<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

require_once( WTR_ADMIN_CLASS_DIR . '/wtr_export.php' );
require_once( WTR_ADMIN_CLASS_DIR . '/fields/wtr_field.php' );

if ( ! class_exists( 'WTR_Update_Settings' ) ) {

	class WTR_Update_Settings extends WTR_Filed {

		public function draw( $name = NULL ){

			$name_field = ( $name ) ? ( $name . '['. $this->id . ']' ) : $this->id;
		?>

		<div class="wonsterFiled">
				<div class="wfDescFullWidth">
					<div class="wfTitle"><?php echo $this->title ?></div>
					<div class="setDescNag"><?php echo $this->desc ?></div>
				</div>
				<div class="clear"></div>
				<div class="one-col">
					<h4 class="backupsNag"><?php _e( 'Five last admin data backups:', WTR_THEME_NAME ) ?></h4>
					<div class="col-two-three">
						<div class="inputRadio-wrapper">
							<ul class="backupList bordered wtr_admin_list_export_data">
								<?php wtr_draw_export_theme_settings() ?>
							</ul>
						</div>
						<div class="clear"></div>
					</div>
					<div class="col-one-three ">
						<div class="backupBtns padded">
							<a name="wonsterModal" href="" class="WonButton blue wtr_admin_export_settings"><?php _e( 'Export', WTR_THEME_NAME ) ?></a>
							<a rel="leanModal" name="wonsterModal" href="#wonsterModalRestoreAuto" class="WonButton red "><?php _e( 'Restore', WTR_THEME_NAME ) ?></a>
						</div>
					</div>
					<div class="clear"></div>
				</div>
				<div class="wfSettFullWidth">
					<div class="wfDescFullWidth">
					<div class="wfTitle"><?php _e('Export admin data', WTR_THEME_NAME ) ?></div>
					<div class="setDescNag">
						<?php echo $this->info ?>
					</div>
					</div>

					<div class="wonsterFiled" style="border:0px">
						<div class="wfDesc">
							<div class="wfTitle"><?php _e( 'Select file with import settings (txt file)', WTR_THEME_NAME ); ?></div>
							<div class="setDescNag"></div>
						</div>
						<div class="wfSett wtrCustomFF">
							<div class="wonsterUpload">
								<div class="setCol-one-three">
									<a href="" class="WonButton blue fileSelect wtr_admin_file_upload" default_size="full" data-editor="" target_type="text" title_modal="none" filter_content="text"><?php _e( 'Select file', WTR_THEME_NAME ); ?>  </a>
								</div>
								<div class="clear"></div>
							</div>
							<div class="wtfUrlUpdate">
								<div class="wfImagePrev wtfUrlUpdateField">
									<div class="imgContener wtr_admin_imgContener wtrUrlInput">
										<input type="text" id="wtr_admin_import_settings_text" name="wtr_admin_import_settings_text" value="" class="wtr_admin_ipload_field wtrUrlUpdateEntry ModalFields VideoSrc ">
									</div>
									<div class="clear"></div>
								</div>
								<div class="clear"></div>
							</div>
							<div class="clear"></div>
						</div>
						<div class="clear"></div>
					</div>

					<div class="btnImpExpSec">
						<a rel="leanModal" name="wonsterModal" href="#wonsterModalRestoreText" class="WonButton red importBtn" style="margin-top:20px;"><?php _e( 'Import form file', WTR_THEME_NAME ) ?></a>
						<input id="wtr_export_setting_to_file" type="hidden" name="wtr_export_setting_to_file" value="">
						<input class="WonButton blue blueExportToFile floatRight  wtr_save_form_to_file" name="Submit" type="submit" value="<?php _e( 'Export data to file', WTR_THEME_NAME ) ?>" />
					</div>
					<div class="clear"></div>
				</div>
				<div class="clear"></div>
			</div>
		<?php
		}// draw
	};// end WTR_Update_Settings
}