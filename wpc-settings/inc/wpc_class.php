<?php 
class wpc{

	
	public function __construct(){
		global $wpdb;
    }
	

	
	/* Get Sections
	 * Author Davinder Singh
	 * @ params (field name , return type)
	 * return array
	 * */ 
	 
	public function getSections($fields = array(), $arrayType = OBJECT){
		global $wpdb;
		if (!empty($fields)) :
		$fields = implode(",",$fields); else:
		$fields = '*';
		endif;
		$GetSectionArray = $wpdb->get_results( 'SELECT '.$fields.' FROM '.$wpdb->prefix.'optionspage_section' , $arrayType );
		return $GetSectionArray;
	}
	
	/* Get Fields by section ID
	  * Author Davinder Singh
	 * @ params (secton id ,field name , return type)
	 * return array
	 * */ 
		
	public function getFields($sectionID , $fields = array() , $arrayType = OBJECT){
		global $wpdb;
		if (!empty($fields)) :
		$fields = implode(",",$fields); else:
		$fields = '*';
		endif;
		$GetfieldsArray = $wpdb->get_results( 'SELECT '.$fields.' FROM '.$wpdb->prefix.'optionspage_fields where wpc_sectionID = '.$sectionID , $arrayType );
		return $GetfieldsArray;
	} 
	/* Get all Fields
	  * Author Davinder Singh
	 * @ params (field name , return type)
	 * return array
	 * */ 
	
	
	public function getAllFields($fields = array() , $arrayType = OBJECT){
		global $wpdb;
		if (!empty($fields)) :
		$fields = implode(",",$fields); else:
		$fields = '*';
		endif;
		$GetfieldsArray = $wpdb->get_results( 'SELECT '.$fields.' FROM '.$wpdb->prefix.'optionspage_fields ', $arrayType );
		return $GetfieldsArray;
	} 

	/* Get Section by section id
	  * Author Davinder Singh
	 * @ params (sectionID)
	 * return array
	 * */ 
	
	public function getSectionByID($SectionID){
		global $wpdb;
		$sectionid = (int) ($SectionID);
		$GetSpecificsectionArray = $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'optionspage_section where id='.$sectionid , OBJECT );
		return $GetSpecificsectionArray;
	}
	
	/* Get Field by Field id
	  * Author Davinder Singh
	 * @ params (Field ID)
	 * return array
	 * */ 
	
	public function getFieldByID($FieldID){
		global $wpdb;
		$FieldID = (int) ($FieldID);
		$GetSpecificsectionArray = $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'optionspage_fields where id='.$FieldID , OBJECT );
		return $GetSpecificsectionArray;
	}
	
	/* Save and update the Sections
	  * Author Davinder Singh
	 * @ params (post data array)
	 * return boolean
	 * */ 
	
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
	
	/* Delete section and assign the deleted section fields to default section
	  * Author Davinder Singh
	 * @ params (section ID)
	 * return boolean
	 * */ 
	
	public function deleteSection($sectionID){
		global $wpdb;
		$get = $this->getFields($sectionID, array('id') , OBJECT);
		foreach ($get as $valueArray){
			foreach ($valueArray as $value){
				$table = $wpdb->prefix.'optionspage_fields';
				$data_array = array('wpc_sectionID' => 1);
				$where = array('id' => $value);
				$wpdb->update( $table, $data_array, $where );
			}
		}
        $response = $wpdb->delete( $wpdb->prefix.'optionspage_section', array( 'id' => $sectionID ) );
		return $response;
	}
	
	/* Delete field
	  * Author Davinder Singh
	 * @ params (Field ID)
	 * return boolean
	 * */ 
	
	
	public function deleteField($fieldID){
		global $wpdb;
        $response = $wpdb->delete( $wpdb->prefix.'optionspage_fields', array( 'id' => $fieldID ) );
		return $response;
	}
	
	/* Create unique Field slug
	  * Author Davinder Singh
	 * @ params (slug)
	 * return string
	 * */ 
	
	public function createslug($slug){
		global $wpdb;
		 $response = $wpdb->get_row( 'SELECT count(*) as slugcount FROM '.$wpdb->prefix.'optionspage_fields where `wpc_optionKey`="'.$slug.'"' , OBJECT ); 
		 if($response->slugcount > 0){
			$slug = '';
		 } else {
			$slug = $slug;
		 }
		return json_encode($slug);
	}
	
	/* Insert and update the field
	  * Author Davinder Singh
	 * @ params (array post)
	 * return boolean
	 * */ 
	
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

