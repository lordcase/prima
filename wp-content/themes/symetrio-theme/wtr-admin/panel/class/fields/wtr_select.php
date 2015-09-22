<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

require_once( WTR_ADMIN_CLASS_DIR . '/fields/wtr_field.php' );

if ( ! class_exists( 'WTR_Select' ) ) {

	class WTR_Select extends WTR_Filed {

		protected $option;


		public function __construct( $data = NULL ) {

			parent::__construct( $data );

			if( isset( $data[ 'meta' ] ) ) {
				if( ! isset( $data[ 'option' ] ) ) {
					throw new Exception( $this->errors['param_construct'] );
				}
			}
			else if ( ! isset( $data[ 'option' ] ) OR ! isset( $data[ 'mod' ] ) OR ! is_array( $data[ 'option' ] ) OR ! count( $data[ 'option' ] ) ) {
				throw new Exception( $this->errors['param_construct'] );
			}
		}// end __construct


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

			if( 'table_sht' ==  $this->mod ){
			?>
			<div class="tableGenerator">
				<div class="wonsterFiled wonsterFiledLastChildKiller">
					<div class="wfDesc">
						<div class="wfTitle">
							<div class="tableGeneratorTittle"><?php echo $this->title?></div>
							<div class="tableTypeSelect">
								<div class="selectdiv ">
									<select class="selectboxdiv <?php echo $this->class ?>" name="<?php echo $name_field ?>">
										<?php
											foreach ( $this->option as $key => $value ) {
												if( is_array( $value ) ){ ?>
													<optgroup label="<?php echo $key ?>">
													<?php
													foreach ( $value as $key2 => $value2 ) { ?>
														<option <?php selected( $key2, $this->value ) ?> value="<?php echo esc_attr( $key2 ); ?>"> <?php echo urldecode( $value2 ) ?></option>
													<?php } ?>
													</optgroup>
												<?php
												}
												else { ?>
													<option <?php selected( $key, $this->value ) ?> value="<?php echo esc_attr( $key ); ?>"> <?php echo urldecode( $value ) ?></option>
												<?php }
												?>
										<?php } ?>
									</select>
									<div class="out"></div>
								</div>
							</div>
							<div class="clear"></div>
						</div>
					</div>
					<div class="wfSett">
						<div class="tableGeneratorNagBtns">
							<a href="" class="WonButton blue Wtr_Table_Add_Row">Add Row</a>
							<a href="" class="WonButton blue Wtr_Table_Add_Col">Add Column</a>
							<div class="clear"></div>
						</div>
					</div>
					<div class="clear"></div>
				</div>
			</div>
			<!-- Table Features Stop -->
			<?php } else{ ?>
			<div class="wonsterFiled <?php echo $dependency; ?>" <?php echo $dependency_data; ?>>
				<div class="wfDesc">
					<div class="wfTitle"><?php echo $this->title?></div>
					<div class="setDescNag"><?php echo $this->desc?></div>
				</div>
				<div class="wfSett">
					<?php
					if( 'font' == $this->mod ) {
						?>
						<div class="setCol-one-three">
							<div class="selectdiv">
								<select id="<?php echo $this->id . '_css'; ?>" class="selectboxdiv wtr_admin_font_switch_select <?php echo $this->class ?>"  name="<?php echo $name_field ?>" >
								<?php
									foreach ( $this->option as $key => $value ) {
										if( is_array( $value ) ){ ?>
											<optgroup label="<?php echo $key ?>">
											<?php
											foreach ( $value as $key2 => $value2 ) { ?>
												<option <?php selected( $key2, $this->value ) ?> value="<?php echo esc_attr( $key2 ); ?>"> <?php echo urldecode( $value2 ) ?></option>
											<?php } ?>
											</optgroup>
										<?php
										}
										else{ ?>
											<option <?php selected( $key, $this->value ) ?> value="<?php echo esc_attr( $key ); ?>"> <?php echo urldecode( $value ) ?></option>
										<?php }
										?>
								<?php } ?>
								</select>
								<div class="out"></div>
							</div>
						</div>
						<div class="setCol-two-three selCol-font-prev-mod">

							<div class="fontPrev roundBor wtr_admin_font_prev"></div>
							<span class="fontPrevNag"> <?php _e( 'Font preview', WTR_THEME_NAME ) ?></span>
							<div class="clear"></div>
						</div>
						<?php
					} else if( 'page' ==  $this->mod ) { ?>
							<div class="selectdiv">
								<select class="selectboxdiv <?php echo $this->class ?> "  name="<?php echo $name_field ?>" >
								<?php if( isset( $this->first_value_title )) :?>
									<option value=""><?php echo $this->first_value_title  ?></option>
								<?php endif ?>
							<?php
									//$page = get_pages('title_li=&orderby=name');
									$pages = get_pages('sort_column=post_title&hierarchical=0');
									foreach ( $pages as $page ) { ?>
										<?php $title =  ($page->post_title ) ?  $page->post_title : __( '(no title)', WTR_THEME_NAME ) ?>
										<option <?php selected( $page->ID, $this->value ) ?> value="<?php echo esc_attr( $page->ID ); ?>"> <?php echo $title ?></option>
							<?php	} ?>
								</select>
								<div class="out"></div>
							</div>
					<?php
					} else if( 'sidebar' ==  $this->mod ) { ?>
						<div class="selectdiv WtrNoneSidebarSelect WtrNoneSidebarData WtrNoneSidebarDataInfo <?php echo $this->class ?>" style="display:none">
							<select  ctrp="<?php echo $this->value;?>" class="selectboxdiv <?php echo $this->class ?>"  name="<?php echo $name_field ?>" ></select>
							<div class="out"></div>
						</div>
						<div class="WonsterFiled WtrNoneSidebarInfo WtrNoneSidebarData WtrNoneSidebarDataInfo<?php echo $this->class ?>" style="display:none" >
							<?php echo $this->meta ?>
							<input class="WtrNoneSidebarValue" type="hidden" value="" name="<?php echo $name_field ?>" disabled="disabled">
						</div>

					<?php
					} else if( 'map_style' ==  $this->mod ) { ?>
								<div class="selectdiv">
									<select class="selectboxdiv <?php echo $this->class ?> "  name="<?php echo $name_field ?>" id="<?php echo $name_field ?>" >
										<?php foreach ( $this->option as $key => $value ) { ?>
												<option <?php selected( $key, $this->value ) ?> value="<?php echo esc_attr( $key ); ?>"> <?php echo urldecode( $value ) ?></option>
										<?php } ?>
									</select>
									<div class="out"></div>
								</div>
								<div>
										<div id="<?php echo $this->get( 'contener_div' ) ?>" data-zoom="<?php echo $this->get( 'zoom' ) ?>"  class="wfGoogleMapDiv wfGoogleMapDivStyle wtrGoogleMapContener" style="width:100%; height:<?php echo $this->get( 'height' ); ?>px;"></div>
										<div class="wtrDivider"></div>
										<div class="clear"></div>
								</div>
								<div class="clear"></div>
							<div class="WonsterFiled" style="display:none" ><?php echo $this->meta ?></div>
					<?php
					} else if( 'marker_style' ==  $this->mod ) { ?>
							<div class="four-five">
								<div class="selectdiv">
									<select class="selectboxdiv <?php echo $this->class ?> "  name="<?php echo $name_field ?>" id="<?php echo $name_field ?>" >
										<?php foreach ( $this->option as $key => $value ) { ?>
												<option <?php selected( $key, $this->value ) ?> value="<?php echo esc_attr( $key ); ?>"> <?php echo urldecode( $value ) ?></option>
										<?php } ?>
									</select>
									<div class="out"></div>
								</div>
							</div>
							<div class="one-five">
								<div class="markerPreview">
									<img class="changeMarkerStyleGoogleMapsPrev">
								</div>
							</div>

							<div class="clear"></div>
							<div class="WonsterFiled" style="display:none" ><?php echo $this->meta ?></div>
					<?php
					} else if( 'animation' ==  $this->mod ) { ?>
							<div class="selectdiv">
								<select class="selectboxdiv <?php echo $this->class ?> wtrAnimateTriggerSelect"  name="<?php echo $name_field ?>" id="<?php echo $name_field ?>" >
									<?php foreach ( $this->option as $key => $value ) { ?>
											<option <?php selected( $key, $this->value ) ?> value="<?php echo esc_attr( $key ); ?>"> <?php echo urldecode( $value ) ?></option>
									<?php } ?>
								</select>
								<div class="out"></div>
							</div>

							<div class="animationDiv">
								<div class="animationPreview">
									<div class="animatedElement"><?php _e( 'Your animation', WTR_THEME_NAME ); ?></div>
									<span class="sectionTittle"><?php _e( 'Preview', WTR_THEME_NAME ); ?></span>
								</div>
							</div>
							<div class="setDescUnder">
							<?php _e( 'Css Animation doesn\'t work on IE 9 and older' , WTR_THEME_NAME ); ?>
							<div class="clear"></div>
							<div class="WonsterFiled" style="display:none" ><?php echo $this->meta ?></div>
					<?php
					} else if( 'overwrite_skin' ==  $this->mod ) { ?>
						<div class="selectdiv wtr-overwrite-skin">
							<?php wp_nonce_field( 'wtr_restet_custom_skin_nonce', 'wtr_restet_custom_skin_nonce' ); ?>
							<select class="selectboxdiv <?php echo $this->class ?> wtrOverwriteSkinSelect"  name="<?php echo $name_field ?>" id="<?php echo $name_field ?>" >
								<?php foreach ( $this->option as $key => $value ) { ?>
										<option <?php selected( $key, $this->value ) ?> value="<?php echo esc_attr( $key ); ?>"> <?php echo urldecode( $value ) ?></option>
								<?php } ?>
							</select>
							<div class="out"></div>
						</div>
						<a rel="leanModal" name="wonsterModal" href="#wonsterModalOverwriteCustomSkin" class="WonButton blue sidebarBtn"><?php  _e( 'Overwrite', WTR_THEME_NAME ) ?></a>
					<?php
					} else if( 'one_click_import' ==  $this->mod ) { ?>
						<div class="selectdiv wtr-one-click-skin">
							<?php wp_nonce_field( 'wtr_one_click_import_nonce', 'wtr_one_click_import_nonce' ); ?>
							<select class="selectboxdiv  <?php echo $this->class ?> wtrAnimateTriggerSelect"  name="<?php echo $name_field ?>" id="<?php echo $this->id ?>" >
								<?php foreach ( $this->option as $key => $value ) { ?>
										<option <?php selected( $key, $this->value ) ?> value="<?php echo esc_attr( $key ); ?>"> <?php echo urldecode( $value ) ?></option>
								<?php } ?>
							</select>
							<div class="out"></div>
						</div>
						<a rel="leanModal" name="wonsterModal" href="#wonsterModalRestoreOneCick" class="WonButton red sidebarBtn"><?php  _e( 'Import data', WTR_THEME_NAME ) ?></a>
					<?php
					} else if( 'multiselect' == $this->mod ) {
						$new_val = explode( ';', $this->value );
						$new_val = array_filter( $new_val );
						$wsk_new = 0;

						if ( $new_val ) {
							$hidden_select = $this->value;
						} else {
							$hidden_select = ';' . key( $this->option ) . ';';
						}
						?>
						<select multiple="multiple" size="<?php echo $this->size; ?>" class="wtrSelectMultiple <?php echo $this->class ?>" id="<?php echo $name_field ?>_tmp" name="<?php echo $name_field ?>_tmp" >
							<?php foreach ( $this->option as $key => $value ) {
								$wsk_new++;
								if ( $new_val ){
									if ( in_array( $key, $new_val ) ) {
										$sel = 'selected="selected"';
									} else {
										$sel = '';
									}
								?>
									<option <?php echo $sel; ?> value="<?php echo esc_attr( $key ); ?>"><?php echo urldecode( $value ) ?></option>
								<?php }
								else{
									if( 1 == $wsk_new ){?>
										<option selected="selected" value="<?php echo esc_attr( $key );?>"><?php echo urldecode( $value ) ?></option>
									<?php } else { ?>
										<option value="<?php echo esc_attr( $key );?>"> <?php echo urldecode( $value ) ?></option>
									<?php }
								}
							 } ?>
						</select>
						<input type="hidden" name="<?php echo $name_field ?>" value="<?php echo $hidden_select;?>" class="ReadStandard wtrSelectMultipleHidden"/>
					<?php
					} else { // normal select
						if( $this->option ){  ?>
							<div class="selectdiv">
								<select class="selectboxdiv <?php echo $this->class ?>" id="<?php echo $name_field ?>" name="<?php echo $name_field ?>" >
									<?php foreach ( $this->option as $key => $value ) { ?>
										<option <?php selected( $key, $this->value ) ?> value="<?php echo esc_attr( $key ); ?>"><?php echo urldecode( $value ) ?></option>
									<?php } ?>
								</select>
								<div class="out"></div>
							</div>
							<div class="WonsterFiled" style="display:none" ><?php echo $this->meta ?></div>
						<?php
						} else { ?>
							<div class="WonsterFiled">
								<?php echo $this->meta ?>
							</div>
						<?php
						}
					}
					if ( $this->info ) { ?>
						<div class="setDescUnder">
							<?php echo $this->info ?>
						</div>
					<?php } ?>
				</div>
				<div class="clear"></div>
			</div>
		<?php
			}
		}// draw
	};// end WTR_Select
}