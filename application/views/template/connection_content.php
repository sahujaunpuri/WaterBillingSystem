<head>  <title>Connection Service</title></head>
<body>
<style>
    body {
            font-family: 'Calibri',sans-serif;
            font-size: 12px;
    }
    @page {
                    size: auto;   /* auto is the initial value */
                    margin: .5in .5in 1in .5in; 
    }
    .left {border-left: 1px solid black;}
    .right{border-right: 1px solid black;}
    .bottom{border-bottom: 1px solid black;}
    .top{border-top: 1px solid black;}

    .fifteen{ width: 15%; }
    .text-center{text-align: center;}
    .text-right{text-align: right;}
</style>

<div>
    <table width="100%" cellspacing="0" cellpadding="0">
        <tr class="row_child_tbl_sales_order" style="height: 100px;" >
            <td class="bottom-only" width="10%" style="border-bottom:1px solid black;object-fit:cover; "><img src="<?php echo $company_info->logo_path; ?>" style="height: 90px;  text-align: left;"></td>
            <td  class="bottom-only" style="border-bottom:1px solid black;"  width="90%" class="">
                <h1 class="report-header" style="padding-left: 30px;"><strong><?php echo $company_info->company_name; ?></strong></h1>
                <p style="padding-left: 30px;"><?php echo $company_info->company_address; ?></p>
                <p style="padding-left: 30px;"> <?php echo $company_info->landline.'/'.$company_info->mobile_no; ?></p>
                <span><?php echo $company_info->email_address; ?></span><br>

            </td>
        </tr>
    </table><br>
  </div>
<div>
    <h4 style="text-align: right;"><b>CONNECTION SERVICE</b></h4>
    <center>
        <table width="100%" cellpadding="5" style="font-family: tahoma;font-size: 11px!important;" border="0">
            <tr>
                <td style="background: lightgray;" colspan="4"><b>ACCOUNT DETAILS</b></td>
            </tr>
            <tr>
                <td style="width: 15%;">Service No :</td>
                <td style="width: 35%;"><?php echo $connection->service_no; ?></td>
                <td style="width: 15%;">Account Type : 
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
            <tr>
                <td colspan="4" style="padding: 20px!important;margin: 20px!important;"></td>
            </tr>
            <tr>
                <td colspan="3" style="padding: 0px!important;margin: 0px!important;"></td>
                <td style="padding: 0px!important;margin: 0px!important;"><center><?php echo $connection->attendant; ?></center></td>
            </tr>
            <tr>
                <td colspan="3" style="padding: 0px!important;margin: 0px!important;"></td>
                <td style="border-bottom: 1px solid gray;padding: 0px!important;margin: 0px!important;"></td>
            </tr>
            <tr>
                <td colspan="3" style="padding: 0px!important;margin: 0px!important;"></td>
                <td style="padding: 0px!important;margin: 0px!important;"><center>Attended By</center></td>
            </tr>
        </table>
        <br />
    </center>
    <br><br>
</div>





















