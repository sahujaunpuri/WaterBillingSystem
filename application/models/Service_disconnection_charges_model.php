<?php

class Service_disconnection_charges_model extends CORE_Model
{
    protected $table = "service_disconnection_charges";
    protected $pk_id = "service_disconnection_charge_id";
    protected $fk_id = "disconnection_id";

    function __construct()
    {
        parent::__construct();
    }


}


?>