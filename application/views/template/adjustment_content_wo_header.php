<head>  <title>Item Adjustment</title></head>
<body>
      <style type="text/css">
      .nohover{

          pointer-events: none;
      }
          
      .bottom-only{
      border:none!important;
      }
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

      </style>
<div>    
    <center><table width="95%" cellpadding="5" style="border-collapse: collapse;border-spacing: 0;font-family: tahoma;font-size: 11;" border="0" class="nohover">
            <tr>
                <td width="45%" valign="top" style="border-collapse: collapse!important;border-spacing: 0!important;font-family: tahoma;font-size: 11; border :0px solid #525252!important;">
                    <span>Department :</span><br />
                    <address>
                        <strong><?php echo $adjustment_info->department_name; ?></strong><br /><br />

                    </address>
                    <p>
                        <span>Date adjusted : <br /> <b><?php echo  date_format(new DateTime($adjustment_info->date_adjusted),"m/d/Y"); ?></b></span><br />

                    </p>
                    <br />
                    <span>Adjustment type :</span><br />
                    <strong><?php echo $adjustment_info->adjustment_type; ?></strong><br>
                </td>

                <td width="50%" align="right" style=" border :0px solid #525252!important;">
                    <p>Adjustment No.</p><br />
                    <h4 class="text-navy"><?php echo $adjustment_info->adjustment_code; ?></h4><br />




                </td>
            </tr>
        </table></center>

    <br /><br />

    <center>
        <table width="95%" style="border-collapse: collapse;border-spacing: 0;font-family: tahoma;font-size: 11;background-color: transparent!important;" class="nohover" >
            <thead style="background-color: transparent!important ;">
            <tr style="background-color: transparent!important ;">
                <th width="50%" style="text-align: left;height: 15px;padding: 6px;border-bottom: 1px solid gray;" >Item</th>
                <th width="12%" style="text-align: right;height: 15px;padding: 6px;border-bottom: 1px solid gray;">Qty</th>
                <th width="12%" style="text-align: center;height: 15px;padding: 6px;border-bottom: 1px solid gray;">UM</th>
                <th width="12%" style="text-align: right;height: 15px;padding: 6px;border-bottom: 1px solid gray;">Price</th>
                <th width="12%" style="text-align: right;height: 15px;padding: 6px;border-bottom: 1px solid gray;">Total</th>
            </tr>
            </thead>
            <tbody style="border-collapse:collapse">
            <?php foreach($adjustment_items as $item){ ?>
                <tr style="background-color: transparent!important ;">
                    <td width="50%" style="border-bottom: 1px solid gray;text-align: left;height: 15px;padding: 6px;"><?php echo $item->product_desc; ?></td>
                    <td width="12%" style="border-bottom: 1px solid gray;text-align: right;height: 15px;padding: 6px;"><?php echo number_format($item->adjust_qty,0); ?></td>
                    <td width="12%" style="border-bottom: 1px solid gray;text-align: center;height: 15px;padding: 6px;"><?php echo $item->unit_name; ?></td>
                    <td width="12%" style="border-bottom: 1px solid gray;text-align: right;height: 15px;padding: 6px;"><?php echo number_format($item->adjust_price,2); ?></td>

                    <td width="12%" style="border-bottom: 1px solid gray;text-align: right;height: 15px;padding: 6px;"><?php echo number_format($item->adjust_line_total_price,2); ?></td>
                </tr>
            <?php } ?>
            <tr>
            <td colspan="5" style="text-align: left;font-weight: bolder; ;height: 15px;padding: 6px;border-left: 1px solid gray;border-right: 1px solid gray;">Remarks:</td>
            </tr>
            <tr>
            <td colspan="5" style="text-align: left;font-weight: bolder; ;height: 15px;padding: 6px;border-left: 1px solid gray;border-bottom: 1px solid gray;border-right: 1px solid gray;"><?php echo $adjustment_info->remarks; ?></td>
            </tr>
            </tbody>
            <tfoot style="background-color: transparent!important ;">
            <tr style="background-color: transparent!important ;">
                <td colspan="2" style="text-align: left;height: 15px;padding: 6px;border-left: 1px solid gray;"><b>Prepared by:</b></td>
                <td colspan="2" style="border-bottom: 1px solid gray;text-align: left;height: 15px;padding: 6px;border-left: 1px solid gray;">Discount : </td>
                <td style="border-bottom: 1px solid gray;text-align: right;height: 15px;padding: 6px;border-right: 1px solid gray;"><?php echo number_format($adjustment_info->total_discount,2); ?></td>
            </tr>
            <tr style="background-color: transparent!important ;">
                <td colspan="2" style="text-align: right;height: 15px;padding: 6px;border-left: 1px solid gray;border-bottom: 1px solid gray;"></td>
                <td colspan="2" style="border-bottom: 1px solid gray;text-align: left;height: 15px;padding: 6px;border-left: 1px solid gray;">Total before Tax : </td>
                <td style="border-bottom: 1px solid gray;text-align: right;height: 15px;padding: 6px;border-right: 1px solid gray;"><?php echo number_format($adjustment_info->total_before_tax,2); ?></td>
            </tr>
            <tr style="background-color: transparent!important ;">
                <td colspan="2" style="text-align: left;height: 15px;padding: 6px;border-left: 1px solid gray;"><b>Received by:</b></td>
                <td colspan="2" style="border-bottom: 1px solid gray;text-align: left;height: 15px;padding: 6px;border-left: 1px solid gray;">Tax Amount : </td>
                <td style="border-bottom: 1px solid gray;text-align: right;height: 15px;padding: 6px;border-right: 1px solid gray;"><?php echo number_format($adjustment_info->total_tax_amount,2); ?></td>
            </tr>
            <tr style="background-color: transparent!important ;">
                <td colspan="2" style="text-align: left;height: 15px;padding: 6px;border-left: 1px solid gray;border-bottom: 1px solid gray;">Date:</td>
                <td colspan="2" style="border-bottom:1px solid gray;text-align: left;height: 15px;padding: 6px;border-left: 1px solid gray;"><strong>Total after Tax : </strong></td>
                <td style="border-bottom: 1px solid gray;text-align: right;height: 15px;padding: 6px;border-right: 1px solid gray;"><strong><?php echo number_format($adjustment_info->total_after_tax,2); ?></strong></td>
            </tr>
            </tfoot>
        </table><br /><br />
    </center>
</div>

<style>
</style>



















