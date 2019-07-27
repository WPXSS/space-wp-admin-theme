<?php
/*
 * pgs
 */

class Space_Pages {
	static function get_pages( $page_slug = '' ) {

		$pages = array();

		$default_args = array(
			'menu-title' => '',
			'tab-title' => '',
			'parent' => 'themes.php',
			'in-menu' => false,
			'has-tab' => false,
			'tab-side' => false,
			'network' => false
		);

		$pages['space-options-general'] = array_merge(
			$default_args,
			array(
				'slug' => 'space-options-general',
				'menu-title' => _x( '🚀 Admin Theme', 'Page title in the menu', 'space' ),
				'title' => _x( 'Space Admin Theme', 'Option page title', 'space' ),
				'callback' => array( __CLASS__, 'display_general_options_page' ),
				'in-menu' => true
			)
		);

		$pages['space-options-network'] = array_merge(
			$default_args,
			array(
				'slug' => 'space-options-network',
				'menu-title' => _x( '🚀 Admin Theme', 'Page title in the menu', 'space' ),
				'title' => _x( 'Space Admin Theme | Network Options', 'Option page title', 'space' ),
				'callback' => array( __CLASS__, 'display_network_options_page' ),
				'in-menu' => true,
				'has-tab' => true,
				'network' => true
			)
		);

		$pages['space-options-network-site-defaults'] = array_merge(
			$default_args,
			array(
				'slug' => 'space-options-network-site-defaults',
				'title' => _x( '🚀 Network Site Defaults', 'Option page title', 'space' ),
				'callback' => array( __CLASS__, 'display_network_options_site_defaults_page' ),
				'network' => true
			)
		);

		//if ( ! Space_Options::get_saved_network_option( 'disable-admin-widget-manager-tool' ) ) {
			$pages['space-options-network-widget-defaults'] = array_merge(
				$default_args,
				array(
					'slug' => 'space-options-network-widget-defaults',
					'title' => _x( '🚀 Widget Manager', 'Option page title', 'space' ),
					'callback' => array( __CLASS__, 'display_network_options_widget_defaults_page' ),
					'network' => true
				)
			);
		//}

		//if ( ! Space_Options::get_saved_network_option( 'disable-admin-column-manager-tool' ) ) {
			$pages['space-options-network-column-defaults'] = array_merge(
				$default_args,
				array(
					'slug' => 'space-options-network-column-defaults',
					'title' => _x( '🚀 Column Manager', 'Option page title', 'space' ),
					'callback' => array( __CLASS__, 'display_network_options_column_defaults_page' ),
					'network' => true
				)
			);
		//}


		if (
			! Space_Options::get_saved_network_option( 'disable-admin-menu-editor-tool' ) ||
			! Space_Options::get_saved_network_option( 'disable-admin-widget-manager-tool' ) ||
			! Space_Options::get_saved_network_option( 'disable-admin-column-manager-tool' )
			) {
			$pages['space-tools'] = array_merge(
				$default_args,
				array(
					'callback' => array( __CLASS__, 'display_tools_page' )
				)
			);
		}

		

		if ( ! Space_Options::get_saved_network_option( 'disable-admin-menu-editor-tool' ) && Space_Options::get_saved_option( 'enable-admin-menu-editor-tool' ) ) {
			$pages['space-admin-menu-editor'] = array_merge(
				$default_args,
				array(
					'slug' => 'space-admin-menu-editor',
					'title' => _x( '🚀 Menu Manager', 'Tool page title', 'space' ),
					'callback' => array( __CLASS__, 'display_admin_menu_editor' ),
					'parent' => 'tools.php',
					'in-menu' => true,
					'has-tab' => false
				)
			);
		}

		if ( ! Space_Options::get_saved_network_option( 'disable-admin-widget-manager-tool' ) && Space_Options::get_saved_option( 'enable-admin-widget-manager-tool' ) ) {
			$pages['space-admin-widget-manager'] = array_merge(
				$default_args,
				array(
					'slug' => 'space-admin-widget-manager',
					'title' => _x( '🚀 Widget Manager', 'Tool page title', 'space' ),
					'callback' => array( __CLASS__, 'display_admin_widget_manager' ),
					'parent' => 'tools.php',
					'in-menu' => true,
					'has-tab' => false
				)
			);
		}

		if ( ! Space_Options::get_saved_network_option( 'disable-admin-column-manager-tool' ) && Space_Options::get_saved_option( 'enable-admin-column-manager-tool' ) ) {
			$pages['space-admin-column-manager'] = array_merge(
				$default_args,
				array(
					'slug' => 'space-admin-column-manager',
					'title' => _x( '🚀 Column Manager', 'Tool page title', 'space' ),
					'callback' => array( __CLASS__, 'display_admin_column_manager' ),
					'parent' => 'tools.php',
					'in-menu' => true,
					'has-tab' => false
				)
			);
		}

		if ( $page_slug ) {
			if ( ! isset( $pages[ $page_slug ] ) ) {
				return null;
			}
			return $pages[ $page_slug ];
		}
		return $pages;

	}

	static function display_general_options_page() {
		$page_info = self::get_pages( 'space-options-general' );
		include( plugin_dir_path( __FILE__ ) . 'inc/general.php' );
	}

	static function display_network_options_page() {
		$page_info = self::get_pages( 'space-options-network' );
		include( plugin_dir_path( __FILE__ ) . 'inc/network.php' );
	}

	static function display_network_options_site_defaults_page() {
		$page_info = self::get_pages( 'space-options-network-site-defaults' );
		include( plugin_dir_path( __FILE__ ) . 'inc/network-defaults.php' );
	}

	static function display_network_options_widget_defaults_page() {
		$page_info = self::get_pages( 'space-options-network-widget-defaults' );
		include( plugin_dir_path( __FILE__ ) . 'inc/network-defaults.php' );
	}

	static function display_network_options_column_defaults_page() {
		$page_info = self::get_pages( 'space-options-network-column-defaults' );
		include( plugin_dir_path( __FILE__ ) . 'inc/network-defaults.php' );
	}
	
	static function display_admin_menu_editor() {
		$page_info = self::get_pages( 'space-admin-menu-editor' );
		include( plugin_dir_path( __FILE__ ) . 'inc/menus.php' );
	}

	static function display_admin_widget_manager() {
		$page_info = self::get_pages( 'space-admin-widget-manager' );
		include( plugin_dir_path( __FILE__ ) . 'inc/widgets.php' );
	}

	static function display_admin_column_manager() {
		$page_info = self::get_pages( 'space-admin-column-manager' );
		include( plugin_dir_path( __FILE__ ) . 'inc/columns.php' );
	}


	static function get_page_url( $page_slug = '', $params = array() ) {
		$page_info = self::get_pages( $page_slug );
		if ( is_null( $page_info ) ) {
			return '';
		}

		$querystring = '';
		if ( count( $params ) ) {
			foreach ( $params as $key => $value ) {
				$querystring .= '&' . $key . '=' . $value;
			}
		}

		if ( $page_info['network'] ) {
			$url = network_admin_url( $page_info['parent'] . '?page=' . $page_info['slug'] . $querystring );
		}

		else {
			$url = admin_url( $page_info['parent'] . '?page=' . $page_info['slug'] . $querystring );
		}

		return $url;

	}

}
?>
