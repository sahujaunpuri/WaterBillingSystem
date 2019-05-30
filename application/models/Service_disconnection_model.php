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


    function  get_disconnection_rate($id,$consumption){
                    $query = $this->db->query("SELECT 
                        z.*,
                        (CASE
                            WHEN z.is_fixed_amount = 1 THEN z.rate
                            ELSE ($consumption * z.rate)
                        END) AS amount_due,
                        (CASE
                            WHEN z.is_fixed_amount = 1 THEN ((10 / 100) * z.rate)
                            ELSE ((10 / 100) * ($consumption * z.rate))
                        END) as penalty_amount
                    FROM
                        (SELECT 
                            x.*,
                                (CASE
                                    WHEN
                                        x.contract_type_id = 1
                                    THEN COALESCE((SELECT mtrx_ri.matrix_residential_amount FROM matrix_residential mtrx_r
                                        LEFT JOIN matrix_residential_items mtrx_ri ON mtrx_ri.matrix_residential_id = mtrx_r.matrix_residential_id
                                        WHERE mtrx_r.matrix_residential_id = default_matrix_id
                                            AND $consumption BETWEEN matrix_residential_from AND matrix_residential_to), 0)
                                    ELSE COALESCE((SELECT mtrx_ci.matrix_commercial_amount FROM matrix_commercial mtrx_c
                                        LEFT JOIN matrix_commercial_items mtrx_ci ON mtrx_ci.matrix_commercial_id = mtrx_c.matrix_commercial_id
                                        WHERE mtrx_c.matrix_commercial_id = default_matrix_id
                                            AND $consumption BETWEEN matrix_commercial_from AND matrix_commercial_to), 0)
                                END) AS rate,
                                (CASE
                                    WHEN
                                        x.contract_type_id = 1
                                    THEN COALESCE((SELECT mtrx_ri.is_fixed_amount FROM matrix_residential mtrx_r
                                        LEFT JOIN matrix_residential_items mtrx_ri ON mtrx_ri.matrix_residential_id = mtrx_r.matrix_residential_id
                                        WHERE mtrx_r.matrix_residential_id = default_matrix_id
                                            AND $consumption BETWEEN matrix_residential_from AND matrix_residential_to), 0)
                                    ELSE COALESCE((SELECT mtrx_ci.is_fixed_amount FROM matrix_commercial mtrx_c
                                        LEFT JOIN matrix_commercial_items mtrx_ci ON mtrx_ci.matrix_commercial_id = mtrx_c.matrix_commercial_id
                                        WHERE mtrx_c.matrix_commercial_id = default_matrix_id
                                            AND $consumption BETWEEN matrix_commercial_from AND matrix_commercial_to), 0)
                                END) AS is_fixed_amount
                        FROM
                            (SELECT 
                            sc.connection_id,
                                sc.contract_type_id, 
                                (CASE 
                                    WHEN sc.contract_type_id = 1
                                    THEN (SELECT default_matrix_residential_id FROM account_integration)
                                    ELSE (SELECT default_matrix_commercial_id FROM account_integration)
                                END) AS default_matrix_id
                        FROM
                             service_connection sc 
                        WHERE
                            sc.is_deleted = FALSE
                            AND sc.connection_id = ".$id.") AS x) AS z");

    return $query->result();
    }
}
?>