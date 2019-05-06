<?php

class Commercial_invoice_items_model extends CORE_Model
{
    protected $table = "commercial_invoice_items";
    protected $pk_id = "commercial_item_id";
    protected $fk_id = "commercial_invoice_id";

    function __construct()
    {
        parent::__construct();
    }

}


?>
