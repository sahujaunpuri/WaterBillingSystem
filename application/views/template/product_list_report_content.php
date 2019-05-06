<!DOCTYPE html>
<html>
<head>
	<title>Product List Report</title>
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
        .right-align{
            text-align: right;
        }
        @media print {
      @page { margin: 0; size: landscape; }
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
        <h3><strong>Product List Report</strong></h3>
    </div>

    			
    <table width="100%" cellpadding="3" cellspacing="0" border="1" style="font-size: 9px;">
    	<thead>
            <th>PLU</th>
            <th>Product Description</th>
            <th>Other Description</th>
            <th>Category</th>
            <th>Supplier</th>
            <th>Unit</th>
            <th>Item Type</th>
            <th>Tax Type</th>
            <th>Purchase Cost</th>
            <th>Sale Price </th>
            <th>Warning QTY </th>
            <th>Ideal Qty</th>
            <th>Discounted Price</th>
            <th>Dealer Price</th>
            <th>Distributor Price</th>
            <th>Public Price</th>
    	</thead>
    	<tbody>
         <?php 

         foreach ($data as $data) { ?>
         <tr>
             <td><?php echo $data->product_code; ?></td>
             <td><?php echo $data->product_desc; ?></td>
             <td><?php echo $data->product_desc1; ?></td>
             <td><?php echo $data->category_name; ?></td>
             <td><?php echo $data->supplier_name; ?></td>
             <td><?php echo $data->parent_unit_name; ?></td>
             <td><?php echo $data->item_type; ?></td>
             <td><?php echo $data->tax_rate; ?></td>
             <td class="right-align"><?php echo number_format($data->purchase_cost,2);  ?></td>
             <td class="right-align"><?php echo number_format($data->sale_price,2);  ?></td>
             <td class="right-align"><?php echo number_format($data->product_warn,2);  ?></td>
             <td class="right-align"><?php echo number_format($data->product_ideal,2);  ?></td>
             <td class="right-align"><?php echo number_format($data->discounted_price,2);  ?></td>
             <td class="right-align"><?php echo number_format($data->dealer_price,2);  ?></td>
             <td class="right-align"><?php echo number_format($data->distributor_price,2);  ?></td>
             <td class="right-align"><?php echo number_format($data->public_price,2);  ?></td>
         </tr>
        
        <?php } ?>   
        </tbody>
    </table>


</body>
</html>