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
    <!--/twitter typehead-->
    <link href="assets/plugins/twittertypehead/twitter.typehead.css" rel="stylesheet">
    <style>
        #span_record_no{
            min-width: 50px;
        }
        #tbl_dr_invoice_filter
        {
            display:none;
        }
        #span_record_no:focus{
            border: 3px solid orange;
            background-color: yellow;
        }
        .alert {
            border-width: 0;
            border-style: solid;
            padding: 24px;
            margin-bottom: 32px;
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
            z-index: 9999999999;
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
        .custom_frame{
            border: 1px solid lightgray;
            margin: 1% 1% 1% 1%;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            border-radius: 5px;
        }
        .numeric{
            text-align: right;
        }
       /* .container-fluid {
            padding: 0 !important;
        }
        .panel-body {
            padding: 0 !important;
        }*/
        #btn_new {
            margin-top: 10px;
            margin-bottom: 10px;
            text-transform: uppercase!important;
        }
        @media screen and (max-width: 480px) {
            table{
                min-width: 800px;
            }
            .dataTables_filter{
                min-width: 800px;
            }
            .dataTables_info{
                min-width: 800px;
            }
            .dataTables_paginate{
                float: left;
                width: 100%;
            }
        }
        .form-group {
            margin-bottom: 15px;
        }
    </style>
    <link type="text/css" href="assets/css/light-theme.css" rel="stylesheet">
</head>
<body class="animated-content"  style="font-family: tahoma;">
<?php echo $_top_navigation; ?>
<div id="wrapper">
<div id="layout-static">
<?php echo $_side_bar_navigation;
?>
<div class="static-content-wrapper white-bg">
<div class="static-content"  >
<div class="page-content"><!-- #page-content -->
<ol class="breadcrumb"  style="margin-bottom: 0;">
    <li><a href="Dashboard">Dashboard</a></li>
    <li><a href="Delivery_receipt">Delivery Receipt</a></li>
</ol>
<div class="container-fluid"">
<div data-widget-group="group1">
<div class="row">
<div class="col-md-12">
<div id="div_dr_invoice_list">
    <div class="panel panel-default">
        <!-- <div class="panel-heading">
            <b style="color: white; font-size: 12pt;"><i class="fa fa-bars"></i>&nbsp; Sales Invoice</b>
        </div> -->
        <div class="panel-body table-responsive">
        <div class="row panel-row">
        <h2 class="h2-panel-heading">Delivery Receipt</h2><hr>
        <button class="btn btn-success" id="btn_new" style="text-transform: none;font-family: Tahoma, Georgia, Serif; " data-toggle="modal" data-target="#salesInvoice" data-placement="left" title="Record Delivery Receipt" > Record Delivery Receipt</button>
        <div id="new-search-area" class="col-sm-2 col-md-2" style="float: right;">
            <input type="text" id="searchbox" class="form-control">
        </div>
            <table id="tbl_dr_invoice" class="table table-striped" cellspacing="0" width="100%" style="">
                <thead >
                <tr>
                    <th></th>
                    <th>Invoice #</th>
                    <th>Invoice Date</th>
                    <th>Due Date</th>
                    <th>Customer</th>
                    <th>Department</th>
                    <th>Remarks</th>
                    <th><center>Action</center></th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        </div>
        <!-- <div class="panel-footer"></div> -->
    </div>
</div>
<div id="div_dr_invoice_fields" style="display: none;">
    <div class="panel panel-default">
        <div class="pull-right">
            <h4 class="dr_invoice_title" style="margin-top: 0%;"></h4>
            <div class="btn btn-green" style="margin-left: 10px;">
                <strong><a id="btn_receive_so" href="#" style="text-decoration: none; color: white;">Create from Sales Order</a></strong>
            </div>
        </div>
        <div class="panel-body" >
        <div class="row panel-row">
            <form id="frm_dr_invoice" role="form" class="form-horizontal">
                <h2 class="h2-panel-heading">Receipt # : <span id="span_record_no">DR-XXXX</span></h4>
                <div>
                <hr>
                    <div class="row">
                        <div class="col-sm-4">
                            <label>Sales Invoice # :</label> <br />
                            <div class="input-group">
                                <input type="text" name="sales_inv_no" class="form-control">
                                <span class="input-group-addon">
                                    <a href="#" id="link_browse" style="text-decoration: none;color:black;"><b>...</b></a>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-2 ">
                            <b class="required">*</b> <label>Invoice Date :</label> <br />
                            <div class="input-group">
                                <input type="text" name="date_invoice" id="invoice_default" class="date-picker form-control" value="<?php echo date("m/d/Y"); ?>" placeholder="Date Invoice" data-error-msg="Please set the date this items are issued!" required>
                                 <span class="input-group-addon">
                                     <i class="fa fa-calendar"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <b class="required">*</b><label> Department :</label> <br />
                            <select name="department" id="cbo_departments" data-error-msg="Department is required." required>
                                <?php foreach($departments as $department){ ?>
                                    <option value="<?php echo $department->department_id; ?>"><?php echo $department->department_name; ?></option>
                                <?php } ?>
                            </select>
                        </div>


                    </div>
                    <div class="row">

                        <div class="col-sm-4">
                            <b class="required">*</b><label>Customer :</label> <br />
                            <select name="customer" id="cbo_customers" data-error-msg="Customer is required." required>
                                <?php foreach($customers as $customer){ ?>
                                    <option data-address="<?php echo $customer->address; ?>" data-customer="<?php echo $customer->contact_name; ?>"   value="<?php echo $customer->customer_id; ?>" data-term-default="<?php echo ($customer->term=="none"?"":$customer->term); ?>"><?php echo $customer->customer_name; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <label>Contact Person :</label><br/>
                            <input type="text" name="contact_person" id="contact_person" class="form-control" required data-error-msg="Contact Person is required!" placeholder="Contact Person">
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-sm-8">
                            <label>Address :</label><br>
                            <input class="form-control" id="txt_address" type="text" name="address" placeholder="Customer Address">
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div>
        <hr>
            <label class="control-label" style="font-family: Tahoma;"><strong>Enter PLU or Search Item :</strong></label>
            <div id="custom-templates">
                <input class="typeahead" type="text" placeholder="Enter PLU or Search Item">
            </div><br />
            <form id="frm_items">
                <div class="table-responsive">
                    <table id="tbl_items" class="table table-striped" cellspacing="0" width="100%" style="font-font:tahoma;">
                        <thead class="">    
                        <tr>
                            <th width="10%">Qty</th><!-- 10% -->
                            <th width="10%">UM</th> <!-- 10% -->
                            <th width="25%">Item</th> <!-- 25% -->
                            <th width="12%" style="text-align: right;">Unit Price</th> <!-- 15% -->
                            <th width="12%" style="text-align: right;">Discount % </th>
                            <!-- DISPLAY NONE display: none;  -->
                            <th style="display: none;" width="7%">Total Discount</th> <!-- total discount -->
                            <th style="display: none;" width="7%">Tax %</th>
                            <!-- DISPLAY -->
                            <th width="12%" style="text-align: right;">Gross</th>
                            <th width="12%" style="text-align: right;">Net Total</th>
                            <!-- DISPLAY NONE  -->
                            <th style="display: none;" width="10%">Vat Input(Total Line Tax)</th> <!-- vat input -->
                            <th style="display: none;" width="10%">Net of Vat (Price w/out Tax)</th> <!-- net of vat -->
                            <td style="display: none;" width="10%">Item ID</td><!-- product id -->
                            <th style="display: none;" width="10%">Total after Global</th> 

                            <th><center>Action</center></th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="6" style="height: 50px;">&nbsp;</td>
                            </tr>
                            <tr>
                                <td style="text-align: right;">Discount %:</td>
                                <td align="right" colspan="1" id="" color="red">
                                <input id="txt_overall_discount" name="total_overall_discount" type="text" class="numeric form-control" value="0.00" />
                                <input type="hidden" id="txt_overall_discount_amount" name="total_overall_discount_amount" class="numeric form-control" value="0.00" readonly></td>

                                <td style="text-align: right;">Total After Discount:</td>
                                <td id="td_total_after_discount" style="text-align: right">0.00</td>

                                <td style="text-align: right;" colspan="2">Total before tax:</td>
                                <td id="td_total_before_tax" style="text-align: right">0.00</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="2" style="text-align: right;"><strong><i class="glyph-icon icon-star"></i> Tax :</strong></td>
                                <td align="right" colspan="2" id="td_tax" color="red">0.00</td>
                                <td colspan="2"  style="text-align: right;"><strong><i class="glyph-icon icon-star"></i> Total After Tax :</strong></td>
                                <td align="right" colspan="1" id="td_after_tax" color="red">0.00</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </form>
        </div>
        <div class="row">
            <div class="container-fluid">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><br />
                <div class="row"><hr>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <label ><strong>Remarks :</strong></label>
                        <div class="col-lg-12" style="padding: 0%;">
                            <textarea name="remarks" id="remarks" class="form-control" placeholder="Remarks"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row" style="display: none;">
                    <div class="col-lg-4 col-lg-offset-8">
                        <div class="table-responsive">
                            <table id="tbl_dr_invoice_summary" class="table invoice-total" style="font-family: tahoma;">
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
            </div>
            </div>
        </div>
        <br />
    </div>
    <div class="panel-footer" >
        <div class="row">
            <div class="col-sm-12">
                <button id="btn_save" class="btn-primary btn" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;"><span class=""></span>Save Changes</button>
                <button id="btn_cancel" class="btn-default btn" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;">Cancel</button>
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
            <div class="modal-header ">
                <button type="button" class="close"   data-dismiss="modal" aria-hidden="true">X</button>
                <h4 class="modal-title" style="color:white;"><span id="modal_mode"> </span>Confirm Deletion</h4>
            </div>
            <div class="modal-body">
                <p id="modal-body-message">Are you sure you want to delete?</p>
            </div>
            <div class="modal-footer">
                <button id="btn_yes" type="button" class="btn btn-danger" data-dismiss="modal" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;">Yes</button>
                <button id="btn_close" type="button" class="btn btn-default" data-dismiss="modal" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;">No</button>
            </div>
        </div>
    </div>
</div>
<div id="modal_so_list" class="modal fade" tabindex="-1" role="dialog"><!--modal-->
    <div class="modal-dialog" style="width: 80%;">
        <div class="modal-content">
            <div class="modal-header ">
                <button type="button" class="close"   data-dismiss="modal" aria-hidden="true">X</button>
                <h2 class="modal-title" style="color: white;"><span id="modal_mode"> </span>Sales Invoice</h2>
            </div>
            <div class="modal-body">
            <div class="row">
            <table id="tbl_si_list" class="table table-striped" cellspacing="0" width="100%">
                <thead >
                <tr>
                    <th></th>
                    <th style="">Invoice #</th>
                    <th>Invoice Date</th>
                    <th>Due Date</th>
                    <th>Customer</th>
                    <th >Order Status</th>
                    <th>Remarks</th>
                    <th><center>Action</center></th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            </div>

            </div>
            <div class="modal-footer">
      <!--           <button id="btn_accept" type="button" class="btn btn-green" style="text-transform: none;font-family: Tahoma, Georgia, Serif;">Receive this Order</button> -->
                <button id="cancel_modal" class="btn btn-default" style="text-transform: none;font-family: Tahoma, Georgia, Serif;">Cancel</button>
            </div>
        </div>
    </div>
<div class="clearfix"></div>
</div><!---modal-->


<footer role="contentinfo">
    <div class="clearfix">
        <ul class="list-unstyled list-inline pull-left">
            <li><h6 style="margin: 0;">&copy; 2017 - JDEV OFFICE SOLUTIONS</h6></li>
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
<script>
$(document).ready(function(){
    var dt; var _txnMode; var _selectedID; var _selectRowObj; var _cboDepartments; var _cboDepartments; var _cboCustomers; var dt_so;
    var oTableItems={
        qty : 'td:eq(0)',
        unit_price : 'td:eq(3)',
        discount : 'td:eq(4)',
        total_line_discount : 'td:eq(5)',
        tax : 'td:eq(6)',
        gross : 'td:eq(7)',
        total : 'td:eq(8)',
        vat_input : 'td:eq(9)',
        net_vat : 'td:eq(10)',
        total_after_global :' td:eq(12)'
    };
    var oTableDetails={
        discount : 'tr:eq(0) > td:eq(1)',
        before_tax : 'tr:eq(1) > td:eq(1)',
        inv_tax_amount : 'tr:eq(2) > td:eq(1)',
        after_tax : 'tr:eq(3) > td:eq(1)'
    };
    var initializeControls=function(){
        dt=$('#tbl_dr_invoice').DataTable({
            "dom": '<"toolbar">frtip',
            "bLengthChange":false,
            "ajax" : "Delivery_receipt/transaction/list_with_count",
            "language": {
                "searchPlaceholder":"Search Receipt"
            },
            "columns": [
                {
                    "targets": [0],
                    "class":          "details-control",
                    "orderable":      false,
                    "data":           null,
                    "defaultContent": ""
                },
                { targets:[1],data: "delivery_inv_no" },
                { targets:[2],data: "date_invoice" },
                {visible:false, targets:[3],data: "date_due" },
                { targets:[4],data: "customer_name" },
                { targets:[5],data: "department_name" },
                { targets:[6],data: "remarks" },
                {
                    targets:[7],
                    render: function (data, type, full, meta){
                        var btn_edit='<button class="btn btn-primary btn-sm" name="edit_info"  style="margin-left:-15px;" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil"></i> </button>';
                        var btn_trash='<button class="btn btn-danger btn-sm" name="remove_info" style="margin-right:0px;" data-toggle="tooltip" data-placement="top" title="Move to trash"><i class="fa fa-trash-o"></i> </button>';
                        return '<center>'+btn_edit+"&nbsp;"+btn_trash+'</center>';
                    }
                }
            ]
        });

        dt_so=$('#tbl_si_list').DataTable({
            "dom": '<"toolbar">frtip',
            "bLengthChange":false,
            "language": {
                "searchPlaceholder":"Search Invoice"
            },
            "ajax" : "Delivery_receipt/transaction/open-sales-invoices",
            "columns": [
                {
                    "targets": [0],
                    "class":          "details-control",
                    "orderable":      false,
                    "data":           null,
                    "defaultContent": ""
                },
                { targets:[1],data: "sales_inv_no" },
                { targets:[2],data: "date_invoice" },
                { targets:[3],data: "date_due" },
                { targets:[4],data: "customer_name" },
                { targets:[5],data: "order_status" },
                { targets:[6],data: "remarks" },
                {
                    targets:[7],
                    render: function (data, type, full, meta){
                    var btn_accept='<button class="btn btn-success btn-sm" name="accept_si"  style="margin-left:-15px;text-transform: none;" data-toggle="tooltip" data-placement="top" title="Receive this Invoice"><i class="fa fa-check"></i> Accept Invoice</button>';
                        return '<center>'+btn_accept+'</center>';
                    }
                }
            ]
        });

            





        $('.numeric').autoNumeric('init');
        $('#contact_no').keypress(validateNumber);
        // var createToolBarButton=function(){
        //     var _btnNew='<button class="btn btn-success" id="btn_new" style="text-transform: none;font-family: Tahoma, Georgia, Serif; " data-toggle="modal" data-target="#salesInvoice" data-placement="left" title="Record Delivery Receipt" >'+
        //         '<i class="fa fa-plus"></i> Record Delivery Receipt</button>';
        //     $("div.toolbar").html(_btnNew);
        // }();
        _cboDepartments=$("#cbo_departments").select2({
            placeholder: "Please select Department.",
            allowClear: false
        });
        _cboCustomers=$("#cbo_customers").select2({
            placeholder: "Please select customer.",
            allowClear: false
        });

        _cboDepartments.select2('val', null);
        _cboCustomers.select2('val',null);
        $('.date-picker').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true
        });

        $('#custom-templates .typeahead').keypress(function(event){
            if (event.keyCode == 13) {
                $('.tt-suggestion:first').click();
            }
        });
        var raw_data = <?php echo json_encode($products); ?>;
        var products = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('product_code','product_desc','product_desc1'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            local : raw_data
        });
        var _objTypeHead=$('#custom-templates .typeahead');
        _objTypeHead.typeahead(null, {
        name: 'products',
        display: 'product_code',
        source: products,
        templates: {
            header: [
                '<table class="tt-head"><tr><td width=20%" style="padding-left: 1%;"><b>PLU</b></td><td width="20%" align="left"><b>Description</b></td><td width="10%" align="left" style="padding-right: 2%;"><b>SRP</b></td></tr></table>'
            ].join('\n'),
            suggestion: Handlebars.compile('<table class="tt-items"><tr><td width="20%" style="padding-left: 1%;">{{product_code}}</td><td width="20%" align="left">{{product_desc}}</td><td width="10%" align="left" style="padding-right: 2%;">{{sale_price}}</td></tr></table>')
        }
        }).on('keyup', this, function (event) {
            if (_objTypeHead.typeahead('val') == '') {
                return false;
            }
            if (event.keyCode == 13) {
             
                // $('.tt-suggestion:first').click();
    _objTypeHead.typeahead('close');        //     -- changed due to barcode scan not working
    _objTypeHead.typeahead('val','');         //  -- changed due to barcode scan not working
            }
        }).bind('typeahead:select', function(ev, suggestion) {
            //console.log(suggestion);
            //alert(suggestion.sale_price);
            var tax_rate=suggestion.tax_rate; //base on the tax rate set to current product
            //choose what purchase cost to be use
            var sale_price=0.00;
            sale_price=suggestion.sale_price;
            //alert(suggestion.sale_price);
            var total=getFloat(sale_price);
            var net_vat=0;
            var vat_input=0;
            if(suggestion.is_tax_exempt=="0"){ //not tax excempt
                net_vat=total/(1+(getFloat(tax_rate)/100));
                vat_input=total-net_vat;
            }else{
                tax_rate=0;
                net_vat=total;
                vat_input=0;
            }
            $('#tbl_items > tbody').append(newRowItem({
                inv_qty : "1",
                inv_gross : total,
                product_code : suggestion.product_code,
                unit_id : suggestion.unit_id,
                unit_name : suggestion.unit_name,
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
                inv_line_total_after_global:0.00
            }));
            reInitializeNumeric();
            reComputeTotal();
            //alert("dd")
        });
        $('div.tt-menu').on('click','table.tt-suggestion',function(){
            _objTypeHead.typeahead('val','');
        });
        $("input#touchspin4").TouchSpin({
            verticalbuttons: true,
            verticalupclass: 'fa fa-fw fa-plus',
            verticaldownclass: 'fa fa-fw fa-minus'
        });
    }();
    
    var bindEventHandlers=(function(){
        var detailRows = [];
        $('#tbl_dr_invoice tbody').on( 'click', 'tr td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = dt.row(tr);
            var d=row.data();

            window.open('Templates/layout/delivery-receipt/'+ d.delivery_receipt_id+'?type=contentview');
        } );
        $('#link_browse').click(function(){
            $('#btn_receive_so').click();
        });

    $('#tbl_si_list tbody').on( 'click', 'tr td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = dt_so.row( tr );
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
                //console.log(tr);
                _selectRowObj=$(this).closest('tr');
                var d=dt_so.row(_selectRowObj).data();
                $.ajax({
                    "dataType":"html",
                    "type":"POST",
                    "url":"Templates/layout/sales-invoice/"+ d.sales_invoice_id+'?type=dropdown',
                    "beforeSend" : function(){
                        row.child( '<center><br /><img src="assets/img/loader/ajax-loader-lg.gif" /><br /><br /></center>' ).show();
                    }
                }).done(function(response){
                    row.child( response,'no-padding' ).show();
                    tr.addClass( 'details' );
                    // Add to the 'open' array
                    if ( idx === -1 ) {
                        detailRows.push( tr.attr('id') );
                    }
                });
            }
        } );
        $('#btn_receive_so').click(function(){
            $('#tbl_si_list tbody').html('<tr><td colspan="7"><center><br /><img src="assets/img/loader/ajax-loader-lg.gif" /><br /><br /></center></td></tr>');
            dt_so.ajax.reload( null, false );
            $('#modal_so_list').modal('show');
        });
        $('#btn_new').click(function(){
            _txnMode="new";
            clearFields($('#div_dr_invoice_fields'));
            $('#span_record_no').html('DR-YYYYMMDD-XXXX');
            showList(false);

            $('#tbl_items > tbody').html('');
            $('#cbo_departments').select2('val', null);
            $('#cbo_customers').select2('val', null);
            $('#img_user').attr('src','assets/img/anonymous-icon.png');
            $('#td_discount').html('0.00');
            $('#td_total_before_tax').html('0.00');
            $('#td_tax').html('0.00');
            $('#td_total_after_tax').html('0.00');
            $('#txt_overall_discount').val('0.00'); 
            $('#txt_overall_discount_amount').val('0.00'); 
            $('#invoice_default').datepicker('setDate', 'today');
            /*$('#cbo_prodType').select2('val', 3);
            $('#cboLookupPrice').select2('val', 1);*/
            reComputeTotal(); //this is to make sure, display summary are recomputed as 0
        });
        $('#tbl_si_list > tbody').on('click','button[name="accept_si"]',function(){
            _selectRowObj=$(this).closest('tr');
            var data=dt_so.row(_selectRowObj).data();
            //alert(data.sales_order_id);
            $('input,textarea').each(function(){
                var _elem=$(this);
                $.each(data,function(name,value){
                    if(_elem.attr('name')==name&&_elem.attr('type')!='password'){
                        _elem.val(value);
                    }
                });
                $('#cbo_customers').select2('val',data.customer_id);
                $('#cbo_departments').select2('val',data.department_id);
                // $('#cbo_department').select2('val',data.department_id);
            });
            $('#modal_so_list').modal('hide');
            resetSummary();
            $.ajax({
                url : 'Delivery_receipt/transaction/item-balance/'+data.sales_invoice_id,
                type : "GET",
                cache : false,
                dataType : 'json',
                processData : false,
                contentType : false,
                beforeSend : function(){
                    $('#tbl_items > tbody').html('<tr><td align="center" colspan="8"><br /><img src="assets/img/loader/ajax-loader-sm.gif" /><br /><br /></td></tr>');
                },
                success : function(response){
                    var rows=response.data;
                    $('#tbl_items > tbody').html('');
                    //var rowCount = $('#tbl-items .row-item');
                    //console.log(rowCount);
                    $.each(rows,function(i,value){
                        $('#tbl_items > tbody').append(newRowItem({
                            inv_gross : value.inv_gross, // ok
                            inv_qty : value.si_qty, //ok 
                            product_code : value.product_code, //ok
                            unit_id : value.unit_id, //ok
                            unit_name : value.unit_name, //ok
                            product_id: value.product_id, //ok
                            product_desc : value.product_desc, //ok
                            inv_line_total_discount : value.line_total_discount, //ok
                            tax_exempt : false,
                            inv_tax_rate : value.si_tax,//ok
                            inv_price : value.si_price, //ok
                            inv_discount : value.si_discount, //ok
                            tax_type_id : null,
                            inv_line_total_price : value.si_line_total, //ok
                            inv_non_tax_amount: value.non_tax_amount,
                            inv_tax_amount:value.tax_amount,
                            orig_so_price : value.si_price,
                            inv_line_total_after_global: 0.00,
                            cost_upon_invoice : value.purchase_cost
                        }));
                    });
                $('#txt_overall_discount').val(accounting.formatNumber($('#txt_overall_discount').val(),2));
                reInitializeNumeric();
                reComputeTotal();
                
                }
            });
        });
        $("#searchbox").keyup(function(){         
            dt
                .search(this.value)
                .draw();
        });


        $('#tbl_dr_invoice tbody').on('click','button[name="edit_info"]',function(){
            _selectRowObj=$(this).closest('tr');
            var data=dt.row(_selectRowObj).data();
            _selectedID=data.delivery_receipt_id;
            // alert(data.delivery_receipt_id);
            _is_journal_posted=data.is_journal_posted;
            if(_is_journal_posted > 0){
                showNotification({title:"<b style='color:white;'> Error!</b>",stat:"error",msg:"Cannot Edit: Invoice is already Posted in Sales Journal."});
            }
            else
            {

            _txnMode="edit";
            $('.dr_invoice_title').html('Edit Delivery Receipt Invoice');
            _selectRowObj=$(this).closest('tr');
            var data=dt.row(_selectRowObj).data();
            _selectedID=data.delivery_receipt_id;
            
            $('input,textarea').each(function(){
                var _elem=$(this);
                $.each(data,function(name,value){
                    if(_elem.attr('name')==name&&_elem.attr('type')!='password'){
                        _elem.val(value);
                    }
                });
            });
            $('#cbo_departments').select2('val',data.department_id);
            $('#cbo_customers').select2('val',data.customer_id);

            $.ajax({
                url : 'Delivery_receipt/transaction/items/'+data.delivery_receipt_id,
                type : "GET",
                cache : false,
                dataType : 'json',
                processData : false,
                contentType : false,
                beforeSend : function(){
                    $('#tbl_items > tbody').html('<tr><td align="center" colspan="8"><br /><img src="assets/img/loader/ajax-loader-sm.gif" /><br /><br /></td></tr>');
                },
                success : function(response){
                    var rows=response.data;
                    $('#tbl_items > tbody').html('');
                    $.each(rows,function(i,value){
                        $('#tbl_items > tbody').append(newRowItem({
                            inv_qty : value.inv_qty,
                            product_code : value.product_code,
                            unit_id : value.unit_id,
                            inv_gross : value.inv_gross,
                            unit_name : value.unit_name,
                            product_id: value.product_id,
                            product_desc : value.product_desc,
                            inv_line_total_discount : value.inv_line_total_discount,
                            tax_exempt : false,
                            inv_tax_rate : value.inv_tax_rate,
                            inv_price : value.inv_price,
                            inv_discount : value.inv_discount,
                            tax_type_id : null,
                            inv_line_total_price : value.inv_line_total_price,
                            inv_non_tax_amount: value.inv_non_tax_amount,
                            inv_tax_amount:value.inv_tax_amount,
                            inv_line_total_after_global : 0.00
                        }));
                    });
                    reComputeTotal();
                }
            });
            $('#span_record_no').html(data.delivery_inv_no);
            showList(false);
        }
        });
        $('#tbl_dr_invoice tbody').on('click','button[name="remove_info"]',function(){
            _selectRowObj=$(this).closest('tr');
            var data=dt.row(_selectRowObj).data();
            _selectedID=data.delivery_receipt_id;
            _is_journal_posted=data.is_journal_posted;
            if(_is_journal_posted > 0){
                showNotification({title:"<b style='color:white;'> Error!</b> ",stat:"error",msg:"Cannot Delete: Invoice is already Posted in Sales Journal."});
            }
            else
            {

            _selectRowObj=$(this).closest('tr');
            var data=dt.row(_selectRowObj).data();
            _selectedID=data.delivery_receipt_id;
            //alert(_selectedID);
            $('#modal_confirmation').modal('show');
        }
        });
        //track every changes on numeric fields
        $('#txt_overall_discount').on('keyup',function(){
            reComputeTotal();
        });

        $('#tbl_items tbody').on('keyup','input.numeric',function(){
            var row=$(this).closest('tr');
            var price=parseFloat(accounting.unformat(row.find(oTableItems.unit_price).find('input.numeric').val()));
            var discount=parseFloat(accounting.unformat(row.find(oTableItems.discount).find('input.numeric').val()));
            var qty=parseFloat(accounting.unformat(row.find(oTableItems.qty).find('input.numeric').val()));
            var tax_rate=parseFloat(accounting.unformat(row.find(oTableItems.tax).find('input.numeric').val()))/100;
            if(discount>price){
                showNotification({title:"Invalid",stat:"error",msg:"Discount must not greater than unit price."});
                row.find(oTableItems.discount).find('input.numeric').val('0.00');
                //$(this).trigger('keyup');
                //return;
            }



            // var discounted_price=price-discount;
            // var line_total_discount=discount*qty;
            // var line_total=discounted_price*qty;


            var line_total = price*qty; //ok not included in the output (view) and not saved in the database
            var line_total_discount=line_total*(discount/100);  
            var net_vat=line_total/(1+tax_rate);
            var vat_input=line_total-net_vat;
            var new_line_total=line_total-line_total_discount; 


            $(oTableItems.gross,row).find('input.numeric').val(accounting.formatNumber(line_total,2)); //gross
            $(oTableItems.total,row).find('input.numeric').val(accounting.formatNumber(new_line_total,2)); // line total amount
            $(oTableItems.total_line_discount,row).find('input.numeric').val(line_total_discount); //line total discount
            $(oTableItems.net_vat,row).find('input.numeric').val(net_vat); //net of vat
            $(oTableItems.vat_input,row).find('input.numeric').val(vat_input); //vat input
            //console.log(net_vat);
            reComputeTotal();
        });
        $('#btn_yes').click(function(){
            //var d=dt.row(_selectRowObj).data();
            //if(getFloat(d.order_status_id)>1){
            //showNotification({title:"Error!",stat:"error",msg:"Sorry, you cannot delete purchase order that is already been recorded on purchase invoice."});
            //}else{
            removeIssuanceRecord().done(function(response){
                showNotification(response);
                if(response.stat=="success"){
                    dt.row(_selectRowObj).remove().draw();
                }
            });
            //}
        });
        $('#btn_cancel').click(function(){
            //$('#modal_so_list').modal('hide');
            showList(true);
        });
        $('#btn_save').click(function(){
            if(validateRequiredFields($('#frm_dr_invoice'))){
                if(_txnMode=="new"){
                    createDrInvoice().done(function(response){
                        showNotification(response);
                        dt.row.add(response.row_added[0]).draw();
                        clearFields($('#frm_dr_invoice'));
                        showList(true);
                    }).always(function(){
                        showSpinningProgress($('#btn_save'));
                    });
                }else{
                    updateDrInvoice().done(function(response){
                        showNotification(response);
                        dt.row(_selectRowObj).data(response.row_updated[0]).draw();
                        clearFields($('#frm_dr_invoice'));
                        showList(true);
                    }).always(function(){
                        showSpinningProgress($('#btn_save'));
                    });
                }
            }
        });


        _cboCustomers.on("select2:select", function (e) {
            var i=$(this).select2('val');
            if(i==0){ //new customer
                //clearFields($('#modal_new_customer').find('form'));
                _cboCustomers.select2('val',null)
                $('#modal_new_customer').modal('show');
            }
            var obj_customers=$('#cbo_customers').find('option[value="' + i + '"]');
            $('#txt_address').val(obj_customers.data('address'));
            $('#contact_person').val(obj_customers.data('customer'));
        });

      
        $('#tbl_items > tbody').on('click','button[name="remove_item"]',function(){
            $(this).closest('tr').remove();
            reComputeTotal();
        });
        $('#btn_browse').click(function(event){
            event.preventDefault();
            $('input[name="file_upload[]"]').click();
        });
        $('input[name="file_upload[]"]').change(function(event){
            var _files=event.target.files;
            /*$('#div_img_product').hide();
            $('#div_img_loader').show();*/
            var data=new FormData();
            $.each(_files,function(key,value){
                data.append(key,value);
            });
            console.log(_files);
            $.ajax({
                url : 'Customers/transaction/upload',
                type : "POST",
                data : data,
                cache : false,
                dataType : 'json',
                processData : false,
                contentType : false,
                success : function(response){
                    $('img[name="img_user"]').attr('src',response.path);
                }
            });
        });
        $('#btn_remove_photo').click(function(event){
            event.preventDefault();
            $('img[name="img_user"]').attr('src','assets/img/anonymous-icon.png');
        });
    })();
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

    var createDrInvoice=function(){
        var _data=$('#frm_dr_invoice,#frm_items').serializeArray();
        var tbl_summary=$('#tbl_dr_invoice_summary');
        _data.push({name : "remarks", value : $('textarea[name="remarks"]').val()});

        _data.push({name : "total_after_discount", value: $('#td_total_after_discount').text()});
        _data.push({name : "summary_discount", value : tbl_summary.find(oTableDetails.discount).text()});
        _data.push({name : "summary_before_discount", value :tbl_summary.find(oTableDetails.before_tax).text()});
        _data.push({name : "summary_tax_amount", value : tbl_summary.find(oTableDetails.inv_tax_amount).text()});
        _data.push({name : "summary_after_tax", value : tbl_summary.find(oTableDetails.after_tax).text()});
        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Delivery_receipt/transaction/create",
            "data":_data,
            "beforeSend": showSpinningProgress($('#btn_save'))
        });
    };
    var updateDrInvoice=function(){
        var _data=$('#frm_dr_invoice,#frm_items').serializeArray();
        var tbl_summary=$('#tbl_dr_invoice_summary');
        _data.push({name : "remarks", value : $('textarea[name="remarks"]').val()});

        _data.push({name : "total_after_discount", value: $('#td_total_after_discount').text()});
        _data.push({name : "summary_discount", value : tbl_summary.find(oTableDetails.discount).text()});
        _data.push({name : "summary_before_discount", value :tbl_summary.find(oTableDetails.before_tax).text()});
        _data.push({name : "summary_tax_amount", value : tbl_summary.find(oTableDetails.inv_tax_amount).text()});
        _data.push({name : "summary_after_tax", value : tbl_summary.find(oTableDetails.after_tax).text()});
        _data.push({name : "delivery_receipt_id" ,value : _selectedID});
        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Delivery_receipt/transaction/update",
            "data":_data,
            "beforeSend": showSpinningProgress($('#btn_save'))
        });
    };
    var removeIssuanceRecord=function(){
        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Delivery_receipt/transaction/delete",
            "data":{delivery_receipt_id : _selectedID}
        });
    };
    var showList=function(b){
        if(b){
            $('#div_dr_invoice_list').show();
            $('#div_dr_invoice_fields').hide();
            $('.datepicker.dropdown-menu').hide();
        }else{
            $('#div_dr_invoice_list').hide();
            $('#div_dr_invoice_fields').show();
        }
    };
    var showNotification=function(obj){
        PNotify.removeAll(); //remove all notifications
        new PNotify({
            title:  obj.title,
            text:  obj.msg,
            type:  obj.stat
        });
    };
    $('#cancel_modal').on('click',function(){
        $('#modal_so_list').modal('hide');
    });
    var showSpinningProgress=function(e){
        $(e).find('span').toggleClass('glyphicon glyphicon-refresh spinning');
    };
    var clearFields=function(f){
        $('input,textarea,select,input:not(.date-picker)',f).val('');
        $('#remarks').val('');
        $(f).find('input:first').focus();
    };
    function format ( d ) {
        //return
    };
    function validateNumber(event) {
        var key = window.event ? event.keyCode : event.which;
        if (event.keyCode === 8 || event.keyCode === 46
            || event.keyCode === 37 || event.keyCode === 39) {
            return true;
        }
        else if ( key < 48 || key > 57 ) {
            return false;
        }
        else return true;
    };
    var getFloat=function(f){
        return parseFloat(accounting.unformat(f));
    };
    var newRowItem=function(d){
return '<tr>'+
//DISPLAY
'<td ><input name="inv_qty[]" type="text" class="numeric form-control" value="'+ d.inv_qty+'"></td>'+
'<td >'+ d.unit_name+'</td>'+
'<td >'+d.product_desc+'</td>'+
'<td><input name="inv_price[]" type="text" class="numeric form-control" value="'+accounting.formatNumber(d.inv_price,2)+'" style="text-align:right;"></td>'+
'<td  style=""><input name="inv_discount[]" type="text" class="numeric form-control" value="'+ accounting.formatNumber(d.inv_discount,2)+'" style="text-align:right;"></td>'+
// DISPLAY NONE
'<td style="display:none;"><input name="inv_line_total_discount[]" type="text" class="numeric form-control" value="'+ accounting.formatNumber(d.inv_line_total_discount,2)+'" readonly></td>'+
'<td  style="display:none;"><input name="inv_tax_rate[]" type="text" class="numeric form-control" value="'+ accounting.formatNumber(d.inv_tax_rate,2)+'"></td>'+
// DISPLAY AGAIN 10%
'<td style=""><input name="inv_gross[]" type="text" class="numeric form-control" value="'+ accounting.formatNumber(d.inv_gross,2)+'" readonly></td>'+
'<td  align="right"><input name="inv_line_total_price[]" type="text" class="numeric form-control" value="'+ accounting.formatNumber(d.inv_line_total_price,2)+'" readonly></td>'+
// DISPLAY NONE AGAIN display:none;"
'<td style="display:none;" ><input name="inv_tax_amount[]" type="text" class="numeric form-control" value="'+ d.inv_tax_amount+'" readonly></td>'+
'<td style="display:none;" ><input name="inv_non_tax_amount[]" type="text" class="numeric form-control" value="'+ d.inv_non_tax_amount+'" readonly></td>'+
'<td style="display:none;"><input name="product_id[]" type="text" class="numeric form-control" value="'+ d.product_id+'" readonly></td>'+
'<td style="display:none;" ><input name="inv_line_total_after_global[]" type="text" class="numeric form-control" value="'+ d.inv_line_total_after_global+'" readonly></td>'+
'<td align="center"><button type="button" name="remove_item" class="btn btn-red"><i class="fa fa-trash"></i></button></td>'+
'</tr>';
    };
    var reComputeTotal=function(){
        var rows=$('#tbl_items > tbody tr');
        var discounts=0; var before_tax=0; var after_tax=0; var inv_tax_amount=0;
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
        });


        var tbl_summary=$('#tbl_dr_invoice_summary');
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
    };
    var resetSummary=function(){
        var tbl_summary=$('#tbl_dr_invoice_summary');
        tbl_summary.find(oTableDetails.discount).html('0.00');
        tbl_summary.find(oTableDetails.before_tax).html('0.00');
        tbl_summary.find(oTableDetails.inv_tax_amount).html('0.00');
        tbl_summary.find(oTableDetails.after_tax).html('<b>0.00</b>');
    };
    var reInitializeNumeric=function(){
        $('.numeric').autoNumeric('init');
    };
    setInterval(function(){
    //console.log('test');
      if(!$("body").hasClass("modal-open")) return;
      var modalDialog = $(".modal.in > .modal-dialog");
      var backdrop = $(".modal.in > .modal-backdrop");
      var backdropHeight = backdrop.height();
      var modalDialogHeight = modalDialog.height();
      if(modalDialogHeight > backdropHeight) backdrop.height(modalDialogHeight+100);
    }, 500)
});
</script>
</body>
</html>