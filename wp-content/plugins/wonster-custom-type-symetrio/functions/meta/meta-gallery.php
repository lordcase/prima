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


function wtr_create_gallery() {

	global $WTR_Opt, $wtr_custom_posts_type;
	$wtr_custom_posts_type[]	= 'gallery';

	$labels= array(
		'name' 					=> __( 'Gallery', 'wtr_ct_framework' ),
		'all_items'				=> __( 'All Gallery', 'wtr_ct_framework' ),
		'singular_name' 		=> __( 'Gallery', 'wtr_ct_framework' ),
		'add_new' 				=> __( 'Add New', 'wtr_ct_framework' ),
		'add_new_item' 			=> __( 'Add New Gallery', 'wtr_ct_framework' ),
		'edit_item' 			=> __( 'Edit Gallery', 'wtr_ct_framework' ),
		'new_item' 				=> __( 'New Gallery', 'wtr_ct_framework' ),
		'view_item' 			=> __( 'View Gallery', 'wtr_ct_framework' ),
		'search_items' 			=> __( 'Search Gallery', 'wtr_ct_framework' ),
		'not_found' 			=> __( 'No Gallery found', 'wtr_ct_framework' ),
		'not_found_in_trash'	=> __( 'No Gallery found in Trash', 'wtr_ct_framework' )
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
		'supports' 				=> array( 'title', 'thumbnail' ,'page-attributes' ),
		"show_in_nav_menus" 	=> false,
		'exclude_from_search'	=> true,
	);
	register_post_type( 'gallery', $args );
} // end wtr_create_gallery
add_action( 'init', 'wtr_create_gallery' );

// add table column in edit page
function wtr_gallery_column($columns){

	$columns = array(
		"cb" 					=> "<input type='checkbox' />",
		"title"					=> __( 'ID', 'wtr_ct_framework' ),
		"gallery_thumbnail"		=> __( 'Photo', 'wtr_ct_framework' ),
		"gallery_order"			=> __( 'Order', 'wtr_ct_framework'),
		"date"					=> __( 'Date', 'wtr_ct_framework'),
	);
	return $columns;
} // end wtr_gallery_column
add_filter("manage_edit-gallery_columns", "wtr_gallery_column");


// manage posts custom column
function wtr_gallery_custom_columns($column){

	global $post;

	switch ($column) {

		case "gallery_thumbnail":
			if( has_post_thumbnail() ){ the_post_thumbnail( array(50,50) ); }
		break;
		case "gallery_order":
			echo $post->menu_order;
		break;
	}
} // end wtr_gallery_custom_columns
add_action("manage_posts_custom_column","wtr_gallery_custom_columns");


//add meta boxes
function wtr_add_metabox_gallery(){

	$current_screen = get_current_screen();

	if( 'gallery' != $current_screen->post_type ){
		return;
	}
	$wtr_portfolio_gallery_item = new WTR_Img_Sortable( array(
			'id' 			=> '_wtr_portfolio_gallery_item',
			'class'			=> '',
			'title' 		=> __( 'Gallery item', 'wtr_ct_framework' ),
			'desc' 			=> __( 'Select photos to create a photo gallery', 'wtr_ct_framework' ),
			'value' 		=> '',
			'default_value' => '',
			'info' 			=> '',
			'allow' 		=> 'all',
			),
			array('target_type' => 'multi-img',
				  'title_modal' => __( 'Insert image url or select file from media library', 'wtr_ct_framework' ) )
	);

	require_once( WTR_ADMIN_CLASS_DIR . '/wtr_meta_box.php' );

	$wtr_GeneralSections = array(
		'id'		=> 'wtr_GeneralSections',
		'name' 		=>__( 'General', 'wtr_ct_framework' ),
		'class'		=> 'General',
		'active_tab'=> true,
		'fields'	=> array(
							$wtr_portfolio_gallery_item
					)
	);

	$wtr_meta_settings =
					array(
						'id' 		=> 'wtr-meta-post',
						'title' 	=> __('Gallery images', 'wtr_ct_framework' ),
						'page' 		=> 'gallery',
						'context' 	=> 'normal',
						'priority' 	=> 'high',
						'sections' 	=> array(
											$wtr_GeneralSections,
										)
					);

	$wtr_meta_box = NEW wtr_meta_box( $wtr_meta_settings );

}// end wtr_add_metabox_gallery
add_action( 'load-post.php', 'wtr_add_metabox_gallery' );
add_action( 'load-post-new.php', 'wtr_add_metabox_gallery' );