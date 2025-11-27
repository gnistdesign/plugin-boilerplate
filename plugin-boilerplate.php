<?php
/**
 * Plugin Boilerplate
 *
 * PHP version 8.3
 *
 * @category   WordPress_Plugin
 * @package    WordPress
 * @subpackage PluginBoilerplate
 * @author     The Gnist Coding Team
 * @copyright  2025 Gnist Design AS
 * @license    GPLv3 or later
 * @link       https://gnistdesign.no
 * @since      1.0.0
 *
 * @wordpress-plugin
 * Plugin Name:       Plugin Boilerplate
 * Plugin URI:        https://gnistdesign.no
 * Description:       A simple boilerplate for the next awesome plugin
 * Author:            The Gnist Coding Team
 * Author URI:        https://gnistdesign.no
 * Version:           1.0.0
 * Requires at least: 6.8
 * Tested up to:      6.8
 * Requires PHP:      8.3
 * License:           GPL v3 or later
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain:       plugin-boilerplate
 * Domain Path:       /languages
 *
 * Plugin Boilerplate is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 *
 * Plugin Boilerplate is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Plugin Boilerplate. If not, see <http://www.gnu.org/licenses/>.
 */

declare( strict_types = 1 );

use Gnist\PluginBoilerplate\Plugin;

defined( 'ABSPATH' ) || exit;

/** BOOTSTRAP */

if ( ! function_exists( 'gpb' ) ) {
	/**
	 * The main function responsible for returning the one true plugin instance.
	 *
	 * Use this function like you would a global variable, except without needing
	 * to declare the global.
	 *
	 * @return Plugin
	 */
	function gpb() : Plugin {
		require_once \plugin_dir_path( __FILE__ ) . '/src/Plugin.php';

		$plugin = Plugin::get_instance(
			[
				'file'    => __FILE__,
				'version' => '1.0.0',
				'domain'  => 'plugin-boilerplate',
			]
		);

		return $plugin;
	}
	gpb();
}
