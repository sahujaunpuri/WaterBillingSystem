<!DOCTYPE html>
<html>
<head>
    <title>Service Disconnection</title>
    <link rel="icon" href="<?php echo base_url('assets/img/companyico.ico'); ?>" type="image/ico" sizes="16x16">
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
            font-weight: bolder;
        }

    table{
        border:none;
    }
    .right-align{
        text-align: right;
    }
    .tablehead{
        background-color: #e2e2e2!important;
    }
    table.tbl_service_disconnection td {
        border: 0px !important;
      padding: 3px 5px 3px 5px!important;
    }
    </style>
</head>
<body>
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
    <div class="">
    <h3 style="text-align: right;">Disconnection Service</h3>
    </div>

   <table width="100%" style="font-family: tahoma;font-size: 11;border: 0px!important;" class="table table-bordered tbl_service_disconnection" border="0">
        <tr>
            <td colspan="7" class="tablehead"><b>ACCOUNT DETAILS</b></td>
        </tr>
      <tr>
          <td width="15%">Disconnection No:</td>
          <td width="55%"><?php echo $dis_info->disconnection_code; ?></td>
          <td width="15%">Date:</td>
          <td width="15%" colspan="4"><?php echo $dis_info->service_date; ?></td>
      </tr>
      <tr>
          <td>Service No:</td>
          <td><?php echo $dis_info->service_no; ?></td>
          <td>Disconnection Date:</td>
          <td colspan="4"><?php echo $dis_info->date_disconnection_date; ?></td>
      </tr>
      <tr>
          <td>Account No:</td>
          <td><?php echo $dis_info->account_no; ?></td>
          <td>Account Type:</td>
          <td colspan="4"><?php echo $dis_info->customer_account_type_desc; ?></td>
      </tr>
      <tr>
          <td>Customer Name:</td>
          <td><?php echo $dis_info->customer_name; ?></td>

          <td>Meter Serial:</td>
          <td colspan="4"><?php echo $dis_info->serial_no; ?></td>
      </tr>
      <tr>
          <td>Name on Receipt:</td>
          <td colspan="6"><?php echo $dis_info->receipt_name; ?></td>
      </tr>
      <tr>
          <td>Address:</td>
          <td colspan="6"><?php echo $dis_info->address; ?></td>
      </tr>
      <tr>
          <td>Reason for Disconnection:</td>
          <td colspan="6"><?php echo $dis_info->reason_desc; ?></td>
      </tr>
      <tr>
          <td colspan="2">Note:</td>
          <td colspan="4"><?php echo $dis_info->disconnection_notes; ?></td>
      </tr>
      <tr>
          <td colspan="1">Remaining Deposit:</td>
          <td colspan="5" ><b><?php echo number_format($dis_info->remaining_deposit,2); ?></b></td>
      </tr>
    </table>
   <table width="100%" style="font-family: tahoma;font-size: 11;border: 0px!important;" class="table table-bordered tbl_service_disconnection" border="0">
        <?php 
        $total_outstanding_balance= $dis_info->arrears_amount + $dis_info->arrears_penalty_amount;
        $total_current_charges = 0;
        $total_amount_due = 0;
        ?>
           <tr>
                <td colspan="7" class="tablehead"><b>PREVIOUS BALANCE</b></td>
           </tr>
            <tr>
                <td></td>
                <td colspan="5">BALANCE AS OF DATE : </td>
                <td class="right-align"><?php echo number_format($dis_info->arrears_amount,2); ?></td>
           </tr>
            <tr>
                <td></td>
                <td colspan="5">PENALTY : </td>
                <td class="right-align"><?php echo number_format($dis_info->arrears_penalty_amount,2); ?></td>
           </tr> 
            <tr>
                <td></td>
                <td colspan="5"><b>TOTAL OUTSTANDING BALANCE</b></td>
                <td class="right-align"><b><?php echo number_format($total_outstanding_balance,2);?></b></td>
           </tr>     
           <tr>
                <td colspan="7" class="tablehead"><b>CURRENT BILLING</b></td>
           </tr>
           <tr>
                <td ></td>
                <td colspan="6">METER CHARGE</td>
           </tr>
           <tr>
                <td width="3%"></td>
                <td width="%"></td>
                <td>MONTH</td>
                <td class="right-align">PREVIOUS </td>
                <td class="right-align">CURRENT </td>
                <td class="right-align">CONSUMPTION</td>
                <td class="right-align"></td>
           </tr>
            <tr>
                <td></td>
                <td></td>
                <td><?php echo date('F Y', strtotime($dis_info->date_disconnection_date)); ?></td>
                <td class="right-align"><?php echo $dis_info->previous_reading; ?></td>
                <td class="right-align"><?php echo $dis_info->last_meter_reading; ?></td>
                <td class="right-align"><?php echo $dis_info->total_consumption; ?></td>
                <td class="right-align"><?php echo number_format($dis_info->meter_amount_due,2); ?></td>
           </tr>
           <?php $total_current_charges = $total_current_charges +  $dis_info->meter_amount_due ;?>
           <tr>
                <td ></td>
                <td colspan="6">OTHER CHARGES:</td>
           </tr>
            <tr>
              <?php foreach ($other_charges as $other_charge) { ?>
                <td></td>
                <td></td>
                <td colspan="4"><?php echo $other_charge->charge_desc ?> (<?php echo $other_charge->other_charge_no ?>) </td>

                <td class="right-align"><?php echo number_format($other_charge->charge_line_total,2) ?></td>
              <?php $total_current_charges += $other_charge->charge_line_total; } 
              $total_amount_due = $total_current_charges + $total_outstanding_balance;?>


           </tr>
            <tr>
                <td></td>
                <td colspan="5"><b>TOTAL CURRENT CHARGES</b></td>
                <td class="right-align"><b><?php echo number_format($total_current_charges,2); ?></b></td>
           </tr>
           <tr>
                <td colspan="6" class="tablehead"><b>TOTAL AMOUNT DUE</b></td>
                <td class="tablehead right-align"><b><?php echo number_format($total_amount_due,2); ?></b></td>
           </tr>
   </table>

</body>
</html>