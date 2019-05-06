<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Truncate extends CORE_Controller {

    function __construct() {
        parent::__construct('');
        // $this->validate_session();
        $this->load->model('Suppliers_model');
        $this->load->model('Supplier_photos_model');
        $this->load->model('Tax_types_model');
        $this->load->model('Users_model');
        $this->load->model('Truncate_model');
        $this->load->model('Account_title_model');
        $this->load->model('Account_integration_model');
        $this->load->model('Purchasing_integration_model');
        $this->load->model('Company_model');
        $this->load->model('Initial_setup_model');


    }

    public function index() {
        // $this->Users_model->validate();
        $data['_def_css_files']=$this->load->view('template/assets/css_files','',TRUE);
        $data['_def_js_files']=$this->load->view('template/assets/js_files','',TRUE);
        $data['title']='Truncate Tables';
        $data['tax_type']=$this->Tax_types_model->get_list();
        $truncate = $this->Truncate_model->get_current_counts();
        $data['current_count'] = $truncate[0];       
        // (in_array('6-1',$this->session->user_rights)? 
        $this->load->view('truncate_view',$data);
        // :redirect(base_url('dashboard')));
        
    }

    function validate_truncation(){
        $login =$this->input->post('username');
        $password =$this->input->post('password');
        if(sha1($login) == '70b210b445dd7efa2a9a751f6fc56a84ca5535e9' && $password == '2018'){
            $response['title']='Success!';
            $response['stat']='success';                
            $response['msg']='Authorization Success.'; 
        }else{                
            $response['title']='Error!';
            $response['stat'] = 'error';               
            $response['msg']='Invalid Details.'; 

        }
            echo json_encode($response);
    }

    function reset_default_coa(){

        $m_account_titles = $this->Account_title_model;
        $m_account_titles->restore_default_account_title();

            $response['title']='Success!';
            $response['stat'] = 'success';               
            $response['msg']='Successfully reset Chart of Accounts to default.'; 

            echo json_encode($response);
    }

    function reset_default_users(){

            $this->db->truncate('user_accounts');
            $m_users=$this->Users_model;
            $m_users->create_default_user();
            $response['title']='Success!';
            $response['stat'] = 'success';               
            $response['msg']='Successfully Reset User Accounts to Default.'; 

            echo json_encode($response);
    }

    function reset_initial_setup(){

            $m_initial=$this->Initial_setup_model;
            $m_initial->setup_general_configuration=0;
            $m_initial->setup_company_info=0;
            $m_initial->setup_user_account=0;
            $m_initial->setup_complete=0;
            $m_initial->modify(1);
            $response['title']='Success!';
            $response['stat'] = 'success';               
            $response['msg']='Successfully Reset Initial Setup.'; 

            echo json_encode($response);
    }

    function reset_default_configuration(){

                $m_integration=$this->Account_integration_model;

                //suppliers
                $m_integration->input_tax_account_id=50;
                $m_integration->payable_account_id=16;
                $m_integration->payable_discount_account_id=53;
                $m_integration->payment_to_supplier_id=1;

                //customers
                $m_integration->output_tax_account_id=48;
                $m_integration->receivable_account_id=5;
                $m_integration->receivable_discount_account_id=52;
                $m_integration->payment_from_customer_id=1;

                $m_integration->retained_earnings_id=18;
                $m_integration->petty_cash_account_id=3;

                $m_integration->sales_invoice_inventory=1;
                $m_integration->cash_invoice_inventory=1;

                $m_integration->depreciation_expense_debit_id=7;
                $m_integration->depreciation_expense_credit_id=8;
                $m_integration->cash_invoice_debit_id=1;
            
                $m_integration->modify(1);


                $m_integration_purchasing=$this->Purchasing_integration_model;
                $m_integration_purchasing->iss_debit_id=51;
                $m_integration_purchasing->adj_debit_id=51;
                $m_integration_purchasing->adj_credit_id=1;
                $m_integration_purchasing->modify(1);

                $response['title']='Success!';
                $response['stat'] = 'success';               
                $response['msg']='Successfully Reset General Configuration to Default.'; 

            echo json_encode($response);
    }

    function reset_default_company(){
                $m_company=$this->Company_model;
                $m_company->delete(1);
                $m_company->company_id=1;
                $m_company->company_name='';
                $m_company->company_address='';
                $m_company->email_address='';
                $m_company->mobile_no='';
                $m_company->landline='';
                $m_company->tin_no='';
                $m_company->registered_to='';
                $m_company->logo_path='assets/img/default-user-image.png';
                $m_company->tax_type_id='';
                $m_company->rdo_no='';
                $m_company->nature_of_business='';
                $m_company->business_type='';
                $m_company->save();

                $response['title']='Success!';
                $response['stat'] = 'success';               
                $response['msg']='Successfully Reset Company Information to Default.'; 

            echo json_encode($response);
    }

    function transaction($txn=null) {
        switch($txn) {

            case 'truncate-journal':
                $journal=$this->input->post('journal',TRUE);
                for($i=0;$i<count($journal);$i++) { $this->db->truncate($journal[$i]); }    

                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Journal Tables Successfully Truncated.'; 
                echo json_encode($response);
            break;

            case 'truncate-invoices':
                $invoice=$this->input->post('invoice',TRUE);
                for($i=0;$i<count($invoice);$i++) { $this->db->truncate($invoice[$i]); }    

                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Invoice Tables Successfully Truncated.'; 
                echo json_encode($response);
            break;

            case 'truncate-payments':
                $payment=$this->input->post('payment',TRUE);
                for($i=0;$i<count($payment);$i++) { $this->db->truncate($payment[$i]); }    

                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Payment Tables Successfully Truncated.'; 
                echo json_encode($response);
            break;

            case 'truncate-masterfiles':
                $masterfiles=$this->input->post('masterfiles',TRUE);
                for($i=0;$i<count($masterfiles);$i++) { $this->db->truncate($masterfiles[$i]); }    

                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Masterfiles Tables Successfully Truncated.'; 
                echo json_encode($response);
            break;

            case 'truncate-references':
                $references=$this->input->post('references',TRUE);
                for($i=0;$i<count($references);$i++) { $this->db->truncate($references[$i]); }    

                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='References Tables Successfully Truncated.'; 
                echo json_encode($response);
            break;

            case 'truncate-accounting':
                $accounting=$this->input->post('accounting',TRUE);
                for($i=0;$i<count($accounting);$i++) { $this->db->truncate($accounting[$i]); }    

                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Accounting Tables Successfully Truncated.'; 
                echo json_encode($response);
            break;

            case 'truncate-users':
                $users=$this->input->post('users',TRUE);
                for($i=0;$i<count($users);$i++) { $this->db->truncate($users[$i]); }    

                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Users Tables Successfully Truncated.'; 
                echo json_encode($response);
            break;

        }
    }
}
