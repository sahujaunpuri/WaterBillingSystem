<?php

class Cost_of_goods_sold_model extends CORE_Model {
    protected  $table="products";
    protected  $pk_id="product_id";

    function __construct() {
        parent::__construct();
    }



    function get_purchases_for_cogs($department_id=null,$start_date,$end_date) {
        $sql="SELECT 
            di.dr_invoice_no,
            s.supplier_name,
            DATE_FORMAT(di.date_delivered,'%M %d, %Y')as delivered_date,
            p.product_desc,
            IF(dii.is_parent = 1, IFNULL(dii.dr_qty,0),IFNULL(dii.dr_qty,0)/IFNULL(p.child_unit_desc,0)) as qty,
            IF(dii.is_parent = 1, IFNULL(dii.dr_price,0),IFNULL(dii.dr_price,0)*IFNULL(p.child_unit_desc,0)) as price,
            dii.dr_line_total_price

             FROM

            delivery_invoice_items as dii
            LEFT JOIN delivery_invoice di ON di.dr_invoice_id = dii.dr_invoice_id
            LEFT JOIN products p on p.product_id = dii.product_id
            LEFT JOIN suppliers s ON s.supplier_id= di.supplier_id
            WHERE di.is_deleted = FALSE AND di.is_active = TRUE
            AND di.date_delivered BETWEEN '$start_date' AND '$end_date'
            AND p.is_active = TRUE AND p.is_deleted = FALSE AND p.item_type_id = 1
            ".($department_id==1||$department_id==null?"":" AND di.department_id=$department_id")."
            ";
        return $this->db->query($sql)->result();
    }

    function get_merchandise_inventory_for_cogs($department=null,$as_of_date) {
        $sql="
            SELECT m.product_id,m.product_desc,m.balance,m.avg_cost,(IFNULL(m.avg_cost,0)*IFNULL(m.balance,0)) as avg_net
            FROM
            (SELECT main.*,

            (ReceiveQty+AdjInQty-AdjOutQty-CashOutQty-SaleOutQty+IssueInQty-IssueOutQty) as balance
             FROM


            (SELECT p.product_id,p.product_desc,
            IFNULL(ReceiveQuery.avg_cost,0) as avg_cost,
            IFNULL(ReceiveQuery.ReceiveQty,0) as ReceiveQty,
            IFNULL(AdjInQuery.AdjInQty,0) as AdjInQty,
            IFNULL(AdjOutQuery.AdjOutQty,0) as AdjOutQty,
            IFNULL(CashOutQuery.CashOutQty,0) as CashOutQty,
            IFNULL(SaleOutQuery.SaleOutQty,0) as SaleOutQty,
            IFNULL(IssueInQuery.IssueInQty,0) as IssueInQty,
            IFNULL(IssueOutQuery.IssueOutQty,0) as IssueOutQty

            FROM products p 
            LEFT JOIN(
            SELECT 
            p.product_id,
            SUM(IF(dii.is_parent = 1, IFNULL(dii.dr_qty,0),IFNULL(dii.dr_qty,0)/IFNULL(p.child_unit_desc,0))) as ReceiveQty,
            AVG(IF(dii.is_parent = 1, IFNULL(dii.dr_price,0),IFNULL(dii.dr_price,0)*IFNULL(p.child_unit_desc,0))) as avg_cost
            FROM delivery_invoice_items as dii
            LEFT JOIN delivery_invoice di ON di.dr_invoice_id = dii.dr_invoice_id
            LEFT JOIN products p on p.product_id = dii.product_id
            WHERE di.is_deleted = FALSE AND di.is_active = TRUE AND di.date_delivered<='$as_of_date'
            ".($department==1||$department==null?"":" AND di.department_id=$department")."
            GROUP BY dii.product_id) as ReceiveQuery ON ReceiveQuery.product_id = p.product_id

            LEFT JOIN(
            SELECT 
            p.product_id,
            SUM(IF(aii.is_parent = 1, IFNULL(aii.adjust_qty,0),IFNULL(aii.adjust_qty,0)/IFNULL(p.child_unit_desc,0))) as AdjInQty
            FROM adjustment_items aii

            LEFT JOIN adjustment_info ai ON ai.adjustment_id = aii.adjustment_id
            LEFT JOIN products p ON p.product_id = aii.product_id
            WHERE ai.is_active = TRUE AND ai.is_deleted = FALSE  AND ai.adjustment_type = 'IN' AND ai.date_adjusted<='$as_of_date'
            ".($department==1||$department==null?"":" AND ai.department_id=$department")."
            GROUP BY aii.product_id) as AdjInQuery ON AdjInQuery.product_id = p.product_id

            LEFT JOIN(
            SELECT 
            p.product_id,
            SUM(IF(aii.is_parent = 1, IFNULL(aii.adjust_qty,0),IFNULL(aii.adjust_qty,0)/IFNULL(p.child_unit_desc,0))) as AdjOutQty
            FROM adjustment_items aii
            LEFT JOIN adjustment_info ai ON ai.adjustment_id = aii.adjustment_id
            LEFT JOIN products p ON p.product_id = aii.product_id
            WHERE ai.is_active = TRUE AND ai.is_deleted = FALSE AND ai.adjustment_type = 'OUT' AND ai.date_adjusted<='$as_of_date'
            ".($department==1||$department==null?"":" AND ai.department_id=$department")."
            GROUP BY aii.product_id) as AdjOutQuery ON AdjOutQuery.product_id = p.product_id

            LEFT JOIN(
            SELECT 
            p.product_id,
            SUM(IF(cii.is_parent = 1, IFNULL(cii.inv_qty,0),IFNULL(cii.inv_qty,0)/IFNULL(p.child_unit_desc,0))) as CashOutQty

            FROM cash_invoice_items cii
            LEFT JOIN cash_invoice ci ON ci.cash_invoice_id =cii.cash_invoice_id
            LEFT JOIN products p ON p.product_id = cii.product_id 
            WHERE ci.is_active = TRUE AND ci.is_deleted = FALSE AND ci.date_invoice<='$as_of_date'
            ".($department==1||$department==null?"":" AND ci.department_id=$department")."
            GROUP BY cii.product_id) as CashOutQuery ON CashOutQuery.product_id = p.product_id 

            LEFT JOIN(
            SELECT p.product_id,
            SUM(IF(sii.is_parent = 1, IFNULL(sii.inv_qty,0),IFNULL(sii.inv_qty,0)/IFNULL(p.child_unit_desc,0))) as SaleOutQty
            FROM sales_invoice_items sii

            LEFT JOIN sales_invoice si ON si.sales_invoice_id = sii.sales_invoice_id
            LEFT JOIN products p ON p.product_id = sii.product_id
            WHERE si.is_active = TRUE AND si.is_deleted = FALSE AND si.date_invoice<='$as_of_date'
            ".($department==1||$department==null?"":" AND si.department_id=$department")."
            GROUP BY sii.product_id) as SaleOutQuery ON SaleOutQuery.product_id = p.product_id

            LEFT JOIN(
            SELECT 
            p.product_id,
            SUM(IF(idi.is_parent = 1, IFNULL(idi.issue_qty,0),IFNULL(idi.issue_qty,0)/IFNULL(p.child_unit_desc,0))) as IssueInQty
            FROM issuance_department_items as idi
            LEFT JOIN issuance_department_info di ON di.issuance_department_id = idi.issuance_department_id
            LEFT JOIN products p on p.product_id = idi.product_id
            WHERE di.is_deleted = FALSE AND di.is_active = TRUE  AND di.date_issued<='$as_of_date'
            ".($department==1||$department==null?"":" AND di.to_department_id=$department")."
            GROUP BY idi.product_id) as IssueInQuery ON IssueInQuery.product_id = p.product_id

            LEFT JOIN(
            SELECT 
            p.product_id,
            SUM(IF(idi.is_parent = 1, IFNULL(idi.issue_qty,0),IFNULL(idi.issue_qty,0)/IFNULL(p.child_unit_desc,0))) as IssueOutQty
            FROM issuance_department_items as idi
            LEFT JOIN issuance_department_info di ON di.issuance_department_id = idi.issuance_department_id
            LEFT JOIN products p on p.product_id = idi.product_id
            WHERE di.is_deleted = FALSE AND di.is_active = TRUE  AND di.date_issued<='$as_of_date'
            ".($department==1||$department==null?"":" AND di.from_department_id=$department")."
            GROUP BY idi.product_id) as IssueOutQuery ON IssueOutQuery.product_id= p.product_id  WHERE p.is_active = TRUE AND p.is_deleted = FALSE AND p.item_type_id  = 1) as main) as m
            ORDER BY m.product_desc ASC


            ";
        return $this->db->query($sql)->result();
    }


}
?>