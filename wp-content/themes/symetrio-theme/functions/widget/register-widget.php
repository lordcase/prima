<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

if ( !defined('ABSPATH') ) { die('-1'); }

if( ! function_exists( 'wtr_register_widget' ) ){

	// Add New widgets
	function wtr_register_widget(){

		register_widget( 'WTR_Tag_Cloud_Widget' );
		register_widget( 'WTR_Widget_Tweets' );
		register_widget( 'WTR_Recent_Posts_Widget' );
		register_widget( 'WTR_Todays_Open_Hours_Widget' );
		register_widget( 'WTR_Open_Hours_Widget' );
		register_widget( 'WTR_Social_Links_Widget' );
		register_widget( 'WTR_Menu_Widget' );
		register_widget( 'WTR_Recent_Comments_Widget' );
		register_widget( 'WTR_Promo_Box_Widget' );
		register_widget( 'WTR_Facebook_Like_Box_Widget' );
	} // end wtr_register_widget
	add_action( 'widgets_init' , 'wtr_register_widget' );
}


if( ! function_exists( 'wtr_register_sidebars' ) ){

	// register custom sidebars
	function wtr_register_sidebars() {

		global $WTR_Opt;

		// footer
		$array_fotter = array(
			__( 'Footer column One', WTR_THEME_NAME ),
			__( 'Footer column Two', WTR_THEME_NAME ),
			__( 'Footer column Three', WTR_THEME_NAME ),
			__( 'Footer column Four', WTR_THEME_NAME ),
			__( 'Footer column Five', WTR_THEME_NAME ), // center
		);

		foreach ($array_fotter as $key => $value) {
			register_sidebar( array(
			'name'          => $value,
			'id'            => 'footer-column-' . $key ,
			'description'   => '',
			'class'         => '',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' 	=> '</div>',
			'before_title' 	=> '<h6>',
			'after_title' 	=> '</h6>',
			));
		}

		// custom theme sidebar
		$sidebar_id = 0;
		$wtr_sidebars = $WTR_Opt->getopt( 'wtr_SidebraManagement' ) ;

		if( $wtr_sidebars ) {
			foreach ( $wtr_sidebars as $sidebar ) {

				$sidebar_id = str_replace( '-', urlencode('&#45;'), $sidebar );
				$sidebar_id = sanitize_title( str_replace( "%",'', $sidebar_id ) );
				$sidebar_id = 'custom-sidebar-' . $sidebar_id;

				register_sidebar( array(
					'name'          => urldecode( $sidebar ),
					'id'            => $sidebar_id,
					'description'   => '',
					'class'         => '',
					'before_widget' => '<div id="%1$s" class="widget %2$s">',
					'after_widget' 	=> '</div>',
					'before_title' 	=> '<h6>',
					'after_title' 	=> '</h6>',
					)
				);
			}
		}

	} // end wtr_register_sidebars
	add_action( 'widgets_init', 'wtr_register_sidebars' );
}