<style type="text/css">
    span{
        position: absolute;
        z-index: 200;
        font-size: 11pt;
    }
    @page {
	  size: legal;
	  margin: default;
	  scale: 100%;
	}
</style>
<img src="../../assets/img/bir_forms/form_2551q.png" style="top: 0px; left: 0px; width: 100%;position: absolute;z-index: 100;">

<span style="top: 177px; left: 108px;letter-spacing: 6px;"><?php echo $m; ?></span>
<span style="top: 177px; left: 140px;letter-spacing: 9px;"><?php echo $y; ?></span>

<?php 
if ($q_info->quarterly == 1){?>
	<span style="top: 182px; left: 241px;font-family: Arial, Helvetica, sans-serif;">x</span>
<?php 
}else if($q_info->quarterly == 2){?>
	<span style="top: 182px; left: 285px;font-family: Arial, Helvetica, sans-serif;">x</span>
<?php
}else if($q_info->quarterly == 3){?>
	<span style="top: 182px; left: 332px;font-family: Arial, Helvetica, sans-serif;">x</span>
<?php
}else if($q_info->quarterly == 4){?>
	<span style="top: 182px; left: 377px;font-family: Arial, Helvetica, sans-serif;">x</span>
<?php
}?>

<span style="top: 235px; left: 55px;letter-spacing: 5px;"><?php echo $tin_1;?></span>
<span style="top: 235px; left: 104px;letter-spacing: 5px;"><?php echo $tin_2;?></span>
<span style="top: 235px; left: 154px;letter-spacing: 5px;"><?php echo $tin_3;?></span>
<span style="top: 235px; left: 204px;letter-spacing: 5px;"><?php echo $tin_4;?></span>

<span style="top: 235px; left: 319px;letter-spacing: 8px;"><?php echo $company->rdo_no;?></span>
<span style="top: 233px; left: 528px;width: 200px;max-width: 200px;"><?php echo $company->nature_of_business;?></span>

<span style="top: 278px; left: 40px;width: 520px;max-width: 520px;"><?php echo $company->registered_to;?></span>
<span style="top: 278px; left: 611px;letter-spacing: 11px;"><?php echo $company->telephone_no;?></span>

<span style="top: 318px; left: 40px;width: 520px;max-width: 520px;"><?php echo $company->registered_address;?></span>
<span style="top: 318px; left: 678px;letter-spacing: 8px;"><?php echo $company->zip_code;?></span>

<?php 
	$top = 424;
	foreach($m_info as $row){
?>
	<span style="top: <?php echo $top;?>px; left: 30px;width: 135px;max-width: 135px;font-size: 11pt;text-align: center;"><?php echo $row->industry_classification;?></span>
	<span style="top: <?php echo $top;?>px; left: 190px;width: 75px;max-width: 75px;font-size: 11pt;text-align: center;"><?php echo $row->atc;?></span>
	<span style="top: <?php echo $top;?>px; left: 298px;width: 150px;max-width: 150px;font-size: 11pt;text-align: right;"><?php echo $row->taxable_amount;?></span>
	<span style="top: <?php echo $top;?>px; left: 485px;width: 60px;max-width: 60px;font-size: 11pt;text-align: center;"><?php echo number_format($row->tax_rate,0);?>%</span>
	<span style="top: <?php echo $top;?>px; left: 579px;width: 150px;max-width: 150px;font-size: 11pt;text-align: right;letter-spacing: 1px;"><?php echo $row->tax_due;?></span>
<?php 
	$top = $top + 30;
}?>

<span style="top: 570px; left: 579px;width: 150px;max-width: 150px;font-size: 11pt;text-align: right;letter-spacing: 1px;"><?php echo $q_info->tax_due;?></span>

<script type="text/javascript">
    window.print();
</script>
