<style type="text/css">
    span{
        position: absolute;
        z-index: 200;
        font-size: 11pt;
    }
    @page {
	  size: A4;
	  margin: default;
	  scale: 100%;
	}
</style>
<img src="../../assets/img/bir_forms/form_2551m_1.png" style="top: 0px; left: 0px; width: 100%;position: absolute;z-index: 100;">
<span style="top: 158px; left: 112px;letter-spacing: 6px;">12</span>
<span style="top: 158px; left: 142px;letter-spacing: 8px;"><?php echo $y; ?></span>

<span style="top: 158px; left: 298px;letter-spacing: 6px;"><?php echo $m; ?></span>
<span style="top: 158px; left: 328px;letter-spacing: 9px;"><?php echo $y; ?></span>

<span style="top: 207px; left: 68px;letter-spacing: 5px;"><?php echo $payor_tin_1;?></span>
<span style="top: 207px; left: 114px;letter-spacing: 5px;"><?php echo $payor_tin_2;?></span>
<span style="top: 207px; left: 159px;letter-spacing: 5px;"><?php echo $payor_tin_3;?></span>
<span style="top: 207px; left: 205px;letter-spacing: 5px;"><?php echo $payor_tin_4;?></span>

<span style="top: 207px; left: 312px;letter-spacing: 8px;"><?php echo $info->rdo_no;?></span>
<span style="top: 207px; left: 505px;width: 190px;max-width: 190px;"><?php echo $info->nature_of_business;?></span>

<span style="top: 244px; left: 50px;width: 480px;max-width: 480px;"><?php echo $info->payor_name;?></span>
<span style="top: 244px; left: 580px;letter-spacing: 10px;"><?php echo $info->telephone_no;?></span>

<span style="top: 278px; left: 50px;width: 480px;max-width: 480px;"><?php echo $info->payor_address;?></span>
<span style="top: 278px; left: 643px;letter-spacing: 7px;"><?php echo $info->zip_code;?></span>


<span style="top: 376px; left: 45px;width: 125px;max-width: 125px;font-size: 10pt;text-align: center;"><?php echo $info->industry_classification;?></span>
<span style="top: 376px; left: 195px;width: 63px;max-width: 63px;font-size: 10pt;text-align: center;"><?php echo $info->atc;?></span>

<span style="top: 376px; left: 285px;width: 150px;max-width: 150px;font-size: 10pt;text-align: center;text-align: right;"><?php echo $info->taxable_amount;?></span>
<span style="top: 376px; left: 465px;width: 50px;max-width: 50px;font-size: 10pt;text-align: center;"><?php echo number_format($info->tax_rate,0);?>%</span>

<span style="top: 376px; left: 535px;width: 155px;max-width: 155px;font-size: 10pt;text-align: center;text-align: right;"><?php echo $info->tax_due;?></span>

<span style="top: 505px; left: 535px;width: 155px;max-width: 155px;font-size: 10pt;text-align: center;text-align: right;"><?php echo $info->tax_due;?></span>


<!-- <img src="../../assets/img/bir_forms/form_2307_2nd_page.png" style="top: 1050px; left: 0px; width: 100%;position: absolute;z-index: 100;"> -->
<script type="text/javascript">
    window.print();
</script>
