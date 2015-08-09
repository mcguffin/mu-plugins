<?php
/*
Plugin Name: Disable Trackbacks
Description: Disables Trackback and pingback core functionality. Warning: You might still have to remove the <Link rel="pingback" /> from your themes header.php
Author: Jörn Lund
Author URI: http://github.org/mcguffin
Version: 0.0.1
*/



// disable rpc method
// code by Samuel Aguilera; https://wordpress.org/plugins/disable-xml-rpc-pingback/
function disable_pingback_rpc( $methods ) {
	unset( $methods['pingback.ping'] );
	unset( $methods['pingback.extensions.getPingbacks'] );
	return $methods;
}
add_filter( 'xmlrpc_methods', 'disable_pingback_rpc' );


// send pingbacks option always off
add_filter( 'pre_option_default_pingback_flag' , '__return_false' );


// set default always closed
if ( ! function_exists('__return_closed') ) {
	function __return_closed() {
		return 'closed';
	}
}
add_filter( 'pre_option_default_ping_status' , '__return_closed' );
add_filter( 'edit_post_ping_status' , '__return_closed' );
add_filter( 'pre_post_ping_status' , '__return_closed' );
add_filter( 'post_ping_status' , '__return_closed' );


// set ping status closes whenever a post is saved.
function insert_post_disable_trackbacks( $post_data , $postarr = null ) {
	$post_data['ping_status'] = 'closed';
	return $post_data;
}
add_filter( 'wp_insert_post_data' , 'insert_post_disable_trackbacks' );






// hide settings on options page
function hide_pingback_options_css() {
	?><style type="text/css" id="disable-trackbacks">
		.form-table td fieldset label[for="default_pingback_flag"],
		.form-table td fieldset label[for="default_ping_status"] {
			display:none;
		}
	</style><?php
}
function hide_pingback_options_head() {
	add_action('admin_head','hide_pingback_options_css');
}
add_action( 'load-options-discussion.php' , 'hide_pingback_options_head' );


// hide trackback discussion option on post editor
function hide_pingback_post_css() {
	?><style type="text/css" id="disable-trackbacks">
		label[for="ping_status"] {
			display:none;
		}
	</style><?php
}
function hide_pingback_post_head(){
	add_action('admin_head','hide_pingback_post_css');
}
add_action( 'load-post.php' , 'hide_pingback_post_head' );
add_action( 'load-post-new.php' , 'hide_pingback_post_head' );


// will remove the trackbacks meta box from post edit screen
function remove_trackback_posttype_support() {
	foreach ( get_post_types() as $post_type )
		remove_post_type_support($post_type,'trackbacks');
}
add_action( 'init', 'remove_trackback_posttype_support', 0x7FFFFFFF ); // do this after (hopefully) all other post types have been registered

/*
Hide options by css: on load-options-discussion.php
*/
