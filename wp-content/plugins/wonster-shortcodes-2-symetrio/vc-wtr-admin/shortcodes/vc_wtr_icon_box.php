<?php
// Don't load directly
if ( !defined('ABSPATH') ) { die('-1'); }

include_once ( 'vc_wtr.php' );

class VCExtendAddonIconBox extends VCExtendAddonWtr{

	public $base	= 'vc_wtr_icon_box';
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
				'param_name'	=> 'size',
				'heading'		=> __( 'Presentation style', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'Boxed', 'wtr_sht_framework' )		=> 'big',
											__( 'Slim', 'wtr_sht_framework' )	=> 'standard',
										),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_size_class',
			),

			array(
				'param_name'	=> 'version',
				'heading'		=> __( 'Version', 'wtr_sht_framework' ),
				'description'	=> __( 'Enable this option if you want to put this item on the background and make it
										more attractive', 'wtr_sht_framework' ),
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'Standard', 'wtr_sht_framework' )	=> 'standard',
											__( 'Light', 'wtr_sht_framework' )		=> 'light',
										),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_version_class',
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
				'param_name'	=> 'data_title',
				'heading'		=> __( 'Title', 'wtr_sht_framework' ),
				'description'	=> __( 'Title of the container', 'wtr_sht_framework' ),
				'type'			=> 'textfield',
				'value'			=> '',
				'admin_label' 	=> false,
				'class'			=> $this->base . '_data_title_class',
				'dependency'	=> array(	'element'	=> 'size',
											'value'		=> array( 'big' ) )
			),

			array(
				'param_name'	=> 'data_content',
				'heading'		=> __( 'Content', 'wtr_sht_framework' ),
				'description'	=> __( 'Contents of the container', 'wtr_sht_framework' ),
				'type'			=> 'textarea',
				'value'			=> '',
				'admin_label' 	=> false,
				'class'			=> $this->base . '_data_content_class',
				'dependency'	=> array(	'element'	=> 'size',
											'value'		=> array( 'big' ) )
			),

			array(
				'param_name'	=> 'label',
				'heading'		=> __( 'Label', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'textfield',
				'value'			=> '',
				'admin_label' 	=> false,
				'class'			=> $this->base . '_label_class',
				'dependency'	=> array(	'element'	=> 'size',
											'value'		=> array( 'standard' ) )
			),

			$this->getDefaultVCfield( 'el_class' ),
		);

		// animate attr
		$this->shtAnimateAttrGenerator( $this->fields, true );


		vc_map( array(
			'name'			=> __( 'Icon Box', 'wtr_sht_framework' ),
			'description'	=> '',
			'base'			=> $this->base,
			'class'			=> $this->base . '_div '. $this->wtrShtMainClass,
			'icon'			=> $this->base . '_icon',
			'controls'		=> 'full',
			'category'		=> $this->groupSht[ 'additional' ],
			'params'		=> $this->fields,
			'weight'		=> 26000,
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



		if( 'big' == $size ){
			$class				= ( 'light' == $version ) ? 'wtrShtIconBoxLight' : '';
			$class_html_attr	= 'wtrSht wtrShtIconBox wtrRadius3 ' . $el_class . ' ' . $class;

			$result .= '<div' . $this->shtAnimateHTML( $class_html_attr, $atts ) . ' >';

				if( ! empty( $url ) ){
					$result .= '<a href="' . $url . '" ' . $target . ' class="wtrShtIconContainer wtrShtIconBoxAni wtrRadius100">';
						$result .= '<i class="wtrShtIconBoxAni ' . $icon . '"></i>';
					$result .= '</a>';
					$result .= '<a href="' . $url . '" ' . $target . ' class="wtrShtIconBoxOverlay"></a>';
				} else {
					$result .= '<span class="wtrShtIconContainer wtrShtIconBoxAni wtrRadius100">';
						$result .= '<i class="wtrShtIconBoxAni ' . $icon . '"></i>';
					$result .= '</span>';
				}

				$result .= '<h4 class="wtrShtIconBoxTitle">';
					$result .= $data_title;
				$result .= '</h4>';
				$result .= '<div class="wtrShtIconBoxDesc">';
					$result .= $data_content;
				$result .= '</div>';
			$result .= '</div>';
		} else {

			$class				= ( 'light' == $version ) ?  'wtrShtIconBoxListLight' : '';
			$class_html_attr	= 'wtrShtIconBoxList  clearfix  ' . $el_class . ' ' . $class;

			$result .= '<div ' . $this->shtAnimateHTML( $class_html_attr, $atts ) . ' >';
				$result .= '<div class="wtrShtIconBoxIconHolder wtrShtIconBoxListAnimation">';
					if( ! empty( $url ) ){
						$result .= '<a href="' . $url . '" ' . $target . '>';
							$result .= '<span><i class="' . $icon . ' wtrShtIconBoxListAnimation"></i></span>';
							$result .= '<p class="wtrShtIconBoxTextHolder wtrShtIconBoxListAnimation">' . $label . '</p>';
						$result .= '</a>';
					} else {
							$result .= '<span><i class="' . $icon. ' wtrShtIconBoxListAnimation"></i></span>';
							$result .= '<p class="wtrShtIconBoxTextHolder wtrShtIconBoxListAnimation">' . $label . '</p>';
					}
				$result .= '</div>';
			$result .= '</div>';

		}


		return $result;
	}//end Render

}//end VCExtendAddonIconBox

new VCExtendAddonIconBox();