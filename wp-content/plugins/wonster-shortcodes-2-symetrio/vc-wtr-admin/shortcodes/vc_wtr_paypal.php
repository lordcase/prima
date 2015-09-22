<?php
// Don't load directly
if ( !defined('ABSPATH') ) { die('-1'); }

include_once ( 'vc_wtr.php' );

class VCExtendAddonPayPal extends VCExtendAddonWtr{

	public $base	= 'vc_wtr_paypal';
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

		global $wtr_paypal_currency_code;

		$this->fields = array(

			array(
				'param_name'	=> 'version',
				'heading'		=> __( 'Version', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'Image button', 'wtr_sht_framework' )				=> 'img',
											__( 'Simple button', 'wtr_sht_framework' )				=> 'wtr_style',
											__( 'Call to action headline', 'wtr_sht_framework' )	=> 'headline'
										),
				'admin_label' 	=> true,
				'class'			=> $this->base . '_version_class',

			),

			// img
			array(
				'param_name'	=> 'img_url',
				'heading'		=> __( 'Button image', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'attach_image',
				'value'			=> '',
				'admin_label' 	=> false,
				'class'			=> $this->base . '_img_url_style',
				'dependency' 	=> array(	'element'	=> 'version',
											'value'		=> array( 'img' ) )
			),

			array(
				'param_name'	=> 'img_url_hover',
				'heading'		=> __( 'Button image on hover', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'attach_image',
				'value'			=> '',
				'admin_label' 	=> false,
				'class'			=> $this->base . '_img_url_hover_style',
				'dependency' 	=> array(	'element'	=> 'version',
											'value'		=> array( 'img' ) )
			),

			//wtr_style
			array(
				'param_name'	=> 'simple_style',
				'heading'		=> __( 'Style', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'Simple button with cart icon on right', 'wtr_sht_framework' )		=> 'style_1',
											__( 'Simple button with paypal icon on right', 'wtr_sht_framework' )	=> 'style_2',
											__( 'Simple button with cart icon on left', 'wtr_sht_framework' )		=> 'style_3',
											__( 'Simple button with paypal icon on left', 'wtr_sht_framework' )		=> 'style_4',
										),
				'admin_label' 	=> true,
				'dependency' 	=> array(	'element'	=> 'version',
											'value'		=> array( 'wtr_style' ) )
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
				'dependency' 	=> array(	'element'	=> 'version',
											'value'		=> array( 'wtr_style' ) )
			),

			array(
				'param_name'	=> 'button_color',
				'heading'		=> __( 'Button background color', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'colorpicker',
				'value'			=> '#dd3333',
				'admin_label' 	=> false,
				'class'			=> $this->base . '_button_color_style',
				'dependency' 	=> array(	'element'	=> 'version',
											'value'		=> array( 'wtr_style' ) )
			),

			array(
				'param_name'	=> 'button_font_color',
				'heading'		=> __( 'Button font color', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'colorpicker',
				'value'			=> '#dd3333',
				'admin_label' 	=> false,
				'class'			=> $this->base . '_button_font_color_style',
				'dependency' 	=> array(	'element'	=> 'version',
											'value'		=> array( 'wtr_style' ) )
			),

			array(
				'param_name'	=> 'button_color_hover',
				'heading'		=> __( 'Button background color on hover', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'colorpicker',
				'value'			=> '#dd3333',
				'admin_label' 	=> false,
				'class'			=> $this->base . '_button_color_hover_style',
				'dependency' 	=> array(	'element'	=> 'version',
											'value'		=> array( 'wtr_style' ) )
			),

			array(
				'param_name'	=> 'button_font_color_hover',
				'heading'		=> __( 'Button font color on hover', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'colorpicker',
				'value'			=> '#dd3333',
				'admin_label' 	=> false,
				'class'			=> $this->base . '_button_font_color_hover_style',
				'dependency' 	=> array(	'element'	=> 'version',
											'value'		=> array( 'wtr_style' ) )
			),


			//headline & wtr_style

			array(
				'param_name'	=> 'button_text',
				'heading'		=> __( 'Button text', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'textfield',
				'value'			=> __( 'Buy now', 'wtr_sht_framework' ),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_button_text_class',
				'dependency' 	=> array(	'element'	=> 'version',
											'value'		=> array( 'wtr_style', 'headline' ) )
			),

			//headline

			array(
				'param_name'	=> 'button_style',
				'heading'		=> __( 'Call to action', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'Normal', 'wtr_sht_framework' )	=> 'normal',
											__( 'Light', 'wtr_sht_framework' )	=> 'light',
										),
				'admin_label' 	=> false,
				'dependency' 	=> array(	'element'	=> 'version',
											'value'		=> array( 'headline' ) )
			),

			array(
				'param_name'	=> 'headline_text',
				'heading'		=> __( 'Headline text', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'textfield',
				'value'			=> '',
				'admin_label' 	=> false,
				'class'			=> $this->base . '_button_text_class',
				'dependency' 	=> array(	'element'	=> 'version',
											'value'		=> array( 'headline' ) )
			),

			array(
				'param_name'	=> 'description_text',
				'heading'		=> __( 'Description text', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'textfield',
				'value'			=> '',
				'admin_label' 	=> false,
				'class'			=> $this->base . '_button_text_class',
				'dependency' 	=> array(	'element'	=> 'version',
											'value'		=> array( 'headline' ) )
			),

			array(
				'param_name'	=> 'price',
				'heading'		=> __( 'Price', 'wtr_sht_framework' ),
				'description'	=> __( '<b>Please, use only decimal format</b>. For example: 10.00', 'wtr_sht_framework' ),
				'type'			=> 'textfield',
				'value'			=> __( '10.00', 'wtr_sht_framework' ),
				'admin_label' 	=> true,
				'class'			=> $this->base . '_price_class',
			),

			array(
				'param_name'	=> 'paypal_mail',
				'heading'		=> __( 'Your PayPal e-mail adres', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'textfield',
				'value'			=> '',
				'admin_label' 	=> false,
				'class'			=> $this->base . '_paypal_mail_class',
			),

			array(
				'param_name'	=> 'transaction_name',
				'heading'		=> __( 'PayPal transaction name', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'textfield',
				'value'			=> '',
				'admin_label' 	=> false,
				'class'			=> $this->base . '_transaction_name_class',
			),



			array(
				'param_name'	=> 'currency_code',
				'heading'		=> __( 'Currency Code', 'wtr_sht_framework' ),
				'description'	=> __( '* This currency does not support decimals. Passing a decimal amount will result
										in an error.<br /> ** This currency is supported as a payment currency and a currency
										balance for in-country PayPal accounts only.', 'wtr_sht_framework' ),
				'type'			=> 'dropdown',
				'value'			=> array_flip( $wtr_paypal_currency_code),
				'admin_label' 	=> true,
				'class'			=> $this->base . '_currency_code_class',
			),

			$this->getDefaultVCfield( 'el_class' ),
		);

		// animate attr
		$this->shtAnimateAttrGenerator( $this->fields, true );


		vc_map( array(
			'name'			=> __( 'PayPal', 'wtr_sht_framework' ),
			'description'	=> '',
			'base'			=> $this->base,
			'class'			=> $this->base . '_div '. $this->wtrShtMainClass,
			'icon'			=> $this->base . '_icon',
			'controls'		=> 'full',
			'category'		=> $this->groupSht[ 'elements' ],
			'params'		=> $this->fields,
			'weight'		=> 19750,
			)
		);
	}//end integrateWithVC


	public function render( $atts, $content = null ){
		$result	='';
		$atts	= $this->prepareCorrectShortcode( $this->fields, $atts );
		extract( $atts );


		if( 'img' ==  $version ) {

			$img_url_attributes			= wp_get_attachment_image_src( $img_url, 'full' );
			$img_url_alt				= esc_attr( get_post_meta( $img_url, '_wp_attachment_image_alt', true ) );
			$img_url					= ( $img_url_attributes[0] ) ? $img_url_attributes[0] : '';
			$img_url_hover_attributes	= wp_get_attachment_image_src( $img_url_hover, 'full' );
			$img_url_hover_alt			= esc_attr( get_post_meta( $img_url_hover, '_wp_attachment_image_alt', true ) );
			$img_url_hover				= ( $img_url_hover_attributes[0] ) ? $img_url_hover_attributes[0] : '';
			$class_html_attr			= 'wtrShtPayPalImg ' . $el_class;

			$result .= '<div ' . $this->shtAnimateHTML( $class_html_attr, $atts ) . '>';
				$result .= '<a class="wtrShtPayPalButtonImg">';
					$result .= '<img class="wtrShtPayPalImgStatic" src="' . $img_url . '" alt="' . $img_url_alt . '">';
					$result .= '<div class="wtrShtPayPalImgHover">';
						$result .= '<img src="' . $img_url_hover . '" alt="' . $img_url_hover_alt . '">';
					$result .= '</div>';
				$result .= '</a>';
				$result .= wtr_paypal_form( $price, $paypal_mail, $currency_code, $transaction_name, 'paypalFunctionSht' );
			$result .= '</div>';
		} else if( 'wtr_style' ==  $version ) {

			$class				= ( 'style_2' == $simple_style OR 'style_1' == $simple_style ) ? 'rightIcon' : 'leftIcon';
			$icon				= ( 'style_3' == $simple_style OR 'style_1' == $simple_style ) ? 'fa fa-shopping-cart' : 'fa fa-paypal';
			$button_icon		= '<span><i class="' . $icon . '"></i></span>';
			$button				= ( 'rightIcon' == $class ) ? $button_text . $button_icon : $button_icon . $button_text;
			$class_html_attr	= 'wtrShtPayPalButton ' . $class . ' ' . $el_class;
			$align_style		= ( 'none' != $align ) ? 'style="text-align:' . esc_attr( $align ) . ';"' :'';

			$result .= '<div ' . $this->shtAnimateHTML( $class_html_attr, $atts ) . ' ' . $align_style . '>';
				$result .= '<a class="wtrRadius3 paypalTriggerSht" style="background-color: ' . $button_color . '; color: ' . $button_font_color . ';" data-color="' . $button_color . '" data-color-text="' . $button_font_color . '" data-color-hover="' . $button_color_hover . '" data-color-text-hover="' . $button_font_color_hover . '" >';
					$result .= $button;
				$result .= '</a>';
				$result .= wtr_paypal_form( $price, $paypal_mail, $currency_code, $transaction_name, 'paypalFunctionSht' );
			$result .= '</div>';

		} else if( 'headline' ==  $version ) {

			$class_html_attr	= 'wtrSht wtrShtPayPal ' . $button_style . ' wtrRadius3 ' . $el_class;

			$result .= '<div ' . $this->shtAnimateHTML( $class_html_attr, $atts ) . '>';
				$result .= '<div class="wtrShtPayPalContainer">';
					$result .= '<div class="wtrPayPalIco"><i class="fa fa-paypal"></i></div>';
					$result .= '<h6 class="wtrShtPayPalItemName">';
						$result .= $headline_text;
						$result .= '<hr>';
					$result .= '</h6>';
				$result .= '</div>';
				if( $description_text ) {
					$result .= '<div class="wtrShtPPDesc">';
						$result .= $description_text;
					$result .= '</div>';
				}
				$result .= '<div class="wtrShtPPPrice wtrRadius3">';
					$result .= '<div>' . $price . '<span> ' . $currency_code . ' </span></div>';
					$result .= '<hr>';
					$result .= '<a  class="wtrShtPPPriceBtn wtrRadius3 paypalTriggerSht">';
						$result .= $button_text;
					$result .= '</a>';
					$result .= wtr_paypal_form( $price, $paypal_mail, $currency_code, $transaction_name, 'paypalFunctionSht' );
				$result .= '</div>';
			$result .= '</div>';
		}




		return $result;
	}//end Render

}//end VCExtendAddonPayPal

new VCExtendAddonPayPal();