<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

require_once( WTR_ADMIN_CLASS_DIR . '/wtr_core.php' );

if ( ! class_exists( 'WTR_Customize_Setting' ) ) {

	class WTR_Customize_Setting extends WTR_Core{

		protected $id;
		protected $id_setting;

		protected $default;
		protected $type 				= 'option';
		protected $capability			= 'edit_theme_options';
		protected $transport			= 'postMessage';
		protected $sanitize_callback	= 'sanitize_hex_color';


		protected $control_args	= array();
		protected $control_section;
		protected $control_type;

		protected $css_selector;
		protected $css_style;
		protected $css_important = false;
		protected $css_custom;

		protected static $priority = 0;

		public function __construct( $data = NULL ) {

			foreach ($data as $key => $value){
				$this->$key = $value;
			}

			$this->id_setting 	= $this->id;
			$this->id 			= WP_CUSTOMIZER_OPT_NAME . '['.$this->id.'][value]';

			if( empty( $this->control_args['label'] ) ){
				$this->control_args['label'] = __( 'Option ','wtr_framework');
			}

			$this->control_args['priority'] = self::$priority ++;
			$this->control_args['settings'] = $this->id;
		} // end __construct


		public function add_setting( $wp_customize ){
			$wp_customize->add_setting( $this->id, array(
				'default'			=> $this->default,
				'type'				=> $this->type,
				'capability'		=> $this->capability,
				'transport'			=> $this->transport,
				'sanitize_callback'	=> $this->sanitize_callback,

				)
			);
		}// end add_setting


		public function add_control( $wp_customize  ){

			if( 'color' == $this->control_type ){
				$control_args 				= $this->control_args;
				$control_args['section']	= $this->control_section;
				$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $this->id, $control_args ) );
			}
		}// end add_control
	}; // end WTR_Text
}