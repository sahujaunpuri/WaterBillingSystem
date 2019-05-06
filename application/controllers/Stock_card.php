<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Stock_card extends CORE_Controller
	{
		function __construct()
		{
			parent::__construct();
			$this->validate_session();
			$this->load->model(
				array(
					'Products_model',
					'Users_model',
					'Company_model'
				)
			);
			$this->load->library('M_pdf');
	        $this->load->library('excel');
	        $this->load->model('Email_settings_model');
		}

		public function index()
		{
			$this->Users_model->validate();
	        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', true);
	        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', true);
	        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', true);
	        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', true);
	        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', true);
	        $data['title'] = 'Stock Card / Bin Card';
	        $data['products']= $this->Products_model->get_list(array('is_active'=>TRUE,'is_deleted'=>FALSE ),'product_id,product_desc,is_bulk');

	        if(in_array('5-1',$this->session->user_rights)){
	        	$this->load->view('stock_card_view',$data);
	       	}else{
	       		redirect(base_url('dashboard'));
	       	}
		}

		function transaction($txn)
		{
			switch ($txn)
			{


			}
		}
	}
?>
