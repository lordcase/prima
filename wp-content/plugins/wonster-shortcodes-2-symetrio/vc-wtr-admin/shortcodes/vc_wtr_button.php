<?php
// Don't load directly
if ( !defined('ABSPATH') ) { die('-1'); }

include_once ( 'vc_wtr.php' );

class VCExtendAddonButton extends VCExtendAddonWtr{

	public $base	= 'vc_wtr_button';
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
				'param_name'	=> 'url',
				'heading'		=> __( 'Button link', 'wtr_sht_framework' ),
				'description'	=> __( 'Where should your button link to?', 'wtr_sht_framework' ),
				'type'			=> 'vc_link',
				'value'			=> '',
				'admin_label' 	=> true,
				'class'			=> $this->base . '_url_class',
			),

			array(
				'param_name'	=> 'label',
				'heading'		=> __( 'Button label', 'wtr_sht_framework' ),
				'description'	=> __( 'Where should your button link to?', 'wtr_sht_framework' ),
				'type'			=> 'textfield',
				'value'			=> __( 'Click me', 'wtr_sht_framework' ),
				'admin_label' 	=> true,
				'class'			=> $this->base . '_label_class',
			),

			array(
				'param_name'	=> 'align',
				'heading'		=> __( 'Element alignment', 'wtr_sht_framework' ),
				'description'	=> __( 'Specify the alignment for your button', 'wtr_sht_framework' ),
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
				'param_name'	=> 'size',
				'heading'		=> __( 'Size', 'wtr_sht_framework' ),
				'description'	=> __( 'Specify the size for your button', 'wtr_sht_framework' ),
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'Normal', 'wtr_sht_framework' )	=> 'normal',
											__( 'Big', 'wtr_sht_framework' )	=> 'big'
										),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_size_class',
			),

			array(
				'param_name'	=> 'color',
				'heading'		=> __( 'Color', 'wtr_sht_framework' ),
				'description'	=> __( 'Specify the color for your button', 'wtr_sht_framework' ),
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'Green', 'wtr_sht_framework' )		=> 'c_green',
											__( 'Blue', 'wtr_sht_framework' )		=> 'c_blue',
											__( 'Navy', 'wtr_sht_framework' )		=> 'c_navy',
											__( 'Turquoise', 'wtr_sht_framework' )	=> 'c_turquoise',
											__( 'Yellow', 'wtr_sht_framework' )		=> 'c_yellow',
											__( 'Orange', 'wtr_sht_framework' )		=> 'c_orange',
											__( 'Red', 'wtr_sht_framework' )		=> 'c_red',
											__( 'Purple', 'wtr_sht_framework' )		=> 'c_purple',
											__( 'Gray', 'wtr_sht_framework' )		=> 'c_gray',
											__( 'Dark Gray', 'wtr_sht_framework' )	=> 'c_darkGrey',
											__( 'White', 'wtr_sht_framework' )		=> 'c_white',
											__( 'Black', 'wtr_sht_framework' )		=> 'c_black',
										),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_color_class',
			),

			array(
				'param_name'		=> 'corner',
				'heading'			=> __( 'Button with rounded corners', 'wtr_sht_framework' ),
				'description'		=> '',
				'type'				=> 'dropdown',
				'value'				=> array(	__( 'Yes', 'wtr_sht_framework' )	=> 'wtrButtonRad',
												__( 'No', 'wtr_sht_framework' )		=> 'wtrButtonNoRad'
										),
				'admin_label'		=> false,
				'class'				=> $this->base . '_corner_class',
			),

			array(
				'param_name'	=> 'background',
				'heading'		=> __( 'Button type', 'wtr_sht_framework' ),
				'description'	=> __( 'Specify the type of your button', 'wtr_sht_framework' ),
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'Button filled with color', 'wtr_sht_framework' )			=> 'wtrButtonNoTrans',
											__( 'Button with transparent background', 'wtr_sht_framework' )	=> 'wtrButtonTrans'
										),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_background_class',
			),

			array(
				'param_name'	=> 'animate_icon',
				'heading'		=> __( 'Button style', 'wtr_sht_framework' ),
				'description'	=> __( 'Define hover action', 'wtr_sht_framework' ),
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'Animated with icon', 'wtr_sht_framework' )			=> 'wtrButtonHoverAnim',
											__( 'Standard with background', 'wtr_sht_framework' )	=> 'wtrButtonHoverNoAnim'
										),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_animated_icon_class',
			),

			array(
				'param_name'	=> 'full_width',
				'heading'		=> __( 'Full width button', 'wtr_sht_framework' ),
				'description'	=> __( 'Decide, does the button fill the entire space in a column', 'wtr_sht_framework' ),
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'Off', 'wtr_sht_framework' )	=> 'wtrButtonNoFullWidth',
											__( 'On', 'wtr_sht_framework' )		=> 'wtrButtonFullWidth'
										),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_align_class',
			),

			$this->getDefaultVCfield( 'el_class' ),
		);

		// margin attr
		$this->shtVCMarginAttrGenerator( $this->fields, array( 'left', 'right', 'top', 'bottom' ) );

		// animate attr
		$this->shtAnimateAttrGenerator( $this->fields, true );


		vc_map( array(
			'name'			=> __( 'Button', 'wtr_sht_framework' ),
			'description'	=> '',
			'base'			=> $this->base,
			'class'			=> $this->base . '_div '. $this->wtrShtMainClass,
			'icon'			=> $this->base . '_icon',
			'controls'		=> 'full',
			'category'		=> $this->groupSht[ 'elements' ],
			'params'		=> $this->fields,
			'weight'		=> 38000,
			)
		);
	}//end integrateWithVC


	public function render( $atts, $content = null ){
		$result	='';
		$atts	= $this->prepareCorrectShortcode( $this->fields, $atts );
		extract( $atts );

		$url_str	= ( ( 0 == substr_count( $url, '|' ) ) AND isset( $target ) ) ? $url . '|target:'. esc_attr( $target ) : $url;
		$url_str	= str_replace("|", "&", $url_str );
		$url_str	= str_replace(":", "=", $url_str );
		parse_str( $url_str, $url_attr );

		extract(shortcode_atts(array(
			'url'		=> '',
			'target'	=> '',
		), $url_attr) );

		$class_color	= substr( $color, 2 );
		$target			= ( empty( $target ) ) ? '' : 'target="_blank"';
		$align_start	= '';
		$align_end		= '';

		if( 'none' != $align ){
			$align_start = '<p style="text-align:' . esc_attr( $align ) . ';">';
			$align_end 	 = '</p>';
		}

		$class_html_attr = 'wtrButtonStd ' . $corner . ' ' . $el_class . ' ' . $full_width . ' ' . $background . ' ' . $size . ' ' . $class_color . ' wtrButtonAnim ' . $animate_icon;

		$result .= $align_start;
		$result .= '<a ' . $target .  ' style="margin:' . intval( $margin_top ) . 'px ' . intval( $margin_right ) . 'px ' . intval( $margin_bottom ) . 'px ' . intval( $margin_left ) . 'px;" ' . $this->shtAnimateHTML( $class_html_attr, $atts ) . ' href="' . esc_url( $url ) . '">' . $label . '</a>';
		$result .= $align_end;

		return $result;
	}//end Render

}//end VCExtendAddonButton

new VCExtendAddonButton();