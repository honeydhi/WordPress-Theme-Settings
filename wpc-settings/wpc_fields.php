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
if((!empty($_POST) && $_POST['wpc_save_field']=='Save Changes')){
	$saveField = $wpcInstance->insertField($_POST);
	if($saveField){
		echo '<div id="message" class="updated fade"><p><strong>Settings saved.</strong></p></div>';
	} else {
		echo '<div id="message" class="updated fade"><p><strong>Nothing saved.</strong></p></div>';
	}
	
}
 if (isset($_GET['deleteField']) && wp_verify_nonce($_GET['deleteField'] , 'doing_something' )) { 	
		$deleteField = $wpcInstance->deleteField($_GET['del']);
		if($deleteField){
			echo '<div id="message" class="updated fade"><p><strong>Deleted Successfully.</strong></p></div>';
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
		$addNewLink = '<a href="'. wp_nonce_url(admin_url('admin.php?page=field-management'), 'add_something', 'addnew').'">Add New Field</a>';
		$fromhiddenaction = 'update';
	} else {
      
    }
?>
<div class="wrap am_wrap" style="float:left; width:50%;">
<?php echo $addNewLink; ?>
	<h2><?php echo $title; ?> Field</h2>
		<div class="am_opts">
	<p>Please, fill the following fields.</p>
	<form 	id="wpc_field_form" method="POST" action="<?php echo $_SERVER['REQUEST_URI'] ; ?>" />	
	 <?php wp_nonce_field( 'save_field','save_field' ); ?>	
		<div class="am_section">
			<div class="am_optionss">
				<div class="am_input am_text">
					<label for="wpc_name" style="width:100px;">Name :<span class="mandatory">*</span> </label>
					<input name="wpc_name" id="wpc_name" type="text" value="<?php echo $name; ?>" />
					<small style="width:190px;">Enter Field name</small>
					<div class="clearfix"></div>
				</div> 

				<div class="am_input am_text">
					<label for="wpc_optionKey" style="width:100px;">Slug<span class="mandatory">*</span></label>
					<input name="wpc_optionKeyshow" id="wpc_optionKeyshow" class="wpc_optionKeyshow" type="text" value="<?php echo $slug; ?>" <?php echo $disabled; ?>/>
					<small style="width:190px;">This will used to get the field value</small>
					<div class="clearfix"></div>
				</div>
				<div class="am_input am_text">
					<label for="wpc_description" style="width:100px;">Add Description</label>
					<textarea name="wpc_description" id="wpc_description" class="wpc_description"><?php echo $desc; ?></textarea>
					<small style="width:190px;">Enter short Description of field (Optional)</small>
					<div class="clearfix"></div>
				</div>
				<div class="am_input am_text">
					<label for="wpc_type" style="width:100px;">Type of Field</label>
					<select name="wpc_type" class="wpc_type">
						<option value="">Select Field Type</option>
						<option <?php if($type =='text') : echo 'selected="selected"'; else: echo ''; endif; ?> value="text">Text</option>
						<option <?php if($type =='upload') : echo 'selected="selected"'; else: echo ''; endif; ?> value="upload">Upload</option>
						<option <?php if($type =='textarea2') : echo 'selected="selected"'; else: echo ''; endif; ?> value="textarea2">Textarea</option>
						<option <?php if($type =='textarea') : echo 'selected="selected"'; else: echo ''; endif; ?> value="textarea">Html Textarea</option>
					</select>
					<small style="width:190px;">Please select the field<span class="mandatory">*</span></small>
				<div class="clearfix"></div>
				</div>
				<div class="am_input am_text">
					<label for="wpc_sectionID" style="width:100px;">Select Section</label>
					<select name="wpc_sectionID" class="wpc_sectionID">
					<?php 
						$getSectionArray = $wpcInstance->getSections(); 
						foreach ($getSectionArray as $value){
						if ($section == $value->id):  $sel = 'selected="selected"'; else: $sel = ''; endif; 
						?>
						<option value="<?php echo $value->id; ?>" <?php echo $sel; ?>><?php echo $value->wpc_Title; ?></option>
						<?php  } ?>
					</select>
					<small style="width:190px;">Select section for this field:<span class="mandatory">*</span></small>
				<div class="clearfix"></div>
				</div>
				
			</div>
		</div><br>
		<span class="submit">
		<input type="hidden" name="wpc_optionKey" id ="wpc_optionKey" value="<?php echo $slug; ?>" />
		<input type="hidden" name="action" value="<?php echo $fromhiddenaction; ?>" />
		<input type="hidden" name="id" value="<?php echo $FieldId; ?>" />
		<input name="wpc_save_field" type="submit" value="Save Changes" />
				</span>
				</form>
	</div>
</div>

<div class="wrap am_wrap" style="float:left; width:30%">
<div class="am_section" >
			<table border="1" style="width:100%" id="fieldTable" class="tablesorter">
			<thead>
 <tr>
    <th>Field Name</th>
	<th>Slug</th>
    <th colspan=2 >Action</th>
  </tr>
  </thead>
  <tbody>
  <?php 
	$getSectionArray = $wpcInstance->getAllFields(); 
	if(!empty(	$getSectionArray)) :
	foreach ($getSectionArray as $value){
	?>
	<tr>
		<td><?php echo $value->wpc_name; ?></td>
		<td><?php echo $value->wpc_optionKey; ?></td>
		<td><a href="<?php echo wp_nonce_url(admin_url('admin.php?page=field-management&del='.$value->id.''), 'doing_something', 'deleteField');?>">Delete</a></td>		
		<td><a href="<?php echo wp_nonce_url(admin_url('admin.php?page=field-management&edit='.$value->id.''), 'edit_something', 'editField');?>">Edit</a></td>
	</tr>
	<?php  } else :?>
	
	<tr><td colspan="4">No record found</td></tr>
	<?php endif; ?>
	</tbody>
    </table>
</div>
</div>

<?php 
if (!isset($_GET['editField']) || !wp_verify_nonce($_GET['editField'] , 'edit_something' )) { ?>
<script>
jQuery(document).ready(function() {
	jQuery("#wpc_name").blur(function() {
		var slug = jQuery('#wpc_name').val();
        slug=slug.toLowerCase();
        slug=slug.replace(/(^\s+|[^a-zA-Z0-9 ]+|\s+$)/g,"");
        slug=slug.replace(/\s+/g, "-");
		jQuery('#wpc_optionKeyshow').val(slug);
		jQuery('#wpc_optionKey').val(slug);
	});
	jQuery("#wpc_optionKeyshow ,.wpc_type,.wpc_sectionID").focusout(function() {
		var slug = jQuery('#wpc_optionKeyshow').val();
        slug=slug.toLowerCase();
        slug=slug.replace(/\s+/g, "-");
		jQuery.ajax({
			url : '<?php echo admin_url('admin-ajax.php'); ?>',
			type : 'POST',
			dataType : 'json', 
			data : {'action': 'wpc_check_slug','slug': slug},
			success : function(response){
			if(response == ''){
			alert("slug Invalid/already exist in our records please use another slug");
				jQuery('#wpc_optionKeyshow').val("");
				jQuery('#wpc_optionKey').val("");
			} else {
				jQuery('#wpc_optionKeyshow').val(response);
				jQuery('#wpc_optionKey').val(response);
			}
			}
		});
	});
});
</script>

<?php } ?>