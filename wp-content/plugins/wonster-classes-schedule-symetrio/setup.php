<?php
/*
Plugin Name: Wonster Classes Schedule - Symetrio Edition
Plugin URI:
Description:
Version: 1.14.1
Author: Wonster
Author URI: http://wonster.co
*/

if (!defined('ABSPATH')) exit;

//====== basic wonster shortcode =========
define( 'WTR_CS_PLUGIN_FILE', __FILE__ );
define( 'WTR_CS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'WTR_CS_PLUGIN_URI', plugin_dir_url( __FILE__ ) );

define( 'WTR_CS_LANG_URI', WTR_CS_PLUGIN_URI . 'languages' );
define( 'WTR_CS_LANG_DIR', WTR_CS_PLUGIN_DIR . 'languages' );

define( 'WTR_CS_PLUGIN_ADMIN_URI', WTR_CS_PLUGIN_URI . 'wtr-admin' );
define( 'WTR_CS_PLUGIN_ADMIN_DIR', WTR_CS_PLUGIN_DIR . 'wtr-admin' );

define( 'WTR_CS_PLUGIN_CUSTOMIZER_URI', WTR_CS_PLUGIN_URI . '/customizer' );
define( 'WTR_CS_PLUGIN_CUSTOMIZER_DIR', WTR_CS_PLUGIN_ADMIN_DIR . '/customizer' );

// translations
load_theme_textdomain( 'wtr_cs_framework', WTR_CS_LANG_DIR );

// shortcodes controler
require_once( WTR_CS_PLUGIN_ADMIN_DIR . '/wtr_controller.php' );

$wtrShtControler = new WTR_Classes_Schedule_Controler();