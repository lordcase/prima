<?php
// Don't load directly
if ( !defined('ABSPATH') ) { die('-1'); }

include_once ( 'vc_wtr.php' );

class VCExtendAddonOpenHours extends VCExtendAddonWtr{

	public $base	= 'vc_wtr_open_hours';
	public $fields	= array();

	//===FUNCTIONS
	public function __construct(){

		parent::__construct();

		// We safely integrate with VC with this hook
		add_action( 'init', array( &$this, 'integrateWithVC' ) );

		//Creating a shortcode addon
		add_shortcode( $this->base, array( &$this, 'render' ) );
	}//end __construct


	public function integrateWithVC(){
		// Map fields

		$this->fields = array(

			array(
				'param_name'	=> 'content',
				'heading'		=> __( 'Content', 'wtr_sht_framework' ),
				'description'	=> __( 'Leave this field blank if you don\'t want display content', 'wtr_sht_framework' ),
				'type'			=> 'textarea_html',
				'value'			=> '',
				'admin_label' 	=> false,
				'class'			=> $this->base . '_data_content_class',
			),

			array(
				'param_name'	=> 'label_1',
				'heading'		=> __( 'Monday (label)', 'wtr_sht_framework' ),
				'description'	=> __( 'Leave this field blank if you don\'t want display content', 'wtr_sht_framework' ),
				'type'			=> 'textfield',
				'value'			=> __( 'Monday', 'wtr_sht_framework' ),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_label_1_class',
			),

			array(
				'param_name'	=> 'val_1',
				'heading'		=> __( 'Monday open hours', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'textfield',
				'value'			=> '',
				'admin_label' 	=> false,
				'class'			=> $this->base . '_val_1_class',
			),

			array(
				'param_name'	=> 'label_2',
				'heading'		=> __( 'Tuesday (label)', 'wtr_sht_framework' ),
				'description'	=> __( 'Leave this field blank if you don\'t want display content', 'wtr_sht_framework' ),
				'type'			=> 'textfield',
				'value'			=> __( 'Tuesday', 'wtr_sht_framework' ),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_label_2_class',
			),

			array(
				'param_name'	=> 'val_2',
				'heading'		=> __( 'Tuesday open hours', 'wtr_sht_framework' ),
				'description'	=> __( 'Leave this field blank if you don\'t want display content', 'wtr_sht_framework' ),
				'type'			=> 'textfield',
				'value'			=> '',
				'admin_label' 	=> false,
				'class'			=> $this->base . '_val_2_class',
			),

			array(
				'param_name'	=> 'label_3',
				'heading'		=> __( 'Wednesday (label)', 'wtr_sht_framework' ),
				'description'	=> __( 'Leave this field blank if you don\'t want display content', 'wtr_sht_framework' ),
				'type'			=> 'textfield',
				'value'			=> __( 'Wednesday', 'wtr_sht_framework' ),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_label_3_class',
			),

			array(
				'param_name'	=> 'val_3',
				'heading'		=> __( 'Wednesday open hours', 'wtr_sht_framework' ),
				'description'	=> __( 'Leave this field blank if you don\'t want display content', 'wtr_sht_framework' ),
				'type'			=> 'textfield',
				'value'			=> '',
				'admin_label' 	=> false,
				'class'			=> $this->base . '_val_3_class',
			),

			array(
				'param_name'	=> 'label_4',
				'heading'		=> __( 'Thursday (label)', 'wtr_sht_framework' ),
				'description'	=> __( 'Leave this field blank if you don\'t want display content', 'wtr_sht_framework' ),
				'type'			=> 'textfield',
				'value'			=> __( 'Thursday', 'wtr_sht_framework' ),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_label_4_class',
			),

			array(
				'param_name'	=> 'val_4',
				'heading'		=> __( 'Thursday open hours', 'wtr_sht_framework' ),
				'description'	=> __( 'Leave this field blank if you don\'t want display content', 'wtr_sht_framework' ),
				'type'			=> 'textfield',
				'value'			=> '',
				'admin_label' 	=> false,
				'class'			=> $this->base . '_val_4_class',
			),

			array(
				'param_name'	=> 'label_5',
				'heading'		=> __( 'Friday (label)', 'wtr_sht_framework' ),
				'description'	=> __( 'Leave this field blank if you don\'t want display content', 'wtr_sht_framework' ),
				'type'			=> 'textfield',
				'value'			=> __( 'Friday', 'wtr_sht_framework' ),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_label_5_class',
			),

			array(
				'param_name'	=> 'val_5',
				'heading'		=> __( 'Friday open hours', 'wtr_sht_framework' ),
				'description'	=> __( 'Leave this field blank if you don\'t want display content', 'wtr_sht_framework' ),
				'type'			=> 'textfield',
				'value'			=> '',
				'admin_label' 	=> false,
				'class'			=> $this->base . '_val_5_class',
			),

			array(
				'param_name'	=> 'label_6',
				'heading'		=> __( 'Saturday (label)', 'wtr_sht_framework' ),
				'description'	=> __( 'Leave this field blank if you don\'t want display content', 'wtr_sht_framework' ),
				'type'			=> 'textfield',
				'value'			=> __( 'Saturday', 'wtr_sht_framework' ),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_label_6_class',
			),

			array(
				'param_name'	=> 'val_6',
				'heading'		=> __( 'Saturday open hours', 'wtr_sht_framework' ),
				'description'	=> __( 'Leave this field blank if you don\'t want display content', 'wtr_sht_framework' ),
				'type'			=> 'textfield',
				'value'			=> '',
				'admin_label' 	=> false,
				'class'			=> $this->base . '_val_6_class',
			),

			array(
				'param_name'	=> 'label_7',
				'heading'		=> __( 'Sunday (label)', 'wtr_sht_framework' ),
				'description'	=> __( 'Leave this field blank if you don\'t want display content', 'wtr_sht_framework' ),
				'type'			=> 'textfield',
				'value'			=> __( 'Sunday', 'wtr_sht_framework' ),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_label_7_class',
			),

			array(
				'param_name'	=> 'val_7',
				'heading'		=> __( 'Sunday open hours', 'wtr_sht_framework' ),
				'description'	=> __( 'Leave this field blank if you don\'t want display content', 'wtr_sht_framework' ),
				'type'			=> 'textfield',
				'value'			=> '',
				'admin_label' 	=> false,
				'class'			=> $this->base . '_val_7_class',
			),

			$this->getDefaultVCfield( 'el_class' ),
		);

		// animate attr
		$this->shtAnimateAttrGenerator( $this->fields, true );

		vc_map( array(
			'name'			=> __( 'Open Hours', 'wtr_sht_framework' ),
			'description'	=> '',
			'base'			=> $this->base,
			'class'			=> $this->base . '_div '. $this->wtrShtMainClass,
			'icon'			=> $this->base . '_icon',
			'controls'		=> 'full',
			'category'		=> $this->groupSht[ 'elements' ],
			'params'		=> $this->fields,
			'weight'		=> 23000,
			)
		);
	}//end integrateWithVC


	public function render( $atts, $content = null ){
		$result				='';
		$atts['content']	= wpb_js_remove_wpautop( $content, false );
		$atts				= $this->prepareCorrectShortcode( $this->fields, $atts );
		extract( $atts );

		$content = trim( $content );

		$class_html_attr = 'wtrSht wtrShtOpenHours ' . $el_class;
		$result .= '<div' . $this->shtAnimateHTML( $class_html_attr, $atts ) . '>';

			if( strlen( $content ) ){
				$result .= '<div class="wtrShtOpenHoursDesc">';
					$result .= $content;
				$result .= '</div>';
			}

			$result .= '<div class="wtrShtOpenHoursItemBox">';
				foreach ( range( 1, 7) as $i ) {

					$current_label	= trim( ${'label_'.$i} );
					$current_val	= trim( ${'val_'.$i} );

					if( ! empty( $current_label ) AND  ! empty( $current_val ) ){
						$result .= '<div class="wtrShtOpenHoursItem">';
							$result .= '<div class="wtrShtOpenHoursItemShedule clearfix">';
								$result .= '<i class="wtrShtOpenIcon fa fa-clock-o"></i>';
								$result .= '<div class="wtrShtOpenHoursMeta clearfix">';
									$result .= '<h5 class="wtrShtOpenHoursDay">' . $current_label . '</h5>';
									$result .= '<div class="wtrShtOpenHoursTime"> ' . $current_val . '</div>';
								$result .= '</div>';
							$result .= '</div>';
						$result .= '</div>';
					}
				}
			$result .= '</div>';
		$result .= '</div>';

		return $result;
	}//end Render

}//end VCExtendAddonOpenHours

new VCExtendAddonOpenHours();