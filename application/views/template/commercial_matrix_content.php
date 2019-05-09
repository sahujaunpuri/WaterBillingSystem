<!DOCTYPE html>
<html>
<head>
    <title>Commerical Rate Matrix</title>
    <style type="text/css">
        body {
            /*font-family: 'Calibri',sans-serif;*/
            /*font-size: 12px;*/
        }

        .align-right {
            text-align: right;
        }

        .align-left {
            text-align: left;
        }

        .data {
            border-bottom: 1px solid #404040;
        }

        .align-center {
            text-align: center;
        }

        .report-header {
            font-weight: bolder;
        }

    </style>
</head>
<body>
    <div class="">
    </div>
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




















