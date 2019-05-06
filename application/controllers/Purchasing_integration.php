<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchasing_integration extends CORE_Controller
{

    function __construct() {
        parent::__construct('');
        $this->validate_session();
        $this->load->model(array(
                'Account_title_model',
                'Account_integration_model',
                'Purchasing_integration_model',
                'Users_model',
                'Sched_expense_integration',
                'Departments_model',
                'Customers_model',
                'Trans_model',
                'Suppliers_model'

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
        $data['title'] = 'Purchasing Integration';

        $data['accounts'] = $this->Account_title_model->get_list(array('is_deleted'=>FALSE));
        $current_accounts= $this->Purchasing_integration_model->get_list();
        $data['current_accounts'] =$current_accounts[0];
        $data['departments'] = $this->Departments_model->get_list(array('is_active'=>TRUE, 'is_deleted'=>FALSE));
        $data['customers']=$this->Customers_model->get_list('is_active=TRUE AND is_deleted=FALSE');
        $data['suppliers']=$this->Suppliers_model->get_list('is_active=TRUE AND is_deleted=FALSE');
        (in_array('6-12',$this->session->user_rights)? 
        $this->load->view('purchasing_integration_view', $data)
        :redirect(base_url('dashboard')));
        

    }


    public function transaction($txn=null){
        switch($txn){


            case 'save':
                $m_integration=$this->Purchasing_integration_model;

                $m_integration->delete(1); //delete it first

                $m_integration->purchasing_integration_id=1;

                $m_integration->iss_supplier_id=$this->input->post('iss_supplier_id',TRUE);
                $m_integration->iss_debit_id=$this->input->post('iss_debit_id',TRUE);
                // $m_integration->iss_credit_id=$this->input->post('iss_credit_id',TRUE);

                $m_integration->adj_supplier_id=$this->input->post('adj_supplier_id',TRUE);
                $m_integration->adj_debit_id=$this->input->post('adj_debit_id',TRUE);
                $m_integration->adj_credit_id=$this->input->post('adj_credit_id',TRUE);


                $m_integration->save();

                $response['stat']="success";
                $response['title']="Success!";
                $response['msg']="Pos Accounts successfully integrated.";

                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=2; //CRUD
                $m_trans->trans_type_id=58; // TRANS TYPE
                $m_trans->trans_log='Updated System Purchasing Configuration';
                $m_trans->save();
                echo json_encode($response);

                break;


         
        }





    }


    function get_response_rows($filter){
        $m_acc_period=$this->Accounting_period_model;

        return $m_acc_period->get_list(
            $filter,
            array(
                'CONCAT(DATE_FORMAT(period_start,"%M %d, %Y")," to ",DATE_FORMAT(period_end,"%M %d, %Y")) as date_covered',
                'accounting_period.*',
                'CONCAT_WS(" ",ua.user_fname,ua.user_lname) as user'

            ),
            array(
                array('user_accounts as ua','ua.user_id=accounting_period.closed_by_user','left')
            ),

            'accounting_period.accounting_period_id DESC'
        );
    }




}
