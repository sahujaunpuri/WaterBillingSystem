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


    <link type="text/css" href="assets/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">
    <link type="text/css" href="assets/plugins/datatables/dataTables.themify.css" rel="stylesheet">
   <link href="assets/plugins/datapicker/datepicker3.css" rel="stylesheet">
    <link href="assets/plugins/select2/select2.min.css" rel="stylesheet">
    <!--/twitter typehead-->
    <link href="assets/plugins/twittertypehead/twitter.typehead.css" rel="stylesheet">


    <style>
        #tbl_items td,#tbl_items tr,#tbl_items th{
            table-layout: fixed;
            border: 1px solid gray;
            border-collapse: collapse;
        }


        .toolbar{
            float: left;
        }

        td.details-control {
            background: url('assets/img/print.png') no-repeat center center;
            cursor: pointer;
        }

        tr.details td.details-control {
            background: url('assets/img/print.png') no-repeat center center;
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

        .dropdown-menu > .active > a,.dropdown-menu > .active > a:hover{
            background-color: dodgerblue;
        }

        @keyframes spin {
            from { transform: scale(1) rotate(0deg); }
            to { transform: scale(1) rotate(360deg); }
        }

        @-webkit-keyframes spin2 {
            from { -webkit-transform: rotate(0deg); }
            to { -webkit-transform: rotate(360deg); }
        }

        .custom_frame{

            border: 1px solid lightgray;
            margin: 1% 1% 1% 1%;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            border-radius: 5px;
        }

        .numeric{
            text-align: right;
        }



        @media screen and (max-width: 480px) {

            table{
                min-width: 800px;
            }

            .dataTables_filter{
                min-width: 800px;
            }

            .dataTables_info{
                min-width: 800px;
            }

            .dataTables_paginate{
                float: left;
                width: 100%;
            }
        }

        .boldlabel {
            font-weight: bold;
        }

        .modal-body {
            /*padding-left:0px !important;*/
        }

        .form-group {
            padding:0;
            margin:5px;
        }

        .input-group {
            padding:0;
            margin:0;
        }

        textarea {
            resize: none;
        }

        .modal-body p {
            margin-left: 20px !important;
        }

    </style>
</head>

<body class="animated-content"  style="font-family: tahoma;">

<?php echo $_top_navigation; ?>

<div id="wrapper">
<div id="layout-static">


<?php echo $_side_bar_navigation;

?>


<div class="static-content-wrapper white-bg">


<div class="static-content">
<div class="page-content"><!-- #page-content -->

<ol class="breadcrumb"  style="margin-bottom: 10px;">
    <li><a href="Dashboard">Dashboard</a> </li>
    <li><a href="Purchases">Purchase Order</a></li>
</ol>


<div class="container-fluid">
<div data-widget-group="group1">
<div class="row">
<div class="col-md-12">
<div id="div_user_list">
    <div class="panel panel-default">
<!-- 
        <a data-toggle="collapse" data-parent="#accordionA" href="#collapseTwo"><div class="panel-heading" style="background: #2ecc71;border-bottom: 1px solid lightgrey;"><b style="color: white; font-size: 12pt;"><i class="fa fa-bars"></i> Purchase Order</b></div></a> -->


        <div class="panel-body table-responsive">
        <h2 class="h2-panel-heading">Purchase Order</h2><hr>
            <table id="tbl_purchases" class="table table-striped" cellspacing="0" width="100%">
                <thead class="">
                <tr>
                    <th></th>
                    <th style="text-align: center;">Email</th>
                    <th>PO#</th>
                    <th>Vendor</th>
                    <th>Terms</th>
                    <th>Approved</th>
                    <th>Status</th>
                    <th>Sent</th>
                    <th><center>Action</center></th>
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

<div id="div_user_fields" style="display: none;">
    <div class="panel panel-default" >

    <div class="panel-body" >

        <div class="row" style="padding: 1%;margin-top: 0%;font-family: "Source Sans Pro", "Segoe UI", "Droid Sans", Tahoma, Arial, sans-serif">
        <form id="frm_purchases" role="form" class="form-horizontal">
            <h2 class="h2-panel-heading">PO # : <span id="span_po_no">PO-XXXX</span></h2><hr>
            <div >
                <div class="row">
                    <div class="col-sm-5" >
                        Department * : <br />
                        <select name="department" id="cbo_departments"  data-error-msg="Department is required." required>
                            <option value="0">[ Create New Department ]</option>
                            <?php foreach($departments as $department){ ?>
                                <option value="<?php echo $department->department_id; ?>" data-default-cost="<?php echo $department->default_cost; ?>" data-delivery-address="<?php echo $department->delivery_address;  ?>"><?php echo $department->department_name; ?></option>
                            <?php } ?>
                        </select>
                    </div>


                    <div class="col-sm-3 col-sm-offset-3">
                        PO # : <br />
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-code"></i>
                            </span>
                            <input type="text" name="po_no" class="form-control" placeholder="PO-YYYYMMDD-XXX" readonly>
                        </div>
                    </div>


                </div>

                <div class="row">
                    <div class="col-sm-5">
                        Supplier * : <br />
                        <select name="supplier" id="cbo_suppliers" data-error-msg="Supplier is required." required>
                            <option value="0">[ Create New Supplier ]</option>
                            <?php foreach($suppliers as $supplier){ ?>
                                <option value="<?php echo $supplier->supplier_id; ?>" data-tax-type="<?php echo $supplier->tax_type_id; ?>" data-contact-person="<?php echo $supplier->contact_name; ?>"><?php echo $supplier->supplier_name; ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="col-sm-4 col-sm-offset-3">

                        Contact Person : <br />
                        <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="fa fa-users"></i>
                                                                </span>
                            <input type="text" name="contact_person" class="form-control" placeholder="Contact Person">
                        </div>

                        <div style="display: none;">
                            Tax type : <br />
                            <select name="tax_type" id="cbo_tax_type">
                                <?php foreach($tax_types as $tax_type){ ?>
                                    <option value="<?php echo $tax_type->tax_type_id; ?>" data-tax-rate="<?php echo $tax_type->tax_rate; ?>"><?php echo $tax_type->tax_type; ?></option>
                                <?php } ?>
                            </select></div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5">
                        Deliver to Address * : <br />
                        <textarea name="deliver_to_address" class="form-control" placeholder="Deliver to Address" data-error-msg="Deliver address is required!" required></textarea>

                    </div>

                    <div class="col-sm-4 col-sm-offset-3">
                        Terms : <br />
                        <input type="text" name="terms" class="form-control">
                    </div>
                </div>


            </div>

        </form>

    </div>



    <div><br />
    <hr>
        <label class="control-label" style="font-family: Tahoma;"><strong>Enter PLU or Search Item :</strong></label>
        <button id="refreshproducts" class="btn-primary btn pull-right" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;"><span class=""></span>  Refresh</button>
        <div id="custom-templates">
            <input class="typeahead" id="typeaheadsearch" type="text" placeholder="Enter PLU or Search Item">
        </div><br />

        <form id="frm_items">
            <div class="table-responsive">
                <table id="tbl_items" class="table table-striped" cellspacing="0" width="100%" style="font-font:tahoma;">
                    <thead class="">
                    <tr>
                        <th width="5%">Qty</th>
                        <th width="10%">UM</th>
                        <th width="15%">Item</th>
                        <th width="10%" style="text-align: right;">Unit Price</th>
                        <th width="10%" style="text-align: right;">Discount(%)</th>

                        <th style="display: none;" width="5%">T.D</th> <!-- total discount -->
                        <th style="display: none;" width="5%">Tax %</th>

                        <th width="15%" style="text-align: right;">Total</th>
                        <th width="10%" style="display: none;">V.I</th> <!-- vat input -->

                        <th style="display: none;" width="10%">N.V</th> <!-- net of vat -->
                        <th style="display: none;" width="10%">Item ID</th><!-- product id -->
                        <th width="5%"><center>Action</center></th>
                        <th style="display: none;" width="10%">Bulk Price</th>
                        <th style="display: none;" width="10%">Retail Price</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>

                    <tfoot>
                    <tr>
                        <td colspan="7" style="height: 20px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="" style="text-align: right;"><strong><i class="glyph-icon icon-star"></i> Discount (%) :</strong></td>
                        <td align="right" colspan="1" id="" color="red">
                            <input id="txt_overall_discount" name="total_overall_discount" type="text" class="numeric form-control" value="0.00" />
                            <input id="txt_overall_discount_amount" name="total_overall_discount_amount" type="hidden" class="numeric form-control" value="0.00" />
                        </td>
                        <td style="text-align: right;"><strong style="display: none;"> <i class="glyph-icon icon-star"></i>Total After Discount :</strong></td>
                        <td id="td_total_after_discount" style="text-align: right;display: none;"><strong>0.00</strong></td><td style="border-right: 0px;"></td>
                        <td style="text-align: right; border-left: 0px!important;"><strong><i class="glyph-icon icon-star"></i> Total Before Tax :</strong></td>
                        <td align="right" colspan="2" id="td_before_tax" color="red">0.00</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align: right;"><strong><i class="glyph-icon icon-star"></i> Tax :</strong></td>
                        <td align="right" colspan="1" id="td_tax" color="red">0.00</td>
                        <td colspan="2" style="text-align: right;"><strong><i class="glyph-icon icon-star"></i> Total After Tax :</strong></td>
                        <td align="right" colspan="2" id="td_after_tax" color="red">0.00</td>
                    </tr>
                    </tfoot>


                </table>
            </div>
        </form>



    </div>

<hr>

    <br />
    <div class="row ">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <label control-label><strong>Remarks :</strong></label>
            <div class="col-lg-12" style="padding: 0%;">
                <textarea name="remarks" class="form-control" placeholder="Remarks"></textarea>
            </div>





            <div class="row" style="display: none;">
                <div class="col-lg-4 col-lg-offset-8">
                    <div class="table-responsive">
                        <table id="tbl_purchase_summary" class="table invoice-total" style="font-family: tahoma;">
                            <tbody>

                            <tr>
                                <td>Discount :</td>
                                <td align="right">0.00</td>
                            </tr>

                            <tr>
                                <td>Total before Tax :</td>
                                <td align="right">0.00</td>
                            </tr>
                            <tr>
                                <td>Tax :</td>
                                <td align="right">0.00</td>
                            </tr>
                            <tr>
                                <td><strong>Total After Tax :</strong></td>
                                <td align="right"><b>0.00</b></td>
                            </tr>


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


        </div>
    </div>

</div>



<br />
<div class="panel-footer">
    <div class="row">
        <div class="col-sm-12">
            <button id="btn_save" class="btn-primary btn" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;"><span class=""></span>  Save Changes</button>
            <button id="btn_cancel" class="btn-default btn" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;"">Cancel</button>
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
        <div class="modal-content"><!---content--->
            <div class="modal-header">
                <button type="button" class="close"   data-dismiss="modal" aria-hidden="true">X</button>
                <h4 class="modal-title" style="color:white;"><span id="modal_mode"> </span>Confirm Deletion</h4>

            </div>

            <div class="modal-body">
                <p id="modal-body-message">Are you sure ?</p>
            </div>

            <div class="modal-footer">
                <button id="btn_yes" type="button" class="btn btn-danger" data-dismiss="modal" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;">Yes</button>
                <button id="btn_close" type="button" class="btn btn-default" data-dismiss="modal" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;">No</button>
            </div>
        </div><!---content---->
    </div>
</div><!---modal-->

<div id="modal_new_department" class="modal fade" tabindex="-1" role="dialog"><!--modal-->
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close"   data-dismiss="modal" aria-hidden="true">X</button>
                <h4 class="modal-title" style="color: white;"><span id="modal_mode"> </span>New Department</h4>

            </div>


            <div class="modal-body">

                <form id="frm_department">
                    <div class="row">
                        <div class="col-md-12" style="margin-left: 10px;">

                            <div class="form-group">
                                <label>* Department :</label>
                                <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-users"></i>
                                        </span>
                                    <input type="text" name="department_name" class="form-control" placeholder="Department" data-error-msg="Department name is required." required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Department Description :</label>
                                <textarea name="department_desc" class="form-control" placeholder="Department Description"></textarea>
                            </div>

                        </div>
                    </div>
                </form>


            </div>

            <div class="modal-footer">
                <button id="btn_create_new_department" type="button" class="btn btn-primary"  style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;"><span class=""></span> Create</button>

                <button id="btn_close_new_department" type="button" class="btn btn-default" data-dismiss="modal" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;">Cancel</button>

            </div>
        </div><!---content---->
    </div>
</div><!---modal-->

<div id="modal_new_supplier" class="modal fade" tabindex="-1" role="dialog"><!--modal-->
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#2ecc71;">
                <button type="button" class="close"   data-dismiss="modal" aria-hidden="true">X</button>
                <h4 class="modal-title" style="color:#ecf0f1 !important;"><span id="modal_mode"> </span>New Supplier</h4>

            </div>

            <div class="modal-body" style="overflow:hidden;">
                <form id="frm_suppliers_new">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="col-md-12">
                                <div class="col-md-4" id="label">
                                    <label class="control-label boldlabel" style="text-align:right;"><font color="red"><b>*</b></font> Company Name :</label>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-users"></i>
                                        </span>
                                        <input type="text" name="supplier_name" class="form-control" placeholder="Supplier Name" data-error-msg="Supplier Name is required!" required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="col-md-4" id="label">
                                    <label class="control-label boldlabel" style="text-align:right;"><font color="red"><b>*</b></font> Contact Person :</label>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-users"></i>
                                        </span>
                                        <input type="text" name="contact_name" class="form-control" placeholder="Contact Person" data-error-msg="Contact Person is required!" required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="col-md-4" id="label">
                                    <label class="control-label boldlabel" style="text-align:right;"><font color="red"><b>*</b></font> Address :</label>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-home"></i>
                                         </span>
                                        <textarea name="address" class="form-control" data-error-msg="Supplier address is required!" placeholder="Address" required ></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="col-md-4" id="label">
                                    <label class="control-label boldlabel" style="text-align:right;">Email Address :</label>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-envelope-o"></i>
                                        </span>
                                        <input type="text" name="email_address" class="form-control" placeholder="Email Address">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="col-md-4" id="label">
                                    <label class="control-label boldlabel" style="text-align:right;">Landline :</label>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-phone"></i>
                                        </span>
                                        <input type="text" name="landline" id="landline" class="form-control" placeholder="Landline">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="col-md-4" id="label">
                                    <label class="control-label boldlabel" style="text-align:right;">Contact No :</label>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-mobile"></i>
                                        </span>
                                        <input type="text" name="contact_no" id="mobile_no" class="form-control" placeholder="Contact No">
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="col-md-4" id="label">
                                    <label class="control-label boldlabel" style="text-align:right;">TIN # :</label>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-code"></i>
                                        </span>
                                        <input type="text" name="tin_no" class="form-control" placeholder="TIN #">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-4" id="label">
                                     <label class="control-label boldlabel" style="text-align:right;">Tax Output % :</label>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-code"></i>
                                        </span>
                                        <input type="text" name="tax_output" class="form-control" placeholder="Input Percentage Number Only"> 
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-4" id="label">
                                    <label class="control-label boldlabel" style="text-align:right;"><font color="red"><b>*</b></font> Tax :</label>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-code"></i>
                                        </span>
                                        <select name="tax_type_id" id="cbo_tax_group">
                                            <option value="">Please select tax type...</option>
                                            <?php foreach($tax_types as $tax_type){ ?>
                                                <option value="<?php echo $tax_type->tax_type_id; ?>" data-tax-rate="<?php echo $tax_type->tax_rate; ?>"><?php echo $tax_type->tax_type; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="col-md-12">
                                <div class="col-md-12">
                                    <label class="control-label boldlabel" style="text-align:left;padding-top:10px;"><i class="fa fa-user" aria-hidden="true" style="padding-right:10px;"></i>Supplier's Photo</label>
                                    <hr style="margin-top:0px !important;height:1px;background-color:black;">
                                </div>
                                <div style="width:100%;height:350px;border:2px solid #34495e;border-radius:5px;">
                                    <center>
                                        <img name="img_user" id="img_user" src="assets/img/anonymous-icon.png" height="140px;" width="140px;"></img>
                                    </center>
                                    <hr style="margin-top:0px !important;height:1px;background-color:black;">
                                    <center>
                                        <button type="button" id="btn_browse" style="width:150px;margin-bottom:5px;" class="btn btn-primary">Browse Photo</button>
                                        <button type="button" id="btn_remove_photo" style="width:150px;" class="btn btn-danger">Remove</button>
                                        <input type="file" name="file_upload[]" class="hidden">
                                    </center>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>


            </div>

            <div class="modal-footer">
                <button id="btn_create_new_supplier" type="button" class="btn btn-primary"  style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;"><span class=""></span> Create</button>
                <button id="btn_close_new_supplier" type="button" class="btn btn-default" data-dismiss="modal" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;">Cancel</button>
            </div>
        </div><!---content---->
    </div>
</div><!---modal-->


<div id="modal_purchase_order" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header " style="padding: 5px !important;">
                <h2 style="color:white; padding-left: 10px;">Purchase Order</h2>
            </div>
            <div class="modal-body">
                <div class="container-fluid" style="overflow: scroll; width: 100%;">
                    <div id="purchase_order">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<footer role="contentinfo">
    <div class="clearfix">
        <ul class="list-unstyled list-inline pull-left">
            <li><h6 style="margin: 0;">&copy; 2017 - JDEV IT BUSINESS SOLUTION</h6></li>
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




<!-- Date range use moment.js same as full calendar plugin -->
<script src="assets/plugins/fullcalendar/moment.min.js"></script>
<!-- Data picker -->
<script src="assets/plugins/datapicker/bootstrap-datepicker.js"></script>



<!-- twitter typehead -->
<script src="assets/plugins/twittertypehead/handlebars.js"></script>
<script src="assets/plugins/twittertypehead/bloodhound.min.js"></script>
<script src="assets/plugins/twittertypehead/typeahead.bundle.min.js"></script>
<script src="assets/plugins/twittertypehead/typeahead.jquery.min.js"></script>

<!-- touchspin -->
<script type="text/javascript" src="assets/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.js"></script>


<!-- Select2 -->
<script src="assets/plugins/select2/select2.full.min.js"></script>

<!-- numeric formatter -->
<script src="assets/plugins/formatter/autoNumeric.js" type="text/javascript"></script>
<script src="assets/plugins/formatter/accounting.js" type="text/javascript"></script>

<script>




$(document).ready(function(){
    var dt; var _txnMode; var _selectedID; var _selectRowObj; var _cboSuppliers; var _cboTaxType;
    var _cboDepartments; var _defCostType; var products; var _line_unit; var changetxn;


    //_defCostType=1; //Luzon Area Purchase Cost is default, this will change when branch is specified

    var oTableItems={
        qty : 'td:eq(0)',
        unit_value: 'td:eq(1)',
        unit_identifier : 'td:eq(2)',
        unit_price : 'td:eq(3)',
        discount : 'td:eq(4)',
        total_line_discount : 'td:eq(5)',
        tax : 'td:eq(6)',
        total : 'td:eq(7)',
        vat_input : 'td:eq(8)',
        net_vat : 'td:eq(9)',
        item_id : 'td:eq(10)',
        bulk_price : 'td:eq(12)',
        retail_price : 'td:eq(13)',
        total_after_global : 'td:eq(14)'


    };


    var oTableDetails={
        discount : 'tr:eq(0) > td:eq(1)',
        before_tax : 'tr:eq(1) > td:eq(1)',
        tax_amount : 'tr:eq(2) > td:eq(1)',
        after_tax : 'tr:eq(3) > td:eq(1)'
    };


    var initializeControls=function(){

        dt=$('#tbl_purchases').DataTable({
            "dom": '<"toolbar">frtip',
            "bLengthChange":false,
            "order": [[ 9, "desc" ]],
            "ajax" : "Purchases/transaction/list",
            "columns": [
                {
                    "targets": [0],
                    "class":          "details-control",
                    "orderable":      false,
                    "data":           null,
                    "defaultContent": ""
                },
                
                { visible:false,
                    targets:[1], data:null,
                    render: function (data, type, full, meta){
                        var btn_email='<button id="btn_email" class="btn-primary btn btn-sm " style="margin-left:-15px;" data-toggle="tooltip" data-placement="top"><i class="fa fa-share"></i> <span class="display" style="display:none;"></span></button> ';
                        var btn_disabled='<button id="btn_email" class="btn-primary btn btn-sm disabled" style="margin-left:-15px;" data-toggle="tooltip" data-placement="top"><i class="fa fa-share"></i> <span class="display" style="display:none;"></span></button> ';
                        if(data.approval_id =="1"){
                            return '<center>'+btn_email+'</center>';
                        }else{
                            return '<center>'+btn_disabled+'</center>';
                            
                        } 
                    }
                },
                { targets:[2],data: "po_no" },
                { targets:[3],data: "supplier_name" },
                { targets:[4],data: "term_description" },
                { targets:[5],data: "approval_status" },
                { targets:[6],data: "order_status" },
                {
                    targets:[7],data: null,
                    render: function (data, type, full, meta){
                        var _attribute='';
                        //console.log(data.is_email_sent);
                        if(data.is_email_sent=="1"){
                            _attribute=' class="fa fa-check-circle" style="color:green;" ';
                        }else{
                            _attribute=' class="fa fa-times-circle" style="color:red;" ';
                        }

                        return '<center><i '+_attribute+'></i></center>';
                    }

                },
                {
                    targets:[8],
                    render: function (data, type, full, meta){
                        var btn_edit='<button class="btn btn-primary btn-sm" name="edit_info"  style="margin-left:-15px;" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil"></i> </button>';
                        var btn_trash='<button class="btn btn-red btn-sm" name="remove_info" style="margin-right:0px;" data-toggle="tooltip" data-placement="top" title="Move to trash"><i class="fa fa-trash-o"></i> </button>';
                        var btn_message='<a href="Po_messages?id='+full.purchase_order_id+'" target="_blank" class="btn btn-green btn-sm" name="message_po" style="margin-right:0px;" data-toggle="tooltip" data-placement="top" title="Message"><i class="fa fa-envelope-o"></i> </a>';
                 

                        return '<center>'+btn_edit+'&nbsp;'+btn_message+'&nbsp;'+btn_trash+'</center>';
                    }
                },
                { targets:[9],data: "purchase_order_id",visible:false }
            ]
        });

        var createToolBarButton=function(){
            var _btnNew='<button class="btn btn-primary"  id="btn_new" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;" data-toggle="modal" data-target="" data-placement="left" title="New Purcahase Order" >'+
                '<i class="fa fa-plus"></i> New Purchase Order</button>';
            $("div.toolbar").html(_btnNew);
        }();

        $('.numeric').autoNumeric('init');

        $('#mobile_no').keypress(validateNumber);

        $('#landline').keypress(validateNumber);

        _cboSuppliers=$('#cbo_suppliers').select2({
            placeholder: "Please select supplier first to filter product lookup.",
            allowClear: true
        });

        _cboSuppliers.select2('val',null);


        /*_productType = $('#cbo_prodType').select2({
         placeholder: "Please select Product Type",
         allowClear: false
         });*/

        _cboDepartments=$("#cbo_departments").select2({
            placeholder: "Please select department.",
            allowClear: true
        });

        _cboDepartments.select2('val',null);



        _cboTaxType=$('#cbo_tax_type').select2({
            placeholder: "Please select tax type.",
            alloowClear: true

        });




        var _cboTaxGroup=$('#cbo_tax_group').select2({
            placeholder: "Please select tax type.",
            allopwClear: true,
            dropdownParent: "#modal_new_supplier"
        });

        _cboTaxGroup.select2('val',null);


        $('#custom-templates .typeahead').keypress(function(event){
            if (event.keyCode == 13) {
                $('.tt-suggestion:first').click();
            }
        });


        products = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('product_code','product_desc','product_desc1'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            local : products
        });

        /*var products = new Bloodhound({
         datumTokenizer: Bloodhound.tokenizers.obj.whitespace(''),
         queryTokenizer: Bloodhound.tokenizers.whitespace,
         remote: {
         cache: false,
         url: 'Purchases/transaction/product-lookup/',

         replace: function(url, uriEncodedQuery) {
         //var prod_type=$('#cbo_prodType').select2('val');
         //var prod_type=$('#cbo_prodType').select2('val');
         //var sid=$('#cbo_suppliers').select2('val');
         //var prod_type=$('#cbo_prodType').select2('val');

         return url + '?description='+uriEncodedQuery;
         }
         }
         });*/



        var _objTypeHead=$('#custom-templates .typeahead');

        _objTypeHead.typeahead(null, {
            name: 'products',
            display: 'product_code',
            source: products,
            templates: {
                header: [
                    '<table class="tt-head"><tr><td width=20%" style="padding-left: 1%;"><b>PLU</b></td><td width="20%" align="left"><b>Description 1</b></td><td width="20%" align="left"><b>Description 2</b></td><td width="10%" align="right" style="padding-right: 2%;"><b>On hand</b><td width="10%" align="right" style="padding-right: 2%;"><b>Cost</b></td></tr></table>'
                ].join('\n'),

                suggestion: Handlebars.compile('<table class="tt-items"><tr><td width="20%" style="padding-left: 1%">{{product_code}}</td><td width="20%" align="left">{{product_desc}}</td><td width="20%" align="left">{{produdct_desc1}}</td><td width="10%" align="right" style="padding-right: 2%;">{{CurrentQty}}</td><td width="10%" align="right" style="padding-right: 2%;">{{purchase_cost}}</td></tr></table>')

            }
        }).on('keyup', this, function (event) {
            if (_objTypeHead.typeahead('val') == '')
                return false;
            if (event.keyCode == 13) {
                //$('.tt-suggestion:first').click();
                _objTypeHead.typeahead('close');
                _objTypeHead.typeahead('val','');
            }
        }).bind('typeahead:select', function(ev, suggestion) {
            //if(_objTypeHead.typeahead('val')==''){ return false; }
            //console.log(suggestion);

            //var tax_id=$('#cbo_tax_type').select2('val');
            //var tax_rate=parseFloat($('#cbo_tax_type').find('option[value="'+tax_id+'"]').data('tax-rate'));
            //alert(suggestion.tax_rate);
            if(!(checkProduct(suggestion.product_id))){ // Checks if item is already existing in the Table of Items for invoice
                showNotification({title: suggestion.product_desc,stat:"error",msg: "Item is Already Added."});
                return;
            }

            var tax_rate=suggestion.tax_rate; //base on the tax rate set to current product

            //choose what purchase cost to be use
            var purchase_cost=0.00;
            purchase_cost=suggestion.purchase_cost;

            var total=getFloat(purchase_cost);
            var net_vat=0;
            var vat_input=0;
            var bulk_price = 0;
            var retail_price = 0;
            var a = ''; // SET a for select class , SETTING a VALUE for a class must have a unit class identifier EX. class="class_1" , class="class_2" 
            if(suggestion.is_tax_exempt=="0"){ //this is not excempted to tax
                net_vat=total/(1+(getFloat(tax_rate)/100));
                vat_input=total-net_vat;
            }else{
                tax_rate=0;
                net_vat=total;
                vat_input=0;

                //if(tax_id!="1"){ //if supplier is taxable, notify the user that this item is tax excempt
                //showNotification({title:"Tax Excempt!",stat:"info",msg:"This item is tax excempt."});
                //}

            }
            bulk_price = suggestion.purchase_cost;

            if(suggestion.is_bulk == 1){
                retail_price = getFloat(suggestion.purchase_cost) / getFloat(suggestion.child_unit_desc);

            }else if (suggestion.is_bulk== 0){
                retail_price = 0;
            }
            if(suggestion.primary_unit == 1){ 
                suggis_parent = 1;
                temp_inv_price = purchase_cost;
            }else{ 
                suggis_parent = 0;
                temp_inv_price = retail_price;
                net_vat = getFloat(net_vat) / getFloat(suggestion.child_unit_desc);
                vat_input = getFloat(vat_input) / getFloat(suggestion.child_unit_desc);
            }
            $('#tbl_items > tbody').append(newRowItem({
                po_qty : "1",
                bulk_price: bulk_price,
                retail_price: retail_price,
                product_code : suggestion.product_code,
                is_bulk: suggestion.is_bulk,
                parent_unit_id : suggestion.parent_unit_id,
                child_unit_id : suggestion.child_unit_id,
                child_unit_name : suggestion.child_unit_name,
                parent_unit_name : suggestion.parent_unit_name,
                product_id: suggestion.product_id,
                product_desc : suggestion.product_desc,
                po_line_total_discount : "0.00",
                tax_exempt : false,
                po_tax_rate : tax_rate,
                po_price : temp_inv_price,
                po_discount : "0.00",
                tax_type_id : null,
                po_line_total : temp_inv_price,
                po_line_total_after_global : temp_inv_price,
                po_non_tax_amount: net_vat,
                po_tax_amount:vat_input,
                is_parent: suggis_parent ,
                primary_unit:suggestion.primary_unit,
                a:a
            }));

        _line_unit=$('.line_unit'+a).select2({
             minimumResultsForSearch: -1
        });
        changetxn = 'active';
            reInitializeNumeric();
            reComputeTotal();


        });

        $('div.tt-menu').on('click','table.tt-suggestion',function(){
            _objTypeHead.typeahead('val','');
        });

        $("input#touchspin4").TouchSpin({
            verticalbuttons: true,
            verticalupclass: 'fa fa-fw fa-plus',
            verticaldownclass: 'fa fa-fw fa-minus'
        });


    }();






    var bindEventHandlers=(function(){
        var detailRows = [];

        $('#tbl_purchases tbody').on( 'click', 'tr td.details-control', function () {
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
                    "url":"Templates/layout/po/"+ d.purchase_order_id,
                    // "beforeSend" : function(){
                    //     row.child( '<center><br /><img src="assets/img/loader/ajax-loader-lg.gif" /><br /><br /></center>' ).show();
                    // }
                }).done(function(response){
                    // row.child( response ).show();
                    // // Add to the 'open' array
                    // if ( idx === -1 ) {
                    //     detailRows.push( tr.attr('id') );
                    // }
                    $("#purchase_order").html(response);
                    $("#modal_purchase_order").modal('show');
                });
            }
        } );





        // $('#tbl_purchases tbody').on('click','#btn_email',function(){
        //     _selectRowObj=$(this).parents('tr').prev();
        //     var d=dt.row(_selectRowObj).data();
        //     var btn=$(this);

        //     $.ajax({
        //         "dataType":"json",
        //         "type":"POST",
        //         "url":"Email/send/po/"+ d.purchase_order_id,
        //         "data": {email:$(this).data('supplier-email')},
        //         "beforeSend" : function(){
        //             showSpinningProgress(btn);
        //         }
        //     }).done(function(response){
        //         showNotification(response);
        //         dt.row(_selectRowObj).data(response.row_updated[0]).draw();
        //     }).always(function(){
        //         showSpinningProgress(btn);
        //     });
        // });

        $('#tbl_purchases tbody').on('click','#btn_email',function(){
            showNotification({title:"Sending!",stat:"info",msg:"Please wait for a few seconds."});
            _selectRowObj=$(this).closest('tr');
            var data=dt.row(_selectRowObj).data();
            _selectedID=data.purchase_order_id;
            var btn=$(this);
        
            $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"Purchases/transaction/email/"+_selectedID,
                "beforeSend": showSpinningProgress(btn)
            }).done(function(response){
                showNotification(response);
                dt.row(_selectRowObj).data(response.row_updated[0]).draw(false);
 
    
            });
        });

        $('#btn_new').click(function(){
            _txnMode="new";
            $('#span_po_no').html("PO-XXXX");

            //$('.toggle-fullscreen').click();
            clearFields($('#frm_purchases'));
            $('#cbo_tax_type').select2('val',null);
            $('#cbo_suppliers').select2('val',null);
            $('#cbo_departments').select2('val',null);
            $('textarea[name="remarks"]').val('');
            //$('#cbo_prodType').select2('val',3);
            $('#typeaheadsearch').val('');
            getproduct().done(function(data){
                products.clear();
                products.local = data.data;
                products.initialize(true);
                countproducts = data.data.length;
                    if(countproducts > 100){
                    showNotification({title:"Success !",stat:"success",msg:"Products List successfully updated."});
                    }
            }).always(function(){  });
            showList(false);
        });
         $('#refreshproducts').click(function(){
            getproduct().done(function(data){
                products.clear();
                products.local = data.data;
                products.initialize(true);
                    showNotification({title:"Success !",stat:"success",msg:"Products List successfully updated."});
            }).always(function(){
                });
         });
        $('#btn_create_new_department').click(function(){

            var btn=$(this);

            if(validateRequiredFields($('#frm_department'))){
                var data=$('#frm_department').serializeArray();
                /*_data.push({name : "photo_path" ,value : $('img[name="img_user"]').attr('src')});*/
                createDepartment().done(function(response){
                    showNotification(response);
                    $('#modal_new_department').modal('hide');

                    var _department=response.row_added[0];
                    $('#cbo_departments').append('<option value="'+_department.department_id+'" data-tax-type="'+_department.department_id+'" selected>'+_department.department_name+'</option>');
                    $('#cbo_departments').select2('val',_department.department_id);
                    $('#cbo_tax_type').select2('val',_department.tax_type_id);
                    clearFields($('#modal_new_department'));

                }).always(function(){
                    showSpinningProgress(btn);
                });
            }
        });

        $('#btn_create_new_supplier').click(function(){

            var btn=$(this);

            if(validateRequiredFields($('#frm_suppliers_new'))){
                var data=$('#frm_suppliers_new').serializeArray();
                /*_data.push({name : "photo_path" ,value : $('img[name="img_user"]').attr('src')});*/
                createSupplier().done(function(response){
                    showNotification(response);
                    $('#modal_new_supplier').modal('hide');

                    var _suppliers=response.row_added[0];
                    $('#cbo_suppliers').append('<option value="'+_suppliers.supplier_id+'" data-tax-type="'+_suppliers.tax_type_id+'" selected>'+_suppliers.supplier_name+'</option>');
                    $('#cbo_suppliers').select2('val',_suppliers.supplier_id);
                    $('#cbo_tax_type').select2('val',_suppliers.tax_type_id);

                }).always(function(){
                    showSpinningProgress(btn);
                });
            }

        });



        $('#tbl_purchases tbody').on('click','button[name="edit_info"]',function(){
            ///alert("ddd");
            _txnMode="edit";
            _selectRowObj=$(this).closest('tr');
            var data=dt.row(_selectRowObj).data();
            _selectedID=data.purchase_order_id;

            $('#span_po_no').html(data.po_no);

            if(getFloat(data.order_status_id)>1){
                showNotification({"title":"Error!","stat":"error","msg":"Sorry, you cannot edit purchase order that is already been received."});
                return;
            }
                getproduct().done(function(data){
                    products.clear();
                    products.local = data.data;
                    products.initialize(true);
                    countproducts = data.data.length;
                        if(countproducts > 100){
                        showNotification({title:"Success !",stat:"success",msg:"Products List successfully updated."});
                        }

                }).always(function(){ });
                $('#typeaheadsearch').val('');

            $('input,textarea').each(function(){
                var _elem=$(this);
                $.each(data,function(name,value){
                    if(_elem.attr('name')==name&&_elem.attr('type')!='password'){
                        _elem.val(value);
                    }
                });
            });

            $('#txt_overall_discount').val(accounting.formatNumber($('#txt_overall_discount').val(),2));

            $('#cbo_suppliers').select2('val',data.supplier_id);
            $('#cbo_departments').select2('val',data.department_id);

            //var tbl_summary=$('#tbl_purchase_summary');
            //tbl_summary.find(oTableDetails.discount).html(accounting.formatNumber(data.total_discount,2));
            //tbl_summary.find(oTableDetails.before_tax).html(accounting.formatNumber(data.total_before_tax,2));
            //tbl_summary.find(oTableDetails.tax_amount).html(accounting.formatNumber(data.total_tax_amount,2));
            //tbl_summary.find(oTableDetails.after_tax).html('<b>'+accounting.formatNumber(data.total_after_tax,2)+'</b>');


            $.ajax({
                url : 'Purchases/transaction/items/'+data.purchase_order_id,
                type : "GET",
                cache : false,
                dataType : 'json',
                processData : false,
                contentType : false,
                beforeSend : function(){
                    $('#tbl_items > tbody').html('<tr><td align="center" colspan="8"><br /><img src="assets/img/loader/ajax-loader-sm.gif" /><br /><br /></td></tr>');
                },
                success : function(response) {
                    var rows=response.data;
                    $('#tbl_items > tbody').html('');
                        a=0;
                    $.each(rows,function(i,value){
                        var retail_price;

                            if(value.is_bulk == 1){
                                retail_price = getFloat(value.purchase_cost) / getFloat(value.child_unit_desc);

                            }else if (value.is_bulk == 0){
                                retail_price = 0;
                            }

                        $('#tbl_items > tbody').append(newRowItem({
                            po_qty : value.po_qty,
                            product_code : value.product_code,
                            child_unit_id : value.child_unit_id,
                            child_unit_name : value.child_unit_name,
                            parent_unit_name : value.parent_unit_name,
                            parent_unit_id : getFloat(value.parent_unit_id),
                            product_id: value.product_id,
                            product_desc : value.product_desc,
                            po_line_total_discount : value.po_line_total_discount,
                            tax_exempt : false,
                            po_tax_rate : value.po_tax_rate,
                            po_price : value.po_price,
                            po_discount : value.po_discount,
                            tax_type_id : null,
                            po_line_total : value.po_line_total,
                            po_line_total_after_global : value.po_line_total_after_global,
                            po_non_tax_amount: value.non_tax_amount,
                            po_tax_amount:value.tax_amount,
                            is_bulk: value.is_bulk,
                            is_parent : value.is_parent,
                            bulk_price: value.purchase_cost,
                            retail_price: retail_price,
                            a:a

                        }));
                        changetxn = 'inactive';
                        // SET THE VALUE FOR UNIT (SELECT 2)
                        _line_unit=$('.line_unit'+a).select2({
                            minimumResultsForSearch: -1
                        });
                        _line_unit.select2('val',value.unit_id);
                        a++;
                    });
                    reInitializeNumeric();
                    reComputeTotal();
                    changetxn = 'active';
                }
            });




            showList(false);

        });

        $('#tbl_purchases tbody').on('click','button[name="remove_info"]',function(){
            _selectRowObj=$(this).closest('tr');
            var data=dt.row(_selectRowObj).data();
            _selectedID=data.purchase_order_id;

            $('#modal_confirmation').modal('show');
        });

        $('#tbl_items tbody').on('change','select',function(){
            if(changetxn == 'active'){
                var row=$(this).closest('tr');
                var unit_value=row.find(oTableItems.unit_value).find('option:selected').attr("data-unit-identifier"); 
                if(getFloat(unit_value) == 1 ){
                    var price=parseFloat(accounting.unformat(row.find(oTableItems.bulk_price).find('input.numeric').val()));
                }else{
                    var price=parseFloat(accounting.unformat(row.find(oTableItems.retail_price).find('input.numeric').val()));
                }
                $(oTableItems.unit_price,row).find('input').val(accounting.formatNumber(price,2));  
                $(oTableItems.unit_identifier,row).find('input').val(accounting.formatNumber(unit_value,2)); 
                $('.number-keyup').keyup();
            } 

        
        });


        //track every changes on numeric fields
        $('#tbl_items tbody').on('keyup ','input.numeric',function(){
            var row=$(this).closest('tr');
            var price=parseFloat(accounting.unformat(row.find(oTableItems.unit_price).find('input.numeric').val()));
            var discount=parseFloat(accounting.unformat(row.find(oTableItems.discount).find('input.numeric').val()));
            var qty=parseFloat(accounting.unformat(row.find(oTableItems.qty).find('input.numeric').val()));
            var tax_rate=parseFloat(accounting.unformat(row.find(oTableItems.tax).find('input.numeric').val()))/100;

            // if(discount>price){
            //     showNotification({title:"Invalid",stat:"error",msg:"Discount must not greater than unit price."});
            //     row.find(oTableItems.discount).find('input.numeric').val('0.00');
            // }
            var global_discount = $('#txt_overall_discount').val();
            var discounted_price=price-discount;
            var line_total_discount=discount*qty;
            var line_total=price*qty;
            var new_discount_price=line_total*(discount/100);
            var new_line_total=line_total-new_discount_price;
            var total_after_global = new_line_total-(new_line_total*(global_discount/100));
            var net_vat=total_after_global/(1+tax_rate);
            var vat_input=total_after_global-net_vat;

            $(oTableItems.total,row).find('input.numeric').val(accounting.formatNumber(new_line_total,2)); // line total amount
            $(oTableItems.total_after_global,row).find('input.numeric').val(accounting.formatNumber(total_after_global,2)); // line total amount
            $(oTableItems.total_line_discount,row).find('input.numeric').val(accounting.formatNumber(new_discount_price,2)); //line total discount
            $(oTableItems.net_vat,row).find('input.numeric').val(accounting.formatNumber(net_vat,2)); //net of vat
            $(oTableItems.vat_input,row).find('input.numeric').val(accounting.formatNumber(vat_input,2)); //vat input

            //console.log(net_vat);
            reComputeTotal();


        });







        $('#btn_yes').click(function(){
            //var d=dt.row(_selectRowObj).data();
            //if(getFloat(d.order_status_id)>1){
            //showNotification({title:"Error!",stat:"error",msg:"Sorry, you cannot delete purchase order that is already been recorded on purchase invoice."});
            //}else{
            removePurchaseOrder().done(function(response){
                showNotification(response);
                if(response.stat=="success"){
                    dt.row(_selectRowObj).remove().draw();
                }

            });
            //}
        });



        $('#btn_cancel').click(function(){
            showList(true);
        });

        $('#btn_close_new_department').click(function() {
            $('#modal_new_department').modal('hide');
        });

        $('#btn_close_new_supplier').click(function() {
            $('#modal_new_supplier').modal('hide');
        });

        $('#btn_save').click(function(){

            if(validateRequiredFields($('#frm_purchases'))){
                if(_txnMode=="new"){
                    createPurchaseOrder().done(function(response){
                        showNotification(response);
                        dt.row.add(response.row_added[0]).draw();
                        clearFields($('#frm_purchases'));
                        showList(true);
                    }).always(function(){
                        showSpinningProgress($('#btn_save'));
                    });
                }else{
                    updatePurchaseOrder().done(function(response){
                        showNotification(response);
                        dt.row(_selectRowObj).data(response.row_updated[0]).draw(false);
                        clearFields($('#frm_purchases'));
                        showList(true);
                    }).always(function(){
                        showSpinningProgress($('#btn_save'));
                    });
                }

            }

        });



        $('#tbl_items > tbody').on('click','button[name="remove_item"]',function(){
            $(this).closest('tr').remove();
            reComputeTotal();
        });

        $('#btn_browse').click(function(event){
            event.preventDefault();
            $('input[name="file_upload[]"]').click();
        });

        $('#btn_remove_photo').click(function(event){
            event.preventDefault();
            $('img[name="img_user"]').attr('src','assets/img/anonymous-icon.png');
        });

        $('input[name="file_upload[]"]').change(function(event){
            var _files=event.target.files;
            /*$('#div_img_product').hide();
             $('#div_img_loader').show();*/
            var data=new FormData();
            $.each(_files,function(key,value){
                data.append(key,value);
            });
            console.log(_files);
            $.ajax({
                url : 'Suppliers/transaction/upload',
                type : "POST",
                data : data,
                cache : false,
                dataType : 'json',
                processData : false,
                contentType : false,
                success : function(response){
                    $('img[name="img_user"]').attr('src',response.path);
                }
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

    var getproduct=function(){
       return $.ajax({
           "dataType":"json",
           "type":"POST",
           "url":"products/transaction/list",
           "beforeSend": function(){
                countproducts = products.local.length;
                if(countproducts > 100){
                    showNotification({title:"Please Wait !",stat:"info",msg:"Refreshing your Products List."});
                }
           }
      });
    };


    var createDepartment=function(){
        var _data=$('#frm_department').serializeArray();

        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Departments/transaction/create",
            "data":_data,
            "beforeSend": showSpinningProgress($('#btn_create_new_department'))
        });
    };

    var createSupplier=function() {
        var _data=$('#frm_suppliers_new').serializeArray();
        _data.push({name : "photo_path" ,value : $('img[name="img_user"]').attr('src')});
        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Suppliers/transaction/create",
            "data":_data,
            "beforeSend": showSpinningProgress($('#btn_create_new_supplier'))
        });
    };

    var createPurchaseOrder=function(){
        var _data=$('#frm_purchases,#frm_items').serializeArray();

        var tbl_summary=$('#tbl_purchase_summary');
        _data.push({name : "total_after_discount", value: $('#td_total_after_discount').text() });
        _data.push({name : "summary_discount", value : tbl_summary.find(oTableDetails.discount).text()});
        _data.push({name : "summary_before_discount", value :tbl_summary.find(oTableDetails.before_tax).text()});
        _data.push({name : "summary_tax_amount", value : tbl_summary.find(oTableDetails.tax_amount).text()});
        _data.push({name : "summary_after_tax", value : tbl_summary.find(oTableDetails.after_tax).text()});
        _data.push({name : "remarks", value : $('textarea[name="remarks"]').val() });
        
        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Purchases/transaction/create",
            "data":_data,
            "beforeSend": showSpinningProgress($('#btn_save'))
        });
    };

    var updatePurchaseOrder=function(){
        var _data=$('#frm_purchases,#frm_items').serializeArray();

        var tbl_summary=$('#tbl_purchase_summary');
        _data.push({name : "total_after_discount", value: $('#td_total_after_discount').text() });
        _data.push({name : "summary_discount", value : tbl_summary.find(oTableDetails.discount).text()});
        _data.push({name : "summary_before_discount", value :tbl_summary.find(oTableDetails.before_tax).text()});
        _data.push({name : "summary_tax_amount", value : tbl_summary.find(oTableDetails.tax_amount).text()});
        _data.push({name : "summary_after_tax", value : tbl_summary.find(oTableDetails.after_tax).text()});
        _data.push({name : "purchase_order_id" ,value : _selectedID});
        _data.push({name : "remarks", value : $('textarea[name="remarks"]').val() });

        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Purchases/transaction/update",
            "data":_data,
            "beforeSend": showSpinningProgress($('#btn_save'))
        });
    };

    var removePurchaseOrder=function(){
        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Purchases/transaction/delete",
            "data":{purchase_order_id : _selectedID}
        });
    };


    var showList=function(b){
        if(b){
            $('#div_user_list').show();
            $('#div_user_fields').hide();
        }else{
            $('#div_user_list').hide();
            $('#div_user_fields').show();
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

    var showSpinningProgress=function(e){
        $(e).toggleClass('disabled');
        $(e).find('span').toggleClass('glyphicon glyphicon-refresh spinning');
    };



    var clearFields=function(f){
        $('input,textarea',f).val('');
        $(f).find('input:first').focus();
        $('#txt_overall_discount').val('0.00');

        $('#tbl_items > tbody').html('');

        $('#td_before_tax').html(accounting.formatNumber(0,2));
        $('#td_after_tax').html('<b>'+accounting.formatNumber(0,2)+'</b>');
        $('#td_discount').html(accounting.formatNumber(0,2));
        $('#td_tax').html(accounting.formatNumber(0,2));
        $('#td_total_after_discount').html(accounting.formatNumber(0,2));


    };


    function format ( d ) {

        //return


    };

    function validateNumber(event) {
        var key = window.event ? event.keyCode : event.which;

        if (event.keyCode === 8 || event.keyCode === 46
            || event.keyCode === 37 || event.keyCode === 39) {
            return true;
        }
        else if ( key < 48 || key > 57 ) {
            return false;
        }
        else return true;
    };

    var getFloat=function(f){
        return parseFloat(accounting.unformat(f));
    };

    var newRowItem=function(d){
        if(d.primary_unit == 1){ parent = ' selected'; child = ' '; }else{ parent = ' '; child = ' selected'; } // This does not cause conflict with value of select when editing 
        if(d.is_bulk == '1'){ 
            unit = '<td ><select class="line_unit'+d.a+'" name="unit_id[]"><option value="'+d.parent_unit_id+'" data-unit-identifier="1" '+parent+'>'+d.parent_unit_name+'</option><option value="'+d.child_unit_id+'" data-unit-identifier="0" '+child+'>'+d.child_unit_name+'</option></select></td>';
        }else{ 
            unit  = '<td ><select class="line_unit'+d.a+'" name="unit_id[]" ><option value="'+d.parent_unit_id+'" data-unit-identifier="1" '+parent+'>'+d.parent_unit_name+'</option></select></td>';
        }
        return '<tr>'+
        '<td ><input name="po_qty[]" type="text" class="numeric form-control number-keyup" value="'+ d.po_qty+'"></td>'+unit+'<td >'+d.product_desc+' <input type="text" style="display:none;" class="form-control" name="is_parent[]" value="'+d.is_parent+'"></td>'+

        '<td ><input name="po_price[]" type="text" class="numeric form-control" value="'+accounting.formatNumber(d.po_price,2)+'" style="text-align:right;"></td>'+
        '<td ><input name="po_discount[]" type="text" class="numeric form-control" value="'+ accounting.formatNumber(d.po_discount,2)+'" style="text-align:right;"></td>'+
        //display:none;
        '<td style="display: none;" ><input name="po_line_total_discount[]" type="text" class="numeric form-control" value="'+ accounting.formatNumber(d.po_line_total_discount,2)+'" readonly></td>'+
        '<td style="display: none;"><input name="po_tax_rate[]" type="text" class="numeric form-control" value="'+ accounting.formatNumber(d.po_tax_rate,2)+'"></td>'+
        '<td  align="right" style="display:none;"><input name="po_line_total[]" type="text" class="numeric form-control" value="'+ accounting.formatNumber(d.po_line_total,2)+'" readonly></td>'+
        '<td  style="display: none;"><input name="tax_amount[]" type="text" class="numeric form-control" value="'+ accounting.formatNumber(d.po_tax_amount,2)+'" readonly></td>'+
        '<td style="display: none;" ><input name="non_tax_amount[]" type="text" class="numeric form-control" value="'+ accounting.formatNumber(d.po_non_tax_amount,2)+'" readonly></td>'+
        '<td style="display: none;"  ><input name="product_id[]" type="text" class="form-control" value="'+ d.product_id+'" readonly></td>'+
        '<td align="center" style="display:none;"><button type="button" name="remove_item" class="btn btn-red"><i class="fa fa-trash"></i></button></td>'+
        '<td style="display: none;"><input  type="text" class="form-control numeric" value="'+ accounting.formatNumber(d.bulk_price,2)+'" readonly></td>'+
        '<td style="display: none;"><input type="text" class="form-control numeric" value="'+ accounting.formatNumber(d.retail_price,2)+'" readonly></td>'+
        '<td  align="right"><input name="po_line_total_after_global[]" type="text" class="numeric form-control" value="'+ accounting.formatNumber(d.po_line_total_after_global,2)+'" readonly></td>'+
        '<td align="center" ><button type="button" name="remove_item" class="btn btn-red"><i class="fa fa-trash"></i></button></td>'+ // ADDED ANOTHER ONE HERE BECAUSE WE CANNOT REARRANGE THE  TABLE DATA
        '</tr>';
    };

    $('#txt_overall_discount').on('keyup',function(){
        $('.number-keyup').keyup();
        reComputeTotal();
    });

    var reComputeTotal=function(){
        var rows=$('#tbl_items > tbody tr');

        var discounts=0; var before_tax=0; var after_tax=0; var tax_amount=0; var after_discount=0; var gross=0;

        $.each(rows,function(){
            discounts+=parseFloat(accounting.unformat($(oTableItems.total_line_discount,$(this)).find('input.numeric').val()));
            gross +=parseFloat(accounting.unformat($(oTableItems.unit_price,$(this)).find('input.numeric').val()) *accounting.unformat($(oTableItems.qty,$(this)).find('input.numeric').val()))
            before_tax+=parseFloat(accounting.unformat($(oTableItems.net_vat,$(this)).find('input.numeric').val()));
            tax_amount+=parseFloat(accounting.unformat($(oTableItems.vat_input,$(this)).find('input.numeric').val()));
            after_tax+=parseFloat(accounting.unformat($(oTableItems.total_after_global,$(this)).find('input.numeric').val()));
        });

        var tbl_summary=$('#tbl_purchase_summary');
        tbl_summary.find(oTableDetails.discount).html(accounting.formatNumber(discounts,2));
        tbl_summary.find(oTableDetails.before_tax).html(accounting.formatNumber(before_tax,2));
        tbl_summary.find(oTableDetails.tax_amount).html(accounting.formatNumber(tax_amount,2));
        tbl_summary.find(oTableDetails.after_tax).html('<b>'+accounting.formatNumber(after_tax,2)+'</b>');
        tbl_summary.find(oTableDetails.total_line_discount).html('<b>'+accounting.formatNumber(after_discount,2)+'</b>');

        $('#td_before_tax').html(accounting.formatNumber(before_tax,2));
        $('#td_after_tax').html('<b>'+accounting.formatNumber(after_tax,2)+'</b>');
        $('#td_discount').html(accounting.formatNumber(discounts,2));
        $('#td_tax').html(accounting.formatNumber(tax_amount,2));
        $('#td_total_after_discount').html(accounting.formatNumber(after_tax,2));
        $('#txt_overall_discount_amount').val(accounting.formatNumber((gross-discounts-after_tax),2));
    };

    _cboDepartments.on("select2:select", function (e) {

        var i=$(this).select2('val');
        var obj_department=$('#cbo_departments').find('option[value="'+i+'"]');

        _defCostType=obj_department.data('default-cost');
    });

    _cboDepartments.on("select2:select", function (e) {

        var i=$(this).select2('val');

        if(i==0){ //new supplier
            _cboDepartments.select2('val',null)
            $('#modal_new_department').modal('show');
            //clearFields($('#modal_new_supplier').find('form'));
        }else{
            var obj_department=$('#cbo_departments').find('option[value="'+i+'"]');
            _defCostType=obj_department.data('default-cost');
            //_cboTaxType.select2('val',obj_supplier.data('tax-type')); //set tax type base on selected Supplier
        }


    });


    _cboSuppliers.on("select2:select", function (e) {
        var i=$(this).select2('val');
        if(i==0){ //new supplier
            _cboSuppliers.select2('val',null)
            $('#modal_new_supplier').modal('show');
            clearFields($('#modal_new_supplier').find('form'));
        }else{
            var obj_supplier=$('#cbo_suppliers').find('option[value="'+i+'"]');
            _cboTaxType.select2('val',obj_supplier.data('tax-type')); //set tax type base on selected Supplier
        }


    });

    var reInitializeNumeric=function(){
        $('.numeric').autoNumeric('init',{mDec: 2});
        $('.number').autoNumeric('init', {mDec:0});
    };
    var checkProduct= function(check_id){
        var prodstat=true;
        var rowcheck=$('#tbl_items > tbody tr');
        $.each(rowcheck,function(){
            item = parseFloat(accounting.unformat($(oTableItems.item_id,$(this)).find('input').val()));
            // alert()
            if(check_id == item){
                prodstat=false;
                return false;
            }
        });
         return prodstat;    
    };
});




</script>


</body>


</html>