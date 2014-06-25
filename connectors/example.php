<?php

class WP_Stream_Connector_Example extends WP_Stream_Connector {

	/**
	 * Context name
	 *
	 * @var string
	 */
	public static $name = 'example';

	/**
	 * Actions registered for this context
	 *
	 * @var array
	 */
	public static $actions = array(
		'example_after_generate_post_id',
	);

	/**
	 * Return translated connector label
	 *
	 * @return string Translated context label
	 */
	public static function get_label() {
		return __( 'Example', 'stream-connector-example' );
	}

	/**
	 * Return translated context labels
	 *
	 * @return array Context label translations
	 */
	public static function get_context_labels() {
		return array(
			'post' => __( 'Post', 'stream-connector-example' ),
			'page' => __( 'Page', 'stream-connector-example' ),
		);
	}

	/**
	 * Return translated action labels
	 *
	 * @return array Action label translations
	 */
	public static function get_action_labels() {
		return array(
			'random' => __( 'Random', 'stream-connector-example' ),
			'chosen' => __( 'Chosen', 'stream-connector-example' ),
		);
	}

	/**
	 * Log example entry
	 *
	 * @action init
	 */
	public static function callback_example_after_generate_post_id( $post_id, $post_type ) {
		$post_title = get_the_title( $post_id );

		if ( isset( $_GET['id'] ) && 'random' === $_GET['id'] ) {
			$action = 'random';
		} else {
			$action = 'chosen';
		}

		$post_type_obj  = get_post_type_object( $post_type );
		$post_type_name = $post_type_obj->labels->singular_name;

		$message = sprintf( __( 'This is an example entry for the "%s" %s.' , 'stream-example-conector' ), $post_title, $post_type_name );
		$context = $post_type;

		self::log(
			$message,
			array(
				'post_title' => $post_title,
			),
			$post_id,
			array( $context => $action )
		);
	}

	/**
	 * Add action links to Stream Records screen
	 *
	 * @filter wp_stream_action_links_{connector}
	 * @param  array $links      Previous links registered
	 * @param  int   $record     Stream record
	 * @return array             Action links
	 */
	public static function action_links( $links, $record ) {
		if ( get_post( $record->object_id ) ) {
			if ( $link = get_edit_post_link( $record->object_id ) ) {

				$post_title = wp_stream_get_meta( $record->ID, 'post_title', true );

				$links[ __( 'Edit', 'stream-example-conector' ) ] = $link;
			}
			if ( $link = get_permalink( $record->object_id ) ) {
				$links[ __( 'View', 'stream-example-conector' ) ] = $link;
			}
		}

		return $links;
	}

}