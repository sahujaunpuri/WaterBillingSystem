     
     <head>  <title>Sales Order </title></head>
<body> <style type="text/css">
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
    table-td.left{
        border-left: 1px solid gray!important;
    }
    table-td.right{
        border-left: 1px solid gray!important;
    }
</style>
<div>
<table width="100%">
        <tr>
            <td width="10%"><img src="<?php echo $company_info->logo_path; ?>" style="height: 90px; width: 120px; text-align: left;"></td>
            <td width="90%" class=''>
                <h1 class="report-header"><strong><?php echo $company_info->company_name; ?></strong></h1>
                <p><?php echo $company_info->company_address; ?></p>
                <p><?php echo $company_info->landline.'/'.$company_info->mobile_no; ?></p>
                <span><?php echo $company_info->email_address; ?></span>
            </td>
        </tr>
    </table><hr>

    <center>
        <table width="95%" cellpadding="5" style="font-family: tahoma;font-size: 11;">
            <tr class="row_child_tbl_so_list">
                <td width="45%" valign="top" style="border: 0px !important;"><br />
                    <span>Department :</span><br />
                    <address>
                        <strong><?php echo $sales_order->department_name; ?></strong><br /><br />

                    </address>
                    <p>
                        <span>Order date : <br /> <b><?php echo  date_format(new DateTime($sales_order->date_order),"m/d/Y"); ?></b></span><br /><br />
                    </p>
                    <br />
                    <span>Customer :</span><br />
                    <strong><?php echo $sales_order->customer_name; ?></strong><br>
                </td>

                <td width="50%" align="right" style="border: 0px !important;">
                    <p>Sales Order No.</p><br />
                    <h4 class="text-navy" ><?php echo $sales_order->so_no; ?></h4><br />
                </td>
            </tr>
        </table>
    </center>

    <br /><br />

    <center>
        <table width="95%" style="border-collapse: collapse;border-spacing: 0;font-family: tahoma;font-size: 11">
            <thead>
            <tr>
                <th width="50%" style="border-bottom: 2px solid gray;text-align: left;height: 30px;padding: 6px;">Item</th>
                <th width="12%" style="border-bottom: 2px solid gray;text-align: right;height: 30px;padding: 6px;">Qty</th>
                <th width="12%" style="border-bottom: 2px solid gray;text-align: center;height: 30px;padding: 6px;">UM</th>
                <th width="12%" style="border-bottom: 2px solid gray;text-align: right;height: 30px;padding: 6px;">Price</th>
                <th width="12%" style="border-bottom: 2px solid gray;text-align: right;height: 30px;padding: 6px;">Total</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($sales_order_items as $item){ ?>
                <tr>
                    <td width="50%" style="border-bottom: 1px solid gray;text-align: left;height: 30px;padding: 6px;"><?php echo $item->product_desc; ?></td>
                    <td width="12%" style="border-bottom: 1px solid gray;text-align: right;height: 30px;padding: 6px;"><?php echo number_format($item->so_qty,2); ?></td>
                    <td width="12%" style="border-bottom: 1px solid gray;text-align: center;height: 30px;padding: 6px;"><?php echo $item->unit_name; ?></td>
                    <td width="12%" style="border-bottom: 1px solid gray;text-align: right;height: 30px;padding: 6px;"><?php echo number_format($item->so_price,2); ?></td>

                    <td width="12%" style="border-bottom: 1px solid gray;text-align: right;height: 30px;padding: 6px;"><?php echo number_format($item->so_line_total_price,2); ?></td>
                </tr>
            <?php } ?>
                <tr>
                <td colspan="5" style="text-align: left;font-weight: bolder; ;height: 30px;padding: 6px;border-left: 1px solid gray;border-right: 1px solid gray;">Remarks:</td>
                </tr>
                <tr>
                <td colspan="5" style="text-align: left;font-weight: bolder; ;height: 30px;padding: 6px;border-left: 1px solid gray;border-bottom: 1px solid gray;border-right: 1px solid gray;"><?php echo $sales_order->remarks; ?></td>
                </tr>
            </tbody>
            <tfoot>
            <tr>
                <td colspan="2" style="text-align: left;height: 30px;padding: 6px;border-left: 1px solid gray!important;"><b>Prepared By:</b></td>
                <td colspan="2" style="border-bottom: 1px solid gray;text-align: left;height: 30px;padding: 6px;border-left: 1px solid gray!important;">Discount 1: </td>
                <td style="border-bottom: 1px solid gray;text-align: right;height: 30px;padding: 6px;border-right: 1px solid gray;"><?php echo number_format($sales_order->total_discount,2); ?></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: right;height: 30px;padding: 6px;border-bottom: 1px solid gray!important;border-left: 1px solid gray!important;"></td>
                <td colspan="2" style="border-bottom: 1px solid gray;text-align: left;height: 30px;padding: 6px;border-left: 1px solid gray!important;">Total before Tax : </td>
                <td style="border-bottom: 1px solid gray;text-align: right;height: 30px;padding: 6px;border-right: 1px solid gray;"><?php echo number_format($sales_order->total_before_tax,2); ?></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: left;height: 30px;padding: 6px;border-left: 1px solid gray!important;"><b>Received By:</b></td>
                <td colspan="2" style="border-bottom: 1px solid gray;text-align: left;height: 30px;padding: 6px;border-left: 1px solid gray!important;">Tax Amount : </td>
                <td style="border-bottom: 1px solid gray;text-align: right;height: 30px;padding: 6px;border-right: 1px solid gray;"><?php echo number_format($sales_order->total_tax_amount,2); ?></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: left;height: 30px;padding: 6px;border-bottom: 1px solid gray!important;border-left: 1px solid gray!important;">Date:</td>
                <td colspan="2" style="border-bottom:1px solid gray;text-align: left;height: 30px;padding: 6px;border-left: 1px solid gray!important;">Total after Tax : </td>
                <td style="border-bottom: 1px solid gray;text-align: right;height: 30px;padding: 6px;border-right: 1px solid gray;"><strong><?php echo number_format($sales_order->total_after_tax,2); ?></strong></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: left;height: 30px;padding: 6px;border-bottom: 1px solid gray!important;border-left: 1px solid gray!important;"></td>
                <td colspan="2" style="border-bottom:1px solid gray;text-align: left;height: 30px;padding: 6px;border-left: 1px solid gray!important;">Discount 2 : </td>
                <td style="border-bottom: 1px solid gray;text-align: right;height: 30px;padding: 6px;border-right: 1px solid gray;"><?php echo number_format($sales_order->total_overall_discount_amount,2); ?></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: left;height: 30px;padding: 6px;border-bottom: 1px solid gray!important;border-left: 1px solid gray!important;"></td>
                <td colspan="2" style="border-bottom:1px solid gray;text-align: left;height: 30px;padding: 6px;border-left: 1px solid gray!important;"><strong>Total : </strong></td>
                <td style="border-bottom: 1px solid gray;text-align: right;height: 30px;padding: 6px;border-right: 1px solid gray;"><?php echo number_format($sales_order->total_after_discount,2); ?></td>
            </tr>
            </tfoot>
        </table><br /><br />
    </center>
</div>





















