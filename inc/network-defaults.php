<div class="wrap">

	<h1><?php echo $page_info['title']; ?></h1>

	<?php Space_Pages::show_page_tabs( $page_info['slug'], true ); ?>

	<div class="space-page-sidebar space-page-sidebar--lower">

		<?php ?>
		<div class="space-widget space-widget-empty">
			<input type="submit" class="button-primary space-button-action space-button-large space-button-w100p" data-js-relay=".space-options-save-button" value="<?php _e( 'Save Settings' ); ?>">
			<button class="button-secondary space-options-revert-button space-button-large space-button-w100p"><?php _e( 'Revert to Defaults', 'space' ); ?></button>
		</div>

		<?php ?>
		<div class="space-widget space-widget-bordered">
			<div class="inside">
				<p>
					<?php _e( 'These settings will be used as defaults when creating a new site in this network.', 'space' ); ?>
				</p>
			</div>
		</div>

		<?php ?>
		<div class="space-widget space-widget-empty">
			<div class="inside">
				<?php _e( 'Index', 'space' ); ?>
				<ul class="space-page-index-list">
					<?php foreach ( Space_Options::get_options_sections() as $section_slug => $section_info ) { ?>
						<?php if ( $section_info['page'] == 'space-options-general' ) { ?>
							<li><a href="#<?php echo esc_attr( $section_slug ); ?>" data-scrollto><?php echo $section_info['title']; ?></a></li>
						<?php } ?>
					<?php } ?>
				</ul>
			</div>
		</div>

	</div>

	<?php settings_errors(); ?>

	<form method="post" action="edit.php?action=<?php echo Space_Options::$options_slug; ?>" class="space-page-content space-options-form">

		<input type="hidden" name="<?php echo Space_Options::$options_slug; ?>[<?php echo 'options-page-identification'; ?>]" value="<?php echo $page_info['slug']; ?>">

		<?php ?>
		<?php settings_fields( Space_Options::$options_slug ); ?>

		<?php ?>
		<?php if ( $page_info['slug'] == 'space-options-network-site-defaults' ) { ?>
			<?php do_settings_sections( 'space-options-general' ); ?>
		<?php } ?>
		<?php if ( $page_info['slug'] == 'space-options-network-widget-defaults' ) { ?>
			<?php do_settings_sections( 'space-admin-widget-manager' ); ?>
		<?php } ?>
		<?php if ( $page_info['slug'] == 'space-options-network-column-defaults' ) { ?>
			<?php do_settings_sections( 'space-admin-column-manager' ); ?>
		<?php } ?>

		<p class="submit">
			<input type="submit" name="submit" class="button-primary space-options-save-button" value="<?php _e( 'Save Settings' ); ?>">
		</p>

	</form>

</div>
