<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

// Don't load directly
if ( !defined('ABSPATH') ) { die('-1');}

include_once ( SHORTCODES_URL . '/wtr_shortcode_template.php' );

if ( ! class_exists( 'WTR_Shortcode_Divider' ) ) {

	class WTR_Shortcode_Divider extends  WTR_Shortcode_Template {


		// FUNCTION
		public function __construct(){

			parent::__construct();
			$this->fields = array(
				'basic'		=> array( 'name' => $this->fieldsGroup[ 'basic' ], 'fields' => array() ),
				'animation'	=> array( 'name' => $this->fieldsGroup[ 'animation' ], 'fields' => array() )
			);

			//init obj
			$this->createEl( self::sht_button() );

			// fill fields
			$this->fillFields();

			parent::__construct();
		}//end __construct


		public static function sht_button( $version = null )
		{
			return array(
				'shortcode_id'	=> 'vc_wtr_divider',
				'end_el'		=> false,
				'name'			=> __('Divider', 'wtr_sht_framework' ),
				'icon'			=> 'ib-divider',
				'shortcode'		=> 'WTR_Shortcode_Divider',
				'modal_size'	=> array( 'width' => 710, 'height' => 885, 'fullscreenW' => 'no', 'fullscreenH' => 'no'  ),
				'prev_size'		=> array( 'width' =>800, 'height' => 600,  'fullscreenW' => 'no', 'fullscreenH' => 'no' ),
				'no_prev'			=> true
			);
		}// end sht_button


		protected function fillFields(){

			// create fields list
			$type = new WTR_Select( array(
					'id'			=> $this->shortcode_id . '_type',
					'class'			=> 'ModalFields ReadStandard',
					'title'			=> __( 'Divider style', 'wtr_sht_framework' ),
					'desc'			=> '',
					'value'			=> 'standard',
					'default_value'	=> '',
					'info'			=> '',
					'allow'			=> 'all',
					'mod'			=> '',
					'option'		=> array('invisible'	=> __( 'Invisible', 'wtr_sht_framework' ),
											 'line'			=> __( 'Line', 'wtr_sht_framework' ),
											 'dots'			=> __( 'Dots', 'wtr_sht_framework' ),
											 'dashed'		=> __( 'Dashed', 'wtr_sht_framework' ),
											 'peaks'		=> __( 'Peaks', 'wtr_sht_framework' ),
											 'icon'			=> __( 'Icon', 'wtr_sht_framework' ),
										),
				)
			);
			array_push( $this->fields[ 'basic' ][ 'fields' ], $type );

			$divider_align = new WTR_Select( array(
					'id'			=> $this->shortcode_id . '_divider_align',
					'class'			=> 'ModalFields ReadStandard',
					'title'			=> 'Divider align',
					'desc'			=> '',
					'value'			=> 'standard',
					'default_value'	=> '',
					'info'			=> '',
					'allow'			=> 'all',
					'mod'			=> '',
					'option'		=> array('left'		=> __( 'Left', 'wtr_sht_framework' ),
											 'center'	=> __( 'Center', 'wtr_sht_framework' ),
											 'right'	=> __( 'Right', 'wtr_sht_framework' )
										),
					'dependency' 	=> array(	'element'	=> $this->shortcode_id . '_type',
												'value'		=> array( 'line', 'dots', 'dashed', 'peaks', 'icon' ) )
				)
			);
			array_push( $this->fields[ 'basic' ][ 'fields' ], $divider_align );

			$height = new WTR_Text(array(
					'id'			=> $this->shortcode_id . '_height',
					'class'			=> 'ModalFields ReadStandard',
					'title'			=> __( 'Height', 'wtr_sht_framework' ),
					'desc'			=> __( 'Value must be a number', 'wtr_sht_framework' ),
					'value'			=> '10',
					'default_value'	=> '',
					'info'			=> '',
					'allow'			=> 'all',
					'dependency' 	=> array(	'element'	=> $this->shortcode_id . '_type',
												'value'		=> array( 'invisible', 'line' ) )
				)
			);
			array_push( $this->fields[ 'basic' ][ 'fields' ], $height );

			$width_p = new WTR_Select( array(
					'id'			=> $this->shortcode_id . '_width_p',
					'class'			=> 'ModalFields ReadStandard',
					'title'			=> __( 'Width (expressed as a percentage)', 'wtr_sht_framework' ),
					'desc'			=> '',
					'value'			=> 'standard',
					'default_value'	=> '',
					'info'			=> '',
					'allow'			=> 'all',
					'mod'			=> '',
					'option'		=> array(	'100'	=> __( '100 %', 'wtr_sht_framework' ),
												'90'	=> __( '90 %', 'wtr_sht_framework' ),
												'80'	=> __( '80 %', 'wtr_sht_framework' ),
												'70'	=> __( '70 %', 'wtr_sht_framework' ),
												'60'	=> __( '60 %', 'wtr_sht_framework' ),
												'50'	=> __( '50 %', 'wtr_sht_framework' ),
												'40'	=> __( '40 %', 'wtr_sht_framework' ),
												'30'	=> __( '30 %', 'wtr_sht_framework' ),
												'20'	=> __( '20 %', 'wtr_sht_framework' ),
												'10'	=> __( '10 %', 'wtr_sht_framework' ),
										),
					'dependency' 	=> array(	'element'	=> $this->shortcode_id . '_type',
												'value'		=> array( 'line', 'icon' ) )
				)
			);
			array_push( $this->fields[ 'basic' ][ 'fields' ], $width_p );

			$width_q = new WTR_Text(array(
					'id'			=> $this->shortcode_id . '_width_q',
					'class'			=> 'ModalFields ReadStandard',
					'title'			=> __( 'Width (expressed as a quantitatively)', 'wtr_sht_framework' ),
					'desc'			=> __( 'Value must be a number eg.  10', 'wtr_sht_framework' ),
					'value'			=> '10',
					'default_value'	=> '',
					'info'			=> '',
					'allow'			=> 'all',
				'dependency' 	=> array(	'element'	=> $this->shortcode_id . '_type',
											'value'		=> array( 'dots', 'dashed', 'peaks' ) )
				)
			);
			array_push( $this->fields[ 'basic' ][ 'fields' ], $width_q );

			$color_line = new WTR_Color( array(
					'id' => $this->shortcode_id . '_color_line',
					'class'			=> 'ModalFields ReadColorHash',
					'title'			=> __( 'Line color', 'wtr_sht_framework' ),
					'desc'			=> '',
					'value'			=> '#e5e5e5',
					'default_value'	=> '',
					'info'			=> '',
					'allow'			=> 'all',
					'dependency' 	=> array(	'element'	=> $this->shortcode_id . '_type',
												'value'		=> array( 'line', 'icon' ) )
				)
			);
			array_push( $this->fields[ 'basic' ][ 'fields' ], $color_line );

			$color_element = new WTR_Color( array(
					'id' => $this->shortcode_id . '_color_element',
					'class'			=> 'ModalFields ReadColorHash',
					'title'			=> __( 'Color element', 'wtr_sht_framework' ),
					'desc'			=> '',
					'value'			=> '#1fce6d',
					'default_value'	=> '',
					'info'			=> '',
					'allow'			=> 'all',
					'dependency' 	=> array(	'element'	=> $this->shortcode_id . '_type',
												'value'		=> array( 'dots', 'dashed', 'peaks' ) )
				)
			);
			array_push( $this->fields[ 'basic' ][ 'fields' ], $color_element );

			$color_icon = new WTR_Color( array(
					'id' => $this->shortcode_id . '_color_icon',
					'class'			=> 'ModalFields ReadColorHash',
					'title'			=> __( 'Icon color', 'wtr_sht_framework' ),
					'desc'			=> '',
					'value'			=> '#1fce6d',
					'default_value'	=> '',
					'info'			=> '',
					'allow'			=> 'all',
					'dependency' 	=> array(	'element'	=> $this->shortcode_id . '_type',
												'value'		=> array( 'icon' ) )
				)
			);
			array_push( $this->fields[ 'basic' ][ 'fields' ], $color_icon );

			$icon_align = new WTR_Select( array(
					'id'			=> $this->shortcode_id . '_icon_align',
					'class'			=> 'ModalFields ReadStandard',
					'title'			=> __( 'Icon align', 'wtr_sht_framework' ),
					'desc'			=> '',
					'value'			=> 'standard',
					'default_value'	=> '',
					'info'			=> '',
					'allow'			=> 'all',
					'mod'			=> '',
					'option'		=> array('left'		=> __( 'Left', 'wtr_sht_framework' ),
											 'center'	=> __( 'Center', 'wtr_sht_framework' ),
											 'right'	=> __( 'Right', 'wtr_sht_framework' )
										),
					'dependency' 	=> array(	'element'	=> $this->shortcode_id . '_type',
												'value'		=> array( 'icon' ) )
				)
			);
			array_push( $this->fields[ 'basic' ][ 'fields' ], $icon_align );

			$icon = new WTR_Icon( array(
					'id'			=> $this->shortcode_id . '_icon',
					'title'			=> __( 'Icon', 'wtr_sht_framework' ),
					'desc'			=> __( 'Select the icon set', 'wtr_sht_framework' ),
					'class'			=> 'ModalFields ReadStandard',
					'value'			=> 'web|fa fa-check',
					'default_value' => '',
					'info'			=> '',
					'allow'			=> 'all',
					'mod'			=> '',
					'dependency' => array(	'element'	=> $this->shortcode_id . '_type',
											'value'		=> array( 'icon' ) )
				)
			);
			array_push( $this->fields[ 'basic' ][ 'fields' ], $icon );


			array_push( $this->fields[ 'basic' ][ 'fields' ], $this->extraClassElement() );

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
	}// end WTR_Shortcode_Divider
}