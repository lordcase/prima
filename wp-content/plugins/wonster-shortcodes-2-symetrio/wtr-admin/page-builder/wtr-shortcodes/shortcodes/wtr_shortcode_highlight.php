<?php
/**
 * @package Energizo
 * @author Wonster
 * @link http://wonster.co/
 */

// Don't load directly
if ( !defined('ABSPATH') ) { die('-1');}

include_once ( SHORTCODES_URL . '/wtr_shortcode_template.php' );


if ( ! class_exists( 'WTR_Shortcode_Dropcaps' ) ) {

	class WTR_Shortcode_Highlight extends  WTR_Shortcode_Template {

		// FUNCTION
		public function __construct(){

			// init obj
			$this->createEl( self::sht_button() );

			// fill fields
			$this->fillFields();
		}// end __construct


		public static function sht_button( $version = null )
		{
			return array(
				'name'				=>  __('Heighlight', 'wtr_sht_framework' ),
				'icon'				=> 'ib-dropcaps',
				'shortcode'			=> 'self',
				'shortcode_id'		=> 'wtr_highlight',
				'shortcode_code'	=> '[wtr_highlight]Your text here[/wtr_highlight]'
			);
		}// end sht_button


		protected function fillFields(){}
	}// end WTR_Shortcode_Dropcaps
}