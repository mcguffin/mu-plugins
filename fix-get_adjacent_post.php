<?php
/*
Plugin Name: Fix get_adjacent_post
Description: Fixes WP core issue. See Tickets http://core.trac.wordpress.org/ticket/8107, https://core.trac.wordpress.org/ticket/28026 by applying this patch: https://core.trac.wordpress.org/attachment/ticket/28026/refresh.28026.diff
Author: joern lund, @lektro
Author URI: http://github.org/mcguffin
Version: 0.0.3
*/

/*
*/

function adjfix_post_where( $where ) {
	global $post, $wpdb;

	if ( ! $post_ID = get_the_ID() )
		return $where;
	
	$op = current_filter() == 'get_previous_post_where' ? '<' : '>';

	$serach = $wpdb->prepare( "WHERE p.post_date $op %s", $post->post_date );
	$replace = $wpdb->prepare("WHERE ( p.post_date $op %s OR ( p.post_date = %s AND p.ID $op %d ) ) ", $post->post_date, $post->post_date, $post_ID );
	$where = str_replace( $search, $replace, $where );

	return $where;
}
add_filter( 'get_previous_post_where','adjfix_post_where' );
add_filter( 'get_next_post_where','adjfix_post_where' );

