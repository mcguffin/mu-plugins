<?php

/*
Plugin Name: Matomo OptOut shortcode
Description: Use shortcode <code>[matomo_optout]</code> to include the Matomo out-out iframe html.
Author: Jörn Lund
Author URI: http://github.org/mcguffin
Version: 0.0.2
*/


function get_matomo_optout_iframe_html( $attr ) {
	$html = '';
	if ( ! isset($GLOBALS ['wp-piwik']) ) {
		return $html;
	}
	$map_attr = array(
		'backgroundColor'	=> 'backgroundcolor',
		'fontColor'			=> 'fontcolor',
		'fontSize'			=> 'fontsize',
		'fontFamily'		=> 'fontfamily',
		'idsite'			=> 'idsite',
	);
	$qargs = array(
		'module' 	=> 'CoreAdminHome',
		'action' 	=> 'optOut',
		'language'	=> substr(get_bloginfo('language'),0,2),
	);
	foreach ( $map_attr as $key => $key_lc ) {
		if ( isset( $attr[ $key_lc ] ) ) {
			$val = $attr[ $key_lc ];
			if ( false !== strpos( $key_lc, 'color') ) {
				$val = str_replace( '#', '', $val );
			} else if ( $key_lc === 'fontsize' && is_numeric($val) ) {
				$val .= 'px';
			}
			$qargs[$key] = $val;
		} else {
			$qargs[$key] = '';
		}
	}

	$matomo_url = $GLOBALS['wp-piwik']->getGlobalOption('piwik_url');
	if ( ! empty($matomo_url) && ! empty($matomo_url) ) {
		$qargs['language'] = substr(get_bloginfo('language'),0,2);
		$iframe_src = add_query_arg( $qargs, $matomo_url );
		$iframe_src = set_url_scheme( $iframe_src, is_ssl() ? 'https' : 'http' );
		$html .= sprintf('<iframe class="matomo-optout" style="border: 0; height: 250px; width: 600px;" style="border: 0;" src="%s"></iframe>',$iframe_src);

	}
	return apply_filters('matomo_optout', $html );
}

add_shortcode('matomo_optout','get_matomo_optout_iframe_html');
