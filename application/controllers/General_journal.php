<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class General_journal extends CORE_Controller
{

    function __construct() {
        parent::__construct('');
        $this->validate_session();

        $this->load->model(
            array(
                'Customers_model',
                'Suppliers_model',
                'Account_title_model',
                'Payment_method_model',
                'Journal_info_model',
                'Journal_account_model',
                'Departments_model',
                'Accounting_period_model',
                'Users_model',
                'Tax_model',
                'Depreciation_expense_model',
                'Trans_model',
                'Adjustment_model',
                'Issuance_department_model',
                'Customer_type_model'

            )
        );

    }

    public function index() {
        $this->Users_model->validate();
        //default resources of the active view
        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', TRUE);
        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', TRUE);
        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', TRUE);
        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', TRUE);
        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', TRUE);

        $data['tax_types']=$this->Tax_model->get_list(array('tax_types.is_deleted'=>FALSE));
        $data['customers']=$this->Customers_model->get_list('is_active=TRUE AND is_deleted=FALSE');
        $data['suppliers']=$this->Suppliers_model->get_list('is_active=TRUE AND is_deleted=FALSE');
        $data['departments']=$this->Departments_model->get_list('is_active=TRUE AND is_deleted=FALSE');
        $data['accounts']=$this->Account_title_model->get_list('is_active=TRUE AND is_deleted=FALSE');
        $data['methods']=$this->Payment_method_model->get_list('is_active=TRUE AND is_deleted=FALSE');
        $data['customer_type']=$this->Customer_type_model->get_list('is_deleted=FALSE');
 
        $data['title'] = 'General Journal';
        (in_array('1-1',$this->session->user_rights)? 
        $this->load->view('general_journal_view', $data)
        :redirect(base_url('dashboard')));
        


    }


    public function transaction($txn=null){
        switch($txn){
            case 'list':
                $m_journal=$this->Journal_info_model;
                $tsd = date('Y-m-d',strtotime($this->input->get('tsd')));
                $ted = date('Y-m-d',strtotime($this->input->get('ted')));
                $additional = " AND DATE(journal_info.date_txn) BETWEEN '$tsd' AND '$ted'";
                $response['data']=$this->get_response_rows(null,$additional);
                echo json_encode($response);
                break;
            case 'get-entries':
                $journal_id=$this->input->get('id');
                $m_accounts=$this->Account_title_model;
                $m_journal_accounts=$this->Journal_account_model;

                $data['accounts']=$m_accounts->get_list(array('is_deleted'=>FALSE));
                $data['entries']=$m_journal_accounts->get_list('journal_accounts.journal_id='.$journal_id);

                $this->load->view('template/journal_entries', $data);
                break;
            case 'create' :
                $m_trans=$this->Trans_model;
                $m_journal=$this->Journal_info_model;
                $m_journal_accounts=$this->Journal_account_model;

                //validate if still in valid range
                $valid_range=$this->Accounting_period_model->get_list("'".date('Y-m-d',strtotime($this->input->post('date_txn',TRUE)))."'<=period_end");
                if(count($valid_range)>0){
                    $response['stat']='error';
                    $response['title']='<b>Accounting Period is Closed!</b>';
                    $response['msg']='Please make sure transaction date is valid!<br />';
                    die(json_encode($response));
                }


                $particular=explode('-',$this->input->post('particular_id',TRUE));
                if($particular[0]=='C'){
                    $m_journal->customer_id=$particular[1];
                    $m_journal->supplier_id=0;
                }else{
                    $m_journal->customer_id=0;
                    $m_journal->supplier_id=$particular[1];
                }


                $m_journal->department_id=$this->input->post('department_id',TRUE);
                $m_journal->remarks=$this->input->post('remarks',TRUE);
                $m_journal->date_txn=date('Y-m-d',strtotime($this->input->post('date_txn',TRUE)));
                $m_journal->book_type='GJE';

                //for audit details
                $m_journal->set('date_created','NOW()');
                $m_journal->created_by_user=$this->session->user_id;
                $m_journal->save();

                $journal_id=$m_journal->last_insert_id();
                $accounts=$this->input->post('accounts',TRUE);
                $memos=$this->input->post('memo',TRUE);
                $dr_amounts=$this->input->post('dr_amount',TRUE);
                $cr_amounts=$this->input->post('cr_amount',TRUE);

                for($i=0;$i<=count($accounts)-1;$i++){
                    $m_journal_accounts->journal_id=$journal_id;
                    $m_journal_accounts->account_id=$accounts[$i];
                    $m_journal_accounts->memo=$memos[$i];
                    $m_journal_accounts->dr_amount=$this->get_numeric_value($dr_amounts[$i]);
                    $m_journal_accounts->cr_amount=$this->get_numeric_value($cr_amounts[$i]);
                    $m_journal_accounts->save();
                }


                //update transaction number base on formatted last insert id
                $m_journal->txn_no='TXN-'.date('Ymd').'-'.$journal_id;
                $m_journal->modify($journal_id);

                $issuance_department_id=$this->input->post('issuance_department_id',TRUE);
                $trn_type=$this->input->post('trn_type',TRUE);
                if($issuance_department_id!=null){
                    $m_issuances=$this->Issuance_department_model;
                    if($trn_type == 'From'){
                        $m_issuances->is_journal_posted_from=TRUE;
                        $m_issuances->posted_by_from=$this->session->user_id;
                        $m_issuances->set('date_posted_from','NOW()');
                        $m_issuances->journal_id_from=$journal_id;
                    }else if ($trn_type == 'To'){
                        $m_issuances->is_journal_posted_to=TRUE;
                        $m_issuances->posted_by_to=$this->session->user_id;
                        $m_issuances->set('date_posted_to','NOW()');
                        $m_issuances->journal_id_to=$journal_id;
                    }

                    
                    $m_issuances->modify($issuance_department_id);

                // AUDIT TRAIL START
                $issuances=$m_issuances->get_list($issuance_department_id,'trn_no');
                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=8; //CRUD
                $m_trans->trans_type_id=14; // TRANS TYPE
                $m_trans->trans_log='Finalized Issuance Transfer Item  Tranfer No.'.$issuances[0]->trn_no.' For General Journal Entry TXN-'.date('Ymd').'-'.$journal_id;
                $m_trans->save();

                //AUDIT TRAIL END
                }
  //if adjustment invoice is available, adjustment invoice is recorded as journal
                $adjustment_id=$this->input->post('adjustment_id',TRUE);
                if($adjustment_id!=null){
                    $m_adjustment=$this->Adjustment_model;
                    $m_adjustment->journal_id=$journal_id;
                    $m_adjustment->is_journal_posted=TRUE;
                    $m_adjustment->modify($adjustment_id);

                // AUDIT TRAIL START
                $adjustment=$m_adjustment->get_list($adjustment_id,'adjustment_code');
                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=8; //CRUD
                $m_trans->trans_type_id=15; // TRANS TYPE
                $m_trans->trans_log='Finalized Adjustment No. '.$adjustment[0]->adjustment_code.' For General Journal Entry TXN-'.date('Ymd').'-'.$journal_id;
                $m_trans->save();
                //AUDIT TRAIL END
                }

                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->trans_key_id=1;
                $m_trans->trans_type_id=1;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_log='Created General Journal TXN-'.date('Ymd').'-'.$journal_id;
                $m_trans->save();

                $response['stat']='success';
                $response['title']='Success!';
                $response['msg']='Journal successfully posted.';
                $response['row_added']=$this->get_response_rows($journal_id);
                echo json_encode($response);
                break;
            case 'update':
                $journal_id=$this->input->get('id');
                $m_journal=$this->Journal_info_model;
                $m_journal_accounts=$this->Journal_account_model;

                //validate if this transaction is not yet closed
                $not_closed=$m_journal->get_list('accounting_period_id>0 AND journal_id='.$journal_id);
                if(count($not_closed)>0){
                    $response['stat']='error';
                    $response['title']='<b>Journal is Locked!</b>';
                    $response['msg']='Sorry, you cannot update journal that is already closed!<br />';
                    die(json_encode($response));
                }

                //validate if still in valid range
                $valid_range=$this->Accounting_period_model->get_list("'".date('Y-m-d',strtotime($this->input->post('date_txn',TRUE)))."'<=period_end");
                if(count($valid_range)>0){
                    $response['stat']='error';
                    $response['title']='<b>Accounting Period is Closed!</b>';
                    $response['msg']='Please make sure transaction date is valid!<br />';
                    die(json_encode($response));
                }


                $particular=explode('-',$this->input->post('particular_id',TRUE));
                if($particular[0]=='C'){
                    $m_journal->customer_id=$particular[1];
                    $m_journal->supplier_id=0;
                }else{
                    $m_journal->customer_id=0;
                    $m_journal->supplier_id=$particular[1];
                }


                $m_journal->department_id=$this->input->post('department_id',TRUE);
                $m_journal->remarks=$this->input->post('remarks',TRUE);
                $m_journal->date_txn=date('Y-m-d',strtotime($this->input->post('date_txn',TRUE)));
                $m_journal->book_type='GJE';

                //for audit details
                $m_journal->set('date_modified','NOW()');
                $m_journal->modified_by_user=$this->session->user_id;
                $m_journal->modify($journal_id);


                $accounts=$this->input->post('accounts',TRUE);
                $memos=$this->input->post('memo',TRUE);
                $dr_amounts=$this->input->post('dr_amount',TRUE);
                $cr_amounts=$this->input->post('cr_amount',TRUE);

                $m_journal_accounts->delete_via_fk($journal_id);

                for($i=0;$i<=count($accounts)-1;$i++){
                    $m_journal_accounts->journal_id=$journal_id;
                    $m_journal_accounts->account_id=$accounts[$i];
                    $m_journal_accounts->memo=$memos[$i];
                    $m_journal_accounts->dr_amount=$this->get_numeric_value($dr_amounts[$i]);
                    $m_journal_accounts->cr_amount=$this->get_numeric_value($cr_amounts[$i]);
                    $m_journal_accounts->save();
                }


                $response['stat']='success';
                $response['title']='Success!';
                $response['msg']='Journal successfully updated';
                $response['row_updated']=$this->get_response_rows($journal_id);
                echo json_encode($response);
                break;

            //***************************************************************************************
            case 'cancel':
                $m_journal=$this->Journal_info_model;
                $journal_id=$this->input->post('journal_id',TRUE);

                //validate if this transaction is not yet closed
                $not_closed=$m_journal->get_list('accounting_period_id>0 AND journal_id='.$journal_id);
                if(count($not_closed)>0){
                    $response['stat']='error';
                    $response['title']='<b>Journal is Locked!</b>';
                    $response['msg']='Sorry, you cannot cancel journal that is already closed!<br />';
                    die(json_encode($response));
                }

                //mark Items as deleted
                $m_journal->set('date_cancelled','NOW()'); //treat NOW() as function and not string
                $m_journal->cancelled_by_user=$this->session->user_id;//user that cancelled the record
                $m_journal->set('is_active','NOT is_active');
                $m_journal->modify($journal_id);



                $response['title']='Cancelled!';
                $response['stat']='success';
                $response['msg']='Journal successfully cancelled.';
                $response['row_updated']=$this->get_response_rows($journal_id);

                echo json_encode($response);

                break;


                case 'create-expense-journal' :
                    $m_journal=$this->Journal_info_model;
                    $m_journal_accounts=$this->Journal_account_model;

                    //validate if still in valid range
                    $valid_range=$this->Accounting_period_model->get_list("'".date('Y-m-d',strtotime($this->input->post('date_txn',TRUE)))."'<=period_end");
                    if(count($valid_range)>0){
                        $response['stat']='error';
                        $response['title']='<b>Accounting Period is Closed!</b>';
                        $response['msg']='Please make sure transaction date is valid!<br />';
                        die(json_encode($response));
                    }


                    $particular=explode('-',$this->input->post('particular_id',TRUE));
                    if($particular[0]=='C'){
                        $m_journal->customer_id=$particular[1];
                        $m_journal->supplier_id=0;
                    }else{
                        $m_journal->customer_id=0;
                        $m_journal->supplier_id=$particular[1];
                    }


                    $m_journal->department_id=$this->input->post('department_id',TRUE);
                    $m_journal->remarks=$this->input->post('remarks',TRUE);
                    $m_journal->date_txn=date('Y-m-d',strtotime($this->input->post('date_txn',TRUE)));
                    $m_journal->book_type='GJE';

                    //for audit details
                    $m_journal->set('date_created','NOW()');
                    $m_journal->created_by_user=$this->session->user_id;
                    $m_journal->save();

                    $journal_id=$m_journal->last_insert_id();
                    $accounts=$this->input->post('accounts',TRUE);
                    $memos=$this->input->post('memo',TRUE);
                    $dr_amounts=$this->input->post('dr_amount',TRUE);
                    $cr_amounts=$this->input->post('cr_amount',TRUE);

                    for($i=0;$i<=count($accounts)-1;$i++){
                        $m_journal_accounts->journal_id=$journal_id;
                        $m_journal_accounts->account_id=$accounts[$i];
                        $m_journal_accounts->memo=$memos[$i];
                        $m_journal_accounts->dr_amount=$this->get_numeric_value($dr_amounts[$i]);
                        $m_journal_accounts->cr_amount=$this->get_numeric_value($cr_amounts[$i]);
                        $m_journal_accounts->save();
                    }


                    //update transaction number base on formatted last insert id
                    $m_journal->txn_no='TXN-'.date('Ymd').'-'.$journal_id;
                    $m_journal->modify($journal_id);

                    $txn_no=$m_journal->get_list($journal_id);

                    $m_depreciation_expense=$this->Depreciation_expense_model;
                    $de_id=$this->input->post('de_id');

                    $m_depreciation_expense->de_remarks='Posted to GL';
                    $m_depreciation_expense->set('date_posted','NOW()');
                    $m_depreciation_expense->is_journal_posted=1;
                    $m_depreciation_expense->de_ref_no=$txn_no[0]->txn_no;
                    $m_depreciation_expense->modify($de_id);


                    $response['stat']='success';
                    $response['title']='Success!';
                    $response['msg']='Journal successfully posted.';
                    $response['row_added']=$this->get_response_rows($journal_id);
                    $response['row_updated']=$m_depreciation_expense->get_list($de_id,
                        array('depreciation_expense.de_id',
                            'MONTHNAME(depreciation_expense.de_date) as de_month',
                            'YEAR(depreciation_expense.de_date) as de_year',
                            'depreciation_expense.de_expense_total',
                            'depreciation_expense.de_remarks',
                            'depreciation_expense.de_ref_no',
                            'depreciation_expense.date_posted',
                            'depreciation_expense.is_journal_posted'
                            )
                        );
                    echo json_encode($response);
                    break;

        };
    }



    public function get_response_rows($criteria=null,$additional = null){
        $m_journal=$this->Journal_info_model;
        return $m_journal->get_list(

            "journal_info.is_deleted=FALSE AND journal_info.book_type='GJE'".($criteria==null?'':' AND journal_info.journal_id='.$criteria)."".($additional==null?'':$additional),

            array(
                'journal_info.journal_id',
                'journal_info.txn_no',
                'journal_info.department_id',
                'DATE_FORMAT(journal_info.date_txn,"%m/%d/%Y")as date_txn',
                'journal_info.is_active',
                'journal_info.remarks',
                'CONCAT(IF(NOT ISNULL(customers.customer_id),CONCAT("C-",customers.customer_id),""),IF(NOT ISNULL(suppliers.supplier_id),CONCAT("S-",suppliers.supplier_id),"")) as particular_id',
                'CONCAT_WS(" ",IFNULL(customers.customer_name,""),IFNULL(suppliers.supplier_name,"")) as particular',
                'CONCAT_WS(" ",user_accounts.user_fname,user_accounts.user_lname)as posted_by'
            ),
            array(
                array('customers','customers.customer_id=journal_info.customer_id','left'),
                array('suppliers','suppliers.supplier_id=journal_info.supplier_id','left'),
                array('user_accounts','user_accounts.user_id=journal_info.created_by_user','left')
            ),
            'journal_info.journal_id DESC'
        );
    }






}
