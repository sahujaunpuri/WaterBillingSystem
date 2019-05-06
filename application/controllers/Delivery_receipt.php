<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Delivery_receipt extends CORE_Controller
{

    function __construct() {
        parent::__construct('');
        $this->validate_session();

        $this->load->model('Delivery_receipt_model');
        $this->load->model('Delivery_receipt_item_model');
        $this->load->model('Refproduct_model');
        $this->load->model('Sales_invoice_model');
        $this->load->model('Departments_model');
        $this->load->model('Customers_model');
        $this->load->model('Products_model');
        $this->load->model('Invoice_counter_model');
        $this->load->model('Company_model');
        $this->load->model('Salesperson_model');
        $this->load->model('Users_model');


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
        $data['products']=$this->Products_model->get_list(
            null, //no id filter
            array(
                       'products.product_id',
                       'products.product_code',
                       'products.product_desc',
                       'products.product_desc1',
                       'products.is_tax_exempt',
                       'products.size',
                       'FORMAT(products.sale_price,2)as sale_price',
                       //'FORMAT(products.sale_price,2)as sale_price',
                       'FORMAT(products.purchase_cost,2)as purchase_cost',
                       'products.unit_id',
                       'products.on_hand',
                       'units.unit_name',
                       'tax_types.tax_type_id',
                       'tax_types.tax_rate'
            ),
            array(
                array('units','units.unit_id=products.unit_id','left'),
                array('categories','categories.category_id=products.category_id','left'),
                array('tax_types','tax_types.tax_type_id=products.tax_type_id','left')

            )

        );

        $data['invoice_counter']=$this->Invoice_counter_model->get_list(array('user_id'=>$this->session->user_id));


        $data['title'] = 'Delivery Receipt';
        
        (in_array('3-4',$this->session->user_rights)? 
        $this->load->view('delivery_receipt_view', $data)
        :redirect(base_url('dashboard')));
    }


    function transaction($txn = null,$id_filter=null) {
        switch ($txn){
            case 'current-invoice-no':
                $user_id=$this->session->user_id;
                $invoice_no=$this->get_current_invoice_no($user_id);
                $response['invoice_no']=$invoice_no;
                echo json_encode($response);
                break;

            case 'current-items':
                $type=$this->input->get('type');
                $description=$this->input->get('description');
                echo json_encode($this->Products_model->get_current_item_list($description,$type));
                break;


            case 'list':  //this returns JSON of Issuance to be rendered on Datatable
                $m_invoice=$this->Sales_invoice_model;
                $response['data']=$this->response_rows(
                    'sales_invoice.is_active=TRUE AND sales_invoice.is_deleted=FALSE'.($id_filter==null?'':' AND sales_invoice.sales_invoice_id='.$id_filter),
                    'sales_invoice.sales_invoice_id DESC'
                );
                echo json_encode($response);
                break;

            case 'list_with_count':  //this returns JSON of Issuance to be rendered on Datatable
                $response['data']=$this->response_rows_count();
                echo json_encode($response);
                break;

            ////****************************************items/products of selected Items***********************************************
            case 'items': //items on the specific PO, loads when edit button is called
                $m_items=$this->Delivery_receipt_item_model;
                $response['data']=$m_items->get_list(
                    array('delivery_receipt_id'=>$id_filter),
                    array(
                        'delivery_receipt_items.*',
                        'products.product_code',
                        'products.product_desc',
                        'units.unit_id',
                        'units.unit_name'
                    ),
                    array(
                        array('products','products.product_id=delivery_receipt_items.product_id','left'),
                        array('units','units.unit_id=delivery_receipt_items.unit_id','left')
                    ),
                    'delivery_receipt_items.delivery_receipt_item_id ASC'
                );


                echo json_encode($response);
                break;




/* ________________________ BUTTON ACCEPT OF A SALES INVOICE  CLICKED FROM DELIVERY INVOICE MODULE ______________________________ (11/09/2017)*/
            case 'item-balance':
                $m_dr_invoice=$this->Delivery_receipt_model;
                $response['data']=$m_dr_invoice->get_products_with_balance_qty_sales_invoice($id_filter);
                echo json_encode($response);

                /*$m_items=$this->Sales_order_item_model;
                $response['data']=$m_items->get_products_with_balance_qty($id_filter);
                echo json_encode($response);*/
                break;





// ********************************* OPEN INVOICES STATUS TABLE ********************************************

            case 'open-sales-invoices':  //this returns Invoices that are partially received or stil open 
                $m_sales_invoice=$this->Sales_invoice_model;
                //$where_filter=null,$select_list=null,$join_array=null,$order_by=null,$group_by=null,$auto_select_escape=TRUE,$custom_where_filter=null
                $response['data']= $m_sales_invoice->get_list(

                    'sales_invoice.is_deleted=FALSE AND sales_invoice.is_active=TRUE AND (sales_invoice.order_status_id=1 OR sales_invoice.order_status_id=3)',

                    array(
                        'sales_invoice.*',
                        'DATE_FORMAT(sales_invoice.date_invoice,"%m/%d/%Y") as date_invoice',
                        'customers.customer_name',
                        'order_status.order_status',
                        'departments.department_name'
                    ),
                    array(
                        array('customers','customers.customer_id=sales_invoice.customer_id','left'),
                        array('departments','departments.department_id=sales_invoice.department_id','left'),
                        array('order_status','order_status.order_status_id=sales_invoice.order_status_id','left')
                    ),
                    'sales_invoice.sales_invoice_id DESC'

                );
                echo json_encode($response);
            break;

            //***************************************create new Items************************************************

            
            case 'create':
                $m_dr_invoice=$this->Delivery_receipt_model;
                $m_customers=$this->Customers_model;

                $m_sales_invoice=$this->Sales_invoice_model;
                $arr_si_info=$m_sales_invoice->get_list(
                    array('sales_invoice.sales_inv_no'=>$this->input->post('sales_inv_no',TRUE)),
                    'sales_invoice.sales_invoice_id'
                );
                $sales_invoice_id=(count($arr_si_info)>0?$arr_si_info[0]->sales_invoice_id:0);
                //treat NOW() as function and not string
                $m_dr_invoice->set('date_created','NOW()'); //treat NOW() as function and not string

                $m_dr_invoice->customer_id=$this->input->post('customer',TRUE);
                $m_dr_invoice->department_id=$this->input->post('department',TRUE);
                $m_dr_invoice->address=$this->input->post('address',TRUE);
                $m_dr_invoice->sales_invoice_id=$sales_invoice_id;
                $m_dr_invoice->remarks=$this->input->post('remarks',TRUE);
                $m_dr_invoice->contact_person=$this->input->post('contact_person',TRUE);
                // $m_dr_invoice->date_due=date('Y-m-d',strtotime($this->input->post('date_due',TRUE)));
                // $m_dr_invoice->issue_to_department=$this->input->post('issue_to_department',TRUE);
                // $m_dr_invoice->salesperson_id=$this->input->post('salesperson_id',TRUE);
                // //$m_dr_invoice->inv_type=2;
                $m_dr_invoice->date_invoice=date('Y-m-d',strtotime($this->input->post('date_invoice',TRUE)));
                $m_dr_invoice->total_overall_discount_amount=$this->get_numeric_value($this->input->post('total_overall_discount_amount',TRUE));
                $m_dr_invoice->total_discount=$this->get_numeric_value($this->input->post('summary_discount',TRUE));
                $m_dr_invoice->total_overall_discount=$this->get_numeric_value($this->input->post('total_overall_discount',TRUE));
                $m_dr_invoice->total_before_tax=$this->get_numeric_value($this->input->post('summary_before_discount',TRUE));
                $m_dr_invoice->total_tax_amount=$this->get_numeric_value($this->input->post('summary_tax_amount',TRUE));
                $m_dr_invoice->total_after_tax=$this->get_numeric_value($this->input->post('summary_after_tax',TRUE));
                $m_dr_invoice->total_after_discount=$this->get_numeric_value($this->input->post('total_after_discount',TRUE));
                $m_dr_invoice->posted_by_user=$this->session->user_id;
                $m_dr_invoice->save();

                $delivery_receipt_id=$m_dr_invoice->last_insert_id();
                $m_dr_invoice->delivery_inv_no='DR-'.date('Ymd').'-'.$delivery_receipt_id;
                $m_dr_invoice->modify($delivery_receipt_id);

                $m_dr_invoice_items=$this->Delivery_receipt_item_model;

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
                // $exp_date=$this->input->post('exp_date',TRUE);
                // $batch_no=$this->input->post('batch_no',TRUE);
                // $cost_upon_invoice=$this->input->post('cost_upon_invoice',TRUE);
                

                $m_products=$this->Products_model;

                for($i=0;$i<count($prod_id);$i++){

                    $m_dr_invoice_items->delivery_receipt_id=$delivery_receipt_id;
                    $m_dr_invoice_items->product_id=$this->get_numeric_value($prod_id[$i]);
                    $m_dr_invoice_items->inv_line_total_after_global=$this->get_numeric_value($inv_line_total_after_global[$i]);
                    $m_dr_invoice_items->inv_qty=$inv_qty[$i];
                    $m_dr_invoice_items->inv_price=$this->get_numeric_value($inv_price[$i]);
                    $m_dr_invoice_items->inv_gross=$this->get_numeric_value($inv_gross[$i]);
                    $m_dr_invoice_items->inv_discount=$this->get_numeric_value($inv_discount[$i]);
                    $m_dr_invoice_items->inv_line_total_discount=$this->get_numeric_value($inv_line_total_discount[$i]);
                    $m_dr_invoice_items->inv_tax_rate=$this->get_numeric_value($inv_tax_rate[$i]);
                    $m_dr_invoice_items->inv_line_total_price=$this->get_numeric_value($inv_line_total_price[$i]);
                    $m_dr_invoice_items->inv_tax_amount=$this->get_numeric_value($inv_tax_amount[$i]);
                    $m_dr_invoice_items->inv_non_tax_amount=$this->get_numeric_value($inv_non_tax_amount[$i]);
                    $m_dr_invoice_items->sales_invoice_id=$sales_invoice_id;
                    //$m_dr_invoice_items->exp_date=date('Y-m-d', strtotime($exp_date[$i]));
                    //$m_dr_invoice_items->batch_no=$batch_no[$i];
                    //$m_dr_invoice_items->cost_upon_invoice=$this->get_numeric_value($cost_upon_invoice[$i]);

                    //unit id retrieval is change, because of TRIGGER restriction
                    $unit_id=$m_products->get_list(array('product_id'=>$prod_id[$i]));
                    $m_dr_invoice_items->unit_id=$unit_id[0]->unit_id;



                    $m_dr_invoice_items->save();
                    // $m_products->on_hand=$m_products->get_product_qty($this->get_numeric_value($prod_id[$i]));
                    // $m_products->modify($this->get_numeric_value($prod_id[$i]));
                }

                //update invoice number base on formatted last insert id



               // update status of so
                $m_sales_invoice->order_status_id=$this->get_si_status($sales_invoice_id);
                $m_sales_invoice->modify($sales_invoice_id);

                //******************************************************************************************
                // IMPORTANT!!!
                //update receivable amount field of customer table
                // $m_customers=$this->Customers_model;
                // $m_customers->recalculate_customer_receivable($this->input->post('customer',TRUE));
                //******************************************************************************************




                if($m_dr_invoice->status()===TRUE){
                    $response['title'] = 'Success!';
                    $response['stat'] = 'success';
                    $response['msg'] = 'Delivery Receipt successfully created.'.$delivery_receipt_id;
                    $response['row_added']=$this->response_rows($delivery_receipt_id);

                    echo json_encode($response);
                }


                break;

            ////***************************************update Items************************************************
            case 'update':
                $m_dr_invoice=$this->Delivery_receipt_model;
                $delivery_receipt_id=$this->input->post('delivery_receipt_id',TRUE);
                $sales_inv_no=$this->input->post('sales_inv_no',TRUE);


                $m_sales_invoice=$this->Sales_invoice_model;
                $arr_si_info=$m_sales_invoice->get_list(
                    array('sales_invoice.sales_inv_no'=>$this->input->post('sales_inv_no',TRUE)),
                    'sales_invoice.sales_invoice_id'
                );
                $sales_invoice_id=(count($arr_si_info)>0?$arr_si_info[0]->sales_invoice_id:0);

                $m_dr_invoice->customer_id=$this->input->post('customer',TRUE);
                $m_dr_invoice->department_id=$this->input->post('department',TRUE);
                $m_dr_invoice->address=$this->input->post('address',TRUE);
                $m_dr_invoice->sales_invoice_id=$sales_invoice_id;
                $m_dr_invoice->remarks=$this->input->post('remarks',TRUE);
                $m_dr_invoice->contact_person=$this->input->post('contact_person',TRUE);
                // $m_dr_invoice->date_due=date('Y-m-d',strtotime($this->input->post('date_due',TRUE)));
                // $m_dr_invoice->issue_to_department=$this->input->post('issue_to_department',TRUE);
                // $m_dr_invoice->salesperson_id=$this->input->post('salesperson_id',TRUE);
                // //$m_dr_invoice->inv_type=2;
                $m_dr_invoice->date_invoice=date('Y-m-d',strtotime($this->input->post('date_invoice',TRUE)));
                $m_dr_invoice->total_overall_discount_amount=$this->get_numeric_value($this->input->post('total_overall_discount_amount',TRUE));
                $m_dr_invoice->total_discount=$this->get_numeric_value($this->input->post('summary_discount',TRUE));
                $m_dr_invoice->total_overall_discount=$this->get_numeric_value($this->input->post('total_overall_discount',TRUE));
                $m_dr_invoice->total_before_tax=$this->get_numeric_value($this->input->post('summary_before_discount',TRUE));
                $m_dr_invoice->total_tax_amount=$this->get_numeric_value($this->input->post('summary_tax_amount',TRUE));
                $m_dr_invoice->total_after_tax=$this->get_numeric_value($this->input->post('summary_after_tax',TRUE));
                $m_dr_invoice->total_after_discount=$this->get_numeric_value($this->input->post('total_after_discount',TRUE));
                $m_dr_invoice->modified_by_user=$this->session->user_id;
                $m_dr_invoice->set('date_modified','NOW()');
                $m_dr_invoice->modify($delivery_receipt_id);

                $m_dr_invoice_items=$this->Delivery_receipt_item_model;
                $m_dr_invoice_items->delete_via_fk($delivery_receipt_id);
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
                // $exp_date=$this->input->post('exp_date',TRUE);
                // $batch_no=$this->input->post('batch_no',TRUE);
                // $cost_upon_invoice=$this->input->post('cost_upon_invoice',TRUE);
                

                $m_products=$this->Products_model;

                for($i=0;$i<count($prod_id);$i++){

                    $m_dr_invoice_items->delivery_receipt_id=$delivery_receipt_id;
                    $m_dr_invoice_items->product_id=$this->get_numeric_value($prod_id[$i]);
                    $m_dr_invoice_items->inv_line_total_after_global=$this->get_numeric_value($inv_line_total_after_global[$i]);
                    $m_dr_invoice_items->inv_qty=$inv_qty[$i];
                    $m_dr_invoice_items->inv_price=$this->get_numeric_value($inv_price[$i]);
                    $m_dr_invoice_items->inv_gross=$this->get_numeric_value($inv_gross[$i]);
                    $m_dr_invoice_items->inv_discount=$this->get_numeric_value($inv_discount[$i]);
                    $m_dr_invoice_items->inv_line_total_discount=$this->get_numeric_value($inv_line_total_discount[$i]);
                    $m_dr_invoice_items->inv_tax_rate=$this->get_numeric_value($inv_tax_rate[$i]);
                    $m_dr_invoice_items->inv_line_total_price=$this->get_numeric_value($inv_line_total_price[$i]);
                    $m_dr_invoice_items->inv_tax_amount=$this->get_numeric_value($inv_tax_amount[$i]);
                    $m_dr_invoice_items->inv_non_tax_amount=$this->get_numeric_value($inv_non_tax_amount[$i]);
                    $m_dr_invoice_items->sales_invoice_id=$sales_invoice_id;
                    //$m_dr_invoice_items->exp_date=date('Y-m-d', strtotime($exp_date[$i]));
                    //$m_dr_invoice_items->batch_no=$batch_no[$i];
                    //$m_dr_invoice_items->cost_upon_invoice=$this->get_numeric_value($cost_upon_invoice[$i]);

                    //unit id retrieval is change, because of TRIGGER restriction
                    $unit_id=$m_products->get_list(array('product_id'=>$prod_id[$i]));
                    $m_dr_invoice_items->unit_id=$unit_id[0]->unit_id;



                    $m_dr_invoice_items->save();
                    // $m_products->on_hand=$m_products->get_product_qty($this->get_numeric_value($prod_id[$i]));
                    // $m_products->modify($this->get_numeric_value($prod_id[$i]));
                }




                    //update status of so
                    $m_sales_invoice->order_status_id=$this->get_si_status($sales_invoice_id);
                    $m_sales_invoice->modify($sales_invoice_id);



                    if($m_dr_invoice->status()===TRUE){
                        $response['title'] = 'Success!';
                        $response['stat'] = 'success';
                        $response['msg'] = 'Sales invoice successfully updated.';
                        $response['row_updated']=$this->response_rows($delivery_receipt_id);

                        echo json_encode($response);
                    }




               // }


                break;


            //***************************************************************************************
            case 'delete':
                $m_dr_invoice=$this->Delivery_receipt_model;
                $m_dr_invoice_items=$this->Delivery_receipt_item_model;
                $m_products=$this->Products_model;
                $m_sales_invoice_count = $this->Customers_model;
                $delivery_receipt_id=$this->input->post('delivery_receipt_id',TRUE);


                //mark Items as deleted
                $m_dr_invoice->set('date_deleted','NOW()'); //treat NOW() as function and not string
                $m_dr_invoice->deleted_by_user=$this->session->user_id;//user that deleted the record
                $m_dr_invoice->is_deleted=1;//mark as deleted
                $m_dr_invoice->modify($delivery_receipt_id);

                $si_info=$m_dr_invoice->get_list($delivery_receipt_id,'delivery_receipt.sales_invoice_id');// get purchase order first

                if(count($si_info)>0){
                    $sales_invoice_id=$si_info[0]->sales_invoice_id;// pass to variable
                    $m_si=$this->Sales_invoice_model;
                    $m_si->order_status_id=$this->get_si_status(
                        $sales_invoice_id);
                    $m_si->modify($sales_invoice_id);

                }

                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Record successfully deleted.';
                echo json_encode($response);

                break;

         

        }

    }



//**************************************user defined*************************************************
    function response_rows($filter_value){
        return $this->Delivery_receipt_model->get_list(
            $filter_value,
            array(
                'delivery_receipt.delivery_receipt_id',
                'delivery_receipt.delivery_inv_no',
                'delivery_receipt.remarks', 
                'delivery_receipt.date_created',
                'delivery_receipt.customer_id',
                'delivery_receipt.inv_type',
                'delivery_receipt.contact_person',
                'delivery_receipt.total_overall_discount',
                'DATE_FORMAT(delivery_receipt.date_invoice,"%m/%d/%Y") as date_invoice',
                'DATE_FORMAT(delivery_receipt.date_due,"%m/%d/%Y") as date_due',
                'departments.department_id',
                'departments.department_name',
                'customers.customer_name',
                'delivery_receipt.salesperson_id',
                'delivery_receipt.address',
                'sales_invoice.sales_inv_no'
            ),
            array(
                array('departments','departments.department_id=delivery_receipt.department_id','left'),
                array('customers','customers.customer_id=delivery_receipt.customer_id','left'),
                array('sales_invoice','sales_invoice.sales_invoice_id=delivery_receipt.sales_invoice_id','left'),
            ),
            'delivery_receipt.delivery_receipt_id DESC'
        );
    }

    function response_rows_count($filter_value=null){
        return $this->Delivery_receipt_model->delivery_receipt_list_with_count();
    }


    function get_si_status($id){
        //NOTE : 1 means open, 2 means Closed, 3 means partially invoice
        $m_dr_invoice=$this->Delivery_receipt_model;

        if(count($m_dr_invoice->get_list(
                array('delivery_receipt.sales_invoice_id'=>$id,'delivery_receipt.is_active'=>TRUE,'delivery_receipt.is_deleted'=>FALSE),
                'delivery_receipt.delivery_receipt_id'))==0 ){ //means no SO found on sales invoice that means this so is still open

            return 1;

        }else{
            $m_dr_invoice=$this->Delivery_receipt_model;
            $row=$m_dr_invoice->get_sales_invoice_balance_qty($id);
            return ($row[0]->balance>0?3:2);
        }

    }




}
