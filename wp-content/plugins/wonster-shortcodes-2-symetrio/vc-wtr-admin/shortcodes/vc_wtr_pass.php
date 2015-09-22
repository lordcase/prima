<?php
// Don't load directly
if ( !defined('ABSPATH') ) { die('-1'); }

if ( !defined( 'WTR_CP_PLUGIN_MAIN_FILE' ) ) { return; }

include_once ( 'vc_wtr.php' );

class VCExtendAddonPass extends VCExtendAddonWtr{

	public $base	= 'vc_wtr_pass';
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
				'param_name'	=> 'id_pass',
				'heading'		=> __( 'Pass', 'wtr_sht_framework' ),
				'description'	=> __( 'Select a pass to be attached to content', 'wtr_sht_framework' ),
				'type'			=> 'dropdown',
				'value'			=> $this->getWpQuery( array(
										'post_type'			=> 'pass',
										'wtr_add_all_item'	=> false,
										'wtr_select_item'	=> true
									) ),
				'admin_label' 	=> true,
				'class'			=> $this->base . '_id_pass_class',
			),

			$this->getDefaultVCfield( 'el_class' ),
		);

		// animate attr
		$this->shtAnimateAttrGenerator( $this->fields, true );

		vc_map( array(
			'name'			=> __( 'Pass', 'wtr_sht_framework' ),
			'description'	=> '',
			'base'			=> $this->base,
			'class'			=> $this->base . '_div '. $this->wtrShtMainClass,
			'icon'			=> $this->base . '_icon',
			'controls'		=> 'full',
			'category'		=> $this->groupSht[ 'elements' ],
			'params'		=> $this->fields,
			'weight'		=> 22000,
			)
		);
	}//end integrateWithVC


	public function render( $atts, $content = null ){
		$result	='';
		$atts	= $this->prepareCorrectShortcode( $this->fields, $atts );
		extract($atts);

		if( 'wtr_select_item' == $id_pass ){
			return $this->draw_alert_info_wrong_data_id_sht( 'pass' );
		}

		global $post_settings;

		$post = get_post( $id_pass );
		if( empty( $post ) ){
			return ;
		}

		$title				= get_the_title( $id_pass );
		$price				= get_post_meta( $id_pass, '_wtr_pass_price', True );
		$membership_type	= get_post_meta( $id_pass, '_wtr_pass_membership_type', True );
		$desc				= get_post_meta( $id_pass, '_wtr_pass_desc', True );
		$status				= get_post_meta( $id_pass, '_wtr_pass_status', True );
		$class				= ( 0 == $status ) ? 'promoStatus' : ( ( 1 == $status ) ? 'newStatus' : 'featuredStatus' );
		$PayPalButton		= get_post_meta( $id_pass, '_wtr_PayPalButton', True );
		$PayPalPrice		= get_post_meta( $id_pass, '_wtr_PayPalPrice', True );
		$PayPalEmail		= get_post_meta( $id_pass, '_wtr_PayPalEmail', True );
		$PayPalCurrencyCode	= get_post_meta( $id_pass, '_wtr_PayPalCurrencyCode', True );
		$PayPalHtml			= wtr_paypal_button( $PayPalButton, $PayPalPrice, $PayPalEmail, $PayPalCurrencyCode, $title, 'wtrShtPassPriceHighlight wtrRadius3 wtrPayPalBtnAct' );
		$class_html_attr	= 'wtrSht wtrShtPass ' . $el_class;

		$result .= '<div' . $this->shtAnimateHTML( $class_html_attr, $atts ) . ' >';
			$result .= '<h5 class="wtrShtPassHeadline">';
				$result .= $title;
			$result .= '</h5>';

			$result .= '<div class="wtrShtPassDesc">';
				$result .= '<div class="wtrShtPassStatus clearfix">';
					$result .= '<div class="' . $class . ' wtrRadius100">';
						$result .= $post_settings['wtr_TranslateClassesSHTPassStatus' . $status ];
					$result .= '</div>';
				$result .= '</div>';
				$result .= '<div class="wtrShtPassDescHeadLine">';
					$result .= '<i class="fa fa-ticket"></i> ' . $membership_type;
				$result .= '</div>';
				$result .= '<div class="wtrShtPassDescLead">';
					$result .= $desc;
				$result .= '</div>';
			$result .= '</div>';
			$result .= '<div class="wtrShtPassPrice clearfix">';
				$result .= '<span class="wtrShtPassPriceHeadline wtrFloatLeft">';
					$result .= $post_settings['wtr_TranslateClassesSHTPassPrice'];
				$result .= '</span>';

				if( $PayPalHtml ){
					$result .= '<div class="wtrFloatRight wtrPayPal">';
						$result .= '<span class="wtrShtPassPriceHighlight wtrRadius3 wtrPayPalPrice">';
							$result .= $price;
						$result .= '</span>';
						$result .= $PayPalHtml;
					$result .= '</div>';
				} else{
					$result .= '<span class="wtrShtPassPriceHighlight wtrRadius3 wtrFloatRight">';
						$result .= $price;
					$result .= '</span>';
				}
			$result .= '</div>';
		$result .= '</div>';

		return $result;
	}//end Render

}//end VCExtendAddonPass

new VCExtendAddonPass();