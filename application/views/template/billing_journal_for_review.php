<style>
    table.table_journal_entries_review td {
        border: 0px !important;
    }
    tr {
        border: none!important;
    }
    .right_align{
        text-align: right;
    }
</style>
<center>
<table class="table_journal_entries_review"  width="100%" style="font-family: tahoma;">
<tbody>
<tr>
<td>
<br />
<div class="tab-container tab-top tab-default">
<ul class="nav nav-tabs">
    <li class="active"><a href="#journal_review_<?php echo $billing_info->meter_reading_input_id; ?>" data-toggle="tab"><i class="fa fa-gavel"></i> Review Journal</a></li>
    <li class=""><a href="#purchase_review_<?php echo $billing_info->meter_reading_input_id; ?>" data-toggle="tab"><i class="fa fa-folder-open-o"></i> Transaction</a></li>
</ul>
<div class="tab-content">
<div class="tab-pane active" id="journal_review_<?php echo $billing_info->meter_reading_input_id; ?>" data-parent-id="<?php echo $billing_info->meter_reading_input_id; ?>" style="min-height: 300px;">
    <form id="frm_journal_review" role="form" class="form-horizontal row-border">
    <span class="hidden"><input type="text" name="ref_no" value="<?php echo $billing_info->batch_no; ?>"></span>
        <h4><span style="margin-left: 1%"><strong><i class="fa fa-gear"></i> Billing Information</strong></span></h4>
        <hr />
        <div style="width: 90%;">
            <input type="hidden" name="meter_reading_input_id" value="<?php echo $billing_info->meter_reading_input_id; ?>">
            <label class="col-lg-2"> * Txn # :</label>
            <div class="col-lg-10">
                <input type="text" name="txn_no" class="form-control" style="font-weight: bold;" placeholder="TXN-MMDDYYY-XXX" readonly>
            </div>
            <br /><br />
            <label class="col-lg-2"> * Date :</label>
            <div class="col-lg-10">
                <input type="text" name="date_txn" class="date-picker  form-control" value="<?php echo date("m/d/Y"); ?>">
            </div>
            <br /><br />
            <label class="col-lg-2"> * Customer :</label>
            <div class="col-lg-10">
                <select name="customer_id" class="cbo_customer_list" data-error-msg="Customer is required." required>
                    <?php foreach($customers as $customer){ ?>
                        <option value="<?php echo $customer->customer_id; ?>" <?php echo ($account_integration->billing_customer_id===$customer->customer_id?'selected':''); ?>><?php echo $customer->customer_name; ?></option>
                    <?php } ?>
                </select>
            </div>
            <br /><br />
            <label class="col-lg-2"> * Department :</label>
            <div class="col-lg-10">
                <select name="department_id" class="cbo_department_list" data-error-msg="Branch is required." required>
                    <?php foreach($departments as $department){ ?>
                        <option value="<?php echo $department->department_id; ?>" <?php echo ($account_integration->billing_department_id===$department->department_id?'selected':''); ?>><?php echo $department->department_name; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <br /><br /><br />
        <h4><span style="margin-left: 1%"><strong><i class="fa fa-gear"></i> Journal Entries</strong></span></h4>
        <hr />
        <table id="tbl_entries_for_review_<?php echo $billing_info->meter_reading_input_id; ?>" class="table table-striped" style="width: 100% !important;">
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
                        <select name="accounts[]" class="selectpicker show-tick form-control selectpicker_accounts" data-live-search="true">
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
        <div class="col-sm-6">
            <button name="btn_finalize_journal_review" class="btn btn-primary "><i class="fa fa-check-circle"></i> <span class=""></span> Finalize and Post this Journal</button>
        </div>
        <div class="col-sm-6">
            <div class="input-group" style="float: right;display: none;">
                <input type="text" name="closing_reason" class="form-control" placeholder="Close Notes/Remarks" >
                 <span class="input-group-addon " style="padding: 0px;background-color: #ff0039!important;">
                    <button name="btn_close_journal_review" class="btn btn-danger disabled" title="Click this if you don't want to post this in Accounting, and it will be removed from the list of Pending for Review" style="">Close</button>    
                </span>
            </div>
        </div>
        </div>
    </div>
</div>
<div class="tab-pane" id="purchase_review_<?php echo $billing_info->meter_reading_input_id; ?>" >
    <h4><span style="margin-left: 1%"><strong><i class="fa fa-bars"> </i> <?php echo $billing_info->batch_no; ?> Billing Details</strong></span></h4>
    <hr />
    <div style="margin-left: 2%">
    <table id="tbl_billing" class="table table-striped" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>Control No</th>
            <th style="">Account No</th>
            <th style="">Particular</th>
            <th>Consumption</th>
            <th class="right_align">Meter Charge</th>
            <th class="right_align">Penalty</th>
            <th class="right_align">Other Charges</th>
            <th class="right_align">Total Receivables</th>
        </tr>
    </thead>
    <tbody>
    <?php $batch_total_amount=0;
    $batch_total_amount_due= 0;
    $batch_total_penalty= 0;
    $batch_total_other_charges= 0;
     foreach ($billing_items as $b_item) { ?>
        <tr>
            <td><?php echo $b_item->control_no ?></td>
            <td><?php echo $b_item->account_no ?></td>
            <td><?php echo $b_item->customer_name ?></td>
            <td><?php echo $b_item->total_consumption ?></td>
            <td class="right_align"><?php echo number_format($b_item->amount_due,2); ?></td>
            <td class="right_align"><?php echo number_format($b_item->arrears_penalty_amount,2); ?></td>
            <td class="right_align"><?php echo number_format($b_item->charges_amount,2); ?></td>
            <td class="right_align"><?php echo number_format($b_item->grand_total_amount,2); ?></td>
        </tr>
    <?php
    $batch_total_amount+= $b_item->grand_total_amount;
    $batch_total_amount_due+= $b_item->amount_due;
    $batch_total_penalty+= $b_item->arrears_penalty_amount;
    $batch_total_other_charges+= $b_item->charges_amount; } ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="4" style="text-align: right"><b>Total:</b></td>
            <td class="right_align"><b><?php echo number_format($batch_total_amount_due,2); ?><b></td>
            <td class="right_align"><b><?php echo number_format($batch_total_penalty,2); ?><b></td>
            <td class="right_align"><b><?php echo number_format($batch_total_other_charges,2); ?><b></td>
            <td class="right_align"><b><?php echo number_format($batch_total_amount,2); ?><b></td>
        </tr>
    </tfoot>
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
<style>
    tr {
        border: none!important;
    }
