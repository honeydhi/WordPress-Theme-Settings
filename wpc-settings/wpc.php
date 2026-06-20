<?php
/*
    Plugin Name: WPC Custom settings 
    Plugin URI: https://www.linkedin.com/in/davinder-singh-ai/
    Description: Plugin for setting up the basic information like social media settings and footer content, this plugin helps the developer to save some of miscellaneous items easily there is no need to make any specific widgets and post type just save all the values in options.
    Author: Davinder Singh
    Version: 1.2
    Author URI: https://www.linkedin.com/in/davinder-singh-ai/
    Requires at least: 6.0
    Tested up to: 7.0
    Requires PHP: 7.4
    */

/* Set your theme name & shortname to get options fields*/
$themename = "WPC Custom Settings";
$shortname = "wpc";
include( plugin_dir_path( __FILE__ ) . 'inc/wpc_class.php');
include( plugin_dir_path( __FILE__ ) . 'inc/shortcodes.php');
require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
$wpcInstance = new wpc;

global $wpc_db_version;
$wpc_db_version = '1.0';

function wpc_install() {
	global $wpdb;
	global $wpc_db_version;

	$wpc_table_name_first = $wpdb->prefix . 'optionspage_section';
	$wpc_table_name_second = $wpdb->prefix . 'optionspage_fields';
	$charset_collate = $wpdb->get_charset_collate();

	$sqlForSection = "CREATE TABLE IF NOT EXISTS $wpc_table_name_first (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		  `wpc_Title` varchar(255) NOT NULL,
		  `wpc_Modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		  PRIMARY KEY (`id`)
	) $charset_collate;";
	
	
	$sqlForFields = "CREATE TABLE IF NOT EXISTS $wpc_table_name_second (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`wpc_sectionID` int(11) NOT NULL,
		`wpc_name` varchar(255) NOT NULL,
		`wpc_description` varchar(255) NOT NULL,
		`wpc_optionKey` varchar(255) NOT NULL,
		`wpc_type` varchar(255) NOT NULL,
		`modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		PRIMARY KEY (`id`)
	) $charset_collate;";
	dbDelta( $sqlForSection );
	dbDelta( $sqlForFields );
	add_option( 'wpc_db_version', $wpc_db_version );
}
function wpc_install_data() {
	global $wpdb;
	
	$wpc_table_name_first = $wpdb->prefix . 'optionspage_section';
	$charset_collate = $wpdb->get_charset_collate();
	$insertDefaultVaue ="INSERT INTO $wpc_table_name_first (wpc_Title)
	SELECT * FROM (SELECT 'Default Section') AS tmp
	WHERE NOT EXISTS (
		SELECT wpc_Title FROM $wpc_table_name_first WHERE wpc_Title = 'Default Section'
	) LIMIT 1";
	dbDelta( $insertDefaultVaue );
}

register_activation_hook( __FILE__, 'wpc_install' );
register_activation_hook( __FILE__, 'wpc_install_data' );




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
	 
	function wpc_add_admin() {
	global $themename, $shortname ,$wpcInstance;
	if ( isset( $_GET['page'] ) && $_GET['page'] == 'wpc-management' && isset( $_REQUEST['action'] ) ) {
			if ( 'save' == $_REQUEST['action'] ) {
			foreach ($_REQUEST as $key=>$value) {
				if( isset( $_REQUEST[ $key ] ) ) { 
					update_option( $key , $value  ); } 
				else { delete_option( $key ); } 
				}
				header("Location: admin.php?page=wpc-management&saved=true");
				die;
		}
		else if( 'reset' == $_REQUEST['action'] ) {
			foreach ($_REQUEST as $key=>$value) {
				delete_option( $key ); }
				header("Location: admin.php?page=wpc-management&reset=true");
				die;
			}
	}
		add_menu_page($themename, $themename, 'manage_options', 'wpc-management', 'wpc_admin', '');
		
	}
	
	/* Add Section Management and Fields Management pages here
	* Author Davinder Singh
	*/
	function wpc_register_submenu_page() {
		add_submenu_page('wpc-management','Section Management', 'Section Management', 'manage_options', 'section-management', 'wpc_get_add_section_page_admin' );
		add_submenu_page('wpc-management', 'Fields Management', 'Fields Management', 'manage_options', 'field-management', 'wpc_get_add_field_page_admin' );
		add_submenu_page('wpc-management', 'How to use', 'How to use', 'manage_options', 'how-to-use-wpc', 'wpc_how_to_use' );
	}
	
	/* Include Fields Management File
	* Davinder Singh
	**/
	
	function wpc_get_add_field_page_admin(){
		$Add_fields_file = plugin_dir_path( __FILE__ ) . "wpc_fields.php";
		if ( file_exists( $Add_fields_file ) )
			require $Add_fields_file;
	}
	
	/* Include Section Management File
	* Davinder Singh
	**/
	
	function wpc_get_add_section_page_admin(){
		$Add_section_file = plugin_dir_path( __FILE__ ) . "wpc_sections.php";
		if ( file_exists( $Add_section_file ) )
			require $Add_section_file;
	}
	/* Include How to Use File
	* Davinder Singh
	**/
	
	function wpc_how_to_use(){
		$Add_how_to_use = plugin_dir_path( __FILE__ ) . "wpc_how_to_use.php";
		if ( file_exists( $Add_how_to_use ) )
			require $Add_how_to_use;
	}
	/* Description : Include all the Jquery and css files here
	 * 
	 * Author : Davinder Singh
	 * params : none;
	 * */
	function wpc_add_init() {
		$plugin_URL = plugin_dir_url( __FILE__ );
		wp_enqueue_style( 'wpc-functions', $plugin_URL . 'css/functions.css', array(), '2.1', 'all' );
		wp_enqueue_style( 'wpc-admin-style', $plugin_URL . 'css/admin-style.css', array(), '2.1', 'all' );
		wp_enqueue_script( 'postbox' );
		wp_enqueue_script( 'jquery-validation', $plugin_URL . 'js/jquery.validate.min.js', array( 'jquery' ), '2.0' );
		wp_enqueue_script( 'jquery-wpc-functions', $plugin_URL . 'js/wpc_functions.js', array( 'jquery' ), '2.0' );
		wp_enqueue_media();
	}
	
	/* Description : Display the setting page in admin
		 * 
		 * Author : Davinder Singh
		 * params : none;
		 * */

	function wpc_admin() {
	global $themename, $shortname ,$wpcInstance;
	$i=0;
	?>
	<div class="wrap wpc-wrap">
		<h1><?php echo esc_html($themename); ?> — Options Panel</h1>
		<?php
		if ( isset($_REQUEST['saved'] )) {
			echo '<div class="notice notice-success is-dismissible"><p><strong>' . esc_html($themename) . ' settings saved.</strong></p></div>';
		}
		if ( isset($_REQUEST['reset'] )) {
			echo '<div class="notice notice-warning is-dismissible"><p><strong>' . esc_html($themename) . ' settings reset.</strong></p></div>';
		}
		?>
		<p>Use the panels below to configure your settings.</p>

		<form method="post">
		<?php wp_nonce_field( 'wpc_save_options', 'wpc_options_nonce' ); ?>
		<?php
		$GetSectionsArray = $wpcInstance->getSections();
		foreach($GetSectionsArray as $GetSections){
			$FieldsArray = $wpcInstance->getFields($GetSections->id);
			$isEmpty = empty($FieldsArray);
			$postbox_class = 'postbox closed' . ($isEmpty ? ' wpc-disabled-postbox' : '');
		?>
		<div class="wpc-postbox">
			<div class="<?php echo esc_attr($postbox_class); ?>">
				<div class="postbox-header">
					<h2 class="hndle">
						<span class="wpc-status-dot <?php echo $isEmpty ? 'wpc-status-empty' : 'wpc-status-has-fields'; ?>"></span>
						<span><?php echo esc_html( $GetSections->wpc_Title ); ?> <?php if($isEmpty) echo '<small>(No fields)</small>'; ?></span>
					</h2>
					<?php if (!$isEmpty) : ?>
					<div class="handle-actions hide-if-no-js">
						<button type="button" class="handlediv" aria-expanded="false">
							<span class="screen-reader-text"><?php printf( esc_html__( 'Toggle panel: %s' ), esc_html( $GetSections->wpc_Title ) ); ?></span>
							<span class="toggle-indicator" aria-hidden="true"></span>
						</button>
					</div>
					<?php endif; ?>
				</div>
				<div class="inside">
					<div class="wpc-field-group">
					<?php
					if ($isEmpty) {
						echo '<div class="wpc-field-row"><div class="wpc-field-input"><p class="description">This section currently has no fields. Add fields in the <a href="'.admin_url('admin.php?page=field-management').'">Fields Management</a> page.</p></div></div>';
					} else {
					foreach ($FieldsArray as $Fields){
						switch ( $Fields->wpc_type ) {
						case 'text':
					?>
						<div class="wpc-field-row">
							<div class="wpc-field-label">
								<label for="<?php echo esc_attr($Fields->wpc_optionKey); ?>"><?php echo esc_html($Fields->wpc_name); ?></label>
							</div>
							<div class="wpc-field-input">
								<input name="<?php echo esc_attr($Fields->wpc_optionKey); ?>" id="<?php echo esc_attr($Fields->wpc_optionKey); ?>" type="text" value="<?php echo esc_attr( stripslashes( get_option( $Fields->wpc_optionKey, '' ) ) ); ?>" class="regular-text" />
								<?php if ( ! empty( $Fields->wpc_description ) ) : ?>
									<p class="description"><?php echo esc_html($Fields->wpc_description); ?></p>
								<?php endif; ?>
							</div>
						</div>
					<?php break; case 'textarea': ?>
						<div class="wpc-field-row">
							<div class="wpc-field-label">
								<label for="<?php echo esc_attr($Fields->wpc_optionKey); ?>"><?php echo esc_html($Fields->wpc_name); ?></label>
							</div>
							<div class="wpc-field-input">
								<div class="wpc-wp-editor-wrap">
									<?php 
									$content = get_option( $Fields->wpc_optionKey, '' );
									wp_editor( stripslashes($content), $Fields->wpc_optionKey, array(
										'textarea_name' => $Fields->wpc_optionKey,
										'textarea_rows' => 8,
										'media_buttons' => true,
										'tinymce'       => true,
										'quicktags'     => true
									));
									?>
								</div>
								<?php if ( ! empty( $Fields->wpc_description ) ) : ?>
									<p class="description"><?php echo esc_html($Fields->wpc_description); ?></p>
								<?php endif; ?>
							</div>
						</div>
					<?php break; case 'textarea2': ?>
						<div class="wpc-field-row">
							<div class="wpc-field-label">
								<label for="<?php echo esc_attr($Fields->wpc_optionKey); ?>"><?php echo esc_html($Fields->wpc_name); ?></label>
							</div>
							<div class="wpc-field-input">
								<textarea name="<?php echo esc_attr($Fields->wpc_optionKey); ?>" id="<?php echo esc_attr($Fields->wpc_optionKey); ?>" rows="6" class="large-text"><?php echo esc_textarea( stripslashes( get_option( $Fields->wpc_optionKey, '' ) ) ); ?></textarea>
								<?php if ( ! empty( $Fields->wpc_description ) ) : ?>
									<p class="description"><?php echo esc_html($Fields->wpc_description); ?></p>
								<?php endif; ?>
							</div>
						</div>
					<?php break; case 'select': ?>
						<div class="wpc-field-row">
							<div class="wpc-field-label">
								<label for="<?php echo esc_attr($Fields->wpc_optionKey); ?>"><?php echo esc_html($Fields->wpc_name); ?></label>
							</div>
							<div class="wpc-field-input">
								<select name="<?php echo esc_attr($Fields->wpc_optionKey); ?>" id="<?php echo esc_attr($Fields->wpc_optionKey); ?>">
								<?php if ( isset($value['options']) && is_array($value['options']) ) { foreach ($value['options'] as $key=>$option) { ?>
									<option <?php selected( get_option( $Fields->wpc_optionKey ), $key ); ?> value="<?php echo esc_attr($key); ?>"><?php echo esc_html($option); ?></option>
								<?php } } ?>
								</select>
								<?php if ( ! empty( $Fields->wpc_description ) ) : ?>
									<p class="description"><?php echo esc_html($Fields->wpc_description); ?></p>
								<?php endif; ?>
							</div>
						</div>
					<?php break; case 'upload': ?>
						<div class="wpc-field-row">
							<div class="wpc-field-label">
								<label for="<?php echo esc_attr($Fields->wpc_optionKey); ?>"><?php echo esc_html($Fields->wpc_name); ?></label>
							</div>
							<div class="wpc-field-input">
								<?php $upload_val = stripslashes( get_option( $Fields->wpc_optionKey, '' ) ); ?>
								<div class="wpc-upload-preview">
									<?php if ( ! empty( $upload_val ) ) : ?>
										<img src="<?php echo esc_url( $upload_val ); ?>" alt="" />
									<?php endif; ?>
								</div>
								<div class="wpc-upload-field">
									<input type="text" name="<?php echo esc_attr($Fields->wpc_optionKey); ?>" id="<?php echo esc_attr($Fields->wpc_optionKey); ?>" value="<?php echo esc_attr( $upload_val ); ?>" class="regular-text" />
									<button type="button" class="button wpc-media-upload" data-target="<?php echo esc_attr($Fields->wpc_optionKey); ?>"><?php esc_html_e('Upload'); ?></button>
								</div>
							</div>
						</div>
					<?php break; case 'checkbox': ?>
						<div class="wpc-field-row">
							<div class="wpc-field-label">
								<?php echo esc_html($Fields->wpc_name); ?>
							</div>
							<div class="wpc-field-input">
								<label for="<?php echo esc_attr($Fields->wpc_optionKey); ?>">
									<input type="checkbox" name="<?php echo esc_attr($Fields->wpc_optionKey); ?>" id="<?php echo esc_attr($Fields->wpc_optionKey); ?>" value="true" <?php checked( get_option($Fields->wpc_optionKey), 'true' ); ?> />
									<?php if ( ! empty( $Fields->wpc_description ) ) echo esc_html($Fields->wpc_description); ?>
								</label>
							</div>
						</div>
					<?php break; default: ?>
					<?php } // end switch
					} // end foreach fields
					} // end if !isEmpty ?>
					</div><!-- .wpc-field-group -->
				</div><!-- .inside -->
			</div><!-- .postbox -->
		</div><!-- .wpc-postbox -->
		<?php } // end foreach sections ?>

		<div class="wpc-submit-box">
			<input type="submit" class="button button-primary" value="<?php esc_attr_e('Save Changes'); ?>" />
			<input type="hidden" name="action" value="save" />
		</div>
		</form>

		<script>
		jQuery(document).ready(function($){
			// Collapsible postbox toggle
			$('.wpc-postbox .handlediv, .wpc-postbox .hndle').on('click', function(){
				var $postbox = $(this).closest('.postbox');
				if ($postbox.hasClass('wpc-disabled-postbox')) {
					return false;
				}
				$postbox.toggleClass('closed');
				var isClosed = $postbox.hasClass('closed');
				$postbox.find('.handlediv').attr('aria-expanded', isClosed ? 'false' : 'true');
			});
			// Media upload
			$('.wpc-media-upload').on('click', function(e){
				e.preventDefault();
				var targetId = $(this).data('target');
				var frame = wp.media({ title: 'Select or Upload Media', button: { text: 'Use this media' }, multiple: false });
				frame.on('select', function(){
					var attachment = frame.state().get('selection').first().toJSON();
					$('#' + targetId).val(attachment.url);
					$(e.target).closest('td').find('.wpc-upload-preview').html('<img src="' + attachment.url + '" />');
				});
				frame.open();
			});
		});
		</script>
	</div><!-- .wrap -->
<?php
}
add_action('admin_enqueue_scripts', 'wpc_add_init');
add_action('admin_menu', 'wpc_add_admin');
add_action('admin_menu', 'wpc_register_submenu_page');

/* check field slug*/
add_action("wp_ajax_wpc_check_slug", "wpc_check_slug");
add_action("wp_ajax_nopriv_wpc_check_slug", "wpc_check_slug");

function wpc_check_slug(){
	global $wpdb;
	global $wpcInstance;
	$slug = isset($_POST['slug']) ? sanitize_text_field( wp_unslash( $_POST['slug'] ) ) : '';
	$result = $wpcInstance->createslug($slug);
	wp_send_json($result); 
	die();
	}
?>
