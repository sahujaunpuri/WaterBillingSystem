<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TAccount extends CORE_Controller
{
    function __construct()
    {
        parent::__construct('');
        $this->validate_session();
        $this->load->model(
            array
            (
                'Journal_account_model',
                'Departments_model',
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
        $data['title'] = 'T-Accounts Report';

        $data['departments']=$this->Departments_model->get_list(array('is_deleted'=>FALSE,'is_active'=>TRUE));

        (in_array('9-14',$this->session->user_rights)? 
        $this->load->view('book_of_accounts_view',$data)
        :redirect(base_url('dashboard')));
    }



    public function transaction($txn=null){
        switch($txn){
            case 'get-journal-list':
                $m_journal = $this->Journal_account_model;

                $start =date('Y-m-d', strtotime($this->input->post('start',TRUE)));
                $end = date('Y-m-d', strtotime($this->input->post('end',TRUE)));
                $book = $this->input->post('book',TRUE);

                $response['data'] = $m_journal->get_t_account($book,$start,$end);
                echo json_encode($response);
                break;

            case 'journal-report':
                $m_journal=$this->Journal_account_model;
                $m_company=$this->Company_model;

                $start=date('Y-m-d', strtotime($this->input->get('s',TRUE)));
                $end=date('Y-m-d', strtotime($this->input->get('e',TRUE)));
                $book=$this->input->get('b',TRUE);
                $company_info=$m_company->get_list();
                $data['company_info']=$company_info[0];

                switch ($book) {
                    case 'GJE':
                            $data['title']='GENERAL JOURNAL';
                        break;

                    case 'CDJ':
                            $data['title']='CASH DISBURSEMENT';
                        break;

                    case 'PJE':
                            $data['title']='PURCHASE JOURNAL';
                        break;

                    case 'SJE':
                            $data['title']='SALES JOURNAL';
                        break;

                    case 'PCF':
                            $data['title']='PETTY CASH VOUCHER';
                        break;

                    case 'CRJ':
                            $data['title']='CASH RECEIPT';
                        break;
                    
                    default:
                            $data['title']='T-Accounts';
                        break;
                }

                $data['journal_list'] = $m_journal->get_t_account($book,$start,$end);
                $this->load->view('template/book_of_accounts_report',$data);
                break;

            case 'journal_report_summary':
                $m_journal=$this->Journal_account_model;
                $m_company=$this->Company_model;

                $start=date('Y-m-d', strtotime($this->input->get('s',TRUE)));
                $end=date('Y-m-d', strtotime($this->input->get('e',TRUE)));
                $company_info=$m_company->get_list();
                $data['company_info']=$company_info[0];


                $book=$this->input->get('b',TRUE);

                switch ($book) {
                    case 'GJE':
                            $data['title']='GENERAL JOURNAL SUMMARY';
                        break;

                    case 'CDJ':
                            $data['title']='CASH DISBURSEMENT SUMMARY';
                        break;

                    case 'PJE':
                            $data['title']='PURCHASE JOURNAL SUMMARY';
                        break;

                    case 'SJE':
                            $data['title']='SALES JOURNAL SUMMARY';
                        break;

                    case 'PCF':
                            $data['title']='PETTY CASH VOUCHER SUMMARY';
                        break;

                    case 'CRJ':
                            $data['title']='CASH RECEIPT SUMMARY';
                        break;
                    
                    default:
                            $data['title']='T-Accounts';
                        break;
                }

                $data['journal_list'] = $m_journal->get_t_account_summary_cdj($book,$start,$end);
                $this->load->view('template/book_of_accounts_report_summary',$data);

                break;

            case 'journal-report-export':
                $excel=$this->excel;
                $m_journal=$this->Journal_account_model;
                $m_company=$this->Company_model;

                $start=date('Y-m-d', strtotime($this->input->get('s',TRUE)));
                $end=date('Y-m-d', strtotime($this->input->get('e',TRUE)));
                $book=$this->input->get('b',TRUE);
                $company_info=$m_company->get_list();
                $data['company_info']=$company_info[0];

                switch ($book) {
                    case 'GJE':
                            $title='GENERAL JOURNAL';
                        break;

                    case 'CDJ':
                            $title='CASH DISBURSEMENT';
                        break;

                    case 'PJE':
                            $title='PURCHASE JOURNAL';
                        break;

                    case 'SJE':
                            $title='SALES JOURNAL';
                        break;

                    case 'PCF':
                            $title='PETTY CASH VOUCHER';
                        break;

                    case 'CRJ':
                            $title='CASH RECEIPT';
                        break;
                    
                    default:
                            $title='T-Accounts';
                        break;
                }

                $journal_list = $m_journal->get_t_account($book,$start,$end);

                $excel->setActiveSheetIndex(0);
                $excel->getActiveSheet()->getColumnDimensionByColumn('A1')->setWidth('50');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A2:B2')->setWidth('50');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A3')->setWidth('50');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A4')->setWidth('50');

                //name the worksheet
                $excel->getActiveSheet()->setTitle("T-ACCOUNT ".$title);
                $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
                                        ->setCellValue('A2',$company_info[0]->company_address)
                                        ->setCellValue('A3',$company_info[0]->landline.'/'.$company_info[0]->mobile_no)                                      
                                        ->setCellValue('A4',$company_info[0]->email_address);

                $excel->getActiveSheet()->getStyle('A')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('A6','T-ACCOUNT'.' '.'('.$title.')')
                                        ->setCellValue('A7','Date: '.$_GET['s'].' to '.$_GET['e']);


                $excel->getActiveSheet()->getColumnDimension('A')->setWidth('35');
                $excel->getActiveSheet()->getColumnDimension('B')->setWidth('20');
                $excel->getActiveSheet()->getColumnDimension('C')->setWidth('37');
                $excel->getActiveSheet()->getColumnDimension('D')->setWidth('60');
                $excel->getActiveSheet()->getColumnDimension('E')->setWidth('25');
                $excel->getActiveSheet()->getColumnDimension('F')->setWidth('18');
                $excel->getActiveSheet()->getColumnDimension('G')->setWidth('18');

                $excel->getActiveSheet()
                        ->getStyle('F')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()
                        ->getStyle('G')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()->setCellValue('A9','Txn #')
                                        ->getStyle('A9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('B9','Date')
                                        ->getStyle('B9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('C9','Particular')
                                        ->getStyle('C9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('D9','Remarks')
                                        ->getStyle('D9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('E9','Account')
                                        ->getStyle('E9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('F9','Dr')
                                        ->getStyle('F9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('G9','Cr')
                                        ->getStyle('G9')->getFont()->setBold(TRUE);
                $i = 10;

                $sum_dr = 0;
                $sum_cr = 0;

                foreach ($journal_list as $journal){

                $excel->getActiveSheet()
                        ->getStyle('F'.$i)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()
                        ->getStyle('G'.$i)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                    $excel->getActiveSheet()->setCellValue('A'.$i,$journal->txn_no)
                                            ->getStyle('A'.$i)->getFont()->setBold(FALSE);
                    $excel->getActiveSheet()->setCellValue('B'.$i,$journal->date_txn);
                    $excel->getActiveSheet()->setCellValue('C'.$i,$journal->description);
                    $excel->getActiveSheet()->setCellValue('D'.$i,$journal->remarks);
                    $excel->getActiveSheet()->setCellValue('E'.$i,$journal->account_title);
                    $excel->getActiveSheet()->getStyle('F'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                    $excel->getActiveSheet()->setCellValue('F'.$i,number_format($journal->dr_amount,2));
                    $excel->getActiveSheet()->getStyle('G'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                    $excel->getActiveSheet()->setCellValue('G'.$i,number_format($journal->cr_amount,2));
                    
                    $sum_dr+=$journal->dr_amount;
                    $sum_cr+=$journal->cr_amount;
                    $i++;

                }

                    $excel->getActiveSheet()
                            ->getStyle('A'.$i)
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                    $excel->getActiveSheet()->setCellValue('A'.$i,'Total:')
                                            ->mergeCells('A'.$i.':'.'E'.$i)
                                            ->getStyle('A'.$i)->getFont()->setBold(FALSE);

                    $excel->getActiveSheet()->getStyle('F'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                    $excel->getActiveSheet()->setCellValue('F'.$i,number_format($sum_dr,2))
                                            ->getStyle('F'.$i)->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->getStyle('G'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                    $excel->getActiveSheet()->setCellValue('G'.$i,number_format($sum_cr,2))
                                            ->getStyle('G'.$i)->getFont()->setBold(TRUE);


                $i++;


                ob_end_clean();
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename='.$title.".xlsx".'');
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

            case 'journal-report-email':
                $excel=$this->excel;
                $m_email=$this->Email_settings_model;
                $email=$m_email->get_list(2);
                $m_journal=$this->Journal_account_model;
                $m_company=$this->Company_model;

                $start=date('Y-m-d', strtotime($this->input->get('s',TRUE)));
                $end=date('Y-m-d', strtotime($this->input->get('e',TRUE)));
                $book=$this->input->get('b',TRUE);
                $company_info=$m_company->get_list();
                $data['company_info']=$company_info[0];

                switch ($book) {
                    case 'GJE':
                            $title='GENERAL JOURNAL';
                        break;

                    case 'CDJ':
                            $title='CASH DISBURSEMENT';
                        break;

                    case 'PJE':
                            $title='PURCHASE JOURNAL';
                        break;

                    case 'SJE':
                            $title='SALES JOURNAL';
                        break;

                    case 'PCF':
                            $title='PETTY CASH VOUCHER';
                        break;

                    case 'CRJ':
                            $title='CASH RECEIPT';
                        break;
                    
                    default:
                            $title='T-Accounts';
                        break;
                }

                $journal_list = $m_journal->get_t_account($book,$start,$end);

                ob_start();

                $excel->setActiveSheetIndex(0);
                $excel->getActiveSheet()->getColumnDimensionByColumn('A1')->setWidth('50');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A2:B2')->setWidth('50');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A3')->setWidth('50');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A4')->setWidth('50');

                //name the worksheet
                $excel->getActiveSheet()->setTitle("T-ACCOUNT ".$title);
                $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
                                        ->setCellValue('A2',$company_info[0]->company_address)
                                        ->setCellValue('A3',$company_info[0]->landline.'/'.$company_info[0]->mobile_no)                                      
                                        ->setCellValue('A4',$company_info[0]->email_address);

                $excel->getActiveSheet()->getStyle('A')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('A6','T-ACCOUNT'.' '.'('.$title.')')
                                        ->setCellValue('A7','Date: '.$_GET['s'].' to '.$_GET['e']);


                $excel->getActiveSheet()->getColumnDimension('A')->setWidth('35');
                $excel->getActiveSheet()->getColumnDimension('B')->setWidth('20');
                $excel->getActiveSheet()->getColumnDimension('C')->setWidth('37');
                $excel->getActiveSheet()->getColumnDimension('D')->setWidth('60');
                $excel->getActiveSheet()->getColumnDimension('E')->setWidth('25');
                $excel->getActiveSheet()->getColumnDimension('F')->setWidth('18');
                $excel->getActiveSheet()->getColumnDimension('G')->setWidth('18');

                $excel->getActiveSheet()
                        ->getStyle('F')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()
                        ->getStyle('G')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()->setCellValue('A9','Txn #')
                                        ->getStyle('A9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('B9','Date')
                                        ->getStyle('B9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('C9','Particular')
                                        ->getStyle('C9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('D9','Remarks')
                                        ->getStyle('D9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('E9','Account')
                                        ->getStyle('E9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('F9','Dr')
                                        ->getStyle('F9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('G9','Cr')
                                        ->getStyle('G9')->getFont()->setBold(TRUE);
                $i = 10;

                $sum_dr = 0;
                $sum_cr = 0;

                foreach ($journal_list as $journal){

                $excel->getActiveSheet()
                        ->getStyle('F'.$i)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()
                        ->getStyle('G'.$i)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                    $excel->getActiveSheet()->setCellValue('A'.$i,$journal->txn_no)
                                            ->getStyle('A'.$i)->getFont()->setBold(FALSE);
                    $excel->getActiveSheet()->setCellValue('B'.$i,$journal->date_txn);
                    $excel->getActiveSheet()->setCellValue('C'.$i,$journal->description);
                    $excel->getActiveSheet()->setCellValue('D'.$i,$journal->remarks);
                    $excel->getActiveSheet()->setCellValue('E'.$i,$journal->account_title);
                    $excel->getActiveSheet()->getStyle('F'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                    $excel->getActiveSheet()->setCellValue('F'.$i,number_format($journal->dr_amount,2));
                    $excel->getActiveSheet()->getStyle('G'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                    $excel->getActiveSheet()->setCellValue('G'.$i,number_format($journal->cr_amount,2));
                    
                    $sum_dr+=$journal->dr_amount;
                    $sum_cr+=$journal->cr_amount;
                    $i++;

                }

                    $excel->getActiveSheet()
                            ->getStyle('A'.$i)
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                    $excel->getActiveSheet()->setCellValue('A'.$i,'Total:')
                                            ->mergeCells('A'.$i.':'.'E'.$i)
                                            ->getStyle('A'.$i)->getFont()->setBold(FALSE);

                    $excel->getActiveSheet()->getStyle('F'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                    $excel->getActiveSheet()->setCellValue('F'.$i,number_format($sum_dr,2))
                                            ->getStyle('F'.$i)->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->getStyle('G'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                    $excel->getActiveSheet()->setCellValue('G'.$i,number_format($sum_cr,2))
                                            ->getStyle('G'.$i)->getFont()->setBold(TRUE);


                $i++;


                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename='.$title.".xlsx".'');
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

                            $file_name=$title.' REPORT '.date('Y-m-d h:i:A', now());
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
                            $subject = $title.' REPORT';
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

                case 'journal_report_export_summary':
                $excel=$this->excel;
                $m_journal=$this->Journal_account_model;
                $m_company=$this->Company_model;

                $start=date('Y-m-d', strtotime($this->input->get('s',TRUE)));
                $end=date('Y-m-d', strtotime($this->input->get('e',TRUE)));
                $company_info=$m_company->get_list();
                $data['company_info']=$company_info[0];


                $book=$this->input->get('b',TRUE);

                switch ($book) {
                    case 'GJE':
                            $title='GENERAL JOURNAL SUMMARY';
                        break;

                    case 'CDJ':
                            $title='CASH DISBURSEMENT SUMMARY';
                        break;

                    case 'PJE':
                            $title='PURCHASE JOURNAL SUMMARY';
                        break;

                    case 'SJE':
                            $title='SALES JOURNAL SUMMARY';
                        break;

                    case 'PCF':
                            $title='PETTY CASH VOUCHER SUMMARY';
                        break;

                    case 'CRJ':
                            $title='CASH RECEIPT SUMMARY';
                        break;
                    
                    default:
                            $title='T-Accounts';
                        break;
                }

                $journal_list = $m_journal->get_t_account_summary_cdj($book,$start,$end);

                $excel->setActiveSheetIndex(0);
                $excel->getActiveSheet()->getColumnDimensionByColumn('A1')->setWidth('50');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A2:B2')->setWidth('50');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A3')->setWidth('50');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A4')->setWidth('50');

                //name the worksheet
                $excel->getActiveSheet()->setTitle($title);
                $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
                                        ->setCellValue('A2',$company_info[0]->company_address)
                                        ->setCellValue('A3',$company_info[0]->landline.'/'.$company_info[0]->mobile_no)                                      
                                        ->setCellValue('A4',$company_info[0]->email_address);

                $excel->getActiveSheet()->getStyle('A')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('A6','T-ACCOUNT'.' '.'('.$title.')')
                                        ->setCellValue('A7','Date: '.$_GET['s'].' to '.$_GET['e']);

                $excel->getActiveSheet()->getColumnDimension('A')->setWidth('35');
                $excel->getActiveSheet()->getColumnDimension('B')->setWidth('50');
                $excel->getActiveSheet()->getColumnDimension('C')->setWidth('35');
                $excel->getActiveSheet()->getColumnDimension('D')->setWidth('35');

                $excel->getActiveSheet()
                        ->getStyle('C')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()
                        ->getStyle('D')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()->setCellValue('A9','Account No')
                                        ->getStyle('A9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('B9','Account Title')
                                        ->getStyle('B9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('C9','Dr')
                                        ->getStyle('C9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('D9','Cr')
                                        ->getStyle('D9')->getFont()->setBold(TRUE);

                $i = 10;
                $sum_dr=0;
                $sum_cr=0;

                foreach($journal_list as $journal) {

                $excel->getActiveSheet()
                        ->getStyle('A'.$i)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                $excel->getActiveSheet()
                        ->getStyle('C'.$i)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()
                        ->getStyle('D'.$i)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                    $excel->getActiveSheet()->setCellValue('A'.$i,$journal->account_no)
                                            ->getStyle('A'.$i)->getFont()->setBold(FALSE);
                    $excel->getActiveSheet()->setCellValue('B'.$i,$journal->account_title);
                    $excel->getActiveSheet()->getStyle('C'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                    $excel->getActiveSheet()->setCellValue('C'.$i,number_format($journal->dr_amount,2));
                    $excel->getActiveSheet()->getStyle('D'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                    $excel->getActiveSheet()->setCellValue('D'.$i,number_format($journal->cr_amount,2));

                    $sum_dr+=$journal->dr_amount;
                    $sum_cr+=$journal->cr_amount;
                    $i++;
                }
                
                    $excel->getActiveSheet()
                            ->getStyle('A'.$i)
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                    $excel->getActiveSheet()->setCellValue('A'.$i,'Total:')
                                            ->mergeCells('A'.$i.':'.'B'.$i)
                                            ->getStyle('A'.$i)->getFont()->setBold(FALSE);

                    $excel->getActiveSheet()->getStyle('C'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                    $excel->getActiveSheet()->setCellValue('C'.$i,number_format($sum_dr,2))
                                            ->getStyle('C'.$i)->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->getStyle('D'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                    $excel->getActiveSheet()->setCellValue('D'.$i,number_format($sum_cr,2))
                                            ->getStyle('D'.$i)->getFont()->setBold(TRUE);


                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename='.$title.".xlsx".'');
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

                case 'journal-report-email-summary':
                $excel=$this->excel;
                $m_email=$this->Email_settings_model;
                $email=$m_email->get_list(2);
                $m_journal=$this->Journal_account_model;
                $m_company=$this->Company_model;

                $start=date('Y-m-d', strtotime($this->input->get('s',TRUE)));
                $end=date('Y-m-d', strtotime($this->input->get('e',TRUE)));
                $company_info=$m_company->get_list();
                $data['company_info']=$company_info[0];


                $book=$this->input->get('b',TRUE);

                switch ($book) {
                    case 'GJE':
                            $title='GENERAL JOURNAL SUMMARY';
                        break;

                    case 'CDJ':
                            $title='CASH DISBURSEMENT SUMMARY';
                        break;

                    case 'PJE':
                            $title='PURCHASE JOURNAL SUMMARY';
                        break;

                    case 'SJE':
                            $title='SALES JOURNAL SUMMARY';
                        break;

                    case 'PCF':
                            $title='PETTY CASH VOUCHER SUMMARY';
                        break;

                    case 'CRJ':
                            $title='CASH RECEIPT SUMMARY';
                        break;
                    
                    default:
                            $title='T-Accounts';
                        break;
                }

                $journal_list = $m_journal->get_t_account_summary_cdj($book,$start,$end);

                ob_start();
                $excel->setActiveSheetIndex(0);
                $excel->getActiveSheet()->getColumnDimensionByColumn('A1')->setWidth('50');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A2:B2')->setWidth('50');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A3')->setWidth('50');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A4')->setWidth('50');

                //name the worksheet
                $excel->getActiveSheet()->setTitle($title);
                $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
                                        ->setCellValue('A2',$company_info[0]->company_address)
                                        ->setCellValue('A3',$company_info[0]->landline.'/'.$company_info[0]->mobile_no)                                      
                                        ->setCellValue('A4',$company_info[0]->email_address);

                $excel->getActiveSheet()->getStyle('A')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('A6','T-ACCOUNT'.' '.'('.$title.')')
                                        ->setCellValue('A7','Date: '.$_GET['s'].' to '.$_GET['e']);

                $excel->getActiveSheet()->getColumnDimension('A')->setWidth('35');
                $excel->getActiveSheet()->getColumnDimension('B')->setWidth('50');
                $excel->getActiveSheet()->getColumnDimension('C')->setWidth('35');
                $excel->getActiveSheet()->getColumnDimension('D')->setWidth('35');

                $excel->getActiveSheet()
                        ->getStyle('C')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()
                        ->getStyle('D')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()->setCellValue('A9','Account No')
                                        ->getStyle('A9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('B9','Account Title')
                                        ->getStyle('B9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('C9','Dr')
                                        ->getStyle('C9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('D9','Cr')
                                        ->getStyle('D9')->getFont()->setBold(TRUE);

                $i = 10;
                $sum_dr=0;
                $sum_cr=0;

                foreach($journal_list as $journal) {

                $excel->getActiveSheet()
                        ->getStyle('A'.$i)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                $excel->getActiveSheet()
                        ->getStyle('C'.$i)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()
                        ->getStyle('D'.$i)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                    $excel->getActiveSheet()->setCellValue('A'.$i,$journal->account_no)
                                            ->getStyle('A'.$i)->getFont()->setBold(FALSE);
                    $excel->getActiveSheet()->setCellValue('B'.$i,$journal->account_title);
                    $excel->getActiveSheet()->getStyle('C'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                    $excel->getActiveSheet()->setCellValue('C'.$i,number_format($journal->dr_amount,2));
                    $excel->getActiveSheet()->getStyle('D'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                    $excel->getActiveSheet()->setCellValue('D'.$i,number_format($journal->cr_amount,2));

                    $sum_dr+=$journal->dr_amount;
                    $sum_cr+=$journal->cr_amount;
                    $i++;
                }
                
                    $excel->getActiveSheet()
                            ->getStyle('A'.$i)
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                    $excel->getActiveSheet()->setCellValue('A'.$i,'Total:')
                                            ->mergeCells('A'.$i.':'.'B'.$i)
                                            ->getStyle('A'.$i)->getFont()->setBold(FALSE);

                    $excel->getActiveSheet()->getStyle('C'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                    $excel->getActiveSheet()->setCellValue('C'.$i,number_format($sum_dr,2))
                                            ->getStyle('C'.$i)->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->getStyle('D'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                    $excel->getActiveSheet()->setCellValue('D'.$i,number_format($sum_cr,2))
                                            ->getStyle('D'.$i)->getFont()->setBold(TRUE);


                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename='.$title.".xlsx".'');
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

                            $file_name=$title.' REPORT '.date('Y-m-d h:i:A', now());
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
                            $subject = $title.' REPORT';
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