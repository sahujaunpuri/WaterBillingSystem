<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment_sending extends CORE_Controller {
    function __construct() {
        parent::__construct('');
        $this->validate_session();
        $this->load->model('Meter_inventory_model');
        $this->load->model('Meter_reading_period_model');
        $this->load->model('Meter_reading_input_model');
        $this->load->model('Customers_model');
        $this->load->model('Billing_model');
        $this->load->model('Account_title_model');
        $this->load->model('Departments_model');
        $this->load->model('Users_model');
        $this->load->model('Trans_model');
        $this->load->model('Company_model');
        $this->load->model('Billing_payments_model');
        $this->load->model('Billing_payment_batch_model');
        $this->load->model('Account_integration_model');
        $this->load->model('Payment_method_model');
        $this->load->library('excel');

    }

    public function index() {
        $this->Users_model->validate();
        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', TRUE);
        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', TRUE);
        $data['_rights'] = $this->load->view('template/elements/rights', '', TRUE);
        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', TRUE);
        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', TRUE);
        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', TRUE);
        $data['title'] = 'Payment to Accounting';

        $data['customer'] = $this->Customers_model->get_list(array('is_active'=>TRUE,'is_deleted'=>FALSE));
        $data['batch'] = $this->Meter_reading_input_model->get_list(array('is_active'=>TRUE,'is_deleted'=>FALSE));
        $data['periods'] = $this->Meter_reading_period_model->get_list(array('is_active'=>TRUE,'is_deleted'=>FALSE),
        'meter_reading_period.*,
        months.month_name,
        DATE_FORMAT(meter_reading_period.meter_reading_period_start,"%m/%d/%Y") as meter_reading_period_start,
        DATE_FORMAT(meter_reading_period.meter_reading_period_end,"%m/%d/%Y") as meter_reading_period_end',
        array(
            array('months','months.month_id = meter_reading_period.month_id','left')),
        'meter_reading_period.meter_reading_year DESC, months.month_id ASC'
        );        

        (in_array('22-2',$this->session->user_rights)? 
        $this->load->view('payment_sending_view', $data)
        :redirect(base_url('dashboard')));
        
    }

    function transaction($txn = null,$filter_value=null) {
        switch ($txn) {
            case 'list':
                // $response['data']=$this->response_rows($filter_value);

                $tsd = date('Y-m-d',strtotime($this->input->get('tsd')));
                $ted = date('Y-m-d',strtotime($this->input->get('ted')));
                $filter_active = "DATE(billing_payments.date_paid) BETWEEN '$tsd' AND '$ted' AND billing_payments.is_active = TRUE AND billing_payments.billing_payment_batch_id = 0";
                $response['data']=$this->response_rows($filter_value,$filter_active);
                echo json_encode($response);
                break;

            case 'list-for-review':
                $response['data']=$this->Billing_payment_batch_model->get_list(array('is_journal_posted'=>FALSE));
                echo json_encode($response);
                break;

            case 'send-to-accounting':

                $tsd = date('Y-m-d',strtotime($this->input->post('tsd')));
                $ted = date('Y-m-d',strtotime($this->input->post('ted')));
                $filter_active = "DATE(billing_payments.date_paid) BETWEEN '$tsd' AND '$ted' AND billing_payments.is_active = TRUE AND billing_payments.billing_payment_batch_id = 0";
                $payments=$this->response_rows($filter_value,$filter_active);

                // PREPARE FOR TOTALS
                $batch_total_paid_amount = 0; $batch_total_paid_cash = 0; $batch_total_paid_check = 0; $batch_total_paid_card = 0; $batch_total_paid_deposit = 0; $batch_total_deposit_refund = 0;
                foreach ($payments as $payment) {
                    if($payment->payment_method_id == 1){  $batch_total_paid_cash += $this->get_numeric_value($payment->total_payment_amount);
                    } else if($payment->payment_method_id == 2){  $batch_total_paid_check += $this->get_numeric_value($payment->total_payment_amount);
                    }else if($payment->payment_method_id == 3){ $batch_total_paid_card  += $this->get_numeric_value($payment->total_payment_amount); }
                    $batch_total_paid_amount += $this->get_numeric_value($payment->total_paid_amount);
                    $batch_total_paid_deposit += $this->get_numeric_value($payment->total_deposit_amount);
                    $batch_total_deposit_refund += $this->get_numeric_value($payment->refund_amount); 

                }

                $m_payment_batch = $this->Billing_payment_batch_model;
                $m_payment_batch->start_date = $tsd;
                $m_payment_batch->end_date = $ted;
                $m_payment_batch->batch_total_paid_amount = $this->get_numeric_value($batch_total_paid_amount);
                $m_payment_batch->batch_total_paid_cash = $this->get_numeric_value($batch_total_paid_cash);
                $m_payment_batch->batch_total_paid_check = $this->get_numeric_value($batch_total_paid_check);
                $m_payment_batch->batch_total_paid_card = $this->get_numeric_value($batch_total_paid_card);
                $m_payment_batch->batch_total_paid_deposit = $this->get_numeric_value($batch_total_paid_deposit);
                $m_payment_batch->batch_total_deposit_refund = $this->get_numeric_value($batch_total_deposit_refund);
                $m_payment_batch->set('date_created','NOW()'); 


                $m_payment_batch->save();

                $billing_payment_batch_id = $m_payment_batch->last_insert_id();
                $m_payment_batch->batch_code = 'BATCH-PAYMENT-'.$billing_payment_batch_id;
                $m_payment_batch->posted_by_user_id = $this->session->user_id;

                $m_payment_batch->modify($billing_payment_batch_id);
                $m_billing_payments = $this->Billing_payments_model;
                foreach ($payments as $payment) { // MODIFY PAYMENTS 
                    $m_billing_payments->billing_payment_batch_id = $billing_payment_batch_id;
                    $m_billing_payments->modify($payment->billing_payment_id);
                }

                $response['title']="Success!";
                $response['stat']="success";
                $response['msg']="Payments successfully sent to Accounting.";

                // Audittrail Log           
                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=12; //CRUD
                $m_trans->trans_type_id=83; // TRANS TYPE
                $m_trans->trans_log='Transfered Billing Payments to Accounting: ('.$this->input->post('tsd').' to '.$this->input->post('ted').') ID('.$billing_payment_batch_id.')';
                $m_trans->save();

                echo json_encode($response);
                break;


            case 'billing-payments-for-review':
                $billing_payment_batch_id=$this->input->get('id',TRUE);

                $m_customers=$this->Customers_model;
                $m_accounts=$this->Account_title_model;
                $m_methods=$this->Payment_method_model;
                $m_departments=$this->Departments_model;



                $data['methods']=$m_methods->get_list();
                $data['departments']=$m_departments->get_list(
                    array(
                        'departments.is_active'=>TRUE,
                        'departments.is_deleted'=>FALSE
                    ));

                $data['customers']=$m_customers->get_list(
                    array(
                        'customers.is_active'=>TRUE,
                        'customers.is_deleted'=>FALSE
                    ),

                    array(
                        'customers.customer_id',
                        'customers.customer_name'
                    )
                );
                $data['entries']=$this->Billing_payment_batch_model->get_journal_entries($billing_payment_batch_id);
                $data['billing_payments_info']=$this->Billing_payments_model->get_list(array('billing_payment_batch_id'=>$billing_payment_batch_id),
                    'billing_payments.*,payment_methods.payment_method,customers.customer_name,service_connection.account_no',
                    array(array('payment_methods','payment_methods.payment_method_id = billing_payments.payment_method_id','left'),
                        array('service_connection','service_connection.connection_id = billing_payments.connection_id','left'),
                        array('customers', 'customers.customer_id= service_connection.customer_id','left')
                        )
                    );

                $data['accounts']=$m_accounts->get_list(
                    array(
                        'account_titles.is_active'=>TRUE,
                        'account_titles.is_deleted'=>FALSE
                    )
                );
                 $data['account_integration'] = $this->Account_integration_model->get_list()[0];
                $data['batch_info']=$this->Billing_payment_batch_model->get_list($billing_payment_batch_id)[0];
                echo $this->load->view('template/billing_payment_for_review',$data,TRUE); //details of the journal

                break;
        }
    }



    function response_rows($id=null,$filter_active=FALSE){ //$show_unposted is TRUE, only unposted will be filtered
        $m_payments=$this->Billing_payments_model;
        return $m_payments->get_list(
        //filter
            ($id==null?'':' billing_payments.billing_payment_id='.$id)." 
            ".($filter_active==FALSE?"": $filter_active),
            //fields
            array(
                'billing_payments.*',
                'DATE_FORMAT(billing_payments.date_paid,"%m/%d/%Y")as date_paid',
                'FORMAT(billing_payments.total_paid_amount,2)as total_paid_amount',
                'payment_methods.payment_method',
                'customers.customer_name',
                'service_connection.receipt_name',
                'CONCAT_WS(" ",user_accounts.user_fname,user_accounts.user_lname)as posted_by_user'
            ),
            //joins
            array(
                array('user_accounts','user_accounts.user_id=billing_payments.created_by_user','left'),
                array('service_connection','service_connection.connection_id=billing_payments.connection_id','left'),
                array('customers','customers.customer_id=service_connection.customer_id','left'),
                array('payment_methods','payment_methods.payment_method_id=billing_payments.payment_method_id','left')
            ),
            'billing_payments.billing_payment_id DESC'

        );
    }
}
