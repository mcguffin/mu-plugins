<?php

/*
Plugin Name: Client side image Resizing
Description: Resize Images in the Browser before they get uploaded.
Author: Jörn Lund
Author URI: http://github.org/mcguffin
Version: 0.0.3
*/

namespace MUPlugins;

/**
 * Return all available image sizes.
 * (Copied from http://codex.wordpress.org/Function_Reference/get_intermediate_image_sizes)
 *
 */
class ClientSideImageResize {

	private static $inst = null;

	public static function instance() {
		if ( is_null( self::$inst ) ) {
			self::$inst = new self();
		}
		return self::$inst;
	}

	private function __clone() {}

	/**
	 *
	 */
	private function __construct() {
		add_filter( 'plupload_init', array( $this, 'plupload_params' ) , 20);
		add_action( 'wp_enqueue_media' , array( $this, 'enqueue_scripts' ) );

	}

	/**
	 *	@action wp_enqueue_media
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( 'client-resize' , plugins_url( 'client-side-image-resize.js' , __FILE__ ) , array('media-editor' ) , '0.0.3' );
		wp_localize_script( 'client-resize' , 'client_resize' , array(
			'plupload' => $this->plupload_params( array() )
		) );
	}

	/**
	 *	@filter plupload_init
	 */
	public function plupload_params( $params ) {
		// get biggest possible image
		$sizes = $this->get_image_sizes();
		$largest = array( 'width'=>0 , 'height'=>0 );
		foreach ( $sizes as $size ) {
			$h = intval( $size['height'] );
			$w = intval( $size['width'] );
			if ( ! $h ) {
				$h = $w * 1.5; // use 2:3 regular photo ratio
			}
			$largest['width'] = max( $w, $largest['width'] );
	 		$largest['height'] = max( $h, intval($largest['height'] ) );
		}
		$params['resize'] = array(
			'enabled' => true,
			'width'		=> intval( $largest['width'] ),
			'height'	=> intval( $largest['height'] ),
			'quality'	=> 90
		);
		return $params;
	}

	/**
	 *	Get registered image size(s) properties
	 *
	 *	@param string $size specific size to get
 	 *	@return array sizes or single size
	 */
	private function get_image_sizes( $size = '' ) {

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
}

ClientSideImageResize::instance();
