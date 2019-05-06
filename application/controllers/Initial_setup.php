<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Initial_setup extends CORE_Controller
{

    function __construct() {
        parent::__construct('');
        // $this->validate_session();
        $this->load->model('Company_model');
        $this->load->model('Tax_model');
        $this->load->model('Users_model');
        $this->load->model('Trans_model');
        $this->load->model('Account_title_model');
        $this->load->model('Account_integration_model');
        $this->load->model('User_groups_model');
        $this->load->model('Initial_setup_model');
        $this->load->model('Purchasing_integration_model');

    }

    public function index() {
        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', TRUE);
        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', TRUE);
        $data['title'] = 'Initial Setup Information';
        $data['tax_type']=$this->Tax_model->get_list(array('is_deleted'=>FALSE));
        $data['accounts'] = $this->Account_title_model->get_list(array('is_deleted'=>FALSE));
        $data['user_groups']=$this->User_groups_model->get_list(array('is_deleted'=>0));
        // Current Accounts for General Configuration
        $current_accounts= $this->Account_integration_model->get_list();
        $data['current_accounts'] =$current_accounts[0];
        // Current Accounts for Purchasing
        $current_accounts_purchasing= $this->Purchasing_integration_model->get_list();
        $data['current_accounts_purchasing'] =$current_accounts_purchasing[0];
        $company=$this->Company_model->get_list();
        $data['company']=$company[0];

        $initial= $this->Initial_setup_model->get_list();
        $data['initialize'] = $initial[0];
        if($initial[0]->setup_complete == TRUE){ redirect(base_url('Login')); }else { $this->load->view('initial_setup_view', $data); }
                
    }

    function transaction($txn = null) {

        switch($txn){

            case 'create_user':
                $m_company=$this->Company_model;
                $company=$m_company->get_list('company_id=1');

                $businesstype= $company[0]->business_type;

                if ($businesstype == 1){ $limit = 100; }
                if ($businesstype == 2){ $limit = 100; }
                if ($businesstype == 3){ $limit = 100; }

        
                $m_users=$this->Users_model;
                if(count($m_users->get_user_list()) >= $limit){

                    $response['title']='Error!';
                    $response['stat']='error';
                    $response['msg']='Limit reached.';
                    echo json_encode($response);
                    exit;
                }

                $user_name=$this->input->post('user_name',TRUE);




                if(count($m_users->get_list(array(
                    'user_accounts.user_name'=>$user_name
                )))>0){

                    $response['title']='Error!';
                    $response['stat']='error';
                    $response['msg']='Sorry, username already exist.';
                    echo json_encode($response);
                    exit;
                }


                $m_users->user_name=$this->input->post('user_name',TRUE);
                $m_users->user_pword=sha1($this->input->post('user_pword',TRUE));
                $m_users->user_lname=$this->input->post('user_lname',TRUE);
                $m_users->user_fname=$this->input->post('user_fname',TRUE);
                $m_users->user_mname=$this->input->post('user_mname',TRUE);
                $m_users->user_address=$this->input->post('user_address',TRUE);
                $m_users->user_email=$this->input->post('user_email',TRUE);
                $m_users->user_mobile=$this->input->post('user_mobile',TRUE);
                $m_users->user_telephone=$this->input->post('user_telephone',TRUE);
                $m_users->user_bdate=date('Y-m-d',strtotime($this->input->post('user_bdate',TRUE)));
                $m_users->user_group_id=$this->input->post('user_group_id',TRUE);
                $m_users->photo_path=$this->input->post('photo_path',TRUE);

                $m_users->set('date_created','NOW()');
                $m_users->posted_by_user=$this->session->user_id;

                $m_users->save();

                $user_account_id=$m_users->last_insert_id();

                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='User account information successfully created.';
                $response['row_added']=$m_users->get_user_list($user_account_id);

                $m_initial = $this->Initial_setup_model;
                $m_initial->setup_user_account = 1;
                $m_initial->setup_complete = 1;
                $m_initial->modify(1);

                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=1; //CRUD
                $m_trans->trans_type_id=43; // TRANS TYPE
                $m_trans->trans_log='Created User: '.$this->input->post('user_name',TRUE);
                $m_trans->save();

                echo json_encode($response);

                break;

            case 'save-integration':
                $m_integration=$this->Account_integration_model;

                $m_integration->delete(1); //delete it first
                $m_integration->integration_id=1;

                //suppliers
                $m_integration->input_tax_account_id=$this->input->post('input_tax_account_id',TRUE);
                $m_integration->payable_account_id=$this->input->post('payable_account_id',TRUE);
                $m_integration->payable_discount_account_id=$this->input->post('payable_discount_account_id',TRUE);
                $m_integration->payment_to_supplier_id=$this->input->post('payment_to_supplier_id',TRUE);

                //customers
                $m_integration->output_tax_account_id=$this->input->post('output_tax_account_id',TRUE);
                $m_integration->receivable_account_id=$this->input->post('receivable_account_id',TRUE);
                $m_integration->receivable_discount_account_id=$this->input->post('receivable_discount_account_id',TRUE);
                $m_integration->payment_from_customer_id=$this->input->post('payment_from_customer_id',TRUE);

                $m_integration->retained_earnings_id=$this->input->post('retained_earnings_id',TRUE);
                $m_integration->petty_cash_account_id=$this->input->post('petty_cash_account_id',TRUE);

                $m_integration->sales_invoice_inventory=$this->get_numeric_value($this->input->post('sales_invoice_inventory',TRUE));
                $m_integration->cash_invoice_inventory=$this->get_numeric_value($this->input->post('cash_invoice_inventory',TRUE));

                $m_integration->depreciation_expense_debit_id=$this->input->post('depreciation_expense_debit_id',TRUE);
                $m_integration->depreciation_expense_credit_id=$this->input->post('depreciation_expense_credit_id',TRUE);
                $m_integration->cash_invoice_debit_id=$this->input->post('cash_invoice_debit_id',TRUE);
                $m_integration->cash_invoice_credit_id=$this->input->post('cash_invoice_credit_id',TRUE);              
                $m_integration->save();

                //Purchasing Integration 
                $m_integration_purchasing=$this->Purchasing_integration_model;
                $m_integration_purchasing->iss_debit_id=$this->input->post('iss_debit_id',TRUE);
                $m_integration_purchasing->adj_debit_id=$this->input->post('adj_debit_id',TRUE);
                $m_integration_purchasing->adj_credit_id=$this->input->post('adj_credit_id',TRUE);
                $m_integration_purchasing->modify(1);


                $response['stat']="success";
                $response['title']="Success!";
                $response['msg']="Account successfully integrated.";

                $m_initial = $this->Initial_setup_model;
                $m_initial->setup_general_configuration = 1;
                $m_initial->modify(1);



                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=2; //CRUD
                $m_trans->trans_type_id=57; // TRANS TYPE
                $m_trans->trans_log='Updated System General Configuration';
                $m_trans->save();
                echo json_encode($response);

                break;


            case 'create_company':
                $m_company=$this->Company_model;

                $m_company->delete(1);

                $m_company->company_id=1;
                $m_company->company_name=$this->input->post('company_name',TRUE);
                $m_company->company_address=$this->input->post('company_address',TRUE);
                $m_company->email_address=$this->input->post('email_address',TRUE);
                $m_company->mobile_no=$this->input->post('mobile_no',TRUE);
                $m_company->landline=$this->input->post('landline',TRUE);
                $m_company->tin_no=$this->input->post('tin_no',TRUE);
                $m_company->registered_to=$this->input->post('registered_to',TRUE);
                $m_company->logo_path=$this->input->post('photo_path',TRUE);
                $m_company->tax_type_id=$this->input->post('tax_type_id',TRUE);
                $m_company->rdo_no=$this->input->post('rdo_no',TRUE);
                $m_company->nature_of_business=$this->input->post('nature_of_business',TRUE);
                $m_company->business_type=$this->input->post('business_type',TRUE);
                $m_company->save();

                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Company information successfully saved.';



                $m_initial = $this->Initial_setup_model;
                $m_initial->setup_company_info = 1;
                $m_initial->modify(1);

                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=2; //CRUD
                $m_trans->trans_type_id=60; // TRANS TYPE
                $m_trans->trans_log='Modified Company Information';
                $m_trans->save();

                echo json_encode($response);

                break;
            //****************************************************************************************************************



            case 'upload':
                $allowed = array('png', 'jpg', 'jpeg','bmp');

                $data=array();
                $files=array();
                $directory='assets/img/company/';

                foreach($_FILES as $file){

                    $server_file_name=uniqid('');
                    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
                    $file_path=$directory.$server_file_name.'.'.$extension;
                    $orig_file_name=$file['name'];

                    if(!in_array(strtolower($extension), $allowed)){
                        $response['title']='Invalid!';
                        $response['stat']='error';
                        $response['msg']='Image is invalid. Please select a valid photo!';
                        die(json_encode($response));
                    }

                    if(move_uploaded_file($file['tmp_name'],$file_path)){
                        $response['title']='Success!';
                        $response['stat']='success';
                        $response['msg']='Image successfully uploaded.';
                        $response['path']=$file_path;
                        echo json_encode($response);
                    }
                }
                break;

            case 'upload_user':
                $allowed = array('png', 'jpg', 'jpeg','bmp');

                $data=array();
                $files=array();
                $directory='assets/img/user/';

                foreach($_FILES as $file){

                    $server_file_name=uniqid('');
                    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
                    $file_path=$directory.$server_file_name.'.'.$extension;
                    $orig_file_name=$file['name'];

                    if(!in_array(strtolower($extension), $allowed)){
                        $response['title']='Invalid!';
                        $response['stat']='error';
                        $response['msg']='Image is invalid. Please select a valid photo!';
                        die(json_encode($response));
                    }

                    if(move_uploaded_file($file['tmp_name'],$file_path)){
                        $response['title']='Success!';
                        $response['stat']='success';
                        $response['msg']='Image successfully uploaded.';
                        $response['path']=$file_path;
                        echo json_encode($response);
                    }
                }
                break;

        }


    }
}
