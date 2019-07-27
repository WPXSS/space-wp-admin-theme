<?php

class Space_Error_Handler {

	static $errors = array();
	static function action_collect_php_errors() {
		if ( ( ! defined( 'WP_DEBUG' ) || ! WP_DEBUG ) || ( defined( 'WP_DEBUG_DISPLAY' ) && ! WP_DEBUG_DISPLAY ) ) {
			return;
		}
		if ( ! is_admin() || Space_Options::get_saved_option( 'disable-cli-error-handling' ) ) {
			return;
		}

		set_error_handler( array( __CLASS__, 'error_handler' ) );

	}

	static function error_handler( $number, $error, $file = '', $line = '', $context = '' ) {
		if ( ( error_reporting() & $number ) == 0 ) {
			return;
		}
		$message = sprintf( _x( 'The following PHP error occurred: "%s" in the file: %s on line %d', 'A PHP error message', 'space' ), $error, $file, $line );
		if ( WP_DEBUG_LOG ) {
			error_log( $message );
		}

		self::$errors[] = $message;

	}

	static function action_output_php_errors() {
		if ( ! count( self::$errors ) ) {
			return;
		}
		foreach ( self::$errors as $error ) {
			echo '<div class="error">' . $error . '</div>';
		}

	}

}

?>
