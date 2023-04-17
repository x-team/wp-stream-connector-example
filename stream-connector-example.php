<?php
/**
 * Plugin Name: Stream Connector - Example
 * Depends: Stream
 * Plugin URI: http://x-team.com
 * Description: This plugin adds a random post generator which logs entries in your Stream.
 * Version: 0.1.0
 * Author: X-Team
 * Author URI: http://wp-stream.com/
 * License: GPLv2+
 * Text Domain: stream-connector-example
 * Domain Path: /languages
 */

/**
 * How to use this plugin
 *
 * This plugin has been made to be copied and changed to suit your own needs.
 * To get started, copy connectors/example.php into your own plugin, then copy
 * the register_stream_connector() function from stream-connector-example.php
 * and hook it into your own plugin via the plugins_loaded action.
 *
 * The good stuff is in connectors/example.php - once you've copied out the
 * register_stream_connector() function, you can ignore the rest of this file.
 *
 * To see this connector in action, activate it from your Plugins screen,
 * and choose Stream Example from the admin menu
 */

class Stream_Example_Plugin {

	/**
	 * Class constructor
	 */
	public function __construct() {
		add_action( 'plugins_loaded', array( $this, 'register_stream_connector' ) );
	}

	/**
	 * If Stream is active, register the Stream Connector
	 *
	 * @action plugins_loaded
	 */
	public function register_stream_connector() {
		if ( ! class_exists( '\WP_Stream\Connector' ) ) {
			return;
		}

		add_filter(
			'wp_stream_connectors',
			function( $classes ) {
				include dirname( __FILE__ ) . '/connectors/example.php';
				$classes[] = new WP_Stream_Connector_Example();
				return $classes;
			}
		);
	}

}

$GLOBALS['stream_example_plugin'] = new Stream_Example_Plugin;
