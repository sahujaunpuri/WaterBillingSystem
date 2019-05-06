<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase_history extends CORE_Controller {
    function __construct() {
        parent::__construct('');
        $this->validate_session();
        // $this->load->model('Pos_integration_items_model');
        $this->load->model('Company_model');
        $this->load->model('Users_model');
        $this->load->model('Suppliers_model');
        $this->load->model('Departments_model');
        $this->load->library('M_pdf');
        $this->load->library('excel');
        $this->load->model('Email_settings_model');
        $this->load->model('Delivery_invoice_model');
    }

    public function index() {
        $this->Users_model->validate();
        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', TRUE);
        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', TRUE);
        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', TRUE);
        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', TRUE);
        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', TRUE);
        $data['title'] = 'Bar Sales Report';
        // $data['cashiers'] = $this->Pos_integration_items_model->cashier_list();
        $data['suppliers']=$this->Suppliers_model->get_list(
            'suppliers.is_active=TRUE AND suppliers.is_deleted=FALSE',
            'suppliers.*,IFNULL(tax_types.tax_rate,0)as tax_rate',
            array(
                array('tax_types','tax_types.tax_type_id=suppliers.tax_type_id','left')
            )
        );
        $data['departments']=$this->Departments_model->get_list(
            array('departments.is_active'=>TRUE,'departments.is_deleted'=>FALSE)
        );


        (in_array('2-6',$this->session->user_rights)? 
        $this->load->view('purchase_history_view', $data)
        :redirect(base_url('dashboard')));
        
    }

    function transaction($txn = null,$id_filter=null) {
        switch ($txn) {
            case 'list':
                $m_pos = $this->Pos_integration_items_model;
                $cashier=$this->input->get('cashier',TRUE);
                $from=date('Y-m-d',strtotime($this->input->get('frm',TRUE)));
                $to=date('Y-m-d',strtotime($this->input->get('to',TRUE)));
                ($cashier == '0')? $cashier = null :$cashier =$cashier ;
                $response['data'] = $m_pos->bar_sales_report_list($cashier,$from,$to);
                echo json_encode($response);
                break;

            case'delivery_list_count':  //this returns JSON of Purchase Order to be rendered on Datatable with validation of count in invoice
            $m_delivery=$this->Delivery_invoice_model;
            $department=$this->input->get('department',TRUE);
            $supplier=$this->input->get('supplier',TRUE);
            ($department == '0')? $department = null :$department =$department ;
            ($supplier == '0')? $supplier = null :$supplier =$supplier ;
                $from=date('Y-m-d',strtotime($this->input->get('frm',TRUE)));
                $to=date('Y-m-d',strtotime($this->input->get('to',TRUE)));
            $response['data']=$m_delivery->delivery_list_count($id_filter,$department,$supplier,$from,$to);

            echo json_encode($response);    

            break;

            case 'print': //cash invoice
                // $m_cash_invoice=$this->Cash_invoice_model;
                // $m_cash_invoice_items=$this->Cash_invoice_items_model;
                $m_company_info=$this->Company_model;
                $type=$this->input->get('type',TRUE);
                $company_info=$m_company_info->get_list();
                $data['company_info']=$company_info[0];
                $m_pos = $this->Pos_integration_items_model;
                $cashier=$this->input->get('cashier',TRUE);
                $from=date('Y-m-d',strtotime($this->input->get('frm',TRUE)));
                $to=date('Y-m-d',strtotime($this->input->get('to',TRUE)));
                ($cashier == '0')? $cashier = null :$cashier =$cashier ;
                $data['reports'] = $m_pos->bar_sales_report_list($cashier,$from,$to);

                $data['from'] =$from;
                $data['to'] =$to;
                $this->load->view('template/bar_sales_report_content',$data);
                // //preview on browser
                // if($type=='contentview'){
                //     $file_name='Bar Sales Report';
                //     $pdfFilePath = $file_name.".pdf"; //generate filename base on id
                //     $pdf = $this->m_pdf->load(); //pass the instance of the mpdf class
                //     $content=$this->load->view('template/bar_sales_report_content',$data,TRUE); //load the template
                //     $pdf->setFooter('{PAGENO}');
                    
                //     $pdf->WriteHTML($content);
                //     //download it.
                //     $pdf->Output();
                // }

                break;

            case 'export':
          
                    $excel=$this->excel;
                    $m_company = $this->Company_model;
                    $company_info = $m_company->get_list();
                    $data['company_info'] = $company_info[0];


                    $m_pos = $this->Pos_integration_items_model;
                    $cashier=$this->input->get('cashier',TRUE);
                    $from=date('Y-m-d',strtotime($this->input->get('frm',TRUE)));
                    $to=date('Y-m-d',strtotime($this->input->get('to',TRUE)));
                    ($cashier == '0')? $cashier = null :$cashier =$cashier ;
                    $reports = $m_pos->bar_sales_report_list($cashier,$from,$to);






                    $excel->setActiveSheetIndex(0);

                    $excel->getActiveSheet()->getColumnDimensionByColumn('A1:B1')->setWidth('30');
                    $excel->getActiveSheet()->getColumnDimensionByColumn('A2:B2')->setWidth('50');
                    $excel->getActiveSheet()->getColumnDimensionByColumn('A3')->setWidth('30');
                    $excel->getActiveSheet()->getColumnDimensionByColumn('A4')->setWidth('30');

                    //name the worksheet
                    $excel->getActiveSheet()->setTitle("Bar Sales Report");
                    $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->mergeCells('A1:B1');
                    $excel->getActiveSheet()->mergeCells('A2:B2');
                    $excel->getActiveSheet()->mergeCells('A3:B3');
                    $excel->getActiveSheet()->mergeCells('A4:B4');
                    $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
                                            ->setCellValue('A2',$company_info[0]->company_address)
                                            ->setCellValue('A3',$company_info[0]->landline.'/'.$company_info[0]->mobile_no)
                                            ->setCellValue('A4',$company_info[0]->email_address);

                    $excel->getActiveSheet()->getColumnDimensionByColumn('A6:B6')->setWidth('40');                                          
                    $excel->getActiveSheet()->mergeCells('A6:D6');
                    $excel->getActiveSheet()->setCellValue('A6','Bar Sales Report ('.$from.' - '.$to.')')
                                            ->getStyle('A6')->getFont()->setBold(TRUE)
                                            ->setSize(16);

                    $excel->getActiveSheet()->getColumnDimension('A')->setWidth('20');
                    $excel->getActiveSheet()->getColumnDimension('B')->setWidth('20');
                    $excel->getActiveSheet()->getColumnDimension('C')->setWidth('20');
                    $excel->getActiveSheet()->getColumnDimension('D')->setWidth('20');
                    $excel->getActiveSheet()->getColumnDimension('E')->setWidth('20');
                    $excel->getActiveSheet()->getColumnDimension('F')->setWidth('20');
                    $excel->getActiveSheet()->getColumnDimension('G')->setWidth('20');
                                                            
                    $i=7;
                    $excel->getActiveSheet()->setCellValue('A'.$i,'Cashier: '.($cashier=='' ? 'ALL' : $cashier))->getStyle('A'.$i);    
                    $excel->getActiveSheet()->setCellValue('B'.$i,'Date: '.$from.' - '.$to)->getStyle('B'.$i);    
                    $i=9;
                    $excel->Align_right('C',$i);
                    $excel->Align_right('D',$i);
                    $excel->Align_right('E',$i);
                    $excel->Align_right('F',$i);
                    $excel->Align_right('G',$i);
                    $excel->getActiveSheet()->setCellValue('A'.$i,'Sales Date')->getStyle('A'.$i)->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->setCellValue('B'.$i,'Cashier')->getStyle('B'.$i)->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->setCellValue('c'.$i,'Total Amount')->getStyle('C'.$i)->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->setCellValue('D'.$i,'Cash')->getStyle('D'.$i)->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->setCellValue('E'.$i,'Check')->getStyle('E'.$i)->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->setCellValue('F'.$i,'Card')->getStyle('F'.$i)->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->setCellValue('G'.$i,'Gift Check')->getStyle('G'.$i)->getFont()->setBold(TRUE);

                    $i++;
                    $total = 0;
                    $total_cash = 0;
                    $total_card = 0;
                    $total_check = 0;
                    $total_gc = 0;
                    foreach ($reports as $report) {
                        $excel->Align_right('C',$i);
                        $excel->Align_right('D',$i);
                        $excel->Align_right('E',$i);
                        $excel->Align_right('F',$i);
                        $excel->Align_right('G',$i);
                        $excel->getActiveSheet()->setCellValue('A'.$i,$report->sales_date);
                        $excel->getActiveSheet()->setCellValue('B'.$i,$report->cashier);
                        $excel->getActiveSheet()->setCellValue('c'.$i,(number_format($report->total,2) == 0 ? '0.00' : number_format($report->total,2)));
                        $excel->getActiveSheet()->setCellValue('D'.$i,(number_format($report->cash_amount,2) == 0 ? '0.00' : number_format($report->cash_amount,2)));
                        $excel->getActiveSheet()->setCellValue('E'.$i,(number_format($report->check_amount,2) == 0 ? '0.00' : number_format($report->check_amount,2)));
                        $excel->getActiveSheet()->setCellValue('F'.$i,(number_format($report->card_amount,2) == 0 ? '0.00' : number_format($report->card_amount,2)));
                        $excel->getActiveSheet()->setCellValue('G'.$i,(number_format($report->gc_amount,2) == 0 ? '0.00' : number_format($report->gc_amount,2)));
                        
                    $i++;

                   $total += $report->total ;
                   $total_cash += $report->cash_amount;
                   $total_card += $report->card_amount;
                   $total_check+= $report->check_amount;
                   $total_gc+= $report->gc_amount;
                    }

                        $excel->Align_right('C',$i);
                        $excel->Align_right('D',$i);
                        $excel->Align_right('E',$i);
                        $excel->Align_right('F',$i);
                        $excel->Align_right('G',$i);
                        $excel->getActiveSheet()->setCellValue('c'.$i,(number_format($total,2) == 0 ? '0.00' : number_format($total,2)))->getStyle('C'.$i)->getFont()->setBold(TRUE);
                        $excel->getActiveSheet()->setCellValue('D'.$i,(number_format($total_cash,2) == 0 ? '0.00' : number_format($total_cash,2)))->getStyle('D'.$i)->getFont()->setBold(TRUE);
                        $excel->getActiveSheet()->setCellValue('F'.$i,(number_format($total_card,2) == 0 ? '0.00' : number_format($total_card,2)))->getStyle('E'.$i)->getFont()->setBold(TRUE);
                        $excel->getActiveSheet()->setCellValue('E'.$i,(number_format($total_check,2) == 0 ? '0.00' : number_format($total_check,2)))->getStyle('F'.$i)->getFont()->setBold(TRUE);
                        $excel->getActiveSheet()->setCellValue('G'.$i,(number_format($total_gc,2) == 0 ? '0.00' : number_format($total_gc,2)))->getStyle('G'.$i)->getFont()->setBold(TRUE);
                        

                    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                    header('Content-Disposition: attachment;filename='."Bar Sales Report.xlsx".'');
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
                    $m_company = $this->Company_model;
                    $company_info = $m_company->get_list();
                    $data['company_info'] = $company_info[0];


                    $m_pos = $this->Pos_integration_items_model;
                    $cashier=$this->input->get('cashier',TRUE);
                    $from=date('Y-m-d',strtotime($this->input->get('frm',TRUE)));
                    $to=date('Y-m-d',strtotime($this->input->get('to',TRUE)));
                    ($cashier == '0')? $cashier = null :$cashier =$cashier ;
                    $reports = $m_pos->bar_sales_report_list($cashier,$from,$to);
                $excel=$this->excel;
                $m_email=$this->Email_settings_model;
                $filter_value = 2;
                $email=$m_email->get_list(2);    
                    $excel->setActiveSheetIndex(0);
                  ob_start();
                    $excel->getActiveSheet()->getColumnDimensionByColumn('A1:B1')->setWidth('30');
                    $excel->getActiveSheet()->getColumnDimensionByColumn('A2:B2')->setWidth('50');
                    $excel->getActiveSheet()->getColumnDimensionByColumn('A3')->setWidth('30');
                    $excel->getActiveSheet()->getColumnDimensionByColumn('A4')->setWidth('30');

                    //name the worksheet
                    $excel->getActiveSheet()->setTitle("Bar Sales Report");
                    $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->mergeCells('A1:B1');
                    $excel->getActiveSheet()->mergeCells('A2:B2');
                    $excel->getActiveSheet()->mergeCells('A3:B3');
                    $excel->getActiveSheet()->mergeCells('A4:B4');
                    $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
                                            ->setCellValue('A2',$company_info[0]->company_address)
                                            ->setCellValue('A3',$company_info[0]->landline.'/'.$company_info[0]->mobile_no)
                                            ->setCellValue('A4',$company_info[0]->email_address);

                    $excel->getActiveSheet()->getColumnDimensionByColumn('A6:B6')->setWidth('40');                                          
                    $excel->getActiveSheet()->mergeCells('A6:D6');
                    $excel->getActiveSheet()->setCellValue('A6','Bar Sales Report ('.$from.' - '.$to.')')
                                            ->getStyle('A6')->getFont()->setBold(TRUE)
                                            ->setSize(16);

                    $excel->getActiveSheet()->getColumnDimension('A')->setWidth('20');
                    $excel->getActiveSheet()->getColumnDimension('B')->setWidth('20');
                    $excel->getActiveSheet()->getColumnDimension('C')->setWidth('20');
                    $excel->getActiveSheet()->getColumnDimension('D')->setWidth('20');
                    $excel->getActiveSheet()->getColumnDimension('E')->setWidth('20');
                    $excel->getActiveSheet()->getColumnDimension('F')->setWidth('20');
                    $excel->getActiveSheet()->getColumnDimension('G')->setWidth('20');
                                                            
                    $i=7;
                    $excel->getActiveSheet()->setCellValue('A'.$i,'Cashier: '.($cashier=='' ? 'ALL' : $cashier))->getStyle('A'.$i);    
                    $excel->getActiveSheet()->setCellValue('B'.$i,'Date: '.$from.' - '.$to)->getStyle('B'.$i);    
                    $i=9;
                    $excel->Align_right('C',$i);
                    $excel->Align_right('D',$i);
                    $excel->Align_right('E',$i);
                    $excel->Align_right('F',$i);
                    $excel->Align_right('G',$i);
                    $excel->getActiveSheet()->setCellValue('A'.$i,'Sales Date')->getStyle('A'.$i)->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->setCellValue('B'.$i,'Cashier')->getStyle('B'.$i)->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->setCellValue('c'.$i,'Total Amount')->getStyle('C'.$i)->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->setCellValue('D'.$i,'Cash')->getStyle('D'.$i)->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->setCellValue('E'.$i,'Check')->getStyle('E'.$i)->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->setCellValue('F'.$i,'Card')->getStyle('F'.$i)->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->setCellValue('G'.$i,'Gift Check')->getStyle('G'.$i)->getFont()->setBold(TRUE);

                    $i++;
                    $total = 0;
                    $total_cash = 0;
                    $total_card = 0;
                    $total_check = 0;
                    $total_gc = 0;
                    foreach ($reports as $report) {
                        $excel->Align_right('C',$i);
                        $excel->Align_right('D',$i);
                        $excel->Align_right('E',$i);
                        $excel->Align_right('F',$i);
                        $excel->Align_right('G',$i);
                        $excel->getActiveSheet()->setCellValue('A'.$i,$report->sales_date);
                        $excel->getActiveSheet()->setCellValue('B'.$i,$report->cashier);
                        $excel->getActiveSheet()->setCellValue('c'.$i,(number_format($report->total,2) == 0 ? '0.00' : number_format($report->total,2)));
                        $excel->getActiveSheet()->setCellValue('D'.$i,(number_format($report->cash_amount,2) == 0 ? '0.00' : number_format($report->cash_amount,2)));
                        $excel->getActiveSheet()->setCellValue('E'.$i,(number_format($report->check_amount,2) == 0 ? '0.00' : number_format($report->check_amount,2)));
                        $excel->getActiveSheet()->setCellValue('F'.$i,(number_format($report->card_amount,2) == 0 ? '0.00' : number_format($report->card_amount,2)));
                        $excel->getActiveSheet()->setCellValue('G'.$i,(number_format($report->gc_amount,2) == 0 ? '0.00' : number_format($report->gc_amount,2)));
                        
                    $i++;

                   $total += $report->total ;
                   $total_cash += $report->cash_amount;
                   $total_card += $report->card_amount;
                   $total_check+= $report->check_amount;
                   $total_gc+= $report->gc_amount;
                    }

                        $excel->Align_right('C',$i);
                        $excel->Align_right('D',$i);
                        $excel->Align_right('E',$i);
                        $excel->Align_right('F',$i);
                        $excel->Align_right('G',$i);
                        $excel->getActiveSheet()->setCellValue('c'.$i,(number_format($total,2) == 0 ? '0.00' : number_format($total,2)))->getStyle('C'.$i)->getFont()->setBold(TRUE);
                        $excel->getActiveSheet()->setCellValue('D'.$i,(number_format($total_cash,2) == 0 ? '0.00' : number_format($total_cash,2)))->getStyle('D'.$i)->getFont()->setBold(TRUE);
                        $excel->getActiveSheet()->setCellValue('F'.$i,(number_format($total_card,2) == 0 ? '0.00' : number_format($total_card,2)))->getStyle('E'.$i)->getFont()->setBold(TRUE);
                        $excel->getActiveSheet()->setCellValue('E'.$i,(number_format($total_check,2) == 0 ? '0.00' : number_format($total_check,2)))->getStyle('F'.$i)->getFont()->setBold(TRUE);
                        $excel->getActiveSheet()->setCellValue('G'.$i,(number_format($total_gc,2) == 0 ? '0.00' : number_format($total_gc,2)))->getStyle('G'.$i)->getFont()->setBold(TRUE);
                // Redirect output to a client’s web browser (Excel2007)
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="Bar Sales Report.xlsx"');
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

                          $file_name='Bar Sales Report '.date('Y-m-d h:i:A', now());
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
                            $subject = 'Bar Sales Report';
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
