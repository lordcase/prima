<?php
/**
 * @package Energizo
 * @author Wonster
 * @link http://wonster.co/
 */

// Don't load directly
if ( !defined('ABSPATH') ) { die('-1');}

include_once ( SHORTCODES_URL . '/wtr_shortcode_template.php' );


if ( ! class_exists( 'WTR_Shortcode_Gallery' ) ) {

	class WTR_Shortcode_Gallery extends  WTR_Shortcode_Template {

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
				'shortcode_id'	=> 'vc_wtr_gallery',
				'end_el'		=> false,
				'name'			=> __('Gallery', 'wtr_sht_framework' ),
				'icon'			=> 'ib-gallery',
				'shortcode'		=> 'WTR_Shortcode_Gallery',
				'modal_size'	=> array( 'width' => 900, 'height' =>600, 'fullscreenW' => 'no', 'fullscreenH' => 'no' ),
				'prev_size'		=> array( 'width' =>1000, 'height' => 850,  'fullscreenW' => 'no', 'fullscreenH' => 'no' ),
				'no_prev'			=> true
			);
		}// end sht_button


		protected function generateListGallery(){

			$args = array(
				'post_type'				=> 'gallery',
				'posts_per_page'		=> -1,
				'ignore_sticky_posts'	=> 1,
				'fields'				=> 'ids'
			);

			// The Query
			$posts	= get_posts( $args );
			$result	= array();

			if ( ! empty( $posts ) ){
				foreach ( $posts as $post ) {
					$nameGallery		= get_the_title( $post );
					$result[ $post ]	= ( trim( $nameGallery ) )? $nameGallery : __( 'no title', 'wtr_sht_framework' );
				}
			}

			if( !count( $result ) ) {
				$result = array( 'NN' => __( 'There are no galleries to choose from', 'wtr_sht_framework' ) );
			}
			return $result;
		}// end generateListGallery


		protected function fillFields(){

			$type = new WTR_Select( array(
					'id'			=> $this->shortcode_id . '_type',
					'title'			=> __( 'Type', 'wtr_sht_framework' ),
					'desc'			=> __( 'Choose the type of your gallery', 'wtr_sht_framework' ),
					'class'			=> 'ModalFields ReadStandard',
					'value'			=> 'metro',
					'default_value'	=> '',
					'info'			=> '',
					'allow'			=> 'all',
					'mod'			=> '',
					'option'		=> array(	'metro'	=> __( 'Metro', 'wtr_sht_framework' ),
												'flex_slider'	=> __( 'Flex slider', 'wtr_sht_framework' ),
										),
				)
			);
			array_push( $this->fields[ 'basic' ][ 'fields' ], $type );

			$id_gallery = new WTR_Select( array(
					'id'			=> $this->shortcode_id . '_id_gallery',
					'title'			=> __( 'Galleries', 'wtr_sht_framework' ),
					'desc'			=> __( 'Select a gallery to be attached to content', 'wtr_sht_framework' ),
					'class'			=> 'ModalFields ReadStandard',
					'value'			=> 'all',
					'default_value'	=> '',
					'info'			=> '',
					'allow'			=> 'all',
					'mod'			=> '',
					'option'		=> $this->generateListGallery(),
				)
			);
			array_push( $this->fields[ 'basic' ][ 'fields' ], $id_gallery );

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
	}// end WTR_Shortcode_Gallery
}