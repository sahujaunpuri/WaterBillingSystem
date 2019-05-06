<script type="text/javascript">
    window.print();
</script>
<style type="text/css">
    label{
 font-family:"Segoe UI", "Source Sans Pro", Calibri, Candara, Arial, sans-serif;font:rgb(51, 51, 51);    
 vertical-align:middle;
 position: absolute;
    }
</style>
<img src="../../assets/img/bir_forms/2307.jpg" style="width: 8.5in;height: 13in;position: absolute;top: 0px;left: 0px;z-index: -999;">


<!-- DATE FROM AND TO -->
<label style=" top: 96px;left:130px;font-size:12px;font-weight:400; "><?php echo $form->date_month; ?></label>
<label style=" top: 96px;left:170px;font-size:12px;font-weight:400; ">01</label>
<label style=" top: 96px;left:205px;font-size:12px;font-weight:400; "><?php echo $form->date_year; ?></label>

<label style=" top: 96px;left:437px;font-size:12px;font-weight:400;"><?php echo $form->date_month; ?></label>
<label style=" top: 96px;left:477px;font-size:12px;font-weight:400;"><?php echo $form->month_end; ?></label>
<label style=" top: 96px;left:517px;font-size:12px;font-weight:400;"><?php echo $form->date_year; ?></label>
<!-- END OF DATE FROM AND TO -->

<!-- TAXPAYER   -->

<label style=" top: 169px;left:152px;font-size:12px;font-weight:400;"><?php echo $form->payee_name; ?></label>
<label style=" top: 202px;left:150px;font-size:12px;font-weight:400;"><?php echo $form->payee_address; ?></label>
<?php  $taxpayer_tin = explode('-', $form->payee_tin); ?>
<label style=" top: 142px;left:154px;font-size:12px;font-weight:400; "><?php  echo $taxpayer_tin[0];?></label>
<label style=" top: 142px;left:220px; font-size:12px;font-weight:400; "><?php  echo $taxpayer_tin[1];?></label>
<label style=" top: 142px;left:290px;font-size:12px;font-weight:400; "><?php  echo $taxpayer_tin[2];?></label>
<label style=" top: 142px;left:360px; font-size:12px;font-weight:400; "><?php  echo $taxpayer_tin[3];?></label>

<!-- END OF TAXPAYER  -->


<!-- TAX PAYOR -->

<label style=" top: 290px;left:152px;font-size:12px;font-weight:400;"><?php echo $form->payor_name; ?></label>
<label style=" top: 325px;left:151px; font-size:12px;font-weight:400;"><?php echo $form->payor_address; ?></label>
<?php  $taxpayor_tin = explode('-', $form->payor_tin); ?>
<label style=" top: 266px;left:154px;font-size:12px;font-weight:400;"><?php  echo $taxpayor_tin[0]; ?></label>
<label style=" top: 266px;left:220px;font-size:12px;font-weight:400;"><?php  echo $taxpayor_tin[1]; ?></label>
<label style=" top: 266px;left:290px;font-size:12px;font-weight:400;"><?php  echo $taxpayor_tin[2]; ?></label>
<label style=" top: 266px;left:360px;font-size:12px;font-weight:400;"><?php  echo $taxpayor_tin[3]; ?></label>
<!-- END TAX PAYOR -->


<?php  $month = $form->date_month;

    
if($month == '01' || $month == '04' ||$month == '07' ||$month == '10'){ ?>


<label style="text-align:right; top: 412px;left:288px; font-size:10px;font-weight:400; width: 85px;"><?php echo number_format($form->gross_amount,2); ?></label>
<label  style="text-align:right; top: 445px;left:288px;font-size:10px;font-weight:700; width: 85px;"><b><?php echo number_format($form->gross_amount,2); ?></b></label>
<!-- Zero on 2nd Month -->
<label style="text-align:right; top: 412px;left:377px; font-size:10px;font-weight:400; width: 90px;">0.00</label>
<label  style="text-align:right; top: 445px;left:377px;font-size:10px;font-weight:700; width: 90px;height: 18px;"><b>0.00</b></label>
<!-- Zero on 3rd Month -->
<label style="text-align:right; top: 412px;left:468px;font-size:10px; font-weight:400; width: 90px;">0.00</label>
<label  style="text-align:right; top: 445px;left:468px;font-size:10px;font-weight:700; width: 90px;height: 18px;"><b>0.00</b></label>


<?php }else if($month == '02' || $month == '05' || $month == '08' || $month == '11'){ ?>


<label style="text-align:right; top: 412px;left:377px; font-size:10px;font-weight:400; width: 90px;"><?php echo number_format($form->gross_amount,2); ?></label>
<label  style="text-align:right; top: 445px;left:377px;font-size:10px;font-weight:700; width: 90px;height: 18px;"><b><?php echo number_format($form->gross_amount,2); ?></b></label>

<!-- Zero on 1st Month -->
<label style="text-align:right; top: 412px;left:288px; font-size:10px;font-weight:400; width: 85px;">0.00</label>
<label  style="text-align:right; top: 445px;left:288px;font-size:10px;font-weight:700; width: 85px;"><b>0.00</b></label>
<!-- Zero on 3rd Month -->
<label style="text-align:right; top: 412px;left:468px;font-size:10px; font-weight:400; width: 90px;">0.00</label>
<label  style="text-align:right; top: 445px;left:468px;font-size:10px;font-weight:700; width: 90px;height: 18px;"><b>0.00</b></label>


<?php } else if($month == '03' || $month == '06' || $month == '09' || $month == '12'){ ?>


<label style="text-align:right; top: 412px;left:468px;font-size:10px; font-weight:400; width: 90px;"><?php echo number_format($form->gross_amount,2); ?></label>
<label  style="text-align:right; top: 445px;left:468px;font-size:10px;font-weight:700; width: 90px;height: 18px;"><b><?php echo number_format($form->gross_amount,2); ?></b></label>

<!-- Zero on 1st Month -->
<label style="text-align:right; top: 412px;left:288px; font-size:10px;font-weight:400; width: 85px;">0.00</label>
<label  style="text-align:right; top: 445px;left:288px;font-size:10px;font-weight:700; width: 85px;"><b>0.00</b></label>

<!-- Zero on 2nd Month -->
<label style="text-align:right; top: 412px;left:377px; font-size:10px;font-weight:400; width: 90px;">0.00</label>
<label  style="text-align:right; top: 445px;left:377px;font-size:10px;font-weight:700; width: 90px;height: 18px;"><b>0.00</b></label>
<?php } ?>





<label style="text-align:right; top: 412px;left:562px; font-size:10px;font-weight:400; width: 90px;"><?php echo number_format($form->gross_amount,2); ?></label>
<label style="text-align:right; top: 445px;left:562px; font-size:10px;font-weight:700; width: 90px;"><b><?php echo number_format($form->gross_amount,2); ?></b></label>
<label style="text-align:right; top: 412px;left:660px;font-size:10px;font-weight:400; width: 135px;height: 18px;"><?php echo number_format($form->deducted_amount,2); ?></label>
<label style="text-align:right; top: 445px;left:660px; font-size:10px;font-weight:700; width: 135px;"><?php echo number_format($form->deducted_amount,2); ?></label>