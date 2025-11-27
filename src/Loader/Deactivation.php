<?php
/**
 * Deactivation Class.
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
 * Class responsible for everything that happens during plugin deactivation.
 */
class Deactivation extends Loader {

	/** Setup */

	/**
	 * Setup actions.
	 *
	 * @return void
	 */
	protected function setup_actions() {
		\add_action( 'gpb/deactivate', [ $this, 'remove_initial_data' ], 10, 0 );
		\add_action( 'gpb/deactivate', [ $this, 'remove_capabilities' ], 10, 0 );
	}

	/**
	 * Setup filters.
	 *
	 * @return void
	 */
	protected function setup_filters() {}

	/** Actions */

	/**
	 * Remove initial plugin data from DB on plugin deactivation.
	 *
	 * * @hooked gpb/activate
	 *
	 * @return void
	 */
	public function remove_initial_data() {
		$prefix = Helper::get( 'prefix' );

		if ( false === \get_option( "{$prefix}_first_activated_version" ) ) {
			return;
		}

		\delete_option( "{$prefix}_first_activated_version" );
		\delete_option( "{$prefix}_first_activated_timestamp" );
		\delete_option( "{$prefix}_first_activated_datetime" );
	}

	/**
	 * Remove capabilities.
	 *
	 * * @hooked gpb/deactivate
	 *
	 * @return void
	 */
	public function remove_capabilities() {
		$roles = Helper::get( 'roles' );

		foreach ( $roles as $name ) {
			$role = \get_role( $name );

			if ( ! is_a( $role, WP_Role::class ) ) {
				continue;
			}

			if ( ! $role->has_cap( Helper::get( 'capability' ) ) ) {
				$role->remove_cap( Helper::get( 'capability' ) );
			}
		}
	}
}
