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
        ->paginate(10);

        return view('maintenance/shipping/shipping_add', [
           'shippingAdd' => $s,
           'municipality' => $municipality
           ]);
   }

   public function store(Request $request)
    {    
        $sam = new ShippingAddressMaintenance;
        $sam->municipality = $request->input('municipality');
        $sam->brgy = $request->input('brgy');
        $sam->shipping_fee = $request->input('shipping-fee');
        $sam->save();

        return redirect('/maintenance/shippingadd')->with('success', 'Data Saved');
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
}
