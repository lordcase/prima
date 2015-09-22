<?php
/**
 * @package Energizo
 * @author Wonster
 * @link http://wonster.co/
 */

// Don't load directly
if ( !defined('ABSPATH') ) { die('-1');}

include_once ( SHORTCODES_URL . '/wtr_shortcode_template.php' );


if ( ! class_exists( 'WTR_Shortcode_Google_Font' ) ) {

	class WTR_Shortcode_Google_Font extends  WTR_Shortcode_Template {

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
				'shortcode_id'	=> 'wtr_google_font',
				'end_el'		=> true,
				'name'			=> __('Google Font', 'wtr_sht_framework' ),
				'icon'			=> 'ib-google-font',
				'shortcode'		=> 'WTR_Shortcode_Google_Font',
				'modal_size'	=> array( 'width' => 900, 'height' =>790, 'fullscreenW' => 'no', 'fullscreenH' => 'no' ),
				'prev_size'		=> array( 'width' =>800, 'height' => 600,  'fullscreenW' => 'no', 'fullscreenH' => 'no' ),
				'no_prev'			=> true
			);
		}// end sht_button


		protected function fillFields(){

			$text = new WTR_Text(array(
					'id'			=> $this->shortcode_id . '_text',
					'class'			=> 'ModalFields SimleTextBetween wtr_admin_font_switch',
					'title'			=> __( 'Text size (px)', 'wtr_sht_framework' ),
					'desc'			=> '',
					'value'			=> __( 'lore ipsum', 'wtr_sht_framework' ),
					'default_value'	=> '',
					'info'			=> '',
					'allow'			=> 'all',
				)
			);
			array_push( $this->fields[ 'basic' ][ 'fields' ], $text );

			$size = new WTR_Scroll( array(
					'id'			=> $this->shortcode_id . '_size',
					'class' 		=> 'ModalFields ReadStandard wtr_admin_prev_font_size',
					'title'			=> __( 'Text size', 'wtr_framework' ),
					'desc'			=> '',
					'value' 		=> 20,
					'default_value' => '',
					'info'			=> '',
					'allow'			=> 'between',
					'has_attr' 		=> '',
					'min' 			=> 8,
					'max' 			=> 80,
				)
			);
			array_push( $this->fields[ 'basic' ][ 'fields' ], $size );

			global $fonts_all;

			$font = new WTR_Select( array(
					'id'			=> $this->shortcode_id . '_font',
					'title'			=> __( 'Google Font', 'wtr_sht_framework' ),
					'desc'			=> '',
					'class'			=> 'ModalFields ReadStandard',
					'value'			=> 'none',
					'default_value'	=> '',
					'info'			=> '',
					'allow'			=> 'all',
					'mod'			=> 'font',
					'option'		=> $fonts_all,
				)
			);
			array_push( $this->fields[ 'basic' ][ 'fields' ], $font );

/*			$size = new WTR_Text(array(
					'id'			=> $this->shortcode_id . '_size',
					'class'			=> 'ModalFields ReadStandard',
					'title'			=> __( 'Font size (px)', 'wtr_sht_framework' ),
					'desc'			=> __( 'Value must be a number', 'wtr_sht_framework' ),
					'value'			=> __( '25', 'wtr_sht_framework' ),
					'default_value'	=> '',
					'info'			=> '',
					'allow'			=> 'all',
				)
			);
			array_push( $this->fields[ 'basic' ][ 'fields' ], $size );*/

			$subset = new WTR_Text(array(
					'id'			=> $this->shortcode_id . '_subset',
					'class'			=> 'ModalFields ReadStandard',
					'title'			=> __( 'Google font subset', 'wtr_sht_framework' ),
					'desc'			=> '',
					'value'			=> '',
					'default_value'	=> '',
					'info'			=> '',
					'allow'			=> 'all',
				)
			);
			array_push( $this->fields[ 'basic' ][ 'fields' ], $subset );


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
	}// end WTR_Shortcode_Google_Font
}