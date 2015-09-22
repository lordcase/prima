<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

require_once( 'wtr_core.php' );

if ( ! class_exists( 'WTR_Section' ) ) {

	class WTR_Section extends WTR_Core {
		protected $id;
		protected $title;
		protected $fields = array();

		public function __construct( $data = NULL ) {

			if ( ! is_array( $data ) OR
				 ! isset( $data[ 'title' ] ) OR
				 ! isset( $data[ 'id' ] ) OR
				 ! isset( $data[ 'fields' ] ) OR
				 ! is_array( $data[ 'fields' ] )
				){
				throw new Exception( $this->errors['param_construct'] );
			}

			foreach ($data[ 'fields' ] as $key => $value) {
				if( 'WTR_Filed' !=  get_parent_class($value) ){
					throw new Exception( $this->errors[ 'param_construct' ] . $this->errors[ 'param_construct_parent' ] );
				}
			}

			foreach ($data as $key => $value)
				$this->$key = $value;
		}
	};// end WTR_Section
}
