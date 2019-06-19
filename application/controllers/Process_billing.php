<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Process_billing extends CORE_Controller {
    function __construct() {
        parent::__construct('');
        $this->validate_session();
        $this->load->model('Meter_inventory_model');
        $this->load->model('Meter_reading_period_model');
        $this->load->model('Meter_reading_input_model');
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
        $data['_rights'] = $this->load->view('template/elements/rights', '', TRUE);
        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', TRUE);
        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', TRUE);
        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', TRUE);
        $data['title'] = 'Process Billing';

        $data['periods'] = $this->Meter_reading_period_model->get_list(array('is_active'=>TRUE,'is_deleted'=>FALSE),
        'meter_reading_period.*,
        months.month_name,
        DATE_FORMAT(meter_reading_period.meter_reading_period_start,"%m/%d/%Y") as meter_reading_period_start,
        DATE_FORMAT(meter_reading_period.meter_reading_period_end,"%m/%d/%Y") as meter_reading_period_end',
        array(
            array('months','months.month_id = meter_reading_period.month_id','left')),
        'meter_reading_period.meter_reading_year DESC, months.month_id ASC'
        );        

        (in_array('18-2',$this->session->user_rights)? 
        $this->load->view('process_billing_view', $data)
        :redirect(base_url('dashboard')));
        
    }

    function transaction($txn = null,$filter_value=null) {
        switch ($txn) {
            case 'reading':
                $period_id = $this->input->get('period_id',TRUE);
                $response['data']=$this->Meter_reading_input_model->meter_reading($period_id);
                echo json_encode($response);
                break;

            case 'check_process':    
                $meter_reading_input_id = $this->input->post('meter_reading_input_id', TRUE);

                if ($meter_reading_input_id == null){
                    $response['title']='Error!';
                    $response['stat']='error';
                    $response['msg']='Select Batch No. to be Processed.';
                }else{
                    $response['stat']='success';
                }

                echo json_encode($response);
                break;


            case 'chck_status':
                $period_id = $this->input->post('period_id',true);
                $response['data']=$this->Meter_reading_period_model->get_list($period_id);
                echo json_encode($response);
                break;

            case 'process':
                $m_billing=$this->Billing_model;
                $meter_reading_input_id = $this->input->post('meter_reading_input_id', TRUE);
                $period_id = $filter_value;

                $meter_period = $this->Meter_reading_period_model->get_list(
                    $period_id,
                    'CONCAT(months.month_name," ",meter_reading_period.meter_reading_year) as period',
                    array(
                        array('months','months.month_id = meter_reading_period.month_id','left'))
                );     

                if($meter_reading_input_id!="")
                {
                    $status=$this->Billing_model->process_billing($meter_reading_input_id);
                    
                    if($status==true){
                        $response['title']='Success!';
                        $response['stat']='success';
                        $response['msg']='Billing Successfully Processed.';

                        // Audittrail Log          
                        $m_trans=$this->Trans_model;
                        $m_trans->user_id=$this->session->user_id;
                        $m_trans->set('trans_date','NOW()');
                        $m_trans->trans_key_id=11; //CRUD
                        $m_trans->trans_type_id=80; // TRANS TYPE
                        $m_trans->trans_log='Process Billing ('.$meter_period[0]->period.')';
                        $m_trans->save();

                    }
                    else{
                        $response['title']='Error!';
                        $response['stat']='error';
                        $response['msg']='Billing Failed to Processed, Please Try Again.';
                    }
                }
                else
                {
                    $response['title']='Error!';
                    $response['stat']='error';
                    $response['msg']='Select Batch No. to be Processed.';
                }

                    echo json_encode($response);
                break;
        }
    }
}
