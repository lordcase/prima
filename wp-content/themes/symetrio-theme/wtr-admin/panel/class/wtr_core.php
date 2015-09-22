<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

require_once( WTR_ADMIN_CLASS_DIR.'/wtr_validate.php' );

if ( ! class_exists( 'WTR_Core' ) ) {

	abstract class WTR_Core {

		protected $errors = array('param_construct'			=> 'Incorrect parameters in the constructor. ',
								  'param_construct_parent'	=> 'Incorrect parrent class. ',
								  'param'					=> 'Incorrect parameters in function. '
								 );


		public function get( $key ) {

			if( !isset( $this->$key) ){
				return false;
			}

			return $this->$key;
		}


		public function set( $key, $value ){

			$this->$key = $value;
		}
	};// end WTR_Core
}