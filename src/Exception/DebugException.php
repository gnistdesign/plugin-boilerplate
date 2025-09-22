<?php
/**
 * Exception Class.
 *
 * PHP version 8.3
 *
 * @package    WordPress
 * @subpackage Gnist\PluginBoilerplate\Exception
 * @since      1.0.0
 */

declare( strict_types = 1 );

namespace Gnist\PluginBoilerplate\Exception;

use Gnist\PluginBoilerplate\Utils\Helper;
use Gnist\PluginBoilerplate\Exception\Exception;

defined( 'ABSPATH' ) || exit;

/**
 * Class responsible for logging exceptions to debug.log
 */
class DebugException extends Exception {

	/**
	 * Constructor.
	 *
	 * @param string $message (Required) Exception message.
	 * @param array  $context (Optional) Exception log context.
	 */
	public function __construct( string $message, private array $context = [] ) {
		parent::__construct( $message );
	}

	/**
	 * Log message.
	 *
	 * @return void
	 */
	public function log() {
		if ( ! Helper::get( 'debug' ) ) {
			return;
		}

		$message = ! empty( $this->getLogContext() )
			? sprintf( '%1$s %2$s', $this->getMessage(), \wp_json_encode( $this->getLogContext(), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES ) )
			: $this->getMessage();

		Helper::debug( $message );
	}

	/**
	 * Get log context.
	 *
	 * @param array $context Context.
	 *
	 * @return array
	 */
	public function getLogContext( array $context = [] ) : array {
		return \wp_parse_args( $context, $this->context );
	}
}
