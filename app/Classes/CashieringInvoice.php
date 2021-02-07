<?php 

namespace App\Classes;
use Illuminate\Support\Facades\DB;

class CashieringInvoice {
    
    public function getVAT($total_due){
        return $total_due * 0.12;
    }

    public function getNetOfVAT($total_due){
        return $total_due - ($total_due * 0.12);
    }

    public function getAmountDue($total_due){
        return $total_due - $this->getVAT($total_due);
    }


    public function getSalesInvoice($product, $discount){

        $output = '
        <style>
        @page { margin: 10px; }
        body{ font-family: sans-serif; }
        th{
            border: 1px solid;
        }
        td{
            font-size: 14px;
            border: 1px solid;
            padding-right: 2px;
            padding-left: 2px;
        }

        .p-name{
            text-align:center;
            margin-bottom:5px;
        }

        .address{
            text-align:center;
            margin-top:0px;
        }

        .p-details{
            margin:0px;
        }

        .ar{
            text-align:right;
        }

        .al{
            text-left:right;
        }

        .align-text{
            text-align:center;
        }

        .align-text td{
            text-align:center;
        }

        .w td{
            width:20px;
        }

   

        .b-text .line{
            margin-bottom:0px;
        }

        .b-text .b-label{
            font-size:12px;
            margin-top:-7px;
            margin-right:12px;
            font-style:italic;
        }

        .peso-sign {
            content: "\20B1";
          }


         </style>
        <div style="width:100%">
        
        <h1 class="p-name">GRACE PEARL PHARMACY</h1>
        <p class="p-details address">F. Alix St., Cor. F. Castro St., Brgy III, Nasugbu, Batangas</p>
        <p class="p-details address">MARIA ALONA S. CALDERON - Prop.</p>
        <p class="p-details address">VAT Reg: TIN 912-068-468-002</p>
        <h3 style="text-align:center;">RECEIPT</h3>

     
    
        <table width="100%" style="border-collapse:collapse; border: 1px solid;">                
        <thead>
          <tr>
              <th>Qty</th>  
              <th>Unit</th>    
              <th>Description</th>   
              <th>Unit Price</th>      
              <th>Amount</th>   
      </thead>
      <tbody>
        ';
        $total_amount = 0;
        $sub_total = 0;
        if($product){
            foreach ($product as $data) {
            
                $sub_total = $data->qty * $data->selling_price;
                $total_amount += $sub_total;
            
                $output .='
            <tr class="align-text">                             
                <td>'. $data->qty .'</td>  
                <td>'. $data->unit .'</td>  
                <td>'. $data->description .'</td>
                <td>'. number_format($data->selling_price,2,'.',',') .'</td>   
                <td>'. number_format($data->amount,2,'.',',') .'</td>    
            </tr>

          

              ';
            
            } 
        }
        else{
            echo "No data found";
        }
        
          
     $output .='
        <tr>
            <td style="text-align:right;" colspan="4">Total Sales (VAT Inclusive) </td>
            <td class="align-text">'. number_format($total_amount,2,'.',',') .' PhP</td>
        </tr>

        <tr>
            <td class="ar" colspan="4">Less: VAT </td>
            <td class="align-text">'. number_format($this->getVAT($total_amount),2,'.',',') .'</td>
        </tr>

        <tr >
            <td class="ar" colspan="2">VATable Sales </td>
            <td ></td>
            <td class="ar">Amount: Net of VAT</td>
            <td class="align-text">'. number_format($this->getNetOfVAT($total_amount),2,'.',',') .'</td>
        </tr>

        <tr>
            <td class="ar" colspan="2">VAT-Exempt Sales</td>
            <td ></td>
            <td class="ar">Less:SC/PWD Discount</td>
            <td class="align-text">'. $discount .'</td>
        </tr>

        <tr>
            <td class="ar" colspan="2">Zero Rated Sales</td>
            <td ></td>
            <td class="ar">Amount Due</td>
            <td class="align-text">'. number_format($this->getAmountDue($total_amount),2,'.',',') .' PhP</td>
        </tr>

        <tr>
            <td class="ar" colspan="2">VAT Amount</td>
            <td ></td>
            <td class="ar">Add: VAT</td>
            <td class="align-text">'. number_format($this->getVAT($total_amount),2,'.',',') .'</td>
        </tr>

        <tr>
            <td style="text-align:right;" colspan="4">Total Amount Due </td>
            <td class="align-text">'. number_format(($total_amount - $discount),2,'.',',')  .' PhP</td>
        </tr>

        </tbody>
    </table>
    
    <div class="b-text">
        <p class="ar line">----------------------------------------</p>
        <p class="ar b-label">Cashier/Authorized Representative</p>
    </div>
</div>';
        DB::table('tblcashiering')->delete();
        return $output;
    }


}