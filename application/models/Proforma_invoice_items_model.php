<?php

class Proforma_invoice_items_model extends CORE_Model
{
    protected $table = "proforma_invoice_items";
    protected $pk_id = "proforma_item_id";
    protected $fk_id = "proforma_invoice_id";

    function __construct()
    {
        parent::__construct();
    }

}


?>
