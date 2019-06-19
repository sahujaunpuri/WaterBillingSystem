	<script>
        // ## Service Connection
        var btn_edit_service_connection='<button class="btn btn-primary btn-sm" name="edit_info"  style="margin-left:-15px;" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil"></i> </button>';
        var btn_trash_service_connection='<button class="btn btn-red btn-sm" name="remove_info" style="margin-right:0px;" data-toggle="tooltip" data-placement="top" title="Move to trash"><i class="fa fa-trash-o"></i> </button>';
        // ## Service Disconnection
        var btn_edit_service_disconnection='<button class="btn btn-primary btn-sm" name="edit_info"  style="margin-left:-15px;" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil"></i> </button>';
        var btn_trash_service_disconnection='<button class="btn btn-red btn-sm" name="remove_info" style="margin-right:0px;" data-toggle="tooltip" data-placement="top" title="Move to trash"><i class="fa fa-trash-o"></i> </button>';    
        // ## Service Reconnection
        var btn_edit_service_reconnection='<button class="btn btn-primary btn-sm" name="edit_info"  style="margin-left:-15px;" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil"></i> </button>';
        var btn_trash_service_reconnection='<button class="btn btn-red btn-sm" name="remove_info" style="margin-right:0px;" data-toggle="tooltip" data-placement="top" title="Move to trash"><i class="fa fa-trash-o"></i> </button>';
        // ## Meter Reading Entry
        var btn_edit_meter_reading_entry='<button class="btn btn-primary btn-sm" name="edit_info"  style="margin-left:-15px;" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil"></i> </button>';
        var btn_trash_meter_reading_entry='<button class="btn btn-danger btn-sm" name="remove_info" style="margin-right:0px;" data-toggle="tooltip" data-placement="top" title="Move to trash"><i class="fa fa-trash-o"></i> </button>';
        // ## Billing Payments 
        var btn_cancel_billing_payment='<center><button type="button" class="btn btn-default btn_cancel_or"><i class="fa fa-times-circle"></i></button></center>';
        var btn_cancel_billing_payment_disabled='<center><button type="button" class="btn btn-default btn_cancel_or" disabled><i class="fa fa-times-circle"></i></button></center>';
        // ## Charges Management
        var btn_edit_charges_management='<button class="btn btn-primary btn-sm" name="edit_info"   data-toggle="tooltip" data-placement="top" title="Edit" style="margin-left:-5px;"><i class="fa fa-pencil"></i> </button>';
        var btn_trash_charges_management='<button class="btn btn-danger btn-sm" name="remove_info"  data-toggle="tooltip" data-placement="top" title="Move to trash" style="margin-right:-5px;"><i class="fa fa-trash-o"></i> </button>';
        // ## Charge Unit Management
        var btn_edit_charge_unit_management='<button class="btn btn-primary btn-sm" name="edit_info"  style="margin-left:-15px;" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil"></i> </button>';
        var btn_trash_charge_unit_management='<button class="btn btn-red btn-sm" name="remove_info" style="margin-right:0px;" data-toggle="tooltip" data-placement="top" title="Move to trash"><i class="fa fa-trash-o"></i> </button>';
        // ## Other Charges
        var btn_edit_other_charges='<button class="btn btn-primary btn-sm" name="edit_info"  style="margin-left:-15px;" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil"></i> </button>';
        var btn_trash_other_charges='<button class="btn btn-danger btn-sm" name="remove_info" style="margin-right:0px;" data-toggle="tooltip" data-placement="top" title="Move to trash"><i class="fa fa-trash-o"></i> </button>';
        // ## Residential Rate Matrix
        var btn_edit_residential_rate='<button class="btn btn-primary btn-sm" name="edit_info"  style="margin-left:-15px;" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil"></i> </button>';
        var btn_trash_residential_rate='<button class="btn btn-red btn-sm" name="remove_info" style="margin-right:0px;" data-toggle="tooltip" data-placement="top" title="Move to trash"><i class="fa fa-trash-o"></i> </button>';
        // ## Commercial Rate Matrix
        var btn_edit_commercial_rate='<button class="btn btn-primary btn-sm" name="edit_info"  style="margin-left:-15px;" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil"></i> </button>';
        var btn_trash_commercial_rate='<button class="btn btn-red btn-sm" name="remove_info" style="margin-right:0px;" data-toggle="tooltip" data-placement="top" title="Move to trash"><i class="fa fa-trash-o"></i> </button>';
        // ## Meter Inventory Buttons
        var btn_edit_meter_inventory='<button class="btn btn-primary btn-sm" name="edit_info"  style="margin-left:-15px;" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil"></i> </button>';
        var btn_trash_meter_inventory='<button class="btn btn-red btn-sm" name="remove_info" style="margin-right:0px;" data-toggle="tooltip" data-placement="top" title="Move to trash"><i class="fa fa-trash-o"></i> </button>';
        // ## Meter Reading Period
        var btn_edit_meter_reading_period='<button class="btn btn-primary btn-sm" name="edit_info"  style="margin-left:-15px;" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil"></i> </button>';
        var btn_trash_meter_reading_period='<button class="btn btn-red btn-sm" name="remove_info" style="margin-right:0px;" data-toggle="tooltip" data-placement="top" title="Move to trash"><i class="fa fa-trash-o"></i> </button>';
        var btn_close_meter_reading_period='<button class="btn btn-orange btn-sm" name="close_info" style="margin-right:0px;" data-toggle="tooltip" data-placement="top" title="Close"><i class="fa fa-close"></i> </button>';
        // ## Attendant Management
        var btn_edit_attendant_management='<button class="btn btn-primary btn-sm" name="edit_info"  style="margin-left:-15px;" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil"></i> </button>';
        var btn_trash_attendant_management='<button class="btn btn-red btn-sm" name="remove_info" style="margin-right:0px;" data-toggle="tooltip" data-placement="top" title="Move to trash"><i class="fa fa-trash-o"></i> </button>';
	</script>

<?php
    // ## Service Connection
    echo (in_array('23-1',$this->session->user_rights)? '' : '<script> $(".create_service_connection").remove(); </script>');
    echo (in_array('23-2',$this->session->user_rights)? '' : '<script> var btn_edit_service_connection=""; </script>');
    echo (in_array('23-3',$this->session->user_rights)? '' : '<script> var btn_trash_service_connection=""; </script>');
    // ## Service Disconnection
    echo (in_array('24-1',$this->session->user_rights)? '' : '<script> $(".create_service_disconnection").remove(); </script>');
    echo (in_array('24-2',$this->session->user_rights)? '' : '<script> var btn_edit_service_disconnection=""; </script>');
    echo (in_array('24-3',$this->session->user_rights)? '' : '<script> var btn_trash_service_disconnection=""; </script>'); 
    // ## Service Reconnection
    echo (in_array('25-1',$this->session->user_rights)? '' : '<script> $(".create_service_reconnection").remove(); </script>');
    echo (in_array('25-2',$this->session->user_rights)? '' : '<script> var btn_edit_service_reconnection=""; </script>');
    echo (in_array('25-3',$this->session->user_rights)? '' : '<script> var btn_trash_service_reconnection=""; </script>');
    // ## Meter Reading Entry
    echo (in_array('26-1',$this->session->user_rights)? '' : '<script> $(".create_meter_reading_entry").remove(); </script>');
    echo (in_array('26-2',$this->session->user_rights)? '' : '<script> var btn_edit_meter_reading_entry=""; </script>');
    echo (in_array('26-3',$this->session->user_rights)? '' : '<script> var btn_trash_meter_reading_entry=""; </script>'); 
    // ## Process Billing
    echo (in_array('27-1',$this->session->user_rights)? '' : '<script> $(".btn_process_billing").remove(); </script>');  
    // ## Billing Payments
    echo (in_array('28-1',$this->session->user_rights)? '' : '<script> $(".create_billing_payment").remove(); </script>');
    echo (in_array('28-2',$this->session->user_rights)? '' : '<script> var btn_cancel_billing_payment=""; </script>');
    echo (in_array('28-2',$this->session->user_rights)? '' : '<script> var btn_cancel_billing_payment_disabled=""; </script>');      
    // ## Charges Management
    echo (in_array('29-1',$this->session->user_rights)? '' : '<script> $(".create_charges_management").remove(); </script>');
    echo (in_array('29-2',$this->session->user_rights)? '' : '<script> var btn_edit_charges_management=""; </script>');
    echo (in_array('29-3',$this->session->user_rights)? '' : '<script> var btn_trash_charges_management=""; </script>');
    // ## Charge Unit Management
    echo (in_array('30-1',$this->session->user_rights)? '' : '<script> $(".create_charge_unit_management").remove(); </script>');
    echo (in_array('30-2',$this->session->user_rights)? '' : '<script> var btn_edit_charge_unit_management=""; </script>');
    echo (in_array('30-3',$this->session->user_rights)? '' : '<script> var btn_trash_charge_unit_management=""; </script>');  
    // ## Other Charges
    echo (in_array('31-1',$this->session->user_rights)? '' : '<script> $(".create_other_charges").remove(); </script>');
    echo (in_array('31-2',$this->session->user_rights)? '' : '<script> var btn_edit_other_charges=""; </script>');
    echo (in_array('31-3',$this->session->user_rights)? '' : '<script> var btn_trash_other_charges=""; </script>');
    // ## Residential Rate Matrix
    echo (in_array('32-1',$this->session->user_rights)? '' : '<script> $(".create_residential_rate").remove(); </script>');
    echo (in_array('32-2',$this->session->user_rights)? '' : '<script> var btn_edit_residential_rate=""; </script>');
    echo (in_array('32-3',$this->session->user_rights)? '' : '<script> var btn_trash_residential_rate=""; </script>');
    // ## Commercial Rate Matrix
    echo (in_array('33-1',$this->session->user_rights)? '' : '<script> $(".create_commercial_rate").remove(); </script>');
    echo (in_array('33-2',$this->session->user_rights)? '' : '<script> var btn_edit_commercial_rate=""; </script>');
    echo (in_array('33-3',$this->session->user_rights)? '' : '<script> var btn_trash_commercial_rate=""; </script>');     
    // ## Meter Inventory
    echo (in_array('34-1',$this->session->user_rights)? '' : '<script> $(".create_meter_inventory").remove(); </script>');
    echo (in_array('34-2',$this->session->user_rights)? '' : '<script> var btn_edit_meter_inventory=""; </script>');
    echo (in_array('34-3',$this->session->user_rights)? '' : '<script> var btn_trash_meter_inventory=""; </script>');
    // ## Meter Reading Period
    echo (in_array('35-1',$this->session->user_rights)? '' : '<script> $(".create_meter_reading_period").remove(); </script>');
    echo (in_array('35-2',$this->session->user_rights)? '' : '<script> var btn_edit_meter_reading_period=""; </script>');
    echo (in_array('35-3',$this->session->user_rights)? '' : '<script> var btn_trash_meter_reading_period=""; </script>');
    echo (in_array('35-4',$this->session->user_rights)? '' : '<script> var btn_close_meter_reading_period=""; </script>');
    // ## Attendant Management
    echo (in_array('36-1',$this->session->user_rights)? '' : '<script> $(".create_attendant_management").remove(); </script>');
    echo (in_array('36-2',$this->session->user_rights)? '' : '<script> var btn_edit_attendant_management=""; </script>');
    echo (in_array('36-3',$this->session->user_rights)? '' : '<script> var btn_trash_attendant_management=""; </script>');
    // ## Connection Deposits Sending
    echo (in_array('37-1',$this->session->user_rights)? '' : '<script> $(".btn_sending_connection_deposits").remove(); </script>');
    // ## Billing Sending
    echo (in_array('38-1',$this->session->user_rights)? '' : '<script> $(".btn_sending_billing").remove(); </script>');
    // ## Payment Sending
    echo (in_array('39-1',$this->session->user_rights)? '' : '<script> $(".btn_sending_payment").remove(); </script>');           
?>