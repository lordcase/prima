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


function wtr_create_clients() {

	global $WTR_Opt, $wtr_custom_posts_type, $wtr_custom_posts_taxonomy;
	$wtr_custom_posts_type[]	= 'clients';
	$wtr_custom_posts_taxonomy[]= 'clients-category';
	$labels= array(
		'name' 					=> __( 'Clients', 'wtr_ct_framework' ),
		'all_items'				=> __( 'All Clients', 'wtr_ct_framework' ),
		'singular_name' 		=> __( 'Client', 'wtr_ct_framework' ),
		'add_new' 				=> __('Add New', 'wtr_ct_framework' ),
		'add_new_item'			=> __('Add New client', 'wtr_ct_framework' ),
		'edit_item'				=> __( 'Edit Client', 'wtr_ct_framework' ),
		'new_item'				=> __( 'New Clients', 'wtr_ct_framework' ),
		'view_item'				=> __( 'View Clients', 'wtr_ct_framework' ),
		'search_items'			=> __( 'Search Clients', 'wtr_ct_framework' ),
		'not_found' 			=> __( 'No Clients found', 'wtr_ct_framework' ),
		'not_found_in_trash'	=> __( 'No Clients found in Trash', 'wtr_ct_framework' ),
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
		'supports'				=> array( 'title', 'thumbnail', 'page-attributes'),
		"show_in_nav_menus" 	=> false,
		'exclude_from_search'	=> true,
	);
	register_post_type( 'clients', $args );
	register_taxonomy(
		"clients-category", array("clients"), array(
			'public' 			=> false,
			'show_ui' 			=> true,
			'show_tagcloud'		=> false,
			"hierarchical" 		=> true,
			"show_in_nav_menus" => false,
			"rewrite" 			=> true,
			'labels' 			=> array(
				'name' 				=> __( 'Clients Categories', 'wtr_ct_framework' ),
				'singular_name' 	=> __( 'Clients Category', 'wtr_ct_framework' ),
				'edit_item' 		=> __( 'Edit Client Category', 'wtr_ct_framework' ),
				'search_items'		=> __( 'Search Client Category' , 'wtr_ct_framework' ),
				'all_items'			=> __( 'All Clients Categories' , 'wtr_ct_framework' ),
				'parent_item'		=> __( 'Parent Client Category' , 'wtr_ct_framework' ),
				'parent_item_colon'	=> __( 'Parent Client Category:' , 'wtr_ct_framework' ),
				'edit_item'			=> __( 'Edit Client Category' , 'wtr_ct_framework' ),
				'update_item'		=> __( 'Update Client Category' , 'wtr_ct_framework' ),
				'add_new_item'		=> __( 'Add New Client Category' , 'wtr_ct_framework' ),
				'new_item_name'		=> __( 'New Client Category Name' , 'wtr_ct_framework' ),
				'menu_name'			=> __( 'Clients Categories' , 'wtr_ct_framework' )
				)
			)
		);
} // end wtr_create_clients
add_action( 'init', 'wtr_create_clients' );


// add table column in edit page
function wtr_clients_column($columns){

	$columns = array(
		"cb" 				=> "<input type='checkbox' />",
		"client_thumbnail" 	=> __( 'Thumbnail', 'wtr_ct_framework' ),
		"title" 			=> __( 'Title', 'wtr_ct_framework' ),
		"clients_category" 	=> __( 'Clients Categories', 'wtr_ct_framework' ),
		"clients_order" 	=> __( 'Order', 'wtr_ct_framework'),
	);
	return $columns;
} // end wtr_clients_column
add_filter( "manage_edit-clients_columns", "wtr_clients_column" );


//manage posts custom column
function wtr_clients_custom_columns($column){

	global $post;

	switch ($column) {
		case "client_thumbnail":
			if( has_post_thumbnail() ){ the_post_thumbnail( array(50,50) ); }
		break;

		case "clients_category":
			echo get_the_term_list( $post->ID, 'clients-category', '', ', ','');
		break;

		case "clients_order":
			echo $post->menu_order;
		break;
	}
} // end wtr_clients_custom_columns
add_action( "manage_posts_custom_column","wtr_clients_custom_columns" );


//add meta boxes
function wtr_add_metabox_clients(){

	$current_screen = get_current_screen();

	if( 'clients' != $current_screen->post_type ){
		return;
	}

	global $WTR_Opt;

	$wtr_clients_link = new WTR_Text(array(
			'id' 			=> '_wtr_clients_link',
			'class'			=> '',
			'title' 		=> __( 'Client website', 'wtr_ct_framework' ),
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
							$wtr_clients_link,
					)
	);

	$wtr_meta_settings =
					array(
						'id' 		=> 'wtr-meta-post',
						'title' 	=> __( 'Clients Options', 'wtr_ct_framework' ),
						'page' 		=> 'clients',
						'context' 	=> 'normal',
						'priority' 	=> 'high',
						'sections' 	=> array(
											$wtr_GeneralSections
										)
					);

	$wtr_meta_box = NEW wtr_meta_box( $wtr_meta_settings );

} // end wtr_add_metabox_clients
add_action( 'load-post.php', 'wtr_add_metabox_clients' );
add_action( 'load-post-new.php', 'wtr_add_metabox_clients' );