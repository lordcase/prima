<?php
/**
 * @package Energizo
 * @author Wonster
 * @link http://wonster.co/
 */

// Don't load directly
if ( !defined('ABSPATH') ) { die('-1');}

include_once ( SHORTCODES_URL . '/wtr_shortcode_template.php' );


if ( ! class_exists( 'WTR_Shortcode_List' ) ) {

	class WTR_Shortcode_List extends  WTR_Shortcode_Template {

		// FUNCTION
		public function __construct( $mod = '0' ){

			parent::__construct();
			$this->fields = array(
				'basic'		=> array( 'name' => $this->fieldsGroup[ 'basic' ], 'fields' => array() ),
				'animation'	=> array( 'name' => $this->fieldsGroup[ 'animation' ], 'fields' => array() )
			);

			$this->$mod		= $mod;

			// init obj
			$this->createEl( self::sht_button() );

			// fill fields
			if( '0' == $this->$mod || 'pb' == $this->$mod ){
				$this->fillFields();
			} else if ( 'properties' == $this->$mod ){
				$this->propertiesItemSortable();
			}
		}// end __construct


		public static function sht_button( $version = null )
		{
			return array(
				'shortcode_id'	=> 'vc_wtr_custom_list',
				'shordcode_extra_id'	=> array( 'wtr_list_item' ),
				'end_el'		=> true,
				'name'			=>  __('Custom List', 'wtr_sht_framework' ),
				'icon'			=> 'ib-list',
				'shortcode'		=> 'WTR_Shortcode_List',
				'modal_size'	=> array( 'width' =>900, 'height' => 625,  'fullscreenW' => 'no', 'fullscreenH' => 'yes' ),
				'prev_size'		=> array( 'width' =>800, 'height' => 600,  'fullscreenW' => 'no', 'fullscreenH' => 'no' ),
				'no_prev'			=> true
			);
		}// end sht_button


		protected function fillFields(){

			$option_prev		= $this->shortcode_id . '_content';
			$optionItem			= array( 0 => array( $this->shortcode_id . '_type_icon' => array( 'value' => 'web|fa fa-check-square' ), $this->shortcode_id . '_content' => array( 'value' => __( 'Please insert code here', 'wtr_sht_framework' ) ), $this->shortcode_id . '_color' => array( 'value' => '1fce6d' ) ),
										 1 => array( $this->shortcode_id . '_type_icon' => array( 'value' => 'web|fa fa-check-square' ), $this->shortcode_id . '_content' => array( 'value' => __( 'Please insert code here', 'wtr_sht_framework' ) ), $this->shortcode_id . '_color' => array( 'value' => '1fce6d' ) ),
									);
			$optionItemDefault	= array( 0 => array( $this->shortcode_id . '_type_icon' => array( 'value' => 'web|fa fa-check-square' ), $option_prev => array( 'value' => __( 'Please insert code here', 'wtr_sht_framework' ) ), $this->shortcode_id . '_color' => array( 'value' => '1fce6d' ) ) );
			$opt_child_sht		= $this->shortcode_id . '_item';
			$opt_child_end		= true;

			$option = new WTR_Sortable( array(
					'id'					=> $this->shortcode_id . '_option',
					'title'					=> __( 'Add/Edit the item to the list', 'wtr_sht_framework' ),
					'desc'					=> __( 'Here you can add, edit, remove and change order of your list items.', 'wtr_sht_framework' ),
					'class'					=> 'ModalFields SortableObj',
					'value'					=> '',
					'default_value'			=> '',
					'info'					=> '',
					'allow'					=> 'all',
					'min_one'				=> 1,
					'max_one'				=> 999,
					'control'				=> true,
					'mod'					=> '',
					'type'					=> $this->shortcode,
					'modal_child_size'		=> array( 'width' => $this->modal_size[ 'width' ], 'height' => 860,  'fullscreenw' => 'no', 'fullscreenh' => 'yes' ),
					'default_option'		=> $optionItemDefault,
					'default_shortcode'		=> $this->getDefaultShortcodeItem( $optionItemDefault, $this->shortcode_id , $opt_child_sht, $opt_child_end ),
					'defautl_rewrite'		=> array(),
					'option'				=> $optionItem,
					'option_shortcode'		=> $this->getDefaultShortcodeItem( $optionItem, $this->shortcode_id , $opt_child_sht, $opt_child_end ),
					'option_prev'			=> $option_prev,
					'child_shortcode'		=> $opt_child_sht,
					'child_end_el'			=> $opt_child_end,
					'zero_item'				=> ''
				)
			);
			array_push( $this->fields[ 'basic' ][ 'fields' ], $option );

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


		protected function propertiesItemSortable(){

			$color_icon = new WTR_Color( array(
					'id' => $this->shortcode_id . '_color_icon',
					'class'			=> 'ModalFields ReadColorHash',
					'title'			=> __( 'Icon color', 'wtr_sht_framework' ),
					'desc'			=> __( 'Specify the color of your divider', 'wtr_sht_framework' ),
					'value'			=> 'ffffff',
					'default_value'	=> '',
					'info'			=> '',
					'allow'			=> 'all',
				)
			);
			array_push( $this->fields[ 'basic' ][ 'fields' ], $color_icon );


			$color_background = new WTR_Color( array(
					'id' => $this->shortcode_id . '_color_background',
					'class'			=> 'ModalFields ReadColorHash',
					'title'			=> __( 'Background color', 'wtr_sht_framework' ),
					'desc'			=> __( 'Specify the color of your divider', 'wtr_sht_framework' ),
					'value'			=> '1fce6d',
					'default_value'	=> '',
					'info'			=> '',
					'allow'			=> 'all',
				)
			);
			array_push( $this->fields[ 'basic' ][ 'fields' ], $color_background );

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

			$data_content = new WTR_Textarea( array(
					'id'			=> $this->shortcode_id . '_content',
					'class'			=> 'ModalFields Tinymce',
					'rows'			=> 16,
					'title'			=> __( 'List item content', 'wtr_sht_framework' ),
					'desc'			=> __( 'Enter some content here', 'wtr_sht_framework' ),
					'value'			=> '',
					'default_value' => '',
					'info'			=> '',
					'allow'			=> 'all',
					'mod'			=> 'tinymce'
				)
			);
			array_push( $this->fields[ 'basic' ][ 'fields' ], $data_content );
		}// end editItemSortable


		private function getDefaultShortcodeItem( $opt, $base_type, $type, $end ){

			$resut	= array();
			$optC	= count( $opt );

			for( $i= 0; $i < $optC; ++$i ){
				$tmp		= '';
				$content	= '';
				$tmp_attr	= array();

				foreach( $opt[ $i ] as $l => $r ){
					$name = str_replace( $base_type .'_', '', $l );

					if( 'content' != $name ){
						array_push( $tmp_attr, $name . '="' . $r[ 'value' ] . '"' );
					} else {
						$content = $r['value'];
					}
				}

				$pattern = '[' . $type .  ' ' . join( ' ', $tmp_attr ) . ']';

				if( strlen( $content ) ){
					$pattern .= $content;
				}

				if($end) {
					$pattern .= '[/' . $type . ']';
				}

				$resut[ $i ] = esc_attr( $pattern );
			}
			return $resut;
		}// end getDefaultShortcodeItem
	}// end WTR_Shortcode_List
}