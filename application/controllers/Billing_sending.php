<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Billing_sending extends CORE_Controller {
    function __construct() {
        parent::__construct('');
        $this->validate_session();
        $this->load->model('Meter_inventory_model');
        $this->load->model('Meter_reading_period_model');
        $this->load->model('Meter_reading_input_model');
        $this->load->model('Customers_model');
        $this->load->model('Billing_model');
        $this->load->model('Users_model');
        $this->load->model('Trans_model');
        $this->load->model('Company_model');
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

        (in_array('22-1',$this->session->user_rights)? 
        $this->load->view('billing_sending_view', $data)
        :redirect(base_url('dashboard')));
        
    }

    function transaction($txn = null) {
        switch ($txn) {
            case 'statement':

                $period_id = $this->input->get('period_id',TRUE);
                $meter_reading_input_id = $this->input->get('meter_reading_input_id',TRUE);
                $response['data']=$this->Billing_model->billing_statement($period_id,$meter_reading_input_id);
                echo json_encode($response);
                break;

            case 'list-of-batches':
                $meter_reading_period_id = $this->input->get('mrid',TRUE);
                $response['data']=$this->Meter_reading_input_model->get_list(array('is_active'=>TRUE,'is_deleted'=>FALSE, 'meter_reading_period_id'=>$meter_reading_period_id));
                echo json_encode($response);
                break;

            case 'send-to-accounting':
                $meter_reading_input_id = $this->input->post('meter_reading_input_id',TRUE);
                $batch_total_amount = $this->get_numeric_value($this->input->post('batch_total_amount',TRUE));
                $validate=$this->Meter_reading_input_model->get_list(array('meter_reading_input_id'=>$meter_reading_input_id,'is_sent'=>TRUE));
                if(count($validate) > 0){
                    $response['stat']='error';
                    $response['msg']='<b>Batch '.$validate[0]->batch_no.' already sent to Accounting!</b>';
                    $response['title']='Please Select Another Batch!<br />';
                    die(json_encode($response));
                } 
                $m_period = $this->Meter_reading_input_model;
                $m_period->is_sent = TRUE;
                $m_period->batch_total_amount = $batch_total_amount;
                $m_period->modify($meter_reading_input_id);

                $batch = $this->Meter_reading_input_model->meter_reading($meter_reading_input_id);

                $response['title'] = 'Success!';
                $response['stat'] = 'success';
                $response['msg'] = 'Batch Successfully sent to Accounting.';

                // Audittrail Log           
                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=12; //CRUD
                $m_trans->trans_type_id=82; // TRANS TYPE
                $m_trans->trans_log='Transfered Batch Meter Reading to Accounting: ('.$batch[0]->batch_no.')';
                $m_trans->save();

                echo json_encode($response);
                break;

        }
    }
}
