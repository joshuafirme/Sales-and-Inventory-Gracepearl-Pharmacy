<?php
namespace App\Http\Controllers\Maintenance;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Input;
use App\ProductMaintenance;
use Illuminate\Http\Request;
use PDF;
use Storage;
use App\Classes\UserAccessRights;
use App\Classes\AuditTrailHelper;
use App\Model\Maintenance\Product;

class ProductMaintenanceCtr extends Controller
{
    private $table_prod = "tblproduct";
    private $table_exp = "tblexpiration";
    private $table_cat = "tblcategory";
    private $table_suplr = "tblsupplier";
    private $table_unit = "tblunit";
    private $table_emp = "tblemployee";
    private $module = "Maintenance";

    public function index(Request $request)
    {
        $rights = new UserAccessRights;

        if(!($rights->isUserAuthorize($this->module)))
        {
            $rights->notAuthMessage();
        }

        $category_param = $request->category;
        $product = $this->getAllProduct(); 
        $unit = DB::table($this->table_unit)->get();
        $category = DB::table($this->table_cat)->get();
        $suplr = DB::table($this->table_suplr)->get();
        
        if(request()->ajax())
        {
            if($request->category){
                return datatables()->of($this->filterByCategory($request->category))
                ->addColumn('action', function($product){
                   // <button class="btn btn-primary btn-sm" "><span class='fa fa-plus'></span> Add Category</button> 
                    $button = ' <a class="btn btn-sm btn-primary" id="btn-edit-product-maintenance" product-code="'. $product->id .'" 
                    data-toggle="modal" data-target="#editProductModal"><i class="fa fa-edit"></i></a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<a class="btn btn-sm" id="delete-product" delete-id="'. $product->id .'"><i style="color:#DC3545;" class="fa fa-trash"></i></a>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
            }
            else{ 
               
                return datatables()->of($product)
                ->addColumn('action', function($product){
                    $button = ' <a class="btn btn-sm" id="btn-edit-product-maintenance" product-code="'. $product->id .'"
                    data-toggle="modal" data-target="#editProductModal" ><i class="fa fa-edit"></i></a>';
                   $button .= '&nbsp;&nbsp;';
                   $button .= '<a class="btn btn-sm" id="delete-product" delete-id="'. $product->id .'"><i  style="color:#DC3545;" class="fa fa-trash"></i></a>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
            }
           
        }
        return view('maintenance/product/product', ['product' => $product, 'unit' => $unit, 'category' => $category, 'suplr' => $suplr]);
    }

    public function getAllProduct(){
        $product = new Product;
        return $product->getAllProduct();
    }

    public function filterByCategory($category_param){
        $product = new Product;
        return $product->filterByCategory($category_param);
    }

    

    public function show($productCode)
    {
        $product = new Product;
        return $product->show($productCode);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $audit = new AuditTrailHelper;
        $audit->recordAction($this->module, 'Add product');
        
        $product = new ProductMaintenance;

        $product->_prefix = $this->getPrefix();
        $product->description = $request->input('description');
        $product->unitID = $request->input('unitID');
        $product->categoryID = $request->input('category_name');
        $product->supplierID = $request->input('supplier_name');
        $product->qty = $request->input('qty');
        $product->re_order = $request->input('re_order');
        $product->orig_price = $request->input('orig_price');
        $product->selling_price = floor($request->get('selling_price')*100)/100;
        $product->exp_date = $request->input('exp_date');
        $product->with_prescription = $request->input('with_prescription');
        $product->highlights = $request->input('highlights');

        $product->save();

        if(request()->hasFile('image')){
            request()->validate([
                'image' => 'file|image|max:5000',
            ]);
        }
        $this->storeImage($product->id);
        $this->storeExpiration($product->_prefix.str_pad($product->id, 4, '0', STR_PAD_LEFT), $product->qty, $product->exp_date);

        return redirect('/maintenance/product')->with('success', 'Data Saved');
    }

    public function storeExpiration($product_code, $qty, $exp_date){
        DB::table('tblexpiration')->insert(
            [
                'product_code' => $product_code,
                'qty' => $qty,
                'exp_date' => $exp_date
            ]
        );
    }

    public function storeHighlights($id){
        DB::table($this->table_prod)
        ->where('id', $id)
        ->update();
    }

    public function storeImage($product_code){
      
        if(request()->has('image')){
            ProductMaintenance::where('id', $product_code)
       
            ->update([
                'image' => request()->image->store('uploads', 'public'),
            ]);
        }
    }

    public function updateProduct(Request $request)
    {
        $audit = new AuditTrailHelper;
        $audit->recordAction($this->module, 'Update product');
        $product = new ProductMaintenance;
        $product->id = $request->input('product_code_hidden');
        $product->description = $request->input('edit_description');
        $product->unitID = $request->input('edit_unit');
        $product->categoryID = $request->input('edit_category_name');
        $product->supplierID = $request->input('edit_supplier_name');
        $product->qty = $request->input('edit_qty');
        $product->re_order = $request->input('edit_re_order');
        $product->orig_price = $request->input('edit_orig_price');
        $product->selling_price = $request->input('edit_selling_price');
        $product->exp_date = $request->input('edit_exp_date');
        $product->with_prescription = $request->input('edit_with_prescription');
        $product->highlights = $request->input('edit_highlights');

        
        ProductMaintenance::where('id', $product->id)
          ->update([
              'description' => $product->description,
              'unitID' => $product->unitID,
              'categoryID' => $product->categoryID,
              'supplierID' => $product->supplierID,
              'qty' => $product->qty,
              're_order' => $product->re_order,
              'orig_price' => $product->orig_price,
              'selling_price' => $product->selling_price,
              'exp_date' => $product->exp_date,
              'with_prescription' => $product->with_prescription,
              'highlights' => $product->highlights
               ]);

            if(request()->hasFile('image')){
                request()->validate([
                    'image' => 'file|image|max:5000',
                ]);
            }
            
            DB::table($this->table_exp)
            ->where('id', $product->id)
            ->update(['exp_date' => $product->exp_date]);
 
            $this->storeImage($product->id_exp);

        return redirect('/maintenance/product')->with('success', 'Product was successfully updated');
     //   Storage::disk('local')->put($image, 'Contents');
     //   $img_path = substr($image, 12);
     //   $this->updateImage($product_code,$img_path);
           
    }

    public function updateImage($product_code, $img_path){
        
            DB::table($this->table_prod)
            ->where('id', $product_code)
            ->update(['image' => $img_path]);
 
        
    }

    

    public function getPrefix()
    {
        $prefix = 'P-'.date('m');
        return $prefix;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $audit = new AuditTrailHelper;
        $audit->recordAction($this->module, 'Delete product');
  
        $product_code = Input::input('product_code');
        $product = DB::table($this->table_exp)->where('id', $id)->delete();
        return $product;
    }

    public function pdf($filter_category){

        $product_data = $this->getAllProductData($filter_category);
        $output = $this->convertProductDataToHTML($product_data);

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($output);
        $pdf->setPaper('A4', 'landscape');

        return $pdf->stream($product_data[0]->created_at);
    }


    public function getAllProductData($category_param)
    {
        $product = DB::table($this->table_prod.' AS P')
        ->select("*", DB::raw('CONCAT(P._prefix, P.id) AS productCode'))
        ->leftJoin($this->table_suplr.' AS S', 'S.id', '=', 'P.supplierID')
        ->leftJoin($this->table_cat.' AS C', 'C.id', '=', 'P.categoryID')
        ->leftJoin($this->table_unit.' AS U', 'U.id', '=', 'P.unitID')
        ->where('category_name',  $category_param)
        ->get();

        return $product;
    }

    public function convertProductDataToHTML($product_data){
        $output = '
        <div style="width:100%">
        <p style="text-align:right;">Date: '. $this->getDate() .'</p>
        <h2 style="text-align:center;">Product List</h2>
        <table width="100%" style="border-collapse:collapse; border: 1px solid;">
                      
        <thead>
          <tr>
              <th style="border: 1px solid;">Product Code</th>
              <th style="border: 1px solid;">Description</th>
              <th style="border: 1px solid;">Quantity</th>
              <th style="border: 1px solid;">Re-Order Point</th>
              <th style="border: 1px solid;">Supplier</th>
              <th style="border: 1px solid;">Category</th>
              <th style="border: 1px solid;">Original Price</th>
              <th style="border: 1px solid;">Selling Price</th>
          </tr>
      </thead>
      <tbody>
        ';
        
        foreach ($product_data as $data) {
        $output .='
        <tr>    
                               
        <td style="border: 1px solid; padding:10px;">'. $data->productCode .'</td>
        <td style="border: 1px solid; padding:10px;">'. $data->description .'</td>
        <td style="border: 1px solid; padding:10px;">'. $data->qty .'</td>
        <td style="border: 1px solid; padding:10px;">'. $data->re_order .'</td>      
        <td style="border: 1px solid; padding:10px;">'. $data->supplierName .'</td>   
        <td style="border: 1px solid; padding:10px;">'. $data->category_name .'</td>      
        <td style="border: 1px solid; padding:10px;">'. $data->orig_price .'</td>      
        <td style="border: 1px solid; padding:10px;">'. $data->selling_price .'</td>           
      </tr>';
    }
          
     $output .='
       </tbody>
      </table>
      </div>';

        return $output;
    }

    public function getCategoryParam()
    {
        $filter_category = Input::input('filter_category');
        
        return $filter_category;
    }

    public function getDate(){
        $date = date('m-d-yy');
        return $date;
    }
}
