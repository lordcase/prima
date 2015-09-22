<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

require_once( WTR_ADMIN_CLASS_DIR . '/fields/wtr_field.php' );

if ( ! class_exists( 'WTR_Sortable' ) ) {

	class WTR_Sortable extends WTR_Filed {

		public function draw( $name = NULL ){
			$name_field = ( $name ) ? ( $name . '['. $this->id . ']' ) : $this->id;
			?>
			<div class="wonsterFiled ">
				<div class="wfDesc">
					<div class="wfTitle"><?php echo $this->title?></div>
					<div class="setDescNag"><?php echo $this->desc?></div>
				</div>
				<div class="wfSett">
					<div class="accordContener">
						<ul id="<?php echo $this->id; ?>" data-typed="<?php echo $this->type; ?>"
							data-widthd="<?php echo $this->modal_child_size['width']; ?>"
							data-heightd="<?php echo $this->modal_child_size['height']; ?>"
							data-fullscreenwd="<?php echo $this->modal_child_size['fullscreenw']; ?>"
							data-fullscreenhd="<?php echo $this->modal_child_size['fullscreenh']; ?>"
							data-min-one="<?php echo $this->min_one; ?>"
							data-max-one="<?php echo $this->max_one; ?>"
							data-child-elem="<?php echo $this->child_shortcode;?>"
							class="wtrSortableList <?php echo $this->class ?>"
							name ="<?php echo $this->id; ?>"
						>
							<li class="noSidebarLi"><div style="" class="noSidebar"><?php echo $this->zero_item; ?> </div></li>
							<?php
								foreach( $this->option as $itemPos => $el ){
									$prevtmp	= $el[ $this->option_prev ][ 'value' ];
									$prevtmp	= trim( strip_tags( $prevtmp ) );

									if( strlen( $prevtmp ) >= 55 ) {
										$prev = mb_substr( $prevtmp, 0, 55) . '...';
									} else {
										$prev = $prevtmp;
									}
								?>
								<li class="ui-state-default">

									<?php if($this->control ) { ?>
											<span class="handle"></span>
											<a class="wtr_accordItemName wtr_accordItemNameCode" data-item="<?php echo $itemPos; ?>" href=""><?php echo $prev; ?></a>
											<span class="wtr_accordItemDelete"></span>
										<?php }else{ ?>
											<span class="detail"></span>
											<a class="wtr_accordItemName wtr_accordItemNameCode" data-item="<?php echo $itemPos; ?>" href=""><?php echo $prev; ?></a>
											<!-- <span class="wtr_accordItemName" >
												<?php echo $el[ $this->option_prev ][ 'value' ]; ?>
											</span> -->
										<?php } ?>
										<input type="hidden" class="Wtr_Opt_Full" value="<?php echo esc_attr($el[ $this->option_prev ][ 'value' ]); ?>">
										<input type="hidden" class="Wtr_Opt_Shortcode" value="<?php echo ( isset( $this->option_shortcode[ $itemPos ] )? esc_attr($this->option_shortcode[ $itemPos ]) : '' ); ?>">
								</li>
							<?php } ?>
						</ul>
						<?php if($this->control ) { ?>
						<a class="wtr_accordItemAdd" href="#"></a>
						<?php } ?>
						<div class="clear"></div>
					</div>
					<div class="clear"></div>
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


		public function exportSettings(){

			return array(
						'option'			=> $this->get( 'option' ),
						'option_shortcode'	=> $this->get( 'option_shortcode' ),
						'option_prev'		=> $this->get( 'option_prev' ),
						'default_option'	=> $this->get( 'default_option' ),
						'default_shortcode'	=> $this->get( 'default_shortcode' ),
						'defautl_rewrite'	=> $this->get( 'defautl_rewrite' ),
						'child_shortcode'	=> $this->get( 'child_shortcode' ),
						'child_end_el'		=> $this->get( 'child_end_el' )
					);
		}// end exportSettings
	};// end WTR_Text
}