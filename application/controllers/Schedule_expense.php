<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Schedule_expense extends CORE_Controller
{

    function __construct() {
        parent::__construct('');
        $this->validate_session();
        $this->load->model(array(
                'Account_title_model',
                'Departments_model',
                'Sched_expense_integration',
                'Users_model',
                'Company_model'
            )
        );
        $this->load->library('excel');
        $this->load->model('Email_settings_model');
    }

    public function index() {
        $this->Users_model->validate();
        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', TRUE);
        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', TRUE);
        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', TRUE);
        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', TRUE);
        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', TRUE);
        $data['title'] = 'Schedule of Expense';
        $data['departments'] = $this->Departments_model->get_list('is_deleted=0 AND is_active=1');
        (in_array('9-11',$this->session->user_rights)? 
        $this->load->view('schedule_expense_view', $data)
        :redirect(base_url('dashboard')));
        
    }

    public function transaction($txn=nul){
        switch($txn){
            case 'schedule-expenses':
                $m_schedule=$this->Sched_expense_integration;
                $date=date('Y-m-d',strtotime($this->input->get('date',TRUE)));
                $depid=$this->input->get('depid',TRUE);


                $response['date']=$date;
                $response['data']=$m_schedule->get_schedule_expense($date,$depid);
                echo json_encode($response);
                break;
            case 'print-schedule-expense':
                $company_info=$this->Company_model->get_list();
                $params['company_info']=$company_info[0];


                $data['department']=$this->Departments_model->get_list($this->input->post('department'));
                $data['company_header']=$this->load->view('template/company_header',$params,TRUE);

                $this->load->view('template/schedule_expense_report',$data);
                break;

            case 'export-schedule-expense':
                $excel=$this->excel;
                $company_info=$this->Company_model->get_list();
                $params['company_info']=$company_info[0];


                $data['department']=$this->Departments_model->get_list($this->input->post('department'));
                $data['company_header']=$this->load->view('template/company_header',$params,TRUE);

                $excel->setActiveSheetIndex(0);

                $excel->getActiveSheet()
                        ->getStyle('A')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                //name the worksheet
                $excel->getActiveSheet()->setTitle("Schedule of Expense Report");
                $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
                                        ->setCellValue('A2',$company_info[0]->company_address)
                                        ->setCellValue('A3',$company_info[0]->landline.'/'.$company_info[0]->mobile_no)
                                        ->mergeCells('A2:B2')
                                        ->getColumnDimensionByColumn('A2:B2')->setwidth('100');

                $excel->getActiveSheet()->setCellValue('A5','Schedule of Cost of Goods Sold')
                                        ->getStyle('A5')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('A6','Period 01/01/2017 to 02/02/2017');


                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename='."Schedule of Expense Report.xlsx".'');
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

            case 'email-schedule-expense':
                $excel=$this->excel;
                $m_email=$this->Email_settings_model;
                $email=$m_email->get_list(2);                
                $company_info=$this->Company_model->get_list();
                $params['company_info']=$company_info[0];


                $data['department']=$this->Departments_model->get_list($this->input->post('department'));
                $data['company_header']=$this->load->view('template/company_header',$params,TRUE);

                ob_start();
                $excel->setActiveSheetIndex(0);

                $excel->getActiveSheet()
                        ->getStyle('A')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                //name the worksheet
                $excel->getActiveSheet()->setTitle("Schedule of Expense Report");
                $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
                                        ->setCellValue('A2',$company_info[0]->company_address)
                                        ->setCellValue('A3',$company_info[0]->landline.'/'.$company_info[0]->mobile_no)
                                        ->mergeCells('A2:B2')
                                        ->getColumnDimensionByColumn('A2:B2')->setwidth('100');

                $excel->getActiveSheet()->setCellValue('A5','Schedule of Cost of Goods Sold')
                                        ->getStyle('A5')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('A6','Period 01/01/2017 to 02/02/2017');


                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename='."Schedule of Expense Report.xlsx".'');
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
                            $file_name='SCHEDULE EXPENSE REPORT '.date('Y-m-d h:i:A', now());
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
                            $subject = 'SCHEDULE EXPENSE REPORT';
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
