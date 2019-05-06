<?php

class Issuance_model extends CORE_Model
{
    protected $table = "issuance_info";
    protected $pk_id = "issuance_id";

    function __construct()
    {
        parent::__construct();
    }
 // NOT IN USE
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



}


?>