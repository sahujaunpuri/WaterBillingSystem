<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Service_disconnection extends CORE_Controller {
    function __construct() {
        parent::__construct('');
        $this->validate_session();
        $this->load->model('Service_disconnection_model');
        $this->load->model('Service_connection_model');
        $this->load->model('Meter_inventory_model');
        $this->load->model('Disconnection_reason_model');
        $this->load->model('Company_model');
        $this->load->model('Customers_model');
        $this->load->model('Users_model');
        $this->load->model('Trans_model');
        $this->load->model('Meter_reading_period_model');
        $this->load->library('excel');
        $this->load->library('M_pdf');
        
    }

    public function index() {
        $this->Users_model->validate();
        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', TRUE);
        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', TRUE);
        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', TRUE);
        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', TRUE);
        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', TRUE);
        $data['title'] = 'Disconnection Service';

        $data['customers']=$this->Customers_model->get_list(
            array('customers.is_deleted'=>FALSE)
        );

        $data['reason']=$this->Disconnection_reason_model->get_list(
            array('disconnection_reason.is_deleted'=>FALSE)
        );        

        (in_array('4-3',$this->session->user_rights)? 
        $this->load->view('service_disconnection_view', $data)
        :redirect(base_url('dashboard')));
        
    }

    function transaction($txn = null) {
        switch ($txn) {
            case 'list':
                $m_disconnection = $this->Service_disconnection_model;
                $response['data']=$m_disconnection->getList();
                echo json_encode($response);
                break;

            case 'get-latest-reading-amount':
                $m_disconnection = $this->Service_disconnection_model;
                $connection_id = $this->input->post('connection_id',TRUE);
                $consumption = $this->get_numeric_value($this->input->post('consumption',TRUE));
                $response['data']=$m_disconnection->get_disconnection_rate($connection_id,$consumption);
                echo json_encode($response);
                break;



            case 'accounts':
                $customer_id = $this->input->get('customer_id',TRUE);
                $response['data']=$this->Service_disconnection_model->accounts($customer_id);
                echo json_encode($response);
                break;

            case 'get-latest-reading':
                $connection_id = $this->input->get('connection_id',TRUE);
                $before_date   = date('Y-m-d',now());
                $response['data']= $this->Meter_reading_period_model->get_meter_reading_for_inputs($before_date,$connection_id);
                echo json_encode($response);
                break;

            case 'create':
                $m_disconnection=$this->Service_disconnection_model;
                $m_connection=$this->Service_connection_model;

                $connection_id = $this->input->post('connection_id',TRUE);
                $service_no =$this->input->post('service_no',TRUE);

                // Get connection data
                $connection_service = $m_connection->getList($connection_id);
                $meter_inventory_id = $connection_service[0]->meter_inventory_id;
                $serial_no = $connection_service[0]->serial_no;
                $customer_id = $connection_service[0]->customer_id;
                $status_id = $connection_service[0]->status_id;

                $service_date = date("Y-m-d",strtotime($this->input->post('service_date',TRUE)));
                $date_disconnection_date = date("Y-m-d",strtotime($this->input->post('date_disconnection_date',TRUE)));

                $m_disconnection->set('date_created','NOW()');
                $m_disconnection->connection_id=$connection_id;
                $m_disconnection->service_date=$service_date;
                $m_disconnection->date_disconnection_date=$date_disconnection_date;
                $m_disconnection->service_no=$service_no;
                $m_disconnection->disconnection_reason_id=$this->input->post('disconnection_reason_id',TRUE);

                $m_disconnection->disconnection_notes=$this->input->post('disconnection_notes',TRUE);
                $m_disconnection->previous_id=$this->input->post('previous_id',TRUE);
                $m_disconnection->previous_status_id=$status_id;
                $m_disconnection->created_by=$this->session->user_id;

                $m_disconnection->default_matrix_id=$this->get_numeric_value($this->input->post('default_matrix_id',TRUE));
                $m_disconnection->rate_amount=$this->get_numeric_value($this->input->post('rate_amount',TRUE));
                $m_disconnection->is_fixed=$this->get_numeric_value($this->input->post('is_fixed',TRUE));
                $m_disconnection->previous_month=$this->input->post('previous_month',TRUE);
                $m_disconnection->previous_reading=$this->get_numeric_value($this->input->post('previous_reading',TRUE));
                $m_disconnection->last_meter_reading=$this->get_numeric_value($this->input->post('last_meter_reading',TRUE));
                $m_disconnection->total_consumption=$this->get_numeric_value($this->input->post('total_consumption',TRUE));
                $m_disconnection->meter_amount_due=$this->get_numeric_value($this->input->post('meter_amount_due',TRUE));



                $m_disconnection->save();

                $disconnection_id=$m_disconnection->last_insert_id();

                //update disconnection code on formatted last insert id
                $disconnection_code='SDN-'.date('Ymd').'-'.$disconnection_id;
                $m_disconnection->disconnection_code=$disconnection_code;
                $m_disconnection->modify($disconnection_id);

                //update connection status and current id
                $m_connection->status_id=2; // Disconnected
                $m_connection->current_id=$disconnection_id;
                $m_connection->modify($connection_id);

                // Updating Meter Inventory Status
                $m_meter_inventory = $this->Meter_inventory_model;
                $m_meter_inventory->meter_status_id=2; // Inactive Status
                $m_meter_inventory->modify($meter_inventory_id);

                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Service Disconnection Information successfully created.';
                $response['row_added']= $m_disconnection->getList($disconnection_id);

                $customer = $this->Customers_model->get_list($customer_id);            
                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=1; //CRUD
                $m_trans->trans_type_id=70; // TRANS TYPE
                $m_trans->trans_log='Created New Disconnection: '.$disconnection_code.' - '.$customer[0]->customer_name.' ('.$serial_no.') ';
                $m_trans->save();

                echo json_encode($response);

                break;

            case 'update':
                $m_disconnection=$this->Service_disconnection_model;
                $m_connection=$this->Service_connection_model;

                $disconnection_id = $this->input->post('disconnection_id',TRUE);
                $connection_id = $this->input->post('connection_id',TRUE);
                $service_no =$this->input->post('service_no',TRUE);
                $disconnection_code =$this->input->post('disconnection_code',TRUE);

                // ## New Connection Data
                $new_data = $this->Service_connection_model->getList($connection_id);
                $status_id = $new_data[0]->status_id;

                $service_date = date("Y-m-d",strtotime($this->input->post('service_date',TRUE)));
                $date_disconnection_date = date("Y-m-d",strtotime($this->input->post('date_disconnection_date',TRUE)));

                $m_disconnection->connection_id=$connection_id;
                $m_disconnection->service_date=$service_date;
                $m_disconnection->date_disconnection_date=$date_disconnection_date;
                $m_disconnection->service_no=$service_no;
                $m_disconnection->disconnection_reason_id=$this->input->post('disconnection_reason_id',TRUE);
                $m_disconnection->last_meter_reading=$this->input->post('last_meter_reading',TRUE);
                $m_disconnection->disconnection_notes=$this->input->post('disconnection_notes',TRUE);
                $m_disconnection->previous_id=$this->input->post('previous_id',TRUE);
                $m_disconnection->previous_status_id=$status_id;
                $m_disconnection->modify($disconnection_id);   

                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Service Disconnection Information successfully updated.';
                $response['row_updated']= $m_disconnection->getList($disconnection_id);

                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=2; //CRUD
                $m_trans->trans_type_id=70; // TRANS TYPE
                $m_trans->trans_log='Updated Disconnection: '.$disconnection_code;
                $m_trans->save();

                echo json_encode($response);

                break;

            case 'chck_disconnection_service':
                    $m_disconnection=$this->Service_disconnection_model;
                    $m_connection=$this->Service_connection_model;

                    $disconnection_id=$this->input->post('disconnection_id',TRUE);

                    $disconnection = $m_disconnection->getList($disconnection_id);
                    $disconnection_code = $disconnection[0]->disconnection_code;

                    $mode=$this->input->post('mode',TRUE);
                    $validate = $m_disconnection->chck_disconnection($disconnection_id); // Active Reconnection
                    $validate_2 = $m_connection->getList(null,2,$disconnection_id); // Current ID

                    if (count($validate) > 0 OR count($validate_2) <= 0){
                        if ($mode == "delete"){$response['title']='Cannot delete!';}else{$response['title']='Cannot update!';}
                        $response['stat']='error';
                        $response['msg'] = 'Disconnection Service #('.$disconnection_code.') still has an active transaction.';
                    }
                    else{
                        $response['stat']='success';
                    }

                    echo json_encode($response);

                break;

            case 'delete':
                $m_disconnection=$this->Service_disconnection_model;
                $m_connection=$this->Service_connection_model;
                $m_meter_inventory=$this->Meter_inventory_model;

                $disconnection_id=$this->input->post('disconnection_id',TRUE);
                $data = $m_disconnection->getList($disconnection_id);
                $disconnection_code = $data[0]->disconnection_code;
                $connection_id = $data[0]->connection_id;
                $current_id = $data[0]->previous_id;
                $status_id = $data[0]->previous_status_id;
                $meter_inventory_id = $data[0]->meter_inventory_id;

                $m_disconnection->is_deleted=1;
                if($m_disconnection->modify($disconnection_id)){
                    $response['title']='Success!';
                    $response['stat']='success';
                    $response['msg']='Disconnection Information successfully deleted.';

                    // ## Update connection service
                    $m_connection->current_id=$current_id;
                    $m_connection->status_id=$status_id;
                    $m_connection->modify($connection_id);

                    // ## Update Meter Inventory Status
                    $m_meter_inventory->meter_status_id=1; // Active
                    $m_meter_inventory->modify($meter_inventory_id);

                    $m_trans=$this->Trans_model;
                    $m_trans->user_id=$this->session->user_id;
                    $m_trans->set('trans_date','NOW()');
                    $m_trans->trans_key_id=3; //CRUD
                    $m_trans->trans_type_id=70; // TRANS TYPE
                    $m_trans->trans_log='Deleted Disconnection: '.$disconnection_code;
                    $m_trans->save();

                    echo json_encode($response);
                }

                break;

            case 'print-masterfile':
                $m_company_info=$this->Company_model;
                $company_info=$m_company_info->get_list();
                $data['company_info']=$company_info[0];
                $data['disconnection']=$this->Service_disconnection_model->getList();
                $this->load->view('template/service_disconnection_list',$data);

                break;

            case 'export-masterfile':

                $excel = $this->excel;

                $m_company_info=$this->Company_model;
                $company_info=$m_company_info->get_list();
                $disconnection=$this->Service_disconnection_model->getList();
                $excel->setActiveSheetIndex(0);

                $excel->getActiveSheet()->getColumnDimensionByColumn('A1:B1')->setWidth('30');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A2:C2')->setWidth('50');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A3')->setWidth('30');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A4')->setWidth('40');

                //name the worksheet
                $excel->getActiveSheet()->setTitle("Service Disconnection");
                $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->mergeCells('A1:D1');
                $excel->getActiveSheet()->mergeCells('A2:D2');
                $excel->getActiveSheet()->mergeCells('A3:D3');
                $excel->getActiveSheet()->mergeCells('A4:D4');

                $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
                                        ->setCellValue('A2',$company_info[0]->company_address)
                                        ->setCellValue('A3',$company_info[0]->landline.'/'.$company_info[0]->mobile_no)
                                        ->setCellValue('A4',$company_info[0]->email_address);

                $excel->getActiveSheet()->setCellValue('A6','Service Disconnection Masterfile')
                                        ->getStyle('A6')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('A7','')
                                        ->getStyle('A7')->getFont()->setItalic(TRUE);
                $excel->getActiveSheet()->setCellValue('A8','')
                                        ->getStyle('A8')->getFont()->setItalic(TRUE);

                $excel->getActiveSheet()->getColumnDimension('A')->setWidth('5');
                $excel->getActiveSheet()->getColumnDimension('B')->setWidth('20');
                $excel->getActiveSheet()->getColumnDimension('C')->setWidth('20');
                $excel->getActiveSheet()->getColumnDimension('D')->setWidth('20');
                $excel->getActiveSheet()->getColumnDimension('E')->setWidth('30');
                $excel->getActiveSheet()->getColumnDimension('F')->setWidth('50');
                $excel->getActiveSheet()->getColumnDimension('G')->setWidth('30');
                $excel->getActiveSheet()->getColumnDimension('H')->setWidth('30');
                $excel->getActiveSheet()->getColumnDimension('I')->setWidth('20');
                $excel->getActiveSheet()->getColumnDimension('J')->setWidth('20');

                 $style_header = array(

                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb'=>'CCFF99'),
                    ),
                    'font' => array(
                        'bold' => true,
                    )
                );


                $excel->getActiveSheet()->getStyle('A9:J9')->applyFromArray( $style_header );

                $excel->getActiveSheet()->setCellValue('A9','#')
                                        ->getStyle('A9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('B9','Disconnection No')
                                        ->getStyle('B9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('C9','Contract No')
                                        ->getStyle('C9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('D9','Service Date')
                                        ->getStyle('D9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('E9','Customer')
                                        ->getStyle('E9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('F9','Address')
                                        ->getStyle('F9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('G9','Target Disconnection Date')
                                        ->getStyle('G9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('H9','Reason')
                                        ->getStyle('H9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('I9','Last Meter Reading')
                                        ->getStyle('I9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('J9','Notes')
                                        ->getStyle('J9')->getFont()->setBold(TRUE);

                $a=1;
                $i=10;

                foreach ($disconnection as $row) {
                $excel->getActiveSheet()->setCellValue('A'.$i,$a)
                                        ->setCellValue('B'.$i,$row->disconnection_code)
                                        ->setCellValue('C'.$i,$row->service_no)
                                        ->setCellValue('D'.$i,$row->service_date)
                                        ->setCellValue('E'.$i,$row->customer_name)
                                        ->setCellValue('F'.$i,$row->address)
                                        ->setCellValue('G'.$i,$row->date_disconnection_date)
                                        ->setCellValue('H'.$i,$row->reason_desc)
                                        ->setCellValue('I'.$i,$row->last_meter_reading)
                                        ->setCellValue('J'.$i,$row->disconnection_notes);
                $i++;
                $a++;

                }
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="Service Disconnection Masterfile '.date('M-d-Y',NOW()).'.xlsx"');
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

            case 'disconnection-print':
                $m_company=$this->Company_model;
                $disconnection_id=$this->input->get('id',TRUE);
                $type=$this->input->get('type',TRUE);
                $data['company_info']=$m_company->get_list()[0];
                $m_disconnection=$this->Service_disconnection_model;
                $data['dis_info'] = $m_disconnection->getList($disconnection_id)[0];
                //show only inside grid with menu button
                if($type=='fullview'||$type==null){
                    echo $this->load->view('template/service_disconnection_content_wo_header',$data,TRUE);
                    echo $this->load->view('template/service_disconnection_content_menus',$data,TRUE);
                }

                //preview on browser
                if($type=='preview'){
                    $file_name='Disconnection Service';
                    $pdfFilePath = $file_name.".pdf"; //generate filename base on id
                    $pdf = $this->m_pdf->load(); //pass the instance of the mpdf class
                    $content=$this->load->view('template/service_disconnection_content',$data,TRUE); //load the template
                    // $pdf->setFooter('{PAGENO}');
                    $pdf->WriteHTML($content);
                    //download it.
                    $pdf->Output();
                }

                break;
        }
    }
}
