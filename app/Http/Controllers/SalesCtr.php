<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\ProductMaintenance;
use App\SupplierMaintenance;
use Illuminate\Http\Request;

class SalesCtr extends Controller
{
    private $table_prod = "tblproduct";
    private $table_cat = "tblcategory";
    private $table_suplr = "tblsupplier";

    public function index()
    {
        //session()->forget('cart');
        return view('/sales/cashiering');
   
    }

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

    

    public function search($search_key)
    {
        if($search_key){
            $product = DB::table($this->table_prod)
            ->select("*", DB::raw('CONCAT(tblproduct._prefix, tblproduct.id) as productCode'))
            ->leftJoin($this->table_suplr, $this->table_suplr . '.id', '=', $this->table_prod . '.supplierID')
            ->leftJoin($this->table_cat, $this->table_cat . '.id', '=', $this->table_prod . '.categoryID')
            ->where('tblproduct.id', 'LIKE', '%'.$search_key.'%')
            ->orWhere('description', 'LIKE', '%'.$search_key.'%')
            ->get();

            return $product;
        }
    
       
    }

    public function addToCart(){
            $product_code = Input::get('product_code');
            $description = Input::get('description');
            $qty_order = Input::get('qty_order');
            $price = Input::get('price');
            $total = Input::get('total');

            $cart = session()->get('cart');
            if(!$cart) {
                $cart = [
                    $product_code => [
                            "description" => $description,
                            "qty" => $qty_order,
                            "price" => $price,   
                            "total" => $total,
                        ]
                ];
                
                session()->put('cart', $cart);
                return redirect()->back()->with('success', 'Product added to cart successfully!');
            }
 
            if(isset($cart[$product_code])) {
                $cart[$product_code]['qty'] += $qty_order;
                session()->put('cart', $cart);
                return redirect()->back()->with('success', 'Product added to cart successfully!');
            }
            
            $cart[$product_code] = [
        
                "description" => $description,
                "qty" => $qty_order,
                "price" => $price,   
                "total" => $total
            ];
        
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Product added to cart successfully!');
    }
}
