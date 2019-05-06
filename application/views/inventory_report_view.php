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

        #tbl_entries td,#tbl_entries tr,#tbl_entries th{
            table-layout: fixed;
            border: 1px solid gray;
            border-collapse: collapse;
        }

        body {
            overflow-x: hidden;
        }
        .right-align{
            text-align: right;
        }
        #tbl_inventory td:nth-child(6){
            text-align: right;
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
        .select2-container{
            min-width: 100%;
            z-index: 999999999;
        }
        @keyframes spin {
            from { transform: scale(1) rotate(0deg); }
            to { transform: scale(1) rotate(360deg); }
        }

        @-webkit-keyframes spin2 {
            from { -webkit-transform: rotate(0deg); }
            to { -webkit-transform: rotate(360deg); }
        }


        .custom_frame{

            border: 1px solid lightgray;
            margin: 1% 1% 1% 1%;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            border-radius: 5px;
        }

        .numeric{
            text-align: right;
        }

        .boldlabel {
            font-weight: bold;
        }

        .modal-body {
            padding-left:0px !important;
        }

        .form-group {
            padding:0;
            margin:5px;
        }

        .input-group {
            padding:0;
            margin:0;
        }

        textarea {
            resize: none;
        }

        .modal-body p {
            margin-left: 20px !important;
        }

        #img_user {
            padding-bottom: 15px;
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
                        <li><a href="Inventory">Inventory Report</a></li>
                    </ol>

                    <div class="container-fluid">
                        <div data-widget-group="group1">
                            <div class="row">
                                <div class="col-md-12">

                                    <div id="div_payable_list">

                                        <div class="panel-group panel-default" id="accordionA">


                                            <div class="panel panel-default" style="border-radius: 0px;">
                                               <!--  <a data-toggle="collapse" data-parent="#accordionA" href="#collapseTwo"><div class="panel-heading" style="background: #2ecc71;border-bottom: 1px solid lightgrey;;"><b style="color:white;font-size: 12pt;><i class="fa fa-bars"></i> Inventory Report</b></div></a> -->
                                                <div id="collapseTwo" class="collapse in">
                                                    <div class="panel-body">
                                                    <h2 class="h2-panel-heading">Inventory Report</h2><hr>

                                                            <div class="row">
                                                                <div class="col-lg-6">
                                                                    Department * : <br />
                                                                    <select id="cbo_department" class="form-control">
                                                                        <option value="0">All Department</option>
                                                                        <?php foreach($departments as $department){ ?>
                                                                            <option value="<?php echo $department->department_id; ?>"><?php echo $department->department_name; ?></option>
                                                                        <?php } ?>
                                                                    </select>

                                                                </div>
                                                                <div class="col-lg-3">
                                                                    Current Count :<br />
                                                                    <select id="cbo_current_count" class="form-control">
                                                                        <option value="1">All</option>
                                                                        <option value="2">Greater than Zero</option>
                                                                        <option value="3">Less than Zero</option>
                                                                        <option value="4">Equal to Zero</option>

                                                                    </select>
                                                                </div>
                                                                <div class="col-lg-3">
                                                                    As of Date * :<br />
                                                                    <div class="input-group">
                                                                        <input type="text" id="txt_date" name="date_txn" class="date-picker form-control" value="<?php echo date("m/d/Y"); ?>">
                                                                         <span class="input-group-addon">
                                                                                <i class="fa fa-calendar"></i>
                                                                         </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <br />

                                                        <div >
                                                            <table id="tbl_inventory" class="table table-striped" cellspacing="0" width="100%">
                                                                <thead class="">
                                                                <tr>
                                                                    <th width="5%"></th>
                                                                    <th width="15%">PLU</th>
                                                                    <th width="40%">Product</th>
                                                                    <th width="20%">Category</th>
                                                                    <th width="10%">Unit</th>
                                                                    <th width="10%" style="text-align: right">Qty</th>
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
        var dt; var _cboDepartment;


        var initializeControls=function(){

            $('.date-picker').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true

            });
            _cboDepartment=$("#cbo_department").select2({
            placeholder: "Choose Department",
            allowClear: false
            });
            _cboCurrentCount=$("#cbo_current_count").select2({
            placeholder: "Choose Count Filter",
            allowClear: false,
            minimumResultsForSearch: -1
            });
            _cboCurrentCount.select2("val", 1);
            reloadList();

            createToolBarButton();



        }();

        var bindEventControls=function(){
            var detailRows = [];


            $('.date-picker').on('change',function(){
                dt.clear().draw();
                dt.destroy();
                reloadList();
                createToolBarButton();
            });

            $('#cbo_department').on('change',function(){
                dt.clear().draw();
                dt.destroy();
                reloadList();
                createToolBarButton();
            });

            _cboCurrentCount.on('select2:select',function(e){
                dt.clear().draw();
                dt.destroy();
                reloadList();
                createToolBarButton();
            });
            $(document).on('click','#btn_print',function(){
                window.open('Inventory/transaction/preview-inventory?depid='+$('#cbo_department').val()+'&date='+$('#txt_date').val()+'&ccf='+$('#cbo_current_count').val());
            });


            $(document).on('click','#btn_export',function(){
                window.open('Inventory/transaction/export-inventory?depid='+$('#cbo_department').val()+'&date='+$('#txt_date').val()+'&ccf='+$('#cbo_current_count').val());
            });

            $(document).on('click','#btn_email',function(){
                showNotification({title:"Sending!",stat:"info",msg:"Please wait for a few seconds."});

                var btn=$(this);
            
                $.ajax({
                    "dataType":"json",
                    "type":"POST",
                    "url":'Inventory/transaction/email-inventory?depid='+$('#cbo_department').val()+'&date='+$('#txt_date').val()+'&ccf='+$('#cbo_current_count').val(),
                    "beforeSend": showSpinningProgress(btn)
                }).done(function(response){
                    showNotification(response);
                    showSpinningProgress(btn);

                });   
            });

            $(document).on('click','#btn_refresh',function(){
                dt.clear().draw();
                dt.destroy();
                reloadList();
                createToolBarButton();
            });


            $('#tbl_inventory tbody').on( 'click', 'tr td.details-control', function () {

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
                    var d=row.data();


                    $.ajax({
                        "dataType":"html",
                        "type":"POST",
                        "url":"Products/transaction/product-history?id="+ d.product_id+"&depid="+$('#cbo_department').val()+"&date="+$('#txt_date').val(),
                        "beforeSend" : function(){
                            row.child( '<center><br /><img src="assets/img/loader/ajax-loader-lg.gif" /><br /><br /></center>' ).show();
                        }
                    }).done(function(response){
                        row.child( response,'no-padding' ).show();
                        if ( idx === -1 ) {
                            detailRows.push( tr.attr('id') );
                        }
                    });
                }
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

        function createToolBarButton(){
            var _btnPrint='<button class="btn btn-primary" id="btn_print" style="text-transform: none; font-family: Tahoma, Georgia, Serif; " data-toggle="modal" data-target="#salesInvoice" data-placement="left" title="Print" >'+
                '<i class="fa fa-print"></i> Print Report</button>';

            var _btnExport='<button class="btn btn-success" id="btn_export" style="text-transform: none; font-family: Tahoma, Georgia, Serif; " data-toggle="modal" data-target="#salesInvoice" data-placement="left" title="Export" >'+
                '<i class="fa fa-file-excel-o"></i> Export</button>';

            var _btnEmail='<button class="btn btn-success" id="btn_email" style="text-transform: none; font-family: Tahoma, Georgia, Serif; " data-toggle="modal" data-target="#salesInvoice" data-placement="left" title="Email" >'+
                '<i class="fa fa-share"></i> Email</button>';

            var _btnRefresh='<button class="btn btn-green" id="btn_refresh" style="text-transform: none; font-family: Tahoma, Georgia, Serif; " data-toggle="modal" data-target="#salesInvoice" data-placement="left" title="Reload" >'+
                '<i class="fa fa-refresh"></i></button>';

            $("div.toolbar").html(_btnPrint+"&nbsp;"+_btnExport+"&nbsp;"+_btnEmail+"&nbsp;"+_btnRefresh);
        };





        function reloadList(){

            dt=$('#tbl_inventory').DataTable({
                "dom": '<"toolbar">frtip',
                "bLengthChange":false,
                "bPaginate":false,
                "ajax": {
                    "url": "Inventory/transaction/get-inventory",
                    "type": "POST",
                    "bDestroy": true,
                    "data": function ( d ) {
                        return $.extend( {}, d, {
                            "depid": $('#cbo_department').val(),
                            "date" : $('#txt_date').val(),
                            "ccf" : $('#cbo_current_count').val()

                        });
                    }
                },
                "columns": [
                    {   
                        "targets": [0],
                        "class":          "details-control",
                        "orderable":      false,
                        "data":           null,
                        "defaultContent": ""
                    },
                    { targets:[1],data: "product_code" },
                    { targets:[2],data: "product_desc" },
                    { targets:[3],data: "category_name" },
                    { targets:[4],data: "parent_unit_name" },
                    {
                        targets:[5], sClass:'right-align',
                        data: "CurrentQty",
                        render: function(data, type, full, meta){
                            return '<b>'+accounting.formatNumber(data,2)+'</b>';
                        }

                    }

                ]

                ,
                "rowCallBack": function(a,b,c){
                    console.log(b);
                }

            });
        };



    });
</script>


</body>

</html>