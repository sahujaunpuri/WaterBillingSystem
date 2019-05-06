
<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from avenxo.kaijuthemes.com/ui-typography.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 06 Jun 2016 12:09:25 GMT -->
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
    <link href="assets/plugins/datapicker/datepicker3.css" rel="stylesheet">

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
            min-width: 100%;
        }

        .dropdown-menu > .active > a,.dropdown-menu > .active > a:hover{
            background-color: dodgerblue;
        }

        @keyframes spin {
            from { transform: scale(1) rotate(0deg); }
            to { transform: scale(1) rotate(360deg); }
        }

        @-webkit-keyframes spin2 {
            from { -webkit-transform: rotate(0deg); }
            to { -webkit-transform: rotate(360deg); }
        }

input {
    border-color: #cccccc!important;
}

        /*table{
            min-width: 700px;
        }

        .dataTables_filter{
            min-width: 700px;
        }

        .dataTables_info{
            min-width: 700px;
        }

        .dataTables_paginate{
            float: left;
            width: 100%;
        }*/

    </style>
</head>

<body class="animated-content">

<div id="wrapper">
    <div id="layout-static">
        <div class="static-content-wrapper white-bg">
            <div class="static-content"  >
                <div class="page-content"><!-- #page-content -->
                <br>
                <div class="container-fluid">
                        <div data-widget-group="group1">
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="div_company_fields">
                                        <div class="panel panel-default">
                                        <input type="hidden" name="setupcompany" id="setupcompany" value="<?php echo $initialize->setup_company_info ?>">
                                        <input type="hidden" name="setupgeneralconfiguration" id="setupgeneralconfiguration" value="<?php echo $initialize->setup_general_configuration ?>">
                                        <input type="hidden" name="setupuser" id="setupuser" value="<?php echo $initialize->setup_user_account ?>">
                                        <input type="hidden" name="setupcomplete" id="setupcomplete" value="<?php echo $initialize->setup_complete ?>">
                                            <div class="panel-body">
                                            <h2 class="h2-panel-heading">INITIAL SET-UP</h2><hr>
                                            <b style="color: red;">*</b><i>Fields are required.</i>
                                               <div id="initial_company_info">
                                                <form id="frm_company" role="form" class="form-horizontal row-border">
                                                <div class="row">
                                                <div class="col-lg-6">
                                                     <div class="form-group">
                                                       <label class="col-md-4  control-label"><strong><b style="color: red;">*</b> Company Name :</strong></label>
                                                       <div class="col-md-8">
                                                               <input  spellcheck="false" type="text" name="company_name" class="form-control" value="<?php echo $company->company_name; ?>" placeholder="Company Name" data-error-msg="Company Name is required!" required>
                                                       </div>
                                                   </div>
                                                   <div class="form-group">
                                                       <label class="col-md-4 control-label"><strong><b style="color: red;">*</b> Company Address :</strong></label>
                                                       <div class="col-md-8">
                                                               <input  spellcheck="false" type="text" name="company_address" class="form-control" value="<?php echo $company->company_address; ?>" placeholder="Company Address" data-error-msg="Company address is required!" required>
                                                       </div>
                                                   </div>

                                                   <div class="form-group">
                                                       <label class="col-md-4  control-label"><strong><b style="color: red;">*</b> Email :</strong></label>
                                                       <div class="col-md-8">
                                                               <input  spellcheck="false" type="text" name="email_address" class="form-control" value="<?php echo $company->email_address; ?>" placeholder="Email Address" data-error-msg="Email address is required!" required>
                                                       </div>
                                                   </div>
                                                   <div class="form-group">
                                                       <label class="col-md-4  control-label"> <strong>Mobile  # :</strong></label>
                                                       <div class="col-md-8">
                                                               <input  spellcheck="false" type="text" name="mobile_no" class="form-control" value="<?php echo $company->mobile_no; ?>" placeholder="Mobile #" data-error-msg="Mobile # is required!">
                                                       </div>
                                                   </div>


                                                   <div class="form-group">
                                                       <label class="col-md-4  control-label"> <strong>Landline :</strong></label>
                                                       <div class="col-md-8">
                                                               <input  spellcheck="false" type="text" name="landline" class="form-control" value="<?php echo $company->landline; ?>" placeholder="Landline">
                                                       </div>
                                                   </div>


                                                   <div class="form-group">
                                                       <label class="col-md-4  control-label"><strong> TIN. :</strong></label>
                                                       <div class="col-md-8">
                                                               <input  spellcheck="false" type="text" name="tin_no" class="form-control" value="<?php echo $company->tin_no; ?>" placeholder="TIN" data-error-msg="TIN. is required!">
                                                       </div>
                                                   </div>
                                                   <div class="form-group">
                                                       <label class="col-md-4  control-label"> <strong>Registered to :</strong></label>
                                                       <div class="col-md-8">
                                                               <input  spellcheck="false" type="text" name="registered_to" class="form-control" value="<?php echo $company->registered_to; ?>" placeholder="Registered to" data-error-msg="Registered to is required!">
                                                       </div>
                                                   </div>

                                                   <div class="form-group">
                                                       <label class="col-md-4  control-label"> <strong>RDO # :</strong></label>
                                                       <div class="col-md-8">
                                                               <input  spellcheck="false" type="text" name="rdo_no" class="form-control" value="<?php echo $company->rdo_no; ?>" placeholder="RDO #" data-error-msg="RDO # to is required!">
                                                       </div>
                                                   </div>

                                                   <div class="form-group">
                                                       <label class="col-md-4  control-label"> <strong><b style="color: red;">*</b> Nature of Business :</strong></label>
                                                       <div class="col-md-8">
                                                           <select name="nature_of_business" id="nature_of_business" data-error-msg="Nature of Business is required." required>
                                                              <option value="Service">Service</option>
                                                              <option value="Manufacturing">Manufacturing</option>
                                                              <option value="Trading">Trading</option>
                                                              <option value="Hotel/Motel">Hotel/Motel</option>
                                                              <option value="Trading">Trading</option>
                                                              <option value="Financing">Financing</option>
                                                              <option value="Outsourcing">Outsourcing</option>
                                                              <option value="Restaurant">Restaurant</option>
                                                              <option value="Grocery">Grocery</option>
                                                              <option value="Convenient Store">Convenient Store</option>
                                                              <option value="Fastfood">Fastfood</option>
                                                              <option value="Retailer">Retailer</option>
                                                              <option value="Hospital/Clinic">Hospital/Clinic</option>
                                                              <option value="Specialty Store">Specialty Store</option>
                                                              <option value="School">School</option>
                                                              <option value="Others">Others</option>


                                                           </select>
                                                       </div>
                                                   </div>

                                                   <div class="form-group">
                                                       <label class="col-md-4 control-label"><strong><b style="color: red;">*</b> Business Type :</strong></label>
                                                       <div class="col-md-8">
                                                           <select name="" id="business_type" data-error-msg="Business Type is required." required >
                                                              <option value="1" <?php echo (1==$company->business_type?'selected':''); ?> >Sole Proprietorship</option>
                                                              <option value="2" <?php echo (2==$company->business_type?'selected':''); ?>>Partnership</option>
                                                              <option  value="3" <?php echo (3==$company->business_type?'selected':''); ?> >Corporation</option>

                                                           </select>
                                                       </div>
                                                   </div>
                                                  <div class="form-group">
                                                       <label class="col-md-4 control-label"><strong><b style="color: red;">*</b> Tax Type :</strong></label>
                                                       <div class="col-md-8">
                                                           <select name="" id="tax_group" data-error-msg="Tax Type is required." required>
                                                               <!-- <option value="0">[ Create Tax Type Group ]</option> -->
                                                               <?php foreach($tax_type as $group){ ?>
                                                                   <option value="<?php echo $group->tax_type_id; ?>" <?php echo ($group->tax_type_id===$company->tax_type_id?'selected':''); ?> ><?php echo $group->tax_type; ?></option>
                                                               <?php } ?>
                                                           </select>
                                                       </div>
                                                   </div> 
                                                </div>
                                                <div class="col-lg-6">
                                                   <div class="form-group">
                                                       <label class="col-md-4  control-label"><strong>Logo :</strong></label>
                                                       <div class="col-md-5">
                                                           <div class="input-group">
                                                               <div class="" style="border:1px solid black;height: 230px;width: 210px;vertical-align: middle;">

                                                                   <div id="div_img_company" style="position:relative;">
                                                                       <img name="img_company" src="<?php echo $company->logo_path; ?>" style="object-fit: fill !important; height: 100%;width: 100%;" />
                                                                       <input  spellcheck="false" type="file" name="file_upload_company[]" class="hidden">
                                                                   </div>

                                                                   <div id="div_img_loader_company" style="display: none;">
                                                                        <img name="img_loader_compay" src="assets/img/loader/ajax-loader-sm.gif" style="display: block;margin:40% auto auto auto; " />
                                                                   </div>
                                                               </div>

                                                               <button type="button" id="btn_browse_company" class="btn btn-green "  style="margin-top: 2%;text-transform: capitalize;font-family: Tahoma, Georgia, Serif;">Browse Photo</button>&nbsp;
                                                               <button type="button" id="btn_remove_photo_company"  class="btn btn-red" style="margin-top: 2%;text-transform: capitalize;font-family: Tahoma, Georgia, Serif;">Remove</button>
                                                           </div>
                                                       </div>
                                                   </div>
                                                </div>
                                                </div>
                                                <button id="btn_save" type="button" class="btn-primary btn pull-right" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;"><span class=""></span>  Save</button>
                                                </form>
                                                </div>  <!-- END OF COMPANY INFO -->
                                                <div id="initial_general_configuration" style="display: none;">
                                                <form id="frm_account_integration" role="form" class="form-horizontal row-border">

                                                    <br >
                                                  <div class="row">
                                                  <div class="col-lg-6">
                                                    <h4><span style="margin-left: 1%"><strong><i class="fa fa-gear"></i> Supplier Integration Account</strong></span></h4>


                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label"> <b style="color: red;">*</b> Input Tax Account :</label>
                                                        <div class="col-md-8">
                                                            <select name="input_tax_account_id" class="cbo_accounts" data-error-msg="Input Tax Account is required." required>
                                                                <?php foreach($accounts as $account){ ?>
                                                                    <option value="<?php echo $account->account_id; ?>" <?php echo ($current_accounts->input_tax_account_id==$account->account_id?'selected':''); ?>  ><?php echo $account->account_title; ?></option>
                                                                <?php } ?>
                                                            </select>


                                                            <span class="help-block m-b-none">Input Tax is generally apply to the purchases of goods and services.</span>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label"> <b style="color: red;">*</b> Payable to Supplier :</label>
                                                        <div class="col-md-8">
                                                            <select name="payable_account_id"  class="cbo_accounts" data-error-msg="Payable Account is required." required>
                                                                <?php foreach($accounts as $account){ ?>
                                                                    <option value="<?php echo $account->account_id; ?>" <?php echo ($current_accounts->payable_account_id==$account->account_id?'selected':''); ?> ><?php echo $account->account_title; ?></option>
                                                                <?php } ?>
                                                            </select>


                                                            <span class="help-block m-b-none">Account that is used to represent the amount owes by the company.</span>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label"> <b style="color: red;">*</b> Discount from Supplier :</label>
                                                        <div class="col-md-8">
                                                            <select name="payable_discount_account_id"  class="cbo_accounts" data-error-msg="Discount Account is required." required>

                                                                <?php foreach($accounts as $account){ ?>
                                                                    <option value="<?php echo $account->account_id; ?>" <?php echo ($current_accounts->payable_discount_account_id==$account->account_id?'selected':''); ?>><?php echo $account->account_title; ?></option>
                                                                <?php } ?>
                                                            </select>

                                                            <span class="help-block m-b-none">Please select Discount Account.</span>
                                                        </div>
                                                    </div>



                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label"> <b style="color: red;">*</b> Payment to Supplier :</label>
                                                        <div class="col-md-8">
                                                            <select name="payment_to_supplier_id"  class="cbo_accounts" data-error-msg="Discount Account is required." required>

                                                                <?php foreach($accounts as $account){ ?>
                                                                    <option value="<?php echo $account->account_id; ?>" <?php echo ($current_accounts->payment_to_supplier_id==$account->account_id?'selected':''); ?>><?php echo $account->account_title; ?></option>
                                                                <?php } ?>
                                                            </select>

                                                            <span class="help-block m-b-none">Please select the account where payment to supplier will be credited.</span>
                                                        </div>
                                                    </div>
                                                  </div>
                                                  <div class="col-lg-6">
                                                    <h4><span style="margin-left: 1%"><strong><i class="fa fa-gear"></i> Customer Integration Account</strong></span></h4>


                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label"> <b style="color: red;">*</b> Output Tax Account :</label>
                                                        <div class="col-md-8">
                                                            <select name="output_tax_account_id"  class="cbo_accounts" data-error-msg="Output Tax account is required." required>

                                                                <?php foreach($accounts as $account){ ?>
                                                                    <option value="<?php echo $account->account_id; ?>" <?php echo ($current_accounts->output_tax_account_id==$account->account_id?'selected':''); ?>><?php echo $account->account_title; ?></option>
                                                                <?php } ?>
                                                            </select>

                                                            <span class="help-block m-b-none">Output tax is the amount charge on your own sales if you are registered as Vatted.</span>
                                                        </div>
                                                    </div>


                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label"> <b style="color: red;">*</b> Receivable from Customer :</label>
                                                        <div class="col-md-8">
                                                            <select name="receivable_account_id"  class="cbo_accounts" data-error-msg="Receivable account is required." required>

                                                                <?php foreach($accounts as $account){ ?>
                                                                    <option value="<?php echo $account->account_id; ?>" <?php echo ($current_accounts->receivable_account_id==$account->account_id?'selected':''); ?>><?php echo $account->account_title; ?></option>
                                                                <?php } ?>
                                                            </select>

                                                            <span class="help-block m-b-none">Account that represents the amount of goods and services credited by customer.</span>
                                                        </div>
                                                    </div>



                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label"> <b style="color: red;">*</b> Discount to Customer :</label>
                                                        <div class="col-md-8">
                                                            <select name="receivable_discount_account_id"  class="cbo_accounts" data-error-msg="Receivable account is required." required>
                                                                <?php foreach($accounts as $account){ ?>
                                                                    <option value="<?php echo $account->account_id; ?>" <?php echo ($current_accounts->receivable_discount_account_id==$account->account_id?'selected':''); ?>><?php echo $account->account_title; ?></option>
                                                                <?php } ?>
                                                            </select>

                                                            <span class="help-block m-b-none">Please select Discount Account.</span>
                                                        </div>
                                                    </div>


                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label"> <b style="color: red;">*</b> Collection Account :</label>
                                                        <div class="col-md-8">
                                                            <select name="payment_from_customer_id"  class="cbo_accounts" data-error-msg="Discount Account is required." required>

                                                                <?php foreach($accounts as $account){ ?>
                                                                    <option value="<?php echo $account->account_id; ?>" <?php echo ($current_accounts->payment_from_customer_id==$account->account_id?'selected':''); ?>><?php echo $account->account_title; ?></option>
                                                                <?php } ?>
                                                            </select>

                                                            <span class="help-block m-b-none">Please select the account where payment of customer will be posted.</span>
                                                        </div>
                                                    </div>
                                                  </div>
                                                  </div>
                                                    <br >
                                                    <div class="row">
                                                    <div class="col-lg-6">
                                                    <h4><span style="margin-left: 1%"><strong><i class="fa fa-gear"></i> Retained Earnings Account</strong></span></h4>
                                                    <div class="form-grou8">
                                                        <label class="col-md-4 control-label"> <b style="color: red;">*</b> Retained Earnings :</label>
                                                        <div class="col-md-8">
                                                            <select name="retained_earnings_id"  class="cbo_accounts" data-error-msg="Retained earnings is required." required>

                                                                <?php foreach($accounts as $account){ ?>
                                                                    <option value="<?php echo $account->account_id; ?>" <?php echo ($current_accounts->retained_earnings_id==$account->account_id?'selected':''); ?>><?php echo $account->account_title; ?></option>
                                                                <?php } ?>
                                                            </select>

                                                            <span class="help-block m-b-none">Please select the account where net income will be forwarded.</span>
                                                        </div>
                                                    </div>

                                                    <br >
                                                    <h4><span style="margin-left: 1%"><strong><i class="fa fa-gear"></i> Petty Cash Account</strong></span></h4>
                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label"> <b style="color: red;">*</b> Petty Cash :</label>
                                                        <div class="col-md-8">
                                                            <select name="petty_cash_account_id" class="cbo_accounts" data-error-msg="Petty Cash account is required." required>

                                                                <?php foreach($accounts as $account){ ?>
                                                                    <option value="<?php echo $account->account_id; ?>" <?php echo ($current_accounts->petty_cash_account_id==$account->account_id?'selected':''); ?>><?php echo $account->account_title; ?></option>
                                                                <?php } ?>
                                                            </select>

                                                            <span class="help-block m-b-none">Please select the account where petty cash will be forwarded.</span>
                                                        </div>
                                                    </div>
                                                    </div>
                                                    <div class="col-lg-6">  
                                                    <h4><span style="margin-left: 1%"><strong><i class="fa fa-gear"></i> Inventory</strong></span></h4>
                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label"> <b style="color: red;">*</b> Sales Invoice Integration :</label>
                                                        <div class="col-md-8">
                                                            <select name="sales_invoice_inventory" class="cbo_accounts" data-error-msg="Inventory is required." required>
                                                           

                                                            <option value="1" <?php echo ($current_accounts->sales_invoice_inventory == 1 ? 'selected' :'')   ?> >Enable</option>
                                                            <option value="0" <?php echo ($current_accounts->sales_invoice_inventory == 0 ? 'selected' :'')   ?>> Disable</option>
                                                            </select>

                                                            <span class="help-block m-b-none">Please select if Sales Invoices will be included in the Inventory computation.</span>
                                                        </div>
                                                    </div>


                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label"> <b style="color: red;">*</b> Cash Invoice Integration :</label>
                                                        <div class="col-md-8">
                                                            <select name="cash_invoice_inventory" class="cbo_accounts" data-error-msg="Inventory is required." required>
                                                           

                                                            <option value="1" <?php echo ($current_accounts->cash_invoice_inventory == 1 ? 'selected' :'')   ?> >Enable</option>
                                                            <option value="0" <?php echo ($current_accounts->cash_invoice_inventory == 0 ? 'selected' :'')   ?>> Disable</option>
                                                            </select>

                                                            <span class="help-block m-b-none">Please select if Cash Invoices will be included in the Inventory computation.</span>
                                                        </div>
                                                    </div>
                                                    </div>
                                                    </div>
                                                    <div class="row">
                                                    <div class="col-lg-6">

                                                    <br >
                                                    <h4><span style="margin-left: 1%"><strong><i class="fa fa-gear"></i> Depreciation Expense Account</strong></span></h4>
                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label"> <b style="color: red;">*</b> Debit Account :</label>
                                                        <div class="col-md-8">
                                                            <select name="depreciation_expense_debit_id"  class="cbo_accounts" data-error-msg="Depreciation Debit account is required." required>

                                                                <?php foreach($accounts as $account){ ?>
                                                                    <option value="<?php echo $account->account_id; ?>" <?php echo ($current_accounts->depreciation_expense_debit_id==$account->account_id?'selected':''); ?>><?php echo $account->account_title; ?></option>
                                                                <?php } ?>
                                                            </select>

                                                            <span class="help-block m-b-none">Account that represents the Debit Entry of the Depreciation Expense</span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label"> <b style="color: red;">*</b> Credit Account :</label>
                                                        <div class="col-md-8">
                                                            <select name="depreciation_expense_credit_id"  class="cbo_accounts" data-error-msg="Depreciation Credit account is required." required>

                                                                <?php foreach($accounts as $account){ ?>
                                                                    <option value="<?php echo $account->account_id; ?>" <?php echo ($current_accounts->depreciation_expense_credit_id==$account->account_id?'selected':''); ?>><?php echo $account->account_title; ?></option>
                                                                <?php } ?>
                                                            </select>

                                                            <span class="help-block m-b-none">Account that represents the Credit Entry of the Depreciation Expense</span>
                                                        </div>
                                                    </div>
                                                    </div>
                                                    <div class="col-lg-6">

                                                    <h4><span style="margin-left: 1%"><strong><i class="fa fa-gear"></i> Cash Invoice Account</strong></span></h4>
                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label"> <b style="color: red;">*</b> Collection Account :</label>
                                                        <div class="col-md-8">
                                                            <select name="cash_invoice_debit_id"  class="cbo_accounts" data-error-msg="Cash Invoice Debit account is required." required>
                                                                <?php foreach($accounts as $account){ ?>
                                                                    <option value="<?php echo $account->account_id; ?>" <?php echo ($current_accounts->cash_invoice_debit_id==$account->account_id?'selected':''); ?>><?php echo $account->account_title; ?></option>
                                                                <?php } ?>
                                                            </select>

                                                            <span class="help-block m-b-none">Please select the account where payment of customer from Cash invoice will be posted..</span>
                                                        </div>
                                                    </div>
                                                    <hr />

                                                    </div>
                                                    </div>
                                                    <div class="row">
                                                    <div class="col-lg-6">
                                                    <h4><span style="margin-left: 1%"><strong><i class="fa fa-gear"></i> Issuance Details</strong></span></h4>
                                                      <div class="form-group">
                                                          <label class="col-md-4 control-label"> <b class="required"> * </b> Debit Account :</label>
                                                          <div class="col-md-8">
                                                              <select name="iss_debit_id" class="cbo_accounts" data-error-msg="Debit Account is required." required>
                                                                  <?php foreach($accounts as $account){ ?>
                                                                      <option value="<?php echo $account->account_id; ?>" <?php echo ($current_accounts_purchasing->iss_debit_id==$account->account_id?'selected':''); ?>  ><?php echo $account->account_title; ?></option>
                                                                  <?php } ?>
                                                              </select>
                                                          <span class="help-block m-b-none">Please Choose Debit Account for the Issuance of Inventory</span>
                                                          </div><br>
                                                          
                                                      </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                    <h4><span style="margin-left: 1%"><strong><i class="fa fa-gear"></i> Adjustment Details</strong></span></h4>
                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label"> <b class="required"> * </b> Debit Account :</label>
                                                        <div class="col-md-8">
                                                            <select name="adj_debit_id" class="cbo_accounts" data-error-msg="Debit Account is required." required>
                                                                <?php foreach($accounts as $account){ ?>
                                                                    <option value="<?php echo $account->account_id; ?>" <?php echo ($current_accounts_purchasing->adj_debit_id==$account->account_id?'selected':''); ?>  ><?php echo $account->account_title; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                            <span class="help-block m-b-none">Please Choose Debit Account for the Adjustment OUT of Inventory</span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label"> <b class="required"> * </b> Credit Account :</label>
                                                        <div class="col-md-8">
                                                            <select name="adj_credit_id" class="cbo_accounts" data-error-msg="Credit Account is required." required>
                                                                <?php foreach($accounts as $account){ ?>
                                                                    <option value="<?php echo $account->account_id; ?>" <?php echo ($current_accounts_purchasing->adj_credit_id==$account->account_id?'selected':''); ?>  ><?php echo $account->account_title; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                            <span class="help-block m-b-none">Please Choose Credit Account for the Adjustment IN of Inventory</span>
                                                        </div>
                                                    </div>
                                                    </div>
                                                    </div>
                                                <button id="btn_save_supplier_accounts" type="button" class="btn btn-primary pull-right" style="font-family: tahoma;text-transform: none;padding: 6px 10px!important;"><span class=""></span> Save</button>
                                                </form>
                                                </div>
                                                <div id="initial_user" style="display: none;">
                                               <form id="frm_users" role="form" class="form-horizontal row-border">
                                                   <div class="row">
                                                    <div class="col-lg-4">
                                                     <div class="form-group">
                                                       <label class="col-md-4 control-label"><strong><b style="color: red;">*</b> User Name :</strong></label>
                                                       <div class="col-md-8">
                                                               <input type="text" name="user_name" class="form-control" placeholder="User Name" data-error-msg="User name is required!" required>
                                                       </div>
                                                   </div>

                                                   <div class="form-group">
                                                       <label class="col-md-4 control-label"><strong><b style="color: red;">*</b> User Group :</strong></label>

                                                       <div class="col-md-8">
                                                           <select name="" id="cbo_user_groups" data-error-msg="User group is required." required>
                                                               <?php foreach($user_groups as $group){ ?>
                                                                        <option value="<?php echo $group->user_group_id; ?>"><?php echo $group->user_group; ?></option>
                                                               <?php } ?>
                                                           </select>


                                                           <i class="help-block m-b-none"><b style="color: red;">*</b>Please select the correct user group of the user.</i>

                                                       </div>

                                                   </div>


                                                   <div class="form-group">
                                                       <label class="col-md-4 control-label"><strong><b style="color: red;">*</b> Password :</strong></label>
                                                       <div class="col-md-8">
                                                               <input type="password" name="user_pword" class="form-control" placeholder="Password" data-error-msg="Password is required!" required>
                                                       </div>
                                                   </div>

                                                   <div class="form-group">
                                                       <label class="col-md-4 control-label"><strong><b style="color: red;">*</b> Confirm Password :</strong></label>
                                                       <div class="col-md-8">
                                                               <input type="password" name="user_confirm_pword" class="form-control" placeholder="Confirm Password" data-error-msg="Please confirm password!" required>

                                                           <span class="help-block m-b-none">Please make sure password match.</span>
                                                       </div>
                                                   </div>
                                                   <div class="form-group">
                                                       <label class="col-md-4 control-label"><strong><b style="color: red;">*</b> Firstname :</strong></label>
                                                       <div class="col-md-8">
                                                               <input type="text" name="user_fname" class="form-control" placeholder="Firstname" data-error-msg="Firstname is required!" required>
                                                       </div>
                                                   </div>


                                                   <div class="form-group">
                                                       <label class="col-md-4 control-label"><strong>Middlename :</strong></label>
                                                       <div class="col-md-8">
                                                               <input type="text" name="user_mname" class="form-control" placeholder="Middlename">
                                                       </div>
                                                   </div>


                                                   <div class="form-group">
                                                       <label class="col-md-4 control-label"><strong><b style="color: red;">*</b> Lastname :</strong></label>
                                                       <div class="col-md-8">
                                                               <input type="text" name="user_lname" class="form-control" placeholder="Lastname" data-error-msg="Lastname is required!" required>
                                                       </div>
                                                   </div>


                                                   </div>
                                                   <div class="col-lg-4">
                                                   <div class="form-group">
                                                       <label class="col-md-4 control-label"><strong>Birthdate :</strong></label>
                                                       <div class="col-md-8">
                                                           <div class="input-group date">
                                                               <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input id="txt_bdate" name="user_bdate" type="text" class="form-control" value="<?php echo date("m/d/Y"); ?>">
                                                           </div>

                                                       </div>

                                                   </div>


                                                   <div class="form-group">
                                                       <label class="col-md-4 control-label"><strong>Address :</strong></label>
                                                       <div class="col-md-8">
                                                           <textarea name="user_address" class="form-control"></textarea>
                                                       </div>
                                                   </div>
                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label"><strong>Email Address :</strong></label>
                                                        <div class="col-md-8">
                                                                <input type="text" name="user_email" class="form-control" placeholder="Email Address">
                                                        </div>
                                                    </div>

                                                   <div class="form-group">
                                                       <label class="col-md-4 control-label"><strong>Landline :</strong></label>
                                                       <div class="col-md-8">
                                                               <input type="text" name="user_telephone" class="form-control" placeholder="Landline">
                                                       </div>
                                                   </div>

                                                   <div class="form-group">
                                                       <label class="col-md-4 control-label"><strong>Mobile No :</strong></label>
                                                       <div class="col-md-8">
                                                               <input type="text" name="user_mobile" class="form-control" placeholder="Mobile No">
                                                       </div>
                                                   </div>
                                                   </div>
                                                   <div class="col-lg-4">

                                                   <div class="form-group">
                                                       <label class="col-md-2  control-label"><strong>Photo :</strong></label>
                                                       <div class="col-md-5">
                                                           <div class="input-group">
                                                               <div class="row" style="border:1px solid black;height: 230px;width: 210px;vertical-align: middle;padding-bottom: 20px;">

                                                                   <div id="div_img_user" style="position:relative;">
                                                                       <img name="img_user" src="assets/img/anonymous-icon.png" style="padding-bottom: 50px; height: 277px; width: 207px;"/>
                                                                       <input type="file" name="file_upload_user[]" class="hidden">
                                                                   </div>

                                                                   <div id="div_img_loader_user" style="display: none;">
                                                                        <img name="img_loader_user" src="assets/img/loader/ajax-loader-sm.gif" style="display: block;margin:40% auto auto auto;" />
                                                                   </div>
                                                               </div>
                                                               <div class="row"><br><br>
                                                               <button type="button" id="btn_browse_user" class="btn btn-primary"  style="margin-top: 2%;text-transform: capitalize;font-family: Tahoma, Georgia, Serif;">Browse Photo</button>
                                                               <button type="button" id="btn_remove_photo_user"  class="btn btn-danger" style="margin-top: 2%;text-transform: capitalize;font-family: Tahoma, Georgia, Serif;">Remove</button>
                                                               </div>
                                                           </div>
                                                       </div>
                                                   </div>
                                                   </div>
                                                   </div>
                                                    <button id="btn_save_user" type="button" class="btn-primary btn pull-right" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;padding: 6px 10px!important;"><span class=""></span>  Save</button>
                                               </form>
                                               </div>
                                                    <br /><br />
                                                    <i id="note">Note: You can change these settings in the system.</i>
                                            </div>
                                            <div class="panel-footer">
                                                <div class="row">
                                                    <div class="col-sm-offset-10 col-sm-2 ">
                                                        
                                                        
                                                        
                                                    </div>
                                                </div>
                                            </div>
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
                        <div class="modal-header">
                            <button type="button" class="close"   data-dismiss="modal" aria-hidden="true">X</button>
                            <h4 class="modal-title"><span id="modal_mode"> </span>Confirm Deletion</h4>

                        </div>

                        <div class="modal-body">
                            <p id="modal-body-message">Are you sure ?</p>
                        </div>

                        <div class="modal-footer">
                            <button id="btn_yes" type="button" class="btn btn-danger" data-dismiss="modal" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;">Yes</button>
                            <button id="btn_close" type="button" class="btn btn-default" data-dismiss="modal" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;">No</button>
                        </div>
                    </div><!---content---->
                </div>
            </div><!---modal-->

            <div id="modal_tax_group" class="modal fade" tabindex="-1" role="dialog"><!--modal-->
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close"   data-dismiss="modal" aria-hidden="true">X</button>
                            <h4 class="modal-title"><span id="modal_mode"> </span>New Tax Group</h4>

                        </div>

                        <div class="modal-body">
                            <form id="frm_tax_group">
                                <div class="form-group">
                                    <label>* Tax Type :</label>
                                    <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-envelope-o"></i>
                                                </span>
                                        <input  spellcheck="false" type="text" name="tax_name" class="form-control" placeholder="Tax group" data-error-msg="Tax name is required." required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>* Tax Rate :</label>
                                    <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-envelope-o"></i>
                                                </span>
                                        <input  spellcheck="false" type="number" name="tax_rate" class="form-control" placeholder="Tax Rate" data-error-msg="Tax Rate is required." required>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label>Description :</label>
                                    <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <textarea name="tax_group_desc" class="form-control"></textarea>
                                    </div>
                                </div>
                            </form>


                        </div>

                        <div class="modal-footer">
                            <button id="btn_create_tax_group" type="button" class="btn btn-primary"  style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;"><span class=""></span> Create</button>
                            <button id="btn_close_user_group" type="button" class="btn btn-default" data-dismiss="modal" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>


            <footer role="contentinfo">
                <div class="clearfix">
                    <ul class="list-unstyled list-inline pull-left">
                          <li><h6 style="margin: 0;">&copy; 2018 - JDEV OFFICE SOLUTION INC.</h6></li>
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




<!-- Date range use moment.js same as full calendar plugin -->
<script src="assets/plugins/fullcalendar/moment.min.js"></script>
<!-- Data picker -->
<script src="assets/plugins/datapicker/bootstrap-datepicker.js"></script>

<!-- Select2 -->
<script src="assets/plugins/select2/select2.full.min.js"></script>





<script>
$("form").attr('autocomplete', 'off');
    $(document).ready(function(){
        var dt; var _txnMode; var _selectedID; var _selectRowObj; var _company_info; var _businesstype; var _accounts; var _businessnature;

        var setupcompany = $('#setupcompany').val();
        var setupgeneralconfiguration = $('#setupgeneralconfiguration').val();
        var setupuser = $('#setupuser').val();
        var setupcomplete = $('#setupcomplete').val();

        var initializeControls=function(){
          if(setupcomplete == true){
            window.open('Login');
          }else if(setupcompany == false && setupgeneralconfiguration == false && setupuser == false){
            $('#initial_general_configuration').hide();
            $('#initial_user').hide();
            $('#initial_company_info').show();
          }else if(setupcompany == true && setupgeneralconfiguration == false && setupuser == false){
            $('#initial_company_info').hide();
            $('#initial_user').hide();
            $('#initial_general_configuration').show();
          }else if(setupgeneralconfiguration == true && setupgeneralconfiguration == true && setupuser == false){
            $('#initial_general_configuration').hide();
            $('#initial_company_info').hide();
            $('#initial_user').show();
          } else if(setupuser == true){
            window.open('Login');
          }

              _accounts=$(".cbo_accounts").select2({
                  placeholder: "Please select account.",
                  allowClear: false
              });
            _company_info=$("#tax_group").select2({
                placeholder: "Please select Tax type",
                allowClear: true
            });

            _businesstype=$("#business_type").select2({
                placeholder: "Please select business type",
                allowClear: true
            });

            _businessnature=$("#nature_of_business").select2({
                placeholder: "Please select business nature",
                allowClear: true
            });

           // _company_info.select2('val', null)


            $('#txt_bdate').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true

            });
            _cboUserGroup=$("#cbo_user_groups").select2({
                placeholder: "Please select user group"
            });

            _cboUserGroup.select2('val', 1)


        }();






        var bindEventHandlers=(function(){
            var detailRows = [];

            $('#tbl_company_info tbody').on( 'click', 'tr td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = dt.row( tr );
                var idx = $.inArray( tr.attr('id'), detailRows );

                if ( row.child.isShown() ) {
                    tr.removeClass( 'details' );
                    row.child.hide();

                    // Remove from the 'open' array
                    detailRows.splice( idx, 1 );
                }
                else {
                    tr.addClass( 'details' );
                    //console.log(row.data());
                    row.child( format( row.data() ) ).show();
                    // Add to the 'open' array
                    if ( idx === -1 ) {
                        detailRows.push( tr.attr('id') );
                    }



                }
            } );



             $('#btn_browse_company').click(function(event){
                    event.preventDefault();
                    $('input[name="file_upload_company[]"]').click();
             });

             $('#btn_browse_user').click(function(event){
                    event.preventDefault();
                    $('input[name="file_upload_user[]"]').click();
             });


            $('#btn_remove_photo_company').click(function(event){
                event.preventDefault();
                $('img[name="img_company"]').attr('src','assets/img/anonymous-icon.png');
            });

            $('#btn_create_tax_group').click(function(){

                var btn=$(this);

                if(validateRequiredFields($('#frm_tax_group'))){
                    var data=$('#frm_tax_group').serializeArray();

                    $.ajax({
                        "dataType":"json",
                        "type":"POST",
                        "url":"Tax_groups/transaction/create",
                        "data":data,
                        "beforeSend" : function(){
                            showSpinningProgress(btn);
                        }
                    }).done(function(response){
                        showNotification(response);
                        $('#modal_tax_group').modal('hide');

                        var _group=response.row_added[0];
                        $('#tax_group').append('<option value="'+_group.tax_type_id+'" selected>'+_group.tax_type+'</option>');
                        $('#tax_group').select2('val',_group.tax_type_id);

                    }).always(function(){
                        showSpinningProgress(btn);
                    });
                }





            });



            $('#btn_yes').click(function(){
                removeCompanyInfo().done(function(response){
                    showNotification(response);
                    dt.row(_selectRowObj).remove().draw();
                });
            });

            $('#btn_save_supplier_accounts').click(function(){
                saveSettings().done(function(response){
                    showNotification(response);
                }).always(function(){
                    showSpinningProgress($('#btn_save_supplier_accounts'));
                                $('#initial_general_configuration').fadeOut('slow');
                                // $('#btn_save_supplier_accounts').fadeOut('slow');
                                $('#note').fadeOut('slow');
                                $('#note').fadeIn(3000);  
                                $('#initial_user').fadeIn(3000);
                                // $('#btn_save_user').fadeIn(3000);
                });
            });



                $('#btn_save_user').click(function(){

                    if(validateRequiredFields($('#frm_users'))){
                            createUserAccount().done(function(response){
                                showNotification(response);
                                if(response.stat=="success"){
                                  window.location.href = "login";
                                }

                            }).always(function(){
                                showSpinningProgress($('#btn_save_user'));
                            });

                    }

                });




            _company_info.on("select2:select", function (e) {

                var i=$(this).select2('val');
                if(i==0){
                    _company_info.select2('val',null)
                    $('#modal_tax_group').modal('show');
                    clearFields($('#modal_tax_group').find('form'));
                }


            });


                $('input[name="file_upload_user[]"]').change(function(event){
                    var _files=event.target.files;

                    $('#div_img_user').hide();
                    $('#div_img_loader_user').show();


                    var data=new FormData();
                    $.each(_files,function(key,value){
                        data.append(key,value);
                    });

                    console.log(_files);

                    $.ajax({
                        url : 'Initial_setup/transaction/upload_user',
                        type : "POST",
                        data : data,
                        cache : false,
                        dataType : 'json',
                        processData : false,
                        contentType : false,
                        success : function(response){
                            //console.log(response);
                            //alert(response.path);
                            $('#div_img_loader_user').hide();
                            $('#div_img_user').show();
                            $('img[name="img_user"]').attr('src',response.path);

                        }
                    });

                });

                $('input[name="file_upload_company[]"]').change(function(event){
                    var _files=event.target.files;

                    $('#div_img_company').hide();
                    $('#div_img_loader_company').show();


                    var data=new FormData();
                    $.each(_files,function(key,value){
                        data.append(key,value);
                    });

                    console.log(_files);

                    $.ajax({
                        url : 'Initial_setup/transaction/upload',
                        type : "POST",
                        data : data,
                        cache : false,
                        dataType : 'json',
                        processData : false,
                        contentType : false,
                        success : function(response){
                            //console.log(response);
                            //alert(response.path);
                            $('#div_img_loader_company').hide();
                            $('#div_img_company').show();
                            $('img[name="img_company"]').attr('src',response.path);

                        }
                    });

                });

                $('#btn_cancel').click(function(){
                    showList(true);
                });



                $('#btn_save').click(function(){

                    if(validateRequiredFields($('#frm_company'))){
                            createCompanyInfo().done(function(response){
                                showNotification(response);
                                if(response.stat=="success"){
                                  $('#initial_company_info').fadeOut('slow');
                                  // $('#btn_save').fadeOut('slow');
                                  $('#note').fadeOut('slow');
                                  $('#note').fadeIn(3000);  
                                  $('#initial_general_configuration').fadeIn(3000);
                                  // $('#btn_save_supplier_accounts').fadeIn(3000);
                                }
                            }).always(function(){
                                showSpinningProgress($('#btn_save'));
                            });


                    }

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


        var createCompanyInfo=function(){
            var _data=$('#frm_company').serializeArray();
            _data.push({name : "photo_path" ,value : $('img[name="img_company"]').attr('src')});
            _data.push({name : "tax_type_id" ,value : $('#tax_group').select2('val')});
            _data.push({name : "business_type" ,value : $('#business_type').select2('val')});

            return $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"Initial_setup/transaction/create_company",
                "data":_data,
                "beforeSend": showSpinningProgress($('#btn_save'))
            });
        };

        var createUserAccount=function(){
            var _data=$('#frm_users').serializeArray();
            _data.push({name : "photo_path" ,value : $('img[name="img_user"]').attr('src')});
            _data.push({name : "user_group_id" ,value : $('#cbo_user_groups').select2('val')});

            return $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"Initial_setup/transaction/create_user",
                "data":_data,
                "beforeSend": showSpinningProgress($('#btn_save_user'))
            });
        };



        var showNotification=function(obj){
            PNotify.removeAll(); //remove all notifications
            new PNotify({
                title:  obj.title,
                text:  obj.msg,
                type:  obj.stat
            });
        };

        var saveSettings=function(){
            var _data=$('#frm_account_integration').serializeArray();
            console.log(_data);

            return $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"Initial_setup/transaction/save-integration",
                "data":_data,
                "beforeSend": showSpinningProgress($('#btn_save_supplier_accounts'))

            });
        };

        var showSpinningProgress=function(e){
            $(e).find('span').toggleClass('glyphicon glyphicon-refresh spinning');
        };

        var clearFields=function(f){
            $('input,textarea',f).val('');
            $(f).find('select').select2('val',null);
            $(f).find('input:first').focus();
        };


        function format ( d ) {
            // `d` is the original data object for the row
            //alert(d.photo_path);
            return '<br /><table style="margin-left:10%;width: 80%;">' +
                    '<thead>' +
                    '</thead>' +
                    '<tbody>' +
                    '<tr>' +
                    '<td width="20%">Name : </td><td width="50%"><b>'+ d.user_name+'</b></td>' +
                    '<td rowspan="5" valign="top"><div class="avatar">'+
                    '<img src="'+ d.photo_path+'" class="img-circle" style="margin-top:0px;height: 100px;width: 100px;">'+
                    '</div></td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td>Address : </td><td><b>'+ d.user_address+'</b></td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td>Email : </td><td>'+ d.user_email+'</td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td>Mobile Nos. : </td><td>'+ d.user_mobile+'</td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td>Landline. : </td><td>'+ d.user_telephone+'</td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td>Active : </td><td><i class="fa fa-check"></i></td>' +
                    '</tr>' +
                    '</tbody></table><br />';






        };




        var substringMatcher = function(strs) {
            return function findMatches(q, cb) {
                var matches, substringRegex;

                // an array that will be populated with substring matches
                matches = [];

                // regex used to determine if a string contains the substring `q`
                substrRegex = new RegExp(q, 'i');

                // iterate through the pool of strings and for any string that
                // contains the substring `q`, add it to the `matches` array
                $.each(strs, function(i, str) {
                    if (substrRegex.test(str)) {
                        matches.push(str);
                    }
                });

                cb(matches);
            };
        };












    });




</script>


</body>


</html>