<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

require_once( WTR_ADMIN_CLASS_DIR . '/fields/wtr_field.php' );

if ( ! class_exists( 'WTR_Textarea' ) ) {

	class WTR_Textarea extends WTR_Filed {

		public function __construct( $data = NULL ) {

			parent::__construct( $data );

			if(! isset( $data[ 'rows' ] ) ){
				throw new Exception( $this->errors['param_construct'] );
			}

			if( ! isset( $this->mod ) || null == $this->mod || '' == $this->mod ){
				$this->mod = 'standard';
			}
		}// end __construct

		public function draw( $name = NULL ){

			$name_field = ( $name ) ? ( $name . '['. $this->id . ']' ) : $this->id;
			$nexDiv = ( trim( $this->info ) )? '' : 'textDivBoxMargin';

			$this->value = str_replace( '``', '"', $this->value );

			if( 'standard' === $this->mod )
			{?>
			<div class="wonsterFiled ">
				<div class="wfDesc">
					<div class="wfTitle"><?php echo $this->title?></div>
					<div class="setDescNag"><?php echo $this->desc?></div>
				</div>
				<div class="wfSett">
					<textarea  id="<?php echo $this->id ?>"  name="<?php echo $name_field ?>"
						class="textDivBox <?php echo $nexDiv; ?> wtr_admin_textarea_field rows <?php echo $this->class ?> noResize"
						rows="<?php echo $this->rows ?>"cols="30"><?php echo esc_textarea( $this->value );?></textarea>
					<?php if( $this->info ) { ?>
						<div class="setDescUnder">
							<?php echo $this->info ?>
						</div>
					<?php } ?>
				</div>
				<div class="clear"></div>
			</div>
			<?php
			}
			else if ( 'tinymce' == $this->mod )
			{?>
			<div class="wonsterFiled">
				<div class="wfDescFullWidth iconTitleX">
					<div class="wfTitle"><?php echo $this->title?></div>
				</div>
				<div class="setDescUnder">
					<?php echo $this->desc?>
				</div>
				<div class="clear"></div>
				<?php
					$flag_version = version_compare( get_bloginfo( 'version' ), '3.8.3', '>' );
					if( !$flag_version ){ ?>
						<a href="#" class="button wtr_admin_file_upload"  data-editor="<?php echo $this->id; ?>" style="position:absolute; z-index:50;"  default_size="full" target_type="tinymce" title_modal="Insert Media" filter_content=""><span class="wp-media-buttons-icon wtr-media-icon"></span> Add Media</a>
				<?php } ?>
				<div class="<?php echo $this->class; ?> tinymce_contener" name="<?php echo $this->id; ?>" data-tiny-id="<?php echo $this->id; ?>">
					<?php
						wp_editor( $this->value, $this->id, array(
							'quicktags'		=> true,
							'media_buttons'	=> $flag_version,
							'textarea_rows'	=> $this->rows,
							'textarea_name'	=> $name_field,
						 ) );
					?>
				</div>
				<div class="setDescUnder">
					<?php if( trim( $this->info ) ) { echo $this->info; }?>
				</div>
			</div>
			<?php }
		}// draw
	};// end WTR_Textarea
}