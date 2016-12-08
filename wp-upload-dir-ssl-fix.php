<?php

/*
Plugin Name: Fix WP Core issue #25449
Description: wp_upload_dir() doesn't support https, https://core.trac.wordpress.org/ticket/25449
Author: Jörn Lund
Author URI: http://github.org/mcguffin
Version: 0.0.1
*/

function _wp_fix_issue_25449($upload_dir) {
	if ( is_ssl() ) {
		$upload_dir['url']     = set_url_scheme( $upload_dir['url'] , 'https' );
		$upload_dir['baseurl'] = set_url_scheme( $upload_dir['baseurl'] , 'https' );
	} else {
		$upload_dir['url']     = set_url_scheme( $upload_dir['url'] , 'http' );
		$upload_dir['baseurl'] = set_url_scheme( $upload_dir['baseurl'] , 'http' );
	}
	return $upload_dir;
}

add_filter( 'upload_dir' , '_wp_fix_issue_25449' );
