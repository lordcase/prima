<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

require_once( WTR_ADMIN_CLASS_DIR . '/fields/wtr_field.php' );

if ( ! class_exists( 'WTR_Img_Sortable' ) ) {

	class WTR_Img_Sortable extends WTR_Filed {

		public function __construct( $data = NULL, $ext = NULL ) {

			parent::__construct($data);

			$this->filter_content	= ( isset( $ext[ 'filter_content' ] ) )? $ext[ 'filter_content' ] : 'image';
			$this->target_type		= ( isset( $ext[ 'target_type' ] ) )? $ext[ 'target_type' ] : 'hidden';
			$this->id_target		= ( isset( $ext[ 'id_target' ] ) )? '#'.$ext[ 'id_target' ] : $this->id;
			$this->multiple			= ( isset( $ext[ 'multiple' ] ) )? $ext[ 'multiple' ] : false;
			$this->title_modal		= ( isset( $ext[ 'title_modal' ] ) )? $ext[ 'title_modal' ] : 'none';
			$this->default_size		= ( isset( $ext[ 'default_size' ] ) )? $ext[ 'default_size' ] : 'full';
		}// end __construct


		public function draw( $name = NULL ){

			$name_field = ( $name ) ? ( $name . '['. $this->id . ']' ) : $this->id;
			?>
			<div class="wonsterFiled">
				<div class="wfDesc">
					<div class="wfTitle"><?php echo $this->title?></div>
					<div class="setDescNag"><?php echo $this->desc?></div>
				</div>
				<div class="wfSett">
					<div class="wonsterUpload">
						<div class="setCol-one-three">
							<a href="" class="WonButton blue fileSelect wtr_admin_file_upload" default_size="<?php echo $this->default_size; ?>" target_type="<?php echo $this->target_type; ?>" title_modal="<?php echo esc_attr( $this->title_modal ); ?>" filter_content="<?php echo $this->filter_content; ?>"> <?php _e('Select file', WTR_THEME_NAME ) ?> </a>
						</div>
						<?php if( $this->info ) { ?>
							<div class="setCol-two-three">
								<div class="setDescObok"><?php echo $this->info ?></div>
							</div>
						<?php } ?>
						<div class="clear"></div>
					</div>
					<div class="wonsterImgSortableContener" >
						<ul class="wr_ImgSortableArea <?php echo $this->class ?>" data-name="<?php echo $name_field; ?>">
							<?php
								if( is_array( $this->value ) && $this->value[0] ){
									foreach( $this->value as $key => $val ){
										$index = array_keys( $val );
										$src = wp_get_attachment_image_src( key( $val ), 'thumbnail' );
										?>
										<li class="ui-state-default">
												<div class="imgThumbContainerImgSortable">
													<div class="delItemImgSortable"></div>
													<img src="<?php echo $src[ 0 ]; ?>" width="80" height="80" class="wtr_GfxItemImgSortable">
													<input type="hidden" name="<?php echo $name_field;?>[][<?php echo $index[ 0 ]; ?>]" class="wtr_ValThumbItemImgSortable" value="">
												</div>
										</li>
								<?php }
								}
							?>
						</ul>
						<div class="clear"></div>
					</div>
				</div>
				<div class="clear"></div>
			</div>
		<?php
		} // draw
	};// end WTR_Img_Sortable
}