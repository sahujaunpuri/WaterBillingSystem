<?php

class Trans_model extends CORE_Model {
    protected  $table="trans";
    protected  $pk_id="trans_id";

    function __construct() {
        parent::__construct();
    }

 function trail($trans_type_id=null,$trans_key_id=null,$startDate=null,$endDate=null,$user_id=null){
        $sql="

			SELECT t.*,tk.trans_key_desc,tt.trans_type_desc,ua.user_fname,ua.user_lname FROm trans t 
			LEFT JOIN trans_key tk ON tk.trans_key_id = t.trans_key_id
			LEFT JOIN trans_type tt ON tt.trans_type_id = t.trans_type_id
			LEFT JOIN user_accounts ua ON ua.user_id = t.user_id

			WHERE CAST(t.trans_date as date)  BETWEEN '$startDate' AND '$endDate'

            ".($trans_type_id==null?"":" AND t.trans_type_id = '$trans_type_id'")."
            ".($trans_key_id==null?"":" AND t.trans_key_id = '$trans_key_id'")."
            ".($user_id==null?"":" AND t.user_id = '$user_id'")."


            ORDER BY t.trans_id ASC
        ";
        return $this->db->query($sql)->result();

    }
}



?>