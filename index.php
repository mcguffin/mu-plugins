<?php

/*
Plugin Name: Load µPlugins 
Author: Jörn Lund
Author URI: http://github.org/mcguffin
Version: 0.0.1
*/

function muplugins_load_textdomain() { 
	load_muplugin_textdomain( 'mu-plugins', 'languages' );
}
add_action( 'plugins_loaded' , 'muplugins_load_textdomain' );
