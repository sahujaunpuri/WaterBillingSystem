<?php

class Issuance_department_item_model extends CORE_Model {
    protected  $table="issuance_department_items";
    protected  $pk_id="issuance_department_item_id";
    protected  $fk_id="issuance_department_id";

    function __construct() {
        parent::__construct();
    }


}



?>