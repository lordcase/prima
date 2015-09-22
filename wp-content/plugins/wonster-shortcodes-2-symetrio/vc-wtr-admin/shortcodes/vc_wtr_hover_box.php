<?php
// Don't load directly
if ( !defined('ABSPATH') ) { die('-1'); }

include_once ( 'vc_wtr.php' );

class VCExtendAddonHoverBox extends VCExtendAddonWtr{

	public $base	= 'vc_wtr_hover_box';
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
				'param_name'	=> 'img_1',
				'heading'		=> __( 'Base image', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'attach_image',
				'value'			=> '',
				'admin_label' 	=> false,
				'class'			=> $this->base . '_img_1_class',
			),

			array(
				'param_name'	=> 'img_2',
				'heading'		=> __( 'Image on hover', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'attach_image',
				'value'			=> '',
				'admin_label' 	=> false,
				'class'			=> $this->base . '_img_2_class',
			),

			array(
				'param_name'	=> 'url',
				'heading'		=> __( 'Link url', 'wtr_sht_framework' ),
				'description'	=> __( 'Where should your image link to?', 'wtr_sht_framework' ),
				'type'			=> 'vc_link',
				'value'			=> '',
				'admin_label' 	=> false,
				'class'			=> $this->base . '_url_class',
			),

			$this->getDefaultVCfield( 'el_class' ),
		);

		// animate attr
		$this->shtAnimateAttrGenerator( $this->fields, true );

		vc_map( array(
			'name'			=> __( 'Hover Box', 'wtr_sht_framework' ),
			'description'	=> '',
			'base'			=> $this->base,
			'class'			=> $this->base . '_div '. $this->wtrShtMainClass,
			'icon'			=> $this->base . '_icon',
			'controls'		=> 'full',
			'category'		=> $this->groupSht[ 'elements' ],
			'params'		=> $this->fields,
			'weight'		=> 27500,
			)
		);
	}//end integrateWithVC


	public function render( $atts, $content = null ){
		$result = '';
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

		if( strlen( $target ) ){
			$target = 'target="' . $target . '"';
		}


		if( $img_1 && $img_2 ){
			$img_1_wp = wp_get_attachment_image( $img_1,'full' );
			$img_2_wp = wp_get_attachment_image( $img_2, 'full' );

			$class_html_attr = 'wtrShtImgLink' . ' ' . esc_attr( $el_class );

			$result	.='<div ' . $this->shtAnimateHTML( $class_html_attr, $atts ) . '>';
				$result .= '<div class="wtrShtImgLinkContainer">';

					if( $url ){
						$result .= '<a ' . $target . ' href="' . $url . '" class="wtrShtImgLinkUrl" ></a>';
					}

					$result .= '<div class="wtrShtImgLinkPictureAbove">';
						$result .= $img_1_wp;
					$result .= '</div>';
					$result .= '<div class="wtrShtImgLinkPictureBelow">';
						$result .= $img_2_wp;
					$result .= '</div>';
				$result .= '</div>';
			$result .= '</div>';

		}

		return $result;
	}//end Render
}//end VCExtendAddonHoverBox



//== Create WooCommerce Sht Object
new VCExtendAddonHoverBox();
