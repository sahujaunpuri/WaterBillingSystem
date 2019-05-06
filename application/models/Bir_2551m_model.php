<?php
	class Bir_2551m_model extends CORE_Model {
	    protected  $table="form_2551m";
	    protected  $pk_id="form_2551m_id";

	    function __construct() {
	        parent::__construct();
	    }

	    function get_2551m_list($year=null,$form_2551m_id=null){
	    	$sql="SELECT 
				    form_2551m.*,
				    FORMAT(form_2551m.taxable_amount, 2) AS taxable_amount,
				    FORMAT(form_2551m.tax_rate, 2) AS tax_rate,
				    FORMAT(form_2551m.tax_due, 2) AS tax_due,
				    m.month_name
				FROM
				    form_2551m
				        LEFT JOIN
				    months m ON m.month_id = form_2551m.month_id
				WHERE
				    form_2551m.is_active = TRUE
				        AND form_2551m.is_deleted = FALSE
				        ".($year==null?"":" AND form_2551m.year = '$year'")."
				        ".($form_2551m_id==null?"":" AND form_2551m.form_2551m_id = '$form_2551m_id'")."
				        ";
	    	return $this->db->query($sql)->result();
	    }

	    function get_2551q_list($year=null,$quarter=null){
	    	$sql="SELECT 
			    m.quarterly,
			    (CASE
					WHEN m.quarterly = 1 THEN '1st Quarter'
			        WHEN m.quarterly = 2 THEN '2nd Quarter'
			        WHEN m.quarterly = 3 THEN '3rd Quarter'
			        WHEN m.quarterly = 4 THEN '4th Quarter'
			        ELSE 'N/A'
				END) as quarter,
    			form_2551m.year,
			    FORMAT(SUM(form_2551m.taxable_amount), 2) AS taxable_amount,
			    FORMAT(form_2551m.tax_rate, 2) AS tax_rate,
			    FORMAT(SUM(form_2551m.tax_due), 2) AS tax_due
			FROM
			    form_2551m
			        LEFT JOIN
			    months m ON m.month_id = form_2551m.month_id
			WHERE
			    form_2551m.is_active = TRUE
			        AND form_2551m.is_deleted = FALSE
			        ".($year==null?"":" AND form_2551m.year = '$year'")."
			        ".($quarter==null?"":" AND m.quarterly = '$quarter'")."
			        GROUP BY m.quarterly";
	    	return $this->db->query($sql)->result();
	    }

	    function get_2551m_quarterly($year,$quarter){
	    	$sql="SELECT 
					form_2551m.industry_classification,
				    form_2551m.atc,
				    FORMAT(form_2551m.taxable_amount, 2) AS taxable_amount,
				    FORMAT(form_2551m.tax_rate, 2) AS tax_rate,
				    FORMAT(form_2551m.tax_due, 2) AS tax_due
				FROM
				    form_2551m
				        LEFT JOIN
				    months m ON m.month_id = form_2551m.month_id
				WHERE
				    form_2551m.is_active = TRUE
				        AND form_2551m.is_deleted = FALSE
				        AND m.quarterly = $quarter
				        AND form_2551m.year = $year
					ORDER BY form_2551m.month_id";
	    	return $this->db->query($sql)->result();
	    }

	    function get_monthly_tax_return($month,$year){
	    	$sql="SELECT 
				    SUM(taxable_amnt) as taxable_amount
				FROM
				    (SELECT 
				        COALESCE(SUM(si.total_after_discount),0) as taxable_amnt
				    FROM
				        sales_invoice si
				    WHERE
				        si.is_journal_posted = TRUE
				        AND MONTH(si.date_invoice) = $month
				        AND YEAR(si.date_invoice) = $year
				        UNION ALL 
					SELECT 
						COALESCE(SUM(ci.total_after_discount),0) as taxable_amnt
				    FROM
				        cash_invoice ci
				    WHERE
				        ci.is_journal_posted = TRUE
				        AND MONTH(ci.date_invoice) = $month
				        AND YEAR(ci.date_invoice) = $year) AS main";
	    	return $this->db->query($sql)->result();
	    }

	    function validate_2551m($month,$year){
	    	$sql="SELECT * FROM form_2551m WHERE month_id = $month AND year = $year";
	    	return $this->db->query($sql)->result();
	    }	

	    function generate_sales_cash_invoice($month=null,$year,$quarter=null){
	    	$sql="SELECT 
				    ref_no, 
				    invoice_id,
                    DATE_FORMAT(date_invoice,'%m/%d/%Y') as date_invoice,
                    department,
                    customer,
                    remarks,
				    FORMAT(amount,2) as amount,
                    invoice_type,
                    months
				FROM
				    (SELECT 
				        si.sales_inv_no as ref_no,
						si.total_after_discount as amount,
						si.sales_invoice_id as invoice_id,
                        c.customer_name as customer,
                        si.date_invoice as date_invoice,
                        d.department_name as department,
                        si.remarks,
                        'si' as invoice_type,
						m.month_name as months,
                        m.month_id 
				    FROM
				        sales_invoice si
						LEFT JOIN customers c ON c.customer_id = si.customer_id
                        LEFT JOIN departments d ON d.department_id = si.department_id
                        LEFT JOIN months m ON m.month_id = MONTH(si.date_invoice)
				    WHERE
				        si.is_journal_posted = TRUE
                        ".($month==null?"":" AND MONTH(si.date_invoice) = $month")."
                        ".($quarter==null?"":" AND m.quarterly = $quarter")."
				        AND YEAR(si.date_invoice) = $year
				        UNION ALL 
					SELECT 
						ci.cash_inv_no as ref_no,
						ci.total_after_discount as amount,
						ci.cash_invoice_id as invoice_id,
                        c.customer_name as customer,
                        ci.date_invoice as date_invoice,
                        d.department_name as department,
                        ci.remarks,
                        'ci' as invoice_type,
						m.month_name as months,
                        m.month_id
				    FROM
				        cash_invoice ci
                        LEFT JOIN customers c ON c.customer_id = ci.customer_id
                        LEFT JOIN departments d ON d.department_id = ci.department_id
                        LEFT JOIN months m ON m.month_id = MONTH(ci.date_invoice)
				    WHERE
				        ci.is_journal_posted = TRUE
                        ".($month==null?"":" AND MONTH(ci.date_invoice) = $month")."
                        ".($quarter==null?"":" AND m.quarterly = $quarter")."
				        AND YEAR(ci.date_invoice) = $year) AS main
                        ORDER BY month_id ASC, invoice_type DESC, ref_no DESC";
				        return $this->db->query($sql)->result();
	    }

        function get_2307($startDate,$endDate,$supplier_id) {
        $sql="SELECT 
				((IFNULL(s.tax_output,0) /100)* ji.amount) as tax_deducted,
				IFNULL(s.tax_output,0) as tax_output,
				ji.*
				 FROM journal_info ji
				LEFT JOIN  suppliers s ON s.supplier_id = ji.supplier_id
				WHERE 

				ji.supplier_id = $supplier_id
				AND  ji.is_active = TRUE AND ji.is_deleted = FALSE AND ji.book_type = 'CDJ'
				AND ji.date_txn BETWEEN '$startDate' AND '$endDate'
          ";
            return $this->db->query($sql)->result();
    	}

        function get_2307_files($month,$year,$supplier_id) {
        $sql="
        SELECT 
				((IFNULL(s.tax_output,0) /100)* ji.amount) as tax_deducted,
				IFNULL(s.tax_output,0) as tax_output,
				ji.*
				 FROM journal_info ji
				LEFT JOIN  suppliers s ON s.supplier_id = ji.supplier_id
				WHERE 

				ji.supplier_id = $supplier_id
				AND  ji.is_active = TRUE AND ji.is_deleted = FALSE AND ji.book_type = 'CDJ'
				AND MONTH(ji.date_txn) = '$month' AND YEAR (ji.date_txn) = '$year' 
          ";
            return $this->db->query($sql)->result();
    	}

        function get_2307_validate($month,$year,$supplier_id) {
        $sql="
       SELECT f.* FROM form_2307 f
		WHERE MONTH(f.date)  = $month AND year(f.date) = $year
		AND supplier_id = $supplier_id AND f.is_active = TRUE AND f.is_deleted = FALSE
          ";
            return $this->db->query($sql)->result();
    	}
	}
?>