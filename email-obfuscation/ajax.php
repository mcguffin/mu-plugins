<?php

namespace EmailObfuscator;

class AjaxObfuscator extends EmailObfuscator {

	/**
	 *	@action init
	 */
	public function init() {
		parent::init();

		if ( ! is_admin() && ! is_customize_preview() && ! wp_get_current_user()->ID ) {

			add_action( 'wp_head' , array( $this, 'enqueue_script' ) );
			add_action( 'shutdown' , array( $this , 'store_fragments' ) , 99 , 0 );

		}

		if ( defined( 'DOING_AJAX' ) ) {
			add_action( 'wp_ajax_get_email_fragments' , array( $this , 'ajax_get_fragments' ) );
			add_action( 'wp_ajax_nopriv_get_email_fragments' , array( $this , 'ajax_get_fragments' ) );
		}

	}


	/**
	 *	@action wp_ajax_get_email_fragments
	 *	@action wp_ajax_nopriv_get_email_fragments
	 */
	function ajax_get_fragments( ) {
		// get referrer
		$key = $this->_get_cache_key( $_SERVER['HTTP_REFERER'] );
		if ( $result = get_option( $key ) ) {
			header('Content-Type: application/json');
			echo $result;
		}
		exit();
	}


	function replace_email_link( $link ) {
		$hash = md5($link);
		$this->map_fragments[$hash] = $link;

		return sprintf( '<a href="#%1$s" data-load-fragment="%1$s">%2$s</a>' ,
			$hash ,
			__('(Click to show Email Link)' , 'mu-plugins' )
		);

	}

	function replace_email_address( $email ) {
		$hash = md5( $email );

		$this->map_fragments[$hash] = $email;

		return sprintf( '<span data-load-fragment="%s">%s</span>' ,
			$hash,
			__('(Click to show Email Address)' , 'mu-plugins' )
		);

	}


	/**
	 *	@action wp_head
	 */
	function enqueue_script() {
		wp_register_script( 'email-obfuscation' , plugins_url( 'js/ajax.js' , __FILE__ ) , array( 'jquery' ), '0.1.1', true );
		wp_localize_script( 'email-obfuscation' , 'email_obfuscator' , array(
			'ajax_url' => admin_url('admin-ajax.php',is_ssl() ? 'https' : 'http' ),
		) );
		wp_enqueue_script( 'email-obfuscation' );
	}
	/**
	 *	@action shutdown
	 */
	function store_fragments() {
		update_option( $this->_get_cache_key( $_SERVER['REQUEST_URI'] ), json_encode( $this->map_fragments ), false );
	}

	/**
	 *	@param string $url
	 *	@return string  filepath
	 */
	private function _get_cache_key( $url ) {

		$hash_url = ( parse_url($url, PHP_URL_PATH) . '?' . parse_url( $url, PHP_URL_QUERY ) );
		return '_email_obfus_' . md5( $hash_url . NONCE_SALT );
	}
}

AjaxObfuscator::instance();
