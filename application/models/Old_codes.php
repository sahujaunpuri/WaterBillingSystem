
    // function get_aging_receivables()
    // {
    //     $sql = "SELECT
    //         n.customer_name,
    //         SUM(n.days) days,
    //         SUM(n.current) current,
    //         SUM(n.30days) thirty_days,
    //         SUM(n.45days) fortyfive_days,
    //         SUM(n.60days) sixty_days,
    //         SUM(n.over_90days) over_ninetydays
    //         FROM
    //         (SELECT
    //         m.customer_id,
    //         m.customer_name,
    //         m.days,
    //         m.sales_inv_no,
    //         IF(m.days >= 0 AND m.days < 30, m.balance,'') AS current,
    //         IF(m.days >= 30 AND m.days <= 44, m.balance,'') AS 30days,
    //         IF(m.days >= 45 AND m.days <= 59, m.balance,'') AS 45days,
    //         IF(m.days >= 60 AND m.days <= 89, m.balance,'') AS 60days,
    //         IF(m.days >= 90, m.balance,'') AS over_90days
    //         FROM
    //         (SELECT
    //             si.sales_inv_no,
    //             si.customer_id,
    //             c.customer_name,
    //             IFNULL(rpp.payment_amount,0) AS payment_amount,
    //             ABS(DATEDIFF(NOW(),si.date_invoice)) AS days,
    //             (IFNULL(si.total_after_tax,0) - IFNULL(rpp.payment_amount,0)) AS balance,
    //             (CASE WHEN (IFNULL(rpp.payment_amount,0) < si.total_after_tax AND IFNULL(rpp.payment_amount,0) > 0) OR (IFNULL(rpp.payment_amount,0) = 0) THEN 'unpaid' ELSE 'paid' END) AS payment_status
    //         FROM
    //             sales_invoice si
    //             LEFT JOIN customers c ON c.customer_id = si.customer_id
    //             LEFT JOIN
    //             (
    //                 SELECT rp.*, rpl.sales_invoice_id, SUM(rpl.payment_amount) payment_amount FROM
    //                 receivable_payments rp
    //                 INNER JOIN receivable_payments_list rpl ON rpl.payment_id = rp.payment_id
    //                 WHERE
    //                 rp.is_deleted=FALSE AND rp.is_active=TRUE
    //                 GROUP BY rpl.sales_invoice_id
    //             ) AS rpp
    //             ON rpp.sales_invoice_id = si.sales_invoice_id
    //         WHERE
    //             si.is_deleted = FALSE
    //             AND si.is_active = TRUE) m
    //         ) n

    //         GROUP BY n.customer_id";

    //     return $this->db->query($sql)->result();
    // }

    // function get_aging_receivables()
    // {
    //     $sql = "SELECT
    //     *
    //     FROM
    //     (
    //         (
    //         SELECT
    //         n.customer_id,
    //         n.customer_name,
    //         SUM(n.days) days,
    //         SUM(n.current) current,
    //         SUM(n.30days) thirty_days,
    //         SUM(n.45days) fortyfive_days,
    //         SUM(n.60days) sixty_days,
    //         SUM(n.over_90days) over_ninetydays,
    //         1 is_sales
    //         FROM
    //         (SELECT
    //         m.customer_id,
    //         m.customer_name,
    //         m.days,
    //         m.sales_inv_no,
    //         IF(m.days >= 0 AND m.days < 30, m.balance,'') AS current,
    //         IF(m.days >= 30 AND m.days <= 44, m.balance,'') AS 30days,
    //         IF(m.days >= 45 AND m.days <= 59, m.balance,'') AS 45days,
    //         IF(m.days >= 60 AND m.days <= 89, m.balance,'') AS 60days,
    //         IF(m.days >= 90, m.balance,'') AS over_90days
    //         FROM
    //         (SELECT
    //             si.sales_inv_no,
    //             si.customer_id,
    //             c.customer_name,
    //             IFNULL(rpp.payment_amount,0) AS payment_amount,
    //             ABS(DATEDIFF(NOW(),si.date_invoice)) AS days,
    //             (IFNULL(si.total_after_tax,0) - IFNULL(rpp.payment_amount,0)) AS balance,
    //             (CASE WHEN (IFNULL(rpp.payment_amount,0) < si.total_after_tax AND IFNULL(rpp.payment_amount,0) > 0) OR (IFNULL(rpp.payment_amount,0) = 0) THEN 'unpaid' ELSE 'paid' END) AS payment_status
    //         FROM
    //             sales_invoice si
    //             LEFT JOIN customers c ON c.customer_id = si.customer_id
    //             LEFT JOIN
    //             (
    //                 SELECT rp.*, rpl.sales_invoice_id, SUM(rpl.payment_amount) payment_amount FROM
    //                 receivable_payments rp
    //                 INNER JOIN receivable_payments_list rpl ON rpl.payment_id = rp.payment_id
    //                 WHERE
    //                 rp.is_deleted=FALSE AND rp.is_active=TRUE
    //                 GROUP BY rpl.sales_invoice_id
    //             ) AS rpp
    //             ON rpp.sales_invoice_id = si.sales_invoice_id
    //         WHERE
    //             si.is_deleted = FALSE
    //             AND si.is_active = TRUE) m
    //         ) n

    //         GROUP BY n.customer_id
    //         )

    //         UNION

    //         (
    //         SELECT
    //         n.customer_id,
    //         n.customer_name,
    //         SUM(n.days) days,
    //         SUM(n.current) current,
    //         SUM(n.30days) thirty_days,
    //         SUM(n.45days) fortyfive_days,
    //         SUM(n.60days) sixty_days,
    //         SUM(n.over_90days) over_ninetydays,
    //         0 is_sales
    //         FROM
    //         (SELECT
    //         m.customer_id,
    //         m.customer_name,
    //         m.days,
    //         m.service_invoice_no,
    //         IF(m.days >= 0 AND m.days < 30, m.balance,'') AS current,
    //         IF(m.days >= 30 AND m.days <= 44, m.balance,'') AS 30days,
    //         IF(m.days >= 45 AND m.days <= 59, m.balance,'') AS 45days,
    //         IF(m.days >= 60 AND m.days <= 89, m.balance,'') AS 60days,
    //         IF(m.days >= 90, m.balance,'') AS over_90days
    //         FROM
    //         (SELECT
    //             si.service_invoice_no,
    //             si.customer_id,
    //             c.customer_name,
    //             IFNULL(rpp.payment_amount,0) AS payment_amount,
    //             ABS(DATEDIFF(NOW(),si.date_invoice)) AS days,
    //             (IFNULL(si.total_amount,0) - IFNULL(rpp.payment_amount,0)) AS balance,
    //             (CASE WHEN (IFNULL(rpp.payment_amount,0) < si.total_amount AND IFNULL(rpp.payment_amount,0) > 0) OR (IFNULL(rpp.payment_amount,0) = 0) THEN 'unpaid' ELSE 'paid' END) AS payment_status
    //         FROM
    //             service_invoice si
    //             LEFT JOIN customers c ON c.customer_id = si.customer_id
    //             LEFT JOIN
    //             (
    //                 SELECT rp.*, rpl.service_invoice_id, SUM(rpl.payment_amount) payment_amount FROM
    //                 receivable_payments rp
    //                 INNER JOIN receivable_payments_list rpl ON rpl.payment_id = rp.payment_id
    //                 WHERE
    //                 rp.is_deleted=FALSE AND rp.is_active=TRUE
    //                 GROUP BY rpl.service_invoice_id
    //             ) AS rpp
    //             ON rpp.service_invoice_id = si.service_invoice_id
    //         WHERE
    //             si.is_deleted = FALSE
    //             AND si.is_active = TRUE) m
    //         ) n

    //         GROUP BY n.customer_id
    //         )
    //     ) sales_services";

    //     return $this->db->query($sql)->result();
    // }


    //     function get_customer_soa_payment($customer_id){
// $sql="
// SELECT * FROM
// (SELECT * FROM
//         (SELECT
//             1 as group_status,
//             rp.*,
//             c.customer_name,
//             rpl.sales_invoice_id,
//             0 as service_invoice_id,
//             GROUP_CONCAT(rp.receipt_no) receipt_no_desc,
//             IFNULL(rpl.receivable_amount,0) receivable_amount,
//             SUM(IFNULL(rpl.payment_amount,0)) payment_amount,
//             (IFNULL(rpl.receivable_amount,0) - SUM(IFNULL(rpl.payment_amount,0))) balance
//         FROM
//         receivable_payments_list rpl
//         INNER JOIN receivable_payments rp ON rp.payment_id = rpl.payment_id
//         LEFT JOIN customers c ON c.customer_id = rp.customer_id
//         WHERE rp.is_deleted=FALSE
//         AND rp.is_active=TRUE
//         AND rp.customer_id = $customer_id
//         AND MONTH(rp.date_paid) = MONTH(NOW()) AND YEAR(NOW())
//         GROUP BY rpl.journal_id) m HAVING balance > 0) as m

// UNION

// (SELECT * FROM
//         (SELECT
//             0 as group_status,
//             rp.*,
//             c.customer_name,
//             0 as sales_invoice_id,
//             rpl.service_invoice_id,
//             GROUP_CONCAT(rp.receipt_no) receipt_no_desc,
//             IFNULL(rpl.receivable_amount,0) receivable_amount,
//             SUM(IFNULL(rpl.payment_amount,0)) payment_amount,
//             (IFNULL(rpl.receivable_amount,0) - SUM(IFNULL(rpl.payment_amount,0))) balance
//         FROM
//         receivable_payments_list rpl
//         INNER JOIN receivable_payments rp ON rp.payment_id = rpl.payment_id
//         LEFT JOIN customers c ON c.customer_id = rp.customer_id
//         WHERE rp.is_deleted=FALSE
//         AND rp.is_active=TRUE
//         AND rp.customer_id = $customer_id
//         AND rpl.service_invoice_id != 0
//         AND MONTH(rp.date_paid) = MONTH(NOW()) AND YEAR(NOW())
//         GROUP BY rpl.service_invoice_id) m HAVING balance > 0) ";



// return $this->db->query($sql)->result();

//     }

    // function get_aging_payables()
    // {
    //     $sql = "SELECT
    //             n.supplier_name,
    //             SUM(n.days) days,
    //             SUM(n.current) current,
    //             SUM(n.30days) thirty_days,
    //             SUM(n.45days) fortyfive_days,
    //             SUM(n.60days) sixty_days,
    //             SUM(n.over_90days) over_ninetydays
    //             FROM
    //             (SELECT
    //             m.supplier_id,
    //             m.supplier_name,
    //             m.days,
    //             m.dr_invoice_no,
    //             IF(m.days >= 0 AND m.days < 30, m.balance,'') AS current,
    //             IF(m.days >= 30 AND m.days <= 44, m.balance,'') AS 30days,
    //             IF(m.days >= 45 AND m.days <= 59, m.balance,'') AS 45days,
    //             IF(m.days >= 60 AND m.days <= 89, m.balance,'') AS 60days,
    //             IF(m.days >= 90, m.balance,'') AS over_90days
    //             FROM
    //             (SELECT 
    //                 di.dr_invoice_no,
    //                 s.supplier_id,
    //                 s.supplier_name,
    //                 di.total_after_tax,
    //                 IFNULL(ppp.payment_amount,0) AS payment_amount,
    //                 ABS(DATEDIFF(NOW(),di.date_delivered)) AS days,
    //                 (IFNULL(di.total_after_tax,0) - IFNULL(ppp.payment_amount,0)) AS balance,
    //                 (CASE WHEN (IFNULL(ppp.payment_amount,0) < di.total_after_tax AND IFNULL(ppp.payment_amount,0) > 0) OR (IFNULL(ppp.payment_amount,0) = 0) THEN 'unpaid' ELSE 'paid' END) AS payment_status
    //             FROM
    //                 delivery_invoice di
    //                 LEFT JOIN suppliers s ON s.supplier_id = di.supplier_id
    //                 LEFT JOIN 
    //                 (SELECT pp.*, ppl.dr_invoice_id, SUM(ppl.payment_amount) payment_amount FROM
    //                 payable_payments pp
    //                 INNER JOIN payable_payments_list ppl ON ppl.payment_id = pp.payment_id
    //                 WHERE 
    //                 pp.is_deleted=FALSE AND pp.is_active=TRUE
    //                 GROUP BY ppl.dr_invoice_id) AS ppp
    //                 ON ppp.dr_invoice_id = di.dr_invoice_id
    //             WHERE
    //                 di.is_deleted = FALSE
    //                 AND di.is_active = TRUE) m
    //             ) n

    //             GROUP BY n.supplier_id";

    //         return $this->db->query($sql)->result();
    // }