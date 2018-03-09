<?php

/*
Plugin Name: Debugging tools
Description: Profiler, disable server cache, show DB queries
Author: Jörn Lund
Author URI: http://github.org/mcguffin
Version: 0.0.3
*/

/**
 *	Performance measurement.
 *	Usage:
 *	<?php
 *		// Start
 *		WP_Profiler::log('Startup');
 *		WP_Profiler::log('Done something...');
 *
 *		// show the result
 *		WP_Profiler::dump();
 *	?>
 */
if ( ! class_exists( 'WP_Profiler' ) ) :
class WP_Profiler {
	private static $_instance=null;
	private $started = 0;
	private $entries = 0;

	public static function instance(){
		if ( is_null( self::$_instance ) )
			self::$_instance = new self();
		return self::$_instance;
	}

	private function __construct( ) {
		$this->started = microtime( true );
		$this->mem_started = memory_get_usage();
		$this->entries = array();
		if ( defined('WP_DEBUG') && WP_DEBUG && function_exists('add_action') ) {
			add_action( 'shutdown' , array( __CLASS__ , 'dump' ) );
		}
	}
	public static function log( $what ){
		self::instance()->entries[] = array(
			'what'	=> $what,
			'time'	=> microtime( true ),
			'mem'	=> memory_get_usage(),
		);
	}
	public static function dump( ) {
		$last = 0;
		$mlast = self::instance()->mem_started;
		if ( count( self::instance()->entries ) ) {
			self::log('Shutdown');
			?><pre><?php
			echo "TIME                 | TIME SINCE LAST      | MEMORY       |  MEMORY DIFF | WHAT  \n";
			foreach ( self::instance()->entries as $i => $entry ) {
				$t = $entry['time'] - self::instance()->started;
				$diff = $t - $last;
				$m = $entry['mem'];
				$mdiff = $m - $mlast;
				echo str_pad( number_format( $t , 16 , '.' , '') , 20, ' ', STR_PAD_RIGHT);
				echo " | ";
				echo str_pad( number_format( $diff , 16 , '.' , '') , 20, ' ', STR_PAD_RIGHT);
				echo " | ";
				echo str_pad( $m , 12 ,' ', STR_PAD_LEFT);
				echo " | ";
				echo str_pad( $mdiff , 12 ,' ', STR_PAD_LEFT);
				echo " | ";
				echo $entry['what'];
				echo "\n";
				$last = $t;
				$mlast = $m;
			}
			?></pre><?php
		}
	}
}
if ( defined('WP_DEBUG') && WP_DEBUG ) {
	WP_Profiler::instance();
}
endif;


/**
 *	Disable Server cache
 */
if ( defined('WP_DEBUG') && WP_DEBUG && ! is_admin() ) {
	if ( ! function_exists( 'disable_cachify' ) ) :
	function disable_cachify() {
		remove_action('plugins_loaded' , array('Cachify','instance') );
	}
	endif;
	add_action('plugins_loaded','disable_cachify',9);
}


/**
 *	Show DB Queries on shutdown
 */
if ( defined('SAVEQUERIES') && SAVEQUERIES ) :
	function show_queries() {
		if (  defined('WP_DEBUG') && WP_DEBUG &&
			! defined('DOING_AJAX') &&
			(strpos($_SERVER['SERVER_NAME'],'.local') !== false || current_user_can( 'administrator' ) )) {
			global $wpdb;
			echo "<pre style=\"padding-left:180px;background:#fff;color:#333;white-space:pre-wrap\">";
			echo count($wpdb->queries)." Queries\n";
			print_r( $wpdb->queries );
			echo "</pre>";
		}
	}
	add_action( 'shutdown' , 'show_queries' );
	add_action( 'show_queries' , 'show_queries' );

endif;




/**
 *	Disable script optimization
 */
if ( defined('SCRIPT_DEBUG') && SCRIPT_DEBUG && ! is_admin() ) :
	add_filter('pre_option_autoptimize_css','__return_zero');
	add_filter('pre_option_autoptimize_js','__return_zero');
endif;
