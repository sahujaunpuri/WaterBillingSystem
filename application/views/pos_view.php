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
    <link href="assets/plugins/datapicker/datepicker3.css" rel="stylesheet">
    <link href="assets/plugins/select2/select2.min.css" rel="stylesheet">
    <!--/twitter typehead-->
    <link href="assets/plugins/twittertypehead/twitter.typehead.css" rel="stylesheet">

        <style>
        @media only screen and (min-width : 768px)   {
                .btn-shortcuts{
                    min-height: 100px;
                    min-width: 95px;
                    width: auto;
                    display:table;
                    display:inline-block;
                    margin: 0 auto;
                    font-size: 12px;
                }

        }
        /* Desktops and laptops ----------- */
        @media only screen  and (min-width : 1366px) {
            .btn-shortcuts{
                min-height: 100px;
                min-width: 105px;
                width: auto;
                display:table;
                display:inline-block;
                margin: 0 auto;
                font-size: 12px;
            }
        }


            html, 
            body {
                height: 100%;
                overflow:hidden;
                color: black;
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


            .btn-keypad{
                height: 65px;
                width: 110px;
                margin-left: 5px;
                margin-right: 5px;
                font-size: 14px;
                margin: 2px 1px 2px 1px;
                padding: 0px 0px 0px 0px ;
                border-radius: 5px;
            }
            .btn-keypad-qty{
                height: 63px;
                width: 106px;
                margin-left: 5px;
                margin-right: 5px;
                font-size: 20px;
                margin: 2px 1px 2px 2px;
                padding: 0px 0px 0px 0px;
                border-radius: 1px;
                color: #a01111;
                border: 1px solid gray;

            }
            .btn-enter, .btn-enter-qty{
                height: 65px;
                width: 400px;
                margin-left: 5px;
                margin-right: 5px;
                font-size: 14px;
                margin: 5px 1px 2px 1px;
                padding: 0px 0px 0px 0px ;
                border-radius: 5px;
            }
            .numeric {
                text-align: right;
            } 
            .btn-keypad, .btn-enter, .btn-enter-qty, .btn-keypad-qty{
                background-color: #76ffe4;
            }
            .btn-shortcuts{
                background-color: #d3dae0;
            }
            .btn-shortcuts:hover, .btn-keypad:hover, .btn-enter:hover, .btn-keypad-qty:hover, .btn-enter-qty:hover, {
                box-shadow: 2px 2px 10px black;
                background-color: #89c8fb;

            }

            .btn-shortcuts:hover{
                box-shadow: 2px 2px 10px black;
                background-color: #e1e2e2;

            }
           .btn-shortcuts:focus, .btn-shortcuts:hover {
                color: #333;
                text-decoration: none;
            }

            input[id^='payment_']{
                border: none;
                font-size: 20px;
            }
            input[readonly]{

                border:none;
                background-color: transparent; 
            }
            .form-control-button[readonly]{
                background-color: transparent;
                border:none;
                font-weight: normal;
            }

            hr.summary{
                    margin-top: 7px;
                    margin-bottom: 6px;
                    border: 0;
                    border-top: 1px solid #d8d8d8;

            }
            #tbl_payment td {
                padding: 0px 10px 1px 10px!important;
            }
            .scroll-panel-pymnt {
                overflow: scroll;
                max-height: 270px;
                overflow-x: hidden;
                border: 1px solid #CFD8DC;
                margin: 0px !important;
            }
            div.main-summary{
                background-color: black;
                width: 100%
            }
            div label.main-summary-label {
                color: white;
                padding:  5px 5px 5px 5px;
                text-transform: uppercase;
                font-size: 20px;
                font-weight: bold;
            }
            .main-summary-numeric{
                color:yellow;
                font-size: 55px;
                font-weight: normal;
                text-align: right;
                display: block;
                padding: 0px 5px 0px 5px;
                margin-top: -30px;
            }
            .table td {
                padding: 2px 10px 2px 10px!important;
                padding-top: 2px !important;
                padding-right: 10px !important;
                padding-bottom: 2px !important;
                padding-left: 10px !important;
            }
            .modal-header {

                padding: 1px 1px 1px 10px;
                background-color: white!important; 
            }
            .modal-title {
                font-size: 15px;
                font-weight: 300;
            }
            .modal-dialog.modal-md {
                width: 655px;
            }
            .tt-head, .tt-items, .tt-menu, .tt-open {
                display: none!important;
            }
            .helper {
                display: inline-block;
                height: 100%;
                vertical-align: middle;
            }
            #typeaheadsearch{
                border-radius: 0px !important;
            }
            #typeaheadsearch:focus{
                background-color: rgb(255, 249, 196)!important;
            }
            #table_items_tr tr th{
                padding-top: 2px !important;
                padding-right: 10px !important;
                padding-bottom: 2px !important;
                padding-left: 10px !important;
            }
            #tbl_products_filter 
            {
                display:none;
            }
            .dtsearch{
                width: 100%;
                border: 1px solid;
                padding: 2px;
            }

            .btn-yes-no{
                text-transform: none!important;
                font-size: 12px!important;
                padding: 4px 31px!important;
                font-size: 13px!important;
                border-radius: 6px;
            }
            .modal-open{

                padding-right: 0px!important;
            }
            .btn-shortcut-label{
                height: 32px;
                vertical-align: top;
            }
            .btn-shortcut-label-key{
                font-weight: normal;
                font-size: 11px;
            }
            .btn-default:focus, .btn-default.focus {
                color: #000000
                background-color: #090909;
                border:1px solid #000000!important;
            }
            .senior-control:focus  {
             background-color: rgb(255, 249, 196)!important;
            }
            .hide-div{
                display: none;
            }
        </style>

    </head>

    <body class="animated-content"  >
    <!-- <body class="animated-content" oncontextmenu="return false" > -->
        <div id="wrapper">
            <div id="layout-static">
        <div class="static-content-wrapper white-bg">
            <div class="static-content"  >
                <div class="page-content"><!-- #page-content --><br>
                   <div class="container-fluid" id="truncate-div">
                        <div data-widget-group="group1">

<div class="row">
<div class="col-lg-8" style="padding-right: 0px;width: 70.666667%">
<!-- <div class="col-lg-12" style="padding-right: 0px;"> -->
<div class="col-sm-12" style="padding: 0px;border: 1px solid #d4cece;padding: 2px;">
    <img src="assets/img/pos-system-v2.png" style="width: 100%">
</div>
<div class="col-sm-12" style="padding: 0px;">
            <form id="frm_items">
                <div class="table-responsive" id="tbody_items_responsive" style="">
                <table style="width: 100%;font-font:tahoma;margin:0px;" id="table_items_tr" class="table table-striped" cellspacing="0" width="100%" >
                    <thead class="">    
                        <tr>
                            <th width="5%"><span></span></th>
                            <th width="30%">Item</th> 
                            <th width="10%">UM</th> 
                            <th width="15%" style="text-align: right;">Unit Price</th> 
                            <th width="10%" style="text-align: right;">Quantity</th>

                            <th style="text-align: right;display: none;">Discount % </th>

                            <th width="15%" style="text-align: right;">Total Discount</th>  

                            <th style="display: none;">Tax %</th>
                            <th  style="text-align: right;display: none;">Gross</th>

                            <th width="15%" style="text-align: right;">Total</th>

                            <th style="display: none;">Vat Input(Total Line Tax)</th> 
                            <th style="display: none;">Net of Vat (Price w/out Tax)</th>  
                            <td style="display: none;">Item ID</td>
                            <th style="display: none;">Total after Global</th> 
                            <th style="display: none;">Dis Type</th> 
                            <th style="display: none;">REF TAX</th> 
                            <th style="display: none;">Zero Rated</th>
                            <th style="display: none;">VAT EX</th>
                        </tr>
                        </thead>

                </table>
                    <table id="tbl_items" class="table table-striped" cellspacing="0" width="100%" style="font-font:tahoma;height: 350px!important;overflow: auto;display: block;margin-bottom: 10px">



                        <tbody id="tbody_items">
                        </tbody>
                        <tfoot style="display: none;">
                            <tr>
                                <td colspan="7" style="height: 50px;">&nbsp;</td>
                            </tr>
                            <tr>
                                <td style="text-align: right;">Discount %:</td>
                                <td align="right" colspan="1" id="" color="red">
                                <input id="txt_overall_discount" name="total_overall_discount" type="text" class="numeric form-control" value="0.00" />
                                <input type="hidden" id="txt_overall_discount_amount" name="total_overall_discount_amount" class="numeric form-control" value="0.00" readonly></td>

                                <td style="text-align: right;">Total After Discount:</td>
                                <td id="td_total_after_discount" style="text-align: right">0.00</td>

                                <td style="text-align: right;" colspan="2">Total Before Tax:</td>
                                <td id="td_total_before_tax" style="text-align: right">0.00</td>
                            </tr>
                            <tr>
                                <td colspan="3" style="text-align: right;"><strong><i class="glyph-icon icon-star"></i> Tax :</strong></td>
                                <td align="right" colspan="1" id="td_tax" color="red">0.00</td>
                                <td colspan="2"  style="text-align: right;"><strong><i class="glyph-icon icon-star"></i> Total After Tax :</strong></td>
                                <td align="right" colspan="1" id="td_after_tax" color="red">0.00</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </form>
            <label class="control-label" style="font-family: Tahoma;font-size: 14px"><strong>Scan PLU / Barcode Here :</strong></label><br>
        <div id="custom-templates" class="" style="position: relative;bottom: 1px;">
            <input class="typeahead" id="typeaheadsearch" type="text" style="vertical-align: bottom!important;">
            <br>
        Total Items: <label id="total_items">0</label><br>
        Total Qty: <label id="total_qty">0</label>
        </div><br />
</div>
</div>
<div class="col-lg-4" style="width: 29.333333%;">
    <div class="main-summary">
        <label class="main-summary-label">Amount Due :</label><br>
        <label id="main_summary_amount_due" class="main-summary-numeric">0.00</label>

    </div>
    <div class="main-summary">
        <label class="main-summary-label">Tendered :</label><br>
        <label id="main_summary_tendered" class="main-summary-numeric">0.00</label>
    </div>
    <div class="main-summary">
        <label class="main-summary-label">Change </label><br>
        <label id="main_summary_change"  class="main-summary-numeric">0.00</label>
    </div>
    <div style="width: 100%;border: 1px solid gray;height: 250px;white-space: nowrap; text-align: center; margin: 1em 0;">
    <span class="helper"></span>
    <img src="assets/img/jdev-logo2.png" style="max-width: 100%;max-height: 100%;vertical-align: center;">

    </div>
</div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div>


        </div>
        <div class="row" style="width: 100%;align-items: center;margin-right: 0px;margin-left: 0px;">
        <div class="col-sm-12" style="padding: 0px;">
        <center>
            <button type="button" class="btn-shortcuts" id="btn_focus_grid">
                <img src="assets/img/pos/f1.png" class="btn-shortcut-label">
                <br><label class="btn-shortcut-label-key" >F1 - Focus Grid</label></button>
            </button>
            <button type="button" class="btn-shortcuts" id="btn_barcode">
                <img src="assets/img/pos/f2.png" class="btn-shortcut-label">
                <br><label class="btn-shortcut-label-key">F2 - Scan Barcode</label></button>
            <button type="button" class="btn-shortcuts" id="btn_browse">
                <img src="assets/img/pos/f3.png" class="btn-shortcut-label">
                <br><label class="btn-shortcut-label-key">F3 - Browse Item</label></button>
            <button type="button" class="btn-shortcuts" id="btn_void">
                <img src="assets/img/pos/f4.png" class="btn-shortcut-label">
                <br><label class="btn-shortcut-label-key">F4 - Void</label></button>
            <button type="button" class="btn-shortcuts">
                <img src="assets/img/pos/f5.png" class="btn-shortcut-label">
                <br><label class="btn-shortcut-label-key">F5 - Journal</label></button>
            <button type="button" class="btn-shortcuts" id="btn_payment">
                <img src="assets/img/pos/f6.png" class="btn-shortcut-label">
                <br><label class="btn-shortcut-label-key">F6 - Payment </label></button>
            <button type="button" class="btn-shortcuts">
                <img src="assets/img/pos/f7.png" class="btn-shortcut-label">
                <br><label class="btn-shortcut-label-key">F7- Open Drawer</label></button>
            <button type="button" class="btn-shortcuts" id="btn_cancel">
                <img src="assets/img/pos/f8.png" class="btn-shortcut-label" style="    margin-bottom: 7px;">
                <br><label class="btn-shortcut-label-key">F8 - Cancel</label></button>
            <button type="button" class="btn-shortcuts" id="btn_hold">
                <img src="assets/img/pos/f9.png" class="btn-shortcut-label">
                <br><label class="btn-shortcut-label-key">F9 - Hold</label></button>
            <button type="button" class="btn-shortcuts" id="btn_discount">
                <img src="assets/img/pos/f10.png" class="btn-shortcut-label">
                <br><label class="btn-shortcut-label-key">F10 - Discount</label></button>
            <button type="button" class="btn-shortcuts" id="btn_qty">
                <img src="assets/img/pos/f11.png" class="btn-shortcut-label">
                <br><label class="btn-shortcut-label-key">F11 - Qty</label></button>
            <button type="button" class="btn-shortcuts">
                <img src="assets/img/pos/f12.png" class="btn-shortcut-label">
                <br><label class="btn-shortcut-label-key">F12 - Close Sales </label></button>
        </center>
        </div>
        </div>
    </div>
</div>
                            <div class="row" style="display: none;">
                                <div class="col-md-12">
                                    <div id="div_tax_list" >
                                        <div class="panel panel-default">
                                            <div class="panel-body table-responsive" style="box-shadow: none!important;">
                                            <h2 class="h2-panel-heading"> POS SYSTEM</h2><hr>
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <b class="required">*</b><label>Customer :</label> <br />
                                                        <select name="customer" id="cbo_customers" data-error-msg="Customer is required." required>
                                                            <?php foreach($customers as $customer){ ?>
                                                                <option data-address="<?php echo $customer->address; ?>" data-contact="<?php echo $customer->contact_name; ?>" value="<?php echo $customer->customer_id; ?>" data-term-default="<?php echo ($customer->term=="none"?"":$customer->term); ?>"><?php echo $customer->customer_name; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-2 col-sm-offset-2">
                                                        <b class="required">*</b> <label>Invoice Date :</label> <br />
                                                        <div class="input-group">
                                                            <input type="text" name="date_invoice" id="invoice_default" class="date-picker form-control" value="<?php echo date("m/d/Y"); ?>" placeholder="Date Invoice" data-error-msg="Please set the date this items are issued!" required>
                                                             <span class="input-group-addon">
                                                                 <i class="fa fa-calendar"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
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

<div id="modal_process_payment" class="modal " role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: #2ecc71">
                 <h2 id="" class="modal-title" style="color:white;">Payment</h2>
            </div>
            <div class="modal-body">
                <form id="frm_payment" role="form" class="form-horizontal">
                <div class="row">
                    <label for='print_receipt'> Print Receipt</label> <input type="checkbox" name="print_receipt" id="print_receipt">
                </div>
                <div class="row">
                <div class="col-sm-7">
                            <table class="table table-striped" id="tbl_payment" style="font-size: 13px;">
                                <tr>
                                    <td colspan="2"><b><center>Type of Payment</center></b></td>
                                </tr>
                                <tr>
                                    <td><button type="button" id="typeofpayment_card" class="btn btn-default"><i class="fa fa-plus" aria-hidden="true"></i></button> ALT 1 - Card</td>
                                    <td><input type="text" class="numeric form-control form-control-button" id="payment_card" readonly></td>
                                </tr>
                                <tr>
                                    <td><button type="button" id="typeofpayment_check" class="btn btn-default"><i class="fa fa-plus" aria-hidden="true"></i></button> ALT 2 - Check</td>
                                    <td><input type="text" class="numeric form-control form-control-button" id="payment_check" readonly></td>
                                </tr>
                                <tr>
                                    <td><button type="button" id="typeofpayment_gc" class="btn btn-default"><i class="fa fa-plus" aria-hidden="true"></i></button> ALT 3 - GC</td>
                                    <td><input type="text" class="numeric form-control form-control-button" id="payment_charge" readonly></td>
                                </tr>
                                <tr>
                                    <td><button type="button" id="typeofpayment_charge" class="btn btn-default"><i class="fa fa-plus" aria-hidden="true"></i></button> ALT 4 - Charge</td>
                                    <td><input type="text" class="numeric form-control form-control-button" id="payment_gc" readonly></td>
                                </tr>

                                <tr>
                                    <td><button type="button" id="typeofpayment_" class="btn btn-default"><i class="fa fa-plus" aria-hidden="true"></i></button> ALT 5 - Cash</td>
                                    <td><input type="text" class="numeric form-control form-control-button" id="payment_cash" readonly></td>
                                </tr>
                                <tr>
                                    <td colspan="2"><input type="text" class="numeric form-control form-control-button" id="payment_total" readonly></td>
                                </tr>
                            </table>
                            <h4>
                                <strong>AMOUNT DUE: <hr class="summary"></strong><input type="text" name="" id="summary_amount_due" class="form-control numeric form-control-button" readonly="" style="font-size: 25px;color: red;">
                            </h4>
                            <h4>
                               <strong> TENDERED:  <hr class="summary"></strong><input type="text" name="" id="summary_tendered" class="form-control numeric form-control-button" style="font-size: 25px;color: green;border:none;font-weight: normal;">
                            </h4>
                            <h4>
                               <strong> CHANGE:  <hr class="summary"></strong><input type="text" name="" id="summary_change" class="form-control numeric form-control-button" readonly="" style="font-size: 25px;color: red;font-weight: bold;">
                            </h4>
                </div>
                <div class="col-sm-5" >
                    <div class="row  senior-citizen" style="line-height: 7px;">
                    <table class="table table-striped" id="" style="font-size: 13px;background-color: #f9f9f9;margin-bottom: 10px;width: 92%;">
                    <tr>
                        <td style="text-align: center;font-weight: bold;">Senior Citizen Information</td>
                    </tr>
                    <tr>
                        <td>                        
                            <label for="sen_name">Name:</label><br>
                            <input type="text" name="sernior_name" id="sen_name" style="width: 93%;height: 30px;" class="form-control senior-control">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="sen_id">Id No:</label>
                            <input type="text" name="sernior_id" id="sen_id" style="width: 93%;height: 30px;" class="form-control senior-control">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="sen_add">Address:</label><br>
                            <input type="text" name="sernior_address" id="sen_add" style="width: 93%;height: 30px;" class="form-control senior-control">
                        </td>
                    </tr>
                    </table>
                    </div>
                    <div class="row whole_number">
                        <div class="col-sm-4" style="padding: 0px;width: 31.333333%;"><button type="button" class="btn-keypad" id="whole_100"><b>100</b></button></div>
                        <div class="col-sm-4" style="padding: 0px;width: 31.333333%;"><button type="button" class="btn-keypad" id="whole_50"><b>50</b></button></div>
                        <div class="col-sm-4" style="padding: 0px;width: 31.333333%;"><button type="button" class="btn-keypad" id="whole_20"><b>20</b></button></div>
                    </div>
                    <div class="row whole_number">
                        <div class="col-sm-4" style="padding: 0px;width: 31.333333%"><button type="button" class="btn-keypad" id="whole_1000"><b>1000</b></button></div>
                        <div class="col-sm-4" style="padding: 0px;width: 31.333333%"><button type="button" class="btn-keypad" id="whole_500"><b>500</b></button></div>
                        <div class="col-sm-4" style="padding: 0px;width: 31.333333%;"><button type="button" class="btn-keypad" id="whole_200"><b>200</b></button></div>
                    </div><br>
                    <div class="row">
                        <div class="col-sm-4" style="padding: 0px;width: 31.333333%;"><button type="button" class="btn-keypad" id="calculator_7"><b>7</b></button></div>
                        <div class="col-sm-4" style="padding: 0px;width: 31.333333%;"><button type="button" class="btn-keypad" id="calculator_8"><b>8</b></button></div>
                        <div class="col-sm-4" style="padding: 0px;width: 31.333333%;"><button type="button" class="btn-keypad" id="calculator_9"><b>9</b></button></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4" style="padding: 0px;width: 31.333333%;"><button type="button" class="btn-keypad" id="calculator_4"><b>4</b></button></div>
                        <div class="col-sm-4" style="padding: 0px;width: 31.333333%;"><button type="button" class="btn-keypad" id="calculator_5"><b>5</b></button></div>
                        <div class="col-sm-4" style="padding: 0px;width: 31.333333%;"><button type="button" class="btn-keypad" id="calculator_6"><b>6</b></button></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4" style="padding: 0px;width: 31.333333%;"><button type="button" class="btn-keypad" id="calculator_1"><b>1</b></button></div>
                        <div class="col-sm-4" style="padding: 0px;width: 31.333333%;"><button type="button" class="btn-keypad" id="calculator_2"><b>2</b></button></div>
                        <div class="col-sm-4" style="padding: 0px;width: 31.333333%;"><button type="button" class="btn-keypad" id="calculator_3"><b>3</b></button></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4" style="padding: 0px;width: 31.333333%;"><button type="button" class="btn-keypad" id="calculator_0"><b>0</b></button></div>
                        <div class="col-sm-4" style="padding: 0px;width: 31.333333%;"><button type="button" class="btn-keypad" id="action_clear"><b>CLEAR</b></button></div>
                        <div class="col-sm-4" style="padding: 0px;width: 31.333333%;"><button type="button" class="btn-keypad" id="action_cancel"><b>CANCEL</b></button></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12" style="padding: 0px;">
                            <button type="button" class="btn-enter" style="width: 344px;"><b>ENTER</b></button>
                            
                        </div>
                    </div>
                </div>
                </div>
                </form>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>



<div id="modal_payment_card" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header" style="background: #2ecc71">
                 <h2 id="" class="modal-title" style="color:white;">Card</h2>
            </div>  
            <div class="modal-body">
                <div class="row">
                <div class="col-sm-12">
                        <form id="frm_modal_card" role="form" class="form-horizontal">
                            <div class="col-md-12">
                                     <label class="control-label boldlabel" style="text-align:right;">Card Holder Name: :</label>
                                <div class="form-group" style="margin-bottom: 2px;">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-user" style="font-size: 13px;"></i>
                                        </span>
                                        <input type="text" name="modal_card_name" class="form-control" required data-error-msg="Card Holder Name is Required !">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                     <label class="control-label boldlabel" style="text-align:right;">Card Approval Number:</label>
                                <div class="form-group" style="margin-bottom: 2px;">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i i class="ti ti-wallet" style="font-size: 13px;"></i>
                                        </span>
                                        <input type="text" name="modal_card_approval" class="form-control" data-error-msg="Department is required." required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                     <label class="control-label boldlabel" style="text-align:right;">Card Number:</label>
                                <div class="form-group" style="margin-bottom: 2px;">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-phone" style="font-size: 13px;"></i>
                                        </span>
                                        <input type="text" name="modal_card_no" class="form-control"  required data-error-msg="Card Number is Required !">
                                    </div>
                                </div>
                            </div>
                            <input type="text" name="modal_card_id"  id='modal_card_id' class="form-control" required data-error-msg="Card is required! " style="display: none;">

                            <div class="col-md-12">
                                     <label class="control-label boldlabel" style="text-align:right;">Amount:</label>
                                <div class="form-group" style="margin-bottom: 2px;">
                                        <input type="text" name="modal_card_amount" id="modal_card_amount" class="form-control numeric" value="0.00" style="height: 50px;font-size: 25px;color: green;">
                                </div>
                            </div>
                        </form>
                </div>

            </div>
            <div class="modal-footer">
                <button id="btn_modal_card_cancel" type="button" class="btn btn-primary btn-pymnt pull-left">
                    <strong> Cancel Card</strong>
                </button>
                <button id="btn_modal_card_clear" type="button" class="btn btn-primary btn-pymnt pull-left">
                    <strong> Clear</strong>
                </button>
                <button id="btn_modal_card_save" type="button" class="btn btn-success btn-pymnt">
                    <strong> Save</strong>
                </button>
                <button type="button" class="btn btn-danger btn-pymnt" data-dismiss="modal" aria-label="Close">
                    <strong> Close</strong>
                </button>
            </div>
        </div>
    </div>
</div>
</div>



<div id="modal_payment_check" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header" style="background: #2ecc71">
                 <h2 id="" class="modal-title" style="color:white;">Check</h2>
            </div>
            <div class="modal-body">
                <div class="row">
                <div class="col-sm-4">
                    <div class="scroll-panel-pymnt">
                    </div>
                </div>
                <div class="col-sm-8">
                        <form id="frm_modal_check" role="form" class="form-horizontal">
                            <div class="col-md-12">
                                     <label class="control-label boldlabel" style="text-align:right;">Branch / Address:</label>
                                <div class="form-group" style="margin-bottom: 2px;">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i i class="ti ti-wallet" style="font-size: 13px;"></i>
                                        </span>
                                        <input type="text" name="modal_check_address" class="form-control" data-error-msg="Branch / Address is required." required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                     <label class="control-label boldlabel" style="text-align:right;">Check Number:</label>
                                <div class="form-group" style="margin-bottom: 2px;">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-phone" style="font-size: 13px;"></i>
                                        </span>
                                        <input type="text" name="modal_check_no" class="form-control"  required data-error-msg="Check Number is Required !">
                                    </div>
                                </div>
                            </div>
                            <input type="text" name="modal_check_id"  id='modal_check_id' class="form-control" required data-error-msg="Check is required! " style="display: none;">

                            <div class="col-md-12">
                                     <label class="control-label boldlabel" style="text-align:right;">Amount:</label>
                                <div class="form-group" style="margin-bottom: 2px;">
                                        <input type="text" name="modal_check_amount" id="modal_check_amount" class="form-control numeric" value="0.00" style="height: 50px;font-size: 25px;color: green;">
                                </div>
                            </div>
                        </form>
                </div>
            </div>
            <div class="modal-footer">
                <button id="btn_modal_check_cancel" type="button" class="btn btn-primary btn-pymnt pull-left">
                    <strong> Cancel Check</strong>
                </button>
                <button id="btn_modal_check_clear" type="button" class="btn btn-primary btn-pymnt pull-left">
                    <strong> Clear</strong>
                </button>
                <button id="btn_modal_check_save" type="button" class="btn btn-success btn-pymnt">
                    <strong> Save</strong>
                </button>
                <button type="button" class="btn btn-danger btn-pymnt" data-dismiss="modal" aria-label="Close">
                    <strong> Close</strong>
                </button>
            </div>
        </div>
    </div>
</div>
</div>

<div id="modal_payment_gc" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header" style="background: #2ecc71">
                 <h2 id="" class="modal-title" style="color:white;">Gift Certificate</h2>
            </div>
            <div class="modal-body">
                <div class="row">
                <div class="col-sm-4">
                    <div class="scroll-panel-pymnt">
                    </div>
                </div>
                <div class="col-sm-8">
                        <form id="frm_modal_gc" role="form" class="form-horizontal">
                            <div class="col-md-12">
                                     <label class="control-label boldlabel" style="text-align:right;">Branch / Address:</label>
                                <div class="form-group" style="margin-bottom: 2px;">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i i class="ti ti-wallet" style="font-size: 13px;"></i>
                                        </span>
                                        <input type="text" name="modal_gc_address" class="form-control" data-error-msg="Branch / Address is required." required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                     <label class="control-label boldlabel" style="text-align:right;">Gift Certificate Number:</label>
                                <div class="form-group" style="margin-bottom: 2px;">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-phone" style="font-size: 13px;"></i>
                                        </span>
                                        <input type="text" name="modal_gc_no" class="form-control"  required data-error-msg="Gift Certificate Number is Required !">
                                    </div>
                                </div>
                            </div>
                            <input type="text" name="modal_gc_id"  id='modal_gc_id' class="form-control" required data-error-msg="Gift Certificate is required! " style="display: none;">

                            <div class="col-md-12">
                                     <label class="control-label boldlabel" style="text-align:right;">Amount:</label>
                                <div class="form-group" style="margin-bottom: 2px;">
                                        <input type="text" name="modal_gc_amount" id="modal_gc_amount" class="form-control numeric" value="0.00" style="height: 50px;font-size: 25px;color: green;">
                                </div>
                            </div>
                        </form>
                </div>

            </div>
            <div class="modal-footer">
                <button id="btn_modal_gc_cancel" type="button" class="btn btn-primary btn-pymnt pull-left">
                    <strong> Cancel GC</strong>
                </button>
                <button id="btn_modal_gc_clear" type="button" class="btn btn-primary btn-pymnt pull-left">
                    <strong> Clear</strong>
                </button>
                <button id="btn_modal_gc_save" type="button" class="btn btn-success btn-pymnt">
                    <strong> Save</strong>
                </button>
                <button type="button" class="btn btn-danger btn-pymnt" data-dismiss="modal" aria-label="Close">
                    <strong> Close</strong>
                </button>
            </div>
        </div>
    </div>
</div>
</div>






<div id="modal_shortcut_discount" class="modal " role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header" >
                 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                 <h2 id="" class="modal-title" >Discount List</h2>
            </div>
            <div class="modal-body">
            <div class="row" style="background-color: #f5eeee;">
                <div class="col-sm-6" style="padding: 0px;">
                <table style="border:none!important;width: 100%;padding-left: 5px;">
                    <tr>
                        <td><label style="font-size: 14px;text-align: right;display: block;padding-right:10px;"> Product Code: </label></td>
                        <td><input type="text" id="modal_discount_product_code" class=""  style="text-align:right;border: 1px solid gray;background-color: white;font-size: 14px;font-weight: bold;" readonly></td>
                    </tr>
                    <tr>
                        <td><label style="font-size: 14px;text-align: right;display: block;padding-right:10px;"> Product Price: </label> </td>
                        <td><input type="text" id="modal_discount_product_price"  class="numeric" style="border: 1px solid gray;background-color: white;font-size: 14px;font-weight: bold;" readonly></td>
                    </tr>
                    <tr>
                        <td><label style="font-size: 14px;text-align: right;display: block;padding-right:10px;">Quantity: </label></td>
                        <td><input type="text" id="modal_discount_qty" class="numeric"  style="border: 1px solid gray;background-color: white;font-size: 14px;font-weight: bold;" readonly></td>
                    </tr>
                </table>
                </div>
                <div class="col-sm-6" style="padding: 0px;">

                <table style="border:none!important;width: 100%;padding-left: 5px;">
                    <tr>
                        <td><label style="font-size: 14px;text-align: right;display: block;padding-right:10px;">Prev. Discount: </label></td>
                        <td><input type="text" id="modal_discount_prev" class="numeric"  style="border: 1px solid gray;background-color: white;font-size: 14px;font-weight: bold;" readonly><br></td>
                    </tr>
                    <tr>
                        <td><label style="font-size: 16px;text-align: right;display: block;padding-right:10px;">Discount Amount: </label></td>
                        <td><input type="text" id="modal_discount_current"  class="numeric" style="border: 1px solid gray;background-color: white;font-size: 16px;font-weight: bold;" readonly><br></td>
                    </tr>
                </table>
                </div>
            </div>
            <div class="row" class="row_ref_discount">
                <table id="tbl_ref_discount" style="width:100%;" class="table table-bordered">
                    <thead>
                        <th style="padding:5px;text-align: left;vertical-align: center;border-bottom: 1px solid rgb(176, 190, 197);width: 70%">Name</th>
                        <th style="padding:5px;text-align: right;vertical-align: center;border-bottom: 1px solid rgb(176, 190, 197);width: 30%;">Discount Percent</th>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            </div>
            <div class="modal-footer">
            <div class="row" style="margin-left: 0px;">
                <div style="float: left;">
                <input type="checkbox" id="give_manual_discount" style="font-size: 14px; vertical-align: center;">
                <label for="give_manual_discount" style="font-size: 14px;vertical-align: center;">Give Manual Discount?</label><br>
               <label> Amount:</label> <input type="text" id="give_manual_discount_amount" class="numeric" style="font-size: 14px;border:1px solid gray;"><br>
               <label> Percent:</label> <input type="text" id="give_manual_discount_percent" class="numeric" style="font-size: 14px;border:1px solid gray;">
                </div>
            <div class="" style="float: right;margin-right:30px;">
            <label>Applied Discount</label><br>
               <label> Amount:</label> <input type="text" id="discount_apply_amount" class="numeric" style="font-size: 14px;border:1px solid gray;"><br>
               <label> Percent:</label> <input type="text" id="discount_apply_percent" class="numeric" style="font-size: 14px;border:1px solid gray;"><br>
               <label> Discount ID:</label> <input type="text" id="discount_apply_discount_id" class="" style="font-size: 14px;border:1px solid gray;">
            </div>
            </div>
            <div class="row" style="margin-left: 0px;margin-right: 10px;margin-top: 15px;">

                <button id="btn_discount_accept" type="button" class="btn btn-success btn-pymnt">
                    <strong> Accept</strong>
                </button>
                <button type="button" class="btn btn-danger btn-pymnt" data-dismiss="modal" aria-label="Close">
                    <strong> Close</strong>
                </button>

            </div>
            </div>
        </div>
    </div>
</div>
</div>



<div id="modal_shortcut_qty" class="modal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-md" style="width: 700px;">
        <div class="modal-content">
            <div class="modal-header" >
                 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                 <h2 id="" class="modal-title" >Quantity</h2>
            </div>
            <div class="modal-body">
            <div class="row" style="">
                <div class="col-sm-6" style="">



                <div class="row" style="">
                <center><input type="text" id="modal_qty_product_desc" class=""  style="text-align:center;border: none;background-color: transparent;font-size: 18px;font-weight: bold;" readonly></center><br>
                <table style="border:none!important;width: 100%;padding-left: 5px;">
                    <tr>
                        <td><label style="font-size: 12px;text-align: right;display: block;padding-right:10px;"> Product Code: </label></td>
                        <td><input type="text" id="modal_qty_product_code" class=""  style="text-align:right;border: 1px solid gray;background-color: white;font-size: 14px;font-weight: bold;" readonly></td>
                    </tr>
                    <tr>
                        <td><label style="font-size: 12px;text-align: right;display: block;padding-right:10px;">Quantity: </label></td>
                        <td><input type="text" id="modal_qty_qty" class="numeric"  style="border: 1px solid gray;background-color: white;font-size: 14px;font-weight: bold;" readonly></td>
                    </tr>
                    <tr>
                        <td><label style="font-size: 12px;text-align: right;display: block;padding-right:10px;"> Product Price: </label> </td>
                        <td><input type="text" id="modal_qty_product_price"  class="numeric" style="border: 1px solid gray;background-color: white;font-size: 14px;font-weight: bold;" readonly></td>
                    </tr>
                </table>
                <div style="display: block;">
                <br><br><br>
                <center><label style="font-size: 16px;">Please input quantity:</label>
                <input type="text" id="modal_qty_current" class="number" style="width: 290px;height: 88px;background-color: #f1edcd;border: 1px solid gray;font-size: 80px;text-align: center;vertical-align: bottom;">
                </center>
                </div>
                </div>






                </div>
                <div class="col-sm-6" style="padding: 0px;zoom: 90%;width: ">
                    <div class="row">
                        <div class="col-sm-4" style="width: 27.333333%;"><button type="button" class="btn-keypad-qty" id="qtycalculator_7"><b>7</b></button></div>
                        <div class="col-sm-4" style="width: 27.333333%;"><button type="button" class="btn-keypad-qty" id="qtycalculator_8"><b>8</b></button></div>
                        <div class="col-sm-4" style="width: 27.333333%;"><button type="button" class="btn-keypad-qty" id="qtycalculator_9"><b>9</b></button></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4" style="width: 27.333333%;"><button type="button" class="btn-keypad-qty" id="qtycalculator_4"><b>4</b></button></div>
                        <div class="col-sm-4" style="width: 27.333333%;"><button type="button" class="btn-keypad-qty" id="qtycalculator_5"><b>5</b></button></div>
                        <div class="col-sm-4" style="width: 27.333333%;"><button type="button" class="btn-keypad-qty" id="qtycalculator_6"><b>6</b></button></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4" style="width: 27.333333%;"><button type="button" class="btn-keypad-qty" id="qtycalculator_1"><b>1</b></button></div>
                        <div class="col-sm-4" style="width: 27.333333%;"><button type="button" class="btn-keypad-qty" id="qtycalculator_2"><b>2</b></button></div>
                        <div class="col-sm-4" style="width: 27.333333%;"><button type="button" class="btn-keypad-qty" id="qtycalculator_3"><b>3</b></button></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4" style="width: 27.333333%;"><button type="button" class="btn-keypad-qty" id="qtycalculator_0"><b>0</b></button></div>
                        <div class="col-sm-4" style="width: 27.333333%;"><button type="button" class="btn-keypad-qty" id="qtyaction_clear"><b>CLEAR</b></button></div>
                        <div class="col-sm-4" style="width: 31.333333%;"><button type="button" class="btn-keypad-qty" id="qtyaction_cancel"><b>CANCEL</b></button></div>
                    </div>
                    <div class="row" style="margin-right: 30px;">
                        <center>

                            <button type="button" class="btn-enter-qty" style="width: 348px;" id="qtyaction_enter"><b>ENTER</b></button>
                            </center>
                    </div>
                </div>

            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>
</div>



<div id="modal_browse_item_qty" class="modal " role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header" >
                 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                 <h2 id="" class="modal-title" >Quantity</h2>
            </div>
            <div class="modal-body">
            <div class="row" style="background-color: #f5eeee;">
                <div class="col-sm-6" style="">
                <center><input type="text" id="modal_browse_product_desc" class=""  style="text-align:center;border: none;background-color: transparent;font-size: 18px;font-weight: bold;" readonly></center><br>
                <table style="border:none!important;width: 100%;padding-left: 5px;">
                    <tr>
                        <td><label style="font-size: 12px;text-align: right;display: block;padding-right:10px;"> Product Code: </label></td>
                        <td><input type="text" id="modal_browse_product_code" class=""  style="text-align:right;border: 1px solid gray;background-color: white;font-size: 14px;font-weight: bold;" readonly></td>
                    </tr>
                    <tr>
                        <td><label style="font-size: 12px;text-align: right;display: block;padding-right:10px;">Quantity: </label></td>
                        <td><input type="text" id="modal_browse_qty" class="numeric"  style="border: 1px solid gray;background-color: white;font-size: 14px;font-weight: bold;" readonly></td>
                    </tr>
                    <tr>
                        <td><label style="font-size: 12px;text-align: right;display: block;padding-right:10px;"> Product Price: </label> </td>
                        <td><input type="text" id="modal_browse_product_price"  class="numeric" style="border: 1px solid gray;background-color: white;font-size: 14px;font-weight: bold;" readonly></td>
                    </tr>
                </table>
                <div style="display: block;">
                <br><br><br>
                <center><label style="font-size: 16px;">Please input quantity:</label></center>
                <input type="text" id="modal_browse_current" class="number" style="width: 290px;height: 88px;background-color: #f1edcd;border: 1px solid gray;font-size: 80px;text-align: center;vertical-align: bottom;">
                </div>
                </div>
                <div class="col-sm-6" style="padding: 0px;zoom: 90%;">
                    <div class="row">
                        <div class="col-sm-4" style="width: 31.333333%;"><button type="button" class="btn-keypad-qty" id="browsecalculator_7"><b>7</b></button></div>
                        <div class="col-sm-4" style="width: 31.333333%;"><button type="button" class="btn-keypad-qty" id="browsecalculator_8"><b>8</b></button></div>
                        <div class="col-sm-4" style="width: 31.333333%;"><button type="button" class="btn-keypad-qty" id="browsecalculator_9"><b>9</b></button></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4" style="width: 31.333333%;"><button type="button" class="btn-keypad-qty" id="browsecalculator_4"><b>4</b></button></div>
                        <div class="col-sm-4" style="width: 31.333333%;"><button type="button" class="btn-keypad-qty" id="browsecalculator_5"><b>5</b></button></div>
                        <div class="col-sm-4" style="width: 31.333333%;"><button type="button" class="btn-keypad-qty" id="browsecalculator_6"><b>6</b></button></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4" style="width: 31.333333%;"><button type="button" class="btn-keypad-qty" id="browsecalculator_1"><b>1</b></button></div>
                        <div class="col-sm-4" style="width: 31.333333%;"><button type="button" class="btn-keypad-qty" id="browsecalculator_2"><b>2</b></button></div>
                        <div class="col-sm-4" style="width: 31.333333%;"><button type="button" class="btn-keypad-qty" id="browsecalculator_3"><b>3</b></button></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4" style="width: 31.333333%;"><button type="button" class="btn-keypad-qty" id="browsecalculator_0"><b>0</b></button></div>
                        <div class="col-sm-4" style="width: 31.333333%;"><button type="button" class="btn-keypad-qty" id="browseaction_clear"><b>CLEAR</b></button></div>
                        <div class="col-sm-4" style="width: 31.333333%;"><button type="button" class="btn-keypad-qty" id="browseaction_cancel"><b>CANCEL</b></button></div>
                    </div>
                    <div class="row">
                        <center>

                            <button type="button" class="btn-enter-qty" style="width: 348px;" id="browseaction_enter"><b>ENTER</b></button>
                            </center>
                    </div>
                </div>

            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>
</div>


<div id="modal_payment_charge" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header" style="background: #2ecc71">
                 <h2 id="" class="modal-title" style="">Charge</h2>
            </div>
            <div class="modal-body">
                <div class="row">
                <div class="col-sm-4">
                    <div class="scroll-panel-pymnt">
                    </div>
                </div>
                <div class="col-sm-8">
                        <form id="frm_modal_charge" role="form" class="form-horizontal">
                            <div class="col-md-12">
                                     <label class="control-label boldlabel" style="text-align:right;">Branch / Address:</label>
                                <div class="form-group" style="margin-bottom: 2px;">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i i class="ti ti-wallet" style="font-size: 13px;"></i>
                                        </span>
                                        <input type="text" name="modal_charge_address" class="form-control" data-error-msg="Branch / Address is required." required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                     <label class="control-label boldlabel" style="text-align:right;">Reference No:</label>
                                <div class="form-group" style="margin-bottom: 2px;">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-phone" style="font-size: 13px;"></i>
                                        </span>
                                        <input type="text" name="modal_charge_no" class="form-control"  required data-error-msg="Reference Number is Required !">
                                    </div>
                                </div>
                            </div>
                            <input type="text" name="modal_charge_id"  id='modal_charge_id' class="form-control" required data-error-msg="Charge to is required! " style="display: none;">

                            <div class="col-md-12">
                                     <label class="control-label boldlabel" style="text-align:right;">Amount:</label>
                                <div class="form-group" style="margin-bottom: 2px;">
                                        <input type="text" name="modal_gc_amount" id="modal_gc_amount" class="form-control numeric" value="0.00" style="height: 50px;font-size: 25px;color: green;">
                                </div>
                            </div>
                        </form>
                </div>

            </div>
            <div class="modal-footer">
                <button id="btn_modal_charge_cancel" type="button" class="btn btn-primary btn-pymnt pull-left">
                    <strong> Cancel GC</strong>
                </button>
                <button id="btn_modal_charge_clear" type="button" class="btn btn-primary btn-pymnt pull-left">
                    <strong> Clear</strong>
                </button>
                <button id="btn_modal_charge_save" type="button" class="btn btn-success btn-pymnt">
                    <strong> Save</strong>
                </button>
                <button type="button" class="btn btn-danger btn-pymnt" data-dismiss="modal" aria-label="Close">
                    <strong> Close</strong>
                </button>
            </div>
        </div>
    </div>
</div>
</div>



<div id="void_modal_confirm" class="modal " role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-sm" style="position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%) !important;overflow: hidden;">
        <div class="modal-content">
            <div class="modal-header" style="background: #2ecc71">
                 <h2 id="" class="modal-title" style="">POS</h2>
            </div>
            <div class="modal-body" style="background-color: #ececec;">
                <div class="row" style="">
                    <center>Are you sure you want to void this item?</center>
                    <br>
                </div>
                <div class="row">
                    <center>
                   <button id="btn_yes_void" type="button" class="btn btn-default btn-yes-no" style="text-transform: none!important;padding: 4px 31px!important;font-size: 13px!important;border-radius: 6px;">Yes</button>
                    <button id="" type="button" class="btn btn-default btn-yes-no" style="text-transform: none!important;" data-dismiss="modal" aria-label="No">No</button>
                    </center>
                </div>

            </div>
        </div>
    </div>
</div>


<div id="cancel_modal_confirm" class="modal " role="dialog" data-backdrop="static" >
    <div class="modal-dialog modal-sm" style="position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%) !important;overflow: hidden;">
        <div class="modal-content">
            <div class="modal-header" style="background: #2ecc71">
                 <h2 id="" class="modal-title" style="">POS</h2>
            </div>
            <div class="modal-body" style="background-color: #ececec;">
                <div class="row" style="">
                    <center>Are you sure you want to cancel this transaction?</center>
                    <br>
                </div>
                <div class="row">
                    <center>
                   <button id="btn_yes_cancel" type="button" class="btn btn-default btn-yes-no" style="text-transform: none!important;padding: 4px 31px!important;font-size: 13px!important;border-radius: 6px;">Yes</button>
                    <button id="" type="button" class="btn btn-default btn-yes-no" style="text-transform: none!important;" data-dismiss="modal" aria-label="No">No</button>
                    </center>
                </div>

            </div>
        </div>
    </div>
</div>


<div id="modal_product_error" class="modal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-sm" style="position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%) !important;overflow: hidden;width: 224px;">
        <div class="modal-content">
            <div class="modal-header" style="background: #2ecc71">
                 <h2 id="" class="modal-title" style="">POS</h2>
            </div>
            <div class="modal-body" style="background-color: #ececec;">
                <div class="row" style="">
                    <center><img src="assets/img/pos/exclamation.png" style="width: 64px; height:64px;"> Product does not exist.</center>
                    <br>
                </div>
                <div class="row">
                    <center>
                    <button id="btn_error_ok" type="button" class="btn btn-default btn-yes-no" style="text-transform: none!important;" data-dismiss="modal" aria-label="No">OK</button>
                    </center>
                </div>

            </div>
        </div>
    </div>
</div>


<div id="modal_browse_item" class="modal " role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header" style="background: #2ecc71">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                 <h2 id="" class="modal-title" style="">Product List</h2>
            </div>
            <div class="modal-body" style="padding-top: 0px!important;">
            <div class="row" style="border-top: 1px solid blue;border-bottom: 1px solid blue;margin-bottom: 5px;margin-top: 5px;margin-left: -20px;margin-right: -20px;">
                    <label style="margin-bottom: 0px;">&nbsp;&nbsp;Select Product</label><br>
                    <label style="font-weight: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Choose Product from the list</label>
            </div>
            <div class="row" style="background-color: #e4e3e3;    margin-left: -20px;margin-right: -20px;">
                <br>
                <div class="col-sm-6">
                    <input type="text" id="searchbox" class="dtsearch" placeholder="Enter text to search" >
                </div>
                <div class="col-sm-6" style="padding-left: 0px;">
                    <div class="col-sm-8" style="padding-left: 0px;">
                    <button id="" type="button" class="btn btn-default pull-left" style="text-transform: none!important;font-size: 12px!important;">Find</button>
                    <button id="searchboxofproducts" type="button" class="btn btn-default pull-left" style="margin-left: 10px;text-transform: none!important;font-size: 12px!important;">Clear</button>
                    </div>

                    <div class="col-sm-4">
                    </div>

                </div>
                <br>
                <br>
            </div>
            <div class="row" style="margin-left: -20px;margin-right: -20px;">
            <table id="tbl_products" class="table table-bordered" style="width: 100%;font-size: 13px;">
                <thead>
                    <tr>
                        <td style="border-bottom: 1px solid rgb(176, 190, 197);font-weight: bold;width: 5%"></td>
                        <td style="border-bottom: 1px solid rgb(176, 190, 197);font-weight: bold;">Product Code</td>
                        <td style="border-bottom: 1px solid rgb(176, 190, 197);font-weight: bold;">Product Name</td>
                        <td style="border-bottom: 1px solid rgb(176, 190, 197);font-weight: bold;">Unit</td>
                        <td style="border-bottom: 1px solid rgb(176, 190, 197);font-weight: bold;">Price</td>

                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
            </div>
            <input type="text" id="choose_product" class="form-control" style="display: none;">
            </div>

            <div class="modal-footer">
                <button id="btn_modal_browse_cancel" type="button" class="btn btn-default btn-pymnt pull-right" style="text-transform: none!important;font-size: 12px!important;margin-left: 10px;">
                    <strong style="font-weight: normal;font-size: 16px;padding: 6px;"> <u>C</u>ancel</strong>
                </button>
                <button id="btn_modal_browse_accept" type="button" class="btn btn-default btn-pymnt pull-right" style="text-transform: none!important;font-size: 12px!important;">
                    <strong style="font-weight: normal;font-size: 16px;padding: 6px;"> <u>A</u>ccept</strong>
                </button>


            </div>
        </div>
    </div>
</div>
</div>

                <div class="row" style="display: none;">
                    <div class="col-lg-4 col-lg-offset-8">
                        <div class="table-responsive">
                            <table id="tbl_cash_invoice_summary" class="table invoice-total" style="font-family: tahoma;">
                                <tbody>
                                <tr>
                                    <td>Discount :</td>
                                    <td align="right">0.00</td>
                                </tr>
                                <tr>
                                    <td>Total before Tax :</td>
                                    <td align="right">0.00</td>
                                </tr>
                                <tr>
                                    <td>Tax :</td>
                                    <td align="right">0.00</td>
                                </tr>
                                <tr>
                                    <td><strong>Total After Tax :</strong></td>
                                    <td align="right"><b>0.00</b></td>
                                </tr>
                                </tbody>
                            </table>
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
    <!-- Date range use moment.js same as full calendar plugin -->
    <script src="assets/plugins/fullcalendar/moment.min.js"></script>
    <!-- Data picker -->
    <script src="assets/plugins/datapicker/bootstrap-datepicker.js"></script>
    <!-- Select2 -->
    <script src="assets/plugins/select2/select2.full.min.js"></script>
    <!-- twitter typehead -->
    <script src="assets/plugins/twittertypehead/handlebars.js"></script>
    <script src="assets/plugins/twittertypehead/bloodhound.min.js"></script>
    <script src="assets/plugins/twittertypehead/typeahead.bundle.js"></script>
    <script src="assets/plugins/twittertypehead/typeahead.jquery.min.js"></script>
    <!-- touchspin -->
    <script type="text/javascript" src="assets/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.js"></script>
    <!-- numeric formatter -->
    <script src="assets/plugins/formatter/autoNumeric.js" type="text/javascript"></script>
    <script src="assets/plugins/formatter/accounting.js" type="text/javascript"></script>
<script type="text/javascript">

function avoidInvalidKeyStorkes(evtArg) {
    var evt = (document.all ? window.event : evtArg);
    var isIE = (document.all ? true : false);
    var KEYCODE = (document.all ? window.event.keyCode : evtArg.which);

    var element = (document.all ? window.event.srcElement : evtArg.target);

    if (KEYCODE == "112") {
        if (isIE) {
            document.onhelp = function() {
                return (false);
            };
            window.onhelp = function() {
                return (false);
            };
        }
        evt.returnValue = false;
        evt.keyCode = 0;
        evt.preventDefault();
        evt.stopPropagation();
        $('#btn_focus_grid').click();
    }

    window.status = "Done";    
}    

if (window.document.addEventListener) {
    window.document.addEventListener("keydown", avoidInvalidKeyStorkes, false);
} else {
    window.document.attachEvent("onkeydown", avoidInvalidKeyStorkes);
    document.captureEvents(Event.KEYDOWN);
}

</script>


    <script>

    $(document).ready(function() {
        var dt; var _txnMode; var _selectedID; var _selectRowObj; var _taxTypeGroup; var _rights; var products;
        var _cboCustomers;
        var tempQty; var splitQty;
        var out = document.getElementById("tbl_items"); // used for scrollbar
        var isScrolledToBottom = out.scrollHeight - out.clientHeight <= out.scrollTop + 1; // used for scrollbar
        var keypressenter = $.Event( "keypress", { which: 13 } );
        var itemcount = 0;
        var oTableItems={
            qty : 'td:eq(4)',
            unit_value: 'td:eq(2)',
            unit_identifier : 'td:eq(1)',
            unit_price : 'td:eq(3)',
            unit_qty : 'td:eq(4)',
            discount : 'td:eq(5)',
            total_line_discount : 'td:eq(6)',
            tax : 'td:eq(7)',
            gross : 'td:eq(8)',
            total : 'td:eq(9)',
            vat_input : 'td:eq(10)',
            net_vat : 'td:eq(11)',
            total_after_global :' td:eq(13)',
            bulk_price : 'td:eq(15)',
            retail_price : 'td:eq(16)',
            product_code : 'td:eq(17)',
            ref_tax : 'td:eq(18)',
            ref_product_desc : 'td:eq(19)',
            ref_discount_type : 'td:eq(20)',
            zero_rated_sls : 'td:eq(21)',
            vat_exempt_sls : 'td:eq(22)'




     
        };
        var oTableDetails={
            discount : 'tr:eq(0) > td:eq(1)',
            before_tax : 'tr:eq(1) > td:eq(1)',
            inv_tax_amount : 'tr:eq(2) > td:eq(1)',
            after_tax : 'tr:eq(3) > td:eq(1)'
        };

        var getproduct=function(){
           return $.ajax({
               "dataType":"json",
               "type":"POST",
               "url":"products/transaction/list",
               "beforeSend": function(){
                    countproducts = products.local.length;
                    if(countproducts > 100){
                        showNotification({title:"Please Wait !",stat:"info",msg:"Refreshing your Products List."});
                    }
               }
          });
        };


        var countCart=function() {
          itemcount= $("#tbl_items > tbody >tr").length;
            var total = itemcount;
            $('#total_items').text(total);
        };

        var initializeControls=function() {
          dtproduct=$('#tbl_products').DataTable({
              "initComplete": function(settings, json) {
              },
            "dom": '<"toolbar">frtip', 
            "bPaginate": false,
            "bInfo" : false,            
            // "bFilter": false,
             "ajax" : "Products/transaction/list",
             "bDestroy": true,
              "language": {
                 "searchPlaceholder": "Search Product"
             },
             "columns": [
                 { targets:[0],data: null,
                    render: function (data, type, full, meta){
                         return '<span class="product_arrow"></span>';
                    }
                },
                { targets:[1],data: "product_code"},
                { targets:[2],data: "product_desc"},
                { targets:[3],data: "parent_unit_name"},
                { targets:[4],data: "sale_price", render: $.fn.dataTable.render.number( ',', '.', 2 )}
             ],
             "rowCallback":function( row, data, index ){

                 $(row).find('td').eq(4).attr({
                     "align": "right"
                 });
                 }
             });

        _cboCustomers=$("#cbo_customers").select2({
            placeholder: "Please select customer."
        });
        _cboCustomers.select2('val',1);

        $('.date-picker').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true
        });

        $("input[id^='payment_']").each(function( index ) {
            $(this).val('0.00')
        });


        $('#invoice_default').datepicker('setDate', 'today');
        $('.numeric').autoNumeric('init');


        $(document).keyup(function(e) {
            if (e.which === 40 && row.is(":last-child")) {

            } else if (e.which === 40 && row.not(":last-child")) {
            $('#tbl_items tbody tr').find('span').removeClass('fa fa-angle-right');
              $('#tbl_items tbody tr').css('background-color','#fff');
              $('#tbl_items tbody tr').css('cursor','pointer');
             newrow = row.next('tr') 
             row = newrow;
            row.css('background-color','rgb(255, 240, 107)');
            row.find('span').toggleClass('fa fa-angle-right');
            }

            if (e.which === 38 && row.is(":first-child")) {

            } else if (e.which === 38) {
            $('#tbl_items tbody tr').find('span').removeClass('fa fa-angle-right');
              $('#tbl_items tbody tr').css('background-color','#fff');
              $('#tbl_items tbody tr').css('cursor','pointer');
             newrow = row.prev('tr') 
             row = newrow;
            row.css('background-color','rgb(255, 240, 107)');
            row.find('span').toggleClass('fa fa-angle-right');
            }
        });


        $('#typeaheadsearch').keyup(function(e) {
            if (e.which === 40 ) { return false; }
            if (e.which === 38) { return false; }
        });

        products = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('product_code','product_desc','product_desc1'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            local : products
        });
        var _objTypeHead=$('#custom-templates .typeahead');
        _objTypeHead.typeahead(null, {
        name: 'products',
        display: 'product_code',
        source: products,
        templates: {

        }
        }).on('keyup', this, function (event) {
            tempQty = 0;
            if (_objTypeHead.typeahead('val') == '') {
                return false;
            }
            if (event.keyCode == 13) {
                tempval = $('#typeaheadsearch').val();
                resulttemp =tempval.split('/')
                if(typeof resulttemp[1] != 'undefined'){ // means there is a QTY 
                    splitQty = resulttemp[0];
                    var newbarcode = resulttemp[1];
                    _objTypeHead.typeahead('val',newbarcode); 
                    $('#typeaheadsearch').trigger(keypressenter);

                } else{  // NO QTY 
                    tempQty = 1;
                }
            typeaheadval = _objTypeHead.typeahead('val');

            if ($('.tt-suggestion:first').length == 0) {
                _objTypeHead.typeahead('val','');  
                $('#modal_product_error').modal('show');
            }
            $('.tt-suggestion:first').click();
            }
        }).bind('typeahead:select', function(ev, suggestion) {
            if(splitQty > 0){ final_qty = splitQty; }else{ final_qty = tempQty; } // IF QTY IS PRESENT, SET IT AS final_qty to be used below
            _objTypeHead.typeahead('close');   
            typeaheadsuggest = suggestion.product_code;
            if(typeaheadval != typeaheadsuggest){
                _objTypeHead.typeahead('val','');  
                $('#modal_product_error').modal('show');
                return;
            }

            _objTypeHead.typeahead('val','');  
            //console.log(suggestion);
            //alert(suggestion.sale_price);
            var tax_rate=suggestion.tax_rate; //base on the tax rate set to current product
            //choose what purchase cost to be use
            var sale_price=0.00;
            sale_price=suggestion.sale_price;
            //alert(suggestion.sale_price);
            floatsale_price= getFloat(sale_price);
            floatsale_qty= getFloat(final_qty);
            var total=floatsale_qty * floatsale_price;
            var net_vat=0;
            var vat_input=0;
            var bulk_price = 0;
            var retail_price = 0;
            var zero_rated_sales = 0;

            if(suggestion.tax_rate=="0.00"){ // ZERO MEANS NO TAX THEN GOES TO ZERO RATED SALES
                tax_rate=0;
                net_vat=0;
                vat_input=0;
                zero_rated_sales = total;
            }else{ // GOES TO TAXABLE SALES
                net_vat=total/(1+(getFloat(tax_rate)/100));
                vat_input=total-net_vat;
                zero_rated_sales = 0;
            }
                a = '';
                bulk_price = suggestion.sale_price;

                if(suggestion.is_bulk == 1){
                    retail_price = getFloat(suggestion.sale_price) / getFloat(suggestion.child_unit_desc);

                }else if (suggestion.is_bulk== 0){
                    retail_price = 0;
                }
            changetxn = 'active';
            $('#tbl_items > tbody').append(newRowItem({
                inv_qty : floatsale_qty,
                inv_gross : total,
                product_code : suggestion.product_code,
                product_id: suggestion.product_id,
                product_desc : suggestion.product_desc,
                inv_line_total_discount : "0.00",
                tax_exempt : false,
                inv_tax_rate : tax_rate,
                inv_price : suggestion.sale_price,
                inv_discount : "0.00",
                tax_type_id : null,
                inv_line_total_price : total,
                inv_non_tax_amount: net_vat,
                inv_tax_amount:vat_input,
                inv_line_total_after_global:0.00,
                    bulk_price: bulk_price,
                    retail_price: retail_price,
                    is_bulk: suggestion.is_bulk,
                    parent_unit_id : suggestion.parent_unit_id,
                    child_unit_id : suggestion.child_unit_id,
                    child_unit_name : suggestion.child_unit_name,
                    parent_unit_name : suggestion.parent_unit_name,
                    is_parent: 1 ,// INITIALLY , UNIT USED IS THE PARENT , 1 for PARENT 0 for CHILD
                    a:a,
                    zero_rated_sales:zero_rated_sales,
                    vat_exempt_sales : 0
            }));
         
                $('#tbl_items tbody tr').css('background-color','#fff');
                $('#tbl_items tbody tr').find('span').removeClass('fa fa-angle-right');
                $('#tbl_items tbody tr').css('cursor','pointer');
                row=$('#tbl_items tbody tr').last();
                row.find('span').toggleClass('fa fa-angle-right');
                $('#tbl_items tbody tr').last().css('background-color','rgb(255, 240, 107)');
            reInitializeNumeric();
            reComputeTotal();
            countCart();
            if(isScrolledToBottom){ out.scrollTop = out.scrollHeight - out.clientHeight; } //SCROLL TO BOTTOM WHEN SCROLLBAR IS PRESENT
            tempQty = 0; splitQty = 0; // SET Temporary QTY and Split QTY to zero
        });
        $('div.tt-menu').on('click','table.tt-suggestion',function(){
            // _objTypeHead.typeahead('val','');
        });
        $("input#touchspin4").TouchSpin({
            verticalbuttons: true,
            verticalupclass: 'fa fa-fw fa-plus',
            verticaldownclass: 'fa fa-fw fa-minus'
        });


        getproduct().done(function(data){
                products.clear();
                products.local = data.data;
                products.initialize(true);
                countproducts = data.data.length;
                    if(countproducts > 100){
                    showNotification({title:"Success !",stat:"success",msg:"Products List successfully updated."});
                    }
        }).always(function(){  });

        }();


        var bindEventHandlers=(function(){

        shortcut.add("f6",function() {
            $('#btn_payment').trigger('click');
        });
        shortcut.add("f1",function() {

            $('#btn_focus_grid').trigger('click');

        });
        shortcut.add("f2",function() {
            $('#btn_barcode').trigger('click');
        });
        shortcut.add("f3",function() {
            $('#btn_browse').trigger('click');

        });

        shortcut.add("f4",function() {
            $('#btn_void').trigger('click');
            
        });

        // shortcut.add("f5",function() {
        //     // alert('Hold');
        // });

        shortcut.add("f7",function() {
            var _data=$('#frm_items').serializeArray();
            console.log(_data);
        });

        shortcut.add("f8",function() {
            $('#btn_cancel').trigger('click');
        });

        shortcut.add("f10",function() {
            $('#btn_discount').trigger('click');
        });

        shortcut.add("f11",function() {
            $('#btn_qty').trigger('click');
        });



        shortcut.add("f12",function() {
            alert('Close Sales');
        });

            $('#btn_payment').click(function(){
                var btn=$(this);
               total = parseFloat(accounting.unformat($('#td_total_after_discount').text()));
               // if(!total == 0){
                var rowsofitems=$('#tbl_items > tbody tr');
                total_exempt=0;
                $.each(rowsofitems,function(){
                    alert()
                    total_exempt+=parseFloat(accounting.unformat());
                    discount_type_check =  $(oTableItems.ref_discount_type,$(this)).find('input.numeric').val()
                });

                if(total_exempt == 0){
                    $('.senior-citizen').addClass('hide-div');
                    $('.whole_number').removeClass('hide-div');
                }else{
                    $('.senior-citizen').removeClass('hide-div');
                    $('.whole_number').addClass('hide-div');
                }

                   $('#modal_process_payment').modal('show');
                   $('#summary_amount_due').val(accounting.formatNumber(total,2))
                   $('#summary_tendered').val(accounting.formatNumber(total,2));30.00
                   $('#payment_cash').val(accounting.formatNumber(total,2));
                   $('#summary_change').val(accounting.formatNumber(0,2));
                    $('#payment_total').val(accounting.formatNumber(total,2));

               // }

            });

            // function shown
            $('#modal_shortcut_qty').on('shown.bs.modal', function () {
                $("#modal_qty_current").focus();
                $("#modal_qty_current").select();
            });

            $('#modal_browse_item_qty').on('shown.bs.modal', function () {
                $("#modal_browse_current").focus();
                $("#modal_browse_current").select();
            });


            $('#modal_process_payment').on('shown.bs.modal', function () {
                $("#summary_tendered").focus();
                $("#summary_tendered").select();
            });

            $('#modal_browse_item').on('shown.bs.modal', function () {
                $('#searchbox').focus();
            });


            $('#cancel_modal_confirm').on('shown.bs.modal', function(){

                $('#btn_yes_cancel').focus();

            });

            $('#void_modal_confirm').on('shown.bs.modal', function () {
                $('#btn_yes_void').focus();
            });

            $('#modal_product_error').on('shown.bs.modal', function () {
                $('#btn_error_ok').focus();
            });

            $('button[id^="calculator_"]').click(function(){
                    var payment_cash = parseFloat(accounting.unformat($('#payment_cash').val()));
                    var btn=$(this);
                    attrid = btn.attr('id');
                    temp = attrid.split("_");
                    calculator_number = temp[1];
                    new_payment_cash = payment_cash + calculator_number ;
                    $('#payment_cash').val(accounting.formatNumber(new_payment_cash,2));
                    $('#summary_tendered').val(accounting.formatNumber(new_payment_cash,2));
                    reComputeChange();
            });

            $('button[id^="qtycalculator_"]').click(function(){
                    var modal_qty_current = $('#modal_qty_current').val();
                    var btn=$(this);
                    attrid = btn.attr('id');
                    temp = attrid.split("_");
                    calculator_number = temp[1];
                    modal_qty_current = modal_qty_current + calculator_number ;
                    $('#modal_qty_current').val(modal_qty_current);
            });

            $('button[id^="browsecalculator_"]').click(function(){
                    var modal_browse_current = $('#modal_browse_current').val();
                    var btn=$(this);
                    attrid = btn.attr('id');
                    temp = attrid.split("_");
                    calculator_number = temp[1];
                    modal_browse_current = modal_browse_current + calculator_number ;
                    $('#modal_browse_current').val(modal_browse_current);
            });

            $('button[id^="whole_"]').click(function(){
                    var btn=$(this);
                    attrid = btn.attr('id');
                    temp = attrid.split("_");
                    calculator_number = temp[1];
                    $('#payment_cash').val(accounting.formatNumber(calculator_number,2));
                    $('#summary_tendered').val(accounting.formatNumber(calculator_number,2));
                    reComputeChange();
            });


            $('#action_clear').click(function(){
                $('#payment_cash').val(accounting.formatNumber(0,2));
                $('#summary_tendered').val(accounting.formatNumber(0,2));
                reComputeChange();
            });


            $('#btn_error_ok').click(function(){
                $('#typeaheadsearch').focus();
            });



            $('#action_cancel').click(function(){
                $('#modal_process_payment').modal('hide');
            });
            $('#action_enter').click(function(){
                alert('Finalize Payment');

            });

            $('#btn_barcode').click(function(){
                $('#typeaheadsearch').focus();
            });

            $('#btn_browse').click(function(){
             
            $('#modal_browse_item').modal('show');

            });

            $('#summary_tendered').on('keyup',function(){
                $('#payment_cash').val(accounting.formatNumber($(this).val(),2));
               reComputeChange();
            });

            $('#btn_focus_grid').click(function(){
                $('#typeaheadsearch').blur();
                row.focus();


            });

            // function click browse 
            $('#browseaction_clear').click(function(){
                $('#modal_browse_current').val('');
                $('#modal_browse_current').focus();
                $('#modal_browse_current').select();
            });
            $('#browseaction_cancel').click(function(){
                $('#modal_browse_item_qty').modal('hide');
                $('#modal_browse_item').modal('show');
            });

            $('#modal_browse_current').keypress(function(event) {
                if (event.keyCode == 13) {
                    $('#browseaction_enter').trigger('click');
                }
            });

            // prod action
            $('#browseaction_enter').click(function(){

                var browseqty =   parseFloat(accounting.unformat($('#modal_browse_current').val()));
                if(browseqty == 0 || browseqty == null){
                    showNotification({title:"Error !",stat:"error",msg:"Please Enter a Quantity!"});
                }else{
            var suggestion=dtproduct.row(rowproducts).data();
            var tax_rate=suggestion.tax_rate; //base on the tax rate set to current product
            var sale_price=0.00;
            sale_price=suggestion.sale_price;
            var total=getFloat(sale_price);
            var net_vat=0;
            var vat_input=0;
            var bulk_price = 0;
            var retail_price = 0;
            var zero_rated_sales = 0;


            if(suggestion.tax_rate=="0.00"){ // ZERO MEANS NO TAX THEN GOES TO ZERO RATED SALES
                tax_rate=0;
                net_vat=0;
                vat_input=0;
                zero_rated_sales = total;
            }else{ // GOES TO TAXABLE SALES
                net_vat=total/(1+(getFloat(tax_rate)/100));
                vat_input=total-net_vat;
                zero_rated_sales = 0;
            }
                a = '';
                bulk_price = suggestion.sale_price;

                if(suggestion.is_bulk == 1){
                    retail_price = getFloat(suggestion.sale_price) / getFloat(suggestion.child_unit_desc);

                }else if (suggestion.is_bulk== 0){
                    retail_price = 0;
                }
            changetxn = 'active';
            $('#tbl_items > tbody').append(newRowItem({
                inv_qty : browseqty,
                inv_gross : total,
                product_code : suggestion.product_code,
                product_id: suggestion.product_id,
                product_desc : suggestion.product_desc,
                inv_line_total_discount : "0.00",
                tax_exempt : false,
                inv_tax_rate : tax_rate,
                inv_price : suggestion.sale_price,
                inv_discount : "0.00",
                tax_type_id : null,
                inv_line_total_price : total,
                inv_non_tax_amount: net_vat,
                inv_tax_amount:vat_input,
                inv_line_total_after_global:0.00,
                    bulk_price: bulk_price,
                    retail_price: retail_price,
                    is_bulk: suggestion.is_bulk,
                    parent_unit_id : suggestion.parent_unit_id,
                    child_unit_id : suggestion.child_unit_id,
                    child_unit_name : suggestion.child_unit_name,
                    parent_unit_name : suggestion.parent_unit_name,
                    is_parent: 1 ,// INITIALLY , UNIT USED IS THE PARENT , 1 for PARENT 0 for CHILD
                    a:a,
                    zero_rated_sales:zero_rated_sales,
                    vat_exempt_sales : 0
            }));
         
                $('#tbl_items tbody tr').css('background-color','#fff');
                $('#tbl_items tbody tr').find('span').removeClass('fa fa-angle-right');
                $('#tbl_items tbody tr').css('cursor','pointer');
                row=$('#tbl_items tbody tr').last();
                row.find('span').toggleClass('fa fa-angle-right');
                $('#tbl_items tbody tr').last().css('background-color','rgb(255, 240, 107)');
            reInitializeNumeric();
            reComputeTotalv2(row);
            if(isScrolledToBottom){ out.scrollTop = out.scrollHeight - out.clientHeight; } //SCROLL TO BOTTOM WHEN SCROLLBAR IS PRESENT
            countCart();
            $('#modal_browse_item_qty').modal('hide');

                }

            });



            $('#btn_discount_accept').on('click',function(){

                dis_percentage_apply = parseFloat(accounting.unformat($('#discount_apply_percent').val()));
                dis_amount_apply = parseFloat(accounting.unformat($('#discount_apply_amount').val()));
                dis_id = parseFloat(accounting.unformat($('#discount_apply_discount_id').val()));
                var ref_tax=parseFloat(accounting.unformat(row.find(oTableItems.ref_tax).find('input.numeric').val()));
                if(checkDiscount()){
                    $(oTableItems.discount,row).find('input.numeric').val(accounting.formatNumber(dis_percentage_apply,2)); 
                    $(oTableItems.total_line_discount,row).find('input.numeric').val(accounting.formatNumber(dis_amount_apply,2));

                    if(dis_id == 1){ // if Senior Citizen, remove
                        $(oTableItems.discount,row).find('input.numeric').val(accounting.formatNumber(dis_percentage_apply,2)); 
                        $(oTableItems.total_line_discount,row).find('input.numeric').val(accounting.formatNumber(dis_amount_apply,2)); 
                        $(oTableItems.tax,row).find('input.numeric').val(accounting.formatNumber(0,2)); 
                        $(oTableItems.vat_input,row).find('input.numeric').val(accounting.formatNumber(0,2));
                        $(oTableItems.ref_discount_type,row).find('input').val(dis_id);
                    }else{
                        $(oTableItems.tax,row).find('input.numeric').val(accounting.formatNumber(ref_tax,2)); 
                        $(oTableItems.discount,row).find('input.numeric').val(accounting.formatNumber(dis_percentage_apply,2)); 
                        $(oTableItems.total_line_discount,row).find('input.numeric').val(accounting.formatNumber(dis_amount_apply,2)); 
                        $(oTableItems.ref_discount_type,row).find('input').val(dis_id);
                    }
                    reComputeTotalv2(row);

                    $('#modal_shortcut_discount').modal('hide');
                }else{
                    showNotification({title:"Error!",stat:"error",msg:'Please Check Transaction'});
                }
            });

            $('#txt_overall_discount').on('keyup',function(){
                reComputeTotal();
            });


            // FUNCTION MODAL

            $('#typeofpayment_card').click(function(){
                // var row = $('#valuecard_'+val).closest('tr');
                // row.css('font-weight','bolder');
                $('#modal_payment_card').modal('show');
            });


            $('#typeofpayment_check').click(function(){
                $('#modal_payment_check').modal('show');
            });


            $('#typeofpayment_gc').click(function(){
                $('#modal_payment_gc').modal('show');
            });


            $('#typeofpayment_charge').click(function(){
                $('#modal_payment_charge').modal('show');
            });


            $('#btn_void').click(function(){
                // row.remove();
                if(itemcount != 0){
                    $('#void_modal_confirm').modal('show');
                };


                // ADD  - IF THERE IS NO ROW, DONT SHOW MODAL

            });


            $('#btn_yes_void').click(function(){
                row.remove();
                reComputeTotal();                
                $('#tbl_items tbody tr').css('background-color','#fff');
                $('#tbl_items tbody tr').css('background-color','#fff');
                $('#tbl_items tbody tr').css('cursor','pointer');
                row = $('#tbl_items tbody tr:first');
                row.css('background-color','rgb(255, 240, 107)');
                row.find('span').toggleClass('fa fa-angle-right');
                countCart();
                $('#void_modal_confirm').modal('hide');
            });

            $('#btn_cancel').click(function(){
                if(itemcount != 0){
                     $('#cancel_modal_confirm').modal('show');
                };
            });

            $('#btn_yes_cancel').click(function(){
                $('#cancel_modal_confirm').modal('hide');
                $('#tbl_items tbody').html('');
                reComputeTotal();
                countCart();
            });


            $('#tbl_items tbody').on('click','tr',function(){
              $('#tbl_items tbody tr').css('background-color','#fff');
              $('#tbl_items tbody tr').css('cursor','pointer');
              $('#tbl_items tbody tr').find('span').removeClass('fa fa-angle-right');
              row=$(this).closest('tr');
              row.css('background-color','rgb(255, 240, 107)');
              row.find('span').toggleClass('fa fa-angle-right');
            });


            $('#btn_qty').click(function(){
                var modal_discount_product_code = row.find(oTableItems.product_code).find('input').val();
                var modal_discount_product_price = parseFloat(accounting.unformat(row.find(oTableItems.unit_price).find('input.numeric').val()));
                var modal_discount_qty = row.find(oTableItems.qty).find('input.numeric').val();
                var modal_discount_product_desc = row.find(oTableItems.ref_product_desc).find('input').val();
                $('#modal_qty_product_code').val(modal_discount_product_code);
                $('#modal_qty_product_price').val(accounting.formatNumber(modal_discount_product_price,2));
                $('#modal_qty_qty').val(accounting.formatNumber(modal_discount_qty,2));
                $('#modal_qty_current').val('');
                $('#modal_qty_product_desc').val(modal_discount_product_desc);
                $('#modal_shortcut_qty').modal('show');
            });


            $('#btn_discount').click(function(){
              // if (itemcount != 0){
                var modal_discount_prev=parseFloat(accounting.unformat(row.find(oTableItems.total_line_discount).find('input.numeric').val()));
                var modal_discount_current = 0;
                var modal_discount_product_code = row.find(oTableItems.product_code).find('input').val();
                var modal_discount_product_price = parseFloat(accounting.unformat(row.find(oTableItems.unit_price).find('input.numeric').val()));
                var modal_discount_qty = row.find(oTableItems.qty).find('input.numeric').val();
                // alert(parseFloat(accounting.unformat(row.find(oTableItems.unit_price).find('input.numeric').val())));
                $('#modal_discount_product_code').val(modal_discount_product_code);
                $('#modal_discount_product_price').val(accounting.formatNumber(modal_discount_product_price,2));
                $('#modal_discount_qty').val(accounting.formatNumber(modal_discount_qty,2));
                $('#modal_discount_prev').val(accounting.formatNumber(modal_discount_prev,2));
                $('#modal_discount_current').val(accounting.formatNumber(modal_discount_current,2));
                $('#give_manual_discount_amount').val('0.00');
                $('#give_manual_discount_percent').val('0.00');
                $('#give_manual_discount_amount').prop('disabled',true);
                $('#give_manual_discount_percent').prop('disabled',true);

                $('#give_manual_discount').prop('checked',false);
                getRefDiscount();
                $('#modal_shortcut_discount').modal('show');
            });

            $('#tbl_ref_discount tbody').on('click','tr',function(){
              $('#tbl_ref_discount tbody tr').css('background-color','#fff');
              $('#tbl_ref_discount tbody tr').css('cursor','pointer');
              rowdiscount=$(this).closest('tr');
              rowdiscount.css('background-color','rgb(255, 240, 107)');

              reComputeDiscount(rowdiscount);
               

            });

            $('#tbl_products tbody').on('click','tr',function(){
            $('#tbl_products tbody tr').css('background-color','#fff');
            $('#tbl_products tbody tr').css('cursor','pointer');
            $('#tbl_products tbody tr').find('span').removeClass('fa fa-angle-right');
            rowproducts=$(this).closest('tr');
            rowproducts.find('span').toggleClass('fa fa-angle-right');
            rowproducts.css('background-color','rgb(255, 240, 107)');
            $('#choose_product').val(dtproduct.row(rowproducts).data().product_id);          

            });
            $('#tbl_products tbody').dblclick(function(){
                $('#tbl_products tbody').trigger('click'); 
                $('#btn_modal_browse_accept').trigger('click');

            });

            $('#btn_modal_browse_cancel').click(function(){
                $('#modal_browse_item').modal('hide');

            });


            $("#searchbox").keyup(function(){         
                dtproduct
                    .search(this.value)
                    .draw();
            });

            $('#btn_modal_browse_accept').click(function(){
                prod_chosen = $('#choose_product').val();
                if(prod_chosen == 0 || prod_chosen == null){
                    showNotification({title:"Error !",stat:"error",msg:"Please Select a Product!"});
                }else{
                    var proddata=dtproduct.row(rowproducts).data();    
                    $('#modal_browse_product_desc').val(proddata.product_desc);
                    $('#modal_browse_product_code').val(proddata.product_code);
                    $('#modal_browse_qty').val('1');
                    $('#modal_browse_product_price').val(proddata.sale_price);
                    $('#modal_browse_current').val('1');
                    $('#modal_browse_item').modal('hide');
                    $('#modal_browse_item_qty').modal('show');

                }
            });



            $('#btn_modal_card_save').click(function(){
            if(validateRequiredFields($('#frm_modal_card'))){
                if($('#modal_card_amount').val() == 0 || $('#modal_card_amount').val() == ''){
                    showNotification({title:"Error !",stat:"error",msg:"Amount must not be zero !"});
                }else{
                    $('#payment_card').val($('#modal_card_amount').val());
                    reComputeChange();
                    $('#modal_payment_card').modal('hide');
                }
            }
            });

            // FUNCTION ACTION 

            $('#btn_modal_card_cancel').click(function(){
                val = $("#modal_card_id").val();
                rowcard=$('#valuecard_'+val).closest('tr');
                rowcard.css('background-color','rgb(255, 255, 255)');
                clearFields($('#frm_modal_card'));
                $('#modal_card_amount').val('0.00');
                $('#modal_payment_card').modal('hide');
                $('#payment_card').val('0.00');
                reComputeChange();
            });

            $('#searchboxofproducts').click(function(){

                $('#searchbox').val('');
                $('#searchbox').focus();
                $('#searchbox').trigger('keyup');

            })


            $('#btn_modal_card_clear').click(function(){
                val = $("#modal_card_id").val();
                rowcard=$('#valuecard_'+val).closest('tr');
                rowcard.css('background-color','rgb(255, 255, 255)');
                clearFields($('#frm_modal_card'));
                $('#modal_card_amount').val('0.00');
            });



            $('#qtyaction_clear').click(function(){
                $('#modal_qty_current').val('');
                $('#modal_qty_current').focus();
                $('#modal_qty_current').select();
            });
            $('#qtyaction_cancel').click(function(){
                $('#modal_shortcut_qty').modal('hide');
            });

            $('#modal_qty_current').keypress(function(event) {
                if (event.keyCode == 13) {
                    $('#qtyaction_enter').trigger('click');
                }
            });
            $('#qtyaction_enter').click(function(){
                currentqty = parseFloat(accounting.unformat($('#modal_qty_current').val()));
                $(oTableItems.qty,row).find('input.numeric').val(accounting.formatNumber(currentqty,2));
                // reComputeDiscount();
                reComputeTotalv2(row);

                $('#modal_shortcut_qty').modal('hide');
            });

            $("#give_manual_discount").change(function() {
                if(this.checked) {
                    $('#tbl_ref_discount tbody tr').each(function(){
                        $(this).prop('disabled',true);
                        $(this).css('background-color','#fff');
                    });
                    $('#give_manual_discount_amount').prop('disabled',false);
                    $('#give_manual_discount_amount').focus();
                    $('#give_manual_discount_amount').select();
                    $('#give_manual_discount_percent').prop('disabled',false);
                    $('#modal_discount_current').val('0.00');
                    $('#tbl_ref_discount').css('opacity','0.7');
                    $('#discount_apply_discount_id').val('2');// apply discount id of 2 (Static) 
                    $('#discount_apply_percent').val(accounting.formatNumber(0,2));
                    $('#discount_apply_amount').val(accounting.formatNumber(0,2));

                }else{

                    $('#tbl_ref_discount tbody tr').each(function(){
                        $(this).prop('disabled',false);
                    });
                    $('#give_manual_discount_amount').prop('disabled',true);
                    $('#give_manual_discount_percent').prop('disabled',true);
                    $('#give_manual_discount_amount').val('0.00');
                    $('#give_manual_discount_percent').val('0.00');
                    rowdiscount = $('#tbl_ref_discount tbody tr:first');
                    rowdiscount.css('background-color','rgb(255, 240, 107)');
                    reComputeDiscount(rowdiscount);
                    $('#tbl_ref_discount').css('opacity','1');


                }
            });

            $('#give_manual_discount_percent').keyup(function(){
                dis_percentage = parseFloat(accounting.unformat($('#give_manual_discount_percent').val()));
                var modal_discount_product_price = parseFloat(accounting.unformat(row.find(oTableItems.unit_price).find('input.numeric').val()));
                var modal_discount_qty = row.find(oTableItems.qty).find('input.numeric').val();
                current_discount_amount = ((modal_discount_product_price * modal_discount_qty)* (dis_percentage/100));
                $('#modal_discount_current').val(accounting.formatNumber(current_discount_amount,2));
                $('#give_manual_discount_amount').val(accounting.formatNumber(current_discount_amount,2));
                $('#discount_apply_percent').val(accounting.formatNumber($(this).val(),2));
                $('#discount_apply_amount').val(accounting.formatNumber(current_discount_amount,2));
                $('#discount_apply_discount_id').val('2');// STATIC ID OF MANUAL (2)
                checkDiscount();
            });
            $('#give_manual_discount_amount').keyup(function(){
                dis_amount = parseFloat(accounting.unformat($('#give_manual_discount_amount').val()));
                var modal_discount_product_price = parseFloat(accounting.unformat(row.find(oTableItems.unit_price).find('input.numeric').val()));
                var modal_discount_qty = row.find(oTableItems.qty).find('input.numeric').val();
                percent = (dis_amount / (modal_discount_product_price * modal_discount_qty));
                current_discount_percent = percent * 100;
                $('#modal_discount_current').val(accounting.formatNumber($(this).val(),2));
                $('#give_manual_discount_percent').val(accounting.formatNumber(current_discount_percent,2));
                $('#discount_apply_percent').val(accounting.formatNumber(current_discount_percent,2));
                $('#discount_apply_amount').val(accounting.formatNumber($(this).val(),2));
                $('#discount_apply_discount_id').val('2');// STATIC ID OF MANUAL (2)
                checkDiscount();
            });

            var reComputeDiscount=function(rowdiscount){
                var modal_discount_prev=parseFloat(accounting.unformat(row.find(oTableItems.discount).find('input.numeric').val()));
                var modal_discount_current = 0;
                var modal_discount_product_code = row.find(oTableItems.product_code).find('input').val();
                var modal_discount_product_price = parseFloat(accounting.unformat(row.find(oTableItems.unit_price).find('input.numeric').val()));
                var modal_discount_product_tax =parseFloat(accounting.unformat(row.find(oTableItems.ref_tax).find('input.numeric').val()))/100;
                var modal_discount_qty = row.find(oTableItems.qty).find('input.numeric').val();
                var total  = (modal_discount_qty * modal_discount_product_price);
                var net_vat=(total/(1+modal_discount_product_tax)); // TOTAL WITHOUT TAX
                var data=dtrefdiscount.row(rowdiscount).data(); // 
                var percentage = data.discount_percent;
                // get original tax to put in the input tax when discount is not senior citizen
                var reference_tax =row.find(oTableItems.ref_tax).find('input.numeric').val();
                // if senior citizen, remove vat then discount
                if(data.discount_type_id == 1){
                     newtotal  = net_vat
                }else{
                    newtotal = total;
                }
                var modal_line_total_discount=newtotal*(percentage/100);  
                $('#modal_discount_current').val(accounting.formatNumber(modal_line_total_discount,2));
                $('#discount_apply_amount').val(accounting.formatNumber(modal_line_total_discount,2));
                $('#discount_apply_percent').val(accounting.formatNumber(percentage,2));
                $('#discount_apply_discount_id').val(data.discount_type_id);
            };




        // New KEYUP FUNCTION OF TBL_ITEMS TBODY
        var reComputeTotalv2=function(row){
            var price=parseFloat(accounting.unformat(row.find(oTableItems.unit_price).find('input.numeric').val()));
            var discount=parseFloat(accounting.unformat(row.find(oTableItems.discount).find('input.numeric').val())); // percentage
            // var line_total_discount=parseFloat(accounting.unformat(row.find(oTableItems.total_line_discount).find('input.numeric').val()));
            var qty=parseFloat(accounting.unformat(row.find(oTableItems.qty).find('input.numeric').val()));
            var discount_type = parseFloat(accounting.unformat(row.find(oTableItems.ref_discount_type).find('input').val()));
            var tax_rate=parseFloat(accounting.unformat(row.find(oTableItems.ref_tax).find('input.numeric').val()))/100;
            var ref_tax=parseFloat(accounting.unformat(row.find(oTableItems.ref_tax).find('input.numeric').val()));
            var gross = price*qty;
            var line_total = price*qty; //   THIS LINE TOTAL DIFFERS DEPENDS ON THE TRANSACTION, HENCE, THIS VAR IS MANIPULATED BELOW

            if(discount_type > 0){ // means there is a discount
                if(discount_type == 1){ 
                    var discount_net_vat = line_total/(1+tax_rate);
                    var discount_vat_input = line_total - discount_net_vat;
                    var line_total_discount=discount_net_vat*(discount/100);
                    // line_total_discount is the discount of senior citizen  ------  Less the tax from total before applying discount
                    var net_vat = ((line_total-line_total_discount)/(1+tax_rate)); 
                    var vat_exempt_sales = line_total - discount_vat_input - line_total_discount;
                    var new_line_total=vat_exempt_sales;
                    var new_tax = 0;
                    var vat_input = 0;
                    var net_vat = 0;
                    if(ref_tax == 0){
                        zero_rated_sls = vat_exempt_sales;
                        vat_exempt_sales = 0;
                    }else{
                        vat_exempt_sales = vat_exempt_sales;
                        zero_rated_sls = 0;
                    }
                // IF ELSE OF DISCOUNT TYPES 
                 } else{
                    var line_total_discount=line_total*(discount/100); 
                    var net_vat = ((line_total-line_total_discount)/(1+tax_rate)); // first, get total without tax
                    var new_line_total=line_total-line_total_discount; 
                    var vat_input = new_line_total - net_vat;
                    var vat_exempt_sales = 0;
                    var new_tax = ref_tax ;

                    if(ref_tax == 0){ // ZERO RATED SALES 
                        var net_vat = 0;
                        var vat_input = 0;
                        var zero_rated_sls = new_line_total;
                        var new_line_total = new_line_total;
                    }else { // VAT 
                        var zero_rated_sls = 0;
                        var new_line_total = new_line_total;
                    }
                }
            // ELSE DISCOUNT IS NOT PRESENT
            }else{  // NO DISCOUNT
                    var net_vat = ((line_total)/(1+tax_rate)); // first, get total without tax
                    var vat_input = line_total - net_vat;
                    var new_line_total = line_total;
                    if(ref_tax == 0){
                        vat_input = 0;
                        net_vat = 0;
                        vat_exempt_sales = 0;
                        zero_rated_sls = line_total;
                    }else{ // VAT 
                        zero_rated_sls = 0;
                        vat_exempt_sales = 0;
                    }
            }

            $(oTableItems.gross,row).find('input.numeric').val(accounting.formatNumber(gross,2)); //gross
            $(oTableItems.total,row).find('input.numeric').val(accounting.formatNumber(new_line_total,2)); // line total amount
            $(oTableItems.total_line_discount,row).find('input.numeric').val(accounting.formatNumber(line_total_discount,2)); //line total discount
            $(oTableItems.net_vat,row).find('input.numeric').val(accounting.formatNumber(net_vat,2)); //net of vat
            $(oTableItems.vat_input,row).find('input.numeric').val(accounting.formatNumber(vat_input,2)); //vat amount
            $(oTableItems.tax,row).find('input.numeric').val(accounting.formatNumber(new_tax,2)); //vat input
            $(oTableItems.zero_rated_sls,row).find('input.numeric').val(accounting.formatNumber(zero_rated_sls,2)); // line total amount
            $(oTableItems.vat_exempt_sls,row).find('input.numeric').val(accounting.formatNumber(vat_exempt_sales,2)); // line total amount
            reComputeTotal();
            };
        })();

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

    var getFloat=function(f){
        return parseFloat(accounting.unformat(f));
    };

    var reComputeChange=function(f){
         total = parseFloat(accounting.unformat($('#td_total_after_discount').text()));
         payment_card = parseFloat(accounting.unformat($('#payment_card').val()));
         payment_check = parseFloat(accounting.unformat($('#payment_check').val()));
         payment_gc = parseFloat(accounting.unformat($('#payment_gc').val()));
         payment_charge = parseFloat(accounting.unformat($('#payment_charge').val()));
         payment_cash = parseFloat(accounting.unformat($('#payment_cash').val()));
         change =  ((payment_card + payment_check + payment_gc + payment_charge + payment_cash) - total);
         payment_total = (payment_card + payment_check + payment_gc + payment_charge + payment_cash);
         $('#payment_total').val(accounting.formatNumber(payment_total,2));
         $('#summary_change').val(accounting.formatNumber(change,2));
    };

    var reComputeTotal=function(){
        var rows=$('#tbl_items > tbody tr');
        var discounts=0; var before_tax=0; var after_tax=0; var inv_tax_amount=0;
        total_qty = 0;
        var global_discount = parseFloat(accounting.unformat($('#txt_overall_discount').val()/100));
        $.each(rows,function(){
            //console.log($(oTableItems.net_vat,$(this)));
            total=parseFloat(accounting.unformat($(oTableItems.total,$(this)).find('input.numeric').val()));
            total_after_global = (total - (total*global_discount));
            $(oTableItems.total_after_global,$(this)).find('input.numeric').val(accounting.formatNumber(total_after_global,2));
            discounts+=parseFloat(accounting.unformat($(oTableItems.total_line_discount,$(this)).find('input.numeric').val()));
            before_tax+=parseFloat(accounting.unformat($(oTableItems.net_vat,$(this)).find('input.numeric').val()));
            inv_tax_amount+=parseFloat(accounting.unformat($(oTableItems.vat_input,$(this)).find('input.numeric').val()));
            after_tax+=parseFloat(accounting.unformat($(oTableItems.total,$(this)).find('input.numeric').val()));
            total_qty+=parseFloat(accounting.unformat($(oTableItems.unit_qty,$(this)).find('input.numeric').val()));
        });
        $('#total_qty').text(total_qty);
        var tbl_summary=$('#tbl_cash_invoice_summary');
        tbl_summary.find(oTableDetails.discount).html(accounting.formatNumber(discounts,2));
        tbl_summary.find(oTableDetails.before_tax).html(accounting.formatNumber(before_tax,2));
        tbl_summary.find(oTableDetails.inv_tax_amount).html(accounting.formatNumber(inv_tax_amount,2));
        tbl_summary.find(oTableDetails.after_tax).html('<b>'+accounting.formatNumber(after_tax,2)+'</b>');


        $('#txt_overall_discount_amount').val(accounting.formatNumber(after_tax * ($('#txt_overall_discount').val() / 100),2));
        $('#td_total_before_tax').html(accounting.formatNumber(before_tax,2));
        $('#td_after_tax').html('<b>'+accounting.formatNumber(after_tax,2)+'</b>');
        $('#td_total_after_discount').html(accounting.formatNumber(after_tax - (after_tax * ($('#txt_overall_discount').val() / 100)),2));
        $('#td_tax').html(accounting.formatNumber(inv_tax_amount,2));
        $('#td_discount').html(accounting.formatNumber(discounts,2)); // unknown - must be referring to table summary but not on id given
        $('#main_summary_amount_due').text(accounting.formatNumber(after_tax - (after_tax * ($('#txt_overall_discount').val() / 100)),2));
    };
    var reInitializeNumeric=function(){
        $('.numeric').autoNumeric('init');
        $('.number').autoNumeric('init', {mDec:0});
    };

    var newRowItem=function(d){
        if(d.is_bulk == '1'){ unit = d.child_unit_name;}else{ unit  = d.parent_unit_name; }
        return '<tr>'+
        '<td width="5%"><span class=""></span></td>'+
        '<td width="30%">'+d.product_desc+'<input type="text" style="display:none;" class="form-control" name="is_parent[]" value="'+d.is_parent+'"></td>'+
        '<td width="10%">'+unit+'</td>'+
        '<td width="15%"><input name="inv_price[]" type="text" class="numeric " value="'+accounting.formatNumber(d.inv_price,2)+'" style="text-align:right;" readonly></td>'+
        '<td width="10%"><input name="inv_qty[]" type="text" class="numeric trigger-keyup" value="'+accounting.formatNumber(d.inv_qty,2)+'" readonly style="text-align:right;"></td>'+
        '<td  style="display:none;"><input name="inv_discount[]" type="text" class="numeric" value="'+ accounting.formatNumber(d.inv_discount,2)+'" style="text-align:right;" readonly></td>'+
        '<td style="15%" width=""><input name="inv_line_total_discount[]" type="text" class="numeric" value="'+ accounting.formatNumber(d.inv_line_total_discount,2)+'" readonly style="text-align:right;"></td>'+
        '<td style="display:none;"><input name="inv_tax_rate[]" type="text" class="numeric" value="'+ accounting.formatNumber(d.inv_tax_rate,2)+'"></td>'+
        '<td style="display:none;"><input name="inv_gross[]" type="text" class="numeric " value="'+ accounting.formatNumber(d.inv_gross,2)+'" readonly></td>'+
        '<td align="right" width=""><input name="inv_line_total_price[]" type="text" class="numeric" value="'+ accounting.formatNumber(d.inv_line_total_price,2)+'" readonly></td>'+
        '<td style="display:none;"><input name="inv_tax_amount[]" type="text" class="numeric form-control" value="'+ d.inv_tax_amount+'" readonly></td>'+
        '<td style="display:none;"><input name="inv_non_tax_amount[]" type="text" class="numeric form-control" value="'+ d.inv_non_tax_amount+'" readonly></td>'+
        '<td style="display:none;"><input name="product_id[]" type="text" class="numeric form-control" value="'+ d.product_id+'" readonly></td>'+
        '<td style="display:none;"><input name="inv_line_total_after_global[]" type="text" class="numeric form-control" value="'+ d.inv_line_total_after_global+'" readonly></td>'+
        '<td align="center" style="display:none;"><button type="button" name="remove_item" class="btn btn-red"><i class="fa fa-trash"></i></button></td>'+
        '<td style="display:none;"><input type="text" class="numeric form-control" value="'+ accounting.formatNumber(d.bulk_price,2)+'" readonly></td>'+
        '<td style="display:none;"><input type="text" class="numeric form-control" value="'+ accounting.formatNumber(d.retail_price,2)+'" readonly></td>'+
        '<td style="display:none;"><input type="text" class="form-control" value="'+d.product_code+'" readonly></td>'+
        '<td style="display:none;"><input type="text" class="form-control numeric" value="'+ accounting.formatNumber(d.inv_tax_rate,2)+'" readonly></td>'+
        '<td style="display:none;"><input type="text" name="product_name[]" class="form-control" value="'+d.product_desc+'" readonly></td>'+
        '<td style="display:none;"><input type="text" name="discount_type[]" class="form-control" value="0" readonly></td>'+
        '<td style="display:none;"><input type="text" name="zero_rated[]" class="form-control numeric" value="'+accounting.formatNumber(d.zero_rated_sales,2)+'" readonly></td>'+
        '<td style="display:none;"><input type="text" name="vat_exempt[]" class="form-control numeric" value="'+accounting.formatNumber(d.vat_exempt_sales,2)+'" readonly></td>'+
        '</tr>';
    };



        var getRefDiscount=function(){
          dtrefdiscount=$('#tbl_ref_discount').DataTable({
              "initComplete": function(settings, json) {
                    rowdiscount = $('#tbl_ref_discount tbody tr:first');
                    rowdiscount.css('background-color','rgb(255, 240, 107)');
                    rowdiscount.trigger('click');
              },
            "dom": '<"toolbar">frtip', 
            "bPaginate": false,
            "bInfo" : false,            
            "bFilter": false,
             "ajax" : "Ref_discounts/transaction/list",
             "bDestroy": true,
              "language": {
                 "searchPlaceholder": "Search Discount"
             },
             "columns": [
                { targets:[0],data: "discount_type_name"},
                 { targets:[1],data: null,
                    render: function (data, type, full, meta){
                         return '<input type="text" id="modaldicountpercentage_'+data.discount_type_id+'" class="numeric" value="'+accounting.formatNumber(data.discount_percent,2)+'" readonly><input type="text" id="modaldicountvalue_'+data.discount_type_id+'" class="discount_id" value="'+data.discount_type_id+'" style="display:none;">';
                    }
                }
             ],
             "rowCallback":function( row, data, index ){

                 $(row).find('td').eq(2).attr({
                     "align": "right"
                 });
                 $(row).find('td').css('padding','10px');
                 $(row).find('td').css('border-bottom','1px solid #B0BEC5');
                 }
             });
        };

 





        var clearFields=function(f){
            $('input,textarea,select,input:not(.date-picker)',f).val('');
            $('#remarks').val('');
            $(f).find('input:first').focus();
        };

        var checkDiscount=function(){ 
            var stat=true;
            final_percent =  parseFloat(accounting.unformat($('#discount_apply_percent').val()));
            if(final_percent > 100){
                showNotification({title:"Error!",stat:"error",msg:'Discount Percentage must not exceed to 100 !'});
                $('#discount_apply_percent').val('0.00');
                $('#discount_apply_amount').val('0.00');
                $('#give_manual_discount_amount').val('0.00');
                $('#give_manual_discount_percent').val('0.00');
                $('#modal_discount_current').val('0.00');                            
                stat=false;
                return false;}

            return stat;
        };
        var validateRequiredFields=function(f){
            var stat=true;
            $('div.form-group').removeClass('has-error');
            $('input[required],textarea[required],select[required]',f).each(function(){
                    if($(this).is('select')){
                        if($(this).val()==0 || $(this).val()==null || $(this).val()==undefined || $(this).val()==""){
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

    });

    </script>

    </body>

</html>