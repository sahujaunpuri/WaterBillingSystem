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
            /*border-top: 3px solid #404040;*/
        }

        tr {
  /*          border: none!important;*/
        }

        tr:nth-child(even){
          
       /*     border: none!important;*/
        }
/*
        tr:hover {
            transition: .4s;
            background: #414141 !important;
            color: white;
        }

        tr:hover .btn {
            border-color: #494949!important;
            border-radius: 0!important;
            -webkit-box-shadow: 0px 0px 5px 1px rgba(0,0,0,0.75);
            -moz-box-shadow: 0px 0px 5px 1px rgba(0,0,0,0.75);
            box-shadow: 0px 0px 5px 1px rgba(0,0,0,0.75);
        }*/
            table{
        border:none!important;
    }
    </style> <table width="100%" border="0">
        <tr>
            <td width="10%" style="object-fit: cover;"><img src="<?php echo $company_info->logo_path; ?>" style="height: 90px; width: 90px; text-align: left;"></td>
            <td width="90%" class="">
                <h1 class="report-header"><strong><?php echo $company_info->company_name; ?></strong></h1>
                <p><?php echo $company_info->company_address; ?></p>
                <p><?php echo $company_info->landline.'/'.$company_info->mobile_no; ?></p>
                <p><?php echo $company_info->email_address; ?></p>
            </td>
        </tr>
    </table><hr>
<table id="main" style="border:none!important;">
	<tr>
		<td style="border: 0px !important;background:transparent !important;"><h3>Customer Name : <?php echo $customers; ?></h3></td>
	</tr>
	<tr>
		<td style="border: 0px !important;background: transparent !important;"><h3>Date : <?php echo $tempfrom." To ".$tempto; ?></h3></td>
	</tr>
</table>

<table class="table" style="width:100%;" class="table table-striped">
	<thead style="">
	<tr>
		<th style="width:30%;text-align:left;">Invoice</th>
		<th style="width:40%;text-align:left;">Remarks</th>
		<th style="width:30%;text-align:left;">Amount Due</th>
	</tr>
	</thead>
	<tbody>
		<?php foreach($receivables as $item){ ?>
		    <tr>
		        <td style="width:30%;"><?php echo $item->sales_inv_no; ?></td>
		        <td style="width:40%;"><?php echo $item->remarks; ?></td>
				<td style="width:30%;"><?php echo number_format($item->net_receivable,2); ?></td>
		    </tr>
		<?php } ?>
	</tbody>
</table>

<style>

</style>