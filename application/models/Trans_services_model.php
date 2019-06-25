<?php

class Trans_services_model extends CORE_Model {
    protected  $table="trans_services";
    protected  $pk_id="trans_id";

    function __construct() {
        parent::__construct();
    }

 function trail($trans_type_id=null,$trans_key_id=null,$startDate=null,$endDate=null,$user_id=null,$connection_id=null){
        $sql="

			SELECT 
                t.*,tk.trans_key_desc,tt.trans_type_desc,ua.user_fname,ua.user_lname,
                sc.service_no, sc.account_no, sc.receipt_name as customer_name, mi.serial_no
                FROM trans_services t 
			LEFT JOIN trans_key_services tk ON tk.trans_key_id = t.trans_key_id
			LEFT JOIN trans_type_services tt ON tt.trans_type_id = t.trans_type_id
			LEFT JOIN user_accounts ua ON ua.user_id = t.user_id
            LEFT JOIN service_connection sc ON sc.connection_id = t.connection_id
            LEFT JOIN customers c ON c.customer_id = sc.customer_id
            LEFT JOIN meter_inventory mi ON mi.meter_inventory_id = sc.meter_inventory_id

			WHERE CAST(t.trans_date as date)  BETWEEN '$startDate' AND '$endDate'

            ".($trans_type_id=="all"?"":" AND t.trans_type_id = '$trans_type_id'")."
            ".($trans_key_id=="all"?"":" AND t.trans_key_id = '$trans_key_id'")."
            ".($user_id=="all"?"":" AND t.user_id = '$user_id'")."
            ".($connection_id=="all"?"":" AND t.connection_id = '$connection_id'")."


            ORDER BY t.trans_id ASC
        ";
        return $this->db->query($sql)->result();

    }
}



?>