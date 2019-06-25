<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Monthly_connection extends CORE_Controller 
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
                    'Billing_model',
                    'Months_model'
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

	        $data['title'] = 'Monthly Connection';
	        $data['months'] = $this->Months_model->get_list();
	        
	        (in_array('21-8',$this->session->user_rights)? 
	        $this->load->view('monthly_connection_view',$data)
	        :redirect(base_url('dashboard')));
			}

		function transaction($txn=null){
			switch($txn){
				case 'list':

					$month_id=$this->input->get('month_id',TRUE);
					$year=$this->input->get('year',TRUE);
					$m_connection=$this->Service_connection_model;

					$response['data']=$m_connection->getList(null,null,null,$month_id,$year);
					echo json_encode($response);

				break;
			}
		}
	}

?>