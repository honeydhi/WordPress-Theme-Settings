<?php 
global $wpdb;
class wpc_shortcodes {
	public static function wpc_get_option_function( $atts ) {
		return get_option($atts['slug']);
	}
	
	public static function wpc_get_option_function_upload( $atts ) {
		$wpc_impage_output= "";

		$wpc_upload_url = isset($atts['url'])? $atts['url']: "";
		$wpc_upload_class = isset($atts['class'])? $atts['class']: "";
		$wpc_upload_id = isset($atts['id'])? $atts['id']: "";


		if($wpc_upload_url && esc_url($wpc_upload_url)){
		if (preg_match("#https?://#", $atts['url']) === 0) {
			$atts['url'] = 'http://'.esc_url($atts['url']);
		}
		
			$wpc_impage_output = '<a href="'.esc_url($atts['url']).'"><img src="'.get_option($atts['slug']).'" class="'.$wpc_upload_class.'" id="'.$atts['id'].'"></a>';
		} else {
			$wpc_impage_output = '<img src="'.get_option($atts['slug']).'" class="'.$wpc_upload_class.'" id="'.$wpc_upload_id.'">';
		}
		return $wpc_impage_output;
	}
	
 }
 add_shortcode( 'wpc_get_option', array( 'wpc_shortcodes', 'wpc_get_option_function' ) );
 add_shortcode( 'wpc_get_option_upload', array( 'wpc_shortcodes', 'wpc_get_option_function_upload' ) );

?>