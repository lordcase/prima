<?php
// Don't load directly
if ( !defined('ABSPATH') ) { die('-1'); }

include_once ( 'vc_wtr.php' );

class VCExtendAddonImageLink extends VCExtendAddonWtr{

	public $base	= 'vc_wtr_image_link';
	public $fields	= array();

	//===FUNCTIONS
	public function __construct(){

		parent::__construct();
		self::$sht_list[] = $this->base;
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
				'value'			=> array(	__( 'Standard', 'wtr_sht_framework' )	=> 'wtrShtLinkStandard',
											__( 'Light', 'wtr_sht_framework' )		=> 'wtrShtLinkLight',
										),
				'admin_label' 	=> true,
				'class'			=> $this->base . '_version_class',
			),

			array(
				'param_name'	=> 'img',
				'heading'		=> __( 'Image', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'attach_image',
				'value'			=> '',
				'admin_label' 	=> false,
				'class'			=> $this->base . '_img_class',
			),

			array(
				'param_name'	=> 'headline_f',
				'heading'		=> __( 'Link headline', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'textfield',
				'value'			=> '',
				'admin_label' 	=> true,
				'class'			=> $this->base . '_headline_f_class',
			),

			array(
				'param_name'	=> 'label_f',
				'heading'		=> __( 'Link label', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'textfield',
				'value'			=> '',
				'admin_label' 	=> true,
				'class'			=> $this->base . '_label_f_class',
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
			'name'			=> __( 'Image link', 'wtr_sht_framework' ),
			'description'	=> '',
			'base'			=> $this->base,
			'class'			=> $this->base . '_div '. $this->wtrShtMainClass,
			'icon'			=> $this->base . '_icon',
			'controls'		=> 'full',
			'category'		=> $this->groupSht[ 'elements' ],
			'params'		=> $this->fields,
			'weight'		=> 25925,
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

		if( $img ){

			$image_attributes	= wp_get_attachment_image( $img, 'size_2' );
			$class_html_attr	= 'wtrShtLink' . ' ' . $el_class . ' ' . $version;

			$result	.='<div ' . $this->shtAnimateHTML( $class_html_attr, $atts ) . '>';
				$result	.='<div class="wtrShtLinkEffect">';
					$result	.='<div class="wtrShtLinkContent">';
						if( $url ){
							$result	.='<a ' . $target . ' href="' . esc_url( $url ) . '" class="wtrShtLinkLay"></a>';
						}

						$result	.= $image_attributes;
						$result	.='<div class="wtrShtLinkMeta ">';
							$result	.='<i class="fa fa-plus-circle"></i>';
						$result	.='</div>';
					$result	.='</div>';

					$headline_fs	= strlen( $headline_f );
					$label_fs		= strlen( $label_f );

					if( 0 != $headline_fs || 0 != $label_fs ){
						$result	.='<div class="wtrShtLinkHedline">';
							if( $headline_fs ){
								$result	.='<span class="wrtAltFontCharacter">' . $headline_f . '</span> ';
							}

							if( $label_fs ){
								$result	.=  $label_f;
							}
						$result	.='</div>';
					}

				$result	.='</div>';
			$result	.='</div>';
		}

		return $result;
	}//end Render
}//end VCExtendAddonImageLink

new VCExtendAddonImageLink();
