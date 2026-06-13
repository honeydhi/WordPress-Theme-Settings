<?php 
global $wpdb;
global $wpcInstance;
$name = '';
$slug = '';
$desc= '';
$type= '';
$section= '';
$title = 'Add';
$fromhiddenaction = 'add';
$sectionId = '';
$disabled='';
$addNewLink = '';
$FieldId  = '';
if(!empty($_POST) && isset($_POST['wpc_save_field']) && $_POST['wpc_save_field']=='Save Changes'){
	$saveField = $wpcInstance->insertField($_POST);
	if($saveField){
		echo '<div class="notice notice-success is-dismissible"><p><strong>Field saved successfully.</strong></p></div>';
	} else {
		echo '<div class="notice notice-error is-dismissible"><p><strong>Nothing saved.</strong></p></div>';
	}
	
}
 if (isset($_GET['deleteField']) && wp_verify_nonce($_GET['deleteField'] , 'doing_something' )) { 	
		$deleteField = $wpcInstance->deleteField($_GET['del']);
		if($deleteField){
			echo '<div class="notice notice-success is-dismissible"><p><strong>Field deleted successfully.</strong></p></div>';
		}
	} else {
      
    }
	
	if (isset($_GET['editField']) && wp_verify_nonce($_GET['editField'] , 'edit_something' )) { 	
		$getFieldByID = $wpcInstance->getFieldByID($_GET['edit']);
		$name =  $getFieldByID->wpc_name;
	 	$desc= $getFieldByID->wpc_description;
		$slug = $getFieldByID->wpc_optionKey;
		$type= $getFieldByID->wpc_type;
		$section= $getFieldByID->wpc_sectionID;
		$title = 'Edit';
		$FieldId = $getFieldByID->id;
		$disabled='disabled';
		$addNewLink = '<a href="'. wp_nonce_url(admin_url('admin.php?page=field-management'), 'add_something', 'addnew').'" class="page-title-action">Add New Field</a>';
		$fromhiddenaction = 'update';
	} else {
      
    }
?>
<div class="wrap wpc-wrap">
	<h1 class="wp-heading-inline"><?php echo esc_html($title); ?> Field</h1>
	<?php echo $addNewLink; ?>
	<hr class="wp-header-end">

	<div class="wpc-col-container">
		<!-- Left Column: Add/Edit Form -->
		<div class="wpc-col-left">
			<div class="postbox">
				<div class="postbox-header"><h2 class="hndle"><span><?php echo esc_html($title); ?> Field</span></h2></div>
				<div class="inside">
					<form action="admin.php?page=field-management" method="post">
						<?php wp_nonce_field( 'save_field', 'save_field' ); ?>
						<div class="wpc-field-group wpc-field-group-compact">
							<div class="wpc-field-row">
								<div class="wpc-field-label">Name <span class="required">*</span></div>
								<div class="wpc-field-input">
									<input name="wpc_name" id="wpc_name" type="text" value="<?php echo esc_attr($name); ?>" required />
									<p class="description">Enter the field name.</p>
								</div>
							</div>
							<div class="wpc-field-row">
								<div class="wpc-field-label">Slug <span class="required">*</span></div>
								<div class="wpc-field-input">
									<input name="wpc_optionKeyshow" id="wpc_optionKeyshow" type="text" value="<?php echo esc_attr($slug); ?>" <?php echo esc_attr($disabled); ?> />
									<p class="description">Used to retrieve the field value.</p>
								</div>
							</div>
							<div class="wpc-field-row">
								<div class="wpc-field-label">Description</div>
								<div class="wpc-field-input">
									<textarea name="wpc_description" id="wpc_description" rows="3"><?php echo esc_textarea($desc); ?></textarea>
									<p class="description">Short description of the field (optional).</p>
								</div>
							</div>
							<div class="wpc-field-row">
								<div class="wpc-field-label">Field Type <span class="required">*</span></div>
								<div class="wpc-field-input">
									<select name="wpc_type" class="wpc_type" required>
										<option value="">Select Field Type</option>
										<option <?php selected($type, 'text'); ?> value="text">Text Box</option>
										<option <?php selected($type, 'textarea'); ?> value="textarea">HTML Textarea</option>
										<option <?php selected($type, 'textarea2'); ?> value="textarea2">Simple Textarea</option>
										<option <?php selected($type, 'checkbox'); ?> value="checkbox">Checkbox</option>
										<option <?php selected($type, 'upload'); ?> value="upload">Image Upload</option>
									</select>
								</div>
							</div>
							<div class="wpc-field-row">
								<div class="wpc-field-label">Section <span class="required">*</span></div>
								<div class="wpc-field-input">
									<select name="wpc_sectionID" class="wpc_sectionID" required>
										<option value="">Select Section</option>
										<?php
										$getSectionArray = $wpcInstance->getSections();
										foreach($getSectionArray as $val){
										?>
											<option <?php selected($section, $val->id); ?> value="<?php echo esc_attr($val->id); ?>"><?php echo esc_html($val->wpc_Title); ?></option>
										<?php } ?>
									</select>
									<p class="description">Assign this field to a section.</p>
								</div>
							</div>
						</div>
						<p class="submit" style="float:left;"> 
							<input type="submit" name="wpc_save_field" class="button button-primary" value="Save Changes" />
							<input type="hidden" name="action" value="<?php echo esc_attr($fromhiddenaction); ?>" />
							<input type="hidden" name="id" value="<?php echo esc_attr($FieldId); ?>" />
							<input type="hidden" name="wpc_optionKey" id="wpc_optionKey" value="<?php echo esc_attr($slug); ?>" />
						</p>
					</form>
				</div>
			</div>
		</div>

		<div class="wpc-col-right">
			<div class="postbox">
				<div class="postbox-header"><h2 class="hndle"><span>All Fields</span></h2></div>
				<div class="inside">
					<div class="wpc-grid-table">
						<div class="wpc-grid-header">
							<div class="wpc-grid-col" style="flex: 2;">Field Name</div>
							<div class="wpc-grid-col">Slug</div>
							<div class="wpc-grid-col">Type</div>
							<div class="wpc-grid-col-actions">Actions</div>
						</div>
						<?php
						$getFieldsArray = $wpcInstance->getAllFields();
						if($getFieldsArray) :
						foreach($getFieldsArray as $val) :
						?>
							<div class="wpc-grid-row">
								<div class="wpc-grid-col" style="flex: 2;"><strong><?php echo esc_html($val->wpc_name); ?></strong></div>
								<div class="wpc-grid-col"><code><?php echo esc_html($val->wpc_optionKey); ?></code></div>
								<div class="wpc-grid-col">
									<?php
									$field_types = array(
										'text'      => 'Text Box',
										'textarea'  => 'HTML Textarea',
										'textarea2' => 'Simple Textarea',
										'checkbox'  => 'Checkbox',
										'upload'    => 'Image Upload'
									);
									echo esc_html( isset( $field_types[ $val->wpc_type ] ) ? $field_types[ $val->wpc_type ] : $val->wpc_type );
									?>
								</div>
								<div class="wpc-grid-col-actions">
									<span class="row-actions">
										<a href="<?php echo wp_nonce_url(admin_url('admin.php?page=field-management&edit='.$val->id.''), 'edit_something', 'editField');?>">Edit</a>
										 | 
										<a href="<?php echo wp_nonce_url(admin_url('admin.php?page=field-management&del='.$val->id.''), 'doing_something', 'deleteField');?>" class="delete" onclick="return confirm('Are you sure you want to delete this field?');">Delete</a>
									</span>
								</div>
							</div>
						<?php endforeach; else: ?>
							<div class="wpc-grid-row"><div class="wpc-grid-col">No fields found. Create your first field using the form.</div></div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php 
if (!isset($_GET['editField']) || !wp_verify_nonce($_GET['editField'] , 'edit_something' )) { ?>
<script>
jQuery(document).ready(function($) {
    // Generate slug as you type
    $("#wpc_name").on('input', function() {
        var slug = $(this).val()
            .toLowerCase()
            .replace(/[^\w\s-]/g, '') // Remove non-word chars
            .replace(/\s+/g, '-')      // Replace spaces with -
            .replace(/--+/g, '-')     // Replace multiple - with single -
            .trim();
        
        $('#wpc_optionKeyshow, #wpc_optionKey').val(slug);
    });

    // Final check and uniqueness check on blur/change
    $("#wpc_optionKeyshow, .wpc_type, .wpc_sectionID").on('blur change', function() {
        var slug = $('#wpc_optionKeyshow').val().toLowerCase().replace(/\s+/g, "-").trim();
        if (!slug) return;

        $.ajax({
            url: '<?php echo admin_url("admin-ajax.php"); ?>',
            type: 'POST',
            dataType: 'json',
            data: {
                'action': 'wpc_check_slug',
                'slug': slug
            },
            success: function(response) {
                if (response === '' || response === false) {
                    alert("Slug is invalid or already exists. Please choose another.");
                    $('#wpc_optionKeyshow, #wpc_optionKey').val("");
                } else {
                    $('#wpc_optionKeyshow, #wpc_optionKey').val(response);
                }
            },
            error: function() {
                console.error("Slug check failed.");
            }
        });
    });
});
</script>

<?php } ?>