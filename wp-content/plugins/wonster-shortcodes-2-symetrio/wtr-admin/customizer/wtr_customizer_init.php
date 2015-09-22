<?php
/**
 * Customizer options
 *
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */


/*  Shortcode colors */
function wtr_customizer_shortcode_init( $wtr_menu ){

	return $wtr_menu;
} //end wtr_customizer_shortcode_init
add_filter( 'wtr_customizer_init', 'wtr_customizer_shortcode_init' );