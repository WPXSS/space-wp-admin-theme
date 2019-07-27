<?php
/*
 * Space Setup class
 * Contains functions to integrate itself into the WordPress installation
 */

class Space_Setup {

	static $editor_font_family = 'Lato:400,400:i';
	static $admin_font_family = 'Lato:400,400:i';

	// Enqueue admin stylesheets
	static function action_enqueue_admin_styles() {

		// Always-use CSS
		wp_enqueue_style( 'space-admin-css', plugins_url( 'css/style.css', __FILE__ ), array(), null );

		// Enqueue the media manager scripts and styles (only when on the Space general options page)
		$screen = get_current_screen();
		if ( in_array( $screen->id, array(
			'appearance_page_space-options-general',
			'themes_page_space-options-network-site-defaults-network'
		) ) ) {
			wp_enqueue_media();
		}

		// When admin theming is enabled...
		if ( Space::is_themed() ) {

			// Theme CSS
			wp_enqueue_style( 'space-theme-css', plugins_url( 'css/admin-theme.min.css', __FILE__ ), array( 'space-admin-css', 'thickbox' ), null );

			

		}

	}

	// Enqueue admin scripts
	static function action_enqueue_admin_scripts() {

		// Gather conditional dependencies
		$dependencies = array(
			'jquery',
			'thickbox',
			'jquery-ui-sortable'
		);

		// Space theme JS
		wp_enqueue_script( 'space-admin-js', plugins_url( 'js/space-admin.js', __FILE__ ), $dependencies, '1.0.5' );

		// Add localized strings
		wp_localize_script( 'space-admin-js', 'space', array(
			'L10n' => array(
				// Source: navMenuL10n
				'saveAlert' => __( 'The changes you made will be lost if you navigate away from this page.' ),
				'untitled' => _x( '(no label)', 'missing menu item navigation label' ),
				// Custom:
				'backToTop' => _x( 'Back to top', 'Title attribute for the Back to top button.', 'space' ),
				'revertConfirm' => _x( 'Are you sure you want to remove all customizations and start from scratch?', 'Confirmation message when reverting the Admin Menu Editor to default.', 'space' ),
				'screenOptions' => __( 'Screen Options' ),
				'help' => __( 'Help' ),
				'exportLoading' => __( 'Loading...', 'space' )
			),
			// Non-translation variables
			'options_slug' => Space_Options::$options_slug,
			'isMobile' => wp_is_mobile() ? 1 : '',
			'themeEnabled' => Space::is_themed() ? 1 : '',
			'spaceEnabled' => Space::is_enabled() ? 1 : '',
			'tableRowCollapse' => Space_Options::get_saved_option( 'post-table-collapse' ) ? 1 : '',
			'metaboxCloseEnabled' => Space_Options::get_saved_option( 'enable-metabox-close-button' ) ? 1 : ''
		) );

	}

	// Enqueue login/register page stylesheet
	static function action_enqueue_login_styles() {

		// Only if login page theming is enabled
		if ( Space::is_themed() ) {
			wp_enqueue_style( 'space-login-css', plugins_url( 'css/login.min.css', __FILE__ ), array(), null );
		}

	}

	// Enqueue login/register page scripts
	static function action_enqueue_login_scripts() {

		// Only if login page theming is enabled
		if ( Space::is_themed() ) {
			wp_enqueue_script( 'space-login-js', plugins_url( 'js/space-login.js', __FILE__ ), array( 'jquery' ), '1.0.5' );
		}

	}

	// Enqueue text editor CSS
	static function action_enqueue_editor_styles() {

		// Only if the option is enabled
		if ( ! Space_Options::get_saved_option( 'enable-editor-styling' ) ) {
			return;
		}

		
		// Load the Google Fonts, unless Google Fonts are disabled
		if ( ! Space_Options::get_saved_option( 'disable-google-fonts-admin' ) ) {
			add_editor_style( str_replace( ',', '%2C', 'https://fonts.googleapis.com/css?family=' . self::$editor_font_family ) );
		}

	}

	// Deactivate the default Google Fonts version of Open Sans while viewing the site
	static function action_dequeue_fonts() {

		wp_deregister_style( 'open-sans' );
		wp_register_style( 'open-sans', false );

	}

	// Dequeue and enqueue Google Fonts in the admin area
	static function action_enqueue_admin_fonts() {

		// Deactivate the default Google Fonts version of Open Sans
		wp_deregister_style( 'open-sans' );
		wp_register_style( 'open-sans', false );

		// Replace them, unless Google Fonts are disabled
		if ( ! Space_Options::get_saved_option( 'disable-google-fonts-admin' ) ) {
			wp_enqueue_style( 'space-admin-fonts', 'https://fonts.googleapis.com/css?family=' . self::$admin_font_family );
		}

	}

	// Enqueue Google Fonts fonts for the login screen
	static function action_enqueue_login_fonts() {
		wp_enqueue_style( 'space-login-fonts', 'https://fonts.googleapis.com/css?family=' . self::$admin_font_family );
	}

	// Add plugin options link to the plugin entry in the plugin list
	static function filter_add_plugin_options_link( $links, $file ) {

		// Check that this is the right plugin entry
		$plugin_base_file = dirname( plugin_basename( __FILE__ ) ) . '/index.php';
		if ( $file != $plugin_base_file ) {
			return $links;
		}

		// Check that this user is allowed to manage the settings
		if ( ! Space_User::is_admin() ) {
			return $links;
		}

		// Generate link
		$settings_link = '<a href="' . Space_Pages::get_page_url( 'space-options-general' ) . '">' . __( 'Settings' ) . '</a>';

		// Add to links array
		array_unshift( $links, $settings_link );

		// Return links array
		return $links;

	}

	// Add CSS classes to the page's <body> tag
	static function filter_add_body_classes( $body_classes ) {

		$new_classes = array();

		// Only when logged in
		if ( ! is_user_logged_in() ) {
			return $body_classes;
		}

		// If viewing the site
		if ( ! is_admin() ) {
			$new_classes[] = 'space-site';
		}

		// If non-mobile (.mobile is added by default)
		if ( ! wp_is_mobile() ) {
			$new_classes[] = 'not-mobile';
		}

		// If theming is enabled
		if ( Space::is_themed() ) {
			$new_classes[] = 'space-theme';
		}

		// Selected admin menu theme
		$new_classes[] = 'space-menu-theme--' . Space_Options::get_saved_option( 'theme-menu' );

		// If posts-per-page is overwritten via the option
		if ( Space_Options::get_saved_option( 'paging-posts' ) ) {
			$new_classes[] = 'space-custom-paging';
		}

		// If hide-top-paging option is enabled
		if ( Space_Options::get_saved_option( 'hide-top-paging' ) ) {
			$new_classes[] = 'space-hide-top-paging';
		}

		// If hide-post-search option is enabled
		if ( Space_Options::get_saved_option( 'hide-post-search' ) ) {
			$new_classes[] = 'space-hide-post-search';
		}

		// If hide-top-bulk option is enabled
		if ( Space_Options::get_saved_option( 'hide-top-bulk' ) ) {
			$new_classes[] = 'space-hide-top-bulk';
		}

		// If hide-user-role-changer
		if ( Space_Options::get_saved_option( 'hide-user-role-changer' ) ) {
			$new_classes[] = 'space-hide-user-role-changer';
		}

		// If hide-view-switch option is enabled
		if ( Space_Options::get_saved_option( 'hide-view-switch' ) ) {
			$new_classes[] = 'space-hide-view-switch';
		}

		// If hide-media-bulk-select option is enabled
		if ( Space_Options::get_saved_option( 'hide-media-bulk-select' ) ) {
			$new_classes[] = 'space-hide-media-bulk-select';
		}

		// If hide-post-list-date-filter option is enabled
		if ( Space_Options::get_saved_option( 'hide-post-list-date-filter' ) ) {
			$new_classes[] = 'space-hide-date-filter';
		}

		// If hide-comment-type-filter option is enabled
		if ( Space_Options::get_saved_option( 'hide-comment-type-filter' ) ) {
			$new_classes[] = 'space-hide-comment-type-filter';
		}

		// If enable-separators option is enabled
		if ( ! is_network_admin() && Space_Options::get_saved_option( 'enable-separators' ) ) {
			$new_classes[] = 'space-show-menu-separators';
		}
		if ( is_network_admin() && Space_Options::get_saved_network_option( 'enable-separators-network' ) ) {
			$new_classes[] = 'space-show-menu-separators';
		}

		// If menu-hover-expand option is enabled (now used for popout bubbles)
		if ( Space_Options::get_saved_option( 'menu-hover-expand' ) && is_admin() ) {
			$new_classes[] = 'space-menu-hover-expand';
		}
		else {
			$new_classes[] = 'space-inline-submenus';
		}

		// If enable-notification-center option is enabled
		if ( Space_Options::get_saved_option( 'enable-notification-center' ) && ! wp_is_mobile() ) {
			$new_classes[] = 'space-notification-center';
		}

		// If post edit addnew option is disabled
		if ( ! Space_Options::get_saved_option( 'admin-widget-manager-addnew' ) ) {
			$new_classes[] = 'space-hide-postedit-addnew';
		}

		// If post edit permalink option is disabled
		if ( ! Space_Options::get_saved_option( 'admin-widget-manager-permalink' ) ) {
			$new_classes[] = 'space-hide-permalink';
		}

		// If post edit media-button option is disabled
		if ( ! Space_Options::get_saved_option( 'admin-widget-manager-media-button' ) ) {
			$new_classes[] = 'space-hide-media-button';
		}

		// Post-table-collapse option
		if ( Space_Options::get_saved_option( 'post-table-collapse' ) ) {
			$new_classes[] = 'space-post-table-collapse';
		}

		// Menu counters option
		if ( Space_Options::get_saved_option( 'enable-menu-counters' ) ) {
			$new_classes[] = 'space-show-menu-counters';
		}

		// Menu default collapse option
		if ( Space_Options::get_saved_option( 'menu-always-collapsed' ) ) {
			$new_classes[] = 'space-menu-collapsed-default';
		}
		else {
			$new_classes[] = 'space-menu-not-collapsed-default';
		}

		// Add role-specific classes
		if ( is_admin() ) {
			$all_roles = Space_User::get_all_roles( true );
			$user_roles = Space_User::get_user_role( 0, 'multiple' );
			foreach ( $all_roles as $role_slug => $role_details ) {
				if ( in_array( $role_slug, $user_roles ) ) {
					$new_classes[] = 'role-' . $role_slug;
				}
				else {
					$new_classes[] = 'not-role-' . $role_slug;
				}
			}
		}

		// Merge & return
		if ( is_array( $body_classes ) ) {
			return array_merge( $body_classes, $new_classes );
		}
		return $body_classes . ' ' . implode( ' ', $new_classes ) . ' ';

	}

	// Remove plugin settings when uninstalling Space
	static function action_uninstall() {
		delete_option( Space_Options::$options_slug );
		delete_option( Space_Options::$network_default_options_slug );
	}

	// Tells WP where to find language files
	static function action_prepare_translations() {
		load_plugin_textdomain( 'space', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	}

	// Hide Space from plugin list depending on network option
	static function filter_trim_plugin_list( $plugins ) {

		if ( is_multisite() && ! is_super_admin() && Space_Options::get_saved_network_option( 'hide-plugin-entry' ) ) {
			unset( $plugins['Space/index.php'] );
		}

		// Return
		return $plugins;

	}

	// Make sure post table date columns have a <abbr> tag for styling and appear in date format from settings
	static function filter_post_table_date_format( $t_time, $post, $column_name = '', $mode = '' ) {

		// If the date format is the default Y/m/d, change it to the date format from the WP settings (not if it's in "1 minute ago" format)
		$t_time = is_numeric( strpos( $t_time, '/' ) ) ? get_the_date() : $t_time;

		// Post table in excerpt mode should have <abbr>
		if ( Space_Options::get_saved_option( 'post-table-collapse' ) ) {
			if ( $mode === 'excerpt' ) {
				$t_time = '<abbr title="' . $t_time . '">' . $t_time . '</abbr>';
			}
		}

		// Return
		return $t_time;

	}

}
?>
