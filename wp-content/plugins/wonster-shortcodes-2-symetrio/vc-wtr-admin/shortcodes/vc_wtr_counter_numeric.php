<?php
// Don't load directly
if ( !defined('ABSPATH') ) { die('-1'); }

include_once ( 'vc_wtr.php' );

class VCExtendAddonCounterNumeric extends VCExtendAddonWtr{

	public $base	= 'vc_wtr_counter_numeric';
	public $fields	= array();

	private static $countElem = 0;

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
				'param_name'	=> 'version',
				'heading'		=> __( 'Version', 'wtr_sht_framework' ),
				'description'	=> __( 'Enable this option if you want to put this item on the background and make it
										more attractive', 'wtr_sht_framework' ),
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'Standard', 'wtr_sht_framework' )	=> 'wtrShtCounterStandard',
											__( 'Light', 'wtr_sht_framework' )		=> 'wtrShtCounterLight',
										),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_version_class',
			),

			array(
				'param_name'	=> 'easing',
				'heading'		=> __( 'Easing effect', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'No', 'wtr_sht_framework' )		=> 'false',
											__( 'Yes', 'wtr_sht_framework' )	=> 'true',
										),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_easing_class',
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
				'heading'		=> __( 'Counting time - from the start to the end', 'wtr_sht_framework' ),
				'description'	=> 'For example: <b>1</b> second delay is <b>1000</b> milliseconds. <b>Please, use only numeric signs</b>',
				'type'			=> 'textfield',
				'value'			=> 10,
				'admin_label' 	=> true,
				'class'			=> $this->base . '_speed_class',
			),

			array(
				'param_name'	=> 'color_font',
				'heading'		=> __( 'Counter color', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'colorpicker',
				'value'			=> '#1fce6d',
				'admin_label' 	=> false,
				'class'			=> $this->base . '_color_font_class',
				'dependency' 	=> array(	'element'	=> 'version',
											'value'		=> array( 'standard' ) )
			),

			array(
				'param_name'	=> 'color_border',
				'heading'		=> __( 'Counter border', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'colorpicker',
				'value'			=> '#e5e5e5',
				'admin_label' 	=> false,
				'class'			=> $this->base . '_color_border_class',
				'dependency' 	=> array(	'element'	=> 'version',
											'value'		=> array( 'standard' ) )
			),

			$this->getDefaultVCfield( 'el_class' ),
		);

		vc_map( array(
			'name'			=> __( 'Counter Numeric', 'wtr_sht_framework' ),
			'description'	=> '',
			'base'			=> $this->base,
			'class'			=> $this->base . '_div '. $this->wtrShtMainClass,
			'icon'			=> $this->base . '_icon',
			'controls'		=> 'full',
			'category'		=> $this->groupSht[ 'additional' ],
			'params'		=> $this->fields,
			'weight'		=> 32000,
			)
		);
	}//end integrateWithVC


	public function render( $atts, $content = null ){
		$result	='';
		$atts	= $this->prepareCorrectShortcode( $this->fields, $atts );
		extract($atts);

		$result .= '<div class="wtrSht wtrShtCounter '. esc_attr( $version ) . ' ' . esc_attr( $el_class ) . '">';
			$result .= '<div id="wtrCounterItem-' . ( self::$countElem++ ) . '" data-duration="' . intval( $speed ) . '" data-value="' . intval( $value ) . '"  data-easing="' . esc_attr( $easing ) . '" class="wtrCounterItem">1</div>';
		$result .= '</div>';

		return $result;
	}//end Render

}//end VCExtendAddonCounterNumeric

new VCExtendAddonCounterNumeric();