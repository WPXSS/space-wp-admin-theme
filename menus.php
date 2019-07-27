<?php
/*
* MENUS
*/

class Space_Admin_Menu_Editor {

	static $main_menus = array();
	static $sub_menus = array();
	static $new_order = array();
	static $unremove_items = array();
	static $remove_items = array();
	static $saved_customizations = array();
	static $admin_locked = array(
		'tools.php',
		'submenu-space-options-general',
		'submenu-space-admin-menu-editor'
	);
	static $title_locked = array(
		'space-menu-collapse',
		'separator1',
		'separator2',
		'separator-last',
		'separator-woocommerce'
	);

	// original
	static function action_gather_admin_menu() {
		if ( isset( $_GET['page'] ) && $_GET['page'] == 'space-admin-menu-editor' ) {

			global $menu;
			global $submenu;

			$hidden_pages = array();
			foreach ( Space_Pages::get_pages() as $space_page ) {
				if ( ! $space_page['in-menu'] ) {
					$hidden_pages[] = $space_page['slug'];
				}
			}

			ksort( $menu );
			foreach ( $menu as $position => $mainmenu_item ) {

				if ( ! isset( $mainmenu_item[2] ) ) {
					continue;
				}

				if ( isset( $mainmenu_item[1] ) && $mainmenu_item[1] == 'manage_links' && isset( $mainmenu_item[5] ) && $mainmenu_item[5] == 'menu-links' ) {
					continue;
				}

				self::$main_menus[ $mainmenu_item[2] ] = $mainmenu_item;

			}

			self::$main_menus['profile.php'] = array(
				__( 'Profile' ),
				'!manage_options',
				'profile.php',
				'',
				'menu-top menu-icon-users',
				'menu-users',
				'dashicons-admin-users'
			);

			foreach ( $submenu as $mainmenu_slug => $submenu_items ) {

				foreach ( $submenu_items as $submenu_item_key => $submenu_item ) {

					if ( in_array( $submenu_item[2], $hidden_pages ) ) {
						unset( $submenu_items[ $submenu_item_key ] );
					}

				}

				self::$sub_menus[ $mainmenu_slug ] = $submenu_items;

			}

		}

	}

	// html
	static function print_menu_editor() {

		$view_site_button_url = apply_filters( 'space-view-site-button-url', home_url() );

		// sorting
		$customizations = self::get_menu_customizations();
		if ( is_null( $customizations ) ) {
			$main_menus_ordered = self::$main_menus;
		}
		else {
			$unused_main_menus = self::$main_menus;
			foreach ( $customizations as $key => $value ) {

				if ( $key == $view_site_button_url . '[slug]' && isset( self::$main_menus[ 'space-view-site' ] ) ) {
					if ( isset( self::$main_menus[ 'space-view-site-logo' ] ) ) {
						$main_menus_ordered[] = self::$main_menus[ 'space-view-site-logo' ];
						unset( $unused_main_menus[ 'space-view-site-logo' ] );
					}
					$main_menus_ordered[] = self::$main_menus[ 'space-view-site' ];
					unset( $unused_main_menus[ 'space-view-site' ] );
				}

				else if ( $key == 'space-view-site[slug]' && ! isset( self::$main_menus[ 'space-view-site'] ) && isset( self::$main_menus[ 'space-view-site-logo'] ) ) {
					$main_menus_ordered[] = self::$main_menus[ 'space-view-site-logo' ];
					unset( $unused_main_menus[ $value ] );
				}

				else if ( $key == 'space-view-site-logo[slug]' && ! isset( self::$main_menus[ 'space-view-site-logo'] ) && isset( self::$main_menus[ 'space-view-site'] ) ) {
					$main_menus_ordered[] = self::$main_menus[ 'space-view-site' ];
					unset( $unused_main_menus[ $value ] );
				}

				else if ( in_array( $key, array( 'space-view-site[slug]', 'space-view-site-logo[slug]' ) ) && ( ! isset( $customizations['space-view-site[slug]'] ) || ! isset( $customizations['space-view-site-logo[slug]'] ) ) && ( isset( self::$main_menus['space-view-site'] ) && isset( self::$main_menus['space-view-site'] ) ) ) {
					$main_menus_ordered[] = self::$main_menus[ 'space-view-site-logo' ];
					$main_menus_ordered[] = self::$main_menus[ 'space-view-site' ];
					unset( $unused_main_menus[ $value ] );
				}

				else if ( $key == $value . '[slug]' && isset( self::$main_menus[ $value ] ) ) {
					$main_menus_ordered[] = self::$main_menus[ $value ];
					unset( $unused_main_menus[ $value ] );
				}

			}
			foreach ( $unused_main_menus as $new_main_menu_slug => $new_main_menu_item ) {

				$main_menus_ordered[] = $new_main_menu_item;

			}

		}

		?>
		
		
		
		<ul class="space-admin-menu-editor space-admin-menu-editor-mainmenu">
			<?php
			foreach ( $main_menus_ordered as $mainmenu_item ) {
				$mainmenu_item_slug = $mainmenu_item[2];
				?>
				<li class="space-admin-menu-editor-item">
					<?php self::print_menu_editor_item( $mainmenu_item ); ?>

					<?php // Submenu ?>
					<?php if ( isset( self::$sub_menus[ $mainmenu_item_slug ] ) && count( self::$sub_menus[ $mainmenu_item_slug ] ) ) { ?>
						<ul class="space-admin-menu-editor space-admin-menu-editor-submenu">
							<?php foreach ( self::$sub_menus[ $mainmenu_item_slug ] as $submenu_item ) { ?>
								<li class="space-admin-menu-editor-item">
									<?php self::print_menu_editor_item( $submenu_item, $mainmenu_item_slug ); ?>
								</li>
							<?php } ?>
						</ul>
					<?php } ?>

				</li>
				<?php
			}
			?>
		</ul>
		<?php

	}

	// html single
	static function print_menu_editor_item( $item_info, $mainmenu_item_slug = '' ) {

		

		$slug = $item_info[2];
		$customizations = self::get_menu_customizations();
		$name_prefix = $mainmenu_item_slug ? 'submenu-' . $slug : $slug;
		$array_key = $mainmenu_item_slug ? 'submenu-' . $slug : $slug;
		$array_key = str_replace( '&amp;', '&', $array_key );
		$title_data = is_numeric( strpos( $item_info[0], '<' ) ) ? trim( substr( $item_info[0], 0, strpos( $item_info[0], '<' ) ) ) : $item_info[0];
		$saved_title = isset( $customizations[ $array_key . '[title]' ] ) ? $customizations[ $array_key . '[title]' ] : '';
		$title_show = $saved_title ? $saved_title : ( $title_data ? $title_data : ( $item_info[3] ? $item_info[3] : _x( '(separator)', 'Item name in the admin menu editor', 'space' ) ) );
		$placeholder = $title_data != $saved_title ? $title_data : ( isset( $item_info[3] ) && $item_info[3] ? $item_info[3] : '' );
		$capability = $item_info[1];
		$icon = isset( $item_info[5] ) ? $item_info[5] : '';

		?>

	<div id="poststuff">

		<div id="post-body" class="metabox-holder columns-2">

			<div id="post-body-content">

				<div class="meta-box-sortables ui-sortable">

					<div class="postbox">

						<div class="space-admin-menu-editor-item-caption">
				<h2><span class="dashicons dashicons-menu-alt3"></span> <?php if ( ! $mainmenu_item_slug ) { ?>
				<?php } ?>
				<span class="space-admin-menu-editor-title-show"><?php echo $title_show; ?></span></h2>
			</div>
						<div class="inside">


			<div class="space-admin-menu-editor-item-settings">

				<input type="hidden" name="<?php echo esc_attr( $name_prefix . '[slug]' ); ?>" value="<?php echo esc_attr( $slug ); ?>">
				<?php if ( $mainmenu_item_slug ) { ?>
					<input type="hidden" name="<?php echo esc_attr( $name_prefix . '[parent]' ); ?>" value="<?php echo esc_attr( $mainmenu_item_slug ); ?>">
				<?php } ?>

				<?php if ( ! in_array( $array_key, self::$title_locked ) ) { ?>
					<div class="space-admin-menu-editor-form-title">
						<label class="space-admin-menu-editor-form-label" for="<?php echo esc_attr( $name_prefix . '[title]' ); ?>"><?php _e( 'Rename', 'space' ); ?></label>
						<input type="text" style="width:250px;" id="<?php echo esc_attr( $name_prefix . '[title]' ); ?>" name="<?php echo esc_attr( $name_prefix . '[title]' ); ?>" value="<?php echo esc_attr( $saved_title ); ?>" placeholder="<?php echo esc_attr( $placeholder ); ?>">
					<br>
					</div>
				<?php } ?>

				<div class="space-admin-menu-editor-form-roles">
					<br>
					<span class="space-admin-menu-editor-form-label"><?php _e( 'Show to ', 'space' ); ?></span>
					<!-- check <php // check ?>-->
					<?php foreach ( Space_User::get_all_roles() as $role ) {

						$field_id = $name_prefix . '_role_' . $role['slug'];
						$saved_role_value = null;
						$role_default = 1;
						$role_disabled = false;

						if ( Space_User::is_admin() && ( ( ! is_multisite() && $role['slug'] == 'administrator' ) || $role['slug'] == 'super' ) && current_user_can( $capability ) ) {
							$role_default = 1;
						}
						else if ( ! array_key_exists( $capability, $role['capabilities'] ) ) {
							$role_default = 0;
							//$role_disabled = true;
							//$saved_role_value = 0;
						}
						if ( strpos( $capability, '!' ) > -1 && ! array_key_exists( str_replace( '!', '', $capability ), $role['capabilities'] ) ) {
							$role_default = 1;
						}
						if ( $role['slug'] == 'super' && ! is_super_admin() ) {
							$role_disabled = true;
						}
						if ( Space_User::is_admin() && ( ( ! is_multisite() && $role['slug'] == 'administrator' ) || $role['slug'] == 'super' ) && in_array( $name_prefix, self::$admin_locked ) ) {
							$role_disabled = true;
							$saved_role_value = 1;
						}

						if ( is_null( $saved_role_value ) ) {
							$saved_role_value = isset( $customizations[ $array_key . '[roles][' . $role['slug'] . ']' ] ) ? $customizations[ $array_key . '[roles][' . $role['slug'] . ']' ] : $role_default;
						}
						?>

						<label class="<?php if ( $role_disabled ) { echo 'form-label-disabled'; } ?>" for="<?php echo esc_attr( $field_id ); ?>">
							<input type="checkbox" id="<?php echo esc_attr( $field_id ); ?>" name="<?php echo esc_attr( $name_prefix . '[roles][' . $role['slug'] . ']' ); ?>" value="1" <?php checked( $saved_role_value ); ?> <?php disabled( $role_disabled ); ?>>
							<?php echo $role['name']; ?>
						</label>

					<?php } ?>
				</div>

			</div>
						</div>
						<!-- .inside -->

					</div>
					<!-- .postbox -->

				</div>
				<!-- .meta-box-sortables .ui-sortable -->

			</div>
			<!-- post-body-content -->

			<!-- sidebar -->
			
			<!-- #postbox-container-1 .postbox-container -->

		</div>
		<!-- #post-body .metabox-holder .columns-2 -->

		<br class="clear">
	</div>
	<!-- #poststuff -->

		<?php

	}

	// data
	static function get_menu_customizations() {

		if ( empty( self::$saved_customizations ) ) {

			$customizations = Space_Options::get_saved_option( 'admin-menu' );

			if ( ! $customizations ) {
				self::$saved_customizations = null;
			}
			else {
				$saved_customizations = json_decode( $customizations, true );

				foreach ( $saved_customizations as $key_value_pair ) {
					self::$saved_customizations[ $key_value_pair['name'] ] = $key_value_pair['value'];
				}
			}

		}

		return self::$saved_customizations;

	}

	static function action_prepare_menu_changes() {

		if ( Space_Options::get_saved_network_option( 'disable-admin-menu-editor-tool' ) || ! Space_Options::get_saved_option( 'enable-admin-menu-editor-tool' ) ) {
			return;
		}

		$customizations = self::get_menu_customizations();
		if ( is_null( $customizations ) ) {
			return;
		}

		foreach ( $customizations as $key => $value ) {
			if ( ! in_array( $key, array( $value . '[slug]', 'submenu-' . $value . '[slug]' ) ) ) {
				continue;
			}

			$is_submenu = $key === 'submenu-' . $value . '[slug]';
			$slug = $is_submenu ? 'submenu-' . $value : $value;
			$parent = $is_submenu && isset( $customizations[ $slug . '[parent]' ] ) ? $customizations[ $slug . '[parent]' ] : false;
			$hide = isset( $customizations[ $slug . '[roles][' . Space_User::get_user_role() . ']' ] ) && ! $customizations[ $slug . '[roles][' . Space_User::get_user_role() . ']' ];

			if ( ! $is_submenu ) {
				if ( $slug == 'space-view-site' && ! isset( $customizations[ 'space-view-site-logo[slug]'] ) ) {
					self::$new_order[] = 'space-view-site-logo';
				}

				if ( $slug == apply_filters( 'space-view-site-button-url', home_url() ) ) {
					self::$new_order[] = 'space-view-site-logo';
					$slug = 'space-view-site';
				}

				self::$new_order[] = $slug;

				if ( $slug == 'space-view-site-logo' && ! isset( $customizations[ 'space-view-site[slug]'] ) ) {
					self::$new_order[] = 'space-view-site';
				}

			}

			if ( $hide ) {
				self::$remove_items[] = array(
					'slug' => $value,
					'parent' => $parent
				);
			}

			else {
				self::$unremove_items[] = $value;
			}

		}

	}

	static function filter_apply_custom_menu_order( $order ) {
		if ( Space_Options::get_saved_network_option( 'disable-admin-menu-editor-tool' ) || ! Space_Options::get_saved_option( 'enable-admin-menu-editor-tool' ) ) {
			return $order;
		}

		if ( ! empty( self::$new_order ) ) {

			$original_order = $order;
			$order = self::$new_order;

			if ( in_array( 'vc-welcome', $original_order ) && in_array( 'vc-general', $order ) ) {
				foreach( $order as $key => $item ) {
					if ( $item == 'vc-general' ) {
						$order[ $key ] = 'vc-welcome';
					}
				}
			}

		}

		return $order;

	}

	static function action_apply_custom_menu_removal() {
		if ( Space_Options::get_saved_network_option( 'disable-admin-menu-editor-tool' ) || ! Space_Options::get_saved_option( 'enable-admin-menu-editor-tool' ) ) {
			return;
		}

		// remove links
		if ( ! current_user_can( 'manage_links' ) ) {
			remove_menu_page( 'link-manager.php' ); // In case of non-admin role
			remove_menu_page( 'edit-tags.php?taxonomy=link_category' ); // Admin role
		}

		if ( empty( self::$remove_items ) ) {
			return;
		}

		foreach ( self::$remove_items as $args ) {
			if ( $args['parent'] ) {

				$startswith = 'customize.php';
				if ( $args['parent'] == 'themes.php' && substr( $args['slug'], 0, strlen( $startswith ) ) == $startswith ) {
					$args['slug'] = add_query_arg( 'return', urlencode( wp_unslash( $_SERVER['REQUEST_URI'] ) ), 'customize.php' );
				}

				$result = remove_submenu_page( $args['parent'], $args['slug'] );
				if ( ! $result ) {
					remove_submenu_page( $args['parent'], str_replace( '&', '&amp;', $args['slug'] ) );
				}

			}

			else {
				remove_menu_page( $args['slug'] );
			}

			// 1. VisualComposer
			if ( ! $args['parent'] && $args['slug'] == 'vc-general' ) {
				remove_menu_page( 'vc-welcome' );
			}

			// 2. Elementor
			if ( ! $args['parent'] && $args['slug'] == 'elementor' ) {
				error_log( print_r( 'chk1', true ) );
				remove_menu_page( 'edit.php?post_type=elementor_library' );
			}

		}

	}

	static function action_apply_custom_menu_unremoval() {

		if ( Space_Options::get_saved_network_option( 'disable-admin-menu-editor-tool' ) || ! Space_Options::get_saved_option( 'enable-admin-menu-editor-tool' ) ) {
			return;
		}

		if ( empty( self::$unremove_items ) ) {
			return;
		}

		global $menu;
		global $submenu;
		foreach ( self::$unremove_items as $item_slug ) {
			foreach ( $menu as $menu_item_key => $menu_item ) {
				if ( isset( $menu_item[2] ) && $menu_item[2] == $item_slug ) {
					$menu[ $menu_item_key ][1] = 'read';
				}
			}
			foreach ( $submenu as $main_menu_item_key => $main_menu_item ) {
				foreach ( $main_menu_item as $menu_item_key => $menu_item ) {
					if ( isset( $menu_item[2] ) && $menu_item[2] == $item_slug ) {
						$submenu[ $main_menu_item_key ][ $menu_item_key ][1] = 'read';
					}
				}
			}
		}

	}

	static function action_apply_custom_menu_renaming() {

		if ( Space_Options::get_saved_network_option( 'disable-admin-menu-editor-tool' ) || ! Space_Options::get_saved_option( 'enable-admin-menu-editor-tool' ) ) {
			return;
		}

		global $menu;
		global $submenu;
		$customizations = self::get_menu_customizations();

		if ( is_null( $customizations ) ) {
			return;
		}

		foreach ( $menu as $mainmenu_key => $mainmenu_item ) {

			if ( isset( $mainmenu_item[2] ) ) {

				$mainmenu_item_slug = $mainmenu_item[2];
				$mainmenu_array_key = $mainmenu_item_slug;
				$mainmenu_array_key = str_replace( '&amp;', '&', $mainmenu_array_key );

				if ( isset( $customizations[ $mainmenu_array_key . '[title]' ] ) && $customizations[ $mainmenu_array_key . '[title]' ] ) {

					if ( ! in_array( $mainmenu_array_key, self::$title_locked ) ) {

						$original = $mainmenu_item[0];
						$original_stripped = is_numeric( strpos( $original, '<' ) ) ? substr( $original, 0, strpos( $original, '<' ) ) : $original;
						$title_stripped = $customizations[ $mainmenu_array_key . '[title]' ];
						$title = str_replace( $original_stripped, $title_stripped, $original );

						// 3. wpml
						/*
						if ( $title_stripped != $original_stripped ) {

							// Register for WPML String Translation
							do_action( 'wpml_register_single_string', 'Admin menu translations', $title_stripped, $title_stripped );

							// Get maybe translated version
							$title = apply_filters( 'wpml_translate_single_string', $title_stripped, 'Admin menu translations', $title_stripped );

						}
						*/

						$menu[ $mainmenu_key ][0] = $title;

					}

				}

			}

			if ( ! isset( $submenu[ $mainmenu_item_slug ] ) ) {
				continue;
			}
			foreach ( $submenu[ $mainmenu_item_slug ] as $submenu_key => $submenu_item ) {

				if ( ! isset( $submenu_item[2] ) ) {
					continue;
				}

				$submenu_item_slug = $submenu_item[2];
				$submenu_array_key = 'submenu-' . $submenu_item_slug;
				$submenu_array_key = str_replace( '&amp;', '&', $submenu_array_key );

				if ( ! isset( $customizations[ $submenu_array_key . '[title]' ] ) || ! $customizations[ $submenu_array_key . '[title]' ] ) {
					continue;
				}

				if ( in_array( $submenu_array_key, self::$title_locked ) ) {
					continue;
				}
				
				$original = $submenu_item[0];
				$original_stripped = is_numeric( strpos( $original, '<' ) ) ? substr( $original, 0, strpos( $original, '<' ) ) : $original;
				$title_stripped = $customizations[ $submenu_array_key . '[title]' ];
				$title = str_replace( $original_stripped, $title_stripped, $original );

				// 4. wpml
				/*
				if ( $title_stripped != $original_stripped ) {
					do_action( 'wpml_register_single_string', 'Admin menu translations', $title_stripped . ' (submenu)', $title_stripped );
					$title = apply_filters( 'wpml_translate_single_string', $title_stripped, 'Admin menu translations', $title_stripped . ' (submenu)' );

				}
				*/
				$submenu[ $mainmenu_item_slug ][ $submenu_key ][0] = $title;

			}

		}

	}

}
?>
