<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cost_of_goods_sold extends CORE_Controller {
    function __construct() {
        parent::__construct('');
        $this->validate_session();
        $this->load->model('Departments_model');
        $this->load->model('Users_model');
        $this->load->model('Trans_model');
        $this->load->model('Cost_of_goods_sold_model');
        $this->load->model('Company_model');
    }

    public function index() {
        $this->Users_model->validate();
        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', TRUE);
        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', TRUE);
        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', TRUE);
        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', TRUE);
        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', TRUE);
        $data['title'] = 'Cost of Goods Sold';
        $data['departments']=$this->Departments_model->get_list('is_deleted=0');
        (in_array('9-12',$this->session->user_rights)? 
        $this->load->view('cost_of_goods_sold_v2', $data)
        :redirect(base_url('dashboard')));
        
    }

    function transaction($txn = null) {
        switch ($txn) {

            case 'purchases':
            $start=date('Y-m-d',strtotime($this->input->get('start',TRUE)));
            $end=date('Y-m-d',strtotime($this->input->get('end',TRUE)));
            $depid=$this->input->get('depid',TRUE);
            $response['data'] = $this->Cost_of_goods_sold_model->get_purchases_for_cogs($depid,$start,$end);
            echo json_encode($response);
            break;

            case 'merchandise-inventory-beginning':
            $start=date('Y-m-d',strtotime($this->input->get('start',TRUE)));
            $depid=$this->input->get('depid',TRUE);
            $new_date=date('Y-m-d',strtotime ( '-1 day' , strtotime($start))); // because the filter is <= DATE
            $response['data'] = $this->Cost_of_goods_sold_model->get_merchandise_inventory_for_cogs($depid,$new_date);
            echo json_encode($response);
            break;


            case 'merchandise-inventory-ending':
            $end=date('Y-m-d',strtotime($this->input->get('end',TRUE)));
            $depid=$this->input->get('depid',TRUE);
            $response['data'] = $this->Cost_of_goods_sold_model->get_merchandise_inventory_for_cogs($depid,$end);
            echo json_encode($response);
            break;



            case 'cogs-print': 
            $start=date('Y-m-d',strtotime($this->input->get('start',TRUE)));
            $end=date('Y-m-d',strtotime($this->input->get('end',TRUE)));
            $depid=$this->input->get('depid',TRUE);

            $new_date=date('Y-m-d',strtotime ( '-1 day' , strtotime($start))); // because the filter is <= DATE
            $data['beginning'] = $this->Cost_of_goods_sold_model->get_merchandise_inventory_for_cogs($depid,$new_date);
            $data['ending'] = $this->Cost_of_goods_sold_model->get_merchandise_inventory_for_cogs($depid,$end);
            $data['purchases'] = $this->Cost_of_goods_sold_model->get_purchases_for_cogs($depid,$start,$end);
            $company=$this->Company_model->get_list();
            $data['company_info']=$company[0];
            echo $this->load->view('template/cost_of_goods_sold_content',$data,TRUE);

            break;
        }
    }
}
