<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MeterInventory extends CORE_Controller {

    function __construct() {
        parent::__construct('');
        $this->validate_session();
        $this->load->model('Meter_inventory_model');
        $this->load->model('Customers_model');
        $this->load->model('Users_model');
        $this->load->model('Trans_model');
    }

    public function index() {
        $this->Users_model->validate();
        $data['_def_css_files']=$this->load->view('template/assets/css_files','',TRUE);
        $data['_def_js_files']=$this->load->view('template/assets/js_files','',TRUE);
        $data['_switcher_settings']=$this->load->view('template/elements/switcher','',TRUE);
        $data['_side_bar_navigation']=$this->load->view('template/elements/side_bar_navigation','',TRUE);
        $data['_top_navigation']=$this->load->view('template/elements/top_navigation','',TRUE);
        $data['title']='Meter Inventory Management';
        $data['customers']=$this->Customers_model->get_list(array('customers.is_deleted'=>FALSE));
        (in_array('5-4',$this->session->user_rights)? 
        $this->load->view('meter_inventory_view',$data)
        :redirect(base_url('dashboard')));
        
    }


    function transaction($txn=null) {
        switch($txn) {
            case 'list':
                $m_meter_inventory=$this->Meter_inventory_model;
                $response['data']=$m_meter_inventory->get_list(
                    array('meter_inventory.is_deleted'=>FALSE,'meter_inventory.is_active'=>TRUE),
                    'meter_inventory.*, customers.customer_id, customers.customer_name',

                    array(
                        array('customers','customers.customer_id=meter_inventory.customer_id','left')
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
       	}
    }
}
