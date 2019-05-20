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
        <link href="assets/plugins/select2/select2.min.css" rel="stylesheet">
        <link type="text/css" href="assets/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">
        <link type="text/css" href="assets/plugins/datatables/dataTables.themify.css" rel="stylesheet">
        <link rel="stylesheet" href="assets/plugins/datapicker/datepicker3.css">

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

            @keyframes spin {
                from { transform: scale(1) rotate(0deg); }
                to { transform: scale(1) rotate(360deg); }
            }

            @-webkit-keyframes spin2 {
                from { -webkit-transform: rotate(0deg); }
                to { -webkit-transform: rotate(360deg); }
            }

            .select2-close-mask{
                z-index: 999999;
            }
            .select2-dropdown{
                z-index: 999999;
            }
            .bottom-10{
                padding-bottom: 10px!important;
            }
            .right{
                text-align: right;
            }

            #tbl_connection_filter, #tbl_meter_list_filter{
                display: none;
            }

            .modal-customer {
              width: 95%;

            }
            .red{
                color: red;
            }
        </style>

    </head>

    <body class="animated-content">

    <?php echo $_top_navigation; ?>

        <div id="wrapper">
            <div id="layout-static">

            <?php echo $_side_bar_navigation;?>

                <div class="static-content-wrapper white-bg">
                    <div class="static-content"  >
                        <div class="page-content"><!-- #page-content -->

                            <ol class="breadcrumb" style="margin:0;">
                                <li><a href="dashboard">Dashboard</a></li>
                                <li><a href="ServiceConnection">Connection Service</a></li>
                            </ol>

                            <div class="container-fluid">
                                <div data-widget-group="group1">
                                    <div class="row">
                                        <div class="col-md-12">

                                            <div id="div_category_list">
                                                <div class="panel panel-default">
                                                    <!-- <div class="panel-heading">
                                                        <b style="color: white; font-size: 12pt;"><i class="fa fa-bars"></i>&nbsp; Sales Person</b>
                                                    </div> -->
                                                    <div class="panel-body table-responsive">
                                                    <h2 class="h2-panel-heading">Connection Service</h2><hr>

                                                         <div class="row">
                                                            <div class="col-lg-3"><br>
                                                                    <button class="btn btn-primary" id="btn_new" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;margin-bottom: 0px !important; float: left;" data-toggle="modal" data-target="" data-placement="left" title="New Meter" ><i class="fa fa-plus"></i>  New Connection</button>
                                                            </div>
                                                            <div class="col-lg-offset-3 col-lg-3" style="text-align: right;">
                                                            &nbsp;<br>
                                                                    <button class="btn btn-primary" id="btn_print" style="text-transform: none; font-family: Tahoma, Georgia, Serif;padding: 6px 10px!important;" data-toggle="modal" data-placement="left" title="Print Connection Masterfile" ><i class="fa fa-print"></i> Print</button> &nbsp;
                                                                    <button class="btn btn-success" id="btn_export" style="text-transform: none; font-family: Tahoma, Georgia, Serif;padding: 6px 10px!important;" data-toggle="modal" data-placement="left" title="Export Connection Masterfile" ><i class="fa fa-file-excel-o"></i> Export</button>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                    Search :<br />
                                                                     <input type="text" id="searchbox_connection" class="form-control">
                                                            </div>
                                                        </div><br>

                                                        <table id="tbl_connection" class="table table-striped" cellspacing="0" width="100%">
                                                            <thead class="">
                                                            <tr>
                                                                <th>Service No</th>
                                                                <th>Account No</th>
                                                                <th>Customer</th>
                                                                <th>Meter Serial</th>
                                                                <th>Connection Date</th>
                                                                <th><center>Action</center></th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <!-- <div class="panel-footer"></div> -->
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
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                                <h4 class="modal-title" style="color:white;"><span id="modal_mode"> </span>Confirm Deletion</h4>
                            </div>

                            <div class="modal-body">
                                <p id="modal-body-message">Are you sure ?</p>
                            </div>

                            <div class="modal-footer">
                                <button id="btn_yes" type="button" class="btn btn-danger" data-dismiss="modal">Yes</button>
                                <button id="btn_close" type="button" class="btn btn-default" data-dismiss="modal">No</button>
                            </div>
                        </div>
                    </div>
                </div><!---modal-->

                <div id="modal_new_connection" class="modal fade" role="dialog">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header" style="background-color:#2ecc71;">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                                <h4 id="connection_title" class="modal-title" style="color: #ecf0f1;"><span id="modal_mode"></span></h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <form id="frm_connection" role="form">
                                        <div class="">

                                            <div class="col-lg-12">
                                                <div class="col-md-6">
                                                    <div class="row bottom-10">
                                                        <div class="form-group">
                                                            <label class="col-xs-12 col-md-3 control-label"><strong>Service No:</strong></label>
                                                            <div class="col-xs-12 col-md-9">
                                                                <div class="input-group">
                                                                    <input type="text" name="service_no" class="form-control" placeholder="SCN-YYYYMMDD-XXXX" readonly>
                                                                    <span class="input-group-addon">
                                                                        <i class="fa fa-code"></i>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row bottom-10">
                                                        <div class="form-group">
                                                            <label class="col-xs-12 col-md-3 control-label"><strong><span class="red">*</span> Customer:</strong></label>
                                                            <div class="col-xs-12 col-md-9">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control" placeholder="Customer" id="customer_name" name="customer_name" readonly>
                                                                    <input type="hidden" name="customer_id" value="0" required data-error-msg="Customer is required.">
                                                                    <input type="hidden" name="meter_inventory_id" value="0">
                                                                    <span class="input-group-addon">
                                                                        <a href="#" id="link_browse_cu"><b>...</b></a>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row bottom-10">
                                                        <div class="form-group">
                                                            <label class="col-xs-12 col-md-3 control-label"><strong>Account No:</strong></label>
                                                            <div class="col-xs-12 col-md-9">
                                                                <div class="input-group">
                                                                    <input type="text" name="account_no" class="form-control" placeholder="ACN-YYYYMMDD-XXXX" readonly>
                                                                    <span class="input-group-addon">
                                                                        <i class="fa fa-code"></i>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="row bottom-10">
                                                        <div class="form-group">
                                                            <label class="col-xs-12 col-md-4 control-label"><strong><span class="red">*</span> Date:</strong></label>
                                                            <div class="col-xs-12 col-md-8">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <i class="fa fa-calendar"></i>
                                                                    </span>
                                                                    <input type="text" name="service_date" id="service_date" class="date-picker form-control" placeholder="MM/DD/YYYY" data-error-msg="Service Date is required." required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row bottom-10">
                                                        <div class="form-group">
                                                            <label class="col-xs-12 col-md-4 control-label"><strong><span class="red">*</span> Connection Date:</strong></label>
                                                            <div class="col-xs-12 col-md-8">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <i class="fa fa-calendar"></i>
                                                                    </span>
                                                                    <input type="text" name="connection_date" id="connection_date" class="date-picker form-control" placeholder="MM/DD/YYYY" data-error-msg="Date Connection is required." required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row bottom-10">
                                                        <div class="form-group">
                                                            <label class="col-xs-12 col-md-4 control-label"><strong>Meter Serial:</strong></label>
                                                            <div class="col-xs-12 col-md-8">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <i class="fa fa-code"></i>
                                                                    </span>
                                                                    <input type="text" id="serial_no" name="serial_no" class="form-control" placeholder="Serial No" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <hr><br>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="col-md-6">
                                                    <div class="row bottom-10">
                                                        <div class="form-group">
                                                            <label class="col-xs-12 col-md-12 control-label">
                                                                <strong><span class="red">*</span> Name to appear on receipt:</strong>
                                                            </label>
                                                            <div class="col-xs-12 col-md-12">
                                                                <div class="input-group">
                                                                    <textarea class="form-control" name="receipt_name" id="receipt_name" placeholder="Receipt Name" data-error-msg="Name on receipt is required." required></textarea>
                                                                    <span class="input-group-addon">
                                                                        <i class="fa fa-code"></i>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row bottom-10">
                                                        <div class="form-group">
                                                            <label class="col-xs-12 col-md-4 control-label">
                                                                <strong>Contract Type:</strong>
                                                            </label>
                                                            <div class="col-xs-12 col-md-8">
                                                                <select name="contract_type_id" id="cbo_contract_type" class="form-control" data-error-msg="Contract Type is required!" style="width: 100%;" required>
                                                                    <?php foreach($contract_types as $contract_type) { ?>
                                                                        <option value="<?php echo $contract_type->contract_type_id; ?>"><?php echo $contract_type->contract_type_name; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row bottom-10">
                                                        <div class="form-group">
                                                            <label class="col-xs-12 col-md-4 control-label"><strong><span class="red">*</span> Initial Reading:</strong></label>
                                                            <div class="col-xs-12 col-md-8">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <i class="fa fa-code"></i>
                                                                    </span>
                                                                    <input type="text" name="initial_meter_reading" class="form-control" placeholder="Meter Reading" data-error-msg="Initial Meter Reading is required." required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="row bottom-10">
                                                        <div class="form-group">
                                                            <label class="col-xs-12 col-md-4 control-label"><strong>Target Date:</strong></label>
                                                            <div class="col-xs-12 col-md-8">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <i class="fa fa-calendar"></i>
                                                                    </span>
                                                                    <input type="text" name="target_date" class="date-picker form-control" placeholder="MM/DD/YYYY">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row bottom-10">
                                                        <div class="form-group">
                                                            <label class="col-xs-12 col-md-4 control-label"><strong>Target Time:</strong></label>
                                                            
                                                            <div class="col-xs-12 col-md-8">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <i class="fa fa-clock-o"></i>
                                                                    </span>
                                                                    <input type="text" name="target_time" class="time-picker form-control" placeholder="HH:MM">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row bottom-10">
                                                        <div class="form-group">
                                                            <label class="col-xs-12 col-md-4 control-label">
                                                                <strong>Rate Type:</strong>
                                                            </label>
                                                            <div class="col-xs-12 col-md-8">
                                                                <select name="rate_type_id" id="cbo_rate_type" class="form-control" data-error-msg="Rate Type is required!" style="width: 100%;" required>
                                                                    <?php foreach($rate_types as $rate_type) { ?>
                                                                        <option value="<?php echo $rate_type->rate_type_id; ?>"><?php echo $rate_type->rate_type_name; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row bottom-10">
                                                        <div class="form-group">
                                                            <label class="col-xs-12 col-md-4 control-label"><strong>Attended by:</strong></label>
                                                            <div class="col-xs-12 col-md-8">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <i class="fa fa-user"></i>
                                                                    </span>
                                                                    <input type="text" name="attended_by" class="form-control" placeholder="Attended By">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button id="btn_save" class="btn btn-primary" name="btn_save"><span></span>Save</button>
                                <button id="btn_cancel" class="btn btn-default">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>

            <div id="modal_meter_list" class="modal fade" role="dialog"><!--modal-->
                <div class="modal-dialog" style="width: 80%;">
                    <div class="modal-content"><!---content--->
                        <div class="modal-header ">
                            <h4 class="modal-title" style="color: white;"><span id="modal_mode"> </span>Meter Inventory</h4>
                        </div>
                        <div class="modal-body">

                            <div class="row">
                                <div class="col-lg-3">
                                Customer : 
                                <select class="form-control" id="cbo_customer" style="width: 100%;">
                                    <option value="">All</option>
                                    <?php foreach($customers as $customer){?>
                                        <option value="<?php echo $customer->customer_id; ?>">
                                            <?php echo $customer->customer_name; ?>
                                        </option>
                                    <?php }?>
                                </select>

                                </div>
                                <div class="col-lg-offset-6 col-lg-3">
                                        Search :<br />
                                         <input type="text" id="searchbox_meter" class="form-control">
                                </div>
                            </div><br>
                            <table id="tbl_meter_list" class="table table-striped" cellspacing="0" width="100%">
                                <thead class="">
                                <tr>
                                    <th>Customer</th>
                                    <th>Meter Code</th>
                                    <th>Serial No</th>
                                    <th><center>Action</center></th>
                                </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="btn_cancel_customer" class="btn btn-default" data-dismiss="modal" style="text-transform: none;font-family: Tahoma, Georgia, Serif;">Cancel</button>
                        </div>
                    </div><!---content---->
                </div>
            </div><!---modal-->


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


    <?php echo $_switcher_settings; ?>
    <?php echo $_def_js_files; ?>

    <!-- Date range use moment.js same as full calendar plugin -->
    <script src="assets/plugins/fullcalendar/moment.min.js"></script>
    <!-- Data picker -->
    <script src="assets/plugins/datapicker/bootstrap-datepicker.js"></script>

    <script src="assets/plugins/spinner/dist/spin.min.js"></script>
    <script src="assets/plugins/spinner/dist/ladda.min.js"></script>

    <script src="assets/plugins/select2/select2.full.min.js"></script>
    <script type="text/javascript" src="assets/plugins/datatables/jquery.dataTables.js"></script>
    <script type="text/javascript" src="assets/plugins/datatables/dataTables.bootstrap.js"></script>

    <script>

    $(document).ready(function(){
        var dt; var _txnMode; var _selectedID; var _selectRowObj; var _selectRowObjMeter;
        var _cboCustomer; var _cboContractType; var _cboRateType;

        var initializeControls=function(){
            _cboCustomer=$("#cbo_customer").select2({
                allowClear: false
            });

            _cboContractType=$("#cbo_contract_type").select2({
                minimumResultsForSearch: -1,
                allowClear: false
            });

            _cboRateType=$("#cbo_rate_type").select2({
                minimumResultsForSearch: -1,
                allowClear: false
            });            

            dt=$('#tbl_connection').DataTable({
                "fnInitComplete": function (oSettings, json) {
                },
                "dom": '<"toolbar">frtip',
                "bLengthChange":false,
                "pageLength": 15,
                "ajax" : "ServiceConnection/transaction/list",
                "columns": [
                    { targets:[0],data: "service_no" },
                    { targets:[1],data: "account_no" },
                    { targets:[2],data: "customer_name" },
                    { targets:[3],data: "serial_no" },
                    { targets:[4],data: "connection_date" },
                    {
                        targets:[5],
                        render: function (data, type, full, meta){
                            var btn_edit='<button class="btn btn-primary btn-sm" name="edit_info"  style="margin-left:-15px;" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil"></i> </button>';
                            var btn_trash='<button class="btn btn-red btn-sm" name="remove_info" style="margin-right:0px;" data-toggle="tooltip" data-placement="top" title="Move to trash"><i class="fa fa-trash-o"></i> </button>';

                            return '<center>'+btn_edit+'&nbsp;'+btn_trash+'</center>';
                        }
                    }
                ]
            });

            dt_meter=$('#tbl_meter_list').DataTable({
                "bLengthChange":false,
                oLanguage: {
                        sProcessing: '<center><br /><img src="assets/img/loader/ajax-loader-sm.gif" /><br /><br /></center>'
                },
                processing : true,
                "ajax" : {
                    "url" : "MeterInventory/transaction/open",
                    "bDestroy": true,            
                    "data": function ( d ) {
                            return $.extend( {}, d, {
                                "customer_id": $('#cbo_customer').select2('val')
                            });
                        }
                }, 
                "columns": [
                    { targets:[0],data: "customer_name" },
                    { targets:[1],data: "meter_code" },
                    { targets:[2],data: "serial_no" },
                    {
                        targets:[3],
                        render: function (data, type, full, meta){
                            var btn_accept='<button class="btn btn-success btn-sm" name="accept_customer"  style="margin-left:-15px;text-transform: none;" data-toggle="tooltip" data-placement="top" title="Accept"><i class="fa fa-check"></i> Accept</button>';
                            return '<center>'+btn_accept+'</center>';
                        }
                    }

                ]
            });

            $('.date-picker').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true
            });

        }();

        var bindEventHandlers=(function(){
            var detailRows = [];

            var getCurrentDate = function(){
                var d = new Date();
                var strDate =  (d.getMonth()+1) + "/" + d.getDate() + "/" + d.getFullYear();
                return strDate;
            };

            $('#link_browse_cu').click(function(){
                $('#tbl_meter_list tbody').html('<tr><td colspan="4"><center><br/><img src="assets/img/loader/ajax-loader-lg.gif" /><br /><br /></center></td></tr>');
                dt_meter.ajax.reload( null, false );

                $('#modal_new_connection').modal('hide');
                $('#modal_meter_list').modal('show');
            });

            _cboCustomer.on('change',function(){
                $('#tbl_meter_list tbody').html('<tr><td colspan="4"><center><br/><br /><br /></center></td></tr>');
                dt_meter.ajax.reload( null, false );
            });

            $('#tbl_meter_list > tbody').on('click','button[name="accept_customer"]',function(){
                _selectRowObjMeter=$(this).closest('tr');
                var data=dt_meter.row(_selectRowObjMeter).data();

                $('#customer_name').val(data.customer_name);
                $('#receipt_name').val(data.customer_name);
                $('#serial_no').val(data.serial_no);
                $('input[name="customer_id"]').val(data.customer_id);
                $('input[name="meter_inventory_id"]').val(data.meter_inventory_id);

                $('#modal_meter_list').modal('hide');
                $('#modal_new_connection').modal('show');

            }); 

             $('#btn_browse').click(function(event){
                    event.preventDefault();
                    $('input[name="file_upload[]"]').click();
             });

            $('#btn_remove_photo').click(function(event){
                event.preventDefault();
                $('img[name="img_user"]').attr('src','assets/img/anonymous-icon.png');
            });

            $('input[name="file_upload[]"]').change(function(event){
                    var _files=event.target.files;
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

            $('#btn_cancel_customer').on('click', function(){

                $('#modal_meter_list').modal('hide');
                $('#modal_new_connection').modal('show');
            });

            $('#tbl_connection tbody').on( 'click', 'tr td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = dt.row( tr );
                var idx = $.inArray( tr.attr('id'), detailRows );

                if ( row.child.isShown() ) {
                    tr.removeClass( 'details' );
                    row.child.hide();

                    detailRows.splice( idx, 1 );
                }
                else {
                    tr.addClass( 'details' );

                    row.child( format( row.data() ) ).show();

                    if ( idx === -1 ) {
                        detailRows.push( tr.attr('id') );
                    }
                }
            } );

            $("#searchbox_connection").keyup(function(){         
                dt
                    .search(this.value)
                    .draw();
            });

            $("#searchbox_meter").keyup(function(){         
                dt_meter
                    .search(this.value)
                    .draw();
            });           

            $('#btn_print').click(function(){
               window.open('MeterInventory/transaction/print-masterfile');
            });  

            $('#btn_export').click(function(){
               window.open('MeterInventory/transaction/export-masterfile');
            }); 

            $('#btn_new').click(function(){
                _txnMode="new";
                clearFields($('#frm_connection'));
                $('#connection_title').text('New Connection Service');
                $('#service_date').val(getCurrentDate());
                $('#connection_date').val(getCurrentDate());
                $('#modal_new_connection').modal('show');
            });

            $('#tbl_connection tbody').on('click','button[name="edit_info"]',function(){
                _txnMode="edit";
                _selectRowObj=$(this).closest('tr');
                var data=dt.row(_selectRowObj).data();
                _selectedID=data.connection_id;
                
                $('input,textarea').each(function(){
                    var _elem=$(this);
                    $.each(data,function(name,value){
                        if(_elem.attr('name')==name){
                            _elem.val(value);
                        }
                    });
                });

                $('#connection_title').text('Edit Connection Service');
                $('#modal_new_connection').modal('show');
            });

            $('#tbl_connection tbody').on('click','button[name="remove_info"]',function(){
                _selectRowObj=$(this).closest('tr');
                var data=dt.row(_selectRowObj).data();
                _selectedID=data.connection_id;
                $('#modal_confirmation').modal('show');
            });

            $('#btn_yes').click(function(){
                removeConnection().done(function(response){
                    showNotification(response);
                    dt.row(_selectRowObj).remove().draw();
                });
            });

            $('#btn_cancel').click(function(){
                $('#modal_new_connection').modal('hide');
            });

            $('#btn_save').click(function(){
                if(validateRequiredFields($('#frm_connection'))){
                    if(_txnMode=="new"){
                        createConnection().done(function(response){
                            showNotification(response);
                            dt.row.add(response.row_added[0]).draw();
                            clearFields($('#frm_connection'));

                        }).always(function(){
                            showSpinningProgress($('#btn_save'));
                        });
                    }else{
                        updateConnection().done(function(response){
                            showNotification(response);
                            dt.row(_selectRowObj).data(response.row_updated[0]).draw();
                            clearFields($('#frm_connection'));
                        }).always(function(){
                            showSpinningProgress($('#btn_save'));
                        });
                    }
                    $('#modal_new_connection').modal('hide');
                }
            });
        })();

    var validateRequiredFields=function(f){
        var stat=true;

        $('div.form-group').removeClass('has-error');
        $('input[required],textarea[required],select[required]',f).each(function(){

                if($(this).is('select')){
                    if($(this).val()==null || $(this).val()==""){
                        showNotification({title:"Error!",stat:"error",msg:$(this).data('error-msg')});
                        $(this).closest('div.form-group').addClass('has-error');
                        $(this).focus();
                        stat=false;
                        return false;
                    }
                }else{
                if($(this).val()=="" || $(this).val()== '0'){
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


        var createCustomer=function(){
            var _dataCustomer=$('#frm_customer').serializeArray();

            return $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"Customers/transaction/create",
                "data":_dataCustomer
            });
        }

        var createConnection=function(){
            var _data=$('#frm_connection').serializeArray();

            return $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"ServiceConnection/transaction/create",
                "data":_data,
                "beforeSend": showSpinningProgress($('#btn_save'))
            });
        };

        var updateConnection=function(){
            var _data=$('#frm_connection').serializeArray();
            _data.push({name : "connection_id" ,value : _selectedID});

            return $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"ServiceConnection/transaction/update",
                "data":_data,
                "beforeSend": showSpinningProgress($('#btn_save'))
            });
        };

        var removeConnection=function(){
            return $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"ServiceConnection/transaction/delete",
                "data":{connection_id : _selectedID}
            });
        };

        var showList=function(b){
            if(b){
                $('#div_category_list').show();
                $('#div_category_fields').hide();
            }else{
                $('#div_category_list').hide();
                $('#div_category_fields').show();
            }
        };

        var showNotification=function(obj){
            PNotify.removeAll();
            new PNotify({
                title:  obj.title,
                text:  obj.msg,
                type:  obj.stat
            });
        };

        var showSpinningProgress=function(e){
            $(e).find('span').toggleClass('glyphicon glyphicon-refresh spinning');
            $(e).toggleClass('disabled');
        };

        var clearFields=function(frm){
            $('input[required],input,textarea',frm).val('');
            $('form').find('input:first').focus();
        };

        function format ( d ) {
            return '<br /><table style="margin-left:10%;width: 80%;">' +
            '<thead>' +
            '</thead>' +
            '<tbody>' +
            '<tr>' +
            '<td>Category Name : </td><td><b>'+ d.category_name+'</b></td>' +
            '</tr>' +
            '<tr>' +
            '<td>Category Description : </td><td>'+ d.category_desc+'</td>' +
            '</tr>' +
            '</tbody></table><br />';
        };
    });

    </script>

    </body>

</html>