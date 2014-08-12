<?php
// /*
// Plugin Name: Fix oembed URLs
// Description: Match oembed http protocols to site protocol. As described in http://wordpress.stackexchange.com/a/113550/35723
// Author: joern lund, WP Stackexchange User brandt
// Author URI: http://github.org/mcguffin
// Version: 0.0.2
// */


// 

function my_embed_oembed_html( $html ) {
	$protocol = is_ssl() ? 'https' : 'http';
    return preg_replace( '@src="https?:@', 'src="'.$protocol.':', $html );
}
add_filter( 'embed_oembed_html', 'my_embed_oembed_html' );