<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

if ( ! class_exists( 'WTR_Settings' ) ) {

	class WTR_Settings extends WTR_Core {

		const WP_OPT_NAME			= 'wtr_symetrio_option';
		const WP_OPT_NAME_BACKUP	= 'wtr_symetrio_option_backup';
		const WP_SHT_LIST_OPT_NAME	= 'wtr_symetrio_sht_list';
		const WP_CURRENT_VERSION	= 'wtr_symetrio_version';
		const WP_ERROR				= 'wtr_symetrio_error';
		const WP_REWRITE_FLUSH		= 'wtr_symetrio_rewrite_flush';
		const WP_EXPORT_OPT_NAME	= 'wtr_symetrio_export_option';
		const WP_CREATE_CSS			= 'wtr_symetrio_create_css';

		static $custom_css_name		= 'style-custom';
		protected $opt				= array();
		protected $opt_a			= array();
		protected $sht_list			= '';


		public function __construct( $option = array() ){

			$this->opt	= apply_filters( 'wtr_init', $option );

			//name_custom_css
			$this->set_custom_css_name();

			//update theme
			add_action( 'after_setup_theme', array( &$this, 'update_theme') );

			// check theme
			add_action( 'after_setup_theme', array( &$this, 'theme_version'));

			// set option
			add_action( 'after_setup_theme', array( &$this, 'init_settings') );

			// create custom css
			add_action( 'init', array( &$this, 'create_custom_css'), 100 );

			// generating links if it was activated theme
			add_action('after_switch_theme', array( &$this, 'switch_theme') );

			// generating links
			add_action( 'wp_loaded', array( &$this, 'flush_rules') );

			// custom style
			add_filter( 'wtr_custom_css', array( &$this, 'custom_css' ) );

			// add font family
			add_action( 'wp_enqueue_scripts', array( &$this, 'font_family'), 100 );

			// export setting
			add_action( 'admin_init',array( &$this,'export_setting') );

			// JS
			add_action( 'wp_footer', array( &$this, 'load_js' ) );

			// upload mimes
			add_filter( 'upload_mimes', array( &$this, 'upload_mimes' ) );

			// debugging info
			add_action( 'wp_head', array( &$this, 'wtr_debugging_info' ) , 1000 );

			// get shortcode list
			$this->sht_list = get_option( self::WP_SHT_LIST_OPT_NAME );

		}// end __construct


		public function export_setting(){

			if( isset( $_POST['wtr_export_setting_to_file'] ) &&  'export' == $_POST['wtr_export_setting_to_file'] ){

				$filename = '' . sanitize_title( WTR_THEME_NAME .'-'. date('Y-d-m__H_i_s') )  .'.txt';

				header( 'Content-Description: File Transfer' );
				header( 'Content-Disposition: attachment; filename=' . $filename );
				header( 'Content-Type: text/plain; charset=' . get_option( 'blog_charset' ), true );
				echo  wtr_encode_theme_settings();
				exit;
			}
		} // end export_setting


		public function save_css(){
			$custom_style	= '';
			$opt			= $this->opt_a;

			//custom fonts
			$custom_fonts		= array( 'wtrFontsCustom','wtrFontsCustom2' );
			$custom_fonts_css	= '';
			$custom_fonts_arg	= '';

			foreach ( $custom_fonts as $custom_font ) {

				if( ! empty( $opt[ $custom_font . 'FontName'] ) AND (
					! empty( $opt[ $custom_font . 'FontWoff'] ) OR
					! empty( $opt[ $custom_font . 'FontEot'] ) OR
					! empty( $opt[ $custom_font . 'FontSvg'] ) OR
					! empty( $opt[ $custom_font . 'FontTtf'] ) OR
					! empty( $opt[ $custom_font . 'FontWoff'] )
					) ){
					$custom_fonts_css .= "@font-face { \n";
					$custom_fonts_css .= "font-family: '" . $opt[ $custom_font . 'FontName'] ."';\n";

					if( ! empty( $opt[ $custom_font . 'FontEot'] )){
						$custom_fonts_css .= "src: url('" . $opt[ $custom_font . 'FontEot'] . "'); \n";
						$custom_fonts_arg[ $custom_font ][]	= "url('" . $opt[ $custom_font . 'FontEot'] . "?#iefix') format('embedded-opentype')";
					}

					if( ! empty( $opt[ $custom_font . 'FontWoff'] )){
						$custom_fonts_arg[ $custom_font ][] ="url('" . $opt[ $custom_font . 'FontWoff'] . "') format('woff')";
					}

					if( ! empty( $opt[ $custom_font . 'FontTtf'] )){
						$custom_fonts_arg[ $custom_font ][] ="url('" . $opt[ $custom_font . 'FontTtf'] . "') format('truetype')";
					}

					if( ! empty( $opt[ $custom_font . 'FontSvg'] )){
						$custom_fonts_arg[ $custom_font ][] = "url('" . $opt[ $custom_font . 'FontSvg'] . "#svgFontName') format('svg')";
					}

					$custom_fonts_css .= 'src: ' .implode( $custom_fonts_arg[ $custom_font ], ",\n"  );
					$custom_fonts_css .= ";\n}\n\n";
				}
			}

			if( ! empty( $custom_fonts_css ) ) {
				$custom_style	.= "/* Custom Fonts */ \n\n" . $custom_fonts_css;
			}

			if( ! empty( $opt['wtr_custom_style_font_size'] ) AND is_array( $opt['wtr_custom_style_font_size'] ) ) {
				$custom_style	.= "/* Fonts family */ \n\n" . implode("\n", $opt['wtr_custom_style_font_size'] );
			}
			if( ! empty( $opt['wtr_custom_style_font'] ) AND is_array( $opt['wtr_custom_style_font'] ) ) {
				$custom_style	.= "/* Fonts size */ \n\n" . implode("\n", $opt['wtr_custom_style_font']) ;

			}
			$custom_style = apply_filters( 'wtr_custom_style_save', $custom_style, $this );
			return $custom_style;

		}//save_css


		function upload_mimes( $existing_mimes = array() ){
			$existing_mimes['woff']	= 'font/woff';
			$existing_mimes['ttf']	= 'font/ttf';
			$existing_mimes['svg']	= 'font/svg';
			$existing_mimes['eot']	= 'font/eot';
			return $existing_mimes;
		} // end upload_mimes


		public function set_custom_css_name(){

			if( function_exists( 'get_blog_details' ) ){
				$blog				= get_blog_details();
				$blog_id			= $blog->blog_id;
				$blog_name			= $blog->blogname;
				$custom_css_name	= self::$custom_css_name;

				if( 1 != $blog_id ) {
					self::$custom_css_name = sanitize_title( $custom_css_name . '-' . $blog_name );
				}
			}
		}

		public function create_custom_css(){
			$create_css			= get_option( 'WP_CREATE_CSS');
			$custom_css_name	= self::$custom_css_name . '.css';

			if( 1 == $create_css ) {
				$file	= fopen( WTR_THEME_DIR ."/" . $custom_css_name, "w" );
				$css	= $this->save_css();
				fwrite( $file, $css );
				fclose( $file );
				update_option( 'WP_CREATE_CSS', 0 );
			}

		} //end create_custom_css


		public function remove_custom_css(){
			update_option( 'WP_CREATE_CSS', 1 );
		} //end remove_custom_css


		public function custom_source_css( $old, $value ){
			$opt = unserialize( base64_decode( $value ) );
			update_option( 'WP_SOURCE_CSS', $opt['wtr_GlobalAccelerateCusttomCss'] );
		} //end custom_source_css


		public function update_theme(){

			add_action( 'update_option_' . self::WP_OPT_NAME, array( &$this, 'custom_source_css'), 10, 2 );
			add_action( 'add_option_' . self::WP_OPT_NAME, array( &$this, 'custom_source_css'), 10, 2 );

			$source_css	= get_option( 'WP_SOURCE_CSS', 1 );
			if ( 1 == $source_css ) {
				// update custom css
				add_action( 'update_option_' . self::WP_OPT_NAME, array( &$this, 'remove_custom_css') );
				add_action( 'add_option_' . self::WP_OPT_NAME, array( &$this, 'remove_custom_css') );
				add_action( 'update_option_' . self::WP_CURRENT_VERSION, array( &$this, 'remove_custom_css') );
				add_action( 'add_option_' . self::WP_CURRENT_VERSION, array( &$this, 'remove_custom_css') );
				add_action( 'update_option_' . WP_CUSTOMIZER_OPT_NAME, array( &$this, 'remove_custom_css') );
				add_action( 'add_option_' . WP_CUSTOMIZER_OPT_NAME, array( &$this, 'remove_custom_css') );
			}

			// update settings
			add_action( 'update_option_' . self::WP_CURRENT_VERSION, array( &$this, 'update_options') );
			// one click
			add_action('wtr_import_end', array( &$this, 'update_options'), 100 );
		} // end update_customizer


		public function theme_version(){
			$theme_version_db			= get_option( self::WP_CURRENT_VERSION );
			$wtr_theme					= wp_get_theme();
			$wtr_theme_parent			= $wtr_theme->parent();
			$theme_version				= ( $wtr_theme_parent ) ? $wtr_theme_parent->Version : WTR_THEME_VERSION;

			if( $theme_version !==  $theme_version_db ){
				$this->backup_options( $theme_version ,$theme_version_db );
				update_option( self::WP_CURRENT_VERSION, $theme_version );
			}

		} // end theme_version


		public function switch_theme(){

			update_option( self::WP_REWRITE_FLUSH, 1 );
		}// end switch_theme


		public function flush_rules(){
			if( get_option( self::WP_REWRITE_FLUSH ) ){
				global $wp_rewrite;
				$wp_rewrite->flush_rules();
				delete_option( self::WP_REWRITE_FLUSH );
			}
		}// end flush_rules


		public function init_settings(){
			global $post_settings;

			$this->opt_a = get_option( self::WP_OPT_NAME );

			// create options
			if( empty( $this->opt_a ) ){
				$this->update_options();
				$this->remove_custom_css();
			}
			// format options
			$this->opt_a = $this->format_options( $this->opt_a );

			$post_settings = $this->opt_a;
		}// end init_settings


		public function update_options(){
			$opt_a		= get_option( self::WP_OPT_NAME );
			$new_opt	= $this->format_options( $opt_a );
			$new_opt	= $this->create_options( $new_opt );
			update_option( self::WP_OPT_NAME, $new_opt );
		} // end update_options


		private function backup_options( $theme_version, $theme_version_db = null ){
			$opt_a			= get_option( self::WP_OPT_NAME );
			$opt_backup		= get_option( self::WP_OPT_NAME_BACKUP );
			$opt_backup		= ( empty( $opt_backup ) ) ? array() : $opt_backup;
			$new_backup		= array(
				'before_version'	=> $theme_version_db,
				'current_version'	=> $theme_version,
				'date'				=> date('Y-m-d H:i:s'),
				'options'			=> $opt_a
				);
			array_push( $opt_backup, $new_backup );
			update_option( self::WP_OPT_NAME_BACKUP, $opt_backup );
		} // end backup_options


		public function format_options( $opt_a ){
			if( is_array( $opt_a ) ) {
				$new_opt		= base64_encode( serialize( $opt_a ) );
				update_option( self::WP_OPT_NAME, $new_opt );
				$opt_a	= $new_opt;
			}
			$opt_a  = unserialize( base64_decode( $opt_a ) );
			return $opt_a;
		} // end format_options


		function create_options( $opt_a = array() ){
			$opt		= $this->opt;
			$update		= false;
			$new_opt_a	= array();

			foreach ( $this->opt as  $group ) {
				foreach ( (array ) $group->get('sections') as $section ) {
					foreach ( ( array ) $section->get('fields') as $field ) {

						$id_field = $field->get( 'id' );
						$no_value = $field->get( 'no_value' );


						if( isset( $opt_a[ $id_field ] ) ) {

							if( true == $no_value ){
								$value = $field->get( 'default_value' );
							} else if( is_object( $opt_a[ $id_field ] ) ){
								$value = $opt_a[ $id_field ]->get( 'value' );
							} else {
								$value = $opt_a[ $id_field ];
							}

						} else {
							$update	= true;
							$value	= $field->get( 'default_value' );
						}
						$new_opt_a[ $id_field ]		= $value;
						$new_opt_a					= $this->set_opt_a( $new_opt_a, $field, $value);

					}
				}
			}

			$new_opt_a	= base64_encode( serialize( $new_opt_a ) );
			$this->opt_a = $new_opt_a;
			return $new_opt_a;
		}// end update_options


		function set_opt_a( $opt_a, $field, $value ){

			$id_field = $field->get( 'id' );

			if ( 'WTR_Upload' == get_class( $field  ) ){
				$image_src	= '';
				$image_alt	= '';

				if( is_numeric( $value ) ){
					$image_alt	= esc_attr( get_post_meta( $value, '_wp_attachment_image_alt', true ) );
					$image_src	= wp_get_attachment_image_src( $value, 'full' );
					$image_src	= $image_src[0];
				}elseif ( is_numeric( strpos( $value, '/assets/img/default_images' ) ) ) {
					$image_src	= $value;
				}

				$opt_a[ $id_field . 'Alt' ]	= $image_alt;
				$opt_a[ $id_field . 'Src' ]	= $image_src;
			//Font family
			} else if( strpos( $id_field ,'FontsFont' ) ){

				$font = $value;
				if( "_" == $font[0] ){
					$font = str_replace('_', '', $font );
				} else if( ! isset( $this->font_family[ $font ] ) ){
					$opt_a['wtr_fonts'][ $font ] =  str_replace(' ','+', $font ) . ':400,700italic,700,400italic';
				}
				$css			= $field->get('css');

				if( $css ){
					$important	= ( isset( $css['important'] ) AND true == $css['important'] ) ? ' !important' : '';
					$opt_a['wtr_custom_style_font'][ $id_field ] = sprintf( "%s {%s:%s%s;}", $css['selector'], $css['style'], $font, $important );

				}

			//Font size
			} else if( strpos( $id_field, '_FontsSize' ) ){
				$css			= $field->get( 'css' );
				if( $css ){
					$value		= explode(' ', $value );
					$value		= $value[0];
					$important	= ( isset( $css['important'] ) AND true == $css['important'] ) ? ' !important' : '';
					$opt_a['wtr_custom_style_font_size'][ $id_field ] = sprintf( "%s {%s:%s%s%s;}", $css['selector'], $css['style'],  $value, $field->get( 'has_attr' ), $important );
				}
			}

			return $opt_a;
		} // end set_opt_a


		public function custom_css( $output ){

			if( 1 == $this->getOpt('wtr_CustomeCSS') ){
				$output .= $this->getOpt('wtr_CustomeCssCode');
			}

			return $output;
		}// custom_css


		public function getOpt( $key ){
			return ( isset( $this->opt_a[ $key ] ) ) ? $this->opt_a[ $key ] : null;
		}// end getOpt


		public function font_family(){

			$font_family	= $this->opt_a['wtr_fonts'];
			$subset			= $this->opt_a['wtrFontsGoogleFontSubset'];

			if( is_array( $font_family )  AND ! empty( $font_family ) ){
				$protocol	= is_ssl() ? 'https' : 'http';
				$fonts		= implode("|", $font_family );
				$subset		= ( $subset ) ? '&subset=' . $subset: '';

				wp_enqueue_style( 'google_fonts', $protocol . '://fonts.googleapis.com/css?family=' . $fonts . $subset );
			}
		}// end font_family


		public function load_js(){

			global $post_settings;

			//Countdown translate
			$param = array(
				'y' => $post_settings['wtr_TranslateCountdownSHTYears'],
				'm' => $post_settings['wtr_TranslateCountdownSHTMonths'],
				'w' => $post_settings['wtr_TranslateCountdownSHTWeeks'],
				'd' => $post_settings['wtr_TranslateCountdownSHTDays'] ,
				'h' => $post_settings['wtr_TranslateCountdownSHTHours'],
				'm' => $post_settings['wtr_TranslateCountdownSHTMinutes'],
				's' => $post_settings['wtr_TranslateCountdownSHTSeconds']
			);
			wp_localize_script( 'all_js', 'wtr_countdown_name', $param );

		} // end load_js


		public function wtr_debugging_info() {

			// Require plugin.php to use is_plugin_active() below
			include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

			if ( is_feed() ) return;

			$theme = wp_get_theme( );

			if(is_child_theme()) {
				$theme = wp_get_theme( $theme->get('Template') );
			}

			$developer_log['Theme']			= $theme->get('Name');
			$developer_log['Version']		= $theme->get('Version');
			$developer_log['Installed']		= $theme->get_template();

			$plugins						= array(
				'WTR_CP_PLUGIN_MAIN_FILE',
				'WTR_CS_PLUGIN_FILE',
				'VC_WTR_SHT_PLUGIN_MAIN_FILE',
			);

			foreach ( $plugins as $plugin ) {
				if( defined( $plugin ) ){
					$wtr_plugin								= get_plugin_data( constant( $plugin ) );
					$developer_log[ $wtr_plugin['Name'] ]	= $wtr_plugin['Version'];
				}
			}

			$debugging_info  = "\n\n<!--\n";
			$debugging_info .= "Debugging Info for Theme support:\n";

			foreach ( $developer_log as $log_key => $log ) {
				$debugging_info .= $log_key . ':  ' . $log . "\n";
			}
			$debugging_info .= "-->\n\n";
			echo apply_filters('wtr_debugging_info', $debugging_info );
		}

		public function get_sht_list(){
			return $this->sht_list;
		}// end get_sht_list


		public static function get_WP_SHT_LIST_OPT_NAME(){
			return self::WP_SHT_LIST_OPT_NAME;
		}// end WP_SHT_LIST_OPT_NAME


		public static function get_WP_OPT_NAME(){
			return self::WP_OPT_NAME;
		}// end get_WP_OPT_NAME


		public static function get_WP_EXPORT_OPT_NAME(){
			return self::WP_EXPORT_OPT_NAME;
		}// end get_WP_EXPORT_OPT_NAME


		public static function get_WP_CURRENT_VERSION(){
			return self::WP_CURRENT_VERSION;
		}// end get_WP_CURRENT_VERSION

		public static function get_custom_css_name(){
			return self::$custom_css_name;
		}// end get_WP_CURRENT_VERSION


		public function get_WP_ERROR(){
			return self::WP_ERROR;
		}// end WP_ERROR


		public function get_WP_REWRITE_FLUSH(){
			return self::WP_REWRITE_FLUSH;
		}// end WP_REWRITE_FLUSH
	}//end WTR_admin
}