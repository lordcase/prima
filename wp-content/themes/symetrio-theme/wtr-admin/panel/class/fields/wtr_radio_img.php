<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

require_once( WTR_ADMIN_CLASS_DIR . '/fields/wtr_field.php' );

if ( ! class_exists( 'WTR_Radio_Img' ) ) {

	class WTR_Radio_Img extends WTR_Filed {

		protected $option;
		protected $checked;


		public function __construct( $data = NULL ) {

			parent::__construct( $data );

			if ( ! isset( $data[ 'option' ] ) OR ! is_array( $data[ 'option' ] ) OR ! count( $data[ 'option' ] ) OR ! isset( $data[ 'checked' ] ) ){
				throw new Exception( $this->errors['param_construct'] );
			}

		} // end __construct


		public function draw( $name = NULL ){

			$name_field = ( $name ) ? ( $name . '['. $this->id . ']' ) : $this->id;
			$fin = array_keys( $this->option );
			$last_key = end( $fin );
			?>
			<div class="wonsterFiled">
				<div class="wfDescFullWidth">
					<div class="wfTitle"><?php echo $this->title?></div>
				</div>
				<div id="<?php echo $this->id ?>" class="wfSettFullWidth">
					<?php foreach ($this->option as $key =>  $value ) { ?>
						<div data-value="<?php echo $value; ?>" class="<?php echo $value . ' ' . $this->class ?> wtr_admin_radio_img_field_click
						<?php if( $last_key == $key ) { echo ' last '; } ?>">
							<span class=""></span>
						</div>
					<?php } ?>
					<input data-checked="<?php echo $this->checked ?>" type="hidden" name="<?php echo $name_field ?>" class="radio_img" data-area="<?php echo $this->id;?>" value="<?php echo $this->value ?>">
				</div>
				<?php if( $this->desc ) { ?>
					<div class="setDescUnder">
						<?php echo $this->desc ?>
					</div>
				<?php } ?>
				<div class="clear"></div>
			</div>
		<?php
		}// draw
	};// end WTR_Radio_Img
}