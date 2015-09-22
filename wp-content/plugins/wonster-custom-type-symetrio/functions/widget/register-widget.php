<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

if ( !defined('ABSPATH') ) { die('-1'); }

if( ! function_exists( 'wtr_ct_register_widget' ) ){

	// Add New widgets
	function wtr_ct_register_widget(){

		register_widget( 'WTR_Recent_Gallery_Widget' );
		register_widget( 'WTR_Testimonials_Widget' );
		register_widget( 'WTR_Pass_Widget' );
		register_widget( 'WTR_Trainers_Widget' );
		register_widget( 'WTR_Events_Widget' );
		register_widget( 'WTR_Events_Upcoming_Widget' );
	} // end wtr_ct_register_widget
	add_action( 'widgets_init' , 'wtr_ct_register_widget' );
}