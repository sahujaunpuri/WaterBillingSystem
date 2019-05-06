<!DOCTYPE html>
<html>
<head>
	<title>Purchase Order</title>
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

		.align-center {
			text-align: center;
		}

		.report-header {
			font-weight: bolder;
		}

		hr {
			/*border-top: 3px solid #404040;*/
		}

		tr {
            border: none!important;
        }
    table{
        border:none!important;
    }
	</style>
</head>
<body>
	<div class="">
		<strong>P.O. # :</strong> <?php echo $purchase_info->po_no; ?></td> <br>
		<strong>Date : </strong><?php echo date_format(new DateTime($purchase_info->date_created),"m/d/Y"); ?>
	</div><br>
	<table width="100%"  cellspacing="-1">
		<tr>
			<td style="padding: 6px;" width="50%" colspan="2"><strong>Supplier / Address:</strong></td>
			<td style="padding: 6px;" width="50%"><strong>Deliver to :</strong></td>
		</tr>
		<tr>
			<td style="padding: 6px;" width="50%" colspan="2"><?php echo $purchase_info->supplier_name; ?></td>
			<td style="padding: 6px;" width="50%"><?php echo $purchase_info->deliver_to_address; ?></td>
		</tr>
		<tr>
			<td style="padding: 6px;" width="25%" colspan="2"><strong>Terms :</strong></td>
			<td style="padding: 6px;" width="25%"><strong>Ref # :</strong></td>
	
		</tr>
		<tr>
			<td style="padding: 6px;" width="25%" colspan="2"><?php echo $purchase_info->terms; ?></td>
			<td style="padding: 6px;" width="25%"></td>
		</tr>
	</table>
	<br>
	<table width="100%" cellpadding="10" cellspacing="-1" class="table table-striped" style="text-align: center;">
		<tr>
			<td style="padding: 6px;border-bottom: 1px solid gray;"><strong>Description</strong></td>
			<td style="padding: 6px;border-bottom: 1px solid gray;"><strong>UM</strong></td>
			<td style="padding: 6px;border-bottom: 1px solid gray;"><strong>Qty</strong></td>
			<td style="padding: 6px;border-bottom: 1px solid gray;"><strong>Unit Price</strong></td>
            <td style="padding: 6px;border-bottom: 1px solid gray;"><strong>Discount (%)</strong></td>
			<td style="padding: 6px;border-bottom: 1px solid gray;"><strong>Amount</strong></td>
		</tr>
		<?php foreach($po_items as $item){ ?>
            <tr>
                <td width="50%" style="border-bottom: 1px solid gray;text-align: left;height: 10px;padding: 6px;"><?php echo $item->product_desc; ?></td>
                <td width="10%" style="border-bottom: 1px solid gray;text-align: center;height: 10px;padding: 6px;"><?php echo $item->unit_name; ?></td>
                <td width="15%" style="border-bottom: 1px solid gray;text-align: right;height: 10px;padding: 6px;"><?php echo number_format($item->po_qty,2); ?></td>
                <td width="15%" style="border-bottom: 1px solid gray;text-align: right;height: 10px;padding: 6px;"><?php echo number_format($item->po_price,2); ?></td>
                <td width="15%" style="border-bottom: 1px solid gray;text-align: right;height: 10px;padding: 6px;"><?php echo number_format($item->po_discount,2); ?></td>
                <td width="10%" style="border-bottom: 1px solid gray;text-align: right;height: 10px;padding: 6px;"><?php echo number_format($item->po_line_total_after_global,2); ?></td>
            </tr>
        <?php } ?>
 <tr>
            <td colspan="6" style="text-align: left;height: 30px;padding: 6px;border-left: 1px solid gray;border-right: 1px solid gray;"><b>Remarks:</b></td>
        </tr>
        <tr>
            <td colspan="6" style="text-align: left;height: 30px;padding: 6px;border-left: 1px solid gray;border-bottom: 1px solid gray;border-right: 1px solid gray;"><?php echo $purchase_info->remarks; ?></td>
        </tr>
        <tr>
        	<td align="left" colspan="2" style="border-left: 1px solid gray;"><b>Prepared By:</b></td>
        	<td colspan="3" style="padding: 6px;border-bottom: 1px solid gray;height: 30px;border-left: 1px solid gray;" align="left">Global Discount %:</td>
        	<td style="padding: 6px;border-bottom: 1px solid gray;height: 30px; border-right: 1px solid gray;" align="right"><?php echo number_format($purchase_info->total_overall_discount,2); ?></td>
        </tr>
        <tr>
            <td align="left" colspan="2"  style="border-left: 1px solid gray;"></td>
            <td  colspan="3"  style="padding: 6px;border-bottom: 1px solid gray;height: 30px;border-left: 1px solid gray;" align="left">Total Discount :</td>
            <td style="padding: 6px;border-bottom: 1px solid gray;height: 30px;border-right: 1px solid gray;" align="right"><?php echo number_format($purchase_info->total_overall_discount_amount +$purchase_info->total_discount ,2); ?></td>
        </tr>
        <tr>
            <td  align="left" colspan="2"  style="border-bottom: 1px solid gray;border-left: 1px solid gray;"></td>
            <td colspan="3" style="padding: 6px;border-bottom: 1px solid gray;height: 30px;border-left: 1px solid gray;" align="left">Total Before Tax:</td>
            <td style="padding: 6px;border-bottom: 1px solid gray;height: 30px;border-right: 1px solid gray;" align="right"><?php echo number_format($purchase_info->total_before_tax,2); ?></td>
        </tr>
        <tr>
        	<td align="left" colspan="2" style="border-left: 1px solid gray;"><b>Received By:</b></td>
        	<td colspan="3" style="padding: 6px;border-bottom: 1px solid gray;height: 30px;border-left: 1px solid gray;" align="left">Total Tax Amount:</td>
        	<td style="padding: 6px;border-bottom: 1px solid gray;height: 30px;border-right: 1px solid gray;" align="right"><?php echo number_format($purchase_info->total_tax_amount,2); ?></td>
        </tr>
        <tr>
        	<td align="left" colspan="2" style="border-left: 1px solid gray;" ></td>
        	<td colspan="3" style="padding: 6px;border-bottom: 1px solid gray;height: 30px;border-left: 1px solid gray;" align="left">Total After Tax:</td>
        	<td style="padding: 6px;border-bottom: 1px solid gray;height: 30px;border-right: 1px solid gray;" align="right"><?php echo number_format($purchase_info->total_after_tax,2); ?></td>
        </tr>

        <tr>
            <td align="left" colspan="2"  style="border-bottom: 1px solid gray;border-left: 1px solid gray;">Date</td>
            <td  colspan="3"  style="padding: 6px;border-bottom: 1px solid gray;height: 30px;border-left: 1px solid gray;" align="left"><strong>Total:</strong></td>
            <td style="padding: 6px;border-bottom: 1px solid gray;height: 30px;border-right: 1px solid gray;" align="right"><strong><?php echo number_format($purchase_info->total_after_discount,2); ?></strong></td>
        </tr>
	</table>

</body>
</html>
