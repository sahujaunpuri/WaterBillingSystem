<?php

class Delivery_receipt_item_model extends CORE_Model
{
    protected $table = "delivery_receipt_items";
    protected $pk_id = "delivery_receipt_item_id";
    protected $fk_id = "delivery_receipt_id";

    function __construct()
    {
        parent::__construct();
    }
}


?>