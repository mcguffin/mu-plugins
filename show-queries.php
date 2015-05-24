<?php

/*
Plugin Name: Show SQL Queries
Author: Jörn Lund
Author URI: http://github.org/mcguffin
Version: 0.0.1
*/
if ( defined('SAVEQUERIES') && SAVEQUERIES ) :
	if ( ! function_exists( 'show_queries' ) ) :
	function show_queries() {
		if ( ! defined('DOING_AJAX') && current_user_can( 'administrator' ) ) {
			global $wpdb;
			echo "<pre style=\"padding-left:180px;background:#fff;color:#333;white-space:pre-wrap\">";
			echo count($wpdb->queries)." Queries\n";
			print_r( $wpdb->queries );
			echo "</pre>";
		}
	}
	endif;
	add_action( 'shutdown' , 'show_queries' );
	add_action( 'show_queries' , 'show_queries' );
	
endif;

