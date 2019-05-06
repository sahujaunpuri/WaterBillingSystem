<!DOCTYPE html>
<html>
<head>
  <title>Product History</title>
  <style>
    body {
      font-family: 'Segoe UI',sans-serif;
      font-size: 12px;
    }
    table, th, td { border-color: white; }
    tr { border-bottom: none !important; }

    .report-header {
      font-size: 22px;
    }
        .right-align{
            text-align: right;
        }
        @media print {
      @page { margin: 0; size: landscape; }
      body { margin: 1.0cm; }
}
  </style>
  <script>
    (function(){
      window.print();
    })();
  </script>
</head>
<body>
       <table width="100%">
        <tr>
            <td width="10%"><img src="<?php echo base_url().$company_info->logo_path; ?>" style="height: 90px; width: 120px; text-align: left;"></td>
            <td width="90%" class="">
                <span style="font-size: 20px;" class="report-header"><strong><?php echo $company_info->company_name; ?></strong></span><br>
                <span><?php echo $company_info->company_address; ?></span><br>
                <span><?php echo $company_info->landline.'/'.$company_info->mobile_no; ?></span><br>
                <span><?php echo $company_info->email_address; ?></span>
            </td>
        </tr>
    </table><hr>
    <div>
        <h3><strong>Stock Card / Bin Card <b>(Retail)</b></strong></h3>
    </div>
<b>Unit of Measurement :</b> <?php echo $info[0]->child_unit_name?><br><br>


<table style="width: 100%" class="table table-striped">
    <tr>
        <td style="width: 15%;" class="class-title">Product Code</td>
        <td style="width: 35%;" id="product_code"><?php echo $info[0]->product_code?></td>
        <td  style="width: 15%;" class="class-title">Purchase Cost</td>
        <td  style="width: 35%;" id="purchase_cost"><?php echo number_format((number_format($info[0]->purchase_cost,2) / number_format($info[0]->child_unit_desc)),2)  ?></td>
    </tr>
    <tr>
        <td style="width: 15%;" class="class-title">Product Description</td>
        <td style="width: 35%;" id="product_desc"><?php echo $info[0]->product_desc?></td>

        <td  style="width: 15%;" class="class-title">Suggested Retail Price</td>
        <td  style="width: 35%;" id="sale_price"><?php echo number_format((number_format($info[0]->sale_price,2) / number_format($info[0]->child_unit_desc)),2)  ?></td>
    </tr>
</table>
   <center>
       <table width="100%"  style="border-collapse: collapse;">
           <thead>
                <tr class="">
                    <td style="border: 1px solid lightgrey;padding: 5px;"><b>Txn Date</b></td>
                    <td style="border: 1px solid lightgrey;padding: 5px;"><b>Reference</b></td>
                    <td style="border: 1px solid lightgrey;padding: 5px;text-align: right;"><b>In</b></td>
                    <td style="border: 1px solid lightgrey;padding: 5px;text-align: right;"><b>Out</b></td>
                    <td style="border: 1px solid lightgrey;padding: 5px;text-align: right;"><b>Balance</b></td>
                    <td style="border: 1px solid lightgrey;padding: 5px;"><b>Department</b></td>
                    <td style="border: 1px solid lightgrey;padding: 5px;"><b>Remarks</b></td>

                </tr>

           </thead>
           <tbody>
                <?php if(count($products_parent)==0){ ?>
                    <tr>
                        <td colspan="9" style="border: 1px solid lightgrey;padding: 10px;" align="center">No transaction found.</td>
                    </tr>
                <?php } ?>

                <?php foreach($products_parent as $product){ ?>
               <tr>
                   <td style="border: 1px solid lightgrey;padding: 5px;"><?php echo date("M d, Y",strtotime($product->txn_date)); ?></td>
                   <td style="border: 1px solid lightgrey;padding: 5px;"><?php echo $product->ref_no; ?></td>
                   <td style="border: 1px solid lightgrey;padding: 5px;text-align: right;"><?php echo number_format($product->child_in_qty,2); ?></td>
                   <td style="border: 1px solid lightgrey;padding: 5px;text-align: right;"><?php echo number_format($product->child_out_qty,2); ?></td>
                   <td style="border: 1px solid lightgrey;padding: 5px;text-align: right;"><?php echo number_format($product->child_balance,2); ?></td>
                   <td style="border: 1px solid lightgrey;padding: 5px;text-align: left;"><?php echo $product->department_name ?></td>
                   <td style="border: 1px solid lightgrey;padding: 5px;text-align: left;"><?php echo $product->remarks; ?></td>
               </tr>
                <?php } ?>
           </tbody>
       </table>
   </center>

<style>
  tr {
      border: none!important;
  }

/*  tr:nth-child(even){
      background: #414141 !important;
      border: none!important;
  }

  tr:hover {
      transition: .4s;
      background: #414141 !important;
      color: white;
  }

  tr:hover .btn {
      border-color: #494949!important;
      border-radius: 0!important;
      -webkit-box-shadow: 0px 0px 5px 1px rgba(0,0,0,0.75);
      -moz-box-shadow: 0px 0px 5px 1px rgba(0,0,0,0.75);
      box-shadow: 0px 0px 5px 1px rgba(0,0,0,0.75);
  }*/
</style>



















<style>
  tr {
      border: none!important;
  }

</style>

</body>
</html>
















