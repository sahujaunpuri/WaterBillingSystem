<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Batch_payments_report extends CORE_Controller {
    function __construct() {
        parent::__construct('');
        $this->validate_session();
        $this->load->model('Users_model');
        $this->load->model('Company_model');
        $this->load->model('Billing_payments_model');
        $this->load->model('Billing_payment_batch_model');
        $this->load->library('excel');
        $this->load->library('M_pdf');
    }

    public function index() {
        $this->Users_model->validate();
        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', TRUE);
        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', TRUE);
        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', TRUE);
        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', TRUE);
        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', TRUE);
        $data['title'] = 'Batch Payments Report';    

        $data['batches'] = $this->Billing_payment_batch_model->get_list(null,'*,DATE_FORMAT(start_date,"%m/%d/%Y")as start_date,DATE_FORMAT(end_date,"%m/%d/%Y")as end_date');

        (in_array('21-5',$this->session->user_rights)? 
        $this->load->view('batch_payment_report_view', $data)
        :redirect(base_url('dashboard')));
        
    }

    function transaction($txn = null,$filter_value=null) {
        switch ($txn) {
            case 'list':
                $bpbid = $this->input->get('bpbid');
                $response['data']=$this->response_rows($bpbid);
                echo json_encode($response);
                break;

            case 'print-batch-history':
                $data['billing_payments_info']=$this->response_rows($filter_value);
                $batch_info=$this->Billing_payment_batch_model->get_list($filter_value,'*,DATE_FORMAT(start_date,"%m/%d/%Y")as start_date,DATE_FORMAT(end_date,"%m/%d/%Y")as end_date,
                    CONCAT_WS(" ",user_accounts.user_fname,user_accounts.user_lname)as posted_by_user
                    ',
                    array(
                        array('user_accounts','user_accounts.user_id=billing_payment_batch.posted_by_user_id','left')
                        )
                    );
                $data['batch_info'] = $batch_info;
                $m_company=$this->Company_model;
                $company=$m_company->get_list();
                $data['company_info']=$company[0];
                echo $this->load->view('template/batch_history_payment_content',$data,TRUE); //load the template

                // $file_name= 'Batch Payment Summary Report - '.$batch_info[0]->batch_code;
                // $pdfFilePath = $file_name.".pdf"; //generate filename base on id
                // $pdf = $this->m_pdf->load(); //pass the instance of the mpdf class
                // $content=$this->load->view('template/batch_history_payment_content',$data,TRUE); //load the template
                // $pdf->WriteHTML($content);
                // //download it.
                // $pdf->Output();

                break;

        }
    }



    function response_rows($billing_payment_batch_id=null){ 
        return $this->Billing_payments_model->get_list(array('billing_payment_batch_id'=>$billing_payment_batch_id),
            'billing_payments.*,payment_methods.payment_method,customers.customer_name,service_connection.account_no,
            CONCAT_WS(" ",user_accounts.user_fname,user_accounts.user_lname)as posted_by_user,
            IF(billing_payments.is_refund = TRUE,billing_payments.remaining_deposit,0) as refund_amount
            ',
            array(array('payment_methods','payment_methods.payment_method_id = billing_payments.payment_method_id','left'),
                array('user_accounts','user_accounts.user_id=billing_payments.created_by_user','left'),
                array('service_connection','service_connection.connection_id = billing_payments.connection_id','left'),
                array('customers', 'customers.customer_id= service_connection.customer_id','left')
                )
            );
    }
}