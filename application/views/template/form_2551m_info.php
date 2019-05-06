<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<div style="margin-bottom: 20px!important;">
		<div style="float: left;font-size: 9pt;">
			<b>Month : </b> <?php echo $info->month_name; ?><br />
			<b>Year:</b> <?php echo $info->year;?><br />
			<b>ATC : </b><?php echo $info->atc; ?><br />
			<b>Industry Classification : </b><?php echo $info->industry_classification; ?><br />
		</div>
		<div style="float: right;font-size: 9pt;">
			<b>Taxable Amount:</b> <?php echo $info->taxable_amount; ?><br />
			<b>Tax Rate:</b> <?php echo number_format($info->tax_rate,0); ?>%<br />
			<b>Tax Due:</b> <?php echo $info->tax_due; ?><br />
		</div>
	</div>
	<table class="table table-striped" cellspacing="0" width="100%" style="margin-top: 10px;">
		<thead>
			<tr>
				<th>Reference #</th>
				<th>Invoice Date</th>
				<th>Department</th>
				<th>Customer</th>
				<th>Remarks</th>
				<th style="text-align: right;">Amount</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			$total_amount = 0;
			foreach($invoices as $invoices){
			$total_amount += (float)str_replace(',', '',$invoices->amount);
			?>
			<tr>
				<td style="text-align: left!important;"><?php echo $invoices->ref_no; ?></td>
				<td style="text-align: left!important;"><?php echo $invoices->date_invoice; ?></td>
				<td style="text-align: left!important;"><?php echo $invoices->department; ?></td>
				<td style="text-align: left!important;"><?php echo $invoices->customer; ?></td>
				<td style="text-align: left!important;"><?php echo $invoices->remarks; ?></td>
				<td align="right"><?php echo $invoices->amount; ?></td>
			</tr>
			<?php }?>
			<tr>
				<td colspan="5" align="right"><b>Total</b></td>
				<td align="right"><b><?php echo number_format($total_amount,2); ?></b></td>
			</tr>
		</tbody>
	</table>
</body>
</html>