<?php

namespace App\Http\Controllers\Maintenance;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\ShippingAddressMaintenance;
use Illuminate\Support\Facades\Input;
use App\Classes\BrgyAPI;

class ShippingAddressCtr extends Controller
{
   private $tbl_shipping = "tblship_add_maintenance";
   

   public function index(){

      $municipality = $this->getMunicipalityList();

        $s = DB::table($this->tbl_shipping)
        ->select($this->tbl_shipping.'.*')
        ->orderBy('municipality', 'asc')
        ->get();

        if(request()->ajax())
        {
            return datatables()->of($s)
            ->addColumn('action', function($s)
            {
               $button = '<a class="btn btn-sm" id="btn-edit-shipping" edit-id="'. $s->id .'" data-toggle="modal" data-target="#editShippingModal"><i class="fa fa-edit"></i></a>';
               $button .= '&nbsp;&nbsp;';
               $button .= '<a class="btn btn-sm" name="id" id="btn-delete-shipping" delete-id="'. $s->id .'"><i style="color:#DC3545;" class="fa fa-trash"></i></a>';
               if($s->is_active == 0){
                  $button .= '<span class="badge" style="background-color:#337AB7; margin-left:50px; color:#fff;">Inactive</span>';     
               }
               return $button;
            })
            ->addColumn('shipping_fee', function($s)
            {
            if($s->shipping_fee == 0){
               $fee = '<span class="text-success">Free</span';
            }
            else{
               $fee = '<span>'. $s->shipping_fee .'</span';
            }

               return $fee;
            })
            ->rawColumns(['action', 'shipping_fee'])
            ->make(true);
        }

        return view('maintenance/shipping/shipping_add', [
           'municipality' => $municipality
           ]);
   }
   

   public function store(Request $request)
    {    
        // $sam = new ShippingAddressMaintenance;
         $municipality = $request->input('municipality');
         $brgy = $request->input('brgy');
         $shipping_fee = $request->input('shipping-fee');
  
         if($this->isAddressExists($municipality, $brgy))
         {
            return redirect('/maintenance/shippingadd')->with('danger', 'Address is already exists!');
         }

         DB::table('tblship_add_maintenance')
         ->insert([
            'municipality' => $municipality,
            'brgy' => $brgy,
            'shipping_fee' => $shipping_fee,
            'is_active' => 1
         ]);

       //  $sam->save();

        return redirect('/maintenance/shippingadd')->with('success', 'Data Saved');
    }

    public function isAddressExists($municipality, $brgy){
      $data = DB::table('tblship_add_maintenance')
         ->where('municipality', $municipality)
         ->where('brgy', $brgy)
         ->get();

      $res = $data->count() > 0 ? true : false;
      return $res;
   }

   public function getMunicipalityList(){

      $api = new BrgyAPI;
      $client = new \GuzzleHttp\Client();
      $response = $client->get($api->getBrgyAPI());
      $obj = json_decode($response->getBody(), JSON_FORCE_OBJECT);
      $response = $obj['4A']['province_list']['BATANGAS']['municipality_list'];
      return $response;
   
   }

   public function getBrgyList($municipality_name){

      $api = new BrgyAPI;
      $client = new \GuzzleHttp\Client();
      $response = $client->get($api->getBrgyAPI());
      $obj = json_decode($response->getBody(), true);
      $response = $obj['4A']['province_list']['BATANGAS']['municipality_list'][$municipality_name];
      return $response;  

   }

   public function show($id){
      return DB::table('tblship_add_maintenance')
         ->where('id', $id)
         ->get();
   }

   public function update(Request $request){
      $id = $request->input('id_hidden');
      $municipality = $request->input('municipality');
      $brgy = $request->input('brgy');
      $fee = $request->input('shipping-fee');

      DB::table('tblship_add_maintenance')
         ->where('id', $id)
         ->update([
            'municipality' => $municipality,
            'brgy' => $brgy,
            'shipping_fee' =>$fee
         ]);

      return redirect('/maintenance/shippingadd')->with('success', 'Shipping address was successfully updated.');
   }

   public function destroy($id){
      DB::table('tblship_add_maintenance')
      ->where('id', $id)
      ->update([
         'is_active' => 0
      ]);
       return redirect('/maintenance/shippingadd')->with('success', 'Shipping address was successfully inactive.');
   }
}
