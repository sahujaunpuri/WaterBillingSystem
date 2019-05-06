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

        .select2-container {
            min-width: 100%;
            z-index: 999999999;
        }
        .right-align{
            text-align: right;
        }

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
                    <ol class="breadcrumb" style="margin:0;">
                        <li><a href="dashboard">Dashboard</a></li>
                        <li><a href="Purchase_history">Purchase History</a></li>
                    </ol>
                    <div class="container-fluid">
                        <div data-widget-group="group1">
                            <div class="row">
                                <div class="col-md-12">

                                    <div id="div_bar_list">
                                        <div class="panel panel-default">

                                            <div class="panel-body table-responsive">
                                            <h2 class="h2-panel-heading">Purchase History</h2><hr>
                                            <div class="row">
                                            <div class="col-sm-3">
                                                <b class="required">*</b> <label>Invoice Date From: </label>:<br />
                                                <div class="input-group">
                                                    <input id="from_date" type="text" class="date-picker form-control" value="<?php echo date("m"); ?>/01/<?php echo date("Y"); ?>">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <b class="required">*</b> <label>Invoice Date To: </label>:<br />
                                                <div class="input-group">
                                                    <input id="to_date" type="text" class="date-picker form-control" value="<?php echo date('m/d/Y'); ?>">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-3">
                                                <b class="required">*</b> <label>Supplier </label>:<br />
                                                <select name="supplier" id="supplier" >
                                                    <option value="0"> ALL</option>
                                                    <?php foreach($suppliers as $supplier){ ?>
                                                        <option value="<?php echo $supplier->supplier_id; ?>"><?php echo $supplier->supplier_name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="col-sm-3">
                                                <b class="required">*</b> <label>Departments </label>:<br />
                                                <select name="department" id="department" >
                                                    <option value="0"> ALL</option>
                                                    <?php foreach($departments as $department){ ?>
                                                        <option value="<?php echo $department->department_id; ?>"><?php echo $department->department_name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            </div>
<!--                                             <div class="col-sm-2">
                                                <button class="btn btn-primary pull-left" style="margin-right: 5px; margin-top: 10px; margin-bottom: 10px;" id="btn_print"  data-toggle="modal" data-target="#salesInvoice" data-placement="left" title="Print" ><i class="fa fa-print"></i> Print Report
                                            </button>
                                            </div>
                                            <div class="col-sm-2">
                                                <button class="btn btn-success pull-left" style="margin-right: 5px; margin-top: 10px; margin-bottom: 10px;" id="btn_excel" data-placement="left" title="Export to Excel" ><i class="fa fa-file-excel-o"></i> Export Report
                                            </button>
                                            </div>
                                            <div class="col-sm-2">
                                                <button class="btn btn-success pull-left" style="margin-right: 5px; margin-top: 10px; margin-bottom: 10px;" id="btn_email" data-placement="left" title="Sent to Email" ><span class=""></span> <i class="fa  fa-envelope-o"></i> Send Report
                                            </button>
                                            </div> -->
                                                <table id="tbl_delivery_invoice" class="table table-striped" cellspacing="0" width="100%">
                                                    <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>Invoice #</th>
                                                        <th>Supplier</th>
                                                        <th>Department</th>
                                                        <th>External Ref#</th>
                                                        <th>PO #</th>
                                                        <th>Terms</th>
                                                        <th>Delivered</th>
                                                        
                                                        <th></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="panel-footer"></div>
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
<script src="assets/plugins/select2/select2.full.min.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/jquery.dataTables.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/dataTables.bootstrap.js"></script>
<script src="assets/plugins/formatter/autoNumeric.js" type="text/javascript"></script>
<script src="assets/plugins/formatter/accounting.js" type="text/javascript"></script>

<script>

$(document).ready(function(){
    var dt; var _txnMode; var _selectedID; var _selectRowObj; var _cashier; var _supplier; var _department;

    var initializeControls=function(){
        dt=$('#tbl_delivery_invoice').DataTable({
            "dom": '<"toolbar">frtip',
            "order": [[ 8, "desc" ]],
            "bLengthChange":false,
            "ajax": {
              "url":"Purchase_history/transaction/delivery_list_count",
              "type":"GET",
              // "order": [[ 6, "desc" ]],
              "data":function (d) {
                return $.extend( {}, d, {
                    "frm": $('#from_date').val(),
                    "to": $('#to_date').val(),
                    "supplier": $('#supplier').val(),
                    "department": $('#department').val()
                });
              }
            },
            "language": {
                "searchPlaceholder":"Search"
            },
            "columns": [
                {
                    "targets": [0],
                    "class":          "details-control",
                    "orderable":      false,
                    "data":           null,
                    "defaultContent": ""
                },
                { targets:[1],data: "dr_invoice_no" },
                { targets:[2],data: "supplier_name" },
                {targets:[3],data: "department_name" },
                { targets:[4],data: "external_ref_no" },
                { targets:[5],data: "po_no" },
                { targets:[6],data: "term_description" },
                { targets:[7],data: "date_delivered" },
            
            { visible:false, targets:[8],data: "dr_invoice_id" }
            ]
        });

        _cashier=$('#cashier').select2({
            placeholder: "Please Select a Cashier",
            allopwClear: true
        });

        _supplier=$('#supplier').select2({
            placeholder: "Please Select a Supplier",
            allopwClear: true
        });

        _supplier=$('#department').select2({
            placeholder: "Please Select a Department",
            allopwClear: true
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

        $('#tbl_delivery_invoice tbody').on( 'click', 'tr td.details-control', function () {
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
                //console.log(row.data());
                var d=row.data();

                $.ajax({
                    "dataType":"html",
                    "type":"POST",
                    "url":"Templates/layout/dr/"+ d.dr_invoice_id,
                    "beforeSend" : function(){
                        row.child( '<center><br /><img src="assets/img/loader/ajax-loader-lg.gif" /><br /><br /></center>' ).show();
                    }
                }).done(function(response){
                    row.child( response,'no-padding' ).show();
                    // Add to the 'open' array
                    if ( idx === -1 ) {
                        detailRows.push( tr.attr('id') );
                    }
                });
            }
        } );


















        $('#from_date').change(function(){
            $('#tbl_delivery_invoice').DataTable().ajax.reload()          
        });
        $('#to_date').change(function(){
            $('#tbl_delivery_invoice').DataTable().ajax.reload()          
        });
        $('#department').change(function(){
            $('#tbl_delivery_invoice').DataTable().ajax.reload()          
        });
        $('#supplier').change(function(){
            $('#tbl_delivery_invoice').DataTable().ajax.reload()          
        });
        $('#btn_print').click(function(){
            window.open('Bar_sales_report/transaction/print?frm='+ $('#from_date').val() +'&to='+ $('#to_date').val()+'&cashier='+ $('#cashier').val()+'&type=contentview');
        });
        $('#btn_excel').click(function(){
            window.open('Bar_sales_report/transaction/export?frm='+ $('#from_date').val() +'&to='+ $('#to_date').val()+'&cashier='+ $('#cashier').val()+'&type=contentview');
        });
       $('#btn_email').on('click', function() {
                showNotification({title:"Sending!",stat:"info",msg:"Please wait for a few seconds."});

                var btn=$(this);
            
                $.ajax({
                    "dataType":"json",
                    "type":"POST",
                    "url":'Bar_sales_report/transaction/email?frm='+ $('#from_date').val() +'&to='+ $('#to_date').val()+'&cashier='+ $('#cashier').val()+'&type=contentview',
                    "beforeSend": showSpinningProgress(btn)
                }).done(function(response){
                    showNotification(response);
                    showSpinningProgress(btn);

                });
                });
    })();

            var showNotification=function(obj){
            PNotify.removeAll(); //remove all notifications
            new PNotify({
                title:  obj.title,
                text:  obj.msg,
                type:  obj.stat
            });
            };


        var showSpinningProgress=function(e){
            $(e).toggleClass('disabled');
            $(e).find('span').toggleClass('glyphicon glyphicon-refresh spinning');
        };

});

</script>

</body>

</html>