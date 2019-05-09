<?php

class Matrix_commercial_items_model extends CORE_Model {
    protected  $table="matrix_commercial_items";
    protected  $pk_id="matrix_commercial_item_id";
    protected  $fk_id = "matrix_commercial_id";

    function __construct() {
        parent::__construct();
    }

}
?>