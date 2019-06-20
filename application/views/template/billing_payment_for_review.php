<style>

    table.table_journal_entries_review td {
        border: 0px !important;
    }
    tr {
        border: none!important;
    }

</style>
<center>
    <table class="table_journal_entries_review"  width="97%" style="font-family: tahoma;">
        <tbody style="border: none!important;">
        <tr>
            <td>
                <br />
                <div class="tab-container tab-default" >
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#journal_review_<?php echo $batch_info->billing_payment_batch_id    ; ?>" data-toggle="tab"><i class="fa fa-gavel"></i> Review Journal</a></li>
                        <li class=""><a href="#payment_review_<?php echo $batch_info->billing_payment_batch_id; ?>" data-toggle="tab"><i class="fa fa-folder-open-o"></i> Payment</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="journal_review_<?php echo $batch_info->billing_payment_batch_id; ?>" data-parent-id="<?php echo $batch_info->billing_payment_batch_id; ?>" style="min-height: 300px;">
                            <form id="frm_journal_review" role="form" class="form-horizontal row-border">
                                <br />
                                <input type="hidden" name="billing_payment_batch_id" value="<?php echo $batch_info->billing_payment_batch_id; ?>">
                                <input type="hidden" name="ref_no" value="<?php echo $batch_info->batch_code;?>">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <div style="border: 1px solid lightgrey;padding: 2%;border-radius: 5px;">
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    Txn # * :<br />
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </span>
                                                        <input type="text" name="txn_no" class="form-control" value="TXN-YYYYMMDD-XXX" readonly>
                                                    </div>
                                                </div><br />
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-7">
                                                    Customer * :<br />
                                                    <select name="customer_id" class="cbo_customer_list">
                                                        <?php foreach($customers as $customer){ ?>
                                                            <option value="<?php echo $customer->customer_id; ?>" <?php echo ($account_integration->billing_customer_id===$customer->customer_id?'selected':''); ?>><?php echo $customer->customer_name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="col-lg-4 col-lg-offset-1">
                                                    Date * :<br />
                                                    <div class="input-group">
                                                        <input type="text" name="date_txn" class="date-picker  form-control" value="<?php echo date("m/d/Y"); ?>">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </span>
                                                    </div>
                                                </div><br />
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-7">
                                                    Branch * :<br />
                                                    <select name="department_id" class="cbo_department_list">
                                                        <?php foreach($departments as $department){ ?>
                                                            <option value="<?php echo $department->department_id; ?>" <?php echo ($account_integration->billing_department_id===$department->department_id?'selected':''); ?>><?php echo $department->department_name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div style="border: 1px solid lightgrey;padding: 4%;border-radius: 5px;">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    Method of Payment * :<br />
                                                    <select name="payment_method" class="cbo_payment_method">
                                                        <?php foreach($methods as $method){ ?>
                                                            <option value="<?php echo $method->payment_method_id; ?>" ><?php echo $method->payment_method; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    OR # * :<br />
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-code"></i>
                                                        </span>
                                                        <input type="text" name="or_no" class="form-control" value="">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    Amount* :<br />
                                                    <input type="text" name="amount" class="numeric form-control" value="<?php echo number_format($batch_info->batch_total_paid_amount,2); ?>">
                                                </div>
                                            </div>
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        Check Date :<br />
                                                        <div class="input-group">
                                                            <input type="text" name="check_date" class="date-picker form-control" value="">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-calendar"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        Check # :<br />
                                                        <input type="text" name="check_no" class="form-control" value="">
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                                <h4><span style="margin-left: 1%"><strong><i class="fa fa-gear"></i> Journal Entries</strong></span></h4>
                                <hr />
                                <table id="tbl_entries_for_review_<?php echo $batch_info->billing_payment_batch_id; ?>" class="table table-striped" style="width: 100% !important;">
                                    <thead>
                                    <tr style="border-bottom:solid gray;">
                                        <th style="width: 30%;">Account</th>
                                        <th style="width: 30%;">Memo</th>
                                        <th style="width: 15%;text-align: right;">Dr</th>
                                        <th style="width: 15%;text-align: right;">Cr</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $dr_total=0.00; $cr_total=0.00;
                                    foreach($entries as $entry){
                                        ?>
                                        <tr>
                                            <td>
                                                <select name="accounts[]" class="selectpicker show-tick form-control selectpicker_accounts" data-live-search="true" >
                                                    <?php foreach($accounts as $account){ ?>
                                                        <option value='<?php echo $account->account_id; ?>' <?php echo ($entry->account_id==$account->account_id?'selected':''); ?> ><?php echo $account->account_title; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                            <td><input type="text" name="memo[]" class="form-control"  value="<?php echo $entry->memo; ?>"></td>
                                            <td><input type="text" name="dr_amount[]" class="form-control numeric" value="<?php echo number_format($entry->dr_amount,2); ?>"></td>
                                            <td><input type="text" name="cr_amount[]" class="form-control numeric"  value="<?php echo number_format($entry->cr_amount,2);?>"></td>
                                            <td>
                                                <button type="button" class="btn btn-default add_account"><i class="fa fa-plus-circle" style="color: green;"></i></button>
                                                <button type="button" class="btn btn-default remove_account"><i class="fa fa-times-circle" style="color: red;"></i></button>
                                            </td>
                                        </tr>
                                        <?php
                                        $dr_total+=$entry->dr_amount;
                                        $cr_total+=$entry->cr_amount;
                                    }
                                    ?>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td colspan="2" align="right"><strong>Total</strong></td>
                                        <td align="right"><strong><?php echo number_format($dr_total,2); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($cr_total,2); ?></strong></td>
                                        <td></td>
                                    </tr>
                                    </tfoot>
                                </table>
                                <hr />
                                <label class="col-lg-2"> Remarks :</label><br />
                                <div class="col-lg-12">
                                    <textarea name="remarks" class="form-control" style="width: 100%;"></textarea>
                                </div>
                                <br /><hr />
                            </form>
                            <br /><br /><hr />
                            <div class="row">
                                <div class="col-lg-12">
                                    <button name="btn_finalize_journal_review" class="btn btn-primary"><i class="fa fa-check-circle"></i> <span class=""></span> Finalize and Post this Journal</button>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="payment_review_<?php echo $batch_info->billing_payment_batch_id; ?>" >
                            <h4><span style="margin-left: 1%"><strong><i class="fa fa-bars"></i> Payment Transaction</strong></span></h4>
                            <hr />
                            <div style="margin-left: 2%">
                                <table id="tbl_payments" class="table table-striped" cellspacing="0" width="100%">
                                    <thead class="">
                                    <tr>
                                        <th>Receipt #</th>
                                        <th>Customer</th>
                                        <th>Account No</th>
                                        <th>Method</th>
                                        <th style="text-align: right;">Amount Payment</th>
                                        <th style="text-align: right;">Deposit Payment</th>
                                        <th style="text-align: right;">Total Payment</th>
                                        <th style="text-align: right;">Refund</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $total_batch = 0;  $total_refund = 0;
                                    foreach ($billing_payments_info as $binfo) { ?>
                                        <tr>
                                            <td><?php echo $binfo->receipt_no ?></td>
                                            <td><?php echo $binfo->customer_name ?></td>
                                            <td><?php echo $binfo->account_no ?></td>
                                            <td><?php echo $binfo->payment_method ?></td>
                                            <td style="text-align: right;"><?php echo number_format($binfo->total_payment_amount,2) ?></td>
                                            <td style="text-align: right;"><?php echo number_format($binfo->total_deposit_amount,2) ?></td>
                                            <td style="text-align: right;"><?php echo number_format($binfo->total_paid_amount,2) ?></td>
                                            <td style="text-align: right;"><?php echo number_format($binfo->refund_amount,2); $total_refund += $binfo->refund_amount;?></td>
                                        </tr>
                                    <?php $total_batch += $binfo->total_paid_amount; } ?>
                                    <tr>
                                        <td colspan="6" style="text-align: right;"><b>Total:</b></td>
                                        <td style="text-align: right;"><b><?php echo number_format($total_batch,2) ?></b></td>
                                        <td style="text-align: right;"><b><?php echo number_format($total_refund,2) ?></b></td>
                                    </tr>
                                    </tbody>
                                </table>
                                <br /><br />
                            </div>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
        </tbody>
    </table>
</center>