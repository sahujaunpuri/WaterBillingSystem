<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>JCORE - <?php echo $title; ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-cdjp-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="description" content="Avenxo Admin Theme">
    <meta name="author" content="">
    <?php echo $_def_css_files; ?>
    <link rel="stylesheet" href="assets/plugins/spinner/dist/ladda-themeless.min.css">
    <link type="text/css" href="assets/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">
    <link type="text/css" href="assets/plugins/datatables/dataTables.themify.css" rel="stylesheet">
    <link href="assets/plugins/select2/select2.min.css" rel="stylesheet">
    <!--<link href="assets/dropdown-enhance/dist/css/bootstrap-select.min.css" rel="stylesheet" type="text/css">-->
    <link href="assets/plugins/datapicker/datepicker3.css" rel="stylesheet">
    <link type="text/css" href="assets/plugins/iCheck/skins/minimal/blue.css" rel="stylesheet">              <!-- iCheck -->
    <link type="text/css" href="assets/plugins/iCheck/skins/minimal/_all.css" rel="stylesheet">                   <!-- Custom Checkboxes / iCheck -->
    <style>
        .toolbar{
            float: left;
        }

        td:nth-child(3),td:nth-child(4){
            text-align: right;
        }

        td:nth-child(5){
            text-align: right;
            font-weight: bolder;
        }
        table.dataTable,
        table.dataTable th,
        table.dataTable td {
          -webkit-box-sizing: content-box;
          -moz-box-sizing: content-box;
          box-sizing: content-box;
        }
    </style>
</head>
<body class="animated-content" style="font-family: tahoma;">
<?php echo $_top_navigation; ?>
<div id="wrapper">
    <div id="layout-static">
        <?php echo $_side_bar_navigation;?>
        <div class="static-content-wrapper white-bg">
            <div class="static-content"  >
                <div class="page-content"><!-- #page-content -->
                    <ol class="breadcrumb" style="margin-bottom: 0px;">
                        <li><a href="dashboard">Dashboard</a></li>
                    </ol>
                    <div class="container-fluid">
                        <div data-widget-group="group1">
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="div_payable_list">
                                        <div class="panel-group panel-default" id="accordionA">
                                            <div class="panel panel-default" style="border-radius: 6px;border: 1px solid lightgrey;">
                                                <div id="collapseTwo" class="collapse in">
                                                    <div class="panel-body">
                                                    <h2 class="h2-panel-heading">General Ledger</h2><hr>
                                                        <div>
                                                            <div class="row">
                                                                <div class="col-lg-6">
                                                                    Period Start * :<br />
                                                                    <div class="input-group">
                                                                        <input type="text" id="txt_date" name="date_from" class="date-picker form-control" value="<?php echo date("m/d/Y"); ?>">
                                                                         <span class="input-group-addon">
                                                                                <i class="fa fa-calendar"></i>
                                                                         </span>
                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-6">
                                                                    Period End * :<br />
                                                                    <div class="input-group">
                                                                        <input type="text" id="txt_date" name="date_to" class="date-picker form-control" value="<?php echo date("m/d/Y"); ?>">
                                                                         <span class="input-group-addon">
                                                                                <i class="fa fa-calendar"></i>
                                                                         </span>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <br />
                                                        <div >
                                                        <button class="btn btn-success" id="btn_print" style="text-transform: none; font-family: Tahoma, Georgia, Serif; " data-toggle="modal" data-target="#salesInvoice" data-placement="left" title="Print" >
                                                        <i class="fa fa-print"></i> Print Report</button>
                                                        <button class="btn btn-primary" id="btn_excel" style="text-transform: none; font-family: Tahoma, Georgia, Serif; " data-toggle="modal" data-target="#salesInvoice" data-placement="left" title="Print" >
                                                        <i class="fa fa-file-excel-o" aria-hidden="true"></i> Export to Excel</button>
                                                        <button class="btn btn-primary" style="margin-right: 5px; margin-top: 10px; margin-bottom: 10px;" id="btn_email" style="text-transform: none; font-family: Tahoma, Georgia, Serif; " data-toggle="modal" data-target="#salesInvoice" data-placement="left" title="Send to Email" >
                                                        <i class="fa fa-share"></i> Email </button>
                                                        <button class="btn btn-success" id="btn_refresh" style="text-transform: none; font-family: Tahoma, Georgia, Serif; " data-toggle="modal" data-target="#salesInvoice" data-placement="left" title="Reload" >
                                                        <i class="fa fa-refresh"></i></button>
                                                            <table id="tbl_general_ledger" class="table table-striped" cellspacing="0" width="100%">
                                                                <thead class="">
                                                                <tr>
                                                                    <th></th>
                                                                    <th width="20%">Account Code</th>
                                                                    <th>Account Title</th>
                                                                    <th>DR</th>
                                                                    <th>CR</th>
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

<script type="text/javascript" src="assets/plugins/datatables/jquery.dataTables.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/dataTables.bootstrap.js"></script>

<!-- Select2-->
<script src="assets/plugins/select2/select2.full.min.js"></script>
<!---<script src="assets/plugins/dropdown-enhance/dist/js/bootstrap-select.min.js"></script>-->

<!-- Date range use moment.js same as full calendar plugin -->
<script src="assets/plugins/fullcalendar/moment.min.js"></script>
<!-- Data picker -->
<script src="assets/plugins/datapicker/bootstrap-datepicker.js"></script>

<!-- numeric formatter -->
<script src="assets/plugins/formatter/autoNumeric.js" type="text/javascript"></script>
<script src="assets/plugins/formatter/accounting.js" type="text/javascript"></script>

<script>
    $(document).ready(function(){
        var _date_from = $('input[name="date_from"]');
        var _date_to = $('input[name="date_to"]');
        var _particular;


        var initializeControls=function(){
            $('.date-picker').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true

            });

            reloadList();
            // createToolBarButton();

        }();

        var bindEventControls=function(){

            $('.date-picker').on('change',function(){
                dt.destroy();
                reloadList();
                // createToolBarButton();
                // getParticular().done(function(response){
                //     if (response.data.length > 0){
                //         _particular = response.data[0].title+' '+data.response.data[0].name;
                //     }
                // });
            });

            $(document).on('click','#btn_print',function(){
                window.open('General_ledger/transaction/report?start='+ _date_from.val() +'&end='+ _date_to.val());
            });

            $(document).on('click','#btn_excel',function(){
                window.open('General_ledger/transaction/export-excel?start='+ _date_from.val() +'&end='+ _date_to.val());
            });

            $('#btn_email').on('click', function() {
            showNotification({title:"Sending!",stat:"info",msg:"Please wait for a few seconds."});

            var btn=$(this);
        
            $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"General_ledger/transaction/email-export?start="+ _date_from.val() +'&end='+ _date_to.val(),
                "beforeSend": showSpinningProgress(btn)
            }).done(function(response){
                showNotification(response);
                showSpinningProgress(btn);

            });
            });


            $(document).on('click','#btn_refresh',function(){
                dt.destroy();
                reloadList();
                // createToolBarButton();
            });


        }();



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

        function getParticular(){
            var _data=$('#').serializeArray();
            _data.push({name : "startDate" ,value : _date_from.val()});
            _data.push({name : "endDate" ,value : _date_to.val()});

            return $.ajax({
                "dataType":"json",
                "type":"GET",
                "url":"General_ledger/transaction/get-general-ledger",
                "data":_data
            });
        }

/*        function createToolBarButton(){
            var _btnPrint='<button class="btn btn-success" id="btn_print" style="text-transform: none; font-family: Tahoma, Georgia, Serif; " data-toggle="modal" data-target="#salesInvoice" data-placement="left" title="Print" >'+
                '<i class="fa fa-print"></i> Print Report</button>';
            var _btnExcel='<button class="btn btn-primary" id="btn_excel" style="text-transform: none; font-family: Tahoma, Georgia, Serif; " data-toggle="modal" data-target="#salesInvoice" data-placement="left" title="Print" >'+
                '<i class="fa fa-file-excel-o" aria-hidden="true"></i> Export to Excel</button>';        
            var _btnEmail='<button class="btn btn-primary" style="margin-right: 5px; margin-top: 10px; margin-bottom: 10px;" id="btn_email" style="text-transform: none; font-family: Tahoma, Georgia, Serif; " data-toggle="modal" data-target="#salesInvoice" data-placement="left" title="Send to Email" >' +
                '<i class="fa fa-share"></i> Email </button>';                      
            var _btnRefresh='<button class="btn btn-success" id="btn_refresh" style="text-transform: none; font-family: Tahoma, Georgia, Serif; " data-toggle="modal" data-target="#salesInvoice" data-placement="left" title="Reload" >'+
                '<i class="fa fa-refresh"></i></button>';

            $("div.toolbar").html(_btnPrint+"&nbsp;"+_btnExcel+"&nbsp;"+_btnEmail+"&nbsp;"+_btnRefresh);
        };*/


        function reloadList(){

            dt=$('#tbl_general_ledger').DataTable({
                "dom": '<"toolbar">frtip',
                "sScrollY":'80vh',
                "order":[[0,'desc']],
                "paging": false,
                "bAutoWidth": true,
                "bPaginate":false,
                "ajax": {
                    "url": "General_ledger/transaction/get-general-ledger",
                    "type": "GET",
                    "bDestroy": true,
                    "data": function ( d ) {
                        return $.extend( {}, d, {
                            "startDate":_date_from.val(),
                            "endDate":_date_to.val()
                        });
                    }
                },
                "columns": [
                    { "visible": false, targets: [0],data: "group_by" },
                    { targets:[3],data: "account_no" },
                    { targets:[4],data: "account_title" },

                    {
                        targets:[5],
                        data: "debit",
                        render: function(data, type, full, meta){
                            return '<b>'+accounting.formatNumber(data,2)+'</b>';
                        }
                    },
                    {
                        targets:[6],
                        data: "credit",
                        render: function(data, type, full, meta){
                            return '<b>'+accounting.formatNumber(data,2)+'</b>';
                        }
                    }
                ]
                ,
                "rowCallBack": function(a, b, c){
                    console.log(b);
                },
                "displayLength": 25,
                "drawCallback": function ( settings ) {
                var api = this.api();
                var rows = api.rows( {page:'current'} ).nodes();
                var last=null;

                            api.column(0, {page:'current'} ).data().each( function ( group, i ) {
                                if ( last !== group ) {
                                    $(rows).eq( i ).before(
                                        '<tr class="group"><td colspan="4" style="background-color:orange;"><b>Date:</b> '+group+'</td></tr>'
                                    );

                                    last = group;
                                }
                            } );
                        }

            });
        };



    });
</script>


</body>

</html>