<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

require_once( WTR_ADMIN_CLASS_DIR . '/fields/wtr_field.php' );

if ( ! class_exists( 'WTR_Alert' ) ) {

	class WTR_Alert extends WTR_Filed {

		public function draw( $name = NULL ){

			$name_field		= ( $name ) ? ( $name . '['. $this->id . ']' ) : $this->id;
			$extra_class	= ( isset( $this->class ) )? $this->class : '';
		?>

			<div class="wonsterFiled ">
				<div class="wonsterFiledAlert <?php echo $extra_class; ?>">
					<?php echo $this->title?>
				</div>
				<div class="clear"></div>
			</div>
		<?php
		}// draw
	};// end WTR_Alert
}