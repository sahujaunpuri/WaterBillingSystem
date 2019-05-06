<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Monthly_percentage_tax_return extends CORE_Controller {
    function __construct() {
        parent::__construct('');
        $this->validate_session();
        $this->load->model('Users_model');
        $this->load->model('Months_model');
        $this->load->model('Bir_2551m_model');
        $this->load->model('Company_model');
    }

    public function index() {
        $this->Users_model->validate();
        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', TRUE);
        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', TRUE);
        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', TRUE);
        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', TRUE);
        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', TRUE);
        $data['months']=$this->Months_model->get_list();
        $data['title'] = 'Monthly Percentage Tax Return';
        (in_array('16-1',$this->session->user_rights)? 
        $this->load->view('monthly_percentage_tax_return_view', $data)
        :redirect(base_url('dashboard')));
        
    }

    function transaction($txn = null) {
        switch ($txn) {
            case 'list':
                $m_2551 = $this->Bir_2551m_model;
                $year = $this->input->get('year', TRUE);
                $response['data'] = $m_2551->get_2551m_list($year);
                echo json_encode($response);
                break;

            case 'get_monthly_tax_return':
                $m_2551 = $this->Bir_2551m_model;
                $m_company = $this->Company_model;

                $month = $this->input->post('month', TRUE);
                $year = $this->input->post('year', TRUE);
                $response['data'] = $m_2551->get_monthly_tax_return($month,$year);
                $response['company'] = $m_company->get_list();
                echo json_encode($response);
                break;

            case 'generate_sales_cash_invoice':
                $m_2551 = $this->Bir_2551m_model;
                $month = $this->input->get('month', TRUE);
                $year = $this->input->get('year', TRUE);
                $response['data'] = $m_2551->generate_sales_cash_invoice($month,$year);
                echo json_encode($response);
                break;                

            case 'create':
                $m_2551 = $this->Bir_2551m_model;
                $m_company = $this->Company_model;
                $m_months = $this->Months_model;

                $month = $this->input->post('month', TRUE);
                $year = $this->input->post('year', TRUE);
                $company = $m_company->get_list();
                $months = $m_months->get_list($month);

                $form_2551m = $m_2551->validate_2551m($month,$year);

                $m_2551->payor_tin = $company[0]->tin_no;
                $m_2551->payor_name = $company[0]->registered_to;
                $m_2551->payor_address = $company[0]->registered_address;
                $m_2551->rdo_no = $company[0]->rdo_no;
                $m_2551->nature_of_business = $company[0]->nature_of_business;
                $m_2551->zip_code = $company[0]->zip_code;
                $m_2551->telephone_no = $company[0]->telephone_no;
                $m_2551->month_id = $month;
                $m_2551->year = $year;
                $m_2551->atc = $this->input->post('atc', TRUE);
                $m_2551->industry_classification = $this->input->post('industry_classification', TRUE);                
                $m_2551->taxable_amount = $this->get_numeric_value($this->input->post('taxable_amount',TRUE));
                $m_2551->tax_rate = $this->get_numeric_value($this->input->post('tax_rate',TRUE));
                $m_2551->tax_due = $this->get_numeric_value($this->input->post('tax_due',TRUE));

                if (count($form_2551m) > 0){

                    $form_2551m_id = $form_2551m[0]->form_2551m_id;

                    $m_2551->date_modified = date('Y-m-d');
                    $m_2551->modified_by_user = $this->session->user_id;
                    $m_2551->modify($form_2551m_id);

                    $response['status'] = 'updated';
                    $response['title'] = 'Success!';
                    $response['stat'] = 'success';
                    $response['msg'] = 'Bir 2551M successfully updated for '.$months[0]->month_name.' '.$year;
                    $response['row'] = $m_2551->get_2551m_list(null,$form_2551m_id);
                }else{

                    $m_2551->set('date','NOW()');
                    $m_2551->date_created = date('Y-m-d');
                    $m_2551->created_by_user = $this->session->user_id;

                    $m_2551->save();
                    $form_2551m_id = $m_2551->last_insert_id();

                    $response['status'] = 'new';
                    $response['title'] = 'Success!';
                    $response['stat'] = 'success';
                    $response['msg'] = 'Bir 2551M successfully created for '.$months[0]->month_name.' '.$year;
                    $response['row'] = $m_2551->get_2551m_list(null,$form_2551m_id);
                }

                // $m_trans=$this->Trans_model;
                // $m_trans->user_id=$this->session->user_id;
                // $m_trans->set('trans_date','NOW()');
                // $m_trans->trans_key_id=1; //CRUD
                // $m_trans->trans_type_id=49; // TRANS TYPE
                // $m_trans->trans_log='Created Bank: '.$this->input->post('bank_name', TRUE);
                // $m_trans->save();
                echo json_encode($response);
                break;

            case 'delete':
                $m_bank=$this->Bank_model;

                $bank_id=$this->input->post('bank_id',TRUE);

                $m_bank->is_deleted=1;
                if($m_bank->modify($bank_id)){
                    $response['title']='Success!';
                    $response['stat']='success';
                    $response['msg']='Bank information successfully deleted.';

                    $bank_name = $m_bank->get_list($bank_id,'bank_name');
                    $m_trans=$this->Trans_model;
                    $m_trans->user_id=$this->session->user_id;
                    $m_trans->set('trans_date','NOW()');
                    $m_trans->trans_key_id=3; //CRUD
                    $m_trans->trans_type_id=49; // TRANS TYPE
                    $m_trans->trans_log='Deleted Bank: '.$bank_name[0]->bank_name;
                    $m_trans->save();

                    echo json_encode($response);
                }

                break;

            case 'update':
                $m_bank=$this->Bank_model;

                $bank_id=$this->input->post('bank_id',TRUE);
                $m_bank->bank_code = $this->input->post('bank_code', TRUE);
                $m_bank->bank_name = $this->input->post('bank_name', TRUE);
                $m_bank->account_number = $this->input->post('account_number', TRUE);
                $m_bank->account_type = $this->input->post('account_type', TRUE);

                $m_bank->modify($bank_id);


                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=2; //CRUD
                $m_trans->trans_type_id=49; // TRANS TYPE
                $m_trans->trans_log='Updated Bank : '.$this->input->post('bank_name', TRUE).' ID('.$bank_id.')';
                $m_trans->save();

                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Bank information successfully updated.';
                $response['row_updated']=$m_bank->get_list($bank_id);
                echo json_encode($response);

                break;
        }
    }
}
