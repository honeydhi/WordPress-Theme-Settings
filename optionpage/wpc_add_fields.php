<?php 
global $wpdb;
?>
<div class="wrap am_wrap">
	<h2>Add New Field</h2>
		<div class="am_opts">
	<p>Please, fill the following fields.</p>			
		<div class="am_section">
			<div class="am_optionss">
				<div class="am_input am_text">
					<label for="wpc_goo">Name : </label>
					<input name="wpc_field_name" id="wpc_field_name" type="text" value="http://google.com" />
					<small>Enter Field name</small>
					<div class="clearfix"></div>
				</div>
				<div class="am_input am_text">
					<label for="wpc_key_value">Key</label>
					<input name="wpc_key_value" id="wpc_tlink" type="text" value="" />
					<small>This will used to get the field value</small>
					<div class="clearfix"></div>
				</div>
				<div class="am_input am_text">
					<label for="wpc_dsc">Add Description</label>
					<input name="wpc_dsc" id="wpc_you" type="text" value="" />
					<small>Enter short Description</small>
					<div class="clearfix"></div>
				</div>
				<div class="am_input am_text">
					<label for="wpc_field_type">Type of Field</label>
					<select name="wpc_field_type">
						<option>Text</option>
						<option>Upload</option>
						<option>Textarea</option>
					</select>
					<small>Please select the field*</small>
				<div class="clearfix"></div>
				</div>
				<div class="am_input am_text">
					<label for="wpc_select_selection">Select Section</label>
					<select name="wpc_select_selection">
						<option>Header Settings</option>
						<option>Social Media Settings</option>
					</select>
					<small>Select section for this field*</small>
				<div class="clearfix"></div>
				</div>
				
			</div>
		</div><br>
		<span class="submit">
					<input name="save2" type="submit" value="Save Changes" />
				</span>
	</div>
</div>