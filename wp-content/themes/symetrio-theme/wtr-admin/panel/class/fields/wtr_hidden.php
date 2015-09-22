<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

require_once( WTR_ADMIN_CLASS_DIR . '/fields/wtr_field.php' );

if ( ! class_exists( 'WTR_Hidden' ) ) {

	class WTR_Hidden extends WTR_Filed {

		public function draw( $name = NULL ){
			$name_field = ( $name ) ? ( $name . '['. $this->id . ']' ) : $this->id;
			?>
			<input type="hidden" id="<?php echo $this->id;?>"  name="<?php echo $name_field ?>" value="<?php echo esc_attr( $this->value );?>" class="inputDivBox wtr_admin_hidden_field <?php echo $this->class ?> "/>
			<?php
		}// draw
	};// end WTR_Hidden
}