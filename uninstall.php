<?php
/**
 * Uninstall Process.
 *
 * Deletes all the plugin data i.e.
 *   - 1. Custom Post types.
 *   - 2. Terms & Taxonomies.
 *   - 3. Plugin pages.
 *   - 4. Plugin options.
 *   - 5. Capabilities.
 *   - 6. Roles.
 *   - 7. Database tables.
 *   - 8. Cron events.
 *
 * @package    WordPress
 * @subpackage PluginBoilerplate
 * @copyright  2025 Gnist Design AS
 * @since      1.0.0
 */

declare( strict_types = 1 );

defined( 'ABSPATH' ) || exit;

defined( 'WP_UNINSTALL_PLUGIN' ) || exit;
