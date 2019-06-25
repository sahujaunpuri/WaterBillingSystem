<head><title>Consumption History - <?php echo $connection->customer_name; ?></title></head>
<body>
<style>
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
    .align-center {
        text-align: center;
    }
    .report-header {
        font-weight: bolder;
    }
    table{
        border:none!important;
    }
    .left {border-left: 1px solid lightgray;}
    .right{border-right: 1px solid lightgray;}
    .bottom{border-bottom: 1px solid lightgray;}
    .top{border-top: 1px solid lightgray;}
    .bold{font-weight: bold;}
</style>
<div>
    <table width="100%" cellspacing="0" cellpadding="0">
        <tr class="row_child_tbl_sales_order" style="height: 100px;border-bottom:1px solid black;" >
            <td class="" width="10%" style="object-fit:cover; "><img src="<?php echo $company_info->logo_path; ?>" style="height: 90px;  text-align: left;"></td>
            <td  class="" style=""  width="90%" class="">
                <h1 class="report-header" style="padding-left: 30px;"><strong><?php echo $company_info->company_name; ?></strong></h1>
                <p style="padding-left: 30px;"><?php echo $company_info->company_address; ?></p>
                <p style="padding-left: 30px;"> <?php echo $company_info->landline.'/'.$company_info->mobile_no; ?></p>
                <span><?php echo $company_info->email_address; ?></span><br>

            </td>
        </tr>
    </table><hr><br>
    <h4 style="width:100%;text-align: right;">CONSUMPTION HISTORY - <?php echo $_GET['y']; ?></h4>
    <center>
        <table width="100%" cellpadding="5" style="font-family: tahoma;font-size: 11px!important;" border="0" class="table table-striped">
            <tr>
                <td style="background: lightgray;" colspan="4"><b>ACCOUNT DETAILS</b></td>
            </tr>
            <tr>
                <td style="width: 15%;">Service No :</td>
                <td style="width: 35%;"><?php echo $connection->service_no; ?></td>
                <td style="width: 15%;">Date : </td>
                <td style="width: 30%;"><?php echo $connection->service_date; ?></td>
            </tr>
            <tr>
                <td>Account No : </td>
                <td><?php echo $connection->account_no; ?></td>
                <td>Installation Date : </td>
                <td><?php echo $connection->target_date.' '.$connection->target_time; ?></td>
            </tr>
            <tr>
                <td>Meter Serial : </td>
                <td><?php echo $connection->serial_no; ?></td>
                <td colspan="2"></td>
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
<h4 style="width:100%;text-align: center;"><?php echo $_GET['y']; ?> - CONSUMPTION HISTORY </h4>
<table style="width:100%;font-family: tahoma;font-size: 11px!important;" class="table table-striped" cellspacing="0" cellpadding="5">
<thead>
    <tr>
    <th class="bottom top left align-left" width="15%">Month</th>
    <th class="bottom top left align-right">Reading</th>
    <th class="bottom top left align-right">Consumption</th>
    <th class="bottom top left right align-right">Amount</th>
    </tr>
</thead>
<?php print_r($datas) ?>
<tbody id="tbody">
<?php 
           foreach ($datas as $data) {
            ?>
            <tr>
                <td class="left bold"><?php echo $data->month_name; ?> </td>
                <td class="left align-right"><?php echo $data->reading; ?></td>
                <td class="left align-right"><?php echo $data->total_consumption; ?></td>
                <td class="left right align-right"><?php if($data->total_amount != 0){ echo number_format($data->total_amount,2); } ?></td>
            </tr>
    <?php } ?>
   <tr>
    <td class="top"></td>
    <td class="top"></td>
    <td class="top"></td>
    <td class="top ">
    </tr>
</tbody>
</table>
    </center>
<br>
<div>
    Date Printed: <?php echo date("m/d/Y h:i a") ?><br>
    Printed by: <?php echo $user; ?>
</div>

</div>





















