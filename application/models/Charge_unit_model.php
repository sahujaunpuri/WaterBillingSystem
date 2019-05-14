<?php

class Charge_unit_model extends CORE_Model {
    protected  $table="charge_unit";
    protected  $pk_id="charge_unit_id";

    function __construct() {
        parent::__construct();
    }

    function get_charge_unit_list($charge_unit_id=null){
        $sql="  SELECT
                  a.*
                FROM
                  charge_unit as a
                WHERE
                    a.is_deleted=FALSE AND a.is_active=TRUE
                ".($charge_unit_id==null?"":" AND a.charge_unit_id=$charge_unit_id")."
            ";
        return $this->db->query($sql)->result();
    }
}
?>