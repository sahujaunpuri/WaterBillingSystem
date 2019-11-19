<?php

class Billing_payment_batch_model extends CORE_Model {
    protected  $table="billing_payment_batch";
    protected  $pk_id="billing_payment_batch_id";

    function __construct() {
        parent::__construct();
    }


	function get_journal_entries($billing_payment_batch_id){
		$sql="
			SELECT main.* FROM(
			SELECT 
			(SELECT payment_from_customer_id FROM account_integration) as account_id,
			'Cash Payments' as memo,
			batch_total_paid_cash as dr_amount,
			0 as cr_amount
			FROM billing_payment_batch 

			WHERE billing_payment_batch_id = $billing_payment_batch_id
			UNION ALL
			SELECT
			(SELECT billing_security_deposit_account_id FROM account_integration) as account_id,
			'' as memo,
			(batch_total_deposit_refund + batch_total_paid_deposit) as dr_amount,
			0 as cr_amount
			FROM billing_payment_batch 

			WHERE billing_payment_batch_id = $billing_payment_batch_id

			UNION ALL 
			SELECT
			(SELECT payment_from_customer_id FROM account_integration) as account_id,
			'Check Payments' as memo,
			batch_total_paid_check  as dr_amount,
			0 as cr_amount
			 FROM billing_payment_batch
			WHERE billing_payment_batch_id = $billing_payment_batch_id

			UNION ALL 
			SELECT 
			(SELECT payment_from_customer_id FROM account_integration) as account_id,
			'Card Payments' as memo,
			batch_total_paid_card as dr_amount,
			0 as cr_amount
			FROM billing_payment_batch 
			WHERE billing_payment_batch_id = $billing_payment_batch_id


			UNION ALL
			SELECT
			(SELECT payment_from_customer_id FROM account_integration) as account_id,
			'' as memo,
			0 as dr_amount,
			batch_total_deposit_refund  as cr_amount FROM billing_payment_batch 
			WHERE billing_payment_batch_id = $billing_payment_batch_id


			UNION ALL

			SELECT
			(SELECT billing_penalty_account_id FROM account_integration) as account_id,
			'Billing Penalty' as memo,
			0 as dr_amount,
			@sumbilpenalty:=IFNULL(SUM(q.cur_penalty_payment),0) as cr_amount

			FROM  (SELECT p.*,
			@curpay:= p.cur_payment_amount,
			IF(@curpay >= p.current_charges, p.current_charges, @curpay) as cur_charges_payment,
			IF(@curpay >= p.current_charges, @curpay:=@curpay-p.current_charges, @curpay:=@curpay-@curpay)as after_cur_charges_payment,
			IF(@curpay >= p.current_meter_charges, p.current_meter_charges,@curpay) as cur_meter_payment,
			IF(@curpay >= p.current_meter_charges,@curpay:=@curpay- p.current_meter_charges, @curpay:=@curpay-@curpay)as after_cur_meter_payment,
			IF(@curpay >= p.current_penalty_charges, p.current_penalty_charges, @curpay)as cur_penalty_payment,
			IF(@curpay >= p.current_penalty_charges,@curpay:=@curpay-p.current_penalty_charges,  @curpay:=@curpay-@curpay) as after_cur_penalty_payment


			 FROM (SELECT 
			o.*,
			(o.charges_amount - o.prev_charges_payment) as current_charges,
			(o.amount_due -o.prev_meter_payment) as current_meter_charges,
			(o.billing_penalty - o.prev_penalty_payment) as current_penalty_charges FROM

			(SELECT 
			n.billing_id,
			n.amount_due,
			n.charges_amount,
			n.billing_penalty,
			n.cur_payment_amount,
			n.prev_payment_amount,
			n.prev_charges_payment,
			n.prev_meter_payment,
			n.prev_penalty_payment
			 FROM(
			SELECT main. *,
						@prevpay:=main.prev_payment_amount as prevprev,
						IF(@prevpay >= main.charges_amount, main.charges_amount, @prevpay) as prev_charges_payment,
                        IF(@prevpay >= main.charges_amount, @prevpay:=@prevpay-main.charges_amount, @prevpay:=@prevpay-@prevpay)as after_prev_charges_payment,
                        IF(@prevpay >= main.amount_due, main.amount_due,@prevpay) as prev_meter_payment,
						IF(@prevpay >= main.amount_due,@prevpay:=@prevpay- main.amount_due, @prevpay:=@prevpay-@prevpay)as after_prev_meter_payment,
                        IF(@prevpay >= main.billing_penalty, main.billing_penalty, @prevpay)as prev_penalty_payment,
						IF(@prevpay >= main.billing_penalty,@prevpay:=@prevpay-main.billing_penalty,  @prevpay:=@prevpay-@prevpay) as after_prev_penalty_payment
						FROM  (
                    
						SELECT 
							b.billing_id,
							IFNULL(payment.payment_amount,0) as cur_payment_amount,
                            IFNULL(prev_payment.payment_amount,0) as prev_payment_amount,
							b.amount_due,
							b.charges_amount,
							(CASE WHEN payment.date_paid IS NULL 
							## check if now is less than the due,
							THEN 
								(CASE WHEN DATE(NOW()) > b.due_date 
									THEN  # NO PAYMENT AND AFTER DUE DATE
										 b.penalty_amount #no payment with penalty 
									ELSE 0 #no payment without penalty 
								   
									END)
							ELSE # IF THERE IS PAYMENT
								(CASE WHEN DATE(payment.date_paid) > b.due_date # MAX DATE
									THEN # WITH PAYMENT AFTER DUE WITH PENALTY
										b.penalty_amount
									ELSE # WITH PAYMENT BEFORE DUE
										(CASE WHEN DATE(NOW()) > DATE(b.due_date)
										THEN #'with payment before due and current date after  due'
											(CASE WHEN payment.payment_amount >= b.amount_due
												THEN 0 # NO PENALTY
												ELSE b.penalty_amount #WITH PENALTY
												END)
										ELSE #with payment before due and current date before due without penalty
										0 
										END )
								END )
							END) as billing_penalty

						FROM
						billing b
						

                        
						INNER JOIN (SELECT bpi.billing_id,
						MAX(date_paid) as date_paid, 
						(SUM(payment_amount) + SUM(deposit_payment)) as payment_amount FROM billing_payment_items bpi
						LEFT JOIN billing_payments bp ON bp.billing_payment_id = bpi.billing_payment_id
						WHERE bp.is_active = TRUE AND bp.is_deleted= FALSE AND bp.billing_payment_batch_id = $billing_payment_batch_id AND bp.billing_payment_batch_id != 0
						GROUP BY bpi.billing_id) as payment ON payment.billing_id = b.billing_id
						
						LEFT JOIN (SELECT bpi.billing_id,
						MAX(date_paid) as date_paid, 
						(SUM(payment_amount) + SUM(deposit_payment)) as payment_amount FROM billing_payment_items bpi
						LEFT JOIN billing_payments bp ON bp.billing_payment_id = bpi.billing_payment_id
						WHERE bp.is_active = TRUE AND bp.is_deleted= FALSE AND bp.billing_payment_batch_id != $billing_payment_batch_id AND bp.billing_payment_batch_id != 0
						GROUP BY bpi.billing_id) as prev_payment ON prev_payment.billing_id = b.billing_id
                        
                        
						) as main
						GROUP BY main.billing_id) as n

                         ) as o) as p) as q
                         
						UNION ALL

						SELECT 
						(SELECT billing_penalty_account_id FROM account_integration) as account_id,
						'Disconnection Penalty' as memo,
						0 as dr_amount,
						@sumdispenalty:=IFNULL(SUM(q.cur_penalty_payment),0) as cr_amount


						 FROM  (SELECT p.*,
						@curpay:= p.cur_payment_amount,
						IF(@curpay >= p.current_charges, p.current_charges, @curpay) as cur_charges_payment,
						IF(@curpay >= p.current_charges, @curpay:=@curpay-p.current_charges, @curpay:=@curpay-@curpay)as after_cur_charges_payment,
						IF(@curpay >= p.current_meter_charges, p.current_meter_charges,@curpay) as cur_meter_payment,
						IF(@curpay >= p.current_meter_charges,@curpay:=@curpay- p.current_meter_charges, @curpay:=@curpay-@curpay)as after_cur_meter_payment,
						IF(@curpay >= p.current_penalty_charges, p.current_penalty_charges, @curpay)as cur_penalty_payment,
						IF(@curpay >= p.current_penalty_charges,@curpay:=@curpay-p.current_penalty_charges,  @curpay:=@curpay-@curpay) as after_cur_penalty_payment


						 FROM (SELECT 
						o.*,
						(o.charges_amount - o.prev_charges_payment) as current_charges,
						(o.meter_amount_due -o.prev_meter_payment) as current_meter_charges,
						(o.disconnection_penalty - o.prev_penalty_payment) as current_penalty_charges FROM

						(SELECT 
						n.disconnection_id,
						n.meter_amount_due,
						n.charges_amount,
						n.disconnection_penalty,
						n.cur_payment_amount,
						n.prev_payment_amount,
						n.prev_charges_payment,
						n.prev_meter_payment,
						n.prev_penalty_payment
						 FROM(
						SELECT main. *,
						@prevpay:=main.prev_payment_amount as prevprev,
						IF(@prevpay >= main.charges_amount, main.charges_amount, @prevpay) as prev_charges_payment,
						IF(@prevpay >= main.charges_amount, @prevpay:=@prevpay-main.charges_amount, @prevpay:=@prevpay-@prevpay)as after_prev_charges_payment,
						IF(@prevpay >= main.meter_amount_due, main.meter_amount_due,@prevpay) as prev_meter_payment,
						IF(@prevpay >= main.meter_amount_due,@prevpay:=@prevpay- main.meter_amount_due, @prevpay:=@prevpay-@prevpay)as after_prev_meter_payment,
						IF(@prevpay >= main.disconnection_penalty, main.disconnection_penalty, @prevpay)as prev_penalty_payment,
						IF(@prevpay >= main.disconnection_penalty,@prevpay:=@prevpay-main.disconnection_penalty,  @prevpay:=@prevpay-@prevpay) as after_prev_penalty_payment
						FROM  (

						SELECT 
							sd.disconnection_id,
							IFNULL(payment.payment_amount,0) as cur_payment_amount,
							IFNULL(prev_payment.payment_amount,0) as prev_payment_amount,
							sd.meter_amount_due,
							sd.charges_amount,
							(CASE WHEN payment.date_paid IS NULL 
							## check if now is less than the due,
							THEN 
								(CASE WHEN DATE(NOW()) > sd.due_date 
									THEN  # NO PAYMENT AND AFTER DUE DATE
										 sd.penalty_amount #no payment with penalty 
									ELSE 0 #no payment without penalty 
								   
									END)
							ELSE # IF THERE IS PAYMENT
								(CASE WHEN DATE(payment.date_paid) > sd.due_date # MAX DATE
									THEN # WITH PAYMENT AFTER DUE WITH PENALTY
										sd.penalty_amount
									ELSE # WITH PAYMENT BEFORE DUE
										(CASE WHEN DATE(NOW()) > DATE(sd.due_date)
										THEN #'with payment before due and current date after  due'
											(CASE WHEN payment.payment_amount >= sd.meter_amount_due
												THEN 0 # NO PENALTY
												ELSE sd.penalty_amount #WITH PENALTY
												END)
										ELSE #with payment before due and current date before due without penalty
										0 
										END )
								END )
							END) as disconnection_penalty

						FROM
						service_disconnection sd

						INNER JOIN (SELECT bpi.disconnection_id,
						MAX(date_paid) as date_paid, 
						(SUM(payment_amount) + SUM(deposit_payment)) as payment_amount FROM billing_payment_items bpi
						LEFT JOIN billing_payments bp ON bp.billing_payment_id = bpi.billing_payment_id
						WHERE bp.is_active = TRUE AND bp.is_deleted= FALSE AND bp.billing_payment_batch_id = $billing_payment_batch_id AND bp.billing_payment_batch_id != 0
						GROUP BY bpi.disconnection_id) as payment ON payment.disconnection_id = sd.disconnection_id

						LEFT JOIN (SELECT bpi.disconnection_id,
						MAX(date_paid) as date_paid, 
						(SUM(payment_amount) + SUM(deposit_payment)) as payment_amount FROM billing_payment_items bpi
						LEFT JOIN billing_payments bp ON bp.billing_payment_id = bpi.billing_payment_id
						WHERE bp.is_active = TRUE AND bp.is_deleted= FALSE AND bp.billing_payment_batch_id != $billing_payment_batch_id AND bp.billing_payment_batch_id != 0
						GROUP BY bpi.disconnection_id) as prev_payment ON prev_payment.disconnection_id = sd.disconnection_id


						) as main
						GROUP BY main.disconnection_id) as n

						 ) as o) as p) as q
                    

						UNION ALL
						SELECT
						(SELECT receivable_account_id FROM account_integration) as account_id,
						'' as memo,
						0 as dr_amount,
						(batch_total_paid_amount-@sumbilpenalty - @sumdispenalty)  as cr_amount FROM billing_payment_batch 
						WHERE billing_payment_batch_id = $billing_payment_batch_id

                    
			) main WHERE main.dr_amount > 0 or main.cr_amount > 0
			";

		return $this->db->query($sql)->result();
	}


}



?>