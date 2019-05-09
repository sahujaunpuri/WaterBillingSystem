<!DOCTYPE html>
<html>
<head>
    <title>Commerical Rate Matrix</title>
<style>
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

        .data {
      /*      border-bottom: 1px solid #404040;*/
        }

        .align-center {
            text-align: center;
        }

        .report-header {
            font-weight: bolder;
        }

        hr {
     /*       border-top: 3px solid #404040;*/
        }
.left {border-left: 1px solid black;}
.right{border-right: 1px solid black;}
.bottom{border-bottom: 1px solid black;}
.top{border-top: 1px solid black;}

.fifteen{ width: 15%; }
.text-center{text-align: center;}
.text-right{text-align: right;}
</style>
</head>
<body>
    <table width="100%" cellspacing="5" cellspacing="0">
        <tr>
            <td width="10%"  class="bottom"><img src="<?php echo base_url($company_info->logo_path); ?>" style="height: 90px; width: 120px; text-align: left;"></td>
            <td width="90%"  class="bottom" >
                <h1 class="report-header" style="margin-bottom: 0"><strong><?php echo $company_info->company_name; ?></strong></h1>
                <span><?php echo $company_info->company_address; ?></span><br>
                <span><?php echo $company_info->landline.'/'.$company_info->mobile_no; ?></span><br>
                <span><?php echo $company_info->email_address; ?></span><br>

            </td>
        </tr>
    </table>
    <h3 class="report-header"><strong>Commercial Rate Matrix</strong></h3>
    <table width="100%" border="0" cellspacing="-1">
        <tr>
            <td style="padding: 4px;" width="50%"><strong>Matrix Code: </strong> <?php echo $info[0]->matrix_commercial_code; ?></td>
            <td style="padding: 4px;" width="50%"></td>
        </tr>
        <tr>
            <td style="padding: 4px;" width="50%"><strong>Matrix Description: </strong> <?php echo $info[0]->description; ?></td>
            <td style="padding: 4px;" width="50%"></td>
        </tr>
        <tr>
            <td style="padding: 4px;" width="50%"><strong>Other Details: </strong> <?php echo $info[0]->other_details; ?></td>
            <td style="padding: 4px;" width="50%"></td>
        </tr>
    </table><br>
    <table width="100%" style="border-collapse: collapse;border-spacing: 0;font-family: tahoma;font-size: 11" border="0">
            <thead>
            <tr>
                <th width="10%" style="border: 1px solid gray;text-align: left;height: 30px;padding: 6px;">From</th>
                <th width="30%" style="border: 1px solid gray;text-align: left;height: 30px;padding: 6px;">To</th>
                <th width="30%" style="border: 1px solid gray;text-align: right;height: 30px;padding: 6px;">Rate Amount</th>
                <th width="15%" style="border: 1px solid gray;text-align: left;height: 30px;padding: 6px;">Is Fixed Amount?</th>
            </tr>
            </thead>
            <tbody>
            <?php

            $dr_amount=0.00; $cr_amount=0.00;

            foreach($items as $item){

                ?>
                <tr>
                    <td width="15%" style="border: 1px solid gray;text-align: left;height: 30px;padding: 6px;"><?php echo number_format($item->matrix_commercial_from,0); ?></td>
                    <td width="15%" style="border: 1px solid gray;text-align: left;height: 30px;padding: 6px;"><?php echo number_format($item->matrix_commercial_to,0); ?></td>
                    <td width="15%" style="border: 1px solid gray;text-align: right;height: 30px;padding: 6px;"><?php echo number_format($item->matrix_commercial_amount,2); ?></td>
                    <td width="15%" style="border: 1px solid gray;text-align: left;height: 30px;padding: 6px;"><?php if($item->is_fixed_amount =='1'){ echo 'Yes'; } else{ echo 'No';} ; ?></td>

                </tr>
                <?php

            }

            ?>

            </tbody> 
        </table>
</body>
</html>




















