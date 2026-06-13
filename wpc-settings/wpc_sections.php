<?php 
global $wpdb;
global $wpcInstance;
$value = '';
$title = 'Add';
$fromhiddenaction = 'add';
$sectionId = '';
$addNewLink = '';
if(!empty($_POST) && isset($_POST['wpc_save_section']) && $_POST['wpc_save_section']=='Save Changes'){
	$saveSection = $wpcInstance->saveUpdateSection($_POST);
	if($saveSection){
		echo '<div class="notice notice-success is-dismissible"><p><strong>Section saved successfully.</strong></p></div>';
	} else {
	
	}
}
 if (isset($_GET['deleteSection']) && wp_verify_nonce($_GET['deleteSection'] , 'doing_something' )) { 	
		$delsection = $wpcInstance->deleteSection($_GET['del']);
		if($delsection){
			echo '<div class="notice notice-success is-dismissible"><p><strong>Section deleted successfully.</strong></p></div>';
		}
	} else {
      
    }
	
	if (isset($_GET['editsection']) && wp_verify_nonce($_GET['editsection'] , 'edit_something' )) { 	
		$sectionDatabyID = $wpcInstance->getSectionByID($_GET['edit']);
		$value =  $sectionDatabyID->wpc_Title;
		$title = 'Edit';
		$sectionId = $sectionDatabyID->id;
		$addNewLink = '<a href="'. wp_nonce_url(admin_url('admin.php?page=section-management'), 'edit_something', 'addnew').'" class="page-title-action">Add New</a>';
		$fromhiddenaction = 'update';
	} else {
      
    }
?>
<div class="wrap wpc-wrap">
	<h1 class="wp-heading-inline"><?php echo esc_html($title); ?> Section</h1>
	<?php echo $addNewLink; ?>
	<hr class="wp-header-end">

	<div class="wpc-col-container">
		<!-- Left Column: Add/Edit Form -->
		<div class="wpc-col-left">
			<div class="postbox">
				<div class="postbox-header">
					<h2 class="hndle"><span><?php echo esc_html($title); ?> Section</span></h2>
				</div>
				<div class="inside">
					<form action="admin.php?page=section-management" method="post">
						<?php wp_nonce_field( 'save_section', 'save_section' ); ?>
						<div class="wpc-field-group wpc-field-group-compact">
							<div class="wpc-field-row">
								<div class="wpc-field-label">Section Name <span class="required">*</span></div>
								<div class="wpc-field-input">
									<input name="wpc_Title" class="wpc_Title" type="text" value="<?php echo esc_attr($value); ?>" required />
									<p class="description">Enter the section name.</p>
								</div>
							</div>
						</div>
						<p class="submit" style="float:left;">
							<input type="submit" name="wpc_save_section" class="button button-primary" value="Save Changes" />
							<input type="hidden" name="action" value="<?php echo esc_attr($fromhiddenaction); ?>" />
							<input type="hidden" name="id" value="<?php echo esc_attr($sectionId); ?>" />
						</p>
					</form>
				</div>
			</div>
		</div>

		<!-- Right Column: Sections List -->
		<div class="wpc-col-right">
			<div class="postbox">
				<div class="postbox-header">
					<h2 class="hndle"><span>All Sections</span></h2>
				</div>
				<div class="inside">
					<div class="wpc-grid-table">
						<div class="wpc-grid-header">
							<div class="wpc-grid-col">Section Name</div>
							<div class="wpc-grid-col-actions">Actions</div>
						</div>
						<?php 
						$getSectionArray = $wpcInstance->getSections(); 
						foreach ($getSectionArray as $val) :
							if($val->id == 1) :
						?>
							<div class="wpc-grid-row">
								<div class="wpc-grid-col"><strong><?php echo esc_html($val->wpc_Title); ?></strong> <em>(Default)</em></div>
								<div class="wpc-grid-col-actions"></div>
							</div>
						<?php else : ?>
							<div class="wpc-grid-row">
								<div class="wpc-grid-col">
									<strong><?php echo esc_html($val->wpc_Title); ?></strong>
								</div>
								<div class="wpc-grid-col-actions">
									<span class="row-actions">
										<a href="<?php echo wp_nonce_url(admin_url('admin.php?page=section-management&edit='.$val->id.''), 'edit_something', 'editsection');?>">Edit</a>
										 | 
										<a href="<?php echo wp_nonce_url(admin_url('admin.php?page=section-management&del='.$val->id.''), 'doing_something', 'deleteSection');?>" class="delete" onclick="return confirm('Are you sure you want to delete this section?');">Delete</a>
									</span>
								</div>
							</div>
						<?php endif; endforeach; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
