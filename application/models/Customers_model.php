<?php

class Customers_model extends CORE_Model{

    protected  $table="customers"; //table name
    protected  $pk_id="customer_id"; //primary key id



    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function get_customer_list_for_sales_report(){
        $sql="SELECT 
            customer_id,
            customer_name
        FROM
            customers
        WHERE
            is_deleted = FALSE AND is_active = TRUE AND customer_id != 1969

        UNION 

        SELECT 
            CONCAT(department_id, '(DR)') AS customer_id,
            CONCAT(department_name, ' (DR)') AS customer_name
        FROM
            departments
        WHERE
            is_deleted = FALSE AND is_active = TRUE AND department_id != 1";

        return $this->db->query($sql)->result();
    }

    function get_customer_list($customer_id=null){
        $sql="  SELECT
                  a.*,b.photo_path
                FROM
                  customers as a
                LEFT JOIN
                    customer_photos as b
                ON
                  a.customer_id=b.customer_id
                WHERE
                    a.is_deleted=FALSE AND a.is_active=TRUE
                ".($customer_id==null?"":" AND a.customer_id=$customer_id")."
            ";
        return $this->db->query($sql)->result();
    }

    //returns list of sales invoice of customer that are unpaid
    // function get_customer_receivable_list($customer_id) {
    //     $sql="SELECT unp.*,IFNULL(pay.sales_payment_amount,0) as sales_payment_amount,
    //             (IFNULL(unp.total_sales_amount,0)-IFNULL(pay.sales_payment_amount,0))as net_receivable
    //             FROM
    //             (SELECT si.sales_invoice_id,si.sales_inv_no,date_due,si.remarks,si.customer_id,s.customer_name,
    //             (si.total_after_tax)As total_sales_amount
    //             FROM (sales_invoice as si
    //             LEFT JOIN customers as s ON si.customer_id=s.customer_id)
    //             WHERE si.is_active=TRUE AND si.is_deleted=FALSE AND si.is_paid=FALSE
    //             AND si.customer_id=$customer_id
    //             )as unp

    //             LEFT JOIN

    //             (SELECT rpl.payment_id,rpl.sales_invoice_id,
    //             SUM(rpl.payment_amount)as sales_payment_amount
    //             FROM (receivable_payments_list as rpl
    //             INNER JOIN sales_invoice as si ON rpl.sales_invoice_id=si.sales_invoice_id)
    //             INNER JOIN receivable_payments as rp ON rpl.payment_id=rp.payment_id
    //             WHERE rp.is_active=TRUE AND rp.is_deleted=FALSE AND si.is_paid=FALSE
    //             AND rp.customer_id=$customer_id
    //             GROUP BY rpl.sales_invoice_id
    //             )As pay

    //             ON unp.sales_invoice_id=pay.sales_invoice_id HAVING net_receivable>0";
                
    //     return $this->db->query($sql)->result();
    // }

    function get_customer_receivable_list($customer_id,$filter_accounts)
    {
        $sql = "SELECT
                unpaid.*,
                IFNULL(paid.receivable_amount,0) receivable_amount,
                IFNULL(paid.payment_amount,0) payment_amount,
                (IFNULL(unpaid.journal_receivable_amount,0) - IFNULL(paid.payment_amount,0)) amount_due
                FROM
                (SELECT
                ji.txn_no,
                ji.journal_id,
                c.customer_name,
                IF(ISNULL(si.date_due),serv_inv.date_due,si.date_due) date_due,
                IF(ISNULL(si.remarks),IFNULL(serv_inv.remarks, ji.remarks),IFNULL(si.remarks, ji.remarks)) remarks,
                IF(ISNULL(ref_no), txn_no, ref_no) inv_no,
                IF(ji.is_sales = 1, SUM(ja.dr_amount), SUM(ja.dr_amount)) as journal_receivable_amount,
                ji.is_sales
                FROM
                (journal_info ji
                INNER JOIN (SELECT * FROM journal_accounts ja WHERE ja.account_id IN ($filter_accounts)) ja ON ja.journal_id = ji.journal_id)
                LEFT JOIN customers c ON c.customer_id = ji.customer_id
                LEFT JOIN sales_invoice si ON si.sales_inv_no = ji.ref_no AND ji.is_sales=1
                LEFT JOIN service_invoice serv_inv ON serv_inv.service_invoice_no = ji.ref_no AND ji.is_sales=0
                WHERE
                ji.is_deleted=FALSE
                AND ji.is_active=TRUE
                AND ji.book_type = 'SJE'
                AND ji.customer_id = $customer_id
                AND ji.hotel_integration_id = 0
                AND ji.pos_integration_id = 0
                GROUP BY ji.journal_id) unpaid

                LEFT JOIN 

                (SELECT
                rpl.journal_id,
                SUM(IFNULL(rpl.receivable_amount,0)) receivable_amount,
                SUM(IFNULL(rpl.payment_amount,0)) payment_amount
                FROM
                receivable_payments rp
                INNER JOIN receivable_payments_list rpl ON rpl.payment_id = rp.payment_id
                WHERE
                rp.is_active=TRUE
                AND rp.is_deleted=FALSE
                AND rp.customer_id = $customer_id
                GROUP BY rpl.journal_id) paid

                ON unpaid.journal_id = paid.journal_id
                HAVING amount_due > 0";

                return $this->db->query($sql)->result();
    }

    function get_customer_receivable_list2($customer_id) {
        $sql = "SELECT
                *
                FROM
                (
                
                (
                    SELECT 
                    unp.*,
                    IFNULL(pay.sales_payment_amount,0) as sales_payment_amount,
                    (IFNULL(unp.total_sales_amount,0)-IFNULL(pay.sales_payment_amount,0))as net_receivable,
                    1 is_sales
                    FROM
                    (
                    SELECT 
                    si.sales_invoice_id,
                    si.sales_inv_no,
                    date_due,
                    si.remarks,
                    si.customer_id,
                    s.customer_name,
                    (si.total_after_tax)As total_sales_amount
                    FROM (sales_invoice as si
                    LEFT JOIN customers as s ON si.customer_id=s.customer_id)
                    WHERE si.is_active=TRUE AND si.is_deleted=FALSE AND si.is_paid=FALSE
                    AND si.customer_id=$customer_id
                    )as unp

                    LEFT JOIN

                    (SELECT rpl.payment_id,rpl.sales_invoice_id,
                    SUM(rpl.payment_amount)as sales_payment_amount
                    FROM (receivable_payments_list as rpl
                    INNER JOIN sales_invoice as si ON rpl.sales_invoice_id=si.sales_invoice_id)
                    INNER JOIN receivable_payments as rp ON rpl.payment_id=rp.payment_id
                    WHERE rp.is_active=TRUE AND rp.is_deleted=FALSE AND si.is_paid=FALSE
                    AND rp.customer_id=$customer_id
                    GROUP BY rpl.sales_invoice_id
                    )As pay

                    ON unp.sales_invoice_id=pay.sales_invoice_id HAVING net_receivable>0
                )

                UNION

                (
                    SELECT 
                    unp.*,
                    IFNULL(pay.sales_payment_amount,0) as sales_payment_amount,
                    (IFNULL(unp.total_sales_amount,0)-IFNULL(pay.sales_payment_amount,0))as net_receivable,
                    0 is_sales
                    FROM
                    (
                    SELECT
                    si.service_invoice_id,
                    si.service_invoice_no,
                    date_due,
                    si.remarks,
                    si.customer_id,
                    s.customer_name,
                    (si.total_amount)As total_sales_amount
                    FROM (service_invoice as si
                    LEFT JOIN customers as s ON si.customer_id=s.customer_id)
                    WHERE si.is_active=TRUE AND si.is_deleted=FALSE
                    AND si.customer_id=$customer_id
                    )as unp

                    LEFT JOIN

                    (
                    SELECT rpl.payment_id,
                    rpl.service_invoice_id,
                    SUM(rpl.payment_amount)as sales_payment_amount
                    FROM (receivable_payments_list as rpl
                    INNER JOIN service_invoice as si ON rpl.service_invoice_id=si.service_invoice_id)
                    INNER JOIN receivable_payments as rp ON rpl.payment_id=rp.payment_id
                    WHERE rp.is_active=TRUE AND rp.is_deleted=FALSE
                    AND rp.customer_id=$customer_id
                    GROUP BY rpl.service_invoice_id
                    )as pay

                    ON unp.service_invoice_id=pay.service_invoice_id HAVING net_receivable>0
                ) 

                ) sales_services";

            return $this->db->query($sql)->result();
    }

    function get_current_receivable_amount($customer_id){
        $sql="SELECT IFNULL((SUM(m.total_receivable)-SUM(m.total_payment)),0) as net_receivable
            FROM
            (SELECT SUM(si.total_after_tax) as total_receivable,0 as total_payment FROM sales_invoice as si
            WHERE si.is_active=TRUE AND si.is_deleted=FALSE AND si.customer_id=$customer_id GROUP BY si.customer_id

            UNION

            SELECT 0 as total_receivable,SUM(rp.total_paid_amount) as total_payment FROM receivable_payments as rp
            WHERE rp.is_active=TRUE AND rp.is_deleted=FALSE AND rp.customer_id=$customer_id GROUP BY rp.customer_id)as m";


        $result=$this->db->query($sql)->result();
        return (float)($result[0]->net_receivable);

    }


    function recalculate_customer_receivable($customer_id){
        $sql="UPDATE customers SET total_receivable_amount=".$this->get_current_receivable_amount($customer_id)." WHERE customer_id=$customer_id";
        return $this->db->query($sql);
    }

    function get_customer_invoice($customer_id){
        $sql="SELECT
           report.sales_inv_no,
            report.date_invoice,
            report.total_after_discount AS amount,
            report.remarks
            FROM 
            /*  SQL BELOW SHOWS DETAILED REPORT, ABOVE SQL IS USED TO SHOW THE FIELDS NEEDED IN THE FRONT END */
            (SELECT
            unpaid.sales_inv_no,
            unpaid.date_invoice,
            unpaid.journal_id,
            unpaid.total_after_discount,

            IFNULL(paid.payment_amount,0) as payment_amount,
            IFNULL(unpaid.total_after_discount - paid.payment_amount,0) AS total,

            (CASE WHEN unpaid.total_after_discount = paid.payment_amount THEN 'paid' ELSE 'unpaid' END) AS remarks
            FROM
            (SELECT
            journal_id,
            sales_inv_no,
            date_invoice,
            total_after_discount
            FROM sales_invoice
            WHERE is_active=TRUE AND is_deleted=FALSE AND customer_id = $customer_id) AS unpaid

            LEFT JOIN

            (SELECT 
            receivable_payments_list.journal_id,
            SUM(payment_amount) AS payment_amount 
            FROM receivable_payments_list
            INNER JOIN receivable_payments ON receivable_payments.payment_id = receivable_payments_list.payment_id
            WHERE is_active=TRUE AND is_deleted=FALSE AND customer_id = $customer_id
            GROUP BY receivable_payments_list.journal_id ) AS paid

            ON paid.journal_id = unpaid.journal_id ) as report";


        return $this->db->query($sql)->result();



    }




function get_customer_payment($customer_id){

    $sql="SELECT 
        receipt_no,
        date_paid,
        total_paid_amount,
        check_no
         FROM

        (SELECT 
        receipt_no,
        date_paid,
        sales_invoice_id,
        total_paid_amount,
        check_no,
        customer_id,
        is_active,
        is_deleted
        FROM receivable_payments as rp

        LEFT JOIN 

        (SELECT 
        sales_invoice_id,
        payment_id
        FROM
        receivable_payments_list
        GROUP BY payment_id) as paid
        ON rp.payment_id = paid.payment_id ) AS report
        
        
        
        WHERE report.is_active = TRUE AND report.is_deleted = FALSE AND report.customer_id = $customer_id

        ";

        return $this->db->query($sql)->result();



}

// function get_customer_payment($customer_id){

//     $sql="SELECT 
//         receipt_no,
//         date_paid,
//         sales_inv_no,
//         total_paid_amount,
//         check_no
//          FROM

//         (SELECT 
//         receipt_no,
//         date_paid,
//         sales_invoice_id,
//         total_paid_amount,
//         check_no,
//         is_active,
//         is_deleted
//         FROM receivable_payments as rp

//         LEFT JOIN 

//         (SELECT 
//         sales_invoice_id,
//         payment_id
//         FROM
//         receivable_payments_list
//         GROUP BY payment_id) as paid
//         ON rp.payment_id = paid.payment_id ) AS report


//         LEFT JOIN 

//         (SELECT sales_invoice_id,sales_inv_no,customer_id FROM sales_invoice
//         WHERE is_active = TRUE AND is_deleted = FALSE) AS si

//         ON si.sales_invoice_id = report.sales_invoice_id 

//         WHERE report.is_active = TRUE AND report.is_deleted = FALSE AND si.customer_id = $customer_id

//         ";

//         return $this->db->query($sql)->result();



// }
// get sales invoice count associated with Customer
function get_sales_invoice_count($sales_invoice_id){
                $sql="
                SELECT * FROM receivable_payments 
                LEFT JOIN receivable_payments_list 
                ON receivable_payments_list.payment_id = receivable_payments.payment_id 
                WHERE receivable_payments_list.sales_invoice_id = $sales_invoice_id 
                AND receivable_payments.is_active = TRUE 
                AND receivable_payments.is_deleted = FALSE";


                return $this->db->query($sql)->result();
                }


}




?>