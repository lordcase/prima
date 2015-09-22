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


function wtr_create_testimonial() {

	global $WTR_Opt, $wtr_custom_posts_type, $wtr_custom_posts_taxonomy;
	$wtr_custom_posts_type[]	= 'testimonial';
	$wtr_custom_posts_taxonomy[]= 'testimonial-category';

	$labels= array(
		'name' 					=> __( 'Testimonials', 'wtr_ct_framework' ),
		'all_items'				=> __( 'All Testimonials', 'wtr_ct_framework' ),
		'singular_name' 		=> __( 'Testimonial', 'wtr_ct_framework' ),
		'add_new' 				=> __( 'Add New', 'wtr_ct_framework' ),
		'add_new_item' 			=> __( 'Add New Testimonial', 'wtr_ct_framework' ),
		'edit_item' 			=> __( 'Edit Testimonial', 'wtr_ct_framework' ),
		'new_item' 				=> __( 'New Testimonial', 'wtr_ct_framework' ),
		'view_item' 			=> __( 'View Testimonials', 'wtr_ct_framework' ),
		'search_items' 			=> __( 'Search Testimonials', 'wtr_ct_framework' ),
		'not_found' 			=>  __( 'No Testimonials found', 'wtr_ct_framework' ),
		'not_found_in_trash'	=> __( 'No Testimonials found in Trash', 'wtr_ct_framework' )
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
		'supports' 				=> array( 'title', 'thumbnail','page-attributes' ),
		"show_in_nav_menus" 	=> false,
		'exclude_from_search'	=> true,
	);
	register_post_type( 'testimonial', $args );
	register_taxonomy(
		"testimonial-category", array("testimonial"), array(
			'public' 			=> false,
			'show_ui' 			=> true,
			'show_tagcloud'		=> false,
			"hierarchical" 		=> true,
			"show_in_nav_menus" => false,
			"rewrite" => true,
			'labels' 			=> array(
				'name' 				=> __( 'Testimonials Categories', 'wtr_ct_framework' ),
				'singular_name' 	=> __( 'Testimonial Category', 'wtr_ct_framework' ),
				'edit_item' 		=> __( 'Edit Testimonial Category', 'wtr_ct_framework' ),
				'search_items'		=> __( 'Search Testimonial Category' , 'wtr_ct_framework' ),
				'all_items'			=> __( 'All Testimonial Categories' , 'wtr_ct_framework' ),
				'parent_item'		=> __( 'Parent Testimonial Category' , 'wtr_ct_framework' ),
				'parent_item_colon'	=> __( 'Parent Testimonial Category:' , 'wtr_ct_framework' ),
				'edit_item'			=> __( 'Edit Testimonial Category' , 'wtr_ct_framework' ),
				'update_item'		=> __( 'Update Testimonial Category' , 'wtr_ct_framework' ),
				'add_new_item'		=> __( 'Add New Testimonial Category' , 'wtr_ct_framework' ),
				'new_item_name'		=> __( 'New Testimonial Category Name' , 'wtr_ct_framework' ),
				'menu_name'			=> __( 'Testimonials Categories' , 'wtr_ct_framework' )
				),
			)
		);
} // end wtr_create_testimonial
add_action( 'init', 'wtr_create_testimonial' );


// add table column in edit page
function wtr_testimonial_column($columns){

	$columns = array(
		"cb" 					=> "<input type='checkbox' />",
		"title"					=> __( 'ID', 'wtr_ct_framework' ),
		"testimonial_thumbnail"	=> __( 'Photo', 'wtr_ct_framework' ),
		"testimonial_author"	=> __( 'Author', 'wtr_ct_framework' ),
		"testimonial_content"	=> __( 'Content', 'wtr_ct_framework' ),
		"testimonial_category"	=> __( 'Categories', 'wtr_ct_framework' ),
		"testimonial_order"		=> __( 'Order', 'wtr_ct_framework'),
		"date"					=> __( 'Date', 'wtr_ct_framework'),
	);
	return $columns;
} // end wtr_testimonial_column
add_filter("manage_edit-testimonial_columns", "wtr_testimonial_column");


// manage posts custom column
function wtr_testimonial_custom_columns($column){

	global $post;

	switch ($column) {
		case "testimonial_author":
			echo get_post_meta( get_the_ID(), '_wtr_testimonial_author', true );
		break;

		case"testimonial_content":
			$desc = get_post_meta( get_the_ID(), '_wtr_testimonial_desc', true );
			echo wp_html_excerpt( $desc, 80, '...' );
		break;

		case "testimonial_thumbnail":
			if( has_post_thumbnail() ){ the_post_thumbnail( array(50,50) ); }
		break;

		case "testimonial_category":
			echo get_the_term_list($post->ID, 'testimonial-category', '', ', ','');
		break;
		case "testimonial_order":
			echo $post->menu_order;
		break;
	}
} // end wtr_testimonial_custom_columns
add_action("manage_posts_custom_column","wtr_testimonial_custom_columns");


// change title
function wtr_testimonial_change_title( $title ){
	$screen = get_current_screen();
	if ( 'testimonial' == $screen->post_type ) {
		$title = __( 'Enter Testimonial`s ID', 'wtr_ct_framework' );
	}
	return $title;
} // end wtr_testimonial_change_title
add_filter( 'enter_title_here', 'wtr_testimonial_change_title' );


//add meta boxes
function wtr_add_metabox_testimonial(){

	$current_screen = get_current_screen();

	if( 'testimonial' != $current_screen->post_type ){
		return;
	}

	global $WTR_Opt;

	$wtr_testimonial_desc = new WTR_Textarea( array(
			'id' 			=> '_wtr_testimonial_desc',
			'class' 		=> '',
			'rows' 			=> 10,
			'title' 		=> __( 'Content', 'wtr_ct_framework' ),
			'desc' 			=> '',
			'value' 		=> '',
			'default_value' => '',
			'info' 			=> '',
			'allow' 		=> 'all',
		)
	);

	$wtr_testimonial_author = new WTR_Text(array(
			'id' 			=> '_wtr_testimonial_author',
			'class'			=> '',
			'title' 		=> __( 'Author', 'wtr_ct_framework' ),
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
							$wtr_testimonial_author,
							$wtr_testimonial_desc
					)
	);

	$wtr_meta_settings =
					array(
						'id' 		=> 'wtr-meta-post',
						'title' 	=> __('Testimonial Options', 'wtr_ct_framework' ),
						'page' 		=> 'testimonial',
						'context' 	=> 'normal',
						'priority' 	=> 'high',
						'sections' 	=> array(
											$wtr_GeneralSections,
										)
					);

	$wtr_meta_box = NEW wtr_meta_box( $wtr_meta_settings );

} // end wtr_add_metabox_testimonial
add_action( 'load-post.php', 'wtr_add_metabox_testimonial' );
add_action( 'load-post-new.php', 'wtr_add_metabox_testimonial' );