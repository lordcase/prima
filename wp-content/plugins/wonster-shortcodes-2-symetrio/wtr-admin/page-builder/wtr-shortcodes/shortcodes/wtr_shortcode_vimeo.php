<?php
/**
 * @package Energizo
 * @author Wonster
 * @link http://wonster.co/
 */

// Don't load directly
if ( !defined('ABSPATH') ) { die('-1');}

include_once ( SHORTCODES_URL . '/wtr_shortcode_template.php' );


if ( ! class_exists( 'WTR_Shortcode_Vimeo' ) ) {

	class WTR_Shortcode_Vimeo extends  WTR_Shortcode_Template {

		// FUNCTION
		public function __construct(){

			parent::__construct();
			$this->fields = array(
				'basic'		=> array( 'name' => $this->fieldsGroup[ 'basic' ], 'fields' => array() ),
				'advanced'	=> array( 'name' => $this->fieldsGroup[ 'advanced' ], 'fields' => array() )
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
				'shortcode_id'	=> 'vc_wtr_vimeo',
				'end_el'		=> false,
				'name'			=> __('Vimeo', 'wtr_sht_framework' ),
				'icon'			=> 'ib-vimeo',
				'shortcode'		=> 'WTR_Shortcode_Vimeo',
				'modal_size'	=> array( 'width' => 900, 'height' =>725, 'fullscreenW' => 'no', 'fullscreenH' => 'no' ),
				'prev_size'		=> array( 'width' =>800, 'height' => 600,  'fullscreenW' => 'no', 'fullscreenH' => 'no' ),
				'no_prev'			=> true
			);
		}// end sht_button


		protected function fillFields(){

			// create fields list
			$url = new WTR_Text(array(
					'id'			=> $this->shortcode_id . '_url',
					'class'			=> 'ModalFields ReadStandard',
					'title'			=> __( 'Movie url', 'wtr_sht_framework' ),
					'desc'			=> '',
					'value'			=> '',
					'default_value' => '',
					'info'			=> __( 'Working example: http://vimeo.com/<b>75746181</b>. <br />Please insert only: <b>75746181</b>', 'wtr_sht_framework' ),
					'allow'			=> 'all',
				)
			);
			array_push( $this->fields[ 'basic' ][ 'fields' ], $url );

			$color = new WTR_Color( array(
					'id' => $this->shortcode_id . '_color',
					'class'			=> 'ModalFields ReadColorHash',
					'title'			=> __( 'Color', 'wtr_sht_framework' ),
					'desc'			=> __( 'Specify the color of the video controls.', 'wtr_sht_framework' ),
					'value'			=> '#00adef',
					'default_value'	=> '',
					'info'			=> '',
					'allow'			=> 'all',
				)
			);
			array_push( $this->fields[ 'basic' ][ 'fields' ], $color );

			$size = new WTR_Select( array(
					'id'			=> $this->shortcode_id . '_size',
					'title'			=> __( 'Movie size', 'wtr_sht_framework' ),
					'desc'			=> '',
					'class'			=> 'ModalFields ReadStandard',
					'value'			=> '750-422',
					'default_value'	=> '',
					'info'			=> '',
					'allow'			=> 'all',
					'mod'			=> '',
					'option'		=> array('750-422'	=> __( 'Big ( 750 x 422 ) ', 'wtr_sht_framework' ),
											 '500-281'	=> __( 'Medium ( 500 x 281 )', 'wtr_sht_framework' ),
											 '360-202'	=> __( 'Small ( 360 x 202 )', 'wtr_sht_framework' ),
											 'custom'	=> __( 'Custom', 'wtr_sht_framework' )
										),
				)
			);
			array_push( $this->fields[ 'basic' ][ 'fields' ], $size );

			$w = new WTR_Text(array(
					'id'			=> $this->shortcode_id . '_width',
					'class'			=> 'ModalFields ReadStandard',
					'title'			=> __( 'Video width', 'wtr_sht_framework' ),
					'desc'			=> __( 'Enter a value for the width', 'wtr_sht_framework' ),
					'value'			=> '750',
					'default_value'	=> '',
					'info'			=> '',
					'allow'			=> 'all',
					'dependency' 	=> array(	'element'	=> $this->shortcode_id . '_size',
												'value'		=> array( 'custom' ) ),
				)
			);
			array_push( $this->fields[ 'basic' ][ 'fields' ], $w );

			$h = new WTR_Text(array(
					'id'			=> $this->shortcode_id . '_height',
					'class'			=> 'ModalFields ReadStandard',
					'title'			=> __( 'Video height', 'wtr_sht_framework' ),
					'desc'			=> __( 'Enter a value for the height', 'wtr_sht_framework' ),
					'value'			=> '422',
					'default_value'	=> '',
					'info'			=> '',
					'allow'			=> 'all',
					'dependency' 	=> array(	'element'	=> $this->shortcode_id . '_size',
												'value'		=> array( 'custom' ) ),
				)
			);
			array_push( $this->fields[ 'basic' ][ 'fields' ], $h );

			$align = new WTR_Select( array(
					'id'			=> $this->shortcode_id . '_align',
					'title'			=> __( 'Align element', 'wtr_sht_framework' ),
					'desc'			=> __( 'Specify the alignment for your movie', 'wtr_sht_framework' ),
					'class'			=> 'ModalFields ReadStandard',
					'value'			=> 'none',
					'default_value'	=> '',
					'info'			=> '',
					'allow'			=> 'all',
					'mod'			=> '',
					'option'		=> array('none'		=> __( 'None', 'wtr_sht_framework' ),
											 'center'	=> __( 'Center', 'wtr_sht_framework' )
										),
				)
			);
			array_push( $this->fields[ 'basic' ][ 'fields' ], $align );

			array_push( $this->fields[ 'basic' ][ 'fields' ], $this->extraClassElement() );

			$autoplay = new WTR_Select( array(
					'id'			=> $this->shortcode_id . '_autoplay',
					'class'			=> 'ModalFields ReadStandard',
					'title'			=> __( 'Autoplay', 'wtr_sht_framework' ),
					'desc'			=> __( 'Play the video automatically on load.<b><br />Note that this won’t work on
											some devices.</b>', 'wtr_sht_framework' ),
					'value'			=> '1',
					'default_value'	=> '',
					'info'			=> '',
					'allow'			=> 'all',
					'mod'			=> '',
					'option'		=> array(	'1' => __( 'On', 'wtr_sht_framework' ),
												'0' => __( 'Off', 'wtr_sht_framework' ) ),
					)
			);
			array_push( $this->fields[ 'advanced' ][ 'fields' ], $autoplay );

			$autor = new WTR_Select( array(
					'id'			=> $this->shortcode_id . '_autor',
					'class'			=> 'ModalFields ReadStandard',
					'title'			=> __( 'Portrait', 'wtr_sht_framework' ),
					'desc'			=> __( 'Show the user’s portrait on the Video', 'wtr_sht_framework' ),
					'value'			=> '1',
					'default_value'	=> '',
					'info'			=> '',
					'allow'			=> 'all',
					'mod'			=> '',
					'option'		=> array(	'1' => __( 'On', 'wtr_sht_framework' ),
												'0' => __( 'Off', 'wtr_sht_framework' ) ),
					)
			);
			array_push( $this->fields[ 'advanced' ][ 'fields' ], $autor );


			$title = new WTR_Select( array(
					'id'			=> $this->shortcode_id . '_title',
					'class'			=> 'ModalFields ReadStandard',
					'title'			=> __( 'Title', 'wtr_sht_framework' ),
					'desc'			=> __( 'Show the title on the video', 'wtr_sht_framework' ),
					'value'			=> '1',
					'default_value'	=> '',
					'info'			=> '',
					'allow'			=> 'all',
					'mod'			=> '',
					'option'		=> array(	'1' => __( 'On', 'wtr_sht_framework' ),
												'0' => __('Off', 'wtr_sht_framework' ) ),
					)
			);
			array_push( $this->fields[ 'advanced' ][ 'fields' ], $title );

			$byline = new WTR_Select( array(
					'id'			=> $this->shortcode_id . '_byline',
					'class'			=> 'ModalFields ReadStandard',
					'title'			=> __( 'User’s byline', 'wtr_sht_framework' ),
					'desc'			=> __( 'Show the user’s byline on the video', 'wtr_sht_framework' ),
					'value'			=> '1',
					'default_value'	=> '',
					'info'			=> '',
					'allow'			=> 'all',
					'mod'			=> '',
					'option'		=> array(	'1' => __( 'On', 'wtr_sht_framework' ),
												'0' => __('Off', 'wtr_sht_framework' ) ),
					)
			);
			array_push( $this->fields[ 'advanced' ][ 'fields' ], $byline );

			$loop = new WTR_Select( array(
					'id'			=> $this->shortcode_id . '_loop',
					'class'			=> 'ModalFields ReadStandard',
					'title'			=> __( 'Play video in loop', 'wtr_sht_framework' ),
					'desc'			=> __( 'Play the video again when it reaches the end.', 'wtr_sht_framework' ),
					'value'			=> '1',
					'default_value'	=> '',
					'info'			=> '',
					'allow'			=> 'all',
					'mod'			=> '',
					'option'		=> array(	'1' => __( 'On', 'wtr_sht_framework' ),
												'0' => __( 'Off', 'wtr_sht_framework' ) ),
					)
			);
			array_push( $this->fields[ 'advanced' ][ 'fields' ], $loop );

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
	}// end WTR_Shortcode_Notification
}