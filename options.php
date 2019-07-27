<?php
/*
 * defaults
 */

class Space_Options {

	static $options_slug = 'space_options';
	static $network_default_options_slug = 'space_options_network_site_defaults';
	static $saved_options = array();
	static $saved_options_with_user_metas = array();
	static $saved_network_options = array();
	static $saved_network_options_with_user_metas = array();
	static $network_default_pages = array(
		'space-options-network-site-defaults' => 'space-options-general',
		'space-options-network-widget-defaults' => 'space-admin-widget-manager',
		'space-options-network-column-defaults' => 'space-admin-column-manager',
	);

	static function get_options_sections( $section_slug = '' ) {

		$options_sections = array(

			// 1
			'space-section-general' => array(
				'title' => _x( '<br>🚀 General Settings', 'Option section name', 'space' ),
				'page' => 'space-options-general',
				'options' => array(
					'enable-space',
					'enable-admin-theme',
					'enable-editor-styling',
					'hide-updates',
				)
			),

			

			// 2
			'space-section-login' => array(
				'slug' => 'space-section-login',
				'title' => _x( '<br>🚀 Login Page', 'Option section name', 'space' ),
				'page' => 'space-options-general',
				'options' => array(
					'enable-login-theme',
					'logo-image',
					'hide-login-logo',
				)
			),

			// 3
			'space-section-menu' => array(
				'slug' => 'space-section-menu',
				'title' => _x( '<br>🚀 Admin Menu', 'Option section name', 'space' ),
				'page' => 'space-options-general',
				'options' => array(
					'hide-menu-logo',
					'menu-logo-image',
					'always-show-view-site',
				)
			),

			// 4
			'space-section-toolbar' => array(
				'slug' => 'space-section-toolbar',
				'title' => _x( '<br>🚀 Toolbar', 'Option section name', 'space' ),
				'page' => 'space-options-general',
				'options' => array(
					'hide-front-admin-toolbar',
					'admin-dashboard-title',
					'enable-site-toolbar-theme',
					'hide-toolbar-view-posts',
					'hide-toolbar-new',
					'hide-toolbar-comments',
					'hide-toolbar-updates',
					'hide-toolbar-search',
					'hide-toolbar-customize',
					'hide-toolbar-mysites'
					//'hide-toolbar-user'
				)
			),

			

			

			// 4
			'space-section-network' => array(
				'slug' => 'space-section-network',
				'title' => _x( '🚀 Network Options', 'Option section name', 'space' ),
				'page' => 'space-options-network',
				'options' => array(
					'network-admins-only',
					'hide-plugin-entry',
					'network-hide-importexport',
				)
			),

			// 5
			'space-section-network-site-defaults' => array(
				'slug' => 'space-section-network-site-defaults',
				'title' => '',
				'page' => 'space-options-network-site-defaults',
				'options' => array()
			),

			// 6
			'space-admin-menu-editor' => array(
				'slug' => 'space-admin-menu-editor',
				'title' => __( 'Menu Editor', 'space' ),
				'page' => 'space-admin-menu-editor',
				'options' => array(
					'admin-menu'
				)
			),

		

		);

		if ( self::get_saved_network_option( 'disable-admin-menu-editor-tool' ) ) {
			unset( $options_sections['space-section-tools']['options']['admin-menu-editor'] );
		}
		if ( self::get_saved_network_option( 'disable-admin-widget-manager-tool' ) ) {
			unset( $options_sections['space-section-tools']['options']['admin-widget-manager'] );
		}
		if ( self::get_saved_network_option( 'disable-admin-column-manager-tool' ) ) {
			unset( $options_sections['space-section-tools']['options']['admin-column-manager'] );
		}
		

		// widgets
		foreach ( Space_Admin_Widget_Manager::get_widget_info() as $page_slug => $widgets ) {
			$options_sections[ 'space-admin-widgets-' . $page_slug ] = array(
				'slug' => 'space-admin-widgets-' . $page_slug,
				'title' => Space_Admin_Widget_Manager::get_page_name( $page_slug ),
				'page' => 'space-admin-widget-manager',
				'options' => Space_Admin_Widget_Manager::get_widget_slugs( $page_slug, 'admin-widget-manager-' )
			);
		}

		// columns
		foreach ( Space_Admin_Column_Manager::get_column_info() as $page_slug => $columns ) {
			$options_sections[ 'space-admin-columns-' . $page_slug ] = array(
				'slug' => 'space-admin-columns-' . $page_slug,
				'title' => Space_Admin_Column_Manager::get_page_name( $page_slug ),
				'page' => 'space-admin-column-manager',
				'options' => Space_Admin_Column_Manager::get_column_slugs( $page_slug, 'admin-column-manager-' . $page_slug . '-' )
			);
		}

		if ( $section_slug && isset( $options_sections[ $section_slug ] ) ) {
			return $options_sections[ $section_slug ];
		}
		return $options_sections;

	}

	static function get_option_info( $option_slug = '' ) {

		$options = array();

		// dflt
		$default_args = array(
			'secondary-title' => '',
			'type' => 'text',
			'help' => '',
			'options' => array(),
			'role-based' => false,
			'disabled-for' => array(),
			'default' => null,
			'user-meta' => '',
			'capability' => ''
		);

		$options['admin-dashboard-title'] = array_merge(
			$default_args,
			array(
				'name' => 'admin-dashboard-title',
				'title' => _x( 'Dashboard Button text', 'Option title', 'space' ),
				'default' => _x( 'Dashboard', 'Toolbar button text', 'space' )
			)
		);

		$options['enable-space'] = array_merge(
			$default_args,
			array(
				'name' => 'enable-space',
				'title' => _x( 'Enable Plugin', 'Option title', 'space' ),
				'secondary-title' => __( 'Enable Space Admin Theme functionality', 'space' ),
				'type' => 'checkbox',
				'default' => 1,
				'role-based' => false
			)
		);

		$options['enable-admin-theme'] = array_merge(
			$default_args,
			array(
				'name' => 'enable-admin-theme',
				'title' => _x( 'Enable Styling', 'Option title', 'space' ),
				'secondary-title' => __( 'Replace default theme with Space Admin Theme', 'space' ),
				'type' => 'checkbox',
				'default' => 1,
				'role-based' => false
			)
		);


		$options['enable-metabox-close-button'] = array_merge(
			$default_args,
			array(
				'name' => 'enable-metabox-close-button',
				'title' => _x( 'Enable Metabox Close Buttons', 'Option title', 'space' ),
				'secondary-title' => __( 'Enable', 'space' ),
				'type' => 'checkbox',
				'role-based' => false,
				'default' => 0,
				)
		);


		$options['hide-updates'] = array_merge(
			$default_args,
			array(
				'name' => 'hide-updates',
				'title' => _x( 'Updates', 'Option title', 'space' ),
				'secondary-title' => __( 'Disable all update notifications', 'space' ),
				'type' => 'checkbox',
				'default' => array(
					'space-default' => 0,
					'super' => 0,
					'administrator' => 0,
					'editor' => 0,
					'author' => 1,
					'contributor' => 1,
					'subscriber' => 1
				),
				'role-based' => false
			)
		);

		$options['hide-front-admin-toolbar'] = array_merge(
			$default_args,
			array(
				'name' => 'hide-front-admin-toolbar',
				'title' => _x( 'Disable', 'Option title', 'space' ),
				'secondary-title' => __( 'Hide Toolbar from the front-end', 'space' ),
				'type' => 'checkbox',
				'default' => 0,
				'role-based' => false
			)
		);

		$options['enable-notification-center'] = array_merge(
			$default_args,
			array(
				'name' => 'enable-notification-center',
				'title' => _x( 'Enable Notification Center', 'Option title', 'space' ),
				'secondary-title' => __( 'Enable', 'space' ),
				'type' => 'checkbox',
				'default' => 0
			)
		);

		$options['hide-toolbar-view-posts'] = array_merge(
			$default_args,
			array(
				'name' => 'hide-toolbar-view-posts',
				'title' => _x( 'Hide View Posts', 'Option title', 'space' ),
				'secondary-title' => __( 'Hide "View Posts" from the toolbar', 'space' ),
				'type' => 'checkbox',
				'default' => 0,
				'role-based' => false
			)
		);

		$options['hide-toolbar-new'] = array_merge(
			$default_args,
			array(
				'name' => 'hide-toolbar-new',
				'title' => _x( 'Hide New', 'Option title', 'space' ),
				'secondary-title' => __( 'Hide "New" dropdown from the toolbar', 'space' ),
				'type' => 'checkbox',
				'default' => 0,
				'role-based' => false
			)
		);

		$options['hide-toolbar-comments'] = array_merge(
			$default_args,
			array(
				'name' => 'hide-toolbar-comments',
				'title' => _x( 'Disable Comments', 'Option title', 'space' ),
				'secondary-title' => __( 'Hide comments from the toolbar', 'space' ),
				'type' => 'checkbox',
				'default' => 0,
				'role-based' => false
			)
		);

		$options['hide-toolbar-updates'] = array_merge(
			$default_args,
			array(
				'name' => 'hide-toolbar-updates',
				'title' => _x( 'Disable Updates', 'Option title', 'space' ),
				'secondary-title' => __( 'Hide updates from the toolbar', 'space' ),
				'type' => 'checkbox',
				'default' => 0,
				'role-based' => false
			)
		);

		$options['hide-toolbar-search'] = array_merge(
			$default_args,
			array(
				'name' => 'hide-toolbar-search',
				'title' => _x( 'Disable Search', 'Option title', 'space' ),
				'secondary-title' => __( 'Hide search field from the toolbar', 'space' ),
				'type' => 'checkbox',
				'default' => 0,
				'role-based' => false
			)
		);

		$options['hide-toolbar-customize'] = array_merge(
			$default_args,
			array(
				'name' => 'hide-toolbar-customize',
				'title' => _x( 'Disable Customize', 'Option title', 'space' ),
				'secondary-title' => __( 'Hide customize button from the toolbar', 'space' ),
				'type' => 'checkbox',
				'default' => 0,
				'role-based' => false
			)
		);

		$options['hide-toolbar-mysites'] = array_merge(
			$default_args,
			array(
				'name' => 'hide-toolbar-mysites',
				'title' => _x( 'Multisite', 'Option title', 'space' ),
				'secondary-title' => __( 'Hide "My Sites" from the toolbar.', 'space' ),
				'type' => 'checkbox',
				'default' => 0,
				'role-based' => false
			)
		);




		$options['enable-login-theme'] = array_merge(
			$default_args,
			array(
				'name' => 'enable-login-theme',
				'title' => _x( 'Enable', 'Option title', 'space' ),
				'secondary-title' => __( 'Enable custom login page', 'space' ),
				'type' => 'checkbox',
				'default' => 1
			)
		);

		$options['enable-site-toolbar-theme'] = array_merge(
			$default_args,
			array(
				'name' => 'enable-site-toolbar-theme',
				'title' => _x( 'Enable Space Toolbar', 'Option title', 'space' ),
				'secondary-title' => __( 'Enable custom toolbar', 'space' ),
				'type' => 'checkbox',
				'default' => 1
			)
		);

		$options['logo-image'] = array_merge(
			$default_args,
			array(
				'name' => 'logo-image',
				'title' => _x( 'Login logo', 'Option title', 'space' ),
				'type' => 'image',
				'default' => ''
			)
		);

		$options['menu-logo-image'] = array_merge(
			$default_args,
			array(
				'name' => 'menu-logo-image',
				'title' => _x( 'Admin Logo image', 'Option title', 'space' ),
				'type' => 'image',
				'default' => 'inherit:logo-image'
			)
		);

		$options['hide-menu-logo'] = array_merge(
			$default_args,
			array(
				'name' => 'hide-menu-logo',
				'title' => _x( 'Custom Logo', 'Option title', 'space' ),
				'secondary-title' => __( 'Hide Admin logo', 'space' ),
				'type' => 'checkbox',
				'default' => 0,
				'role-based' => false
			)
		);

		

		$options['hide-login-logo'] = array_merge(
			$default_args,
			array(
				'name' => 'hide-login-logo',
				'title' => _x( 'Hide logo', 'Option title', 'space' ),
				'secondary-title' => __( 'Disable logo on the login page', 'space' ),
				'type' => 'checkbox',
				'default' => 0
			)
		);


		$options['disable-quick-edit'] = array_merge(
			$default_args,
			array(
				'name' => 'disable-quick-edit',
				'title' => _x( 'Disable Quick Edit', 'Option title', 'space' ),
				'secondary-title' => __( 'Disable for %s', 'space' ),
				'help' => _x( 'Remove the Quick Edit link under each post in post/page listings.', 'Option description', 'space' ),
				'type' => 'checkbox',
				'default' => 0,
				'role-based' => true
			)
		);

		$options['network-admins-only'] = array_merge(
			$default_args,
			array(
				'name' => 'network-admins-only',
				'title' => _x( 'Network Admins Only', 'Option title', 'space' ),
				'secondary-title' => __( 'Make Space only manageable by Network/Super Admins', 'space' ),
				'help' => _x( 'Plugin Options and Space Tools on all network sites will not be editable by site administrators.', 'Option description', 'space' ),
				'type' => 'checkbox',
				'default' => 0,
				'network-option' => true
			)
		);

		$options['hide-plugin-entry'] = array_merge(
			$default_args,
			array(
				'name' => 'hide-plugin-entry',
				'title' => _x( 'Hide Plugin Entry', 'Option title', 'space' ),
				'secondary-title' => __( 'Make site administrators unable to see and deactivate Space', 'space' ),
				'help' => _x( 'Hides Space on individual network site\'s plugin listings for anyone except Network Admins, making Site Admins unable to deactivate the plugin. Note that if Space is network-activated, it will already be hidden from the individual site\'s plugin list.', 'Option description', 'space' ),
				'type' => 'checkbox',
				'default' => 0,
				'network-option' => true
			)
		);


		$options['disable-admin-menu-editor-tool'] = array_merge(
			$default_args,
			array(
				'name' => 'disable-admin-menu-editor-tool',
				'title' => _x( 'Menu Editor', 'Option title', 'space' ),
				'secondary-title' => __( 'Disable menu editor across network', 'space' ),
				'type' => 'checkbox',
				'default' => 0,
				'network-option' => true
			)
		);

		$options['disable-admin-widget-manager-tool'] = array_merge(
			$default_args,
			array(
				'name' => 'disable-admin-widget-manager-tool',
				'title' => _x( 'Widget Manager', 'Option title', 'space' ),
				'secondary-title' => __( 'Disable widget manager across network', 'space' ),
				'type' => 'checkbox',
				'default' => 0,
				'network-option' => true
			)
		);

		$options['disable-admin-column-manager-tool'] = array_merge(
			$default_args,
			array(
				'name' => 'disable-admin-column-manager-tool',
				'title' => _x( 'Column Manager', 'Option title', 'space' ),
				'secondary-title' => __( 'Disable column manager across network', 'space' ),
				'type' => 'checkbox',
				'default' => 0,
				'network-option' => true
			)
		);

		$options['enable-admin-menu-editor-tool'] = array_merge(
			$default_args,
			array(
				'name' => 'enable-admin-menu-editor-tool',
				'title' => _x( 'Menu Editor', 'Option title', 'space' ),
				'secondary-title' => __( 'Enable', 'space' ),
				'type' => 'checkbox',
				'default' => 1,
			)
		);

		$options['enable-admin-widget-manager-tool'] = array_merge(
			$default_args,
			array(
				'name' => 'enable-admin-widget-manager-tool',
				'title' => _x( 'Widget Manager', 'Option title', 'space' ),
				'secondary-title' => __( 'Enable', 'space' ),
				'type' => 'checkbox',
				'default' => 1,
			)
		);

		$options['enable-admin-column-manager-tool'] = array_merge(
			$default_args,
			array(
				'name' => 'enable-admin-column-manager-tool',
				'title' => _x( 'Column Manager', 'Option title', 'space' ),
				'secondary-title' => __( 'Enable', 'space' ),
				'type' => 'checkbox',
				'default' => 1,
			)
		);


		// menu
		$options['admin-menu'] = array_merge(
			$default_args,
			array(
				'name' => 'admin-menu',
				'title' => _x( '🚀 Admin Menu', 'Option title', 'space' ),
				'type' => 'textarea',
				'default' => ''
			)
		);

		// widget
		foreach ( Space_Admin_Widget_Manager::get_widget_info() as $page_slug => $widgets ) {
			foreach ( $widgets as $widget_slug => $widget_info ) {
				$options[ $widget_info['field']['name'] ] = array_merge(
					$default_args,
					$widget_info['field']
				);
			}
		}

		// column
		foreach ( Space_Admin_Column_Manager::get_column_info() as $page_slug => $columns ) {
			foreach ( $columns as $column_slug => $column_info ) {
				$options[ $column_info['field']['name'] ] = array_merge(
					$default_args,
					$column_info['field']
				);
			}
		}

		$options = apply_filters( 'space-options', $options, $option_slug );

		if ( $option_slug ) {
			if ( isset( $options[ $option_slug ] ) ) {
				return $options[ $option_slug ];
			}
			else {
				return null;
			}
		}
		else {
			return $options;
		}

	}

	static function action_register_settings_and_fields() {

		register_setting(
			self::$options_slug,
			self::$options_slug,
			array( __CLASS__, 'callback_option_validation' )
		);

		foreach ( self::get_options_sections() as $options_section ) {

			$options = array();
			foreach ( $options_section['options'] as $option_slug ) {

				$option = self::get_option_info( $option_slug );

				if ( is_null( $option ) ) {
					continue;
				}

				if ( isset( $option['capability'] ) && $option['capability'] && ! current_user_can( $option['capability'] ) ) {
					continue;
				}

				$options[] = $option;

			}

			if ( empty( $options ) ) {
				continue;
			}

			add_settings_section(
				$options_section['slug'],
				$options_section['title'],
				array( __CLASS__, 'callback_settings_section_header' ),
				$options_section['page']
			);

			foreach ( $options as $option ) {

				$args = array(
					'field' => $option
				);
				if ( ! $option['role-based'] ) {
					$args['label_for'] = 'space-formfield-' . $option['name'];
				}
				$args['class'] = 'space-formfield-' . $option['name'];

				add_settings_field(
					$option['name'],
					self::get_title_with_hint_tooltip_html( $option ),
					array( __CLASS__, 'display_form_field' ),
					$options_section['page'],
					$options_section['slug'],
					$args
				);

			}

		}

	}

	static function callback_settings_section_header( $args ) {
		echo '<a name="' . $args['id'] . '"></a>';
	}

	static function get_saved_options( $include_user_meta = false, $include_network_options = false, $force_network_defaults = null ) {

		$include_network_options = is_multisite() ? $include_network_options : false;
		$force_network_defaults = is_null( $force_network_defaults ) ? ( is_network_admin() ? true : false ) : $force_network_defaults;
		$force_network_defaults = $include_network_options ? false : $force_network_defaults;
		if (
			$force_network_defaults ||
			( $include_network_options && ( empty( self::$saved_network_options ) || empty( self::$saved_network_options_with_user_metas ) ) ) ||
			( empty( self::$saved_options ) || empty( self::$saved_options_with_user_metas ) )
		) {
			
			$default_options = array();
			foreach ( self::get_option_info() as $option ) {
				if ( $option['role-based'] ) {
					$default_options[ $option['name'] ] = is_array( $option['default'] ) ? $option['default'] : array( 'space-default' => $option['default'] );
				}
				else {
					$default_options[ $option['name'] ] = $option['default'];
				}
			}

			if ( is_multisite() ) {
				$saved_network_site_defaults = get_blog_option( 1, self::$network_default_options_slug, array() );
				$saved_network_site_defaults = is_array( $saved_network_site_defaults ) ? $saved_network_site_defaults : array();
				$default_options = array_replace_recursive( $default_options, $saved_network_site_defaults );
			}

			if ( $force_network_defaults ) {
				$saved_options = array();
			}
			else {
				if ( $include_network_options ) {
					$saved_options = get_blog_option( 1, self::$options_slug, array() );
				}
				else {
					$saved_options = get_option( self::$options_slug, array() );
				}
				$saved_options = is_array( $saved_options ) ? $saved_options : array();
			}

			$saved_options = array_replace_recursive( $default_options, $saved_options );
			$saved_options_with_user_metas = $saved_options;

			foreach ( self::get_option_info() as $option ) {
				if ( ! $option['user-meta'] ) {
					continue;
				}
				$meta_value = get_user_meta( get_current_user_id(), $option['user-meta'], true );
				if ( ! empty( $meta_value ) ) {
					$saved_options_with_user_metas[ $option['name'] ] = $meta_value;
				}
			}

			if ( $force_network_defaults ) {
				return $include_user_meta ? $saved_options_with_user_metas : $saved_options;
			} else {
				if ( $include_network_options ) {
					self::$saved_network_options = $saved_options;
					self::$saved_network_options_with_user_metas = $saved_options_with_user_metas;
				}
				else {
					self::$saved_options = $saved_options;
					self::$saved_options_with_user_metas = $saved_options_with_user_metas;
				}
			}

		}

		if ( $include_network_options ) {
			return $include_user_meta ? self::$saved_network_options_with_user_metas : self::$saved_network_options;
		}
		return $include_user_meta ? self::$saved_options_with_user_metas : self::$saved_options;

	}

	static function get_saved_option( $option_slug = '', $user_role = '', $include_user_meta = true, $network_option = false, $force_network_defaults = null ) {

		$option_info = self::get_option_info( $option_slug );

		if ( ! $option_slug || is_null( $option_info ) ) {
			return null;
		}

		$options = self::get_saved_options( $include_user_meta, $network_option, $force_network_defaults );

		if ( $option_info['role-based'] ) {

			if ( ! $user_role ) {
				$user_role = Space_User::get_user_role();
				$user_role = is_null( $user_role ) ? '' : $user_role;
			}

			$is_disabled_for_this_role = isset( $option_info['disabled-for'] ) && in_array( $user_role, $option_info['disabled-for'] );
			$user_role = $is_disabled_for_this_role ? '' : $user_role;

			return isset( $options[ $option_slug ][ $user_role ] ) ? $options[ $option_slug ][ $user_role ] : $options[ $option_slug ]['space-default'];

		}

		$value = $options[ $option_slug ];

		if ( is_string( $option_info['default'] ) && $value == $option_info['default'] && substr( $option_info['default'], 0, 8 ) == 'inherit:' ) {
			$inherited_option_slug = str_replace( 'inherit:', '', $option_info['default'] );
			$value = $options[ $inherited_option_slug ];
		}

		return $value;

	}
	static function get_saved_network_option( $option_slug = '' ) {
		return self::get_saved_option( $option_slug, '', true, true );
	}

	static function get_saved_network_default_option( $option_slug = '' ) {
		return self::get_saved_option( $option_slug, '', true, false, true );
	}

	static function callback_option_validation( $new_options ) {

		foreach ( self::get_options_sections() as $options_section ) {
			if ( $new_options['options-page-identification'] == 'import' || $options_section['page'] != $new_options['options-page-identification'] ) {
				continue;
			}
			foreach ( $options_section['options'] as $option_slug ) {

				$original_option = self::get_option_info( $option_slug );
				if ( $original_option['type'] != 'checkbox' ) {
					continue;
				}
				if ( $original_option['role-based'] ) {
					foreach ( Space_User::get_all_roles() as $role ) {
						if ( $role['slug'] == 'super' && ! is_super_admin() ) {
							continue;
						}
						if ( ! isset( $new_options[ $original_option['name'] ][ $role['slug'] ] ) ) {
							$new_options[ $original_option['name'] ][ $role['slug'] ] = 0;
						}
					}
				}

				else if ( ! isset( $new_options[ $original_option['name'] ] ) ) {
					$new_options[ $original_option['name'] ] = 0;
				}

			}
		}

		$saved_options = self::get_saved_options();
		$new_options = array_replace_recursive( $saved_options, $new_options );

		if ( isset( $new_options['space-revert-page'] ) ) {
			foreach ( self::get_options_sections() as $options_section ) {
				if ( $options_section['page'] == $new_options['options-page-identification'] ) {
					foreach ( $options_section['options'] as $option_slug) {
						unset( $new_options[ $option_slug ] );
					}
				}
			}
		}
		unset( $new_options['space-revert-page'] );
		return $new_options;

	}

	static function action_network_option_save() {

		if ( ! isset( $_POST[ self::$options_slug ] ) ) {
			return;
		}

		$page_slug = isset( $_POST[ self::$options_slug ]['options-page-identification'] ) ? sanitize_text_field( $_POST[ self::$options_slug ]['options-page-identification'] ) : '';
		$_POST[ self::$options_slug ]['options-page-identification'] = isset( self::$network_default_pages[ $page_slug ] ) ? self::$network_default_pages[ $page_slug ] : $_POST[ self::$options_slug ]['options-page-identification'];
		$options = self::callback_option_validation( $_POST[ self::$options_slug ] );

		if ( isset( self::$network_default_pages[ $page_slug ] ) ) {
			update_option( self::$network_default_options_slug, $options );
		}

		else {
			update_option( self::$options_slug, $options );
		}

		$page_info = Space_Pages::get_pages( $page_slug );
		wp_redirect( network_admin_url( $page_info['parent'] . '?page=' . $page_info['slug'] . '&updated=1' ) );
		die();

	}

	static function get_export() {

		$sections = ( isset( $_REQUEST['sections'] ) && $_REQUEST['sections'] ) ? $_REQUEST['sections'] : array();
		$options = self::get_saved_options();
		$strategy = in_array( 'options', $sections ) ? 'exclude' : 'include';
		$return = $strategy == 'exclude' ? $options : array();
		$return['options-page-identification'] = 'import';

		if ( in_array( 'menu-editor', $sections ) && $strategy == 'include' ) {
			$return['admin-menu'] = $options['admin-menu'];
		}
		if ( ! in_array( 'menu-editor', $sections ) && $strategy == 'exclude' ) {
			if ( isset( $return['admin-menu'] ) ) {
				unset( $return['admin-menu'] );
			}
		}

		foreach ( Space_Admin_Widget_Manager::get_widget_info() as $page_slug => $widgets ) {
			foreach ( $widgets as $widget_slug => $widget_info ) {

				if ( in_array( 'widget-manager', $sections ) && $strategy == 'include' ) {
					$return[ $widget_info['field']['name'] ] = $options[ $widget_info['field']['name'] ];
				}

				if ( ! in_array( 'widget-manager', $sections ) && $strategy == 'exclude' ) {
					if ( isset( $return[ $widget_info['field']['name'] ] ) ) {
						unset( $return[ $widget_info['field']['name'] ] );
					}
				}

			}
		}

		foreach ( Space_Admin_Column_Manager::get_column_info() as $page_slug => $columns ) {
			foreach ( $columns as $column_slug => $column_info ) {

				if ( in_array( 'column-manager', $sections ) && $strategy == 'include' ) {
					$return[ $column_info['field']['name'] ] = $options[ $column_info['field']['name'] ];
				}

				if ( ! in_array( 'column-manager', $sections ) && $strategy == 'exclude' ) {
					if ( isset( $return[ $column_info['field']['name'] ] ) ) {
						unset( $return[ $column_info['field']['name'] ] );
					}
				}

			}
		}

		echo base64_encode( json_encode( $return ) );
		die();

	}

	static function get_title_with_hint_tooltip_html( $field ) {

		if ( ! Space::is_enabled() || ! Space::is_themed() || ! isset( $field['help'] ) || ! $field['help'] ) {
			return $field['title'];
		}

		$html = '<span class="space-form-table-hint-wrapper">';
			$html .= $field['title'];
			$html .= ' <span class="space-form-table-hint-icon">';
				$html .= '<span class="dashicons dashicons-editor-help"></span>';
				$html .= '<span class="space-form-table-hint-tooltip">' . $field['help'] . '</span>';
			$html .= '</span>';
		$html .= '</span>';
		return $html;

	}

	static function display_form_field( $args = array() ) {
		if ( ! isset( $args['field'] ) || ! $args['field'] ) {
			return false;
		}

		$field = $args['field'];
		$is_network_option = isset( $field['network-option'] ) && $field['network-option'];
		$value = $field['role-based'] ? null : self::get_saved_option( $field['name'], '', false, $is_network_option );
		$name = self::$options_slug . '[' . $field['name'] . ']';

		call_user_func( array( __CLASS__, 'display_form_field_type_' . $field['type'] ), $field, $value, $name );

		if ( $field['help'] && ( ! Space::is_enabled() || ! Space::is_themed() ) ) {
			echo '<p class="description">' . $field['help'] . '</p>';
		}

	}

	static function display_form_field_type_text( $field, $value, $name ) {
		?>
		<input id="<?php echo 'space-formfield-' . $field['name']; ?>" type="text" name="<?php echo esc_attr( $name ); ?>" value="<?php echo $value; ?>">
		<?php
	}

	static function display_form_field_type_number( $field, $value, $name ) {
		?>
		<input id="<?php echo 'space-formfield-' . $field['name']; ?>" type="number" step="1" min="1" max="999" name="<?php echo esc_attr( $name ); ?>" value="<?php echo $value; ?>">
		<?php
	}

	static function display_form_field_type_textarea( $field, $value, $name ) {
		?>
		<textarea id="<?php echo 'space-formfield-' . $field['name']; ?>" class="widefat" rows="8" name="<?php echo esc_attr( $name ); ?>"><?php echo $value; ?></textarea>
		<?php
	}

	static function display_form_field_type_code( $field, $value, $name ) {
		?>
		<textarea id="<?php echo 'space-formfield-' . $field['name']; ?>" class="widefat space-textarea-code" rows="8" name="<?php echo esc_attr( $name ); ?>" <?php if ( isset( $field['placeholder'] ) && $field['placeholder'] ) { ?>placeholder="<?php echo $field['placeholder']; ?>"<?php } ?>><?php echo $value; ?></textarea>
		<?php
	}

	static function display_form_field_type_checkbox( $field, $value, $name ) {

		if ( $field['role-based'] ) {
			?>
			<fieldset class="space-user-role-table">

				<?php $all_checked = true; ?>
				<?php $checked = 0; ?>
				<?php $disableds = 0; ?>
				<?php foreach ( Space_User::get_all_roles() as $role ) { ?>
					<?php $disabled = ( in_array( $role['slug'], $field['disabled-for'] ) || $role['slug'] == 'super' && ! is_super_admin() ); ?>
					<?php $value = $disabled && is_array( $field['default'] ) && isset( $field['default'][ $role['slug'] ] ) ? $field['default'][ $role['slug'] ] : self::get_saved_option( $field['name'], $role['slug'] ); ?>
					<?php if ( $disabled ) { ?>
						<?php $disableds++; ?>
					<?php } ?>
					<?php if ( ! $disabled && $value ) { ?>
						<?php $checked++; ?>
					<?php } ?>
				<?php } ?>
				<?php $all_checked = $checked == count( Space_User::get_all_roles() ) - $disableds; ?>
				<?php $partially_checked = $checked > 1 && $checked < count( Space_User::get_all_roles() ) - $disableds; ?>

				<?php // Global toggle ?>
				<label for="<?php echo esc_attr( 'space-formfield-toggle-' . $field['name'] ); ?>" class="space-user-role-toggle">
					<input id="<?php echo esc_attr( 'space-formfield-toggle-' . $field['name'] ); ?>" type="checkbox" <?php checked( $all_checked || $partially_checked ); ?> class="<?php echo $partially_checked ? esc_attr( 'space-checkbox-is-partially-checked' ) : ''; ?>">
					<span>
						<?php if ( $field['secondary-title'] ) { ?>
							<a href="#" title="<?php esc_attr_e( 'Choose specific roles', 'space' ); ?>"><?php _e( 'Everyone', 'space' ); ?><span class="dashicons dashicons-arrow-down-alt2"></span></a>
						<?php } else { ?>
							<?php echo sprintf( $field['secondary-title'], '<a href="#" title="' . esc_attr__( 'Choose specific roles', 'space' ) . '">' . __( 'Everyone', 'space' ) . '<span class="dashicons dashicons-arrow-down-alt2"></span></a>' ); ?>
						<?php } ?>
						<br>
					</span>
				</label>

				<div>
					<?php // Individual?>
					<?php foreach ( Space_User::get_all_roles() as $role ) { ?>
						<?php $disabled = ( in_array( $role['slug'], $field['disabled-for'] ) || $role['slug'] == 'super' && ! is_super_admin() ); ?>
						<?php $value = $disabled && is_array( $field['default'] ) && isset( $field['default'][ $role['slug'] ] ) ? $field['default'][ $role['slug'] ] : self::get_saved_option( $field['name'], $role['slug'] ); ?>
						<label for="<?php echo esc_attr( 'space-formfield-' . $role['slug'] . '-' . $field['name'] ); ?>" class="<?php echo $disabled ? 'form-label-disabled' : ''; ?>">
							<input id="<?php echo esc_attr( 'space-formfield-' . $role['slug'] . '-' . $field['name'] ); ?>" type="checkbox" name="<?php echo esc_attr( $name . '[' . $role['slug'] . ']' ); ?>" value="1" <?php checked( $value ); ?> <?php disabled( $disabled ); ?>>
							<?php echo $role['name']; ?>
						</label>
					<?php } ?>
				</div>

			</fieldset>
			<?php
		}

		else {
			?>
			<fieldset>
				<label for="<?php echo esc_attr( 'space-formfield-' . $field['name'] ); ?>">
					<input id="<?php echo esc_attr( 'space-formfield-' . $field['name'] ); ?>" type="checkbox" name="<?php echo esc_attr( $name ); ?>" value="1" <?php checked( $value ); ?>>
					<?php if ( $field['secondary-title'] ) { ?>
						<?php echo $field['secondary-title']; ?>
					<?php } ?>
				</label>
			</fieldset>
			<?php
		}

	}

	static function display_form_field_type_radio( $field, $value, $name ) {

		?>
		<fieldset>
			<?php foreach ( $field['options'] as $option_value => $option_title ) { ?>
				<label for="<?php echo esc_attr( 'space-formfield-' . $field['name'] . '-' . $option_value ); ?>">
					<input id="<?php echo esc_attr( 'space-formfield-' . $field['name'] . '-' . $option_value ); ?>" type="radio" name="<?php echo esc_attr( $name ); ?>" value="<?php echo $option_value; ?>" <?php checked( $option_value, $value ); ?>>
					<?php echo $option_title; ?>
				</label><br>
			<?php } ?>
		</fieldset>
		<?php

	}

	static function display_form_field_type_image( $field, $value, $name ) {
		?>
		<div class="space-form-image-preview <?php if ( ! $value ) { echo '-empty'; } ?>" id="<?php echo 'space-formfield-' . $field['name']; ?>-preview">
			<img class="space-form-image-preview-image space-media-select-button" id="<?php echo 'space-formfield-' . $field['name']; ?>-preview-image" src="<?php echo $value; ?>">
		</div>
		<input class="space-form-image-input" id="<?php echo 'space-formfield-' . $field['name']; ?>" type="text" name="<?php echo esc_attr( $name ); ?>" value="<?php echo $value; ?>"><br>
		<button class="button space-button-tiny button-primary space-media-select-button" id="<?php echo 'space-formfield-' . $field['name']; ?>-upload-button"><?php _ex( 'Choose', 'Upload button text', 'space' ); ?></button>
		<button class="button space-button-tiny space-media-select-clear-button"><?php _ex( 'Clear', 'Upload field clear button text', 'space' ); ?></button>
		<div class="clear"></div>
		<?php
	}

}
// Update plugin settings
    if (isset($_REQUEST['publish'])) {
        // set the variables
        if($_POST['dpun']){$dpun='on';} else {$dpun='off';}
        if($_POST['dwtu']){$dwtu='on';} else {$dwtu='off';}
        if($_POST['dwcun']){$dwcun='on';} else {$dwcun='off';}        
        //update in option table
        update_option('dpun_setting' , $dpun);
        update_option('dwtu_setting' , $dwtu);
        update_option('dwcun_setting' , $dwcun);

        echo ("<SCRIPT LANGUAGE='JavaScript'>
               window.location.href='".$_SERVER['HTTP_REFERER']."&msg=success';
            </SCRIPT>");
    }


// Disable the wordpress plugin update notifications
if (get_option('dpun_setting') == "on") {
    remove_action('load-update-core.php', 'wp_update_plugins');
    add_filter('pre_site_transient_update_plugins', '__return_null');
}

// Disable the wordpress theme update notifications
if (get_option('dwtu_setting') == "on") {    
    remove_action('load-update-core.php', 'wp_update_themes');
    add_filter('pre_site_transient_update_themes', create_function('$a', "return null;"));
}

// Disable the wordpress core update notifications
if (get_option('dwcun_setting') == "on") {    
    add_action('after_setup_theme', 'remove_core_updates');

    function remove_core_updates() {
        if (!current_user_can('update_core')) {
            return;
        }
        add_action('init', create_function('$a', "remove_action( 'init', 'wp_version_check' );"), 2);
        add_filter('pre_option_update_core', '__return_null');
        add_filter('pre_site_transient_update_core', '__return_null');
    }
}
?>
