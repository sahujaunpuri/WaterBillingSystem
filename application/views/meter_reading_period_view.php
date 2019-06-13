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

        .select2-container {
            min-width: 100%;
            z-index: 999999999;
        }
        #tbl_meter_reading_period_filter{
            display: none;
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
                        <li><a href="Meter_reading_period">Mater Reading Period Management</a></li>
                    </ol>

                    <div class="container-fluid">
                        <div data-widget-group="group1">
                            <div class="row">
                                <div class="col-md-12">

                                    <div id="div_period_list">
                                        <div class="panel panel-default">
                                            <div class="panel-body table-responsive">
                                            <h2 class="h2-panel-heading">Meter Reading Period Management</h2><hr>

                                                <div class="row">
                                                    <div class="col-lg-3"><br>
                                                        <button class="btn btn-primary"  id="btn_new" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;" data-toggle="modal" data-target="" data-placement="left" title="New Period" ><i class="fa fa-plus"></i> New Period</button>
                                                    </div>
                                                    <div class="col-lg-3 col-lg-offset-6">
                                                            Search :<br />
                                                             <input type="text" id="searchbox_period" class="form-control">
                                                    </div>
                                                </div><br>
                                                <table id="tbl_meter_reading_period" class="table table-striped" cellspacing="0" width="100%">

                                                    <thead class="">
                                                    <tr>
                                                        <th>Year</th>
                                                        <th>Month</th>
                                                        <th>Period Start</th>
                                                        <th>Period End</th>
                                                        <th>Status</th>
                                                        <th><center>Action</center></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>

                                                    </tbody>
                                                </table>
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


            <div id="modal_close" class="modal fade" tabindex="-1" role="dialog"><!--modal-->
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close"   data-dismiss="modal" aria-hidden="true">X</button>
                            <h4 class="modal-title" style="color:white;"><span id="modal_mode"> </span>Confirm Close</h4>
                        </div>

                        <div class="modal-body">
                            <p id="modal-body-message">
                                <b>Are you sure you want to close this period?</b> <br />
                                <span style="color: red;font-size: 8pt;">Note : It will close the Meter Reading Entry and Processing Billing within this Period.</span>
                            </p>
                        </div>

                        <div class="modal-footer">
                            <button id="btn_yes_close" type="button" class="btn btn-danger" data-dismiss="modal">Yes</button>
                            <button id="btn_close" type="button" class="btn btn-default" data-dismiss="modal">No</button>
                        </div>
                    </div>
                </div>
            </div><!---modal-->


            <div id="modal_meter_reading_period" class="modal fade" tabindex="-1" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 id="modal_period_title" class="modal-title" style="color: white;"></h4>
                        </div>
                        <div class="modal-body">
                            <form id="frm_meter_reading_period" role="form" class="form-horizontal row-border">
                                <div class="form-group">
                                    <label class="col-md-4 control-label"><strong><B> * </B> Period Start :</strong></label>
                                    <div class="col-md-8">
                                        <div class="input-group">
                                            <input type="text" name="meter_reading_period_start" class="date-picker form-control" id="period_start" placeholder="Period Start" data-error-msg="Period Start is required!" required>
                                            <span class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label"><strong><B> * </B> Period End :</strong></label>
                                    <div class="col-md-8">
                                        <div class="input-group">
                                             <input type="text" name="meter_reading_period_end" id="period_end" class="date-picker form-control" placeholder="Period End" data-error-msg="Period End is required!" required>
                                            <span class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label"><strong><B> * </B> Applicable Month :</strong></label>
                                    <div class="col-md-8">
                                       <select name="month_id" class="form-control" id="cbo_month_id" data-error-msg="Month is required!" required>
                                            <?php foreach ($months as $month) { ?>
                                            <option value="<?php echo $month->month_id; ?>"><?php echo $month->month_name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label"><strong><B> * </B> Applicable Year :</strong></label>
                                    <div class="col-md-8">
                                        <select name="meter_reading_year" class="form-control" id="cbo_applicable_year" data-error-msg="Account Type is required!" required>
                                            <?php
                                            $startingYear = date('Y') - 5;
                                            $endingYear = date('Y') + 5;
                                            for ($i = $startingYear;$i <= $endingYear;$i++) { ?> 
                                            <option value='<?php echo $i; ?>'><?php echo $i; ?></option><?php } ?>
                                        </select>
                                    </div>
                                </div><br/>
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

<script src="assets/plugins/select2/select2.full.min.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/jquery.dataTables.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/dataTables.bootstrap.js"></script>
<script src="assets/plugins/datapicker/bootstrap-datepicker.js"></script>
<script>

$(document).ready(function(){
    var dt; var _txnMode; var _selectedID; var _selectRowObj; var _cboMonth; var _cboApplicableYear;
    var yearNow = new Date().getFullYear();
    var monthNow = new Date().getMonth() + 1;
    var initializeControls=function(){
        dt=$('#tbl_meter_reading_period').DataTable({
            "dom": '<"toolbar">frtip',
            "bLengthChange":false,
            "ajax" : "Meter_reading_period/transaction/list",
            "language": {
                "searchPlaceholder":"Search"
            },
            "columns": [
                { targets:[0],data: "meter_reading_year" },
                { targets:[1],data: "month_name" },
                { targets:[2],data: "meter_reading_period_start" },
                { targets:[3],data: "meter_reading_period_end" },
                { targets:[4],data: "status" },
                {
                    targets:[5],
                    render: function (data, type, full, meta){
                        var btn_edit='<button class="btn btn-primary btn-sm" name="edit_info"  style="margin-left:-15px;" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil"></i> </button>';
                        var btn_trash='<button class="btn btn-red btn-sm" name="remove_info" style="margin-right:0px;" data-toggle="tooltip" data-placement="top" title="Move to trash"><i class="fa fa-trash-o"></i> </button>';
                        var btn_close='<button class="btn btn-orange btn-sm" name="close_info" style="margin-right:0px;" data-toggle="tooltip" data-placement="top" title="Close"><i class="fa fa-close"></i> </button>';

                        return '<center>'+btn_edit+'&nbsp;'+btn_trash+'&nbsp;'+btn_close+'</center>';
                    }
                }
            ]
        });

        _cboMonth = $('#cbo_month_id').select2({
            placeholder: "Please select account type.",
            allowClear: false
        });

        _cboApplicableYear = $('#cbo_applicable_year').select2({
            placeholder: "Please Select Applicable Year.",
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

        $('#tbl_meter_reading_period tbody').on( 'click', 'tr td.details-control', function () {
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

        $('#btn_new').click(function(){
            _txnMode="new";
            // clearFields();
            // $('.date-picker').datepicker('setDate','today');
            $('#cbo_applicable_year').select2('val', yearNow);
            $('#cbo_month_id').select2('val', monthNow);
            $('#period_start').datepicker('setDate', new Date(yearNow, (monthNow-2), 1));
            $('#period_end').datepicker('setDate', new Date(yearNow, (monthNow-2)+1,0));
             // $("#datepicker").datepicker("setDate", startDate);
            $('#modal_period_title').text('New Meter Reading Period');
            $('#modal_meter_reading_period').modal('show');
            //showList(false);
        });

        $("#searchbox_period").keyup(function(){         
            dt
                .search(this.value)
                .draw();
        });

        _cboMonth.on('select2:select',function(){
            now =$(this).val();
            $('#period_start').datepicker('setDate', new Date(yearNow, (now-2), 1));
            $('#period_end').datepicker('setDate', new Date(yearNow, (now-2)+1,0));
        });

        _cboApplicableYear.on('select2:select',function(){
            yearnow =$(this).val();
            $('#period_start').datepicker('setDate', new Date(yearnow, (monthNow-2), 1));
            $('#period_end').datepicker('setDate', new Date(yearnow, (monthNow-2)+1,0));
        });

        $('#tbl_meter_reading_period tbody').on('click','button[name="edit_info"]',function(){
            _txnMode="edit";
            _selectRowObj=$(this).closest('tr');
            var data=dt.row(_selectRowObj).data();
            _selectedID=data.meter_reading_period_id;

            $('input,textarea').each(function(){
                var _elem=$(this);
                $.each(data,function(name,value){
                    if(_elem.attr('name')==name){
                        _elem.val(value);
                    }
                });
            });
            _cboMonth.select2('val',data.month_id);
            _cboApplicableYear.select2('val',data.meter_reading_year);
            $('#modal_period_title').text('Edit Meter Reading Period');
            $('#modal_meter_reading_period').modal('show');
            _cboMonth.select2('val',data.month_id);
            //showList(false);
        });

        $('#tbl_meter_reading_period tbody').on('click','button[name="remove_info"]',function(){
            _selectRowObj=$(this).closest('tr');
            var data=dt.row(_selectRowObj).data();
            _selectedID=data.meter_reading_period_id;

            $('#modal_confirmation').modal('show');
        });

        $('#tbl_meter_reading_period tbody').on('click','button[name="close_info"]',function(){
            _selectRowObj=$(this).closest('tr');
            var data=dt.row(_selectRowObj).data();
            _selectedID=data.meter_reading_period_id;

            $('#modal_close').modal('show');
        });

        $('#btn_yes').click(function(){
            removeMeterPeriod().done(function(response){
                showNotification(response);
                if(response.stat=='success') {
                    dt.row(_selectRowObj).remove().draw();
                }
            });
        });

        $('#btn_yes_close').click(function(){
            closeMeterPeriod().done(function(response){
                showNotification(response);
                if(response.stat=='success') {
                    dt.row(_selectRowObj).data(response.row_updated[0]).draw();
                }
            });
        });

        $('#btn_cancel').click(function(){
            $('#modal_meter_reading_period').modal('hide');
            //showList(true);
        });

        $('#btn_save').click(function(){
            if(validateRequiredFields()){
                if(_txnMode=="new"){
                    createMeterPeriod().done(function(response){
                        showNotification(response);
                            if(response.stat=='success') {
                                dt.row.add(response.row_added[0]).draw();
                                clearFields();
                                $('#modal_meter_reading_period').modal('hide');
                            }
                    }).always(function(){
                        showSpinningProgress($('#btn_save'));
                    });
                }else{
                    updateMeterPeriod().done(function(response){
                        showNotification(response);
                        if(response.stat=='success') {
                            dt.row(_selectRowObj).data(response.row_updated[0]).draw();
                            clearFields();
                            $('#modal_meter_reading_period').modal('hide');
                        }
                        //showList(true);
                    }).always(function(){
                        showSpinningProgress($('#btn_save'));
                    });
                }
                
            }
        });
    })();

    var validateRequiredFields=function(){
        var stat=true;
        $('div.form-group').removeClass('has-error');
        $('input[required],textarea[required],select[required]').each(function(){
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
    var createMeterPeriod=function(){
        var _data=$('#frm_meter_reading_period').serializeArray();

        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Meter_reading_period/transaction/create",
            "data":_data,
            "beforeSend": showSpinningProgress($('#btn_save'))
        });
    };

    var updateMeterPeriod=function(){
        var _data=$('#frm_meter_reading_period').serializeArray();
        _data.push({name : "meter_reading_period_id" ,value : _selectedID});

        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Meter_reading_period/transaction/update",
            "data":_data,
            "beforeSend": showSpinningProgress($('#btn_save'))
        });
    };

    var removeMeterPeriod=function(){
        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Meter_reading_period/transaction/delete",
            "data":{meter_reading_period_id : _selectedID}
        });
    };

    var closeMeterPeriod=function(){
        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Meter_reading_period/transaction/close",
            "data":{meter_reading_period_id : _selectedID}
        });
    };    
    
    var showList=function(b){
        if(b){
            $('#div_period_list').show();
            $('#div_period_fields').hide();
        }else{
            $('#div_period_list').hide();
            $('#div_period_fields').show();
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

    var clearFields=function(){
        $('input[required],textarea,input:not(.date-picker)','#frm_meter_reading_period').val('');
        // $('form').find('input:first').focus();
    };

    function format ( d ) {
        return '<br /><table style="margin-left:10%;width: 80%;">' +
        '<thead>' +
        '</thead>' +
        '<tbody>' +
        '<tr>' +
        '<td>Unit Name : </td><td><b>'+ d.unit_name+'</b></td>' +
        '</tr>' +
        '<tr>' +
        '<td>Unit Description : </td><td>'+ d.unit_desc+'</td>' +
        '</tr>' +
        '</tbody></table><br />';
    };
});

</script>

</body>

</html>