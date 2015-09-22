<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

require_once( WTR_ADMIN_CLASS_DIR . '/fields/wtr_field.php' );

if ( ! class_exists( 'WTR_Checkbox' ) ) {

	class WTR_Checkbox extends WTR_Filed {

		protected $option;

		public function __construct( $data = NULL ) {

			parent::__construct( $data );

			if ( ! isset( $data[ 'option' ] ) ){
				throw new Exception( $this->errors['param_construct'] );
			}

		} // end __construct


		public function draw( $name = NULL ){

			$name_field	= ( $name ) ? ( $name . '['. $this->id . ']' ) : $this->id;
			$items_tmp	= array( 'checked' => array(), 'not_checked' => array()  );

			foreach ( $this->option as $key => $value ) {
				$checlbox_index	= 'not_checked';
				$item			= array(
										'name'		=> $value,
										'status'	=> '',
										'id'		=> $key,
									);

				if( is_array( $this->value ) AND  in_array( $key, $this->value ) ){
					$checlbox_index = 'checked';
					$item['status'] = 1;
				}

				$items_tmp[ $checlbox_index ][] = $item;
			}

			$items = array_merge( $items_tmp['checked'] , $items_tmp['not_checked'] );

			if( 'simple' == $this->mod ){
				?>
				<div id="" class="categorydiv">
					<div class="tabs-panel" >
						<ul>
							<?php foreach ( $items as  $item ) :
							$status = ( 1 == $item['status'] ) ? 'checked="checked"': '';
							?>
								<li>
									<label>
										<input type="checkbox" <?php echo $status;?> name="<?php echo $name_field; ?>[]" value="<?php echo $item['id'];?>"> <?php echo $item['name'] ?>
									</label>
								</li>
							<?php endforeach?>
						</ul>
					</div>
				</div>
				<?php
			} else { ?>
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
								foreach ( $items as $item ) {
									$status = ( 1 == $item['status'] ) ? 'checked data-customclass="margin-right"': '';

									$txt .='
									<li><input type="checkbox" class="wtrStrAdminRadio" value="' . $item['id'] . '" id="checkExp_' . $item['id'] . '" name="' . $name_field . '[]"
									data-label="' . $item['name'] .'"' . $status . ' /></li>';
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
			}

		}// draw
	};// end WTR_Checkbox
}

/*

	max-height: 200px;
	min-height: 42px;
	overflow: auto;
	border: 1px solid;

*/