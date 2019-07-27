<?php
/*
 * users
 */

class Space_User {
	static function get_all_roles( $all = false ) {
		$roles = $all ? wp_roles()->roles : get_editable_roles();
		foreach ( $roles as $key => $role ) {
			$roles[ $key ]['slug'] = $key;
		}

		if ( is_multisite() ) {
			$roles = array_reverse( $roles );
			$roles['super'] = array(
				'slug' => 'super',
				'name' => _x( 'Network Administrator', 'User role', 'space' ),
				'capabilities' => $roles['administrator']['capabilities']
			);
			$roles = array_reverse( $roles );
		}
		return $roles;

	}
	static function get_user_role( $user_id = 0, $multiple = false ) {
		if ( ! $user_id ) {
			$user_id = get_current_user_id();
		}
		if ( ! $user_id || ! is_numeric( $user_id ) ) {
			return null;
		}

		if ( is_multisite() && is_super_admin( $user_id ) ) {
			if ( $multiple ) {
				return array( 'super' );
			}
			else {
				return 'super';
			}
		}
		$user = new WP_User( $user_id );
		if ( $user === false ) {
			return null;
		}
		$role = $user->roles;
		if ( $multiple ) {
			return is_array( $role ) ? $role : array( $role );
		}
		else {
			return is_array( $role ) ? array_shift( $role ) : $role;
		}

	}

	static function get_user_role_display( $user_id = 0 ) {
		if ( ! $user_id ) {
			$user_id = get_current_user_id();
		}
		if ( ! $user_id || ! is_numeric( $user_id ) ) {
			return '';
		}
		if ( is_multisite() && is_super_admin( $user_id ) ) {
			return _x( 'Network Administrator', 'User role', 'space' );
		}
		global $wp_roles;
		$role_names = array();
		foreach ( self::get_user_role( $user_id, 'multiple' ) as $role_slug ) {
			$role_names[] = isset( $wp_roles->roles[ $role_slug ]['name'] ) ? translate_user_role( $wp_roles->roles[ $role_slug ]['name'] ) : ucfirst( $role_slug );
		}
		return implode( ', ', $role_names );

	}

	static function get_full_name( $user_object = false ) {

		if ( ! $user_object ) {
			$user_object = wp_get_current_user();
		}
		if ( $user_object->first_name && $user_object->last_name ) {
			return $user_object->first_name . ' ' . $user_object->last_name;
		}
		else if ( $user_object->first_name || $user_object->last_name ) {
			return $user_object->first_name . $user_object->last_name;
		}
		else {
			return $user_object->display_name;
		}

	}

	static function get_admin_cap() {

		if ( is_multisite() && Space_Options::get_saved_network_option( 'network-admins-only' ) ) {
			return apply_filters( 'space-super-admin-cap', 'manage_network_options' );
		}
		//return apply_filters( 'space-admin-cap', 'edit_theme_options' );
		return apply_filters( 'space-admin-cap', 'manage_options' );

	}
	static function is_admin() {
		return current_user_can( self::get_admin_cap() );
	}

}
?>
