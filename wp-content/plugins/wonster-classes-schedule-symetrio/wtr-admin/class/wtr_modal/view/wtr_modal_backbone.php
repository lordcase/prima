<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

// Don't load directly
if ( !defined('ABSPATH') ) { die('-1'); }

if ( ! class_exists( 'WTR_Modal_Backbone' ) ) {

	abstract class WTR_Modal_Backbone {

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


		public function __construct(){
			$this->fieldsGroup = array(
				'basic' 	=> __( 'Global', 'wtr_cs_framework' ),
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
			ob_start();

			foreach( $this->fields as $group => $group_data ){
				$obj_c  = count( $group_data[ 'fields' ] );

				for( $i = 0; $i < $obj_c; ++$i ){
					$d = ( isset( $data[ $this->fields[ $group ][ 'fields' ][ $i ]->get( 'id' ) ] ) )? $data[ $this->fields[ $group ][ 'fields' ][ $i ]->get( 'id' ) ] : array();
					$this->fillFieldsFinal( $this->fields[ $group ][ 'fields' ][ $i ], $d );
					$this->fields[ $group ][ 'fields' ][ $i ]->draw();
				}
			}

			return ob_get_clean();
		}// end draw


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


		protected function getWPQuery( $data ){
			$result = array();
			$config = array(
				'post_type'				=> $data,
				'posts_per_page'		=> -1,
				'ignore_sticky_posts'	=> 1
			);

			// The Query
			$the_query	= new WP_Query( $config );

			if ( $the_query->have_posts() ){
				while ( $the_query->have_posts() ){
					$the_query->the_post();
					$name = get_the_title();
					$name = ( trim( $name ) )? $name: __( 'No title', 'wtr_cs_framework' );
					$result[ get_the_id() ] = $name;
				}
			}

			/* Restore original Post Data */
			wp_reset_postdata();

			if( !count( $result ) ) {
				$result = array( 'NN' => __( 'There is no item to choose from', 'wtr_cs_framework' ) );
			}
			asort( $result );

			return $result;
		}//end getClassesList


		protected function generateListTrainer(){
			$args = array(
				'post_type'				=> 'trainer',
				'posts_per_page'		=> -1,
				'ignore_sticky_posts'	=> 1,
			);

			// The Query
			$the_query = new WP_Query( $args );
			$result = array();

			if ( $the_query->have_posts() ){
				while ( $the_query->have_posts() ){
					$the_query->the_post();

					$nameTrainer	= get_post_meta( get_the_ID(), '_wtr_trainer_name', true );
					$surnameTrainer	= get_post_meta( get_the_ID(), '_wtr_trainer_last_name', true );

					if( $nameTrainer || $surnameTrainer ){
						$name = trim( $nameTrainer . ' ' . $surnameTrainer );
					}
					else{
						$name = __( 'no title', 'wtr_cs_framework' );
					}

					$result[ get_the_id() ] = $name;
				}
			}
			/* Restore original Post Data */
			wp_reset_postdata();

			if( !count( $result ) ) {
				$result = array( 'NN'  => __( 'There is no trainer to choose from', 'wtr_cs_framework' ) );
			}

			asort( $result );

			return $result;
		}//end generateListTrainer


		protected function generateMin(){
			$result = array( '00' => '0', '01' => '1', '02' => '2', '03' => '3', '04' => '4', '05' => '5',
							'06' => '6', '07' => '7', '08' => '8', '09' => '9' );

			for( $i = 10; $i < 60; $i++ ){
				$result[ $i ] = $i;
			}

			return $result;
		}//end generateMin


		public static function generateHours( $format ){
			$result = array();

			if( '12' == $format ){
				$result =array(
					'0' => '12 AM', '1' => '1 AM', '2' => '2 AM', '3' => '3 AM', '4' => '4 AM', '5' => '5 AM', '6' => '6 AM',
					'7' => '7 AM', '8' => '8 AM', '9' => '9 AM', '10' => '10 AM', '11' => '11 AM', '12' => '12 PM',
					'13' => '1 PM', '14' => '2 PM', '15' => '3 PM', '16' => '4 PM', '17' => '5 PM', '18' => '6 PM',
					'19' => '7 PM', '20' => '8 PM', '21' => '9 PM', '22' => '10 PM', '23' => '11 PM',
				);
			}else{
				for( $i = 0; $i < 24; $i++ ){
					$result[ $i ] = $i;
				}
			}
			return $result;
		}//end generateHours
	}// end WTR_Tabs_TinyMCE
}