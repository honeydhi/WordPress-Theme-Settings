<?php 
global $wpdb;
global $wpcInstance;
$value = '';
$title = 'Add';
$fromhiddenaction = 'add';
$sectionId = '';
$addNewLink = '';
if((!empty($_POST) && $_POST['wpc_save_section']=='Save Changes')){
	$saveSection = $wpcInstance->saveUpdateSection($_POST);
	if($saveSection){
		echo '<div id="message" class="updated fade"><p><strong>Settings saved.</strong></p></div>';
	} else {
	
	}
}
 if (isset($_GET['deleteSection']) && wp_verify_nonce($_GET['deleteSection'] , 'doing_something' )) { 	
		$delsection = $wpcInstance->deleteSection($_GET['del']);
		if($delsection){
			echo '<div id="message" class="updated fade"><p><strong>Deleted Successfully.</strong></p></div>';
		}
	} else {
      
    }
	
	if (isset($_GET['editsection']) && wp_verify_nonce($_GET['editsection'] , 'edit_something' )) { 	
		$sectionDatabyID = $wpcInstance->getSectionByID($_GET['edit']);
		$value =  $sectionDatabyID->wpc_Title;
		$title = 'Edit';
		$sectionId = $sectionDatabyID->id;
		$addNewLink = '<a href="'. wp_nonce_url(admin_url('admin.php?page=section-management'), 'edit_something', 'addnew').'">Add New</a>';
		$fromhiddenaction = 'update';
	} else {
      
    }
?>
<div class="wrap am_wrap" style="float:left; width:50%; margin-top:3%;">
<?php echo $addNewLink; ?>
	<h2><?php echo $title;?> Section</h2>
		<div class="am_opts">	
	<form 	id="wpc_section_form" method="POST" action="<?php echo $_SERVER['REQUEST_URI'] ; ?>" />	
	 <?php wp_nonce_field( 'save_section','save_section' ); ?>

		<div class="am_section">
			<div class="am_optionss">
				<div class="am_input am_text">
					<label for="wpc_Title" style="width:100px;">Section Name<span class="mandatory">*</span> : </label>
					<input name="wpc_Title" id="wpc_Title" type="text" value="<?php echo $value; ?>" />
					<small style="width:190px;">Enter Section name</small>
					<div class="clearfix"></div>
				</div>
			</div>
		</div><br>
		<span class="submit">
			<input type="hidden" name="action" value="<?php echo $fromhiddenaction; ?>" />
			<input type="hidden" name="id" value="<?php echo $sectionId; ?>" />
			<input name="wpc_save_section" type="submit" value="Save Changes" />
		</span>
		</form>
	</div>
</div>
<div class="wrap am_wrap" style="float:left; width:30%">
<div class="am_section" >
<table border="1" style="width:100%" id="sectionTable" class="tablesorter">
<thead>
 <tr>
    <th>Section Name</th>
    <th colspan=2 >Action</th>
  </tr>
  </thead>
  <tbody>
  <?php 
	$getSectionArray = $wpcInstance->getSections(); 
	foreach ($getSectionArray as $value){
	if($value->id == 1) :
	?>
	<tr>
		<td colspan="3"><?php echo $value->wpc_Title; ?></td>
	</tr>
	<?php   else :?>
	<tr>
		<td><?php echo $value->wpc_Title; ?></td>
		<td><a href="<?php echo wp_nonce_url(admin_url('admin.php?page=section-management&del='.$value->id.''), 'doing_something', 'deleteSection');?>">Delete</a></td>		
		<td><a href="<?php echo wp_nonce_url(admin_url('admin.php?page=section-management&edit='.$value->id.''), 'edit_something', 'editsection');?>">Edit</a></td>
	</tr>
	<?php endif; }?>
	<tbody>
    </table>
</div>
</div>
