<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Locations extends CORE_Controller
{

    function __construct() {
        parent::__construct('');
        $this->validate_session();
        $this->load->model('Locations_model');
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
        $data['title'] = 'Location Management';
        (in_array('4-5',$this->session->user_rights)? 
        $this->load->view('locations_view', $data)
        :redirect(base_url('dashboard')));
        
    }

    function transaction($txn = null) {
        switch ($txn) {
            case 'list':
                $m_locations = $this->Locations_model;
                $response['data'] = $m_locations->get_location_list();
                echo json_encode($response);
                break;

            case 'create':
                $m_locations = $this->Locations_model;

                $m_locations->location_name = $this->input->post('location_name', TRUE);
                $m_locations->save();

                $location_id = $m_locations->last_insert_id();

                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=1; //CRUD
                $m_trans->trans_type_id=48; // TRANS TYPE
                $m_trans->trans_log='Created Location: '.$this->input->post('location_name', TRUE);
                $m_trans->save();


                $response['title'] = 'Success!';
                $response['stat'] = 'success';
                $response['msg'] = 'location information successfully created.';
                $response['row_added'] = $m_locations->get_location_list($location_id);
                echo json_encode($response);

                break;

            case 'delete':
                $m_locations=$this->Locations_model;

                $location_id=$this->input->post('location_id',TRUE);

                $m_locations->is_deleted=1;
                if($m_locations->modify($location_id)){
                    $response['title']='Success!';
                    $response['stat']='success';
                    $response['msg']='location information successfully deleted.';

                    $m_trans=$this->Trans_model;
                    $m_trans->user_id=$this->session->user_id;
                    $m_trans->set('trans_date','NOW()');
                    $m_trans->trans_key_id=3; //CRUD
                    $m_trans->trans_type_id=48; // TRANS TYPE
                    $m_trans->trans_log='Deleted Location: ID('.$location_id.')';
                    $m_trans->save();

                    echo json_encode($response);
                }

                break;

            case 'update':
                $m_locations=$this->Locations_model;

                $location_id=$this->input->post('location_id',TRUE);
                $m_locations->location_name=$this->input->post('location_name',TRUE);

                $m_locations->modify($location_id);

                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=2; //CRUD
                $m_trans->trans_type_id=48; // TRANS TYPE
                $m_trans->trans_log='Updated Location: '.$this->input->post('location_name',TRUE).' ID('.$location_id.')';
                $m_trans->save();

                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='location information successfully updated.';
                $response['row_updated']=$m_locations->get_location_list($location_id);
                echo json_encode($response);

                break;
        }
    }
}
