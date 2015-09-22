<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

// Don't load directly
if ( !defined('ABSPATH') ) { die('-1'); }

include_once ( 'wtr_modal_backbone.php' );

if ( ! class_exists( 'wtr_calendar_scope' ) ) {

	class wtr_calendar_scope extends  WTR_Modal_Backbone {

		// VARIABLES
		private $obj;
		private $fullscreenModeW;
		private $fullscreenModeH;
		private $width;
		private $height;
		private $data;
		private $drawContent;
		private $calendarData;

		// FUNCTION
		public function __construct( $mode , $param ){

			parent::__construct();
			$this->fields = array(
				'basic'		=> array( 'name' => $this->fieldsGroup[ 'basic' ], 'fields' => array() ),
			);

			// init obj
			$this->createEl( self::sht_button( $mode ) );

			// fill fields
			$this->fillFields( $mode, $param );

			parent::__construct();
		}// end __construct


		public static function sht_button( $mode = null )
		{
			return array(
				'name'			=> __('Scope', 'wtr_cs_framework' ),
				'title'			=> ( 'new' == $mode )? __( 'Add new', 'wtr_cs_framework' ) : __( 'Edit', 'wtr_cs_framework' ),
				'modal_size'	=> array( 'width' => 900, 'height' =>600, 'fullscreenW' => 'no', 'fullscreenH' => 'no' ),
			);
		}// end sht_button


		protected function fillFields( $mode, $param )
		{
			if( 'new' == $mode ){
				$isHide = '';
			}else if( 'edit' == $mode ){
				$isHide = 'ModalHide';
			}

			if( 'edit' == $mode ){
				$overwrite = new WTR_Select( array(
						'id'			=> 'overwrite',
						'title'			=> __( 'Overwrite', 'wtr_cs_framework' ),
						'desc'			=> __( 'This function will overwrite the settings of all instances belonging to the scope you are editing.', 'wtr_cs_framework' ),
						'class'			=> 'ModalFields ReadStandard',
						'value'			=> '0',
						'default_value'	=> '',
						'info'			=> '',
						'allow'			=> 'all',
						'mod'			=> '',
						'option'		=> array(
							'0'	=> __( 'NO', 'wtr_cs_framework' ),
							'1'	=> __( 'YES', 'wtr_cs_framework' ),
						),
					)
				);
				array_push( $this->fields[ 'basic' ][ 'fields' ], $overwrite );

				$id_scope = new WTR_Hidden(array(
						'id'			=> 'id_scope',
						'class'			=> 'ModalFields ReadStandard',
						'title'			=> '',
						'desc'			=> '',
						'value'			=> $mode,
						'default_value'	=> '',
						'info'			=> '',
						'allow'			=> 'all',
					)
				);
				array_push( $this->fields[ 'basic' ][ 'fields' ], $id_scope );
			}

			$start_date = new WTR_Datepicker(array(
					'id'			=> 'start_date',
					'class'			=> 'ModalFields ReadStandard ' . $isHide,
					'title'			=> __( 'Scope - start', 'wtr_cs_framework' ),
					'desc'			=> '',
					'value'			=> date( 'Y-m-d' ),
					'default_value'	=> '',
					'info'			=> '',
					'allow'			=> 'all',
					'rande'			=> array( 'start' => date( 'Y' ), 'end' => date( 'Y' ) + 10 )
				)
			);
			array_push( $this->fields[ 'basic' ][ 'fields' ], $start_date );

			$end_date = new WTR_Datepicker(array(
					'id'			=> 'end_date',
					'class'			=> 'ModalFields ReadStandard ' . $isHide,
					'title'			=> __( 'Scope - start', 'wtr_cs_framework' ),
					'desc'			=> '',
					'value'			=> date( 'Y-m-d' ),
					'default_value'	=> '',
					'info'			=> '',
					'allow'			=> 'all',
					'rande'			=> array( 'start' => date( 'Y' ), 'end' => date( 'Y' ) + 10 )
				)
			);
			array_push( $this->fields[ 'basic' ][ 'fields' ], $end_date );

			$day_of_the_week = new WTR_Select( array(
					'id'			=> 'day_of_the_week',
					'title'			=> __( 'Days', 'wtr_cs_framework' ),
					'desc'			=> '',
					'class'			=> 'ModalFields ReadStandard ' . $isHide,
					'value'			=> '',
					'default_value'	=> '',
					'info'			=> '',
					'allow'			=> 'all',
					'mod'			=> '',
					'option'		=> array(
						'0'	=> __( 'Monday', 'wtr_cs_framework' ),
						'1'	=> __( 'Tuesday', 'wtr_cs_framework' ),
						'2'	=> __( 'Wednesday', 'wtr_cs_framework' ),
						'3'	=> __( 'Thursday', 'wtr_cs_framework' ),
						'4'	=> __( 'Friday', 'wtr_cs_framework' ),
						'5'	=> __( 'Saturday', 'wtr_cs_framework' ),
						'6'	=> __( 'Sunday', 'wtr_cs_framework' ),
					),
				)
			);
			array_push( $this->fields[ 'basic' ][ 'fields' ], $day_of_the_week );

			$id_classes = new WTR_Select( array(
					'id'			=> 'id_classes',
					'title'			=> __( 'Class', 'wtr_cs_framework' ),
					'desc'			=> '',
					'class'			=> 'ModalFields ReadStandard GetRealValue',
					'value'			=> '',
					'default_value'	=> '',
					'info'			=> '',
					'allow'			=> 'all',
					'mod'			=> '',
					'option'		=> $this->getWPQuery( 'classes' ),
				)
			);
			array_push( $this->fields[ 'basic' ][ 'fields' ], $id_classes );

			$time_hour_start = new WTR_Select( array(
					'id'			=> 'time_hour_start',
					'title'			=> __( 'Time - hour', 'wtr_cs_framework' ),
					'desc'			=> __( 'Beginning of the class', 'wtr_cs_framework' ),
					'class'			=> 'ModalFields ReadStandard',
					'value'			=> date( 'G' ),
					'default_value'	=> '',
					'info'			=> '',
					'allow'			=> 'all',
					'mod'			=> '',
					'option'		=> $this->generateHours( $param[ 'time_format' ] ),
				)
			);
			array_push( $this->fields[ 'basic' ][ 'fields' ], $time_hour_start );

			$time_minute_start = new WTR_Select( array(
					'id'			=> 'time_minute_start',
					'title'			=> __( 'Time - minute', 'wtr_cs_framework' ),
					'desc'			=> __( 'Beginning of the class', 'wtr_cs_framework' ),
					'class'			=> 'ModalFields ReadStandard',
					'value'			=> date( 'i' ),
					'default_value'	=> '',
					'info'			=> '',
					'allow'			=> 'all',
					'mod'			=> '',
					'option'		=> $this->generateMin(),
				)
			);
			array_push( $this->fields[ 'basic' ][ 'fields' ], $time_minute_start );

			$time_hour_end = new WTR_Select( array(
					'id'			=> 'time_hour_end',
					'title'			=> __( 'Time - hour', 'wtr_cs_framework' ),
					'desc'			=> __( 'End of the class', 'wtr_cs_framework' ),
					'class'			=> 'ModalFields ReadStandard',
					'value'			=> date( 'G' ),
					'default_value'	=> '',
					'info'			=> '',
					'allow'			=> 'all',
					'mod'			=> '',
					'option'		=> $this->generateHours( $param[ 'time_format' ] ),
				)
			);
			array_push( $this->fields[ 'basic' ][ 'fields' ], $time_hour_end );

			$time_minute_end = new WTR_Select( array(
					'id'			=> 'time_minute_end',
					'title'			=> __( 'Time - minute', 'wtr_cs_framework' ),
					'desc'			=> __( 'End of the class', 'wtr_cs_framework' ),
					'class'			=> 'ModalFields ReadStandard',
					'value'			=> date( 'i' ),
					'default_value'	=> '',
					'info'			=> '',
					'allow'			=> 'all',
					'mod'			=> '',
					'option'		=> $this->generateMin(),
				)
			);
			array_push( $this->fields[ 'basic' ][ 'fields' ], $time_minute_end );

			$room = new WTR_Select( array(
					'id'			=> 'id_room',
					'title'			=> __( 'Room', 'wtr_cs_framework' ),
					'desc'			=> '',
					'class'			=> 'ModalFields ReadStandard GetRealValue',
					'value'			=> '',
					'default_value'	=> '',
					'info'			=> '',
					'allow'			=> 'all',
					'mod'			=> '',
					'option'		=> $this->getWPQuery( 'rooms' ),
				)
			);
			array_push( $this->fields[ 'basic' ][ 'fields' ], $room );

			$trainers = new WTR_Select( array(
					'id'			=> 'trainers',
					'title'			=> __( 'Trainers', 'wtr_cs_framework' ),
					'desc'			=> '',
					'class'			=> 'ModalFields GetRealValue',
					'value'			=> '',
					'default_value'	=> '',
					'info'			=> '',
					'allow'			=> 'all',
					'mod'			=> 'multiselect',
					'size'			=> 6,
					'option'		=> $this->generateListTrainer(),
				)
			);
			array_push( $this->fields[ 'basic' ][ 'fields' ], $trainers );

			$participants = new WTR_Text(array(
					'id'			=> 'participants',
					'class'			=> 'ModalFields ReadStandard',
					'title'			=> __( 'Participants', 'wtr_cs_framework' ),
					'desc'			=> __( 'Value must be a number', 'wtr_cs_framework' ),
					'value'			=> '0',
					'default_value'	=> '',
					'info'			=> '',
					'allow'			=> 'all',
				)
			);
			array_push( $this->fields[ 'basic' ][ 'fields' ], $participants );

			$desc = new WTR_Textarea( array(
					'id' 			=> 'desc',
					'class' 		=> 'ModalFields ReadStandard',
					'rows' 			=> 5,
					'title' 		=> __( 'Additional text - modal', 'wtr_framework' ),
					'desc' 			=> '',
					'value' 		=> '',
					'default_value' => '',
					'info' 			=> '',
					'allow' 		=> 'all',
				)
			);
			array_push( $this->fields[ 'basic' ][ 'fields' ], $desc );

			$view = new WTR_Hidden(array(
					'id'			=> 'view_controler',
					'class'			=> 'ModalFields ReadStandard',
					'title'			=> '',
					'desc'			=> '',
					'value'			=> 'wtr_calendar_scope',
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
		}// end fillFields
	}//end wtr_calendar_scope
}