<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

// Don't load directly
if ( !defined('ABSPATH') ) { die('-1');}

require_once( 'class/wtr_db_controller.php' );
require_once( 'class/wtr_view_controller.php' );

register_uninstall_hook( WTR_CS_PLUGIN_FILE, array( 'WTR_Classes_Schedule_Controler', 'uninstall' ) );
register_activation_hook( WTR_CS_PLUGIN_FILE, array( 'WTR_Classes_Schedule_Controler', 'activate' ) );

function WTR_Classes_Schedule_Controler_activate(){}

if ( ! class_exists( 'WTR_Classes_Schedule_Controler' ) ) {

	class WTR_Classes_Schedule_Controler{

		//VARIABLE
		private $config		= array();

		private static $db_controler;
		private static $view_controler;

		private static $sht_count = 0;

		//FUNCTION
		public function __construct(){

			self::$db_controler		= new WTR_Cs_db();
			self::$view_controler	= new WTR_Cs_view();

			add_action( 'init', array( &$this, 'check_theme' ), 8 );
			add_action( 'init', array( &$this, 'init_settings') );

		} // end __construct

		public function check_theme(){

			//I'm checking does Symetrio theme is active
			$this->config['wtr_theme_disable'] = ( ! defined( 'WTR_THEME_VERSION' ) AND ! defined( 'WTR_THEME_NAME' ) );

			if( $this->config['wtr_theme_disable']){
				add_action( 'admin_notices', array( &$this, 'admin_notice' ) );
				return;
			}

/*			if( ! defined( 'WTR_CP_PLUGIN_MAIN_FILE' ) ){
				add_action( 'admin_notices', array( &$this, 'admin_custom_type_notice' ) );
				return;
			}
*/
			define( 'WTR_CS_PLUGIN_STATUS', 1 );
			$this->loadPluginData();
		}// end check_theme


		public function init_settings() {
			global $wtr_date_format_field;
			$date_format = get_option( 'wtr_classes_schedule_date_format' );
			if( empty( $date_format ) ) {
				update_option( 'wtr_classes_schedule_date_format', key( $wtr_date_format_field ) );
			}
		} // end init_settings



		public static function admin_notice() {
			$plugin_data = get_plugin_data( WTR_CS_PLUGIN_FILE );

			echo '<div class="error"  style="margin-left: 0;" >';
				echo '<p>'. sprintf( __( '<strong>%s</strong> - This plugin works only with Symetrio theme created by
								 Wonster Team', 'wtr_sht_framework' ), $plugin_data[ 'Name' ] ) .
					'.</p>';
			echo '</div>';
		}//end admin_notice


		public static function admin_custom_type_notice() {
			$plugin_data = get_plugin_data( WTR_CS_PLUGIN_FILE );

			echo '<div class="error"  style="margin-left: 0;" >';
				echo '<p>'. sprintf( __( '<strong>%s</strong> - This plugin works only with <b>WonsterCustom type - Symetrio Edition</b> created by
								 Wonster Team', 'wtr_sht_framework' ), $plugin_data[ 'Name' ] ) .
					'.</p>';
			echo '</div>';
		}//end admin_custom_type_notice


		public static function activate(){

			if ( ! current_user_can( 'activate_plugins' ) ) {
				return;
			}

			self::$db_controler->create_plugin_table();
		}// end activate


		public static  function uninstall(){
			if ( ! current_user_can( 'activate_plugins' ) ) {
				return;
			}

			/*
			if( 1 == get_option('wtr_classes_schedule_drop_table') ){
				self::$db_controler->delete_plugin_table();
			}*/
			self::$db_controler->delete_plugin_table();
		}// end uninstall


		private function loadPluginData(){

			if( is_multisite() ){
				self::$db_controler->create_plugin_table();
			}

			//admin
			add_action( 'admin_init', array( &$this, 'add_user_caps' ) );
			add_action( 'admin_menu', array( &$this, 'create_options_page' ) );
			add_action( 'wp_ajax_wtr_calendar_schedule_new', array( &$this, 'add_calendar' ) );
			add_action( 'wp_ajax_wtr_calendar_schedule_edit', array( &$this, 'edit_calendar' ) );
			add_action( 'wp_ajax_wtr_calendar_schedule_delete', array( &$this, 'delete_calendar' ) );
			add_action( 'wp_ajax_wtr_calendar_scope_new', array( &$this, 'add_calendar_scope' ) );
			add_action( 'wp_ajax_wtr_calendar_scope_edit', array( &$this, 'edit_calendar_scope' ) );
			add_action( 'wp_ajax_wtr_calendar_scope_delete', array( &$this, 'delete_calendar_scope' ) );
			add_action( 'wp_ajax_wtr_calendar_instance_new', array( &$this, 'add_calendar_instance' ) );
			add_action( 'wp_ajax_wtr_calendar_instance_edit', array( &$this, 'edit_calendar_instance' ) );
			add_action( 'wp_ajax_wtr_calendar_instance_delete', array( &$this, 'delete_calendar_instance' ) );

			add_action( 'before_delete_post',  array( &$this, 'delete_post_data' ) );
			add_action( 'wp_trash_post',  array( &$this, 'delete_post_data' ) );

			//public
			add_action( 'wp_enqueue_scripts', array( &$this, 'load_public_styles_and_scripts' ), 100 );
			add_action( 'wp_ajax_wtr_calendar_schedule_class_filter', array( &$this, 'public_class_filter' ) );
			add_action( 'wp_ajax_nopriv_wtr_calendar_schedule_class_filter', array( &$this, 'public_class_filter' ) );
			add_action( 'wp_ajax_wtr_calendar_schedule_class_detail', array( &$this, 'public_class_detail' ) );
			add_action( 'wp_ajax_nopriv_wtr_calendar_schedule_class_detail', array( &$this, 'public_class_detail' ) );
			add_action( 'wp_ajax_wtr_calendar_get_week', array( &$this, 'public_get_week' ) );
			add_action( 'wp_ajax_nopriv_wtr_calendar_get_week', array( &$this, 'public_get_week' ) );

			//Creating a shortcode addon
			add_shortcode( 'vc_wtr_class_schedule_plugin', array( &$this, 'render_class_schedule' ) );
			add_shortcode( 'vc_wtr_daily_schedule_plugin', array( &$this, 'render_daily_schedule' ) );
		}//end loadPluginData


		public function gen_alert_delete_post_data( $data, $post_type ){

			$alert	= '';
			$days	= array(
				__( 'Monday', 'wtr_cs_framework' ),
				__( 'Tuesday', 'wtr_cs_framework' ),
				__( 'Wednesday', 'wtr_cs_framework' ),
				__( 'Thursday', 'wtr_cs_framework' ),
				__( 'Friday', 'wtr_cs_framework' ),
				__( 'Saturday', 'wtr_cs_framework' ),
				__( 'Sunday', 'wtr_cs_framework' ),
			);

			$plugin	=  get_plugin_data( WTR_CS_PLUGIN_FILE );

			$alert .= '<b>' . __( 'ERROR INFORMATION', 'wtr_cs_framework' ) . '</b> &#160;&#160;&#160;&#160;';
			$alert .= '<br/><br/><a style="font-size:16px;" href="edit.php?post_type=' . esc_attr( $post_type ) . '">' . __( 'Back', 'wtr_cs_framework' ) . '</a><br/><br/>';
			$alert .= 'You are trying to delete the data that are used by the plugin "' . $plugin[ 'Name' ] . '". To remove this item you must first remove the instances in the timetable';
			$alert .= '<br/><br/>';

			$scope_c = count( $data[ 'scope' ] );
			if( $scope_c ){

				$alert .= '<b>' . __( 'Calendar scope', 'wtr_cs_framework' ) . ':</b>';
				$alert .= '<ul>';

				for( $i = 0; $i < $scope_c; $i++ ){
					$alert .=
					'<li>' . __( 'Calendar', 'wtr_cs_framework' ) . ': '.
						$data[ 'scope' ][ $i ][ 'name' ] . ' - ' .
						$data[ 'scope' ][ $i ][ 'start_date' ] . ' - ' .
						$data[ 'scope' ][ $i ][ 'end_date' ] . ' (' .
						$days[ $data[ 'scope' ][ $i ][ 'day_of_the_week' ] ] . ') --- ' .
						' <a target="_blank" href="admin.php?page=wtr_classes_schedule&view=scope&id=' .
							intval( $data[ 'scope' ][ $i ][ 'id' ] ) .
						'" style="font-weight:bold;">GO TO</a>' .
					'</li>';
				}
				$alert .= '</ul><br/>';
			}

			$ap_m_week_c = count( $data[ 'ap_m_week' ] );
			$ap_static_c = count( $data[ 'ap_static' ] );

			if( $ap_m_week_c || $ap_static_c ){
				$alert .= '<b style="font-size:14px;">' . __( 'Calendar instance', 'wtr_cs_framework' ) . ':</b>';
				$alert .= '<ul>';
			}

			if( $ap_m_week_c ){
				for( $i = 0; $i < $ap_m_week_c; $i++ ){

					$gen_url = 'admin.php?page=wtr_classes_schedule&view=instance&id=' . intval( $data[ 'ap_m_week' ][ $i ][ 'id' ] ) . '&date=' . intval( $data[ 'ap_m_week' ][ $i ][ 'date' ] );

					$alert .=
					'<li>' . __( 'Calendar', 'wtr_cs_framework' ) . ': '.
						$data[ 'ap_m_week' ][ $i ][ 'name' ] . ' - ' .
						$data[ 'ap_m_week' ][ $i ][ 'date' ] . ' --- ' .
						' <a target="_blank" href="'. $gen_url .'" style="font-weight:bold;">' . __( 'GO TO', 'wtr_cs_framework' ) . '</a>' .
					'</li>';
				}
			}


			if( $ap_static_c ){
				for( $i = 0; $i < $ap_static_c; $i++ ){
					if( isset( $data[ 'ap_static' ][ $i ][ 'date' ] ) ){
						$data_day_t = $data[ 'ap_static' ][ $i ][ 'date' ];
					}else{
						$data_day_t = $days [ $data_day_t = $data[ 'ap_static' ][ $i ][ 'day_of_the_week' ] ];
					}

					$gen_url = 'admin.php?page=wtr_classes_schedule&view=instance&id=' . intval( $data[ 'ap_static' ][ $i ][ 'id' ] );

					$alert .=
					'<li>' . __( 'Calendar', 'wtr_cs_framework' ) . ': '.
						$data[ 'ap_static' ][ $i ][ 'name' ] . ' - ' .
						$data_day_t . ' --- ' .
						' <a target="_blank" href="' . $gen_url . '" style="font-weight:bold;">' . __( 'GO TO', 'wtr_cs_framework' ) . '</a>' .
					'</li>';
				}
			}

			if( $ap_m_week_c || $ap_static_c ){
				$alert .= '</ul><br/>';
			}

			$alert .= '<a href="edit.php?post_type=' . esc_attr( $post_type ) . '">' . __( 'Back', 'wtr_cs_framework' ) . '</a>';

			return $alert;
		}//end gen_alert_delete_post_data


		public function delete_post_data( $post_id ){

			global $post_type;

			$result = self::$db_controler->check_data_link( $post_type, $post_id );

			if( count( $result ) ){
				wp_die( $this->gen_alert_delete_post_data( $result, $post_type ) );
			}

			return  false;
		}//end delete_post_data


		function add_user_caps() {

			global $wp_roles, $wtr_date_format_field;

			if( isset( $_POST['wtr_classes_schedule_submit'] ) ){

				if( isset( $_POST['role'] ) OR  isset( $_POST['drop_table']  ) OR isset( $_POST['date_format'] ) ){

					$admin_role		= ( isset( $_POST['role'] ) AND is_array( $_POST['role'] ) ) ? $_POST['role'] : array();
					$drop_table		= isset( $_POST['drop_table'] ) ? intval( $_POST['drop_table'] ) : 0 ;
					$date_format	= isset( $_POST['date_format'] ) ? $_POST['date_format'] : current( $wtr_date_format_field ) ;
					update_option( 'wtr_classes_schedule_drop_table', $drop_table);
					update_option( 'wtr_classes_schedule_date_format', $date_format);

					$all_roles		= $wp_roles->roles;
					$editable_roles	= apply_filters('editable_roles', $all_roles );

					foreach ( $editable_roles as $role_key => $role ) {
						if( isset( $admin_role[ $role_key ] ) OR 'administrator' == $role_key){
							$wp_roles->add_cap( $role_key, 'wtr_classes_schedule_manage' );
						} else {
							$wp_roles->remove_cap( $role_key, 'wtr_classes_schedule_manage' );
						}
					}
				}
			}else if( ! isset( $wp_roles->roles['administrator']['capabilities']['wtr_classes_schedule_manage'] ) ){
				$wp_roles->add_cap( 'administrator', 'wtr_classes_schedule_manage' );
			}
		} // end  add_user_caps


		public function create_options_page(){

			$classes_schedule_slug		= 'wtr_classes_schedule';
			$classes_schedule_name		= __('Classes schedule', 'wtr_framework');
			$classes_schedule_all_name	= __('All classes schedules', 'wtr_framework');
			$classes_schedule_page	= add_menu_page(
										$classes_schedule_name,
										$classes_schedule_name,
										'wtr_classes_schedule_manage',
										$classes_schedule_slug,
										array( &$this, 'create_options_page_html' ),
										null,
										'34.1'
									);

			$classes_schedule_page	= add_submenu_page(
										$classes_schedule_slug,
										$classes_schedule_all_name,
										$classes_schedule_all_name,
										'wtr_classes_schedule_manage',
										$classes_schedule_slug
									);

			add_action('admin_init', array( &$this, 'register_admin_styles_and_scripts') );
			add_action('admin_print_styles-' . $classes_schedule_page, array( &$this, 'init_enqueue_styles' ) );
			add_action('admin_print_scripts-' . $classes_schedule_page, array( &$this, 'init_enqueue_scipts' ) );

			//settings
			$classes_schedule_settings_slug	= 'wtr_classes_schedule_settings';
			$classes_schedule_settings_name	= __('Settings', 'wtr_framework');
			$classes_schedule_settings_page	= add_submenu_page(
												$classes_schedule_slug,
												$classes_schedule_settings_name,
												$classes_schedule_settings_name,
												'manage_options',
												$classes_schedule_settings_slug,
												array( &$this, 'create_settings_page_html' )
											);

			add_action('admin_print_styles-' . $classes_schedule_settings_page, array( &$this, 'init_enqueue_styles' ) );
			add_action('admin_print_scripts-' . $classes_schedule_settings_page, array( &$this, 'init_enqueue_scipts' ) );
		} // end create_options_page


		public function register_admin_styles_and_scripts(){
			// ==== register Stylesheets
				wp_register_style( 'admin-schedule-css', trailingslashit( WTR_CS_PLUGIN_URI ) . 'assets/css/admin-style.css' );
				wp_register_style( 'wtr-modal-window-css', trailingslashit( WTR_CS_PLUGIN_URI ) . 'assets/css/wtr_modal_window.css' );

			//==== Register Scripts
				wp_register_script( 'admin-schedule-js', trailingslashit( WTR_CS_PLUGIN_URI ) . 'assets/js/admin-scripts.js', true );
				wp_register_script( 'wtr-modal-window-js', trailingslashit( WTR_CS_PLUGIN_URI ) . 'assets/js/wtr_modal_window.js', true );
		}//end register_script


		public function init_enqueue_styles(){
			wp_enqueue_style( 'normalize' );
			wp_enqueue_style( 'site' );
			wp_enqueue_style( 'aristo' );
			wp_enqueue_style( 'font_awesome' );
			wp_enqueue_style( 'admin-schedule-css' );
			wp_enqueue_style( 'wtr-modal-window-css' );
			wp_enqueue_style( 'pikaday' );
		}// end init_enqueue


		public function init_enqueue_scipts(){

			//localize
			$lang = array(
				'ajax_url'		=> admin_url( 'admin-ajax.php' ),
				'plugin_path'	=> WTR_CS_PLUGIN_URI,
				'msg'			=> array(
					'delete_calendar'			=> __( 'Are sure you want to delete this calendar?', 'wtr_cs_framework' ),
					'name_calendar_not_unique'	=> __( 'Calendar with the same name already exists. Enter another name.', 'wtr_cs_framework' ),
					'error'						=> __( 'Oops something went wrong', 'wtr_cs_framework' ),
					'scope_no_id_class'			=> __( 'To be able to add this schedule you have to first create Classes.', 'wtr_cs_framework' ),
					'scope_no_id_room'			=> __( 'To be able to add this schedule you have to first create Room.', 'wtr_cs_framework' ),
					'scope_no_trainers'			=> __( 'To be able to add this schedule you have to first create Trainer.', 'wtr_cs_framework' ),
					'scope_wrong_hour'			=> __( 'To be able to add this schedule you have to first set up start and stop time for activity.', 'wtr_cs_framework' ),
					'scope_wrong_scope'			=> __( 'To be able to add this schedule you have to first add activitie duration.', 'wtr_cs_framework' ),
					'scope_no_instance'			=> __( 'To be able to add this schedule you have to first set the duration of  the extent ( so that while it is taking was one instance )', 'wtr_cs_framework' ),
					'delete_scope'				=> __( 'Are sure you want to delete this scope and its classes instance?', 'wtr_cs_framework' ),
				)
			);
			wp_localize_script( 'admin-schedule-js', 'wtr_classes_schedule_param', $lang );

			//load script
			wp_enqueue_script('jquery-ui');
			wp_enqueue_script( 'jquery-ui-sortable' );
			wp_enqueue_script( 'jquery-ui-slider' );
			wp_enqueue_script( 'moment' );
			wp_enqueue_script( 'pikaday' );
			wp_enqueue_script( 'obj_loader' );
			wp_enqueue_script( 'admin-schedule-js' );
			wp_enqueue_script( 'wtr-modal-window-js' );
		}// end init_enqueue


		public function load_public_styles_and_scripts(){
			wp_enqueue_style( 'public-schedule-css', trailingslashit( WTR_CS_PLUGIN_URI ) . 'assets/css/public-schedule.css' );
			wp_enqueue_script( 'public-schedule-js', trailingslashit( WTR_CS_PLUGIN_URI ) . 'assets/js/public-scripts.js', array( 'jquery' ), '1.0.0', true );

			//localize
			$param = array(
				'ajax_url'		=> admin_url( 'admin-ajax.php' ),
				'plugin_path'	=> WTR_CS_PLUGIN_URI,
			);
			wp_localize_script( 'public-schedule-js', 'wtr_classes_schedule_param', $param );
		}//end load_public_styles_and_scripts


		public function create_options_page_html(){

			$view	= ( isset( $_GET['view'] ) ) ? $_GET['view'] : null;
			$id		= ( isset( $_GET['id'] ) ) ? $_GET['id'] : null;

			switch ( $view ) {
				case 'classes-schedule':
				default:
					$this->calendar_prev();
				break;

				case 'scope':
					$this->scope_prev( $id );
				break;

				case 'instance':
					$this->instance_prev( $id );
				break;
			}
		}// end create_options_page_html


		public function create_settings_page_html(){
			self::$view_controler->create_settings_page_html( );
		}// end create_settings_page_html


		private function clean_data( $data ){

			if( is_array( $data ) ){

				$result = array();
				foreach( $data as $key => $val ){
					$result[ $key ] = trim( strip_tags( htmlspecialchars( $val ) ) );
				}

				return $result;
			}else{
				return strip_tags( htmlspecialchars( $data ) );
			}
		}//end cleanData


		//=== FUNCTION CALENDAR

		public function calendar_prev() {
			$calendar_list = self::$db_controler->get_calendar_list();
			self::$view_controler->calendar_list_preview( $calendar_list );
		}// end page_html


		public function transform_data_array( $data, $mode = null ){
			$result = array();

			foreach( $data as $key => $val ){
				$result[ $key ][ 'value' ] = $val;
				if( 'flag_1' == $mode ){
					$result[ $key ][ 'flag' ] = 1;
				}
				else if( 'flag_0' == $mode ){
					$result[ $key ][ 'flag' ] = 0;
				}
			}

			return $result;
		}//end transform_data_array


		public function add_calendar(){

			//prepare nonce
			check_ajax_referer( 'wtr_calendar_schedule_new_opt_nonce' );

			$data	= array();
			$fields	= urldecode( $_POST[ 'field' ] );
			$fields	= utf8_decode( $fields );

			parse_str( $fields, $data );

			$data	= $this->clean_data( $data );
			$data_p = $data;

			// prepare data
			$name_calendar = $data[ 'name' ];

			unset(
				$data_p[ 'name' ],
				$data_p[ 'view_controler' ],
				$data_p[ 'mode_type_controler' ]
			);

			$result = self::$db_controler->create_calendar( $name_calendar, $data_p );

			if( 'not_unique' === $result[ 'status' ] ){
				$respons = array( 'status' => 'error', 'reason' => 'name_calendar_not_unique' );
			}else if( true === $result[ 'status' ] ){
				$respons = array( 'status' => 'success', 'code'	=> self::$view_controler->draw_calendar_item( $result[ 'id_timetable' ], $this->transform_data_array( $data ) ) );
			}else{
				$respons = array( 'status' => 'error', 'reason' => 'undefined' );
			}

			$respons = array_merge( $respons, array( 'controler' => $data[ 'view_controler' ], 'mode' => $data[ 'mode_type_controler' ] ) );

			echo json_encode( $respons );
			die();
		}//end add_calendar


		public function edit_calendar(){

			//prepare nonce
			check_ajax_referer( 'wtr_calendar_schedule_edit_opt_nonce' );

			$data	= array();
			$fields	= urldecode( $_POST[ 'field' ] );
			$fields	= utf8_decode( $fields );

			parse_str( $fields, $data );

			$data	= $this->clean_data( $data );
			$data_p = $data;

			// prepare data
			$name_calendar	= $data[ 'name' ];
			$id_timetable	= $data[ 'id_timetable' ];

			unset(
				$data_p[ 'id_timetable' ],
				$data_p[ 'name' ],
				$data_p[ 'view_controler' ],
				$data_p[ 'mode_type_controler' ]
			);

			$result = self::$db_controler->edit_calendar( $id_timetable, $name_calendar, $data_p );


			if( 'not_unique' === $result[ 'status' ] ){
				$respons = array( 'status' => 'error', 'reason' => 'name_calendar_not_unique' );
			}else if( true === $result[ 'status' ] ){
				$dataT = $this->transform_data_array( $data );
				$respons = array( 'status' => 'success', 'id_timetable' => $id_timetable, 'code' => self::$view_controler->draw_calendar_item( $id_timetable, $dataT ) );
			}else{
				$respons = array( 'status' => 'error', 'reason' => 'undefined' );
			}

			$respons = array_merge( $respons, array( 'controler' => $data[ 'view_controler' ], 'mode' => $data[ 'mode_type_controler' ] ) );

			echo json_encode( $respons );
			die();
		}//end edit_calendar


		public function delete_calendar(){
			check_ajax_referer( 'wtr_calendar_nonce' );

			$id_timetable = $this->clean_data( $_POST['id_timetable'] );

			if( true === self::$db_controler->delete_calendar( $id_timetable ) ){
				echo json_encode( array( 'status' => 'success' ) );
			}else{
				echo json_encode( array( 'status' => 'error' ) );
			}

			die();
		}//end delete_calendar


		//=== FUNCTION SCOPE

		private function cleanExtraParam( $data ){
			$result = array();

			foreach( $data as $key => $val ){
				if ( strpos( $key, 'txt_' ) ===false ){
					$result[ $key ] = $val;
				}
			}
			return $result;
		}//end cleanExtraParam


		private function transform_scope_items_to_days_scope( $scope ){
			$result = array();

			foreach( $scope as $id_scope => $scope_fields ){
				$day = $scope_fields[ 'day_of_the_week' ][ 'value' ];
				$result[ $day ][ $id_scope ] =  $scope_fields;
			}
			return $result;
		}//end transform_scope_items_to_days_scope


		private function generate_scope_instance( $start, $end, $day ){
			$scope		= array();
			$wsk_loop	= true;
			$end_ts		= strtotime( $end );

			$date_acc	= date_create( $start );
			$n_day		= date_format($date_acc, 'N' );
			$data_diff	= $day + 1 - $n_day;

			if( 0 != $data_diff ){
				if( 0 > $data_diff ){
					$data_diff = 7 - abs( $data_diff );
				}

				//calculate one instance on the calendar
				date_modify( $date_acc, '+' . $data_diff . ' day' );
			}

			while( $wsk_loop ){
				$tmp = date_format( $date_acc, 'Y-m-d' );

				if( strtotime( $tmp ) <= $end_ts ){
					array_push( $scope, $tmp );
					date_modify( $date_acc, '+7 day' );
				}else{
					$wsk_loop = false;
				}
			}

			return $scope;
		}//end generate_scope_instance

		private function check_differencs_scope( $data_org, $edit_data, $mode = 'simple' ){
			$result = array();

			if( 'simple' == $mode ){
				foreach( $edit_data as $field => $value ){

					if( isset( $data_org[ $field ] ) && $data_org[ $field ] != $value ){
						$result[ $field ] = $value;
					}
				}
			}else if( 'flag' == $mode ){
				foreach( $edit_data as $field => $value ){
					if( isset( $data_org[ $field ] ) && $data_org[ $field ][ 'value' ] != $value ){
						$result[ $field ] = $value;
					}
				}
			}

			return $result;
		}//end check_differencs_scope


		public function validate_calendar_scope_data( $data, $instance = null ){

			$h1			= $data[ 'time_hour_start' ] . ':' . $data[ 'time_minute_start' ];
			$h2			= $data[ 'time_hour_end' ] . ':' . $data[ 'time_minute_end' ];
			$s1			= ( isset( $data[ 'start_date' ] ) )? $data[ 'start_date' ] : current_time( 'Y-m-d' );
			$s2			= ( isset( $data[ 'end_date' ] ) )? $data[ 'end_date' ] : current_time( 'Y-m-d' );
			$id_classes	= ( isset( $data[ 'id_classes' ] ) )? $data[ 'id_classes' ] : '';
			$id_room	= ( isset( $data[ 'id_room' ] ) )? $data[ 'id_room' ] : '';
			$respons	= array();

			if ( 'NN' == $id_classes ){
				$respons = array( 'status' => 'error', 'reason' => 'id_classes' );
			}
			else if( 'NN' == $id_room ){
				$respons = array( 'status' => 'error', 'reason' => 'id_room' );
			}
			else if( 'NN' == $data[ 'trainers' ] || ';NN;' == $data[ 'trainers' ] ){
				$respons =  array( 'status' => 'error', 'reason' => 'trainers' );
			}
			else if( strtotime( $h1 ) >= strtotime( $h2 ) ){
				$respons =  array( 'status' => 'error', 'reason' => 'wrong_hour' );
			}
			else if( strtotime( $s1 ) > strtotime( $s2 ) ){
				$respons =  array( 'status' => 'error', 'reason' => 'wrong_scope' );
			}
			else if( true == is_null( $instance ) ||  0 == count( $instance ) ){
				$respons =  array( 'status' => 'error', 'reason' => 'no_instance' );
			}
			else{
				$respons =  array( 'status' => 'success' );
			}

			return $respons;
		}//end validate_calendar_scope_data


		public function scope_prev( $id_timetable ) {
			$calendar_data	= self::$db_controler->get_calendar( $id_timetable );
			$scope_list		= self::$db_controler->get_scope_list( $calendar_data );
			$scope_list		= $this->transform_scope_items_to_days_scope( $scope_list );
			self::$view_controler->scope_calendar_list_preview( $calendar_data, $scope_list );
		}// end week_page_html


		public function add_calendar_scope(){
			check_ajax_referer( 'wtr_calendar_scope_new_opt_nonce' );

			$data	= array();
			$fields	= urldecode( $_POST[ 'field' ] );
			$fields	= utf8_decode( $fields );

			parse_str( $fields, $data );

			$data		= $this->clean_data( $data );
			$instance	= $this->generate_scope_instance(
				$data[ 'start_date' ],
				$data[ 'end_date' ],
				$data[ 'day_of_the_week' ]
			);

			$valid		= $this->validate_calendar_scope_data( $data, $instance );

			if( $valid[ 'status' ] == 'success' ){
				$data_p	= $data;
				$scope	= array(
					'id_timetable'		=> $data_p[ 'id_timetable' ],
					'id_classes'		=> $data_p[ 'id_classes' ],
					'day_of_the_week'	=> $data_p[ 'day_of_the_week' ],
					'start_date'		=> $data_p[ 'start_date' ],
					'end_date'			=> $data_p[ 'end_date' ],
				);

				unset(
					$data_p[ 'view_controler' ],
					$data_p[ 'mode_type_controler' ],
					$data_p[ 'id_timetable' ],
					$data_p[ 'id_classes' ],
					$data_p[ 'day_of_the_week' ],
					$data_p[ 'start_date' ],
					$data_p[ 'end_date' ]
				);

				$result = self::$db_controler->create_calendar_scope(
					$scope, $this->cleanExtraParam( $data_p ),
					$instance
				);

				if( true === $result[ 'status' ] ){
					$dataT = $this->transform_data_array( $data );

					$respons = array(
						'status' 	=> 'success',
						'day'		=> $dataT[ 'day_of_the_week' ][ 'value' ],
						'code'		=> self::$view_controler->draw_calendar_scope_item(
							self::$db_controler->get_calendar( $scope[ 'id_timetable' ] ),
							$result[ 'id_scope' ], $dataT
						)
					);
				}else{
					$respons = array( 'status' => 'error', 'reason' => 'undefined' );
				}

			}else{
				$respons = $valid;
			}

			$respons = array_merge( $respons, array( 'controler' => $data[ 'view_controler' ], 'mode' => $data[ 'mode_type_controler' ] ) );

			echo json_encode( $respons );
			die();
		}//end add_calendar_scope


		public function edit_calendar_scope(){

			//prepare nonce
			check_ajax_referer( 'wtr_calendar_scope_edit_opt_nonce' );

			$data	= array();
			$fields	= urldecode( $_POST[ 'field' ] );
			$fields	= utf8_decode( $fields );

			parse_str( $fields, $data );

			$data		= $this->clean_data( $data );
			$valid		= $this->validate_calendar_scope_data( $data, array( 'null' ) );

			if( $valid[ 'status' ] == 'success' ){
				$overwrite		= $data[ 'overwrite' ];
				$id_scope		= $data[ 'id_scope' ];
				$id_timetable	= $data[ 'id_timetable' ];
				$day			= $data[ 'day_of_the_week' ];
				$data_p			= $data;

				//prepare data
				$org_data	= self::$db_controler->get_scope( $id_scope );
				$edit_data	= $this->cleanExtraParam( $data_p );

				if( !$overwrite ){
					$edit_data	= $this->check_differencs_scope( $org_data, $edit_data );
				}

				if( isset( $edit_data[ 'id_classes' ] ) ){
					$scope = array( 'id_classes' => $edit_data[ 'id_classes' ] );
					unset( $edit_data[ 'id_classes' ] );
				}else{
					$scope = array();
				}

				$result = self::$db_controler->edit_calendar_scope(
					$id_scope,
					$scope,
					$edit_data,
					$overwrite
				);

				if( true === $result[ 'status' ] ){
					if( true === $result[ 'change' ] ){
						$dataT		= $this->transform_data_array( $data );
						$respons	= array(
							'status'	=> 'success',
							'change'	=> true,
							'day'		=> $day,
							'id_scope'	=> $id_scope,
							'code'		=> self::$view_controler->draw_calendar_scope_item(
								self::$db_controler->get_calendar( $id_timetable ),
								$id_scope, $dataT
							)
						);
					}else{
						$respons = array(
							'status'	=> 'success',
							'change'	=> false
							);
					}
				}else{
					$respons = array( 'status' => 'error', 'reason' => 'undefined' );
				}

			}else{
				$respons = $valid;
			}

			$respons = array_merge( $respons, array( 'controler' => $data[ 'view_controler' ], 'mode' => $data[ 'mode_type_controler' ] ) );

			echo json_encode( $respons );
			die();
		}//end edit_calendar_scope


		public function delete_calendar_scope(){
			check_ajax_referer( 'wtr_scope_nonce' );

			$id_scope = $this->clean_data( $_POST['id_scope'] );

			if( true === self::$db_controler->delete_scope( $id_scope ) ){
				echo json_encode( array( 'status' => 'success' ) );
			}else{
				echo json_encode( array( 'status' => 'error' ) );
			}

			die();
		}//end delete_calendar_scope


		//=== FUNCTION INSTANCE

		private function get_scope_instance( $select_date ){
			$result		= array();
			$date_start = date_create( $select_date );
			$date_end	= date_create( $select_date );
			$date_acc	= date_create( $select_date );
			$n_day		= date_format($date_acc, 'N' ) - 1;
			$days		= array();
			$days_f		= array();
			$start;
			$end;

			if( 0 != $n_day ){
				date_modify( $date_start, '-' . $n_day . ' day' );
				$start = $tmp = date_format( $date_start, 'Y-m-d' );
			}else{
				$start = $select_date;
			}

			$date_acc_f = date_create( $start );
			$date_acc_s = date_format( $date_acc_f, 'Y-m-d' );

			$days[ $date_acc_s ] = 0;
			$days_f[ 0 ] = $date_acc_s;
			for( $i = 1; $i < 7; $i++ ){
				date_modify( $date_acc_f, '+1 day' );
				$date_acc_s = date_format( $date_acc_f, 'Y-m-d' );
				$days[ $date_acc_s ] = $i;
				$days_f[ $i ] = $date_acc_s;
			}

			return array( 'n_day' => $n_day, 'days' => $days, 'days_f' => $days_f );
		}//end get_scope_instance


		public function instance_prev( $id_timetable ) {
			$calendar_data	= self::$db_controler->get_calendar( $id_timetable );

			if( 'static' == $calendar_data[ 'type' ] ){
				$scope = null;
			}else if( 'multi_week' == $calendar_data[ 'type' ] ){
				$date	= strip_tags( $_GET[ 'date' ] );
				$scope	= $this->get_scope_instance( $date );
			}

			$rande_calendar	= self::$db_controler->get_calendar_date_scope( $calendar_data );
			$instance_list	= self::$db_controler->get_instance_list( $calendar_data, $scope[ 'days' ] );

			self::$view_controler->instance_calendar_list_preview( $calendar_data, $instance_list, $scope, $rande_calendar );
		}// end static_page_html


		public function add_calendar_instance(){
			check_ajax_referer( 'wtr_calendar_instance_new_opt_nonce' );

			$data	= array();
			$fields	= urldecode( $_POST[ 'field' ] );
			$fields	= utf8_decode( $fields );

			parse_str( $fields, $data );

			$data		= $this->clean_data( $data );

			$valid		= $this->validate_calendar_scope_data( $data, array( 'null' ) );

			if( $valid[ 'status' ] == 'success' ){
				$data_p = $data;

				$main_field = array(
					'id_timetable'		=> $data_p[ 'id_timetable' ],
					'id_classes'		=> $data_p[ 'id_classes' ],
					'day_of_the_week'	=> $data_p[ 'day_of_the_week' ],
				);

				unset(
					$data_p[ 'view_controler' ],
					$data_p[ 'mode_type_controler' ],
					$data_p[ 'id_timetable' ],
					$data_p[ 'id_classes' ],
					$data_p[ 'day_of_the_week' ],
					$data_p[ 'type' ]
				);

				$result = self::$db_controler->create_calendar_static_instance(
					$main_field,
					$this->cleanExtraParam( $data_p )
				);

				if( true === $result[ 'status' ] ){
					$dataT = $this->transform_data_array( $data );

					$respons = array(
						'status' 	=> 'success',
						'day'		=> $dataT[ 'day_of_the_week' ][ 'value' ],
						'code'		=> self::$view_controler->draw_calendar_instance_item(
							self::$db_controler->get_calendar( $main_field[ 'id_timetable' ] ),
							$result[ 'id_instance' ],
							$dataT,
							$data[ 'type' ]
						)
					);
				}else{
					$respons = array( 'status' => 'error', 'reason' => 'undefined' );
				}

			}else{
				$respons = $valid;
			}

			$respons = array_merge( $respons, array( 'controler' => $data[ 'view_controler' ], 'mode' => $data[ 'mode_type_controler' ] ) );

			echo json_encode( $respons );
			die();
		}//end add_calendar_instance


		public function edit_calendar_instance(){
			//prepare nonce
			check_ajax_referer( 'wtr_calendar_instance_edit_opt_nonce' );

			$data	= array();
			$fields	= urldecode( $_POST[ 'field' ] );
			$fields	= utf8_decode( $fields );

			parse_str( $fields, $data );

			$data		= $this->clean_data( $data );
			$valid		= $this->validate_calendar_scope_data( $data, array( 'null' ) );

			if( $valid[ 'status' ] == 'success' ){

				$id_instance	= $data[ 'id_instance' ];
				$id_timetable	= $data[ 'id_timetable' ];
				$type			= $data[ 'type' ];
				$data_p			= $data;
				$main_data		= null;

				unset(
					$data_p[ 'id_instance' ],
					$data_p[ 'type' ],
					$data_p[ 'id_timetable' ],
					$data_p[ 'view_controler' ],
					$data_p[ 'mode_type_controler' ]
				);

				//prepare data
				$org_data	= self::$db_controler->get_instance( $type, $id_instance );

				$edit_data	= $this->cleanExtraParam( $data_p );
				$edit_data	= $this->check_differencs_scope( $org_data, $edit_data, 'flag' );

				if( 'multi_week' == $data[ 'type' ] ){
					$flag = 'flag_1';
				}else if( 'static' == $data[ 'type' ] ){

					if( isset( $edit_data[ 'id_classes' ] ) ){
						$main_data[ 'id_classes' ] = $edit_data[ 'id_classes' ];
					}

					if( isset( $edit_data[ 'day_of_the_week' ] ) ){
						$main_data[ 'day_of_the_week' ] = $edit_data[ 'day_of_the_week' ];
					}
					$flag = 'flag_0';
				}

				$result = self::$db_controler->edit_calendar_instance(
					$type,
					$id_instance,
					$edit_data,
					$main_data
				);

				if( true === $result[ 'status' ] ){

					if( true === $result[ 'change' ] ){

						$dataT	= $this->transform_data_array( $edit_data, $flag );
						$dataN	= $this->transform_data_array( $data );
						$dataT	= array_merge( $edit_data, $dataT );
						$dataT	= array_merge( $dataN, $org_data, $dataT );

						$respons = array(
							'status'		=> 'success',
							'change'		=> true,
							'id_instance'	=> $id_instance,
							'day'			=> ( isset( $data[ 'day_of_the_week' ] ) )? $data[ 'day_of_the_week' ] : '',
							'code'			=> self::$view_controler->draw_calendar_instance_item(
								self::$db_controler->get_calendar( $id_timetable ),
								$id_instance,
								$dataT,
								$type
							)
						);
					}else{
						$respons = array(
							'status'	=> 'success',
							'change'	=> false
							);
					}

				}else{
					$respons = array( 'status' => 'error', 'reason' => 'undefined' );
				}
			}else{
				$respons = $valid;
			}

			$respons = array_merge( $respons, array( 'controler' => $data[ 'view_controler' ], 'mode' => $data[ 'mode_type_controler' ] ) );

			echo json_encode( $respons );
			die();
		}//end edit_calendar_instance


		public function delete_calendar_instance(){
			check_ajax_referer( 'wtr_instance_nonce' );

			$id_instance = $this->clean_data( $_POST['id_instance'] );
			$type = $this->clean_data( $_POST['type'] );

			if( true === self::$db_controler->delete_instance( $id_instance, $type ) ){
				echo json_encode( array( 'status' => 'success' ) );
			}else{
				echo json_encode( array( 'status' => 'error' ) );
			}

			die();
		}//end delete_calendar_instance


		public function min_unique_id( $instance_id ){
			$l = 10 - strlen( $instance_id );
			return $instance_id . str_repeat( '0', $l );
		}

		public function convert_event_time( $format, $hour ){
			$result = $hour;

			if( '0' != $format ){
				$time_f  = ( '1' == $format ) ? 'pm' : 'am' ;
				$time_temp = new DateTime( $hour . $time_f );
				$x = $time_temp->format( 'H' );

				$result = intval( $x );
			}
			return $result;
		}//end convert_event_time


		public function convert_std_schedule_to_hours_format( $calendar_data ){
			$result		= array();
			$result_m	= array();

			if( count( $calendar_data[ 'instance_admin' ] ) ){
				foreach( $calendar_data[ 'instance_admin' ] as $day => $schedule ){
					foreach( $schedule as $instance_id => $data ){
						// instance_public
						if( !isset( $result[ $data[ 'time_hour_start' ][ 'value' ] ] ) ){
							$result[ $data[ 'time_hour_start' ][ 'value' ] ] = array();
							$result[ $data[ 'time_hour_start' ][ 'value' ] ][ $data[ 'day_of_the_week' ][ 'value' ] ] = array();
						}else if( !isset( $result[ $data[ 'time_hour_start' ][ 'value' ] ][ $data[ 'day_of_the_week' ][ 'value' ] ] ) ){
							$result[ $data[ 'time_hour_start' ][ 'value' ] ][ $data[ 'day_of_the_week' ][ 'value' ] ] = array();
						}
						$result[ $data[ 'time_hour_start' ][ 'value' ] ][ $data[ 'day_of_the_week' ][ 'value' ] ][ $data[ 'time_minute_start' ][ 'value' ] . $this->min_unique_id( $instance_id ) ] = array_merge( $data, array( 'type_data' => 'class' ) );

						//instance_public_mobile
						if( !isset( $result_m[ $day ][ $data[ 'time_hour_start' ][ 'value' ] ] ) ){
							$result_m[ $day ][ $data[ 'time_hour_start' ][ 'value' ] ] = array();
						}
						$result_m[ $day ][ $data[ 'time_hour_start' ][ 'value' ] ][ $data[ 'time_minute_start' ][ 'value' ] . $this->min_unique_id( $instance_id ) ] = array_merge( $data, array( 'type_data' => 'class' ) );
					}
				}
			}

			// event
			if( count( $calendar_data[ 'instance_event' ] ) ){
				foreach( $calendar_data[ 'instance_event' ] as $id_event => $event ){


					$ext_data = array(
						'type_data'	=> 'event',
						'id_event'	=> $id_event,
						'h_start'	=> $this->convert_event_time( $event[ '_wtr_event_time_start_type' ], $event[ '_wtr_event_time_start_h' ] ),
						'h_end'		=> $this->convert_event_time( $event[ '_wtr_event_time_end_type' ], $event[ '_wtr_event_time_end_h' ] ),
					);

					$result[ $ext_data[ 'h_start' ] ][ $event[ 'day' ] ][ $event[ '_wtr_event_time_start_m' ] . $this->min_unique_id( $id_event ) ] = array_merge( $event, $ext_data );
					$result_m[ $event[ 'day' ] ][ $ext_data[ 'h_start' ] ][ $event[ '_wtr_event_time_start_m' ] . $this->min_unique_id( $id_event ) ] = array_merge( $event, $ext_data );
				}
			}

			ksort( $result, SORT_NUMERIC );

			for( $i=0; $i < 7; $i++ ){
				if( isset( $result_m[ $i ] ) ){
					ksort( $result_m[ $i ], SORT_NUMERIC );

					if( count( $result_m[ $i ] ) ){
						foreach( $result_m[ $i ] as $key => $val ){
							ksort( $result_m[ $i ][ $key ], SORT_NUMERIC );
						}
					}
				}
			}

			$calendar_data[ 'instance_public' ] = $result;
			$calendar_data[ 'instance_public_mobile' ] = $result_m;
			return $calendar_data;
		}


		public function public_class_filter(){
			$id_render		= intval( $_GET[ 'idx' ] );
			$id_calendar	= intval( $_GET[ 'id_calendar' ] );
			$type			= htmlentities( strip_tags( $_GET[ 'type' ] ) );

			$calendar_data = self::$db_controler->get_calendar_classes_full_data( $id_calendar, $type );
			self::$view_controler->draw_filter_calendar_classes_public( $id_calendar, $calendar_data, $id_render );
			die();
		}//end public_class_filter


		public function public_class_detail(){
			$idx		= intval( $_GET[ 'idx' ] );
			$id_classes	= intval( $_GET[ 'class' ] );
			$time		= intval( $_GET[ 'time' ] );
			$show_level = ( 'no'== $_GET[ 'level' ] )? 'no' : 'yes';

			$type		= htmlentities( strip_tags( $_GET[ 'type' ] ) );
			$calendar_data = self::$db_controler->get_calendar_classes_item_data( $idx, $type, $id_classes );
			self::$view_controler->draw_calendar_item_public( $calendar_data, $time, $show_level );
			die();
		}//end public_class_detail


		public function public_get_week(){
			check_ajax_referer( 'wtr_calendar_public_nonce' );

			$id_schedule	= intval( $_POST[ 'calendar' ] );
			$direction		= htmlentities( strip_tags( $_POST[ 'direction' ] ) );
			$day			= htmlentities( strip_tags( $_POST[ 'day' ] ) );
			$modal			= htmlentities( strip_tags( $_POST[ 'modal' ] ) );
			$show_level		= htmlentities( strip_tags( $_POST[ 'modal' ] ) );
			$empty_hours	= htmlentities( strip_tags( $_POST[ 'hours' ] ) );
			$id_class		= htmlentities( strip_tags( $_POST[ 'id_class' ] ) );
			$clickable		= htmlentities( strip_tags( $_POST[ 'clickable' ] ) );
			$show_weekend	= htmlentities( strip_tags( $_POST[ 'showweekend' ] ) );

			$day_n = date_create( $day );
			if( 'prev' == $direction ){
				date_modify( $day_n, '-7 day' );
			}else{
				date_modify( $day_n, '+7 day' );
			}
			$day = date_format( $day_n, 'Y-m-d' );

			if( !isset( $empty_hours ) ){
				$empty_hours = 'no';
			}

			if( !isset( $show_level ) ){
				$show_level = 'no';
			}

			if( !isset( $id_class ) ){
				$id_class = 'wtr_all_items';
			}

			if( !isset( $clickable ) ){
				$clickable = 'yes';
			}

			if( !isset( $show_weekend ) ){
				$show_weekend = 'yes';
			}

			$calendar_data		= self::$db_controler->get_calendar( $id_schedule );
			$scope				= $this->get_scope_instance( $day );
			$calendar_data		= self::$db_controler->get_calendar_full_data( $calendar_data, $scope, 'public', $id_class, $clickable, $show_weekend );


			$full_data			= $this->convert_std_schedule_to_hours_format( $calendar_data );
			$html_data			= self::$view_controler->draw_calendar_in_public_table( $full_data, $modal, $show_level, $empty_hours, $clickable, $show_weekend );

			$scope[ 'days_f' ]	= $this->change_the_format_days( $scope[ 'days_f' ] );
			$respons			= array( 'html_data' => $html_data, 'scope' => $scope );

			echo json_encode( $respons );
			die();
		}//end public_get_week


		public function change_the_format_days( $days ){
			global $wtr_date_format;
			$date_format = get_option( 'wtr_classes_schedule_date_format' );
			$date_format = $wtr_date_format[$date_format];

			$result = array();

			foreach( $days as $d ){
				array_push( $result, date_i18n( $date_format[ 'all' ], strtotime( $d  ) ) );
			}

			return $result;
		}//end change_the_format_days

		//=== RENDER
		public function render_class_schedule( $atts, $content = null ){

			extract( $atts );

			if( 'wtr_select_item' == $id_schedule ){
				return self::$view_controler->draw_alert_info_wrong_data_id_schedule( 'class schedule' );
			}

			if( !isset( $pdf_url ) ){
				$pdf_url = '';
			}

			$calendar_data = self::$db_controler->get_calendar( $id_schedule );

			if( count( $calendar_data ) ){
				if( 'static' == $calendar_data[ 'type' ] ){
					$scope = null;
				}else if( 'multi_week' == $calendar_data[ 'type' ] ){
					$scope	= $this->get_scope_instance( current_time( 'Y-m-d' ) );
				}

				if( !isset( $empty_hours ) ){
					$empty_hours = 'no';
				}

				if( !isset( $show_level ) ){
					$show_level = 'no';
				}

				if( !isset( $id_class ) ){
					$id_class = 'wtr_all_items';
				}

				if( !isset( $clickable ) ){
					$clickable = 'yes';
				}

				if( !isset( $show_weekend ) ){
					$show_weekend = 'yes';
				}

				$calendar_data = self::$db_controler->get_calendar_full_data( $calendar_data, $scope, 'public', $id_class );

				$full_data = $this->convert_std_schedule_to_hours_format( $calendar_data );

				ob_start();
				self::$view_controler->draw_calendar_in_public( $full_data, $version, self::$sht_count, $modal, $scope, $pdf, $pdf_url, $show_level, $empty_hours, $id_class, $clickable, $show_weekend );
				self::$view_controler->draw_calendar_in_public_mobile( $full_data, self::$sht_count, $scope, $id_class, $clickable, $show_weekend );

				$result = ob_get_clean();

			}else{
				$result = self::$view_controler->draw_alert_info_wrong_data_id();
			}
			self::$sht_count++;

			return $result;
		}//end render


		public function render_daily_schedule( $atts, $content = null ){

			extract( $atts );

			if( 'wtr_select_item' == $id_schedule ){
				return self::$view_controler->draw_alert_info_wrong_data_id_schedule( 'daily schedule' );
			}

			if( !isset( $el_class ) ){
				$el_class = '';
			}

			$calendar_data	= self::$db_controler->get_calendar( $id_schedule );

			if( count( $calendar_data ) ){
				$data			= self::$db_controler->get_calendar_daily_data( $calendar_data );
				$today_data		= $this->convert_std_schedule_to_hours_format( $data );

				if( !isset( $show_level ) ){
					$show_level = 'no';
				}

				ob_start();
				self::$view_controler->draw_calendar_daily_in_public( $today_data, $el_class, $show_level );
				$result = ob_get_clean();
			}
			else{
				$result = self::$view_controler->draw_alert_info_wrong_data_id();
			}

			return $result;
		}//end render_daily_schedule

	}//end WTR_Shortcodes_Controler
}