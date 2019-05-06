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
    <table width="100%">
    	<tr>
    		<td colspan="2"><b>QuarterlyPercentage Tax Return Details</b></td>
    	</tr>
    	<tr>
    		<td width="15%"><b>Quarter :</b> </td>
    		<td width="35%"><?php echo $q_info->quarter; ?></td>
    		<td width="25%"><b>Taxable Amount : </b></td>
    		<td width="25%"><?php echo $q_info->taxable_amount; ?></td>
    	</tr>
    	<tr>
    		<td width="15%"><b>Year :</b></td>
    		<td><?php echo $q_info->year;?></td>
    		<td width="15%"><b>Tax Rate :</b></td>
    		<td><?php echo number_format($q_info->tax_rate,0); ?>%</td>    		
    	</tr>
    	<tr>
    		<td width="15%"><b>Tax Due :</b></td>
    		<td><?php echo $q_info->tax_due; ?></td>
    	</tr>
    </table>
    <hr/>

	<table class="table table-striped" cellspacing="0" cellpadding="3" width="100%" style="margin-top: 10px;">
		<thead>
			<tr>
				<th style="text-align: left;border-bottom: 1px solid black;">Month</th>
				<th style="text-align: left;border-bottom: 1px solid black;">Reference #</th>
				<th style="text-align: left;border-bottom: 1px solid black;">Invoice Date</th>
				<th style="text-align: left;border-bottom: 1px solid black;">Department</th>
				<th style="text-align: left;border-bottom: 1px solid black;">Customer</th>
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
				<td style="text-align: left!important;font-size: 10pt;"><?php echo $invoices->months; ?></td>
				<td style="text-align: left!important;font-size: 10pt;"><?php echo $invoices->ref_no; ?></td>
				<td style="text-align: left!important;font-size: 10pt;"><?php echo $invoices->date_invoice; ?></td>
				<td style="text-align: left!important;font-size: 10pt;"><?php echo $invoices->department; ?></td>
				<td style="text-align: left!important;font-size: 10pt;"><?php echo $invoices->customer; ?></td>
				<td align="right" style="font-size: 10pt;"><?php echo $invoices->amount; ?></td>
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