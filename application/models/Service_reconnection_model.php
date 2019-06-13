<?php

class Service_reconnection_model extends CORE_Model {
    protected  $table="service_reconnection";
    protected  $pk_id="reconnection_id";

    function __construct() {
        parent::__construct();
    }

    function getList($reconnection_id=null,$customer_id=null)
    {
        $query = $this->db->query("SELECT 
                    sr.*,
                    DATE_FORMAT(sr.service_date, '%m/%d/%Y') AS service_date,
                    DATE_FORMAT(sr.date_connection_target, '%m/%d/%Y') AS date_connection_target,
                    DATE_FORMAT(sd.date_disconnection_date, '%m/%d/%Y') AS date_disconnection_date,
                    sd.disconnection_code,
                    sd.connection_id,
                    sc.account_no,
                    sc.address,
                    sc.meter_inventory_id,
                    sc.receipt_name,
                    inv.serial_no,
                    c.customer_name,
                    sc.customer_id,
                    ct.contract_type_name,
                    cat.customer_account_type_desc,
                    rt.rate_type_name,
                    rrt.rate_type_name as new_rate_type
                FROM
                    service_reconnection sr
                        LEFT JOIN
                    service_disconnection sd ON sd.disconnection_id = sr.disconnection_id
                        LEFT JOIN
                    service_connection sc ON sc.connection_id = sd.connection_id
                        LEFT JOIN
                    meter_inventory inv ON inv.meter_inventory_id = sc.meter_inventory_id
                        LEFT JOIN
                    customers c ON c.customer_id = sc.customer_id
                        LEFT JOIN
                    customer_account_type cat ON cat.customer_account_type_id = c.customer_account_type_id
                        LEFT JOIN
                    contract_types ct ON ct.contract_type_id = sc.contract_type_id
                        LEFT JOIN
                    rate_types rt ON rt.rate_type_id = sc.rate_type_id
                        LEFT JOIN 
                    rate_types rrt ON rrt.rate_type_id = sr.rate_type_id
                WHERE
                    sr.is_deleted = FALSE
                        AND sr.is_active = TRUE
                        ".($reconnection_id==null?"":" AND sr.reconnection_id=".$reconnection_id)."
                        ".($customer_id==null?"":" AND sc.customer_id=".$customer_id)."
                     ORDER BY sr.reconnection_id ASC");
        return $query->result();
    }

    function getDisconnections($customer_id=null){
        $query = $this->db->query("SELECT 
                sc.*,
                DATE_FORMAT(sd.service_date, '%m/%d/%Y') AS service_date,
                DATE_FORMAT(sd.date_disconnection_date, '%m/%d/%Y') AS date_disconnection_date,
                sd.disconnection_code,
                sd.connection_id,
                sd.disconnection_id,
                sc.account_no,
                sc.meter_inventory_id,
                c.customer_name,
                sc.customer_id,
                inv.serial_no,
                ct.contract_type_name,
                rt.rate_type_name
            FROM
                service_connection sc
                    LEFT JOIN
                service_disconnection sd ON sd.disconnection_id = sc.current_id
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
                    AND sc.status_id = 2
                    ".($customer_id==null?"":" AND sc.customer_id=".$customer_id)."");
                    return $query->result();
    }

    function chck_reconnection($reconnection_id=null){
        $query = $this->db->query("SELECT sd.*
                    FROM
                        service_disconnection sd 
                        WHERE 
                        sd.is_deleted = FALSE
                        AND sd.previous_status_id = 3
                        AND sd.previous_id = $reconnection_id");
                            return $query->result();
    }    

}
?>