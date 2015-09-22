<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

if ( !defined('ABSPATH') ) { die('-1'); }

/* ---------------------------------------------------------------------------
 * Create new post type
 * --------------------------------------------------------------------------- */


function wtr_create_gym_location() {

	global $WTR_Opt, $wtr_custom_posts_type;
	$wtr_custom_posts_type[]	= 'gym_location';

	$labels= array(
		'name' 					=> __( 'Gym Location', 'wtr_ct_framework' ),
		'all_items'				=> __( 'All Gym Location', 'wtr_ct_framework' ),
		'singular_name' 		=> __( 'Gym Location', 'wtr_ct_framework' ),
		'add_new' 				=> __( 'Add New', 'wtr_ct_framework' ),
		'add_new_item' 			=> __( 'Add New Gym Location', 'wtr_ct_framework' ),
		'edit_item' 			=> __( 'Edit Gym Location', 'wtr_ct_framework' ),
		'new_item' 				=> __( 'New Gym Location', 'wtr_ct_framework' ),
		'view_item' 			=> __( 'View Gym Location', 'wtr_ct_framework' ),
		'search_items' 			=> __( 'Search Gym Location', 'wtr_ct_framework' ),
		'not_found' 			=> __( 'No Gym Location found', 'wtr_ct_framework' ),
		'not_found_in_trash'	=> __( 'No Gym Location found in Trash', 'wtr_ct_framework' )
	);

	$args = array(
		'labels' 				=> $labels,
		'public' 				=> false,
		'publicly_queryable'	=> false,
		'show_ui' 				=> true,
		'query_var' 			=> false,
		'capability_type' 		=> 'post',
		'hierarchical' 			=> false,
		'menu_position' 		=> null,
		'rewrite' 				=> true,
		'supports' 				=> array( 'title'),
		"show_in_nav_menus" 	=> false,
		'exclude_from_search'	=> true,
	);
	register_post_type( 'gym_location', $args );

}	// end wtr_create_gym_location
add_action( 'init', 'wtr_create_gym_location' );


function wtr_get_gym_location_metabox( $post_in = null ){

	$option		= array();
	if( is_null( $post_in ) OR  ! empty( $post_in ) AND is_array( $post_in ) ) {

		$args		= array( 'post_type' => 'gym_location', 'post_status' => 'any', 'posts_per_page' => -1, 'post__in' => $post_in );
		$objects	= get_posts( $args );

		foreach ( $objects as $object ) {
			$option[ $object->ID ] = ( empty( $object->post_title) ) ? __( '(no title)', 'wtr_ct_framework' ) : $object->post_title;
		}
	}
	return $option;
} // end wtr_get_gym_location_metabox


function wtr_save_metabox_gym_location( $id ){

	$post_trainers	= get_post_meta( $id, '_wtr_gym_location',true );
	$new_trainers	= ( isset( $_POST['_wtr_gym_location'] ) ) ? $_POST['_wtr_gym_location'] : '';

	delete_post_meta( $id, '_wtr_gym_location');

	if( ! empty( $new_trainers ) ){
		foreach ( $new_trainers as $trainer ) {
			add_post_meta( $id, '_wtr_gym_location', $trainer );
		}
	}
} // end wtr_save_metabox_gym_location