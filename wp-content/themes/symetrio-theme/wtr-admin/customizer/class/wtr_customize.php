<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

require_once( WTR_ADMIN_CLASS_DIR . '/wtr_export.php' );

if ( ! class_exists( 'WTR_Customize' ) ) {

	class WTR_Customize extends WTR_Core {

		protected static $opt_obj = array() ;

		public function __construct( $option = array() ){

			self::$opt_obj = $option;

			//set option
			add_action( 'init' , array( &$this, 'init' ) );

			// Setup the Theme Customizer settings and controls
			add_action( 'customize_register' , array( &$this, 'register' ) );

			// Enqueue live preview javascript in Theme Customizer admin screen
			add_action( 'customize_preview_init' , array( &$this, 'live_preview' ) );

			//encode settings ( import text / iport auto )
			add_filter( 'wtr_encode_theme_settings', array( &$this, 'encode_settings' ) );
			add_filter( 'wtr_custom_style_save', array( &$this, 'custom_style_save' ), 10, 2 );

			// resporte defaul settings theme
			add_action( 'wtr_default_settings', array( &$this, 'default_settings' ) );

			// impot settings theme
			add_action( 'wtr_import_data', array( &$this, 'import_data' ) );

			add_action( 'customize_controls_enqueue_scripts', array( &$this, 'theme_customize_scripts' ) );

			//update custom css
			add_action( 'update_option_' . WTR_Settings::get_WP_CURRENT_VERSION(), array( &$this, 'update_custom_css') );
			add_action( 'add_option_' . WTR_Settings::get_WP_CURRENT_VERSION(), array( &$this, 'update_custom_css') );

		} // end __construct


		public function  init(){

			$customize		= get_option( WP_CUSTOMIZER_OPT_NAME );
			if( empty( $customize) ){
				$customize = $this->get_default();
				update_option( WP_CUSTOMIZER_OPT_NAME, $customize );
			}
		} // end init

		public function update_custom_css(){

			$customize		= get_option( WP_CUSTOMIZER_OPT_NAME );
			$customize_new	= array();
			$update			= false;

			if( ! empty( $customize) ){

				foreach ( self::$opt_obj as $section ) {
					foreach ( $section->get('settings') as $setting ) {

						$id_setting	= $setting->get('id_setting');
						$selector	= $setting->get('css_selector');

						if( ! isset( $customize[ $id_setting ] ) ) {
							$value	= $setting->get('default');
							$update = true;
						} else if( $customize[ $id_setting ]['style'] != $selector ) {
							$value	= $customize[ $id_setting ]['value'];
							$update = true;
						} else {
							$value	= $customize[ $id_setting ]['value'];
						}

						$customize_new[ $id_setting ]= array( 'value' => $value, 'style' => $selector );
					}
				}

				if( $update OR ( count( $customize ) != count( $customize_new ) AND defined( 'WTR_SHT_PLUGIN_DIR' ) ) ) {
					update_option( WP_CUSTOMIZER_OPT_NAME, $customize_new );
				}

			}
		} // end update_custom_css

		public function theme_customize_scripts() {
			wp_enqueue_script('wtr-customize-script', WTR_CUSTOMIZER_URI . '/wtr_customizer.js');

			$wtr_customize_desc = __( 'To see changes in the public area be sure to set: General Theme Skin on <strong>"Custom"</strong>. <br> To make it happen please go to: Color &gt; General, field: "Theme Skin"', 'wtr_framework' );
			wp_localize_script( 'wtr-customize-script', 'wtr_customize_desc', $wtr_customize_desc );
		} // end theme_customize_style


		public function get_default(){
			foreach ( self::$opt_obj as $section ) {
				foreach ( $section->get('settings') as $setting ) {
					$customize[ $setting->get('id_setting') ] = array( 'value' => $setting->get('default') , 'style' => $setting->get('css_selector') );
				}
			}
			return  $customize;
		} // end get_default


		public function custom_style_save( $output, $WTR_Opt ){

			$theme_skin = $WTR_Opt->getopt('wtr_ColorThemeSkin');
			if( 'custom' == $theme_skin ){
				$output	.= "\n\n/* Colors */ \n\n";
				$output	.= $this->get_customizer_styles( null, "\n" );
			}else {
				global $wtr_theme_skins_colors;
				$setting	= $wtr_theme_skins_colors [ $theme_skin ];
				$customizer	= json_decode( $setting, true );

				$output	.= "\n\n/* Colors */ \n\n";
				$output	.= $this->get_customizer_styles( $customizer, "\n" );
			}
			return $output;
		} // cend custom_style_save


		public function customizer_style( $output ){
			$customizer_styles = $this->get_customizer_styles();
			$output .= $customizer_styles;
			return $output;
		}// end customizer_style


		public function live_preview() {

			$zilb		= ini_get('zlib.output_compression' );
			$firefox	= isset( $_SERVER['HTTP_USER_AGENT'] ) ? preg_match('/Firefox/i', $_SERVER['HTTP_USER_AGENT'] ) : 0;

			// fix bug  https://core.trac.wordpress.org/ticket/22430
			if( $zilb AND $firefox ){
				remove_action( 'shutdown', 'wp_ob_end_flush_all', 1 );
			}

			add_action( 'wp_footer', array( &$this, 'admin_scripts' ),  20 );
		} //end live_preview


		public  function register ( $wp_customize ) {

			//custom style
			add_filter( 'wtr_custom_css', array( &$this, 'customizer_style' ), 10, 2 );

			// remove Sections
			$wp_customize->remove_section('static_front_page');
			$wp_customize->remove_section('title_tagline');
			$wp_customize->remove_section('colors');
			$wp_customize->remove_section('header_image');
			$wp_customize->remove_section('nav');
			$wp_customize->remove_section('background_image');

			foreach ( self::$opt_obj as $section ) {

				//1. Define a new section (if desired) to the Theme Customizer
				$section->add_section( $wp_customize );

				foreach ( $section->get('settings') as $setting ) {
					//2. Register new settings to the WP database...
					$setting->add_setting( $wp_customize );
					//3. Finally, we define the control itself (which links a setting to a section and renders the HTML controls)..
					$setting->add_control( $wp_customize );
				}
			}

		} // end register

		function admin_scripts(){
?>
			<script type="text/javascript">
				function hex2rgb(hex) {
					if (hex[0]=="#") {hex=hex.substr(1)};
					if (hex.length==3) {
						var temp=hex; hex='';
						temp = /^([a-f0-9])([a-f0-9])([a-f0-9])$/i.exec(temp).slice(1);
						for (var i=0;i<3;i++) hex+=temp[i]+temp[i];
					}
					var triplets = /^([a-f0-9]{2})([a-f0-9]{2})([a-f0-9]{2})$/i.exec(hex).slice(1);
					return {
						red: parseInt(triplets[0],16),
						green: parseInt(triplets[1],16),
						blue: parseInt(triplets[2],16)
					}
				}

				( function( $ ) {


				<?php
					foreach ( self::$opt_obj as $section ) {
						foreach ( $section->get('settings') as $setting ) {

							$css_custom 	= $setting->get('css_custom');
							$css_important	= $setting->get('css_important');

							echo "wp.customize( '" . $setting->get('id') . "', function( value ) { ";
							echo "value.bind( function( newval ) {";

							if( is_array( $css_custom ) AND isset( $css_custom['type'] ) AND 'rgba' ==  $css_custom['type'] ) {
								echo 'var rgb = hex2rgb(newval); ';
								echo 'newval = " rgba("+rgb.red+","+rgb.green+","+rgb.blue+",' . $css_custom['value'] . ')";';
							}

							echo "var important = '';";
							if( true == $css_important ){
								echo "important = 'important';";
							}

							echo "$('" . $setting->get('css_selector') . "').each(function () {this.style.setProperty( '" . $setting->get( 'css_style' ). "', newval, important ); } ); } ); } );";
						}
					}
				?>
				} )( jQuery );
			</script>
			<?php
		} // end admin_scripts


		public function get_customizer_styles( $customize = "", $separator = "" ){

			if( empty( $customize ) ){
				$customize	= get_option( WP_CUSTOMIZER_OPT_NAME );
			}
			$output		='';

			foreach ( self::$opt_obj as $section ) {
				foreach ( $section->get('settings') as $setting ) {
					if( isset( $customize[ $setting->get( 'id_setting') ] ) ){

						$css_important	= $setting->get('css_important');
						$css_custom 	= $setting->get('css_custom');


						$setting_db	= $customize[ $setting->get( 'id_setting') ];
						$value		= $setting_db['value'];


						if( is_array( $css_custom ) AND isset( $css_custom['type'] ) AND 'rgba' ==  $css_custom['type'] ){
							$value =  $this->hex2rgba( $value , $css_custom['value'] ) ;
						}

						if( true == $css_important ) {
							$value .= ' !important ';
						}

						if( $value ) {
							$output .= sprintf( "%s {%s:%s;} $separator", $setting->get( 'css_selector'), $setting->get( 'css_style' ) , $value );
						}
					}
				}
			}
			return $output;
		} // end get_customizer_styles


		private function hex2rgba( $hex , $alpha_channel ) {
			$hex = str_replace("#", "", $hex);

			if(strlen($hex) == 3) {
				$r = hexdec(substr($hex,0,1).substr($hex,0,1));
				$g = hexdec(substr($hex,1,1).substr($hex,1,1));
				$b = hexdec(substr($hex,2,1).substr($hex,2,1));
			} else {
				$r = hexdec(substr($hex,0,2));
				$g = hexdec(substr($hex,2,2));
				$b = hexdec(substr($hex,4,2));
			}

			$rgba = "rgba( $r, $g, $b, $alpha_channel)";
			return $rgba;
		} // end hex2rgba


		public function import_data( $data ){

			if( isset( $data[ WP_CUSTOMIZER_OPT_NAME ] ) ) {
				update_option( WP_CUSTOMIZER_OPT_NAME, $data[ WP_CUSTOMIZER_OPT_NAME ] );
			}
		} // end import_data


		public function default_settings(){
			delete_option( WP_CUSTOMIZER_OPT_NAME );
		} // end default_settings


		public function encode_settings( $options ){
			$options[ WP_CUSTOMIZER_OPT_NAME ]  = get_option( WP_CUSTOMIZER_OPT_NAME );
			return $options;
		} // end encode_settings


	} // end WTR_Customize
}