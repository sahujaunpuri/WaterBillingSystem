<?php
	defined('BASEPATH') OR exit('No direct script access allowed.');

	class Aging_receivables extends CORE_Controller
	{
		function __construct()
		{
			parent::__construct();
			$this->validate_session();
			$this->load->model(
				array(
					'Sales_invoice_model',
					'Soa_settings_model',
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
	        //default resources of the active view
	        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', TRUE);
	        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', TRUE);
	        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', TRUE);
	        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', TRUE);
	        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', TRUE);
	        $data['title'] = "Aging of Receivables";

	        $this->load->view('aging_receivables_view',$data);
		}

		function transaction($txn)
		{
			switch ($txn) {
				case 'list':
					$m_sales = $this->Sales_invoice_model;

	                $accounts=$this->Soa_settings_model->get_list(null,'soa_account_id'); 
	                $acc = []; 
	                foreach ($accounts as $account) { $acc[]=$account->soa_account_id; } 
	                $filter_accounts =  implode(",", $acc); 

					$response['data'] = $m_sales->get_aging_receivables($filter_accounts);

					echo json_encode($response);
					break;

				case 'print':

					$m_sales = $this->Sales_invoice_model;
					$m_company = $this->Company_model;

					$company_info = $m_company->get_list();

					$data['company_info'] = $company_info[0];
	                $accounts=$this->Soa_settings_model->get_list(null,'soa_account_id'); 
	                $acc = []; 
	                foreach ($accounts as $account) { $acc[]=$account->soa_account_id; } 
	                $filter_accounts =  implode(",", $acc); 
					$data['receivables'] = $m_sales->get_aging_receivables($filter_accounts);

                    $file_name='Aging of Receivables';
                    $pdfFilePath = $file_name.".pdf"; //generate filename base on id
                    $pdf = $this->m_pdf->load(); //pass the instance of the mpdf class
                    $content=$this->load->view('template/aging_receivables_report',$data,TRUE); //load the template
                    $pdf->setFooter('{PAGENO}');
                    $pdf->WriteHTML($content);
                    //download it.
                    $pdf->Output();


					// $this->load->view('template/aging_receivables_report',$data);
					break;
				
				default:
					# code...
					break;

				case 'export':
          
                	$excel=$this->excel;
					$m_sales = $this->Sales_invoice_model;
					$m_company = $this->Company_model;

					$company_info = $m_company->get_list();

					$data['company_info'] = $company_info[0];
	                $accounts=$this->Soa_settings_model->get_list(null,'soa_account_id'); 
	                $acc = []; 
	                foreach ($accounts as $account) { $acc[]=$account->soa_account_id; } 
	                $filter_accounts =  implode(",", $acc); 
					$receivables = $m_sales->get_aging_receivables($filter_accounts);

	                $excel->setActiveSheetIndex(0);

	                $excel->getActiveSheet()->getColumnDimensionByColumn('A1:B1')->setWidth('30');
	                $excel->getActiveSheet()->getColumnDimensionByColumn('A2:B2')->setWidth('50');
	                $excel->getActiveSheet()->getColumnDimensionByColumn('A3')->setWidth('30');
	                $excel->getActiveSheet()->getColumnDimensionByColumn('A4')->setWidth('30');

	                //name the worksheet
	                $excel->getActiveSheet()->setTitle("Aging of Receivables Report");
	                $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->mergeCells('A1:B1');
	                $excel->getActiveSheet()->mergeCells('A2:B2');
	                $excel->getActiveSheet()->mergeCells('A3:B3');
	                $excel->getActiveSheet()->mergeCells('A4:B4');
	                $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
	                                        ->setCellValue('A2',$company_info[0]->company_address)
	                                        ->setCellValue('A3',$company_info[0]->landline.'/'.$company_info[0]->mobile_no)
	                                        ->setCellValue('A4',$company_info[0]->email_address);

	                $excel->getActiveSheet()->getColumnDimensionByColumn('A6:B6')->setWidth('40');	                                        
	                $excel->getActiveSheet()->mergeCells('A6:B6');
                	$excel->getActiveSheet()->setCellValue('A6','AGING OF RECEIVABLES REPORT')
                                        	->getStyle('A6')->getFont()->setBold(TRUE)
                                        	->setSize(16);

	                $excel->getActiveSheet()->getColumnDimension('A')->setWidth('40');
	                $excel->getActiveSheet()->getColumnDimension('B')->setWidth('25');
	                $excel->getActiveSheet()->getColumnDimension('C')->setWidth('25');
	                $excel->getActiveSheet()->getColumnDimension('D')->setWidth('25');
	                $excel->getActiveSheet()->getColumnDimension('E')->setWidth('30');
	                $excel->getActiveSheet()->getColumnDimension('F')->setWidth('30');
	                	                	                
	                $excel->getActiveSheet()
	                        ->getStyle('B')
	                        ->getAlignment()
	                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	                $excel->getActiveSheet()
	                        ->getStyle('C')
	                        ->getAlignment()
	                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	                $excel->getActiveSheet()
	                        ->getStyle('D')
	                        ->getAlignment()
	                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	                $excel->getActiveSheet()
	                        ->getStyle('E')
	                        ->getAlignment()
	                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	                $excel->getActiveSheet()
	                        ->getStyle('F')
	                        ->getAlignment()
	                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);	

	                $excel->getActiveSheet()->setCellValue('A8','Customer Name')
	                                        ->getStyle('A8')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->setCellValue('B8','Current')
	                                        ->getStyle('B8')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->setCellValue('C8','30 Days')
	                                        ->getStyle('C8')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->setCellValue('D8','45 Days')
	                                        ->getStyle('D8')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->setCellValue('E8','60 Days')
	                                        ->getStyle('E8')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->setCellValue('F8','Over 90 Days')
	                                        ->getStyle('F8')->getFont()->setBold(TRUE);
	                $i=9;
					$sum_current = 0; $sum_thirty = 0; $sum_fortyfive = 0; $sum_sixty = 0; $sum_ninety = 0;	   
					
					foreach($receivables as $receivable) {		
		                $excel->getActiveSheet()->getColumnDimension('A')->setWidth('40');
		                $excel->getActiveSheet()->getColumnDimension('B')->setWidth('25');
		                $excel->getActiveSheet()->getColumnDimension('C')->setWidth('25');
		                $excel->getActiveSheet()->getColumnDimension('D')->setWidth('25');
		                $excel->getActiveSheet()->getColumnDimension('E')->setWidth('30');
		                $excel->getActiveSheet()->getColumnDimension('F')->setWidth('30');

		                $excel->getActiveSheet()
		                        ->getStyle('B')
		                        ->getAlignment()
		                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		                $excel->getActiveSheet()
		                        ->getStyle('C')
		                        ->getAlignment()
		                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		                $excel->getActiveSheet()
		                        ->getStyle('D')
		                        ->getAlignment()
		                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		                $excel->getActiveSheet()
		                        ->getStyle('E')
		                        ->getAlignment()
		                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		                $excel->getActiveSheet()
		                        ->getStyle('F')
		                        ->getAlignment()
		                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);	

		                $excel->getActiveSheet()->setCellValue('A'.$i,$receivable->customer_name);
                    	$excel->getActiveSheet()->getStyle('B'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');		            
		                $excel->getActiveSheet()->setCellValue('B'.$i,(number_format($receivable->current,2) == 0 ? '' : number_format($receivable->current,2)));
                    	$excel->getActiveSheet()->getStyle('C'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');		                
		                $excel->getActiveSheet()->setCellValue('C'.$i,(number_format($receivable->thirty_days,2) == 0 ? '' : number_format($receivable->thirty_days,2)));
                    	$excel->getActiveSheet()->getStyle('D'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');		                
		                $excel->getActiveSheet()->setCellValue('D'.$i,(number_format($receivable->fortyfive_days,2) == 0 ? '' : number_format($receivable->fortyfive_days,2)));
                   		$excel->getActiveSheet()->getStyle('E'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');		                
		                $excel->getActiveSheet()->setCellValue('E'.$i,(number_format($receivable->sixty_days,2) == 0 ? '' : number_format($receivable->sixty_days,2)));
                    	$excel->getActiveSheet()->getStyle('F'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');		                
		                $excel->getActiveSheet()->setCellValue('F'.$i,(number_format($receivable->over_ninetydays,2) == 0 ? '' : number_format($receivable->over_ninetydays,2)));
						
						$i++;
	 					$sum_current += $receivable->current; 
	                    $sum_thirty += $receivable->thirty_days;
	                    $sum_fortyfive += $receivable->fortyfive_days;
	                    $sum_sixty += $receivable->sixty_days;
	                    $sum_ninety += $receivable->over_ninetydays;											
					}			         
                    	$excel->getActiveSheet()->getStyle('B'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');		            
		                $excel->getActiveSheet()->setCellValue('B'.$i,number_format($sum_current,2));
                    	$excel->getActiveSheet()->getStyle('C'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');		                		                
		                $excel->getActiveSheet()->setCellValue('C'.$i,number_format($sum_thirty,2));
                    	$excel->getActiveSheet()->getStyle('D'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');		                		                
		                $excel->getActiveSheet()->setCellValue('D'.$i,number_format($sum_fortyfive,2));
                   		$excel->getActiveSheet()->getStyle('E'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');		                		                
		                $excel->getActiveSheet()->setCellValue('E'.$i,number_format($sum_sixty,2));
                    	$excel->getActiveSheet()->getStyle('F'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');		                		                
		                $excel->getActiveSheet()->setCellValue('F'.$i,number_format($sum_ninety,2));

		                $i++;

	                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	                header('Content-Disposition: attachment;filename='."Aging of Receivables Report.xlsx".'');
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

				case 'email':
          
                	$excel=$this->excel;
	                $m_email=$this->Email_settings_model;
	                $email=$m_email->get_list(2);
					$m_sales = $this->Sales_invoice_model;
					$m_company = $this->Company_model;

					$company_info = $m_company->get_list();

					$data['company_info'] = $company_info[0];
	                $accounts=$this->Soa_settings_model->get_list(null,'soa_account_id'); 
	                $acc = []; 
	                foreach ($accounts as $account) { $acc[]=$account->soa_account_id; } 
	                $filter_accounts =  implode(",", $acc); 
					$receivables = $m_sales->get_aging_receivables($filter_accounts);

					ob_start();
	                $excel->setActiveSheetIndex(0);

	                $excel->getActiveSheet()->getColumnDimensionByColumn('A1:B1')->setWidth('30');
	                $excel->getActiveSheet()->getColumnDimensionByColumn('A2:B2')->setWidth('50');
	                $excel->getActiveSheet()->getColumnDimensionByColumn('A3')->setWidth('30');
	                $excel->getActiveSheet()->getColumnDimensionByColumn('A4')->setWidth('30');

	                //name the worksheet
	                $excel->getActiveSheet()->setTitle("Aging of Receivables Report");
	                $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->mergeCells('A1:B1');
	                $excel->getActiveSheet()->mergeCells('A2:B2');
	                $excel->getActiveSheet()->mergeCells('A3:B3');
	                $excel->getActiveSheet()->mergeCells('A4:B4');
	                $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
	                                        ->setCellValue('A2',$company_info[0]->company_address)
	                                        ->setCellValue('A3',$company_info[0]->landline.'/'.$company_info[0]->mobile_no)
	                                        ->setCellValue('A4',$company_info[0]->email_address);

	                $excel->getActiveSheet()->getColumnDimensionByColumn('A6:B6')->setWidth('40');	                                        
	                $excel->getActiveSheet()->mergeCells('A6:B6');
                	$excel->getActiveSheet()->setCellValue('A6','AGING OF RECEIVABLES REPORT')
                                        	->getStyle('A6')->getFont()->setBold(TRUE)
                                        	->setSize(16);

	                $excel->getActiveSheet()->getColumnDimension('A')->setWidth('40');
	                $excel->getActiveSheet()->getColumnDimension('B')->setWidth('25');
	                $excel->getActiveSheet()->getColumnDimension('C')->setWidth('25');
	                $excel->getActiveSheet()->getColumnDimension('D')->setWidth('25');
	                $excel->getActiveSheet()->getColumnDimension('E')->setWidth('30');
	                $excel->getActiveSheet()->getColumnDimension('F')->setWidth('30');
	                	                	                
	                $excel->getActiveSheet()
	                        ->getStyle('B')
	                        ->getAlignment()
	                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	                $excel->getActiveSheet()
	                        ->getStyle('C')
	                        ->getAlignment()
	                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	                $excel->getActiveSheet()
	                        ->getStyle('D')
	                        ->getAlignment()
	                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	                $excel->getActiveSheet()
	                        ->getStyle('E')
	                        ->getAlignment()
	                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	                $excel->getActiveSheet()
	                        ->getStyle('F')
	                        ->getAlignment()
	                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);	

	                $excel->getActiveSheet()->setCellValue('A8','Customer Name')
	                                        ->getStyle('A8')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->setCellValue('B8','Current')
	                                        ->getStyle('B8')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->setCellValue('C8','30 Days')
	                                        ->getStyle('C8')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->setCellValue('D8','45 Days')
	                                        ->getStyle('D8')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->setCellValue('E8','60 Days')
	                                        ->getStyle('E8')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->setCellValue('F8','Over 90 Days')
	                                        ->getStyle('F8')->getFont()->setBold(TRUE);
	                $i=9;
					$sum_current = 0; $sum_thirty = 0; $sum_fortyfive = 0; $sum_sixty = 0; $sum_ninety = 0;	   
					
					foreach($receivables as $receivable) {		
		                $excel->getActiveSheet()->getColumnDimension('A')->setWidth('40');
		                $excel->getActiveSheet()->getColumnDimension('B')->setWidth('25');
		                $excel->getActiveSheet()->getColumnDimension('C')->setWidth('25');
		                $excel->getActiveSheet()->getColumnDimension('D')->setWidth('25');
		                $excel->getActiveSheet()->getColumnDimension('E')->setWidth('30');
		                $excel->getActiveSheet()->getColumnDimension('F')->setWidth('30');

		                $excel->getActiveSheet()
		                        ->getStyle('B')
		                        ->getAlignment()
		                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		                $excel->getActiveSheet()
		                        ->getStyle('C')
		                        ->getAlignment()
		                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		                $excel->getActiveSheet()
		                        ->getStyle('D')
		                        ->getAlignment()
		                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		                $excel->getActiveSheet()
		                        ->getStyle('E')
		                        ->getAlignment()
		                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		                $excel->getActiveSheet()
		                        ->getStyle('F')
		                        ->getAlignment()
		                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);	

		                $excel->getActiveSheet()->setCellValue('A'.$i,$receivable->customer_name);
                    	$excel->getActiveSheet()->getStyle('B'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');		            
		                $excel->getActiveSheet()->setCellValue('B'.$i,(number_format($receivable->current,2) == 0 ? '' : number_format($receivable->current,2)));
                    	$excel->getActiveSheet()->getStyle('C'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');		                
		                $excel->getActiveSheet()->setCellValue('C'.$i,(number_format($receivable->thirty_days,2) == 0 ? '' : number_format($receivable->thirty_days,2)));
                    	$excel->getActiveSheet()->getStyle('D'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');		                
		                $excel->getActiveSheet()->setCellValue('D'.$i,(number_format($receivable->fortyfive_days,2) == 0 ? '' : number_format($receivable->fortyfive_days,2)));
                   		$excel->getActiveSheet()->getStyle('E'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');		                
		                $excel->getActiveSheet()->setCellValue('E'.$i,(number_format($receivable->sixty_days,2) == 0 ? '' : number_format($receivable->sixty_days,2)));
                    	$excel->getActiveSheet()->getStyle('F'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');		                
		                $excel->getActiveSheet()->setCellValue('F'.$i,(number_format($receivable->over_ninetydays,2) == 0 ? '' : number_format($receivable->over_ninetydays,2)));
						
						$i++;
	 					$sum_current += $receivable->current; 
	                    $sum_thirty += $receivable->thirty_days;
	                    $sum_fortyfive += $receivable->fortyfive_days;
	                    $sum_sixty += $receivable->sixty_days;
	                    $sum_ninety += $receivable->over_ninetydays;											
					}			         
                    	$excel->getActiveSheet()->getStyle('B'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');		            
		                $excel->getActiveSheet()->setCellValue('B'.$i,number_format($sum_current,2));
                    	$excel->getActiveSheet()->getStyle('C'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');		                		                
		                $excel->getActiveSheet()->setCellValue('C'.$i,number_format($sum_thirty,2));
                    	$excel->getActiveSheet()->getStyle('D'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');		                		                
		                $excel->getActiveSheet()->setCellValue('D'.$i,number_format($sum_fortyfive,2));
                   		$excel->getActiveSheet()->getStyle('E'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');		                		                
		                $excel->getActiveSheet()->setCellValue('E'.$i,number_format($sum_sixty,2));
                    	$excel->getActiveSheet()->getStyle('F'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');		                		                
		                $excel->getActiveSheet()->setCellValue('F'.$i,number_format($sum_ninety,2));

		                $i++;

	                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	                header('Content-Disposition: attachment;filename='."Aging of Receivables Report.xlsx".'');
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

                            $file_name='Aging of Receivables Report '.date('Y-m-d h:i:A', now());
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
                            $subject = 'Aging of Receivables';
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