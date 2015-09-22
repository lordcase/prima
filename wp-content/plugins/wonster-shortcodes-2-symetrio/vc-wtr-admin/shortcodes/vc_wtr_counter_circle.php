<?php
// Don't load directly
if ( !defined('ABSPATH') ) { die('-1'); }

include_once ( 'vc_wtr.php' );

class VCExtendAddonCounterCircle extends VCExtendAddonWtr{

	public $base	= 'vc_wtr_counter_circle';
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
				'param_name'	=> 'align',
				'heading'		=> __( 'Element alignment', 'wtr_sht_framework' ),
				'description'	=> __( 'Specify the alignment for your element', 'wtr_sht_framework' ),
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'None', 'wtr_sht_framework' )	=> 'none',
											__( 'Left', 'wtr_sht_framework' )	=> 'left',
											__( 'Right', 'wtr_sht_framework' )	=> 'right',
											__( 'Center', 'wtr_sht_framework' )	=> 'center'
										),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_align_class',
			),

			array(
				'param_name'	=> 'value',
				'heading'		=> __( 'Value', 'wtr_sht_framework' ),
				'description'	=> __( 'Final value. <b>Please, use only numeric signs</b>', 'wtr_sht_framework' ),
				'type'			=> 'textfield',
				'value'			=> 100,
				'admin_label' 	=> true,
				'class'			=> $this->base . '_value_class',
			),

			array(
				'param_name'	=> 'speed',
				'heading'		=> __( 'Counting Speed', 'wtr_sht_framework' ),
				'description'	=> 'Miliseconds between animation cycles, lower value is faster. Please, use only numeric signs</b>',
				'type'			=> 'textfield',
				'value'			=> 10,
				'admin_label' 	=> true,
				'class'			=> $this->base . '_speed_class',
			),

			array(
				'param_name'	=> 'color_active',
				'heading'		=> __( 'Active counting color', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'colorpicker',
				'value'			=> '#1fce6d',
				'admin_label' 	=> false,
				'class'			=> $this->base . '_color_active_class',
			),

			array(
				'param_name'	=> 'weight',
				'heading'		=> __( 'Line weight', 'wtr_sht_framework' ),
				'description'	=> __( 'Final value. <b>Please, use only numeric signs</b>', 'wtr_sht_framework' ),
				'type'			=> 'textfield',
				'value'			=> 13,
				'admin_label' 	=> false,
				'class'			=> $this->base . '_weight_class',
			),


			array(
				'param_name'	=> 'color_bg',
				'heading'		=> __( 'Counting color', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'colorpicker',
				'value'			=> '#238250',
				'admin_label' 	=> false,
				'class'			=> $this->base . '_color_bg_class',
			),

			array(
				'param_name'	=> 'color_font',
				'heading'		=> __( 'Font color', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'colorpicker',
				'value'			=> '#000000',
				'admin_label' 	=> false,
				'class'			=> $this->base . '_color_font_class',
			),

			$this->getDefaultVCfield( 'el_class' ),
		);

		vc_map( array(
			'name'			=> __( 'Counter Circle', 'wtr_sht_framework' ),
			'description'	=> '',
			'base'			=> $this->base,
			'class'			=> $this->base . '_div '. $this->wtrShtMainClass,
			'icon'			=> $this->base . '_icon',
			'controls'		=> 'full',
			'category'		=> $this->groupSht[ 'additional' ],
			'params'		=> $this->fields,
			'weight'		=> 33000,
			)
		);
	}//end integrateWithVC


	public function render( $atts, $content = null ){
		$result			='';
		$atts			= $this->prepareCorrectShortcode( $this->fields, $atts );
		$align_style	= '';

		extract($atts);

		if( 'none' != $align ){
			$align_style = ' style="text-align:' . esc_attr( $align ) . ';"';
		}

		$result .= '<div class="' . esc_attr( $el_class ) . ' wtrShtCircleCounterArea"' . $align_style . '>';
			$result .= '<canvas data-weight="' . intval( $weight ) . '" data-value="' . intval( $value ) . '" data-speed="' . intval( $speed ) . '" data-active-color="' . esc_attr(  $color_active ) . '" data-color="' . esc_attr( $color_bg ) . '" data-font-color="' . esc_attr( $color_font ) . '" class="wtrShtCircleCounter  loader"></canvas>';
		$result .= '</div>';

		return $result;
	}//end Render

}//end VCExtendAddonCounterCircle

new VCExtendAddonCounterCircle();