<style>

    table.table_journal_entries_review td {
        border: 0px !important;
    }
    tr {
        border: none!important;
}
.align-right{
    text-align: right;
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
                        <li class="active"><a href="#journal_review_<?php echo $info->cash_invoice_id; ?>" data-toggle="tab"><i class="fa fa-gavel"></i> Review Journal</a></li>
                        <li class=""><a href="#payment_review_<?php echo $info->cash_invoice_id; ?>" data-toggle="tab"><i class="fa fa-folder-open-o"></i> Payment</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="journal_review_<?php echo $info->cash_invoice_id; ?>" data-parent-id="<?php echo $info->cash_invoice_id; ?>" style="min-height: 300px;">
                            <?php if(!$valid_particular){ ?>
                                <div class="alert alert-dismissable alert-danger">
                                    <i class="fa fa-exclamation-circle"></i>&nbsp; <strong>Sorry!</strong> We could not find the record of <b><?php echo $info->customer_name; ?></b>.<br />
                                    <i class="fa fa-exclamation-circle"></i>&nbsp; Please make sure that <b><?php echo $info->customer_name; ?></b> is not deleted or cancelled to your masterfile record.
                                    <br /><br />
                                    <i class="fa fa-bars"></i>&nbsp; Please call the System Administrator or Developer for assistance.
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                </div>
                            <?php } ?>
                            <form id="frm_journal_review" role="form" class="form-horizontal row-border">
                                <br />
                                <input type="hidden" name="cash_invoice_id" value="<?php echo $info->cash_invoice_id; ?>">
                                <input type="hidden" name="ref_no" value="<?php echo $info->cash_inv_no;?>">
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
                                                            <option value="<?php echo $customer->customer_id; ?>" <?php echo ($info->customer_id===$customer->customer_id?'selected':''); ?>><?php echo $customer->customer_name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="col-lg-4 col-lg-offset-1">
                                                    Date * :<br />
                                                    <div class="input-group">
                                                        <input type="text" name="date_txn" class="date-picker  form-control" value="<?php echo $info->date_invoice; ?>">
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
                                                            <option value="<?php echo $department->department_id; ?>"><?php echo $department->department_name; ?></option>
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
                                <table id="tbl_entries_for_review_<?php echo $info->cash_invoice_id; ?>" class="table table-striped" style="width: 100% !important;">
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
                                    <textarea name="remarks" class="form-control" style="width: 100%;"><?php echo $info->remarks; ?></textarea>
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
                                        <div class="input-group" style="float: right;">
                                            <input type="text" name="closing_reason" class="form-control" placeholder="Close Notes/Remarks" >
                                             <span class="input-group-addon " style="padding: 0px;background-color: #ff0039!important;">
                                                <button name="btn_close_journal_review" class="btn btn-danger " title="Click this if you don't want to post this in Accounting, and it will be removed from the list of Pending for Review" style="">Close</button>    
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="payment_review_<?php echo $info->cash_invoice_id; ?>" >
                            <h4><span style="margin-left: 1%"><strong><i class="fa fa-bars"></i> Cash Invoice Transaction</strong></span></h4>
                            <hr />
                            <div style="margin-left: 2%">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <i class="fa fa-code"></i> Cash Invoice # : <b><?php echo $info->cash_inv_no; ?></b><br />
                                        <i class="fa fa-calendar"></i> Date Invoice : <?php echo $info->date_invoice; ?><br />
                                        <i class="fa fa-users"></i> Customer : <?php echo $info->customer_name; ?><br /><br />
                                    </div>
                                    <div class="col-lg-6">
                                    Contact Person : <?php echo $info->customer_name; ?><br />                                    
                                    Email Address : <?php echo $info->email_address; ?><br />
                                    Contact Number : <?php echo $info->contact_no; ?><br />

                                    </div>
                                </div>
                                <table class="table table-striped" style="width: 100% !important;">
                                    <thead>
                                    <tr style="border-bottom: solid gray;">
                                        <td ><strong>Item </strong></td>
                                        <td ><strong>UM</strong></td>
                                        <td  class="align-right"><strong>Qty</strong></td>
                                        <td  class="align-right"><strong>Unit Price</strong></td>
                                        <td  class="align-right"><strong>Discount</strong></td>
                                        <td  class="align-right"><strong>Gross</strong></td>
                                        <td  class="align-right"><strong>Net Total</strong></td>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <?php foreach ($items as $item) { ?>
                                        <tr>
                                        <td><?php echo $item->product_desc; ?></td>
                                        <td><?php echo $item->unit_name; ?></td>
                                        <td class="align-right"><?php echo $item->inv_qty; ?></td>
                                        <td class="align-right"><?php echo number_format($item->inv_price,2); ?></td>
                                        <td class="align-right"><?php echo number_format($item->inv_discount,2); ?></td>
                                        <td class="align-right"><?php echo number_format($item->inv_gross,2); ?></td>
                                        <td class="align-right"><?php echo number_format($item->inv_line_total_price,2); ?></td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td colspan="6"  class="align-right"><strong>Discount 1:</strong></td>
                                        <td class="align-right"><?php echo number_format($info->total_discount,2); ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" class="align-right"><strong>Total Before Tax:</strong></td>
                                        <td class="align-right"><?php echo number_format($info->total_before_tax,2); ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" class="align-right"><strong>Tax Amount:</strong></td>
                                        <td class="align-right"><?php echo number_format($info->total_tax_amount,2); ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" class="align-right"><strong>Total After Tax:</strong></td>
                                        <td class="align-right"><?php echo number_format($info->total_after_tax,2); ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" class="align-right"><strong>Discount 2:</strong></td>
                                        <td class="align-right"><?php echo number_format($info->total_overall_discount_amount,2); ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" class="align-right"><strong>Total :</strong></td>
                                        <td class="align-right"><?php echo number_format($info->total_after_discount,2); ?></td>
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