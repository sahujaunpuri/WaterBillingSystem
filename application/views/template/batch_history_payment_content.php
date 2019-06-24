<head><title>Batch History Report</title></head>
<body>
<style>
@media print{@page {size: landscape}}
    table{
        border:none!important;
        font-family: Calibri;
        font-size: 12px;
        border-collapse: collapse;
    }
    td{
        padding: 0px!important;
        margin: 0px!important; 
        padding: 3px;
    }
    th{
        border-bottom: 1px solid lightgray;text-align: left;
    }
</style>
<table width="100%" class="nohover" >
    <tr>
        <td  class="bottom-only" width="10%" style="object-fit: cover;"><img src="<?php echo base_url($company_info->logo_path); ?>" style="height: 90px; width: 90px; text-align: left;"></td>
        <td class="bottom-only" width="90%" class="">
            <strong style="font-size: 18px;"><?php echo $company_info->company_name; ?></strong><br>
            <span><?php echo $company_info->company_address; ?></span><br>
            <span><?php echo $company_info->landline.'/'.$company_info->mobile_no; ?></span><br>
            <span><?php echo $company_info->email_address; ?></span><br>

        </td>
    </tr>
</table><hr>    
<h4>Batch Payment Summary (<?php echo $batch_info[0]->batch_code ?>)</h4>

<table width="100%">
    <tr>
        <td>Date : <?php echo $batch_info[0]->start_date; ?> - <?php echo $batch_info[0]->end_date; ?></td>
        <td align="right">Date Printed : <?php echo date('m/d/Y h:i a');?></td>
    </tr>
    <tr>
        <td>Batch Closed by <?php echo $batch_info[0]->posted_by_user; ?>  </td>
        <td align="right">Printed by: <?php echo $this->session->user_fullname; ?></td>
    </tr>
</table>
<br>
<table width="100%">
    <thead>
        <tr>
            <th>Receipt #</th>
            <th>Customer</th>
            <th>Account No</th>
            <th>Method</th>
            <th style="text-align: right;">Amount Payment</th>
            <th style="text-align: right;">Deposit Payment</th>
            <th style="text-align: right;">Total Payment</th>
            <th style="text-align: right;">Refund</th>
        </tr> 
    </thead>  
    <tbody>
    <?php $total_batch = 0;  $total_refund = 0;
    foreach ($billing_payments_info as $binfo) { ?>
        <tr>
            <td><?php echo $binfo->receipt_no ?></td>
            <td><?php echo $binfo->customer_name ?></td>
            <td><?php echo $binfo->account_no ?></td>
            <td><?php echo $binfo->payment_method ?></td>
            <td style="text-align: right;"><?php echo number_format($binfo->total_payment_amount,2) ?></td>
            <td style="text-align: right;"><?php echo number_format($binfo->total_deposit_amount,2) ?></td>
            <td style="text-align: right;"><?php echo number_format($binfo->total_paid_amount,2) ?></td>
            <td style="text-align: right;"><?php echo number_format($binfo->refund_amount,2); $total_refund += $binfo->refund_amount; ?> </td>
        </tr>
    <?php $total_batch += $binfo->total_paid_amount; } ?>
    <tr>
        <td colspan="6" style="text-align: right;border-top: 1px solid black"><b>Total:</b></td>
        <td style="text-align: right;border-top: 1px solid black"><b><?php echo number_format($total_batch,2) ?></b></td>
        <td style="text-align: right;border-top: 1px solid black"><b><?php echo number_format($total_refund,2) ?></b></td>
    </tr>    
    </tbody>   
</table>

<script>
window.print();
</script>