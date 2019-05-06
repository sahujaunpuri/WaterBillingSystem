<?php
	defined('BASEPATH') OR exit('No direct script access allowed.');

	class Bank_reconciliation extends CORE_Controller
	{
		
		function __construct()
		{
			parent::__construct();
			$this->validate_session();
			$this->load->model(
				array(
					'Bank_model',
					'Journal_info_model',
					'Account_title_model',
					'Bank_reconciliation_model',
					'Users_model',
					'Company_model',
					'Bank_reconciliation_details_model'
				)
			);
		}

		public function index()
		{
			$this->Users_model->validate();
			$data['_def_css_files'] = $this->load->view('template/assets/css_files', '', true);
	        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', true);
	        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', true);
	        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', true);
	        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', true);
	        $data['banks']=$this->Bank_model->get_list('is_active=TRUE AND is_deleted=FALSE');
	        $data['account_titles']=$this->Account_title_model->get_list('is_active=TRUE AND is_deleted=FALSE');
	        $data['title'] = 'Bank Reconciliation';
	        (in_array('11-1',$this->session->user_rights)? 
	        $this->load->view('bank_reconciliation_view', $data)
	        :redirect(base_url('dashboard')));
	        
		}

		function transaction($txn) 
		{
			switch ($txn) {
				case 'list':
					$m_journal=$this->Journal_info_model;

					$startDate=date('Y-m-d',strtotime($this->input->get('sDate',TRUE)));
					$endDate=date('Y-m-d',strtotime($this->input->get('eDate',TRUE)));
					$account_id=$this->input->get('accountid',TRUE);

					$response['data']=$m_journal->get_bank_recon($account_id,$startDate,$endDate);

					echo json_encode($response);
					break;

				case 'reconcile-check':
					$m_bankr = $this->Bank_reconciliation_model;
					$m_bank_details = $this->Bank_reconciliation_details_model;

					$m_bankr->begin();
					$m_bankr->set('date_reconciled','NOW()');
					$m_bankr->bank_id=$this->input->post('bank_id',TRUE);
					$m_bankr->reconciled_by=$this->session->user_id;
					$m_bankr->account_id=$this->input->post('account_id',TRUE);
					$m_bankr->account_balance=$this->get_numeric_value($this->input->post('account_balance',TRUE));
					$m_bankr->bank_service_charge=$this->get_numeric_value($this->input->post('bank_service_charge',TRUE));
					$m_bankr->nsf_check=$this->get_numeric_value($this->input->post('nsf_check',TRUE));
					$m_bankr->check_printing_charge=$this->get_numeric_value($this->input->post('check_printing_charge',TRUE));
					$m_bankr->interest_earned=$this->get_numeric_value($this->input->post('interest_earned',TRUE));
					$m_bankr->notes_receivable=$this->get_numeric_value($this->input->post('notes_receivable',TRUE));
					$m_bankr->actual_balance=$this->get_numeric_value($this->input->post('actual_balance',TRUE));
					$m_bankr->outstanding_checks=$this->get_numeric_value($this->input->post('outstanding_checks',TRUE));
					$m_bankr->deposit_in_transit=$this->get_numeric_value($this->input->post('deposit_in_transit',TRUE));
					$m_bankr->journal_adjusted_collection=$this->get_numeric_value($this->input->post('journal_adjusted_collection',TRUE));
					$m_bankr->bank_adjusted_collection=$this->get_numeric_value($this->input->post('bank_adjusted_collection',TRUE));
					$m_bankr->save();

					$bank_recon_id = $m_bankr->last_insert_id();
					$m_journal=$this->Journal_info_model;

					$journal_id = $this->input->post('journal_id');
					$check_status = $this->input->post('check_status');

					for($i=0;$i<count($journal_id);$i++)
					{
						$m_bank_details->bank_recon_id=$bank_recon_id;
						$m_bank_details->journal_id=$journal_id[$i];
						$m_bank_details->check_status=$check_status[$i];
						$m_bank_details->save();

						$m_journal->is_reconciled=1;
						$m_journal->modify('journal_id='.$journal_id[$i]);
					}

					$m_bankr->commit();

					if($m_bankr->status()===TRUE){
	                    $response['title'] = 'Success!';
	                    $response['stat'] = 'success';
	                    $response['msg'] = 'Bank successfully reconciled';

	                    echo json_encode($response);
	                }
					break;

				case 'get-history':
					$m_bankr = $this->Bank_reconciliation_model;

					$response['data'] = $m_bankr->get_list(
						null,
						'bank_reconciliation.*, CONCAT(ua.user_fname," ", ua.user_lname) AS fullname,b.*,at.account_title,DATE_FORMAT(bank_reconciliation.date_reconciled,"%m/%d/%Y") as date_reconciled',
						array(
							array('user_accounts as ua','ua.user_id=bank_reconciliation.reconciled_by','left'),
							array('account_titles as at','at.account_id=bank_reconciliation.account_id','left'),
							array('bank as b','b.bank_id=bank_reconciliation.bank_id','left')
						)
					);

					echo json_encode($response);
					break;
				
				case 'get-account-balance':
					$m_journal=$this->Journal_info_model;

					$account_id=$this->input->get('account_id');

					$account_balance=$m_journal->get_list(
						'ja.account_id='.$account_id.'
						AND journal_info.is_deleted=FALSE
						AND journal_info.is_active=TRUE',
						'IFNULL(IF(ac.account_type_id = 1 OR ac.account_type_id = 5,
						(SUM(ja.dr_amount) - SUM(ja.cr_amount)),
						(SUM(ja.cr_amount) - SUM(ja.dr_amount))),0) AS Balance',
						array(
							array('journal_accounts as ja','ja.journal_id=journal_info.journal_id','inner'),
							array('account_titles as at','at.account_id = ja.account_id','left'),
							array('account_classes as ac','ac.account_class_id=at.account_class_id','left')
						)
					);

					$response['data']=number_format($account_balance[0]->Balance,2);

					echo json_encode($response);
					break;

				case 'print-history':
	                $m_company_info=$this->Company_model;
	                $company_info=$m_company_info->get_list();
	                $data['company_info']=$company_info[0];
					$m_bankr = $this->Bank_reconciliation_model;
					$id=$this->input->get('id');
					$data['data'] = $m_bankr->get_list(
						$id,
						'bank_reconciliation.*, CONCAT(ua.user_fname," ", ua.user_lname) AS fullname,b.*,at.account_title,DATE_FORMAT(bank_reconciliation.date_reconciled,"%m/%d/%Y") as date_reconciled',
						array(
							array('user_accounts as ua','ua.user_id=bank_reconciliation.reconciled_by','left'),
							array('account_titles as at','at.account_id=bank_reconciliation.account_id','left'),
							array('bank as b','b.bank_id=bank_reconciliation.bank_id','left')
						)
					)[0];
					$data['outs']=$this->Bank_reconciliation_details_model->get_list('bank_reconciliation_details.check_status = 1 and bank_reconciliation_details.bank_recon_id='.$id,
						'bank_reconciliation_details.*,journal_info.check_no,DATE_FORMAT(journal_info.check_date,"%M %d") as check_date,journal_info.amount',
						array(array('journal_info','journal_info.journal_id=bank_reconciliation_details.journal_id','left'))

						);

					$this->load->view('template/bank_recon_content',$data);
					break;
			}
		}
	}
?>