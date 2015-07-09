<div class="wrap am_wrap">
<h1>How To Use WordPress Custom Theme</h1>
<p>
WordPress Custom Settings enables you to save your custom settings like social media links some html block a small text line upload a logo and file etc easily it gives you a options to create sections for categorization of your fields you can edit delete your sections also give you a interface to add multiple fields and manage them.you can call all the fields using shortcode as well </p>
	
<strong><i>Use in Templates :</i> </strong>
<p>You can just get your custom field value by putting the simple WordPress function on you template where you want to get that field : <br /><br />
<img src="<?php echo  plugin_dir_url( __FILE__ ); ?>/images/optiontag.png" class="inactive" alt="wpc_optiontag">
<p> where <code>$option</code> is your field slug which you can get from field management tab.</p><br>
<img src="<?php echo  plugin_dir_url( __FILE__ ); ?>/images/slugs.png" class="inactive" alt="wpc_optiontag" />
<br>
<strong><i>Use in Editor :</i> </strong>
<p>You can use the WordPress Custom Settings in your WordPress Editor as well using shortcodes , to get the simple value like textarea , text field and html textarea just follow the below shortcode: <br><br>
<code>[wpc_get_option slug="your_desire_slug"]</code><br><br>
for getting the upload means image use following shortcode:<br><br>
<code>[wpc_get_option_upload slug="logo-fotter" id="responsive" class="responsive" url="google.com"]</code><br>

</div>
