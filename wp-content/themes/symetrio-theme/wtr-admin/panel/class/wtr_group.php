<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

require_once( 'wtr_core.php' );

if ( ! class_exists( 'WTR_Group' ) ) {

	class WTR_Group extends WTR_Core {
		protected $title;
		protected $class;
		protected $sections = array();

		public function __construct( $data = NULL ) {

			if ( ! is_array( $data ) OR
				 ! isset( $data[ 'title' ] ) OR
				 ! isset( $data[ 'class' ] ) OR
				 ! isset( $data[ 'sections' ] ) OR
				 ! is_array($data[ 'sections' ])
				){
				throw new Exception( $this->errors['param_construct'] );
			}

			foreach ($data[ 'sections' ] as $key => $value)
			{
				if( 'WTR_Section' !=  get_class($value) ){
					throw new Exception( $this->errors[ 'param_construct' ] . $this->errors[ 'param_construct_parent' ] );
				}
			}

			foreach ($data as $key => $value){
				$this->$key = $value;
			}
		}
	}// end WTR_Group
}