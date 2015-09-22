<?php

// Don't load directly
if ( !defined('ABSPATH') ) { die('-1'); }

include_once ( 'vc_wtr.php' );

class WPBakeryShortCode_Vc_Wtr_Content_Slider extends WPBakeryShortCodesContainer {};
class WPBakeryShortCode_Vc_Wtr_Content_Slider_Item extends WPBakeryShortCodesContainer {};

class VCExtendAddonContentSlider extends VCExtendAddonWtr{

	public $base		= 'vc_wtr_content_slider';
	public $base_child	= 'vc_wtr_content_slider_item';

	public $contener_fields	= array();
	public $item_fields		= array();

	//===FUNCTIONS
	public function __construct(){

		parent::__construct();

		// We safely integrate with VC with this hook
		add_action( 'init', array( &$this, 'integrateWithVC' ) );

		//Creating a shortcode addon
		add_shortcode( $this->base, array( &$this, 'renderContener' ) );
		add_shortcode( $this->base_child, array( &$this, 'renderItem' ) );
	}//end __construct


	public function integrateWithVC(){

		//item fields
		$this->contener_fields = array(

			array(
				'param_name'	=> 'auto',
				'heading'		=> __( 'Auto slide', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'No', 'wtr_sht_framework' )		=> '0',
											__( 'Yes', 'wtr_sht_framework' )	=> '1',
										),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_auto_class',
			),

			array(
				'param_name'	=> 'dots_visibility',
				'heading'		=> __( 'Navigation dots visibility', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'Yes', 'wtr_sht_framework' )	=> 'wtrShtContentSliderShowDots',
											__( 'No', 'wtr_sht_framework' )		=> 'wtrShtContentSliderNoDots',
										),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_dots_visibility_class',
			),

			array(
				'param_name'	=> 'version',
				'heading'		=> __( 'Version', 'wtr_sht_framework' ),
				'description'	=> __( 'Enable this option if you want to put this item on the background and make it
										more attractive', 'wtr_sht_framework' ),
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'Standard', 'wtr_sht_framework' )	=> 'wtrShtContentSliderStandard',
											__( 'Light', 'wtr_sht_framework' )		=> 'wtrShtContentSliderLight',
										),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_version_class',
			),

			array(
				'param_name'	=> 'delay_slide',
				'heading'		=> __( 'Time between slides', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'dropdown',
				'value'			=> array(	__( '1.0 second', 'wtr_sht_framework' )		=> '1000',
											__( '1.5 seconds', 'wtr_sht_framework' )	=> '1500',
											__( '2.0 seconds', 'wtr_sht_framework' )	=> '2000',
											__( '2.5 seconds', 'wtr_sht_framework' )	=> '2500',
											__( '3.0 seconds', 'wtr_sht_framework' )	=> '3000',
											__( '3.5 seconds', 'wtr_sht_framework' )	=> '3500',
											__( '4.0 seconds', 'wtr_sht_framework' )	=> '4000',
											__( '4.5 seconds', 'wtr_sht_framework' )	=> '4500',
											__( '5.0 seconds', 'wtr_sht_framework' )	=> '5000',
											__( '5.5 seconds', 'wtr_sht_framework' )	=> '5500',
											__( '6.0 seconds', 'wtr_sht_framework' )	=> '6000',
											__( '6.5 seconds', 'wtr_sht_framework' )	=> '6500',
											__( '7.0 seconds', 'wtr_sht_framework' )	=> '7000',
											__( '7.5 seconds', 'wtr_sht_framework' )	=> '7500',
											__( '8.0 seconds', 'wtr_sht_framework' )	=> '8000',
											__( '8.5 seconds', 'wtr_sht_framework' )	=> '8500',
											__( '9.0 seconds', 'wtr_sht_framework' )	=> '9000',
											__( '9.5 seconds', 'wtr_sht_framework' )	=> '9500',
											__( '10.0 seconds', 'wtr_sht_framework' )	=> '10000',
										),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_delay_slide_class',
				'dependency' 	=> array(	'element'	=> 'auto',
											'value'		=> array( '1' ) )
			),
		);

		array_push($this->contener_fields, $this->getDefaultVCfield( 'el_class' ) );

		// animate attr
		$this->shtAnimateAttrGenerator( $this->contener_fields, true );

			vc_map( array(
				'name'						=> __( 'Content Slider', 'wtr_sht_framework' ),
				'description'				=> '',
				'base'						=> $this->base,
				'class'						=> $this->base . '_div',
				'icon'						=> $this->base . '_icon',
				'controls'					=> 'full',
				'category'					=> $this->groupSht[ 'elements' ],
				'params'					=> $this->contener_fields,
				'show_settings_on_create'	=> true,
				'content_element'			=> true,
				'as_parent'					=> array( 'only' => $this->base_child  ),
				'js_view'					=> 'VcColumnView',
				'weight'					=> 34000,
				)
			);

		//item fields
		array_push($this->item_fields, $this->getDefaultVCfield( 'el_class' ) );

			//custom list - item
			vc_map( array(
				'name'						=> __( 'Content Slider - Slide', 'wtr_sht_framework' ),
				'description'				=> '',
				'base'						=> $this->base_child,
				'class'						=> $this->base_child . '_div',
				'icon'						=> $this->base_child . '_icon',
				'controls'					=> 'full',
				'category'					=> $this->groupSht[ 'elements' ],
				'params'					=> $this->item_fields,
				'show_settings_on_create'	=> false,
				'content_element'			=> true,
				'as_parent'					=> array(	'except' => $this->base . ',' . $this->base_child . ',' .
														'vc_wtr_google_maps_marker,
														vc_wtr_google_maps_road,
														vc_wtr_google_maps_contener,
														vc_wtr_step_by_step_item,
														vc_wtr_wonster_slider_item,
														vc_wtr_custom_list_item' ),
				'js_view'					=> 'VcColumnView',
				'as_child'					=> array('only' => $this->base ),
				)
			);
	}//end integrateWithVC


	public function renderContener( $atts, $content = null ){
		$result				='';
		$atts['content']	= wpb_js_remove_wpautop( $content, false );
		$atts				= $this->prepareCorrectShortcode( $this->contener_fields, $atts );
		extract( $atts );

		$class_html_attr = 'wtrSht wtrShtContentSlider ' . $version . ' ' . $el_class . ' ' . $dots_visibility;

		$result .= '<div' . $this->shtAnimateHTML( $class_html_attr, $atts ) . ' >';
			$result .= '<div  data-autoplay="' . esc_attr( $auto ) . '" data-interval="' . esc_attr( $delay_slide ) . '" class="wtrContentSlider">';
				$result .= $content ;
			$result .= '</div>';
		$result .= '</div>';

		return $result;
	}//end Render


	public function renderItem( $atts, $content = null ){
		$result				='';
		$atts['content']	= wpb_js_remove_wpautop( $content, false );
		$atts				= $this->prepareCorrectShortcode( $this->contener_fields, $atts );
		extract( $atts );
		$result .= '<div class="' . esc_attr( $el_class ) . '">';
			$result .= '<div class="wtrContentSliderElement">';
				$result .= $content ;
			$result .= '</div>';
		$result .= '</div>';

		return $result;
	}//end Render

}//end VCExtendAddonContentSlider

new VCExtendAddonContentSlider();