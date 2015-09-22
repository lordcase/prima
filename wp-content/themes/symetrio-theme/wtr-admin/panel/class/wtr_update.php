<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

if ( ! class_exists( 'WTR_Update' ) ) {

	class WTR_update extends WTR_Core {


		protected $plugins				= array();
		protected $installed_plugins	= array();


		public function __construct( $option = array() ){

			add_action( 'init', array( $this, 'init' ) );
			add_filter( 'set_site_transient_update_plugins', array( $this, 'plugins_upgrade_check') );
			add_filter( 'site_transient_update_plugins', array( $this, 'plugins_upgrade_check') );
			add_action( 'init', array( $this, 'init' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'scripts' ) );

		} // end __construct

		public function init() {

			$plugins					= wtr_update_required_plugins();
			$this->installed_plugins	= $this->get_plugins();

			foreach ($plugins as $plugin) {
				$this->register($plugin);
			}
		} // end init


		function register( $plugin ) {
			$plugin['file_path']				= $this->get_plugin_basename_from_slug($plugin['slug']);
			$this->plugins[ $plugin['slug'] ]	= $plugin;
		} // end register


		function plugins_upgrade_check( $update_plugins ){

			if ( ! is_object( $update_plugins ) ) {
				$update_plugins = new stdClass;
			}

			foreach ( $this->plugins as $slug => $plugin ) {
				$file_path = $plugin['file_path'];

				if( ! empty( $this->installed_plugins[ $this->plugins[ $slug ]['file_path'] ] ) AND true === $this->does_plugin_require_update( $plugin['slug'] ) ) {
					if ( empty( $update_plugins->response[ $file_path ] ) ) {
						$update_plugins->response[ $file_path ] = new stdClass;
					}
					// We only really need to set package, but let's do all we can in case WP changes something.
					$update_plugins->response[ $file_path ]->slug        = $slug;
					$update_plugins->response[ $file_path ]->plugin      = $file_path;
					$update_plugins->response[ $file_path ]->new_version = $plugin['version'];
					$update_plugins->response[ $file_path ]->package     = $plugin['source'];
				}
			}
			return $update_plugins;
		} // end plugins_upgrade_check

		/**
		 * Check the plugins directory and retrieve all plugin files with plugin data.
		 */
		public function get_plugins() {
			if ( ! function_exists( 'get_plugins' ) ) {
				require_once ABSPATH . 'wp-admin/includes/plugin.php';
			}
			return get_plugins();
		} // end get_plugins


		/**
		 * Check whether the plugin has updates
		 */
		public function does_plugin_require_update( $slug ) {
			$installed_version	= ( ! empty( $this->installed_plugins[ $this->plugins[ $slug ]['file_path'] ]['Version'] ) ) ? $this->installed_plugins[ $this->plugins[ $slug ]['file_path'] ]['Version'] : '';
			$minimum_version	= $this->plugins[ $slug ]['version'];
			return version_compare( $minimum_version, $installed_version, '>' );
		} // end does_plugin_require_update


		/**
		 * Get file path of the plugin file from the plugin slug, if the plugin is installed.
		 */
		protected function get_plugin_basename_from_slug( $slug ) {
			$keys = array_keys( $this->installed_plugins );

			foreach ( $keys as $key ) {
				if ( is_integer( strpos( $key, $slug ) ) ) {
					return $key;
				}
			}
			return $slug;
		} // end get_plugin_basename_from_slug


		public function scripts($hook) {

			global $wp_version;
			$cur_wp_version = preg_replace('/-.*$/', '', $wp_version);

			if('update-core.php' === $hook) {
				wp_enqueue_script( 'wtr_plugin_update_core', WTR_ADMIN_URI . '/panel/js/plugin_update_core.js', false );
				//localize
				$unknown = explode('%1$s:', __('Compatibility with WordPress %1$s: Unknown', 'default'));
				$according_to_its_author = explode('%1$s: 100%%', __('Compatibility with WordPress %1$s: 100%% (according to its author)', 'default'));

				$param = array(
					'unknown'					=> $unknown[1],
					'according_to_its_author'	=> ' 100% ' . $according_to_its_author[1]
				);
				wp_localize_script( 'wtr_plugin_update_core', 'wtr_update_plugin', $param );
			} else if ('plugins.php' === $hook ) {
				wp_enqueue_script( 'wtr_plugin_update', WTR_ADMIN_URI . '/panel/js/plugin_update.js', false );
			}


		} //end scripts

	}//end WTR_update
}