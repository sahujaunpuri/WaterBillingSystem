<?php

class Meter_reading_period_model extends CORE_Model {
    protected  $table="meter_reading_period";
    protected  $pk_id="meter_reading_period_id";

    function __construct() {
        parent::__construct();
    }

    function get_meter_reading_for_inputs(){
        $sql='SELECT
main.connection_id,
sc.account_no,
c.customer_name,
mi.serial_no,
main.current_reading as previous_reading,
main.applicable_month

 FROM (SELECT n.*

FROM
(SELECT 
connection_id,
applicable_month,
current_reading
 FROM 

(SELECT 
mrii.connection_id,
DATE(CONCAT(mrp.meter_reading_year,  "-", mrp.month_id, "-01")) as applicable_month,
mrii.current_reading

FROM meter_reading_input_items mrii 

LEFT JOIN meter_reading_input mri ON mri.meter_reading_input_id=mrii.meter_reading_input_id
LEFT JOIN meter_reading_period mrp ON mrp.meter_reading_period_id = mri.meter_reading_period_id
WHERE mrii.connection_id = 1 
AND mri.is_deleted = FALSE 
AND mri.is_active = TRUE

UNION ALL

SELECT 
scr.connection_id,
DATE(CONCAT(YEAR(scr.connection_date),  "-", MONTH(scr.connection_date), "-01")) as applicable_month,
scr.initial_meter_reading as current_reading
FROM service_connection scr
 
WHERE scr.is_active= TRUE AND scr.is_deleted = FALSE )
 as main
 
WHERE applicable_month < DATE("2019-08-01") 
ORDER BY connection_id ASC,applicable_month ASC)  as n

LEFT OUTER JOIN 

(SELECT 
connection_id,
applicable_month,
current_reading
 FROM 

(SELECT 
mrii.connection_id,
DATE(CONCAT(mrp.meter_reading_year,  "-", mrp.month_id, "-01")) as applicable_month,
mrii.current_reading

FROM meter_reading_input_items mrii 

LEFT JOIN meter_reading_input mri ON mri.meter_reading_input_id=mrii.meter_reading_input_id
LEFT JOIN meter_reading_period mrp ON mrp.meter_reading_period_id = mri.meter_reading_period_id
WHERE mrii.connection_id = 1 
AND mri.is_deleted = FALSE 
AND mri.is_active = TRUE

UNION ALL

SELECT 
scr.connection_id,
DATE(CONCAT(YEAR(scr.connection_date),  "-", MONTH(scr.connection_date), "-01")) as applicable_month,
scr.initial_meter_reading as current_reading
FROM service_connection scr
 
WHERE scr.is_active= TRUE AND scr.is_deleted = FALSE )
 as main
 
WHERE applicable_month < DATE("2019-08-01") 
ORDER BY connection_id ASC,applicable_month ASC) as o

on (n.connection_id = o.connection_id and n.applicable_month < o.applicable_month)

where o.connection_id is null
order by o.connection_id) as main

LEFT JOIN service_connection sc ON sc.connection_id = main.connection_id 
LEFT JOIN customers c ON c.customer_id = sc.customer_id
LEFT JOIN meter_inventory mi ON mi.meter_inventory_id = sc.meter_inventory_id';
        return $this->db->query($sql)->result();
    }


}
?>