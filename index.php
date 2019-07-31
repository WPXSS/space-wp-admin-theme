<?php
/*
Plugin Name: 🚀 Space Admin Theme
Plugin URI: https://pluginsbay.com/wp-admin-themes/
Description: WordPress admin theme that brings a nice and modern look to your wp-admin. Change is good! :)
Version: 1.0.5
Author: Stefan Pejcic
Author URI: https://pluginsbay.com/wp-admin-themes/
*/

defined( 'ABSPATH' ) || die();

include( plugin_dir_path( __FILE__ ) . 'inc/recursive.php' );
include( plugin_dir_path( __FILE__ ) . 'setup.php' );
include( plugin_dir_path( __FILE__ ) . 'class.php' );
include( plugin_dir_path( __FILE__ ) . 'options.php' );
include( plugin_dir_path( __FILE__ ) . 'dashboard.php' );
include( plugin_dir_path( __FILE__ ) . 'topbar.php' );
include( plugin_dir_path( __FILE__ ) . 'pages.php' );
include( plugin_dir_path( __FILE__ ) . 'menu.php' );
include( plugin_dir_path( __FILE__ ) . 'menus.php' );
include( plugin_dir_path( __FILE__ ) . 'widgets.php' );
include( plugin_dir_path( __FILE__ ) . 'columns.php' );
include( plugin_dir_path( __FILE__ ) . 'users.php' );
include( plugin_dir_path( __FILE__ ) . 'errors.php' );

function admin_style() {
    wp_enqueue_style( 'fm_admin_style', plugins_url("css/admin_style.css",__FILE__) );
}

add_action( 'admin_enqueue_scripts', 'admin_style' );

add_action( 'admin_enqueue_scripts', array( 'Space_Setup', 'action_enqueue_admin_scripts' ) );
add_action( 'login_enqueue_scripts', array( 'Space_Setup', 'action_enqueue_login_styles' ) );
add_action( 'login_enqueue_scripts', array( 'Space_Setup', 'action_enqueue_login_scripts' ) );
add_filter( 'plugin_action_links', array( 'Space_Setup', 'filter_add_plugin_options_link' ), 10, 2 );
add_filter( 'login_body_class', array( 'Space_Setup', 'filter_add_body_classes' ) );
add_action( 'login_enqueue_scripts', array( 'Space_Setup', 'action_enqueue_login_fonts' ) );
add_action( 'plugins_loaded', array( 'Space_Setup', 'action_prepare_translations' ) );
add_action( 'init', 'space_init_setup' );
function space_init_setup() {
	if ( Space::is_enabled() ) {
		add_action( 'admin_enqueue_scripts', array( 'Space_Setup', 'action_enqueue_admin_styles' ) );
		add_filter( 'body_class', array( 'Space_Setup', 'filter_add_body_classes' ) );
		add_filter( 'admin_body_class', array( 'Space_Setup', 'filter_add_body_classes' ), 11 );
		add_action( 'wp_enqueue_scripts', array( 'Space_Setup', 'action_dequeue_fonts' ) );
		add_action( 'admin_enqueue_scripts', array( 'Space_Setup', 'action_enqueue_admin_fonts' ) );
		add_action( 'admin_init', array( 'Space_Setup', 'action_enqueue_editor_styles' ) );
		add_filter( 'all_plugins', array( 'Space_Setup', 'filter_trim_plugin_list' ) );
		add_filter( 'post_date_column_time', array( 'Space_Setup', 'filter_post_table_date_format' ), 10, 4 );
	}
}

add_action( 'admin_init', array( 'Space_Options', 'action_register_settings_and_fields' ) );
add_action( 'network_admin_edit_space_options', array( 'Space_Options', 'action_network_option_save' ) );
add_filter( 'login_headerurl', array( 'Space', 'filter_change_login_logo_link' ) );
add_filter( 'login_headertitle', array( 'Space', 'filter_change_login_logo_title' ) );
add_action( 'login_head', array( 'Space', 'action_change_login_logo' ) );
add_filter( 'login_errors', array( 'Space', 'filter_login_errors' ) );
add_action( 'init', 'space_init_general' );
function space_init_general() {
	if ( Space::is_enabled() ) {

		Space::action_hide_updates();
		Space::action_hide_screen_options();
		add_action( 'admin_head', array( 'Space', 'action_hide_help' ) );
	}
}

add_action( 'init', 'space_init_widgets' );
function space_init_widgets() {
	if ( Space::is_enabled() ) {
		add_action( 'wp_dashboard_setup', array( 'Space_Dashboard', 'action_add_dashboard_widgets' ) );
		add_action( 'wp_network_dashboard_setup', array( 'Space_Dashboard', 'action_add_network_dashboard_widgets' ) );
		add_action( 'do_meta_boxes', array( 'Space_Admin_Widget_Manager', 'action_remove_metaboxes' ) );
	}
}

add_action( 'init', 'space_init_columns' );
function space_init_columns() {
	if ( Space::is_enabled() ) {
		add_filter( 'manage_post_posts_columns', array( 'Space_Admin_Column_Manager', 'filter_remove_posts_columns' ), 11 ); // 11 for Yoast columns
		add_filter( 'manage_page_posts_columns', array( 'Space_Admin_Column_Manager', 'filter_remove_pages_columns' ), 11 ); // 11 for Yoast columns
		add_filter( 'manage_users_columns', array( 'Space_Admin_Column_Manager', 'filter_remove_users_columns' ) );
		add_filter( 'manage_media_columns', array( 'Space_Admin_Column_Manager', 'filter_remove_media_columns' ) );
		add_filter( 'manage_product_posts_columns', array( 'Space_Admin_Column_Manager', 'filter_remove_woocommerce_product_columns' ), 11 );
		add_filter( 'manage_shop_order_posts_columns', array( 'Space_Admin_Column_Manager', 'filter_remove_woocommerce_order_columns' ), 11 );
		add_filter( 'manage_shop_coupon_posts_columns', array( 'Space_Admin_Column_Manager', 'filter_remove_woocommerce_coupon_columns' ), 11 );
	}
}

add_action( 'init', array( 'Space_Admin_Menu_Editor', 'action_prepare_menu_changes' ) );
add_action( 'admin_menu', array( 'Space_Menu', 'action_add_space_menu_entries' ), apply_filters( 'space-admin-menu-hook-prio', 20000 ) - 1 );
add_action( 'admin_menu', array( 'Space_Admin_Menu_Editor', 'action_gather_admin_menu' ), apply_filters( 'space-admin-menu-hook-prio', 20000 ) + 1 );
add_filter( 'menu_order', array( 'Space_Admin_Menu_Editor', 'filter_apply_custom_menu_order' ), apply_filters( 'space-admin-menu-hook-prio', 20000 ) + 2 );
add_action( 'admin_menu', array( 'Space_Admin_Menu_Editor', 'action_apply_custom_menu_removal' ), apply_filters( 'space-admin-menu-hook-prio', 20000 ) + 3 );
add_action( 'admin_menu', array( 'Space_Admin_Menu_Editor', 'action_apply_custom_menu_unremoval' ), apply_filters( 'space-admin-menu-hook-prio', 20000 ) + 3 );
add_action( 'admin_menu', array( 'Space_Admin_Menu_Editor', 'action_apply_custom_menu_renaming' ), apply_filters( 'space-admin-menu-hook-prio', 20000 ) );
add_action( 'save_post', array( 'Space_Menu', 'action_reset_posttype_counters' ) );
add_action( 'add_attachment', array( 'Space_Menu', 'action_reset_media_counters' ) );
add_action( 'delete_attachment', array( 'Space_Menu', 'action_reset_media_counters' ) );
add_action( 'user_register', array( 'Space_Menu', 'action_reset_user_counters' ) );
add_action( 'delete_user', array( 'Space_Menu', 'action_reset_user_counters' ) );
add_action( 'init', 'space_init_menu' );
function space_init_menu() {
	if ( Space::is_enabled() ) {
		add_filter( 'parent_file', array( 'Space_Menu', 'filter_admin_menu_active_states' ) );
		add_filter( 'custom_menu_order', '__return_true' );
		add_action( 'admin_menu', array( 'Space_Menu', 'action_add_menu_entries' ), apply_filters( 'space-admin-menu-hook-prio', 20000 ) - 1 );
		add_action( ( defined( 'AME_ROOT_DIR' ) ? 'admin_menu' : 'admin_init' ), array( 'Space_Menu', 'action_apply_relinks' ), apply_filters( 'space-admin-menu-hook-prio', 20000 ) );
		add_action( 'admin_head', array( 'Space_Menu', 'action_add_numbers' ) );
		add_action( 'network_admin_menu', array( 'Space_Menu', 'action_add_network_menu_entries' ) );
		add_action( 'network_admin_menu', array( 'Space_Menu', 'action_add_numbers' ) );
	}
}

add_action( 'init', 'space_init_toolbar' );
function space_init_toolbar() {
	if ( Space::is_enabled() ) {
		add_action( 'admin_bar_menu', array( 'Space_Toolbar', 'action_add_toolbar_nodes_sooner' ), 0 );
		add_action( 'admin_bar_menu', array( 'Space_Toolbar', 'action_add_toolbar_nodes_later' ) );
		add_action( 'admin_bar_menu', array( 'Space_Toolbar', 'action_remove_toolbar_nodes' ), 999 );
		Space_Toolbar::action_hide_toolbar();
		add_action( 'wp_enqueue_scripts', array( 'Space_Toolbar', 'action_enqueue_site_toolbar_styles' ) );
		add_filter( 'admin_bar_menu', array( 'Space_Toolbar', 'filter_user_greeting' ) );
		Space_Toolbar::action_remove_toolbar_css_injection();
	}
}

add_action( 'wp_ajax_space-get-export', array( 'Space_Options', 'get_export' ) );

register_uninstall_hook( __FILE__, array( 'Space_Setup', 'action_uninstall' ) );

add_action( 'init', 'space_init_errors' );
function space_init_errors() {
	if ( Space::is_enabled() ) {
		Space_Error_Handler::action_collect_php_errors();
		add_action( 'all_admin_notices', array( 'Space_Error_Handler', 'action_output_php_errors' ) );
	}
}



