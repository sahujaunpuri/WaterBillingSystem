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

        #tbl_reconnection_filter, #tbl_account_list_filter{
                display: none;
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
                        <li><a href="Service_reconnection">Reconnection Service</a></li>
                    </ol>
                    <div class="container-fluid">
                        <div data-widget-group="group1">
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="div_reconnection_list">
                                        <div class="panel panel-default">
                                            <div class="panel-body table-responsive">
                                            <h2 class="h2-panel-heading">Reconnection Service</h2><hr>
                                                <div class="row">
                                                    <div class="col-lg-3"><br>
                                                            <button class="btn btn-primary create_service_reconnection" id="btn_new" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;" data-toggle="modal" data-target="" data-placement="left" title="New Reconnection" ><i class="fa fa-plus"></i> New Reconnection</button>
                                                    </div>
                                                    <div class="col-lg-offset-3 col-lg-3" style="text-align: right;">
                                                    &nbsp;<br>
                                                            <button class="btn btn-primary" id="btn_print" style="text-transform: none; font-family: Tahoma, Georgia, Serif;padding: 6px 10px!important;" data-toggle="modal" data-placement="left" title="Print Connection Masterfile" ><i class="fa fa-print"></i> Print</button> &nbsp;
                                                            <button class="btn btn-success" id="btn_export" style="text-transform: none; font-family: Tahoma, Georgia, Serif;padding: 6px 10px!important;" data-toggle="modal" data-placement="left" title="Export Connection Masterfile" ><i class="fa fa-file-excel-o"></i> Export</button>
                                                    </div>
                                                    <div class="col-lg-3">
                                                            Search :<br />
                                                             <input type="text" id="searchbox_reconnection" class="form-control">
                                                    </div>
                                                </div><br>
                                                <table id="tbl_reconnection" class="table table-striped" cellspacing="0" width="100%">
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
                <div class="modal-dialog" style="width: 80%;">
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
            <div id="modal_new_reconnection" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header" style="background: #2ecc71">
                             <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                             <h2 id="modal_title" class="modal-title" style="color:white;"></h2>
                        </div>
                        <div class="modal-body">
                            <form id="frm_reconnection" role="form" class="form-horizontal">
                                <div class="row" style="margin: 1%;">
                                    <div class="col-lg-6">
                                        <div class="form-group" style="margin-bottom:0px;">
                                            <label class="">Service Reconnection No (Auto):</label>
                                            <input type="text" class="form-control" name="reconnection_code" placeholder="SRN-YYYYMMDD-XXXX" readonly>
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
                                            <input type="hidden" name="disconnection_id" class="form-control" readonly placeholder="Disconnection ID" value="0">
                                            <span class="input-group-addon">
                                                <a href="#" id="link_browse_disc" style="text-decoration: none;color:black;"><b>...</b></a>
                                                <i class="fa fa-code" id="sn_icon"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-offset-1 col-lg-4">
                                        <div class="form-group" style="margin-bottom:0px;">
                                            <label class="">Date Disconnected:</label>
                                            <input type="text" name="date_disconnection_date" class="form-control" placeholder="Date Disconnected" readonly>
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
                                            <textarea class="form-control" name="address" id="address" placeholder="Address" readonly style="border: 1px solid gray;"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="margin: 1%;">
                                    <div class="col-lg-6" style="padding-left:0px;padding-right: 0px;">
                                        <label class=""> Contract Type:</label>
                                        <input type="text" name="contract_type_name" class="form-control" placeholder="Contract Type" readonly>
                                    </div>
                                    <div class="col-lg-6" style="padding-left:10px!important;padding-right: 0px;">
                                        <label class=""> Rate Type:</label>
                                        <input type="text" name="rate_type_name" class="form-control" placeholder="Rate Type" readonly>
                                    </div>
                                </div>

                                <div class="row" style="margin: 1%;">
                                    <div class="col-lg-6" style="padding-left:0px;padding-right: 0px;">
                                        <label class=""><B class="required"> * </B> Target Connection Date:</label>
                                        <input type="text" name="date_connection_target" class="date-picker form-control" placeholder="Date" data-error-msg="Target Connection Date is required!" required value="<?php echo date("m/d/Y"); ?>">
                                    </div>
                                    <div class="col-lg-4" style="padding-left:10px!important;">
                                        <label class=""><B class="required"> * </B> Target Connection Time:</label>
                                        <input type="text" name="time_connection_target" class="form-control" placeholder="Time" data-error-msg="Target Connection Time is required!" required>                                 
                                    </div>
                                </div>

                                <div class="row" style="margin: 1%;">
                                    <div class="col-lg-6" style="padding-left:0px;padding-right: 0px;">
                                        <label class=""><B class="required"> * </B> New Rate Type:</label>
                                        <select name="rate_type_id" id="cbo_rate_type_id" class="form-control" style="width: 100%;">
                                            <?php foreach($rate_types as $rate_type){?>
                                                <option value="<?php echo $rate_type->rate_type_id;?>">
                                                    <?php echo $rate_type->rate_type_name; ?>
                                                </option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>




                            </form>
                        </div>
                        <div class="modal-footer">
                            <button id="btn_save" class="btn btn-primary">Save</button>
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

<?php echo $_rights; ?>
<script>

$(document).ready(function(){
    var dt; var _txnMode; var _selectedID; var _selectRowObj; var _cboDisconnectionReason; var dt_so; 
    var _cboCustomer; var _cboRateType; var _selectRowObjAcc;

    var initializeControls=function(){

        _cboCustomer=$("#cbo_customer").select2({
            allowClear: false
        });

        _cboRateType=$("#cbo_rate_type_id").select2({
            minimumResultsForSearch: -1,
            allowClear: false
        });

        dt=$('#tbl_reconnection').DataTable({
            "dom": '<"toolbar">frtip',
            "bLengthChange":false,
            "order": [[ 7, "desc" ]],
            "ajax" : "Service_reconnection/transaction/list",
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
                { targets:[0],data: "reconnection_code" },
                { targets:[1],data: "disconnection_code" },
                { targets:[2],data: "account_no" },
                { targets:[3],data: "receipt_name" },
                { targets:[4],data: "service_date" },
                {
                    targets:[5],
                    render: function (data, type, full, meta){
                        return '<center>'+btn_edit_service_reconnection+'&nbsp;'+btn_trash_service_reconnection+'</center>';
                    }
                },
                { targets:[6],data: "reconnection_id", visible:false}
            ]
        });

        dt_account=$('#tbl_account_list').DataTable({
            "bLengthChange":false,
            "scrollY":        "300px",
            "scrollCollapse": true,
            "order": [[ 5, "desc" ]],
            oLanguage: {
                    sProcessing: '<center><br /><img src="assets/img/loader/ajax-loader-sm.gif" /><br /><br /></center>'
            },
            processing : true,
            "ajax" : {
                "url" : "Service_reconnection/transaction/disconnections",
                "bDestroy": true,            
                "data": function ( d ) {
                        return $.extend( {}, d, {
                            "customer_id": $('#cbo_customer').val()
                        });
                    }
            }, 
            "columns": [
                { targets:[0],data: "account_no" },
                { targets:[1],data: "receipt_name" },
                { targets:[2],data: "disconnection_code" },
                { targets:[3],data: "serial_no" },
                {
                    targets:[4],
                    render: function (data, type, full, meta){
                        var btn_accept='<button class="btn btn-success btn-sm" name="accept_account"  style="margin-left:-15px;text-transform: none;" data-toggle="tooltip" data-placement="top" title="Accept"><i class="fa fa-check"></i> Accept</button>';
                        return '<center>'+btn_accept+'</center>';
                    }
                },
                { targets:[5],data: "disconnection_id", visible:false}

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

        $('#tbl_reconnection tbody').on( 'click', 'tr td.details-control', function () {
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
                    "url":"Templates/layout/reconnection/"+ d.reconnection_id,
                    "beforeSend" : function(){
                        row.child( '<center><br /><img src="assets/img/loader/ajax-loader-lg.gif" /><br /><br /></center>' ).show();
                    }
                }).done(function(response){
                    row.child( response,'no-padding' ).show();
                    // Add to the 'open' array
                    if ( idx === -1 ) {
                        detailRows.push( tr.attr('id') );
                    }
                });
            }
        });         

        $('#btn_new').click(function(){
            _txnMode="new";
            clearFields($('#frm_reconnection'));
            $('.date-picker').datepicker('setDate', 'today');
            $('#modal_title').text('New Reconnection Service');
            $('#modal_new_reconnection').modal('show');
            $('#link_browse_disc').show();
            _cboRateType.select2('val',1);
            $('#sn_icon').hide();
        });

        $('#tbl_reconnection tbody').on('click','button[name="edit_info"]',function(){
            _txnMode="edit";
            _selectRowObj=$(this).closest('tr');
            var data=dt.row(_selectRowObj).data();
            _selectedID=data.reconnection_id;

            $('input[name="service_no"]').val(data.disconnection_code);
            $('input[name="disconnection_id"]').val(data.disconnection_id);
            $('input[name="date_disconnection_date"]').val(data.date_disconnection_date);
            $('input[name="contract_type_name"]').val(data.contract_type_name);
            $('input[name="rate_type_name"]').val(data.rate_type_name);

            _cboRateType.select2('val',data.rate_type_id);

            $('input,textarea,select').each(function(){
                var _elem=$(this);
                $.each(data,function(name,value){
                    if(_elem.attr('name')==name){
                        _elem.val(value);
                    }
                });
            });

            $('input[name="customer_name"]').val(data.receipt_name);

            $('#link_browse_disc').hide();
            $('#sn_icon').show();
            $('#modal_title').text('Edit Reconnection Service');
            $('#modal_new_reconnection').modal('show');
        });

        $('#tbl_account_list > tbody').on('click','button[name="accept_account"]',function(){
            _selectRowObjAcc=$(this).closest('tr');
            var data=dt_account.row(_selectRowObjAcc).data();

            $('input[name="service_no"]').val(data.disconnection_code);
            $('input[name="disconnection_id"]').val(data.disconnection_id);
            $('input[name="date_disconnection_date"]').val(data.date_disconnection_date);
            $('input[name="customer_name"]').val(data.receipt_name);
            $('input[name="contract_type_name"]').val(data.contract_type_name);
            $('input[name="rate_type_name"]').val(data.rate_type_name);
            $('textarea[name="address"]').val(data.address);

            $('#modal_account_list').modal('hide');
            $('#modal_new_reconnection').modal('show');

        }); 

        $('#tbl_reconnection tbody').on('click','button[name="remove_info"]',function(){
            _selectRowObj=$(this).closest('tr');
            var data=dt.row(_selectRowObj).data();
            _selectedID=data.reconnection_id;

            chck_reconnection_service(_selectedID,'delete').done(function(response){
                if(response.stat == "success"){
                    $('#modal_confirmation').modal('show');
                }else{
                    showNotification(response);
                }
            });          
        });

        _cboCustomer.on('select2:select',function(e){
            $('#tbl_account_list tbody').html('<tr><td colspan="5"><center><br/><br /><br /></center></td></tr>');
            dt_account.ajax.reload( null, false );
        });

        $("#searchbox_reconnection").keyup(function(){         
            dt
                .search(this.value)
                .draw();
        });

        $("#searchbox_accounts").keyup(function(){         
            dt_account
                .search(this.value)
                .draw();
        });

        $('#btn_print').click(function(){
           window.open('Service_reconnection/transaction/print-masterfile');
        });  

        $('#btn_export').click(function(){
           window.open('Service_reconnection/transaction/export-masterfile');
        }); 

        $('#btn_yes').click(function(){
            removeReconnection().done(function(response){
                showNotification(response);
                dt.row(_selectRowObj).remove().draw();
            });
        });

        $('#link_browse_disc').click(function(){
            $('#modal_new_reconnection').modal('hide');
            $('#modal_account_list').modal('show');

            setTimeout(function(){
                $('#tbl_account_list tbody').html('<tr><td colspan="5"><center><br /><img src="assets/img/loader/ajax-loader-lg.gif" /><br /><br /></center></td></tr>');
                dt_account.ajax.reload( null, false );
            },100);
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
            $('#modal_new_reconnection').modal('hide');
        });
        
        $('#btn_cancel_account').click(function(){
            $('#modal_account_list').modal('hide');
            $('#modal_new_reconnection').modal('show');
        });

        $('#btn_save').click(function(){
            if(validateRequiredFields($('#frm_reconnection'))){
                if(_txnMode=="new"){
                    createReconnection().done(function(response){
                        showNotification(response);
                        dt.row.add(response.row_added[0]).draw();
                        clearFields($('#frm_reconnection'));

                    }).always(function(){
                        showSpinningProgress($('#btn_save'));
                    });
                }else{
                    updateReconnection().done(function(response){
                        showNotification(response);
                        dt.row(_selectRowObj).data(response.row_updated[0]).draw();
                        clearFields($('#frm_reconnection'));
                    }).always(function(){
                        showSpinningProgress($('#btn_save'));
                    });
                }
                $('#modal_new_reconnection').modal('hide');
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

    var createReconnection=function(){
        var _data=$('#frm_reconnection').serializeArray();

        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Service_reconnection/transaction/create",
            "data":_data,
            "beforeSend": showSpinningProgress($('#btn_save'))
        });
    };

    var updateReconnection=function(){
        var _data=$('#frm_reconnection').serializeArray();
        _data.push({name : "reconnection_id" ,value : _selectedID});

        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Service_reconnection/transaction/update",
            "data":_data,
            "beforeSend": showSpinningProgress($('#btn_save'))
        });
    };

    var removeReconnection=function(){
        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Service_reconnection/transaction/delete",
            "data":{reconnection_id : _selectedID}
        });
    };

    var chck_reconnection_service=function(reconnection_id,mode){

        var _data=$('#').serializeArray();
        _data.push({name : "reconnection_id" ,value : reconnection_id});
        _data.push({name : "mode" ,value : mode});

        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Service_reconnection/transaction/chck_reconnection_service",
            "data":_data
        });
    };

    var showList=function(b){
        if(b){
            $('#div_reconnection_list').show();
            $('#div_department_fields').hide();
        }else{
            $('#div_reconnection_list').hide();
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