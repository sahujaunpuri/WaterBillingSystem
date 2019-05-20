<?php

class Meter_reading_input_items_model extends CORE_Model {
    protected  $table="meter_reading_input_items";
    protected  $pk_id="meter_reading_input_item_id";
    protected  $fk_id="meter_reading_input_id";

    function __construct() {
        parent::__construct();
    }


    function validate_duplication($connection_id,$meter_reading_period_id,$meter_reading_input_id){
        $sql="SELECT 
			batch_no,
			account_no
			FROM
			meter_reading_input_items

			LEFT JOIN 
			meter_reading_input ON
			meter_reading_input.meter_reading_input_id = meter_reading_input_items.meter_reading_input_id
			LEFT JOIN
			service_connection ON
			service_connection.connection_id = meter_reading_input_items.connection_id
			WHERE 
			meter_reading_input_items.connection_id = $connection_id AND 
			meter_reading_input.meter_reading_period_id = $meter_reading_period_id AND 
			meter_reading_input.is_deleted = FALSE

            ".($meter_reading_input_id==0? " ":
                " AND meter_reading_input.meter_reading_input_id != $meter_reading_input_id"
            )."
            ";
        return $this->db->query($sql)->result();
    }
}
?>