<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

require_once( WTR_ADMIN_CLASS_DIR . '/fields/wtr_field.php' );

if ( ! class_exists( 'WTR_Radio_Btn' ) ) {

	class WTR_Radio_Btn extends WTR_Filed {

		protected $option;
		protected $checked;

		public function __construct( $data = NULL ) {

			parent::__construct( $data );

			if ( ! isset( $data[ 'option' ] )  OR ! is_array( $data[ 'option' ] ) OR ! count( $data[ 'option' ] ) OR ! isset( $data[ 'checked' ] ) ){
				throw new Exception( $this->errors['param_construct'] );
			}
		}// end __construct


		public function draw( $name = NULL ){

			$name_field = ( $name ) ? ( $name . '['. $this->id . ']' ) : $this->id;
			$last_key = end( array_keys( $this->option ) );
			?>
			<div class="wonsterFiled">
				<div class="wfDescFullWidth">
					<div class="wfTitle"><?php echo $this->title?></div>
				</div>
				<?php if( $this->desc ) { ?>
					<div class="setDescUnder">
						<?php echo $this->desc ?>
					</div>
				<?php } ?>
				<div id="<?php echo $this->id ?>" class="wfSettFullWidth">
					<?php foreach ($this->option as $key =>  $value ) { ?>
						<div class="buttonItemSet roundBor wtr_admin_btn_radio_field_click">
							<div data-value="<?php echo $value; ?>" class="<?php echo $value . ' ' . $this->class ?> wtr_admin_btn_radio_field">
								<span class=""></span>
							</div>
						</div>
					<?php } ?>
					<input data-checked="<?php echo $this->checked ?>" type="hidden" name="<?php echo $name_field ?>"class="radio_img wtr_admin_btn_radio_field_click" data-area="<?php echo $this->id;?>" value="<?php echo $this->value ?>">
				</div>
				<div class="clear"></div>
			</div>
		<?php
		}// draw
	};// end WTR_Radio_Btn
}