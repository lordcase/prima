<?php

// Don't load directly
if ( !defined('ABSPATH') ) { die('-1'); }

class VCExtendAddonWtr{

	//=== VARIABLES
	public $shtToRemove			= array();
	public $paramInShtToRemove	= array();
	public $groupSht			= array();
	public $shtCardName			= array();
	public $wtrShtMainClass		= 'wtrVcMainShtClass';

	public static $sht_list = array(  );


	//=== FUNCTIONS
	public function __construct(){

		$this->shtCardName = array(
			'margin'		=> __( 'Margins', 'wtr_sht_framework' ),
			'animate'		=> __( 'CSS Animation', 'wtr_sht_framework' ),
			'additional'	=> __( 'Additional', 'wtr_sht_framework' ),
			'container'		=> __( 'Container', 'wtr_sht_framework' ),
			'advanced'		=> __( 'Advanced', 'wtr_sht_framework' ),
			'background'	=> __( 'Background', 'wtr_sht_framework' ),
		);

		$this->groupSht = array(
			'elements'		=> __( 'Wonster Elements', 'wtr_sht_framework' ),
			'additional'	=> __( 'Wonster additional elements', 'wtr_sht_framework' ),
			'media'			=> __( 'Wonster Media', 'wtr_sht_framework' ),
			'woocommerce'	=> __( 'Wonster WooCommerce', 'wtr_sht_framework' ),
		);

	}//end __construct

	public function removeShortcodes(){
		foreach( $this->shtToRemove as $sht ){
			vc_remove_element( $sht );
		}
	}//end removeShortcodes


	public function removeShortcodesParam( $data = null ){

		if( $data && is_array( $data ) ){
			$dataArray = $data;
		}
		else{
			$dataArray = $this->paramInShtToRemove;
		}

		foreach( $dataArray as $sht => $param ){
			if( is_array( $param ) ){
				foreach ( $param as $key ) {
					vc_remove_param( $sht, $key );
				}
			}else{
				vc_remove_param( $sht, $param );
			}
		}
	}//end removeShortcodes


	public function modifyVCCore(){
		// Removing unnecessary params in shortcodes
		$this->removeShortcodesParam();

		// Removing unnecessary shortcodes
		$this->removeShortcodes();
	}//end modifyVCCore


	public function modifyVCCoreStatus(){
		return !empty( $this->shtToRemove ) || !empty( $this->paramInShtToRemove );
	}//end modifyVCCore


	public function shtVCMarginAttrGenerator( &$sht_param, $attr ){

		if( is_array( $sht_param ) && is_array( $attr ) && count( $attr ) ){

			foreach( $attr as $margin ){

				switch( $margin ){

					case 'top':
						$tmp = array(
							'param_name'	=> 'margin_top',
							'heading'		=> __( 'Margin top', 'wtr_sht_framework' ),
							'description'	=> __( '<b>Please, use only numeric signs</b>', 'wtr_sht_framework' ),
							'group'			=> $this->shtCardName[ 'margin' ],
							'type'			=> 'textfield',
							'value'			=> 0,
							'holder'		=> 'hidden',
							'admin_label' 	=> false,
							'class'			=> $this->base . '_margin_top_class',
						);
						array_push( $sht_param, $tmp );
					break;

					case 'bottom':
						$tmp = array(
							'param_name'	=> 'margin_bottom',
							'heading'		=> __( 'Margin bottom', 'wtr_sht_framework' ),
							'description'	=> __( '<b>Please, use only numeric signs</b>', 'wtr_sht_framework' ),
							'group'			=> $this->shtCardName[ 'margin' ],
							'type'			=> 'textfield',
							'value'			=> 0,
							'holder'		=> 'hidden',
							'admin_label' 	=> false,
							'class'			=> $this->base . '_margin_bottom_class',
						);
						array_push( $sht_param, $tmp );
					break;

					case 'right':
						$tmp = array(
							'param_name'	=> 'margin_right',
							'heading'		=> __( 'Margin right', 'wtr_sht_framework' ),
							'description'	=> __( '<b>Please, use only numeric signs</b>', 'wtr_sht_framework' ),
							'group'			=> $this->shtCardName[ 'margin' ],
							'type'			=> 'textfield',
							'value'			=> 0,
							'holder'		=> 'hidden',
							'admin_label' 	=> false,
							'class'			=> $this->base . '_margin_right_class',
						);
						array_push( $sht_param, $tmp );
					break;

					case 'left':
						$tmp = array(
							'param_name'	=> 'margin_left',
							'heading'		=> __( 'Margin left', 'wtr_sht_framework' ),
							'description'	=> __( 'Please, use only numeric signs', 'wtr_sht_framework' ),
							'group'			=> $this->shtCardName[ 'margin' ],
							'type'			=> 'textfield',
							'value'			=> 0,
							'holder'		=> 'hidden',
							'admin_label' 	=> false,
							'class'			=> $this->base . '_margin_left_class',
						);
						array_push( $sht_param, $tmp );
					break;
				}
			}
		}
	}//end shtVCMarginGenerator


	public function shtAnimateAttrEffect( $tab ){

		return array(
			'param_name'	=> 'animate',
			'heading'		=> __( 'Animation effect', 'wtr_sht_framework' ),
			'description'	=> '',
			'group'			=> $tab,
			'type'			=> 'wtr_animate_dropdown',
			'value'			=> array(	__( 'None', 'wtr_sht_framework' )			=> 'none',
										'bounce'							=> 'bounce',
										'bounceIn'							=> 'wtrOpacityNone_bounceIn',
										'bounceInDown'						=> 'wtrOpacityNone_bounceInDown',
										'bounceInLeft'						=> 'wtrOpacityNone_bounceInLeft',
										'bounceInRight'						=> 'wtrOpacityNone_bounceInRight',
										'bounceInUp'						=> 'wtrOpacityNone_bounceInUp',
										'fadeIn'							=> 'wtrOpacityNone_fadeIn',
										'fadeInDown'						=> 'wtrOpacityNone_fadeInDown',
										'fadeInDownBig'						=> 'wtrOpacityNone_fadeInDownBig',
										'fadeInLeft'						=> 'wtrOpacityNone_fadeInLeft',
										'fadeInLeftBig'						=> 'wtrOpacityNone_fadeInLeftBig',
										'fadeInRight'						=> 'wtrOpacityNone_fadeInRight',
										'fadeInRightBig'					=> 'wtrOpacityNone_fadeInRightBig',
										'fadeInUp'							=> 'wtrOpacityNone_fadeInUp',
										'fadeInUpBig'						=> 'wtrOpacityNone_fadeInUpBig',
										'flash'								=> 'flash',
										'flip'								=> 'flip',
										'flipInX'							=> 'wtrOpacityNone_flipInX',
										'flipInY'							=> 'wtrOpacityNone_flipInY',
										'lightSpeedIn'						=> 'wtrOpacityNone_lightSpeedIn',
										'pulse'								=> 'pulse',
										'rotateIn'							=> 'wtrOpacityNone_rotateIn',
										'rotateInDownLeft'					=> 'wtrOpacityNone_rotateInDownLeft',
										'rotateInDownRight'					=> 'wtrOpacityNone_rotateInDownRight',
										'rotateInUpLeft'					=> 'wtrOpacityNone_rotateInUpLeft',
										'rotateInUpRight'					=> 'wtrOpacityNone_rotateInUpRight',
										'slideInDown'						=> 'wtrOpacityNone_slideInDown',
										'slideInLeft'						=> 'wtrOpacityNone_slideInLeft',
										'slideInRight'						=> 'wtrOpacityNone_slideInRight',
										'shake'								=> 'shake',
										'swing'								=> 'swing',
										'rollIn'							=> 'wtrOpacityNone rollIn',
										'rubberBand'						=> 'rubberBand',
										'tada'								=> 'tada',
										'wobble'							=> 'wobble'
									),
			'holder'		=> 'hidden',
			'admin_label'	=> false,
			'class'			=> 'wtr_animate_class',
		);
	}


	public function shtAnimateHTML( $class, $atts ) {

		$result = '';

		extract( shortcode_atts( array(
			'animate'		=> 'none',
			'delay'	=> 0,
			),$atts ) );


		if( 'none' !== $animate and ! empty( $animate ) ) {

			if( strpos( $animate, ' ' ) ){
				$class_animate = explode( ' ', $animate );
			}else{
				$class_animate = explode( '_', $animate );
			}


			if( isset( $class_animate[ 0 ] ) AND 'wtrOpacityNone' == $class_animate[ 0 ] ) {
				$class .= ' wtrOpacityNone ';
				$animate = $class_animate[ 1 ];
			}

			if( '' != $class ){
				$class = $class . ' ';
			}
			$result = ' class="' . esc_attr( $class ) . 'wtr_animate " data-animate="' . esc_attr( $animate ) . '"  data-animate-delay="' . intval( $delay ) . '" ';
		} else if( '' != $class ){
			$result = ' class="' . esc_attr( $class ) . '" ';
		}

		return $result;
	} // end shtAnimateHTML


	public function shtAnimateAttrDelay( $tab ){

		return array(
			'param_name'	=> 'delay',
			'heading'		=> __( 'Animation Delay (in milliseconds)', 'wtr_sht_framework' ),
			'description'	=> __( 'Value must be a number. For example: <b>1</b> second delay is <b>1000</b> milliseconds', 'wtr_sht_framework' ),
			'group'			=> $tab,
			'type'			=> 'textfield',
			'value'			=> 0,
			'holder'		=> 'hidden',
			'admin_label' 	=> false,
			'class'			=> 'wtr_animate_delay_class',
		);
	}//end shtAnimateAttrDelay


	public function shtAnimateAttrGenerator( &$sht_param, $generalTab ){

		if( is_array( $sht_param ) && isset( $generalTab ) ){

			if( $generalTab ){
				$tab = __( $this->shtCardName[ 'animate' ], 'js_composer' );
			}
			else{
				$tab = null;
			}

			array_push( $sht_param, $this->shtAnimateAttrEffect( $tab ) );
			array_push( $sht_param, $this->shtAnimateAttrDelay( $tab ) );
		}
	}//end shtAnimateAttrGenerator


	public function  getDefaultVCfield( $type ){

		switch( $type ){

			case 'el_class':
			return array(
				'param_name'	=> 'el_class',
				'heading'		=> __( 'Extra class name', 'wtr_sht_framework' ),
				'description'	=> __( 'If you wish to style particular content element differently, then use this
										field to add a class name and then refer to it in your css file', 'wtr_sht_framework' ),
				'type'			=> 'textfield',
				'value'			=> '',
				'holder'		=> 'hidden',
				'admin_label' 	=> false,
				'class'			=> $this->base . '_el_class_class'
			);
			break;

			case 'el_id':
			return 	array(
				'param_name'	=> 'el_id',
				'heading'		=> __( 'Row ID', 'wtr_sht_framework' ),
				'description' => sprintf( __( 'Enter row ID (Note: make sure it is unique and valid according to <a href="%s" target="_blank">w3c specification</a>).', 'wtr_sht_framework' ), 'http://www.w3schools.com/tags/att_global_id.asp' ),
				'type'			=> 'el_id',
				'value'			=> '',
				'holder'		=> 'hidden',
				'admin_label' 	=> false,
				'class'			=> $this->base . '_el_id_id'
			);
			break;
		}

	}//end getDefaultVCfield


	public function getTermsData( $list, $attr = array() ){

		$default	= array(
			'hide_empty'		=> false,
			'wtr_add_all_item'	=> true
		);
		$result = array();
		$config	= array_merge( $default, $attr );
		$all	= get_terms( $list, $config );

		if( $config[ 'wtr_add_all_item' ] ){
			$result	= array( __( 'Include all', 'wtr_sht_framework' ) => 'wtr_all_items' );
		}

		if( is_array( $all ) ){
			foreach ( $all as $category ){
				$result[ ' ' . $category->name .' ' ] = esc_attr( $category->slug );
			}
		}

		if( !count( $result ) ) {
			$result = array( __( 'There are no category to choose from', 'wtr_sht_framework' ) => 'NN' );
		}

		return $result;
	}//end get_terms


	public function getWpQuery( $attr = array() ){

		$default = array(
			'post_type'				=> 'gym_location',
			'posts_per_page'		=> -1,
			'ignore_sticky_posts'	=> 1,
			'wtr_add_all_item'		=> true,
			'fields'				=> 'ids'
		);
		$result	= array();
		$config	= array_merge( $default, $attr );

		if( $config[ 'wtr_add_all_item' ] ){
			$result	= array( __( 'Include all', 'wtr_sht_framework' ) => 'wtr_all_items' );
		}else if( $config[ 'wtr_select_item' ] ){
			$result	= array( __( 'Select item', 'wtr_sht_framework' ) => 'wtr_select_item' );
		}

		// The Query
		$posts	= get_posts( $config );

		if ( ! empty( $posts ) ){
			foreach ( $posts as $post ) {
				$name = get_the_title( $post );
				$index = ( trim( $name ) )? $name: __( 'no title', 'wtr_sht_framework' );
				$index = str_replace( '&#8211;', '-', $index );
				$index = str_replace( '&#8212;', '-', $index );
				$result[ ' ' . $index . ' ' ] = $post;
			}
		}


		if( !count( $result ) ) {
			$result = array( __( 'There is no item to choose from', 'wtr_sht_framework' ) => 'NN' );
		}
		return $result;
	}//end generateListGymLocation


	public function prepareCorrectShortcode( $pre_fields, $sht_attr, $fix_attr = array() ){

		// prepare fix array
		$result		= array();
		$fixArray	= array();
		$sizeFields	= count( $pre_fields );

		for( $i = 0; $i < $sizeFields; $i++ ){

			if( !is_array( $pre_fields[ $i ][ 'value' ] ) ){
				$fixArray[ $pre_fields[ $i ][ 'param_name' ] ] = $pre_fields[ $i ][ 'value' ];
			}else{
				$fixArrayTmp = array_slice( $pre_fields[ $i ][ 'value' ], 0, 1 );
				$fixArray[ $pre_fields[ $i ][ 'param_name' ] ] = array_shift( $fixArrayTmp );
			}

		}

		if( !is_array( $sht_attr ) ){
			$sht_attr = array();
		}

		// combining the default settings of the attributes entered
		$result =array_merge( $fixArray, $sht_attr );

		// overwrite bad value
		foreach( $fix_attr as $key => $val ){
			if( isset( $result[ $key ] ) ){
				foreach( $val[ 'bad_value' ] as $err ){
					if( $err == trim( $result[ $key ] ) ){
						$result[ $key ] = $val[ 'replace' ];
						break;
					}
				}
			}
		}
		return $result;
	}//end prepareCorrectShortcode


	public function draw_alert_info_wrong_data_id_sht( $type ){

		$result = '<div class="wtrNotification red wtrShtAlignLeft ">';
			$result .= __( 'Please, go back to Visual Composer, edit <strong>"' . $type . '"</strong> shortcode and select desired item from select box.', 'wtr_cs_framework' );
		$result .= '</div>';

		return $result;
	}//end draw_alert_info_wrong_data_id_sht

}// end VCExtendAddonWtr