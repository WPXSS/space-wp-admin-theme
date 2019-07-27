<div class="wrap">

	<h1><?php echo $page_info['title']; ?></h1>
<div id="poststuff">

		<div id="post-body" class="metabox-holder columns-2">

			<!-- main content -->
			<div id="post-body-content">

				<div class="meta-box-sortables ui-sortable">

					<div class="postbox"><br><br>
						<div class="inside">
							<?php settings_errors(); ?>

		<form method="post" action="options.php" class="space-admin-column-manager-form">

			<input type="hidden" name="<?php echo Space_Options::$options_slug; ?>[<?php echo 'options-page-identification'; ?>]" value="<?php echo $page_info['slug']; ?>">

			<?php ?>
			<?php settings_fields( Space_Options::$options_slug ); ?>

			<?php ?>
			<?php do_settings_sections( $page_info['slug'] ); ?>

			<p class="submit">
				<input type="submit" class="button-primary space-button-action space-admin-column-save-button" value="<?php _e( 'Save Settings' ); ?>">
				<?php if ( ! is_multisite() || is_super_admin() ) { ?>
					<button class="button-secondary space-admin-column-revert-button"><?php _e( 'Reset All', 'space' ); ?></button>
				<?php } ?>
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
									'About', 'WpAdminStyle'
								); ?></span></h2>

						<div class="inside">
							<div class="inside">
			<p>Here you can enable or disable columns on your site or accross all the sites on the network.</p>
				<ul class="space-page-index-list">
					<?php foreach ( Space_Admin_Column_Manager::get_column_info() as $page_slug => $columns ) { ?>
						<li><br><a href="#space-admin-columns-<?php echo esc_attr( $page_slug ); ?>" data-scrollto><?php echo Space_Admin_Column_Manager::get_page_name( $page_slug ); ?></a></li>
					<?php } ?>
				</ul>
				<input type="submit" class="button-primary space-button-action space-button-large space-button-w100p" data-js-relay=".space-admin-column-save-button" value="<?php _e( 'Save Settings' ); ?>">
			<?php if ( ! is_multisite() || is_super_admin() ) { ?>
				<button class="button-secondary space-admin-column-revert-button space-button-large space-button-w100p"><?php _e( 'Reset All', 'space' ); ?></button>
			<?php } ?>
			</div>
						</div>
						<!-- .inside -->

					</div>
					<!-- .postbox -->

				</div>
				<!-- .meta-box-sortables -->

			</div>
			<!-- #postbox-container-1 .postbox-container -->

		</div>
		<!-- #post-body .metabox-holder .columns-2 -->

		<br class="clear">
	</div>
	<!-- #poststuff -->	

</div>
