<?php

class Billing_model extends CORE_Model{

    protected  $table="billing"; //table name
    protected  $pk_id="billing_id"; //primary key id


    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function get_customer_billing_receivables($type_id){
    	$sql = "SELECT
    				main.*
    			FROM
    		(SELECT 
    			service_connection.customer_id,
    			service_connection.connection_id,
			    service_connection.account_no,
			    service_connection.customer_name,
			    service_connection.address,
			    (COALESCE(billing.billing_fee, 0) + COALESCE(disconnection.disconnection_fee, 0)) as fee,
			    COALESCE(payment.payment_fee, 0) AS payment,
			    ((COALESCE(billing.billing_fee, 0) + COALESCE(disconnection.disconnection_fee, 0)) - COALESCE(payment.payment_fee, 0)) AS balance
			FROM
			    (SELECT 
			        c.customer_id,
			            sc.connection_id,
			            sc.account_no,
			            sc.address,
			            c.customer_name
			    FROM
			        service_connection sc
			    LEFT JOIN customers c ON c.customer_id = sc.customer_id) AS service_connection
			        LEFT JOIN
			    (SELECT 
			        sc.customer_id,
			            sc.connection_id,
			            COALESCE(SUM(b.grand_total_amount), 0) AS billing_fee
			    FROM
			        billing b
			    LEFT JOIN meter_reading_period mrp ON mrp.meter_reading_period_id = b.meter_reading_period_id
			    LEFT JOIN months m ON m.month_id = mrp.month_id
			    LEFT JOIN service_connection sc ON sc.connection_id = b.connection_id
			    LEFT JOIN customers c ON c.customer_id = sc.customer_id
			    ".($type_id==1?" GROUP BY sc.connection_id ":" GROUP BY sc.customer_id ")." ) AS billing 
			    ".($type_id==1?" ON service_connection.connection_id = billing.connection_id":" ON service_connection.customer_id = billing.customer_id")."

			        LEFT JOIN
			    (SELECT 
			        sc.customer_id,
			            sc.connection_id,
			            COALESCE(SUM(sd.grand_total_amount), 0) AS disconnection_fee
			    FROM
			        service_disconnection sd
			    LEFT JOIN service_connection sc ON sc.connection_id = sd.connection_id
			    LEFT JOIN customers c ON c.customer_id = sc.customer_id
			    WHERE
			        sd.is_active = TRUE
			            AND sd.is_deleted = FALSE
			    ".($type_id==1?" GROUP BY sc.connection_id":" GROUP BY sc.customer_id").") AS disconnection 
			    ".($type_id==1?" ON billing.connection_id = disconnection.connection_id":" ON billing.customer_id = disconnection.customer_id")."

			        LEFT JOIN
			    (SELECT 
			        sc.customer_id,
			            sc.connection_id,
			            SUM(bp.total_paid_amount) AS payment_fee
			    FROM
			        billing_payments bp
			    LEFT JOIN service_connection sc ON sc.connection_id = bp.connection_id
			    LEFT JOIN customers c ON c.customer_id = sc.customer_id
			    WHERE
			        bp.is_active = TRUE
			            AND bp.is_deleted = FALSE
			    ".($type_id==1?" GROUP BY sc.connection_id":" GROUP BY sc.customer_id").") AS payment 
			    ".($type_id==1?" ON billing.connection_id = payment.connection_id":" ON billing.customer_id = payment.customer_id")."
				".($type_id==1?" GROUP BY service_connection.connection_id":" GROUP BY service_connection.customer_id").") main
				WHERE main.balance > 0";
    	return $this->db->query($sql)->result();
    }

    function get_customer_billing_subsidiary($connection_id,$startDate,$endDate){
    	$this->db->query("SET @balance:=0.00;");
    	$sql="SELECT 
				    main.*,
				    CONVERT( (@balance:=@balance + (main.fee - main.payment)) , DECIMAL (20 , 2 )) AS balance
				FROM
				    (SELECT 
				        b.control_no AS ref_no,
				        CONCAT('Billing Statement (','',m.month_name,' ',mrp.meter_reading_year,')') as transaction,
				            DATE_FORMAT(b.date_processed, '%m/%d/%Y') AS date_txn,
				            b.grand_total_amount AS fee,
				            0 AS payment
				    FROM
				        billing b
				        LEFT JOIN meter_reading_period mrp ON mrp.meter_reading_period_id = b.meter_reading_period_id
				        LEFT JOIN months m ON m.month_id = mrp.month_id
				    WHERE
				        b.connection_id = $connection_id
				            AND b.date_processed BETWEEN '$startDate' AND '$endDate' UNION ALL SELECT 
				        sd.disconnection_code AS ref_no,
				        'Service Disconnection' as transaction,
				            DATE_FORMAT(sd.service_date, '%m/%d/%Y') AS date_txn,
				            sd.grand_total_amount AS fee,
				            0 AS payment
				    FROM
				        service_disconnection sd
				    WHERE
				        sd.connection_id = $connection_id
				            AND sd.is_active = TRUE
				            AND sd.is_deleted = FALSE
				            AND sd.service_date BETWEEN '$startDate' AND '$endDate' UNION ALL SELECT 
				        bp.receipt_no AS ref_no,
				        'Payment' as transaction,
				            DATE_FORMAT(bp.date_paid, '%m/%d/%Y') AS date_txn,
				            0 AS fee,
				            bp.total_paid_amount AS payment
				    FROM
				        billing_payments bp
				    WHERE
				        bp.connection_id = $connection_id
				            AND bp.is_active = TRUE
				            AND bp.is_deleted = FALSE
				            AND bp.date_paid BETWEEN '$startDate' AND '$endDate' ) main
				ORDER BY main.date_txn ASC";
		return $this->db->query($sql)->result();
    }


    function billing_statement($period_id=null,$meter_reading_input_id=null,$customer_id=null,$billing_id=null){
    	$query = $this->db->query("SELECT 
    		billing.*,
			    sc.account_no,
			    sc.address,
			    ct.contract_type_name,
			    c.customer_name,
			    mi.serial_no,
			    mri.batch_no,
			    DATE_FORMAT(billing.due_date,'%m/%d/%Y') as due_date,
			    DATE_FORMAT(billing.reading_date,'%m/%d/%Y') as reading_date,
			    CONCAT((DATE_FORMAT(mrp.meter_reading_period_start,'%m/%d/%Y')),' - ',(DATE_FORMAT(mrp.meter_reading_period_end,'%m/%d/%Y'))) AS period_covered,
			    m.month_name,
			    (billing.amount_due + billing.penalty_amount) as total_amount_due,
			    (billing.grand_total_amount + billing.penalty_amount) as amount_after_due,
			    (billing.arrears_amount + billing.arrears_penalty_amount) as previous_balance,
			    (billing.amount_due + billing.arrears_amount + billing.arrears_penalty_amount ) as grand_total_amount_label_for_report # GRAND TOTAL AMOUNT WITH PREVIOUS BALANCE INCLUDED

			FROM
			    billing
			    	LEFT JOIN
			    meter_reading_input mri ON mri.meter_reading_input_id = billing.meter_reading_input_id
			        LEFT JOIN
			    service_connection sc ON sc.connection_id = billing.connection_id
			    	LEFT JOIN 
			    contract_types ct ON ct.contract_type_id = sc.contract_type_id
			        LEFT JOIN
			    customers c ON c.customer_id = sc.customer_id
			        LEFT JOIN
			    meter_inventory mi ON mi.meter_inventory_id = sc.meter_inventory_id
			    	LEFT JOIN
			    meter_reading_period mrp ON mrp.meter_reading_period_id = billing.meter_reading_period_id
			    	LEFT JOIN
			    months m ON m.month_id = mrp.month_id
			WHERE
			        ".($period_id==null?" billing.meter_reading_period_id = 0":" billing.meter_reading_period_id=".$period_id)."
			        ".($meter_reading_input_id==0?"":" AND billing.meter_reading_input_id=".$meter_reading_input_id)."
			        ".($customer_id==0?"":" AND sc.customer_id=".$customer_id)."
			        ".($billing_id==null?"":" AND billing.billing_id=".$billing_id).""); 
    	return $query->result();
    }

    function process_billing($meter_reading_input_id) {

    	foreach($meter_reading_input_id as $id){

    		$total_amount_due = 0;

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

    		$check_existing_billing_scharges = $this->db->query("SELECT bc.other_charge_id FROM
						    billing_charges bc WHERE bc.meter_reading_input_id=".$id);
    		$billing_charges = $check_existing_billing_scharges->result();

    		if ($check_existing_billing_scharges->num_rows() != 0){

    			// Update Processed Status of Other Charges
    			foreach($billing_charges as $bc){
	            	$update_charges = "UPDATE other_charges SET is_processed=0 WHERE other_charge_id=".$bc->other_charge_id;
	               	$this->db->query($update_charges);
    			}

    			// Delete current billing charges
    			foreach($billing_charges as $bc){
	                $other_charge_id = $bc->other_charge_id;
	                $this->db->where('other_charge_id', $other_charge_id);
	                $this->db->delete('billing_charges');
    			}
    		}

    		$meter_reading_input = $this->db->query("SELECT 
					    z.*,
					    (CASE
					        WHEN z.is_fixed_amount = 1 THEN z.rate
					        ELSE (z.total_consumption * z.rate)
					    END) AS amount_due,
					    (CASE
					        WHEN z.is_fixed_amount = 1 
					        	THEN ((10 / 100) * (z.rate))
					        ELSE ((10 / 100) * (z.total_consumption * z.rate))
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
					            MONTH(DATE_SUB(mrp.meter_reading_period_start, INTERVAL 1 MONTH)) as arrears_month_id,
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
    			$total_charges = 0;
    			// GET PREVIOUS BILLING (LATEST)
    			$get_previous_billing_id = $this->db->query("SELECT * FROM (SELECT 
											mrii.meter_reading_input_id,
											b.billing_id,
											mrii.connection_id,
											DATE_FORMAT(CONCAT(mrp.meter_reading_year,'-',mrp.month_id,'-01'), '%b %Y') as current_month,
											mri.meter_reading_period_id
											FROM meter_reading_input_items mrii

											LEFT JOIN meter_reading_input mri ON mri.meter_reading_input_id = mrii.meter_reading_input_id
											LEFT JOIN meter_reading_period mrp ON mrp.meter_reading_period_id = mri.meter_reading_period_id
											INNER JOIN billing b ON b.meter_reading_input_id = mrii.meter_reading_input_id AND b.connection_id= mrii.connection_id
											WHERE mrii.connection_id = ".$row->connection_id.") as main
											 WHERE main.current_month = '".$row->previous_month."'");
    			$previous_billing_info = $get_previous_billing_id->result();

    			$arrears_amount = 0;
    			$arrears_penalty_amount = 0;

    			if(count($previous_billing_info) > 0) { // CHECK IF THERE IS A PREVIOUS BILLING

    				// CHECK OF PREVIOUS IS PAID
					$check_previous_billing_if_paid = $this->db->query("SELECT 
						b.connection_id,
						b.due_date,
						b.control_no,
						CONCAT(m.month_name, ' ', mrp.meter_reading_year) as description,
						b.billing_id,
						0 as disconnection_id,
						b.grand_total_amount as receivable_amount,
						IFNULL(payment.paid_amount,0) as paid_amount,
						(IFNULL(b.grand_total_amount,0) - IFNULL(payment.paid_amount,0)) as amount_due,
						0 as payment_amount

						FROM billing b
						LEFT JOIN meter_reading_period mrp ON mrp.meter_reading_period_id = b.meter_reading_period_id
						LEFT JOIN months m ON m.month_id = mrp.month_id

						LEFT JOIN
						(SELECT 
						bpi.billing_id,
						bp.date_paid,
						SUM(bpi.payment_amount) as paid_amount

						FROM billing_payment_items bpi
						LEFT JOIN billing_payments bp on bp.billing_payment_id = bpi.billing_payment_id
						LEFT JOIN billing b ON b.billing_id = bpi.billing_id
						WHERE bp.is_active = TRUE AND bp.is_deleted = FALSE 
							AND bp.date_paid <= b.due_date
						GROUP BY bpi.billing_id) as payment ON payment.billing_id = b.billing_id
						WHERE b.billing_id  = ".$previous_billing_info[0]->billing_id."");
					$result_previous_payment = $check_previous_billing_if_paid->result()[0];

				if($result_previous_payment->amount_due > 0){
					$get_penalty_for_last_billing = $this->db->query("SELECT penalty_amount FROM billing WHERE billing_id = ".$previous_billing_info[0]->billing_id."")->result()[0];
					$arrears_penalty_amount = $get_penalty_for_last_billing->penalty_amount;
				}
						
				$arrears_amount_info = $this->db->query("SELECT SUM(IFNULL(main.amount_due,0)) as arrears_amount FROM(SELECT 
					b.connection_id,
					b.due_date,
					b.control_no,
					CONCAT(m.month_name, ' ', mrp.meter_reading_year) as description,
					b.billing_id,
					0 as disconnection_id,
					b.grand_total_amount as receivable_amount,
					IFNULL(payment.paid_amount,0) as paid_amount,
					(IFNULL(b.grand_total_amount,0) - IFNULL(payment.paid_amount,0)) as amount_due,
					0 as payment_amount

					FROM billing b
					LEFT JOIN meter_reading_period mrp ON mrp.meter_reading_period_id = b.meter_reading_period_id
					LEFT JOIN months m ON m.month_id = mrp.month_id

					LEFT JOIN
					(SELECT 
					bpi.billing_id,
					SUM(bpi.payment_amount) as paid_amount

					FROM billing_payment_items bpi
					LEFT JOIN billing_payments bp on bp.billing_payment_id = bpi.billing_payment_id
					WHERE bp.is_active = TRUE AND bp.is_deleted = FALSE
					

					GROUP BY bpi.billing_id) as payment ON payment.billing_id = b.billing_id

					 ".($row->connection_id==0?"":" WHERE b.connection_id=".$row->connection_id)." ) as main
					"); 
				$arrears_amount_result = $arrears_amount_info->result();
				$arrears_amount = $arrears_amount_result[0]->arrears_amount;

    			}
			
					// print_r($arrears_amount);


    		  $total_amount_due = $row->amount_due;
              $data[0] =
                 array(
                    'connection_id' => $row->connection_id,
                    'default_matrix_id' => $row->default_matrix_id,
                    'meter_reading_input_id' => $row->meter_reading_input_id,
                    'meter_reading_period_id' => $row->meter_reading_period_id,
                    'due_date' => date("Y-m-d",strtotime($row->due_date)),
                    'reading_date' => date('Y-m-d',strtotime($row->date_input)),
                    'previous_reading' => $row->previous_reading,
                    'previous_month' => $row->previous_month,
                    'current_reading' => $row->current_reading,
                    'total_consumption' => $row->total_consumption,
                    'amount_due' => $row->amount_due,
                    'arrears_amount' => $arrears_amount,
                    'arrears_month_id' => $row->arrears_month_id,
                    'rate_amount' => $row->rate,
                    'penalty_amount' => $row->penalty_amount,
                    'arrears_penalty_amount' => $arrears_penalty_amount,
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

               	$other_charges = $this->db->query("SELECT 
					    oc.other_charge_id,
					    oci.other_charge_item_id,
					    oci.charge_id,
					    oci.charge_unit_id,
					    oci.charge_amount,
					    oci.charge_qty,
					    oci.charge_line_total
					FROM
					    other_charges oc
					    LEFT JOIN other_charges_items oci ON oci.other_charge_id = oc.other_charge_id
					    WHERE 
							oc.is_deleted = FALSE
							AND oc.is_active = TRUE
					        AND oc.is_processed = FALSE
					        AND oc.connection_id =".$row->connection_id);
               	$charges = $other_charges->result();
               	$a=0;

               	foreach ($other_charges->result() as $oc) {
               	  $total_charges += $oc->charge_line_total;
	              $data_charges[0] =
	                 array(
	                    'billing_id' => $billing_id,
	                    'meter_reading_input_id' => $row->meter_reading_input_id,
	                    'other_charge_id' => $oc->other_charge_id,
	                    'other_charge_item_id' => $oc->other_charge_item_id,
	                    'charge_id' => $oc->charge_id,
	                    'charge_unit_id' => $oc->charge_unit_id,
	                    'charge_amount' => $oc->charge_amount,
	                    'charge_qty' => $oc->charge_qty,
	                    'charge_line_total' => $oc->charge_line_total
	                 );

	            	$this->db->insert_batch('billing_charges', $data_charges);     

		            $update_bc = "UPDATE other_charges SET is_processed=1 WHERE other_charge_id=".$oc->other_charge_id;
	               	$this->db->query($update_bc);

               		$a++;
               	}

               	$grand_total = $total_amount_due + $total_charges + $arrears_penalty_amount;
               	$update_amount = "UPDATE billing SET grand_total_amount=$grand_total, charges_amount=$total_charges WHERE billing_id=".$billing_id;
	            $this->db->query($update_amount);

				$i++;
    		}
    	}
    	return true;
    }



    function billing_receivables($connection_id=null){
    	$query = $this->db->query("SELECT main.* FROM(SELECT 
				b.connection_id,
				DATE_FORMAT(b.due_date, '%m/%d/%Y') AS due_date,
				b.control_no,
				CONCAT(m.month_name, ' ', mrp.meter_reading_year) as description,
				b.billing_id,
				0 as disconnection_id,
				b.grand_total_amount as receivable_amount,
				IFNULL(payment.paid_amount,0) as paid_amount,
				(IFNULL(b.grand_total_amount,0) - IFNULL(payment.paid_amount,0)) as amount_due,
				0 as payment_amount

				FROM billing b
				LEFT JOIN meter_reading_period mrp ON mrp.meter_reading_period_id = b.meter_reading_period_id
				LEFT JOIN months m ON m.month_id = mrp.month_id

				LEFT JOIN
				(SELECT 
				bpi.billing_id,
				(SUM(bpi.payment_amount) + SUM(bpi.deposit_payment)) as paid_amount

				FROM billing_payment_items bpi
				LEFT JOIN billing_payments bp on bp.billing_payment_id = bpi.billing_payment_id
				WHERE bp.is_active = TRUE AND bp.is_deleted = FALSE
				

				GROUP BY bpi.billing_id) as payment ON payment.billing_id = b.billing_id

				 ".($connection_id==0?"":" WHERE b.connection_id=".$connection_id)." 


				 UNION ALL

			    SELECT 
			    sd.connection_id,
			    '' as due_date,
			    sd.service_no as control_no,
			    'Service Disconnection' as description,
			    0 as billing_id,
			    sd.disconnection_id,
			    IFNULL(sd.grand_total_amount,0) as receivable_amount,
			    IFNULL(payment.paid_amount,0) as paid_amount,
			    (IFNULL(sd.grand_total_amount,0) -  IFNULL(payment.paid_amount,0)) as amount_due,
			    0 as payment_amount
			    FROM service_disconnection sd
			    LEFT JOIN
			    
			    (SELECT 
				bpi.disconnection_id,
				(SUM(bpi.payment_amount) + SUM(bpi.deposit_payment)) as paid_amount
				FROM billing_payment_items bpi
				LEFT JOIN billing_payments bp on bp.billing_payment_id = bpi.billing_payment_id
				WHERE bp.is_active = TRUE AND bp.is_deleted = FALSE AND bpi.billing_id = 0
				GROUP BY bpi.disconnection_id) as payment ON payment.disconnection_id= sd.disconnection_id
			    
			    WHERE sd.is_active = TRUE AND sd.is_deleted= FALSE
			    ".($connection_id==0?"":" AND sd.connection_id=".$connection_id)." 

				 ) as main


				 having main.amount_due > 0



"); 
    	return $query->result();
    }
}

?>