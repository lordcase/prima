<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

require_once( WTR_ADMIN_CLASS_DIR . '/fields/wtr_field.php' );

if ( ! class_exists( 'WTR_Radio' ) ) {

	class WTR_Radio extends WTR_Filed {

		protected $option;


		public function __construct( $data = NULL ) {

			parent::__construct( $data );

			if ( ! isset( $data[ 'option' ] ) OR ! is_array( $data[ 'option' ] ) OR ! count( $data[ 'option' ] )) {
				throw new Exception( $this->errors['param_construct'] );
			}

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
					<div class="setCol">
						<div class="wtr_admin_radio_field">
							<?php
							if( isset( $this->mod ) AND 'robot' == $this->mod AND 0 == get_option( 'blog_public') ) : ?>
								<div class="WonsterFiled">
									<?php echo $this->meta ?>
								</div>
							<?php else : ?>
								<?php foreach ( $this->option as $key => $value ) { ?>
									<input class="wtr_admin_radio_check_input <?php echo $this->class ?>"  type="radio" value="<?php echo $key; ?>" id="<?php echo $this->id . $key; ?>"
									 name="<?php echo $name_field ?>" <?php checked( $key, $this->value ); ?> />
									<label class="wtr_admin_radio_check" class="blueBtn" for="<?php echo $this->id . $key; ?>"> <?php echo $value ?> </label>
								<?php } ?>
							<?php endif?>
							<?php
							if( isset( $this->src ) AND ! empty( $this->src ) ) : ?>
								<div class="wfImagePrev  wtr_radio_thumbnail">
									<div class="imgContener wtr_admin_imgContener ">
										<img class="wtr_admin_foto_tmb" src="<?php echo $this->src ?>"></div>
									<div class="clear"></div>
								</div>
								<div class="clear"></div>
							<?php endif ?>
						</div>
					</div>
					<?php if( $this->info ) { ?>
						<div class="setCol-2">
							<div class="setDesc">
								<?php echo $this->info ?>
							</div>
						</div>
					<?php } ?>
				</div>
				<div class="clear"></div>
			</div>
		<?php
		}// draw
	};// end WTR_Radio
}