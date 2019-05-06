<?php

class Cash_invoice_items_model extends CORE_Model
{
    protected $table = "cash_invoice_items";
    protected $pk_id = "cash_item_id";
    protected $fk_id = "cash_invoice_id";

    function __construct()
    {
        parent::__construct();
    }

}


?>
