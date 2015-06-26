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
$themename = "My Theme Settings";
$shortname = "wpc";
include("wpc_functions.php");
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
	
/* Add your Custom options field here
 * Author Davinder Singh
 * @ array (name , value)
 * */
	global $wpdb;
	$GetSectionsArray = $wpdb->get_results( 'SELECT * FROM wp_optionspage_section' , ARRAY_N );
	
	/*echo '<pre>'; print_r($Mainresults); die;
$options = array (
	array( "name" => $themename." Options",
			"type" => "title"),
	array( "name" => "Header Settings",
			"type" => "section"),
	array( "type" => "open"),
	array( "name" => "Phone Number",
			"desc" => "Enter Your Phone number here.",
			"id" => $shortname."_pho",
			"type" => "text",
			"std" => ""),
	array( "name" => "Logo",  
	"desc" => "Upload Logo image  here",  
	"id" => $shortname."_upload_one",  
	"type" => "upload",  
	"std" => ""), 
	array( "type" => "close"),


	
	array( "name" => "Social Media Settings",
			"type" => "section"),
	array( "type" => "open"),
	array( "name" => "Google Plus LinK",
			"desc" => "Enter Your Google Plus Link here.",
			"id" => $shortname."_goo",
			"type" => "text",
			"std" => ""),
	array( "name" => "Facebook LinK",
			"desc" => "Enter Your Facebook Link here.",
			"id" => $shortname."_face",
			"type" => "text",
			"std" => ""),
	array( "name" => "Twitter LinK",
			"desc" => "Enter Your Twitter Link here.",
			"id" => $shortname."_tlink",
			"type" => "text",
			"std" => ""),
	array( "name" => "Youtube LinK",
			"desc" => "Enter Your Youtube Link here.",
			"id" => $shortname."_you",
			"type" => "text",
			"std" => ""),
	array( "name" => "Rss LinK",
			"desc" => "Enter Your Rss Link here.",
			"id" => $shortname."_rss",
			"type" => "text",
			"std" => ""),
	array( "type" => "close"),
	
	array( "name" => "Homepage Settings",
			"type" => "section"),
	array( "type" => "open"),
	array( "name" => "First Block Title",
			"desc" => "Enter Your Home Page First Block Title ",
			"id" => $shortname."_first_block",
			"type" => "text",
			"std" => ""),
	array( "name" => "First Block Discription",
			"desc" => "Enter Your Home Page First Block Discription ",
			"id" => $shortname."_first_dis",
			"type" => "textarea",
			"std" => ""),

	array( "name" => "First Block Image",
			"desc" => "Upload Your Home Page First Block Image ",
			"id" => $shortname."_first_img",
			"type" => "upload",
			"std" => ""),
	array( "name" => "Second Block Title",
			"desc" => "Enter Your Home Page Second Block Title ",
			"id" => $shortname."_second_block",
			"type" => "text",
			"std" => ""),
	array( "name" => "Second Block Discription",
			"desc" => "Enter Your Home Page Second Block Discription ",
			"id" => $shortname."_second_dis",
			"type" => "textarea",
			"std" => ""),

	array( "name" => "Second Block Image",
			"desc" => "Upload Your Home Page Second Block Image ",
			"id" => $shortname."_second_image",
			"type" => "upload",
			"std" => ""),


	array( "name" => "Third Block Title",
			"desc" => "Enter Your Home Page Third Block Title ",
			"id" => $shortname."_third_block",
			"type" => "text",
			"std" => ""),

	array( "name" => "Third Block Discription",
	"desc" => "Enter Your Home Page Third Block Title ",
			"id" => $shortname."_third_dis",
			"type" => "textarea",
			"std" => ""),
	array( "name" => "Third Block Image",
			"desc" => "Upload Your Home Page Third Block Image ",
			"id" => $shortname."_third_img",
			"type" => "upload",
			"std" => ""),


	array( "type" => "close"),

	array( "name" => "Footer Settings",
			"type" => "section"),

	array( "type" => "open"),
	array( "name" => "Copy Right Text",
			"desc" => "Enter Copy Right Text",
			"id" => $shortname."_copyright",
			"type" => "text",
			"std" => ""),

	array( "type" => "close"),
	);
	//echo '<pre>'; print_r($options); die; */
	/* Description : Update and delete the options fields here
	 * 
	 * Author : Davinder Singh
	 * params : none;
	 * */
	 
	function mytheme_add_admin() {
	global $themename, $shortname, $options;
	if ( $_GET['page'] == basename(__FILE__) ) {
			if ( 'save' == $_REQUEST['action'] ) {
			foreach ($options as $value) {
					update_option( $value['id'], $_REQUEST[ $value['id'] ] ); 
				}
			foreach ($options as $value) {
				if( isset( $_REQUEST[ $value['id'] ] ) ) { 
					update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); } 
				else { delete_option( $value['id'] ); } 
				}
				header("Location: admin.php?page=admin_menu.php&saved=true");
				die;
		}
		else if( 'reset' == $_REQUEST['action'] ) {
			foreach ($options as $value) {
				delete_option( $value['id'] ); }
				header("Location: admin.php?page=admin_menu.php&reset=true");
				die;
			}
	}
		add_menu_page($themename, $themename, 'administrator', basename(__FILE__), 'mytheme_admin');
	}

	function register_my_custom_submenu_page() {
		add_submenu_page(get_admin_page_parent(), 'Add New Fields', 'Add New Fields', 'manage_options', 'add-more-options', 'my_custom_submenu_page_callback' );
		remove_submenu_page(get_admin_page_parent(),get_admin_page_parent());
	}
	
	function my_custom_submenu_page_callback(){
		$Add_fields_file = plugin_dir_path( __FILE__ ) . "wpc_add_fields.php";
		if ( file_exists( $Add_fields_file ) )
			require $Add_fields_file;
	}

	/* Description : Include all the Jquery and css files here
	 * 
	 * Author : Davinder Singh
	 * params : none;
	 * */
	function mytheme_add_init() {
		$plugin_URL = plugin_dir_url( __FILE__ );
		wp_enqueue_style("functions", $plugin_URL."functions.css", false, "1.0", "all");
		wp_enqueue_style("functions-styles", $plugin_URL."admin-style.css", false, "1.0", "all");
		wp_enqueue_script("am_script", $plugin_URL."js/am_script.js", false, "1.0");
		wp_enqueue_script("upload_box", $plugin_URL."js/upload_box.js", false, "1.0");
		wp_enqueue_script('media-upload');
		wp_enqueue_script('thickbox');
		//wp_register_script('my-upload', get_bloginfo( 'stylesheet_directory' ) . '/js/uploader.js', array('jquery','media-upload','thickbox'));
		wp_enqueue_script('my-upload');
		wp_enqueue_style('thickbox');
	}
	
	/* Description : Display the setting page in admin
		 * 
		 * Author : Davinder Singh
		 * params : none;
		 * */

	function mytheme_admin() {
	global $themename, $shortname, $options ,$GetSectionsArray;
	$i=0;
	if ( $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings saved.</strong></p></div>';
	if ( $_REQUEST['reset'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings reset.</strong></p></div>';
		foreach ($Mainresults as $mainresultarray) {
				
	}
	?>
	
	
<div class="wrap am_wrap">
	<h2><?php echo $themename; ?> Options Panel</h2>
		<div class="am_opts">
			
<p>Please, use the menu below to setting up your theme.</p>			
<div class="am_section">
	<div class="am_title">
		<h3><img src="<?php echo  plugin_dir_url( __FILE__ ); ?>/images/trans.png" class="inactive" alt="">Social Media Settings</h3>
		<span class="submit"><input name="save2" type="submit" value="Save Changes" /></span>
		<div class="clearfix"></div>
	</div>
	<div class="am_options">
		<div class="am_input am_text">
			<label for="wpc_goo">Google Plus LinK</label>
			<input name="wpc_goo" id="wpc_goo" type="text" value="http://google.com" />
			<small>Enter Your Google Plus Link here.</small>
			<div class="clearfix"></div>
		</div>
		<div class="am_input am_text">
			<label for="wpc_tlink">Twitter LinK</label>
			<input name="wpc_tlink" id="wpc_tlink" type="text" value="" />
			<small>Enter Your Twitter Link here.</small>
			<div class="clearfix"></div>
		</div>
		<div class="am_input am_text">
			<label for="wpc_you">Youtube LinK</label>
			<input name="wpc_you" id="wpc_you" type="text" value="" />
			<small>Enter Your Youtube Link here.</small>
			<div class="clearfix"></div>
		</div>
		<div class="am_input am_text">
			<label for="wpc_rss">Rss LinK</label>
			<input name="wpc_rss" id="wpc_rss" type="text" value="" />
			<small>Enter Your Rss Link here.</small>
		<div class="clearfix"></div>
		</div>
	</div>
</div>
<br/>
<?php
	foreach($GetSectionsArray as $GetSections){ 
	?>
	<div class="am_section">
		<div class="am_title">
		<h3><img src="<?php echo  plugin_dir_url( __FILE__ ); ?>/images/trans.png" class="inactive" alt=""><?php  echo $GetSections[1]; ?></h3>
		<span class="submit"><input name="save2" type="submit" value="Save Changes" /></span>
		<div class="clearfix"></div>
	</div>
	<div class="am_options">
	<?php  $FieldsArray = getFields($GetSections[0]);
	//echo '<pre>';print_r($FieldsArray);
	foreach ($FieldsArray as $Fields){
		switch ( $Fields->type ) {
		case "text":
	?>
	<div class="am_input am_text">
		<label for="wpc_goo"><?php echo $Fields->name; ?></label>
		<input name="wpc_goo" id="wpc_goo" type="<?php echo $Fields->type; ?>" value="" />
		<small><?php echo $Fields->description; ?></small>
		<div class="clearfix"></div>
	</div>
	<?php break; case 'text2': ?>
			   <div class="am_input am_text">
				<style type="text/css">
					.icolor{position:absolute;}
					.icolor_flat,.icolor_ft{position:relative;}
					.icolor td{width: 15px;height: 15px;border: solid 1px #000000;	cursor:pointer;}
					.icolor table{background-color: #FFFFFF;border: solid 1px #ccc;}
					.icolor .icolor_tbx{width:170px;border-top:1px solid #999;border-left:1px solid #ccc;border-right:1px solid #ccc;border-bottom:1px solid #ccc;}
					.icolor_ok img{border:none;}
					.icolorC,h2{width:500px;margin:80px auto;}
					#icolor4 .icolor_tbx{width:154px;padding-right:16px;}
					#icolor4 .icolor_ok{position:absolute;left:154px;top:50%;margin-top:-8px;}
				</style>
		<script type="text/javascript" src="<?php bloginfo('template_url');?>/optionpage/js/jquery.icolor.js"></script> 
		<label for="<?php echo $Fields->optionKey; ?>"><?php echo $Fields->name; ?></label>
		<input name="<?php echo $Fields->optionKey; ?>" id="<?php echo $Fields->optionKey; ?>" type="text" value="<?php if ( get_option( $value['id'] ) != "") { echo stripslashes(get_option( $value['id'])  ); } else { echo $value['std']; } ?>"/>
		<script type="text/javascript">
			//<![CDATA[
			var $ = jQuery.noConflict();
			$("#<?php echo $Fields->optionKey; ?>").icolor({
				onSelect:function(c){this.$tb.css("background-color",c);this.$t.val(c);}
			});	
			//]]>
		</script>
		</div>
	<div class="am_input am_textarea">
	<label for="<?php echo $Fields->optionKey; ?>"><?php echo $Fields->name; ?></label>
	<div class="texted"><textarea id="<?php echo $Fields->optionKey; ?>" name="<?php echo $Fields->optionKey; ?>" type="<?php echo $value['type']; ?>" cols="" rows=""><?php if ( get_option( $Fields->optionKey ) != "") { echo stripslashes(get_option( $Fields->optionKey) ); } else { echo $value['std']; } ?></textarea>
	<div class="clear" style="margin:0;padding:0; clear:both;"></div>
	</div>
	<small><?php echo $Fields->description; ?></small><div class="clearfix"></div>
	<script>
		//<![CDATA[
		bkLib.onDomLoaded(function() { new nicEditor().panelInstance('<?php echo $Fields->optionKey; ?>'); });
		//]]>
	</script>
	</div>
	<?php break; case 'textarea':?>
	<div class="am_input am_textarea">
	<label for="<?php echo $Fields->optionKey; ?>"><?php echo $Fields->name; ?></label>
	<div class="texted"><textarea id="<?php echo $Fields->optionKey; ?>" name="<?php echo $Fields->optionKey; ?>" type="<?php echo $value['type']; ?>" cols="" rows=""><?php if ( get_option( $Fields->optionKey ) != "") { echo stripslashes(get_option( $Fields->optionKey) ); } else { echo $value['std']; } ?></textarea>
	<div class="clear" style="margin:0;padding:0; clear:both;"></div>
	</div>
	<small><?php echo $Fields->description; ?></small><div class="clearfix"></div>
	<script>
		//<![CDATA[
		bkLib.onDomLoaded(function() { new nicEditor().panelInstance('<?php echo $Fields->optionKey; ?>'); });
		//]]>
	</script>
	</div>
	<?php break; case 'textarea2': ?>
	<div class="am_input am_textarea">
			<label for="<?php echo $Fields->optionKey; ?>"><?php echo $Fields->name; ?></label>
			<div class="texted"><textarea  name="<?php echo $Fields->optionKey; ?>" type="<?php echo $value['type']; ?>" cols="" rows=""><?php if ( get_option( $Fields->optionKey ) != "") { echo stripslashes(get_option( $Fields->optionKey) ); } else { echo $value['std']; } ?></textarea>
			<div class="clear" style="margin:0;padding:0; clear:both;"></div>
		</div>
		<small><?php echo $Fields->description; ?></small><div class="clearfix"></div>
	</div> 
	<?php break; case 'select':?>
	<div class="am_input am_select">
		<label for="<?php echo $Fields->optionKey; ?>"><?php echo $Fields->name; ?></label>
			<select name="<?php echo $Fields->optionKey; ?>" id="<?php echo $Fields->optionKey; ?>">
			<?php foreach ($value['options'] as $key=>$option) { ?>
			<option <?php if (get_option( $Fields->optionKey ) == $key) { echo 'selected="selected"'; } ?> value="<?php echo $key; ?>"><?php echo $option; ?></option><?php } ?>
			</select>
		<small><?php echo $Fields->description; ?></small><div class="clearfix"></div>
	</div>
	<?php break; case 'upload': ?>
	<div class="rm_input rm_upload">
		<p class="awdMetaImage" style="padding-left:15px; max-width:720px;"><img  src="<?php if ( get_option( $Fields->optionKey ) != "") { echo stripslashes(get_option( $Fields->optionKey) ); } else { echo $value['std']; } ?>"  /> <p>
		<label style="padding-left:15px;" for="<?php echo $Fields->optionKey; ?>"><?php echo $Fields->name; ?></label>
		<input type="text" class="upload-url <?php echo $field_class; ?>" name="<?php echo $Fields->optionKey; ?>" id="<?php echo $value['name']; ?>" value="<?php if ( get_option( $Fields->optionKey ) != "") { echo stripslashes(get_option( $Fields->optionKey ) ); } else { echo $value['std']; } ?>" />
		<input id="st_upload_button" class="st_upload_button" type="button" name="upload_button" value="Upload"  />
	</div>
	<?php break; case "checkbox":?>
	<div class="am_input am_checkbox">
		<label for="<?php echo $Fields->optionKey; ?>"><?php echo $value['name']; ?></label>
		<?php if(get_option($Fields->optionKey)){ $checked = "checked=\"checked\""; }else{ $checked = "";} ?>
		<input type="checkbox" name="<?php echo $Fields->optionKey; ?>" id="<?php echo $Fields->optionKey; ?>" value="true" <?php echo $checked; ?> />
		<small><?php echo $Fields->description; ?></small><div class="clearfix"></div>
	</div>
	
	<?php break; default: ?>
	<?php }
	} ?></div>
	</div>
<br/>
	<?php }

	?>
	
	
	
	<!--
			<form method="post">
				<?php foreach ($options as $value) {
					switch ( $value['type'] ) {
					case "open":
				?>
				<?php break; case "close": ?>
				</div>
				</div>
				<br/>
				<?php break; case "title": 	?>
				<p>Please, use the menu below to setting up your theme.</p>
				<?php break; case 'text':?>
				<div class="am_input am_text">
					<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
					<input name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_option( $value['id'] ) != "") { echo stripslashes(get_option( $value['id'])  ); } else { echo $value['std']; } ?>" />
					<small><?php echo $value['desc']; ?></small><div class="clearfix"></div>
				</div>
			 <?php break; case 'text2': ?>
			   <div class="am_input am_text">
				<style type="text/css">
					.icolor{position:absolute;}
					.icolor_flat,.icolor_ft{position:relative;}
					.icolor td{width: 15px;height: 15px;border: solid 1px #000000;	cursor:pointer;}
					.icolor table{background-color: #FFFFFF;border: solid 1px #ccc;}
					.icolor .icolor_tbx{width:170px;border-top:1px solid #999;border-left:1px solid #ccc;border-right:1px solid #ccc;border-bottom:1px solid #ccc;}
					.icolor_ok img{border:none;}
					.icolorC,h2{width:500px;margin:80px auto;}
					#icolor4 .icolor_tbx{width:154px;padding-right:16px;}
					#icolor4 .icolor_ok{position:absolute;left:154px;top:50%;margin-top:-8px;}
				</style>
		<script type="text/javascript" src="<?php bloginfo('template_url');?>/optionpage/js/jquery.icolor.js"></script> 
		<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
		<input name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="text" value="<?php if ( get_option( $value['id'] ) != "") { echo stripslashes(get_option( $value['id'])  ); } else { echo $value['std']; } ?>"/>
		<script type="text/javascript">
			//<![CDATA[
			var $ = jQuery.noConflict();
			$("#<?php echo $value['id']; ?>").icolor({
				onSelect:function(c){this.$tb.css("background-color",c);this.$t.val(c);}
			});	
			//]]>
		</script>
		</div>
	<?php break; case 'textarea':?>
	<div class="am_input am_textarea">
	<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
	<div class="texted"><textarea id="<?php echo $value['id']; ?>" name="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" cols="" rows=""><?php if ( get_option( $value['id'] ) != "") { echo stripslashes(get_option( $value['id']) ); } else { echo $value['std']; } ?></textarea>
	<div class="clear" style="margin:0;padding:0; clear:both;"></div>
	</div>
	<small><?php echo $value['desc']; ?></small><div class="clearfix"></div>
	<script>
		//<![CDATA[
		bkLib.onDomLoaded(function() { new nicEditor().panelInstance('<?php echo $value['id']; ?>'); });
		//]]>
	</script>
	</div>
	<?php break; case 'textarea2': ?>
	<div class="am_input am_textarea">
			<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
			<div class="texted"><textarea  name="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" cols="" rows=""><?php if ( get_option( $value['id'] ) != "") { echo stripslashes(get_option( $value['id']) ); } else { echo $value['std']; } ?></textarea>
			<div class="clear" style="margin:0;padding:0; clear:both;"></div>
		</div>
		<small><?php echo $value['desc']; ?></small><div class="clearfix"></div>
	</div> 
	<?php break; case 'select':?>
	<div class="am_input am_select">
		<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
			<select name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">
			<?php foreach ($value['options'] as $key=>$option) { ?>
			<option <?php if (get_option( $value['id'] ) == $key) { echo 'selected="selected"'; } ?> value="<?php echo $key; ?>"><?php echo $option; ?></option><?php } ?>
			</select>
		<small><?php echo $value['desc']; ?></small><div class="clearfix"></div>
	</div>
	<?php break; case 'upload': ?>
	<div class="rm_input rm_upload">
		<?php default: ?>
		<p class="awdMetaImage" style="padding-left:15px; max-width:720px;"><img  src="<?php if ( get_option( $value['id'] ) != "") { echo stripslashes(get_option( $value['id']) ); } else { echo $value['std']; } ?>"  /> <p>
		<label style="padding-left:15px;" for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
		<input type="text" class="upload-url <?php $field_class ?>" name="<?php echo $value['id']; ?>" id="<?php echo $value['name']; ?>" value="<?php if ( get_option( $value['id'] ) != "") { echo stripslashes(get_option( $value['id']) ); } else { echo $value['std']; } ?>" />
		<input id="st_upload_button" class="st_upload_button" type="button" name="upload_button" value="Upload"  />
	</div>
	<?php break; case "checkbox":?>
	<div class="am_input am_checkbox">
		<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
		<?php if(get_option($value['id'])){ $checked = "checked=\"checked\""; }else{ $checked = "";} ?>
		<input type="checkbox" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" value="true" <?php echo $checked; ?> />
		<small><?php echo $value['desc']; ?></small><div class="clearfix"></div>
	</div>
	<?php break; case "section": $i++; ?>
		<div class="am_section">
			<div class="am_title">
			<h3><img src="<?php echo plugin_dir_url( __FILE__ ); ?>/images/trans.png" class="inactive" alt="""><?php echo $value['name']; ?></h3>
			<span class="submit"><input name="save<?php echo $i; ?>" type="submit" value="Save Changes" /></span>
			<div class="clearfix"></div></div>
				<div class="am_options">
				<?php break;
				}
		}
	?>
		<p class="submit save">
			<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
			<input type="hidden" name="action" value="save" />
		</p>
	</form>-->
	</div> 

<?php
}
add_action('admin_init', 'mytheme_add_init');
add_action('admin_menu', 'mytheme_add_admin');
add_action('admin_menu', 'register_my_custom_submenu_page');


?>
