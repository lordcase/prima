<?php
/**
 * head functions
 *
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

if ( !defined('ABSPATH') ) { die('-1'); }

if( ! function_exists( 'wtr_header' ) ){

	// header ,positioning logos and type, drawing menu
	function wtr_header(){
		global $post_settings, $wtr_post_type;

		if ( 0 == $post_settings['wtr_HeaderSettings'] ) {
			return;
		}

		$LogoPosition			= $post_settings['wtr_HeaderLogoPosition'];
		$LogoImage				= ( $post_settings['wtr_HeaderLogoImageSrc'] ) ? '<img class="wtrLogoWebsite wtrLogoAnimate" src="' . $post_settings['wtr_HeaderLogoImageSrc'] .'" alt="' . $post_settings['wtr_HeaderLogoImageAlt'] .'">' : '';
		$LogoImagetransparent	= ( $post_settings['wtr_HeaderLogoImageTransparentSrc'] ) ? '<img class="wtrLogoWebsite wtrLogoAnimate" src="' . $post_settings['wtr_HeaderLogoImageTransparentSrc'] .'" alt="' . $post_settings['wtr_HeaderLogoImageTransparentAlt'] .'">' : '';

		$clean_menu_class		= ( 1 == $post_settings['wtr_HeaderCleanMenuMod'] ) ? 'wtrCleanMenu': '';
		$navigation_type		= $post_settings['wtr_HeaderNavigationType'];
		$navigation_type_data	= 'data-mode="' . $post_settings['wtr_HeaderNavigationType'] . '"';
		$transparent_mode		= $post_settings['wtr_HeaderTransparentMode'];
		$transparent_data		= ( $transparent_mode ) ? 'data-logo-normal="' . $post_settings['wtr_HeaderLogoImageSrc'] . '" data-logo-trans="' . $post_settings['wtr_HeaderLogoImageTransparentSrc'] . '"' : '';
		$LogoImage				= ( 1 == $transparent_mode AND $LogoImagetransparent ) ? $LogoImagetransparent : $LogoImage;
		$logo					= '';
		$simplified_class		= 'wtrSimplifiedMenu';

		$menu					= get_theme_mod('nav_menu_locations');
		$menu_primary_status	= 0;
		if( isset( $menu['primary'] ) AND ! empty( $menu['primary'] ) ){
			$primary_menu			= wp_get_nav_menu_object( $menu['primary'] );
			$menu_primary_status	= $primary_menu->count;
		}
		$menu_primary_class			= ( empty( $menu_primary_status ) ) ? 'wtrNoMenu' : '';

		// pozycja loga
		switch ( $LogoPosition ) {
			case '0': // Left
			default:
				$logo_class			= "wtrLogo wtrFloatLeft ";
				$container_class	= "wtrNavigation wtrFloatRight";
				$menu_class			= "wtrMainNavigation clearfix";
				break;
			case '1': // Right
				$logo_class			= "wtrLogo wtrFloatRight ";
				$container_class	= "wtrNavigation wtrFloatLeft";
				$menu_class			= "wtrMainNavigation clearfix";
				break;
		}

		$header_style	= '';
		$menu_style		= '';

		//create main menu

		$wtr_main_menu_str_2 = $wtr_main_menu_str = wtr_wp_nav_menu( $container_class, $menu_class, $menu_style );

		$pos = strpos( $wtr_main_menu_str, "wtr-menu-1" );
		if ($pos !== false) {
			$wtr_main_menu_str_2 = substr_replace( $wtr_main_menu_str, "wtr-menu-0", $pos, strlen( "wtr-menu-1" ) );
		}

		$navigation_class	= ( $wtr_main_menu_str_2 ) ? 'wtrAnimateNavigation': 'wtrNoNavigation';
		$transparent_class	= '';
		$header_type_class	= ( $post_settings['wtr_HeaderType'] == 1 ) ? ' wtrHeaderBoxed' : '';

		//standard & smart header
		if( '0' == $navigation_type || '2' == $navigation_type ){
			if( '1' == $transparent_mode ){
				$transparent_class = ' wtrHeaderTransparent ';
			}

			if( '2' == $navigation_type ){
				$transparent_class .= ' wtrSmartMenuOn ';
			}
		}
		//sticky header
		else if( '1' == $navigation_type && '1' == $transparent_mode ){
			$transparent_class = ' wtrHeaderTransparent wtrHeaderFixed ';
		}

		// logo
		if( 3 != $post_settings['wtr_HeaderSettings'] ) {
			$logo				= '<a class="'. $logo_class.' " '. $header_style .' href="' . esc_url( home_url() ) . '">' . $LogoImage . '</a>';
			$simplified_class	= '';
		}


		echo '<header class="wtrHeader wtrAnimate wtrHeaderColor' . $header_type_class . ' ' . $transparent_class . ' ' . $simplified_class . ' ' . $clean_menu_class . ' " '. $transparent_data . ' '. $navigation_type_data .'>';
			wtr_header_section();
			echo '<div class="wtrMainHeader">';
				echo '<div class="wtrInner ' . $navigation_class . ' clearfix">';
					echo $logo;
					if( 0 == $post_settings['wtr_HeaderMobileNavigationType']) {
						echo '<div class="wtrMobileMenu"> <span>' . $post_settings['wtr_TranslateHomeMobileMenu'] . '</span> </div>';
					}
					echo $wtr_main_menu_str_2;
				echo '</div>';
			echo '</div>';
		echo '</header>';

		if( '1' == $navigation_type && '0' == $transparent_mode ){

			if( !is_admin_bar_showing() ){
				$top_class = 'wtrHeaderFixedTop';
			}else{
				$top_class = 'wtrHeaderFixedTopAdmin';
			}

			echo '<header class="wtrHeaderSecond wtrDisplayHide wtrHeaderFixed wtrAnimate wtrHeaderColor ' . $header_type_class . ' ' . $top_class . '  ' . $simplified_class . ' ' . $clean_menu_class . ' ' . $menu_primary_class . ' " '. $transparent_data . ' '. $navigation_type_data .'>';
				wtr_header_section();
				echo '<div class="wtrMainHeader">';
					echo '<div class="wtrInner wtrAnimateNavigation clearfix">';
						echo $logo;
						echo $wtr_main_menu_str;
					echo '</div>';
				echo '</div>';
			echo '</header>';
		}
	}// end wtr_header
}


if( ! function_exists( 'wtr_breadcrumbs' ) ){

	// bread crumbs
	function wtr_breadcrumbs(){

		global $post, $wp_query, $post_settings, $wtr_post_type;

		// BreadCrumbs Center OFF
		if( 0 == $post_settings['wtr_BreadCrumbsContainer'] ) {
			return;
		}

		$home				= $post_settings['wtr_TranslateHomeBreadcrumbsMainPage'];
		$homeLink			= home_url();
		$output				= '';
		$outputTitle		= '';
		$homeName			= $post_settings['wtr_TranslateHomeBreadcrumbsBlog'];
		$output_crumbs		= array();
		$output_crumbs[]	= array( 'url' => $homeLink, 'name' => $home );
		// BLOG category
		if( is_category() ) {
			$term				= get_term_by( 'id', get_query_var( 'cat' ),'category' );
			$outputTitle		= $post_settings['wtr_TranslateBlogCrumbsArchiveForCategory'] . " " . single_cat_title( '', false );
			$output_crumbs		= wtr_breadcrumbs_blog_page( $homeName, $output_crumbs );
			$output_crumbs		= wtr_breadcrumbs_parents_terms( $term, $output_crumbs, false );

		// Blog tag
		} elseif( is_tag() ) {
			$output_crumbs		= wtr_breadcrumbs_blog_page( $homeName, $output_crumbs );
			$output_crumbs[]	= array( 'name' => single_tag_title( '', false ) );
			$outputTitle		= $post_settings['wtr_TranslateBlogCrumbsTagArchivefor'] ." ". single_tag_title( '', false );

		// Blog author
		} elseif( is_author() ) {
			global $author;
			$userdata			= get_userdata( $author );
			$output_crumbs		= wtr_breadcrumbs_blog_page( $homeName, $output_crumbs );
			$output_crumbs[]	= array( 'name' => $userdata->display_name );
			$outputTitle		= $post_settings['wtr_TranslateBlogCrumbsAuthorArchive'] . " " . $userdata->display_name ;

		// Blog day
		} elseif( is_day() ) {
			$output_crumbs		= wtr_breadcrumbs_blog_page( $homeName, $output_crumbs );
			$output_crumbs[]	= array( 'url' => get_year_link( get_the_time( 'Y' ) ), 'name' => get_the_time( 'Y' ) );
			$output_crumbs[]	= array( 'url' => get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ), 'name' => get_the_time( 'F' ) );
			$output_crumbs[]	= array( 'name' => get_the_time( 'd' ) );
			$outputTitle		= $post_settings['wtr_TranslateBlogCrumbsArchiveForDate'] . " " . get_the_time( 'F jS, Y' );

		// BLOG month
		} elseif( is_month() ) {
			$output_crumbs		= wtr_breadcrumbs_blog_page( $homeName, $output_crumbs );
			$output_crumbs[]	= array( 'url' => get_year_link( get_the_time( 'Y' ) ), 'name' => get_the_time( 'Y' ) );
			$output_crumbs[]	= array( 'name' => get_the_time('F') );
			$outputTitle		= $post_settings['wtr_TranslateBlogCrumbsArchiveForMonth'] . " " . get_the_time( 'F, Y' );

		// BLOG year
		} elseif( is_year() ) {
			$output_crumbs		= wtr_breadcrumbs_blog_page( $homeName, $output_crumbs );
			$output_crumbs[] 	= array( 'name' => get_the_time('Y') );
			$outputTitle 		= $post_settings['wtr_TranslateBlogCrumbsArchiveForYear'] . " " . get_the_time( 'Y' );

		// Page
		} elseif( is_page() AND ! $post->post_parent ) {
			$output_crumbs[]	= array( 'name' => get_the_title() );
			$outputTitle		= get_the_title();

		// Page with parent
		} elseif( is_page() AND $post->post_parent ) {
			$parent_id			= $post->post_parent;
			$output_crumbs		= wtr_breadcrumbs_parents_page( $parent_id, $output_crumbs );
			$output_crumbs[]	= array( 'name' => get_the_title() );
			$outputTitle		= get_the_title();

		// search
		} elseif ( is_search() ) {
			$outputTitle		= $post_settings['wtr_TranslateSearchFormCrumbsSearchResults'];

		// Post
		} elseif( is_single() AND ! is_attachment() ) {

			// Custom post
			if( get_post_type() != 'post' ){
				$post_type			= get_post_type_object( get_post_type() );
				$output_crumbs[]	= array( 'name' => $post_type->labels->singular_name );
				$output_crumbs[]	= array( 'name' => get_the_title() );
				$outputTitle		= get_the_title();

			// Post
			}else{
				$output_crumbs		= wtr_breadcrumbs_blog_page( $homeName, $output_crumbs );
				$outputTitle		= $homeName;
			}

		} elseif ( is_tax() ) {
			$term				= get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
			$outputTitle		= $post_settings['wtr_TranslateHomeCrumbsTaxArchiveFor'] ." ". single_term_title( '', false );
			$output_crumbs		= wtr_breadcrumbs_parents_terms( $term, $output_crumbs, true );

		// attachment
		} elseif ( is_attachment() ) {
			$post_type			= get_post_type_object( get_post_type() );
			$output_crumbs[]	= array( 'name' => $post_type->labels->singular_name );
			$output_crumbs[]	= array( 'name' => get_the_title() );
			$outputTitle		= get_the_title();

		} elseif( is_home() ) {
			$output_crumbs		= wtr_breadcrumbs_blog_page( $homeName, $output_crumbs );
			$outputTitle		= $homeName;
		}

		$output_crumbs	= apply_filters( 'wtr_breadcrumbs_output_crumbs', $output_crumbs );
		$outputTitle	= apply_filters( 'wtr_breadcrumbs_title', $outputTitle );

		$crumbs_keys	= array_keys( $output_crumbs );
		$last_crumb_key	= end( $crumbs_keys );


		foreach ( $output_crumbs as $crumb_key => $crumb ) {
			if( $last_crumb_key == $crumb_key ){
				$output .= '<li class="wtrCrumb wtrActiveCrumb wtrRadius3 wtrBreadcrumbActvieCrumbColor">' . $crumb['name'] . '</li>';
			} else if( isset( $crumb['url'] ) ){
				$output .= '<li class="wtrCrumb" ><a class="wtrBreadcrumbLinkColor" href="' . esc_url( $crumb['url'] ) . '">' . $crumb['name'] . '</a></li>';
			}else{
				$output .= '<li class="wtrCrumb wtrNoLinkCrumb" >' . $crumb['name'] . '</li>';
			}
		}

		$background = ( $post_settings[ 'wtr_BreadCrumbsBackgroundImgSrc' ] ) ? 'style="background-image:url('. esc_attr( $post_settings[ 'wtr_BreadCrumbsBackgroundImgSrc' ] ) .');"': '';

		echo '<section class="wtrBreadcrumb wtrBreadcrumbColor" ' . $background . ' >';
			echo '<div class="wtrInner clearfix">';
				echo '<div class="wtrBreadcrumbHeadline wtrBreadcrumbHeadlineColor">';
					echo $outputTitle;
				echo '</div>';
				if( 1 == $post_settings['wtr_BreadCrumbs'] ){
					echo '<div class="wtrBreadcrumbPath">';
						echo'<ul class="wtrBreadcrumbPathList">';
							echo $output ;
						echo '</ul>';
					echo '</div>';
				}
			echo '</div>';
		echo '</section>';
	} // end wtr_breadcrumbs
}


if( ! function_exists( 'wtr_breadcrumbs_parents_terms' ) ){

	// bread crumbs parrents terms
	function wtr_breadcrumbs_parents_terms( $term, $output_crumbs, $taxonomy_name = false ){

		$parent				= $term;
		$taxonomy			= $term->taxonomy;
		$taxonomy_obj		= get_taxonomy( $taxonomy );
		$crumb[]			= array( 'url' => get_term_link( $parent, $taxonomy ), 'name' => $parent->name );

		while ( 0 != $parent->parent ){
			$parent		= get_term_by( 'id', $parent->parent, $taxonomy );
			$crumb[]	= array( 'url' => get_term_link( $parent, $taxonomy ), 'name' => $parent->name );
		}

		if( true === $taxonomy_name ){
			$output_crumbs[]	= array( 'name' => $taxonomy_obj->labels->singular_name );
		}

		$output_crumbs = array_merge( $output_crumbs, array_reverse( $crumb ) );
		return $output_crumbs;
	} // end wtr_breadcrumbs_parents_terms
}


if( ! function_exists( 'wtr_breadcrumbs_blog_page' ) ){

	// bread crumbs blog page
	function wtr_breadcrumbs_blog_page( $homeName, $output_crumbs ){

		if ( 'post' == get_post_type() AND 'page' == get_option( 'show_on_front' ) ) {
			$posts_page			= get_option( 'page_for_posts' );
			if ( '' != $posts_page  AND  is_numeric( $posts_page ) ) {
				$output_crumbs	= wtr_breadcrumbs_parents_page( $posts_page, $output_crumbs );
			}
		} else {
			$output_crumbs[]	= array( 'name' => $homeName, 'url' => home_url() );
		}

		return $output_crumbs;
	} // end wtr_breadcrumbs_blog_page
}


if( ! function_exists( 'wtr_breadcrumbs_parents_page' ) ){

	// bread crumbs parrents page
	function wtr_breadcrumbs_parents_page( $parent_id, $output_crumbs ){
		$crumb = array();
		while ( $parent_id ) {
			$page			= get_page( $parent_id );
			$crumb[]	= array( 'url' => get_permalink( $page->ID ), 'name' => get_the_title( $page->ID ) );
			$parent_id		= $page->post_parent;
		}

		$output_crumbs = array_merge( $output_crumbs, array_reverse( $crumb ) );
		return $output_crumbs;
	} // end wtr_breadcrumbs_parents_page
}


if( ! function_exists( 'wtr_title' ) ){

	// generating a title page
	function wtr_title( $title ){

		global $post_settings;

		// Check status theme SEO
		if ( 1 == $post_settings['wtr_SeoSwich'] ){

			if( is_home() ) {
				$title = esc_attr( $post_settings['wtr_SeoTitleHome'] );
			} else if( is_page( ) OR  is_single( ) ) {
				$title = esc_attr( $post_settings['wtr_SeoTitle'] );
			}
			// paged
			if( is_paged() ) {
				global $paged;
				$title .= ' ' . $post_settings['wtr_TranslateHomePagination'] . ' '. $paged;
			}
		}
		return  $title;
	} // end wtr_title
}
add_filter( 'wp_title', 'wtr_title', 10, 1 );


if( ! function_exists( 'wtr_the_title' ) ){

	// generating title
	function wtr_the_title( $title, $id ){

		global $post_settings, $wtr_post_type;

		$title = ( 'trainer' == get_post_type() AND  get_the_id() == $id AND ( ! empty( $post_settings['wtr_trainer_name'] ) OR ! empty( $post_settings['wtr_trainer_last_name'] ) ) ) ? $post_settings['wtr_trainer_name'] .' ' .$post_settings['wtr_trainer_last_name'] : $title;
		$title = ( ! empty( $title ) ) ? $title : __( '(no title)', WTR_THEME_NAME ) ;

		return $title;
	} // end wtr_the_title
}
add_filter('the_title', 'wtr_the_title',10 ,2 );


if( ! function_exists( 'wtr_social_media' ) ){

	// generation of icons for social media

	function wtr_social_media(){

		global $post_settings, $wtr_social_media;

		echo '<div class="wtrColOneTwo wtrAlignLeft clearfix">';
			echo '<ul class="wtrQuickContactSocialLinks">';
				foreach ( $wtr_social_media as $key => $value) {
					$social_media_link = $post_settings[ $key ];
					if( ! empty( $social_media_link ) ) {
						echo '<li> <a class=" wtrAnimate" href="' . esc_url( $social_media_link ) .'" target="_blank" ><i class="' . esc_attr( $value['icon'] ) .'"></i></a></li>';
					}
				}
			echo '</ul>';
		echo '</div>';
	} // end wtr_social_media
}

if( ! function_exists( 'wtr_header_section' ) ){

	// drawing header sections
	function wtr_header_section(){

		global $post_settings;

		if( 2 != $post_settings['wtr_HeaderSettings'] ){
			return;
		}

		$SectionOne = $post_settings['wtr_HeaderSectionOne'];
		$SectionTwo = $post_settings['wtr_HeaderSectionTwo'];

		echo '<div class="wtrQuickContact">';
			echo '<div class="wtrInner clearfix">';
				wtr_social_media();
				if( ! empty( $SectionOne ) OR ! empty( $SectionTwo ) ){
					$class = ( ! empty( $SectionOne ) AND !empty( $SectionTwo ) ) ? '' : 'wtrHQCCol';
					echo '<div class="wtrColOneTwo wtrLastCol wtrAlignRight">';
						echo '<div class="wtrQuickContactInfo clearfix">';
							if( $SectionOne ){
								echo '<div class="wtrColOneTwo ' . $class . ' wtrAlignRight">';
									echo $SectionOne;
								echo '</div>';
							}
							if( $SectionTwo ) {
								echo '<div class="wtrColOneTwo  ' . $class . ' wtrLastCol wtrAlignRight">';
									echo $SectionTwo;
								echo '</div>';
							}
						echo '</div>';
					echo '</div>';
				}
			echo '</div>';
		echo '</div>';

	} // end wtr_header_section
}


if( ! function_exists( 'wtr_no_robot' ) ){

	// checking whether the entry is to be not indexed by search engines. If so, the following meta tag creation
	function wtr_no_robot(){

		global $post_settings;

		if( 1 == $post_settings['wtr_SeoSwich'] AND   isset( $post_settings['wtr_NoRobot'] ) AND 1 == $post_settings['wtr_NoRobot']  AND 1 == get_option( 'blog_public') ) {
			echo "<meta name='robots' content='noindex,nofollow' />\n";
		}
	} // end wtr_no_robot
}
add_action( 'wp_head' , 'wtr_no_robot' );


if( ! function_exists( 'wtr_seo' ) ){

	// generating seo tags on the page. Depending on the settings Post
	function wtr_seo(){

		global $post_settings;

		if ( 1 == $post_settings['wtr_SeoSwich'] ) {

			if( $post_settings['wtr_SeoDescription'] ) {
				echo '<meta name="description" content="'. esc_attr( $post_settings['wtr_SeoDescription'] ) .'" />'."\n";
			}

			if( $post_settings['wtr_SeoKeywords'] ) {
				echo '<meta name="keywords" content="'. esc_attr( $post_settings['wtr_SeoKeywords'] )  .'" />'."\n";
			}
		}
	} // end wtr_seo
}
add_action( 'wp_head' , 'wtr_seo' );


if( ! function_exists( 'wtr_before_head_end' ) ){

	// adding the code from the settings "Space before </head>"
	function wtr_before_head_end(){

		global $post_settings;
		echo $post_settings['wtr_GlobalSpaceBeforeHead'] . "\n" ;;
	} // end wtr_before_head
}
add_action( 'wp_head', 'wtr_before_head_end', 1000 );


if( ! function_exists( 'wtr_analitics' ) ){

	// adding the code from the settings "Google analytics code"
	function wtr_analitics(){

		global $post_settings;

		if( $post_settings['wtr_AnaliticsModule']  AND ! empty( $post_settings['wtr_AnaliticsCode'] ) ) {
			echo  $post_settings['wtr_AnaliticsCode'] . "\n" ;
		}
	} // end wtr_before_head
}
add_action( 'wp_head', 'wtr_analitics', 1001 );


if( ! function_exists( 'wtr_favicon' ) ){

	// setting favicon
	function wtr_favicon(){

		global $post_settings;
		$favicon  = $post_settings['wtr_HeaderFaviconSrc'];

		if( $favicon ){
			$type = "image/x-icon";
			if( strpos( $favicon, '.png' ) ) {
				$type = "image/png";
			} else if( strpos( $favicon, '.gif' ) ) {
				$type = "image/gif";
			}

			echo '<link rel="icon" href="' . esc_url( $favicon ) . '" type="' . $type . '">' . "\n" ;
		}
	} // end wtr_favicon
}


if( ! function_exists( 'wtr_fb_meta' ) ){

	// generate meta tags to facebook
	function wtr_fb_meta(){

		global $post_settings;
		if( is_singular() AND 1 == $post_settings['wtr_GlobalSocialMetaTag']  ){
			if (have_posts()) : while( have_posts() ) : the_post(); endwhile; endif;

			global  $post_settings;

			echo '<meta property="og:site_name" content="' . esc_attr( $post_settings['wtr_SeoTitleHome'] ) . '" />'."\n";
			echo '<meta property="og:type" content="article" />'."\n";
			echo '<meta property="og:title" content="'. esc_attr( $post_settings['wtr_SeoTitle'] ) .'" />'."\n";
			echo '<meta property="og:url" content="' . esc_url( get_permalink() ). '" />'."\n";

			if( has_post_thumbnail() ){
				$post_thumbnail_id 	= get_post_thumbnail_id( get_the_id() );
				$image_attributes 	= wp_get_attachment_image_src( $post_thumbnail_id, 'full' );
				$img 				= $image_attributes[0];
				$img_type 			= wp_check_filetype( $img );

				echo '<meta property="og:image:type" content="' . $img_type['type'] . '" />'."\n";
				echo '<meta property="og:image:width" content="' . $image_attributes[1] .'" />'."\n";
				echo '<meta property="og:image:height" content="' . $image_attributes[2] .'" />'."\n";
				echo '<meta property="og:image" content="' . $img . '" />'."\n";
			}

			if( has_excerpt() ) {
				echo '<meta property="og:description" content="' . esc_attr( wtr_excerpt() ) . '" />'."\n";
			}
		}
	} // end wtr_fb_meta
}
add_action('wp_head', 'wtr_fb_meta');


if( ! function_exists( 'wtr_custom_css' ) ){

	// custom css
	function wtr_custom_css(){
		global $WTR_Opt;
		$output = '';
		$output = apply_filters( 'wtr_custom_css', $output, $WTR_Opt );

		echo '<style type="text/css">' . $output . '</style>';

	} // end  wtr_custom_css
}
add_action( 'wp_head', 'wtr_custom_css' );


if( ! function_exists( 'wtr_custom_css_for_page' ) ){

	// custom css for page
	function wtr_custom_css_for_page( $output ){

		global $post_settings;

		if( isset( $post_settings['wtr_CustomCssForPage'] ) ) {
			$output .= "\n" . $post_settings['wtr_CustomCssForPage'];
		}
		return $output;

	} // end  wtr_custom_css_for_page
}
add_filter( 'wtr_custom_css', 'wtr_custom_css_for_page');


if( ! function_exists( 'wtr_header_main' ) ){

	function wtr_header_main(){

		global $post_settings;

		echo $post_settings['wtr_Boxed_start'];

		if( 1 == $post_settings['wtr_HeaderMobileNavigationType']) {
			wtr_wp_nav_mobile_menu();
		} else {
			wtr_wp_nav_mobile_menu_classic();
		}

		wtr_header();
		wtr_breadcrumbs();
	} // end wtr_header_main
}
add_action('wtr_header', 'wtr_header_main');


if( ! function_exists( 'wtr_loader' ) ){

	function wtr_loader(){

		global $post_settings;
		if( 1 == $post_settings['wtr_GlobalPageLoaderAnimation'] ){
			echo '<div class="wtrLoader">';
				echo '<div class="wtrCircle">' . $post_settings['wtr_TranslateHomeLoader'] . '</div>';
			echo '</div>';
		}
	} // end wtr_loader
}

