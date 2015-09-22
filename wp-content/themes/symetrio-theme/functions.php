<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

$wtr_theme = wp_get_theme();

// ===== the definition of constants
define( 'WTR_THEME_DIR', get_template_directory());
define( 'WTR_THEME_URI', get_template_directory_uri());

define( 'WTR_SYMETRIO', 'Symetrio');
define( 'WTR_THEME_VERSION', $wtr_theme->Version);
define( 'WTR_THEME_NAME', $wtr_theme->Name);
define( 'WTR_ADMIN_TRANSLATE_NAME', WTR_THEME_NAME . ' Global Settings');

define( 'WTR_LANG_URI', WTR_THEME_URI . '/languages' );
define( 'WTR_LANG_DIR', WTR_THEME_DIR . '/languages' );

define( 'WTR_ADMIN_URI', WTR_THEME_URI . '/wtr-admin' );
define( 'WTR_ADMIN_DIR', WTR_THEME_DIR . '/wtr-admin' );

define( 'WTR_IMPORTER_URI', WTR_ADMIN_URI . '/importer' );
define( 'WTR_IMPORTER_DIR', WTR_ADMIN_DIR . '/importer' );

define( 'WTR_CUSTOMIZER_URI', WTR_ADMIN_URI . '/customizer' );
define( 'WTR_CUSTOMIZER_DIR', WTR_ADMIN_DIR . '/customizer' );

define( 'WTR_CUSTOMIZER_CLASS_URI', WTR_CUSTOMIZER_URI . '/class' );
define( 'WTR_CUSTOMIZER_CLASS_DIR', WTR_CUSTOMIZER_DIR . '/class' );

define( 'WTR_ADMIN_CLASS_URI', WTR_ADMIN_URI . '/panel/class' );
define( 'WTR_ADMIN_CLASS_DIR', WTR_ADMIN_DIR . '/panel/class' );

define( 'WTR_FN_URI', WTR_THEME_URI . '/functions' );
define( 'WTR_FN_DIR', WTR_THEME_DIR . '/functions' );

define( 'WTR_HELPERS_URI', WTR_FN_URI . '/helpers' );
define( 'WTR_HELPERS_DIR', WTR_FN_DIR . '/helpers' );

define( 'WTR_META_URI', WTR_FN_URI . '/meta' );
define( 'WTR_META_DIR', WTR_FN_DIR . '/meta' );

define( 'WTR_WIDGET_URI', WTR_FN_URI . '/widget' );
define( 'WTR_WIDGET_DIR', WTR_FN_DIR . '/widget' );

define( 'WTR_PLUGINS_DIR', WTR_FN_DIR . '/plugins' );
define( 'WTR_PLUGINS_URI', WTR_FN_URI . '/plugins' );

define( 'WTR_EXTENSIONS_URI', WTR_THEME_URI . '/extensions' );
define( 'WTR_EXTENSIONS_DIR', WTR_THEME_DIR . '/extensions' );


// translations Public
load_theme_textdomain( WTR_THEME_NAME, WTR_LANG_DIR );

// translations Admin
load_theme_textdomain( 'wtr_framework', WTR_LANG_DIR );


//extensions
require_once( WTR_EXTENSIONS_DIR . '/wpml/functions.php' );
require_once( WTR_EXTENSIONS_DIR . '/woocommerce/functions.php' );
require_once( WTR_EXTENSIONS_DIR . '/qTranslate/functions.php' );
require_once( WTR_EXTENSIONS_DIR . '/qTranslate-x/functions.php' );
require_once( WTR_EXTENSIONS_DIR . '/bbPress/functions.php' );
require_once( WTR_EXTENSIONS_DIR . '/wordpress-seo/functions.php' );

//admin init
require_once( WTR_ADMIN_DIR .'/wtr_init.php' );

//admin customizer init
require_once( WTR_CUSTOMIZER_DIR .'/wtr_customizer_init.php' );

//public init
require_once( WTR_FN_DIR .'/wtr_theme_init.php' );

//meta
require_once( WTR_META_DIR . '/meta-page.php' );
require_once( WTR_META_DIR . '/meta-post.php' );

//helpers
require_once( WTR_HELPERS_DIR . '/helper-footer.php' );
require_once( WTR_HELPERS_DIR . '/helper-function.php' );
require_once( WTR_HELPERS_DIR . '/helper-menu.php' );
require_once( WTR_HELPERS_DIR . '/helper-megamenu.php' );
require_once( WTR_HELPERS_DIR . '/helper-mobile-menu.php' );
require_once( WTR_HELPERS_DIR . '/helper-mobile-menu-classic.php' );
require_once( WTR_HELPERS_DIR . '/helper-smart-menu.php' );
require_once( WTR_HELPERS_DIR . '/helper-header.php' );
require_once( WTR_HELPERS_DIR . '/helper-post-content.php' );
require_once( WTR_HELPERS_DIR . '/helper-sht.php' );
require_once( WTR_HELPERS_DIR . '/helper-onepage.php' );

//registration  sidebars
require_once( WTR_WIDGET_DIR . '/register-widget.php' );

//registration widgets
require_once( WTR_WIDGET_DIR . '/widget-tweets.php' );
require_once( WTR_WIDGET_DIR . '/widget-tag-cloud.php' );
require_once( WTR_WIDGET_DIR . '/widget-recent-posts.php' );
require_once( WTR_WIDGET_DIR . '/widget-todays-open-hours.php' );
require_once( WTR_WIDGET_DIR . '/widget-open-hours.php' );
require_once( WTR_WIDGET_DIR . '/widget-social-links.php' );
require_once( WTR_WIDGET_DIR . '/widget-menu.php' );
require_once( WTR_WIDGET_DIR . '/widget-recent-comments.php' );
require_once( WTR_WIDGET_DIR . '/widget-promo-box.php' );
require_once( WTR_WIDGET_DIR . '/widget-facebook-like-box.php' );

//Plugins
require_once( WTR_PLUGINS_DIR . '/class-tgm-plugin-activation.php' );
require_once( WTR_PLUGINS_DIR . '/twitteroauth.php' );

//Importer
require_once( WTR_IMPORTER_DIR . '/wtr_importer.php' );