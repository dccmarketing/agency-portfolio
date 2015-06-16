<?php

/**
 * Fired during plugin activation
 *
 * @link       http://slushman.com/plugins/agency-portfolio
 * @since      1.0.0
 *
 * @package    Agency_Portfolio
 * @subpackage Agency_Portfolio/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Agency_Portfolio
 * @subpackage Agency_Portfolio/includes
 * @author     Slushman <chris@slushman.com>
 */
class Agency_Portfolio_Activator {

	/**
	 * Creates custom post types and plugin settings, then flushes rewrite rules
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-agency-portfolio-admin.php';

		Agency_Portfolio_Admin::new_cpt_portfolio();

		flush_rewrite_rules();

	}

}
