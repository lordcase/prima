<?php
/**
 * Customizer options
 *
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

require_once( WTR_CUSTOMIZER_CLASS_DIR . '/wtr_customize.php' );
require_once( WTR_CUSTOMIZER_CLASS_DIR . '/fields/wtr_customize_section.php' );
require_once( WTR_CUSTOMIZER_CLASS_DIR . '/fields/wtr_customize_setting.php' );

if( ! defined( 'WP_CUSTOMIZER_OPT_NAME' ) ){
	define( 'WP_CUSTOMIZER_OPT_NAME', WTR_Settings::get_WP_OPT_NAME() . '_customizer' );
}



//---------------------------------------------------------
// SEttings
//---------------------------------------------------------

//Global colors Section
$wtr_Color_1 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_1',
		'default'		=> '#000000',
		'control_args'	=> array( 'label' 	=> __( 'Body and loader background color', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> 'body, .wtrLoader',
		'css_style' 	=> 'background-color',
		)
);


//Header colors Section
$wtr_Color_2 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_2',
		'default'		=> '#ffffff',
		'control_args'	=> array( 'label' 	=> __( 'Navigation background color', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.wtrHeader.wtrHeaderTransparent.wtrMenuScroll, .wtrHeaderColor',
		'css_style' 	=> 'background-color',
		'css_important'	=> true,
		)
);

$wtr_Color_3 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_3',
		'default'		=> '#999999',
		'control_args'	=> array( 'label' 	=> __( 'Quick contact font colors', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.wtrHeader .wtrQuickContactInfo, .wtrHeader .wtrQuickContactInfo p, .wtrMenuScroll .wtrQuickContactInfo p, .wtrMenuScroll .wtrQuickContactInfo a, .wtrHeader .wtrQuickContact p, .wtrHeader .wtrQuickContactInfo a',
		'css_style' 	=> 'color',
		)
);

$wtr_Color_4 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_4',
		'default'		=> '#cccccc',
		'control_args'	=> array( 'label' 	=> __( 'Quick contact link colors', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.wtrQuickContactSocialLinks li a, .wtrQuickContactInfo a',
		'css_style' 	=> 'color',
		)
);

$wtr_Color_5 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_5',
		'default'		=> '#000000',
		'control_args'	=> array( 'label' 	=> __( 'Quick contact link background color on hover', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.wtrQuickContactSocialLinks li a:hover',
		'css_style' 	=> 'background-color',
		'css_custom'	=> array( 'type' => 'rgba', 'value'=> '0.1'),
		'transport'		=> 'refresh',
		)
);

$wtr_Color_6 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_6',
		'default'		=> '#ffffff',
		'control_args'	=> array( 'label' 	=> __( 'Quick contact link font color on hover', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.wtrQuickContactSocialLinks li a:hover, .wtrQuickContactInfo a:hover',
		'css_style' 	=> 'color',
		'transport'		=> 'refresh',
		)
);

$wtr_Color_85 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_85',
		'default'		=> '#e5e5e5',
		'control_args'	=> array( 'label' 	=> __( 'Quick contact border color', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.wtrMenuScroll .wtrQuickContact, .wtrQuickContact',
		'css_style' 	=> 'border-color',
		)
);

$wtr_Color_7 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_7',
		'default'		=> '#000000',
		'control_args'	=> array( 'label' 	=> __( 'First level navigation font color', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.wtrMobileNaviTriger.wtrDefaultLinkColor i, .wtrMenuScroll.wtrHeaderTransparent .wtrMainNavigation .wtrNaviItem > span, .wtrMenuScroll.wtrHeaderTransparent.wtrHeaderFixed .wtrNaviSearchItem div i, .wtrMenuScroll .wtrMainNavigation .wtrNaviItem > a, .wtrMenuScroll.wtrHeaderTransparent.wtrHeaderFixed .wtrNaviCartItem a i, .wtrMainNavigation .wtrNaviCartItem a i, .wtrNaviSearchItem .wtrDefaultLinkColor, .wtrMenuScroll.wtrHeaderTransparent .wtrNaviSearchItem i, .wtrMainNavigation .wtrNaviSearchItem .wtrDefaultLinkColor i, .wtrMenuLinkColor, .menu-item-language a, .menu-item-language ul.sub-menu li a',
		'css_style' 	=> 'color',
		)
);

$wtr_Color_84 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_84',
		'default'		=> '#1fce6d',
		'control_args'	=> array( 'label' 	=> __( 'First level navigation font color on hover', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.wtrSecondMenuContainer li.menu-item-has-children.current-menu-parent > a, .wtrSecondMenuContainer li.menu-item-has-children.current-menu-item a.wtrSecondMenuLinkColor, .wtrSecondMenuContainer li.menu-item-has-children span.wtrSecondMenuLinkColor, .wtrSecondMenuContainer li.menu-item-has-children span.wtrSecondMenuLinkColor:hover, .wtrNavigation > ul.wtrMainNavigation > li.current-menu-item > a, .wtrMobileNaviTriger.wtrDefaultLinkColor i:hover, .wtrHeaderTransparent .wtrMainNavigation .wtrNaviItem.wtrNaviSearchItem i:hover, .wtrMainNavigation .wtrNaviSearchItem .wtrDefaultLinkColor i:hover, ul.wtrMainNavigation > li.menu-item.current-menu-ancestor .wtrMenuLinkColor, .wtrHeaderTransparent .wtrMainNavigation > li.menu-item.current-menu-ancestor .wtrMenuLinkColor, .wtrNaviSearchItem:hover i, .wtrMenuScroll.wtrHeaderTransparent .wtrNaviSearchItem:hover i, .wtrMenuScroll.wtrHeaderTransparent .wtrMainNavigation .wtrNaviItem.wtrNaviSearchItem i:hover, .wtrMenuScroll.wtrHeaderTransparent .wtrMainNavigation span.wtrMenuLinkColor:hover, .wtrMenuScroll.wtrHeaderTransparent .wtrMainNavigation a.wtrMenuLinkColor:hover, .wtrMainNavigation .wtrNaviItem.wtrNaviHover > span, .wtrMainNavigation .wtrNaviItem.wtrNaviHover > a, .wtrMenuLinkColor:hover, .wtrMenuScroll.wtrHeaderTransparent .wtrMainNavigation a.wtrMenuLinkColor:hover, .wtrMenuScroll.wtrHeaderTransparent .wtrMainNavigation span.wtrMenuLinkColor:hover',
		'css_style' 	=> 'color',
		'css_important'	=> true,
		'transport'		=> 'refresh',
		)
);

$wtr_Color_8 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_8',
		'default'		=> '#222222',
		'control_args'	=> array( 'label' 	=> __( 'Second level navigation background color', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.wtrMegaMenuContainerColor',
		'css_style' 	=> 'background-color',
		)
);

$wtr_Color_95 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_95',
		'default'		=> '#222222',
		'control_args'	=> array( 'label' 	=> __( 'Color for arrow in second level navigation - in boxed navigation mode', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.wtrHeaderBoxed .wtrMegaDrop:after, .wtrHeaderBoxed .wtrSecondDrop:after',
		'css_style' 	=> 'color',
		)
);

$wtr_Color_9 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_9',
		'default'		=> '#ffffff',
		'control_args'	=> array( 'label' 	=> __( 'Second level navigation headline color', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.wtrStandardMenu .wtrThirdNavi .wtrDropIcon:after, .wtrMegaMenuHeadline, .wtrMegaMenuHeadline a',
		'css_style' 	=> 'color',
		)
);

$wtr_Color_10 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_10',
		'default'		=> '#ffffff',
		'control_args'	=> array( 'label' 	=> __( 'Second level navigation link color', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> 'span.wtrSecondMenuLinkColor:hover, .wtrSecondMenuLinkColor',
		'css_style' 	=> 'color',
		)
);

$wtr_Color_11 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_11',
		'default'		=> '#ffffff',
		'control_args'	=> array( 'label' 	=> __( 'Third level navigation link color ', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.wtrThirdMenuLinkColor',
		'css_style' 	=> 'color',
		)
);

$wtr_Color_12 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_12',
		'default'		=> '#000000',
		'control_args'	=> array( 'label' 	=> __( 'Active position and third level navigation link color on hover', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.wtrSecondMenuContainer li.current_page_item span.wtrThirdMenuLinkColor, .current-menu-ancestor.wtrSecondDrop .current-menu-ancestor.wtrThirdNavi .wtrThirdDrop .current-menu-item a, .wtrThirdMenuLinkColor:hover',
		'css_style' 	=> 'color',
		'css_important'	=> true,
		'transport'		=> 'refresh',
		)
);

$wtr_Color_13 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_13',
		'default'		=> '#333333',
		'control_args'	=> array( 'label' 	=> __( 'Mobile and smart navigation background color', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.wtrSmartNavigation .dl-menuwrapper .dl-trigger:hover, .wtrSmartNavigation .dl-menuwrapper .dl-trigger.dl-active, .wtrSmartNavigation .dl-menuwrapper ul, .mp-level',
		'css_style' 	=> 'background-color',
		'css_important'	=> true,
		'transport'		=> 'refresh',
		)
);


//Breadcrumbs colors Section
$wtr_Color_14 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_14',
		'default'		=> '#ffffff',
		'control_args'	=> array( 'label' 	=> __( 'Breadcrumbs background color', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.wtrBreadcrumbColor',
		'css_style' 	=> 'background-color',
		)
);

$wtr_Color_15 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_15',
		'default'		=> '#999999',
		'control_args'	=> array( 'label' 	=> __( 'Breadcrumbs headline font color', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.wtrBreadcrumbHeadlineColor',
		'css_style' 	=> 'color',
		)
);

$wtr_Color_16 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_16',
		'default'		=> '#999999',
		'control_args'	=> array( 'label' 	=> __( 'Breadcrumbs patch font color', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.wtrNoLinkCrumb, .wtrBreadcrumbPathList .wtrCrumb:before, .wtrBreadcrumbLinkColor',
		'css_style' 	=> 'color',
		)
);

$wtr_Color_17 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_17',
		'default'		=> '#ffffff',
		'control_args'	=> array( 'label' 	=> __( 'Breadcrumb active site font colors', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.wtrBreadcrumbActvieCrumbColor',
		'css_style' 	=> 'color',
		)
);

$wtr_Color_18 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_18',
		'default'		=> '#000000',
		'control_args'	=> array( 'label' 	=> __( 'Breadcrumb active site background color', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.wtrBreadcrumbActvieCrumbColor',
		'css_style' 	=> 'background-color',
		'css_custom'	=> array( 'type' => 'rgba', 'value'=> '0.15')
		)
);


//Others Section
$wtr_Color_19 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_19',
		'default'		=> '#1fce6d',
		'control_args'	=> array( 'label' 	=> __( 'Distinctive font color for valid elemnts', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.bbp-topics ul.sticky .bbp-topic-permalink:before, .bbp-topics li.bbp-topic-title a.bbp-topic-permalink:hover, .bbp-forum-info a.bbp-forum-title:hover, .wtrBreadcrumbPathList .wtrCrumb a:hover, .wtrShtFullWidthTabs .wtrShtFWT li.tab-current i, .wtrDailyScheduleHeadlineDate, .wtrEventCategoryItem a.active, .wtrHeaderTransparent.wtrHeaderFixed.wtrMenuScroll a.wtrTriggerMobileMenu i, .shipping_calculator h2 a.shipping-calculator-button,.woocommerce .products .product .price,.woocommerce ul.products li.product a:hover h3,.woocommerce p.myaccount_user strong,.woocommerce .cart_item a,.woocommerce .stock,.woocommerce .in-stock,.woocommerce #content div.product .woocommerce-tabs ul.tabs li.active,.woocommerce div.product .woocommerce-tabs ul.tabs li.active,.woocommerce #content div.product p.price,.woocommerce #content div.product span.price,.woocommerce div.product p.price,.woocommerce div.product span.price,.woocommerce-page #content div.product .woocommerce-tabs ul.tabs li.active,.woocommerce-page div.product .woocommerce-tabs ul.tabs li.active,.woocommerce-page #content div.product p.price,.woocommerce-page #content div.product span.price,.woocommerce-page div.product p.price,.woocommerce-page div.product span.price,/* WooCommerce */.wtrTimeTableModalTabs .resp-tab-active,.wtrTimeTableModalTabsList li:hover,.wtrShtGoogleMaps a,.wtrShtLastNewsStandard .wtrShtLastNewsStandardHeadlineColor:hover,.wtrShtLastNewsListStreamItem:hover .wtrShtLastNewsListItemTitle a,.wtrShtLastNewsListStreamItem:hover .wtrShtLastNewsListItemTitle,.wtrShtTabs .resp-tab-active,.wtrShtTabs .resp-tabs-list li:hover,.wtrShtEventListBtn:hover,.wtrShtEventListItem .wtrShtEventListTittle a:hover,.wtrShtClassesListTimeInfo i,.wtrShtClassesListKcallInfo i,.wtrShtClassesListItem .wtrShtClassesListTittle a:hover,.wtrShtAccordion ul .wtrShtAccordionItem:hover .wtrShtAccordionNavi:after,.wtrShtAccordion ul .wtrShtAccordionItem .wtrShtAccordionHeadline:hover,.wtrShtAccordion ul .wtrShtAccordionItem.st-open .wtrShtAccordionHeadline,.wtrShtAccordion ul .wtrShtAccordionItem.st-open > .wtrShtAccordionHeadline .wtrShtAccordionNavi:after,.wtrShtStepByStepIco,.wtrShtStepByStepItem:after,.wtrShtIconContainer,.no-touch .hi-icon-effect-1a .hi-icon,.no-touch .hi-icon-effect-9a .hi-icon:hover,.no-touch .hi-icon-effect-8 .hi-icon:hover,.hi-icon,.wtrShtOpenHoursDesc a,.wtrShtPassesListLight .wtrShtPassesListNavi:after,.wtrShtPassesListLight .wtrShtPassesListItem .wtrShtPassesListNavi:after,.wtrShtPassesListLight .wtrShtPassesListItem .wtrShtPassesListHeadlineItem:hover,.wtrShtPassesListLight .wtrShtPassesListItem.st-open .wtrShtPassesListHeadlineItem,.wtrShtPassesListLight .wtrShtPassesListItem.st-open .wtrShtPassesListHeadline .wtrShtPassesListNavi:after,.wtrShtPassesListLight .wtrShtPassesListItem:hover .wtrShtPassesListNavi:after,.wtrShtPassesListLight .wtrShtPassesListItem:hover,.wtrShtPassesListLight .wtrShtPassesListItem.st-open,.wtrShtSliderGallery .flex-direction-nav a,.wtrShtIconBoxList span i,.wtrMainNavigation .wtrThirdNavi .wtrSecNaviItemLink:hover .wtrDropIcon:after, .wtrMegaMenuHeadline a:hover,a.wtrSecondMenuLinkColor:hover,.wtrDefHedlineLinkColor a:hover, .wtrEventEntryMetaDate i, .wtrEventEntryCategoryItemHeadline, .wtrVeOrName, .wtrDefaultLinkColor, .wtrTrainerPageTrainerFunction,  .wtrEventStreamItemMetaDate i, .current-menu-item.wtrMegaMenuHeadline a, .current-menu-ancestor.wtrSecondDrop .current-menu-ancestor.wtrThirdNavi .wtrDropIcon:after, .current-menu-item > span, .current-menu-item > a > span, .current-menu-item > a, blockquote:after, .wtrMenuScroll.wtrHeaderTransparent .wtrMainNavigation .current-menu-ancestor > a, .wtrMenuScroll.wtrHeaderTransparent .wtrMainNavigation .current-menu-ancestor > span, .wtrPageContent p a:not(.button):not(.wtrButtonStd):not(.wtrClientUrl):not(.wtrShtEventListBtn):not(.wtrDefBorderLink):not(.chosen-single):not(.remove):not(.star-5):not(.star-4):not(.star-3):not(.star-2):not(.star-1):not(.ptp-button), .wpb_text_column a:not(.button):not(.showcoupon):not(.remove):not(.wtrButtonStd):not(.chosen-single):not(.ptp-button):not(.view), .comment-content a, .wtrPageContent table a:not(.wtrShtTimeTableEntryName):not(.remove):not(.wtrShtTimeTableEntryTrainer):not(.wtrShtTimeTableEntryRoom):not(.ptp-button):not(.view), .wtrPageContent dl a, .wtrCommentList .trackback a, .wtrCommentList .pingback a',
		'css_style' 	=> 'color',
		'css_important'	=> true,
		'transport'		=> 'refresh',
		)
);

$wtr_Color_20 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_20',
		'default'		=> '#1fce6d',
		'control_args'	=> array( 'label' 	=> __( 'Distinctive Background color for valid elements', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.wtrSimpleMobileNav ul li a:hover, .wtrShtPayPal.normal, .wtrCrewItemContainer, .wtrDSItem, .wtrShtBoxedEventsColTwo,.wtrShtBoxedEventsColTwoSec,.wtrShtBoxedEventsColOne,.wtrShtBoxedEventsColOneSec,.wtrShtBoxedClassesSkill,.wtrShtTTLoader > div,.wtrShtCallLoader > div, .wtrTimeTableModalClassClockTime i,.hentry .mejs-controls .mejs-time-rail .mejs-time-current,.wtrShtCountdown,.wtrShtLastNewsModern .owl-theme .owl-dots,.wtrShtEventListPrice,.wtrShtTrainerMetaName,.wtrShtStepByStepInfo,.wtrShtIconContainer:hover,.wtrShtIconBox:hover .wtrShtIconContainer,.hi-icon-effect-3 .hi-icon:after,.no-touch .hi-icon-effect-3a .hi-icon:hover,.no-touch .hi-icon-effect-1a .hi-icon:hover,.wtrShtWonsterSliderDotsContainer .wtrShtWonsterSliderDots li span:hover,.wtrShtWonsterSliderDotsContainer .wtrShtWonsterSliderDots li span.wtrActiveSlide,.wtrRotProgress,.wtrShtOpenIcon,.wtrShtPassesListClassesPrice,.wtrShtPassesListDark .wtrShtPassesListContainer,.wtrShtPassPriceHighlight,.wtrShtContentSlider .owl-theme .owl-controls .owl-next:hover,.wtrShtContentSlider .owl-theme .owl-controls .owl-prev:hover,.wtrClinetsCarusel.owl-theme .owl-dots .owl-dot.active span,.wtrClinetsCarusel.owl-theme .owl-dots .owl-dot:hover span,.wtrShtSliderGallery .flex-control-paging li a.flex-active,.wtrShtSliderGallery .flex-control-paging li a:hover,.wtrShtIconBoxList .wtrShtIconBoxIconHolder:hover,.wtrShtMark,.wtrMenuScroll.wtrHeaderTransparent.wtrHeaderFixed span.wtrCartCounter:hover,.wtrMenuScroll.wtrHeaderTransparent.wtrHeaderFixed span.wtrCartCounter,.wtrCartCounter:hover,.wtrCartCounter,.wtrMegaMenuContainerColorSecond,.wtrEventEntryPrice,.wtrTrainerPageTrainerSocialLinks li a:hover,.wtrEventStreamItemPrice,.wtrDefBgColor,.wtrClassesDifficultMeter,.wtrClassesHeadline, .wtrTrainerPageCover, .wtrEventStreamItemNoPhoto, .wtrMegaMenuContainerColorSecond, .wtrContainerColor.wtr404, mark',
		'css_style' 	=> 'background-color',
		'css_important'	=> true,
		'transport'		=> 'refresh',
		)
);

$wtr_Color_21 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_21',
		'default'		=> '#1fce6d',
		'control_args'	=> array( 'label' 	=> __( 'Distinctive border color for valid elements', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.select2-drop-active, .select2-dropdown-open .select2-choice, .select2-dropdown-open.select2-drop-above .select2-choice, .select2-dropdown-open.select2-drop-above .select2-choices, .select2-drop.select2-drop-above, .select2-drop.select2-drop-above.select2-drop-active, .wtrCircle, .wtrTimeTableClasses, .wtrShtLastNewsStandard .wtrShtLastNewsStandardDate:after, .wtrShtIconContainer:hover, .wtrShtIconBox:hover .wtrShtIconContainer, .wtrShtContentSlider .owl-theme .owl-dots .owl-dot.active span, .wtrShtContentSlider .owl-theme .owl-dots .owl-dot:hover span, .wtrMenuScroll.wtrHeaderTransparent.wtrHeaderFixed .wtrNaviCartLink:hover, .wtrNaviCartLink:hover, .wtrMenuScroll.wtrHeaderTransparent .wtrNaviSearchItem:hover i, .wtrMenuLinkColor:hover, .wtrBlogPostSneakPeakDate:after, .wrtBlogDfPostDate:after, .wtrClassesTimeStopWatch, .wtrMainNavigation > li.menu-item-language:hover, .menu-item-language ul.sub-menu, .wtrMenuScroll.wtrHeaderTransparent .wtrMainNavigation > li.menu-item-language:hover, .wtrMenuScroll.wtrHeaderTransparent .menu-item-language ul.sub-menu',
		'css_style' 	=> 'border-color',
		'css_important'	=> true,
		'transport'		=> 'refresh',
		)
);

$wtr_Color_22 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_22',
		'default'		=> '#000000',
		'control_args'	=> array( 'label' 	=> __( 'Second distinctive background color', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.wtrDailyScheduleHeadlineColumn, .wtrDailySchedule, .wtrShtBoxedClassesColTwo, .wtrShtBoxedClassesColTwoSec, .wtrShtBoxedClassesColOne, .wtrShtBoxedClassesColOneSec, .hentry .mejs-mediaelement, .hentry .mejs-container .mejs-controls, #vimeoplayer, #ytplayer, .wtrShtPromoEventAddMeta, .wtrShtPromoEventMeta, .wtrShtPromoEventNoPhoto .wtrShtPromoEventPictureContainer, .wtrShtPassesList .st-open',
		'css_style' 	=> 'background-color',
		)
);

$wtr_Color_23 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_23',
		'default'		=> '#ffffff',
		'control_args'	=> array( 'label' 	=> __( 'Font color for distinctive elements on colored backgrounds', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.wtrSimpleMobileNav ul li a:hover, .wtrShtPayPal.normal .wtrShtPPPrice div, .wtrShtPayPal.normal .wtrShtPPDesc, .wtrShtPayPal.normal .wtrShtPPDesc p, .wtrShtPayPal.normal .wtrShtPayPalItemName, .wtrDSItemTrainer li, .wtrShtDSNoResults, .wtrDSItemTime, .wtrDSItemClass, .wtrDSItemTime, .wtrDSItemName, .wtrDSItem, .wtrDailyScheduleHeadline, .wtrDSNavigation .wtrDSNext i, .wtrDSNavigation .wtrDSPrev i, .wtrShtBoxedEventPrice, .wtrShtBoxedEventsTime, .wtrShtBoxedEventsSpace .wtrShtBoxedEventsHeadline a, .wtrShtBoxedClassesTime, .wtrShtBoxedClassesSpace .wtrShtBoxedClassesHeadline a, .wtrShtBoxedClassesSpace .wtrShtBoxedClassesElements:before, .wtrTimeTableModalClassClockTime i, .wtrShtWonsterSliderControls span.prev::before, .wtrShtWonsterSliderControls span.next::before, .wtrShtCountdown .countdown-amount, .wtrShtPromoEventTittle, .wtrShtLastNewsModern .wtrShtLastNewsModernBoxDate, .wtrShtLastNewsModern .wtrShtLastNewsModernBoxAuthor, .wtrShtLastNewsModern .wtrShtLastNewsModernBoxComments, .wtrShtEventListPrice, .wtrShtTrainerMetaPositionName, .wtrShtTrainerMetaNameSubline, .wtrShtTrainerMetaNameHeadline, .wtrShtStepByStepInfoNo, .wtrShtStepByStepInfoNag, .wtrShtIconBox:hover .wtrShtIconContainer i, .no-touch .hi-icon-effect-3a .hi-icon:hover, .no-touch .hi-icon-effect-2a .hi-icon:hover,.no-touch .hi-icon-effect-1a .hi-icon:hover, .wtrShtWonsterSliderControls span, .wtrShtPassesListClassesPrice, .wtrShtPassesListContainer .wtrShtPassesListItem:hover .wtrShtPassesListNavi:after, .wtrShtPassesListContainer .wtrShtPassesListItem:hover, .wtrShtPassesListDark .wtrShtPassesListContainer .wtrShtPassesListItem.st-open, .wtrShtPassesListDark .wtrShtPassesListContainer .wtrShtPassesListItem.st-open > .wtrShtPassesListHeadline .wtrShtPassesListNavi:after, .wtrShtGallery .wtrHoveredGalleryItemElements:before, .wtrShtMark, .wtrShtBoxedEventsSpace .wtrShtBoxedEventsElements:before, .wtrShtClassesArrow, .wtrShtPromoEventAddMeta i, .wtrShtPromoEventAdditionalIco, .wtrShtLastNewsStandard .wtrShtLastNewsStandardElements:before, .wtrShtLastNewsModern .wtrShtLastNewsModernBox:hover .wtrShtLastNewsModernBoxOthers, .wtrShtLastNewsModern .wtrShtLastNewsModernBoxOthers, .wtrShtLastNewsModern .wtrShtLastNewsModernBoxHedaline a, .wtrShtLastNewsMetro .wtrShtLastNewsBoxedAuthor a, .wtrShtLastNewsMetro .wtrShtLastNewsBoxedAuthor, .wtrShtLastNewsMetro .wtrShtLastNewsBoxedDate, .wtrShtLastNewsMetro .wtrShtLastNewsBoxedHedline, .wtrShtLastNewsListCommentsNr, .wtrShtClassesMetaTime, .wtrShtClassesMetaHeadline a, .wtrShtRoomClassesName, .wtrShtRoomName, .wtrShtTrainer .wtrShtTrainerElements:before, .wtrCrewItemName, .wtrShtOpenIcon, .wtrShtPassesListDark .wtrShtPassesListHeadlineItem, .wtrShtPassPriceHighlight, .wtrShtContentSlider .owl-theme .owl-controls .owl-nav [class*=owl-], .wtrShtIconBoxList .wtrShtIconBoxIconHolder:hover a, .wtrShtIconBoxList .wtrShtIconBoxIconHolder:hover i, .wtrShtIconBoxList .wtrShtIconBoxIconHolder:hover p, .wtrShtInstagramGalleryItemLink i, .wtrMenuScroll.wtrHeaderTransparent.wtrHeaderFixed .wtrCartCounter:hover, .wtrMenuScroll.wtrHeaderTransparent.wtrHeaderFixed .wtrNaviCartLink:hover .wtrCartCounter, .wtrNaviCartLink:hover .wtrCartCounter, .wtrCartCounter, .wtrSearchInput, .wtr404Slug, mark',
		'css_style' 	=> 'color',
		'css_important'	=> true,
		'transport'		=> 'refresh',
		)
);

$wtr_Color_24 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_24',
		'default'		=> '#127a44',
		'control_args'	=> array( 'label' 	=> __( 'Second font color for distinctive elements on colored backgrounds', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.wtrShtPassesListNavi:after, .wtr404HeadlineColor',
		'css_style' 	=> 'color',
		)
);

$wtr_Color_25 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_25',
		'default'		=> '#000000',
		'control_args'	=> array( 'label' 	=> __( 'Button font color for items placed on distinctive sections', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.wtrSearchInputButton:before, .wtrSearchInputButton, .wtr404ButtonColors',
		'css_style' 	=> 'color',
		)
);

$wtr_Color_26 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_26',
		'default'		=> '#ffffff',
		'control_args'	=> array( 'label' 	=> __( 'Button background color for items placed on distinctive sections', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.wtrSearchInputButton, .wtr404ButtonColors',
		'css_style' 	=> 'background-color',
		)
);

$wtr_Color_27 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_27',
		'default'		=> '#ffffff',
		'control_args'	=> array( 'label' 	=> __( 'Woo Commerce Sale badage colors ', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.woocommerce .product span.onsale, .woocommerce .wtrContainer span.onsale, .woocommerce span.onsale',
		'css_style' 	=> 'color',
		'css_important'	=> true,
		)
);

$wtr_Color_28 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_28',
		'default'		=> '#1fce6d',
		'control_args'	=> array( 'label' 	=> __( 'Woo Commerce Sale badage background colors ', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.woocommerce .product span.onsale, .woocommerce .wtrContainer span.onsale, .woocommerce span.onsale',
		'css_style' 	=> 'background-color',
		'css_important'	=> true,
		)
);

$wtr_Color_86 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_86',
		'default'		=> '#1fce6d',
		'control_args'	=> array( 'label' 	=> __( 'Pricing table price section background color', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.ptp-price',
		'css_style' 	=> 'background-color',
		'css_important'	=> true,
		)
);

$wtr_Color_87 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_87',
		'default'		=> '#ffffff',
		'control_args'	=> array( 'label' 	=> __( 'Pricing table price section font color', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.ptp-price',
		'css_style' 	=> 'color',
		'css_important'	=> true,
		)
);

$wtr_Color_88 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_88',
		'default'		=> '#000000',
		'control_args'	=> array( 'label' 	=> __( 'Pricing table plan name font color', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.ptp-plan',
		'css_style' 	=> 'color',
		'css_important'	=> true,
		)
);

$wtr_Color_89 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_89',
		'default'		=> '#dddddd',
		'control_args'	=> array( 'label' 	=> __( 'Pricing table border color', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.ptp-bullet-item, .ptp-item-container',
		'css_style' 	=> 'border-color',
		'css_important'	=> true,
		)
);

$wtr_Color_90 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_90',
		'default'		=> '#555555',
		'control_args'	=> array( 'label' 	=> __( 'Pricing table description section font color', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.ptp-bullet-item',
		'css_style' 	=> 'color',
		'css_important'	=> true,
		)
);

$wtr_Color_91 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_91',
		'default'		=> '#ffffff',
		'control_args'	=> array( 'label' 	=> __( 'Pricing table description section background color', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.ptp-plan, .ptp-cta, .ptp-bullet-item',
		'css_style' 	=> 'background-color',
		'css_important'	=> true,
		)
);

$wtr_Color_92 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_92',
		'default'		=> '#1B9F56',
		'control_args'	=> array( 'label' 	=> __( ' Pricing table featured column background color', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.ptp-highlight .ptp-cta, .ptp-highlight .ptp-bullet-item, .ptp-most-popular, .ptp-highlight .ptp-plan',
		'css_style' 	=> 'background-color',
		'css_important'	=> true,
		)
);

$wtr_Color_93 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_93',
		'default'		=> '#1fce6d',
		'control_args'	=> array( 'label' 	=> __( 'Pricing table featured column price section background color', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.ptp-highlight .ptp-price',
		'css_style' 	=> 'background-color',
		'css_important'	=> true,
		)
);

$wtr_Color_94 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_94',
		'default'		=> '#ffffff',
		'control_args'	=> array( 'label' 	=> __( 'Featured column font color', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.ptp-highlight .ptp-price, .ptp-highlight .ptp-bullet-item, .ptp-most-popular, .ptp-highlight .ptp-plan',
		'css_style' 	=> 'color',
		'css_important'	=> true,
		)
);

//Container colors Section
$wtr_Color_29 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_29',
		'default'		=> '#ffffff',
		'control_args'	=> array( 'label' 	=> __( 'Container background color', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.wtrBlogPostSneakPeakDate:after, .wrtBlogDfPostDate:after, .wtrShtTestimonialStdAuthorPicContainer, .wtrTrainerPagePicture, .wtrEventStreamItemMetaContainer, .wtrEventStreamItemHeadlineContainer, .wtrEventEntryDetails, .wtrEventEntryPageSidebar, .wtrEventEntryMetaContainer ul li, .wtrEventEntryMetaContainer, .wtrEventEntryHeadlineContainer, .wtrSidebarRight, .wtrSidebarLeft, .error404, .wtrContainerColor',
		'css_style' 	=> 'background-color',
		)
);

$wtr_Color_30 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_30',
		'default'		=> '#ffffff',
		'control_args'	=> array( 'label' 	=> __( 'Conatiner background color for elements like tables, tabs and others', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.wtrShtPayPal.light, .woocommerce-ordering, .wtrShtFullWidthTabs .wtrShtFWT li:hover, .wtrShtFullWidthTabs .wtrShtFWT li.tab-current, .wtrShtFullWidthTabContent section.content-current, .wtrShtFullWidthTabs, .wtrShtPass, .wtrClientsTable .wtrClientItem, .wtrTimeTableClasses, .wtrTimeTableModalContainer, .wtrTimeTableModalTabs .resp-tab-active, .hentry .mejs-controls .mejs-time-rail .mejs-time-total, .hentry .mejs-controls .mejs-horizontal-volume-slider .mejs-horizontal-volume-total, .hentry .mejs-controls .mejs-time-rail .mejs-time-loaded, .hentry .mejs-controls .mejs-horizontal-volume-slider .mejs-horizontal-volume-current, .wtrShtGoogleMapsInfoBox, .wtrShtLastNewsStandard .wtrShtLastNewsStandardDate:after, .wtrShtLastNewsModern .owl-theme .owl-dots .owl-dot span, .wtrShtLastNewsModern .owl-theme .owl-dots .owl-dot.active span, .wtrShtLastNewsModern .owl-theme .owl-dots .owl-dot:hover span, .wtrShtTabs .resp-tab-content, .wtrShtTabs .resp-tab-active, .wtrShtRoomSeparator, .wtrCrewItemPictureContainer .wtrCrewItemPicture, .wtrShtStepByStepContainer, .wtrShtIconContainer, .wtrShtIconBox, .hi-icon-effect-2 .hi-icon:after, .wtrShtWonsterSliderDotsContainer .wtrShtWonsterSliderDots li span, .wtrShtOpenHours, .wtrShtPassesListLight .wtrShtPassesListContainer .st-open, .wtrShtPassesListLight .wtrShtPassesListContainer, .wtrShtContentSlider .owl-theme .owl-dots .owl-dot.active span, .wtrShtContentSlider .owl-theme .owl-dots .owl-dot:hover span, .wtrShtSliderGallery .flex-control-paging li a, .wtrShtSliderGallery .flex-direction-nav li a, .wtrShtSliderGallery .flexslider, .wtrShtTimeTableItem tbody, .wtrIconDividerStyle, .wtrShtMobileTimeTable',
		'css_style' 	=> 'background-color',
		'transport'		=> 'refresh',
		)
);

$wtr_Color_31 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_31',
		'default'		=> '#ffffff',
		'control_args'	=> array( 'label' 	=> __( 'Background color for conatiner elemnts like tabs and tables', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.woocommerce .wtrContainer div.product .woocommerce-tabs .panel, .woocommerce .wtrContainer .shop_table.cart, .woocommerce .wtrContainer #order_review .shop_table, .woocommerce .wtrContainer .shop_table.order_details, .woocommerce .wtrContainer #payment, .woocommerce .wtrContainer #content div.product .woocommerce-tabs ul.tabs li, .woocommerce .wtrContainer div.product .woocommerce-tabs ul.tabs li, .woocommerce-page .wtrContainer div.product .woocommerce-tabs .panel, .woocommerce-page .wtrContainer #payment, .woocommerce-page .wtrContainer #content div.product .woocommerce-tabs ul.tabs li, .woocommerce-page .wtrContainer div.product .woocommerce-tabs ul.tabs li',
		'css_style' 	=> 'background-color',
		)
);

$wtr_Color_32 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_32',
		'default'		=> '#000000',
		'control_args'	=> array( 'label' 	=> __( 'Headline font color', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '#bbpress-forums #bbp-search-form .hidden:before, .bbp-row-actions #favorite-toggle span.is-favorite a, .bbp-row-actions #subscription-toggle span.is-subscribed a, #bbpress-forums #bbp-user-wrapper h2.entry-title, .bbp-breadcrumb-current, #subscription-toggle a:before, #subscription-toggle a, #favorite-toggle:before, #favorite-toggle a, .wtrShtPayPal.light .wtrShtPayPalItemName, .wtrShtPayPal.light .wtrShtPPPrice div, .wtrEventEntryMetaList li, .wtrShtFullWidthTabs .wtrShtFWT li.tab-current span, .wtrShtLinkHedline span, .checkout h3, .woocommerce-shipping-fields h3, .woocommerce-billing-fields h3, .woocommerce h1, .woocommerce h2, .woocommerce h3, .woocommerce h4, .woocommerce h5, .woocommerce h6, .woocommerce .shop_table .cart_item .product-name a, .woocommerce .cart_totals h2, .woocommerce #content div.product .product_title, .woocommerce div.product .product_title, .woocommerce-page #content div.product .product_title, .woocommerce-page div.product .product_title, /* WooCommerce */ .wtrShtTimeTableNoResultsHeadline, .wtrShtTimeTableItem thead th .wtrShtTimeTableDay, .wtrShtTimeTableEvent .wtrShtTimeTableEntryName, .wtrShtTimeTableEvent .wtrShtTimeTableEntryTimePeriod, .wtrShtTimeTableEvent .wtrShtTimeTableEntryTrainer, .wtrShtMobileTimeTableHeadline h4, .wtrShtMobileTimeTableClassName, .wtrTimeTableModalTabsListItem:hover, .wtrClassDetailsModalMetaHeadlineExSmall, .wtrClassDetailsModalMetaHeadlineEx a, .wtrShtIconBoxTitle, .wtrShtAccordionItem, .wtrShtGoogleMaps h1, .wtrShtLastNewsStandard .wtrShtLastNewsStandardHeadlineColor, .wtrShtLastNewsStandard .wtrShtLastNewsStandardDateCreated, .wtrShtLastNewsListItemTitle a, .wtrShtLastNewsListItemTitle, .wtrShtEventListTime, .wtrShtEventListItem .wtrShtEventListTittle a, .wtrShtEventListBtn, .wtrShtClassesListItem .wtrShtClassesListTittle a, .wtrShtCounter, .wtrShtStepByStepName, .wtrShtTestimonialRot .wtrShtTestimonialStdContainer p, .wtrShtTestimonialRot .wtrShtTestimonialStdContainer, .wtrShtTestimonialStd .wtrShtTestimonialStdContainer p, .wtrShtTestimonialStd .wtrShtTestimonialStdContainer, .wtrShtOpenHoursDay, .wtrShtOpenHoursDesc h1, .wtrShtOpenHoursDesc h2, .wtrShtOpenHoursDesc h3, .wtrShtOpenHoursDesc h4, .wtrShtOpenHoursDesc h5, .wtrShtOpenHoursDesc h6, .wtrShtPassesListLight .wtrShtPassesListClassesName, .wtrShtPassesListLight .wtrShtPassesListHeadlineItem, .wtrShtPassDescHeadLine, .wtrShtPassHeadline, .wtrShtPassHeadline a, .wtrShtHeadline, .wtrClientName h4, .wtrCommentList .comment cite.fn, .wtrCommentList .comment cite.fn a, .wtrDefHedlineLinkColor a, .wtrEventEntryTitle, .wtrEventEntryDetailsHeadline, .wtrClassesTrainerItemName, .wtrEventStreamItemMetaList, .wtrBlogPostSneakPeakDate, .wrtBlogDfPostDateCreated, .wtrBlogDfPostHeadline, .wtrPostAuthorName, .wtrCommentList .comment .fn a, .wtrCommentList .comment-reply-title, .wtrHeadlineElement, .wtrHedlineColor',
		'css_style' 	=> 'color',
		'transport'		=> 'refresh',
		)
);

$wtr_Color_33 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_33',
		'default'		=> '#555555',
		'control_args'	=> array( 'label' 	=> __( 'Paragraph font color', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.wtrShtPayPal.light .wtrShtPPPrice span, .wtrShtPayPal.light .wtrShtPPDesc, .wtrShtPayPal.light .wtrShtPPDesc p, .woocommerce-ordering select, .wtrCommentList .comment p, .addresses .title .edit, .addresses .title .edit, .wtrPageContent .woocommerce p, .woocommerce .woocommerce-error, .woocommerce .woocommerce-info, .woocommerce .woocommerce-message, .woocommerce .payment_methods, .woocommerce .shop_table, .woocommerce .cart_totals, .woocommerce .woocommerce-result-count, .woocommerce .order_details, .woocommerce .addresses, .woocommerce .customer_details, .woocommerce .product .entry-summary p, .woocommerce .woocommerce-tabs p, .woocommerce .product_meta, .woocommerce-page .woocommerce-error, .woocommerce-page .woocommerce-info, .woocommerce-page .woocommerce-message, /* WooCommerce */ .wtrShtMobileTimeTableClassTime, .wtrTimeTableClasses, .wtrTimeTableModalTabsListItem, .wtrClassDetailsModalMetaItemDesc p, .wtrShtLastNewsStandard .wtrShtLastNewsStandardLead, .wtrShtLastNewsListItemLead, .wtrShtPassesListLight .wtrShtPassesListClassesDesc, .wtrClientUrl, .wtrEventMoreDetail, .wtrEventEntryDetailsDesc, .wtrBlogPostSneakPeakOther, .wtrBlogPostSneakPeakLead, .wtrBlogDfPostCategoryItem, .wtrBlogDfPostOther, .logged-in-as, .wtrCommentList .comment-meta, .wtrCommentList .commentSeparator, .wtrCommentList .comment .fn, .wtrPostAuthorDesc, .wtrPageContent, .wtrPageContent p, .wtrPageContent ol, .wtrPageContent ul, .comment-content, .comment-content p',
		'css_style' 	=> 'color',
		)
);

$wtr_Color_35 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_35',
		'default'		=> '#ffffff',
		'control_args'	=> array( 'label' 	=> __( 'Font color on transparent backgrounds', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.wtrShtLinkMeta i, .wtrEventEntryPrice, .wtrTrainerPageTrainerSocialLinks li a:hover, .wtrEventStreamItemPrice, .wtrDefBgColor, .wtrClassesTimeStopWatch .wtrTimeCounter, .wtrClassesTimeStopWatch .wtrTimeCounterLead, .wtrClassesNameColorHolder, .wtrClassesKcalInfo, .wtrClassParticipantNumber, .wtrClassesDifficultMeterInfo, .wtrClassParticipantHeadline, .wtrTrainerPageTrainerSocialLinks li a, .wtrTrainerPageTrainerName, .wtrTrainerPageTrainerSurname, .wtrHoverdPostElements:before, .wtrBlogPostModernSneakPeakDate, .wtrBlogPostModernSneakPeakAuthor, .wtrBlogPostModernSneakPeakComments, .wtrBlogPostModernSneakPeakOthers, .wtrBlogPostModernSneakPeakHeadline a, .wtrBlogModernPostAdditionalData .wtrBlogDfPostOther, .wtrBlogModernPostOther, .wtrBlogModernPostDate:before, .wtrBlogModernPostDateCreated, .wtrBlogModernPostHeadlineContent .wtrBlogModernPostCategory .wtrBlogDfPostCategoryItem, .wtrBlogModernPostHeadlineContent .wtrBlogModernPostCategory a, .wtrRelatedPosts .wtrHoverdNewsBoxAuthor, .wtrRelatedPosts .wtrHoverdNewsBoxAuthor a, .wtrRelatedPosts .wtrHoverdNewsBoxPostDate, .wtrRelatedPosts .wtrHoverdNewsBoxPostTittle, .wtrBlogModernPostHeadline, .wtrShtPassesListDark .wtrShtPassesListClassesName',
		'css_style' 	=> 'color',
		'transport'		=> 'refresh',
		)
);

$wtr_Color_36 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_36',
		'default'		=> '#e5e5e5',
		'control_args'	=> array( 'label' 	=> __( 'Border color for site elements', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '#bbpress-forums fieldset.bbp-form, #bbpress-forums li.bbp-footer, div.bbp-topic-header,  div.bbp-reply-header, #bbpress-forums div.bbp-topic-tags, #bbpress-forums div.wp-editor-container, #bbpress-forums div.bbp-the-content-wrapper div.quicktags-toolbar, #bbpress-forums li.bbp-body ul.forum,  #bbpress-forums li.bbp-body ul.topic, #bbpress-forums li.bbp-header, #bbpress-forums ul.bbp-lead-topic, #bbpress-forums ul.bbp-topics, #bbpress-forums ul.bbp-forums, #bbpress-forums ul.bbp-replies, #bbpress-forums ul.bbp-search-results, #bbpress-forums li.bbp-body ul.forum, #bbpress-forums li.bbp-body ul.topic, #bbpress-forums li.bbp-header, #bbpress-forums ul.bbp-lead-topic, #bbpress-forums ul.bbp-topics, #bbpress-forums ul.bbp-forums, #bbpress-forums ul.bbp-replies, #bbpress-forums ul.bbp-search-results, .wtrShtPayPal.light .wtrShtPPPrice hr, .wtrShtPayPal.light .wtrShtPayPalItemName hr, .wtrShtPayPal.light, .woocommerce-ordering, .woocommerce #reviews #comments ol.commentlist li .comment-text, .woocommerce-page #reviews #comments ol.commentlist li .comment-text, .woocommerce table.shop_table tfoot td, .woocommerce table.shop_table tfoot th, .woocommerce-page table.shop_table tfoot td, .woocommerce-page table.shop_table tfoot th, .woocommerce .cart-collaterals .cart_totals tr td, .woocommerce .cart-collaterals .cart_totals tr th, .woocommerce-page .cart-collaterals .cart_totals tr td, .woocommerce-page .cart-collaterals .cart_totals tr th, .woocommerce table.shop_table, .woocommerce-page table.shop_table, .woocommerce table.shop_table td, .woocommerce-page table.shop_table td, .woocommerce #content div.product .woocommerce-tabs ul.tabs:before, .woocommerce div.product .woocommerce-tabs ul.tabs:before, .woocommerce-page #content div.product .woocommerce-tabs ul.tabs:before, .woocommerce-page div.product .woocommerce-tabs ul.tabs:before, .woocommerce #payment, .woocommerce-page #payment, .woocommerce #payment ul.payment_methods, .woocommerce-page #payment ul.payment_methods, .woocommerce p.stars a.star-1, .woocommerce p.stars a.star-2, .woocommerce p.stars a.star-3, .woocommerce p.stars a.star-4, .woocommerce p.stars a.star-5, .woocommerce-page p.stars a.star-1, .woocommerce-page p.stars a.star-2, .woocommerce-page p.stars a.star-3, .woocommerce-page p.stars a.star-4, .woocommerce-page p.stars a.star-5, .wtrMenuScroll.wtrHeaderTransparent .wtrNaviCartLink, .woocommerce #content div.product .woocommerce-tabs ul.tabs li.active, .woocommerce div.product .woocommerce-tabs ul.tabs li.active, .woocommerce-page #content div.product .woocommerce-tabs ul.tabs li.active, .woocommerce-page div.product .woocommerce-tabs ul.tabs li.active, /* WooCommerce */ .wtrShtPassDesc, .wtrShtPassHeadline, .wtrShtContentSlider .owl-theme .owl-dots .owl-dot span, .wtrShtTimeTableItem th, .wtrShtTimeTableItem td, .wtrShtMobileTimeTableDaylyPlanTime, .wtrTimeTableModalTabs .resp-tab-active, .wtrTimeTableModalTabItem, .wtrClassDetailsModalContainer, .wtrClassDetailsModalMetaItem, .wtrClassDetailsModalMetaItemDesc, .wtrClassDetailsModalMetaItemReadMore, .wtrClassDetailsModalMetaItemHead, .wtrShtEventListItem, .wtrShtLastNewsStandard .wtrShtLastNewsStandardContainer, .wtrShtLastNewsStandard .wtrShtLastNewsStandardItem, .wtrShtLastNewsListItemDate div, .wtrShtLastNewsListItemDate, .wtrShtLastNewsListStreamItem, .wtrShtTabs h2.resp-tab-title:last-child, .wtrShtTabs h2.resp-accordion, .wtrShtTabs .resp-tab-content, .wtrShtTabs .resp-tab-active, .wtrShtTabs .resp-tabs-list li, .wtrShtEventListBtn, .wtrShtClassesListKcallInfo, .wtrShtClassesListItem, .wtrShtCounter, .wtrShtAccordion ul .wtrShtAccordionItem, .wtrShtStepByStepContainer, .wtrShtIconContainer, .wtrShtIconBox, .wtrShtTestimonialRot .wtrShtTestimonialStdItem, .wtrShtOpenHoursItem, .wtrShtOpenHours, .wtrShtPassesListLight .wtrShtPassesListContainer, .wtrShtPass, .wtrClientItem, .wtrShtTimeTableItem thead, .wtrClinetsCarusel .owl-controls, .wtrShtPassesListLight .wtrShtPassesPriceListItem, .wtrShtIconBoxListDivider, .wtrMenuScroll.wtrHeaderTransparent.wtrHeaderFixed .wtrNaviCartLink, .wtrHeaderColor, .wtrBreadcrumbColor, .wtrNaviCartLink, .wtrClassesTrainerItem, .wtrClassesTrainerInfo, .wtrNoItemStream, .wtrEventCategoryItem, .wtrEventStreamItemMetaList li, .wtrEventStreamItemMetaContainer, .wtrContentSidebar, .wtrBlogPostSneakPeakContainer, .wtrBlogPostSneakPeak, .wtrCommentList .comment-respond, .wtrPostAuthor, .wtrBlogDfPostContent, .wtrDefBorderColor, .wtrSearchResultsHeadline, .wtrSearchResultMetaList li, .wtrSearchResultsFootline, .wtrBlogStreamModern .wtrPagination, .wtrSearchResults .wtrPagination, .wtrEventStream .wtrPagination, .wtrShtLastNewsList .wtrPagination, .wtrEventEntryDetails, .wtrEventEntryPageSidebar, .wtrEventEntryMetaContainer ul li, .wtrEventEntryMetaContainer, .wtrEventEntryHeadlineContainer, .wtrSidebarInner, .wtrSidebarRight, .wtrSidebarLeft, blockquote, .commentsClosed, .wtrMainNavigation > li.menu-item-language, .menu-item-language ul.sub-menu li, .wtrMenuScroll.wtrHeaderTransparent .wtrMainNavigation > li.menu-item-language, .wtrCommentList .pingback, .wtrCommentList .trackback, pre, table, th, td',
		'css_style' 	=> 'border-color',
		'css_important'	=> true,
		)
);

$wtr_Color_37 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_37',
		'default'		=> '#2ecc71',
		'control_args'	=> array( 'label' 	=> __( 'Distinctive overlay background color for elements on hover', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.wtrShtLinkMeta, .wtrDSEventItem .wtrDSItemContainer, .wtrShtRoom:hover .wtrShtRoomOverlay, .wtrShtBoxedClassesOverlay, .wtrShtGallery .wtrShtGalleryItem:hover .wtrShtGalleryItemOverlay, .wtrEventStreamItem:hover .wtrPostOverlay, .wtrHoverdModernPostBox:hover .wtrPostOverlay, .wtrRelatedPosts .wtrHoverdNewsBox:hover .overlay',
		'css_style' 	=> 'background-color',
		'css_custom'	=> array( 'type' => 'rgba', 'value'=> '0.7'),
		'transport'		=> 'refresh',
		)
);

$wtr_Color_38 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_38',
		'default'		=> '#000000',
		'control_args'	=> array( 'label' 	=> __( 'Second overlay background color for elemnts and text holders', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.wtrDSEventItem:hover .wtrDSItemContainer, .wtrDSItem:hover .wtrDSItemContainer, .wtrShtLastNewsModern .wtrShtLastNewsModernBox .wtrPostOverlay, .wtrShtLastNewsMetro .wtrShtLastNewsBoxedOverlay, .wtrShtRoomOverlay, .wtrShtCrewOverlay, .wtrEventStreamItem .wtrPostOverlay, .wtrRelatedPosts .wtrHoverdNewsBox .overlay, .wtrHoverdModernPostBox .wtrPostOverlay',
		'css_style' 	=> 'background-color',
		'css_custom'	=> array( 'type' => 'rgba', 'value'=> '0.3')
		)
);

$wtr_Color_39 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_39',
		'default'		=> '#f5f5f5',
		'control_args'	=> array( 'label' 	=> __( 'Background color for text holder', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.select2-results .select2-highlighted, .wtrShtFullWidthTabs .wtrShtFWT, .wtrShtLinkHedline, .wtrShtTimeTableItem thead, .wtrShtPassDesc, .wtrShtLastNewsMetro .wtrShtLastNewsBoxedItemHolder, .wtrShtEventListTime',
		'css_style' 	=> 'background-color',
		)
);

$wtr_Color_40 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_40',
		'default'		=> '#000000',
		'control_args'	=> array( 'label' 	=> __( 'Background color for clickable elements like arrows in content slider full width tabs container', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '#bbpress-forums #bbp-single-user-details #bbp-user-navigation li.current a, #bbpress-forums li.bbp-footer, #bbp_search, .wtrShtStepByStepInfoNo, .wtrShtLastNewsModern .owl-theme .owl-dots .owl-dot span, .wtrShtWonsterSliderControls:hover span, .wtrShtContentSlider .owl-theme .owl-controls .owl-next, .wtrShtContentSlider .owl-theme .owl-controls .owl-prev, .wtrClinetsCarusel.owl-theme .owl-dots .owl-dot span',
		'css_style' 	=> 'background-color',
		'css_custom'	=> array( 'type' => 'rgba', 'value'=> '0.1'),
		'transport'		=> 'refresh',
		)
);

$wtr_Color_41 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_41',
		'default'		=> '#000000',
		'control_args'	=> array( 'label' 	=> __( 'Secondary overlay background color for elements on hover', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.wtrDSItemContainer, .wtrShtBoxedEventsOverlay, .wtrShtPromoEventOverlay, .wtrShtLastNewsStandard .wtrShtLastNewsStandardBox:hover .wtrShtLastNewsStandardOverlay, .wtrShtLastNewsModern .wtrShtLastNewsModernBox:hover .wtrPostOverlay, .wtrShtLastNewsMetro .wtrShtLastNewsBoxedItemHolder:hover .wtrShtLastNewsBoxedOverlay, .wtrShtLastNewsListOverlay, .wtrShtTrainerOverlay, .wtrCrewItemContainer:hover .wtrShtCrewOverlay, .wtrShtInstagramGalleryItemOverlay, .wtrHoverdPostBox:hover .wtrPostOverlay, .wtrEventStreamItemNoPhoto:hover, .wtrEventStreamItem:hover .wtrPostOverlay',
		'css_style' 	=> 'background-color',
		'css_custom'	=> array( 'type' => 'rgba', 'value'=> '0.6'),
		'transport'		=> 'refresh',
		)
);

$wtr_Color_42 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_42',
		'default'		=> '#e5e5e5',
		'control_args'	=> array( 'label' 	=> __( 'Border color for input fields', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '#bbpress-forums #bbp-search-form #bbp_search, #bbpress-forums fieldset.bbp-form select, #new-post input, #bbpress-forums div.bbp-the-content-wrapper input, #bbpress-forums #bbp-your-profile fieldset input, #bbpress-forums #bbp-your-profile fieldset textarea, .select2-search input, #calc_shipping_state_field, #calc_shipping_country_field, .select2-container .select2-choice, .woocommerce form .form-row.woocommerce-validated .select2-container, .woocommerce form .form-row.woocommerce-validated input.input-text, .woocommerce form .form-row.woocommerce-validated select, .woocommerce #review_form #respond textarea, .woocommerce #content table.cart td.actions .coupon .input-text, .woocommerce table.cart td.actions .coupon .input-text, .woocommerce form.checkout_coupon, .woocommerce form.login, .woocommerce form.register, .woocommerce .comment-form input, .woocommerce #review_form #respond textarea, .woocommerce form .form-row input.input-text, .woocommerce form .form-row textarea, .woocommerce .quantity, .woocommerce .quantity .minus, .woocommerce .quantity .plus, .woocommerce .quantity input.qty, .woocommerce #content .quantity input.qty, .woocommerce #content .quantity, .woocommerce #content .quantity .minus, .woocommerce #content .quantity .plus, .woocommerce-page #review_form #respond textarea, .woocommerce-page #content table.cart td.actions .coupon .input-text, .woocommerce-page table.cart td.actions .coupon .input-text, .woocommerce-page form.checkout_coupon, .woocommerce-page form.login, .woocommerce-page form.register, .woocommerce-page form .form-row input.input-text, .woocommerce-page form .form-row textarea, .woocommerce-page #content .quantity input.qty, .woocommerce-page .quantity input.qty, .woocommerce-page #content .quantity, .woocommerce-page #content .quantity .minus, .woocommerce-page #content .quantity .plus, .woocommerce-page .quantity .minus, .woocommerce-page .quantity .plus, .woocommerce-page .quantity, /* WooCommerce */ .wpcf7 input[type="date"], .wpcf7 input[type="tel"], .wpcf7 input[type="url"], .wpcf7 input[type="email"], .wpcf7 input[type="text"], .wpcf7 input[type="number"], .wpcf7 textarea, .wtrCommentList .comment-form, .wtrCommentList textarea, .wtrCommentList input, .wtrCommentList #respond input[type="text"], .wtrSearchFormAlter input[type="text"], .wtrPassProtectedContent input[type="password"], .wtrDefInputColor',
		'css_style' 	=> 'border-color',
		)
);

$wtr_Color_43 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_43',
		'default'		=> '#ffffff',
		'control_args'	=> array( 'label' 	=> __( 'Background color for input fields', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '#bbpress-forums #bbp-search-form #bbp_search, #bbpress-forums fieldset.bbp-form select, #new-post input, #bbpress-forums div.bbp-the-content-wrapper input, #bbpress-forums fieldset.bbp-form textarea, #bbpress-forums fieldset.bbp-form select, #bbpress-forums fieldset.bbp-form input, #bbpress-forums #bbp-your-profile fieldset input, #bbpress-forums #bbp-your-profile fieldset textarea, .select2-results .select2-ajax-error, .select2-results .select2-no-results, .select2-results .select2-searching, .select2-results .select2-selection-limit, .select2-search input, .select2-drop, .select2-results, .select2-container .select2-choice, #calc_shipping_state_field, #calc_shipping_country_field, .woocommerce-ordering, .woocommerce #review_form #respond textarea, .woocommerce #content table.cart td.actions .coupon .input-text, .woocommerce table.cart td.actions .coupon .input-text, .woocommerce form.checkout_coupon, .woocommerce form.login, .woocommerce form.register, .woocommerce .comment-form input, .woocommerce #review_form #respond textarea, .woocommerce form .form-row input.input-text, .woocommerce form .form-row textarea, .woocommerce .quantity, .woocommerce .quantity .minus, .woocommerce .quantity .plus, .woocommerce .quantity input.qty, .woocommerce #content .quantity input.qty, .woocommerce #content .quantity, .woocommerce #content .quantity .minus, .woocommerce #content .quantity .plus, .woocommerce-page .wtrContainer #content .quantity .minus:hover, .woocommerce-page .wtrContainer #content .quantity .plus:hover, .woocommerce-page .wtrContainer .quantity .minus:hover, .woocommerce-page .wtrContainer .quantity .plus:hover, .woocommerce-page #review_form #respond textarea, .woocommerce-page #content table.cart td.actions .coupon .input-text, .woocommerce-page table.cart td.actions .coupon .input-text, .woocommerce-page form.checkout_coupon, .woocommerce-page form.login, .woocommerce-page form.register, .woocommerce-page form .form-row input.input-text, .woocommerce-page form .form-row textarea, .woocommerce-page #content .quantity input.qty, .woocommerce-page .quantity input.qty, .woocommerce-page #content .quantity, .woocommerce-page #content .quantity .minus, .woocommerce-page #content .quantity .plus, .woocommerce-page .quantity .minus, .woocommerce-page .quantity .plus, .woocommerce-page .quantity, /* WooCommerce */ .wpcf7 input[type="date"], .wpcf7 input[type="tel"], .wpcf7 input[type="url"], .wpcf7 input[type="email"], .wpcf7 input[type="text"], .wpcf7 input[type="number"], .wpcf7 textarea, .wtrCommentList .comment-form, .wtrCommentList textarea, .wtrCommentList input, .wtrCommentList #respond input[type="text"], .wtrSearchFormAlter input[type="text"], .wtrPassProtectedContent input[type="password"], .wtrDefInputColor',
		'css_style' 	=> 'background-color',
		'css_important'	=> true,
		'transport'		=> 'refresh',
		)
);

$wtr_Color_44 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_44',
		'default'		=> '#555555',
		'control_args'	=> array( 'label' 	=> __( 'Font color for input fields', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '#bbpress-forums fieldset.bbp-form textarea, #bbpress-forums #bbp-search-form #bbp_search, #bbpress-forums fieldset.bbp-form select, #new-post input, #bbpress-forums div.bbp-the-content-wrapper input, #bbpress-forums #bbp-your-profile fieldset input, #bbpress-forums #bbp-your-profile fieldset textarea, .select2-results .select2-ajax-error, .select2-results .select2-no-results, .select2-results .select2-searching, .select2-results .select2-selection-limit, .select2-search input, .select2-drop, #calc_shipping_state_field select, #calc_shipping_country_field select, a.select2-choice span.select2-chosen, .woocommerce #review_form #respond textarea, .woocommerce #content table.cart td.actions .coupon .input-text, .woocommerce table.cart td.actions .coupon .input-text, .woocommerce form.checkout_coupon, .woocommerce form.login, .woocommerce form.register, .woocommerce .comment-form input, .woocommerce #review_form #respond textarea, .woocommerce form .form-row input.input-text, .woocommerce form .form-row textarea, .woocommerce .quantity, .woocommerce .quantity .minus, .woocommerce .quantity .plus, .woocommerce .quantity input.qty, .woocommerce #content .quantity input.qty, .woocommerce #content .quantity, .woocommerce #content .quantity .minus, .woocommerce #content .quantity .plus, .woocommerce-page #review_form #respond textarea, .woocommerce-page #content table.cart td.actions .coupon .input-text, .woocommerce-page table.cart td.actions .coupon .input-text, .woocommerce-page form.checkout_coupon, .woocommerce-page form.login, .woocommerce-page form.register, .woocommerce-page form .form-row input.input-text, .woocommerce-page form .form-row textarea, .woocommerce-page #content .quantity input.qty, .woocommerce-page .quantity input.qty, .woocommerce-page #content .quantity, .woocommerce-page #content .quantity .minus, .woocommerce-page #content .quantity .plus, .woocommerce-page .quantity .minus, .woocommerce-page .quantity .plus, .woocommerce-page .quantity, /* WooCommerce */ .wpcf7 input[type="date"], .wpcf7 input[type="tel"], .wpcf7 input[type="url"], .wpcf7 input[type="email"], .wpcf7 input[type="text"], .wpcf7 input[type="number"], .wpcf7 textarea, .wtrCommentList .comment-form, .wtrCommentList textarea, .wtrCommentList input, .wtrCommentList #respond input[type="text"], .wtrSearchFormAlter input[type="text"], .wtrPassProtectedContent input[type="password"], .wtrDefInputColor',
		'css_style' 	=> 'color',
		)
);

$wtr_Color_45 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_45',
		'default'		=> '#1fce6d',
		'control_args'	=> array( 'label' 	=> __( 'Background color for primary buttons', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.bbp-submit-wrapper button#bbp_topic_submit, .bbp-submit-wrapper button#bbp_reply_submit, .wtrShtPayPal.light .wtrShtPPPriceBtn, .wtrPayPal .wtrPayPalBtnAct:hover, .wtrPLPayPalBtnAct:hover, .wtrEPPayPalBtnAct:hover, .wtrCPPayPalBtnAct, .wtrShtLastNewsStandard a.wtrButtonStd.green, .woocommerce .wtrContainer  #content input.button.alt, .woocommerce .wtrContainer  #respond input#submit.alt, .woocommerce .wtrContainer  a.button.alt, .woocommerce .wtrContainer  button.button.alt, .woocommerce .wtrContainer  input.button.alt, .woocommerce-page .wtrContainer  #content input.button.alt, .woocommerce-page .wtrContainer  #respond input#submit.alt, .woocommerce-page .wtrContainer  a.button.alt, .woocommerce-page .wtrContainer  button.button.alt, .woocommerce-page .wtrContainer  input.button.alt, .woocommerce .wtrContainer  button.single_add_to_cart_button, /* WooCommerce */ .wtrShtTimeTable .wtrShtTimeTableHeadlinePeriod, .wtrShtTimeTable .wtrShtTimeTableBtn, .wtrTimeTableClassesCategory, .wtrClassDetailsModalClassBtn, .wpcf7 input[type="submit"], .wtrShtPromoEventBtn, .wtrPaginationList li .active, .wtrPaginationList li a:hover, .wtrSmartNavigation .dl-menuwrapper .dl-trigger, .wtrHoverdPostButtonContainer .wtrButtonStd, .wtrCommentList #respond #submit, .wtrPassProtectedContent input[type="submit"], .wtrDefStdButton',
		'css_style' 	=> 'background-color',
		'css_important'	=> true,
		'transport'		=> 'refresh',
		)
);

$wtr_Color_46 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_46',
		'default'		=> '#ffffff',
		'control_args'	=> array( 'label' 	=> __( 'Font color for primary buttons', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.bbp-submit-wrapper button#bbp_topic_submit, .bbp-submit-wrapper button#bbp_reply_submit, .wtrShtPayPal.light .wtrShtPPPriceBtn, .wtrPayPal .wtrPayPalBtnAct:hover, .wtrPLPayPalBtnAct:hover, .wtrEPPayPalBtnAct:hover, .wtrCPPayPalBtnAct, .wtrShtLastNewsStandard a.wtrButtonStd.green, .woocommerce .wtrContainer  #content input.button.alt, .woocommerce .wtrContainer  #respond input#submit.alt, .woocommerce .wtrContainer  a.button.alt, .woocommerce .wtrContainer  button.button.alt, .woocommerce .wtrContainer  input.button.alt, .woocommerce-page .wtrContainer  #content input.button.alt, .woocommerce-page .wtrContainer  #respond input#submit.alt, .woocommerce-page .wtrContainer  a.button.alt, .woocommerce-page .wtrContainer  button.button.alt, .woocommerce-page .wtrContainer  input.button.alt, .woocommerce .wtrContainer  button.single_add_to_cart_button, /* WooCommerce */ .wtrShtTimeTable .wtrShtTimeTableHeadlinePeriod, .wtrShtTimeTable .wtrShtTimeTableBtn, .wtrTimeTableClassesCategory, .wtrClassDetailsModalClassBtn, .wpcf7 input[type="submit"], .wtrShtPromoEventBtn, .wtrPaginationList li .active, .wtrPaginationList li a:hover, .wtrSmartNavigation .dl-menuwrapper .dl-trigger, .wtrHoverdPostButtonContainer .wtrButtonStd, .wtrCommentList #respond #submit, .wtrPassProtectedContent input[type="submit"], .wtrDefStdButton',
		'css_style' 	=> 'color',
		'transport'		=> 'refresh',
		)
);

$wtr_Color_47 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_47',
		'default'		=> '#27ae60',
		'control_args'	=> array( 'label' 	=> __( 'Background color for primary buttons on hover', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.bbp-submit-wrapper button#bbp_topic_submit:hover, .bbp-submit-wrapper button#bbp_reply_submit:hover, .wtrShtPayPal.light .wtrShtPPPriceBtn:hover, .wtrShtPPPriceBtn, .wtrPayPal .wtrPayPalBtnAct, .wtrPLPayPalBtnAct, .wtrEPPayPalBtnAct, .wtrCPPayPalBtnAct:hover, .wtrSidebar.wtrSidebarWdg .widget_price_filter .ui-slider .ui-slider-handle, .woocommerce .wtrContainer #content input.button.alt:hover, .woocommerce .wtrContainer #respond input#submit.alt:hover, .woocommerce .wtrContainer a.button.alt:hover, .woocommerce .wtrContainer button.button.alt:hover, .woocommerce .wtrContainer input.button.alt:hover, .woocommerce-page .wtrContainer #content input.button.alt:hover, .woocommerce-page .wtrContainer #respond input#submit.alt:hover, .woocommerce-page .wtrContainer a.button.alt:hover, .woocommerce-page .wtrContainer button.button.alt:hover, .woocommerce-page .wtrContainer input.button.alt:hover, /* WooCommerce */ .wtrShtTimeTable .wtrShtTimeTableBtn:hover, .wtrTimeTableClassesCategory:hover, .wtrClassDetailsModalClassBtn:hover, .wpcf7 input[type="submit"]:hover, .wtrShtPromoEventBtn:hover, .wtrHoverdPostButtonContainer .wtrButtonStd:hover, .wtrCommentList #respond #submit:hover, .wtrPassProtectedContent input[type="submit"]:hover, .wtrDefStdButton:hover',
		'css_style' 	=> 'background-color',
		'css_important'	=> true,
		'transport'		=> 'refresh',
		)
);

$wtr_Color_48 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_48',
		'default'		=> '#ffffff',
		'control_args'	=> array( 'label' 	=> __( 'Font color for primary buttons on hover ', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.bbp-submit-wrapper button#bbp_topic_submit:hover, .bbp-submit-wrapper button#bbp_reply_submit:hover, .wtrShtPayPal.light .wtrShtPPPriceBtn:hover, .wtrShtPPPriceBtn, .wtrPayPal .wtrPayPalBtnAct, .wtrPLPayPalBtnAct, .wtrEPPayPalBtnAct, .wtrCPPayPalBtnAct:hover, .woocommerce .wtrContainer #content input.button.alt:hover, .woocommerce .wtrContainer #respond input#submit.alt:hover, .woocommerce .wtrContainer a.button.alt:hover, .woocommerce .wtrContainer button.button.alt:hover, .woocommerce .wtrContainer input.button.alt:hover, .woocommerce-page .wtrContainer #content input.button.alt:hover, .woocommerce-page .wtrContainer #respond input#submit.alt:hover, .woocommerce-page .wtrContainer a.button.alt:hover, .woocommerce-page .wtrContainer button.button.alt:hover, .woocommerce-page .wtrContainer input.button.alt:hover, /* WooCommerce */ .wtrShtTimeTable .wtrShtTimeTableBtn, .wtrTimeTableClassesCategory:hover, .wtrClassDetailsModalClassBtn:hover, .wpcf7 input[type="submit"]:hover, .wtrShtPromoEventBtn:hover, .wtrHoverdPostButtonContainer .wtrButtonStd:hover, .wtrCommentList #respond #submit:hover, .wtrPassProtectedContent input[type="submit"]:hover, .wtrDefStdButton:hover',
		'css_style' 	=> 'color',
		'transport'		=> 'refresh',
		)
);

$wtr_Color_49 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_49',
		'default'		=> '#efefef',
		'control_args'	=> array( 'label' 	=> __( 'Background color for secondary buttons', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.woocommerce #content nav.woocommerce-pagination ul li a, .woocommerce #content nav.woocommerce-pagination ul li span, .woocommerce nav.woocommerce-pagination ul li a, .woocommerce nav.woocommerce-pagination ul li span, .woocommerce-page #content nav.woocommerce-pagination ul li a, .woocommerce-page #content nav.woocommerce-pagination ul li span, .woocommerce-page nav.woocommerce-pagination ul li a, .woocommerce-page nav.woocommerce-pagination ul li span, .woocommerce #content input.button, .woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .woocommerce-page #content input.button, .woocommerce-page #respond input#submit, .woocommerce-page a.button, .woocommerce-page button.button, .woocommerce-page input.button, .woocommerce .wtrContainer #content input.button, .woocommerce .wtrContainer #respond input#submit, .woocommerce .wtrContainer a.button, .woocommerce .wtrContainer button.button, .woocommerce .wtrContainer input.button, .woocommerce-page .wtrContainer #content input.button, .woocommerce-page .wtrContainer #respond input#submit, .woocommerce-page .wtrContainer a.button, .woocommerce-page .wtrContainer button.button, .woocommerce-page .wtrContainer input.button, /* WooCommerce */ .wtrShtLastNewsStandard .wtrShtLastNewsStandardOtherLink, .wtrPaginationList li a, .wtrEventEntryMetaFacebook, .wtrEventEntryMetaGoogle, .wtrRelatedPosts .owl-theme .owl-dots .owl-dot span, .wtrRelatedPosts .owl-controls, .wtrFacebookShare, .wtrTwitterShare, .wtrPinterestShare, .wtrTumblrShare, .wtrGoogleShare, .wtrBlogDfPostOtherLink, .wtrCommentList .comment .reply a',
		'css_style' 	=> 'background-color',
		'css_important'	=> true,
		)
);

$wtr_Color_50 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_50',
		'default'		=> '#555555',
		'control_args'	=> array( 'label' 	=> __( 'Font color for secondary buttons', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.woocommerce #content nav.woocommerce-pagination ul li a, .woocommerce #content nav.woocommerce-pagination ul li span, .woocommerce nav.woocommerce-pagination ul li a, .woocommerce nav.woocommerce-pagination ul li span, .woocommerce-page #content nav.woocommerce-pagination ul li a, .woocommerce-page #content nav.woocommerce-pagination ul li span, .woocommerce-page nav.woocommerce-pagination ul li a, .woocommerce-page nav.woocommerce-pagination ul li span, .woocommerce #content input.button, .woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .woocommerce-page #content input.button, .woocommerce-page #respond input#submit, .woocommerce-page a.button, .woocommerce-page button.button, .woocommerce-page input.button, .woocommerce .wtrContainer #content input.button, .woocommerce .wtrContainer #respond input#submit, .woocommerce .wtrContainer a.button, .woocommerce .wtrContainer button.button, .woocommerce .wtrContainer input.button, .woocommerce-page .wtrContainer #content input.button, .woocommerce-page .wtrContainer #respond input#submit, .woocommerce-page .wtrContainer a.button, .wtrContainer .woocommerce p a.button, .woocommerce-page .wtrContainer button.button, .woocommerce-page .wtrContainer input.button, /* WooCommerce */ .wtrShtLastNewsStandard .wtrShtLastNewsStandardOtherLink, .wtrPostAuthorSocialLink:hover, .wtrRelatedPosts .owl-prev:hover:after, .wtrRelatedPosts .owl-next:hover:after, .wtrPaginationList li a, .wtrEventEntryMetaFacebook, .wtrEventEntryMetaGoogle, .wtrRelatedPosts .owl-theme .owl-dots .owl-dot span, .wtrRelatedPosts .owl-controls, .wtrFacebookShare, .wtrTwitterShare, .wtrPinterestShare, .wtrTumblrShare, .wtrGoogleShare, .wtrBlogDfPostOtherLink, .wtrCommentList .comment .reply a',
		'css_style' 	=> 'color',
		'transport'		=> 'refresh',
		)
);

$wtr_Color_51 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_51',
		'default'		=> '#1fce6d',
		'control_args'	=> array( 'label' 	=> __( 'Background color for secondary buttons on hover', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.woocommerce #content nav.woocommerce-pagination ul li a:focus, .woocommerce #content nav.woocommerce-pagination ul li a:hover, .woocommerce #content nav.woocommerce-pagination ul li span.current, .woocommerce nav.woocommerce-pagination ul li a:focus, .woocommerce nav.woocommerce-pagination ul li a:hover, .woocommerce nav.woocommerce-pagination ul li span.current, .woocommerce-page #content nav.woocommerce-pagination ul li a:focus, .woocommerce-page #content nav.woocommerce-pagination ul li a:hover, .woocommerce-page #content nav.woocommerce-pagination ul li span.current, .woocommerce-page nav.woocommerce-pagination ul li a:focus, .woocommerce-page nav.woocommerce-pagination ul li a:hover, .woocommerce-page nav.woocommerce-pagination ul li span.current, .woocommerce #content nav.woocommerce-pagination ul li a:hover, .woocommerce #content nav.woocommerce-pagination ul li span:hover, .woocommerce nav.woocommerce-pagination ul li a:hover, .woocommerce nav.woocommerce-pagination ul li span:hover, .woocommerce-page #content nav.woocommerce-pagination ul li a:hover, .woocommerce-page #content nav.woocommerce-pagination ul li span:hover, .woocommerce-page nav.woocommerce-pagination ul li a:hover, .woocommerce-page nav.woocommerce-pagination ul li span:hover, .woocommerce #content input.button:hover, .woocommerce #respond input#submit:hover, .woocommerce a.button:hover, .woocommerce button.button:hover, .woocommerce input.button:hover .woocommerce-page #content input.button:hover, .woocommerce-page #respond input#submit:hover, .woocommerce-page a.button:hover, .woocommerce-page button.button:hover, .woocommerce-page input.button:hover, .woocommerce .wtrContainer #content input.button:hover, .woocommerce .wtrContainer #respond input#submit:hover, .woocommerce .wtrContainer a.button:hover, .woocommerce .wtrContainer button.button:hover, .woocommerce .wtrContainer input.button:hover, .woocommerce-page .wtrContainer #content input.button:hover, .woocommerce-page .wtrContainer #respond input#submit:hover, .woocommerce-page .wtrContainer a.button:hover, .woocommerce-page .wtrContainer button.button:hover, .woocommerce-page .wtrContainer input.button:hover, /* WooCommerce */ .wtrShtLastNewsStandard .wtrShtLastNewsStandardOtherLink:hover, .wtrRelatedPosts .owl-theme .owl-dots .owl-dot.active span, .wtrRelatedPosts .owl-theme .owl-dots .owl-dot:hover span, .wtrCommentList .comment .reply a:hover, .wtrBlogDfPostOtherLink:hover',
		'css_style' 	=> 'background-color',
		'css_important'	=> true,
		'transport'		=> 'refresh',
		)
);

$wtr_Color_52 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_52',
		'default'		=> '#ffffff',
		'control_args'	=> array( 'label' 	=> __( 'Font color for secondary buttons on hover', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.woocommerce #content nav.woocommerce-pagination ul li a:focus, .woocommerce #content nav.woocommerce-pagination ul li a:hover, .woocommerce #content nav.woocommerce-pagination ul li span.current, .woocommerce nav.woocommerce-pagination ul li a:focus, .woocommerce nav.woocommerce-pagination ul li a:hover, .woocommerce nav.woocommerce-pagination ul li span.current, .woocommerce-page #content nav.woocommerce-pagination ul li a:focus, .woocommerce-page #content nav.woocommerce-pagination ul li a:hover, .woocommerce-page #content nav.woocommerce-pagination ul li span.current, .woocommerce-page nav.woocommerce-pagination ul li a:focus, .woocommerce-page nav.woocommerce-pagination ul li a:hover, .woocommerce-page nav.woocommerce-pagination ul li span.current, .woocommerce #content nav.woocommerce-pagination ul li a:hover, .woocommerce #content nav.woocommerce-pagination ul li span:hover, .woocommerce nav.woocommerce-pagination ul li a:hover, .woocommerce nav.woocommerce-pagination ul li span:hover, .woocommerce-page #content nav.woocommerce-pagination ul li a:hover, .woocommerce-page #content nav.woocommerce-pagination ul li span:hover, .woocommerce-page nav.woocommerce-pagination ul li a:hover, .woocommerce-page nav.woocommerce-pagination ul li span:hover, .woocommerce #content input.button:hover, .woocommerce #respond input#submit:hover, .woocommerce a.button:hover, .woocommerce button.button:hover, .woocommerce input.button:hover .woocommerce-page #content input.button:hover, .woocommerce-page #respond input#submit:hover, .woocommerce-page a.button:hover, .woocommerce-page button.button:hover, .woocommerce-page input.button:hover, .woocommerce .wtrContainer #content input.button:hover, .woocommerce .wtrContainer #respond input#submit:hover, .woocommerce .wtrContainer a.button:hover, .woocommerce .wtrContainer button.button:hover, .woocommerce .wtrContainer input.button:hover, .woocommerce-page .wtrContainer #content input.button:hover, .woocommerce-page .wtrContainer #respond input#submit:hover, .woocommerce-page .wtrContainer a.button:hover, .woocommerce-page .wtrContainer button.button:hover, .woocommerce-page .wtrContainer input.button:hover, /* WooCommerce */ .wtrShtLastNewsStandard .wtrShtLastNewsStandardOtherLink:hover, .wtrRelatedPosts .owl-theme .owl-dots .owl-dot.active span, .wtrRelatedPosts .owl-theme .owl-dots .owl-dot:hover span, .wtrCommentList .comment .reply a:hover, .wtrBlogDfPostOtherLink:hover',
		'css_style' 	=> 'color',
		'transport'		=> 'refresh',
		)
);

$wtr_Color_53 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_53',
		'default'		=> '#555555',
		'control_args'	=> array( 'label' 	=> __( 'Text link font color', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '#bbpress-forums #bbp-single-user-details #bbp-user-navigation a, #bbpress-forums .bbp-topic-freshness a, #bbpress-forums .bbp-body a.bbp-author-name, #bbpress-forums div.bbp-topic-tags a, ul.bbp-forums .bbp-forum-content, .wtrPageContent #bbpress-forums .topic p a, #bbpress-forums .bbp-forums .bbp-forum-freshness a, #bbpress-forums .bbp-forums .bbp-forum-freshness .bbp-topic-meta a.bbp-author-name, #bbpress-forums .bbp-forums .bbp-forum-content a, #bbpress-forums .bbp-breadcrumb p a, .bbp-forum-info a.bbp-forum-title, .bbp-topics li.bbp-topic-title a.bbp-topic-permalink, .bbp-topic-reply-count, .bbp-topic-voice-count, .bbp-forum-topic-count, .bbp-forum-reply-count, .wtrCommentList .comment-navigation a, .comment-edit-link, p.myaccount_user a, .login .lost_password a, .entry-summary .product_meta .posted_in a, .entry-summary .product_meta .tagged_as a, .woocommerce a.wc-forward, .woocommerce .woocommerce-review-link, .woocommerce .shop_table a, .woocommerce .order_details a, .woocommerce .woocommerce-error a, .woocommerce .woocommerce-info a, .woocommerce .woocommerce-message a, .woocommerce-page .woocommerce-error a, .woocommerce-page .woocommerce-info a, .woocommerce-page .woocommerce-message a, /* WooCommerce */ .wtrEventEntryCategoryItem, .wtrEventEntryCategoryItem a, .wtrClassesTrainerItemLink, .wtrNoItemStreamHeadline, .wtrEventCategoryItem a, .wtrBlogDfPostCategoryItem a, .wtrCommentList #respond .logged-in-as a, .wtrDefBorderLink, .wtrCommentList .trackback .comment-meta a, .wtrCommentList .pingback .comment-meta a, .woocommerce a.chosen-single, .woocommerce-info a',
		'css_style' 	=> 'color',
		'css_important'	=> true,
		)
);

$wtr_Color_54 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_54',
		'default'		=> '#999999',
		'control_args'	=> array( 'label' 	=> __( 'Third font color', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.bbp-user-section .bbp-reply-header, .bbp-user-section .bbp-reply-header a, .bbp-reply-header .bbp-reply-post-date, .bbp-forum-header a.bbp-forum-permalink, .bbp-topic-header a.bbp-topic-permalink, .bbp-reply-header a.bbp-reply-permalink, .bbp-footer, #bbpress-forums fieldset.bbp-form legend, .bbp-header .bbp-reply-content, .bbp-header .bbp-reply-author, .bbp-forum-info, .bbp-forum-topic-count, .bbp-forum-reply-count, .bbp-forum-freshness, .forum-titles li, #subscription-toggle, .wtrSearchResultMetaList li, .wtrSearchResultMetaList li a, .wtrShtAccordionHeadline, .wtrShtFullWidthTabs .wtrShtFWT li a, .wtrShtLinkHedline, .wtrDailyScheduleHeadlineAddText, .wtrDailyScheduleName, .wtrShtMobileTimeTableHeadline span, .wtrShtMobileTimeTableEventHeadline, .wtrClassDetailsModalMetaHeadline, .wtrClassDetailsModalClassTime, .wtrShtTabs li, .wtrShtPromoEventDate, .wtrShtPromoEventAdditional, .wtrShtLastNewsListItemAuthor a, .wtrShtLastNewsListItemDate div, .wtrShtLastNewsListCommentsName, .wtrShtAccordion ul .wtrShtAccordionItem > .wtrShtAccordionHeadline .wtrShtAccordionNavi:after, .wtrShtTestimonialRot .wtrShtTestimonialStdAuthorName, .wtrShtOpenHoursItemShedule, .wtrShtPassDesc, .wtrShtMobileTimeTableClass:after, .wtrShtTimeTableEvent .wtrShtTimeTableEventHeadline, .wtrShtTimeTableItem tbody td .wtrShtTimeTableEntryTime, .wtrShtTimeTableItem thead th .wtrShtTimeTableHead, .wtrShtTestimonialStd .wtrShtTestimonialStdAuthorName, .woocommerce #content div.product p.price del, .woocommerce #content div.product span.price del, .woocommerce div.product p.price del, .woocommerce div.product span.price del, .woocommerce-page #content div.product p.price del, .woocommerce-page #content div.product span.price del, .woocommerce-page div.product p.price del, .woocommerce-page div.product span.price del, .woocommerce #payment div.payment_box p, .woocommerce-page #payment div.payment_box p, .woocommerce ul.products li.product .price del, .woocommerce-page ul.products li.product .price del, .wtrPostAuthorSocialLink, .wtrRelatedPosts .owl-next, .wtrRelatedPosts .owl-prev, .commentsClosed, .woocommerce a.about_paypal, .wtrShtPassesList.wtrShtPassesListLight .wtrShtPassesListHeadline .wtrShtPassesListNavi:after',
		'css_important'	=> true,
		'css_style' 	=> 'color',
		)
);

$wtr_Color_55 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_55',
		'default'		=> '#ffffff',
		'control_args'	=> array( 'label' 	=> __( 'Border color for valid elements on colored backgrounds like avatars, pagination dots', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.wtrShtBoxedEventPrice, .wtrShtLastNewsModern .wtrShtLastNewsModernBoxAuthorImg, .wtrCrewItemPictureContainer .wtrCrewItemPicture, .wtrShtWonsterSliderDotsContainer .wtrShtWonsterSliderDots li span, .wtrShtTestimonialStdAuthorPicContainer .wtrShtTestimonialStdAuthorPic, .wtrShtSliderGallery .flex-control-paging li a, .wtrCommentList .comment-author .avatar, .wtrClassesTrainerPicture, .wtrTrainerPagePicture, .wtrBlogPostModernSneakPeakAuthorImg, .wtrPostAutorPicture',
		'css_style' 	=> 'border-color',
		)
);


//Sidebar Colors Section
$wtr_Color_56 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_56',
		'default'		=> '#000000',
		'control_args'	=> array( 'label' 	=> __( 'Sidebar - Widget headline font color', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.wtrSidebarWdg .widget h6',
		'css_style' 	=> 'color',
		)
);

$wtr_Color_57 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_57',
		'default'		=> '#000000',
		'control_args'	=> array( 'label' 	=> __( 'Sidebar - Widget primary font color', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.wtrSidebarWdg .widget_price_filter .price_label .from, .wtrSidebarWdg .widget_price_filter .price_label .to, .wtrSidebarWdg .woocommerce ul.cart_list li a, .wtrSidebarWdg .woocommerce ul.product_list_widget li a, .wtrSidebarWdg .woocommerce-page ul.cart_list li a, .wtrSidebarWdg .woocommerce-page ul.product_list_widget li a, .wtrSidebarWdg .cat-item span, .wtrSidebarWdg .total strong, /* WooCOmmerce */ .wtrSidebarWdg .widget_text a, .wtrSidebarWdg .wtrWidgetCountdownHeadline a, .wtrSidebarWdg .wtrWidgetNavigationFirstLvlItem a, .wtrSidebarWdg .wtrWidgetNavigationFirstLvl, .wtrSidebarWdg .wtrWidgetRecentCommLink a, .wtrSidebarWdg .wtrWidgetTrainersLink, .wtrSidebarWdg .wtrWidgetNextForTodayLink, .wtrSidebarWdg .wtrWidgetTestimonialRotItemDesc, .wtrSidebarWdg .wtrWidgetRecentPostHeadline a, .wtrSidebarWdg .wtrWidgetNewsletterInput, .wtrSidebarWdg .wtrWidgetTwitterStreamItemTittle a, .wtrSidebarWdg .widget_rss .rss-date, .wtrSidebarWdg .widget_rss ul li a, .wtrSidebarWdg .widget_rss h6 a.rsswidget, .wtrSidebarWdg .widget_recent_entries ul li a, .wtrSidebarWdg .widget_pages ul li a, .wtrSidebarWdg .widget_categories ul li a, .wtrSidebarWdg .widget_archive ul li a, .wtrSidebarWdg .widget_recent_comments ul li a, .wtrSidebarWdg .widget_nav_menu ul li a, .wtrSidebarWdg #wp-calendar tbody td a, .wtrSidebarWdg #wp-calendar tfoot #next a, .wtrSidebarWdg #wp-calendar tfoot #prev a, .wtrSidebarWdg #wp-calendar caption, .wtrSidebarWdg .wtrWidgetOpenHoursDay',
		'css_style' 	=> 'color',
		)
);

$wtr_Color_58 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_58',
		'default'		=> '#888888',
		'control_args'	=> array( 'label' 	=> __( 'Sidebar - Widget paragraph and lead font color', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.wtrSidebarWdg .widget_layered_nav_filters ul li a, .wtrSidebarWdg .widget_shopping_cart .empty, .wtrSidebarWdg .widget_price_filter .price_label, .wtrSidebarWdg .widget_shopping_cart .cart_list .quantity .amount, .wtrSidebarWdg .woocommerce ul.cart_list del .amount, .wtrSidebarWdg .woocommerce ul.product_list_widget del .amount, .wtrSidebarWdg .woocommerce-page ul.cart_list del .amount, .wtrSidebarWdg .woocommerce-page ul.product_list_widget del .amount, .wtrSidebarWdg del .amount, .wtrSidebarWdg .widget_shopping_cart .quantity, .wtrSidebarWdg .widget_shopping_cart .amount, .wtrSidebarWdg .widget_product_categories .product-categories a, /* WooCOmmerce */ .wtrSidebarWdg .wtrWidgetRecentCommDate, .wtrSidebarWdg .wtrWidgetRecentCommWriter, .wtrSidebarWdg .wtrWidgetMembershipName, .wtrSidebarWdg .wtrWidgetSocialIconLink, .wtrSidebarWdg .wtrWidgetTodayIsDesc, .wtrSidebarWdg .wtrWidgetNewsletterDesc, .wtrSidebarWdg .wtrWidgetTwitterStreamItemTittle, .wtrSidebarWdg .widget_rss ul li, .wtrSidebarWdg #wp-calendar tbody td, .wtrSidebarWdg .widget_text, .wtrSidebarWdg .widget_text p, .wtrSidebarWdg .tagcloud a, .wtrSidebarWdg ul.cart_list li:before, .wtrSidebarWdg ul.product_list_widget li:before, .wtrSidebarWdg ul.cart_list li:before, .wtrSidebarWdg ul.product_list_widget li:before, .wtrSidebarWdg .widget_top_rated_products del, .wtrSidebarWdg .widget_top_rated_products del .amount, .wtrSidebarWdg .widget_recently_viewed_products del, .wtrSidebarWdg .widget_recently_viewed_products del .amount, .wtrSidebarWdg .widget_products del, .wtrSidebarWdg .widget_products del .amount, .wtrSidebarWdg .widget_recent_reviews .reviewer, .wtrSidebarWdg .widget_wtrwidgetpromo p, .wtrSidebarWdg .widget_recent_comments ul li:before, .wtrSidebarWdg .wtrWidgetNavigationSecondLvlItem a, .wtrSidebarWdg .wtrWidgetTrainerHeadline, .wtrSidebarWdg .wtrWidgetNextForTodayMeta, .wtrSidebarWdg .wtrWidgetTestimonialRotItemAuthor, .wtrSidebarWdg .wtrWidgetRecentPostDate, .wtrSidebarWdg .wtrWidgetTwitterStreamItemDate, .wtrSidebarWdg .wtrWidgetOpenHoursTime, .wtrSidebarWdg .widget_recent_entries ul li .post-date, .wtrSidebarWdg .widget_recent_entries ul li a:before, .wtrSidebarWdg .widget_pages ul li.page_item_has_children a, .wtrSidebarWdg .widget_tag_cloud .tagcloud a, .wtrSidebarWdg .widget_categories ul li, .wtrSidebarWdg .widget_archive ul li, .wtrSidebarWdg .widget_recent_comments ul li, .wtrSidebarWdg .widget_nav_menu ul li.menu-item-has-children a, .wtrSidebarWdg #wp-calendar thead th',
		'css_style' 	=> 'color',
		)
);

$wtr_Color_59 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_59',
		'default'		=> '#ffffff',
		'control_args'	=> array( 'label' 	=> __( 'Sidebar - Widget text color for text holders', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.wtrSidebarWdg .widget_price_filter .ui-slider .ui-slider-handle, .wtrSidebarWdg .widget_price_filter .ui-slider .ui-slider-range, .wtrSidebarWdg .widget_price_filter .price_slider_amount .button:hover, .wtrSidebarWdg .price_slider_amount .button:hover, .wtrSidebarWdg .widget_shopping_cart .buttons .button:hover, .wtrSidebarWdg .widget_shopping_cart .buttons .button.checkout, /* WooCOmmerce */ .wtrSidebarWdg .owl-carousel .owl-controls .owl-nav .owl-next:hover:after, .wtrSidebarWdg .owl-carousel .owl-controls .owl-nav .owl-prev:hover:after, .wtrSidebarWdg .wtrWidgetUpcomingEventsHeadline a, .wtrSidebarWdg .wtrWidgetCountdownPrice, .wtrSidebarWdg .wtrWidgetUpcomingEventsDate, .wtrSidebarWdg .wtrWidgetCountdownDate, .wtrSidebarWdg .wtrWidgetCountdown .countdown-period, .wtrSidebarWdg .wtrWidgetCountdown .countdown-amount, .wtrSidebarWdg .wtrWidgetSocialIconLink:hover, .wtrSidebarWdg .wtrWidgetTrainerImgOverlay span:before, .wtrSidebarWdg .wtrWidgetRecentPostImgOverlay span:before, .wtrSidebarWdg .wtrWidgetRecentGalleryOverlay span:before, .wtrSidebarWdg .wtrWidgetTodayIsOpenHours, .wtrSidebarWdg .wtrWidgetOpenIcon, .wtrSidebarWdg .wtrWidgetTagItemLink:hover, .wtrSidebarWdg .wtrWidgetTagItemLink:hover, .wtrSidebarWdg .wtrWidgetUpcomingEventsHeadline a, .wtrSidebarWdg .widget_meta ul li a, .wtrSidebarWdg .widget_wtrwidgetpromo .wtrDefStdButton',
		'css_style' 	=> 'color',
		'css_important'	=> true,
		'transport'		=> 'refresh',
		)
);

$wtr_Color_60 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_60',
		'default'		=> '#ffffff',
		'control_args'	=> array( 'label' 	=> __( 'Sidebar - Widget background color for text holders', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.widget_product_search input[type="search"], .wtrSidebarWdg .widget_product_search input#s, /* WooCommerce */ .wtrSidebarWdg .wtrWidgetNewsletterInput, .wtrSidebarWdg .widget_search input[type="text"]',
		'css_style' 	=> 'background-color',
		)
);

$wtr_Color_61 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_61',
		'default'		=> '#000000',
		'control_args'	=> array( 'label' 	=> __( 'Sidebar - Widget text color for text holders', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.widget_product_search input[type="search"], .wtrSidebarWdg .widget_product_search input#s, /* WooCommerce */ .wtrSidebarWdg .wtrWidgetCountdownHeadline a, .wtrSidebarWdg .wtrWidgetNewsletterInput, .wtrSidebarWdg .widget_search input[type="text"]',
		'css_style' 	=> 'color',
		)
);

$wtr_Color_62 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_62',
		'default'		=> '#1fce6d',
		'control_args'	=> array( 'label' 	=> __( 'Sidebar - Distinctive background color for valid elements and hover for clicable elements', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.wtrSidebarWdg .widget_price_filter .ui-slider .ui-slider-handle, .wtrSidebarWdg .widget_price_filter .ui-slider .ui-slider-range, .wtrSidebarWdg .widget_price_filter .price_slider_amount .button:hover, .wtrSidebarWdg .price_slider_amount .button:hover, .wtrSidebarWdg .widget_shopping_cart .buttons .button:hover, .wtrSidebarWdg .widget_shopping_cart .buttons .button.checkout, /* WooCOmmerce */ .wtrSidebarWdg .wtrWidgetCountdownDate, .wtrSidebarWdg .wtrWidgetCountdown, .wtrSidebarWdg .wtrWidgetNavigationFirstLvlItem:before, .wtrSidebarWdg .wtrWidgetRecentCommLink:before, .wtrSidebarWdg .wtrWidgetTestimonial .wtrShtTestimonialRot .wtrRotProgress, .wtrSidebarWdg .wtrWidgetSocialIconLink:hover, .wtrSidebarWdg .wtrWidgetTodayIsOpenHours, .wtrSidebarWdg .wtrWidgetOpenIcon, .wtrSidebarWdg .wtrWidgetTagItemLink:hover, .wtrSidebarWdg .wtrWidgetUpcomingEventsPrice, .wtrSidebarWdg .wtrWidgetUpcomingEventsHeadline a, .wtrSidebarWdg .wtrWidgetUpcomingEventsRotator .owl-prev:hover, .wtrSidebarWdg .wtrWidgetUpcomingEventsRotator .owl-next:hover, .wtrSidebarWdg .wtrWidgetUpcomingEventsRotator .owl-dots .owl-dot.active span, .wtrSidebarWdg .widget_meta ul, .wtrSidebarWdg .widget_wtrwidgetpromo .wtrDefStdButton',
		'css_style' 	=> 'background-color',
		'css_important'	=> true,
		)
);

$wtr_Color_63 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_63',
		'default'		=> '#000000',
		'control_args'	=> array( 'label' 	=> __( 'Sidebar - Border color', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.widget_product_search input[type="search"], .widget_product_categories .product-categories li, .wtrSidebarWdg .widget_recently_viewed_products ul.product_list_widget li, .wtrSidebarWdg .widget_top_rated_products ul.product_list_widget li, .wtrSidebarWdg .widget_products ul.product_list_widget li, .wtrSidebarWdg .widget_recent_reviews ul.product_list_widget li, .wtrSidebarWdg .widget_recently_viewed_products ul.product_list_widget li, .wtrSidebarWdg .widget_top_rated_products ul.product_list_widget li, .wtrSidebarWdg .widget_products ul.product_list_widget li, .wtrSidebarWdg .widget_recent_reviews ul.product_list_widget li .wtrSidebarWdg .woocommerce .widget_shopping_cart .total, .wtrSidebarWdg .woocommerce-page .widget_shopping_cart .total, .wtrSidebarWdg .woocommerce-page.widget_shopping_cart .total, .wtrSidebarWdg .woocommerce.widget_shopping_cart .total, .wtrSidebarWdg .widget_product_search input#s, /* WooCOmmerce */ .wtrSidebarWdg .wtrWidgetNavigationThirdLvl, .wtrSidebarWdg .wtrWidgetNavigationSecondLvl, .wtrSidebarWdg .wtrWidgetRecentCommList, .wtrSidebarWdg .wtrWidgetMembershipItem, .wtrSidebarWdg .wtrWidgetNextForTodayItem, .wtrSidebarWdg .wtrWidgetTestimonial .wtrShtTestimonialRot .wtrShtTestimonialStdItem, .wtrSidebarWdg .wtrWidgetNewsletterInput, .wtrSidebarWdg .widget_search input[type="text"], .wtrSidebarWdg .widget_recent_entries ul li, .wtrSidebarWdg .widget_pages ul li.page_item_has_children, .wtrSidebarWdg .widget_archive ul li, .wtrSidebarWdg .widget_nav_menu ul li.menu-item-has-children, .wtrSidebarWdg .widget_meta ul li, .wtrSidebarWdg #wp-calendar caption, .wtrSidebarWdg #wp-calendar thead, .wtrSidebarWdg #wp-calendar tbody td, .wtrSidebarWdg #wp-calendar tfoot',
		'css_style' 	=> 'border-color',
		'css_custom'	=> array( 'type' => 'rgba', 'value'=> '0.15')
		)
);

$wtr_Color_64 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_64',
		'default'		=> '#1fce6d',
		'control_args'	=> array( 'label' 	=> __( 'Sidebar - Distinctive color for valid elements, icons and links', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.wtrSidebarWdg .widget_shopping_cart_content .total .amount, .wtrSidebarWdg .woocommerce ul.product_list_widget .amount, .wtrSidebarWdg .woocommerce-page ul.cart_list .amount, .wtrSidebarWdg .woocommerce-page ul.product_list_widget .amount, .wtrSidebarWdg .widget_top_rated_products ins .amount, .wtrSidebarWdg .widget_recently_viewed_products ins .amount, .wtrSidebarWdg .widget_products ins .amount, .wtrSidebarWdg .widget_product_search .screen-reader-text:before, /* WooCOmmerce */ .wtrCommentList em.comment-awaiting-moderation, .wtrSidebarWdg .widget_search label, .wtrSidebarWdg .wtrWidgetMembershipItemPrice, .wtrSidebarWdg .wtrWidgetRecentCommWriter i, .wtrSidebarWdg .wtrWidgetNextForTodayItem:before, .wtrSidebarWdg .wtrWidgetTodayIsLink, .wtrSidebarWdg .wtrWidgetNewsletterPrivacyPolicy, .wtrSidebarWdg .wtrWidgetTwitterStreamItemDate:before, .wtrSidebarWdg .widget_pages ul li a:after, .wtrSidebarWdg .widget_nav_menu ul li a:after',
		'css_style' 	=> 'color',
		)
);

$wtr_Color_65 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_65',
		'default'		=> '#000000',
		'control_args'	=> array( 'label' 	=> __( 'Sidebar - Widget background color for clicable elements', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.wtrSidebarWdg .widget_price_filter .price_slider_wrapper .ui-widget-content, .wtrSidebarWdg .widget_price_filter .price_slider_amount .button, .wtrSidebarWdg .price_slider_amount .button, .wtrSidebarWdg .widget_shopping_cart .buttons .button, /* WooCOmmerce */ .wtrSidebarWdg .widget_wtrwidgetpromo .wtrDefStdButton:hover, .wtrSidebarWdg .wtrWidgetSocialIconLink, .wtrSidebarWdg .wtrWidgetTagItemLink, .wtrSidebarWdg .wtrWidgetUpcomingEventsRotator .owl-nav, .wtrSidebarWdg .wtrWidgetUpcomingEventsRotator .owl-dots .owl-dot span',
		'css_style' 	=> 'background',
		'css_custom'	=> array( 'type' => 'rgba', 'value'=> '0.05'),
		'css_important'	=> true,
		)
);

$wtr_Color_66 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_66',
		'default'		=> '#555555',
		'control_args'	=> array( 'label' 	=> __( 'Sidebar - Widget font color for clicable elements', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.wtrSidebarWdg .widget_price_filter .price_slider_wrapper .ui-widget-content, .wtrSidebarWdg .widget_price_filter .price_slider_amount .button, .wtrSidebarWdg .price_slider_amount .button, .wtrSidebarWdg .widget_shopping_cart .buttons .button, /* WooCOmmerce */ .wtrSidebarWdg .widget_wtrwidgetpromo .wtrDefStdButton:hover, .wtrSidebarWdg .wtrWidgetUpcomingEventsRotator .owl-next:after, .wtrSidebarWdg .wtrWidgetUpcomingEventsRotator .owl-prev:after, .wtrSidebarWdg .wtrWidgetTagItemLink',
		'css_style' 	=> 'color',
		'css_important'	=> true,
		)
);

$wtr_Color_67 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_67',
		'default'		=> '#1fce6d',
		'control_args'	=> array( 'label' 	=> __( 'Sidebar - Widget overlay background color', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.wtrSidebarWdg .wtrWidgetTrainerImgOverlay, .wtrSidebarWdg .wtrWidgetRecentPostImgOverlay, .wtrSidebarWdg .wtrWidgetRecentGalleryOverlay',
		'css_style' 	=> 'background',
		'css_custom'	=> array( 'type' => 'rgba', 'value'=> '0.8')
		)
);

$wtr_Color_68 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_68',
		'default'		=> '#000000',
		'control_args'	=> array( 'label' 	=> __( 'Sidebar - Widget second overlay background color', 'wtr_framework' ) ),
		'control_type'	=> 'color', 'css_selector' 	=> '.wtrSidebarWdg .wtrWidgetCountdownPrice, .wtrSidebarWdg .wtrWidgetUpcomingEventsDate',
		'css_style' 	=> 'background-color',
		'css_custom'	=> array( 'type' => 'rgba', 'value'=> '0.6')
		)
);


//Footer colors Section
$wtr_Color_69 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_69',
		'default'		=> '#ffffff',
		'control_args'	=> array( 'label' 	=> __( 'Foot - Widget headline font color', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.wtrFooterWdg .widget h6',
		'css_style' 	=> 'color',
		)
);

$wtr_Color_70 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_70',
		'default'		=> '#000000',
		'control_args'	=> array( 'label' 	=> __( 'Footer background color', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.wtrFooterColor',
		'css_style' 	=> 'background-color',
		)
);

$wtr_Color_71 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_71',
		'default'		=> '#ffffff',
		'control_args'	=> array( 'label' 	=> __( 'Foot - Widget primary font color', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.wtrFooterWdg .widget_price_filter .price_slider_wrapper .ui-widget-content, .wtrFooterWdg .widget_price_filter .price_slider_amount .button, .wtrFooterWdg .price_slider_amount .button, .wtrFooterWdg .widget_shopping_cart .buttons .button, .wtrFooterWdg .woocommerce ul.cart_list li a, .wtrFooterWdg .woocommerce ul.product_list_widget li a, .wtrFooterWdg .woocommerce-page ul.cart_list li a, .wtrFooterWdg .woocommerce-page ul.product_list_widget li a, .wtrFooterWdg .cat-item span, /* WooCommerce */ .wtrFooterWdg .widget_text a, .wtrFooterWdg #wp-calendar tfoot #next a, .wtrFooterWdg #wp-calendar tfoot #prev a, .wtrFooterWdg #wp-calendar tbody td a, .wtrFooterWdg #wp-calendar caption, .wtrFooterWdg .widget_meta ul li a, .wtrFooterWdg .widget_nav_menu ul li a, .wtrFooterWdg .widget_recent_comments ul li a, .wtrFooterWdg .widget_archive ul li a, .wtrFooterWdg .widget_categories ul li a, .wtrFooterWdg .widget_pages ul li a, .wtrFooterWdg .widget_recent_entries ul li a, .wtrFooterWdg .widget_rss .rss-date, .wtrFooterWdg .widget_rss ul li a, .wtrFooterWdg .widget_rss h6 a.rsswidget, .wtrFooterWdg .wtrWidgetCountdownPrice, .wtrFooterWdg .wtrWidgetUpcomingEventsDate, .wtrFooterWdg .wtrWidgetUpcomingEventsPrice, .wtrFooterWdg .wtrWidgetUpcomingEventsHeadline a, .wtrFooterWdg .wtrWidgetCountdownDate, .wtrFooterWdg .wtrWidgetCountdown .countdown-period, .wtrFooterWdg .wtrWidgetCountdown .countdown-amount, .wtrFooterWdg .wtrWidgetNavigationFirstLvlItem a, .wtrFooterWdg .wtrWidgetNavigationFirstLvl, .wtrFooterWdg .wtrWidgetRecentCommLink a, .wtrFooterWdg .wtrWidgetTrainersLink, .wtrFooterWdg .wtrWidgetTrainerMetaContainer, .wtrFooterWdg .wtrWidgetNextForTodayLink, .wtrFooterWdg .wtrWidgetTestimonialRotItemDesc, .wtrFooterWdg .wtrWidgetRecentPostHeadline a, .wtrFooterWdg .wtrWidgetTodayIsOpenHours, .wtrFooterWdg .wtrWidgetTwitterStreamItemTittle a, .wtrFooterWdg .wtrWidgetOpenHoursDay, .wtrFooterWdg .wtrWidgetOpenIcon',
		'css_style' 	=> 'color',
		)
);

$wtr_Color_72 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_72',
		'default'		=> '#555555',
		'control_args'	=> array( 'label' 	=> __( 'Foot - Widget paragraph and lead font color', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.wtrFooterWdg .widget_price_filter .price_slider_wrapper .ui-widget-content, .wtrFooterWdg .widget_price_filter .price_slider_amount .button, .wtrFooterWdg .price_slider_amount .button, .wtrFooterWdg .widget_shopping_cart .buttons .button, .wtrFooterWdg .widget_layered_nav_filters ul li a, .wtrFooterWdg .widget_shopping_cart .empty, .wtrFooterWdg .widget_price_filter .price_label, .wtrFooterWdg .widget_shopping_cart .total strong, .wtrFooterWdg .widget_shopping_cart .cart_list .quantity .amount, .wtrFooterWdg .woocommerce ul.cart_list del .amount, .wtrFooterWdg .woocommerce ul.product_list_widget del .amount, .wtrFooterWdg .woocommerce-page ul.cart_list del .amount, .wtrFooterWdg .woocommerce-page ul.product_list_widget del .amount, .wtrFooterWdg del .amount, .wtrFooterWdg .widget_shopping_cart .quantity, .wtrFooterWdg .widget_shopping_cart .amount, .wtrFooterWdg .widget_product_categories .product-categories a, .wtrFooterWdg .tagcloud a, .wtrFooterWdg ul.cart_list li:before, .wtrFooterWdg ul.product_list_widget li:before, .wtrFooterWdg ul.cart_list li:before, .wtrFooterWdg ul.product_list_widget li:before, .wtrFooterWdg .widget_top_rated_products del, .wtrFooterWdg .widget_top_rated_products del .amount, .wtrFooterWdg .widget_recently_viewed_products del, .wtrFooterWdg .widget_recently_viewed_products del .amount, .wtrFooterWdg .widget_products del, .wtrFooterWdg .widget_products del .amount, .wtrFooterWdg .widget_recent_reviews .reviewer, /* WooCommerce */ .wtrFooterWdg .widget_wtrwidgetpromo .wtrDefStdButton:hover, .wtrFooterWdg .wtrWidgetTwitterStreamItem .wtrWidgetTwitterStreamItemDate, .wtrFooterWdg #wp-calendar tbody td, .wtrFooterWdg .widget_nav_menu ul li.menu-item-has-children a, .wtrFooterWdg .widget_recent_comments ul li, .wtrFooterWdg .widget_archive ul li, .wtrFooterWdg .widget_categories ul li, .wtrFooterWdg .widget_tag_cloud .tagcloud a, .wtrFooterWdg .widget_pages ul li.page_item_has_children a, .wtrFooterWdg .widget_recent_entries ul li .post-date, .wtrFooterWdg .widget_rss ul li, .wtrFooterWdg .wtrWidgetNavigationSecondLvlItem a, .wtrFooterWdg .wtrWidgetRecentCommDate, .wtrFooterWdg .wtrWidgetRecentCommWriter, .wtrFooterWdg .wtrWidgetTrainerHeadline, .wtrFooterWdg .wtrWidgetMembershipName, .wtrFooterWdg .wtrWidgetNextForTodayMeta, .wtrFooterWdg .wtrWidgetTestimonialRotItemAuthor, .wtrFooterWdg .wtrWidgetRecentPostDate, .wtrFooterWdg .wtrWidgetTodayIsDesc, .wtrFooterWdg .wtrWidgetNewsletterDesc, .wtrFooterWdg .wtrWidgetTwitterStreamItemTittle, .wtrFooterWdg .wtrWidgetOpenHoursTime, .wtrFooterWdg .widget_wtrwidgetpromo, .wtrFooterWdg .widget_wtrwidgetpromo p, .wtrFooterWdg .widget_text, .wtrFooterWdg .widget_text p',
		'css_style' 	=> 'color',
		'css_important'	=> true,
		)
);

$wtr_Color_73 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_73',
		'default'		=> '#ffffff',
		'control_args'	=> array( 'label' 	=> __( 'Foot - Widget background color for text holders', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.wtrFooterWdg .widget_product_search input#s, /* WooCommerce */ .wtrFooterWdg .wtrWidgetCountdownHeadlineContainer, .wtrFooterWdg .wtrWidgetNewsletterInput, .wtrFooterWdg .widget_search input[type="text"], .widget_icl_lang_sel_widget #lang_sel a.lang_sel_sel, .widget_icl_lang_sel_widget #lang_sel ul ul li a:hover, .widget_icl_lang_sel_widget #lang_sel ul ul li a',
		'css_style' 	=> 'background-color',
		)
);

$wtr_Color_74 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_74',
		'default'		=> '#000000',
		'control_args'	=> array( 'label' 	=> __( 'Foot - Widget text color for text holders', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.wtrFooterWdg .widget_product_search input#s, /* WooCommerce */ .wtrFooterWdg .wtrWidgetCountdownHeadline a, .wtrFooterWdg .wtrWidgetNewsletterInput, .wtrFooterWdg .widget_search input[type="text"], .widget_icl_lang_sel_widget #lang_sel a',
		'css_style' 	=> 'color',
		)
);

$wtr_Color_75 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_75',
		'default'		=> '#ffffff',
		'control_args'	=> array( 'label' 	=> __( 'Foot - Widget background color for clicable elements', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.wtrFooterWdg .widget_price_filter .price_slider_wrapper .ui-widget-content, .wtrFooterWdg .widget_price_filter .price_slider_amount .button, .wtrFooterWdg .price_slider_amount .button, .wtrFooterWdg .widget_shopping_cart .buttons .button, .wtrFooterWdg .widget_price_filter .price_slider_wrapper .ui-widget-content, /* WooCommerce */ .wtrFooterWdg .widget_wtrwidgetpromo .wtrDefStdButton:hover, .wtrFooterWdg .wtrWidgetUpcomingEventsRotator .owl-nav, .wtrFooterWdg .wtrWidgetUpcomingEventsRotator .owl-dots .owl-dot span, .wtrFooterWdg .wtrWidgetSocialIconLink, .wtrFooterWdg .wtrWidgetTagItemLink',
		'css_style' 	=> 'background',
		'css_custom'	=> array( 'type' => 'rgba', 'value'=> '0.1'),
		'css_important'	=> true,


		)
);

$wtr_Color_76 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_76',
		'default'		=> '#1fce6d',
		'control_args'	=> array( 'label' 	=> __( 'Foot - Distinctive background color on hover for clicable elements', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.wtrFooterWdg .widget_price_filter .ui-slider .ui-slider-handle, .wtrFooterWdg .widget_price_filter .ui-slider .ui-slider-range, .wtrFooterWdg .widget_price_filter .price_slider_amount .button:hover, .wtrFooterWdg .price_slider_amount .button:hover, .wtrFooterWdg .widget_shopping_cart .buttons .button:hover, .wtrFooterWdg .widget_shopping_cart .buttons .button.checkout, /* WooCommerce */ .wtrFooterWdg .widget_wtrwidgetpromo .wtrDefStdButton, .wtrFooterWdg .widget_meta ul, .wtrFooterWdg .wtrRotProgress, .wtrFooterWdg .wtrWidgetUpcomingEventsPrice, .wtrFooterWdg .wtrWidgetUpcomingEventsHeadline a, .wtrFooterWdg .wtrWidgetUpcomingEventsRotator .owl-prev:hover, .wtrFooterWdg .wtrWidgetUpcomingEventsRotator .owl-next:hover, .wtrFooterWdg .wtrWidgetUpcomingEventsRotator .owl-dots .owl-dot.active span, .wtrFooterWdg .wtrWidgetCountdownDate, .wtrFooterWdg .wtrWidgetCountdown, .wtrFooterWdg .wtrWidgetNavigationFirstLvlItem:before, .wtrFooterWdg .wtrWidgetRecentCommLink:before, .wtrFooterWdg .wtrWidgetTestimonial .wtrShtTestimonialRot .wtrRotProgress, .wtrFooterWdg .wtrWidgetSocialIconLink:hover, .wtrFooterWdg .wtrWidgetTodayIsOpenHours, .wtrFooterWdg .wtrWidgetOpenIcon, .wtrFooterWdg .wtrWidgetTagItemLink:hover',
		'css_style' 	=> 'background-color',
		'css_important'	=> true,
		)
);

$wtr_Color_77 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_77',
		'default'		=> '#ffffff',
		'control_args'	=> array( 'label' 	=> __( 'Foot - Widget text color for clickable elements', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.wtrFooterWdg .widget_price_filter .price_slider_amount .button:hover, .wtrFooterWdg .price_slider_amount .button:hover, .wtrFooterWdg .widget_shopping_cart .buttons .button:hover, .wtrFooterWdg .widget_shopping_cart .buttons .button.checkout, /* WooCommerce */ .wtrFooterWdg .widget_wtrwidgetpromo .wtrDefStdButton, .wtrFooterWdg .wtrWidgetTagItemLink:hover, .wtrFooterWdg .wtrWidgetUpcomingEventsRotator .owl-next:after, .wtrFooterWdg .wtrWidgetUpcomingEventsRotator .owl-prev:after, .wtrFooterWdg .wtrWidgetTrainerImgOverlay span:before, .wtrFooterWdg .wtrWidgetTrainerImgOverlay, .wtrFooterWdg .wtrWidgetRecentPostImgOverlay span:before, .wtrFooterWdg .wtrWidgetRecentPostImgOverlay, .wtrFooterWdg .wtrWidgetRecentGalleryOverlay span:before, .wtrFooterWdg .wtrWidgetRecentGalleryOverlay, .wtrFooterWdg .wtrWidgetSocialIconLink, .wtrFooterWdg .wtrWidgetSocialIconLink:hover, .wtrFooterWdg .wtrWidgetTagItemLink',
		'css_style' 	=> 'color',
		'css_important'	=> true,
		)
);

$wtr_Color_78 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_78',
		'default'		=> '#ffffff',
		'control_args'	=> array( 'label' 	=> __( 'Foot - Border color', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.wtrFooterDivider, .wtrCopyright .wtrInner, .wtrFooterWdg .widget_recently_viewed_products ul.product_list_widget li, .wtrFooterWdg .widget_top_rated_products ul.product_list_widget li, .wtrFooterWdg .widget_products ul.product_list_widget li, .wtrFooterWdg .widget_recent_reviews ul.product_list_widget li, .wtrFooterWdg .widget_recently_viewed_products ul.product_list_widget li, .wtrFooterWdg .widget_top_rated_products ul.product_list_widget li, .wtrFooterWdg .widget_products ul.product_list_widget li, .wtrFooterWdg .widget_recent_reviews ul.product_list_widget li .wtrFooterWdg .woocommerce .widget_shopping_cart .total, .wtrFooterWdg .woocommerce-page .widget_shopping_cart .total, .wtrFooterWdg .woocommerce-page.widget_shopping_cart .total, .wtrFooterWdg .woocommerce.widget_shopping_cart .total, .wtrFooterWdg .widget_product_search input#s, /* WooCommerce */ .wtrFooterWdg #wp-calendar tfoot, .wtrFooterWdg #wp-calendar tbody td, .wtrFooterWdg #wp-calendar thead, .wtrFooterWdg #wp-calendar caption, .wtrFooterWdg .widget_meta ul li, .wtrFooterWdg .widget_nav_menu ul li.menu-item-has-children, .wtrFooterWdg .widget_archive ul li, .wtrFooterWdg .widget_pages ul li.page_item_has_children, .wtrFooterWdg .widget_recent_entries ul li, .wtrFooterWdg .wtrWidgetNavigationThirdLvl, .wtrFooterWdg .wtrWidgetNavigationSecondLvl, .wtrFooterWdg .wtrWidgetRecentCommList, .wtrFooterWdg .wtrWidgetMembershipItem, .wtrFooterWdg .wtrWidgetNextForTodayItem, .wtrFooterWdg .wtrShtTestimonialRot .wtrShtTestimonialStdItem, .widget_icl_lang_sel_widget #lang_sel ul ul, .widget_icl_lang_sel_widget #lang_sel ul ul a, .widget_icl_lang_sel_widget #lang_sel ul ul a:visited',
		'css_style' 	=> 'border-color',
		'css_custom'	=> array( 'type' => 'rgba', 'value'=> '0.15'),
		'css_important'	=> true,
		)
);

$wtr_Color_79 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_79',
		'default'		=> '#1fce6d',
		'control_args'	=> array( 'label' 	=> __( 'Foot - Distinctive color for valid text and links', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.wtrFooterWdg .widget_shopping_cart_content .total .amount, .wtrFooterWdg .woocommerce ul.product_list_widget .amount, .wtrFooterWdg .woocommerce-page ul.cart_list .amount, .wtrFooterWdg .woocommerce-page ul.product_list_widget .amount, .wtrFooterWdg .widget_top_rated_products ins .amount, .wtrFooterWdg .widget_recently_viewed_products ins .amount, .wtrFooterWdg .widget_products ins .amount, .wtrFooterWdg .widget_product_search .screen-reader-text:before, /* WooCommerce */ .wtrFooterWdg .widget_recent_comments ul li:before, .wtrFooterWdg .widget_search label, .wtrFooterWdg #wp-calendar thead th, .wtrFooterWdg .widget_nav_menu ul li a:after, .wtrFooterWdg .widget_pages ul li a:after, .wtrFooterWdg .widget_recent_entries ul li a:before, .wtrFooterWdg .wtrWidgetRecentCommWriter i, .wtrFooterWdg .wtrWidgetMembershipItemPrice, .wtrFooterWdg .wtrWidgetNextForTodayItem:before, .wtrFooterWdg .wtrWidgetTodayIsLink, .wtrFooterWdg .wtrWidgetNewsletterPrivacyPolicy, .wtrFooterWdg .wtrWidgetTwitterStreamItem:before',
		'css_style' 	=> 'color',
		)
);

$wtr_Color_80 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_80',
		'default'		=> '#1fce6d',
		'control_args'	=> array( 'label' 	=> __( 'Foot - Distinctive overlay background color', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.wtrFooterWdg .wtrWidgetCountdownPrice, .wtrFooterWdg .wtrWidgetUpcomingEventsDate, .wtrFooterWdg .wtrWidgetTrainerImgOverlay, .wtrFooterWdg .wtrWidgetRecentPostImgOverlay, .wtrFooterWdg .wtrWidgetRecentGalleryOverlay',
		'css_style' 	=> 'background',
		'css_custom'	=> array( 'type' => 'rgba', 'value'=> '0.8')
		)
);

$wtr_Color_81 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_81',
		'default'		=> '#000000',
		'control_args'	=> array( 'label' 	=> __( 'Copyrights background color', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.wtrCopyrightColor, #lang_sel_footer',
		'css_style' 	=> 'background-color',
		)
);

$wtr_Color_82 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_82',
		'default'		=> '#555555',
		'control_args'	=> array( 'label' 	=> __( 'Copyrights font and link color', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.wtrCopyright a, .wtrCopyright, .wtrCopyright p, #lang_sel_footer ul li a',
		'css_style' 	=> 'color',
		)
);

$wtr_Color_83 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_83',
		'default'		=> '#1fce6d',
		'control_args'	=> array( 'label' 	=> __( 'Copyrights link color on hover', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.wtrCopyright a:hover, #lang_sel_footer ul li a:hover',
		'css_style' 	=> 'color',
		)
);


$wtr_Color_96 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_96',
		'default'		=> '#cccccc',
		'control_args'	=> array( 'label' 	=> __( 'Standard mobile navigation header', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.wtrSimpleMobileHeader',
		'css_style' 	=> 'color',
		)
);

$wtr_Color_97 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_97',
		'default'		=> '#ffffff',
		'control_args'	=> array( 'label' 	=> __( 'Navigation background color', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.wtrSH .wtrHeaderTransparent .wtrMobileNaviTriger span, .wtrSH .wtrHeaderTransparent .wtrMobileMenu span, .wtrSH .wtrHeaderTransparent .wtrMobileNaviTriger span:before, .wtrSH .wtrHeaderTransparent .wtrMobileNaviTriger span:after, .wtrSH .wtrHeaderTransparent .wtrMobileMenu span:after, .wtrSH .wtrHeaderTransparent .wtrMobileMenu span:before, .wtrExpander span:before, .wtrExpander span:after, .wtrBH .wtrMobileNaviTriger span, .wtrBH .wtrMobileNaviTriger span:before, .wtrBH .wtrMobileNaviTriger span:after, .wtrBH .wtrMobileMenu span:after, .wtrBH .wtrMobileMenu span:before, .wtrMobileNaviTriger span:before, .wtrMobileNaviTriger span:after, .wtrMobileMenu span:after, .wtrMobileMenu span:before, .wtrSimpleMobileNavContainer, .wtrMobileNaviTriger span, .wtrMobileMenu span',
		'css_style' 	=> 'background-color',
		'transport'		=> 'refresh',
		)
);

$wtr_Color_98 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_98',
		'default'		=> '#e5e5e5',
		'control_args'	=> array( 'label' 	=> __( 'Navigation border color', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.wtrSimpleMobileNav ul li ul li:before, .wtrSimpleMobileNav ul.wtrMainNaviList',
		'css_style' 	=> 'border-color',
		)
);

$wtr_Color_99 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_99',
		'default'		=> '#cccccc',
		'control_args'	=> array( 'label' 	=> __( 'Navigation icon color', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.wtrExpander.wtrMinus span:before, .wtrExpander.wtrPlus span:before, .wtrExpander.wtrMinus span:after, .wtrExpander.wtrPlus span:after, .wtrExpander.wtrMinus span:after, .wtrBH.wtrSimpleNavOn .wtrMobileNaviTriger span, .wtrBH.wtrSimpleNavOn .wtrMobileMenu span, .wtrBH.wtrSimpleNavOn .wtrMobileNaviTriger span:before, .wtrBH.wtrSimpleNavOn .wtrMobileNaviTriger span:after, .wtrBH.wtrSimpleNavOn .wtrMobileMenu span:after, .wtrBH.wtrSimpleNavOn .wtrMobileMenu span:before, .wtrSH.wtrSimpleNavOn .wtrHeaderColor .wtrMobileNaviTriger span, .wtrSH.wtrSimpleNavOn .wtrHeaderColor .wtrMobileMenu span, .wtrSH.wtrSimpleNavOn .wtrHeaderColor .wtrMobileNaviTriger span:before, .wtrSH.wtrSimpleNavOn .wtrHeaderColor .wtrMobileNaviTriger span:after, .wtrSH.wtrSimpleNavOn .wtrHeaderColor .wtrMobileMenu span:after, .wtrSH.wtrSimpleNavOn .wtrHeaderColor .wtrMobileMenu span:before,.wtrSimpleNavOn .wtrMobileNaviTriger span:before, .wtrSimpleNavOn .wtrMobileNaviTriger span:after, .wtrSimpleNavOn .wtrMobileMenu span:after, .wtrSimpleNavOn .wtrMobileMenu span:before, .wtrSimpleNavOn .wtrMobileNaviTriger span, .wtrSimpleNavOn .wtrMobileMenu span',
		'css_style' 	=> 'background-color',
		'transport'		=> 'refresh',
		)
);

$wtr_Color_100 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_100',
		'default'		=> '#000000',
		'control_args'	=> array( 'label' 	=> __( 'Navigation second icon color', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.wtrSH .wtrHeaderTransparent.wtrHeaderColor .wtrMobileMenu.wtrMenuOpen span:after, .wtrSH .wtrHeaderTransparent.wtrHeaderColor .wtrMobileMenu.wtrMenuOpen span:before, .wtrHeaderTransparent .wtrMobileMenu.wtrMenuOpen span:before, .wtrHeaderTransparent .wtrMobileMenu.wtrMenuOpen span:after, .wtrBNTH .wtrHeaderColor .wtrMobileNaviTriger span, .wtrBNTH .wtrHeaderColor .wtrMobileMenu span, .wtrBNTH .wtrHeaderColor .wtrMobileNaviTriger span:before, .wtrBNTH .wtrHeaderColor .wtrMobileNaviTriger span:after, .wtrBNTH .wtrHeaderColor .wtrMobileMenu span:after, .wtrBNTH .wtrHeaderColor .wtrMobileMenu span:before, .wtrSH .wtrHeaderColor .wtrMobileNaviTriger span, .wtrSH .wtrHeaderColor .wtrMobileMenu span, .wtrSH .wtrHeaderColor .wtrMobileNaviTriger span:before, .wtrSH .wtrHeaderColor .wtrMobileNaviTriger span:after, .wtrSH .wtrHeaderColor .wtrMobileMenu span:after, .wtrSH .wtrHeaderColor .wtrMobileMenu span:before',
		'css_style' 	=> 'background-color',
		'css_important'	=> true,
		'transport'		=> 'refresh',
		)
);

$wtr_Color_101 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_101',
		'default'		=> '#333333',
		'control_args'	=> array( 'label' 	=> __( 'Navigation menu item color', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.wtrSimpleMobileNav ul li ul li a, .wtrSimpleMobileNav ul li a, .wtrSimpleMobileNav ul li span',
		'css_style' 	=> 'color',
		)
);

$wtr_Color_102 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_102',
		'default'		=> '#f5f5f5',
		'control_args'	=> array( 'label' 	=> __( 'Navigation search input background color', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.wtrSimpleMNSearch input',
		'css_style' 	=> 'background-color',
		)
);

$wtr_Color_103 = new WTR_Customize_Setting ( array(
		'id' 			=> 'wtr_Color_103',
		'default'		=> '#555555',
		'control_args'	=> array( 'label' 	=> __( 'Navigation search input text color', 'wtr_framework' ) ),
		'control_type'	=> 'color',
		'css_selector' 	=> '.wtrSimpleMNSearch input',
		'css_style' 	=> 'color',
		)
);

$wtr_GlobalColorsSection  = new WTR_Customize_Section( array(
		'id' 				=> 'wtr_GlobalColorsSection',
		'args'				=> array(
			'title'			=> __( 'Global colors', 'wtr_framework' ),
			'capability'	=> 'edit_theme_options',
			'description'	=> '',
		),
		'settings'		=> array(
			$wtr_Color_1,
		)
	)
);

$wtr_HeaderColorsSection  = new WTR_Customize_Section( array(
		'id' 				=> 'wtr_HeaderColorsSection',
		'args'				=> array(
			'title'			=> __( 'Header colors', 'wtr_framework' ),
			'capability'	=> 'edit_theme_options',
			'description'	=> '',
		),
		'settings'		=> array(
			$wtr_Color_2,
			$wtr_Color_3,
			$wtr_Color_4,
			$wtr_Color_5,
			$wtr_Color_6,
			$wtr_Color_85,
			$wtr_Color_7,
			$wtr_Color_84,
			$wtr_Color_8,
			$wtr_Color_95,
			$wtr_Color_9,
			$wtr_Color_10,
			$wtr_Color_11,
			$wtr_Color_12,
			$wtr_Color_13,
		)
	)
);

$wtr_BreadcrumbsColorsSection  = new WTR_Customize_Section( array(
		'id' 				=> 'wtr_BreadcrumbsColorsSection',
		'args'				=> array(
			'title'			=> __( 'Breadcrumbs colors', 'wtr_framework' ),
			'capability'	=> 'edit_theme_options',
			'description'	=> '',
		),
		'settings'		=> array(
			$wtr_Color_14,
			$wtr_Color_15,
			$wtr_Color_16,
			$wtr_Color_17,
			$wtr_Color_18,
		)
	)
);

$wtr_OthersColorsSection  = new WTR_Customize_Section( array(
		'id' 				=> 'wtr_OthersColorsSection',
		'args'				=> array(
			'title'			=> __( 'Others colors', 'wtr_framework' ),
			'capability'	=> 'edit_theme_options',
			'description'	=> '',
		),
		'settings'		=> array(
			$wtr_Color_19,
			$wtr_Color_20,
			$wtr_Color_21,
			$wtr_Color_22,
			$wtr_Color_23,
			$wtr_Color_24,
			$wtr_Color_25,
			$wtr_Color_26,
			$wtr_Color_27,
			$wtr_Color_28,
			$wtr_Color_86,
			$wtr_Color_87,
			$wtr_Color_88,
			$wtr_Color_89,
			$wtr_Color_90,
			$wtr_Color_91,
			$wtr_Color_92,
			$wtr_Color_93,
			$wtr_Color_94,
		)
	)
);

$wtr_ContainerColorsSection  = new WTR_Customize_Section( array(
		'id' 				=> 'wtr_ContainerColorsSection',
		'args'				=> array(
			'title'			=> __( 'Container colors', 'wtr_framework' ),
			'capability'	=> 'edit_theme_options',
			'description'	=> '',
		),
		'settings'		=> array(
			$wtr_Color_29,
			$wtr_Color_30,
			$wtr_Color_31,
			$wtr_Color_32,
			$wtr_Color_33,
			$wtr_Color_35,
			$wtr_Color_36,
			$wtr_Color_37,
			$wtr_Color_38,
			$wtr_Color_39,
			$wtr_Color_40,
			$wtr_Color_41,
			$wtr_Color_42,
			$wtr_Color_43,
			$wtr_Color_44,
			$wtr_Color_45,
			$wtr_Color_46,
			$wtr_Color_47,
			$wtr_Color_48,
			$wtr_Color_49,
			$wtr_Color_50,
			$wtr_Color_51,
			$wtr_Color_52,
			$wtr_Color_53,
			$wtr_Color_54,
			$wtr_Color_55,
		)
	)
);

$wtr_SidebarColorsSection  = new WTR_Customize_Section( array(
		'id' 				=> 'wtr_SidebarColorsSection',
		'args'				=> array(
			'title'			=> __( 'Sidebar colors', 'wtr_framework' ),
			'capability'	=> 'edit_theme_options',
			'description'	=> '',
		),
		'settings'		=> array(
			$wtr_Color_56,
			$wtr_Color_57,
			$wtr_Color_58,
			$wtr_Color_59,
			$wtr_Color_60,
			$wtr_Color_61,
			$wtr_Color_62,
			$wtr_Color_63,
			$wtr_Color_64,
			$wtr_Color_65,
			$wtr_Color_66,
			$wtr_Color_67,
			$wtr_Color_68,
		)
	)
);

$wtr_FooterColorsSection  = new WTR_Customize_Section( array(
		'id' 				=> 'wtr_FooterColorsSection',
		'args'				=> array(
			'title'			=> __( 'Footer colors', 'wtr_framework' ),
			'capability'	=> 'edit_theme_options',
			'description'	=> '',
		),
		'settings'		=> array(
			$wtr_Color_69,
			$wtr_Color_70,
			$wtr_Color_71,
			$wtr_Color_72,
			$wtr_Color_73,
			$wtr_Color_74,
			$wtr_Color_75,
			$wtr_Color_76,
			$wtr_Color_77,
			$wtr_Color_78,
			$wtr_Color_79,
			$wtr_Color_80,
			$wtr_Color_81,
			$wtr_Color_82,
			$wtr_Color_83,
		)
	)
);

$wtr_StandardMobileNavigationSection  = new WTR_Customize_Section( array(
		'id' 				=> 'wtr_StandardMobileNavigationSection',
		'args'				=> array(
			'title'			=> __( 'Standard mobile navigation colors', 'wtr_framework' ),
			'capability'	=> 'edit_theme_options',
			'description'	=> '',
		),
		'settings'		=> array(
			$wtr_Color_96,
			$wtr_Color_97,
			$wtr_Color_98,
			$wtr_Color_99,
			$wtr_Color_100,
			$wtr_Color_101,
			$wtr_Color_102,
			$wtr_Color_103
		)
	)
);

$wtr_menu = array(
	$wtr_GlobalColorsSection,
	$wtr_HeaderColorsSection,
	$wtr_BreadcrumbsColorsSection,
	$wtr_OthersColorsSection,
	$wtr_ContainerColorsSection,
	$wtr_SidebarColorsSection,
	$wtr_FooterColorsSection,
	$wtr_StandardMobileNavigationSection,

);

$wtr_custmize = new WTR_Customize( $wtr_menu );