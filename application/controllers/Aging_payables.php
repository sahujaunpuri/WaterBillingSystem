<?php
    defined('BASEPATH') OR exit('No direct script access allowed.');

    class Aging_payables extends CORE_Controller
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
            $data['title'] = "Aging of Payables";

            $this->load->view('aging_payables_view',$data);
        }

        function transaction($txn)
        {
            switch ($txn) {
                case 'list':
                    $m_delivery = $this->Delivery_invoice_model;

                    $response['data'] = $m_delivery->get_aging_payables();

                    echo json_encode($response);
                    break;  

                case 'print':


                    $m_delivery = $this->Delivery_invoice_model;
                    $m_company = $this->Company_model;

                    $company_info = $m_company->get_list();

                    $data['company_info'] = $company_info[0];
                    $data['payables'] = $m_delivery->get_aging_payables();
                    $file_name='Aging of Payables';
                    
                    $pdfFilePath = $file_name.".pdf"; //generate filename base on id
                    $pdf = $this->m_pdf->load("A4-L"); //pass the instance of the mpdf class
                    $content=$this->load->view('template/aging_payables_report',$data,TRUE); //load the template
                    $pdf->setFooter('{PAGENO}');
                    $pdf->WriteHTML($content);
                    //download it.
                    $pdf->Output();
                    #$this->load->view('template/aging_payables_report',$data);
                    break;
                
                default:
                    # code...
                    break;

                case 'export':

                    $excel=$this->excel;
                    $m_delivery = $this->Delivery_invoice_model;
                    $m_company = $this->Company_model;

                    $company_info = $m_company->get_list();

                    $data['company_info'] = $company_info[0];
                    $payables = $m_delivery->get_aging_payables();
                    $file_name='Aging of Payables';

                    $excel->setActiveSheetIndex(0);

                    $excel->getActiveSheet()->getColumnDimensionByColumn('A1:B1')->setWidth('30');
                    $excel->getActiveSheet()->getColumnDimensionByColumn('A2:B2')->setWidth('50');
                    $excel->getActiveSheet()->getColumnDimensionByColumn('A3')->setWidth('30');

                    //name the worksheet
                    $excel->getActiveSheet()->setTitle("Aging of Payables Report");
                    $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->mergeCells('A1:B1');
                    $excel->getActiveSheet()->mergeCells('A2:B2');
                    $excel->getActiveSheet()->mergeCells('A3:B3');
                    $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
                                            ->setCellValue('A2',$company_info[0]->company_address)
                                            ->setCellValue('A3',$company_info[0]->landline.'/'.$company_info[0]->mobile_no);  

                    $excel->getActiveSheet()->getColumnDimensionByColumn('A5:B5')->setWidth('40');                                          
                    $excel->getActiveSheet()->mergeCells('A5:B5');
                    $excel->getActiveSheet()->setCellValue('A5','AGING OF PAYABLES REPORT')
                                            ->getStyle('A5')->getFont()->setBold(TRUE)
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

                    $excel->getActiveSheet()->setCellValue('A7','Supplier Name')
                                            ->getStyle('A7')->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->setCellValue('B7','Current')
                                            ->getStyle('B7')->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->setCellValue('C7','30 Days')
                                            ->getStyle('C7')->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->setCellValue('D7','45 Days')
                                            ->getStyle('D7')->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->setCellValue('E7','60 Days')
                                            ->getStyle('E7')->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->setCellValue('F7','Over 90 Days')
                                            ->getStyle('F7')->getFont()->setBold(TRUE);

                    $i=8;
                    $sum_current = 0; $sum_thirty = 0; $sum_fortyfive = 0; $sum_sixty = 0; $sum_ninety = 0;    
                    
                    foreach($payables as $payable) {
                        $sum_current += $payable->current; 
                        $sum_thirty += $payable->thirty_days;
                        $sum_fortyfive += $payable->fortyfive_days;
                        $sum_sixty += $payable->sixty_days;
                        $sum_ninety += $payable->over_ninetydays;

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

                        $excel->getActiveSheet()->setCellValue('A'.$i,$payable->supplier_name);
                        $excel->getActiveSheet()->getStyle('B'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');                    
                        $excel->getActiveSheet()->setCellValue('B'.$i,(number_format($payable->current,2) == 0 ? '' : number_format($payable->current,2)));
                        $excel->getActiveSheet()->getStyle('C'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');                        
                        $excel->getActiveSheet()->setCellValue('C'.$i,(number_format($payable->thirty_days,2) == 0 ? '' : number_format($payable->thirty_days,2)));
                        $excel->getActiveSheet()->getStyle('D'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');                        
                        $excel->getActiveSheet()->setCellValue('D'.$i,(number_format($payable->fortyfive_days,2) == 0 ? '' : number_format($payable->fortyfive_days,2)));
                        $excel->getActiveSheet()->getStyle('E'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');                        
                        $excel->getActiveSheet()->setCellValue('E'.$i,(number_format($payable->sixty_days,2) == 0 ? '' : number_format($payable->sixty_days,2)));
                        $excel->getActiveSheet()->getStyle('F'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');                        
                        $excel->getActiveSheet()->setCellValue('F'.$i,(number_format($payable->over_ninetydays,2) == 0 ? '' : number_format($payable->over_ninetydays,2)));
                        
                        $i++;
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

                    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                    header('Content-Disposition: attachment;filename='."Aging of Payables Report.xlsx".'');
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
                    $m_delivery = $this->Delivery_invoice_model;
                    $m_company = $this->Company_model;

                    $company_info = $m_company->get_list();

                    $data['company_info'] = $company_info[0];
                    $payables = $m_delivery->get_aging_payables();
                    $file_name='Aging of Payables';

                    ob_start();
                    $excel->setActiveSheetIndex(0);

                    $excel->getActiveSheet()->getColumnDimensionByColumn('A1:B1')->setWidth('30');
                    $excel->getActiveSheet()->getColumnDimensionByColumn('A2:B2')->setWidth('50');
                    $excel->getActiveSheet()->getColumnDimensionByColumn('A3')->setWidth('30');

                    //name the worksheet
                    $excel->getActiveSheet()->setTitle("Aging of Payables Report");
                    $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->mergeCells('A1:B1');
                    $excel->getActiveSheet()->mergeCells('A2:B2');
                    $excel->getActiveSheet()->mergeCells('A3:B3');
                    $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
                                            ->setCellValue('A2',$company_info[0]->company_address)
                                            ->setCellValue('A3',$company_info[0]->landline.'/'.$company_info[0]->mobile_no);  

                    $excel->getActiveSheet()->getColumnDimensionByColumn('A5:B5')->setWidth('40');                                          
                    $excel->getActiveSheet()->mergeCells('A5:B5');
                    $excel->getActiveSheet()->setCellValue('A5','AGING OF PAYABLES REPORT')
                                            ->getStyle('A5')->getFont()->setBold(TRUE)
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

                    $excel->getActiveSheet()->setCellValue('A7','Supplier Name')
                                            ->getStyle('A7')->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->setCellValue('B7','Current')
                                            ->getStyle('B7')->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->setCellValue('C7','30 Days')
                                            ->getStyle('C7')->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->setCellValue('D7','45 Days')
                                            ->getStyle('D7')->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->setCellValue('E7','60 Days')
                                            ->getStyle('E7')->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->setCellValue('F7','Over 90 Days')
                                            ->getStyle('F7')->getFont()->setBold(TRUE);

                    $i=8;
                    $sum_current = 0; $sum_thirty = 0; $sum_fortyfive = 0; $sum_sixty = 0; $sum_ninety = 0;    
                    
                    foreach($payables as $payable) {
                        $sum_current += $payable->current; 
                        $sum_thirty += $payable->thirty_days;
                        $sum_fortyfive += $payable->fortyfive_days;
                        $sum_sixty += $payable->sixty_days;
                        $sum_ninety += $payable->over_ninetydays;

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

                        $excel->getActiveSheet()->setCellValue('A'.$i,$payable->supplier_name);
                        $excel->getActiveSheet()->getStyle('B'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');                    
                        $excel->getActiveSheet()->setCellValue('B'.$i,(number_format($payable->current,2) == 0 ? '' : number_format($payable->current,2)));
                        $excel->getActiveSheet()->getStyle('C'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');                        
                        $excel->getActiveSheet()->setCellValue('C'.$i,(number_format($payable->thirty_days,2) == 0 ? '' : number_format($payable->thirty_days,2)));
                        $excel->getActiveSheet()->getStyle('D'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');                        
                        $excel->getActiveSheet()->setCellValue('D'.$i,(number_format($payable->fortyfive_days,2) == 0 ? '' : number_format($payable->fortyfive_days,2)));
                        $excel->getActiveSheet()->getStyle('E'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');                        
                        $excel->getActiveSheet()->setCellValue('E'.$i,(number_format($payable->sixty_days,2) == 0 ? '' : number_format($payable->sixty_days,2)));
                        $excel->getActiveSheet()->getStyle('F'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');                        
                        $excel->getActiveSheet()->setCellValue('F'.$i,(number_format($payable->over_ninetydays,2) == 0 ? '' : number_format($payable->over_ninetydays,2)));
                        
                        $i++;
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
                        
                    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                    header('Content-Disposition: attachment;filename='."Aging of Payables Report.xlsx".'');
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

                            $file_name='Aging of Payables Report '.date('Y-m-d h:i:A', now());
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
                            $subject = 'Aging of Payables';
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