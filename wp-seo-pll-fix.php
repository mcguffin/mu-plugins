<?php
/*
Plugin Name: WP-SEO / Polylang fix
Description: Fix missing SEO-Columns after quick edit when Polylang is enabled
Author: Jörn Lund
Author URI: http://github.org/mcguffin
Version: 0.0.1
*/

// Init WP-SEO Admin class when PLL is saving
function wpseo_ppl_admin_init() {
	if ( function_exists( 'wpseo_admin_init' ) ) {
		wpseo_admin_init();
	}
}

if ( defined( 'DOING_AJAX' ) && DOING_AJAX && filter_input( INPUT_POST, 'action' ) === 'pll_update_post_rows' ) {
	add_action( 'plugins_loaded', 'wpseo_ppl_admin_init', 15 );
	// Always show WP-SEO admin cols.
	add_filter( 'wpseo_always_register_metaboxes_on_admin', '__return_true' );
}

