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
 * To see this connector in action, activate it from your Plugins screen, and
 * choose Stream Example from the admin menu
 */

class Stream_Example_Plugin {

	/**
	 * Class constructor
	 */
	public function __construct() {
		add_action( 'plugins_loaded', array( $this, 'register_stream_connector' ) );
		add_action( 'admin_menu', array( $this, 'register_menu' ) );
	}

	/**
	 * If Stream is active, register the Stream Connector
	 *
	 * @action plugins_loaded
	 */
	public function register_stream_connector() {
		if ( ! class_exists( 'WP_Stream' ) ) {
			return;
		}

		add_filter(
			'wp_stream_connectors',
			function( $classes ) {
				include dirname( __FILE__ ) . '/connectors/example.php';
				$classes[] = 'WP_Stream_Connector_Example';
				return $classes;
			}
		);
	}

	/**
	 * Register menu item
	 *
	 * @action admin_menu
	 */
	public function register_menu() {
		add_menu_page(
			__( 'Random Post Generator', 'stream-connector-example' ),
			__( 'Stream Example', 'stream-connector-example' ),
			WP_Stream_Admin::VIEW_CAP,
			'example',
			array( $this, 'page' ),
			'',
			3
		);
	}

	/**
	 * Render Random Number Generator Page
	 */
	public function page() {
		?>
		<div class="wrap">
			<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
			<?php
			if ( isset( $_GET['type'] ) && isset( $_GET['id'] ) ) {
				$type = 'page' === $_GET['type'] ? 'page' : 'post';

				if ( 'random' === $_GET['id'] ) {
					$post_rand = get_posts(
						array(
							'posts_per_page' => 1,
							'post_type'      => $type,
							'orderby'        => 'rand'
						)
					);
					$post_id = $post_rand[0]->ID;
				} else {
					$post_id = (int) filter_input( INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT );
				}

				$post_id = apply_filters( 'example_post_id', $post_id, $type );
				do_action( 'example_after_generate_post_id', $post_id, $type );

				echo '<div id="message" class="updated below-h2"><p>' . sprintf( __( 'The %s is', 'stream-connector-example' ), $type ) . ' <strong>' . get_the_title( $post_id ) . '</strong></p></div>';
			}

			$post_choices = get_posts(
				array(
					'posts_per_page' => 3,
					'post_type'      => 'post',
					'orderby'        => 'rand'
				)
			);
			$page_choices = get_posts(
				array(
					'posts_per_page' => 3,
					'post_type'      => 'page',
					'orderby'        => 'rand'
				)
			);
			?>
			<div class="posts">
				<h3><?php _e( 'Posts', 'stream-connector-example' ); ?></h3>
				<p class="description"><?php _e( 'Choose a post.', 'stream-connector-example' ); ?></p>
				<a href="<?php echo add_query_arg( array( 'type' => 'post', 'id' => 'random' ) ); ?>" class="button button-primary"><?php _e( 'Random', 'stream-connector-example' ); ?></a>
				<?php foreach ( $post_choices as $post ): ?>
				<a href="<?php echo add_query_arg( array( 'type' => 'post', 'id' => $post->ID ) ); ?>" class="button"><?php echo get_the_title( $post->ID ); ?></a>
				<?php endforeach; ?>
			</div>
			<br />
			<div class="pages">
				<h3><?php _e( 'Pages', 'stream-connector-example' ); ?></h3>
				<p class="description"><?php _e( 'Choose a page.', 'stream-connector-example' ); ?></p>
				<a href="<?php echo add_query_arg( array( 'type' => 'page', 'id' => 'random' ) ); ?>" class="button button-primary"><?php _e( 'Random', 'stream-connector-example' ); ?></a>
				<?php foreach ( $page_choices as $page ): ?>
				<a href="<?php echo add_query_arg( array( 'type' => 'page', 'id' => $page->ID ) ); ?>" class="button"><?php echo get_the_title( $page->ID ); ?></a>
				<?php endforeach; ?>
			</div>
			<br />
		</div>
		<?php
	}

}

$GLOBALS['stream_example_plugin'] = new Stream_Example_Plugin;