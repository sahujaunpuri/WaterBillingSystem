<?php

class Dispatching_invoice_model extends CORE_Model
{
    protected $table = "dispatching_invoice";
    protected $pk_id = "dispatching_invoice_id";

    function __construct()
    {
        parent::__construct();
    }


	 function list_of_open(){
	    $sql='SELECT 
		1 as is_sales,
		si.sales_invoice_id as invoice_id,
		si.sales_inv_no as inv_no,
		si.address,
		si.contact_person,
		DATE_FORMAT(si.date_invoice,"%m/%d/%Y") as date_invoice,
		DATE_FORMAT(si.date_due,"%m/%d/%Y") as date_due,
		si.salesperson_id,
		si.customer_id,
		c.customer_name,
		si.department_id,
		d.department_name,
		order_status.order_status,
		si.remarks,
		si.customer_type_id

		FROM sales_invoice si
		LEFT JOIN customers as c ON c.customer_id = si.customer_id
		LEFT JOIN departments d ON d.department_id = si.department_id
		LEFT JOIN order_status ON order_status.order_status_id=si.order_status_id
		WHERE
		si.is_deleted=FALSE AND si.is_active=TRUE 

		UNION ALL

		SELECT 
		2 as is_sales,
		ci.cash_invoice_id as invoice_id,
		ci.cash_inv_no as inv_no,
		ci.address,
		ci.contact_person,
		DATE_FORMAT(ci.date_invoice,"%m/%d/%Y") as date_invoice,
		DATE_FORMAT(ci.date_due,"%m/%d/%Y") as date_due,
		ci.salesperson_id,
		ci.customer_id,
		c.customer_name,
		ci.department_id,
		d.department_name,
		order_status.order_status,
		ci.remarks,
		ci.customer_type_id

		FROM cash_invoice ci
		LEFT JOIN customers as c ON c.customer_id = ci.customer_id
		LEFT JOIN departments d ON d.department_id = ci.department_id
		LEFT JOIN order_status ON order_status.order_status_id=ci.order_status_id
		WHERE
		ci.is_deleted=FALSE AND ci.is_active=TRUE ';

	         return $this->db->query($sql)->result();
	    }

 function get_si_balance_qty($sales_invoice_id){
	    $sql="SELECT SUM(x.balance) as balance 
		FROM(SELECT 
		m.sales_invoice_id,
		m.sales_inv_no,
		m.product_id,
		SUM(m.InvQty) as InvQty,
		SUM(m.DIsQty) as DisQty,
		(SUM(m.InvQty)-SUM(m.DIsQty)) as Balance
		FROM 
		(SELECT 

		si.sales_invoice_id,
		si.sales_inv_no,
		sii.product_id,
		SUM(sii.inv_qty) as InvQty,
		0 as DisQty

		FROM 
		sales_invoice si 
		INNER JOIN sales_invoice_items sii ON sii.sales_invoice_id = si.sales_invoice_id
		WHERE si.sales_invoice_id = $sales_invoice_id
		AND si.is_active = TRUE
		AND si.is_deleted = FALSE
		GROUP BY si.sales_inv_no,sii.product_id

		UNION ALL

		SELECT 
		si.sales_invoice_id,
		si.sales_inv_no,
		dii.product_id,
		0 as InvQty,
		SUM(dii.inv_qty) as DisQty

		FROM
		dispatching_invoice di

		INNER JOIN sales_invoice si ON si.sales_invoice_id = di.sales_invoice_id
		INNER JOIN dispatching_invoice_items dii ON dii.dispatching_invoice_id = di.dispatching_invoice_id
		WHERE si.sales_invoice_id = $sales_invoice_id
		AND di.is_active = TRUE 
		AND di.is_deleted = FALSE

		GROUP BY si.sales_inv_no,dii.product_id) as m GROUP BY m.sales_inv_no,m.product_id ) as x";

	         return $this->db->query($sql)->result();
	    }

	function get_ci_balance_qty($cash_invoice_id){
	    $sql="SELECT SUM(x.balance) as balance
		FROM
		(SELECT 
		m.cash_invoice_id,
		m.cash_inv_no,
		SUM(m.InvQty) as InvQty,
		SUM(m.DisQty) as DisQty,
		(SUM(m.InvQty) - SUM(m.DisQty))as balance
		FROM
		(SELECT ci.cash_invoice_id,
		ci.cash_inv_no,
		cii.product_id,
		SUM(cii.inv_qty) as InvQty,
		0 as DisQty

		FROM 
		cash_invoice ci 

		LEFT JOIN cash_invoice_items cii ON cii.cash_invoice_id = ci.cash_invoice_id
		WHERE ci.is_active = TRUE AND ci.is_deleted = FALSE
		AND ci.cash_invoice_id  = $cash_invoice_id
		GROUP BY ci.cash_inv_no, cii.product_id  

		UNION ALL

		SELECT ci.cash_invoice_id,
		ci.cash_inv_no,
		dii.product_id,
		0 as InvQty,
		SUM(dii.inv_qty)as DisQty


		FROM dispatching_invoice di

		INNER JOIN cash_invoice ci ON ci.cash_invoice_id = di.cash_invoice_id
		INNER JOIN dispatching_invoice_items dii ON dii.dispatching_invoice_id = di.dispatching_invoice_id
		WHERE ci.cash_invoice_id = $cash_invoice_id
		AND di.is_active = TRUE
		AND di.is_deleted = FALSE
		GROUP BY ci.	cash_inv_no,dii.product_id) as m
		GROUP BY m.cash_inv_no,m.product_id) as x";

	         return $this->db->query($sql)->result();
	    }

}


?>
