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

        #tbl_connection_filter, #tbl_account_list_filter{
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
                        <li><a href="Connection_sending">Connection Deposits to Accounting</a></li>
                    </ol>
                    <div class="container-fluid">
                        <div data-widget-group="group1">
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="div_reconnection_list">
                                        <div class="panel panel-default">
                                            <div class="panel-body table-responsive" style="overflow-x: hidden;">
                                            <h2 class="h2-panel-heading">Connection Deposits to Accounting</h2><hr>
                                                <div class="row">
                                                    <div class="col-lg-2">
                                                        <label>Start Date :</label> <br />
                                                        <input type="text"  class="form-control date-picker" id="start_date" value="<?php echo date("m/d/Y"); ?>">
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <label> End Date :</label> <br />
                                                        <input type="text"  class="form-control date-picker" id="end_date" value="<?php echo date("m/d/Y"); ?>">
                                                    </div>
                                                    <div class="col-lg-4"><br><br>
                                                        <button type="button" class="btn btn-primary btn_sending_connection_deposits" id="sent_to_accounting" style="width: 100%;">
                                                            <i class="fa fa-send"></i> Send to Accounting
                                                        </button>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <label>  Search :</label> <br />
                                                        <input type="text" id="searchbox_connections" class="form-control">
                                                    </div>
                                                </div>
                                                <br />
                                                <table id="tbl_connection" class="table table-striped" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>Service No</th>
                                                            <th style="">Account No</th>
                                                            <th style="">Particular</th>
                                                            <th>Service Date</th>
                                                            <th width="15%">Total Deposits</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="4" style="text-align: right"><b>Total:</b></td>
                                                            <td><input type="text"  class="form-control" name="batch_total_amount" style="font-weight: bold;border: 0px;background-color: transparent;padding: 0px;height: 18px;text-align: right;width: 100px;" readonly> </td>
                                                            <td></td>
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

        dt=$('#tbl_connection').DataTable({
            "bLengthChange":false,
            oLanguage: {
                    sProcessing: '<center><br /><img src="assets/img/loader/ajax-loader-sm.gif" /><br /><br /></center>'
            },
            "order": [[ 5, "desc" ]],
            processing : true,
            "ajax" : {
                "url" : "Connection_sending/transaction/list-for-sending",
                "bDestroy": true,            
                "data": function ( d ) {
                        return $.extend( {}, d, {
                            "sd" : $('#start_date').val(),
                            "ed" : $('#end_date').val()
                        });
                    }
            }, 
            "columns": [
                { targets:[0],data: "service_no" },
                { targets:[1],data: "account_no" },
                { targets:[2],data: "customer_name" },
                { targets:[3],data: "service_date" },

                {
                    className: "text-right",
                    targets:[4],data: "initial_meter_deposit",
                    render: function(data){
                        return accounting.formatNumber(data,2);
                    }
                },
                 { targets:[3],data: "connection_id",visible: false }

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

        $("#searchbox_connections").keyup(function(){         
            dt
                .search(this.value)
                .draw();
        });        


        $(".date-picker").on("change", function () {        
            $('#tbl_connection').DataTable().ajax.reload()
        });

        $('#sent_to_accounting').click(function(){
            btn = $(this);
            if(getFloat($('input[name="batch_total_amount"]').val()) == '0' || getFloat($('input[name="batch_total_amount"]').val()) == null){
                    showNotification({title:"Error!",stat:"error",msg: 'Total must not be zero!'});
            }else{

                $.ajax({
                    "dataType":"json",
                    "type":"POST",
                    "url":"Connection_sending/transaction/send-to-accounting",
                    "data":{sd: $('#start_date').val(), ed: $('#end_date').val(), batch_total_amount : $('input[name="batch_total_amount"]').val() },
                    "beforeSend" : function(){
                        showSpinningProgress(btn);
                    }
                }).done(function(response){
                    showNotification(response);
                    if(response.stat == 'success'){
                        $('#tbl_connection').DataTable().ajax.reload()
                    }
                }).always(function(){
                    showSpinningProgress(btn);
                });
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

    var getFloat=function(f){
        return parseFloat(accounting.unformat(f));
    };
});

</script>

</body>

</html>