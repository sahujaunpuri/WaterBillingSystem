<?php

class Service_connection_model extends CORE_Model{

    protected  $table="service_connection"; //table name
    protected  $pk_id="connection_id"; //primary key id

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }


}

?>