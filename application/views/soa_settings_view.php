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
 
    <link rel="stylesheet" href="assets/plugins/spinner/dist/ladda-themeless.min.css"> 
 
    <link type="text/css" href="assets/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet"> 
    <link type="text/css" href="assets/plugins/datatables/dataTables.themify.css" rel="stylesheet"> 
    <link href="assets/plugins/datapicker/datepicker3.css" rel="stylesheet"> 
    <link href="assets/plugins/select2/select2.min.css" rel="stylesheet"> 
 
 
 
    <style> 
 
/*        h4{ 
            color:white; 
        }*/ 
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
 
/*        .dropdown-menu > .active > a,.dropdown-menu > .active > a:hover{ 
            background-color: dodgerblue; 
        }*/ 
 
        @keyframes spin { 
            from { transform: scale(1) rotate(0deg); } 
            to { transform: scale(1) rotate(360deg); } 
        } 
 
        @-webkit-keyframes spin2 { 
            from { -webkit-transform: rotate(0deg); } 
            to { -webkit-transform: rotate(360deg); } 
        } 
 
        .table td{ 
          padding:   0px 10px 0px 10px!important; 
        } 
        label{ 
            font-weight: normal; 
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
 
<ol class="breadcrumb" style="margin-bottom: 0px;"> 
    <li><a href="dashboard">Dashboard</a></li> 
    <li><a href="Soa_settings">Statement of Account Settings</a></li> 
</ol> 
 
 
<div class="container-fluid"> 
<div data-widget-group="group1"> 
<div class="row"> 
    <div class="col-md-12"> 
        <div class="tab-container tab-top tab-primary"> 
            <ul class="nav nav-tabs"> 
                <li class="active"><a href="#soa_settings" data-toggle="tab" style="font-family: tahoma;">Statement of Accounts Settings</a></li> 
            </ul> 
            <div class="tab-content"> 
<!-- ITEM TRANSFER START --> 
            <div class="tab-pane active" id="soa_settings" style="min-height: 300px;"> 
                <form id="frm_account_integration_item_transfer" role="form" class="form-horizontal row-border"> 
      <!--                   <h4><span style="margin-left: 1%"><strong><i class="fa fa-gear"></i> Accounts Receivable Accounts </strong></span></h4> --> 
                            <i>Note: Please check the appropriate accounts to be included in the computation of SOA and Aging of Receivables</i> 
                                <table id="tbl_user_group_rights" class="table table-striped"  cellspacing="0" width="100%"> 
                                    <thead> 
                                    <tr> 
                                        <th width="80%">Description</th> 
                                        <th width="20%"></th> 
                                    </tr> 
                                    </thead> 
                                    <tbody> 
 
                                        <?php foreach($accounts as $account){ ?> 
                                            <tr style="border: 1px solid lightgray;"> 
                                                <td> 
                                                    <input type="checkbox" name="account_id[]" id="<?php echo $account->account_id; ?>" class="css-checkbox" value="<?php echo $account->account_id; ?>" <?php echo ($account->is_allowed == 1?' checked':''); ?>/> 
                                                    <label for="<?php echo $account->account_id; ?>" class="css-label "> 
                                                    <?php echo $account->account_title; ?> 
                                                    </label> 
                                                </td> 
                                                <td style="font-size:16px;"></td> 
                                            </tr> 
                                        <?php } ?> 
 
                                    </tbody> 
                                </table> 
 
                </form> 
                    <div class="col-sm-offset-3"> 
                        <button id="btn_save_soa_settings" type="button" class="btn btn-primary" style="font-family: tahoma;text-transform: none;"><span class=""></span> Save Account Changes</button> 
                    </div> 
            </div> 
 
<!-- ITEM TRANSFER END --> 
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
 
 
<script type="text/javascript" src="assets/plugins/datatables/jquery.dataTables.js"></script> 
<script type="text/javascript" src="assets/plugins/datatables/dataTables.bootstrap.js"></script> 
 
 
 
 
<!-- Date range use moment.js same as full calendar plugin --> 
<script src="assets/plugins/fullcalendar/moment.min.js"></script> 
<!-- Data picker --> 
<script src="assets/plugins/datapicker/bootstrap-datepicker.js"></script> 
 
<!-- Select2 --> 
<script src="assets/plugins/select2/select2.full.min.js"></script> 
 
 
 
 
 
<script> 
$(document).ready(function(){ 
    var dt; var _txnMode; var _selectedID; var _selectRowObj; var _accounts; 
 
 
 
    var initializeControls=function(){ 
        $('.date-picker').datepicker({ 
            todayBtn: "linked", 
            keyboardNavigation: false, 
            forceParse: false, 
            calendarWeeks: true, 
            autoclose: true 
 
        }); 
    }(); 
 
 
 
 
 
 
    var bindEventHandlers=(function(){ 
            $('#btn_save_soa_settings').click(function(){ 
                saveSettingsItemTransfer().done(function(response){ 
                    showNotification(response); 
                }).always(function(){ 
                    showSpinningProgress($('#btn_save_soa_settings')); 
                }); 
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
 
 
 
    var saveSettingsItemTransfer=function(){ 
        var _data=$('#frm_account_integration_item_transfer').serializeArray(); 
        console.log(_data); 
 
        return $.ajax({ 
            "dataType":"json", 
            "type":"POST", 
            "url":"Soa_settings/transaction/save_accounts", 
            "data":_data, 
            "beforeSend": showSpinningProgress($('#btn_save_soa_settings')) 
 
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
 
    var clearFields=function(f){ 
        $('input,textarea',f).val(''); 
        $(f).find('select').select2('val',null); 
        $(f).find('input:first').focus(); 
    }; 
 
    var showList=function(b){ 
        if(b){ 
            $('#div_account_year_list').show(); 
            $('#div_account_year_fields').hide(); 
        }else{ 
            $('#div_account_year_list').hide(); 
            $('#div_account_year_fields').show(); 
        } 
    }; 
 
 
}); 
 
 
 
 
</script> 
 
 
</body> 
 
 
</html>