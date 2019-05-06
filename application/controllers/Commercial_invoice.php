<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Commercial_invoice extends CORE_Controller
{

    function __construct() {
        parent::__construct('');
        $this->validate_session();

        $this->load->model('Commercial_invoice_model');
        $this->load->model('Commercial_invoice_items_model');
        $this->load->model('Refproduct_model');
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
                // parameter (table to join(left) , the reference field)
                array('units','units.unit_id=products.unit_id','left'),
                array('categories','categories.category_id=products.category_id','left'),
                array('tax_types','tax_types.tax_type_id=products.tax_type_id','left')

            )

        );

        $data['invoice_counter']=$this->Invoice_counter_model->get_list(array('user_id'=>$this->session->user_id));


        $data['title'] = 'Commercial Invoice';
        
        (in_array('15-2',$this->session->user_rights)? 
        $this->load->view('commercial_invoice_view', $data)
        :redirect(base_url('dashboard')));
    }


    function transaction($txn = null,$id_filter=null) {
        switch ($txn){
            case 'list':
            $m_pf_invoice = $this->Commercial_invoice_model;
            $response['data']=$this->response_rows(array('commercial_invoice.is_active'=>TRUE, 'commercial_invoice.is_deleted'=>FALSE));
                    echo json_encode($response);

        
            break;



            ////****************************************items/products of selected Items***********************************************
            case 'items': //items on the specific PO, loads when edit button is called
                $m_items=$this->Commercial_invoice_items_model;
                $response['data']=$m_items->get_list(
                    array('commercial_invoice_id'=>$id_filter),
                    array(
                        'commercial_invoice_items.*',
                        'products.product_code',
                        'products.product_desc',
                        'units.unit_id',
                        'units.unit_name'
                    ),
                    array(
                        array('products','products.product_id=commercial_invoice_items.product_id','left'),
                        array('units','units.unit_id=commercial_invoice_items.unit_id','left')
                    ),
                    'commercial_invoice_items.commercial_item_id ASC'
                );


                echo json_encode($response);
                break;


            //***************************************create new Items************************************************

            
            case 'create':
                $m_invoice=$this->Commercial_invoice_model;
                $m_customers=$this->Customers_model;


                //get sales order id base on SO number



                $m_invoice->begin();

                //treat NOW() as function and not string
                $m_invoice->set('date_created','NOW()'); //treat NOW() as function and not string

                // $m_invoice->customer_id=$this->input->post('customer',TRUE);
                // $m_invoice->department_id=$this->input->post('department',TRUE);
                // $m_invoice->issue_to_department=$this->input->post('issue_to_department',TRUE);
                // $m_invoice->address=$this->input->post('address',TRUE);
                $m_invoice->remarks=$this->input->post('remarks',TRUE);
                // $m_invoice->contact_person=$this->input->post('contact_person',TRUE);
                // $m_invoice->date_due=date('Y-m-d',strtotime($this->input->post('date_due',TRUE)));


                $m_invoice->bill_customer=$this->input->post('bill_customer');
                $m_invoice->bill_address=$this->input->post('bill_address');
                $m_invoice->bill_email=$this->input->post('bill_email');
                $m_invoice->ship_customer=$this->input->post('ship_customer');
                $m_invoice->ship_address=$this->input->post('ship_address');
                $m_invoice->ship_contact=$this->input->post('ship_contact');
                $m_invoice->ship_number=$this->input->post('ship_number');
                $m_invoice->ship_city=$this->input->post('ship_city');
                $m_invoice->ship_zipcode=$this->input->post('ship_zipcode');

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

                $commercial_invoice_id=$m_invoice->last_insert_id();

                $m_invoice_items=$this->Commercial_invoice_items_model;

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
                

                $m_products=$this->Products_model;

                for($i=0;$i<count($prod_id);$i++){

                    $m_invoice_items->commercial_invoice_id=$commercial_invoice_id;
                    $m_invoice_items->product_id=$this->get_numeric_value($prod_id[$i]);
                    $m_invoice_items->inv_line_total_after_global=$this->get_numeric_value($inv_line_total_after_global[$i]);
                    //+$m_invoice_items->inv_qty=$this->get_numeric_value($inv_qty[$i]);
                    $m_invoice_items->inv_qty=$inv_qty[$i];
                    $m_invoice_items->inv_price=$this->get_numeric_value($inv_price[$i]);
                    $m_invoice_items->inv_gross=$this->get_numeric_value($inv_gross[$i]);
                    $m_invoice_items->inv_discount=$this->get_numeric_value($inv_discount[$i]);
                    $m_invoice_items->inv_line_total_discount=$this->get_numeric_value($inv_line_total_discount[$i]);
                    $m_invoice_items->inv_tax_rate=$this->get_numeric_value($inv_tax_rate[$i]);
                    $m_invoice_items->inv_line_total_price=$this->get_numeric_value($inv_line_total_price[$i]);
                    $m_invoice_items->inv_tax_amount=$this->get_numeric_value($inv_tax_amount[$i]);
                    $m_invoice_items->inv_non_tax_amount=$this->get_numeric_value($inv_non_tax_amount[$i]);


                    //unit id retrieval is change, because of TRIGGER restriction
                    $unit_id=$m_products->get_list(array('product_id'=>$prod_id[$i]));
                    $m_invoice_items->unit_id=$unit_id[0]->unit_id;
                    $m_invoice_items->save();
                }

                //update invoice number base on formatted last insert id
                $m_invoice->commercial_inv_no='COM-INV-'.date('Ymd').'-'.$commercial_invoice_id;
                $m_invoice->modify($commercial_invoice_id);



                $m_invoice->commit();



                if($m_invoice->status()===TRUE){
                    $response['title'] = 'Success!';
                    $response['stat'] = 'success';
                    $response['msg'] = 'Commercial Invoice successfully created.';
                    $response['row_added']=$this->response_rows($commercial_invoice_id);

                    echo json_encode($response);
                }


                break;


            ////***************************************update Items************************************************
            case 'update':
                $m_invoice=$this->Commercial_invoice_model;
                $commercial_invoice_id=$this->input->post('commercial_invoice_id',TRUE);


                    $m_invoice->begin();


                    // $m_invoice->customer_id=$this->input->post('customer',TRUE);
                    // $m_invoice->department_id=$this->input->post('department',TRUE);
                    $m_invoice->remarks=$this->input->post('remarks',TRUE);
                    // $m_invoice->customer_id=$this->input->post('customer',TRUE);
                    // $m_invoice->salesperson_id=$this->input->post('salesperson_id',TRUE);
                    // $m_invoice->sales_order_id=$sales_order_id;
                    // $m_invoice->date_due=date('Y-m-d',strtotime($this->input->post('date_due',TRUE)));
                    $m_invoice->bill_customer=$this->input->post('bill_customer');
                    $m_invoice->bill_address=$this->input->post('bill_address');
                    $m_invoice->bill_email=$this->input->post('bill_email');
                    $m_invoice->ship_customer=$this->input->post('ship_customer');
                    $m_invoice->ship_address=$this->input->post('ship_address');
                    $m_invoice->ship_contact=$this->input->post('ship_contact');
                    $m_invoice->ship_number=$this->input->post('ship_number');
                    $m_invoice->ship_city=$this->input->post('ship_city');
                    $m_invoice->ship_zipcode=$this->input->post('ship_zipcode');
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
                    $m_invoice->modify($commercial_invoice_id);



                $m_invoice_items=$this->Commercial_invoice_items_model;
                $m_invoice_items->delete_via_fk($commercial_invoice_id);

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
                

                $m_products=$this->Products_model;

                for($i=0;$i<count($prod_id);$i++){

                    $m_invoice_items->commercial_invoice_id=$commercial_invoice_id;
                    $m_invoice_items->product_id=$this->get_numeric_value($prod_id[$i]);
                    $m_invoice_items->inv_line_total_after_global=$this->get_numeric_value($inv_line_total_after_global[$i]);
                    //+$m_invoice_items->inv_qty=$this->get_numeric_value($inv_qty[$i]);
                    $m_invoice_items->inv_qty=$inv_qty[$i];
                    $m_invoice_items->inv_price=$this->get_numeric_value($inv_price[$i]);
                    $m_invoice_items->inv_gross=$this->get_numeric_value($inv_gross[$i]);
                    $m_invoice_items->inv_discount=$this->get_numeric_value($inv_discount[$i]);
                    $m_invoice_items->inv_line_total_discount=$this->get_numeric_value($inv_line_total_discount[$i]);
                    $m_invoice_items->inv_tax_rate=$this->get_numeric_value($inv_tax_rate[$i]);
                    $m_invoice_items->inv_line_total_price=$this->get_numeric_value($inv_line_total_price[$i]);
                    $m_invoice_items->inv_tax_amount=$this->get_numeric_value($inv_tax_amount[$i]);
                    $m_invoice_items->inv_non_tax_amount=$this->get_numeric_value($inv_non_tax_amount[$i]);


                    //unit id retrieval is change, because of TRIGGER restriction
                    $unit_id=$m_products->get_list(array('product_id'=>$prod_id[$i]));
                    $m_invoice_items->unit_id=$unit_id[0]->unit_id;
                    $m_invoice_items->save();
                }

                    $m_invoice->commit();



                    if($m_invoice->status()===TRUE){
                        $response['title'] = 'Success!';
                        $response['stat'] = 'success';
                        $response['msg'] = 'Commercial Invoice successfully updated.';
                        $response['row_updated']=$this->response_rows($commercial_invoice_id);

                        echo json_encode($response);
                    }




               // }


                break;


            //***************************************************************************************
            case 'delete':

                $m_invoice=$this->Commercial_invoice_model;
                $m_invoice_items=$this->Commercial_invoice_items_model;
                $commercial_invoice_id=$this->input->post('commercial_invoice_id',TRUE);

                $m_invoice->set('date_deleted','NOW()'); //treat NOW() as function and not string
                $m_invoice->deleted_by_user=$this->session->user_id;//user that deleted the record
                $m_invoice->is_deleted=1;//mark as deleted
                $m_invoice->modify($commercial_invoice_id);


                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Record successfully deleted.';
                echo json_encode($response);

                break;

        }

    }


    function response_rows($filter_value){
        return $this->Commercial_invoice_model->get_list(
            $filter_value,
            array(
                'commercial_invoice.*',
                'DATE_FORMAT(commercial_invoice.date_invoice,"%m/%d/%Y") as date_invoice',
                'DATE_FORMAT(commercial_invoice.date_due,"%m/%d/%Y") as date_due',
                // 'departments.department_id',
                // 'departments.department_name',
                // 'customers.customer_name',
                // 'commercial_invoice.salesperson_id',
                // 'commercial_invoice.address',
                // 'sales_order.so_no'
            ),
            array(
                // array('departments','departments.department_id=commercial_invoice.department_id','left'),
                // array('customers','customers.customer_id=commercial_invoice.customer_id','left'),
                // array('sales_order','sales_order.sales_order_id=commercial_invoice.sales_order_id','left'),
            ),
            'commercial_invoice.commercial_invoice_id DESC'
        );
    }





}
