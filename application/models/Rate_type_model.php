<?php

class Rate_type_model extends CORE_Model{

    protected  $table="rate_types"; //table name
    protected  $pk_id="rate_type_id"; //primary key id

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

}

?>