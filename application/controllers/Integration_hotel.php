<?php
	defined('BASEPATH') OR die('direct script access is not allowed');

	class Integration_hotel extends CORE_Controller
	{
		
		function __construct()
		{
			parent::__construct();
			$this->validate_session();
			$this->load->model(
				array(
					'Journal_info_model',
					'Users_model',
					'Integration_hotel_model',
					// 'Pos_integration_model',
					'Company_model',
					'Journal_account_model',
					'Customers_model',
					'Departments_model',
					'Account_title_model',
					'Hotel_integration_model',
					'Accounting_period_model'



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
	        $data['accounts']=$this->Account_title_model->get_list('is_active=TRUE AND is_deleted=FALSE');
	        $data['departments']=$this->Departments_model->get_list('is_active=TRUE AND is_deleted=FALSE');
        // (in_array('16-3',$this->session->user_rights)? 
        $this->load->view('integration_hotel_view',$data);
        // :redirect(base_url('dashboard')));
	        
		}

		function transaction($txn=null,$id_filter=null){
			switch ($txn) {
				case 'list':
					$m_items = $this->Integration_hotel_model;
					$aod=date('Y-m-d',strtotime($this->input->get('aod',TRUE)));
					$department_id=$this->input->get('dp',TRUE);
					$response['data']=$m_items->get_list_hotel_items($aod,$department_id);
					// $items=$m_items->get_pos_list_front_end($aod);
					// $response['data']=$items;

					// $i = 0;
					// foreach ($items as $item) {
					// 	if($item->is_equal == 0){
					// 		$i++;
					// 	}

					// }
					// if($i > 0){

     //            $response['stat']="error";
     //            $response['title']="Unequal Transaction Detected!";
     //            $response['msg']="There is an unequal distribution of amount.";
					// }


					echo json_encode($response);
				break;

			case 'integration-for-review':
				$m_items = $this->Integration_hotel_model;
				$m_customers = $this->Customers_model;
				$m_departments = $this->Departments_model;
				$m_accounts=$this->Account_title_model;
				$info=$m_items->get_list($id_filter,
					'hotel_items.*,
					DATE_FORMAT(hotel_items.sales_date,"%m/%d/%Y") as date_sales');
				$type = $info[0]->item_type;
				$department_id = $info[0]->department_id; // use department ID as hotel_settings_id
				
				if($type == 'ADV'){
					$entries =$m_items->adv_journal_entries($id_filter,$department_id); 
				} else if($type == 'COUT'){
					$entries =$m_items->cout_journal_entries($id_filter,$department_id); 
				}else if($type == 'REV'){
					$entries =$m_items->rev_journal_entries($id_filter,$department_id); 
				}else if($type == 'STR'){
					$entries =$m_items->str_journal_entries($id_filter,$department_id); 
				}
				$customers_info = $this->Hotel_integration_model->get_list($department_id);
                $data['customer_id']= $customers_info[0]->customer_id;
                $customer_id = $customers_info[0]->customer_id; 
                $data['customers']=$m_customers->get_list(array('customers.is_active'=>TRUE,'customers.is_deleted'=>FALSE),
					array('customers.customer_id','customers.customer_name'));
                $valid_customer=$m_customers->get_list(array('customer_id'=>$customer_id,'is_active'=>TRUE,'is_deleted'=>FALSE));
                $data['valid_particular']=(count($valid_customer)>0);
                $data['departments']=$m_departments->get_list(array('is_active'=>TRUE,'is_deleted'=>FALSE));
                $data['accounts']=$m_accounts->get_list(array('account_titles.is_active'=>TRUE,'account_titles.is_deleted'=>FALSE));
				$data['info']=$info[0];
				$data['entries']=$entries;
					echo $this->load->view('template/integration_hotel_review_content',$data,TRUE);
				break;



				case 'finalize':
                $m_journal=$this->Journal_info_model;
                $m_journal_accounts=$this->Journal_account_model;
                $hotel_items_id = $this->input->post('hotel_items_id');

                //validate if still in valid range
                $valid_range=$this->Accounting_period_model->get_list("'".date('Y-m-d',strtotime($this->input->post('date_txn',TRUE)))."'<=period_end");
                if(count($valid_range)>0){
                    $response['stat']='error';
                    $response['title']='<b>Accounting Period is Closed!</b>';
                    $response['msg']='Please make sure transaction date is valid!<br />';
                    die(json_encode($response));
                }

                $valid_id=$this->Integration_hotel_model->get_list('is_posted = TRUE AND hotel_items_id='.$hotel_items_id);
                if(count($valid_id)>0){

                	$journal_info_validate = $m_journal->get_list('hotel_integration_id='.$hotel_items_id,'txn_no');
                    $response['stat']='error';
                    $response['title']='<b>Already Posted!</b>';
                    $response['msg']='Please  Check '.$journal_info_validate[0]->txn_no.' in the Sales Journal!<br />';
                    die(json_encode($response));
                }


                $m_journal->customer_id=$this->input->post('customer_id',TRUE);
                $m_journal->department_id=$this->input->post('department_id',TRUE);
                $m_journal->remarks=$this->input->post('remarks',TRUE);
                $m_journal->hotel_integration_id=$this->input->post('hotel_items_id',TRUE);
                $m_journal->date_txn=date('Y-m-d',strtotime($this->input->post('date_txn',TRUE)));
                $m_journal->book_type='SJE';
                $m_journal->ref_no=$this->input->post('ref_no',TRUE);
                $m_journal->is_sales=1;

                //for audit details
                $m_journal->set('date_created','NOW()');
                $m_journal->created_by_user=$this->session->user_id;
                $m_journal->save();					

				$journal_id=$m_journal->last_insert_id();
                $accounts=$this->input->post('accounts',TRUE);
                $memos=$this->input->post('memo',TRUE);
                $dr_amounts=$this->input->post('dr_amount',TRUE);
                $cr_amounts=$this->input->post('cr_amount',TRUE);

                for($i=0;$i<=count($accounts)-1;$i++){
                    $m_journal_accounts->journal_id=$journal_id;
                    $m_journal_accounts->account_id=$accounts[$i];
                    $m_journal_accounts->memo=$memos[$i];
                    $m_journal_accounts->dr_amount=$this->get_numeric_value($dr_amounts[$i]);
                    $m_journal_accounts->cr_amount=$this->get_numeric_value($cr_amounts[$i]);
                    $m_journal_accounts->save();
                }
                $m_journal->txn_no='TXN-'.date('Ymd').'-'.$journal_id;
                $m_journal->modify($journal_id);
                // mark as posted hotel items
                $m_items=$this->Integration_hotel_model;
                $m_items->is_posted = 1;
                $m_items->journal_id = $journal_id;
                $m_items->posted_by=$this->session->user_id;
                $m_items->set('posted_date','NOW()');
                $m_items->modify($hotel_items_id);

				
                $response['stat']="success";
                $response['title']="Success!";
                $response['msg']="Information successfully Posted";
				


					echo json_encode($response);
				break;



            case 'upload':
                $allowed = array('jdev');

                $data=array();
                $files=array();
                $directory='assets/files/quickie_reports/';

				$duplicate_count = 0;
				$success_count = 0;
				$invalid_extension_count = 0;
                foreach($_FILES as $file){

	                $server_file_name=uniqid('');
	                $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
	                $file_path=$directory.date("Y-m-d").'-'.date("H-i-s").'-'.$file['name'];
	                $orig_file_name=$file['name'];
					$m_hotel_items = $this->Integration_hotel_model;


					$duplicatecheck = count($m_hotel_items->get_list(array('hotel_items.file_path='=>$orig_file_name)));


					if($duplicatecheck > 0){
						$duplicate_count ++ ;
					}else{
			                    if(!in_array(strtolower($extension), $allowed)){
			                        $response['title']='Invalid!';
			                        $response['stat']='error';
			                        $response['msg']='File is invalid. Please select a valid file!';
			                        die(json_encode($response));
			                    	$invalid_extension_count ++;

			                    }else{ 

			                    	if(move_uploaded_file($file['tmp_name'],$file_path)){
				                    	$success_count ++;
							            $names=file($file_path);

										foreach($names as $name)
										{
									    	$name =explode('|', $name);
									        $m_hotel_items->item_type=$name[0];
									        $m_hotel_items->department_id=$name[1];
									        $m_hotel_items->sales_date=date('Y-m-d',strtotime($name[2]));
									        $m_hotel_items->shift=$name[3];

									        $m_hotel_items->adv_cash=$name[4];
									        $m_hotel_items->adv_check=$name[5];
									        $m_hotel_items->adv_card=$name[6];
									        $m_hotel_items->adv_charge=$name[7];
									        $m_hotel_items->adv_bank=$name[8];

									        $m_hotel_items->cash_amount=$name[9];
									        $m_hotel_items->check_amount=$name[10];
									        $m_hotel_items->card_amount=$name[11];
									        $m_hotel_items->charge_amount=$name[12];
									        $m_hotel_items->bank_amount=$name[13];

									        $m_hotel_items->room_sales=$name[14];
									        $m_hotel_items->bar_sales=$name[15];
									        $m_hotel_items->other_sales=$name[16];

									        $m_hotel_items->advance_sales=$name[17];

									        $m_hotel_items->file_path=$file['name'];
									        $m_hotel_items->save();
										}
									}
			                    } //end of if else extension checking
			        } // end of duplicate checking
            	} // end of foreach files

                        $response['title']='Uploaded. <br>'.$success_count.' Successful<br>'.$duplicate_count.' Duplicate Text file<br>'.$invalid_extension_count.' Invalid Extension<br>' ;
                        $response['stat']='info';
                        $response['msg']='Text File(s) successfully validated and uploaded.';
                        echo json_encode($response);

                break;


			}
		}
	}
?>