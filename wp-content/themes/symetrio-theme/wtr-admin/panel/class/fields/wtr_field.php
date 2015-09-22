<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

require_once( WTR_ADMIN_CLASS_DIR.'/wtr_core.php' );

if ( ! class_exists( 'WTR_Filed' ) ) {

	class WTR_Filed  extends WTR_Core {

		protected $id;
		protected $title;
		protected $desc;
		protected $value;
		protected $default_value;
		protected $info;
		protected $allow;
		protected $class = '';


		public function __construct( $data = NULL ) {

			if ( ! is_array( $data ) OR
				 ! isset( $data[ 'id' ] ) OR
				 ! isset( $data[ 'title' ] ) OR
				 ! isset( $data[ 'desc' ] ) OR
				 ! isset( $data[ 'value' ] ) OR
				 ! isset( $data[ 'default_value' ] ) OR
				 ! isset( $data[ 'info' ] ) OR
				 ! isset( $data[ 'allow' ] )
				){
				throw new Exception( $this->errors['param_construct'] );
			}

			foreach ($data as $key => $value)
				$this->$key = $value;
		}//end __construct


		public function set( $key, $value ){

			if( WTR_Validate::check( $this->allow , $value ) ){
				$this->$key = $value;
				return true;
			}
			return false;
		}//end set


		public function compare( $obj ){

			if( get_class( $obj ) != get_class( $this ) ){
				return false;
			}

			$obj_a = get_object_vars( $obj );
			$this_a = get_object_vars( $this );

			foreach ($this_a as $key => $value) {

				if( !isset( $obj_a[ $key ] ) OR ( $value != $obj_a[ $key ] ) ) {
					return false;
				}else{
					unset( $obj_a[ $key ] );
				}
			}

			if( $obj_a ){
				return false;
			}
			return true;
		}//end compare


		public function exportSettings(){
			return array(
						'value' => ( '' != trim( $this->get( 'value' ) ) )? $this->get( 'value' ) : $this->get( 'default_value' )
					);
		}// end exportSettings
	};// end WTR_Filed
}