        <style type="text/css">
    body {
            font-family: 'Calibri',sans-serif;
            font-size: 12px;
    }
    @page {
                    size: auto;   /* auto is the initial value */
                    margin: .5in .5in 1in .5in; 
    }
/*    tr:hover {
        transition: .4s;
        background: #414141 !important;
        color: white;
    }

    tr:hover .btn {
        border-color: #494949!important;
        border-radius: 0!important;
        -webkit-box-shadow: 0px 0px 5px 1px rgba(0,0,0,0.75);
        -moz-box-shadow: 0px 0px 5px 1px rgba(0,0,0,0.75);
        box-shadow: 0px 0px 5px 1px rgba(0,0,0,0.75);
    }*/
.left {border-left: 1px solid black;}
.right{border-right: 1px solid black;}
.bottom{border-bottom: 1px solid black;}
.top{border-top: 1px solid black;}

.fifteen{ width: 15%; }
.text-center{text-align: center;}
.text-right{text-align: right;}
        </style>
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
    <table width="100%" cellpadding="5" cellspacing="0">
        <tr>
            <td><span>Batch No:</span></td>
            <td><?php echo $batch->batch_no?></td>
            <td>Date Input:</td>
            <td><?php echo  date_format(new DateTime($batch->date_input ),"m/d/Y"); ?></td>

        <tr>
            <td><span>Applicable Month:</span></td>
            <td><?php echo $batch->month_name;?> <?php echo $batch->meter_reading_year;?></td>
            <td><span>Posted By:</span></td>
            <td><?php echo $batch->posted_by ?></td>
        </tr>
    </table>
    <table width="100%"  style="font-family: tahoma;font-size: 11;" cellspacing="0" cellpadding="5">
            <thead>

            <tr>
                <th width="12%" style="text-align: center;height: 30px;padding: 6px;" class="top left bottom">Account No</th>
                <th width="50%" style="text-align: left;height: 30px;padding: 6px;" class="top bottom ">Customer Name</th>
                <th width="12%" style="text-align: left;height: 30px;padding: 6px;" class="top bottom ">Meter Serial</th>
                <th width="12%" style="text-align: left;height: 30px;padding: 6px;" class="top bottom ">Previous Month</th>
                <th width="12%" style="text-align: right;height: 30px;padding: 6px;" class="top bottom ">Previous</th>
                <th width="12%" style="text-align: right;height: 30px;padding: 6px;" class="top bottom ">Current</th>
                <th width="12%" style="text-align: right;height: 30px;padding: 6px;" class="top bottom  right">Consumption</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($input_items as $inputs){ ?>
                <tr>
                    <td width="12%" class="left" style="text-align: center;height: 30px;padding: 6px;"><?php echo $inputs->account_no; ?></td>
                    <td width="50%" style="text-align: left;height: 30px;padding: 6px;"><?php echo $inputs->receipt_name; ?></td>
                    <td width="12%" style="text-align: left;height: 30px;padding: 6px;"><?php echo $inputs->serial_no; ?></td>
                    <td width="12%" style="text-align: left;height: 30px;padding: 6px;"><?php echo $inputs->previous_month; ?></td>
                    <td width="12%" style="text-align: right;height: 30px;padding: 6px;"><?php echo $inputs->previous_reading ?></td>
                    <td width="12%" style="text-align: right;height: 30px;padding: 6px;"><?php echo $inputs->current_reading ?></td>
                    <td width="12%" class="right" style="text-align: right;height: 30px;padding: 6px;"><?php echo $inputs->total_consumption ?></td>
                </tr>
            <?php } ?>
            <tr>
            <td colspan="" rowspan="" headers="" class="left top right bottom">Remarks</td>
            <td colspan="6" style="text-align: left;font-weight: bolder; ;height: 30px;padding: 6px;" class="right top bottom"><?php echo $batch->remarks; ?></td>
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
