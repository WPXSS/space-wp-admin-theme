<?php
/*
Plugin Name: Space Admin Theme
Plugin URI: https://pluginsbay.com/wp-admin-themes/
Description: Modern looking WordPress admin theme for the dashboard.
Version: 1.0.2
Author: Stefan Pejcic
Author URI: https://pluginsbay.com/wp-admin-themes/
License: GPLv2
*/
/*
 *      Copyright 2015 Northon Torga @Shift Empreendimentos Virtuais <producao@shift.com>
 *
 *      This program is free software; you can redistribute it and/or modify
 *      it under the terms of the GNU General Public License as published by
 *      the Free Software Foundation; either version 3 of the License, or
 *      (at your option) any later version.
 *
 *      This program is distributed in the hope that it will be useful,
 *      but WITHOUT ANY WARRANTY; without even the implied warranty of
 *      MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *      GNU General Public License for more details.
 *
 *      You should have received a copy of the GNU General Public License
 *      along with this program; if not, write to the Free Software
 *      Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 *      MA 02110-1301, USA.
 */
?>
<?php

// LOGIN PAGE
add_action( 'login_enqueue_scripts', 'spacewpat_theme_login' );
function spacewpat_theme_login() {
    wp_enqueue_style( 'spacewpat-login', plugins_url('css/login.css', __FILE__) );
}

add_filter( 'login_headerurl', 'spacewpat_login_url_logo' );
function spacewpat_login_url_logo() {
    return home_url();
}

add_filter( 'login_headertitle', 'spacewpat_login_logo_url_title' );
function spacewpat_login_logo_url_title() {
    return the_title();
}


// WP ADMIN
add_action( 'admin_enqueue_scripts', 'spacewpat_theme_general' );
function spacewpat_theme_general() {
        wp_enqueue_style( 'spacewpat-general', plugins_url('css/general.css', __FILE__) );
}

// WP ADMIN BAR
add_action( 'wp_head', 'spacewpat_theme_bar' );
function spacewpat_theme_bar() {
	if ( is_user_logged_in() ) {
        wp_enqueue_style( 'spacewpat-bar', plugins_url('css/admin-bar.css', __FILE__) );
	}
}
