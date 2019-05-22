<?php

class Service_connection_model extends CORE_Model{

    protected  $table="service_connection"; //table name
    protected  $pk_id="connection_id"; //primary key id

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function getList($connection_id=null){
    	$query = $this->db->query("SELECT 
		    sc.*,
		    inv.serial_no,
		    c.customer_name,
		    ct.contract_type_name,
		    rt.rate_type_name,
		    DATE_FORMAT(sc.connection_date, '%m/%d/%Y') AS connection_date,
		    DATE_FORMAT(sc.service_date, '%m/%d/%Y') AS service_date,
		    DATE_FORMAT(sc.target_date, '%m/%d/%Y') AS target_date
		FROM
		    service_connection sc
		        LEFT JOIN
		    meter_inventory inv ON inv.meter_inventory_id = sc.meter_inventory_id
		        LEFT JOIN
		    customers c ON c.customer_id = sc.customer_id
		        LEFT JOIN
		    contract_types ct ON ct.contract_type_id = sc.contract_type_id
		        LEFT JOIN
		    rate_types rt ON rt.rate_type_id = sc.rate_type_id
		WHERE
		    sc.is_deleted = FALSE
		        AND sc.is_active = TRUE
		        ".($connection_id==null?"":" AND sc.connection_id=".$connection_id)."");
    	return $query->result();
    }

    function chck_meter($meter_inventory_id=null,$connection_id=null)
    {
    	$query = $this->db->query("SELECT sc.connection_id,sc.meter_inventory_id,inv.serial_no 
    					FROM service_connection sc
    					LEFT JOIN meter_inventory inv ON inv.meter_inventory_id = sc.meter_inventory_id
    				WHERE 
    					sc.is_deleted = FALSE
    					".($meter_inventory_id==null?"":" AND sc.meter_inventory_id=".$meter_inventory_id)."
    					".($connection_id==null?"":" AND sc.connection_id=".$connection_id)."");
        return $query->result();
    }

    function chck_meter_reading($connection_id=null){
    	$query = $this->db->query("SELECT 
				    mri.*, sc.service_no
				FROM
				    meter_reading_input mri
				    LEFT JOIN meter_reading_input_items mrii ON mrii.meter_reading_input_id = mri.meter_reading_input_id
				    LEFT JOIN service_connection sc ON sc.connection_id = mrii.connection_id
				    WHERE mri.is_deleted = FALSE
				    AND mrii.connection_id = $connection_id");
    			return $query->result();
    }

    function chck_connection($connection_id=null){
    	$query = $this->db->query("SELECT sd.* FROM service_disconnection sd WHERE sd.is_deleted = FALSE AND sd.connection_id = $connection_id");
    	return $query->result();
    }    

}

?>