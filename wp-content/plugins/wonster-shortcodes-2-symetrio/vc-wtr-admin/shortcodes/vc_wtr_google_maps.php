<?php

// Don't load directly
if ( !defined('ABSPATH') ) { die('-1'); }

include_once ( 'vc_wtr.php' );

class WPBakeryShortCode_Vc_Wtr_Google_Maps extends WPBakeryShortCodesContainer {};
class WPBakeryShortCode_Vc_Wtr_Google_Maps_Marker extends WPBakeryShortCode {};
class WPBakeryShortCode_Vc_Wtr_Google_Maps_Road extends WPBakeryShortCode {};
class WPBakeryShortCode_Vc_Wtr_Google_Maps_Contener extends WPBakeryShortCode {};

class VCExtendAddonGoogleMaps extends VCExtendAddonWtr{

	public $base				= 'vc_wtr_google_maps';
	public $base_child_marker	= 'vc_wtr_google_maps_marker';
	public $base_child_road		= 'vc_wtr_google_maps_road';
	public $base_child_contener	= 'vc_wtr_google_maps_contener';

	public $map_fields			= array();
	public $map_marker_fields	= array();
	public $map_road_fields		= array();
	public $map_contener		= array();

	private static $sht_maps_contener		= 0;
	private static $sht_maps_js				= 'var wtr_google_maps = {};';
	private static $tmp_sht_maps_point		= array();
	private static $tmp_sht_maps_road		= array();
	private static $tmp_sht_maps_contener	= array();

	//===FUNCTIONS
	public function __construct(){

		parent::__construct();

		// We safely integrate with VC with this hook
		add_action( 'init', array( &$this, 'integrateWithVC' ) );

		//Creating a shortcode addon
		add_shortcode( $this->base, array( &$this, 'renderContener' ) );
		add_shortcode( $this->base_child_marker, array( &$this, 'renderMarker' ) );
		add_shortcode( $this->base_child_road, array( &$this, 'renderRoad' ) );
		add_shortcode( $this->base_child_contener, array( &$this, 'renderContenerDesc' ) );

		// Register CSS and JS
		add_action( 'wp_footer', array( &$this, 'loadCssAndJs' ) );

		// Modify the default settings
		if( $this->modifyVCCoreStatus() ){
			add_action( 'init', array( &$this, 'modifyVCCore' ), 20 );
		}
	}//end __construct


	public function integrateWithVC(){

		//map fields
		$this->map_fields = array(

			array(
				'param_name'	=> 'alert',
				'heading'		=> '',
				'description'	=> '',
				'type'			=> 'wtr_alert',
				'value'			=> '',
				'admin_label' 	=> false,
				'class'			=> $this->base . '_alert_class',
				'dependency' 	=> array(	'element'	=> 'type_map',
											'value'		=> array( 'STREET_VIEW_PANORAMA', 'STREET_VIEW_PANORAMA_SERVICE' ) ),
				'wtr_attr'		=> array(	'extra_class'	=> '',
											'message'		=> __( '<b>Important!</b> For the <b>&#34;street view panorama&#34;</b> is
																	not recommended to use additional components such as
																	<b>&#34;markers&#34;</b> or <b>&#34;road map&#34;</b>', 'wtr_sht_framework' )
										 ),
			),

			array(
				'param_name'	=> 'type_map',
				'heading'		=> __( 'Map types', 'wtr_sht_framework' ),
				'description'	=> __( 'Specify the type of your map', 'wtr_sht_framework' ),
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'ROADMAP - displays the default road map view', 'wtr_sht_framework' )					=> 'ROADMAP',
											__( 'SATELLITE - displays Google Earth satellite images', 'wtr_sht_framework' )				=> 'SATELLITE',
											__( 'HYBRID - displays a mixture of normal and satellite views', 'wtr_sht_framework' )		=> 'HYBRID',
											__( 'TERRAIN - displays a physical map based on terrain information', 'wtr_sht_framework' )	=> 'TERRAIN',
											__( 'STREET VIEW PANORAMA', 'wtr_sht_framework' )											=> 'STREET_VIEW_PANORAMA',
											/*__( 'STREET VIEW PANORAMA - SERVICE', 'wtr_sht_framework' )									=> 'STREET_VIEW_PANORAMA_SERVICE'*/
									),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_type_class',
			),

			array(
				'param_name'	=> 'heading_map',
				'heading'		=> __( 'Heading', 'wtr_sht_framework' ),
				'description'	=> __( 'The camera heading in degrees relative to true north. True north is <b>0°</b>,
										east is <b>90°</b>, south is <b>180°</b>, west is <b>270°</b>. </br><b>Value must be a number.</b>', 'wtr_sht_framework' ),
				'type'			=> 'textfield',
				'value'			=> __( '0', 'wtr_sht_framework' ),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_heading_class',
				'dependency' 	=> array(	'element'	=> 'type_map',
											'value'		=> array( 'STREET_VIEW_PANORAMA', 'STREET_VIEW_PANORAMA_SERVICE' ) )
			),

			array(
				'param_name'	=> 'pitch_map',
				'heading'		=> __( 'Heading', 'wtr_sht_framework' ),
				'description'	=> __( 'The camera pitch in degrees, relative to the street view vehicle.
										Ranges from <b>90°</b> (directly upwards) to <b>-90°</b> (directly downwards).
										</br><b>Value must be a number.</b>', 'wtr_sht_framework' ),
				'type'			=> 'textfield',
				'value'			=> __( '0', 'wtr_sht_framework' ),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_pitch_class',
				'dependency' 	=> array(	'element'	=> 'type_map',
											'value'		=> array( 'STREET_VIEW_PANORAMA', 'STREET_VIEW_PANORAMA_SERVICE' ) )
			),

			array(
				'param_name'	=> 'style_map',
				'heading'		=> __( 'Map style', 'wtr_sht_framework' ),
				'description'	=> __( 'Specify the style of your map', 'wtr_sht_framework' ),
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'Standard style', 'wtr_sht_framework' )			=> 'standard',
											__( 'Apple Maps-esque', 'wtr_sht_framework' )		=> 'apple_maps_esque',
											__( 'Aqua', 'wtr_sht_framework' )					=> 'aqua',
											__( 'Avocado World', 'wtr_sht_framework' )			=> 'avocado_world',
											__( 'Bates Green', 'wtr_sht_framework' )			=> 'bates_green',
											__( 'Bentley', 'wtr_sht_framework' )				=> 'bentley',
											__( 'Blue', 'wtr_sht_framework' )					=> 'c_blue',
											__( 'Blueprint (No Labels)', 'wtr_sht_framework' )	=> 'blueprint',
											__( 'Blueprint', 'wtr_sht_framework' )				=> 'blueprint_label',
											__( 'Blue Essence', 'wtr_sht_framework' )			=> 'blue_essence',
											__( 'Blue Gray', 'wtr_sht_framework' )				=> 'blue_gray',
											__( 'Blue Water', 'wtr_sht_framework' )				=> 'blue_water',
											__( 'Bluish', 'wtr_sht_framework' )					=> 'bluish',
											__( 'Bright & Bubbly', 'wtr_sht_framework' )		=> 'bright_bubbly',
											__( 'Candy Colours', 'wtr_sht_framework' )			=> 'candy_colours',
											__( 'Caribbean Mountain', 'wtr_sht_framework' )		=> 'caribbean_mountain',
											__( 'Chilled', 'wtr_sht_framework' )				=> 'chilled',
											__( 'Cobalt', 'wtr_sht_framework' )					=> 'cobalt',
											__( 'Countries', 'wtr_sht_framework' )				=> 'countries',
											__( 'Deep Green', 'wtr_sht_framework' )				=> 'deep_green',
											__( 'Esperanto', 'wtr_sht_framework' )				=> 'esperanto',
											__( 'Flat green', 'wtr_sht_framework' )				=> 'flat_green',
											__( 'Flat Map', 'wtr_sht_framework' )				=> 'flat_map',
											__( 'Gowalla', 'wtr_sht_framework' )				=> 'gowalla',
											__( 'Greyscale', 'wtr_sht_framework' )				=> 'greyscale',
											__( 'Hard Edges', 'wtr_sht_framework' )				=> 'hard_edges',
											__( 'Hints of Gold', 'wtr_sht_framework' )			=> 'hints_of_gold',
											__( 'Holiday', 'wtr_sht_framework' )				=> 'holiday',
											__( 'Homage to Toner', 'wtr_sht_framework' )		=> 'homage_to_toner',
											__( 'Hopper', 'wtr_sht_framework' )					=> 'hopper',
											__( 'Hot Pink', 'wtr_sht_framework' )				=> 'hot_pink',
											__( 'Icy Blue', 'wtr_sht_framework' )				=> 'icy_blue',
											__( 'Jane Iredale', 'wtr_sht_framework' )			=> 'jane_iredale',
											__( 'Just places', 'wtr_sht_framework' )			=> 'just_places',
											__( 'Light Green', 'wtr_sht_framework' )			=> 'light_green',
											__( 'Light Monochrome', 'wtr_sht_framework' )		=> 'light_monochrome',
											__( 'Lunar Landscape', 'wtr_sht_framework' )		=> 'lunar_landscape',
											__( 'MapBox', 'wtr_sht_framework' )					=> 'map_box',
											__( 'Midnight Commander', 'wtr_sht_framework' )		=> 'midnight_commander',
											__( 'Military Flat', 'wtr_sht_framework' )			=> 'military_flat',
											__( 'Mixed', 'wtr_sht_framework' )					=> 'mixed',
											__( 'Nature', 'wtr_sht_framework' )					=> 'nature',
											__( 'Neon World', 'wtr_sht_framework' )				=> 'neon_world',
											__( 'Neutral Blue', 'wtr_sht_framework' )			=> 'neutral_blue',
											__( 'Night vision', 'wtr_sht_framework' )			=> 'night_vision',
											__( 'Old Timey', 'wtr_sht_framework' )				=> 'old_timey',
											__( 'Old Dry Mud', 'wtr_sht_framework' )			=> 'old_dry_mud',
											__( 'Pale Dawn', 'wtr_sht_framework' )				=> 'pale_dawn',
											__( 'Paper', 'wtr_sht_framework' )					=> 'paper',
											__( 'Red Alert', 'wtr_sht_framework' )				=> 'red_alert',
											__( 'Red Hues', 'wtr_sht_framework' )				=> 'red_hues',
											__( 'Retro', 'wtr_sht_framework' )					=> 'retro',
											__( 'Roadtrip At Night', 'wtr_sht_framework' )		=> 'roadtrip_at_night',
											__( 'Route XL', 'wtr_sht_framework' )				=> 'route_xl',
											__( 'Shades of Grey', 'wtr_sht_framework' )			=> 'shades_of_grey',
											__( 'Shift Worker', 'wtr_sht_framework' )			=> 'shift_worker',
											__( 'Simple Labels', 'wtr_sht_framework' )			=> 'simple_labels',
											__( 'Snazzy Maps', 'wtr_sht_framework' )			=> 'snazzy_maps',
											__( 'Souldisco', 'wtr_sht_framework' )				=> 'souldisco',
											__( 'Subtle', 'wtr_sht_framework' )					=> 'subtle',
											__( 'Subtle Grayscale', 'wtr_sht_framework' )		=> 'subtle_grayscale',
											__( 'Subtle Green', 'wtr_sht_framework' )			=> 'subtle_green',
											__( 'Subtle Greyscale Map', 'wtr_sht_framework' )	=> 'subtle_greyscale_map',
											__( 'The Endless Atlas', 'wtr_sht_framework' )		=> 'the_endless_atlas',
											__( 'Tripitty', 'wtr_sht_framework' )				=> 'tripitty',
											__( 'Turquoise Water', 'wtr_sht_framework' )		=> 'turquoise_water',
											__( 'Unimposed Topography', 'wtr_sht_framework' )	=> 'unimposed_topography',
											__( 'Unsaturated Browns', 'wtr_sht_framework' )		=> 'unsaturated_browns',
											__( 'Vintage', 'wtr_sht_framework' )				=> 'vintage',
											__( 'Vintage Blue', 'wtr_sht_framework' )			=> 'vintage_blue',
											__( 'Vitamin C', 'wtr_sht_framework' )				=> 'vitamin_c',
										),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_style_class',
				'dependency' 	=> array(	'element'	=> 'type_map',
											'value'		=> array(	'ROADMAP',
																	'SATELLITE',
																	'HYBRID',
																	'TERRAIN',
																	'STREET_VIEW_PANORAMA_SERVICE') )
			),

			array(
				'param_name'	=> 'map',
				'heading'		=> __( 'Center the map', 'wtr_sht_framework' ),
				'description'	=> __( 'To center the map, use the red pin. Pin location centers the map. Important, be vigilant, of this setting depends on what area of ​​the map will be visible on your page.', 'wtr_sht_framework' ),
				'type'			=> 'wtr_google_map',
				'value'			=> '-37.81751|144.959168',
				'admin_label' 	=> false,
				'class'			=> $this->base . '_map_class',
				'wtr_attr'		=> array(
										'type_map_controler'	=> 'type_map',		// false if disable
										'style_map_controler'	=> 'style_map',		// false if disable
										'marker_controler'		=> false,			// false if disable
										'map_height'			=> 300,
										'map_zoom'				=> 10,
									)
			),

			array(
				'param_name'	=> 'height',
				'heading'		=> __( 'Map height', 'wtr_sht_framework' ),
				'description'	=> __( 'Specify the height of your map. <b>Value must be a number.</b>', 'wtr_sht_framework' ),
				'type'			=> 'textfield',
				'value'			=> __( '500', 'wtr_sht_framework' ),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_height_class',
			),

			array(
				'param_name'	=> 'zoom',
				'heading'		=> __( 'Map zoom', 'wtr_sht_framework' ),
				'description'	=> __( 'Zoom value from 1 to 21 where 21 is the greatest and 1 the smallest.', 'wtr_sht_framework' ),
				'type'			=> 'dropdown',
				'value'			=> array(	'1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6',
											'7' => '7', '8' => '8', '9' => '9', '10' => '10', '11' => '11', '12' => '12',
											'13' => '13', '14' => '14', '15' => '15', '16' => '16', '17' => '17',
											'18' => '18', '19' => '19', '20' => '20', '21' => '21'),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_zoom_class',
				'dependency' 	=> array(	'element'	=> 'type_map',
											'value'		=> array( 'ROADMAP', 'SATELLITE', 'HYBRID', 'TERRAIN' ) )
			),

			$this->getDefaultVCfield( 'el_class' ),

			array(
				'param_name'	=> 'scroll',
				'heading'		=> __( 'Scrollwheel', 'wtr_sht_framework' ),
				'description'	=> __( 'Set to false to disable zooming with your mouse scrollwheel.', 'wtr_sht_framework' ),
				'group'			=> $this->shtCardName[ 'additional' ],
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'On', 'wtr_sht_framework' )		=> '1',
											__( 'Off', 'wtr_sht_framework' )	=> '0'
										),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_scroll_class',
			),

			array(
				'param_name'	=> 'move_controls',
				'heading'		=> __( 'Move controls', 'wtr_sht_framework' ),
				'description'	=> '',
				'group'			=> $this->shtCardName[ 'additional' ],
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'On', 'wtr_sht_framework' )		=> '1',
											__( 'Off', 'wtr_sht_framework' )	=> '0'
										),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_move_controls_class',
			),

			array(
				'param_name'	=> 'zoom_control',
				'heading'		=> __( 'Zoom controls', 'wtr_sht_framework' ),
				'description'	=> __( 'Set to false to disable map zoom controls.', 'wtr_sht_framework' ),
				'group'			=> $this->shtCardName[ 'additional' ],
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'On', 'wtr_sht_framework' )		=> '1',
											__( 'Off', 'wtr_sht_framework' )	=> '0'
										),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_zoom_control_class',
			),

			array(
				'param_name'	=> 'type_control',
				'heading'		=> __( 'Map type controls', 'wtr_sht_framework' ),
				'description'	=> __( 'Set to false to disable type controls.', 'wtr_sht_framework' ),
				'group'			=> $this->shtCardName[ 'additional' ],
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'On', 'wtr_sht_framework' )		=> '1',
											__( 'Off', 'wtr_sht_framework' )	=> '0'
										),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_type_control_class',
				'dependency' 	=> array(	'element'	=> 'type_map',
											'value'		=> array( 'ROADMAP', 'SATELLITE', 'HYBRID', 'TERRAIN' ) )
			),

			array(
				'param_name'	=> 'address_control',
				'heading'		=> __( 'Address control', 'wtr_sht_framework' ),
				'description'	=>'',
				'group'			=> $this->shtCardName[ 'additional' ],
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'On', 'wtr_sht_framework' )		=> '1',
											__( 'Off', 'wtr_sht_framework' )	=> '0'
										),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_address_control_class',
				'dependency' 	=> array(	'element'	=> 'type_map',
											'value'		=> array( 'STREET_VIEW_PANORAMA' ) )
			),

			array(
				'param_name'	=> 'click_to_go',
				'heading'		=> __( 'Click ToGo', 'wtr_sht_framework' ),
				'description'	=>'',
				'group'			=> $this->shtCardName[ 'additional' ],
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'On', 'wtr_sht_framework' )		=> '1',
											__( 'Off', 'wtr_sht_framework' )	=> '0'
										),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_click_to_go_class',
				'dependency' 	=> array(	'element'	=> 'type_map',
											'value'		=> array( 'STREET_VIEW_PANORAMA' ) )
			),

			array(
				'param_name'	=> 'disable_default_ui',
				'heading'		=> __( 'Disable default UI', 'wtr_sht_framework' ),
				'description'	=>'',
				'group'			=> $this->shtCardName[ 'additional' ],
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'On', 'wtr_sht_framework' )		=> '1',
											__( 'Off', 'wtr_sht_framework' )	=> '0'
										),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_click_disable_default_ui_class',
				'dependency' 	=> array(	'element'	=> 'type_map',
											'value'		=> array( 'STREET_VIEW_PANORAMA' ) )
			),
		);

			//google maps
			vc_map( array(
				'name'						=> __( 'Google Maps', 'wtr_sht_framework' ),
				'description'				=> '',
				'base'						=> $this->base,
				'class'						=> $this->base . '_div',
				'icon'						=> $this->base . '_icon',
				'controls'					=> 'full',
				'category'					=> $this->groupSht[ 'elements' ],
				'params'					=> $this->map_fields,
				'show_settings_on_create'	=> true,
				'content_element'			=> true,
				'as_parent'					=> array( 'only' => $this->base_child_marker . ',' . $this->base_child_road . ',' . $this->base_child_contener ),
				'js_view'					=> 'VcColumnView',
				'weight'					=> 28000,
				)
			);


		//marker fields
		$this->map_marker_fields = array(

			array(
				'param_name'	=> 'title_marker',
				'heading'		=> __( 'Marker title', 'wtr_sht_framework' ),
				'description'	=> __( 'This name will appear when your cursor hover the marker placed on the map', 'wtr_sht_framework' ),
				'type'			=> 'textfield',
				'value'			=> __( 'e.g. Envato - PO Box 16122 Collins Street West', 'wtr_sht_framework' ),
				'admin_label' 	=> true,
				'class'			=> $this->base_child_marker . '_title_marker_class',
			),

			array(
				'param_name'	=> 'url_link',
				'heading'		=> __( 'Link', 'wtr_sht_framework' ),
				'description'	=> __( 'Where should your marker link to?', 'wtr_sht_framework' ),
				'type'			=> 'vc_link',
				'value'			=> '',
				'admin_label' 	=> false,
				'class'			=> $this->base_child_marker . '_url_class',
			),

			array(
				'param_name'	=> 'marker_style',
				'heading'		=> __( 'Marker style', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'dropdown',
				'value'			=> array(
										__( 'Standard', 'wtr_sht_framework' )					=> 'standard',
										__( 'My own', 'wtr_sht_framework' )						=> 'my_own',
										__( 'Pin - red circle', 'wtr_sht_framework' )			=> 'pin_red_circle',
										__( 'Pin - red stars', 'wtr_sht_framework' )			=> 'pin_red_stars',
										__( 'Pin - blue blank', 'wtr_sht_framework' )			=> 'pin_blue_blank',
										__( 'Pin - blue circle', 'wtr_sht_framework' )			=> 'pin_blue_circle',
										__( 'Pin - blue stars', 'wtr_sht_framework' )			=> 'pin_blue_stars',
										__( 'Pin - light blue blank', 'wtr_sht_framework' )		=> 'pin_light_blue_blank',
										__( 'Pin - light blue circle', 'wtr_sht_framework' )	=> 'pin_light_blue_circle',
										__( 'Pin - light blue stars', 'wtr_sht_framework' )		=> 'pin_light_blue_stars',
										__( 'Pin - green blank', 'wtr_sht_framework' )			=> 'pin_green_blank',
										__( 'Pin - green circle', 'wtr_sht_framework' )			=> 'pin_green_circle',
										__( 'Pin - green stars', 'wtr_sht_framework' )			=> 'pin_green_stars',
										__( 'Pin - pink blank', 'wtr_sht_framework' )			=> 'pin_pink_blank',
										__( 'Pin - pink circle', 'wtr_sht_framework' )			=> 'pin_pink_circle',
										__( 'Pin - pink stars', 'wtr_sht_framework' )			=> 'pin_pink_stars',
										__( 'Pin - purple blank', 'wtr_sht_framework' )			=> 'pin_purple_blank',
										__( 'Pin - purple circle', 'wtr_sht_framework' )		=> 'pin_purple_circle',
										__( 'Pin - purple stars', 'wtr_sht_framework' )			=> 'pin_purple_stars',
										__( 'Pin - white blank', 'wtr_sht_framework' )			=> 'pin_white_blank',
										__( 'Pin - white circle', 'wtr_sht_framework' )			=> 'pin_white_circle',
										__( 'Pin - white stars', 'wtr_sht_framework' )			=> 'pin_white_stars',
										__( 'Pin - yellow blank', 'wtr_sht_framework' )			=> 'pin_yellow_blank',
										__( 'Pin - yellow circle', 'wtr_sht_framework' )		=> 'pin_yellow_circle',
										__( 'Pin - yellow stars', 'wtr_sht_framework' )			=> 'pin_yellow_stars',
										__( 'Pin - 1', 'wtr_sht_framework' )					=> 'pin1',
										__( 'Pin - 2', 'wtr_sht_framework' )					=> 'pin2',
										__( 'Pin - 3', 'wtr_sht_framework' )					=> 'pin3',
										__( 'Pin - 4', 'wtr_sht_framework' )					=> 'pin4',
										__( 'Pin - 5', 'wtr_sht_framework' )					=> 'pin5',
										__( 'Pin - 6', 'wtr_sht_framework' )					=> 'pin6',
										__( 'Pin - 7', 'wtr_sht_framework' )					=> 'pin7',
										__( 'Pin - 8', 'wtr_sht_framework' )					=> 'pin8',
										__( 'Pin - 9', 'wtr_sht_framework' )					=> 'pin9',
										__( 'Pin - 10', 'wtr_sht_framework' )					=> 'pin10',
										__( 'Pin - A', 'wtr_sht_framework' )					=> 'pin_a',
										__( 'Pin - B', 'wtr_sht_framework' )					=> 'pin_b',
										__( 'Pin - C', 'wtr_sht_framework' )					=> 'pin_c',
										__( 'Pin - D', 'wtr_sht_framework' )					=> 'pin_d',
										__( 'Pin - E', 'wtr_sht_framework' )					=> 'pin_e',
										__( 'Pin - F', 'wtr_sht_framework' )					=> 'pin_f',
										__( 'Pin - G', 'wtr_sht_framework' )					=> 'pin_g',
										__( 'Pin - H', 'wtr_sht_framework' )					=> 'pin_h',
										__( 'Pin - I', 'wtr_sht_framework' )					=> 'pin_i',
										__( 'Pin - J', 'wtr_sht_framework' )					=> 'pin_j',
										__( 'Pin - K', 'wtr_sht_framework' )					=> 'pin_k',
										__( 'Pin - L', 'wtr_sht_framework' )					=> 'pin_l',
										__( 'Pin - M', 'wtr_sht_framework' )					=> 'pin_m',
										__( 'Pin - N', 'wtr_sht_framework' )					=> 'pin_n',
										__( 'Pin - O', 'wtr_sht_framework' )					=> 'pin_o',
										__( 'Pin - P', 'wtr_sht_framework' )					=> 'pin_p',
										__( 'Pin - Q', 'wtr_sht_framework' )					=> 'pin_q',
										__( 'Pin - R', 'wtr_sht_framework' )					=> 'pin_r',
										__( 'Pin - S', 'wtr_sht_framework' )					=> 'pin_s',
										__( 'Pin - T', 'wtr_sht_framework' )					=> 'pin_t',
										__( 'Pin - U', 'wtr_sht_framework' )					=> 'pin_u',
										__( 'Pin - V', 'wtr_sht_framework' )					=> 'pin_v',
										__( 'Pin - W', 'wtr_sht_framework' )					=> 'pin_w',
										__( 'Pin - X', 'wtr_sht_framework' )					=> 'pin_x',
										__( 'Pin - Y', 'wtr_sht_framework' )					=> 'pin_y',
										__( 'Pin - Z', 'wtr_sht_framework' )					=> 'pin_z',
										__( 'Push pin - blue', 'wtr_sht_framework' )			=> 'pushpin_blue',
										__( 'Push pin -  green', 'wtr_sht_framework' )			=> 'pushpin_green',
										__( 'Push pin -  light blue', 'wtr_sht_framework' )		=> 'pushpin_light_blue',
										__( 'Push pin -  pink', 'wtr_sht_framework' )			=> 'pushpin_pink',
										__( 'Push pin -  purple', 'wtr_sht_framework' )			=> 'pushin_purple',
										__( 'Push pin -  red', 'wtr_sht_framework' )			=> 'pushin_red',
										__( 'Push pin -  white', 'wtr_sht_framework' )			=> 'pushin_white',
										__( 'Push pin -  yellow', 'wtr_sht_framework' )			=> 'pushin_yellow',
										__( 'Track - 1', 'wtr_sht_framework' )					=> 'track_1',
										__( 'Track - 2', 'wtr_sht_framework' )					=> 'track_2',
										__( 'Track - 3', 'wtr_sht_framework' )					=> 'track_3',
										__( 'Track - 4', 'wtr_sht_framework' )					=> 'track_4',
										__( 'Track - 5', 'wtr_sht_framework' )					=> 'track_5',
										__( 'Track - 6', 'wtr_sht_framework' )					=> 'track_6',
										__( 'Track - 7', 'wtr_sht_framework' )					=> 'track_7',
										__( 'Track - 8', 'wtr_sht_framework' )					=> 'track_8',
										__( 'Track - 9', 'wtr_sht_framework' )					=> 'track_9',
										__( 'Track - 10', 'wtr_sht_framework' )					=> 'track_10',
										__( 'Track - 11', 'wtr_sht_framework' )					=> 'track_11',
										__( 'Track - 12', 'wtr_sht_framework' )					=> 'track_12',
										__( 'Track - 13', 'wtr_sht_framework' )					=> 'track_13',
										__( 'Track - 14', 'wtr_sht_framework' )					=> 'track_14',
										__( 'Track - 15', 'wtr_sht_framework' )					=> 'track_15',
										__( 'Custom pin - 1', 'wtr_sht_framework' )				=> 'custom_pin_1',
										__( 'Custom pin - 2', 'wtr_sht_framework' )				=> 'custom_pin_2',
										__( 'Custom pin - 3', 'wtr_sht_framework' )				=> 'custom_pin_3',
										__( 'Custom pin - 4', 'wtr_sht_framework' )				=> 'custom_pin_4',
										__( 'Custom pin - arrow', 'wtr_sht_framework' )			=> 'custom_pin_arrow',
										__( 'Custom pin - plus 1', 'wtr_sht_framework' )		=> 'custom_pin_plus_1',
										__( 'Custom pin - plus 2', 'wtr_sht_framework' )		=> 'custom_pin_plus_2',
										__( 'Custom pin - home', 'wtr_sht_framework' )			=> 'custom_pin_home',
										__( 'Custom pin - forbidden', 'wtr_sht_framework' )		=> 'custom_pin_forbidden',
										__( 'Custom pin - gas stations', 'wtr_sht_framework' )	=> 'custom_pin_gas_stations',
										__( 'Custom pin - market 1', 'wtr_sht_framework' )		=> 'custom_pin_market_1',
										__( 'Custom pin - market 2', 'wtr_sht_framework' )		=> 'custom_pin_market_2',
										__( 'Custom pin - church', 'wtr_sht_framework' )		=> 'custom_pin_church',
										__( 'Custom pin - restaurant', 'wtr_sht_framework' )	=> 'custom_pin_restaurant',
										__( 'Custom pin - info 1', 'wtr_sht_framework' )		=> 'custom_pin_info_1',
										__( 'Custom pin - info 2', 'wtr_sht_framework' )		=> 'custom_pin_info_2',
										__( 'Custom pin - info 3', 'wtr_sht_framework' )		=> 'custom_pin_info_3',
									),
				'admin_label' 	=> true,
				'class'			=> $this->base_child_marker . '_type_class',
			),

			array(
				'param_name'	=> 'own_marker_style',
				'heading'		=> __( 'Upload your own maker', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'attach_image',
				'value'			=> '',
				'admin_label' 	=> false,
				'class'			=> $this->base_child_marker . '_own_marker_style',
				'dependency' 	=> array(	'element'	=> 'marker_style',
											'value'		=> array( 'my_own' ) )
			),

			array(
				'param_name'	=> 'geo_marker',
				'heading'		=> __( 'Marker coordinates', 'wtr_sht_framework' ),
				'description'	=> __( 'To specify the coordinates of the marker you can use our search engine located
										above the map. You can change the position of the cursor by dragging it to the
										desired location', 'wtr_sht_framework' ),
				'type'			=> 'wtr_google_map',
				'value'			=> '-37.81751|144.959168',
				'admin_label' 	=> false,
				'class'			=> $this->base_child_marker . '_geo_marker_class',
				'wtr_attr'		=> array(
										'type_map_controler'	=> false,							// false if disable
										'style_map_controler'	=> false,							// false if disable
										'marker_controler'		=> 'marker_style|own_marker_style',	// false if disable
										'map_height'			=> 300,
										'map_zoom'				=> 10,
									)
			),
		);
			//google maps - marker
			vc_map( array(
				'name'						=> __( 'Google Maps - Marker', 'wtr_sht_framework' ),
				'description'				=> '',
				'base'						=> $this->base_child_marker,
				'class'						=> $this->base_child_marker . '_div ' . $this->wtrShtMainClass,
				'icon'						=> $this->base_child_marker . '_icon',
				'controls'					=> 'full',
				'category'					=> $this->groupSht[ 'elements' ],
				'params'					=> $this->map_marker_fields,
				'show_settings_on_create'	=> true,
				'content_element'			=> true,
				'as_child'					=> array('only' => $this->base ),
				)
			);


		//road fields
		$this->map_road_fields	= array(

			array(
				'param_name'	=> 'desc',
				'heading'		=> __( 'Label', 'wtr_sht_framework' ),
				'description'	=> __( 'The name of the road', 'wtr_sht_framework' ),
				'type'			=> 'textfield',
				'value'			=> __( 'Road #1', 'wtr_sht_framework' ),
				'admin_label' 	=> false,
				'class'			=> $this->base_child_road . '_desc_style',
			),

			array(
				'param_name'	=> 'color_line',
				'heading'		=> __( 'Color line', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'colorpicker',
				'value'			=> '#dd3333',
				'admin_label' 	=> false,
				'class'			=> $this->base_child_road . '_color_line_style',
			),

			array(
				'param_name'	=> 'weight_line',
				'heading'		=> __( 'Weight line road', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'dropdown',
				'value'			=> array(	'3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8',
											'9' => '9', '10' => '10', '11' => '12', '13' => '13', '14' => '14',
											'15' => '15', '16' => '16', '17' => '17', '18' => '18', '19' => '19',
											'20' => '20', '21' => '21', '22' => '22', '23' => '23', '24' => '24',
											'25' => '25', '26' => '26', '27' => '27', '28' => '28', '29' => '29',
											'30' => '30' ),
				'admin_label' 	=> false,
				'class'			=> $this->base_child_road . '_weight_line_style',
			),

			array(
				'param_name'	=> 'geo_road',
				'heading'		=> __( 'Road coordinates', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'wtr_google_map',
				'value'			=> '-37.81751|144.959168',
				'admin_label' 	=> false,
				'class'			=> $this->base_child_road . '_geo_road_class',
				'wtr_attr'		=> array(
										'type_map_controler'	=> false,				// false if disable
										'style_map_controler'	=> false,				// false if disable
										'marker_controler'		=> false,				// false if disable
										'map_height'			=> 300,
										'road_contener'			=> 'points',			// false if disable
										'road_color'			=> 'color_line',		// false if disable
										'road_weight'			=> 'weight_line',		// false if disable
										'map_zoom'				=> 13,
									)
			),

			array(
				'param_name'	=> 'points',
				'heading'		=> '',
				'description'	=> '',
				'type'			=> 'wtr_hidden',
				'value'			=> '',
				'admin_label' 	=> false,
				'class'			=> $this->base_child_road . '_points_style',
			),
		);
			//google maps - road
			vc_map( array(
				'name'						=> __( 'Google Maps - Road', 'wtr_sht_framework' ),
				'description'				=> '',
				'base'						=> $this->base_child_road,
				'class'						=> $this->base_child_road . '_div',
				'icon'						=> $this->base_child_road . '_icon',
				'controls'					=> 'full',
				'category'					=> $this->groupSht[ 'elements' ],
				'params'					=> $this->map_road_fields,
				'show_settings_on_create'	=> true,
				'content_element'			=> true,
				'as_child'					=> array('only' => $this->base ),
				)
			);

		// contener fields
		$this->map_contener = array(

			array(
				'param_name'	=> 'alert',
				'heading'		=> '',
				'description'	=> '',
				'type'			=> 'wtr_alert',
				'value'			=> '',
				'admin_label' 	=> false,
				'class'			=> $this->base . '_alert_class',
				'wtr_attr'		=> array(	'extra_class'	=> '',
											'message'		=> __( '<b>Important!</b> For one map is recommended to use
																	only one container.', 'wtr_sht_framework' )
										 ),
			),

			array(
				'param_name'	=> 'align',
				'heading'		=> __( 'Container alignment', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'Left', 'wtr_sht_framework' )	=> 'left',
											__( 'Right', 'wtr_sht_framework' )	=> 'right'
									),
				'admin_label' 	=> true,
				'class'			=> $this->base . '_align_class',
			),

			array(
				'param_name'	=> 'content',
				'heading'		=> __( 'Content', 'wtr_sht_framework' ),
				'description'	=> __( 'the contents of the container', 'wtr_sht_framework' ),
				'type'			=> 'textarea_html',
				'value'			=> __( 'Please insert code here', 'wtr_sht_framework' ),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_data_content_class',
			)
		);

			//google maps - contener
			vc_map( array(
				'name'						=> __( 'Google Maps - Container', 'wtr_sht_framework' ),
				'description'				=> '',
				'base'						=> $this->base_child_contener,
				'class'						=> $this->base_child_contener . '_div',
				'icon'						=> $this->base_child_contener . '_icon',
				'controls'					=> 'full',
				'category'					=> $this->groupSht[ 'elements' ],
				'params'					=> $this->map_contener,
				'show_settings_on_create'	=> true,
				'content_element'			=> true,
				'as_child'					=> array('only' => $this->base ),
				)
			);
	}//end integrateWithVC


	public function renderContener( $atts, $content = null ){

		$result				= '';
		$atts['content']	= wpb_js_remove_wpautop( $content, false );
		$atts				= $this->prepareCorrectShortcode( $this->map_fields, $atts );
		$map_attr			= $atts;
		$desc_area			= count( self::$tmp_sht_maps_contener );
		extract( $atts );

		unset(
			$map_attr[ 'el_class' ],
			$map_attr[ 'align' ],
			$map_attr[ 'height' ],
			$map_attr[ 'content' ],
			$map_attr[ 'animate' ],
			$map_attr[ 'delay' ]
		);

		//prepare js
		self::$sht_maps_js .= 'wtr_google_maps[ ' . self::$sht_maps_contener . ' ] = { data : {}, markers : [], roads : [] };';

			//data
			$map_attr_str = array();
			foreach( $map_attr as $key => $val ){
				$map_attr_str[] = $key . ' : "' . $val . '"';
			}
			self::$sht_maps_js .= 'wtr_google_maps[ ' . self::$sht_maps_contener . ' ].data = { ' . implode( ',', $map_attr_str ) . ' };';

			//markers
			$markers_c = count( self::$tmp_sht_maps_point );
			if( $markers_c ){
				$map_marker_attr_str = array();
				for( $i = 0; $i < $markers_c; ++$i ){
					foreach( self::$tmp_sht_maps_point[ $i ] as $key => $val ){
						$map_marker_attr_str[] = $key . ' : "' . $val . '"';
					}
					self::$sht_maps_js .= 'wtr_google_maps[ ' . self::$sht_maps_contener . ' ].markers[' . $i . '] = { ' . implode( ',', $map_marker_attr_str ) . ' };';
				}
			}

			//roads
			$roads_c = count( self::$tmp_sht_maps_road );
			if( $roads_c ){
				$map_marker_attr_str = array();
				for( $i = 0; $i < $roads_c; ++$i ){
					foreach( self::$tmp_sht_maps_road[ $i ] as $key => $val ){
						$map_marker_attr_str[] = $key . ' : "' . $val . '"';
					}
					self::$sht_maps_js .= 'wtr_google_maps[ ' . self::$sht_maps_contener . ' ].roads[' . $i . '] = { ' . implode( ',', $map_marker_attr_str ) . ' };';
				}
			}

		//create html
		$style = ' style="height:' . intval( $height ) . 'px;" ';

		$result .= '<div data-contener="' . self::$sht_maps_contener . '" class="wtrSht wtrShtGoogleMaps ' . esc_attr( $el_class ) . '">';

			if( $desc_area ){
				for( $k = 0; $k < $desc_area; $k++ ){

					$ext_class = ( 'left' == self::$tmp_sht_maps_contener[ $k ][ 'align' ] ) ? ' wtrShtGoogleMapsInfoBoxLeft ' : '';

					$result .= '<div class="wtrInner">';
						$result .= '<div class="wtrPageContent">';
							$result .= '<div class="wtrShtGoogleMapsInfoBox wtrRadius3' . $ext_class . '">';
								$result .= self::$tmp_sht_maps_contener[ $k ][ 'content' ];
							$result .= '</div>';
						$result .= '</div>';
					$result .= '</div>';
				}
			}
			$result .= '<div ' . $style . ' data-mheight="' . intval( $height ) . '" data-contener="' . self::$sht_maps_contener . '" class="wtrShtGoogleMapsContener" id="wtr-google-maps-contener-' . self::$sht_maps_contener . '"></div>';

			if( $desc_area ){
				for( $k = 0; $k < $desc_area; $k++ ){
					$result .= '<div class="wtrInner">';
						$result .= '<div class="wtrPageContent">';
							$result .= '<div class="wtrShtGoogleMapsInfoBoxMobile wtrRadius3">';
								$result .= self::$tmp_sht_maps_contener[ $k ][ 'content' ];
							$result .= '</div>';
						$result .= '</div>';
					$result .= '</div>';
				}
			}

		$result .= '</div>';

		// cleaning variables
		self::$sht_maps_contener++;
		self::$tmp_sht_maps_point	= array();
		self::$tmp_sht_maps_road	= array();
		self::$tmp_sht_maps_contener= array();

		return $result;
	}//end Render


	public function renderMarker( $atts, $content = null ){
		$result		='';
		$atts		= $this->prepareCorrectShortcode( $this->map_marker_fields, $atts );
		$content	= wpb_js_remove_wpautop( $content, false );

		if( 'my_own' == $atts[ 'marker_style' ] ){
			$id_file	= $atts[ 'own_marker_style' ];
			$ext		= array( 'width' => '', 'height' => '', 'url' => '' );
			$file		= wp_get_attachment_metadata( $id_file );

			if( $file ){
				$upload_dir			= wp_upload_dir();
				$ext[ 'width' ]		= $file[ 'width' ];
				$ext[ 'height' ]	= $file[ 'height' ];
				$ext[ 'url' ]		= trailingslashit ( $upload_dir[ 'baseurl' ] ) . $file[ 'file' ];
			}

			$atts = array_merge( $atts, $ext );
		}
		array_push( self::$tmp_sht_maps_point, $atts );
		return $content;
	}//end Render


	public function renderRoad( $atts, $content = null ){
		$result		='';
		$atts		= $this->prepareCorrectShortcode( $this->map_road_fields, $atts );
		$content	= wpb_js_remove_wpautop( $content, false );

		array_push( self::$tmp_sht_maps_road, $atts );
		return $content;
	}//end Render


	public function renderContenerDesc( $atts, $content = null ){
		$result				='';
		$atts				= $this->prepareCorrectShortcode( $this->map_contener, $atts );
		$content			= wpb_js_remove_wpautop( $content, WPBMap::getTagsRegexp() );
		$atts[ 'content' ]	= $content;
		array_push( self::$tmp_sht_maps_contener, $atts );
		return $content;
	}//end renderContener


	public function loadCssAndJs(){
		echo '<script type="text/javascript">' . self::$sht_maps_js . '</script>';
	}//end loadCssAndJs
}//end VCExtendAddonAnimateCss

new VCExtendAddonGoogleMaps();