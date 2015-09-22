<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

if ( !defined('ABSPATH') ) { die('-1'); }

/* ---------------------------------------------------------------------------
 * Create new post type
 * --------------------------------------------------------------------------- */


function wtr_create_trainers() {

	global $WTR_Opt, $wtr_custom_posts_type, $wtr_custom_posts_taxonomy;
	$wtr_SlugsTrainers_Slug		= $WTR_Opt->getopt('wtr_SlugsTrainers_Slug');
	$wtr_custom_posts_type[]	= 'trainer';
	$wtr_custom_posts_taxonomy[]= 'trainer-specialization';
	$wtr_custom_posts_taxonomy[]= 'trainer-function';

	$labels= array(
		'name' 					=> __( 'Trainers', 'wtr_ct_framework' ),
		'all_items'				=> __( 'All Trainers', 'wtr_ct_framework' ),
		'singular_name' 		=> __( 'Trainer', 'wtr_ct_framework' ),
		'add_new' 				=> __( 'Add New', 'wtr_ct_framework' ),
		'add_new_item' 			=> __( 'Add New Trainer', 'wtr_ct_framework' ),
		'edit_item' 			=> __( 'Edit Trainer', 'wtr_ct_framework' ),
		'new_item' 				=> __( 'New Trainer', 'wtr_ct_framework' ),
		'view_item' 			=> __( 'View Trainer', 'wtr_ct_framework' ),
		'search_items' 			=> __( 'Search Trainers', 'wtr_ct_framework' ),
		'not_found' 			=>  __( 'No Trainers found', 'wtr_ct_framework' ),
		'not_found_in_trash'	=> __( 'No Trainers found in Trash', 'wtr_ct_framework' )
	);

	$args = array(
		'labels' 				=> $labels,
		'public' 				=> true,
		'publicly_queryable'	=> true,
		'show_ui' 				=> true,
		'query_var' 			=> true,
		'capability_type' 		=> 'post',
		'hierarchical' 			=> false,
		'menu_position' 		=> null,
		"show_in_nav_menus" 	=> false,
		'exclude_from_search' 	=> false,
		'rewrite' 				=> array( 'slug' => $wtr_SlugsTrainers_Slug, 'with_front' => true),
		'supports' 				=> array( 'title', 'editor', 'thumbnail','page-attributes' )
	);
	register_post_type( 'trainer', $args );
	register_taxonomy(
		"trainer-specialization", array("trainer"), array(
			'public' 			=> false,
			'show_ui' 			=> true,
			'show_tagcloud'		=> false,
			"hierarchical" 		=> true,
			"show_in_nav_menus" => false,
			"rewrite" => true,
			'labels' 			=> array(
				'name' 				=> __( 'Trainers Specializations', 'wtr_ct_framework' ),
				'singular_name' 	=> __( 'Trainer Specialization', 'wtr_ct_framework' ),
				'edit_item' 		=> __( 'Edit Trainer Specialization', 'wtr_ct_framework' ),
				'search_items'		=> __( 'Search Trainer Specialization' , 'wtr_ct_framework' ),
				'all_items'			=> __( 'All Trainers Specializations' , 'wtr_ct_framework' ),
				'parent_item'		=> __( 'Parent Trainer Specialization' , 'wtr_ct_framework' ),
				'parent_item_colon'	=> __( 'Parent Trainer Specialization:' , 'wtr_ct_framework' ),
				'edit_item'			=> __( 'Edit Trainer Specialization' , 'wtr_ct_framework' ),
				'update_item'		=> __( 'Update Trainer Specialization' , 'wtr_ct_framework' ),
				'add_new_item'		=> __( 'Add New Trainer Specialization' , 'wtr_ct_framework' ),
				'new_item_name'		=> __( 'New Trainer Specialization Name' , 'wtr_ct_framework' ),
				'menu_name'			=> __( 'Trainers Specializations' , 'wtr_ct_framework' )
				),
			)
		);
	register_taxonomy(
		"trainer-function", array("trainer"), array(
			'public' 			=> false,
			'show_ui' 			=> true,
			'show_tagcloud'		=> false,
			"hierarchical" 		=> true,
			"show_in_nav_menus" => false,
			"rewrite" => true,
			'labels' 			=> array(
				'name' 				=> __( 'Trainers Functions (in the club)', 'wtr_ct_framework' ),
				'singular_name' 	=> __( 'Trainer Function (in the club)', 'wtr_ct_framework' ),
				'edit_item' 		=> __( 'Edit Trainer Function (in the club)', 'wtr_ct_framework' ),
				'search_items'		=> __( 'Search Trainer Function (in the club)' , 'wtr_ct_framework' ),
				'all_items'			=> __( 'All Trainer Functions (in the club)' , 'wtr_ct_framework' ),
				'parent_item'		=> __( 'Parent Trainer Function (in the club)' , 'wtr_ct_framework' ),
				'parent_item_colon'	=> __( 'Parent Trainer Function (in the club):' , 'wtr_ct_framework' ),
				'edit_item'			=> __( 'Edit Trainer Function (in the club)' , 'wtr_ct_framework' ),
				'update_item'		=> __( 'Update Trainer Function (in the club)' , 'wtr_ct_framework' ),
				'add_new_item'		=> __( 'Add New Trainer Function (in the club)' , 'wtr_ct_framework' ),
				'new_item_name'		=> __( 'New Trainer Function (in the club)' , 'wtr_ct_framework' ),
				'menu_name'			=> __( 'Trainer Function (in the club)' , 'wtr_ct_framework' )
				),
			)
		);
} // end wtr_create_trainers
add_action( 'init', 'wtr_create_trainers' );


function wtr_single_template_trainer( $single ) {
	global $post;

	if ( isset( $post->post_type ) AND "trainer" == $post->post_type ){
		$single =  WTR_CP_INCLUDES_DIR . '/single-trainer.php';
	}
	return $single;
} // end wtr_single_template_trainer
add_filter( 'single_template', 'wtr_single_template_trainer' );


// add table column in edit page
function wtr_trainer_column($columns){

	$columns = array(
		"cb"					=> "<input type='checkbox' />",
		"trainer_thumbnail"		=> __( 'Photo', 'wtr_ct_framework' ),
		"title"					=> __( 'ID', 'wtr_ct_framework' ),
		"trainer_name"			=> __( 'Name', 'wtr_ct_framework' ),
		"trainer_last_name"		=> __( 'Last name', 'wtr_ct_framework' ),
		"trainer_function"		=> __( 'Trainer Function (in the club)', 'wtr_ct_framework' ),
		"trainer_gym_location"	=> __( 'Gym Location', 'wtr_ct_framework' ),
		"trainer_order"			=> __( 'Order', 'wtr_ct_framework'),
	);
	return $columns;
} // end wtr_trainer_column
add_filter("manage_edit-trainer_columns", "wtr_trainer_column");


//manage posts custom column
function wtr_trainer_custom_columns($column){

	global $post;

	switch ($column) {

		case "trainer_thumbnail":
			if( has_post_thumbnail() ){ the_post_thumbnail( array(50,50) ); }
		break;

		case "trainer_name":
			echo get_post_meta( get_the_ID(), '_wtr_trainer_name', true );
		break;

		case "trainer_last_name":
			echo get_post_meta( get_the_ID(), '_wtr_trainer_last_name', true );
		break;

		case "trainer_function":
			echo get_the_term_list($post->ID, 'trainer-function', '', ', ','');
		break;

		case "trainer_gym_location":
			$gym_location		= get_post_meta( $post->ID, '_wtr_gym_location', false );
			$gym_location_names	= wtr_get_gym_location_metabox( $gym_location, true );
			echo implode( $gym_location_names, ', ' );
		break;

		case "trainer_order":
			echo $post->menu_order;
		break;
	}
} // end wtr_trainer_custom_columns
add_action("manage_posts_custom_column","wtr_trainer_custom_columns");


// change title
function wtr_trainer_change_title( $title ){
	$screen = get_current_screen();
	if ( 'trainer' == $screen->post_type ) {
		$title = __( 'Enter ID Trainer', 'wtr_ct_framework' );
	}
	return $title;
} // end wtr_trainer_change_title
add_filter( 'enter_title_here', 'wtr_trainer_change_title' );


//add meta boxes
function wtr_add_metabox_trainer(){

	$current_screen = get_current_screen();

	if( 'trainer' != $current_screen->post_type ){
		return;
	}

	global $WTR_Opt;

	$wtr_trainer_name = new WTR_Text(array(
			'id' 			=> '_wtr_trainer_name',
			'class'			=> '',
			'title' 		=> __( 'Name', 'wtr_ct_framework' ),
			'desc' 			=> '',
			'value' 		=> '',
			'default_value' => '',
			'info' 			=> '',
			'allow' 		=> 'all',
			)
	);

	$wtr_trainer_last_name = new WTR_Text(array(
			'id' 			=> '_wtr_trainer_last_name',
			'class'			=> '',
			'title' 		=> __( 'Last name', 'wtr_ct_framework' ),
			'desc' 			=> '',
			'value' 		=> '',
			'default_value' => '',
			'info' 			=> '',
			'allow' 		=> 'all',
			)
	);

	$wtr_trainer_background_img = new WTR_Upload( array(
			'id'			=> '_wtr_trainer_background_img',
			'title'			=> __( 'Cover image', 'wtr_ct_framework' ),
			'desc' 			=> '',
			'value'			=> '',
			'default_value' => '',
			'info'			=> '',
			'allow'			=> 'all',
		),
		array( 'title_modal' => __( 'Insert image', 'wtr_ct_framework' ) )
	);

	$wtr_trainer_img_sht = new WTR_Upload( array(
			'id'			=> '_wtr_trainer_img_sht',
			'title'			=> __( 'Background image', 'wtr_ct_framework' ),
			'desc' 			=> __( 'Shortcode Trainers', 'wtr_ct_framework' ),
			'value'			=> '',
			'default_value' => '',
			'info'			=> '',
			'allow'			=> 'all',
		),
		array( 'title_modal' => __( 'Insert image', 'wtr_ct_framework' ) )
	);

	//wtr_nav_menu
	$nav_menus		= wp_get_nav_menus( array('orderby' => 'name') );
	$wtr_nav_menus	= array(
							'none'	=> __( 'None', 'wtr_framework' ),
							0		=> __( 'Default', 'wtr_framework' ),
							);

	foreach ( $nav_menus as  $nav_menu) {
		$wtr_nav_menus[ $nav_menu->term_id ] = $nav_menu->name;
	}

	$wtr_clean_menu_mod = new WTR_Radio( array(
			'id'			=> '_wtr_clean_menu_mod',
			'title'			=> __( 'Enable clean menu mode', 'wtr_framework' ),
			'desc'			=> __( 'This option allows you to hide additional menu icons like: </br> Search icon, WooCommerce cart (if installed), WPML select (if installed)', 'wtr_framework' ),
			'value'			=> '',
			'default_value' => '0',
			'info'			=> '',
			'allow'			=> 'int',
			'option'		=> array( '1' => 'On' , '0' => 'Off' ),
		)
	);

	$wtr_page_nav_menu = new WTR_Select(array(
			'id' 			=> '_wtr_page_nav_menu',
			'title' 		=> __( 'Page menu', 'wtr_framework' ),
			'desc' 			=> '',
			'value' 		=> '',
			'default_value' => 0,
			'info' 			=> '',
			'allow' 		=> 'all',
			'option' 		=> $wtr_nav_menus,
			'mod' 			=> '',
			)
	);

	$wtr_HeaderSettings = new WTR_Select( array(
			'id'			=> '_wtr_HeaderSettings',
			'title'			=> __( 'Header settings', 'wtr_framework' ),
			'desc'			=> '',
			'value'			=> '',
			'default_value' => $WTR_Opt->getopt( 'wtr_HeaderSettings' ),
			'info'			=> '',
			'allow'			=> 'int',
			'mod' 			=> '',
			'option'		=> array(
										'0' => __( 'Off', 'wtr_framework' ),
										'1' => __( 'Show menu', 'wtr_framework' ),
										'2' => __( 'Show menu &#43; socials', 'wtr_framework' ),
										'3' => __( 'Simplified menu', 'wtr_framework' )
										),
		)
	);

	$wtr_BreadCrumbsContainer = new WTR_Radio( array(
			'id' 			=> '_wtr_BreadCrumbsContainer',
			'title' 		=> __( 'Breadcrumbs container', 'wtr_framework' ),
			'desc' 			=> '',
			'value' 		=> '',
			'default_value' => $WTR_Opt->getopt( 'wtr_BlogBreadCrumbsContainer' ),
			'info' 			=> '',
			'allow' 		=> 'int',
			'option' 		=> array( '1' => 'On' , '0' => 'Off' ),
			'class'			=> ''
		)
	);

	$wtr_BreadCrumbs = new WTR_Radio( array(
			'id' 			=> '_wtr_BreadCrumbs',
			'title' 		=> __( 'Breadcrumbs', 'wtr_framework' ),
			'desc' 			=> '',
			'value' 		=> '',
			'default_value' => $WTR_Opt->getopt( 'wtr_BlogBreadCrumbs' ),
			'info' 			=> '',
			'allow' 		=> 'int',
			'option' 		=> array( '1' => 'On' , '0' => 'Off' ),
			'class'			=> ''
		)
	);

	$wtr_SeoTitle = new WTR_Text(array(
			'id' 			=> '_wtr_SeoTitle',
			'class' 		=> '',
			'title' 		=> __( 'SEO tittle', 'wtr_ct_framework' ),
			'desc' 			=> '',
			'value' 		=> '',
			'default_value' => '',
			'info' 			=> '',
			'allow' 		=> 'all',
			)
	);

	$wtr_SeoDesc = new WTR_Text(array(
			'id' 			=> '_wtr_SeoDesc',
			'class' 		=> '',
			'title' 		=> __( 'SEO description', 'wtr_ct_framework' ),
			'desc' 			=> '',
			'value' 		=> '',
			'default_value' => '',
			'info' 			=> '',
			'allow' 		=> 'all',
			)
	);

	$wtr_SeoKey = new WTR_Text(array(
			'id' 			=> '_wtr_SeoKey',
			'class' 		=> '',
			'title' 		=> __( 'SEO keywords', 'wtr_ct_framework' ),
			'desc' 			=> '',
			'value' 		=> '',
			'default_value' => '',
			'info' 			=> '',
			'allow' 		=> 'all',
			)
	);


	$wtr_NoRobot = new WTR_Radio( array(
			'id' 			=> '_wtr_NoRobot',
			'title' 		=> __( 'Robots meta tag', 'wtr_ct_framework' ),
			'desc' 			=> '',
			'value' 		=> '',
			'default_value' => '0',
			'info' 			=> '',
			'allow' 		=> 'int',
			'option' 		=> array( '1' => 'On' , '0' => 'Off' ),
			'mod' 			=> 'robot',
			'meta' 			=> '<div class="WtrNoneSidebarDataInfo wtrOnlyPortfolio wtrPageFields">' . __( 'Site has No Robot attribute ', 'wtr_ct_framework' ) . '</div>',
		)
	);

	$wtr_SidebarPosition = new WTR_Radio_Img( array(
			'id' 			=> '_wtr_SidebarPosition',
			'title' 		=> __( 'Sidebar position', 'wtr_ct_framework' ),
			'desc' 			=> '',
			'value' 		=> '',
			'default_value' => $WTR_Opt->getopt( 'wtr_SidebarPositionOnTrainer' ),
			'info' 			=> '',
			'allow' 		=> 'all',
			'checked' 		=> 'sideChecked',
			'class' 		=> 'sideSetter wtrPageFields',
			'option'		=> array( 'setLeftSide' , 'setRightSide', 'setNone' ),
		)
	);

	$wtr_Sidebar = new WTR_Select(array(
			'id' 			=> '_wtr_Sidebar',
			'title' 		=> __( 'Sidebar', 'wtr_ct_framework' ),
			'desc' 			=> '',
			'value' 		=> '',
			'default_value' => $WTR_Opt->getopt( 'wtr_SidebarPickOnTrainer' ),
			'info' 			=> '',
			'allow' 		=> 'all',
			'option' 		=> $WTR_Opt->getopt( 'wtr_SidebraManagement' ) ,
			'meta' 			=> '<div class="WtrNoneSidebarDataInfo wtrOnlyPortfolio wtrPageFields">' . __( 'To set sidebar use "Siedebar management". Go to: Apperance > Theme Options > General > Sidebar', 'wtr_ct_framework' ) . '</div>',
			'mod' 			=> '',
			'class'			=> 'wtrOnlyPortfolio wtrPageFields'
			)
	);

	$wtr_facebook = new WTR_Text(array(
			'id' 			=> '_wtr_facebook',
			'class' 		=> '',
			'title' 		=> __( 'Facebook', 'wtr_ct_framework' ),
			'desc' 			=> '',
			'value' 		=> '',
			'default_value' => '',
			'info' 			=> '',
			'allow' 		=> 'all',
			)
	);

	$wtr_googleplus = new WTR_Text(array(
			'id' 			=> '_wtr_googleplus',
			'class' 		=> '',
			'title' 		=> __( 'Google', 'wtr_ct_framework' ),
			'desc' 			=> '',
			'value' 		=> '',
			'default_value' => '',
			'info' 			=> '',
			'allow' 		=> 'all',
			)
	);

	$wtr_twitter = new WTR_Text(array(
			'id' 			=> '_wtr_twitter',
			'class' 		=> '',
			'title' 		=> __( 'Twitter', 'wtr_ct_framework' ),
			'desc' 			=> '',
			'value' 		=> '',
			'default_value' => '',
			'info' 			=> '',
			'allow' 		=> 'all',
			)
	);

	$wtr_vimeo = new WTR_Text(array(
			'id' 			=> '_wtr_vimeo',
			'class' 		=> '',
			'title' 		=> __( 'Vimeo', 'wtr_ct_framework' ),
			'desc' 			=> '',
			'value' 		=> '',
			'default_value' => '',
			'info' 			=> '',
			'allow' 		=> 'all',
			)
	);

	$wtr_youtube = new WTR_Text(array(
			'id' 			=> '_wtr_youtube',
			'class' 		=> '',
			'title' 		=> __( 'YouTube', 'wtr_ct_framework' ),
			'desc' 			=> '',
			'value' 		=> '',
			'default_value' => '',
			'info' 			=> '',
			'allow' 		=> 'all',
			)
	);

	$wtr_tumblr = new WTR_Text(array(
			'id' 			=> '_wtr_tumblr',
			'class' 		=> '',
			'title' 		=> __( 'Tumblr', 'wtr_ct_framework' ),
			'desc' 			=> '',
			'value' 		=> '',
			'default_value' => '',
			'info' 			=> '',
			'allow' 		=> 'all',
			)
	);

	$wtr_pinterest = new WTR_Text(array(
			'id' 			=> '_wtr_pinterest',
			'class' 		=> '',
			'title' 		=> __( 'Pinterest', 'wtr_ct_framework' ),
			'desc' 			=> '',
			'value' 		=> '',
			'default_value' => '',
			'info' 			=> '',
			'allow' 		=> 'all',
			)
	);

	$wtr_instagram = new WTR_Text(array(
			'id' 			=> '_wtr_instagram',
			'class' 		=> '',
			'title' 		=> __( 'Instagram', 'wtr_ct_framework' ),
			'desc' 			=> '',
			'value' 		=> '',
			'default_value' => '',
			'info' 			=> '',
			'allow' 		=> 'all',
			)
	);

	$wtr_flickr = new WTR_Text(array(
			'id' 			=> '_wtr_flickr',
			'class' 		=> '',
			'title' 		=> __( 'Flickr', 'wtr_ct_framework' ),
			'desc' 			=> '',
			'value' 		=> '',
			'default_value' => '',
			'info' 			=> '',
			'allow' 		=> 'all',
			)
	);

	$wtr_vkontakte = new WTR_Text(array(
			'id' 			=> '_wtr_vkontakte',
			'class' 		=> '',
			'title' 		=> __( 'VKontakte', 'wtr_ct_framework' ),
			'desc' 			=> '',
			'value' 		=> '',
			'default_value' => '',
			'info' 			=> '',
			'allow' 		=> 'all',
			)
	);

	$wtr_linkedin = new WTR_Text(array(
			'id' 			=> '_wtr_linkedin',
			'class' 		=> '',
			'title' 		=> __( 'LinkedIn', 'wtr_ct_framework' ),
			'desc' 			=> '',
			'value' 		=> '',
			'default_value' => '',
			'info' 			=> '',
			'allow' 		=> 'all',
			)
	);

	$wtr_CustomCssForPage = new WTR_Textarea( array(
			'id' 			=> '_wtr_CustomCssForPage',
			'class' 		=> '',
			'rows' 			=> 10,
			'title' 		=> __( 'Custom css for page', 'wtr_ct_framework' ),
			'desc' 			=> '',
			'value' 		=> '',
			'default_value' => '',
			'info' 			=> '',
			'allow' 		=> 'all',
		)
	);

	require_once( WTR_ADMIN_CLASS_DIR . '/wtr_meta_box.php' );

	$wtr_GeneralSections = array(
		'id'		=> 'wtr_GeneralSections',
		'name' 		=>__( 'General', 'wtr_ct_framework' ),
		'class'		=> 'General',
		'active_tab'=> true,
		'fields'	=> array(
							$wtr_trainer_name,
							$wtr_trainer_last_name,
							$wtr_trainer_background_img,
							$wtr_trainer_img_sht
					)
	);

	$wtr_LayoutSections = array(
		'id'		=> 'wtr_LayoutSections',
		'name' 		=>__( 'Layout', 'wtr_framework' ),
		'class'		=> 'Layout',
		'active_tab'=> false,
		'fields'	=> array(
							$wtr_clean_menu_mod,
							$wtr_page_nav_menu,
							$wtr_HeaderSettings,
							$wtr_BreadCrumbsContainer,
							$wtr_BreadCrumbs
					)
	);

	$wtr_SidebarSections = array(
		'id'		=> 'wtr_SidebarSections',
		'name' 		=>__( 'Sidebar', 'wtr_ct_framework' ),
		'class'		=> 'Sidebar',
		'active_tab'=> false,
		'fields'	=> array(
							$wtr_SidebarPosition,
							$wtr_Sidebar,
					)
	);

	$wtr_SocialMediaSections = array(
		'id'		=> 'wtr_SocialMediaSections',
		'name' 		=>__( 'Social Media', 'wtr_ct_framework' ),
		'class'		=> 'SocialMedial',
		'exclusion'	=> '',
		'active_tab'=> false,
		'fields'	=> array(
							$wtr_facebook,
							$wtr_googleplus,
							$wtr_twitter,
							$wtr_vimeo,
							$wtr_youtube,
							$wtr_tumblr,
							$wtr_pinterest,
							$wtr_instagram,
							$wtr_flickr,
							$wtr_vkontakte,
							$wtr_linkedin
					)
	);


	$wtr_CssSections = array(
		'id'		=> 'wtr_CssSections',
		'name' 		=>__( 'CSS', 'wtr_ct_framework' ),
		'class'		=> 'CSS',
		'fields'	=> array(
							$wtr_CustomCssForPage
					)
	);

	$wtr_meta_settings =
					array(
						'id' 		=> 'wtr-meta-post',
						'title' 	=> __('Trainer Options', 'wtr_ct_framework' ),
						'page' 		=> 'trainer',
						'context' 	=> 'normal',
						'priority' 	=> 'high',
						'sections' 	=> array(
											$wtr_GeneralSections,
											$wtr_LayoutSections,
											$wtr_SidebarSections,
											$wtr_SocialMediaSections,
											$wtr_CssSections
										)
					);

	// Add seo fields
	if ( 1 ==  $WTR_Opt->getopt( 'wtr_SeoSwich' ) ) {
		$wtr_SEOSections = array(
			'id'		=> 'wtr_SEOSections',
			'name' 		=>__( 'SEO', 'wtr_ct_framework' ),
			'class'		=> 'SEO',
			'fields'	=> array(
								$wtr_SeoTitle,
								$wtr_SeoDesc,
								$wtr_SeoKey,
								$wtr_NoRobot,
							)
		);
		$wtr_meta_settings['sections'][] = $wtr_SEOSections;
	}

	//Gym location Right Metabox
	$wtr_gym_location_options = wtr_get_gym_location_metabox();

	$wtr_gym_location = new WTR_Checkbox( array(
			'id'			=> '_wtr_gym_location',
			'title'			=> __( 'Gym Location', 'wtr_ct_framework' ),
			'desc'			=> '',
			'value'			=> '',
			'default_value' => array(),
			'info'			=> '',
			'allow'			=> 'all',
			'option'		=> $wtr_gym_location_options,
			'mod' 			=> 'simple'

		)
	);

	$wtr_GeneralSections = array(
		'id'		=> 'wtr_GeneralSections',
		'name' 		=>__( 'General', 'wtr_ct_framework' ),
		'class'		=> 'General',
		'active_tab'=> true,
		'fields'	=> array(
							$wtr_gym_location,
					)
	);

	$wtr_gym_location_right_meta_settings =
					array(
						'id' 		=> 'wtr-gym_location-meta-right-post',
						'title' 	=> __( 'Gym Location', 'wtr_ct_framework' ),
						'page' 		=> 'trainer',
						'context' 	=> 'side',
						'priority' 	=> 'core',
						'callback'	=> 'render_right_meta_box_content',
						'sections' 	=> array(
											$wtr_GeneralSections,
										)
					);

	$wtr_meta_box						= NEW wtr_meta_box( $wtr_meta_settings );
	$wtr_gym_location_right_meta_box	= NEW wtr_meta_box( $wtr_gym_location_right_meta_settings );

} // end wtr_add_metabox_clients
add_action( 'load-post.php', 'wtr_add_metabox_trainer' );
add_action( 'load-post-new.php', 'wtr_add_metabox_trainer' );


function wtr_get_trainers_metabox( $post_in = null ){

	$option		= array();
	if( is_null( $post_in ) OR  ! empty( $post_in ) AND is_array( $post_in ) ) {

		$args		= array( 'post_type' => 'trainer', 'post_status' => 'any', 'posts_per_page' => -1, 'post__in' => $post_in );
		$objects	= get_posts( $args );

		foreach ( $objects as $object ) {
			$name		= get_post_meta( $object->ID, '_wtr_trainer_name', true );
			$last_name	= get_post_meta( $object->ID, '_wtr_trainer_last_name', true );

			$option[ $object->ID ] = ( empty( $name ) AND empty( $last_name ) ) ? __( '(no title)', 'wtr_ct_framework' ) : $name . ' ' . $last_name;
		}
	}
	return $option;
} // end wtr_get_trainers_metabox


add_action( 'wtr_post_save_trainer' , 'wtr_save_metabox_gym_location' );


function wtr_save_metabox_trainers( $id ){

	$post_trainers	= get_post_meta( $id, '_wtr_trainers',true );
	$new_trainers	= ( isset( $_POST['_wtr_trainers'] ) ) ? $_POST['_wtr_trainers'] : '';

	delete_post_meta( $id, '_wtr_trainers');

	if( ! empty( $new_trainers ) ){
		foreach ( $new_trainers as $trainer ) {
			add_post_meta( $id, '_wtr_trainers', $trainer );
		}
	}
} // end wtr_save_metabox_trainers


function wtr_post_settings_single_post_trainer( $post_settings_single ){

	$post_settings_single = array(
		'wtr_SidebarPosition'		=> '_wtr_SidebarPosition',
		'wtr_Sidebar'				=> '_wtr_Sidebar',
		'wtr_trainer_name'			=> '_wtr_trainer_name',
		'wtr_trainer_last_name'		=> '_wtr_trainer_last_name',
		'wtr_trainer_background_img'=> '_wtr_trainer_background_img',
		'wtr_trainer_Facebook'		=> '_wtr_facebook',
		'wtr_trainer_GooglePlus'	=> '_wtr_googleplus',
		'wtr_trainer_Twitter'		=> '_wtr_twitter',
		'wtr_trainer_Vimeo'			=> '_wtr_vimeo',
		'wtr_trainer_YouTube'		=> '_wtr_youtube',
		'wtr_trainer_Tumblr'		=> '_wtr_tumblr',
		'wtr_trainer_Pinterest'		=> '_wtr_pinterest',
		'wtr_trainer_Instagram'		=> '_wtr_instagram',
		'wtr_trainer_Flickr'		=> '_wtr_flickr',
		'wtr_trainer_VKontakte'		=> '_wtr_vkontakte',
		'wtr_trainer_LinkedIn'		=> '_wtr_linkedin',
		'wtr_CustomCssForPage'		=> '_wtr_CustomCssForPage',
		'wtr_SeoTitle'				=> '_wtr_SeoTitle',
		'wtr_SeoDescription'		=> '_wtr_SeoDesc',
		'wtr_SeoKeywords'			=> '_wtr_SeoKey',
		'wtr_NoRobot'				=> '_wtr_NoRobot',
		'wtr_HeaderSettings'		=> '_wtr_HeaderSettings',
		'wtr_page_nav_menu'			=> '_wtr_page_nav_menu',
		'wtr_HeaderCleanMenuMod'	=> '_wtr_clean_menu_mod',
		'wtr_BreadCrumbsContainer'	=> '_wtr_BreadCrumbsContainer',
		'wtr_BreadCrumbs'			=> '_wtr_BreadCrumbs',
	);
	return $post_settings_single;

} // end wtr_post_settings_single_post_trainer
add_filter( 'wtr_post_settings_single_post_trainer', 'wtr_post_settings_single_post_trainer', 10, 2 );


function wtr_post_settings_default_trainer( $post_settings ){

	$post_settings['wtr_Sidebar']		= $post_settings['wtr_SidebarPickOnTrainer'];
	return $post_settings;

} // end wtr_post_settings_default_trainer
add_filter( 'wtr_post_settings_default_trainer', 'wtr_post_settings_default_trainer', 10, 1);