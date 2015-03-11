<?php

/**
 * @link              http://L6.org/
 * @since             1.0.0
 * @package           Image_Marker
 *
 * @wordpress-plugin
 * Plugin Name:       Leaflet Maps Marker Image Extension
 * Plugin URI:        http://L6.org/
 * Description:       Extension to Leaflet Maps Marker to make markers from images.
 * Version:           1.1
 * Author:            Neil Boyd
 * Author URI:        http://L6.org/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       image-marker
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-image-marker-activator.php
 */
function activate_image_marker() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-image-marker-activator.php';
	Image_Marker_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-image-marker-deactivator.php
 */
function deactivate_image_marker() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-image-marker-deactivator.php';
	Image_Marker_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_image_marker' );
register_deactivation_hook( __FILE__, 'deactivate_image_marker' );

/**
 * The core plugin class that is used to define internationalization,
 * dashboard-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-image-marker.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_image_marker() {

	$plugin = new Image_Marker();
	$plugin->run();

}
run_image_marker();
