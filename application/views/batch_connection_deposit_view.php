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

        #tbl_service_batch_filter, #tbl_account_list_filter{
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
            text-align: right;
        }
        .btn {
            padding: 6px 7px!important;
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
                        <li><a href="Batch_connection_deposit_report">Batch Connection Deposits Report</a></li>
                    </ol>
                    <div class="container-fluid">
                        <div data-widget-group="group1">
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="div_reconnection_list">
                                        <div class="panel panel-default">
                                            <div class="panel-body table-responsive" style="overflow-x: hidden;">
                                            <h2 class="h2-panel-heading">Batch Connection Deposits Report</h2><hr>
                                                <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="col-lg-6"> Connection Deposits Batch: <br />
                                                        <select id="cbo_service_batch"  class="form-control">
                                                        <optgroup label="Batch Code | Start Date | End Date">
                                                            <?php foreach ($batches as $batch) { ?>
                                                                <option value="<?php echo $batch->service_connection_batch_id; ?>"><?php echo $batch->batch_code ?> | <?php echo $batch->start_date ?> | <?php echo $batch->end_date ?></option>
                                                            <?php } ?>
                                                        </optgroup>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-3"><br>
                                                        <button type="button" class="btn btn-primary" id="print_report" style="width: 100%;">
                                                            <i class="fa fa-print"></i> Print
                                                        </button>
                                                    </div>
                                                    <div class="col-lg-3">
                                                    Search : <br />
                                                        <input type="text" id="searchbox_batch" class="form-control">
                                                    </div>

                                                </div>
                                                </div>
                                                <br>
                                                <table id="tbl_service_batch" class="table table-striped" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>Account No</th>
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
                                                            <td></td>
                                                            <td colspan="4" style="text-align: right"><b>Total:</b></td>
                                                            <td><input type="text"  class="form-control" name="batch_total_amount" style="font-weight: bold;border: 0px;background-color: transparent;padding: 0px;height: 18px;text-align: right;" readonly> </td>
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
<script type="text/javascript" src="assets/plugins/datatables/ellipsis.js"></script>
<!-- numeric formatter -->
<script src="assets/plugins/formatter/autoNumeric.js" type="text/javascript"></script>
<script src="assets/plugins/formatter/accounting.js" type="text/javascript"></script>

<script>

$(document).ready(function(){
    var dt; var _txnMode; var _selectedID; var _selectRowObj; var _selectedMRID; var _cbo_service_batch;

    var initializeControls=function(){          
        $('.date-picker').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true
        });

        _cbo_service_batch = $('#cbo_service_batch').select2({
            templateResult: function(data) {
                var r = data.text.split('|');
                    var $result = $(
                        '<div class="row">' +
                            '<div class="col-md-4">' + r[0] + '</div>' +
                            '<div class="col-md-4">' + r[1] + '</div>' +
                            '<div class="col-md-4">' + r[2] + '</div>' +
                        '</div>'
                    );
                    return $result;
            },
            placeholder: "Please select payment batch.",
            allowClear: false
        });

        dt=$('#tbl_service_batch').DataTable({
            "bLengthChange":false,
            oLanguage: {
                    sProcessing: '<center><br /><img src="assets/img/loader/ajax-loader-sm.gif" /><br /><br /></center>'
            },
            "order": [[ 6, "desc" ]],
            processing : true,
            "ajax" : {
                "url" : "Batch_connection_deposit_report/transaction/list",
                "bDestroy": true,            
                "data": function ( d ) {
                        return $.extend( {}, d, {
                            "scbid":$('#cbo_service_batch').val()
                        });
                    }
            }, 
                "columns": [
                    {
                        "targets": [0],
                        "class":          "details-control hidden",
                        "orderable":      false,
                        "data":           null,
                        "defaultContent": ""
                    },
                    { targets:[1],data: "service_no" },
                    { targets:[2],data: "account_no" },
                    { targets:[3],data: "receipt_name" },
                    { targets:[4],data: "service_date" },
                    {sClass: "right_align", targets:[5],data: "initial_meter_deposit", render: $.fn.dataTable.render.number( ',', '.', 2)},
                    { targets:[6],data: "service_connection_batch_id" , visible:false},
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
                        .column(5)
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

        $("#searchbox_batch").keyup(function(){         
            dt
                .search(this.value)
                .draw();
        });        
     
        _cbo_service_batch.on('select2:select',function(e){
            $('#tbl_service_batch').DataTable().ajax.reload()
        });
        $('#print_report').click(function(){
            window.open('Batch_connection_deposit_report/transaction/print-batch-history/'+$('#cbo_service_batch').val());
        });

    })();



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