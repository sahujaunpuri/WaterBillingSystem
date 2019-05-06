<?php

class Hotel_integration_model extends CORE_Model{

    protected  $table="hotel_settings"; //table name
    protected  $pk_id="hotel_settings_id"; //primary key id


    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }


}


?>