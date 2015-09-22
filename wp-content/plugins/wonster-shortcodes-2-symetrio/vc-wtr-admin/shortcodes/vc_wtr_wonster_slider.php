<?php

// Don't load directly
if ( !defined('ABSPATH') ) { die('-1'); }

include_once ( 'vc_wtr.php' );

class WPBakeryShortCode_Vc_Wtr_Wonster_Slider extends WPBakeryShortCodesContainer {};
class WPBakeryShortCode_Vc_Wtr_Wonster_Slider_Item extends WPBakeryShortCode {};

class VCExtendAddonWonsterSlider extends VCExtendAddonWtr{

	public $base		= 'vc_wtr_wonster_slider';
	public $base_child	= 'vc_wtr_wonster_slider_item';
	public $buttonGroup	= '';

	public $contener_fields	= array();
	public $fields_item		= array();

	private static $countSliders		= 0;
	private static $countSlidersItem	= 0;

	//===FUNCTIONS
	public function __construct(){

		parent::__construct();

		$this->buttonGroup = __( 'Button', 'wtr_sht_framework' );

		// We safely integrate with VC with this hook
		add_action( 'init', array( &$this, 'integrateWithVC' ) );

		//Creating a shortcode addon
		add_shortcode( $this->base, array( &$this, 'renderContener' ) );
		add_shortcode( $this->base_child, array( &$this, 'renderItem' ) );
	}//end __construct


	public function integrateWithVC(){

		//item fields
		$this->contener_fields = array(
			array(
				'param_name'	=> 'effect',
				'heading'		=> __( 'Choose slide effect', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'Soft scale', 'wtr_sht_framework' )			=> 'fxSoftScale',
											__( 'Press away', 'wtr_sht_framework' )			=> 'fxPressAway',
											__( 'Side Swing', 'wtr_sht_framework' )			=> 'fxSideSwing',
											__( 'Fortune wheel', 'wtr_sht_framework' )		=> 'fxFortuneWheel',
											__( 'Swipe', 'wtr_sht_framework' )				=> 'fxSwipe',
											__( 'Push reveal', 'wtr_sht_framework' )		=> 'fxPushReveal',
											__( 'Snap in', 'wtr_sht_framework' )			=> 'fxSnapIn',
											__( 'Let me in', 'wtr_sht_framework' )			=> 'fxLetMeIn',
											__( 'Stick it', 'wtr_sht_framework' )			=> 'fxStickIt',
											__( 'Archive me', 'wtr_sht_framework' )			=> 'fxArchiveMe',
											__( 'Vertical growth', 'wtr_sht_framework' )	=> 'fxVGrowth',
											__( 'Slide Behind', 'wtr_sht_framework' )		=> 'fxSlideBehind',
											__( 'Soft Pulse', 'wtr_sht_framework' )			=> 'fxSoftPulse',
											__( 'Earthquake', 'wtr_sht_framework' )			=> 'fxEarthquake',
											__( 'Cliff diving', 'wtr_sht_framework' )		=> 'fxCliffDiving',
										),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_effect_class',
			),

			array(
				'param_name'	=> 'auto',
				'heading'		=> __( 'Auto slide', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'No', 'wtr_sht_framework' )		=> 'false',
											__( 'Yes', 'wtr_sht_framework' )	=> 'true',
										),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_auto_class',
			),

			array(
				'param_name'	=> 'delay_slide',
				'heading'		=> __( 'Time between slides', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'dropdown',
				'value'			=> array(	__( '1.0 second', 'wtr_sht_framework' )		=> '1000',
											__( '1.5 seconds', 'wtr_sht_framework' )	=> '1500',
											__( '2.0 seconds', 'wtr_sht_framework' )	=> '2000',
											__( '2.5 seconds', 'wtr_sht_framework' )	=> '2500',
											__( '3.0 seconds', 'wtr_sht_framework' )	=> '3000',
											__( '3.5 seconds', 'wtr_sht_framework' )	=> '3500',
											__( '4.0 seconds', 'wtr_sht_framework' )	=> '4000',
											__( '4.5 seconds', 'wtr_sht_framework' )	=> '4500',
											__( '5.0 seconds', 'wtr_sht_framework' )	=> '5000',
											__( '5.5 seconds', 'wtr_sht_framework' )	=> '5500',
											__( '6.0 seconds', 'wtr_sht_framework' )	=> '6000',
											__( '6.5 seconds', 'wtr_sht_framework' )	=> '6500',
											__( '7.0 seconds', 'wtr_sht_framework' )	=> '7000',
											__( '7.5 seconds', 'wtr_sht_framework' )	=> '7500',
											__( '8.0 seconds', 'wtr_sht_framework' )	=> '8000',
											__( '8.5 seconds', 'wtr_sht_framework' )	=> '8500',
											__( '9.0 seconds', 'wtr_sht_framework' )	=> '9000',
											__( '9.5 seconds', 'wtr_sht_framework' )	=> '9500',
											__( '10.0 seconds', 'wtr_sht_framework' )	=> '10000',
										),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_delay_slide_class',
				'dependency' 	=> array(	'element'	=> 'auto',
											'value'		=> array( 'true' ) )
			),

			array(
				'param_name'	=> 'hover_stop',
				'heading'		=> __( 'Stop autoplay slider when mouse hover on', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'Yes', 'wtr_sht_framework' )	=> 'true',
											__( 'No', 'wtr_sht_framework' )		=> 'false',
										),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_hover_stop_class',
				'dependency' 	=> array(	'element'	=> 'auto',
											'value'		=> array( 'true' ) )
			),

		);

		array_push($this->contener_fields, $this->getDefaultVCfield( 'el_class' ) );


			vc_map( array(
				'name'						=> __( 'Wonster Slider', 'wtr_sht_framework' ),
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
				'weight'		=> 11000,
				)
			);


		//item fields
		$this->fields_item = array(

			array(
				'param_name'	=> 'img',
				'heading'		=> __( 'Image', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'attach_image',
				'value'			=> '',
				'admin_label' 	=> false,
				'class'			=> $this->base . '_img_style',
			),

			array(
				'param_name'	=> 'overlay_color',
				'heading'		=> __( 'Overlay color', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'Off', 'wtr_sht_framework' )	=> '0',
											__( 'On', 'wtr_sht_framework' )		=> '1'
										),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_overlay_color_class',
			),

			array(
				'param_name'	=> 'color_bg',
				'heading'		=> __( 'Color', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'colorpicker',
				'value'			=> 'rgba(0,0,0,0.6)',
				'holder'		=> 'hidden',
				'admin_label' 	=> false,
				'class'			=> $this->base . '_color_bg_class',
				'dependency' 	=> array(	'element'	=> 'overlay_color',
											'value'		=> array( '1' ) )
			),

			array(
				'param_name'	=> 'headline',
				'heading'		=> __( 'Headline', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'textfield',
				'value'			=> '',
				'admin_label' 	=> true,
				'class'			=> $this->base . '_headline_class',
			),

			array(
				'param_name'	=> 'color_headline',
				'heading'		=> __( 'Headline color', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'colorpicker',
				'value'			=> '#ffffff',
				'holder'		=> 'hidden',
				'admin_label' 	=> false,
				'class'			=> $this->base . '_color_headline_class',
			),

			array(
				'param_name'	=> 'lead_1',
				'heading'		=> __( 'Lead 1', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'textfield',
				'value'			=> '',
				'admin_label' 	=> true,
				'class'			=> $this->base . '_lead_1_class',
			),

			array(
				'param_name'	=> 'lead_2',
				'heading'		=> __( 'Lead 2', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'textfield',
				'value'			=> '',
				'admin_label' 	=> true,
				'class'			=> $this->base . '_lead_2_class',
			),

			array(
				'param_name'	=> 'color_l',
				'heading'		=> __( 'Leads color', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'colorpicker',
				'value'			=> '#999999',
				'holder'		=> 'hidden',
				'admin_label' 	=> false,
				'class'			=> $this->base . '_color_l_class',
			),

			array(
				'param_name'	=> 'align',
				'heading'		=> __( 'Content alignment', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'Left', 'wtr_sht_framework' )	=> 'wtrTextAlignLeft',
											__( 'Right', 'wtr_sht_framework' )	=> 'wtrTextAlignRight',
											__( 'Center', 'wtr_sht_framework' )	=> 'wtrTextAlignCenter',
										),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_align_class',
			),

			// button

			array(
				'param_name'	=> 'click_element',
				'heading'		=> __( 'Button with link', 'wtr_sht_framework' ),
				'description'	=> '',
				'group'			=> $this->buttonGroup,
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'Off', 'wtr_sht_framework' )	=> '0',
											__( 'On', 'wtr_sht_framework' )		=> '1'
										),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_click_element_class',
			),

			array(
				'param_name'	=> 'url',
				'heading'		=> __( 'Link', 'wtr_sht_framework' ),
				'description'	=> __( 'Where should  link to?', 'wtr_sht_framework' ),
				'group'			=> $this->buttonGroup,
				'type'			=> 'vc_link',
				'value'			=> '',
				'admin_label' 	=> false,
				'class'			=> $this->base . '_url_class',
				'dependency' 	=> array(	'element'	=> 'click_element',
											'value'		=> array( '1' ) )
			),

			array(
				'param_name'	=> 'label',
				'heading'		=> __( 'Button label', 'wtr_sht_framework' ),
				'description'	=> __( 'Where should your button link to?', 'wtr_sht_framework' ),
				'group'			=> $this->buttonGroup,
				'type'			=> 'textfield',
				'value'			=> __( 'Click me', 'wtr_sht_framework' ),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_label_class',
				'dependency' 	=> array(	'element'	=> 'click_element',
											'value'		=> array( '1' ) )
			),

			array(
				'param_name'	=> 'size',
				'heading'		=> __( 'Size', 'wtr_sht_framework' ),
				'description'	=> __( 'Specify the size for your button', 'wtr_sht_framework' ),
				'group'			=> $this->buttonGroup,
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'Normal', 'wtr_sht_framework' )	=> 'normal',
											__( 'Big', 'wtr_sht_framework' )	=> 'big'
										),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_size_class',
				'dependency' 	=> array(	'element'	=> 'click_element',
											'value'		=> array( '1' ) )
			),

			array(
				'param_name'	=> 'color',
				'heading'		=> __( 'Color', 'wtr_sht_framework' ),
				'description'	=> __( 'Specify the color for your button', 'wtr_sht_framework' ),
				'group'			=> $this->buttonGroup,
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'Green', 'wtr_sht_framework' )		=> 'c_green',
											__( 'Blue', 'wtr_sht_framework' )		=> 'c_blue',
											__( 'Navy', 'wtr_sht_framework' )		=> 'c_navy',
											__( 'Turquoise', 'wtr_sht_framework' )	=> 'c_turquoise',
											__( 'Yellow', 'wtr_sht_framework' )		=> 'c_yellow',
											__( 'Orange', 'wtr_sht_framework' )		=> 'c_orange',
											__( 'Red', 'wtr_sht_framework' )		=> 'c_red',
											__( 'Purple', 'wtr_sht_framework' )		=> 'c_rurple',
											__( 'Gray', 'wtr_sht_framework' )		=> 'c_gray',
											__( 'Dark Gray', 'wtr_sht_framework' )	=> 'c_dark_gray',
											__( 'White', 'wtr_sht_framework' )		=> 'c_white',
											__( 'Black', 'wtr_sht_framework' )		=> 'c_black',
										),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_color_class',
				'dependency' 	=> array(	'element'	=> 'click_element',
											'value'		=> array( '1' ) )
			),

			array(
				'param_name'	=> 'corner',
				'heading'		=> __( 'Button with rounded corners', 'wtr_sht_framework' ),
				'description'	=> '',
				'group'			=> $this->buttonGroup,
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'Yes', 'wtr_sht_framework' )	=> 'wtrButtonRad',
											__( 'No', 'wtr_sht_framework' )		=> 'wtrButtonNoRad'
										),
				'admin_label'	=> false,
				'class'			=> $this->base . '_corner_class',
				'dependency' 	=> array(	'element'	=> 'click_element',
											'value'		=> array( '1' ) )
			),

			array(
				'param_name'	=> 'background',
				'heading'		=> __( 'Button type', 'wtr_sht_framework' ),
				'description'	=> __( 'Specify the type of your button', 'wtr_sht_framework' ),
				'group'			=> $this->buttonGroup,
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'Button filled with color', 'wtr_sht_framework' )			=> 'wtrButtonNoTrans',
											__( 'Button with transparent background', 'wtr_sht_framework' )	=> 'wtrButtonTrans'
										),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_background_class',
				'dependency' 	=> array(	'element'	=> 'click_element',
											'value'		=> array( '1' ) )
			),

			array(
				'param_name'	=> 'animate_icon',
				'heading'		=> __( 'Animated with icon', 'wtr_sht_framework' ),
				'description'	=> __( 'Define hover action', 'wtr_sht_framework' ),
				'group'			=> $this->buttonGroup,
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'Animated with icon', 'wtr_sht_framework' )			=> 'wtrButtonHoverAnim',
											__( 'Standard with background', 'wtr_sht_framework' )	=> 'wtrButtonHoverNoAnim'
										),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_animated_icon_class',
				'dependency' 	=> array(	'element'	=> 'click_element',
											'value'		=> array( '1' ) )
			),

			$this->getDefaultVCfield( 'el_class' ),
		);
			//custom list - item
			vc_map( array(
				'name'						=> __( 'Wonster Slider - Slide', 'wtr_sht_framework' ),
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
		extract( $atts );

		$result .= '<section class="wtrSht wtrShtWonsterSlider  ' . esc_attr( $el_class ) . '">';
			$result .= '<div data-effect="'. esc_attr( $effect ) .'" data-autoslide="' . esc_attr( $auto ) . '" data-delay="' . intval( $delay_slide ) . '" data-hover-stop="' . esc_attr( $hover_stop ) . '" id="wtrWonsterSliderItem-' . ( self::$countSliders ) . '" class="component wtr-wonster-slider wtrShtWonsterSliderComponent component-fullwidth">';
				$result .= '<ul class="itemwrap">';
				$result .= $content ;
				$result .= '</ul>';
				$result .= '<div class="wtrShtWonsterSliderControlsContainer clearfix">';
					$result .= '<nav class="wtrShtWonsterSliderControls clearfix">';
						$result .= '<span class="prev wtrRadius3"></span>';
						$result .= '<span class="next wtrRadius3"></span>';
					$result .= '</nav>';
				$result .= '</div>';
			$result .= '</div>';

			$result .= '<div class="wtrShtWonsterSliderDotsContainer clearfix">';
				$result .= '<ul class="wtrShtWonsterSliderDots">';
					$result .= str_repeat( '<li><span class=""></span></li>', self::$countSlidersItem );
				$result .= '</ul>';
			$result .= '</div>';
		$result .= '</section>';

		self::$countSliders++;
		self::$countSlidersItem = 0;

		return $result;
	}//end Render


	public function renderItem( $atts, $content = null ){
		$result	='';
		$atts	= $this->prepareCorrectShortcode( $this->fields_item, $atts );
		extract( $atts );


		$image_attributes	= wp_get_attachment_image_src( $img, 'full' );
		$image				= ( $image_attributes[0] ) ?  $image_attributes[0] : '' ;
		$style_bg			=( 1 == $overlay_color ) ? 'style="background-color:' . esc_attr( $color_bg ) . ';"' : '';
		$button				= '';

		if( 1 == $click_element ){
			$button .= '<span class="wtrShtWonsterSliderButtonContainer clearfix">';
				$button .= do_shortcode( '[vc_wtr_button url="' . $url . '" label="' . $label . '" align="none" size="' . $size . '" color="' . $color . '" corner="' . $corner . '" background="' . $background . '" animate_icon="' . $animate_icon . '" full_width="wtrButtonNoFullWidth"]' );
			$button .= '</span>';
		}

		$result .= '<li class=" ' . esc_attr( $el_class ) . ' " style="background-image: url(\'' . $image . '\')">';
			$result .= '<div class="wtrInner">';
				$result .= '<div class="wtrShtWonsterSliderLayer">';
					$result .= '<div class="wtrShtWonsterSliderLayerMeta ' . esc_attr( $align ) . '">';
						if( $headline ){
							$result .= '<h2 class="wtrShtWonsterSliderHeadline" style="color:' . esc_attr( $color_headline ) . ';" >' . $headline . '</h2>';
						}
						if( $lead_2 OR $lead_1){
							$result .= '<div class="wtrShtWonsterSliderLead" style="color: ' . esc_attr( $color_l ) . ';">';
								$result .= '<div class="wtrShtWonsterSliderSluglineOne">' . $lead_1 . '</div>';
								$result .= '<div class="wtrShtWonsterSliderSluglineSec">' . $lead_2 . '</div>';
							$result .= '</div>';
						}
						$result .= $button;
					$result .= '</div>';
				$result .= '</div>';
			$result .= '</div>';
			$result .= '<span class="wtrShtWonsterSliderOverlay"  '. $style_bg .'></span>';
		$result .= '</li>';

		self::$countSlidersItem++;

		return $result;
	}//end Render

}//end VCExtendAddonWonsterSlider

new VCExtendAddonWonsterSlider();