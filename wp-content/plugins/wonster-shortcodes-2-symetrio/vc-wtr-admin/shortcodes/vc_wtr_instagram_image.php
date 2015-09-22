<?php
// Don't load directly
if ( !defined('ABSPATH') ) { die('-1'); }

include_once ( 'vc_wtr.php' );

class VCExtendAddonInstagramImage extends VCExtendAddonWtr{

	public $base	= 'vc_wtr_instagram_image';
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
				'param_name'	=> 'image_id',
				'heading'		=> __( 'Image ID', 'wtr_sht_framework' ),
				'description'	=> __( 'eg. <b>r83mWeIhwH</b> from http://instagram.com/p/<b>r83mWeIhwH</b>/', 'wtr_sht_framework' ),
				'type'			=> 'textfield',
				'value'			=> '',
				'admin_label' 	=> true,
				'class'			=> $this->base . '_image_id_class',
			),

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

			$this->getDefaultVCfield( 'el_class' ),
		);

		vc_map( array(
			'name'			=> __( 'Instagram Image', 'wtr_sht_framework' ),
			'description'	=> '',
			'base'			=> $this->base,
			'class'			=> $this->base . '_div '. $this->wtrShtMainClass,
			'icon'			=> $this->base . '_icon',
			'controls'		=> 'full',
			'category'		=> $this->groupSht[ 'media' ],
			'params'		=> $this->fields,
			'weight'		=> 25750,
			)
		);
	}//end integrateWithVC


	public function render( $atts, $content = null ){
		$result	='';
		$atts	= $this->prepareCorrectShortcode( $this->fields, $atts );
		extract( $atts );

		if( 'none' != $align ){
			$style_attr = ' style="text-align:' . esc_attr( $align ) . ';" ';
		}else{
			$style_attr = '';
		}

		$result .= '<div'. $style_attr .' class="wtrShtInstagramPhoto ' . esc_attr( $el_class ) . '">';
			$result .= '<iframe src="//instagram.com/p/' . esc_attr( $image_id ) . '/embed/" width="612" height="710"></iframe>';
		$result .= '</div>';

		return $result;
	}//end Render

}//end VCExtendAddonInstagramImage

new VCExtendAddonInstagramImage();