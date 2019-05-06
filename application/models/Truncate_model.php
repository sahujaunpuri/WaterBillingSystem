<?php

class Truncate_model extends CORE_Model{

    protected  $table="company_info"; //table name
    protected  $pk_id="company_id"; //primary key id


    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function get_current_counts(){
        $sql="SELECT 
				(SELECT COUNT(*) FROM journal_accounts) as journal_accounts,
				(SELECT COUNT(*) FROM journal_entry_templates) as journal_entry_templates,
				(SELECT COUNT(*) FROM journal_info) as journal_info,
				(SELECT COUNT(*) FROM journal_templates_info) as journal_templates_info,
				(SELECT COUNT(*) FROM batch_info) as batch_info,
				(SELECT COUNT(*) FROM depreciation_expense) as depreciation_expense,
				(SELECT COUNT(*) FROM bank_reconciliation) as bank_reconciliation,
				(SELECT COUNT(*) FROM bank_reconciliation_details) as bank_reconciliation_details,
                (SELECT COUNT(*) FROM cash_invoice) as cash_invoice,
                (SELECT COUNT(*) FROM cash_invoice_items) as cash_invoice_items,
                (SELECT COUNT(*) FROM delivery_invoice) as delivery_invoice,
                (SELECT COUNT(*) FROM delivery_invoice_items) as delivery_invoice_items,
                (SELECT COUNT(*) FROM issuance_department_info) as issuance_department_info,
                (SELECT COUNT(*) FROM issuance_department_items) as issuance_department_items,
                (SELECT COUNT(*) FROM proforma_invoice) as proforma_invoice,
                (SELECT COUNT(*) FROM proforma_invoice_items) as proforma_invoice_items,
                (SELECT COUNT(*) FROM purchase_order) as purchase_order,
                (SELECT COUNT(*) FROM purchase_order_items) as purchase_order_items,
                (SELECT COUNT(*) FROM sales_order) as sales_order,
                (SELECT COUNT(*) FROM sales_order_items) as sales_order_items,
                (SELECT COUNT(*) FROM sales_invoice) as sales_invoice,
                (SELECT COUNT(*) FROM sales_invoice_items) as sales_invoice_items,
                (SELECT COUNT(*) FROM service_invoice) as service_invoice,
                (SELECT COUNT(*) FROM service_invoice_items) as service_invoice_items,
                (SELECT COUNT(*) FROM adjustment_info) as adjustment_info,
                (SELECT COUNT(*) FROM adjustment_items) as adjustment_items,
                (SELECT COUNT(*) FROM po_attachments) as po_attachments,
                (SELECT COUNT(*) FROM po_messages) as po_messages,
                (SELECT COUNT(*) FROM payable_payments) as payable_payments,
                (SELECT COUNT(*) FROM payable_payments_list) as payable_payments_list,
                (SELECT COUNT(*) FROM receivable_payments) as receivable_payments,
                (SELECT COUNT(*) FROM receivable_payments_list) as receivable_payments_list,
                (SELECT COUNT(*) FROM products) as products,
                (SELECT COUNT(*) FROM suppliers) as suppliers,
                (SELECT COUNT(*) FROM supplier_photos) as supplier_photos,
                (SELECT COUNT(*) FROM customers) as customers,
                (SELECT COUNT(*) FROM customer_photos) as customer_photos,
                (SELECT COUNT(*) FROM salesperson) as salesperson,
                (SELECT COUNT(*) FROM fixed_assets) as fixed_assets,
                (SELECT COUNT(*) FROM bank) as bank,
                (SELECT COUNT(*) FROM departments) as departments,
                (SELECT COUNT(*) FROM categories) as categories,
                (SELECT COUNT(*) FROM service_unit) as service_unit,
                (SELECT COUNT(*) FROM services) as services,
                (SELECT COUNT(*) FROM tax_types) as tax_types,
                (SELECT COUNT(*) FROM units) as units,
                (SELECT COUNT(*) FROM locations) as locations,
                (SELECT COUNT(*) FROM account_classes) as account_classes,
                (SELECT COUNT(*) FROM account_integration) as account_integration,
                (SELECT COUNT(*) FROM account_titles) as account_titles,
                (SELECT COUNT(*) FROM account_types) as account_types,
                (SELECT COUNT(*) FROM account_year) as account_year,
                (SELECT COUNT(*) FROM accounting_period) as accounting_period,
                (SELECT COUNT(*) FROM rights_links) as rights_links,
                (SELECT COUNT(*) FROM user_accounts) as user_accounts,
                (SELECT COUNT(*) FROM user_group_rights) as user_group_rights,
                (SELECT COUNT(*) FROM user_groups) as user_groups,
                (SELECT COUNT(*) FROM trans) as trans





                ";
        return $this->db->query($sql)->result();
    }

}
?>