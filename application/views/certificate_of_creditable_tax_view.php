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
        #tbl_2307_filter{
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
        #tbl_2307 td:nth-child(4), #tbl_2307 td:nth-child(5){
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
                        <li><a href="Certificate_of_creditable_tax">Certificate of Creditable Tax</a></li>
                    </ol>

                    <div class="container-fluid">
                        <div data-widget-group="group1">
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="div_2307_form_list">
                                        <div class="panel panel-default">
                                            <div class="panel-body">
                                            <h2 class="h2-panel-heading">Certificate of Creditable Tax (BIR FORM #2307)<small> | <a href="assets/manual/birforms/2307.pdf" target="_blank" style="color:#999999;"><i class="fa fa-question-circle"></i></a></small></h2><hr>
                                            <div class="row" style="margin-bottom: 20px;">
                                                <div class="col-lg-3">
                                                    <b>Month:</b><br>
                                                    <select class="form-control" name="month" id="month" width="100%">
                                                    <option value="0">ALL MONTHS
                                                        <?php 
                                                        $active_month = date("m");
                                                            foreach($months as $month){?>
                                                            <option value="<?php echo $month->month_id; ?>" <?php if($month->month_id==$active_month){echo 'selected'; }?>>
                                                                <?php echo $month->month_name; ?>
                                                            </option>
                                                        <?php }?>
                                                    </select>
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
                                                <div class="col-lg-2"><br>
                                                    <button class="btn btn-primary" id="btn_print" data-toggle="modal" title="Print" ><i class="fa fa-print"></i> Print Report</button>
                                                </div>
                                                <div class="col-lg-4">
                                                    <b>Search:</b><br />
                                                    <input type="text" id="searchbox_2307" placeholder="Search" class="form-control">
                                                </div>
                                            </div>


                                            <table id="tbl_2307" class="table table-striped" cellspacing="0" width="100%">
                                                <thead>
                                                    <th width="2%"></th>
                                                    <th width="10%">Txn No.</th>
                                                    <th width="15%">Supplier</th>
                                                    <th width="10%" style="text-align: right;">Gross Amount</th>
                                                    <th width="10%" style="text-align: right;">Tax Amount</th>
                                                    <th width="25%">Remarks</th>
                                                    <th width="10%"><center>Action</center></th>
                                                </thead>
                                            </table>
                                            </div>
                                            <div class="panel-footer"></div>
                                        </div>
                                    </div>
                                    <div id="div_2307_form_entry" class="hidden">
                                        <div class="panel panel-default">
                                            <div class="panel-body table-responsive">
                                            <h2 class="h2-panel-heading">Certificate of Creditable Tax</h2><hr>

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

<script>

$(document).ready(function(){
    var dt; var _txnMode; var _selectedID; var _selectRowObj; var _cboAccountType; var _selMonth; var _selYear;

    var initializeControls=function(){

        _selMonth=$('#month').select2({
            placeholder: "Month"
        });

        _selYear=$('#year').select2({
            placeholder: "Year"
        });

        dt=$('#tbl_2307').DataTable({
            "dom": '<"toolbar">frtip',
            "bLengthChange":false,
            "order": [[ 2, "desc" ]],
            oLanguage: {
                    sProcessing: '<center><br /><img src="assets/img/loader/ajax-loader-sm.gif" /><br /><br /></center>'
            },
            processing : true,            
            "ajax" : {
                "url" : "Certificate_of_creditable_tax/transaction/list",
                "bDestroy": true,            
                "data": function ( d ) {
                        return $.extend( {}, d, {
                            "month":$('#month').select2('val'),
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
                { targets:[1],data: "txn_no" },
                { targets:[2],data: "payee_name" },
                { targets:[3],data: "gross_amount" },
                { targets:[4],data: "deducted_amount" },
                { targets:[5],data: "remarks" },
                {
                    targets:[6],data: null,
                    render: function (data, type, full, meta){
                        var btn_print='<button class="btn btn-primary btn-sm" name="print_form_2307" style="margin-right:0px;" data-toggle="tooltip" data-placement="top" title="Print Form 2307"><i class="fa fa-print"></i> </button>';
                        return '<center>'+btn_print+'</center>';
                    }
                }
            ]
        });
    }();

    var bindEventHandlers=(function(){
        var detailRows = [];

        _selMonth.on("select2:select", function (e) {
            dt.ajax.reload( null, false );
        });

        _selYear.on("select2:select", function (e) {
            dt.ajax.reload( null, false );
        });

        $("#searchbox_2307").keyup(function(){         
            dt
                .search(this.value)
                .draw();
        });

        $('#btn_print').on('click', function() {
            window.open('Certificate_of_creditable_tax/transaction/print-list?month='+ $('#month').val() +'&year='+ $('#year').val());
        });   

        $('#tbl_2307 tbody').on( 'click', 'tr td.details-control', function () {
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
                    "url":"Templates/layout/journal-cdj?id="+ d.journal_id,
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

        $('#tbl_2307').on('click','button[name="print_form_2307"]',function(){
            _selectRowObj=$(this).closest('tr');
            var data=dt.row(_selectRowObj).data();
            _selectedID=data.journal_id;
            window.open("Templates/layout/print-form-2307?id="+_selectedID+"&type=print","_blank");
        });

    })();

    var validateRequiredFields=function(){
        var stat=true;
        $('div.form-group').removeClass('has-error');
        $('input[required],textarea[required],select[required]').each(function(){
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
        });
        return stat;
        };

    var showList=function(b){
        if(b){
            $('#div_2307_form_list').show();
            $('#div_2307_form_entry').hide();
        }else{
            $('#div_2307_form_list').hide();
            $('#div_2307_form_entry').show();
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
    };

    var clearFields=function(){
        $('input[required],textarea','#frm_bank').val('');
        $('form').find('input:first').focus();
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