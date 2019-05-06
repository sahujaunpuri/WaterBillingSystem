<?php
	class Bir_2307_model extends CORE_Model {
	    protected  $table="form_2307";
	    protected  $pk_id="form_2307_id";

	    function __construct() {
	        parent::__construct();
	    }

	    function get_2307_list($month=null,$year=null,$journal_id=null){
	    	$sql="SELECT 
				    form_2307.*,
				    FORMAT(form_2307.gross_amount, 2) as gross_amount,
				    FORMAT(form_2307.deducted_amount, 2) as deducted_amount,
				    ji.date_txn,
				    m.quarter
				FROM
				    form_2307 
				    LEFT JOIN journal_info ji ON ji.journal_id = form_2307.journal_id
				    LEFT JOIN months m ON m.month_id = MONTH(ji.date_txn)
				    WHERE 
				    	form_2307.is_active = TRUE
				        AND form_2307.is_deleted = FALSE
				        ".($month==null?"":" AND MONTH(ji.date_txn) = $month")."
				        ".($year==null?"":" AND YEAR(ji.date_txn) = $year")."
				        ".($journal_id==null?"":" AND form_2307.journal_id = $journal_id")."
				        ";
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