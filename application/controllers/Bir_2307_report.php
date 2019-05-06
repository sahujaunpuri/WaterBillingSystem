<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Bir_2307_report extends CORE_Controller
	{
		function __construct()
		{
			parent::__construct();
			$this->validate_session();
			$this->load->model(
				array(
					'Journal_info_model',
					'Receivable_payment_model',
					'Users_model',
					'Company_model',
					'Suppliers_model',
					'Bir_2307_model'

				)
			);
			$this->load->library('excel');
			$this->load->model('Email_settings_model');
		}

		public function index()
		{	
			$this->Users_model->validate();
			$data['_def_css_files'] = $this->load->view('template/assets/css_files', '', TRUE);
	        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', TRUE);
	        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', TRUE);
	        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', TRUE);
	        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', TRUE);
	        $data['suppliers']=$this->Suppliers_model->get_list(
	            array('suppliers.is_deleted'=>FALSE),
	            'suppliers.*,IFNULL(tax_types.tax_rate,0)as tax_rate',
	            array(
	                array('tax_types','tax_types.tax_type_id=suppliers.tax_type_id','left')
	            )
	        );
	        $data['title'] = 'Bir 2307';
        (in_array('12-3',$this->session->user_rights)? 
        $this->load->view('bir_2307_report_view',$data)
        :redirect(base_url('dashboard')));
		}

		function transaction($txn=null) {
			switch($txn) {
				case 'list':
					$m_bir = $this->Bir_2307_model;
					// $m_journal_info=$this->Receivable_payment_model;

					$startDate=date("Y-m-d",strtotime($this->input->get('start',TRUE)));
					$endDate=date("Y-m-d",strtotime($this->input->get('end',TRUE)));
					$supplier_id=$this->input->get('sup_id');
					$response['data']=$m_bir->get_2307($startDate,$endDate,$supplier_id);
					echo json_encode($response);
				break;
		
			}
		}
	}
?>