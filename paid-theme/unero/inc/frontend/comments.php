<?php
/**
 * Hooks for comment ajax
 *
 * @package Unero
 */

/**
 * Custom fields comment form
 *
 * @since  1.0
 *
 * @return  array  $fields
 */
function unero_comment_form_fields() {
	global $commenter, $aria_req;

	$fields = array(
		'author' => '<p class="comment-form-author col-md-6 col-sm-12">' .
			'<input id ="author" placeholder="' . esc_html__( 'Name', 'unero' ) . ' " name="author" type="text" required value="' . esc_attr( $commenter['comment_author'] ) .
			'" size    ="30"' . $aria_req . ' /></p>',

		'email'  => '<p class="comment-form-email col-md-6 col-sm-12">' .
			'<input id ="email" placeholder="' . esc_html__( 'Email', 'unero' ) . '"name="email" type="email" required value="' . esc_attr( $commenter['comment_author_email'] ) .
			'" size    ="30"' . $aria_req . ' /></p>',

		'url'    => '<p class="comment-form-url col-md-12 col-sm-12">' .
			'<input id ="url" placeholder="' . esc_html__( 'Website', 'unero' ) . '"name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) .
			'" size    ="30" /></p>'
	);

	return $fields;
}

add_filter( 'comment_form_default_fields', 'unero_comment_form_fields' );