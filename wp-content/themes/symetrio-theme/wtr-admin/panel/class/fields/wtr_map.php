<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

require_once( WTR_ADMIN_CLASS_DIR . '/fields/wtr_field.php' );

if ( ! class_exists( 'WTR_Map' ) ) {

	class WTR_Map extends WTR_Filed {

		public function draw( $name = NULL ){

			$name_field	= ( $name ) ? ( $name . '['. $this->id . ']' ) : $this->id;
			$geo		= explode( '|', $this->value );

			//var_dump($name_field);
	/*		$x = get_post_meta( '44', 'ddd_geo_marker', true );
			var_dump($this->value);*/
		?>
			<div class="wonsterFiled ">
				<div class="wfDesc">
					<div class="wfTitle"><?php echo $this->title?></div>
					<div class="setDescNag"><?php echo $this->desc?></div>
				</div>
				<div class="wfSett">
						<input class="sidebarInp wtr_maps_search_in gmaps_search_str"
								type="text"
								placeholder="<?php _e( 'Entry name of the town / street / company', 'wtr_framework' );?>"
								value="">
						<span class="WonButton blue sidebarBtn wtr_gmaps_search_btn"><?php _e( 'Find place', 'wtr_framework' ); ?></span>
						<div 	id="<?php echo $this->get( 'contener_div' ) ?>"
								class="wfGoogleMapDiv wtrGoogleMapContener"
								data-x="<?php echo $geo[ 0 ]; ?>"
								data-y="<?php echo $geo[ 1 ]; ?>"
								data-zoom="<?php echo $this->get( 'zoom' ) ?>"
								style="height:<?php echo $this->get( 'height' ); ?>px;"
								data-type-map-controler="<?php echo $this->type_map_controler; ?>"
								data-style-map-controler="<?php echo $this->style_map_controler; ?>"
								data-marker-map-controler="<?php echo $this->marker_map_controler; ?>"

						>
						</div>
						<input name="<?php echo $name_field; ?>" class="geo_marker wtr_google_map_field wtrGeoMapsVal" type="hidden" value="<?php echo $this->value;?>">
						<div class="wtrDivider"></div>
						<div class="clear"></div>
					</div>
				<div class="clear"></div>
			</div>
		<?php
		}// draw


		public function exportSettings(){

			return array(
						'value'	=> $this->get( 'value' ),
						'x_pos'	=> $this->get( 'x_pos' ),
						'y_pos'	=> $this->get( 'y_pos' )
					);
		}// end exportSettings
	};// end WTR_Map
}