<?php

// Don't load directly
if ( !defined('ABSPATH') ) { die('-1'); }

class VCExtendAddonWtrShortcodesParam{

	//=== VARIABLES
	private $jsParamFile = 'vc-wtr-param.js';
	private $patchAssets;


	//=== FUNCTIONS
	public function __construct() {
		// set patch to VC params assets
		$this->patchAssets = plugins_url( 'assets/js/' . $this->jsParamFile, __FILE__ );

		add_action( 'wp_ajax_wtr_get_attachment_data', array( &$this, 'get_attachment_data' ) );

		// load new VC params
		add_shortcode_param('wtr_hidden', array( &$this, 'wtr_hidden' ), $this->patchAssets );
		add_shortcode_param('wtr_animate_dropdown', array( &$this, 'wtr_animate_dropdown' ), $this->patchAssets );
		add_shortcode_param('wtr_alert', array( &$this, 'wtr_alert' ), $this->patchAssets );
		add_shortcode_param('wtr_icons_set', array( &$this, 'wtr_icons_set' ), $this->patchAssets );
		add_shortcode_param('wtr_google_map', array( &$this, 'wtr_google_map' ), $this->patchAssets );
		add_shortcode_param('wtr_multi_select', array( &$this, 'wtr_multi_select' ), $this->patchAssets );
	}//end __construct


	public function wtr_hidden( $settings, $value ) {

		$dependency = vc_generate_dependencies_attributes( $settings );

			return '<div class="wtr_hidden">'
						.'<input name="'.$settings['param_name']
						.'" class="wpb_vc_param_value wtr_vc_hidden wpb-textinput '
						.$settings['param_name'].' '.$settings['type'].'_field" type="hidden" value="'
						.$value.'" ' . $dependency . '/>'
					.'</div>';
	}//end wtr_hidden


	public function wtr_animate_dropdown( $settings, $value ){

		$dependency = vc_generate_dependencies_attributes( $settings );
		$result = '';

		$result .=
			'<div class="wtr_animate_dropdown">
				<div class="wtr_animate_dropdown_selector">
						<select name="'.$settings['param_name']
						.'" class="wpb_vc_param_value wpb-input wpb-select wtr_animate_select '
						.$settings['param_name'].' '.$settings['type'].'_field ' . $value . '"'
						. $dependency . ' data-option="' . $value . '">';

				foreach( $settings['value'] as $name => $val ){
					if( trim( $val ) == trim( $value ) ){
						$sel = 'selected="selected"';
					}
					else{
						$sel = '';
					}
					$result .= '<option ' . $sel . ' class="' . $val . '" value="'. $val .'">' . $name . '</option>';
				}

			$result .= '</select>
				</div>
				<div class="wtr_animate_div animationDiv">
					<div class="animationPreview">
						<div class="animatedElement">Your animation</div>
						<span class="sectionTittle">Preview</span>
					</div>
				</div>
				<span class="description clear">' . __( 'Css Animation doesn\'t work on IE 9 and older' , 'wtr_sht_framework' ) .'</span>
			</div>';

		return $result;
	}//end wtr_animate_dropdown


	public function wtr_alert( $settings, $value ){

		$config = array(
			'extra_class'	=> '',
			'message'		=> '',
		);

		$config		= array_merge( $config, ( isset( $settings[ 'wtr_attr' ] )? $settings[ 'wtr_attr' ] : array() ) );
		$dependency = vc_generate_dependencies_attributes( $settings );

		return '<div class="wtr_alert">
					<div class="wonsterFiledAlert ' . $config[ 'extra_class' ] . '">
						' . $config[ 'message' ] . '
					</div>
					<input name="'.$settings['param_name']
					.'" class="wpb_vc_param_value wpb-textinput wtr-new-fields'
					.$settings['param_name'].' '.$settings['type'].'_field" type="hidden" value="'
					.$value.'" ' . $dependency . '/>
				</div>';
	}//end wtr_alert


	public function wtr_icons_set( $settings, $value ){

		global $wtr_icons;

		$dependency = vc_generate_dependencies_attributes( $settings );
		$result = '';

		$val_attr	= explode( '|', $value );
		$group		= $val_attr[ 0 ];
		$icon_set	= $val_attr[ 1 ];

		$result =
		'<div class="wtr_vc_icons_set_div">

			<div class="set-col-3 sc-3-margin">
				<div class="icoSelectGroup">
					<select class="wpb-select wtrVcSelectGroup">';

						foreach( array_keys( $wtr_icons ) as $key ){
							$result .= '<option '. selected( $key, $group, false )  .' value="' . $key . '">' . $wtr_icons[ $key ][ 'name' ] . ' </option>';
						}

					$result .= '
					</select>
					<div class="out"></div>
				</div>
			</div>

			<div class="set-col-3">
				<div class="wfDescFullWidth wtrIconSelectUser" style="<?php echo $defaultV;?>">
					<div class="floatRight">
						<div class="wfSelectedIcon">' . __('You selected:', 'wtr_framework' ) . '</div>
						<div class="wfSelectedIconPrev">
							<i class="' . $icon_set . '"></i>
						</div>
					</div>
				</div>
				<div class="clear"></div>
			</div>
			<div class="clear"></div>';

			foreach( array_keys( $wtr_icons ) as $key ){
				$result .= '
				<div class="iconContainer wtrVcIconList wtrIcon_' . $key . '" style="display:none;">
					<ul class="iconList">';

						foreach( $wtr_icons[ $key ][ 'collection' ] as $icon ){

							$this_icon = ( $icon == $icon_set )? 'iTPActive' : '';

							$result .= '
							<li class="iconItem">
									<span class="wtrVcIconItemPos ' . $this_icon . '">
										<i class="' . $icon . '"></i>
									</span>
							</li>';
						}

					$result .= '
					</ul>
					<div class="clear"></div>
				</div>';
			}

			$result .= '
			<input name="'.$settings['param_name']
			.'" class="wpb_vc_param_value wpb-textinput wtr-icon-set-fields wtr_vc_selected_icon '
			.$settings['param_name'].' '.$settings['type'].'_field" type="hidden" value="'
			.$value.'" ' . $dependency . '/>'
		.'</div>';


		return $result;
	}//end wtr_icons_set


	public function wtr_google_map( $settings, $value ){

		$dependency = vc_generate_dependencies_attributes( $settings );
		$result = '';

		$config = array(
			'type_map_controler'	=> false,
			'style_map_controler'	=> false,
			'marker_controler'		=> false,
			'map_height'			=> '250',
			'map_zoom'				=> '10',
			'road_contener'			=> false,
			'road_color'			=> false,
			'road_weight'			=> false,
		);




		$config				= array_merge( $config, ( isset( $settings[ 'wtr_attr' ] )? $settings[ 'wtr_attr' ] : array() ) );
		$config[ 'geo' ]	= explode( '|', $value );

		$result .='
		<div class="wtrVcGoogleMapsSection">
			<div class="clearfix wtrVcSearchSectionMaps">
				<div class="wtrVcCol wtrVcColThreeFourth">
					<input class="sidebarInp wtr_maps_search_in gmaps_search_str" type="text" placeholder="' .
						__( 'Entry name of the town / street / company', 'wtr_sht_framework' ) . '" value="">
				</div>
				<div class="wtrVcCol wtrVcColOneFourth wtrVcColLast">
					<button class="button-primary wtr_gmaps_search_btn wtrFullWidthButton">
						' . __( 'Find place', 'wtr_sht_framework' ) .
					'</button>
				</div>
			</div>
			<div id="' . $settings['param_name'] . '_map" data-zoom="' . $config[ 'map_zoom' ] . '" '.
				' data-x="' . $config[ 'geo' ][ 0 ]. '" data-y="' . $config[ 'geo' ][ 1 ] .'" ' .
				' data-type-map-controler="' . $config[ 'type_map_controler' ] . '" ' .
				' data-style-map-controler="' . $config[ 'style_map_controler' ] . '" ' .
				' data-marker-map-controler="' . $config[ 'marker_controler' ] . '" ' .
				' data-road-controler="' . $config[ 'road_contener' ] . '" ' .
				' data-road-color="' . $config[ 'road_color' ] . '" ' .
				' data-road-weight="' . $config[ 'road_weight' ] . '" ' .
				' class="wfGoogleMapDiv wtrVcGoogleMapContener" style="height:' . $config[ 'map_height' ] . 'px;">
			</div>';

			if( $config[ 'road_contener' ] ){
				$result .='
				<div class="roadMsgInfoFirstPoint">
					<p>' . __( 'Click on the map to create the beginning of route and start drawing', 'wtr_sht_framework' ) . '</p>
				</div>
				<div class="wtrGoogleMapToolSet">
					<button id="removeAllPoint" class="button"><i class="fa fa-times"></i> ' . __( 'Remove all points', 'wtr_sht_framework' ) . '</button>
					<button id="removeLastPoint" class="button"><i class="fa fa-step-backward"></i> ' . __( 'Undo', 'wtr_sht_framework' ) . '</button>
					<span class="wtrGoogleMapsElements">
						<input type="checkbox" id="roadSnapMode" checked="checked"> ' . __( 'Road Snap', 'wtr_sht_framework' ) . ' |
						<i class="fa fa-flag-checkered"></i> ' . __( 'Distance', 'wtr_sht_framework' ) . ':
							<span id="distanceRoad"  style="font-weight:bold;">
								<span class="wtrDistMiles">0</span> ' . __( 'miles', 'wtr_sht_framework' ) .
								' ( <span class="wtrDistKm">0</span> ' . __( 'km', 'wtr_sht_framework' ) .
								' / <span class="wtrDistMetres">0</span> ' . __( 'm', 'wtr_sht_framework' ) .' )
							</span>
					<span>
				</div>';
			}

			$result .='
			<input name="' . $settings['param_name'] .'" class="wpb_vc_param_value wpb-textinput '
				.$settings['param_name'].' '.$settings['type'].'_field wtrVcGeoMapsVal" type="hidden" value="' .
				$value . '" ' . $dependency . '/>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>';

		return $result;
	}//end wtr_google_map


	public function wtr_multi_select( $settings, $value ){

		$config = array(
			'size'	=> 4,
		);

		$config		= array_merge( $config, ( isset( $settings[ 'wtr_attr' ] )? $settings[ 'wtr_attr' ] : array() ) );
		$dependency	= vc_generate_dependencies_attributes( $settings );
		$real_val	= explode( ',', $value );

		$result =
			'<div class="wtr_multi_dropdown_selector">
				<select size="' . $config[ 'size' ] . '" multiple="multiple" name="'.$settings['param_name']
				.'" class="wpb-input wpb-select wtr_vc_multi_select_field">';

				foreach( $settings['value'] as $name => $val ){
					if( in_array( trim( $val ), $real_val ) ){
						$sel = 'selected="selected"';
					}
					else{
						$sel = '';
					}
					$result .= '<option ' . $sel . ' class="' . $val . '" value="'. $val .'">' . $name . '</option>';
				}

		$result .= '
				</select>'
				.'<input name="'.$settings['param_name']
				.'" class="wpb_vc_param_value wtr_vc_value wpb-textinput'
				.$settings['param_name'].' '.$settings['type'].'_field" type="hidden" value="'
				.$value.'" ' . $dependency . '/>
		</div>';

		return $result;
	}//end wtr_multis_elect


	public function get_attachment_data(){
		$id			= intval( $_POST[ 'id_file' ] );
		$upload_dir	= wp_upload_dir();
		$file		= wp_get_attachment_metadata( $id );

		echo json_encode( array( 'url' => trailingslashit( $upload_dir[ 'baseurl' ] ) .  $file[ 'file' ], 'height' => $file[ 'height' ], 'width' => $file[ 'width' ] ) );
		die();
	}//end get_attachment_data

}//end VCExtendAddonWtrShortcodesParam

new VCExtendAddonWtrShortcodesParam();