<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

// Don't load directly
if ( !defined('ABSPATH') ) { die('-1'); }

if ( ! class_exists( 'WTR_Shortcode_Template' ) ) {

	abstract class WTR_Shortcode_Template {

		// VARIABLE
		protected $title;
		protected $desc;
		protected $shortcode_id;
		protected $end_el;
		protected $fieldsGroup	= array();
		protected $fields		= array();
		protected $fieldsData	= array();
		protected $alerts		= array();
		protected $errors		= array( 'wrong_param' => 'Incorrect parameters in the constructor. ' );


		// FUNCTIONS
		abstract protected function fillFields();

		public function __construct(){
			$this->fieldsGroup = array(
				'basic' 	=> __( 'Global', 'wtr_sht_framework' ),
				'animation' => __( 'CSS Animation', 'wtr_sht_framework' ),
				'advanced'	=> __( 'Advanced', 'wtr_sht_framework' ),
				'margin'	=> __( 'Margins' )
			);
		}// end __construct


		public function get( $opt ){

			if( isset($this->$opt) ){
				return $this->$opt;
			} else {
				throw new Exception( $this->errors[ 'wrong_param' ] );
			}
		}// end get


		protected function createEl( $opt ){

			if( count($opt) ){
				foreach ( $opt as $key => $value ){
					$this->$key = $value;
				}
			}
		}// end createEl


		public function fieldsValue(){

			$result = array();

			foreach( $this->fields as $group => $group_data ){

				$obj_c  = count( $group_data[ 'fields' ] );

				for( $i = 0; $i < $obj_c; ++$i ){
					$result[ $this->fields[ $group ][ 'fields' ][ $i ]->get( 'id' ) ] = $this->fields[ $group ][ 'fields' ][ $i ]->exportSettings();
				}
			}
				//$result[ $this->fields[ $i ]->get( 'id' ) ] = $this->fields[ $i ]->exportSettings();
			return $result;
		}// end fieldsValue


		protected function fillFieldsFinal ( $obj, $source ){

			foreach( $source as $field => $val )
				$obj->set( $field, $val );
		}// end fillFieldsFinal


		public function draw( $data ){

			$counterItem = 0;

			ob_start();

			foreach( $this->fields as $group => $group_data ){

				$obj_c  = count( $group_data[ 'fields' ] );

				if( 0 == $counterItem ){
					$display = 'block';
					++$counterItem;
				}
				else{
					$display = 'none';
				}


				echo '<div style="display:' . $display . '" class="wtr_subform_option wtr_sht_subform_detal_' . $group . '">';

				for( $i = 0; $i < $obj_c; ++$i ){
					$d = ( isset( $data[ $this->fields[ $group ][ 'fields' ][ $i ]->get( 'id' ) ] ) )? $data[ $this->fields[ $group ][ 'fields' ][ $i ]->get( 'id' ) ] : array();
					$this->fillFieldsFinal( $this->fields[ $group ][ 'fields' ][ $i ], $d );
					$this->fields[ $group ][ 'fields' ][ $i ]->draw();
				}

				echo '</div>';
			}

			return ob_get_clean();
		}// end draw


		public function getGroupFields(){

			$result = array();

			foreach( $this->fields as $group => $group_data ){
				if( count( $group_data[ 'fields' ] ) )
				$result[ trim( $group ) ] = trim( $group_data[ 'name' ] );
			}

			return $result;
		}// end getGroupFields


		public function animationOption(){

			$result = array();

			$animate = new WTR_Select( array(
					'id'			=> $this->shortcode_id . '_animate',
					'class'			=> 'ModalFields ReadStandard',
					'title'			=> __( 'Animation effect', 'wtr_sht_framework' ),
					'desc'			=> '',
					'value'			=> 'none',
					'default_value'	=> '',
					'info'			=> '',
					'allow'			=> 'all',
					'mod'			=> 'animation',
					'option'		=> array(	'none'								=> __( 'None', 'wtr_sht_framework' ),
												'bounce'							=> 'bounce',
												'wtrOpacityNone bounceIn'			=> 'bounceIn',
												'wtrOpacityNone bounceInDown'		=> 'bounceInDown',
												'wtrOpacityNone bounceInLeft'		=> 'bounceInLeft',
												'wtrOpacityNone bounceInRight'		=> 'bounceInRight',
												'wtrOpacityNone bounceInUp'			=> 'bounceInUp',
												'wtrOpacityNone fadeIn'				=> 'fadeIn',
												'wtrOpacityNone fadeInDown'			=> 'fadeInDown',
												'wtrOpacityNone fadeInDownBig'		=> 'fadeInDownBig',
												'wtrOpacityNone fadeInLeft'			=> 'fadeInLeft',
												'wtrOpacityNone fadeInLeftBig'		=> 'fadeInLeftBig',
												'wtrOpacityNone fadeInRight'		=> 'fadeInRight',
												'wtrOpacityNone fadeInRightBig'		=> 'fadeInRightBig',
												'wtrOpacityNone fadeInUp'			=> 'fadeInUp',
												'wtrOpacityNone fadeInUpBig'		=> 'fadeInUpBig',
												'flash'								=> 'flash',
												'flip'								=> 'flip',
												'wtrOpacityNone flipInX'			=> 'flipInX',
												'wtrOpacityNone flipInY'			=> 'flipInY',
												'wtrOpacityNone lightSpeedIn'		=> 'lightSpeedIn',
												'pulse'								=> 'pulse',
												'wtrOpacityNone rotateIn'			=> 'rotateIn',
												'wtrOpacityNone rotateInDownLeft'	=> 'rotateInDownLeft',
												'wtrOpacityNone rotateInDownRight'	=> 'rotateInDownRight',
												'wtrOpacityNone rotateInUpLeft'		=> 'rotateInUpLeft',
												'wtrOpacityNone rotateInUpRight'	=> 'rotateInUpRight',
												'wtrOpacityNone slideInDown'		=> 'slideInDown',
												'wtrOpacityNone slideInLeft'		=> 'slideInLeft',
												'wtrOpacityNone slideInRight'		=> 'slideInRight',
												'shake'								=> 'shake',
												'swing'								=> 'swing',
												'wtrOpacityNone rollIn'				=> 'rollIn',
												'rubberBand'						=> 'rubberBand',
												'tada'								=> 'tada',
												'wobble'							=> 'wobble'
											)
				)
			);
			array_push( $result, $animate );

			$animate_delay = new WTR_Text(array(
					'id'			=> $this->shortcode_id . '_delay',
					'class'			=> 'ModalFields ReadStandard',
					'title'			=> __( 'Animation Delay (in milliseconds)', 'wtr_sht_framework' ),
					'desc'			=> __( 'Value must be a number', 'wtr_sht_framework' ),
					'value'			=> 0,
					'default_value'	=> '',
					'info'			=> 'For example: <b>1</b> second delay is <b>1000</b> milliseconds',
					'allow'			=> 'all',
				)
			);
			array_push( $result, $animate_delay );

			return $result;
		}//animationOption


		public function marginsOption(){

			$result = array();

			$marginleft = new WTR_Text( array(
					'id'			=> $this->shortcode_id . '_margin_left',
					'class'			=> 'ModalFields ReadScroll',
					'title'			=> __( 'Margin left', 'wtr_sht_framework' ),
					'desc'			=> __( 'Please, use only numeric signs', 'wtr_sht_framework' ),
					'value'			=> 0,
					'default_value'	=> '',
					'info'			=> '',
					'allow'			=> 'all',
				)
			);
			array_push( $result, $marginleft );

			$marginright = new WTR_Text( array(
					'id'			=> $this->shortcode_id . '_margin_right',
					'class'			=> 'ModalFields ReadScroll',
					'title'			=> __( 'Margin right', 'wtr_sht_framework' ),
					'desc'			=> __( 'Please, use only numeric signs', 'wtr_sht_framework' ),
					'value'			=> 0,
					'default_value'	=> '',
					'info'			=> '',
					'allow'			=> 'all',
				)
			);
			array_push( $result, $marginright );

			$margintop = new WTR_Text( array(
					'id'			=> $this->shortcode_id . '_margin_top',
					'class'			=> 'ModalFields ReadScroll',
					'title'			=> __( 'Margin top', 'wtr_sht_framework' ),
					'desc'			=> __( 'Please, use only numeric signs', 'wtr_sht_framework' ),
					'value'			=> 0,
					'default_value'	=> '',
					'info'			=> '',
					'allow'			=> 'all',
				)
			);
			array_push( $result, $margintop );

			$marginbottom = new WTR_Text( array(
					'id'			=> $this->shortcode_id . '_margin_bottom',
					'class'			=> 'ModalFields ReadScroll',
					'title'			=> __( 'Margin bottom', 'wtr_sht_framework' ),
					'desc'			=> __( 'Please, use only numeric signs', 'wtr_sht_framework' ),
					'value'			=> 0,
					'default_value'	=> '',
					'info'			=> '',
					'allow'			=> 'all',
				)
			);
			array_push( $result, $marginbottom );

			return $result;
		}//end animationOption


		public function extraClassElement(){

			return new WTR_Text(array(
					'id'			=> $this->shortcode_id . '_el_class',
					'class'			=> 'ModalFields ReadStandard',
					'title'			=> __( 'Extra class name', 'wtr_sht_framework' ),
					'desc'			=> __( 'If you wish to style particular content element differently,
											then use this field to add a class name and then refer to it in your
											css file', 'wtr_sht_framework' ),
					'value'			=> '',
					'default_value'	=> '',
					'info'			=> '',
					'allow'			=> 'all',
				)
			);
		}//end extraClassElement


		public function getDefaultShortcodeItemColumns( $opt, $base_type, $type, $end ){

			$resut	= array();
			$optC	= count( $opt );

			for( $i= 0; $i < $optC; ++$i ){
				$tmp		= '';
				$content	= '';
				$tmp_attr	= array();

				foreach( $opt[ $i ] as $l => $r ){
					$name = str_replace( $base_type .'_', '', $l );

					if( 'title' == $name ) continue;

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
			return  $resut;
		}// end getDefaultShortcodeItem
	}// end WTR_Tabs_TinyMCE
}