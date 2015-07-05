<?php
/*
    Plugin Name: Basic settings 
    Plugin URI: https://about.me/honeydavinder
    Description: Plugin for setting up the logo and basic information like social media settings and footer content, this pluign helps the developer to add new meta fields and options fields.
    Author: Davinder Singh
    Version: 1.0
    Author URI: https://about.me/honeydavinder
    */

/* Set your theme name & shortname to get options fields*/
$themename = "WordPress Custom Settings";
$shortname = "wpc";
include( plugin_dir_path( __FILE__ ) . 'inc/wpc_class.php');
$wpcInstance = new wpc;
/* Fetch all Categories ,you can use it any where in your theme to get the desire pages or posts.
 * 
 * Author Davinder Singh
 * */
$categories = get_categories('hide_empty=1&orderby=name');
$wp_cats = array();
	foreach ($categories as $category_list ) {
		$wp_cats[$category_list->cat_ID] = $category_list->cat_name;
}


/* Fetch all pages you can use it any where in your theme to get the desire pages
 * 
 * Author Davinder Singh
 * */
	$pages = get_pages('hide_empty=0&orderby=name'); 
	$wp_pag = array();
		foreach ($pages as $pagg) {
			$wp_pag[ $pagg->ID ]= $pagg->post_title;
	}

	/* Description : Update and delete the options fields here
	 * 
	 * Author : Davinder Singh
	 * params : none;
	 * */
	 
	function mytheme_add_admin() {
	global $themename, $shortname ,$wpcInstance;
	if ( $_GET['page'] == basename(__FILE__) ) {
			if ( 'save' == $_REQUEST['action'] ) {
			foreach ($_REQUEST as $key=>$value) {
				if( isset( $_REQUEST[ $key ] ) ) { 
					update_option( $key , $value  ); } 
				else { delete_option( $key ); } 
				}
				header("Location: admin.php?page=admin_menu.php&saved=true");
				die;
		}
		else if( 'reset' == $_REQUEST['action'] ) {
			foreach ($_REQUEST as $key=>$value) {
				delete_option( $key ); }
				header("Location: admin.php?page=admin_menu.php&reset=true");
				die;
			}
	}
		add_menu_page($themename, $themename, 'administrator', basename(__FILE__), 'mytheme_admin');
	}

	function register_my_custom_submenu_page() {
		add_submenu_page(get_admin_page_parent(), 'Section Management', 'Section Management', 'manage_options', 'section-management', 'get_add_section_page_admin' );
		add_submenu_page(get_admin_page_parent(), 'Add New Fields', 'Add New Fields', 'manage_options', 'add-new-field', 'get_add_field_page_admin' );
	}
	
	function get_add_field_page_admin(){
		$Add_fields_file = plugin_dir_path( __FILE__ ) . "wpc_add_fields.php";
		if ( file_exists( $Add_fields_file ) )
			require $Add_fields_file;
	}
	
	function get_add_section_page_admin(){
		$Add_section_file = plugin_dir_path( __FILE__ ) . "wpc_add_sections.php";
		if ( file_exists( $Add_section_file ) )
			require $Add_section_file;
	}

	/* Description : Include all the Jquery and css files here
	 * 
	 * Author : Davinder Singh
	 * params : none;
	 * */
	function mytheme_add_init() {
		$plugin_URL = plugin_dir_url( __FILE__ );
		wp_enqueue_style("functions", $plugin_URL."css/functions.css", false, "1.0", "all");
		wp_enqueue_style("functions-styles", $plugin_URL."css/admin-style.css", false, "1.0", "all");
		wp_enqueue_script("am_script", $plugin_URL."js/am_script.js", false, "1.0");
		wp_enqueue_script("upload_box", $plugin_URL."js/upload_box.js", false, "1.0");
		wp_enqueue_script('jquery-validation', $plugin_URL."js/jquery.validate.min.js", false, "1.0");
		wp_enqueue_script('jquery-wpc-functions', $plugin_URL."js/wpc_functions.js", false, "1.0");
		wp_enqueue_script('media-upload');
		wp_enqueue_script('thickbox');
		wp_enqueue_script('my-upload');
		wp_enqueue_style('thickbox');
	}
	
	/* Description : Display the setting page in admin
		 * 
		 * Author : Davinder Singh
		 * params : none;
		 * */

	function mytheme_admin() {
	global $themename, $shortname ,$wpcInstance;
	$i=0;
	if ( $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings saved.</strong></p></div>';
	if ( $_REQUEST['reset'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings reset.</strong></p></div>';
	?>
	
	
<div class="wrap am_wrap">
	<h2><?php echo $themename; ?> Options Panel</h2>
		<div class="am_opts">
			
<p>Please, use the menu below to setting up your theme.</p>			
<br/>
<form method="post">
<?php
	$GetSectionsArray = $wpcInstance->getSections();
	foreach($GetSectionsArray as $GetSections){ 
	
	?>
	<div class="am_section">
		<div class="am_title">
		<h3><img src="<?php echo  plugin_dir_url( __FILE__ ); ?>/images/trans.png" class="inactive" alt=""><?php  echo $GetSections->wpc_Title; ?></h3>
		<!--span class="submit"><input name="save2" type="submit" value="Save Changes" /></span-->
		<div class="clearfix"></div>
	</div>
	
	<div class="am_options">
	<?php  
	$FieldsArray = $wpcInstance->getFields($GetSections->id);
	foreach ($FieldsArray as $Fields){
		switch ( $Fields->wpc_type ) {
		case "text":
	?>
	<div class="am_input am_text">
		<label for="<?php echo $Fields->wpc_name; ?>"><?php echo $Fields->wpc_name; ?></label>
		<input name="<?php echo $Fields->wpc_optionKey; ?>" id="<?php echo $Fields->wpc_name; ?>" type="<?php echo $Fields->wpc_type; ?>" value="<?php if ( get_option( $Fields->wpc_optionKey ) != "") { echo stripslashes(get_option( $Fields->wpc_optionKey) ); } else { echo $value['std']; } ?>" />
		<small><?php echo $Fields->wpc_description; ?></small>
		<div class="clearfix"></div>
	</div>
	<?php break; case 'textarea':?>
	<div class="am_input am_textarea">
	<label for="<?php echo $Fields->wpc_optionKey; ?>"><?php echo $Fields->wpc_name; ?></label>
	<div class="texted"><textarea id="<?php echo $Fields->wpc_optionKey; ?>" name="<?php echo $Fields->wpc_optionKey; ?>" type="<?php echo $Fields->wpc_type; ?>" cols="" rows=""><?php if ( get_option( $Fields->wpc_optionKey ) != "") { echo stripslashes(get_option( $Fields->wpc_optionKey) ); } else { echo $value['std']; } ?></textarea>
	<div class="clear" style="margin:0;padding:0; clear:both;"></div>
	</div>
	<small><?php echo $Fields->description; ?></small><div class="clearfix"></div>
	<script>
		//<![CDATA[
		bkLib.onDomLoaded(function() { new nicEditor().panelInstance('<?php echo $Fields->wpc_optionKey; ?>'); });
		//]]>
	</script>
	</div>
	<?php break; case 'textarea2': ?>
	<div class="am_input am_textarea">
			<label for="<?php echo $Fields->wpc_optionKey; ?>"><?php echo $Fields->wpc_name; ?></label>
			<div class="texted"><textarea  name="<?php echo $Fields->wpc_optionKey; ?>" type="<?php echo $Fields->wpc_type; ?>" cols="" rows=""><?php if ( get_option( $Fields->wpc_optionKey ) != "") { echo stripslashes(get_option( $Fields->wpc_optionKey) ); } else { echo $value['std']; } ?></textarea>
			<div class="clear" style="margin:0;padding:0; clear:both;"></div>
		</div>
		<small><?php echo $Fields->description; ?></small><div class="clearfix"></div>
	</div> 
	<?php break; case 'select':?>
	<div class="am_input am_select">
		<label for="<?php echo $Fields->wpc_optionKey; ?>"><?php echo $Fields->wpc_name; ?></label>
			<select name="<?php echo $Fields->wpc_optionKey; ?>" id="<?php echo $Fields->wpc_optionKey; ?>">
			<?php foreach ($value['options'] as $key=>$option) { ?>
			<option <?php if (get_option( $Fields->wpc_optionKey ) == $key) { echo 'selected="selected"'; } ?> value="<?php echo $key; ?>"><?php echo $option; ?></option><?php } ?>
			</select>
		<small><?php echo $Fields->description; ?></small><div class="clearfix"></div>
	</div>
	<?php break; case 'upload': ?>
	<div class="rm_input rm_upload">
		<p class="awdMetaImage" style="padding-left:15px; max-width:720px;"><img  src="<?php if ( get_option( $Fields->wpc_optionKey ) != "") { echo stripslashes(get_option( $Fields->wpc_optionKey) ); } else { echo $value['std']; } ?>"  /> <p>
		<label style="padding-left:15px;" for="<?php echo $Fields->wpc_optionKey; ?>"><?php echo $Fields->wpc_name; ?></label>
		<input type="text" class="upload-url <?php echo $field_class; ?>" name="<?php echo $Fields->wpc_optionKey; ?>" id="<?php echo $Fields->wpc_name; ?>" value="<?php if ( get_option( $Fields->wpc_optionKey ) != "") { echo stripslashes(get_option( $Fields->wpc_optionKey ) ); } else { echo $value['std']; } ?>" />
		<input id="st_upload_button" class="st_upload_button" type="button" name="upload_button" value="Upload"  />
	</div>
	<?php break; case "checkbox":?>
	<div class="am_input am_checkbox">
		<label for="<?php echo $Fields->wpc_optionKey; ?>"><?php echo $value['name']; ?></label>
		<?php if(get_option($Fields->wpc_optionKey)){ $checked = "checked=\"checked\""; }else{ $checked = "";} ?>
		<input type="checkbox" name="<?php echo $Fields->wpc_optionKey; ?>" id="<?php echo $Fields->wpc_optionKey; ?>" value="true" <?php echo $checked; ?> />
		<small><?php echo $Fields->description; ?></small><div class="clearfix"></div>
	</div>
	
	<?php break; default: ?>
	<?php }
	} ?></div>
	</div>
<br/>
	<?php }

	?>
	
	<p class="submit save">
			<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
			<input type="hidden" name="action" value="save" />
		</p>
	</form>
</div> 

<?php
}
add_action('admin_init', 'mytheme_add_init');
add_action('admin_menu', 'mytheme_add_admin');
add_action('admin_menu', 'register_my_custom_submenu_page');

/* check field slug*/
add_action("wp_ajax_check_slug", "check_slug");
add_action("wp_ajax_nopriv_check_slug", "check_slug");

function check_slug(){
	global $wpdb;
	global $wpcInstance;
	$slug = trim($_POST['slug']);
	$result = $wpcInstance->createslug($slug);
	print_r($result); 
	die();
	}
?>
