<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inventory extends CORE_Controller
{
    function __construct()
    {
        parent::__construct('');
        $this->validate_session();
        $this->load->model(
            array
            (
                'Departments_model',
                'Company_model',
                'Users_model',
                'Products_model',
                'Account_integration_model'
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
        $data['title'] = 'Inventory Report';

        $data['departments']=$this->Departments_model->get_list(array('is_deleted'=>FALSE,'is_active'=>TRUE));
        
        (in_array('15-4',$this->session->user_rights)? 
        $this->load->view('inventory_report_view',$data)
        :redirect(base_url('dashboard')));
    }



    public function transaction($txn=null){
        switch($txn){
            case 'get-inventory':
                $m_products = $this->Products_model;
                $date = date('Y-m-d',strtotime($this->input->post('date',TRUE)));
                $depid = $this->input->post('depid',TRUE);
                $currentcountfilter = $this->input->post('ccf',TRUE);

                $account_integration =$this->Account_integration_model;
                $a_i=$account_integration->get_list();
                $account =$a_i[0]->sales_invoice_inventory;
                $account_cii =$a_i[0]->cash_invoice_inventory; // Cash Invoice 
                $account_dis =$a_i[0]->dispatching_invoice_inventory; // Cash Invoice 

                // Current Quantity Current Count Filter , 1 for ALL, 2 for Greater than 0, 3 for Less than Zero
                if($currentcountfilter  == 1){ $ccf = null; }else if ($currentcountfilter  == 2) { $ccf = ' > 0'; }
                else if($currentcountfilter  == 3){ $ccf = ' < 0'; }else if($currentcountfilter  == 4){ $ccf = ' = 0';}

                $response['data']=$m_products->product_list($account,$date,null,null,null,1,null,$depid,$account_cii,$account_dis, $ccf);
                // $response['data'] = $m_products->get_product_list_inventory($date,$depid,$account);


                echo json_encode($response);
                break;

            case 'preview-inventory':
                $account_integration =$this->Account_integration_model;
                $a_i=$account_integration->get_list();
                $account =$a_i[0]->sales_invoice_inventory;
                $ci_account =$a_i[0]->cash_invoice_inventory;
                $account_dis =$a_i[0]->dispatching_invoice_inventory;

                $m_products = $this->Products_model;
                $m_department = $this->Departments_model;

                $date = date('Y-m-d',strtotime($this->input->get('date',TRUE)));
                $depid = $this->input->get('depid',TRUE);
                $info = $m_department->get_department_list($depid);
                $currentcountfilter = $this->input->get('ccf',TRUE);
                // Current Quantity Current Count Filter , 1 for ALL, 2 for Greater than 0, 3 for Less than Zero
                if($currentcountfilter  == 1){ $ccf = null; }else if ($currentcountfilter  == 2) { $ccf = ' > 0'; }
                else if($currentcountfilter  == 3){ $ccf = ' < 0'; }else if($currentcountfilter  == 4){ $ccf = ' = 0';}

                $data['products']=$m_products->product_list($account,$date,null,null,null,1,null,$depid,$ci_account,$account_dis, $ccf);
                // $data['products'] = $m_products->get_product_list_inventory($date,$depid,$account);
                $data['date'] = date('m/d/Y',strtotime($date));

                if(isset($info[0])){
                    $data['department'] =$info[0]->department_name;
                }else{
                    $data['department'] = 'All';
                }

                $m_company_info=$this->Company_model;
                $company_info=$m_company_info->get_list();
                $data['company_info']=$company_info[0];
                $this->load->view('template/batch_inventory_report',$data);
                break;

            case 'export-inventory':

                $excel = $this->excel;
                $account_integration =$this->Account_integration_model;
                $a_i=$account_integration->get_list();
                $account =$a_i[0]->sales_invoice_inventory;
                $ci_account =$a_i[0]->cash_invoice_inventory;
                $account_dis =$a_i[0]->dispatching_invoice_inventory;
                $m_products = $this->Products_model;
                $m_department = $this->Departments_model;

                $date = date('Y-m-d',strtotime($this->input->get('date',TRUE)));
                $depid = $this->input->get('depid',TRUE);
                $info = $m_department->get_department_list($depid);
                $currentcountfilter = $this->input->get('ccf',TRUE);
                // Current Quantity Current Count Filter , 1 for ALL, 2 for Greater than 0, 3 for Less than Zero
                if($currentcountfilter  == 1){ $ccf = null; }else if ($currentcountfilter  == 2) { $ccf = ' > 0'; }
                else if($currentcountfilter  == 3){ $ccf = ' < 0'; }else if($currentcountfilter  == 4){ $ccf = ' = 0';}

                if($currentcountfilter  == 1){ $ccf_data = 'All Count Items'; }else if ($currentcountfilter  == 2) { $ccf_data = 'Items Greater than Zero'; }
                else if($currentcountfilter  == 3){ $ccf_data = 'Items Less than Zero'; }else if($currentcountfilter  == 4){ $ccf_data = 'Items Equal to Zero';}

                $products=$m_products->product_list($account,$date,null,null,null,1,null,$depid,$ci_account,$account_dis,$ccf);
                $data['date'] = date('m/d/Y',strtotime($date));

                if(isset($info[0])){
                    $department =$info[0]->department_name;
                }else{
                    $department= 'All';
                }

                $m_company_info=$this->Company_model;
                $company_info=$m_company_info->get_list();
                $data['company_info']=$company_info[0];

                $excel->setActiveSheetIndex(0);

                $excel->getActiveSheet()->getColumnDimensionByColumn('A1:B1')->setWidth('30');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A2:C2')->setWidth('50');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A3')->setWidth('30');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A4')->setWidth('40');

                //name the worksheet
                $excel->getActiveSheet()->setTitle("Inventory Report");
                $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->mergeCells('A1:B1');
                $excel->getActiveSheet()->mergeCells('A2:C2');
                $excel->getActiveSheet()->mergeCells('A3:B3');
                $excel->getActiveSheet()->mergeCells('A4:B4');

                $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
                                        ->setCellValue('A2',$company_info[0]->company_address)
                                        ->setCellValue('A3',$company_info[0]->landline.'/'.$company_info[0]->mobile_no)
                                        ->setCellValue('A4',$company_info[0]->email_address);

                $excel->getActiveSheet()->setCellValue('A6','Inventory Report - '.$department)
                                        ->getStyle('A6')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('A7','As of '.$date)
                                        ->getStyle('A7')->getFont()->setItalic(TRUE);
                $excel->getActiveSheet()->setCellValue('A8',$ccf_data)
                                        ->getStyle('A8')->getFont()->setItalic(TRUE);

                $excel->getActiveSheet()->getColumnDimension('A')->setWidth('40');
                $excel->getActiveSheet()->getColumnDimension('B')->setWidth('25');
                $excel->getActiveSheet()->getColumnDimension('C')->setWidth('25');
                $excel->getActiveSheet()->getColumnDimension('D')->setWidth('25');
                $excel->getActiveSheet()->getColumnDimension('E')->setWidth('30');
    
                $excel->getActiveSheet()
                        ->getStyle('E9')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                 $style_header = array(

                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb'=>'CCFF99'),
                    ),
                    'font' => array(
                        'bold' => true,
                    )
                );


                $excel->getActiveSheet()->getStyle('A9:E9')->applyFromArray( $style_header );

                $excel->getActiveSheet()->setCellValue('A9','PLU')
                                        ->getStyle('A9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('B9','Description')
                                        ->getStyle('B9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('C9','Category')
                                        ->getStyle('C9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('D9','Unit')
                                        ->getStyle('D9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('E9','Current Qty')
                                        ->getStyle('E9')->getFont()->setBold(TRUE);

                $i=10;

                foreach($products as $product){
                        $excel->getActiveSheet()->getColumnDimension('A')->setWidth('40');
                        $excel->getActiveSheet()->getColumnDimension('B')->setWidth('50');
                        $excel->getActiveSheet()->getColumnDimension('C')->setWidth('40');
                        $excel->getActiveSheet()->getColumnDimension('D')->setWidth('25');
                        $excel->getActiveSheet()->getColumnDimension('E')->setWidth('35');

            
                        $excel->getActiveSheet()
                                ->getStyle('A'.$i)
                                ->getAlignment()
                                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                        $excel->getActiveSheet()->setCellValue('A'.$i,$product->product_code);
                        $excel->getActiveSheet()->setCellValue('B'.$i,$product->product_desc);
                        $excel->getActiveSheet()->setCellValue('C'.$i,$product->category_name);
                        $excel->getActiveSheet()->setCellValue('D'.$i,$product->parent_unit_name);

                        $excel->getActiveSheet()->getStyle('E'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');                        
                        $excel->getActiveSheet()->setCellValue('E'.$i,number_format($product->CurrentQty,2));
                        $i++;                  
                }
                if(count($products)==0){

                        $excel->getActiveSheet()->setCellValue('A'.$i,'No Records Found');

                }

                $excel->getActiveSheet()->getStyle('A'.$i.':'.'E'.$i)->applyFromArray( $style_header );

                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="Inventory Report '.date('M-d-Y',NOW()).'.xlsx"');
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


            case 'email-inventory':

                $excel = $this->excel;
                $m_email=$this->Email_settings_model;
                $email=$m_email->get_list(2);
                $account_integration =$this->Account_integration_model;
                $a_i=$account_integration->get_list();
                $account =$a_i[0]->sales_invoice_inventory;
                $ci_account =$a_i[0]->cash_invoice_inventory;
                $account_dis =$a_i[0]->dispatching_invoice_inventory;

                $m_products = $this->Products_model;
                $m_department = $this->Departments_model;

                $date = date('Y-m-d',strtotime($this->input->get('date',TRUE)));
                $depid = $this->input->get('depid',TRUE);
                $info = $m_department->get_department_list($depid);
                $currentcountfilter = $this->input->get('ccf',TRUE);
                // Current Quantity Current Count Filter , 1 for ALL, 2 for Greater than 0, 3 for Less than Zero
                if($currentcountfilter  == 1){ $ccf = null; }else if ($currentcountfilter  == 2) { $ccf = ' > 0'; }
                else if($currentcountfilter  == 3){ $ccf = ' < 0'; }else if($currentcountfilter  == 4){ $ccf = ' = 0';}

                if($currentcountfilter  == 1){ $ccf_data = 'All Count Items'; }else if ($currentcountfilter  == 2) { $ccf_data = 'Items Greater than Zero'; }
                else if($currentcountfilter  == 3){ $ccf_data = 'Items Less than Zero'; }else if($currentcountfilter  == 4){ $ccf_data = 'Items Equal to Zero';}

                $products=$m_products->product_list($account,$date,null,null,null,1,null,$depid,$ci_account,$account_dis,$ccf);
                $data['date'] = date('m/d/Y',strtotime($date));

                if(isset($info[0])){
                    $department =$info[0]->department_name;
                }else{
                    $department = 'All';
                }

                $m_company_info=$this->Company_model;
                $company_info=$m_company_info->get_list();
                $data['company_info']=$company_info[0];

                ob_start();
                $excel->setActiveSheetIndex(0);

                $excel->getActiveSheet()->getColumnDimensionByColumn('A1:B1')->setWidth('30');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A2:C2')->setWidth('50');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A3')->setWidth('30');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A4')->setWidth('40');

                //name the worksheet
                $excel->getActiveSheet()->setTitle("Inventory Report");
                $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->mergeCells('A1:B1');
                $excel->getActiveSheet()->mergeCells('A2:C2');
                $excel->getActiveSheet()->mergeCells('A3:B3');
                $excel->getActiveSheet()->mergeCells('A4:B4');

                $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
                                        ->setCellValue('A2',$company_info[0]->company_address)
                                        ->setCellValue('A3',$company_info[0]->landline.'/'.$company_info[0]->mobile_no)
                                        ->setCellValue('A4',$company_info[0]->email_address);

                $excel->getActiveSheet()->setCellValue('A6','Inventory Report - '.$department)
                                        ->getStyle('A6')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('A7','As of '.$date)
                                        ->getStyle('A7')->getFont()->setItalic(TRUE);
                $excel->getActiveSheet()->setCellValue('A8',$ccf_data)
                                        ->getStyle('A8')->getFont()->setItalic(TRUE);
                $excel->getActiveSheet()->getColumnDimension('A')->setWidth('40');
                $excel->getActiveSheet()->getColumnDimension('B')->setWidth('25');
                $excel->getActiveSheet()->getColumnDimension('C')->setWidth('25');
                $excel->getActiveSheet()->getColumnDimension('D')->setWidth('25');
                $excel->getActiveSheet()->getColumnDimension('E')->setWidth('30');
    
                $excel->getActiveSheet()
                        ->getStyle('E9')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                 $style_header = array(

                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb'=>'CCFF99'),
                    ),
                    'font' => array(
                        'bold' => true,
                    )
                );


                $excel->getActiveSheet()->getStyle('A9:E9')->applyFromArray( $style_header );

                $excel->getActiveSheet()->setCellValue('A9','PLU')
                                        ->getStyle('A9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('B9','Description')
                                        ->getStyle('B9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('C9','Category')
                                        ->getStyle('C9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('D9','Unit')
                                        ->getStyle('D9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('E9','Current Qty')
                                        ->getStyle('E9')->getFont()->setBold(TRUE);

                $i=10;

                foreach($products as $product){
                        $excel->getActiveSheet()->getColumnDimension('A')->setWidth('40');
                        $excel->getActiveSheet()->getColumnDimension('B')->setWidth('50');
                        $excel->getActiveSheet()->getColumnDimension('C')->setWidth('40');
                        $excel->getActiveSheet()->getColumnDimension('D')->setWidth('25');
                        $excel->getActiveSheet()->getColumnDimension('E')->setWidth('35');

            
                        $excel->getActiveSheet()
                                ->getStyle('A'.$i)
                                ->getAlignment()
                                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                        $excel->getActiveSheet()->setCellValue('A'.$i,$product->product_code);
                        $excel->getActiveSheet()->setCellValue('B'.$i,$product->product_desc);
                        $excel->getActiveSheet()->setCellValue('C'.$i,$product->category_name);
                        $excel->getActiveSheet()->setCellValue('D'.$i,$product->parent_unit_name);

                        $excel->getActiveSheet()->getStyle('E'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');                        
                        $excel->getActiveSheet()->setCellValue('E'.$i,number_format($product->CurrentQty,2));
                        $i++;                  
                }
                if(count($products)==0){

                        $excel->getActiveSheet()->setCellValue('A'.$i,'No Records Found');

                }

                $excel->getActiveSheet()->getStyle('A'.$i.':'.'E'.$i)->applyFromArray( $style_header );

                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="Inventory Report '.date('M-d-Y',NOW()).'.xlsx"');
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

                            $file_name='Inventory Report '.date('Y-m-d h:i:A', now());
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
                            $subject = 'Inventory Report';
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