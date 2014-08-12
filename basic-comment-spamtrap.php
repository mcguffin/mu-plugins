<?php

/*
Plugin Name: Basic Comment Spam Trap
Description: Basic Honeypot spam protection.
Author: Jörn Lund
Author URI: http://github.org/mcguffin
Version: 0.0.1
*/

// change this to whatever you like
define( 'HONEYPOT_FORM_FIELD' , 'interested' );


// SPAM comment if fierld has been filled.
function honeypot_check( $approved , $commentdata ) {
	if ( ! empty( $_POST[ HONEYPOT_FORM_FIELD ] ) )
		return 'spam';
	return $approved;
}
add_filter( 'pre_comment_approved' , 'honeypot_check' , 10 , 2 );


// css to hide honeypot field.
function honeypot_form_css( ) {
	?><style type="text/css">
		.form-field-<?php echo HONEYPOT_FORM_FIELD ?> { display:none; }
	</style><?php
}
add_action('wp_head','honeypot_form_css');


// add honepot field to comment form. Unsuspicius HTML
function honeypot_field( $fields ) {
	$fields[ HONEYPOT_FORM_FIELD ] = '<p class="comment-form-url form-field-' . HONEYPOT_FORM_FIELD . '"><label for="' . HONEYPOT_FORM_FIELD . '">' . __( ucwords(HONEYPOT_FORM_FIELD) ) . '</label> ' .
		            '<input id="' . HONEYPOT_FORM_FIELD . '" name="'.HONEYPOT_FORM_FIELD.'" type="text" size="30" /></p>';
	return $fields;
}
add_filter( 'comment_form_default_fields' , 'honeypot_field' );

