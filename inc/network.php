<div class="wrap">

	<h1><?php echo $page_info['title']; ?></h1>

	<?php Space_Pages::show_page_tabs( $page_info['slug'], true ); ?>

	<div class="space-page-sidebar space-page-sidebar--lower">
		<div class="space-widget space-widget-empty">
			<input type="submit" class="button-primary space-button-action space-button-large space-button-w100p" data-js-relay=".space-options-save-button" value="<?php _e( 'Save Settings' ); ?>">
			<button class="button-secondary space-options-revert-button space-button-large space-button-w100p"><?php _e( 'Revert to Defaults', 'space' ); ?></button>
		</div>
		<div class="space-widget space-widget-bordered">
			<div class="inside">
				<p>
					Note that these are only network-related options. To manage site specific options, visit the network sites individually.
				</p>
			</div>
		</div>
	</div>

	<?php settings_errors(); ?>

	<form method="post" action="edit.php?action=<?php echo esc_attr( Space_Options::$options_slug ); ?>" class="space-page-content space-options-form">

		<input type="hidden" name="<?php echo esc_attr( Space_Options::$options_slug ); ?>[<?php echo 'options-page-identification'; ?>]" value="<?php echo esc_attr( $page_info['slug'] ); ?>">

		<?php ?>
		<?php settings_fields( Space_Options::$options_slug ); ?>

		<?php ?>
		<?php do_settings_sections( $page_info['slug'] ); ?>

		<p class="submit">
			<input type="submit" name="submit" class="button-primary space-options-save-button" value="<?php _e( 'Save Settings' ); ?>">
		</p>

	</form>

</div>
