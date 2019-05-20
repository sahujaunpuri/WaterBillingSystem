<?php

class Meter_inventory_model extends CORE_Model{

    protected  $table="meter_inventory"; //table name
    protected  $pk_id="meter_inventory_id"; //primary key id


    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function getList($meter_status_id=null,$meter_inventory_id=null,$customer_id=null,$is_new=null)
    {
    	$query = $this->db->query("SELECT 
				    meter_inventory.*,
				    customers.customer_id,
				    customers.customer_name,
				    meter_status.status_name
				FROM
				    meter_inventory
				        LEFT JOIN
				    customers ON customers.customer_id = meter_inventory.customer_id
				        LEFT JOIN
				    meter_status ON meter_status.meter_status_id = meter_inventory.meter_status_id
				WHERE
				    meter_inventory.is_deleted = FALSE
				        AND meter_inventory.is_active = TRUE
				        ".($meter_status_id==null?"":" AND meter_inventory.meter_status_id=".$meter_status_id)."
				        ".($is_new==null?"":" AND meter_inventory.is_new=".$is_new)."
				        ".($meter_inventory_id==null?"":" AND meter_inventory.meter_inventory_id=".$meter_inventory_id)."
				        ".($customer_id==null?"":" AND meter_inventory.customer_id=".$customer_id)."
				     ORDER BY meter_inventory.meter_code ASC");
        return $query->result();
    }
}

?>