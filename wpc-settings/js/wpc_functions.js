jQuery(document).ready(function(){
	/* Validation for section form*/
	jQuery("#wpc_section_form").validate({
		rules: {
			wpc_Title: "required"
		},
		messages: {
			wpc_Title: "Please enter your Section Name"
		}
	});
	
	/* Validation for add new field */
	jQuery("#wpc_field_form").validate({
		rules: {
			wpc_name: "required",
			wpc_optionKeyshow:"required",
			wpc_type: "required"
		},
		messages: {
			wpc_name: "Please enter your Field Name",
			wpc_optionKeyshow: "Enter Slug",
			wpc_type: "Please select field type"
		}
	});
	
	jQuery("#sectionTable").tablesorter(); 
	jQuery("#fieldTable").tablesorter(); 
	
	
});










 