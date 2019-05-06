<head>  <title>Supplier Masterfile </title></head>
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
    <h2>Supplier Masterfile</h2>
        <table width="100%" style="border-collapse: collapse;border-spacing: 0;font-family: tahoma;font-size: 11" id="tbl_supplier">
            <thead>
            <tr>
                <th>Company Name</th>
                <th>TIN</th>
                <th width="20%">Address</th>
                <th>Contact Person</th>
                <th>Contact No</th>
                <th>Email</th>
                <th width="5%">Tax</th>
            </tr>
            </thead>
            <tbody>
            
            <?php foreach ($suppliers as $supplier) { ?>
            <tr>
                <td><?php echo $supplier->supplier_name ?></td>
                <td><?php echo $supplier->tin_no ?></td>
                <td><?php echo $supplier->address ?></td>
                <td><?php echo $supplier->contact_person ?></td>
                <td><?php echo $supplier->contact_no ?></td>
                <td><?php echo $supplier->email_address ?></td>
                <td><?php echo $supplier->tax_type ?></td>
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













