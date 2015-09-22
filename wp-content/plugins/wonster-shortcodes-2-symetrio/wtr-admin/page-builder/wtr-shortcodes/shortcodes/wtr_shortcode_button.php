<?php
/**
 * @package Energizo
 * @author Wonster
 * @link http://wonster.co/
 */

// Don't load directly
if ( !defined('ABSPATH') ) { die('-1');}

include_once ( SHORTCODES_URL . '/wtr_shortcode_template.php' );


if ( ! class_exists( 'WTR_Shortcode_Button' ) ) {

	class WTR_Shortcode_Button extends  WTR_Shortcode_Template {

		// FUNCTION
		public function __construct(){

			parent::__construct();
			$this->fields = array(
				'basic'		=> array( 'name' => $this->fieldsGroup[ 'basic' ], 'fields' => array() ),
				'margin'	=> array( 'name' => $this->fieldsGroup[ 'margin' ], 'fields' => array() ),
				'animation'	=> array( 'name' => $this->fieldsGroup[ 'animation' ], 'fields' => array() )
			);

			// init obj
			$this->createEl( self::sht_button() );

			// fill fields
			$this->fillFields();

			parent::__construct();
		}// end __construct


		public static function sht_button( $version = null )
		{
			return array(
				'shortcode_id'	=> 'vc_wtr_button',
				'end_el'		=> false,
				'name'			=> __('Buttons', 'wtr_sht_framework' ),
				'icon'			=> 'ib-button',
				'shortcode'		=> 'WTR_Shortcode_Button',
				'modal_size'	=> array( 'width' => 900, 'height' =>815, 'fullscreenW' => 'no', 'fullscreenH' => 'no' ),
				'prev_size'		=> array( 'width' =>800, 'height' => 600,  'fullscreenW' => 'no', 'fullscreenH' => 'no' ),
				'no_prev'			=> true
			);
		}// end sht_button


		protected function fillFields(){

			$url = new WTR_Text(array(
					'id'			=> $this->shortcode_id . '_url',
					'class'			=> 'ModalFields ReadStandard VCModUrl',
					'title'			=> __( 'Button Link', 'wtr_sht_framework' ),
					'desc'			=> __( 'Where should your button link to?', 'wtr_sht_framework' ),
					'value'			=> 'http://',
					'default_value'	=> '',
					'info'			=> __( '<span style="color:#318fce; font-weight:bold;">Please fill full path</span>. Example: https://google.com', 'wtr_sht_framework' ),
					'allow'			=> 'all',
				)
			);
			array_push( $this->fields[ 'basic' ][ 'fields' ], $url );

			$label = new WTR_Text(array(
					'id'			=> $this->shortcode_id . '_label',
					'class'			=> 'ModalFields ReadStandard',
					'title'			=> __( 'Button Label', 'wtr_sht_framework' ),
					'desc'			=> __( 'This is the text that appears on your button', 'wtr_sht_framework' ),
					'value'			=> __( 'Click me', 'wtr_sht_framework' ),
					'default_value'	=> '',
					'info'			=> '',
					'allow'			=> 'all',
				)
			);
			array_push( $this->fields[ 'basic' ][ 'fields' ], $label );

			$align = new WTR_Select( array(
					'id'			=> $this->shortcode_id . '_align',
					'title'			=> __( 'Align element', 'wtr_sht_framework' ),
					'desc'			=> __( 'Specify the alignment for your button', 'wtr_sht_framework' ),
					'class'			=> 'ModalFields ReadStandard',
					'value'			=> 'none',
					'default_value'	=> '',
					'info'			=> '',
					'allow'			=> 'all',
					'mod'			=> '',
					'option'		=> array('none'		=> __( 'None', 'wtr_sht_framework' ),
											 'left'		=> __( 'Left', 'wtr_sht_framework' ),
											 'center'	=> __( 'Center', 'wtr_sht_framework' ),
											 'right'	=> __( 'Right', 'wtr_sht_framework' )
										),
				)
			);
			array_push( $this->fields[ 'basic' ][ 'fields' ], $align );

			$size = new WTR_Select( array(
					'id'			=> $this->shortcode_id . '_size',
					'title'			=> __( 'Size', 'wtr_sht_framework' ),
					'desc'			=> __( 'Specify the size for your button', 'wtr_sht_framework' ),
					'class'			=> 'ModalFields ReadStandard',
					'value'			=> 'normal',
					'default_value'	=> '',
					'info'			=> '',
					'allow'			=> 'all',
					'mod'			=> '',
					'option'		=> array('normal'	=> __( 'Normal', 'wtr_sht_framework' ),
											 'big'		=> __( 'Big', 'wtr_sht_framework' )
										),
				)
			);
			array_push( $this->fields[ 'basic' ][ 'fields' ], $size );

			$color = new WTR_Select( array(
					'id'			=> $this->shortcode_id . '_color',
					'title'			=> __( 'Color', 'wtr_sht_framework' ),
					'desc'			=> __( 'Specify the color for your button', 'wtr_sht_framework' ),
					'class'			=> 'ModalFields ReadStandard',
					'value'			=> 'lightBlue',
					'default_value'	=> '',
					'info'			=> '',
					'allow'			=> 'all',
					'mod'			=> '',
					'option'		=> array(	'c_green'		=> __( 'Green', 'wtr_sht_framework' ),
												'c_blue'		=> __( 'Blue', 'wtr_sht_framework' ),
												'c_navy'		=> __( 'Navy', 'wtr_sht_framework' ),
												'c_turquoise'	=> __( 'Turquoise', 'wtr_sht_framework' ),
												'c_yellow'		=> __( 'Yellow', 'wtr_sht_framework' ),
												'c_orange'		=> __( 'Orange', 'wtr_sht_framework' ),
												'c_red'			=> __( 'Red', 'wtr_sht_framework' ),
												'c_rurple'		=> __( 'Purple', 'wtr_sht_framework' ),
												'c_gray'		=> __( 'Gray', 'wtr_sht_framework' ),
												'c_dark_gray'	=> __( 'Dark Gray', 'wtr_sht_framework' ),
												'c_white'		=> __( 'White', 'wtr_sht_framework' ),
												'c_black'		=> __( 'Black', 'wtr_sht_framework' ),
										),
				)
			);
			array_push( $this->fields[ 'basic' ][ 'fields' ], $color );

			$corner = new WTR_Select( array(
					'id'			=> $this->shortcode_id . '_corner',
					'title'			=> __( 'Button with rounded corners', 'wtr_sht_framework' ),
					'desc'			=> '',
					'class'			=> 'ModalFields ReadStandard',
					'value'			=> 'wtrButtonRad',
					'default_value'	=> '',
					'info'			=> '',
					'allow'			=> 'all',
					'mod'			=> '',
					'option'		=> array('wtrButtonRad'		=> __( 'Yes', 'wtr_sht_framework' ),
											 'wtrButtonNoRad'	=> __( 'No', 'wtr_sht_framework' )
										),
				)
			);
			array_push( $this->fields[ 'basic' ][ 'fields' ], $corner );

			$background = new WTR_Select( array(
					'id'			=> $this->shortcode_id . '_background',
					'title'			=> __( 'Button type', 'wtr_sht_framework' ),
					'desc'			=> __( 'Specify  the type of your button', 'wtr_sht_framework' ),
					'class'			=> 'ModalFields ReadStandard',
					'value'			=> 'filled',
					'default_value'	=> '',
					'info'			=> '',
					'allow'			=> 'all',
					'mod'			=> '',
					'option'		=> array('wtrButtonNoTrans'		=> __( 'Button filled with color', 'wtr_sht_framework' ),
											 'wtrButtonTrans'		=> __( 'Button filled with color transparent background', 'wtr_sht_framework' )
										),
				)
			);
			array_push( $this->fields[ 'basic' ][ 'fields' ], $background );

			$animate_icon = new WTR_Select( array(
					'id'			=> $this->shortcode_id . '_animate_icon',
					'title'			=> __( 'Animated with icon', 'wtr_sht_framework' ),
					'desc'			=> __( 'Define hover action', 'wtr_sht_framework' ),
					'class'			=> 'ModalFields ReadStandard',
					'value'			=> 'animated',
					'default_value'	=> '',
					'info'			=> '',
					'allow'			=> 'all',
					'mod'			=> '',
					'option'		=> array('wtrButtonHoverAnim'	=> __( 'Animated with icon', 'wtr_sht_framework' ),
											 'wtrButtonHoverNoAnim'	=> __( 'Standard with background', 'wtr_sht_framework' )
										),
				)
			);
			array_push( $this->fields[ 'basic' ][ 'fields' ], $animate_icon );

			$full_width = new WTR_Select( array(
					'id'			=> $this->shortcode_id . '_full_width',
					'title'			=> __( 'Full width', 'wtr_sht_framework' ),
					'desc'			=> __( 'Decide, does the button fill the entire space in a column', 'wtr_sht_framework' ),
					'class'			=> 'ModalFields ReadStandard',
					'value'			=> 'wtrButtonNoFullWidth',
					'default_value'	=> '',
					'info'			=> '',
					'allow'			=> 'all',
					'mod'			=> '',
					'option'		=> array('wtrButtonFullWidth'	=> __( 'On', 'wtr_sht_framework' ),
											 'wtrButtonNoFullWidth'	=> __( 'Off', 'wtr_sht_framework' )
										),
				)
			);
			array_push( $this->fields[ 'basic' ][ 'fields' ], $full_width );

			$target = new WTR_Select( array(
					'id'			=> $this->shortcode_id . '_target',
					'title'			=> __( 'Open Link in new Window?', 'wtr_sht_framework' ),
					'desc'			=> __( 'Select here if you want to open the linked page in a new window', 'wtr_sht_framework' ),
					'class'			=> 'ModalFields ReadStandard',
					'value'			=> 'animated',
					'default_value'	=> '1',
					'info'			=> '',
					'allow'			=> 'all',
					'mod'			=> '',
					'option'		=> array('_target'	=> __( 'On', 'wtr_sht_framework' ),
											 '0'		=> __( 'Off', 'wtr_sht_framework' )
										),
				)
			);
			array_push( $this->fields[ 'basic' ][ 'fields' ], $target );

			array_push( $this->fields[ 'basic' ][ 'fields' ], $this->extraClassElement() );

			// add margin option
			$this->fields[ 'margin' ][ 'fields' ] = $this->marginsOption();

			// add animation option
			$this->fields[ 'animation' ][ 'fields' ] = $this->animationOption();

			$type_external = new WTR_Hidden(array(
					'id'			=> 'type_external',
					'class'			=> 'ModalFields SaveOnly',
					'title'			=> '',
					'desc'			=> '',
					'value'			=> __CLASS__,
					'default_value'	=> '',
					'info'			=> '',
					'allow'			=> 'all',
				)
			);
			array_push( $this->fields[ 'basic' ][ 'fields' ], $type_external );
		}// end fillFields
	}// end WTR_Shortcode_Button
}