<?php

class Service_invoice_model extends CORE_Model
{
    protected $table = "service_invoice";
    protected $pk_id = "service_invoice_id";

    function __construct()
    {
        parent::__construct();
    }



 function get_journal_entries($service_invoice_id){
        $sql="SELECT main.* FROM(SELECT
            s.income_account_id as account_id,
            '' as memo,
            SUM(sii.service_line_total) as cr_amount,
            0 as dr_amount

            FROM `service_invoice_items` as sii
            INNER JOIN services as s ON sii.service_id=s.service_id
            WHERE sii.service_invoice_id=$service_invoice_id AND s.income_account_id>0
            GROUP BY s.income_account_id

            UNION ALL

			         SELECT acc_receivable.*
             FROM
            (SELECT 

            (SELECT receivable_account_id FROM account_integration) as account_id,
            '' as memo,
            0 cr_amount,
            si.total_amount_after_discount as dr_amount

            FROM service_invoice as si
            WHERE si.service_invoice_id=$service_invoice_id
            ) as acc_receivable GROUP BY acc_receivable.account_id
            
            UNION ALL
            
            SELECT acc_discount.*
             FROM
            (SELECT 

            (SELECT receivable_discount_account_id FROM account_integration) as account_id,
            '' as memo,
            0 cr_amount,
            si.total_overall_discount_amount as dr_amount

            FROM service_invoice as si
            WHERE si.service_invoice_id=$service_invoice_id
            ) as acc_discount GROUP BY acc_discount.account_id     


            ) as main WHERE main.dr_amount>0 OR main.cr_amount>0";


        return $this->db->query($sql)->result();

 }

    function get_journal_entries_2($service_invoice_id){


        $sql="SELECT main.* FROM
            (SELECT
            s.income_account_id as account_id,
            '' as memo,
            SUM(sii.service_line_total) cr_amount,
            0 as dr_amount

            FROM `service_invoice_items` as sii
            INNER JOIN services as s ON sii.service_id=s.service_id
            WHERE sii.service_invoice_id=$service_invoice_id AND s.income_account_id>0

            GROUP BY s.income_account_id
            
            UNION ALL
            
            SELECT acc_receivable.account_id,acc_receivable.memo,
            0 as cr_amount,SUM(acc_receivable.dr_amount) as dr_amount
             FROM
            (SELECT sii.service_id,

            (SELECT receivable_account_id FROM account_integration) as account_id
            ,
            '' as memo,
            0 cr_amount,
            SUM(sii.service_line_total_after_global) as dr_amount

            FROM `service_invoice_items` as sii
            INNER JOIN services as s ON sii.service_id=s.service_id
            WHERE sii.service_invoice_id=$service_invoice_id AND s.income_account_id>0
            ) as acc_receivable GROUP BY acc_receivable.account_id
            
            UNION ALL
            
            SELECT acc_receivable.account_id,acc_receivable.memo,
            0 as cr_amount, 
            (line_total - line_total_after_global) as dr_amount
             FROM
            (SELECT sii.service_id,

            (SELECT receivable_discount_account_id FROM account_integration) as account_id
            ,
            '' as memo,
            0 cr_amount,
            SUM(IFNULL(sii.service_line_total_after_global,0)) as line_total_after_global,
            SUM(IFNULL(sii.service_line_total,0)) as line_total

            FROM `service_invoice_items` as sii
            INNER JOIN services as s ON sii.service_id=s.service_id
            WHERE sii.service_invoice_id=$service_invoice_id AND s.income_account_id>0
            ) as acc_receivable GROUP BY acc_receivable.account_id
            
            )as main WHERE main.dr_amount>0 OR main.cr_amount>0";

        return $this->db->query($sql)->result();

    }

}


?>