<?php

class Billing_connection_batch_model extends CORE_Model {
    protected  $table="service_connection_batch";
    protected  $pk_id="service_connection_batch_id";

    function __construct() {
        parent::__construct();
    }


	function get_journal_entries($service_connection_batch_id){
		$sql="
			SELECT main.* FROM(
			SELECT 
			(SELECT payment_from_customer_id FROM account_integration) as account_id,
			'' as memo,
			batch_total_deposit as dr_amount,
			0 as cr_amount
			FROM service_connection_batch 
			WHERE service_connection_batch_id = $service_connection_batch_id

			UNION ALL

			SELECT 
			(SELECT billing_security_deposit_account_id FROM account_integration) as account_id,
			'' as memo,
			0 as dr_amount,
			batch_total_deposit as cr_amount
			FROM service_connection_batch 
			WHERE service_connection_batch_id = $service_connection_batch_id			
			) main WHERE main.dr_amount > 0 or main.cr_amount > 0
			";

		return $this->db->query($sql)->result();
	}


}



?>