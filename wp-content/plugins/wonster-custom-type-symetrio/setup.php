<?php

/*
Plugin Name: WonsterCustom type - Symetrio Edition
Plugin URI:
Description:
Version: 2.9
Author: Wonster
Author URI: http://wonster.co
*/

if (!defined('ABSPATH')) exit;


define( 'WTR_CP_PLUGIN_MAIN_FILE', __FILE__ );
define( 'WTR_CP_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'WTR_CP_PLUGIN_URI', plugin_dir_url( __FILE__ ) );

define( 'WTR_CP_LANG_URI', WTR_CP_PLUGIN_URI . 'languages' );
define( 'WTR_CP_LANG_DIR', WTR_CP_PLUGIN_DIR . 'languages' );

define( 'WTR_CP_PLUGIN_ADMIN_URI', WTR_CP_PLUGIN_URI . 'wtr-admin' );
define( 'WTR_CP_PLUGIN_ADMIN_DIR', WTR_CP_PLUGIN_DIR . 'wtr-admin' );

define( 'WTR_CP_FN_URI', WTR_CP_PLUGIN_URI . 'functions' );
define( 'WTR_CP_FN_DIR', WTR_CP_PLUGIN_DIR . 'functions' );

define( 'WTR_CP_META_URI', WTR_CP_FN_URI . '/meta' );
define( 'WTR_CP_META_DIR', WTR_CP_FN_DIR . '/meta' );

define( 'WTR_CP_WIDGET_URI', WTR_CP_FN_URI . '/widget' );
define( 'WTR_CP_WIDGET_DIR', WTR_CP_FN_DIR . '/widget' );

define( 'WTR_CP_PLUGINS_URI', WTR_CP_FN_URI . '/plugins' );
define( 'WTR_CP_PLUGINS_DIR', WTR_CP_FN_DIR . '/plugins' );

define( 'WTR_CP_TEMPLATES_URI', WTR_CP_FN_URI . '/templates' );
define( 'WTR_CP_TEMPLATES_DIR', WTR_CP_FN_DIR . '/templates' );

define( 'WTR_CP_INCLUDES_URI', WTR_CP_FN_URI . '/includes' );
define( 'WTR_CP_INCLUDES_DIR', WTR_CP_FN_DIR . '/includes' );

// translations
load_theme_textdomain( 'wtr_ct_framework', WTR_CP_LANG_DIR );

// controler
require_once( WTR_CP_PLUGIN_ADMIN_DIR . '/wtr_controller.php' );

$wtrShtControler = new WTR_CT_Controler();