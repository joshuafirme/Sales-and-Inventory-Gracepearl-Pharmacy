<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\ProductMaintenance;
use App\SupplierMaintenance;
use Illuminate\Http\Request;
use PDF;

class ProductMaintenanceCtr extends Controller
{
    private $table_prod = "tblproduct";
    private $table_cat = "tblcategory";
    private $table_suplr = "tblsupplier";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $category_param = $request->category;
        $product = $this->getAllProduct(); 
        $category = DB::table($this->table_cat)->get();
        $suplr = DB::table($this->table_suplr)->get();
        
        if(request()->ajax())
        {
            if($request->category){
                return datatables()->of($this->filterByCategory($request->category))
                ->addColumn('action', function($product){
                    $button = ' <a class="btn" href="/maintenance/product/edit/'. $product->id .'"><i class="fa fa-edit"></i></a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<a class="btn" id="delete-product" delete-id="'. $product->id .'"><i class="fa fa-trash"></i></a>';
                    return $button;
                })
                ->rawColumns(['action' => 'action'])
                ->make(true);
            }
            else{ 
               
                return datatables()->of($product)
                ->addColumn('action', function($data){
                    $button = ' <a class="btn" href="/maintenance/product/edit/'. $data->id .'"><i class="fa fa-edit"></i></a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<a class="btn" id="delete-product" delete-id="'. $data->id .'"><i class="fa fa-trash"></i></a>';
                    return $button;
                })
                ->rawColumns(['action' => 'action'])
                ->make(true);
            }
           
        }
        return view('maintenance/product/product', ['product' => $product, 'category' => $category, 'suplr' => $suplr]);
    }

    public function getAllProduct(){
        $product = DB::table($this->table_prod)
        ->select("*", DB::raw('tblproduct.id AS productCode'))
        ->leftJoin($this->table_suplr, $this->table_suplr . '.id', '=', $this->table_prod . '.supplierID')
        ->leftJoin($this->table_cat, $this->table_cat . '.id', '=', $this->table_prod . '.categoryID')
        ->get();

        return $product;
    }

    public function filterByCategory($category_param){
        $product = DB::table($this->table_prod)
        ->select("*", DB::raw('tblproduct.id AS productCode'))
        ->leftJoin($this->table_suplr, $this->table_suplr . '.id', '=', $this->table_prod . '.supplierID')
        ->leftJoin($this->table_cat, $this->table_cat . '.id', '=', $this->table_prod . '.categoryID')
        ->where('categoryID', $category_param)
        ->get();

        return $product;
    }

    

    public function edit($id)
    {
        $product = DB::table($this->table_prod)
            ->select("*", DB::raw('tblproduct.id AS productCode'))
            ->leftJoin($this->table_suplr, $this->table_suplr . '.id', '=', $this->table_prod . '.supplierID')
            ->leftJoin($this->table_cat, $this->table_cat . '.id', '=', $this->table_prod . '.categoryID')
            ->where('tblproduct.id', $id)
            ->get();
        
            $category = DB::table($this->table_cat)->get();
            $suplr = DB::table($this->table_suplr)->get();

            return view('maintenance/product/product_update', ['product' => $product, 'category' => $category, 'suplr' => $suplr]);
    }

  


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = new ProductMaintenance;

        $product->_prefix = $this->getPrefix();
        $product->description = $request->input('description');
        $product->categoryID = $request->input('categoryID');
        $product->supplierID = $request->input('supplierID');
        $product->qty = $request->input('qty');
        $product->re_order = $request->input('re_order');
        $product->orig_price = $request->input('orig_price');
        $product->selling_price = $request->get('selling_price');
        $product->exp_date = $request->input('exp_date');

        if(request()->hasFile('image')){
            request()->validate([
                'image' => 'file|image|max:5000',
            ]);
        }

        $product->save();
        $this->storeImage($product);

        return redirect('/maintenance/product')->with('success', 'Data Saved');
    }

    public function storeImage($product){
        if(request()->has('image')){
            $product->update([
                'image' => request()->image->store('uploads', 'public'),
            ]);
        }
    }

    public function getPrefix()
    {
        $prefix = 'P'.date('my').'-';
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


    public function search(Request $request)
    {
        $search_key = $request->input('search-product');
        
        $product = DB::table($this->table_prod)
        ->select("*", DB::raw('tblproduct.id AS productCode'))
        ->leftJoin($this->table_suplr, $this->table_suplr . '.id', '=', $this->table_prod . '.supplierID')
        ->leftJoin($this->table_cat, $this->table_cat . '.id', '=', $this->table_prod . '.categoryID')
        ->where('tblproduct.id', 'LIKE', '%'.$search_key.'%')
        ->orWhere('description', 'LIKE', '%'.$search_key.'%')
        ->paginate(3);

         $category = DB::table($this->table_cat)->get();
         $suplr = DB::table($this->table_suplr)->get();
         
        return view('maintenance/product/product', ['product' => $product, 'category' => $category, 'suplr' => $suplr]);
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
        ->select("*", DB::raw('tblproduct.id AS productCode'))
            ->leftJoin($this->table_suplr, $this->table_suplr . '.id', '=', $this->table_prod . '.supplierID')
            ->leftJoin($this->table_cat, $this->table_cat . '.id', '=', $this->table_prod . '.categoryID')
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
                               
        <td style="border: 1px solid; padding:10px;">'. $data->_prefix . str_pad($data->productCode,6,'0',STR_PAD_LEFT) .'</td>
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
        $filter_category = Input::get('filter_category');
        
        return $filter_category;
    }

    public function getDate(){
        $date = date('m-d-yy');
        return $date;
    }
}
