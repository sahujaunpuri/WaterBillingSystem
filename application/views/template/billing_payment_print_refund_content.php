<head><title>Refund Acknowledgement Receipt</title></head>
<body>
<style>
    .bottom-only{
        border:none!important;
    }
    .align-right {
        text-align: right;
    }
    .align-left {
        text-align: left;
    }
    .align-center {
        text-align: center;
    }
    .report-header {
        font-weight: bolder;
    }
    table{
        border:none!important;
    }
    table tbody tr td {
            line-height: 1.4em;
    }
    .center{text-align: center;}
</style>
<div>
</div>
<div class="center" style="text-transform: uppercase;">
    <b style="font-size: 15px;"><?php echo $company_info->company_name; ?></b><br/>
    <?php echo $company_info->company_address; ?><br><br>
    Refund Acknowledgement Receipt
</div>

<table style="width:100%;">
    <tbody>
        <tr>
            <td width="15%">AR No:</td>
            <td><?php echo $info->receipt_no; ?> </td>
            <td width="15%">Date:</td>
            <td width="10%"><?php echo $info->date_paid; ?></td>
        </tr>
        <tr>
            <td>Customer:</td>
            <td><?php echo $info->receipt_name; ?> </td>
            <td>Meter No:</td>
            <td><?php echo $info->serial_no; ?></td>
        </tr>
        <tr>
            <td>Account No:</td>
            <td><?php echo $info->account_no; ?></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Amount Refund:</td>
            <td><?php echo number_format($info->refund_amount,2); ?> </td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Amount in Words:</td>
            <td colspan="3" style="text-transform: capitalize;"><?php echo $num_words; ?></td>
        </tr>
        <tr>
        <td colspan="4"> &nbsp;</td>
        </tr>
        <tr>
            <td>Noted By:</td>
            <td>___________________</td>
            <td>Received By:</td>
            <td>___________________</td>
        </tr>
    </tbody>
</table>
<br>
<script>
    window.print();
</script>

















