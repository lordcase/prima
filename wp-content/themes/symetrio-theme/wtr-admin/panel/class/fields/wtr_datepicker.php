<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

require_once( WTR_ADMIN_CLASS_DIR . '/fields/wtr_field.php' );

if ( ! class_exists( 'WTR_Datepicker' ) ) {

	class WTR_Datepicker extends WTR_Filed {

		public function draw( $name = NULL ){

			$name_field = ( $name ) ? ( $name . '['. $this->id . ']' ) : $this->id;

			if( isset( $this->dependency ) ){
				$dependency = 'dependency';
				$dependency_data =	' data-field-dependency="'.  $this->dependency[ 'element' ] .
									'" data-option-dependency="' . implode( '|', $this->dependency[ 'value' ] ) . '" ';
			}
			else {
				$dependency_data = $dependency = '';
			}
		?>
			<div class="wonsterFiled <?php echo $dependency; ?>" <?php echo $dependency_data; ?>>
				<div class="wfDesc">
					<div class="wfTitle"><?php echo $this->title?></div>
					<div class="setDescNag"><?php echo $this->desc?></div>
				</div>
				<div class="wfSett">
					<i class="fa fa-calendar wtrDatepickerIco"></i>
					<input type="text" id="<?php echo $this->id;?>"  name="<?php echo $name_field ?>"
					data-rande-start="<?php echo $this->rande[ 'start' ]; ?>"
					data-rande-end="<?php echo $this->rande[ 'end' ]; ?>"
					value="<?php echo esc_attr( $this->value );?>" class="inputDivBox wtrDatepickerField <?php echo $this->class ?> "/>
					<?php if( $this->info ) { ?>
						<div class="setDescUnder">
							<?php echo $this->info ?>
						</div>
					<?php } ?>
				</div>
				<div class="clear"></div>
			</div>
		<?php
		}// draw
	};// end WTR_Datepicker
}