<head>  <title>Meter Inventory Masterfile </title></head>
<body> <style type="text/css">
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
    #tbl_masterfile thead tr th {
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
    <h2>Meter Inventory Masterfile</h2>
        <table width="100%" style="border-collapse: collapse;border-spacing: 0;font-family: tahoma;font-size: 11pt;" id="tbl_masterfile">
            <thead>
            <tr>
                <th>Meter Code</th>
                <th>Serial No</th>
                <th>Description</th>
                <th>Current Assignee</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody>
            
            <?php foreach ($inventory as $inventory) { ?>
            <tr>
                <td><?php echo $inventory->meter_code ?></td>
                <td><?php echo $inventory->serial_no ?></td>
                <td><?php echo $inventory->meter_description ?></td>
                <td><?php echo $inventory->customer_name ?></td>
                <td><?php echo $inventory->status_name; ?></td>
            </tr>
            <?php } ?>

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













