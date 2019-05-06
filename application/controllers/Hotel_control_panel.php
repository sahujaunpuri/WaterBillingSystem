<?php
	defined('BASEPATH') OR die('direct script access is not allowed');

	class Hotel_control_panel extends CORE_Controller
	{
		
		function __construct()
		{
			parent::__construct();
			$this->validate_session();
			$this->load->model(
				array(
					'Journal_info_model',
					'Users_model',
					'Hotel_integration_items_model',
					'Hotel_integration_model',
					'Company_model',
					'Journal_account_model',
					'Customers_model',
					'Departments_model'


				)
			);
	        $this->load->library('excel');
	        $this->load->model('Email_settings_model');
		}

		public function index() {
			$this->Users_model->validate();
			$data['_def_css_files'] = $this->load->view('template/assets/css_files', '', true);
	        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', true);
	        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', true);
	        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', true);
	        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', true);
	        $data['title'] = 'Hotel Integration Control Panel';
        (in_array('15-1',$this->session->user_rights)? 
        $this->load->view('hotel_control_panel_view',$data)
        :redirect(base_url('dashboard')));
	        
		}

		function transaction($txn=null){
			switch ($txn) {
				case 'list':
					$m_items = $this->Hotel_integration_items_model;

					$aod=date('Y-m-d',strtotime($this->input->get('aod',TRUE)));
					$items=$m_items->get_hotel_list_front_end($aod);
					$response['data']=$items;

					echo json_encode($response);
				break;

				case 'finalize':
					$m_items = $this->Hotel_integration_items_model;
					$m_hotel = $this->Hotel_integration_model;
					$hotel_accounts = $m_hotel->get_list();
					$department_id = $hotel_accounts[0]->department_id;
					$aod=date('Y-m-d',strtotime($this->input->post('txt_date',TRUE)));
					$items_finalize=$m_items->get_hotel_list_balanced($aod);

					$m_journal = $this->Journal_info_model;
					$m_journal_accounts=$this->Journal_account_model;

					$is_not_equal = 0;
					foreach ($items_finalize as $item) {

						if($item->is_equal == '0'){
							$is_not_equal++;
						}else{


							if($item->ar_guest_id == 0){ // means checkout only
								$customer_id = $item->guest_id;
								$customer_name = $item->guest_name; 

								$m_journal->remarks='Sales date: '.$item->sales_date.', Reference no: '.$item->ref_no;
							}else { // means checkout with AR ( Accounts Receivable)
								$customer_id = $item->ar_guest_id;
								$customer_name = $item->ar_guest_name;
								$m_journal->remarks='Sales date: '.$item->sales_date.', Reference no: '.$item->ref_no.', Original Billing From '.$item->guest_name.' transferred to '.$item->ar_guest_name;
							}

						$m_customers = $this->Customers_model;
						$list = $m_customers->get_list(array('pos_customer_id' => $customer_id));
						$count = count($list);

						if($count > 0) { // if customer already existing 
							$m_journal->customer_id = $list[0]->customer_id;
							$m_customers->customer_name=$customer_name;
							$m_customers->modify($list[0]->customer_id);

						}else{
							$m_customers->pos_customer_id=$customer_id;
							$m_customers->customer_name=$customer_name;
							$m_customers->save();
							$customer_id=$m_customers->last_insert_id();
							$m_journal->customer_id = $customer_id;

						}

						$m_journal->book_type = 'SJE';
						$m_journal->is_sales = 1;
						$m_journal->department_id = $department_id;
						$m_journal->ref_no=$item->ref_no;
						$m_journal->hotel_integration_id=$item->hotel_integration_items_id;


						$m_journal->set('date_created','NOW()');
						$m_journal->date_txn=date('Y-m-d',now());
						$m_journal->created_by_user=$this->session->user_id;
						$m_journal->save();
						$journal_id=$m_journal->last_insert_id();

			                if($item->item_type == "COUT"){
			                    $entries = $m_items->get_hotel_entries_journal_cout($item->hotel_integration_items_id);
			                }

			                foreach ($entries as $entry) {
			                    $m_journal_accounts->journal_id=$journal_id;
			                    $m_journal_accounts->account_id=$entry->account_id;
			                    $m_journal_accounts->memo='';
			                    $m_journal_accounts->dr_amount=$this->get_numeric_value($entry->dr_amount);
			                    $m_journal_accounts->cr_amount=$this->get_numeric_value($entry->cr_amount);
			                    $m_journal_accounts->save();
			                }

		                $m_journal->txn_no='TXN-'.date('Ymd').'-'.$journal_id;
		                $m_journal->modify($journal_id);
		                $m_items->is_posted = 1;
						$m_items->set('posted_date','NOW()');
		                $m_items->posted_by=$this->session->user_id;
		                $m_items->modify($item->hotel_integration_items_id);

					}


						}

                $response['stat']="success";
                $response['title']="Success!";
                $response['msg']="Hotel System Sales Successfully Integrated.";

					echo json_encode($response);
				break;



			}
		}
	}
?>