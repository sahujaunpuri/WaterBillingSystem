<?php
	defined('BASEPATH') OR die('direct script access is not allowed');

	class Replenishment_report extends CORE_Controller
	{
		
		function __construct()
		{
			parent::__construct();
			$this->validate_session();
			$this->load->model(
				array(
					'Journal_info_model',
					'Users_model',
					'Company_model'
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
	        $data['title'] = 'Replenishment Report';
        (in_array('9-13',$this->session->user_rights)? 
        $this->load->view('replenishment_report_view',$data)
        :redirect(base_url('dashboard')));
	        
		}

		function transaction($txn=null){
			switch ($txn) {
				case 'list':
					$m_journal=$this->Journal_info_model;

					$aod=date('Y-m-d',strtotime($this->input->get('aod',TRUE)));

					$response['data']=$m_journal->get_list(
						'journal_info.is_active=TRUE AND
						journal_info.is_deleted=FALSE AND
						journal_info.book_type="PCV" AND
						account_classes.account_type_id=5 AND
						journal_info.is_replenished=TRUE AND
						journal_info.date_txn <= "'.$aod.'"',
						'journal_info.txn_no,
						journal_info.supplier_id,
						journal_info.remarks,
						journal_info.amount,
						journal_info.ref_no,
						journal_info.journal_id,
						journal_info.department_id,
						departments.*,
						DATE_FORMAT(journal_info.date_txn,"%m/%d/%Y") AS date_txn,
						suppliers.*,
						batch_info.*,
						journal_accounts.account_id',
						array(
							array('suppliers','suppliers.supplier_id=journal_info.supplier_id','left'),
							array('journal_accounts','journal_accounts.journal_id=journal_info.journal_id','inner'),
							array('batch_info','batch_info.batch_id=journal_info.batch_id','inner'),
							array('account_titles','account_titles.account_id=journal_accounts.account_id','left'),
							array('account_classes','account_classes.account_class_id=account_titles.account_class_id','left'),
							array('departments','departments.department_id=journal_info.department_id','left')
						)
					);

					echo json_encode($response);
				break;

				case 'report':
					$m_journal=$this->Journal_info_model;
					$m_company=$this->Company_model;

					$aod=date('Y-m-d',strtotime($this->input->get('aod',TRUE)));

					$company_info=$m_company->get_list();

					$data['company_info']=$company_info[0];

					$data['batches']=$m_journal->get_list(
						'journal_info.is_active=TRUE AND
						journal_info.is_deleted=FALSE AND
						journal_info.book_type="PCV" AND
						journal_info.is_replenished=TRUE AND
						journal_info.date_txn <= "'.$aod.'"',
						'DISTINCT(batch_info.batch_no),
						batch_info.*',
						array(
							array('batch_info','batch_info.batch_id=journal_info.batch_id','inner')
						)
					);

					$data['replenishments']=$m_journal->get_list(
						'journal_info.is_active=TRUE AND
						journal_info.is_deleted=FALSE AND
						journal_info.book_type="PCV" AND
						account_classes.account_type_id=5 AND
						journal_info.is_replenished=TRUE AND
						journal_info.date_txn <= "'.$aod.'"',
						'journal_info.txn_no,
						journal_info.supplier_id,
						journal_info.remarks,
						journal_info.amount,
						journal_info.ref_no,
						journal_info.journal_id,
						journal_info.department_id,
						departments.*,
						DATE_FORMAT(journal_info.date_txn,"%m/%d/%Y") AS date_txn,
						suppliers.*,
						batch_info.*,
						journal_accounts.account_id',
						array(
							array('suppliers','suppliers.supplier_id=journal_info.supplier_id','left'),
							array('journal_accounts','journal_accounts.journal_id=journal_info.journal_id','inner'),
							array('batch_info','batch_info.batch_id=journal_info.batch_id','inner'),
							array('account_titles','account_titles.account_id=journal_accounts.account_id','left'),
							array('account_classes','account_classes.account_class_id=account_titles.account_class_id','left'),
							array('departments','departments.department_id=journal_info.department_id','left')
						)
					);

					$this->load->view('template/replenishment_report_html',$data);
				break;

//EXPORT
				case 'export':
                	$excel=$this->excel;
					$m_journal=$this->Journal_info_model;
					$m_company=$this->Company_model;

					$aod=date('Y-m-d',strtotime($this->input->get('aod',TRUE)));

					$company_info=$m_company->get_list();

					$data['company_info']=$company_info[0];

					$batches=$m_journal->get_list(
						'journal_info.is_active=TRUE AND
						journal_info.is_deleted=FALSE AND
						journal_info.book_type="PCV" AND
						journal_info.is_replenished=TRUE AND
						journal_info.date_txn <= "'.$aod.'"',
						'DISTINCT(batch_info.batch_no),
						batch_info.*',
						array(
							array('batch_info','batch_info.batch_id=journal_info.batch_id','inner')
						)
					);

					$replenishments=$m_journal->get_list(
						'journal_info.is_active=TRUE AND
						journal_info.is_deleted=FALSE AND
						journal_info.book_type="PCV" AND
						account_classes.account_type_id=5 AND
						journal_info.is_replenished=TRUE AND
						journal_info.date_txn <= "'.$aod.'"',
						'journal_info.txn_no,
						journal_info.supplier_id,
						journal_info.remarks,
						journal_info.amount,
						journal_info.ref_no,
						journal_info.journal_id,
						journal_info.department_id,
						departments.*,
						DATE_FORMAT(journal_info.date_txn,"%m/%d/%Y") AS date_txn,
						suppliers.*,
						batch_info.*,
						journal_accounts.account_id',
						array(
							array('suppliers','suppliers.supplier_id=journal_info.supplier_id','left'),
							array('journal_accounts','journal_accounts.journal_id=journal_info.journal_id','inner'),
							array('batch_info','batch_info.batch_id=journal_info.batch_id','inner'),
							array('account_titles','account_titles.account_id=journal_accounts.account_id','left'),
							array('account_classes','account_classes.account_class_id=account_titles.account_class_id','left'),
							array('departments','departments.department_id=journal_info.department_id','left')
						)
					);
                	
                	$excel->setActiveSheetIndex(0);

	                $excel->getActiveSheet()->getColumnDimensionByColumn('A1')->setWidth('50');
	                $excel->getActiveSheet()->getColumnDimensionByColumn('A2:B2')->setWidth('50');
	                $excel->getActiveSheet()->getColumnDimensionByColumn('A3')->setWidth('50');
	                $excel->getActiveSheet()->getColumnDimensionByColumn('A4')->setWidth('50');
	                //name the worksheet
	                $excel->getActiveSheet()->setTitle("REPLENISHMENT REPORT");
	                $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->mergeCells('A2:C2');
	                $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
	                                        ->setCellValue('A2',$company_info[0]->company_address)
	                                        ->setCellValue('A3',$company_info[0]->landline.'/'.$company_info[0]->mobile_no)
	                                        ->setCellValue('A4',$company_info[0]->email_address);

	                $excel->getActiveSheet()->setCellValue('A6','REPLENISHMENT REPORT')
	                                        ->getStyle('A6')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->setCellValue('A7','as of '.$aod)
	                                        ->getStyle('A7')->getFont()->setBold(TRUE);

	                $i=9;

	                foreach ($batches as $batch){
		                $excel->getActiveSheet()->getColumnDimension('A')->setWidth('50');
		                $excel->getActiveSheet()->getColumnDimension('B')->setWidth('50');
		                $excel->getActiveSheet()->getColumnDimension('C')->setWidth('50');
		                $excel->getActiveSheet()->getColumnDimension('D')->setWidth('50');

	                	$excel->getActiveSheet()->setCellValue('A'.$i,'BATCH #: '.$batch->batch_no)
	                                        	->getStyle('A'.$i)->getFont()->setBold(TRUE);
	                    $i++;

		                $excel->getActiveSheet()
		                        ->getStyle('D'.$i)
		                        ->getAlignment()
		                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

	                	$excel->getActiveSheet()->setCellValue('A'.$i,'Document # / PCV #')
	                                        	->getStyle('A'.$i)->getFont()->setBold(TRUE);
	                	$excel->getActiveSheet()->setCellValue('B'.$i,'Particular')
	                                        	->getStyle('B'.$i)->getFont()->setBold(TRUE);
	                	$excel->getActiveSheet()->setCellValue('C'.$i,'Remarks')
	                                        	->getStyle('C'.$i)->getFont()->setBold(TRUE);	                                        	
	                	$excel->getActiveSheet()->setCellValue('D'.$i,'Amount')
	                                        	->getStyle('D'.$i)->getFont()->setBold(TRUE);

	    				$sum_replenish_amount=0;

	    				foreach ($replenishments as $replenishment) {
	    					if ($batch->batch_id == $replenishment->batch_id) {
	    						$i++;

				                $excel->getActiveSheet()
				                        ->getStyle('D'.$i)
				                        ->getAlignment()
				                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

	                			$excel->getActiveSheet()->setCellValue('A'.$i,$replenishment->txn_no);
	                			$excel->getActiveSheet()->setCellValue('B'.$i,$replenishment->supplier_name);
	                			$excel->getActiveSheet()->setCellValue('C'.$i,$replenishment->remarks);
	                			$excel->getActiveSheet()->setCellValue('D'.$i,number_format($replenishment->amount,2))
                                      					->getStyle('D'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');

    							$sum_replenish_amount += $replenishment->amount; 

	    					}

	    				}
    						$i++;
			                $excel->getActiveSheet()
			                        ->getStyle('A'.$i)
			                        ->getAlignment()
			                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

			                $excel->getActiveSheet()
			                        ->getStyle('D'.$i)
			                        ->getAlignment()
			                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

	                		$excel->getActiveSheet()->setCellValue('A'.$i,'Total:')
                									->mergeCells('A'.$i.':'.'C'.$i);
                			$excel->getActiveSheet()->setCellValue('D'.$i,number_format($sum_replenish_amount,2))
                                  					->getStyle('D'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                            $i++;
	                }

	                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	                header('Content-Disposition: attachment;filename='."REPLENISHMENT REPORT.xlsx".'');
	                header('Cache-Control: max-age=0');
	                // If you're serving to IE 9, then the following may be needed
	                header('Cache-Control: max-age=1');

	                // If you're serving to IE over SSL, then the following may be needed
	                header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
	                header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
	                header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
	                header ('Pragma: public'); // HTTP/1.0

	                $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
	                $objWriter->save('php://output');  
				break;

//EMAIL
				case 'email':
                	$excel=$this->excel;
	                $m_email=$this->Email_settings_model;
	                $email=$m_email->get_list(2);
					$m_journal=$this->Journal_info_model;
					$m_company=$this->Company_model;

					$aod=date('Y-m-d',strtotime($this->input->get('aod',TRUE)));

					$company_info=$m_company->get_list();

					$data['company_info']=$company_info[0];

					$batches=$m_journal->get_list(
						'journal_info.is_active=TRUE AND
						journal_info.is_deleted=FALSE AND
						journal_info.book_type="PCV" AND
						journal_info.is_replenished=TRUE AND
						journal_info.date_txn <= "'.$aod.'"',
						'DISTINCT(batch_info.batch_no),
						batch_info.*',
						array(
							array('batch_info','batch_info.batch_id=journal_info.batch_id','inner')
						)
					);

					$replenishments=$m_journal->get_list(
						'journal_info.is_active=TRUE AND
						journal_info.is_deleted=FALSE AND
						journal_info.book_type="PCV" AND
						account_classes.account_type_id=5 AND
						journal_info.is_replenished=TRUE AND
						journal_info.date_txn <= "'.$aod.'"',
						'journal_info.txn_no,
						journal_info.supplier_id,
						journal_info.remarks,
						journal_info.amount,
						journal_info.ref_no,
						journal_info.journal_id,
						journal_info.department_id,
						departments.*,
						DATE_FORMAT(journal_info.date_txn,"%m/%d/%Y") AS date_txn,
						suppliers.*,
						batch_info.*,
						journal_accounts.account_id',
						array(
							array('suppliers','suppliers.supplier_id=journal_info.supplier_id','left'),
							array('journal_accounts','journal_accounts.journal_id=journal_info.journal_id','inner'),
							array('batch_info','batch_info.batch_id=journal_info.batch_id','inner'),
							array('account_titles','account_titles.account_id=journal_accounts.account_id','left'),
							array('account_classes','account_classes.account_class_id=account_titles.account_class_id','left'),
							array('departments','departments.department_id=journal_info.department_id','left')
						)
					);
                	
                	ob_start();
                	$excel->setActiveSheetIndex(0);

	                $excel->getActiveSheet()->getColumnDimensionByColumn('A1')->setWidth('50');
	                $excel->getActiveSheet()->getColumnDimensionByColumn('A2:B2')->setWidth('50');
	                $excel->getActiveSheet()->getColumnDimensionByColumn('A3')->setWidth('50');
	                $excel->getActiveSheet()->getColumnDimensionByColumn('A4')->setWidth('50');
	                //name the worksheet
	                $excel->getActiveSheet()->setTitle("REPLENISHMENT REPORT");
	                $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->mergeCells('A2:C2');
	                $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
	                                        ->setCellValue('A2',$company_info[0]->company_address)
	                                        ->setCellValue('A3',$company_info[0]->landline.'/'.$company_info[0]->mobile_no)
	                                        ->setCellValue('A4',$company_info[0]->email_address);

	                $excel->getActiveSheet()->setCellValue('A6','REPLENISHMENT REPORT')
	                                        ->getStyle('A6')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->setCellValue('A7','as of '.$aod)
	                                        ->getStyle('A7')->getFont()->setBold(TRUE);

	                $i=9;

	                foreach ($batches as $batch){
		                $excel->getActiveSheet()->getColumnDimension('A')->setWidth('50');
		                $excel->getActiveSheet()->getColumnDimension('B')->setWidth('50');
		                $excel->getActiveSheet()->getColumnDimension('C')->setWidth('50');
		                $excel->getActiveSheet()->getColumnDimension('D')->setWidth('50');

	                	$excel->getActiveSheet()->setCellValue('A'.$i,'BATCH #: '.$batch->batch_no)
	                                        	->getStyle('A'.$i)->getFont()->setBold(TRUE);
	                    $i++;

		                $excel->getActiveSheet()
		                        ->getStyle('D'.$i)
		                        ->getAlignment()
		                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

	                	$excel->getActiveSheet()->setCellValue('A'.$i,'Document # / PCV #')
	                                        	->getStyle('A'.$i)->getFont()->setBold(TRUE);
	                	$excel->getActiveSheet()->setCellValue('B'.$i,'Particular')
	                                        	->getStyle('B'.$i)->getFont()->setBold(TRUE);
	                	$excel->getActiveSheet()->setCellValue('C'.$i,'Remarks')
	                                        	->getStyle('C'.$i)->getFont()->setBold(TRUE);	                                        	
	                	$excel->getActiveSheet()->setCellValue('D'.$i,'Amount')
	                                        	->getStyle('D'.$i)->getFont()->setBold(TRUE);

	    				$sum_replenish_amount=0;

	    				foreach ($replenishments as $replenishment) {
	    					if ($batch->batch_id == $replenishment->batch_id) {
	    						$i++;

				                $excel->getActiveSheet()
				                        ->getStyle('D'.$i)
				                        ->getAlignment()
				                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

	                			$excel->getActiveSheet()->setCellValue('A'.$i,$replenishment->txn_no);
	                			$excel->getActiveSheet()->setCellValue('B'.$i,$replenishment->supplier_name);
	                			$excel->getActiveSheet()->setCellValue('C'.$i,$replenishment->remarks);
	                			$excel->getActiveSheet()->setCellValue('D'.$i,number_format($replenishment->amount,2))
                                      					->getStyle('D'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');

    							$sum_replenish_amount += $replenishment->amount; 

	    					}

	    				}
    						$i++;
			                $excel->getActiveSheet()
			                        ->getStyle('A'.$i)
			                        ->getAlignment()
			                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

			                $excel->getActiveSheet()
			                        ->getStyle('D'.$i)
			                        ->getAlignment()
			                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

	                		$excel->getActiveSheet()->setCellValue('A'.$i,'Total:')
                									->mergeCells('A'.$i.':'.'C'.$i);
                			$excel->getActiveSheet()->setCellValue('D'.$i,number_format($sum_replenish_amount,2))
                                  					->getStyle('D'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                            $i++;
	                }

	                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	                header('Content-Disposition: attachment;filename='."REPLENISHMENT REPORT.xlsx".'');
	                header('Cache-Control: max-age=0');
	                // If you're serving to IE 9, then the following may be needed
	                header('Cache-Control: max-age=1');

	                // If you're serving to IE over SSL, then the following may be needed
	                header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
	                header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
	                header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
	                header ('Pragma: public'); // HTTP/1.0

	                $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
	                $objWriter->save('php://output'); 
	                $data = ob_get_clean();

                            $file_name='Replenishment Report '.date('Y-m-d h:i:A', now());
                            $excelFilePath = $file_name.".xlsx"; //generate filename base on id
                            //download it.
                            // Set SMTP Configuration
                            $emailConfig = array(
                                'protocol' => 'smtp', 
                                'smtp_host' => 'ssl://smtp.googlemail.com', 
                                'smtp_port' => 465, 
                                'smtp_user' => $email[0]->email_address, 
                                'smtp_pass' => $email[0]->password, 
                                'mailtype' => 'html', 
                                'charset' => 'iso-8859-1'
                            );

                            // Set your email information
                            
                            $from = array(
                                'email' => $email[0]->email_address,
                                'name' => $email[0]->name_from
                            );

                            $to = array($email[0]->email_to);
                            $subject = 'Replenishment Report';
                          //  $message = 'Type your gmail message here';
                            $message = '<p>To: ' .$email[0]->email_to. '</p></ br>' .$email[0]->default_message.'</ br><p>Sent By: '. '<b>'.$this->session->user_fullname.'</b>'. '</p></ br>' .date('Y-m-d h:i:A', now());

                            // Load CodeIgniter Email library
                            $this->load->library('email', $emailConfig);
                            // Sometimes you have to set the new line character for better result
                            $this->email->set_newline("\r\n");
                            // Set email preferences
                            $this->email->from($from['email'], $from['name']);
                            $this->email->to($to);
                            $this->email->subject($subject);
                            $this->email->message($message);
                            $this->email->attach($data, 'attachment', $excelFilePath , 'application/ms-excel');
                            $this->email->set_mailtype("html");
                            // Ready to send email and check whether the email was successfully sent
                            if (!$this->email->send()) {
                                // Raise error message
                            $response['title']='Try Again!';
                            $response['stat']='error';
                            $response['msg']='Please check the Email Address of your Supplier or your Internet Connection.';

                            echo json_encode($response);
                            } else {
                                // Show success notification or other things here
                            $response['title']='Success!';
                            $response['stat']='success';
                            $response['msg']='Email Sent successfully.';

                            echo json_encode($response);
                            }

				break;

			}
		}
	}
?>