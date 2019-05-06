<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<div style="margin-bottom: 20px!important;">
		<div style="float: left;font-size: 9pt;">
			<b>Quarter : </b> <?php echo $q_info->quarter; ?><br />
			<b>Year:</b> <?php echo $q_info->year;?><br />
		</div>
		<div style="float: right;font-size: 9pt;">
			<b>Taxable Amount:</b> <?php echo $q_info->taxable_amount; ?><br />
			<b>Tax Rate:</b> <?php echo number_format($q_info->tax_rate,0); ?>%<br />
			<b>Tax Due:</b> <?php echo $q_info->tax_due; ?><br />
		</div>
	</div>

	<table class="table table-striped" cellspacing="0" width="100%" style="margin-top: 10px;">
		<thead>
			<tr>
				<th>Month</th>
				<th>Reference #</th>
				<th>Invoice Date</th>
				<th>Department</th>
				<th>Customer</th>
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
				<td style="text-align: left!important;"><?php echo $invoices->months; ?></td>
				<td style="text-align: left!important;"><?php echo $invoices->ref_no; ?></td>
				<td style="text-align: left!important;"><?php echo $invoices->date_invoice; ?></td>
				<td style="text-align: left!important;"><?php echo $invoices->department; ?></td>
				<td style="text-align: left!important;"><?php echo $invoices->customer; ?></td>
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