<!DOCTYPE html>
<html>
<head>
    <title>Cost of Goods Sold</title>
    <style type="text/css">
        body {
            font-family: 'Calibri',sans-serif;
            font-size: 12px;
        }
        .align-right {
            text-align: right;
        }
        .align-left {
            text-align: left;
        }
        .data {
            border-bottom: 1px solid #404040;
        }
        .align-center {
            text-align: center;
        }
        .report-header {
            font-weight: bolder; font-size: 16px;
        }
        .right-align{
            text-align: right;
        }
        th {
            text-align: left;
        }
        .period_start::before{
            content: "<?php echo $_GET['start']; ?>"
        }
        .period_end::before{
            content: "<?php echo $_GET['end']; ?>"
        }
    </style>
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
    <div class="" style="text-align: center;">
        <span class="report-header"><strong>Cost of Goods Sold</strong></span><br><small>Period <i><span class="period_start"></span> to <span class="period_end"></span></i></small>
    </div>

<table style="width: 100%;border:none!important;">
    <tbody>
        <tr>
            <td style="width: 80%"><span style="font-weight: bold;font-size: 20px">Merchandise Inventory - Beginning</span><br><i> Beginning Inventory of Period <span class="period_start"></span> to <span class="period_end"></span></i> </td>
            <td style="width: 20%;background: #3fc2ff!important;text-align: right;font-size: 20px;color: white;padding:5px;">   <?php $total_beginning_span =0; foreach ($beginning as $beg) {  $total_beginning_span+=$beg->avg_net; } echo number_format($total_beginning_span,2);?></td>
        </tr>
    </tbody>
</table>
<br>
<table class="table table-striped" id="tbl_merchandise_beginning" cellspacing="0" width="100%"> 
    <thead>
        <tr>
            <th >Product Description</th>
            <th class="align-right">On Hand</th>
            <th class="align-right">Average Cost</th>
            <th class="align-right">Total</th>
        </tr>
    </thead>
    <tbody>
    <?php $total_beginning =0; foreach ($beginning as $beg) {  $total_beginning+=$beg->avg_net;?>

        <tr>
            <td><?php echo $beg->product_desc ?></td>
            <td class="align-right"><?php echo number_format($beg->balance,2); ?></td>
            <td class="align-right"><?php echo number_format($beg->avg_cost,2); ?></td>
            <td class="align-right"><?php echo number_format($beg->avg_net,2); ?></td>
        </tr>

    <?php  } ?>
    </tbody>
    <tfoot>
    <tr>
        <td colspan="3" style="text-align: left;"><b>Merchandise Inventory - Beginning :</b></td>
        <td colspan="1" align="right"><b><?php echo number_format($total_beginning,2) ?></b></td>
    </tr>

    </tfoot>
</table>
<br><br>                                        
<table style="width: 100%;border:none!important;">
    <tbody>
        <tr>
            <td style="width: 80%"><span style="font-weight: bold;font-size: 20px;"><small>Add:</small> Purchases</span><br><i> Purchase Invoice of Period <span class="period_start"></span> to <span class="period_end"></span></i> </td>
            <td style="width: 20%;background: #3fc2ff!important;text-align: right;font-size: 20px;color: white;padding:5px;">   <?php $total_purchases_span = 0; foreach ($purchases as $pur) {  $total_purchases_span += $pur->dr_line_total_price; }  echo number_format($total_purchases_span,2) ?></td>
        </tr>
    </tbody>
</table>
<br>
<table class="table table-striped" id="tbl_purchases" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>Invoice #</th>
            <th>Date</th>
            <th>Supplier</th>
            <th>Product</th>
            <th class="right-align">Qty</th>
            <th class="right-align">Cost</th>
            <th class="right-align">Total</th>
        </tr>
    </thead>
    <tbody>
    <?php $total_purchases = 0; foreach ($purchases as $pur) {  $total_purchases += $pur->dr_line_total_price ?>
        <tr>
            <td><?php echo $pur->dr_invoice_no ?></td>
            <td><?php echo $pur->delivered_date ?></td>
            <td><?php echo $pur->supplier_name ?></td>
            <td><?php echo $pur->product_desc ?></td>
            <td class="right-align"><?php echo number_format($pur->qty,2) ?></td>
            <td class="right-align"><?php echo number_format($pur->price,2) ?></td>
            <td class="right-align"><?php echo number_format($pur->dr_line_total_price,2) ?></td>
        </tr>
    <?php } ?>
    </tbody>
    <tfoot>
    <tr>
        <td colspan="5" style="text-align: left;"><b>Add : Total Purchases</b></td>
        <td colspan="2" align="right"><b class=""><?php echo number_format($total_purchases,2); ?></b></td>
    </tr>

    </tfoot>
</table>
<table style="width: 100%;border:none!important;">
    <tbody>
        <tr>
            <td style="width: 80%;text-align:right;padding-right: 10px;"><span style="font-weight: bold;">Total Goods Available for Sale: </span><i>( Merchandise Inventory [Beginning] + Purchases )</i> </td>
            <td style="width: 20%;background: #3fc2ff!important;text-align: right;font-size: 20px;color: white;padding:5px;" class="total_available_goods"><?php echo number_format(($total_beginning+$total_purchases),2) ?></td>
        </tr>
    </tbody>
</table><br>
<table style="width: 100%;border:none!important;">
    <tbody>
        <tr>
            <td style="width: 80%"><span style="font-weight: bold;font-size: 20px;"><small>Less:</small> Merchandise Inventory - End</span><br>
            <i> Inventory of Period <span class="period_start"></span> to <span class="period_end"></span></i> </td>
            <td style="width: 20%;background: #3fc2ff!important;text-align: right;font-size: 20px;color: white;padding:5px;" class="total_avg_cost_ending"><?php $total_ending_span =0; foreach ($ending as $end) {  $total_ending_span+=$end->avg_net; } echo number_format($total_ending_span,2) ?> </td>
        </tr>
    </tbody>
</table>
<br>
<br><br>
<table class="table table-striped" cellspacing="0" width="100%" id="tbl_ending_inventory">
    <thead>
        <tr>
            <th >Product Description</th>
            <th class="align-right">On Hand</th>
            <th class="align-right">Average Cost</th>
            <th class="align-right">Total</th>
        </tr>
    </thead>
    <tbody>
    <?php $total_ending =0; foreach ($ending as $end) {  $total_ending+=$end->avg_net;?>
        <tr>
            <td><?php echo $end->product_desc ?></td>
            <td class="align-right"><?php echo number_format($end->balance,2); ?></td>
            <td class="align-right"><?php echo number_format($end->avg_cost,2); ?></td>
            <td class="align-right"><?php echo number_format($end->avg_net,2); ?></td>
        </tr>
    <?php  } ?>
    </tbody>
    <tfoot>
    <tr>
        <td colspan="3" style="text-align: left;"><b>Merchandise Inventory - Ending :</b></td>
        <td colspan="2" align="right"><b class=""><?php echo number_format($total_ending,2); ?></b></td>
    </tr>

    </tfoot>
</table>
<table style="width: 100%;border:none!important;">
    <tbody>
        <tr>
            <td style="width: 80%;text-align:right;padding-right: 10px;"><span style="font-weight: bold;font-size: 20px;">Cost of Goods Sold: </span><br><i>Period <span class="period_start"></span> to <span class="period_end"></span></i> </td>
            <td style="width: 20%;background: #3fc2ff!important;text-align: right;font-size: 20px;color: white;padding:5px;" class="total_cost_of_goods_sold"><?php echo number_format(($total_beginning+$total_purchases-$total_ending),2); ?></td>
        </tr>
    </tbody>
</table><br>

</body>
</html>



<script type="text/javascript">
    window.print()
</script>

















