<!DOCTYPE html>
<html>
<head>
    <title>Water Billing Statement</title>
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
    table.statment td {
        border: 0px !important;
    }
    </style>
</head>
<body>
    <div class="">
    <!-- <h4 style="text-align: center;">Disconnection Service</h4> -->
    </div>

   <table width="100%" style="font-family: tahoma;font-size: 11;border: 0px!important;" class="table table-bordered statment" border="0">
        <tr>
            <td colspan="4" class="tablehead"><b>BILLING DETAILS</b></td>
        </tr>
        <tr>
          <td width="10%">Control No:</td>
          <td width="40%"><?php echo $billing->control_no; ?></td>
          <td width="15%">Period Covered:</td>
          <td width="35%"><?php echo $billing->period_covered; ?></td>
        </tr>
        <tr>
          <td>Account No:</td>
          <td><?php echo $billing->account_no; ?></td>
          <td>Reading Date:</td>
          <td><?php echo $billing->reading_date; ?></td>
        </tr>
        <tr>
          <td>Particular: </td>
          <td><?php echo $billing->customer_name; ?></td>
          <td>Due Date: </td>
          <td><?php echo $billing->due_date; ?></td>
        </tr>
        <tr>
          <td>Address: </td>
          <td><?php echo $billing->address; ?></td>
          <td>Contract Type: </td>
          <td><?php echo $billing->contract_type_name; ?></td>
        </tr>
        <tr>
          <td>Meter Serial: </td>
          <td><?php echo $billing->serial_no; ?></td>
          <td>Rate Amount: </td>
          <td><?php echo $billing->rate_amount; ?></td>
        </tr>
    </table>
    <table width="100%" style="font-family: tahoma;font-size: 11;border: 0px!important;" class="table table-bordered statment" border="0">

           <tr>
                <td colspan="7" class="tablehead"><b>PREVIOUS BALANCE</b></td>
           </tr>
            <tr>
                <td></td>
                <td colspan="5">BALANCE AS OF  : </td>
                <td class="right-align"><?php echo number_format($billing->arrears_amount,2); ?></td>
           </tr>
            <tr>
                <td></td>
                <td colspan="5">PENALTY : </td>
                <td class="right-align"><?php echo number_format($billing->arrears_penalty_amount,2);?></td>
           </tr> 
            <tr>
                <td></td>
                <td colspan="5"><b>TOTAL OUTSTANDING BALANCE</b></td>
                <td class="right-align"><b><?php echo number_format(($billing->arrears_amount + $billing->arrears_penalty_amount),2); ?></b></td>
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
                <td><?php echo $billing->month_name; ?></td>
                <td class="right-align"><?php echo $billing->previous_reading; ?></td>
                <td class="right-align"><?php echo $billing->current_reading; ?></td>
                <td class="right-align"><?php echo $billing->total_consumption; ?></td>
                <td class="right-align"><?php echo number_format($billing->amount_due,2); ?></td>
           </tr>         
           <tr>
                <td ></td>
                <td colspan="6">OTHER CHARGES:</td>
           </tr>
          <?php 
            $total_charges = 0;
            foreach($charges as $charges){
            $total_charges += $charges->charge_line_total;
          ?>
            <tr>
                <td colspan="2"></td>
                <!-- <td><?php echo number_format($charges->charge_qty,0); ?></td> -->
                <td><?php echo $charges->charge_desc.' ('.$charges->other_charge_no.')'; ?></td>
                <td colspan="3"></td>
                <!-- <td><?php echo $charges->charge_unit_name; ?></td> -->
                <!-- <td class="right-align"><?php echo number_format($charges->charge_amount,2); ?></td> -->
                <td class="right-align"><?php echo number_format($charges->charge_line_total,2); ?></td>
           </tr>  
           <?php }?>
           <tr>
                <td></td>
                <td colspan="5"><b>TOTAL CURRENT CHARGES</b></td>
                <td class="right-align"><b><?php echo number_format($total_charges,2); ?></b></td>
           </tr>
           <tr>
                <td colspan="6" class="tablehead"><b>TOTAL AMOUNT DUE <i>(Before Due Date)</i></b></td>
                <td class="tablehead right-align"><b><?php echo number_format(($billing->grand_total_amount + $billing->arrears_amount + $billing->arrears_penalty_amount),2); ?></b></td>
           </tr>
           <tr>
                <td></td>
                <td colspan="5">PENALTY AMOUNT</td>
                <td class="right-align"><?php echo number_format($billing->penalty_amount,2); ?></td>
           </tr>
           <tr>
                <td colspan="6" class="tablehead"><b>TOTAL AMOUNT DUE <i>(After Due Date)</i></b></td>
                <td class="tablehead right-align"><b><?php echo number_format(($billing->grand_total_amount+$billing->arrears_amount+$billing->arrears_penalty_amount+$billing->penalty_amount),2); ?></b></td>
           </tr>
   </table>

</body>
</html>