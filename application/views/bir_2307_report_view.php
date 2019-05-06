<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="utf-8">

    <title>JCORE - <?php ECHO $title; ?></title>

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

        .select2-container{
            min-width: 100%;
        }
        .right-align{
            text-align: right;
        }
        td.details-control {
            background: url('assets/img/Folder_Closed.png') no-repeat center center;
            cursor: pointer;
        }
        tr.details td.details-control {
            background: url('assets/img/Folder_Opened.png') no-repeat center center;
        }
/*tr:nth-child(even){background-color:none !important;}*/
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
	                    <li><a href="Bir_2307_report">Bir Form 2307 Report</a></li>
	                </ol>

	                <div class="container-fluid">
	                    <div class="panel panel-default">
	                    	<!-- <div class="panel-heading" style="background: #2ecc71;border-bottom: 1px solid lightgrey;;"><b style="color:white;font-size: 12pt;"><i class="fa fa-bars"></i> </b></div> -->
		                    <div class="panel-body">
                            <h2 class="h2-panel-heading">Bir Form 2307 Report </h2><hr>
		                    	<div class="row">
		                    		<div class="container-fluid">
		                    			<div class="container-fluid group-box">
		                    				<div class="col-xs-12 col-md-6">
		                    					<strong>Start Date * : </strong><br>
		                    					<div class="input-group">
			                    					<input id="startDate" type="text" class="date-picker form-control" name="date_from" value="01/01/<?php echo date("Y"); ?>">
			                    					<div class="input-group-addon">
			                    						<i class="fa fa-calendar"></i>
			                    					</div>
		                    					</div>
		                    				</div>
			                    			<div class="col-xs-12 col-md-6">
		                    					<strong>End Date * : </strong><br>
			                    				<div class="input-group">
			                    					<input id="endDate" type="text" class="date-picker form-control" name="date_to" value="<?php echo date("m/d/Y"); ?>">
			                    					<div class="input-group-addon">
			                    						<i class="fa fa-calendar"></i>
			                    					</div>
		                    					</div>
		                    				</div>
			                    		</div><br>
                                        <div class="container-fluid group-box">
                                        <div class="col-xs-12 col-md-6">
                                            <strong>Supplier * : </strong><br>
                                                <select name="supplier_id" id="new_supplier" data-error-msg="Supplier is required." required >
                                                    <option value="0">Please Select a Supplier</option>
                                                    <?php foreach($suppliers as $row) {  ?>

                                                     <option value="<?php echo $row->supplier_id ?>" data-address="<?php echo $row->tin_no ?>"><?php echo $row->supplier_name ?></option>';

                                                     <?php } ?>
                                                </select>
                            
                                        </div>
                                        <div class="col-xs-12 col-md-6">
                                            <div class="col-md-6">TIN:<br><input type="text" id="tin_no" class="form-control" readonly></div>
                                            <div class="col-md-6"></div>
                                        </div>
                                        </div>
			                    		<div class="container-fluid group-box">
<!-- 			                    			<button class="btn btn-primary pull-left" style="margin-right: 5px; margin-top: 10px; margin-bottom: 10px;" id="btn_print"  data-toggle="modal" data-target="#salesInvoice" data-placement="left" title="Print" ><i class="fa fa-print"></i> Print Report
                                            </button>
                                            <button class="btn btn-success pull-left" style="margin-right: 5px; margin-top: 10px; margin-bottom: 10px;" id="btn_export"  data-toggle="modal" data-target="#salesInvoice" data-placement="left" title="Export" ><i class="fa fa-file-excel-o"></i> Export Report
                                            </button>
                                            <button class="btn btn-success pull-left" style="margin-right: 5px; margin-top: 10px; margin-bottom: 10px;" id="btn_email"  data-toggle="modal" data-target="#salesInvoice" data-placement="left" title="Email" ><i class="fa fa-share"></i> Email Report
                                            </button> -->
		                    				<table id="tbl_voucher_registry" class="table table-striped" cellspacing="0" width="100%" style="background-color: transparent !important;";>
		                    					<thead>
                                                <tr>   
                                                    <th >Date</th>
                                                    <th >Gross Amount</th>
                                                    <th >Tax Percent</th>
                                                    <th >Deducted Amount</th>
                                                    <th >Reference No.</th>

                                                </tr>
		                    					</thead>
		                    					<tbody>
		                    						
		                    					</tbody>
		                    					

		                    				</table>

			                    		</div>
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
    	var dt; var _cbo_suppliers;
    	 $('.isNumeric').autoNumeric('init');
        _cbo_suppliers=$('#new_supplier').select2({
            allowClear: false
        });

       var initializeControls=function(){
            $('.date-picker').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true
            });
          
            initializeDataTable();
          
        }();

        var bindEventHandlers=function() {
        	$('#startDate').on('change', function() {
        		dt.destroy();
        		initializeDataTable();
        	
        	});
            $('#new_supplier').on('change', function() {
                dt.destroy();
                initializeDataTable();
            
            });


        	$('#endDate').on('change', function() {
        		dt.destroy();
        		initializeDataTable();
      
        	});

        _cbo_suppliers.on("select2:select", function (e) {
            var i=$(this).select2('val');
            var _cbo_suppliers=$('#new_supplier').find('option[value="' + i + '"]');
            // alert(_cbo_suppliers.data('address'));
            $('#tin_no').val(_cbo_suppliers.data('address'));
        });


        	$('#btn_print').on('click', function() {
        		window.open('Collection_list_report/transaction/report?start='+ $('#startDate').val() +'&end='+ $('#endDate').val());
        	});

            $('#btn_export').on('click', function() {
                window.open('Collection_list_report/transaction/export?start='+ $('#startDate').val() +'&end='+ $('#endDate').val(),'_self');
            });

            $('#btn_email').on('click', function() {
                showNotification({title:"Sending!",stat:"info",msg:"Please wait for a few seconds."});

                var btn=$(this);
            
                $.ajax({
                    "dataType":"json",
                    "type":"POST",
                    "url":'Collection_list_report/transaction/email?start='+ $('#startDate').val() +'&end='+ $('#endDate').val(),
                    "beforeSend": showSpinningProgress(btn)
                }).done(function(response){
                    showNotification(response);
                    showSpinningProgress(btn);

                });
            });

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

        }();

        function initializeDataTable(){
        	dt=$('#tbl_voucher_registry').DataTable({
        		"dom": '<"toolbar">frtip',
        		"bLengthChange":false,
        		  "paging": false,
        		    "bInfo" : false,
                    "bSort": false,
        		"language": {
        			"searchPlaceholder":"Search"
        		},
        		"ajax":{
        			"url": "Bir_2307_report/transaction/list",
                    "type": "GET",
                    "bDestroy": true,
                    "data": function ( d ) {
                        return $.extend( {}, d, {
                            "start":$('#startDate').val(),
                            "end":$('#endDate').val(),
                            "sup_id":$('#new_supplier').val()

                        });
                    }
                },
                "columns": [
                    { "searchable": true,targets:[0],data: "date_txn" },
                    { "searchable": true, sClass:'right-align', targets:[3],data: "amount", 
                        render: $.fn.dataTable.render.number( ',', '.', 2 )
                    }, 
                    { sClass:'right-align',targets:[1],data: "tax_output" },  
                    { sClass:'right-align', targets:[3],data: "tax_deducted", 
                        render: $.fn.dataTable.render.number( ',', '.', 2 )
                    },
                    { "searchable": true,targets:[2],data: "txn_no" },  

                ]
        	});


        	




        };





    });
</script>



</body>

</html>