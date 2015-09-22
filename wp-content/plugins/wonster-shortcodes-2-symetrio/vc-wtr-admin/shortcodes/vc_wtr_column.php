<?php
// Don't load directly
if ( !defined('ABSPATH') ) { die('-1'); }

include_once ( 'vc_wtr.php' );

class VCExtendAddonColumn extends VCExtendAddonWtr{

	public $base			= 'vc_column';
	public $base_inner		= 'vc_column_inner';
	public $fields			= array();
	public $fields_inner	= array();

	//===FUNCTIONS
	public function __construct(){

		parent::__construct();

		// We safely integrate with VC with this hook
		add_action( 'init', array( &$this, 'integrateWithVC' ) );

		//Creating a shortcode addon
		add_shortcode( $this->base, array( &$this, 'render' ), 10, 3 );
		add_shortcode( $this->base_inner, array( &$this, 'render_inner' ), 10, 3 );
	}//end __construct


	public function integrateWithVC(){

		$this->removeShortcodesParam(
			array(
				$this->base			=> array( 'font_color', 'el_class' ),
				$this->base_inner	=> array( 'font_color', 'el_class' ),
			)
		);

		$type_bg = array(
				'param_name'	=> 'type_bg',
				'heading'		=> __( 'Background type', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'Transparent', 'wtr_sht_framework' )	=> 'transparent',
											__( 'Solid color', 'wtr_sht_framework' )	=> 'solid',
											__( 'Image', 'wtr_sht_framework' )			=> 'img',
										),
				'holder'		=> 'hidden',
				'admin_label' 	=> false,
				'class'			=> $this->base . '_type_bg_class',

		);
		vc_add_param($this->base, $type_bg );
		array_push( $this->fields, $type_bg );
		vc_add_param($this->base_inner, $type_bg );
		array_push( $this->fields_inner, $type_bg );

		$color_bg = array(
				'param_name'	=> 'color_bg',
				'heading'		=> __( 'Background color', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'colorpicker',
				'value'			=> '#ffffff',
				'holder'		=> 'hidden',
				'admin_label' 	=> false,
				'class'			=> $this->base . '_color_bg_class',
				'dependency' 	=> array(	'element'	=> 'type_bg',
											'value'		=> array( 'solid' ) )
		);
		vc_add_param($this->base, $color_bg );
		array_push( $this->fields, $color_bg );
		vc_add_param($this->base_inner, $color_bg );
		array_push( $this->fields_inner, $color_bg );

		$img_bg = array(
				'param_name'	=> 'img_bg',
				'heading'		=> __( 'Background color', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'attach_image',
				'value'			=> '',
				'holder'		=> 'hidden',
				'admin_label' 	=> false,
				'class'			=> $this->base . '_img_bg_class',
				'dependency' 	=> array(	'element'	=> 'type_bg',
											'value'		=> array( 'img' ) )
		);
		vc_add_param($this->base, $img_bg );
		array_push( $this->fields, $img_bg );
		vc_add_param($this->base_inner, $img_bg );
		array_push( $this->fields_inner, $img_bg );

		$img_attr = array(
				'param_name'	=> 'img_attr',
				'heading'		=> __( 'Backgorund image attribute', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'Default', 'wtr_sht_framework' )	=> 'default',
											__( 'Cover', 'wtr_sht_framework' )		=> 'cover',
											__( 'Contain', 'wtr_sht_framework' )	=> 'contain',
											__( 'No Repeat', 'wtr_sht_framework' )	=> 'no_repeat',
											__( 'Repeat', 'wtr_sht_framework' )		=> 'repeat',
										),
				'holder'		=> 'hidden',
				'admin_label' 	=> false,
				'class'			=> $this->base . '_img_attr_style',
				'dependency' 	=> array(	'element'	=> 'type_bg',
											'value'		=> array( 'img' ) )
		);
		vc_add_param($this->base, $img_attr );
		array_push( $this->fields, $img_attr );
		vc_add_param($this->base_inner, $img_attr );
		array_push( $this->fields_inner, $img_attr );

		$corner = array(
				'param_name'	=> 'corner',
				'heading'		=> __( 'Rounded corners on column edges', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'No', 'wtr_sht_framework' )		=> 'wtrNoRoundedCornersColumn',
											__( 'Yes', 'wtr_sht_framework' )	=> 'wtrRoundedCornersColumn' ),
				'holder'		=> 'hidden',
				'admin_label' 	=> false,
				'class'			=> $this->base . '_corner_class',
		);
		vc_add_param($this->base, $corner );
		array_push( $this->fields, $corner );
		vc_add_param($this->base_inner, $corner );
		array_push( $this->fields_inner, $corner );

		$el_class = $this->getDefaultVCfield( 'el_class' );
		vc_add_param($this->base, $el_class );
		array_push( $this->fields, $el_class );
		vc_add_param($this->base_inner, $el_class );
		array_push( $this->fields_inner, $el_class );


		// adding attributes "animation" to shortdcode
		$animate_effect = $this->shtAnimateAttrEffect( $this->shtCardName[ 'animate' ] );
		vc_add_param($this->base, $animate_effect );
		array_push( $this->fields , $animate_effect );
		vc_add_param($this->base_inner, $animate_effect );
		array_push( $this->fields_inner, $animate_effect );

		$animate_delay = $this->shtAnimateAttrDelay( $this->shtCardName[ 'animate' ] );
		vc_add_param($this->base, $animate_delay );
		array_push( $this->fields , $animate_delay );
		vc_add_param($this->base_inner, $animate_delay );
		array_push( $this->fields_inner, $animate_delay );

	}//end integrateWithVC


	private function render_main(  $atts, $content = null, $sht, $class ){
		$result				= '';
		$atts['content']	= wpb_js_remove_wpautop( $content, false );
		$atts				= $this->prepareCorrectShortcode( $this->fields, $atts );
		extract( $atts );

		//var_dump($offset);

		$width				= ( isset( $width ) ) ? $width : '';
		$class_width		= wpb_translateColumnWidthToSpan( $width );
		$style_attr			= array();

		if( 'img' == $type_bg ){
			$image_attributes	= wp_get_attachment_image_src( $img_bg, 'full' );
			$image				= ( $image_attributes[0] ) ? $image_attributes[0] : '';

			switch ( $img_attr ) {

				case 'cover':
					$img_attr_code = 'background-position: center; background-repeat: no-repeat; background-size: cover;';
				break;

				case 'contain':
					$img_attr_code = 'background-position: center; background-repeat: no-repeat; background-size: contain;';
				break;

				case 'no_repeat':
					$img_attr_code = 'background-repeat: no-repeat;';
				break;

				case 'repeat':
					$img_attr_code = 'background-repeat: repeat;';
				break;

				case 'default'	:
				default			:
					$img_attr_code = '';
				break;
			}

			$style_attr[]		= ( $image ) ? 'background:url(' . $image . '); ' . $img_attr_code : '';
		} else if( 'solid' == $type_bg ){
			$style_attr[]		= 'background-color: '. esc_attr( $color_bg ).';';
		}
		$style					= ( $style_attr ) ? 'style="' . implode('', $style_attr ) . '"' : '';

		if( !isset( $offset ) ){
			$offset = '';
		}

		if( isset( $css ) ){
			$css = explode( '{', $css );
			$css = ' ' . substr( $css[ 0 ], 1 ) . ' ';
		}else{
			$css = '';
		}

		$class_html_attr = $class . ' ' . $class_width . ' ' . $corner . ' wpb_column vc_column_container ' . $el_class;

		$result .= "\n\t" . '<div ' . $this->shtAnimateHTML( $class_html_attr, $atts ) . ' >';
		$result .= "\n\t\t" . '<div ' . $style . ' class="wpb_wrapper '. esc_attr( $css ) . ' ' . esc_attr( $offset ) . '">';
		$result .= "\n\t\t\t" . $content;
		$result .= "\n\t\t" . '</div> ';
		$result .= "\n\t" . '</div> ';

		return $result;

	}//end render_main


	public function render( $atts, $content = null, $sht ){
		$result = $this->render_main( $atts, $content, $sht, 'wtrStandardColumn' );
		return $result;
	}//end renderTabContener


	public function render_inner( $atts, $content = null, $sht ){
		$result =$this->render_main( $atts, $content, $sht, 'wtrInnerColumn' );
		return $result;
	}//end renderTabContener

}//end VCExtendAddonColumn

new VCExtendAddonColumn();