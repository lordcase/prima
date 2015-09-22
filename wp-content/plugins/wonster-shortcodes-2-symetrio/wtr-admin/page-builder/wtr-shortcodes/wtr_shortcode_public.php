<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

// Don't load directly
if ( !defined('ABSPATH') ) { die('-1'); }


function wtr_highlight_shortcode( $atts, $content ) {
	$result = '<span class="wtrShtMark">' . $content . '</span>';
	return $result;
} // end wtr_highlight_shortcode
add_shortcode( 'wtr_highlight', 'wtr_highlight_shortcode' );