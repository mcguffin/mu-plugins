<?php

/*
Plugin Name: Client side image Resizing
Author: Jörn Lund
Author URI: http://github.org/mcguffin
Version: 0.0.1
*/

/**
 * Return all available image sizes.
 * (Copied from http://codex.wordpress.org/Function_Reference/get_intermediate_image_sizes)
 *
 */
if ( ! function_exists('get_image_sizes') ) :
function get_image_sizes( $size = '' ) {

	global $_wp_additional_image_sizes;

	$sizes = array();
	$get_intermediate_image_sizes = get_intermediate_image_sizes();

	// Create the full array with sizes and crop info
	foreach( $get_intermediate_image_sizes as $_size ) {

		if ( in_array( $_size, array( 'thumbnail', 'medium', 'large' ) ) ) {

			$sizes[ $_size ]['width'] = get_option( $_size . '_size_w' );
			$sizes[ $_size ]['height'] = get_option( $_size . '_size_h' );
			$sizes[ $_size ]['crop'] = (bool) get_option( $_size . '_crop' );

		} elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {

			$sizes[ $_size ] = array( 
			'width' => $_wp_additional_image_sizes[ $_size ]['width'],
			'height' => $_wp_additional_image_sizes[ $_size ]['height'],
			'crop' =>  $_wp_additional_image_sizes[ $_size ]['crop']
			);

		}

	}

	// Get only 1 size if found
	if ( $size ) {
		if( isset( $sizes[ $size ] ) ) {
			return $sizes[ $size ];
		} else {
			return false;
		}
	}

	return $sizes;
}
endif;


/*
This one works on the Media upload page.
*/

function client_side_resize_plupload_params( $params ) {
	// get biggest possible image
	$sizes = get_image_sizes();
	$largest = array( 'width'=>0 , 'height'=>0 );
	foreach ( $sizes as $size ) {
		$largest['width'] = max($size['width'],$largest['width']);
 		$largest['height'] = max($size['height'],$largest['height']);
	}
	$params['resize'] = array(
		'enabled' => true,
		'width'		=> $largest['width'],
		'height'	=> $largest['height'],
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
		'plupload' => client_side_resize_plupload_params( array() ) 
	) );
}

add_action( 'wp_enqueue_media' , 'client_side_resize_load' );
