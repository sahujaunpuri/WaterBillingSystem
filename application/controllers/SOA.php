<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class SOA extends CORE_Controller
	{
		function __construct()
		{
			parent::__construct();
			$this->validate_session();
			$this->load->model(
				array(
					'Sales_invoice_model',
					'Customers_model',
					'Users_model',
					'Soa_settings_model',
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
	        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', true);
	        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', true);
	        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', true);
	        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', true);
	        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', true);
	        $data['title'] = 'Statement of Account';

	        $data['customers'] = $this->Customers_model->get_list('is_deleted=FALSE AND is_active=TRUE');

	        $this->load->view('statement_of_account_view',$data);
		}

		function transaction($txn)
		{
			switch ($txn)
			{
				case 'balances':
					$m_sales = $this->Sales_invoice_model;

					$accounts=$this->Soa_settings_model->get_list(null,'soa_account_id'); 
	                $acc = []; 
	                foreach ($accounts as $account) { $acc[]=$account->soa_account_id; } 
	                $filter_accounts =  implode(",", $acc); 

					$customer_id = $this->input->get('cusid',TRUE);
					$response['previous_balances_soa'] = $m_sales->get_customer_soa_final(false,$customer_id,null,null,$filter_accounts);
					$response['current_balances_soa'] = $m_sales->get_customer_soa_final(true,$customer_id,null,null,$filter_accounts);
					
					// $response['current_balances'] = $m_sales->get_customer_soa('= MONTH(NOW())',$customer_id,null,null);


					// $response['previous_balances'] = $m_sales->get_customer_soa_complete('< MONTH(NOW())',$customer_id,null,null);
					// $response['current_balances'] = $m_sales->get_customer_soa_complete('= MONTH(NOW())',$customer_id,null,null);

					
					$response['payments'] = $m_sales->get_customer_soa_payment($customer_id,$filter_accounts);
					echo json_encode($response);
					break;

				case 'print':
					$m_sales = $this->Sales_invoice_model;

					$customer_id = $this->input->get('cusid',TRUE);

					$company_info = $this->Company_model->get_list();

					$data['company_info'] = $company_info[0];

					$customer_info = $this->Customers_model->get_list($customer_id);

					$data['customer_info'] = $customer_info[0];
	                $accounts=$this->Soa_settings_model->get_list(null,'soa_account_id'); 
	                $acc = []; 
	                foreach ($accounts as $account) { $acc[]=$account->soa_account_id; } 
	                $filter_accounts =  implode(",", $acc); 

					$data['previous_balances'] = $m_sales->get_customer_soa_final(false,$customer_id,null,null,$filter_accounts);
					$data['current_balances'] = $m_sales->get_customer_soa_final(true,$customer_id,null,null,$filter_accounts);
					$data['payments'] = $m_sales->get_customer_soa_payment($customer_id,$filter_accounts);


                    $file_name='Aging of Receivables';
                    
                    $pdfFilePath = $file_name.".pdf"; //generate filename base on id
                    $pdf = $this->m_pdf->load("A4-L"); //pass the instance of the mpdf class
                    $content=$this->load->view('template/soa_print',$data,TRUE); //load the template
                    $pdf->setFooter('{PAGENO}');
                    $pdf->WriteHTML($content);
                    //download it.
                    $pdf->Output();

				#	$this->load->view('template/soa_print',$data);
					break;

				case 'export':
                	$excel=$this->excel;
					$m_sales = $this->Sales_invoice_model;

					$customer_id = $this->input->get('cusid',TRUE);

					$company_info = $this->Company_model->get_list();

					$data['company_info'] = $company_info[0];

					$customer_info = $this->Customers_model->get_list($customer_id);

					$customer_info = $customer_info[0];

	                $accounts=$this->Soa_settings_model->get_list(null,'soa_account_id'); 
	                $acc = []; 
	                foreach ($accounts as $account) { $acc[]=$account->soa_account_id; } 
	                $filter_accounts =  implode(",", $acc); 


					$previous_balances = $m_sales->get_customer_soa_final(false,$customer_id,null,null,$filter_accounts);
					$current_balances = $m_sales->get_customer_soa_final(true,$customer_id,null,null,$filter_accounts);
					$payments = $m_sales->get_customer_soa_payment($customer_id,$filter_accounts);

	                $excel->setActiveSheetIndex(0);

	                $excel->getActiveSheet()->getColumnDimensionByColumn('A1:B1')->setWidth('30');
	                $excel->getActiveSheet()->getColumnDimensionByColumn('A2:C2')->setWidth('50');
	                $excel->getActiveSheet()->getColumnDimensionByColumn('A3')->setWidth('30');
	                $excel->getActiveSheet()->getColumnDimensionByColumn('A4')->setWidth('40');

	                //name the worksheet
	                $excel->getActiveSheet()->setTitle("Aging of Receivables Report");
	                $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->mergeCells('A1:B1');
	                $excel->getActiveSheet()->mergeCells('A2:C2');
	                $excel->getActiveSheet()->mergeCells('A3:B3');
	                $excel->getActiveSheet()->mergeCells('A4:B4');
	                $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
	                                        ->setCellValue('A2',$company_info[0]->company_address)
	                                        ->setCellValue('A3',$company_info[0]->landline.'/'.$company_info[0]->mobile_no)
	                                        ->setCellValue('A4',$company_info[0]->email_address);

	                $excel->getActiveSheet()->getColumnDimensionByColumn('A6:C6')->setWidth('50');	                                        
	                $excel->getActiveSheet()->mergeCells('A6:C6');
                	$excel->getActiveSheet()->setCellValue('A6',$customer_info->customer_name.'`S '.'STATEMENT OF ACCOUNT')
                                        	->getStyle('A6')->getFont()->setBold(TRUE)
                                        	->setSize(14);
	                
	                $excel->getActiveSheet()->mergeCells('A8:B8');					
                	$excel->getActiveSheet()->setCellValue('A8','Customer Name: '.$customer_info->customer_name)
                                        	->getStyle('A8')->getFont()->setBold(TRUE);

	                $excel->getActiveSheet()->mergeCells('D8:E8');                                        	
                	$excel->getActiveSheet()->setCellValue('D8','Date: '.date('Y-m-d'))
                                        	->getStyle('D8')->getFont()->setBold(TRUE);

                	$excel->getActiveSheet()->setCellValue('A9','Address: '.$customer_info->address)
                                        	->getStyle('A9')->getFont()->setBold(TRUE);

	                $excel->getActiveSheet()->mergeCells('D9:F9');
                	$excel->getActiveSheet()->setCellValue('D9','Contact Person: '.$customer_info->contact_name)
                                        	->getStyle('D9')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()
	                        ->getStyle('A10')
	                        ->getAlignment()
	                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

					$sumPrev = 0; $sumPrevSales=0; $sumPrevService=0; $sumCur = 0; $sumPayment = 0; $totalBalance = 0; $total = 0;  $sumCurSales=0;
							$sumCurService=0; $sumPaymentSales=0 ; $sumPaymentService=0; 

	                $excel->getActiveSheet()->mergeCells('A10:E10');
                	$excel->getActiveSheet()->setCellValue('A10','PREVIOUS BALANCES')
                                        	->getStyle('A10')->getFont()->setBold(TRUE);

	                $excel->getActiveSheet()->getColumnDimension('A')->setWidth('40');
	                $excel->getActiveSheet()->getColumnDimension('B')->setWidth('25');
	                $excel->getActiveSheet()->getColumnDimension('C')->setWidth('25');
	                $excel->getActiveSheet()->getColumnDimension('D')->setWidth('25');
	                $excel->getActiveSheet()->getColumnDimension('E')->setWidth('30');

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

	                $excel->getActiveSheet()->setCellValue('A11','Invoice #')
	                                        ->getStyle('A11')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->setCellValue('B11','Date')
	                                        ->getStyle('B11')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->setCellValue('C11','Amount')
	                                        ->getStyle('C11')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->setCellValue('D11','Balance Amount')
	                                        ->getStyle('D11')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->setCellValue('E11','Total')
	                                        ->getStyle('E11')->getFont()->setBold(TRUE);

	                $excel->getActiveSheet()->mergeCells('A12:E12');
                	$excel->getActiveSheet()->setCellValue('A12','SALES INVOICE');


                    $i=13;

                    foreach($previous_balances as $previous_balance) {
						if($previous_balance->is_sales == 1) { 
			                $excel->getActiveSheet()->setCellValue('A'.$i,$previous_balance->invoice_no);
			                $excel->getActiveSheet()->setCellValue('B'.$i,$previous_balance->date_txn);
                    		$excel->getActiveSheet()->getStyle('C'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');		            
			                $excel->getActiveSheet()->setCellValue('C'.$i,number_format($previous_balance->receivable_amount,2));
		                    $excel->getActiveSheet()->getStyle('D'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');		            	                
			                $excel->getActiveSheet()->setCellValue('D'.$i,number_format($previous_balance->balance,2));

							$i++;
							$sumPrevSales += $previous_balance->receivable_amount;
						}
                    }

			                $excel->getActiveSheet()->mergeCells('A'.$i.':'.'E'.$i);
		                	$excel->getActiveSheet()->setCellValue('A'.$i,'SERVICE INVOICE');					                    
					foreach($previous_balances as $previous_balance) {
						if($previous_balance->is_sales == 0) {
			                $excel->getActiveSheet()->setCellValue('A'.$i,$previous_balance->invoice_no);
			                $excel->getActiveSheet()->setCellValue('B'.$i,$previous_balance->date_txn);
                    		$excel->getActiveSheet()->getStyle('C'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');		            
			                $excel->getActiveSheet()->setCellValue('C'.$i,number_format($previous_balance->receivable_amount,2));
		                    $excel->getActiveSheet()->getStyle('D'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');		            	                
			                $excel->getActiveSheet()->setCellValue('D'.$i,number_format($previous_balance->balance,2));

			                $i++;
			                $sumPrevService += $previous_balance->receivable_amount;
						}
					}
							$i++;
			                $excel->getActiveSheet()
			                        ->getStyle('A'.$i,':','D'.$i)
			                        ->getAlignment()
			                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

							$excel->getActiveSheet()->mergeCells('A'.$i.':'.'D'.$i);
		                	$excel->getActiveSheet()->setCellValue('A'.$i,'SUB-TOTAL:')					                    
	                                        		->getStyle('A'.$i)->getFont()->setBold(TRUE);
	                        $sumPrev = $sumPrevSales + $sumPrevService;              

		                    $excel->getActiveSheet()->getStyle('E'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');		            	                	
			                $excel->getActiveSheet()->setCellValue('E'.$i,number_format($sumPrev,2));

			                $i++;

			                $excel->getActiveSheet()
			                        ->getStyle('A'.$i)
			                        ->getAlignment()
			                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
			                        	                
			                $excel->getActiveSheet()->mergeCells('A'.$i.':'.'E'.$i);
		                	$excel->getActiveSheet()->setCellValue('A'.$i,'CURRENT BALANCES')
		                                        	->getStyle('A'.$i)->getFont()->setBold(TRUE);			                

			                $excel->getActiveSheet()
			                        ->getStyle('C'.$i)
			                        ->getAlignment()
			                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			                $excel->getActiveSheet()
			                        ->getStyle('D'.$i)
			                        ->getAlignment()
			                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			                $excel->getActiveSheet()
			                        ->getStyle('E'.$i)
			                        ->getAlignment()
			                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);	

			                $i++;
			                $excel->getActiveSheet()->setCellValue('A'.$i,'Invoice #')
			                                        ->getStyle('A'.$i)->getFont()->setBold(TRUE);
			                $excel->getActiveSheet()->setCellValue('B'.$i,'Date')
			                                        ->getStyle('B'.$i)->getFont()->setBold(TRUE);
			                $excel->getActiveSheet()->setCellValue('C'.$i,'Amount')
			                                        ->getStyle('C'.$i)->getFont()->setBold(TRUE);
			                $excel->getActiveSheet()->setCellValue('D'.$i,'Balance Amount')
			                                        ->getStyle('D'.$i)->getFont()->setBold(TRUE);
			                $excel->getActiveSheet()->setCellValue('E'.$i,'Total')
			                                        ->getStyle('E'.$i)->getFont()->setBold(TRUE);

			                $i++;
			                $excel->getActiveSheet()->mergeCells('A'.$i.':'.'E'.$i);
		                	$excel->getActiveSheet()->setCellValue('A'.$i,'SALES INVOICE');

		                	$i++;
                	foreach($current_balances as $current_balance) {
						if($current_balance->is_sales == 1) {
			                $excel->getActiveSheet()->setCellValue('A'.$i,$current_balance->invoice_no);
			                $excel->getActiveSheet()->setCellValue('B'.$i,$current_balance->date_txn);
                    		$excel->getActiveSheet()->getStyle('C'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');		            
			                $excel->getActiveSheet()->setCellValue('C'.$i,number_format($current_balance->receivable_amount,2));
		                    $excel->getActiveSheet()->getStyle('D'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');		            	                
			                $excel->getActiveSheet()->setCellValue('D'.$i,number_format($current_balance->balance,2));
			                
			                $i++;
							$sumCurSales += $current_balance->receivable_amount;
						}
                	}
			                $excel->getActiveSheet()->mergeCells('A'.$i.':'.'E'.$i);
		                	$excel->getActiveSheet()->setCellValue('A'.$i,'SERVICE INVOICE');

		                	$i++;
		            foreach($current_balances as $current_balance) {
		            	if($current_balance->is_sales == 0) {
			                $excel->getActiveSheet()->setCellValue('A'.$i,$current_balance->invoice_no);
			                $excel->getActiveSheet()->setCellValue('B'.$i,$current_balance->date_txn);
                    		$excel->getActiveSheet()->getStyle('C'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');		            
			                $excel->getActiveSheet()->setCellValue('C'.$i,number_format($current_balance->receivable_amount,2));
		                    $excel->getActiveSheet()->getStyle('D'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');		            	                
			                $excel->getActiveSheet()->setCellValue('D'.$i,number_format($current_balance->balance,2));

			                $i++;
			                $sumCurService += $current_balance->receivable_amount;
		            	}
		            }
							$i++;
			                $excel->getActiveSheet()
			                        ->getStyle('A'.$i,':','D'.$i)
			                        ->getAlignment()
			                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

							$excel->getActiveSheet()->mergeCells('A'.$i.':'.'D'.$i);
		                	$excel->getActiveSheet()->setCellValue('A'.$i,'SUB-TOTAL:')					                    
	                                        		->getStyle('A'.$i)->getFont()->setBold(TRUE);
	                        $sumCur = $sumCurService + $sumCurSales;              

		                    $excel->getActiveSheet()->getStyle('E'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');		            	                	
			                $excel->getActiveSheet()->setCellValue('E'.$i,number_format($sumCur,2));

			                $i++;
			                $excel->getActiveSheet()
			                        ->getStyle('A'.$i)
			                        ->getAlignment()
			                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
			                        	                
			                $excel->getActiveSheet()->mergeCells('A'.$i.':'.'E'.$i);
		                	$excel->getActiveSheet()->setCellValue('A'.$i,'PAYMENTS')
		                                        	->getStyle('A'.$i)->getFont()->setBold(TRUE);			                

			                $excel->getActiveSheet()
			                        ->getStyle('C'.$i)
			                        ->getAlignment()
			                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

			                $i++;
			                $excel->getActiveSheet()->setCellValue('A'.$i,'Receipt #')
			                                        ->getStyle('A'.$i)->getFont()->setBold(TRUE);
			                $excel->getActiveSheet()->setCellValue('B'.$i,'Date')
			                                        ->getStyle('B'.$i)->getFont()->setBold(TRUE);
			                $excel->getActiveSheet()->setCellValue('C'.$i,'Payment Amount')
			                                        ->getStyle('C'.$i)->getFont()->setBold(TRUE);
			                $excel->getActiveSheet()->mergeCells('D'.$i.':'.'E'.$i);


			                $i++;
			                $excel->getActiveSheet()->mergeCells('A'.$i.':'.'E'.$i);
		                	$excel->getActiveSheet()->setCellValue('A'.$i,'SALES');

		                	$i++;

					foreach($payments as $payment) { 
						if($payment->is_sales == 1) {
			                $excel->getActiveSheet()->setCellValue('A'.$i,$payment->receipt_no_desc);
			                $excel->getActiveSheet()->setCellValue('B'.$i,$payment->date_paid);
                    		$excel->getActiveSheet()->getStyle('C'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');		            
			                $excel->getActiveSheet()->setCellValue('C'.$i,number_format($payment->payment_amount,2));
			                $i++;
			                $sumPaymentSales += $payment->payment_amount;
						}
					}
			                $excel->getActiveSheet()->mergeCells('A'.$i.':'.'E'.$i);
		                	$excel->getActiveSheet()->setCellValue('A'.$i,'SERVICE');

		              		$i++;
		            foreach($payments as $payment) {
						if($payment->is_sales == 0) { 
			                $excel->getActiveSheet()->setCellValue('A'.$i,$payment->receipt_no_desc);
			                $excel->getActiveSheet()->setCellValue('B'.$i,$payment->date_paid);
                    		$excel->getActiveSheet()->getStyle('C'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');		            
			                $excel->getActiveSheet()->setCellValue('C'.$i,number_format($payment->payment_amount,2));
			                $i++;
			                $sumPaymentService += $payment->payment_amount;
						}
		            }	

				           	$sumPayment = $sumPaymentService + $sumPaymentSales;
				           	$total = $sumPrev + $sumCur; 
							$totalBalance = $total - $sumPayment;

			                $excel->getActiveSheet()
			                        ->getStyle('A'.$i,':','D'.$i)
			                        ->getAlignment()
			                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

							$excel->getActiveSheet()->mergeCells('A'.$i.':'.'D'.$i);
		                	$excel->getActiveSheet()->setCellValue('A'.$i,'TOTAL:')					                    
	                                        		->getStyle('A'.$i)->getFont()->setBold(TRUE);

		                    $excel->getActiveSheet()->getStyle('E'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');		            	                	
			                $excel->getActiveSheet()->setCellValue('E'.$i,number_format($total,2));

			                $i++;

			                $excel->getActiveSheet()
			                        ->getStyle('A'.$i,':','D'.$i)
			                        ->getAlignment()
			                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

							$excel->getActiveSheet()->mergeCells('A'.$i.':'.'D'.$i);
		                	$excel->getActiveSheet()->setCellValue('A'.$i,'LESS PAYMENT:')					                    
	                                        		->getStyle('A'.$i)->getFont()->setBold(TRUE);

		                    $excel->getActiveSheet()->getStyle('E'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');		            	                	
			                $excel->getActiveSheet()->setCellValue('E'.$i,number_format($sumPayment,2));

			               	$i++;

			                $excel->getActiveSheet()
			                        ->getStyle('A'.$i,':','D'.$i)
			                        ->getAlignment()
			                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

							$excel->getActiveSheet()->mergeCells('A'.$i.':'.'D'.$i);
		                	$excel->getActiveSheet()->setCellValue('A'.$i,'BALANCE:')					                    
	                                        		->getStyle('A'.$i)->getFont()->setBold(TRUE);

		                    $excel->getActiveSheet()->getStyle('E'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');		            	                	
			                $excel->getActiveSheet()->setCellValue('E'.$i,number_format($totalBalance,2));
							
							$i++;

							$BStyle = array(
							  'borders' => array(
							    'bottom' => array(
							      'style' => PHPExcel_Style_Border::BORDER_THIN
							    )
							  )
							);

			                $i++;

	                		$excel->getActiveSheet()->getColumnDimensionByColumn('A'.$i.':'.'B'.$i)->setWidth('30');
	                		$excel->getActiveSheet()->getColumnDimensionByColumn('D'.$i.':'.'E'.$i)->setWidth('30');

			                $excel->getActiveSheet()->mergeCells('A'.$i.':'.'B'.$i);
							$excel->getActiveSheet()->getStyle('A'.$i.':'.'B'.$i)->applyFromArray($BStyle);

			                $excel->getActiveSheet()->mergeCells('D'.$i.':'.'E'.$i);
							$excel->getActiveSheet()->getStyle('D'.$i.':'.'E'.$i)->applyFromArray($BStyle);			


			                $i++;
			                $excel->getActiveSheet()
			                        ->getStyle('A'.$i,':','B'.$i)
			                        ->getAlignment()
			                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			                $excel->getActiveSheet()
			                        ->getStyle('D'.$i,':','E'.$i)
			                        ->getAlignment()
			                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			                $excel->getActiveSheet()->mergeCells('A'.$i.':'.'B'.$i);
							$excel->getActiveSheet()->setCellValue('A'.$i,'Prepared By')	
	                                        		->getStyle('A'.$i)->getFont()->setBold(TRUE);																	                    
			                $excel->getActiveSheet()->mergeCells('D'.$i.':'.'E'.$i);
							$excel->getActiveSheet()->setCellValue('D'.$i,'Received By')		
	                                        		->getStyle('D'.$i)->getFont()->setBold(TRUE);

	                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	                header('Content-Disposition: attachment;filename='."Statement of Account.xlsx".'');
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

					$customer_id = $this->input->get('cusid',TRUE);

					$company_info = $this->Company_model->get_list();

					$data['company_info'] = $company_info[0];

					$customer_info = $this->Customers_model->get_list($customer_id);

					$customer_info = $customer_info[0];

					$previous_balances = $m_sales->get_customer_soa_final(false,$customer_id,null,null,$filter_accounts);
					$current_balances = $m_sales->get_customer_soa_final(true,$customer_id,null,null,$filter_accounts);
					$payments = $m_sales->get_customer_soa_payment($customer_id,$filter_accounts);

					ob_start();
	                $excel->setActiveSheetIndex(0);

	                $excel->getActiveSheet()->getColumnDimensionByColumn('A1:B1')->setWidth('30');
	                $excel->getActiveSheet()->getColumnDimensionByColumn('A2:C2')->setWidth('50');
	                $excel->getActiveSheet()->getColumnDimensionByColumn('A3')->setWidth('30');
	                $excel->getActiveSheet()->getColumnDimensionByColumn('A4')->setWidth('40');

	                //name the worksheet
	                $excel->getActiveSheet()->setTitle("Aging of Receivables Report");
	                $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->mergeCells('A1:B1');
	                $excel->getActiveSheet()->mergeCells('A2:C2');
	                $excel->getActiveSheet()->mergeCells('A3:B3');
	                $excel->getActiveSheet()->mergeCells('A4:B4');
	                $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
	                                        ->setCellValue('A2',$company_info[0]->company_address)
	                                        ->setCellValue('A3',$company_info[0]->landline.'/'.$company_info[0]->mobile_no)
	                                        ->setCellValue('A4',$company_info[0]->email_address);

	                $excel->getActiveSheet()->getColumnDimensionByColumn('A6:C6')->setWidth('50');	                                        
	                $excel->getActiveSheet()->mergeCells('A6:C6');
                	$excel->getActiveSheet()->setCellValue('A6',$customer_info->customer_name.'`S '.'STATEMENT OF ACCOUNT')
                                        	->getStyle('A6')->getFont()->setBold(TRUE)
                                        	->setSize(14);
	                
	                $excel->getActiveSheet()->mergeCells('A8:B8');					
                	$excel->getActiveSheet()->setCellValue('A8','Customer Name: '.$customer_info->customer_name)
                                        	->getStyle('A8')->getFont()->setBold(TRUE);

	                $excel->getActiveSheet()->mergeCells('D8:E8');                                        	
                	$excel->getActiveSheet()->setCellValue('D8','Date: '.date('Y-m-d'))
                                        	->getStyle('D8')->getFont()->setBold(TRUE);

                	$excel->getActiveSheet()->setCellValue('A9','Address: '.$customer_info->address)
                                        	->getStyle('A9')->getFont()->setBold(TRUE);

	                $excel->getActiveSheet()->mergeCells('D9:F9');
                	$excel->getActiveSheet()->setCellValue('D9','Contact Person: '.$customer_info->contact_name)
                                        	->getStyle('D9')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()
	                        ->getStyle('A10')
	                        ->getAlignment()
	                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

					$sumPrev = 0; $sumPrevSales=0; $sumPrevService=0; $sumCur = 0; $sumPayment = 0; $totalBalance = 0; $total = 0;  $sumCurSales=0;
							$sumCurService=0; $sumPaymentSales=0 ; $sumPaymentService=0; 

	                $excel->getActiveSheet()->mergeCells('A10:E10');
                	$excel->getActiveSheet()->setCellValue('A10','PREVIOUS BALANCES')
                                        	->getStyle('A10')->getFont()->setBold(TRUE);

	                $excel->getActiveSheet()->getColumnDimension('A')->setWidth('40');
	                $excel->getActiveSheet()->getColumnDimension('B')->setWidth('25');
	                $excel->getActiveSheet()->getColumnDimension('C')->setWidth('25');
	                $excel->getActiveSheet()->getColumnDimension('D')->setWidth('25');
	                $excel->getActiveSheet()->getColumnDimension('E')->setWidth('30');

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

	                $excel->getActiveSheet()->setCellValue('A11','Invoice #')
	                                        ->getStyle('A11')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->setCellValue('B11','Date')
	                                        ->getStyle('B11')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->setCellValue('C11','Amount')
	                                        ->getStyle('C11')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->setCellValue('D11','Balance Amount')
	                                        ->getStyle('D11')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->setCellValue('E11','Total')
	                                        ->getStyle('E11')->getFont()->setBold(TRUE);

	                $excel->getActiveSheet()->mergeCells('A12:E12');
                	$excel->getActiveSheet()->setCellValue('A12','SALES INVOICE');


                    $i=13;

                    foreach($previous_balances as $previous_balance) {
						if($previous_balance->is_sales == 1) { 
			                $excel->getActiveSheet()->setCellValue('A'.$i,$previous_balance->invoice_no);
			                $excel->getActiveSheet()->setCellValue('B'.$i,$previous_balance->date_txn);
                    		$excel->getActiveSheet()->getStyle('C'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');		            
			                $excel->getActiveSheet()->setCellValue('C'.$i,number_format($previous_balance->receivable_amount,2));
		                    $excel->getActiveSheet()->getStyle('D'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');		            	                
			                $excel->getActiveSheet()->setCellValue('D'.$i,number_format($previous_balance->balance,2));

							$i++;
							$sumPrevSales += $previous_balance->receivable_amount;
						}
                    }

			                $excel->getActiveSheet()->mergeCells('A'.$i.':'.'E'.$i);
		                	$excel->getActiveSheet()->setCellValue('A'.$i,'SERVICE INVOICE');					                    
					foreach($previous_balances as $previous_balance) {
						if($previous_balance->is_sales == 0) {
			                $excel->getActiveSheet()->setCellValue('A'.$i,$previous_balance->invoice_no);
			                $excel->getActiveSheet()->setCellValue('B'.$i,$previous_balance->date_txn);
                    		$excel->getActiveSheet()->getStyle('C'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');		            
			                $excel->getActiveSheet()->setCellValue('C'.$i,number_format($previous_balance->receivable_amount,2));
		                    $excel->getActiveSheet()->getStyle('D'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');		            	                
			                $excel->getActiveSheet()->setCellValue('D'.$i,number_format($previous_balance->balance,2));

			                $i++;
			                $sumPrevService += $previous_balance->receivable_amount;
						}
					}
							$i++;
			                $excel->getActiveSheet()
			                        ->getStyle('A'.$i,':','D'.$i)
			                        ->getAlignment()
			                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

							$excel->getActiveSheet()->mergeCells('A'.$i.':'.'D'.$i);
		                	$excel->getActiveSheet()->setCellValue('A'.$i,'SUB-TOTAL:')					                    
	                                        		->getStyle('A'.$i)->getFont()->setBold(TRUE);
	                        $sumPrev = $sumPrevSales + $sumPrevService;              

		                    $excel->getActiveSheet()->getStyle('E'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');		            	                	
			                $excel->getActiveSheet()->setCellValue('E'.$i,number_format($sumPrev,2));

			                $i++;

			                $excel->getActiveSheet()
			                        ->getStyle('A'.$i)
			                        ->getAlignment()
			                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
			                        	                
			                $excel->getActiveSheet()->mergeCells('A'.$i.':'.'E'.$i);
		                	$excel->getActiveSheet()->setCellValue('A'.$i,'CURRENT BALANCES')
		                                        	->getStyle('A'.$i)->getFont()->setBold(TRUE);			                

			                $excel->getActiveSheet()
			                        ->getStyle('C'.$i)
			                        ->getAlignment()
			                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			                $excel->getActiveSheet()
			                        ->getStyle('D'.$i)
			                        ->getAlignment()
			                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			                $excel->getActiveSheet()
			                        ->getStyle('E'.$i)
			                        ->getAlignment()
			                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);	

			                $i++;
			                $excel->getActiveSheet()->setCellValue('A'.$i,'Invoice #')
			                                        ->getStyle('A'.$i)->getFont()->setBold(TRUE);
			                $excel->getActiveSheet()->setCellValue('B'.$i,'Date')
			                                        ->getStyle('B'.$i)->getFont()->setBold(TRUE);
			                $excel->getActiveSheet()->setCellValue('C'.$i,'Amount')
			                                        ->getStyle('C'.$i)->getFont()->setBold(TRUE);
			                $excel->getActiveSheet()->setCellValue('D'.$i,'Balance Amount')
			                                        ->getStyle('D'.$i)->getFont()->setBold(TRUE);
			                $excel->getActiveSheet()->setCellValue('E'.$i,'Total')
			                                        ->getStyle('E'.$i)->getFont()->setBold(TRUE);

			                $i++;
			                $excel->getActiveSheet()->mergeCells('A'.$i.':'.'E'.$i);
		                	$excel->getActiveSheet()->setCellValue('A'.$i,'SALES INVOICE');

		                	$i++;
                	foreach($current_balances as $current_balance) {
						if($current_balance->is_sales == 1) {
			                $excel->getActiveSheet()->setCellValue('A'.$i,$current_balance->invoice_no);
			                $excel->getActiveSheet()->setCellValue('B'.$i,$current_balance->date_txn);
                    		$excel->getActiveSheet()->getStyle('C'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');		            
			                $excel->getActiveSheet()->setCellValue('C'.$i,number_format($current_balance->receivable_amount,2));
		                    $excel->getActiveSheet()->getStyle('D'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');		            	                
			                $excel->getActiveSheet()->setCellValue('D'.$i,number_format($current_balance->balance,2));
			                
			                $i++;
							$sumCurSales += $current_balance->receivable_amount;
						}
                	}
			                $excel->getActiveSheet()->mergeCells('A'.$i.':'.'E'.$i);
		                	$excel->getActiveSheet()->setCellValue('A'.$i,'SERVICE INVOICE');

		                	$i++;
		            foreach($current_balances as $current_balance) {
		            	if($current_balance->is_sales == 0) {
			                $excel->getActiveSheet()->setCellValue('A'.$i,$current_balance->invoice_no);
			                $excel->getActiveSheet()->setCellValue('B'.$i,$current_balance->date_txn);
                    		$excel->getActiveSheet()->getStyle('C'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');		            
			                $excel->getActiveSheet()->setCellValue('C'.$i,number_format($current_balance->receivable_amount,2));
		                    $excel->getActiveSheet()->getStyle('D'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');		            	                
			                $excel->getActiveSheet()->setCellValue('D'.$i,number_format($current_balance->balance,2));

			                $i++;
			                $sumCurService += $current_balance->receivable_amount;
		            	}
		            }
							$i++;
			                $excel->getActiveSheet()
			                        ->getStyle('A'.$i,':','D'.$i)
			                        ->getAlignment()
			                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

							$excel->getActiveSheet()->mergeCells('A'.$i.':'.'D'.$i);
		                	$excel->getActiveSheet()->setCellValue('A'.$i,'SUB-TOTAL:')					                    
	                                        		->getStyle('A'.$i)->getFont()->setBold(TRUE);
	                        $sumCur = $sumCurService + $sumCurSales;              

		                    $excel->getActiveSheet()->getStyle('E'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');		            	                	
			                $excel->getActiveSheet()->setCellValue('E'.$i,number_format($sumCur,2));

			                $i++;
			                $excel->getActiveSheet()
			                        ->getStyle('A'.$i)
			                        ->getAlignment()
			                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
			                        	                
			                $excel->getActiveSheet()->mergeCells('A'.$i.':'.'E'.$i);
		                	$excel->getActiveSheet()->setCellValue('A'.$i,'PAYMENTS')
		                                        	->getStyle('A'.$i)->getFont()->setBold(TRUE);			                

			                $excel->getActiveSheet()
			                        ->getStyle('C'.$i)
			                        ->getAlignment()
			                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

			                $i++;
			                $excel->getActiveSheet()->setCellValue('A'.$i,'Receipt #')
			                                        ->getStyle('A'.$i)->getFont()->setBold(TRUE);
			                $excel->getActiveSheet()->setCellValue('B'.$i,'Date')
			                                        ->getStyle('B'.$i)->getFont()->setBold(TRUE);
			                $excel->getActiveSheet()->setCellValue('C'.$i,'Payment Amount')
			                                        ->getStyle('C'.$i)->getFont()->setBold(TRUE);
			                $excel->getActiveSheet()->mergeCells('D'.$i.':'.'E'.$i);


			                $i++;
			                $excel->getActiveSheet()->mergeCells('A'.$i.':'.'E'.$i);
		                	$excel->getActiveSheet()->setCellValue('A'.$i,'SALES');

		                	$i++;

					foreach($payments as $payment) { 
						if($payment->is_sales == 1) {
			                $excel->getActiveSheet()->setCellValue('A'.$i,$payment->receipt_no_desc);
			                $excel->getActiveSheet()->setCellValue('B'.$i,$payment->date_paid);
                    		$excel->getActiveSheet()->getStyle('C'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');		            
			                $excel->getActiveSheet()->setCellValue('C'.$i,number_format($payment->payment_amount,2));
			                $i++;
			                $sumPaymentSales += $payment->payment_amount;
						}
					}
			                $excel->getActiveSheet()->mergeCells('A'.$i.':'.'E'.$i);
		                	$excel->getActiveSheet()->setCellValue('A'.$i,'SERVICE');

		              		$i++;
		            foreach($payments as $payment) {
						if($payment->is_sales == 0) { 
			                $excel->getActiveSheet()->setCellValue('A'.$i,$payment->receipt_no_desc);
			                $excel->getActiveSheet()->setCellValue('B'.$i,$payment->date_paid);
                    		$excel->getActiveSheet()->getStyle('C'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');		            
			                $excel->getActiveSheet()->setCellValue('C'.$i,number_format($payment->payment_amount,2));
			                $i++;
			                $sumPaymentService += $payment->payment_amount;
						}
		            }	

				           	$sumPayment = $sumPaymentService + $sumPaymentSales;
				           	$total = $sumPrev + $sumCur; 
							$totalBalance = $total - $sumPayment;

			                $excel->getActiveSheet()
			                        ->getStyle('A'.$i,':','D'.$i)
			                        ->getAlignment()
			                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

							$excel->getActiveSheet()->mergeCells('A'.$i.':'.'D'.$i);
		                	$excel->getActiveSheet()->setCellValue('A'.$i,'TOTAL:')					                    
	                                        		->getStyle('A'.$i)->getFont()->setBold(TRUE);

		                    $excel->getActiveSheet()->getStyle('E'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');		            	                	
			                $excel->getActiveSheet()->setCellValue('E'.$i,number_format($total,2));

			                $i++;

			                $excel->getActiveSheet()
			                        ->getStyle('A'.$i,':','D'.$i)
			                        ->getAlignment()
			                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

							$excel->getActiveSheet()->mergeCells('A'.$i.':'.'D'.$i);
		                	$excel->getActiveSheet()->setCellValue('A'.$i,'LESS PAYMENT:')					                    
	                                        		->getStyle('A'.$i)->getFont()->setBold(TRUE);

		                    $excel->getActiveSheet()->getStyle('E'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');		            	                	
			                $excel->getActiveSheet()->setCellValue('E'.$i,number_format($sumPayment,2));

			               	$i++;

			                $excel->getActiveSheet()
			                        ->getStyle('A'.$i,':','D'.$i)
			                        ->getAlignment()
			                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

							$excel->getActiveSheet()->mergeCells('A'.$i.':'.'D'.$i);
		                	$excel->getActiveSheet()->setCellValue('A'.$i,'BALANCE:')					                    
	                                        		->getStyle('A'.$i)->getFont()->setBold(TRUE);

		                    $excel->getActiveSheet()->getStyle('E'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');		            	                	
			                $excel->getActiveSheet()->setCellValue('E'.$i,number_format($totalBalance,2));
							
							$i++;

							$BStyle = array(
							  'borders' => array(
							    'bottom' => array(
							      'style' => PHPExcel_Style_Border::BORDER_THIN
							    )
							  )
							);

			                $i++;

	                		$excel->getActiveSheet()->getColumnDimensionByColumn('A'.$i.':'.'B'.$i)->setWidth('30');
	                		$excel->getActiveSheet()->getColumnDimensionByColumn('D'.$i.':'.'E'.$i)->setWidth('30');

			                $excel->getActiveSheet()->mergeCells('A'.$i.':'.'B'.$i);
							$excel->getActiveSheet()->getStyle('A'.$i.':'.'B'.$i)->applyFromArray($BStyle);

			                $excel->getActiveSheet()->mergeCells('D'.$i.':'.'E'.$i);
							$excel->getActiveSheet()->getStyle('D'.$i.':'.'E'.$i)->applyFromArray($BStyle);			


			                $i++;
			                $excel->getActiveSheet()
			                        ->getStyle('A'.$i,':','B'.$i)
			                        ->getAlignment()
			                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			                $excel->getActiveSheet()
			                        ->getStyle('D'.$i,':','E'.$i)
			                        ->getAlignment()
			                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			                $excel->getActiveSheet()->mergeCells('A'.$i.':'.'B'.$i);
							$excel->getActiveSheet()->setCellValue('A'.$i,'Prepared By')	
	                                        		->getStyle('A'.$i)->getFont()->setBold(TRUE);																	                    
			                $excel->getActiveSheet()->mergeCells('D'.$i.':'.'E'.$i);
							$excel->getActiveSheet()->setCellValue('D'.$i,'Received By')		
	                                        		->getStyle('D'.$i)->getFont()->setBold(TRUE);

	                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	                header('Content-Disposition: attachment;filename='."Statement of Account.xlsx".'');
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

                            $file_name='STATEMENT OF ACCOUNT REPORT '.date('Y-m-d h:i:A', now());
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
                            $subject = 'STATEMENT OF ACCOUNT';
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
