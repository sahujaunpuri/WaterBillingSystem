<style>

    table.table_journal_entries_review td {
        border: 0px !important;
    }
    tr {
        border: none!important;
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
    <li class="<?php if($info->is_journal_posted==0) { echo 'active';} else { echo '';}?> " <?php if($info->is_journal_posted==1) { echo 'style="display:none;"';} else { echo '';}?>><a href="#journal_review_<?php echo $info->de_id; ?>" data-toggle="tab"><i class="fa fa-gavel"></i> Review Journal</a></li>
    <li class="<?php if($info->is_journal_posted==1) { echo 'active';} else { echo '';}?>" <?php if($info->is_journal_posted==0) { echo 'style="display:none;"';} else { echo '';}?>><a href="#purchase_review_<?php echo $info->de_id; ?>" data-toggle="tab"><i class="fa fa-folder-open-o"></i> Transaction</a></li>
</ul>
<div class="tab-content">
<div class="tab-pane <?php if($info->is_journal_posted==0) { echo 'active';} else { echo '';}?>" id="journal_review_<?php echo $info->de_id; ?>" data-parent-id="<?php echo $info->de_id; ?>" style="min-height: 300px;">
    <form id="frm_journal_review_<?php echo $info->de_id; ?>" role="form" class="form-horizontal row-border">
        <h4><span style="margin-left: 1%"><strong><i class="fa fa-gear"></i> General Journal</strong></span></h4>
        <hr />
        <div style="width: 90%;">
            <input type="hidden" name="de_id" value="<?php echo $info->de_id; ?>">
                <div class="row">
                <label class="col-lg-2"> <b class="required">*</b> Txn # :</label>
                <div class="col-lg-4">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-code"></i>
                        </span>
                        <input type="text" name="txn_no" class="form-control" placeholder="TXN-YYYYMMDD-XXX" readonly>
                    </div>
                </div>
                <label class="col-lg-2"> <b class="required">*</b> Date :</label>
                <div class="col-lg-4">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </span>
                        <input type="text" name="date_txn"  class="date-picker form-control" data-error-msg="Date is required." required>
                    </div>
                </div>
                </div>
            <div class="row">
                 <label class="col-lg-2"> <b class="required">*</b> Particular :</label>
                <div class="col-lg-10">
                    <select name="particular_id" class="selectpicker show-tick form-control particular_select" data-live-search="true" data-error-msg="Particular is required." required>

                        <optgroup label="Customers">
                            <?php foreach($customers as $customer){ ?>
                                <option value='C-<?php echo $customer->customer_id; ?>'><?php echo $customer->customer_name; ?></option>
                            <?php } ?>
                        </optgroup>
                        <optgroup label="Suppliers">
                            <?php foreach($suppliers as $supplier){ ?>
                                <option value='S-<?php echo $supplier->supplier_id; ?>'><?php echo $supplier->supplier_name; ?></option>
                            <?php } ?>
                        </optgroup>

                    </select>
                </div>
            <label class="col-lg-2"> <b class="required">*</b> Department :</label>
            <div class="col-lg-10">
                <select name="department_id" class="cbo_department_list" data-error-msg="Branch is required." required>
                    <?php foreach($departments as $department){ ?>
                        <option value="<?php echo $department->department_id; ?>"><?php echo $department->department_name; ?></option>
                    <?php } ?>
                </select>
            </div>
            </div>
        </div>
        <br /><br /><br />
        <h4><span style="margin-left: 1%"><strong><i class="fa fa-gear"></i> Journal Entries</strong></span></h4>
        <hr />
        <table id="tbl_entries_for_review_<?php echo $info->de_id;?>" class="table table-striped" style="width: 100% !important;">
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
                        <select name="accounts[]" class="selectpicker show-tick form-control selectpicker_accounts" data-live-search="true" title="Please select Student" style="width:100%;">
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
            <button name="btn_finalize_journal_review" class="btn btn-primary <?php if($info->is_journal_posted == 1){ echo 'disabled';} ?>"><i class="fa fa-check-circle"></i> <span class=""></span> Finalize this Journal</button>
        </div>
    </div>
</div>

<div class="tab-pane <?php if($info->is_journal_posted==1) { echo 'active';} else { echo '';}?>" id="purchase_review_<?php echo $info->de_id; ?>" >
    <h4><span style="margin-left: 1%"><strong><i class="fa fa-bars"></i><?php if($info->is_journal_posted==1) { echo ' POSTED';} else { echo ' FOR POSTING';}?> </strong></span></h4>
    <hr />
    <div style="margin-left: 2%">
        <div class="row">
        <?php if($info->is_journal_posted == 1){ ?> 

        This Depreciation Expense is already posted in the General Journal with the Transaction Number :<b> <?php echo $info->de_ref_no; ?></b>

        <?php } ?>
        </div>
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
