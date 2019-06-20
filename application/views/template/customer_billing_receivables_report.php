<!DOCTYPE html>
<html>
<head>
	<title>Customer Billing Receivables Report</title>
    <link rel="icon" href="<?php echo base_url('assets/img/companyico.ico'); ?>" type="image/ico" sizes="16x16">
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

        .data {
            border-bottom: 1px solid #404040;
        }

        .align-center {
            text-align: center;
        }

        .report-header {
            font-weight: bolder;
        }

        hr {
            border-top: 1px solid #404040;
        }
        table{
            border-collapse: collapse;
        }
    </style>
</head>
<body>
	<table width="100%">
        <tr>
            <td width="10%" style="object-fit: cover;"><img src="<?php echo $company_info->logo_path; ?>" style="height: 90px;width: 90px; text-align: left;"></td>
            <td width="90%">
                <h1 class="report-header"><strong><?php echo $company_info->company_name; ?></strong></h1>
                <p><?php echo $company_info->company_address; ?></p>
                <p><?php echo $company_info->landline.'/'.$company_info->mobile_no; ?></p><br>
            </td>
        </tr>
    </table><hr>
    <table width="100%" style="border-collapse: collapse;">
        <tr>
            <td><h3 class="report-header"><strong>CUSTOMER BILLING RECEIVABLES</strong></h3></td>
            <td align="right">Date : <?php echo date('m/d/Y'); ?></td>
        </tr>
    </table>
    <br>
    <table width="100%" cellspacing="5" cellpadding="3" style="border-collapse: collapse;font-size: 9pt!important;">
    	<thead>
            <tr>
                <?php if($type_id == 1){ ?> <th style="text-align: left;border-bottom: 1px solid black;">Account #</th> <?php }?>
                <th style="text-align: left;border-bottom: 1px solid black;">Customer</th>
                <th style="text-align: left;border-bottom: 1px solid black;">Address</th>
                <th style="text-align: right;border-bottom: 1px solid black; ">Fees</th>
                <th style="text-align: right;border-bottom: 1px solid black; ">Payments</th>
                <th style="text-align: right;border-bottom: 1px solid black; ">Balance</th>
            </tr>
        </thead>
        <tbody>
        	<?php 
            $total_receivable_amount = 0;
            foreach($receivables as $receivable) { 
            $total_receivable_amount += $receivable->balance;
            ?>
        	<tr>
                <?php if($type_id == 1){ ?> <td><?php echo $receivable->account_no; ?></td> <?php }?>
        		<td><?php echo $receivable->customer_name; ?></td>
        		<td><?php echo $receivable->address; ?></td>
        		<td style="text-align: right;"><?php echo number_format($receivable->fee,2); ?></td>
        		<td style="text-align: right;"><?php echo number_format($receivable->payment,2); ?></td>
        		<td style="text-align: right;"><b><?php echo number_format($receivable->balance,2); ?></b></td>
    		</tr>
    		<?php } ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="<?php if($type_id == 1){ echo '5'; }else{ echo '4'; }?>" align="right" style="border-top: 1px solid lightgray;"><b>Total: </b></td>
                <td align="right" style="border-top: 1px solid lightgray;"><b><?php echo number_format($total_receivable_amount,2); ?></b></td>
            </tr>
        </tfoot>
    </table>
</html>