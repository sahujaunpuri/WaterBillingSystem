<?php

class Ref_discount_model extends CORE_Model {
    protected  $table="refdiscounttype";
    protected  $pk_id="discount_type_id";

    function __construct() {
        parent::__construct();
    }

    function get_discount_list($discount_type_id=null){
        $sql="  SELECT
                  a.*
                FROM
                  refdiscounttype as a
                WHERE
                    a.is_deleted=FALSE 
                    AND  a.discount_type_id != 2
                ".($discount_type_id==null?"":" AND a.discount_type_id=$discount_type_id")."
                ORDER BY a.discount_type_id ASC
            ";
        return $this->db->query($sql)->result();
    }
}
?>