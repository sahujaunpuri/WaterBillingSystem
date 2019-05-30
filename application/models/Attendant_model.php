<?php

class Attendant_model extends CORE_Model{

    protected  $table="attendant"; //table name
    protected  $pk_id="attendant_id"; //primary key id

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

}

?>