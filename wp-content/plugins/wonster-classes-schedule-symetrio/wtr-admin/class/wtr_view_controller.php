<?php

include_once 'wtr_modal/view/wtr_modal_backbone.php';

if ( ! class_exists( 'WTR_Cs_view' ) ) {

	class WTR_Cs_view{

		private $days_list = array();


		//FUNCTION
		public function __construct(){
			add_action( 'wp', array( &$this, 'set_days_list' ), 20 );
		}//end __construct

		public function set_days_list(){

			global $post_settings;

			$this->days_list = array(
				$post_settings['wtr_TranslateClassesScheduleSHTMonday'],
//				__( 'Monday', 'Symetrioo' ),
				__( 'Tuesday', 'Symetrioo' ),
				__( 'Wednesday', 'Symetrioo' ),
				__( 'Thursday', 'Symetrioo' ),
				__( 'Friday', 'Symetrioo' ),
				__( 'Saturday', 'Symetrioo' ),
				__( 'Sunday', 'Symetrioo' )
			);
		} // end set_days_list


		private function prepare_calendar_data_to_display( $data ){

			$result = array();

			foreach( $data as $name => $value ){
				$result[ $name  ][ 'value' ] = esc_attr( $value[ 'value' ] );
			}

			if( '1' == $result[ 'show_event' ][ 'value' ] ){
				$result[ 'show_event_s' ][ 'value' ] = __( 'YES', 'wtr_cs_framework' );
			}else if( '0' == $result[ 'show_event' ][ 'value' ] ){
				$result[ 'show_event_s' ][ 'value' ] = __( 'NO', 'wtr_cs_framework' );
			}

			switch( $result[ 'time_format' ][ 'value' ] ){
				case '12'	: $result[ 'time_format_s' ][ 'value' ] = __( '12 AM / PM', 'wtr_cs_framework' ); break;
				case '24'	: $result[ 'time_format_s' ][ 'value' ] = __( '24 H', 'wtr_cs_framework' ); break;
			}

			switch( $result[ 'type' ][ 'value' ] ){
				case 'static'		: $result[ 'type_s' ][ 'value' ] = __( 'Static', 'wtr_cs_framework' ); break;
				case 'multi_week'	: $result[ 'type_s' ][ 'value' ] = __( 'Multi week', 'wtr_cs_framework' ); break;
			}

			return $result;
		}

		// CALENDAR FUNCTION

		public function draw_calendar_item( $id_timetable, $data ){

			$calendar = $this->prepare_calendar_data_to_display( $data );

			$result = '<tr class="stdRow wtr-data-calendar-' . intval( $id_timetable ) . '">
				<td class="class">' . stripcslashes( $calendar[ 'name' ][ 'value' ] ) . '</td>
				<td class="class">' . $calendar[ 'time_format_s' ][ 'value' ] . '</td>
				<td class="class">' . $calendar[ 'type_s' ][ 'value' ] . '</td>
				<td class="class">' . $calendar[ 'show_event_s' ][ 'value' ] . '</td>
				<td class="class">';

					if( $calendar[ 'type' ][ 'value' ] != 'static' ){

						$result .= '
						<a href="?page=wtr_classes_schedule&view=scope&id=' . intval( $id_timetable ) . '" class="wtrScopeBtn">
							<i class="fa fa-expand"></i>' .
							__( 'Scope', 'wtr_cs_framework' ) .
						'</a>';

						$extra_class = '';
					}
					else{
						$extra_class = 'wtrInstanceBtnCenter';
					}

					if( 'multi_week' == $data[ 'type' ][ 'value' ] ){
						$checkDate = '&date=' . current_time( 'Y-m-d' );
					}else{
						$checkDate = '';
					}

					$result .='
					<a href="?page=wtr_classes_schedule&view=instance&id=' . intval( $id_timetable ) . esc_attr( $checkDate ) . '" class="wtrInstanceBtn '. $extra_class .'">
						<i class="fa fa-map-marker"></i>' .
						__( 'Instance', 'wtr_cs_framework' ) .
					'</a>
				</td>
				<td class="option">
					<div class="wtrAdminCallSett clearfix">
						<span data-calendar="'. intval( $id_timetable ) .'" class="wtrAdminCalSettBtn settingBtn wtrEditCalendar">
							<i class="fa fa-cog"></i>
						</span>
						<span data-calendar="'. intval( $id_timetable ) .'" class="wtrAdminCalSettBtn deleteBtn wtrDeleteCalendar">
							<i class="fa fa-times"></i>
						</span>
					</div>
				</td>
			</tr>';

			return $result;
		}//end draw_calendar_item


		public function calendar_list_preview( $timetable ){

			$nothing_row		= '';
			wp_nonce_field( 'wtr_calendar_nonce', 'wtr_calendar_nonce' );
			echo '
			<div class="wtrCalendarHeadline clearfix">
				<h2>' . __( 'Classes schedule', 'wtr_cs_framework' ) . '</h2>
				<span class="WonButton yellow wtrAddCalendar">' . __( 'Add classes schedule', 'wtr_cs_framework' ) . '</span>
			</div>
			<div class="wtrCalendarInside wtrTimeShedule inside">
				<div class="wtrCalendarContainer">
					<div class="wtrPageOptions wtrUIContener">
						<div class="wtrPageOptionsTabsContent">
							<div class="wtrAdminCalendarTable">
								<table class="pure-table">
									<thead>
										<tr>
											<th class="class">' . __( 'Name', 'wtr_cs_framework' ) . '</th>
											<th class="class">' . __( 'Time format', 'wtr_cs_framework' ) . '</th>
											<th class="class">' . __( 'Type', 'wtr_cs_framework' ) . '</th>
											<th class="class">' . __( 'Show event', 'wtr_cs_framework' ) . '</th>
											<th class="class">' . __( 'Action', 'wtr_cs_framework' ) . '</th>
											<th class="option">' . __( 'Settings', 'wtr_cs_framework' ) . '</th>
										</tr>
									</thead>
									<tbody>';

									if( is_array( $timetable ) && count( $timetable ) ){
										$nothing_row = 'display:none;';

										foreach ( $timetable as $id_timetable => $item ) {
											echo $this->draw_calendar_item( $id_timetable, $item );
										}
									}
									else{
										$nothing_row ='';
									}

									echo '
										<tr class="stdRow stdNothingHere" style="' . $nothing_row . '">
											<td colspan="6">' . __( 'Nothing here :(', 'wtr_cs_framework' ) . '</td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="clear"></div>
						</div>
						<div class="clear"></div>
					</div>
				</div>
			</div>';
		}//end CalendarListPreview


		public static function generate_hours_public( $format, $h, $m, $format_output = 'main' ){

			$result	= '';
			$time	= array();
			$m		= intval( $m );

			if( '12' == $format ){
				$time =array(
					'0' => '12 am', '1' => '1 am', '2' => '2 am', '3' => '3 am', '4' => '4 am', '5' => '5 am', '6' => '6 am',
					'7' => '7 am', '8' => '8 am', '9' => '9 am', '10' => '10 am', '11' => '11 am', '12' => '12 pm',
					'13' => '1 pm', '14' => '2 pm', '15' => '3 pm', '16' => '4 pm', '17' => '5 pm', '18' => '6 pm',
					'19' => '7 pm', '20' => '8 pm', '21' => '9 pm', '22' => '10 pm', '23' => '11 pm',
				);

				$h = intval( $h );
				$t = explode( ' ', $time[ $h ] );
				$t[ 0 ] = intval( $t[ 0 ] );

				if( 'main' == $format_output ){
					$result ='<span>' . ( $t[ '0' ] < 10 ? '0' : '' ) . $t[ '0' ] . ':'  . ( $m < 10 ? '0' : '' ) . $m . '</span><span class="wtrAmPm">' . $t[ '1' ] . '</span>';
				}else if( 'modal' == $format_output ){
					$result = ( $t[ '0' ] < 10 ? '0' : '' ) . $t[ '0' ] . ':'  . ( $m < 10 ? '0' : '' ) . $m . ' ' . $t[ '1' ];
				}
			}else{
				$h = intval( $h );
				if( 'main' == $format_output ){
					$result = '<span>' . ( $h < 10 ? '0' : '' ) . $h . ':' . ( $m < 10 ? '0' : '' ) . $m . '</span>';
				}else if( 'modal' == $format_output ){
					$result = ( $h < 10 ? '0' : '' ) . $h . ':' . ( $m < 10 ? '0' : '' ) . $m;
				}
			}

			return $result;
		}//end generate_hours_public


		private  function draw_schedule_public_row( $time_format, $row, $modal, $calendar_type, $show_level, $clickable, $show_weekend ){

			$result	= '';
			$sday	= ( 'yes' == $show_weekend )? 7 : 5;

			//empty hour
			if( !isset( $row ) ){
				$result .= str_repeat ( '<td></td>', $sday );
			}
			//hour data
			else{
				for( $day_i = 0; $day_i < $sday; $day_i++ ){
					//empty hour in day
					if( !isset( $row[ $day_i ] ) || 0 == count( $row[ $day_i ] ) ){
						$result .= '<td></td>';
					}
					else{
						ksort( $row[ $day_i ], SORT_NUMERIC );
						$result .= '<td>';
							foreach( $row[ $day_i ] as $index => $fields ){
								$result .= $this->draw_schedule_public_item( $time_format, $fields, $modal, $calendar_type, $show_level, $clickable, $show_weekend );
							}
						$result .= '</td>';
					}
				}
			}

			return $result;
		}//end draw_schedule_public_row


		private function draw_schedule_public_item ( $time_format, $data, $modal, $calendar_type, $show_level, $clickable, $show_weekend ){

			$category_str = '';
			if( isset( $data[ 'detal_classes' ][ 'term' ] ) ){
				foreach( $data[ 'detal_classes' ][ 'term' ] as $cat ){
					$category_str .= ' wtr-cat-' . $cat;
				}
			}

			if( 'class' == $data[ 'type_data' ]){
				if( 'no' == $modal ){
					$result = '<div class="wtrShtTimeTableFitnessEntry wtrShtTimeTableFitnessEntryClass wtr-class-' . intval( $data[ 'id_classes' ][ 'value' ] ) . ' ' . esc_attr( $category_str ) . '" style="background-color: ' . esc_attr( $data[ 'detal_classes' ][ 'meta' ][ '_wtr_classes_bg_color' ] ) . '; color: ' . esc_attr( $data[ 'detal_classes' ][ 'meta' ][ '_wtr_classes_font_color' ] ) . ';">';
						$result .= '<div class="wtrShtTimeTableEntryColor"></div>';

						if( 'no' == $clickable ){
							$result .= '<span class=" wrtAltFontCharacter">' . $data[ 'detal_classes' ][ 'post_title' ] . '</span>';
						}else{
							$result .= '<a href="' . get_permalink( intval( $data[ 'id_classes' ][ 'value' ] ) ) . '" class="wtrShtTimeTableEntryName wrtAltFontCharacter">';
								$result .= $data[ 'detal_classes' ][ 'post_title' ];
							$result .= '</a>';
						}

						$result .= '<div class="wtrShtTimeTableEntryTimePeriod clearfix">';
							$result .= '<div class="wtrShtTimeTableFrom">';
								$result .= $this->generate_hours_public( $time_format, $data[ 'time_hour_start' ][ 'value' ], $data[ 'time_minute_start' ][ 'value' ] );
							$result .= '</div>';
							$result .= '<div class="wtrShtTimeTableSeparator">';
								$result .= '<span> - </span>';
							$result .= '</div>';
							$result .= '<div class="wtrShtTimeTableTo">';
								$result .= $this->generate_hours_public( $time_format, $data[ 'time_hour_end' ][ 'value' ], $data[ 'time_minute_end' ][ 'value' ] );
							$result .= '</div>';
						$result .= '</div>';

						if( count( $data[ 'trainers' ] ) ){
							if( 'no' == $clickable ){
								foreach( $data[ 'trainers' ] as $id_trainer => $data_trainer ){
									$result .= '<span class="wtrShtTimeTableEntryTrainerNoLink">';
										$result .= $data_trainer[ 'name' ];
									$result .= '</span>';
								}
							}else{
								foreach( $data[ 'trainers' ] as $id_trainer => $data_trainer ){
									$result .= '<a href="' . get_permalink( intval( $id_trainer ) ) . '" class="wtrShtTimeTableEntryTrainer">';
										$result .= $data_trainer[ 'name' ];
									$result .= '</a>';
								}
							}
						}

						if( count( $data[ 'detal_room' ] ) ){
							if( 'no' == $clickable ){
								$result .= '<span class="wtrShtTimeTableEntryRoomNoLink">';
									$result .= $data[ 'detal_room' ][ 'name' ];
								$result .= '</span>';
							}else{
								$result .= '<a href="' . get_permalink( intval( $data[ 'id_room' ][ 'value' ] ) ) . '" class="wtrShtTimeTableEntryRoom">';
									$result .= $data[ 'detal_room' ][ 'name' ];
								$result .= '</a>';
							}
						}
					$result .= '</div>';
				}else if( 'yes' == $modal ){
					$result = '<div class="wtrShtTimeTableFitnessEntry wtrShtTimeTableFitnessEntryClass wtr-class-' . intval( $data[ 'id_classes' ][ 'value' ] ) . ' ' . $category_str . '" style="background-color: ' . esc_attr( $data[ 'detal_classes' ][ 'meta' ][ '_wtr_classes_bg_color' ] ) . '; color: ' . esc_attr( $data[ 'detal_classes' ][ 'meta' ][ '_wtr_classes_font_color' ] ) . ';">';
						$result .= '<a href="#modal" data-time="'. esc_attr( $time_format ) .'" data-level="' . $show_level . '" data-class="' . esc_attr( $data[ 'id_classes' ][ 'value' ] ) . '" data-idx="' . esc_attr( $data[ 'id_row' ] ) . '" data-type="' . esc_attr( $calendar_type ) . '" class="wtrNoModalDetail wtrClassDetails"></a>';
							$result .= '<div class="wtrShtTimeTableEntryColor"></div>';
							$result .= '<span class="wtrShtTimeTableEntryName wrtAltFontCharacter">';
								$result .= $data[ 'detal_classes' ][ 'post_title' ];
							$result .= '</span>';
							$result .= '<div class="wtrShtTimeTableEntryTimePeriod clearfix">';
								$result .= '<div class="wtrShtTimeTableFrom">';
									$result .= $this->generate_hours_public( $time_format, $data[ 'time_hour_start' ][ 'value' ], $data[ 'time_minute_start' ][ 'value' ] );
								$result .= '</div>';
								$result .= '<div class="wtrShtTimeTableSeparator">';
									$result .= '<span> - </span>';
								$result .= '</div>';
								$result .= '<div class="wtrShtTimeTableTo">';
									$result .= $this->generate_hours_public( $time_format, $data[ 'time_hour_end' ][ 'value' ], $data[ 'time_minute_end' ][ 'value' ] );
								$result .= '</div>';
							$result .= '</div>';

							if( count( $data[ 'trainers' ] ) ){
								foreach( $data[ 'trainers' ] as $id_trainer => $data_trainer ){
									$result .= '<span class="wtrShtTimeTableEntryTrainer">';
										$result .= $data_trainer[ 'name' ];
									$result .= '</span>';
								}
							}

					$result .= '</div>';
				}
			}else if( 'event' == $data[ 'type_data' ]){
				$result = '<div class="wtrShtTimeTableFitnessEntry wtrShtTimeTableEvent">';
					$result .= '<a href="' . get_permalink( intval( $data[ 'id_event' ] ) ) . '"  class="wtrNoModalDetail"></a>';
					$result .= '<div class="wtrShtTimeTableEntryColor" style="background-color: #1fce6d;"></div>';
					$result .= '<div class="wtrShtTimeTableEventHeadline"><i class="fa fa-star"></i> ' . __('EVENT', 'wtr_cs_framework' ) . '</div>';
					$result .= '<span class="wtrShtTimeTableEntryName wrtAltFontCharacter">' . $data[ 'title' ] . '</span>';
					$result .= '<div class="wtrShtTimeTableEntryTimePeriod clearfix">';
						$result .= '<div class="wtrShtTimeTableFrom">';
							$result .= $this->generate_hours_public( $time_format, $data[ 'h_start' ], intval( $data[ '_wtr_event_time_start_m' ] ) );
						$result .= '</div>';
						$result .= '<div class="wtrShtTimeTableSeparator">';
							$result .= '<span> - </span>';
						$result .= '</div>';
						$result .= '<div class="wtrShtTimeTableTo">';
							$result .= $this->generate_hours_public( $time_format, $data[ 'h_end' ], intval( $data[ '_wtr_event_time_end_m' ] ) );
						$result .= '</div>';
					$result .= '</div>';
				$result .= '</div>';
			}

			return $result;
		}// end draw_schedule_public_item


		public function draw_calendar_in_public( $calendar_data, $style, $id, $modal, $scope, $pdf, $pdf_url, $show_level, $empty_hours, $id_class, $clickable, $show_weekend ){

			global $post_settings;

			if( 0 == $id ){
				wp_nonce_field( 'wtr_calendar_public_nonce', 'wtr_calendar_public_nonce' );
			}

			$result = '<div class="wtrShtTimeTable ' . esc_attr( $style ) . ' wtrShtTimeTableIdx-' . esc_attr( $id ) . '">';
				$result .= '<div class="wtrShtDesktopTimeTable">';
					$result .= '<div class="wtrShtTimeTableHeadline clearfix">';

					if( 'multi_week' == $calendar_data[ 'type' ] ){
						global $wtr_date_format;
						$date_format = get_option( 'wtr_classes_schedule_date_format' );
						$date_format = $wtr_date_format[$date_format];

						reset( $scope[ 'days' ] );
						$start = key( $scope[ 'days' ] );
						$start = date_i18n( $date_format[ 'all' ], strtotime( $start ) );

						end( $scope[ 'days' ] );
						$end = key( $scope[ 'days' ] );
						$end = date_i18n( $date_format[ 'all' ], strtotime( $end ) );

						$result .= '<div class="wtrShtTimeTableHeadlineLeft">';
							$result .= '<span data-filter="" data-direction="prev" data-clickable="' . $clickable . '" data-showweekend="' . $show_weekend . '" data-idclass="'. esc_attr( $id_class ) .'"  data-hours="'. esc_attr( $empty_hours ) .'" data-level="'. esc_attr( $show_level ) .'" data-modal="'. esc_attr( $modal ) .'" data-calendar="'. esc_attr( $calendar_data[ 'id_timetable' ] ) .'" class="wtrShtTimeTableBtn wtrShtTimeTableBtnPrev wtrscheduleTimeGo">';
								$result .= '<i class="fa fa-chevron-left"></i>';
							$result .= '</span>';
							$result .= '<span class="wtrShtTimeTableHeadlinePeriod">';
								$result .= '<span class="wtrScheduleTimePickerStart">' . $start . '</span> <span class="wtrScheduleTimePickerSeparator">-</span> <span class="wtrScheduleTimePickerEnd">' . $end . '</span>';
							$result .= '</span>';
							$result .= '<span data-filter="" data-direction="next" data-clickable="' . $clickable . '" data-showweekend="' . $show_weekend . '" data-idclass="'. esc_attr( $id_class ) .'" data-hours="'. esc_attr( $empty_hours ) .'" data-level="'. esc_attr( $show_level ) .'" data-modal="'. esc_attr( $modal ) .'" data-calendar="'. esc_attr( $calendar_data[ 'id_timetable' ] ) .'" class="wtrShtTimeTableBtn wtrShtTimeTableBtnNext wtrscheduleTimeGo">';
								$result .= '<i class="fa fa-chevron-right"></i>';
							$result .= '</span>';
						$result .= '</div>';
					}

					if( count( $calendar_data[ 'instance_public' ] ) ){
						$result .= '<div class="wtrShtTimeTableHeadlineRight clearfix">';

							if( 'yes' == $pdf ){
								$result .= '<a target="_blank" href="' . esc_url( $pdf_url ) . '" class="wtrShtTimeTableBtn wtrRadius3 wtrTimetablePdf">';
									$result .= __( 'PDF', 'wtr_cs_framework' );
								$result .= '</a>';
							}

							if( 'wtr_all_items' == $id_class ){
								$result .= '<span class="wtrShtTimeTableBtn wtrRadius3 wtrTimetableFilterDataAll">';
									$result .= __( 'Show all', 'Symetrioo' );
								$result .= '</span>';
								$result .= '<a href="#modal" data-idx="'. esc_attr( $id ) .'" data-calendar="' . esc_attr( $calendar_data[ 'id_timetable' ] ) . '" data-type="' . esc_attr( $calendar_data[ 'type' ] ) . '" class="wtrShtTimeTableBtn wtrShtTimeTableBtnClasses wtrRadius3 wtrClassFilter">';
									$result .= '<i class="fa fa-th"></i>' . __( 'Select classes', 'Symetrioo' );
								$result .= '</a>';
							}
						$result .= '</div>';
					}

					$result .= '</div>';
					$result .= '<div class="wtrShtTimeTableContainer">';

					//overlay
					if( 'multi_week' == $calendar_data[ 'type' ] ){
						$result .= '<div class="wtrShtTimeTableLoadOverlay" style="display:none;">';
							$result .= '<div class="wtrShtCallLoader">';
								$result .= '<div class="wtrRect1"></div>';
								$result .= '<div class="wtrRect2"></div>';
								$result .= '<div class="wtrRect3"></div>';
								$result .= '<div class="wtrRect4"></div>';
								$result .= '<div class="wtrRect5"></div>';
							$result .= '</div>';
						$result .= '</div>';
					}

					$result .= $this->draw_calendar_in_public_table( $calendar_data, $modal, $show_level, $empty_hours, $clickable, $show_weekend );

					$result .= '</div>';
				$result .= '</div>';
			$result .= '</div>';

			echo $result;
		}//end draw_calendar_in_public


		public function draw_calendar_in_public_table( $calendar_data, $modal, $show_level, $empty_hours, $clickable, $show_weekend ){

			global $post_settings;

			$result = '<table class="wtrShtTimeTableItem">';
				$result .= '<thead>';
					$result .= '<tr>';
						$result .= '<th style="width:200px !important;"><span class="wtrShtTimeTableHead">' . __( 'Time / Day', 'Symetrioo' ) . '</span></th>';
						$result .= '<th><span class="wtrShtTimeTableDay">' . $this->days_list[ 0 ] . '</span></th>';
						$result .= '<th><span class="wtrShtTimeTableDay">' . $this->days_list[ 1 ] . '</span></th>';
						$result .= '<th><span class="wtrShtTimeTableDay">' . $this->days_list[ 2 ] . '</span></th>';
						$result .= '<th><span class="wtrShtTimeTableDay">' . $this->days_list[ 3 ] . '</span></th>';
						$result .= '<th><span class="wtrShtTimeTableDay">' . $this->days_list[ 4 ] . '</span></th>';

						if( 'yes' == $show_weekend ){
							$result .= '<th><span class="wtrShtTimeTableDay">' . $this->days_list[ 5 ] . '</span></th>';
							$result .= '<th><span class="wtrShtTimeTableDay">' . $this->days_list[ 6 ] . '</span></th>';
						}

					$result .= '</tr>';
				$result .= '</thead>';
				$result .= '<tbody>';

				//empty calendar
				if( !count( $calendar_data[ 'instance_public' ] ) ){
					$result .= '<tr class="wtrShtTimeTableNoResults">';
						$result .= '<td colspan="8" >';
							$result .= '<div class="wtrShtTimeTableNoResultsHeadline">' . __( 'Sorry, no results in selected week', 'Symetrioo' )  . '</div>';
						$result .= '</td>';
					$result .= '</tr>';
				}

				//calendar data
				else{
					reset( $calendar_data[ 'instance_public' ] );
					$hour_start = key( $calendar_data[ 'instance_public' ] );

					end( $calendar_data[ 'instance_public' ] );
					$hour_end = key( $calendar_data[ 'instance_public' ] );
					reset( $calendar_data[ 'instance_public' ] );

					for( $hour_i = $hour_start; $hour_i <= $hour_end; $hour_i++ ){

						$data_h = ( isset( $calendar_data[ 'instance_public' ][ $hour_i ] ) )? $calendar_data[ 'instance_public' ][ $hour_i ] : array();

						if( 0 == count( $data_h ) &&  'yes' == $empty_hours ){}
						else{
							$result .= '<tr>';
								$result .= '<td class="wtrShtTimeTableEntryTimeHolder">';
									$result .= '<div class="wtrShtTimeTableEntryTime clearfix">';
										$result .= '<div class="wtrShtTimeTableFrom">';
											$result .= $this->generate_hours_public( $calendar_data[ 'time_format' ], $hour_i, '0' );
										$result .= '</div>';
										$result .= '<div class="wtrShtTimeTableSeparator">';
											$result .= '<span> - </span>';
										$result .= '</div>';
										$result .= '<div class="wtrShtTimeTableTo">';
											$result .= $this->generate_hours_public( $calendar_data[ 'time_format' ], ( $hour_i + 1 ), '0' );
										$result .= '</div>';
									$result .= '</div>';
								$result .= '</td>';

								$result .= $this->draw_schedule_public_row(
									$calendar_data[ 'time_format' ],
									$data_h,
									$modal,
									$calendar_data[ 'type' ],
									$show_level,
									$clickable,
									$show_weekend
								);

							$result .= '</tr>';
						}
					}
				}

				$result .= '</tbody>';
			$result .= '</table>';

			return $result;
		}//end draw_calendar_in_public_table


		public function draw_calendar_in_public_mobile( $calendar_data, $id, $scope = null ){
			$result ='<div class="wtrShtMobileTimeTable">';
				$result .='<ul class="wtrShtMobileTimeTableList">';

				if( isset( $calendar_data[ 'instance_public_mobile' ] ) && count( $calendar_data[ 'instance_public_mobile' ] ) ){
					for( $i = 0; $i < 7; $i++ ){
						if( isset( $calendar_data[ 'instance_public_mobile' ][ $i ] ) ){

							$result .='<li class="wtrShtMobileTimeTableItem">';
								$result .='<div class="wtrShtMobileTimeTableHeadline clearfix">';
									$result .='<h4>' . $this->days_list[ $i ] . '</h4>';
									if( 'multi_week' == $calendar_data[ 'type' ] ){
										$result .='<span>' . $scope[ 'days_f' ][ $i ] . '</span>';
									}
								$result .='</div>';
								$result .='<ul class="wtrShtMobileTimeTableDaylyPlan">';

								foreach( $calendar_data[ 'instance_public_mobile' ][ $i ] as $day_data ){
									ksort( $day_data );

									foreach( $day_data as $data_x ){
										if( 'class' == $data_x[ 'type_data' ] ){
											$result .='<li class="wtrShtMobileTimeTableDaylyPlanTime">';
												$result .='<a href="' . get_permalink( intval( $data_x[ 'id_classes' ][ 'value' ] ) ) . '" class="wtrShtMobileTimeTableClass">';
													$result .='<div class="wtrShtMobileTimeTableClassName">' . $data_x[ 'detal_classes' ][ 'post_title' ] . '</div>';
													$result .='<div class="wtrShtMobileTimeTableClassTime">';
														$result .= $this->generate_hours_public( $calendar_data[ 'time_format' ], $data_x[ 'time_hour_start' ][ 'value' ], $data_x[ 'time_minute_start' ][ 'value' ], 'modal' );
															$result .= ' - ';
														$result .= $this->generate_hours_public( $calendar_data[ 'time_format' ], $data_x[ 'time_hour_end' ][ 'value' ], $data_x[ 'time_minute_end' ][ 'value' ], 'modal' );
													$result .= '</div>';
												$result .='</a>';
											$result .='</li>';
										}
										else{
											$result .='<li class="wtrShtMobileTimeTableDaylyPlanTime">';
												$result .='<a href="' . get_permalink( intval( $data_x[ 'id_event' ] ) ) . '" class="wtrShtMobileTimeTableClass">';
													$result .='<div class="wtrShtMobileTimeTableEventHeadline"><i class="fa fa-star"></i>' . __( 'Event', 'wtr_cs_framework' ) . '</div>';
													$result .='<div class="wtrShtMobileTimeTableClassName">' . $data_x[ 'title' ] . '</div>';
													$result .='<div class="wtrShtMobileTimeTableClassTime">';
														$result .= $this->generate_hours_public( $calendar_data[ 'time_format' ], $data_x[ 'h_end' ], intval( $data_x[ '_wtr_event_time_end_m' ] ) );
															$result .= ' - ';
														$result .= $this->generate_hours_public( $calendar_data[ 'time_format' ], $data_x[ 'h_end' ], intval( $data_x[ '_wtr_event_time_end_m' ] ) );
													$result .= '</div>';
												$result .='</a>';
											$result .='</li>';
										}
									}
								}
								$result .='</ul>';
							$result .='</li>';
						}
					}
				}else{
					$result .='<li class="wtrShtMobileTimeTableNoResults">';
						$result .= __( 'Sorry, no results in selected week', 'wtr_cs_framework' );
					$result .='</li>';
				}
				$result .='</ul>';
			$result .='</div>';

			echo $result;
		}//end draw_calendar_in_public_mobile


		public function draw_calendar_daily_in_public( $calendar_data, $el_class, $show_level ){
			global $post_settings;

			$date_c = get_the_time('d M Y', current_time( 'timestamp' ));
			$date_n = current_time( 'N' );

			$result = '<div class="wtrSht wtrShtFullWidthSection ' . esc_attr( $el_class ). '" >';
				$result .= '<div class="wtrDailySchedule clearfix">';

					$result .= '<div class="wtrDailyScheduleHeadlineColumn">';
						$result .= '<div class="wtrDailyScheduleHeadlineMeta">';
							$result .= '<div class="wtrDailyScheduleName wrtAltFontCharacter">' . __( 'Symetrioo', 'Symetrioo' ) . '</div>';
							$result .= '<div class="wtrDailyScheduleHeadline">' . __( 'Daily schedule', 'Symetrioo' ) . '</div>';
							$result .= '<div class="wtrDailyScheduleHeadlineDate ">' . $date_c . '</div>';
						$result .= '</div>';

						if( isset( $calendar_data[ 'instance_public_mobile' ][ $date_n - 1 ] ) && 4 < count( $calendar_data['instance_admin'][ $date_n - 1 ] ) ){
							$result .= '<ul class="wtrDSNavigation clearfix">';
								$result .= '<li class="wtrDSPrev">';
									$result .= '<i class="fa fa-chevron-left"></i>';
								 $result .= '</li>';
								$result .= '<li class="wtrDSNext">';
									$result .= '<i class="fa fa-chevron-right"></i>';
								$result .= '</li>';
							$result .= '</ul>';
						}

					$result .= '</div>';
					$result .= '<div class="wtrDailyScheduleRotatorColumn">';
					if( count( $calendar_data[ 'instance_public_mobile' ] ) ){

							$result .= '<div class="wtrDailyScheduleRotator clearfix">';

							foreach( $calendar_data[ 'instance_public_mobile' ][ $date_n - 1 ] as $hour => $idx_data ){
								foreach( $idx_data as $item ){

									if( 'class' == $item[ 'type_data' ] ){

										$id_img		= get_post_thumbnail_id( $item[ 'id_classes' ][ 'value' ] );
										$img_src	= wp_get_attachment_image_src( $id_img, 'size_2' );

										$result .= '<div class="wtrDSItem" style="background-image: url(\''. $img_src[ 0 ] .'\')">';
											$result .= '<div class="wtrDSItemContainer">';
												$result .= '<div class="wtrDSItemNameAttr" style="background-color: ' . esc_attr( $item[ 'detal_classes' ][ 'meta' ][ '_wtr_classes_bg_color' ] ) . ';"></div>';
												$result .= '<a href="' . get_permalink( intval( $item[ 'id_classes' ][ 'value' ] ) ) . '" class="wtrDSItemLink" ></a>';
												$result .= '<div class="wtrDSItemTime">' . $this->generate_hours_public( $calendar_data[ 'time_format' ], $item[ 'time_hour_start' ][ 'value' ], $item[ 'time_minute_start' ][ 'value' ] );
												$result .= ' - ';
												$result .= $this->generate_hours_public( $calendar_data[ 'time_format' ], $item[ 'time_hour_end' ][ 'value' ], $item[ 'time_minute_end' ][ 'value' ] ) . '</div>';
												$result .= '<div class="wtrDSItemTrainer"></div>';
												$result .= '<h3 class="wtrDSItemName">' . $item[ 'detal_classes' ][ 'post_title' ] . '</h3>';
												$result .= '<ul class="wtrDSItemTrainer">';

													foreach( $item[ 'trainers' ] as $id_trainer => $data_trainer ){
														$result .= '<li>';
															$result .= $data_trainer[ 'name' ];
														$result .= '</li>';
													}

												$result .= '</ul>';

												if( 'no' == $show_level ){
													$result .= '<ul class="wtrDSItemSkill wtrShtBoxedClassesSkill wtrRadius100 clearfix">';
														$result .= wtr_helper_classes_skill_dot( $item[ 'detal_classes' ][ 'meta' ][ '_wtr_classes_lvl' ] );
													$result .= '</ul>';
												}

											$result .= '</div>';
										$result .= '</div>';

									}else if( 'event' == $item[ 'type_data' ] ){

										$id_img		= get_post_thumbnail_id( $item[ 'id_event' ] );
										$img_src	= wp_get_attachment_image_src( $id_img, 'size_2' );

										$result .= '<div class="wtrDSItem wtrDSEventItem" style="background-image: url(\''. $img_src[ 0 ] .'\')">';
											$result .= '<div class="wtrDSItemContainer">';
												$result .= '<a href="" class="wtrDSItemLink" ></a>';
												$result .= '<div class="wtrDSItemTime">';
													$result .= $this->generate_hours_public( $calendar_data[ 'time_format' ], $item[ 'h_start' ], intval( $item[ '_wtr_event_time_start_m' ] ) );
													$result .= ' - ';
													$result .= $this->generate_hours_public( $calendar_data[ 'time_format' ], $item[ 'h_end' ], intval( $item[ '_wtr_event_time_end_m' ] ) );
												$result .= '</div>';
												$result .= '<div class="wtrDSItemTrainer"></div>';
												$result .= '<h3 class="wtrDSItemName">' . $item[ 'title' ] . '</h3>';
												$result .= '<div class="wtrDSItemCategory">';
													$result .= '<i class="fa fa-map-marker"></i>';
													$result .= '<span>' . __( 'Event', 'wtr_cs_framework' ) . '</span>';
												$result .= '</div>';
											$result .= '</div>';
										$result .= '</div>';

									}
								}
							}

							$result .= '</div>';

					}else{
						$result .= '<h6 class="wtrShtDSNoResults">' . __( 'No results for today', 'wtr_cs_framework' ) . '</h6>';
					}
					$result .= '</div>';
				$result .= '</div>';
			$result .= '</div>';

			echo $result;
		}//end draw_calendar_daily_in_public


		public function draw_alert_info_wrong_data_id(){

			$result = '<div class="wtrNotification red wtrShtAlignLeft ">';
				$result .= __( '<strong>Wonster Classes Schedule - Symetrio Edition:</strong> There is no such data to generate this shortcode', 'wtr_cs_framework' );
			$result .= '</div>';

			return $result;
		}//end draw_alert_info_wrong_data_id


		public function draw_alert_info_wrong_data_id_schedule( $type ){

			$result = '<div class="wtrNotification red wtrShtAlignLeft ">';
				$result .= __( 'Please, go back to Visual Composer, edit <strong>"' . $type . '"</strong> shortcode and select desired item from select box.', 'wtr_cs_framework' );
			$result .= '</div>';

			return $result;
		}//end draw_alert_info_wrong_data_id_schedule


		public function draw_filter_calendar_classes_public( $id_calendar, $data, $idx ){

			global $post_settings;

			$categoryC = count( $data[ 'category' ] );

			$category_c = '';
			foreach( $data[ 'category' ] as $id => $name ){
				$category_c .= '<li class="wtrTimeTableModalListItem wtrTimetableFilterData" data-idx="' . esc_attr( $idx ) . '" data-filter="wtr-cat-' . esc_attr( $id ) . '">';
					$category_c .= '<div class="wtrTimeTableClassesCategory">' .  $name ;
					$category_c .= '<span>' . __( 'Category', 'Symetrioo' ) . '</span></div>';
				$category_c .= '</li>';
			}

			$classes_c = '';
			foreach( $data[ 'classes' ] as $id => $name ){
				$classes_c .= '<li class="wtrTimeTableModalListItem wtrTimetableFilterData" data-idx="' . esc_attr( $idx ) . '"  data-filter="wtr-class-' . esc_attr( $id ) . '">';
					$classes_c .= '<div class="wtrTimeTableClasses">' .  $name ;
					$classes_c .= '<span>' . __( 'Class', 'Symetrioo' ) . '</span></div>';
				$classes_c .= '</li>';
			}


			$result = '<div class="wtrTimeTableModalContainer">';
				$result .= '<div class="wtrTimeTableModalHeader">';
					$result .= '<span class="wtrTimeTableModalClose close"></span>';
					$result .= '<h4>' . __( 'Select classes', 'Symetrioo' ) . '</h4>';
				$result .= '</div>';
				$result .= '<div class="wtrTimeTableModalTabs clearfix">';
					$result .= '<ul class="wtrTimeTableModalTabsList resp-tabs-list clearfix">';
						$result .= '<li class="wtrTimeTableModalTabsListItem">' . __( 'Show all', 'Symetrioo' ) . '</li>';

						if( $categoryC ){
							$result .= '<li class="wtrTimeTableModalTabsListItem">' . __( 'Categories', 'Symetrioo' ) . '</li>';
							$result .= '<li class="wtrTimeTableModalTabsListItem">' . __( 'Classes', 'Symetrioo' ) . '</li>';
						}

					$result .= '</ul>';
					$result .= '<div class="wtrTimeTableModalTabsContainer resp-tabs-container">';
						$result .= '<div class="wtrTimeTableModalTabItem wtrTabAnimation">';
								$result .= '<div class="wtrTimeTableModalContainer">';
									$result .= '<ul class="wtrTimeTableModalList clearfix">';
									$result .= $category_c;
									$result .= $classes_c;
									$result .= '</ul>';
								$result .= '</div>';
						$result .= '</div>';

						if( $categoryC ){
							$result .= '<div class="wtrTimeTableModalTabItem wtrTabAnimation" style="display:none">';
								$result .= '<div class="wtrTimeTableModalContainer">';
									$result .= '<ul class="wtrTimeTableModalList clearfix">';
									$result .= $category_c;
									$result .= '</ul>';
								$result .= '</div>';
							$result .= '</div>';
							$result .= '<div class="wtrTimeTableModalTabItem wtrTabAnimation"  style="display:none">';
								$result .= '<div class="wtrTimeTableModalContainer">';
									$result .= '<ul class="wtrTimeTableModalList clearfix">';
									$result .= $classes_c;
									$result .= '</ul>';
								$result .= '</div>';
							$result .= '</div>';
						}

					$result .= '</div>';
				$result .= '</div>';
			$result .= '</div>';

			echo $result;
		}//end draw_filter_calendar_classes_public


		public function draw_calendar_item_public( $data, $time_format, $show_level ){

			global $wtr_date_format;

			$google_dates			= date("Ymd\\THi00", $data[ 'timetable_info' ][ 'start_time' ] ) . '/' . date("Ymd\\THi00", $data[ 'timetable_info' ][ 'end_time' ] );
			$google_calendar_url	= esc_url( 'https://www.google.com/calendar/render?action=TEMPLATE&text=' . urlencode( $data[ 'post' ][ 'post_title' ] ) . '&dates=' . $google_dates . '&pli=1' );

			$date_format = get_option( 'wtr_classes_schedule_date_format' );
			$date_format = $wtr_date_format[$date_format];

			if( 'static' == $data[ 'timetable_info' ][ 'class_date' ] ){
				$m_data_x = '';
			}else{
				$m_data_x = ' (' . date_i18n( $date_format[ 'all' ], strtotime( $data[ 'timetable_info' ][ 'class_date' ] ) ) . ')';
			}

			$result = '<div class="wtrTimeTableModalContainer">';
				$result .= '<div class="wtrTimeTableModalHeader">';
					$result .= '<span class="wtrTimeTableModalClose close"></span>';
					$result .= '<div>';
						$result .= '<h4>' . $data[ 'post' ][ 'post_title' ] . $m_data_x . '</h4>';
					$result .= '</div>';
					$result .= '<div class="wtrTimeTableModalClassClockTime">';
						$result .= '<a class="wtrGoogleModal" target="_blank" href="' . $google_calendar_url . '"><i class="fa fa-google"></i></a>';
						$result .= '<i class="fa fa-clock-o"></i>';
						$result .='<span class="wtrScheduleTableClockInfo">';
							$result .= $this->generate_hours_public( $time_format, $data[ 'timetable_info' ][ 'time_hour_start' ][ 'value' ], $data[ 'timetable_info' ][ 'time_minute_start' ][ 'value' ], 'modal' );
								$result .= ' - ';
							$result .= $this->generate_hours_public( $time_format, $data[ 'timetable_info' ][ 'time_hour_end' ][ 'value' ], $data[ 'timetable_info' ][ 'time_minute_end' ][ 'value' ], 'modal' );
						$result .= '</span>';
					$result .= '</div>';
				$result .= '</div>';
				$result .= '<div class="wtrClassDetailsModalContainer wtrModalNoDesc clearfix">';
					$result .= '<div class="wtrClassDetailsModalMeta clearfix">';
						$result .= '<div class="wtrClassDetailsModalMetaContainer">';

							if( 'no' == $show_level ){
								$result .= '<div class="wtrClassDetailsModalMetaItem wtrClassDetailsModalMetaItemXSmall">';
									$result .= '<div class="wtrClassDetailsModalMetaHeadline">';
										$result .=  __( 'Skill', 'wtr_cs_framework' );
									$result .= '</div>';
									$result .= '<ul class="wtrShtBoxedClassesSkill clearfix wtrRadius100">';
										$result .= wtr_helper_classes_skill_dot( $data[ 'meta' ][ '_wtr_classes_lvl' ][0] );
									$result .= '</ul>';
								$result .= '</div>';
							}

							$result .= '<div class="wtrClassDetailsModalMetaItem wtrClassDetailsModalMetaItemSmall">';
								$result .= '<div class="wtrClassDetailsModalMetaHeadline">';
									$result .= __( 'Time', 'wtr_cs_framework' );
								$result .= '</div>';
								$result .= '<div class="wtrClassDetailsModalMetaHeadlineExSmall">' . $data[ 'timetable_info' ][ 'time_duration' ] . ' ' . __( 'min', 'wtr_cs_framework' ) . '</div>';
							$result .= '</div>';
							$result .= '<div class="wtrClassDetailsModalMetaItem wtrClassDetailsModalMetaItemMedium">';
								$result .= '<div class="wtrClassDetailsModalMetaHeadline">';
									$result .= __( 'Trainers', 'wtr_cs_framework' );
								$result .= '</div>';
								$result .= '<div class="wtrClassDetailsModalMetaHeadlineEx">';

									if( isset( $data[ 'timetable_info' ][ 'txt_trainers' ] ) ){
										foreach( $data[ 'timetable_info' ][ 'txt_trainers' ] as $id_trainer => $name ){
											$result .= '<a href="' . get_permalink( intval( $id_trainer ) ) . '">' . $name  . '</a>';
										}
									}

								$result .= '</div>';
							$result .= '</div>';
							$result .= '<div class="wtrClassDetailsModalMetaItem">';
								$result .= '<div class="wtrClassDetailsModalMetaHeadline">';
									$result .= __( 'Room', 'wtr_cs_framework' );
								$result .= '</div>';
								$result .= '<div class="wtrClassDetailsModalMetaHeadlineEx">';
									$result .= '<a href="' . get_permalink( intval( $data[ 'timetable_info' ][ 'id_room' ]['value'] ) ) . '">' . $data[ 'timetable_info' ][ 'txt_id_room' ]. '</a>';
								$result .= '</div>';
							$result .= '</div>';
							$result .= '<div class="wtrClassDetailsModalMetaItem">';
								$result .= '<div class="wtrClassDetailsModalMetaHeadline">';
									$result .= __( 'Limit', 'wtr_cs_framework' );
								$result .= '</div>';
								$result .= '<div class="wtrClassDetailsModalMetaHeadlineEx">' . $data[ 'timetable_info' ][ 'participants' ][ 'value' ] . '</div>';
							$result .= '</div>';
						$result .= '</div>';

						if( strlen( trim( $data[ 'timetable_info' ][ 'desc' ][ 'value' ] ) ) ){
							$result .= '<div class="wtrClassDetailsModalMetaItemDesc">';
								$result .= '<div class="wtrClassDetailsModalMetaHeadline">';
									$result .= __( 'Additional text', 'wtr_cs_framework' );
								$result .= '</div>';
								$result .= '<p>';
									$result .= $data[ 'timetable_info' ][ 'desc' ][ 'value' ];
								$result .= '</p>';
							$result .= '</div>';
						}

						$result .= '<div class="wtrClassDetailsModalMetaItemReadMore">';
							$result .= '<a href="' . get_permalink( intval( $data[ 'post' ]['ID'] ) ) . '" class="wtrClassDetailsModalClassBtn wtrRadius3">' . __( 'Read more', 'wtr_cs_framework' ) . '</a>';
						$result .= '</div>';
					$result .= '</div>';
				$result .= '</div>';
			$result .= '</div>';

			echo $result;
		}//end draw_calendar_item_public

		// SCOPE FUNCTION

		private function gen_hours_overview( $format, $hour, $minutes ){

			$result;

			if( '12' == $format ){
				$hour_d				= WTR_Modal_Backbone::generateHours( $format );
				$h					= explode( ' ', $hour_d[ $hour[ 'value' ] ] );
				$hour[ 'value' ]	= $h[ 0 ];

				$result	= $this->check_data_flag( $hour ) . ':' . $this->check_data_flag( $minutes ) . ' ' . $h[ 1 ];
			}else if( '24' == $format ){
				$result = $this->check_data_flag( $hour ) . ':' . $this->check_data_flag( $minutes );
			}

			return $result;
		}//end gen_hours_overview


		public function scope_data_switcher( $scope_list, $rande_data ){

			$result			= '';
			$scope_list_c	= count( $scope_list );

			echo '
			<div class="wtrPageOptionsDatePick clearfix">
				<div class="wtrPageOptionsDateSlider clearfix">
					<div class="wtrPageOptionsDateSelector">
						<i class="fa fa-calendar wtrDatepickerIco wtrInstanceFilterButton"></i>
					</div>
					<div class="wtrPageOptionsDateEmiter">
						<div class="wtrPageOptionsDateEmiterHeadline wtrInstanceFilterButton">' . esc_attr( $_GET[ 'date' ] ) . '</div>
						<input id="wtrFilterScopeInstanceDatePicker" data-rande-start=" ' . esc_attr( $rande_data[ 'year_start' ] ) . ' " data-rande-end="' . esc_attr( $rande_data[ 'year_end' ] ) . '" data-date-start="' . esc_attr( $rande_data[ 'start' ] ) . '" data-date-end="' . esc_attr( $rande_data[ 'end' ] ) . '" type="text" class="wtrFilterScopeInstanceDatePicker" value="' . esc_attr( $_GET[ 'date' ] ) . '">
					</div>
				</div>
				<a href="?page=wtr_classes_schedule&view=instance&id=' . esc_attr( $_GET[ 'id' ] ) . '&date=' . esc_attr( $_GET[ 'date' ] ) . '" class="WonButton  wtrFilterScopeInstance" style="height:12px !important;" data-calendar="1">' . __( 'Show data', 'wtr_cs_framework' ) . '</a>
			</div>';
		}//end


		public function draw_calendar_scope_item( $calendar, $id_scope, $data ){

			if( isset( $data[ 'txt_id_classes' ][ 'value' ] ) ){
				if( isset( $data[ 'txt_id_room' ][ 'value' ] ) ){
					$room_text = $data[ 'txt_id_room' ][ 'value' ];
				}else{
					$room_text = '';
				}

				$result = '<tr class="stdRow wtr-data-scope-' . esc_attr( $id_scope ) . ' ">
					<td class="class"> ' . stripcslashes( $data[ 'txt_id_classes' ][ 'value' ] ) . ' </td>
					<td class="class">' . $data[ 'start_date' ][ 'value' ] . ' - ' . $data[ 'end_date' ][ 'value' ] . '</td>
					<td class="class">' .
						$this->gen_hours_overview( $calendar[ 'time_format' ], $data[ 'time_hour_start' ], $data[ 'time_minute_start' ] )  . ' - ' .
						$this->gen_hours_overview( $calendar[ 'time_format' ], $data[ 'time_hour_end' ], $data[ 'time_minute_end' ] ) .
					'</td>
					<td class="class">' . $room_text . '</td>
					<td class="class">' . ( ( isset( $data[ 'txt_trainers' ] ) )? $data[ 'txt_trainers' ][ 'value' ] : $data[ 'txt_trainers_tmp' ][ 'value' ] ) . '</td>
					<td class="class">' . $data[ 'participants' ][ 'value' ] . '</td>
					<td class="option">
						<div class="wtrAdminCallSett clearfix">
							<span data-scope="'. esc_attr( $id_scope ) .'" data-calendar="'. esc_attr( $calendar[ 'id_timetable' ] ) .'" class="wtrAdminCalSettBtn settingBtn wtrEditScope">
								<i class="fa fa-cog"></i>
							</span>
							<span data-scope="'. esc_attr( $id_scope ) .'" class="wtrAdminCalSettBtn deleteBtn wtrDeleteScope">
								<i class="fa fa-times"></i>
							</span>
						</div>
					</td>
				</tr>';
			}else{
				$result = '';
			}

			return $result;
		}//end draw_calendar_scope_item


		public function grid_for_day( $mode, $calendar, $source, $type = null ){

			$days = array(
				'monday',
				'tuesday',
				'wednesday',
				'thursday',
				'friday',
				'saturday',
				'sunday',
			);

			if( 'scope' == $mode ){
				$attr = array(
					array( 'class' => '', 'name' => __( 'Class', 'wtr_cs_framework' ) ),
					array( 'class' => '', 'name' => __( 'From - To', 'wtr_cs_framework' ) ),
					array( 'class' => 'time', 'name' => __( 'Time period', 'wtr_cs_framework' ) ),
					array( 'class' => 'room', 'name' => __( 'Room', 'wtr_cs_framework' ) ),
					array( 'class' => '', 'name' => __( 'Trainers', 'wtr_cs_framework' ) ),
					array( 'class' => 'room', 'name' => __( 'Participants', 'wtr_cs_framework' ) ),
				);
			}else if( 'instance' == $mode ){
				$attr = array(
					array( 'class' => '', 'name' => __( 'Class', 'wtr_cs_framework' ) ),
					array( 'class' => 'time', 'name' => __( 'Time period', 'wtr_cs_framework' ) ),
					array( 'class' => 'room', 'name' => __( 'Room', 'wtr_cs_framework' ) ),
					array( 'class' => '', 'name' => __( 'Trainers', 'wtr_cs_framework' ) ),
					array( 'class' => 'room', 'name' => __( 'Participants', 'wtr_cs_framework' ) ),
				);
			}
			$attr_c = count( $attr );

			for( $wsk_day = 0; $wsk_day < 7; $wsk_day++ ){

				$style = ( $wsk_day )? 'style="display:none;"' : '';

				echo '
				<table class="pure-table wtrClassScheduleTabContentInner scope-day-'. esc_attr( $days[ $wsk_day ] ) .' scope-day-'. esc_attr( $wsk_day ) .'" ' . $style . ' data-day="' . esc_attr( $wsk_day ) . '">
					<thead>
						<tr>';
							for( $cols_wsk = 0; $cols_wsk < $attr_c ; $cols_wsk++ ){
								echo '<th class="' . esc_attr( $attr[ $cols_wsk ][ 'class' ] ) . '">' .$attr[ $cols_wsk ][ 'name' ] . '</th>';
							}
						echo '
							<th class="option">' . __( 'Settings', 'wtr_cs_framework' ) . '</th>
						</tr>
					</thead>
					<tbody>';

					if( isset( $source[ $wsk_day ] ) && count( $source[ $wsk_day ] ) ){
						$nothing_row	= 'display:none;';
						if( 'scope' == $mode ){
							foreach ( $source[ $wsk_day ] as $id_timetable => $item ) {
								echo $this->draw_calendar_scope_item( $calendar, $id_timetable, $item );
							}
						}else if( 'instance' == $mode ){
							foreach ( $source[ $wsk_day ] as $id_instance => $instance ) {
								echo $this->draw_calendar_instance_item( $calendar, $id_instance, $instance, $type );
							}
						}

					}
					else{
						$nothing_row ='';
					}

					echo '
						<tr class="stdRow stdNothingHere" style="' . $nothing_row . '">
							<td colspan="' . ( $attr_c + 1 ) . '">' . __( 'Nothing here :(', 'wtr_cs_framework' ) . '</td>
						</tr>
					</tbody>
				</table>';
			}
		}//end scope_for_day


		public function scope_calendar_list_preview( $calendar_data, $scope_list ){
			echo '
			<div class="wtrCalendarHeadline clearfix">
				<h2>' . __( 'Calendar scope', 'wtr_cs_framework' ) . ': ' . $calendar_data[ 'name' ] . '</h2>
				<span class="WonButton yellow wtrAddScope" data-calendar="' . esc_attr( $_GET[ 'id' ] ) . '">' . __( 'Add scope', 'wtr_cs_framework' ) . '</span>
				<a href="?page=wtr_classes_schedule&view=instance&id=' . esc_attr( $_GET[ 'id' ] ) . '&date=' . current_time( 'Y-m-d' ) . '" class="WonButton blue" name="Submit" type="submit">' . __( 'Calendar Instance', 'wtr_cs_framework' ) . '</a>
				<a href="?page=wtr_classes_schedule" class="WonButton blue" name="Submit" type="submit">' . __( 'Back to list of calendars', 'wtr_cs_framework' ) . '</a>
			</div>
			<div class="wtrCalendarInside inside">
					<div class="wtrCalendarContainer">
						<div class="wtrPageOptions wtrUIContener">
							<div class="wtrPageOptionsInner">';

							wp_nonce_field( 'wtr_scope_nonce', 'wtr_scope_nonce' );
							echo'
								<ul class="wtrPageOptionsTabsInsider">
									<li class="wtrClassScheduleTabItem wtrActivePageOptionTab" data-trigger="scope-day-monday">
										<div>
											<span class="wtrAdminCalendarTabNameDayHolder " data-trigger="scope-day-monday">
												' . $this->days_list[ 0 ] . '
											</span>
											<span class="wtrAdminCalendarTabDateHolder wtrActiveDateTab"></span>
										</div>
									</li>
									<li class="wtrClassScheduleTabItem" data-trigger="scope-day-tuesday">
										<div>
											<span class="wtrAdminCalendarTabNameDayHolder " data-trigger="scope-day-tuesday">
												' . $this->days_list[ 1 ] . '
											</span>
											<span class="wtrAdminCalendarTabDateHolder "></span>
										</div>
									</li>
									<li class="wtrClassScheduleTabItem" data-trigger="scope-day-wednesday">
										<div>
											<span class="wtrAdminCalendarTabNameDayHolder" data-trigger="scope-day-wednesday">
												' . $this->days_list[ 2 ] . '
											</span>
											<span class="wtrAdminCalendarTabDateHolder "></span>
										</div>
									</li>
									<li class="wtrClassScheduleTabItem" data-trigger="scope-day-thursday">
										<div>
											<span class="wtrAdminCalendarTabNameDayHolder  " data-trigger="scope-day-thursday">
												' . $this->days_list[ 3 ] . '
											</span>
											<span class="wtrAdminCalendarTabDateHolder "></span>
										</div>
									</li>
									<li class="wtrClassScheduleTabItem" data-trigger="scope-day-friday">
										<div>
											<span class="wtrAdminCalendarTabNameDayHolder  " data-trigger="scope-day-friday">
												' . $this->days_list[ 4 ] . '
											</span>
											<span class="wtrAdminCalendarTabDateHolder "></span>
										</div>
									</li>
									<li class="wtrClassScheduleTabItem" data-trigger="scope-day-saturday">
										<div>
											<span class="wtrAdminCalendarTabNameDayHolder  " data-trigger="scope-day-saturday">
												' . $this->days_list[ 5 ] . '
											</span>
											<span class="wtrAdminCalendarTabDateHolder "></span>
										</div>
									</li>
									<li class="wtrClassScheduleTabItem" data-trigger="scope-day-sunday">
										<div>
											<span class="wtrAdminCalendarTabNameDayHolder " data-trigger="scope-day-sunday">
												' . $this->days_list[ 6 ] . '
											</span>
											<span class="wtrAdminCalendarTabDateHolder "></span>
										</div>
									</li>
								</ul>
							</div>
							<div class="wtrPageOptionsTabsContent">
								<div class="wtrAdminCalendarTable">
									<div class="wtrAdminCalendarHolder">
										<div class="wtrAdminCalendarHolderTitle" >
											<div class="headline">' . __( 'Data loading', 'wtr_cs_framework' ) . '</div>
											<div class="subline">' . __( 'please wait', 'wtr_cs_framework' ) . '</div>
										</div>
									</div>';

									$this->grid_for_day( 'scope', $calendar_data, $scope_list );

								echo '
								</div>
								<div class="clear"></div>
							</div>

							<div class="clear"></div>
						</div>
					</div>';
		}//end ScopeCalendarListPreview


		//INSTANCE FUNCTION

		public function check_data_flag( $source, $txt = null ){

			if( $txt ){
				$val = $txt[ 'value' ];
			}else{
				$val = $source[ 'value' ];
			}

			if( isset( $source[ 'flag' ] ) && '1' == $source[ 'flag' ] ){
				$result = '<span style="color: red; font-weight:bold;">' . $val . '</span>';
			}else{
				$result = $val;
			}

			return $result;
		}//end check_data_flag


		public function draw_calendar_instance_item( $calendar, $id_instance, $instance, $type ){
			if( isset( $instance[ 'txt_id_classes' ] ) ){
				$result = '<tr class="stdRow wtr-data-instance-' . esc_attr( $id_instance ) . ' ">
					<td class="class"> ' . stripcslashes( $this->check_data_flag( $instance[ 'id_classes' ], $instance[ 'txt_id_classes' ] ) ) . ' </td>
					<td class="class">' .
						$this->gen_hours_overview( $calendar[ 'time_format' ], $instance[ 'time_hour_start' ], $instance[ 'time_minute_start' ] )  . ' - ' .
						$this->gen_hours_overview( $calendar[ 'time_format' ], $instance[ 'time_hour_end' ], $instance[ 'time_minute_end' ] ) .
					'</td>
					<td class="class">' . $this->check_data_flag( $instance[ 'id_room' ], $instance[ 'txt_id_room' ] ) . '</td>
					<td class="class">' . ( ( isset( $instance[ 'txt_trainers' ] ) )? $this->check_data_flag( $instance[ 'trainers' ], $instance[ 'txt_trainers' ] ) : $this->check_data_flag( $instance[ 'trainers' ], $instance[ 'txt_trainers_tmp' ] ) ) . '</td>
					<td class="class">' . $this->check_data_flag( $instance[ 'participants' ] ) . '</td>
					<td class="option">
						<div class="wtrAdminCallSett clearfix">
							<span data-instance="'. esc_attr( $id_instance ) .'" data-calendar="'. esc_attr( $calendar[ 'id_timetable' ] ) .'" class="wtrAdminCalSettBtn settingBtn wtrEditInstance">
								<i class="fa fa-cog"></i>
							</span>
							<span data-instance="'. esc_attr( $id_instance ) .'" data-type="' . esc_attr( $type ) . '" class="wtrAdminCalSettBtn deleteBtn wtrDeleteInstance">
								<i class="fa fa-times"></i>
							</span>
						</div>
					</td>
				</tr>';
			}else{
				$result = '';
			}

			return $result;
		}//end draw_calendar_instance_item


		public function set_active_day_instance( $day, $active ){
			if( $day == $active ){
				$status = 'wtrActivePageOptionTab';
			}else{
				$status = 'wtrNonActivePageOptionTab';
			}

			return $status;
		}//end set_active_day_instance



		public function instance_calendar_list_preview( $calendar_data, $instance, $scope, $rande = null ){
			echo '
			<div class="wtrCalendarHeadline clearfix">
				<h2>' . __( 'Calendar instance', 'wtr_cs_framework' ) . ': ' . $calendar_data[ 'name' ] . '</h2>';

				if( 'static' == $calendar_data[ 'type' ] ){
					echo '<span class="WonButton yellow wtrAddInstance" data-calendar="' . esc_attr( $_GET[ 'id' ] ) . '">' . __( 'Add instance', 'wtr_cs_framework' ) . '</span>';
				}

				echo'
				<input type="hidden" value="' . $calendar_data[ 'type' ] . '" class="wtr_calendar_instance_type"/>';

				if( 'multi_week' == $calendar_data[ 'type' ] ){
					echo '<a href="?page=wtr_classes_schedule&view=scope&id=' . esc_attr( $_GET[ 'id' ] ) . '" class="WonButton blue" name="Submit" type="submit">' . __( 'Calendar Scope', 'wtr_cs_framework' ) . '</a>';
				}

				echo '<a href="?page=wtr_classes_schedule" class="WonButton blue" name="Submit" type="submit">' . __( 'Back to list of calendars', 'wtr_cs_framework' ) . '</a>';

			echo '
			</div>
			<div class="wtrCalendarInside inside">
					<div class="wtrCalendarContainer">
						<div class="wtrPageOptions wtrUIContener">
							<div class="wtrPageOptionsInner">';

							if( 'multi_week' == $calendar_data[ 'type' ] ){
								echo $this->scope_data_switcher( $instance, $rande );
							}

							wp_nonce_field( 'wtr_instance_nonce', 'wtr_instance_nonce' );
							echo'
								<ul class="wtrPageOptionsTabsInsider">
									<li class="wtrClassScheduleTabItem '. $this->set_active_day_instance( 0, $scope[ 'n_day' ] ) .'" data-trigger="scope-day-monday">
										<div>
											<span class="wtrAdminCalendarTabNameDayHolder " data-trigger="scope-day-monday">
												' . $this->days_list[ 0 ] . '
											</span>
											<span class="wtrAdminCalendarTabDateHolder wtrActiveDateTab">' . $scope[ 'days_f' ][ 0 ] . '</span>
										</div>
									</li>
									<li class="wtrClassScheduleTabItem '. $this->set_active_day_instance( 1, $scope[ 'n_day' ] ) .'" data-trigger="scope-day-tuesday">
										<div>
											<span class="wtrAdminCalendarTabNameDayHolder " data-trigger="scope-day-tuesday">
												' . $this->days_list[ 1 ] . '
											</span>
											<span class="wtrAdminCalendarTabDateHolder ">' . $scope[ 'days_f' ][ 1 ] . '</span>
										</div>
									</li>
									<li class="wtrClassScheduleTabItem '. $this->set_active_day_instance( 2, $scope[ 'n_day' ] ) .'" data-trigger="scope-day-wednesday">
										<div>
											<span class="wtrAdminCalendarTabNameDayHolder" data-trigger="scope-day-wednesday">
												' . $this->days_list[ 2 ] . '
											</span>
											<span class="wtrAdminCalendarTabDateHolder ">' . $scope[ 'days_f' ][ 2 ] . '</span>
										</div>
									</li>
									<li class="wtrClassScheduleTabItem '. $this->set_active_day_instance( 3, $scope[ 'n_day' ] ) .'" data-trigger="scope-day-thursday">
										<div>
											<span class="wtrAdminCalendarTabNameDayHolder  " data-trigger="scope-day-thursday">
												' . $this->days_list[ 3 ] . '
											</span>
											<span class="wtrAdminCalendarTabDateHolder ">' . $scope[ 'days_f' ][ 3 ] . '</span>
										</div>
									</li>
									<li class="wtrClassScheduleTabItem '. $this->set_active_day_instance( 4, $scope[ 'n_day' ] ) .'" data-trigger="scope-day-friday">
										<div>
											<span class="wtrAdminCalendarTabNameDayHolder  " data-trigger="scope-day-friday">
												' . $this->days_list[ 4 ] . '
											</span>
											<span class="wtrAdminCalendarTabDateHolder ">' . $scope[ 'days_f' ][ 4 ] . '</span>
										</div>
									</li>
									<li class="wtrClassScheduleTabItem '. $this->set_active_day_instance( 5, $scope[ 'n_day' ] ) .'" data-trigger="scope-day-saturday">
										<div>
											<span class="wtrAdminCalendarTabNameDayHolder  " data-trigger="scope-day-saturday">
												' . $this->days_list[ 5 ] . '
											</span>
											<span class="wtrAdminCalendarTabDateHolder ">' . $scope[ 'days_f' ][ 5 ] . '</span>
										</div>
									</li>
									<li class="wtrClassScheduleTabItem '. $this->set_active_day_instance( 6, $scope[ 'n_day' ] ) .'" data-trigger="scope-day-sunday">
										<div>
											<span class="wtrAdminCalendarTabNameDayHolder " data-trigger="scope-day-sunday">
												' . $this->days_list[ 6 ] . '
											</span>
											<span class="wtrAdminCalendarTabDateHolder ">' . $scope[ 'days_f' ][ 6 ] . '</span>
										</div>
									</li>
								</ul>
							</div>
							<div class="wtrPageOptionsTabsContent">
								<div class="wtrAdminCalendarTable">';
									$this->grid_for_day( 'instance', $calendar_data, $instance, $calendar_data[ 'type' ] );
								echo '
								</div>
								<div class="clear"></div>
							</div>

							<div class="clear"></div>
						</div>
					</div>';
		}//end InstanceCalendarListPreview


		public function create_settings_page_html(){

			global $wp_roles, $wtr_date_format_field;

			$drop_table		= intval( get_option('wtr_classes_schedule_drop_table') );
			$date_format	= get_option('wtr_classes_schedule_date_format');
			$all_roles		= $wp_roles->roles;
			$editable_roles	= apply_filters('editable_roles', $all_roles );

			echo '<form method="post" action="">';


			echo '
			<div class="wp-con"></div>
				<div id="wtr-meta-page" class="wtrCAS postbox  wtrOptionPanel">
					<div class="handlediv" title="Click to toggle"><br></div>
					<h3 class="wtrCASH3"><span>'. __( 'Schedule settings', 'wtr_cs_framework' ) .'</span></h3>
					<div class="inside">
						<div class="wtrPageOptions wtrCASUi wtrUIContener"><div class="wtrPageOptionsInner">

								<ul class="wtrPageOptionsTabsInsider">
								<li>
									<span class="wtrPageOptionsTabItem wtrActivePageOptionTab" data-trigger="wtrPageOptionsTabItem_Layout">'. __('Basic', 'wtr_cs_framework' ) .'</span>
								</li>
								</ul>
							</div>
							<div class="wonsterFiled ">
								<div class="wfDesc">
									<div class="wfTitle">'. __('Roles and users permissions with access to schedule', 'wtr_cs_framework' ) .'</div>
									<div class="setDescNag"></div>
								</div>
								<div class="wfSett">';

									foreach( $editable_roles as $role_key => $role ){
										$checked	= isset( $role['capabilities']['wtr_classes_schedule_manage'] ) ? 'checked="checked"' : '';
										$readonly	= ( 'administrator' == $role_key) ? 'disabled="disabled"' : '';
										echo '<div class="wtrCASOpt"><input  ' . $readonly . ' ' . $checked . ' value="' . $role_key .'" type="checkbox" name="role[' . $role_key . ']"  >' . $role['name'] .'</div>';
									}

								echo '</div>
								<div class="clear"></div>
							</div>

							<div class="wonsterFiled ">
								<div class="wfDesc">
									<div class="wfTitle">'. __('Delete all previously added schedule data during uninstallation process', 'wtr_cs_framework' ) .'</div>
									<div class="setDescNag"></div>
								</div>
								<div class="wfSett">
									<select  name="drop_table">
										<option "' . selected( $drop_table, 0, false ) .'" value="">' . __('NO' , 'wtr_cs_framework' ) .'</option>
										<option "'. selected( $drop_table, 1, false ) .' " value="1">' . __('YES', 'wtr_cs_framework' ) .'</option>
									</select>
								</div>
								<div class="clear"></div>
							</div>
							<div class="wonsterFiled ">
								<div class="wfDesc">
									<div class="wfTitle">'. __('Default date format', 'wtr_cs_framework' ) .'</div>
									<div class="setDescNag"></div>
								</div>
								<div class="wfSett">
									<select  name="date_format">';
										foreach ($wtr_date_format_field as $key => $value) {
											echo  '<option "' . selected( $key, $date_format, false ) .'" value="' . $key . '">' . $value .'</option>';
										}
									echo '</select>
								</div>
								<div class="clear"></div>
							</div>
						</div>
					</div>
				</div>
				<input class="wtrCASS" name=" wtr_classes_schedule_submit" type="submit" value="' .__('Save', 'wtr_cs_framework' ) .'" />
			</form>';
		}//end create_settings_page_html
	}//end WTR_Cs_view
}
