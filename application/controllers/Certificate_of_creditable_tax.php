<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Certificate_of_creditable_tax extends CORE_Controller {
    function __construct() {
        parent::__construct('');
        $this->validate_session();
        $this->load->model('Users_model');
        $this->load->model('Months_model');
        $this->load->model('Bir_2307_model');
        $this->load->model('Company_model');
        $this->load->library('M_pdf');
    }

    public function index() {
        $this->Users_model->validate();
        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', TRUE);
        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', TRUE);
        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', TRUE);
        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', TRUE);
        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', TRUE);
        $data['months']=$this->Months_model->get_list();
        $data['title'] = 'Certificate of Creditable Tax';
        (in_array('16-3',$this->session->user_rights)? 
        $this->load->view('certificate_of_creditable_tax_view', $data)
        :redirect(base_url('dashboard')));
        
    }

    function transaction($txn = null) {
        switch ($txn) {
            case 'list':
                $m_form_2307 = $this->Bir_2307_model;
                $month = $this->input->get('month', TRUE);
                $year = $this->input->get('year', TRUE);
                if($month == 0){$month = null;}
                $response['data'] = $m_form_2307->get_2307_list($month,$year);
                echo json_encode($response);
                break;


            case 'print-list':
                $m_form_2307 = $this->Bir_2307_model;
                $month = $this->input->get('month', TRUE);
                $year = $this->input->get('year', TRUE);
                if($month == 0){$month = null;}
                $data['items'] = $m_form_2307->get_2307_list($month,$year);
                $data['company_info']=$this->Company_model->get_list()[0];

                $file_name='Certificate of Creditable Tax Report';
                $pdfFilePath = $file_name.".pdf";
                $pdf = $this->m_pdf->load(); 
                $pdf->AddPage('L');
                $content =  $this->load->view('template/2307_content',$data,TRUE);
                $pdf->SetTitle('Certificate of Creditable Tax Report');
                $pdf->WriteHTML($content);
                $pdf->Output();
                
                break;

            case 'create':
                $m_bank = $this->Bank_model;

                $m_bank->bank_code = $this->input->post('bank_code', TRUE);
                $m_bank->bank_name = $this->input->post('bank_name', TRUE);
                $m_bank->account_number = $this->input->post('account_number', TRUE);
                $m_bank->account_type = $this->input->post('account_type', TRUE);
                $m_bank->save();
                $bank_id = $m_bank->last_insert_id();

                $response['title'] = 'Success!';
                $response['stat'] = 'success';
                $response['msg'] = 'Bank information successfully created.';
                $response['row_added'] = $m_bank->get_list($bank_id);

                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=1; //CRUD
                $m_trans->trans_type_id=49; // TRANS TYPE
                $m_trans->trans_log='Created Bank: '.$this->input->post('bank_name', TRUE);
                $m_trans->save();

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
