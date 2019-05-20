<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Service_disconnection extends CORE_Controller {
    function __construct() {
        parent::__construct('');
        $this->validate_session();
        $this->load->model('Service_disconnection_model');
        $this->load->model('Service_connection_model');
        $this->load->model('Meter_inventory_model');
        $this->load->model('Customers_model');
        $this->load->model('Users_model');
        $this->load->model('Trans_model');
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

            case 'accounts':
                $customer_id = $this->input->get('customer_id',TRUE);
                $response['data']=$this->Service_disconnection_model->accounts($customer_id);
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
                $m_disconnection->last_meter_reading=$this->input->post('last_meter_reading',TRUE);
                $m_disconnection->disconnection_notes=$this->input->post('disconnection_notes',TRUE);
                $m_disconnection->previous_id=$this->input->post('previous_id',TRUE);
                $m_disconnection->previous_status_id=$status_id;
                $m_disconnection->created_by=$this->session->user_id;
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

                // ## Previous Connection Data
                $prev_data = $this->Service_disconnection_model->getList($disconnection_id);
                $prev_connection_id = $prev_data[0]->connection_id;
                $prev_meter_inventory_id = $prev_data[0]->meter_inventory_id;
                $disconnection_code = $prev_data[0]->disconnection_code;
                $previous_id = $prev_data[0]->previous_id;
                $previous_status_id = $prev_data[0]->previous_status_id;

                // ## New Connection Data
                $new_data = $this->Service_connection_model->getList($connection_id);
                $new_connection_id = $new_data[0]->connection_id;
                $new_meter_inventory_id = $new_data[0]->meter_inventory_id;
                $customer_id = $new_data[0]->customer_id;
                $serial_no = $new_data[0]->serial_no;
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

                if ($connection_id != $prev_connection_id){
                    // Update previous connection status and current id
                    $m_connection->status_id=$previous_status_id; // Connected or Reconnected
                    $m_connection->current_id=$previous_id;
                    $m_connection->modify($prev_connection_id);

                    // Update new connection status and current id
                    $m_connection->status_id=2; // Disconnected
                    $m_connection->current_id=$disconnection_id;
                    $m_connection->modify($new_connection_id);

                    // Update Previous Meter Inventory Status 
                    $m_meter_inventory = $this->Meter_inventory_model;
                    $m_meter_inventory->meter_status_id=1; // Active Status
                    $m_meter_inventory->modify($prev_meter_inventory_id);

                    // Update New Meter Inventory Status
                    $m_meter_inventory = $this->Meter_inventory_model;
                    $m_meter_inventory->meter_status_id=2; // Inactive Status
                    $m_meter_inventory->modify($new_meter_inventory_id);     
                }           

                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Service Disconnection Information successfully updated.';
                $response['row_updated']= $m_disconnection->getList($disconnection_id);

                $customer = $this->Customers_model->get_list($customer_id);            
                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=2; //CRUD
                $m_trans->trans_type_id=70; // TRANS TYPE
                $m_trans->trans_log='Updated Disconnection: '.$disconnection_code.' - '.$customer[0]->customer_name.' ('.$serial_no.') ';
                $m_trans->save();

                echo json_encode($response);

                break;

            case 'delete':
                $m_disconnection=$this->Service_disconnection_model;
                $m_connection=$this->Service_connection_model;

                $disconnection_id=$this->input->post('disconnection_id',TRUE);
                $data = $m_disconnection->getList($disconnection_id);
                $disconnection_code = $data[0]->disconnection_code;

                $m_disconnection->is_deleted=1;
                if($m_disconnection->modify($disconnection_id)){
                    $response['title']='Success!';
                    $response['stat']='success';
                    $response['msg']='Disconnection Information successfully deleted.';

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
        }
    }
}
