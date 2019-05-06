<!DOCTYPE html>
<html>
<head>
    <title>General Ledger Report</title>
    <style>
        body {
            font-family: 'Segoe UI',sans-serif;
            font-size: 12px;
        }
        table, th, td { border-color: white; }
        td{
            padding: 5px 5px 5px 5px;
        }
        tr { border-bottom: none !important; }

        .report-header {
            font-size: 22px;
        }
        @media print {
      @page { margin: 0; }
      body { margin: 1.0cm; }
}

    </style>
    <script>
        (function(){
            window.print();
        })();
    </script>
</head>
<body>
    <table width="100%">
        <tr>
            <td width="10%" style="object-fit: cover;"><img src="<?php echo base_url($company_info->logo_path); ?>" style="height: 90px; width: 90px; text-align: left;"></td>
            <td width="90%">
                <span class="report-header"><strong><?php echo $company_info->company_name; ?></strong></span><br>
                <span><?php echo $company_info->company_address; ?></span><br>
                <span><?php echo $company_info->landline.'/'.$company_info->mobile_no; ?></span>
            </td>
        </tr>
    </table><hr>
    <div>
        <h3><strong><center>General Ledger Report</center></strong></h3>
    </div>

    <p><strong>Period Covered:</strong>

    <?php echo date("m-d-Y",strtotime($start)); ?> to <?php echo date("m-d-Y",strtotime($end)); ?></p>
    <p  style="float: right;"> <strong>Run Date:</strong> <?php echo date("m-d-Y");?> </p>

    <?php 
    $total_dr = 0;
    $total_cr = 0;
    foreach ($report_info as $report) { 
    ?>
    <table width="100%" cellpadding="3" cellspacing="0" border="1">
    <tr>
        <td colspan="4">
            <?php 
                $txn_no = ' | <b>Transaction #:</b> '.$report->txn_no ;
                $href_no = ($report->ref_type != '' ? ' | <b>Reference #:</b> '.$report->reference : '');

                $no = $txn_no.' '.$href_no;
            ?>
            <?php echo $report->group_by.' '.$no;?>
        </td>
    </tr>
    <?php if ($report->name != ""){?>
    <tr>
        <td colspan="4"><?php echo '<b>'.$report->title.'</b> '.$report->name;?></td>
    </tr>
    <?php }?>
        <tr>
            <th >Account Code</th>
            <th >Account Title</th>
            <th >DR</th>
            <th >CR </th>
        </tr>
    <tbody>
        <?php foreach ($report_item_info as $report_item) {
             if (($report_item->date_txn == $report->date_txn) AND ($report_item->book_type == $report->book_type) AND ($report_item->name == $report->name) AND ($report_item->txn_no == $report->txn_no)) { 

                $total_dr += $report_item->debit;
                $total_cr += $report_item->credit;

                ?>
            <tr>
                <td width="25%"><?php echo $report_item->account_no; ?> </td> 
                <td width="25%"><?php echo $report_item->account_title; ?> </td>
                <td align="right" width="25%"><?php echo number_format($report_item->debit,2); ?></td>
                <td align="right" width="25%"><?php echo number_format($report_item->credit,2); ?> </td>
            </tr>
        <?php 
        }}?> 

                <td colspan="2" align="right"><strong>TOTAL:</strong> </td>
                <td align="right"><strong><?php echo number_format($total_dr,2); ?></strong></td>
                <td align="right"><strong><?php echo number_format($total_cr,2); ?></strong></td>

        <?php if ($report->remarks != ""){?>
            <tr>
                <td colspan="4">
                    <b>Remarks: </b><?php echo $report->remarks;?>
                </td>
            </tr>
        <?php }?>
        <?php $total_dr = 0;$total_cr = 0;?>
    </tbody>
    </table>
    <br />
    <?php }?>
</body>
</html>