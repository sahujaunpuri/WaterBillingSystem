<html>
<head>
    <title>Inventory Report</title>
    <style>
        body{
            font-family: tahoma;font-size: 11;
        }

        table{

            font-size: 11;
            font-family: tahoma;
        }

        table thead tr td{
            height: 25px;
            background-color: lightgreen;
            font-weight: bold;
            font-size: 12;

        }


        table tfoot tr td{
            background-color: lightgreen;
            font-weight: 400;
        }

        td{
 
            padding-left: 5px;
            padding-right: 3px;
            height: 20px;
        }


    </style>

    <!-- <script>
        $(document).ready(function(){
            window.print();
        });

        window.onload = function () {
    window.print();
}
    </script> -->

    <script type="text/javascript">
        (function(){
            window.print();
        })();
    </script>




</head>

<body>

<div style="">
    <table width="100%" border="0">
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

    <h3 style="margin-bottom: 0px;">Inventory Report - <?php echo $department; ?>
        </h3>
    <i>As of <?php echo $date; ?></i>



    <br /><br />
    <table width="100%" >
        <thead>
            <tr>
                <td width="10%">PLU</td>
                <td width="30%">Description</td>
                <td width="10%">Category</td>
                <td width="5%">Unit</td>
                <td width="10%" align="right">Current Qty</td>
            </tr>
        </thead>
        <tbody>
            <?php foreach($products as $product){ ?>
            <tr>
                <td><?php echo $product->product_code; ?></td>
                <td><?php echo $product->product_desc; ?></td>
                <td><?php echo $product->category_name; ?></td>
                <td><?php echo $product->parent_unit_name; ?></td>
                <td align="right"><?php echo number_format($product->CurrentQty,2); ?></td>
            </tr>
            <?php } ?>


            <?php if(count($products)==0){ ?>
                <tr>
                    <td colspan="5" style="height: 40px;"><center>No records found.</center></td>
                </tr>
            <?php } ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5">&nbsp;</td>

            </tr>
        </tfoot>
    </table>



</div>




</body>
</html>