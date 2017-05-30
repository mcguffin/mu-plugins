<?php

/*
Plugin Name: Load µPlugins 
Description: Load and init mu-plugins
Author: Jörn Lund
Author URI: http://github.org/mcguffin
Version: 0.0.2
*/

function muplugins_load_textdomain() { 
	load_muplugin_textdomain( 'mu-plugins', 'languages' );
}
add_action( 'plugins_loaded' , 'muplugins_load_textdomain' );



/**
 *	Disable comments
 *	git@github.com:solarissmoke/disable-comments-mu.git
 */
include dirname(__FILE__) .  '/disable-comments-mu/disable-comments-mu.php';
add_action('widgets_init',function() {
	include_once dirname(__FILE__) .  '/widgets/PostType_Taxonomy_Widget.php';
	register_widget( 'PostType_Taxonomy_Widget' );
});
