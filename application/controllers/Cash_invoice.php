<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cash_invoice extends CORE_Controller
{

    function __construct() {
        parent::__construct('');
        $this->validate_session();

        $this->load->model('Cash_invoice_model');
        $this->load->model('Cash_invoice_items_model');
        $this->load->model('Refproduct_model');
        $this->load->model('Sales_order_model');
        $this->load->model('Departments_model');
        $this->load->model('Customers_model');
        $this->load->model('Products_model');
        $this->load->model('Invoice_counter_model');
        $this->load->model('Company_model');
        $this->load->model('Salesperson_model');
        $this->load->model('Users_model');
        $this->load->model('Trans_model');
        $this->load->model('Sales_invoice_model');
        $this->load->model('Customer_type_model');
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

        $data['salespersons']=$this->Salesperson_model->get_list(
            array('salesperson.is_active'=>TRUE,'salesperson.is_deleted'=>FALSE),
            'salesperson_id, acr_name, CONCAT(firstname, " ", middlename, " ", lastname) AS fullname, firstname, middlename, lastname'
        );

        //data required by active view
        $data['customers']=$this->Customers_model->get_list(
            array('customers.is_active'=>TRUE,'customers.is_deleted'=>FALSE)
        );

        $data['refproducts']=$this->Refproduct_model->get_list(
            'is_deleted=FALSE'
        );


        $tax_rate=$this->Company_model->get_list(
            null,
            array(
                'company_info.tax_type_id',
                'tt.tax_rate'
            ),
            array(
                array('tax_types as tt','tt.tax_type_id=company_info.tax_type_id','left')
            )
        );

        $data['tax_percentage']=(count($tax_rate)>0?$tax_rate[0]->tax_rate:0);

        
        $data['customer_type']=$this->Customer_type_model->get_list(
            'is_deleted=FALSE'
        );
 
        $data['invoice_counter']=$this->Invoice_counter_model->get_list(array('user_id'=>$this->session->user_id));
        
        $data['customer_type_create']=$this->Customer_type_model->get_list(
            'is_deleted=FALSE'
        );
 

        $data['title'] = 'Cash Invoice';
        
        (in_array('3-4',$this->session->user_rights)? 
        $this->load->view('cash_invoice_view', $data)
        :redirect(base_url('dashboard')));
    }


    function transaction($txn = null,$id_filter=null) {
        switch ($txn){


            case'close-invoice':  
            $m_sales=$this->Cash_invoice_model;
            $cash_invoice_id =$this->input->post('cash_invoice_id');
            $m_sales->closing_reason = $this->input->post('closing_reason');
            $m_sales->closed_by_user = $this->session->user_id;
            $m_sales->is_closed = TRUE;
            $m_sales->modify($cash_invoice_id);


            $cash_inv_info=$m_sales->get_list($cash_invoice_id,'cash_inv_no');
            $m_trans=$this->Trans_model;
            $m_trans->user_id=$this->session->user_id;
            $m_trans->set('trans_date','NOW()');
            $m_trans->trans_key_id=11; //CRUD
            $m_trans->trans_type_id=65; // TRANS TYPE
            $m_trans->trans_log='Closed/ Did Not Post Cash Invoice No: '.$cash_inv_info[0]->cash_inv_no.' from Cash Receipt Pending with reason: '.$this->input->post('closing_reason');
            $m_trans->save();
            $response['title'] = 'Success!';
            $response['stat'] = 'success';
            $response['msg'] = 'Cash Invoice successfully closed.';
            echo json_encode($response);    

            break;
            
            case 'list':
            $m_pf_invoice = $this->Cash_invoice_model;
            $response['data']=$this->response_rows();
                    echo json_encode($response);

        
            break;



            ////****************************************items/products of selected Items***********************************************
            case 'items': //items on the specific PO, loads when edit button is called
                $m_items=$this->Cash_invoice_items_model;
                $response['data']=$m_items->get_list(
                    array('cash_invoice_id'=>$id_filter),
                    array(
                        'cash_invoice_items.*',
                        'products.product_code',
                        'products.product_desc',
                        'units.unit_id',
                        'units.unit_name',
                        'products.is_bulk',
                        'products.child_unit_id',
                        'products.parent_unit_id',
                        'products.child_unit_desc',
                        'products.discounted_price',
                        'products.dealer_price',
                        'products.distributor_price',
                        'products.public_price',
                        'products.sale_price',
                        '(SELECT units.unit_name  FROM units WHERE  units.unit_id = products.parent_unit_id) as parent_unit_name',
                        '(SELECT units.unit_name  FROM units WHERE  units.unit_id = products.child_unit_id) as child_unit_name'
                    ),
                    array(
                        array('products','products.product_id=cash_invoice_items.product_id','left'),
                        array('units','units.unit_id=cash_invoice_items.unit_id','left')
                    ),
                    'cash_invoice_items.cash_item_id ASC'
                );


                echo json_encode($response);
                break;


            //***************************************create new Items************************************************

            
            case 'create':
                $m_invoice=$this->Cash_invoice_model;
                $m_customers=$this->Customers_model;
                $m_invoice->begin();

                //treat NOW() as function and not string
                $m_invoice->set('date_created','NOW()'); //treat NOW() as function and not string
                $m_so=$this->Sales_order_model;
                $arr_so_info=$m_so->get_list(
                    array('sales_order.so_no'=>$this->input->post('so_no',TRUE)),
                    'sales_order.sales_order_id'
                );
                $sales_order_id=(count($arr_so_info)>0?$arr_so_info[0]->sales_order_id:0);
                $m_invoice->sales_order_id=$sales_order_id;
                $m_invoice->customer_type_id=$this->input->post('customer_type_id',TRUE);
                $m_invoice->customer_id=$this->input->post('customer',TRUE);
                $m_invoice->sales_order_no=$this->input->post('so_no',TRUE);
                $m_invoice->department_id=$this->input->post('department',TRUE);
                $m_invoice->issue_to_department=$this->input->post('issue_to_department',TRUE);
                $m_invoice->address=$this->input->post('address',TRUE);
                $m_invoice->remarks=$this->input->post('remarks',TRUE);
                $m_invoice->contact_no=$this->input->post('contact_no',TRUE);
                $m_invoice->salesperson_id=$this->input->post('salesperson_id',TRUE);
                $m_invoice->email_address=$this->input->post('email_address',TRUE);
                $m_invoice->contact_person=$this->input->post('contact_person',TRUE);
                $m_invoice->date_due=date('Y-m-d',strtotime($this->input->post('date_due',TRUE)));
                $m_invoice->date_invoice=date('Y-m-d',strtotime($this->input->post('date_invoice',TRUE)));
                $m_invoice->total_overall_discount_amount=$this->get_numeric_value($this->input->post('total_overall_discount_amount',TRUE));
                $m_invoice->total_discount=$this->get_numeric_value($this->input->post('summary_discount',TRUE));
                $m_invoice->total_overall_discount=$this->get_numeric_value($this->input->post('total_overall_discount',TRUE));
                $m_invoice->total_before_tax=$this->get_numeric_value($this->input->post('summary_before_discount',TRUE));
                $m_invoice->total_tax_amount=$this->get_numeric_value($this->input->post('summary_tax_amount',TRUE));
                $m_invoice->total_after_tax=$this->get_numeric_value($this->input->post('summary_after_tax',TRUE));
                $m_invoice->total_after_discount=$this->get_numeric_value($this->input->post('total_after_discount',TRUE));
                $m_invoice->posted_by_user=$this->session->user_id;
                $m_invoice->save();

                $cash_invoice_id=$m_invoice->last_insert_id();

                $m_invoice_items=$this->Cash_invoice_items_model;

                $prod_id=$this->input->post('product_id',TRUE);
                $inv_qty=$this->input->post('inv_qty',TRUE);
                $inv_price=$this->input->post('inv_price',TRUE);
                $inv_gross=$this->input->post('inv_gross',TRUE);
                $inv_discount=$this->input->post('inv_discount',TRUE);
                $inv_line_total_discount=$this->input->post('inv_line_total_discount',TRUE);
                $inv_tax_rate=$this->input->post('inv_tax_rate',TRUE);
                $inv_line_total_price=$this->input->post('inv_line_total_price',TRUE);
                $inv_tax_amount=$this->input->post('inv_tax_amount',TRUE);
                $inv_non_tax_amount=$this->input->post('inv_non_tax_amount',TRUE);
                $inv_line_total_after_global=$this->input->post('inv_line_total_after_global',TRUE);
                $dr_invoice_id=$this->input->post('dr_invoice_id',TRUE);
                $exp_date=$this->input->post('exp_date',TRUE);
                $batch_no=$this->input->post('batch_no',TRUE);
                $cost_upon_invoice=$this->input->post('cost_upon_invoice',TRUE);
                $is_parent=$this->input->post('is_parent',TRUE);

                $m_products=$this->Products_model;

                for($i=0;$i<count($prod_id);$i++){

                    $m_invoice_items->cash_invoice_id=$cash_invoice_id;
                    $m_invoice_items->product_id=$this->get_numeric_value($prod_id[$i]);
                    $m_invoice_items->inv_line_total_after_global=$this->get_numeric_value($inv_line_total_after_global[$i]);
                    $m_invoice_items->inv_qty=$this->get_numeric_value($inv_qty[$i]);
                    $m_invoice_items->inv_price=$this->get_numeric_value($inv_price[$i]);
                    $m_invoice_items->inv_gross=$this->get_numeric_value($inv_gross[$i]);
                    $m_invoice_items->inv_discount=$this->get_numeric_value($inv_discount[$i]);
                    $m_invoice_items->inv_line_total_discount=$this->get_numeric_value($inv_line_total_discount[$i]);
                    $m_invoice_items->inv_tax_rate=$this->get_numeric_value($inv_tax_rate[$i]);
                    $m_invoice_items->inv_line_total_price=$this->get_numeric_value($inv_line_total_price[$i]);
                    $m_invoice_items->inv_tax_amount=$this->get_numeric_value($inv_tax_amount[$i]);
                    $m_invoice_items->inv_non_tax_amount=$this->get_numeric_value($inv_non_tax_amount[$i]);

                    $m_invoice_items->is_parent=$this->get_numeric_value($is_parent[$i]);
                    if($is_parent[$i] == '1'){
                            $unit_id=$m_products->get_list(array('product_id'=>$prod_id[$i]));
                            $m_invoice_items->unit_id=$unit_id[0]->parent_unit_id;
                    }else{
                             $unit_id=$m_products->get_list(array('product_id'=>$prod_id[$i]));
                            $m_invoice_items->unit_id=$unit_id[0]->child_unit_id;
                    }   

                    $unit_id=$m_products->get_list(array('product_id'=>$prod_id[$i]));

                    $m_invoice_items->save();
                }

                //update invoice number base on formatted last insert id
                $m_invoice->cash_inv_no='CI-INV-'.date('Ymd').'-'.$cash_invoice_id;
                $m_invoice->modify($cash_invoice_id);


                $m_so->order_status_id=$this->get_so_status($sales_order_id);
                $m_so->modify($sales_order_id);

                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=1; //CRUD
                $m_trans->trans_type_id=65; // TRANS TYPE
                $m_trans->trans_log='Created Cash Invoice No: CI-INV-'.date('Ymd').'-'.$cash_invoice_id;
                $m_trans->save();
                $m_invoice->commit();

                if($m_invoice->status()===TRUE){
                    $response['title'] = 'Success!';
                    $response['stat'] = 'success';
                    $response['msg'] = 'Cash Invoice successfully created.';
                    $response['row_added']=$this->response_rows($cash_invoice_id);

                    echo json_encode($response);
                }


                break;


            ////***************************************update Items************************************************
            case 'update':
                $m_invoice=$this->Cash_invoice_model;
                $cash_invoice_id=$this->input->post('cash_invoice_id',TRUE);
                $sales_inv_no=$this->input->post('cash_inv_no',TRUE);

                    $m_invoice->begin();

                    $m_so=$this->Sales_order_model;
                    $arr_so_info=$m_so->get_list(
                        array('sales_order.so_no'=>$this->input->post('so_no',TRUE)),
                        'sales_order.sales_order_id'
                    );
                    $sales_order_id=(count($arr_so_info)>0?$arr_so_info[0]->sales_order_id:0);
                    $m_invoice->sales_order_id=$sales_order_id;
                    $m_invoice->customer_type_id=$this->input->post('customer_type_id',TRUE);
                    $m_invoice->customer_id=$this->input->post('customer',TRUE);
                    $m_invoice->department_id=$this->input->post('department',TRUE);
                    $m_invoice->remarks=$this->input->post('remarks',TRUE);
                    $m_invoice->customer_id=$this->input->post('customer',TRUE);
                    $m_invoice->salesperson_id=$this->input->post('salesperson_id',TRUE);
                    $m_invoice->contact_no=$this->input->post('contact_no',TRUE);
                    $m_invoice->email_address=$this->input->post('email_address',TRUE);
                    $m_invoice->date_invoice=date('Y-m-d',strtotime($this->input->post('date_invoice',TRUE)));
                    $m_invoice->contact_person=$this->input->post('contact_person',TRUE);
                    $m_invoice->total_overall_discount=$this->get_numeric_value($this->input->post('total_overall_discount',TRUE));
                    $m_invoice->total_overall_discount_amount=$this->get_numeric_value($this->input->post('total_overall_discount_amount',TRUE));
                    $m_invoice->total_discount=$this->get_numeric_value($this->input->post('summary_discount',TRUE));
                    $m_invoice->total_before_tax=$this->get_numeric_value($this->input->post('summary_before_discount',TRUE));
                    $m_invoice->total_tax_amount=$this->get_numeric_value($this->input->post('summary_tax_amount',TRUE));
                    $m_invoice->total_after_tax=$this->get_numeric_value($this->input->post('summary_after_tax',TRUE));
                    $m_invoice->total_after_discount=$this->get_numeric_value($this->input->post('total_after_discount',TRUE));
                    $m_invoice->address=$this->input->post('address',TRUE);
                    $m_invoice->modified_by_user=$this->session->user_id;
                    $m_invoice->modify($cash_invoice_id);



                $m_invoice_items=$this->Cash_invoice_items_model;
                $m_invoice_items->delete_via_fk($cash_invoice_id);

                $prod_id=$this->input->post('product_id',TRUE);
                $inv_qty=$this->input->post('inv_qty',TRUE);
                $inv_price=$this->input->post('inv_price',TRUE);
                $inv_gross=$this->input->post('inv_gross',TRUE);
                $inv_discount=$this->input->post('inv_discount',TRUE);
                $inv_line_total_discount=$this->input->post('inv_line_total_discount',TRUE);
                $inv_tax_rate=$this->input->post('inv_tax_rate',TRUE);
                $inv_line_total_price=$this->input->post('inv_line_total_price',TRUE);
                $inv_tax_amount=$this->input->post('inv_tax_amount',TRUE);
                $inv_non_tax_amount=$this->input->post('inv_non_tax_amount',TRUE);
                $inv_line_total_after_global=$this->input->post('inv_line_total_after_global',TRUE);
                $dr_invoice_id=$this->input->post('dr_invoice_id',TRUE);
                $exp_date=$this->input->post('exp_date',TRUE);
                $batch_no=$this->input->post('batch_no',TRUE);
                $cost_upon_invoice=$this->input->post('cost_upon_invoice',TRUE);
                $is_parent=$this->input->post('is_parent',TRUE);

                $m_products=$this->Products_model;

                for($i=0;$i<count($prod_id);$i++){

                    $m_invoice_items->cash_invoice_id=$cash_invoice_id;
                    $m_invoice_items->product_id=$this->get_numeric_value($prod_id[$i]);
                    $m_invoice_items->inv_line_total_after_global=$this->get_numeric_value($inv_line_total_after_global[$i]);
                    $m_invoice_items->inv_qty=$this->get_numeric_value($inv_qty[$i]);
                    $m_invoice_items->inv_price=$this->get_numeric_value($inv_price[$i]);
                    $m_invoice_items->inv_gross=$this->get_numeric_value($inv_gross[$i]);
                    $m_invoice_items->inv_discount=$this->get_numeric_value($inv_discount[$i]);
                    $m_invoice_items->inv_line_total_discount=$this->get_numeric_value($inv_line_total_discount[$i]);
                    $m_invoice_items->inv_tax_rate=$this->get_numeric_value($inv_tax_rate[$i]);
                    $m_invoice_items->inv_line_total_price=$this->get_numeric_value($inv_line_total_price[$i]);
                    $m_invoice_items->inv_tax_amount=$this->get_numeric_value($inv_tax_amount[$i]);
                    $m_invoice_items->inv_non_tax_amount=$this->get_numeric_value($inv_non_tax_amount[$i]);

                    $m_invoice_items->is_parent=$this->get_numeric_value($is_parent[$i]);
                    if($is_parent[$i] == '1'){
                        $unit_id=$m_products->get_list(array('product_id'=>$prod_id[$i]));
                        $m_invoice_items->unit_id=$unit_id[0]->parent_unit_id;
                    }else{
                         $unit_id=$m_products->get_list(array('product_id'=>$prod_id[$i]));
                        $m_invoice_items->unit_id=$unit_id[0]->child_unit_id;
                    }   

                    //unit id retrieval is change, because of TRIGGER restriction
                    $unit_id=$m_products->get_list(array('product_id'=>$prod_id[$i]));
                    $m_invoice_items->save();
                }

                    $m_so->order_status_id=$this->get_so_status($sales_order_id);
                    $m_so->modify($sales_order_id);

                    $cash_inv=$m_invoice->get_list($cash_invoice_id,'cash_inv_no');
                    $m_trans=$this->Trans_model;
                    $m_trans->user_id=$this->session->user_id;
                    $m_trans->set('trans_date','NOW()');
                    $m_trans->trans_key_id=2; //CRUD
                    $m_trans->trans_type_id=65; // TRANS TYPE
                    $m_trans->trans_log='Updated Cash Invoice No: '.$cash_inv[0]->cash_inv_no;
                    $m_trans->save();

                    $m_invoice->commit();



                    if($m_invoice->status()===TRUE){
                        $response['title'] = 'Success!';
                        $response['stat'] = 'success';
                        $response['msg'] = 'Cash Invoice successfully updated.';
                        $response['row_updated']=$this->response_rows($cash_invoice_id);

                        echo json_encode($response);
                    }




               // }


                break;


            //***************************************************************************************
            case 'delete':

                $m_invoice=$this->Cash_invoice_model;
                $m_invoice_items=$this->Cash_invoice_items_model;
                $cash_invoice_id=$this->input->post('cash_invoice_id',TRUE);

                $m_invoice->set('date_deleted','NOW()'); //treat NOW() as function and not string
                $m_invoice->deleted_by_user=$this->session->user_id;//user that deleted the record
                $m_invoice->is_deleted=1;//mark as deleted
                $m_invoice->modify($cash_invoice_id);



                $so_info=$m_invoice->get_list($cash_invoice_id,'cash_invoice.sales_order_id');// get purchase order first

                if(count($so_info)>0){
                    $sales_order_id=$so_info[0]->sales_order_id;// pass to variable
                    $m_so=$this->Sales_order_model;
                    $m_so->order_status_id=$this->get_so_status(
                        $sales_order_id);
                    $m_so->modify($sales_order_id);

                }

                $cash_inv=$m_invoice->get_list($cash_invoice_id,'cash_inv_no');
                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=3; //CRUD
                $m_trans->trans_type_id=65; // TRANS TYPE
                $m_trans->trans_log='Deleted Cash Invoice No: '.$cash_inv[0]->cash_inv_no;
                $m_trans->save();

                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Record successfully deleted.';
                echo json_encode($response);

                break;

            case 'cash-for-review':
                $m_invoice=$this->Cash_invoice_model;
                $response['data']=$m_invoice->get_cash_invoice_for_review(); 
                echo json_encode($response);
                break;
        }

    }


    function get_so_status($id){
        //NOTE : 1 means open, 2 means Closed, 3 means partially invoice
        $m_sales_invoice=$this->Sales_invoice_model;
        $m_cash_invoice=$this->Cash_invoice_model;

        if(count($m_sales_invoice->get_list(
                array('sales_invoice.sales_order_id'=>$id,'sales_invoice.is_active'=>TRUE,'sales_invoice.is_deleted'=>FALSE),
                'sales_invoice.sales_invoice_id'))==0  &&

            count($m_cash_invoice->get_list(
                array('cash_invoice.sales_order_id'=>$id,'cash_invoice.is_active'=>TRUE,'cash_invoice.is_deleted'=>FALSE),
                'cash_invoice.cash_invoice_id'))==0 


                ){ //means no SO found on sales invoice that means this so is still open

            return 1;

        }else{
            $m_so=$this->Sales_order_model;
            $row=$m_so->get_so_balance_qty($id);
            return ($row[0]->Balance>0?3:2);
        }

    }


    function response_rows($id_filter=null,$show_unposted=FALSE){
        return $this->Cash_invoice_model->get_list(
            'cash_invoice.is_active = TRUE AND cash_invoice.is_deleted = FALSE '.($id_filter==null?'':' AND cash_invoice.cash_invoice_id='.$id_filter). ($show_unposted==FALSE?"":" AND cash_invoice.is_journal_posted=FALSE "),
            array(
                'cash_invoice.*',
                'DATE_FORMAT(cash_invoice.date_invoice,"%m/%d/%Y") as date_invoice',
                'DATE_FORMAT(cash_invoice.date_due,"%m/%d/%Y") as date_due',
                'departments.department_id',
                'departments.department_name',
                'customers.customer_name',
                'cash_invoice.salesperson_id',
                'cash_invoice.customer_type_id',
                'cash_invoice.address',
                'sales_order.so_no'
            ),
            array(
                array('departments','departments.department_id=cash_invoice.department_id','left'),
                array('customers','customers.customer_id=cash_invoice.customer_id','left'),
                array('sales_order','sales_order.sales_order_id=cash_invoice.sales_order_id','left'),
            ),
            'cash_invoice.cash_invoice_id DESC'
        );
    }


}
