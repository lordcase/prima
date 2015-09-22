<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

if ( !defined('ABSPATH') ) { die('-1'); }

if( ! function_exists( 'symetrio_setup' ) ){

	// theme setup
	function symetrio_setup() {

		// Adds RSS feed links to <head> for posts and comments.
		add_theme_support( 'automatic-feed-links' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menu( 'primary', __( 'Primary Menu', 'wtr_framework' ) );

		// This theme uses a custom image size for featured images, displayed on "standard" posts.
		add_theme_support( 'post-thumbnails' );

		// custom image size
		add_image_size( 'size_1', 404, 200, true );
		add_image_size( 'size_2', 512, 512, true );
		add_image_size( 'size_3', 750, 500, true );
		add_image_size( 'size_4', 1200, 600, true );
		add_image_size( 'size_5', 1920, 1080, true );

	} // end symetrio_setup
}
add_action( 'after_setup_theme', 'symetrio_setup' );


if( ! function_exists( 'wtr_custom_image_siz' ) ){

	// customowe size of a picture when you select this
	function wtr_custom_image_siz( $sizes ) {

		global $_wp_additional_image_sizes;

		if( ! empty( $_wp_additional_image_sizes ) ) {
			foreach ( $_wp_additional_image_sizes as $key => $value ) {
				if ( ! isset($sizes[ $key ]) ){
					$sizes[ $key ] = ucfirst( str_replace( '_', ' ', $key ) );
				}
			}
		}
		return $sizes;
	} // end wtr_custom_sizes
}
add_filter( 'image_size_names_choose', 'wtr_custom_image_siz' );


if( ! function_exists( 'wtr_admin_bar_render' ) ){

	// a link to the theme settings in the admin bar
	function wtr_admin_bar_render() {
		if( current_user_can( 'manage_options' ) ){
			global $wp_admin_bar;
			$wp_admin_bar->add_menu( array(
				'parent' => false, 		// use 'false' for a root menu, or pass the ID of the parent menu
				'id' => 'wtr_options', 	// link ID, defaults to a sanitized title value
				'title' => sprintf( __( 'Theme Option -  %1$s', ucfirst( WTR_THEME_NAME ) ), WTR_THEME_NAME ), // link title
				'href' => admin_url( 'themes.php?page=wtr_theme_page'), // name of file
				'meta' => false 		// array of any of the following options: array( 'html' => '', 'class' => '', 'onclick' => '', target => '', title => '' );
			));
		}
	} // end wtr_admin_bar_render
}
add_action( 'wp_before_admin_bar_render', 'wtr_admin_bar_render' );


if( ! function_exists( 'wtr_scripts_styles' ) ){

	// public style / script
	function wtr_scripts_styles() {

		if( ! is_admin() ) {

			global $post_settings;
			$source_css			= get_option( 'WP_SOURCE_CSS');
			$custom_css_name	= ( 1 == $source_css ) ? WTR_Settings::get_custom_css_name() . '.css' : 'style-custom.php';

			wp_enqueue_style( 'style-css', get_stylesheet_uri() );

			wp_enqueue_style( 'all_css', WTR_THEME_URI . '/assets/css/all_css.css' );
			wp_enqueue_style( 'site', WTR_THEME_URI . '/assets/css/site.css' );
			wp_enqueue_style( 'widgets', WTR_THEME_URI . '/assets/css/widgets.css' );
			wp_enqueue_style( 'animation_css', WTR_THEME_URI . '/assets/css/animation_css.css' );
			wp_enqueue_style( 'font_awesome', WTR_THEME_URI . '/assets/css/font-awesome.min.css' );
			wp_enqueue_style( 'style_custom' , WTR_THEME_URI . '/' . $custom_css_name );

			wp_enqueue_script('modernizr_custom', WTR_THEME_URI . '/assets/js/modernizr.custom.js', null, WTR_THEME_VERSION, true );
			wp_enqueue_script( 'jquery' );
			wp_enqueue_script('all_js', WTR_THEME_URI . '/assets/js/all_js.js', null, WTR_THEME_VERSION, true );
			wp_enqueue_script('main', WTR_THEME_URI . '/assets/js/main.js', null, WTR_THEME_VERSION, true );

			//localize
			$param = array(
				'theme_url' => WTR_THEME_URI,
			);
			wp_localize_script( 'main', 'wtr_main_theme_data', $param );

			// Comment Script
			if ( is_singular() AND get_option( 'thread_comments' ) ){
				wp_enqueue_script( 'comment-reply', false, WTR_THEME_VERSION, true  );
			}

		}
	} // end wtr_scripts_styles
}
add_action( 'wp_enqueue_scripts', 'wtr_scripts_styles', 20 );


if( ! function_exists( 'wtr_responsive_styles' ) ){

	// public responsive
	function wtr_responsive_styles(){
		if( ! is_admin() ) {

			global $post_settings;

			if( 1 == $post_settings['wtr_GlobalResponsive'] ){
				wp_enqueue_style( 'responsive', WTR_THEME_URI . '/assets/css/responsive.css' );
			}
		}
	} // end wtr_responsive_styles
}
add_action( 'wp_enqueue_scripts', 'wtr_responsive_styles', 200 );


if( ! function_exists( 'wtr_content_width' ) ){

	// Adjust content width
	function wtr_content_width() {
		global $content_width, $post_settings;

/*		if ( ( 'setNone' == $post_settings['wtr_SidebarPosition'] AND  is_page() )){
			$content_width = 1200;
		} else if ( 'setNone' !== $post_settings['wtr_SidebarPosition'] AND  is_page() ){
			$content_width = 784;
		} else if ( 'setNone' == $post_settings['wtr_SidebarPosition'] AND  is_single() AND ! is_attachment() ){
			$content_width = 960;
		} else if ( 'setNone' !== $post_settings['wtr_SidebarPosition'] AND  is_single() AND ! is_attachment() ){
			$content_width = 627;
		}*/
	}
}
add_action( 'template_redirect', 'wtr_content_width' );


if( ! function_exists( 'wtr_register_required_plugins' ) ){

	// activation plug-ins
	function wtr_register_required_plugins() {

		/**
		 * Array of plugin arrays. Required keys are name and slug.
		 * If the source is NOT from the .org repo, then source is also required.
		 */
		$plugins = wtr_update_required_plugins();

		// Change this to your theme text domain, used for internationalising strings
		$theme_text_domain = 'wtr_framework';

		/**
		 * Array of configuration settings. Amend each line as needed.
		 * If you want the default strings to be available under your own theme domain,
		 * leave the strings uncommented.
		 * Some of the strings are added into a sprintf, so see the comments at the
		 * end of each line for what each argument will be.
		 */
		$config = array(
			'id'           => 'tgmpa',                 // Unique ID for hashing notices for multiple instances of TGMPA.
			'default_path' => '',                      // Default absolute path to bundled plugins.
			'menu'         => 'tgmpa-install-plugins', // Menu slug.
			'parent_slug'  => 'themes.php',            // Parent menu slug.
			'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
			'has_notices'  => true,                    // Show admin notices or not.
			'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
			'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
			'is_automatic' => false,                   // Automatically activate plugins after installation or not.
			'message'      => '',                      // Message to output right before the plugins table.
		);
		tgmpa( $plugins, $config );
	} // wtr_register_required_plugins
}
add_action( 'tgmpa_register', 'wtr_register_required_plugins' );


if( ! function_exists( 'wtr_public_settings' ) ){

	// set options on demand from a location on page
	function wtr_public_settings(){

		global $post , $post_settings, $wtr_translate, $wtr_date_format, $wtr_post_type;

		// translation of OP files
		if( 0 == $post_settings['wtr_TranslateTranslationSettings'] ) {
			foreach( $wtr_translate as $key => $vlaue ){
				$post_settings[ $key ] = $vlaue;
			}
		}

		// get type
		if( ( is_single() OR is_page() ) AND empty( $wtr_post_type ) ){
			$wtr_post_type					= $post->post_type;
			$post_settings['template']		= get_post_meta( $post->ID, '_wp_page_template', true );
		} else {
			$post_settings['template']		= '';
		}

		$wtr_post_type = apply_filters( 'wtr_post_type', $wtr_post_type, $post_settings['template'] );



		// Defualt settings
		// wtr_Boxed
		$post_settings['wtr_Boxed']							= $post_settings['wtr_GlobalBoxed'];
		// BreadCrumbs
		$post_settings['wtr_BreadCrumbsContainer']			= $post_settings['wtr_HeaderBreadCrumbsContainer'];
		$post_settings['wtr_BreadCrumbs']					= $post_settings['wtr_HeaderBreadCrumbs'];
		$post_settings['wtr_BreadCrumbsBackgroundImg']		= $post_settings['wtr_HeaderBreadCrumbsBackgroundImg'];
		$post_settings['wtr_BreadCrumbsBackgroundImgSrc']	= $post_settings['wtr_HeaderBreadCrumbsBackgroundImgSrc'];

		// Nav menu
		$post_settings['wtr_HeaderCleanMenuMod']			= 0;
		$post_settings['wtr_page_nav_menu']					= '';
		$post_settings['wtr_HeaderTransparentMode'] 		= 0;


		// Default Blog settings
		// Date foramt
		$post_settings['wtr_BlogDateFormat']				= $wtr_date_format[ $post_settings['wtr_BlogDefaultBlogDateFormat'] ];
		// Sidebar
		$post_settings['wtr_SidebarPosition']				= $post_settings['wtr_SidebarPositionOnBlog'];
		$post_settings['wtr_Sidebar']						= $post_settings['wtr_SidebarPickOnBlog'];
		// Post content
		$post_settings['wtr_BlogShowMeta']					= $post_settings['wtr_BlogShowMeta'];
		$post_settings['wtr_Categories']					= $post_settings['wtr_BlogCategoriesInPost'];
		$post_settings['wtr_ShowTags']						= $post_settings['wtr_BlogShowTagsInBlogPost'];
		$post_settings['wtr_SocialMediaToolbar']			= $post_settings['wtr_BlogSocialMediaToolbar'];
		$post_settings['wtr_ShowAuthorBio']					= $post_settings['wtr_BlogShowAuthorBio'];
		//RelatedPosts
		$post_settings['wtr_BlogRelatedPosts']				= $post_settings['wtr_BlogRelatedPosts'];
		$post_settings['wtr_BlogRelatedPostsOrderBy']		= $post_settings['wtr_BlogRelatedPostsOrderBy'];
		$post_settings['wtr_BlogRelatedPostsBy']			= $post_settings['wtr_BlogRelatedPostsBy'];


		// Default Events settings
		$post_settings['wtr_EventDateFormat']				= $wtr_date_format[ $post_settings['wtr_EventPostDateFormat'] ];


		// archive page
		if ( is_archive() ){
			$post_settings['wtr_SidebarPosition']			= $post_settings['wtr_SidebarPositionOnArchive'];
			$post_settings['wtr_Sidebar']					= $post_settings['wtr_SidebarPickOnArchive'];
		// search page
		} else if( is_search() ){
			$post_settings['wtr_SidebarPosition']			= $post_settings['wtr_SidebarPositionOnSearch'];
			$post_settings['wtr_Sidebar']					= $post_settings['wtr_SidebarPickOnSearch'];
		// 404 page
		} else if( is_404() ){
			$post_settings['wtr_FooterSettings']			= 0;
			$post_settings['wtr_HeaderSettings']			= 0;
			$post_settings['wtr_BreadCrumbsContainer']		= 0;
		//others
		} else {
			$post_settings									= apply_filters( 'wtr_post_settings_stream', $post_settings, $wtr_post_type );
		}

		$post_settings = apply_filters( 'wtr_post_settings_default_' . $wtr_post_type , $post_settings );

		// single post settings
		if ( ( is_singular( ) AND ! is_attachment() ) OR is_preview() ) {

			$post_settings_single = array();
			// post
			if ( 'post' == $wtr_post_type ) {

				$post_settings['wtr_BreadCrumbsContainer']	= $post_settings['wtr_BlogBreadCrumbsContainer'];
				$post_settings['wtr_BreadCrumbs']			= $post_settings['wtr_BlogBreadCrumbs'];

				$post_settings_single = array(
					'wtr_SidebarPosition'			=> '_wtr_SidebarPosition',
					'wtr_Sidebar'					=> '_wtr_Sidebar',
					'wtr_BlogSingleStyle'			=> '_wtr_BlogStyle',
					'wtr_BlogRelatedPosts'			=> '_wtr_RelatedPosts',
					'wtr_BlogRelatedPostsOrderBy'	=> '_wtr_RelatedPostsOrderBy',
					'wtr_BlogRelatedPostsBy'		=> '_wtr_RelatedPostsBy',
					'wtr_CustomCssForPage'			=> '_wtr_CustomCssForPage',
					'wtr_SeoTitle'					=> '_wtr_SeoTitle',
					'wtr_SeoDescription'			=> '_wtr_SeoDesc',
					'wtr_SeoKeywords'				=> '_wtr_SeoKey',
					'wtr_NoRobot'					=> '_wtr_NoRobot',
				);
			// page
			} else if ( 'page' == $wtr_post_type ) {

				$post_settings_single = array(
					'wtr_SidebarPosition'		=> '_wtr_SidebarPosition',
					'wtr_Sidebar'				=> '_wtr_Sidebar',
					'wtr_Boxed'					=> '_wtr_Boxed',
					'wtr_BackgroundImg'			=> '_wtr_BackgroundImg',
					'wtr_HeaderSettings'		=> '_wtr_HeaderSettings',
					'wtr_HeaderType'			=> '_wtr_HeaderType',
					'wtr_BreadCrumbsContainer'	=> '_wtr_BreadCrumbsContainer',
					'wtr_BreadCrumbs'			=> '_wtr_BreadCrumbs',
					'wtr_FooterSettings'		=> '_wtr_FooterSettings',
					'wtr_page_nav_menu'			=> '_wtr_page_nav_menu',
					'wtr_CustomCssForPage'		=> '_wtr_CustomCssForPage',
					'wtr_SeoTitle'				=> '_wtr_SeoTitle',
					'wtr_SeoDescription'		=> '_wtr_SeoDesc',
					'wtr_SeoKeywords'			=> '_wtr_SeoKey',
					'wtr_NoRobot'				=> '_wtr_NoRobot',
					'wtr_HeaderTransparentMode'	=> '_wtr_transparent_mode',
					'wtr_HeaderCleanMenuMod'	=> '_wtr_clean_menu_mod'
				);
			}

			$post_settings_single = apply_filters( 'wtr_post_settings_single_post_' . $wtr_post_type , $post_settings_single );

			foreach ( $post_settings_single as $key => $value) {

				$single	= true;
				if( is_array( $value ) ){
					$single	= isset( $value['single'] ) ?  $value['single'] : true;
					$value	= $value['value'] ?  $value['value'] : '';
				}

				if( '' !== get_post_meta( $post->ID , $value, $single ) ){
					$value =  get_post_meta( $post->ID , $value, $single );
				} else if ( isset( $post_settings[ $key ] )) {
					$value = $post_settings[ $key ];
				} else {
					$value = '';
				}

				$post_settings[ $key ] = $value;
			}
		}

		// setting final
		$post_settings = apply_filters( 'wtr_post_settings', $post_settings );


		//custom sidebar
		$sidebar_id = str_replace( '-', urlencode('&#45;'), $post_settings['wtr_Sidebar'] );
		$sidebar_id = sanitize_title( str_replace( "%",'', $sidebar_id ) );
		$sidebar_id = 'custom-sidebar-' . $sidebar_id;
		$post_settings['wtr_Sidebar'] = $sidebar_id;



		// SEO
		$post_settings['wtr_SeoTitleHome']	= ( 0 == $post_settings['wtr_SeoSwich'] OR empty( $post_settings['wtr_SeoTitleHome'] ) ) ? get_bloginfo( 'name' ) : $post_settings['wtr_SeoTitleHome'];
		$post_settings['wtr_SeoTitle']		= ( ! empty( $post_settings['wtr_SeoTitle'] ) ) ? esc_attr( $post_settings['wtr_SeoTitle'] ) : get_the_title( );


		//Boxed
		if( 1 == $post_settings['wtr_Boxed'] ){
			$post_settings['wtr_Boxed_start']	= '<div class="boxed">';
			$post_settings['wtr_Boxed_end']		= '</div>';
		} else {
			$post_settings['wtr_Boxed_start']	= '';
			$post_settings['wtr_Boxed_end']		= '';
		}

		// checking whether Disqus is on
		$active_plugins = get_option( 'active_plugins' );

		if ( in_array( 'disqus-comment-system/disqus.php', $active_plugins ) ){
			$post_settings['wtr_disqus_status'] = 1;
		} else {
			$post_settings['wtr_disqus_status'] = 0;
		}


		// posts | sidebar class
		switch ( $post_settings['wtr_SidebarPosition'] ) {

			case 'setLeftSide':
				$post_settings['wtr_ContentInClass']['main']	= 'wtrLeftSide';
				$post_settings['wtr_ContentInClass']['content']	= 'wtrContentSidebar wtrContentSidebarLeft';
				$post_settings['wtr_ContentInClass']['sidebar']	= 'wtrContentCol wtrSidebar wtrSidebarLeft wtrSidebarWdg clearfix';
				break;

			case 'setRightSide':
				$post_settings['wtr_ContentInClass']['main']	= '';
				$post_settings['wtr_ContentInClass']['content'] = 'wtrContentSidebar wtrContentSidebarRigh';
				$post_settings['wtr_ContentInClass']['sidebar'] = 'wtrContentCol wtrSidebar wtrSidebarRight wtrSidebarWdg clearfix';
				break;

			case 'setNone':
			default:
				$post_settings['wtr_ContentInClass']['main']	= '';
				$post_settings['wtr_ContentInClass']['content'] = 'wtrContentNoSidebar';
				$post_settings['wtr_ContentInClass']['sidebar'] = '';
				break;
		}

		// default  blog thumbil
		$post_settings['wtr_DefalutThumbnail']		= WTR_THEME_URI . '/assets/img/default_images/default.jpg';



		// review post
		if( $wtr_post_type AND ! is_single() ){
/*			if ( 1 == $post_settings['wtr_BlogStreamStyle'] ) {
				$post_settings['wtr_ContentInClass']['content']	.= ' wtrBlogStreamModern';
				$post_settings['wtr_BlogContainerStart']		= '<div class="wtrBlogStreamModernContainer clearfix"><div class="wtrBlogModernPostRow clearfix">';
				$post_settings['wtr_BlogContainerEnd']			= '</div></div>';
			} else {
				$post_settings['wtr_ContentInClass']['content']	.= ' wtrBlogStreamStd';
				$post_settings['wtr_BlogContainerStart']		= '';
				$post_settings['wtr_BlogContainerEnd']			= '';
			}*/
		}

		// single
		if( is_single() ) {

			// post
			if( 'post' == $wtr_post_type ){

				//modern post
				$post_settings['wtr_ContentInClass']['main'] .= ( 1 == $post_settings['wtr_BlogSingleStyle'] ) ? ' wtrModernBlogPost' : '' ;
			}
		}

		// footer
		switch ( $post_settings['wtr_FooterColumnNumber'] ) {

			case 'setOne':
			default:
				$post_settings['wtr_FooterColumns']	= 1;
				$post_settings['wtr_FooterClass']	= 'wtrColOne';
				break;

			case 'setTwo':
				$post_settings['wtr_FooterColumns']	= 2;
				$post_settings['wtr_FooterClass']	= 'wtrColOneTwo';
				break;

			case 'setThree':
				$post_settings['wtr_FooterColumns']	= 3;
				$post_settings['wtr_FooterClass']	= 'wtrColOneThird';
				break;

			case 'setFour':
				$post_settings['wtr_FooterColumns']	= 4;
				$post_settings['wtr_FooterClass']	= 'wtrColOneFourth';
				break;
		}

		// footer background
		if( $post_settings['wtr_FooterBackgroundImgSrc'] ){
			$post_settings['wtr_FooterClassImg']		= 'wtrFooterBgImage';
			$post_settings['wtr_FooterStyle']			= 'style="background-image: url( \'' . $post_settings['wtr_FooterBackgroundImgSrc'] .'\');"';
			$post_settings['wtr_FooterContainerClass']	= 'wtrTransaprentBg';
		}else{
			$post_settings['wtr_FooterClassImg']		= '';
			$post_settings['wtr_FooterStyle']			= '';
			$post_settings['wtr_FooterContainerClass']	= '';
		}

		// header pusher class
		$post_settings['wtr_HeaderPusherClass'] 		= ( 0 == $post_settings['wtr_HeaderMobileNavigationType'] ) ? ' wtrSimpleNavEnabled' : '';

		if ( 1 == $post_settings['wtr_HeaderType'] AND 1 == $post_settings['wtr_HeaderTransparentMode'] ) {
			$post_settings['wtr_HeaderPusherClass'] 		.= ' wtrBH';
		} else if ( 1 == $post_settings['wtr_HeaderType'] ) {
			$post_settings['wtr_HeaderPusherClass'] 		.= ' wtrBNTH';
		} else {
			$post_settings['wtr_HeaderPusherClass'] 		.= ' wtrSH';
		}

		// footer cols
		$post_settings['wtr_FooterWidgets_0']	= 'footer-column-0';
		$post_settings['wtr_FooterWidgets_1']	= 'footer-column-1';
		$post_settings['wtr_FooterWidgets_2']	= 'footer-column-2';
		$post_settings['wtr_FooterWidgets_3']	= 'footer-column-3';
		$post_settings['wtr_FooterWidgets_4']	= 'footer-column-4';

		$post_settings = apply_filters( 'wtr_post_settings_final', $post_settings );

	} // end wtr_public_settings
}
add_action( 'wp', 'wtr_public_settings');