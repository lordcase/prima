<?php

/*
Plugin Name: Wonster Shortcodes for Visual Composer - Symetrio Edition
Plugin URI:
Description: Build your perfect site with awesome shortcodes added to Visual Composer. This plugin works only with Symetrio theme created by Wonster team.
Version: 2.16.2
Author: Wonster
Author URI: http://wonster.co
*/

if (!defined('ABSPATH')) exit;

//====== VC wonster bridge =========
define( 'VC_WTR_SHT_PLUGIN_MAIN_FILE', __FILE__ );
define( 'VC_WTR_SHT_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'VC_WTR_SHT_PLUGIN_URI', plugin_dir_url( __FILE__ ) );

define( 'VC_WTR_SHT_LANG_URI', VC_WTR_SHT_PLUGIN_URI . 'languages' );
define( 'VC_WTR_SHT_LANG_DIR', VC_WTR_SHT_PLUGIN_DIR . 'languages' );
define( 'VC_WTR_SHT_PLUGIN_LIBS', VC_WTR_SHT_PLUGIN_DIR . 'vc-wtr-admin' );
define( 'VC_WTR_SHT_PLUGIN_SHORTCODES', VC_WTR_SHT_PLUGIN_LIBS . '/shortcodes' );

include_once  VC_WTR_SHT_PLUGIN_LIBS . '/vc_wtr_system.php';

$VcWtrStstem = new VCExtendAddonWtrSystem();


//====== basic wonster shortcode =========
define( 'WTR_SHT_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'WTR_SHT_PLUGIN_URI', plugin_dir_url( __FILE__ ) );

define( 'WTR_SHT_LANG_URI', WTR_SHT_PLUGIN_URI . 'languages' );
define( 'WTR_SHT_LANG_DIR', WTR_SHT_PLUGIN_DIR . 'languages' );

define( 'WTR_SHT_PLUGIN_ADMIN_URI', WTR_SHT_PLUGIN_URI . 'wtr-admin' );
define( 'WTR_SHT_PLUGIN_ADMIN_DIR', WTR_SHT_PLUGIN_DIR . 'wtr-admin' );

define( 'WTR_SHT_PLUGIN_CUSTOMIZER_URI', WTR_SHT_PLUGIN_URI . '/customizer' );
define( 'WTR_SHT_PLUGIN_CUSTOMIZER_DIR', WTR_SHT_PLUGIN_ADMIN_DIR . '/customizer' );

define( 'SHORTCODES_URL', WTR_SHT_PLUGIN_ADMIN_DIR . '/page-builder/wtr-shortcodes' );
define( 'SHORTCODES_URL_PUBLIC', SHORTCODES_URL . '/public' );

// translations
load_theme_textdomain( 'wtr_sht_framework', WTR_SHT_LANG_DIR );

// shortcodes controler
require_once( WTR_SHT_PLUGIN_ADMIN_DIR . '/page-builder/wtr_shortcodes_controller.php' );

$wtrShtControler = new WTR_Shortcodes_Controller( $VcWtrStstem );