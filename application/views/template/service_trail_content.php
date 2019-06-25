<head><title>Service Trail</title></head>
<body>
<style>
    @page {
      /*size: 8.5in 11in!important;*/
      margin: 8px!important;
    }
    table{
    	border-collapse: collapse;
        border:none!important;
        font-size: 11px;
        font-family: Calibri;
    }
    td{
        padding: 0px!important;
        margin: 0px!important; 
        padding: 2px;
    }
    th{
    	border-bottom: 1px solid black;
    }
    .t_content td{
    	border-bottom: 1px solid lightgray;
    }
    .t_content th{
    	text-align: left;
    }
</style>

<div>
<table width="100%" class="nohover" >
        <tr>
            <td  class="bottom-only" width="10%" style="object-fit: cover;"><img src="<?php echo $company_info->logo_path; ?>" style="height: 90px; width: 90px; text-align: left;"></td>
            <td class="bottom-only" width="90%" class="">
                <h1 class="report-header"><strong><?php echo $company_info->company_name; ?></strong></h1>
                <p><?php echo $company_info->company_address; ?></p>
                <p><?php echo $company_info->landline.'/'.$company_info->mobile_no; ?></p>
                <span><?php echo $company_info->email_address; ?></span><br>

            </td>
        </tr>
    </table><hr>	
	<table width="100%">
		<tr>
			<td><h2 style="text-transform: uppercase;">Service Trail</h2></td>
		</tr>
	</table>

	<table width="100%">
		<tr>
			<td>Transaction Type: <?php echo $trans_type; ?></td>
			<td>From Date: <?php echo $start_date; ?></td>
			<td align="right">Date Printed: <?php echo date('m/d/Y h:i:s'); ?></td>
		</tr>
		<tr>
			<td>Record Type : <?php echo $trans_key; ?></td>
			<td>To Date: <?php echo $end_date; ?></td>
			<td align="right">Printed by : <?php echo $user; ?></td>
		</tr>
		<tr>
			<td>Service No : <?php echo $service_no; ?></td>
			<td>User Account : <?php echo $user; ?></td>
			<td></td>
		</tr>
	</table>
</div>
<hr>
<table class="t_content" width="100%" cellpadding="5">
	<thead>
		<tr>
			<th>Transaction Date</th>
			<th>Transaction Type</th>
			<th>Record Type</th>
			<th width="10%">Service No</th>
			<th width="10%">Account No</th>
			<th width="15%">Customer Name</th>
			<th>Meter Serial</th>
			<th>Log Description</th>
			<th>User</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			if (count($history)){
			foreach($history as $row){?>
			<tr>
				<td><?php echo $row->trans_date;?></td>
				<td><?php echo $row->trans_type_desc;?></td>
				<td><?php echo $row->trans_key_desc;?></td>
				<td><?php echo $row->service_no;?></td>
				<td><?php echo $row->account_no;?></td>
				<td><?php echo $row->customer_name;?></td>
				<td><?php echo $row->serial_no;?></td>
				<td><?php echo $row->trans_log;?></td>
				<td><?php echo $row->user_fname.' '.$row->user_lname;?></td>
			</tr>
		<?php }}else{?>
			<tr>
				<td colspan="9">
					<center>No Data Available</center>
				</td>
			</tr>
		<?php }?>
	</tbody>
</table>
















