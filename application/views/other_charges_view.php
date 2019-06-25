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
        #span_invoice_no{
            min-width: 50px;
        }
        #span_invoice_no:focus{
            border: 3px solid orange;
            background-color: yellow;
        }
        .alert {
            border-width: 0;
            border-style: solid;
            padding: 24px;
            margin-bottom: 32px;
        }
        .alert-danger, .alert-danger h1, .alert-danger h2, .alert-danger h3, .alert-danger h4, .alert-danger h5, .alert-danger h6, .alert-danger small {
            color: #E9EDEF;
        }
        .alert-danger {
            color: #E9EDEF;
            background-color: #f9bdbb;
            border-color: #e84e40;
        }
        .toolbar{
            float: left;
        }
        td.details-control {
            background: url('assets/img/print.png') no-repeat center center;
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
        .form-control[readonly] {
            background-color: #f3f2f2;
            opacity: 1;
        }
        #tbl_other_charges_filter{
                display: none;
        }
    </style>
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
    <li><a href="Other_charges">Other Charges</a></li>
</ol>
<div class="container-fluid">
<div data-widget-group="group1">
<div class="row">
<div class="col-md-12">
<div id="div_other_charges_list">
    <div class="panel panel-default">
        <div class="panel-body table-responsive">
            <div class="row panel-row">
             <h2 class="h2-panel-heading">Other Charges</h2><hr>         
                 <div class="row">
                        <div class="col-lg-3"><br>
                                <button class="btn btn-success create_other_charges" id="btn_new" style="text-transform: none;font-family: Tahoma, Georgia, Serif;"  title="Record Other Charges" ><i class="fa fa-plus"></i> Record Other Charges</button>
                        </div>
                        <div class="col-lg-offset-6 col-lg-3">
                                Search :<br />
                                 <input type="text" id="searchbox_other_charges" class="form-control">
                        </div>
                </div><br>  
                <table id="tbl_other_charges" class="table table-striped"  cellspacing="0" width="100%" style="">
                <thead class="">
                <tr>
                    <th></th>
                    <th>Invoice #</th>
                    <th>Customer Name</th>
                    <th>Account No</th>
                    <th>Invoice Date</th>
                    <th width="20%">Remarks</th>
                    <th><center>Action</center></th>
                    <th></th>
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
<div id="div_other_charges_fields" style="display: none;">
    <div class="panel panel-default" style="">
        <div class="panel-body">
        <div class="row panel-row" >
            <form id="frm_other_charges" role="form" class="form-horizontal">
                <h2 class="h2-panel-heading">Invoice # : <span id="span_invoice_no">INV-XXXX</span></h2>
                <div>
                <hr>
                    <div class="row">
                        <div class="col-sm-4">
                            <label>ACCOUNT NO :</label> <br />
                            <div class="input-group">
                                <input type="text" name="account_no" class="form-control" id="account_no_id" readonly>
                                <input type="hidden" id="connection_id" name="connection_id" class="form-control" >
                                <span class="input-group-addon">
                                    <a href="#" id="link_browse" style="text-decoration: none;color:black;"><b>...</b></a>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <label>Customer Name :</label><br/>
                            <input type="text"  id="customer_name" name="customer_name" class="form-control" readonly>
                        </div>
                        <div class="col-sm-4">
                            <label>Serial No :</label><br/>
                            <input type="text"  id="serial_no_id" name="serial_no" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <b class="required">* </b><label>Invoice Date :</label> <br />
                            <div class="input-group">
                                <input type="text" name="date_invoice" id="invoice_default" class="date-picker form-control" value="<?php echo date("m/d/Y"); ?>" placeholder="Date Invoice" data-error-msg="Please set the date this items are issued!" required>
                                 <span class="input-group-addon">
                                     <i class="fa fa-calendar"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div><hr>
            <label class="control-label" style="font-family: Tahoma;"><strong>Enter PLU or Search Item :</strong></label>
            <div id="custom-templates">
                <input class="typeahead" type="text" placeholder="Enter PLU or Search Item">
            </div><br />
            <form id="frm_items">
                <div class="table-responsive">
                    <table id="tbl_items" class="table table-striped" cellspacing="0" width="100%" style="font-font:tahoma;">
                        <thead class="">    
                        <tr>
                            <th width="10%">Qty</th>
                            <th width="15%">UM</th>
                            <th width="25%">Item</th>
                            <th width="20%" style="text-align: right;">Unit Price</th>
                            <th width="20%" style="text-align: right;">Total</th>
                            <th style="display:none;" width="20%" style="text-align: right;">AFTER GLOBAL</th>
                            <td style="display:none;">Item ID</td>
                            <td style="display:none;">Unit Id</td>
                            <th><center>Action</center></th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2" style="text-align: right;"></td>
                                <td>
                                    <input type="hidden" id="txt_total_overall_discount" class="numeric form-control" name="total_overall_discount" value="0.00">
                                    <input type="hidden" class="numeric form-control " name="total_overall_discount_amount" id="txt_total_overall_discount_amount" readonly>
                                </td>
                                <td colspan="1" style="text-align: right;"><strong><i class="glyph-icon icon-star"></i> Total Amount :</strong></td>
                                <td align="right" colspan="1" id="total_amount" color="red">0.00</td>
                                <td></td>
                            </tr>
                            <tr style="display: none;">
                            <td colspan="4" style="text-align: right;"><strong><i class="glyph-icon icon-star"></i> Total After Discount :</strong></td>
                                <td align="right" colspan="1" id="total_amount_before_discount" color="red">0.00</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </form>
        </div>

        <form id="frm_remarks">
        <div class="row">
            <div class="container-fluid">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><br />
                <div class="row">
                <hr>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <label control-label><strong>Remarks :</strong></label>
                        <div class="col-lg-12" style="padding: 0%;">
                            <textarea name="remarks" id="remarks" class="form-control" placeholder="Remarks"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row" style="display: none;">
                    <div class="col-lg-4 col-lg-offset-8">
                        <div class="table-responsive">
                            <table id="tbl_other_charges_summary" class="table invoice-total" style="font-family: tahoma;">
                                <tbody>
                                <tr>
                                    <td><strong>Total After Tax :</strong></td>
                                    <td align="right"><b>0.00</b></td>
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
        </form>
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

<div id="modal_account_list" class="modal fade" tabindex="-1" role="dialog"><!--modal-->
    <div class="modal-dialog" style="width: 80%;">
        <div class="modal-content">
            <div class="modal-header ">
                <button type="button" class="close"   data-dismiss="modal" aria-hidden="true">X</button>
                <h2 class="modal-title" style="color: white;"><span id="modal_mode"> </span>Accounts</h2>
            </div>
            <div class="modal-body">
                <table id="tbl_account_list" class="table table-striped" cellspacing="0" width="100%">
                    <thead class="">
                    <tr>
                        <th></th>
                        <th>Account No</th>
                        <th>Customer</th>
                        <th>Service No</th>
                        <th>Serial No</th>
                        <th><center>Action</center></th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button class="btn btn-default" style="text-transform: none;font-family: Tahoma, Georgia, Serif;" data-dismiss="modal"> Cancel</button>
            </div>
        </div>
    </div>
<div class="clearfix"></div>
</div><!---modal-->
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
</div><!---modal-->



<footer role="contentinfo">
    <div class="clearfix">
        <ul class="list-unstyled list-inline pull-left">
            <li><h6 style="margin: 0;">&copy; 2017 - JDEV IT BUSINESS SOLUTION</h6></li>
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
<script type="text/javascript" src="assets/plugins/datatables/ellipsis.js"></script>
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

<?php echo $_rights; ?>
<script>
$(document).ready(function(){
    var dt; var _txnMode; var _selectedID; var _selectRowObj; var dtAccounts;
    var yearNow = new Date().getFullYear();
    var monthNow = new Date().getMonth() + 1;
    var oTableItems={
        qty : 'td:eq(0)',
        unit_price : 'td:eq(3)',
        total : 'td:eq(4)',
        line_total_after_global : 'td:eq(5)'

    };
    var oTableDetails={
        total_after_discount : 'tr:eq(0) > td:eq(1)',
        total : 'tr:eq(1) > td:eq(1)'
    };
    var initializeControls=function(){
        dt=$('#tbl_other_charges').DataTable({
            "dom": '<"toolbar">frtip',
            "bLengthChange":false,
            "order": [[ 7, "desc" ]],
            "ajax" : "Other_charges/transaction/list",
            "language": {
                "searchPlaceholder":"Search Invoice"
            },
            "columns": [
                {
                    "targets": [0],
                    "class":          "details-control",
                    "orderable":      false,
                    "data":           null,
                    "defaultContent": ""
                },
                { targets:[1],data: "other_charge_no" },
                { targets:[2],data: "receipt_name" },
                { targets:[3],data: "account_no" },
                { targets:[4],data: "date_invoice" },
                { targets:[5],data: "remarks",render: $.fn.dataTable.render.ellipsis(60)},
                {
                    targets:[6],
                    render: function (data, type, full, meta){
                        return '<center>'+btn_edit_other_charges+"&nbsp;"+btn_trash_other_charges+'</center>';
                    }
                },
                { targets:[7],data: "other_charge_id",visible:false },
            ]
        });
        dtAccounts=$('#tbl_account_list').DataTable({
            "bLengthChange":false,
            "ajax" : "Other_charges/transaction/list-accounts",
            "columns": [
                {   visible:false,
                    "targets": [0],
                    "class":          "details-control",
                    "orderable":      false,
                    "data":           null,
                    "defaultContent": ""
                },
                { targets:[1],data: "account_no" },
                { targets:[2],data: "receipt_name" },
                { targets:[3],data: "service_no" },
                { targets:[4],data: "serial_no" },
                {
                    targets:[6],
                    render: function (data, type, full, meta){
                        var btn_accept='<button class="btn btn-success btn-sm" name="accept_account"  style="margin-left:-15px;text-transform: none;" data-toggle="tooltip" data-placement="top" title="Accept Account No"><i class="fa fa-check"></i> Accept</button>';
                        return '<center>'+btn_accept+'</center>';
                    }
                }
            ]
        });
        $('.numeric').autoNumeric('init');
        $('.number').autoNumeric('init',{mDec:0});
        $('.date-picker').datepicker({
            startDate: new Date(yearNow, (monthNow-1), 1),
            endDate: new Date(yearNow, (monthNow-1)+1,0),
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true
        });

        $('#contact_no').keypress(validateNumber);

        $('#custom-templates .typeahead').keypress(function(event){
            if (event.keyCode == 13) {
                $('.tt-suggestion:first').click();
            }
        });
        // $charges is from controller function index
        var raw_data = <?php echo json_encode($charges); ?>;
        var charges = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('charge_code','charge_desc','charge_amount'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            local : raw_data
        });
        var _objTypeHead=$('#custom-templates .typeahead');
        _objTypeHead.typeahead(null, {
        name: 'charges',
        display: 'charge_code',
        source: charges,  // edit this , this must be the same as the var charges declared in the new BLoodhound
        templates: {
            header: [
                '<table class="tt-head"><tr><td width=20%" style="padding-left: 1%;"><b>PLU</b></td><td width="20%" align="left"><b>Description</b></td><td width="10%" align="left" style="padding-right: 2%;"><b>SRP</b></td></tr></table>'
            ].join('\n'),
            suggestion: Handlebars.compile('<table class="tt-items"><tr><td width="20%" style="padding-left: 1%;">{{charge_code}}</td><td width="20%" align="left">{{charge_desc}}</td><td width="10%" align="left" style="padding-right: 2%;">{{charge_amount}}</td></tr></table>')
        }
        }).on('keyup', this, function (event) {
            if (_objTypeHead.typeahead('val') == '') {
                return false;
            }
            if (event.keyCode == 13) {
                //$('.tt-suggestion:first').click();
                _objTypeHead.typeahead('close');
                _objTypeHead.typeahead('val','');
            }
        }).bind('typeahead:select', function(ev, suggestion) {


            var charge_amount= 0.00;
            charge_amount=suggestion.charge_amount;
            var charge_line_total=getFloat(charge_amount);


            $('#tbl_items > tbody').append(newRowItem({
                inv_qty : "1",
                charge_unit_id : suggestion.charge_unit_id,
                charge_id : suggestion.charge_id,
                charge_desc : suggestion.charge_desc,
                charge_unit_name : suggestion.charge_unit_name,
                charge_amount : charge_amount,
                line_total : charge_line_total
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

        $("#searchbox_other_charges").keyup(function(){         
            dt
                .search(this.value)
                .draw();
        });

        $('#tbl_other_charges tbody').on( 'click', 'tr td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = dt.row( tr );
            var idx = $.inArray( tr.attr('id'), detailRows );                
                var d=row.data();
                window.open("Templates/layout/other-charge-dropdown/"+ d.other_charge_id+"?type=html");
        } );

        $('#btn_cancel').click(function(){
        showList(true);
    });

        $('#btn_new').click(function(){
            _txnMode="new";
            clearFields($('#div_other_charges_fields'));
            $('#span_invoice_no').html('INV-XXXX');
            showList(false);

            $('#tbl_items > tbody').html('');
            $('#img_user').attr('src','assets/img/anonymous-icon.png');
            $('#customer_name').val('');
            $('#account_no').val('');
            $('#connection_id').val('');
            $('#account_no_id').val('');
            $('#serial_no_id').val('');
            $('#total_amount').html('0.00');
            $('#txt_total_overall_discount').val('0.00');
            $('#txt_total_overall_discount_amount').val('0.00');
            $('#invoice_default').datepicker('setDate', 'today');
            $('#due_default').datepicker('setDate', 'today');
            reComputeTotal(); //this is to make sure, display summary are recomputed as 0
        });

        $('#link_browse').click(function(){
            $('#tbl_account_list tbody').html('<tr><td colspan="6"><center><br /><img src="assets/img/loader/ajax-loader-lg.gif" /><br /><br /></center></td></tr>');
            dtAccounts.ajax.reload( null, false );
            $('#modal_account_list').modal('show');
        });

        $('#tbl_other_charges tbody').on('click','button[name="edit_info"]',function(){
            ///alert("ddd");
            _txnMode="edit";
            $('.other_charges_title').html('Edit Other Charges');
            _selectRowObj=$(this).closest('tr');
            var data=dt.row(_selectRowObj).data();
            _selectedID=data.other_charge_id;

            $('#span_invoice_no').html(data.other_charge_no);
            $('input,textarea').each(function(){
                var _elem=$(this);
                $.each(data,function(name,value){
                    if(_elem.attr('name')==name&&_elem.attr('type')!='password'){
                        _elem.val(value);
                    }
                });
            });

            $.ajax({
                url : 'Other_charges/transaction/items-invoice/'+data.other_charge_id,
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
                            inv_qty : value.charge_qty,
                            charge_id : value.charge_id,
                            charge_desc : value.charge_desc,
                            charge_unit_id : value.charge_unit_id,
                            charge_unit_name : value.charge_unit_name,
                            charge_amount : value.charge_amount,
                            line_total : value.charge_line_total


                        }));
                    });
                   $('#txt_total_overall_discount').val(accounting.formatNumber($('#txt_total_overall_discount').val(),2));
                   reInitializeNumeric();
                    reComputeTotal();
                }

            });

            showList(false);
        
        });

        $('#tbl_account_list > tbody').on('click','button[name="accept_account"]',function(){
            _selectRowObjAccount=$(this).closest('tr');
            var data=dtAccounts.row(_selectRowObjAccount).data();
            $('#customer_name').val(data.receipt_name);
            $('#account_no').val(data.customer_name);
            $('#connection_id').val(data.connection_id);
            $('#account_no_id').val(data.account_no);
            $('#serial_no_id').val(data.serial_no);
            $('#modal_account_list').modal('hide');
        });

        $('#tbl_other_charges tbody').on('click','button[name="remove_info"]',function(){
            _selectRowObj=$(this).closest('tr');
            var data=dt.row(_selectRowObj).data();
            _selectedID=data.other_charge_id;
            //alert(_selectedID);
            _is_journal_posted=data.is_journal_posted;
            if(_is_journal_posted > 0){
                    showNotification({title:" Error!",stat:"error",msg:"Cannot Delete: Invoice is already Posted in Sales Journal."});
            } else{
                $('#modal_confirmation').modal('show');
            }
        });
        //track every changes on numeric fields
        $('#tbl_items tbody').on('keyup','input.numeric,input.number',function(){
            var row=$(this).closest('tr');
            var price=parseFloat(accounting.unformat(row.find(oTableItems.unit_price).find('input.numeric').val()));
            var qty=parseFloat(accounting.unformat(row.find(oTableItems.qty).find('input.number').val()));
            var line_total=price*qty;
            $(oTableItems.total,row).find('input.numeric').val(accounting.formatNumber(line_total,2)); // line total amount


            reComputeTotal();
        });
        $('#tbl_items tfoot').on('keyup','input.numeric,input.number',function(){
            reComputeTotal();
        });        

        $('#btn_yes').click(function(){
            removeOtherCharges().done(function(response){
                showNotification(response);
                if(response.stat=="success"){
                    dt.row(_selectRowObj).remove().draw();
                }
            });
            //}
        });

        $('#btn_save').click(function(){
            // var _data=$('#frm_other_charges,#frm_items,#frm_remarks').serializeArray();
            // console.log(_data)
            if(validateRequiredFields($('#frm_other_charges'))){
                if(_txnMode=="new"){
                    createOtherCharges().done(function(response){
                        showNotification(response);
                        dt.row.add(response.row_added[0]).draw();
                        clearFields($('#frm_other_charges'));
                        showList(true);
                    }).always(function(){
                        showSpinningProgress($('#btn_save'));
                    });
                }else{
                    updateOtherCharges().done(function(response){
                        showNotification(response);
                        dt.row(_selectRowObj).data(response.row_updated[0]).draw();
                        clearFields($('#frm_other_charges'));
                        showList(true);
                    }).always(function(){
                        showSpinningProgress($('#btn_save'));
                    });
                }
            }
        });
    
        $('#tbl_items > tbody').on('click','button[name="remove_item"]',function(){
            $(this).closest('tr').remove();
            reComputeTotal();
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

    var createOtherCharges=function(){
        var _data=$('#frm_other_charges,#frm_items,#frm_remarks').serializeArray();
        var tbl_summary=$('#tbl_other_charges_summary');
        _data.push({name : "summary_total_amount", value : tbl_summary.find(oTableDetails.total).text()});
        _data.push({name : "summary_total_amount_after_discount", value : tbl_summary.find(oTableDetails.total_after_discount).text()});
        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Other_charges/transaction/create-invoice", // edit this
            "data":_data,
            "beforeSend": showSpinningProgress($('#btn_save'))
        });
    };
    var updateOtherCharges=function(){
        var _data=$('#frm_other_charges,#frm_items,#frm_remarks ').serializeArray();
        var tbl_summary=$('#tbl_other_charges_summary');
        _data.push({name : "summary_total_amount", value : tbl_summary.find(oTableDetails.total).text()});
        _data.push({name : "summary_total_amount_after_discount", value : tbl_summary.find(oTableDetails.total_after_discount).text()});
        _data.push({name : "other_charge_id" ,value : _selectedID});
        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Other_charges/transaction/update-invoice",
            "data":_data,
            "beforeSend": showSpinningProgress($('#btn_save'))
        });
    };
    var removeOtherCharges=function(){
        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Other_charges/transaction/delete",
            "data":{other_charge_id : _selectedID}
        });
    };
    var showList=function(b){
        if(b){
            $('#div_other_charges_list').show();
            $('#div_other_charges_fields').hide();
            $('.datepicker.dropdown-menu').hide();
        }else{
            $('#div_other_charges_list').hide();
            $('#div_other_charges_fields').show();
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
        '<td width="10%"><input name="charge_qty[]" type="text" class="number form-control" value="'+ d.inv_qty+'"></td>'+
        '<td width="5%">'+ d.charge_unit_name+'</td>'+
        '<td width="10%" name="charge_desc[]">'+d.charge_desc+'</td>'+
        '<td width="11%"><input name="charge_amount[]" type="text" class="numeric form-control" value="'+accounting.formatNumber(d.charge_amount,2)+'" style="text-align:right;"></td>'+
        '<td width="11%" align="right"><input name="charge_line_total[]" type="text" class="numeric form-control" value="'+ accounting.formatNumber(d.line_total,2)+'" readonly></td>'+
        // display:none;
        '<td width="11%" style="display:none;" align="right"><input name="charge_line_total_after_global[]" type="text" class="numeric form-control" value="'+ accounting.formatNumber(d.line_total,2)+'" readonly></td>'+
        '<td style="display:none;"><input name="charge_id[]" type="text" class=" form-control" value="'+ d.charge_id+'" readonly></td>'+
        '<td style="display:none;"><input name="charge_unit_id[]" type="text" class=" form-control" value="'+ d.charge_unit_id+'" readonly></td>'+
        '<td align="center"><button type="button" name="remove_item" class="btn btn-red"><i class="fa fa-trash"></i></button></td>'+
        '</tr>';
    };
    var reComputeTotal=function(){
        var rows=$('#tbl_items > tbody tr');
        var total_amount=0;
        var over_all_discount = parseFloat(accounting.unformat($('#txt_total_overall_discount').val()/100));
        $.each(rows,function(){
        new_total = parseFloat(accounting.unformat($(oTableItems.total,$(this)).find('input.numeric').val()));
        total_amount+=parseFloat(accounting.unformat($(oTableItems.total,$(this)).find('input.numeric').val()));
        $(oTableItems.line_total_after_global,$(this)).find('input.numeric').val(accounting.formatNumber(new_total - (new_total*over_all_discount),2));   
        });


        var discount_percentage = $('#txt_total_overall_discount').val();
        var discount_amount = total_amount*(discount_percentage/100);
        var total_after_discount = total_amount - discount_amount;


        $('#txt_total_overall_discount_amount').val(accounting.formatNumber(discount_amount,2)); // amount of discount
        $('#total_amount').html('<b>'+accounting.formatNumber(total_amount,2)+'</b>'); //amount after discount
        $('#total_amount_before_discount').html('<b>'+accounting.formatNumber(total_after_discount,2)+'</b>'); 


        var tbl_summary=$('#tbl_other_charges_summary');
        tbl_summary.find(oTableDetails.total).html('<b>'+accounting.formatNumber(total_amount,2)+'</b>');
        tbl_summary.find(oTableDetails.total_after_discount).html('<b>'+accounting.formatNumber(total_after_discount,2)+'</b>');
    };
    var resetSummary=function(){
        var tbl_summary=$('#tbl_other_charges_summary');
        tbl_summary.find(oTableDetails.total).html('<b>0.00</b>');
    };
    var reInitializeNumeric=function(){
        $('.numeric').autoNumeric('init');
        $('.number').autoNumeric('init',{mDec:0});
    };

});
</script>
</body>
</html>