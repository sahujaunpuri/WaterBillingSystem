<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_consumption_history extends CORE_Controller {

    function __construct() {
        parent::__construct('');
        $this->validate_session();
        $this->load->model(array(
            'Sales_invoice_model',
            'Company_model',
            'Users_model',
            'Meter_reading_period_model',
            'Service_connection_model',
            'Months_model',
            'Company_model',
            'Customers_model'
        ));
        $this->load->library('excel');
        $this->load->model('Email_settings_model');
        $this->load->library('M_pdf');

    }

    public function index() {
        $this->Users_model->validate();
        $data['_def_css_files']=$this->load->view('template/assets/css_files','',TRUE);
        $data['_def_js_files']=$this->load->view('template/assets/js_files','',TRUE);
        $data['_switcher_settings']=$this->load->view('template/elements/switcher','',TRUE);
        $data['_side_bar_navigation']=$this->load->view('template/elements/side_bar_navigation','',TRUE);
        $data['_top_navigation']=$this->load->view('template/elements/top_navigation','',TRUE);


        $data['title']='Consumption History';
        $data['meter_years']=$this->Meter_reading_period_model->get_list(array('is_active'=> TRUE, 'is_deleted'=> FALSE), 'DISTINCT(meter_reading_year)');
        $data['accounts']=$this->Service_connection_model->get_list(array('service_connection.is_active'=> TRUE, 'service_connection.is_deleted'=> FALSE), 'connection_id,account_no,customer_name,serial_no,receipt_name',
        	array(
				array('customers c', 'c.customer_id=service_connection.customer_id','left'),
				array('meter_inventory','meter_inventory.meter_inventory_id = service_connection.meter_inventory_id','left')
        		)
        	);

        (in_array('21-2',$this->session->user_rights)? 
        $this->load->view('customer_consumption_history_view',$data)
        :redirect(base_url('dashboard')));
    }


    function transaction($txn=null){
        switch($txn){
            case 'consumption-history':
            $scid=$this->input->get('scid',TRUE);
            $response['years']=$this->Meter_reading_period_model->get_list(array('is_active'=> TRUE, 'is_deleted'=> FALSE), 'DISTINCT(meter_reading_year)');
            $response['months']=$this->Months_model->get_list();
            if($scid != null || $scid != '' ){
				$response['data']=$this->Meter_reading_period_model->get_history($scid);
            }else {
            	$response['data'] = [];
            }
            echo json_encode($response);    

            break;

            case 'consumption-history-info':
				$m_connection=$this->Service_connection_model;
				$scid=$this->input->get('scid',TRUE);
				if($scid != null || $scid != '' ){
					$info=$m_connection->getList($scid);
					$data['connection']=$info[0];
	            	echo $this->load->view('template/connection_content_wo_header',$data,TRUE); 
				}else{
					$data['connection'] = [];
					echo $this->load->view('template/connection_content_wo_header_wo_details',$data,TRUE); 
				}

            break;

            case 'consumption-history-print':
				$m_connection=$this->Service_connection_model;
                $scid=$this->input->get('scid',TRUE);
				$year=$this->input->get('y',TRUE);
                $data['company_info']=$this->Company_model->get_list()[0];
				$data['connection']=$m_connection->getList($scid)[0];
	            $data['years']=$this->Meter_reading_period_model->get_list(array('is_active'=> TRUE, 'is_deleted'=> FALSE), 'DISTINCT(meter_reading_year)');
	            $data['months']=$this->Months_model->get_list();
				$data['datas']=$this->Meter_reading_period_model->get_history($scid,$year);
                $data['user']=$this->session->user_fullname; 

                $file_name='Customer Consumption History';
                $pdfFilePath = $file_name.".pdf"; //generate filename base on id
                $pdf = $this->m_pdf->load(); //pass the instance of the mpdf class
                $content=$this->load->view('template/connection_content_history_print',$data,TRUE); //load the template
                // $pdf->setFooter('{PAGENO}');
                $pdf->WriteHTML($content);
                //download it.
                $pdf->Output();
				// echo $this->load->view('template/connection_content_history_print',$data,TRUE); 
            break;

        
        }
    }



}
