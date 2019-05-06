<?php

class Integration_hotel_model extends CORE_Model{

    protected  $table="hotel_items"; //table name
    protected  $pk_id="hotel_items_id"; //primary key id


    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

function cashier_list(){
$sql="SELECT distinct cashier FROM pos_quickie_integration_items";
        return $this->db->query($sql)->result();
}


function bar_sales_report_list($cashier=null,$from=null,$to){
$sql="SELECT *,
DATE_FORMAT(pos_quickie_integration_items.sales_date,'%m/%d/%Y')as sales_date FROM pos_quickie_integration_items 
WHERE is_posted = TRUE
".($cashier==null?"":" AND cashier='".$cashier."'")."

AND sales_date BETWEEN '".$from."' and '".$to."' 
ORDER BY sales_date ASC
";
        return $this->db->query($sql)->result();
}

function get_pos_entries_journal($item_id){


$sql="SELECT main.*,ac.account_title FROM (SELECT 
(SELECT  asset_cash from pos_quickie_integration) as account_id,
'' as memo,
cash_amount as dr_amount,
0 as cr_amount
FROM pos_quickie_integration_items
WHERE pos_quickie_integration_items_id = $item_id


UNION ALL

SELECT 
(SELECT  asset_check from pos_quickie_integration) as account_id,
'' as memo,
check_amount as dr_amount,
0 as cr_amount
FROM pos_quickie_integration_items
WHERE pos_quickie_integration_items_id = $item_id

UNION ALL

SELECT 
(SELECT  asset_card from pos_quickie_integration) as account_id,
'' as memo,
card_amount as dr_amount,
0 as cr_amount
FROM pos_quickie_integration_items
WHERE pos_quickie_integration_items_id = $item_id

UNION ALL

SELECT 
(SELECT  asset_gc from pos_quickie_integration) as account_id,
'' as memo,
gc_amount as dr_amount,
0 as cr_amount
FROM pos_quickie_integration_items
WHERE pos_quickie_integration_items_id = $item_id

UNION ALL

SELECT (SELECT income_sales from pos_quickie_integration) as account_id,
'' as memo,
0 as dr_amount,
(IFNULL(total,0)- IFNULL(tax_amount,0)) as cr_amount
from pos_quickie_integration_items
WHERE pos_quickie_integration_items_id = $item_id


UNION ALL

SELECT (SELECT tax from pos_quickie_integration) as account_id,
'' as memo,
0 as dr_amount,
tax_amount as cr_amount
from pos_quickie_integration_items
WHERE pos_quickie_integration_items_id = $item_id
) as main
 
LEFT JOIN account_titles ac ON ac.account_id = main.account_id

WHERE main.dr_amount > 0 OR main.cr_amount > 0";
        return $this->db->query($sql)->result();
}

function get_pos_list_front_end($sales_date){


$sql="

SELECT main.*,
CASE WHEN main.dr_amount = main.cr_amount THEN 1 ELSE 0 END as is_equal
FROM

(SELECT pii.pos_quickie_integration_items_id,
pii.sales_date,
pii.cashier,
pii.branch,
(IFNULL(pii.cash_amount,0) + IFNULL(pii.check_amount,0) + IFNULL(pii.card_amount,0) + IFNULL(pii.gc_amount,0)) dr_amount,
IFNULL(pii.total,0) as cr_amount,
ref_no  FROM pos_quickie_integration_items pii

WHERE  pii.is_posted = FALSE AND pii.sales_date <= '$sales_date') as main
";
        return $this->db->query($sql)->result();
}



function get_pos_list_balanced($sales_date){

$sql="
SELECT pos.*,x.* FROM pos_quickie_integration_items as pos

LEFT JOIN (SELECT main.*,
CASE WHEN main.dr_amount = main.cr_amount THEN 1 ELSE 0 END as is_equal
FROM

(SELECT pii.pos_quickie_integration_items_id,
pii.sales_date,
(IFNULL(pii.cash_amount,0) + IFNULL(pii.check_amount,0) + IFNULL(pii.card_amount,0) + IFNULL(pii.gc_amount,0)) dr_amount,
IFNULL(pii.total,0) as cr_amount,
ref_no  FROM pos_quickie_integration_items pii

WHERE  pii.is_posted = FALSE AND pii.sales_date <= '$sales_date') as main) as x
ON x.pos_quickie_integration_items_id = pos.pos_quickie_integration_items_id

WHERE pos.is_posted = FALSE AND x.sales_date <= '$sales_date'
" ;
       return $this->db->query($sql)->result();
}












function get_list_hotel_items($date,$department_id){
    $sql="SELECT hi.*,d.department_name,
    DATE_FORMAT(hi.sales_date,'%m/%d/%Y')as sales_date
    FROM hotel_items hi
    LEFT JOIN departments as d on d.department_id = hi.department_id
    WHERE hi.is_posted = FALSE AND hi.sales_date <='$date' AND hi.department_id = '$department_id'
    ORDER BY hi.hotel_items_id ASC
     ";

    return $this->db->query($sql)->result();
}

function adv_journal_entries($hotel_items_id,$department_id){
    $sql="
    SELECT main.* FROM
    (SELECT 
        (SELECT adv_cash_id from hotel_settings WHERE hotel_settings_id = $department_id) as account_id,
        '' as memo,
        adv_cash as dr_amount,
        0 as cr_amount
        FROM hotel_items
        WHERE hotel_items_id = $hotel_items_id

        UNION ALL

        SELECT 
        (SELECT adv_check_id from hotel_settings WHERE hotel_settings_id = $department_id) as account_id,
        '' as memo,
        adv_check as dr_amount,
        0 as cr_amount
        FROM hotel_items
        WHERE hotel_items_id = $hotel_items_id

        UNION ALL

        SELECT 
        (SELECT adv_card_id from hotel_settings WHERE hotel_settings_id = $department_id) as account_id,
        '' as memo,
        adv_card as dr_amount,
        0 as cr_amount
        FROM hotel_items
        WHERE hotel_items_id = $hotel_items_id

        UNION ALL

        SELECT 
        (SELECT adv_charge_id from hotel_settings WHERE hotel_settings_id = $department_id) as account_id,
        '' as memo,
        adv_charge as dr_amount,
        0 as cr_amount
        FROM hotel_items
        WHERE hotel_items_id = $hotel_items_id

        UNION ALL

        SELECT 
        (SELECT adv_bank_id from hotel_settings WHERE hotel_settings_id = $department_id) as account_id,
        '' as memo,
        adv_bank as dr_amount,
        0 as cr_amount
        FROM hotel_items
        WHERE hotel_items_id = $hotel_items_id

        UNION ALL

        SELECT 
        (SELECT adv_sales_id from hotel_settings WHERE hotel_settings_id = $department_id) as account_id,
        '' as memo,
        0 as dr_amount,
        advance_sales as cr_amount
        FROM hotel_items
        WHERE hotel_items_id = $hotel_items_id
    )  as main WHERE main.dr_amount > 0 OR main.cr_amount > 0
    ";

    return $this->db->query($sql)->result();
}


function cout_journal_entries($hotel_items_id,$department_id){
    $sql="
    SELECT main.* FROM
    (SELECT 
        (SELECT adv_sales_id from hotel_settings WHERE hotel_settings_id = $department_id) as account_id,
        '' as memo,
        advance_sales as dr_amount,
        0 as cr_amount
        FROM hotel_items
        WHERE hotel_items_id = $hotel_items_id


        UNION ALL

        SELECT 
        (SELECT room_sales_id from hotel_settings WHERE hotel_settings_id = $department_id) as account_id,
        '' as memo,
        0 as dr_amount,
        room_sales as cr_amount
        FROM hotel_items
        WHERE hotel_items_id = $hotel_items_id

        UNION ALL

        SELECT 
        (SELECT bar_sales_id from hotel_settings WHERE hotel_settings_id = $department_id) as account_id,
        '' as memo,
        0 as dr_amount,
        bar_sales as cr_amount
        FROM hotel_items
        WHERE hotel_items_id = $hotel_items_id

        UNION ALL

        SELECT 
        (SELECT other_sales_id from hotel_settings WHERE hotel_settings_id = $department_id) as account_id,
        '' as memo,
        0 as dr_amount,
        other_sales as cr_amount
        FROM hotel_items
        WHERE hotel_items_id = $hotel_items_id

    )  as main WHERE main.dr_amount > 0 OR main.cr_amount > 0
    ";

    return $this->db->query($sql)->result();
}


function rev_journal_entries($hotel_items_id,$department_id){
    $sql="
    SELECT main.* FROM
    (SELECT 
        (SELECT cash_id from hotel_settings WHERE hotel_settings_id = $department_id) as account_id,
        '' as memo,
        cash_amount as dr_amount,
        0 as cr_amount
        FROM hotel_items
        WHERE hotel_items_id = $hotel_items_id

        UNION ALL

        SELECT 
        (SELECT check_id from hotel_settings WHERE hotel_settings_id = $department_id) as account_id,
        '' as memo,
        check_amount as dr_amount,
        0 as cr_amount
        FROM hotel_items
        WHERE hotel_items_id = $hotel_items_id

        UNION ALL

        SELECT 
        (SELECT card_id from hotel_settings WHERE hotel_settings_id = $department_id) as account_id,
        '' as memo,
        card_amount as dr_amount,
        0 as cr_amount
        FROM hotel_items
        WHERE hotel_items_id = $hotel_items_id

        UNION ALL

        SELECT 
        (SELECT charge_id from hotel_settings WHERE hotel_settings_id = $department_id) as account_id,
        '' as memo,
        charge_amount  as dr_amount,
        0 as cr_amount
        FROM hotel_items
        WHERE hotel_items_id = $hotel_items_id

        UNION ALL

        SELECT 
        (SELECT bank_id from hotel_settings WHERE hotel_settings_id = $department_id) as account_id,
        '' as memo,
        bank_amount  as dr_amount,
        0 as cr_amount
        FROM hotel_items
        WHERE hotel_items_id = $hotel_items_id

        UNION ALL

        SELECT 
        (SELECT adv_cash_id from hotel_settings WHERE hotel_settings_id = $department_id) as account_id,
        '' as memo,
        0 as dr_amount,
        adv_cash  as cr_amount
        FROM hotel_items
        WHERE hotel_items_id = $hotel_items_id

        UNION ALL

        SELECT 
        (SELECT adv_check_id from hotel_settings WHERE hotel_settings_id = $department_id) as account_id,
        '' as memo,
        0 as dr_amount,
        adv_check
          as cr_amount
        FROM hotel_items
        WHERE hotel_items_id = $hotel_items_id


        UNION ALL

        SELECT 
        (SELECT adv_card_id from hotel_settings WHERE hotel_settings_id = $department_id) as account_id,
        '' as memo,
        0 as dr_amount,
        adv_card as cr_amount
        FROM hotel_items
        WHERE hotel_items_id = $hotel_items_id


        UNION ALL

        SELECT 
        (SELECT adv_charge_id from hotel_settings WHERE hotel_settings_id = $department_id) as account_id,
        '' as memo,
        0 as dr_amount,
        adv_charge as cr_amount
        FROM hotel_items
        WHERE hotel_items_id = $hotel_items_id

        UNION ALL

        SELECT 
        (SELECT adv_bank_id from hotel_settings WHERE hotel_settings_id = $department_id) as account_id,
        '' as memo,
        0 as dr_amount,
        adv_bank as cr_amount
        FROM hotel_items
        WHERE hotel_items_id = $hotel_items_id


    )  as main WHERE main.dr_amount > 0 OR main.cr_amount > 0
    ";

    return $this->db->query($sql)->result();
}



function str_journal_entries($hotel_items_id,$department_id){
    $sql="
    SELECT main.* FROM
    (SELECT 
        (SELECT cash_id from hotel_settings WHERE hotel_settings_id = $department_id) as account_id,
        '' as memo,
        cash_amount as dr_amount,
        0 as cr_amount
        FROM hotel_items
        WHERE hotel_items_id = $hotel_items_id

        UNION ALL

        SELECT 
        (SELECT check_id from hotel_settings WHERE hotel_settings_id = $department_id) as account_id,
        '' as memo,
        check_amount as dr_amount,
        0 as cr_amount
        FROM hotel_items
        WHERE hotel_items_id = $hotel_items_id

        UNION ALL

        SELECT 
        (SELECT card_id from hotel_settings WHERE hotel_settings_id = $department_id) as account_id,
        '' as memo,
        card_amount as dr_amount,
        0 as cr_amount
        FROM hotel_items
        WHERE hotel_items_id = $hotel_items_id

        UNION ALL

        SELECT 
        (SELECT charge_id from hotel_settings WHERE hotel_settings_id = $department_id) as account_id,
        '' as memo,
        charge_amount  as dr_amount,
        0 as cr_amount
        FROM hotel_items
        WHERE hotel_items_id = $hotel_items_id

        UNION ALL

        SELECT 
        (SELECT bank_id from hotel_settings WHERE hotel_settings_id = $department_id) as account_id,
        '' as memo,
        bank_amount  as dr_amount,
        0 as cr_amount
        FROM hotel_items
        WHERE hotel_items_id = $hotel_items_id

        UNION ALL


        SELECT 
        (SELECT room_sales_id from hotel_settings WHERE hotel_settings_id = $department_id) as account_id,
        '' as memo,
        0 as dr_amount,
        room_sales as cr_amount
        FROM hotel_items
        WHERE hotel_items_id = $hotel_items_id

        UNION ALL

        SELECT 
        (SELECT bar_sales_id from hotel_settings WHERE hotel_settings_id = $department_id) as account_id,
        '' as memo,
        0 as dr_amount,
        bar_sales as cr_amount
        FROM hotel_items
        WHERE hotel_items_id = $hotel_items_id

        UNION ALL

        SELECT 
        (SELECT other_sales_id from hotel_settings WHERE hotel_settings_id = $department_id) as account_id,
        '' as memo,
        0 as dr_amount,
        other_sales as cr_amount
        FROM hotel_items
        WHERE hotel_items_id = $hotel_items_id

    )  as main WHERE main.dr_amount > 0 OR main.cr_amount > 0
    ";

    return $this->db->query($sql)->result();
}

}


?>