<?php

class Other_charge_model extends CORE_Model
{
    protected $table = "other_charges";
    protected $pk_id = "other_charge_id";

    function __construct()
    {
        parent::__construct();
    }

	function accounts($customer_id=null){
	   $query = $this->db->query("SELECT 
	           sc.*,
	           c.customer_name,
	           inv.serial_no,
	           (CASE 
	               WHEN sc.status_id = 1
	                   THEN sc.service_no
	               ELSE 
	                   (SELECT reconnection_code FROM service_reconnection WHERE reconnection_id = sc.current_id)
	           END) as service_no
	       FROM
	           service_connection sc
	           LEFT JOIN meter_inventory inv ON inv.meter_inventory_id = sc.meter_inventory_id
	           LEFT JOIN customers c ON c.customer_id = sc.customer_id
	       WHERE
	           sc.status_id = 1 OR 3
	           AND sc.is_deleted = FALSE
	           AND sc.is_active = TRUE
	           ".($customer_id==null?"":" AND sc.customer_id=".$customer_id)."");
	   return $query->result();
	}



}


?>