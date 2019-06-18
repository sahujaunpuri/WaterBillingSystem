<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Customer_billing_subsidiary extends CORE_Controller 
	{
		function __construct()
		{
			parent::__construct('');
			$this->validate_session();
			$this->load->model(
				array
				(
					'Journal_account_model',
					'Journal_info_model',
					'Customers_model',
					'Account_title_model',
					'Account_class_model',
					'Account_type_model',
					'Users_model',
					'Customer_subsidiary_model',
                    'Account_integration_model',
                    'Service_connection_model',
                    'Billing_model'
				)
			);
		}

		public function index() {
			$this->Users_model->validate();
	        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', true);
	        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', true);
	        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', true);
	        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', true);
	        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', true);

	        $data['title'] = 'Customer Billing Subsidiary';
	        $data['accounts'] = $this->Service_connection_model->getList();
	        
	        (in_array('21-4',$this->session->user_rights)? 
	        $this->load->view('customer_billing_subsidiary_view',$data)
	        :redirect(base_url('dashboard')));
			}

		function transaction($txn=null){
			switch($txn){
				case 'get-customer-subsidiary':

					$connection_id=$this->input->get('connection_id',TRUE);
					$start_Date=date('Y-m-d',strtotime($this->input->get('startDate',TRUE)));
					$end_Date=date('Y-m-d',strtotime($this->input->get('endDate',TRUE)));
					$m_billing=$this->Billing_model;

					$response['data']=$m_billing->get_customer_billing_subsidiary($connection_id,$start_Date,$end_Date);
					echo json_encode($response);

				break;
			}
		}
	}

?>