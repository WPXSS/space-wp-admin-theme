<?php
/*
 * adding to menus
 */

class Space_Menu {
	static function action_add_space_menu_entries() {
		foreach ( Space_Pages::get_pages() as $page_info ) {

			if ( $page_info['network'] ) {
				continue;
			}

			$page_info['menu-title'] = $page_info['menu-title'] ? $page_info['menu-title'] : $page_info['title'];

			if ( ! $page_info['in-menu'] ) {
				$page_info['menu-title'] = '';
			}

			add_submenu_page(
				$page_info['parent'],
				$page_info['title'],
				$page_info['menu-title'],
				Space_User::get_admin_cap(),
				$page_info['slug'],
				$page_info['callback']
			);

		}

	}

	// add
	static function action_add_menu_entries() {

		$menu_logo_image = Space_Options::get_saved_option( 'menu-logo-image' );
		$hide_menu_logo = Space_Options::get_saved_option( 'hide-menu-logo' );
		$always_show_view_site = Space_Options::get_saved_option( 'always-show-view-site' );

		

		// logo
		if ( ! $hide_menu_logo && $menu_logo_image ) {
			add_menu_page(
				_x( 'Logo image', 'Menu button description', 'space' ),
				'<img class="space-menu-logo" src="' . esc_attr( $menu_logo_image ) . '" title="' . get_bloginfo( 'name' ) . '">',
				'read',
				'space-view-site-logo',
				'__return_false',
				'none',
				0
			);
		}

		// view site
		if ( $hide_menu_logo || ! $menu_logo_image || $always_show_view_site ) {
			add_menu_page(
				_x( 'View Site', 'Text on the menu button', 'space' ),
				_x( 'View Site', 'Text on the menu button', 'space' ),
				'read',
				'space-view-site',
				'__return_false',
				'none',
				0
			);
		}

	}

	// links
	static function action_apply_relinks() {

		global $menu;
		if ( $menu && is_array( $menu ) && ! empty( $menu ) ) {
			foreach ( $menu as $menuitem_key => $menuitem ) {

				// Collapse
				if ( isset( $menuitem[2] ) && $menuitem[2] == 'space-menu-collapse' ) {
					$menu[ $menuitem_key ][2] = '#';
				}

				// View Site
				if ( isset( $menuitem[2] ) && $menuitem[2] == 'space-view-site' ) {
					$menu[ $menuitem_key ][2] = apply_filters( 'space-view-site-button-url', home_url() );
				}

				// logo
				if ( isset( $menuitem[2] ) && $menuitem[2] == 'space-view-site-logo' ) {
					$menu[ $menuitem_key ][2] = apply_filters( 'space-view-site-logo-url', home_url() );
				}

			}
		}

	}

	static function action_add_network_menu_entries() {
		foreach ( Space_Pages::get_pages() as $page_info ) {

			if ( ! $page_info['network'] ) {
				continue;
			}

			if ( ! $page_info['in-menu'] ) {
				$page_info['parent'] = null;
			}

			add_submenu_page(
				$page_info['parent'],
				$page_info['title'],
				( $page_info['menu-title'] ? $page_info['menu-title'] : $page_info['title'] ),
				Space_User::get_admin_cap(),
				$page_info['slug'],
				$page_info['callback']
			);

		}

	}

	static function filter_admin_menu_active_states( $parent_file ) {

		global $submenu_file;
		$screen = get_current_screen();
		$general_options_page = Space_Pages::get_pages( 'space-options-general' );
		foreach ( Space_Pages::get_pages() as $page_info ) {
			if ( $page_info['in-menu'] ) {
				continue;
			}
			if ( is_numeric( strpos( $screen->base, $page_info['slug'] ) ) ) {
				$parent_file = $general_options_page['parent'];
				$submenu_file = $general_options_page['slug'];
				break;
			}
		}
		return $parent_file;

	}

	// updates
	static function action_remove_update_menu() {
		remove_submenu_page( 'index.php', 'update-core.php' );
	}

	// numbers
	static function action_add_numbers() {
		if ( ! Space::is_themed() ) {
			return;
		}
		if ( ! Space_Options::get_saved_option( 'enable-menu-counters' ) ) {
			return;
		}

		global $menu;
		$menu = is_array( $menu ) ? $menu : array();

		foreach ( $menu as $item_key => $item ) {

			if ( ! is_array( $item ) || ! isset( $item[2] ) ) {
				continue;
			}

			$item_slug = $item[2];
			$item_title = $item[0];

			if ( is_numeric( strpos( $item_title, '<' ) ) && ! is_numeric( strpos( $item_title, 'count-0' ) ) ) {
				continue;
			}

			if ( is_numeric( strpos( $item_slug, 'edit.php' ) ) ) {
				$post_type = explode( 'post_type=', $item_slug );
				$post_type = isset( $post_type[1] ) ? $post_type[1] : 'post';
				$transient = get_transient( 'space-posttype-count' );
				$transient = is_array( $transient ) ? $transient : array();
				if ( isset( $transient[ $post_type ][ get_current_user_id() ] ) ) {
					$post_count = $transient[ $post_type ][ get_current_user_id() ];
				}
				else {

					$post_type_object = get_post_type_object( $post_type );
					if ( ! current_user_can( $post_type_object->cap->edit_others_posts ) ) {

						global $wpdb;
						$exclude_states = get_post_stati( array(
							'show_in_admin_all_list' => false
						) );
						$post_count = intval( $wpdb->get_var( $wpdb->prepare( "
							SELECT COUNT( 1 )
							FROM $wpdb->posts
							WHERE post_type = %s
							AND post_status NOT IN ( '" . implode( "','", $exclude_states ) . "' )
							AND post_author = %d
						", $post_type, get_current_user_id() ) ) );

					}
					else {
						$post_count = wp_count_posts( $post_type );
						$post_count = $post_count->publish;
					}

					$transient[ $post_type ][ get_current_user_id() ] = $post_count;
					set_transient( 'space-posttype-count', $transient, WEEK_IN_SECONDS );

				}
			}

			else if ( $item_slug == 'upload.php' ) {
				$transient = get_transient( 'space-media-count' );
				if ( $transient ) {
					$post_count = $transient;
				}
				else {
					$post_count = wp_count_posts( 'attachment' );
					$post_count = $post_count->inherit;
					set_transient( 'space-media-count', $post_count, WEEK_IN_SECONDS );
				}
			}

			else if ( $item_slug == 'edit-comments.php' ) {
				$post_count = wp_count_comments();
				$post_count = $post_count->total_comments;
			}

			else if ( $item_slug == 'users.php' ) {
				if ( is_multisite() && is_network_admin() ) {
					$post_count = get_sitestats();
					if ( ! isset( $post_count['users'] ) ) {
						continue;
					}
					$post_count = $post_count['users'];
				}
				else {
					$transient = get_transient( 'space-user-count' );
					if ( $transient ) {
						$post_count = $transient;
					}
					else {
						$post_count = count_users();
						$post_count = $post_count['total_users'];
						set_transient( 'space-user-count', $post_count, WEEK_IN_SECONDS );
					}
				}
			}

			else if ( $item_slug == 'plugins.php' ) {
				$post_count = get_transient( 'plugin_slugs' );
				if ( $post_count == false ) {
					$post_count = array_keys( get_plugins() );
					set_transient( 'plugin_slugs', $post_count, DAY_IN_SECONDS );
				}
				$post_count = count( $post_count );
			}

			else if ( is_multisite() && is_network_admin() && $item_slug == 'themes.php' ) {
				$post_count = get_site_transient( 'update_themes' );
				if ( ! $post_count || ! isset( $post_count->checked ) ) {
					continue;
				}
				$post_count = count( $post_count->checked );
			}

			else if ( is_multisite() && is_network_admin() && $item_slug == 'sites.php' ) {
				$post_count = get_sitestats();
				if ( ! isset( $post_count['blogs'] ) ) {
					continue;
				}
				$post_count = $post_count['blogs'];
			}

			else {
				continue;
			}

			$post_count_display = $post_count > 999 ? '999+' : $post_count;
			$menu[ $item_key ][0] .= '<span class="space-menu-number" title="' . esc_attr( $post_count . ' ' . $item_title ) . '">' . $post_count_display . '</span>';

		}

	}

	static function action_reset_posttype_counters( $post_id ) {

		if ( ! Space_Options::get_saved_option( 'enable-menu-counters' ) ) {
			return;
		}

		$post_type = get_post_type( $post_id );
		$transient = get_transient( 'space-posttype-count' );
		$transient = is_array( $transient ) ? $transient : array();
		$transient[ $post_type ] = array();
		set_transient( 'space-posttype-count', $transient, WEEK_IN_SECONDS );

	}

	static function action_reset_media_counters( $attachment_id ) {

		if ( ! Space_Options::get_saved_option( 'enable-menu-counters' ) ) {
			return;
		}

		delete_transient( 'space-media-count' );

	}

	static function action_reset_user_counters( $user_id ) {

		if ( ! Space_Options::get_saved_option( 'enable-menu-counters' ) ) {
			return;
		}

		delete_transient( 'space-user-count' );

	}

}
?>
