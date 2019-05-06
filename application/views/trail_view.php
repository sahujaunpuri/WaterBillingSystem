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
    var _section_id; var _menu_id; var _trans_key_id; var _user_id;
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
            "order": [[ 5, "asc" ]],
             "searching": false,
            // "scrollX": true,
            "ajax": {
              "url":"Trail/transaction/list",
              "type":"GET",
              // "order": [[ 6, "desc" ]],
              "data":function (d) {
                return $.extend( {}, d, {
                    "user_id": $('#user_id').val(),
                    "trans_type_id": $('#trans_type_id').val(),
                    "trans_key_id": $('#trans_key_id').val(),
                    "start_date": $('#start_date').val(),
                    "end_date": $('#end_date').val()
                });
              }
            },
            "columns": [

                { targets:[0],data: "trans_date" },
                { targets:[1],data: "trans_type_desc" },
                { targets:[2],data: "trans_key_desc" },
                { targets:[3],data: "trans_log" },
                { targets:[4], data: null, render: function ( data, type, row ) {
                // Combine the first and last names into a single table field
                if(data.user_fname!== null){
                    return data.user_fname+' '+data.user_lname; // data to be rendered 
                }else{
                    return'';
                }

                } },
                { visible:false,targets:[5],data: "trans_id" }

            ],

            language: {
                         searchPlaceholder: "Search"
                     },
            "rowCallback":function( row, data, index ){

                // $(row).find('td').eq(4).attr({
                //     "align": "right"
                // });
            }


        });


        $('.date-picker').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true
        });

        _cboCategory=$('#trans_type_id').select2({
            allowClear: false
        });


        _trans_key_id=$('#trans_key_id').select2({
            allowClear: false
        });


        _user_id=$('#user_id').select2({
            allowClear: false
        });


      
    }();
    
        

    var bindEventHandlers=(function(){
        $("#trans_type_id").on("change", function () {        
            $('#tbl_products').DataTable().ajax.reload()
        });
        $("#user_id").on("change", function () {        
            $('#tbl_products').DataTable().ajax.reload()
        });
        $("#trans_key_id").on("change", function () {        
            $('#tbl_products').DataTable().ajax.reload()
        });
        $("#end_date").on("change", function () {        
            $('#tbl_products').DataTable().ajax.reload()
        });
        $("#start_date").on("change", function () {        
            $('#tbl_products').DataTable().ajax.reload()
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
                        <li><a href="Trail" id="filter">Audit Trail</a></li>
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
                                            <h2 class="h2-panel-heading">Audit Trail</h2><hr>
                                                <div class="row">
                                                <div class="col-sm-3" >
                                                    Transaction Type :
                                                    <select name="" id="trans_type_id" required>
                                                        <option value="">All Transaction Types</option>
                                                        <?php foreach($trans_type as $row) { echo '<option value="'.$row->trans_type_id.'">'.$row->trans_type_desc.'</option>'; } ?>
                                                    </select>

                                                </div>
                                                <div class="col-sm-2" >
                                                    Record Type :
                                                    <select name="" id="trans_key_id"  required>
                                                        <option value="">All Record Types</option>
                                                        <?php foreach($trans_key as $row) { echo '<option value="'.$row->trans_key_id.'">'.$row->trans_key_desc.'</option>'; } ?>
                                                    </select>

                                                </div>
                                                <div class="col-sm-3" >
                                                    User Account:
                                                    <select name="" id="user_id"  required>
                                                        <option value="">All User Accounts</option>
                                                        <option value="0">User Login Attempts</option>
                                                        <?php foreach($users as $row) { echo '<option value="'.$row->user_id.'">'.$row->full_name.'</option>'; } ?>
                                                    </select>

                                                </div>
                                                <div class="col-sm-2">
                                                    From :
                                                    <div class="input-group">
                                                        <input type="text" name="start_date" id="start_date" class="date-picker form-control" value="01/01/<?php echo date("Y"); ?>" placeholder="Date" data-error-msg="Please set the date." required>
                                                         <span class="input-group-addon">
                                                             <i class="fa fa-calendar"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">
                                                    To :
                                                    <div class="input-group">
                                                        <input type="text" name="end_date" id="end_date" class="date-picker form-control" value="<?php echo date("m/d/Y"); ?>" placeholder="Date" data-error-msg="Please set the date." required>
                                                         <span class="input-group-addon">
                                                             <i class="fa fa-calendar"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                                <br>
                                                </div><br>
                                                <div class="row">
       <!--                                              <div class="col-sm-2">
                                                        <button class="btn btn-primary pull-left" style="margin-right: 5px; margin-top: 10px; margin-bottom: 10px;" id="btn_print" style="text-transform: none; font-family: Tahoma, Georgia, Serif; " title="Print" ><i class="fa fa-print"></i> Print Report
                                                        </button>
                                                    </div> -->
                                                   <!--  <div class="col-sm-2">
                                                        <button class="btn btn-success pull-left" style="margin-right: 5px; margin-top: 10px; margin-bottom: 10px;" id="btn_excel" style="text-transform: none; font-family: Tahoma, Georgia, Serif; " title="Export to Excel" ><i class="fa fa-file-excel-o"></i> Excel Report
                                                        </button>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <button class="btn btn-success pull-left" style="margin-right: 5px; margin-top: 10px; margin-bottom: 10px;" id="btn_email" style="text-transform: none; font-family: Tahoma, Georgia, Serif; " title="Export to Excel" ><span class=""></span> <i class="fa fa-file-excel-o"></i> Email Report
                                                        </button>
                                                    </div> -->
                                                </div>
                                                <table id="tbl_products" class="table table-striped" cellspacing="0" width="100%">
                                                    <thead class="">
                                                    <tr>    
                                                        <th width="15%">Transaction Date</th>
                                                        <th width="15%">Transaction Type</th>
                                                        <th width="10%">Record Type</th>
                                                        <th>Log Description</th>
                                                        <th>User</th>
                                                        <th>Transaction ID</th>
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