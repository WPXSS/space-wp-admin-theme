<?php
class Space {
/*
* LOGIN
*/
	// Change from wp.org to your site
	static function filter_change_login_logo_link( $original ) {
		return home_url();
	}

	// set title alt to your site
	static function filter_change_login_logo_title( $original ) {
		return get_bloginfo( 'name' );
	}

	// add sustom login logo
	static function action_change_login_logo() {
		// hide logo
		if ( Space_Options::get_saved_option( 'hide-login-logo' ) ) {
			echo '<style>#login > h1 a { display: none !important; }</style>';
		}
		// set bg with css
		else if ( Space_Options::get_saved_option( 'logo-image' ) ) {
			echo '<style>#login > h1 a { background-image: url("' . esc_url( Space_Options::get_saved_option( 'logo-image' ) ) . '") !important; }</style>';
		}

	}
/*
* UPDATES
*/
	
	// all good
	static function filter_prevent_updates() {

		global $wp_version;
		// return
		return (object) array(
			'last_checked' => time(),
			'version_checked' => $wp_version
		);

	}

	// hide updates
	static function action_hide_updates() {
		if ( ! Space_Options::get_saved_option( 'hide-updates' ) ) {
			return;
		}
		// disable checking
		add_filter( 'pre_site_transient_update_core', array( __CLASS__, 'filter_prevent_updates' ) );
		add_filter( 'pre_site_transient_update_plugins', array( __CLASS__, 'filter_prevent_updates' ) );
		add_filter( 'pre_site_transient_update_themes', array( __CLASS__, 'filter_prevent_updates' ) );
		// hide from menu
		add_action( 'admin_menu', array( 'Space_Menu', 'action_remove_update_menu'), 999 );

	}
/*
* HIDE DEFAULTS
*/
	// hide screen options
	static function action_hide_screen_options() {
		if ( Space_Options::get_saved_option( 'hide-screen-options' ) ) {
			add_filter( 'screen_options_show_screen', '__return_false' );
		}

	}

	// hide help btn
	static function action_hide_help() {
		if ( Space_Options::get_saved_option( 'hide-help' ) ) {
			$screen = get_current_screen();
			if ( is_callable( array( $screen, 'remove_help_tabs' ) ) ) {
				$screen->remove_help_tabs();
			}
		}

	}

	// hide login error
	static function filter_login_errors( $errors ) {
		if ( Space_Options::get_saved_option( 'disable-login-errors' ) ) {
			return null;
		}
		// default
		return $errors;

	}


	// is enabled
	static function is_enabled() {
		$bool = Space_Options::get_saved_option( 'enable-space' ) || is_network_admin();
		$bool = apply_filters( 'space-is-enabled', $bool );

		return $bool;

	}

	// Return wether the current page renders the Space theming
	static function is_themed() {

		$bool = false;

		// login
		$is_login_or_register = in_array( $GLOBALS['pagenow'], array( 'wp-login.php', 'wp-register.php' ) );
		if ( $is_login_or_register && Space_Options::get_saved_option( 'enable-login-theme' ) ) {
			$bool = true;
		}

		// Customizer
		global $wp_customize;
		$is_customizer = isset( $wp_customize ) && is_a( $wp_customize, 'WP_Customize_Manager' );
		if ( $is_customizer && Space_Options::get_saved_option( 'enable-customizer-theme' ) ) {
			$bool = true;
		}

		// Admin area
		if ( ! $is_login_or_register && ! $is_customizer && is_admin() && Space_Options::get_saved_option( 'enable-admin-theme' ) ) {
			$bool = true;
		}

		// Top-bar
		if ( ! $is_login_or_register && ! $is_customizer && ! is_admin() && Space_Options::get_saved_option( 'enable-site-toolbar-theme' ) && Space_Options::get_saved_option( 'enable-admin-theme' ) ) {
			$bool = true;
		}

		$bool = apply_filters( 'space-is-themed', $bool );

		return $bool;

	}

}

?>
