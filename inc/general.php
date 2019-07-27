<div class="wrap">

	<h1><?php echo $page_info['title']; ?></h1>

<div id="poststuff">

		<div id="post-body" class="metabox-holder columns-2">

			<!-- main content -->
			<div id="post-body-content">

				<div class="meta-box-sortables ui-sortable">

					<div class="postbox">
						<div class="inside"><br>
							<?php settings_errors(); ?>

	<form method="post" action="options.php" class="space-page-content space-options-form">

		<input type="hidden" name="<?php echo Space_Options::$options_slug; ?>[<?php echo 'options-page-identification'; ?>]" value="<?php echo $page_info['slug']; ?>">

		<?php // Prepare options ?>
		<?php settings_fields( Space_Options::$options_slug ); ?>

		<?php // Show this page's option sections & fields ?>
		<?php do_settings_sections( $page_info['slug'] ); ?>

		<p class="submit">
			<input type="submit" name="submit" class="button-primary space-options-save-button" value="<?php _e( 'Save Settings' ); ?>">
		</p>

	</form>
						</div>
						<!-- .inside -->

					</div>
					<!-- .postbox -->

				</div>
				<!-- .meta-box-sortables .ui-sortable -->

			</div>
			<!-- post-body-content -->

			<!-- sidebar -->
			<div id="postbox-container-1" class="postbox-container">

				<div class="meta-box-sortables">					
<div class="postbox">

						<h2><span><?php esc_attr_e(
									'Menu Editor', 'WpAdminStyle'
								); ?></span></h2>

			<div class="inside">
<p>With <a href="tools.php?page=space-admin-menu-editor">Menu Editor</a> you can rearange admin menu items or remove them completely.</p>
			</div>
						<!-- .inside -->
					</div>
					<!-- .postbox -->					
<div class="postbox">

						<h2><span><?php esc_attr_e(
									'Widget Editor', 'WpAdminStyle'
								); ?></span></h2>

			<div class="inside">
<p>With <a href="tools.php?page=space-admin-widget-manager">Widget Editor</a> you choose which widgets should be available to which users.</p>
			</div>
						<!-- .inside -->
					</div>
					<!-- .postbox -->
					
<div class="postbox">

						<h2><span><?php esc_attr_e(
									'Column Editor', 'WpAdminStyle'
								); ?></span></h2>

			<div class="inside">
<p>With <a href="tools.php?page=space-admin-column-manager">Column Editor</a> you can assign columns per each page on the wp-admin dashboard.</p>
			</div>
						<!-- .inside -->
					</div>
					<!-- .postbox -->
<div class="postbox">

						<h2><span><?php esc_attr_e(
									'Update notifications', 'WpAdminStyle'
								); ?></span></h2>
<hr>
			<div class="inside">
	<form name="fm_dwun" method="POST">
		<table class="fm-content">
		<tbody>
			<tr class="mlw-box-left">
			    <th scope="row">
			        <label for="dwtu">Theme</label>
			    </th>
			    <td>
                                 <label class="switch">
                                <input class="switch-input" name="dwtu" type="checkbox" <?php if (get_option("dwtu_setting") == "on") {
			echo "checked"; } ?>/>
                                <span class="switch-label" data-on="DISABLE" data-off="ENABLE"></span>
                                <span class="switch-handle"></span>
                            </label>
			        
			    </td>
			</tr>
			<tr>
			<th scope="row">
			    <label for="dpun">Plugins</label>
			</th>
			<td>
			    <label class="switch">
                                <input class="switch-input" name="dpun" type="checkbox" <?php if (get_option("dpun_setting") == "on") {
			echo "checked"; } ?>/>
                                <span class="switch-label" data-on="DISABLE" data-off="ENABLE"></span>
                                <span class="switch-handle"></span>
                            </label>
			</td>
			</tr>
			
			<tr>
			    <th scope="row">
			        <label for="dwcun">Core</label>
			    </th>
			    <td>
                                <label class="switch">
                                <input class="switch-input" name="dwcun" type="checkbox" <?php if (get_option("dwcun_setting") == "on") {
			echo "checked"; } ?>/>
                                <span class="switch-label" data-on="DISABLE" data-off="ENABLE"></span>
                                <span class="switch-handle"></span>
                            </label>			        
			    </td>
			</tr>
		</tbody>
		</table>
		<input type="submit" name="publish" id="publish" class="button button-primary" value="Save Changes">
	</form>

<?php
?>
</div>
						<!-- .inside -->
					</div>
					<!-- .postbox -->					
<div class="postbox">

						<h2><span><?php esc_attr_e(
									'Leave a Review', 'WpAdminStyle'
								); ?></span></h2>

			<div class="inside" style="padding: 10px;">
				<a href="https://wordpress.org/support/plugin/space-admin-theme/reviews/?filter=5" target="_blank"><img src="https://pluginsbay.com/wp-content/uploads/2019/07/5-star-review.png" alt="Leave a Review on WordPress.org" width="150px" style="align:center;"></a>
				<p>
					If you like Space Admin Theme please consider <a href="https://wordpress.org/support/plugin/space-admin-theme/reviews/?filter=5" target="_blank">leaving a review on WordPres.org</a>.
				</p>
			</div>
						<!-- .inside -->

					</div>
					<!-- .postbox -->

				</div>

			</div>
			<!-- #postbox-container-1 .postbox-container -->

		</div>
		<!-- #post-body .metabox-holder .columns-2 -->

		<br class="clear">
	</div>
	<!-- #poststuff -->

</div>
