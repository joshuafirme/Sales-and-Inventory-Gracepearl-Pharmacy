<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Input;
use App\ProductMaintenance;
use App\SupplierMaintenance;
use Illuminate\Http\Request;
use PDF;
use Storage;

class ProductMaintenanceCtr extends Controller
{
    private $table_prod = "tblproduct";
    private $table_cat = "tblcategory";
    private $table_suplr = "tblsupplier";
    private $table_unit = "tblunit";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
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
        $product = DB::table($this->table_prod)
        ->select("tblproduct.*", 
        DB::raw('CONCAT(tblproduct._prefix, tblproduct.id) AS productCode, unit, supplierName, category_name, DATE_FORMAT(exp_date,"%d-%m-%Y") as exp_date'))
        ->leftJoin($this->table_suplr, $this->table_suplr . '.id', '=', $this->table_prod . '.supplierID')
        ->leftJoin($this->table_cat, $this->table_cat . '.id', '=', $this->table_prod . '.categoryID')
        ->leftJoin($this->table_unit, $this->table_unit . '.id', '=', $this->table_prod . '.unitID')
        ->get();

        return $product;
    }

    public function filterByCategory($category_param){
        $product = DB::table($this->table_prod)
        ->select("tblproduct.*", 
        DB::raw('CONCAT(tblproduct._prefix, tblproduct.id) AS productCode, unit, supplierName, category_name, DATE_FORMAT(exp_date,"%d-%m-%Y") as exp_date'))
        ->leftJoin($this->table_suplr, $this->table_suplr . '.id', '=', $this->table_prod . '.supplierID')
        ->leftJoin($this->table_cat, $this->table_cat . '.id', '=', $this->table_prod . '.categoryID')
        ->leftJoin($this->table_unit, $this->table_unit . '.id', '=', $this->table_prod . '.unitID')
        ->where('categoryID', $category_param)
        ->get();

        return $product;
    }

    

    public function show($productCode)
    {
        $product = DB::table($this->table_prod)
            ->select("tblproduct.*", DB::raw('CONCAT(tblproduct._prefix, tblproduct.id) AS productCode, category_name, supplierName, unit, category_name'))
            ->leftJoin($this->table_suplr, $this->table_suplr . '.id', '=', $this->table_prod . '.supplierID')
            ->leftJoin($this->table_cat, $this->table_cat . '.id', '=', $this->table_prod . '.categoryID')
            ->leftJoin($this->table_unit, $this->table_unit . '.id', '=', $this->table_prod . '.unitID')
            ->where('tblproduct.id', $productCode)
            ->get();

            return $product;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $summernote_val = Input::input('summernote_val');
        $product = new ProductMaintenance;

        $product->_prefix = $this->getPrefix();
        $product->description = $request->input('description');
        $product->unitID = $request->input('unitID');
        $product->categoryID = $request->input('category_name');
        $product->supplierID = $request->input('supplier_name');
        $product->qty = $request->input('qty');
        $product->re_order = $request->input('re_order');
        $product->orig_price = $request->input('orig_price');
        $product->selling_price = $request->get('selling_price');
        $product->exp_date = $request->input('exp_date');
        $product->with_prescription = $request->input('with_prescription');
        $product->highlights = $summernote_val;

        $product->save();

        if(request()->hasFile('image')){
            request()->validate([
                'image' => 'file|image|max:5000',
            ]);
        }
        $this->storeImage($product);

        return redirect('/maintenance/product')->with('success', 'Data Saved');
    }

    public function storeHighlights($id){
        DB::table($this->table_prod)
        ->where('id', $id)
        ->update();
    }

    public function storeImage($product){
        if(request()->has('image')){
            $product->update([
                'image' => request()->image->store('uploads', 'public'),
            ]);
        }
    }

    public function updateProduct($product_code)
    {
        $product = new ProductMaintenance;
        $product->desciption = Input::input('description');
        $product->unitID = Input::input('unit');
        $product->categoryID = Input::input('category_name');
        $product->supplierID = Input::input('supplier_name');
        $product->re_order = Input::input('re_order');
        $product->orig_price = Input::input('orig_price');
        $product->selling_price = Input::input('selling_price');
        $product->exp_date = Input::input('exp_date');
        $image = Input::input('img_path');

        DB::update('UPDATE '. $this->table_prod .' 
        SET description = ?,  unitID = ?, categoryID = ?, supplierID = ?, re_order = ?, orig_price = ?, selling_price = ?, exp_date = ?
        WHERE id = ?',
        [
            $product->desciption, 
            $product->unitID, 
            $product->categoryID, 
            $product->supplierID, 
            $product->re_order, 
            $product->orig_price, 
            $product->selling_price, 
            $product->exp_date, 
            $product_code
            ]);

        
        Storage::disk('local')->put($image, 'Contents');
        $img_path = substr($image, 12);
        $this->updateImage($product_code,$img_path);
           
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
        $product = DB::table($this->table_prod)->where('id', $id)->delete();
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
        $product = DB::table($this->table_prod)
        ->select("*", DB::raw('CONCAT(tblproduct._prefix, tblproduct.id) AS productCode'))
            ->leftJoin($this->table_suplr, $this->table_suplr . '.id', '=', $this->table_prod . '.supplierID')
            ->leftJoin($this->table_cat, $this->table_cat . '.id', '=', $this->table_prod . '.categoryID')
            ->leftJoin($this->table_unit, $this->table_unit . '.id', '=', $this->table_prod . '.unitID')
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
