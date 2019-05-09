<?php

class Contract_type_model extends CORE_Model{

    protected  $table="contract_types"; //table name
    protected  $pk_id="contract_type_id"; //primary key id

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }


}

?>