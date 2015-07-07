 jQuery(document).ready(function() {
    jQuery('.st_upload_button').click(function() {
         var targetfield = jQuery(this).prev('input.upload-url');
		
               
     tb_show('', 'media-upload.php?TB_iframe=true');
 
    window.send_to_editor = function(html) {
		 html='<div>'+html+'</div>';		 
         imgurl = jQuery('img',html).attr('src');
		// jQuery('#'+formfield).val(imgurl);

			targetfield.val(imgurl);
			
	     targetfield.closest('p').prev('.awdMetaImage').html('<img height=120 width=120 src="'+imgurl+'"/>');  
			
		  //targetfield.closest('p').prev("div.image_wrap").html('<img src="'+imgurl+'" height="100" width="100" />');
        tb_remove();
    }
 return false;
 
 });
 
});
