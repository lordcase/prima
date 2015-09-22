<?php
/**
 * @package Energizo
 * @author Wonster
 * @link http://wonster.co/
 */

// Don't load directly
if ( !defined('ABSPATH') ) { die('-1');}

include_once ( SHORTCODES_URL . '/wtr_shortcode_template.php' );


if ( ! class_exists( 'WTR_Shortcode_Animation' ) ) {

	class WTR_Shortcode_Animation extends  WTR_Shortcode_Template {

		// FUNCTION
		public function __construct(){

			parent::__construct();
			$this->fields = array(
				'basic'		=> array( 'name' => $this->fieldsGroup[ 'basic' ], 'fields' => array() )
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
				'shortcode_id'	=> 'vc_wtr_animation',
				'end_el'		=> true,
				'name'			=> __('Animation Area', 'wtr_sht_framework' ),
				'icon'			=> 'ib-css-animation',
				'shortcode'		=> 'WTR_Shortcode_Animation',
				'modal_size'	=> array( 'width' => 900, 'height' =>700, 'fullscreenW' => 'no', 'fullscreenH' => 'no' ),
				'prev_size'		=> array( 'width' =>800, 'height' => 600,  'fullscreenW' => 'no', 'fullscreenH' => 'no' ),
				'no_prev'			=> true
			);
		}// end sht_button


		protected function fillFields(){

			// add animation option
			$this->fields[ 'basic' ][ 'fields' ] = $this->animationOption();

			$alert= new WTR_Alert( array(
					'id'			=> 'wtr_ColorThemeAlert',
					'title'			=> __( '<b>Important!</b> Shortcodes in WordPress have limitation which may affect
											the proper functioning of this element.
											<a href="http://codex.wordpress.org/Shortcode_API#Nested_Shortcodes"
											target="blank" style="color:#8a6d3b; font-weight:bold; text-decoration:
											underline;">Read more</a>', 'wtr_sht_framework' ),
					'desc'			=> '',
					'value'			=> '',
					'default_value'	=> '1',
					'info'			=> '',
					'allow'			=> 'int',
					'mod'			=> ''
				)
			);
			array_unshift($this->fields[ 'basic' ][ 'fields' ], $alert );

			$content = new WTR_Hidden(array(
					'id'			=> 'type_content',
					'class'			=> 'ModalFields SimleTextBetween',
					'title'			=> '',
					'desc'			=> '',
					'value'			=> __( 'Insert your code here', 'wtr_sht_framework' ),
					'default_value'	=> '',
					'info'			=> '',
					'allow'			=> 'all',
				)
			);

			array_push( $this->fields[ 'basic' ][ 'fields' ], $this->extraClassElement() );

			array_push( $this->fields[ 'basic' ][ 'fields' ], $content );

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