<?php
/**
 * @package Energizo
 * @author Wonster
 * @link http://wonster.co/
 */

// Don't load directly
if ( !defined('ABSPATH') ) { die('-1');}

include_once ( SHORTCODES_URL . '/wtr_shortcode_template.php' );


if ( ! class_exists( 'WTR_Shortcode_Notification' ) ) {

	class WTR_Shortcode_Notification extends  WTR_Shortcode_Template {

		// FUNCTION
		public function __construct(){

			parent::__construct();
			$this->fields = array(
				'basic'		=> array( 'name' => $this->fieldsGroup[ 'basic' ], 'fields' => array() ),
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
				'shortcode_id'	=> 'vc_wtr_notification',
				'end_el'		=> false,
				'name'			=> __('Notification', 'wtr_sht_framework' ),
				'icon'			=> 'ib-info',
				'shortcode'		=> 'WTR_Shortcode_Notification',
				'modal_size'	=> array( 'width' => 900, 'height' =>760, 'fullscreenW' => 'no', 'fullscreenH' => 'yes' ),
				'prev_size'		=> array( 'width' =>800, 'height' => 600,  'fullscreenW' => 'no', 'fullscreenH' => 'no' ),
				'no_prev'			=> true
			);
		}// end sht_button


		protected function fillFields(){

			// create fields list
			$info = new WTR_Text(array(
					'id'			=> $this->shortcode_id . '_info',
					'class'			=> 'ModalFields ReadStandard',
					'title'			=> __( 'Your message', 'wtr_sht_framework' ),
					'desc'			=> __( 'Notification message', 'wtr_sht_framework' ),
					'value'			=> __( 'Information', 'wtr_sht_framework' ),
					'default_value'	=> '',
					'info'			=> '',
					'allow'			=> 'all',
				)
			);
			array_push( $this->fields[ 'basic' ][ 'fields' ], $info );

			$color = new WTR_Select( array(
					'id'			=> $this->shortcode_id . '_color',
					'title'			=> __( 'Color', 'wtr_sht_framework' ),
					'desc'			=> __( 'Specify the color for your notification message', 'wtr_sht_framework' ),
					'class'			=> 'ModalFields ReadStandard',
					'value'			=> 'c_green',
					'default_value' => '',
					'info'			=> '',
					'allow'			=> 'all',
					'mod'			=> '',
					'option'		=> array('c_green'			=> __( 'Green', 'wtr_sht_framework' ),
											 'c_yellow'			=> __( 'Yellow', 'wtr_sht_framework' ),
											 'c_blue'			=> __( 'Blue', 'wtr_sht_framework' ),
											 'c_red'			=> __( 'Red', 'wtr_sht_framework' ),
											 'c_grey'			=> __( 'Grey', 'wtr_sht_framework' ),
											 'c_transparent'	=> __( 'White', 'wtr_sht_framework' ),
										),
				)
			);
			array_push( $this->fields[ 'basic' ][ 'fields' ], $color );

			$align = new WTR_Select( array(
					'id'			=> $this->shortcode_id . '_align',
					'title'			=> __( 'Align text', 'wtr_sht_framework' ),
					'desc'			=> __( 'Specify the alignment for your message', 'wtr_sht_framework' ),
					'class'			=> 'ModalFields ReadStandard',
					'value'			=> 'left',
					'default_value'	=> '',
					'info'			=> '',
					'allow'			=> 'all',
					'mod'			=> '',
					'option'		=> array('wtrShtAlignLeft'		=> __( 'Left', 'wtr_sht_framework' ),
											 'wtrShtAlignCenter'	=> __( 'Center', 'wtr_sht_framework' ),
											 'wtrShtAlignRight'		=> __( 'Right', 'wtr_sht_framework' )
										),
				)
			);
			array_push( $this->fields[ 'basic' ][ 'fields' ], $align );

			$icon_status = new WTR_Select( array(
					'id'			=> $this->shortcode_id . '_icon_status',
					'title'			=> __( 'Notification icon', 'wtr_sht_framework' ),
					'desc'			=> __( 'Specify the visibility of an icon (icon will display on the left before text)', 'wtr_sht_framework' ),
					'class'			=> 'ModalFields ReadStandard',
					'value'			=> '0',
					'default_value' => '',
					'info'			=> '',
					'allow'			=> 'all',
					'mod'			=> '',
					'option'		=> array( '0' => __( 'No icon', 'wtr_sht_framework' ),
											  '1' => __( 'Yes ,display icon', 'wtr_sht_framework' )
										),
				)
			);
			array_push( $this->fields[ 'basic' ][ 'fields' ], $icon_status );

			$type_icon = new WTR_Icon( array(
					'id'			=> $this->shortcode_id . '_icon',
					'title'			=> __( 'Icon', 'wtr_sht_framework' ),
					'desc'			=> __( 'Select the icon set', 'wtr_sht_framework' ),
					'class'			=> 'ModalFields ReadStandard',
					'value'			=> 'web|fa fa-check-circle-o',
					'default_value'	=> '',
					'info'			=> '',
					'allow'			=> 'all',
					'mod'			=> '',
					'dependency' => array(	'element' => $this->shortcode_id . '_icon_status',
											'value' => array( '1' ) )
				)
			);
			array_push( $this->fields[ 'basic' ][ 'fields' ], $type_icon );

			$link_status = new WTR_Select( array(
					'id'			=> $this->shortcode_id . '_link_status',
					'title'			=> __( 'Notification link', 'wtr_sht_framework' ),
					'desc'			=> __( 'Is the notification message will contain a link?', 'wtr_sht_framework' ),
					'class'			=> 'ModalFields ReadStandard',
					'value'			=> '0',
					'default_value'	=> '',
					'info'			=> '',
					'allow'			=> 'all',
					'mod'			=> '',
					'option'		=> array('0' => 'No',
											 '1' => 'Yes'
										),
				)
			);
			array_push( $this->fields[ 'basic' ][ 'fields' ], $link_status );

			// create fields list
			$anhor = new WTR_Text(array(
					'id'			=> $this->shortcode_id . '_anhor',
					'class'			=> 'ModalFields ReadStandard',
					'title'			=> __( 'Link tittle.', 'wtr_sht_framework' ),
					'desc'			=> __( 'This is the text that appears on your link.', 'wtr_sht_framework' ),
					'value'			=> __( 'Click me', 'wtr_sht_framework' ),
					'default_value' => '',
					'info'			=> '',
					'allow'			=> 'all',
					'dependency' => array(	'element' => $this->shortcode_id . '_link_status',
											'value' => array( '1' ) )
				)
			);
			array_push( $this->fields[ 'basic' ][ 'fields' ], $anhor );

			$url = new WTR_Text(array(
					'id'			=> $this->shortcode_id . '_url',
					'class'			=> 'ModalFields ReadStandard VCModUrl',
					'title'			=> __( 'Link URL', 'wtr_sht_framework' ),
					'desc'			=> __( 'Where should notification link to?', 'wtr_sht_framework' ),
					'value'			=> 'http://',
					'default_value' => '',
					'info'			=> __( '<b>Please fill full path</b>. Example: https://google.com', 'wtr_sht_framework' ),
					'allow'			=> 'all',
					'dependency' => array(	'element' => $this->shortcode_id . '_link_status',
											'value' => array( '1' ) )
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
					'dependency' => array(	'element' => $this->shortcode_id . '_link_status',
											'value' => array( '1' ) )
				)
			);
			array_push( $this->fields[ 'basic' ][ 'fields' ], $target );

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
	}// end WTR_Shortcode_Notification
}

