<?php 
class wpc{

	
	public function __construct(){
		global $wpdb;
    }
	

	
	/* Add your Custom options field here
	 * Author Davinder Singh
	 * @ array (name , value)
	 * */ 
	 
	public function getSections(){
		global $wpdb;
		$GetSectionArray = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'optionspage_section' , OBJECT );
		return $GetSectionArray;
	}
	
		
	public function getFields($sectionID){
		global $wpdb;
		$GetfieldsArray = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'optionspage_fields where wpc_sectionID = '.$sectionID , OBJECT );
		return $GetfieldsArray;
	} 
	
	public function getSectionByID($SectionID){
		global $wpdb;
		$sectionid = (int) ($SectionID);
		$GetSpecificsectionArray = $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'optionspage_section where id='.$sectionid , OBJECT );
		return $GetSpecificsectionArray;
	}
	public function saveUpdateSection($dataArray = array()){
		global $wpdb;
		$dataManupliateArray = array();
		if ( ! isset( $_POST['save_section'] ) || ! wp_verify_nonce( $_POST['save_section'], 'save_section' ) 
		) {
			print 'Sorry, your nonce did not verify.';
		   exit;
		} else {
			foreach ($dataArray  as $key=>$dataconent){
				if($key == 'wpc_Title'){
					$dataManupliateArray[$key] = $dataconent;
				}
			}
			if($dataArray['action']=='update' && $dataArray['id']!=''){
				$response = $wpdb->update( $wpdb->prefix.'optionspage_section', $dataManupliateArray, array( 'id' => $dataArray['id'] ));
			} else {
				$response = $wpdb->insert($wpdb->prefix.'optionspage_section',	$dataManupliateArray);
			}
		}
		return $response;
	}
	
	public function deleteSection($sectionID){
		global $wpdb;
		$response = $wpdb->delete( $wpdb->prefix.'optionspage_section', array( 'id' => $sectionID ) );
		return $response;
	}
	
	public function createslug($slug){
		global $wpdb;
		 $response = $wpdb->get_row( 'SELECT count(*) as slugcount FROM '.$wpdb->prefix.'optionspage_fields where `wpc_optionKey`="'.$slug.'"' , OBJECT ); 
		 if($response->slugcount > 0){
			$count = $response->slugcount+1;
			$slug = $slug.$count;
		 } else {
			$slug = $slug;
		 }
		return json_encode($slug);
	}
	
		public function insertField($dataArray = array()){
		global $wpdb;
		$dataManupliateArray = array();
		if ( ! isset( $_POST['save_field'] ) || ! wp_verify_nonce( $_POST['save_field'], 'save_field' ) 
		) {
			print 'Sorry, your nonce did not verify.';
		   exit;
		} else {
		
		
			foreach ($dataArray  as $key=>$dataconent){
			
			$array = array ('wpc_name' , 'wpc_description','wpc_type','wpc_sectionID','wpc_optionKey');
				if(in_array( $key ,$array)){
					$dataManupliateArray[$key] = $dataconent;
				}
			}
			if($dataArray['action']=='update' && $dataArray['id']!=''){
				$response = $wpdb->update( $wpdb->prefix.'optionspage_fields', $dataManupliateArray, array( 'id' => $dataArray['id'] ));
			} else {
				$response = $wpdb->insert($wpdb->prefix.'optionspage_fields',	$dataManupliateArray);
			}
		}
		return $response;
	}
	
	
}

