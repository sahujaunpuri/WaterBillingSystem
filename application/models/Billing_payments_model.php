<?php

class Billing_payments_model extends CORE_Model{

    protected  $table="billing_payments"; //table name
    protected  $pk_id="billing_payment_id"; //primary key id


    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
 }