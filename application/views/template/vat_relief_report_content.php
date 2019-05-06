<!DOCTYPE html>
<html>
<head>
	<title>VAT Relief Report</title>
	<style>
		body {
			font-family: 'Segoe UI',sans-serif;
			font-size: 12px;
		}
		table, th, td { border-color: white; }
		tr { border-bottom: none !important; }

		.report-header {
			font-size: 22px;
		}
        @media print {
      @page { margin: 0; }
      body { margin: 1.0cm; }
}
	</style>
	<script>
		(function(){
			window.print();
		})();
	</script>
</head>
<body>
       <table width="100%">
        <tr>
            <td width="10%" style="object-fit: cover;"><img src="<?php echo base_url().$company_info->logo_path; ?>" style="height: 90px; width: 90px; text-align: left;"></td>
            <td width="90%" class="">
                <span style="font-size: 20px;" class="report-header"><strong><?php echo $company_info->company_name; ?></strong></span><br>
                <span><?php echo $company_info->company_address; ?></span><br>
                <span><?php echo $company_info->landline.'/'.$company_info->mobile_no; ?></span><br>
                <span><?php echo $company_info->email_address; ?></span>
            </td>
        </tr>
    </table><hr>
    <div>
        <h3><strong>VAT RELIEF REPORT</strong></h3>
    </div>
    <?php foreach($suppliers as $supplier) { ?>
    			
    <table width="100%" cellpadding="3" cellspacing="0" border="1">
    	<thead>
    		<tr>
				<td colspan="5"><strong>SUPPLIER : </strong><?php echo $supplier->supplier_name; ?></strong></td>
				<td colspan="2"><strong> TIN # :</strong> <?php echo $supplier->tin_no; ?></strong></td>
			</tr>
    		<th width="25%" align="left">Invoice / OR #</th>
            <th width="10%" align="left">Reference #</th>
    		<th width="10%" align="right">Invoice Amount</th>
            <th width="10%" align="right">Non Vatable</th>
    		<th width="10%" align="right">Vatable</th>

            <th width="10%" align="right">VAT Input</th>
            <th width="10%" align="right">Net of VAT</th>
    	</thead>
    	<tbody>
    		<?php 
                
                $sum_vatable_amount=0; 
                $sum_non_vatable=0;
	    		$sum_invoice_amt=0; 
	    		$sum_vat_input=0;
	    		$sum_net_vat=0; 
    		?>
    		<?php foreach($vat_reliefs as $vat_relief) { ?>
    			<?php if ($supplier->supplier_id == $vat_relief->supplier_id) { ?>
    			<tr>
    				<td ><?php echo $vat_relief->dr_invoice_no; ?></td>
                    <td ><?php echo $vat_relief->external_ref_no; ?></td>
                    <td  align="right"><?php echo number_format($vat_relief->total_after_tax,2); ?></td>
                    <td  align="right"><?php echo number_format($vat_relief->invoice_non_vat,2); ?></td>
    				<td  align="right"><?php echo number_format($vat_relief->dr_taxable,2); ?></td>
    				<td  align="right"><?php echo number_format($vat_relief->total_tax_amount,2); ?></td>
    				<td  align="right"><?php echo number_format($vat_relief->net_of_vat,2); ?></td>
    			</tr>
    			<?php 
                    $sum_vatable_amount+=$vat_relief->dr_taxable;
                    $sum_non_vatable+=$vat_relief->invoice_non_vat;
    				$sum_invoice_amt += $vat_relief->total_after_tax; 
    				$sum_vat_input += $vat_relief->total_tax_amount;
    				$sum_net_vat += $vat_relief->net_of_vat;
    			?>
    			<?php } ?>
    		<?php } ?>
			<tr>
				<td  colspan=2><strong>TOTAL :</strong></td>
                <td  align="right"><?php echo number_format($sum_invoice_amt,2) ?></td>
                <td  align="right"><?php echo number_format($sum_non_vatable,2) ?></td>
				<td  align="right"><?php echo number_format($sum_vatable_amount,2) ?></td>
				<td  align="right"><?php echo number_format($sum_vat_input,2) ?></td>
				<td  align="right"><?php echo number_format($sum_net_vat,2) ?></td>
			</tr>
    	</tbody>
    </table>

	<?php } ?>
</body>
</html>