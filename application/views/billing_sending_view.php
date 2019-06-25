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
        td.details-control-print {
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

        @keyframes spin {
            from { transform: scale(1) rotate(0deg); }
            to { transform: scale(1) rotate(360deg); }
        }

        @-webkit-keyframes spin2 {
            from { -webkit-transform: rotate(0deg); }
            to { -webkit-transform: rotate(360deg); }
        }

        #tbl_billing_filter, #tbl_account_list_filter{
                display: none;
        }

        label{
            font-weight: normal;
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
       .select2-results__options {
                overflow-x: hidden;
        }
        .right_align{
            align-items: center;
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
                        <li><a href="Billing_sending">Billing to Accounting</a></li>
                    </ol>
                    <div class="container-fluid">
                        <div data-widget-group="group1">
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="div_reconnection_list">
                                        <div class="panel panel-default">
                                            <div class="panel-body table-responsive" style="overflow-x: hidden;">
                                            <h2 class="h2-panel-heading">Billing to Accounting</h2><hr>
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <label> Period :</label> <br />
                                                        <select name="meter_reading_period_id" id="cbo_period" data-error-msg="Meter Reading Period is required." required style="width: 100%;">
                                                            <option value="">Select a period</option>
                                                            <?php foreach($periods as $period){ ?>
                                                                <option value="<?php echo $period->meter_reading_period_id; ?>" data-start="<?php echo $period->meter_reading_period_start; ?>" data-end="<?php echo $period->meter_reading_period_end; ?>"><?php echo $period->month_name; ?> <?php echo $period->meter_reading_year; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <label>Start Date :</label> <br />
                                                        <input type="text"  class="form-control" id="start_date" readonly>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <label> End Date :</label> <br />
                                                        <input type="text"  class="form-control" id="end_date" readonly>
                                                    </div>
                                                    <div class="col-lg-offset-1 col-lg-3">
                                                        <label>  Search :</label> <br />
                                                        <input type="text" id="searchbox_billing" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <label> Batch No :</label> <br />
                                                        <select name="meter_reading_input_id" id="cbo_meter_reading_input" data-error-msg="Meter Reading Period is required." required style="width: 100%;">
                                                        <optgroup label="Batch # | Processed">
                                                        </optgroup>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-4"><br><br>
                                                        <button type="button" class="btn btn-primary btn_sending_billing" id="sent_to_accounting" style="width: 100%;">
                                                            <i class="fa fa-send"></i> Send to Accounting
                                                        </button>
                                                    </div>
                                                    <div class="col-lg-offset-1 col-lg-3">
                                                       
                                                    </div>
                                                </div><br>
                                                <table id="tbl_billing" class="table table-striped" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>Control No</th>
                                                            <th style="width: 100px;">Account No</th>
                                                            <th style="width: 200px;">Particular</th>
                                                            <th>Consumption</th>
                                                            <th>Total Receivables</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="4" style="text-align: right"><b>Total:</b></td>
                                                            <td><input type="text"  class="form-control" name="batch_total_amount" style="font-weight: bold;border: 0px;background-color: transparent;padding: 0px;height: 18px;text-align: right;" readonly> </td>
                                                        </tr>
                                                    </tfoot>
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
            <div id="modal_confirmation" class="modal fade" tabindex="-1" role="dialog"><!--modal-->
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                            <h4 class="modal-title" style="color:white;"><span id="modal_mode"> </span>Confirm Process</h4>
                        </div>

                        <div class="modal-body">
                            <p id="modal-body-message">Are you sure?</p>
                        </div>

                        <div class="modal-footer">
                            <button id="btn_yes" type="button" class="btn btn-success" data-dismiss="modal">Yes</button>
                            <button id="btn_close" type="button" class="btn btn-default" data-dismiss="modal">No</button>
                        </div>
                    </div>
                </div>
            </div><!---modal-->
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

<?php echo $_rights; ?>
<script>

$(document).ready(function(){
    var dt; var _txnMode; var _selectedID; var _selectRowObj; var _selectedMRID;

    var initializeControls=function(){

        _cboPeriod=$("#cbo_period").select2({
            placeholder: "Please Select Period.",
            allowClear: false
        });

        _cboPeriod.select2('val',0);
        $('#sent_to_accounting').attr('disabled', true);
        _cboBatchNo=$("#cbo_meter_reading_input").select2({
            templateResult: function(data) {
                var r = data.text.split('|');
                    var $result = $(
                        '<div class="row">' +
                            '<div class="col-md-9">' + r[0] + '</div>' +
                            '<div class="col-md-3" class="right_align">' + r[1] + '</div>' +
                        '</div>'
                    );
                    return $result;
            },
            placeholder: "Please Select Batch No.",
            allowClear: false
        });

          

        dt=$('#tbl_billing').DataTable({
            "bLengthChange":false,
            oLanguage: {
                    sProcessing: '<center><br /><img src="assets/img/loader/ajax-loader-sm.gif" /><br /><br /></center>'
            },
            processing : true,
            "ajax" : {
                "url" : "Billing_sending/transaction/statement",
                "bDestroy": true,            
                "data": function ( d ) {
                        return $.extend( {}, d, {
                            "period_id": $('#cbo_period').val(),
                            "meter_reading_input_id": $('#cbo_meter_reading_input').val()
                        });
                    }
            }, 
            "columns": [
                { targets:[0],data: "control_no" },
                { targets:[1],data: "account_no" },
                { targets:[2],data: "receipt_name" },
                {
                    className: "text-right",
                    targets:[3],data: "total_consumption",
                    render: function(data){
                        return accounting.formatNumber(data,0);
                    }
                },
                {
                    className: "text-right",
                    targets:[4],data: "grand_total_amount",
                    render: function(data){
                        return accounting.formatNumber(data,2);
                    }
                },

            ],

                "footerCallback": function ( row, data, start, end, display ) {
                    var api = this.api(), data;
                   // console.log(data);
         
                    // Remove the formatting to get integer data for summation
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };
         
                    // Total over all pages
                    totalAmount = api
                        .column(4)
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                     $('input[name="batch_total_amount"]').val(accounting.formatNumber(totalAmount,2));

                }
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

        $("#searchbox_billing").keyup(function(){         
            dt
                .search(this.value)
                .draw();
        });        

        _cboPeriod.on('select2:select', function(){
            var i=$(this).select2('val');

            _selectedMRID = $(this).select2('val');
            _currentMeterPeriod = $(this).select2('val'); // SET CURRENT METER READING PERIOD TO GET ALL ACCOUNTS
            var obj_period=$('#cbo_period').find('option[value="' + i + '"]');
            $('#start_date').val(obj_period.data('start'));
            $('#end_date').val(obj_period.data('end'));
            $('#tbl_billing tbody').html('<tr><td colspan="5"><i>No records found.</i></td></tr>');
            $('input[name="batch_total_amount"]').val(accounting.formatNumber(0,2));
            getBatchNo('false'); // FALSE MEANS SETTING VAL AS NULL
            if(_cboBatchNo.val() != null){$('#sent_to_accounting').attr('disabled', false);}else{ $('#sent_to_accounting').attr('disabled', true); }
        });

       _cboBatchNo.on('select2:select', function(){
            if(_cboBatchNo.val() != null){$('#sent_to_accounting').attr('disabled', false);}else{ $('#sent_to_accounting').attr('disabled', true); }
            $('#tbl_billing tbody').html('<tr><td colspan="5"><i>No records found.</i></td></tr>');
            $('input[name="batch_total_amount"]').val(accounting.formatNumber(0,2));
            dt.ajax.reload( null, false );
        });
     

        $('#btn_process').on('click',function(){
            check_process().done(function(response){
                if(response.stat == "success"){
                    $('#modal_confirmation').modal('show');
                }else{   
                    showNotification(response);
                }
            }).always(function(){
                showSpinningProgress($('#btn_process'));
            });
        });

        $('#btn_yes').click(function(){
            $('#btn_process').attr('disabled',true);
            $("#btn_process span").text('Processing');
            process_billing().done(function(response){
                showNotification(response);
                $('#select_all').prop('checked', false);
                dt.ajax.reload( null, false );
            }).always(function(){
                showSpinningProgress($('#btn_process'));
                $("#btn_process span").text('Process');
                $('#btn_process').attr('disabled',false);
            });
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

        $('#sent_to_accounting').click(function(){
            var  i = _cboBatchNo.val();
            btn = $(this);
                $.ajax({
                    "dataType":"json",
                    "type":"POST",
                    "url":"Billing_sending/transaction/send-to-accounting",
                    "data":{meter_reading_input_id: i , batch_total_amount : $('input[name="batch_total_amount"]').val() },
                    "beforeSend" : function(){
                        showSpinningProgress(btn);
                    }
                }).done(function(response){
                    showNotification(response);
                    if(response.stat == 'success'){
                        getBatchNo('true',i); // TRUE MEANS SETTING THE SECOND PARAM AS THE VAL
                    }
                }).always(function(){
                    showSpinningProgress(btn);
                });

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

    var process_billing=function(){
        var _data = dt.$('input, select').serialize();
        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Process_billing/transaction/process",
            "data":_data,
            "beforeSend": showSpinningProgress($('#btn_process'))
        });
    };

    var getBatchNo=function(b,newval){
            _cboBatchNo.empty().trigger("change");
            _cboBatchNo.append('<optgroup label="Batch # | Processed"></optgroup>');

                $.ajax({
                    type : "GET",
                    cache : false,
                    dataType : 'json',
                    async: true,
                    "data" : { mrid : _selectedMRID },
                    "url":"Billing_sending/transaction/list-of-batches",
                    "beforeSend" : function(){
                        // row.child( '<center><br /><img src="assets/img/loader/ajax-loader-lg.gif" /><br /><br /></center>' ).show();
                    }
                }).then(function(response){
                     $.each(response.data,function(i,value){
                        var option = new Option(format(value.batch_no,value.is_sent), value.meter_reading_input_id, true, true);
                        _cboBatchNo.select2({
                          data: option,
                          escapeMarkup: function(markup) {
                            return markup;
                          },
                          placeholder: "Please Select Batch No.",
                            templateResult: function(data) {
                                var r = data.text.split('|');
                                    var $result = $(
                                        '<div class="row">' +
                                            '<div class="col-md-8">' + r[0] + '</div>' +
                                            '<div class="col-md-4">' + r[1] + '</div>' +
                                        '</div>'
                                    );
                                    return $result;
                            },
                        })
                        _cboBatchNo.append(option).trigger('change');
                     });
                     if(b == 'true'){
                        _cboBatchNo.val(newval).trigger('change');
                     }else{
                        _cboBatchNo.val(null).trigger('change');
                     }
                });
    };


    var check_process=function(){
        var _data = dt.$('input, select').serialize();
        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Process_billing/transaction/check_process",
            "data":_data,
            "beforeSend": showSpinningProgress($('#btn_process'))
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
        $(e).find('i').toggleClass('glyphicon glyphicon-refresh spinning');
    };

    var clearFields=function(f){
        $('input:not(.date-picker),input[required],textarea',f).val('');
        $('form').find('input:first').focus();
    };

    function format ( d,sent ) {
        if(sent == 1){
            return  d+' | <i class="fa fa-check-circle"></i>';

        }else{
            return  d+' | <i class="fa fa-times-circle"></i>';

        }
    };
});

</script>

</body>

</html>