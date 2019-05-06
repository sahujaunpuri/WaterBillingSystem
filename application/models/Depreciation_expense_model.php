<?php

class Depreciation_expense_model extends CORE_Model {
    protected  $table="depreciation_expense";
    protected  $pk_id="de_id";

    function __construct() {
        parent::__construct();
    }


function get_journal_entries($de_id){

$sql="SELECT main.* FROM(SELECT 
		(SELECT depreciation_expense_debit_id FROM account_integration) as account_id,
		'' as memo,
		de.de_expense_total as dr_amount,
		0 as cr_amount
		FROM depreciation_expense de
		WHERE de.de_id = $de_id

		UNION ALL

		SELECT 
		(SELECT depreciation_expense_credit_id FROM account_integration) as account_id,
		'' as memo,
		0 as dr_amount,
		de.de_expense_total as cr_amount
		FROM depreciation_expense de
		WHERE de.de_id = $de_id

	)as main WHERE main.dr_amount>0 OR main.cr_amount>0
";

      return $this->db->query($sql)->result();




}

}
?>