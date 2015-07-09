<?php 
global $wpdb;
class wpc_shortcodes {
	public static function wpc_get_option_function( $atts ) {
		echo get_option($atts['slug']);
	}
	
	public static function wpc_get_option_function_upload( $atts ) {
		if(esc_url($atts['url'])){
		if (preg_match("#https?://#", $atts['url']) === 0) {
			$atts['url'] = 'http://'.esc_url($atts['url']);
		}
		
		echo '<a href="'.esc_url($atts['url']).'"><img src="'.get_option($atts['slug']).'" class="'.$atts['class'].'" id="'.$atts['id'].'"></a>';
		} else {
		echo '<img src="'.get_option($atts['slug']).'" class="'.$atts['class'].'" id="'.$atts['id'].'">';
		}
	}
	
 }
 add_shortcode( 'wpc_get_option', array( 'wpc_shortcodes', 'wpc_get_option_function' ) );
 add_shortcode( 'wpc_get_option_upload', array( 'wpc_shortcodes', 'wpc_get_option_function_upload' ) );

?>