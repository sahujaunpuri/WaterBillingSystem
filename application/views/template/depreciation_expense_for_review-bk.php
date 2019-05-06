<table class="table_journal_entries_review"  width="100%" style="font-family: tahoma;">
<tbody>
<div class="tab-container tab-top tab-default">
<div class="tab-content">


    <form id="frm_journal_review" role="form" class="form-horizontal row-border">
        <h4><span style="margin-left: 1%"><strong><i class="fa fa-gear"></i> General Journal</strong></span></h4>
        <hr />
        <div style="width: 90%;">
            <input type="hidden" name="service_invoice_id" value="">
            <label class="col-lg-2"> * Txn # :</label>
            <div class="col-lg-10">
                <input type="text" name="txn_no" class="form-control" style="font-weight: bold;" placeholder="TXN-MMDDYYY-XXX" readonly>
            </div>
            <br /><br />
            <label class="col-lg-2"> * Date :</label>
            <div class="col-lg-10">
                <input type="text" name="date_txn" class="date-picker  form-control" >
            </div>
            <br /><br />
            <label class="col-lg-2"> * Particular :</label>
            <div class="col-lg-10">
                <select name="customer_id" class="cbo_customer_list form-control" data-error-msg="Particular is required." required>
                    <?php foreach($suppliers as $supplier){ ?>
                        <option value="<?php echo $supplier->supplier_id; ?>"><?php echo $supplier->supplier_name; ?></option>
                    <?php } ?>
                </select>
            </div>
            <br /><br />
            <label class="col-lg-2"> * Department :</label>
            <div class="col-lg-10">
                <select name="department_id" class="cbo_department_list form-control" data-error-msg="Branch is required." required>
                    <?php foreach($departments as $department){ ?>
                        <option value="<?php echo $department->department_id; ?>"><?php echo $department->department_name; ?></option>
                    <?php } ?>
                </select>
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
                        <button type="button" class="btn btn-default remove_account"><i class="fa fa-plus-circle" style="color: red;"></i></button>
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
            <button name="btn_finalize_journal_review" class="btn btn-primary"><i class="fa fa-check-circle"></i> <span class=""></span> Finalize this Journal</button>
        </div>
    </div>

</div>

</div>
</div>
</tbody>
</table>
<style>
    tr {
        border: none!important;
    }
