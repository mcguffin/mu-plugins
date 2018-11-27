<?php

namespace EmailObfuscator;

class JSCryptObfuscator extends EmailObfuscator {

	private $key;

	/**
	 *	@action init
	 */
	public function init() {
		parent::init();
		$this->key = random_bytes(32);
		//$this->key = base64_encode( $k );

		if ( ! is_admin() && ! is_customize_preview() && ! wp_get_current_user()->ID ) {

			add_action( 'wp_head' , array( $this, 'enqueue_script' ) );

		}

	}

	function replace_email_address( $email ) {
		return sprintf('<span data-obfuscated="%s">%s</span>', base64_encode($this->crypt( $email, 1 )), __('(Undisclosed Email Address)','mu-plugins') );
	}

	function replace_email_link( $link ) {
		return sprintf('<a href="#" data-obfuscated="%s">%s</a>', base64_encode( $this->crypt( $link, 1 )), __('(Undisclosed Email Address)','mu-plugins') );
	}


	/**
	 *	@action wp_head
	 */
	function enqueue_script() {
		wp_register_script( 'email-obfuscation' , plugins_url( 'js/js-crypt.js' , __FILE__ ) , array( 'jquery' ), '0.1.1', true );
		wp_localize_script( 'email-obfuscation' , 'email_obfuscator' , array(
			'key' => base64_encode($this->key),
		) );
		wp_enqueue_script( 'email-obfuscation' );
	}

	private function crypt( $str, $dir=1 ) {
		// simple char rotation

		$this->klen = strlen($this->key);
		$this->cdir = $dir;

		$arr = str_split( $str );
		$ret = array_walk( $arr, [ $this, 'chr_crypt'] );
		return implode( '', $arr );
		// return str.split('').map( function(s,i) {
		// 	return String.fromCharCode( s.charCodeAt(0) + key.charCodeAt(i%len)*enc );
		// }).join('');
	}
	private function chr_crypt(&$chr,$i) {
		error_log( ord( $this->key[ $i % $this->klen ]) );
		$chr = chr( ord( $chr ) + ord( $this->key[ $i % $this->klen ] ) * $this->cdir );
	}
}


JSCryptObfuscator::instance();
