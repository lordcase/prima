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


function wtr_create_events() {

	global $WTR_Opt, $wtr_custom_posts_type, $wtr_custom_posts_taxonomy;
	$wtr_SlugsEvents_Slug		= $WTR_Opt->getopt('wtr_SlugsEvents_Slug');
	$wtr_custom_posts_type[]	= 'events';
	$wtr_custom_posts_taxonomy[]= 'events-category';

	$labels= array(
		'name' 					=> __( 'Events', 'wtr_ct_framework' ),
		'all_items'				=> __( 'All Events', 'wtr_ct_framework' ),
		'singular_name' 		=> __( 'Events', 'wtr_ct_framework' ),
		'add_new' 				=> __( 'Add New', 'wtr_ct_framework' ),
		'add_new_item' 			=> __( 'Add New Event', 'wtr_ct_framework' ),
		'edit_item' 			=> __( 'Edit Event', 'wtr_ct_framework' ),
		'new_item' 				=> __( 'New Event', 'wtr_ct_framework' ),
		'view_item' 			=> __( 'View Event', 'wtr_ct_framework' ),
		'search_items' 			=> __( 'Search Events', 'wtr_ct_framework' ),
		'not_found' 			=> __( 'No Events found', 'wtr_ct_framework' ),
		'not_found_in_trash'	=> __( 'No Events found in Trash', 'wtr_ct_framework' )
	);

	$args = array(
		'labels' 				=> $labels,
		'public' 				=> true,
		'publicly_queryable' 	=> true,
		'show_ui' 				=> true,
		'query_var' 			=> true,
		'capability_type' 		=> 'post',
		'hierarchical' 			=> false,
		'menu_position' 		=> null,
		"show_in_nav_menus" 	=> false,
		'exclude_from_search' 	=> false,
		'rewrite' 				=> array( 'slug' => $wtr_SlugsEvents_Slug, 'with_front' => true ),
		'supports' 				=> array( 'title', 'editor', 'thumbnail', 'page-attributes', 'excerpt' )
	);
	register_post_type( 'events', $args );
	register_taxonomy(
		"events-category", array("events"), array(
			'public' 			=> false,
			'show_ui' 			=> true,
			'show_tagcloud'		=> false,
			"hierarchical" 		=> true,
			"show_in_nav_menus" => false,
			"rewrite" 			=> true,
			'labels' 			=> array(
				'name' 				=> __( 'Events Categories', 'wtr_ct_framework' ),
				'singular_name' 	=> __( 'Event Category', 'wtr_ct_framework' ),
				'edit_item' 		=> __( 'Edit Event Category', 'wtr_ct_framework' ),
				'search_items'		=> __( 'Search Event Category' , 'wtr_ct_framework' ),
				'all_items'			=> __( 'All Events Categories' , 'wtr_ct_framework' ),
				'parent_item'		=> __( 'Parent Event Category' , 'wtr_ct_framework' ),
				'parent_item_colon'	=> __( 'Parent Event Category:' , 'wtr_ct_framework' ),
				'edit_item'			=> __( 'Edit Event Category' , 'wtr_ct_framework' ),
				'update_item'		=> __( 'Update Event Category' , 'wtr_ct_framework' ),
				'add_new_item'		=> __( 'Add New Event Category' , 'wtr_ct_framework' ),
				'new_item_name'		=> __( 'New Event Category Name' , 'wtr_ct_framework' ),
				'menu_name'			=> __( 'Events Categories' , 'wtr_ct_framework' )
				),
			)
		);
} // end wtr_create_events
add_action( 'init', 'wtr_create_events' );


function wtr_single_template_events($single) {
	global $post;

	if ( isset( $post->post_type ) AND "events" == $post->post_type ){
		$single =  WTR_CP_INCLUDES_DIR . '/single-events.php';
	}
	return $single;
} // end wtr_single_template_classes
add_filter('single_template', 'wtr_single_template_events');


function get_custom_post_type_template( $archive_template ) {
	$taxonomy = get_query_var('taxonomy');
	if ( 'events-category' == $taxonomy ) {
		$archive_template = WTR_CP_INCLUDES_DIR . '/taxonomy-events-category.php';
	}
	return $archive_template;
} // end get_custom_post_type_template
add_filter( 'taxonomy_template', 'get_custom_post_type_template' ) ;


function wtr_pre_get_posts_taxonomy_events_category($query) {
	if($query->is_main_query() AND $query->is_tax('events-category') ) {
		$query->set( 'meta_key', '_wtr_event_time_start' );
		$query->set( 'orderby', 'meta_value' );
		$query->set( 'order', 'DESC' );
	}
	return $query;
} // end wtr_pre_get_posts_taxonomy_events_category
add_action( 'pre_get_posts', 'wtr_pre_get_posts_taxonomy_events_category');

// add table column in edit page
function wtr_events_column($columns){

	$columns = array(
		"cb" 					=> "<input type='checkbox' />",
		"title"					=> __( 'Title', 'wtr_ct_framework' ),
		"events_date"			=> __( 'Event Date', 'wtr_ct_framework'),
		"events_category"		=> __( 'Events Category', 'wtr_ct_framework' ),
		"events_gym_location"	=> __( 'Gym Location', 'wtr_ct_framework' ),
		"events_order"			=> __( 'Order', 'wtr_ct_framework'),
	);
	return $columns;
} // end wtr_events_column
add_filter("manage_edit-events_columns", "wtr_events_column");


// manage posts custom column
function wtr_events_custom_columns($column){

	global $post;

	switch ($column) {
		case "events_category":
			echo get_the_term_list( $post->ID, 'events-category', '', ', ','');
		break;

		case "events_date":
			$date				= get_post_meta( $post->ID, '_wtr_event_time_start', true );
			$events_date		= ( $date ) ? date( 'Y-m-d H:i' , $date ): '';
			echo $events_date;
		break;

		case "events_gym_location":
			$gym_location		= get_post_meta( $post->ID, '_wtr_gym_location', false );
			$gym_location_names	= wtr_get_gym_location_metabox( $gym_location, true );
			echo implode( $gym_location_names, ', ' );
		break;

		case "events_order":
			echo $post->menu_order;
		break;
	}
} // end wtr_events_custom_columns
add_action("manage_posts_custom_column","wtr_events_custom_columns");


//add meta boxes
function wtr_add_metabox_events(){

	$current_screen = get_current_screen();

	if( 'events' != $current_screen->post_type ){
		return;
	}

	global $WTR_Opt, $wtr_paypal_currency_code;

	$wtr_SeoTitle = new WTR_Text(array(
			'id' 			=> '_wtr_SeoTitle',
			'class' 		=> '',
			'title' 		=> __( 'SEO tittle', 'wtr_ct_framework' ),
			'desc' 			=> '',
			'value' 		=> '',
			'default_value' => '',
			'info' 			=> '',
			'allow' 		=> 'all',
			)
	);

	$wtr_SeoDesc = new WTR_Text(array(
			'id' 			=> '_wtr_SeoDesc',
			'class' 		=> '',
			'title' 		=> __( 'SEO description', 'wtr_ct_framework' ),
			'desc' 			=> '',
			'value' 		=> '',
			'default_value' => '',
			'info' 			=> '',
			'allow' 		=> 'all',
			)
	);

	$wtr_SeoKey = new WTR_Text(array(
			'id' 			=> '_wtr_SeoKey',
			'class' 		=> '',
			'title' 		=> __( 'SEO keywords', 'wtr_ct_framework' ),
			'desc' 			=> '',
			'value' 		=> '',
			'default_value' => '',
			'info' 			=> '',
			'allow' 		=> 'all',
			)
	);

	$wtr_NoRobot = new WTR_Radio( array(
			'id' 			=> '_wtr_NoRobot',
			'title' 		=> __( 'Robots meta tag', 'wtr_ct_framework' ),
			'desc' 			=> '',
			'value' 		=> '',
			'default_value' => '0',
			'info' 			=> '',
			'allow' 		=> 'int',
			'option' 		=> array( '1' => 'On' , '0' => 'Off' ),
			'mod' 			=> 'robot',
			'meta' 			=> '<div class="WtrNoneSidebarDataInfo wtrOnlyPortfolio wtrPageFields">' . __( 'Site has No Robot attribute ', 'wtr_ct_framework' ) . '</div>',
		)
	);

	$wtr_CustomCssForPage = new WTR_Textarea( array(
			'id' 			=> '_wtr_CustomCssForPage',
			'class' 		=> '',
			'rows' 			=> 10,
			'title' 		=> __( 'Custom css for page', 'wtr_ct_framework' ),
			'desc' 			=> '',
			'value' 		=> '',
			'default_value' => '',
			'info' 			=> '',
			'allow' 		=> 'all',
		)
	);

	$wtr_event_covera_img = new WTR_Upload( array(
			'id'			=> '_wtr_event_covera_img',
			'title'			=> __( 'Cover image ', 'wtr_ct_framework' ),
			'desc' 			=> __( 'Single Event', 'wtr_ct_framework' ),
			'value'			=> '',
			'default_value' => '',
			'info'			=> '',
			'allow'			=> 'all',
		),
		array( 'title_modal' => __( 'Insert image', 'wtr_ct_framework' ) )
	);

	$wtr_event_covera_img_stream = new WTR_Upload( array(
			'id'			=> '_wtr_event_covera_img_stream',
			'title'			=> __( 'Cover image ', 'wtr_ct_framework' ),
			'desc' 			=> __( 'Stream Events', 'wtr_ct_framework' ),
			'value'			=> '',
			'default_value' => '',
			'info'			=> '',
			'allow'			=> 'all',
		),
		array( 'title_modal' => __( 'Insert image', 'wtr_ct_framework' ) )
	);

	$wtr_event_date = new WTR_Datepicker(array(
			'id' 			=> '_wtr_event_date',
			'class'			=> '',
			'title' 		=> __( 'Event date', 'wtr_ct_framework' ),
			'desc' 			=> '',
			'value' 		=> '',
			'default_value' => date( 'Y-m-d' ),
			'info' 			=> '',
			'allow' 		=> 'all',
			'rande'			=> array( 'start' => date( 'Y' ), 'end' => date( 'Y' ) + 10 )
		)
	);

	$wtr_event_time_start_h = new WTR_Select(array(
			'id' 			=> '_wtr_event_time_start_h',
			'title' 		=> __( 'Time - hour', 'wtr_ct_framework' ),
			'desc'			=> __( 'Event start', 'wtr_ct_framework' ),
			'value' 		=> '',
			'default_value' => '8',
			'info' 			=> '',
			'allow' 		=> 'all',
			'option' 		=> wtr_events_set_date_time( 'h' ),
			'mod' 			=> '',
			)
	);

	$wtr_event_time_start_m = new WTR_Select(array(
			'id' 			=> '_wtr_event_time_start_m',
			'title' 		=> __( 'Time - minute', 'wtr_ct_framework' ),
			'desc'			=> __( 'Event start', 'wtr_ct_framework' ),
			'value' 		=> '',
			'default_value' => '0',
			'info' 			=> '',
			'allow' 		=> 'all',
			'option' 		=> wtr_events_set_date_time( 'm' ),
			'mod' 			=> '',
			)
	);

	$wtr_event_time_start_type = new WTR_Select(array(
			'id' 			=> '_wtr_event_time_start_type',
			'title' 		=> __( 'Time - type - start time', 'wtr_ct_framework' ),
			'desc'			=> __( 'Select between 24H or 12H time', 'wtr_ct_framework' ),
			'value' 		=> '',
			'default_value' => '50',
			'info' 			=> '',
			'allow' 		=> 'all',
			'option' 		=> array(
									0 => __('--', 'wtr_ct_framework' ),
									1 => __( 'PM', 'wtr_ct_framework' ),
									2 => __( 'AM', 'wtr_ct_framework' ),
								),
			'mod' 			=> '',
			)
	);

	$wtr_event_time_end_h = new WTR_Select(array(
			'id' 			=> '_wtr_event_time_end_h',
			'title' 		=> __( 'Time - hour', 'wtr_ct_framework' ),
			'desc'			=> __( 'Event end', 'wtr_ct_framework' ),
			'value' 		=> '',
			'default_value' => '22',
			'info' 			=> '',
			'allow' 		=> 'all',
			'option' 		=> wtr_events_set_date_time( 'h' ),
			'mod' 			=> '',
			)
	);

	$wtr_event_time_end_m = new WTR_Select(array(
			'id' 			=> '_wtr_event_time_end_m',
			'title' 		=> __( 'Time - minute', 'wtr_ct_framework' ),
			'desc'			=> __( 'Event end', 'wtr_ct_framework' ),
			'value' 		=> '',
			'default_value' => '0',
			'info' 			=> '',
			'allow' 		=> 'all',
			'option' 		=> wtr_events_set_date_time( 'm' ),
			'mod' 			=> '',
			)
	);

	$wtr_event_time_end_type = new WTR_Select(array(
			'id' 			=> '_wtr_event_time_end_type',
			'title' 		=> __( 'Time - type - end time', 'wtr_ct_framework' ),
			'desc'			=> __( 'Select between 24H or 12H time', 'wtr_ct_framework' ),
			'value' 		=> '',
			'default_value' => '50',
			'info' 			=> '',
			'allow' 		=> 'all',
			'option' 		=> array(
									0 => __('--', 'wtr_ct_framework' ),
									1 => __( 'PM', 'wtr_ct_framework' ),
									2 => __( 'AM', 'wtr_ct_framework' ),
				),
			'mod' 			=> '',
			)
	);

	$wtr_event_google_calendar = new WTR_Radio( array(
			'id' 			=> '_wtr_event_google_calendar',
			'title' 		=> __( 'Google calendar', 'wtr_ct_framework' ),
			'desc' 			=> __( 'Displays a link that allows you to add events to google calendar', 'wtr_ct_framework' ),
			'value' 		=> '',
			'default_value' => '0',
			'info' 			=> '',
			'allow' 		=> 'int',
			'option' 		=> array( '1' => 'On' , '0' => 'Off' ),
			'mod' 			=> 'robot',
		)
	);

	$wtr_event_fb = new WTR_Text(array(
			'id' 			=> '_wtr_event_fb',
			'class' 		=> '',
			'title' 		=> __( 'Facebook link', 'wtr_ct_framework' ),
			'desc' 			=> __( 'Link to events on facebook', 'wtr_ct_framework' ),
			'value' 		=> '',
			'default_value' => '',
			'info' 			=> '',
			'allow' 		=> 'all',
			)
	);

	$wtr_event_location = new WTR_Select(array(
			'id' 			=> '_wtr_event_location',
			'title' 		=> __( 'Location', 'wtr_ct_framework' ),
			'desc' 			=> '',
			'value' 		=> '',
			'default_value' => '',
			'info' 			=> '',
			'allow' 		=> 'all',
			'option' 		=> wtr_get_events_locations( null, true ),
			'meta' 			=> '<div class="WtrNoneSidebarDataInfo wtrOnlyPortfolio wtrPageFields">' . __( 'To set Location go to: Events > All Locations > Add New', 'wtr_ct_framework' ) . '</div>',
			'mod' 			=> '',
			)
	);

	$wtr_event_organizer = new WTR_Select(array(
			'id' 			=> '_wtr_event_organizer',
			'title' 		=> __( 'Organizer', 'wtr_ct_framework' ),
			'desc' 			=> '',
			'value' 		=> '',
			'default_value' => '',
			'info' 			=> '',
			'allow' 		=> 'all',
			'option' 		=> wtr_get_events_organizers( null, true ),
			'meta' 			=> '<div class="WtrNoneSidebarDataInfo wtrOnlyPortfolio wtrPageFields">' . __( 'To set Location go to: Events > All Organizers > Add New', 'wtr_ct_framework' ) . '</div>',
			'mod' 			=> '',
			)
	);

	$wtr_event_sign_up = new WTR_Text(array(
			'id' 			=> '_wtr_event_sign_up',
			'class'			=> '',
			'title' 		=> __( 'Sign ups to', 'wtr_ct_framework' ),
			'desc' 			=> '',
			'value' 		=> '',
			'default_value' => '',
			'info' 			=> '',
			'allow' 		=> 'all',
		)
	);

	$wtr_event_number = new WTR_Text(array(
			'id' 			=> '_wtr_event_number',
			'class'			=> '',
			'title' 		=> __( 'Number of participants', 'wtr_ct_framework' ),
			'desc' 			=> '',
			'value' 		=> '',
			'default_value' => '',
			'info' 			=> '',
			'allow' 		=> 'all',
		)
	);

	$wtr_event_price = new WTR_Text(array(
			'id' 			=> '_wtr_event_price',
			'class'			=> '',
			'title' 		=> __( 'Price', 'wtr_ct_framework' ),
			'desc' 			=> '',
			'value' 		=> '',
			'default_value' => '',
			'info' 			=> '',
			'allow' 		=> 'all',
		)
	);

	$wtr_event_time_start = new WTR_Hidden( array(
			'id'			=> '_wtr_event_time_start',
			'class'			=> '',
			'title'			=> '',
			'desc'			=> '',
			'value'			=> '',
			'default_value' => '',
			'info'			=> '',
			'allow'			=> 'all',
		)
	);

	$wtr_event_time_end = new WTR_Hidden( array(
			'id'			=> '_wtr_event_time_end',
			'class'			=> '',
			'title'			=> '',
			'desc'			=> '',
			'value'			=> '',
			'default_value' => '',
			'info'			=> '',
			'allow'			=> 'all',
		)
	);

	//wtr_nav_menu
	$nav_menus		= wp_get_nav_menus( array('orderby' => 'name') );
	$wtr_nav_menus	= array(
							'none'	=> __( 'None', 'wtr_framework' ),
							0		=> __( 'Default', 'wtr_framework' ),
							);

	foreach ( $nav_menus as  $nav_menu) {
		$wtr_nav_menus[ $nav_menu->term_id ] = $nav_menu->name;
	}

	$wtr_clean_menu_mod = new WTR_Radio( array(
			'id'			=> '_wtr_clean_menu_mod',
			'title'			=> __( 'Enable clean menu mode', 'wtr_framework' ),
			'desc'			=> __( 'This option allows you to hide additional menu icons like: </br> Search icon, WooCommerce cart (if installed), WPML select (if installed)', 'wtr_framework' ),
			'value'			=> '',
			'default_value' => '0',
			'info'			=> '',
			'allow'			=> 'int',
			'option'		=> array( '1' => 'On' , '0' => 'Off' ),
		)
	);

	$wtr_page_nav_menu = new WTR_Select(array(
			'id' 			=> '_wtr_page_nav_menu',
			'title' 		=> __( 'Page menu', 'wtr_framework' ),
			'desc' 			=> '',
			'value' 		=> '',
			'default_value' => 0,
			'info' 			=> '',
			'allow' 		=> 'all',
			'option' 		=> $wtr_nav_menus,
			'mod' 			=> '',
			)
	);

	$wtr_HeaderSettings = new WTR_Select( array(
			'id'			=> '_wtr_HeaderSettings',
			'title'			=> __( 'Header settings', 'wtr_framework' ),
			'desc'			=> '',
			'value'			=> '',
			'default_value' => $WTR_Opt->getopt( 'wtr_HeaderSettings' ),
			'info'			=> '',
			'allow'			=> 'int',
			'mod' 			=> '',
			'option'		=> array(
										'0' => __( 'Off', 'wtr_framework' ),
										'1' => __( 'Show menu', 'wtr_framework' ),
										'2' => __( 'Show menu &#43; socials', 'wtr_framework' ),
										'3' => __( 'Simplified menu', 'wtr_framework' )
										),
		)
	);

	$wtr_BreadCrumbsContainer = new WTR_Radio( array(
			'id' 			=> '_wtr_BreadCrumbsContainer',
			'title' 		=> __( 'Breadcrumbs container', 'wtr_framework' ),
			'desc' 			=> '',
			'value' 		=> '',
			'default_value' => $WTR_Opt->getopt( 'wtr_BlogBreadCrumbsContainer' ),
			'info' 			=> '',
			'allow' 		=> 'int',
			'option' 		=> array( '1' => 'On' , '0' => 'Off' ),
			'class'			=> ''
		)
	);

	$wtr_BreadCrumbs = new WTR_Radio( array(
			'id' 			=> '_wtr_BreadCrumbs',
			'title' 		=> __( 'Breadcrumbs', 'wtr_framework' ),
			'desc' 			=> '',
			'value' 		=> '',
			'default_value' => $WTR_Opt->getopt( 'wtr_BlogBreadCrumbs' ),
			'info' 			=> '',
			'allow' 		=> 'int',
			'option' 		=> array( '1' => 'On' , '0' => 'Off' ),
			'class'			=> ''
		)
	);


	$wtr_PayPalButton = new WTR_Radio( array(
			'id'			=> '_wtr_PayPalButton',
			'class'			=> '',
			'title'			=> __( 'Show call to action button', 'wtr_framework' ),
			'desc'			=> '',
			'value'			=> '',
			'default_value' => $WTR_Opt->getopt( 'wtr_PayPalShowInEvent' ),
			'info'			=> '',
			'allow'			=> 'int',
			'option' 	=> array( '1' => 'On' , '0' => 'Off' ),
		)
	);
	$wtr_PayPalPrice = new WTR_Text( array(
			'id'			=> '_wtr_PayPalPrice',
			'class'			=> '',
			'title'			=> __( 'Price', 'wtr_framework' ),
			'desc'			=> '',
			'value'			=> '',
			'default_value' => '',
			'info'			=> '',
			'allow'			=> 'all',
		)
	);

	$wtr_PayPalEmail = new WTR_Text( array(
			'id'			=> '_wtr_PayPalEmail',
			'class'			=> '',
			'title'			=> __( 'Your PayPal e-mail adress', 'wtr_framework' ),
			'desc'			=> '',
			'value'			=> '',
			'default_value' => $WTR_Opt->getopt( 'wtr_PayPalEmail' ),
			'info'			=> '',
			'allow'			=> 'all',
		)
	);

	$wtr_PayPalCurrencyCode = new WTR_Select( array(
			'id'			=> '_wtr_PayPalCurrencyCode',
			'title'			=> __( 'Currency Code', 'wtr_framework' ),
			'desc'			=> __( "* This currency does not support decimals. Passing a decimal amount will result in an error.</br>** This currency is supported as a payment currency and a currency balance for in-country PayPal accounts only.", 'wtr_framework' ),
			'value'			=> '',
			'default_value' => $WTR_Opt->getopt( 'wtr_PayPalCurrencyCode' ),
			'info'			=> '',
			'allow'			=> 'all',
			'mod' 			=> '',
			'option'		=> $wtr_paypal_currency_code,
		)
	);

	require_once( WTR_ADMIN_CLASS_DIR . '/wtr_meta_box.php' );

	$wtr_GeneralSections = array(
		'id'		=> 'wtr_GeneralSections',
		'name' 		=>__( 'General', 'wtr_ct_framework' ),
		'class'		=> 'General',
		'active_tab'=> true,
		'fields'	=> array(
							$wtr_event_covera_img,
							$wtr_event_covera_img_stream,
							$wtr_event_number,
							$wtr_event_price,
							$wtr_event_sign_up,
							$wtr_event_date,
							$wtr_event_time_start_type,
							$wtr_event_time_start_h,
							$wtr_event_time_start_m,
							$wtr_event_time_end_type,
							$wtr_event_time_end_h,
							$wtr_event_time_end_m,
							$wtr_event_google_calendar,
							$wtr_event_fb,
							$wtr_event_location,
							$wtr_event_organizer,
							$wtr_event_time_start,
							$wtr_event_time_end,
					)
	);

	$wtr_LayoutSections = array(
		'id'		=> 'wtr_LayoutSections',
		'name' 		=>__( 'Layout', 'wtr_framework' ),
		'class'		=> 'Layout',
		'active_tab'=> false,
		'fields'	=> array(
							$wtr_clean_menu_mod,
							$wtr_page_nav_menu,
							$wtr_HeaderSettings,
							$wtr_BreadCrumbsContainer,
							$wtr_BreadCrumbs
					)
	);

	$wtr_CssSections = array(
		'id'		=> 'wtr_CssSections',
		'name' 		=>__( 'CSS', 'wtr_ct_framework' ),
		'class'		=> 'CSS',
		'fields'	=> array(
							$wtr_CustomCssForPage
					)
	);

	$wtr_meta_settings =
					array(
						'id' 		=> 'wtr-meta-post',
						'title' 	=> __('Event Options', 'wtr_ct_framework' ),
						'page' 		=> 'events',
						'context' 	=> 'normal',
						'priority' 	=> 'high',
						'sections' 	=> array(
											$wtr_GeneralSections,
											$wtr_LayoutSections,
											$wtr_CssSections
											)
					);


	// Add seo fields
	if ( 1 ==  $WTR_Opt->getopt( 'wtr_SeoSwich' ) ) {
		$wtr_SEOSections = array(
			'id'		=> 'wtr_SEOSections',
			'name' 		=>__( 'SEO', 'wtr_ct_framework' ),
			'class'		=> 'SEO',
			'fields'	=> array(
								$wtr_SeoTitle,
								$wtr_SeoDesc,
								$wtr_SeoKey,
								$wtr_NoRobot,
							)
		);
		$wtr_meta_settings['sections'][] = $wtr_SEOSections;
	}

	// Add paypal fields
	if ( 1 ==  $WTR_Opt->getopt( 'wtr_PayPalGlobalStatus' ) ) {
		$wtr_SEOSections = array(
			'id'		=> 'wtr_PayPalSections',
			'name' 		=>__( 'PayPal Integration', 'wtr_ct_framework' ),
			'class'		=> 'PayPal',
			'fields'	=> array(
								$wtr_PayPalButton,
								$wtr_PayPalPrice,
								$wtr_PayPalEmail,
								$wtr_PayPalCurrencyCode,
							)
		);
		$wtr_meta_settings['sections'][] = $wtr_SEOSections;
	}


	//Gym location Right Metabox
	$wtr_gym_location_options = wtr_get_gym_location_metabox();

	$wtr_gym_location = new WTR_Checkbox( array(
			'id'			=> '_wtr_gym_location',
			'title'			=> __( 'Gym Location', 'wtr_ct_framework' ),
			'desc'			=> '',
			'value'			=> '',
			'default_value' => array(),
			'info'			=> '',
			'allow'			=> 'all',
			'option'		=> $wtr_gym_location_options,
			'mod' 			=> 'simple'

		)
	);

	$wtr_GeneralSections = array(
		'id'		=> 'wtr_GeneralSections',
		'name' 		=>__( 'General', 'wtr_ct_framework' ),
		'class'		=> 'General',
		'active_tab'=> true,
		'fields'	=> array(
							$wtr_gym_location,
					)
	);

	$wtr_gym_location_right_meta_settings =
					array(
						'id' 		=> 'wtr-gym_location-meta-right-post',
						'title' 	=> __( 'Gym Location', 'wtr_ct_framework' ),
						'page' 		=> 'events',
						'context' 	=> 'side',
						'priority' 	=> 'core',
						'callback'	=> 'render_right_meta_box_content',
						'sections' 	=> array(
											$wtr_GeneralSections,
										)
					);

	$wtr_meta_box						= NEW wtr_meta_box( $wtr_meta_settings );
	$wtr_gym_location_right_meta_box	= NEW wtr_meta_box( $wtr_gym_location_right_meta_settings );

} // end wtr_add_metabox_events
add_action( 'load-post.php', 'wtr_add_metabox_events' );
add_action( 'load-post-new.php', 'wtr_add_metabox_events' );


function wtr_save_post_events( $post_ID) {

	if( isset( $_POST['_wtr_event_time_end'] ) ){
		$date				= empty( $_POST['_wtr_event_date'] ) ? date('Y-m-d'): $_POST['_wtr_event_date'];
		$time_start_h		= $_POST['_wtr_event_time_start_h'];
		$time_start_m		= $_POST['_wtr_event_time_start_m'];
		$time_start_type	= $_POST['_wtr_event_time_start_type'];
		$time_start_type	= ( 0 == $time_start_type ) ? '' : ( ( 1 == $time_start_type ) ? 'pm' : 'am' );
		$time_end_h			= $_POST['_wtr_event_time_end_h'];
		$time_end_m			= $_POST['_wtr_event_time_end_m'];
		$time_end_type		= $_POST['_wtr_event_time_end_type'];
		$time_end_type		= ( 0 == $time_end_type ) ? '' : ( ( 1 == $time_end_type ) ? 'pm' : 'am' );

		$_POST['_wtr_event_time_start']	= strtotime( $date . ' ' . $time_start_h . ':'. $time_start_m . $time_start_type );
		$_POST['_wtr_event_time_end']	= strtotime( $date . ' ' . $time_end_h . ':'. $time_end_m . $time_end_type );
	}
} // end wtr_save_post_events
add_action( 'wtr_post_save_events' , 'wtr_save_post_events' );
add_action( 'wtr_post_save_events' , 'wtr_save_metabox_gym_location' );


function wtr_events_set_date_time( $type = 'h' ) {
	if( 'h' == $type){
		$time = array_merge( array( '00','01', '02', '03', '04', '05', '06', '07', '08', '09' ), range( 10, 23 ) );
	} else {
		$time = array_merge( array( '00','01', '02', '03', '04', '05', '06', '07', '08', '09' ), range( 10, 60 ) );
	}
	$time = array_combine( $time, $time );
	return $time;
} // end wtr_events_set_date_time


function wtr_post_type_events( $wtr_post_type, $template ){

	$wtr_post_type	= ( 'template-events.php' == $template ) ? 'events_stream' : $wtr_post_type;
	return $wtr_post_type;

} // end wtr_post_type_events
add_filter( 'wtr_post_type', 'wtr_post_type_events', 10, 2);


function wtr_post_settings_default_stream_events( $post_settings ){

	$post_settings['wtr_SidebarPosition']		= $post_settings['wtr_SidebarPositionOnEvent'];
	$post_settings['wtr_Sidebar']				= $post_settings['wtr_SidebarPickOnEvent'];

	return $post_settings;

} // end wtr_post_settings_default_stream_events
add_filter( 'wtr_post_settings_default_events_stream', 'wtr_post_settings_default_stream_events', 10, 1);


function wtr_post_settings_single_post_events( $post_settings_single ){

	$post_settings_single = array(
		'wtr_event_covera_img'		=> '_wtr_event_covera_img',
		'wtr_event_calendar'		=> '_wtr_event_calendar',
		'wtr_event_number'			=> '_wtr_event_number',
		'wtr_event_price'			=> '_wtr_event_price',
		'wtr_event_sign_up'			=> '_wtr_event_sign_up',
		'wtr_event_date'			=> '_wtr_event_date',
		'wtr_event_time_start_h'	=> '_wtr_event_time_start_h',
		'wtr_event_time_start_m'	=> '_wtr_event_time_start_m',
		'wtr_event_time_start_type'	=> '_wtr_event_time_start_type',
		'wtr_event_time_end_h'		=> '_wtr_event_time_end_h',
		'wtr_event_time_end_m'		=> '_wtr_event_time_end_m',
		'wtr_event_time_end_type'	=> '_wtr_event_time_end_type',
		'wtr_event_google_calendar'	=> '_wtr_event_google_calendar',
		'wtr_event_fb'				=> '_wtr_event_fb',
		'wtr_event_location'		=> '_wtr_event_location',
		'wtr_event_organizer'		=> '_wtr_event_organizer',
		'wtr_event_time_start'		=> '_wtr_event_time_start',
		'wtr_event_time_end'		=> '_wtr_event_time_end',
		'wtr_CustomCssForPage'		=> '_wtr_CustomCssForPage',
		'wtr_SeoTitle'				=> '_wtr_SeoTitle',
		'wtr_SeoDescription'		=> '_wtr_SeoDesc',
		'wtr_SeoKeywords'			=> '_wtr_SeoKey',
		'wtr_NoRobot'				=> '_wtr_NoRobot',
		'wtr_HeaderSettings'		=> '_wtr_HeaderSettings',
		'wtr_page_nav_menu'			=> '_wtr_page_nav_menu',
		'wtr_HeaderCleanMenuMod'	=> '_wtr_clean_menu_mod',
		'wtr_BreadCrumbsContainer'	=> '_wtr_BreadCrumbsContainer',
		'wtr_BreadCrumbs'			=> '_wtr_BreadCrumbs',
		'wtr_PayPalButton'			=> '_wtr_PayPalButton',
		'wtr_PayPalPrice'			=> '_wtr_PayPalPrice',
		'wtr_PayPalEmail'			=> '_wtr_PayPalEmail',
		'wtr_PayPalCurrencyCode'	=> '_wtr_PayPalCurrencyCode',
	);

	return $post_settings_single;

} // end wtr_post_settings_single_post_events
add_filter( 'wtr_post_settings_single_post_events', 'wtr_post_settings_single_post_events', 10, 2 );


function wtr_post_settings_single_post_events_stream( $post_settings_single ){

	$post_settings_single = array(
		'wtr_Boxed'					=> '_wtr_Boxed',
		'wtr_BackgroundImg'			=> '_wtr_BackgroundImg',
		'wtr_HeaderSettings'		=> '_wtr_HeaderSettings',
		'wtr_BreadCrumbsContainer'	=> '_wtr_BreadCrumbsContainer',
		'wtr_BreadCrumbs'			=> '_wtr_BreadCrumbs',
		'wtr_FooterSettings'		=> '_wtr_FooterSettings',
		'wtr_page_nav_menu'			=> '_wtr_page_nav_menu',
		'wtr_CustomCssForPage'		=> '_wtr_CustomCssForPage',
		'wtr_SeoTitle'				=> '_wtr_SeoTitle',
		'wtr_SeoDescription'		=> '_wtr_SeoDesc',
		'wtr_SeoKeywords'			=> '_wtr_SeoKey',
		'wtr_NoRobot'				=> '_wtr_NoRobot',
		'wtr_HeaderTransparentMode'	=> '_wtr_transparent_mode'
	);
	return $post_settings_single;

} // end wtr_post_settings_single_post_events_stream
add_filter( 'wtr_post_settings_single_post_events_stream', 'wtr_post_settings_single_post_events_stream', 10, 2 );