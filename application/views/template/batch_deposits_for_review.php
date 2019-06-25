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
                        <li class="active"><a href="#journal_review_<?php echo $info->service_connection_batch_id; ?>" data-toggle="tab"><i class="fa fa-gavel"></i> Review Journal</a></li>
                        <li class=""><a href="#purchase_review_<?php echo $info->service_connection_batch_id; ?>" data-toggle="tab"><i class="fa fa-folder-open-o"></i> Transaction</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="journal_review_<?php echo $info->service_connection_batch_id; ?>" data-parent-id="<?php echo $info->service_connection_batch_id; ?>" style="min-height: 300px;">

                            <form id="frm_journal_review" role="form" class="form-horizontal row-border">
                            <input type="hidden" name="ref_no" value="<?php echo $info->batch_code; ?>">


                            
                                <h4><span style="margin-left: 1%"><strong><i class="fa fa-gear"></i> General Journal</strong></span></h4>
                                <hr />
                                <div style="width: 90%;">
                                    <input type="hidden" name="service_connection_batch_id" value="<?php echo $info->service_connection_batch_id; ?>">
                                    <label class="col-lg-2"> <b class="required">*</b> Txn # :</label>
                                    <div class="col-lg-10">
                                        <input type="text" name="txn_no" class="form-control" style="font-weight: bold;" placeholder="TXN-MMDDYYY-XXX" readonly>
                                    </div>
                                    <br /><br />
                                    <label class="col-lg-2"> <b class="required">*</b> Date :</label>
                                    <div class="col-lg-10">
                                        <input type="text" name="date_txn" class="date-picker  form-control" value="<?php echo date("m/d/Y") ?>">
                                    </div>
                                    <br /><br />
                                    <label class="col-lg-2"> <b class="required">*</b> Customer : </label>
                                    <div class="col-lg-10">

                                            <select id="cbo_particulars" name="particular_id" class=" cbo_supplier_list selectpicker show-tick form-control" data-live-search="true" data-error-msg="Particular is required." required>
                                                <optgroup label="Customers">
                                                    <?php foreach($customers as $customer){ ?>
                                                        <option value='C-<?php echo $customer->customer_id; ?>' <?php echo ($account_integration->billing_customer_id===$customer->customer_id?'selected':''); ?>><?php echo $customer->customer_name; ?></option>
                                                    <?php } ?>
                                                </optgroup>

                                                <optgroup label="Suppliers">
                                                    <?php foreach($suppliers as $supplier){ ?>
                                                        <option value='S-<?php echo $supplier->supplier_id; ?>'><?php echo $supplier->supplier_name; ?></option>
                                                    <?php } ?>
                                                </optgroup>
                                            </select>
                                    </div>
                                    <br /><br />
                                    <label class="col-lg-2"> <b class="required">*</b> Branch : </label>
                                    <div class="col-lg-10">
                                        <select name="department_id" class="cbo_department_list" data-error-msg="" required>
                                            <?php foreach($departments as $department){ ?>
                                                <option value="<?php echo $department->department_id; ?>" <?php echo ($account_integration->billing_department_id===$department->department_id?'selected':''); ?>><?php echo $department->department_name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <br /><br /><br />
                                <h4><span style="margin-left: 1%"><strong><i class="fa fa-gear"></i> Journal Entries</strong></span></h4>
                                <hr />
                                <table id="tbl_entries_for_review_dep_<?php echo $info->service_connection_batch_id; ?>" class="table table-striped" style="width: 100% !important;">
                                    <thead>
                                    <tr style="border-bottom:solid gray;">
                                        <th style="width: 30%;">Account</th>
                                        <th style="width: 15%;">Memo</th>
                                        <th style="width: 15%;text-align: right;">Dr</th>
                                        <th style="width: 15%;text-align: right;">Cr</th>
                                        <th style="width: 10%;">Action</th>
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
                                <div class="col-sm-6">
                                    <button name="btn_finalize_journal_review" class="btn btn-primary "><i class="fa fa-check-circle"></i> <span class=""></span> Finalize and Post this Journal</button>
                                </div>
                                <div class="col-sm-6">

                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="purchase_review_<?php echo $info->service_connection_batch_id; ?>" >
                                <h4><span style="margin-left: 1%"><strong><i class="fa fa-bars"></i> Service Connections</strong></span></h4>
                                <hr />
                                <div style="margin-left: 2%;margin-right: 20px;">
                                <table id="tbl_connection" class="table table-striped" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Service No</th>
                                            <th style="">Account No</th>
                                            <th style="">Particular</th>
                                            <th>Service Date</th>
                                            <th width="15%" class="right_align">Total Deposits</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $total_batch = 0; foreach ($items as $item) { ?>
                                            <tr>
                                                <td><?php echo $item->service_no; ?></td>
                                                <td><?php echo $item->account_no; ?></td>
                                                <td><?php echo $item->receipt_name; ?></td>
                                                <td><?php echo $item->service_date; ?></td>
                                                <td class="right_align"><?php echo number_format($item->initial_meter_deposit,2); ?></td>
                                            </tr>
                                        <?php $total_batch += $item->initial_meter_deposit; } ?>
                                            <tr>
                                            <td class="right_align" colspan="4"><b>Total:</b></td>
                                            <td class="right_align"><b><?php echo number_format($total_batch,2) ?></b></td>
                                            </tr>
                                    </tbody>

                                </table>
                                </div>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
        </tbody>
    </table>
</center>
