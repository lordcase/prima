<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

require_once( WTR_ADMIN_CLASS_DIR . '/fields/wtr_field.php' );
require_once( WTR_ADMIN_CLASS_DIR . '/wtr_icons.php' );

if ( ! class_exists( 'WTR_Icon' ) ) {

	class WTR_Icon extends WTR_Filed {

		public function __construct( $data ){

			parent::__construct( $data );
		}// end __construct


		public function draw( $name = NULL ){

			global $wtr_icons;
			$name_field	= ( $name ) ? ( $name . '['. $this->id . ']' ) : $this->id;
			$defaultV	= ( trim( $this->value ) )? '' : 'display:none;';
			$iconSet	= explode( '|', $this->value );

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
				<div class="wfDescFullWidth iconTitleX">
					<div class="wfTitle"><?php echo $this->title?></div>
				</div>
				<div class="setDescUnder">
					<?php echo $this->desc?>
				</div>
				<div class="set-col-3 sc-3-margin">
					<div class="selectdiv icoSelectGroup">
						<select class="selectboxdiv wtrSelectGroup">
							<?php foreach( $wtr_icons as $key => $value ){ ?>
								<option <?php selected( $key, $iconSet[ 0 ] ) ?>  value="<?php echo $key;?>"><?php echo $value[ 'name' ];?></option>
							<?php } ?>
						</select>
						<div class="out"></div>
					</div>
				</div>
				<div class="set-col-3">
					<div class="wfDescFullWidth wtrIconSelectUser" style="<?php echo $defaultV;?>">
						<div class="floatRight">
							<div class="wfSelectedIcon"><?php _e('You selected:', 'wtr_framework' ); ?></div>
							<div class="wfSelectedIconPrev">
								<i class="<?php echo $iconSet[ 1 ];?>"></i>
							</div>
						</div>
					</div>
					<div class="clear"></div>
				</div>
				<div class="clear"></div>
				<?php foreach( $wtr_icons as $key => $value ){?>
					<div class="iconContainer wtrIconList wtrIcon_<?php echo $key; ?>" style="display:none;">
						<ul class="iconList">
							<?php  foreach( $value[ 'collection' ] as $icon ){?>
								<li class="iconItem">
									<a href="" class="iconItemPos <?php if( $icon == $iconSet[ 1 ] ) { echo 'iTPActive'; }?>">
										<i class="<?php echo  $icon; ?>"></i>
									</a>
								</li>
							<?php } ?>
						</ul>
						<div class="clear"></div>
					</div>
				<?php } ?>
				<div class="setDescUnder">
					<?php if( trim( $this->info ) ) {echo $this->info; }?>
				</div>
				<input type="hidden" id="<?php echo $this->id;?>"  name="<?php echo $name_field ?>"
				value="<?php echo esc_attr( $this->value );?>" class="wtr_admin_icons_field <?php echo $this->class ?> "/>
			</div>
		<?php
		}// draw


		public function exportSettings(){

			return array(
						'value' => ( '' != trim( $this->get( 'value' ) ) )? $this->get( 'value' ) : $this->get( 'default_value' ),
						'default_icon' => $this->get( 'default_icon' )
					);
		}// end exportSettings
	};// end WTR_Icon
}