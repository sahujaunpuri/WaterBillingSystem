<!DOCTYPE html>
<html>
<head>
    <title>Bank Reconciliation</title>
</head>
<style type="text/css">
    .right-align {text-align: right;}
    .bottom{border-bottom: 1px solid black;}
table#outs tr:first-child td:nth-child(3)::before{
    content: "P"
}
table#outs tr:last-child td:nth-child(3){
    border-bottom: 1px solid black;
}
        body {
            font-family: 'Calibri',sans-serif;
            font-size: 12px;
        }
        .report-header {
            font-size: 22px;
        }
        .heads{
            font-size: 18px;
        }
</style>
<body>

    <table width="100%">
        <tr>
            <td width="10%"><img src="<?php echo base_url($company_info->logo_path); ?>" style="height: 90px; width: 120px; text-align: left;"></td>
            <td width="90%" class="align-center">
                <span class="report-header"><strong><?php echo $company_info->company_name; ?></strong></span><br>
                <span><?php echo $company_info->company_address; ?></span><br>
                <span><?php echo $company_info->landline.'/'.$company_info->mobile_no; ?></span>
            </td>
        </tr>
    </table><hr>
    <div class="">
        <span class="heads"><strong>Bank Reconciliation</strong></span>       
        <br><?php echo $data->date_reconciled ?><br><br>

<table width="100%" class="table table-striped">
<tbody>
    <tr>
        <td width="40%"><b>Balance as per Bank</b></td>
        <td width="20%"></td>
        <td width="20%"></td>
        <td width="20%" class="right-align">P<?php  echo number_format($data->actual_balance,2);?></td>
    </tr>

    <tr>
        <td>Add: Deposit in Transit</td>
        <td></td>
        <td></td>
        <td  class="right-align bottom"><?php echo number_format($data->deposit_in_transit,2); ?></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td class="right-align"><?php echo number_format(($data->deposit_in_transit + $data->actual_balance),2) ?></td>
    </tr>
    <tr >
        <td>Less Outstanding Checks:</td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
</tbody>
</table>
<table width="100%" class="table table-striped" id="outs">
    <?php $totalout = 0;
    foreach ($outs as $out) {  $totalout+=$out->amount; ?>
    <tr >
        <td width="40%">No. <?php echo $out->check_no ?> issued on <?php echo $out->check_date ?></td>
        <td width="20%"></td>
        <td width="20%" class="right-align"><?php echo number_format($out->amount,2) ?></td>
        <td width="20%"></td>
    </tr>
     <?php } ?>
</tbody>
</table>
<table width="100%" class="table table-striped" >
    <tr >
        <td width="40%"></td>
        <td width="20%"></td>
        <td width="20%" class="right-align"></td>
        <td width="20%" class="right-align bottom"><?php echo number_format($totalout,2) ?></td>
    </tr>
    <tr >
        <td width="40%">Adjusted Bank Balance</td>
        <td width="20%"></td>
        <td width="20%" class="right-align"></td>
        <td width="20%" class="right-align bottom">P<?php echo number_format((($data->deposit_in_transit + $data->actual_balance)-$totalout),2) ?></td>
    </tr>
</tbody>
</table><br>
<table width="100%" class="table table-striped" id="book">
<tbody>
    <tr>
        <td width="40%"><b>Balance as per Books</b></td>
        <td width="20%"></td>
        <td width="20%"></td>
        <td width="20%" class="right-align">P<?php  echo number_format($data->account_balance,2);?></td>
    </tr>

    <tr>
        <td>Add: </td>
        <td></td>
        <td></td>
        <td  class="right-align"></td>
    </tr>
    <tr>
        <td>Interest Income from Bank</td>
        <td></td>
        <td class="right-align">P<?php echo number_format($data->interest_earned,2) ?></td>
        <td ></td>
    </tr>
    <tr >
        <td>Note Receivable Collection from Bank</td>
        <td></td>
        <td class="right-align bottom"><?php echo number_format($data->notes_receivable,2) ?></td>
        <td></td>
    </tr>
    <tr >
        <td></td>
        <td></td>
        <td ></td>
        <td class="right-align bottom"><?php echo number_format(($data->notes_receivable+$data->interest_earned),2) ?></td>
    </tr>
    <?php $total_after_add_in_books = $data->notes_receivable+$data->interest_earned+$data->account_balance; ?>
    <tr >
        <td></td>
        <td></td>
        <td ></td>
        <td class="right-align"><?php echo number_format($total_after_add_in_books,2) ?></td>
    </tr>
    <tr>
        <td>Less: </td>
        <td></td>
        <td></td>
        <td  class="right-align"></td>
    </tr>
    <tr>
        <td>NSF Check</td>
        <td></td>
        <td class="right-align">P<?php echo number_format($data->nsf_check,2) ?></td>
        <td ></td>
    </tr>
    <tr >
        <td>Bank Service Fee</td>
        <td></td>
        <td class="right-align"><?php echo number_format($data->bank_service_charge,2) ?></td>
        <td></td>
    </tr>
    <tr >
        <td>Check Printing Charge</td>
        <td></td>
        <td class="right-align bottom"><?php echo number_format($data->check_printing_charge,2) ?></td>
        <td></td>
    </tr>
    <?php $total_of_books_less=$data->bank_service_charge+$data->check_printing_charge+$data->nsf_check; ?>
    <tr >
        <td></td>
        <td></td>
        <td></td>
        <td class="right-align bottom"><?php echo number_format($total_of_books_less,2) ?></td>
    </tr>
    <tr >
        <td>Adjusted Book Balance</td>
        <td></td>
        <td></td>
        <td class="right-align bottom">P<?php echo number_format($total_after_add_in_books-$total_of_books_less,2) ?></td>
    </tr>

</tbody>
</table>
</body>
</html>

<script type="text/javascript">
    window.print();

</script>