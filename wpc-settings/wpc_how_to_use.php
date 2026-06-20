<div class="wrap wpc-wrap">
	<h1>How To Use WordPress Custom Settings</h1>

	<div class="wpc-card">
		<p>
			WordPress Custom Settings enables you to save custom settings like social media links, HTML blocks, text lines, logos, and file uploads easily. It provides options to create sections for categorising your fields. You can edit and delete sections, add multiple fields, and manage them — all from the admin panel. Fields can also be used via shortcodes.
		</p>

		<hr />

		<h2>Using in Templates</h2>
		<p>Retrieve a custom field value in your theme template with the standard WordPress function:</p>
		<img src="<?php echo esc_url( plugin_dir_url( __FILE__ ) ); ?>images/optiontag.png" alt="WPC get_option example" />
		<p>Where <code>$option</code> is your field slug, which you can find on the <strong>Fields Management</strong> tab:</p>
		<img src="<?php echo esc_url( plugin_dir_url( __FILE__ ) ); ?>images/slugs.png" alt="WPC Field slugs" />

		<hr />

		<h2>Using in the Editor (Shortcodes)</h2>
		<p>You can use WordPress Custom Settings inside the WordPress block or classic editor via shortcodes.</p>

		<h3>Text, Textarea &amp; HTML Textarea fields</h3>
		<pre><code>[wpc_get_option slug="your_desired_slug"]</code></pre>

		<h3>Upload (Image) fields</h3>
		<pre><code>[wpc_get_option_upload slug="logo-footer" id="responsive" class="responsive" url="google.com"]</code></pre>

		<div class="notice notice-info inline" style="margin-top: 20px;">
			<p><strong>Tip:</strong> Replace <code>your_desired_slug</code> with the actual slug from your Fields Management page.</p>
		</div>
	</div>
</div>
