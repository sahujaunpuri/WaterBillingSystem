<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<table width="100%" class="nohover">
        <tr>
            <td  class="bottom-only" width="10%" style="object-fit: cover;"><img src="<?php echo $company->logo_path; ?>" style="height: 90px; width: 90px; text-align: left;"></td>
            <td class="bottom-only" width="90%" class="">
                <h1 class="report-header"><strong><?php echo $company->company_name; ?></strong></h1>
                <p><?php echo $company->company_address; ?></p>
                <p><?php echo $company->landline.'/'.$company->mobile_no; ?></p>
                <span><?php echo $company->email_address; ?></span><br>

            </td>
        </tr>
    </table><hr>

    <table style="width: 100%;">
    	<tr>
    		<td colspan="2" style="font-size: 12pt;"><b>Monthly Percentage Tax Return</b> (BIR FORM #2551M)</td>
    	</tr>
    	<tr>
    		<td><b>Month : </b> <?php echo $info->month_name; ?></td>
    		<td><b>Taxable Amount:</b> <?php echo $info->taxable_amount; ?></td>
    	</tr>
    	<tr>
    		<td><b>Year:</b> <?php echo $info->year;?></td>
    		<td><b>Tax Rate:</b> <?php echo number_format($info->tax_rate,0); ?>%</td>
    	</tr>
    	<tr>
    		<td><b>ATC : </b><?php echo $info->atc; ?></td>
    		<td><b>Tax Due:</b> <?php echo $info->tax_due; ?></td>
    	</tr>
    	<tr>
    		<td><b>Industry Classification : </b><?php echo $info->industry_classification; ?></td>
    		<td></td>
    	</tr>
    </table>
    <br>

	<table cellpadding="5" style="border-collapse: collapse;border-spacing: 0;font-family: tahoma;font-size: 11;width: 100%;">
		<thead>
			<tr>
				<th style="text-align: left!important;border-bottom: 1px solid black;">Reference #</th>
				<th style="text-align: left!important;border-bottom: 1px solid black;">Invoice Date</th>
				<th style="text-align: left!important;border-bottom: 1px solid black;">Department</th>
				<th style="text-align: left!important;border-bottom: 1px solid black;">Customer</th>
				<th style="text-align: left!important;border-bottom: 1px solid black;">Remarks</th>
				<th style="text-align: right;border-bottom: 1px solid black;">Amount</th>
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
				<td colspan="5" align="right" style="border-top: 1px solid black;"><b>Total</b></td>
				<td align="right" style="border-top: 1px solid black;"><b><?php echo number_format($total_amount,2); ?></b></td>
			</tr>
		</tbody>
	</table>
</body>
</html>