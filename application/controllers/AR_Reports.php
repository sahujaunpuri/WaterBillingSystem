<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AR_Reports extends CORE_Controller {
    function __construct() {
        parent::__construct('');

        $this->validate_session();
        $this->load->model('AR_Receivable_model');
		$this->load->model('Customers_model');
        $this->load->library('M_pdf');
        $this->load->model('Users_model');
        $this->load->model('Company_model');
        $this->load->library('excel');
        $this->load->model('Email_settings_model');
    }

    public function index() {

    }


    function layout($layout=null,$filter_value=null,$filter_from=null,$filter_to=null,$type=null){
        switch($layout){
            case 'ar_receivable_reports': //purchase order
                            $m_company=$this->Company_model;
                $company=$m_company->get_list();

                $data['company_info']=$company[0];
					$m_ar_receivable=$this->AR_Receivable_model;
					$m_customers=$this->Customers_model;
					$tempfrom = str_replace("-", "/", $filter_from);
					$tempto = str_replace("-", "/", $filter_to);
					
					$new_filter_from = date("Y-m-d", strtotime($tempfrom));
					$new_filter_to = date("Y-m-d", strtotime($tempto));
					if($filter_value=="all"){
						$data['receivables']=$m_ar_receivable->get_customer_receivable_list_nofilter($filter_value,$new_filter_from,$new_filter_to);
					}
					else{
						$data['receivables']=$m_ar_receivable->get_customer_receivable_list($filter_value,$new_filter_from,$new_filter_to);
					}
					if($filter_value!="all"){
						$customer_name=$m_customers->get_list(
						$filter_value,
						'customers.customer_name'
						);
						$data['customers']=$customer_name[0]->customer_name;
					}
					else{
						$data['customers']="All";
					}
					
					$data['tempfrom']=$tempfrom;
					$data['tempto']=$tempto;
                    
					
                        //show only inside grid
						if($type=='fullview'||$type==null){
                            echo $this->load->view('template/customer_receivable_list_report_html',$data,TRUE);
                        }
						
                        //download pdf
                        if($type=='pdf'){
                            $pdfFilePath = $data['customers']."-".$tempfrom."-".$tempto.".pdf"; //generate filename base on id
                            $pdf = $this->m_pdf->load(); //pass the instance of the mpdf class
                            $content=$this->load->view('template/customer_receivable_list_report_html',$data,TRUE); //load the template
                            $pdf->setFooter('{PAGENO}');
                            $pdf->WriteHTML($content);
                            //download it.
                            $pdf->Output($pdfFilePath,"D");

                        }

                        //preview on browser
                        if($type=='preview'){
                            $pdfFilePath = "print.pdf"; //generate filename base on id
                            $pdf = $this->m_pdf->load(); //pass the instance of the mpdf class
                            $content=$this->load->view('template/customer_receivable_list_report_html',$data,TRUE); //load the template
                            $pdf->setFooter('{PAGENO}');
                            $pdf->WriteHTML($content);
                            //download it.
                            $pdf->Output();
                        }

                        break;
//EXPORT TO EXCEL
            case 'ar_receivable_reports_export': //purchase order
                $excel=$this->excel;
                $m_company=$this->Company_model;
                $company=$m_company->get_list();

                $company_info=$company[0];
                $m_ar_receivable=$this->AR_Receivable_model;
                $m_customers=$this->Customers_model;
                $tempfrom = str_replace("-", "/", $filter_from);
                $tempto = str_replace("-", "/", $filter_to);
                
                $new_filter_from = date("Y-m-d", strtotime($tempfrom));
                $new_filter_to = date("Y-m-d", strtotime($tempto));
                if($filter_value=="all"){
                    $receivables=$m_ar_receivable->get_customer_receivable_list_nofilter($filter_value,$new_filter_from,$new_filter_to);
                }
                else{
                    $receivables=$m_ar_receivable->get_customer_receivable_list($filter_value,$new_filter_from,$new_filter_to);
                }
                if($filter_value!="all"){
                    $customer_name=$m_customers->get_list(
                    $filter_value,
                    'customers.customer_name'
                    );
                    $customers=$customer_name[0]->customer_name;
                }
                else{
                    $customers="All";
                }
                
                $data['tempfrom']=$tempfrom;
                $data['tempto']=$tempto;
                    
                $excel->setActiveSheetIndex(0);

                $excel->getActiveSheet()->getColumnDimensionByColumn('A1:B1')->setWidth('30');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A2:B2')->setWidth('50');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A3')->setWidth('30');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A4')->setWidth('30');

                //name the worksheet
                $excel->getActiveSheet()->setTitle("AR SCHEDULE REPORT");
                $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->mergeCells('A1:B1');
                $excel->getActiveSheet()->mergeCells('A2:B2');
                $excel->getActiveSheet()->mergeCells('A3:B3');
                $excel->getActiveSheet()->mergeCells('A4:B4');
                $excel->getActiveSheet()->setCellValue('A1',$company_info->company_name)
                                        ->setCellValue('A2',$company_info->company_address)
                                        ->setCellValue('A3',$company_info->landline.'/'.$company_info->mobile_no)
                                        ->setCellValue('A4',$company_info->email_address);

                $excel->getActiveSheet()->setCellValue('A6','Customer Name: '.$customers)
                                        ->getStyle('A6')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('A7','Date: '.$tempfrom.' To '.$tempto)
                                        ->getStyle('A7')->getFont()->setBold(TRUE);

                $excel->getActiveSheet()->getColumnDimension('A')->setWidth('40');
                $excel->getActiveSheet()->getColumnDimension('B')->setWidth('50');
                $excel->getActiveSheet()->getColumnDimension('C')->setWidth('30');

                $excel->getActiveSheet()
                        ->getStyle('C')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()->setCellValue('A9','Invoice')
                                        ->getStyle('A9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('B9','Remarks')
                                        ->getStyle('B9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('C9','Amount Due')
                                        ->getStyle('C9')->getFont()->setBold(TRUE);
                $i=10;

                foreach($receivables as $item){
                    $excel->getActiveSheet()
                            ->getStyle('C')
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                    $excel->getActiveSheet()->setCellValue('A'.$i,$item->sales_inv_no);
                    $excel->getActiveSheet()->setCellValue('B'.$i,$item->remarks);
                    $excel->getActiveSheet()->getStyle('C'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                    $excel->getActiveSheet()->setCellValue('C'.$i,number_format($item->net_receivable,2));

                    $i++;
                }

                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename='."Account Receivable Report.xlsx".'');
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

//EMAIL EXCEL
            case 'ar_receivable_reports_email': //purchase order
                $excel=$this->excel;
                $m_email=$this->Email_settings_model;
                $email=$m_email->get_list(2);
                $m_company=$this->Company_model;
                $company=$m_company->get_list();

                $company_info=$company[0];
                $m_ar_receivable=$this->AR_Receivable_model;
                $m_customers=$this->Customers_model;
                $tempfrom = str_replace("-", "/", $filter_from);
                $tempto = str_replace("-", "/", $filter_to);
                
                $new_filter_from = date("Y-m-d", strtotime($tempfrom));
                $new_filter_to = date("Y-m-d", strtotime($tempto));
                if($filter_value=="all"){
                    $receivables=$m_ar_receivable->get_customer_receivable_list_nofilter($filter_value,$new_filter_from,$new_filter_to);
                }
                else{
                    $receivables=$m_ar_receivable->get_customer_receivable_list($filter_value,$new_filter_from,$new_filter_to);
                }
                if($filter_value!="all"){
                    $customer_name=$m_customers->get_list(
                    $filter_value,
                    'customers.customer_name'
                    );
                    $customers=$customer_name[0]->customer_name;
                }
                else{
                    $customers="All";
                }
                
                $data['tempfrom']=$tempfrom;
                $data['tempto']=$tempto;
                
                ob_start();
                $excel->setActiveSheetIndex(0);

                $excel->getActiveSheet()->getColumnDimensionByColumn('A1:B1')->setWidth('30');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A2:B2')->setWidth('50');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A3')->setWidth('30');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A4')->setWidth('30');

                //name the worksheet
                $excel->getActiveSheet()->setTitle("AR SCHEDULE REPORT");
                $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->mergeCells('A1:B1');
                $excel->getActiveSheet()->mergeCells('A2:B2');
                $excel->getActiveSheet()->mergeCells('A3:B3');
                $excel->getActiveSheet()->mergeCells('A4:B4');
                $excel->getActiveSheet()->setCellValue('A1',$company_info->company_name)
                                        ->setCellValue('A2',$company_info->company_address)
                                        ->setCellValue('A3',$company_info->landline.'/'.$company_info->mobile_no)
                                        ->setCellValue('A4',$company_info->email_address);

                $excel->getActiveSheet()->setCellValue('A6','Customer Name: '.$customers)
                                        ->getStyle('A6')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('A7','Date: '.$tempfrom.' To '.$tempto)
                                        ->getStyle('A7')->getFont()->setBold(TRUE);

                $excel->getActiveSheet()->getColumnDimension('A')->setWidth('40');
                $excel->getActiveSheet()->getColumnDimension('B')->setWidth('50');
                $excel->getActiveSheet()->getColumnDimension('C')->setWidth('30');

                $excel->getActiveSheet()
                        ->getStyle('C')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()->setCellValue('A9','Invoice')
                                        ->getStyle('A9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('B9','Remarks')
                                        ->getStyle('B9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('C9','Amount Due')
                                        ->getStyle('C9')->getFont()->setBold(TRUE);
                $i=10;

                foreach($receivables as $item){
                    $excel->getActiveSheet()
                            ->getStyle('C')
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                    $excel->getActiveSheet()->setCellValue('A'.$i,$item->sales_inv_no);
                    $excel->getActiveSheet()->setCellValue('B'.$i,$item->remarks);
                    $excel->getActiveSheet()->getStyle('C'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                    $excel->getActiveSheet()->setCellValue('C'.$i,number_format($item->net_receivable,2));

                    $i++;
                }

                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename='."Account Receivable Report.xlsx".'');
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

                            $file_name='ACCOUNT RECEIVABLE REPORT '.date('Y-m-d h:i:A', now());
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
                            $subject = 'ACCOUNT RECEIVABLE REPORT';
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
