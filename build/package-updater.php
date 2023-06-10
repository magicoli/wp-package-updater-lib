<?php
/**
 * WP Package Updater - composer-ready library.
 *
 * This is a set of all needed libraries to include in a plugin, to get
 * automatic  updates from Anexandre Froger's [WP Plugin Update
 * Server](https://github.com/froger-me/wp-plugin-update-server).
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

( ! defined( 'WPPUL_VERSION' ) ) && define( 'WPPUL_VERSION', '1.0.1-2-g5e23826' );

// Enable plugin updates only if $wppul_server variable is set
$trace = debug_backtrace();
if ( isset( $wppul_server ) && isset( $trace[0] ) ) {
	$wppul_plugin_file = empty( $wppul_plugin_file ) ? $trace[0]['file'] : $wppul_plugin_file;

	// Instantiate WP_Package_Updater class
	require_once plugin_dir_path( __FILE__ ) . 'wp-package-updater/class-wp-package-updater.php';
	new WP_Package_Updater(
		$wppul_server,
		wp_normalize_path( $wppul_plugin_file ),
		wp_normalize_path( plugin_dir_path( $wppul_plugin_file ) ),
		isset( $wppul_licence_required ) ? $wppul_licence_required : false
	);

	// Unset the variable after it has been used
	unset( $wppul_server );
	unset( $wppul_licence_required );
	unset( $wppul_plugin_file );
}
