<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Attendant extends CORE_Controller {

    function __construct() {
        parent::__construct('');
        $this->validate_session();
        $this->load->model('Attendant_model');
        $this->load->model('Departments_model');
        $this->load->model('Users_model');
        $this->load->model('Trans_model');
    }

    public function index() {
        $this->Users_model->validate();
        $data['_def_css_files']=$this->load->view('template/assets/css_files','',TRUE);
        $data['_def_js_files']=$this->load->view('template/assets/js_files','',TRUE);
        $data['_rights'] = $this->load->view('template/elements/rights', '', TRUE);
        $data['_switcher_settings']=$this->load->view('template/elements/switcher','',TRUE);
        $data['_side_bar_navigation']=$this->load->view('template/elements/side_bar_navigation','',TRUE);
        $data['_top_navigation']=$this->load->view('template/elements/top_navigation','',TRUE);
        $data['title']='Attendant Management';
        $data['departments']=$this->Departments_model->get_list(array('departments.is_deleted'=>FALSE));
        (in_array('20-5',$this->session->user_rights)? 
        $this->load->view('attendant_view',$data)
        :redirect(base_url('dashboard')));
        
    }


    function transaction($txn=null) {
        switch($txn) {
            case 'list':
                $m_attendant=$this->Attendant_model;
                $response['data']=$m_attendant->get_list(
                    array('attendant.is_deleted'=>FALSE),
                    'attendant.*, CONCAT(attendant.last_name,", ",attendant.first_name," ",attendant.middle_name) AS full_name, departments.department_id, departments.department_name',

                    array(
                        array('departments','departments.department_id=attendant.department_id','left')
                    )
                );
                echo json_encode($response);

                break;

            case 'create':
                $m_attendant=$this->Attendant_model;

                $m_attendant->set('date_created','NOW()');

                $m_attendant->first_name=$this->input->post('first_name',TRUE);
                $m_attendant->middle_name=$this->input->post('middle_name',TRUE);
                $m_attendant->last_name=$this->input->post('last_name',TRUE);
                $m_attendant->contact_no=$this->input->post('contact_no',TRUE);
                $m_attendant->department_id=$this->input->post('department_id',TRUE);
                $m_attendant->posted_by_user=$this->session->user_id;
                $m_attendant->save();

                $attendant_id=$m_attendant->last_insert_id();

                //update no on formatted last insert id
                $attendant_code='ATD-'.date('Ymd').'-'.$attendant_id;
                $m_attendant->attendant_code = $attendant_code;
                $m_attendant->modify($attendant_id);

                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Attendant Information successfully created.';
                $response['row_added']= $m_attendant->get_list(
                    $attendant_id,
                    'attendant.*, CONCAT(attendant.last_name,", ",attendant.first_name," ",attendant.middle_name) AS full_name, departments.department_id, departments.department_name',
                    array(
                        array('departments','departments.department_id=attendant.department_id','left')
                    )
                );

                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=1; //CRUD
                $m_trans->trans_type_id=72; // TRANS TYPE
                $m_trans->trans_log='Created Attendant: '.$this->input->post('first_name',TRUE).' '.$this->input->post('middle_name',TRUE).' '.$this->input->post('last_name',TRUE);
                $m_trans->save();

                echo json_encode($response);

                break;

            case 'delete':
                $m_attendant=$this->Attendant_model;
                $attendant_id=$this->input->post('attendant_id',TRUE);

                $m_attendant->is_deleted=1;
                if($m_attendant->modify($attendant_id)){
                    $response['title']='Success!';
                    $response['stat']='success';
                    $response['msg']='Attendant information successfully deleted.';
                    $m_trans=$this->Trans_model;

                    $m_trans->user_id=$this->session->user_id;
                    $m_trans->set('trans_date','NOW()');
                    $m_trans->trans_key_id=3; //CRUD
                    $m_trans->trans_type_id=72; // TRANS TYPE
                    $m_trans->trans_log='Deleted Attendant: ID('.$attendant_id.')';
                    $m_trans->save();

                    echo json_encode($response);
                }

                break;

            case 'update':
                $m_attendant=$this->Attendant_model;
                $attendant_id=$this->input->post('attendant_id',TRUE);

                $m_attendant->first_name=$this->input->post('first_name',TRUE);
                $m_attendant->middle_name=$this->input->post('middle_name',TRUE);
                $m_attendant->last_name=$this->input->post('last_name',TRUE);
                $m_attendant->contact_no=$this->input->post('contact_no',TRUE);
                $m_attendant->department_id=$this->input->post('department_id',TRUE);
                $m_attendant->modify($attendant_id);

                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Attendant Information successfully updated.';
                $response['row_updated']=$m_attendant->get_list(
                    $attendant_id,
                    'attendant.*, CONCAT(attendant.last_name,", ",attendant.first_name," ",attendant.middle_name) AS full_name, departments.department_id, departments.department_name',
                    array(
                        array('departments','departments.department_id=attendant.department_id','left')
                    )
                );

                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=2; //CRUD
                $m_trans->trans_type_id=72; // TRANS TYPE
                $m_trans->trans_log='Updated Attendant: ID('.$attendant_id.')'; 
                $m_trans->save();

                echo json_encode($response);

                break;
       	}
    }
}
