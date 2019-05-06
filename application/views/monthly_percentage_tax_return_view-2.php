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
                                    <div id="div_bank_list">
                                        <div class="panel panel-default">
                                            <div class="panel-body table-responsive">
                                            <h2 class="h2-panel-heading">Monthly Percentage Tax Return</h2><hr>
                                                (To be filled up by the BIR)
                                                <div>
                                                    <span>&#x25B6; DLN:</span>
                                                    <span class="pull-right">&#x25B6; PSIC:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    </span>
                                                </div>
                                                <table id="tbl_mptr" class="table" style="border:1px solid black!important;" width="100%">
                                                    <tbody>
                                                        <tr style="height: 100px;">
                                                            <td style="width: 38%">
                                                                Republika ng Pilipinas<br>
                                                                Kagawaran ng Pananalapi<br>
                                                                Kawanihan ng Rentas Internas
                                                            </td>
                                                            <td style="width: 24%">
                                                                <center>
                                                                    <h2>
                                                                        Monthly Percentage<br>
                                                                        Tax Return
                                                                    </h2>
                                                                </center>
                                                            </td>
                                                            <td class="pull-right" style="width: 38%">
                                                                BIR Form No.
                                                                <p><span style="font-size: 40px;"><b>2551M</b></span><br>September 2005 (ENCS)</p>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <table id="tbl_mptr2" class="table" style="margin-top: 3px;" width="100%">
                                                    <tbody>
                                                        <tr>
                                                            <td colspan="7">Fill in all applicable spaces. Mark all appropriate boxes with an "X".</td>
                                                        </tr>
                                                        <tr class="bglabel-color" style="height: 50px;">
                                                            <td style="width: 30%" colspan="2">
                                                                <b>1</b> &#x25B6; For the&nbsp;
                                                                <input type="checkbox" name="calendar" id="calendar">
                                                                <label for='calendar' style="vertical-align: text-bottom!important;">Calendar </label> 
                                                                <input type="checkbox" name="fiscal" id="fiscal">
                                                                <label for='fiscal' style="vertical-align: text-bottom!important;">Fiscal </label><br>
                                                                <div class="col-md-4 left">
                                                                    <b>2</b> &#x25B6; <span>Year ended<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(MM/YYYY)</span>
                                                                </div>
                                                                <div class="col-md-8 right">
                                                                    <input type="text" name="year_ended" class="form-control">
                                                                </div>
                                                            </td>
                                                            <td colspan="3" style="width: 25%">
                                                                <b>3</b> For the month<br>
                                                                <div class="col-md-4 left">
                                                                    (MM/YYYY) &#x25B6;
                                                                </div>
                                                                <div class="col-md-8 right">
                                                                    <input type="text" name="for_the_month" class="form-control">
                                                                </div>
                                                            </td>
                                                            <td style="width: 20%">
                                                                <b>4</b> Amended Return<br><br>
                                                                &#x25B6; &nbsp;&nbsp;&nbsp;<input type="checkbox" name="amended_return_yes" id="amended_return_yes">
                                                                <label for='amended_return_yes' style="vertical-align: text-bottom!important;">Yes </label> 
                                                                &nbsp;&nbsp;&nbsp;
                                                                <input type="checkbox" name="amended_return_no" id="amended_return_no">
                                                                <label for='amended_return_no' style="vertical-align: text-bottom!important;">No </label>
                                                            </td>
                                                            <td style="width: 25%">
                                                                <b>5</b> Number of sheets attached<br>
                                                                <input type="text" name="no_of_sheets_attached" style="width: 30%!important;" class="form-control pull-right">
                                                            </td>
                                                        </tr>
                                                        <tr class="bglabel-color">
                                                            <td colspan="7"><b><span style="float: left;">Part I</span><center><span>Background Information</span></center></b></td>
                                                        </tr>
                                                        <tr class="bglabel-color">
                                                            <td colspan="2">
                                                                <div class="col-md-2 left">
                                                                    <b>6</b> TIN<br>&nbsp;&nbsp;&nbsp;&#x25B6;
                                                                </div>
                                                                <div class="col-md-10 right">
                                                                    <input type="text" name="tin" class="form-control">
                                                                </div>
                                                            </td>
                                                            <td colspan="2" style="width: 20%;">
                                                                <div class="col-md-5 left">
                                                                    <b>7</b> RDO Code<br>&nbsp;&nbsp;&nbsp;&#x25B6;
                                                                </div>
                                                                <div class="col-md-7 right">
                                                                    <input type="text" name="rdo_code" class="form-control">
                                                                </div>
                                                            </td>
                                                            <td colspan="3">
                                                                <div class="col-md-4 left">
                                                                    <b>8</b> Line of Business/<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Occupation&nbsp;&nbsp;&nbsp; &#x25B6;
                                                                </div>
                                                                <div class="col-md-8 right">
                                                                    <input type="text" name="line_of_business" class="form-control">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr class="bglabel-color">
                                                            <td colspan="6">
                                                                <b>9 </b>&nbsp;Taxpayer's Name (For Individual)Last Name, First Name, Middle Name(For Non-individual) Registered Name<br>
                                                                <div class="col-md-1">
                                                                    &#x25B6;
                                                                </div>
                                                                <div class="col-md-11 right left">
                                                                    <input type="text" name="taxpayer_name" class="form-control">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <b>10 </b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Telephone Number<br>
                                                                <div class="col-md-11 pull-right right">
                                                                    <input type="text" name="telephone_number" class="form-control">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr class="bglabel-color">
                                                            <td colspan="6">
                                                                <b>11 </b>&nbsp;Registered Address<br>
                                                                <div class="col-md-1">
                                                                    &#x25B6;
                                                                </div>
                                                                <div class="col-md-11 right left">
                                                                    <input type="text" name="registered_address" class="form-control">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <b>12 </b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Zip Code<br>
                                                                <div class="col-md-7" style="text-align: right;">
                                                                    &#x25B6;
                                                                </div>
                                                                <div class="col-md-5 right" style>
                                                                    <input type="text" name="zip_code" class="form-control">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr class="bglabel-color">
                                                            <td colspan="7">
                                                                <b>13 </b>&nbsp;Are you availling of tax relief under Special Law<br>
                                                                <div class="col-md-7">&nbsp;or International Tax Treaty
                                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                    <input type="checkbox" name="special_yes" id="special_yes">
                                                                    <label for='special_yes' style="vertical-align: text-bottom!important;">Yes </label> 
                                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                    <input type="checkbox" name="special_no" id="special_no">
                                                                    <label for='special_no' style="vertical-align: text-bottom!important;">No </label>
                                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                    If yes, specify
                                                                </div>
                                                                <div class="col-md-5">
                                                                    <input type="text" name="special_specify" class="form-control">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr class="bglabel-color">
                                                            <td colspan="7"><b><span style="float: left;">Part II</span><center><span>&#x25B6; Computation of Tax</span></center></b></td>
                                                        </tr>
                                                        <tr class="no-border-tr bglabel-color">
                                                            <td class="no-border" colspan="2">
                                                                <center>
                                                                    Taxable Transaction/<br>
                                                                    Industry Classification
                                                                </center>
                                                            </td>
                                                            <td class="no-border">
                                                                <center>
                                                                    A T C
                                                                </center>
                                                            </td>
                                                            <td colspan="2" class="no-border">
                                                                <center>
                                                                    Taxable Amount
                                                                </center>
                                                            </td>
                                                            <td class="no-border">
                                                                <center>
                                                                    Tax Rate
                                                                </center>
                                                            </td>
                                                            <td class="no-border">
                                                                <center>
                                                                    Tax Due
                                                                </center>
                                                            </td>
                                                        </tr>
                                                        <tr class="no-border-tr bglabel-color">
                                                            <td class="no-border" colspan="2">
                                                                <div class="col-md-1 left">
                                                                    <b>14A</b>
                                                                </div>
                                                                <div class="col-md-11 right">
                                                                    <input type="text" name="14A" class="form-control">
                                                                </div>
                                                            </td>
                                                            <td class="no-border">
                                                                <div class="col-md-1 left">
                                                                    <b>14B</b>
                                                                </div>
                                                                <div class="col-md-10 right">
                                                                    <input type="text" name="14B" class="form-control">
                                                                </div>
                                                            </td>
                                                            <td colspan="2" class="no-border">
                                                                <div class="col-md-1 left">
                                                                    <b>14C</b>
                                                                </div>
                                                                <div class="col-md-10 right">
                                                                    <input type="text" name="14C" class="form-control">
                                                                </div>
                                                            </td>
                                                            <td class="no-border">
                                                                <div class="col-md-1 left">
                                                                    <b>14D</b>
                                                                </div>
                                                                <div class="col-md-10 right">
                                                                    <input type="text" name="14D" class="form-control">
                                                                </div>
                                                            </td>
                                                            <td class="no-border">
                                                                <div class="col-md-1 left">
                                                                    <b>14E</b>
                                                                </div>
                                                                <div class="col-md-10 right">
                                                                    <input type="text" name="14E" class="form-control">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr class="no-border-tr bglabel-color">
                                                            <td class="no-border" colspan="2">
                                                                <div class="col-md-1 left">
                                                                    <b>15A</b>
                                                                </div>
                                                                <div class="col-md-11 right">
                                                                    <input type="text" name="15A" class="form-control">
                                                                </div>
                                                            </td>
                                                            <td class="no-border">
                                                                <div class="col-md-1 left">
                                                                    <b>15B</b>
                                                                </div>
                                                                <div class="col-md-10 right">
                                                                    <input type="text" name="15B" class="form-control">
                                                                </div>
                                                            </td>
                                                            <td colspan="2" class="no-border">
                                                                <div class="col-md-1 left">
                                                                    <b>15C</b>
                                                                </div>
                                                                <div class="col-md-10 right">
                                                                    <input type="text" name="15C" class="form-control">
                                                                </div>
                                                            </td>
                                                            <td class="no-border">
                                                                <div class="col-md-1 left">
                                                                    <b>15D</b>
                                                                </div>
                                                                <div class="col-md-10 right">
                                                                    <input type="text" name="15D" class="form-control">
                                                                </div>
                                                            </td>
                                                            <td class="no-border">
                                                                <div class="col-md-1 left">
                                                                    <b>15E</b>
                                                                </div>
                                                                <div class="col-md-10 right">
                                                                    <input type="text" name="15E" class="form-control">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr class="no-border-tr bglabel-color">
                                                            <td class="no-border" colspan="2">
                                                                <div class="col-md-1 left">
                                                                    <b>16A</b>
                                                                </div>
                                                                <div class="col-md-11 right">
                                                                    <input type="text" name="16A" class="form-control">
                                                                </div>
                                                            </td>
                                                            <td class="no-border">
                                                                <div class="col-md-1 left">
                                                                    <b>16B</b>
                                                                </div>
                                                                <div class="col-md-10 right">
                                                                    <input type="text" name="16B" class="form-control">
                                                                </div>
                                                            </td>
                                                            <td colspan="2" class="no-border">
                                                                <div class="col-md-1 left">
                                                                    <b>16C</b>
                                                                </div>
                                                                <div class="col-md-10 right">
                                                                    <input type="text" name="16C" class="form-control">
                                                                </div>
                                                            </td>
                                                            <td class="no-border">
                                                                <div class="col-md-1 left">
                                                                    <b>16D</b>
                                                                </div>
                                                                <div class="col-md-10 right">
                                                                    <input type="text" name="16D" class="form-control">
                                                                </div>
                                                            </td>
                                                            <td class="no-border">
                                                                <div class="col-md-1 left">
                                                                    <b>16E</b>
                                                                </div>
                                                                <div class="col-md-10 right">
                                                                    <input type="text" name="16E" class="form-control">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr class="no-border-tr bglabel-color">
                                                            <td class="no-border" colspan="2">
                                                                <div class="col-md-1 left">
                                                                    <b>17A</b>
                                                                </div>
                                                                <div class="col-md-11 right">
                                                                    <input type="text" name="17A" class="form-control">
                                                                </div>
                                                            </td>
                                                            <td class="no-border">
                                                                <div class="col-md-1 left">
                                                                    <b>17B</b>
                                                                </div>
                                                                <div class="col-md-10 right">
                                                                    <input type="text" name="17B" class="form-control">
                                                                </div>
                                                            </td>
                                                            <td colspan="2" class="no-border">
                                                                <div class="col-md-1 left">
                                                                    <b>17C</b>
                                                                </div>
                                                                <div class="col-md-10 right">
                                                                    <input type="text" name="17C" class="form-control">
                                                                </div>
                                                            </td>
                                                            <td class="no-border">
                                                                <div class="col-md-1 left">
                                                                    <b>17D</b>
                                                                </div>
                                                                <div class="col-md-10 right">
                                                                    <input type="text" name="17D" class="form-control">
                                                                </div>
                                                            </td>
                                                            <td class="no-border">
                                                                <div class="col-md-1 left">
                                                                    <b>17E</b>
                                                                </div>
                                                                <div class="col-md-10 right">
                                                                    <input type="text" name="17E" class="form-control">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr class="no-border-tr bglabel-color">
                                                            <td class="no-border" colspan="2">
                                                                <div class="col-md-1 left">
                                                                    <b>18A</b>
                                                                </div>
                                                                <div class="col-md-11 right">
                                                                    <input type="text" name="18A" class="form-control">
                                                                </div>
                                                            </td>
                                                            <td class="no-border">
                                                                <div class="col-md-1 left">
                                                                    <b>18B</b>
                                                                </div>
                                                                <div class="col-md-10 right">
                                                                    <input type="text" name="18B" class="form-control">
                                                                </div>
                                                            </td>
                                                            <td colspan="2" class="no-border">
                                                                <div class="col-md-1 left">
                                                                    <b>18C</b>
                                                                </div>
                                                                <div class="col-md-10 right">
                                                                    <input type="text" name="18C" class="form-control">
                                                                </div>
                                                            </td>
                                                            <td class="no-border">
                                                                <div class="col-md-1 left">
                                                                    <b>18D</b>
                                                                </div>
                                                                <div class="col-md-10 right">
                                                                    <input type="text" name="18D" class="form-control">
                                                                </div>
                                                            </td>
                                                            <td class="no-border">
                                                                <div class="col-md-1 left">
                                                                    <b>18E</b>
                                                                </div>
                                                                <div class="col-md-10 right">
                                                                    <input type="text" name="18E" class="form-control">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr class="no-border-tr bglabel-color">
                                                            <td colspan="6" class="no-border">
                                                                <b>19 </b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total Tax Due
                                                            </td>
                                                            <td class="no-border">
                                                                <div class="col-md-1 left">
                                                                    <b>19</b>
                                                                </div>
                                                                <div class="col-md-10 right">
                                                                    <input type="text" name="19" class="form-control">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr class="no-border-tr bglabel-color">
                                                            <td colspan="7" class="no-border">
                                                                <b>20 </b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Less: Tax Credits/Payment
                                                            </td>
                                                        </tr>
                                                        <tr class="no-border-tr bglabel-color">
                                                            <td colspan="6" class="no-border">
                                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>20A </b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Creditable Percentage Tax Withheld Per BIR Form No. 2307 (See Schedule 1)
                                                            </td>
                                                            <td class="no-border">
                                                                <div class="col-md-1 left">
                                                                    <b>20A</b>
                                                                </div>
                                                                <div class="col-md-10 right">
                                                                    <input type="text" name="20A" class="form-control">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr class="no-border-tr bglabel-color">
                                                            <td colspan="6" class="no-border">
                                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>20B </b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tax Paid in Return Previously Filed, if this is an Amended Return
                                                            </td>
                                                            <td class="no-border">
                                                                <div class="col-md-1 left">
                                                                    <b>20B</b>
                                                                </div>
                                                                <div class="col-md-10 right">
                                                                    <input type="text" name="20B" class="form-control">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr class="no-border-tr bglabel-color">
                                                            <td colspan="6" class="no-border">
                                                                <b>21 </b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total Tax Credits/Payments (Sum of Items 20A & 20B)
                                                            </td>
                                                            <td class="no-border">
                                                                <div class="col-md-1 left">
                                                                    <b>21</b>
                                                                </div>
                                                                <div class="col-md-10 right">
                                                                    <input type="text" name="21" class="form-control">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr class="no-border-tr bglabel-color">
                                                            <td colspan="6" class="no-border">
                                                                <b>22 </b>&nbsp;Tax Payable (Overpayment) (Item 19 less Item 21)
                                                            </td>
                                                            <td class="no-border">
                                                                <div class="col-md-1 left">
                                                                    <b>22</b>
                                                                </div>
                                                                <div class="col-md-10 right">
                                                                    <input type="text" name="22" class="form-control">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr class="no-border-tr bglabel-color">
                                                            <td class="no-border" colspan="2">
                                                                <b>23 </b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Add: Penalties
                                                            </td>
                                                            <td class="no-border">
                                                                <center>Surcharge</center>
                                                            </td>
                                                            <td class="no-border" colspan="2">
                                                                <center>Interest</center>
                                                            </td>
                                                            <td class="no-border" colspan="1">
                                                                <center>Compromise</center>
                                                            </td>
                                                            <td class="no-border">
                                                            </td>
                                                        </tr>
                                                        <tr class="no-border-tr bglabel-color">
                                                            <td class="no-border" colspan="2">
                                                            </td>
                                                            <td class="no-border">
                                                                <div class="col-md-1 left">
                                                                    <b>23A</b>
                                                                </div>
                                                                <div class="col-md-10 right">
                                                                    <input type="text" name="23A" class="form-control">
                                                                </div>
                                                            </td>
                                                            <td class="no-border" colspan="2">
                                                                <div class="col-md-1 left">
                                                                    <b>23B</b>
                                                                </div>
                                                                <div class="col-md-10 right">
                                                                    <input type="text" name="23B" class="form-control">
                                                                </div>
                                                            </td>
                                                            <td class="no-border">
                                                                <div class="col-md-1 left">
                                                                    <b>23C</b>
                                                                </div>
                                                                <div class="col-md-10 right">
                                                                    <input type="text" name="23C" class="form-control">
                                                                </div>
                                                            </td>
                                                            <td class="no-border">
                                                                <div class="col-md-1 left">
                                                                    <b>23D</b>
                                                                </div>
                                                                <div class="col-md-10 right">
                                                                    <input type="text" name="23D" class="form-control">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr class="no-border-tr bglabel-color">
                                                            <td colspan="6" class="no-border">
                                                                <b>24 </b>&nbsp;&nbsp;&nbsp;Total Amount Payable/(Overpayment) (Sum of items 22 and 23D)
                                                            </td>
                                                            <td class="no-border">
                                                                <div class="col-md-1 left">
                                                                    <b>24</b>
                                                                </div>
                                                                <div class="col-md-10 right">
                                                                    <input type="text" name="24" class="form-control">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr class="no-border-tr bglabel-color">
                                                            <td colspan="2" class="no-border">
                                                               &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;If overpayment, mark one box only:
                                                            </td>
                                                            <td colspan="3" class="no-border">
                                                                <input type="checkbox" name="refunded" id="refunded">
                                                                <label for='refunded' style="vertical-align: text-bottom!important;">To be Refunded </label> 
                                                            </td>
                                                            <td colspan="2" class="no-border">
                                                                <input type="checkbox" name="tax_credit" id="tax_credit">
                                                                <label for='tax_credit' style="vertical-align: text-bottom!important;">To be issued a Tax Credit Certificate </label><br>
                                                            </td>
                                                        </tr>
                                                        <tr class="border-tr">
                                                            <td colspan="7" class="no-border">
                                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;I declare, under the penalties of perjury, that this return has been made in good fatith, verified by me, and to the best of my knowledge, and belief, is true and correct, pursuant to the provisions of the National Internal Revenue Code, as amended, and the regulations issued under authority thereof.
                                                            </td>
                                                        </tr>
                                                        <tr class="no-border-tr">
                                                            <td colspan="5" class="no-border">
                                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>25</b><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u><br>
                                                                <center>President/Vice President/Principal Officer/Accredited Tax Agent/<br>Authorized Representative/Taxpayer<br>(Signature Over Printed Name)<center>
                                                            </td>
                                                            <td colspan="2" class="no-border">
                                                                <center>
                                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>26</b><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u><br>
                                                                Treasurer/Assistant Treasurer<br>(Signature Over Printed Name)<center>
                                                            </td>
                                                        </tr>
                                                        <tr class="no-border-tr">
                                                            <td colspan="2" class="no-border">
                                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<center><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u><br>Title/Position of Signatory</center>
                                                            </td>
                                                            <td colspan="3" class="no-border">
                                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<center><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u><br>TIN of Signatory</center>
                                                            </td>
                                                            <td colspan="2" class="no-border">
                                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                <center><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u><br>
                                                                Title/Position of Signatory</center>
                                                            </td>
                                                        </tr>
                                                        <tr class="no-border-tr">
                                                            <td class="no-border" colspan="2">
                                                                <center><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u><br>Tax Agent Acc. No./Atty's Roll No.(if applicable) </center>
                                                            </td>
                                                            <td class="no-border">
                                                                <center><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u><br>Date of Issuance</center>
                                                            </td>
                                                            <td colspan="2" class="no-border">
                                                                <center><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u><br>Date of Expiry</center>
                                                            </td>
                                                            <td colspan="2" class="no-border">
                                                                <center><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u><br>TIN of Signatory</center>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="6" class="bglabel-color">
                                                                <b><span style="float: left;">Part III</span><center><span>Details of Payment</span></center></b>
                                                            </td>
                                                            <td rowspan="6"><center><br>Stamp of Receiving Office/AAB and Date of Receipt (RO's Signature/ Bank Teller's Initial)</center></td>
                                                        </tr>
                                                        <tr class="bglabel-color">
                                                            <td><center>Particulars</center></td>
                                                            <td><center>Drawee Bank/Agency</center></td>
                                                            <td><center>Number</center></td>
                                                            <td><center>Date<br>MM-DD-YYYY</center></td>
                                                            <td colspan="2"><center>Amount</center></td>
                                                        </tr>
                                                        <tr class="no-border-tr bglabel-color">
                                                            <td class="no-border" style="width: 15%;"><b>27 </b>&nbsp;&nbsp;Cash/Bank<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Debit Memo</td>
                                                            <td class="no-border">
                                                                <div class="col-md-1 left">
                                                                    <b>27A</b>
                                                                </div>
                                                                <div class="col-md-10 right">
                                                                    <input type="text" name="27A" class="form-control">
                                                                </div>
                                                            </td>
                                                            <td class="no-border">
                                                                <div class="col-md-1 left">
                                                                    <b>27B</b>&#x25B6;
                                                                </div>
                                                                <div class="col-md-10 right">
                                                                    <input type="text" name="27B" class="form-control">
                                                                </div>
                                                            </td>
                                                            <td class="no-border">
                                                                <div class="col-md-1 left">
                                                                    <b>27C</b>&#x25B6;
                                                                </div>
                                                                <div class="col-md-10 right">
                                                                    <input type="text" name="27C" class="form-control">
                                                                </div>
                                                            </td>
                                                            <td colspan="2" class="no-border">
                                                                <div class="col-md-1 left">
                                                                    <b>27D</b>&#x25B6;
                                                                </div>
                                                                <div class="col-md-10 right">
                                                                    <input type="text" name="27D" class="form-control">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr class="no-border-tr bglabel-color">
                                                            <td class="no-border" style="width: 15%;"><b>28 </b>&nbsp;&nbsp;Check</td>
                                                            <td class="no-border">
                                                                <div class="col-md-1 left">
                                                                    <b>28A</b>&#x25B6;
                                                                </div>
                                                                <div class="col-md-10 right">
                                                                    <input type="text" name="28A" class="form-control">
                                                                </div>
                                                            </td>
                                                            <td class="no-border">
                                                                <div class="col-md-1 left">
                                                                    <b>28B</b>&#x25B6;
                                                                </div>
                                                                <div class="col-md-10 right">
                                                                    <input type="text" name="28B" class="form-control">
                                                                </div>
                                                            </td>
                                                            <td class="no-border">
                                                                <div class="col-md-1 left">
                                                                    <b>28C</b>&#x25B6;
                                                                </div>
                                                                <div class="col-md-10 right">
                                                                    <input type="text" name="28C" class="form-control">
                                                                </div>
                                                            </td>
                                                            <td colspan="2" class="no-border">
                                                                <div class="col-md-1 left">
                                                                    <b>28D</b>&#x25B6;
                                                                </div>
                                                                <div class="col-md-10 right">
                                                                    <input type="text" name="28D" class="form-control">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr class="no-border-tr bglabel-color">
                                                            <td colspan="2" class="no-border" style="width: 15%;"><b>29 </b>&nbsp;&nbsp;Tax Debit<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Memo</td>
                                                            <td class="no-border">
                                                                <div class="col-md-1 left">
                                                                    <b>29A</b>&#x25B6;
                                                                </div>
                                                                <div class="col-md-10 right">
                                                                    <input type="text" name="29A" class="form-control">
                                                                </div>
                                                            </td>
                                                            <td class="no-border">
                                                                <div class="col-md-1 left">
                                                                    <b>29B</b>&#x25B6;
                                                                </div>
                                                                <div class="col-md-10 right">
                                                                    <input type="text" name="29B" class="form-control">
                                                                </div>
                                                            </td>
                                                            <td colspan="2" class="no-border">
                                                                <div class="col-md-1 left">
                                                                    <b>29C</b>&#x25B6;
                                                                </div>
                                                                <div class="col-md-10 right">
                                                                    <input type="text" name="29C" class="form-control">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr class="no-border-tr bglabel-color">
                                                            <td class="no-border" style="width: 15%;"><b>30 </b>&nbsp;&nbsp;Others</td>
                                                            <td class="no-border">
                                                                <div class="col-md-1 left">
                                                                    <b>30A</b>&#x25B6;
                                                                </div>
                                                                <div class="col-md-10 right">
                                                                    <input type="text" name="30A" class="form-control">
                                                                </div>
                                                            </td>
                                                            <td class="no-border">
                                                                <div class="col-md-1 left">
                                                                    <b>30B</b>&#x25B6;
                                                                </div>
                                                                <div class="col-md-10 right">
                                                                    <input type="text" name="30B" class="form-control">
                                                                </div>
                                                            </td>
                                                            <td class="no-border">
                                                                <div class="col-md-1 left">
                                                                    <b>30C</b>&#x25B6;
                                                                </div>
                                                                <div class="col-md-10 right">
                                                                    <input type="text" name="30C" class="form-control">
                                                                </div>
                                                            </td>
                                                            <td colspan="2" class="no-border">
                                                                <div class="col-md-1 left">
                                                                    <b>30D</b>&#x25B6;
                                                                </div>
                                                                <div class="col-md-10 right">
                                                                    <input type="text" name="30D" class="form-control">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr style="border-bottom: none!important;">
                                                            <td colspan="7" class="no-border">
                                                                Machine Validation/Revenue Official Receipt Details (If not filed with an Authorized Agent Bank)
                                                            </td>
                                                        </tr>
                                                        <tr class="no-border-tr">
                                                            <td colspan="7" class="no-border"></td>
                                                        </tr>
                                                        <tr style="border-top: none!important;">
                                                            <td colspan="7" class="no-border"></td>
                                                        </tr>
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

<script src="assets/plugins/select2/select2.full.min.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/jquery.dataTables.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/dataTables.bootstrap.js"></script>

<script>

$(document).ready(function(){
    var dt; var _txnMode; var _selectedID; var _selectRowObj; var _cboAccountType;

    var initializeControls=function(){

    }();

    var bindEventHandlers=(function(){
        var detailRows = [];
        
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
            $('#div_bank_list').show();
            $('#div_bank_fields').hide();
        }else{
            $('#div_bank_list').hide();
            $('#div_bank_fields').show();
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

</html>vie