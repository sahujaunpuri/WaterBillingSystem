<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CORE_Controller
{

    function __construct() {
        parent::__construct('');
        $this->validate_session();
        $this->load->library('excel');
        $this->load->model('Products_model');
        $this->load->model('Categories_model');
        $this->load->model('Units_model');
        $this->load->model('Item_type_model');
        $this->load->model('Account_title_model');
        $this->load->model('Refproduct_model');
        $this->load->model('Suppliers_model');
        $this->load->model('Tax_model');
        $this->load->model('Purchases_model');
        $this->load->model('Purchase_items_model');
        $this->load->model('Sales_order_model');
        $this->load->model('Sales_order_item_model');
        $this->load->model('Sales_invoice_model');
        $this->load->model('Sales_invoice_item_model');
        $this->load->model('Issuance_model');
        $this->load->model('Issuance_item_model');
        $this->load->model('Delivery_invoice_model');
        $this->load->model('Delivery_invoice_item_model');
        $this->load->model('Users_model');
        $this->load->model('Account_integration_model');
        $this->load->model('Company_model');
        $this->load->model('Trans_model');
        $this->load->model('Brands_model');
    }

    public function index() {
        $this->Users_model->validate();
        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', TRUE);
        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', TRUE);
        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', TRUE);
        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', TRUE);
        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', TRUE);
        $data['title'] = 'Product Management';

        $data['tax_types']=$this->Tax_model->get_list();
        $data['suppliers']=$this->Suppliers_model->get_list(
            array('suppliers.is_deleted'=>FALSE),
            'suppliers.*,IFNULL(tax_types.tax_rate,0)as tax_rate',
            array(
                array('tax_types','tax_types.tax_type_id=suppliers.tax_type_id','left')
            )
        );
        $data['refproduct'] = $this->Refproduct_model->get_list(array('refproduct.is_deleted'=>FALSE));
        $data['categories'] = $this->Categories_model->get_list(array('categories.is_deleted'=>FALSE));
        $data['units'] = $this->Units_model->get_list(array('units.is_deleted'=>FALSE));
        $data['item_types'] = $this->Item_type_model->get_list(array('item_types.is_deleted'=>FALSE));
        $data['accounts'] = $this->Account_title_model->get_list('is_active= TRUE AND is_deleted = FALSE','account_id,account_title');
        $data['tax_types']=$this->Tax_model->get_list(array('tax_types.is_deleted'=>FALSE));
        $data['brands']= $this->Brands_model->get_brand_list();
        // (in_array('5-1',$this->session->user_rights)? 
        // $this->load->view('products_view', $data)
        // :redirect(base_url('dashboard')));
        
        if(in_array('5-1',$this->session->user_rights)){
            $this->load->view('products_view', $data);
        }elseif (in_array('15-1',$this->session->user_rights)) {
            $this->load->view('products_view', $data);
        }else{
            redirect(base_url('dashboard'));
        }
    }

    function transaction($txn = null) {
        switch ($txn) {
                // Products List, All Sales and Cash Invoices are included in the computation. 
                //Inventory Report is the only report where Cash and Sales invoice inclusion is optional
            case 'list':
                $m_products = $this->Products_model;
                $response['data']=$m_products->product_list(1,null,null,null,null,null,null,null,1);
                // $response['data']=$this->response_rows(array('products.is_deleted'=>FALSE));
                echo json_encode($response);
                break;

            case 'getproduct':
                $refproduct_id = $this->input->post('refproduct_id', TRUE);
                $get = "";

                if($refproduct_id == 1){
                    $get = array('products.refproduct_id'=>$refproduct_id,'products.is_deleted'=>FALSE);
                }

                elseif($refproduct_id == 2){
                    $get = array('products.refproduct_id'=>$refproduct_id,'products.is_deleted'=>FALSE);
                }

                else {
                    $get = array('products.is_deleted'=>FALSE);
                }

                $response['data'] = $this->response_rows($get);
                echo json_encode($response);
                break;

            case 'create':
                $m_products = $this->Products_model;

                $m_products->set('date_created','NOW()');
                $m_products->created_by_user = $this->session->user_id;

                $m_products->product_code = $this->input->post('product_code', TRUE);
                $m_products->product_desc = $this->input->post('product_desc', TRUE);
                $m_products->product_desc1 = $this->input->post('product_desc1', TRUE);
                $m_products->brand_id = $this->input->post('brand_id', TRUE);
                $m_products->size = $this->input->post('size', TRUE);
                $m_products->supplier_id = $this->input->post('supplier_id', TRUE);
                $m_products->category_id = $this->input->post('category_id', TRUE);
                $m_products->refproduct_id = $this->input->post('refproduct_id', TRUE);
                $m_products->item_type_id = $this->input->post('item_type_id', TRUE);
                $m_products->income_account_id = $this->input->post('income_account_id', TRUE);
                $m_products->expense_account_id = $this->input->post('expense_account_id', TRUE);
                $m_products->parent_unit_id = $this->input->post('parent_unit_id', TRUE);

                $m_products->is_bulk =$this->get_numeric_value($this->input->post('is_bulk',TRUE));
                $m_products->child_unit_desc = $this->get_numeric_value($this->input->post('child_unit_desc', TRUE));
                $m_products->child_unit_id = $this->input->post('child_unit_id', TRUE);  
  

        
                $m_products->tax_type_id = $this->input->post('tax_type_id', TRUE);
                //$m_products->is_inventory = $this->input->post('inventory',TRUE);

                 //im not sure, why posted checkbox post value of 0 when checked
               $m_products->primary_unit =$this->get_numeric_value($this->input->post('primary_unit',TRUE));
               $m_products->is_tax_exempt =$this->get_numeric_value($this->input->post('is_tax_exempt',TRUE));

                $m_products->equivalent_points = $this->get_numeric_value($this->input->post('equivalent_points', TRUE));
                $m_products->product_warn =$this->get_numeric_value( $this->input->post('product_warn', TRUE));
                $m_products->product_ideal =$this->get_numeric_value( $this->input->post('product_ideal', TRUE));
                //$m_products->markup_percent = $this->input->post('markup_percent', TRUE);
                $m_products->sale_price =$this->get_numeric_value($this->input->post('sale_price', TRUE));
                $m_products->purchase_cost =$this->get_numeric_value($this->input->post('purchase_cost', TRUE));
                $m_products->purchase_cost_2 =$this->get_numeric_value($this->input->post('purchase_cost_2', TRUE));
                $m_products->discounted_price =$this->get_numeric_value($this->input->post('discounted_price', TRUE));
                $m_products->dealer_price =$this->get_numeric_value($this->input->post('dealer_price', TRUE));
                $m_products->distributor_price =$this->get_numeric_value($this->input->post('distributor_price', TRUE));
                $m_products->public_price =$this->get_numeric_value($this->input->post('public_price', TRUE));

                $m_products->save();

                $product_id = $m_products->last_insert_id();

                $response['title'] = 'Success!';
                $response['stat'] = 'success';
                $response['msg'] = 'Product Information successfully created.';
                $response['row_added'] = $this->response_rows($product_id);

                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=1; //CRUD
                $m_trans->trans_type_id=50; // TRANS TYPE
                $m_trans->trans_log='Created a new Product: '.$this->input->post('product_desc', TRUE);
                $m_trans->save();

                echo json_encode($response);

                break;

            case 'update':
                $account_integration =$this->Account_integration_model;
                $a_i=$account_integration->get_list();
                $account =$a_i[0]->sales_invoice_inventory;
                $ci_account =$a_i[0]->cash_invoice_inventory;


                $m_products=$this->Products_model;


                $product_id=$this->input->post('product_id',TRUE);

                $m_products->set('date_modified','NOW()');
                $m_products->modified_by_user = $this->session->user_id;

                $m_products->brand_id = $this->input->post('brand_id', TRUE);
                $m_products->product_code = $this->input->post('product_code', TRUE);
                $m_products->product_desc = $this->input->post('product_desc', TRUE);
                $m_products->product_desc1 = $this->input->post('product_desc1', TRUE);
                $m_products->size = $this->input->post('size', TRUE);
                $m_products->supplier_id = $this->input->post('supplier_id', TRUE);
                $m_products->category_id = $this->input->post('category_id', TRUE);
                $m_products->refproduct_id = $this->input->post('refproduct_id', TRUE);
                $m_products->item_type_id = $this->input->post('item_type_id', TRUE);
                $m_products->income_account_id = $this->input->post('income_account_id', TRUE);
                $m_products->expense_account_id = $this->input->post('expense_account_id', TRUE);
                $m_products->parent_unit_id = $this->input->post('parent_unit_id', TRUE);
                $m_products->child_unit_desc = $this->get_numeric_value($this->input->post('child_unit_desc', TRUE));
                $m_products->child_unit_id = $this->input->post('child_unit_id', TRUE);  

                $m_products->is_bulk =$this->get_numeric_value($this->input->post('is_bulk',TRUE));
                $m_products->tax_type_id = $this->input->post('tax_type_id', TRUE);
                //$m_products->is_inventory = $this->input->post('inventory',TRUE);

                 //im not sure, why posted checkbox post value of 0 when checked
               $m_products->is_tax_exempt =$this->get_numeric_value($this->input->post('is_tax_exempt',TRUE));
               $m_products->primary_unit =$this->get_numeric_value($this->input->post('primary_unit',TRUE));


                $m_products->equivalent_points = $this->get_numeric_value($this->input->post('equivalent_points', TRUE));
                $m_products->product_warn =$this->get_numeric_value( $this->input->post('product_warn', TRUE));
                $m_products->product_ideal =$this->get_numeric_value( $this->input->post('product_ideal', TRUE));
                //$m_products->markup_percent = $this->input->post('markup_percent', TRUE);
                $m_products->sale_price =$this->get_numeric_value($this->input->post('sale_price', TRUE));
                $m_products->purchase_cost =$this->get_numeric_value($this->input->post('purchase_cost', TRUE));
                $m_products->purchase_cost_2 =$this->get_numeric_value($this->input->post('purchase_cost_2', TRUE));
                $m_products->discounted_price =$this->get_numeric_value($this->input->post('discounted_price', TRUE));
                $m_products->dealer_price =$this->get_numeric_value($this->input->post('dealer_price', TRUE));
                $m_products->distributor_price =$this->get_numeric_value($this->input->post('distributor_price', TRUE));
                $m_products->public_price =$this->get_numeric_value($this->input->post('public_price', TRUE));


                $m_products->modify($product_id);

                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Product information successfully updated.';
                $response['row_updated']=$m_products->product_list(1,null,$product_id,null,null,null,null,null,1);

                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=2; //CRUD
                $m_trans->trans_type_id=50; // TRANS TYPE
                $m_trans->trans_log='Updated Product : '.$this->input->post('product_desc', TRUE).' ID('.$product_id.')';
                $m_trans->save();

                echo json_encode($response);

                break;


            case 'delete':
                $m_products=$this->Products_model;

                $m_purchases=$this->Purchases_model;
                $m_purchase_items=$this->Purchase_items_model;
                $m_sales_order=$this->Sales_order_model;
                $m_order_items=$this->Sales_order_item_model;
                $m_invoice=$this->Sales_invoice_model;
                $m_invoice_items=$this->Sales_invoice_item_model;
                $m_issuance=$this->Issuance_model;
                $m_issuance_items=$this->Issuance_item_model;
                $m_delivery_invoice=$this->Delivery_invoice_model;
                $m_deliver_items=$this->Delivery_invoice_item_model;

                $product_id=$this->input->post('product_id',TRUE);

                if(count($m_purchase_items->get_list(

                    'purchase_order.is_deleted=0 AND product_id='.$product_id,

                    'purchase_order_items.product_id',

                    array(
                        array('purchase_order','purchase_order.purchase_order_id=purchase_order_items.purchase_order_id','left')
                    )

                ))>0){

                    $response['title'] = 'Cannot delete!';
                    $response['stat'] = 'error';
                    $response['msg'] = 'This product still has an active transaction in Purchase Order.';

                    echo json_encode($response);
                    exit;
                }

                else if(count($m_order_items->get_list(
                    'sales_order.is_deleted=0 AND product_id='.$product_id,
                    'sales_order_items.product_id',
                    array(
                        array('sales_order','sales_order.sales_order_id=sales_order_items.sales_order_id','left')
                    )

                ))>0){

                    $response['title'] = 'Cannot delete!';
                    $response['stat'] = 'error';
                    $response['msg'] = 'This product still has an active transaction in Sales Order.';

                    echo json_encode($response);
                    exit;
                }

                else if(count($m_invoice_items->get_list(

                    'sales_invoice.is_deleted=0 AND product_id='.$product_id,

                    'sales_invoice_items.product_id',

                    array(
                        array('sales_invoice','sales_invoice.sales_invoice_id=sales_invoice_items.sales_invoice_id','left')
                    )

                ))>0){

                    $response['title'] = 'Cannot delete!';
                    $response['stat'] = 'error';
                    $response['msg'] = 'This product still has an active transaction in Sales Invoice.';

                    echo json_encode($response);
                    exit;
                }

                else if(count($m_issuance_items->get_list(

                    'issuance_info.is_deleted=0 AND product_id='.$product_id,

                    'issuance_items.product_id',

                    array(
                        array('issuance_info','issuance_info.issuance_id=issuance_items.issuance_id','left')
                    )

                ))>0){

                    $response['title'] = 'Cannot delete!';
                    $response['stat'] = 'error';
                    $response['msg'] = 'This product still has an active transaction in Item Issuance';

                    echo json_encode($response);
                    exit;
                }

                else if(count($m_deliver_items->get_list(

                    'delivery_invoice.is_deleted=0 AND product_id='.$product_id,

                    'delivery_invoice_items.product_id',

                    array(
                        array('delivery_invoice','delivery_invoice.dr_invoice_id=delivery_invoice_items.dr_invoice_id','left')
                    )

                ))>0){

                    $response['title'] = 'Cannot delete!';
                    $response['stat'] = 'error';
                    $response['msg'] = 'This product still has an active transaction in Purchase Invoice.';

                    echo json_encode($response);
                    exit;
                }

                else {
                    $m_products->set('date_deleted','NOW()');
                    $m_products->deleted_by_user = $this->session->user_id;
                    $m_products->is_deleted=1;
                    if($m_products->modify($product_id)){
                        $response['title']='Success!';
                        $response['stat']='success';
                        $response['msg']='Product information successfully deleted.';


                    $product_desc= $m_products->get_list($product_id,'product_desc');
                    $m_trans=$this->Trans_model;
                    $m_trans->user_id=$this->session->user_id;
                    $m_trans->set('trans_date','NOW()');
                    $m_trans->trans_key_id=3; //CRUD
                    $m_trans->trans_type_id=50; // TRANS TYPE
                    $m_trans->trans_log='Deleted Product: '.$product_desc[0]->product_desc;
                    $m_trans->save();

                        echo json_encode($response);
                    }
                }

                break;

            case 'product-history':
                $account_integration =$this->Account_integration_model;
                $a_i=$account_integration->get_list();

                $account =$a_i[0]->sales_invoice_inventory;
                $ci_account =$a_i[0]->cash_invoice_inventory;
                $disaccount =$a_i[0]->dispatching_invoice_inventory;


                $product_id=$this->input->get('id');
                $department_id=($this->input->get('depid')==null||$this->input->get('depid')==0?0:$this->input->get('depid'));
                $as_of_date=$this->input->get('date');

                if($as_of_date==null){$date = null; }else{$date = date('Y-m-d',strtotime($as_of_date));}

                $m_products=$this->Products_model;
                $data['products']=$m_products->get_product_history($product_id,$department_id,$date,$account);
                $data['products_parent']=$m_products->get_product_history_with_child($product_id,$department_id,$date,$account,1,$ci_account,$disaccount);
                $data['product_id']=$product_id;
                //$this->load->view('Template/product_history_menus',$data);

                $this->load->view('template/product_history_inventory',$data);
                break;

            case 'history-product': // USED IN PRODUCTS MANAGEMENT
                $m_company=$this->Company_model;
                $company_info = $m_company->get_list();
                $data['company_info']=$company_info[0];

                $account_integration =$this->Account_integration_model;
                $a_i=$account_integration->get_list();

                $account =$a_i[0]->sales_invoice_inventory;


                $product_id=$this->input->get('id');
                $department_id=($this->input->get('depid')==null||$this->input->get('depid')==0?0:$this->input->get('depid'));
                $as_of_date=$this->input->get('date');

                if($as_of_date==null){
                    $date = null;
                }else{
                    $date = date('Y-m-d',strtotime($as_of_date));
                }

                $data['product_id'] = $product_id;
                $m_products=$this->Products_model;
                //$product_id,$depid=0,$as_of_date=null,$account,$is_parent=null,$ciaccount // OREDR OF PARAMETER
                $data['products_parent']=$m_products->get_product_history_with_child($product_id,$department_id,$date,1,1,1);
                $data['products_child']=$m_products->get_product_history_with_child($product_id,$department_id,$date,1,0,1);
                $data['product_id']=$product_id;
                //$this->load->view('Template/product_history_menus',$data);


                $product_info = $m_products->product_list(1,null,$product_id,null,null,null,null,null,null,1);

                $data['product_info'] = $product_info[0];
                $type=$this->input->get('type');
                $cat=$this->input->get('cat');
                $inv=$this->input->get('inv');
                $data['type'] = $type;

                $data['info']=$m_products->get_list(
                    array('product_id'=>$product_id),
                    array(
                        'products.*',
                            '(SELECT units.unit_name  FROM units WHERE  units.unit_id = products.parent_unit_id) as parent_unit_name',
                            '(SELECT units.unit_name  FROM units WHERE  units.unit_id = products.child_unit_id) as child_unit_name'
                            )
                );

                if($type == NULL){
                    $this->load->view('template/product_history',$data);
                }else if($type == 'print'){
                    if($inv=='parent'){
                        $this->load->view('template/product_history_content',$data);
                    }else if($inv=='child'){
                        $this->load->view('template/product_history_content_child',$data);
                    }
                }else if($type == 'stockcard'){
                        echo json_encode($data);
                }else if($type == 'stockcard_print'){
                    if($cat == 'bulk'){
                        $this->load->view('template/Stock_card_parent_content',$data);
                    }else if ($cat == 'retail'){
                        $this->load->view('template/Stock_card_child_content',$data);

                    }
                }
                break;
                
        }
    }





    function response_rows($filter){
        return $this->Products_model->get_list(
            $filter,

            'products.*,categories.category_name,suppliers.supplier_name,refproduct.product_type,item_types.item_type,account_titles.account_title',

            array(
                array('suppliers','suppliers.supplier_id=products.supplier_id','left'),
                array('refproduct','refproduct.refproduct_id=products.refproduct_id','left'),
                array('categories','categories.category_id=products.category_id','left'),
                array('item_types','item_types.item_type_id=products.item_type_id','left'),
                array('account_titles','account_titles.account_id=products.income_account_id','left')
            )
        );
    }




function Export(){

            $m_company_info = $this->Company_model;
            $company_info=$m_company_info->get_list();
            $inv = $this->input->get('inv');
                $product_id=$this->input->get('product_id');
                $department_id=($this->input->get('depid')==null||$this->input->get('depid')==0?0:$this->input->get('depid'));
                $as_of_date=$this->input->get('date');

                if($as_of_date==null){
                    $date = null;
                }else{
                    $date = date('Y-m-d',strtotime($as_of_date));
                }

                $data['product_id'] = $product_id;
                $m_products=$this->Products_model;
                // $products=$m_products->get_product_history($product_id,$department_id,$date,1);

                $products=$m_products->get_product_history_with_child($product_id,$department_id,$date,1,1,1);
                $products_child=$m_products->get_product_history_with_child($product_id,$department_id,$date,1,0,1);
                $data['product_id']=$product_id;
                //$this->load->view('Template/product_history_menus',$data);


                $product_info = $m_products->product_list(1,null,$product_id,null,null,null,null,null,1);
                $data['product_info'] = $product_info[0];

            $excel=$this->excel;

            $excel->setActiveSheetIndex(0);
            ob_start();
          
            $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
                                    ->setCellValue('A2',$company_info[0]->company_address)
                                    ->setCellValue('A3',$company_info[0]->email_address)
                                    ->setCellValue('A4',$company_info[0]->mobile_no)
                                    ->setCellValue('A6','Product History')
                                    ->setCellValue('A7','As of '.date("F j, Y, g:i a"));
if($inv == 'parent'){
          $excel->getActiveSheet()->setCellValue('A9','Product Description')->getStyle('A9')->getFont()->setBold(TRUE)
          ->getActiveSheet()->setCellValue('B9',$product_info[0]->product_desc)

          ->setCellValue('A10','Other Description')->getStyle('A10')->getFont()->setBold(TRUE)
          ->getActiveSheet()->setCellValue('B10',$product_info[0]->product_desc1)

          ->setCellValue('A11','Category')->getStyle('A11')->getFont()->setBold(TRUE)
          ->getActiveSheet()->setCellValue('B11',$product_info[0]->category_name)

          ->setCellValue('A12','Supplier')->getStyle('A12')->getFont()->setBold(TRUE)
          ->getActiveSheet()->setCellValue('B12',$product_info[0]->supplier_name)

          ->setCellValue('A13','Unit')->getStyle('A13')->getFont()->setBold(TRUE)
          ->getActiveSheet()->setCellValue('B13',$product_info[0]->parent_unit_name.' (Bulk Unit)')

          ->setCellValue('A14','Tax')->getStyle('A14')->getFont()->setBold(TRUE)
          ->getActiveSheet()->setCellValue('B14',$product_info[0]->tax_type.'('.$product_info[0]->tax_rate.' %)')

          ->setCellValue('C9','Purchase Cost')->getStyle('C9')->getFont()->setBold(TRUE)
          ->getActiveSheet()->setCellValue('D9',number_format($product_info[0]->purchase_cost,2))->getStyle('D9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)

          ->getActiveSheet()->setCellValue('C10','Sale Price')->getStyle('C10')->getFont()->setBold(TRUE)
          ->getActiveSheet()->setCellValue('D10',number_format($product_info[0]->sale_price,2))->getStyle('D10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)

          ->getActiveSheet()->setCellValue('C11','Discounted Price')->getStyle('C11')->getFont()->setBold(TRUE)
          ->getActiveSheet()->setCellValue('D11',number_format($product_info[0]->discounted_price,2))->getStyle('D11')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)

          ->getActiveSheet()->setCellValue('C12','Dealer Price')->getStyle('C12')->getFont()->setBold(TRUE)
          ->getActiveSheet()->setCellValue('D12',number_format($product_info[0]->dealer_price,2))->getStyle('D12')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)

          ->getActiveSheet()->setCellValue('C13','Distributor Price')->getStyle('C13')->getFont()->setBold(TRUE)
          ->getActiveSheet()->setCellValue('D13',number_format($product_info[0]->distributor_price,2))->getStyle('D13')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)

          ->getActiveSheet()->setCellValue('C14','Public Price')->getStyle('C14')->getFont()->setBold(TRUE)
          ->getActiveSheet()->setCellValue('D14',number_format($product_info[0]->public_price,2))->getStyle('D14')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)

          ->getActiveSheet()->setCellValue('A15','Warning QTY')->getStyle('A15')->getFont()->setBold(TRUE)
          ->getActiveSheet()->setCellValue('B15',$product_info[0]->product_warn)->getStyle('B15')

          ->getActiveSheet()->setCellValue('C15','Ideal Qty')->getStyle('C15')->getFont()->setBold(TRUE)
          ->getActiveSheet()->setCellValue('D15',$product_info[0]->product_ideal)->getStyle('D15')
          
        ->getActiveSheet()->setCellValue('A18','Transaction Date')->getStyle('A18')->getFont()->setBold(TRUE)
        ->getActiveSheet()->setCellValue('B18','Reference')->getStyle('B18')->getFont()->setBold(TRUE)
        ->getActiveSheet()->setCellValue('C18','Transaction Type')->getStyle('C18')->getFont()->setBold(TRUE)
        ->getActiveSheet()->setCellValue('D18','Description')->getStyle('D18')->getFont()->setBold(TRUE)
        ->getActiveSheet()->setCellValue('E18','Remarks')->getStyle('E18')->getFont()->setBold(TRUE)
        ->getActiveSheet()->setCellValue('F18','In')->getStyle('F18')->getFont()->setBold(TRUE)
        ->getActiveSheet()->setCellValue('G18','Out')->getStyle('G18')->getFont()->setBold(TRUE)
        ->getActiveSheet()->setCellValue('H18','Balance')->getStyle('H18')->getFont()->setBold(TRUE);
        }else if ($inv=='child'){
          $excel->getActiveSheet()->setCellValue('A9','Product Description')->getStyle('A9')->getFont()->setBold(TRUE)
          ->getActiveSheet()->setCellValue('B9',$product_info[0]->product_desc)

          ->setCellValue('A10','Other Description')->getStyle('A10')->getFont()->setBold(TRUE)
          ->getActiveSheet()->setCellValue('B10',$product_info[0]->product_desc1)

          ->setCellValue('A11','Category')->getStyle('A11')->getFont()->setBold(TRUE)
          ->getActiveSheet()->setCellValue('B11',$product_info[0]->category_name)

          ->setCellValue('A12','Supplier')->getStyle('A12')->getFont()->setBold(TRUE)
          ->getActiveSheet()->setCellValue('B12',$product_info[0]->supplier_name)

          ->setCellValue('A13','Unit')->getStyle('A13')->getFont()->setBold(TRUE)
          ->getActiveSheet()->setCellValue('B13',$product_info[0]->child_unit_name.' (Retail Unit)')

          ->setCellValue('A14','Tax')->getStyle('A14')->getFont()->setBold(TRUE)
          ->getActiveSheet()->setCellValue('B14',$product_info[0]->tax_type.'('.$product_info[0]->tax_rate.' %)')

          ->setCellValue('C9','Purchase Cost')->getStyle('C9')->getFont()->setBold(TRUE)
          ->getActiveSheet()->setCellValue('D9',number_format(($product_info[0]->purchase_cost/$product_info[0]->child_unit_desc),2))->getStyle('D9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)

          ->getActiveSheet()->setCellValue('C10','Sale Price')->getStyle('C10')->getFont()->setBold(TRUE)
          ->getActiveSheet()->setCellValue('D10',number_format(($product_info[0]->sale_price/$product_info[0]->child_unit_desc),2))->getStyle('D10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)

          ->getActiveSheet()->setCellValue('C11','Discounted Price')->getStyle('C11')->getFont()->setBold(TRUE)
          ->getActiveSheet()->setCellValue('D11',number_format(($product_info[0]->discounted_price/$product_info[0]->child_unit_desc),2))->getStyle('D11')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)

          ->getActiveSheet()->setCellValue('C12','Dealer Price')->getStyle('C12')->getFont()->setBold(TRUE)
          ->getActiveSheet()->setCellValue('D12',number_format(($product_info[0]->dealer_price/$product_info[0]->child_unit_desc),2))->getStyle('D12')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)

          ->getActiveSheet()->setCellValue('C13','Distributor Price')->getStyle('C13')->getFont()->setBold(TRUE)
          ->getActiveSheet()->setCellValue('D13',number_format(($product_info[0]->distributor_price/$product_info[0]->child_unit_desc),2))->getStyle('D13')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)

          ->getActiveSheet()->setCellValue('C14','Public Price')->getStyle('C14')->getFont()->setBold(TRUE)
          ->getActiveSheet()->setCellValue('D14',number_format(($product_info[0]->public_price/$product_info[0]->child_unit_desc),2))->getStyle('D14')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)

          ->getActiveSheet()->setCellValue('A15','Warning QTY')->getStyle('A15')->getFont()->setBold(TRUE)
          ->getActiveSheet()->setCellValue('B15',$product_info[0]->product_warn.' '.$product_info[0]->parent_unit_name.'(Bulk Unit)')->getStyle('B15')
          ->getActiveSheet()->setCellValue('C15','Ideal Qty')->getStyle('C15')->getFont()->setBold(TRUE)
          ->getActiveSheet()->setCellValue('D15',$product_info[0]->product_ideal.' '.$product_info[0]->parent_unit_name.'(Bulk Unit)')->getStyle('D15')

        ->getActiveSheet()->setCellValue('A18','Transaction Date')->getStyle('A18')->getFont()->setBold(TRUE)
        ->getActiveSheet()->setCellValue('B18','Reference')->getStyle('B18')->getFont()->setBold(TRUE)
        ->getActiveSheet()->setCellValue('C18','Transaction Type')->getStyle('C18')->getFont()->setBold(TRUE)
        ->getActiveSheet()->setCellValue('D18','Description')->getStyle('D18')->getFont()->setBold(TRUE)
        ->getActiveSheet()->setCellValue('E18','Remarks')->getStyle('E18')->getFont()->setBold(TRUE)
        ->getActiveSheet()->setCellValue('F18','In')->getStyle('F18')->getFont()->setBold(TRUE)
        ->getActiveSheet()->setCellValue('G18','Out')->getStyle('G18')->getFont()->setBold(TRUE)
        ->getActiveSheet()->setCellValue('H18','Balance')->getStyle('H18')->getFont()->setBold(TRUE);



        }else{

        }






$i=18;

        if($inv == 'parent'){
                        foreach ($products as $product) {
                                $i++;


                                $excel->getActiveSheet()->setCellValue('A'.$i,$product->txn_date);
                                $excel->getActiveSheet()->setCellValue('B'.$i,$product->ref_no);
                                $excel->getActiveSheet()->setCellValue('C'.$i,$product->type);
                                $excel->getActiveSheet()->setCellValue('D'.$i,$product->Description);
                                $excel->getActiveSheet()->setCellValue('E'.$i,$product->remarks);
                                $excel->getActiveSheet()->setCellValue('F'.$i,number_format($product->parent_in_qty,2));
                                $excel->getActiveSheet()->setCellValue('G'.$i,number_format($product->parent_out_qty,2));
                                $excel->getActiveSheet()->setCellValue('H'.$i,number_format($product->parent_balance,2));

                            }

        }else if ($inv=='child'){

                        foreach ($products_child as $product) {
                                $i++;


                                $excel->getActiveSheet()->setCellValue('A'.$i,$product->txn_date);
                                $excel->getActiveSheet()->setCellValue('B'.$i,$product->ref_no);
                                $excel->getActiveSheet()->setCellValue('C'.$i,$product->type);
                                $excel->getActiveSheet()->setCellValue('D'.$i,$product->Description);
                                $excel->getActiveSheet()->setCellValue('E'.$i,$product->remarks);
                                $excel->getActiveSheet()->setCellValue('F'.$i,number_format($product->child_in_qty,2));
                                $excel->getActiveSheet()->setCellValue('G'.$i,number_format($product->child_out_qty,2));
                                $excel->getActiveSheet()->setCellValue('H'.$i,number_format($product->child_balance,2));

                            }

        }else{

        }

                        

foreach(range('A','H') as $columnID) {
    $excel->getActiveSheet()->getColumnDimension($columnID)
        ->setAutoSize(true);
}
            // Redirect output to a client’s web browser (Excel2007)
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Product History of '.$product_info[0]->product_desc.' '.date("F j, Y g.i a").'.xlsx"');
            header('Cache-Control: max-age=0');
            // If you're serving to IE 9, then the following may be needed
            header('Cache-Control: max-age=1');

            // If you're serving to IE over SSL, then the following may be needed
            header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
            header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
            header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header ('Pragma: public'); // HTTP/1.0

            $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
            $objWriter->save('php://output');



}


function Export_Stock(){
      
                $m_company_info = $this->Company_model;
                $company_info=$m_company_info->get_list();



                $account_integration =$this->Account_integration_model;
                $a_i=$account_integration->get_list();
                $account =$a_i[0]->sales_invoice_inventory;

                $product_id=$this->input->get('id');
                $cat=$this->input->get('cat');

                $department_id=($this->input->get('depid')==null||$this->input->get('depid')==0?0:$this->input->get('depid'));
                $as_of_date=$this->input->get('date');
                if($as_of_date==null){ $date = null; }else{$date = date('Y-m-d',strtotime($as_of_date));}
                $m_products=$this->Products_model;
                $products_parent=$m_products->get_product_history_with_child($product_id,$department_id,$date,1,1,1);
                $products_child=$m_products->get_product_history_with_child($product_id,$department_id,$date,1,0,1);
                $info=$m_products->get_list(
                    array('product_id'=>$product_id),
                    array(
                        'products.*',
                            '(SELECT units.unit_name  FROM units WHERE  units.unit_id = products.parent_unit_id) as parent_unit_name',
                            '(SELECT units.unit_name  FROM units WHERE  units.unit_id = products.child_unit_id) as child_unit_name'
                            )
                );
                $product_info= $info[0];
                if($cat == 'bulk'){$cat_name = 'Bulk'; }else if ($cat == 'retail'){$cat_name = 'Retail';}

                $excel=$this->excel;
                $excel->setActiveSheetIndex(0);
                ob_start();
                $excel->getActiveSheet()->mergeCells('A1:D1');
                $excel->getActiveSheet()->mergeCells('A2:D2');
                $excel->getActiveSheet()->mergeCells('A3:D3');
                $excel->getActiveSheet()->mergeCells('A4:D4');

                $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
                                        ->setCellValue('A2',$company_info[0]->company_address)
                                        ->setCellValue('A3',$company_info[0]->email_address)
                                        ->setCellValue('A4',$company_info[0]->mobile_no)
                                        ->setCellValue('A6','Stock Card / Bin Card ('.$cat_name.')')
                                        ->setCellValue('A7','As of '.date("F j, Y, g:i a"));


          $excel->getActiveSheet()->setCellValue('A9','Product Description')->getStyle('A9')->getFont()->setBold(TRUE)
          ->getActiveSheet()->setCellValue('B9',$product_info->product_desc)
          ->setCellValue('A10','Other Description')->getStyle('A10')->getFont()->setBold(TRUE)
          ->getActiveSheet()->setCellValue('B10',$product_info->product_desc1);


          $excel->getActiveSheet()->getStyle('A6')->getFont()->setBold(TRUE);
          if($cat == 'bulk'){          
                $purchase_cost = $product_info->purchase_cost;
                $sale_price =$product_info->sale_price;
                $excel->getActiveSheet()->setCellValue('E9','Unit of Measurement')->getStyle('E9')->getFont()->setBold(TRUE)
                        ->getActiveSheet()->setCellValue('F9',$product_info->parent_unit_name);
            }else if($cat == 'retail'){
                $purchase_cost = number_format($product_info->purchase_cost,2) / number_format($product_info->child_unit_desc,2);
                $sale_price = number_format($product_info->sale_price,2) / number_format($product_info->child_unit_desc,2);
                $excel->getActiveSheet()->setCellValue('E9','Unit of Measurement')->getStyle('E9')->getFont()->setBold(TRUE)
                        ->getActiveSheet()->setCellValue('F9',$product_info->child_unit_name);
            }

            $excel->getActiveSheet()->setCellValue('C9','Purchase Cost')->getStyle('C9')->getFont()->setBold(TRUE)
                    ->getActiveSheet()->setCellValue('D9',$purchase_cost)->getStyle('D9')->getNumberFormat()->setFormatCode('#,##0.00');
            $excel->getActiveSheet()->setCellValue('C10','Suggested Retail Price')->getStyle('C10')->getFont()->setBold(TRUE)
                    ->getActiveSheet()->setCellValue('D10',$sale_price)->getStyle('D10')->getNumberFormat()->setFormatCode('#,##0.00');
            $excel->getActiveSheet()->setCellValue('A12','Transaction Date')->getStyle('A12')->getFont()->setBold(TRUE)
                    ->getActiveSheet()->setCellValue('B12','Reference')->getStyle('B12')->getFont()->setBold(TRUE)
                    ->getActiveSheet()->setCellValue('C12','IN')->getStyle('C12')->getFont()->setBold(TRUE)
                    ->getActiveSheet()->setCellValue('D12','OUT')->getStyle('D12')->getFont()->setBold(TRUE)
                    ->getActiveSheet()->setCellValue('E12','Balance')->getStyle('E12')->getFont()->setBold(TRUE)
                    ->getActiveSheet()->setCellValue('F12','Department')->getStyle('F12')->getFont()->setBold(TRUE)
                    ->getActiveSheet()->setCellValue('G12','Remarks')->getStyle('G12')->getFont()->setBold(TRUE);
            $excel->getActiveSheet()->getStyle('C12')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $excel->getActiveSheet()->getStyle('D12')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $excel->getActiveSheet()->getStyle('E12')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
          $i = 12;  foreach ($products_parent as $parent) {
                                $i++;
                                $excel->getActiveSheet()->setCellValue('A'.$i,$parent->txn_date);
                                $excel->getActiveSheet()->setCellValue('B'.$i,$parent->ref_no);

                                if($cat == 'bulk'){
                                    $excel->getActiveSheet()->setCellValue('C'.$i,number_format($parent->parent_in_qty,2))->getStyle('C'.$i)->getNumberFormat()->setFormatCode('#,##0.00');
                                    $excel->getActiveSheet()->setCellValue('D'.$i,number_format($parent->parent_out_qty,2))->getStyle('D'.$i)->getNumberFormat()->setFormatCode('#,##0.00');
                                    $excel->getActiveSheet()->setCellValue('E'.$i,number_format($parent->parent_balance,2))->getStyle('E'.$i)->getNumberFormat()->setFormatCode('#,##0.00');
                                }else if ($cat == 'retail'){
                                    $excel->getActiveSheet()->setCellValue('C'.$i,number_format($parent->child_in_qty,2))->getStyle('C'.$i)->getNumberFormat()->setFormatCode('#,##0.00');
                                    $excel->getActiveSheet()->setCellValue('D'.$i,number_format($parent->child_out_qty,2))->getStyle('D'.$i)->getNumberFormat()->setFormatCode('#,##0.00');
                                    $excel->getActiveSheet()->setCellValue('E'.$i,number_format($parent->child_balance,2))->getStyle('E'.$i)->getNumberFormat()->setFormatCode('#,##0.00');

                                }

                                $excel->getActiveSheet()->setCellValue('F'.$i,$parent->department_name);
                                $excel->getActiveSheet()->setCellValue('G'.$i,$parent->remarks);

                                // STYLE
                                 $excel->getActiveSheet()->getStyle('C'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                                 $excel->getActiveSheet()->getStyle('D'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                                 $excel->getActiveSheet()->getStyle('E'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                                 $excel->getActiveSheet()->getStyle('F'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                                 $excel->getActiveSheet()->getStyle('G'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                            }




            foreach(range('A','G') as $columnID) {
                $excel->getActiveSheet()->getColumnDimension($columnID)
                    ->setAutoSize(true);
            }
            // Redirect output to a client’s web browser (Excel2007)
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Stock Card of '.trim($product_info->product_desc).' '.date("F j, Y g.i a").'.xlsx"');
            header('Cache-Control: max-age=0');
            // If you're serving to IE 9, then the following may be needed
            header('Cache-Control: max-age=1');

            // If you're serving to IE over SSL, then the following may be needed
            header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
            header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
            header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header ('Pragma: public'); // HTTP/1.0

            $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
            $objWriter->save('php://output');



}

}
