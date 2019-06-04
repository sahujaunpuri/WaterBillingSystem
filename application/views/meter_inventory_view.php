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
                padding-bottom: 10px;
            }
            .right{
                text-align: right;
            }

            #tbl_meter_inventory_filter{
                display: none;
            }

            .modal-lg {
              width: 95%;

            }
            div.dataTables_processing{ 
                position: absolute!important; 
                top: 0%!important; 
                right: -45%!important; 
                left: auto!important; 
                width: 100%!important; 
                height: 40px!important; 
                background: none!important; 
                background-color: transparent!important; 
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
                                <li><a href="MeterInventory">Meter Inventory</a></li>
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
                                                    <div class="panel-body table-responsive" style="overflow-x:hidden">
                                                    <h2 class="h2-panel-heading">Meter Inventory</h2><hr>

                                                         <div class="row">
                                                            <div class="col-lg-3"><br>
                                                                    <button class="btn btn-primary" id="btn_new" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;margin-bottom: 0px !important; float: left;" data-toggle="modal" data-target="" data-placement="left" title="New Meter" ><i class="fa fa-plus"></i>  New Meter</button>
                                                            </div>
                                                            <div class="col-lg-3" style="text-align: right;">
                                                            &nbsp;<br>
                                                                    <button class="btn btn-primary" id="btn_print" style="text-transform: none; font-family: Tahoma, Georgia, Serif;padding: 6px 10px!important;" data-toggle="modal" data-placement="left" title="Print Meter Masterfile" ><i class="fa fa-print"></i> Print</button> &nbsp;
                                                                    <button class="btn btn-success" id="btn_export" style="text-transform: none; font-family: Tahoma, Georgia, Serif;padding: 6px 10px!important;" data-toggle="modal" data-placement="left" title="Export Meter Masterfile" ><i class="fa fa-file-excel-o"></i> Export</button>

                                                            </div>
                                                            <div class="col-lg-3">
                                                                Status : <br />
                                                                <select name="status_id" id="cbo_status" class="form-control" style="width: 100%;">
                                                                    <option value="">All</option>
                                                                    <?php foreach($meter_status as $status){?>
                                                                        <option value="<?php echo $status->meter_status_id; ?>">
                                                                            <?php echo $status->status_name; ?>
                                                                        </option>
                                                                    <?php }?>
                                                                </select>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                    Search :<br />
                                                                     <input type="text" id="searchbox_meter" class="form-control">
                                                            </div>
                                                        </div><br>

                                                        <table id="tbl_meter_inventory" class="table table-striped" cellspacing="0" width="100%">
                                                            <thead class="">
                                                            <tr>
                                                                <th>Meter Code</th>
                                                                <th>Serial No</th>
                                                                <th>Description</th>
                                                                <th>Current Assignee</th>
                                                                <th>Status</th>
                                                                <th><center>Action</center></th>
                                                            </tr>
                                                            </thead>
                                                            <tbody></tbody>
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

                <div id="modal_new_meter" class="modal fade" role="dialog">
                    <div class="modal-dialog modal-md">
                        <div class="modal-content">
                            <div class="modal-header" style="background-color:#2ecc71;">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                                <h4 id="meter_title" class="modal-title" style="color: #ecf0f1;"><span id="modal_mode"></span></h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <form id="frm_meter_inventory" role="form">
                                        <div class="">
                                            <div class="col-xs-12 bottom-10">
                                                <div class="form-group">
                                                    <label class="col-xs-12 col-md-3 control-label right"><strong>Meter Code (Auto):</strong></label>
                                                    <div class="col-xs-12 col-md-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-code"></i>
                                                            </span>
                                                            <input type="text" name="meter_code" class="form-control" placeholder="MC-YYYYMMDD-XXXX" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 bottom-10">
                                                <div class="form-group">
                                                    <label class="col-xs-12 col-md-3 control-label right"><strong><font color="red">*</font> Serial No :</strong></label>
                                                    <div class="col-xs-12 col-md-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-code"></i>
                                                            </span>
                                                            <input type="text" name="serial_no" id="serial_no" class="form-control" placeholder="Serial No" data-error-msg="Serial No. is required!" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 bottom-10">
                                                <div class="form-group">
                                                    <label class="col-xs-12 col-md-3 control-label right"><strong>&nbsp;&nbsp;&nbsp;Description :</strong></label>
                                                    <div class="col-xs-12 col-md-9">
                                                        <textarea name="meter_description" placeholder="Description" class="form-control"></textarea>
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
        var dt; var _txnMode; var _selectedID; var _selectRowObj; var _cboStatus;

        var initializeControls=function(){

            _cboStatus=$("#cbo_status").select2({
                minimumResultsForSearch: -1,
                allowClear: false
            });

            dt=$('#tbl_meter_inventory').DataTable({
                "dom": '<"toolbar">frtip',
                "bLengthChange":false,
                "order": [[ 6, "desc" ]],
                oLanguage: {
                        sProcessing: '<center><br /><img src="assets/img/loader/ajax-loader-sm.gif" /><br /><br /></center>'
                },
                processing : true,
                "ajax" : {
                    "url" : "MeterInventory/transaction/list",
                    "bDestroy": true,            
                    "data": function ( d ) {
                            return $.extend( {}, d, {
                                "status_id": $('#cbo_status').select2('val')
                            });
                        }
                }, 
                "columns": [
                    { targets:[0],data: "meter_code" },
                    { targets:[1],data: "serial_no" },
                    { targets:[2],data: "meter_description" },
                    { targets:[3],data: "customer_name" },
                    { targets:[4],data: "status_name" },
                    {
                        targets:[5],
                        render: function (data, type, full, meta){
                            var btn_edit='<button class="btn btn-primary btn-sm" name="edit_info"  style="margin-left:-15px;" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil"></i> </button>';
                            var btn_trash='<button class="btn btn-red btn-sm" name="remove_info" style="margin-right:0px;" data-toggle="tooltip" data-placement="top" title="Move to trash"><i class="fa fa-trash-o"></i> </button>';

                            return '<center>'+btn_edit+'&nbsp;'+btn_trash+'</center>';
                        }
                    },
                    { targets:[6],data: "meter_inventory_id", visible:false}
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

            _cboStatus.on('change',function(){
                $('#tbl_meter_inventory tbody').html('<tr><td colspan="6"><center><br/><br /><br /></center></td></tr>');
                dt.ajax.reload( null, false );
            });

            $('#tbl_meter_inventory tbody').on( 'click', 'tr td.details-control', function () {
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

            $("#searchbox_meter").keyup(function(){         
                dt
                    .search(this.value)
                    .draw();
            });

            $('#btn_print').click(function(){
               window.open('MeterInventory/transaction/print-masterfile/'+_cboStatus.select2('val'));
            });  

            $('#btn_export').click(function(){
               window.open('MeterInventory/transaction/export-masterfile/'+_cboStatus.select2('val'));
            }); 

            $('#btn_new').click(function(){
                _txnMode="new";
                clearFields($('#frm_meter_inventory'));
                $('#meter_title').text('New Meter Inventory');
                $('#modal_new_meter').modal('show');
            });

            $('#tbl_meter_inventory tbody').on('click','button[name="edit_info"]',function(){
                _txnMode="edit";
                _selectRowObj=$(this).closest('tr');
                var data=dt.row(_selectRowObj).data();
                _selectedID=data.meter_inventory_id;

                chckMeter(_selectedID,'edit').done(function(response){
                    if (response.stat == "success"){
                        $('input,textarea').each(function(){
                            var _elem=$(this);
                            $.each(data,function(name,value){
                                if(_elem.attr('name')==name){
                                    _elem.val(value);
                                }
                            });
                        });

                        $('#meter_title').text('Edit Meter Inventory');
                        $('#modal_new_meter').modal('show');
                    }else{
                        showNotification(response);
                    }
                });
            });

            $('#tbl_meter_inventory tbody').on('click','button[name="remove_info"]',function(){
                _selectRowObj=$(this).closest('tr');
                var data=dt.row(_selectRowObj).data();
                _selectedID=data.meter_inventory_id;
                chckMeter(_selectedID,'delete').done(function(response){
                    if(response.stat == "success"){
                        $('#modal_confirmation').modal('show');
                    }else{
                        showNotification(response);
                    }
                });
            });

            $('#btn_yes').click(function(){
                removeMeterInventory().done(function(response){
                    showNotification(response);
                    if (response.stat == "success"){
                        dt.row(_selectRowObj).remove().draw();
                    }
                });
            });

            $('#btn_cancel').click(function(){
                $('#modal_new_meter').modal('hide');
            });

            $('#btn_save').click(function(){
                if(validateRequiredFields($('#frm_meter_inventory'))){
                    if(_txnMode=="new"){
                        createMeterInventory().done(function(response){
                            showNotification(response);
                            if (response.stat == "success"){
                                dt.row.add(response.row_added[0]).draw();
                                clearFields($('#frm_meter_inventory'));
                                $('#modal_new_meter').modal('hide');
                            }else{
                                $('#serial_no').focus();
                            }
                        }).always(function(){
                            showSpinningProgress($('#btn_save'));
                        });
                    }else{
                        updateMeterInventory().done(function(response){
                            showNotification(response);
                            if (response.stat == "success"){
                                dt.row(_selectRowObj).data(response.row_updated[0]).draw();
                                clearFields($('#frm_meter_inventory'));
                                $('#modal_new_meter').modal('hide');
                            }else{
                                $('#serial_no').focus(); 
                            }

                        }).always(function(){
                            showSpinningProgress($('#btn_save'));
                        });
                    }
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

        var createMeterInventory=function(){
            var _data=$('#frm_meter_inventory').serializeArray();

            return $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"MeterInventory/transaction/create",
                "data":_data,
                "beforeSend": showSpinningProgress($('#btn_save'))
            });
        };

        var updateMeterInventory=function(){
            var _data=$('#frm_meter_inventory').serializeArray();
            _data.push({name : "meter_inventory_id" ,value : _selectedID});

            return $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"MeterInventory/transaction/update",
                "data":_data,
                "beforeSend": showSpinningProgress($('#btn_save'))
            });
        };

        var removeMeterInventory=function(){
            return $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"MeterInventory/transaction/delete",
                "data":{meter_inventory_id : _selectedID}
            });
        };

        var chckMeter=function(meter_inventory_id,mode){

            var _data=$('#').serializeArray();
            _data.push({name : "meter_inventory_id" ,value : meter_inventory_id});
            _data.push({name : "mode" ,value : mode});

            return $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"MeterInventory/transaction/chckMeter",
                "data":_data
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