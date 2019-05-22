<?php

class Disconnection_reason_model extends CORE_Model{

    protected  $table="disconnection_reason"; //table name
    protected  $pk_id="disconnection_reason_id"; //primary key id


    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

}

?>