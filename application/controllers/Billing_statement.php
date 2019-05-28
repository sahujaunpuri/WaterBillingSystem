<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Billing_statement extends CORE_Controller {
    function __construct() {
        parent::__construct('');
        $this->validate_session();
        $this->load->model('Meter_inventory_model');
        $this->load->model('Meter_reading_period_model');
        $this->load->model('Meter_reading_input_model');
        $this->load->model('Customers_model');
        $this->load->model('Billing_model');
        $this->load->model('Users_model');
        $this->load->model('Trans_model');
        $this->load->model('Company_model');
        $this->load->library('excel');
    }

    public function index() {
        $this->Users_model->validate();
        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', TRUE);
        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', TRUE);
        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', TRUE);
        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', TRUE);
        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', TRUE);
        $data['title'] = 'Billing Statement';

        $data['customer'] = $this->Customers_model->get_list(array('is_active'=>TRUE,'is_deleted'=>FALSE));
        $data['batch'] = $this->Meter_reading_input_model->get_list(array('is_active'=>TRUE,'is_deleted'=>FALSE));
        $data['periods'] = $this->Meter_reading_period_model->get_list(array('is_active'=>TRUE,'is_deleted'=>FALSE),
        'meter_reading_period.*,
        months.month_name,
        DATE_FORMAT(meter_reading_period.meter_reading_period_start,"%m/%d/%Y") as meter_reading_period_start,
        DATE_FORMAT(meter_reading_period.meter_reading_period_end,"%m/%d/%Y") as meter_reading_period_end',
        array(
            array('months','months.month_id = meter_reading_period.month_id','left')),
        'meter_reading_period.meter_reading_year DESC, months.month_id ASC'
        );        

        (in_array('4-3',$this->session->user_rights)? 
        $this->load->view('billing_statement_view', $data)
        :redirect(base_url('dashboard')));
        
    }

    function transaction($txn = null) {
        switch ($txn) {
            case 'statement':

                $period_id = $this->input->get('period_id',TRUE);
                $meter_reading_input_id = $this->input->get('meter_reading_input_id',TRUE);
                $customer_id = $this->input->get('customer_id',TRUE);

                $response['data']=$this->Billing_model->billing_statement($period_id,$meter_reading_input_id,$customer_id);
                echo json_encode($response);
                break;

            case 'check_process':    
                $meter_reading_input_id = $this->input->post('meter_reading_input_id', TRUE);

                if ($meter_reading_input_id == null){
                    $response['title']='Error!';
                    $response['stat']='error';
                    $response['msg']='Select Batch No. to be Processed.';
                }else{
                    $response['stat']='success';
                }

                echo json_encode($response);
                break;

            case 'process':
                $m_billing=$this->Billing_model;
                $meter_reading_input_id = $this->input->post('meter_reading_input_id', TRUE);

                if($meter_reading_input_id!="")
                {
                    $status=$this->Billing_model->process_billing($meter_reading_input_id);
                    
                    if($status==true){
                        $response['title']='Success!';
                        $response['stat']='success';
                        $response['msg']='Billing Successfully Processed.';
                    }
                    else{
                        $response['title']='Error!';
                        $response['stat']='error';
                        $response['msg']='Billing Failed to Processed, Please Try Again.';
                    }
                }
                else
                {
                    $response['title']='Error!';
                    $response['stat']='error';
                    $response['msg']='Select Batch No. to be Processed.';
                }

                    echo json_encode($response);
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
