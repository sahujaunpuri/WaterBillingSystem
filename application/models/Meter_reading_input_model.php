<?php

class Meter_reading_input_model extends CORE_Model {
    protected  $table="meter_reading_input";
    protected  $pk_id="meter_reading_input_id";

    function __construct() {
        parent::__construct();
    }

	function meter_reading($period_id=null){
        $query = $this->db->query("SELECT 
			    mri.*,
			    mrp.*,
			    DATE_FORMAT(mri.date_input, '%m/%d/%Y') AS date_input,
			    m.month_name,
			    CONCAT_WS(' ', user.user_fname, user.user_lname) AS posted_by
			FROM
			    meter_reading_input mri
			        LEFT JOIN
			    meter_reading_period mrp ON mrp.meter_reading_period_id = mri.meter_reading_period_id
			        LEFT JOIN
			    months m ON m.month_id = mrp.month_id
			        LEFT JOIN
			    user_accounts user ON user.user_id = mri.posted_by_user
			WHERE
			    mri.is_deleted = FALSE
			        ".($period_id==null?" AND mri.meter_reading_period_id=0":" AND mri.meter_reading_period_id=".$period_id)."");
					return $query->result();
    }    

	function get_journal_entries($meter_reading_input_id){
        $query = $this->db->query("SELECT main.* FROM (SELECT 
			(SELECT receivable_account_id FROM account_integration) as account_id,
			'' as memo,
			SUM(IFNULL(grand_total_amount,0)) as dr_amount,
			0 as cr_amount
			 FROM  billing WHERE meter_reading_input_id = $meter_reading_input_id
			 
			UNION ALL 

			SELECT 
			(SELECT billing_meter_account_id FROM account_integration) as account_id,
			'' as memo,
			0 as dr_amount,
			SUM(IFNULL(amount_due,0)) as cr_amount FROM billing WHERE meter_reading_input_id = $meter_reading_input_id

			UNION ALL

			SELECT 
			(SELECT billing_penalty_account_id FROM account_integration) as account_id,
			'' as memo,
			0 as dr_amount,
			SUM(IFNULL(arrears_penalty_amount,0))  FROM billing WHERE meter_reading_input_id = $meter_reading_input_id

			UNION ALL
			SELECT charges.* FROM
			(SELECT 
			c.income_account_id as account_id,
			'' as memo,
			0 as dr_amount,
			SUM(IFNULL(charge_line_total,0)) as cr_amount
			FROM  billing_charges bc
			LEFT JOIN charges c on c.charge_id = bc.charge_id 
			WHERE meter_reading_input_id = '$meter_reading_input_id'

			GROUP BY c.income_account_id) as charges

			) as main WHERE main.dr_amount > 0 or main.cr_amount > 0
			");
					return $query->result();
    }    
}
?>