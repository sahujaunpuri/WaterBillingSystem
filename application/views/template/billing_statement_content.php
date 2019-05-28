<head><title>Billing Statement</title></head>
<body>
<style>
    body {
            font-family: 'Calibri',sans-serif;
            font-size: 12px;
    padding:0;
    margin:0;

    }    
    .align-right {
        text-align: right;
    }
    .align-left {
        text-align: left;
    }
    .align-center {
        text-align: center;
    }
    .report-header {
        font-weight: bolder;
    }
    @page {
      size: A4 portrait;
      margin: 2cm 3cm;
    }
    table{
        border:none!important;
    }
    .left {border-left: 1px solid lightgray;}
    .right{border-right: 1px solid lightgray;}
    .bottom{border-bottom: 1px solid lightgray;}
    .top{border-top: 1px solid lightgray;}
    .bold{font-weight: bold;}
    div { position: relative; }
    div > span { position: absolute; right: 10; bottom: 0; }
    .pb{
        margin: 0px 20px;
/*page-break-after:always; border: 1px black;*/
    }
</style>
<?php  for($i=0;$i< 5;$i++){ ?>

<div style="page-break-after:always;">
<div class="pb" style="height: 330px;mri"><br><br>
    <center><span style="text-transform: uppercase;"><?php echo $company_info->company_name; ?></span><br>
    <span style="text-transform: uppercase;"><?php echo $company_info->company_address; ?></span></center><hr>
    <center><b>BILLING STATEMENTS</b></center><hr>
    <table style="font-size: 12px;">
        <tbody>
            <tr>
                <td>ACCOUNT NO : &nbsp;&nbsp; 00003541351</td>
            </tr>
            <tr>
                <td>Customer Name : &nbsp;&nbsp; JOASH JEZREEL NOBLE</td>
            </tr>
            <tr>
                <td>Address: &nbsp;&nbsp;LOT 1 BLK 15, TAAL ST
            </tr>
        </tbody>
    </table>
    <hr>
    <table width="100%" style="font-size: 12px;">
        <tbody>
            <tr>
                <td colspan="2">PERIOD COVERED : 01/01/2019 - 01/31/2019</td>
                <td colspan="2">Due Date: 02/15/2019</td>
            </tr>
            <tr>
                <td colspan="4">&nbsp;&nbsp;</td>
            </tr>
            <tr>
                <td colspan="4">Meter Reading</td>
            </tr>
            <tr>
                <td width="10%"></td>
                <td colspan="3">Reading Date: 02/01/2019</td>
            </tr>
            <tr>
                <td></td>
                <td>Previous Reading:&nbsp;&nbsp;11,367</td>
                <td>Current Reading: &nbsp;&nbsp;11,403</td>
                <td>Consume: &nbsp;&nbsp;<b>36</b></td>
            </tr>
            <tr>
                <td colspan="4">Payables</td>
            </tr>
            <tr>
                <td></td>
                <td>Amount Due:&nbsp;&nbsp;792.50</td>
                <td>Penalty:&nbsp;&nbsp;79.25</td>
                <td>Total Amount Due:&nbsp;&nbsp;871.75</td>
            </tr>
            <tr>
                <td colspan="4">&nbsp;&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2">TOTAL AMOUNT BEFORE DUE DATE:&nbsp;&nbsp;<b>792.50</b></td>
                <td colspan="2">TOTAL AMOUNT AFTER DUE DATE:&nbsp;&nbsp;<b>871.75</b></td>
            </tr>
        </tbody>
    </table>   
<span >File Copy</span>
</div>
<center>- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -</center> <br>
<div class="pb" style="height: 330px;">
    <center><span style="text-transform: uppercase;"><?php echo $company_info->company_name; ?></span><br>
    <span style="text-transform: uppercase;"><?php echo $company_info->company_address; ?></span></center><hr>
    <center><b>BILLING STATEMENTS</b></center><hr>
    <table style="font-size: 12px;">
        <tbody>
            <tr>
                <td>ACCOUNT NO : &nbsp;&nbsp; 00003541351</td>
            </tr>
            <tr>
                <td>Customer Name : &nbsp;&nbsp; JOASH JEZREEL NOBLE</td>
            </tr>
            <tr>
                <td>Address: &nbsp;&nbsp;LOT 1 BLK 15, TAAL ST
            </tr>
        </tbody>
    </table><hr>
    <table width="100%" style="font-size: 12px;">
        <tbody>
            <tr>
                <td colspan="2">PERIOD COVERED : 01/01/2019 - 01/31/2019</td>
                <td colspan="2">Due Date: 02/15/2019</td>
            </tr>
            <tr>
                <td colspan="4">&nbsp;&nbsp;</td>
            </tr>
            <tr>
                <td colspan="4">Meter Reading</td>
            </tr>
            <tr>
                <td width="10%"></td>
                <td colspan="3">Reading Date: 02/01/2019</td>
            </tr>
            <tr>
                <td></td>
                <td>Previous Reading:</td>
                <td>Current Reading</td>
                <td>Consume</td>
            </tr>
            <tr>
                <td colspan="4">Payables</td>
            </tr>
            <tr>
                <td></td>
                <td>Amount Due:&nbsp;&nbsp;11,367</td>
                <td>Penalty:&nbsp;&nbsp;11,403</td>
                <td>Total Amount Due:&nbsp;&nbsp;<b>36</b></td>
            </tr>
            <tr>
                <td colspan="4">&nbsp;&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2">TOTAL AMOUNT BEFORE DUE DATE:&nbsp;&nbsp;<b>792.50</b></td>
                <td colspan="2">TOTAL AMOUNT AFTER DUE DATE:&nbsp;&nbsp;<b>871.75</b></td>
            </tr>
        </tbody>
    </table>   
<span >Customer Copy</span>
</div>
<center>- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -</center> <br>
<div class="pb" style="height: 330px;">
    <center><span style="text-transform: uppercase;"><?php echo $company_info->company_name; ?></span><br>
    <span style="text-transform: uppercase;"><?php echo $company_info->company_address; ?></span></center><hr>
    <center><b>BILLING STATEMENTS</b></center><hr>
    <table style="font-size: 12px;">
        <tbody>
            <tr>
                <td>ACCOUNT NO : &nbsp;&nbsp; 00003541351</td>
            </tr>
            <tr>
                <td>Customer Name : &nbsp;&nbsp; JOASH JEZREEL NOBLE</td>
            </tr>
            <tr>
                <td>Address: &nbsp;&nbsp;LOT 1 BLK 15, TAAL ST
            </tr>
        </tbody>
    </table><hr>
    <table width="100%" style="font-size: 12px;">
        <tbody>
            <tr>
                <td colspan="2">PERIOD COVERED : 01/01/2019 - 01/31/2019</td>
                <td colspan="2">Due Date: 02/15/2019</td>
            </tr>
            <tr>
                <td colspan="4">&nbsp;&nbsp;</td>
            </tr>
            <tr>
                <td colspan="4">Meter Reading</td>
            </tr>
            <tr>
                <td width="10%"></td>
                <td colspan="3">Reading Date: 02/01/2019</td>
            </tr>
            <tr>
                <td></td>
                <td>Previous Reading:</td>
                <td>Current Reading</td>
                <td>Consume</td>
            </tr>
            <tr>
                <td colspan="4">Payables</td>
            </tr>
            <tr>
                <td></td>
                <td>Amount Due:&nbsp;&nbsp;11,367</td>
                <td>Penalty:&nbsp;&nbsp;11,403</td>
                <td>Total Amount Due:&nbsp;&nbsp;<b>36</b></td>
            </tr>
            <tr>
                <td colspan="4">&nbsp;&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2">TOTAL AMOUNT BEFORE DUE DATE:&nbsp;&nbsp;<b>792.50</b></td>
                <td colspan="2">TOTAL AMOUNT AFTER DUE DATE:&nbsp;&nbsp;<b>871.75</b></td>
            </tr>
        </tbody>
    </table>   
<span >Accounting Copy</span>
</div>
</div>
<?php } ?>
<script>
    // window.print();
</script>


















