<!DOCTYPE html>
<html>
<head>
    <title>Chart of Accounts</title>
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

        .align-center {
            text-align: center;
        }

        .report-header {
            font-weight: bolder;
        }

        tr {
            border: none!important;
        }
    table{
        border:none!important;
    }
    </style>
</head>
<script type="text/javascript">
    
    window.print();
</script>
<body>
    <table width="100%">
        <tr class="row_child_tbl_sales_order">
            <td width="10%"><img src="<?php echo base_url().$company_info->logo_path; ?>" style="height: 100px; width: 100px; text-align: left;"></td>
            <td width="90%" class="">
                <span  style="font-size: 22px;"><strong><?php echo $company_info->company_name; ?></strong></span><br>
                <span><?php echo $company_info->company_address; ?></span><br>
                <span><?php echo $company_info->landline.'/'.$company_info->mobile_no; ?></span><br>
                <span><?php echo $company_info->email_address; ?></span><br>

            </td>
        </tr>
    </table><hr>

<h2 style="text-align: center;">CHART OF ACCOUNTS</h2> 
<?php 
foreach ($types as $type) {
    echo '<b style="text-transform:uppercase;">'.$type->account_type.'</b><br><br>';
    foreach ($classes as $class) {
        if($class->account_type_id == $type->account_type_id){
            echo '<b>'.$class->account_class.'</b><br>';
            foreach ($accounts as $account) {
                if($account->account_class_id == $class->account_class_id){
                echo  $account->account_no.' - '.$account->account_title.'<br>';
                    foreach ($accounts_child as $child) {
                        if($child->parent_account_id == $account->account_id)
                            echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$child->account_no.' - '.$child->account_title.'<br>';
                    }
                }
            }
        }
    }
    echo '<br>';
}
?>
</body>
</html>