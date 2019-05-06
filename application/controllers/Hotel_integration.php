<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hotel_integration extends CORE_Controller
{

    function __construct() {
        parent::__construct('');
        $this->validate_session();
        $this->load->model(array(
                'Account_title_model',
                'Account_integration_model',
                'Hotel_integration_model',
                'Users_model',
                'Sched_expense_integration',
                'Departments_model',
                'Customers_model',


            )

        );
    }

    public function index() {
        $this->Users_model->validate();
        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', TRUE);
        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', TRUE);
        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', TRUE);
        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', TRUE);
        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', TRUE);
        $data['title'] = 'Hotel Integration';

        $data['accounts'] = $this->Account_title_model->get_list(array('is_deleted'=>FALSE));
        $poleng_villa_accounts= $this->Hotel_integration_model->get_list(2);
        $poleng_apartment_accounts= $this->Hotel_integration_model->get_list(3);
        $red_rose_accounts= $this->Hotel_integration_model->get_list(4);
        $hayvenhurst_accounts= $this->Hotel_integration_model->get_list(5);
        $data['poleng_villa_accounts'] =$poleng_villa_accounts[0];
        $data['poleng_apartment_accounts'] =$poleng_apartment_accounts[0];
        $data['red_rose_accounts'] =$red_rose_accounts[0];
        $data['hayvenhurst_accounts'] =$hayvenhurst_accounts[0];
        $data['departments'] = $this->Departments_model->get_list(array('is_active'=>TRUE, 'is_deleted'=>FALSE));
        $data['customers'] = $this->Customers_model->get_list(array('is_active'=>TRUE, 'is_deleted'=>FALSE));


        // (in_array('6-13',$this->session->user_rights)? 
        $this->load->view('hotel_integration_view', $data);
        // :redirect(base_url('dashboard')));
        

    }


    public function transaction($txn=null){
        switch($txn){
            case 'save':
                $m_integration=$this->Hotel_integration_model;
                $department_id =$this->input->post('department_id'); // department id as Hotel_settings_id
                $m_integration->room_sales_id=$this->input->post('room_sales_id',TRUE);
                $m_integration->bar_sales_id=$this->input->post('bar_sales_id',TRUE);
                $m_integration->other_sales_id=$this->input->post('other_sales_id',TRUE);
                $m_integration->adv_sales_id=$this->input->post('adv_sales_id',TRUE);
                $m_integration->adv_cash_id=$this->input->post('adv_cash_id',TRUE);
                $m_integration->adv_check_id=$this->input->post('adv_check_id',TRUE);
                $m_integration->adv_card_id=$this->input->post('adv_card_id',TRUE);
                $m_integration->adv_charge_id=$this->input->post('adv_charge_id',TRUE);
                $m_integration->adv_bank_id=$this->input->post('adv_bank_id',TRUE);
                $m_integration->cash_id=$this->input->post('cash_id',TRUE);
                $m_integration->check_id=$this->input->post('check_id',TRUE);
                $m_integration->card_id=$this->input->post('card_id',TRUE);
                $m_integration->charge_id=$this->input->post('charge_id',TRUE);
                $m_integration->bank_id=$this->input->post('bank_id',TRUE);
                $m_integration->customer_id=$this->input->post('customer_id',TRUE);
                $m_integration->modify($department_id);

                $response['stat']="success";
                $response['title']="Success!";
                $response['msg']="Hotel Accounts successfully integrated.";

                echo json_encode($response);

                break;

        }
    }
}
