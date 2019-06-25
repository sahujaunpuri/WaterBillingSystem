<head>
    <title>Monthly Connection Report</title>
    <link rel="icon" href="<?php echo base_url('assets/img/companyico.ico'); ?>" type="image/ico" sizes="16x16">
</head>
<body>
<style>
    table{
        border:none!important;
        font-family: Calibri;
        font-size: 12px;
        border-collapse: collapse;
    }
    td{
        padding: 0px!important;
        margin: 0px!important; 
        padding: 3px;
    }
    th{
        border-bottom: 1px solid lightgray;
    }
</style>
<table width="100%" class="nohover" >
    <tr>
        <td  class="bottom-only" width="10%" style="object-fit: cover;"><img src="<?php echo $company_info->logo_path; ?>" style="height: 90px; width: 90px; text-align: left;"></td>
        <td class="bottom-only" width="90%" class="">
            <h1 class="report-header"><strong><?php echo $company_info->company_name; ?></strong></h1>
            <p><?php echo $company_info->company_address; ?></p>
            <p><?php echo $company_info->landline.'/'.$company_info->mobile_no; ?></p>
            <span><?php echo $company_info->email_address; ?></span><br>

        </td>
    </tr>
</table><hr>    
<h4>Monthly Connection</h4>
<table width="100%">
    <tr>
        <td>Month : <?php echo $month; ?></td>
        <td align="right">Date Printed : <?php echo date('m/d/Y h:i a');?></td>
    </tr>
    <tr>
        <td></td>
        <td align="right">Printed by: <?php echo $user; ?></td>
    </tr>
</table>
<br>
<table width="100%" cellspacing="5" cellpadding="5">
    <thead>
        <tr>
            <th align="left"><b>Service No</b></th>
            <th align="left"><b>Account No</b></th>
            <th align="left"><b>Customer</b></th>
            <th align="left"><b>Address</b></th>
            <th align="left"><b>Serial No</b></th>
            <th align="left"><b>Service Date</b></th>
            <th align="left"><b>Installation Date</b></th>
        </tr>  
    </thead>  
    <tbody>
        <?php 
            if(count($connections) > 0){
            foreach($connections as $connection){
            ?>
            <tr>
                <td><?php echo $connection->service_no; ?></td>
                <td><?php echo $connection->account_no; ?></td>
                <td><?php echo $connection->receipt_name; ?></td>
                <td><?php echo $connection->address; ?></td>
                <td><?php echo $connection->serial_no; ?></td>
                <td><?php echo $connection->service_date; ?></td>
                <td><?php echo $connection->installation_date; ?></td>
            </tr>
        <?php }
        }else{
            echo '<tr>';
            echo '<td colspan="7" style="border-top: 1px solid lightgray;">';        
            echo '<center>No Data Available</center>';
            echo '</td>';
            echo '</tr>';
        }?>        
    </tbody>   
</table>