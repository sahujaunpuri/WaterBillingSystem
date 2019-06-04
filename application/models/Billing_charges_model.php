<?php

class Billing_charges_model extends CORE_Model{

    protected  $table="billing_charges"; //table name
    protected  $pk_id="billing_charge_id"; //primary key id


    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function billing_charges($billing_id=null){
    	$query = $this->db->query("SELECT 
		    bc.*, c.charge_code, c.charge_desc, cu.charge_unit_name, oc.other_charge_no
		FROM
		    billing_charges bc
		        LEFT JOIN
		    billing b ON b.billing_id = bc.billing_id
		    	LEFT JOIN
			other_charges oc ON oc.other_charge_id = bc.other_charge_id
		        LEFT JOIN
		    charges c ON c.charge_id = bc.charge_id
		        LEFT JOIN
		    charge_unit cu ON cu.charge_unit_id = bc.charge_unit_id
			".($billing_id==null?"":" WHERE bc.billing_id=".$billing_id).""); 
    	return $query->result();
    } 
}

?>