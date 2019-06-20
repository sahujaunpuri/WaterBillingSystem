<head>  
    <title>Reconnection Masterfile </title>
    <link rel="icon" href="<?php echo base_url('assets/img/companyico.ico'); ?>" type="image/ico" sizes="16x16">
</head>
<body> <style type="text/css">
        body {
            font-family: 'Calibri',sans-serif;
            font-size: 12px;
        }
        @page {
          size: A4 landscape;
        }
        .align-right {
            text-align: right;
        }

        .align-left {
            text-align: left;
        }

        .align-center {
            text-align: center;
        }

        .report-header {
            font-weight: bolder;
        }
            table{
        border:none!important;
    }
    table-td.left{
        border-left: 1px solid gray!important;
    }
    table-td.right{
        border-left: 1px solid gray!important;
    }
    #tbl_supplier thead tr th {
        border-bottom: 2px solid gray;text-align: left;height: 30px;padding: 6px;
    }
</style>
<div>
    <table width="100%" cellspacing="5" cellspacing="0">
        <tr>
            <td width="10%"  class="bottom"><img src="<?php echo base_url($company_info->logo_path); ?>" style="height: 90px; width: 120px; text-align: left;"></td>
            <td width="90%"  class="bottom" >
                <h1 class="report-header" style="margin-bottom: 0"><strong><?php echo $company_info->company_name; ?></strong></h1>
                <span><?php echo $company_info->company_address; ?></span><br>
                <span><?php echo $company_info->landline.'/'.$company_info->mobile_no; ?></span><br>
                <span><?php echo $company_info->email_address; ?></span><br>

            </td>
        </tr>
    </table>
    <h2>Service Reconnection Masterfile</h2>
        <table width="100%" style="border-collapse: collapse;border-spacing: 0;font-family: tahoma;font-size: 11" id="tbl_supplier">
            <thead>
            <tr>
                <th>#</th>
                <th style="width: 100px;">Reconnection No</th>
                <th style="width: 100px;">Contract No</th>
                <th style="width: 80px;">Service Date</th>
                <th style="width: 80px;">Date Disconnected</th>
                <th>Customer</th>
                <th>Address</th>
                <th>Contract Type</th>
                <th>Rate Type</th>
                <th>Target Connection Date & Time</th>
                <th>New Rate Type</th>
            </tr>
            </thead>
            <tbody>
            
            <?php 
            $i=1;
            foreach ($reconnection as $row) { ?>
            <tr>
                <td><?php echo $i; ?></td> 
                <td><?php echo $row->reconnection_code ?></td>
                <td><?php echo $row->disconnection_code ?></td>
                <td><?php echo $row->service_date ?></td>
                <td><?php echo $row->date_disconnection_date ?></td>
                <td><?php echo $row->customer_name ?></td>
                <td><?php echo $row->address ?></td>
                <td><?php echo $row->contract_type_name ?></td>
                <td><?php echo $row->rate_type_name ?></td>
                <td><?php echo $row->date_connection_target.' '.$row->time_connection_target ?></td>
                <td><?php echo $row->new_rate_type ?></td>
            </tr>
            <?php $i++;} ?>

            </tr>
            </tbody>
            <tfoot>
            </tfoot>
        </table><br /><br />
    </center>
</div>
<script type="text/javascript">
    window.print();
</script>













