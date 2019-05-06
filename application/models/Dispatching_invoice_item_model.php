<?php

class Dispatching_invoice_item_model extends CORE_Model
{
    protected $table = "dispatching_invoice_items";
    protected $pk_id = "dispatching_item_id";
    protected $fk_id = "dispatching_invoice_id";

    function __construct()
    {
        parent::__construct();
    }




   function get_products_with_balance_qty_si($sales_invoice_id){
   	$sql="SELECT o.*, (o.inv_gross - o.non_tax_amount) as tax_amount
	FROM(SELECT n.*,
	(n.inv_price * n.inv_qty) as inv_gross,
	(n.inv_price * n.inv_qty) as line_total,
	((n.inv_price * n.inv_qty)/(1+n.tax_rate_decimal)) as non_tax_amount,
	((n.inv_price * n.inv_qty)-(n.inv_price * n.inv_qty)*(n.inv_discount/100)) as inv_line_total_price,
	((n.inv_price * n.inv_qty)*(n.inv_discount/100)) as inv_line_total_discount
	FROM
	(SELECT main.*,
	p.purchase_cost,
	(main.inv_tax_rate/100)as tax_rate_decimal,
	p.product_code,
	p.product_desc,
	p.sale_price,
	p.discounted_price,
	p.dealer_price,	
	p.distributor_price,
	p.public_price,
	p.parent_unit_id,
	p.child_unit_id,
	p.child_unit_desc,
	p.is_bulk,
	(SELECT unit_name FROM units u WHERE u.unit_id = p.parent_unit_id) as parent_unit_name,
	(SELECT unit_name FROM units u WHERE u.unit_id = p.child_unit_id) as child_unit_name

	FROM
	(SELECT 
	m.sales_invoice_id,
	m.sales_inv_no,
	m.product_id,
	MAX(m.inv_price) as inv_price,
	MAX(m.inv_discount) as inv_discount,
	MAX(m.inv_tax_rate) as inv_tax_rate,
	(SUM(InvQty)-SUM(DisQty)) as inv_qty,
	MAX(m.unit_id) as unit_id,
	MAX(m.is_parent) as is_parent
	 FROM
	(SELECT
	si.sales_invoice_id,
	si.sales_inv_no,
	sii.product_id,
	SUM(sii.inv_qty) as InvQty,
	0 as DisQty,
	sii.inv_price,
	sii.inv_discount,
	sii.inv_tax_rate,
	sii.unit_id,
	sii.is_parent

	FROM sales_invoice si	
	INNER JOIN sales_invoice_items as sii ON si.sales_invoice_id=sii.sales_invoice_id
	WHERE 
	si.sales_invoice_id = $sales_invoice_id AND
	si.is_active = TRUE AND si.is_deleted = FALSE
	GROUP BY si.sales_inv_no,sii.product_id

	UNION ALL

	SELECT
	si.sales_invoice_id,
	si.sales_inv_no,
	dii.product_id,
	0 as InvQty,
	SUM(dii.inv_qty) as DisQty,
	0 as inv_price,
	0 as inv_discount,
	0 as inv_tax_rate,
	0 as unit_id,
	0 as is_parent

	FROM dispatching_invoice di	
	INNER JOIN sales_invoice as si ON si.sales_invoice_id = di.sales_invoice_id
	INNER JOIN dispatching_invoice_items as dii ON dii.dispatching_invoice_id=di.dispatching_invoice_id
	WHERE 
	si.sales_invoice_id = $sales_invoice_id AND
	di.is_active = TRUE AND di.is_deleted = FALSE
	GROUP BY si.sales_inv_no,dii.product_id) as m
	GROUP BY m.sales_inv_no, m.product_id HAVING inv_qty > 0) as main
	LEFT JOIN products p ON p.product_id = main.product_id

	GROUP BY main.sales_inv_no,main.product_id

	) as n ) as o";
        return $this->db->query($sql)->result();
    }





 function get_products_with_balance_qty_ci($cash_invoice_id){
   	$sql="SELECT o.*, (o.inv_gross - o.non_tax_amount) as tax_amount
	FROM(SELECT n.*,
	(n.inv_price * n.inv_qty) as inv_gross,
	(n.inv_price * n.inv_qty) as line_total,
	((n.inv_price * n.inv_qty)/(1+n.tax_rate_decimal)) as non_tax_amount,
	((n.inv_price * n.inv_qty)-(n.inv_price * n.inv_qty)*(n.inv_discount/100)) as inv_line_total_price,
	((n.inv_price * n.inv_qty)*(n.inv_discount/100)) as inv_line_total_discount
	FROM
	(SELECT main.*,
	p.purchase_cost,
	(main.inv_tax_rate/100)as tax_rate_decimal,
	p.product_code,
	p.product_desc,
	p.sale_price,
	p.discounted_price,
	p.dealer_price,	
	p.distributor_price,
	p.public_price,
	p.parent_unit_id,
	p.child_unit_id,
	p.child_unit_desc,
	p.is_bulk,
	(SELECT unit_name FROM units u WHERE u.unit_id = p.parent_unit_id) as parent_unit_name,
	(SELECT unit_name FROM units u WHERE u.unit_id = p.child_unit_id) as child_unit_name

	FROM
	(SELECT 
	m.cash_invoice_id,
	m.cash_inv_no,
	m.product_id,
	MAX(m.inv_price) as inv_price,
	MAX(m.inv_discount) as inv_discount,
	MAX(m.inv_tax_rate) as inv_tax_rate,
	(SUM(InvQty)-SUM(DisQty)) as inv_qty,
	MAX(m.unit_id) as unit_id,
	MAX(m.is_parent) as is_parent
	 FROM
	(SELECT

	ci.cash_invoice_id,
	ci.cash_inv_no,
	cii.product_id,
	SUM(cii.inv_qty) as InvQty,
	0 as DisQty,
	cii.inv_price,
	cii.inv_discount,
	cii.inv_tax_rate,
	cii.unit_id,
	cii.is_parent
	FROM cash_invoice ci

	INNER JOIN cash_invoice_items cii ON cii.cash_invoice_id = ci.cash_invoice_id

	WHERE ci.cash_invoice_id = $cash_invoice_id
	AND ci.is_active = TRUE AND ci.is_deleted = FALSE
	GROUP BY ci.cash_inv_no,cii.product_id

	UNION ALL

	SELECT
	ci.cash_invoice_id,
	ci.cash_inv_no,
	dii.product_id,
	0 as InvQty,
	SUM(dii.inv_qty) as DisQty,
	0 as inv_price,
	0 as inv_discount,
	0 as inv_tax_rate,
	0 as unit_id,
	0 as is_parent

	FROM dispatching_invoice di	
	INNER JOIN cash_invoice as ci ON ci.cash_invoice_id = di.cash_invoice_id
	INNER JOIN dispatching_invoice_items as dii ON dii.dispatching_invoice_id=di.dispatching_invoice_id
	WHERE 
	ci.cash_invoice_id = $cash_invoice_id AND
	di.is_active = TRUE AND di.is_deleted = FALSE
	GROUP BY ci.cash_inv_no,dii.product_id) as m
	GROUP BY m.cash_inv_no, m.product_id HAVING inv_qty > 0) as main
	LEFT JOIN products p ON p.product_id = main.product_id

	GROUP BY main.cash_inv_no,main.product_id
	) as n ) as o";

    return $this->db->query($sql)->result();

    }


}


?>