<?php

class Meter_inventory_model extends CORE_Model{

    protected  $table="meter_inventory"; //table name
    protected  $pk_id="meter_inventory_id"; //primary key id


    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function getMeter($status_id, $customer_id)
    {
        $query = $this->db->query("SELECT inv.*, c.customer_name FROM meter_inventory inv
    					LEFT JOIN customers c ON c.customer_id = inv.customer_id WHERE inv.meter_status_id = $status_id
    					".($customer_id==null?"":" AND inv.customer_id = ".$customer_id)."");
        return $query->result();
    }

}

?>