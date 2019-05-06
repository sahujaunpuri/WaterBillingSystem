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


    <!--<link href="assets/dropdown-enhance/dist/css/bootstrar-select.min.css" rel="stylesheet" type="text/css">-->

    <link href="assets/plugins/datapicker/datepicker3.css" rel="stylesheet">


    <link type="text/css" href="assets/plugins/iCheck/skins/minimal/blue.css" rel="stylesheet">              <!-- iCheck -->
    <link type="text/css" href="assets/plugins/iCheck/skins/minimal/_all.css" rel="stylesheet">    
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
        .right-align{text-align: right;}
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
                        <li><a href="Cost_of_goods_sold">Cost of Goods Sold</a></li>
                    </ol>

                    <div class="container-fluid">
                        <div data-widget-group="group1">
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="div_department_list">
                                        <div class="panel panel-default">
                                            <div class="panel-body table-responsive">
                                            <h2 class="h2-panel-heading">Cost of Goods Sold</h2><hr>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    Department * : <br />
                                                    <select id="cbo_departments" class="form-control" style="width: 100%;">
                                                        <?php foreach($departments as $department){ ?>
                                                            <option value="<?php echo $department->department_id; ?>"><?php echo $department->department_name; ?></option>
                                                        <?php } ?>
                                                    </select>

                                                </div>
                                                <div class="col-lg-3">
                                                        From :<br />
                                                        <div class="input-group">
                                                            <input type="text" id="txt_start_date" name="" class="date-picker form-control" value="01/01/<?php echo date("Y"); ?>">
                                                             <span class="input-group-addon">
                                                                    <i class="fa fa-calendar"></i>
                                                             </span>
                                                        </div>
                                                </div>
                                                <div class="col-lg-3">
                                                        To :<br />
                                                        <div class="input-group">
                                                            <input type="text" id="txt_end_date" name="" class="date-picker form-control" value="<?php echo date("m/t/Y"); ?>">
                                                             <span class="input-group-addon">
                                                                    <i class="fa fa-calendar"></i>
                                                             </span>
                                                        </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                            <br>
                                            <div class="col-sm-12">
                                            <button id="btn_refresh" class="btn btn-green" style="text-transform: none;margin-left: 5px;color: white;"><i class="fa fa-refresh"></i> Refresh</button>
                                            <button id="btn_print" class="btn btn-primary" style="text-transform: none;"><i class="fa fa-print"></i> Print Report</button>
                                            </div>
                                            <br>
                                            <hr>
                                            <div class="col-sm-12">
                                                <table style="width: 100%;border:none!important;">
                                                    <tbody>
                                                        <tr>
                                                            <td style="width: 80%"><h4 style="font-weight: bold;">Merchandise Inventory - Beginning</h4><i> Beginning Inventory of Period <span class="period_start"></span> to <span class="period_end"></span></i> </td>
                                                            <td style="width: 20%;background: #3fc2ff!important;text-align: right;font-size: 20px;color: white;padding:5px;" class="total_avg_cost">0.00</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <br>
                                                <table class="table table-striped" id="tbl_merchandise_beginning" cellspacing="0" width="100%"> 
                                                    <thead>
                                                        <tr>
                                                            <th >Product Description</th>
                                                            <th >On Hand</th>
                                                            <th >Average Cost</th>
                                                            <th >Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tfoot>
                                                    <tr>
                                                        <td colspan="3" style="text-align: left;"><b>Merchandise Inventory - Beginning :</b></td>
                                                        <td colspan="1" align="right"><b class="total_avg_cost">0.00</b></td>
                                                    </tr>

                                                    </tfoot>
                                                </table>
                                            </div>
                                            <div class="col-sm-12">
                                                <table style="width: 100%;border:none!important;">
                                                    <tbody>
                                                        <tr>
                                                            <td style="width: 80%"><h4 style="font-weight: bold;"><small>Add:</small> Purchases</h4><i> Purchase Invoice of Period <span class="period_start"></span> to <span class="period_end"></span></i> </td>
                                                            <td style="width: 20%;background: #3fc2ff!important;text-align: right;font-size: 20px;color: white;padding:5px;" class="total_purchases">0.00</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <br>
                                                <table class="table table-striped" id="tbl_purchases" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>Invoice #</th>
                                                            <th>Date</th>
                                                            <th>Supplier</th>
                                                            <th>Product</th>
                                                            <th>Qty</th>
                                                            <th>Cost</th>
                                                            <th>Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tfoot>
                                                    <tr>
                                                        <td colspan="5" style="text-align: left;"><b>Add : Total Purchases</b></td>
                                                        <td colspan="2" align="right"><b class="total_purchases">0.00</b></td>
                                                    </tr>

                                                    </tfoot>
                                                </table>
                                            </div>
                                            <div class="col-sm-12">
                                                <table style="width: 100%;border:none!important;">
                                                    <tbody>
                                                        <tr>
                                                            <td style="width: 80%;text-align:right;padding-right: 10px;"><h4 style="font-weight: bold;">Total Goods Available for Sale: </h4><i>( Merchandise Inventory [Beginning] + Purchases )</i> </td>
                                                            <td style="width: 20%;background: #3fc2ff!important;text-align: right;font-size: 20px;color: white;padding:5px;" class="total_available_goods">0.00</td>
                                                        </tr>
                                                    </tbody>
                                                </table><br>
                                                <table style="width: 100%;border:none!important;">
                                                    <tbody>
                                                        <tr>
                                                            <td style="width: 80%"><h4 style="font-weight: bold;"><small>Less:</small> Merchandise Inventory - End</h4><i> Inventory of Period <span class="period_start"></span> to <span class="period_end"></span></i> </td>
                                                            <td style="width: 20%;background: #3fc2ff!important;text-align: right;font-size: 20px;color: white;padding:5px;" class="total_avg_cost_ending">0.00</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <br>
                                                <table class="table table-striped" cellspacing="0" width="100%" id="tbl_ending_inventory">
                                                    <thead>
                                                        <tr>
                                                            <th>Product Description</th>
                                                            <th>On Hand</th>
                                                            <th>Average Cost</th>
                                                            <th>Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tfoot>
                                                    <tr>
                                                        <td colspan="3" style="text-align: left;"><b>Merchandise Inventory - Ending :</b></td>
                                                        <td colspan="1" align="right"><b class="total_avg_cost_ending">0.00</b></td>
                                                    </tr>

                                                    </tfoot>
                                                </table>
                                                <br>
                                                <table style="width: 100%;border:none!important;">
                                                    <tbody>
                                                        <tr>
                                                            <td style="width: 80%;text-align:right;padding-right: 10px;"><h4 style="font-weight: bold;">Cost of Goods Sold: </h4><i>Period <span class="period_start"></span> to <span class="period_end"></span></i> </td>
                                                            <td style="width: 20%;background: #3fc2ff!important;text-align: right;font-size: 20px;color: white;padding:5px;" class="total_cost_of_goods_sold">0.00</td>
                                                        </tr>
                                                    </tbody>
                                                </table><br>
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

<script src="assets/plugins/spinner/dist/spin.min.js"></script>
<script src="assets/plugins/spinner/dist/ladda.min.js"></script>

<script src="assets/plugins/select2/select2.full.min.js"></script>
<script src="assets/plugins/formatter/autoNumeric.js" type="text/javascript"></script>
<script src="assets/plugins/formatter/accounting.js" type="text/javascript"></script>
<script type="text/javascript" src="assets/plugins/datatables/jquery.dataTables.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/dataTables.bootstrap.js"></script>
<script src="assets/plugins/datapicker/bootstrap-datepicker.js"></script>
<script>

$(document).ready(function(){
    var dt; var _txnMode; var _selectedID; var _cboDepartments; var dtPurchases;

    var initializeControls=function(){
        _cboDepartments=$("#cbo_departments").select2({
            allowClear: false
        });
        $('.date-picker').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true

        });
        $('.period_start').text($('#txt_start_date').val());
        $('.period_end').text($('#txt_end_date').val());
        reloadInventoryCosting();
        reloadPurchases();
        reloadInventoryCostingEnding();

    }();

    var bindEventHandlers=(function(){
        _cboDepartments.on('select2:select',function(){
            reloadList();
        });

        $("#txt_start_date,#txt_end_date").on("change", function () { 
        $('.period_start').text($('#txt_start_date').val());
        $('.period_end').text($('#txt_end_date').val());       
            reloadList();
        });

        $("#btn_refresh").on("click", function () {    
            reloadList();
        });

        $("#btn_print").on("click", function () {    
           window.open('Cost_of_goods_sold/transaction/cogs-print?depid='+_cboDepartments.select2('val')+'&start='+$('#txt_start_date').val()+'&end='+$('#txt_end_date').val());
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
        $(e).find('span').toggleClass('glyphicon glyphicon-refresh spinning');
    };

        function reloadList(){
            dtInventoryCosting.clear().draw();
            dtInventoryCosting.destroy();

            dtInventoryEndingCosting.clear().draw();
            dtInventoryEndingCosting.destroy();

            dtPurchases.clear().draw();
            dtPurchases.destroy();

            reloadInventoryCosting();
            reloadPurchases();
            reloadInventoryCostingEnding();

            //reComputeCostOfGoodsSold();
        }


        function reloadPurchases(){
            dtPurchases=$('#tbl_purchases').DataTable({
                    "bLengthChange":false,
                    "language": {
                        "searchPlaceholder": "Search",
                        "loadingRecords": "<br /><center><img src='assets/img/loader/facebook.gif'></center><br />",
                        "emptyTable": "No records found on specified department and period"
                    },
                    "ajax": {
                        "url": "Cost_of_goods_sold/transaction/purchases",
                        "type": "GET",
                        "bDestroy": true,
                        "data": function ( d ) {
                            return $.extend( {}, d, {
                                "start":$('#txt_start_date').val(),
                                "end":$('#txt_end_date').val(),
                                "depid":$('#cbo_departments').val()
                            });
                        }
                    },
                    "columns": [
                        { targets:[0],data: "dr_invoice_no" },
                        { targets:[1],data: "delivered_date" },
                        { targets:[2],data: "supplier_name" },
                        { targets:[3],data: "product_desc" },
                        {  sClass:"right-align", targets:[4],data: "qty" , render: $.fn.dataTable.render.number( ',', '.', 2)},
                        { sClass:"right-align", targets:[5],data: "price", render: $.fn.dataTable.render.number( ',', '.', 2) },
                        { sClass:"right-align", targets:[6],data: "dr_line_total_price", render: $.fn.dataTable.render.number( ',', '.', 2) }

                    ],
                    "footerCallback": function ( row, data, start, end, display ) {
                        var api = this.api(), data;

                        // Remove the formatting to get integer data for summation
                        var intVal = function ( i ) {
                            return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                                typeof i === 'number' ?
                                    i : 0;
                        };

                        // Total over all pages
                        total = api
                            .column( 6 )
                            .data()
                            .reduce( function (a, b) {
                                return intVal(a) + intVal(b);
                            }, 0 );


                        $('.total_purchases').text(accounting.formatNumber(total,2));
                        reComputeCostOfGoodsSold();
                    }


                }
            );
        };
        function reloadInventoryCosting(){
            dtInventoryCosting=$('#tbl_merchandise_beginning').DataTable({
                    "bLengthChange":false,
                    "language": {
                        "searchPlaceholder": "Search",
                        "loadingRecords": "<br /><center><img src='assets/img/loader/facebook.gif'></center><br />",
                        "emptyTable": "No records found on specified department and period"
                    },
                    "ajax": {
                        "url": "Cost_of_goods_sold/transaction/merchandise-inventory-beginning",
                        "type": "GET",
                        "bDestroy": true,
                        "data": function ( d ) {
                            return $.extend( {}, d, {
                                "start":$('#txt_start_date').val(),
                                "end":$('#txt_end_date').val(),
                                "depid":$('#cbo_departments').val()
                            });
                        }
                    },
                    "columns": [
                        { targets:[0],data: "product_desc" },
                        {  sClass:"right-align", targets:[1],data: "balance" , render: $.fn.dataTable.render.number( ',', '.', 2)},
                        {  sClass:"right-align", targets:[2],data: "avg_cost" , render: $.fn.dataTable.render.number( ',', '.', 2)},
                        {  sClass:"right-align", targets:[3],data: "avg_net" , render: $.fn.dataTable.render.number( ',', '.', 2)},

                    ],

                    "footerCallback": function ( row, data, start, end, display ) {
                        var api = this.api(), data;

                        // Remove the formatting to get integer data for summation
                        var intVal = function ( i ) {
                            return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                                typeof i === 'number' ?
                                    i : 0;
                        };

                        // Total over all pages
                        total = api
                            .column( 3 )
                            .data()
                            .reduce( function (a, b) {
                                return intVal(a) + intVal(b);
                            }, 0 );


                        $('.total_avg_cost').text(accounting.formatNumber(total,2));
                        reComputeCostOfGoodsSold();
                    }


                }
            );
        };
        function reloadInventoryCostingEnding(){
            dtInventoryEndingCosting=$('#tbl_ending_inventory').DataTable({
                    "bLengthChange":false,
                    "language": {
                        "searchPlaceholder": "Search",
                        "loadingRecords": "<br /><center><img src='assets/img/loader/facebook.gif'></center><br />",
                        "emptyTable": "No records found on specified department and period"
                    },
                    "ajax": {
                        "url": "Cost_of_goods_sold/transaction/merchandise-inventory-ending",
                        "type": "GET",
                        "bDestroy": true,
                        "data": function ( d ) {
                            return $.extend( {}, d, {
                                "start":$('#txt_start_date').val(),
                                "end":$('#txt_end_date').val(),
                                "depid":$('#cbo_departments').val()
                            });
                        }
                    },
                    "columns": [
                        { targets:[0],data: "product_desc" },
                        {  sClass:"right-align", targets:[1],data: "balance" , render: $.fn.dataTable.render.number( ',', '.', 2)},
                        {  sClass:"right-align", targets:[2],data: "avg_cost" , render: $.fn.dataTable.render.number( ',', '.', 2)},
                        {  sClass:"right-align", targets:[3],data: "avg_net" , render: $.fn.dataTable.render.number( ',', '.', 2)},

                    ],

                    "footerCallback": function ( row, data, start, end, display ) {
                        var api = this.api(), data;

                        // Remove the formatting to get integer data for summation
                        var intVal = function ( i ) {
                            return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                                typeof i === 'number' ?
                                    i : 0;
                        };

                        // Total over all pages
                        total = api
                            .column( 3 )
                            .data()
                            .reduce( function (a, b) {
                                return intVal(a) + intVal(b);
                            }, 0 );


                        $('.total_avg_cost_ending').text(accounting.formatNumber(total,2));
                        reComputeCostOfGoodsSold();
                    }


                }
            );
        };

        function reComputeCostOfGoodsSold(){

            var totalInventoryBegin=getFloat($('.total_avg_cost').first().text());
            var totalPurchases=getFloat($('.total_purchases').first().text());

            var totalGoodsForSale=totalInventoryBegin+totalPurchases;
            $('.total_available_goods').text(accounting.formatNumber(totalGoodsForSale,2));

            var totalInventoryCostEnd=getFloat($('.total_avg_cost_ending').first().text());

            var cog=totalGoodsForSale-totalInventoryCostEnd;
            $('.total_cost_of_goods_sold').text(accounting.formatNumber(cog,2));

        };

        function getFloat(f){
            return parseFloat(accounting.unformat(f));
        };

});

</script>

</body>

</html>