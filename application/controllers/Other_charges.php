<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Other_charges extends CORE_Controller
{

    function __construct() {
        parent::__construct('');
        $this->validate_session();

        $this->load->model('Other_charge_model');
        $this->load->model('Charges_model');
        $this->load->model('Users_model');
        $this->load->model('Other_charge_item_model');
        $this->load->model('Trans_model');

    }

    public function index() {
        $this->Users_model->validate();
        //default resources of the active view
        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', TRUE);
        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', TRUE);
        $data['_rights'] = $this->load->view('template/elements/rights', '', TRUE);
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

        $data['title'] = 'Other Charges';
        (in_array('19-3',$this->session->user_rights)? 
        $this->load->view('other_charges_view', $data)
        :redirect(base_url('dashboard')));
    }


    function transaction($txn = null,$id_filter=null) {
        switch ($txn){

            //******************************************* Datatable when page loads ****************************************************************
            case 'list' :
                $response['data']= $this->response_rows_invoice('other_charges.is_active=TRUE AND other_charges.is_deleted=FALSE');
                echo json_encode($response);

                break;

            case 'list-accounts' :
                $response['data']= $this->Other_charge_model->accounts();

                echo json_encode($response);
                break;

            ////****************************************items/products of selected Items***********************************************
            case 'items-invoice':
                $m_items=$this->Other_charge_item_model;
                $response['data']=$m_items->get_list(
                    array('other_charge_id'=>$id_filter),
                    array(
                        'other_charges_items.*',
                        'charges.charge_code',
                        'charges.charge_desc',
                        'charge_unit.charge_unit_id',
                        'charge_unit.charge_unit_name'
                    ),
                    array(
                        array('charges','charges.charge_id=other_charges_items.charge_id','left'),
                        array('charge_unit','charge_unit.charge_unit_id=other_charges_items.charge_unit_id','left')
                    ),
                    'other_charges_items.other_charge_item_id ASC'
                );


                echo json_encode($response);

                break;


            //***************************************create new Items************************************************
            case 'create-invoice':
                $m_invoice=$this->Other_charge_model;
                $m_invoice->set('date_created','NOW()');
                $m_invoice->address=$this->input->post('address',TRUE);
                $m_invoice->date_invoice=date('Y-m-d',strtotime($this->input->post('date_invoice',TRUE)));
                $m_invoice->remarks=$this->input->post('remarks',TRUE);
                $m_invoice->total_amount=$this->get_numeric_value($this->input->post('summary_total_amount',TRUE));
                $m_invoice->connection_id=$this->get_numeric_value($this->input->post('connection_id',TRUE));
                $m_invoice->total_overall_discount=$this->get_numeric_value($this->input->post('total_overall_discount',TRUE));
                $m_invoice->total_overall_discount_amount=$this->get_numeric_value($this->input->post('total_overall_discount_amount',TRUE));
                $m_invoice->total_amount_after_discount=$this->get_numeric_value($this->input->post('summary_total_amount_after_discount',TRUE));
                $m_invoice->posted_by_user=$this->session->user_id;
                $m_invoice->save();

                $other_charge_id=$m_invoice->last_insert_id();
                $m_invoice_items=$this->Other_charge_item_model;

                //prepare the items with multiple values for looping statement
                $charge_qty = $this->input->post('charge_qty');
                $charge_amount = $this->input->post('charge_amount');
                $charge_line_total = $this->input->post('charge_line_total');
                $charge_line_total_after_global = $this->input->post('charge_line_total_after_global');
                $charge_id = $this->input->post('charge_id');
                $charge_unit_id = $this->input->post('charge_unit_id');
                
                for($i=0;$i<count($charge_id);$i++){
                    $m_invoice_items->other_charge_id=$other_charge_id;
                    $m_invoice_items->charge_qty=$this->get_numeric_value($charge_qty[$i]);
                    $m_invoice_items->charge_amount=$this->get_numeric_value($charge_amount[$i]);
                    $m_invoice_items->charge_line_total=$this->get_numeric_value($charge_line_total[$i]);
                    $m_invoice_items->charge_line_total_after_global=$this->get_numeric_value($charge_line_total_after_global[$i]);
                    $m_invoice_items->charge_id=$this->get_numeric_value($charge_id[$i]);
                    $m_invoice_items->charge_unit_id=$this->get_numeric_value($charge_unit_id[$i]);
                    $m_invoice_items->save();
                }

                $m_invoice->other_charge_no='OTH-CHR-'.date('Ymd').'-'.$other_charge_id;
                $m_invoice->modify($other_charge_id);

                if($m_invoice->status()===TRUE){
                    $response['title'] = 'Success!';
                    $response['stat'] = 'success';
                    $response['msg'] = 'Other Charge successfully created.';
                    $response['row_added']=$this->response_rows_invoice($other_charge_id);

                    // Audittrail Log          
                    $m_trans=$this->Trans_model;
                    $m_trans->user_id=$this->session->user_id;
                    $m_trans->set('trans_date','NOW()');
                    $m_trans->trans_key_id=1; //CRUD
                    $m_trans->trans_type_id=78; // TRANS TYPE
                    $m_trans->trans_log='Created New Other Charges Invoice: (OTH-CHR-'.date('Ymd').'-'.$other_charge_id.')';
                    $m_trans->save();

                    echo json_encode($response);
                }

                break;
            



            ////***************************************update Items************************************************
            case 'update-invoice':
                $m_invoice=$this->Other_charge_model;

                $other_charge_id=$this->input->post('other_charge_id',TRUE);

                $m_invoice->set('date_created','NOW()');
                $m_invoice->address=$this->input->post('address',TRUE);
                $m_invoice->date_invoice=date('Y-m-d',strtotime($this->input->post('date_invoice',TRUE)));
                $m_invoice->remarks=$this->input->post('remarks',TRUE);
                $m_invoice->connection_id=$this->get_numeric_value($this->input->post('connection_id',TRUE));
                $m_invoice->total_amount=$this->get_numeric_value($this->input->post('summary_total_amount',TRUE));
                $m_invoice->total_overall_discount=$this->get_numeric_value($this->input->post('total_overall_discount',TRUE));
                $m_invoice->total_overall_discount_amount=$this->get_numeric_value($this->input->post('total_overall_discount_amount',TRUE));
                $m_invoice->total_amount_after_discount=$this->get_numeric_value($this->input->post('summary_total_amount_after_discount',TRUE));
                $m_invoice->posted_by_user=$this->session->user_id;
                $m_invoice->modify($other_charge_id);

                $m_invoice_items=$this->Other_charge_item_model;
                $m_invoice_items->delete_via_fk($other_charge_id); 
                //prepare the items with multiple values for looping statement
                $charge_qty = $this->input->post('charge_qty');
                $charge_amount = $this->input->post('charge_amount');
                $charge_line_total = $this->input->post('charge_line_total');
                $charge_line_total_after_global = $this->input->post('charge_line_total_after_global');
                $charge_id = $this->input->post('charge_id');
                $charge_unit_id = $this->input->post('charge_unit_id');
                
                for($i=0;$i<count($charge_id);$i++){
                    $m_invoice_items->other_charge_id=$other_charge_id;
                    $m_invoice_items->charge_qty=$this->get_numeric_value($charge_qty[$i]);
                    $m_invoice_items->charge_amount=$this->get_numeric_value($charge_amount[$i]);
                    $m_invoice_items->charge_line_total=$this->get_numeric_value($charge_line_total[$i]);
                    $m_invoice_items->charge_line_total_after_global=$this->get_numeric_value($charge_line_total_after_global[$i]);
                    $m_invoice_items->charge_id=$this->get_numeric_value($charge_id[$i]);
                    $m_invoice_items->charge_unit_id=$this->get_numeric_value($charge_unit_id[$i]);
                    $m_invoice_items->save();
                }

                if($m_invoice->status()===TRUE){
                    $response['title'] = 'Success!';
                    $response['stat'] = 'success';
                    $response['msg'] = 'Other Charge successfully updated.';
                    $response['row_updated']=$this->response_rows_invoice($other_charge_id);

                    // Audittrail Log          
                    $m_trans=$this->Trans_model;
                    $m_trans->user_id=$this->session->user_id;
                    $m_trans->set('trans_date','NOW()');
                    $m_trans->trans_key_id=2; //CRUD
                    $m_trans->trans_type_id=78; // TRANS TYPE
                    $m_trans->trans_log='Updated Other Charges Invoice: ID('.$other_charge_id.')';
                    $m_trans->save();

                    echo json_encode($response);
                }

            break;

            //***************************************************************************************
            case 'delete':
                $m_invoice=$this->Other_charge_model;
                $other_charge_id=$this->input->post('other_charge_id',TRUE);

                //mark Items as deleted
                $m_invoice->set('date_deleted','NOW()'); //treat NOW() as function and not string
                $m_invoice->deleted_by_user=$this->session->user_id;//user that deleted the record
                $m_invoice->is_deleted=1;//mark as deleted
                $m_invoice->modify($other_charge_id);

                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Record successfully deleted.';

                // Audittrail Log          
                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=3; //CRUD
                $m_trans->trans_type_id=78; // TRANS TYPE
                $m_trans->trans_log='Deleted Other Charges Invoice: ID('.$other_charge_id.')';
                $m_trans->save();

                echo json_encode($response);

                break;            
        }

    }



//**************************************user defined*************************************************


function response_rows_invoice($filter_value){
    return $this->Other_charge_model->get_list(
            $filter_value,
            'other_charges.*,
            customers.customer_name,
            departments.department_name,
            service_connection.account_no,
            meter_inventory.serial_no,
            DATE_FORMAT(other_charges.date_invoice,"%m/%d/%Y") as date_invoice',
            array(
                array('departments','departments.department_id=other_charges.department_id','left'),
                array('service_connection','service_connection.connection_id=other_charges.connection_id','left'),
                array('meter_inventory','meter_inventory.meter_inventory_id=service_connection.meter_inventory_id','left'),
                array('customers','customers.customer_id=service_connection.customer_id','left')
            ),
            'other_charges.other_charge_id DESC'

            );


}


}
