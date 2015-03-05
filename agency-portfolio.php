<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * Dashboard. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://slushman.com/plugins/agency-portfolio
 * @since             1.0.0
 * @package           Agency_Portfolio
 *
 * @wordpress-plugin
 * Plugin Name:       Agency Portfolio
 * Plugin URI:        http://slushman.com/plugins/agency-portfolio
 * Description:       Show off your work with a portfolio on your site!
 * Version:           1.0.0
 * Author:            Slushman
 * Author URI:        http://slushman.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       agency-portfolio
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-agency-portfolio-activator.php
 */
function activate_agency_portfolio() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-agency-portfolio-activator.php';
	Agency_Portfolio_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-agency-portfolio-deactivator.php
 */
function deactivate_agency_portfolio() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-agency-portfolio-deactivator.php';
	Agency_Portfolio_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_agency_portfolio' );
register_deactivation_hook( __FILE__, 'deactivate_agency_portfolio' );

/**
 * The core plugin class that is used to define internationalization,
 * dashboard-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-agency-portfolio.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_agency_portfolio() {

	$plugin = new Agency_Portfolio();
	$plugin->run();

}
run_agency_portfolio();
