<!DOCTYPE html>
<html>
<head>
	<title>Aging of Receivables Report</title>
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
      
        }
        p{
            padding: 0px 0px 0px 0px;
        }
    </style>
    <script type="text/javascript">
    	(function(){
    		window.print();
    	})();
    </script>
</head>
<body>
    <table width="100%" border="0">
        <tr>
            <td width="10%" style="object-fit: cover;"><img src="<?php echo $company_info->logo_path; ?>" style="height: 90px;width: 90px;  text-align: left;"></td>
            <td width="90%" class="">
                <h1 class="report-header"><strong><?php echo $company_info->company_name; ?></strong></h1>
                <p><?php echo $company_info->company_address; ?></p>
                <p><?php echo $company_info->landline.'/'.$company_info->mobile_no; ?></p>
                <p><?php echo $company_info->email_address; ?></p>
            </td>
        </tr>
    </table><hr>
    <td><h2>AGING OF RECEIVABLES REPORT</h2></td>
    <table width="100%" border="1" cellspacing="0">
    	<tr>
    		<td width="30%"><b>Customer Name</b></td>
    		<td width="15%"><b>Current</b></td>
    		<td width="15%"><b>30 Days</b></td>
    		<td width="15%"><b>45 Days</b></td>
    		<td width="15%"><b>60 Days</b></td>
    		<td width="15%"><b>Over 90 Days</b></td>
    	</tr>
    	<tbody>
            <?php $sum_current = 0; $sum_thirty = 0; $sum_fortyfive = 0; $sum_sixty = 0; $sum_ninety = 0; ?>
            <?php foreach($receivables as $receivable) { ?>

                <tr>
                    <td><?php echo $receivable->customer_name; ?></td>
                    <td align="right"><?php echo (number_format($receivable->current,2) == 0 ? '' : number_format($receivable->current,2)); ?></td>
                    <td align="right"><?php echo (number_format($receivable->thirty_days,2) == 0 ? '' : number_format($receivable->thirty_days,2)); ?></td>
                    <td align="right"><?php echo (number_format($receivable->fortyfive_days,2) == 0 ? '' : number_format($receivable->fortyfive_days,2)); ?></td>
                    <td align="right"><?php echo (number_format($receivable->sixty_days,2) == 0 ? '' : number_format($receivable->sixty_days,2)); ?></td>
                    <td align="right"><?php echo (number_format($receivable->over_ninetydays,2) == 0 ? '' : number_format($receivable->over_ninetydays,2)); ?></td>
                </tr>
              <?php $sum_current += $receivable->current; 
                    $sum_thirty += $receivable->thirty_days;
                    $sum_fortyfive += $receivable->fortyfive_days;
                    $sum_sixty += $receivable->sixty_days;
                    $sum_ninety += $receivable->over_ninetydays;
            ?>
            <?php } ?>
            <tr>
                <td></td>
                <td align="right"><?php echo number_format($sum_current,2); ?></td>
                <td align="right"><?php echo number_format($sum_thirty,2); ?></td>
                <td align="right"><?php echo number_format($sum_fortyfive,2); ?></td>
                <td align="right"><?php echo number_format($sum_sixty,2); ?></td>
                <td align="right"><?php echo number_format($sum_ninety,2); ?></td>
            </tr>
    	</tbody>
    </table>
</body>
</html>