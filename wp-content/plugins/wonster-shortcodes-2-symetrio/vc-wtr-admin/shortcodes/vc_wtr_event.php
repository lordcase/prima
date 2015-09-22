<?php
// Don't load directly
if ( !defined('ABSPATH') ) { die('-1'); }

if ( !defined( 'WTR_CP_PLUGIN_MAIN_FILE' ) ) { return; }

include_once ( 'vc_wtr.php' );

class VCExtendAddonEvent extends VCExtendAddonWtr{

	public $base	= 'vc_wtr_event';
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
				'heading'		=> __( 'Mode', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'Box left', 'wtr_sht_framework' )	=> 'box_left',
											__( 'Box right', 'wtr_sht_framework' )	=> 'box_right',
										),
				'admin_label' 	=> true,
				'class'			=> $this->base . '_mode_class',
			),

			array(
				'param_name'	=> 'id_event',
				'heading'		=> __( 'Event name', 'wtr_sht_framework' ),
				'description'	=> __( 'Select a event to be attached to content', 'wtr_sht_framework' ),
				'type'			=> 'dropdown',
				'value'			=> $this->getWpQuery( array(
										'post_type'			=> 'events',
										'wtr_add_all_item'	=> false,
										'wtr_select_item'	=> true
									) ),
				'admin_label' 	=> true,
				'class'			=> $this->base . '_id_event_class',
			),

			$this->getDefaultVCfield( 'el_class' ),
		);
		// animate attr
		$this->shtAnimateAttrGenerator( $this->fields, true );

		vc_map( array(
			'name'			=> __( 'Event', 'wtr_sht_framework' ),
			'description'	=> '',
			'base'			=> $this->base,
			'class'			=> $this->base . '_div '. $this->wtrShtMainClass,
			'icon'			=> $this->base . '_icon',
			'controls'		=> 'full',
			'category'		=> $this->groupSht[ 'elements' ],
			'params'		=> $this->fields,
			'weight'		=> 29775,
			)
		);
	}//end integrateWithVC


	public function render( $atts, $content = null ){
		$result	='';
		$atts	= $this->prepareCorrectShortcode( $this->fields, $atts );
		extract($atts);

		if( 'wtr_select_item' == $id_event ){
			return $this->draw_alert_info_wrong_data_id_sht( 'event' );
		}

		global $post_settings;


		$post = get_post( $id_event );
		if( empty( $post ) ){
			return ;
		}

		$title				= get_the_title( $id_event );
		$url				= esc_url( get_the_permalink( $id_event ) );
		$time_start			= get_post_meta( $id_event, '_wtr_event_time_start', true );
		$date				= date_i18n( $post_settings['wtr_EventDateFormat']['all'], $time_start );
		$datetime			= date( 'Y-m-d', $time_start );
		$price				= get_post_meta( $id_event, '_wtr_event_price', true );
		$post_thumbnail_id	= get_post_thumbnail_id( $id_event );
		$image_attributes	= wp_get_attachment_image_src( $post_thumbnail_id, 'size_2' );
		$image_alt			= esc_attr( get_post_meta( $post_thumbnail_id, '_wp_attachment_image_alt', true ) );
		$image				= ( $image_attributes[0] ) ? $image_attributes[0] : $post_settings['wtr_DefalutThumbnail'] ;
		$class_row			= ( 'box_left' == $mode ) ? 'wtrShtOrderChange' : '';
		$class_html_attr	= 'wtrSht wtrOneElementSht wtrShtBoxedEvents ' . $class_row . ' ' . $el_class . ' clearfix';

		$result .= '<div' . $this->shtAnimateHTML( $class_html_attr, $atts ) . '>';
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
		$result .= '</div>';

		wp_reset_postdata();
		return $result;
	}//end Render

}//end VCExtendAddonEvent

new VCExtendAddonEvent();