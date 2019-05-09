<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ServiceConnection extends CORE_Controller {

    function __construct() {
        parent::__construct('');
        $this->validate_session();

        $this->load->model('Service_connection_model');
        $this->load->model('Meter_inventory_model');
        $this->load->model('Customers_model');
        $this->load->model('Contract_type_model');
        $this->load->model('Rate_type_model');
        $this->load->model('Users_model');
        $this->load->model('Trans_model');
        $this->load->model('Company_model');

        $this->load->library('excel');
    }

    public function index() {
        $this->Users_model->validate();
        $data['_def_css_files']=$this->load->view('template/assets/css_files','',TRUE);
        $data['_def_js_files']=$this->load->view('template/assets/js_files','',TRUE);
        $data['_switcher_settings']=$this->load->view('template/elements/switcher','',TRUE);
        $data['_side_bar_navigation']=$this->load->view('template/elements/side_bar_navigation','',TRUE);
        $data['_top_navigation']=$this->load->view('template/elements/top_navigation','',TRUE);
        $data['title']='Service Connection Management';
        $data['customers']=$this->Customers_model->get_list(
            array('customers.is_deleted'=>FALSE)
        );
        $data['contract_types']=$this->Contract_type_model->get_list(
            array('contract_types.is_deleted'=>FALSE,'contract_types.is_active'=>TRUE)
        );
        $data['rate_types']=$this->Rate_type_model->get_list(
            array('rate_types.is_deleted'=>FALSE,'rate_types.is_active'=>TRUE)
        );

        (in_array('5-4',$this->session->user_rights)? 
        $this->load->view('service_connection_view',$data)
        :redirect(base_url('dashboard')));
        
    }


    function transaction($txn=null) {
        switch($txn) {
            case 'list':
                $m_connection=$this->Service_connection_model;
                $response['data']=$m_connection->get_list(
                    array('service_connection.is_deleted'=>FALSE,'service_connection.is_active'=>TRUE),
                    'service_connection.*, customers.customer_id, customers.customer_name, contract_types.*, rate_types.*',

                    array(
                        array('customers','customers.customer_id=service_connection.customer_id','left'),
                        array('contract_types','contract_types.contract_type_id=service_connection.contract_type_id','left'),
                        array('rate_types','rate_types.rate_type_id=service_connection.rate_type_id','left')
                    )
                );
                echo json_encode($response);

                break;

            case 'create':
                $m_meter_inventory=$this->Meter_inventory_model;

                $customer_id = $this->input->post('customer_id',TRUE);
                $m_meter_inventory->set('date_created','NOW()');

                $m_meter_inventory->serial_no=$this->input->post('serial_no',TRUE);
                $m_meter_inventory->meter_description=$this->input->post('meter_description',TRUE);
                $m_meter_inventory->customer_id=$customer_id;

                $m_meter_inventory->created_by=$this->session->user_id;
                $m_meter_inventory->save();

                $meter_inventory_id=$m_meter_inventory->last_insert_id();

                //update po meter code on formatted last insert id
                $meter_code='MC-'.date('Ymd').'-'.$meter_inventory_id;
                $m_meter_inventory->meter_code=$meter_code;
                $m_meter_inventory->modify($meter_inventory_id);

                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Meter Inventory Information successfully created.';
                $response['row_added']= $m_meter_inventory->get_list(
                    $meter_inventory_id,
                    'meter_inventory.*, customers.customer_id, customers.customer_name',
                    array(
                        array('customers','customers.customer_id=meter_inventory.customer_id','left')
                    )
                );

                $customer = $this->Customers_model->get_list($customer_id);            
                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=1; //CRUD
                $m_trans->trans_type_id=68; // TRANS TYPE
                $m_trans->trans_log='Created Meter Inventory: '.$meter_code.' - '.$customer[0]->customer_name;
                $m_trans->save();

                echo json_encode($response);

                break;

            case 'delete':
                $m_meter_inventory=$this->Meter_inventory_model;
                $meter_inventory_id=$this->input->post('meter_inventory_id',TRUE);

                $m_meter_inventory->is_deleted=1;
                if($m_meter_inventory->modify($meter_inventory_id)){
                    $response['title']='Success!';
                    $response['stat']='success';
                    $response['msg']='Meter Inventory information successfully deleted.';
                    $m_trans=$this->Trans_model;

                    $m_trans->user_id=$this->session->user_id;
                    $m_trans->set('trans_date','NOW()');
                    $m_trans->trans_key_id=3; //CRUD
                    $m_trans->trans_type_id=68; // TRANS TYPE
                    $m_trans->trans_log='Deleted Meter Inventory: ID('.$meter_inventory_id.')';
                    $m_trans->save();

                    echo json_encode($response);
                }

                break;

            case 'update':
                $m_meter_inventory=$this->Meter_inventory_model;
                $meter_inventory_id=$this->input->post('meter_inventory_id',TRUE);

                $customer_id = $this->input->post('customer_id',TRUE);

                $m_meter_inventory->serial_no=$this->input->post('serial_no',TRUE);
                $m_meter_inventory->meter_description=$this->input->post('meter_description',TRUE);
                $m_meter_inventory->customer_id=$customer_id;

                $m_meter_inventory->modified_by=$this->session->user_id;
                $m_meter_inventory->modify($meter_inventory_id);

                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Meter Inventory Information successfully updated.';
                $response['row_updated']= $m_meter_inventory->get_list(
                    $meter_inventory_id,
                    'meter_inventory.*, customers.customer_id, customers.customer_name',
                    array(
                        array('customers','customers.customer_id=meter_inventory.customer_id','left')
                    )
                );

                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=2; //CRUD
                $m_trans->trans_type_id=68; // TRANS TYPE
                $m_trans->trans_log='Updated Meter Inventory: ID('.$meter_inventory_id.')'; 
                $m_trans->save();

                echo json_encode($response);

                break;

            case 'print-masterfile':
                $m_company_info=$this->Company_model;
                $company_info=$m_company_info->get_list();
                $data['company_info']=$company_info[0];

                $data['inventory']=$this->Meter_inventory_model->get_list('meter_inventory.is_active=TRUE AND meter_inventory.is_deleted=FALSE',
                    'meter_inventory.*,customers.customer_name,',
                    array(
                        array('customers','customers.customer_id = meter_inventory.customer_id','left')

                        ),
                    'meter_inventory.meter_code ASC'
                    );
                    $this->load->view('template/meter_masterfile_content',$data);

                break;

            case 'export-masterfile':

                $excel = $this->excel;

                $m_company_info=$this->Company_model;
                $company_info=$m_company_info->get_list();
                $data['company_info']=$company_info[0];
                $inventory=$this->Meter_inventory_model->get_list('meter_inventory.is_active=TRUE AND meter_inventory.is_deleted=FALSE',
                    'meter_inventory.*,customers.customer_name,',
                    array(
                        array('customers','customers.customer_id = meter_inventory.customer_id','left')

                        ),
                    'meter_inventory.meter_code ASC'
                    );
                $excel->setActiveSheetIndex(0);

                $excel->getActiveSheet()->getColumnDimensionByColumn('A1:B1')->setWidth('30');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A2:C2')->setWidth('50');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A3')->setWidth('30');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A4')->setWidth('40');

                //name the worksheet
                $excel->getActiveSheet()->setTitle("Meter Inventory Masterfile");
                $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->mergeCells('A1:B1');
                $excel->getActiveSheet()->mergeCells('A2:C2');
                $excel->getActiveSheet()->mergeCells('A3:B3');
                $excel->getActiveSheet()->mergeCells('A4:B4');

                $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
                                        ->setCellValue('A2',$company_info[0]->company_address)
                                        ->setCellValue('A3',$company_info[0]->landline.'/'.$company_info[0]->mobile_no)
                                        ->setCellValue('A4',$company_info[0]->email_address);

                $excel->getActiveSheet()->setCellValue('A6','Meter Inventory Masterfile')
                                        ->getStyle('A6')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('A7','')
                                        ->getStyle('A7')->getFont()->setItalic(TRUE);
                $excel->getActiveSheet()->setCellValue('A8','')
                                        ->getStyle('A8')->getFont()->setItalic(TRUE);

                $excel->getActiveSheet()->getColumnDimension('A')->setWidth('25');
                $excel->getActiveSheet()->getColumnDimension('B')->setWidth('25');
                $excel->getActiveSheet()->getColumnDimension('C')->setWidth('40');
                $excel->getActiveSheet()->getColumnDimension('D')->setWidth('40');
                $excel->getActiveSheet()->getColumnDimension('E')->setWidth('25');

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

                $excel->getActiveSheet()->setCellValue('A9','Meter Code')
                                        ->getStyle('A9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('B9','Serial No')
                                        ->getStyle('B9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('C9','Description')
                                        ->getStyle('C9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('D9','Current Assignee')
                                        ->getStyle('D9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('E9','Date Created')
                                        ->getStyle('E9')->getFont()->setBold(TRUE);

                $i=10;


                foreach ($inventory as $inventory) {
                $excel->getActiveSheet()->setCellValue('A'.$i,$inventory->meter_code)
                                        ->setCellValue('B'.$i,$inventory->serial_no)
                                        ->setCellValue('C'.$i,$inventory->meter_description)
                                        ->setCellValue('D'.$i,$inventory->customer_name)
                                        ->setCellValue('E'.$i,$inventory->date_created);
                $i++;

                }
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="Meter Inventory Masterfile '.date('M-d-Y',NOW()).'.xlsx"');
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
