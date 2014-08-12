<?php
/*
Plugin Name: Fix get_adjacent_post
Description: Fixes WP core issue. See Ticket #8107 http://core.trac.wordpress.org/ticket/8107
Author: joern lund
Author URI: http://github.org/mcguffin
Version: 0.0.2
*/

/*
let people define sort criteria by post type.
*/

function adjfix_post_where( $where ) {
	global $post, $wpdb;

	if ( ! $post_ID = get_the_ID() )
		return $where;
	
	$op = current_filter() == 'get_previous_post_where' ? '<' : '>';

	// ** PHP strtotime() and MySQL UNIX_TIMESTAMP() strtotime are timezone aware, but we cannot be sure, if timezones are configured correctly in both systems. ** //
	// ** Need to make sure both use the GMT timestamp. ** //
	$sortval = strtotime($post->post_date_gmt . " GMT") . '.' . str_pad( intval( $post_ID ) , 12 , '0' , STR_PAD_LEFT ); 
	$replace = " (UNIX_TIMESTAMP(p.post_date_gmt) + ( UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(UTC_TIMESTAMP()) ) + CAST(p.ID*0.000000000001 AS DECIMAL(12,12)) ) $op $sortval";
	$where = str_replace(" p.post_date $op '$post->post_date'" , $replace, $where );
	return $where;
}

function adjfix_post_sort( $sort ) {
	if ( ! $post_ID = get_the_ID() )
		return $sort;// 
	return str_replace('ORDER BY p.post_date ASC','ORDER BY (UNIX_TIMESTAMP(p.post_date_gmt) + ( UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(UTC_TIMESTAMP()) ) + CAST(p.ID*0.000000000001 AS DECIMAL(12,12)) ) ASC' , $sort );
}

add_filter( 'get_previous_post_where','adjfix_post_where' );
add_filter( 'get_next_post_where','adjfix_post_where' );

add_filter( 'get_previous_post_sort','adjfix_post_sort');
add_filter( 'get_next_post_sort','adjfix_post_sort');

