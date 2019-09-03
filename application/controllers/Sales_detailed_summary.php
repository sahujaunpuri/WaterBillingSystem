<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sales_detailed_summary extends CORE_Controller {

    function __construct() {
        parent::__construct('');
        $this->validate_session();
        $this->load->model(array(
            'Sales_invoice_model',
            'Company_model',
            'Users_model',
            'Customers_model'
        ));
        $this->load->library('excel');
        $this->load->model('Email_settings_model');

    }

    public function index() {
        $this->Users_model->validate();
        $data['_def_css_files']=$this->load->view('template/assets/css_files','',TRUE);
        $data['_def_js_files']=$this->load->view('template/assets/js_files','',TRUE);
        $data['_switcher_settings']=$this->load->view('template/elements/switcher','',TRUE);
        $data['_side_bar_navigation']=$this->load->view('template/elements/side_bar_navigation','',TRUE);
        $data['_top_navigation']=$this->load->view('template/elements/top_navigation','',TRUE);

        $data['customers']=$this->Customers_model->get_customer_list_for_sales_report();

        $data['title']='Sales Report';
        

        (in_array('8-1',$this->session->user_rights)? 
        $this->load->view('sales_detailed_summary_view',$data)
        :redirect(base_url('dashboard')));
    }


    function transaction($txn=null){
        switch($txn){
            case 'per-sales-detailed':
                $m_sales_invoice=$this->Sales_invoice_model;
                $start=date("Y-m-d",strtotime($this->input->get('startDate',TRUE)));
                $end=date("Y-m-d",strtotime($this->input->get('endDate',TRUE)));

                $response['data']=$m_sales_invoice->get_sales_detailed_list($start,$end);

                echo(
                json_encode($response)
                );
            break;

            case 'per-sales-summary':
                $m_sales_invoice=$this->Sales_invoice_model;
                $start=date("Y-m-d",strtotime($this->input->get('startDate',TRUE)));
                $end=date("Y-m-d",strtotime($this->input->get('endDate',TRUE)));

                $response['data']=$m_sales_invoice->get_sales_summary_list($start,$end);

                echo(
                json_encode($response)
                );
            break;

            case 'per-sales-summary-salesperson':
                $m_sales_invoice=$this->Sales_invoice_model;
                $start=date("Y-m-d",strtotime($this->input->get('startDate',TRUE)));
                $end=date("Y-m-d",strtotime($this->input->get('endDate',TRUE)));

                $response['data']=$m_sales_invoice->get_sales_summary_list_salesperson($start,$end);

                echo(
                json_encode($response)
                );
            break;

            case 'product-sales-summary':   
                $m_sales_invoice=$this->Sales_invoice_model;
                $start=date("Y-m-d",strtotime($this->input->get('startDate',TRUE)));
                $end=date("Y-m-d",strtotime($this->input->get('endDate',TRUE)));

                $response['data']=$m_sales_invoice->get_sales_product_summary_list($start,$end);

                echo(
                json_encode($response)
                );
            break;

            case 'summary-report-smc':
                $m_company_info=$this->Company_model;
                $m_sales_invoice=$this->Sales_invoice_model;

                $company_info=$m_company_info->get_list();
                $data['company_info']=$company_info[0];

                $startDate=date('Y-m-d',strtotime($this->input->get('startDate')));
                $endDate=date('Y-m-d',strtotime($this->input->get('endDate')));
                $type=$this->input->get('type',TRUE);

                $data['sales_summaries']=$m_sales_invoice->get_sales_summary_list($startDate,$endDate);
                $data['sp_summaries']=$m_sales_invoice->get_sales_summary_list_salesperson($startDate,$endDate);
                $data['product_summaries']=$m_sales_invoice->get_sales_product_summary_list($startDate,$endDate);

                if ($type == 'c') {
                    $this->load->view('template/sales_report_customer_summary',$data);
                } else if ($type == 'sp') {
                    $this->load->view('template/sales_report_salesperson_summary',$data);
                } else if ($type == 'p') {
                    $this->load->view('template/sales_report_product_summary',$data);
                }
            break;

            case 'email-summary-report-smc':
                $excel = $this->excel;
                $m_email=$this->Email_settings_model;
                $filter_value = 2;
                $email=$m_email->get_list(2);       
                $m_company_info=$this->Company_model;
                $m_sales_invoice=$this->Sales_invoice_model;

                $company_info=$m_company_info->get_list();
                $data['company_info']=$company_info[0];

                $startDate=date('Y-m-d',strtotime($this->input->get('startDate')));
                $endDate=date('Y-m-d',strtotime($this->input->get('endDate')));
                $type=$this->input->get('type',TRUE);

                $sales_summaries=$m_sales_invoice->get_sales_summary_list($startDate,$endDate);

                $product_summaries=$m_sales_invoice->get_sales_product_summary_list($startDate,$endDate);

                $excel->setActiveSheetIndex(0);

                if ($type == 'c') {
                    ob_start();
                    $excel->getActiveSheet()->getColumnDimensionByColumn('A1')->setWidth('50');
                    $excel->getActiveSheet()->getColumnDimensionByColumn('A2:B2')->setWidth('50');
                    $excel->getActiveSheet()->getColumnDimensionByColumn('A3')->setWidth('50');
                    $excel->getActiveSheet()->setTitle("SALES PER CUSTOMER SUMMARY");
                    $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
                     ->setCellValue('A2',$company_info[0]->company_address)
                     ->setCellValue('A3',$company_info[0]->landline.'/'.$company_info[0]->mobile_no);

                    $excel->getActiveSheet()->getStyle('A5')->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->setCellValue('A5','SALES REPORT PER CUSTOMER (SUMMARY)');

                    $excel->getActiveSheet()->getColumnDimension('A')->setWidth('40');
                    $excel->getActiveSheet()->getColumnDimension('B')->setWidth('25');
                    $excel->getActiveSheet()->getColumnDimension('C')->setWidth('25');

                    $excel->getActiveSheet()
                            ->getStyle('C')
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                    $excel->getActiveSheet()->getStyle('A7')->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->getStyle('B7')->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->getStyle('C7')->getFont()->setBold(TRUE);

                    $excel->getActiveSheet()->setCellValue('A7','Customer');
                    $excel->getActiveSheet()->setCellValue('B7','Total Sales');
                    $i = 8;
                    $sum = 0;
                foreach ($sales_summaries as $sales_summary){


                    $excel->getActiveSheet()
                            ->getStyle('A'.$i)
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                    $excel->getActiveSheet()
                            ->getStyle('B'.$i)
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                     $excel->getActiveSheet()->setCellValue('A'.$i,$sales_summary->customer_name);
                     $excel->getActiveSheet()->getStyle('A'.$i)->getFont()->setBold(FALSE);
                     $excel->getActiveSheet()->getStyle('B'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                     $excel->getActiveSheet()->setCellValue('B'.$i,number_format($sales_summary->total_amount,2));

                     $i++;
                     $sum+=$sales_summary->total_amount;

                     $excel->getActiveSheet()
                            ->getStyle('B'.$i)
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                     $excel->getActiveSheet()
                            ->getStyle('A'.$i)
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);


                     $excel->getActiveSheet()->setCellValue('A'.$i,'Total:');
                     $excel->getActiveSheet()->getStyle('A')->getFont()->setBold(TRUE);
                     $excel->getActiveSheet()->getStyle('B'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                     $excel->getActiveSheet()->setCellValue('B'.$i,number_format($sum,2));

                 }


                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename='."Sales Report Per Customer Summary.xlsx".'');
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

                            $file_name='Sales Report Per Customer Summary '.date('Y-m-d h:i:A', now());
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
                            $subject = 'Sales Report Per Customer Summary';
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
                } 
                else if ($type == 'sp'){
                    ob_start();
                    $excel->getActiveSheet()->getColumnDimensionByColumn('A1')->setWidth('50');
                    $excel->getActiveSheet()->getColumnDimensionByColumn('A2:B2')->setWidth('50');
                    $excel->getActiveSheet()->getColumnDimensionByColumn('A3')->setWidth('50');
                    $excel->getActiveSheet()->setTitle("SALES PER SALESPERSON SUMMARY");
                    $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
                     ->setCellValue('A2',$company_info[0]->company_address)
                     ->setCellValue('A3',$company_info[0]->landline.'/'.$company_info[0]->mobile_no);

                    $excel->getActiveSheet()->getStyle('A5')->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->setCellValue('A5','SALES REPORT PER SALESPERSON (SUMMARY)');

                    $i = 8;
                    $sum = 0;

                    $excel->getActiveSheet()->getStyle('A7')->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->getStyle('B7')->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->getStyle('C7')->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()
                                ->getStyle('C7')
                                ->getAlignment()
                                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                    $excel->getActiveSheet()->setCellValue('A7','Salesperson Code');
                    $excel->getActiveSheet()->setCellValue('B7','Salesperson');
                    $excel->getActiveSheet()->setCellValue('C7','Total Sales');

                    foreach ($sales_summaries as $sales_summary){
                         $excel->getActiveSheet()->getColumnDimension('A')->setWidth('20');
                         $excel->getActiveSheet()->getColumnDimension('B')->setWidth('40');
                         $excel->getActiveSheet()->getColumnDimension('C')->setWidth('40');

                         $excel->getActiveSheet()
                                ->getStyle('A'.$i)
                                ->getAlignment()
                                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                         $excel->getActiveSheet()
                                ->getStyle('B'.$i)
                                ->getAlignment()
                                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                         $excel->getActiveSheet()
                                ->getStyle('C'.$i)
                                ->getAlignment()
                                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                         $excel->getActiveSheet()->setCellValue('A'.$i,$sales_summary->salesperson_code);
                         $excel->getActiveSheet()->setCellValue('B'.$i,$sales_summary->salesperson_name);
                         $excel->getActiveSheet()->getStyle('B'.$i)->getFont()->setBold(FALSE);
                         $excel->getActiveSheet()->getStyle('C'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                         $excel->getActiveSheet()->setCellValue('C'.$i,number_format($sales_summary->total_amount,2));

                         $i++;
                         $sum+=$sales_summary->total_amount;
                         $excel->getActiveSheet()
                                ->getStyle('C'.$i)
                                ->getAlignment()
                                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                         $excel->getActiveSheet()
                                ->getStyle('B'.$i)
                                ->getAlignment()
                                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                         $excel->getActiveSheet()->setCellValue('B'.$i,'Total:');
                         $excel->getActiveSheet()->getStyle('B')->getFont()->setBold(TRUE);
                         $excel->getActiveSheet()->getStyle('C'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                         $excel->getActiveSheet()->setCellValue('C'.$i,number_format($sum,2));
                    }

                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename='."Sales Report Per Sales Person Summary.xlsx".'');
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

                            $file_name='Sales Report Per Salesperson (Summary) '.date('Y-m-d h:i:A', now());
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
                            $subject = 'Sales Report Per Salesperson (Summary)';
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
                }
                else {
                ob_start();
                $excel->getActiveSheet()->getColumnDimensionByColumn('A1')->setWidth('50');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A2:B2')->setWidth('50');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A3')->setWidth('50');
                $excel->getActiveSheet()->setTitle("SALES PER PRODUCT SUMMARY");
                $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
                 ->setCellValue('A2',$company_info[0]->company_address)
                 ->setCellValue('A3',$company_info[0]->landline.'/'.$company_info[0]->mobile_no);

                $excel->getActiveSheet()->getStyle('A5')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('A5','SALES REPORT PER PRODUCT (SUMMARY)');

                $i = 8;
                $sum = 0;
                $excel->getActiveSheet()->getColumnDimension('A')->setWidth('20');
                $excel->getActiveSheet()->getColumnDimension('B')->setWidth('40');
                $excel->getActiveSheet()->getColumnDimension('C')->setWidth('25');

                $excel->getActiveSheet()->getStyle('A7')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->getStyle('B7')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->getStyle('C7')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()
                    ->getStyle('C7')
                    ->getAlignment()
                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $excel->getActiveSheet()->setCellValue('A7','Product Code');
                $excel->getActiveSheet()->setCellValue('B7','Product');
                $excel->getActiveSheet()->setCellValue('C7','Invoice Total Sales');

                foreach ($product_summaries as $sales_summary){
                    $excel->getActiveSheet()
                        ->getStyle('A'.$i)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                    $excel->getActiveSheet()
                        ->getStyle('B'.$i)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                    $excel->getActiveSheet()
                        ->getStyle('C'.$i)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                    $excel->getActiveSheet()->setCellValue('A'.$i,$sales_summary->product_code);
                    $excel->getActiveSheet()->setCellValue('B'.$i,$sales_summary->product_desc);
                    $excel->getActiveSheet()->getStyle('B'.$i)->getFont()->setBold(FALSE);          
                    $excel->getActiveSheet()->getStyle('C'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                    $excel->getActiveSheet()->setCellValue('C'.$i,number_format($sales_summary->total_amount,2));

                    $i++;
                    $sum += $sales_summary->total_amount;
                    $excel->getActiveSheet()
                        ->getStyle('C')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);  
                    $excel->getActiveSheet()
                        ->getStyle('B')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT); 
                    $excel->getActiveSheet()->setCellValue('B'.$i,'Total:');        
                    $excel->getActiveSheet()->getStyle('B')->getFont()->setBold(TRUE);          
                    $excel->getActiveSheet()->getStyle('C'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                    $excel->getActiveSheet()->setCellValue('C'.$i,number_format($sum,2));
                }

                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename='."Sales Report Per Product Summary.xlsx".'');
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

                            $file_name='Sales Report Per Product (Summary) '.date('Y-m-d h:i:A', now());
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
                            $subject = 'Sales Report Per Product (Summary)';
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
                }

            break;

            case 'export-summary-report-smc':
                $excel = $this->excel;
                $m_company_info=$this->Company_model;
                $m_sales_invoice=$this->Sales_invoice_model;

                $company_info=$m_company_info->get_list();
                $data['company_info']=$company_info[0];

                $startDate=date('Y-m-d',strtotime($this->input->get('startDate')));
                $endDate=date('Y-m-d',strtotime($this->input->get('endDate')));
                $type=$this->input->get('type',TRUE);

                $sales_summaries=$m_sales_invoice->get_sales_summary_list($startDate,$endDate);

                $product_summaries=$m_sales_invoice->get_sales_product_summary_list($startDate,$endDate);

                $excel->setActiveSheetIndex(0);

                $excel->setActiveSheetIndex(0);

                if ($type == 'c') {
                    ob_start();
                    $excel->getActiveSheet()->getColumnDimensionByColumn('A1')->setWidth('50');
                    $excel->getActiveSheet()->getColumnDimensionByColumn('A2:B2')->setWidth('50');
                    $excel->getActiveSheet()->getColumnDimensionByColumn('A3')->setWidth('50');
                    $excel->getActiveSheet()->setTitle("SALES PER CUSTOMER SUMMARY");
                    $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
                     ->setCellValue('A2',$company_info[0]->company_address)
                     ->setCellValue('A3',$company_info[0]->landline.'/'.$company_info[0]->mobile_no);

                    $excel->getActiveSheet()->getStyle('A5')->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->setCellValue('A5','SALES REPORT PER CUSTOMER (SUMMARY)');

                    $excel->getActiveSheet()->getColumnDimension('A')->setWidth('40');
                    $excel->getActiveSheet()->getColumnDimension('B')->setWidth('25');

                    $excel->getActiveSheet()
                            ->getStyle('C')
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                    $excel->getActiveSheet()->getStyle('A7')->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->getStyle('B7')->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->getStyle('C7')->getFont()->setBold(TRUE);

                    $excel->getActiveSheet()->setCellValue('A7','Customer');
                    $excel->getActiveSheet()->setCellValue('B7','Total Sales');
                    $i = 8;
                    $sum = 0;
                foreach ($sales_summaries as $sales_summary){


                    $excel->getActiveSheet()
                            ->getStyle('A'.$i)
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                    $excel->getActiveSheet()
                            ->getStyle('B'.$i)
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                     $excel->getActiveSheet()->setCellValue('A'.$i,$sales_summary->customer_name);
                     $excel->getActiveSheet()->getStyle('A'.$i)->getFont()->setBold(FALSE);
                     $excel->getActiveSheet()->getStyle('B'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                     $excel->getActiveSheet()->setCellValue('B'.$i,number_format($sales_summary->total_amount,2));

                     $i++;
                     $sum+=$sales_summary->total_amount;

                     $excel->getActiveSheet()
                            ->getStyle('B'.$i)
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                     $excel->getActiveSheet()
                            ->getStyle('A'.$i)
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);


                     $excel->getActiveSheet()->setCellValue('A'.$i,'Total:');
                     $excel->getActiveSheet()->getStyle('A')->getFont()->setBold(TRUE);
                     $excel->getActiveSheet()->getStyle('B'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                     $excel->getActiveSheet()->setCellValue('B'.$i,number_format($sum,2));

                 }

                ob_end_clean();
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename='."Sales Report Per Customer Summary.xlsx".'');
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
                } 
                else if ($type == 'sp'){
                    $excel->getActiveSheet()->getColumnDimensionByColumn('A1')->setWidth('50');
                    $excel->getActiveSheet()->getColumnDimensionByColumn('A2:B2')->setWidth('50');
                    $excel->getActiveSheet()->getColumnDimensionByColumn('A3')->setWidth('50');
                    $excel->getActiveSheet()->setTitle("SALES PER SALESPERSON SUMMARY");
                    $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
                     ->setCellValue('A2',$company_info[0]->company_address)
                     ->setCellValue('A3',$company_info[0]->landline.'/'.$company_info[0]->mobile_no);

                    $excel->getActiveSheet()->getStyle('A5')->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->setCellValue('A5','SALES REPORT PER SALESPERSON (SUMMARY)');

                    $i = 8;
                    $sum = 0;

                    $excel->getActiveSheet()->getStyle('A7')->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->getStyle('B7')->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->getStyle('C7')->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()
                                ->getStyle('C7')
                                ->getAlignment()
                                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                    $excel->getActiveSheet()->setCellValue('A7','Salesperson Code');
                    $excel->getActiveSheet()->setCellValue('B7','Salesperson');
                    $excel->getActiveSheet()->setCellValue('C7','Total Sales');

                    foreach ($sales_summaries as $sales_summary){
                         $excel->getActiveSheet()->getColumnDimension('A')->setWidth('20');
                         $excel->getActiveSheet()->getColumnDimension('B')->setWidth('40');
                         $excel->getActiveSheet()->getColumnDimension('C')->setWidth('40');

                         $excel->getActiveSheet()
                                ->getStyle('A'.$i)
                                ->getAlignment()
                                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                         $excel->getActiveSheet()
                                ->getStyle('B'.$i)
                                ->getAlignment()
                                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                         $excel->getActiveSheet()
                                ->getStyle('C'.$i)
                                ->getAlignment()
                                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                         $excel->getActiveSheet()->setCellValue('A'.$i,$sales_summary->salesperson_code);
                         $excel->getActiveSheet()->setCellValue('B'.$i,$sales_summary->salesperson_name);
                         $excel->getActiveSheet()->getStyle('B'.$i)->getFont()->setBold(FALSE);
                         $excel->getActiveSheet()->getStyle('C'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                         $excel->getActiveSheet()->setCellValue('C'.$i,number_format($sales_summary->total_amount,2));

                         $i++;
                         $sum+=$sales_summary->total_amount;
                         $excel->getActiveSheet()
                                ->getStyle('C'.$i)
                                ->getAlignment()
                                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                         $excel->getActiveSheet()
                                ->getStyle('B'.$i)
                                ->getAlignment()
                                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                         $excel->getActiveSheet()->setCellValue('B'.$i,'Total:');
                         $excel->getActiveSheet()->getStyle('B')->getFont()->setBold(TRUE);
                         $excel->getActiveSheet()->getStyle('C'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                         $excel->getActiveSheet()->setCellValue('C'.$i,number_format($sum,2));
                    }

                ob_end_clean();
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename='."Sales Report Per Sales Person Summary.xlsx".'');
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
                }
                else {

                $excel->getActiveSheet()->getColumnDimensionByColumn('A1')->setWidth('50');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A2:B2')->setWidth('50');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A3')->setWidth('50');
                $excel->getActiveSheet()->setTitle("SALES PER PRODUCT SUMMARY");
                $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
                 ->setCellValue('A2',$company_info[0]->company_address)
                 ->setCellValue('A3',$company_info[0]->landline.'/'.$company_info[0]->mobile_no);

                $excel->getActiveSheet()->getStyle('A5')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('A5','SALES REPORT PER PRODUCT (SUMMARY)');

                $i = 8;
                $sum = 0;
                $excel->getActiveSheet()->getColumnDimension('A')->setWidth('20');
                $excel->getActiveSheet()->getColumnDimension('B')->setWidth('40');
                $excel->getActiveSheet()->getColumnDimension('C')->setWidth('25');

                $excel->getActiveSheet()->getStyle('A7')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->getStyle('B7')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->getStyle('C7')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()
                    ->getStyle('C7')
                    ->getAlignment()
                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $excel->getActiveSheet()->setCellValue('A7','Product Code');
                $excel->getActiveSheet()->setCellValue('B7','Product');
                $excel->getActiveSheet()->setCellValue('C7','Invoice Total Sales');

                foreach ($product_summaries as $sales_summary){
                    $excel->getActiveSheet()
                        ->getStyle('A'.$i)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                    $excel->getActiveSheet()
                        ->getStyle('B'.$i)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                    $excel->getActiveSheet()
                        ->getStyle('C'.$i)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                    $excel->getActiveSheet()->setCellValue('A'.$i,$sales_summary->product_code);
                    $excel->getActiveSheet()->setCellValue('B'.$i,$sales_summary->product_desc);
                    $excel->getActiveSheet()->getStyle('B'.$i)->getFont()->setBold(FALSE);          
                    $excel->getActiveSheet()->getStyle('C'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                    $excel->getActiveSheet()->setCellValue('C'.$i,number_format($sales_summary->total_amount,2));

                    $i++;
                    $sum += $sales_summary->total_amount;
                    $excel->getActiveSheet()
                        ->getStyle('C')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);  
                    $excel->getActiveSheet()
                        ->getStyle('B')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT); 
                    $excel->getActiveSheet()->setCellValue('B'.$i,'Total:');        
                    $excel->getActiveSheet()->getStyle('B')->getFont()->setBold(TRUE);          
                    $excel->getActiveSheet()->getStyle('C'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                    $excel->getActiveSheet()->setCellValue('C'.$i,number_format($sum,2));
                }

                ob_end_clean();
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename='."Sales Report Per Product Summary.xlsx".'');
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
                }

            break;

            case 'detailed-report-smcp': 
                $m_company_info=$this->Company_model;
                $m_sales_invoice=$this->Sales_invoice_model;

                $company_info=$m_company_info->get_list();
                $data['company_info']=$company_info[0];

                $startDate=date('Y-m-d',strtotime($this->input->get('startDate')));
                $endDate=date('Y-m-d',strtotime($this->input->get('endDate')));
                $type=$this->input->get('type',TRUE);

                $data['customers']=$m_sales_invoice->get_per_customer_sales_detailed($startDate,$endDate);

                $data['salespersons']=$m_sales_invoice->get_per_salesperson_sales_detailed($startDate,$endDate);


                $data['sales_details']=$m_sales_invoice->get_sales_detailed_list($startDate,$endDate);

                if ($type == 'c') {
                    $this->load->view('template/sales_report_customer_detailed',$data);
                } else if ($type == 'sp') {
                    $this->load->view('template/sales_report_salesperson_detailed',$data);
                } else {
                    $this->load->view('template/sales_report_product_detailed',$data);
                }
            break;

            case 'email-detailed-report-smcp': 
                $excel=$this->excel;
                $m_email=$this->Email_settings_model;
                $filter_value = 2;
                $email=$m_email->get_list(2);                
                $m_company_info=$this->Company_model;
                $m_sales_invoice=$this->Sales_invoice_model;

                $company_info=$m_company_info->get_list();
                $data['company_info']=$company_info[0];

                $startDate=date('Y-m-d',strtotime($this->input->get('startDate')));
                $endDate=date('Y-m-d',strtotime($this->input->get('endDate')));
                $type=$this->input->get('type',TRUE);

                $customers=$m_sales_invoice->get_per_customer_sales_detailed($startDate,$endDate);

                $salespersons=$m_sales_invoice->get_per_salesperson_sales_detailed($startDate,$endDate);


                $sales_details=$m_sales_invoice->get_sales_detailed_list($startDate,$endDate);
                
                $excel->setActiveSheetIndex(0);

                if ($type == 'c'){

                 ob_start();
                 $excel->getActiveSheet()->getColumnDimensionByColumn('A1')->setWidth('50');
                 $excel->getActiveSheet()->getColumnDimensionByColumn('A2:B2')->setWidth('50');
                 $excel->getActiveSheet()->getColumnDimensionByColumn('A3')->setWidth('50');
                 $excel->getActiveSheet()->setTitle("SALES PER CUSTOMER DETAILED");
                 $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
                 $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
                                         ->setCellValue('A2',$company_info[0]->company_address)
                                         ->setCellValue('A3',$company_info[0]->landline.'/'.$company_info[0]->mobile_no);
                 $excel->getActiveSheet()->getStyle('A5')->getFont()->setBold(TRUE);
                 $excel->getActiveSheet()->setCellValue('A5','SALES REPORT PER CUSTOMER (DETAILED)');

                $i = 7;

                foreach ($customers as $customer){
                    $excel->getActiveSheet()->setCellValue('A'.$i,$customer->customer_name);
                    $excel->getActiveSheet()->getStyle('A'.$i)->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->mergeCells('A'.$i.':G'.$i);
                    $excel->getActiveSheet()->getColumnDimension('B')->setWidth('15');
                    $excel->getActiveSheet()->getColumnDimension('C')->setWidth('15');
                    $excel->getActiveSheet()->getColumnDimension('D')->setWidth('40');
                    $excel->getActiveSheet()->getColumnDimension('E')->setWidth('20');
                    $excel->getActiveSheet()->getColumnDimension('F')->setWidth('15');
                    $excel->getActiveSheet()->getColumnDimension('G')->setWidth('20');


                $i++;
                $excel->getActiveSheet()
                        ->getStyle('A'.$i)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $excel->getActiveSheet()
                        ->getStyle('E'.$i)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $excel->getActiveSheet()
                        ->getStyle('F'.$i)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $excel->getActiveSheet()
                        ->getStyle('G'.$i)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                 $excel->getActiveSheet()->setCellValue('A'.$i,'Invoice #');
                 $excel->getActiveSheet()->getStyle('A'.$i)->getFont()->setBold(TRUE);
                 $excel->getActiveSheet()->setCellValue('B'.$i,'Date');
                 $excel->getActiveSheet()->getStyle('B'.$i)->getFont()->setBold(TRUE);
                 $excel->getActiveSheet()->setCellValue('C'.$i,'Product Code');
                 $excel->getActiveSheet()->getStyle('C'.$i)->getFont()->setBold(TRUE);
                 $excel->getActiveSheet()->setCellValue('D'.$i,'Description');
                 $excel->getActiveSheet()->getStyle('D'.$i)->getFont()->setBold(TRUE);
                 $excel->getActiveSheet()->setCellValue('E'.$i,'Unit Amount');
                 $excel->getActiveSheet()->getStyle('E'.$i)->getFont()->setBold(TRUE);
                 $excel->getActiveSheet()->setCellValue('F'.$i,'Qty');
                 $excel->getActiveSheet()->getStyle('F'.$i)->getFont()->setBold(TRUE);
                 $excel->getActiveSheet()->setCellValue('G'.$i,'Total Amount');
                 $excel->getActiveSheet()->getStyle('G'.$i)->getFont()->setBold(TRUE);

                 $i++;
                 $sum=0;
                 foreach ($sales_details as $sales_detail){
                    if ($customer->customer_id == $sales_detail->customer_id) { 
                        $excel->getActiveSheet()
                                ->getStyle('A'.$i)
                                ->getAlignment()
                                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                        $excel->getActiveSheet()
                                ->getStyle('C'.$i)
                                ->getAlignment()
                                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                        $excel->getActiveSheet()
                                ->getStyle('E'.$i)
                                ->getAlignment()
                                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                        $excel->getActiveSheet()
                                ->getStyle('F'.$i)
                                ->getAlignment()
                                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $excel->getActiveSheet()
                                ->getStyle('G'.$i)
                                ->getAlignment()
                                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                         $excel->getActiveSheet()->setCellValue('A'.$i,$sales_detail->sales_inv_no);
                         $excel->getActiveSheet()->getStyle('A'.$i)->getFont()->setBold(FALSE);
                         $excel->getActiveSheet()->setCellValue('B'.$i,date('Y-m-d', strtotime($sales_detail->date_invoice)));
                         $excel->getActiveSheet()->setCellValue('C'.$i,$sales_detail->product_code);
                         $excel->getActiveSheet()->setCellValue('D'.$i,$sales_detail->product_desc);
                         $excel->getActiveSheet()->getStyle('E'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                         $excel->getActiveSheet()->setCellValue('E'.$i,number_format($sales_detail->inv_price,2));
                         $excel->getActiveSheet()->setCellValue('F'.$i,$sales_detail->inv_qty);
                         $excel->getActiveSheet()->getStyle('F'.$i)->getFont()->setBold(FALSE);
                         $excel->getActiveSheet()->getStyle('G'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                         $excel->getActiveSheet()->setCellValue('G'.$i,number_format($sales_detail->total_amount,2));

                 $i++;

                 $sum += $sales_detail->total_amount;
                 $excel->getActiveSheet()
                        ->getStyle('F'.$i)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $excel->getActiveSheet()
                        ->getStyle('G'.$i)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                 $excel->getActiveSheet()->setCellValue('F'.$i,'TOTAL:');
                 $excel->getActiveSheet()->getStyle('F'.$i)->getFont()->setBold(TRUE);
                 $excel->getActiveSheet()->setCellValue('G'.$i,number_format($sum,2));

                    }
                 }

                 $i++;
                }    
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename='."Sales Report Per Customer Detailed.xlsx".'');
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

                            $file_name='Sales Report Per Customer Detailed '.date('Y-m-d h:i:A', now());
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
                            $subject = 'Sales Report Per Customer Detailed';
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
                }
            else if ($type == 'sp'){

                 ob_start();
                 $excel->getActiveSheet()->getColumnDimensionByColumn('A1')->setWidth('50');
                 $excel->getActiveSheet()->getColumnDimensionByColumn('A2:B2')->setWidth('50');
                 $excel->getActiveSheet()->getColumnDimensionByColumn('A3')->setWidth('50');
                 $excel->getActiveSheet()->setTitle("SALES PER SALESPERSON DETAILED");
                 $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
                 $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
                                         ->setCellValue('A2',$company_info[0]->company_address)
                                         ->setCellValue('A3',$company_info[0]->landline.'/'.$company_info[0]->mobile_no);
                 $excel->getActiveSheet()->getStyle('A5')->getFont()->setBold(TRUE);
                 $excel->getActiveSheet()->setCellValue('A5','SALES REPORT PER SALESPERSON (DETAILED)');

                $i = 7;

                foreach ($salespersons as $salesperson){
                    $excel->getActiveSheet()->setCellValue('A'.$i,$salesperson->salesperson_name);
                    $excel->getActiveSheet()->getStyle('A'.$i)->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->mergeCells('A'.$i.':E'.$i);
                    $excel->getActiveSheet()->getColumnDimension('B')->setWidth('15');
                    $excel->getActiveSheet()->getColumnDimension('C')->setWidth('20');
                    $excel->getActiveSheet()->getColumnDimension('D')->setWidth('15');
                    $excel->getActiveSheet()->getColumnDimension('E')->setWidth('20');

                $i++;

                    $excel->getActiveSheet()
                            ->getStyle('C'.$i)
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                    $excel->getActiveSheet()
                            ->getStyle('D'.$i)
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $excel->getActiveSheet()
                            ->getStyle('E'.$i)
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                    $excel->getActiveSheet()->setCellValue('A'.$i,'Invoice #');
                    $excel->getActiveSheet()->getStyle('A'.$i)->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->setCellValue('B'.$i,'Date');
                    $excel->getActiveSheet()->getStyle('B'.$i)->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->setCellValue('C'.$i,'Unit Amount');
                    $excel->getActiveSheet()->getStyle('C'.$i)->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->setCellValue('D'.$i,'Qty');
                    $excel->getActiveSheet()->getStyle('D'.$i)->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->setCellValue('E'.$i,'Total Amount');
                    $excel->getActiveSheet()->getStyle('E'.$i)->getFont()->setBold(TRUE);

                $i++;
                $sum=0;

                foreach ($sales_details as $sales_detail){
                    if ($salesperson->salesperson_id == $sales_detail->salesperson_id) {
                    $excel->getActiveSheet()
                            ->getStyle('C'.$i)
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                    $excel->getActiveSheet()
                            ->getStyle('D'.$i)
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $excel->getActiveSheet()
                            ->getStyle('E'.$i)
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                    $excel->getActiveSheet()->setCellValue('A'.$i,$sales_detail->sales_inv_no);
                    $excel->getActiveSheet()->getStyle('A'.$i)->getFont()->setBold(FALSE);    
                    $excel->getActiveSheet()->setCellValue('B'.$i,date('Y-m-d', strtotime($sales_detail->date_invoice)));
                    $excel->getActiveSheet()->getStyle('C'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                    $excel->getActiveSheet()->setCellValue('C'.$i,number_format($sales_detail->inv_price,2));
                    $excel->getActiveSheet()->setCellValue('D'.$i,$sales_detail->inv_qty);
                    $excel->getActiveSheet()->getStyle('D'.$i)->getFont()->setBold(FALSE);
                    $excel->getActiveSheet()->getStyle('E'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                    $excel->getActiveSheet()->setCellValue('E'.$i,number_format($sales_detail->total_amount,2));
                
                $i++;

                    $sum += $sales_detail->total_amount;
                    $excel->getActiveSheet()
                    ->getStyle('D'.$i)
                    ->getAlignment()
                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                    $excel->getActiveSheet()
                    ->getStyle('E'.$i)
                    ->getAlignment()
                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                    $excel->getActiveSheet()->setCellValue('D'.$i,'Total:');
                    $excel->getActiveSheet()->getStyle('D'.$i)->getFont()->setBold(TRUE);    
                    $excel->getActiveSheet()->setCellValue('E'.$i,number_format($sum,2));

                   }
                }
                $i++;
                }

                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename='."Sales Report Per Sales Person Detailed.xlsx".'');
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

                          $file_name='SALES REPORT PER SALESPERSON (DETAILED) '.date('Y-m-d h:i:A', now());
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
                            $subject = 'SALES REPORT PER SALESPERSON (DETAILED)';
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
                 }

            else {
                 ob_start();
                 $excel->getActiveSheet()->getColumnDimensionByColumn('A1')->setWidth('50');
                 $excel->getActiveSheet()->getColumnDimensionByColumn('A2:B2')->setWidth('50');
                 $excel->getActiveSheet()->getColumnDimensionByColumn('A3')->setWidth('50');
                 $excel->getActiveSheet()->setTitle("SALES PER PRODUCT DETAILED");
                 $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
                 $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
                                         ->setCellValue('A2',$company_info[0]->company_address)
                                         ->setCellValue('A3',$company_info[0]->landline.'/'.$company_info[0]->mobile_no);
                 $excel->getActiveSheet()->getStyle('A5')->getFont()->setBold(TRUE);
                 $excel->getActiveSheet()->setCellValue('A5','SALES REPORT PER PRODUCT (DETAILED)');


                 $excel->getActiveSheet()
                 ->getStyle('E7')
                 ->getAlignment()
                 ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                 $excel->getActiveSheet()
                 ->getStyle('F7')
                 ->getAlignment()
                 ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                 $excel->getActiveSheet()
                 ->getStyle('G7')
                 ->getAlignment()
                 ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                 $excel->getActiveSheet()->setCellValue('A7','Invoice #');
                 $excel->getActiveSheet()->getStyle('A7')->getFont()->setBold(TRUE);
                 $excel->getActiveSheet()->setCellValue('B7','Date');
                 $excel->getActiveSheet()->getStyle('B7')->getFont()->setBold(TRUE);
                 $excel->getActiveSheet()->setCellValue('C7','Product Code');
                 $excel->getActiveSheet()->getStyle('C7')->getFont()->setBold(TRUE);
                 $excel->getActiveSheet()->setCellValue('D7','Description');
                 $excel->getActiveSheet()->getStyle('D7')->getFont()->setBold(TRUE);
                 $excel->getActiveSheet()->setCellValue('E7','Unit Amount');
                 $excel->getActiveSheet()->getStyle('E7')->getFont()->setBold(TRUE);
                 $excel->getActiveSheet()->setCellValue('F7','Qty');
                 $excel->getActiveSheet()->getStyle('F7')->getFont()->setBold(TRUE);
                 $excel->getActiveSheet()->setCellValue('G7','Total Amount');
                 $excel->getActiveSheet()->getStyle('G7')->getFont()->setBold(TRUE);


                $i = 8;
                $sum=0;
                foreach ($sales_details as $sales_detail){

                    $excel->getActiveSheet()->getColumnDimension('A')->setWidth('30');
                    $excel->getActiveSheet()->getColumnDimension('B')->setWidth('15');
                    $excel->getActiveSheet()->getColumnDimension('C')->setWidth('20');
                    $excel->getActiveSheet()->getColumnDimension('D')->setWidth('30');
                    $excel->getActiveSheet()->getColumnDimension('E')->setWidth('25');
                    $excel->getActiveSheet()->getColumnDimension('F')->setWidth('20');
                    $excel->getActiveSheet()->getColumnDimension('G')->setWidth('25');
                    $excel->getActiveSheet()
                    ->getStyle('A'.$i)
                    ->getAlignment()
                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                    $excel->getActiveSheet()
                    ->getStyle('C'.$i)
                    ->getAlignment()
                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                    $excel->getActiveSheet()
                    ->getStyle('E'.$i)
                    ->getAlignment()
                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                    $excel->getActiveSheet()
                    ->getStyle('F'.$i)
                    ->getAlignment()
                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $excel->getActiveSheet()
                    ->getStyle('G'.$i)
                    ->getAlignment()
                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                    $excel->getActiveSheet()->setCellValue('A'.$i,$sales_detail->sales_inv_no);
                    $excel->getActiveSheet()->setCellValue('B'.$i,date('Y-m-d', strtotime($sales_detail->date_invoice)));
                    $excel->getActiveSheet()->setCellValue('C'.$i,$sales_detail->product_code);
                    $excel->getActiveSheet()->setCellValue('D'.$i,$sales_detail->product_desc);
                    $excel->getActiveSheet()->getStyle('D'.$i)->getFont()->setBold(FALSE);
                    $excel->getActiveSheet()->getStyle('E'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                    $excel->getActiveSheet()->setCellValue('E'.$i,number_format($sales_detail->inv_price,2));
                    $excel->getActiveSheet()->setCellValue('F'.$i,$sales_detail->inv_qty);
                    $excel->getActiveSheet()->getStyle('A'.$i.':F'.$i)->getFont()->setBold(FALSE);
                    $excel->getActiveSheet()->getStyle('G'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                    $excel->getActiveSheet()->setCellValue('G'.$i,number_format($sales_detail->total_amount,2));

                    $i++;
                    $sum += $sales_detail->total_amount;
                    $excel->getActiveSheet()
                            ->getStyle('A'.$i)
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                    $excel->getActiveSheet()
                            ->getStyle('G'.$i)
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                    $excel->getActiveSheet()
                            ->getStyle('F'.$i)
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                    $excel->getActiveSheet()->setCellValue('F'.$i,'Total:');
                    $excel->getActiveSheet()->getStyle('F')->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->getStyle('G'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                    $excel->getActiveSheet()->setCellValue('G'.$i,number_format($sum,2));

                }


                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename='."Sales Report Per Product Detailed.xlsx".'');
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

                            $file_name='SALES REPORT PER PRODUCT (DETAILED) '.date('Y-m-d h:i:A', now());
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
                            $subject = 'SALES REPORT PER PRODUCT (DETAILED)';
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

            }

            break;

            case 'export-detailed-report-smcp': 
                $excel=$this->excel;
                $m_company_info=$this->Company_model;
                $m_sales_invoice=$this->Sales_invoice_model;

                $company_info=$m_company_info->get_list();
                $data['company_info']=$company_info[0];

                $startDate=date('Y-m-d',strtotime($this->input->get('startDate')));
                $endDate=date('Y-m-d',strtotime($this->input->get('endDate')));
                $type=$this->input->get('type',TRUE);

                $customers=$m_sales_invoice->get_per_customer_sales_detailed($startDate,$endDate);

                $salespersons=$m_sales_invoice->get_per_salesperson_sales_detailed($startDate,$endDate);


                $sales_details=$m_sales_invoice->get_sales_detailed_list($startDate,$endDate);
                
                $excel->setActiveSheetIndex(0);

                if ($type == 'c'){


                 $excel->getActiveSheet()->getColumnDimensionByColumn('A1')->setWidth('50');
                 $excel->getActiveSheet()->getColumnDimensionByColumn('A2:B2')->setWidth('50');
                 $excel->getActiveSheet()->getColumnDimensionByColumn('A3')->setWidth('50');
                 $excel->getActiveSheet()->setTitle("SALES PER CUSTOMER DETAILED");
                 $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
                 $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
                                         ->setCellValue('A2',$company_info[0]->company_address)
                                         ->setCellValue('A3',$company_info[0]->landline.'/'.$company_info[0]->mobile_no);
                 $excel->getActiveSheet()->getStyle('A5')->getFont()->setBold(TRUE);
                 $excel->getActiveSheet()->setCellValue('A5','SALES REPORT PER CUSTOMER (DETAILED)');

                $i = 7;

                foreach ($customers as $customer){
                    $excel->getActiveSheet()->setCellValue('A'.$i,$customer->customer_name);
                    $excel->getActiveSheet()->getStyle('A'.$i)->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->mergeCells('A'.$i.':G'.$i);
                    $excel->getActiveSheet()->getColumnDimension('B')->setWidth('15');
                    $excel->getActiveSheet()->getColumnDimension('C')->setWidth('15');
                    $excel->getActiveSheet()->getColumnDimension('D')->setWidth('40');
                    $excel->getActiveSheet()->getColumnDimension('E')->setWidth('20');
                    $excel->getActiveSheet()->getColumnDimension('F')->setWidth('15');
                    $excel->getActiveSheet()->getColumnDimension('G')->setWidth('20');


                $i++;
                $excel->getActiveSheet()
                        ->getStyle('A'.$i)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $excel->getActiveSheet()
                        ->getStyle('E'.$i)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $excel->getActiveSheet()
                        ->getStyle('F'.$i)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $excel->getActiveSheet()
                        ->getStyle('G'.$i)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                 $excel->getActiveSheet()->setCellValue('A'.$i,'Invoice #');
                 $excel->getActiveSheet()->getStyle('A'.$i)->getFont()->setBold(TRUE);
                 $excel->getActiveSheet()->setCellValue('B'.$i,'Date');
                 $excel->getActiveSheet()->getStyle('B'.$i)->getFont()->setBold(TRUE);
                 $excel->getActiveSheet()->setCellValue('C'.$i,'Product Code');
                 $excel->getActiveSheet()->getStyle('C'.$i)->getFont()->setBold(TRUE);
                 $excel->getActiveSheet()->setCellValue('D'.$i,'Description');
                 $excel->getActiveSheet()->getStyle('D'.$i)->getFont()->setBold(TRUE);
                 $excel->getActiveSheet()->setCellValue('E'.$i,'Unit Amount');
                 $excel->getActiveSheet()->getStyle('E'.$i)->getFont()->setBold(TRUE);
                 $excel->getActiveSheet()->setCellValue('F'.$i,'Qty');
                 $excel->getActiveSheet()->getStyle('F'.$i)->getFont()->setBold(TRUE);
                 $excel->getActiveSheet()->setCellValue('G'.$i,'Total Amount');
                 $excel->getActiveSheet()->getStyle('G'.$i)->getFont()->setBold(TRUE);

                 $i++;
                 $sum=0;
                 foreach ($sales_details as $sales_detail){
                    if ($customer->customer_id == $sales_detail->customer_id) { 
                        $excel->getActiveSheet()
                                ->getStyle('A'.$i)
                                ->getAlignment()
                                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                        $excel->getActiveSheet()
                                ->getStyle('C'.$i)
                                ->getAlignment()
                                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                        $excel->getActiveSheet()
                                ->getStyle('E'.$i)
                                ->getAlignment()
                                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                        $excel->getActiveSheet()
                                ->getStyle('F'.$i)
                                ->getAlignment()
                                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $excel->getActiveSheet()
                                ->getStyle('G'.$i)
                                ->getAlignment()
                                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                         $excel->getActiveSheet()->setCellValue('A'.$i,$sales_detail->sales_inv_no);
                         $excel->getActiveSheet()->getStyle('A'.$i)->getFont()->setBold(FALSE);
                         $excel->getActiveSheet()->setCellValue('B'.$i,date('Y-m-d', strtotime($sales_detail->date_invoice)));
                         $excel->getActiveSheet()->setCellValue('C'.$i,$sales_detail->product_code);
                         $excel->getActiveSheet()->setCellValue('D'.$i,$sales_detail->product_desc);
                         $excel->getActiveSheet()->getStyle('E'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                         $excel->getActiveSheet()->setCellValue('E'.$i,number_format($sales_detail->inv_price,2));
                         $excel->getActiveSheet()->setCellValue('F'.$i,$sales_detail->inv_qty);
                         $excel->getActiveSheet()->getStyle('F'.$i)->getFont()->setBold(FALSE);
                         $excel->getActiveSheet()->getStyle('G'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                         $excel->getActiveSheet()->setCellValue('G'.$i,number_format($sales_detail->total_amount,2));

                 $i++;

                 $sum += $sales_detail->total_amount;
                 $excel->getActiveSheet()
                        ->getStyle('F'.$i)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $excel->getActiveSheet()
                        ->getStyle('G'.$i)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                 $excel->getActiveSheet()->setCellValue('F'.$i,'TOTAL:');
                 $excel->getActiveSheet()->getStyle('F'.$i)->getFont()->setBold(TRUE);
                 $excel->getActiveSheet()->setCellValue('G'.$i,number_format($sum,2));

                    }
                 }

                 $i++;
                }    
                ob_end_clean();
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename='."Sales Report Per Customer Detailed.xlsx".'');
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
                }
            else if ($type == 'sp'){

                 $excel->getActiveSheet()->getColumnDimensionByColumn('A1')->setWidth('50');
                 $excel->getActiveSheet()->getColumnDimensionByColumn('A2:B2')->setWidth('50');
                 $excel->getActiveSheet()->getColumnDimensionByColumn('A3')->setWidth('50');
                 $excel->getActiveSheet()->setTitle("SALES PER SALESPERSON DETAILED");
                 $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
                 $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
                                         ->setCellValue('A2',$company_info[0]->company_address)
                                         ->setCellValue('A3',$company_info[0]->landline.'/'.$company_info[0]->mobile_no);
                 $excel->getActiveSheet()->getStyle('A5')->getFont()->setBold(TRUE);
                 $excel->getActiveSheet()->setCellValue('A5','SALES REPORT PER SALESPERSON (DETAILED)');

                $i = 7;

                foreach ($salespersons as $salesperson){
                    $excel->getActiveSheet()->setCellValue('A'.$i,$salesperson->salesperson_name);
                    $excel->getActiveSheet()->getStyle('A'.$i)->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->mergeCells('A'.$i.':E'.$i);
                    $excel->getActiveSheet()->getColumnDimension('B')->setWidth('15');
                    $excel->getActiveSheet()->getColumnDimension('C')->setWidth('20');
                    $excel->getActiveSheet()->getColumnDimension('D')->setWidth('15');
                    $excel->getActiveSheet()->getColumnDimension('E')->setWidth('20');

                $i++;

                    $excel->getActiveSheet()
                            ->getStyle('C'.$i)
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                    $excel->getActiveSheet()
                            ->getStyle('D'.$i)
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $excel->getActiveSheet()
                            ->getStyle('E'.$i)
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                    $excel->getActiveSheet()->setCellValue('A'.$i,'Invoice #');
                    $excel->getActiveSheet()->getStyle('A'.$i)->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->setCellValue('B'.$i,'Date');
                    $excel->getActiveSheet()->getStyle('B'.$i)->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->setCellValue('C'.$i,'Unit Amount');
                    $excel->getActiveSheet()->getStyle('C'.$i)->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->setCellValue('D'.$i,'Qty');
                    $excel->getActiveSheet()->getStyle('D'.$i)->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->setCellValue('E'.$i,'Total Amount');
                    $excel->getActiveSheet()->getStyle('E'.$i)->getFont()->setBold(TRUE);

                $i++;
                $sum=0;

                foreach ($sales_details as $sales_detail){
                    if ($salesperson->salesperson_id == $sales_detail->salesperson_id) {
                    $excel->getActiveSheet()
                            ->getStyle('C'.$i)
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                    $excel->getActiveSheet()
                            ->getStyle('D'.$i)
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $excel->getActiveSheet()
                            ->getStyle('E'.$i)
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                    $excel->getActiveSheet()->setCellValue('A'.$i,$sales_detail->sales_inv_no);
                    $excel->getActiveSheet()->getStyle('A'.$i)->getFont()->setBold(FALSE);    
                    $excel->getActiveSheet()->setCellValue('B'.$i,date('Y-m-d', strtotime($sales_detail->date_invoice)));
                    $excel->getActiveSheet()->getStyle('C'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                    $excel->getActiveSheet()->setCellValue('C'.$i,number_format($sales_detail->inv_price,2));
                    $excel->getActiveSheet()->setCellValue('D'.$i,$sales_detail->inv_qty);
                    $excel->getActiveSheet()->getStyle('D'.$i)->getFont()->setBold(FALSE);
                    $excel->getActiveSheet()->getStyle('E'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                    $excel->getActiveSheet()->setCellValue('E'.$i,number_format($sales_detail->total_amount,2));
                
                $i++;

                    $sum += $sales_detail->total_amount;
                    $excel->getActiveSheet()
                    ->getStyle('D'.$i)
                    ->getAlignment()
                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                    $excel->getActiveSheet()
                    ->getStyle('E'.$i)
                    ->getAlignment()
                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                    $excel->getActiveSheet()->setCellValue('D'.$i,'Total:');
                    $excel->getActiveSheet()->getStyle('D'.$i)->getFont()->setBold(TRUE);    
                    $excel->getActiveSheet()->setCellValue('E'.$i,number_format($sum,2));

                   }
                }
                $i++;
                }

                ob_end_clean();
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename='."Sales Report Per Sales Person Detailed.xlsx".'');
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
            }

            else {
                 $excel->getActiveSheet()->getColumnDimensionByColumn('A1')->setWidth('50');
                 $excel->getActiveSheet()->getColumnDimensionByColumn('A2:B2')->setWidth('50');
                 $excel->getActiveSheet()->getColumnDimensionByColumn('A3')->setWidth('50');
                 $excel->getActiveSheet()->setTitle("SALES PER PRODUCT DETAILED");
                 $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
                 $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
                                         ->setCellValue('A2',$company_info[0]->company_address)
                                         ->setCellValue('A3',$company_info[0]->landline.'/'.$company_info[0]->mobile_no);
                 $excel->getActiveSheet()->getStyle('A5')->getFont()->setBold(TRUE);
                 $excel->getActiveSheet()->setCellValue('A5','SALES REPORT PER PRODUCT (DETAILED)');


                 $excel->getActiveSheet()
                 ->getStyle('E7')
                 ->getAlignment()
                 ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                 $excel->getActiveSheet()
                 ->getStyle('F7')
                 ->getAlignment()
                 ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                 $excel->getActiveSheet()
                 ->getStyle('G7')
                 ->getAlignment()
                 ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                 $excel->getActiveSheet()->setCellValue('A7','Invoice #');
                 $excel->getActiveSheet()->getStyle('A7')->getFont()->setBold(TRUE);
                 $excel->getActiveSheet()->setCellValue('B7','Date');
                 $excel->getActiveSheet()->getStyle('B7')->getFont()->setBold(TRUE);
                 $excel->getActiveSheet()->setCellValue('C7','Product Code');
                 $excel->getActiveSheet()->getStyle('C7')->getFont()->setBold(TRUE);
                 $excel->getActiveSheet()->setCellValue('D7','Description');
                 $excel->getActiveSheet()->getStyle('D7')->getFont()->setBold(TRUE);
                 $excel->getActiveSheet()->setCellValue('E7','Unit Amount');
                 $excel->getActiveSheet()->getStyle('E7')->getFont()->setBold(TRUE);
                 $excel->getActiveSheet()->setCellValue('F7','Qty');
                 $excel->getActiveSheet()->getStyle('F7')->getFont()->setBold(TRUE);
                 $excel->getActiveSheet()->setCellValue('G7','Total Amount');
                 $excel->getActiveSheet()->getStyle('G7')->getFont()->setBold(TRUE);


                $i = 8;
                $sum=0;
                foreach ($sales_details as $sales_detail){

                    $excel->getActiveSheet()->getColumnDimension('A')->setWidth('30');
                    $excel->getActiveSheet()->getColumnDimension('B')->setWidth('15');
                    $excel->getActiveSheet()->getColumnDimension('C')->setWidth('20');
                    $excel->getActiveSheet()->getColumnDimension('D')->setWidth('30');
                    $excel->getActiveSheet()->getColumnDimension('E')->setWidth('25');
                    $excel->getActiveSheet()->getColumnDimension('F')->setWidth('20');
                    $excel->getActiveSheet()->getColumnDimension('G')->setWidth('25');
                    $excel->getActiveSheet()
                    ->getStyle('A'.$i)
                    ->getAlignment()
                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                    $excel->getActiveSheet()
                    ->getStyle('C'.$i)
                    ->getAlignment()
                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                    $excel->getActiveSheet()
                    ->getStyle('E'.$i)
                    ->getAlignment()
                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                    $excel->getActiveSheet()
                    ->getStyle('F'.$i)
                    ->getAlignment()
                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $excel->getActiveSheet()
                    ->getStyle('G'.$i)
                    ->getAlignment()
                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                    $excel->getActiveSheet()->setCellValue('A'.$i,$sales_detail->sales_inv_no);
                    $excel->getActiveSheet()->setCellValue('B'.$i,date('Y-m-d', strtotime($sales_detail->date_invoice)));
                    $excel->getActiveSheet()->setCellValue('C'.$i,$sales_detail->product_code);
                    $excel->getActiveSheet()->setCellValue('D'.$i,$sales_detail->product_desc);
                    $excel->getActiveSheet()->getStyle('D'.$i)->getFont()->setBold(FALSE);
                    $excel->getActiveSheet()->getStyle('E'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                    $excel->getActiveSheet()->setCellValue('E'.$i,number_format($sales_detail->inv_price,2));
                    $excel->getActiveSheet()->setCellValue('F'.$i,$sales_detail->inv_qty);
                    $excel->getActiveSheet()->getStyle('A'.$i.':F'.$i)->getFont()->setBold(FALSE);
                    $excel->getActiveSheet()->getStyle('G'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                    $excel->getActiveSheet()->setCellValue('G'.$i,number_format($sales_detail->total_amount,2));

                    $i++;
                    $sum += $sales_detail->total_amount;
                    $excel->getActiveSheet()
                            ->getStyle('A'.$i)
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                    $excel->getActiveSheet()
                            ->getStyle('G'.$i)
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                    $excel->getActiveSheet()
                            ->getStyle('F'.$i)
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                    $excel->getActiveSheet()->setCellValue('F'.$i,'Total:');
                    $excel->getActiveSheet()->getStyle('F')->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->getStyle('G'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                    $excel->getActiveSheet()->setCellValue('G'.$i,number_format($sum,2));

                }



                ob_end_clean();
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename='."Sales Report Per Product Detailed.xlsx".'');
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
            }

            break;
        }
    }



}
