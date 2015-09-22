<?php

// Don't load directly
if ( !defined('ABSPATH') ) { die('-1'); }

include_once ( VC_WTR_SHT_PLUGIN_LIBS . '/shortcodes/vc_wtr.php' );

class VCExtendAddonWtrSystem extends VCExtendAddonWtr{

	//=== VARIABLES
	private $status = array(
		'vc_enable'					=> false,
		'vc_wtr_shortcode_except'	=> array(),	//e.g. 'wtr_animate'
		'vc_frontend_edit'			=> false,
		'vc_disable_update'			=> true,
		'vc_acceptable_version'		=> '4.3.3'
	);

	public $shtToRemove = array();				//e.g. 'vc_separator'
	public $paramInShtToRemove = array();		//e.g. 'vc_separator' => 'color'

	//=== FUNCTIONS
	public function __construct( $options = array() ) {

		if( is_array( $options ) ){
			$this->status = array_merge( $this->status, $options );
		}

		// We safely integrate with VC
		add_action( 'init', array( $this, 'checkCore' ), 8 );

	}//end __construct


	public function getStatus( $val ){

		if( isset( $this->status[ $val ] ) )
			return $this->status[ $val ];
		else
			return null;

	}//end getStatus


	public function your_prefix_vcSetAsTheme() {
		vc_set_as_theme();
	}// end your_prefix_vcSetAsTheme


	public function checkCore(){

		//I'm checking does Wonster theme is active and whether Wonster Shortcode can be activated
		if( ( ! defined( 'WTR_THEME_VERSION' ) AND ! defined( 'WTR_THEME_NAME' ) ) ){
			add_action( 'admin_notices', array( &$this, 'showAlertThemeDisable') );
			return false;
		}

/*		if( ! defined( 'WTR_CP_PLUGIN_MAIN_FILE' ) ){
			add_action( 'admin_notices', array( &$this, 'admin_custom_type_notice') );
			return;
		}*/

		// Check if Visual Composer is installed
		if ( ! defined( 'WPB_VC_VERSION' ) ){
			$this->status[ 'vc_enable' ] = false;

			// Display notice that Visual Compser is required
			add_action( 'admin_notices', array( &$this, 'showAlertVcDisable' ) );
		}
		else{

			if( version_compare( WPB_VC_VERSION, $this->status[ 'vc_acceptable_version' ], '>=' ) ){
				$this->status[ 'vc_enable' ] = true;
			}
			else{
				add_action( 'admin_notices', array( &$this, 'showalertIncorrectVcVersion' ) );
				$this->status[ 'vc_enable' ] = false;
			}
		}

		// Visual Composer is enabled
		if( $this->status[ 'vc_enable' ] ){

			add_action( 'vc_before_init', array( &$this, 'your_prefix_vcSetAsTheme' ) );

			//hide info about update VC
			vc_set_as_theme( $this->status[ 'vc_disable_update' ] );

			//hide frontend edit option
			if( !$this->status[ 'vc_frontend_edit' ] ){
				vc_disable_frontend();
			}

			// remove default vc shortcode
/*			$this->shtToRemove = array( 'vc_wp_search', 'vc_wp_meta', 'vc_wp_recentcomments', 'vc_wp_calendar', 'vc_wp_pages',
										'vc_wp_tagcloud', 'vc_wp_custommenu', 'vc_wp_text', 'vc_wp_posts', 'vc_wp_links',
										'vc_wp_categories', 'vc_wp_archives', 'vc_wp_rss', 'vc_text_separator', 'vc_tour',
										'vc_toggle', 'vc_widget_sidebar', 'vc_message', 'vc_button', 'vc_button2',
										'vc_cta_button', 'vc_cta_button2', 'vc_carousel', 'vc_gmaps', 'vc_posts_grid',
										'vc_posts_slider', 'vc_separator', 'vc_gallery', 'vc_images_carousel', 'vc_video',
										'vc_pie', 'vc_progress_bar',
										 );*/

			$this->shtToRemove = array( 'vc_wp_search', 'vc_wp_meta', 'vc_wp_recentcomments', 'vc_wp_calendar', 'vc_wp_pages',
										'vc_wp_tagcloud', 'vc_wp_custommenu', 'vc_wp_text', 'vc_wp_posts', 'vc_wp_links',
										'vc_wp_categories', 'vc_wp_archives', 'vc_wp_rss','vc_tour',
										'vc_toggle', 'vc_widget_sidebar', 'vc_message',
										'vc_cta_button', 'vc_cta_button2', 'vc_carousel', 'vc_gmaps', 'vc_posts_grid',
										'vc_posts_slider', 'vc_gallery', 'vc_images_carousel', 'vc_video',
										'vc_pie', 'vc_progress_bar', 'vc_tta_tour',
										 );

			//change only default vc map
			$this->changeDefaultVcMap();

			$this->loadPluginSoruce();
		}
	}//end checkCore


	private function loadPluginShortcodes(){
		include_once VC_WTR_SHT_PLUGIN_SHORTCODES .'/vc_wtr.php';
		$vc_wtr_sht = glob( VC_WTR_SHT_PLUGIN_SHORTCODES .'/vc_wtr_*.php' );

		foreach ( $vc_wtr_sht as $lib ){
			$lib_sh		= explode( '/', $lib );
			$lib_sh		= explode( '.', array_pop( $lib_sh ) );
			$lib_idx	= substr( $lib_sh[ 0 ], 3 );

			if( !in_array( $lib_idx, $this->status[ 'vc_wtr_shortcode_except' ] ) ){
				include_once $lib;
			}
		}

		add_filter( 'the_content', array( &$this, 'wtr_shordcode_content_fix' ) );
	}//end LoadPluginLibs


	static function wtr_shordcode_content_fix( $content ) {

		$shortcode_tags	= join( "|", VCExtendAddonWtr::$sht_list );

		// opening tag
		$content = preg_replace("/(<p>)?\[($shortcode_tags)(\s[^\]]+)?\](<\/p>|<br \/>)?/", "[$2$3]", $content );
		// closing tag
		$content = preg_replace("/(<p>)?\[\/($shortcode_tags)](<\/p>|<br \/>)?/", "[/$2]", $content );

		return $content;
	}//end wtr_shordcode_content_fix


	public function loadCssAndJsVcWtrNewParam(){
		wp_register_style( 'wtr_sht_framework_param_style', trailingslashit( VC_WTR_SHT_PLUGIN_URI ) . 'vc-wtr-admin/shortcodes-param/assets/css/vc-wtr-param.css' );
		wp_enqueue_style( 'wtr_sht_framework_param_style' );
	}//end loadCssAndJsVcWtrNewParam


	public function loadCssAndJsVcWtrPluginPublicArea(){

		$plugin_data = get_plugin_data( VC_WTR_SHT_PLUGIN_MAIN_FILE );

		// Load additional CSS and js in admin area
		if( ! is_admin() ){
			// here wp_enqueue_style
			wp_enqueue_style( 'libs-schortcodes-css', trailingslashit( VC_WTR_SHT_PLUGIN_URI ) . 'assets/css/libs-shortcodes.css' );
			wp_enqueue_style( 'main-schortcodes-css', trailingslashit( VC_WTR_SHT_PLUGIN_URI ) . 'assets/css/shortcodes.css' );

			// here wp_enqueue_script
			wp_enqueue_script('libs-schortcodes-js', trailingslashit( VC_WTR_SHT_PLUGIN_URI ) . 'assets/js/libs-shortcodes.js', null, $plugin_data[ 'Version' ], true );
			wp_enqueue_script('main-schortcodes-js', trailingslashit( VC_WTR_SHT_PLUGIN_URI ) . 'assets/js/shortcodes.js', null, $plugin_data[ 'Version' ], true );
		}
	}//end loadCssAndJsVcWtrPluginPublicArea


	public function loadCssAndJsVcWtrPluginAdminArea(){
		wp_register_style( 'wtr_sht_framework_admin_style', trailingslashit( VC_WTR_SHT_PLUGIN_URI ) . 'vc-wtr-admin/assets/css/vc-icons-conteners.css' );
		wp_enqueue_style( 'wtr_sht_framework_admin_style' );
	}//end loadCssAndJsVcWtrPluginAdminArea


	private function loadPluginSoruce(){
		// Modify the default settings
		if( $this->modifyVCCoreStatus() ){
			add_action( 'init', array( &$this, 'modifyVCCore' ), 9 );
		}

		// Load new params for VC
		add_action( 'current_screen',  array( &$this, 'loadCssAndJsVcWtrNewParam' ), 8 );

		// Add new params for VC
		if( is_admin() ){
			include_once ( VC_WTR_SHT_PLUGIN_LIBS . '/shortcodes-param/vc_wtr_shortcodes_param.php' );
		}

		// Load new shortcode
		$this->loadPluginShortcodes();

		// Load additional CSS and js in public area
		add_action( 'wp_enqueue_scripts', array( &$this, 'loadCssAndJsVcWtrPluginPublicArea' ), 20 );

		// Load additional CSS and js in public admins
		add_action( 'admin_enqueue_scripts', array( &$this, 'loadCssAndJsVcWtrPluginAdminArea' ), 20 );
	}// end loadPluginSoruce


	public static function showAlertThemeDisable() {
		$plugin_data = get_plugin_data( VC_WTR_SHT_PLUGIN_MAIN_FILE );

		echo '<div class="error"  style="margin-left: 0;" >';
			echo '<p>'. sprintf( __( '<strong>%s</strong> - This plugin works only with Symetrio theme created by
							 Wonster Team', 'wtr_sht_framework' ), $plugin_data[ 'Name' ] ) .
				'.</p>';
		echo '</div>';

	}//end showAlertThemeDisable


	public static function admin_custom_type_notice() {
		$plugin_data = get_plugin_data( VC_WTR_SHT_PLUGIN_MAIN_FILE );

		echo '<div class="error"  style="margin-left: 0;" >';
			echo '<p>'. sprintf( __( '<strong>%s</strong> - This plugin works only with <b>WonsterCustom type - Symetrio Edition</b> created by
							 Wonster Team', 'wtr_sht_framework' ), $plugin_data[ 'Name' ] ) .
				'.</p>';
		echo '</div>';
	}//end admin_custom_type_notice


	public function showAlertVcDisable() {
		$plugin_data = get_plugin_data( VC_WTR_SHT_PLUGIN_MAIN_FILE );
		echo '
		<div class="error"  style="margin-left: 0;">
			<p>'.sprintf( __( '<strong>%s</strong> requires <strong>Visual Composer</strong>
				plugin to be activated on your site.', 'wtr_sht_framework' ), $plugin_data[ 'Name' ] ).'
			</p>
		</div>';
	}//end showAlertVcDisable


	public function showalertIncorrectVcVersion(){
		$plugin_data = get_plugin_data( VC_WTR_SHT_PLUGIN_MAIN_FILE );
		echo '
		<div class="error"  style="margin-left: 0;">
			<p>'.sprintf( __( '<strong>%s</strong> requires <strong> Visual Composer</strong> version <strong>%s</strong> to be  activated on your site.
				', 'wtr_sht_framework' ), $plugin_data[ 'Name' ], $this->status[ 'vc_acceptable_version' ] ).'
			</p>
		</div>';
	}//end showalertIncorrectVcVersion


	public function changeDefaultVcMap(){

		vc_map_update( 'vc_raw_html', array (
			'name'			=> __( 'Raw HTML', 'wtr_sht_framework' ),
			'description'	=> '',
			'icon' 			=> 'vc_wtr_raw_html_icon',
			'weight'		=> 19500,
		));

		vc_map_update( 'vc_raw_js', array (
			'name'			=> __( 'Raw JavaScript', 'wtr_sht_framework' ),
			'description'	=> '',
			'icon' 			=> 'vc_wtr_raw_js_icon',
			'weight'		=> 19200,
		));

		vc_map_update( 'vc_googleplus', array (
			'description'	=> '',
			'icon' 			=> 'vc_wtr_google_plus',
			'weight'		=> 28500,
		));

		vc_map_update( 'vc_pinterest', array (
			'description'	=> '',
			'icon'			=> 'vc_wtr_pinteres',
			'weight'		=> 19500,
		));

		vc_map_update( 'vc_facebook', array (
			'description'	=> '',
			'icon'			=> 'vc_wtr_facebook',
			'weight'		=> 29500,
		));

		vc_map_update( 'vc_flickr', array (
			'description'	=> '',
			'icon'			=> 'vc_wtr_flickr',
			'weight'		=> 29250,
		));


		vc_map_update( 'vc_tweetmeme', array (
			'description'	=> '',
			'icon'			=> 'vc_wtr_twitter',
			'weight'		=> 12500,
		));

		vc_map_update( 'vc_single_image', array (
			'description'	=> '',
			'icon' 			=> 'vc_wtr_single_image',
			'weight'		=> 18500,
		));

		vc_map_update( 'vc_empty_space', array (
			'description'	=> '',
			'icon' 			=> 'vc_wtr_empty_space',
			'weight'		=> 29887,
		));

		vc_map_update( 'vc_custom_heading', array (
			'description'	=> '',
			'icon' 			=> 'vc_wtr_custom_heading',
			'weight'		=> 31500,
		));

	}//end changeDefaultVcMap
}// end VCExtendAddonWtrSystem