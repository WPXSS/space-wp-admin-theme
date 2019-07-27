<div class="wrap">

	<h1><?php echo $page_info['title']; ?></h1>

	<div class="space-page-content">

		<?php settings_errors(); ?>

		<?php ?>
		<?php Space_Admin_Menu_Editor::print_menu_editor(); ?>

		<?php ?>
		<form method="post" action="options.php" class="space-admin-menu-editor-form">

			<input type="hidden" name="<?php echo Space_Options::$options_slug; ?>[<?php echo 'options-page-identification'; ?>]" value="<?php echo $page_info['slug']; ?>">

			<?php ?>
			<?php settings_fields( Space_Options::$options_slug ); ?>

			<?php ?>
			<?php do_settings_sections( $page_info['slug'] ); ?>

			<p class="submit">
				<input type="submit" name="submit" class="button-primary space-button-action space-admin-menu-save-button" value="<?php _e( 'Save Settings' ); ?>">
				<?php if ( ! is_multisite() || is_super_admin() ) { ?>
					<button class="button-secondary space-admin-menu-revert-button"><?php _e( 'Reset All', 'space' ); ?></button>
				<?php } ?>
			</p>

		</form>

	</div>

</div>
