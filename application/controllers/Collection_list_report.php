<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Collection_list_report extends CORE_Controller
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
					'Company_model'
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
	        $data['title'] = 'Collection List Report';
        (in_array('12-3',$this->session->user_rights)? 
        $this->load->view('Collection_list_report_view',$data)
        :redirect(base_url('dashboard')));
	        
		}

		function transaction($txn=null) {
			switch($txn) {
				case 'list':
					$m_journal_info=$this->Receivable_payment_model;

					$startDate=date("Y-m-d",strtotime($this->input->get('start',TRUE)));
					$endDate=date("Y-m-d",strtotime($this->input->get('end',TRUE)));

					$response['data']=$m_journal_info->get_receivable_payment($startDate,$endDate);
					echo json_encode($response);
				break;


				case 'report':
					$m_journal_info=$this->Receivable_payment_model;
					$m_company=$this->Company_model;

					$startDate=date("Y-m-d",strtotime($this->input->get('start',TRUE)));
					$endDate=date("Y-m-d",strtotime($this->input->get('end',TRUE)));

					$company_info=$m_company->get_list();
					$data['company_info']=$company_info[0];

					$report_info=$m_journal_info->get_receivable_payment($startDate,$endDate);
					$data['start']=$startDate;
					$data['end']=$endDate;
					$data['report_info']=$report_info;

					$this->load->view('template/collection_list_report_content',$data);
				break;

				case 'export':
					$excel = $this->excel;
					$m_journal_info=$this->Receivable_payment_model;
					$m_company=$this->Company_model;

					$startDate=date("Y-m-d",strtotime($this->input->get('start',TRUE)));
					$endDate=date("Y-m-d",strtotime($this->input->get('end',TRUE)));

					$company_info=$m_company->get_list();
					$company_info=$company_info[0];

					$report_info=$m_journal_info->get_receivable_payment($startDate,$endDate);
					$start=$startDate;
					$end=$endDate;
					$report_info=$report_info;

					$excel->setActiveSheetIndex(0);

					$excel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
					$excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
					$excel->getActiveSheet()->getColumnDimension('C')->setWidth(50);
					$excel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
					$excel->getActiveSheet()->getColumnDimension('E')->setWidth(40);
					$excel->getActiveSheet()->getColumnDimension('F')->setWidth(40);

                    $excel->getActiveSheet()->setTitle("Collection List");

                    $excel->getActiveSheet()->setCellValue('A1',$company_info->company_name)
                    						->mergeCells('A1:D1')
                    						->getStyle('A1:D1')->getFont()->setBold(True)
                    						->setSize(16);
                    $excel->getActiveSheet()->setCellValue('A2',$company_info->company_address)
                    						->mergeCells('A2:D2')
                    						->setCellValue('A3',$company_info->landline.' / '.$company_info->mobile_no)
                    						->mergeCells('A3:D3');

					$border_bottom= array(
                    'borders' => array(
                        'bottom' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('rgb' => '292929')
                        )
                    ));

                    $excel->getActiveSheet()->setCellValue('A5')
                    						->mergeCells('A5:F5')
                                            ->getStyle('A5:F5')->applyFromArray($border_bottom);

                    $excel->getActiveSheet()
                            ->getStyle('A6:F6')
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

					$excel->getActiveSheet()->setCellValue('A6','Collection List Report')
											->mergeCells('A6:F6')
											->getStyle('A6:F6')->getFont()->setBold(True)
											->setSize(14);

					$excel->getActiveSheet()->setCellValue('A7','Period Covered: '.date("m-d-Y",strtotime($start)))
											->mergeCells('A7:B7')
											->getStyle('A7')->getFont()->setBold(True);

                    $excel->getActiveSheet()
                            ->getStyle('C7:D7')
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

					$excel->getActiveSheet()->setCellValue('C7','Run Date: '.date("m-d-Y",strtotime($end)))
											->mergeCells('C7:D7')
											->getStyle('C7:D7')->getFont()->setBold(True);

                    $excel->getActiveSheet()
                            ->getStyle('D8:F8')
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

					$excel->getActiveSheet()->setCellValue('A8','Reference No.')
											->getStyle('A8')->getFont()->setBold(TRUE);
					$excel->getActiveSheet()->setCellValue('B8','Date')
											->getStyle('B8')->getFont()->setBold(TRUE);
					$excel->getActiveSheet()->setCellValue('C8','Customer Name')
											->getStyle('C8')->getFont()->setBold(TRUE);

					$excel->getActiveSheet()->setCellValue('D8',"Pay Type\nCash")
											->getStyle('D8')->getFont()->setBold(TRUE);
					$excel->getActiveSheet()->getStyle('D8')->getAlignment()->setWrapText(true);
					$excel->getActiveSheet()->setCellValue('E8',"Check")
											->getStyle('E8')->getFont()->setBold(TRUE);
					$excel->getActiveSheet()->getStyle('E8')->getAlignment()->setWrapText(true);
					$excel->getActiveSheet()->setCellValue('F8',"Credit")
											->getStyle('F8')->getFont()->setBold(TRUE);
					$excel->getActiveSheet()->getStyle('F8')->getAlignment()->setWrapText(true);

					$i=9;

					foreach ($report_info as $report) {

		                $excel->getActiveSheet()
		                        ->getStyle('A'.$i)
		                        ->getAlignment()
		                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

		                $excel->getActiveSheet()
		                        ->getStyle('D'.$i.':'.'F'.$i)
		                        ->getAlignment()
		                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

           				$excel->getActiveSheet()->getStyle('D'.$i.':'.'F'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');

						$excel->getActiveSheet()->setCellValue('A'.$i,$report->receipt_no);
						$excel->getActiveSheet()->setCellValue('B'.$i,$report->date_paid);
						$excel->getActiveSheet()->setCellValue('C'.$i,$report->customer_name);
						$excel->getActiveSheet()->setCellValue('D'.$i,number_format($report->cash_amount,2));
						$excel->getActiveSheet()->setCellValue('E'.$i,number_format($report->check_amount,2));
						$excel->getActiveSheet()->setCellValue('F'.$i,number_format($report->card_amount,2));
						$i++;

					}


					$border_top = array(
					  'borders' => array(
					    'top' => array(
					      'style' => PHPExcel_Style_Border::BORDER_THIN
					    )
					  )
					);

					$excel->getActiveSheet()->getStyle('D'.$i.':'.'F'.$i)->applyFromArray($border_top);

			        $cash_amount=0;
			        $check_amount=0;
			        $card_amount=0;

			        foreach ($report_info as $report) {
			            $cash=$report->cash_amount;
			            $check=$report->check_amount;
			            $card=$report->card_amount;

			            // Sum of every Pay Type
			            $cash_amount += $cash;
			            $check_amount += $check;
			            $card_amount += $card_amount;
			        
			        }


	                $excel->getActiveSheet()
	                        ->getStyle('D'.$i)
	                        ->getAlignment()
	                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

           			$excel->getActiveSheet()->getStyle('D'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
					$excel->getActiveSheet()->setCellValue('D'.$i,number_format($cash_amount,2))
											->getStyle('D'.$i)->getFont()->setBold(TRUE);
					$excel->getActiveSheet()->getStyle('D'.$i)->getAlignment()->setWrapText(true);

           			$excel->getActiveSheet()->getStyle('E'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
					$excel->getActiveSheet()->setCellValue('E'.$i,number_format($check_amount,2))
											->getStyle('E'.$i)->getFont()->setBold(TRUE);
					$excel->getActiveSheet()->getStyle('E'.$i)->getAlignment()->setWrapText(true);

           			$excel->getActiveSheet()->getStyle('F'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
					$excel->getActiveSheet()->setCellValue('F'.$i,number_format($card_amount,2))
											->getStyle('F'.$i)->getFont()->setBold(TRUE);
					$excel->getActiveSheet()->getStyle('F'.$i)->getAlignment()->setWrapText(true);

					$i++;

					$excel->getActiveSheet()->getStyle('D'.$i.':'.'F'.$i)->applyFromArray($border_top);

	                $excel->getActiveSheet()
	                        ->getStyle('A'.$i)
	                        ->getAlignment()
	                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

	                $excel->getActiveSheet()
	                        ->getStyle('D'.$i)
	                        ->getAlignment()
	                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                	$excel->getActiveSheet()->mergeCells('A'.$i.':C'.$i);
					$excel->getActiveSheet()->setCellValue('A'.$i,'Total')
											->getStyle('A'.$i)->getFont()->setBold(TRUE);

					$total_amount= $cash_amount + $check_amount +$card_amount;

                	$excel->getActiveSheet()->mergeCells('D'.$i.':F'.$i);
           			$excel->getActiveSheet()->getStyle('D'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
					$excel->getActiveSheet()->setCellValue('D'.$i,number_format($total_amount,2))
											->getStyle('D'.$i)->getFont()->setBold(TRUE);


	                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	                header('Content-Disposition: attachment;filename='."Collection List Report.xlsx".'');
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
					$excel = $this->excel;
					$m_email = $this->Email_settings_model;
					$email = $m_email->get_list(2);
					$m_journal_info=$this->Receivable_payment_model;
					$m_company=$this->Company_model;

					$startDate=date("Y-m-d",strtotime($this->input->get('start',TRUE)));
					$endDate=date("Y-m-d",strtotime($this->input->get('end',TRUE)));

					$company_info=$m_company->get_list();
					$company_info=$company_info[0];

					$report_info=$m_journal_info->get_receivable_payment($startDate,$endDate);
					$start=$startDate;
					$end=$endDate;
					$report_info=$report_info;

					ob_start();
					$excel->setActiveSheetIndex(0);

					$excel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
					$excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
					$excel->getActiveSheet()->getColumnDimension('C')->setWidth(50);
					$excel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
					$excel->getActiveSheet()->getColumnDimension('E')->setWidth(40);
					$excel->getActiveSheet()->getColumnDimension('F')->setWidth(40);

                    $excel->getActiveSheet()->setTitle("Collection List");

                    $excel->getActiveSheet()->setCellValue('A1',$company_info->company_name)
                    						->mergeCells('A1:D1')
                    						->getStyle('A1:D1')->getFont()->setBold(True)
                    						->setSize(16);
                    $excel->getActiveSheet()->setCellValue('A2',$company_info->company_address)
                    						->mergeCells('A2:D2')
                    						->setCellValue('A3',$company_info->landline.' / '.$company_info->mobile_no)
                    						->mergeCells('A3:D3');

					$border_bottom= array(
                    'borders' => array(
                        'bottom' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('rgb' => '292929')
                        )
                    ));

                    $excel->getActiveSheet()->setCellValue('A5')
                    						->mergeCells('A5:F5')
                                            ->getStyle('A5:F5')->applyFromArray($border_bottom);

                    $excel->getActiveSheet()
                            ->getStyle('A6:F6')
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

					$excel->getActiveSheet()->setCellValue('A6','Collection List Report')
											->mergeCells('A6:F6')
											->getStyle('A6:F6')->getFont()->setBold(True)
											->setSize(14);

					$excel->getActiveSheet()->setCellValue('A7','Period Covered: '.date("m-d-Y",strtotime($start)))
											->mergeCells('A7:B7')
											->getStyle('A7')->getFont()->setBold(True);

                    $excel->getActiveSheet()
                            ->getStyle('C7:D7')
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

					$excel->getActiveSheet()->setCellValue('C7','Run Date: '.date("m-d-Y",strtotime($end)))
											->mergeCells('C7:D7')
											->getStyle('C7:D7')->getFont()->setBold(True);

                    $excel->getActiveSheet()
                            ->getStyle('D8:F8')
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

					$excel->getActiveSheet()->setCellValue('A8','Reference No.')
											->getStyle('A8')->getFont()->setBold(TRUE);
					$excel->getActiveSheet()->setCellValue('B8','Date')
											->getStyle('B8')->getFont()->setBold(TRUE);
					$excel->getActiveSheet()->setCellValue('C8','Customer Name')
											->getStyle('C8')->getFont()->setBold(TRUE);

					$excel->getActiveSheet()->setCellValue('D8',"Pay Type\nCash")
											->getStyle('D8')->getFont()->setBold(TRUE);
					$excel->getActiveSheet()->getStyle('D8')->getAlignment()->setWrapText(true);
					$excel->getActiveSheet()->setCellValue('E8',"Check")
											->getStyle('E8')->getFont()->setBold(TRUE);
					$excel->getActiveSheet()->getStyle('E8')->getAlignment()->setWrapText(true);
					$excel->getActiveSheet()->setCellValue('F8',"Credit")
											->getStyle('F8')->getFont()->setBold(TRUE);
					$excel->getActiveSheet()->getStyle('F8')->getAlignment()->setWrapText(true);

					$i=9;

					foreach ($report_info as $report) {

		                $excel->getActiveSheet()
		                        ->getStyle('A'.$i)
		                        ->getAlignment()
		                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

		                $excel->getActiveSheet()
		                        ->getStyle('D'.$i.':'.'F'.$i)
		                        ->getAlignment()
		                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

           				$excel->getActiveSheet()->getStyle('D'.$i.':'.'F'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');

						$excel->getActiveSheet()->setCellValue('A'.$i,$report->receipt_no);
						$excel->getActiveSheet()->setCellValue('B'.$i,$report->date_paid);
						$excel->getActiveSheet()->setCellValue('C'.$i,$report->customer_name);
						$excel->getActiveSheet()->setCellValue('D'.$i,number_format($report->cash_amount,2));
						$excel->getActiveSheet()->setCellValue('E'.$i,number_format($report->check_amount,2));
						$excel->getActiveSheet()->setCellValue('F'.$i,number_format($report->card_amount,2));
						$i++;

					}


					$border_top = array(
					  'borders' => array(
					    'top' => array(
					      'style' => PHPExcel_Style_Border::BORDER_THIN
					    )
					  )
					);

					$excel->getActiveSheet()->getStyle('D'.$i.':'.'F'.$i)->applyFromArray($border_top);

			        $cash_amount=0;
			        $check_amount=0;
			        $card_amount=0;

			        foreach ($report_info as $report) {
			            $cash=$report->cash_amount;
			            $check=$report->check_amount;
			            $card=$report->card_amount;

			            // Sum of every Pay Type
			            $cash_amount += $cash;
			            $check_amount += $check;
			            $card_amount += $card_amount;
			        
			        }


	                $excel->getActiveSheet()
	                        ->getStyle('D'.$i)
	                        ->getAlignment()
	                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

           			$excel->getActiveSheet()->getStyle('D'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
					$excel->getActiveSheet()->setCellValue('D'.$i,number_format($cash_amount,2))
											->getStyle('D'.$i)->getFont()->setBold(TRUE);
					$excel->getActiveSheet()->getStyle('D'.$i)->getAlignment()->setWrapText(true);

           			$excel->getActiveSheet()->getStyle('E'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
					$excel->getActiveSheet()->setCellValue('E'.$i,number_format($check_amount,2))
											->getStyle('E'.$i)->getFont()->setBold(TRUE);
					$excel->getActiveSheet()->getStyle('E'.$i)->getAlignment()->setWrapText(true);

           			$excel->getActiveSheet()->getStyle('F'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
					$excel->getActiveSheet()->setCellValue('F'.$i,number_format($card_amount,2))
											->getStyle('F'.$i)->getFont()->setBold(TRUE);
					$excel->getActiveSheet()->getStyle('F'.$i)->getAlignment()->setWrapText(true);

					$i++;

					$excel->getActiveSheet()->getStyle('D'.$i.':'.'F'.$i)->applyFromArray($border_top);

	                $excel->getActiveSheet()
	                        ->getStyle('A'.$i)
	                        ->getAlignment()
	                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

	                $excel->getActiveSheet()
	                        ->getStyle('D'.$i)
	                        ->getAlignment()
	                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                	$excel->getActiveSheet()->mergeCells('A'.$i.':C'.$i);
					$excel->getActiveSheet()->setCellValue('A'.$i,'Total')
											->getStyle('A'.$i)->getFont()->setBold(TRUE);

					$total_amount= $cash_amount + $check_amount +$card_amount;

                	$excel->getActiveSheet()->mergeCells('D'.$i.':F'.$i);
           			$excel->getActiveSheet()->getStyle('D'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
					$excel->getActiveSheet()->setCellValue('D'.$i,number_format($total_amount,2))
											->getStyle('D'.$i)->getFont()->setBold(TRUE);


	                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	                header('Content-Disposition: attachment;filename='."Collection List Report.xlsx".'');
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

                            $file_name='Collection List Report '.date('Y-m-d h:i:A', now());
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
                            $subject = 'Collection List Report';
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