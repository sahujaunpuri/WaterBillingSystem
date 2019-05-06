<?php

class Delivery_receipt_model extends CORE_Model
{
    protected $table = "delivery_receipt";
    protected $pk_id = "delivery_receipt_id";

    function __construct()
    {
        parent::__construct();
    }

 function delivery_receipt_list_with_count(){
    $sql="SELECT
        di.*,
        DATE_FORMAT(di.date_invoice,'%m/%d/%Y') as date_invoice,
        DATE_FORMAT(di.date_due,'%m/%d/%Y') as date_due,
        di.salesperson_id,
        di.address,
        departments.department_id,
        departments.department_name,
        customers.customer_name,
        sales_invoice.sales_inv_no
        FROM delivery_receipt AS di
        LEFT JOIN departments ON departments.department_id=di.department_id
        LEFT JOIN customers  ON customers.customer_id=di.customer_id
        LEFT JOIN sales_invoice ON sales_invoice.sales_invoice_id=di.sales_invoice_id
        WHERE di.is_active= TRUE AND di.is_deleted =  FALSE";

         return $this->db->query($sql)->result();

     }




    function get_products_with_balance_qty_sales_invoice($sales_invoice_id){

        $sql="
        SELECT o.*, (o.line_total - o.non_tax_amount)as tax_amount FROM
       ( SELECT n.*,
        (n.si_price*n.si_qty) as inv_gross,
        (n.si_price*n.si_qty) as line_total,
        (n.si_price*n.si_qty)/(1+n.tax_rate_decimal) as non_tax_amount,
        ((n.si_price*n.si_qty) -((n.si_price*n.si_qty) * (n.si_discount/100))) as si_line_total,
        ((n.si_price*n.si_qty) * (n.si_discount/100)) as line_total_discount
         FROM 

        (SELECT 
        main.*,
        (main.si_tax/100)as tax_rate_decimal,
        p.sale_price, 
        p.size, 
        p.product_code,
        p.product_desc,
        p.unit_id,
        u.unit_name

         FROM(

        SELECT
        m.sales_invoice_id,
        m.sales_inv_no,
        m.product_id,
        MAX(m.inv_price) as  si_price,
        MAX(m.inv_discount) as si_discount,
        MAX(m.inv_tax_rate) as si_tax,
        (SUM(m.inv_qty)-SUM(m.dr_qty)) as si_qty FROM

        (SELECT si.sales_invoice_id,
            si.sales_inv_no,
            sii.product_id,
            sii.inv_price,
            sii.inv_discount,
            sii.inv_tax_rate,
            SUM(sii.inv_qty) as  inv_qty,
            0 as dr_qty

        FROM sales_invoice si

        INNER JOIN sales_invoice_items sii on sii.sales_invoice_id = si.sales_invoice_id
        WHERE si.sales_invoice_id = $sales_invoice_id AND si.is_active = TRUE AND si.is_deleted = FALSE

        GROUP BY si.sales_invoice_id , sii.product_id

        UNION ALL
        SELECT 
            si.sales_invoice_id,
            si.sales_inv_no,
            dri.product_id,
            0 as inv_price,
            0 as inv_discount,
            0 asinv_tax_rate,
            0 as inv_qty,
            SUM(dri.inv_qty) as  dr_qty
            

        FROM (delivery_receipt dr
        INNER JOIN sales_invoice si ON si.sales_invoice_id = dr.sales_invoice_id)
        INNER JOIN delivery_receipt_items dri on dri.delivery_receipt_id = dr.delivery_receipt_id
        WHERE si.sales_invoice_id = $sales_invoice_id AND dr.is_active = TRUE AND dr.is_deleted = FALSE
            
        GROUP BY si.sales_invoice_id, dri.product_id) as m

        GROUP BY m.sales_invoice_id,m.product_id) as main
        LEFT JOIN products p ON  p.product_id = main.product_id
        LEFT JOIN units u ON u.unit_id = p.unit_id 

        HAVING si_qty > 0
        )  as n ) as o";

         return $this->db->query($sql)->result();

}







    function get_sales_invoice_balance_qty($id){
        $sql="SELECT
            SUM(o.balance) as balance
             FROM
            (SELECT 
            m.sales_invoice_id,
            m.sales_inv_no,
            m.product_id,
            (SUM(m.SiQty)-SUM(m.DrQty)) as balance
             FROM
            (SELECT 
            si.sales_invoice_id,
            si.sales_inv_no,
            sii.product_id,
            SUM(sii.inv_qty) as SiQty,
            0 as DrQty

            FROM sales_invoice si
            INNER JOIN sales_invoice_items sii ON sii.sales_invoice_id = si.sales_invoice_id

            WHERE si.sales_invoice_id = $id AND si.is_active = TRUE AND si.is_deleted = FALSE
            GROUP BY  si.sales_inv_no,sii.product_id

            UNION ALL

            SELECT 
            si.sales_invoice_id,
            si.sales_inv_no,
            dri.product_id,
            0 as SiQty,
            SUM(dri.inv_qty) as  DrQty


            FROM (delivery_receipt dr
            INNER JOIN sales_invoice si ON si.sales_invoice_id = dr.sales_invoice_id)
            INNER JOIN delivery_receipt_items dri on dri.delivery_receipt_id = dr.delivery_receipt_id
            WHERE si.sales_invoice_id = $id AND dr.is_active = TRUE AND dr.is_deleted = FALSE
            GROUP BY si.sales_invoice_id, dri.product_id) as m
            GROUP BY m.sales_invoice_id,m.product_id) as o";

        return $this->db->query($sql)->result();
    }





}


?>
