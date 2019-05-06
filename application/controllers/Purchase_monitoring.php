<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase_monitoring extends CORE_Controller
{

    function __construct() {
        parent::__construct('');
        $this->validate_session();
        $this->load->library('excel');
        $this->load->model('Products_model');
        $this->load->model('Categories_model');
        $this->load->model('Units_model');
        $this->load->model('Item_type_model');
        $this->load->model('Account_title_model');
        $this->load->model('Refproduct_model');
        $this->load->model('Suppliers_model');
        $this->load->model('Tax_model');
        $this->load->model('Purchases_model');
        $this->load->model('Purchase_items_model');
        $this->load->model('Sales_order_model');
        $this->load->model('Sales_order_item_model');
        $this->load->model('Sales_invoice_model');
        $this->load->model('Sales_invoice_item_model');
        $this->load->model('Issuance_model');
        $this->load->model('Issuance_item_model');
        $this->load->model('Delivery_invoice_model');
        $this->load->model('Delivery_invoice_item_model');
        $this->load->model('Users_model');
        $this->load->model('Account_integration_model');
        // $this->load->model('Menu_model');
        $this->load->model('Company_model');
        $this->load->model('Email_settings_model');


                   $this->load->library('excel');

    }

    public function index() {
        $this->Users_model->validate();
        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', TRUE);
        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', TRUE);
        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', TRUE);
        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', TRUE);
        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', TRUE);
        $data['title'] = 'Purchase Monitoring';

        $data['tax_types']=$this->Tax_model->get_list();
        $data['suppliers']=$this->Suppliers_model->get_list(
            array('suppliers.is_deleted'=>FALSE),
            'suppliers.*,IFNULL(tax_types.tax_rate,0)as tax_rate',
            array(
                array('tax_types','tax_types.tax_type_id=suppliers.tax_type_id','left')
            )
        );
        $data['refproduct'] = $this->Refproduct_model->get_list(array('refproduct.is_deleted'=>FALSE));
        // $data['refmenu'] = $this->Menu_model->get_list(array('refmenu.is_deleted'=>FALSE));

        $data['categories'] = $this->Categories_model->get_list(array('categories.is_deleted'=>FALSE));
        $data['units'] = $this->Units_model->get_list(array('units.is_deleted'=>FALSE));
        $data['item_types'] = $this->Item_type_model->get_list(array('item_types.is_deleted'=>FALSE));
        $data['accounts'] = $this->Account_title_model->get_list('is_active= TRUE AND is_deleted = FALSE','account_id,account_title');
        $data['tax_types']=$this->Tax_model->get_list(array('tax_types.is_deleted'=>FALSE));
        $data['products']=$this->Products_model->get_list(array('products.is_deleted'=>FALSE));

        (in_array('2-7',$this->session->user_rights)? 
        $this->load->view('purchase_monitoring_view', $data)
        :redirect(base_url('dashboard')));
        
    }

    function transaction($txn = null) {
        switch ($txn) {
            case 'list':
                $m_delivery_invoice = $this->Delivery_invoice_model;
                $product_id = $this->input->get('product_id');
                $start_date=date('Y-m-d',strtotime($this->input->get('start_date',TRUE)));
                $end_date=date('Y-m-d',strtotime($this->input->get('end_date',TRUE)));
                $response['data']=$m_delivery_invoice->purchase_monitoring($product_id,$start_date,$end_date);
                echo json_encode($response);
                break;

            case 'report':
                $m_company=$this->Company_model;
                $company=$m_company->get_list();
                $data['company_info']=$company[0];

                $m_delivery_invoice = $this->Delivery_invoice_model;
                $product_id = $this->input->get('product_id');
                $start_date=date('Y-m-d',strtotime($this->input->get('start_date',TRUE)));
                $end_date=date('Y-m-d',strtotime($this->input->get('end_date',TRUE)));
                $data['data']=$m_delivery_invoice->purchase_monitoring($product_id,$start_date,$end_date);

                if ($product_id == null ){ 
                    $data['product_name'] = 'ALL'; 
                }else{
                    $product_info = $this->Products_model->get_list($product_id);
                    $data['product_name']=$product_info[0]->product_desc;
                }
                $data['start_date'] = $start_date;
                $data['end_date'] = $end_date;

                $this->load->view('template/purchase_monitoring_content',$data);
                break;

            case 'excel':
                $m_company=$this->Company_model;
                $company_info=$m_company->get_list();

                $m_products = $this->Products_model;
                $supplier_id = $this->input->get('sup');
                $category_id = $this->input->get('cat');

                $suppliers = $this->Suppliers_model->get_list($supplier_id);
                $categories = $this->Categories_model->get_list($category_id);

                ($supplier_id == null ? $supplier_name = 'ALL' : $supplier_name=$suppliers[0]->supplier_name);
                ($category_id == null ? $category_name = 'ALL' : $category_name=$categories[0]->category_name);
                $data=$m_products->product_list(1,null,null,$supplier_id,$category_id,null,1);
                // echo json_encode($response);
                // $this->load->view('template/product_list_report_content',$data);



                $excel=$this->excel;

                $excel->setActiveSheetIndex(0);

                $excel->getActiveSheet()->getStyle('A')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $excel->getActiveSheet()->getStyle('B')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                $excel->getActiveSheet()->getStyle('C')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $excel->getActiveSheet()->getStyle('D')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $excel->getActiveSheet()->getStyle('E')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $excel->getActiveSheet()->getStyle('F')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $excel->getActiveSheet()->getStyle('G')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $excel->getActiveSheet()->getStyle('H')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
                $excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
                $excel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
                $excel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
                $excel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
                $excel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
                $excel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
                $excel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
                $excel->getActiveSheet()->getColumnDimension('I')->setWidth(25);
                $excel->getActiveSheet()->getColumnDimension('J')->setWidth(25);
                $excel->getActiveSheet()->getColumnDimension('K')->setWidth(25);

                $excel->getActiveSheet()->getColumnDimension('L')->setWidth(25);
                $excel->getActiveSheet()->getColumnDimension('M')->setWidth(25);
                $excel->getActiveSheet()->getColumnDimension('N')->setWidth(25);
                $excel->getActiveSheet()->getColumnDimension('O')->setWidth(25);
                $excel->getActiveSheet()->getColumnDimension('P')->setWidth(25);

                $excel->getActiveSheet()->setTitle('Product List Report');

                $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
                                        ->setCellValue('A2',$company_info[0]->company_address)
                                        ->setCellValue('A3',$company_info[0]->email_address)
                                        ->setCellValue('A4',$company_info[0]->mobile_no);

                $excel->getActiveSheet()->getStyle('A8')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->getStyle('B8')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->getStyle('C8')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->getStyle('D8')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->getStyle('E8')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->getStyle('F8')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->getStyle('G8')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->getStyle('H8')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->getStyle('I8')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->getStyle('J8')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->getStyle('K8')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->getStyle('L8')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->getStyle('M8')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->getStyle('N8')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->getStyle('O8')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->getStyle('P8')->getFont()->setBold(TRUE);

            $excel->getActiveSheet()->setCellValue('A6','REORDER PRODUCT LIST (Pick-up)  ')
            ->setCellValue('C6','Supplier: '.$supplier_name)
            ->setCellValue('D6','Category: '.$category_name)

                ->setCellValue('A8','PLU')
                ->setCellValue('B8','Product Description')
                ->setCellValue('C8','Unit')
                ->setCellValue('D8','Category')
                ->setCellValue('E8','Supplier')
                ->setCellValue('F8','Minimum Stock')
                ->setCellValue('G8','Actual Stock')
                ->setCellValue('H8','Recommended Order');


                $i = 9;


                foreach ($data as $data) {
                            $excel->getActiveSheet()->setCellValue('A'.$i,$data->product_code)
                                ->setCellValue('B'.$i,$data->product_desc)
                                ->setCellValue('C'.$i,$data->unit_name)
                                ->setCellValue('D'.$i, $data->category_name)
                                ->setCellValue('E'.$i, $data->supplier_name)
                                ->setCellValue('F'.$i,number_format($data->product_warn,0))
                                ->setCellValue('G'.$i, number_format($data->CurrentQty,0))
                                ->setCellValue('H'.$i,number_format($data->recommended_qty,0));
                $i++;

                }

                $i++;

            $excel->getActiveSheet()->setCellValue('A'.$i,'Exported By: '.$this->session->user_fullname);
            $i++;
            $excel->getActiveSheet()->setCellValue('A'.$i,'Date Exported: '.date("Y-m-d H:i:s"));


                // Redirect output to a client’s web browser (Excel2007)
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="Reorder Product (Pick-list)'.date("Y-m-d H:i:s").'.xlsx"');
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

                $m_email=$this->Email_settings_model;
                $filter_value = 2;
                $email=$m_email->get_list(2);   
                $m_company=$this->Company_model;
                $company_info=$m_company->get_list();

                $m_products = $this->Products_model;
                $supplier_id = $this->input->get('sup');
                $category_id = $this->input->get('cat');

                $suppliers = $this->Suppliers_model->get_list($supplier_id);
                $categories = $this->Categories_model->get_list($category_id);

                ($supplier_id == null ? $supplier_name = 'ALL' : $supplier_name=$suppliers[0]->supplier_name);
                ($category_id == null ? $category_name = 'ALL' : $category_name=$categories[0]->category_name);
                $data=$m_products->product_list(1,null,null,$supplier_id,$category_id,null,1);
                // echo json_encode($response);

                $excel=$this->excel;
              
                $excel->setActiveSheetIndex(0);
                // SET WIDTH
                  ob_start();

                $excel->getActiveSheet()->getStyle('A')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $excel->getActiveSheet()->getStyle('B')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                $excel->getActiveSheet()->getStyle('C')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $excel->getActiveSheet()->getStyle('D')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $excel->getActiveSheet()->getStyle('E')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $excel->getActiveSheet()->getStyle('F')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $excel->getActiveSheet()->getStyle('G')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $excel->getActiveSheet()->getStyle('H')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
                $excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
                $excel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
                $excel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
                $excel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
                $excel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
                $excel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
                $excel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
                $excel->getActiveSheet()->getColumnDimension('I')->setWidth(25);
                $excel->getActiveSheet()->getColumnDimension('J')->setWidth(25);
                $excel->getActiveSheet()->getColumnDimension('K')->setWidth(25);

                $excel->getActiveSheet()->getColumnDimension('L')->setWidth(25);
                $excel->getActiveSheet()->getColumnDimension('M')->setWidth(25);
                $excel->getActiveSheet()->getColumnDimension('N')->setWidth(25);
                $excel->getActiveSheet()->getColumnDimension('O')->setWidth(25);
                $excel->getActiveSheet()->getColumnDimension('P')->setWidth(25);

                $excel->getActiveSheet()->setTitle('Product List Report');

                $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
                                        ->setCellValue('A2',$company_info[0]->company_address)
                                        ->setCellValue('A3',$company_info[0]->email_address)
                                        ->setCellValue('A4',$company_info[0]->mobile_no);

                $excel->getActiveSheet()->getStyle('A8')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->getStyle('B8')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->getStyle('C8')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->getStyle('D8')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->getStyle('E8')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->getStyle('F8')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->getStyle('G8')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->getStyle('H8')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->getStyle('I8')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->getStyle('J8')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->getStyle('K8')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->getStyle('L8')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->getStyle('M8')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->getStyle('N8')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->getStyle('O8')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->getStyle('P8')->getFont()->setBold(TRUE);

            $excel->getActiveSheet()->setCellValue('A6','REORDER PRODUCT LIST (Pick-up)  ')
            ->setCellValue('C6','Supplier: '.$supplier_name)
            ->setCellValue('D6','Category: '.$category_name)

                ->setCellValue('A8','PLU')
                ->setCellValue('B8','Product Description')
                ->setCellValue('C8','Unit')
                ->setCellValue('D8','Category')
                ->setCellValue('E8','Supplier')
                ->setCellValue('F8','Minimum Stock')
                ->setCellValue('G8','Actual Stock')
                ->setCellValue('H8','Recommended Order');


                $i = 9;


                foreach ($data as $data) {
                            $excel->getActiveSheet()->setCellValue('A'.$i,$data->product_code)
                                ->setCellValue('B'.$i,$data->product_desc)
                                ->setCellValue('C'.$i,$data->unit_name)
                                ->setCellValue('D'.$i, $data->category_name)
                                ->setCellValue('E'.$i, $data->supplier_name)
                                ->setCellValue('F'.$i,number_format($data->product_warn,0))
                                ->setCellValue('G'.$i, number_format($data->CurrentQty,0))
                                ->setCellValue('H'.$i,number_format($data->recommended_qty,0));
                $i++;

                }

                $i++;

            $excel->getActiveSheet()->setCellValue('A'.$i,'Exported By: '.$this->session->user_fullname);
            $i++;
            $excel->getActiveSheet()->setCellValue('A'.$i,'Date Exported: '.date("Y-m-d H:i:s"));

                 // Redirect output to a client’s web browser (Excel2007)
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="Reorder Product (Pick-up) '.date('Y-m-d',now()).'.xlsx"');
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
                                ob_end_clean();

                          $file_name='Reorder Product (Pick-up)'.date('Y-m-d h:i:A', now());
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
                            $subject = 'Reorder Product (Pick-list)';
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
                            $response['msg']='Please check the Email Address or your Internet Connection.';

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
