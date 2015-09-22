<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

if( ! function_exists( 'wtr_update_required_plugins' ) ){

	function wtr_update_required_plugins() {

		$plugins = array(
			array(
				'name'					=> 'Revolution Slider',
				'slug'					=> 'revslider',
				'source'				=> WTR_PLUGINS_DIR . '/revslider.zip',
				'required'				=> true,
				'version'				=> '5.0.5',
				'force_activation'		=> false,
				'force_deactivation'	=> false,
				'external_url'			=> '',
			),
			array(
				'name'					=> 'Visual Composer: Page Builder for WordPress',
				'slug'					=> 'js_composer',
				'source'				=> WTR_PLUGINS_DIR . '/js_composer.zip',
				'required'				=> true,
				'version'				=> '4.6.2',
				'force_activation'		=> false,
				'force_deactivation'	=> false,
				'external_url'			=> '',
			),
			array(
				'name'					=> 'Wonster Shortcodes for Visual Composer - Symetrio Edition',
				'slug'					=> 'wonster-shortcodes-2-symetrio',
				'source'				=> WTR_PLUGINS_DIR . '/wonster-shortcodes-2-symetrio.zip',
				'required'				=> true,
				'version'				=> '2.16.2',
				'force_activation'		=> false,
				'force_deactivation'	=> false,
				'external_url'			=> '',
			),
			array(
				'name'					=> 'Wonster Classes Schedule - Symetrio Edition',
				'slug'					=> 'wonster-classes-schedule-symetrio',
				'source'				=> WTR_PLUGINS_DIR . '/wonster-classes-schedule-symetrio.zip',
				'required'				=> true,
				'version'				=> '1.14.1',
				'force_activation'		=> false,
				'force_deactivation'	=> false,
				'external_url'			=> '',
			),
			array(
				'name'					=> 'Wonster Custom Type - Symetrio Edition',
				'slug'					=> 'wonster-custom-type-symetrio',
				'source'				=> WTR_PLUGINS_DIR . '/wonster-custom-type-symetrio.zip',
				'required'				=> true,
				'version'				=> '2.9',
				'force_activation'		=> false,
				'force_deactivation'	=> false,
				'external_url'			=> '',
			)
		);
		return $plugins;
	} // wtr_update_required_plugins
}