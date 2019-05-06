<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Issuance_department extends CORE_Controller
{
    function __construct() {
        parent::__construct('');
        $this->validate_session();
        $this->load->model('Issuance_department_model');
        $this->load->model('Issuance_department_item_model');
        $this->load->model('Departments_model');
        $this->load->model('Tax_types_model');
        $this->load->model('Products_model');
        //$this->load->model('Customers_model');
        $this->load->model('Refproduct_model');
        $this->load->model('Users_model');
        $this->load->model('Trans_model');

    }
    public function index() {
        $this->Users_model->validate();
        //default resources of the active view
        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', TRUE);
        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', TRUE);
        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', TRUE);
        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', TRUE);
        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', TRUE);
        //data required by active view
        $data['departments']=$this->Departments_model->get_list(
            array('departments.is_active'=>TRUE,'departments.is_deleted'=>FALSE)
        );

        $data['refproducts']=$this->Refproduct_model->get_list(
            'is_deleted=FALSE',null,null,'refproduct.refproduct_id'
        );

        $data['title'] = 'Issuance to Department';
        (in_array('15-5',$this->session->user_rights)? 
        $this->load->view('issuance_department_view', $data)
        :redirect(base_url('dashboard')));
        
    }
    function transaction($txn = null,$id_filter=null) {
        switch ($txn){

            case'close-invoice':  
            $m_invoice=$this->Issuance_department_model;
                $issuance_department_id =$this->input->post('issuance_department_id');
            if($this->input->post('trn_type') == 'From'){

                $m_invoice->closing_reason_from = $this->input->post('closing_reason');
                $m_invoice->closed_by_user_from = $this->session->user_id;
                $m_invoice->is_closed_from = TRUE;
                $m_invoice->modify($issuance_department_id);
            }else if($this->input->post('trn_type') == 'To'){
                $m_invoice->closing_reason_to = $this->input->post('closing_reason');
                $m_invoice->closed_by_user_to = $this->session->user_id;
                $m_invoice->is_closed_to = TRUE;
                $m_invoice->modify($issuance_department_id);
            }



            $iss_inv_no=$m_invoice->get_list($issuance_department_id,'trn_no');
            $m_trans=$this->Trans_model;
            $m_trans->user_id=$this->session->user_id;
            $m_trans->set('trans_date','NOW()');
            $m_trans->trans_key_id=11; //CRUD
            $m_trans->trans_type_id=66; // TRANS TYPE
            $m_trans->trans_log='Closed/Did Not Post Issuance Department '.$this->input->post('trn_type').' : '.$iss_inv_no[0]->trn_no.' from General Journal Pending with reason: '.$this->input->post('closing_reason');
            $m_trans->save();
            $response['title'] = 'Success!';
            $response['stat'] = 'success';
            $response['msg'] = 'Issuance Department successfully closed.';
            echo json_encode($response);    
            break;


            case 'list':  //this returns JSON of Issuance to be rendered on Datatable
                $m_issuance=$this->Issuance_department_model;
                $response['data']=$this->response_rows(
                    'issuance_department_info.is_active=TRUE AND issuance_department_info.is_deleted=FALSE'.($id_filter==null?'':' AND issuance_department_info.issuance_department_id='.$id_filter)
                );
                echo json_encode($response);
                break;


            case 'issuance-department-for-review':  //this returns JSON of Issuance to be rendered on Datatable of accounting issuance
                $response['data']=$this->Issuance_department_model->issuance_department_for_review();
                echo json_encode($response);
                break;

            ////****************************************items/products of selected Items***********************************************
            case 'items': //items on the specific PO, loads when edit button is called
                $m_items=$this->Issuance_department_item_model;
                $response['data']=$m_items->get_list(
                    array('issuance_department_id'=>$id_filter),
                    array(
                        'issuance_department_items.*',
                        'products.product_code',
                        'products.product_desc',
                            'products.purchase_cost',
                            'products.is_bulk',
                            'products.child_unit_id',
                            'products.parent_unit_id',
                            'products.child_unit_desc',
                            '(SELECT units.unit_name  FROM units WHERE  units.unit_id = products.parent_unit_id) as parent_unit_name',
                            '(SELECT units.unit_name  FROM units WHERE  units.unit_id = products.child_unit_id) as child_unit_name'
                    ),
                    array(
                        array('products','products.product_id=issuance_department_items.product_id','left')
                    ),
                    'issuance_department_items.issuance_department_item_id DESC'
                );
                echo json_encode($response);
                break;

            //***************************************create new Items************************************************
            case 'create':
                $m_issuance=$this->Issuance_department_model;
                if(count($m_issuance->get_list(array('trn_no'=>$this->input->post('trn_no',TRUE))))>0){
                    $response['title'] = 'Invalid!';
                    $response['stat'] = 'error';
                    $response['msg'] = 'Transfer No. already exists.';
                    echo json_encode($response);
                    exit;
                }
                $m_issuance->begin();
                $m_issuance->set('date_created','NOW()'); //treat NOW() as function and not string
                $m_issuance->remarks=$this->input->post('remarks',TRUE);
                $m_issuance->date_issued=date('Y-m-d',strtotime($this->input->post('date_issued',TRUE)));
                $m_issuance->terms=$this->input->post('terms',TRUE);
                $m_issuance->from_department_id=$this->input->post('from_department_id',TRUE);
                $m_issuance->to_department_id=$this->input->post('to_department_id',TRUE);

                // OK
                $m_issuance->total_discount=$this->get_numeric_value($this->input->post('summary_discount',TRUE));
                $m_issuance->total_before_tax=$this->get_numeric_value($this->input->post('summary_before_discount',TRUE));
                $m_issuance->total_tax_amount=$this->get_numeric_value($this->input->post('summary_tax_amount',TRUE));
                $m_issuance->total_after_tax=$this->get_numeric_value($this->input->post('summary_after_tax',TRUE));
                $m_issuance->posted_by_user=$this->session->user_id;
                $m_issuance->save();
                $issuance_department_id=$m_issuance->last_insert_id();
                $m_issue_items=$this->Issuance_department_item_model;
                $prod_id=$this->input->post('product_id',TRUE);
                $issue_qty=$this->input->post('issue_qty',TRUE);
                $issue_price=$this->input->post('issue_price',TRUE);
                $issue_discount=$this->input->post('issue_discount',TRUE);
                $issue_line_total_discount=$this->input->post('issue_line_total_discount',TRUE);
                $issue_tax_rate=$this->input->post('issue_tax_rate',TRUE);
                $issue_line_total_price=$this->input->post('issue_line_total_price',TRUE);
                $issue_tax_amount=$this->input->post('issue_tax_amount',TRUE);
                $issue_non_tax_amount=$this->input->post('issue_non_tax_amount',TRUE);
                $batch_no=$this->input->post('batch_no',TRUE);
                $exp_date=$this->input->post('exp_date',TRUE);
                $is_parent=$this->input->post('is_parent',TRUE);
                $m_products=$this->Products_model;
                for($i=0;$i<count($prod_id);$i++){
                    $m_issue_items->issuance_department_id=$issuance_department_id;
                    $m_issue_items->product_id=$this->get_numeric_value($prod_id[$i]);
                    $m_issue_items->issue_qty=$this->get_numeric_value($issue_qty[$i]);
                    $m_issue_items->issue_price=$this->get_numeric_value($issue_price[$i]);
                    $m_issue_items->issue_discount=$this->get_numeric_value($issue_discount[$i]);
                    $m_issue_items->issue_line_total_discount=$this->get_numeric_value($issue_line_total_discount[$i]);
                    $m_issue_items->issue_tax_rate=$this->get_numeric_value($issue_tax_rate[$i]);
                    $m_issue_items->issue_line_total_price=$this->get_numeric_value($issue_line_total_price[$i]);
                    $m_issue_items->issue_tax_amount=$this->get_numeric_value($issue_tax_amount[$i]);
                    $m_issue_items->issue_non_tax_amount=$this->get_numeric_value($issue_non_tax_amount[$i]);
                    // $m_issue_items->batch_no=$batch_no[$i];
                    // $m_issue_items->exp_date=date('Y-m-d',strtotime($exp_date[$i]));
                    //unit id retrieval is change, because of TRIGGER restriction
                        $m_issue_items->is_parent=$this->get_numeric_value($is_parent[$i]);
                        if($is_parent[$i] == '1'){
                            $m_issue_items->set('unit_id','(SELECT parent_unit_id FROM products WHERE product_id='.(int)$prod_id[$i].')');
                        }else{
                             $m_issue_items->set('unit_id','(SELECT child_unit_id FROM products WHERE product_id='.(int)$prod_id[$i].')');
                        } 
                    $m_issue_items->save();
                    $m_products->on_hand=$m_products->get_product_qty($this->get_numeric_value($prod_id[$i]));
                    $m_products->modify($this->get_numeric_value($prod_id[$i]));
                }
                //update invoice number base on formatted last insert id
                $m_issuance->trn_no='TRN-'.date('Ymd').'-'.$issuance_department_id;
                $m_issuance->modify($issuance_department_id);

                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=1; //CRUD
                $m_trans->trans_type_id=66; // TRANS TYPE
                $m_trans->trans_log='Created Issuance No: TRN-'.date('Ymd').'-'.$issuance_department_id;
                $m_trans->save();

                $m_issuance->commit();
                if($m_issuance->status()===TRUE){
                    $response['title'] = 'Success!';
                    $response['stat'] = 'success';
                    $response['msg'] = 'Items successfully issued.';
                    $response['row_added']=$this->response_rows($issuance_department_id);
                    echo json_encode($response);
                }
                break;
            ////***************************************update Items************************************************
            case 'update':
                $m_issuance=$this->Issuance_department_model;
                $issuance_department_id=$this->input->post('issuance_department_id',TRUE);
                $m_issuance->begin();

                $m_issuance->remarks=$this->input->post('remarks',TRUE);
                $m_issuance->date_issued=date('Y-m-d',strtotime($this->input->post('date_issued',TRUE)));
                $m_issuance->from_department_id=$this->input->post('from_department_id',TRUE);
                $m_issuance->to_department_id=$this->input->post('to_department_id',TRUE);
                $m_issuance->terms=$this->input->post('terms',TRUE);

                $m_issuance->total_discount=$this->get_numeric_value($this->input->post('summary_discount',TRUE));
                $m_issuance->total_before_tax=$this->get_numeric_value($this->input->post('summary_before_discount',TRUE));
                $m_issuance->total_tax_amount=$this->get_numeric_value($this->input->post('summary_tax_amount',TRUE));
                $m_issuance->total_after_tax=$this->get_numeric_value($this->input->post('summary_after_tax',TRUE));

                $m_issuance->modified_by_user=$this->session->user_id;

                $m_issuance->modify($issuance_department_id);
                $m_issue_items = $this->Issuance_department_item_model;
                $m_issue_items->delete_via_fk($issuance_department_id); //delete previous items then insert those new
                $prod_id=$this->input->post('product_id',TRUE);
                $issue_price=$this->input->post('issue_price',TRUE);
                $issue_discount=$this->input->post('issue_discount',TRUE);
                $issue_line_total_discount=$this->input->post('issue_line_total_discount',TRUE);
                $issue_tax_rate=$this->input->post('issue_tax_rate',TRUE);
                $issue_qty=$this->input->post('issue_qty',TRUE);
                $issue_line_total_price=$this->input->post('issue_line_total_price',TRUE);
                $issue_tax_amount=$this->input->post('issue_tax_amount',TRUE);
                $issue_non_tax_amount=$this->input->post('issue_non_tax_amount',TRUE);
                $is_parent=$this->input->post('is_parent',TRUE);



                $m_products=$this->Products_model;
                for($i=0;$i<count($prod_id);$i++){
                    $m_issue_items->issuance_department_id=$issuance_department_id;
                    $m_issue_items->product_id=$this->get_numeric_value($prod_id[$i]);
                    $m_issue_items->issue_price=$this->get_numeric_value($issue_price[$i]);
                    $m_issue_items->issue_discount=$this->get_numeric_value($issue_discount[$i]);
                    $m_issue_items->issue_line_total_discount=$this->get_numeric_value($issue_line_total_discount[$i]);
                    $m_issue_items->issue_tax_rate=$this->get_numeric_value($issue_tax_rate[$i]);
                    $m_issue_items->issue_qty=$this->get_numeric_value($issue_qty[$i]);
                    $m_issue_items->issue_line_total_price=$this->get_numeric_value($issue_line_total_price[$i]);
                    $m_issue_items->issue_tax_amount=$this->get_numeric_value($issue_tax_amount[$i]);
                    $m_issue_items->issue_non_tax_amount=$this->get_numeric_value($issue_non_tax_amount[$i]);

                        $m_issue_items->is_parent=$this->get_numeric_value($is_parent[$i]);
                        if($is_parent[$i] == '1'){
                            $m_issue_items->set('unit_id','(SELECT parent_unit_id FROM products WHERE product_id='.(int)$prod_id[$i].')');
                        }else{
                             $m_issue_items->set('unit_id','(SELECT child_unit_id FROM products WHERE product_id='.(int)$prod_id[$i].')');
                        } 
                    $m_issue_items->save();
                }


                $iss_info=$m_issuance->get_list($issuance_department_id,'trn_no');
                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=2; //CRUD
                $m_trans->trans_type_id=66; // TRANS TYPE
                $m_trans->trans_log='Updated Issuance No: '.$iss_info[0]->trn_no;
                $m_trans->save();
                $m_issuance->commit();
                if($m_issuance->status()===TRUE){
                    $response['title'] = 'Success!';
                    $response['stat'] = 'success';
                    $response['msg'] = 'Issue items successfully updated.';
                    $response['row_updated']=$this->response_rows($issuance_department_id);
                    echo json_encode($response);
                }
                break;
            //***************************************************************************************
            case 'delete':
                $m_issuance=$this->Issuance_department_model;
                $m_issuance_items=$this->Issuance_department_item_model;
                $m_products=$this->Products_model;
                $issuance_department_id=$this->input->post('issuance_department_id',TRUE);
                //mark Items as deleted
                $m_issuance->set('date_deleted','NOW()'); //treat NOW() as function and not string, set deletion date
                $m_issuance->deleted_by_user=$this->session->user_id;
                $m_issuance->is_deleted=1;
                $m_issuance->modify($issuance_department_id);
                //update product on_hand after issuance is deleted...

                //end update product on_hand after issuance is deleted...
                $iss_info=$m_issuance->get_list($issuance_department_id,'trn_no');
                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=3; //CRUD
                $m_trans->trans_type_id=66; // TRANS TYPE
                $m_trans->trans_log='Deleted Transfer Issuance No: '.$iss_info[0]->trn_no;
                $m_trans->save();
                
                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Record successfully deleted.';
                echo json_encode($response);
                break;
            //***************************************************************************************
        }
    }
//**************************************user defined*************************************************
    function response_rows($filter_value){
        return $this->Issuance_department_model->get_list(
            $filter_value,
            array(
                'issuance_department_info.issuance_department_id',
                'issuance_department_info.trn_no',
                'issuance_department_info.remarks',
                'issuance_department_info.from_department_id',
                'issuance_department_info.to_department_id',
                'issuance_department_info.date_created',
                'DATE_FORMAT(issuance_department_info.date_issued,"%m/%d/%Y") as date_issued',
                'issuance_department_info.terms',
                'departments.department_id',
                'departments.department_name as to_department_name',
                'depfrom.department_name as from_department_name',
                'issuance_department_info.is_journal_posted_from',
                'issuance_department_info.is_journal_posted_to'
            ),
            array(
                array('departments','departments.department_id=issuance_department_info.to_department_id','left'),
                array('departments as depfrom','depfrom.department_id=issuance_department_info.from_department_id','left')
                //array('customers','customers.customer_id=issuance_info.issued_to_person','left')
            ),
            'issuance_department_info.issuance_department_id DESC'
        );
    }
//***************************************************************************************
}
