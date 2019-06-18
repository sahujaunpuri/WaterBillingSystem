<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Connection_sending extends CORE_Controller {
    function __construct() {
        parent::__construct('');
        $this->validate_session();

        $this->load->model('Service_connection_model');
        $this->load->model('Users_model');
        $this->load->model('Trans_model');
        $this->load->model('Company_model');
        $this->load->model('Suppliers_model');
        $this->load->model('Account_title_model');
        $this->load->model('Departments_model');
        $this->load->model('Customers_model');
        $this->load->model('Billing_connection_batch_model');
        $this->load->model('Account_integration_model');
        $this->load->library('excel');
    }

    public function index() {
        $this->Users_model->validate();
        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', TRUE);
        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', TRUE);
        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', TRUE);
        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', TRUE);
        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', TRUE);
        $data['title'] = 'Billing to Accounting';    

        (in_array('22-1',$this->session->user_rights)? 
        $this->load->view('connection_sending_view', $data)
        :redirect(base_url('dashboard')));
        
    }

    function transaction($txn = null) {
        switch ($txn) {
            case 'list-for-sending':
                $sd = date('Y-m-d',strtotime($this->input->get('sd')));
                $ed = date('Y-m-d',strtotime($this->input->get('ed')));
                $additional = "service_connection.is_active = TRUE AND service_connection.is_deleted = FALSE AND service_connection.service_connection_batch_id = 0 AND DATE(service_connection.service_date) BETWEEN '$sd' AND '$ed'";
                $response['data'] = $this->Service_connection_model->get_list($additional,
                    'service_connection.*,customers.customer_name,DATE_FORMAT(service_connection.service_date,"%m/%d/%Y") as service_date',
                    array(array('customers','customers.customer_id = service_connection.customer_id','left'))
                    );
                echo json_encode($response);


            break;

            case 'send-to-accounting':
                $sd = date('Y-m-d',strtotime($this->input->post('sd')));
                $ed = date('Y-m-d',strtotime($this->input->post('ed')));
                $batch_total_amount = $this->get_numeric_value($this->input->post('batch_total_amount',TRUE));

                $additional = "service_connection.is_active = TRUE AND service_connection.is_deleted = FALSE AND DATE(service_connection.service_date) BETWEEN '$sd' AND '$ed'";
                $deposits = $this->Service_connection_model->get_list($additional,
                    'service_connection.*,customers.customer_name,DATE_FORMAT(service_connection.service_date,"%m/%d/%Y") as service_date',
                    array(array('customers','customers.customer_id = service_connection.customer_id','left'))
                    );
                $batch_total_deposit = 0;

                foreach ($deposits as $deposit) {
                    $batch_total_deposit+=$deposit->initial_meter_deposit;
                }

                $m_service_batch = $this->Billing_connection_batch_model;
                $m_service_batch->start_date = $sd;
                $m_service_batch->end_date = $ed;
                $m_service_batch->batch_total_deposit = $this->get_numeric_value($batch_total_deposit);
                $m_service_batch->posted_by_user_id = $this->session->user_id;
                $m_service_batch->set('date_created','NOW()'); 
                $m_service_batch->save();


                $service_connection_batch_id = $m_service_batch->last_insert_id();
                $m_service_batch->batch_code = 'BATCH-DEPOSIT-'.$service_connection_batch_id;
                $m_service_batch->modify($service_connection_batch_id);

                $m_batch_deposit = $this->Service_connection_model;
                foreach ($deposits as $deposit) { // MODIFY CONNECTIONS
                    $m_batch_deposit->service_connection_batch_id = $service_connection_batch_id;
                    $m_batch_deposit->modify($deposit->connection_id);
                }


                $response['title'] = 'Success!';
                $response['stat'] = 'success';
                $response['msg'] = 'Batch Successfully sent to Accounting.';

                // Audittrail Log           
                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=12; //CRUD
                $m_trans->trans_type_id=84; // TRANS TYPE
                $m_trans->trans_log='Transfered Batch Meter Reading to Accounting: ('.$service_connection_batch_id.')';
                $m_trans->save();

                echo json_encode($response);
                break;


                case 'batch-deposit-for-review': 
                $service_connection_batch_id=$this->input->get('id',TRUE);

                $m_suppliers=$this->Suppliers_model;
                $m_accounts=$this->Account_title_model;
                $m_departments=$this->Departments_model;

                $info = $this->Billing_connection_batch_model->get_list($service_connection_batch_id)[0];
                $data['info'] = $info;

                $data['entries'] = $this->Billing_connection_batch_model->get_journal_entries($service_connection_batch_id);


                $data['account_integration'] = $this->Account_integration_model->get_list()[0];
                $data['departments']=$m_departments->get_list('is_active=TRUE AND is_deleted=FALSE');

                $data['suppliers']=$m_suppliers->get_list(
                    array(
                        'suppliers.is_active'=>TRUE,
                        'suppliers.is_deleted'=>FALSE
                    ),

                    array(
                        'suppliers.supplier_id',
                        'suppliers.supplier_name'
                    )
                );

                $data['customers']=$this->Customers_model->get_list(
                    array(
                        'customers.is_active'=>TRUE,
                        'customers.is_deleted'=>FALSE
                    ),

                    array(
                        'customers.customer_id',
                        'customers.customer_name'
                    )
                );
                $data['accounts']=$m_accounts->get_list(
                    array(
                        'account_titles.is_active'=>TRUE,
                        'account_titles.is_deleted'=>FALSE
                    )
                );


                $data['items'] = $this->Service_connection_model->get_list(array('service_connection_batch_id'=>$service_connection_batch_id),
                    'service_connection.*,customers.customer_name,DATE_FORMAT(service_connection.service_date,"%m/%d/%Y") as service_date',
                    array(array('customers','customers.customer_id = service_connection.customer_id','left'))
                    );

                echo $this->load->view('template/batch_deposits_for_review',$data,TRUE); //details of the journal

                break;
        }
    }
}
