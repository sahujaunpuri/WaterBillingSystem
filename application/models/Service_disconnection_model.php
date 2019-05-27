<?php

class Service_disconnection_model extends CORE_Model {
    protected  $table="service_disconnection";
    protected  $pk_id="disconnection_id";

    function __construct() {
        parent::__construct();
    }

    function getList($disconnection_id=null,$customer_id=null,$status_id=null)
    {
        $query = $this->db->query("SELECT 
                    sd.*,
                    DATE_FORMAT(sd.service_date, '%m/%d/%Y') AS service_date,
                    DATE_FORMAT(sd.date_disconnection_date, '%m/%d/%Y') AS date_disconnection_date,
                    sd.service_no,
                    sc.account_no,
                    sc.meter_inventory_id,
                    sc.customer_id,
                    sc.address,
                    sc.receipt_name,
                    inv.serial_no,
                    customers.customer_name,
                    ct.contract_type_name,
                    rt.rate_type_name,
                    dr.reason_desc
                FROM
                    service_disconnection sd
                        LEFT JOIN
                    service_connection sc ON sc.connection_id = sd.connection_id
                        LEFT JOIN
                    customers ON customers.customer_id = sc.customer_id
                        LEFT JOIN 
                    meter_inventory inv ON inv.meter_inventory_id = sc.meter_inventory_id
                        LEFT JOIN
                    contract_types ct ON ct.contract_type_id = sc.contract_type_id
                        LEFT JOIN
                    rate_types rt ON rt.rate_type_id = sc.rate_type_id
                        LEFT JOIN
                    disconnection_reason dr ON dr.disconnection_reason_id = sd.disconnection_reason_id
                WHERE
                    sd.is_deleted = FALSE
                        AND sd.is_active = TRUE
                        ".($disconnection_id==null?"":" AND sd.disconnection_id=".$disconnection_id)."
                        ".($customer_id==null?"":" AND sc.customer_id=".$customer_id)."
                        ".($status_id==null?"":" AND sc.status_id=".$status_id)."
                     ORDER BY sd.disconnection_id ASC");
        return $query->result();
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
                END) as service_no,
                (CASE 
                    WHEN sc.status_id = 1
                        THEN sc.connection_id
                    ELSE 
                        (SELECT reconnection_id FROM service_reconnection WHERE reconnection_id = sc.current_id)
                END) as previous_id
            FROM
                service_connection sc
                LEFT JOIN meter_inventory inv ON inv.meter_inventory_id = sc.meter_inventory_id
                LEFT JOIN customers c ON c.customer_id = sc.customer_id
            WHERE
                (sc.status_id = 1 OR sc.status_id = 3)
                AND sc.is_deleted = FALSE
                AND sc.is_active = TRUE
                ".($customer_id==null?"":" AND sc.customer_id=".$customer_id)."");
        return $query->result();
    }

    function chck_disconnection($disconnection_id){
        $query=$this->db->query("SELECT 
                    sd.*
                FROM
                    service_disconnection sd
                        LEFT JOIN
                    service_reconnection sr ON sr.disconnection_id = sd.disconnection_id
                WHERE
                    sr.is_deleted = FALSE
                        AND sd.is_deleted = FALSE
                        AND sr.disconnection_id = $disconnection_id");
                        return $query->result();
    }

}
?>