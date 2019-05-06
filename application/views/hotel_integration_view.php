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
        .tab-container .nav-tabs > li > a {
            border-radius: 0;
            padding: 9px 16px;
            font-weight: 100;
        }

        h5{
            margin-left: 20px;
        }
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

/*        .dropdown-menu > .active > a,.dropdown-menu > .active > a:hover{
            background-color: dodgerblue;
        }*/

        @keyframes spin {
            from { transform: scale(1) rotate(0deg); }
            to { transform: scale(1) rotate(360deg); }
        }

        @-webkit-keyframes spin2 {
            from { -webkit-transform: rotate(0deg); }
            to { -webkit-transform: rotate(360deg); }
        }

        label{
            text-align: left!important;
            font-weight: 600!important;
        }
    </style>
</head>

<body class="animated-content">

<?php echo $_top_navigation; ?>

<div id="wrapper">
<div id="layout-static">


<?php echo $_side_bar_navigation;

?>


<div class="static-content-wrapper white-bg">


<div class="static-content"  >
<div class="page-content"><!-- #page-content -->

<ol class="breadcrumb" style="margin-bottom: 0px;">
    <li><a href="dashboard">Dashboard</a></li>
    <li><a href="Hotel_integration">Hotel Integration </a></li>
</ol>


<div class="container-fluid">
<div data-widget-group="group1">
<div class="row">
    <div class="col-md-12">
        <div class="tab-container tab-top tab-primary">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#accounts_integration_setting" data-toggle="tab" style="font-family: tahoma;">Poleng Villa</a></li>
                <li ><a href="#poleng_apartment" data-toggle="tab" style="font-family: tahoma;">Poleng Apartment</a></li>
                <li ><a href="#red_rose" data-toggle="tab" style="font-family: tahoma;">Red Rose</a></li>
                <li ><a href="#hayvenhurst" data-toggle="tab" style="font-family: tahoma;">Hayvenhurst</a></li>


            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="accounts_integration_setting" style="min-height: 300px;">
                    <form id="frm_poleng_villa" role="form" class="form-horizontal row-border">
                    <div class="row">
                        <div class="col-md-2 " style=" width: 11.666667%;">
                            <button id="btn_save_poleng_villa" type="button" class="btn btn-primary " style="padding: 7px 7px 7px 7px!important; font-family: tahoma;text-transform: none;"><span class=""></span> Save Changes</button>
                        </div>
                        <div class="col-md-3">
                             <h2 class="form-inline"><i class="fa fa-gear"></i>  Poleng Villa</h2>
                        </div>

                    </div>
                       
                        
                        <input type="hidden" name="department_id" value="2">
                        <h5><span style="margin-left: 1%"><strong> Asset Integration Account</strong></span></h5>
                        <div class="form-group">
                            <label class="col-md-2  col-md-offset-1 control-label"> * Cash Payment :</label>
                            <div class="col-md-4 col-md-offset-0 col-md-offset-3 col-md-offset-3">
                                <select name="cash_id" class="cbo_accounts" data-error-msg="Cash Payment Account is required." required>
                                    <?php foreach($accounts as $account){ ?>
                                        <option value="<?php echo $account->account_id; ?>" <?php echo ($poleng_villa_accounts->cash_id==$account->account_id?'selected':''); ?>  ><?php echo $account->account_title; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2  col-md-offset-1 control-label"> * Check Account :</label>
                            <div class="col-md-4 col-md-offset-0 col-md-offset-3 col-md-offset-3">
                                <select name="check_id"  class="cbo_accounts" data-error-msg="Check Account is required." required>
                                    <?php foreach($accounts as $account){ ?>
                                        <option value="<?php echo $account->account_id; ?>" <?php echo ($poleng_villa_accounts->check_id==$account->account_id?'selected':''); ?> ><?php echo $account->account_title; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2  col-md-offset-1 control-label"> * Credit Card :</label>
                            <div class="col-md-4 col-md-offset-0 col-md-offset-3 col-md-offset-3">
                                <select name="card_id"  class="cbo_accounts" data-error-msg="Credit Card Account is required." required>

                                    <?php foreach($accounts as $account){ ?>
                                        <option value="<?php echo $account->account_id; ?>" <?php echo ($poleng_villa_accounts->card_id==$account->account_id?'selected':''); ?>><?php echo $account->account_title; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2  col-md-offset-1 control-label"> * Charge Account :</label>
                            <div class="col-md-4 col-md-offset-0 col-md-offset-3 col-md-offset-3">
                                <select name="charge_id"  class="cbo_accounts" data-error-msg="Charge Account Account is required." required>

                                    <?php foreach($accounts as $account){ ?>
                                        <option value="<?php echo $account->account_id; ?>" <?php echo ($poleng_villa_accounts->charge_id==$account->account_id?'selected':''); ?>><?php echo $account->account_title; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2  col-md-offset-1 control-label"> * Bank Account:</label>
                            <div class="col-md-4 col-md-offset-0 col-md-offset-3 col-md-offset-3">
                                <select name="bank_id" class="cbo_accounts" data-error-msg="Advance Bank Account is required." required>
                                    <?php foreach($accounts as $account){ ?>
                                        <option value="<?php echo $account->account_id; ?>" <?php echo ($poleng_villa_accounts->bank_id==$account->account_id?'selected':''); ?>  ><?php echo $account->account_title; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <br>
                        <h5><span style="margin-left: 1%"><strong> Liability Integration Accounts</strong></span></h5>
                        <div class="form-group">
                            <label class="col-md-2  col-md-offset-1 control-label"> * Advance Cash:</label>
                            <div class="col-md-4 col-md-offset-0 col-md-offset-3">
                                <select name="adv_cash_id" class="cbo_accounts" data-error-msg="Advance Cash Account is required." required>
                                    <?php foreach($accounts as $account){ ?>
                                        <option value="<?php echo $account->account_id; ?>" <?php echo ($poleng_villa_accounts->adv_cash_id==$account->account_id?'selected':''); ?>  ><?php echo $account->account_title; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2  col-md-offset-1 control-label"> * Advance Check :</label>
                            <div class="col-md-4 col-md-offset-0 col-md-offset-3 col-md-offset-3">
                                <select name="adv_check_id" class="cbo_accounts" data-error-msg="Advance Check Account is required." required>
                                    <?php foreach($accounts as $account){ ?>
                                        <option value="<?php echo $account->account_id; ?>" <?php echo ($poleng_villa_accounts->adv_check_id==$account->account_id?'selected':''); ?>  ><?php echo $account->account_title; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2  col-md-offset-1 control-label"> * Advance Card :</label>
                            <div class="col-md-4 col-md-offset-0 col-md-offset-3 col-md-offset-3">
                                <select name="adv_card_id" class="cbo_accounts" data-error-msg="Advance Card Account is required." required>
                                    <?php foreach($accounts as $account){ ?>
                                        <option value="<?php echo $account->account_id; ?>" <?php echo ($poleng_villa_accounts->adv_card_id==$account->account_id?'selected':''); ?>  ><?php echo $account->account_title; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2  col-md-offset-1 control-label"> * Advance Charge :</label>
                            <div class="col-md-4 col-md-offset-0 col-md-offset-3 col-md-offset-3">
                                <select name="adv_charge_id" class="cbo_accounts" data-error-msg="Advance Charge Account is required." required>
                                    <?php foreach($accounts as $account){ ?>
                                        <option value="<?php echo $account->account_id; ?>" <?php echo ($poleng_villa_accounts->adv_charge_id==$account->account_id?'selected':''); ?>  ><?php echo $account->account_title; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2  col-md-offset-1 control-label"> * Advance Bank :</label>
                            <div class="col-md-4 col-md-offset-0 col-md-offset-3 col-md-offset-3">
                                <select name="adv_bank_id" class="cbo_accounts" data-error-msg="Advance Bank Account is required." required>
                                    <?php foreach($accounts as $account){ ?>
                                        <option value="<?php echo $account->account_id; ?>" <?php echo ($poleng_villa_accounts->adv_bank_id==$account->account_id?'selected':''); ?>  ><?php echo $account->account_title; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <h5><span style="margin-left: 1%"><strong> Income Integration Accounts</strong></span></h5>
                        <div class="form-group">
                            <label class="col-md-2  col-md-offset-1 control-label"> * Room Sales :</label>
                            <div class="col-md-4 col-md-offset-0 col-md-offset-3 col-md-offset-3">
                                <select name="room_sales_id" class="cbo_accounts" data-error-msg="Room Sales Account is required." required>
                                    <?php foreach($accounts as $account){ ?>
                                        <option value="<?php echo $account->account_id; ?>" <?php echo ($poleng_villa_accounts->room_sales_id==$account->account_id?'selected':''); ?>  ><?php echo $account->account_title; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2  col-md-offset-1 control-label"> * Bar Sales :</label>
                            <div class="col-md-4 col-md-offset-0 col-md-offset-3 col-md-offset-3">
                                <select name="bar_sales_id" class="cbo_accounts" data-error-msg="Bar Sales Account is required." required>
                                    <?php foreach($accounts as $account){ ?>
                                        <option value="<?php echo $account->account_id; ?>" <?php echo ($poleng_villa_accounts->bar_sales_id==$account->account_id?'selected':''); ?>  ><?php echo $account->account_title; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2  col-md-offset-1 control-label"> * Other Sales :</label>
                            <div class="col-md-4 col-md-offset-0 col-md-offset-3 col-md-offset-3">
                                <select name="other_sales_id" class="cbo_accounts" data-error-msg="Other Sales Account is required." required>
                                    <?php foreach($accounts as $account){ ?>
                                        <option value="<?php echo $account->account_id; ?>" <?php echo ($poleng_villa_accounts->other_sales_id==$account->account_id?'selected':''); ?>  ><?php echo $account->account_title; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2  col-md-offset-1 control-label"> * Advance Sales:</label>
                            <div class="col-md-4 col-md-offset-0 col-md-offset-3 col-md-offset-3">
                                <select name="adv_sales_id" class="cbo_accounts" data-error-msg="Other Sales Account is required." required>
                                    <?php foreach($accounts as $account){ ?>
                                        <option value="<?php echo $account->account_id; ?>" <?php echo ($poleng_villa_accounts->adv_sales_id==$account->account_id?'selected':''); ?>  ><?php echo $account->account_title; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div><br>
                        <h5><span style="margin-left: 1%"><strong> Customer Account</strong></span></h5>
                        <div class="form-group">
                            <label class="col-md-2  col-md-offset-1 control-label"> * Customer:</label>
                            <div class="col-md-4 col-md-offset-0 col-md-offset-3">
                                <select name="customer_id" class="cbo_accounts" data-error-msg="Customer is required." required>
                                    <?php foreach($customers as $customer){ ?>
                                        <option value="<?php echo $customer->customer_id; ?>" <?php echo ($poleng_villa_accounts->customer_id==$customer->customer_id?'selected':''); ?>  ><?php echo $customer->customer_name; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <br>
                        <br >
                        <hr />
                        <div class=" col-lg-offset-3">

                        </div>
                    </form>
                </div>
























                <div class="tab-pane" id="poleng_apartment" style="min-height: 300px;">
                    <form id="frm_poleng_apartment" role="form" class="form-horizontal row-border">
                        <div class="row">
                            <div class="col-md-2 " style=" width: 11.666667%;">
                            <button id="btn_save_poleng_apartment" type="button" class="btn btn-primary" style="padding: 7px 7px 7px 7px!important; font-family: tahoma;text-transform: none;"><span class=""></span> Save Changes</button>
                            </div>
                            <div class="col-md-3">
                                 <h2 class="form-inline"><i class="fa fa-gear"></i>  Poleng Apartment</h2>
                            </div>

                        </div>
                        <h5><span style="margin-left: 1%"><strong> Asset Integration Account</strong></span></h5>
                        <div class="form-group">
                        <input type="hidden" name="department_id" value="3">
                            <label class="col-md-2  col-md-offset-1 control-label"> * Cash Payment :</label>
                            <div class="col-md-4 col-md-offset-0 col-md-offset-3 col-md-offset-3">
                                <select name="cash_id" class="cbo_accounts" data-error-msg="Cash Payment Account is required." required>
                                    <?php foreach($accounts as $account){ ?>
                                        <option value="<?php echo $account->account_id; ?>" <?php echo ($poleng_apartment_accounts->cash_id==$account->account_id?'selected':''); ?>  ><?php echo $account->account_title; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2  col-md-offset-1 control-label"> * Check Account :</label>
                            <div class="col-md-4 col-md-offset-0 col-md-offset-3 col-md-offset-3">
                                <select name="check_id"  class="cbo_accounts" data-error-msg="Check Account is required." required>
                                    <?php foreach($accounts as $account){ ?>
                                        <option value="<?php echo $account->account_id; ?>" <?php echo ($poleng_apartment_accounts->check_id==$account->account_id?'selected':''); ?> ><?php echo $account->account_title; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2  col-md-offset-1 control-label"> * Credit Card :</label>
                            <div class="col-md-4 col-md-offset-0 col-md-offset-3 col-md-offset-3">
                                <select name="card_id"  class="cbo_accounts" data-error-msg="Credit Card Account is required." required>

                                    <?php foreach($accounts as $account){ ?>
                                        <option value="<?php echo $account->account_id; ?>" <?php echo ($poleng_apartment_accounts->card_id==$account->account_id?'selected':''); ?>><?php echo $account->account_title; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2  col-md-offset-1 control-label"> * Charge Account :</label>
                            <div class="col-md-4 col-md-offset-0 col-md-offset-3 col-md-offset-3">
                                <select name="charge_id"  class="cbo_accounts" data-error-msg="Charge Account Account is required." required>

                                    <?php foreach($accounts as $account){ ?>
                                        <option value="<?php echo $account->account_id; ?>" <?php echo ($poleng_apartment_accounts->charge_id==$account->account_id?'selected':''); ?>><?php echo $account->account_title; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2  col-md-offset-1 control-label"> * Bank Account:</label>
                            <div class="col-md-4 col-md-offset-0 col-md-offset-3 col-md-offset-3">
                                <select name="bank_id" class="cbo_accounts" data-error-msg="Advance Bank Account is required." required>
                                    <?php foreach($accounts as $account){ ?>
                                        <option value="<?php echo $account->account_id; ?>" <?php echo ($poleng_apartment_accounts->bank_id==$account->account_id?'selected':''); ?>  ><?php echo $account->account_title; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <br>
                        <h5><span style="margin-left: 1%"><strong> Liability Integration Accounts</strong></span></h5>
                        <div class="form-group">
                            <label class="col-md-2  col-md-offset-1 control-label"> * Advance Cash:</label>
                            <div class="col-md-4 col-md-offset-0 col-md-offset-3">
                                <select name="adv_cash_id" class="cbo_accounts" data-error-msg="Advance Cash Account is required." required>
                                    <?php foreach($accounts as $account){ ?>
                                        <option value="<?php echo $account->account_id; ?>" <?php echo ($poleng_apartment_accounts->adv_cash_id==$account->account_id?'selected':''); ?>  ><?php echo $account->account_title; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2  col-md-offset-1 control-label"> * Advance Check :</label>
                            <div class="col-md-4 col-md-offset-0 col-md-offset-3 col-md-offset-3">
                                <select name="adv_check_id" class="cbo_accounts" data-error-msg="Advance Check Account is required." required>
                                    <?php foreach($accounts as $account){ ?>
                                        <option value="<?php echo $account->account_id; ?>" <?php echo ($poleng_apartment_accounts->adv_check_id==$account->account_id?'selected':''); ?>  ><?php echo $account->account_title; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2  col-md-offset-1 control-label"> * Advance Card :</label>
                            <div class="col-md-4 col-md-offset-0 col-md-offset-3 col-md-offset-3">
                                <select name="adv_card_id" class="cbo_accounts" data-error-msg="Advance Card Account is required." required>
                                    <?php foreach($accounts as $account){ ?>
                                        <option value="<?php echo $account->account_id; ?>" <?php echo ($poleng_apartment_accounts->adv_card_id==$account->account_id?'selected':''); ?>  ><?php echo $account->account_title; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2  col-md-offset-1 control-label"> * Advance Charge :</label>
                            <div class="col-md-4 col-md-offset-0 col-md-offset-3 col-md-offset-3">
                                <select name="adv_charge_id" class="cbo_accounts" data-error-msg="Advance Charge Account is required." required>
                                    <?php foreach($accounts as $account){ ?>
                                        <option value="<?php echo $account->account_id; ?>" <?php echo ($poleng_apartment_accounts->adv_charge_id==$account->account_id?'selected':''); ?>  ><?php echo $account->account_title; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2  col-md-offset-1 control-label"> * Advance Bank :</label>
                            <div class="col-md-4 col-md-offset-0 col-md-offset-3 col-md-offset-3">
                                <select name="adv_bank_id" class="cbo_accounts" data-error-msg="Advance Bank Account is required." required>
                                    <?php foreach($accounts as $account){ ?>
                                        <option value="<?php echo $account->account_id; ?>" <?php echo ($poleng_apartment_accounts->adv_bank_id==$account->account_id?'selected':''); ?>  ><?php echo $account->account_title; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <h5><span style="margin-left: 1%"><strong> Income Integration Accounts</strong></span></h5>
                        <div class="form-group">
                            <label class="col-md-2  col-md-offset-1 control-label"> * Room Sales :</label>
                            <div class="col-md-4 col-md-offset-0 col-md-offset-3 col-md-offset-3">
                                <select name="room_sales_id" class="cbo_accounts" data-error-msg="Room Sales Account is required." required>
                                    <?php foreach($accounts as $account){ ?>
                                        <option value="<?php echo $account->account_id; ?>" <?php echo ($poleng_apartment_accounts->room_sales_id==$account->account_id?'selected':''); ?>  ><?php echo $account->account_title; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2  col-md-offset-1 control-label"> * Bar Sales :</label>
                            <div class="col-md-4 col-md-offset-0 col-md-offset-3 col-md-offset-3">
                                <select name="bar_sales_id" class="cbo_accounts" data-error-msg="Bar Sales Account is required." required>
                                    <?php foreach($accounts as $account){ ?>
                                        <option value="<?php echo $account->account_id; ?>" <?php echo ($poleng_apartment_accounts->bar_sales_id==$account->account_id?'selected':''); ?>  ><?php echo $account->account_title; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2  col-md-offset-1 control-label"> * Other Sales :</label>
                            <div class="col-md-4 col-md-offset-0 col-md-offset-3 col-md-offset-3">
                                <select name="other_sales_id" class="cbo_accounts" data-error-msg="Other Sales Account is required." required>
                                    <?php foreach($accounts as $account){ ?>
                                        <option value="<?php echo $account->account_id; ?>" <?php echo ($poleng_apartment_accounts->other_sales_id==$account->account_id?'selected':''); ?>  ><?php echo $account->account_title; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2  col-md-offset-1 control-label"> * Advance Sales:</label>
                            <div class="col-md-4 col-md-offset-0 col-md-offset-3 col-md-offset-3">
                                <select name="adv_sales_id" class="cbo_accounts" data-error-msg="Other Sales Account is required." required>
                                    <?php foreach($accounts as $account){ ?>
                                        <option value="<?php echo $account->account_id; ?>" <?php echo ($poleng_apartment_accounts->adv_sales_id==$account->account_id?'selected':''); ?>  ><?php echo $account->account_title; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div><br>
                        <h5><span style="margin-left: 1%"><strong> Customer Account</strong></span></h5>
                        <div class="form-group">
                            <label class="col-md-2  col-md-offset-1 control-label"> * Customer:</label>
                            <div class="col-md-4 col-md-offset-0 col-md-offset-3">
                                <select name="customer_id" class="cbo_accounts" data-error-msg="Customer is required." required>
                                    <?php foreach($customers as $customer){ ?>
                                        <option value="<?php echo $customer->customer_id; ?>" <?php echo ($poleng_apartment_accounts->customer_id==$customer->customer_id?'selected':''); ?>  ><?php echo $customer->customer_name; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <br>
                        <br>
                        <br >
                        <hr />
                        <div class=" col-lg-offset-3">

                        </div>
                    </form>
                </div>







                <div class="tab-pane" id="red_rose" style="min-height: 300px;">
                    <form id="frm_red_rose" role="form" class="form-horizontal row-border">
                        <div class="row">
                            <div class="col-md-2 " style=" width: 11.666667%;">
                            <button id="btn_save_red_rose" type="button" class="btn btn-primary" style="padding: 7px 7px 7px 7px!important; font-family: tahoma;text-transform: none;"><span class=""></span> Save Changes</button>
                            </div>
                            <div class="col-md-3">
                                 <h2 class="form-inline"><i class="fa fa-gear"></i>  Red Rose</h2>
                            </div>

                        </div>
                        <h5><span style="margin-left: 1%"><strong> Asset Integration Account</strong></span></h5>
                        <div class="form-group">
                        <input type="hidden" name="department_id" value="4">
                            <label class="col-md-2  col-md-offset-1 control-label"> * Cash Payment :</label>
                            <div class="col-md-4 col-md-offset-0 col-md-offset-3 col-md-offset-3">
                                <select name="cash_id" class="cbo_accounts" data-error-msg="Cash Payment Account is required." required>
                                    <?php foreach($accounts as $account){ ?>
                                        <option value="<?php echo $account->account_id; ?>" <?php echo ($red_rose_accounts->cash_id==$account->account_id?'selected':''); ?>  ><?php echo $account->account_title; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2  col-md-offset-1 control-label"> * Check Account :</label>
                            <div class="col-md-4 col-md-offset-0 col-md-offset-3 col-md-offset-3">
                                <select name="check_id"  class="cbo_accounts" data-error-msg="Check Account is required." required>
                                    <?php foreach($accounts as $account){ ?>
                                        <option value="<?php echo $account->account_id; ?>" <?php echo ($red_rose_accounts->check_id==$account->account_id?'selected':''); ?> ><?php echo $account->account_title; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2  col-md-offset-1 control-label"> * Credit Card :</label>
                            <div class="col-md-4 col-md-offset-0 col-md-offset-3 col-md-offset-3">
                                <select name="card_id"  class="cbo_accounts" data-error-msg="Credit Card Account is required." required>

                                    <?php foreach($accounts as $account){ ?>
                                        <option value="<?php echo $account->account_id; ?>" <?php echo ($red_rose_accounts->card_id==$account->account_id?'selected':''); ?>><?php echo $account->account_title; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2  col-md-offset-1 control-label"> * Charge Account :</label>
                            <div class="col-md-4 col-md-offset-0 col-md-offset-3 col-md-offset-3">
                                <select name="charge_id"  class="cbo_accounts" data-error-msg="Charge Account Account is required." required>

                                    <?php foreach($accounts as $account){ ?>
                                        <option value="<?php echo $account->account_id; ?>" <?php echo ($red_rose_accounts->charge_id==$account->account_id?'selected':''); ?>><?php echo $account->account_title; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2  col-md-offset-1 control-label"> * Bank Account:</label>
                            <div class="col-md-4 col-md-offset-0 col-md-offset-3 col-md-offset-3">
                                <select name="bank_id" class="cbo_accounts" data-error-msg="Advance Bank Account is required." required>
                                    <?php foreach($accounts as $account){ ?>
                                        <option value="<?php echo $account->account_id; ?>" <?php echo ($red_rose_accounts->bank_id==$account->account_id?'selected':''); ?>  ><?php echo $account->account_title; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <h5><span style="margin-left: 1%"><strong> Income Integration Accounts</strong></span></h5>
                        <div class="form-group">
                            <label class="col-md-2  col-md-offset-1 control-label"> * Room Sales :</label>
                            <div class="col-md-4 col-md-offset-0 col-md-offset-3 col-md-offset-3">
                                <select name="room_sales_id" class="cbo_accounts" data-error-msg="Room Sales Account is required." required>
                                    <?php foreach($accounts as $account){ ?>
                                        <option value="<?php echo $account->account_id; ?>" <?php echo ($red_rose_accounts->room_sales_id==$account->account_id?'selected':''); ?>  ><?php echo $account->account_title; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2  col-md-offset-1 control-label"> * Bar Sales :</label>
                            <div class="col-md-4 col-md-offset-0 col-md-offset-3 col-md-offset-3">
                                <select name="bar_sales_id" class="cbo_accounts" data-error-msg="Bar Sales Account is required." required>
                                    <?php foreach($accounts as $account){ ?>
                                        <option value="<?php echo $account->account_id; ?>" <?php echo ($red_rose_accounts->bar_sales_id==$account->account_id?'selected':''); ?>  ><?php echo $account->account_title; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2  col-md-offset-1 control-label"> * Other Sales :</label>
                            <div class="col-md-4 col-md-offset-0 col-md-offset-3 col-md-offset-3">
                                <select name="other_sales_id" class="cbo_accounts" data-error-msg="Other Sales Account is required." required>
                                    <?php foreach($accounts as $account){ ?>
                                        <option value="<?php echo $account->account_id; ?>" <?php echo ($red_rose_accounts->other_sales_id==$account->account_id?'selected':''); ?>  ><?php echo $account->account_title; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div><br>
                        <h5><span style="margin-left: 1%"><strong> Customer Account</strong></span></h5>
                        <div class="form-group">
                            <label class="col-md-2  col-md-offset-1 control-label"> * Customer:</label>
                            <div class="col-md-4 col-md-offset-0 col-md-offset-3">
                                <select name="customer_id" class="cbo_accounts" data-error-msg="Customer is required." required>
                                    <?php foreach($customers as $customer){ ?>
                                        <option value="<?php echo $customer->customer_id; ?>" <?php echo ($red_rose_accounts->customer_id==$customer->customer_id?'selected':''); ?>  ><?php echo $customer->customer_name; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <br>
                        <br >
                        <hr />
                    </form>
                </div>





                <div class="tab-pane" id="hayvenhurst" style="min-height: 300px;">
                    <form id="frm_hayvenhurst" role="form" class="form-horizontal row-border">
                        <div class="row">
                            <div class="col-md-2 " style=" width: 11.666667%;">
                            <button id="btn_save_hayvenhurst" type="button" class="btn btn-primary" style="padding: 7px 7px 7px 7px!important; font-family: tahoma;text-transform: none;"><span class=""></span> Save Changes</button>
                            </div>
                            <div class="col-md-3">
                                 <h2 class="form-inline"><i class="fa fa-gear"></i>  Hayvenhurst</h2>
                            </div>

                        </div>
                        <h5><span style="margin-left: 1%"><strong> Asset Integration Account</strong></span></h5>
                        <div class="form-group">
                        <input type="hidden" name="department_id" value="5">
                            <label class="col-md-2  col-md-offset-1 control-label"> * Cash Payment :</label>
                            <div class="col-md-4 col-md-offset-0 col-md-offset-3 col-md-offset-3">
                                <select name="cash_id" class="cbo_accounts" data-error-msg="Cash Payment Account is required." required>
                                    <?php foreach($accounts as $account){ ?>
                                        <option value="<?php echo $account->account_id; ?>" <?php echo ($hayvenhurst_accounts->cash_id==$account->account_id?'selected':''); ?>  ><?php echo $account->account_title; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2  col-md-offset-1 control-label"> * Check Account :</label>
                            <div class="col-md-4 col-md-offset-0 col-md-offset-3 col-md-offset-3">
                                <select name="check_id"  class="cbo_accounts" data-error-msg="Check Account is required." required>
                                    <?php foreach($accounts as $account){ ?>
                                        <option value="<?php echo $account->account_id; ?>" <?php echo ($hayvenhurst_accounts->check_id==$account->account_id?'selected':''); ?> ><?php echo $account->account_title; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2  col-md-offset-1 control-label"> * Credit Card :</label>
                            <div class="col-md-4 col-md-offset-0 col-md-offset-3 col-md-offset-3">
                                <select name="card_id"  class="cbo_accounts" data-error-msg="Credit Card Account is required." required>

                                    <?php foreach($accounts as $account){ ?>
                                        <option value="<?php echo $account->account_id; ?>" <?php echo ($hayvenhurst_accounts->card_id==$account->account_id?'selected':''); ?>><?php echo $account->account_title; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2  col-md-offset-1 control-label"> * Charge Account :</label>
                            <div class="col-md-4 col-md-offset-0 col-md-offset-3 col-md-offset-3">
                                <select name="charge_id"  class="cbo_accounts" data-error-msg="Charge Account Account is required." required>

                                    <?php foreach($accounts as $account){ ?>
                                        <option value="<?php echo $account->account_id; ?>" <?php echo ($hayvenhurst_accounts->charge_id==$account->account_id?'selected':''); ?>><?php echo $account->account_title; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2  col-md-offset-1 control-label"> * Bank Account:</label>
                            <div class="col-md-4 col-md-offset-0 col-md-offset-3 col-md-offset-3">
                                <select name="bank_id" class="cbo_accounts" data-error-msg="Advance Bank Account is required." required>
                                    <?php foreach($accounts as $account){ ?>
                                        <option value="<?php echo $account->account_id; ?>" <?php echo ($hayvenhurst_accounts->bank_id==$account->account_id?'selected':''); ?>  ><?php echo $account->account_title; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <h5><span style="margin-left: 1%"><strong> Income Integration Accounts</strong></span></h5>
                        <div class="form-group">
                            <label class="col-md-2  col-md-offset-1 control-label"> * Room Sales :</label>
                            <div class="col-md-4 col-md-offset-0 col-md-offset-3 col-md-offset-3">
                                <select name="room_sales_id" class="cbo_accounts" data-error-msg="Room Sales Account is required." required>
                                    <?php foreach($accounts as $account){ ?>
                                        <option value="<?php echo $account->account_id; ?>" <?php echo ($hayvenhurst_accounts->room_sales_id==$account->account_id?'selected':''); ?>  ><?php echo $account->account_title; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2  col-md-offset-1 control-label"> * Bar Sales :</label>
                            <div class="col-md-4 col-md-offset-0 col-md-offset-3 col-md-offset-3">
                                <select name="bar_sales_id" class="cbo_accounts" data-error-msg="Bar Sales Account is required." required>
                                    <?php foreach($accounts as $account){ ?>
                                        <option value="<?php echo $account->account_id; ?>" <?php echo ($hayvenhurst_accounts->bar_sales_id==$account->account_id?'selected':''); ?>  ><?php echo $account->account_title; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2  col-md-offset-1 control-label"> * Other Sales :</label>
                            <div class="col-md-4 col-md-offset-0 col-md-offset-3 col-md-offset-3">
                                <select name="other_sales_id" class="cbo_accounts" data-error-msg="Other Sales Account is required." required>
                                    <?php foreach($accounts as $account){ ?>
                                        <option value="<?php echo $account->account_id; ?>" <?php echo ($hayvenhurst_accounts->other_sales_id==$account->account_id?'selected':''); ?>  ><?php echo $account->account_title; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div><br>
                        <h5><span style="margin-left: 1%"><strong> Customer Account</strong></span></h5>
                        <div class="form-group">
                            <label class="col-md-2  col-md-offset-1 control-label"> * Customer:</label>
                            <div class="col-md-4 col-md-offset-0 col-md-offset-3">
                                <select name="customer_id" class="cbo_accounts" data-error-msg="Customer is required." required>
                                    <?php foreach($customers as $customer){ ?>
                                        <option value="<?php echo $customer->customer_id; ?>" <?php echo ($hayvenhurst_accounts->customer_id==$customer->customer_id?'selected':''); ?>  ><?php echo $customer->customer_name; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <br>
                        <br >
                        <hr />
                    </form>
                </div>
















            </div> <!-- END OF TAB CONTENT -->
        </div>
    </div>
</div>
</div>
</div> <!-- .container-fluid -->

</div> <!-- #page-content -->
</div>




<footer role="contentinfo">
    <div class="clearfix">
        <ul class="list-unstyled list-inline pull-left">
            <li><h6 style="margin: 0;">&copy; 2017 - JDEV OFFICE SOLUTION INC</h6></li>
        </ul>
        <button class="pull-right btn btn-link btn-xs hidden-print" id="back-to-top"><i class="ti ti-arrow-up"></i></button>
    </div>
</footer>




</div>
</div>


</div>


<?php echo $_switcher_settings; ?>
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
$(document).ready(function(){
    var dt; var _txnMode; var _selectedID; var _selectRowObj; var _accounts;



    var initializeControls=function(){

        _accounts=$(".cbo_accounts").select2({
            placeholder: "Please select account.",
            allowClear: false
        });

        var createToolBarButton=function() {
            var _btnNew='<button class="btn btn-primary"  id="btn_close_accounting" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;" data-toggle="modal" data-target="" data-placement="left" title="Close Accounting Period" >'+
                '<i class="fa fa-bars"></i> Close Accounting Period</button>';
                $("div.toolbar").html(_btnNew);
        }();

    }();






    var bindEventHandlers=(function(){
    $('#btn_save_poleng_villa').click(function(){   
        var _data=$('#frm_poleng_villa').serializeArray();
        console.log(_data);
            return $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"Hotel_integration/transaction/save",
                "data":_data,
                "beforeSend": showSpinningProgress($('#btn_save_poleng_villa'))
            }).done(function(response){
                        showNotification(response);
            }).always(function(){
                showSpinningProgress($('#btn_save_poleng_villa'));
            });
        });
    $('#btn_save_poleng_apartment').click(function(){   
        var _data=$('#frm_poleng_apartment').serializeArray();
        console.log(_data);
            return $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"Hotel_integration/transaction/save",
                "data":_data,
                "beforeSend": showSpinningProgress($('#btn_save_poleng_apartment'))
            }).done(function(response){
                        showNotification(response);
            }).always(function(){
                showSpinningProgress($('#btn_save_poleng_apartment'));
            });
        });
    $('#btn_save_red_rose').click(function(){   
        var _data=$('#frm_red_rose').serializeArray();
        console.log(_data);
            return $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"Hotel_integration/transaction/save",
                "data":_data,
                "beforeSend": showSpinningProgress($('#btn_save_red_rose'))
            }).done(function(response){
                        showNotification(response);
            }).always(function(){
                showSpinningProgress($('#btn_save_red_rose'));
            });
        });
    $('#btn_save_hayvenhurst').click(function(){   
        var _data=$('#frm_hayvenhurst').serializeArray();
        console.log(_data);
            return $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"Hotel_integration/transaction/save",
                "data":_data,
                "beforeSend": showSpinningProgress($('#btn_save_hayvenhurst'))
            }).done(function(response){
                        showNotification(response);
            }).always(function(){
                showSpinningProgress($('#btn_save_hayvenhurst'));
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



    var saveSettings=function(){
        var _data=$('#frm_poleng_villa').serializeArray();
        console.log(_data);

        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Hotel_integration/transaction/save",
            "data":_data,
            "beforeSend": showSpinningProgress($('#btn_save_poleng_villa'))

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



    var showSpinningProgress=function(e){
        $(e).toggleClass('disabled');
        $(e).find('span').toggleClass('glyphicon glyphicon-refresh spinning');
    };

    var clearFields=function(f){
        $('input,textarea',f).val('');
        $(f).find('select').select2('val',null);
        $(f).find('input:first').focus();
    };

    var showList=function(b){
        if(b){
            $('#div_account_year_list').show();
            $('#div_account_year_fields').hide();
        }else{
            $('#div_account_year_list').hide();
            $('#div_account_year_fields').show();
        }
    };











});




</script>


</body>


</html>