<?php
/**
 * Config Class.
 *
 * PHP version 8.3
 *
 * @package    WordPress
 * @subpackage PluginBoilerplate
 * @since      1.0.0
 */

declare( strict_types = 1 );

namespace Gnist\PluginBoilerplate;

defined( 'ABSPATH' ) || exit;

/**
 * Class responsible for maintaining configurations.
 */
class Config {

	/**
	 * Holds the configuration.
	 *
	 * @var array
	 */
	private array $data = [];

	/**
	 * Constructor.
	 *
	 * @param array $config Configuration.
	 */
	public function __construct( array $config = [] ) {
		$this->set_props( $config );
	}

	/**
	 * Set class properties.
	 *
	 * @param array $config Configuration.
	 *
	 * @return void
	 */
	private function set_props( array $config ) {
		$this->data = \wp_parse_args( $config, [] );
	}

	/**
	 * Set config value.
	 *
	 * @param string $name  Config name.
	 * @param mixed  $value Config value.
	 * @param bool   $clean Sanitize value.
	 *
	 * @return void
	 */
	public function set( string $name, mixed $value, bool $clean = true ) {
		$clean = \apply_filters( "gpb/config/clean/name={$name}", $clean );

		$this->data[ $name ] = true === $clean ? $this->clean( $value, $name ) : $value;
	}

	/**
	 * Unset variables.
	 *
	 * @param string $key Key.
	 */
	public function unset( string $key ) {
		if ( isset( $this->data[ $key ] ) ) {
			unset( $this->data[ $key ] );
		}
	}

	/**
	 * Is value set or not.
	 *
	 * @param string $key Data key.
	 *
	 * @return bool
	 */
	public function isset( string $key ) : bool {
		return isset( $this->data[ $key ] );
	}

	/**
	 * Get value from config.
	 *
	 * @param string $name Name of config key.
	 *
	 * @return mixed Class property if found, null otherwise.
	 */
	public function get( string $name ) : mixed {
		return isset( $this->data[ $name ] ) ? $this->data[ $name ] : null;
	}

	/**
	 * Read config.
	 *
	 * @return array
	 */
	public function read() : array {
		return $this->data;
	}

	/**
	 * Clean variables from all tags. Arrays are cleaned recursively.
	 * Non-scalar values are ignored.
	 *
	 * @param mixed $value Data to sanitize.
	 *
	 * @return mixed
	 */
	public function clean( mixed $value ) : mixed {
		if ( is_array( $value ) ) {
			return array_map( [ $this, 'clean' ], $value );
		} else {
			return is_scalar( $value ) ? \wp_strip_all_tags( $value ) : $value;
		}
	}
}
