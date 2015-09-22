<?php
/**
 * @package Energizo
 * @author Wonster
 * @link http://wonster.co/
 */

// Don't load directly
if ( !defined('ABSPATH') ) { die('-1');}

include_once ( SHORTCODES_URL . '/wtr_shortcode_template.php' );


if ( ! class_exists( 'WTR_Shortcode_Youtube' ) ) {

	class WTR_Shortcode_Youtube extends  WTR_Shortcode_Template {

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
				'shortcode_id'	=> 'vc_wtr_youtube',
				'end_el'		=> false,
				'name'			=> __('YouTube', 'wtr_sht_framework' ),
				'icon'			=> 'ib-youtube',
				'shortcode'		=> 'WTR_Shortcode_Youtube',
				'modal_size'	=> array( 'width' => 900, 'height' =>850, 'fullscreenW' => 'no', 'fullscreenH' => 'no' ),
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
					'default_value'	=> '',
					'info'			=> __( 'Working example: http://www.youtube.com/watch?v=<b>G0k3kHtyoqc</b>.
											<br />Please insert only: <b>G0k3kHtyoqc</b>', 'wtr_sht_framework' ),
					'allow'			=> 'all',
				)
			);
			array_push( $this->fields[ 'basic' ][ 'fields' ], $url );

			$size = new WTR_Select( array(
					'id'			=> $this->shortcode_id . '_size',
					'title'			=> __( 'Movie size', 'wtr_sht_framework' ),
					'desc'			=> '',
					'class'			=> 'ModalFields ReadStandard',
					'value'			=> '960-720',
					'default_value'	=> '',
					'info'			=> '',
					'allow'			=> 'all',
					'mod'			=> '',
					'option'		=> array('960-720' => __( 'Super big ( 960 x 720 )', 'wtr_sht_framework' ),
											 '640-480' => __( 'Big ( 640 x 480 )', 'wtr_sht_framework' ),
											 '480-360' => __( 'Medium ( 480 x 360 )', 'wtr_sht_framework' ),
											 '420-315' => __( 'Small ( 420 x 315 )', 'wtr_sht_framework' ),
											 'custom'  => __( 'Custom', 'wtr_sht_framework' )
										),
				)
			);
			array_push( $this->fields[ 'basic' ][ 'fields' ], $size );


			$w = new WTR_Text(array(
					'id'			=> $this->shortcode_id . '_width',
					'class'			=> 'ModalFields ReadStandard',
					'title'			=> __( 'Video width', 'wtr_sht_framework' ),
					'desc'			=> __( 'Enter a value for the width', 'wtr_sht_framework' ),
					'value'			=> '480',
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
					'value'			=> '360',
					'default_value'	=> '',
					'info'			=> '',
					'allow'			=> 'all',
					'dependency' 	=> array(	'element'	=> $this->shortcode_id . '_size',
												'value'		=> array( 'custom' ) ),
				)
			);
			array_push( $this->fields[ 'basic' ][ 'fields' ], $h );

			$resolution = new WTR_Select( array(
					'id'			=> $this->shortcode_id . '_resolution',
					'title'			=> __( 'Movie resolution', 'wtr_sht_framework' ),
					'desc'			=> '',
					'class'			=> 'ModalFields ReadStandard',
					'value'			=> 'small',
					'default_value'	=> '',
					'info'			=> __( 'If you select a higher resolution than available for this film,
											YouTube automatically select the highest available resolution', 'wtr_sht_framework' ),
					'allow'			=> 'all',
					'mod'			=> '',
					'option'		=> array('small'	=> __( 'Small - 240p', 'wtr_sht_framework' ),
											 'medium'	=> __( 'Medium - 360p', 'wtr_sht_framework' ),
											 'large'	=> __( 'Large - 480p', 'wtr_sht_framework' ),
											 'hd720'	=> __( 'HD Ready - 720p', 'wtr_sht_framework' ),
											 'hd1080'	=> __( 'Full HD - 1080p', 'wtr_sht_framework' )
										),
				)
			);
			array_push( $this->fields[ 'basic' ][ 'fields' ], $resolution );

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

			$theme = new WTR_Select( array(
					'id'			=> $this->shortcode_id . '_theme',
					'title'			=> __( 'Theme', 'wtr_sht_framework' ),
					'desc'			=> __( 'This parameter indicates whether the embedded player will display
											player controls (like a \'play\' button or volume control) within a dark
											or light control bar.', 'wtr_sht_framework' ),
					'class'			=> 'ModalFields ReadStandard',
					'value'			=> 'dark',
					'default_value' => '',
					'info'			=> '',
					'allow'			=> 'all',
					'mod'			=> '',
					'option'		=> array(	'dark' => __( 'Dark theme', 'wtr_sht_framework' ),
												'light' => __( 'Light theme', 'wtr_sht_framework' ) ),
				)
			);
			array_push( $this->fields[ 'basic' ][ 'fields' ], $theme );

			$color = new WTR_Select( array(
					'id'			=> $this->shortcode_id . '_color',
					'title'			=> __( 'Color', 'wtr_sht_framework' ),
					'desc'			=> __( 'This parameter specifies the color that will be used in the player\'s video
											progress bar to highlight the amount of the video that the viewer has
											already seen.', 'wtr_sht_framework' ),
					'class'			=> 'ModalFields ReadStandard',
					'value'			=> 'red',
					'default_value' => '',
					'info'			=> '',
					'allow'			=> 'all',
					'mod'			=> '',
					'option'		=> array(	'c_red' => __( 'Red', 'wtr_sht_framework' ),
												'c_white' => __( 'White', 'wtr_sht_framework' ) ),
				)
			);
			array_push( $this->fields[ 'basic' ][ 'fields' ], $color );

			array_push( $this->fields[ 'basic' ][ 'fields' ], $this->extraClassElement() );

			$autoplay = new WTR_Select( array(
					'id'			=> $this->shortcode_id . '_autoplay',
					'class'			=> 'ModalFields ReadStandard',
					'title'			=> __( 'Play the video automatically on load', 'wtr_sht_framework' ),
					'desc'			=> __( 'Sets whether or not the initial video will autoplay when the player
											loads.', 'wtr_sht_framework' ),
					'value'			=> '1',
					'default_value'	=> '',
					'info'			=> __( 'Note that this won’t work on some devices.', 'wtr_sht_framework' ),
					'allow'			=> 'all',
					'mod'			=> '',
					'option'		=> array(	'1' => __( 'On', 'wtr_sht_framework' ),
												'0' => __( 'Off', 'wtr_sht_framework' ) ),
					)
			);
			array_push( $this->fields[ 'advanced' ][ 'fields' ], $autoplay );

			$controls = new WTR_Select( array(
					'id'			=> $this->shortcode_id . '_controls',
					'class'			=> 'ModalFields ReadStandard',
					'title'			=> __( 'Show controls', 'wtr_sht_framework' ),
					'desc'			=> __( 'This parameter indicates whether the video player controls will
											display.', 'wtr_sht_framework' ),
					'value'			=> '1',
					'default_value'	=> '',
					'info'			=> '',
					'allow'			=> 'all',
					'mod'			=> '',
					'option'		=> array(	'1' => __( 'On', 'wtr_sht_framework' ),
												'0' => __( 'Off', 'wtr_sht_framework' ) ),
					)
			);
			array_push( $this->fields[ 'advanced' ][ 'fields' ], $controls );

			$showinfo = new WTR_Select( array(
					'id'			=> $this->shortcode_id . '_showinfo',
					'class'			=> 'ModalFields ReadStandard',
					'title'			=> __( 'Show info about author', 'wtr_sht_framework' ),
					'desc'			=> __( 'If you set the parameter value to "Off", then the player will not display
											information like the video title and uploader before the video starts
											playing.', 'wtr_sht_framework' ),
					'value'			=> '1',
					'default_value'	=> '',
					'info'			=> '',
					'allow'			=> 'all',
					'mod'			=> '',
					'option'		=> array(	'1' => __( 'On', 'wtr_sht_framework' ),
												'0' => __('Off', 'wtr_sht_framework' ) ),
					)
			);
			array_push( $this->fields[ 'advanced' ][ 'fields' ], $showinfo );


			$rel = new WTR_Select( array(
					'id'			=> $this->shortcode_id . '_rel',
					'class'			=> 'ModalFields ReadStandard',
					'title'			=> __( 'Show related videos', 'wtr_sht_framework' ),
					'desc'			=> __( 'This parameter indicates whether the player should show related videos when
											playback of the initial video ends.', 'wtr_sht_framework' ),
					'value'			=> '1',
					'default_value'	=> '',
					'info'			=> '',
					'allow'			=> 'all',
					'mod'			=> '',
					'option'		=> array(	'1' => __( 'On', 'wtr_sht_framework' ),
												'0' => __( 'Off', 'wtr_sht_framework' ) ),
					)
			);
			array_push( $this->fields[ 'advanced' ][ 'fields' ], $rel );

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
	}// end WTR_Shortcode_Youtube
}