<?php
// Don't load directly
if ( !defined('ABSPATH') ) { die('-1'); }

include_once ( 'vc_wtr.php' );

class WPBakeryShortCode_Vc_Wtr_Animation extends WPBakeryShortCodesContainer {};

class VCExtendAddonAnimation extends VCExtendAddonWtr{

	public $base	= 'vc_wtr_animation';
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

		parent::__construct();

		$this->fields = array(
			array(
				'param_name'	=> 'alert',
				'heading'		=> '',
				'description'	=> '',
				'type'			=> 'wtr_alert',
				'value'			=> '',
				'wtr_attr'		=> array(
										'message' => __( "<b>Important!</b> Shortcodes in WordPress have limitation which may affect the
														proper functioning of this element.
														<a href='http://codex.wordpress.org/Shortcode_API#Nested_Shortcodes' target='blank'
														style='color:#8a6d3b; font-weight:bold; text-decoration: underline;'>Read more</a>."
														, 'wtr_sht_framework' ),
									),
				'admin_label'	=> false,
				'class'			=> $this->base . '_alert_class',
			),
		);

		// animate attr
		$this->shtAnimateAttrGenerator( $this->fields, false );

		array_push( $this->fields, $this->getDefaultVCfield( 'el_class' ) );

		vc_map( array(
			'name'						=> __( 'Animation Area', 'wtr_sht_framework' ),
			'description'				=> '',
			'base'						=> $this->base,
			'class'						=> $this->base . '_div',
			'icon'						=> $this->base . '_icon',
			'controls'					=> 'full',
			'category'					=> $this->groupSht[ 'additional' ],
			'params'					=> $this->fields,
			'as_parent'					=> array( 'except' => $this->base ),
			'show_settings_on_create'	=> true,
			'content_element' 			=> true,
			'js_view' => 'VcColumnView',
			'weight'		=> 39000,
			)
		);
	}//end integrateWithVC


	public function render( $atts, $content = null ){
		$result				='';
		$atts['content']	= wpb_js_remove_wpautop( $content, false );
		$atts				= $this->prepareCorrectShortcode( $this->fields, $atts );
		extract( $atts );

		$result .= '<div ' . $this->shtAnimateHTML( $el_class, $atts ) . ' >';
			$result .= $content;
		$result .= '</div>';

		return $result;

		return $result;
	}//end Render

}//end VCExtendAddonAnimation

new VCExtendAddonAnimation();