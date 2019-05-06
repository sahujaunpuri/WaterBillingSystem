<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Form_2307 extends CORE_Controller
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
	        $company_info=$this->Company_model->get_list();
	        $data['company_info']=$company_info[0];
	        $data['title'] = 'Bir Form 2307';
        (in_array('12-3',$this->session->user_rights)? 
        $this->load->view('form_2307_view',$data)
        :redirect(base_url('dashboard')));
		}

		function transaction($txn=null) {
			switch($txn) {
				case 'list':
					$m_bir = $this->Bir_2307_model;
					$month=$this->input->get('month',TRUE);
					$year=$this->input->get('year',TRUE);
					$supplier_id=$this->input->get('sup_id');
					$response['data']=$m_bir->get_2307_files($month,$year,$supplier_id);
					echo json_encode($response);
				break;

				case 'list-table':
					$m_bir = $this->Bir_2307_model;
					$response['data']=$m_bir->get_list(array('form_2307.is_active'=>TRUE,'form_2307.is_deleted'=>FALSE),
						'form_2307.*,
						DATE_FORMAT(form_2307.date, "%M %Y") as form_date,
						s.tax_output,
						s.supplier_name',

						array(
							array('suppliers s','s.supplier_id = form_2307.supplier_id','left')
							)
						);
					echo json_encode($response);
				break;


				case 'create':

				$m_bir=$this->Bir_2307_model;
				$month = $this->input->post('month',true);
				$year = $this->input->post('year',true);
				$supplier_id=$this->input->post('supplier_id',true);

				$validate = $m_bir->get_2307_validate($month,$year,$supplier_id);
				if(count($validate) > 0){
					$response['stat']='error';
                    $response['title']='<b>Invalid Period!</b>';
                    $response['msg']='A record with the same supplier and date exists!<br />';
                    die(json_encode($response));
				}

				$m_bir->date=$year.'-'.$month.'-00';
				$m_bir->supplier_id=$this->input->post('supplier_id',true);
				$m_bir->payee_tin=$this->input->post('payee_tin',true);
				$m_bir->payee_name=$this->input->post('payee_name',true);
				$m_bir->payee_address=$this->input->post('payee_address',true);
				$m_bir->payor_tin=$this->input->post('payor_tin',true);
				$m_bir->payor_name=$this->input->post('payor_name',true);
				$m_bir->payor_address=$this->input->post('payor_address',true);
				$m_bir->gross_amount=$this->get_numeric_value($this->input->post('gross_amount',true));
				$m_bir->deducted_amount=$this->get_numeric_value($this->input->post('deducted_amount',true));
				$m_bir->created_by_user=$this->session->user_id;
				$m_bir->set('date_created','NOW()'); 
				$m_bir->save();
                $response['title'] = 'Success!';
                $response['stat'] = 'success';
                $response['msg'] = 'Form 2307 successfully created.';
                $form_2307_id=$m_bir->last_insert_id();	
                $response['row_added']=$m_bir->get_list($form_2307_id,
					'form_2307.*,
					DATE_FORMAT(form_2307.date, "%M %Y") as form_date,
					s.tax_output,
					s.supplier_name',

					array(
						array('suppliers s','s.supplier_id = form_2307.supplier_id','left')
						)
				);

					echo json_encode($response);

				break;
		
            case 'delete':

                $m_bir=$this->Bir_2307_model;
                $form_2307_id=$this->input->post('form_2307_id',TRUE);

                $m_bir->set('date_deleted','NOW()'); //treat NOW() as function and not string
                $m_bir->deleted_by_user=$this->session->user_id;//user that deleted the record
                $m_bir->is_deleted=1;//
                $m_bir->modify($form_2307_id);


                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Record successfully deleted.';
                echo json_encode($response);

            break;

            case 'print':

                $m_bir=$this->Bir_2307_model;
                $form_2307_id=$this->input->get('id',TRUE);

                $data=$m_bir->get_list($form_2307_id,
					'form_2307.*,
					DATE_FORMAT(form_2307.date, "%M %Y") as form_date,
					DATE_FORMAT(form_2307.date, "%m") as date_month,
					DATE_FORMAT(form_2307.date, "%y") as date_year,
					DATE_FORMAT(LAST_DAY(form_2307.date), "%d") as month_end,
					s.tax_output,
					s.supplier_name',

					array(
						array('suppliers s','s.supplier_id = form_2307.supplier_id','left')
						)
				);
				$data['form']=$data[0];


				 $this->load->view('template/form_2307_content',$data);

            break;



			}
		}
	}
?>