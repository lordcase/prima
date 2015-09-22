<?php
// Don't load directly
if ( !defined('ABSPATH') ) { die('-1'); }

include_once ( 'vc_wtr.php' );

class VCExtendAddonIcon extends VCExtendAddonWtr{

	public $base	= 'vc_wtr_icon';
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
				'param_name'	=> 'circle',
				'heading'		=> __( 'Icon in circle', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'Off', 'wtr_sht_framework' )	=> 'off',
											__( 'On', 'wtr_sht_framework' )		=> 'on',
										),
				'admin_label' 	=> true,
				'class'			=> $this->base . '_circle_class',
			),

			array(
				'param_name'	=> 'circle_style',
				'heading'		=> __( 'Circle style', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'Style 1', 'wtr_sht_framework' )	=> '1',
											__( 'Style 2', 'wtr_sht_framework' )	=> '2',
											__( 'Style 3', 'wtr_sht_framework' )	=> '3',
											__( 'Style 4', 'wtr_sht_framework' )	=> '8',
											__( 'Style 5', 'wtr_sht_framework' )	=> '9',
										),
				'admin_label'	=> false,
				'class'			=> $this->base . '_circle_version_class',
				'dependency'	=> array(	'element'	=> 'circle',
											'value'		=> array( 'on' ) )
			),

			array(
				'param_name'	=> 'version',
				'heading'		=> __( 'Version', 'wtr_sht_framework' ),
				'description'	=> __( 'Enable this option if you want to put this item on the background and make it
										more attractive', 'wtr_sht_framework' ),
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'Standard', 'wtr_sht_framework' )	=> 'wtrShtIcoStandard',
											__( 'Light', 'wtr_sht_framework' )		=> 'wtrShtIcoLight',
										),
				'admin_label'	=> false,
				'class'			=> $this->base . '_version_class',
				'dependency'	=> array(	'element'	=> 'circle',
											'value'		=> array( 'on' ) )
			),

			array(
				'param_name'	=> 'url',
				'heading'		=> __( 'Link', 'wtr_sht_framework' ),
				'description'	=> __( 'Where should your link to?. <b>Optional field</b>', 'wtr_sht_framework' ),
				'type'			=> 'vc_link',
				'value'			=> '',
				'admin_label' 	=> true,
				'class'			=> $this->base . '_url_class',
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
				'param_name'	=> 'color',
				'heading'		=> __( 'Color', 'wtr_sht_framework' ),
				'description'	=> __( 'Specify the color for your icon', 'wtr_sht_framework' ),
				'type'			=> 'colorpicker',
				'value'			=> '#1fce6d',
				'admin_label' 	=> false,
				'class'			=> $this->base . '_color_class',
				'dependency'	=> array(	'element'	=> 'circle',
											'value'		=> array( 'off' ) )
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

			array(
				'param_name'	=> 'size',
				'heading'		=> __( 'Size', 'wtr_sht_framework' ),
				'description'	=> __( 'Specify the size of the selected icon. <b>Please, use only numeric signs</b>', 'wtr_sht_framework' ),
				'type'			=> 'textfield',
				'value'			=> 20,
				'admin_label' 	=> false,
				'class'			=> $this->base . '_size_class',
				'dependency'	=> array(	'element'	=> 'circle',
											'value'		=> array( 'off' ) )
			),

			array(
				'param_name'	=> 'float',
				'heading'		=> __( 'Element float', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'None', 'wtr_sht_framework' )	=> 'none',
											__( 'Left', 'wtr_sht_framework' )	=> 'wtrShtIconFloatLeft',
											__( 'Right', 'wtr_sht_framework' )	=> 'wtrShtIconFloatRight',
										),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_float_class',
			),

			$this->getDefaultVCfield( 'el_class' ),
		);

		// animate attr
		$this->shtAnimateAttrGenerator( $this->fields, true );


		vc_map( array(
			'name'			=> __( 'Icon', 'wtr_sht_framework' ),
			'description'	=> '',
			'base'			=> $this->base,
			'class'			=> $this->base . '_div '. $this->wtrShtMainClass,
			'icon'			=> $this->base . '_icon',
			'controls'		=> 'full',
			'category'		=> $this->groupSht[ 'additional' ],
			'params'		=> $this->fields,
			'weight'		=> 27000,
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

		$target			= ( empty( $target ) ) ? '' : 'target="_blank"';
		$icon			= explode( "|", $type_icon );
		$icon			= ( 2 == count( $icon ) ) ? esc_attr( $icon[1] ) : '';
		$url			= esc_url( $url );

		$icon				= explode( "|", $type_icon );
		$float_style		= ( 'none' != $float ) ? $float : '' ;


		if( 'on' == $circle ){
			$align_style	= ( 'none' != $align ) ? 'style="text-align:' . esc_attr( $align ) . ';"' :'';
			$class_circle	= 'hi-icon-effect-' . intval( $circle_style ) . ' hi-icon-effect-' . intval( $circle_style ) . 'a';

			$class_html_attr = $float_style . ' ' . $el_class  . ' ' . $version ;

			$result .= '<div ' . $this->shtAnimateHTML( $class_html_attr, $atts ) . '>';
				$result .= '<div class="hi-icon-wrap ' . $class_circle . '" ' . $align_style . '>';

					if( ! empty( $url ) ){
						$result .= '<a href="' . $url . '" ' . $target . ' class="hi-icon">';
							$result .= '<i class="' . esc_attr( $icon[1] ) . '"></i>';
						$result .= '</a>';
					}else{
						$result .= '<span class="hi-icon">';
							$result .= '<i class="' . esc_attr( $icon[1] ) . '"></i>';
						$result .= '</span>';
					}

				$result .= '</div>';
			$result .= '</div>';

		} else {

			if( 'none' != $align ){
				$align_start	= '<p style="text-align:' . esc_attr( $align ) . ';">';
				$align_end		= '</p>';
			}
			else {
				$align_start	= '';
				$align_end		= '';
			}

			$class_html_attr = $icon[1] . ' ' . $el_class . ' ' . $float_style;

			$result .= $align_start;

				if( ! empty( $url ) ){
					$result .= '<a href="' . $url . '" ' . $target . '>';
						$result .= '<i style="color:' . $color .';font-size:' . intval( $size ) .'px;" ' . $this->shtAnimateHTML( $class_html_attr, $atts ) . '></i>';
					$result .= '</a>';
				}else{
					$result .= '<i style="color:' . $color .';font-size:' . intval( $size ) .'px;" ' . $this->shtAnimateHTML( $class_html_attr, $atts ) . '></i>';
				}

			$result .= $align_end;
		}

		return $result;
	}//end Render

}//end VCExtendAddonIcon

new VCExtendAddonIcon();