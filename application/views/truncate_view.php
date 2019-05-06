<!DOCTYPE html>

<html lang="en">

    <head>

        <meta charset="utf-8">

        <title>JCORE - <?php echo $title; ?></title>

        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-touch-fullscreen" content="yes">
        <meta name="description" content="Avenxo Admin Theme">
        <meta name="author" content="">

        <?php echo $_def_css_files; ?>

        <link rel="stylesheet" href="assets/plugins/spinner/dist/ladda-themeless.min.css">
        <link type="text/css" href="assets/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">
        <link type="text/css" href="assets/plugins/datatables/dataTables.themify.css" rel="stylesheet">

        <link href="assets/plugins/select2/select2.min.css" rel="stylesheet">

        <style>
            .toolbar{
                float: left;
            }

            td.details-control {
                background: url('assets/img/Folder_Closed.png') no-repeat center center;
                cursor: pointer;
            }
            tr.details td.details-control {
                background: url('assets/img/Folder_Opened.png') no-repeat center center;
            }

            .child_table{
                padding: 5px;
                border: 1px #ff0000 solid;
            }

            .glyphicon.spinning {
                animation: spin 1s infinite linear;
                -webkit-animation: spin2 1s infinite linear;
            }

            .select2-container{
                width: 100% !important;
            }

            @keyframes spin {
                from { transform: scale(1) rotate(0deg); }
                to { transform: scale(1) rotate(360deg); }
            }

            @-webkit-keyframes spin2 {
                from { -webkit-transform: rotate(0deg); }
                to { -webkit-transform: rotate(360deg); }
            }
            .css-label{
                font-weight: normal;
            }

        </style>

    </head>

    <body class="animated-content"  >
    <!-- <body class="animated-content" oncontextmenu="return false" > -->
        <div id="wrapper">
            <div id="layout-static">
        <div class="static-content-wrapper white-bg">
            <div class="static-content"  >
                <div class="page-content"><!-- #page-content -->
<br>

                    <div class="container-fluid" id="truncate-div">
                        <div data-widget-group="group1">
                            <div class="row">
                                <div class="col-md-12">

                                    <div id="div_tax_list">
                                        <div class="panel panel-default">
                                            <!-- <div class="panel-heading">
                                                <b style="color: white; font-size: 12pt;"><i class="fa fa-bars"></i>&nbsp; Tax Setup</b>
                                            </div> -->
                                            <div class="panel-body table-responsive">
                                            <h2 class="h2-panel-heading"> Truncate Tables (Developers Only)</h2><hr>
<i>Note: Please Perform Full Backup Before Truncating tables.</i>

<div class="tab-container tab-top tab-default">
<ul class="nav nav-tabs">
    <li class="active"><a href="#journals" data-toggle="tab"><i class="fa fa-folder-open-o"></i> Journals</a></li>
    <li class=""><a href="#invoices" data-toggle="tab"><i class="fa fa-folder-open-o"></i> Invoices</a></li>
    <li class=""><a href="#payments" data-toggle="tab"><i class="fa fa-folder-open-o"></i> Payments</a></li>
    <li class=""><a href="#references" data-toggle="tab"><i class="fa fa-folder-open-o"></i> References</a></li>
    <li class=""><a href="#masterfiles" data-toggle="tab"><i class="fa fa-folder-open-o"></i> Masterfiles</a></li>    
    <li class=""><a href="#accounting" data-toggle="tab"><i class="fa fa-folder-open-o"></i> Accounting</a></li>
    <li class=""><a href="#users" data-toggle="tab"><i class="fa fa-folder-open-o"></i> Users</a></li>
    <li class=""><a href="#reset_defaults" data-toggle="tab"><i class="fa fa-folder-open-o"></i> Reset Defaults</a></li>

</ul>
<div class="tab-content">
    <div class="tab-pane" id="accounting" data-parent-id="" style="min-height: 300px;">
        <form id="frm_accounting">
        <input type="checkbox" id="selectall_accounting" class="css-checkbox"><label class="css-label " for="selectall_accounting">SELECT ALL ACCOUNTING</label><br>
            <input type="checkbox" name="accounting[]" value="account_classes" id="account_classes" class="css-checkbox"><label class="css-label " for="account_classes">Account Classes</label>(<?php echo $current_count->account_classes ?>)<br>
            <input type="checkbox" name="accounting[]" value="account_titles" id="account_titles" class="css-checkbox"><label class="css-label " for="account_titles">Chart of Accounts</label>(<?php echo $current_count->account_titles ?>)<br>
            <input type="checkbox" name="accounting[]" value="account_types" id="account_types" class="css-checkbox"><label class="css-label " for="account_types">Account Types</label>(<?php echo $current_count->account_types ?>)<br>
            <input type="checkbox" name="accounting[]" value="account_year" id="account_year" class="css-checkbox"><label class="css-label " for="account_year">Account Year</label>(<?php echo $current_count->account_year ?>)<br>
            <input type="checkbox" name="accounting[]" value="accounting_period" id="accounting_period" class="css-checkbox"><label class="css-label " for="accounting_period">Accounting Period</label>(<?php echo $current_count->accounting_period ?>)<br>
            <input type="checkbox" name="accounting[]" value="trans" id="trans" class="css-checkbox"><label class="css-label " for="trans">Audit Trail</label>(<?php echo $current_count->trans ?>)<br>
        </form>
        <button id="btn_accounting" class="btn-primary btn" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;"><span class=""></span>Truncate Accounting</button>
    </div>
    <div class="tab-pane" id="references" style="min-height: 300px;">
    <input type="checkbox" id="selectall_references" class="css-checkbox"><label class="css-label " for="selectall_references">SELECT ALL REFERENCES</label><br>
    <form id="frm_references">

        <input type="checkbox" name="references[]" value="bank" id="bank" class="css-checkbox"><label class="css-label " for="bank">Bank</label>(<?php echo $current_count->bank ?>)<br>
        <input type="checkbox" name="references[]" value="departments" id="departments" class="css-checkbox"><label class="css-label " for="departments">Departments</label>(<?php echo $current_count->departments ?>)<br>
        <input type="checkbox" name="references[]" value="categories" id="categories" class="css-checkbox"><label class="css-label " for="categories">Categories</label>(<?php echo $current_count->categories ?>)<br>
         <input type="checkbox" name="references[]" value="services" id="services" class="css-checkbox"><label class="css-label " for="services">Services</label>(<?php echo $current_count->services ?>)<br>
        <input type="checkbox" name="references[]" value="service_unit" id="service_unit" class="css-checkbox"><label class="css-label " for="service_unit">Service Units</label>(<?php echo $current_count->service_unit ?>)<br>
        <input type="checkbox" name="references[]" value="tax_types" id="tax_types" class="css-checkbox"><label class="css-label " for="tax_types">Tax Types</label>(<?php echo $current_count->tax_types ?>)<br>
        <input type="checkbox" name="references[]" value="units" id="units" class="css-checkbox"><label class="css-label " for="units">Units</label>(<?php echo $current_count->units ?>)<br>
        <input type="checkbox" name="references[]" value="locations" id="locations" class="css-checkbox"><label class="css-label " for="locations">Locations</label>(<?php echo $current_count->locations ?>)<br>
       
    </form>   
    <button id="btn_references" class="btn-primary btn" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;"><span class=""></span>Truncate References</button>
    </div>
    <div class="tab-pane active" id="journals" style="min-height: 300px;">
    <input type="checkbox" id="selectall_journal" class="css-checkbox"><label class="css-label " for="selectall_journal">SELECT ALL JOURNALS</label><br>
        <form id="frm_journal">

        <input type="checkbox" name="journal[]" value="journal_info" id="journal_info" class="css-checkbox"><label class="css-label " for="journal_info">Journal Info</label>(<?php echo $current_count->journal_info; ?>)<br>
        <input type="checkbox" name="journal[]" value="journal_accounts" id="journal_accounts" class="css-checkbox"><label class="css-label " for="journal_accounts">Journal Accounts</label>(<?php echo $current_count->journal_accounts; ?>)<br>
        <input type="checkbox" name="journal[]" value="journal_entry_templates" id="journal_entry_templates" class="css-checkbox"><label class="css-label " for="journal_entry_templates">Journal Templates Items</label>(<?php echo $current_count->journal_entry_templates; ?>)<br>
        <input type="checkbox" name="journal[]" value="journal_templates_info" id="journal_templates_info" class="css-checkbox"><label class="css-label " for="journal_templates_info">Journal Templates Info</label>(<?php echo $current_count->journal_templates_info; ?>)<br>
        <input type="checkbox" name="journal[]" value="batch_info" id="batch_info" class="css-checkbox"><label class="css-label " for="batch_info">Petty Cash Batch Info</label>(<?php echo $current_count->batch_info; ?>)<br>
        <input type="checkbox" name="journal[]" value="depreciation_expense" id="depreciation_expense" class="css-checkbox"><label class="css-label " for="depreciation_expense">Depreciation Expense</label>(<?php echo $current_count->depreciation_expense; ?>)<br>
        <input type="checkbox" name="journal[]" value="bank_reconciliation" id="bank_reconciliation" class="css-checkbox"><label class="css-label " for="bank_reconciliation">Bank Reconciliation Info</label>(<?php echo $current_count->bank_reconciliation; ?>)<br>
        <input type="checkbox" name="journal[]" value="bank_reconciliation_details" id="bank_reconciliation_details" class="css-checkbox"><label class="css-label " for="bank_reconciliation_details">Bank Reconciliation Items</label>(<?php echo $current_count->bank_reconciliation_details; ?>)<br>
        </form>
        <button id="btn_journal" class="btn-primary btn" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;"><span class=""></span>Truncate Journals</button>
    </div>
    <div class="tab-pane" id="invoices" style="min-height: 300px;">
        <form id="frm_invoices">
        <input type="checkbox" id="selectall_invoice" class="css-checkbox"><label class="css-label " for="selectall_invoice">SELECT ALL INVOICES</label><br>
        <input type="checkbox" name="invoice[]" value="purchase_order" id="purchase_order" class="css-checkbox"><label class="css-label " for="purchase_order">Purchase Order Info</label>(<?php echo $current_count->purchase_order; ?>)<br>
        <input type="checkbox" name="invoice[]" value="purchase_order_items" id="purchase_order_items" class="css-checkbox"><label class="css-label " for="purchase_order_items">Purchase Order Items</label>(<?php echo $current_count->purchase_order_items; ?>)<br>
        <input type="checkbox" name="invoice[]" value="po_attachments" id="po_attachments" class="css-checkbox"><label class="css-label " for="po_attachments">Purchase Order Attachments</label>(<?php echo $current_count->po_attachments; ?>)<br>
        <input type="checkbox" name="invoice[]" value="po_messages" id="po_messages" class="css-checkbox"><label class="css-label " for="po_messages">Purchase Order Messages</label>(<?php echo $current_count->po_messages; ?>)<br>
        <input type="checkbox" name="invoice[]" value="delivery_invoice" id="delivery_invoice" class="css-checkbox"><label class="css-label " for="delivery_invoice">Delivery Invoice</label>(<?php echo $current_count->delivery_invoice; ?>)<br>
        <input type="checkbox" name="invoice[]" value="delivery_invoice_items" id="delivery_invoice_items" class="css-checkbox"><label class="css-label " for="delivery_invoice_items">Delivery Invoice Items</label>(<?php echo $current_count->delivery_invoice_items; ?>)<br>

        <input type="checkbox" name="invoice[]" value="proforma_invoice" id="proforma_invoice" class="css-checkbox"><label class="css-label " for="proforma_invoice">Proforma Invoice Info</label>(<?php echo $current_count->proforma_invoice; ?>)<br>
        <input type="checkbox" name="invoice[]" value="proforma_invoice_items" id="proforma_invoice_items" class="css-checkbox"><label class="css-label " for="proforma_invoice_items">Proforma Invoice Items</label>(<?php echo $current_count->proforma_invoice_items; ?>)<br>

        <input type="checkbox" name="invoice[]" value="cash_invoice" id="cash_invoice" class="css-checkbox"><label class="css-label " for="cash_invoice">Cash Invoice Info</label>(<?php echo $current_count->cash_invoice; ?>)<br>
        <input type="checkbox" name="invoice[]" value="cash_invoice_items" id="cash_invoice_items" class="css-checkbox"><label class="css-label " for="cash_invoice_items">Cash Invoice Items</label>(<?php echo $current_count->cash_invoice_items; ?>)<br>

        <input type="checkbox" name="invoice[]" value="sales_order" id="sales_order" class="css-checkbox"><label class="css-label " for="sales_order">Sales Order Info</label>(<?php echo $current_count->sales_order; ?>)<br>
        <input type="checkbox" name="invoice[]" value="sales_order_items" id="sales_order_items" class="css-checkbox"><label class="css-label " for="sales_order_items">Sales Order Items</label>(<?php echo $current_count->sales_order_items; ?>)<br>
        <input type="checkbox" name="invoice[]" value="sales_invoice" id="sales_invoice" class="css-checkbox"><label class="css-label " for="sales_invoice">Sales Invoice Info</label>(<?php echo $current_count->sales_invoice; ?>)<br>
        <input type="checkbox" name="invoice[]" value="sales_invoice_items" id="sales_invoice_items" class="css-checkbox"><label class="css-label " for="sales_invoice_items">Sales Invoice Items</label>(<?php echo $current_count->sales_invoice_items; ?>)<br>
        <input type="checkbox" name="invoice[]" value="service_invoice" id="service_invoice" class="css-checkbox"><label class="css-label " for="service_invoice">Service Invoice Info</label>(<?php echo $current_count->service_invoice; ?>)<br>
        <input type="checkbox" name="invoice[]" value="service_invoice_items" id="service_invoice_items" class="css-checkbox"><label class="css-label " for="service_invoice_items">Service Invoice Items</label>(<?php echo $current_count->service_invoice_items; ?>)<br>
        <input type="checkbox" name="invoice[]" value="adjustment_info" id="adjustment_info" class="css-checkbox"><label class="css-label " for="adjustment_info">Adjustments Info</label>(<?php echo $current_count->adjustment_info; ?>)<br>
        <input type="checkbox" name="invoice[]" value="adjustment_items" id="adjustment_items" class="css-checkbox"><label class="css-label " for="adjustment_items">Adjustments Items</label>(<?php echo $current_count->adjustment_items; ?>)<br>
        <input type="checkbox" name="invoice[]" value="issuance_department_info" id="issuance_department_info" class="css-checkbox"><label class="css-label " for="issuance_department_info">Issuance Department Info</label>(<?php echo $current_count->issuance_department_info; ?>)<br>
        <input type="checkbox" name="invoice[]" value="issuance_department_items" id="issuance_department_items" class="css-checkbox"><label class="css-label " for="issuance_department_items">Issuance Department Items</label>(<?php echo $current_count->issuance_department_items; ?>)<br>
        </form>

         <button id="btn_invoices" class="btn-primary btn" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;"><span class=""></span>Truncate Invoices</button>

    </div>
    <div class="tab-pane" id="payments" style="min-height: 300px;">
    <input type="checkbox" id="selectall_payment" class="css-checkbox"><label class="css-label " for="selectall_payment">SELECT ALL PAYMENTS</label><br>
        <form id="frm_payments">
        <input type="checkbox" name="payment[]" value="payable_payments" id="payable_payments" class="css-checkbox"><label class="css-label " for="payable_payments">Accounts Payable Payments Info</label>(<?php echo $current_count->payable_payments; ?>)<br>
        <input type="checkbox" name="payment[]" value="payable_payments_list" id="payable_payments_list" class="css-checkbox"><label class="css-label " for="payable_payments_list">Accounts Payable Payments Items</label>(<?php echo $current_count->payable_payments_list; ?>)<br>
        <input type="checkbox" name="payment[]" value="receivable_payments" id="receivable_payments" class="css-checkbox"><label class="css-label " for="receivable_payments">Accounts Receivable Payments Info</label>(<?php echo $current_count->receivable_payments; ?>)<br>
        <input type="checkbox" name="payment[]" value="receivable_payments_list" id="receivable_payments_list" class="css-checkbox"><label class="css-label " for="receivable_payments_list">Accounts Receivable Payments Items</label>(<?php echo $current_count->receivable_payments_list; ?>)<br>
        </form>
         <button id="btn_payments" class="btn-primary btn" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;"><span class=""></span>Truncate Payments</button>
    </div>
    <div class="tab-pane" id="masterfiles" style="min-height: 300px;">
        <input type="checkbox" id="selectall_masterfiles" class="css-checkbox"><label class="css-label " for="selectall_masterfiles">SELECT ALL MASTERFILES</label><br>
        <form id="frm_masterfiles">
        <input type="checkbox" name="masterfiles[]" value="products" id="products" class="css-checkbox"><label class="css-label " for="products">Products</label>(<?php echo $current_count->products; ?>)<br>
        <input type="checkbox" name="masterfiles[]" value="suppliers" id="suppliers" class="css-checkbox"><label class="css-label " for="suppliers">Suppliers</label>(<?php echo $current_count->suppliers; ?>)<br>
        <input type="checkbox" name="masterfiles[]" value="supplier_photos" id="supplier_photos" class="css-checkbox"><label class="css-label " for="supplier_photos">Suppliers Photos</label>(<?php echo $current_count->supplier_photos; ?>)<br>
        <input type="checkbox" name="masterfiles[]" value="customers" id="customers" class="css-checkbox"><label class="css-label " for="customers">Customers</label>(<?php echo $current_count->customers; ?>)<br>
        <input type="checkbox" name="masterfiles[]" value="customer_photos" id="customer_photos" class="css-checkbox"><label class="css-label " for="customer_photos">Customers Photos</label>(<?php echo $current_count->customer_photos; ?>)<br>
        <input type="checkbox" name="masterfiles[]" value="salesperson" id="salesperson" class="css-checkbox"><label class="css-label " for="salesperson">Salespersons</label>(<?php echo $current_count->salesperson; ?>)<br>
        <input type="checkbox" name="masterfiles[]" value="fixed_assets" id="fixed_assets" class="css-checkbox"><label class="css-label " for="fixed_assets">Fixed Assets</label>(<?php echo $current_count->fixed_assets; ?>)<br>
        </form>
         <button id="btn_masterfiles" class="btn-primary btn" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;"><span class=""></span>Truncate Masterfiles</button>
    </div>
    <div class="tab-pane" id="users" style="min-height: 300px;">
    <input type="checkbox" id="selectall_users" class="css-checkbox"><label class="css-label " for="selectall_users">SELECT ALL USERS</label><br>
        <form id="frm_users">
        <input type="checkbox" name="users[]" value="rights_links" id="rights_links" class="css-checkbox"><label class="css-label " for="rights_links">Right Links</label>(<?php  echo $current_count->rights_links ?>)<br>
        <input type="checkbox" name="users[]" value="user_accounts" id="user_accounts" class="css-checkbox"><label class="css-label " for="user_accounts">User Accounts</label>(<?php  echo $current_count->user_accounts ?>)<br>
        <input type="checkbox" name="users[]" value="user_groups" id="user_groups" class="css-checkbox"><label class="css-label " for="user_groups">User Groups</label>(<?php  echo $current_count->user_groups ?>)<br>
        <input type="checkbox" name="users[]" value="user_group_rights" id="user_group_rights" class="css-checkbox"><label class="css-label " for="user_group_rights">User Group Rights</label>(<?php  echo $current_count->user_group_rights ?>)<br>
        </form>
         <button id="btn_users" class="btn-primary btn" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;"><span class=""></span>Truncate Users</button>
    </div>
    <div class="tab-pane" id="reset_defaults" style="min-height: 300px;">
         <button id="reset_default_coa" type="button" class="btn-primary btn" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;"><span class=""></span>Reset Chart of Accounts to Default</button> <br>
         <button id="reset_default_users" type="button" class="btn-primary btn" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;"><span class=""></span>Reset Users to Default</button> <br>
         <button id="reset_default_configuration" type="button" class="btn-primary btn" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;"><span class=""></span>Reset General Configuration to Default</button><br> 
         <button id="reset_default_company" type="button" class="btn-primary btn" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;"><span class=""></span>Reset Company Information to Default</button> <br>
        <button id="reset_initial_setup" type="button" class="btn-primary btn" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;"><span class=""></span>Reset Initial Setup</button> <br>
    </div>

</div> <!-- END  OF  TAB CONTENT BODY -->    
</div> <!-- END  OF  TAB CONTENT CONTAINER -->   






                                            </div>
                                            <div class="panel-footer"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- .container-fluid -->

                </div> <!-- #page-content -->
            </div>

<div id="modal_confirmation" class="modal fade" tabindex="-1" role="dialog"><!--modal-->
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header ">
                <h4 class="modal-title" style="color:white;"><span id="modal_mode"> </span>Authorize Access</h4>
            </div>
            <div class="modal-body">
            <input id="username" type="password" name="username" class="form-control">
            <input id="password" type="password" name="password" class="form-control">
            </div>
            <div class="modal-footer">
              
              
            </div>
        </div>
    </div>
</div>

            <footer role="contentinfo">
                <div class="clearfix">
                    <ul class="list-unstyled list-inline pull-left">
                        <li><h6 style="margin: 0;">&copy; 2018 - JDEV OFFICE SOLUTION INC</h6></li>
                          <button id="validate" type="button" class="btn btn-danger hidden" style="position: margin-right:-100px; text-transform: capitalize;font-family: Tahoma, Georgia, Serif;"></button>
                    </ul>
                    <button class="pull-right btn btn-link btn-xs hidden-print" id="back-to-top"><i class="ti ti-arrow-up"></i></button>
                </div>
            </footer>
        </div>
        </div>
    </div>
    <?php echo $_def_js_files; ?>

    <script src="assets/plugins/spinner/dist/spin.min.js"></script>
    <script src="assets/plugins/spinner/dist/ladda.min.js"></script>

    <script type="text/javascript" src="assets/plugins/datatables/jquery.dataTables.js"></script>
    <script type="text/javascript" src="assets/plugins/datatables/dataTables.bootstrap.js"></script>

    <script src="assets/plugins/select2/select2.full.min.js"></script>

    <script>

$(document).keydown(function(e){ if(e.which === 123){ return false; }
  if(e.altKey && e.keyCode == 83){ e.preventDefault(); $('[id^=validate]').click(); } });
$(document).bind("contextmenu",function(e) {  e.preventDefault(); });
    $(document).ready(function() {
        var dt; var _txnMode; var _selectedID; var _selectRowObj; var _taxTypeGroup; var _rights;
        $('#modal_confirmation').modal({
            backdrop: 'static',
            keyboard: false
        });
        // $('#truncate-div').click(false);


        var initializeControls=function() {
            _rights = 'false';
            // $('#modal_confirmation').modal('show');
        }();


        var bindEventHandlers=(function(){
           $('[id^=btn_]').click(function() {
            if(_rights == 'false'){
                showNotification({title:"Error !",stat:"error",msg:"Unauthorized Access"});
            }else {

                var btn=$(this);
                temp = this.id.split("_");
                name = temp[1];

                var data=$('#frm_'+name).serializeArray();
                $.ajax({
                    "dataType":"json",
                    "type":"POST",
                    "url":"Truncate/transaction/truncate-"+name,
                    "data":data,
                    "beforeSend" : function(){
                        showSpinningProgress(btn);
                    }
                }).done(function(response){
                    showNotification(response);
                }).always(function(){
                    showSpinningProgress(btn);
                });
            } // END OF IF ELSE
           });



            $('[id^=selectall_]').click(function(event) {   
                    var btn=$(this); temp = this.id.split("_"); name = temp[1];
                if(this.checked) {
                    $('input[name="'+name+'[]"]').each(function() {
                        this.checked = true;                        
                    });
                }
                else {
                    $('input[name="'+name+'[]').each(function() {
                        this.checked = false;                        
                    });
                }
            });


           $('[id^=validate]').click(function() {
             var btn=$(this);

                var _data=[];
                _data.push({name : "username" ,value : $('#username').val() });
                _data.push({name : "password" ,value : $('#password').val()});

                $.ajax({
                    "dataType":"json",
                    "type":"POST",
                    "url":"Truncate/validate_truncation",
                    "data":_data,
                    "beforeSend" : function(){
                        showSpinningProgress(btn);
                    }
                }).done(function(response){
                    showNotification(response);
                    if(response.stat == 'error'){
                        _rights = 'false';


                    }else if(response.stat == 'success'){
                        $('#modal_confirmation').modal('hide');
                        // $('#truncate-div').click(true);
                        _rights = 'true';
                    }
                }).always(function(){
                    showSpinningProgress(btn);
                });
           });


           $('#reset_default_coa').click(function() {
             var btn=$(this);

                $.ajax({
                    "dataType":"json",
                    "type":"POST",
                    "url":"Truncate/reset_default_coa",
                    "beforeSend" : function(){
                        showSpinningProgress(btn);
                    }
                }).done(function(response){
                    showNotification(response);
                }).always(function(){
                    showSpinningProgress(btn);
                });
           });

           $('#reset_default_users').click(function() {
             var btn=$(this);

                $.ajax({
                    "dataType":"json",
                    "type":"POST",
                    "url":"Truncate/reset_default_users",
                    "beforeSend" : function(){
                        showSpinningProgress(btn);
                    }
                }).done(function(response){
                    showNotification(response);
                }).always(function(){
                    showSpinningProgress(btn);
                });
           });

           $('#reset_default_configuration').click(function() {
             var btn=$(this);

                $.ajax({
                    "dataType":"json",
                    "type":"POST",
                    "url":"Truncate/reset_default_configuration",
                    "beforeSend" : function(){
                        showSpinningProgress(btn);
                    }
                }).done(function(response){
                    showNotification(response);
                }).always(function(){
                    showSpinningProgress(btn);
                });
           });

           $('#reset_default_company').click(function() {
             var btn=$(this);

                $.ajax({
                    "dataType":"json",
                    "type":"POST",
                    "url":"Truncate/reset_default_company",
                    "beforeSend" : function(){
                        showSpinningProgress(btn);
                    }
                }).done(function(response){
                    showNotification(response);
                }).always(function(){
                    showSpinningProgress(btn);
                });
           });

           $('#reset_initial_setup').click(function() {
             var btn=$(this);

                $.ajax({
                    "dataType":"json",
                    "type":"POST",
                    "url":"Truncate/reset_initial_setup",
                    "beforeSend" : function(){
                        showSpinningProgress(btn);
                    }
                }).done(function(response){
                    showNotification(response);
                }).always(function(){
                    showSpinningProgress(btn);
                });
           });
           
        })();


        var validateRequiredFields=function(f){
            var stat=true;

            $('div.form-group').removeClass('has-error');
            $('input[required],textarea[required],select[required]',f).each(function(){

                if($(this).is('select')){
                    if($(this).select2('val')==0||$(this).select2('val')==null){
                        showNotification({title:"Error!",stat:"error",msg:$(this).data('error-msg')});
                        $(this).closest('div.form-group').addClass('has-error');
                        $(this).focus();
                        stat=false;
                        return false;
                    }
                }else{
                    if($(this).val()==""){
                        showNotification({title:"Error!",stat:"error",msg:$(this).data('error-msg')});
                        $(this).closest('div.form-group').addClass('has-error');
                        $(this).focus();
                        stat=false;
                        return false;
                    }
                }



            });

            return stat;
        };

    var showNotification=function(obj){
        PNotify.removeAll(); //remove all notifications
        new PNotify({
            title:  obj.title,
            text:  obj.msg,
            type:  obj.stat
        });
    };

    var showSpinningProgress=function(e){
        $(e).find('span').toggleClass('glyphicon glyphicon-refresh spinning');
    };

    
    });

    </script>

    </body>

</html>