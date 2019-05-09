<?php

class Matrix_residential_items_model extends CORE_Model {
    protected  $table="matrix_residential_items";
    protected  $pk_id="matrix_residential_item_id";
    protected  $fk_id = "matrix_residential_id";

    function __construct() {
        parent::__construct();
    }

}
?>