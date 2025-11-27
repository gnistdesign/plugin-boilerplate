<?php
/**
 * Activation Class.
 *
 * PHP version 8.3
 *
 * @package    WordPress
 * @subpackage PluginBoilerplate\Loader
 * @since      1.0.0
 */

declare( strict_types = 1 );

namespace Gnist\PluginBoilerplate\Loader;

use Gnist\PluginBoilerplate\Utils\Helper;
use Gnist\PluginBoilerplate\Abstracts\Loader;
use WP_Role;

defined( 'ABSPATH' ) || exit;

/**
 * Class responsible for everything that happens during plugin activation.
 */
class Activation extends Loader {

	/** Setup */

	/**
	 * Setup actions.
	 *
	 * @return void
	 */
	protected function setup_actions() {
		\add_action( 'gpb/activate', [ $this, 'add_initial_data' ], 10, 0 );
		\add_action( 'gpb/activate', [ $this, 'add_capabilities' ], 10, 0 );
	}

	/**
	 * Setup filters.
	 *
	 * @return void
	 */
	protected function setup_filters() {}

	/** Actions */

	/**
	 * Add initial plugin data to DB on plugin activation.
	 *
	 * * @hooked gpb/activate
	 *
	 * @return void
	 */
	public function add_initial_data() {
		$prefix = Helper::get( 'prefix' );

		if ( false !== \get_option( "{$prefix}_first_activated_version" ) ) {
			return;
		}

		\update_option( "{$prefix}_first_activated_version", Helper::get( 'version' ), false );
		\update_option( "{$prefix}_first_activated_timestamp", time(), false );
		\update_option( "{$prefix}_first_activated_datetime", \wp_date( 'Y-m-d H:i:s' ), false );

		\do_action( 'gpb/activate/initial' );
	}

	/**
	 * Add capabilities.
	 *
	 * * @hooked gpb/activate
	 *
	 * @return void
	 */
	public function add_capabilities() {
		$roles = Helper::get( 'roles' );

		foreach ( $roles as $name ) {
			$role = \get_role( $name );

			if ( ! is_a( $role, WP_Role::class ) ) {
				continue;
			}

			if ( ! $role->has_cap( Helper::get( 'capability' ) ) ) {
				$role->add_cap( Helper::get( 'capability' ) );
			}
		}
	}
}
