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
        #tbl_monthly_connection_filter{
            display: none;
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
                        <li><a href="Monthly_connection">Monthly Connection</a></li>
                    </ol>

                    <div class="container-fluid">
                        <div data-widget-group="group1">
                            <div class="row">
                                <div class="col-md-12">

                                    <div id="div_payable_list">

                                        <div class="panel-group panel-default" id="accordionA">


                                            <div class="panel panel-default">
                                                <div id="collapseTwo" class="collapse in">
                                                    <div class="panel-body">
                                                    <h2 class="h2-panel-heading">Monthly Connection</h2><hr>
                                                        <div>
                                                            <div class="row">
                                                                <div class="col-lg-3">
                                                                    Month * : <br />
                                                                    <select id="cbo_months" class="form-control">
                                                                        <?php foreach($months as $month) { ?>
                                                                            <option value="<?php echo $month->month_id; ?>"><?php echo $month->month_name; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                                <div class="col-lg-2">
                                                                    Year * : <br />
                                                                    <select class="form-control" id="cbo_year" data-error-msg="Year is required!" required>
                                                                        <?php
                                                                        $startingYear = date('Y') - 5;
                                                                        $endingYear = date('Y') + 5;
                                                                        for ($i = $startingYear;$i <= $endingYear;$i++) { ?> 
                                                                        <option value='<?php echo $i; ?>'><?php echo $i; ?></option><?php } ?>
                                                                    </select>
                                                                </div>
                                                                <div class="col-lg-4" align="right">
                                                                    <br>
                                                                    <button class="btn btn-primary" id="btn_print" style="text-transform: none; font-family: Tahoma, Georgia, Serif;padding: 6px!important; " data-toggle="modal" data-placement="left" title="Print" ><i class="fa fa-print"></i> Print Report</button>
                                                                    <button class="btn btn-green" id="btn_export" style="text-transform: none; font-family: Tahoma, Georgia, Serif; padding: 6px!important;" data-toggle="modal" data-placement="left" title="Export" ><i class="fa fa-file-excel-o"></i> Export</button>
                                                                    <button class="btn btn-green" id="btn_email" style="text-transform: none; font-family: Tahoma, Georgia, Serif; padding: 6px!important;" data-toggle="modal" data-placement="left" title="Email" ><i class="fa fa-share"></i> Email</button>
                                                                    <button class="btn btn-success" id="btn_refresh" style="text-transform: none; font-family: Tahoma, Georgia, Serif; padding: 6px!important;" data-toggle="modal" data-placement="left" title="Reload" ><i class="fa fa-refresh"></i></button>
                                                                </div>
                                                                <div class="col-lg-3">
                                                                    Search :<br />
                                                                     <input type="text" id="searchbox_connection" class="form-control">
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <br />

                                                        <div>
                                                            <table id="tbl_monthly_connection" class="table table-striped" cellspacing="0" width="100%">
                                                                <thead class="">
                                                                <tr>
                                                                    <th>Service No</th>
                                                                    <th>Account No</th>
                                                                    <th>Customer</th>
                                                                    <th>Address</th>
                                                                    <th>Meter Serial</th>
                                                                    <th>Service Date</th>
                                                                    <th>Installation Date</th>
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
        var _cboMonths; var _cboYears;var dt;
        var monthNow = new Date().getMonth() + 1;
        var yearNow = new Date().getFullYear();

        var initializeControls=function(){

            _cboMonths=$("#cbo_months").select2({
                placeholder: "Please select month.",
                allowClear: false
            });

            _cboMonths.select2('val',monthNow);

            _cboYears=$("#cbo_year").select2({
                placeholder: "Please select year.",
                allowClear: false
            });

            _cboYears.select2('val',yearNow);

            $('.date-picker').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true

            });

            dt=$('#tbl_monthly_connection').DataTable({
                "dom": '<"toolbar">frtip',
                "bLengthChange":false,
                "bPaginate":false,
                "ajax": {
                    "url": "Monthly_connection/transaction/list",
                    "type": "GET",
                    "bDestroy": true,
                    "data": function ( d ) {
                        return $.extend( {}, d, {
                            "month_id" : _cboMonths.select2('val'),
                            "year" : _cboYears.select2('val')
                        });
                    }
                },
                "columns": [
                    { targets:[0],data: "service_no" },
                    { targets:[1],data: "account_no" },
                    { targets:[2],data: "receipt_name" },
                    { targets:[3],data: "address" },
                    { targets:[4],data: "serial_no" },
                    { targets:[5],data: "service_date" },
                    { targets:[6],data: "installation_date" }
                ]

                ,
                "rowCallBack": function(a,b,c){
                    console.log(b);
                }

            });

        }();

        var bindEventControls=function(){

            $("#searchbox_connection").keyup(function(){         
                dt
                    .search(this.value)
                    .draw();
            });

            _cboMonths.on("select2:select", function (e) {
                $('#tbl_monthly_connection tbody').html('<tr><td colspan="7"><center><br/><img src="assets/img/loader/ajax-loader-lg.gif" /><br /><br /></center></td></tr>');
                dt.ajax.reload();
            });

            _cboYears.on("select2:select", function (e) {
                $('#tbl_monthly_connection tbody').html('<tr><td colspan="7"><center><br/><img src="assets/img/loader/ajax-loader-lg.gif" /><br /><br /></center></td></tr>');
                dt.ajax.reload();
            });

            $(document).on('click','#btn_print',function(){
                window.open('Templates/layout/monthly_connection?type=preview&month_id='+_cboMonths.val()+'&year='+_cboYears.val());

            });

            $(document).on('click','#btn_export',function(){
                window.open('Templates/layout/monthly_connection_export?type=preview&month_id='+_cboMonths.val()+'&year='+_cboYears.val());

            });

            $(document).on('click','#btn_email',function(){
                showNotification({title:"Sending!",stat:"info",msg:"Please wait for a few seconds."});

                var btn=$(this);
            
                $.ajax({
                    "dataType":"json",
                    "type":"POST",
                    "url":"Templates/layout/monthly_connection_email?type=preview&month_id="+_cboMonths.val()+'&year='+_cboYears.val(),
                    "beforeSend": showSpinningProgress(btn)
                }).done(function(response){
                    showNotification(response);
                    showSpinningProgress(btn);

                });
            });

            $(document).on('click','#btn_refresh',function(){
                $('#tbl_monthly_connection tbody').html('<tr><td colspan="7"><center><br/><img src="assets/img/loader/ajax-loader-lg.gif" /><br /><br /></center></td></tr>');
                dt.ajax.reload();
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

    });
</script>
</body>
</html>