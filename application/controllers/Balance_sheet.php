<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Balance_sheet extends CORE_Controller
{

    function __construct() {
        parent::__construct('');
        $this->validate_session();
        $this->load->model(array(
                'Account_class_model',
                'Journal_info_model',
                'Journal_account_model',
                'Departments_model',
                'Accounting_period_model',
                'Users_model',
                'Company_model'
            )
        );

        $this->load->library('M_pdf');
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
        $data['title'] = 'Balance Sheet';

        $data['departments']=$this->Departments_model->get_list('is_deleted=FALSE');


        (in_array('9-1',$this->session->user_rights)? 
        $this->load->view('balance_sheet_view', $data)
        :redirect(base_url('dashboard')));
        
    }


    function transaction($txn=null){
        switch($txn){
            case 'bs':
                //$as_of_date=$this->input->get('date',TRUE);
                $as_of_date=date("Y-m-d",strtotime($this->input->get('date',TRUE)));
                $department_id=$this->input->get('depid',TRUE);
                $type=$this->input->get('type',TRUE);

                $net_income_period=$this->get_period_on_closed_txn($as_of_date);
                if(count($net_income_period)>0){ //if specified date is between the closed period
                    $net_income_start=date("Y-m-d",strtotime($net_income_period[0]->period_start));
                    $net_income_end=date("Y-m-d",strtotime($as_of_date));
                }else{
                    //if date specified is not found on "closed accounting period"

                    //get the last closed date
                    $last_closed=$this->get_last_accounting_closed_date();
                    if(count($last_closed)>0){

                        $net_income_start=date("Y-m-d",strtotime("1 days",strtotime($last_closed[0]->last_closed_date)));
                        $net_income_end=date("Y-m-d",strtotime($as_of_date));

                        //make sure new start date base on the last closed date is not greater than to the specified date
                        if($net_income_start>$net_income_end){ //if greater than
                            $first_journal_txn=$this->get_journal_first_txn_date();
                            if(count($first_journal_txn)>0){ //there is journal transaction


                                $net_income_start=date("Y-m-d",strtotime($first_journal_txn[0]->first_txn_date));
                                $net_income_end=date("Y-m-d",strtotime($as_of_date));

                                //make sure journal first date is not greater than "as of date"
                                if($net_income_start>$net_income_end){
                                    $net_income_start=$net_income_end;
                                }

                            }else{ //if no transaction found

                                $net_income_start=date("Y-m-d",strtotime(date('Y',strtotime($as_of_date)))."-01-01"); //set it to january 1, of specified date
                                $net_income_end=date("Y-m-d",strtotime($as_of_date));
                            }

                        }

                    }else{
                        $first_journal_txn=$this->get_journal_first_txn_date();
                        if(count($first_journal_txn)>0){ //there is journal transaction


                            $net_income_start=date("Y-m-d",strtotime($first_journal_txn[0]->first_txn_date));
                            $net_income_end=date("Y-m-d",strtotime($as_of_date));

                            //make sure journal first date is not greater than "as of date"
                            if($net_income_start>$net_income_end){
                                $net_income_start=$net_income_end;
                            }

                        }else{ //if no transaction found

                            $net_income_start=date("Y-m-d",strtotime(date('Y',strtotime($as_of_date)))."-01-01"); //set it to january 1, of specified date
                            $net_income_end=date("Y-m-d",strtotime($as_of_date));
                        }

                    }
                }



                $m_journal_accounts=$this->Journal_account_model;

                //if id is 1, Main-All branches is selected, set it to null to disable filtering
                if($department_id==1){$department_id=null;}

                //get list of account classifications
                $data['acc_classes']=$m_journal_accounts->get_bs_account_classes($as_of_date,$department_id);
                //get list of parent account
                $data['acc_titles']=$m_journal_accounts->get_bs_parent_account_balances($as_of_date,$department_id);

                $data['prev_net_income']=$m_journal_accounts->get_net_income($net_income_start,$department_id);

                $data['current_year_earnings']=$m_journal_accounts->get_net_income(array(
                    $net_income_start,
                    $net_income_end
                ),$department_id);

                $data['date']=date("M d, Y",strtotime($as_of_date));
                $data['net_period']=date("M d, Y",strtotime($net_income_start))." to ".date("M d, Y",strtotime($net_income_end));

                $m_company=$this->Company_model;
                $company=$m_company->get_list();

                $data['company_info']=$company[0];
                $dep_info=$this->Departments_model->get_list($department_id);
                $data['dep_info']=$dep_info[0];

                if($type==null|$type=='preview'){
                    $this->load->view('template/balance_sheet_report',$data);
                }




                break;

                case 'email-excel':

               $double_underline = array(
                      'font'  => array(
                        'underline' => 'doubleAccounting'
                      )
                );
                $single_underline = array(
                      'font'  => array(
                        'underline' => 'singleAccounting'
                      )
                );


                $as_of_date=date("Y-m-d",strtotime($this->input->get('date',TRUE)));
                $department_id=$this->input->get('depid',TRUE);
                $type=$this->input->get('type',TRUE);

                $net_income_period=$this->get_period_on_closed_txn($as_of_date);
                if(count($net_income_period)>0){ //if specified date is between the closed period
                    $net_income_start=date("Y-m-d",strtotime($net_income_period[0]->period_start));
                    $net_income_end=date("Y-m-d",strtotime($as_of_date));
                }else{
                    //if date specified is not found on "closed accounting period"

                    //get the last closed date
                    $last_closed=$this->get_last_accounting_closed_date();
                    if(count($last_closed)>0){

                        $net_income_start=date("Y-m-d",strtotime("1 days",strtotime($last_closed[0]->last_closed_date)));
                        $net_income_end=date("Y-m-d",strtotime($as_of_date));

                        //make sure new start date base on the last closed date is not greater than to the specified date
                        if($net_income_start>$net_income_end){ //if greater than
                            $first_journal_txn=$this->get_journal_first_txn_date();
                            if(count($first_journal_txn)>0){ //there is journal transaction


                                $net_income_start=date("Y-m-d",strtotime($first_journal_txn[0]->first_txn_date));
                                $net_income_end=date("Y-m-d",strtotime($as_of_date));

                                //make sure journal first date is not greater than "as of date"
                                if($net_income_start>$net_income_end){
                                    $net_income_start=$net_income_end;
                                }

                            }else{ //if no transaction found

                                $net_income_start=date("Y-m-d",strtotime(date('Y',strtotime($as_of_date)))."-01-01"); //set it to january 1, of specified date
                                $net_income_end=date("Y-m-d",strtotime($as_of_date));
                            }

                        }

                    }else{
                        $first_journal_txn=$this->get_journal_first_txn_date();
                        if(count($first_journal_txn)>0){ //there is journal transaction


                            $net_income_start=date("Y-m-d",strtotime($first_journal_txn[0]->first_txn_date));
                            $net_income_end=date("Y-m-d",strtotime($as_of_date));

                            //make sure journal first date is not greater than "as of date"
                            if($net_income_start>$net_income_end){
                                $net_income_start=$net_income_end;
                            }

                        }else{ //if no transaction found

                            $net_income_start=date("Y-m-d",strtotime(date('Y',strtotime($as_of_date)))."-01-01"); //set it to january 1, of specified date
                            $net_income_end=date("Y-m-d",strtotime($as_of_date));
                        }

                    }
                }



                $m_journal_accounts=$this->Journal_account_model;

                //if id is 1, Main-All branches is selected, set it to null to disable filtering
                if($department_id==1){$department_id=null;}

                //get list of account classifications
                $acc_classes=$m_journal_accounts->get_bs_account_classes($as_of_date,$department_id);
                //get list of parent account
                $acc_titles=$m_journal_accounts->get_bs_parent_account_balances($as_of_date,$department_id);

                $prev_net_income=$m_journal_accounts->get_net_income($net_income_start,$department_id);

                $current_year_earnings=$m_journal_accounts->get_net_income(array(
                    $net_income_start,
                    $net_income_end
                ),$department_id);

                $date=date("M d, Y",strtotime($as_of_date));
                $net_period=date("M d, Y",strtotime($net_income_start))." to ".date("M d, Y",strtotime($net_income_end));

                $m_company=$this->Company_model;
                $company_info=$m_company->get_list();

                $dep_info=$this->Departments_model->get_list($department_id);
                $data['dep_info']=$dep_info[0];


                $excel=$this->excel;
                $m_email=$this->Email_settings_model;
                $filter_value = 2;
                $email=$m_email->get_list(2);    
                ob_start();
                $excel->setActiveSheetIndex(0);
                $excel->getActiveSheet()->getStyle('D')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $excel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
                $excel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
                $excel->getActiveSheet()->getColumnDimension('E')->setWidth(15);

                $excel->getActiveSheet()->setTitle('Balance Sheet');

                $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
                                        ->setCellValue('A2',$company_info[0]->company_address)
                                        ->setCellValue('A3',$company_info[0]->email_address)
                                        ->setCellValue('A4',$company_info[0]->mobile_no);

                $excel->Align_center('A',5);
                $excel->Align_center('A',6);
                $excel->getActiveSheet()->setCellValue('A5','BALANCE SHEET')->mergeCells('A5:E5');
                $excel->getActiveSheet()->getStyle('A6')->getFont()->setItalic(true);
                $excel->getActiveSheet()->setCellValue('A6','As of date '.$date)->mergeCells('A6:E6');
                $excel->Set_bold('A',7);
                $excel->getActiveSheet()->setCellValue('A7','Total Assets');
                $i = 8;


                   $total_type=0; 
                        foreach($acc_classes as $class){ 
                            if($class->account_type_id==1){ 
                            $excel->getActiveSheet()->getStyle('B'.$i)->getFont()->setItalic(true);
                               $excel->getActiveSheet()->setCellValue('B'.$i,$class->account_class);                     

                    $i++;
                    $total_balance=0; 
                        foreach($acc_titles as $account){
                            if($class->account_class_id==$account->account_class_id){
                                $excel->Align_right('E',$i);
                                $excel->getActiveSheet()->setCellValue('C'.$i,$account->account_title);
                                $excel->getActiveSheet()->setCellValue('E'.$i,$this->format_display($account->balance));
                                $total_balance+=$account->balance; $total_type+=$account->balance;
                                $i++;
                               }
                           }
                  $excel->getActiveSheet()->getRowDimension($i)->setRowHeight(5);
                  $excel->getActiveSheet()->getStyle('E'.$i)->applyFromArray($single_underline);
                  $excel->getActiveSheet()->setCellValue('E'.$i,'   ');
                  $i++;
                  // TOTAL CURRENT ASSETS
                  $excel->Set_bold('E',$i);
                  $excel->Align_right('E',$i);
                  $excel->getActiveSheet()->getStyle('D'.$i)->getFont()->setItalic(true);
                  $excel->getActiveSheet()->setCellValue('D'.$i,'Total '.$class->account_class);
                  $excel->getActiveSheet()->getStyle('E'.$i)->applyFromArray($single_underline);
                  $excel->getActiveSheet()->setCellValue('E'.$i,$this->format_display($total_balance));
                  $i+=2;

                  // TOTAL ASSETS
                  $excel->Set_bold('E',$i);
                  $excel->Set_bold('D',$i);

                  $excel->Align_right('E',$i);
                  $excel->getActiveSheet()->getStyle('E'.$i)->applyFromArray($double_underline);
                  $excel->getActiveSheet()->setCellValue('D'.$i,'Total Assets');
                  $excel->getActiveSheet()->setCellValue('E'.$i, $this->format_display($total_type));

                    }
                 } 

                $i+=3;

                $excel->Set_bold('A',$i);
                $excel->getActiveSheet()->setCellValue('A'.$i,'Total Liabilities and Equities');
                $i++;
                $total_type=0; 
                        foreach($acc_classes as $class){ 
                            if($class->account_type_id==2||$class->account_type_id==3){
                                $excel->getActiveSheet()->getStyle('B'.$i)->getFont()->setItalic(true);
                                $excel->getActiveSheet()->setCellValue('B'.$i,$class->account_class);                        

                    $i++;
                    $total_balance=0; 
                        foreach($acc_titles as $account){
                            if($class->account_class_id==$account->account_class_id){
                                $excel->Align_right('E',$i);
                                $excel->getActiveSheet()->setCellValue('C'.$i,$account->account_title);
                                $excel->getActiveSheet()->setCellValue('E'.$i,$this->format_display($account->balance));
                                $total_balance+=$account->balance; $total_type+=$account->balance;
                                $i++;
                               }
                           }
                  $excel->getActiveSheet()->getRowDimension($i)->setRowHeight(5);
                  $excel->getActiveSheet()->getStyle('E'.$i)->applyFromArray($single_underline);
                  $excel->getActiveSheet()->setCellValue('E'.$i,'   ');
                  $i++;
                  // TOTAL CURRENT LIABILITIES
                  $excel->getActiveSheet()->getStyle('E'.$i)->applyFromArray($single_underline);
                  $excel->Set_bold('E',$i);
                  $excel->Align_right('E',$i);
                  $excel->getActiveSheet()->getStyle('D'.$i)->getFont()->setItalic(true);
                  
                  $excel->getActiveSheet()->setCellValue('D'.$i,'Total '.$class->account_class);
                  $excel->getActiveSheet()->setCellValue('E'.$i,$this->format_display($total_balance));
                  $i++;

                  $excel->Set_bold('E',$i);
                  $excel->Align_right('E',$i);
                  $excel->getActiveSheet()->getStyle('D'.$i)->getFont()->setItalic(true);
                  $excel->getActiveSheet()->getStyle('E'.$i)->applyFromArray($single_underline);
                  $excel->getActiveSheet()->setCellValue('D'.$i,'Retained Earnings (forwarded previous net income)');
                  $excel->getActiveSheet()->setCellValue('E'.$i,$this->format_display($prev_net_income));
                  $i++;

                  $excel->Set_bold('E',$i);
                  $excel->Align_right('E',$i);
                  $excel->getActiveSheet()->getStyle('D'.$i)->getFont()->setItalic(true);
                  $excel->getActiveSheet()->getStyle('E'.$i)->applyFromArray($single_underline);
                  $excel->getActiveSheet()->setCellValue('D'.$i,'Current Period Earnings ('.$net_period.')');
                  $excel->getActiveSheet()->setCellValue('E'.$i,$this->format_display($current_year_earnings));


                  $i+=2;
                  $excel->Set_bold('E',$i);
                  $excel->Align_right('E',$i);
                  $excel->Set_bold('D',$i);
                  $excel->getActiveSheet()->setCellValue('D'.$i,'Total Liabilites and Equities');
                  $excel->getActiveSheet()->getStyle('E'.$i)->applyFromArray($double_underline);
                  $excel->getActiveSheet()->setCellValue('E'.$i,$this->format_display($total_type+$current_year_earnings+$prev_net_income));
                    }
                 } 



                // Redirect output to a client’s web browser (Excel2007)
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="Balance Sheet.xlsx"');
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

                          $file_name='BALANCE SHEET '.date('Y-m-d h:i:A', now());
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
                            $subject = 'BALANCE SHEET';
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



    function get_period_on_closed_txn($date){
            $m_period=$this->Accounting_period_model;

            return $m_period->get_list(
                "'$date' BETWEEN period_start AND period_end",
                array(
                    'period_start',
                    'period_end'
                )
            );

    }

    function get_last_accounting_closed_date(){
        $m_period=$this->Accounting_period_model;

        return $m_period->get_list(
            null,
            array(
                'MAX(period_end) as last_closed_date'
            ),
            null,
            null,
            null,
            TRUE,
            null,
            'NOT ISNULL(last_closed_date)'
        );
    }


    function get_journal_first_txn_date(){
        $m_journal=$this->Journal_info_model;

        return $m_journal->get_list(
            null,
            array(
                'MIN(date_txn)as first_txn_date'
            ),
            null,
            null,
            null,
            TRUE,
            null,
            'NOT ISNULL(first_txn_date)'
        );
    }

    function format_display($balance){
        $balance=(float)$balance;
        if($balance<0){
            $balance=str_replace("-","",$balance);
            return "(".number_format($balance,2).")";
        }else{
            return number_format($balance,2);
        }

    }


function export_excel() {

                $double_underline = array(
                      'font'  => array(
                        'underline' => 'doubleAccounting'
                      )
                );
                $single_underline = array(
                      'font'  => array(
                        'underline' => 'singleAccounting'
                      )
                );


                $as_of_date=date("Y-m-d",strtotime($this->input->get('date',TRUE)));
                $department_id=$this->input->get('depid',TRUE);
                $type=$this->input->get('type',TRUE);

                $net_income_period=$this->get_period_on_closed_txn($as_of_date);
                if(count($net_income_period)>0){ //if specified date is between the closed period
                    $net_income_start=date("Y-m-d",strtotime($net_income_period[0]->period_start));
                    $net_income_end=date("Y-m-d",strtotime($as_of_date));
                }else{
                    //if date specified is not found on "closed accounting period"

                    //get the last closed date
                    $last_closed=$this->get_last_accounting_closed_date();
                    if(count($last_closed)>0){

                        $net_income_start=date("Y-m-d",strtotime("1 days",strtotime($last_closed[0]->last_closed_date)));
                        $net_income_end=date("Y-m-d",strtotime($as_of_date));

                        //make sure new start date base on the last closed date is not greater than to the specified date
                        if($net_income_start>$net_income_end){ //if greater than
                            $first_journal_txn=$this->get_journal_first_txn_date();
                            if(count($first_journal_txn)>0){ //there is journal transaction


                                $net_income_start=date("Y-m-d",strtotime($first_journal_txn[0]->first_txn_date));
                                $net_income_end=date("Y-m-d",strtotime($as_of_date));

                                //make sure journal first date is not greater than "as of date"
                                if($net_income_start>$net_income_end){
                                    $net_income_start=$net_income_end;
                                }

                            }else{ //if no transaction found

                                $net_income_start=date("Y-m-d",strtotime(date('Y',strtotime($as_of_date)))."-01-01"); //set it to january 1, of specified date
                                $net_income_end=date("Y-m-d",strtotime($as_of_date));
                            }

                        }

                    }else{
                        $first_journal_txn=$this->get_journal_first_txn_date();
                        if(count($first_journal_txn)>0){ //there is journal transaction


                            $net_income_start=date("Y-m-d",strtotime($first_journal_txn[0]->first_txn_date));
                            $net_income_end=date("Y-m-d",strtotime($as_of_date));

                            //make sure journal first date is not greater than "as of date"
                            if($net_income_start>$net_income_end){
                                $net_income_start=$net_income_end;
                            }

                        }else{ //if no transaction found

                            $net_income_start=date("Y-m-d",strtotime(date('Y',strtotime($as_of_date)))."-01-01"); //set it to january 1, of specified date
                            $net_income_end=date("Y-m-d",strtotime($as_of_date));
                        }

                    }
                }



                $m_journal_accounts=$this->Journal_account_model;

                //if id is 1, Main-All branches is selected, set it to null to disable filtering
                if($department_id==1){$department_id=null;}

                //get list of account classifications
                $acc_classes=$m_journal_accounts->get_bs_account_classes($as_of_date,$department_id);
                //get list of parent account
                $acc_titles=$m_journal_accounts->get_bs_parent_account_balances($as_of_date,$department_id);

                $prev_net_income=$m_journal_accounts->get_net_income($net_income_start,$department_id);

                $current_year_earnings=$m_journal_accounts->get_net_income(array(
                    $net_income_start,
                    $net_income_end
                ),$department_id);

                $date=date("M d, Y",strtotime($as_of_date));
                $net_period=date("M d, Y",strtotime($net_income_start))." to ".date("M d, Y",strtotime($net_income_end));

                $m_company=$this->Company_model;
                $company_info=$m_company->get_list();

                $dep_info=$this->Departments_model->get_list($department_id);
                $data['dep_info']=$dep_info[0];












                $excel=$this->excel;

                $excel->setActiveSheetIndex(0);
                $excel->getActiveSheet()->getStyle('D')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $excel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
                $excel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
                $excel->getActiveSheet()->getColumnDimension('E')->setWidth(15);

                $excel->getActiveSheet()->setTitle('Balance Sheet');

                $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
                                        ->setCellValue('A2',$company_info[0]->company_address)
                                        ->setCellValue('A3',$company_info[0]->email_address)
                                        ->setCellValue('A4',$company_info[0]->mobile_no);

                $excel->Align_center('A',5);
                $excel->Align_center('A',6);
                $excel->getActiveSheet()->setCellValue('A5','BALANCE SHEET')->mergeCells('A5:E5');
                $excel->getActiveSheet()->getStyle('A6')->getFont()->setItalic(true);
                $excel->getActiveSheet()->setCellValue('A6','As of date '.$date)->mergeCells('A6:E6');
                $excel->Set_bold('A',7);
                $excel->getActiveSheet()->setCellValue('A7','Total Assets');
                $i = 8;


                   $total_type=0; 
                        foreach($acc_classes as $class){ 
                            if($class->account_type_id==1){ 
                            $excel->getActiveSheet()->getStyle('B'.$i)->getFont()->setItalic(true);
                               $excel->getActiveSheet()->setCellValue('B'.$i,$class->account_class);                     

                    $i++;
                    $total_balance=0; 
                        foreach($acc_titles as $account){
                            if($class->account_class_id==$account->account_class_id){
                                $excel->Align_right('E',$i);
                                $excel->getActiveSheet()->setCellValue('C'.$i,$account->account_title);
                                $excel->getActiveSheet()->setCellValue('E'.$i,$this->format_display($account->balance));
                                $total_balance+=$account->balance; $total_type+=$account->balance;
                                $i++;
                               }
                           }
                  $excel->getActiveSheet()->getRowDimension($i)->setRowHeight(5);
                  $excel->getActiveSheet()->getStyle('E'.$i)->applyFromArray($single_underline);
                  $excel->getActiveSheet()->setCellValue('E'.$i,'   ');
                  $i++;
                  // TOTAL CURRENT ASSETS
                  $excel->Set_bold('E',$i);
                  $excel->Align_right('E',$i);
                  $excel->getActiveSheet()->getStyle('D'.$i)->getFont()->setItalic(true);
                  $excel->getActiveSheet()->setCellValue('D'.$i,'Total '.$class->account_class);
                  $excel->getActiveSheet()->getStyle('E'.$i)->applyFromArray($single_underline);
                  $excel->getActiveSheet()->setCellValue('E'.$i,$this->format_display($total_balance));
                  $i+=2;

                  // TOTAL ASSETS
                  $excel->Set_bold('E',$i);
                  $excel->Set_bold('D',$i);

                  $excel->Align_right('E',$i);
                  $excel->getActiveSheet()->getStyle('E'.$i)->applyFromArray($double_underline);
                  $excel->getActiveSheet()->setCellValue('D'.$i,'Total Assets');
                  $excel->getActiveSheet()->setCellValue('E'.$i, $this->format_display($total_type));

                    }
                 } 

                $i+=3;

                $excel->Set_bold('A',$i);
                $excel->getActiveSheet()->setCellValue('A'.$i,'Total Liabilities and Equities');
                $i++;
                $total_type=0; 
                        foreach($acc_classes as $class){ 
                            if($class->account_type_id==2||$class->account_type_id==3){
                                $excel->getActiveSheet()->getStyle('B'.$i)->getFont()->setItalic(true);
                                $excel->getActiveSheet()->setCellValue('B'.$i,$class->account_class);                        

                    $i++;
                    $total_balance=0; 
                        foreach($acc_titles as $account){
                            if($class->account_class_id==$account->account_class_id){
                                $excel->Align_right('E',$i);
                                $excel->getActiveSheet()->setCellValue('C'.$i,$account->account_title);
                                $excel->getActiveSheet()->setCellValue('E'.$i,$this->format_display($account->balance));
                                $total_balance+=$account->balance; $total_type+=$account->balance;
                                $i++;
                               }
                           }
                  $excel->getActiveSheet()->getRowDimension($i)->setRowHeight(5);
                  $excel->getActiveSheet()->getStyle('E'.$i)->applyFromArray($single_underline);
                  $excel->getActiveSheet()->setCellValue('E'.$i,'   ');
                  $i++;
                  // TOTAL CURRENT LIABILITIES
                  $excel->getActiveSheet()->getStyle('E'.$i)->applyFromArray($single_underline);
                  $excel->Set_bold('E',$i);
                  $excel->Align_right('E',$i);
                  $excel->getActiveSheet()->getStyle('D'.$i)->getFont()->setItalic(true);
                  
                  $excel->getActiveSheet()->setCellValue('D'.$i,'Total '.$class->account_class);
                  $excel->getActiveSheet()->setCellValue('E'.$i,$this->format_display($total_balance));
                  $i++;

                  $excel->Set_bold('E',$i);
                  $excel->Align_right('E',$i);
                  $excel->getActiveSheet()->getStyle('D'.$i)->getFont()->setItalic(true);
                  $excel->getActiveSheet()->getStyle('E'.$i)->applyFromArray($single_underline);
                  $excel->getActiveSheet()->setCellValue('D'.$i,'Retained Earnings (forwarded previous net income)');
                  $excel->getActiveSheet()->setCellValue('E'.$i,$this->format_display($prev_net_income));
                  $i++;

                  $excel->Set_bold('E',$i);
                  $excel->Align_right('E',$i);
                  $excel->getActiveSheet()->getStyle('D'.$i)->getFont()->setItalic(true);
                  $excel->getActiveSheet()->getStyle('E'.$i)->applyFromArray($single_underline);
                  $excel->getActiveSheet()->setCellValue('D'.$i,'Current Period Earnings ('.$net_period.')');
                  $excel->getActiveSheet()->setCellValue('E'.$i,$this->format_display($current_year_earnings));


                  $i+=2;
                  $excel->Set_bold('E',$i);
                  $excel->Align_right('E',$i);
                  $excel->Set_bold('D',$i);
                  $excel->getActiveSheet()->setCellValue('D'.$i,'Total Liabilites and Equities');
                  $excel->getActiveSheet()->getStyle('E'.$i)->applyFromArray($double_underline);
                  $excel->getActiveSheet()->setCellValue('E'.$i,$this->format_display($total_type+$current_year_earnings+$prev_net_income));
                    }
                 } 



                // Redirect output to a client’s web browser (Excel2007)
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="Balance Sheet.xlsx"');
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


}
