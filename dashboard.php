<?php
/*
 * dashboard
 */

class Space_Dashboard {
	static function action_add_dashboard_widgets() {
		if ( Space_User::is_admin() ) {
			
		}

	}

	static function action_add_network_dashboard_widgets() {

		if ( Space_User::is_admin() ) {
			wp_add_dashboard_widget(
				'space-network-dashboard-widget-status',
				_x( 'Site and Server Status', 'Dashboard widget title', 'space' ),
				array( __CLASS__, 'display_dashboard_status_widget' )
			);
		}

	}


}
?>
