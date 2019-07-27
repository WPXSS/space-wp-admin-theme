<div class="wrap">

	<h1><?php echo $page_info['title']; ?></h1>
<div id="poststuff">

		<div id="post-body" class="metabox-holder columns-2">

			<!-- main content -->
			<div id="post-body-content">


					<div class="postbox">

						<div class="inside">
							<?php settings_errors(); ?>

		<form method="post" action="options.php" class="space-admin-widget-manager-form">
<br>
			<input type="hidden" name="<?php echo Space_Options::$options_slug; ?>[<?php echo 'options-page-identification'; ?>]" value="<?php echo $page_info['slug']; ?>">

			<?php ?>
			<?php settings_fields( Space_Options::$options_slug ); ?>

			<?php ?>
			<?php do_settings_sections( $page_info['slug'] ); ?>

			<p class="submit">
				<input type="submit" class="button-primary space-button-action space-admin-widget-save-button" value="<?php _e( 'Save Settings' ); ?>">
				<?php if ( ! is_multisite() || is_super_admin() ) { ?>
					<button class="button-secondary space-admin-widget-revert-button"><?php _e( 'Reset All', 'space' ); ?></button>
				<?php } ?>
			</p>

		</form>
						</div>
						<!-- .inside -->

					</div>
					<!-- .postbox -->

				<!-- .meta-box-sortables .ui-sortable -->

			</div>
			<!-- post-body-content -->

			<!-- sidebar -->
			<div id="postbox-container-1" class="postbox-container">

				<div class="meta-box-sortables">

					<div class="postbox">

						<h2><span><?php esc_attr_e(
									'Content ', 'WpAdminStyle'
								); ?></span></h2>

						<div class="inside">
						<ul class="space-page-index-list">
					<?php foreach ( Space_Admin_Widget_Manager::get_widget_info() as $page_slug => $widgets ) { ?>
						<li><a href="#space-admin-widgets-<?php echo esc_attr( $page_slug ); ?>" data-scrollto><?php echo Space_Admin_Widget_Manager::get_page_name( $page_slug ); ?></a></li>
					<?php } ?>
						</ul>
						<p>Here you can enable or disable widgets on your site or accross all the sites on the network.</p>
				<input type="submit" class="button-primary space-button-action space-button-large space-button-w100p" data-js-relay=".space-admin-widget-save-button" value="<?php _e( 'Save Settings' ); ?>">
			<?php if ( ! is_multisite() || is_super_admin() ) { ?>
				<button class="button-secondary space-admin-widget-revert-button space-button-large space-button-w100p"><?php _e( 'Revert to Defaults', 'space' ); ?></button>
			<?php } ?>
						</div>
						<!-- .inside -->

					</div>
					<!-- UPGRADE
					<div class="postbox">

						<h2><span><?php esc_attr_e(
									'More options', 'WpAdminStyle'
								); ?></span></h2>

						<div class="inside">
						<p>If you would like to enable/disable widgets per user role, please consider getting the <a href="https://checkout.freemius.com/mode/dialog/plugin/1273/plan/6771/licenses/1/">pro version for only $7.50</a>.</p>
						</div>

					</div> -->
				</div>
				<!-- .meta-box-sortables -->

			</div>
			<!-- #postbox-container-1 .postbox-container -->

		</div>
		<!-- #post-body .metabox-holder .columns-2 -->

</div>
