<?php

// Don't load directly
if ( !defined('ABSPATH') ) { die('-1'); }

include_once ( 'vc_wtr.php' );

class WPBakeryShortCode_Vc_Wtr_Step_By_Step extends WPBakeryShortCodesContainer {};
class WPBakeryShortCode_Vc_Wtr_Step_By_Step_Item extends WPBakeryShortCode {};

class VCExtendAddonStepByStep extends VCExtendAddonWtr{

	public $base		= 'vc_wtr_step_by_step';
	public $base_child	= 'vc_wtr_step_by_step_item';

	public $contener_fields	= array();
	public $fields_item		= array();

	private static $items_count	= 1;
	private static $items_data	= array();

	//===FUNCTIONS
	public function __construct(){

		parent::__construct();

		// We safely integrate with VC with this hook
		add_action( 'init', array( &$this, 'integrateWithVC' ) );

		//Creating a shortcode addon
		add_shortcode( $this->base, array( &$this, 'renderContener' ) );
		add_shortcode( $this->base_child, array( &$this, 'renderItem' ) );
	}//end __construct


	public function integrateWithVC(){

		$this->contener_fields = array(
			array(
				'param_name'	=> 'alert',
				'heading'		=> '',
				'description'	=> '',
				'type'			=> 'wtr_alert',
				'value'			=> '',
				'admin_label' 	=> false,
				'class'			=> $this->base . '_alert_class',
				'dependency' 	=> array(	'element'	=> 'type',
											'value'		=> array( 'boxed' ) ),
				'wtr_attr'		=> array(	'extra_class'	=> '',
											'message'		=> __( '<b>Important!</b> The maximum number of steps is: 6', 'wtr_sht_framework' )
										 ),
			),
		);

		// animate attr
		$this->shtAnimateAttrGenerator( $this->contener_fields, false );

		array_push($this->contener_fields, $this->getDefaultVCfield( 'el_class' ) );

			vc_map( array(
				'name'						=> __( 'Step by Step', 'wtr_sht_framework' ),
				'description'				=> '',
				'base'						=> $this->base,
				'class'						=> $this->base . '_div',
				'icon'						=> $this->base . '_icon',
				'controls'					=> 'full',
				'category'					=> $this->groupSht[ 'elements' ],
				'params'					=> $this->contener_fields,
				'show_settings_on_create'	=> true,
				'content_element'			=> true,
				'as_parent'					=> array( 'only' => $this->base_child  ),
				'js_view'					=> 'VcColumnView',
				'weight'					=> 18000,
				)
			);


		//item fields
		$this->fields_item = array(

			array(
				'param_name'	=> 'data_title',
				'heading'		=> __( 'Title', 'wtr_sht_framework' ),
				'description'	=> __( 'the title of the container', 'wtr_sht_framework' ),
				'type'			=> 'textfield',
				'value'			=> '',
				'admin_label' 	=> false,
				'class'			=> $this->base . '_data_content_class',
			),

			array(
				'param_name'	=> 'data_content',
				'heading'		=> __( 'Content', 'wtr_sht_framework' ),
				'description'	=> __( 'the contents of the container', 'wtr_sht_framework' ),
				'type'			=> 'textarea',
				'value'			=> '',
				'admin_label' 	=> false,
				'class'			=> $this->base . '_data_content_class',
			),

			array(
				'param_name'	=> 'type',
				'heading'		=> __( 'Type the graphic', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'None', 'wtr_sht_framework' )	=> 'none',
											__( 'Image', 'wtr_sht_framework' )	=> 'image',
											__( 'Icon', 'wtr_sht_framework' )	=> 'icon',
										),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_type_class'
			),

			array(
				'param_name'	=> 'img',
				'heading'		=> __( 'Image', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'attach_image',
				'value'			=> '',
				'admin_label' 	=> false,
				'class'			=> $this->base . '_img_style',
				'dependency' 	=> array(	'element'	=> 'type',
											'value'		=> array( 'image' ) )
			),

			array(
				'param_name'	=> 'type_icon',
				'heading'		=> __( 'Icon', 'wtr_sht_framework' ),
				'description'	=> __( 'Select the icon set', 'wtr_sht_framework' ),
				'type'			=> 'wtr_icons_set',
				'value'			=> 'web|fa fa-check-square', // group | icon
				'admin_label' 	=> false,
				'class'			=> $this->base . '_type_icon_class',
				'dependency' 	=> array(	'element'	=> 'type',
											'value'		=> array( 'icon' ) )
			),

			array(
				'param_name'	=> 'color',
				'heading'		=> __( 'Color', 'wtr_sht_framework' ),
				'description'	=> __( 'Specify the color for your icon', 'wtr_sht_framework' ),
				'type'			=> 'colorpicker',
				'value'			=> '#000000',
				'admin_label' 	=> false,
				'class'			=> $this->base . '_color_class',
				'dependency' 	=> array(	'element'	=> 'type',
							'value'		=> array( 'icon' ) )
			),
		);
			//custom list - item
			vc_map( array(
				'name'						=> __( 'Step by Step - Item', 'wtr_sht_framework' ),
				'description'				=> '',
				'base'						=> $this->base_child,
				'class'						=> $this->base_child . '_div '. $this->wtrShtMainClass,
				'icon'						=> $this->base_child . '_icon',
				'controls'					=> 'full',
				'category'					=> $this->groupSht[ 'elements' ],
				'params'					=> $this->fields_item,
				'show_settings_on_create'	=> true,
				'content_element'			=> true,
				'as_child'					=> array('only' => $this->base ),
				)
			);
	}//end integrateWithVC


	public function renderContener( $atts, $content = null ){
		$result				='';
		$atts['content']	= wpb_js_remove_wpautop( $content, false );
		$atts				= $this->prepareCorrectShortcode( $this->contener_fields, $atts );
		$itemsC				= count( self::$items_data );
		extract( $atts );

		switch( $itemsC ){
			case 1: $childrenS = 'wtrOneStep'; break;
			case 2: $childrenS = 'wtrTwoSteps'; break;
			case 3: $childrenS = 'wtrThreeSteps'; break;
			case 4: $childrenS = 'wtrFourSteps'; break;
			case 5: $childrenS = 'wtrFiveSteps'; break;
			case 6: $childrenS = 'wtrSixSteps'; break;
		}

		global $post_settings;

		$class_html_attr = 'wtrSht wtrShtStepByStep ' . $childrenS . ' clearfix ' . $el_class;

		$result .= '<div' . $this->shtAnimateHTML( $class_html_attr, $atts ) . ' >';

			if( $itemsC ){
				for( $i = 0; $i < $itemsC; $i++ ){
					$last = ( $i == $itemsC - 1 )? ' ShtStepByStepLast ' : '';
					$result .= '<div class="wtrShtStepByStepItem ' . $last . '">';
						$result .= '<div class="wtrShtStepByStepContainer ">';
							$data_title		= self::$items_data[ $i ][ 'data_title' ];
							$data_content	= self::$items_data[ $i ][ 'data_content' ];
							if( 'image' == self::$items_data[ $i ][ 'type' ] ){
								$img		= wp_get_attachment_image_src( self::$items_data[ $i ][ 'img' ], 'full' );
								$img_alt	= esc_attr( get_post_meta( self::$items_data[ $i ][ 'img' ], '_wp_attachment_image_alt', true ) );
								$result .= '<img class="wtrSteByStepImg" src="' . $img[0] . '" alt="' . $img_alt . '">';
							}else if( 'icon' == self::$items_data[ $i ][ 'type' ] ){
								$type_icon		= self::$items_data[ $i ][ 'type_icon' ];
								$icon			= explode( "|", $type_icon );
								$icon			= ( 2 == count( $icon ) ) ? esc_attr( $icon[1] ) : '';
								$color			= self::$items_data[ $i ][ 'color' ];
								$style_iscon	= 'style="color:' . esc_attr( $color ) . ';"';

								$result .= '<div class="wtrShtStepByStepIco">';
									$result .= '<i ' . $style_iscon . ' class="' . $icon . '"></i>';
								$result .= '</div>';
							}

							$result .= '<h4 class="wtrShtStepByStepName">' . $data_title . '</h4>';
							$result .= '<div class="wtrShtStepByStepDesc">' . $data_content . '</div>';
						$result .= '</div>';
						$result .= '<div class="wtrShtStepByStepInfo clearfix">';
							$result .= '<div class="wtrShtStepByStepInfoNag">' . $post_settings['wtr_TranslateClassesSHTSBSStep'] . '</div>';
							$result .= '<div class="wtrShtStepByStepInfoNo wtrRadius3">' . ( $i + 1 ) . '</div>';
						$result .= '</div>';
					$result .= '</div>';
				}
			}

		$result .= '</div>';

		self::$items_count	= 1;
		self::$items_data	= array();
		return $result;
	}//end Render


	public function renderItem( $atts, $content = null ){
		$atts = $this->prepareCorrectShortcode( $this->fields_item, $atts );

		array_push( self::$items_data, $atts );
		self::$items_count ++;
	}//end Render

}//end VCExtendAddonStepByStep

new VCExtendAddonStepByStep();