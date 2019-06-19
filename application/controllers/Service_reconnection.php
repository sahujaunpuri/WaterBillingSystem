<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Service_reconnection extends CORE_Controller {
    function __construct() {
        parent::__construct('');
        $this->validate_session();
        $this->load->model('Service_connection_model');
        $this->load->model('Service_disconnection_model');
        $this->load->model('Service_reconnection_model');
        $this->load->model('Meter_inventory_model');
        $this->load->model('Rate_type_model');
        $this->load->model('Customers_model');
        $this->load->model('Users_model');
        $this->load->model('Trans_model');
        $this->load->model('Trans_services_model');
        $this->load->model('Company_model');
        $this->load->library('excel');
    }

    public function index() {
        $this->Users_model->validate();
        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', TRUE);
        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', TRUE);
        $data['_rights'] = $this->load->view('template/elements/rights', '', TRUE);
        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', TRUE);
        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', TRUE);
        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', TRUE);
        $data['title'] = 'Reconnection Service';

        $data['customers']=$this->Customers_model->get_list(
            array('customers.is_deleted'=>FALSE)
        );

        $data['rate_types']=$this->Rate_type_model->get_list(
            array('rate_types.is_deleted'=>FALSE,'rate_types.is_active'=>TRUE)
        );

        (in_array('17-3',$this->session->user_rights)? 
        $this->load->view('service_reconnection_view', $data)
        :redirect(base_url('dashboard')));
        
    }

    function transaction($txn = null) {
        switch ($txn) {
            case 'list':
                $m_reconnection = $this->Service_reconnection_model;
                $response['data']=$m_reconnection->getList();
                echo json_encode($response);
                break;

            case 'disconnections':
                $customer_id = $this->input->get('customer_id',TRUE);
                $response['data']=$this->Service_reconnection_model->getDisconnections($customer_id);
                echo json_encode($response);
                break;

            case 'create':
                $m_reconnection=$this->Service_reconnection_model;
                $m_connection=$this->Service_connection_model;

                $disconnection_id = $this->input->post('disconnection_id',TRUE);

                $prev_data=$this->Service_disconnection_model->getList($disconnection_id);
                $connection_id = $prev_data[0]->connection_id;
                $meter_inventory_id = $prev_data[0]->meter_inventory_id;
                $serial_no = $prev_data[0]->serial_no;
                $customer_id = $prev_data[0]->customer_id;

                $service_date = date("Y-m-d",strtotime($this->input->post('service_date',TRUE)));
                $date_connection_target = date("Y-m-d",strtotime($this->input->post('date_connection_target',TRUE)));

                $m_reconnection->set('date_created','NOW()');
                $m_reconnection->disconnection_id=$disconnection_id;
                $m_reconnection->service_date=$service_date;
                $m_reconnection->date_connection_target=$date_connection_target;
                $m_reconnection->time_connection_target=$this->input->post('time_connection_target',TRUE);
                $m_reconnection->rate_type_id=$this->input->post('rate_type_id',TRUE);
                $m_reconnection->created_by=$this->session->user_id;
                $m_reconnection->save();

                $reconnection_id=$m_reconnection->last_insert_id();

                //update reconnection code on formatted last insert id
                $reconnection_code='SRN-'.date('Ymd').'-'.$reconnection_id;
                $m_reconnection->reconnection_code=$reconnection_code;
                $m_reconnection->modify($reconnection_id);

                //update connection status and current id
                $m_connection->status_id=3; // Reconnected
                $m_connection->current_id=$reconnection_id;
                $m_connection->modify($connection_id);

                // Updating Meter Inventory Status
                $m_meter_inventory = $this->Meter_inventory_model;
                $m_meter_inventory->meter_status_id=1; // Active Status
                $m_meter_inventory->modify($meter_inventory_id);

                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Service Reconnection Information successfully created.';
                $response['row_added']= $m_reconnection->getList($reconnection_id);

                $customer = $this->Customers_model->get_list($customer_id);            
                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=1; //CRUD
                $m_trans->trans_type_id=71; // TRANS TYPE
                $m_trans->trans_log='Created New Reconnection: '.$reconnection_code.' - '.$customer[0]->customer_name.' ('.$serial_no.') ';
                $m_trans->save();

                // Service History
                $m_trans_services=$this->Trans_services_model;
                $m_trans_services->user_id=$this->session->user_id;
                $m_trans_services->set('trans_date','NOW()');
                $m_trans_services->trans_key_id=1; //CRUD
                $m_trans_services->trans_type_id=3; // TRANS TYPE
                $m_trans_services->connection_id=$connection_id; // TRANS TYPE
                $m_trans_services->trans_log='Created New Reconnection: ('.$reconnection_code.')';
                $m_trans_services->save();

                echo json_encode($response);

                break;

            case 'update':
                $m_disconnection=$this->Service_disconnection_model;
                $m_reconnection=$this->Service_reconnection_model;
                $m_connection=$this->Service_connection_model;

                $reconnection_id = $this->input->post('reconnection_id',TRUE);
                $disconnection_id = $this->input->post('disconnection_id',TRUE);
                $reconnection_code = $this->input->post('reconnection_code',TRUE);

                $service_date = date("Y-m-d",strtotime($this->input->post('service_date',TRUE)));
                $date_connection_target = date("Y-m-d",strtotime($this->input->post('date_connection_target',TRUE)));

                $m_reconnection->disconnection_id=$disconnection_id;
                $m_reconnection->service_date=$service_date;
                $m_reconnection->date_connection_target=$date_connection_target;
                $m_reconnection->time_connection_target=$this->input->post('time_connection_target',TRUE);
                $m_reconnection->rate_type_id=$this->input->post('rate_type_id',TRUE);
                $m_reconnection->modify($reconnection_id);         

                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Service Reconnection Information successfully updated.';
                $response['row_updated']= $m_reconnection->getList($reconnection_id);
        
                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=2; //CRUD
                $m_trans->trans_type_id=71; // TRANS TYPE
                $m_trans->trans_log='Updated Reconnection: ID('.$reconnection_id.')';
                $m_trans->save();

                echo json_encode($response);

                break;

            case 'chck_reconnection_service':
                    $m_reconnection=$this->Service_reconnection_model;
                    $m_connection=$this->Service_connection_model;

                    $reconnection_id=$this->input->post('reconnection_id',TRUE);
                    $mode=$this->input->post('mode',TRUE);

                    $reconnection = $m_reconnection->getList($reconnection_id);
                    $reconnection_code = $reconnection[0]->reconnection_code;

                    $validate = $m_reconnection->chck_reconnection($reconnection_id); // Reconnection that have active disconnection
                    $validate_2 = $m_connection->getList(null,3,$reconnection_id); // Current ID

                    if (count($validate) > 0 OR count($validate_2) <= 0){
                        if ($mode == "delete"){$response['title']='Cannot delete!';}else{$response['title']='Cannot update!';}
                        $response['stat']='error';
                        $response['msg'] = 'Reconnection Service #('.$reconnection_code.') still has an active transaction.';
                    }else{
                        $response['stat']='success';
                    }

                    echo json_encode($response);

                break;

            case 'delete':
                $m_disconnection=$this->Service_disconnection_model;
                $m_reconnection=$this->Service_reconnection_model;
                $m_connection=$this->Service_connection_model;
                $m_meter_inventory = $this->Meter_inventory_model;

                $reconnection_id=$this->input->post('reconnection_id',TRUE);
                $data = $m_reconnection->getList($reconnection_id);
                $reconnection_code = $data[0]->reconnection_code;
                $disconnection_id = $data[0]->disconnection_id;
                $connection_id = $data[0]->connection_id;
                $meter_inventory_id = $data[0]->meter_inventory_id;

                $m_reconnection->is_deleted=1;
                if($m_reconnection->modify($reconnection_id)){
                    $response['title']='Success!';
                    $response['stat']='success';
                    $response['msg']='Reconnection Information successfully deleted.';

                    // Update Connection Current Status
                    $m_connection->status_id=2; // Disconnected
                    $m_connection->current_id=$disconnection_id;
                    $m_connection->modify($connection_id);

                    // Update Meter Inventory Status
                    $m_meter_inventory->meter_status_id=2; // Inactive Status
                    $m_meter_inventory->modify($meter_inventory_id);      

                    $m_trans=$this->Trans_model;
                    $m_trans->user_id=$this->session->user_id;
                    $m_trans->set('trans_date','NOW()');
                    $m_trans->trans_key_id=3; //CRUD
                    $m_trans->trans_type_id=71; // TRANS TYPE
                    $m_trans->trans_log='Deleted Reconnection: ID('.$reconnection_id.')';
                    $m_trans->save();

                    // Service History
                    $m_trans_services=$this->Trans_services_model;
                    $m_trans_services->user_id=$this->session->user_id;
                    $m_trans_services->set('trans_date','NOW()');
                    $m_trans_services->trans_key_id=2; //CRUD
                    $m_trans_services->trans_type_id=3; // TRANS TYPE
                    $m_trans_services->connection_id=$connection_id; // TRANS TYPE
                    $m_trans_services->trans_log='Deleted Reconnection: ('.$reconnection_code.')';
                    $m_trans_services->save();
                        echo json_encode($response);
                    }
                break;

            case 'print-masterfile':
                $m_company_info=$this->Company_model;
                $company_info=$m_company_info->get_list();
                $data['company_info']=$company_info[0];
                $data['reconnection']=$this->Service_reconnection_model->getList();
                $this->load->view('template/service_reconnection_list',$data);

                break;

            case 'export-masterfile':

                $excel = $this->excel;

                $m_company_info=$this->Company_model;
                $company_info=$m_company_info->get_list();
                $reconnection=$this->Service_reconnection_model->getList();
                $excel->setActiveSheetIndex(0);

                $excel->getActiveSheet()->getColumnDimensionByColumn('A1:B1')->setWidth('30');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A2:C2')->setWidth('50');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A3')->setWidth('30');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A4')->setWidth('40');

                //name the worksheet
                $excel->getActiveSheet()->setTitle("Service Reconnection");
                $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->mergeCells('A1:D1');
                $excel->getActiveSheet()->mergeCells('A2:D2');
                $excel->getActiveSheet()->mergeCells('A3:D3');
                $excel->getActiveSheet()->mergeCells('A4:D4');

                $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
                                        ->setCellValue('A2',$company_info[0]->company_address)
                                        ->setCellValue('A3',$company_info[0]->landline.'/'.$company_info[0]->mobile_no)
                                        ->setCellValue('A4',$company_info[0]->email_address);

                $excel->getActiveSheet()->setCellValue('A6','Service Reconnection Masterfile')
                                        ->getStyle('A6')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('A7','')
                                        ->getStyle('A7')->getFont()->setItalic(TRUE);
                $excel->getActiveSheet()->setCellValue('A8','')
                                        ->getStyle('A8')->getFont()->setItalic(TRUE);

                $excel->getActiveSheet()->getColumnDimension('A')->setWidth('5');
                $excel->getActiveSheet()->getColumnDimension('B')->setWidth('20');
                $excel->getActiveSheet()->getColumnDimension('C')->setWidth('20');
                $excel->getActiveSheet()->getColumnDimension('D')->setWidth('20');
                $excel->getActiveSheet()->getColumnDimension('E')->setWidth('20');
                $excel->getActiveSheet()->getColumnDimension('F')->setWidth('30');
                $excel->getActiveSheet()->getColumnDimension('G')->setWidth('50');
                $excel->getActiveSheet()->getColumnDimension('H')->setWidth('20');
                $excel->getActiveSheet()->getColumnDimension('I')->setWidth('20');
                $excel->getActiveSheet()->getColumnDimension('J')->setWidth('20');
                $excel->getActiveSheet()->getColumnDimension('K')->setWidth('20');

                 $style_header = array(

                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb'=>'CCFF99'),
                    ),
                    'font' => array(
                        'bold' => true,
                    )
                );

                $excel->getActiveSheet()->getStyle('A9:K9')->applyFromArray( $style_header );

                $excel->getActiveSheet()->setCellValue('A9','#')
                                        ->getStyle('A9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('B9','Reconnection No')
                                        ->getStyle('B9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('C9','Contract No')
                                        ->getStyle('C9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('D9','Service Date')
                                        ->getStyle('D9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('E9','Date Disconnected')
                                        ->getStyle('E9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('F9','Customer')
                                        ->getStyle('F9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('G9','Address')
                                        ->getStyle('G9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('H9','Contract Type')
                                        ->getStyle('H9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('I9','Rate Type')
                                        ->getStyle('I9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('J9','Target Connection Date & Time')
                                        ->getStyle('J9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('K9','New Rate Type')
                                        ->getStyle('K9')->getFont()->setBold(TRUE);

                $a=1;
                $i=10;

                foreach ($reconnection as $row) {
                $excel->getActiveSheet()->setCellValue('A'.$i,$a)
                                        ->setCellValue('B'.$i,$row->reconnection_code)
                                        ->setCellValue('C'.$i,$row->disconnection_code)
                                        ->setCellValue('D'.$i,$row->service_date)
                                        ->setCellValue('E'.$i,$row->date_disconnection_date)
                                        ->setCellValue('F'.$i,$row->customer_name)
                                        ->setCellValue('G'.$i,$row->address)
                                        ->setCellValue('H'.$i,$row->contract_type_name)
                                        ->setCellValue('I'.$i,$row->rate_type_name)
                                        ->setCellValue('J'.$i,$row->date_connection_target.' '.$row->time_connection_target)
                                        ->setCellValue('K'.$i,$row->new_rate_type);
                $i++;
                $a++;

                }
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="Service Reconnection Masterfile '.date('M-d-Y',NOW()).'.xlsx"');
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
        }
    }
}
