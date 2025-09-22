<?php
/**
 * Helper Class.
 *
 * PHP version 8.3
 *
 * @package    WordPress
 * @subpackage PluginBoilerplate\Utils
 * @since      1.0.0
 */

declare( strict_types = 1 );

namespace Gnist\PluginBoilerplate\Utils;

use Gnist\PluginBoilerplate\Abstracts\Loader;
use Gnist\PluginBoilerplate\Exception\DebugException;

defined( 'ABSPATH' ) || exit;

/**
 * Class responsible for helping.
 */
class Helper {

	/**
	 * Get configuration data.
	 *
	 * @param string $name Name to get.
	 *
	 * @return mixed
	 */
	public static function get( string $name ) : mixed {
		return \gpb()->config()->get( $name );
	}

	/**
	 * Print data in a pre-tag for debugging.
	 *
	 * @param mixed $data        Debug data.
	 * @param bool  $is_parsable Output as parsable string representation of a variable.
	 *
	 * @return void
	 */
	public static function print( mixed $data = [], bool $is_parsable = false ) {
		echo '<pre class="gpb-print" style="background-color:#2b2b2b;color:white;overflow:scroll;padding:15px;border-radius:.35em;">';

		if ( $is_parsable ) {
			var_export( $data ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_var_export
		} else {
			print_r( $data ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_print_r
		}

		echo '</pre>';
	}

	/**
	 * Log data to debug.log.
	 *
	 * @param mixed $data Debug data.
	 *
	 * @return void
	 */
	public static function debug( mixed $data = [] ) {
		if ( ! self::get( 'debug' ) ) {
			return;
		}

		$debug = print_r( $data, true ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_print_r

		error_log( strval( $debug ) ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log
	}


	/**
	 * Get instance.
	 *
	 * @throws DebugException If instance does not exist.
	 * @throws DebugException If get_instance()-method does not exist.
	 * @throws DebugException If class does not extend Loader.
	 *
	 * @param string $fqn Fully qualified name (FQN).
	 *
	 * @return null|Loader Instance of the Loader-class if exists, null otherwise.
	 */
	public static function get_instance( string $fqn ) : ?Loader {
		static $instance = null;

		try {
			if ( ! class_exists( $fqn ) ) {
				throw new DebugException( 'Instance does not exist', [ 'fqn' => $fqn ] );
			}

			if ( ! is_a( $fqn, Loader::class, true ) ) {
				throw new DebugException( 'The class must extend Loader', [ 'fqn' => $fqn ] );
			}

			$instance = $fqn::get_instance();
		} catch ( DebugException $e ) {
			$e->log();
		} finally {
			return $instance;
		}
	}

	/**
	 * Load actions and filters from the instance.
	 *
	 * @throws DebugException If no instance could be loaded.
	 *
	 * @param string $fqn Fully qualified name (FQN).
	 *
	 * @return void
	 */
	public static function load( string $fqn ) {
		$instance = self::get_instance( $fqn );

		try {
			if ( is_null( $instance ) ) {
				throw new DebugException( 'No instance could be loaded', [ 'class' => $fqn ] );
			}

			$instance->load();
		} catch ( DebugException $e ) {
			$e->log();
		}
	}
}
