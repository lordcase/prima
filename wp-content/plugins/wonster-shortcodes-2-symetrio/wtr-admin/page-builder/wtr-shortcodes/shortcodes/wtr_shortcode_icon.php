<?php
/**
 * @package Energizo
 * @author Wonster
 * @link http://wonster.co/
 */

// Don't load directly
if ( !defined('ABSPATH') ) { die('-1');}

include_once ( SHORTCODES_URL . '/wtr_shortcode_template.php' );


if ( ! class_exists( 'WTR_Shortcode_Icon' ) ) {

	class WTR_Shortcode_Icon extends  WTR_Shortcode_Template {

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
				'shortcode_id'	=> 'vc_wtr_icon',
				'end_el'		=> false,
				'name'			=> __('Icons', 'wtr_sht_framework' ),
				'icon'			=> 'ib-rocket',
				'shortcode'		=> 'WTR_Shortcode_Icon',
				'modal_size'	=> array( 'width' => 900, 'height' =>870, 'fullscreenW' => 'no', 'fullscreenH' => 'no' ),
				'prev_size'		=> array( 'width' =>800, 'height' => 600,  'fullscreenW' => 'no', 'fullscreenH' => 'no' ),
				'no_prev'			=> true
			);
		}// end sht_button


		protected function fillFields(){

			$circle = new WTR_Select( array(
					'id'			=> $this->shortcode_id . '_circle',
					'title'			=> __( 'Icon in circle', 'wtr_sht_framework' ),
					'desc'			=> '',
					'class'			=> 'ModalFields ReadStandard',
					'value'			=> 'off',
					'default_value' => '',
					'info'			=> '',
					'allow'			=> 'all',
					'mod'			=> '',
					'option'		=> array('on'	=> __( 'On', 'wtr_sht_framework' ),
											 'off'	=> __( 'Off', 'wtr_sht_framework' )
										),
				)
			);
			array_push( $this->fields[ 'basic' ][ 'fields' ], $circle );

			$circle_style = new WTR_Select( array(
					'id'			=> $this->shortcode_id . '_circle_style',
					'title'			=> __( 'Circle style', 'wtr_sht_framework' ),
					'desc'			=> '',
					'class'			=> 'ModalFields ReadStandard',
					'value'			=> 'style_1',
					'default_value' => '',
					'info'			=> '',
					'allow'			=> 'all',
					'mod'			=> '',
					'option'		=> array('1'	=> __( 'Style 1', 'wtr_sht_framework' ),
											 '2'	=> __( 'Style 2', 'wtr_sht_framework' ),
											 '3'	=> __( 'Style 3', 'wtr_sht_framework' ),
											 '8'	=> __( 'Style 4', 'wtr_sht_framework' ),
											 '9'	=> __( 'Style 5', 'wtr_sht_framework' )
										),
					'dependency'	=> array(	'element'	=> $this->shortcode_id . '_circle',
												'value'		=> array( 'on' ) )
				)
			);
			array_push( $this->fields[ 'basic' ][ 'fields' ], $circle_style );

			$version = new WTR_Select( array(
					'id'			=> $this->shortcode_id . '_version',
					'title'			=> __( 'Version', 'wtr_sht_framework' ),
					'desc'			=> __( 'Enable this option if you want to put this item on the background and make it
										more attractive', 'wtr_sht_framework' ),
					'class'			=> 'ModalFields ReadStandard',
					'value'			=> 'off',
					'default_value' => '',
					'info'			=> '',
					'allow'			=> 'all',
					'mod'			=> '',
					'option'		=> array('wtrShtIcoStandard'	=> __( 'Standard', 'wtr_sht_framework' ),
											 'wtrShtIcoLight'		=> __( 'Light', 'wtr_sht_framework' )
										),
					'dependency'	=> array(	'element'	=> $this->shortcode_id . '_circle',
												'value'		=> array( 'on' ) )
				)
			);
			array_push( $this->fields[ 'basic' ][ 'fields' ], $version );

			$url = new WTR_Text(array(
					'id'			=> $this->shortcode_id . '_url',
					'class'			=> 'ModalFields ReadStandard VCModUrl',
					'title'			=> __( 'Link URL', 'wtr_sht_framework' ),
					'desc'			=> __( 'Where should notification link to?', 'wtr_sht_framework' ),
					'value'			=> 'http://',
					'default_value' => '',
					'info'			=> __( '<b>Please fill full path</b>. Example: https://google.com', 'wtr_sht_framework' ),
					'allow'			=> 'all',
				)
			);
			array_push( $this->fields[ 'basic' ][ 'fields' ], $url );

			$target = new WTR_Select( array(
					'id'			=> $this->shortcode_id . '_target',
					'title'			=> __( 'Link target', 'wtr_sht_framework' ),
					'desc'			=> __( 'Select how do you want to open the linked page', 'wtr_sht_framework' ),
					'class'			=> 'ModalFields ReadStandard',
					'value'			=> '1',
					'default_value'	=> '',
					'info'			=> '',
					'allow'			=> 'all',
					'mod'			=> '',
					'option'		=> array('1' => __( 'Open in NEW window', 'wtr_sht_framework' ),
											 '0' => __( 'Open in SAME window', 'wtr_sht_framework' ),
										),
				)
			);
			array_push( $this->fields[ 'basic' ][ 'fields' ], $target );

			$type_icon = new WTR_Icon( array(
					'id'			=> $this->shortcode_id . '_type_icon',
					'title'			=> __( 'Icon', 'wtr_sht_framework' ),
					'desc'			=> __( 'Select the icon set', 'wtr_sht_framework' ),
					'class'			=> 'ModalFields ReadStandard',
					'value'			=> 'web|fa fa-check-square',
					'default_value' => '',
					'info'			=> '',
					'allow'			=> 'all',
					'mod'			=> '',
				)
			);
			array_push( $this->fields[ 'basic' ][ 'fields' ], $type_icon );

			$color = new WTR_Color( array(
					'id' => $this->shortcode_id . '_color',
					'class'			=> 'ModalFields ReadColorHash',
					'title'			=> __( 'Color', 'wtr_sht_framework' ),
					'desc'			=> __( 'Specify the color for your icon', 'wtr_sht_framework' ),
					'value'			=> '1fce6d',
					'default_value' => '',
					'info'			=> '',
					'allow'			=> 'all',
					'dependency'	=> array(	'element'	=> $this->shortcode_id . '_circle',
												'value'		=> array( 'off' ) )
				)
			);
			array_push( $this->fields[ 'basic' ][ 'fields' ], $color );

			$align = new WTR_Select( array(
					'id'			=> $this->shortcode_id . '_align',
					'title'			=> __( 'Align element', 'wtr_sht_framework' ),
					'desc'			=> __( 'Specify the alignment for your icon', 'wtr_sht_framework' ),
					'class'			=> 'ModalFields ReadStandard',
					'value'			=> 'none',
					'default_value' => '',
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

			$size = new WTR_Text(array(
					'id'			=> $this->shortcode_id . '_size',
					'class'			=> 'ModalFields ReadStandard',
					'title'			=> __( 'Size', 'wtr_sht_framework' ),
					'desc'			=> __( 'Specify the size of the selected icon. <b>Please, use only numeric signs</b>', 'wtr_sht_framework' ),
					'value'			=> 20,
					'default_value'	=> '',
					'info'			=> '',
					'allow'			=> 'all',
					'dependency'	=> array(	'element'	=> $this->shortcode_id . '_circle',
												'value'		=> array( 'off' ) )
				)
			);
			array_push( $this->fields[ 'basic' ][ 'fields' ], $size );


			$float = new WTR_Select( array(
					'id'			=> $this->shortcode_id . '_float',
					'class'			=> 'ModalFields ReadStandard',
					'title'			=> __( 'Float attribute', 'wtr_sht_framework' ),
					'desc'			=> '',
					'value'			=> '9',
					'default_value' => 'none',
					'info'			=> '',
					'allow'			=> 'all',
					'mod'			=> '',
					'option'		=> array( 'none'					=> __( 'None', 'wtr_sht_framework' ),
											  'wtrShtIconFloatLeft'		=> __( 'Left', 'wtr_sht_framework' ),
											  'wtrShtIconFloatRight'	=> __( 'Right', 'wtr_sht_framework' )
											),
				)
			);
			array_push( $this->fields[ 'basic' ][ 'fields' ], $float );

			array_push( $this->fields[ 'basic' ][ 'fields' ], $this->extraClassElement() );

			// add animation option
			$this->fields[ 'animation' ][ 'fields' ] = $this->animationOption();

			$type_external = new WTR_Hidden(array(
					'id'			=> 'type_external',
					'class'			=> 'ModalFields SaveOnly',
					'title'			=> '',
					'desc'			=> '',
					'value'			=> __CLASS__,
					'default_value' => '',
					'info'			=> '',
					'allow'			=> 'all',
				)
			);
			array_push( $this->fields[ 'basic' ][ 'fields' ], $type_external );
		}// end fillFields
	}// end WTR_Shortcode_Icon
}