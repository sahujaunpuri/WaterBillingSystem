<!DOCTYPE html>
<html>
<head>
	<title>Pick List</title>
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
            <td width="10%"><img src="<?php echo base_url().$company_info->logo_path; ?>" style="height: 90px; width: 90px; text-align: left;"></td>
            <td width="90%" class="">
                <span style="font-size: 20px;" class="report-header"><strong><?php echo $company_info->company_name; ?></strong></span><br>
                <span><?php echo $company_info->company_address; ?></span><br>
                <span><?php echo $company_info->landline.'/'.$company_info->mobile_no; ?></span><br>
                <span><?php echo $company_info->email_address; ?></span>
            </td>
        </tr>
    </table><hr>
    <div>
        <h3><strong>Pick List</strong></h3>
    </div>

    	<span style="font-weight: bolder;">Supplier: </span>   <?php echo $supplier_name;?> <br>
        <span style="font-weight: bolder;">Category: </span>   <?php echo $category_name;?>
     <table width="100%" cellpadding="3" cellspacing="0" border="1">
    	<thead>
            <th>PLU</th>
            <th>Product Description</th>
            <th>Unit</th>
            <th>Category</th>
            <th>Supplier</th>
            <th>Minumum Stock</th>
            <th>Actual Stock</th>
            <th>Recommended Order</th>
    	</thead>
    	<tbody>
         <?php 

         foreach ($data as $data) { ?>
         <tr>
             <td><?php echo $data->product_code; ?></td>
             <td><?php echo $data->product_desc; ?></td>
             <td><?php echo $data->parent_unit_name; ?></td>             
             <td><?php echo $data->category_name; ?></td>
             <td><?php echo $data->supplier_name; ?></td>
             <td class="right-align"><?php echo number_format($data->product_warn,0);  ?></td>
             <td class="right-align"><?php echo number_format($data->CurrentQty,0);  ?></td>
             <td class="right-align"><?php echo number_format($data->recommended_qty,0);  ?></td>
         </tr>
        
        <?php } ?>   
        </tbody>
    </table>


</body>
</html>