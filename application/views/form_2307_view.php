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
	                    <li><a href="Form_2307">Bir Form 2307</a></li>
	                </ol>

	                <div class="container-fluid" id="div_form_list">
	                    <div class="panel panel-default" >
	                    	<!-- <div class="panel-heading" style="background: #2ecc71;border-bottom: 1px solid lightgrey;;"><b style="color:white;font-size: 12pt;"><i class="fa fa-bars"></i> </b></div> -->
		                    <div class="panel-body">
                            <h2 class="h2-panel-heading">Bir Form 2307 </h2><hr>
		                    	<div class="row">
		                    		<div class="container-fluid">
                                        <div class="container-fluid group-box">
                                         <button class="btn btn-primary" id="btn_new" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;margin-bottom: 0px !important; float: left;" data-toggle="modal" data-target="" data-placement="left" title=" New product" ><i class="fa fa-plus"></i>  New </button>

                                            <table id="tbl_list" class="table table-striped" cellspacing="0" width="100%" style="background-color: transparent !important;";>
                                                <thead>
                                                <tr>
                                                    <th >Date</th>
                                                    <th >Supplier</th>
                                                    <th >Payee Name</th>
                                                    <th >Gross Amount</th>
                                                    <th >Deducted Amount</th>
                                                    <th ><center>Action</center></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    
                                                </tbody>
                                                

                                            </table>



                                        </div><br>

		                    		</div>		                    	
		                    	</div>
		                    </div>
		                    <div class="panel-footer"></div>
	                    </div>
                    </div>
                        <div class="container-fluid" style="display: none;" id="div_form_fields" >
                        <div class="panel panel-default" >
                            <div class="panel-body">
                            <h2 class="h2-panel-heading">Generate New </h2><hr>
                            <form id="frm_journal" role="form" class="form-horizontal">
                                <div class="row">
                                    <div class="container-fluid">
                                        <div class="container-fluid group-box">

                                        <div class="col-xs-12 col-md-6">
                                            <strong>Supplier * : </strong><br>
                                                <select name="supplier_id" id="new_supplier" data-error-msg="Supplier is required." required >
                                                    <option value="0">Please Select a Supplier</option>
                                                    <?php foreach($suppliers as $row) {  ?>

                                                     <option value="<?php echo $row->supplier_id ?>" data-address="<?php echo $row->address ?>" data-tin="<?php echo $row->tin_no ?>" data-name="<?php echo $row->supplier_name ?>"><?php echo $row->supplier_name ?></option>';

                                                     <?php } ?>
                                                </select>
                            
                                        </div>

                                        <div class="col-xs-12 col-md-3">
                                        <strong>Month : </strong><br>
                                        <select  name="month" id="month">
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
                                        <div class="col-xs-12 col-md-3">
                                        <strong>Year : </strong><br>
                                            <select name="year" id="year"  required>
                                                <?php 
                                                    $now = date('Y');

                                                    $minyear=date('Y', strtotime('-3 years')); 
                                                    $maxyear=date('Y', strtotime('+3 years'));
                                                      while($minyear!=$maxyear){
                                                          echo '<option value='.$minyear.' '.($now == $minyear ? 'selected' : '').'>'.$minyear.'</option>';
                                                          $minyear++;
                                                      }
                                                ?>
                                            </select>
                                        </div>
                                        </div><br>
                                        <div class="container-fluid group-box">
                                            <div class="col-xs-12 col-md-3">
                                            Tin: (XXX-XXX-XXX-XXXX)<br>
                                            <input type="text" name="payee_tin" id="payee_tin" class="form-control" required>
                                            </div>
                                            <div class="col-xs-12 col-md-3">
                                            Payee's Name:<br>
                                            <input type="text" name="payee_name" id="payee_name" class="form-control" required>
                                            </div>
                                            <div class="col-xs-12 col-md-6">
                                            Registered Address:<br>
                                            <input type="text" name="payee_address" id="payee_address" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="container-fluid group-box">
                                            <div class="col-xs-12 col-md-3">
                                            Tin: (XXX-XXX-XXX-XXXX)<br>
                                            <input type="text" name="payor_tin" id="payor_tin" class="form-control" value="<?php  echo $company_info->tin_no?>" required>
                                            </div>
                                            <div class="col-xs-12 col-md-3">
                                            Payor's Name:<br>
                                            <input type="text" name="payor_name" id="payor_name" class="form-control" value="<?php  echo $company_info->company_name?>" required>
                                            </div>
                                            <div class="col-xs-12 col-md-6">
                                            Registered Address:<br>
                                            <input type="text" name="payor_address" id="payor_address" class="form-control" value="<?php  echo $company_info->company_address?>" required>
                                            
                                            


                                            </div>
                                        </div>
                                        <div class="container-fluid group-box">
                                            <div class="col-xs-12 col-md-3">
                                            Gross Amount: <br>
                                            <input type="text" name="gross_amount" class="form-control" id="total_total" readonly>
                                            </div>
                                            <div class="col-xs-12 col-md-3">
                                            Deducted Amount:<br>
                                            <input type="text" name="deducted_amount" class="form-control" id="total_deducted" readonly>
                                            </div>
                                        </div>
                                        <div class="container-fluid group-box">
                                            <table id="tbl_reference" class="table table-striped" cellspacing="0" width="100%" style="background-color: transparent !important;";>
                                                <thead>
                                                <tr>
                                                    <th></th>
                                                    <th >Date</th>
                                                    <th >Gross Amount</th>
                                                    <th >Tax Percent</th>
                                                    <th >Deducted Amount</th>
                                                    <th >Reference No.</th>

                                                </tr>
                                                </thead>
                                                        <tfoot>
                                                            <tr>
                                                                <td id="footer-id"></td>
                                                                <td  style="text-align:right;font-size: 11px;"><b>Total</b></td>
                                                                <td  style="text-align:right;font-size: 11px;"></td>
                                                                <td  style="text-align:right;font-size: 11px;"></td>
                                                                <td style="text-align:right;font-size: 11px;"></td>
                                                                <td  style="text-align:right;font-size: 11px;"></td>
                                                            </tr>
                                                        </tfoot>
                                                <tbody>
                                                    
                                                </tbody>
                                                

                                            </table>

                                        </div>
                                    </div>

                                </div>
                            </form>
                            </div>
                            <div class="panel-footer" >
                                <div class="row">
                                    <div class="col-sm-12">
                                        <button id="btn_generate" class="btn-primary btn" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;"><span class=""></span>Generate</button>
                                        <button id="btn_cancel" class="btn-default btn" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>






	            	</div> <!-- .container-fluid -->






<div id="modal_confirmation" class="modal fade" tabindex="-1" role="dialog"><!--modal-->
    <div class="modal-dialog modal-sm">
        <div class="modal-content"><!---content-->
            <div class="modal-header ">
                <button type="button" class="close"   data-dismiss="modal" aria-hidden="true">X</button>
                <h4 class="modal-title" style="color: white;"><span id="modal_mode"> </span>Confirm Deletion</h4>

            </div>

            <div class="modal-body">
                <p id="modal-body-message">Are you sure you want to delete this record?</p>

                <i>Deleted by : <?php echo $this->session->user_fullname; ?></i>
            </div>

            <div class="modal-footer">
                <button id="btn_yes" type="button" class="btn btn-danger" data-dismiss="modal" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;">Yes</button>
                <button id="btn_close" type="button" class="btn btn-default" data-dismiss="modal" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;">No</button>
            </div>
        </div><!---content-->
    </div>
</div><!---modal-->







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
    	var dt; var _cbo_suppliers; var year; var _month; var dtable; var _selectedID;
    	 $('.isNumeric').autoNumeric('init');
        _cbo_suppliers=$('#new_supplier').select2({
            allowClear: false
        });

        year =$('#year').select2({
            allowClear:false
        });

        _month =$('#month').select2({
            allowClear:false
        });
       var initializeControls=function(){

            initializeDataTable();
          initializeList();
        }();

        var bindEventHandlers=function() {
            var detailRows = [];
            $('#tbl_reference tbody').on( 'click', 'tr td.details-control', function () {
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
            } );

        	$('#month').on('change', function() {
                dt.clear().destroy();
        		initializeDataTable();
        	
        	});
            $('#new_supplier').on('change', function() {
                dt.clear().destroy();
                initializeDataTable();
            
            });


        $('#tbl_list').on('click','button[name="remove_info"]',function(){
            _selectRowObj=$(this).closest('tr');
            var data=dtable.row(_selectRowObj).data();
            _selectedID=data.form_2307_id;
            $('#modal_confirmation').modal('show');
        });

        $('#tbl_list').on('click','button[name="btn_print"]',function(){
            _selectRowObj=$(this).closest('tr');
            var data=dtable.row(_selectRowObj).data();
            _selectedID=data.form_2307_id;
            // alert(_selectedID);
            window.open('Form_2307/transaction/print?id='+_selectedID)
        });


        _cbo_suppliers.on("select2:select", function (e) {
            var i=$(this).select2('val');
            var _cbo_suppliers=$('#new_supplier').find('option[value="' + i + '"]');
            // alert(_cbo_suppliers.data('address'));
            $('#payee_address').val(_cbo_suppliers.data('address'));
            $('#payee_tin').val(_cbo_suppliers.data('tin'));
            $('#payee_name').val(_cbo_suppliers.data('name'));
        });

            $('#btn_yes').click(function(){
                $.ajax({
                    "dataType":"json",
                    "type":"POST",
                    "url":"Form_2307/transaction/delete",
                    "data":{form_2307_id : _selectedID},
                    "success": function(response){
                        showNotification(response);
                        if(response.stat=="success"){
                            dtable.row(_selectRowObj).remove().draw();
                        }

                    }
                });
            });
            $('#btn_generate').on('click',function(){
                // $('#finalize').modal('hide');  
                if(validateRequiredFields('#frm_journal')){

                    if($('#total_total').val() == 0){
                            showNotification({title:"Error!",stat:"error",msg:"Gross Amount must not be zero."});
                    }else{
                        createForm().done(function(response){
                            showNotification(response);
                            
                            if(response.stat=="success"){
                                dtable.row.add(response.row_added[0]).draw();
                                clearFields($('#frm_journal'));
                                showList(true);
                               
                            }

                        }).always(function(){
                            showSpinningProgress($('#btn_generate'));
                        });


                    }

                }




            });

        	$('#year').on('change', function() {
                dt.clear().destroy();
        		initializeDataTable();
      
        	});

            $('#btn_new').on('click', function() {
                // alert();
            

            _month.select2('val','01');
            _cbo_suppliers.select2('val',0);
            
            showList(false);
            });

            $('#btn_cancel').on('click',function(){

            showList(true);

            });

            var createForm=function(){
                var _data=$('#frm_journal').serializeArray();
                console.log(_data);
                showSpinningProgress($('#btn_generate'))
                return $.ajax({
                    "dataType":"json",
                    "type":"POST",
                    "url":"Form_2307/transaction/create",
                    "data":_data

                });
            };

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

            var validateRequiredFields=function(f){
                var stat=true;
                $('div.form-group').removeClass('has-error');
                $('input[required]',f).each(function(){
                        if($(this).is('select')){
                            if($(this).val()==0 || $(this).val()==null || $(this).val()==undefined || $(this).val()==""){
                                showNotification({title:"Error!",stat:"error",msg:'All fields are required.'});
                                $(this).closest('div.form-group').addClass('has-error');
                                $(this).focus();
                                stat=false;
                                return false;
                            }
                        }else{
                            if($(this).val()==""){
                                showNotification({title:"Error!",stat:"error",msg:'All fields are required.'});
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
                    $('#div_form_list').show();
                    $('#div_form_fields').hide();
                }else{
                    $('#div_form_list').hide();
                    $('#div_form_fields').show();
                }
            };
        }();

        function initializeDataTable(){
        	dt=$('#tbl_reference').DataTable({
        		"dom": '<"toolbar">frtip',
        		"bLengthChange":false,
        		  "paging": false,
        		    "bInfo" : false,
                    "bSort": false,
        		"language": {
        			"searchPlaceholder":"Search"
        		},
        		"ajax":{
        			"url": "Form_2307/transaction/list",
                    "type": "GET",
                    "bDestroy": true,
                    "data": function ( d ) {
                        return $.extend( {}, d, {
                            "month":$('#month').val(),
                            "year":$('#year').val(),
                            "sup_id":$('#new_supplier').val()

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
                    { "searchable": true,targets:[1],data: "date_txn" },
                    { "searchable": true, sClass:'right-align', targets:[2],data: "amount", 
                        render: $.fn.dataTable.render.number( ',', '.', 2 )
                    }, 
                    { sClass:'right-align',targets:[3],data: "tax_output" },  
                    { sClass:'right-align', targets:[4],data: "tax_deducted", 
                        render: $.fn.dataTable.render.number( ',', '.', 2 )
                    },
                    { "searchable": true,targets:[5],data: "txn_no" },  

                ],



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
 
             // Total over all pages


            gross = api
                .column( 2, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    // console.log(intVal(a) + intVal(b));
                    return intVal(a) + intVal(b);
                }, 0 );


                    // Update footer
            $( api.column( 2 ).footer() ).html(
                '<b>'+accounting.formatNumber(gross,2) +'</b>'
            );

            total_deducted = api
                .column( 4, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    // console.log(intVal(a) + intVal(b));
                    return intVal(a) + intVal(b);
                }, 0 );


                    // Update footer
            $( api.column( 4 ).footer() ).html(
                '<b>'+accounting.formatNumber(total_deducted,2) +'</b>'
            );

            $("#footer-id").removeClass("details-control");
            $('#total_deducted').val(accounting.formatNumber(total_deducted,2));
            $('#total_total').val(accounting.formatNumber(gross,2));



        }
        	});

        };

        function initializeList(){
            dtable=$('#tbl_list').DataTable({
                "dom": '<"toolbar">frtip',
                "bLengthChange":false,
                  // "paging": false,
                  //   "bInfo" : false,
                  //   "bSort": false,
                "language": {
                    "searchPlaceholder":"Search"
                },
                "ajax":{
                    "url": "Form_2307/transaction/list-table",
                    "type": "GET",
                    "bDestroy": true
                },
                "columns": [
                    {
                       
                        targets:[0],data: "form_date" 
                    },
                      { "searchable": true,targets:[1],data: "supplier_name" }, 

                      { "searchable": true,targets:[2],data: "payee_name" }, 
                    { sClass:'right-align',"searchable": true, sClass:'right-align', targets:[3],data: "gross_amount", 
                        render: $.fn.dataTable.render.number( ',', '.', 2 )
                    },  
                    { sClass:'right-align', targets:[4],data: "deducted_amount", 
                        render: $.fn.dataTable.render.number( ',', '.', 2 )
                    },
                   
                    {
                        targets:[5],
                        render: function (data, type, full, meta){
                            var btn_print='<button class="btn btn-success btn-sm" name="btn_print" style="margin-right:0px;" data-toggle="tooltip" data-placement="top" title="Print"><i class="fa fa-print"></i> </button>';
                            var btn_cancel='<button class="btn btn-red btn-sm" name="remove_info" style="margin-right:0px;" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-times"></i> </button>';

                            return '<center>'+btn_print+' '+btn_cancel+'</center>';
                        }
                    }

                ]
            });

        };

    var clearFields=function(f){
        $('input,textarea',f).val('');
    };




    });
</script>



</body>

</html>