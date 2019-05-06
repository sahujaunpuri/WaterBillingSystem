<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class Depreciation_expense extends CORE_Controller
	{
		function __construct()
		{
			parent::__construct('');
			$this->validate_session();

			$this->load->model(
				array(
					'Users_model',
					'Fixed_asset_management_model',
					'Depreciation_expense_model',
					'Account_title_model'
				)
			);
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
	        $data['title'] = 'Depreciation Expense Report';
	        $data['accounts'] = $this->Account_title_model->get_list(array('is_deleted'=>FALSE));
	        $data['starting_year']=date('Y', strtotime('-100 year'));
	        $data['ending_year']=date('Y', strtotime('+10 year'));
	        $data['current_year']=date('Y');
	        (in_array('10-2',$this->session->user_rights)? 
	        $this->load->view('depreciation_expense_view',$data)
	        :redirect(base_url('dashboard')));
	        
		}

		function transaction($txn=null){
			switch($txn){
				case 'gdr-list':
					$m_fixed_asset=$this->Fixed_asset_management_model;

					$month=$this->input->get('m',TRUE);
					$year=$this->input->get('y',TRUE);

					$response['data']=$m_fixed_asset->get_depreciation_expense($month, $year);

					echo json_encode($response);
				break;

				case 'review-list':
					$m_depreciation_expense= $this->Depreciation_expense_model;
					$response['data']=$m_depreciation_expense->get_list(array('depreciation_expense.is_active'=>TRUE),
						array('depreciation_expense.de_id',
							'MONTHNAME(depreciation_expense.de_date) as de_month',
							'YEAR(depreciation_expense.de_date) as de_year',
							'depreciation_expense.de_expense_total',
							'depreciation_expense.de_remarks',
							'depreciation_expense.de_ref_no',
							'depreciation_expense.date_posted',
							'depreciation_expense.is_journal_posted'
							)
						);

					echo json_encode($response);
				break;

				case 'gdr-print':
					$m_fixed_asset=$this->Fixed_asset_management_model;

					$month=$this->input->get('m',TRUE);
					$year=$this->input->get('y',TRUE);

					$data['depreciation_expenses']=$m_fixed_asset->get_depreciation_expense($month, $year);

					$this->load->view('template/depreciation_expense_report',$data);
				break;

				case 'gdr-export':
                	$excel=$this->excel;					
					$m_fixed_asset=$this->Fixed_asset_management_model;

					$month=$this->input->get('m',TRUE);
					$year=$this->input->get('y',TRUE);

					$depreciation_expenses=$m_fixed_asset->get_depreciation_expense($month, $year);

                	$excel->setActiveSheetIndex(0);

	                $excel->getActiveSheet()->getColumnDimensionByColumn('A1:I1')->setWidth('50');
	                $excel->getActiveSheet()->getColumnDimensionByColumn('A3:I3')->setWidth('50');
	                //name the worksheet
	                $excel->getActiveSheet()->setTitle("REPLENISHMENT BATCH REPORT");

	                $excel->getActiveSheet()
	                        ->getStyle('A1')
	                        ->getAlignment()
	                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	                $excel->getActiveSheet()
	                        ->getStyle('A3')
	                        ->getAlignment()
	                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	                $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
					$excel->getActiveSheet()->getStyle("A1")->getFont()->setSize(16);	                
	                $excel->getActiveSheet()->mergeCells('A1:I1');
	                $excel->getActiveSheet()->mergeCells('A3:I3');
					$excel->getActiveSheet()->getStyle("A3")->getFont()->setSize(10);
	                $excel->getActiveSheet()->getStyle('A3')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->setCellValue('A1','Depreciation Expense Report')
	                                        ->setCellValue('A3','For the Month of '.date('F Y', strtotime($_GET['y'].'-'.$_GET['m'])));	

	                $excel->getActiveSheet()->getColumnDimension('A')->setWidth('20');
	                $excel->getActiveSheet()->getColumnDimension('B')->setWidth('20');
	                $excel->getActiveSheet()->getColumnDimension('C')->setWidth('25');
	                $excel->getActiveSheet()->getColumnDimension('D')->setWidth('25');	    
	                $excel->getActiveSheet()->getColumnDimension('E')->setWidth('10');	    
	                $excel->getActiveSheet()->getColumnDimension('F')->setWidth('25');	    
	                $excel->getActiveSheet()->getColumnDimension('G')->setWidth('45');	    
	                $excel->getActiveSheet()->getColumnDimension('H')->setWidth('40');	    
	                $excel->getActiveSheet()->getColumnDimension('I')->setWidth('20');	    

	                $excel->getActiveSheet()
	                        ->getStyle('A5')
	                        ->getAlignment()
	                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	                $excel->getActiveSheet()
	                        ->getStyle('B5')
	                        ->getAlignment()
	                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	                $excel->getActiveSheet()
	                        ->getStyle('C5')
	                        ->getAlignment()
	                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	                $excel->getActiveSheet()
	                        ->getStyle('D5')
	                        ->getAlignment()
	                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	                $excel->getActiveSheet()
	                        ->getStyle('E5')
	                        ->getAlignment()
	                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	                $excel->getActiveSheet()
	                        ->getStyle('F5')
	                        ->getAlignment()
	                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	                $excel->getActiveSheet()
	                        ->getStyle('G5')
	                        ->getAlignment()
	                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	                $excel->getActiveSheet()
	                        ->getStyle('H5')
	                        ->getAlignment()
	                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	                $excel->getActiveSheet()
	                        ->getStyle('I5')
	                        ->getAlignment()
	                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                	$excel->getActiveSheet()->setCellValue('A5','Asset Code')
                                        	->getStyle('A5')->getFont()->setBold(TRUE);
                	$excel->getActiveSheet()->setCellValue('B5','Description')
                                        	->getStyle('B5')->getFont()->setBold(TRUE);
                	$excel->getActiveSheet()->setCellValue('C5','Date Acquired')
                                        	->getStyle('C5')->getFont()->setBold(TRUE);
                	$excel->getActiveSheet()->setCellValue('D5','Acquisiotion Cost')
                                        	->getStyle('D5')->getFont()->setBold(TRUE);
                	$excel->getActiveSheet()->setCellValue('E5','Life')
                                        	->getStyle('E5')->getFont()->setBold(TRUE);
                	$excel->getActiveSheet()->setCellValue('F5','Salvage Value')
                                        	->getStyle('F5')->getFont()->setBold(TRUE);
                	$excel->getActiveSheet()->setCellValue('G5','Depreciation Expense (Monthly)')
                                        	->getStyle('G5')->getFont()->setBold(TRUE);
                	$excel->getActiveSheet()->setCellValue('H5','Accumulative Depreciation')
                                        	->getStyle('H5')->getFont()->setBold(TRUE);
                	$excel->getActiveSheet()->setCellValue('I5','Book Value')
                                        	->getStyle('I5')->getFont()->setBold(TRUE);

                    $i=6;                   	
					$totalacquisition = 0;
					$totalsalvage = 0;
					$totaldepreciation = 0;
					$totalaccumulative = 0;
					$totalbook  = 0;

					foreach ($depreciation_expenses as $depreciation_expense) {

	                $excel->getActiveSheet()
	                        ->getStyle('E')
	                        ->getAlignment()
	                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

	                	$excel->getActiveSheet()->setCellValue('A'.$i,$depreciation_expense->asset_code);
	                	$excel->getActiveSheet()->setCellValue('B'.$i,$depreciation_expense->asset_description);
	                	$excel->getActiveSheet()->setCellValue('C'.$i,date('F d,Y', strtotime($depreciation_expense->date_acquired)));
	                	$excel->getActiveSheet()->getStyle('D'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
	                	$excel->getActiveSheet()->setCellValue('D'.$i,number_format($depreciation_expense->acquisition_cost,2));
	                	$excel->getActiveSheet()->setCellValue('E'.$i,$depreciation_expense->life_years);
	                	$excel->getActiveSheet()->getStyle('F'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
	                	$excel->getActiveSheet()->setCellValue('F'.$i,number_format($depreciation_expense->salvage_value,2));
	                	$excel->getActiveSheet()->getStyle('G'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
	                	$excel->getActiveSheet()->setCellValue('G'.$i,number_format($depreciation_expense->depreciation_expense,2));
	                	$excel->getActiveSheet()->getStyle('H'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
	                	$excel->getActiveSheet()->setCellValue('H'.$i,number_format($depreciation_expense->accu_dep,2));
	                	$excel->getActiveSheet()->getStyle('I'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');                	
	                	$excel->getActiveSheet()->setCellValue('I'.$i,number_format($depreciation_expense->book_value,2));
	                	$i++;

						$totalacquisition += $depreciation_expense->acquisition_cost;
						$totalsalvage += $depreciation_expense->salvage_value ;
						$totaldepreciation += $depreciation_expense->depreciation_expense ;
						$totalaccumulative += $depreciation_expense->accu_dep ;
						$totalbook += $depreciation_expense->book_value ;
					}	
	                	$excel->getActiveSheet()->mergeCells('A'.$i.':'.'B'.$i);					
	                	$excel->getActiveSheet()->setCellValue('C'.$i,'TOTAL:')
                                        		->getStyle('C'.$i)->getFont()->setBold(TRUE);
	                	$excel->getActiveSheet()->getStyle('D'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');                	
	                	$excel->getActiveSheet()->setCellValue('D'.$i,number_format($totalacquisition,2))
                                        		->getStyle('D'.$i)->getFont()->setBold(TRUE);
	                	$excel->getActiveSheet()->getStyle('F'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');                	
	                	$excel->getActiveSheet()->setCellValue('F'.$i,number_format($totalsalvage,2))
                                        		->getStyle('F'.$i)->getFont()->setBold(TRUE);
	                	$excel->getActiveSheet()->getStyle('G'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');                	
	                	$excel->getActiveSheet()->setCellValue('G'.$i,number_format($totaldepreciation,2))
                                        		->getStyle('G'.$i)->getFont()->setBold(TRUE);
	                	$excel->getActiveSheet()->getStyle('H'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');                	
	                	$excel->getActiveSheet()->setCellValue('H'.$i,number_format($totalaccumulative,2))
                                        		->getStyle('H'.$i)->getFont()->setBold(TRUE);
	                	$excel->getActiveSheet()->getStyle('I'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');                	
	                	$excel->getActiveSheet()->setCellValue('I'.$i,number_format($totalbook,2))
                                        		->getStyle('I'.$i)->getFont()->setBold(TRUE);

	                	$i++;

	                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	                header('Content-Disposition: attachment;filename='."Depreciation Expense Report.xlsx".'');
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

				case 'gdr-email':
                	$excel=$this->excel;	
	                $m_email=$this->Email_settings_model;
	                $email=$m_email->get_list(2);					
					$m_fixed_asset=$this->Fixed_asset_management_model;

					$month=$this->input->get('m',TRUE);
					$year=$this->input->get('y',TRUE);

					$depreciation_expenses=$m_fixed_asset->get_depreciation_expense($month, $year);

					ob_start();
                	$excel->setActiveSheetIndex(0);

	                $excel->getActiveSheet()->getColumnDimensionByColumn('A1:I1')->setWidth('50');
	                $excel->getActiveSheet()->getColumnDimensionByColumn('A3:I3')->setWidth('50');
	                //name the worksheet
	                $excel->getActiveSheet()->setTitle("REPLENISHMENT BATCH REPORT");

	                $excel->getActiveSheet()
	                        ->getStyle('A1')
	                        ->getAlignment()
	                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	                $excel->getActiveSheet()
	                        ->getStyle('A3')
	                        ->getAlignment()
	                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	                $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
					$excel->getActiveSheet()->getStyle("A1")->getFont()->setSize(16);	                
	                $excel->getActiveSheet()->mergeCells('A1:I1');
	                $excel->getActiveSheet()->mergeCells('A3:I3');
					$excel->getActiveSheet()->getStyle("A3")->getFont()->setSize(10);
	                $excel->getActiveSheet()->getStyle('A3')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->setCellValue('A1','Depreciation Expense Report')
	                                        ->setCellValue('A3','For the Month of '.date('F Y', strtotime($_GET['y'].'-'.$_GET['m'])));	

	                $excel->getActiveSheet()->getColumnDimension('A')->setWidth('20');
	                $excel->getActiveSheet()->getColumnDimension('B')->setWidth('20');
	                $excel->getActiveSheet()->getColumnDimension('C')->setWidth('25');
	                $excel->getActiveSheet()->getColumnDimension('D')->setWidth('25');	    
	                $excel->getActiveSheet()->getColumnDimension('E')->setWidth('10');	    
	                $excel->getActiveSheet()->getColumnDimension('F')->setWidth('25');	    
	                $excel->getActiveSheet()->getColumnDimension('G')->setWidth('45');	    
	                $excel->getActiveSheet()->getColumnDimension('H')->setWidth('40');	    
	                $excel->getActiveSheet()->getColumnDimension('I')->setWidth('20');	    

	                $excel->getActiveSheet()
	                        ->getStyle('A5')
	                        ->getAlignment()
	                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	                $excel->getActiveSheet()
	                        ->getStyle('B5')
	                        ->getAlignment()
	                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	                $excel->getActiveSheet()
	                        ->getStyle('C5')
	                        ->getAlignment()
	                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	                $excel->getActiveSheet()
	                        ->getStyle('D5')
	                        ->getAlignment()
	                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	                $excel->getActiveSheet()
	                        ->getStyle('E5')
	                        ->getAlignment()
	                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	                $excel->getActiveSheet()
	                        ->getStyle('F5')
	                        ->getAlignment()
	                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	                $excel->getActiveSheet()
	                        ->getStyle('G5')
	                        ->getAlignment()
	                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	                $excel->getActiveSheet()
	                        ->getStyle('H5')
	                        ->getAlignment()
	                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	                $excel->getActiveSheet()
	                        ->getStyle('I5')
	                        ->getAlignment()
	                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                	$excel->getActiveSheet()->setCellValue('A5','Asset Code')
                                        	->getStyle('A5')->getFont()->setBold(TRUE);
                	$excel->getActiveSheet()->setCellValue('B5','Description')
                                        	->getStyle('B5')->getFont()->setBold(TRUE);
                	$excel->getActiveSheet()->setCellValue('C5','Date Acquired')
                                        	->getStyle('C5')->getFont()->setBold(TRUE);
                	$excel->getActiveSheet()->setCellValue('D5','Acquisiotion Cost')
                                        	->getStyle('D5')->getFont()->setBold(TRUE);
                	$excel->getActiveSheet()->setCellValue('E5','Life')
                                        	->getStyle('E5')->getFont()->setBold(TRUE);
                	$excel->getActiveSheet()->setCellValue('F5','Salvage Value')
                                        	->getStyle('F5')->getFont()->setBold(TRUE);
                	$excel->getActiveSheet()->setCellValue('G5','Depreciation Expense (Monthly)')
                                        	->getStyle('G5')->getFont()->setBold(TRUE);
                	$excel->getActiveSheet()->setCellValue('H5','Accumulative Depreciation')
                                        	->getStyle('H5')->getFont()->setBold(TRUE);
                	$excel->getActiveSheet()->setCellValue('I5','Book Value')
                                        	->getStyle('I5')->getFont()->setBold(TRUE);

                    $i=6;                   	
					$totalacquisition = 0;
					$totalsalvage = 0;
					$totaldepreciation = 0;
					$totalaccumulative = 0;
					$totalbook  = 0;

					foreach ($depreciation_expenses as $depreciation_expense) {

	                $excel->getActiveSheet()
	                        ->getStyle('E')
	                        ->getAlignment()
	                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

	                	$excel->getActiveSheet()->setCellValue('A'.$i,$depreciation_expense->asset_code);
	                	$excel->getActiveSheet()->setCellValue('B'.$i,$depreciation_expense->asset_description);
	                	$excel->getActiveSheet()->setCellValue('C'.$i,date('F d,Y', strtotime($depreciation_expense->date_acquired)));
	                	$excel->getActiveSheet()->getStyle('D'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
	                	$excel->getActiveSheet()->setCellValue('D'.$i,number_format($depreciation_expense->acquisition_cost,2));
	                	$excel->getActiveSheet()->setCellValue('E'.$i,$depreciation_expense->life_years);
	                	$excel->getActiveSheet()->getStyle('F'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
	                	$excel->getActiveSheet()->setCellValue('F'.$i,number_format($depreciation_expense->salvage_value,2));
	                	$excel->getActiveSheet()->getStyle('G'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
	                	$excel->getActiveSheet()->setCellValue('G'.$i,number_format($depreciation_expense->depreciation_expense,2));
	                	$excel->getActiveSheet()->getStyle('H'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
	                	$excel->getActiveSheet()->setCellValue('H'.$i,number_format($depreciation_expense->accu_dep,2));
	                	$excel->getActiveSheet()->getStyle('I'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');                	
	                	$excel->getActiveSheet()->setCellValue('I'.$i,number_format($depreciation_expense->book_value,2));
	                	$i++;

						$totalacquisition += $depreciation_expense->acquisition_cost;
						$totalsalvage += $depreciation_expense->salvage_value ;
						$totaldepreciation += $depreciation_expense->depreciation_expense ;
						$totalaccumulative += $depreciation_expense->accu_dep ;
						$totalbook += $depreciation_expense->book_value ;
					}	
	                	$excel->getActiveSheet()->mergeCells('A'.$i.':'.'B'.$i);					
	                	$excel->getActiveSheet()->setCellValue('C'.$i,'TOTAL:')
                                        		->getStyle('C'.$i)->getFont()->setBold(TRUE);
	                	$excel->getActiveSheet()->getStyle('D'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');                	
	                	$excel->getActiveSheet()->setCellValue('D'.$i,number_format($totalacquisition,2))
                                        		->getStyle('D'.$i)->getFont()->setBold(TRUE);
	                	$excel->getActiveSheet()->getStyle('F'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');                	
	                	$excel->getActiveSheet()->setCellValue('F'.$i,number_format($totalsalvage,2))
                                        		->getStyle('F'.$i)->getFont()->setBold(TRUE);
	                	$excel->getActiveSheet()->getStyle('G'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');                	
	                	$excel->getActiveSheet()->setCellValue('G'.$i,number_format($totaldepreciation,2))
                                        		->getStyle('G'.$i)->getFont()->setBold(TRUE);
	                	$excel->getActiveSheet()->getStyle('H'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');                	
	                	$excel->getActiveSheet()->setCellValue('H'.$i,number_format($totalaccumulative,2))
                                        		->getStyle('H'.$i)->getFont()->setBold(TRUE);
	                	$excel->getActiveSheet()->getStyle('I'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');                	
	                	$excel->getActiveSheet()->setCellValue('I'.$i,number_format($totalbook,2))
                                        		->getStyle('I'.$i)->getFont()->setBold(TRUE);

	                	$i++;

	                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	                header('Content-Disposition: attachment;filename='."Depreciation Expense Report.xlsx".'');
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

                            $file_name='Depreciation Expense Report '.date('Y-m-d h:i:A', now());
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
                            $subject = 'Depreciation Expense Report';
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

				case 'prepare-for-review':
					$month=$this->input->get('m',TRUE);
					$year=$this->input->get('y',TRUE);

					$response['data']=$m_fixed_asset->get_depreciation_expense($month, $year);

				break;

				case 'create-for-review':
					$m_depreciation_expense= $this->Depreciation_expense_model;

					$month=$this->input->post('month',TRUE);
					$year=$this->input->post('year',TRUE);
					$total=$this->input->post('total');
					$date=$year.'-'.$month.'-01';

					$m_depreciation_expense->de_expense_total=$this->get_numeric_value($total);
					$m_depreciation_expense->de_date=date('Y-m-d',strtotime($year.'-'.$month.'-01'));
					$m_depreciation_expense->de_remarks='For Review';
					$m_depreciation_expense->save();


					$response['title'] = 'Success!';
                    $response['stat'] = 'success';
                    $response['msg'] = 'Depreciation Expense successfully prepared for review.'.$date;

                    echo json_encode($response);

				break;
			}
		}
	}
?>