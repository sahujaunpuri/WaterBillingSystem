<?php

class Adjustment_model extends CORE_Model
{
protected $table = "adjustment_info";
protected $pk_id = "adjustment_id";

function __construct()
{
parent::__construct();
}
// OUT ADJUSTMENT
 function get_journal_entries_2($adjustment_id){
        $sql="SELECT 
        main.* 
        FROM(

        SELECT
		(SELECT pi.adj_debit_id FROM purchasing_integration pi) as account_id,
		SUM(IFNULL(adj.adjust_non_tax_amount,0)) as dr_amount,
		0 as cr_amount,
		'' as memo

		FROM 
		adjustment_items adj 
		INNER JOIN products p ON p.product_id = adj.product_id
		WHERE adj.adjustment_id = $adjustment_id AND p.expense_account_id > 0
		GROUP BY adj.adjustment_id

		UNION ALL

		SELECT 
		p.expense_account_id as account_id,
		0 as dr_amount,
		SUM(IFNULL(adj.adjust_non_tax_amount,0)) as cr_amount,
		'' as memo

		FROM adjustment_items adj
		INNER JOIN products p ON p.product_id = adj.product_id
		WHERE adj.adjustment_id= $adjustment_id AND p.expense_account_id > 0
		GROUP BY p.expense_account_id) as main 
		WHERE main.dr_amount > 0 OR main.cr_amount > 0";
        return $this->db->query($sql)->result();

    }
// IN ADJUSTMENT
     function get_journal_entries_2_in($adjustment_id){
        $sql="SELECT 
        main.* 
        FROM(
		SELECT
		p.expense_account_id as account_id,
		SUM(IFNULL(adj.adjust_non_tax_amount,0)) as dr_amount,
		0 as cr_amount,
		
		'' as memo
		FROM adjustment_items adj
		INNER JOIN products p ON p.product_id = adj.product_id
		WHERE adj.adjustment_id= $adjustment_id AND p.expense_account_id > 0
		GROUP BY p.expense_account_id



		UNION ALL

        SELECT
		(SELECT pi.adj_credit_id FROM purchasing_integration pi) as account_id,
		0 as dr_amount,
		SUM(IFNULL(adj.adjust_non_tax_amount,0)) as cr_amount,
		
		'' as memo

		FROM 
		adjustment_items adj 
		INNER JOIN products p ON p.product_id = adj.product_id
		WHERE adj.adjustment_id = $adjustment_id AND p.expense_account_id > 0
		GROUP BY adj.adjustment_id

		) as main 
		WHERE main.dr_amount > 0 OR main.cr_amount > 0";

        return $this->db->query($sql)->result();



    }


     function get_adjustments_for_review(){
        $sql='SELECT main.*

			FROM(SELECT 
			ai.adjustment_id,
			ai.adjustment_code,
			ai.remarks,
			ai.adjustment_type,
			ai.date_created,
			DATE_FORMAT(ai.date_adjusted,"%m/%d/%Y") as date_adjusted,
			d.department_id,
			d.department_name

			FROM adjustment_info ai
			LEFT JOIN departments d ON d.department_id = ai.department_id

			WHERE
			ai.is_active=TRUE AND
			ai.is_deleted=FALSE AND 
			is_journal_posted=FALSE
			AND ai.adjustment_type = "IN"
			AND ai.is_closed = FALSE

			UNION ALL

			SELECT 

			ai.adjustment_id,
			ai.adjustment_code,
			ai.remarks,
			ai.adjustment_type,
			ai.date_created,
			DATE_FORMAT(ai.date_adjusted,"%m/%d/%Y") as date_adjusted,
			d.department_id,
			d.department_name

			FROM adjustment_info ai
			LEFT JOIN departments d ON d.department_id = ai.department_id

			WHERE
			ai.is_active=TRUE AND
			ai.is_deleted=FALSE AND 
			is_journal_posted=FALSE
			AND ai.adjustment_type = "OUT"
			AND ai.is_closed = FALSE) as main

			ORDER BY main.adjustment_id';
        return $this->db->query($sql)->result();



    }
}


?>