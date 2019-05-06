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
    <link href="assets/plugins/datapicker/datepicker3.css" rel="stylesheet">
    <link href="assets/css/plugins/datapicker/datepicker3.css" rel="stylesheet">

    <?php echo $_switcher_settings; ?>
    <?php echo $_def_js_files; ?>


    <script type="text/javascript" src="assets/plugins/datatables/jquery.dataTables.js"></script>
    <script type="text/javascript" src="assets/plugins/datatables/dataTables.bootstrap.js"></script>


    <!-- Date range use moment.js same as full calendar plugin -->
    <script src="assets/plugins/fullcalendar/moment.min.js"></script>
    <!-- Data picker -->
    <script src="assets/plugins/datapicker/bootstrap-datepicker.js"></script>

    <!-- Select2 -->
    <script src="assets/plugins/select2/select2.full.min.js"></script>


    <!-- Date range use moment.js same as full calendar plugin -->
    <script src="assets/js/plugins/fullcalendar/moment.min.js"></script>
    <!-- Data picker -->
    <script src="assets/js/plugins/datapicker/bootstrap-datepicker.js"></script>

    <!-- twitter typehead -->
    <script src="assets/plugins/twittertypehead/handlebars.js"></script>
    <script src="assets/plugins/twittertypehead/bloodhound.min.js"></script>
    <script src="assets/plugins/twittertypehead/typeahead.bundle.min.js"></script>
    <script src="assets/plugins/twittertypehead/typeahead.jquery.min.js"></script>

    <!-- touchspin -->
    <script type="text/javascript" src="assets/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.js"></script>

    <!-- numeric formatter -->
    <script src="assets/plugins/formatter/autoNumeric.js" type="text/javascript"></script>
    <script src="assets/plugins/formatter/accounting.js" type="text/javascript"></script>

    <script>

$(document).ready(function(){
    var dt; var _txnMode; var _selectedID; var _selectRowObj; var _cboItemTypes; var _selectedProductType; var _isTaxExempt=0;
    var _cboSupplier; var _cboCategory; var _cboTax; var _cboInventory; var _cboMeasurement; var _cboCredit; var _cboDebit;
    var _cboTaxGroup;
    var _section_id; var _menu_id;
    /*$(document).ready(function(){
        $('#modal_filter').modal('show');
        showList(false);
    });*/

    var initializeControls=function() {
        dt=$('#tbl_products').DataTable({
            "fnInitComplete": function (oSettings, json) {
                // $.unblockUI();
                },
            "dom": '<"toolbar">frtip',
            "bLengthChange":false,
            "pageLength":15,
            "order": [[ 1, "asc" ]],
             "searching": false,
            // "scrollX": true,
            "ajax": {
              "url":"Product_list_report/transaction/list",
              "type":"GET",
              // "order": [[ 6, "desc" ]],
              "data":function (d) {
                return $.extend( {}, d, {
                    "cat": $('#product_category').val(),
                    "sup": $('#new_supplier').val(),
                    "inv": $('#cbo_item_type').val()
                });
              }
            },
            "columns": [
                { visible:false,
                    "targets": [0],
                    "class":          "details-control",
                    "orderable":      false,
                    "data":           null,
                    "defaultContent": ""
                },
                { targets:[1],data: "product_code" },
                { targets:[2],data: "product_desc" },
                { targets:[3],data: "product_desc1" },
                { targets:[4],data: "category_name" },
                { targets:[5],data: "supplier_name" },
                { targets:[6],data: "parent_unit_name" },
                { targets:[7],data: "item_type" },
                { targets:[8],data: "tax_rate" },
                { sClass:'right-align', targets:[9],data: "purchase_cost" , render: $.fn.dataTable.render.number( ',', '.', 2 ) },
                { sClass:'right-align', targets:[10],data: "sale_price", render: $.fn.dataTable.render.number( ',', '.', 2 ) },
                { sClass:'right-align', targets:[11],data: "product_warn", render: $.fn.dataTable.render.number( ',', '.', 2 ) },
                { sClass:'right-align', targets:[12],data: "product_ideal", render: $.fn.dataTable.render.number( ',', '.', 2 ) },
                { sClass:'right-align', targets:[13],data: "discounted_price", render: $.fn.dataTable.render.number( ',', '.', 2 ) },
                { sClass:'right-align', targets:[14],data: "dealer_price" , render: $.fn.dataTable.render.number( ',', '.', 2 ) },
                { sClass:'right-align', targets:[15],data: "distributor_price", render: $.fn.dataTable.render.number( ',', '.', 2 ) },
                { sClass:'right-align', targets:[16],data: "public_price" , render: $.fn.dataTable.render.number( ',', '.', 2 ) },
                { sClass:'right-align', visible:false,
                    targets:[4],data: "CurrentQty",
                    render: function (data, type, full, meta) {
                        if(isNaN(data)){
                            return 0;
                        }else{
                            return parseFloat(data);
                        }

                    }
                }
            ],

            language: {
                         searchPlaceholder: "Search Product Name"
                     },
            "rowCallback":function( row, data, index ){

                $(row).find('td').eq(4).attr({
                    "align": "right"
                });
            }


        });




        _cboCategory=$('#product_category').select2({
            allowClear: false
        });

        _cboCategory=$('#new_supplier').select2({
            allowClear: false
        });
        _cboItemTypes=$('#cbo_item_type').select2({
            allowClear: false
        });

      
    }();
    
        

    var bindEventHandlers=(function(){
        $("#new_supplier").on("change", function () {        
            $('#tbl_products').DataTable().ajax.reload()
        });
        $("#product_category").on("change", function () {        
            $('#tbl_products').DataTable().ajax.reload()
        });
        $("#cbo_item_type").on("change", function () {        
            $('#tbl_products').DataTable().ajax.reload()
        });

        $('#btn_print').click(function(){
            window.open('Product_list_report/transaction/report?sup='+$('#new_supplier').val()+'&cat='+$('#product_category').val()+'&inv='+$('#cbo_item_type').val());
        });

        $('#btn_excel').click(function(){
            window.open('Product_list_report/transaction/excel?sup='+$('#new_supplier').val()+'&cat='+$('#product_category').val()+'&inv='+$('#cbo_item_type').val());
        });
        $('#btn_email').on('click', function() {
        showNotification({title:"Sending!",stat:"info",msg:"Please wait for a few seconds."});

        var btn=$(this);
    
        $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":'Product_list_report/transaction/email?sup='+$('#new_supplier').val()+'&cat='+$('#product_category').val()+'&inv='+$('#cbo_item_type').val(),
            "beforeSend": showSpinningProgress(btn)
        }).done(function(response){
            showNotification(response);
            showSpinningProgress(btn);

        });
        });
    })();




    var showList=function(b){
        if(b){
            $('#div_product_list').show();
            $('#div_product_fields').hide();
        }else{
            $('#div_product_list').hide();
            $('#div_product_fields').show();
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



    var getFloat=function(f){
        return parseFloat(accounting.unformat(f));
    };


});

</script>

    <style>
        .right-align{
            text-align: right;
        }  
        .toolbar{
            float: left;
            margin-bottom: 0px !important;
            padding-bottom: 0px !important;
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
        }
        @keyframes spin {
            from { transform: scale(1) rotate(0deg); }
            to { transform: scale(1) rotate(360deg); }
        }

        @-webkit-keyframes spin2 {
            from { -webkit-transform: rotate(0deg); }
            to { -webkit-transform: rotate(360deg); }
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

                    <ol class="breadcrumb" style="margin:0%;">
                        <li><a href="dashboard">Dashboard</a></li>
                        <li><a href="Product_list_report" id="filter">Products List Report (Detailed)</a></li>
                    </ol>

                    <div class="container-fluid">
                        <div data-widget-group="group1">
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="div_product_list">
                                        <div class="panel panel-default">
<!--                                             <div class="panel-heading">
                                                <b style="color: white; font-size: 12pt;"><i class="fa fa-bars"></i>&nbsp; Products</b>
                                            </div> -->
                                            <div class="panel-body table-responsive" id="product_list_panel">
                                            <h2 class="h2-panel-heading">Product List Report (Detailed)</h2><hr>
                                                <div class="row">
                                                <div class="col-sm-3" >
                                                    Category :
                                                    <select name="category_id" id="product_category" data-error-msg="Category is required." required>
                                                        <option value="">All Categories</option>
                                                        <?php foreach($categories as $row) { echo '<option value="'.$row->category_id.'">'.$row->category_name.'</option>'; } ?>
                                                    </select>

                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group" style="margin-bottom:0px;">
                                                         Supplier :
                                                        <select name="supplier_id" id="new_supplier" data-error-msg="Supplier is required." required>
                                                            <option value="">All Suppliers</option>
                                                            <?php foreach($suppliers as $row) {   echo '<option value="'.$row->supplier_id.'">'.$row->supplier_name.'</option>';} ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group" style="margin-bottom:0px;">
                                                        Inventory type :

                                                        <select name="item_type_id" id="cbo_item_type" data-error-msg="Inverntory type is required." required>
                                                            <option value="">All Inventory Types</option>
                                                            <?php foreach($item_types as $item_type){ ?>
                                                                <option value="<?php echo $item_type->item_type_id ?>"><?php echo $item_type->item_type; ?></option>
                                                            <?php } ?>
                                                        </select>

                                                    </div>
                                                </div>
                                                <br>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-2">
                                                        <button class="btn btn-primary pull-left" style="margin-right: 5px; margin-top: 10px; margin-bottom: 10px;" id="btn_print" style="text-transform: none; font-family: Tahoma, Georgia, Serif; " title="Print" ><i class="fa fa-print"></i> Print Report
                                                        </button>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <button class="btn btn-success pull-left" style="margin-right: 5px; margin-top: 10px; margin-bottom: 10px;" id="btn_excel" style="text-transform: none; font-family: Tahoma, Georgia, Serif; " title="Export to Excel" ><i class="fa fa-file-excel-o"></i> Excel Report
                                                        </button>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <button class="btn btn-success pull-left" style="margin-right: 5px; margin-top: 10px; margin-bottom: 10px;" id="btn_email" style="text-transform: none; font-family: Tahoma, Georgia, Serif; " title="Export to Excel" ><span class=""></span>  <i class="fa fa-file-excel-o"></i> Email Report
                                                        </button>
                                                    </div>
                                                </div>
                                                <table id="tbl_products" class="table table-striped" cellspacing="0" width="100%">
                                                    <thead class="">
                                                    <tr>    
                                                        <th></th>
                                                        <th>PLU</th>
                                                        <th>Product Description</th>
                                                        <th>Other Description</th>
                                                        <th>Category</th>
                                                        <th>Supplier</th>
                                                        <th>Unit</th>
                                                        <th>Item Type</th>
                                                        <th>Tax Type</th>
                                                        <th>Purchase Cost</th>
                                                        <th>Sale Price </th>
                                                        <th>Warning QTY </th>
                                                        <th>Ideal Qty</th>
                                                        <th>Discounted Price</th>
                                                        <th>Dealer Price</th>
                                                        <th>Distributor Price</th>
                                                        <th>Public Price</th>


                                                        <th>On Hand</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>

                                                    </tbody>
                                                </table>
                                            </div>

                                            <div class="panel-footer" style="text-align: right;">
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
                        <li><h6 style="margin: 0;">&copy; 2017 - JDEV OFFICE SOLUTION</h6></li>
                    </ul>
                    <button class="pull-right btn btn-link btn-xs hidden-print" id="back-to-top"><i class="ti ti-arrow-up"></i></button>
                </div>
            </footer>

        </div>
    </div>
</div>





</body>

</html>