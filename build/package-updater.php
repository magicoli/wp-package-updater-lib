<?php
/**
 * WP Package Updater - composer-ready library.
 *
 * This is a set of all needed libraries to include in a plugin, to get
 * automatic  updates from Anexandre Froger's [WP Plugin Update
 * Server](https://github.com/froger-me/wp-plugin-update-server).
 *
 * Version: 0.1.5
 */

namespace MagicOli\WpPackageUpdaterLib;

if ( ! defined( 'WPINC' ) ) {
	die;
}
error_log('Been here ' . __FILE__);

// Enable plugin updates only if $wppul_server variable is set
if ( isset( $wppul_server ) ) {

    // Include the library file
    require_once plugin_dir_path( __FILE__ ) . 'wp-package-updater/class-wp-package-updater.php';

    // Instantiate WP_Package_Updater class
    new WP_Package_Updater(
        $wppul_server,
        wp_normalize_path( plugin_dir_path( __FILE__ ) . 'project-donations-wc.php' ),
        wp_normalize_path( plugin_dir_path( __FILE__ ) ),
        isset($wppul_licence_required) ? $wppul_licence_required : false
    );

    // Unset the variable after it has been used
    unset( $wppul_server );
    unset( $wppul_licence_required );
}
