<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Trail extends CORE_Controller
{

    function __construct() {
        parent::__construct('');
        $this->validate_session();
        $this->load->model('Users_model');
        $this->load->model('Trans_model');
        $this->load->model('Trans_type_model');
        $this->load->model('Trans_key_model');


                   $this->load->library('excel');

    }

    public function index() {
        $this->Users_model->validate();
        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', TRUE);
        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', TRUE);
        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', TRUE);
        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', TRUE);
        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', TRUE);
        $data['title'] = 'Audit Trail';


        $data['trans_type']=$this->Trans_type_model->get_list();
        $data['trans_key']=$this->Trans_key_model->get_list();
        $data['users']=$this->Users_model->get_user_list();

        (in_array('6-13',$this->session->user_rights)? $this->load->view('trail_view', $data)  :redirect(base_url('dashboard')));

        
    }

    function transaction($txn = null) {
        switch ($txn) {
            case 'list':
                $m_trans_model = $this->Trans_model;
                $trans_type_id = $this->input->get('trans_type_id');
                $trans_key_id = $this->input->get('trans_key_id');
                $user_id = $this->input->get('user_id');
                $start_date=date('Y-m-d',strtotime($this->input->get('start_date',TRUE)));
                $end_date=date('Y-m-d',strtotime($this->input->get('end_date',TRUE)));
                $response['data']=$m_trans_model->trail($trans_type_id,$trans_key_id,$start_date,$end_date,$user_id);
                echo json_encode($response);
                break;

        }
    }
}
