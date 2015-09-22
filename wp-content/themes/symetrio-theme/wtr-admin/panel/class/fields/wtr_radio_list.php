<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

require_once( WTR_ADMIN_CLASS_DIR . '/fields/wtr_field.php' );

if ( ! class_exists( 'WTR_Radio_List' ) ) {

	class WTR_Radio_List extends WTR_Filed {

		protected $option;

		public function __construct( $data = NULL ) {

			parent::__construct( $data );

			if ( ! isset( $data[ 'option' ] ) OR ! is_array( $data[ 'option' ] ) OR ! count( $data[ 'option' ] ) ){
				throw new Exception( $this->errors['param_construct'] );
			}

		} // end __construct


		public function draw( $name = NULL ){

			$name_field = ( $name ) ? ( $name . '['. $this->id . ']' ) : $this->id;
			?>
			<div class="wonsterFiled ">
				<div class="wfDesc">
					<div class="wfTitle"><?php echo $this->title?></div>
					<div class="setDescNag"><?php echo $this->desc?></div>
				</div>
				<div class="wfSett">
					<div class="inputRadio-wrapper">
						<ul class="backupList  ">
							<?php
								$txt = '';
								foreach ( $this->option as $key => $value ) {
									$txt .='
									<li><input type="radio" class="wtrStrAdminRadio" value="' . $key . '" id="checkExp_' . $key . '" name="' . $name_field . '"
									data-label="' . $value .'"';

									if( $key == $this->value){
										$txt .='checked data-customclass="margin-right"';
									}
									$txt .= ' /></li>';
								}
								echo $txt;
							?>
						</ul>
					</div>
					<div class="clear"></div>
				</div>
				<div class="clear"></div>
			</div>
		<?php
		}// draw
	};// end WTR_Radio_Img
}