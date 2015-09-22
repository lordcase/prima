<?php

// Don't load directly
if ( !defined('ABSPATH') ) { die('-1'); }

include_once ( 'vc_wtr.php' );

class WPBakeryShortCode_Vc_Wtr_Custom_List extends WPBakeryShortCodesContainer {};
class WPBakeryShortCode_Vc_Wtr_Custom_List_Item extends WPBakeryShortCode {};

class VCExtendAddonCustomList extends VCExtendAddonWtr{

	public $base		= 'vc_wtr_custom_list';
	public $base_child	= 'vc_wtr_custom_list_item';

	public $contener_fields	= array();
	public $fields_item		= array();

	//===FUNCTIONS
	public function __construct(){

		parent::__construct();
		self::$sht_list[] = $this->base;
		self::$sht_list[] = $this->base_child;
		// We safely integrate with VC with this hook
		add_action( 'init', array( &$this, 'integrateWithVC' ) );

		//Creating a shortcode addon
		add_shortcode( $this->base, array( &$this, 'renderContener' ) );
		add_shortcode( $this->base_child, array( &$this, 'renderItem' ) );
	}//end __construct


	public function integrateWithVC(){

		// animate attr
		$this->shtAnimateAttrGenerator( $this->contener_fields, false );

		array_push($this->contener_fields, $this->getDefaultVCfield( 'el_class' ) );

			//custom list
			vc_map( array(
				'name'						=> __( 'Custom List', 'wtr_sht_framework' ),
				'description'				=> '',
				'base'						=> $this->base,
				'class'						=> $this->base . '_div',
				'icon'						=> $this->base . '_icon',
				'controls'					=> 'full',
				'category'					=> $this->groupSht[ 'additional' ],
				'params'					=> $this->contener_fields,
				'show_settings_on_create'	=> true,
				'content_element'			=> true,
				'as_parent'					=> array( 'only' => $this->base_child  ),
				'js_view'					=> 'VcColumnView',
				'weight'		=> 31000,
				)
			);


		$this->fields_item = array(

			array(
				'param_name'	=> 'color_icon',
				'heading'		=> __( 'Icon color', 'wtr_sht_framework' ),
				'description'	=> __( 'Specify the color for your icon', 'wtr_sht_framework' ),
				'type'			=> 'colorpicker',
				'value'			=> '#ffffff',
				'admin_label' 	=> false,
				'class'			=> $this->base . '_color_icon_class',
			),

			array(
				'param_name'	=> 'color_background',
				'heading'		=> __( 'Background color', 'wtr_sht_framework' ),
				'description'	=> __( 'Specify the color for your icon', 'wtr_sht_framework' ),
				'type'			=> 'colorpicker',
				'value'			=> '#1fce6d',
				'admin_label' 	=> false,
				'class'			=> $this->base . '_color_background_class',
			),

			array(
				'param_name'	=> 'type_icon',
				'heading'		=> __( 'Icon', 'wtr_sht_framework' ),
				'description'	=> __( 'Select the icon set', 'wtr_sht_framework' ),
				'type'			=> 'wtr_icons_set',
				'value'			=> 'web|fa fa-check-square', // group | icon
				'admin_label' 	=> true,
				'class'			=> $this->base . '_type_icon_class',
			),

			array(
				'param_name'	=> 'content',
				'heading'		=> __( 'Content', 'wtr_sht_framework' ),
				'description'	=> __( 'the contents of the container', 'wtr_sht_framework' ),
				'type'			=> 'textarea_html',
				'value'			=> __( 'Please insert code here', 'wtr_sht_framework' ),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_data_content_class',
			),
		);

			//custom list - item
			vc_map( array(
				'name'						=> __( 'Custom List - Item', 'wtr_sht_framework' ),
				'description'				=> '',
				'base'						=> $this->base_child,
				'class'						=> $this->base_child . '_div ' . $this->wtrShtMainClass,
				'icon'						=> $this->base_child . '_icon',
				'controls'					=> 'full',
				'category'					=> $this->groupSht[ 'elements' ],
				'params'					=> $this->fields_item,
				'show_settings_on_create'	=> true,
				'content_element'			=> true,
				'as_child'					=> array('only' => $this->base ),
				'weight'					=> 23000,
				)
			);
	}//end integrateWithVC


	public function renderContener( $atts, $content = null ){
		$result				='';
		$atts['content']	= wpb_js_remove_wpautop( $content, false );
		$atts				= $this->prepareCorrectShortcode( $this->contener_fields, $atts );
		extract( $atts );

		$class_html_attr = 'wtrCustomList ' . $el_class;
		$result .= '<div' . $this->shtAnimateHTML( $class_html_attr, $atts ) . ' >';
			$result .= '<ul class="wtrCustomListItem ">';
				$result .= $content ;
			$result .= '</ul>';
		$result .= '</div>';

		return $result;
	}//end Render


	public function renderItem( $atts, $content = null ){
		$result				='';
		$atts['content']	= wpb_js_remove_wpautop( $content, WPBMap::getTagsRegexp() );
		$atts				= $this->prepareCorrectShortcode( $this->fields_item, $atts );
		extract( $atts );

		$icon				= explode( "|", $type_icon );
		$icon				= ( 2 == count( $icon ) ) ? esc_attr( $icon[1] ) : '';
		$style_background	= 'style="background-color:' . esc_attr( $color_background ) . ';"';
		$style_iscon		= 'style="color:' . esc_attr( $color_icon ) . ';"';

		$result .='<li class="clearfix">';
			$result .='<div class="wtrCustomListItemIcon" ' . $style_background . ' ><i ' . $style_iscon . ' class="' . $icon . '"></i></div>';
			$result .='<div class="wtrCustomListItemName">' . $content . '</div>';
		$result .='</li>';

		return $result;
	}//end Render

}//end VCExtendAddonCustomList

new VCExtendAddonCustomList();