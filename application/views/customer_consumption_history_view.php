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
        div.dataTables_filter input { 
            margin-top: 10px;
        }

        .toolbar{
            float: left;
        }

        .text-right { 
            text-align: right!important; 
        } 
 
        .text-left {  
            text-align: left!important; 
        } 
       .select2-results__options {
                overflow-x: hidden;
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
                        <li><a href="Customer_consumption_history">Consumption History Report</a></li>
                    </ol>
                    <div class="container-fluid">
                        <div data-widget-group="group1">
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="div_payable_list">
                                        <div class="panel-group panel-default" id="accordionA">
                                            <div class="panel panel-default" style="border-radius: 6px;min-height: 670px;">
                                                <div id="collapseTwo" class="collapse in">
                                                    <div class="panel-body">
                                                    <h2 class="h2-panel-heading">Consumption History Report</h2><hr>
                                                        <div >
                                                        <div class="row">
                                                            <div class="col-sm-10">
                                                                <select id="cbo_accounts" style="width: 100%;">
                                                                    <optgroup label="Account # | Customer Name | Meter Serial">
                                                                        <?php foreach($accounts as $account){ ?>
                                                                            <option value="<?php echo $account->connection_id; ?>"><?php echo $account->account_no; ?> | <?php echo $account->customer_name; ?> | <?php echo $account->serial_no; ?></option>
                                                                        <?php } ?>
                                                                    </optgroup>
                                                                </select>
                                                            </div>
                                                            <div class="col-sm-2">
                                                            <button id="btn_print" class="btn btn-success" style="text-transform: none;padding: 6px 15px!important;"><i class="fa fa-print"></i> Print</button>
                                                            </div>
                                                        </div><br>
                                                        <div id="details_loader">
                                                            <center><br /><img src="assets/img/loader/ajax-loader-lg.gif" /><br /><br /></center>
                                                        </div>
                                                        <div class="" id="div_details">
                                                        </div>
                                                            <div id="div_tab_container">
                                                                <div class="tab-container tab-top tab-primary">
                                                                    <ul class="nav nav-tabs">
                                                                        <?php foreach ($meter_years as $meter_year) { ?>
                                                                            <li class="<?php if(date("Y") == $meter_year->meter_reading_year){echo 'active'; } ?>">
                                                                                <a data-toggle="tab" href="#<?php echo $meter_year->meter_reading_year ; ?>"><?php echo $meter_year->meter_reading_year ; ?></a>
                                                                            </li>
                                                                        <?php } ?>
                                                                    </ul>
                                                                    <div class="tab-content" id="">
                                                                        <?php foreach ($meter_years as $meter_year) { ?>
                                                                            <div id="<?php echo $meter_year->meter_reading_year ; ?>" class="tab-pane fade in <?php if(date("Y") == $meter_year->meter_reading_year){echo 'active'; } ?>">
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <br />

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
        <div id="modal_confirmation" class="modal fade" tabindex="-1" role="dialog"><!--modal-->
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header ">
                        <button type="button" class="close"   data-dismiss="modal" aria-hidden="true">X</button>
                        <h4 class="modal-title" style="color:white;"><span id="modal_mode"> </span>Print Consumption History</h4>
                    </div>
                    <div class="modal-body">
                        <p id="modal-body-message">Select a Year</p>
                            <select id="cbo_print_year" style="width: 100%;">
                                    <?php foreach($meter_years as $meter_year){ ?>
                                        <option value="<?php echo $meter_year->meter_reading_year; ?>"><?php echo $meter_year->meter_reading_year; ?></option>
                                    <?php } ?>
                            </select>
                    </div>
                    <div class="modal-footer">
                        <button id="btn_yes" type="button" class="btn btn-danger" data-dismiss="modal" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;">Yes</button>
                        <button id="btn_close" type="button" class="btn btn-default" data-dismiss="modal" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;">No</button>
                    </div>
                </div>
            </div>
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
        var _cboAccounts; var _cboPrintYear;
        var initializeControls=function(){
            
        _cboAccounts=$("#cbo_accounts").select2({
            templateResult: function(data) {
                var r = data.text.split('|');
                    var $result = $(
                        '<div class="row">' +
                            '<div class="col-md-3">' + r[0] + '</div>' +
                            '<div class="col-md-6">' + r[1] + '</div>' +
                            '<div class="col-md-3">' + r[2] + '</div>' +
                        '</div>'
                    );
                    return $result;
            },
            placeholder: "Please Select an Account.",
            allowClear: false
        });
        _cboPrintYear=$("#cbo_print_year").select2({
            placeholder: "Please Select a Year.",
            allowClear: false
        });
        _cboAccounts.select2('val',null);
        _cboPrintYear.select2('val',null);
        reInitializeTables();
        }();

        var bindEventControls=function(){
            _cboAccounts.on('select2:select', function(){
                reInitializeTables();
            });
            $('#btn_print').click(function(){
                if(_cboAccounts.val() =='' || _cboAccounts.val() ==null){
                    showNotification({title:"Error !",stat:"error",msg:"Please Select an Account."});
                }else{ $('#modal_confirmation').modal('show'); }
            });
            $('#btn_yes').click(function(){
                window.open('Customer_consumption_history/transaction/consumption-history-print?scid='+$('#cbo_accounts').val()+'&y='+$('#cbo_print_year').val());
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


function reInitializeTables (){
         var data = [];
         data.push({name : "scid" ,value : $('#cbo_accounts').val()});
         $('#details_loader').show();
         $('#div_details,#div_tab_container').hide();
        $.ajax({
            url : 'Customer_consumption_history/transaction/consumption-history',
            type : "GET",
            cache : false,
            dataType : 'json',
            "data":data,
            success : function(response){
                $('#details_loader').hide();
                $('.tab-pane').html('');
                $.each(response.years, function(index,value){

                    $('#'+value.meter_reading_year).append(
                    '<table style="width:100%" class="table table-striped">'+
                    '<thead>'+
                    '<th width="15%"></th>'+
                    '<th>Reading</th>'+
                    '<th>Consumption</th>'+                    
                    '<th>Amount</th>'+                    
                    '</thead>'+
                        '<tbody id="tbody_'+value.meter_reading_year+'">'+

                        '</tbody>'+
                         '</table>'
                    );


                });

                    $.each(response.years, function(index,sug){
                    $.each(response.months, function(index,value){


                        $('#tbody_'+sug.meter_reading_year).append(
                            '<tr>'+
                            '<td><b>'+value.month_name+'</b></td>'+
                            '<td id="'+sug.meter_reading_year+'_'+pad(value.month_id,2)+'_r"></td>'+
                            '<td id="'+sug.meter_reading_year+'_'+pad(value.month_id,2)+'_c"></td>'+
                            '<td id="'+sug.meter_reading_year+'_'+pad(value.month_id,2)+'_a"></td>'+

                            '</tr>');

                            // if(sug.meter_reading_year == data.meter_reading_year && pad(value.month_id, 2) == data.month_id){
                            //     $('#tbody_'+sug.meter_reading_year).append(
                            //         '<tr>'+
                            //         '<td><b>'+value.month_name+'</b></td>'+
                            //         '<td>'+sug.meter_reading_year+'</td>'+
                            //         '<td>asd</td>'+
                            //         '</tr>');

                            // }else if (sug.meter_reading_year == data.meter_reading_year){
                            //     $('#tbody_'+sug.meter_reading_year).append(
                            //         '<tr>'+
                            //         '<td><b>'+value.month_name+'</b></td>'+
                            //         '<td>'+sug.meter_reading_year+'</td>'+
                            //         '<td></td>'+
                            //         '</tr>');

                            // }


                    });

                   
                });

                $.each(response.data, function(index,data){
                        $('#'+data.meter_reading_year+'_'+pad(data.month_id,2)+'_c').text(data.current);
                });


                $('#div_details,#div_tab_container').show();
            } // END OF SUCCESS

        }); // END OF AJAX

        $.ajax({
            url : 'Customer_consumption_history/transaction/consumption-history-info',
            "dataType":"html",
            "type":"GET",
            "data":data,
            success : function(response){
                $("#div_details").html(response);
            } // END OF SUCCESS

        }); // END OF AJAX


} // END OF FUNCION reInitializeTables
function pad (str, max) {
  str = str.toString();
  return str.length < max ? pad("0" + str, max) : str;
}
    });
</script>


</body>

</html>