<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

require_once( WTR_ADMIN_CLASS_DIR . '/wtr_core.php' );

if ( ! class_exists( 'WTR_Customize_Section' ) ) {

	class WTR_Customize_Section extends WTR_Core {

		protected $id;
		protected $args;
		protected $settings			= array();
		protected static $priority	= 30;

		public function __construct( $data = NULL ) {

			foreach ($data as $key => $value)
				$this->$key = $value;

			if( ! isset( $this->args['priority'] ) ){
				$this->args['priority'] = self::$priority ++;
			}

			$settings = array();
			foreach ( $this->settings as $setting ) {
				if( is_object($setting) AND 'WTR_Customize_Setting' ==  get_class( $setting ) ){
					$setting->set('control_section',$this->id);
					$settings[] = $setting;
				}
			}
			$this->settings = $settings;
		} // end __construct


		public function add_section( $wp_customize ){
			$wp_customize->add_section( $this->id, $this->args );
		}// end add_setting
	}; // end WTR_Text
}