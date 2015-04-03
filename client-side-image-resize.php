<?php

/*
Plugin Name: Client side image Resizing
Author: Jörn Lund
Author URI: http://github.org/mcguffin
Version: 0.0.1
*/

/*
This one works on the Media upload page.
*/

function client_side_resize_plupload_params( $params ) {
	// get biggest possible image
	$sizes = get_image_sizes();
	$largest = array( 'width'=>0 , 'height'=>0 );
	foreach ( $sizes as $size ) {
		$largest['width'] = max($size['width'],$largest['width']);
// 		$largest['height'] = max($size['height'],$largest['height']);
	}
	$params['resize'] = array(
		'enabled' => true,
		'width'		=> $largest['width'],
		'height'	=> 0, // flexible height
		'quality'	=> 90
	);
	return $params;
}
add_filter( 'plupload_init', 'client_side_resize_plupload_params' , 20);


/*
This one is for the js media library
*/

function client_side_resize_load() {
	wp_enqueue_script( 'client-resize' , plugins_url( 'client-side-image-resize.js' , __FILE__ ) , array('media-editor' ) , '0.0.1' );
	wp_localize_script( 'client-resize' , 'client_resize' , array( 
		'plupload' => enable_client_resize_plupload_params( array() ) 
	) );
}

add_action( 'wp_enqueue_media' , 'client_side_resize_load' );