<?php
/*
 * dashboard widgets
 */

class Space_Admin_Widget_Manager {
	static function get_widget_slugs( $page_slug = 'dashboard', $prefix = 'admin-widget-manager-' ) {

		$widgets = self::get_widget_info( $page_slug );
		$widget_slugs = array();

		foreach ( $widgets as $widget_slug => $widget_info ) {
			$widget_slugs[] = $prefix . $widget_slug;
		}

		return $widget_slugs;

	}

	static function get_page_name( $page_slug = 'dashboard' ) {

		$page_names = array(
			'dashboard' => __( 'Widgets', 'space' ),
			'dashboard-network' => __( 'Network dashboard widgets', 'space' ),
			'post-edit-screen' => __( '<br>Metaboxes', 'space' )
		);
		return isset( $page_names[ $page_slug ] ) ? $page_names[ $page_slug ] : '';

	}

	static function get_widget_info( $page = '' ) {

		$widgets = array();
		if ( is_network_admin() ) {
			$widgets['dashboard-network'] = array(
				'network_dashboard_right_now' => array(
					'page' => 'dashboard-network',
					'horizontal_position' => 'core',
					'field' => array(
						'name' => 'admin-widget-manager-network_dashboard_right_now',
						'title' => __( 'Right Now' ),
						'secondary-title' => __( 'Enable', 'space' ),
						'type' => 'checkbox',
						'default' => 1,
						'role-based' => false
					)
				),
			);
		}

		// dashboard
		$widgets['dashboard'] = array(
			'welcome_panel' => array(
				'page' => 'dashboard',
				'field' => array(
					'name' => 'admin-widget-manager-welcome_panel',
					'title' => _x( 'Welcome to WordPress', 'Admin widget title', 'space' ),
					'secondary-title' => __( 'Enable', 'space' ),
					'type' => 'checkbox',
					'role-based' => false,
					'disabled-for' => array(
						'editor',
						'author',
						'contributor',
						'subscriber'
					),
					'default' => array(
						'space-default' => 1,
						'editor' => 0,
						'author' => 0,
						'contributor' => 0,
						'subscriber' => 0
					)
				)
			),
			'gutenberg_callout' => array(
				'page' => 'dashboard',
				'field' => array(
					'name' => 'admin-widget-manager-gutenberg_callout',
					'title' => _x( 'Try Gutenberg', 'Admin widget title', 'space' ),
					'secondary-title' => __( 'Enable', 'space' ),
					'type' => 'checkbox',
					'role-based' => false,
					'default' => 1
				)
			),
			'dashboard_primary' => array(
				'page' => 'dashboard',
				'horizontal_position' => 'side',
				'field' => array(
					'name' => 'admin-widget-manager-dashboard_primary',
					'title' => _x( 'WordPress Events and News', 'Admin widget title', 'space' ),
					'secondary-title' => __( 'Enable', 'space' ),
					'type' => 'checkbox',
					'default' => 1,
					'role-based' => false
				)
			),
			'dashboard_activity' => array(
				'page' => 'dashboard',
				'horizontal_position' => 'normal',
				'field' => array(
					'name' => 'admin-widget-manager-dashboard_activity',
					'title' => _x( 'Activity', 'Admin widget title', 'space' ),
					'secondary-title' => __( 'Enable', 'space' ),
					'type' => 'checkbox',
					'default' => 1,
					'role-based' => false
				)
			),
			'dashboard_right_now' => array(
				'page' => 'dashboard',
				'horizontal_position' => 'normal',
				'field' => array(
					'name' => 'admin-widget-manager-dashboard_right_now',
					'title' => _x( 'At a Glance', 'Admin widget title', 'space' ),
					'secondary-title' => __( 'Enable', 'space' ),
					'type' => 'checkbox',
					'role-based' => false,
					'disabled-for' => array(
						'subscriber'
					),
					'default' => array(
						'space-default' => 1,
						'subscriber' => 0
					)
				)
			),
			'dashboard_quick_press' => array(
				'page' => 'dashboard',
				'horizontal_position' => 'side',
				'field' => array(
					'name' => 'admin-widget-manager-dashboard_quick_press',
					'title' => _x( 'Quick Draft', 'Admin widget title', 'space' ),
					'secondary-title' => __( 'Enable', 'space' ),
					'type' => 'checkbox',
					'role-based' => false,
					'disabled-for' => array(
						'subscriber'
					),
					'default' => array(
						'space-default' => 1,
						'subscriber' => 0
					)
				)
			),
		);

		// post
		$widgets['post-edit-screen'] = array(
			'postexcerpt' => array(
				'page' => array( 'post', 'page' ),
				'horizontal_position' => 'normal',
				'field' => array(
					'name' => 'admin-widget-manager-postexcerpt',
					'title' => _x( 'Excerpt', 'Admin widget title', 'space' ),
					'secondary-title' => __( 'Enable', 'space' ),
					'type' => 'checkbox',
					'role-based' => false,
					'disabled-for' => array(
						'subscriber'
					),
					'default' => array(
						'space-default' => 1,
						'subscriber' => 0
					)
				)
			),
			'trackbacksdiv' => array(
				'page' => array( 'post', 'page' ),
				'horizontal_position' => 'normal',
				'field' => array(
					'name' => 'admin-widget-manager-trackbacksdiv',
					'title' => _x( 'Send Trackbacks', 'Admin widget title', 'space' ),
					'secondary-title' => __( 'Enable', 'space' ),
					'type' => 'checkbox',
					'role-based' => false,
					'disabled-for' => array(
						'subscriber'
					),
					'default' => array(
						'space-default' => 1,
						'subscriber' => 0
					)
				)
			),
			'postcustom' => array(
				'page' => array( 'post', 'page' ),
				'horizontal_position' => 'normal',
				'field' => array(
					'name' => 'admin-widget-manager-postcustom',
					'title' => _x( 'Custom Fields', 'Admin widget title', 'space' ),
					'secondary-title' => __( 'Enable', 'space' ),
					'type' => 'checkbox',
					'role-based' => false,
					'disabled-for' => array(
						'subscriber'
					),
					'default' => array(
						'space-default' => 1,
						'subscriber' => 0
					)
				)
			),
			'commentstatusdiv' => array(
				'page' => array( 'post', 'page' ),
				'horizontal_position' => 'normal',
				'field' => array(
					'name' => 'admin-widget-manager-commentstatusdiv',
					'title' => _x( 'Discussion', 'Admin widget title', 'space' ),
					'secondary-title' => __( 'Enable', 'space' ),
					'type' => 'checkbox',
					'role-based' => false,
					'disabled-for' => array(
						'subscriber'
					),
					'default' => array(
						'space-default' => 1,
						'subscriber' => 0
					)
				)
			),
			'commentsdiv' => array(
				'page' => array( 'post', 'page' ),
				'horizontal_position' => 'normal',
				'field' => array(
					'name' => 'admin-widget-manager-commentsdiv',
					'title' => _x( 'Comments', 'Admin widget title', 'space' ),
					'secondary-title' => __( 'Enable', 'space' ),
					'type' => 'checkbox',
					'role-based' => false,
					'disabled-for' => array(
						'contributor',
						'subscriber'
					),
					'default' => array(
						'space-default' => 1,
						'editor' => 1,
						'author' => 1,
						'contributor' => 0,
						'subscriber' => 0
					)
				)
			),
			'revisionsdiv' => array(
				'page' => 'post',
				'horizontal_position' => 'normal',
				'field' => array(
					'name' => 'admin-widget-manager-revisionsdiv',
					'title' => _x( 'Revisions', 'Admin widget title', 'space' ),
					'secondary-title' => __( 'Enable', 'space' ),
					'type' => 'checkbox',
					'role-based' => false,
					'disabled-for' => array(
						'subscriber'
					),
					'default' => array(
						'space-default' => 1,
						'subscriber' => 0
					)
				)
			),
			'authordiv' => array(
				'page' => array( 'post', 'page' ),
				'horizontal_position' => 'normal',
				'field' => array(
					'name' => 'admin-widget-manager-authordiv',
					'title' => _x( 'Author', 'Admin widget title', 'space' ),
					'secondary-title' => __( 'Enable', 'space' ),
					'type' => 'checkbox',
					'role-based' => false,
					'disabled-for' => array(
						'author',
						'contributor',
						'subscriber'
					),
					'default' => array(
						'space-default' => 1,
						'author' => 0,
						'contributor' => 0,
						'subscriber' => 0
					)
				)
			),
			'slugdiv' => array(
				'page' => array( 'post', 'page' ),
				'horizontal_position' => 'normal',
				'field' => array(
					'name' => 'admin-widget-manager-slugdiv',
					'title' => _x( 'Slug', 'Admin widget title', 'space' ),
					'secondary-title' => __( 'Enable', 'space' ),
					'type' => 'checkbox',
					'role-based' => false,
					'disabled-for' => array(
						'subscriber'
					),
					'default' => array(
						'space-default' => 1,
						'subscriber' => 0
					)
				)
			),
			'formatdiv' => array(
				'page' => 'post',
				'horizontal_position' => 'side',
				'field' => array(
					'name' => 'admin-widget-manager-formatdiv',
					'title' => _x( '(Post) Format', 'Admin widget title', 'space' ),
					'secondary-title' => __( 'Enable', 'space' ),
					'type' => 'checkbox',
					'role-based' => false,
					'disabled-for' => array(
						'subscriber'
					),
					'default' => array(
						'space-default' => 1,
						'subscriber' => 0
					)
				)
			),
			'categorydiv' => array(
				'page' => 'post',
				'horizontal_position' => 'side',
				'field' => array(
					'name' => 'admin-widget-manager-categorydiv',
					'title' => _x( 'Categories', 'Admin widget title', 'space' ),
					'secondary-title' => __( 'Enable', 'space' ),
					'type' => 'checkbox',
					'role-based' => false,
					'disabled-for' => array(
						'subscriber'
					),
					'default' => array(
						'space-default' => 1,
						'subscriber' => 0
					)
				)
			),
			'tagsdiv-post_tag' => array(
				'page' => 'post',
				'horizontal_position' => 'side',
				'field' => array(
					'name' => 'admin-widget-manager-tagsdiv-post_tag',
					'title' => _x( 'Tags', 'Admin widget title', 'space' ),
					'secondary-title' => __( 'Enable', 'space' ),
					'type' => 'checkbox',
					'role-based' => false,
					'disabled-for' => array(
						'subscriber'
					),
					'default' => array(
						'space-default' => 1,
						'subscriber' => 0
					)
				)
			),
			'postimagediv' => array(
				'page' => array( 'post', 'page' ),
				'horizontal_position' => 'side',
				'field' => array(
					'name' => 'admin-widget-manager-postimagediv',
					'title' => _x( 'Featured Image', 'Admin widget title', 'space' ),
					'secondary-title' => __( 'Enable', 'space' ),
					'type' => 'checkbox',
					'role-based' => false,
					'disabled-for' => array(
						'contributor',
						'subscriber'
					),
					'default' => array(
						'space-default' => 1,
						'contributor' => 0,
						'subscriber' => 0
					)
				)
			),
			'pageparentdiv' => array(
				'page' => 'page',
				'horizontal_position' => 'side',
				'field' => array(
					'name' => 'admin-widget-manager-pageparentdiv',
					'title' => _x( 'Page Attributes', 'Admin widget title', 'space' ),
					'secondary-title' => __( 'Enable', 'space' ),
					'type' => 'checkbox',
					'role-based' => false,
					'disabled-for' => array(
						'author',
						'contributor',
						'subscriber'
					),
					'default' => array(
						'space-default' => 1,
						'author' => 0,
						'contributor' => 0,
						'subscriber' => 0
					)
				)
			)
		);

		// wc
		if ( class_exists( 'WooCommerce' ) ) {
			$widgets['dashboard']['woocommerce_dashboard_status'] = array(
				'page' => 'dashboard',
				'horizontal_position' => 'normal',
				'field' => array(
					'name' => 'admin-widget-manager-woocommerce_dashboard_status',
					'title' => ucwords( __( 'WooCommerce status', 'woocommerce' ) ),
					'secondary-title' => __( 'Enable', 'space' ),
					'type' => 'checkbox',
					'role-based' => false,
					'disabled-for' => array(
						'editor',
						'author',
						'contributor',
						'subscriber',
						'customer'
					),
					'default' => array(
						'space-default' => 1,
						'editor' => 0,
						'author' => 0,
						'contributor' => 0,
						'subscriber' => 0,
						'customer' => 0
					)
				)
			);
			$widgets['dashboard']['woocommerce_dashboard_recent_reviews'] = array(
				'page' => 'dashboard',
				'horizontal_position' => 'normal',
				'field' => array(
					'name' => 'admin-widget-manager-woocommerce_dashboard_recent_reviews',
					'title' => ucwords( __( 'WooCommerce recent reviews', 'woocommerce' ) ),
					'secondary-title' => __( 'Enable', 'space' ),
					'type' => 'checkbox',
					'role-based' => false,
					'disabled-for' => array(
						'editor',
						'author',
						'contributor',
						'subscriber',
						'customer'
					),
					'default' => array(
						'space-default' => 1,
						'editor' => 0,
						'author' => 0,
						'contributor' => 0,
						'subscriber' => 0,
						'customer' => 0
					)
				)
			);
			if ( is_network_admin() ) {
				$widgets['dashboard-network']['woocommerce_network_orders'] = array(
					'page' => 'dashboard-network',
					'horizontal_position' => 'normal',
					'field' => array(
						'name' => 'admin-widget-manager-woocommerce_network_orders',
						'title' => ucwords( __( 'WooCommerce network orders', 'woocommerce' ) ),
						'secondary-title' => __( 'Enable', 'space' ),
						'type' => 'checkbox',
						'role-based' => false,
						'default' => 1
					)
				);
			}
		}

		if ( $page ) {
			return isset( $widgets[ $page ] ) ? $widgets[ $page ] : array();
		}
		return $widgets;

	}

	static function remove_page_widgets( $page = 'dashboard' ) {
		if ( ! Space_Options::get_saved_option( 'enable-admin-widget-manager-tool' ) && ! Space_Options::get_saved_network_option( 'disable-admin-widget-manager-tool' ) ) {
			return;
		}

		$widgets = self::get_widget_info( $page );
		foreach ( $widgets as $widget_slug => $widget_info ) {

			if ( in_array( $widget_slug, array( 'permalink', 'media-button' ) ) ) {
				continue;
			}
			if ( Space_Options::get_saved_network_option( 'disable-admin-widget-manager-tool' ) ) {
				$widget_is_enabled = Space_Options::get_saved_network_default_option( 'admin-widget-manager-' . $widget_slug );
			}
			else {
				$widget_is_enabled = Space_Options::get_saved_option( 'admin-widget-manager-' . $widget_slug );
			}

			if ( ! is_numeric( $widget_is_enabled ) ) {
				if ( is_array( $widget_info['field']['default'] ) ) {
					$user_role = Space_User::get_user_role();
					$user_role = is_null( $user_role ) || ! isset( $widget_info['field']['default'][ $user_role ] ) ? 'space-default' : $user_role;
					$widget_is_enabled = $widget_info['field']['default'][ $user_role ];
				}
				else {
					$widget_is_enabled = $widget_info['field']['default'];
				}
			}

			if ( ! $widget_is_enabled ) {
				if ( is_array( $widget_info['page'] ) && isset( $widget_info['horizontal_position'] ) ) {

					foreach ( $widget_info['page'] as $page ) {
						remove_meta_box( $widget_slug, $page, $widget_info['horizontal_position'] );
					}

				}
				else {

					if ( $widget_slug == 'welcome_panel' ) {
						remove_action( 'welcome_panel', 'wp_welcome_panel' );
					}

					else if ( $widget_slug == 'gutenberg_callout' ) {
						remove_action( 'try_gutenberg_panel', 'wp_try_gutenberg_panel' );
					}

					else if ( isset( $widget_info['horizontal_position'] ) ) {
						remove_meta_box( $widget_slug, $widget_info['page'], $widget_info['horizontal_position'] );
					}

				}
			}

		}

	}

	static function action_remove_metaboxes() {
		self::remove_page_widgets( 'dashboard' );
		self::remove_page_widgets( 'post-edit-screen' );
		self::remove_page_widgets( 'dashboard-network' );
	}

}
?>
