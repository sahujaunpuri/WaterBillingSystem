<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cogs extends CORE_Controller
{

    function __construct() {
        parent::__construct('');
        $this->validate_session();

        $this->load->model(array(
            'Departments_model',
            'Products_model',
            'Delivery_invoice_model',
            'Delivery_invoice_item_model',
            'Users_model',
            'Company_model'
        ));
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

        $data['title'] = 'Cost of Good Sold Report';
        $data['departments']=$this->Departments_model->get_list('is_deleted=0');
        (in_array('9-12',$this->session->user_rights)? 
        $this->load->view('cost_of_good_sold_view', $data)
        :redirect(base_url('dashboard')));
        
    }

    function transaction($txn=null){
        switch($txn){
            case 'print':
                $company_info=$this->Company_model->get_list();
                $params['company_info']=$company_info[0];
                $data['start']=$this->input->get('start',TRUE);
                $data['end']=$this->input->get('end',TRUE);
                $data['inv_begin']=$this->input->post('inv_begin');
                $data['purchases']=$this->input->post('purchases');
                $data['goodsForSale']=$this->input->post('goodsForSale');
                $data['inv_end']=$this->input->post('inv_end');
                $data['cogs']=$this->input->post('cogs');
                $data['department']=$this->Departments_model->get_list($this->input->post('department'));
                $data['company_header']=$this->load->view('template/company_header',$params,TRUE);

                $this->load->view('template/cogs_report',$data);

                break;

            case 'export':
                $excel=$this->excel;
                $company_info=$this->Company_model->get_list();
                $params['company_info']=$company_info[0];

                $start=$this->input->get('start',TRUE);
                $end=$this->input->get('end',TRUE);
                $inv_begin=$this->input->post('inv_begin');
                $purchases=$this->input->post('purchases');
                $goodsForSale=$this->input->post('goodsForSale');
                $inv_end=$this->input->post('inv_end');
                $cogs=$this->input->post('cogs');
                $department=$this->Departments_model->get_list($this->input->post('department'));

                $excel->setActiveSheetIndex(0);

                $excel->getActiveSheet()->getColumnDimensionByColumn('A1:H1')->setWidth('30');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A2:H2')->setWidth('50');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A3:H3')->setWidth('30');
               
                $excel->getActiveSheet()
                        ->getStyle('A1:H1')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $excel->getActiveSheet()
                        ->getStyle('A2:H2')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $excel->getActiveSheet()
                        ->getStyle('A3:H3')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);                            
                //name the worksheet
                $excel->getActiveSheet()->setTitle("Cost of Good Sold Report");
                $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->mergeCells('A1:H1');
                $excel->getActiveSheet()->mergeCells('A2:H2');
                $excel->getActiveSheet()->mergeCells('A3:H3');
                $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
                                        ->setCellValue('A2',$company_info[0]->company_address)
                                        ->setCellValue('A3',$company_info[0]->landline.'/'.$company_info[0]->mobile_no);  

                $excel->getActiveSheet()
                        ->getStyle('A5:H5')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 

                $excel->getActiveSheet()
                        ->getStyle('A6:H6')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 

                $excel->getActiveSheet()
                        ->getStyle('A7:I7')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


                $excel->getActiveSheet()
                        ->getStyle('E10:H10')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

               $excel->getActiveSheet()
                        ->getStyle('E11:H11')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

               $excel->getActiveSheet()
                        ->getStyle('E9:H9')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

               $excel->getActiveSheet()
                        ->getStyle('E12:H12')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);


               $excel->getActiveSheet()
                        ->getStyle('E13:H13')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()->mergeCells('A5:H5');
                $excel->getActiveSheet()->setCellValue('A5','Schedule of Cost of Goods Sold')
                                        ->getStyle('A5')->getFont()->setBold(TRUE);

                $excel->getActiveSheet()->mergeCells('A6:H6');
                $excel->getActiveSheet()->setCellValue('A6',$department[0]->department_name);

                $excel->getActiveSheet()->mergeCells('A7:H7');
                $excel->getActiveSheet()->setCellValue('A7',$start.' to '.$end);

                $excel->getActiveSheet()->mergeCells('A9:D9');
                $excel->getActiveSheet()->setCellValue('A9','Merchandise Inventory - Beginning');

                $excel->getActiveSheet()->mergeCells('E9:H9');
                $excel->getActiveSheet()->getStyle('E9')->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');                    
                $excel->getActiveSheet()->setCellValue('E9',number_format($inv_begin,2));                

                $excel->getActiveSheet()->mergeCells('A10:D10');
                $excel->getActiveSheet()->setCellValue('A10','Add : Purchases')
                                        ->getStyle('A10')->getAlignment()->setIndent(1);

                $excel->getActiveSheet()->mergeCells('E10:H10');
                $excel->getActiveSheet()->getStyle('E10')->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');                    
                $excel->getActiveSheet()->setCellValue('E10',number_format($purchases,2));  

                $BStyle = array(
                  'borders' => array(
                    'bottom' => array(
                      'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                  )
                );

                $SStyle = array(
                  'borders' => array(
                    'bottom' => array(
                      'style' => PHPExcel_Style_Border::BORDER_THICK
                    )
                  )
                );

                $BTStyle = array(
                  'borders' => array(
                    'bottom' => array(
                      'style' => PHPExcel_Style_Border::BORDER_DOUBLE 
                    )
                  )
                );

                $excel->getActiveSheet()->getStyle('G10:H10')->applyFromArray($BStyle);

                $excel->getActiveSheet()->mergeCells('A11:D11');
                $excel->getActiveSheet()->setCellValue('A11','Total Goods available for Sale')
                                        ->getStyle('A11:D11')->getFont()->setBold(TRUE);

                $excel->getActiveSheet()->mergeCells('E11:H11');
                $excel->getActiveSheet()->getStyle('E11')->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');                    
                $excel->getActiveSheet()->setCellValue('E11',number_format($goodsForSale,2))    
                                        ->getStyle('E11')->getFont()->setBold(TRUE);

                $excel->getActiveSheet()->mergeCells('A12:D12');
                $excel->getActiveSheet()->setCellValue('A12','Less : Merchandise Inventory - End')
                                        ->getStyle('A12')->getAlignment()->setIndent(1);

                $excel->getActiveSheet()->mergeCells('E12:H12');
                $excel->getActiveSheet()->getStyle('E12')->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');                    
                $excel->getActiveSheet()->setCellValue('E12',number_format($inv_end,2));   

                $excel->getActiveSheet()->getStyle('G12:H12')->applyFromArray($SStyle);

                $excel->getActiveSheet()->mergeCells('A13:D13');
                $excel->getActiveSheet()->setCellValue('A13','Cost of Goods Sold')
                                        ->getStyle('A13:D13')->getFont()->setBold(TRUE);

                $excel->getActiveSheet()->mergeCells('E13:H13');
                $excel->getActiveSheet()->getStyle('E13')->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');                    
                $excel->getActiveSheet()->setCellValue('E13',number_format($cogs,2))  
                                        ->getStyle('E13')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->getStyle('G13:H13')->applyFromArray($BTStyle);

                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename='."Cost of Goods Sold Report.xlsx".'');
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
                $company_info=$this->Company_model->get_list();
                $params['company_info']=$company_info[0];

                $start=$this->input->get('start',TRUE);
                $end=$this->input->get('end',TRUE);
                $inv_begin=$this->input->post('inv_begin');
                $purchases=$this->input->post('purchases');
                $goodsForSale=$this->input->post('goodsForSale');
                $inv_end=$this->input->post('inv_end');
                $cogs=$this->input->post('cogs');
                $department=$this->Departments_model->get_list($this->input->post('department'));

                ob_start();
                $excel->setActiveSheetIndex(0);

                $excel->getActiveSheet()->getColumnDimensionByColumn('A1:H1')->setWidth('30');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A2:H2')->setWidth('50');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A3:H3')->setWidth('30');
               
                $excel->getActiveSheet()
                        ->getStyle('A1:H1')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $excel->getActiveSheet()
                        ->getStyle('A2:H2')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $excel->getActiveSheet()
                        ->getStyle('A3:H3')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);                            
                //name the worksheet
                $excel->getActiveSheet()->setTitle("Cost of Good Sold Report");
                $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->mergeCells('A1:H1');
                $excel->getActiveSheet()->mergeCells('A2:H2');
                $excel->getActiveSheet()->mergeCells('A3:H3');
                $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
                                        ->setCellValue('A2',$company_info[0]->company_address)
                                        ->setCellValue('A3',$company_info[0]->landline.'/'.$company_info[0]->mobile_no);  

                $excel->getActiveSheet()
                        ->getStyle('A5:H5')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 

                $excel->getActiveSheet()
                        ->getStyle('A6:H6')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 

                $excel->getActiveSheet()
                        ->getStyle('A7:I7')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


                $excel->getActiveSheet()
                        ->getStyle('E10:H10')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

               $excel->getActiveSheet()
                        ->getStyle('E11:H11')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

               $excel->getActiveSheet()
                        ->getStyle('E9:H9')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

               $excel->getActiveSheet()
                        ->getStyle('E12:H12')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);


               $excel->getActiveSheet()
                        ->getStyle('E13:H13')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()->mergeCells('A5:H5');
                $excel->getActiveSheet()->setCellValue('A5','Schedule of Cost of Goods Sold')
                                        ->getStyle('A5')->getFont()->setBold(TRUE);

                $excel->getActiveSheet()->mergeCells('A6:H6');
                $excel->getActiveSheet()->setCellValue('A6',$department[0]->department_name);

                $excel->getActiveSheet()->mergeCells('A7:H7');
                $excel->getActiveSheet()->setCellValue('A7',$start.' to '.$end);

                $excel->getActiveSheet()->mergeCells('A9:D9');
                $excel->getActiveSheet()->setCellValue('A9','Merchandise Inventory - Beginning');

                $excel->getActiveSheet()->mergeCells('E9:H9');
                $excel->getActiveSheet()->getStyle('E9')->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');                    
                $excel->getActiveSheet()->setCellValue('E9',number_format($inv_begin,2));                

                $excel->getActiveSheet()->mergeCells('A10:D10');
                $excel->getActiveSheet()->setCellValue('A10','Add : Purchases')
                                        ->getStyle('A10')->getAlignment()->setIndent(1);

                $excel->getActiveSheet()->mergeCells('E10:H10');
                $excel->getActiveSheet()->getStyle('E10')->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');                    
                $excel->getActiveSheet()->setCellValue('E10',number_format($purchases,2));  

                $BStyle = array(
                  'borders' => array(
                    'bottom' => array(
                      'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                  )
                );

                $SStyle = array(
                  'borders' => array(
                    'bottom' => array(
                      'style' => PHPExcel_Style_Border::BORDER_THICK
                    )
                  )
                );

                $BTStyle = array(
                  'borders' => array(
                    'bottom' => array(
                      'style' => PHPExcel_Style_Border::BORDER_DOUBLE 
                    )
                  )
                );

                $excel->getActiveSheet()->getStyle('G10:H10')->applyFromArray($BStyle);

                $excel->getActiveSheet()->mergeCells('A11:D11');
                $excel->getActiveSheet()->setCellValue('A11','Total Goods available for Sale')
                                        ->getStyle('A11:D11')->getFont()->setBold(TRUE);

                $excel->getActiveSheet()->mergeCells('E11:H11');
                $excel->getActiveSheet()->getStyle('E11')->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');                    
                $excel->getActiveSheet()->setCellValue('E11',number_format($goodsForSale,2))    
                                        ->getStyle('E11')->getFont()->setBold(TRUE);

                $excel->getActiveSheet()->mergeCells('A12:D12');
                $excel->getActiveSheet()->setCellValue('A12','Less : Merchandise Inventory - End')
                                        ->getStyle('A12')->getAlignment()->setIndent(1);

                $excel->getActiveSheet()->mergeCells('E12:H12');
                $excel->getActiveSheet()->getStyle('E12')->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');                    
                $excel->getActiveSheet()->setCellValue('E12',number_format($inv_end,2));   

                $excel->getActiveSheet()->getStyle('G12:H12')->applyFromArray($SStyle);

                $excel->getActiveSheet()->mergeCells('A13:D13');
                $excel->getActiveSheet()->setCellValue('A13','Cost of Goods Sold')
                                        ->getStyle('A13:D13')->getFont()->setBold(TRUE);

                $excel->getActiveSheet()->mergeCells('E13:H13');
                $excel->getActiveSheet()->getStyle('E13')->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');                    
                $excel->getActiveSheet()->setCellValue('E13',number_format($cogs,2))  
                                        ->getStyle('E13')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->getStyle('G13:H13')->applyFromArray($BTStyle);

                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename='."Cost of Goods Sold Report.xlsx".'');
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

                            $file_name='Cost of Goods Sold Report '.date('Y-m-d h:i:A', now());
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
                            $subject = 'Cost of Goods Sold';
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

            case 'merchandise-inventory':
                $m_products=$this->Products_model;

                $start=$this->input->get('start',TRUE);
                $end=$this->input->get('end',TRUE);
                $depid=$this->input->get('depid',TRUE);

                $new_date=date('Y-m-d',strtotime ( '-1 day' , strtotime($start) )  );


                $response['data']=$m_products->get_inventory_costing($new_date,$depid);
                echo json_encode($response);

                break;

            case 'merchandise-inventory-ending':
                $m_products=$this->Products_model;

                $start=date('Y-m-d', strtotime($this->input->get('start',TRUE)));
                $end=date('Y-m-d', strtotime($this->input->get('end',TRUE)));
                $depid=$this->input->get('depid',TRUE);

                $response['data']=$m_products->get_inventory_costing($end,$depid);
                echo json_encode($response);

                break;

            case 'purchases':

                $m_purchases=$this->Delivery_invoice_item_model;

                $start=date('Y-m-d',strtotime($this->input->get('start',TRUE)));
                $end=date('Y-m-d',strtotime($this->input->get('end',TRUE)));
                $depid=$this->input->get('depid',TRUE);

                $response['data']=$m_purchases->get_list(

                    "di.date_delivered BETWEEN '".$start."' AND '".$end."'".($depid==1||$depid==null?"":" AND di.department_id=".$depid),

                    array(
                        'p.product_desc',
                        'delivery_invoice_items.dr_qty',
                        'FORMAT(delivery_invoice_items.dr_price,4)as dr_price',
                        'FORMAT(delivery_invoice_items.dr_line_total_price,4)as dr_line_total_price',
                        'di.dr_invoice_no',
                        'DATE_FORMAT(di.date_delivered,"%M %d, %Y")as delivered_date',
                        'di.date_delivered',
                        's.supplier_name'
                    ),
                    array(
                        array( 'delivery_invoice as di','di.dr_invoice_id=delivery_invoice_items.dr_invoice_id','left'),
                        array( 'products as p','p.product_id=delivery_invoice_items.product_id','left'),
                        array( 'suppliers as s','s.supplier_id=di.supplier_id','left')
                    )

                );
                echo json_encode($response);
                break;
        }
    }

}
