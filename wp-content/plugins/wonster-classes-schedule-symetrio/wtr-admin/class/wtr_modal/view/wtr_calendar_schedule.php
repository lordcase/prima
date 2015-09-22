<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

// Don't load directly
if ( !defined('ABSPATH') ) { die('-1'); }

include_once ( 'wtr_modal_backbone.php' );

if ( ! class_exists( 'wtr_calendar_schedule' ) ) {

	class wtr_calendar_schedule extends  WTR_Modal_Backbone {

		// VARIABLES
		private $obj;
		private $fullscreenModeW;
		private $fullscreenModeH;
		private $width;
		private $height;
		private $data;
		private $drawContent;

		// FUNCTION
		public function __construct( $mode ){

			parent::__construct();
			$this->fields = array(
				'basic'		=> array( 'name' => $this->fieldsGroup[ 'basic' ], 'fields' => array() ),
			);

			// init obj
			$this->createEl( self::sht_button( $mode ) );

			// fill fields
			$this->fillFields( $mode );

			parent::__construct();
		}// end __construct


		public static function sht_button( $mode = null )
		{
			return array(
				'name'			=> __('Calendar', 'wtr_cs_framework' ),
				'title'			=> ( 'new' == $mode )? __( 'Add new', 'wtr_cs_framework' ) : __( 'Edit', 'wtr_cs_framework' ),
				'modal_size'	=> array( 'width' => 900, 'height' =>600, 'fullscreenW' => 'no', 'fullscreenH' => 'no' ),
			);
		}// end sht_button


		public function getGymLocation(){

			$config = array(
				'post_type'				=> 'gym_location',
				'posts_per_page'		=> -1,
				'ignore_sticky_posts'	=> 1,
				'wtr_add_all_item'		=> true,
			);
			$result	= array();

			if( $config[ 'wtr_add_all_item' ] ){
				$result	= array( 'wtr_all_items' => __( 'Include all', 'wtr_cs_framework' ) );
			}

			// The Query
			$the_query	= new WP_Query( $config );

			if ( $the_query->have_posts() ){
				while ( $the_query->have_posts() ){
					$the_query->the_post();
					$name = get_the_title();
					$index = ( trim( $name ) )? $name: __( 'no title', 'wtr_cs_framework' );
					$result[ get_the_id() ] = $index;
				}
			}

			/* Restore original Post Data */
			wp_reset_postdata();

			if( !count( $result ) ) {
				$result = array( 'NN' => __( 'There is no item to choose from', 'wtr_cs_framework' ) );
			}
			return $result;
		}//end generateListGymLocation


		protected function fillFields( $mode )
		{
			$name = new WTR_Text(array(
					'id'			=> 'name',
					'class'			=> 'ModalFields ReadStandard',
					'title'			=> __( 'Calendar name', 'wtr_cs_framework' ),
					'desc'			=> '',
					'value'			=> 'My new calendar',
					'default_value'	=> '',
					'info'			=> '',
					'allow'			=> 'all',
				)
			);
			array_push( $this->fields[ 'basic' ][ 'fields' ], $name );

			if( 'new' == $mode ){
				$isHide = '';
			}else if( 'edit' == $mode ){
				$isHide = 'ModalHide';
			}

			$time_format = new WTR_Select( array(
					'id'			=> 'time_format',
					'title'			=> __( 'Time format', 'wtr_cs_framework' ),
					'desc'			=> '',
					'class'			=> 'ModalFields ReadStandard',
					'value'			=> 'static',
					'default_value'	=> '',
					'info'			=> '',
					'allow'			=> 'all',
					'mod'			=> '',
					'option'		=> array(	'24'	=> __( '24 H', 'wtr_cs_framework' ),
												'12'	=> __( '12 AM / PM', 'wtr_cs_framework' ),
										),
				)
			);
			array_push( $this->fields[ 'basic' ][ 'fields' ], $time_format );

			$type = new WTR_Select( array(
					'id'			=> 'type',
					'title'			=> __( 'Type', 'wtr_cs_framework' ),
					'desc'			=> '',
					'class'			=> 'ModalFields ReadStandard ' . $isHide,
					'value'			=> 'static',
					'default_value'	=> '',
					'info'			=> '',
					'allow'			=> 'all',
					'mod'			=> '',
					'option'		=> array(	'static'		=>__( 'Static', 'wtr_cs_framework' ),
												'multi_week'	=> __( 'Multi week', 'wtr_cs_framework' ),
										),
				)
			);
			array_push( $this->fields[ 'basic' ][ 'fields' ], $type );

			$show_event = new WTR_Select( array(
					'id'			=> 'show_event',
					'title'			=> __( 'Show event', 'wtr_cs_framework' ),
					'desc'			=> '',
					'class'			=> 'ModalFields ReadStandard',
					'value'			=> '0',
					'default_value'	=> '',
					'info'			=> '',
					'allow'			=> 'all',
					'mod'			=> '',
					'option'		=> array(	'1'	=>__( 'Yes', 'wtr_cs_framework' ),
												'0'	=> __( 'No', 'wtr_cs_framework' ),
										),
					'dependency' 	=> array(	'element'	=> 'type',
												'value'		=> array( 'multi_week' ) )
				)
			);
			array_push( $this->fields[ 'basic' ][ 'fields' ], $show_event );

			$show_event = new WTR_Select( array(
					'id'			=> 'gym_id',
					'title'			=> __( 'Select the location which from we display events', 'wtr_cs_framework' ),
					'desc'			=> '',
					'class'			=> 'ModalFields ReadStandard',
					'value'			=> '0',
					'default_value'	=> '',
					'info'			=> '',
					'allow'			=> 'all',
					'mod'			=> '',
					'option'		=> $this->getGymLocation(),
					'dependency' 	=> array(	'element'	=> 'show_event',
												'value'		=> array( '1' ) )
				)
			);
			array_push( $this->fields[ 'basic' ][ 'fields' ], $show_event );

			$view = new WTR_Hidden(array(
					'id'			=> 'view_controler',
					'class'			=> 'ModalFields ReadStandard',
					'title'			=> '',
					'desc'			=> '',
					'value'			=> 'wtr_calendar_schedule',
					'default_value'	=> '',
					'info'			=> '',
					'allow'			=> 'all',
				)
			);
			array_push( $this->fields[ 'basic' ][ 'fields' ], $view );

			$mode_type = new WTR_Hidden(array(
					'id'			=> 'mode_type_controler',
					'class'			=> 'ModalFields ReadStandard',
					'title'			=> '',
					'desc'			=> '',
					'value'			=> $mode,
					'default_value'	=> '',
					'info'			=> '',
					'allow'			=> 'all',
				)
			);
			array_push( $this->fields[ 'basic' ][ 'fields' ], $mode_type );

			if( 'edit' == $mode ){
				$id_timetable = new WTR_Hidden(array(
						'id'			=> 'id_timetable',
						'class'			=> 'ModalFields ReadStandard',
						'title'			=> '',
						'desc'			=> '',
						'value'			=> '',
						'default_value'	=> '',
						'info'			=> '',
						'allow'			=> 'all',
					)
				);
				array_push( $this->fields[ 'basic' ][ 'fields' ], $id_timetable );
			}
		}// end fillFields
	}//end wtr_calendar_schedule
}
