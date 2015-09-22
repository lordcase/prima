<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

require_once( WTR_ADMIN_CLASS_DIR . '/fields/wtr_field.php' );

if ( ! class_exists( 'WTR_Scroll' ) ) {

	class WTR_Scroll extends WTR_Filed {

		protected $max;
		protected $min;


		public function __construct( $data = NULL ) {

			parent::__construct( $data );

			if ( ! isset( $data[ 'max' ] ) OR
				 ! isset( $data[ 'min' ] ) OR
				 ! isset( $data[ 'has_attr' ] )
			){
				throw new Exception( $this->errors['param_construct'] );
			}
		}// end __construct


		public function draw( $name = NULL ){

			$name_field = ( $name ) ? ( $name . '['. $this->id . ']' ) : $this->id;
			?>
			<div class="wonsterFiled ">
				<div class="wfDesc">
					<div class="wfTitle"><?php echo $this->title?></div>
					<div class="setDescNag"><?php echo $this->desc?></div>
				</div>
				<div class="wfSett">
					<div class="rangeSlide wtr_admin_scroll_field <?php echo $this->class ?>" name="<?php echo $name_field ?>" data-value="<?php echo esc_attr( str_replace($this->has_attr, '', $this->value) ) ?>" data-min="<?php echo $this->min ?>" data-max="<?php echo $this->max ?>"
					data-px="<?php echo $this->has_attr ?>" ></div>
					<input type="text" value="" readonly="readonly" name="<?php echo $name_field ?>" class="variableInp wtr_admin_scroll_amount" />
					<?php if( $this->info ) { ?>
						<div class="setDescUnder">
							<?php echo $this->info ?>
						</div>
					<?php } ?>
					<div class="clear"></div>
				</div>
				<div class="clear"></div>
			</div>
			<?php } // draw
	};// end WTR_Scroll
}