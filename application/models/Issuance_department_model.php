<?php

class Issuance_department_model extends CORE_Model
{
    protected $table = "issuance_department_info";
    protected $pk_id = "issuance_department_id";

    function __construct()
    {
        parent::__construct();
    }

    function get_journal_entries_2($issuance_id){
        $sql="SELECT 
        main.* 
        FROM(

        SELECT 
		(SELECT pi.iss_debit_id FROM purchasing_integration pi) as account_id,
		SUM(IFNULL(iss.issue_non_tax_amount,0)) as dr_amount,
		0 as cr_amount,
		'' as memo
		FROM 
		issuance_items iss
		INNER JOIN products p ON p.product_id = iss.product_id
		WHERE iss.issuance_id = $issuance_id AND p.expense_account_id > 0
		GROUP BY iss.issuance_id

		UNION ALL

		SELECT p.expense_account_id as account_id,
		0 as dr_amount,
		SUM(IFNULL(iss.issue_non_tax_amount,0)) as cr_amount,
		'' as memo
		FROM 
		issuance_items iss
		INNER JOIN products p ON p.product_id = iss.product_id
		WHERE iss.issuance_id = $issuance_id AND p.expense_account_id > 0
		GROUP BY p.expense_account_id) as main 
		WHERE main.dr_amount > 0 OR main.cr_amount > 0";
        return $this->db->query($sql)->result();

    }

    function issuance_department_for_review(){
        $sql="SELECT main.* FROM
		(SELECT 
		idi.issuance_department_id,
		idi.trn_no,
		d.department_name  as department,
		idi.date_issued,
		idi.terms,
		idi.remarks,
		'From' as trn_type

		FROM issuance_department_info  idi
		LEFT JOIN departments d ON d.department_id = idi.from_department_id 
		WHERE idi.is_journal_posted_from = FALSE
		AND idi.is_active = TRUE
		AND idi.is_deleted = FALSE
		AND idi.is_closed_from = FALSE

		UNION ALL 

		SELECT 
		idi.issuance_department_id,
		idi.trn_no,
		d.department_name  as department,
		idi.date_issued,
		idi.terms,
		idi.remarks,
		'To' as trn_type

		FROM issuance_department_info idi
		LEFT JOIN departments d ON d.department_id = idi.to_department_id 
		WHERE idi.is_journal_posted_to = FALSE
		AND idi.is_active = TRUE
		AND idi.is_deleted = FALSE
		AND idi.is_closed_to = FALSE

		) as main
		ORDER BY main.issuance_department_id


		";
        return $this->db->query($sql)->result();



    }


	    function get_journal_entries_from($issuance_department_id){
	        $sql="SELECT 
	        main.* 
	        FROM(

	        SELECT 
			(SELECT pi.iss_debit_id FROM purchasing_integration pi) as account_id,
			SUM(IFNULL(iss.issue_non_tax_amount,0)) as dr_amount,
			0 as cr_amount,
			'' as memo
			FROM 
			issuance_department_items iss
			INNER JOIN products p ON p.product_id = iss.product_id
			WHERE iss.issuance_department_id = $issuance_department_id AND p.expense_account_id > 0
			GROUP BY iss.issuance_department_id

			UNION ALL

			SELECT p.expense_account_id as account_id,
			0 as dr_amount,
			SUM(IFNULL(iss.issue_non_tax_amount,0)) as cr_amount,
			'' as memo
			FROM 
			issuance_department_items iss
			INNER JOIN products p ON p.product_id = iss.product_id
			WHERE iss.issuance_department_id = $issuance_department_id AND p.expense_account_id > 0
			GROUP BY p.expense_account_id) as main 
			WHERE main.dr_amount > 0 OR main.cr_amount > 0";
	        return $this->db->query($sql)->result();

	    }

	    function get_journal_entries_to($issuance_department_id){
	        $sql="SELECT 
	        main.* 
	        FROM(
			SELECT p.expense_account_id as account_id,

			SUM(IFNULL(iss.issue_non_tax_amount,0)) as dr_amount,
			0 as cr_amount,
			'' as memo
			FROM 
			issuance_department_items iss
			INNER JOIN products p ON p.product_id = iss.product_id
			WHERE iss.issuance_department_id = $issuance_department_id AND p.expense_account_id > 0
			GROUP BY p.expense_account_id

			UNION ALL

			SELECT (SELECT pi.iss_debit_id FROM purchasing_integration pi) as account_id,
			0 as dr_amount,
			SUM(IFNULL(iss.issue_non_tax_amount,0)) as cr_amount,
			'' as memo
			FROM 
			issuance_department_items iss
			INNER JOIN products p ON p.product_id = iss.product_id
			WHERE iss.issuance_department_id = $issuance_department_id AND p.expense_account_id > 0
			GROUP BY iss.issuance_department_id
			) as main 
			WHERE main.dr_amount > 0 OR main.cr_amount > 0";
	        return $this->db->query($sql)->result();

	    }


}


?>