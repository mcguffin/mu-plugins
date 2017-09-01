<?php

/*
Plugin Name: Fix PHP Exception with Polylang and duplicate posts
Description: ...
Author: Jörn Lund
Author URI: http://github.org/mcguffin
Version: 0.0.1
*/

function muplugins_pll_duplicate_post_fix( $val ) {
	if ( is_string($val) ) {
		if ( $val === '' ) {
			return array();
		}
		return (array) $val;
	}
	return $val;
}

add_filter( 'option_duplicate_post_taxonomies_blacklist', 'muplugins_pll_duplicate_post_fix', 0 );