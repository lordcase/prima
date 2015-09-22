<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

require_once( WTR_ADMIN_CLASS_DIR . '/fields/wtr_field.php' );

if ( ! class_exists( 'WTR_Upload' ) ) {

	class WTR_Upload extends WTR_Filed {

		// VARIABLE
		protected $filter_content;
		protected $target_type;
		protected $id_target;
		protected $multiple;
		protected $title_modal;


		// FUNCTION
		public function __construct( $data = NULL, $ext = NULL ) {

			parent::__construct($data);

			$this->filter_content	= ( isset( $ext[ 'filter_content' ] ) )? $ext[ 'filter_content' ] : 'image';
			$this->target_type		= ( isset( $ext[ 'target_type' ] ) )? $ext[ 'target_type' ] : 'hidden';
			$this->id_target		= ( isset( $ext[ 'id_target' ] ) )? '#'.$ext[ 'id_target' ] : $this->id;
			$this->multiple			= ( isset( $ext[ 'multiple' ] ) )? $ext[ 'multiple' ] : false;
			$this->title_modal		= ( isset( $ext[ 'title_modal' ] ) )? $ext[ 'title_modal' ] : 'none';
			$this->default_size		= ( isset( $data[ 'default_size' ] ) )? $data[ 'default_size' ] : 'full';

		}// end __construct


		public function draw( $name = NULL ){

			$name_field = ( $name ) ? ( $name . '['. $this->id . ']' ) : $this->id;

			if( is_numeric( $this->value ) ){
				$image_src	= wp_get_attachment_image_src( $this->value, 'full' );
				$this->image_src	= $image_src[0];
			}elseif ( is_numeric( strpos( $this->value, '/assets/img/default_images' ) ) ) {
				$this->image_src	= $this->value;
			}

			if( !isset( $this->mod)  OR ( $this->mod  == 'custom_font' ) ):?>
			<?php
				$mod_class = ( isset( $this->mod) AND $this->mod  == 'custom_font' ) ? 'wtrCustomFF' : '';
			?>
				<div class="wonsterFiled ">
					<div class="wfDesc">
						<div class="wfTitle"><?php echo $this->title?></div>
						<div class="setDescNag"><?php echo $this->desc?></div>
					</div>
					<div class="wfSett <?php echo $mod_class; ?>">
						<div class="wonsterUpload">
							<div class="setCol-one-three">
								<a href="" class="WonButton blue fileSelect wtr_admin_file_upload" default_size="<?php echo $this->default_size; ?>" data-editor="<?php $this->id; ?>" target_type="<?php echo $this->target_type; ?>" title_modal="<?php echo esc_attr( $this->title_modal ); ?>" filter_content="<?php echo $this->filter_content; ?>"> <?php _e('Select file', WTR_THEME_NAME ) ?> </a>
							</div>
							<?php if( $this->info ) { ?>
								<div class="setCol-two-three">
									<div class="setDescObok"><?php echo $this->info ?></div>
								</div>
							<?php } ?>
							<div class="clear"></div>
						</div>
						<div class="wtfUrlUpdate">
							<div class="wfImagePrev wtfUrlUpdateField">
								<div class="imgContener wtr_admin_imgContener <?php if( 'text' == $this->target_type ) { echo 'wtrUrlInput'; } ?>">
									<?php if( trim( $this->value ) && 'text' != $this->target_type ){ ?>
										<span class="deleteFoto wtr_admin_deleteFoto"></span>
										<img class="wtr_admin_foto_tmb" src="<?php echo $this->image_src ?>" >
									<?php }

									if( 'hidden' == $this->target_type ){ ?>
										<input type="hidden" id="<?php echo $this->id;?>"  name="<?php echo $name_field ?>"
										value="<?php echo esc_attr( $this->value );?>" class="wtr_admin_ipload_field <?php echo $this->class ?> "/>
									<?php }
									else if( 'text' == $this->target_type ) { ?>
										<input type="text"  id="<?php echo $this->id;?>"  name="<?php echo $name_field ?>"
										value="<?php echo esc_attr( $this->value );?>" class="wtr_admin_ipload_field wtrUrlUpdateEntry <?php echo $this->class ?> "/>
									<?php } ?>
								</div>
								<div class="clear"></div>
							</div>
							<div class="clear"></div>
						</div>
						<div class="clear"></div>
					</div>
					<div class="clear"></div>
				</div>
		<?php
		elseif ( $this->mod  == 'avatar'):
		?>
			<h3> <?php  _e( 'Avatar', WTR_THEME_NAME ) ?></h3>
			<table class="form-table">
				<tbody>
					<tr>
						<th><label for="wtr_avatar_img"><?php echo $this->title ?></label></th>
						<td>
						<div class="wfSett">
							<div class="wonsterUpload">
								<div class="setCol-one-three">
									<a href="" class="WonButton blue fileSelect wtr_admin_file_upload" default_size="<?php echo $this->default_size; ?>" data-editor="<?php $this->id; ?>" target_type="<?php echo $this->target_type; ?>" title_modal="<?php echo esc_attr( $this->title_modal ); ?>" filter_content="<?php echo $this->filter_content; ?>"> <?php _e('Select file', WTR_THEME_NAME ) ?> </a>
								</div>
								<div class="clear"></div>
							</div>
							<div class="wtfUrlUpdate">
								<div class="wfImagePrev wtfUrlUpdateField" style="width:96px">
									<div class="imgContener wtr_admin_imgContener">
										<?php if( trim( $this->value ) &&  'text' != $this->target_type ){ ?>
											<span class="deleteFoto wtr_admin_deleteFoto"></span>
											<img class="wtr_admin_foto_tmb" src="<?php echo $this->image_src ?>" >
										<?php }
										if( 'hidden' == $this->target_type ){ ?>
											<input type="hidden" id="<?php echo $this->id;?>"  name="<?php echo $name_field ?>"
											value="<?php echo esc_attr( $this->value );?>" class="wtr_admin_ipload_field <?php echo $this->class ?> "/>
										<?php } ?>
									</div>
									<div class="clear"></div>
								</div>
								<div class="clear"></div>
							</div>
							<div class="clear"></div>
						</div>
						</td>
					</tr>
				</tbody>
			</table>
		<?php
		endif;
		}// draw
	};// end WTR_Upload
}