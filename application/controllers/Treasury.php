<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Treasury extends CORE_Controller
{

    function __construct() {
        parent::__construct('');
        $this->validate_session();

        $this->load->model(
            array(
                'Suppliers_model',
                'Departments_model',
                'Account_title_model',
                'Payment_method_model',
                'Journal_info_model',
                'Journal_account_model',
                'Tax_types_model',
                'Delivery_invoice_model',
                'Payment_method_model',
                'Check_layout_model',
                'Payable_payment_model',
                'Accounting_period_model',
                'Journal_template_info_model',
                'Journal_template_entry_model',
                'Company_model',
                'Users_model',
                'Bank_model'
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

        $data['bank_refs']=$this->Bank_model->get_list('is_deleted=FALSE AND is_active=TRUE');
        $data['suppliers']=$this->Suppliers_model->get_list('is_deleted = FALSE');
        $data['departments']=$this->Departments_model->get_list('is_deleted = FALSE');
        $data['accounts']=$this->Account_title_model->get_list('is_deleted = FALSE');
        $data['methods']=$this->Payment_method_model->get_list();
        $data['tax_types']=$this->Tax_types_model->get_list('is_deleted=0');
        $data['payment_methods']=$this->Payment_method_model->get_list('is_deleted=0');
        $data['layouts']=$this->Check_layout_model->get_list('is_deleted=0');
        $data['banks']=$this->Journal_info_model->get_list('is_active=1 AND is_deleted=0 AND payment_method_id=2',null,null,null,'bank');

        $data['title'] = 'Treasury';
        (in_array('1-2',$this->session->user_rights)? 
        $this->load->view('treasury_view', $data)
        :redirect(base_url('dashboard')));
        
    }


    public function transaction($txn=null){
        switch($txn){
            case 'get-check-list':
                $m_journal=$this->Journal_info_model;
                $response['data']=$m_journal->get_list(
                    "journal_info.is_active=1 AND journal_info.is_deleted=0 AND journal_info.book_type='CDJ' AND journal_info.payment_method_id=2 AND journal_info.check_status=0",
                    array(
                        'journal_info.*',
                        's.supplier_name',
                        'UPPER(journal_info.bank)as bank',
                        'DATE_FORMAT(journal_info.check_date,"%m/%d/%Y")as check_date'
                    ),
                    array(
                        array('suppliers as s','s.supplier_id=journal_info.supplier_id','left')
                    )
                );
                echo json_encode($response);
                break;

            case 'check-for-release':
                $m_journal=$this->Journal_info_model;
                $response['data']=$m_journal->get_list(
                    "journal_info.is_active=1 AND journal_info.is_deleted=0 AND journal_info.book_type='CDJ' AND journal_info.payment_method_id=2 AND journal_info.check_status=1",
                    array(
                        'journal_info.*',
                        's.supplier_name',
                        'UPPER(journal_info.bank)as bank',
                        'DATE_FORMAT(journal_info.check_date,"%m/%d/%Y")as check_date'
                    ),
                    array(
                        array('suppliers as s','s.supplier_id=journal_info.supplier_id','left')
                    )
                );
                echo json_encode($response);
                break;

            case 'get-entries':
                $journal_id=$this->input->get('id');
                $m_accounts=$this->Account_title_model;
                $m_journal_accounts=$this->Journal_account_model;

                $data['accounts']=$m_accounts->get_list();
                $data['entries']=$m_journal_accounts->get_list('journal_accounts.journal_id='.$journal_id);

                $this->load->view('template/journal_entries', $data);
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

                $m_journal->supplier_id=$this->input->post('supplier_id',TRUE);
                $m_journal->remarks=$this->input->post('remarks',TRUE);
                $m_journal->date_txn=date('Y-m-d',strtotime($this->input->post('date_txn',TRUE)));
                $m_journal->book_type='CDJ';
                $m_journal->department_id=$this->input->post('department_id');
                $m_journal->payment_method_id=$this->input->post('payment_method');
                // $m_journal->bank=$this->input->post('bank');
                $m_journal->bank_id=$this->input->post('bank_id');
                $m_journal->check_no=$this->input->post('check_no');
                $m_journal->check_date=date('Y-m-d',strtotime($this->input->post('check_date',TRUE)));
                $m_journal->ref_type=$this->input->post('ref_type');
                $m_journal->ref_no=$this->input->post('ref_no');
                $m_journal->amount=$this->get_numeric_value($this->input->post('amount'));

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

        };
    }



    public function get_response_rows($criteria=null){
        $m_journal=$this->Journal_info_model;
        return $m_journal->get_list(

            "journal_info.is_deleted=FALSE AND journal_info.book_type='CDJ'".($criteria==null?'':' AND journal_info.journal_id='.$criteria),

            array(
                'journal_info.journal_id',
                'journal_info.txn_no',
                'DATE_FORMAT(journal_info.date_txn,"%m/%d/%Y")as date_txn',
                'journal_info.is_active',
                'journal_info.remarks',
                'journal_info.department_id',
                'journal_info.bank_id',
                'journal_info.supplier_id',
                'journal_info.customer_id',
                'journal_info.payment_method_id',
                'payment_methods.payment_method',
                'journal_info.bank',
                'journal_info.check_no',
                'journal_info.check_status',
                'suppliers.supplier_name',
                'DATE_FORMAT(journal_info.check_date,"%m/%d/%Y") as check_date',
                'journal_info.ref_type',
                'journal_info.ref_no',
                'journal_info.amount',

                'CONCAT(IFNULL(customers.customer_name,""),IFNULL(suppliers.supplier_name,""))as particular',
                'CONCAT_WS(" ",user_accounts.user_fname,user_accounts.user_lname)as posted_by'
            ),
            array(
                array('customers','customers.customer_id=journal_info.customer_id','left'),
                array('suppliers','suppliers.supplier_id=journal_info.supplier_id','left'),
                array('departments','departments.department_id=journal_info.department_id','left'),
                array('user_accounts','user_accounts.user_id=journal_info.created_by_user','left'),
                array('payment_methods','payment_methods.payment_method_id=journal_info.payment_method_id','left')
            ),
            'journal_info.journal_id DESC'
        );
    }






}
