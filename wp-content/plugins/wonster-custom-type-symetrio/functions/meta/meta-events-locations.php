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


function wtr_create_events_locations() {

	global $WTR_Opt, $wtr_custom_posts_type;
	$wtr_custom_posts_type[]	= 'events_locations';

	$labels= array(
		'name' 					=> __( 'Location', 'wtr_ct_framework' ),
		'all_items'				=> __( 'All Locations', 'wtr_ct_framework' ),
		'singular_name' 		=> __( 'Location', 'wtr_ct_framework' ),
		'add_new' 				=> __( 'Add New', 'wtr_ct_framework' ),
		'add_new_item' 			=> __( 'Add New Location', 'wtr_ct_framework' ),
		'edit_item' 			=> __( 'Edit Location', 'wtr_ct_framework' ),
		'new_item' 				=> __( 'New Location', 'wtr_ct_framework' ),
		'view_item' 			=> __( 'View Location', 'wtr_ct_framework' ),
		'search_items' 			=> __( 'Search Location', 'wtr_ct_framework' ),
		'not_found' 			=> __( 'No Locations found', 'wtr_ct_framework' ),
		'not_found_in_trash'	=> __( 'No Locations in Trash', 'wtr_ct_framework' )
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
	register_post_type( 'events_locations', $args );

}	// end wtr_create_events_locations
add_action( 'init', 'wtr_create_events_locations' );


// add table column in edit page
function wtr_events_locations_column($columns){

	$columns = array(
		"cb" 					=> "<input type='checkbox' />",
		"title"					=> __( 'title', 'wtr_ct_framework' ),
		"event_locatio_address"	=> __( 'Address', 'wtr_ct_framework' ),
	);
	return $columns;
} // end wtr_events_locations_column
add_filter("manage_edit-events_locations_columns", "wtr_events_locations_column");


// manage posts custom column
function wtr_events_locations_custom_columns($column){

	global $post;

	switch ($column) {
		case "event_locatio_address":
			echo get_post_meta( $post->ID, '_wtr_events_locations_address', true );
		break;
	}
} // end wtr_events_locations_custom_columns
add_action("manage_posts_custom_column","wtr_events_locations_custom_columns");


//add meta boxes
function wtr_add_metabox_events_locations(){

	$current_screen = get_current_screen();

	if( 'events_locations' != $current_screen->post_type ){
		return;
	}

	global $WTR_Opt;

	$wtr_events_locations_address = new WTR_Text( array(
			'id' 			=> '_wtr_events_locations_address',
			'title' 		=> __( 'Address', 'wtr_ct_framework' ),
			'desc' 			=> '',
			'value' 		=> '',
			'default_value' => '',
			'info' 			=> '',
			'allow' 		=> 'all',
		)
	);

	$wtr_events_locations_email = new WTR_Text( array(
			'id' 			=> '_wtr_events_locations_email',
			'class'			=> '',
			'title' 		=> __( 'E-mail', 'wtr_ct_framework' ),
			'desc' 			=> '',
			'value' 		=> '',
			'default_value' => '',
			'info' 			=> '',
			'allow' 		=> 'all',
		)
	);

	$wtr_events_locations_url = new WTR_Text( array(
			'id' 			=> '_wtr_events_locations_url',
			'class'			=> '',
			'title' 		=> __( 'URL', 'wtr_ct_framework' ),
			'desc' 			=> '',
			'value' 		=> '',
			'default_value' => '',
			'info' 			=> '',
			'allow' 		=> 'all',
		)
	);

	$wtr_events_locations_phone = new WTR_Text( array(
			'id' 			=> '_wtr_events_locations_phone',
			'class'			=> '',
			'title' 		=> __( 'Phone number', 'wtr_ct_framework' ),
			'desc' 			=> '',
			'value' 		=> '',
			'default_value' => '',
			'info' 			=> '',
			'allow' 		=> 'all',
		)
	);

	$wtr_events_locations_google = new WTR_Map( array(
		'id' 					=> '_wtr_events_locations_google',
		'class'					=> 'ModalFields wtrGoogleMapContener',
		'title'					=> __( 'Marker coordinates ', 'wtr_ct_framework' ),
		'desc'					=> __( 'To specify the coordinates of the marker you can use our search engine located above the map.<br /><br />You can change the position of the cursor by dragging it to the desired location', 'wtr_ct_framework' ),
		'value'					=> '',
		'default_value'			=> '-37.81751|144.959168',
		'zoom'					=> '10',
		'height'				=> '400',
		'contener_div'			=> 'wtr_map_temp_contener',
		'info'					=> '',
		'allow'					=> 'all',
		'type_map_controler'	=> '_wtr_events_locations_type',
		'style_map_controler'	=> '_wtr_events_locations_map_style',
		'marker_map_controler'	=> '_wtr_events_locations_marker_style'
		)
	);



	$wtr_events_locations_type = new WTR_Select( array(
		'id' 			=> '_wtr_events_locations_type',
		'class'			=> 'ModalFields',
		'title'			=> __( 'Map types', 'wtr_ct_framework' ),
		'desc'			=> __( 'Specify the type of your map', 'wtr_ct_framework' ),
		'value'			=> 'ROADMAP',
		'default_value'	=> '',
		'info'			=> '',
		'allow'			=> 'all',
		'mod'			=> '',
		'option'		=> array(	'ROADMAP'		=> __( 'ROADMAP - displays the default road map view', 'wtr_ct_framework' ),
									'SATELLITE'	=> __( 'SATELLITE - displays Google Earth satellite images', 'wtr_ct_framework' ),
									'HYBRID'		=> __( 'HYBRID - displays a mixture of normal and satellite views', 'wtr_ct_framework' ),
									'TERRAIN'		=> __( 'TERRAIN - displays a physical map based on terrain information', 'wtr_ct_framework' )
								),
		)
	);

	$wtr_events_locations_map_style = new WTR_Select( array(
			'id' 			=> '_wtr_events_locations_map_style',
			'class'			=> 'ModalFields',
			'title'			=> __( 'Map style', 'wtr_ct_framework' ),
			'desc'			=> __( 'Specify the style of your map', 'wtr_ct_framework' ),
			'value'			=> 'standard',
			'default_value'	=> '',
			'info'			=> '',
			'allow'			=> 'all',
			'zoom'			=> '10',
			'contener_div'	=> 'wtr_prev_div_select_g_maps',
			'height'		=> '250',
			'mod'			=> '',
			'option'		=> array(	'standard'					=> __( 'Standard style', 'wtr_ct_framework' ),
										'apple_maps_esque'			=>'Apple Maps-esque',
										'aqua'						=> 'Aqua',
										'avocado_world'				=> 'Avocado World',
										'bates_green'				=> 'Bates Green',
										'bentley'					=> 'Bentley',
										'blue'						=> 'Blue',
										'blueprint'					=> 'Blueprint (No Labels)',
										'blueprint_label'			=> 'Blueprint',
										'blue_essence'				=> 'Blue Essence',
										'blue_gray'					=> 'Blue Gray',
										'blue_water'				=> 'Blue Water',
										'bluish'					=> 'Bluish',
										'bright_bubbly'				=> 'Bright & Bubbly',
										'candy_colours'				=> 'Candy Colours',
										'caribbean_mountain'		=> 'Caribbean Mountain',
										'chilled'					=> 'Chilled',
										'cobalt'					=> 'Cobalt',
										'countries'					=> 'Countries',
										'deep_green'				=> 'Deep Green',
										'esperanto'					=> 'Esperanto',
										'flat_green'				=> 'Flat green',
										'flat_map'					=> 'Flat Map',
										'gowalla'					=> 'Gowalla',
										'greyscale'					=> 'Greyscale',
										'hard_edges'				=> 'Hard Edges',
										'hints_of_gold'				=> 'Hints of Gold',
										'holiday'					=> 'Holiday',
										'homage_to_toner'			=> 'Homage to Toner',
										'hopper'					=> 'Hopper',
										'hot_pink'					=> 'Hot Pink',
										'icy_blue'					=> 'Icy Blue',
										'jane_iredale'				=> 'Jane Iredale',
										'just_places'				=> 'Just places',
										'light_green'				=> 'Light Green',
										'light_monochrome'			=> 'Light Monochrome',
										'lunar_landscape'			=> 'Lunar Landscape',
										'mapBox'					=> 'MapBox',
										'midnight_commander'		=> 'Midnight Commander',
										'military_flat'				=> 'Military Flat',
										'mixed'						=> 'Mixed',
										'nature'					=> 'Nature',
										'neon_world'				=> 'Neon World',
										'neutral_blue'				=> 'Neutral Blue',
										'night_vision'				=> 'Night vision',
										'old_timey'					=> 'Old Timey',
										'old_dry_mud'				=> 'Old Dry Mud',
										'pale_dawn'					=> 'Pale Dawn',
										'paper'						=> 'Paper',
										'red_alert'					=> 'Red Alert',
										'red_hues'					=> 'Red Hues',
										'retro'						=> 'Retro',
										'roadtrip_at_night'			=> 'Roadtrip At Night',
										'routeXL'					=> 'RouteXL',
										'shades_of_grey'			=> 'Shades of Grey',
										'shift_worker'				=> 'Shift Worker',
										'simple_labels'				=> 'Simple Labels',
										'snazzy_maps'				=> 'Snazzy Maps',
										'souldisco'					=> 'Souldisco',
										'subtle'					=> 'Subtle',
										'subtle_grayscale'			=> 'Subtle Grayscale',
										'subtle_green'				=> 'Subtle Green',
										'subtle_greyscale_map'		=> 'Subtle Greyscale Map',
										'the_endless_atlas'			=> 'The Endless Atlas',
										'tripitty'					=> 'Tripitty',
										'turquoise_water'			=> 'Turquoise Water',
										'unimposed_topography'		=>'Unimposed Topography',
										'unsaturated_browns'		=> 'Unsaturated Browns',
										'vintage'					=> 'Vintage',
										'vintage_blue'				=> 'Vintage Blue',
										'vitamin_c'					=> 'Vitamin C'
									),

		)
	);

	$wtr_events_locations_zoom = new WTR_Select( array(
			'id'			=> '_wtr_events_locations_zoom',
			'class'			=> 'ModalFields',
			'title'			=> __( 'Map zoom', 'wtr_ct_framework' ),
			'desc'			=> __( 'Zoom value from 0 to 21 where 21 is the greatest and 0 the smallest.', 'wtr_ct_framework' ),
			'value'			=> '',
			'default_value'	=> '9',
			'info'			=> '',
			'allow'			=> 'all',
			'mod'			=> '',
			'option'		=> array( '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6',
									  '7' => '7', '8' => '8', '9' => '9', '10' => '10', '11' => '11', '12' => '12', '13' => '13',
									  '14' => '14', '15' => '15', '16' => '16', '17' => '17', '18' => '18', '19' => '19',
									  '20' => '20', '21' => '21' ),
		)
	);

	$wtr_events_locations_scrooll = new WTR_Radio( array(
			'id' 			=> '_wtr_events_locations_scroll',
			'class'			=> 'ModalFields',
			'title'			=> __( 'Scrollwheel', 'wtr_ct_framework' ),
			'desc'			=> __( 'Set to false to disable zooming with your mouse scrollwheel.', 'wtr_ct_framework' ),
			'value'			=> '',
			'default_value'	=> '0',
			'info'			=> '',
			'allow'			=> 'all',
			'option'		=> array( '1' => __( 'On', 'wtr_ct_framework' ) , '0' => __( 'Off', 'wtr_ct_framework' ) )
		)
	);

	$wtr_events_locations_marker_style = new WTR_Select( array(
			'id' 			=> '_wtr_events_locations_marker_style',
			'class'			=> 'ModalFields',
			'title'			=> __( 'Select marker style', 'wtr_ct_framework' ),
			'desc'			=> '',
			'value'			=> 'standard',
			'default_value'	=> '',
			'info'			=> '',
			'allow'			=> 'all',
			'mod'			=> '',
			'option'		=> array(	'standard' => __( 'Standard', 'wtr_ct_framework' ),
										'pin_red_circle' => __( 'Pin - red circle ', 'wtr_ct_framework' ),
										'pin_red_stars' => __( 'Pin - red stars ', 'wtr_ct_framework' ),
										'pin_blue_blank' => __( 'Pin - blue blank ', 'wtr_ct_framework' ),
										'pin_blue_circle' => __( 'Pin - blue circle ', 'wtr_ct_framework' ),
										'pin_blue_stars' => __( 'Pin - blue stars ', 'wtr_ct_framework' ),
										'pin_light_blue_blank' => __( 'Pin - light blue blank ', 'wtr_ct_framework' ),
										'pin_light_blue_circle' => __( 'Pin - light blue circle ', 'wtr_ct_framework' ),
										'pin_light_blue_stars' => __( 'Pin - light blue stars ', 'wtr_ct_framework' ),
										'pin_green_blank' => __( 'Pin - green blank ', 'wtr_ct_framework' ),
										'pin_green_circle' => __( 'Pin - green circle ', 'wtr_ct_framework' ),
										'pin_green_stars' => __( 'Pin - green stars ', 'wtr_ct_framework' ),
										'pin_pink_blank' => __( 'Pin - pink blank ', 'wtr_ct_framework' ),
										'pin_pink_circle' => __( 'Pin - pink circle ', 'wtr_ct_framework' ),
										'pin_pink_stars' => __( 'Pin - pink stars ', 'wtr_ct_framework' ),
										'pin_purple_blank' => __( 'Pin - purple blank ', 'wtr_ct_framework' ),
										'pin_purple_circle' => __( 'Pin - purple circle ', 'wtr_ct_framework' ),
										'pin_purple_stars' => __( 'Pin - purple stars ', 'wtr_ct_framework' ),
										'pin_white_blank' => __( 'Pin - white blank ', 'wtr_ct_framework' ),
										'pin_white_circle' => __( 'Pin - white circle ', 'wtr_ct_framework' ),
										'pin_white_stars' => __( 'Pin - white stars ', 'wtr_ct_framework' ),
										'pin_yellow_blank' => __( 'Pin - yellow blank ', 'wtr_ct_framework' ),
										'pin_yellow_circle' => __( 'Pin - yellow circle ', 'wtr_ct_framework' ),
										'pin_yellow_stars' => __( 'Pin - yellow stars ', 'wtr_ct_framework' ),
										'pin1'	=> __( 'Pin - 1 ', 'wtr_ct_framework' ),
										'pin2'	=> __( 'Pin - 2 ', 'wtr_ct_framework' ),
										'pin3'	=> __( 'Pin - 3 ', 'wtr_ct_framework' ),
										'pin4'	=> __( 'Pin - 4 ', 'wtr_ct_framework' ),
										'pin5'	=> __( 'Pin - 5 ', 'wtr_ct_framework' ),
										'pin6'	=> __( 'Pin - 6 ', 'wtr_ct_framework' ),
										'pin7'	=> __( 'Pin - 7 ', 'wtr_ct_framework' ),
										'pin8'	=> __( 'Pin - 8 ', 'wtr_ct_framework' ),
										'pin9'	=> __( 'Pin - 9 ', 'wtr_ct_framework' ),
										'pin10'	=> __( 'Pin - 10 ', 'wtr_ct_framework' ),
										'pin_a'	=> __( 'Pin - A ', 'wtr_ct_framework' ),
										'pin_b'	=> __( 'Pin - B ', 'wtr_ct_framework' ),
										'pin_c'	=> __( 'Pin - C ', 'wtr_ct_framework' ),
										'pin_d'	=> __( 'Pin - D ', 'wtr_ct_framework' ),
										'pin_e'	=> __( 'Pin - E ', 'wtr_ct_framework' ),
										'pin_f'	=> __( 'Pin - F ', 'wtr_ct_framework' ),
										'pin_g'	=> __( 'Pin - G ', 'wtr_ct_framework' ),
										'pin_h'	=> __( 'Pin - H ', 'wtr_ct_framework' ),
										'pin_i'	=> __( 'Pin - I ', 'wtr_ct_framework' ),
										'pin_j'	=> __( 'Pin - J ', 'wtr_ct_framework' ),
										'pin_k'	=> __( 'Pin - K ', 'wtr_ct_framework' ),
										'pin_l'	=> __( 'Pin - L ', 'wtr_ct_framework' ),
										'pin_m'	=> __( 'Pin - M ', 'wtr_ct_framework' ),
										'pin_n'	=> __( 'Pin - N ', 'wtr_ct_framework' ),
										'pin_o'	=> __( 'Pin - O ', 'wtr_ct_framework' ),
										'pin_p'	=> __( 'Pin - P ', 'wtr_ct_framework' ),
										'pin_q'	=> __( 'Pin - Q ', 'wtr_ct_framework' ),
										'pin_r'	=> __( 'Pin - R ', 'wtr_ct_framework' ),
										'pin_s'	=> __( 'Pin - S ', 'wtr_ct_framework' ),
										'pin_t'	=> __( 'Pin - T ', 'wtr_ct_framework' ),
										'pin_u'	=> __( 'Pin - U ', 'wtr_ct_framework' ),
										'pin_v'	=> __( 'Pin - V ', 'wtr_ct_framework' ),
										'pin_w'	=> __( 'Pin - W ', 'wtr_ct_framework' ),
										'pin_x'	=> __( 'Pin - X ', 'wtr_ct_framework' ),
										'pin_y'	=> __( 'Pin - Y ', 'wtr_ct_framework' ),
										'pin_z'	=> __( 'Pin - Z ', 'wtr_ct_framework' ),
										'pushpin_blue'	=> __( 'Push pin - blue', 'wtr_ct_framework' ),
										'pushpin_green'	=> __( 'Push pin -  green', 'wtr_ct_framework' ),
										'pushpin_light_blue'	=> __( 'Push pin -  light blue', 'wtr_ct_framework' ),
										'pushpin_pink'	=> __( 'Push pin -  pink', 'wtr_ct_framework' ),
										'pushin_purple'	=> __( 'Push pin -  purple', 'wtr_ct_framework' ),
										'pushin_red'	=> __( 'Push pin -  red', 'wtr_ct_framework' ),
										'pushin_white'	=> __( 'Push pin -  white', 'wtr_ct_framework' ),
										'pushin_yellow'	=> __( 'Push pin -  yellow', 'wtr_ct_framework' ),
										'track_1'	=> __( 'Track - 1', 'wtr_ct_framework' ),
										'track_2'	=> __( 'Track - 2', 'wtr_ct_framework' ),
										'track_3'	=> __( 'Track - 3', 'wtr_ct_framework' ),
										'track_4'	=> __( 'Track - 4', 'wtr_ct_framework' ),
										'track_5'	=> __( 'Track - 5', 'wtr_ct_framework' ),
										'track_6'	=> __( 'Track - 6', 'wtr_ct_framework' ),
										'track_7'	=> __( 'Track - 7', 'wtr_ct_framework' ),
										'track_8'	=> __( 'Track - 8', 'wtr_ct_framework' ),
										'track_9'	=> __( 'Track - 9', 'wtr_ct_framework' ),
										'track_10'	=> __( 'Track - 10', 'wtr_ct_framework' ),
										'track_11'	=> __( 'Track - 11', 'wtr_ct_framework' ),
										'track_12'	=> __( 'Track - 12', 'wtr_ct_framework' ),
										'track_13'	=> __( 'Track - 13', 'wtr_ct_framework' ),
										'track_14'	=> __( 'Track - 14', 'wtr_ct_framework' ),
										'track_15'	=> __( 'Track - 15', 'wtr_ct_framework' ),
										'custom_pin_1' => __( 'Custom pin - 1', 'wtr_ct_framework' ),
										'custom_pin_2' => __( 'Custom pin - 2', 'wtr_ct_framework' ),
										'custom_pin_3' => __( 'Custom pin - 3', 'wtr_ct_framework' ),
										'custom_pin_3' => __( 'Custom pin - 4', 'wtr_ct_framework' ),
										'custom_pin_arrow' => __( 'Custom pin - arrow', 'wtr_ct_framework' ),
										'custom_pin_plus_1' => __( 'Custom pin - plus 1', 'wtr_ct_framework' ),
										'custom_pin_plus_2' => __( 'Custom pin - plus 2', 'wtr_ct_framework' ),
										'custom_pin_home' => __( 'Custom pin - home', 'wtr_ct_framework' ),
										'custom_pin_forbidden' => __( 'Custom pin - forbidden', 'wtr_ct_framework' ),
										'custom_pin_gas_stations' =>__( 'Custom pin - gas stations', 'wtr_ct_framework' ),
										'custom_pin_market_1' =>__( 'Custom pin - market 1', 'wtr_ct_framework' ),
										'custom_pin_market_2' =>__( 'Custom pin - market 2', 'wtr_ct_framework' ),
										'custom_pin_church' =>__( 'Custom pin - church', 'wtr_ct_framework' ),
										'custom_pin_restaurant' =>__( 'Custom pin - restaurant', 'wtr_ct_framework' ),
										'custom_pin_info_1' =>__( 'Custom pin - info 1', 'wtr_ct_framework' ),
										'custom_pin_info_2' =>__( 'Custom pin - info 2', 'wtr_ct_framework' ),
										'custom_pin_info_3' =>__( 'Custom pin - info 3', 'wtr_ct_framework' ),
									),
		)
	);


	require_once( WTR_ADMIN_CLASS_DIR . '/wtr_meta_box.php' );

	$wtr_GeneralSections = array(
		'id'		=> 'wtr_GeneralSections',
		'name' 		=>__( 'General', 'wtr_ct_framework' ),
		'class'		=> 'General',
		'active_tab'=> true,
		'fields'	=> array(
			$wtr_events_locations_address,
			$wtr_events_locations_email,
			$wtr_events_locations_url,
			$wtr_events_locations_phone,
			$wtr_events_locations_google,
			$wtr_events_locations_type,
			$wtr_events_locations_map_style,
			$wtr_events_locations_marker_style,
			$wtr_events_locations_zoom,
			$wtr_events_locations_scrooll,
		)
	);

	$wtr_meta_settings = array(
		'id' 		=> 'wtr-meta-post',
		'title' 	=> __('Location Options', 'wtr_ct_framework' ),
		'page' 		=> 'events_locations',
		'context' 	=> 'normal',
		'priority' 	=> 'high',
		'sections' 	=> array( $wtr_GeneralSections )
	);

	$wtr_meta_box = NEW wtr_meta_box( $wtr_meta_settings );

} // end wtr_add_metabox_events_locations
add_action( 'load-post.php', 'wtr_add_metabox_events_locations' );
add_action( 'load-post-new.php', 'wtr_add_metabox_events_locations' );


function wtr_get_events_locations( $post_in = null, $none = false ){

	$option		= array();
	if( is_null( $post_in ) OR  ! empty( $post_in ) AND is_array( $post_in ) ) {

		$args		= array( 'post_type' => 'events_locations', 'post_status' => 'any', 'posts_per_page' => -1, 'post__in' => $post_in );
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
} // end wtr_get_events_locations