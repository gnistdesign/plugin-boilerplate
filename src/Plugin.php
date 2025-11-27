<?php
/**
 * Plugin Class.
 *
 * PHP version 8.3
 *
 * @package    WordPress
 * @subpackage PluginBoilerplate
 * @since      1.0.0
 */

declare( strict_types = 1 );

namespace Gnist\PluginBoilerplate;

use Gnist\PluginBoilerplate\Utils\Helper;

defined( 'ABSPATH' ) || exit;

/**
 * Final class which initializes the plugin.
 */
final class Plugin {

	/**
	 * Plugin configuration.
	 *
	 * @var Config
	 */
	private Config $config;

	/** Singleton */

	/**
	 * Main plugin instance.
	 *
	 * Insures that only one instance of this class exists in memory at any one
	 * time. Also prevents needing to define globals all over the place.
	 *
	 * @staticvar object $instance
	 *
	 * @see gpb()
	 *
	 * @param array $args {
	 *     Plugin arguments.
	 *
	 *     @var string $file    File to main plugin file.
	 *     @var string $version Plugin version.
	 *     @var string $domain  Plugin textdomain.
	 * }
	 *
	 * @return Plugin The one true plugin instance.
	 */
	public static function get_instance( array $args = [] ) : Plugin {
		// Store the instance locally to avoid private static replication.
		static $instance = null;

		// Only run these methods if they haven't been ran previously.
		if ( \is_null( $instance ) ) {
			$instance = new Plugin();

			// Setup.
			$instance->setup_config( $args );
			$instance->setup_files();

			// Activation / Deactivation.
			\register_activation_hook( $instance->config()->get( 'file' ), [ $instance, 'plugin_activated' ] );
			\register_deactivation_hook( $instance->config()->get( 'file' ), [ $instance, 'plugin_deactivated' ] );

			// Initialize.
			$instance->initialize();
		}

		// Always return the instance.
		return $instance;
	}

	/** Magic Methods */

	/**
	 * A dummy magic method to prevent this class from being cloned.
	 *
	 * @return void
	 */
	public function __clone() {
		\_doing_it_wrong( __FUNCTION__, \esc_html__( 'Cheatin&#8217; huh?', 'plugin-boilerplate' ), '1.0.0' );
	}

	/**
	 * A dummy magic method to prevent this class from being unserialized.
	 *
	 * @return void
	 */
	public function __wakeup() {
		\_doing_it_wrong( __FUNCTION__, \esc_html__( 'Cheatin&#8217; huh?', 'plugin-boilerplate' ), '1.0.0' );
	}

	/**
	 * Magic method to prevent notices and errors from invalid method calls.
	 *
	 * @param string $name Name.
	 * @param array  $args Arguments.
	 *
	 * @return void
	 */
	public function __call( string $name = '', array $args = [] ) {
		unset( $name, $args );
	}

	/** Spesific Methods */

	/**
	 * Setup the environment.
	 *
	 * @see get_instance()
	 *
	 * @param array $args Plugin arguments.
	 *
	 * @return void
	 */
	private function setup_config( array $args ) {
		if ( ! class_exists( 'Config' ) ) {
			include_once plugin_dir_path( __FILE__ ) . 'Config.php';
		}

		$config = new Config( $args );

		// Names.
		$config->set( 'prefix',  'gpb' );
		$config->set( 'prefixd', 'gpb-' );
		$config->set( 'prefixu', 'gpb_' );
		$config->set( 'name',    'Plugin Boilerplate' );

		// Misc.
		$config->set( 'capability', "manage_{$config->get( 'prefix' )}" );
		$config->set( 'environment', \wp_get_environment_type() );
		$config->set( 'debug', defined( 'WP_DEBUG' ) && true === WP_DEBUG );
		$config->set( 'assets_version', true === (bool) $config->get( 'debug' ) ? time() : $config->get( 'version' ) );

		// File & base.
		$config->set( 'basename', \plugin_basename( $config->get( 'file' ) ) );
		$config->set( 'basepath', \trailingslashit( dirname( $config->get( 'basename' ) ) ) );

		// Paths.
		$uploads_dir     = \wp_upload_dir();
		$uploads_basedir = \trailingslashit( $uploads_dir['basedir'] );

		$config->set( 'plugin_dir',    \trailingslashit( \plugin_dir_path( $config->get( 'file' ) ) ) );
		$config->set( 'src_dir',       \trailingslashit( $config->get( 'plugin_dir' ) . 'src' ) );
		$config->set( 'views_dir',     \trailingslashit( $config->get( 'plugin_dir' ) . 'views' ) );
		$config->set( 'vendor_dir',    \trailingslashit( $config->get( 'plugin_dir' ) . 'vendor' ) );
		$config->set( 'templates_dir', \trailingslashit( $config->get( 'plugin_dir' ) . 'templates' ) );
		$config->set( 'theme_dir',     \trailingslashit( \get_theme_file_path() ) );
		$config->set( 'uploads_dir',   $uploads_basedir );

		// URLs.
		$config->set( 'plugin_url', \trailingslashit( \plugin_dir_url( $config->get( 'file' ) ) ) );
		$config->set( 'vendor_url', \trailingslashit( $config->get( 'plugin_url' ) . 'vendor' ) );
		$config->set( 'assets_url', \trailingslashit( $config->get( 'plugin_url' ) . 'assets' ) );
		$config->set( 'images_url', \trailingslashit( $config->get( 'assets_url' ) . 'images' ) );
		$config->set( 'js_url',     \trailingslashit( $config->get( 'assets_url' ) . 'js' ) );
		$config->set( 'css_url',    \trailingslashit( $config->get( 'assets_url' ) . 'css' ) );

		// Languages.
		$config->set( 'lang_base', \trailingslashit( $config->get( 'basepath' ) . 'languages' ) );
		$config->set( 'lang_dir',  \trailingslashit( $config->get( 'plugin_dir' ) . 'languages' ) );

		// Dates.
		$config->set( 'date_format',     \get_option( 'date_format' ) );
		$config->set( 'time_format',     \get_option( 'time_format' ) );
		$config->set( 'datetime_format', sprintf( '%1$s, %2$s', $config->get( 'date_format' ), $config->get( 'time_format' ) ) );

		// Roles allowed to adjust the plugin settings.
		$config->set( 'roles', [
			'editor',
			'administrator',
		] );

		$this->config = $config;

		\do_action( 'gpb/setup/config', $this->config, $this );
	}

	/**
	 * Setup files.
	 *
	 * - Generic files.
	 * - Files generated by PSR-4 autoloader.
	 *
	 * @see get_instance()
	 *
	 * @return void
	 */
	private function setup_files() {
		if ( file_exists( $this->config()->get( 'vendor_dir' ) . 'autoload.php' ) ) {
			include_once $this->config()->get( 'vendor_dir' ) . 'autoload.php';
		}

		\do_action( 'gpb/setup/files', $this );
	}

	/** Activation / Deactivation */

	/**
	 * The code that runs during plugin activation. Add plugin cap to the given
	 * roles.
	 *
	 * * @hooked register_activation_hook
	 *
	 * @see get_instance()
	 *
	 * @return void
	 */
	public function plugin_activated() {
		\do_action( 'gpb/activate', $this );
	}

	/**
	 * The code that runs during plugin deactivation.
	 * Remove plugin cap of the given roles.
	 *
	 * * @hooked register_deactivation_hook
	 *
	 * @see get_instance()
	 *
	 * @return void
	 */
	public function plugin_deactivated() {
		\do_action( 'gpb/deactivate', $this );
	}

	/** Init */

	/**
	 * Bootstrap the rest of the plugin.
	 *
	 * @see get_instance()
	 *
	 * @return void
	 */
	public function initialize() {
		Helper::load( Loader\Activation::class );
		Helper::load( Loader\Deactivation::class );
		Helper::load( Loader\Setup::class );

		/** ! BEGIN DEBUG ! */
		\add_action( 'admin_menu', function() {
			\add_menu_page(
				$this->config()->get( 'name' ),
				$this->config()->get( 'name' ),
				$this->config()->get( 'capability' ),
				$this->config()->get( 'prefix' ),
				function() {
					Helper::print( $this );
				},
				'dashicons-schedule',
				3
			);
		}, 10, 0 );
		/** ! END DEBUG ! */

		\do_action( 'gpb/initialized', $this );
	}

	/** Getters */

	/**
	 * Get plugin configuration.
	 *
	 * @return Config
	 */
	public function config() : Config {
		return $this->config;
	}
}
