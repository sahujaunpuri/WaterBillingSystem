<?php

class Billing_model extends CORE_Model{

    protected  $table="billing"; //table name
    protected  $pk_id="billing_id"; //primary key id


    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function billing_statement($period_id=null,$meter_reading_input_id=null,$customer_id=null){
    	$query = $this->db->query("SELECT 
			    sc.account_no,
			    c.customer_name,
			    mi.serial_no,
			    billing.billing_id,
			    billing.previous_month,
			    billing.previous_reading,
			    billing.current_reading,
			    billing.total_consumption,
			    billing.amount_due
			FROM
			    billing
			        LEFT JOIN
			    service_connection sc ON sc.connection_id = billing.connection_id
			        LEFT JOIN
			    customers c ON c.customer_id = sc.customer_id
			        LEFT JOIN
			    meter_inventory mi ON mi.meter_inventory_id = sc.meter_inventory_id
			WHERE
			        ".($period_id==null?" billing.meter_reading_period_id = 0":" billing.meter_reading_period_id=".$period_id)."
			        ".($meter_reading_input_id==0?"":" AND billing.meter_reading_input_id=".$meter_reading_input_id)."
			        ".($customer_id==0?"":" AND sc.customer_id=".$customer_id).""); 
    	return $query->result();
    }

    function process_billing($meter_reading_input_id) {

    	foreach($meter_reading_input_id as $id){

    		// Check if billing is existing
    		$check_existing_billing = $this->db->query("SELECT * FROM billing WHERE meter_reading_input_id =".$id);
            $billing = $check_existing_billing->result();
            $exist = 0;

            //deleting current billing based on id
            if ($check_existing_billing->num_rows() != 0) {
                $exist = 1;
                $input_id = $billing[0]->meter_reading_input_id;
                $this->db->where('meter_reading_input_id', $input_id);
                $this->db->delete('billing');
            }

    		$check_existing_billing = $this->db->query("SELECT * FROM meter_reading_input WHERE meter_reading_input_id =".$id);

    		$meter_reading_input = $this->db->query("SELECT 
					    z.*,
					    (CASE
					        WHEN z.is_fixed_amount = 1 THEN z.rate
					        ELSE (z.total_consumption * z.rate)
					    END) AS amount_due,
					    ((10 / 100) * (z.total_consumption * z.rate)) as penalty_amount
					FROM
					    (SELECT 
					        x.*,
					            (CASE
					                WHEN
					                    x.contract_type_id = 1
					                THEN COALESCE((SELECT mtrx_ri.matrix_residential_amount FROM matrix_residential mtrx_r
				                        LEFT JOIN matrix_residential_items mtrx_ri ON mtrx_ri.matrix_residential_id = mtrx_r.matrix_residential_id
				                        WHERE mtrx_r.matrix_residential_id = default_matrix_id
				                            AND x.total_consumption BETWEEN matrix_residential_from AND matrix_residential_to), 0)
					                ELSE COALESCE((SELECT mtrx_ci.matrix_commercial_amount FROM matrix_commercial mtrx_c
					                    LEFT JOIN matrix_commercial_items mtrx_ci ON mtrx_ci.matrix_commercial_id = mtrx_c.matrix_commercial_id
					                    WHERE mtrx_c.matrix_commercial_id = default_matrix_id
					                        AND x.total_consumption BETWEEN matrix_commercial_from AND matrix_commercial_to), 0)
					            END) AS rate,
					            (CASE
					                WHEN
					                    x.contract_type_id = 1
					                THEN COALESCE((SELECT mtrx_ri.is_fixed_amount FROM matrix_residential mtrx_r
				                        LEFT JOIN matrix_residential_items mtrx_ri ON mtrx_ri.matrix_residential_id = mtrx_r.matrix_residential_id
				                        WHERE mtrx_r.matrix_residential_id = default_matrix_id
				                            AND x.total_consumption BETWEEN matrix_residential_from AND matrix_residential_to), 0)
					                ELSE COALESCE((SELECT mtrx_ci.is_fixed_amount FROM matrix_commercial mtrx_c
					                    LEFT JOIN matrix_commercial_items mtrx_ci ON mtrx_ci.matrix_commercial_id = mtrx_c.matrix_commercial_id
					                    WHERE mtrx_c.matrix_commercial_id = default_matrix_id
					                        AND x.total_consumption BETWEEN matrix_commercial_from AND matrix_commercial_to), 0)
					            END) AS is_fixed_amount
					    FROM
					        (SELECT 
					        mrii.connection_id,
					            mrii.previous_reading,
					            mrii.current_reading,
					            mrii.total_consumption,
					            mrii.previous_month,
					            mri.meter_reading_input_id,
					            mri.meter_reading_period_id,
					            mri.date_input,
					            sc.contract_type_id, 
					            CONCAT(mrp.month_id,'/15/',mrp.meter_reading_year) as due_date,
					            (CASE 
					            	WHEN sc.contract_type_id = 1
					                THEN (SELECT default_matrix_residential_id FROM account_integration)
					                ELSE (SELECT default_matrix_commercial_id FROM account_integration)
					            END) AS default_matrix_id
					    FROM
					        meter_reading_input mri
					    LEFT JOIN meter_reading_input_items mrii ON mrii.meter_reading_input_id = mri.meter_reading_input_id
					    LEFT JOIN service_connection sc ON sc.connection_id = mrii.connection_id
					    LEFT JOIN meter_reading_period mrp ON mrp.meter_reading_period_id = mri.meter_reading_period_id
					    WHERE
					        mri.is_deleted = FALSE
					        AND mri.meter_reading_input_id = ".$id.") AS x) AS z");
    		$reading = $meter_reading_input->result();
    		$i=0;

    		foreach ($meter_reading_input->result() as $row) {

              $data[0] =
                 array(
                    'connection_id' => $row->connection_id,
                    'meter_reading_input_id' => $row->meter_reading_input_id,
                    'meter_reading_period_id' => $row->meter_reading_period_id,
                    'due_date' => date("Y-m-d",strtotime($row->due_date)),
                    'reading_date' => date('Y-m-d',strtotime($row->date_input)),
                    'previous_reading' => $row->previous_reading,
                    'previous_month' => $row->previous_month,
                    'current_reading' => $row->current_reading,
                    'total_consumption' => $row->total_consumption,
                    'amount_due' => $row->amount_due,
                    'rate_amount' => $row->rate,
                    'penalty_amount' => $row->penalty_amount,
                    'is_fixed' => $row->is_fixed_amount,
                    'date_processed' => date("Y-m-d"),
                    'processed_by' => $this->session->user_id
                 );

            	$this->db->insert_batch('billing', $data);
				
				$billing_id=$this->db->insert_id();
    		  	$control_no = str_pad($billing_id, 7, '0', STR_PAD_LEFT);

            	$update_billing = "UPDATE billing SET control_no='".$control_no."' WHERE billing_id=".$billing_id;
               	$this->db->query($update_billing);

            	$update = "UPDATE meter_reading_input SET is_processed=1 WHERE meter_reading_input_id=".$row->meter_reading_input_id;
               	$this->db->query($update);

				$i++;
    		}
    	}
    	return true;
    }

}

?>