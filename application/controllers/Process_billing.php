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

        (in_array('4-3',$this->session->user_rights)? 
        $this->load->view('process_billing_view', $data)
        :redirect(base_url('dashboard')));
        
    }

    function transaction($txn = null) {
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

            case 'process':
                $m_billing=$this->Billing_model;
                $meter_reading_input_id = $this->input->post('meter_reading_input_id', TRUE);

                if($meter_reading_input_id!="")
                {
                    $status=$this->Billing_model->process_billing($meter_reading_input_id);
                    
                    if($status==true){
                        $response['title']='Success!';
                        $response['stat']='success';
                        $response['msg']='Billing Successfully Processed.';
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
