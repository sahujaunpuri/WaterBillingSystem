<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Voucher_registry_report extends CORE_Controller
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

		public function index()
		{	
			$this->Users_model->validate();
			$data['_def_css_files'] = $this->load->view('template/assets/css_files', '', TRUE);
	        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', TRUE);
	        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', TRUE);
	        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', TRUE);
	        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', TRUE);
	        $data['title'] = 'Voucher Registry Report';
	     
	    (in_array('12-1',$this->session->user_rights)? 
        $this->load->view('voucher_registry_report_view',$data )
        :redirect(base_url('dashboard')));
		}

		function transaction($txn=null) {
			switch($txn) {
				case 'list':
					$m_journal_info=$this->Journal_info_model;

					$startDate=date("Y-m-d",strtotime($this->input->get('start',TRUE)));
					$endDate=date("Y-m-d",strtotime($this->input->get('end',TRUE)));

					$response['data']=$m_journal_info->get_voucher_registry($startDate,$endDate);

					echo json_encode($response);
				break;


				case 'report':
					$m_journal_info=$this->Journal_info_model;
					$m_company=$this->Company_model;

					$startDate=date("Y-m-d",strtotime($this->input->get('start',TRUE)));
					$endDate=date("Y-m-d",strtotime($this->input->get('end',TRUE)));

					$company_info=$m_company->get_list();
					$data['company_info']=$company_info[0];

					$data['vouchers']=$this->Journal_info_model->get_voucher_registry($startDate,$endDate);
					$data['start']=$startDate;
					$data['end']=$endDate;
					$total_info=$m_journal_info->get_voucher_registry_total($startDate,$endDate);
					$data['total_info']=$total_info[0];

					$this->load->view('template/voucher_registry_report_content',$data);
				break;

				case 'export':
					$excel = $this->excel;
					$m_journal_info=$this->Journal_info_model;
					$m_company=$this->Company_model;

					$startDate=date("Y-m-d",strtotime($this->input->get('start',TRUE)));
					$endDate=date("Y-m-d",strtotime($this->input->get('end',TRUE)));

					$company_info=$m_company->get_list();
					$company_info=$company_info[0];

					$vouchers=$this->Journal_info_model->get_voucher_registry($startDate,$endDate);
					$start=$startDate;
					$end=$endDate;
					$total_info=$m_journal_info->get_voucher_registry_total($startDate,$endDate);
					$total_info=$total_info[0];

					$excel->setActiveSheetIndex(0);

                    //name the worksheet
                    $excel->getActiveSheet()->setTitle("Voucher Registry");

					$excel->getActiveSheet()->setCellValue('A1',$company_info->company_name)
											->mergeCells('A1:D1')
											->getStyle('A1:D1')->getFont()->setBold(TRUE)
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
                    						->mergeCells('A5:D5')
                                            ->getStyle('A5:D5')->applyFromArray($border_bottom);

                    $excel->getActiveSheet()
                            ->getStyle('A6:D6')
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

					$excel->getActiveSheet()->setCellValue('A6','Voucher Registry')
											->mergeCells('A6:D6')
											->getStyle('A6:D6')->getFont()->setBold(True);

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

					$excel->getActiveSheet()->getColumnDimension('A')->setWidth(50);
					$excel->getActiveSheet()->getColumnDimension('B')->setWidth(50);
					$excel->getActiveSheet()->getColumnDimension('C')->setWidth(70);
					$excel->getActiveSheet()->getColumnDimension('D')->setWidth(50);

					$excel->getActiveSheet()->getStyle('A8:D8')->getFont()->setBold(True);

                    $excel->getActiveSheet()
                            ->getStyle('D8')
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

					$excel->getActiveSheet()->setCellValue('A8','CV No.');
					$excel->getActiveSheet()->setCellValue('B8','Date');
					$excel->getActiveSheet()->setCellValue('C8','Particular/Supplier');
					$excel->getActiveSheet()->setCellValue('D8','Amount');

					$i=9;

					foreach ($vouchers as $voucher) { 
	                    $excel->getActiveSheet()
	                            ->getStyle('D'.$i)
	                            ->getAlignment()
	                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);	

	                    $excel->getActiveSheet()
	                            ->getStyle('A'.$i)
	                            ->getAlignment()
	                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);	

						$excel->getActiveSheet()->setCellValue('A'.$i,$voucher->ref_no);
						$excel->getActiveSheet()->setCellValue('B'.$i,$voucher->date_txn);
						$excel->getActiveSheet()->setCellValue('C'.$i,$voucher->supplier_name);
						$excel->getActiveSheet()->getStyle('D'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');	
						$excel->getActiveSheet()->setCellValue('D'.$i,number_format($voucher->amount,2));

						$i++;

					}


                    $border_top= array(
                    'borders' => array(
                        'top' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('rgb' => '292929')
                        )
                    ));

                    $excel->getActiveSheet()
                            ->getStyle('A'.$i.':'.'D'.$i)
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);	

					$excel->getActiveSheet()->setCellValue('A'.$i,'Total')
											->mergeCells('A'.$i.':'.'C'.$i)
											->getStyle('A'.$i.':'.'C'.$i)->getFont()->setBold(True);



					$excel->getActiveSheet()->setCellValue('D'.$i)
                                        	->getStyle('D'.$i)->applyFromArray($border_top);

					$excel->getActiveSheet()->getStyle('D'.$i)->getFont()->setBold(True);

					$excel->getActiveSheet()->setCellValue('D'.$i,number_format($total_info->summary,2))
							  				->getStyle('D'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');

	                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	                header('Content-Disposition: attachment;filename='."Voucher Registry Report.xlsx".'');
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
					$m_journal_info=$this->Journal_info_model;
					$m_company=$this->Company_model;

					
					$m_email=$this->Email_settings_model;
					$email = $m_email->get_list(2);

					$startDate=date("Y-m-d",strtotime($this->input->get('start',TRUE)));
					$endDate=date("Y-m-d",strtotime($this->input->get('end',TRUE)));

					$company_info=$m_company->get_list();
					$company_info=$company_info[0];

					$vouchers=$this->Journal_info_model->get_voucher_registry($startDate,$endDate);
					$start=$startDate;
					$end=$endDate;
					$total_info=$m_journal_info->get_voucher_registry_total($startDate,$endDate);
					$total_info=$total_info[0];

					ob_start();
					$excel->setActiveSheetIndex(0);

                    //name the worksheet
                    $excel->getActiveSheet()->setTitle("Voucher Registry");

					$excel->getActiveSheet()->setCellValue('A1',$company_info->company_name)
											->mergeCells('A1:D1')
											->getStyle('A1:D1')->getFont()->setBold(TRUE)
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
                    						->mergeCells('A5:D5')
                                            ->getStyle('A5:D5')->applyFromArray($border_bottom);

                    $excel->getActiveSheet()
                            ->getStyle('A6:D6')
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

					$excel->getActiveSheet()->setCellValue('A6','Voucher Registry')
											->mergeCells('A6:D6')
											->getStyle('A6:D6')->getFont()->setBold(True);

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

					$excel->getActiveSheet()->getColumnDimension('A')->setWidth(50);
					$excel->getActiveSheet()->getColumnDimension('B')->setWidth(50);
					$excel->getActiveSheet()->getColumnDimension('C')->setWidth(70);
					$excel->getActiveSheet()->getColumnDimension('D')->setWidth(50);

					$excel->getActiveSheet()->getStyle('A8:D8')->getFont()->setBold(True);

                    $excel->getActiveSheet()
                            ->getStyle('D8')
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

					$excel->getActiveSheet()->setCellValue('A8','CV No.');
					$excel->getActiveSheet()->setCellValue('B8','Date');
					$excel->getActiveSheet()->setCellValue('C8','Particular/Supplier');
					$excel->getActiveSheet()->setCellValue('D8','Amount');

					$i=9;

					foreach ($vouchers as $voucher) { 
	                    $excel->getActiveSheet()
	                            ->getStyle('D'.$i)
	                            ->getAlignment()
	                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);	

	                    $excel->getActiveSheet()
	                            ->getStyle('A'.$i)
	                            ->getAlignment()
	                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);	

						$excel->getActiveSheet()->setCellValue('A'.$i,$voucher->ref_no);
						$excel->getActiveSheet()->setCellValue('B'.$i,$voucher->date_txn);
						$excel->getActiveSheet()->setCellValue('C'.$i,$voucher->supplier_name);
						$excel->getActiveSheet()->getStyle('D'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');	
						$excel->getActiveSheet()->setCellValue('D'.$i,number_format($voucher->amount,2));

						$i++;

					}


                    $border_top= array(
                    'borders' => array(
                        'top' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('rgb' => '292929')
                        )
                    ));

                    $excel->getActiveSheet()
                            ->getStyle('A'.$i.':'.'D'.$i)
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);	

					$excel->getActiveSheet()->setCellValue('A'.$i,'Total')
											->mergeCells('A'.$i.':'.'C'.$i)
											->getStyle('A'.$i.':'.'C'.$i)->getFont()->setBold(True);



					$excel->getActiveSheet()->setCellValue('D'.$i)
                                        	->getStyle('D'.$i)->applyFromArray($border_top);

					$excel->getActiveSheet()->getStyle('D'.$i)->getFont()->setBold(True);

					$excel->getActiveSheet()->setCellValue('D'.$i,number_format($total_info->summary,2))
							  				->getStyle('D'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');

	                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	                header('Content-Disposition: attachment;filename='."Voucher Registry Report.xlsx".'');
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


                            $file_name='Voucher Registry Report '.date('Y-m-d h:i:A', now());
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
                            $subject = 'Voucher Registry Report';
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