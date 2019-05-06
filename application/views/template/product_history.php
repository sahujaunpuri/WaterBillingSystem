<div class="tab-container tab-top tab-default">
  <ul class="nav nav-tabs">
      <li class="active"><a href="#Bulk_history_<?php echo $product_info->product_id;  ?>" data-toggle="tab"><i class="fa fa-gavel"></i> Bulk</a></li>
   <?php  if($info[0]->is_bulk==1) {?>   <li class=""><a href="#retail_history_<?php echo $product_info->product_id;  ?>" data-toggle="tab"><i class="fa fa-folder-open-o"></i> Retail</a></li><?php }?>
  </ul>
  <div class="tab-content">
      <div class="tab-pane active" id="Bulk_history_<?php echo $product_info->product_id;  ?>"  >
<b>Product Name:</b> <?php echo $info[0]->product_desc?><br>
<b>Unit of Measurement :</b> <?php echo $info[0]->parent_unit_name?><br><br>
   <center>
       <table width="100%"  style="border-collapse: collapse;">
           <thead>
                <tr class="">
                    <td style="border: 1px solid lightgrey;padding: 5px;"><b>Txn Date</b></td>
                    <td style="border: 1px solid lightgrey;padding: 5px;"><b>Reference</b></td>
                    <td style="border: 1px solid lightgrey;padding: 5px;"><b>Txn Type</b></td>
                    <td style="border: 1px solid lightgrey;padding: 5px;"><b>Description</b></td>
                    <td style="border: 1px solid lightgrey;padding: 5px;"><b>Department</b></td>
                    <td style="border: 1px solid lightgrey;padding: 5px;width: 20%;"><b>Remarks</b></td>
                    <td style="border: 1px solid lightgrey;padding: 5px;text-align: right;"><b>In</b></td>
                    <td style="border: 1px solid lightgrey;padding: 5px;text-align: right;"><b>Out</b></td>
                    <td style="border: 1px solid lightgrey;padding: 5px;text-align: right;"><b>Balance</b></td>

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
                   <td style="border: 1px solid lightgrey;padding: 5px;"><?php echo $product->type; ?></td>
                   <td style="border: 1px solid lightgrey;padding: 5px;"><?php echo $product->Description; ?></td>
                   <td style="border: 1px solid lightgrey;padding: 5px;"><?php echo $product->department_name; ?></td>
                   <td style="border: 1px solid lightgrey;padding: 5px;"><?php echo $product->remarks; ?></td>
                   <td style="border: 1px solid lightgrey;padding: 5px;text-align: right;"><?php echo number_format($product->parent_in_qty,2); ?></td>
                   <td style="border: 1px solid lightgrey;padding: 5px;text-align: right;"><?php echo number_format($product->parent_out_qty,2); ?></td>
                   <td style="border: 1px solid lightgrey;padding: 5px;text-align: right;font-weight: bolder;"><?php echo number_format($product->parent_balance,2); ?></td>
               </tr>
                <?php } ?>
           </tbody>
       </table>
   </center><br>
<a href="Products/transaction/history-product?id=<?php  echo $product_id?>&type=print&inv=parent" class="btn btn-success btn-sm" name=""  target="_blank" data-toggle="tooltip" data-placement="top" title="Print Bulk Product History" style="margin-right:-5px;"><i class="fa fa-print"></i> Print</a>
 &nbsp;<a href="Products/Export?product_id=<?php  echo $product_id?>&inv=parent" class="btn btn-success btn-sm" name=""   data-toggle="tooltip" data-placement="top" title="Export To Excel" style="margin-right:-5px;"><i class="fa fa-file-excel-o"></i> Export</a>

</div>
  <div class="tab-pane" id="retail_history_<?php echo $product_info->product_id;  ?>" >
<b>Product Name: </b><?php echo $info[0]->product_desc?><br>
<b>Unit of Measurement :</b> <?php echo $info[0]->child_unit_name?><br>
<b>Unit Details:</b> <?php echo $info[0]->parent_unit_name?> = <?php echo $info[0]->child_unit_desc?> <?php echo $info[0]->child_unit_name?>
<br><br>
     <center>
         <table width="100%"  style="border-collapse: collapse;">
             <thead>
                  <tr class="">
                      <td style="border: 1px solid lightgrey;padding: 5px;"><b>Txn Date</b></td>
                      <td style="border: 1px solid lightgrey;padding: 5px;"><b>Reference</b></td>
                      <td style="border: 1px solid lightgrey;padding: 5px;"><b>Txn Type</b></td>
                      <td style="border: 1px solid lightgrey;padding: 5px;"><b>Description</b></td>
                      <td style="border: 1px solid lightgrey;padding: 5px;text-align: right;"><b>In</b></td>
                      <td style="border: 1px solid lightgrey;padding: 5px;text-align: right;"><b>Out</b></td>
                      <td style="border: 1px solid lightgrey;padding: 5px;text-align: right;"><b>Balance</b></td>
                  </tr>

             </thead>
             <tbody>
                  <?php if(count($products_child)==0){ ?>
                      <tr>
                          <td colspan="9" style="border: 1px solid lightgrey;padding: 10px;" align="center">No transaction found.</td>
                      </tr>
                  <?php } ?>

                  <?php foreach($products_child as $product){ ?>
                 <tr>
                     <td style="border: 1px solid lightgrey;padding: 5px;"><?php echo date("M d, Y",strtotime($product->txn_date)); ?></td>
                     <td style="border: 1px solid lightgrey;padding: 5px;"><?php echo $product->ref_no; ?></td>
                     <td style="border: 1px solid lightgrey;padding: 5px;"><?php echo $product->type; ?></td>
                     <td style="border: 1px solid lightgrey;padding: 5px;"><?php echo $product->Description; ?></td>
                     <td style="border: 1px solid lightgrey;padding: 5px;text-align: right;"><?php echo number_format($product->child_in_qty,2); ?></td>
                     <td style="border: 1px solid lightgrey;padding: 5px;text-align: right;"><?php echo number_format($product->child_out_qty,2); ?></td>
                     <td style="border: 1px solid lightgrey;padding: 5px;text-align: right;font-weight: bolder;"><?php echo number_format($product->child_balance,2); ?></td>
                 </tr>
                  <?php } ?>
             </tbody>
         </table>
     </center><br>
<a href="Products/transaction/history-product?id=<?php  echo $product_id?>&type=print&inv=child" class="btn btn-success btn-sm" name=""  target="_blank" data-toggle="tooltip" data-placement="top" title="Print Retail Product History" style="margin-right:-5px;"><i class="fa fa-print"></i> Print</a>
 &nbsp;<a href="Products/Export?product_id=<?php  echo $product_id?>&inv=child" class="btn btn-success btn-sm" name=""   data-toggle="tooltip" data-placement="top" title="Export To Excel" style="margin-right:-5px;"><i class="fa fa-file-excel-o"></i> Export</a>
  </div><br>

<!--        <a href="Products/transaction/history-product?id=<?php  echo $product_id?>&type=print" class="btn btn-success btn-sm" name=""  target="_blank" data-toggle="tooltip" data-placement="top" title="Print History" style="margin-right:-5px;"><i class="fa fa-print"></i> Print</a>
&nbsp;
     <a href="Products/Export?product_id=<?php  echo $product_id?>" class="btn btn-success btn-sm" name=""   data-toggle="tooltip" data-placement="top" title="Export To Excel" style="margin-right:-5px;"><i class="fa fa-file-excel-o"></i> Export</a>
&nbsp; -->
<!--     <button class="btn btn-success btn btn-sm" style="" name="btn_email" style="text-transform: none; font-family: Tahoma, Georgia, Serif; " title="Send to Email" ><i class="fa fa-share"></i> Email
    </button> -->
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


















