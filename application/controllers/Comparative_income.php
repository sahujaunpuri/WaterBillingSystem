<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Comparative_income extends CORE_Controller
	{
		function __construct()
		{
			parent::__construct();
			$this->validate_session();
			$this->load->model(
				array(
                'Account_class_model',
                'Journal_info_model',
                'Journal_account_model',
                'Departments_model',
                'Users_model',
                'Company_model',
                'Email_settings_model'
            	)
           	);
           $this->load->library('excel');
		}

		public function index() {
			$this->Users_model->validate();
			$data['_def_css_files'] = $this->load->view('template/assets/css_files', '', true);
	        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', true);
	        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', true);
	        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', true);
	        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', true);
	        $data['title'] = 'Comparative Income Statement';

	        $cur_start_month = date('Y-m-1');
	        $cur_end_month = date('Y-m-t');

	        $prev_start_month = date('Y-m-j', strtotime('first day of previous month'));
	        $prev_end_month = date('Y-m-j', strtotime('last day of previous month'));

	        $data['departments']=$this->Departments_model->get_list('is_deleted=FALSE');

	        $data['income_accounts']=$this->Journal_info_model->get_cur_prev_balance(4,$prev_start_month,$prev_end_month,$cur_start_month,$cur_end_month);
	        $data['expense_accounts']=$this->Journal_info_model->get_cur_prev_balance(5,$prev_start_month,$prev_end_month,$cur_start_month,$cur_end_month);
        (in_array('9-16',$this->session->user_rights)? 
         $this->load->view('comparative_income_view', $data)
        :redirect(base_url('dashboard')));
	       
		}

        
		function Report() {
            date_default_timezone_set('Asia/Manila');

			$cur_start_month = date('Y-m-1');
	        $cur_end_month = date('Y-m-t');

	        $prev_start_month = date('Y-m-j', strtotime('first day of previous month'));
	        $prev_end_month = date('Y-m-j', strtotime('last day of previous month'));

	        $company_info=$this->Company_model->get_list();
	        $data['company_info']=$company_info[0];

	        $data['departments']=$this->Departments_model->get_list('is_deleted=FALSE');

	        $data['income_accounts']=$this->Journal_info_model->get_cur_prev_balance(4,$prev_start_month,$prev_end_month,$cur_start_month,$cur_end_month);
	        $data['expense_accounts']=$this->Journal_info_model->get_cur_prev_balance(5,$prev_start_month,$prev_end_month,$cur_start_month,$cur_end_month);

	        $this->load->view('template/comparative_income_report',$data);
		}


		function Export(){
			$cur_start_month = date('Y-m-1');
	        $cur_end_month = date('Y-m-t');

	        $prev_start_month = date('Y-m-j', strtotime('first day of previous month'));
	        $prev_end_month = date('Y-m-j', strtotime('last day of previous month'));

	        $company_info=$this->Company_model->get_list();
	        $data['company_info']=$company_info[0];

	        $data['departments']=$this->Departments_model->get_list('is_deleted=FALSE');

	        $income_accounts=$this->Journal_info_model->get_cur_prev_balance(4,$prev_start_month,$prev_end_month,$cur_start_month,$cur_end_month);
	        $expense_accounts=$this->Journal_info_model->get_cur_prev_balance(5,$prev_start_month,$prev_end_month,$cur_start_month,$cur_end_month);


	            $excel=$this->excel;
              
                $excel->setActiveSheetIndex(0);
                  ob_start();
                // SET WIDTH
                $excel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
                $excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
                $excel->getActiveSheet()->getColumnDimension('C')->setWidth(30);

                $excel->getActiveSheet()->setTitle('Comparative Income Statement');

                $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
                                        ->setCellValue('A2',$company_info[0]->company_address)
                                        ->setCellValue('A3',$company_info[0]->email_address)
                                        ->setCellValue('A4',$company_info[0]->mobile_no);


                $excel->Align_center('A',8);
                $excel->Align_center('B',8);
                $excel->Align_center('c',8);
                $excel->getActiveSheet()->getStyle('A8')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->getStyle('B8')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->getStyle('C8')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->getStyle('A8')->getAlignment()
                                        ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER)
                                        ->setWrapText(true)
                                        ;
                $excel->getActiveSheet()->getStyle('B8')->getAlignment()->setWrapText(true);
                $excel->getActiveSheet()->getStyle('C8')->getAlignment()->setWrapText(true);   

                $excel->getActiveSheet()->setCellValue('A8','ACCOUNT DESCRIPTION');
                $excel->getActiveSheet()->setCellValue('B8',"PREVIOUS MONTH\n(".date('F Y', strtotime('last month')).")");

                $excel->getActiveSheet()->setCellValue('C8',"CURRENT MONTH\n(".date("F Y").")");
                $excel->Cell_color('A',9,'b7d2ff');
                $excel->getActiveSheet()->setCellValue('A9','INCOME')
                						->mergeCells('A9:C9')
                						->getStyle('A9')->getFont()
                						->setBold(TRUE);
                $excel->Align_center('A','9');
                $i = 9;
                $income_total_prev=0;
                $income_total_cur=0;
                foreach($income_accounts as $income_account)
                {
                    $i++;
                    $excel->Align_right('B',$i);
                    $excel->Align_right('C',$i);
                    $excel->getActiveSheet()->setCellValue('A'.$i,$income_account->account_title);
                    $excel->getActiveSheet()->setCellValue('B'.$i,number_format($income_account->core_prev_balance,2));
                    $excel->getActiveSheet()->setCellValue('C'.$i,number_format($income_account->core_cur_balance,2));
                    

                    $income_total_prev+=$income_account->core_prev_balance;
                    $income_total_cur+=$income_account->core_cur_balance;

                }
                $i++;
                // $excel->getActiveSheet()->getStyle('A'.$i)
                // 						->getAlignment()
                //                     	->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
               $excel->Align_right('A',$i);
               $excel->Align_right('B',$i);
              $excel->Align_right('C',$i);
                
                $excel->getActiveSheet()->setCellValue('A'.$i,'Total Income:')
                						->getStyle('A'.$i)->getFont()
                                        ->setBold(TRUE);
                                        
                $excel->getActiveSheet()->setCellValue('B'.$i,number_format($income_total_prev,2))
                						->getStyle('B'.$i)->getFont()
                                        ->setBold(TRUE);
                                        
                $excel->getActiveSheet()->setCellValue('C'.$i,number_format($income_total_cur,2))
                						->getStyle('C'.$i)->getFont()
                                        ->setBold(TRUE);
                                        
                $i+=1;
               $excel->Align_center('A',$i);
                $excel->Cell_color('A',$i,'b7d2ff');
                $excel->getActiveSheet()->setCellValue('A'.$i,'EXPENSES')
                						->mergeCells('A'.$i.':C'.$i.'')
                						->getStyle('A'.$i)->getFont()
                						->setBold(TRUE);
                $expense_total_prev=0;
                $expense_total_cur=0;
                foreach($expense_accounts as $expense_account)
                {
                    $i++;
                    $excel->Align_right('B',$i);
                    $excel->Align_right('C',$i);
                    $excel->getActiveSheet()->setCellValue('A'.$i,$expense_account->account_title);
                    $excel->getActiveSheet()->setCellValue('B'.$i,number_format($expense_account->core_prev_balance,2));
                    $excel->getActiveSheet()->setCellValue('C'.$i,number_format($expense_account->core_cur_balance,2));

                    $expense_total_prev+=$expense_account->core_prev_balance;
                    $expense_total_cur+=$expense_account->core_cur_balance;

                }
                $i++;
                $excel->Align_right('A',$i);
                $excel->Align_right('B',$i);
                $excel->Align_right('C',$i);
                $excel->getActiveSheet()->setCellValue('A'.$i,'Total Expense:')
                						->getStyle('A'.$i)->getFont()
                                        ->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('B'.$i,number_format($expense_total_prev,2))
                						->getStyle('B'.$i)->getFont()
                                        ->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('C'.$i,number_format($expense_total_cur,2))
                						->getStyle('C'.$i)->getFont()
                                        ->setBold(TRUE);
                $i++;
                $excel->Align_right('A',$i);
                $excel->Align_right('B',$i);
                $excel->Align_right('C',$i);
                $excel->getActiveSheet()->setCellValue('A'.$i,'NET INCOME:')
						->getStyle('A'.$i)->getFont()
                        ->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('B'.$i,number_format($income_total_prev,2)-number_format($expense_total_prev,2))
                						->getStyle('B'.$i)->getFont()
                                        ->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('C'.$i,number_format(($income_total_cur-$expense_total_cur),2))
                						->getStyle('C'.$i)->getFont()
                                        ->setBold(TRUE)
                                        ;


                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="Comparative Income Statement '.date('F Y').'.xlsx"');
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

                $send = $this->input->get('send');
                    if($send == "true")    

                {
                $data = ob_get_contents();
                ob_end_clean();
                    $m_email=$this->Email_settings_model;
                                $email=$m_email->get_list(2);
                                $file_name='Comparative Income Statement';
                                $excelFilePath = $file_name.".xlsx"; 
                                $emailConfig = array(
                                    'protocol' => 'smtp', 
                                    'smtp_host' => 'ssl://smtp.googlemail.com', 
                                    'smtp_port' => 465, 
                                    'smtp_user' => $email[0]->email_address, 
                                    'smtp_pass' => $email[0]->password, 
                                    'mailtype' => 'html', 
                                    'charset' => 'iso-8859-1'
                                );
                                $from = array(
                                    'email' => $email[0]->email_address,
                                    'name' => $email[0]->name_from
                                );
                                $to = array($email[0]->email_to);
                                $subject = 'Comparative Income Statement';
                                $message = '<p>To: ' .$email[0]->email_to. '</p></ br>' .$email[0]->default_message.'</ br><p>Sent By: '. '<b>'.$this->session->user_fullname.'</b>'. '</p></ br>';
                                $this->load->library('email', $emailConfig);
                                $this->email->set_newline("\r\n");
                                $this->email->from($from['email'], $from['name']);
                                $this->email->to($to);
                                $this->email->subject($subject);
                                $this->email->message($message);
                                $this->email->attach($data, 'attachment', $excelFilePath , 'application/ms-excel');
                                $this->email->set_mailtype("html");
                                if (!$this->email->send()) {
                                $response['title']='Try Again!';
                                $response['stat']='error';
                                $response['msg']='Please check the Email Address or your Internet Connection.';
                                } else {
                                $response['title']='Success!';
                                $response['stat']='success';
                                $response['msg']='Email Sent successfully.';
                                }
                                echo json_encode($response);};
 




        }

	}
?>