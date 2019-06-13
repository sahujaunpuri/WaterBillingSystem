<?php

class Billing_payments_model extends CORE_Model{

    protected  $table="billing_payments"; //table name
    protected  $pk_id="billing_payment_id"; //primary key id


    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function get_account_with_allowable_deposit($connection_id){
    	$query = $this->db->query("SELECT 
			sc.connection_id, (IFNULL(sc.initial_meter_deposit,0)- IFNULL(o.total_deposit_used,0)) as allowable_deposit
			FROM service_connection sc 

			LEFT JOIN

			(SELECT n.connection_id, 
			(IFNULL(total_deposit,0)+IFNULL(total_refund,0)) as total_deposit_used  
			FROM
			(SELECT main.connection_id,
			IFNULL(main.total_deposit,0) as total_deposit,
			IFNULL(refund.total_refund,0) as total_refund FROM (SELECT bp.connection_id, SUM(bp.total_deposit_amount) as total_deposit FROM billing_payments bp
			WHERE is_active= TRUE AND is_deleted = FALSE
			GROUP BY bp.connection_id ) as main
			LEFT JOIN
			(SELECT bp.connection_id, SUM(bp.remaining_deposit) as total_refund FROM billing_payments bp 
			WHERE is_active= TRUE AND is_deleted = FALSE AND is_refund = TRUE
			GROUP BY bp.connection_id) as refund  On refund.connection_id = main.connection_id) as n ) as o ON o.connection_id = sc.connection_id


			WHERE sc.is_active = TRUE AND sc.is_deleted = FALSE AND sc.connection_id = $connection_id"); 
    	return $query->result();
    }

 }