<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from avenxo.kaijuthemes.com/ui-typography.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 06 Jun 2016 12:09:25 GMT -->
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


    <link href="assets/plugins/select2/select2.min.css" rel="stylesheet">
    <link type="text/css" href="assets/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">
    <link type="text/css" href="assets/plugins/datatables/dataTables.themify.css" rel="stylesheet">

    <link type="text/css" href="assets/plugins/zTree/zTreeStyle.css" rel="stylesheet">

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

        #zTreeDemoBackground { 
            overflow: auto;
        }

        #tbl_matrixes_filter{
            display: none;
        }
        .numeric{
            text-align: right;
        }
    </style>
</head>

<body class="animated-content">

<?php echo $_top_navigation; ?>

<div id="wrapper">
<div id="layout-static">


<?php echo $_side_bar_navigation;

?>


<div class="static-content-wrapper white-bg">


<div class="static-content"  >
    <div class="page-content"><!-- #page-content -->

        <ol class="breadcrumb" style="margin:0;">
            <li><a href="dashboard">Dashboard</a></li>
            <li><a href="Matrix_commercial">Commercial Rate Matrix</a></li>
        </ol>
        <div class="container-fluid">
            <div data-widget-group="group1">
                <div class="row">
                    <div class="col-md-12">
                        <div id="div_chart_list">
                            <div class="panel panel-default">
                                <div class="panel-body table-responsive">
                            <h2 class="h2-panel-heading">Commercial Rate Matrix</h2><hr>
                             <!--    <div class="panel-heading">
                                    <b style="color: white; font-size: 12pt;"><i class="fa fa-bars"></i>&nbsp; Chart of Accounts</b>
                                </div> -->
                                <div class="row" id="treeListWrapper">
                                    <div class="col-xs-12 col-lg-12">
                                        <div class="panel-body table-responsive" style="padding-left: 1px!important;border-top-color:transparent!important;">
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <button class="btn btn-primary"  id="btn_new" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;" data-toggle="modal" data-target="" data-placement="left" title="New Matrix" ><i class="fa fa-plus"></i> New Matrix</button>
                                                </div>
                                                <div class="col-sm-3">
                                                </div>
                                                <div class="col-sm-3">
                                                </div>
                                                <div class="col-sm-3">
                                                    <input type="text" placeholder="Search" class="form-control" id="searchbox_tbl_matrixes">
                                                </div>
                                            </div>
                                        <br>
                                            <table id="tbl_matrixes" class="table table-striped" cellspacing="0" width="100%">
                                                <thead class="">
                                                <tr>
                                                    <th>&nbsp;&nbsp;</th>
                                                    <th style="">Matrix Code</th>
                                                    <th style="">Matrix Description</th>
                                                    <th>Other Details</th>
                                                    <th style="width: 15%;"><center>Action</center></th>
                                                </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>


                        <div id="div_account_fields" style="display: none;">
                            <div class="panel panel-default" style="border-top: 3px solid #2196f3;">
                                <div class="panel-body">
                                    <h2 class="h2-panel-heading" id="account_add_title"></h2><hr>
                                    <form id="frm_accounts" role="form" class="form-horizontal row-border">
                                        <div class="form-group">
                                            <label class="col-md-2 control-label"><strong>* Matrix Description :</strong></label>
                                            <div class="col-md-9">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-code"></i>
                                                    </span>
                                                    <input type="text" name="description" id="" class="form-control" placeholder="Description" data-error-msg="Matrix Rate Description is required!" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2 control-label"><strong>Other Details :</strong></label>
                                            <div class="col-md-9">
                                                <textarea name="other_details" class="form-control"></textarea>
                                            </div>
                                        </div>

                                        <br>
                                        <div class="row">
                                            <div class="col-sm-12">
                                            <table id="tbl_matrix_form" class="table table-striped" cellspacing="0" width="100%">
                                                <thead class="">
                                                    <tr>
                                                        <th>From</th>
                                                        <th style="">To</th>
                                                        <th>Rate Amount</th>
                                                        <th style="width: 15%;">Is Fixed Amount?</th>
                                                        <th style="width: 15%;">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                            </div>
                                        </div>
                                        <br /><br /><br />
                                    </form>
                                </div>
                                <div class="panel-footer">
                                    <div class="row ">
                                        <div class="col-sm-12">
                                            <button id="btn_save" class="btn-primary btn" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;""><span class=""></span>  Save Changes</button>
                                            <button id="btn_cancel" class="btn-default btn" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;"">Cancel</button>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>

                <table id="table_hidden" class="hidden">
                    <tr>
                        <td><input type="text" name="matrix_commercial_from[]" class="form-control number" required data-error-msg="Range From is required!"></td>
                        <td><input type="text" name="matrix_commercial_to[]" class="form-control number" required data-error-msg="Range To is required!"></td>
                        <td><input type="text" name="matrix_commercial_amount[]" class="form-control numeric" required data-error-msg="Rate Amount is required!"></td>
                        <td><input type="checkbox" name="is_fixed_amount[]" class="form-control" value="1"></td>
                        <td>
                            <button type="button" class="btn btn-default add_account"><i class="fa fa-plus-circle" style="color: green;"></i></button>
                            <button type="button" class="btn btn-default remove_account"><i class="fa fa-times-circle" style="color: red;"></i></button>
                        </td>
                    </tr>
                </table>
                    </div>
                </div>
            </div>
        </div> <!-- .container-fluid -->

    </div> <!-- #page-content -->
</div>


<div id="modal_confirmation" class="modal fade" tabindex="-1" role="dialog"><!--modal-->
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close"   data-dismiss="modal" aria-hidden="true">X</button>
                <h4 class="modal-title" style="color:white;><span id="modal_mode"> </span>Confirm Deletion</h4>

            </div>

            <div class="modal-body">
                <p id="modal-body-message">Are you sure ?</p>
            </div>

            <div class="modal-footer">
                <button id="btn_yes" type="button" class="btn btn-danger" data-dismiss="modal">Yes</button>
                <button id="btn_close" type="button" class="btn btn-default" data-dismiss="modal">No</button>
            </div>
        </div>
    </div>
</div><!---modal-->









<footer role="contentinfo">
    <div class="clearfix">
        <ul class="list-unstyled list-inline pull-left">
            <li><h6 style="margin: 0;">&copy; 2018 - JDEV Office Solution </h6></li>
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

<!-- Select2 -->
<script src="assets/plugins/select2/select2.full.min.js"></script>
<script type="text/javascript" src="assets/plugins/zTree/jquery.ztree.core.js"></script>
<script src="assets/plugins/formatter/autoNumeric.js" type="text/javascript"></script>
<script src="assets/plugins/formatter/accounting.js" type="text/javascript"></script>
<script>
$(document).ready(function(){
    var dt; var _txnMode; var _selectedID; var _selectRowObj; 

    var initializeControls=function(){

        dt=$('#tbl_matrixes').DataTable({
            "dom": '<"toolbar">frtip',
            "bLengthChange":false,
            "pageLength": 15,
                "order": [[ 1, "desc" ]],
            "ajax" : "Matrix_commercial/transaction/list",
            "columns": [
                { 
                    "targets": [0],
                    "class":          "details-control",
                    "orderable":      false,
                    "data":           null,
                    "defaultContent": ""
                },
                { targets:[1],data: "matrix_commercial_code" },
                { targets:[2],data: "description" },
                { targets:[3],data: "other_details" },
                {
                    targets:[4],
                    render: function (data, type, full, meta){
                        var btn_edit='<button class="btn btn-primary btn-sm" name="edit_info"  style="margin-left:-15px;" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil"></i> </button>';
                        var btn_trash='<button class="btn btn-red btn-sm" name="remove_info" style="margin-right:0px;" data-toggle="tooltip" data-placement="top" title="Move to trash"><i class="fa fa-trash-o"></i> </button>';

                        return '<center>'+btn_edit+'&nbsp;'+btn_trash+'</center>';
                    }
                }
            ]
        });

         reInitializeNumeric();

    }();






    var bindEventHandlers=(function(){
        var detailRows = [];

        $('#tbl_matrixes tbody').on( 'click', 'tr td.details-control', function () {
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
                var d=row.data();
                $.ajax({
                    "dataType":"html",
                    "type":"POST",
                    "url":"Templates/layout/commercial-matrix/"+ d.matrix_commercial_id,
                    "beforeSend" : function(){
                        row.child( '<center><br /><img src="assets/img/loader/ajax-loader-lg.gif" /><br /><br /></center>' ).show();
                    }
                }).done(function(response){
                    row.child( response,'no-padding' ).show();
                    if ( idx === -1 ) {
                        detailRows.push( tr.attr('id') );
                    }
                });
            }
        } );


        $('#btn_new').click(function(){
            _txnMode="new";
            $('#account_add_title').text('New Commercial Rate Matrix');
            $( "input[name='description']" ).val('');
            $( "textarea[name='other_details']" ).val('');
            $('#tbl_matrix_form tbody').html('');
            $('#tbl_matrix_form tbody').append($('#table_hidden').find('tr').clone());
            reInitializeNumeric();
            showList(false);
        });

        $("#searchbox_tbl_matrixes").keyup(function(){         
            dt
                .search(this.value)
                .draw();
        });

        $('#btn_print').click(function(){
              window.open('Account_titles/transaction/print');
        });
        $('#btn_excel').click(function(){
              window.open('Account_titles/Export');
        });

        $('#tbl_matrix_form').on('click','button.add_account',function(){

            var row=$('#table_hidden').find('tr');
            row.clone().insertAfter('#tbl_matrix_form > tbody tr:last');
            reInitializeNumeric();
            // reInitializeNumeric();

        });

        $('#tbl_matrix_form').on('click','button.remove_account',function(){
            var oRow=$('#tbl_matrix_form > tbody tr');

            if(oRow.length>1){
                $(this).closest('tr').remove();
            }else{
                showNotification({"title":"Error!","stat":"error","msg":"Sorry, you cannot remove all rows."});
            }
        });

        $('#btn_create_account_class').click(function(){

            var btn=$(this);

            if(validateRequiredFields($('#frm_account_classes'))){
                var data=$('#frm_account_classes').serializeArray();

                $.ajax({
                    "dataType":"json",
                    "type":"POST",
                    "url":"Account_classes/transaction/create",
                    "data":data,
                    "beforeSend" : function(){
                        showSpinningProgress(btn);
                    }
                }).done(function(response){
                    showNotification(response);
                    $('#modal_new_account_class').modal('hide');

                    var _class=response.row_added[0];
                    $('#cbo_account_class').append('<option value="'+_class.account_class_id+'" selected>'+_class.account_class+'</option>');
                    $('#cbo_account_class').select2('val',_class.account_class_id);

                }).always(function(){
                    showSpinningProgress(btn);
                });
            }





        });


        $('#tbl_matrixes tbody').on('click','button[name="edit_info"]',function(){
            ///alert("ddd");
            _txnMode="edit";
            _selectRowObj=$(this).closest('tr');
            var data=dt.row(_selectRowObj).data();
            _selectedID=data.matrix_commercial_id;

            $('input,textarea,select').each(function(){
                var _elem=$(this);
                $.each(data,function(name,value){

                        if(_elem.attr('name')==name){
                            _elem.val(value);
                        }
                });
            });

            $('#account_add_title').text('Edit Commercial Rate Matrix');


            $.ajax({
                url : 'Matrix_commercial/transaction/edit-items/'+data.matrix_commercial_id,
                type : "GET",
                cache : false,
                dataType : 'json',
                processData : false,
                contentType : false,
                beforeSend : function(){
                    $('#tbl_matrix_form > tbody').html('<tr><td align="center" colspan="5"><br /><img src="assets/img/loader/ajax-loader-sm.gif" /><br /><br /></td></tr>');
                },
                success : function(response){
                    var rows=response.data;
                    $('#tbl_matrix_form > tbody').html('');
                    $.each(rows,function(i,value){
                        $('#tbl_matrix_form > tbody').append(newRowItem({
                            matrix_commercial_from : value.matrix_commercial_from,
                            matrix_commercial_to : value.matrix_commercial_to,
                            matrix_commercial_amount : value.matrix_commercial_amount,
                            is_fixed_amout_checked : value.is_fixed_amout_checked

                        }));

                    });
                }

            });
            reInitializeNumeric();
            showList(false);

        });

        $('#tbl_matrixes tbody').on('click','button[name="remove_info"]',function(){
            _selectRowObj=$(this).closest('tr');
            var data=dt.row(_selectRowObj).data();
            _selectedID=data.matrix_commercial_id;
            $('#modal_confirmation').modal('show');
        });

        $('#btn_yes').click(function(){
            removeAccount().done(function(response){
                showNotification(response);
                if(response.stat=='success') {
                    dt.row(_selectRowObj).remove().draw();
                }
            });
        });



        $('#btn_cancel').click(function(){
            $('#tbl_matrix_form tbody').html('');
            showList(true);
        });

        $('#btn_save').click(function(){  
            if(validateRequiredFields($('#frm_accounts'))){
                if(_txnMode=="new"){
                    createAccountInfo().done(function(response){
                        showNotification(response);
                        if(response.stat=="success"){
                            dt.row.add(response.row_added[0]).draw();
                            showList(true);
                        }
                    }).always(function(){
                        showSpinningProgress($('#btn_save'));
                    });
                }else{
                    updateAccountInfo().done(function(response){
                        showNotification(response);
                        if(response.stat=="success"){
                            dt.row(_selectRowObj).data(response.row_updated[0]).draw(false);
                            showList(true);
                        }
                    }).always(function(){
                        showSpinningProgress($('#btn_save'));
                    });
                }
            }
        });


    })();


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

        return stat;
    };


    var createAccountInfo=function(){
        $('form#frm_accounts input:checkbox[name^=is_fixed_amount]').each(function () {
            if(!$(this).prop("checked")){
                $(this).html("<input type='hidden' name='is_fixed_amount[]' value='0' />")
            }
        });
        var _data=$('#frm_accounts').serializeArray();
        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Matrix_commercial/transaction/create",
            "data":_data,
            "beforeSend": showSpinningProgress($('#btn_save'))
        });
    };

    var updateAccountInfo=function(){
        $('form#frm_accounts input:checkbox[name^=is_fixed_amount]').each(function () {
            if(!$(this).prop("checked")){
                $(this).html("<input type='hidden' name='is_fixed_amount[]' value='0' />")
            }
        });
        var _data=$('#frm_accounts').serializeArray();
        _data.push({name : "matrix_commercial_id" ,value : _selectedID});
        console.log(_data)
        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Matrix_commercial/transaction/update",
            "data":_data,
            "beforeSend": showSpinningProgress($('#btn_save'))
        });
    };

    var removeAccount=function(){
        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Matrix_commercial/transaction/delete",
            "data":{matrix_commercial_id : _selectedID}
        });
    };

    var showList=function(b){
        if(b){
            $('#div_chart_list').show();
            $('#div_account_fields').hide();
        }else{
            $('#div_chart_list').hide();
            $('#div_account_fields').show();
        }
    };

    var showNotification=function(obj){
        PNotify.removeAll(); //remove all notifications
        new PNotify({
            title:  obj.title,
            text:  obj.msg,
            type:  obj.stat
        });
    };

    function reInitializeNumeric(){
        $('.numeric').autoNumeric('init',{mDec: 2});
        $('.number').autoNumeric('init', {mDec:0});
    };

    var showSpinningProgress=function(e){
        $(e).toggleClass('disabled');
        $(e).find('span').toggleClass('glyphicon glyphicon-refresh spinning');
    };

    var clearFields=function(f){
        $('input,textarea',f).val('');
        $('form').find('input:first').focus();
    };

    var newRowItem=function(d){
        return '<tr>'+
        //DISPLAY
        '<td  style=""><input name="matrix_commercial_from[]" type="text" class="number form-control" value="'+ accounting.formatNumber(d.matrix_commercial_from,0)+'"></td>'+
        '<td  style=""><input name="matrix_commercial_to[]" type="text" class="number form-control" value="'+ accounting.formatNumber(d.matrix_commercial_to,0)+'"></td>'+
        '<td  style=""><input name="matrix_commercial_amount[]" type="text" class="numeric form-control" value="'+ accounting.formatNumber(d.matrix_commercial_amount,2)+'"></td>'+
        '<td><input type="checkbox" name="is_fixed_amount[]" class="form-control" value="1" '+ d.is_fixed_amout_checked+'></td>'+
        '<td>'+
            '<button type="button" class="btn btn-default add_account"><i class="fa fa-plus-circle" style="color: green;"></i></button>'+
            '<button type="button" class="btn btn-default remove_account"><i class="fa fa-times-circle" style="color: red;"></i></button>'+
        ' </td>'+   
        '</tr>';
    };




});




</script>


</body>


</html>