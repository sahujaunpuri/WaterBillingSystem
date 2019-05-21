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
    }

    public function index() {
        $this->Users_model->validate();
        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', TRUE);
        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', TRUE);
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

        (in_array('4-3',$this->session->user_rights)? 
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
                $response['data']=$this->Service_reconnection_model->getDisconnections(null,$customer_id,2);
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

                $customer = $this->Customers_model->get_list($customer_id);            
                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=2; //CRUD
                $m_trans->trans_type_id=71; // TRANS TYPE
                $m_trans->trans_log='Updated Reconnection: '.$reconnection_code;
                $m_trans->save();

                echo json_encode($response);

                break;

            case 'delete':
                $m_disconnection=$this->Service_disconnection_model;
                $m_reconnection=$this->Service_reconnection_model;
                $m_connection=$this->Service_connection_model;

                $reconnection_id=$this->input->post('reconnection_id',TRUE);
                $data = $m_reconnection->getList($reconnection_id);
                $reconnection_code = $data[0]->reconnection_code;

                // // ## Previous Disconnection Data
                // $prev_data = $this->Service_reconnection_model->getList($reconnection_id);
                // $prev_disconnection_id = $prev_data[0]->disconnection_id;
                // $prev_connection_id = $prev_data[0]->connection_id;
                // $prev_meter_inventory_id = $prev_data[0]->meter_inventory_id;
                // $disconnection_code = $prev_data[0]->disconnection_code;

                // // ## New Disconnection Data
                // $new_data = $this->Service_disconnection_model->getList($disconnection_id);
                // $new_connection_id = $new_data[0]->connection_id;
                // $new_meter_inventory_id = $new_data[0]->meter_inventory_id;
                // $customer_id = $new_data[0]->customer_id;
                // $serial_no = $new_data[0]->serial_no;

                // if ($disconnection_id != $prev_disconnection_id){
                //     // update previous connection status and current id
                //     $m_connection->status_id=2; // Disconnected
                //     $m_connection->current_id=$prev_disconnection_id;
                //     $m_connection->modify($prev_connection_id);

                //     // update new connection status and current id
                //     $m_connection->status_id=3; // Reconnected
                //     $m_connection->current_id=$reconnection_id;
                //     $m_connection->modify($new_connection_id);

                //     // update Previous Meter Inventory Status 
                //     $m_meter_inventory = $this->Meter_inventory_model;
                //     $m_meter_inventory->meter_status_id=2; // Inactive Status
                //     $m_meter_inventory->modify($prev_meter_inventory_id);

                //     // update New Meter Inventory Status
                //     $m_meter_inventory = $this->Meter_inventory_model;
                //     $m_meter_inventory->meter_status_id=1; // Active Status
                //     $m_meter_inventory->modify($new_meter_inventory_id); 
                // }      

                $m_reconnection->is_deleted=1;
                if($m_reconnection->modify($reconnection_id)){
                    $response['title']='Success!';
                    $response['stat']='success';
                    $response['msg']='Reconnection Information successfully deleted.';

                    $m_trans=$this->Trans_model;
                    $m_trans->user_id=$this->session->user_id;
                    $m_trans->set('trans_date','NOW()');
                    $m_trans->trans_key_id=3; //CRUD
                    $m_trans->trans_type_id=71; // TRANS TYPE
                    $m_trans->trans_log='Deleted Reconnection: '.$reconnection_code;
                    $m_trans->save();

                    echo json_encode($response);
                }
                break;
        }
    }
}
