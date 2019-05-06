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

    <style>
        #tbl_mptr2 tr,#tbl_mptr2 th,#tbl_mptr2 td{
            table-layout: fixed;
            border: 1px solid black;
            border-collapse: collapse;
            border-spacing: 0;
        }

        .bglabel-color{
            background-color: #ebebe0;
        }

        .left{
            padding-left: 0px;
        }

        .right{
            padding-right: 0px;
        }

        .no-border{
            border: none!important;
        }

        .no-border-tr{
            border-top: none!important;
            border-bottom: none!important;
        }

        .border-tr{
            border-bottom: none!important;
        }

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
        #tbl_2551M_filter{
            display: none;
        }
        div.dataTables_processing{ 
        position: absolute!important; 
        top: 0%!important; 
        right: -45%!important; 
        left: auto!important; 
        width: 100%!important; 
        height: 40px!important; 
        background: none!important; 
        background-color: transparent!important; 
        } 
        #tbl_2551M td:nth-child(5), #tbl_2551M td:nth-child(6), #tbl_2551M td:nth-child(7){
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
                        <li><a href="Monthly_percentage_tax_return">Monthly Percentage Tax Return</a></li>
                    </ol>

                    <div class="container-fluid">
                        <div data-widget-group="group1">
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="div_2551M_form_list">
                                        <div class="panel panel-default">
                                            <div class="panel-body">
                                            <h2 class="h2-panel-heading">Monthly Percentage Tax Return (BIR FORM #2551M)</h2><hr>
                                            <div class="row" style="margin-bottom: 20px;">
                                                <div class="col-lg-3">
                                                    <br />
                                                    <button type="button" class="btn btn-primary form-control" id="generate_2551m">
                                                        Generate 2551M
                                                    </button>
                                                </div>
                                                <div class="col-lg-3">
                                                    <b>Year:</b><br>
                                                    <select class="form-control" name="year" id="year" width="100%">
                                                        <?php 
                                                        $minyear=1999; $maxyear=date('Y');
                                                        $active_year = date("Y");
                                                          while($minyear!=$maxyear){?>
                                                            <option value="<?php echo $minyear+1; ?>" <?php if($minyear+1 == $active_year){echo 'selected'; }?>>
                                                                <?php echo $minyear+1; ?>
                                                            </option>
                                                        <?php $minyear++; }?>
                                                    </select>
                                                </div>
                                                <div class="col-lg-3 col-lg-offset-3">
                                                    <b>Search:</b><br />
                                                    <input type="text" id="searchbox_2551M" placeholder="Search" class="form-control">
                                                </div>
                                            </div>


                                            <table id="tbl_2551M" class="table table-striped" cellspacing="0" width="100%">
                                                <thead>
                                                    <th width="2%"></th>
                                                    <th width="10%">Month</th>
                                                    <th width="20%">Industry Classification</th>
                                                    <th width="5%">ATC</th>
                                                    <th width="10%" style="text-align: right;">Taxable Amount</th>
                                                    <th width="10%" style="text-align: right;">Tax Rate</th>
                                                    <th width="10%" style="text-align: right;">Tax Due</th>
                                                    <th width="10%"><center>Action</center></th>
                                                    <th></th>
                                                </thead>
                                            </table>
                                            </div>
                                            <div class="panel-footer"></div>
                                        </div>
                                    </div>
                                    <div id="div_2551M_form_entry" class="hidden">
                                        <div class="panel panel-default">
                                            <div class="panel-body table-responsive">
                                                <h2 class="h2-panel-heading">Generete BIR Form #2551M</h2><hr>
                                                <form id="frm_2551m">
                                                <div class="row" style="margin-bottom: 20px;">
                                                    <div class="col-lg-6">
                                                        <div class="col-md-12">
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <label>Month:</label><br>
                                                                    <select class="form-control" name="month" id="month" width="100%">
                                                                        <?php 
                                                                        $active_month = date("m");
                                                                            foreach($months as $month){?>
                                                                            <option value="<?php echo $month->month_id; ?>" <?php if($month->month_id==$active_month){echo 'selected'; }?>><?php echo $month->month_name; ?>
                                                                            </option>
                                                                        <?php }?>
                                                                    </select>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <label>Year:</label><br>
                                                                    <select class="form-control" name="year" id="year_entry" width="100%">
                                                                        <?php 
                                                                        $minyear=1999; $maxyear=date('Y');
                                                                        $active_year = date("Y");
                                                                          while($minyear!=$maxyear){?>
                                                                            <option value="<?php echo $minyear+1; ?>" <?php if($minyear+1 == $active_year){echo 'selected'; }?>><?php echo $minyear+1; ?>
                                                                            </option>
                                                                        <?php $minyear++; }?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="row" style="margin-top: 10px;">
                                                                <div class="col-sm-6">
                                                                    <b class="required">*</b> <label>ATC</label><br>
                                                                    <input type="text" class="form-control" name="atc" id="atc" required data-error-msg="ATC is required." placeholder="ATC">
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <b class="required">*</b> <label>Industry Classification</label><br>
                                                                    <input type="text" class="form-control" name="industry_classification" id="industry_classification" required data-error-msg="Industry Classification is required." placeholder="Industry Classification">
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <div class="row" style="margin-top: 10px;">
                                                                <div class="col-sm-6">
                                                                    <label style="float: right!important;">Taxable Amount:</label><br>
                                                                    <input type="text" class="numeric form-control" name="taxable_amount" id="taxable_amount" readonly placeholder="0.00" style="text-align: right;">
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <label style="float: right!important;">Tax Rate (%):</label><br>
                                                                    <input type="text" class="numeric form-control" name="tax_rate" id="tax_rate" readonly placeholder="0.00" style="text-align: right;">
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <label style="float: right!important;">Taxable Due:</label><br>
                                                                    <input type="text" class="numeric form-control" name="tax_due" id="tax_due" readonly placeholder="0.00" style="text-align: right;">
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <div class="row" style="margin-top: 10px;">
                                                                <div class="col-sm-6">
                                                                    <button type="button" id="save_2551m" class="btn btn-primary form-control" style="width: 100%;">Save</button>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <button type="button" id="cancel_2551m" class="btn btn-danger form-control" style="width: 100%;">Cancel</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <br />
                                                        <table id="tbl_2251M_monthly" class="table table-striped" cellspacing="0" width="100%">
                                                            <thead>
                                                                <tr>
                                                                    <th>Reference No#</th>
                                                                    <th>Invoice Date</th>
                                                                    <th>Customer</th>
                                                                    <th style="text-align: right;">Net Amount</th>
                                                                    <th></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody></tbody>
                                                            <tfoot>
                                                                <td align="right" colspan="3">TOTAL :</td>
                                                                <td id="total_net_amount" align="right">0.00</td>
                                                            </tfoot>
                                                        </table>
                                                    </div>
                                                </div>
                                                </form>
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

<script src="assets/plugins/select2/select2.full.min.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/jquery.dataTables.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/dataTables.bootstrap.js"></script>

<!-- numeric formatter -->
<script src="assets/plugins/formatter/autoNumeric.js" type="text/javascript"></script>
<script src="assets/plugins/formatter/accounting.js" type="text/javascript"></script>
<script>

$(document).ready(function(){
    var dt; var _txnMode; var _selectedID; var _selectRowObj; var _cboAccountType; var _selMonth; var _selYear; var _selYearEntry; var _cstatus=0;

    var initializeControls=function(){

        _selYear=$('#year').select2({
            placeholder: "Year"
        });

        _selMonth=$('#month').select2({
            placeholder: "Month"
        });

        _selYearEntry=$('#year_entry').select2({
            placeholder: "Year"
        });               

        dt=$('#tbl_2551M').DataTable({
            "dom": '<"toolbar">frtip',
            "bLengthChange":false,
            "order": [[ 8, "desc" ]],
            oLanguage: {
                    sProcessing: '<center><br /><img src="assets/img/loader/ajax-loader-sm.gif" /><br /><br /></center>'
            },
            processing : true,            
            "ajax" : {
                "url" : "Monthly_percentage_tax_return/transaction/list",
                "bDestroy": true,            
                "data": function ( d ) {
                        return $.extend( {}, d, {
                            "year":$('#year').select2('val')
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
                { targets:[1],data: "month_name" },
                { targets:[2],data: "industry_classification" },
                { targets:[3],data: "atc" },
                { targets:[4],data: "taxable_amount" },
                { targets:[5],data: "tax_rate" },
                { targets:[6],data: "tax_due" },
                {
                    targets:[7],data: null,
                    render: function (data, type, full, meta){
                        var btn_print='<button class="btn btn-primary btn-sm" name="print_form_2551m" style="margin-right:0px;" data-toggle="tooltip" data-placement="top" title="Print Form 2551M"><i class="fa fa-print"></i> </button>';
                        return '<center>'+btn_print+'</center>';
                    }
                },
                { visible:false, targets:[8],data: "month_id" }
            ]
        });

         dt_invoices=$('#tbl_2251M_monthly').DataTable({
            "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "order": [[ 0, "desc" ]],        
            "ajax" : {
                "url" : "Monthly_percentage_tax_return/transaction/generate_sales_cash_invoice",
                "bDestroy": true,            
                "data": function ( d ) {
                        return $.extend( {}, d, {
                            "month":$('#month').select2('val'),
                            "year":$('#year_entry').select2('val')
                        });
                    }
            }, 
            "columns": [
                { targets:[0],data: "ref_no" },
                { targets:[1],data: "date_invoice" },
                { targets:[2],data: "customer" },
                { targets:[3],data: "amount" },
                { visible:false, targets:[4],data: "invoice_id" }
            ],
            language: {
                         searchPlaceholder: "Search Invoice"
                     },    
            "footerCallback": function(a,b,c){
                var api = this.api(), data;
                // Remove the formatting to get integer data for summation
                var intVal = function ( i ) {
                    return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                        typeof i === 'number' ?
                            i : 0;
                };

                total_net_amount = api
                    .column( 3 )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                $('#total_net_amount').html('<b>'+accounting.formatNumber(total_net_amount,2)+'</b>');
            },        
            "rowCallback":function( row, data, index ){

                $(row).find('td').eq(3).attr({
                    "align": "right"
                });
            }
        });
         $('.numeric').autoNumeric('init',{mDec:2});
    }();

    var bindEventHandlers=(function(){
        var detailRows = [];

        _selYear.on("select2:select", function (e) {
            dt.ajax.reload( null, false );
        });        

        $("#searchbox_2551M").keyup(function(){         
            dt
                .search(this.value)
                .draw();
        });

        $('#generate_2551m').click(function(){
            showList(false);
            clearFields('#frm_2551m');
            get_monthly_ptr();
        });

        _selYearEntry.on("select2:select", function (e) {
            get_monthly_ptr();
        });   

        _selMonth.on("select2:select", function (e) {
            get_monthly_ptr();
        });   

        $('#cancel_2551m').click(function(){
            showList(true);
        });

        $('#tbl_2551M tbody').on( 'click', 'tr td.details-control', function () {
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
                    "url":"Templates/layout/form_2551m_details?id="+ d.form_2551m_id,
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
        });

        $('#save_2551m').click(function(){
            if(validateRequiredFields($('#frm_2551m'))){
                save2551m().done(function(response){
                    showNotification(response);

                    if (response.status == 'new'){
                        dt.row.add(response.row[0]).draw();
                    }else{
                        dt.ajax.reload( null, false );
                    }

                    clearFields($('#frm_2551m'))
                    showList(true);
                }).always(function(){
                    showSpinningProgress($('#save_2551m'));
                });
            };
        });

        $('#tbl_2551M').on('click','button[name="print_form_2551m"]',function(){
            _selectRowObj=$(this).closest('tr');
            var data=dt.row(_selectRowObj).data();
            _selectedID=data.form_2551m_id;
            window.open("Templates/layout/print-form-2551m?id="+_selectedID+"&type=print","_blank");
        });

        var get_monthly_ptr=function(){
            dt_invoices.ajax.reload( null, false );
            get_monthly_tax_return().done(function(response){
                var row = response.data[0];
                var company = response.company[0];
                _cstatus= row.taxable_amount;

                var taxable_amount = row.taxable_amount;
                var tax_rate = 0.03;
                $('#taxable_amount').val(accounting.formatNumber(row.taxable_amount,2));
                $('#tax_rate').val(3);

                var tax_due = (parseFloat(taxable_amount) * parseFloat(tax_rate));
                $('#tax_due').val(accounting.formatNumber(tax_due,2)); 
                $('#industry_classification').val(company.industry_classification);
            });
        };

    })();

    var newRowItem=function(d){
    return '<tr>'+
           '<td>'+d.ref_no+'</td>'+
           '<td style="text-align: right;">'+d.amount+'</td>'+
           '</tr>';
    };

    var validateRequiredFields=function(){
        var stat=true;
        $('div.form-group').removeClass('has-error');
        $('input[required],textarea[required],select[required]').each(function(){

            month = $('#month option:selected').text();
            year = $('#year_entry option:selected').text();

            if(_cstatus <= 0){
                showNotification({title:"Error!",stat:"error",msg:"No Record Found for "+month+' '+year});
                stat=false;
                return false;
            }else{
                if($(this).is('select')){
                    if($(this).val()==0 || $(this).val()==null || $(this).val()==undefined || $(this).val()==""){
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
            }
        });
        return stat;
        };

    var showList=function(b){
        if(b){
            $('#div_2551M_form_list').removeClass('hidden');
            $('#div_2551M_form_entry').addClass('hidden');
        }else{
            $('#div_2551M_form_list').addClass('hidden');
            $('#div_2551M_form_entry').removeClass('hidden');
        }
    };

    var get_monthly_tax_return=function(){
        var _data=$('#').serializeArray();
        _data.push({name : "month" ,value : _selMonth.select2('val')});
        _data.push({name : "year" ,value : _selYearEntry.select2('val')});

        return $.ajax({ 
            "dataType":"json",
            "type":"POST",
            "url":"Monthly_percentage_tax_return/transaction/get_monthly_tax_return",
            "data":_data
        });
    };

    var generate_sales_cash_invoice=function(){
        var _data=$('#').serializeArray();
        _data.push({name : "month" ,value : _selMonth.select2('val')});
        _data.push({name : "year" ,value : _selYearEntry.select2('val')});

        return $.ajax({ 
            "dataType":"json",
            "type":"POST",
            "url":"Monthly_percentage_tax_return/transaction/generate_sales_cash_invoice",
            "data":_data
        });
    };

    var save2551m=function(){
        var _data=$('#frm_2551m').serializeArray();

        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Monthly_percentage_tax_return/transaction/create",
            "data":_data,
            "beforeSend": showSpinningProgress($('#save_2551m'))
        });
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
    };

    var clearFields=function(f){
        $('input,textarea', f).val('');
        $(f).find('input:first').focus();
    };

    function format ( d ) {
        return '<br /><table style="margin-left:10%;width: 80%;">' +
        '<thead>' +
        '</thead>' +
        '<tbody>' +
        '<tr>' +
        '<td>Unit Name : </td><td><b>'+ d.unit_name+'</b></td>' +
        '</tr>' +
        '<tr>' +
        '<td>Unit Description : </td><td>'+ d.unit_desc+'</td>' +
        '</tr>' +
        '</tbody></table><br />';
    };
});

</script>

</body>

</html>