<?php
/**
 * Loader Class.
 *
 * PHP version 8.3
 *
 * @package    WordPress
 * @subpackage PluginBoilerplate
 * @since      1.0.0
 */

declare( strict_types = 1 );

namespace Gnist\PluginBoilerplate\Abstracts;

defined( 'ABSPATH' ) || exit;

/**
 * Class responsible for loading actions and filters from within a class.
 */
abstract class Loader {

	/**
	 * Main loader instance.
	 *
	 * Insures that only one instance of the class exists in memory at any one
	 * time. Also prevents needing to define globals all over the place.
	 *
	 * @staticvar object $instances
	 *
	 * @return Loader The one true loader instance.
	 */
	public static function get_instance() : Loader {
		// Store the instances locally to avoid private static replication.
		static $instances;

		// Get the called class.
		$class = get_called_class();

		// Only run these methods if they haven't been ran previously.
		if ( ! isset( $instances[ $class ] ) ) {
			$instances[ $class ] = new $class();
		}

		// Always return the instance.
		return $instances[ $class ];
	}

	/**
	 * Constructor.
	 *
	 * @return void
	 */
	protected function __construct() {
		// Do nothing.
	}

	/**
	 * Load actions & filters.
	 *
	 * @return void
	 */
	public function load() {
		$this->setup_actions();
		$this->setup_filters();
	}

	/**
	 * Setup actions.
	 *
	 * @return void
	 */
	abstract protected function setup_actions();

	/**
	 * Setup filters.
	 *
	 * @return void
	 */
	abstract protected function setup_filters();
}
