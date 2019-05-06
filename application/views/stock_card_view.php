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

    <?php echo $_def_js_files; ?>

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

        .group-heading-soa {
            background-color: #bcf6ff;
        }

        .hidden{
            display: none;
        }
        table thead tr th {
            font-weight: bold;
        }
        .class-title{
            font-weight: bold;
        }
        .ellipsis {
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }
    </style>
    <?php echo $_def_css_files; ?>

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
                        <li><a href="stock_card">Stock Card / Bin Card</a></li>
                    </ol>
                    <div class="container-fluid">
                        <div class="panel panel-default">
                            <!-- <div class="panel-heading">
                                <b style="color: white; font-size: 12pt;"><i class="fa fa-bars"></i>&nbsp; Statement of Account</b>
                            </div> -->
                            <div class="panel-body">
                                <h2 style="margin-bottom: 30px;">Stock Card / Bin Card</h1><hr>
                                <div class="row container-fluid">
                                        <div class="col-xs-12 col-sm-6">
                                            <label><b class="required">*</b> Product :</label><br>
                                            <select id="cbo_product" class="form-control" style="width: 100%">
                                                <?php foreach($products as $product) { ?>
                                                    <option value="<?php echo $product->product_id; ?>" data-bulk="<?php echo $product->is_bulk; ?>">
                                                        <?php echo $product->product_desc; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-xs-4 col-sm-2">
                                            <label><b class="required">*</b> Category</label><br>
                                            <select id="cbo_cat" class="form-control" style="width: 100%">
                                                    <option value="bulk" id="bulk">Bulk</option>
                                                    <option value="retail" id="retail">Retail</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-4 col-sm-2"><br><br>
                                            <button id="btn_print" class="btn btn-primary btn-block" style="margin-top: 5px;vertical-align: middle;"><i class="fa fa-print"></i> Print Report</button>
                                        </div>
                                        <div class="col-xs-4 col-sm-2"><br><br>
                                            <button id="btn_export" class="btn btn-success btn-block" style="margin-top: 5px;"><i class="fa fa-file-excel-o"></i> Export</button>
                                        </div>

                                </div><br>
                                <div class="container-fluid">
                                <table style="width: 100%" class="table table-striped">
                                    <tr>
                                        <td style="width: 15%;" class="class-title">Product Code</td>
                                        <td style="width: 35%;" id="product_code"></td>
                                        <td  style="width: 15%;" class="class-title">Purchase Cost</td>
                                        <td  style="width: 35%;" id="purchase_cost"></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 15%;" class="class-title">Product Description</td>
                                        <td style="width: 35%;" id="product_desc"></td>

                                        <td  style="width: 15%;" class="class-title">Suggested Retail Price</td>
                                        <td  style="width: 35%;" id="sale_price"></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 15%;" class="class-title">Unit of Measurement</td>
                                        <td style="width: 35%;" id="unit_of_measurement"></td>

                                        <td  style="width: 15%;" class="class-title"></td>
                                        <td  style="width: 35%;" id=""></td>
                                    </tr>
                                </table>
                                <table id="tbl_stock" class="table table-striped" style="width: 100%;,margin-top: 20px;">
                                <thead>
                                    <tr>
                                        <th style="width: 10%;">Date</th>
                                        <th style="width: 20%;">Document No.</th>
                                        <th style="width: 10%;text-align: right;font-weight: bold;">IN</th>
                                        <th style="width: 10%;text-align: right;font-weight: bold;">OUT</th>
                                        <th style="width: 10%;text-align: right;font-weight: bold;">Balance</th>
                                        <th style="text-align: left;width: 15%;">Location</th>
                                        <th style="text-align: left;width: 25%">Remarks</th>
                                    </tr>
                                </thead>
                                    <tbody id="parent" style="width: 100%;">

                                    </tbody>
                                </table>
                                </div>
                                </div>
                                <div class="row">   
                                    <div class="container-fluid">
                                    </div>
                                </div>
                            </div>
                            <div class="panel-footer"></div>
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

<script src="assets/plugins/spinner/dist/spin.min.js"></script>
<script src="assets/plugins/spinner/dist/ladda.min.js"></script>
<!-- numeric formatter -->
<script src="assets/plugins/formatter/autoNumeric.js" type="text/javascript"></script>
<script src="assets/plugins/formatter/accounting.js" type="text/javascript"></script>
<script type="text/javascript" src="assets/plugins/datatables/jquery.dataTables.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/dataTables.bootstrap.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/ellipsis.js"></script>
<script src="assets/plugins/select2/select2.full.min.js"></script>

<script>

$(document).ready(function(){
    var _cboProduct;
    var _cboCat;
    var initializeControls=function() {
        _cboProduct = $('#cbo_product').select2({
            searchPlaceholder: 'Select Product '
        });

        _cboCat = $('#cbo_cat').select2({
            minimumResultsForSearch : -1
        });


        reinitializeBalances();
    }();

    var bindEventHandlers=function(){
        _cboProduct.on('select2:select',function(){
            _cboCat.select2('val','bulk');
            reinitializeBalances();
        });

        $('#btn_print').click(function(){
            window.open('products/transaction/history-product?id='+_cboProduct.val()+'&type=stockcard_print&cat='+_cboCat.val())
        });;

        $('#btn_export').click(function(){
            window.open('products/Export_Stock?id='+_cboProduct.val()+'&type=stockcard_print&cat='+_cboCat.val())

        });

        _cboCat.on("select2:select", function (e) {
            reinitializeBalances();
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

    function reinitializeBalances() {   
        ii =  _cboProduct.val()
        var prodbulk=$('#cbo_product').find('option[value="' + ii + '"]');
        if(prodbulk.data('bulk') == 0 && _cboCat.val() == 'retail'){
            showNotification({title:"Error !",stat:"error",msg:"Retail Unit is not available with the chosen Product."});
            _cboCat.select2('val','bulk');
            // reinitializeBalances();
            return;
        }

        $('#tbl_stock #parent').html('');
        $.ajax({
            url : 'Products/transaction/history-product?id='+_cboProduct.val()+'&type=stockcard',
            type : "GET",
            cache : false,
            dataType : 'json',
            processData : false,
            contentType : false,
            success : function(response){


            if(_cboCat.val() == 'bulk'){
                    $('#unit_of_measurement').html(response.product_info.parent_unit_name);
                    $('#product_desc').html(response.product_info.product_desc);
                    $('#purchase_cost').html(accounting.formatNumber(response.product_info.purchase_cost,2));
                    $('#sale_price').html(accounting.formatNumber(response.product_info.sale_price,2));
                    $('#product_code').html(response.product_info.product_code);
                    $.each(response.products_parent, function(index,value){
                        $('#tbl_stock #parent').append(
                            '<tr>'+
                                '<td>'+value.txn_date+'</td>'+
                                '<td>'+value.ref_no+'</td>'+
                                '<td align="right">'+accounting.formatNumber(value.parent_in_qty,2)+'</td>'+
                                '<td align="right">'+accounting.formatNumber(value.parent_out_qty,2)+'</td>'+
                                '<td align="right">'+accounting.formatNumber(value.parent_balance,2)+'</td>'+
                                '<td>'+value.department_name+'</td>'+
                                '<td>'+value.remarks+'</td>'+
                            '</tr>'
                        );
                    });
            }else if (_cboCat.val() == 'retail'){
                $('#unit_of_measurement').html(response.product_info.child_unit_name);
                $('#product_desc').html(response.product_info.product_desc);
                $('#purchase_cost').html(accounting.formatNumber((response.product_info.purchase_cost / response.product_info.child_unit_desc),2))
                $('#sale_price').html(accounting.formatNumber((response.product_info.sale_price / response.product_info.child_unit_desc),2));
                $('#product_code').html(response.product_info.product_code);
                $.each(response.products_child, function(index,value){
                    $('#tbl_stock #parent').append(
                        '<tr>'+
                            '<td>'+value.txn_date+'</td>'+
                            '<td>'+value.ref_no+'</td>'+
                            '<td align="right">'+accounting.formatNumber(value.child_in_qty,2)+'</td>'+
                            '<td align="right">'+accounting.formatNumber(value.child_out_qty,2)+'</td>'+
                            '<td align="right">'+accounting.formatNumber(value.child_balance,2)+'</td>'+
                            '<td>'+value.department_name+'</td>'+
                            '<td>'+value.remarks+'</td>'+
                        '</tr>'
                    );
                });
            }




            }

        });
    };
});

</script>

</body>

</html>