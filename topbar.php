<?php
/*
 * top-bar
 */

class Space_Toolbar {
	static function action_enqueue_site_toolbar_styles() {
		if ( is_admin_bar_showing() && Space::is_themed() ) {
			wp_enqueue_style( 'space-toolbar-css', plugins_url( 'css/topbar.min.css', __FILE__ ), array(), null );
			// Elementor
			if ( defined( 'ELEMENTOR_VERSION' ) ) {
				wp_enqueue_style( 'space-plugin-support-css-elementor', plugins_url( 'css/plugin/space-elementor.min.css', __FILE__ ), array(), null );
			}

		}

	}

	static function action_add_toolbar_nodes_sooner( $wp_toolbar ) {
		if ( ! Space::is_themed() ) {
			return;
		}

		if ( ! is_admin() && current_user_can( 'read' ) ) {
			$wp_toolbar->add_node(
				array(
					'id' => 'space-admin',
					'title' => Space_Options::get_saved_option( 'admin-dashboard-title' ),
					'href' => admin_url()
				)
			);
		}

		if ( Space::is_themed() ) {
			$html = '<a href="' . esc_url( admin_url( 'profile.php' ) ) . '">' . Space_User::get_full_name() . '</a>';
			$html .= '<span class="space-toolbar-user-role">' . Space_User::get_user_role_display() . '</span>';
			$wp_toolbar->add_node(
				array(
					'id' => 'space-username',
					'title' => $html,
					'parent' => 'user-actions'
				)
			);
		}

	}

	static function action_add_toolbar_nodes_later( $wp_toolbar ) {

		if ( Space_Options::get_saved_option( 'enable-notification-center' ) && is_admin() && ! wp_is_mobile() ) {
			$wp_toolbar->add_node( array(
				'id' => 'space-notification-center',
				'title' => '<span class="dashicons dashicons-marker"></span> <span class="space-notification-count">0</a>',
				'parent' => 'top-secondary'
			) );
			$wp_toolbar->add_menu( array(
				'id' => 'space-notification-center-dummy',
				'parent' => 'space-notification-center',
				'title' => ''
			) );
		}

	}

	static function action_remove_toolbar_nodes( $wp_toolbar ) {
		// HIDE wp logo
		$wp_toolbar->remove_node( 'wp-logo' );

		// updates
		if ( Space_Options::get_saved_option( 'hide-toolbar-updates' ) ) {
			$wp_toolbar->remove_node( 'updates' );
		}

		// comments
		if ( Space_Options::get_saved_option( 'hide-toolbar-comments' ) ) {
			$wp_toolbar->remove_node( 'comments' );
		}

		// view post
		if ( Space_Options::get_saved_option( 'hide-toolbar-view-posts' ) ) {
			$wp_toolbar->remove_node( 'archive' );
		}

		// new dropdown
		if ( Space_Options::get_saved_option( 'hide-toolbar-new' ) ) {
			$wp_toolbar->remove_node( 'new-content' );
		}

		// search
		if ( Space_Options::get_saved_option( 'hide-toolbar-search' ) ) {
			$wp_toolbar->remove_node( 'search' );
		}

		// customize
		if ( Space_Options::get_saved_option( 'hide-toolbar-customize' ) ) {
			$wp_toolbar->remove_node( 'customize' );
		}

		// multisite
		if ( Space_Options::get_saved_option( 'hide-toolbar-mysites' ) ) {
			$wp_toolbar->remove_node( 'my-sites' );
		}

		if ( ! Space::is_themed() ) {
			return;
		}

		// site name
		$wp_toolbar->remove_node( 'site-name' );

		// user
		if ( Space::is_themed() ) {
			$wp_toolbar->remove_node( 'user-info' );
		}
		$wp_toolbar->remove_node( 'edit-profile' );

	}

	static function action_hide_toolbar() {

		if ( is_admin() ) {
			return;
		}

		if ( Space_Options::get_saved_option( 'hide-front-admin-toolbar' ) ) {
			show_admin_bar( false );
		}

	}

	// css
	static function action_remove_toolbar_css_injection() {
		if ( Space::is_themed() ) {
			add_theme_support( 'admin-bar', array( 'callback' => '__return_false' ) );
		}

	}

	static function filter_user_greeting( $wp_toolbar ) {

		$node = $wp_toolbar->get_node('my-account');
		$user = wp_get_current_user();

		if ( Space::is_themed() ) {
			$new_title = get_avatar( get_current_user_id(), '42' );
		}

		if ( ! Space::is_themed() ) {
			$full_name = Space_User::get_full_name( $user );
			$new_title = str_replace( 'Howdy, ', '', $node->title );
			$new_title = str_replace( $user->display_name, $full_name, $new_title );
		}

		$wp_toolbar->add_node(
			array(
				'id' => 'my-account',
				'title' => $new_title
			)
		);

	}

}
?>
