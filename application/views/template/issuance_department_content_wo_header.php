<head>  <title>Issuance Report</title></head>
<body>
<style>



    #issuance tr {
        background: transparent !important;
    }

    #report_footer th {
/*        background: #303030 !important;
*/    }
    .report{

    border-bottom: 1px solid gray;

    border-right: none;
    border-left:none;
    border-top:none;

}
    td{

    }
    tr {
/*        border: none!important;*/
    }

    tr:nth-child(even){
/*        background: #414141 !important;*/
/*        border: none!important;*/
    }

/*    tr:hover {
        transition: .4s;
        background: #414141 !important;
        color: white;
    }
    
*/
    th{
        background-color: transparent!important;
    }
/*    tr:hover .btn {
        border-color: #494949!important;
        border-radius: 0!important;
        -webkit-box-shadow: 0px 0px 5px 1px rgba(0,0,0,0.75);
        -moz-box-shadow: 0px 0px 5px 1px rgba(0,0,0,0.75);
        box-shadow: 0px 0px 5px 1px rgba(0,0,0,0.75);
    }
*/
       body {
        font-family: 'Calibri',sans-serif;
        font-size: 12px;
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
       table{
        border:none!important;
    }
          
      </style>

<div style="width:100%">
<table style="font-family:tahoma;width: 100%;" id="report_header">
    <tbody>
        <tr>
            <td style="width:75%;font-size:18px;font-weight:bold;border:none!important;">ITEM TRANSFER REPORT</td>
            <td style="width:25%;font-size:18px;font-weight:bold;border:none!important;text-align: right;"><?php echo $issuance_info->trn_no; ?></td>
        </tr>

    </tbody>
</table>

<table width="100%" id="issuance">
    <thead>
    </thead>
    <tbody>
        <tr>
            <td style="width:20%;text-align:left;font-weight:bold;border:none!important;">From Department:</td>
            <td style="width:20%;text-align:center;" class="report"><?php echo $issuance_info->from_department_name; ?></td>
            <td style="width:10%;border:none!important;"></td>
            <td style="width:10%;border:none!important;"></td>
            <td style="width:20%;text-align:right;font-weight:bold;border:none!important;">Date:</td>
            <td style="width:20%;text-align:center;" class="report"><?php echo  date_format(new DateTime($issuance_info->date_issued),"m/d/Y"); ?></td>
        </tr>
        <tr>


            <td style="width:20%;text-align:left;font-weight:bold;border:none!important;">To Department:</td>
            <td style="width:20%;text-align:center;" class="report"><?php echo $issuance_info->to_department_name; ?></td>
            <td style="width:10%;border:none!important;"></td>

            <td style="width:10%;border: none!important;"></td>
            <td style="text-align:right;font-weight:bold;border:none!important;">Terms:</td>
            <td style="width:20%;text-align:center;" class="report"> <?php echo $issuance_info->terms; ?></td>
        </tr>
    </tbody>
</table><br>
<table width="100%" style="font-family:tahoma;" cellspacing="0" >
    <thead>
        <tr >
            <th style="width:35%;text-align:left;border-bottom: 1px solid gray;">Description</th>
            <th style="width:10%;text-align:center;border-bottom: 1px solid gray;">Quantity</th>
            <th style="width:15%;text-align:center;border-bottom: 1px solid gray;">Unit</th>
            <th style="width:20%;text-align:center;border-bottom: 1px solid gray;">Unit Price</th>
            <th style="width:20%;text-align:center;border-bottom: 1px solid gray;">Amount</th>
        </tr>
    </thead>
    <tbody>
       <?php 
            $grandtotal=0;
            foreach($issue_items as $item){
            $grandtotal+=$item->issue_line_total_price;
             ?>
                <tr>
                    <td style="border-bottom: 1px solid gray;"><?php echo $item->product_desc; ?></td>
                    <td style="text-align:center; border-bottom: 1px solid gray;"><?php echo number_format($item->issue_qty,0); ?></td>
                    <td style="text-align:center; border-bottom: 1px solid gray;"><?php echo $item->unit_name; ?></td>
                    <td style="text-align:center;border-bottom: 1px solid gray;"><?php echo number_format($item->issue_price,2); ?></td>
                    <td style="text-align:center;border-bottom: 1px solid gray;"><?php echo number_format($item->issue_line_total_price,2); ?></td>
                </tr>
            <?php } ?>
            <tr>
            <td colspan="3"></td>
                <td  style="text-align:left;font-weight:bold;  border-bottom: 1px solid gray;">Grand Total</td>
                <td style="text-align:center;font-weight:bold; border-bottom: 1px solid gray;"><?php echo number_format($grandtotal,2); ?></td>
            </tr>
    </tbody>
</table>
</div>









