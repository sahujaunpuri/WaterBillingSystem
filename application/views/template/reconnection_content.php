<head>  
    <title>Reconnection Services</title>  
    <link rel="icon" href="<?php echo base_url('assets/img/companyico.ico'); ?>" type="image/ico" sizes="16x16">
</head>
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
    <h4 style="text-align: right;"><b>RECONNECTION SERVICE</b></h4>
    <center>
        <table width="100%" cellpadding="5" style="font-family: tahoma;font-size: 11px!important;" border="0">
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
    <br><br>
</div>





















