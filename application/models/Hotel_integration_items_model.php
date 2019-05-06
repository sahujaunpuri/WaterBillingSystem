<?php

class Hotel_integration_items_model extends CORE_Model{

    protected  $table="hotel_integration_items"; //table name
    protected  $pk_id="hotel_integration_items_id"; //primary key id


    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }



function get_hotel_entries_journal_cout($item_id){


$sql="SELECT main.*,ac.account_title FROM (
		SELECT 
		(SELECT  asset_cash from hotel_integration) as account_id,
		'' as memo,
		cash_amount as dr_amount,
		0 as cr_amount

		FROM hotel_integration_items
		WHERE hotel_integration_items_id = $item_id

	UNION ALL

		SELECT 
		(SELECT asset_check from hotel_integration) as account_id,
		'' as memo,
		check_amount as dr_amount,
		0 as cr_amount
		FROM hotel_integration_items
		WHERE hotel_integration_items_id = $item_id

	UNION ALL

		SELECT 
		(SELECT asset_card from hotel_integration) as account_id,
		'' as memo,
		card_amount as dr_amount,
		0 as cr_amount

		FROM hotel_integration_items
		WHERE hotel_integration_items_id = $item_id
			
	UNION ALL

		SELECT 
		(SELECT asset_charge from hotel_integration) as account_id,
		'' as memo,
		charge_amount as dr_amount,
		0 as cr_amount

		FROM hotel_integration_items
		WHERE hotel_integration_items_id = $item_id

	UNION ALL 

		SELECT (SELECT liability_apd from hotel_integration) as account_id,
		'' as memo,
		advance_amount as dr_amount,
		0 as cr_amount
		from hotel_integration_items
		WHERE hotel_integration_items_id = $item_id

	UNION ALL 

		SELECT (SELECT income_rs from hotel_integration) as account_id,
		'' as memo,
		0 as dr_amount,
		room_sales as cr_amount
		from hotel_integration_items
		WHERE hotel_integration_items_id = $item_id

	UNION ALL 

		SELECT (SELECT income_bs from hotel_integration) as account_id,
		'' as memo,
		0 as dr_amount,
		bar_sales as cr_amount
		from hotel_integration_items
		WHERE hotel_integration_items_id = $item_id


	UNION ALL 

		SELECT (SELECT income_os from hotel_integration) as account_id,
		'' as memo,
		0 as dr_amount,
		other_sales as cr_amount
		 from hotel_integration_items
		 WHERE hotel_integration_items_id = $item_id
 ) as main
 
LEFT JOIN account_titles ac ON ac.account_id = main.account_id

WHERE main.dr_amount > 0 OR main.cr_amount > 0
";
        return $this->db->query($sql)->result();
}

function get_hotel_list_front_end($sales_date){


$sql="
SELECT main.*,
CASE WHEN main.dr_amount = main.cr_amount THEN 1 ELSE 0 END as is_equal

 FROM (SELECT hii.hotel_integration_items_id,  CASE hii.ar_guest_id WHEN 0 THEN 'CHECKOUT ' ELSE 'CHECKOUT [AR]' END as customer_item_type,
CASE hii.ar_guest_id WHEN 0 THEN hii.guest_id ELSE hii.ar_guest_id END as customer_id,
CASE hii.ar_guest_id WHEN 0 THEN hii.guest_name ELSE hii.ar_guest_name END as customer_name,

CASE hii.item_type WHEN 'COUT' THEN (hii.cash_amount + hii.check_amount + hii.card_amount + hii.charge_amount + hii.advance_amount) ELSE 0  END as dr_amount,
CASE hii.item_type WHEN 'COUT' THEN (hii.room_sales + hii.bar_sales + hii.other_sales)  ELSE 0  END as cr_amount,

hii.ref_no,
hii.sales_date FROM hotel_integration_items hii
WHERE  hii.is_posted = FALSE AND hii.sales_date <= '$sales_date') as main


";
        return $this->db->query($sql)->result();
}


function get_hotel_list_balanced($sales_date){

$sql="
SELECT hot.*,x.* FROM hotel_integration_items as hot

LEFT JOIN (SELECT main.*,
CASE WHEN main.dr_amount = main.cr_amount THEN 1 ELSE 0 END as is_equal

FROM (SELECT hii.hotel_integration_items_id,  
CASE hii.item_type WHEN 'COUT' THEN
(hii.cash_amount + hii.check_amount + hii.card_amount + hii.charge_amount + hii.advance_amount) 
ELSE 0  END as dr_amount,
CASE hii.item_type WHEN 'COUT' THEN
(hii.room_sales + hii.bar_sales + hii.other_sales) 
ELSE 0  END as cr_amount FROM hotel_integration_items hii
WHERE  hii.is_posted = FALSE ) as main) as x
ON x.hotel_integration_items_id = hot.hotel_integration_items_id

WHERE hot.is_posted = FALSE AND sales_date <= '$sales_date'
" ;
       return $this->db->query($sql)->result();
}


}


?>