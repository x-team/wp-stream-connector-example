<?php
/**
 * This example connector logs when the current user saves an odd-numbered post.
 */

class WP_Stream_Connector_Example extends \WP_Stream\Connector {

	/**
	 * Slug for the connector
	 *
	 * @var string
	 */
	public $name = 'example';

	/**
	 * Label for this connector
	 *
	 * This label should answer the question: "What feature set is being connected to Stream?"
	 *
	 * Examples might be:
	 * - "Example plugin"
	 * - "This Plugin CLI"
	 * - "Example Plugin"
	 *
	 * @return string Translated context label
	 */
	public function get_label() {
		return __( 'Example Connector', 'stream-connector-example' );
	}


	/**
	 * Actions registered for this connector's context
	 *
	 * This is an array of WordPress action names.
	 * The action names can be from Core (https://codex.wordpress.org/Plugin_API/Action_Reference),
	 * from a plugin, or from your custom code. It doesn't matter!
	 *
	 * @var array
	 */
	public $actions = array(
		// Here, we hook a connector action on save_post
		'save_post',
	);

	/**
	 * Return translated context labels
	 *
	 * A "context" is, generally speaking, a WordPress object type: a post type, user, option, and so on.
	 *
	 * @return array Context label translations
	 */
	public function get_context_labels() {
		return array(
			'post' => __( 'Post', 'stream-connector-example' ),
			'page' => __( 'Page', 'stream-connector-example' ),
		);
	}

	/**
	 * Return translated action labels
	 *
	 * "Action" here does not refer to a WordPress action hook. Rather,
	 * an "action" in the context of this function is a discrete loggable thing
	 * which gets logged by a connector. There is not a 1:1 relationship between
	 * connectors and "actions", as a single connector may log different "actions"
	 * or different connectors may log the same "action"
	 *
	 * @return array Action label translations
	 */
	public function get_action_labels() {
		return array(
			'edit_odd' => __( 'Edit Odd-Numbered Post', 'stream-connector-example' )
		);
	}

	/**
	 * Example connector logging on the save_post hook.
	 *
	 * Stream connector callbacks are named after the WO action hook, prefixed with 'callback_`.
	 * The parameters passed to your callback are the parameters passed to that hook.
	 *
	 * So, for our example here, the parameters for `save_post` are:
	 *
	 * @action save_post
	 * @param int $post_id the ID of the post being saved
	 * @param WP_Post $post the post object
	 * @param bool $update whether the post is being udpated.
	 * @return void
	 * @link https://developer.wordpress.org/reference/hooks/save_post/
	 */
	public function callback_save_post( $post_id, $post, $update ) {
		if ( 0 !== $post_id % 2 ) {
			// the post ID is even
		}
		$post_title = get_the_title( $post_id );

		$post_type_obj  = get_post_type_object( $post->post_type );

		$message = sprintf(
			__( 'Edited an odd-numbered post: "%1$s" %2$s.' , 'stream-example-conector' ),
			$post_title,
			$post_id
		);
		$context = $post->post_type;
		$action  = 'edit_odd';

		/**
		 * Parameters to self::log are:
		 *
		 * @param string $message   sprintf-ready error message string.
		 * @param array  $args      sprintf (and extra) arguments to use.
		 * @param int    $object_id Target object id.
		 * @param string $context   Context of the event. Could be a WordPress object type like post, page, user. Could be something specific to your plugin.
		 * @param string $action    Action of the event, which needs to match an item in get_action_labels()
		 * @param int    $user_id   User responsible for the event — whic we're leaving off
		 *
		 * @link https://github.com/xwp/stream/blob/305583d70e8a7667d1f99df85196024a7334ed50/classes/class-connector.php#L146-L158
		 */
		self::log(
			$message,
			array(
				'post_title' => $post_title,
				'post_id' => $post_id,
			),
			$post_id,
			$context,
			$action
			// $user_id - if you felt like faking log entries to another user
		);
	}

	/**
	 * Add action links
	 *
	 * These appear on individual Stream entries when the mouse hovers over that entry.
	 * They're analogous to the links that appear on on the psots list table to let you view/edit/trash posts.
	 *
	 * This is not mandatory, but if there's an action that an admin would need to do in response to this log entry, this is where you'd put it.
	 *
	 * @filter wp_stream_action_links_{connector}
	 * @param  array $links      Previous links registered
	 * @param  int   $record     Stream record
	 * @return array             Action links
	 */
	public function action_links( $links, $record ) {
		if ( get_post( $record->object_id ) ) {
			if ( $link = get_edit_post_link( $record->object_id ) ) {

				$post_title = $record->get_meta( 'post_title', true );

				$links[ __( 'Edit', 'stream-example-conector' ) ] = $link;
			}
			if ( $link = get_permalink( $record->object_id ) ) {
				$links[ __( 'View', 'stream-example-conector' ) ] = $link;
			}
		}

		return $links;
	}
}
