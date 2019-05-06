<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pos extends CORE_Controller {

    function __construct() {
        parent::__construct('');
        // $this->validate_session();
        $this->load->model('Customers_model');


    }      


    public function index() {
        // $this->Users_model->validate();
        $data['_def_css_files']=$this->load->view('template/assets/css_files','',TRUE);
        $data['_def_js_files']=$this->load->view('template/assets/js_files','',TRUE);
        $data['title']='POINT OF SALES';
        $data['customers']=$this->Customers_model->get_list(
            array('customers.is_active'=>TRUE,'customers.is_deleted'=>FALSE)
        );
        $this->load->view('pos_view',$data);
        
    }


    function transaction($txn=null) {
        switch($txn) {

           

        }
    }
}
