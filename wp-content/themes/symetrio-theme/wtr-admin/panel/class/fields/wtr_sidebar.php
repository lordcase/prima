<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

require_once( WTR_ADMIN_CLASS_DIR . '/fields/wtr_field.php' );

if ( ! class_exists( 'WTR_Sidebar' ) ) {

	class WTR_Sidebar extends WTR_Filed {

		public function draw( $name = NULL ){

			$name_field = ( $name ) ? ( $name . '['. $this->id . ']' ) : $this->id;
		?>
			<div class="wonsterFiled ">
				<div class="wfDesc">
					<div class="wfTitle"><?php echo $this->title?></div>
					<div class="setDescNag"><?php echo $this->desc?></div>
				</div>
				<div class="wfSett">
					<input class="<?php echo $this->class ?> sidebarInp wtr_admin_add_sidebar_input" type="text" data-tname="<?php echo $name;?>"  data-id="<?php echo $this->id;?>" data-placeholder="<?php _e( 'Sidebar name', WTR_THEME_NAME ) ?>" value="">
					<a href="" class="WonButton blue sidebarBtn wtr_admin_add_sidebar"> <?php _e( 'Add sidebar', WTR_THEME_NAME) ?> </a>
					<?php if( $this->info ) { ?>
						<div class="setDescUnder">
							<?php echo $this->info ?>
						</div>
					<?php } ?>
					<div class="sidebarList">
						<ul class="wtr_admin_sidebar_list">
						<?php
						if( is_array($this->value)){

							$visUL = 'none;';

							foreach ( $this->value  as $value) { ?>
								<li>
									<div class="sidebarName"><?php echo urldecode( $value ); ?></div>
									<a rel="leanModal" href="#wonsterModal_sidebarDel" class="delSidebar wtr_admin_del_sidebar"></a>
									<input type="hidden"  name="<?php echo $name; ?>[<?php echo $this->id;?>][<?php echo $value ?>]" value="<?php echo $value ?>" class="wtr_sidebar_name_field"  />
								</li>
						<?php
							}
						}
						else{
							$visUL = 'block;';
						}
						?>
							<li>
								<div style="display:<?php echo $visUL ?>" class="noSidebar"><?php _e( 'Type sidebar name above and press the button', WTR_THEME_NAME) ?></div>
							</li>
						</ul>
					</div>
					<div class="clear"></div>
				</div>
				<div class="clear"></div>
			</div>
		<?php
		}// draw
	};// end WTR_Sidebar
}