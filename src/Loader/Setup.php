<?php
/**
 * Setup Class.
 *
 * PHP version 8.3
 *
 * @package    WordPress
 * @subpackage PluginBoilerplate\Loader
 * @since      1.0.0
 */

declare( strict_types = 1 );

namespace Gnist\PluginBoilerplate\Loader;

use Gnist\PluginBoilerplate\Abstracts\Loader;

defined( 'ABSPATH' ) || exit;

/**
 * Class responsible for the initial setup of the plugin.
 */
class Setup extends Loader {

	/** Setup */

	/**
	 * Setup actions.
	 *
	 * @return void
	 */
	protected function setup_actions() {
		\add_action( 'init', [ $this, 'init' ], 4, 0 );
		\add_action( 'admin_init', [ $this, 'admin_init' ], 10, 0 );
		\add_action( 'plugins_loaded', [ $this, 'plugins_loaded' ], 10, 0 );
	}

	/**
	 * Setup filters.
	 *
	 * @return void
	 */
	protected function setup_filters() {}

	/** Actions */

	/**
	 * Plugin fully initialized.
	 *
	 * * @hooked init
	 *
	 * @return void
	 */
	public function init() {
		// Bail early if called directly from functions.php or plugin file.
		if ( ! \did_action( 'plugins_loaded' ) ) {
			return;
		}

		// Fires after the plugin is completely "initialized".
		\do_action( 'gpb/init' );
	}

	/**
	 * Fires in admin only.
	 *
	 * * @hooked admin_init
	 *
	 * @return void
	 */
	public function admin_init() {
		\do_action( 'gpb/admin/init' );
	}

	/**
	 * Fires after all plugins are loaded.
	 *
	 * * @hooked plugins_loaded
	 *
	 * @return void
	 */
	public function plugins_loaded() {
		\do_action( 'gpb/plugins/loaded' );
	}
}
