<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Meter_reading_input extends CORE_Controller
{

    function __construct() {
        parent::__construct('');
        $this->validate_session();

        $this->load->model('Other_charge_model');
        $this->load->model('Charges_model');
        $this->load->model('Users_model');
        $this->load->model('Other_charge_item_model');
        $this->load->model('Meter_reading_period_model');
        $this->load->model('Meter_reading_input_model');
        $this->load->model('Meter_reading_input_items_model');
    }

    public function index() {
        $this->Users_model->validate();
        //default resources of the active view
        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', TRUE);
        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', TRUE);
        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', TRUE);
        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', TRUE);
        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', TRUE);

        $data['charges'] = $this->Charges_model->get_list(
            array('charges.is_active'=>TRUE,'charges.is_deleted'=>FALSE), 
            array('charges.*','charge_unit.*'),
            array(
                array('charge_unit','charge_unit.charge_unit_id=charges.charge_unit_id','left')
                )   
            );

        $data['periods'] = $this->Meter_reading_period_model->get_list(array('is_active'=>TRUE,'is_deleted'=>FALSE),
        'meter_reading_period.*,
        months.month_name,
        DATE_FORMAT(meter_reading_period.meter_reading_period_start,"%m/%d/%Y") as meter_reading_period_start,
        DATE_FORMAT(meter_reading_period.meter_reading_period_end,"%m/%d/%Y") as meter_reading_period_end',
        array(
            array('months','months.month_id = meter_reading_period.month_id','left')),
        'meter_reading_period.meter_reading_year DESC, months.month_id ASC'
        );
      

        $data['title'] = 'Meter Reading Input';
        $this->load->view('meter_reading_input_view', $data);
    }


    function transaction($txn = null,$id_filter=null) {
        switch ($txn){

            //******************************************* Datatable when page loads ****************************************************************
            case 'list' :
                $response['data']= $this->response_rows_invoice('meter_reading_input.is_active=TRUE AND meter_reading_input.is_deleted=FALSE');
                echo json_encode($response);

                break;

            case 'list-inputs' :
                $response['data']= $this->Meter_reading_period_model->get_meter_reading_for_inputs();
                echo json_encode($response);
                break;

            case 'check-transaction' :
                $connection_id = $this->input->post('connection_id',TRUE);
                $meter_reading_period_id = $this->input->post('meter_reading_period_id',TRUE);
                $meter_reading_input_id = $this->input->post('meter_reading_input_id',TRUE);
                // $info= $this->Meter_reading_input_items_model->get_list(
                //     array('meter_reading_input_items.connection_id'=>$connection_id,
                //         'meter_reading_input.meter_reading_period_id'=>$meter_reading_period_id,
                //         'meter_reading_input.is_deleted'=>FALSE),
                //     'batch_no, account_no',
                //     array(
                //         array('meter_reading_input','meter_reading_input.meter_reading_input_id = meter_reading_input_items.meter_reading_input_id','left'),
                //         array(' ','    ','left')
                //         )
                //     );
                $info = $this->Meter_reading_input_items_model->validate_duplication($connection_id,$meter_reading_period_id,$meter_reading_input_id);
                if(count($info) > 0){
                    $response['stat']='error';
                    $response['batch_no']=$info[0]->batch_no;
                    $response['account_no']=$info[0]->account_no;
                    die(json_encode($response));
                }

                $response['stat'] = 'success';
                echo json_encode($response);
                break;

            ////****************************************items/products of selected Items***********************************************
            case 'items-input':

                $m_items=$this->Meter_reading_input_items_model;
                $response['data']=$m_items->get_list(
                    array('meter_reading_input_id'=>$id_filter),
                    array(
                        'meter_reading_input_items.connection_id',
                        'meter_reading_input_items.previous_reading',
                        'meter_reading_input_items.current_reading',
                        'meter_reading_input_items.total_consumption',
                        'service_connection.account_no',
                        'customers.customer_name',
                        'meter_inventory.serial_no'
                    ),
                    array(
                        array('service_connection','service_connection.connection_id=meter_reading_input_items.connection_id','left'),
                        array('customers','customers.customer_id=service_connection.customer_id','left'),
                        array('meter_inventory','meter_inventory.meter_inventory_id=service_connection.meter_inventory_id','left'),
                    ),
                    'meter_reading_input_items.meter_reading_input_item_id ASC'
                );

                echo json_encode($response);

                break;



            case 'create-batch':
                $m_invoice=$this->Meter_reading_input_model;
                $meter_reading_period_id = $this->input->post('meter_reading_period_id',TRUE);
                $m_invoice->set('date_created','NOW()');
                $m_invoice->meter_reading_period_id = $meter_reading_period_id;
                $m_invoice->date_input=date('Y-m-d',strtotime($this->input->post('date_input',TRUE)));
                $m_invoice->posted_by_user=$this->session->user_id;

                $batch_info = $this->Meter_reading_period_model->get_list($meter_reading_period_id)[0];
                $batch_id = (count($m_invoice->get_list(array('meter_reading_period_id'=>$meter_reading_period_id))) + 1);
                $month_id = str_pad($batch_info->month_id, 2, '0', STR_PAD_LEFT);
                $m_invoice->batch_no  = 'BCH-'.$batch_info->meter_reading_year.''.$month_id.'-'.$batch_id;
                $m_invoice->save();

                $meter_reading_input_id=$m_invoice->last_insert_id();
                $m_invoice_items=$this->Meter_reading_input_items_model;

                //prepare the items with multiple values for looping statement
                $connection_id = $this->input->post('connection_id');
                $previous_reading = $this->input->post('previous_reading');
                $current_reading = $this->input->post('current_reading');
                $total_consumption = $this->input->post('total_consumption');
                
                for($i=0;$i<count($connection_id);$i++){
                    $m_invoice_items->meter_reading_input_id=$meter_reading_input_id;
                    $m_invoice_items->connection_id=$this->get_numeric_value($connection_id[$i]);
                    $m_invoice_items->previous_reading=$this->get_numeric_value($previous_reading[$i]);
                    $m_invoice_items->current_reading=$this->get_numeric_value($current_reading[$i]);
                    $m_invoice_items->total_consumption=$this->get_numeric_value($total_consumption[$i]);
                    $m_invoice_items->save();
                }

            

                if($m_invoice->status()===TRUE){
                    $response['title'] = 'Success!';
                    $response['stat'] = 'success';
                    $response['msg'] = 'Batch Meter Input successfully created.';
                    $response['row_added']=$this->response_rows_invoice($meter_reading_input_id);
                    echo json_encode($response);
                }

                break;


            case 'update-batch':
                $m_invoice=$this->Meter_reading_input_model;
                $meter_reading_input_id = $this->input->post('meter_reading_input_id',TRUE);
                $m_invoice->date_input=date('Y-m-d',strtotime($this->input->post('date_input',TRUE)));

                $m_invoice->modify($meter_reading_input_id);

                $m_invoice_items=$this->Meter_reading_input_items_model;
                $m_invoice_items->delete_via_fk($meter_reading_input_id); 
                //prepare the items with multiple values for looping statement
                $connection_id = $this->input->post('connection_id');
                $previous_reading = $this->input->post('previous_reading');
                $current_reading = $this->input->post('current_reading');
                $total_consumption = $this->input->post('total_consumption');
                
                for($i=0;$i<count($connection_id);$i++){
                    $m_invoice_items->meter_reading_input_id=$meter_reading_input_id;
                    $m_invoice_items->connection_id=$this->get_numeric_value($connection_id[$i]);
                    $m_invoice_items->previous_reading=$this->get_numeric_value($previous_reading[$i]);
                    $m_invoice_items->current_reading=$this->get_numeric_value($current_reading[$i]);
                    $m_invoice_items->total_consumption=$this->get_numeric_value($total_consumption[$i]);
                    $m_invoice_items->save();
                }


                if($m_invoice->status()===TRUE){
                    $response['title'] = 'Success!';
                    $response['stat'] = 'success';
                    $response['msg'] = 'Batch Meter Input successfully updated.';
                    $response['row_updated']=$this->response_rows_invoice($meter_reading_input_id);
                    echo json_encode($response);
                }

                break;


            //***************************************************************************************
            case 'delete':
                $m_invoice=$this->Meter_reading_input_model;
                $meter_reading_input_id=$this->input->post('meter_reading_input_id',TRUE);

                //mark Items as deleted
                // $m_invoice->set('date_deleted','NOW()'); //treat NOW() as function and not string
                // $m_invoice->deleted_by_user=$this->session->user_id;//user that deleted the record
                $m_invoice->is_deleted=1;//mark as deleted
                $m_invoice->modify($meter_reading_input_id);

                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Record successfully deleted.';
                echo json_encode($response);

                break;            
        }

    }



//**************************************user defined*************************************************

    function response_rows_invoice($filter_value){
        return $this->Meter_reading_input_model->get_list(
                $filter_value,
                'meter_reading_input.*,
                meter_reading_period.*,
                DATE_FORMAT(meter_reading_input.date_input,"%m/%d/%Y") as date_input,
                months.month_name,
                CONCAT_WS(" ",user_accounts.user_fname,user_accounts.user_lname)as posted_by',
                array(
                    array('meter_reading_period','meter_reading_period.meter_reading_period_id=meter_reading_input.meter_reading_period_id','left'),
                    array('months','months.month_id=meter_reading_period.month_id','left'),
                    array('user_accounts','user_accounts.user_id=meter_reading_input.posted_by_user','left')
                )

        );
    }                           

}
