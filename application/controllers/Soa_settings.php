<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
 
class Soa_settings extends CORE_Controller 
{ 
 
    function __construct() { 
        parent::__construct(''); 
        $this->validate_session(); 
        $this->load->model(array( 
                'Account_title_model', 
                'Soa_settings_model', 
                'Sales_invoice_model', 
                'Users_model', 
            ) 
 
        ); 
    } 
 
    public function index() { 
        $this->Users_model->validate(); 
        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', TRUE); 
        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', TRUE); 
        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', TRUE); 
        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', TRUE); 
        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', TRUE); 
        $data['title'] = 'Statement of Accounts Settings'; 
 
        $data['accounts'] = $this->Account_title_model->get_list(array('account_titles.is_active'=>TRUE,'account_titles.is_deleted'=>FALSE,'account_classes.account_type_id'=>1), 
            'account_titles.account_id,account_titles.account_title, 
            IF(ISNULL(ss.soa_account_id),0,1) as is_allowed', 
            array(array('soa_settings ss','ss.soa_account_id = account_titles.account_id','left'), 
                array('account_classes','account_classes.account_class_id=account_titles.account_class_id','left')) 
            ); 
 
        (in_array('6-14',$this->session->user_rights)?  
        $this->load->view('soa_settings_view', $data)
        :redirect(base_url('dashboard'))); 
         
 
    } 
 
 
    public function transaction($txn=null){ 
        switch($txn){ 
           case 'save_accounts': 
           $this->db->truncate('soa_settings');  
                $m_rights=$this->Soa_settings_model; 
 
                $account_id=$this->input->post('account_id',TRUE); 
                foreach($account_id as $account_id){ 
                        $m_rights->soa_account_id=$account_id; 
                        $m_rights->save(); 
                } 
 
                $response['title']='Success!'; 
                $response['stat']='success'; 
                $response['msg']='SOA Settings Saved Successfully.'; 
 
                echo json_encode($response); 
 
           break; 
 
        } 
 
    } 
 
} 
