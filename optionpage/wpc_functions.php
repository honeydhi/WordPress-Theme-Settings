<?php 
global $wpdb;

function getFields($sectionID){
	global $wpdb;
	$GetfieldsArray = $wpdb->get_results( "SELECT * FROM wp_optionspage_fields where sectionID = $sectionID" , OBJECT );
	return $GetfieldsArray;
}
?>
