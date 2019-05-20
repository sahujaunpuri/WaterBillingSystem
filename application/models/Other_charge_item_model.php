<?php

class Other_charge_item_model extends CORE_Model
{
    protected $table = "other_charges_items";
    protected $pk_id = "other_charges_item_id";
    protected $fk_id = "other_charge_id";

    function __construct()
    {
        parent::__construct();
    }


}


?>