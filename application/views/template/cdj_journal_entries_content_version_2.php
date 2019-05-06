<!DOCTYPE html>
<html>
<head>
    <title>Cash Disbursement</title>
    <style type="text/css">
   
    @media print and (width: 8.5in) and (height: 11in) {
            @page{
          margin-left: 45px;
          margin-right: 45px;      
            }
    }
        body {
            font-family: 'Arial',sans-serif;
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

        hr {
            border-top: 3px solid #404040;
        }

        tr {
  /*          border: none!important;*/
        }

        tr:nth-child(even){
          
       /*     border: none!important;*/
        }
        .padding-info{
            padding-left:10px;
        }
            table{
      
        border:none!important;
    }
    .bottom{
        border-bottom: 0.5px solid black;
    }

    </style>
    <script type="text/javascript">

</script>

</head>
<body>
                <p style="position: absolute;top:20px;left: 45px;font-size: 15px;text-transform: uppercase;"><b><?php echo $company_info->company_name; ?></b></p>
                <p style="position: absolute;top:20px;right: 45px;font-size: 16px;"><b>ACKNOWLEDGEMENT</b></p>
<table style="width: 100%;line-height: 120%;" id="info-table">
<tr>
        <td class="">&nbsp;</td>
        <td class=""></td>
        <td class=""></td>
        <td class=""></td>
    </tr>
<tr>
        <td class=""></td>
        <td class=""></td>
        <td class=""></td>
        <td class=""></td>
    </tr>
    <tr>
        <td class="align-right"  style="width: 15%"><strong style="font-size: 11px;">Voucher No.:</td>
        <td class="padding-info" style="width: 35%"><strong style="font-size: 12px;"><?php echo $journal_info->journal_id; ?></td>
        <td class="align-right" style="width: 30%;"><strong style="font-size: 11px;">Account No.:</td>
        <td class="padding-info"><strong style="font-size: 12px;"><?php  ?></td>
    </tr>
    <tr>
        <td class="align-right"><strong style="font-size: 11px;">Voucher Date:</td>
        <td class="padding-info"><strong style="font-size: 12px;"><?php echo date('F d, Y', strtotime($journal_info->date_txn)); ?></td>
        <td class="align-right"><strong style="font-size: 11px;">Check No.:</td>
        <td class="padding-info"><strong style="font-size: 12px;"><?php echo $journal_info->check_no; ?></td>
    </tr>
    <tr>
        <td class="align-right"><strong style="font-size: 11px;">Amount:</td>
        <td class="padding-info"><strong style="font-size: 12px;"><?php echo  number_format($journal_info->amount,2); ?></td>
        <td class="align-right"><strong style="font-size: 11px;">Check Date:</td>
        <td class="padding-info"><strong style="font-size: 12px;"><?php echo date('m/d/y', strtotime($journal_info->check_date)); ?></td>
    </tr>
    <tr>
        <td class="align-right"><strong style="font-size: 11px;">Amount in Words:</td>
        <td class="padding-info"><strong style="font-size: 12px;text-transform: capitalize; font-family: 'Times New Roman', Times, serif;"><i><?php echo $num_words; ?></i></td>
        <td class=""></td>
        <td class=""></td>
    </tr>
    <tr>
        <td class="">&nbsp;</td>
        <td class=""></td>
        <td class=""></td>
        <td class=""></td>
    </tr>
    <tr>
        <td class="align-right"><strong style="font-size: 11px;">Payee Name:</td>
        <td class="padding-info" colspan="3"><strong style="font-size: 12px;text-transform: uppercase;">***<?php echo $journal_info->supplier_name; ?>***</td>
    </tr>
</table>
<table>
        <tr>
        <td class="">&nbsp;</td>
        <td class=""></td>
        <td class=""></td>
        <td class=""></td>
    </tr>

    <tr>
        <td class="" style="width: 25%;">&nbsp;</td>
        <td class="" style="width: 25%;"></td>
        <td class="" style="width: 25%;text-align: center;font-size: 10px;">_________________________<br>Received By<br>(Print name and sign)</td>
        <td class="" style="width: 20%;text-align: center;font-size: 10px;">_________________________<br>Date<br> &nbsp;<br></td>
    </tr>
    <tr>

</table>
<br>
<br>
<b style="font-size: 15px;text-transform: uppercase;"><?php echo $company_info->company_name; ?></b>
                <p style="position: absolute;top:265px;right: 45px;font-size: 16px;"><b>VOUCHER DETAILS</b></p>
<table style="width: 100%;padding-top: 15px;" id="info-table-2nd" >
    <tr>
        <td class="align-right" style="width: 15%"><strong style="font-size: 11px;">Payee Name:</td>
        <td class="padding-info" colspan="3"><strong style="font-size: 12px;text-transform: uppercase;">***<?php echo $journal_info->supplier_name; ?>***</td>
    </tr>
</table>
<table style="width: 100%;padding-top: 10px;line-height: 100%;">
    <tr>
        <td class="align-right"  style="width: 15%"><strong style="font-size: 11px;">Voucher No.:</td>
        <td class="padding-info" style="width: 30%"><strong style="font-size: 12px;"><?php echo $journal_info->journal_id; ?></td>
        <td class="align-right" style="width: 15%;"><strong style="font-size: 11px;">Voucher Date.:</td>
        <td class="padding-info"><strong style="font-size: 12px;"><?php echo date('F d, Y', strtotime($journal_info->date_txn)); ?></td>
    </tr>
    <tr>
        <td class="align-right"><strong style="font-size: 11px;">Account No:</td>
        <td class="padding-info"><strong style="font-size: 12px;"><?php  ?></td>
        <td class="align-right"><strong style="font-size: 11px;">Tax Code.:</td>
        <td class="padding-info"><strong style="font-size: 12px;"><?php  ?></td>
    </tr>
    <tr>
        <td class="align-right"><strong style="font-size: 11px;">Check No.:</td>
        <td class="padding-info"><strong style="font-size: 12px;"><?php echo $journal_info->check_no; ?></td>
        <td class="align-right"><strong style="font-size: 11px;">Batch No.:</td>
        <td class="padding-info"><strong style="font-size: 12px;"></td>
    </tr>
    <tr>
        <td class="align-right"><strong style="font-size: 11px;">Amount:</td>
        <td class="padding-info"><strong style="font-size: 12px;">***<?php echo number_format($journal_info->amount,2); ?>***</td>
        <td class=""></td>
        <td class=""></td>
    </tr>
    <tr>
        <td class="align-right"><strong style="font-size: 11px;">Purpose of Check:</td>
        <td class="padding-info" colspan="3" style="font-size: 11px;"><i><?php echo $journal_info->remarks; ?></i></td>

    </tr>

</table>







<hr style="color: black;margin-bottom: 0px;padding-bottom: 0px; ">
    <table width="100%" style="font-family: 'Courier New'; letter-spacing: .5px;font-size: 10;    border-spacing: 10px 0px;
    border-collapse: separate;" border="0">
            <thead>
            <tr>
                <th width="15%" style="border-bottom: .5px solid black;text-align: center;height: 30px;padding: 6px;">ACCOUNT CODE</th>
                <th width="35%" style="border-bottom: .5px solid black;text-align: center;height: 30px;padding: 6px;">ACCOUNT DESCRIPTION</th>
                <th width="25%" style="border-bottom: .5px solid black;text-align: center;height: 30px;padding: 6px;">DEBIT</th>
                <th width="25%" style="border-bottom: .5px solid black;text-align: center;height: 30px;padding: 6px;">CREDIT</th>
            </tr>
            </thead>
    </table>
    <table width="100%" cellpadding="0" style="font-size: 10px;font-family: 'Courier New'; letter-spacing: 0px;border-spacing: 10px 5px;">
            <?php

            $dr_amount=0.00; $cr_amount=0.00;

            foreach($journal_accounts as $account){

                ?>
                <tr >
                    <td width="15%"  style="text-align: left;"><?php echo $account->account_no; ?></td>
                    <td width="35%"  style="text-align: left;"><?php echo $account->account_title; ?></td>
                    <td width="25%"  style="text-align: right;"><?php  if($account->dr_amount == 0){echo ''; } else{ echo number_format($account->dr_amount,2);} ?></td>
                    <td width="25%"  style="text-align: right;"><?php if($account->cr_amount == 0){ echo ''; } else{ echo number_format($account->cr_amount,2);} ?></td>
                </tr>
                <?php

                $dr_amount+=$account->dr_amount;
                $cr_amount+=$account->cr_amount; } ?>
    </table>
    <table width="100%" style="font-family: 'Courier New'; letter-spacing: .5px;font-size: 10;    border-spacing: 10px 5px;
    border-collapse: separate;" border="0">
            <thead>
            <tr>
                <th width="15%" style=""> </th>
                <th width="35%" style=""> </th>
                <th width="25%" style="text-align: right;border-top:.5px solid black;"><?php echo number_format($dr_amount,2); ?></th>
                <th width="25%" style="text-align: right;border-top:.5px solid black;"><?php echo number_format($cr_amount,2); ?></th>
            </tr>
            </thead>
    </table>
<table width="100%" cellpadding="0" style="font-size: 10px;font-family: 'Courier New'; letter-spacing: 0px;border-spacing: 10px 5px;text-align: center;">
    <tr>
        <td class="bottom">REFERENCE NO. <br> &nbsp;</td>
        <td class="bottom">INVOICE <br>NUMBER <br> &nbsp;</td>
        <td class="bottom">INVOICE <br>DATE <br> &nbsp;</td>
        <td class="bottom">INVOICE <br>AMOUNT <br> &nbsp;</td>
        <td class="bottom">DM/CM <br>AMOUNT <br> &nbsp;</td>
        <td class="bottom">TAX <br>AMOUNT <br> &nbsp;</td>
        <td class="bottom">AMOUNT PAID <br> &nbsp;</td>
    </tr>

    <tr>
        <td style="text-align: left;"><?php echo $journal_info->ref_type?> <?php echo $journal_info->ref_no ?></td>
        <td></td>
        <td><?php echo date('m/d/y', strtotime($journal_info->date_txn)); ?></td>
        <td></td>
        <td style="text-align: right;"><?php echo number_format($journal_info->amount,2); ?></td>
        <td></td>
        <td style="text-align: right;"><?php echo number_format($journal_info->amount,2); ?></td>
    </tr>
    <tr>
        <td class=""></td>
        <td class=""></td>
        <td class=""></td>
        <td class="bottom"></td>
        <td class="bottom"></td>
        <td class="bottom"></td>
        <td class="bottom"></td>
    </tr>
    <tr>
        <td class=""></td>
        <td class=""></td>
        <td class=""></td>
        <td style="text-align: right;">0.00</td>
        <td style="text-align: right;"><?php echo number_format($journal_info->amount,2); ?></td>
        <td style="text-align: right;">0.00</td>
        <td style="text-align: right;"><?php echo number_format($journal_info->amount,2); ?></td>
    </tr>
</table>

<br><br><br><br><br>
    <table style="text-align: center;font-size: 10px;width: 100%" >
        <tr>
            <td width="30%" class="" style="padding-right: 10px;vertical-align: bottom;">SHAIRA MANALILI</td>
            <td width="30%" class="" style="padding-right: 10px;vertical-align: bottom;">JEROME S. ROQUE</td>
            <td width="30%" class="" style="padding-right: 10px;vertical-align: bottom;">ABEL V. DIZON</td>
        </tr>
        <tr >
            <td width="30%" style="padding-right: 10px;vertical-align: middle;padding-top: 0px;">___________________________________</td>
            <td width="30%" height="10" style="padding-right: 10px;vertical-align: middle;padding-top: 0px;">___________________________________</td>
            <td width="30%" height="10" style="padding-right: 10px;vertical-align: middle;padding-top: 0px;">___________________________________</td>
        </tr>
        <tr>
            <td width="30%" style="padding-right: 10px;">PREPARED BY / PRINTED BY</td>
            <td width="30%" style="padding-right: 10px;">CHECKED BY</td>
            <td width="30%" style="padding-right: 10px;">APPROVED BY</td>
        </tr>
    </table>
        </center>

<p style="margin-left: 2.54cm;position: absolute;top: 824; left: 46;">***<?php echo $journal_info->supplier_name; ?>***</p>
<p style="margin-left: 2.54cm;position: absolute; top: 853.7270; left: 27.7539;text-transform:capitalize;">***<?php echo $num_words; ?>***</p>
<p style="margin-left: 2.54cm;position: absolute; top: 828.6370; left: 527.6250;">***<?php echo number_format($journal_info->amount,2); ?>***</p>
<p style="margin-left: 2.54cm;position: absolute; top: 797.6520; left: 528.7110;"><?php echo date('F d, Y', strtotime($journal_info->date_txn)); ?></p>
<p></p>
</body>
</html>
















