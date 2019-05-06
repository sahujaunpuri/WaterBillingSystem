<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Vat_relief_report extends CORE_Controller
	{
		function __construct()
		{
			parent::__construct();
			$this->validate_session();
			$this->load->model(
				array(
					'Delivery_invoice_model',
					'Users_model',
					'Company_model'
				)
			);
			$this->load->library('excel');
            $this->load->model('Email_settings_model');

		}


		public function index()
		{	$this->Users_model->validate();
			$data['_def_css_files'] = $this->load->view('template/assets/css_files', '', TRUE);
	        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', TRUE);
	        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', TRUE);
	        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', TRUE);
	        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', TRUE);
	        $data['title'] = 'VAT Relief Report';
        (in_array('6-11',$this->session->user_rights)? 
        $this->load->view('vat_relief_report_view',$data)
        :redirect(base_url('dashboard')));
	        
		}

		function transaction($txn=null, $id_filter=null) {
			switch($txn) {
				case 'list':
					$m_delivery_inv=$this->Delivery_invoice_model;

					$startDate=date("Y-m-d",strtotime($this->input->get('start',TRUE)));
					$endDate=date("Y-m-d",strtotime($this->input->get('end',TRUE)));

					$response['data']=$m_delivery_inv->get_vat_relief($startDate,$endDate);

					echo json_encode($response);
				break;

				case 'report':
					$m_delivery_inv=$this->Delivery_invoice_model;
					$m_company=$this->Company_model;

					$startDate=date("Y-m-d",strtotime($this->input->get('start',TRUE)));
					$endDate=date("Y-m-d",strtotime($this->input->get('end',TRUE)));

					$company_info=$m_company->get_list();
					$data['company_info']=$company_info[0];
					$data['suppliers']=$m_delivery_inv->get_vat_relief_supplier_list($startDate,$endDate);
					$data['vat_reliefs']=$m_delivery_inv->get_vat_relief($startDate,$endDate);

					$this->load->view('template/vat_relief_report_content',$data);
				break;

				case 'export-vat-relief':
                $excel=$this->excel;

				$m_delivery_inv=$this->Delivery_invoice_model;
				$startDate=date("Y-m-d",strtotime($this->input->get('start',TRUE)));
				$endDate=date("Y-m-d}",strtotime($this->input->get('end',TRUE)));

				$data['suppliers']=$m_delivery_inv->get_vat_relief_supplier_list($startDate,$endDate);
				$m_company=$this->Company_model;
				$company_info=$m_company->get_list();
				$data['company_info']=$company_info[0];


				$startDate=date("Y-m-d",strtotime($this->input->get('start',TRUE)));
				$endDate=date("Y-m-d}",strtotime($this->input->get('end',TRUE)));

				$suppliers=$m_delivery_inv->get_vat_relief_supplier_list($startDate,$endDate);
				$vat_reliefs=$m_delivery_inv->get_vat_relief($startDate,$endDate);

                $excel->setActiveSheetIndex(0);
                $excel->getActiveSheet()->getColumnDimensionByColumn('A1')->setWidth('50');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A2:B2')->setWidth('50');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A3')->setWidth('50');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A4')->setWidth('50');

                //name the worksheet
                $excel->getActiveSheet()->setTitle("Vat Relief Report");
                $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
                						->setCellValue('A2',$company_info[0]->company_address)
                						->setCellValue('A3',$company_info[0]->email_address)
                						->setCellValue('A4',$company_info[0]->mobile_no);




                $i = 7;						
                
                foreach ($suppliers as $supplier){
                $excel->getActiveSheet()->setCellValue('A'.$i,'Supplier'.':'.$supplier->supplier_name);
                $excel->getActiveSheet()->setCellValue('C'.$i,'TIN #'.':'.$supplier->tin_no);
               	$excel->getActiveSheet()->mergeCells('A'.$i.':B'.$i);
               	$excel->getActiveSheet()->mergeCells('C'.$i.':D'.$i);
                $excel->getActiveSheet()->getColumnDimension('A')->setWidth('40');
                $excel->getActiveSheet()->getColumnDimension('B')->setWidth('30');
                $excel->getActiveSheet()->getColumnDimension('C')->setWidth('50');
                $excel->getActiveSheet()->getColumnDimension('D')->setWidth('50');
                $excel->getActiveSheet()->getColumnDimension('E')->setWidth('50');
                $excel->getActiveSheet()->getColumnDimension('F')->setWidth('50');
                $excel->getActiveSheet()->getColumnDimension('G')->setWidth('50');


               	$sum_invoice_amt=0; 
	    		$sum_vatable_amount=0; //from gross
	    		$sum_net_vat=0; //from gross

                $sum_of_vat=0; 
                $sum_of_net_vat=0; 

	    		$i++;
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
                $excel->getActiveSheet()
                        ->getStyle('F'.$i)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);                
                $excel->getActiveSheet()
                        ->getStyle('G'.$i)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);


	    		 $excel->getActiveSheet()->setCellValue('A'.$i,'Invoice / OR #');
	    		 $excel->getActiveSheet()->getStyle('A'.$i)->getFont()->setBold(TRUE);
                 $excel->getActiveSheet()->setCellValue('B'.$i,'Reference #');
                 $excel->getActiveSheet()->getStyle('B'.$i)->getFont()->setBold(TRUE);
	    		 $excel->getActiveSheet()->setCellValue('C'.$i,'Gross');
                 $excel->getActiveSheet()->getStyle('C'.$i)->getFont()->setBold(TRUE);
	    		 $excel->getActiveSheet()->setCellValue('D'.$i,'Non Vatable');
                 $excel->getActiveSheet()->getStyle('D'.$i)->getFont()->setBold(TRUE);
	    		 $excel->getActiveSheet()->setCellValue('E'.$i,'Vatable');
                 $excel->getActiveSheet()->getStyle('E'.$i)->getFont()->setBold(TRUE);
                 $excel->getActiveSheet()->setCellValue('F'.$i,'VAT Input');
                 $excel->getActiveSheet()->getStyle('F'.$i)->getFont()->setBold(TRUE);
                 $excel->getActiveSheet()->setCellValue('G'.$i,'Net of VAT');
                 $excel->getActiveSheet()->getStyle('G'.$i)->getFont()->setBold(TRUE);


	    		 $i++;
                	foreach ($vat_reliefs as $vat_relief) {
                		if ($supplier->supplier_id == $vat_relief->supplier_id) {
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
                $excel->getActiveSheet()
                        ->getStyle('F'.$i)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $excel->getActiveSheet()
                        ->getStyle('G'.$i)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $excel->getActiveSheet()
                        ->getStyle('B'.$i)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $excel->getActiveSheet()->setCellValue('A'.$i,$vat_relief->dr_invoice_no);
                $excel->getActiveSheet()->getStyle('A'.$i)->getFont()->setBold(FALSE);
                $excel->getActiveSheet()->setCellValue('B'.$i,$vat_relief->external_ref_no);
                $excel->getActiveSheet()->getStyle('C'.$i.':E'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                $excel->getActiveSheet()->setCellValue('C'.$i,number_format($vat_relief->total_after_tax,2));
                $excel->getActiveSheet()->setCellValue('D'.$i,number_format($vat_relief->invoice_non_vat,2));
                $excel->getActiveSheet()->setCellValue('E'.$i,number_format($vat_relief->dr_taxable,2));
                $excel->getActiveSheet()->setCellValue('F'.$i,number_format($vat_relief->total_tax_amount,2));
                $excel->getActiveSheet()->setCellValue('G'.$i,number_format($vat_relief->net_of_vat,2));

                $i++;
    				$sum_invoice_amt += $vat_relief->total_after_tax; 
    				$sum_vatable_amount += $vat_relief->dr_taxable;
                    $sum_net_vat += $vat_relief->invoice_non_vat;
                    $sum_of_vat += $vat_relief->total_tax_amount;
    				$sum_of_net_vat += $vat_relief->net_of_vat;
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
                $excel->getActiveSheet()
                        ->getStyle('F'.$i)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $excel->getActiveSheet()
                        ->getStyle('G'.$i)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	    		$excel->getActiveSheet()->setCellValue('A'.$i,'TOTAL:');
	    		$excel->getActiveSheet()->getStyle('A'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('C'.$i,number_format($sum_invoice_amt,2));
                $excel->getActiveSheet()->setCellValue('D'.$i,number_format($sum_net_vat,2));
                $excel->getActiveSheet()->setCellValue('E'.$i,number_format($sum_vatable_amount,2));
                $excel->getActiveSheet()->setCellValue('F'.$i,number_format($sum_of_vat,2));
                $excel->getActiveSheet()->setCellValue('G'.$i,number_format($sum_of_net_vat,2));


                	}
                }
              	$i++;

            	}

                ob_end_clean();
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename='."Vat Relief.xlsx".'');
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

                case 'email-vat-relief':
                $excel=$this->excel;
                $m_email=$this->Email_settings_model;
                $email=$m_email->get_list(2);
                $m_delivery_inv=$this->Delivery_invoice_model;
                $startDate=date("Y-m-d",strtotime($this->input->get('start',TRUE)));
                $endDate=date("Y-m-d}",strtotime($this->input->get('end',TRUE)));

                $data['suppliers']=$m_delivery_inv->get_vat_relief_supplier_list($startDate,$endDate);
                $m_company=$this->Company_model;
                $company_info=$m_company->get_list();
                $data['company_info']=$company_info[0];
                $filter_value = 2;


                $startDate=date("Y-m-d",strtotime($this->input->get('start',TRUE)));
                $endDate=date("Y-m-d}",strtotime($this->input->get('end',TRUE)));

                $suppliers=$m_delivery_inv->get_vat_relief_supplier_list($startDate,$endDate);
                $vat_reliefs=$m_delivery_inv->get_vat_relief($startDate,$endDate);

                ob_start();

               $excel->setActiveSheetIndex(0);
                $excel->getActiveSheet()->getColumnDimensionByColumn('A1')->setWidth('50');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A2:B2')->setWidth('50');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A3')->setWidth('50');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A4')->setWidth('50');

                //name the worksheet
                $excel->getActiveSheet()->setTitle("Vat Relief Report");
                $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
                                        ->setCellValue('A2',$company_info[0]->company_address)
                                        ->setCellValue('A3',$company_info[0]->email_address)
                                        ->setCellValue('A4',$company_info[0]->mobile_no);




                $i = 7;                     
                
                foreach ($suppliers as $supplier){
                $excel->getActiveSheet()->setCellValue('A'.$i,'Supplier'.':'.$supplier->supplier_name);
                $excel->getActiveSheet()->setCellValue('C'.$i,'TIN #'.':'.$supplier->tin_no);
                $excel->getActiveSheet()->mergeCells('A'.$i.':B'.$i);
                $excel->getActiveSheet()->mergeCells('C'.$i.':D'.$i);
                $excel->getActiveSheet()->getColumnDimension('A')->setWidth('40');
                $excel->getActiveSheet()->getColumnDimension('B')->setWidth('30');
                $excel->getActiveSheet()->getColumnDimension('C')->setWidth('50');
                $excel->getActiveSheet()->getColumnDimension('D')->setWidth('50');
                $excel->getActiveSheet()->getColumnDimension('E')->setWidth('50');
                $excel->getActiveSheet()->getColumnDimension('F')->setWidth('50');
                $excel->getActiveSheet()->getColumnDimension('G')->setWidth('50');


                $sum_invoice_amt=0; 
                $sum_vatable_amount=0; //from gross
                $sum_net_vat=0; //from gross

                $sum_of_vat=0; 
                $sum_of_net_vat=0; 

                $i++;
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
                $excel->getActiveSheet()
                        ->getStyle('F'.$i)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);                
                $excel->getActiveSheet()
                        ->getStyle('G'.$i)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);


                 $excel->getActiveSheet()->setCellValue('A'.$i,'Invoice / OR #');
                 $excel->getActiveSheet()->getStyle('A'.$i)->getFont()->setBold(TRUE);
                 $excel->getActiveSheet()->setCellValue('B'.$i,'Reference #');
                 $excel->getActiveSheet()->getStyle('B'.$i)->getFont()->setBold(TRUE);
                 $excel->getActiveSheet()->setCellValue('C'.$i,'Gross');
                 $excel->getActiveSheet()->getStyle('C'.$i)->getFont()->setBold(TRUE);
                 $excel->getActiveSheet()->setCellValue('D'.$i,'Non Vatable');
                 $excel->getActiveSheet()->getStyle('D'.$i)->getFont()->setBold(TRUE);
                 $excel->getActiveSheet()->setCellValue('E'.$i,'Vatable');
                 $excel->getActiveSheet()->getStyle('E'.$i)->getFont()->setBold(TRUE);
                 $excel->getActiveSheet()->setCellValue('F'.$i,'VAT Input');
                 $excel->getActiveSheet()->getStyle('F'.$i)->getFont()->setBold(TRUE);
                 $excel->getActiveSheet()->setCellValue('G'.$i,'Net of VAT');
                 $excel->getActiveSheet()->getStyle('G'.$i)->getFont()->setBold(TRUE);


                 $i++;
                    foreach ($vat_reliefs as $vat_relief) {
                        if ($supplier->supplier_id == $vat_relief->supplier_id) {
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
                $excel->getActiveSheet()
                        ->getStyle('F'.$i)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $excel->getActiveSheet()
                        ->getStyle('G'.$i)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $excel->getActiveSheet()
                        ->getStyle('B'.$i)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $excel->getActiveSheet()->setCellValue('A'.$i,$vat_relief->dr_invoice_no);
                $excel->getActiveSheet()->getStyle('A'.$i)->getFont()->setBold(FALSE);
                $excel->getActiveSheet()->setCellValue('B'.$i,$vat_relief->external_ref_no);
                $excel->getActiveSheet()->getStyle('C'.$i.':E'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                $excel->getActiveSheet()->setCellValue('C'.$i,number_format($vat_relief->total_after_tax,2));
                $excel->getActiveSheet()->setCellValue('D'.$i,number_format($vat_relief->invoice_non_vat,2));
                $excel->getActiveSheet()->setCellValue('E'.$i,number_format($vat_relief->dr_taxable,2));
                $excel->getActiveSheet()->setCellValue('F'.$i,number_format($vat_relief->total_tax_amount,2));
                $excel->getActiveSheet()->setCellValue('G'.$i,number_format($vat_relief->net_of_vat,2));

                $i++;
                    $sum_invoice_amt += $vat_relief->total_after_tax; 
                    $sum_vatable_amount += $vat_relief->dr_taxable;
                    $sum_net_vat += $vat_relief->invoice_non_vat;
                    $sum_of_vat += $vat_relief->total_tax_amount;
                    $sum_of_net_vat += $vat_relief->net_of_vat;
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
                $excel->getActiveSheet()
                        ->getStyle('F'.$i)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $excel->getActiveSheet()
                        ->getStyle('G'.$i)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $excel->getActiveSheet()->setCellValue('A'.$i,'TOTAL:');
                $excel->getActiveSheet()->getStyle('A'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('C'.$i,number_format($sum_invoice_amt,2));
                $excel->getActiveSheet()->setCellValue('D'.$i,number_format($sum_net_vat,2));
                $excel->getActiveSheet()->setCellValue('E'.$i,number_format($sum_vatable_amount,2));
                $excel->getActiveSheet()->setCellValue('F'.$i,number_format($sum_of_vat,2));
                $excel->getActiveSheet()->setCellValue('G'.$i,number_format($sum_of_net_vat,2));


                    }
                }
                $i++;

                }

                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename='."Vat Relief.xlsx".'');
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
                $data =  ob_get_clean();


                            $file_name='Vat Relief Report '.date('Y-m-d h:i:A', now());
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
                            $subject = 'Vat Relief Report';
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
                            $response['msg']='Please check the Email Address  or your Internet Connection.';

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