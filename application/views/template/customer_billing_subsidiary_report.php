<!DOCTYPE html>
<html>
<head>
	<title>Customer Billing Subsidiary Report</title>
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
            border-top: 3px solid #404040;
        }
    </style>
</head>
<body>
	<table width="100%">
        <tr>
            <td width="10%" style="object-fit: cover;"><img src="<?php echo $company_info->logo_path; ?>" style="height: 90px;width: 90px; text-align: left;"></td>
            <td width="90%" class="align-center">
                <h1 class="report-header"><strong><?php echo $company_info->company_name; ?></strong></h1>
                <p><?php echo $company_info->company_address; ?></p>
                <p><?php echo $company_info->landline.'/'.$company_info->mobile_no; ?></p><br>
                <h3>PERIOD : <?php echo '<strong>'.$_GET['startDate'].'</strong> to <strong>'.$_GET['endDate'].'</strong>'; ?></h3>
            </td>
        </tr>
    </table><hr>
    <div class="">
        <h3 class="report-header"><strong>CUSTOMER BILLING SUBSIDIARY REPORT</strong></h3>
    </div>
     <table width="100%" cellspacing="-1">
        <tr>
        	<td style="padding: 4px;" width="50%"><strong>Account No: </strong><?php echo $account_subsidiary->account_no; ?></td>
        </tr>
        <tr>
            <td style="padding: 4px;" width="50%"><strong>Customer: </strong><?php echo $account_subsidiary->receipt_name; ?></td>
        </tr>
    </table><br>
    <table width="100%" cellspacing="-1">
    	<thead>
            <tr>
                <th style="border: 1px solid gray;text-align: center;height: 30px;padding: 6px;">Txn Date</th>
                <th style="border: 1px solid gray;text-align: left;height: 30px;padding: 6px;">Reference #</th>
                <th style="border: 1px solid gray;text-align: left;height: 30px;padding: 6px;">Transaction</th>
                <th style="border: 1px solid gray;text-align: right;height: 30px;padding: 6px;">Fee</th>
                <th style="border: 1px solid gray;text-align: right;height: 30px;padding: 6px;">Payment</th>
                <th style="border: 1px solid gray;text-align: right;height: 30px;padding: 6px;">Balance</th>
            </tr>
        </thead>
        <tbody>
        	<?php foreach($subsidiary_info as $items) { ?>
        	<tr>
        		<td style="border: 1px solid gray;text-align: left;height: 20px;padding: 6px;"><?php echo $items->date_txn; ?></td>
        		<td style="border: 1px solid gray;text-align: left;height: 20px;padding: 6px;"><?php echo $items->ref_no; ?></td>
        		<td style="border: 1px solid gray;text-align: left;height: 20px;padding: 6px;"><?php echo $items->transaction; ?></td>
        		<td style="border: 1px solid gray;text-align: right;height: 20px;padding: 6px;"><?php echo number_format($items->fee,2); ?></td>
        		<td style="border: 1px solid gray;text-align: right;height: 20px;padding: 6px;"><?php echo number_format($items->payment,2); ?></td>
        		<td style="border: 1px solid gray;text-align: right;height: 20px;padding: 6px;"><?php echo number_format($items->balance,2); ?></td>
    		</tr>
    		<?php } ?>
        </tbody>
    </table>

    <br>
    <span style="font-size: 8pt;">
        Printed Date : <?php echo date('m/d/Y h:i a'); ?><br>
        Printed by : <?php echo $user; ?> <br>
    </span>
</html>