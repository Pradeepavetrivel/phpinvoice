<?php
$id = $_GET['id'];
// print_r($your_date);
$url ='https://creator.zoho.com/api/json/invoicegenerator/view/Invoice_form_Report?authtoken=30d1170029c99d66392a3e47192995ba&scope=creatorapi&zc_ownername=rubenaorborc&raw=true&criteria=(ID=='.$id.')';
// print_r($url);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$response = curl_exec($ch);
// print_r($response);
// $invoice_data=$_GET['$response'];
$invoice_data = json_decode($response)->Invoice_form[0];
$payable_to =$invoice_data->Payable_to;
$grand_total=$invoice_data->Grand_Total;
$grand_total_price = str_replace('$', 'Rs.', $grand_total);
$submission_Date=$invoice_data->Submission_Date;
$formatted_date = date("d/m/y", strtotime($submission_Date));
// print_r($formatted_date);
$subtotal = $invoice_data->Subtotal;
$sub_total = str_replace('$', 'Rs.', $subtotal);
// $invoice_id=$invoice_data->Invoice_Id;
$want_to_remove_gst=$invoice_data->Want_to_remove_GST;
// print_r($want_to_remove_gst);
$invoice_type=$invoice_data->Invoice_Type;
$select_your_gst=$invoice_data->Select_Your_GST;
$igstAmount = '';
$cgstAmount = '';
$sgstAmount = '';
if($select_your_gst == 'IGST'){

  $igstAmount = $invoice_data->IGST_18;
}else{
  $cgstAmount=$invoice_data->CGST_9;
  $sgstAmount=$invoice_data->SGST_9;
}
$discount = $invoice_data->Discount;
// print_r($discount);
$total = $invoice_data->Total;
// print_r($total);
// if($discount == '0'){
//   $discount = hide;
// }
$invoice_for=$invoice_data->Invoice_for;
$invoice=$invoice_data->Invoice;
$project_name=$invoice_data->Project_Name;
$due_date=$invoice_data->Due_date;
$formatted_duedate = date("d/m/y", strtotime($due_date));
// print_r($invoice_data);
$sfurl='https://creator.zoho.com/api/json/invoicegenerator/view/Invoice_Subform_Report?authtoken=30d1170029c99d66392a3e47192995ba&scope=creatorapi&zc_ownername=rubenaorborc&raw=true&criteria=(Invoice=='.$id.')';
$sfch = curl_init();
curl_setopt($sfch, CURLOPT_URL, $sfurl);
curl_setopt($sfch, CURLOPT_POST, 0);
curl_setopt($sfch, CURLOPT_RETURNTRANSFER, 1);
$sfresponse = curl_exec($sfch);
$subform_data = json_decode($sfresponse)->Invoice_Subform;
$subformDataArrayReverse = array_reverse($subform_data);

foreach ($subformDataArrayReverse as $key => $value) {
$s_no=$subformDataArrayReverse[$key]->S_no;
$description =$subformDataArrayReverse[$key]->Description;
$hrs =$subformDataArrayReverse[$key]->Hrs;
$unit_price=$subformDataArrayReverse[$key]->Unit_Price;
$price = str_replace('$', '', $unit_price);
$total_price =$subformDataArrayReverse[$key]->Total_Price;
$totalprice = str_replace('$', '', $total_price);
}
// print_r($subform_data);
?>


<!DOCTYPE html>
<html>
  <head>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
      th, td 
      {
        padding: 8px;
        text-align: left;
      }
      table
      {
        border-collapse: collapse;
      }
      
      table.t01 tr:nth-child(odd)
      {
       background-color:#fff;
      }
      
    /*  table.t01
      {
        width:180px;
      }*/
      #main-container
      {
        padding-right:50px;
        padding-left:50px;
        padding-top:1px;
        padding-bottom:17px;

      }
      .border
      {
        border: 10px;
         
      }
      table.t01 tr:nth-child(even) 
      {
        background-color:#C5E3BF!important;
        
      }
      .box
      {
        background-color:#C5E3BF !important;
        height: 54px;
        width: 985px;  
        overflow-y: hidden;
        color: #009C41 !important;
        padding-bottom: 93px;
        -webkit-print-color-adjust:exact; 
      }
      .heading_color
      {
       color:  #009C41 !important;
       width:75%; 
      }
      .image_size
      {
        width:40%;
      }
      .gst_style
      {
        margin-right:-223px;
        text-align: right;
        margin-top: 23px;
        margin-left:-299px;
        font-weight:900;
        color: #009C41;
      }
      .font_color
      {
        color:blue;
      }
     .heading_color
      {
       text-align:center;
       color:  #00692c;
      }
      .grand_total{
        color:  #009C41; 
        font-size: 21px;
      }
      .grand_total_amount{
        color:  #009C41; 
        font-size: 21px;
      }
      .sub_total{
        color:blue; 
        font-size:21px;
      }
      .sub_total_amount{
        color:black; 
        font-size:21px;
      }
      @media{
      .grand_total{
      color:  #009C41;
          font-size: 19px;
      }
      .grand_total_amount{
        color: #009C41; 
        font-size:19px;
      }
      .sub_total_amount{
        color:black; 
        font-size:19px;
      }
      .sub_total{
      color:blue;
          font-size:19px;
      }
      }
     </style>
  </head>
  <body>
    <div id="main-container"><br>
      <div style="border-color:  #009C41; border-style:thin" class="card p-3">
         <div class="row">
              <div class="col-md-10">
                 <img class="image_size" src="download.png"><br><br>
                 <p> #340 B, Shyamala Towers, 3rd Floor,#136 Arcot Rd, Vadapalani,<br> Chennai, Tamil Nadu 600093.</p>
              </div>
               <div class="col-md-5 gst_style">
                <p>GST Ref No:33AAMCA0969R</p>
              </div>
          </div>
         <div class="box">
          <b><h2 style="font-size:50px;font-weight:700;"><?php echo $invoice_type?></h2></b><br>
          <p style="font-size:19px;margin-top:-29px;"><b>Submitted on <?php echo 
          $formatted_date?></p></b>
        </div>
        <br>
        <table style="width:100%;table-layout:fixed; height:50%" class="table table-bordered">
          <tr>
            <th class="heading_color">
              Invoice for
            </th>
            <th class="heading_color">
              Payable to
            </th>
            <th class="heading_color">
              Invoice #
            </th>
            <th class="heading_color">
              Project Name
            </th>
            <th class="heading_color">
              Due date</b>
            </th>
          </tr>
          <tr>
            <td style="text-align:center;"><?php echo $invoice_for?></td>
            <td style="text-align:center;"><?php echo $payable_to?></td>
            <td style="text-align:center;"><?php echo $invoice?></td>
            <td style="text-align:center;"><?php echo $project_name?></td>
            <td style="text-align:center;"><?php echo $formatted_duedate?></td>
          </tr>
        </table>
        <hr>
        <table class="t01 table-bordered" style="border-collapse:collapse;width:100%">
          <tr class="font_color">
            <th style="width:8% !important;text-align:left;">S no</th>
            <th style="text-align:center;width:54% !important;">Description</th>
            <th style="width:5% !important;text-align:left;">Hrs</th>
            <th style="width:15% !important;text-align:left;">Unit price</th>
            <th style="width:18% !important;text-align:left;">Total price</th>
          </tr>
          <?php foreach ($subformDataArrayReverse as $key => $value) {?>
           <tr>
            <td style="text-align:left;"><?php echo $subformDataArrayReverse[$key]->S_no;?></td>
            <td style="text-align:left;"><?php echo $subformDataArrayReverse[$key]->Description;?></td>
            <td style="text-align:left;"><?php echo $subformDataArrayReverse[$key]->Hrs;?></td>
            <td style="text-align:left;"><?php echo str_replace('$', 'Rs.', $subformDataArrayReverse[$key]->Unit_Price);?></td>
            <td style="text-align:left;"><?php echo str_replace('$', 'Rs.',  $subformDataArrayReverse[$key]->Total_Price);?></td>
          </tr>
          <?php }?>
         <tr style="background-color:#FFF!important;"><td colspan="5" style="border:none!important;"></td></tr>
          <tr style="background-color:#FFF!important;"><td colspan="5" style="border:none!important;"></td></tr>
          <tr style="background-color:#FFF!important;">

          <?php if($invoice_type == 'Tax Invoice'){ ?>

           <td colspan="3"><b style="color: #009C41;font-size:21px;font-family:bold;margin-left:-3px;">Bank details</b></td>
           <?php }else{?>
              <td colspan="3"></td>>
            <?php }?>
            <td style="text-align: right;"><b class="sub_total" style="">Subtotal</b></td>
            <td style="text-align: left;"><b class="sub_total_amount" style=""><?php echo $sub_total?></b></td>
          </tr>
          <tr style="background-color:#FFF!important;">
            <?php if($invoice_type == 'Tax Invoice'){ ?>
            <td colspan="3" style="padding:5px;">Bank Name: Citi Bank.<br>
            Bank Account No: 0276741446.<br>
            Account holder Name: AORBORC TECHNOLOGIES PVT LTD.<br>
            IFSC Code: CITI0000003.</td>
            <?php }else{?>
              <td colspan="3" style="padding:5px;"></td>>
            <?php }?>

            <?php if ($discount == '0') {?>
            
            <?php }else{?>
            <!-- <td colspan="3"> -->
            <td style="text-align: right;"><b style="color:blue;">Discount</b></td>
            <td style="text-align: left;"><b style="color:black"><?php echo str_replace('$', 'Rs.', $discount);?></b></td> 
            <?php }?>
          </tr>
          <tr>

          <?php if($want_to_remove_gst!='false'){?>
          
            <?php if ($select_your_gst == 'GST') {?>
             <br>
             <td colspan="3"> 
             <td style="text-align:right; Submitted on 01/01/07;"><b style="color:blue;margin-left: 34px;">CGST-9%<br><br><b style="color:blue;margin-left: 34px;">SGST-9%</b></td><br>
             <td style="text-align: left;"><b style="color:black;"><?php echo str_replace('$','Rs.', $cgstAmount);?><br><br><b style="color:black;"><?php echo str_replace('$', 'Rs.', $sgstAmount);?></b></td>
            <?php }else{?>
              <td colspan="3"> 
              <td style="text-align: right;"><b style="color:blue;">IGST-18%</b></td>
              <td style="text-align: left;"><b style="color:black"><?php echo str_replace('$', 'Rs.', $igstAmount);?></b></td>
            <?php }?>

          <?php }?>

          </tr>
        
          <tr style="background-color:#C5E3BF">
            <td style="border:none!important;"></td>
            <td colspan="3" style="text-align:right;border:none!important;"><b class="grand_total" style="">Grand Total</b></td>
            <td style="text-align:left;border:none!important;"><b class="grand_total_amount" style=""><?php echo $grand_total_price?></b></td>
          </tr>
        </table><br>
        <b style="color:#009C41; text-align:center; font-style:italic; font-size:25px;">THANKS FOR YOUR BUSINESS<br>*****</b>
      </div>
      </div>
    </div>
  </body>
</html>