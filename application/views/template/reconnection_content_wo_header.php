<head>
    <title>Reconnection Services</title>
    <link rel="icon" href="<?php echo base_url('assets/img/companyico.ico'); ?>" type="image/ico" sizes="16x16">
</head>
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
        <table width="100%" cellpadding="5" style="font-family: tahoma;font-size: 11px!important;" border="0" class="tablenoborder">
            <tr>
                <td style="background: lightgray;" colspan="4"><b>ACCOUNT DETAILS</b></td>
            </tr>
            <tr>
                <td style="width: 15%;">Reconnection No :</td>
                <td style="width: 35%;"><?php echo $reconnection->reconnection_code; ?></td>
                <td style="width: 15%;">Account Type : </td>
                <td style="width: 30%;"><?php echo $reconnection->customer_account_type_desc; ?></td>

            </tr>
            <tr>               
                <td>Service No :</td>
                <td><?php echo $reconnection->disconnection_code; ?></td>
                <td>Date : </td>
                <td><?php echo $reconnection->service_date; ?></td>
            </tr>
            <tr>
                <td>Account No : </td>
                <td><?php echo $reconnection->account_no; ?></td>
                <td>Disconnection Date : </td>
                <td><?php echo $reconnection->date_disconnection_date; ?></td>
            </tr>
            <tr>
                <td>Meter Serial : </td>
                <td><?php echo $reconnection->serial_no; ?></td>
                <td>Reinstallation Date : </td>
                <td><?php echo $reconnection->date_connection_target.' '.$reconnection->time_connection_target; ?></td>
            </tr>
            <tr>
                <td style="background: lightgray;" colspan="4"><b>CUSTOMER DETAILS</b></td>
            </tr>            
            <tr>
                <td>Customer :</td>
                <td colspan="3"><?php echo $reconnection->customer_name; ?> </td>
            </tr>
            <tr>
                <td>Name on Receipt :</td>
                <td colspan="3"><?php echo $reconnection->receipt_name; ?> </td>
            </tr>
            <tr>
                <td>Address : </td>
                <td colspan="3"><?php echo $reconnection->address; ?></td>
            </tr>
            <tr>
                <td style="background: lightgray;" colspan="4"><b>METER DETAILS</b></td>
            </tr> 
            <tr>
                <td>Old Rate Type : </td>
                <td><?php echo $reconnection->rate_type_name; ?></td>
                <td>Contract Type : </td>
                <td><?php echo $reconnection->contract_type_name; ?></td>
            </tr>
            <tr>
                <td>New Rate Type : </td>
                <td><?php echo $reconnection->new_rate_type; ?></td>
                <td colspan="2"></td>
            </tr>
        </table>
        <br />
    </center>
</div>





















