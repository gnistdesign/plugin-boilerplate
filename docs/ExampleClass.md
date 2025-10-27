# ExampleClass.php

```php
<?php
/**
 * ExampleClass Class.
 *
 * PHP version 8.3
 *
 * @package    WordPress
 * @subpackage PluginBoilerplate
 * @since      1.0.0
 */

declare( strict_types = 1 );

namespace Gnist\PluginBoilerplate;

use Gnist\PluginBoilerplate\Abstracts\Loader;

defined( 'ABSPATH' ) || exit;

/**
 * Class responsible for everything that this class does.
 */
class ExampleClass extends Loader {

	/** Setup */

	/**
	 * Setup actions.
	 *
	 * @return void
	 */
	protected function setup_actions() {}

	/**
	 * Setup filters.
	 *
	 * @return void
	 */
	protected function setup_filters() {}

	/** Actions */

	/** Filters */
}
```
