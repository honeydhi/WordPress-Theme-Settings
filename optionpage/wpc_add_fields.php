<?php 
global $wpdb;
global $wpcInstance;

if((!empty($_POST) && $_POST['wpc_save_field']=='Save Changes')){
	$saveField = $wpcInstance->insertField($_POST);
	/*if($saveSection){
		echo '<div id="message" class="updated fade"><p><strong>Settings saved.</strong></p></div>';
	} else {
	
	}*/
	
}
?>
<div class="wrap am_wrap">
	<h2>Add New Field</h2>
		<div class="am_opts">
	<p>Please, fill the following fields.</p>
	<form 	id="wpc_field_form" method="POST" action="<?php echo $_SERVER['REQUEST_URI'] ; ?>" />	
	 <?php wp_nonce_field( 'save_field','save_field' ); ?>	
		<div class="am_section">
			<div class="am_optionss">
				<div class="am_input am_text">
					<label for="wpc_name">Name :<span class="mandatory">*</span> </label>
					<input name="wpc_name" id="wpc_name" type="text" value="" />
					<small>Enter Field name</small>
					<div class="clearfix"></div>
				</div>
				<div class="am_input am_text">
					<label for="wpc_optionKey">Key</label>
					<input name="wpc_optionKeyshow" id="wpc_optionKeyshow" type="text" value="" disabled="disabled"/>
					<small>This will used to get the field value</small>
					<div class="clearfix"></div>
				</div>
				<div class="am_input am_text">
					<label for="wpc_description">Add Description</label>
					<textarea name="wpc_description" id="wpc_description"></textarea>
					<small>Enter short Description of field (Optional)</small>
					<div class="clearfix"></div>
				</div>
				<div class="am_input am_text">
					<label for="wpc_type">Type of Field</label>
					<select name="wpc_type">
						<option value="">Select Field Type</option>
						<option value="text">Text</option>
						<option value="upload">Upload</option>
						<option value="textarea2">Textarea</option>
						<option value="textarea">Html Textarea</option>
					</select>
					<small>Please select the field*</small>
				<div class="clearfix"></div>
				</div>
				<div class="am_input am_text">
					<label for="wpc_sectionID">Select Section</label>
					<select name="wpc_sectionID">
					<?php 
						$getSectionArray = $wpcInstance->getSections(); 
						foreach ($getSectionArray as $value){
						?>
						<option value="<?php echo $value->id; ?>"><?php echo $value->wpc_Title; ?></option>
						<?php  } ?>
					</select>
					<small>Select section for this field:<span class="mandatory">*</span></small>
				<div class="clearfix"></div>
				</div>
				
			</div>
		</div><br>
		<span class="submit">
		<input type="hidden" name="wpc_optionKey" id ="wpc_optionKey" value="" />
					<input name="wpc_save_field" type="submit" value="Save Changes" />
				</span>
				</form>
	</div>
</div>

<script>
jQuery(document).ready(function() {
	jQuery("#wpc_name").blur(function() {
		var slug = jQuery('#wpc_name').val();
        slug=slug.toLowerCase();
        slug=slug.replace(/(^\s+|[^a-zA-Z0-9 ]+|\s+$)/g,"");
        slug=slug.replace(/\s+/g, "-");
		jQuery.ajax({
			url : '<?php echo admin_url('admin-ajax.php'); ?>',
			type : 'POST',
			dataType : 'json', 
			data : {'action': 'check_slug','slug': slug},
			success : function(response){
				jQuery('#wpc_optionKeyshow').val(response);
				jQuery('#wpc_optionKey').val(response);
			}
		});
	});
});
</script>

