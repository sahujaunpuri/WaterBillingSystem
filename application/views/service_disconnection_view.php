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

        @keyframes spin {
            from { transform: scale(1) rotate(0deg); }
            to { transform: scale(1) rotate(360deg); }
        }

        @-webkit-keyframes spin2 {
            from { -webkit-transform: rotate(0deg); }
            to { -webkit-transform: rotate(360deg); }
        }

        #tbl_disconnection_filter, #tbl_account_list_filter{
                display: none;
        }

        #tbl_items .form-control[readonly], #tbl_other_items .form-control[readonly]{
            background-color: transparent;
            border: 0;
        }
        .number, .numeric{
            text-align: right;
        }
    </style>

</head>

<body class="animated-content">

<?php echo $_top_navigation; ?>

<div id="wrapper">
    <div id="layout-static">

        <?php echo $_side_bar_navigation;?>

        <div class="static-content-wrapper white-bg custom-background">
            <div class="static-content"  >
                <div class="page-content"><!-- #page-content -->
                    <ol class="breadcrumb transparent-background" style="margin: 0;">
                        <li><a href="dashboard">Dashboard</a></li>
                        <li><a href="Service_disconnection">Disconnection Service</a></li>
                    </ol>
                    <div class="container-fluid">
                        <div data-widget-group="group1">
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="div_service_list">
                                        <div class="panel panel-default">
                                            <div class="panel-body table-responsive">
                                            <h2 class="h2-panel-heading">Disconnection Service</h2><hr>
                                                <div class="row">
                                                    <div class="col-lg-3"><br>
                                                            <button class="btn btn-primary"  id="btn_new" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;" data-toggle="modal" data-target="" data-placement="left" title="New Disconnection" ><i class="fa fa-plus"></i> New Disconnection</button>
                                                    </div>
                                                    <div class="col-lg-offset-3 col-lg-3" style="text-align: right;">
                                                    &nbsp;<br>
                                                            <button class="btn btn-primary" id="btn_print" style="text-transform: none; font-family: Tahoma, Georgia, Serif;padding: 6px 10px!important;" data-toggle="modal" data-placement="left" title="Print Disconnection Masterfile" ><i class="fa fa-print"></i> Print</button> &nbsp;
                                                            <button class="btn btn-success" id="btn_export" style="text-transform: none; font-family: Tahoma, Georgia, Serif;padding: 6px 10px!important;" data-toggle="modal" data-placement="left" title="Export Disconnection Masterfile" ><i class="fa fa-file-excel-o"></i> Export</button>
                                                    </div>
                                                    <div class="col-lg-3">
                                                            Search :<br />
                                                             <input type="text" id="searchbox_disconnection" class="form-control">
                                                    </div>
                                                </div><br>
                                                <table id="tbl_disconnection" class="table table-striped" cellspacing="0" width="100%">
                                                    <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>Service No</th>
                                                        <th>Contract No</th>
                                                        <th>Account No</th>
                                                        <th>Customer</th>
                                                        <th>Date</th>
                                                        <th><center>Action</center></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- .container-fluid -->
                </div> <!-- #page-content -->
            </div>

            <div id="modal_account_list" class="modal fade" role="dialog"><!--modal-->
                <div class="modal-dialog " style="width: 80%;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="modal-title" style="color: white;"><span id="modal_mode"></span>Account List</h2>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-3">
                                    Customer : 
                                    <select class="form-control" name="customer_id" id="cbo_customer" style="width: 100%;">
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
                                    <input type="text" id="searchbox_accounts" class="form-control">
                                </div>
                            </div><br>
                            <table id="tbl_account_list" class="table table-striped" cellspacing="0" width="100%">
                                <thead class="">
                                    <tr>
                                        <th>Account No</th>
                                        <th>Customer</th>
                                        <th>Service No</th>
                                        <th>Serial No</th>
                                        <th><center>Action</center></th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button id="btn_cancel_account" class="btn btn-default" data-dismiss="modal" style="text-transform: none;font-family: Tahoma, Georgia, Serif;">Cancel</button>
                        </div>
                    </div><!---content---->
                </div>
            <div class="clearfix"></div>
            </div><!---modal-->
            <div id="modal_confirmation" class="modal fade" tabindex="-1" role="dialog"><!--modal-->
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close"   data-dismiss="modal" aria-hidden="true">X</button>
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
            <div id="modal_new_disconnection" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog " style="width: 95%;">
                    <div class="modal-content">
                        <div class="modal-header" style="background: #2ecc71">
                             <button type="button" class="close"   data-dismiss="modal" aria-hidden="true">X</button>
                             <h2 id="modal_title" class="modal-title" style="color:white;"></h2>
                        </div>
                        <div class="modal-body">
                            <form id="frm_disconnection" role="form" class="form-horizontal">
                            <div class="row">
                            <div class="col-lg-6">
                                <div class="row" style="margin: 1%;">
                                    <div class="col-lg-6">
                                        <div class="form-group" style="margin-bottom:0px;">
                                            <label class="">Service Disconnection No (Auto):</label>
                                            <input type="text" class="form-control" name="disconnection_code" placeholder="SDN-YYYYMMDD-XXXX"  readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-lg-offset-2">
                                        <div class="form-group" style="margin-bottom:0px;">
                                            <label class=""><B class="required"> * </B>  Date :</label>
                                            <input type="text" name="service_date" class="date-picker form-control" placeholder="Date" data-error-msg="Date is required!" required value="<?php echo date("m/d/Y"); ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="margin: 1%;">
                                    <div class="col-lg-7" style="padding-left:0px;padding-right: 0px;"> 
                                        <label><B class="required"> * </B> Service No:</label> <br />
                                        <div class="input-group">
                                            <input type="text" name="service_no" class="form-control" readonly placeholder="Service No" required data-error-msg="Service No is required!">
                                            <input type="hidden" name="connection_id" class="form-control" readonly placeholder="Connection ID" value="0">
                                            <input type="hidden" name="previous_id" class="form-control" readonly placeholder="prev_id" value="0">
                                            <span class="input-group-addon">
                                                <a href="#" id="link_browse_co" style="text-decoration: none;color:black;"><b>...</b></a>
                                                <i class="fa fa-code" id="sn_icon"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-offset-1 col-lg-4">
                                        <div class="form-group" style="margin-bottom:0px;">
                                            <label class=""><B class="required"> * </B>Target Disconnection Date:</label>
                                            <input type="text" name="date_disconnection_date" class="date-picker form-control" placeholder="Target Disconnection Date" data-error-msg="Target Disconnection Date is required!" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="margin: 1%;">
                                    <div class="col-lg-12">
                                        <div class="form-group" style="margin-bottom:0px;">
                                            <label class="">Customer Name:</label>
                                            <input type="text" name="customer_name" class="form-control" placeholder="Customer Name" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="row" style="margin: 1%;">
                                    <div class="col-lg-12">
                                        <div class="form-group" style="margin-bottom:0px;">
                                            <label class="">Address:</label>
                                            <textarea name="address" id="address" class="form-control" placeholder="Address" readonly style="border: 1px solid gray;"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row" style="margin: 1%;">
                                    <div class="col-lg-7" style="padding-left:0px;padding-right: 0px;">
                                        <label class=""><B class="required"> * </B> Reason for Disconnection:</label>
                                        <select name="disconnection_reason_id" id="cbo_disconnection_reason_id" style="width: 100%;padding-left:0px;padding-right: 0px; "  data-error-msg="Reason for Disconnection is required!" required>
                                            <?php foreach($reason as $row){?>
                                                <option value="<?php echo $row->disconnection_reason_id;?>">
                                                    <?php echo $row->reason_desc; ?>
                                                </option>
                                            <?php }?>
                                        </select>
                                    </div>
                                    <div class="col-lg-offset-1 col-lg-4">
                                        <div class="form-group" style="margin-bottom:0px;">
                                            <label class=""><B class="required"> * </B> Last Meter Reading:</label>
                                            <!-- <input type="text" name="last_meter_reading" class="number form-control" placeholder="Last Meter Reading" data-error-msg="Last Meter Reading is required!" required style="text-align: right;"> -->
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="margin: 1%;">
                                    <div class="col-lg-12">
                                        <div class="form-group" style="margin-bottom:0px;">
                                                <label class="">Notes :</label>
                                                <textarea name="disconnection_notes" class="form-control" placeholder="Please explain further"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <h4>Meter Charges</h4>
                                        <table id="tbl_items" class="table table-striped" cellspacing="0" width="100%" style="font-font:tahoma;">
                                            <thead class="">    
                                            <tr>
                                                <th>Previous Month</th>
                                                <th style="text-align: right;">Previous</th>
                                                <th style="text-align: right;">Current</th>
                                                <th style="text-align: right;">Consumption</th>
                                                <th style="text-align: right;">Total</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td class=""><input type="text" class="form-control" name="previous_month" readonly> </td>
                                                <td class=""><input type="text" class="form-control number" name="previous_reading" readonly></td>
                                                <td class=""><input type="text" class="form-control number" name="last_meter_reading"></td>
                                                <td class=""><input type="text" class="form-control number" name="total_consumption" readonly=""></td>
                                                <td class=""><input type="text" class="form-control numeric" name="meter_amount_due" readonly=""></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <input type="hidden" name="default_matrix_id" class="form-control"> 
                                        <input type="hidden" name="rate_amount" class="form-control"> 
                                        <input type="hidden" name="is_fixed" class="form-control"> 
                                </div>
                                <div class="row">
                                    <h4>Other Charges</h4>
                                        <table id="tbl_other_items" class="table table-striped" cellspacing="0" width="100%" style="font-font:tahoma;">
                                            <thead class="">    
                                            <tr>
                                                <th class="hidden">OC ID</th>
                                                <th class="hidden">OCI ID</th>
                                                <th class="hidden">CH ID</th>
                                                <th class="hidden">QTY</th>
                                                <th width="25%">Charge No</th>
                                                <th width="50%">Description</th>
                                                <th class="hidden">UM</th>
                                                <th class="hidden" style="text-align: right;">Cost</th>
                                                <th style="text-align: right;">Total</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                </div>
                                
                                <div class="row">
                                <h4>Arrears</h4>
                                    <div class="col-lg-4">
                                        <div class="form-group" style="margin-bottom:0px;">
                                            <label class="">Arrears as of Date:</label>
                                            <input type="text" name="arrears_amount" class="form-control numeric" placeholder="" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-lg-offset-4">
                                        <div class="form-group" style="margin-bottom:0px;">
                                            <label class="">Arrears Penalty:</label>
                                            <input type="text" name="arrears_penalty_amount" class="form-control numeric" placeholder="" readonly>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button id="btn_save" class="btn btn-primary"><span class=""></span> Save</button>
                            <button id="btn_cancel" class="btn btn-default">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>

            <footer role="contentinfo">
                <div class="clearfix">
                    <ul class="list-unstyled list-inline pull-left">
                        <li><h6 style="margin: 0;">&copy; 2018 - JDEV OFFICE SOLUTION INC</h6></li>
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
<script src="assets/plugins/datapicker/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/jquery.dataTables.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/dataTables.bootstrap.js"></script>
<script src="assets/plugins/select2/select2.full.min.js"></script>
<!-- numeric formatter -->
<script src="assets/plugins/formatter/autoNumeric.js" type="text/javascript"></script>
<script src="assets/plugins/formatter/accounting.js" type="text/javascript"></script>
<script>

$(document).ready(function(){
    var dt; var _txnMode; var _selectedID; var _selectRowObj; var _cboDisconnectionReason; var dt_so; 
    var _cboCustomer; var _selectedConnectionID; var _connection_id_get

    var initializeControls=function(){

        _cboCustomer=$("#cbo_customer").select2({
            allowClear: false
        });
        
        $('.number').autoNumeric('init', {mDec:0});

        dt=$('#tbl_disconnection').DataTable({
            "dom": '<"toolbar">frtip',
            "bLengthChange":false,
            "ajax" : "Service_disconnection/transaction/list",
            "language" : {
                "searchPlaceholder": "Search"
            },
            "columns": [
                {
                    "targets": [0],
                    "class":          "details-control",
                    "orderable":      false,
                    "data":           null,
                    "defaultContent": ""
                },
                { targets:[1],data: "disconnection_code" },
                { targets:[2],data: "service_no" },
                { targets:[3],data: "account_no" },
                { targets:[4],data: "customer_name" },
                { targets:[5],data: "service_date" },
                {
                    targets:[6],
                    render: function (data, type, full, meta){
                        var btn_edit='<button class="btn btn-primary btn-sm" name="edit_info"  style="margin-left:-15px;" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil"></i> </button>';
                        var btn_trash='<button class="btn btn-red btn-sm" name="remove_info" style="margin-right:0px;" data-toggle="tooltip" data-placement="top" title="Move to trash"><i class="fa fa-trash-o"></i> </button>';

                        return '<center>'+btn_edit+'&nbsp;'+btn_trash+'</center>';
                    }
                }
            ]
        });

        dt_account=$('#tbl_account_list').DataTable({
            "bLengthChange":false,
            oLanguage: {
                    sProcessing: '<center><br /><img src="assets/img/loader/ajax-loader-sm.gif" /><br /><br /></center>'
            },
            processing : true,
            "ajax" : {
                "url" : "Service_disconnection/transaction/accounts",
                "bDestroy": true,            
                "data": function ( d ) {
                        return $.extend( {}, d, {
                            "customer_id": $('#cbo_customer').val()
                        });
                    }
            }, 
            "columns": [
                { targets:[0],data: "account_no" },
                { targets:[1],data: "customer_name" },
                { targets:[2],data: "service_no" },
                { targets:[3],data: "serial_no" },
                {
                    targets:[4],
                    render: function (data, type, full, meta){
                        var btn_accept='<button class="btn btn-success btn-sm" name="accept_account"  style="margin-left:-15px;text-transform: none;" data-toggle="tooltip" data-placement="top" title="Accept"><i class="fa fa-check"></i> Accept</button>';
                        return '<center>'+btn_accept+'</center>';
                    }
                }

            ]
        });        

        _cboDisconnectionReason=$("#cbo_disconnection_reason_id").select2({
            minimumResultsForSearch: -1,
            allowClear: false
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

        $('#tbl_disconnection tbody').on( 'click', 'tr td.details-control', function () {
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
                var d=row.data();
                $.ajax({
                    "dataType":"html",
                    "type":"POST",
                    "url":"Service_disconnection/transaction/disconnection-print?id="+ d.disconnection_id,
                    "beforeSend" : function(){
                        row.child( '<center><br /><img src="assets/img/loader/ajax-loader-lg.gif" /><br /><br /></center>' ).show();
                    }
                }).done(function(response){
                    tr.addClass( 'details' );
                    row.child( response,'no-padding' ).show();
                    // Add to the 'open' array
                    if ( idx === -1 ) {
                        detailRows.push( tr.attr('id') );
                    }
                });
            }
        } );

        $('#btn_new').click(function(){
            _txnMode="new";
            clearFields($('#frm_disconnection'));
            $('.date-picker').datepicker('setDate', 'today');
            $('#modal_title').text('New Disconnection Service');
            $('#modal_new_disconnection').modal('show');
            $('#tbl_other_items > tbody').html('');
            _cboDisconnectionReason.select2('val',1);
            $('#link_browse_co').show();
            $('#sn_icon').hide();
        });

        $('#tbl_disconnection tbody').on('click','button[name="edit_info"]',function(){
            _txnMode="edit";
            _selectRowObj=$(this).closest('tr');
            var data=dt.row(_selectRowObj).data();
            _selectedID=data.disconnection_id;
            _connection_id_get = data.connection_id;
            $('input,textarea,select').each(function(){
                var _elem=$(this);
                $.each(data,function(name,value){
                    if(_elem.attr('name')==name){
                        _elem.val(value);
                    }
                });
            });
            $('#tbl_other_items > tbody').html('');
            _cboDisconnectionReason.select2('val',data.disconnection_reason_id);



            $.ajax({
                url : 'Service_disconnection/transaction/items/'+data.disconnection_id,
                type : "GET",
                cache : false,
                dataType : 'json',
                processData : false,
                contentType : false,
                beforeSend : function(){
                    $('#tbl_other_items > tbody').html('<tr><td align="center" colspan="8"><br /><img src="assets/img/loader/ajax-loader-sm.gif" /><br /><br /></td></tr>');
                },
                success : function(response){
                    var rows=response.other_charges;
                    $('#tbl_other_items > tbody').html('');
                    $.each(rows,function(i,value){
                        $('#tbl_other_items > tbody').append(newRowItem({
                            other_charge_id :value.other_charge_id,
                            other_charge_item_id :value.other_charge_item_id,
                            charge_id :value.charge_id,
                            other_charge_no :value.other_charge_no,
                            charge_qty :value.charge_qty,
                            charge_desc :value.charge_desc,
                            charge_unit_id :value.charge_unit_id,
                            charge_amount :value.charge_amount,
                            charge_line_total :value.charge_line_total
                        }));
                   });
                    reInitializeNumeric();
                }
            });

            $('#link_browse_co').hide();
            $('#sn_icon').show();
            $('#modal_title').text('Edit Disconnection Service');
            $('#modal_new_disconnection').modal('show');
        });

        $('#tbl_account_list > tbody').on('click','button[name="accept_account"]',function(){
            _selectRowObj=$(this).closest('tr');
            var data=dt_account.row(_selectRowObj).data();
            $('#tbl_other_items > tbody').html('<tr><td align="center" colspan="8"><br /><img src="assets/img/loader/ajax-loader-sm.gif" /><br /><br /></td></tr>');

            $('input[name="service_no"]').val(data.service_no);
            $('input[name="connection_id"]').val(data.connection_id);
            $('input[name="customer_name"]').val(data.customer_name);
            $('textarea[name="address"]').val(data.address);
            $('input[name="previous_id"]').val(data.previous_id);

            _connection_id_get = data.connection_id;
            getLatestReading(_connection_id_get).done(function(response){
                var latest=response.data[0];
                console.log(latest);
                $('input[name="previous_month"]').val(latest.previous_month);
                $('input[name="previous_reading"]').val(latest.previous_reading);
                $('input[name="last_meter_reading"]').val(0);
                $('input[name="last_meter_reading"]').keyup();
                $('input[name="arrears_amount"]').val(response.arrears_amount);
                $('input[name="arrears_penalty_amount"]').val(response.arrears_penalty_amount);
                $('#tbl_other_items > tbody').html('');
                    var rows=response.other_charges;
                    $.each(rows,function(i,value){
                        $('#tbl_other_items > tbody').append(newRowItem({
                            other_charge_id :value.other_charge_id,
                            other_charge_item_id :value.other_charge_item_id,
                            charge_id :value.charge_id,
                            other_charge_no :value.other_charge_no,
                            charge_qty :value.charge_qty,
                            charge_desc :value.charge_desc,
                            charge_unit_id :value.charge_unit_id,
                            charge_amount :value.charge_amount,
                            charge_line_total :value.charge_line_total
                        }));
                    });

                    reInitializeNumeric();
            });

             
            $('#modal_account_list').modal('hide');
            $('#modal_new_disconnection').modal('show');

        }); 

        $('#tbl_disconnection tbody').on('click','button[name="remove_info"]',function(){
            _selectRowObj=$(this).closest('tr');
            var data=dt.row(_selectRowObj).data();
            _selectedID=data.disconnection_id;

            chck_disconnection_service(_selectedID,'delete').done(function(response){
                if(response.stat == "success"){
                    $('#modal_confirmation').modal('show');
                }else{
                    showNotification(response);
                }
            });

        });

        _cboCustomer.on('change',function(){
            $('#tbl_account_list tbody').html('<tr><td colspan="5"><center><br/><br /><br /></center></td></tr>');
            dt_account.ajax.reload( null, false );
        });

        $('#btn_print').click(function(){
           window.open('Service_disconnection/transaction/print-masterfile');
        });  

        $('#btn_export').click(function(){
           window.open('Service_disconnection/transaction/export-masterfile');
        }); 


        $("#searchbox_disconnection").keyup(function(){         
            dt
                .search(this.value)
                .draw();
        });

        $("#searchbox_accounts").keyup(function(){         
            dt_account
                .search(this.value)
                .draw();
        });

        $('#btn_yes').click(function(){
            removeDisconnection().done(function(response){
                showNotification(response);
                dt.row(_selectRowObj).remove().draw();
            });
        });

        $('#link_browse_co').click(function(){
            $('#tbl_account_list tbody').html('<tr><td colspan="5"><center><br /><img src="assets/img/loader/ajax-loader-lg.gif" /><br /><br /></center></td></tr>');
            dt_account.ajax.reload( null, false );

            $('#modal_new_disconnection').modal('hide');
            $('#modal_account_list').modal('show');
        });

        $('input[name="file_upload[]"]').change(function(event){
            var _files=event.target.files;

            $('#div_img_department').hide();
            $('#div_img_loader').show();

            var data=new FormData();
            $.each(_files,function(key,value){
                data.append(key,value);
            });

            //console.log(_files);

            $.ajax({
                url : 'Departments/transaction/upload',
                type : "POST",
                data : data,
                cache : false,
                dataType : 'json',
                processData : false,
                contentType : false,
                success : function(response){
                    $('#div_img_loader').hide();
                    $('#div_img_department').show();
                }
            });
        });

        $('#btn_cancel').click(function(){
            clearFields();
            $('#modal_new_disconnection').modal('hide');
        });
        
        $('#btn_cancel_account').click(function(){
            $('#modal_account_list').modal('hide');
            $('#modal_new_disconnection').modal('show');
        });

        $('#btn_save').click(function(){
            if(validateRequiredFields($('#frm_disconnection'))){
                if(_txnMode=="new"){
                    createDisconnection().done(function(response){
                        showNotification(response);
                        dt.row.add(response.row_added[0]).draw();
                        clearFields($('#frm_disconnection'));
                        $('#modal_new_disconnection').modal('hide');
                    }).always(function(){
                        showSpinningProgress($('#btn_save'));
                    });
                }else{
                    updateDisconnection().done(function(response){
                        showNotification(response);
                        dt.row(_selectRowObj).data(response.row_updated[0]).draw();
                        clearFields($('#frm_disconnection'));
                        $('#modal_new_disconnection').modal('hide');
                    }).always(function(){
                        showSpinningProgress($('#btn_save'));
                    });
                }
                
            }
        });


        $('#tbl_items tbody').on('keyup','input.number',function(){

            var row=$(this).closest('tr');
            var last_meter_reading=parseFloat(accounting.unformat($('input[name="last_meter_reading"]').val()));
            var previous_reading=parseFloat(accounting.unformat($('input[name="previous_reading"]').val()));
            if(previous_reading == '' || previous_reading == null){
                return false;
            }
            if(last_meter_reading < previous_reading){
                $('input[name="total_consumption"]').val('');
                $('input[name="meter_amount_due"]').val('');
                $('input[name="default_matrix_id"]').val('');
                $('input[name="rate_amount"]').val('');
                $('input[name="is_fixed"]').val('');
            }else{
                var total_consumption=last_meter_reading-previous_reading;
                 $('input[name="total_consumption"]').val(accounting.formatNumber(total_consumption,0));
                 // GET DETAILS
                    getLatestReadingAmount(total_consumption).done(function(response){
                        var rate=response.data[0];
                        $('input[name="meter_amount_due"]').val(accounting.formatNumber(rate.amount_due,2));
                        $('input[name="default_matrix_id"]').val(rate.default_matrix_id);
                        $('input[name="rate_amount"]').val(rate.rate);
                        $('input[name="is_fixed"]').val(rate.is_fixed_amount);
                    });
            }
        });

    })();

    var reInitializeNumeric=function(){
        $('.numeric').autoNumeric('init',{mDec: 2});
        $('.number').autoNumeric('init', {mDec:0});
    };

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

    var createDisconnection=function(){
        var _data=$('#frm_disconnection').serializeArray();
        // console.log(_data)
        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Service_disconnection/transaction/create",
            "data":_data,
            "beforeSend": showSpinningProgress($('#btn_save'))
        });
    };

    var updateDisconnection=function(){
        var _data=$('#frm_disconnection').serializeArray();
        _data.push({name : "disconnection_id" ,value : _selectedID});

        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Service_disconnection/transaction/update",
            "data":_data,
            "beforeSend": showSpinningProgress($('#btn_save'))
        });
    };

    var removeDisconnection=function(){
        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Service_disconnection/transaction/delete",
            "data":{disconnection_id : _selectedID}
        });
    };

    var getLatestReading=function(){
        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Service_disconnection/transaction/get-latest-reading",
            "data":{connection_id : _connection_id_get, 'service_date' :  $('input[name="service_date"]').val()}
        });
    };

    var getLatestReadingAmount=function(consumption_get){
        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Service_disconnection/transaction/get-latest-reading-amount",
            "data":{connection_id : _connection_id_get, consumption : consumption_get}
        });
    };

    var chck_disconnection_service=function(disconnection_id,mode){

        var _data=$('#').serializeArray();
        _data.push({name : "disconnection_id" ,value : disconnection_id});
        _data.push({name : "mode" ,value : mode});

        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Service_disconnection/transaction/chck_disconnection_service",
            "data":_data
        });
    }; 


    var showList=function(b){
        if(b){
            $('#div_service_list').show();
            $('#div_department_fields').hide();
        }else{
            $('#div_service_list').hide();
            $('#div_department_fields').show();
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
    };

    var clearFields=function(f){
        $('input:not(.date-picker),input[required],textarea',f).val('');
        $('form').find('input:first').focus();
    };

    var newRowItem=function(d){
        return '<tr>'+
        '<td class="hidden"><input name="other_charge_id[]" type="text" class="number form-control" value="'+d.other_charge_id+'"></td>'+
        '<td class="hidden"><input name="other_charge_item_id[]" type="text" class="number form-control" value="'+d.other_charge_item_id+'"></td>'+
        '<td class="hidden"><input name="charge_id[]" type="text" class="number form-control" value="'+d.charge_id+'"></td>'+
        '<td class="hidden"><input name="charge_qty[]" type="text" class="number form-control" value="'+d.charge_qty+'"></td>'+
        '<td>'+d.other_charge_no+'</td>'+
        '<td>'+d.charge_desc+'</td>'+
        '<td class="hidden"><input name="charge_unit_id[]" type="text" class="form-control number" value="'+d.charge_unit_id+'"></td>'+
        '<td class="hidden"><input name="charge_amount[]" type="text" class="numeric form-control" value="'+d.charge_amount+'"></td>'+
        '<td><input name="charge_line_total[]" type="text" class="numeric form-control" value="'+d.charge_line_total+'" readonly></td>'+
        '</tr>';
    };
    function format ( d ) {
        return '<br /><table style="margin-left:10%;width: 80%;">' +
        '<thead>' +
        '</thead>' +
        '<tbody>' +
        '<tr>' +
        '<td>Department Name : </td><td><b>'+ d.department_name+'</b></td>' +
        '</tr>' +
        '<tr>' +
        '<td>Department Description : </td><td>'+ d.department_desc+'</td>' +
        '</tr>' +
        '</tbody></table><br />';
    };
});

</script>

</body>

</html>