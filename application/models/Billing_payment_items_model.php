<?php

class Billing_payment_items_model extends CORE_Model{

    protected  $table="billing_payment_items"; //table name
    protected  $pk_id="billing_payment_item_id"; //table name
    protected  $fk_id="billing_payment_id"; //primary key id


    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
 }

 ?>