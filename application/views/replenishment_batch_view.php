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
    <link href="assets/plugins/datapicker/datepicker3.css" rel="stylesheet">
    <link href="assets/plugins/select2/select2.min.css" rel="stylesheet">
    <link type="text/css" href="assets/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">
    <link href="assets/plugins/select2/select2.min.css" rel="stylesheet">
    <link type="text/css" href="assets/plugins/datatables/dataTables.themify.css" rel="stylesheet">

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
        select { width: 100%; }
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

                    <ol class="breadcrumb">
                        <li><a href="dashboard">Dashboard</a></li>
                        <li><a href="Replenishment_batch">Replenishment Batch Report</a></li>
                    </ol>

                    <div class="container-fluid">
                        <div class="panel panel-default">
                        <!--     <div class="panel-heading">
                                <b style="color: white; font-size: 12pt;"><i class="fa fa-bars"></i>&nbsp; </b>
                            </div> -->
                            <div class="panel-body">
                            <h2 class="h2-panel-heading">Replenishment Batch Report</h2><hr>
                                <div class="row">
                                    <div class="container-fluid">
                                        <div class="container-fluid group-box">
                                            <div class="col-xs-12 col-md-4" style="margin-bottom: 10px;">
                                                <strong>Batch No:</strong>
                                                <select id="batch_id">
                                                    <?php foreach ($batches as $batch): ?>
                                                       <option value="<?php echo $batch->batch_id; ?>"><?php echo $batch->batch_no; ?></option> 
                                                    <?php endforeach ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div><br>
                                <div class="row">
                                    <div class="container-fluid">
                                        <div class="container-fluid group-box">
                                            <button class="btn btn-primary pull-left" style="margin-right: 5px; margin-top: 0; margin-bottom: 10px;" id="btn_print" style="text-transform: none; font-family: Tahoma, Georgia, Serif; ">
                                                <i class="fa fa-print"></i> Print Report
                                            </button>
                                            <button class="btn btn-success pull-left" style="margin-right: 5px; margin-top: 0; margin-bottom: 10px;" id="btn_export" style="text-transform: none; font-family: Tahoma, Georgia, Serif; ">
                                                <i class="fa fa-file-excel-o"></i> Export
                                            </button>
                                            <button class="btn btn-success pull-left" style="margin-right: 5px; margin-top: 0; margin-bottom: 10px;" id="btn_email" style="text-transform: none; font-family: Tahoma, Georgia, Serif; ">
                                                <i class="fa fa-share"></i> Email
                                            </button>                                           
                                            <table id="tbl_replenishment" class="table table-striped" width="100%" cellspacing="0">
                                                <thead class="">
                                                    <th></th>
                                                    <th>Document # / PCV #</th>
                                                    <th>Particular</th>
                                                    <th>Amount</th>
                                                    <th>Remarks</th>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
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
                        <li><h6 style="margin: 0;">&copy; 2017 - JDEV IT Business Solutions</h6></li>
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

<!-- Date range use moment.js same as full calendar plugin -->
<script src="assets/plugins/fullcalendar/moment.min.js"></script>
<!-- Data picker -->
<script src="assets/plugins/datapicker/bootstrap-datepicker.js"></script>
<!-- numeric formatter -->
<script src="assets/plugins/formatter/autoNumeric.js" type="text/javascript"></script>
<script src="assets/plugins/formatter/accounting.js" type="text/javascript"></script>

<script type="text/javascript" src="assets/plugins/datatables/jquery.dataTables.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/dataTables.bootstrap.js"></script>
<script src="assets/plugins/select2/select2.full.min.js"></script>

<script>

$(document).ready(function(){
    var dtReplenish; var _cboBatch;

    var initializeControl=function(){
        $('.date-picker').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true
        });

        InitializeDataTable();
    }();

    var bindEventHandlers=function(){


       _cboBatch.on("select2:select", function (e) {
            dtReplenish.destroy();
            InitializeDataTable();
        });


        $('#btn_print').click(function(){
            window.open('Replenishment_batch/transaction/report?i='+$('#batch_id').val());
        });

        $('#btn_export').click(function(){
            window.open('Replenishment_batch/transaction/export?i='+$('#batch_id').val());
        });

        $('#btn_email').click(function(){
            showNotification({title:"Sending!",stat:"info",msg:"Please wait for a few seconds."});

            var btn=$(this);
        
            $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"Replenishment_batch/transaction/email?i="+$('#batch_id').val(),
                "beforeSend": showSpinningProgress(btn)
            }).done(function(response){
                showNotification(response);
                showSpinningProgress(btn);

            });
        });

            var showSpinningProgress=function(e){
                $(e).toggleClass('disabled');
                $(e).find('span').toggleClass('glyphicon glyphicon-refresh spinning');
            };


            var showNotification=function(obj){
                PNotify.removeAll(); //remove all notifications
                new PNotify({
                    title:  obj.title,
                    text:  obj.msg,
                    type:  obj.stat
                });
            };
            
    }();

    function InitializeDataTable() {
        dtReplenish=$('#tbl_replenishment').DataTable({
            "dom": '<"toolbar">frtip',
            "bLengthChange":false,
            "language": {
                searchPlaceholder: "Search..."
            },
            "ajax": {
              "url":"Replenishment_batch/transaction/list",
              "type":"GET",
              "bDestroy":true,
              "data":function (d) {
                return $.extend( {}, d, {
                    "i": $('#batch_id').val()
                });
              }
            },
            "columns": [
                { visible:false, targets:[0],data: "batch_no" },
                { targets:[1],data: "txn_no" },
                { targets:[2],data: "supplier_name" },
                {
                    className: "text-right",
                    targets:[3],data: "amount",
                    render: function(data){
                        return accounting.formatNumber(data,2);
                    }
                },
                { targets:[4],data: "remarks" }
            ],
            "order": [[ 0, 'asc' ]],
            "displayLength": 25,
            "drawCallback": function ( settings ) {
                var api = this.api();
                var rows = api.rows( {page:'current'} ).nodes();
                var last=null;
     
                api.column(0, {page:'current'} ).data().each( function ( group, i ) {
                    if ( last !== group ) {
                        $(rows).eq( i ).before(
                            '<tr class="group"><td colspan="5" style="background-color:#064475; color: white;"><strong>'+'BATCH #: <i>'+group+'</i></strong></td></tr>'
                        );
     
                        last = group;
                    }
                } );
            }
        });


        _cboBatch=$("#batch_id").select2({
            placeholder: "Please select Batch Number.",
            allowClear: true
        });

    };
});

</script>

</body>

</html>