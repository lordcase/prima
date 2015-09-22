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


function wtr_create_events_organizers() {

	global $WTR_Opt, $wtr_custom_posts_type;
	$wtr_custom_posts_type[]	= 'events_organizers';

	$labels= array(
		'name' 					=> __( 'Organizer', 'wtr_ct_framework' ),
		'all_items'				=> __( 'All Organizers', 'wtr_ct_framework' ),
		'singular_name' 		=> __( 'Organizer', 'wtr_ct_framework' ),
		'add_new' 				=> __( 'Add New', 'wtr_ct_framework' ),
		'add_new_item' 			=> __( 'Add New Organizer', 'wtr_ct_framework' ),
		'edit_item' 			=> __( 'Edit Organizer', 'wtr_ct_framework' ),
		'new_item' 				=> __( 'New Organizer', 'wtr_ct_framework' ),
		'view_item' 			=> __( 'View Organizer', 'wtr_ct_framework' ),
		'search_items' 			=> __( 'Search Organizer', 'wtr_ct_framework' ),
		'not_found' 			=> __( 'No Organizers found', 'wtr_ct_framework' ),
		'not_found_in_trash'	=> __( 'No Organizers in Trash', 'wtr_ct_framework' )
	);

	$args = array(
		'labels' 				=> $labels,
		'public' 				=> false,
		'publicly_queryable' 	=> false,
		'show_ui' 				=> true,
		'show_in_menu'			=> 'edit.php?post_type=events',
		'query_var' 			=> false,
		'capability_type' 		=> 'post',
		'hierarchical' 			=> false,
		'menu_position' 		=> null,
		"show_in_nav_menus" 	=> false,
		'exclude_from_search' 	=> true,
		'rewrite' 				=> true,
		'supports' 				=> array( 'title' )
	);
	register_post_type( 'events_organizers', $args );

}	// end wtr_create_events_organizers
add_action( 'init', 'wtr_create_events_organizers' );


// add table column in edit page
function wtr_events_organizers_column($columns){

	$columns = array(
		"cb" 						=> "<input type='checkbox' />",
		"title"						=> __( 'title', 'wtr_ct_framework' ),
		"events_organizers_address"	=> __( 'Address', 'wtr_ct_framework' ),
	);
	return $columns;
} // end wtr_events_organizers_column
add_filter("manage_edit-events_organizers_columns", "wtr_events_organizers_column");


// manage posts custom column
function wtr_events_organizers_custom_columns($column){

	global $post;

	switch ($column) {
		case "events_organizers_address":
			echo get_post_meta( $post->ID, '_wtr_events_organizers_address', true );
		break;
	}
} // end wtr_events_organizers_custom_columns
add_action("manage_posts_custom_column","wtr_events_organizers_custom_columns");


//add meta boxes
function wtr_add_metabox_events_organizers(){

	$current_screen = get_current_screen();

	if( 'events_organizers' != $current_screen->post_type ){
		return;
	}

	global $WTR_Opt;

	$wtr_events_organizers_address = new WTR_Text( array(
			'id' 			=> '_wtr_events_organizers_address',
			'title' 		=> __( 'Address', 'wtr_ct_framework' ),
			'desc' 			=> '',
			'value' 		=> '',
			'default_value' => '',
			'info' 			=> '',
			'allow' 		=> 'all',
		)
	);

	$wtr_events_organizers_email = new WTR_Text( array(
			'id' 			=> '_wtr_events_organizers_email',
			'class'			=> '',
			'title' 		=> __( 'E-mail', 'wtr_ct_framework' ),
			'desc' 			=> '',
			'value' 		=> '',
			'default_value' => '',
			'info' 			=> '',
			'allow' 		=> 'all',
		)
	);

	$wtr_events_organizers_url = new WTR_Text( array(
			'id' 			=> '_wtr_events_organizers_url',
			'class'			=> '',
			'title' 		=> __( 'URL', 'wtr_ct_framework' ),
			'desc' 			=> '',
			'value' 		=> '',
			'default_value' => '',
			'info' 			=> '',
			'allow' 		=> 'all',
		)
	);

	$wtr_events_organizers_phone = new WTR_Text( array(
			'id' 			=> '_wtr_events_organizers_phone',
			'class'			=> '',
			'title' 		=> __( 'Phone number', 'wtr_ct_framework' ),
			'desc' 			=> '',
			'value' 		=> '',
			'default_value' => '',
			'info' 			=> '',
			'allow' 		=> 'all',
		)
	);


	require_once( WTR_ADMIN_CLASS_DIR . '/wtr_meta_box.php' );

	$wtr_GeneralSections = array(
		'id'		=> 'wtr_GeneralSections',
		'name' 		=>__( 'General', 'wtr_ct_framework' ),
		'class'		=> 'General',
		'active_tab'=> true,
		'fields'	=> array(
							$wtr_events_organizers_address,
							$wtr_events_organizers_email,
							$wtr_events_organizers_url,
							$wtr_events_organizers_phone,
					)
	);

	$wtr_meta_settings =
					array(
						'id' 		=> 'wtr-meta-post',
						'title' 	=> __('Organizer Options', 'wtr_ct_framework' ),
						'page' 		=> 'events_organizers',
						'context' 	=> 'normal',
						'priority' 	=> 'high',
						'sections' 	=> array(
											$wtr_GeneralSections
											)
					);

	$wtr_meta_box						= NEW wtr_meta_box( $wtr_meta_settings );

} // end wtr_add_metabox_events_organizers
add_action( 'load-post.php', 'wtr_add_metabox_events_organizers' );
add_action( 'load-post-new.php', 'wtr_add_metabox_events_organizers' );


function wtr_get_events_organizers( $post_in = null, $none = false ){

	$option		= array();
	if( is_null( $post_in ) OR  ! empty( $post_in ) AND is_array( $post_in ) ) {

		$args		= array( 'post_type' => 'events_organizers', 'post_status' => 'any', 'posts_per_page' => -1, 'post__in' => $post_in );
		$objects	= get_posts( $args );

		if( $objects ) {
			if( $none ) {
				$option[] = __( 'None', 'wtr_ct_framework' );
			}
			foreach ( $objects as $object ) {
				$option[ $object->ID ] = ( empty( $object->post_title) ) ? __( '(no title)', 'wtr_ct_framework' ) : $object->post_title;
			}
		}
	}
	return $option;
} // end wtr_get_events_organizers