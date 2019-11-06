        <style type="text/css">
    body {
            font-family: 'Calibri',sans-serif;
            font-size: 12px;
    }

@media print {
      @page { size: landscape; }
}
.left {border-left: 1px solid black;}
.right{border-right: 1px solid black;}
.bottom{border-bottom: 1px solid black;}
.top{border-top: 1px solid black!important;}

.fifteen{ width: 15%; }
.text-center{text-align: center;}
.text-right{text-align: right;}
.text-left{text-align: left;}
</style>
    <table width="100%">
        <tr>
            <td width="10%" style="object-fit: cover;"><img src="<?php echo base_url($company_info->logo_path); ?>" style="height: 90px; width: 90px; text-align: left;"></td>
            <td width="90%" class="">
                <h3 class="report-header"><strong><?php echo $company_info->company_name; ?></strong></h3>
                <p><?php echo $company_info->company_address; ?></p>
                <p><?php echo $company_info->landline.'/'.$company_info->mobile_no; ?></p>
                <p><?php echo $company_info->email_address; ?></p>
            </td>
        </tr>
    </table><hr>
    <div class="">
        <h3 class="report-header"><strong>Certificate of Creditable Tax Report -  <?php echo $_GET['year'];  ?></strong></h3>
    </div>
<table id="tbl_2307" class="table table-striped" cellspacing="5" width="100%">
    <thead>
        <tr>
            <th class="text-left">Txn No.</th>
            <th class="text-left">Date</th>
            <th class="text-left">Supplier</th>
            <th style="text-align: right;">Gross Amount</th>
            <th style="text-align: right;">Tax Amount</th>
            <th class="text-left">Remarks</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($items as $item) { ?>
        <tr>

            <td><?php echo $item->txn_no; ?></td>
            <td><?php echo $item->month_name; ?></td>
            <td><?php echo $item->payee_name; ?></td>
            <td class="text-right"><?php echo $item->gross_amount; ?></td>
            <td class="text-right"><?php echo $item->deducted_amount; ?></td>
            <td><?php echo $item->remarks; ?></td>
        </tr>
    <?php } ?>
    </tbody>
</table>
