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
    <link href="assets/plugins/select2/select2.min.css" rel="stylesheet">
    <link type="text/css" href="assets/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">
    <link type="text/css" href="assets/plugins/datatables/dataTables.themify.css" rel="stylesheet">
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

/*        .child_table{
            padding: 5px;
            border: 1px #ff0000 solid;
        }*/

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
        }

        .numeric{
            text-align: right;
        }

        .select2-container { 
            width: 100% !important; 
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

                    <ol class="breadcrumb">
                        <li><a href="dashboard">Dashboard</a></li>
                        <li><a href="depreciation_expense">Depreciation Expense</a></li>
                    </ol>

                    <div class="container-fluid">
                        <div class="panel panel-default">
                            <!-- <div class="panel-heading">
                                <b style="color: white; font-size: 12pt;"><i class="fa fa-bars"></i>&nbsp; Depreciation Expense</b>
                            </div> -->
                            <div class="panel-body">
                            <h2 class="h2-panel-heading">Depreciation Expense</h2><hr>
                                <div class="row">
                                    <div class="container-fluid">
                                        <div class="container-fluid group-box">
                                            <div class="col-xs-12 col-md-4">
                                                  <b>Applicable Month :</b><br>
                                                <select id="cbo_month" class="form-control" >
                                                    <option value="01">January</option>
                                                    <option value="02">February</option>
                                                    <option value="03">March</option>
                                                    <option value="04">April</option>
                                                    <option value="05">May</option>
                                                    <option value="06">June</option>
                                                    <option value="07">July</option>
                                                    <option value="08">August</option>
                                                    <option value="09">September</option>
                                                    <option value="10">October</option>
                                                    <option value="11">November</option>
                                                    <option value="12">December</option>
                                                </select>
                                            </div>
                                            <div class="col-xs-12 col-md-4">
                                                <b>Year :</b><br>
                                                <select id="cbo_year" class="form-control">
                                                    <?php
                                                        for($starting_year; $starting_year <= $current_year; $starting_year++) {
                                                             echo '<option value="'.$starting_year.'"';
                                                             if( $starting_year ==  $current_year ) {
                                                                    echo ' selected="selected"';
                                                             }
                                                             echo ' >'.$starting_year.'</option>';
                                                         }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row" style="display: none;">
                                        <form id="frm-prepare-for-review">
                                            <div class="col-sm-4">
                                                <label>Total:</label>
                                                <input type="text" name="total" value="0.00" class="form-control" id="Sumofallmonthlydepreciation" style="text-align: right;">
                                            </div>
                                            <div class="col-sm-4">
                                                 <label>Month:</label>
                                                <input type="text" name="month" class="form-control" id="month">
                                            </div>
                                            <div class="col-sm-4">
                                                 <label>Year:</label>
                                                <input type="text" name="year" class="form-control" id="year">
                                            </div>
                                            </form>
                                        </div><br>
                                        <div class="container-fluid group-box">
                                            <button class="btn btn-primary pull-left" id="btn_print"><i class="fa fa-print"></i>&nbsp; Print Report</button>
                                            <button class="btn btn-success pull-left" id="btn_export" style="margin-left: 10px;"><i class="fa fa-file-excel-o"></i>&nbsp; Export</button>
                                            <button class="btn btn-success pull-left" id="btn_email" style="margin-left: 10px;"><i class="fa fa-share"></i>&nbsp; Email</button>
                                            <button class="btn btn-success pull-left" id="btn_save" style="margin-left: 10px;padding: 2px 7px!important;"><i class="fa fa-print"></i>&nbsp; Save</button>
                                            <table id="tbl_depreciation" class="table table-striped" width="100%" class="">
                                                <thead>
                                                    <tr>
                                                       <th>Asset Code</th>
                                                       <th>Description</th>
                                                       <th>Date Acquired</th>
                                                       <th>Acquisition Cost</th>
                                                       <th>Life</th> 
                                                       <th>Salvage Value</th>
                                                       <th>Depreciation Expense (Monthly)</th>
                                                       <th>Accumulative Depreciation</th>
                                                       <th>Book Value</th>
                                                    </tr>
                                                </thead>
                                                        <tfoot>
                                                            <tr>
                                                                <td colspan="3" style="text-align:right;"><b>Current Page Total :</b></td>
                                                                <td  style="text-align:right;" id="Sumacquisition"></td>
                                                                <td></td>
                                                                <td  style="text-align:right;" id="Sumsalvage"></td>
                                                                <td  style="text-align:right;" id="Summonthly"></td>
                                                                <td  style="text-align:right;" id="Sumaccumulative"></td>
                                                                <td  style="text-align:right;" id="Sumbook"></td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="3" style="text-align:right;"><b>Grand Total :</b></td>
                                                                <td  style="text-align:right;" id="Sumofallacquisition"></td>
                                                                <td></td>
                                                                <td  style="text-align:right;" id="Sumofallsalvage"></td>
                                                                <td  style="text-align:right;" id="Sumofallmonthly"></td>
                                                                <td  style="text-align:right;" id="Sumofallaccumulative"></td>
                                                                <td  style="text-align:right;" id="Sumofallbook"></td>

                                                            </tr>
                                                        </tfoot>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div></div>
                        </div>


            <div class="panel panel-default">
                <div class="panel-body">
                <h2 class="h2-panel-heading">Review Depreciation Expense</h2><hr>
                    <table id="tbl_review" class="table table-striped" width="100%" class="">
                            <thead>
                                <tr>
                                   <th></th>
                                   <th>Month</th>
                                   <th>Year</th>
                                   <th>Depreciation Total</th>
                                   <th>Remarks</th>
                                   <th>Reference No.</th>
                                   <th>Date Posted</th>


                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                </div>
            </div>
        </div> <!-- .container-fluid -->



                </div> <!-- #page-content -->
            </div>
            <div id="modal_confirmation" class="modal fade" tabindex="-1" role="dialog"><!--modal-->
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header ">
                            <button type="button" class="close"   data-dismiss="modal" aria-hidden="true">X</button>
                            <h4 class="modal-title" style="color:white;"><span id="modal_mode"> </span>Confirm Preparation</h4>
                        </div>
                        <div class="modal-body">
                            <p id="modal-body-message">Prepare the Depreciation Expense for review?</p>
                        </div>
                        <div class="modal-footer">
                            <button id="btn_yes" type="button" class="btn btn-success" data-dismiss="modal" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;">Yes</button>
                            <button id="btn_close" type="button" class="btn btn-default" data-dismiss="modal" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;">No</button>
                        </div>
                    </div>
                </div>
            </div>

            <table id="table_hidden" class="hidden">
                <tr>
                    <td>
                        <select name="accounts[]" class="selectpicker show-tick form-control selectpicker_accounts" data-live-search="true" title="Please select Account.">
                            <?php foreach($accounts as $account){ ?>
                                <option value='<?php echo $account->account_id; ?>'><?php echo $account->account_title; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                    <td><input type="text" name="memo[]" class="form-control"></td>
                    <td><input type="text" name="dr_amount[]" class="form-control numeric"></td>
                    <td><input type="text" name="cr_amount[]" class="form-control numeric"></td>
                    <td>
                        <button type="button" class="btn btn-default add_account"><i class="fa fa-plus-circle" style="color: green;"></i></button>
                        <button type="button" class="btn btn-default remove_account"><i class="fa fa-times-circle" style="color: red;"></i></button>
                    </td>
                </tr>
            </table>


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

<script src="assets/plugins/select2/select2.full.min.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/jquery.dataTables.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/dataTables.bootstrap.js"></script>

<!-- numeric formatter -->

<script src="assets/plugins/fullcalendar/moment.min.js"></script>
<!-- Data picker -->
<script src="assets/plugins/datapicker/bootstrap-datepicker.js"></script>
<script src="assets/plugins/formatter/autoNumeric.js" type="text/javascript"></script>
<script src="assets/plugins/formatter/accounting.js" type="text/javascript"></script>

<script>

$(document).ready(function(){

    var _cboMonth, _cboYear;
    var dt; var dtreview;    var _txnMode; var _cboCustomers; var _cboMethods; var _selectRowObj; var _selectedID; 
    var dtReview;
    
    var oTBJournal={
        "dr" : "td:eq(2)",
        "cr" : "td:eq(3)"
    };

    var oTFSummary={
        "dr" : "td:eq(1)",
        "cr" : "td:eq(2)"
    };
    
    var initializeControls=function(){
        _cboMonth=$('#cbo_month').select2({
            placeholder: "Please Select Month",
            allowClear: false
        });

        _cboYear=$('#cbo_year').select2({
            placeholder: "Please Select Year",
            allowClear: false
        });

        _cboMonth.select2('val','<?php echo date('m');?>');
        _cboYear.select2('val',<?php echo date('Y'); ?>);

        initializeDataTable();


    }();

    function initializeDataTable() {
        dt=$('#tbl_depreciation').DataTable({
            "dom":'<"toolbar">frtip',
            "bLengthChange": false,
            "language": {
                searchPlaceholder: "Search records"
            },
            "ajax": {
                "url":"Depreciation_expense/transaction/gdr-list",
                "bDestroy":true,
                "data": function (d) {
                    return $.extend({}, d, {
                        "m":_cboMonth.val(),
                        "y":_cboYear.val()
                    });
                }
            },
            "columns": [
                { targets:[0],data: "asset_code" },
                { targets:[1],data: "asset_description" },
                { targets:[2],data: "acquired_date" },
                { sClass: "text-right", targets:[3],data: "acquisition_cost", render: function(data,type,full,meta){ return accounting.formatNumber(data,2);}},
                { sClass: "text-center",targets:[4],data: "life_years" },
                { sClass: "text-right", targets:[5],data: "salvage_value",render: function(data,type,full,meta){ return accounting.formatNumber(data,2);}},
                { sClass: "text-right",targets:[6],data: "depreciation_expense",render: function(data,type,full,meta){return accounting.formatNumber(data,2);}},
                { sClass: "text-right",targets:[7],data: "accu_dep",render: function(data,type,full,meta){return accounting.formatNumber(data,2);}},
                { sClass: "text-right",targets:[8],data: "book_value", render: function(data,type,full,meta){return accounting.formatNumber(data,2);}}],
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
             
                        // Total over this page
                        pageTotalAmount = api .column( 3, { page: 'current'} ) .data() .reduce( function (a, b) { return intVal(a) + intVal(b);}, 0 );
                        pageTotalAmount5 = api .column( 5, { page: 'current'} ) .data() .reduce( function (a, b) { return intVal(a) + intVal(b);}, 0 );
                        pageTotalAmount6 = api .column( 6, { page: 'current'} ) .data() .reduce( function (a, b) { return intVal(a) + intVal(b);}, 0 );
                        pageTotalAmount7 = api .column( 7, { page: 'current'} ) .data() .reduce( function (a, b) { return intVal(a) + intVal(b);}, 0 );
                        pageTotalAmount8 = api .column( 8, { page: 'current'} ) .data() .reduce( function (a, b) { return intVal(a) + intVal(b); }, 0 );
                        // Total over all pages
                        totalAmount = api .column(3) .data() .reduce( function (a, b) { return intVal(a) + intVal(b); }, 0 );
                        totalAmount5 = api .column(5) .data() .reduce( function (a, b) { return intVal(a) + intVal(b); }, 0 );
                        totalAmount6 = api .column(6) .data() .reduce( function (a, b) { return intVal(a) + intVal(b); }, 0 );
                        totalAmount7 = api .column(7) .data() .reduce( function (a, b) { return intVal(a) + intVal(b); }, 0 );
                        totalAmount8 = api .column(8) .data() .reduce( function (a, b) { return intVal(a) + intVal(b); }, 0 );
                        //total of every category hahaha
                         $('#Sumacquisition').html('<b> '+accounting.formatNumber(pageTotalAmount,2)+'</b>');
                         $('#Sumsalvage').html('<b> '+accounting.formatNumber(pageTotalAmount5,2)+'</b>');
                         $('#Summonthly').html('<b> '+accounting.formatNumber(pageTotalAmount6,2)+'</b>');
                         $('#Sumaccumulative').html('<b> '+accounting.formatNumber(pageTotalAmount7,2)+'</b>');
                         $('#Sumbook').html('<b> '+accounting.formatNumber(pageTotalAmount8,2)+'</b>');

                         $('#Sumofallacquisition').html('<b> '+accounting.formatNumber(totalAmount,2)+'</b>');
                         $('#Sumofallsalvage').html('<b> '+accounting.formatNumber(totalAmount5,2)+'</b>');
                         $('#Sumofallmonthly').html('<b> '+accounting.formatNumber(totalAmount6,2)+'</b>');
                         $('#Sumofallaccumulative').html('<b> '+accounting.formatNumber(totalAmount7,2)+'</b>');
                         $('#Sumofallbook').html('<b> '+accounting.formatNumber(totalAmount8,2)+'</b>');

                         $('#Sumofallmonthlydepreciation').val(accounting.formatNumber(totalAmount6,2));
                    }
        });

        dt.order([ 1, 'asc' ]).draw();
        $('#month').val(_cboMonth.val());
        $('#year').val(_cboYear.val());

         dtreview=$('#tbl_review').DataTable({
            "bLengthChange": false,
            "language": {
                searchPlaceholder: "Search records"
            },
            "ajax": {
                "url":"Depreciation_expense/transaction/review-list",
                "bDestroy":true
            },
            "columns": [
                            {
                    "targets": [0],
                    "class":          "details-control",
                    "orderable":      false,
                    "data":           null,
                    "defaultContent": ""
                },
                { targets:[1],data: "de_month" },
                { targets:[2],data: "de_year" },
                { targets:[3],data: "de_expense_total" },
                { targets:[4],data: "de_remarks"},
                { targets:[5],data: "de_ref_no" },
                {
                    targets:[6],data: null,
                    render: function (data, type, full, meta){
                        var _attribute='';
                        //console.log(data.is_email_sent);
                        if(data.date_posted=="0000-00-00"){
                            _attribute='';
                        }else{
                            _attribute=data.date_posted;
                        }
                        return _attribute;
                    }
                }
                
            ]
           
        });



    };

    var bindEventHandlers=function(){
        var detailRows = [];

        $('#tbl_review tbody').on( 'click', 'tr td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = dtreview.row( tr );
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
                    "url":"Templates/layout/depreciation_expense?id="+ d.de_id,
                    "beforeSend" : function(){
                        row.child( '<center><br /><img src="assets/img/loader/ajax-loader-lg.gif" /><br /><br /></center>' ).show();
                    }
                }).done(function(response){
                    row.child( response,'no-padding' ).show();



                    // var tbl=$('#tbl_entries_for_review_'+ d.de_id);

                    // reInitializeSpecificDropDown($('.cbo_customer_list'));
                    reInitializeSpecificDropDown($('.cbo_department_list'));
                    reInitializeSpecificDropDown($('.particular_select'));
                    $('.date-picker').datepicker('setDate','today');
                    reInitializeNumeric();

                    var tbl=$('#tbl_entries_for_review_'+ d.de_id);
                    var parent_tab_pane=$('#journal_review_'+ d.de_id);
                    reInitializeDropDownAccounts(tbl);
                    reInitializeChildEntriesTable(tbl);
                    reInitializeChildElements(parent_tab_pane);



                    if ( idx === -1 ) {
                        detailRows.push( tr.attr('id') );
                    }
                });

            }
        } );    
        $('#btn_print').on('click', function(){
            window.open('Depreciation_expense/transaction/gdr-print?m='+_cboMonth.val()+'&y='+_cboYear.val());
        });

        $('#btn_export').on('click', function(){
            window.open('Depreciation_expense/transaction/gdr-export?m='+_cboMonth.val()+'&y='+_cboYear.val());
        });

        $('#btn_email').on('click', function(){
            showNotification({title:"Sending!",stat:"info",msg:"Please wait for a few seconds."});

            var btn=$(this);
        
            $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"Depreciation_expense/transaction/gdr-email?m="+_cboMonth.val()+'&y='+_cboYear.val(),
                "beforeSend": showSpinningProgress(btn)
            }).done(function(response){
                showNotification(response);
                showSpinningProgress(btn);

            });
        });

        $('#btn_save').on('click', function(){
            $('#modal_confirmation').modal('show');
        });

        $('#btn_yes').on('click',function(){
            var amount = $('#Sumofallmonthlydepreciation').val();
            if(amount==0.00){
                showNotification({title:"Error!",stat:"error",msg:"Depreciation Expense must not be equal to 0"});
            } else{
                createDepreciationExpense().done(function(response){
                    showNotification(response);
                    // dt.row.add(response.row_added[0]).draw();
                    // clearFields($('#frm_sales_invoice'));
                    // showList(true);
                    // dt.destroy();
                    // dtreview.destroy();
                    // initializeDataTable();
                    dtreview.ajax.reload();
                });
            }
        });

        _cboMonth.on('select2:select', function(){
            dt.destroy();
            dtreview.destroy();
            initializeDataTable();
        });

        _cboYear.on('select2:select', function(){
            dt.destroy();
            dtreview.destroy();
            initializeDataTable();
        });

    }();

    var createDepreciationExpense=function(){
        var _data=$('#frm-prepare-for-review').serializeArray();

            return $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"Depreciation_expense/transaction/create-for-review",
                "data":_data
            });
        };


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


    var reComputeTotals=function(tbl){
        var oRows=tbl.find('tbody tr');
        var _DR_amount=0.00; var _CR_amount=0.00;
        $.each(oRows,function(i,value){
            _DR_amount+=getFloat($(this).find(oTBJournal.dr).find('input.numeric').val());
            _CR_amount+=getFloat($(this).find(oTBJournal.cr).find('input.numeric').val());


        });

        tbl.find('tfoot tr').find(oTFSummary.dr).html('<b>'+accounting.formatNumber(_DR_amount,2)+'</b>');
        tbl.find('tfoot tr').find(oTFSummary.cr).html('<b>'+accounting.formatNumber(_CR_amount,2)+'</b>');

    };


    function reInitializeNumeric(){
        $('.numeric').autoNumeric('init');
    };

    function reInitializeDropDownAccounts(tbl){
        tbl.find('select.selectpicker').select2({
            placeholder: "Please select account.",
            allowClear: false
        });
    };


    function reInitializeSpecificDropDown(elem){
        elem.select2({
            placeholder: "Please select item.",
            allowClear: true
        });
        elem.select2('val',null);
    };

    var isBalance=function(opTable=null){
        var oRow; var dr; var cr;

        if(opTable==null){
            oRow=$('#tbl_entries > tfoot tr');
        }else{
            oRow=$(opTable+' > tfoot tr');
        }

        dr=getFloat(oRow.find(oTFSummary.dr).text());
        cr=getFloat(oRow.find(oTFSummary.cr).text());

        return (dr==cr);
    };

    var validateRequiredFields=function(f){
        var stat=true;

        $('div.form-group').removeClass('has-error');
        $('input[required],textarea[required],select[required]',f).each(function(){

            if($(this).is('select')){
                if($(this).select2('val')==0||$(this).select2('val')==null){
                    showNotification({title:"Error!",stat:"error",msg:$(this).data('error-msg')});
                    $(this).closest('div.form-group').addClass('has-error');
                    $(this).focus();
                    stat=false;
                    return false;
                }
            }else{
                if($(this).val()==""){
                    showNotification({title:"Error!",stat:"error",msg:$(this).data('error-msg')});
                    $(this).closest('div.form-group').addClass('has-error');
                    $(this).focus();
                    stat=false;
                    return false;
                }
            }
        });
                if(!isBalance()){
            showNotification({title:"Error!",stat:"error",msg:'Please make sure Debit and Credit amount are equal.'});
            stat=false;
        }

        return stat;
    };
    var reInitializeChildEntriesTable=function(tbl){
        var _oTblEntries=tbl.find('tbody');
        console.log(_oTblEntries);
        _oTblEntries.on('keyup','input.numeric',function(){
            var _oRow=$(this).closest('tr');
            if(_oTblEntries.find(oTBJournal.dr).index()===$(this).closest('td').index()){
             //if true, this is Debit amount
                if(getFloat(_oRow.find(oTBJournal.dr).find('input.numeric').val())>0){
                   
                    _oRow.find(oTBJournal.cr).find('input.numeric').val('0.00');
                }
            }else{
                if(getFloat(_oRow.find(oTBJournal.cr).find('input.numeric').val())>0) {
                    _oRow.find(oTBJournal.dr).find('input.numeric').val('0.00');
                }
            }
            reComputeTotals(tbl);
        });



        //add account button on table
        tbl.on('click','button.add_account',function(){

            var row=$('#table_hidden').find('tr');
            row.clone().insertAfter(tbl.find('tbody > tr:last'));

            reInitializeNumeric();
            reInitializeDropDownAccounts(tbl);

        });


        tbl.on('click','button.remove_account',function(){
            var oRow=tbl.find('tbody tr');

            if(oRow.length>1){
                $(this).closest('tr').remove();
            }else{
                showNotification({"title":"Error!","stat":"error","msg":"Sorry, you cannot remove all rows."});
            }

            reComputeTotals(tbl);

        });




    };

var getFloat=function(f){
    return parseFloat(accounting.unformat(f));
};


var reInitializeChildElements=function(parent){
        var _dataParentID=parent.data('parent-id');
        var btn=parent.find('button[name="btn_finalize_journal_review"]');

        //initialize datepicker
        parent.find('input.date-picker').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true

        });


        parent.on('click','button[name="btn_finalize_journal_review"]',function(){
            var _curBtn=$(this);
            if(isBalance('#tbl_entries_for_review_'+_dataParentID)){
                var _parentRow=_curBtn.parents('table.table_journal_entries_review').parents('tr').prev();
                if(validateRequiredFields($('#frm_journal_review_'+_dataParentID))){

                finalizeJournalReview().done(function(response){

                    showNotification(response);
                    if(response.stat=="success"){
                            dtreview.row(_parentRow).remove().draw();
                            dtreview.row.add(response.row_updated[0]).draw();
                            // dtreview.row(_parentRow).data(response.row_updated[0]).draw();
                        
                    }
                }).always(function(){
                    showSpinningProgress(_curBtn);
                });

            }
                    

            }else{
                showNotification({title:"Not Balance!",stat:"error",msg:'Please make sure Debit and Credit amount are equal.'});
                stat=false;
            }

        });



        var finalizeJournalReview=function(){
            var _data_review=parent.find('form').serializeArray();
            return $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"General_journal/transaction/create-expense-journal",
                "data":_data_review,
                "beforeSend": showSpinningProgress(btn)

            });
        };



    };


});


</script>

</body>

</html>