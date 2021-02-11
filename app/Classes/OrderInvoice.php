<?php 

namespace App\Classes;
use Session;

class OrderInvoice {

    public function getTotalDue()
    {
        $sub_total = Session::get('order-total-amount');
        $shipping_fee = Session::get('order-shipping-fee');
        $discount = Session::get('order-discount');

        return ($sub_total + $shipping_fee) - $discount;
    }
    
    public function getVAT(){
        return $this->getTotalDue() * 0.12;
    }

    public function getNetOfVAT(){
        return $this->getTotalDue() - ($this->getTotalDue() * 0.12);
    }

    public function getAmountDue(){
        return $this->getTotalDue() - $this->getVAT($this->getTotalDue());
    }

    public function getSalesInvoiceHtml($shipping_info)
    { 
        $output = '
        <!DOCTYPE html>
        <html>
        
        <head>
            <meta charset="UTF-8">
        </head>

        <body>
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
            padding-left: 10px;
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

        .f-courier{
            font-family: monospace, sans-serif;
        }


         </style>


        <div style="width:100%">
        
        <h1 class="p-name">GRACE PEARL PHARMACY</h1>
        <p class="p-details address">F. Alix St., Cor. F. Castro St., Brgy III, Nasugbu, Batangas</p>
        <p class="p-details address">MARIA ALONA S. CALDERON - Prop.</p>
        <p class="p-details address">VAT Reg: TIN 912-068-468-002</p>
        <h3 style="text-align:center;">SALES INVOICE</h3>

     
    
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
        if(session()->get('order')){
            foreach (session()->get('order') as $product_code => $data) {
            
              
            
                $output .='
            <tr class="align-text">                             
                <td>'. $data['qty'] .'</td>  
                <td>'. $data['unit'] .'</td>  
                <td>'. $data['description'] .'</td>
                <td>'. number_format($data['unit_price'],2,'.',',') .'</td>   
                <td>'. number_format($data['amount'],2,'.',',') .'</td>              
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
            <td class="align-text">P '. number_format($this->getTotalDue(),2,'.',',') .'</td>
        </tr>

        <tr>
            <td class="ar" colspan="4">Less: VAT </td>
            <td class="align-text">P '. number_format($this->getVAT(),2,'.',',') .'</td>
        </tr>

        <tr >
            <td class="ar" colspan="2">VATable Sales </td>
            <td ></td>
            <td class="ar">Amount: Net of VAT</td>
            <td class="align-text">P '. number_format($this->getNetOfVAT(),2,'.',',') .'</td>
        </tr>

        <tr>
            <td class="ar" colspan="2">VAT-Exempt Sales</td>
            <td ></td>
            <td class="ar">Less:SC/PWD Discount</td>
            <td class="align-text">P '. Session::get('order-discount') .'</td>
        </tr>

        <tr>
            <td class="ar" colspan="2">Zero Rated Sales</td>
            <td ></td>
            <td class="ar">Amount Due</td>
            <td class="align-text">P '. number_format($this->getAmountDue(),2,'.',',') .'</td>
        </tr>

        <tr>
            <td class="ar" colspan="2">VAT Amount</td>
            <td ></td>
            <td class="ar">Add: VAT</td>
            <td class="align-text">P '. number_format($this->getVAT(),2,'.',',') .'</td>
        </tr>

        <tr>
            <td class="ar" colspan="2"></td>
            <td ></td>
            <td class="ar">Shipping fee</td>
            <td class="align-text">P '. Session::get('order-shipping-fee') .'</td>
        </tr>

        <tr>
            <td style="text-align:right;" colspan="4">Total Amount Due </td>
            <td class="align-text">P '. number_format($this->getTotalDue(),2,'.',',') .'</td>
        </tr>

        </tbody>
    </table>
    
    <div class="b-text">
        <p class="ar line">----------------------------------------</p>
        <p class="ar b-label">Cashier/Authorized Representative</p>
    </div>

    <table cellspacing="0" cellpadding="0" style="border-collapse: collapse; border: 0px solid none;">
        <tr class="f-courier">
            <td>'.$shipping_info->municipality.'</td>
            </tr>
            <tr class="f-courier">
            <td>'.$shipping_info->brgy.'</td>
            </tr>
            <tr class="f-courier">
            <td>'.$shipping_info->flr_bldg_blk.'</td>
            </tr>
            <tr class="f-courier">
            <td>'.$shipping_info->note.'</td>
            </tr>
    </table>

</div>

</body>

</html>';
return $output;
}

}