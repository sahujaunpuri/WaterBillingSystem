<style type="text/css">
.left {border-left: 1px solid lightgray;}
.right{border-right: 1px solid lightgray;}
.bottom{border-bottom: 1px solid lightgray;}
.top{border-top: 1px solid lightgray;}

.fifteen{ width: 15%; }
.text-center{text-align: center;}
.text-right{text-align: right;}
</style>

    <table width="100%" style="font-family: tahoma;font-size: 11;" cellspacing="0">
            <thead>
                <tr>
                    <th width="12%" style="text-align: center;height: 30px;padding: 3px;" class="top left bottom">Account No</th>
                    <th width="50%" style="text-align: left;height: 30px;padding: 3px;" class="top bottom ">Customer Name</th>
                    <th width="12%" style="text-align: left;height: 30px;padding: 3px;" class="top bottom ">Meter Serial</th>
                    <th width="12%" style="text-align: left;height: 30px;padding: 3px;" class="top bottom ">Previous Month</th>
                    <th width="12%" style="text-align: right;height: 30px;padding: 3px;" class="top bottom ">Previous</th>
                    <th width="12%" style="text-align: right;height: 30px;padding: 3px;" class="top bottom ">Current</th>
                    <th width="12%" style="text-align: right;height: 30px;padding: 3px;" class="top bottom  right">Consumption</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($input_items as $inputs){ ?>
                <tr>
                    <td width="12%"  class="left" style="text-align: center;height: 10PX;padding: 3px;"><?php echo $inputs->account_no; ?></td>
                    <td width="50%" style="text-align: left;height: 10PX;padding: 3px;"><?php echo $inputs->receipt_name; ?></td>
                    <td width="12%" style="text-align: left;height: 10PX;padding: 3px;"><?php echo $inputs->serial_no; ?></td>
                    <td width="12%" style="text-align: left;height: 10PX;padding: 3px;"><?php echo $inputs->previous_month; ?></td>
                    <td width="12%" style="text-align: right;height: 10PX;padding: 3px;"><?php echo $inputs->previous_reading ?></td>
                    <td width="12%" style="text-align: right;height: 10PX;padding: 3px;"><?php echo $inputs->current_reading ?></td>
                    <td width="12%" class="right" style="text-align: right;height: 10PX;padding: 3px;"><?php echo $inputs->total_consumption ?></td>
                </tr>
            <?php } ?>
            <tr>
            <td colspan="" rowspan="" headers="" class="left top right bottom">Remarks</td>
            <td colspan="6" style="text-align: left;font-weight: bolder; ;height: 30px;padding: 3px;" class="right top bottom"><?php echo $batch->remarks; ?></td>
            </tr>
            </tbody>
        </table>
            <table width="100%" cellspacing="0" cellpadding="5">

<!--                 <tr>
                <td colspan="2" class="left ">Prepared By:</td>
                <td colspan="2" class="left">Date Received:</td>

                <td colspan="2" class="left right">Received By:</td>
                </tr>
                <tr style="">
                    <td style="width: 15%" class="text-left left bottom"> <br><br><br></td>
                    <td style="width: 20%" class="bottom"></td>
                    <td style="width: 10%" class="text-right left bottom"> </td>
                    <td style="width: 20%" class="bottom"> </td>
                    <td style="width: 15%" class="text-left left bottom"></td>
                    <td style="width: 20%" class="right bottom"></td>
                </tr> -->

            </table>
</table>
