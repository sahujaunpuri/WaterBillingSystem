<?php

class Billing_payment_batch_model extends CORE_Model {
    protected  $table="billing_payment_batch";
    protected  $pk_id="billing_payment_batch_id";

    function __construct() {
        parent::__construct();
    }


	function get_journal_entries($billing_payment_batch_id){
		$sql="
			SELECT main.* FROM(
			SELECT 
			(SELECT payment_from_customer_id FROM account_integration) as account_id,
			'Cash Payments' as memo,
			batch_total_paid_cash as dr_amount,
			0 as cr_amount
			FROM billing_payment_batch 

			WHERE billing_payment_batch_id = $billing_payment_batch_id

			UNION ALL 
			SELECT
			(SELECT payment_from_customer_id FROM account_integration) as account_id,
			'Check Payments' as memo,
			batch_total_paid_check  as dr_amount,
			0 as cr_amount
			 FROM billing_payment_batch
			WHERE billing_payment_batch_id = $billing_payment_batch_id

			UNION ALL 
			SELECT 
			(SELECT payment_from_customer_id FROM account_integration) as account_id,
			'Card Payments' as memo,
			batch_total_paid_card as dr_amount,
			0 as cr_amount
			FROM billing_payment_batch 
			WHERE billing_payment_batch_id = $billing_payment_batch_id

			UNION ALL
			SELECT
			(SELECT receivable_account_id FROM account_integration) as account_id,
			'' as memo,
			0 as dr_amount,
			batch_total_paid_amount  as cr_amount FROM billing_payment_batch 
			WHERE billing_payment_batch_id = $billing_payment_batch_id

			) main WHERE main.dr_amount > 0 or main.cr_amount > 0
			";

		return $this->db->query($sql)->result();
	}


}



?>