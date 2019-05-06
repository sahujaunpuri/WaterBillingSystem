 <style type="text/css">
     #content td {
        font-size: 14px;
        /*border: 1px solid gray!important; */
     }
     .left{border-left: 1px solid gray!important; }
     .right{border-right: 1px solid gray!important; }
     .top{border-top: 1px solid gray!important; }
     .bottom{border-bottom: 1px solid gray!important; }

    #content tr:nth-child(even){
            background-color: : #f9f9f9 !important;

        }
    #content tr:nth-child(odd){
            background-color: transparent; !important;

        }
        span{
            font-size: 14px;
        }
 </style>
 <div style="margin-left: 20px">
    <h2 style="margin-top: 0px!important;">Transaction Details</h2> <hr />
    <div class="row">
        <div class="col-sm-6">
                <span>Guest name :</span> <span style="font-size: 14px;font-weight: bolder;"><?php echo $item->guest_name; ?></span><br>
                <span>Reference No :</span> <span style="font-size: 14px;font-weight: bolder;"><?php echo $item->ref_no; ?></span><br>
                <span>Sales Date :</span> <span style="font-size: 14px;font-weight: bolder;"><?php echo $item->sales_date; ?></span><br><br>
        </div>
        <div class="col-sm-6">
                                <span>AR to :</span> <span style="font-size: 14px;font-weight: bolder;"><?php echo $item->ar_guest_name; ?></span><br>
        </div>
    </div>
    <h2>Journal Entries</h2><hr><br>
</div>
    <table class="customers_content"  id="content" width="100%" style="font-family: tahoma; border: 1px solid gray!important;">
        <tbody>
        <tr>
        <td style="font-weight: bolder;" class="bottom ">Account</td>
        <td  style="text-align: right;font-weight: bolder;" class="bottom ">Debit</td>
        <td  style="text-align: right;font-weight: bolder;" class="bottom ">Credit</td>
        </tr>
        <?php 
        $total_dr = 0;
        $total_cr = 0;
        foreach ($entries as $entry) { ?>
        <tr>
            <td  class="left bottom" style="text-align: left;"><?php  echo $entry->account_title ?></td>
            <td class=" bottom" style="text-align: right;"><?php  echo number_format($entry->dr_amount,2); ?></td>
            <td class=" bottom" style="text-align: right;"><?php  echo number_format($entry->cr_amount,2); ?></td>
        </tr>
        <?php 
        $total_dr += $entry->dr_amount;
        $total_cr += $entry->cr_amount;
         } ?>

        <td></td>
        <td  style="text-align: right;font-weight: bolder;"><?php echo  number_format($total_dr,2); ?></td>
        <td  style="text-align: right;font-weight: bolder;"><?php echo  number_format($total_cr,2); ?></td>
        </tr>
        </tbody>

    </table>
<hr><br><br>
** END OF TRANSACTION **<br><br>
<hr>
