<?php
// Don't load directly
if ( !defined('ABSPATH') ) { die('-1'); }

include_once ( 'vc_wtr.php' );

class VCExtendAddonCountdown extends VCExtendAddonWtr{

	public $base	= 'vc_wtr_countdown';
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
				'param_name'	=> 'version',
				'heading'		=> __( 'Version', 'wtr_sht_framework' ),
				'description'	=> __( 'Enable this option if you want to put this item on the background and make it
										more attractive', 'wtr_sht_framework' ),
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'Standard', 'wtr_sht_framework' )	=> 'wtrShtCountdownStandard',
											__( 'Light', 'wtr_sht_framework' )		=> 'wtrShtCountdownLight ',
										),
				'admin_label' 	=> true,
				'class'			=> $this->base . '_version_class',
			),

			array(
				'param_name'	=> 'year',
				'heading'		=> __( 'Set a year', 'wtr_sht_framework' ),
				'description'	=> __( 'Value must be a number', 'wtr_sht_framework' ),
				'type'			=> 'textfield',
				'value'			=> date( 'Y' ),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_year_class',
			),

			array(
				'param_name'	=> 'month',
				'heading'		=> __( 'Set a month', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'January', 'wtr_sht_framework' )	=> '0',
											__( 'February', 'wtr_sht_framework' )	=> '1',
											__( 'March', 'wtr_sht_framework' )		=> '2',
											__( 'April', 'wtr_sht_framework' )		=> '3',
											__( 'May', 'wtr_sht_framework' )		=> '4',
											__( 'June', 'wtr_sht_framework' )		=> '5',
											__( 'July', 'wtr_sht_framework' )		=> '6',
											__( 'August', 'wtr_sht_framework' )		=> '7',
											__( 'September', 'wtr_sht_framework' )	=> '8',
											__( 'October', 'wtr_sht_framework' )	=> '9',
											__( 'November', 'wtr_sht_framework' )	=> '10',
											__( 'December', 'wtr_sht_framework' )	=> '11',
										),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_month_class',
			),

			array(
				'param_name'	=> 'day',
				'heading'		=> __( 'Set a day', 'wtr_sht_framework' ),
				'description'	=> __( 'Value must be a number', 'wtr_sht_framework' ),
				'type'			=> 'textfield',
				'value'			=> date( 'd' ),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_day_class',
			),

			array(
				'param_name'	=> 'hour',
				'heading'		=> __( 'Set an hour', 'wtr_sht_framework' ),
				'description'	=> __( '<b>Format 24 hour clock</b>. Value must be a number eg. 8, 17', 'wtr_sht_framework' ),
				'type'			=> 'textfield',
				'value'			=> date( 'G' ),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_day_class',
			),

			array(
				'param_name'	=> 'minute',
				'heading'		=> __( 'Set a minute', 'wtr_sht_framework' ),
				'description'	=> __( 'Value must be a number', 'wtr_sht_framework' ),
				'type'			=> 'textfield',
				'value'			=> date( 'i' ),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_day_class',
			),

			$this->getDefaultVCfield( 'el_class' ),
		);

		vc_map( array(
			'name'			=> __( 'Countdown', 'wtr_sht_framework' ),
			'description'	=> '',
			'base'			=> $this->base,
			'class'			=> $this->base . '_div '. $this->wtrShtMainClass,
			'icon'			=> $this->base . '_icon',
			'controls'		=> 'full',
			'category'		=> $this->groupSht[ 'elements' ],
			'params'		=> $this->fields,
			'weight'		=> 33500,
			)
		);
	}//end integrateWithVC


	public function render( $atts, $content = null ){
		$result	='';
		$atts	= $this->prepareCorrectShortcode( $this->fields, $atts );
		extract($atts);

		global $post_settings;

		$result = '<div data-year="' . intval( $year ) . '" data-month="' . intval( $month ) . '" data-day="' . intval( $day ) . '" data-hour="' . intval( $hour ) . '" data-minute="' . intval( $minute ) . '" class="wtrShtCountdown '. esc_attr( $version ) . ' clearfix ' . esc_attr( $el_class ) . '">';
			$result .= '<span class="countdown-row countdown-show4">';
				$result .= '<span class="countdown-section">';
					$result .= '<span class="wrtAltFontCharacter countdown-amount">0</span>';
					$result .= '<span class="countdown-period">' . $post_settings['wtr_TranslateCountdownSHTDays'] . '</span>';
				$result .= '</span>';
				$result .= '<span class="countdown-section">';
						$result .= '<span class="wrtAltFontCharacter countdown-amount">0</span>';
						$result .= '<span class="countdown-period">' . $post_settings['wtr_TranslateCountdownSHTHours'] . '</span>';
				$result .= '</span>';
				$result .= '<span class="countdown-section">';
					$result .= '<span class="wrtAltFontCharacter countdown-amount">0</span>';
					$result .= '<span class="countdown-period">' . $post_settings['wtr_TranslateCountdownSHTMinutes'] . '</span>';
				$result .= '</span>';
				$result .= '<span class="countdown-section">';
					$result .= '<span class="wrtAltFontCharacter countdown-amount">0</span>';
					$result .= '<span class="countdown-period">' . $post_settings['wtr_TranslateCountdownSHTSeconds'] . '</span>';
				$result .= '</span>';
			$result .= '</span>';
		$result .= '</div>';

		return $result;
	}//end render

}//end VCExtendAddonCountdown

new VCExtendAddonCountdown();