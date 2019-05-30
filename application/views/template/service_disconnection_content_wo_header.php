<!DOCTYPE html>
<html>
<head>
    <title>Service Disconnection</title>
    <style type="text/css">

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
    }
    </style>
</head>
<body>
    <div class="">
    <!-- <h4 style="text-align: center;">Disconnection Service</h4> -->
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
          <td>Meter Serial:</td>
          <td colspan="4"><?php echo $dis_info->serial_no; ?></td>
      </tr>
      <tr>
          <td>Customer Name:</td>
          <td colspan="6"><?php echo $dis_info->customer_name; ?></td>
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
    </table>
   <table width="100%" style="font-family: tahoma;font-size: 11;border: 0px!important;" class="table table-bordered tbl_service_disconnection" border="0">

           <tr>
                <td colspan="7" class="tablehead"><b>PREVIOUS BALANCE</b></td>
           </tr>
            <tr>
                <td></td>
                <td colspan="5">BALANCE AS OF  : </td>
                <td class="right-align">0.00</td>
           </tr>
            <tr>
                <td></td>
                <td colspan="5">PENALTY : </td>
                <td class="right-align">0.00</td>
           </tr> 
            <tr>
                <td></td>
                <td colspan="5"><b>TOTAL OUTSTANDING BALANCE</b></td>
                <td class="right-align"><b>0.00</b></td>
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
           <tr>
                <td ></td>
                <td colspan="6">PENALTY</td>
           </tr>
           <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="right-align">0.00</td>
           </tr>
           <tr>
                <td ></td>
                <td colspan="6">OTHER CHARGES:</td>
           </tr>
            <tr>
                <td></td>
                <td></td>
                <td colspan="4"></td>
                <td class="right-align">0.00</td>
           </tr>
            <tr>
                <td></td>
                <td colspan="5"><b>TOTAL CURRENT CHARGES</b></td>
                <td class="right-align"><b>0.00</b></td>
           </tr>
           <tr>
                <td colspan="6" class="tablehead"><b>TOTAL AMOUNT DUE</b></td>
                <td class="tablehead right-align"><b>0.00</b></td>
           </tr>
   </table>

</body>
</html>