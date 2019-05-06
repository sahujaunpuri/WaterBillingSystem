<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ref_discounts extends CORE_Controller
{

    function __construct() {
        parent::__construct('');
        $this->validate_session();
        $this->load->model('Ref_discount_model');
    }

    public function index() {
        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', true);
        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', true);
        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', true);
        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', true);
        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', true);
        $data['title'] = 'POS Discount Types';

        // $this->load->view('cards_view', $data);
    }

    function transaction($txn = null) {
        switch ($txn) {
            case 'list':
                $m_discounts = $this->Ref_discount_model;
                $response['data'] = $m_discounts->get_discount_list();
                echo json_encode($response);
                break;
        }
    }
}
