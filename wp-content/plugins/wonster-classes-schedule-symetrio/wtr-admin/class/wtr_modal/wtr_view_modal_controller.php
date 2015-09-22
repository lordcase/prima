<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

if ( ! class_exists( 'WTR_Modal_Controler' ) ) {

	// # wp
	$ext_patch = __FILE__;
	$path_file = explode( 'wp-content', $ext_patch );
	$path_to_wp = $path_file[0];
	require_once( $path_to_wp . '/wp-load.php' );

	class WTR_Modal_Controler {

		private $config	= array();
		private $param	= array();
		private $data	= array();

		public function __construct(){
			// clean data
			$cln	= array();

			foreach( $_GET as $l => $r ){
				$r	= strip_tags( $r );
				$r	= trim( $r );
				$cln[$l] =  trim( $r );
			}

			if( !isset( $cln[ 'w' ] )  || !isset( $cln[ 'h' ] ) || !isset( $cln[ 'mode' ] ) || !isset( $cln[ 'view' ] ) || !isset( $cln[ 'data' ] ) ){

			}else{
				$this->config = $cln;
				$this->load_tpl();
				$this->load_libs();
				$this->get_data();
				$this->load_modal();
			}
		}//end __construct


		private function load_tpl(){
			// # load mode view

			$view = strtolower( $this->config[ 'view' ] );
			include_once dirname( __FILE__ )  . '/view/' . $view . '.php';

			// # template
			include_once 'wtr_modal_tpl.php';
		}//end load_tpl


		private function load_libs(){
			foreach ( glob( WTR_ADMIN_CLASS_DIR . "/fields/wtr_*.php" ) as $lib )
				include_once $lib;
		}//end load_libs


		private function prepare_data_from_db( $data ){
			$result = array();

			foreach( $data as $key => $val ){
				if( !is_array( $val ) ){
					$result[ $key ] = array( 'value' => $val );
				}else{
					$result[ $key ] = $val;
				}
			}

			return $result;
		}//end prepare_data_from_db


		private function get_data(){

			if( 'null' != $this->config[ 'data' ] ){

				include_once '../wtr_db_controller.php';
				$db_controler = new WTR_Cs_db();

				if( 'wtr_calendar_schedule' == $this->config[ 'view' ] && 'edit' == $this->config[ 'mode' ] ){

					$data = $db_controler->get_calendar( $this->config[ 'data' ] );

					if( count( $data ) ){
						$this->data = $this->prepare_data_from_db( $data );
					}
				}
				else if( 'wtr_calendar_scope' == $this->config[ 'view' ] ){
					if( 'new' == $this->config[ 'mode' ] ){
						$data	= $db_controler->get_calendar( $this->config[ 'data' ] );
						$dataC	= $data;
					}else if( 'edit' == $this->config[ 'mode' ] ){
						$tmp	= explode( '-', $this->config[ 'data' ] );
						$dataC	= $db_controler->get_calendar( $tmp[ 0 ] );
						$data	= $db_controler->get_scope( $tmp[ 1 ] );
						$data[ 'id_scope' ] = $tmp[ 1 ];
					}

					if( count( $data ) ){
						$this->data		= $this->prepare_data_from_db( $data );
						$this->param	= $dataC;
					}
				}
				else if( 'wtr_calendar_instance' == $this->config[ 'view' ] ){

					if( 'new' == $this->config[ 'mode' ] ){
						$dataC	= $db_controler->get_calendar( $this->config[ 'data' ] );
						$data	= $this->prepare_data_from_db( $dataC );
					}else if( 'edit' == $this->config[ 'mode' ] ){
						$tmp	= explode( '-', $this->config[ 'data' ] );
						$dataC	= $db_controler->get_calendar( $tmp[ 0 ] );

						$data	= $db_controler->get_instance( $dataC[ 'type' ], $tmp[ 1 ] );

						$data[ 'id_timetable' ]	= $tmp[ 0 ];
						$data[ 'id_instance' ]	= $tmp[ 1 ];

						$data = $this->prepare_data_from_db( $data );
					}
					$this->data		= $data;
					$this->param	= $dataC;
				}
			}

		}//end get_data


		private function load_modal(){
			$obj 	= new $this->config[ 'view' ]( $this->config[ 'mode' ], $this->param );
			$modal 	= new WTR_Modal_Tpl( $obj, $this->data, $this->config[ 'view' ], $this->config[ 'mode' ] );

			$modal->Show();
		}//end load_modal
	}
}

new WTR_Modal_Controler();