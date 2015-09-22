<?php
// Don't load directly
if ( !defined('ABSPATH') ) { die('-1'); }

if ( !defined( 'WTR_CP_PLUGIN_MAIN_FILE' ) ) { return; }

include_once ( 'vc_wtr.php' );

class VCExtendAddonEvents extends VCExtendAddonWtr{

	public $base	= 'vc_wtr_events';
	public $fields	= array();

	//===FUNCTIONS
	public function __construct(){

		parent::__construct();

		// We safely integrate with VC with this hook
		add_action( 'init', array( &$this, 'integrateWithVC' ) );

		//Creating a shortcode addon
		add_shortcode( $this->base, array( &$this, 'render' ) );
	}//end __construct


	public function integrateWithVC(){
		// Map fields

		$this->fields = array(

			array(
				'param_name'	=> 'mode',
				'heading'		=> __( 'Presentation style', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'List', 'wtr_sht_framework' )	=> 'list',
											__( 'Box', 'wtr_sht_framework' )	=> 'box',
										),
				'admin_label' 	=> true,
				'class'			=> $this->base . '_mode_class',
			),

			array(
				'param_name'	=> 'gym_location',
				'heading'		=> __( 'Gym locations', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'wtr_multi_select',
				'value'			=> $this->getWpQuery( array( 'post_type' => 'gym_location' ) ),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_gym_location_class',
				'wtr_attr'		=> array( 'size' => 3 ),
			),

			array(
				'param_name'	=> 'categories',
				'heading'		=> __( 'Events category', 'wtr_sht_framework' ),
				'description'	=> __( 'Select a events to be attached to content', 'wtr_sht_framework' ),
				'type'			=> 'wtr_multi_select',
				'value'			=> $this->getTermsData( 'events-category' ),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_categories_class',
				'wtr_attr'		=> array( 'size' => 6 ),
			),

			array(
				'param_name'	=> 'order',
				'heading'		=> __( 'Order events by', 'wtr_sht_framework' ),
				'description'	=> __( 'Specify the order of events category', 'wtr_sht_framework' ),
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'Date event (ascending)', 'wtr_sht_framework' )		=> 'data_add_asc',
											__( 'Date event (descending)', 'wtr_sht_framework' )	=> 'data_add_desc',
											__( 'Order value (ascending)', 'wtr_sht_framework' )	=> 'order_asc',
											__( 'Order value (descending)', 'wtr_sht_framework' )	=> 'order_desc',
											__( 'Title (ascending)', 'wtr_sht_framework' )			=> 'title_asc',
											__( 'Title (descending)', 'wtr_sht_framework' )			=> 'title_desc',
										),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_order_class',
			),

			array(
				'param_name'	=> 'show',
				'heading'		=> __( 'Show', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'All', 'wtr_sht_framework' )		=> 'wtr_all_items',
											__( 'Upcoming', 'wtr_sht_framework' )	=> 'upcoming',

										),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_show_class',
			),

			array(
				'param_name'	=> 'limit',
				'heading'		=> __( 'Item limit', 'wtr_sht_framework' ),
				'description'	=> __( '<b>Please, use only numeric signs</b>', 'wtr_sht_framework' ),
				'type'			=> 'textfield',
				'value'			=> '4',
				'admin_label' 	=> false,
				'class'			=> $this->base . '_limit_class',
			),

			$this->getDefaultVCfield( 'el_class' ),
		);

		// animate attr
		$this->shtAnimateAttrGenerator( $this->fields, true );

		vc_map( array(
			'name'			=> __( 'Events', 'wtr_sht_framework' ),
			'description'	=> '',
			'base'			=> $this->base,
			'class'			=> $this->base . '_div '. $this->wtrShtMainClass,
			'icon'			=> $this->base . '_icon',
			'controls'		=> 'full',
			'category'		=> $this->groupSht[ 'elements' ],
			'params'		=> $this->fields,
			'weight'		=> 29750,
			)
		);
	}//end integrateWithVC


	public function render( $atts, $content = null ){
		$result	='';
		$atts	= $this->prepareCorrectShortcode( $this->fields, $atts );
		extract( $atts );

		global $post_settings;

		$i						= 1;
		$tax_query				= null;
		$meta_key				= null;
		$meta_query				= null;
		$query_gym_location		= ( 'wtr_all_items' == $gym_location ) ? '' :explode(',', $gym_location );
		$query_category			= ( 'wtr_all_items' == $categories ) ? '' :explode(',', $categories );

		if( $query_category ){
			$tax_query[]	=  array(
				'taxonomy'			=> 'events-category',
				'field'				=> 'slug',
				'terms'				=> $query_category,
				'include_children'	=> false
			);
		}

		if( $query_gym_location ){
			$meta_query[]	=array(
				'key'				=> '_wtr_gym_location',
				'value'				=> $query_gym_location,
				'compare'			=> 'IN',
			);
		}
		if( 'upcoming' == $show ){
			$meta_query[]	=array(
				'key'				=> '_wtr_event_time_end',
				'value'				=> current_time( "timestamp" ),
				'compare'			=> '>=',
			);
		}

		switch ( $order ) {
			case 'order_desc':
			default:
				$query_orderby	= 'menu_order';
				$query_order	= 'DESC';
				break;

			case 'order_asc':
				$query_orderby	= 'menu_order';
				$query_order	= 'ASC';
				break;

			case 'data_add_desc':
				$meta_key		= '_wtr_event_time_start';
				$query_orderby	= 'meta_value';
				$query_order	= 'DESC';
				break;

			case 'data_add_asc':
				$meta_key		= '_wtr_event_time_start';
				$query_orderby	= 'meta_value';
				$query_order	= 'ASC';
				break;
			case 'title_desc':
				$query_orderby	= 'title';
				$query_order	= 'DESC';
				break;

			case 'title_asc':
				$query_orderby	= 'title';
				$query_order	= 'ASC';
				break;
		}

		$query_args		= array(
			'post_type'			=> 'events',
			'posts_per_page'	=> $limit,
			'orderby'			=> $query_orderby,
			'order'				=> $query_order,
			'meta_key'			=> $meta_key,
			'tax_query'			=> $tax_query,
			'meta_query'		=> $meta_query
		);

		// The Query
		$the_query = new WP_Query( $query_args );


		if ( $the_query->have_posts() ) {

			if( 'box' == $mode ){

				$class_row	='wtrShtOrderChange';
				$item_rows	= 2;

				while ( $the_query->have_posts() ) {
					$the_query->the_post();

					$id					= get_the_id();
					$title				= get_the_title();
					$url				= esc_url( get_the_permalink() );
					$time_start			= get_post_meta( $id, '_wtr_event_time_start', true );
					$date				= date_i18n( $post_settings['wtr_EventDateFormat']['all'], $time_start );
					$datetime			= date( 'Y-m-d', $time_start );
					$price				= get_post_meta( $id, '_wtr_event_price', true );
					$post_thumbnail_id	= get_post_thumbnail_id( $id );
					$image_attributes	= wp_get_attachment_image_src( $post_thumbnail_id, 'size_2' );
					$image_alt			= esc_attr( get_post_meta( $post_thumbnail_id, '_wp_attachment_image_alt', true ) );
					$image				= ( $image_attributes[0] ) ? $image_attributes[0] : $post_settings['wtr_DefalutThumbnail'] ;


					if( $i == 1 ){
						$class_row			= ( empty( $class_row ) ) ? 'wtrShtOrderChange' : '';
						$class_html_attr	= 'wtrSht wtrShtBoxedEvents ' . $class_row . ' ' . $el_class . ' clearfix';
						$result .= '<div' . $this->shtAnimateHTML( $class_html_attr, $atts ) . ' >';
					}
					$i++;

					$result .= '<div class="wtrShtBoxedEventsSpace wtrShtBoxedEventsCoOneHalf clearfix">';
						$result .= '<div class="wtrShtBoxedEventsColOne clearfix">';
							$result .= '<a href="' . $url . '" class="wtrShtBoxedEventsColTwo wtrShtBoxedEventsImgContainer">';
								$result .= '<span class="wtrShtBoxedEventsElements wtrShtBoxedClassesAnimate"></span>';
								$result .= '<span class="wtrShtBoxedEventsOverlay wtrShtBoxedClassesAnimate"></span>';
								$result .= '<span></span>';
								$result .= '<img src="' . $image . '" alt="' . $image_alt . '">';
							$result .= '</a>';
							$result .= '<div class="wtrShtBoxedEventsColTwoSec">';
								$result .= '<div class="wtrShtBoxedEventsContainerSpace"></div>';
								$result .= '<div class="wtrShtBoxedEventsContainer">';
									$result .= '<div class="wtrShtBoxedEventsInfo clearfix">';
										$result .= '<time datetime="' . esc_attr( $datetime ) . '" class="wtrShtBoxedEventsTime wtrRadius3">';
											$result .= $date;
										$result .= '</time>';
										$result .= '<span class="wtrShtBoxedEventPrice ">' . $price . '</span>';
									$result .= '</div>';
									$result .= '<h3 class="wtrShtBoxedEventsHeadline">';
										$result .= '<a href="' . $url . '">' . $title . '</a>';
									$result .= '</h3>';
									$result .= '<a class="wtrShtBoxedEventsReadMore" href="' . $url . '">' . $post_settings['wtr_TranslateEventSHTReadMore'] . ' <i class="fa fa-long-arrow-right"></i></a>';
								$result .= '</div>';
							$result .= '</div>';
						$result .= '</div>';
					$result .= '</div>';

					if( $item_rows <  $i ){
						$result .= '</div>';
						$i = 1;
					}
				}

				if( $i != 1 ) {
					$result .= '</div>';
				}

			} else if( 'list'){
				$class_html_attr = 'wtrSht wtrShtEventList ' .  $el_class ;
				$result .= '<ul' . $this->shtAnimateHTML( $class_html_attr, $atts ) . '>';
				while ( $the_query->have_posts() ) {
					$the_query->the_post();

					$id					= get_the_id();
					$title				= get_the_title();
					$url				= esc_url( get_the_permalink() );
					$time_start			= get_post_meta( $id, '_wtr_event_time_start', true );
					$date				= date_i18n( $post_settings['wtr_EventDateFormat']['all'], $time_start );
					$price				= get_post_meta( $id, '_wtr_event_price', true );


					$result .= '<li class="wtrShtEventListItem clearfix">';
						$result .= '<div class="wtrShtEventListPriceContainer">';
							$result .= '<div class="wtrShtEventListPrice wtrRadius2">' . $price . '</div>';
								$result .= '<span class="wtrShtEventListTime wtrRadius2">';
									$result .= $date;
								$result .= '</span>';
							$result .= '</div>';
							$result .= '<div class="wtrShtEventListTittleContainer">';
								$result .= '<h3 class="wtrShtEventListTittle">';
									$result .= '<a href="' . $url . '">' . $title . '</a>';
								$result .= '</h3>';
							$result .= '</div>';
							$result .= '<a href="' . $url . '" class="wtrShtEventListBtn wtrRadius2">';
								$result .= '<i class="fa fa-map-marker"></i>';
							$result .= '</a>';
					$result .= '</li>';
				}
				$result .= '</ul>';
			}
		}
		wp_reset_postdata();
		return $result;
	}//end Render

}//end VCExtendAddonEvents

new VCExtendAddonEvents();