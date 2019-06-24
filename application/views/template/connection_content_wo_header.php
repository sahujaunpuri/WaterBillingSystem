<head><title>Connection Services</title></head>
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
    .tablenoborder{
        border:none!important;
    }
</style>
<div>
    <center>
        <table width="100%" cellpadding="5" style="font-family: tahoma;font-size: 11px!important;" border="0" class="table table-striped tablenoborder">
            <tr>
                <td style="background: lightgray;" colspan="4"><b>ACCOUNT DETAILS</b></td>
            </tr>
            <tr>
                <td style="width: 15%;">Service No :</td>
                <td style="width: 35%;"><?php echo $connection->service_no; ?></td>
                <td style="width: 15%;">Account Type : </td>
                <td style="width: 30%;"><?php echo $connection->customer_account_type_desc; ?></td>
            </tr>
            <tr>
                <td>Account No : </td>
                <td><?php echo $connection->account_no; ?></td>
                <td>Date : </td>
                <td><?php echo $connection->service_date; ?></td>
            </tr>
            <tr>
                <td>Meter Serial : </td>
                <td><?php echo $connection->serial_no; ?></td>
                <td>Installation Date : </td>
                <td><?php echo $connection->target_date.' '.$connection->target_time; ?></td>
            </tr>
            <tr>
                <td style="background: lightgray;" colspan="4"><b>CUSTOMER DETAILS</b></td>
            </tr>            
            <tr>
                <td>Customer :</td>
                <td colspan="3"><?php echo $connection->customer_name; ?> </td>
            </tr>
            <tr>
                <td>Name on Receipt :</td>
                <td colspan="3"><?php echo $connection->receipt_name; ?> </td>
            </tr>
            <tr>
                <td>Address : </td>
                <td colspan="3"><?php echo $connection->address; ?></td>
            </tr>
            <tr>
                <td style="background: lightgray;" colspan="4"><b>METER DETAILS</b></td>
            </tr> 
            <tr>
                <td>Contract Type : </td>
                <td><?php echo $connection->contract_type_name; ?></td>
                <td>Initial Reading : </td>
                <td><?php echo number_format($connection->initial_meter_reading,0); ?></td>
            </tr>
            <tr>
                <td>Rate Type : </td>
                <td><?php echo $connection->rate_type_name; ?></td>
                <td>Initial Deposit : </td>
                <td><?php echo number_format($connection->initial_meter_deposit,2); ?></td>
            </tr>
        </table>
        <br />
    </center>
</div>





















