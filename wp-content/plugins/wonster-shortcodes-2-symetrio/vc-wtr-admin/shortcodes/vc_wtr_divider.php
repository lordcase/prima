<?php
// Don't load directly
if ( !defined('ABSPATH') ) { die('-1'); }

include_once ( 'vc_wtr.php' );

class VCExtendAddonDivider extends VCExtendAddonWtr{

	public $base	= 'vc_wtr_divider';
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
				'param_name'	=> 'type',
				'heading'		=> __( 'Divider style', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'Invisible', 'wtr_sht_framework' )	=> 'invisible',
											__( 'Line', 'wtr_sht_framework' )		=> 'line',
											__( 'Dots', 'wtr_sht_framework' )		=> 'dots',
											__( 'Dashed', 'wtr_sht_framework' )		=> 'dashed',
											__( 'Peaks', 'wtr_sht_framework' )		=> 'peaks',
											__( 'Icon', 'wtr_sht_framework' )		=> 'icon',
									),
				'admin_label' 	=> true,
				'class'			=> $this->base . '_type_class',
			),

			array(
				'param_name'	=> 'divider_align',
				'heading'		=> __( 'Element alignment', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'Left', 'wtr_sht_framework' )	=> 'left',
											__( 'Center', 'wtr_sht_framework' )	=> 'center',
											__( 'Right', 'wtr_sht_framework' )	=> 'right',
									),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_divider_align_class',
				'dependency' 	=> array(	'element'	=> 'type',
											'value'		=> array( 'line', 'dots', 'dashed', 'peaks', 'icon' ) )
			),

			array(
				'param_name'	=> 'height',
				'heading'		=> __( 'Height', 'wtr_sht_framework' ),
				'description'	=> __( 'Value must be a number', 'wtr_sht_framework' ),
				'type'			=> 'textfield',
				'value'			=> 10,
				'admin_label' 	=> false,
				'class'			=> $this->base . '_height_class',
				'dependency' 	=> array(	'element'	=> 'type',
											'value'		=> array( 'invisible', 'line' ) )
			),

			array(
				'param_name'	=> 'width_p',
				'heading'		=> __( 'Width (expressed as a percentage)', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'dropdown',
				'value'			=> array(	__( '100 %', 'wtr_sht_framework' )	=> '100',
											__( '90 %', 'wtr_sht_framework' )	=> '90',
											__( '80 %', 'wtr_sht_framework' )	=> '80',
											__( '70 %', 'wtr_sht_framework' )	=> '70',
											__( '60 %', 'wtr_sht_framework' )	=> '60',
											__( '50 %', 'wtr_sht_framework' )	=> '50',
											__( '40 %', 'wtr_sht_framework' )	=> '40',
											__( '30 %', 'wtr_sht_framework' )	=> '30',
											__( '20 %', 'wtr_sht_framework' )	=> '20',
											__( '10 %', 'wtr_sht_framework' )	=> '10',

									),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_width_p_class',
				'dependency' 	=> array(	'element'	=> 'type',
											'value'		=> array( 'line', 'icon' ) )
			),

			array(
				'param_name'	=> 'width_q',
				'heading'		=> __( 'Width (expressed as a quantitatively)', 'wtr_sht_framework' ),
				'description'	=> __( 'Value must be a number eg.  10', 'wtr_sht_framework' ),
				'type'			=> 'textfield',
				'value'			=> 10,
				'admin_label' 	=> false,
				'class'			=> $this->base . '_width_q_class',
				'dependency' 	=> array(	'element'	=> 'type',
											'value'		=> array( 'dots', 'dashed', 'peaks' ) )
			),

			array(
				'param_name'	=> 'color_line',
				'heading'		=> __( 'Line color', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'colorpicker',
				'value'			=> '#e5e5e5',
				'admin_label' 	=> false,
				'class'			=> $this->base . '_color_line_class',
				'dependency' 	=> array(	'element'	=> 'type',
											'value'		=> array( 'line', 'icon' ) )
			),

			array(
				'param_name'	=> 'color_element',
				'heading'		=> __( 'Element color', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'colorpicker',
				'value'			=> '#1fce6d',
				'admin_label' 	=> false,
				'class'			=> $this->base . '_color_element_class',
				'dependency' 	=> array(	'element'	=> 'type',
											'value'		=> array( 'dots', 'dashed', 'peaks' ) )
			),

			array(
				'param_name'	=> 'color_icon',
				'heading'		=> __( 'Icon color', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'colorpicker',
				'value'			=> '#1fce6d',
				'admin_label' 	=> false,
				'class'			=> $this->base . '_color_icon_class',
				'dependency' 	=> array(	'element'	=> 'type',
											'value'		=> array( 'icon' ) )
			),

			array(
				'param_name'	=> 'icon_align',
				'heading'		=> __( 'Icon alignment', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'Left', 'wtr_sht_framework' )	=> 'left',
											__( 'Center', 'wtr_sht_framework' )	=> 'center',
											__( 'Right', 'wtr_sht_framework' )	=> 'right',
									),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_icon_align_class',
				'dependency' 	=> array(	'element'	=> 'type',
											'value'		=> array( 'icon' ) )
			),

			array(
				'param_name'	=> 'icon',
				'heading'		=> __( 'Icon', 'wtr_sht_framework' ),
				'description'	=> __( 'Select the icon set', 'wtr_sht_framework' ),
				'type'			=> 'wtr_icons_set',
				'value'			=> 'web|fa fa-check', // group | icon
				'admin_label' 	=> false,
				'class'			=> $this->base . '_icon_class',
				'dependency' => array(	'element'	=> 'type',
										'value'		=> array( 'icon' ) )
			),

			$this->getDefaultVCfield( 'el_class' ),
		);

		// animate attr
		$this->shtAnimateAttrGenerator( $this->fields, true );

		vc_map( array(
			'name'			=> __( 'Divider', 'wtr_sht_framework' ),
			'description'	=> '',
			'base'			=> $this->base,
			'class'			=> $this->base . '_div '. $this->wtrShtMainClass,
			'icon'			=> $this->base . '_icon',
			'controls'		=> 'full',
			'category'		=> $this->groupSht[ 'elements' ],
			'params'		=> $this->fields,
			'weight'		=> 30000,
			)
		);
	}//end integrateWithVC


	public function render( $atts, $content = null ){
		$result	='';
		$atts	= $this->prepareCorrectShortcode( $this->fields, $atts );
		extract($atts);

		switch ( $type ) {

			case 'invisible':
			default:
				$container			= 'hr';
				$class				= 'wtrHrDivider';
				$style				= 'height:' . intval( $height ) . 'px;';
				$divider_align		= '';
			break;

			case 'line':
				$container			= 'hr';
				$class				= 'wtrHrDivider';
				$style				= 'width:' . intval( $width_p ) . '%;height:' . intval( $height ) . 'px; background:' . esc_attr( $color_line ) . ';color:' . esc_attr( $color_line ) . ';';
			break;

			case 'dots':
				$container			= 'div';
				$class				= 'wtrDotsDivider';
				$divider_content	= str_repeat( '<span style="background:' . esc_attr( $color_element ) . ';color:' . esc_attr( $color_element ) . ';"></span>', intval( $width_q ) );
			break;

			case 'dashed':
				$container			= 'div';
				$class				= 'wtrDashedDivider';
				$divider_content	= str_repeat( '<span style="background:' . esc_attr( $color_element ) . ';color:' . esc_attr( $color_element ) . ';"></span>', intval( $width_q ) );
			break;

			case 'peaks':
				$container			= 'div';
				$class				= 'wtrPeaksDivider';
				$divider_content	= str_repeat( '<i class="fa fa-chevron-down" style="color:' . esc_attr( $color_element ) . ';"></i>' . "\n", intval( $width_q ) );
			break;

			case 'icon':
				$container			= 'div';
				$class				= 'wtrIconDivider';
				$style				= 'width:' . intval( $width_p ) . '%;border-color:' . esc_attr( $color_line ) . ';';
				$icon_ements		= explode("|", $icon );
				$icon_ements		= ( 2 == count( $icon_ements ) ) ? esc_attr( $icon_ements[1] ) : '';
				$divider_content	= '<span class="wtrIconDividerStyle ' . esc_attr( $icon_align ) . '" style="color:' . esc_attr( $color_icon ) . ';" >';
				$divider_content	.= '<span class="wtrIconDividerIco"><i class="' . $icon_ements . '"></i></span>';
				$divider_content	.= '</span>';
			break;
		}

		$style	=( ! empty( $style ) ) ? 'style="' . $style . '"' : '';

		if( 'hr' == $container ) {
			$class_html_attr = $class . ' ' . $divider_align;
			$result	.='<hr ' . $this->shtAnimateHTML( $class_html_attr, $atts ) . ' ' . $style . ' >';
		} else {
			$class_html_attr = $class . ' ' . $divider_align;
			$result	.='<div ' . $this->shtAnimateHTML( $class_html_attr, $atts ) . ' ' . $style . ' >';
				$result .= $divider_content;
			$result	.='</div>';
		}

		return $result;
	}//end Render

}//end VCExtendAddonDivider

new VCExtendAddonDivider();