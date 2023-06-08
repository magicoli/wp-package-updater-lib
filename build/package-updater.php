<?php
/**
 * WP Package Updater - composer-ready library.
 *
 * This is a set of all needed libraries to include in a plugin, to get
 * automatic  updates from Anexandre Froger's [WP Plugin Update
 * Server](https://github.com/froger-me/wp-plugin-update-server).
 */

namespace MagicOli\WpPackageUpdaterLib;

if ( ! defined( 'WPINC' ) ) {
	die;
}

// Enable plugin updates only if $wppul_server variable is set
$trace = debug_backtrace();
if ( isset($wppul_server) && isset($trace[0]) ) {
	$plugin_file = empty($plugin_file) ? $trace[0]['file'] : $plugin_file;

	// Instantiate WP_Package_Updater class
	require_once plugin_dir_path( __FILE__ ) . 'wp-package-updater/class-wp-package-updater.php';
	new WP_Package_Updater(
		$wppul_server,
		wp_normalize_path( $plugin_file ),
		wp_normalize_path( plugin_dir_path( $plugin_file ) ),
		isset($wppul_licence_required) ? $wppul_licence_required : false
	);

	// Unset the variable after it has been used
	unset( $wppul_server );
	unset( $wppul_licence_required );
}
