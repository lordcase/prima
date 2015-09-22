<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

// Include libs
foreach ( glob( WTR_ADMIN_CLASS_DIR . "/fields/wtr_*.php" ) as $lib )
	require_once( $lib );

require_once( WTR_ADMIN_CLASS_DIR . '/wtr_section.php' );
require_once( WTR_ADMIN_CLASS_DIR . '/wtr_group.php' );

require_once( WTR_ADMIN_CLASS_DIR . '/wtr_theme_page.php' );
require_once( WTR_ADMIN_CLASS_DIR . '/wtr_avatar.php' );
require_once( WTR_ADMIN_CLASS_DIR . '/wtr_user_social.php' );
require_once( WTR_ADMIN_CLASS_DIR . '/wtr_settings.php' );
require_once( WTR_ADMIN_CLASS_DIR . '/wtr_fonts.php' );
require_once( WTR_ADMIN_CLASS_DIR . '/wtr_theme_skins.php' );
require_once( WTR_ADMIN_CLASS_DIR . '/wtr_paypal.php' );
require_once( WTR_ADMIN_CLASS_DIR . '/wtr_update.php' );
require_once( WTR_ADMIN_CLASS_DIR . '/wtr_update_config.php' );


require_once( WTR_ADMIN_CLASS_DIR . '/wtr_translate.php' );
require_once( WTR_ADMIN_CLASS_DIR . '/wtr_date_format.php' );
require_once( WTR_ADMIN_CLASS_DIR . '/wtr_social_media.php' );

require_once( WTR_ADMIN_CLASS_DIR . '/wtr_instagram.php' );


//===== Define obj

//Global: wtr_GeneralGlobalSection
$wtr_GlobalResponsive = new WTR_Radio( array(
		'id'			=> 'wtr_GlobalResponsive',
		'title'			=> __( 'Responsive', 'wtr_framework' ),
		'desc'			=> '',
		'value'			=> '',
		'default_value' => '1',
		'info'			=> '',
		'allow'			=> 'int',
		'option' 	=> array( '1' => 'On' , '0' => 'Off' ),
	)
);

$wtr_GlobalSocialMetaTag = new WTR_Radio( array(
		'id'			=> 'wtr_GlobalSocialMetaTag',
		'title'			=> __( 'Social MetaTag', 'wtr_framework' ),
		'desc'			=> __( 'Specify whether you want to add to the single post meta tags social eg. og: title, og: image', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => '1',
		'info'			=> '',
		'allow'			=> 'int',
		'option'		=> array( '1' => 'On' , '0' => 'Off' ),
	)
);

$wtr_GlobalBoxed= new WTR_Radio( array(
		'id'			=> 'wtr_GlobalBoxed',
		'title'			=> __( 'Boxed style', 'wtr_framework' ),
		'desc'			=> '',
		'value'			=> '',
		'default_value' => '0',
		'info'			=> '',
		'allow'			=> 'int',
		'option' 	=> array( '1' => 'On' , '0' => 'Off' ),
	)
);

$wtr_GlobalAccelerateCusttomCss= new WTR_Radio( array(
		'id'			=> 'wtr_GlobalAccelerateCusttomCss',
		'title'			=> __( 'Accelerate custom css', 'wtr_framework' ),
		'desc'			=> __( 'If you have problem with generating Custom CSS using Appearance > Customize turn off this option', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => '1',
		'info'			=> '',
		'allow'			=> 'int',
		'option' 	=> array( '1' => 'On' , '0' => 'Off' ),
	)
);

$wtr_GlobalAvatarStatus = new WTR_Radio( array(
		'id'			=> 'wtr_GlobalAvatarStatus',
		'title'			=> __( 'Avatar image', 'wtr_framework' ),
		'desc'			=> __( 'Additional image field in Users > Your profile', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => '1',
		'info'			=> '',
		'allow'			=> 'int',
		'option'		=> array( '1' => 'On' , '0' => 'Off' ),
	)
);

$wtr_GlobalPageLoaderAnimation = new WTR_Radio( array(
		'id'			=> 'wtr_GlobalPageLoaderAnimation',
		'title'			=> __( 'Page loader animation', 'wtr_framework' ),
		'desc'			=> '',
		'value'			=> '',
		'default_value' => '0',
		'info'			=> '',
		'allow'			=> 'int',
		'option'		=> array( '1' => 'On' , '0' => 'Off' ),
	)
);

$wtr_GlobalSpaceBeforeHead = new WTR_Textarea( array(
		'id'			=> 'wtr_GlobalSpaceBeforeHead',
		'class'			=> '',
		'rows'			=> 10,
		'title'			=> __( 'Space before &#60;/head&#62;', 'wtr_framework' ),
		'desc' 			=> __( 'Add code before the &#60;/head&#62; tag.', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => '',
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_GlobalSpaceBeforeBody = new WTR_Textarea( array(
		'id'			=> 'wtr_GlobalSpaceBeforeBody',
		'class'			=> '',
		'rows'			=> 10,
		'title'			=> __( 'Space before &#60;/body&#62;', 'wtr_framework' ),
		'desc' 			=> __( 'Add code before the &#60;/body&#62; tag.', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => '',
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_Global404Page = new WTR_Select( array(
		'id'			=> 'wtr_Global404Page',
		'title'			=> __( '404 page', 'wtr_framework' ),
		'desc'			=> '',
		'value'			=> '',
		'default_value' => '',
		'info'			=> '',
		'allow'			=> 'all',
		'mod' 			=> 'page',
		'first_value_title' =>__( 'Standard 404 Page', 'wtr_framework' ),
		'option'		=> array( '' )
	)
);

$wtr_GlobalPageBackgroundImg = new WTR_Img_Sortable( array(
	'id' 			=> 'wtr_GlobalPageBackgroundImg',
	'class'			=> '',
	'title' 		=> __( 'Page Background images', 'wtr_framework' ),
	'desc' 			=> __( 'Select the photos to appear in the background of the page. If you select more than one photo will be used fade effect between them.', 'wtr_framework' ),
	'value' 		=> '',
	'default_value' => '',
	'info' 			=> '',
	'allow' 		=> 'all',
	),
	array('target_type' => 'multi-img',
		  'title_modal' => __( 'Insert image url or select file from media library', 'wtr_framework' ) )
);

$wtr_GlobalPagineArrows = new WTR_Radio( array(
		'id'			=> 'wtr_GlobalPagineArrows',
		'title'			=> __( 'Pagination arrow', 'wtr_framework' ),
		'desc' 			=> __( 'Arrows in pagination next / previous post ', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => '1',
		'info'			=> '',
		'allow'			=> 'int',
		'option'		=> array( '1' => 'On' , '0' => 'Off' ),
	)
);

// Slugs: wtr_GeneralSlugsSection
$wtr_SlugsRooms_Slug = new WTR_Text( array(
		'id'			=> 'wtr_SlugsRooms_Slug',
		'class'			=> '',
		'title'			=> __( 'Rooms slug:', 'wtr_framework' ),
		'desc'			=> '',
		'value'			=> '',
		'default_value' => 'rooms-item',
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_SlugsTrainers_Slug = new WTR_Text( array(
		'id'			=> 'wtr_SlugsTrainers_Slug',
		'class'			=> '',
		'title'			=> __( 'Trainers slug:', 'wtr_framework' ),
		'desc'			=> '',
		'value'			=> '',
		'default_value' => 'trainer-item',
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_SlugsClasses_Slug = new WTR_Text( array(
		'id'			=> 'wtr_SlugsClasses_Slug',
		'class'			=> '',
		'title'			=> __( 'Classes slug:', 'wtr_framework' ),
		'desc'			=> '',
		'value'			=> '',
		'default_value' => 'classes-item',
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_SlugsClassesCategory_Slug = new WTR_Text( array(
		'id'			=> 'wtr_SlugsClassesCategory_Slug',
		'class'			=> '',
		'title'			=> __( 'Classes category slug:', 'wtr_framework' ),
		'desc'			=> '',
		'value'			=> '',
		'default_value' => 'classes-category',
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_SlugsEvents_Slug = new WTR_Text( array(
		'id'			=> 'wtr_SlugsEvents_Slug',
		'class'			=> '',
		'title'			=> __( 'Events slug:', 'wtr_framework' ),
		'desc'			=> '',
		'value'			=> '',
		'default_value' => 'events-item',
		'info'			=> '',
		'allow'			=> 'all',
	)
);


// SEO: wtr_GeneralSeoSection
$wtr_SeoSwich = new WTR_Radio( array(
		'id'			=> 'wtr_SeoSwich',
		'title'			=> __( 'Use SEO fileds', 'wtr_framework' ),
		'desc'			=> '',
		'value'			=> '',
		'default_value' => '1',
		'info'			=> '',
		'allow'			=> 'int',
		'option'		=> array( '1' => 'On' , '0' => 'Off' ),
	)
);

$wtr_SeoTitle = new WTR_Text( array(
		'id'			=> 'wtr_SeoTitleHome',
		'class'			=> '',
		'title'			=> __( 'Title', 'wtr_framework' ),
		'desc'			=> __( 'This functions only work when blog posts are on the main page', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => '',
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_SeoDescription = new WTR_Text( array(
		'id'			=> 'wtr_SeoDescription',
		'class'			=> '',
		'title'			=> __( 'Description', 'wtr_framework' ),
		'desc'			=> __( 'This setting may be overridden by single posts & pages', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => '',
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_SeoKeywords = new WTR_Text( array(
		'id'			=> 'wtr_SeoKeywords',
		'class'			=> '',
		'title'			=> __( 'Keywords', 'wtr_framework' ),
		'desc'			=> __( 'This setting may be overridden by single posts & pages', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => '',
		'info'			=> '',
		'allow'			=> 'all',
	)
);

//Analytics: wtr_GeneralAnaliticsSection
$wtr_AnaliticsModule = new WTR_Radio( array(
		'id'			=> 'wtr_AnaliticsModule',
		'title'			=> __( 'Google Analytics module', 'wtr_framework' ),
		'desc'			=> '',
		'value'			=> '',
		'default_value' => '1',
		'info'			=> '',
		'allow'			=> 'int',
		'option'		=> array( '1' => 'On' , '0' => 'Off' ),
	)
);

$wtr_AnaliticsCode = new WTR_Textarea( array(
		'id'			=> 'wtr_AnaliticsCode',
		'class'			=> '',
		'rows'			=> 15,
		'title'			=> __( 'Google Analytics code', 'wtr_framework' ),
		'desc'			=> '',
		'value'			=> '',
		'default_value' => '',
		'info'			=> '',
		'allow'			=> 'all',
	)
);

//Sidebar: wtr_GeneralSidebarSection
$wtr_SidebraManagement = new WTR_Sidebar( array(
		'id'			=> 'wtr_SidebraManagement',
		'title'			=> __( 'Sidebar management', 'wtr_framework' ),
		'desc'			=> '',
		'value'			=> '',
		'default_value' => array(),
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_SidebarPositionOnSearch= new WTR_Radio_Img( array(
		'id'			=> 'wtr_SidebarPositionOnSearch',
		'title'			=> __( 'Sidebar position on search pages', 'wtr_framework' ),
		'desc'			=> '',
		'value'			=> '',
		'default_value' => 'setNone',
		'info'			=> '',
		'allow'			=> 'all',
		'checked' 		=> 'sideChecked',
		'class' 		=> 'sideSetter',
		'option'		=> array( 'setLeftSide' , 'setRightSide', 'setNone' ),
	)
);

$wtr_SidebarPickOnSearch = new WTR_Select(array(
		'id'			=> 'wtr_SidebarPickOnSearch',
		'title'			=> __( 'Set sidebar on search pages', 'wtr_framework' ),
		'desc'			=> '',
		'value'			=> '',
		'default_value' => '',
		'info'			=> '',
		'allow'			=> 'all',
		'option'		=>  array(),
		'meta' 			=> __( 'Add sidebar', WTR_THEME_NAME ),
		'mod' 			=> 'sidebar'
	)
);

$wtr_SidebarPositionOnArchive = new WTR_Radio_Img( array(
		'id'			=> 'wtr_SidebarPositionOnArchive',
		'title'			=> __( 'Sidebar position on archive pages', 'wtr_framework' ),
		'desc'			=> '',
		'value'			=> '',
		'default_value' => 'setNone',
		'info'			=> '',
		'allow'			=> 'all',
		'checked' 		=> 'sideChecked',
		'class' 		=> 'sideSetter',
		'option'		=> array( 'setLeftSide' , 'setRightSide', 'setNone' ),
	)
);

$wtr_SidebarPickOnArchive = new WTR_Select(array(
		'id'			=> 'wtr_SidebarPickOnArchive',
		'title'			=> __( 'Set sidebar on archive pages', 'wtr_framework' ),
		'desc'			=> '',
		'value'			=> '',
		'default_value' => '',
		'info'			=> '',
		'allow'			=> 'all',
		'option'		=>  array(),
		'meta' 			=> __( 'Add sidebar', WTR_THEME_NAME ),
		'mod' 			=> 'sidebar'
	)
);

$wtr_SidebarPositionOnBlog = new WTR_Radio_Img( array(
		'id'			=> 'wtr_SidebarPositionOnBlog',
		'title'			=> __( 'Sidebar position on blog page', 'wtr_framework' ),
		'desc'			=> '',
		'value'			=> '',
		'default_value' => 'setRightSide',
		'info'			=> '',
		'allow'			=> 'all',
		'checked' 		=> 'sideChecked',
		'class' 		=> 'sideSetter',
		'option'		=> array( 'setLeftSide' , 'setRightSide', 'setNone' ),
	)
);

$wtr_SidebarPickOnBlog = new WTR_Select(array(
		'id'			=> 'wtr_SidebarPickOnBlog',
		'title'			=> __( 'Set sidebar on blog page', 'wtr_framework' ),
		'desc'			=> '',
		'value'			=> '',
		'default_value' => '',
		'info'			=> '',
		'allow'			=> 'all',
		'option'		=>  array(),
		'meta' 			=> __( 'Add sidebar', WTR_THEME_NAME ),
		'mod' 			=> 'sidebar'
		)
);

$wtr_SidebarPositionOnBlogPostPage = new WTR_Radio_Img( array(
		'id'			=> 'wtr_SidebarPositionOnBlogPostPage',
		'title'			=> __( 'Sidebar position on blog post page', 'wtr_framework' ),
		'desc'			=> __( 'This setting may be overridden by single posts', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => 'setRightSide',
		'info'			=> '',
		'allow'			=> 'all',
		'checked' 		=> 'sideChecked',
		'class' 		=> 'sideSetter',
		'option'		=> array( 'setLeftSide' , 'setRightSide', 'setNone' ),
	)
);

$wtr_SidebarPickOnBlogPostPage = new WTR_Select(array(
		'id'			=> 'wtr_SidebarPickOnBlogPostPage',
		'title'			=> __( 'Set sidebar on blog post page', 'wtr_framework' ),
		'desc'			=> __( 'This setting may be overridden by single posts', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => '',
		'info'			=> '',
		'allow'			=> 'all',
		'option'		=>  array(),
		'meta' 			=> __( 'Add sidebar', 'wtr_framework' ),
		'mod' 			=> 'sidebar'
	)
);

$wtr_SidebarPositionOnSinglePage = new WTR_Radio_Img( array(
		'id'			=> 'wtr_SidebarPositionOnSinglePage',
		'title'			=> __( 'Sidebar position on single page', 'wtr_framework' ),
		'desc'			=> __( 'This setting may be overridden by single pages', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => 'setNone',
		'info'			=> '',
		'allow'			=> 'all',
		'checked' 		=> 'sideChecked',
		'class' 		=> 'sideSetter',
		'option'		=> array( 'setLeftSide' , 'setRightSide', 'setNone' ),
	)
);

$wtr_SidebarPickOnSinglePage  = new WTR_Select(array(
		'id'			=> 'wtr_SidebarPickOnSinglePage',
		'title'			=> __( 'Set sidebar  on single page', 'wtr_framework' ),
		'desc'			=> __( 'This setting may be overridden by single pages', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => '',
		'info'			=> '',
		'allow'			=> 'all',
		'option'		=>  array(),
		'meta' 			=> __( 'Add sidebar', 'wtr_framework' ),
		'mod' 			=> 'sidebar'
	)
);

$wtr_SidebarPositionOnTrainer = new WTR_Radio_Img( array(
		'id'			=> 'wtr_SidebarPositionOnTrainer',
		'title'			=> __( 'Sidebar position on trainer', 'wtr_framework' ),
		'desc'			=> __( 'This setting may be overridden by single pages', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => 'setRightSide',
		'info'			=> '',
		'allow'			=> 'all',
		'checked' 		=> 'sideChecked',
		'class' 		=> 'sideSetter',
		'option'		=> array( 'setLeftSide' , 'setRightSide', 'setNone' ),
	)
);

$wtr_SidebarPickOnTrainer  = new WTR_Select(array(
		'id'			=> 'wtr_SidebarPickOnTrainer',
		'title'			=> __( 'Set sidebar  on trainer', 'wtr_framework' ),
		'desc'			=> __( 'This setting may be overridden by single pages', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => '',
		'info'			=> '',
		'allow'			=> 'all',
		'option'		=>  array(),
		'meta' 			=> __( 'Add sidebar', 'wtr_framework' ),
		'mod' 			=> 'sidebar'
	)
);
$wtr_SidebarPositionOnRooms = new WTR_Radio_Img( array(
		'id'			=> 'wtr_SidebarPositionOnRooms',
		'title'			=> __( 'Sidebar position on room', 'wtr_framework' ),
		'desc'			=> __( 'This setting may be overridden by single pages', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => 'setRightSide',
		'info'			=> '',
		'allow'			=> 'all',
		'checked' 		=> 'sideChecked',
		'class' 		=> 'sideSetter',
		'option'		=> array( 'setLeftSide' , 'setRightSide', 'setNone' ),
	)
);

$wtr_SidebarPickOnRooms = new WTR_Select(array(
		'id'			=> 'wtr_SidebarPickOnRooms',
		'title'			=> __( 'Set sidebar  on room', 'wtr_framework' ),
		'desc'			=> '',
		'value'			=> '',
		'default_value' => '',
		'info'			=> '',
		'allow'			=> 'all',
		'option'		=>  array(),
		'meta' 			=> __( 'Add sidebar', 'wtr_framework' ),
		'mod' 			=> 'sidebar'
	)
);

$wtr_SidebarPositionOnEvent= new WTR_Radio_Img( array(
		'id'			=> 'wtr_SidebarPositionOnEvent',
		'title'			=> __( 'Sidebar position on event', 'wtr_framework' ),
		'desc'			=> '',
		'value'			=> '',
		'default_value' => 'setRightSide',
		'info'			=> '',
		'allow'			=> 'all',
		'checked' 		=> 'sideChecked',
		'class' 		=> 'sideSetter',
		'option'		=> array( 'setLeftSide' , 'setRightSide', 'setNone' ),
	)
);

$wtr_SidebarPickOnEvent = new WTR_Select(array(
		'id'			=> 'wtr_SidebarPickOnEvent',
		'title'			=> __( 'Set sidebar on event', 'wtr_framework' ),
		'desc'			=> __( 'This setting may be overridden by single pages', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => '',
		'info'			=> '',
		'allow'			=> 'all',
		'option'		=>  array(),
		'meta' 			=> __( 'Add sidebar', 'wtr_framework' ),
		'mod' 			=> 'sidebar'
	)
);

//Blog: wtr_GeneralBlogSection
$wtr_BlogPostNumber = new WTR_Text( array(
		'id'			=> 'wtr_BlogPostNumber',
		'class'			=> '',
		'title'			=> __( 'Number of posts per page', 'wtr_framework' ),
		'desc'			=> '',
		'value'			=> '',
		'default_value' => '5',
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_BlogExcerptLength = new WTR_Text( array(
		'id'			=> 'wtr_BlogExcerptLength',
		'class'			=> '',
		'title'			=> __( 'Post excerpt length ( signs )', 'wtr_framework' ),
		'desc'			=> __( 'The value must be a number', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => '300',
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_BlogStreamStyle = new WTR_Select( array(
		'id'			=> 'wtr_BlogStreamStyle',
		'title'			=> __( 'Blog style', 'wtr_framework' ),
		'desc'			=> '',
		'value'			=> '',
		'default_value' => '0',
		'info'			=> '',
		'allow'			=> 'int',
		'mod' 			=> '',
		'option'		=> array( '0' => 'Normal' , '1' => 'Modern' ),
	)
);

$wtr_BlogSingleStyle = new WTR_Select( array(
		'id'			=> 'wtr_BlogSingleStyle',
		'title'			=> __( 'Blog style', 'wtr_framework' ),
		'desc'			=> __( 'Single post', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => '0',
		'info'			=> '',
		'allow'			=> 'int',
		'mod' 			=> '',
		'option'		=> array( '0' => 'Normal' , '1' => 'Modern' ),
	)
);

$wtr_BlogDefaultBlogDateFormat = new WTR_Select( array(
		'id'			=> 'wtr_BlogDefaultBlogDateFormat',
		'title'			=> __( 'Default blog date format', 'wtr_framework' ),
		'desc' 			=> __( 'date format in blog, single post, shortcode latest news, widgets, and recent comments', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => '1',
		'info'			=> '',
		'allow'			=> 'int',
		'mod' 			=> '',
		'option'		=> $wtr_date_format_field
	)
);

$wtr_BlogShowMeta = new WTR_Radio( array(
		'id'			=> 'wtr_BlogShowMeta',
		'title'			=> __( 'Show meta', 'wtr_framework' ),
		'desc'			=> __( 'Author, Comment, Sticky', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => '1',
		'info'			=> '',
		'allow'			=> 'int',
		'option'		=> array( '1' => 'On' , '0' => 'Off' ),
	)
);

$wtr_BlogCategoriesInPost = new WTR_Radio( array(
		'id'			=> 'wtr_BlogCategoriesInPost',
		'title'			=> __( 'Show categories', 'wtr_framework' ),
		'desc'			=> __( 'Single post', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => '1',
		'info'			=> '',
		'allow'			=> 'int',
		'option'		=> array( '1' => 'On' , '0' => 'Off' ),
	)
);

$wtr_BlogShowTagsInBlogPost = new WTR_Radio( array(
		'id'			=> 'wtr_BlogShowTagsInBlogPost',
		'title'			=> __( 'Show tags', 'wtr_framework' ),
		'desc'			=> __( 'Single post', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => '1',
		'info'			=> '',
		'allow'			=> 'int',
		'option'		=> array( '1' => 'On' , '0' => 'Off' ),
	)
);

$wtr_BlogSocialMediaToolbar = new WTR_Radio( array(
		'id'			=> 'wtr_BlogSocialMediaToolbar',
		'title'			=> __( 'Social media toolbar', 'wtr_framework' ),
		'desc'			=> __( 'Single post', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => '1',
		'info'			=> '',
		'allow'			=> 'int',
		'option'		=> array( '1' => 'On' , '0' => 'Off' ),
	)
);

$wtr_BlogShowAuthorBio = new WTR_Radio( array(
		'id'			=> 'wtr_BlogShowAuthorBio',
		'title'			=> __( 'Show author bio', 'wtr_framework' ),
		'desc'			=> __( 'Single post', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => '1',
		'info'			=> '',
		'allow'			=> 'int',
		'option'		=> array( '1' => 'On' , '0' => 'Off' ),
	)
);

$wtr_BlogRelatedPosts = new WTR_Radio( array(
		'id'			=> 'wtr_BlogRelatedPosts',
		'title'			=> __( 'Related posts', 'wtr_framework' ),
		'desc'			=> __( 'Single post', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => '0',
		'info'			=> '',
		'allow'			=> 'int',
		'option'		=> array( '1' => 'On' , '0' => 'Off' ),
	)
);

$wtr_BlogRelatedPostsBy = new WTR_Select( array(
		'id'			=> 'wtr_BlogRelatedPostsBy',
		'title'			=> __( 'Related posts by', 'wtr_framework' ),
		'desc'			=> __( 'Single post', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => '0',
		'info'			=> '',
		'allow'			=> 'int',
		'mod' 			=> '',
		'option'		=> array(
									'0' => __( 'Tags ', 'wtr_framework' ),
									'1' => __( 'Category', 'wtr_framework' ),
									'2' => __( 'Tags and Category', 'wtr_framework' )
									),
	)
);

$wtr_BlogRelatedPostsOrderBy = new WTR_Select( array(
		'id'			=> 'wtr_BlogRelatedPostsOrderBy',
		'title'			=> __( 'Related posts order by', 'wtr_framework' ),
		'desc'			=> __( 'Single post', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => '0',
		'info'			=> '',
		'allow'			=> 'int',
		'mod' 			=> '',
		'option'		=> array( '0' => __( ' Lastest ', 'wtr_framework' ), '1' => __( 'Random', 'wtr_framework' )),
	)
);

$wtr_BlogBreadCrumbsContainer = new WTR_Radio( array(
		'id'			=> 'wtr_BlogBreadCrumbsContainer',
		'title'			=> __( 'Breadcrumbs container', 'wtr_framework' ),
		'desc'			=> __( 'Single post', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => '1',
		'info'			=> '',
		'allow'			=> 'int',
		'option'		=> array( '1' => 'On' , '0' => 'Off' ),
	)
);

$wtr_BlogBreadCrumbs = new WTR_Radio( array(
		'id'			=> 'wtr_BlogBreadCrumbs',
		'title'			=> __( 'Breadcrumbs', 'wtr_framework' ),
		'desc'			=> __( 'Single post', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => '1',
		'info'			=> '',
		'allow'			=> 'int',
		'option'		=> array( '1' => 'On' , '0' => 'Off' ),
	)
);

//Events: wtr_GeneralBlogSection
$wtr_EventPostNumber = new WTR_Text( array(
		'id'			=> 'wtr_EventPostNumber',
		'class'			=> '',
		'title'			=> __( 'Number of events per page', 'wtr_framework' ),
		'desc'			=> '',
		'value'			=> '',
		'default_value' => '5',
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_EventPostDateFormat = new WTR_Select( array(
		'id'			=> 'wtr_EventPostDateFormat',
		'title'			=> __( 'Event date format', 'wtr_framework' ),
		'desc'			=> '',
		'value'			=> '',
		'default_value' => '1',
		'info'			=> '',
		'allow'			=> 'int',
		'mod' 			=> '',
		'option'		=> $wtr_date_format_field
	)
);

$wtr_EventPostReviewType = new WTR_Select( array(
		'id'			=> 'wtr_EventPostReviewType',
		'title'			=> __( 'Event review type', 'wtr_framework' ),
		'desc'			=> '',
		'value'			=> '',
		'default_value' => '1',
		'info'			=> '',
		'allow'			=> 'int',
		'mod' 			=> '',
		'option'		=> array( 0 => __( 'All', 'wtr_framework' ) , 1 => __( 'Split ( current / outdated )', 'wtr_framework' )  )
	)
);

//Social Media links: wtr_SocialMediaSocialMediaLinksSection
$wtr_SocialMediaFacebook = new WTR_Text( array(
		'id'			=> 'wtr_SocialMediaFacebook',
		'class'			=> '',
		'title'			=> __( 'Facebook', 'wtr_framework' ),
		'desc'			=> '',
		'value'			=> '',
		'default_value' => '',
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_SocialMediaGooglePlus = new WTR_Text( array(
		'id'			=> 'wtr_SocialMediaGooglePlus',
		'class'			=> '',
		'title'			=> __( 'Google +', 'wtr_framework' ),
		'desc'			=> '',
		'value'			=> '',
		'default_value' => '',
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_SocialMediaTwitter = new WTR_Text( array(
		'id'			=> 'wtr_SocialMediaTwitter',
		'class'			=> '',
		'title'			=> __( 'Twitter', 'wtr_framework' ),
		'desc'			=> '',
		'value'			=> '',
		'default_value' => '',
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_SocialMediaVimeo = new WTR_Text( array(
		'id'			=> 'wtr_SocialMediaVimeo',
		'class'			=> '',
		'title'			=> __( 'Vimeo', 'wtr_framework' ),
		'desc'			=> '',
		'value'			=> '',
		'default_value' => '',
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_SocialMediaYouTube = new WTR_Text( array(
		'id'			=> 'wtr_SocialMediaYouTube',
		'class'			=> '',
		'title'			=> __( 'YouTube', 'wtr_framework' ),
		'desc'			=> '',
		'value'			=> '',
		'default_value' => '',
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_SocialMediaFlickr = new WTR_Text( array(
		'id'			=> 'wtr_SocialMediaFlickr',
		'class'			=> '',
		'title'			=> __( 'Flickr', 'wtr_framework' ),
		'desc'			=> '',
		'value'			=> '',
		'default_value' => '',
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_SocialMediaPinterest = new WTR_Text( array(
		'id'			=> 'wtr_SocialMediaPinterest',
		'class'			=> '',
		'title'			=> __( 'Pinterest', 'wtr_framework' ),
		'desc'			=> '',
		'value'			=> '',
		'default_value' => '',
		'info'			=> '',
		'allow'			=> 'all',
	)
);


$wtr_SocialMediaInstagram = new WTR_Text( array(
		'id'			=> 'wtr_SocialMediaInstagram',
		'class'			=> '',
		'title'			=> __( 'Instagram', 'wtr_framework' ),
		'desc'			=> '',
		'value'			=> '',
		'default_value' => '',
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_SocialMediaTumblr = new WTR_Text( array(
		'id'			=> 'wtr_SocialMediaTumblr',
		'class'			=> '',
		'title'			=> __( 'Tumblr', 'wtr_framework' ),
		'desc'			=> '',
		'value'			=> '',
		'default_value' => '',
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_SocialMediaVKontakte = new WTR_Text( array(
		'id'			=> 'wtr_SocialMediaVKontakte',
		'class'			=> '',
		'title'			=> __( 'VKontakte', 'wtr_framework' ),
		'desc'			=> '',
		'value'			=> '',
		'default_value' => '',
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_SocialMediaLinkedIn = new WTR_Text( array(
		'id'			=> 'wtr_SocialMediaLinkedIn',
		'class'			=> '',
		'title'			=> __( 'LinkedIn', 'wtr_framework' ),
		'desc'			=> '',
		'value'			=> '',
		'default_value' => '',
		'info'			=> '',
		'allow'			=> 'all',
	)
);

//Social Media settings: wtr_SocialMediaSocialMediaSettingsSection
$wtr_SocialsMediaSettFacebook = new WTR_Radio( array(
		'id'			=> 'wtr_SocialsMediaSettFacebook',
		'title'			=> __( 'Facebook share button', 'wtr_framework' ),
		'desc'			=> '',
		'value'			=> '',
		'default_value' => '1',
		'info'			=> '',
		'allow'			=> 'int',
		'option'		=> array( '1' => 'On' , '0' => 'Off' ),
	)
);

$wtr_SocialsMediaSettGooglePlus = new WTR_Radio( array(
		'id'			=> 'wtr_SocialsMediaSettGooglePlus',
		'title'			=> __( 'Google+ share button', 'wtr_framework' ),
		'desc'			=> '',
		'value'			=> '',
		'default_value' => '1',
		'info'			=> '',
		'allow'			=> 'int',
		'option'		=> array( '1' => 'On' , '0' => 'Off' ),
	)
);

$wtr_SocialsMediaSettTwitter = new WTR_Radio( array(
		'id'			=> 'wtr_SocialsMediaSettTwitter',
		'title'			=> __( 'Twitter share button', 'wtr_framework' ),
		'desc'			=> '',
		'value'			=> '',
		'default_value' => '1',
		'info'			=> '',
		'allow'			=> 'int',
		'option'		=> array( '1' => 'On' , '0' => 'Off' ),
	)
);

$wtr_SocialsMediaSettPinterest = new WTR_Radio( array(
		'id'			=> 'wtr_SocialsMediaSettPinterest',
		'title'			=> __( 'Pinterest share button', 'wtr_framework' ),
		'desc'			=> '',
		'value'			=> '',
		'default_value' => '1',
		'info'			=> '',
		'allow'			=> 'int',
		'option'		=> array( '1' => 'On' , '0' => 'Off' ),
	)
);

$wtr_SocialsMediaSettTumblr = new WTR_Radio( array(
		'id'			=> 'wtr_SocialsMediaSettTumblr',
		'title'			=> __( 'Tumblr share button', 'wtr_framework' ),
		'desc'			=> '',
		'value'			=> '',
		'default_value' => '1',
		'info'			=> '',
		'allow'			=> 'int',
		'option'		=> array( '1' => 'On' , '0' => 'Off' ),
	)
);


//Header: wtr_LaloutHeaderSection
$wtr_HeaderSettings = new WTR_Select( array(
		'id'			=> 'wtr_HeaderSettings',
		'title'			=> __( 'Header settings', 'wtr_framework' ),
		'desc'			=> '',
		'value'			=> '',
		'default_value' => '1',
		'info'			=> '',
		'allow'			=> 'int',
		'mod' 			=> '',
		'option'		=> array(
									'0' => __( 'Off', 'wtr_framework' ),
									'1' => __( 'Show Menu', 'wtr_framework' ),
									'2' => __( 'Show Menu &#43; Socials', 'wtr_framework' )
									),
	)
);

$wtr_HeaderType = new WTR_Select( array(
		'id'			=> 'wtr_HeaderType',
		'title'			=> __( 'Header type', 'wtr_framework' ),
		'desc'			=> '',
		'value'			=> '',
		'default_value' => '0',
		'info'			=> '',
		'allow'			=> 'int',
		'mod' 			=> '',
		'option'		=> array(
									'0' => __( 'Standard', 'wtr_framework' ),
									'1' => __( 'Boxed', 'wtr_framework' ),
									),
	)
);

$wtr_HeaderNavigationType = new WTR_Select( array(
		'id'			=> 'wtr_HeaderNavigationType',
		'title'			=> __( 'Navigation type', 'wtr_framework' ),
		'desc'			=> '',
		'value'			=> '',
		'default_value' => '1',
		'info'			=> '',
		'allow'			=> 'int',
		'mod' 			=> '',
		'option'		=> array(
									'0' => __( 'Standard navigation', 'wtr_framework' ),
									'1' => __( 'Sticky navigation', 'wtr_framework' ),
									'2' => __( 'Smart navigation', 'wtr_framework' )
									),
	)
);

$wtr_HeaderMobileNavigationType = new WTR_Select( array(
		'id'			=> 'wtr_HeaderMobileNavigationType',
		'title'			=> __( 'Mobile navigation type', 'wtr_framework' ),
		'desc'			=> '',
		'value'			=> '',
		'default_value' => '1',
		'info'			=> '',
		'allow'			=> 'int',
		'mod' 			=> '',
		'option'		=> array(
									'0' => __( 'Classic ', 'wtr_framework' ),
									'1' => __( 'Modern ', 'wtr_framework' ),
									),
	)
);

$wtr_HeaderLogoPosition = new WTR_Select( array(
		'id'			=> 'wtr_HeaderLogoPosition',
		'title'			=> __( 'Logo position', 'wtr_framework' ),
		'desc'			=> '',
		'value'			=> '',
		'default_value' => '0',
		'info'			=> '',
		'allow'			=> 'int',
		'mod' 			=> '',
		'option'		=> array( '0' => 'Left' , '1' => 'Right' ),
	)
);

$wtr_HeaderLogoImage = new WTR_Upload( array(
		'id'			=> 'wtr_HeaderLogoImage',
		'title'			=> __( 'Graphic logo', 'wtr_framework' ),
		'desc'			=> '',
		'value'			=> '',
		'default_value' => WTR_THEME_URI . '/assets/img/default_images/logo.png',
		'info'			=> '',
		'allow'			=> 'all'
	),
	array( 'title_modal' => __( 'Insert image', 'wtr_framework' ) )
);

$wtr_HeaderLogoImageTransparent = new WTR_Upload( array(
		'id'			=> 'wtr_HeaderLogoImageTransparent',
		'title'			=> __( 'Graphic logo - transparent', 'wtr_framework' ),
		'desc'			=> '',
		'value'			=> '',
		'default_value' => WTR_THEME_URI . '/assets/img/default_images/logo_trans.png',
		'info'			=> '',
		'allow'			=> 'all'
	),
	array( 'title_modal' => __( 'Insert image', 'wtr_framework' ) )
);

$wtr_HeaderFavicon = new WTR_Upload( array(
		'id'			=> 'wtr_HeaderFavicon',
		'title'			=> __( 'Favicon', 'wtr_framework' ),
		'desc'			=> '',
		'value'			=> '',
		'default_value' => WTR_THEME_URI . '/assets/img/default_images/favi.png',
		'info'			=> '',
		'allow'			=> 'all'
	),
	array( 'title_modal' => __( 'Insert image', 'wtr_framework' ) )
);

$wtr_HeaderSectionOne  = new WTR_Text(array(
		'id'			=> 'wtr_HeaderSectionOne',
		'class'			=> '',
		'title'			=> __( 'First header section', 'wtr_framework' ),
		'desc'			=> '',
		'value'			=> '',
		'default_value'	=> '',
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_HeaderSectionTwo = new WTR_Text(array(
		'id'			=> 'wtr_HeaderSectionTwo',
		'class'			=> '',
		'title'			=> __( 'Second header section', 'wtr_framework' ),
		'desc'			=> '',
		'value'			=> '',
		'default_value'	=> '',
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_HeaderSearchStatus = new WTR_Radio( array(
		'id'			=> 'wtr_HeaderSearchStatus',
		'title'			=> __( 'Search icon inside main navigation', 'wtr_framework' ),
		'desc'			=> '',
		'value'			=> '',
		'default_value' => '1',
		'info'			=> '',
		'allow'			=> 'int',
		'option'		=> array( '1' => 'On' , '0' => 'Off' ),
	)
);

$wtr_HeaderBreadCrumbsContainer = new WTR_Radio( array(
		'id'			=> 'wtr_HeaderBreadCrumbsContainer',
		'title'			=> __( 'Breadcrumbs container', 'wtr_framework' ),
		'desc'			=> '',
		'value'			=> '',
		'default_value' => '1',
		'info'			=> '',
		'allow'			=> 'int',
		'option'		=> array( '1' => 'On' , '0' => 'Off' ),
	)
);

$wtr_HeaderBreadCrumbs = new WTR_Radio( array(
		'id'			=> 'wtr_HeaderBreadCrumbs',
		'title'			=> __( 'Breadcrumbs', 'wtr_framework' ),
		'desc'			=> '',
		'value'			=> '',
		'default_value' => '1',
		'info'			=> '',
		'allow'			=> 'int',
		'option'		=> array( '1' => 'On' , '0' => 'Off' ),
	)
);

$wtr_HeaderBreadCrumbsBackgroundImg = new WTR_Upload( array(
		'id'			=> 'wtr_HeaderBreadCrumbsBackgroundImg',
		'title'			=> __( 'Breadcrumbs background image', 'wtr_framework' ),
		'desc'			=> '',
		'value'			=> '',
		'default_value' => '',
		'info'			=> '',
		'allow'			=> 'all'
	),
	array( 'title_modal' => __( 'Insert image', 'wtr_framework' ) )
);

//Footer: wtr_LaloutFooterSection
$wtr_FooterSettings = new WTR_Select( array(
		'id'			=> 'wtr_FooterSettings',
		'title'			=> __( 'Footer settings', 'wtr_framework' ),
		'desc'			=> '',
		'value'			=> '',
		'default_value' => '2',
		'info'			=> '',
		'allow'			=> 'int',
		'mod' 			=> '',
		'option'		=> array(
									'0' => __( 'Off', 'wtr_framework' ),
									'1' => __( 'Show widget', 'wtr_framework' ),
									'2' => __( 'Show copyright', 'wtr_framework' ),
									'3' => __( 'Show copyright &#43; widget', 'wtr_framework' )
									),
	)
);

$wtr_FooterBackgroundImg = new WTR_Upload( array(
		'id'			=> 'wtr_FooterBackgroundImg',
		'title'			=> __( 'Footer background image', 'wtr_framework' ),
		'desc'			=> '',
		'value'			=> '',
		'default_value' => '',
		'info'			=> '',
		'allow'			=> 'all'
	),
	array( 'title_modal' => __( 'Insert image', 'wtr_framework' ) )
);

$wtr_FooterDivider = new WTR_Radio( array(
		'id'			=> 'wtr_FooterDivider',
		'title'			=> __( 'Footer divider', 'wtr_framework' ),
		'desc'			=> '',
		'value'			=> '',
		'default_value' => '1',
		'info'			=> '',
		'allow'			=> 'int',
		'option'		=> array( '1' => 'On' , '0' => 'Off' ),
	)
);

$wtr_FooterColumnNumber = new WTR_Radio_Img( array(
		'id'			=> 'wtr_FooterColumnNumber',
		'title'			=> __( 'Number of columns in footer', 'wtr_framework' ),
		'desc'			=> '',
		'value'			=> '',
		'default_value' => 'setTwo',
		'info'			=> '',
		'allow'			=> 'all',
		'checked' 		=> 'colsChecked',
		'class' 		=> 'footerColSetter',
		'option'		=> array( 'setOne' , 'setTwo', 'setThree', 'setFour' ),
	)
);

$wtr_FooterCenterColumn = new WTR_Radio( array(
		'id'			=> 'wtr_FooterCenterColumn',
		'title'			=> __( 'Footer promo column visibility', 'wtr_framework' ),
		'desc' 			=> __( 'First and full width widget section on footer', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => '1',
		'info'			=> '',
		'allow'			=> 'int',
		'option'		=> array( '1' => 'On' , '0' => 'Off' ),
	)
);


$wtr_FooterCoopyrightText = new WTR_Textarea( array(
		'id'			=> 'wtr_FooterCoopyrightText',
		'class'			=> '',
		'rows'			=> 10,
		'title'			=> __( 'Copyright text', 'wtr_framework' ),
		'desc'			=> '',
		'value'			=> '',
		'default_value' => '<p>Symetrio Multi - Sport WordPress Theme.</p>',
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_FooterSectionOne = new WTR_Text(array(
		'id'			=> 'wtr_FooterSectionOne',
		'class'			=> '',
		'title'			=> __( 'First footer section', 'wtr_framework' ),
		'desc'			=> '',
		'value'			=> '',
		'default_value'	=> '<a href="">contact@example.com</a>',
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_FooterSectionTwo = new WTR_Text(array(
		'id'			=> 'wtr_FooterSectionTwo',
		'class'			=> '',
		'title'			=> __( 'Second footer section', 'wtr_framework' ),
		'desc'			=> '',
		'value'			=> '',
		'default_value'	=> 'Made by <a href="http://wonster.co">Wonster</a> © 2014',
		'info'			=> '',
		'allow'			=> 'all',
	)
);

//Custom css: wtr_CustomeCssSection
$wtr_CustomeCSS = new WTR_Radio( array(
		'id'			=> 'wtr_CustomeCSS',
		'title'			=> __( 'Custom CSS', 'wtr_framework' ),
		'desc'			=> '',
		'value'			=> '',
		'default_value' => '1',
		'info'			=> '',
		'allow'			=> 'int',
		'option'		=> array( '1' => 'On' , '0' => 'Off' ),
	)
);

$wtr_CustomeCssCode = new WTR_Textarea( array(
		'id'			=> 'wtr_CustomeCssCode',
		'class'			=> '',
		'rows'			=> 17,
		'title'			=> __( 'Custom CSS code', 'wtr_framework' ),
		'desc'			=> '',
		'value'			=> '',
		'default_value' => '',
		'info'			=> '',
		'allow'			=> 'all',
	)
);

//General: wtr_ColorGeneralSection
$wtr_ColorThemeAlert = new WTR_Alert( array(
		'id'			=> 'wtr_ColorThemeAlert',
		'title'			=> __( 'If you want to change theme colors please go to Appearance > Customize.', 'wtr_framework' ),
		'desc'			=> '',
		'value'			=> '',
		'default_value' => '1',
		'info'			=> '',
		'allow'			=> 'int',
		'mod' 			=> ''
	)
);

$wtr_ColorThemeSkin = new WTR_Select( array(
		'id'			=> 'wtr_ColorThemeSkin',
		'title'			=> __( 'Theme skin', 'wtr_framework' ),
		'desc'			=> __( '<span style="color: #ff787e"> If you want to make customization without the use of predefined skins, this field should be "custome".</span>', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => 'custom',
		'info'			=> '',
		'allow'			=> 'all',
		'mod' 			=> '',
		'option'		=> array_merge( array( 'custom'	=> __( 'Custom' , 'wtr_framework' ) ), $wtr_theme_skins_defaul ),
	)
);

$wtr_ColorThemeSkinOverwrite = new WTR_Select( array(
		'id'			=> 'wtr_ColorThemeSkinOverwrite',
		'title'			=> __( 'Theme custom skin overwrite', 'wtr_framework' ),
		'desc'			=> __( '<span style="color: #ff787e"> If you want to modify predefined style, select your style and click „overwrite” it will overwrite custom style. </br> After that, please go to Appearance > Customize.</span>', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => 'blue',
		'info'			=> '',
		'allow'			=> 'all',
		'mod' 			=> 'overwrite_skin',
		'option'		=> $wtr_theme_skins_defaul,
	)
);


//Font-size: wtr_FontsFontSizeSection
$wtr_FontsSize_1 = new WTR_Scroll( array(
		'id'			=> 'wtr_FontsSize_1',
		'class'			=> '',
		'title'			=> __( 'Navigation font size', 'wtr_framework' ),
		'desc'			=> '',
		'value' 		=> 0,
		'default_value' => 18,
		'info'			=> '',
		'allow'			=> 'between',
		'has_attr' 		=> 'px',
		'min' 			=> 8,
		'max' 			=> 100,
		'css'			=> array(
			'selector'	=> '.wtrMainNavigation .wtrNaviCartItem a i, .wtrMainNavigation .wtrNaviItem .wtrNaviSearchItem div i, .wtrMainNavigation .wtrNaviItem > a, .wtrMainNavigation .wtrNaviItem > .wtrNaviNoLink',
			'style'		=> 'font-size',
			'important'	=> true,
			)
	)
);

$wtr_FontsSize_2 = new WTR_Scroll( array(
		'id'			=> 'wtr_FontsSize_2',
		'class'			=> '',
		'title'			=> __( 'Breadcrumb headline font size', 'wtr_framework' ),
		'desc'			=> '',
		'value' 		=> 0,
		'default_value' => 20,
		'info'			=> '',
		'allow'			=> 'between',
		'has_attr' 		=> 'px',
		'min' 			=> 8,
		'max' 			=> 100,
		'css'			=> array(
			'selector'	=> '.wtrBreadcrumbHeadline',
			'style'		=> 'font-size',
			)
	)
);

$wtr_FontsSize_3 = new WTR_Scroll( array(
		'id'			=> 'wtr_FontsSize_3',
		'class'			=> '',
		'title'			=> __( 'Breadcrumb patch font size', 'wtr_framework' ),
		'desc'			=> '',
		'value' 		=> 0,
		'default_value' => 16,
		'info'			=> '',
		'allow'			=> 'between',
		'has_attr' 		=> 'px',
		'min' 			=> 8,
		'max' 			=> 100,
		'css'			=> array(
			'selector'	=> '.wtrBreadcrumbPathList .wtrCrumb, .wtrBreadcrumbPathList .wtrCrumb a',
			'style'		=> 'font-size',
			'important'	=> true,
			)
	)
);

$wtr_FontsSize_4 = new WTR_Scroll( array(
		'id'			=> 'wtr_FontsSize_4',
		'class'			=> '',
		'title'			=> __( 'Sidebar widget headlines font size', 'wtr_framework' ),
		'desc'			=> '',
		'value' 		=> 0,
		'default_value' => 20,
		'info'			=> '',
		'allow'			=> 'between',
		'has_attr' 		=> 'px',
		'min' 			=> 8,
		'max' 			=> 100,
		'css'			=> array(
			'selector'	=> '.wtrSidebarWdg  .widget h6',
			'style'		=> 'font-size',
			'important'	=> true,
			)
	)
);

$wtr_FontsSize_5 = new WTR_Scroll( array(
		'id'			=> 'wtr_FontsSize_5',
		'class'			=> '',
		'title'			=> __( 'Footer widget headlines font size', 'wtr_framework' ),
		'desc'			=> '',
		'value' 		=> 0,
		'default_value' => 20,
		'info'			=> '',
		'allow'			=> 'between',
		'has_attr' 		=> 'px',
		'min' 			=> 8,
		'max' 			=> 100,
		'css'			=> array(
			'selector'	=> '.wtrFooterWdg .widget h6',
			'style'		=> 'font-size',
			'important'	=> true,
			)
	)
);

$wtr_FontsSize_6 = new WTR_Scroll( array(
		'id'			=> 'wtr_FontsSize_6',
		'class'			=> '',
		'title'			=> __( 'Page H1 size', 'wtr_framework' ),
		'desc'			=> '',
		'value' 		=> 0,
		'default_value' => 28,
		'info'			=> '',
		'allow'			=> 'between',
		'has_attr' 		=> 'px',
		'min' 			=> 8,
		'max' 			=> 100,
		'css'			=> array(
			'selector'	=> '.wtrPageContent h1',
			'style'		=> 'font-size',
			)
	)
);

$wtr_FontsSize_7 = new WTR_Scroll( array(
		'id'			=> 'wtr_FontsSize_7',
		'class'			=> '',
		'title'			=> __( 'Page H2 size', 'wtr_framework' ),
		'desc'			=> '',
		'value' 		=> 0,
		'default_value' => 24,
		'info'			=> '',
		'allow'			=> 'between',
		'has_attr' 		=> 'px',
		'min' 			=> 8,
		'max' 			=> 100,
		'css'			=> array(
			'selector'	=> '.wtrPageContent h2',
			'style'		=> 'font-size',
			)
	)
);

$wtr_FontsSize_8 = new WTR_Scroll( array(
		'id'			=> 'wtr_FontsSize_8',
		'class'			=> '',
		'title'			=> __( 'Page H3 size', 'wtr_framework' ),
		'desc'			=> '',
		'value' 		=> 0,
		'default_value' => 22,
		'info'			=> '',
		'allow'			=> 'between',
		'has_attr' 		=> 'px',
		'min' 			=> 8,
		'max' 			=> 100,
		'css'			=> array(
			'selector'	=> '.wtrPageContent h3',
			'style'		=> 'font-size',
			)
	)
);

$wtr_FontsSize_9 = new WTR_Scroll( array(
		'id'			=> 'wtr_FontsSize_9',
		'class'			=> '',
		'title'			=> __( 'Page H4 size', 'wtr_framework' ),
		'desc'			=> '',
		'value' 		=> 0,
		'default_value' => 20,
		'info'			=> '',
		'allow'			=> 'between',
		'has_attr' 		=> 'px',
		'min' 			=> 8,
		'max' 			=> 100,
		'css'			=> array(
			'selector'	=> '.wtrPageContent h4',
			'style'		=> 'font-size',
			)
	)
);

$wtr_FontsSize_10 = new WTR_Scroll( array(
		'id'			=> 'wtr_FontsSize_10',
		'class'			=> '',
		'title'			=> __( 'Page H5 size', 'wtr_framework' ),
		'desc'			=> '',
		'value' 		=> 0,
		'default_value' => 18,
		'info'			=> '',
		'allow'			=> 'between',
		'has_attr' 		=> 'px',
		'min' 			=> 8,
		'max' 			=> 100,
		'css'			=> array(
			'selector'	=> '.wtrPageContent h5',
			'style'		=> 'font-size',
			)
	)
);

$wtr_FontsSize_11 = new WTR_Scroll( array(
		'id'			=> 'wtr_FontsSize_11',
		'class'			=> '',
		'title'			=> __( 'Page H6 size', 'wtr_framework' ),
		'desc'			=> '',
		'value' 		=> 0,
		'default_value' => 16,
		'info'			=> '',
		'allow'			=> 'between',
		'has_attr' 		=> 'px',
		'min' 			=> 8,
		'max' 			=> 100,
		'css'			=> array(
			'selector'	=> '.wtrPageContent h6',
			'style'		=> 'font-size',
			)
	)
);

$wtr_FontsSize_12 = new WTR_Scroll( array(
		'id'			=> 'wtr_FontsSize_12',
		'class'			=> '',
		'title'			=> __( 'Page p size', 'wtr_framework' ),
		'desc'			=> '',
		'value' 		=> 0,
		'default_value' => 16,
		'info'			=> '',
		'allow'			=> 'between',
		'has_attr' 		=> 'px',
		'min' 			=> 8,
		'max' 			=> 100,
		'css'			=> array(
			'selector'	=> '.wtrPageContent, .wtrPageContent p, .wtrPageContent .wpb_text_column a',
			'style'		=> 'font-size',
			)
	)
);

$wtr_FontsSize_13 = new WTR_Scroll( array(
		'id'			=> 'wtr_FontsSize_13',
		'class'			=> '',
		'title'			=> __( 'Navigation font size (mega menu, second and third level)', 'wtr_framework' ),
		'desc'			=> '',
		'value' 		=> 0,
		'default_value' => 14,
		'info'			=> '',
		'allow'			=> 'between',
		'has_attr' 		=> 'px',
		'min' 			=> 8,
		'max' 			=> 100,
		'css'			=> array(
			'selector'	=> '.wtrSecondNavigation .wtrSecNaviItem .wtrSecNaviItemLink',
			'style'		=> 'font-size',
			)
	)
);

$wtr_FontsSize_14 = new WTR_Scroll( array(
		'id'			=> 'wtr_FontsSize_14',
		'class'			=> '',
		'title'			=> __( 'Navigation font size (mega menu headlines)', 'wtr_framework' ),
		'desc'			=> '',
		'value' 		=> 0,
		'default_value' => 18,
		'info'			=> '',
		'allow'			=> 'between',
		'has_attr' 		=> 'px',
		'min' 			=> 8,
		'max' 			=> 100,
		'css'			=> array(
			'selector'	=> '.wtrMegaMenuHeadline, .wtrMegaMenuHeadline a',
			'style'		=> 'font-size',
			'important'	=> true,
			)
	)
);
//Font - family: wtr_FontFontFamilySection
$wtr_txt_hidden = new WTR_Text( array(
		'id'			=> 'font_text_hidden',
		'class' 		=> 'wtr_admin_font_switch',
		'title'			=> __( 'Preview Text', 'wtr_framework' ),
		'desc'			=> '',
		'value'			=> '',
		'default_value' => 'lore ipsum',
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_admin_prev_font_size = new WTR_Scroll( array(
		'id'			=> '_wtr_admin_prev_font_size',
		'class' 		=> 'wtr_admin_prev_font_size',
		'title'			=> __( 'Preview text size', 'wtr_framework' ),
		'desc'			=> '',
		'value' 		=> 0,
		'default_value' => 20,
		'info'			=> '',
		'allow'			=> 'between',
		'has_attr' 		=> 'px',
		'min' 			=> 8,
		'max' 			=> 60,
	)
);

$wtr_FontsFont_0 = new WTR_Select( array(
		'id'			=> 'wtr_FontsFont_0',
		'title'			=> __( 'Default body and paragraph font family', 'wtr_framework' ),
		'desc' 			=>'',
		'value' 		=> '',
		'default_value' => '_"Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif',
		'info' 			=> '',
		'allow' 		=> 'all',
		'mod' 			=> 'font',
		'option' 		=> array(
			__( 'default font', 'wtr_framework' )	=> array( '_"Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif'	=> 'Arial / Helvetica' ),
			__( 'standard font', 'wtr_framework' )	=> $fonts_stanrad,
			__( 'popular fonts', 'wtr_framework' )	=> $fonts_popular,
			__( 'all fonts', 'wtr_framework' )		=> $fonts_all
		),
		'css'			=> array(
			'selector'	=> 'body, button, input, textarea, .wtrDefFontCharacter',
			'style'		=> 'font-family'
			)
	)
);


$wtr_FontsFont_1 = new WTR_Select( array(
		'id'			=> 'wtr_FontsFont_1',
		'title'			=> 'Default headline font family',
		'desc' 			=> '',
		'value' 		=> '',
		'default_value' => 'Montserrat',
		'info' 			=> '',
		'allow' 		=> 'all',
		'mod' 			=> 'font',
		'option' 		=> array(
			__( 'default font', 'wtr_framework' )	=> array( 'Montserrat'	=> 'Montserrat', ),
			__( 'standard font', 'wtr_framework' )	=> $fonts_stanrad,
			__( 'popular fonts', 'wtr_framework' )	=> $fonts_popular,
			__( 'all fonts', 'wtr_framework' )		=> $fonts_all
		),
		'css'			=> array(
			'selector'	=> '#fp-nav ul li .fp-tooltip, h1, h2, h3, h4, h5, h6, .wrtAltFontCharacter, .wtrHeadlineElement, .wtrCommentList .comment cite.fn, .wtrCommentList .comment cite.fn a,.ptp-price',
			'style'		=> 'font-family'
			)
	)
);

$wtr_FontsFont_2 = new WTR_Select( array(
		'id'			=> 'wtr_FontsFont_2',
		'title'			=> 'Quote and testimonial font family: ',
		'desc' 			=> '',
		'value' 		=> '',
		'default_value' => 'Noto Serif',
		'info' 			=> '',
		'allow' 		=> 'all',
		'mod' 			=> 'font',
		'option' 		=> array(
			__( 'default font', 'wtr_framework' )	=> array( 'Noto Serif' => 'Noto Serif' ),
			__( 'standard font', 'wtr_framework' )	=> $fonts_stanrad,
			__( 'popular fonts', 'wtr_framework' )	=> $fonts_popular,
			__( 'all fonts', 'wtr_framework' )		=> $fonts_all
		),
		'css'			=> array(
			'selector'	=> 'blockquote, .wrtSecAltFontCharacter,.ptp-most-popular, .wtrShtTestimonialRot .wtrShtTestimonialStdContainer p',
			'style'		=> 'font-family'
			)
	)
);

$wtr_FontsFont_3 = new WTR_Select( array(
		'id'			=> 'wtr_FontsFont_3',
		'title'			=> 'Default first level navigation font family',
		'desc' 			=> '',
		'value' 		=> '',
		'default_value' => '_"Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif',
		'info' 			=> '',
		'allow' 		=> 'all',
		'mod' 			=> 'font',
		'option' 		=> array(
			__( 'default font', 'wtr_framework' )	=> array( '_"Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif'	=> 'Arial / Helvetica' ),
			__( 'standard font', 'wtr_framework' )	=> $fonts_stanrad,
			__( 'popular fonts', 'wtr_framework' )	=> $fonts_popular,
			__( 'all fonts', 'wtr_framework' )		=> $fonts_all
		),
		'css'			=> array(
			'selector'	=> '.wtrMainNavigation .wtrNaviItem > a, .wtrMainNavigation .wtrNaviItem > span',
			'style'		=> 'font-family'
			)
	)
);

$wtrFontsGoogleFontSubset = new WTR_Text( array(
		'id'			=> 'wtrFontsGoogleFontSubset',
		'class'			=> '',
		'title'			=> __( 'Google font subset', 'wtr_framework' ),
		'desc'			=> '',
		'value'			=> '',
		'default_value' => '',
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtrFontsCustomFontName = new WTR_Text( array(
		'id'			=> 'wtrFontsCustomFontName',
		'class'			=> '',
		'title'			=> __( 'Custom Font | Name ', 'wtr_framework' ),
		'desc'			=> __( "This name will be used in CSS declaration for example: </br> p { font-family: 'MyWebFont', Arial, sans-serif; }", 'wtr_framework' ),
		'value'			=> '',
		'default_value' => '',
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtrFontsCustomFontWoff = new WTR_Upload( array(
					'id'			=> 'wtrFontsCustomFontWoff',
					'title'			=> __( 'Custom Font | .woff', 'wtr_sht_framework' ),
					'desc'			=> '',
					'value'			=> '',
					'default_value'	=> '',
					'default_size'	=> 'full',
					'info'			=> '',
					'allow'			=> 'all',
					'mod'			=> 'custom_font',
					'class'			=> 'ModalFields VideoSrc',
					'mod'			=> 'custom_font',
				),
				array( 'filter_content' => 'font/woff',
					   'target_type' => 'text',
					 )
			);

$wtrFontsCustomFontTtf = new WTR_Upload( array(
					'id'			=> 'wtrFontsCustomFontTtf',
					'title'			=> __( 'Custom Font | .ttf', 'wtr_sht_framework' ),
					'desc'			=> '',
					'value'			=> '',
					'default_value'	=> '',
					'default_size'	=> 'full',
					'info'			=> '',
					'allow'			=> 'all',
					'class'			=> 'ModalFields VideoSrc',
					'mod'			=> 'custom_font',
				),
				array( 'filter_content' => 'font/ttf',
					   'target_type' => 'text',
					 )
			);


$wtrFontsCustomFontSvg = new WTR_Upload( array(
					'id'			=> 'wtrFontsCustomFontSvg',
					'title'			=> __( 'Custom Font | .svg', 'wtr_sht_framework' ),
					'desc'			=> '',
					'value'			=> '',
					'default_value'	=> '',
					'default_size'	=> 'full',
					'info'			=> '',
					'allow'			=> 'all',
					'class'			=> 'ModalFields VideoSrc',
					'mod'			=> 'custom_font',
				),
				array( 'filter_content' => 'font/svg',
					   'target_type' => 'text',
					 )
			);

$wtrFontsCustomFontEot = new WTR_Upload( array(
					'id'			=> 'wtrFontsCustomFontEot',
					'title'			=> __( 'Custom Font | .eot', 'wtr_sht_framework' ),
					'desc'			=> '',
					'value'			=> '',
					'default_value'	=> '',
					'default_size'	=> 'full',
					'info'			=> '',
					'allow'			=> 'all',
					'class'			=> 'ModalFields VideoSrc',
					'mod'			=> 'custom_font',
				),
				array( 'filter_content' => 'font/eot',
					   'target_type' => 'text',
					 )
			);

$wtrFontsCustom2FontName = new WTR_Text( array(
		'id'			=> 'wtrFontsCustom2FontName',
		'class'			=> '',
		'title'			=> __( 'Custom Font 2 | Name ', 'wtr_framework' ),
				'desc'			=> __( "This name will be used in CSS declaration for example: </br> p { font-family: 'MyWebFont', Arial, sans-serif; }", 'wtr_framework' ),
		'value'			=> '',
		'default_value' => '',
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtrFontsCustom2FontWoff = new WTR_Upload( array(
					'id'			=> 'wtrFontsCustom2FontWoff',
					'title'			=> __( 'Custom Font 2 | .woff', 'wtr_sht_framework' ),
					'desc'			=> '',
					'value'			=> '',
					'default_value'	=> '',
					'default_size'	=> 'full',
					'info'			=> '',
					'allow'			=> 'all',
					'class'			=> 'ModalFields VideoSrc',
					'mod'			=> 'custom_font',
				),
				array( 'filter_content' => 'font/woff',
					   'target_type' => 'text',
					 )
			);

$wtrFontsCustom2FontTtf = new WTR_Upload( array(
					'id'			=> 'wtrFontsCustom2FontTtf',
					'title'			=> __( 'Custom Font 2 | .ttf', 'wtr_sht_framework' ),
					'desc'			=> '',
					'value'			=> '',
					'default_value'	=> '',
					'default_size'	=> 'full',
					'info'			=> '',
					'allow'			=> 'all',
					'class'			=> 'ModalFields VideoSrc',
					'mod'			=> 'custom_font',
				),
				array( 'filter_content' => 'font/ttf',
					   'target_type' => 'text',
					 )
			);


$wtrFontsCustom2FontSvg = new WTR_Upload( array(
					'id'			=> 'wtrFontsCustom2FontSvg',
					'title'			=> __( 'Custom Font 2 | .svg', 'wtr_sht_framework' ),
					'desc'			=> '',
					'value'			=> '',
					'default_value'	=> '',
					'default_size'	=> 'full',
					'info'			=> '',
					'allow'			=> 'all',
					'class'			=> 'ModalFields VideoSrc',
					'mod'			=> 'custom_font',
				),
				array( 'filter_content' => 'font/svg',
					   'target_type' => 'text',
					 )
			);

$wtrFontsCustom2FontEot = new WTR_Upload( array(
					'id'			=> 'wtrFontsCustom2FontEot',
					'title'			=> __( 'Custom Font 2 | .eot', 'wtr_sht_framework' ),
					'desc'			=> '',
					'value'			=> '',
					'default_value'	=> '',
					'default_size'	=> 'full',
					'info'			=> '',
					'allow'			=> 'all',
					'class'			=> 'ModalFields VideoSrc',
					'mod'			=> 'custom_font',
				),
				array( 'filter_content' => 'font/eot',
					   'target_type' => 'text',
					 )
			);

//General: wtr_TranslateGeneralSection
$wtr_TranslateTranslationSettings = new WTR_Radio( array(
		'id'			=> 'wtr_TranslateTranslationSettings',
		'title'			=> __( 'Translation settings', 'wtr_framework' ),
		'desc'			=> __( 'Disable this setting if you want to use PO / MO files or other additional plugins like WPML', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => '1',
		'info'			=> '',
		'allow'			=> 'int',
		'option'		=> array( '1' => 'On' , '0' => 'Off' ),
	)
);

$wtr_TranslateHomeBreadcrumbsBlog = new WTR_Text( array(
		'id'			=> 'wtr_TranslateHomeBreadcrumbsBlog',
		'class'			=> '',
		'title'			=> __( 'Breadcrumbs text on blog', 'wtr_framework' ),
		'desc' 			=> __( 'Text which appears above blog breadcrumbs', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateHomeBreadcrumbsBlog' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateHomeBreadcrumbsMainPage = new WTR_Text( array(
		'id'			=> 'wtr_TranslateHomeBreadcrumbsMainPage',
		'class'			=> '',
		'title'			=> __( 'Breadcrumbs text on main page', 'wtr_framework' ),
		'desc' 			=> __( 'Text which appears above main page breadcrumbs', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateHomeBreadcrumbsMainPage' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateHomeCrumbsTaxArchiveFor = new WTR_Text( array(
		'id'			=> 'wtr_TranslateHomeCrumbsTaxArchiveFor',
		'class'			=> '',
		'title'			=> __( 'Taxonomy archive for', 'wtr_framework' ),
		'desc' 			=> '',
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateHomeCrumbsTaxArchiveFor' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);


$wtr_TranslateHomeOlderComments = new WTR_Text( array(
		'id'			=> 'wtr_TranslateHomeOlderComments',
		'class'			=> '',
		'title'			=> __( 'Older comments', 'wtr_framework' ),
		'desc' 			=> '',
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateHomeOlderComments' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateHomeNewerComments = new WTR_Text( array(
		'id'			=> 'wtr_TranslateHomeNewerComments',
		'class'			=> '',
		'title'			=> __( 'Newer comments', 'wtr_framework' ),
		'desc' 			=> '',
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateHomeNewerComments' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateHomeCommentsCount = new WTR_Text( array(
		'id'			=> 'wtr_TranslateHomeCommentsCount',
		'class'			=> '',
		'title'			=> __( 'Comments count', 'wtr_framework' ),
		'desc' 			=> '',
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateHomeCommentsCount' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateHomeCommentsAreClosed = new WTR_Text( array(
		'id'			=> 'wtr_TranslateHomeCommentsAreClosed',
		'class'			=> '',
		'title'			=> __( 'Comments are closed', 'wtr_framework' ),
		'desc' 			=> '',
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateHomeCommentsAreClosed' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateHomeCommentsmMderation = new WTR_Text( array(
		'id'			=> 'wtr_TranslateHomeCommentsmMderation',
		'class'			=> '',
		'title'			=> __( 'Comments moderation text', 'wtr_framework' ),
		'desc' 			=> '',
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateHomeCommentsmMderation' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateHomePasswordText = new WTR_Text( array(
		'id'			=> 'wtr_TranslateHomePasswordText',
		'class'			=> '',
		'title'			=> __( 'Password text', 'wtr_framework' ),
		'desc' 			=> '',
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateHomePasswordText' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateHomePasswordlabelSubmit = new WTR_Text( array(
		'id'			=> 'wtr_TranslateHomePasswordlabelSubmit',
		'class'			=> '',
		'title'			=> __( 'Password label Submit', 'wtr_framework' ),
		'desc' 			=> '',
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateHomePasswordlabelSubmit' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateHomePasswordText2 = new WTR_Text( array(
		'id'			=> 'wtr_TranslateHomePasswordText2',
		'class'			=> '',
		'title'			=> __( 'Password text 2', 'wtr_framework' ),
		'desc' 			=> '',
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateHomePasswordText2' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateHomePagination = new WTR_Text( array(
		'id'			=> 'wtr_TranslateHomePagination',
		'class'			=> '',
		'title'			=> __( 'Pagination in title', 'wtr_framework' ),
		'desc' 			=> '',
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateHomePagination' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateHomeLoader = new WTR_Text( array(
		'id'			=> 'wtr_TranslateHomeLoader',
		'class'			=> '',
		'title'			=> __( 'Loader', 'wtr_framework' ),
		'desc' 			=> '',
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateHomeLoader' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateHomePayPal = new WTR_Text( array(
		'id'			=> 'wtr_TranslateHomePayPal',
		'class'			=> '',
		'title'			=> __( 'Buy', 'wtr_framework' ),
		'desc' 			=> __( 'PayPal', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateHomePayPal' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateHomeMobileMenu = new WTR_Text( array(
		'id'			=> 'wtr_TranslateHomeMobileMenu',
		'class'			=> '',
		'title'			=> __( 'Mobile menu tittle', 'wtr_framework' ),
		'desc' 			=> '',
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateHomeMobileMenu' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

//Blog wtr_TranslateBlogSection
$wtr_TranslateBlogContinueReading = new WTR_Text( array(
		'id'			=> 'wtr_TranslateBlogContinueReading',
		'class'			=> '',
		'title'			=> __( 'Continue reading', 'wtr_framework' ),
		'desc' 			=> '',
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateBlogContinueReading' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateBlogByAuthor = new WTR_Text( array(
		'id'			=> 'wtr_TranslateBlogByAuthor',
		'class'			=> '',
		'title'			=> __( 'By (author)', 'wtr_framework' ),
		'desc'			=> '',
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateBlogByAuthor' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateBlogPostByAuthor = new WTR_Text( array(
		'id'			=> 'wtr_TranslateBlogPostByAuthor',
		'class'			=> '',
		'title'			=> __( 'By (author)', 'wtr_framework' ),
		'desc'			=> __( 'Single post', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateBlogPostByAuthor' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateBlogPostAuthor = new WTR_Text( array(
		'id'			=> 'wtr_TranslateBlogPostAuthor',
		'class'			=> '',
		'title'			=> __( 'Author', 'wtr_framework' ),
		'desc'			=> __( 'Single post', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateBlogPostAuthor' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateBlogPostTags = new WTR_Text( array(
		'id'			=> 'wtr_TranslateBlogPostTags',
		'class'			=> '',
		'title'			=> __( 'Tags for this post', 'wtr_framework' ),
		'desc'			=> __( 'Single post', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateBlogPostTags' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateBlogRelatedPosts = new WTR_Text( array(
		'id'			=> 'wtr_TranslateBlogRelatedPosts',
		'class'			=> '',
		'title'			=> __( 'Related posts', 'wtr_framework' ),
		'desc'			=> __( 'Single post', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateBlogRelatedPosts' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateBlogRelatedPostsAuthor = new WTR_Text( array(
		'id'			=> 'wtr_TranslateBlogRelatedPostsAuthor',
		'class'			=> '',
		'title'			=> __( 'Author', 'wtr_framework' ),
		'desc'			=> __( 'Related Posts', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateBlogRelatedPostsAuthor' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateBlogStickyPosts = new WTR_Text( array(
		'id'			=> 'wtr_TranslateBlogStickyPosts',
		'class'			=> '',
		'title'			=> __( 'Sticky posts', 'wtr_framework' ),
		'desc'			=> '',
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateBlogStickyPosts' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateBlogCrumbsArchiveForCategory = new WTR_Text( array(
		'id'			=> 'wtr_TranslateBlogCrumbsArchiveForCategory',
		'class'			=> '',
		'title'			=> __( 'Archive for category', 'wtr_framework' ),
		'desc' 			=> '',
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateBlogCrumbsArchiveForCategory' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateBlogCrumbsTagArchivefor = new WTR_Text( array(
		'id'			=> 'wtr_TranslateBlogCrumbsTagArchivefor',
		'class'			=> '',
		'title'			=> __( 'Tag Archive for', 'wtr_framework' ),
		'desc' 			=> '',
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateBlogCrumbsTagArchivefor' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateBlogCrumbsAuthorArchive = new WTR_Text( array(
		'id'			=> 'wtr_TranslateBlogCrumbsAuthorArchive',
		'class'			=> '',
		'title'			=> __( 'Author archive', 'wtr_framework' ),
		'desc' 			=> '',
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateBlogCrumbsAuthorArchive' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateBlogCrumbsArchiveForDate = new WTR_Text( array(
		'id'			=> 'wtr_TranslateBlogCrumbsArchiveForDate',
		'class'			=> '',
		'title'			=> __( 'Archive for date', 'wtr_framework' ),
		'desc' 			=> '',
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateBlogCrumbsArchiveForDate' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateBlogCrumbsArchiveForMonth = new WTR_Text( array(
		'id'			=> 'wtr_TranslateBlogCrumbsArchiveForMonth',
		'class'			=> '',
		'title'			=> __( 'Archive for month', 'wtr_framework' ),
		'desc' 			=> '',
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateBlogCrumbsArchiveForMonth' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateBlogCrumbsArchiveForYear = new WTR_Text( array(
		'id'			=> 'wtr_TranslateBlogCrumbsArchiveForYear',
		'class'			=> '',
		'title'			=> __( 'Archive for year', 'wtr_framework' ),
		'desc' 			=> '',
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateBlogCrumbsArchiveForYear' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

//Classes wtr_TranslateClassesSection
$wtr_TranslateClassesMinutes = new WTR_Text( array(
		'id'			=> 'wtr_TranslateClassesMinutes',
		'class'			=> '',
		'title'			=> __( 'Minutes', 'wtr_framework' ),
		'desc' 			=> '',
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateClassesMinutes' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);


$wtr_TranslateClassesKcal = new WTR_Text( array(
		'id'			=> 'wtr_TranslateClassesKcal',
		'class'			=> '',
		'title'			=> __( 'Kcal burned', 'wtr_framework' ),
		'desc' 			=> '',
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateClassesKcal' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateClassesLevel= new WTR_Text( array(
		'id'			=> 'wtr_TranslateClassesLevel',
		'class'			=> '',
		'title'			=> __( 'Level', 'wtr_framework' ),
		'desc' 			=> '',
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateClassesLevel' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);
$wtr_TranslateClassesLevel_1 = new WTR_Text( array(
		'id'			=> 'wtr_TranslateClassesLevel_1',
		'class'			=> '',
		'title'			=> __( 'Description of difficulty (level 1)', 'wtr_framework' ),
		'desc' 			=> '',
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateClassesLevel_1' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateClassesLevel_2 = new WTR_Text( array(
		'id'			=> 'wtr_TranslateClassesLevel_2',
		'class'			=> '',
		'title'			=> __( 'Description of difficulty (level 2)', 'wtr_framework' ),
		'desc' 			=> '',
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateClassesLevel_2' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateClassesLevel_3 = new WTR_Text( array(
		'id'			=> 'wtr_TranslateClassesLevel_3',
		'class'			=> '',
		'title'			=> __( 'Description of difficulty (level 3)', 'wtr_framework' ),
		'desc' 			=> '',
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateClassesLevel_3' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateClassesLevel_4 = new WTR_Text( array(
		'id'			=> 'wtr_TranslateClassesLevel_4',
		'class'			=> '',
		'title'			=> __( 'Description of difficulty (level 4)', 'wtr_framework' ),
		'desc' 			=> '',
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateClassesLevel_4' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateClassesLevel_5 = new WTR_Text( array(
		'id'			=> 'wtr_TranslateClassesLevel_5',
		'class'			=> '',
		'title'			=> __( 'Description of difficulty (level 5)', 'wtr_framework' ),
		'desc' 			=> '',
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateClassesLevel_5' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateClassesNumber = new WTR_Text( array(
		'id'			=> 'wtr_TranslateClassesNumber',
		'class'			=> '',
		'title'			=> __( 'Limit of participants', 'wtr_framework' ),
		'desc' 			=> '',
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateClassesNumber' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateClassesTrainer = new WTR_Text( array(
		'id'			=> 'wtr_TranslateClassesTrainer',
		'class'			=> '',
		'title'			=> __( 'Trainers', 'wtr_framework' ),
		'desc' 			=> '',
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateClassesTrainer' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);


$wtr_TranslateClassesTrainerReadMore = new WTR_Text( array(
		'id'			=> 'wtr_TranslateClassesTrainerReadMore',
		'class'			=> '',
		'title'			=> __( 'Trainer read more', 'wtr_framework' ),
		'desc' 			=> '',
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateClassesTrainerReadMore' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

//Contact Form: wtr_TranslateCommentFormSection
$wtr_TranslateCommentFormName = new WTR_Text( array(
		'id'			=> 'wtr_TranslateCommentFormName',
		'class'			=> '',
		'title'			=> __( 'Name', 'wtr_framework' ),
		'desc' 			=> '',
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateCommentFormName' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateCommentFormEmail = new WTR_Text( array(
		'id'			=> 'wtr_TranslateCommentFormEmail',
		'class'			=> '',
		'title'			=> __( 'E-mail', 'wtr_framework' ),
		'desc' 			=> '',
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateCommentFormEmail' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateCommentFormUrl = new WTR_Text( array(
		'id'			=> 'wtr_TranslateCommentFormUrl',
		'class'			=> '',
		'title'			=> __( 'Url', 'wtr_framework' ),
		'desc' 			=> '',
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateCommentFormUrl' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateCommentFormtitleReply = new WTR_Text( array(
		'id'			=> 'wtr_TranslateCommentFormtitleReply',
		'class'			=> '',
		'title'			=> __( 'Title reply', 'wtr_framework' ),
		'desc' 			=> __( ' The title of comment form (when not replying to a comment, see <a title="Function Reference/comment form title" href="http://codex.wordpress.org/Function_Reference/comment_form_title">comment_form_title</a> )', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateCommentFormtitleReply' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateCommentFormtitleReplyTo = new WTR_Text( array(
		'id'			=> 'wtr_TranslateCommentFormtitleReplyTo',
		'class'			=> '',
		'title'			=> __( 'Title reply to', 'wtr_framework' ),
		'desc' 			=> __( 'The title of comment form (when replying to a comment, see <a title="Function Reference/comment form title" href="http://codex.wordpress.org/Function_Reference/comment_form_title">comment_form_title</a>)', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateCommentFormtitleReplyTo' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateCommentFormcancelReplyLink = new WTR_Text( array(
		'id'			=> 'wtr_TranslateCommentFormcancelReplyLink',
		'class'			=> '',
		'title'			=> __( 'Reply link', 'wtr_framework' ),
		'desc' 			=> __('Link label to cancel reply. ', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateCommentFormcancelReplyLink' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateCommentFormlabelSubmit = new WTR_Text( array(
		'id'			=> 'wtr_TranslateCommentFormlabelSubmit',
		'class'			=> '',
		'title'			=> __( 'Label submit', 'wtr_framework' ),
		'desc' 			=> __( 'The name of submit button. ', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateCommentFormlabelSubmit' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateCommentFormComment = new WTR_Text( array(
		'id'			=> 'wtr_TranslateCommentFormComment',
		'class'			=> '',
		'title'			=> __( 'Comment', 'wtr_framework' ),
		'desc' 			=> '',
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateCommentFormComment' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

//Event wtr_TranslateEventSection
$wtr_TranslateEventSelectEvent = new WTR_Text( array(
		'id'			=> 'wtr_TranslateEventSelectEvent',
		'class'			=> '',
		'title'			=> __( 'Select event', 'wtr_framework' ),
		'desc' 			=> '',
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateEventSelectEvent' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateEventCurrent = new WTR_Text( array(
		'id'			=> 'wtr_TranslateEventCurrent',
		'class'			=> '',
		'title'			=> __( 'Current', 'wtr_framework' ),
		'desc' 			=> '',
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateEventCurrent' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateEventOutdated = new WTR_Text( array(
		'id'			=> 'wtr_TranslateEventOutdated',
		'class'			=> '',
		'title'			=> __( 'Outdated', 'wtr_framework' ),
		'desc' 			=> '',
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateEventOutdated' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateEventNoItems = new WTR_Text( array(
		'id'			=> 'wtr_TranslateEventNoItems',
		'class'			=> '',
		'title'			=> __( 'No items', 'wtr_framework' ),
		'desc' 			=> '',
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateEventNoItems' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateEventSingleCategory = new WTR_Text( array(
		'id'			=> 'wtr_TranslateEventSingleCategory',
		'class'			=> '',
		'title'			=> __( 'Event category', 'wtr_framework' ),
		'desc' 			=> __( 'Single event', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateEventSingleCategory' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateEventSingleVenue = new WTR_Text( array(
		'id'			=> 'wtr_TranslateEventSingleVenue',
		'class'			=> '',
		'title'			=> __( 'Venue', 'wtr_framework' ),
		'desc' 			=> __( 'Single event', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateEventSingleVenue' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateEventSingleVenuePhone = new WTR_Text( array(
		'id'			=> 'wtr_TranslateEventSingleVenuePhone',
		'class'			=> '',
		'title'			=> __( 'Venue phone', 'wtr_framework' ),
		'desc' 			=> __( 'Single event', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateEventSingleVenuePhone' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateEventSingleOrgaznizer = new WTR_Text( array(
		'id'			=> 'wtr_TranslateEventSingleOrgaznizer',
		'class'			=> '',
		'title'			=> __( 'Orgaznizer', 'wtr_framework' ),
		'desc' 			=> __( 'Single event', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateEventSingleOrgaznizer' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateEventSingleOrgaznizerPhone = new WTR_Text( array(
		'id'			=> 'wtr_TranslateEventSingleOrgaznizerPhone',
		'class'			=> '',
		'title'			=> __( 'Orgaznizer phone', 'wtr_framework' ),
		'desc' 			=> __( 'Single event', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateEventSingleOrgaznizerPhone' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateEventSingleDetails = new WTR_Text( array(
		'id'			=> 'wtr_TranslateEventSingleDetails',
		'class'			=> '',
		'title'			=> __( 'Details', 'wtr_framework' ),
		'desc' 			=> __( 'Single event', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateEventSingleDetails' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateEventSingleSignUps = new WTR_Text( array(
		'id'			=> 'wtr_TranslateEventSingleSignUps',
		'class'			=> '',
		'title'			=> __( 'Sign ups', 'wtr_framework' ),
		'desc' 			=> __( 'Single event', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateEventSingleSignUps' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateEventSingleLimits = new WTR_Text( array(
		'id'			=> 'wtr_TranslateEventSingleLimits',
		'class'			=> '',
		'title'			=> __( 'Limits', 'wtr_framework' ),
		'desc' 			=> __( 'Single event', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateEventSingleLimits' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateEventSingleParticipants = new WTR_Text( array(
		'id'			=> 'wtr_TranslateEventSingleParticipants',
		'class'			=> '',
		'title'			=> __( 'Participants', 'wtr_framework' ),
		'desc' 			=> __( 'Single event', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateEventSingleParticipants' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

//404: wtr_Translate404Section
$wtr_Translate404After404 = new WTR_Text( array(
		'id'			=> 'wtr_Translate404After404',
		'class'			=> '',
		'title'			=> __( 'Text after 404', 'wtr_framework' ),
		'desc'			=> '',
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_Translate404After404' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);
$wtr_Translate404TextBelow404 = new WTR_Text( array(
		'id'			=> 'wtr_Translate404TextBelow404',
		'class'			=> '',
		'title'			=> __( 'Text below 404 ', 'wtr_framework' ),
		'desc'			=> '',
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_Translate404TextBelow404' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);
$wtr_Translate404ButtonLabel = new WTR_Text( array(
		'id'			=> 'wtr_Translate404ButtonLabel',
		'class'			=> '',
		'title'			=> __( 'Button label ', 'wtr_framework' ),
		'desc'			=> '',
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_Translate404ButtonLabel' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_Translate404Section_1_title = new WTR_Text( array(
		'id'			=> 'wtr_Translate404Section_1_title',
		'class'			=> '',
		'title'			=> __( 'Section I title ', 'wtr_framework' ),
		'desc'			=> '',
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_Translate404Section_1_title' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_Translate404Section_2_title = new WTR_Text( array(
		'id'			=> 'wtr_Translate404Section_2_title',
		'class'			=> '',
		'title'			=> __( 'Section II title ', 'wtr_framework' ),
		'desc'			=> '',
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_Translate404Section_2_title' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_Translate404Section_2_desc = new WTR_Text( array(
		'id'			=> 'wtr_Translate404Section_2_desc',
		'class'			=> '',
		'title'			=> __( 'Section II description', 'wtr_framework' ),
		'desc'			=> '',
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_Translate404Section_2_desc' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_Translate404Section_3_title = new WTR_Text( array(
		'id'			=> 'wtr_Translate404Section_3_title',
		'class'			=> '',
		'title'			=> __( 'Section III title ', 'wtr_framework' ),
		'desc'			=> '',
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_Translate404Section_3_title' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_Translate404Section_3_desc = new WTR_Text( array(
		'id'			=> 'wtr_Translate404Section_3_desc',
		'class'			=> '',
		'title'			=> __( 'Section II description', 'wtr_framework' ),
		'desc'			=> '',
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_Translate404Section_3_desc' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

//Search form: wtr_TranslateSearchFormSection
$wtr_TranslateSearchFormNewSearch = new WTR_Text( array(
		'id'			=> 'wtr_TranslateSearchFormNewSearch',
		'class'			=> '',
		'title'			=> __( 'New search title', 'wtr_framework' ),
		'desc' 			=> '',
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateSearchFormNewSearch' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateSearchNaviFormNewSearch = new WTR_Text( array(
		'id'			=> 'wtr_TranslateSearchNaviFormNewSearch',
		'class'			=> '',
		'title'			=> __( 'New search title', 'wtr_framework' ),
		'desc' 			=> __( 'Search inside main navigation', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateSearchNaviFormNewSearch' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);
$wtr_TranslateSearchNaviFormNewSearchLabel  = new WTR_Text( array(
		'id'			=> 'wtr_TranslateSearchNaviFormNewSearchLabel',
		'class'			=> '',
		'title'			=> __( 'Search button label', 'wtr_framework' ),
		'desc' 			=> __( 'Search inside main navigation', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateSearchNaviFormNewSearchLabel' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);


$wtr_TranslateSearchFormSearchResultFor  = new WTR_Text( array(
		'id'			=> 'wtr_TranslateSearchFormSearchResultFor',
		'class'			=> '',
		'title'			=> __( 'Search result for', 'wtr_framework' ),
		'desc' 			=> __( 'Section results', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateSearchFormSearchResultFor' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateSearchFormSectionNoresultsTitle = new WTR_Text( array(
		'id'			=> 'wtr_TranslateSearchFormSectionNoresultsTitle',
		'class'			=> '',
		'title'			=> __( 'Title', 'wtr_framework' ),
		'desc' 			=> __( 'Section No results', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateSearchFormSectionNoresultsTitle' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateSearchFormCrumbsSearchResults = new WTR_Text( array(
		'id'			=> 'wtr_TranslateSearchFormCrumbsSearchResults',
		'class'			=> '',
		'title'			=> __( 'Search results', 'wtr_framework' ),
		'desc' 			=> __( 'Breadcrumbs', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateSearchFormCrumbsSearchResults' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateSearchFormSearchComment = new WTR_Text( array(
		'id'			=> 'wtr_TranslateSearchFormSearchComment',
		'class'			=> '',
		'title'			=> __( 'Comments', 'wtr_framework' ),
		'desc' 			=> __( 'Section results', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateSearchFormSearchComment' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateSearchFormSearchByAuthor = new WTR_Text( array(
		'id'			=> 'wtr_TranslateSearchFormSearchByAuthor',
		'class'			=> '',
		'title'			=> __( 'By (author)', 'wtr_framework' ),
		'desc' 			=> __( 'Section results', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateSearchFormSearchByAuthor' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateSearchFormSearchPostType = new WTR_Text( array(
		'id'			=> 'wtr_TranslateSearchFormSearchPostType',
		'class'			=> '',
		'title'			=> __( 'Type', 'wtr_framework' ),
		'desc' 			=> __( 'Section results', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateSearchFormSearchPostType' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateSearchFormSearchPostType_page = new WTR_Text( array(
		'id'			=> 'wtr_TranslateSearchFormSearchPostType_page',
		'class'			=> '',
		'title'			=> __( 'Post type: page', 'wtr_framework' ),
		'desc' 			=> __( 'Section results', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateSearchFormSearchPostType_page' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateSearchFormSearchPostType_post = new WTR_Text( array(
		'id'			=> 'wtr_TranslateSearchFormSearchPostType_post',
		'class'			=> '',
		'title'			=> __( 'Post type: post', 'wtr_framework' ),
		'desc' 			=> __( 'Section results', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateSearchFormSearchPostType_post' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateSearchFormSearchPostType_rooms = new WTR_Text( array(
		'id'			=> 'wtr_TranslateSearchFormSearchPostType_rooms',
		'class'			=> '',
		'title'			=> __( 'Post type: rooms', 'wtr_framework' ),
		'desc' 			=> __( 'Section results', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateSearchFormSearchPostType_rooms' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateSearchFormSearchPostType_classes = new WTR_Text( array(
		'id'			=> 'wtr_TranslateSearchFormSearchPostType_classes',
		'class'			=> '',
		'title'			=> __( 'Post type: classes', 'wtr_framework' ),
		'desc' 			=> __( 'Section results', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateSearchFormSearchPostType_classes' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateSearchFormSearchPostType_trainer = new WTR_Text( array(
		'id'			=> 'wtr_TranslateSearchFormSearchPostType_trainer',
		'class'			=> '',
		'title'			=> __( 'Post type: trainer', 'wtr_framework' ),
		'desc' 			=> __( 'Section results', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateSearchFormSearchPostType_trainer' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateSearchFormSearchPostType_events = new WTR_Text( array(
		'id'			=> 'wtr_TranslateSearchFormSearchPostType_events',
		'class'			=> '',
		'title'			=> __( 'Post type: events', 'wtr_framework' ),
		'desc' 			=> __( 'Section results', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateSearchFormSearchPostType_events' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);


//Shortcode: wtr_TranslateShortcodeSection
$wtr_TranslateBlogSHTBy = new WTR_Text( array(
		'id'			=> 'wtr_TranslateBlogSHTBy',
		'class'			=> '',
		'title'			=> __( 'By', 'wtr_framework' ),
		'desc' 			=> __( 'Shortcode News', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateBlogSHTBy' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateBlogSHTAuthor = new WTR_Text( array(
		'id'			=> 'wtr_TranslateBlogSHTAuthor',
		'class'			=> '',
		'title'			=> __( 'Author', 'wtr_framework' ),
		'desc' 			=> __( 'Shortcode News', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateBlogSHTAuthor' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateBlogSHTReadMore = new WTR_Text( array(
		'id'			=> 'wtr_TranslateBlogSHTReadMore',
		'class'			=> '',
		'title'			=> __( 'Read more', 'wtr_framework' ),
		'desc' 			=> __( 'Shortcode News', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateBlogSHTReadMore' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateBlogSHTComments = new WTR_Text( array(
		'id'			=> 'wtr_TranslateBlogSHTComments',
		'class'			=> '',
		'title'			=> __( 'Comments', 'wtr_framework' ),
		'desc' 			=> __( 'Shortcode News', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateBlogSHTComments' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateClassesSHTKcal = new WTR_Text( array(
		'id'			=> 'wtr_TranslateClassesSHTKcal',
		'class'			=> '',
		'title'			=> __( 'Kcal burned', 'wtr_framework' ),
		'desc' 			=> __( 'Shortcode Classes', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateClassesSHTKcal' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateClassesSHTMinutes = new WTR_Text( array(
		'id'			=> 'wtr_TranslateClassesSHTMinutes',
		'class'			=> '',
		'title'			=> __( 'Minutes', 'wtr_framework' ),
		'desc' 			=> __( 'Shortcode Classes', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateClassesSHTMinutes' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateCountdownSHTYears = new WTR_Text( array(
		'id'			=> 'wtr_TranslateCountdownSHTYears',
		'class'			=> '',
		'title'			=> __( 'Years', 'wtr_framework' ),
		'desc' 			=> __( 'Shortcode Countdown', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateCountdownSHTYears' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateCountdownSHTMonths = new WTR_Text( array(
		'id'			=> 'wtr_TranslateCountdownSHTMonths',
		'class'			=> '',
		'title'			=> __( 'Months', 'wtr_framework' ),
		'desc' 			=> __( 'Shortcode Countdown', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateCountdownSHTMonths' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateCountdownSHTWeeks = new WTR_Text( array(
		'id'			=> 'wtr_TranslateCountdownSHTWeeks',
		'class'			=> '',
		'title'			=> __( 'Weeks', 'wtr_framework' ),
		'desc' 			=> __( 'Shortcode Countdown', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateCountdownSHTWeeks' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateCountdownSHTDays = new WTR_Text( array(
		'id'			=> 'wtr_TranslateCountdownSHTDays',
		'class'			=> '',
		'title'			=> __( 'Days', 'wtr_framework' ),
		'desc' 			=> __( 'Shortcode Countdown', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateCountdownSHTDays' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateCountdownSHTHours = new WTR_Text( array(
		'id'			=> 'wtr_TranslateCountdownSHTHours',
		'class'			=> '',
		'title'			=> __( 'Hours', 'wtr_framework' ),
		'desc' 			=> __( 'Shortcode Countdown', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateCountdownSHTHours' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateCountdownSHTMinutes = new WTR_Text( array(
		'id'			=> 'wtr_TranslateCountdownSHTMinutes',
		'class'			=> '',
		'title'			=> __( 'Minutes', 'wtr_framework' ),
		'desc' 			=> __( 'Shortcode Countdown', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateCountdownSHTMinutes' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateCountdownSHTSeconds = new WTR_Text( array(
		'id'			=> 'wtr_TranslateCountdownSHTSeconds',
		'class'			=> '',
		'title'			=> __( 'Seconds', 'wtr_framework' ),
		'desc' 			=> __( 'Shortcode Countdown', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateCountdownSHTSeconds' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateClassesScheduleSHTMonday = new WTR_Text( array(
		'id'			=> 'wtr_TranslateClassesScheduleSHTMonday',
		'class'			=> '',
		'title'			=> __( 'Monday', 'wtr_framework' ),
		'desc' 			=> __( 'Shortcode Classes schedule', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateClassesScheduleSHTMonday' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateClassesScheduleSHTTuesday = new WTR_Text( array(
		'id'			=> 'wtr_TranslateClassesScheduleSHTTuesday',
		'class'			=> '',
		'title'			=> __( 'Tuesday', 'wtr_framework' ),
		'desc' 			=> __( 'Shortcode Classes schedule', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateClassesScheduleSHTTuesday' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateClassesScheduleSHTWednesday = new WTR_Text( array(
		'id'			=> 'wtr_TranslateClassesScheduleSHTWednesday',
		'class'			=> '',
		'title'			=> __( 'Wednesday', 'wtr_framework' ),
		'desc' 			=> __( 'Shortcode Classes schedule', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateClassesScheduleSHTWednesday' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateClassesScheduleSHTThursday = new WTR_Text( array(
		'id'			=> 'wtr_TranslateClassesScheduleSHTThursday',
		'class'			=> '',
		'title'			=> __( 'Thursday', 'wtr_framework' ),
		'desc' 			=> __( 'Shortcode Classes schedule', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateClassesScheduleSHTThursday' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateClassesScheduleSHTFriday = new WTR_Text( array(
		'id'			=> 'wtr_TranslateClassesScheduleSHTFriday',
		'class'			=> '',
		'title'			=> __( 'Friday', 'wtr_framework' ),
		'desc' 			=> __( 'Shortcode Classes schedule', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateClassesScheduleSHTFriday' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateClassesScheduleSHTSaturday = new WTR_Text( array(
		'id'			=> 'wtr_TranslateClassesScheduleSHTSaturday',
		'class'			=> '',
		'title'			=> __( 'Saturday', 'wtr_framework' ),
		'desc' 			=> __( 'Shortcode Classes schedule', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateClassesScheduleSHTSaturday' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateClassesScheduleSHTSunday = new WTR_Text( array(
		'id'			=> 'wtr_TranslateClassesScheduleSHTSunday',
		'class'			=> '',
		'title'			=> __( 'Sunday', 'wtr_framework' ),
		'desc' 			=> __( 'Shortcode Classes schedule', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateClassesScheduleSHTSunday' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateClassesScheduleSHTTimeDay = new WTR_Text( array(
		'id'			=> 'wtr_TranslateClassesScheduleSHTTimeDay',
		'class'			=> '',
		'title'			=> __( 'Time / Day', 'wtr_framework' ),
		'desc' 			=> __( 'Shortcode Classes schedule', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateClassesScheduleSHTTimeDay' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateClassesScheduleSHTSelectClasse = new WTR_Text( array(
		'id'			=> 'wtr_TranslateClassesScheduleSHTSelectClasse',
		'class'			=> '',
		'title'			=> __( 'Select classes', 'wtr_framework' ),
		'desc' 			=> __( 'Shortcode Classes schedule', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateClassesScheduleSHTSelectClasse' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateClassesScheduleSHTShowAll = new WTR_Text( array(
		'id'			=> 'wtr_TranslateClassesScheduleSHTShowAll',
		'class'			=> '',
		'title'			=> __( 'Show all', 'wtr_framework' ),
		'desc' 			=> __( 'Shortcode Classes schedule', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateClassesScheduleSHTShowAll' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateClassesScheduleSHTSorry = new WTR_Text( array(
		'id'			=> 'wtr_TranslateClassesScheduleSHTSorry',
		'class'			=> '',
		'title'			=> __( 'No results in selected week', 'wtr_framework' ),
		'desc' 			=> __( 'Shortcode Classes schedule', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateClassesScheduleSHTSorry' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateClassesScheduleSHTAll = new WTR_Text( array(
		'id'			=> 'wtr_TranslateClassesScheduleSHTAll',
		'class'			=> '',
		'title'			=> __( 'All', 'wtr_framework' ),
		'desc' 			=> __( 'Shortcode Classes schedule', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateClassesScheduleSHTAll' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateClassesScheduleSHTCategories = new WTR_Text( array(
		'id'			=> 'wtr_TranslateClassesScheduleSHTCategories',
		'class'			=> '',
		'title'			=> __( 'Categories', 'wtr_framework' ),
		'desc' 			=> __( 'Shortcode Classes schedule', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateClassesScheduleSHTCategories' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateClassesScheduleSHTClasses = new WTR_Text( array(
		'id'			=> 'wtr_TranslateClassesScheduleSHTClasses',
		'class'			=> '',
		'title'			=> __( 'Classes', 'wtr_framework' ),
		'desc' 			=> __( 'Shortcode Classes schedule', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateClassesScheduleSHTClasses' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateClassesScheduleSHTCategory = new WTR_Text( array(
		'id'			=> 'wtr_TranslateClassesScheduleSHTCategory',
		'class'			=> '',
		'title'			=> __( 'Category', 'wtr_framework' ),
		'desc' 			=> __( 'Shortcode Classes schedule', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateClassesScheduleSHTCategory' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateClassesScheduleSHTClass = new WTR_Text( array(
		'id'			=> 'wtr_TranslateClassesScheduleSHTClass',
		'class'			=> '',
		'title'			=> __( 'Class', 'wtr_framework' ),
		'desc' 			=> __( 'Shortcode Classes schedule', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateClassesScheduleSHTClass' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateEventSHTReadMore = new WTR_Text( array(
		'id'			=> 'wtr_TranslateEventSHTReadMore',
		'class'			=> '',
		'title'			=> __( 'Read more', 'wtr_framework' ),
		'desc'			=> __( 'Shortcode Events', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateEventSHTReadMore' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateClassesSHTPassStatus0  = new WTR_Text( array(
		'id'			=> 'wtr_TranslateClassesSHTPassStatus0',
		'class'			=> '',
		'title'			=> __( 'Promotion', 'wtr_framework' ),
		'desc'			=> __( 'Shortcode Pass', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateClassesSHTPassStatus0' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateClassesSHTPassStatus1  = new WTR_Text( array(
		'id'			=> 'wtr_TranslateClassesSHTPassStatus1',
		'class'			=> '',
		'title'			=> __( 'New', 'wtr_framework' ),
		'desc'			=> __( 'Shortcode Pass', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateClassesSHTPassStatus1' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateClassesSHTPassStatus2 = new WTR_Text( array(
		'id'			=> 'wtr_TranslateClassesSHTPassStatus2',
		'class'			=> '',
		'title'			=> __( 'Featured', 'wtr_framework' ),
		'desc'			=> __( 'Shortcode Pass', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateClassesSHTPassStatus2' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateClassesSHTPassPrice  = new WTR_Text( array(
		'id'			=> 'wtr_TranslateClassesSHTPassPrice',
		'class'			=> '',
		'title'			=> __( 'Price', 'wtr_framework' ),
		'desc'			=> __( 'Shortcode Pass', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateClassesSHTPassPrice' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateClassesSHTSBSStep  = new WTR_Text( array(
		'id'			=> 'wtr_TranslateClassesSHTSBSStep',
		'class'			=> '',
		'title'			=> __( 'Step', 'wtr_framework' ),
		'desc'			=> __( 'Shortcode Step by step', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateClassesSHTSBSStep' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateDailyScheduleSHTText  = new WTR_Text( array(
		'id'			=> 'wtr_TranslateDailyScheduleSHTText',
		'class'			=> '',
		'title'			=> __( 'Gym name', 'wtr_framework' ),
		'desc'			=> __( 'Shortcode Daily Schedule', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateDailyScheduleSHTText' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_TranslateDailyScheduleSHTText2  = new WTR_Text( array(
		'id'			=> 'wtr_TranslateDailyScheduleSHTText2',
		'class'			=> '',
		'title'			=> __( 'Daily Schedule', 'wtr_framework' ),
		'desc'			=> __( 'Shortcode Daily Schedule', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateDailyScheduleSHTText2' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);


//Widgets: wtr_TranslateWidgetsSection
$wtr_TranslateWidgetsSectionTrainerMeet = new WTR_Text( array(
		'id'			=> 'wtr_TranslateWidgetsSectionTrainerMeet',
		'class'			=> '',
		'title'			=> __( 'Meet', 'wtr_framework' ),
		'desc'			=> __( 'Symetrio trainers ', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => $wtr_translate[ 'wtr_TranslateWidgetsSectionTrainerMeet' ],
		'info'			=> '',
		'allow'			=> 'all',
	)
);


//PayPal: wtr_PayPalSection
$wtr_PayPalGlobalStatus = new WTR_Radio( array(
		'id'			=> 'wtr_PayPalGlobalStatus',
		'class'			=> '',
		'title'			=> __( 'Global settings', 'wtr_framework' ),
		'desc'			=> '',
		'value'			=> '',
		'default_value' => '1',
		'info'			=> '',
		'allow'			=> 'int',
		'option' 	=> array( '1' => 'On' , '0' => 'Off' ),
	)
);

$wtr_PayPalShowInClass = new WTR_Radio( array(
		'id'			=> 'wtr_PayPalShowInClass',
		'class'			=> '',
		'title'			=> __( 'Show “pay” button in class details', 'wtr_framework' ),
		'desc'			=> '',
		'value'			=> '',
		'default_value' => '1',
		'info'			=> '',
		'allow'			=> 'int',
		'option' 	=> array( '1' => 'On' , '0' => 'Off' ),
	)
);

$wtr_PayPalShowInEvent = new WTR_Radio( array(
		'id'			=> 'wtr_PayPalShowInEvent',
		'class'			=> '',
		'title'			=> __( 'Show “pay” button in event details', 'wtr_framework' ),
		'desc'			=> '',
		'value'			=> '',
		'default_value' => '1',
		'info'			=> '',
		'allow'			=> 'int',
		'option' 	=> array( '1' => 'On' , '0' => 'Off' ),
	)
);

$wtr_PayPalShowInPass = new WTR_Radio( array(
		'id'			=> 'wtr_PayPalShowInPass',
		'class'			=> '',
		'title'			=> __( 'Show “pay” button in pass details', 'wtr_framework' ),
		'desc'			=> '',
		'value'			=> '',
		'default_value' => '1',
		'info'			=> '',
		'allow'			=> 'int',
		'option' 	=> array( '1' => 'On' , '0' => 'Off' ),
	)
);

$wtr_PayPalEmail = new WTR_Text( array(
		'id'			=> 'wtr_PayPalEmail',
		'class'			=> '',
		'title'			=> __( 'Your PayPal e-mail adress', 'wtr_framework' ),
		'desc'			=> '',
		'value'			=> '',
		'default_value' => '',
		'info'			=> '',
		'allow'			=> 'all',
	)
);

$wtr_PayPalCurrencyCode = new WTR_Select( array(
		'id'			=> 'wtr_PayPalCurrencyCode',
		'title'			=> __( 'Currency Code', 'wtr_framework' ),
		'desc'			=> __( "* This currency does not support decimals. Passing a decimal amount will result in an error.</br>** This currency is supported as a payment currency and a currency balance for in-country PayPal accounts only.", 'wtr_framework' ),
		'value'			=> '',
		'default_value' => 'USD',
		'info'			=> '',
		'allow'			=> 'all',
		'mod' 			=> '',
		'option'		=> $wtr_paypal_currency_code,
	)
);

//Import: wtr_DataBackupImportSection
$wtr_DataBackupExporSettings = new WTR_Update_Settings( array(
		'id'			=> 'wtr_DataBackupExporSettings',
		'class'			=> '',
		'title'			=> __( 'Export / import data from restore points', 'wtr_framework' ),
		'desc' 			=> __( 'This module has been prepared in order to backup configuration of your site. With this tool you will easily be able to prepare several versions of your website and in a very short time you will be able to choose the best one for you. We allow you to store in a one-time up to 5 restore points. All of the data that you can set with our panel can be exported.', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => '',
		'info'			=> __( 'This field contains configuration data for your site as a text. If you have several sites based on our theme and you want them to be setup identical you can use this option.', 'wtr_framework' ),
		'allow'			=> 'all',
	)
);


$wtr_OneClickThemeAlert = new WTR_Alert( array(
		'id'			=> 'wtr_ColorThemeAlert',
		'title'			=> __( 'One Click import allows you to fill your site with content based on demo site previously
								prepared by Wonster Team. It is an alternative for classic import via XML file.
								This process will recreate the demo site on your Wordpress 1:1
								(except files from the media library).</br></br>
								<span class="wtrAlertTextImportant">To run this process flawlessly, all your input data will be completely erased:</span></br></br>
								<ul class="alertUlImportOneClick">
									<li>Posts</li>
									<li>Pages</li>
									<li>Sidebars and widget position</li>
									<li>Files form medial library</li>
									<li>All data types added previously by theme: <b>' . WTR_THEME_NAME . '</b></li>
								 </ul></br>
								<b>Before starting the one click import it is recommended to backup your Wordpress</b>.', 'wtr_framework' ),
		'desc'			=> '',
		'value'			=> '',
		'default_value' => '1',
		'info'			=> '',
		'allow'			=> 'int',
		'mod' 			=> '',
		'class'			=> 'wtrAlertAlignLeft'
	)
);

$wtr_DataBackupOneClickImport = new WTR_Select( array(
		'id'			=> 'wtr_DataBackupOneClickImport',
		'title'			=> __( 'One click import', 'wtr_framework' ),
		'desc'			=> __( 'Use select to indicate the demo version you want to recreate on your website. To begin the process of full data import, please click on the <b>"Import Data"</b> button.', 'wtr_framework' ),
		'value'			=> '',
		'default_value' => '1',
		'info'			=> '',
		'allow'			=> 'all',
		'mod' 			=> 'one_click_import',
		'option'		=> $wtr_theme_skins_defaul,
	)
);

//---------------------------------------------------------
// Sections
//---------------------------------------------------------

//General
$wtr_GeneralGlobalSection = new WTR_Section( array(
		'id'		=> 'wtr_GeneralGlobalSection',
		'title'		=> __( 'Global', 'wtr_framework' ),
		'fields'	=>array(
			$wtr_GlobalSocialMetaTag,
			$wtr_GlobalBoxed,
			$wtr_GlobalAccelerateCusttomCss,
			$wtr_GlobalResponsive,
			$wtr_GlobalAvatarStatus,
			$wtr_GlobalPageLoaderAnimation,
			$wtr_GlobalSpaceBeforeHead,
			$wtr_GlobalSpaceBeforeBody,
			$wtr_Global404Page,
			$wtr_GlobalPageBackgroundImg,
			$wtr_GlobalPagineArrows
		),
	)
);

//Slugs
$wtr_GeneralSlugsSection = new WTR_Section( array(
		'id'		=> 'wtr_GeneralSlugsSection',
		'title'		=> __( 'Slugs', 'wtr_framework' ),
		'fields'	=> array(
			$wtr_SlugsRooms_Slug,
			$wtr_SlugsTrainers_Slug,
			$wtr_SlugsClasses_Slug,
			$wtr_SlugsClassesCategory_Slug,
			$wtr_SlugsEvents_Slug
		),
	)
);

$wtr_GeneralSeoSection = new WTR_Section( array(
		'id'		=> 'wtr_GeneralSeoSection',
		'title'		=> __( 'SEO', 'wtr_framework' ),
		'fields'	=> array(

			$wtr_SeoSwich,
			$wtr_SeoTitle,
			$wtr_SeoDescription,
			$wtr_SeoKeywords,
		),
	)
);

$wtr_GeneralAnaliticsSection = new WTR_Section( array(
		'id'		=> 'wtr_GeneralAnaliticsSection',
		'title'		=> __( 'Google Analytics', 'wtr_framework' ),
		'fields'	=> array(
			$wtr_AnaliticsModule,
			$wtr_AnaliticsCode,
		),
	)
);

$wtr_GeneralSidebarSection = new WTR_Section( array(
		'id'		=> 'wtr_GeneralSidebarSection',
		'title'		=> __( 'Sidebar', 'wtr_framework' ),
		'fields'	=> array(
			$wtr_SidebraManagement,
			$wtr_SidebarPositionOnSearch,
			$wtr_SidebarPickOnSearch,
			$wtr_SidebarPositionOnArchive,
			$wtr_SidebarPickOnArchive,
			$wtr_SidebarPositionOnBlog,
			$wtr_SidebarPickOnBlog,
			$wtr_SidebarPositionOnBlogPostPage,
			$wtr_SidebarPickOnBlogPostPage,
			$wtr_SidebarPositionOnSinglePage,
			$wtr_SidebarPickOnSinglePage,
			$wtr_SidebarPositionOnTrainer,
			$wtr_SidebarPickOnTrainer,
			$wtr_SidebarPositionOnRooms,
			$wtr_SidebarPickOnRooms,
			$wtr_SidebarPositionOnEvent,
			$wtr_SidebarPickOnEvent

		),
	)
);

$wtr_GeneralBlogSection = new WTR_Section( array(
		'id'		=> 'wtr_GeneralBlogSection',
		'title'		=> __( 'Blog', 'wtr_framework' ),
		'fields'	=> array(
			$wtr_BlogPostNumber,
			$wtr_BlogExcerptLength,
			$wtr_BlogStreamStyle,
			$wtr_BlogSingleStyle,
			$wtr_BlogDefaultBlogDateFormat,
			$wtr_BlogShowMeta,
			$wtr_BlogCategoriesInPost,
			$wtr_BlogShowTagsInBlogPost,
			$wtr_BlogSocialMediaToolbar,
			$wtr_BlogShowAuthorBio,
			$wtr_BlogRelatedPosts,
			$wtr_BlogRelatedPostsBy,
			$wtr_BlogRelatedPostsOrderBy,
			$wtr_BlogBreadCrumbsContainer,
			$wtr_BlogBreadCrumbs,
		),
	)
);

$wtr_GeneralEventSection = new WTR_Section( array(
		'id'		=> 'wtr_GeneralEventSection',
		'title'		=> __( 'Event', 'wtr_framework' ),
		'fields'	=> array(
			$wtr_EventPostNumber,
			$wtr_EventPostDateFormat,
			$wtr_EventPostReviewType,
		),
	)
);

//Social Media
$wtr_SocialMediaSocialMediaLinksSection = new WTR_Section( array(
		'id'		=> 'wtr_SocialMediaSocialMediaLinksSection',
		'title'		=> __( 'Social Medial links', 'wtr_framework' ),
		'fields'	=> array(
			$wtr_SocialMediaFacebook,
			$wtr_SocialMediaGooglePlus,
			$wtr_SocialMediaTwitter,
			$wtr_SocialMediaVimeo,
			$wtr_SocialMediaYouTube,
			$wtr_SocialMediaFlickr,
			$wtr_SocialMediaPinterest,
			$wtr_SocialMediaTumblr,
			$wtr_SocialMediaInstagram,
			$wtr_SocialMediaVKontakte,
			$wtr_SocialMediaLinkedIn
		),
	)
);

$wtr_SocialMediaSocialMediaSettingsSection = new WTR_Section( array(
		'id'		=> 'wtr_SocialMediaSocialMediaSettingsSection',
		'title'		=> __( 'Social Media settings', 'wtr_framework' ),
		'fields'	=> array(
			$wtr_SocialsMediaSettFacebook,
			$wtr_SocialsMediaSettGooglePlus,
			$wtr_SocialsMediaSettTwitter,
			$wtr_SocialsMediaSettPinterest,
			$wtr_SocialsMediaSettTumblr
		),
	)
);

//Layout
$wtr_LaloutHeaderSection = new WTR_Section( array(
		'id'		=> 'wtr_LaloutHeaderSection',
		'title'		=> __( 'Header', 'wtr_framework' ),
		'fields'	=> array(
			$wtr_HeaderSettings,
			$wtr_HeaderType,
			$wtr_HeaderNavigationType,
			$wtr_HeaderMobileNavigationType,
			$wtr_HeaderLogoPosition,
			$wtr_HeaderLogoImage,
			$wtr_HeaderLogoImageTransparent,
			$wtr_HeaderFavicon,
			$wtr_HeaderSectionOne,
			$wtr_HeaderSectionTwo,
			$wtr_HeaderSearchStatus,
			$wtr_HeaderBreadCrumbsContainer,
			$wtr_HeaderBreadCrumbs,
			$wtr_HeaderBreadCrumbsBackgroundImg,
		),
	)
);

$wtr_LaloutFooterSection = new WTR_Section( array(
		'id'		=> 'wtr_LaloutFooterSection',
		'title'		=> __( 'Footer', 'wtr_framework' ),
		'fields'	=> array(
			$wtr_FooterSettings,
			$wtr_FooterBackgroundImg,
			$wtr_FooterColumnNumber,
			$wtr_FooterCenterColumn,
			$wtr_FooterDivider,
			$wtr_FooterCoopyrightText,
			$wtr_FooterSectionOne,
			$wtr_FooterSectionTwo,
		),
	)
);

$wtr_CustomeCssSection = new WTR_Section( array(
		'id'		=> 'wtr_CustomeCssSection',
		'title'		=> __( 'Custom css', 'wtr_framework' ),
		'fields'	=> array(
			$wtr_CustomeCSS,
			$wtr_CustomeCssCode,
		 ),
	)
);

//Color
$wtr_ColorGeneralSection = new WTR_Section( array(
		'id'		=> 'wtr_ColorGeneralSection',
		'title'		=> __( 'General', 'wtr_framework' ),
		'fields'	=> array(
			$wtr_ColorThemeAlert,
			$wtr_ColorThemeSkin,
			$wtr_ColorThemeSkinOverwrite
		),
	)
);

//Fonts
$wtr_FontsFontSizeSection = new WTR_Section( array(
		'id'		=> 'wtr_FontsFontSizeSection',
		'title'		=> __( 'Font-size', 'wtr_framework' ),
		'fields'	=> array(
			$wtr_FontsSize_1,
			$wtr_FontsSize_13,
			$wtr_FontsSize_14,
			$wtr_FontsSize_2,
			$wtr_FontsSize_3,
			$wtr_FontsSize_4,
			$wtr_FontsSize_5,
			$wtr_FontsSize_6,
			$wtr_FontsSize_7,
			$wtr_FontsSize_8,
			$wtr_FontsSize_9,
			$wtr_FontsSize_10,
			$wtr_FontsSize_11,
			$wtr_FontsSize_12,
			),
	)
);

$wtr_FontFontFamilySection = new WTR_Section( array(
		'id'		=> 'wtr_FontFontFamilySection',
		'title'		=> __( 'Font - family', 'wtr_framework' ),
		'fields'	=> array(
			$wtr_txt_hidden,
			$wtr_admin_prev_font_size,
			$wtr_FontsFont_0,
			$wtr_FontsFont_3,
			$wtr_FontsFont_1,
			$wtr_FontsFont_2,
			$wtrFontsGoogleFontSubset,
			$wtrFontsCustomFontName,
			$wtrFontsCustomFontWoff,
			$wtrFontsCustomFontEot,
			$wtrFontsCustomFontSvg,
			$wtrFontsCustomFontTtf,
			$wtrFontsCustomFontWoff,
			$wtrFontsCustom2FontName,
			$wtrFontsCustom2FontWoff,
			$wtrFontsCustom2FontEot,
			$wtrFontsCustom2FontSvg,
			$wtrFontsCustom2FontTtf,
			$wtrFontsCustom2FontWoff,
		),
	)
);


//Translate
$wtr_TranslateGeneralSection = new WTR_Section( array(
		'id'		=> 'wtr_TranslateGeneralSection',
		'title'		=> __( 'General', 'wtr_framework' ),
		'fields'	=> array(
			$wtr_TranslateTranslationSettings,
			$wtr_TranslateHomeBreadcrumbsMainPage,
			$wtr_TranslateHomeBreadcrumbsBlog,
			$wtr_TranslateHomeCrumbsTaxArchiveFor,
			$wtr_TranslateHomeOlderComments,
			$wtr_TranslateHomeNewerComments,
			$wtr_TranslateHomeCommentsCount,
			$wtr_TranslateHomeCommentsAreClosed,
			$wtr_TranslateHomeCommentsmMderation,
			$wtr_TranslateHomePasswordText,
			$wtr_TranslateHomePasswordText2,
			$wtr_TranslateHomePasswordlabelSubmit,
			$wtr_TranslateHomePagination,
			$wtr_TranslateHomeLoader,
			$wtr_TranslateHomePayPal,
			$wtr_TranslateHomeMobileMenu
		),
	)
);

$wtr_TranslateBlogSection = new WTR_Section( array(
		'id'		=> 'wtr_TranslateBlogSection',
		'title'		=> __( 'Blog', 'wtr_framework' ),
		'fields'	=> array(
			$wtr_TranslateBlogContinueReading,
			$wtr_TranslateBlogByAuthor,
			$wtr_TranslateBlogPostByAuthor,
			$wtr_TranslateBlogPostTags,
			$wtr_TranslateBlogPostAuthor,
			$wtr_TranslateBlogRelatedPosts,
			$wtr_TranslateBlogRelatedPostsAuthor,
			$wtr_TranslateBlogStickyPosts,
			$wtr_TranslateBlogCrumbsArchiveForCategory,
			$wtr_TranslateBlogCrumbsTagArchivefor,
			$wtr_TranslateBlogCrumbsAuthorArchive,
			$wtr_TranslateBlogCrumbsArchiveForDate,
			$wtr_TranslateBlogCrumbsArchiveForMonth,
			$wtr_TranslateBlogCrumbsArchiveForYear,
		),
	)
);

$wtr_TranslateEventSection = new WTR_Section( array(
		'id'		=> 'wtr_TranslateEventSection',
		'title'		=> __( 'Event', 'wtr_framework' ),
		'fields'	=> array(
			$wtr_TranslateEventSelectEvent,
			$wtr_TranslateEventCurrent,
			$wtr_TranslateEventOutdated,
			$wtr_TranslateEventNoItems,
			$wtr_TranslateEventSingleCategory,
			$wtr_TranslateEventSingleVenue,
			$wtr_TranslateEventSingleVenuePhone,
			$wtr_TranslateEventSingleOrgaznizer,
			$wtr_TranslateEventSingleOrgaznizerPhone,
			$wtr_TranslateEventSingleDetails,
			$wtr_TranslateEventSingleSignUps,
			$wtr_TranslateEventSingleLimits,
			$wtr_TranslateEventSingleParticipants,
		),
	)
);

$wtr_TranslateClassesSection = new WTR_Section( array(
		'id'		=> 'wtr_TranslateClassesSection',
		'title'		=> __( 'Classes', 'wtr_framework' ),
		'fields'	=> array(
			$wtr_TranslateClassesMinutes,
			$wtr_TranslateClassesKcal,
			$wtr_TranslateClassesLevel,
			$wtr_TranslateClassesLevel_1,
			$wtr_TranslateClassesLevel_2,
			$wtr_TranslateClassesLevel_3,
			$wtr_TranslateClassesLevel_4,
			$wtr_TranslateClassesLevel_5,
			$wtr_TranslateClassesNumber,
			$wtr_TranslateClassesTrainer,
			$wtr_TranslateClassesTrainerReadMore,
		),
	)
);

$wtr_TranslateCommentFormSection = new WTR_Section( array(
		'id'		=> 'wtr_TranslateCommentFormSection',
		'title'		=> __( 'Comment Form', 'wtr_framework' ),
		'fields'	=> array(
			$wtr_TranslateCommentFormName,
			$wtr_TranslateCommentFormEmail,
			$wtr_TranslateCommentFormUrl,
			$wtr_TranslateCommentFormComment,
			$wtr_TranslateCommentFormtitleReply,
			$wtr_TranslateCommentFormtitleReplyTo,
			$wtr_TranslateCommentFormcancelReplyLink,
			$wtr_TranslateCommentFormlabelSubmit,
		),
	)
);

$wtr_Translate404Section = new WTR_Section( array(
		'id'		=> 'wtr_Translate404Section',
		'title'		=> __( '404', 'wtr_framework' ),
		'fields'	=> array(
			$wtr_Translate404After404,
			$wtr_Translate404TextBelow404,
			$wtr_Translate404ButtonLabel,
			$wtr_Translate404Section_1_title,
			$wtr_Translate404Section_2_title,
			$wtr_Translate404Section_2_desc,
			$wtr_Translate404Section_3_title,
			$wtr_Translate404Section_3_desc,
		),
	)
);

$wtr_TranslateSearchFormSection = new WTR_Section( array(
		'id'		=> 'wtr_TranslateSearchFormSection',
		'title'		=> __( 'Search form', 'wtr_framework' ),
		'fields'	=> array(
			$wtr_TranslateSearchFormNewSearch,
			$wtr_TranslateSearchNaviFormNewSearch,
			$wtr_TranslateSearchNaviFormNewSearchLabel,
			$wtr_TranslateSearchFormSearchResultFor,
			$wtr_TranslateSearchFormSectionNoresultsTitle,
			$wtr_TranslateSearchFormCrumbsSearchResults,
			$wtr_TranslateSearchFormSearchComment,
			$wtr_TranslateSearchFormSearchByAuthor,
			$wtr_TranslateSearchFormSearchPostType,
			$wtr_TranslateSearchFormSearchPostType_page,
			$wtr_TranslateSearchFormSearchPostType_post,
			$wtr_TranslateSearchFormSearchPostType_rooms,
			$wtr_TranslateSearchFormSearchPostType_classes,
			$wtr_TranslateSearchFormSearchPostType_trainer,
			$wtr_TranslateSearchFormSearchPostType_events
		),
	)
);

$wtr_TranslateShortcodeSection = new WTR_Section( array(
		'id'		=> 'wtr_TranslateShortcodeSection',
		'title'		=> __( 'Shortcode', 'wtr_framework' ),
		'fields'	=> array(
			$wtr_TranslateBlogSHTBy,
			$wtr_TranslateBlogSHTAuthor,
			$wtr_TranslateBlogSHTReadMore,
			$wtr_TranslateBlogSHTComments,
			$wtr_TranslateEventSHTReadMore,
			$wtr_TranslateClassesSHTMinutes,
			$wtr_TranslateClassesSHTKcal,
			$wtr_TranslateCountdownSHTYears,
			$wtr_TranslateCountdownSHTMonths,
			$wtr_TranslateCountdownSHTWeeks,
			$wtr_TranslateCountdownSHTDays,
			$wtr_TranslateCountdownSHTHours,
			$wtr_TranslateCountdownSHTMinutes,
			$wtr_TranslateCountdownSHTSeconds,
			$wtr_TranslateClassesSHTPassStatus2,
			$wtr_TranslateClassesSHTPassStatus1,
			$wtr_TranslateClassesSHTPassStatus0,
			$wtr_TranslateClassesScheduleSHTMonday,
			$wtr_TranslateClassesScheduleSHTTuesday,
			$wtr_TranslateClassesScheduleSHTWednesday,
			$wtr_TranslateClassesScheduleSHTThursday,
			$wtr_TranslateClassesScheduleSHTFriday,
			$wtr_TranslateClassesScheduleSHTSaturday,
			$wtr_TranslateClassesScheduleSHTSunday,
			$wtr_TranslateClassesScheduleSHTTimeDay,
			$wtr_TranslateClassesScheduleSHTSelectClasse,
			$wtr_TranslateClassesScheduleSHTShowAll,
			$wtr_TranslateClassesScheduleSHTSorry,
			$wtr_TranslateClassesScheduleSHTAll,
			$wtr_TranslateClassesScheduleSHTCategories,
			$wtr_TranslateClassesScheduleSHTClasses,
			$wtr_TranslateClassesScheduleSHTCategory,
			$wtr_TranslateClassesScheduleSHTClass,
			$wtr_TranslateClassesSHTPassPrice,
			$wtr_TranslateClassesSHTSBSStep,
			$wtr_TranslateDailyScheduleSHTText,
			$wtr_TranslateDailyScheduleSHTText2,
		),
	)
);

$wtr_TranslateWidgetsSection = new WTR_Section( array(
		'id'		=> 'wtr_TranslateWidgetsSection',
		'title'		=> __( 'Widgets', 'wtr_framework' ),
		'fields'	=> array(
			$wtr_TranslateWidgetsSectionTrainerMeet
		),
	)
);


//PayPal
$wtr_PayPalSection = new WTR_Section( array(
		'id'		=> 'wtr_PayPalSection',
		'title'		=> __( 'Global', 'wtr_framework' ),
		'fields'	=> array(
			$wtr_PayPalGlobalStatus,
			$wtr_PayPalShowInClass,
			$wtr_PayPalShowInEvent,
			$wtr_PayPalShowInPass,
			$wtr_PayPalEmail,
			$wtr_PayPalCurrencyCode ,
		),
	)
);


//Data Backup
$wtr_DataBackupImporExportSection = new WTR_Section( array(
		'id'		=> 'wtr_DataBackupImportSection',
		'title'		=> __( 'Export / Import', 'wtr_framework' ),
		'fields'=> array(
			$wtr_DataBackupExporSettings
		),
	)
);

$wtr_DataBackupOneClickSection = new WTR_Section( array(
		'id'		=> 'wtr_DataBackupOneClickSection',
		'title'		=> __( 'One Click Import', 'wtr_framework' ),
		'fields'=> array(
			$wtr_OneClickThemeAlert,
			$wtr_DataBackupOneClickImport
		),
	)
);


//---------------------------------------------------------
// Groups
//---------------------------------------------------------

$wtr_GeneralGroup = new WTR_Group( array(
		'title'		=> __( 'General', 'wtr_framework' ),
		'class'		=> 'wtr_GeneralGroup',
		'sections'	=> array(
			$wtr_GeneralGlobalSection,
			$wtr_GeneralSlugsSection,
			$wtr_GeneralSeoSection,
			$wtr_GeneralAnaliticsSection,
			$wtr_GeneralSidebarSection,
			$wtr_GeneralBlogSection,
			$wtr_GeneralEventSection
		),
	)
);

$wtr_SocialMediaGroup = new WTR_Group( array(
		'title'		=> __( 'Social Media', 'wtr_framework' ),
		'class'		=> 'wtr_SocialMediaGroup',
		'sections'	=> array(
			$wtr_SocialMediaSocialMediaLinksSection,
			$wtr_SocialMediaSocialMediaSettingsSection,
		),
	)
);

$wtr_LayoutGroup = new WTR_Group( array(
		'title'		=> __( 'Layout', 'wtr_framework' ),
		'class'		=> 'wtr_LayoutGroup',
		'sections'	=> array(
			$wtr_LaloutHeaderSection,
			$wtr_LaloutFooterSection,
			$wtr_CustomeCssSection,
		),
	)
);

$wtr_ColorGroup = new WTR_Group( array(
		'title'		=> __( 'Color', 'wtr_framework' ),
		'class'		=> 'wtr_ColorGroup',
		'sections'	=> array(
			$wtr_ColorGeneralSection,
		),
	)
);


$wtr_FontsGroup = new WTR_Group( array(
		'title'		=> __( 'Fonts', 'wtr_framework' ),
		'class'		=> 'wtr_FontsGroup',
		'sections'	=> array(
			$wtr_FontsFontSizeSection,
			$wtr_FontFontFamilySection
		),
	)
);

$wtr_TranslateGroup = new WTR_Group( array(
		'title'		=> __( 'Translate', 'wtr_framework' ),
		'class'		=> 'wtr_TranslateGroup',
		'sections'	=> array(
			$wtr_TranslateGeneralSection,
			$wtr_TranslateBlogSection,
			$wtr_TranslateClassesSection,
			$wtr_TranslateEventSection,
			$wtr_TranslateCommentFormSection,
			$wtr_Translate404Section,
			$wtr_TranslateSearchFormSection,
			$wtr_TranslateWidgetsSection,
			$wtr_TranslateShortcodeSection,
		),
	)
);

$wtr_PayPalGroup = new WTR_Group( array(
		'title'		=> __( 'PayPal', 'wtr_framework' ),
		'class'		=> 'wtr_PayPalGroup',
		'sections'	=> array(
			$wtr_PayPalSection
		),
	)
);

$wtr_DataBackupGroup = new WTR_Group( array(
		'title'		=> __( 'Data Backup', 'wtr_framework' ),
		'class'		=> 'wtr_DataBackupGroup',
		'sections'	=> array(
			$wtr_DataBackupImporExportSection,
			$wtr_DataBackupOneClickSection
		),
	)
);


$wtr_menu = array(
	$wtr_GeneralGroup,
	$wtr_SocialMediaGroup,
	$wtr_LayoutGroup,
	$wtr_ColorGroup,
	$wtr_FontsGroup,
	$wtr_TranslateGroup,
	$wtr_PayPalGroup,
	$wtr_DataBackupGroup,
);

global $WTR_Opt;

// Init
$WTR_Opt 			= new WTR_Settings( $wtr_menu);
$wtr_theme_page 	= new WTR_Theme_Page( $WTR_Opt );
$wtr_avatar 		= new WTR_Avatar;
$wtr_user_social 	= new WTR_user_social;
$wtr_update			= new WTR_Update;