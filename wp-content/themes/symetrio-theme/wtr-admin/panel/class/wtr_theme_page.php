<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

if ( ! class_exists( 'WTR_Theme_Page' ) ) {

	class WTR_Theme_Page extends WTR_Core {

		private $settings = array();
		public $theme_page;

		public function __construct( $settings = array() ){

			$this->settings = $settings;

			//register setting
			add_action('admin_init', array( &$this, 'register_admin_scripts') );

			//icons
			add_action('admin_init', array( &$this, 'init_enqueue_admin') );

			//mega menu
			add_action('admin_print_styles-nav-menus.php', array( &$this, 'init_enqueue_admin_mega_menu') );

			//dashboard
			add_action('admin_print_styles-index.php', array( &$this, 'init_enqueue_admin_dashboard') );

			//options page
			add_action('admin_menu', array( &$this, 'create_options_page') );

			// Register the new dashboard widget
			add_action('wp_dashboard_setup', array( &$this, 'rating_dashboard_widgets' ) );
			add_action('wp_dashboard_setup', array( &$this, 'forum_dashboard_widgets' ) );

		}// end __construct


		public function create_options_page(){
			$this->theme_page = add_theme_page(
				sprintf( __( 'Theme Option -  %1$s', ucfirst( WTR_THEME_NAME ) ), WTR_THEME_NAME ),
				sprintf( __( 'Theme Option -  %1$s', ucfirst( WTR_THEME_NAME ) ), WTR_THEME_NAME ),
				'manage_options',
				'wtr_theme_page',
				array(&$this, 'create_options_page_html')
			);

			add_action('admin_print_styles-'. $this->theme_page , array(&$this, 'init_enqueue'));


			//register setting
			$wp_opt_name	= $this->settings->get_WP_OPT_NAME();
			register_setting( $wp_opt_name, $wp_opt_name, array( &$this, 'wtr_validate_options' ) );
			add_action( 'load-' . $this->theme_page, array( &$this, 'init_register_setting') );
		}// end create_options_page


		public function init_enqueue_admin(){
			wp_enqueue_style( 'menu_icons' );
		}// end init_enqueue_admin


		public function init_enqueue_admin_mega_menu(){
			wp_enqueue_media();
			wp_enqueue_style( 'mega_menu' );
			wp_enqueue_script( 'mega_menu' );
		}// end init_enqueue_admin_mega_menu

		public function init_enqueue_admin_dashboard(){
			wp_enqueue_style( 'wtr_dashboard' );
		}// end init_enqueue_admin_dashboard



		public function register_admin_scripts(){

			// ==== register Stylesheets
			wp_register_style( 'site', WTR_ADMIN_URI . '/panel/css/site.css' );
			wp_register_style( 'normalize', WTR_ADMIN_URI . '/panel/css/normalize.css' );
			wp_register_style( 'aristo', WTR_ADMIN_URI . '/panel/css/aristo/aristo.css' );
			wp_register_style( 'minicolors', WTR_ADMIN_URI . '/panel/css/minicolors/jquery.minicolors.css' );
			wp_register_style( 'prettyCheckable', WTR_ADMIN_URI . '/panel/js/prettyCheckable/prettyCheckable.css' );
			wp_register_style( 'prettyCheckable', WTR_ADMIN_URI . '/panel/js/prettyCheckable.css' );
			wp_register_style( 'mega_menu', WTR_ADMIN_URI . '/panel/js/mega-menu/mega-menu.css' );
			wp_register_style( 'wtr_dashboard', WTR_ADMIN_URI . '/panel/css/dashboard.css' );
			wp_register_style( 'pikaday', WTR_ADMIN_URI . '/panel/css/pikaday.css' );

			//==== menu items
			wp_register_style( 'menu_icons', WTR_ADMIN_URI . '/panel/css/menu_icons.css' );
				// shortcode builder
				wp_register_style( 'font_awesome', WTR_THEME_URI . '/assets/css/font-awesome.min.css' );
				wp_enqueue_style( 'animation_css', WTR_THEME_URI . '/assets/css/animation_css.css' );

			//==== Register Scripts
			wp_register_script( 'minicolors', WTR_ADMIN_URI . '/panel/js/jquery.minicolors.js', false, WTR_THEME_VERSION );
			wp_register_script( 'gmaps', 'http://maps.googleapis.com/maps/api/js?sensor=false', false );
			wp_register_script( 'wtr_google_maps_style', WTR_THEME_URI . '/assets/js/wtr_google_maps_style.js', false, WTR_THEME_VERSION, true );
			wp_register_script( 'obj_loader', WTR_ADMIN_URI . '/panel/js/obj.loader.js', false, WTR_THEME_VERSION, true );
			wp_register_script( 'tiny_modal', WTR_ADMIN_URI . '/panel/js/jquery.leanModal.min.js', false );
			wp_register_script( 'prettyCheckable', WTR_ADMIN_URI . '/panel/js/prettyCheckable/prettyCheckable.js', false );
			wp_register_script( 'admin_panel_j', WTR_ADMIN_URI . '/panel/js/admin.panel.js', false, WTR_THEME_VERSION, true );
			wp_register_script( 'jqueryForm', WTR_ADMIN_URI . '/panel/js/jquery.form.js', false );
			wp_register_script( 'mega_menu', WTR_ADMIN_URI . '/panel/js/mega-menu/mega-menu.js', false );
			wp_register_script( 'moment', WTR_ADMIN_URI . '/panel/js/moment.js', false );
			wp_register_script( 'pikaday', WTR_ADMIN_URI . '/panel/js/pikaday.js', false );
		}// end register_admin_scripts


		public function init_enqueue(){

			// ==== Enqueue Stylesheets
			wp_enqueue_style( 'site' );

			wp_enqueue_style( 'normalize' );
			wp_enqueue_style( 'aristo' );
			wp_enqueue_style( 'minicolors' );
			wp_enqueue_style( 'thickbox' );
			wp_enqueue_style( 'media-upload' );
			wp_enqueue_style( 'prettyCheckable' );

			// Enqueue Scripts
			//wp_enqueue_script('jquery-mini');
			wp_enqueue_media();
			wp_enqueue_script( 'jquery' );
			wp_enqueue_script('jquery-ui');
			wp_enqueue_script( 'jquery-ui-slider' );

			wp_enqueue_script( 'thickbox' );
			wp_enqueue_script( 'media-upload' );
			wp_enqueue_script( 'minicolors' );
			wp_enqueue_script( 'tiny_modal' );
			wp_enqueue_script( 'prettyCheckable' );
			wp_enqueue_script( 'jqueryForm' );
			wp_enqueue_script( 'obj_loader' );
			wp_enqueue_script( 'admin_panel_j' );

			//params for admin_panel_j
			$params = array(
					'uri'		=> WTR_ADMIN_URI,
					'uri_class'	=> WTR_ADMIN_CLASS_URI,
					'ajaxurl'	=> admin_url( 'admin-ajax.php' ),
				);
			wp_localize_script( 'admin_panel_j', 'wp_param_admin_panel', $params );
		}// end init_enqueue


		public function rating_dashboard_widget_function( $post, $callback_args ) {
			echo "<span>Let anybody know that our product is awesome! </span></br></br>";
			echo "It will take you literally a moment, just click the button below and leave us a 5 star rating. </br>We are really appreciate for your support, by leaving the rating you are contributing to the dynamic development of our product.</br></br>";
			echo '<a href="http://themeforest.net/downloads" target="_blank" class="button button-primary ">Rate Symetrio</a></br></br> ';
			echo 'or, <a href="http://themeforest.net/item/symetrio-multisport-gym-fitness-theme/9634580/comments" target="_blank">leave us a comment</a>';
		} // end rating_dashboard_widget_function


		public function rating_dashboard_widgets() {

			$widget_id		= 'wtrRateUs';
			$widget_name	= 'Rate our product';
			$callback		=  array( &$this, 'rating_dashboard_widget_function' );
			$location		= 'normal';
			$priority		= 'high';
			$callback_args	= null;
			$screen			= get_current_screen();
			add_meta_box( $widget_id, $widget_name, $callback, $screen, $location, $priority, $callback_args );

		} // end rating_dashboard_widgets


		public function forum_dashboard_widget_function( $post, $callback_args ) {
			echo "<span>None of our clients will be left without a help.</span></br></br>";
			echo "We want you to know that deciding to purchase one of our products you get something more than just a WordPress Theme.</br>";
			echo "If you need help or you’ve found a problem, please feel free to contact with us. We can promise that we’ll do our best to help you quick as possible. We are appreciate for your support. </br></br>";
			echo '<a href="http://support.wonster.co/" target="_blank" class="button button-primary ">Yes, I need help</a></br></br> ';
		} // end forum_dashboard_widget_function


		public function forum_dashboard_widgets() {

			$widget_id		= 'wtrSupport';
			$widget_name	= 'Premium Support';
			$callback		=  array( &$this, 'forum_dashboard_widget_function' );
			$location		= 'side';
			$priority		= 'high';
			$callback_args	= null;
			$screen			= get_current_screen();
			add_meta_box( $widget_id, $widget_name, $callback, $screen, $location, $priority, $callback_args );

		} // end forum_dashboard_widgets


		public function create_options_page_html(){
		?>
			<form method="post" action="options.php" enctype="multipart/form-data" id="wtr_form_settings">

			<?php
				$wp_opt_name = $this->settings->get_WP_OPT_NAME();
				settings_fields( $wp_opt_name );

				$message_admin = get_option( $this->settings->get_WP_ERROR(), 'none' );

				// draw alets
				$this->create_alerts_element_html( $message_admin) ;
			?>
				<div class="container">
					<div class="wonsterFrame wtrUIContener">
						<div class="head">
							<div class="logoSec">
								<a href="http://wonster.co" target="_blank" class="themeName"><?php echo  WTR_THEME_NAME ?></a>
								<span class="softVersion">
									 <?php _e( 'ver.', WTR_THEME_NAME ); echo WTR_THEME_VERSION ?>
								</span>
							</div>
							<div class="headLinks">
								<ul class="moreLinks">
									<li>
										<a href="http://support.wonster.co/" target="_blank" class="WonButton head headBtn support"><?php  _e( 'Support', WTR_THEME_NAME ) ?></a>
									</li>
									<li>
										<a href="http://support.wonster.co/manual/<?php echo strtolower( WTR_THEME_NAME ); ?>" target="_blank" class="WonButton head headBtn manual"><?php  _e( 'Manual', WTR_THEME_NAME ) ?></a>
									</li>
									<li>
										<a href="http://wonster.co/get-xml/" target="_blank" class="WonButton head headBtn xml"><?php  _e( 'XML Demo', WTR_THEME_NAME ) ?></a>
									</li>
									<li>
										<a href="http://themeforest.net/downloads" target="_blank" class="WonButton head headBtn rateUs"><?php  _e( 'Rate Symetrio', WTR_THEME_NAME ) ?></a>
									</li>
								</ul>
								<a href="http://wonster.co" target="_blank" class="wonsterLogo floatRight"></a>
								<div class="clear"></div>
							</div>
							<div class="clear"></div>
						</div>
						<div class="main">
							<div class="nav">
								<ul class="mainNav">
								<?php
									$wtrPanelStartAcrtive = 0;
									foreach ( $this->settings->get( 'opt' ) as  $group ) {
										if( 0 == $wtrPanelStartAcrtive ){
											$wtrflagActiveGo = 'block';
											$wtrflagActiveMain = 'navActive';
										}
										else{
											$wtrflagActiveGo = 'none';
											$wtrflagActiveMain = '';
										}

										$wtrPanelStartAcrtive++;
									?>
									<li>
										<a id="<?php echo $group->get( 'class' ) ?>" class="<?php echo $group->get('class') ?> wtr_admin_group <?php echo $wtrflagActiveMain; ?>"  href=""><?php echo $group->get( 'title' ) ?> </a>
										<ul class="secNav" style="display:<?php echo $wtrflagActiveGo; ?>">
											<?php foreach ($group->get('sections') as $section) { ?>
												<li><a id="<?php echo $section->get( 'id' ); ?>" href="" class="wtr_admin_select"> <?php  echo $section->get( 'title' );  ?> </a></li>
											<?php } ?>
										</ul>
									</li>
								<?php } ?>
								</ul>
							</div>
							<div class="content">
								<div class="settings">
									<div class="setNag"><span class="wtr_admin_active_group_title"></span><span class="slash">\</span><span class="underCat wtr_admin_active_section_title"></span>
										<input class="WonButton yellow floatRight wtr_save_form" name="Submit" type="submit" value="<?php  _e( 'Save', WTR_THEME_NAME ) ?>" />
									</div>
									<div class="ui-form">
									<?php
										// draw modals
										$this->create_modals_element_html();

										foreach ( $this->settings->get( 'opt' ) as  $group ) {
											foreach ( $group->get( 'sections' ) as  $section) {?>
												<div id="<?php echo $section->get( 'id' ) . '_section' ?>">
												<?php
													$this->do_settings_sections( $section->get( 'id' ) . '_section_group' );
												?>
												</div>
												<?php
											}
										}
									?>
									</div>
										<div class="footBtns">
											<a  id="go" rel="leanModal" name="wonsterModal" href="#wonsterModalDefault" class="WonButton blue"><?php  _e( 'Default Settings', WTR_THEME_NAME ) ?></a>
											<!-- <a href="" id="dialog_link" ><?php  _e( 'Default Settings', WTR_THEME_NAME ) ?></a> -->
											<input class="WonButton yellow floatRight wtr_save_form" name="Submit" type="submit" value="<?php  _e( 'Save', WTR_THEME_NAME ) ?>" />
											<div class="clear"></div>
										</div>
									<div class="clear"></div>
								</div>
								<div class="clear"></div>
							</div>
							<div class="clear"></div>
						</div>
						<div class="copy">© 2013 Made With fire by <a href="http://wonster.co" target="blank" class="miniLogo">Wonster</a></div>
					</div>
					<div class="clear"></div>
				</div>
			<input type="hidden" name="submitControl" class="wtr_admin_submit_control" value="" />
		</form>
		<?php
		}// end create_options_page_html


		private function create_alerts_element_html($message_admin){

			//$message_admin - default / import_data / none / import_error
			if( $message_admin ){
				update_option( $this->settings->get_WP_ERROR(), 'none' );
			}

			if( 'default' == $message_admin || 'import_data' == $message_admin || 'import_error' == $message_admin ){

				$visablePopup = 'display:block';
				$visablePopupDefault = $visablePopupImport = $visablePopupImportErr =  'display:none';

				if( 'default' == $message_admin ){
					$visablePopupDefault = 'display:block';
				} else if( 'import_data' == $message_admin ){
					$visablePopupImport = 'display:block';
				} else if( 'import_error' == $message_admin ){
					$visablePopupImportErr = 'display:block';
				}
			}
			else{
				$visablePopupDefault = $visablePopupImport = $visablePopupImportErr = 'display:none';
				$visablePopup = 'display:none';
			}
			?>

			<!-- ALERTS -->
			<div class="saveInfo"  style="<?php echo $visablePopup;?>">

				<!-- save error -->
				<div class="saveInfoNag saveInfoNagErr wtr_adimin_option_msg  <?php echo 'wtr_admin_set_alert_'.$message_admin; ?>" style="<?php echo $visablePopupImportErr; ?>">
					<div class="infoError"><?php  _e( 'Save error', WTR_THEME_NAME ) ?></div>
					<div class="btnInfo">
						<a href="" class="WonButton red infoErrorBtn"> <?php  _e( 'Ok, I understand', WTR_THEME_NAME ) ?></a>
					</div>
				</div>

				<!-- restore default settings success -->
				<div  style="<?php echo $visablePopupDefault;?>" class="saveInfoNag restoreInfoNagOk <?php echo 'wtr_admin_set_alert_'.$message_admin; ?> wtr_adimin_option_msg">
					<div class="infoOk"><?php  _e( 'Restored default settings', WTR_THEME_NAME ) ?></div>
				</div>

				<!-- exported data -->
				<div class="saveInfoNag exportInfoNagOk wtr_adimin_option_msg" style="display:none;">
					<div class="infoOk"><?php  _e( 'Exported data', WTR_THEME_NAME ) ?></div>
				</div>

				<!-- import settings success -->
				<div  style="<?php echo $visablePopupImport;?>" class="saveInfoNag importInfoNagOk <?php echo 'wtr_admin_set_alert_'.$message_admin; ?> wtr_adimin_option_msg">
					<div class="infoOk"><?php  _e( 'Imported settings', WTR_THEME_NAME ) ?></div>
				</div>

				<!-- one cliick import-->
				<div  style="<?php echo $visablePopupImport;?>" class="saveInfoNag importOneClickInfoNagOk <?php echo 'wtr_admin_set_alert_'.$message_admin; ?> wtr_adimin_option_msg">
					<div class="infoOk"><?php  _e( 'Dummy data successfully imported', WTR_THEME_NAME ) ?></div>
				</div>

				<!-- save success -->
				<div class="saveInfoNag saveInfoNagOk wtr_adimin_option_msg"  style="display:none">
					<div class="infoOk"><?php  _e( 'Save success', WTR_THEME_NAME ) ?></div>
				</div>

				<!-- load animation -->
				<div class="wonsterLoader wtr_adimin_option_msg" style="display:none">
					<div class="wonsterLoaderElement"></div>
				</div>

			</div>
			<!-- end ALERTS -->
		<?php
		}// end create_alerts_element_html


		private function create_modals_element_html(){ ?>

			<!-- MODALS -->
				<!-- modal - default settings  -->
					<div id="wonsterModalDefault" class="wonsterModal">
						<div class="modalNag">
							<span class="modal_tittle"><?php  _e( 'Restore default settings', WTR_THEME_NAME ) ?></span>
							<a class="modal_close wtr_admin_modal_close" href=""></a>
							<div class="clear"></div>
						</div>
						<div class="modalContent">
							<p><?php  _e( 'Are you sure you want to reset all settings for this theme? <br />All entered data will be lost', WTR_THEME_NAME ) ?></p>
							<div class="btnModalSpace">
								<a href="" data-trigger="default-settings" class="WonButton red wonster_do_def_serttings"><?php  _e( 'Default Settings', WTR_THEME_NAME ) ?></a> <a href="" class="AlternativButton wtr_admin_modal_close">No, cancel</a>
							</div>
							<div class="clear"></div>
						</div>
						<div class="clear"></div>
					</div>
				<!-- end modal - default settings  -->

				<!-- modal - import auto settings  -->
					<div id="wonsterModalRestoreAuto" class="wonsterModal">
						<div class="modalNag">
							<span class="modal_tittle"><?php  _e( 'Restore settings', WTR_THEME_NAME ) ?></span>
							<a class="modal_close wtr_admin_modal_close" href=""></a>
							<div class="clear"></div>
						</div>
						<div class="modalContent">
							<p><?php  _e( 'Are you sure you want to restore all settings for this theme? <br />All entered data will be lost', WTR_THEME_NAME ) ?></p>
							<div class="btnModalSpace">
								<a href="" data-trigger="import-auto" class="WonButton red wonster_do_import_auto_serttings"><?php  _e( 'Restore Settings', WTR_THEME_NAME ) ?></a> <a href="" class="AlternativButton wtr_admin_modal_close">No, cancel</a>
							</div>
							<div class="clear"></div>
						</div>
						<div class="clear"></div>
					</div>
				<!-- end modal - import auto settings  -->

				<!-- modal - import text settings  -->
					<div id="wonsterModalRestoreText" class="wonsterModal">
						<div class="modalNag">
							<span class="modal_tittle"><?php  _e( 'Restore settings', WTR_THEME_NAME ) ?></span>
							<a class="modal_close wtr_admin_modal_close" href=""></a>
							<div class="clear"></div>
						</div>
						<div class="modalContent">
							<p><?php  _e( 'Are you sure you want to restore all settings for this theme? <br />All entered data will be lost', WTR_THEME_NAME ) ?></p>
							<div class="btnModalSpace">
								<a href="" data-trigger="import-text" class="WonButton red wonster_do_import_text_serttings"><?php  _e( 'Import dummy data', WTR_THEME_NAME ) ?></a> <a href="" class="AlternativButton wtr_admin_modal_close">No, cancel</a>
							</div>
							<div class="clear"></div>
						</div>
						<div class="clear"></div>
					</div>
				<!-- end modal - import text settings  -->

				<!-- modal - one click import  -->
					<div id="wonsterModalRestoreOneCick" class="wonsterModal">
						<div class="modalNag">
							<span class="modal_tittle"><?php  _e( 'Import dummy data', WTR_THEME_NAME ) ?></span>
							<a class="modal_close wtr_admin_modal_close" href=""></a>
							<div class="clear"></div>
						</div>
						<div class="modalContent">
							<p><?php  _e( 'Are you sure you want to import dummy data? All entered data will be lost.<br /><br /><b>
										   Data import can take from several seconds to several minutes.
										   Import time depends on server performance and the amount of data needed to be processed.</b>', WTR_THEME_NAME ) ?></p>
							<div class="btnModalSpace">
								<span class="WonButton red wtr_do_once_click_import"><?php  _e( 'Import data', WTR_THEME_NAME ) ?></span> <a href="" class="AlternativButton wtr_admin_modal_close">No, cancel</a>
							</div>
							<div class="clear"></div>
						</div>
						<div class="clear"></div>
					</div>
				<!-- end modal - one click import -->

				<!-- modal - delete slider -->
					<div id="wonsterModal_sidebarDel" class="wonsterModal">
						<div class="modalNag">
							<span class="modal_tittle"><?php  _e( 'Delete sidebar item', WTR_THEME_NAME ) ?></span>
							<a class="modal_close wtr_admin_modal_close" href=""></a>
							<div class="clear"></div>
						</div>
						<div class="modalContent">
							<p><?php  _e( 'Are you sure you want to permanently delete sidebar: <b id="sideBarNameDel"></b>', WTR_THEME_NAME ) ?></p>
							<div class="btnModalSpace">
								<a href="" class="WonButton red wtr_admin_confirm_del_slider"><?php  _e( 'Ok, delete', WTR_THEME_NAME ) ?></a> <a href="" class="AlternativButton wtr_admin_modal_close"><?php  _e( 'No, cancel', WTR_THEME_NAME ) ?></a>
							</div>
							<div class="clear"></div>
						</div>
						<div class="clear"></div>
					</div>
				<!-- end modal - delete slider -->

				<!-- modal - overwrite custom skin  -->
					<div id="wonsterModalOverwriteCustomSkin" class="wonsterModal">
						<div class="modalNag">
							<span class="modal_tittle"><?php  _e( 'Theme custom skin overwrite', WTR_THEME_NAME ) ?></span>
							<a class="modal_close wtr_admin_modal_close" href=""></a>
							<div class="clear"></div>
						</div>
						<div class="modalContent">
							<p><?php  _e( 'Are you sure you want to overwrite custom style?', WTR_THEME_NAME ) ?></p>
							<div class="btnModalSpace">
								<span class="WonButton red wtrOverwriteSkin"><?php  _e( 'Yes, overwrite', WTR_THEME_NAME ) ?></span> <a href="" class="AlternativButton wtr_admin_modal_close">No, cancel</a>
							</div>
							<div class="clear"></div>
						</div>
						<div class="clear"></div>
					</div>
				<!-- end modal - overwrite custom skin -->
			<!-- end MODALS -->
		<?php
		}// create_modals_element_html


		function init_register_setting(){

			$opt	= $this->settings->get( 'opt' );
			$opt_a	= $this->settings->get( 'opt_a' );

			foreach ( $opt as  $group ) {
				foreach ( $group->get( 'sections' ) as  $section ) {
					add_settings_section( $section->get( 'id' ).'_section', '', null, $section->get( 'id' ) . '_section_group' );

					foreach ( $section->get('fields') as  $field ) {

						if( isset( $opt_a[ $field->get('id') ] ) ){
							$field->set('value', $opt_a[ $field->get('id') ] );
							add_settings_field( $field->get( 'id' ).'_field', '', null, $section->get( 'id' ) . '_section_group', $section->get( 'id' ).'_section', array('obj' => $field ) );
						}
					}
				}
			}
		}// end init_register_setting


		// Verification of user input
		function wtr_validate_options( $input ) {

			switch( $_POST['submitControl'] ){

				//restore default settings
				case 'default-settings':
					update_option( $this->settings->get_WP_ERROR(), 'default' );
					update_option( $this->settings->get_WP_REWRITE_FLUSH(),  1 );
					do_action( 'wtr_default_settings' );
					return null;
				break;

				// writing by ajax
				case 'ajax':
					$opt_a  = $this->settings->get( 'opt_a' );
				break;

				// restore settings from the backup system
				case 'import-auto':
					$opt_a  = $this->settings->get( 'opt_a' );
					$input  = wtr_get_export_theme_settings( $_POST[ 'wtr_export_theme_settings' ] );
					$status = 'import_data' ;
				break;

				// restore settings from text
				case 'import-text':
					$opt_a  = $this->settings->get( 'opt_a' );
					$input  = wtr_decode_theme_settings( wp_remote_fopen( $_POST[ 'wtr_admin_import_settings_text' ] ) );
					$status = 'import_data' ;
				break;

				default:
					$opt_a  = $this->settings->get( 'opt_a' );
				break;
			}

			$flaga			= false;
			$new_opt		= array();
			$status_flush	= 0;
			$opt			= $this->settings->get( 'opt' );


			foreach ( $opt as  $group ) {
				foreach ( (array ) $group->get('sections') as $section ) {
					foreach ( ( array ) $section->get('fields') as $field ) {

						$id_field	= $field->get( 'id' );
						$allow		= $field->get( 'allow' );
						$value		= $field->get( 'value' );

						if( isset( $input[ $id_field ] ) ){
							$new_value = ( ! is_array( $input[ $id_field ] ) ) ? trim ( $input[ $id_field ] ) : $input[ $id_field ];

							if( $allow == 'between' ){
								$min			= $field->get( 'min' );
								$max			= $field->get( 'max' );
								$has_attr		= $field->get( 'has_attr' );
								//$input[ $key ]	= trim( $input[ $key ] );

								$flaga = WTR_Validate::check( $allow, $new_value, $max, $min, $has_attr );
							} else {
								$flaga = WTR_Validate::check( $allow, $new_value ) ;
							}

						//default value
						} else {
							$new_value	= $field->get( 'default_value' );
						}
						$new_opt[ $id_field ]	= $new_value;
						$new_opt				= $this->settings->set_opt_a( $new_opt, $field, $new_value );

						//checking slug
						if( $status_flush != 1 AND strpos( $id_field, '_Slug' ) AND $value !=  $new_value ){
							$status_flush = 1;
						}
						if( ! $flaga ){
							break 3;
						}
					}
				}
			}

			if( ! $flaga ){

				$new_opt  = $this->settings->get( 'opt_a' );

				if( isset( $status ) AND 'import_data' == $status ) {
					update_option( $this->settings->get_WP_ERROR(), 'import_error' );
				}

				if( empty( $status ) OR 'import_data' != $status ){
					echo 'wtr_save_option_error';
					exit;
				}
			}
			else if ( isset( $status ) ){

				update_option( $this->settings->get_WP_ERROR(),  $status );
				do_action( 'wtr_import_data', $input );
			}

			if( $flaga AND isset( $status_flush ) ){
				update_option( $this->settings->get_WP_REWRITE_FLUSH(),  $status_flush );
			}

			return base64_encode( serialize( $new_opt ) );
		}// end wtr_validate_options


		public function do_settings_sections( $page ) {

			global $wp_settings_sections, $wp_settings_fields;

			if ( ! isset( $wp_settings_sections ) || !isset( $wp_settings_sections[ $page ] ) ){
				return;
			}

			foreach ( ( array ) $wp_settings_sections[ $page ] as $section ) {

				if ( $section[ 'title' ] ){
					echo "<h3>{$section['title']}</h3>\n";
				}

				if ( $section[ 'callback' ] ){
					call_user_func( $section[ 'callback' ], $section );
				}

				if ( ! isset( $wp_settings_fields ) || !isset( $wp_settings_fields[ $page ] ) || !isset( $wp_settings_fields[ $page ][ $section[ 'id' ] ] ) ){
					continue;
				}

				//echo '<table class="form-table">';
				$this->do_settings_fields( $page, $section[ 'id' ] );
				//echo '</table>';
			}
		}// end do_settings_sections


		public function do_settings_fields( $page, $section ) {
			global $wp_settings_fields;

			if ( !isset( $wp_settings_fields ) || !isset( $wp_settings_fields[ $page ] ) || !isset( $wp_settings_fields[ $page ][ $section ] ) ){
				return;
			}

			$wp_opt_name = $this->settings->get_WP_OPT_NAME();
			foreach ( ( array ) $wp_settings_fields[ $page ][ $section ] as $field ) {

				if( $field[ 'args' ][ 'obj' ] ){
					$field[ 'args' ][ 'obj' ] ->draw( $wp_opt_name );
				}
			}
		}// end do_settings_fields
	}// end WTR_Theme_Page
}