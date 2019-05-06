<!DOCTYPE html>
<html>
<head>
	<title>Purchase Monitoring</title>
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
            <td width="10%"><img src="<?php echo base_url().$company_info->logo_path; ?>" style="height: 90px; width: 120px; text-align: left;"></td>
            <td width="90%" class="">
                <span style="font-size: 20px;" class="report-header"><strong><?php echo $company_info->company_name; ?></strong></span><br>
                <span><?php echo $company_info->company_address; ?></span><br>
                <span><?php echo $company_info->landline.'/'.$company_info->mobile_no; ?></span><br>
                <span><?php echo $company_info->email_address; ?></span>
            </td>
        </tr>
    </table><hr>
    <div>
        <h3><strong>Purchase Monitoring</strong></h3>
    </div>
        <span style="font-weight: bolder;">Product: </span>   <?php echo $product_name;?> <br>
        <span style="font-weight: bolder;">Date Range: </span>   <?php echo date( "F d, Y", strtotime($start_date) );?> - <?php echo date( "F d, Y", strtotime($end_date) );?>
     <table width="100%" cellpadding="3" cellspacing="0" border="1">
    	<thead>
            <th>PLU</th>
            <th>Product Description</th>
            <th>Unit</th>
            <th>Price</th>
            <th>Supplier</th>
            <th>Date Invoice</th>
            <th>Reference No</th>
    	</thead>
    	<tbody>
         <?php 

         foreach ($data as $data) { ?>
         <tr>
             <td><?php echo $data->product_code; ?></td>
             <td><?php echo $data->product_desc; ?></td>
             <td><?php echo $data->unit_name; ?></td>             
             <td><?php echo $data->dr_price; ?></td>
             <td><?php echo $data->supplier_name; ?></td>
             <td class="right-align"><?php echo $data->date_delivered;  ?></td>
             <td class="right-align"><?php echo $data->dr_invoice_no; ?></td>
         </tr>
        
        <?php } ?>   
        </tbody>
    </table>


</body>
</html>