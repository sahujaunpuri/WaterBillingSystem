<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class General_ledger extends CORE_Controller 
	{
		function __construct()
		{
			parent::__construct('');
			$this->validate_session();
			$this->load->model(
				array
				(
					'Journal_account_model',
					'Journal_info_model',
					'Customers_model',
					'Suppliers_model',
					'Account_title_model',
					'Account_class_model',
					'Account_type_model',
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
	        $data['title'] = 'General Ledger';

	        $data['account_titles'] = $this->Account_title_model->get_list('account_titles.is_deleted=FALSE AND account_titles.is_active=TRUE',null,null,'account_title');

	        (in_array('9-20',$this->session->user_rights)? 
	        $this->load->view('general_ledger_view',$data)
	        :redirect(base_url('dashboard')));
	        
		}

		function transaction($txn=null, $mode=null){
			switch($txn){
				case 'get-general-ledger':

					$start_Date=date('Y-m-d',strtotime($this->input->get('startDate',TRUE)));
					$end_Date=date('Y-m-d',strtotime($this->input->get('endDate',TRUE)));

					$m_journal_info=$this->Journal_info_model;

					$response['data']=$m_journal_info->get_general_ledger($start_Date,$end_Date);
					echo json_encode($response);

				break;


				case 'report':

					$m_journal_info=$this->Journal_info_model;
					$m_company=$this->Company_model;

					$startDate=date("Y-m-d",strtotime($this->input->get('start',TRUE)));
					$endDate=date("Y-m-d",strtotime($this->input->get('end',TRUE)));

					$company_info=$m_company->get_list();
					$data['company_info']=$company_info[0];

					$report_info=$m_journal_info->get_general_ledger_report($startDate,$endDate);
					$report_item_info = $m_journal_info->get_general_ledger_items($startDate,$endDate);

					$data['start']=$startDate;
					$data['end']=$endDate;
					$data['report_info']=$report_info;
					$data['report_item_info'] = $report_item_info;

					// echo json_encode($report_info);
					$this->load->view('template/general_ledger_report_content',$data);

				break;

				case 'export-excel':

					$m_journal_info=$this->Journal_info_model;
					$m_company=$this->Company_model;

	                $start=date("Y-m-d",strtotime($this->input->get('start',TRUE)));
					$end=date("Y-m-d",strtotime($this->input->get('end',TRUE)));

					$report_info=$m_journal_info->get_general_ledger_report($start,$end);
					$report_item_info = $m_journal_info->get_general_ledger_items($start,$end);

					$company_info=$m_company->get_list();
					$data['company_info']=$company_info[0];

					$excel=$this->excel;
					$htmlHelper = new \PHPExcel_Helper_HTML();
	                $excel->setActiveSheetIndex(0);

	                $excel->getActiveSheet()->getColumnDimension('A')
	                                        ->setAutoSize(false)
	                                        ->setWidth('15');

	                $excel->getActiveSheet()->getColumnDimension('B')
	                                        ->setAutoSize(false)
	                                        ->setWidth('40');

	                $excel->getActiveSheet()->getColumnDimension('C')
	                                        ->setAutoSize(false)
	                                        ->setWidth('15');

	                $excel->getActiveSheet()->getColumnDimension('D')
	                                        ->setAutoSize(false)
	                                        ->setWidth('15');

	                $excel->getActiveSheet()->setTitle('General Ledger');

	                $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
	                                        ->setCellValue('A2',$company_info[0]->company_address)
	                                        ->setCellValue('A3',$company_info[0]->email_address)
	                                        ->setCellValue('A4',$company_info[0]->mobile_no);


	                $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);

					$html_period = "<b> Period: </b> <i>".$start."</i> to <i>".$end."</i>";
					$period = $htmlHelper->toRichTextObject($html_period);

	                $excel->getActiveSheet()->setCellValue('A6','GENERAL LEDGER')
	                                        ->setCellValue('A7',$period);

	                $excel->getActiveSheet()->getStyle('A6')->getFont()->setBold(TRUE);

	                $date = date('m/d/Y');
	                $html_date = "<b> Run Date: </b>".$date;
					$run_date = $htmlHelper->toRichTextObject($html_date);

            		$excel->getActiveSheet()->mergeCells('C6:D6')->setCellValue('C6',$run_date);

				    $style = array(
				        'alignment' => array(
				            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				        )
				    );

				    $excel->getActiveSheet()->getStyle("C6:D6")->applyFromArray($style);


	                $i = 8;
	            	$total_dr = 0;
	            	$total_cr = 0;

	                foreach($report_info as $report)
	                {
	                	$i++;

						$html_txn_no = '<b>Transaction #:</b> '.$report->txn_no ;
						$html_ref_no = ($report->ref_type != '' ? ' | <b>Reference #:</b> '.$report->reference : '');

						$html_no = $html_txn_no.' '.$html_ref_no;

						$html_title = "<b> Date: </b>".$report->date_txn." | <b>Book: </b>".$report->book_type.' | '.$html_no;
						$group_title = $htmlHelper->toRichTextObject($html_title);

                		$excel->getActiveSheet()
	                        ->mergeCells('A'.$i.':'.'D'.$i)
	                        ->setCellValue('A'.$i,$group_title)
	                        ->getStyle('A'.$i.':'.'D'.$i)->applyFromArray(
	                            array(
	                                'fill' => array(
	                                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
	                                    'color' => array('rgb' => 'FFCC80')
	                                )
	                            )
	                        )->getFont()
	                        ->setBold(TRUE);

			                $excel->getActiveSheet()
			                		->getStyle('A'.$i.':'.'D'.$i)->applyFromArray(
									    array(
									        'borders' => array(
									            'allborders' => array(
									                'style' => PHPExcel_Style_Border::BORDER_THIN,
									                'color' => array('rgb' => 'B0BEC5')
									            )
									        )
									    )
									);


			              $i++;

						$html_particular = '<b>'.$report->title.'</b> '.$report->name;
						$group_particular = $htmlHelper->toRichTextObject($html_particular);

							$excel->getActiveSheet()
	                        ->mergeCells('A'.$i.':'.'D'.$i)
	                        ->setCellValue('A'.$i,$group_particular)
	                        ->getStyle('A'.$i.':'.'D'.$i)->applyFromArray(
	                            array(
	                                'fill' => array(
	                                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
	                                    'color' => array('rgb' => 'CFD8DC')
	                                )
	                            )
	                        )->getFont()
	                        ->setBold(TRUE);

			                $excel->getActiveSheet()
			                		->getStyle('A'.$i.':'.'D'.$i)->applyFromArray(
									    array(
									        'borders' => array(
									            'allborders' => array(
									                'style' => PHPExcel_Style_Border::BORDER_THIN,
									                'color' => array('rgb' => 'B0BEC5')
									            )
									        )
									    )
									);


	                	$i++;
			                $excel->getActiveSheet()
			                		->getStyle('A'.$i.':'.'D'.$i)->applyFromArray(
									    array(
									        'borders' => array(
									            'allborders' => array(
									                'style' => PHPExcel_Style_Border::BORDER_THIN,
									                'color' => array('rgb' => 'B0BEC5')
									            )
									        )
									    )
									);

                		$excel->getActiveSheet()->setCellValue('A'.$i,'Account Code')
                						->getStyle('A'.$i)->applyFromArray(
				                            array(
				                                'fill' => array(
				                                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
				                                    'color' => array('rgb' => 'ECEFF1')
				                                )
				                            )
				                        )->getFont()
                                        ->setBold(TRUE);

                		$excel->getActiveSheet()->setCellValue('B'.$i,'Account Title')
                						->getStyle('B'.$i)->applyFromArray(
				                            array(
				                                'fill' => array(
				                                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
				                                    'color' => array('rgb' => 'ECEFF1')
				                                )
				                            )
				                        )->getFont()
                                        ->setBold(TRUE);

                		$excel->getActiveSheet()->setCellValue('C'.$i,'DR')
                						->getStyle('C'.$i)->applyFromArray(
				                            array(
				                                'fill' => array(
				                                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
				                                    'color' => array('rgb' => 'ECEFF1')
				                                )
				                            )
				                        )->getFont()
                                        ->setBold(TRUE);

                		$excel->getActiveSheet()->setCellValue('D'.$i,'CR')
                						->getStyle('D'.$i)->applyFromArray(
				                            array(
				                                'fill' => array(
				                                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
				                                    'color' => array('rgb' => 'ECEFF1')
				                                )
				                            )
				                        )->getFont()
                                        ->setBold(TRUE);

		                $excel->getActiveSheet()
		                		->getStyle('A'.$i)->applyFromArray(
								    array(
								        'borders' => array(
								            'allborders' => array(
								                'style' => PHPExcel_Style_Border::BORDER_THIN,
								                'color' => array('rgb' => 'B0BEC5')
								            )
								        )
								    )
								);

		                $excel->getActiveSheet()
		                		->getStyle('B'.$i)->applyFromArray(
								    array(
								        'borders' => array(
								            'allborders' => array(
								                'style' => PHPExcel_Style_Border::BORDER_THIN,
								                'color' => array('rgb' => 'B0BEC5')
								            )
								        )
								    )
								);

		                $excel->getActiveSheet()
		                		->getStyle('C'.$i)->applyFromArray(
								    array(
								        'borders' => array(
								            'allborders' => array(
								                'style' => PHPExcel_Style_Border::BORDER_THIN,
								                'color' => array('rgb' => 'B0BEC5')
								            )
								        )
								    )
								);

		                $excel->getActiveSheet()
		                		->getStyle('D'.$i)->applyFromArray(
								    array(
								        'borders' => array(
								            'allborders' => array(
								                'style' => PHPExcel_Style_Border::BORDER_THIN,
								                'color' => array('rgb' => 'B0BEC5')
								            )
								        )
								    )
								);								


                        $excel->Align_center('A',$i);
                        $excel->Align_center('B',$i);
                        $excel->Align_center('C',$i);
                        $excel->Align_center('D',$i);

                        foreach ($report_item_info as $report_item){
                        	
                        	if (($report_item->date_txn == $report->date_txn) AND ($report_item->book_type == $report->book_type) AND ($report_item->name == $report->name) AND ($report_item->txn_no == $report->txn_no)) {
                        	$i++;

                        	$total_dr += $report_item->debit;
                        	$total_cr += $report_item->credit;

	                		$excel->getActiveSheet()->setCellValue('A'.$i,$report_item->account_no)
							                		->getStyle('A'.$i)
							                		->applyFromArray(
													    array(
													        'borders' => array(
													            'allborders' => array(
													                'style' => PHPExcel_Style_Border::BORDER_THIN,
													                'color' => array('rgb' => 'B0BEC5')
													            )
													        )
													    )
													)
						                            ->getAlignment()
						                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

	                		$excel->getActiveSheet()->setCellValue('B'.$i,$report_item->account_title)
	                								->getStyle('B'.$i)->applyFromArray(
													    array(
													        'borders' => array(
													            'allborders' => array(
													                'style' => PHPExcel_Style_Border::BORDER_THIN,
													                'color' => array('rgb' => 'B0BEC5')
													            )
													        )
													    )
													);	
	                		$excel->getActiveSheet()->setCellValue('C'.$i,number_format($report_item->debit,2))
	                								->getStyle('C'.$i)
	                								->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

	                		$excel->getActiveSheet()->setCellValue('D'.$i,number_format($report_item->credit,2))
	                								->getStyle('D'.$i)
	                								->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

	                		$excel->getActiveSheet()->getStyle('C'.$i)
	                								->applyFromArray(
													    array(
													        'borders' => array(
													            'allborders' => array(
													                'style' => PHPExcel_Style_Border::BORDER_THIN,
													                'color' => array('rgb' => 'B0BEC5')
													            )
													        )
													    )
													)
													->getAlignment()
						                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						                            
	                		$excel->getActiveSheet()->getStyle('D'.$i)
	                								->applyFromArray(
													    array(
													        'borders' => array(
													            'allborders' => array(
													                'style' => PHPExcel_Style_Border::BORDER_THIN,
													                'color' => array('rgb' => 'B0BEC5')
													            )
													        )
													    )
													)
													->getAlignment()
						                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                        	}
                        }
                        $i++;

                        $excel->getActiveSheet()
		                        ->mergeCells('A'.$i.':'.'B'.$i)
		                        ->setCellValue('A'.$i,'Total:')
		                        ->getStyle('A'.$i.':'.'B'.$i)
		                		->getAlignment()
						        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                		$excel->getActiveSheet()->setCellValue('C'.$i,number_format($total_dr,2))
                						->getStyle('C'.$i)->applyFromArray(
				                            array(
				                                'fill' => array(
				                                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
				                                    'color' => array('rgb' => 'ECEFF1')
				                                )
				                            )
				                        )->getFont()
                                        ->setBold(TRUE);

                		$excel->getActiveSheet()->setCellValue('D'.$i,number_format($total_dr,2))
                						->getStyle('D'.$i)->applyFromArray(
				                            array(
				                                'fill' => array(
				                                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
				                                    'color' => array('rgb' => 'ECEFF1')
				                                )
				                            )
				                        )->getFont()
                                        ->setBold(TRUE);


						$excel->getActiveSheet()->getStyle('A'.$i.':'.'B'.$i)
	                								->applyFromArray(
													    array(
													        'borders' => array(
													            'allborders' => array(
													                'style' => PHPExcel_Style_Border::BORDER_THIN,
													                'color' => array('rgb' => 'B0BEC5')
													            )
													        )
													    )
													);

						$excel->getActiveSheet()->getStyle('A'.$i.':'.'B'.$i)
													->getFont()
		                							->setBold(TRUE);

						$excel->getActiveSheet()->getStyle('C'.$i)
	                								->applyFromArray(
													    array(
													        'borders' => array(
													            'allborders' => array(
													                'style' => PHPExcel_Style_Border::BORDER_THIN,
													                'color' => array('rgb' => 'B0BEC5')
													            )
													        )
													    )
													)
													->getAlignment()
						                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

						$excel->getActiveSheet()->getStyle('D'.$i)
	                								->applyFromArray(
													    array(
													        'borders' => array(
													            'allborders' => array(
													                'style' => PHPExcel_Style_Border::BORDER_THIN,
													                'color' => array('rgb' => 'B0BEC5')
													            )
													        )
													    )
													)
													->getAlignment()
						                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

		                $total_dr = 0;$total_cr = 0;

		                $i++;
                        if ($report->remarks != ""){
					
						$html = "<b> Remarks: </b>".$report->remarks;
						$remark = $htmlHelper->toRichTextObject($html);

	                		$excel->getActiveSheet()
		                        ->mergeCells('A'.$i.':'.'D'.$i)
		                        ->setCellValue('A'.$i,$remark)
		                        ->getStyle('A'.$i.':'.'D'.$i)->applyFromArray(
		                            array(
		                                'fill' => array(
		                                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
		                                    'color' => array('rgb' => 'ECEFF1')
		                                )
		                            )
		                        );

			                $excel->getActiveSheet()
			                		->getStyle('A'.$i.':'.'D'.$i)->applyFromArray(
									    array(
									        'borders' => array(
									            'allborders' => array(
									                'style' => PHPExcel_Style_Border::BORDER_THIN,
									                'color' => array('rgb' => 'B0BEC5')
									            )
									        )
									    )
									);


	                   		$i++;
	               		}

	                }
	                $i++;


	                // Redirect output to a client’s web browser (Excel2007)
	                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	                header('Content-Disposition: attachment;filename="General Ledger '.$start.' to '.$end.'.xlsx"');
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

				case 'email-export':
	                $m_email=$this->Email_settings_model;
	                $email=$m_email->get_list(2);    

					$m_journal_info=$this->Journal_info_model;
					$m_company=$this->Company_model;

	                $start=date("Y-m-d",strtotime($this->input->get('start',TRUE)));
					$end=date("Y-m-d",strtotime($this->input->get('end',TRUE)));

					$report_info=$m_journal_info->get_general_ledger_report($start,$end);
					$report_item_info = $m_journal_info->get_general_ledger_items($start,$end);

					$company_info=$m_company->get_list();
					$data['company_info']=$company_info[0];

					$excel=$this->excel;
					$htmlHelper = new \PHPExcel_Helper_HTML();
					
					ob_start();
	                $excel->setActiveSheetIndex(0);
	                $excel->getActiveSheet()->getColumnDimension('A')
	                                        ->setAutoSize(false)
	                                        ->setWidth('15');

	                $excel->getActiveSheet()->getColumnDimension('B')
	                                        ->setAutoSize(false)
	                                        ->setWidth('40');

	                $excel->getActiveSheet()->getColumnDimension('C')
	                                        ->setAutoSize(false)
	                                        ->setWidth('15');

	                $excel->getActiveSheet()->getColumnDimension('D')
	                                        ->setAutoSize(false)
	                                        ->setWidth('15');

	                $excel->getActiveSheet()->setTitle('General Ledger');

	                $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
	                                        ->setCellValue('A2',$company_info[0]->company_address)
	                                        ->setCellValue('A3',$company_info[0]->email_address)
	                                        ->setCellValue('A4',$company_info[0]->mobile_no);


	                $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);

					$html_period = "<b> Period: </b> <i>".$start."</i> to <i>".$end."</i>";
					$period = $htmlHelper->toRichTextObject($html_period);

	                $excel->getActiveSheet()->setCellValue('A6','GENERAL LEDGER')
	                                        ->setCellValue('A7',$period);

	                $excel->getActiveSheet()->getStyle('A6')->getFont()->setBold(TRUE);

	                $date = date('m/d/Y');
	                $html_date = "<b> Run Date: </b>".$date;
					$run_date = $htmlHelper->toRichTextObject($html_date);

            		$excel->getActiveSheet()->mergeCells('C6:D6')->setCellValue('C6',$run_date);

				    $style = array(
				        'alignment' => array(
				            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				        )
				    );

				    $excel->getActiveSheet()->getStyle("C6:D6")->applyFromArray($style);


	                $i = 8;
	            	$total_dr = 0;
	            	$total_cr = 0;

	                foreach($report_info as $report)
	                {
	                	$i++;

						$html_txn_no = '<b>Transaction #:</b> '.$report->txn_no ;
						$html_ref_no = ($report->ref_type != '' ? ' | <b>Reference #:</b> '.$report->reference : '');

						$html_no = $html_txn_no.' '.$html_ref_no;

						$html_title = "<b> Date: </b>".$report->date_txn." | <b>Book: </b>".$report->book_type.' | '.$html_no;
						$group_title = $htmlHelper->toRichTextObject($html_title);

                		$excel->getActiveSheet()
	                        ->mergeCells('A'.$i.':'.'D'.$i)
	                        ->setCellValue('A'.$i,$group_title)
	                        ->getStyle('A'.$i.':'.'D'.$i)->applyFromArray(
	                            array(
	                                'fill' => array(
	                                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
	                                    'color' => array('rgb' => 'FFCC80')
	                                )
	                            )
	                        )->getFont()
	                        ->setBold(TRUE);

			                $excel->getActiveSheet()
			                		->getStyle('A'.$i.':'.'D'.$i)->applyFromArray(
									    array(
									        'borders' => array(
									            'allborders' => array(
									                'style' => PHPExcel_Style_Border::BORDER_THIN,
									                'color' => array('rgb' => 'B0BEC5')
									            )
									        )
									    )
									);


			              $i++;

						$html_particular = '<b>'.$report->title.'</b> '.$report->name;
						$group_particular = $htmlHelper->toRichTextObject($html_particular);

							$excel->getActiveSheet()
	                        ->mergeCells('A'.$i.':'.'D'.$i)
	                        ->setCellValue('A'.$i,$group_particular)
	                        ->getStyle('A'.$i.':'.'D'.$i)->applyFromArray(
	                            array(
	                                'fill' => array(
	                                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
	                                    'color' => array('rgb' => 'CFD8DC')
	                                )
	                            )
	                        )->getFont()
	                        ->setBold(TRUE);

			                $excel->getActiveSheet()
			                		->getStyle('A'.$i.':'.'D'.$i)->applyFromArray(
									    array(
									        'borders' => array(
									            'allborders' => array(
									                'style' => PHPExcel_Style_Border::BORDER_THIN,
									                'color' => array('rgb' => 'B0BEC5')
									            )
									        )
									    )
									);


	                	$i++;
			                $excel->getActiveSheet()
			                		->getStyle('A'.$i.':'.'D'.$i)->applyFromArray(
									    array(
									        'borders' => array(
									            'allborders' => array(
									                'style' => PHPExcel_Style_Border::BORDER_THIN,
									                'color' => array('rgb' => 'B0BEC5')
									            )
									        )
									    )
									);

                		$excel->getActiveSheet()->setCellValue('A'.$i,'Account Code')
                						->getStyle('A'.$i)->applyFromArray(
				                            array(
				                                'fill' => array(
				                                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
				                                    'color' => array('rgb' => 'ECEFF1')
				                                )
				                            )
				                        )->getFont()
                                        ->setBold(TRUE);

                		$excel->getActiveSheet()->setCellValue('B'.$i,'Account Title')
                						->getStyle('B'.$i)->applyFromArray(
				                            array(
				                                'fill' => array(
				                                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
				                                    'color' => array('rgb' => 'ECEFF1')
				                                )
				                            )
				                        )->getFont()
                                        ->setBold(TRUE);

                		$excel->getActiveSheet()->setCellValue('C'.$i,'DR')
                						->getStyle('C'.$i)->applyFromArray(
				                            array(
				                                'fill' => array(
				                                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
				                                    'color' => array('rgb' => 'ECEFF1')
				                                )
				                            )
				                        )->getFont()
                                        ->setBold(TRUE);

                		$excel->getActiveSheet()->setCellValue('D'.$i,'CR')
                						->getStyle('D'.$i)->applyFromArray(
				                            array(
				                                'fill' => array(
				                                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
				                                    'color' => array('rgb' => 'ECEFF1')
				                                )
				                            )
				                        )->getFont()
                                        ->setBold(TRUE);

		                $excel->getActiveSheet()
		                		->getStyle('A'.$i)->applyFromArray(
								    array(
								        'borders' => array(
								            'allborders' => array(
								                'style' => PHPExcel_Style_Border::BORDER_THIN,
								                'color' => array('rgb' => 'B0BEC5')
								            )
								        )
								    )
								);

		                $excel->getActiveSheet()
		                		->getStyle('B'.$i)->applyFromArray(
								    array(
								        'borders' => array(
								            'allborders' => array(
								                'style' => PHPExcel_Style_Border::BORDER_THIN,
								                'color' => array('rgb' => 'B0BEC5')
								            )
								        )
								    )
								);

		                $excel->getActiveSheet()
		                		->getStyle('C'.$i)->applyFromArray(
								    array(
								        'borders' => array(
								            'allborders' => array(
								                'style' => PHPExcel_Style_Border::BORDER_THIN,
								                'color' => array('rgb' => 'B0BEC5')
								            )
								        )
								    )
								);

		                $excel->getActiveSheet()
		                		->getStyle('D'.$i)->applyFromArray(
								    array(
								        'borders' => array(
								            'allborders' => array(
								                'style' => PHPExcel_Style_Border::BORDER_THIN,
								                'color' => array('rgb' => 'B0BEC5')
								            )
								        )
								    )
								);								


                        $excel->Align_center('A',$i);
                        $excel->Align_center('B',$i);
                        $excel->Align_center('C',$i);
                        $excel->Align_center('D',$i);

                        foreach ($report_item_info as $report_item){
                        	
                        	if (($report_item->date_txn == $report->date_txn) AND ($report_item->book_type == $report->book_type) AND ($report_item->name == $report->name) AND ($report_item->txn_no == $report->txn_no)) {
                        	$i++;

                        	$total_dr += $report_item->debit;
                        	$total_cr += $report_item->credit;

	                		$excel->getActiveSheet()->setCellValue('A'.$i,$report_item->account_no)
							                		->getStyle('A'.$i)
							                		->applyFromArray(
													    array(
													        'borders' => array(
													            'allborders' => array(
													                'style' => PHPExcel_Style_Border::BORDER_THIN,
													                'color' => array('rgb' => 'B0BEC5')
													            )
													        )
													    )
													)
						                            ->getAlignment()
						                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

	                		$excel->getActiveSheet()->setCellValue('B'.$i,$report_item->account_title)
	                								->getStyle('B'.$i)->applyFromArray(
													    array(
													        'borders' => array(
													            'allborders' => array(
													                'style' => PHPExcel_Style_Border::BORDER_THIN,
													                'color' => array('rgb' => 'B0BEC5')
													            )
													        )
													    )
													);	
	                		$excel->getActiveSheet()->setCellValue('C'.$i,number_format($report_item->debit,2))
	                								->getStyle('C'.$i)
	                								->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

	                		$excel->getActiveSheet()->setCellValue('D'.$i,number_format($report_item->credit,2))
	                								->getStyle('D'.$i)
	                								->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

	                		$excel->getActiveSheet()->getStyle('C'.$i)
	                								->applyFromArray(
													    array(
													        'borders' => array(
													            'allborders' => array(
													                'style' => PHPExcel_Style_Border::BORDER_THIN,
													                'color' => array('rgb' => 'B0BEC5')
													            )
													        )
													    )
													)
													->getAlignment()
						                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						                            
	                		$excel->getActiveSheet()->getStyle('D'.$i)
	                								->applyFromArray(
													    array(
													        'borders' => array(
													            'allborders' => array(
													                'style' => PHPExcel_Style_Border::BORDER_THIN,
													                'color' => array('rgb' => 'B0BEC5')
													            )
													        )
													    )
													)
													->getAlignment()
						                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                        	}
                        }
                        $i++;

                        $excel->getActiveSheet()
		                        ->mergeCells('A'.$i.':'.'B'.$i)
		                        ->setCellValue('A'.$i,'Total:')
		                        ->getStyle('A'.$i.':'.'B'.$i)
		                		->getAlignment()
						        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                		$excel->getActiveSheet()->setCellValue('C'.$i,number_format($total_dr,2))
                						->getStyle('C'.$i)->applyFromArray(
				                            array(
				                                'fill' => array(
				                                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
				                                    'color' => array('rgb' => 'ECEFF1')
				                                )
				                            )
				                        )->getFont()
                                        ->setBold(TRUE);

                		$excel->getActiveSheet()->setCellValue('D'.$i,number_format($total_dr,2))
                						->getStyle('D'.$i)->applyFromArray(
				                            array(
				                                'fill' => array(
				                                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
				                                    'color' => array('rgb' => 'ECEFF1')
				                                )
				                            )
				                        )->getFont()
                                        ->setBold(TRUE);


						$excel->getActiveSheet()->getStyle('A'.$i.':'.'B'.$i)
	                								->applyFromArray(
													    array(
													        'borders' => array(
													            'allborders' => array(
													                'style' => PHPExcel_Style_Border::BORDER_THIN,
													                'color' => array('rgb' => 'B0BEC5')
													            )
													        )
													    )
													);

						$excel->getActiveSheet()->getStyle('A'.$i.':'.'B'.$i)
													->getFont()
		                							->setBold(TRUE);

						$excel->getActiveSheet()->getStyle('C'.$i)
	                								->applyFromArray(
													    array(
													        'borders' => array(
													            'allborders' => array(
													                'style' => PHPExcel_Style_Border::BORDER_THIN,
													                'color' => array('rgb' => 'B0BEC5')
													            )
													        )
													    )
													)
													->getAlignment()
						                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

						$excel->getActiveSheet()->getStyle('D'.$i)
	                								->applyFromArray(
													    array(
													        'borders' => array(
													            'allborders' => array(
													                'style' => PHPExcel_Style_Border::BORDER_THIN,
													                'color' => array('rgb' => 'B0BEC5')
													            )
													        )
													    )
													)
													->getAlignment()
						                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

		                $total_dr = 0;$total_cr = 0;

		                $i++;
                        if ($report->remarks != ""){
					
						$html = "<b> Remarks: </b>".$report->remarks;
						$remark = $htmlHelper->toRichTextObject($html);

	                		$excel->getActiveSheet()
		                        ->mergeCells('A'.$i.':'.'D'.$i)
		                        ->setCellValue('A'.$i,$remark)
		                        ->getStyle('A'.$i.':'.'D'.$i)->applyFromArray(
		                            array(
		                                'fill' => array(
		                                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
		                                    'color' => array('rgb' => 'ECEFF1')
		                                )
		                            )
		                        );

			                $excel->getActiveSheet()
			                		->getStyle('A'.$i.':'.'D'.$i)->applyFromArray(
									    array(
									        'borders' => array(
									            'allborders' => array(
									                'style' => PHPExcel_Style_Border::BORDER_THIN,
									                'color' => array('rgb' => 'B0BEC5')
									            )
									        )
									    )
									);


	                   		$i++;
	               		}

	                }
	                $i++;


	                // Redirect output to a client’s web browser (Excel2007)
	                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	                header('Content-Disposition: attachment;filename="General Ledger '.$start.' to '.$end.'.xlsx"');
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

                          $file_name='General Ledger '.date('Y-m-d h:i:A', now());
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
                            $subject = 'General Ledger '.date('Y');
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