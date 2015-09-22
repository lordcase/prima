<?php

if ( ! class_exists( 'WTR_Cs_db' ) ) {

	class WTR_Cs_db{

		//VARIABLE
		private $table_timetable;
		private $table_timetable_fields;
		private $table_scope;
		private $table_scope_fields;
		private $table_ap_multi;
		private $table_ap_multi_fields;
		private $table_ap_static;
		private $table_ap_static_fields;
		private $calendarFields;

		//FUNCTION

		public function __construct(){

			global $wpdb;

			$this->table_timetable_var			= 'wtr_schedule';
			$this->table_timetable_fields_var	= 'wtr_schedule_fields';
			$this->table_scope_var				= 'wtr_schedule_scope';
			$this->table_scope_fields_var		= 'wtr_schedule_scope_fields';
			$this->table_ap_multi_var			= 'wtr_schedule_ap_multi';
			$this->table_ap_multi_fields_var	= 'wtr_schedule_ap_multi_fields';
			$this->table_ap_static_var			= 'wtr_schedule_ap_static';
			$this->table_ap_static_fields_var	= 'wtr_schedule_ap_static_fields';

			$this->table_timetable				= $wpdb->prefix . $this->table_timetable_var;
			$this->table_timetable_fields		= $wpdb->prefix . $this->table_timetable_fields_var;
			$this->table_scope					= $wpdb->prefix . $this->table_scope_var;
			$this->table_scope_fields			= $wpdb->prefix . $this->table_scope_fields_var;
			$this->table_ap_multi				= $wpdb->prefix . $this->table_ap_multi_var;
			$this->table_ap_multi_fields		= $wpdb->prefix . $this->table_ap_multi_fields_var;
			$this->table_ap_static				= $wpdb->prefix . $this->table_ap_static_var;
			$this->table_ap_static_fields		= $wpdb->prefix . $this->table_ap_static_fields_var;

			$this->calendarFields	= array(
				'name'			=> '',
				'type'			=> '',
				'time_format'	=> '',
				'show_event'	=> '',
			);
		}//end __construct


		public function create_plugin_table(){

			global $wpdb;

			$charset_collate = '';
			if ( ! empty($wpdb->charset) ) {
				$charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
			}
			if ( ! empty($wpdb->collate) ) {
				$charset_collate .= " COLLATE $wpdb->collate";
			}

			// classes schedule table
			if ( 0 !== strcasecmp( $wpdb->get_var( "SHOW TABLES LIKE '{$this->table_timetable}'" ), $this->table_timetable ) ) {
				$sql = "CREATE TABLE IF NOT EXISTS `{$this->table_timetable}` (
							`id` INT NOT NULL AUTO_INCREMENT,
							`name` VARCHAR(45) NULL,
							PRIMARY KEY (`id`)
						) {$charset_collate}";

				if ( $wpdb->query( $sql ) === false ) {
					throw new Exception( $wpdb->last_error );
				}
			}

			// classes schedule settings table
			if ( 0 !== strcasecmp( $wpdb->get_var( "SHOW TABLES LIKE '{$this->table_timetable_fields}'" ), $this->table_timetable_fields ) ) {
				$sql = "CREATE TABLE IF NOT EXISTS `{$this->table_timetable_fields}` (
							`id` INT NOT NULL AUTO_INCREMENT,
							`id_timetable` INT NOT NULL,
							`field` VARCHAR(20) NULL,
							`value` TEXT NULL,
							PRIMARY KEY (`id`)
						) {$charset_collate}";

				if ( $wpdb->query( $sql ) === false ) {
					throw new Exception( $wpdb->last_error );
				}
			}

			// classes schedule scope table
			if ( 0 !== strcasecmp( $wpdb->get_var( "SHOW TABLES LIKE '{$this->table_scope}'" ), $this->table_scope ) ) {
				$sql = "CREATE TABLE IF NOT EXISTS `{$this->table_scope}` (
							`id` INT NOT NULL AUTO_INCREMENT,
							`id_timetable` INT NOT NULL,
							`id_classes` INT NULL,
							`day_of_the_week` INT NULL,
							`start_date` DATE NULL,
							`end_date` DATE NULL,
							PRIMARY KEY (`id`)
						) {$charset_collate}";

				if ( $wpdb->query( $sql ) === false ) {
					throw new Exception( $wpdb->last_error );
				}
			}

			// classes schedule scope table
			if ( 0 !== strcasecmp( $wpdb->get_var( "SHOW TABLES LIKE '{$this->table_scope_fields}'" ), $this->table_scope_fields ) ) {
				$sql = "CREATE TABLE IF NOT EXISTS `{$this->table_scope_fields}` (
							`id` INT NOT NULL AUTO_INCREMENT,
							`id_scope` INT NOT NULL,
							`field` VARCHAR(20) NULL,
							`value` TEXT NULL,
							PRIMARY KEY (`id`)
						) {$charset_collate}";

				if ( $wpdb->query( $sql ) === false ) {
					throw new Exception( $wpdb->last_error );
				}
			}

			// classes schedule scope table
			if ( 0 !== strcasecmp( $wpdb->get_var( "SHOW TABLES LIKE '{$this->table_ap_multi}'" ), $this->table_ap_multi ) ) {
				$sql = "CREATE TABLE IF NOT EXISTS `{$this->table_ap_multi}` (
							`id` INT NOT NULL AUTO_INCREMENT,
							`id_timetable` INT NOT NULL,
							`id_scope` INT NOT NULL,
							`id_classes` INT NULL,
							`date` DATE NULL,
							PRIMARY KEY (`id`)
						) {$charset_collate}";

				if ( $wpdb->query( $sql ) === false ) {
					throw new Exception( $wpdb->last_error );
				}
			}

			// ap multi
			if ( 0 !== strcasecmp( $wpdb->get_var( "SHOW TABLES LIKE '{$this->table_ap_multi_fields}'" ), $this->table_ap_multi_fields ) ) {
				$sql = "CREATE TABLE IF NOT EXISTS `{$this->table_ap_multi_fields}` (
							`id` INT NOT NULL AUTO_INCREMENT,
							`id_scope` INT NOT NULL,
							`id_ap_multi` INT NOT NULL,
							`field` VARCHAR(20) NULL,
							`value` TEXT NULL,
							`flag` TINYINT(1) NULL,
							PRIMARY KEY (`id`)
						) {$charset_collate}";

				if ( $wpdb->query( $sql ) === false ) {
					throw new Exception( $wpdb->last_error );
				}
			}

			// ap static
			if ( 0 !== strcasecmp( $wpdb->get_var( "SHOW TABLES LIKE '{$this->table_ap_static}'" ), $this->table_ap_static ) ) {
				$sql = "CREATE TABLE IF NOT EXISTS `{$this->table_ap_static}` (
							`id` INT NOT NULL AUTO_INCREMENT,
							`id_timetable` INT NOT NULL,
							`id_classes` INT NULL,
							`day_of_the_week` INT NULL,
							PRIMARY KEY (`id`)
						) {$charset_collate}";

				if ( $wpdb->query( $sql ) === false ) {
					throw new Exception( $wpdb->last_error );
				}
			}

			// classes schedule scope table
			if ( 0 !== strcasecmp( $wpdb->get_var( "SHOW TABLES LIKE '{$this->table_ap_static_fields}'" ), $this->table_ap_static_fields ) ) {
				$sql = "CREATE TABLE IF NOT EXISTS `{$this->table_ap_static_fields}` (
							`id` INT NOT NULL AUTO_INCREMENT,
							`id_ap_static` INT NOT NULL,
							`field` VARCHAR(20) NULL,
							`value` TEXT NULL,
							`flag` TINYINT(1) NULL,
							PRIMARY KEY (`id`)
						) {$charset_collate}";

				if ( $wpdb->query( $sql ) === false ) {
					throw new Exception( $wpdb->last_error );
				}
			}
		}//end create_plugin_table


		public function delete_plugin_table(){

			global $wpdb;

			if( is_multisite() ){
				$sites = wp_get_sites();
				echo '<pre>';
				foreach( $sites as $key => $site ){
					$id_site = $site[ 'blog_id' ];

					$wp_opt = $wpdb->prefix . $site[ 'blog_id' ] . '_options';
					$row = $wpdb->get_row( $wpdb->prepare( "SELECT option_value FROM $wp_opt WHERE option_name = %s LIMIT 1", 'wtr_classes_schedule_drop_table' ) );

					if( isset( $row->option_value ) && 1 == $row->option_value ){
						$wpdb->query( "DROP TABLE " . $wpdb->prefix . $id_site . '_' . $this->table_timetable_var );
						$wpdb->query( "DROP TABLE " . $wpdb->prefix . $id_site . '_' . $this->table_timetable_fields_var );
						$wpdb->query( "DROP TABLE " . $wpdb->prefix . $id_site . '_' . $this->table_scope_var );
						$wpdb->query( "DROP TABLE " . $wpdb->prefix . $id_site . '_' . $this->table_scope_fields_var );
						$wpdb->query( "DROP TABLE " . $wpdb->prefix . $id_site . '_' . $this->table_ap_multi_var );
						$wpdb->query( "DROP TABLE " . $wpdb->prefix . $id_site . '_' . $this->table_ap_multi_fields_var );
						$wpdb->query( "DROP TABLE " . $wpdb->prefix . $id_site . '_' . $this->table_ap_static_var );
						$wpdb->query( "DROP TABLE " . $wpdb->prefix . $id_site . '_' . $this->table_ap_static_fields_var );
					}
				}
			}

			if( 1 == get_option( 'wtr_classes_schedule_drop_table' ) ){
				$wpdb->query( "DROP TABLE " . $this->table_timetable );
				$wpdb->query( "DROP TABLE " . $this->table_timetable_fields );
				$wpdb->query( "DROP TABLE " . $this->table_scope );
				$wpdb->query( "DROP TABLE " . $this->table_scope_fields );
				$wpdb->query( "DROP TABLE " . $this->table_ap_multi );
				$wpdb->query( "DROP TABLE " . $this->table_ap_multi_fields );
				$wpdb->query( "DROP TABLE " . $this->table_ap_static );
				$wpdb->query( "DROP TABLE " . $this->table_ap_static_fields );
			}
		}//end delete_plugin_table


		public function check_data_link( $type, $id ){

			global $wpdb;

			$result	= array( 'scope' => array(), 'ap_m_week' => array(), 'ap_static' => array() );
			$flagS	= true;
			$limit 	= 50;

			switch( $type ){
				case 'trainer':
					$where_scope	= "`sf`.field = 'trainers' AND `sf`.value LIKE '%;{$id};%'";
					$where_ap_m		= "`apf`.field = 'trainers' AND `apf`.value LIKE '%;{$id};%'";
					$where_ap_s		= "`apf`.field = 'trainers' AND `apf`.value LIKE '%;{$id};%'";
				break;

				case 'classes':
					$where_scope	= "`s`.id_classes = {$id} GROUP BY `sf`.id_scope";
					$where_ap_m		= "`ap`.id_classes = {$id} GROUP BY `ap`.date";
					$where_ap_s		= "`ap`.id_classes = {$id} GROUP BY `ap`.id";
				break;

				case 'rooms':
					$where_scope	= "`sf`.field = 'id_room' AND `sf`.value = {$id}";
					$where_ap_m		= "`apf`.field = 'id_room' AND `apf`.value = {$id}";
					$where_ap_s		= "`apf`.field = 'id_room' AND `apf`.value = {$id}";
				break;

				default:
					$flagS	= false;
					$result	= array();
				break;
			}

			if( true === $flagS ){

				$scope_query = "SELECT `t`.name, `t`.id, `sf`.id_scope, `s`.start_date, `s`.end_date, `s`.day_of_the_week
								FROM {$this->table_scope} s
								INNER JOIN {$this->table_scope_fields} sf ON `s`.id = `sf`.id_scope
								INNER JOIN {$this->table_timetable} t ON `t`.id = `s`.id_timetable
								WHERE  %s LIMIT {$limit};";

				$ap_m_query =  "SELECT `t`.id, `t`.name, `ap`.id_scope, `ap`.date
								FROM {$this->table_ap_multi} ap
								INNER JOIN {$this->table_ap_multi_fields} apf ON `ap`.id = `apf`.id_ap_multi
								INNER JOIN {$this->table_timetable} t ON `t`.id = `ap`.id_timetable
								WHERE  %s LIMIT {$limit};";

				$ap_s_query =  "SELECT `t`.id, `t`.name, `ap`.day_of_the_week
								FROM {$this->table_ap_static} ap
								INNER JOIN {$this->table_ap_static_fields} apf ON `ap`.id = `apf`.id_ap_static
								INNER JOIN {$this->table_timetable} t ON `t`.id = `ap`.id_timetable
								WHERE %s LIMIT {$limit};";

				//multi
				$result[ 'scope' ]		= $wpdb->get_results( sprintf( $scope_query, $where_scope ), 'ARRAY_A' );
				$result[ 'ap_m_week' ]	= $wpdb->get_results( sprintf( $ap_m_query, $where_ap_m ), 'ARRAY_A' );

				//static
				$result[ 'ap_static' ]	= $wpdb->get_results( sprintf( $ap_s_query, $where_ap_s ), 'ARRAY_A' );

				if( 0 == count( $result[ 'scope' ] ) && 0 == count( $result[ 'ap_m_week' ] ) && 0 == count( $result[ 'ap_static' ] )){
					$result = array();
				}
			}else{
				$result = array();
			}

			return $result;
		}//end check_data_link


		private function fix_db_data( $default, $data, $rec = false ){

			$result = array();

			if( $rec ){

				foreach( $data as $key => $fields ){
					$result[ $key ] = array_merge( $default, $fields );
				}
			}
			else{
				$result = array_merge( $default, $data );
			}

			return $result;
		}//end fix_db_data


		public function getWpQuery( $attr = array(), $mode = 'admin' ){

			$default = array(
				'post_type'				=> 'gym_location',
				'posts_per_page'		=> -1,
				'ignore_sticky_posts'	=> 1,
				'wtr_add_all_item'		=> true,
				'fields'				=> 'ids'
			);
			$result	= array();
			$config	= array_merge( $default, $attr );


			// The Query
			$posts	= get_posts( $config );

			if ( ! empty( $posts ) ){
				foreach ( $posts as $post ) {
					$name = get_the_title( $post );
					$index = ( trim( $name ) )? $name: __( 'no title', 'wtr_sht_framework' );
					$index = str_replace( '&#8211;', '-', $index );
					$index = str_replace( '&#8212;', '-', $index );

					if( 'admin' == $mode ){
						$result[ $post ] = $index;
					}else{
						$result[ $post ] = array( 'name' => $index, 'post_status' => get_post_status( $post ) );
					}
				}
			}

			return $result;
		}//end getWpQuery


		protected function generateListTrainer( $mode = 'admin' ){

			$args = array(
				'post_type'				=> 'trainer',
				'posts_per_page'		=> -1,
				'ignore_sticky_posts'	=> 1,
				'fields'				=> 'ids'
			);

			// The Query
			$posts	= get_posts( $args );
			$result	= array();

			if ( ! empty( $posts ) ){
				foreach ( $posts as $post ) {
					$nameTrainer	= get_post_meta( $post, '_wtr_trainer_name', true );
					$surnameTrainer	= get_post_meta( $post, '_wtr_trainer_last_name', true );

					if( $nameTrainer || $surnameTrainer ){
						$index = trim( $nameTrainer . ' ' . $surnameTrainer );
					}
					else{
						$index = __( 'no title', 'wtr_sht_framework' );
					}

					if( 'admin' == $mode ){
						$result[ $post ] = $index;
					}else if( 'public' == $mode ){
						$result[ $post ] = array( 'name' => $index, 'post_status' => get_post_status( $post ) );
					}
				}
			}

			return $result;
		}//end generateListTrainer


		// CALENDAR FUNCTION ====

		public function get_calendar( $id ){

			global $wpdb;

			$id = ( int ) $id;

			$timetable = array();
			$results	= $wpdb->get_results( "SELECT `t`.id, `t`.name,`tf`.field, `tf`.value
										FROM `{$this->table_timetable}`as `t` JOIN
										`{$this->table_timetable_fields}` as `tf` on `t`.id = `tf`.id_timetable
										WHERE `t`.id = $id;",
										'ARRAY_A' );

				foreach ( $results as $result ) {
					$timetable[ 'id_timetable' ] = $result['id'];
					$timetable['name'] = stripcslashes( $result['name'] );
					$timetable[ $result['field'] ] = $result['value'];
				};

			return $timetable;
		}//end get_calendar


		public function get_calendar_classes_full_data( $id_calendar, $mode ){

			global $wpdb;

			$classes	= array();
			$category	= array();

			if( 'static' == $mode ){
				$results = $wpdb->get_results(
					"SELECT `w`.id_classes as id_classes, `p`.post_title as classes, `t`.term_id as id_cat, `t`.name as cat
					FROM {$this->table_ap_static} w JOIN {$wpdb->posts} p ON `w`.id_classes = `p`.ID
					LEFT JOIN {$wpdb->term_relationships} r ON `r`.object_id = `p`.ID
					LEFT JOIN {$wpdb->terms} t ON `t`.term_id = `r`.term_taxonomy_id
					WHERE `w`.id_timetable =" . $id_calendar,
					'ARRAY_A'
				);
			}else if( 'multi_week' == $mode ){
				$results = $wpdb->get_results(
					"SELECT `w`.id_classes as id_classes, `p`.post_title as classes, `t`.term_id as id_cat, `t`.name as cat
					FROM {$this->table_ap_multi} w JOIN {$wpdb->posts} p ON `w`.id_classes = `p`.ID
					LEFT JOIN {$wpdb->term_relationships} r ON `r`.object_id = `p`.ID
					LEFT JOIN {$wpdb->terms} t ON `t`.term_id = `r`.term_taxonomy_id
					WHERE `w`.id_timetable =" . $id_calendar
					.' GROUP BY `p`.post_title, `t`.term_id',
					'ARRAY_A'
				);
			}

			if( $results ){
				$resultsC = count( $results );
				for( $i = 0; $i < $resultsC; $i++ ){
					$classes[ $results[ $i ][ 'id_classes' ] ] = $results[ $i ][ 'classes' ];
					if( null !== $results[ $i ][ 'id_cat' ] ){
						$category[ $results[ $i ][ 'id_cat' ] ] = $results[ $i ][ 'cat' ];
					}
				}
			}

			asort( $classes, SORT_REGULAR  );
			asort( $category, SORT_REGULAR  );

			return array( 'classes' => $classes, 'category' => $category );
		}//end get_calendar_classes_full_data


		public function get_calendar_classes_item_data( $idx, $type, $id_classes ){

			global $wpdb;

			$result = array(
				'id_classes'		=> $id_classes,
				'post'				=> array(),
				'meta'				=> array(),
				'timetable_info'	=> array()
			);

			if( 'static' == $type ){
				$q = $wpdb->get_results(
					"SELECT `s`.field, `s`.value, `s`.flag
					FROM {$this->table_ap_static_fields} s
					WHERE `s`.id_ap_static =" . $idx,
					'ARRAY_A'
				);

				$q_c = count( $q );
				for( $i = 0; $i < $q_c; $i++ ){
					$result[ 'timetable_info' ][ $q[ $i ][ 'field' ] ] = array( 'value' => $q[ $i ][ 'value' ], 'flag' => $q[ $i ][ 'flag' ] );
				}

			}else if( 'multi_week' == $type ){
				$q = $wpdb->get_results(
					"SELECT `s`.field, `s`.value, `s`.flag
					FROM {$this->table_ap_multi_fields} s
					WHERE `s`.id_ap_multi =" . $idx,
					'ARRAY_A'
				);

				$q_c = count( $q );
				for( $i = 0; $i < $q_c; $i++ ){
					$result[ 'timetable_info' ][ $q[ $i ][ 'field' ] ] = array( 'value' => $q[ $i ][ 'value' ], 'flag' => $q[ $i ][ 'flag' ] );
				}

				$qmain = $wpdb->get_results(
					"SELECT `s`.date
					FROM {$this->table_ap_multi} s
					WHERE `s`.id =" . $idx,
					'ARRAY_A'
				);
			}

			//get list of trainsers
			$trainers = $this->generateListTrainer();

			$trainers_list	= array();
			$id_trainers	= explode( ';', $result[ 'timetable_info' ][ 'trainers' ][ 'value' ] );
			$id_trainers	= array_filter( $id_trainers );

			foreach( $id_trainers as $id_trainer ){
				if( isset( $trainers[ $id_trainer ] ) ){
					$result[ 'timetable_info' ][ 'txt_trainers' ][ $id_trainer ] = $trainers[ $id_trainer ];
				}
			}

			//get list of rooms
			$rooms = $this->getWpQuery( array( 'post_type' => 'rooms' ) );

			if( isset( $rooms[ $result[ 'timetable_info' ][ 'id_room' ][ 'value' ] ]) ){
				$result[ 'timetable_info' ][ 'txt_id_room' ] = $rooms[ $result[ 'timetable_info' ][ 'id_room' ][ 'value' ] ];
			}else{
				$result[ 'timetable_info' ][ 'txt_id_room' ] = '';
			}


			//time duration
			if( 'static' == $type ){
				$start_time	= strtotime( $result[ 'timetable_info' ][ 'time_hour_start' ][ 'value' ] . ":" . $result[ 'timetable_info' ][ 'time_minute_start' ][ 'value' ] . ":00" );
				$end_time	= strtotime( $result[ 'timetable_info' ][ 'time_hour_end' ][ 'value' ] . ":" . $result[ 'timetable_info' ][ 'time_minute_end' ][ 'value' ] . ":00" );

				$result[ 'timetable_info' ][ 'class_date' ]		= 'static';
			}else if( 'multi_week' == $type ){
				$start_time	= strtotime( $qmain[ 0 ][ 'date' ] . " " . $result[ 'timetable_info' ][ 'time_hour_start' ][ 'value' ] . ":" . $result[ 'timetable_info' ][ 'time_minute_start' ][ 'value' ] . ":00" );
				$end_time	= strtotime( $qmain[ 0 ][ 'date' ] . " " . $result[ 'timetable_info' ][ 'time_hour_end' ][ 'value' ] . ":" . $result[ 'timetable_info' ][ 'time_minute_end' ][ 'value' ] . ":00" );

				$result[ 'timetable_info' ][ 'class_date' ]		= $qmain[ 0 ][ 'date' ];
			}

			$difference	= $end_time - $start_time;

			$result[ 'timetable_info' ][ 'time_duration' ]	= floor( $difference / 60 );
			$result[ 'timetable_info' ][ 'start_time' ]		= $start_time;
			$result[ 'timetable_info' ][ 'end_time' ]		= $end_time;


			$result[ 'post' ] = get_post( $id_classes, ARRAY_A );
			$result[ 'meta' ] = get_post_meta( $id_classes );
			return $result;
		}//end get_calendar_classes_item_data


		public function get_calendar_full_data( $calendar, $scope = null, $mode = 'public', $id_class ){

			$result = $calendar;
			$result[ 'instance_admin' ] = array();
			$result[ 'instance_event' ] = array();

			if( count( $result ) ){
				$result[ 'instance_admin' ] = $this->get_instance_list( $result, $scope[ 'days' ], 'public', null, $id_class );
			}

			if( '1' == $calendar[ 'show_event' ] ){
				$result[ 'instance_event' ] = $this->get_list_events( $result, $scope );
			}
			return $result;
		}//end get_calendar_full_data


		public function get_calendar_daily_data( $calendar_data ){

			$result = $calendar_data;
			$result[ 'instance_admin' ] = array();
			$result[ 'instance_event' ] = array();

			if( 'static' == $calendar_data[ 'type' ] ){
				$today						= current_time( 'N' ) - 1;
				$result[ 'instance_admin' ]	= $this->get_instance_list( $calendar_data, $scope = null, $mode = 'public', $day = $today, $id_class = 'wtr_all_items' );
			}else if( 'multi_week' == $calendar_data[ 'type' ] ){
				$today						= current_time( 'Y-m-d' );
				$result[ 'instance_admin' ]	= $this->get_instance_list( $calendar_data, $scope = null, $mode = 'public', $day = $today, $id_class = 'wtr_all_items' );
			}

			if( '1' == $calendar_data[ 'show_event' ] ){
				$today						= current_time( 'Y-m-d' );
				$result[ 'instance_event' ]	= $this->get_list_events( $result, null, $today );
			}

			return $result;
		}//end get_calendar_daily_data


		public function get_calendar_list( $mode = true ){

			global $wpdb;

			$timetable	= array();
			$results	= $wpdb->get_results( "SELECT `t`.id, `t`.name,`tf`.field, `tf`.value
										FROM `{$this->table_timetable}`as `t` JOIN
										`{$this->table_timetable_fields}` as `tf` on `t`.id = `tf`.id_timetable
										ORDER BY `t`.id DESC;",
										'ARRAY_A' );

			if( $mode ){
				foreach ( $results as $result ) {
					$timetable[ $result['id'] ]['name']['value'] = $result['name'];
					$timetable[ $result['id'] ][ $result['field'] ] = array( 'value' => $result['value'] );
				};

				return $this->fix_db_data( $this->calendarFields, $timetable, true );
			}
			else{
				return $result;
			}
		}//end get_calendar_list


		public function create_calendar( $name_calendar, $calendar_fields ){

			global $wpdb;

			//whether the name is unique?
			$unique_name = $wpdb->get_var( "SELECT COUNT( `id` ) FROM `{$this->table_timetable}` WHERE `name` = '$name_calendar'" );

			if( 0 < $unique_name ){
				return array( 'status' => 'not_unique' );
			}else{
				//add calendar
				$timetable_value = array(
					'name'	=> $name_calendar
				);
				$wpdb->insert( $this->table_timetable, $timetable_value );

				$current_id = $wpdb->get_var( "SELECT id FROM `{$this->table_timetable}` ORDER BY  id  DESC LIMIT 1" );

				//adding fields to the calendar
				foreach ( $calendar_fields as $name => $value ) {
					$fields = array(
						'id_timetable'	=> $current_id,
						'field'			=> $name,
						'value'			=> $value
					);
					$return = $wpdb->insert( $this->table_timetable_fields, $fields );
				}
				return array( 'status' => true, 'id_timetable' => $current_id );
			}
		}//end add_calendar


		public function edit_calendar( $id_timetable, $name_calendar, $calendar_fields ){

			global $wpdb;

			//whether the name is unique?
			$unique_name = $wpdb->get_var( "SELECT COUNT( `id` )
											FROM `{$this->table_timetable}`
											WHERE `name` = '$name_calendar' AND `id` != {$id_timetable}" );

			if( 0 < $unique_name ){
				return array( 'status' => 'not_unique' );
			}else{
				//change name
				$wpdb->update(
					$this->table_timetable,
					array('name'	=> $name_calendar ),
					array( 'id'		=> $id_timetable ),
					array( '%s' ),
					array( '%d' )
				);

				//change fields
				foreach ( $calendar_fields as $name => $value ) {
					$wpdb->update(
						$this->table_timetable_fields,
						array( 'value'			=> $value ),
						array( 'id_timetable'	=> $id_timetable, 'field' => $name ),
						array( '%s'),
						array( '%d', '%s' )
					);
				}

				return array( 'status' => true, 'id_timetable' => $id_timetable );
			}
		}


		public function delete_calendar( $id ){

			global $wpdb;

			//delete classes instance
			$wpdb->query( "DELETE FROM {$this->table_ap_multi_fields}
							WHERE id_ap_multi
							IN (
								SELECT `ap`.id
								FROM {$this->table_ap_multi} ap
								WHERE id_timetable = {$id}
							)" );
			$wpdb->delete( $this->table_ap_multi, array( 'id_timetable'=> $id ), array( '%d' ) );

			$wpdb->query( "DELETE FROM {$this->table_ap_static_fields}
							WHERE id_ap_static
							IN (
								SELECT `ap`.id
								FROM {$this->table_ap_static} ap
								WHERE id_timetable = {$id}
							)" );
			$wpdb->delete( $this->table_ap_static, array( 'id_timetable'=> $id ), array( '%d' ) );

			//delete scope
			$wpdb->query( "DELETE FROM {$this->table_scope_fields}
							WHERE id_scope
							IN (
								SELECT `s`.id
								FROM {$this->table_scope} s
								WHERE id_timetable = {$id}
							)" );

			$wpdb->delete( $this->table_scope, array( 'id_timetable'=> $id ), array( '%d' ) );

			// delete calendar
			$wpdb->delete( $this->table_timetable_fields, array( 'id_timetable'=> $id ), array( '%d' ) );
			$wpdb->delete( $this->table_timetable, array( 'id'=> $id ), array( '%d' ) );
			return true;
		}//end delete_calendar


		// SCOPE FUNCTION ====

		public function get_scope_list( $calendar_data ){

			global $wpdb;

			$scope	= array();
			$id		= $calendar_data['id_timetable'];

			//get scope detail
			$scope_query = $wpdb->get_results(
				"SELECT `s`.id, `s`.id_classes, `s`.day_of_the_week, `s`.start_date, `s`.end_date
				FROM {$this->table_scope} as s
				WHERE `s`.id_timetable = $id ORDER BY `s`.id DESC;",
				'ARRAY_A'
			);

			if( $scope_query ){
				foreach( $scope_query as $single_scope_data ){
					foreach( $single_scope_data as $name => $val ){
						$scope[ $single_scope_data[ 'id' ] ][ $name  ] = array( 'value' => $val );
					}
				}

				$scope_key = array_keys ( $scope );
				$scope_ids = implode( ',', $scope_key );

				$scope_fields_query = $wpdb->get_results(
					"SELECT `sf`.id_scope, `sf`.field, `sf`.value
					FROM {$this->table_scope_fields} sf
					WHERE `sf`.id_scope IN ($scope_ids);",
					'ARRAY_A'
				);

				foreach( $scope_fields_query as $single_scope_fields_data ){
					$scope[ $single_scope_fields_data[ 'id_scope' ] ][ $single_scope_fields_data[ 'field' ] ] = array( 'value' => $single_scope_fields_data[ 'value' ] );
				}
				//get list of classes
				$classes = $this->getWpQuery( array( 'post_type' => 'classes' ) );

				//get list of rooms
				$rooms = $this->getWpQuery( array( 'post_type' => 'rooms' ) );

				//get list of trainsers
				$trainers = $this->generateListTrainer();

				//merge values
				foreach( $scope as $id_scope => $fields ){
					if( isset( $classes[ $fields[ 'id_classes' ][ 'value' ] ] ) ){
						$scope[ $id_scope ][ 'txt_id_classes' ][ 'value' ]	= $classes[ $fields[ 'id_classes' ][ 'value' ] ];
					}

					if( isset( $rooms[ $fields[ 'id_room' ][ 'value' ] ] ) ){
						$scope[ $id_scope ][ 'txt_id_room' ][ 'value' ]	= $rooms[ $fields[ 'id_room' ][ 'value' ] ];
					}

					$trainers_list	= array();
					$id_trainers	= explode( ';', $scope[ $id_scope ][ 'trainers' ][ 'value' ] );
					$id_trainers	= array_filter( $id_trainers );
					foreach( $id_trainers as $id_trainer ){
						if( isset( $trainers[ $id_trainer ] ) ){
							array_push( $trainers_list, $trainers[ $id_trainer ] );
						}
					}
					$scope[ $id_scope ][ 'txt_trainers' ][ 'value' ] = implode( ', ', $trainers_list );
				}
			}

			return $scope;
		}//end get_scope_list


		public function get_scope( $id_scope ){

			global $wpdb;

			$result = array();

			$scope_query = $wpdb->get_results(
				"SELECT `s`.id_timetable, `s`.id_classes, `s`.day_of_the_week, `s`.start_date, `s`.end_date
				FROM {$this->table_scope} as s
				WHERE `s`.id = {$id_scope};",
				'ARRAY_A'
			);
			$result = ( isset( $scope_query[ 0 ] ) )? $scope_query[ 0 ] : $scope_query;

			$scope_fields_query = $wpdb->get_results(
				"SELECT `sf`.field, `sf`.value
				FROM {$this->table_scope_fields} as sf
				WHERE `sf`.id_scope = {$id_scope};",
				'ARRAY_A'
			);

			foreach( $scope_fields_query as $field ){
				$result[ $field[ 'field' ] ] = $field[ 'value' ];
			}

			return $result;
		}//end get_scope


		public function create_calendar_scope( $scope, $scope_fields, $instance ){

			global $wpdb;

			//add scope
			$timetable_value = array(
				'id_timetable'		=> $scope[ 'id_timetable' ],
				'id_classes'		=> $scope[ 'id_classes' ],
				'day_of_the_week'	=> $scope[ 'day_of_the_week' ],
				'start_date'		=> $scope[ 'start_date' ],
				'end_date'			=> $scope[ 'end_date' ]
			);
			$wpdb->insert( $this->table_scope, $timetable_value );

			$current_id = $wpdb->get_var( "SELECT id FROM `{$this->table_scope}` ORDER BY  id  DESC LIMIT 1" );

			//adding fields to the scope
			foreach ( $scope_fields as $name => $value ) {
				$fields = array(
					'id_scope'	=> $current_id,
					'field'		=> $name,
					'value'		=> $value
				);
				$return = $wpdb->insert( $this->table_scope_fields, $fields );
			}

			// add instances
			$i_c = count( $instance );

			for( $i = 0; $i < $i_c; $i++ ){
				$this->create_calendar_multi_instance(
					array(
						'id_timetable'	=> $scope[ 'id_timetable' ],
						'id_scope'		=> $current_id,
						'id_classes'	=> $scope[ 'id_classes' ],
						'date'			=> $instance[ $i ]
					), $scope_fields
				);
			}//end for

			return array( 'status' => true, 'id_scope' => $current_id );
		}//end create_calendar_scope


		public function edit_calendar_scope( $id, $scope, $scope_fields, $mode = 0 ){

			global $wpdb;

			$change = false;

			if( count( $scope ) ){
				$change = true;

				//update main scope table
				$wpdb->update(
					$this->table_scope,
					$scope,
					array( 'id' => $id )
				);

				//update main table - multi ap
				$wpdb->update(
					$this->table_ap_multi,
					$scope,
					array( 'id_scope' => $id )
				);
			}

			if( count( $scope_fields ) ){
				$change = true;

				//update scope fields
				foreach( $scope_fields as $field => $value ){
					$wpdb->update(
						$this->table_scope_fields,
						array( 'field' => $field, 'value' => $value ),
						array( 'id_scope' => $id, 'field' => $field )
					);
				}

				//update scope fields - multi ap
				if( $mode ){
					foreach( $scope_fields as $field => $value ){
						$wpdb->update(
							$this->table_ap_multi_fields,
							array( 'field' => $field, 'value' => $value, 'flag' => 0 ),
							array( 'id_scope' => $id, 'field' => $field )
						);
					}
				}else{
					foreach( $scope_fields as $field => $value ){
						$wpdb->update(
							$this->table_ap_multi_fields,
							array( 'field' => $field, 'value' => $value ),
							array( 'id_scope' => $id, 'field' => $field, 'flag' => 0 )
						);
					}
				}

			}

			return array( 'status' => true, 'change' => $change );
		}//end edit_calendar_scope


		public function delete_scope( $id ){

			global $wpdb;

			$id = intval( $id );

			$app_ids_q = $wpdb->get_results(
				"SELECT `ap`.id
				FROM `{$this->table_ap_multi}` ap
				WHERE `ap`.id_scope = {$id}", 'ARRAY_A' );

			if( $app_ids_q ){
				$app_str = array();
				foreach( $app_ids_q as $item ){
					array_push( $app_str, $item[ 'id' ] );
				}

				$app_str = implode( ',',$app_str );

				// app
				$wpdb->query( "DELETE FROM {$this->table_ap_multi_fields} WHERE id_ap_multi IN ({$app_str})" );
				$wpdb->delete( $this->table_ap_multi, array( 'id_scope'=> $id ), array( '%d' ) );
			}

			// delete scope
			$wpdb->delete( $this->table_scope_fields, array( 'id_scope'=> $id ), array( '%d' ) );
			$wpdb->delete( $this->table_scope, array( 'id'=> $id ), array( '%d' ) );

			return true;
		}//end delete_scope


		// INSTANCE FUNCTION ====

		public function get_calendar_date_scope( $calendar ){

			global $wpdb;

			$query = "SELECT `fs`.date FROM {$this->table_ap_multi} fs WHERE id_timetable = %d ORDER BY `fs`.date %s LIMIT 1;";

			$start	= $wpdb->get_var( sprintf( $query, $calendar[ 'id_timetable' ], 'ASC' ) );
			$end	= $wpdb->get_var( sprintf( $query, $calendar[ 'id_timetable' ], 'DESC' ) );

			$start_t	= explode('-', $start );
			$end_t		= explode('-', $end );

			return array( 'year_start' => $start_t[ 0 ], 'year_end' => $end_t[ 0 ], 'start' => $start, 'end' => $end );
		}//end get_calendar_date_scope


		public function get_instance( $type, $id_scope ){

			global $wpdb;

			$result = array();

			if( 'multi_week' == $type ){
				$query = $wpdb->get_results(
					"SELECT `apf`.field, `apf`.value, `apf`.flag
					FROM {$this->table_ap_multi_fields} apf
					WHERE id_ap_multi = {$id_scope};",
					'ARRAY_A'
				);

				foreach( $query as $field ){
					$result[ $field[ 'field' ] ] = array( 'value' => $field[ 'value' ], 'flag' => $field[ 'flag' ] );
				}

			}else if( 'static' == $type ){
				$query = $wpdb->get_results(
					"SELECT `apf`.field, `apf`.value, `apf`.flag
					FROM {$this->table_ap_static_fields} apf
					WHERE id_ap_static = {$id_scope};",
					'ARRAY_A'
				);

				foreach( $query as $field ){
					$result[ $field[ 'field' ] ] = array( 'value' => $field[ 'value' ], 'flag' => $field[ 'flag' ] );
				}

				$query = $wpdb->get_results(
					"SELECT `ap`.id_classes, `ap`.day_of_the_week
					FROM {$this->table_ap_static} ap
					WHERE id = {$id_scope};",
					'ARRAY_A'
				);

				$result[ 'id_classes' ]			= array( 'value' => $query[ 0 ][ 'id_classes' ], 'flag' => 0 );
				$result[ 'day_of_the_week' ]	= array( 'value' => $query[ 0 ][ 'day_of_the_week' ], 'flag' => 0 );
			}

			return $result;
		}//end get_instance


		private function get_posts_extra_data( $post_type, $meta_keys, $mode = 'none' ){

			global $wpdb;

			$meta_fields_a	= array();
			$meta_keys_c	= count( $meta_keys );

			for( $i = 0; $i < $meta_keys_c; $i++ ){
				$meta_fields_a[] = '`pm`.meta_key ="' . $meta_keys[ $i ] . '"';
			}

			$meta_fields = implode( ' OR ', $meta_fields_a );

			if( 'none' == $mode ){
				$query = $wpdb->get_results(
					"SELECT `p`.ID, `p`.post_title, `p`.post_status, `pm`.meta_key, `pm`.meta_value
					FROM `{$wpdb->posts}` p
					LEFT JOIN `{$wpdb->postmeta}` pm ON `p`.ID = `pm`.post_id
					WHERE `p`.post_type = '{$post_type}' AND ( $meta_fields );",
					'ARRAY_A'
				 );
				$query_c = count( $query );

				for( $i = 0; $i < $query_c; $i++ ){
					$result[ $query[ $i ][ 'ID' ] ][ 'post_title' ]		= $query[ $i ][ 'post_title' ];
					$result[ $query[ $i ][ 'ID' ] ][ 'post_status' ]	= $query[ $i ][ 'post_status' ];
					$result[ $query[ $i ][ 'ID' ] ][ 'meta' ][ $query[ $i ][ 'meta_key' ] ] = $query[ $i ][ 'meta_value' ];
				}
			}else if( 'category' == $mode ){
				$query = $wpdb->get_results(
					"SELECT `p`.ID, `p`.post_title, `p`.post_status, `pm`.meta_key, `pm`.meta_value, `tr`.term_taxonomy_id
					FROM `{$wpdb->posts}` p
					LEFT JOIN `{$wpdb->postmeta}` pm ON `p`.ID = `pm`.post_id
					LEFT JOIN `{$wpdb->term_relationships}` tr ON `p`.ID = `tr`.object_id
					WHERE `p`.post_type = '{$post_type}' AND ( $meta_fields );",
					'ARRAY_A'
				 );
				$query_c = count( $query );

				for( $i = 0; $i < $query_c; $i++ ){
					$result[ $query[ $i ][ 'ID' ] ][ 'post_title' ]		= $query[ $i ][ 'post_title' ];
					$result[ $query[ $i ][ 'ID' ] ][ 'post_status' ]	= $query[ $i ][ 'post_status' ];
					$result[ $query[ $i ][ 'ID' ] ][ 'meta' ][ $query[ $i ][ 'meta_key' ] ] = $query[ $i ][ 'meta_value' ];
					if( null !== $query[ $i ][ 'term_taxonomy_id' ] ){
						$result[ $query[ $i ][ 'ID' ] ][ 'term' ][ $query[ $i ][ 'term_taxonomy_id' ] ] = trim( $query[ $i ][ 'term_taxonomy_id' ] );
					}
				}
			}

			return $result;
		}//end get_posts_extra_data


		public function get_instance_list( $calendar_data, $scope = null, $mode = 'admin', $day_t = null, $id_class = 'wtr_all_items' ){

			global $wpdb;

			$instances	= array();
			$id			= $calendar_data[ 'id_timetable' ];
			$type		= $calendar_data[ 'type' ];

			if( $day_t ){
				if( 'static' == $type ){
					$instances_tmp = $wpdb->get_results(
						"SELECT `ap`.*, `apf`.field, `apf`.value, `apf`.flag
			 			FROM {$this->table_ap_static} ap INNER JOIN {$this->table_ap_static_fields} apf ON `ap`.id = `apf`.id_ap_static
						WHERE `ap`.id_timetable = {$calendar_data[ 'id_timetable' ]} AND `ap`.day_of_the_week = {$day_t}
						ORDER BY `ap`.id DESC",
						'ARRAY_A'
					);
				}else if( 'multi_week' == $type ){
					$instances_tmp = $wpdb->get_results(
						"SELECT `ap`.*, `apf`.field, `apf`.value, `apf`.flag
			 			FROM {$this->table_ap_multi} ap INNER JOIN {$this->table_ap_multi_fields} apf ON `ap`.id = `apf`.id_ap_multi
						WHERE `ap`.id_timetable = {$calendar_data[ 'id_timetable' ]} AND `ap`.date = '{$day_t}'
						ORDER BY `ap`.id DESC",
						'ARRAY_A'
					 );
				}
			}else{
				if( 'static' == $type ){

					$instances_tmp = $wpdb->get_results(
						"SELECT `ap`.*, `apf`.field, `apf`.value, `apf`.flag
			 			FROM {$this->table_ap_static} ap INNER JOIN {$this->table_ap_static_fields} apf ON `ap`.id = `apf`.id_ap_static
						WHERE `ap`.id_timetable = {$calendar_data[ 'id_timetable' ]}
						ORDER BY `ap`.id DESC",
						'ARRAY_A'
					);
				}else if( 'multi_week' == $type ){

					reset( $scope );
					$start = key( $scope );

					end( $scope );
					$end = key( $scope );

					$instances_tmp = $wpdb->get_results(
						"SELECT `ap`.*, `apf`.field, `apf`.value, `apf`.flag
			 			FROM {$this->table_ap_multi} ap INNER JOIN {$this->table_ap_multi_fields} apf ON `ap`.id = `apf`.id_ap_multi
						WHERE `ap`.id_timetable = {$calendar_data[ 'id_timetable' ]} AND `ap`.date >= '{$start}' AND `ap`.date <= '{$end}'
						ORDER BY `ap`.id DESC",
						'ARRAY_A'
					 );
				}
			}

			if( $instances_tmp ){

				foreach( $instances_tmp as $element ){

					if( $day_t ){
						$day = current_time( 'N' ) - 1;
					}else{
						if( isset( $element[ 'date' ] ) ){
							$day = $scope [ $element[ 'date' ] ];
						}else{
							$day = $element[ 'day_of_the_week' ];
						}
					}

					$instances[ $day ][ $element[ 'id' ] ][ 'day_of_the_week' ] = array( 'value' => $day );
					$instances[ $day ][ $element[ 'id' ] ][ $element[ 'field' ] ] = array(
						'value' => $element[ 'value' ],
						'flag' => $element[ 'flag' ]
					);

					unset( $element[ 'field' ], $element[ 'value' ], $element[ 'flag' ] );

					foreach( $element as $key => $value ){
						$instances[ $day ][ $element[ 'id' ] ][ $key ] = array( 'value' => $value );
					}
				}

				if( 'admin' == $mode ){
					//get list of classes
					$classes = $this->getWpQuery( array( 'post_type' => 'classes' ) );

					//get list of rooms
					$rooms = $this->getWpQuery( array( 'post_type' => 'rooms' ) );

					//get list of trainsers
					$trainers = $this->generateListTrainer();

					//merge values
					foreach( $instances as $day => $day_instances ){
						foreach( $day_instances as $id_instance => $fields ){

							$class	= $instances[ $day ][ $id_instance ][ 'id_classes' ][ 'value' ];
							$room	= $instances[ $day ][ $id_instance ][ 'id_room' ][ 'value' ];

							if( isset( $classes[ $class ] ) ){
								$instances[ $day ][ $id_instance ][ 'txt_id_classes' ][ 'value' ] = $classes[ $class ];
							}

							if( isset( $rooms[ $room ] ) ){
								$instances[ $day ][ $id_instance ][ 'txt_id_room' ][ 'value' ] = $rooms[ $room ];
							}else{
								$instances[ $day ][ $id_instance ][ 'txt_id_room' ][ 'value' ] = '';
							}

							$trainers_list	= array();
							$id_trainers	= explode( ';', $instances[ $day ][ $id_instance ][ 'trainers' ][ 'value' ] );
							$id_trainers	= array_filter( $id_trainers );

							foreach( $id_trainers as $id_trainer ){
								if( isset( $trainers[ $id_trainer ] ) ){
									array_push( $trainers_list, $trainers[ $id_trainer ] );
								}
							}
							$instances[ $day ][ $id_instance ][ 'txt_trainers' ][ 'value' ] = implode( ', ', $trainers_list );
						}
					}
				}else if( 'public' == $mode ){
					//get list of classes
					$postmeta_classes = array(
						'_wtr_classes_bg_color',
						'_wtr_classes_font_color',
						'_wtr_classes_lvl'
					);

					$classes = $this->get_posts_extra_data( 'classes', $postmeta_classes, 'category' );

					//get list of rooms
					$rooms = $this->getWpQuery( array( 'post_type' => 'rooms' ), 'public' );

					//get list of trainsers
					$trainers = $this->generateListTrainer( 'public' );

					//merge values
					$copy = $instances;

					foreach( $instances as $day => $day_instances ){
						foreach( $day_instances as $id_instance => $fields ){
							$class	= $instances[ $day ][ $id_instance ][ 'id_classes' ][ 'value' ];
							$room	= $instances[ $day ][ $id_instance ][ 'id_room' ][ 'value' ];

							if( 'wtr_all_items' != $id_class && $id_class != $class ){
								unset( $instances[ $day ][ $id_instance ] );
								unset( $copy[ $day ][ $id_instance ] );
								continue;
							}

							if( 'publish' != $classes[ $class ][ 'post_status' ] ){
								unset( $copy[ $day ][ $id_instance ] );
							}else{
								$copy[ $day ][ $id_instance ][ 'detal_classes' ] = $classes[ $class ];

								$copy[ $day ][ $id_instance ][ 'detal_room' ] = array();
								if( isset( $rooms[ $room ] ) && 'publish' == $rooms[ $room ][ 'post_status' ] ){
									$copy[ $day ][ $id_instance ][ 'detal_room' ] = $rooms[ $room ];
								}

								$trainers_list		= array();
								$id_trainers		= explode( ';', $copy[ $day ][ $id_instance ][ 'trainers' ][ 'value' ] );
								$id_trainers		= array_filter( $id_trainers );

								foreach( $id_trainers as $id_trainer ){
									if( isset( $trainers[ $id_trainer ] ) && 'publish' == $trainers[ $id_trainer ][ 'post_status' ] ){
										$trainers_list[ $id_trainer ] = $trainers[ $id_trainer ];
									}
								}

								$copy[ $day ][ $id_instance ][ 'trainers' ]	= $trainers_list;
								$copy[ $day ][ $id_instance ][ 'id_row' ]	= $id_instance;
							}
						}
					}
					$instances = $copy;
				}
			}
			return $instances;
		}//end get_instance_list


		public function create_calendar_multi_instance( $instance, $fields ){

			global $wpdb;

			//add instance
			$timetable_value	= array(
				'id_timetable'	=> $instance[ 'id_timetable' ],
				'id_scope'		=> $instance[ 'id_scope' ],
				'id_classes'	=> $instance[ 'id_classes' ],
				'date'			=> $instance[ 'date' ]
			);
			$wpdb->insert( $this->table_ap_multi, $timetable_value );

			$current_id = $wpdb->get_var( "SELECT id FROM `{$this->table_ap_multi}` ORDER BY  id  DESC LIMIT 1" );

			//add fields
			foreach ( $fields as $name => $value ) {
				$fields_ap = array(
					'id_scope'		=> $instance[ 'id_scope' ],
					'id_ap_multi'	=> $current_id,
					'field'			=> $name,
					'value'			=> $value,
					'flag'			=> '0'
				);

				$return = $wpdb->insert( $this->table_ap_multi_fields, $fields_ap );
			}
			return array( 'status' => true, 'id_instance' => $current_id );

		}//end create_calendar_instance


		public function create_calendar_static_instance( $instance, $fields ){

			global $wpdb;

			//add instance
			$timetable_value = array(
				'id_timetable'		=> $instance[ 'id_timetable' ],
				'id_classes'		=> $instance[ 'id_classes' ],
				'day_of_the_week'	=> $instance[ 'day_of_the_week' ]
			);
			$wpdb->insert( $this->table_ap_static, $timetable_value );

			$current_id = $wpdb->get_var( "SELECT id FROM `{$this->table_ap_static}` ORDER BY  id  DESC LIMIT 1" );

			//add fields
			foreach ( $fields as $name => $value ) {
				$fields_ap = array(
					'id_ap_static'	=> $current_id,
					'field'			=> $name,
					'value'			=> $value,
					'flag'			=> false
				);
				$return = $wpdb->insert( $this->table_ap_static_fields, $fields_ap );
			}
			return array( 'status' => true, 'id_instance' => $current_id );

		}//end create_calendar_instance


		public function edit_calendar_instance( $type, $id_instance, $data_fields, $data = null ){

			global $wpdb;

			$change = false;

			if( count( $data_fields ) || count( $data ) ){
				$change = true;

				//update scope fields - multi ap
				if( 'multi_week' == $type ){
					foreach( $data_fields as $field => $value ){
						$wpdb->update(
							$this->table_ap_multi_fields,
							array( 'field' => $field, 'value' => $value, 'flag' => 1 ),
							array( 'id_ap_multi' => $id_instance, 'field' => $field )
						);
					}
				}
				else if( 'static' == $type ){
					if( count( $data ) ){
						$wpdb->update(
							$this->table_ap_static,
							$data,
							array( 'id' => $id_instance )
						);
					}

					foreach( $data_fields as $field => $value ){
						$wpdb->update(
							$this->table_ap_static_fields,
							array( 'field' => $field, 'value' => $value, 'flag' => 0 ),
							array( 'id_ap_static' => $id_instance, 'field' => $field )
						);
					}
				}

			}

			return array( 'status' => true, 'change' => $change );
		}//end


		public function delete_instance( $id_instance, $type ){

			global $wpdb;

			if( 'multi_week' == $type ){
				$wpdb->delete( $this->table_ap_multi_fields, array( 'id_ap_multi'=> $id_instance ), array( '%d' ) );
				$wpdb->delete( $this->table_ap_multi, array( 'id'=> $id_instance ), array( '%d' ) );
			}else if( 'static' == $type ){
				$wpdb->delete( $this->table_ap_static_fields, array( 'id_ap_static'=> $id_instance ), array( '%d' ) );
				$wpdb->delete( $this->table_ap_static, array( 'id'=> $id_instance ), array( '%d' ) );
			}

			return true;
		}//end delete_instance


		// == EVENTS

		private function get_list_events( $result, $scope, $day_t = null ){

			global $wpdb;

			$events_data	= array();
			$events_tmp		= array();

			if( 'NN' == $result[ 'gym_id' ] || 'publish' != get_post_status( $result[ 'gym_id' ] ) ){
				$gym = 'wtr_all_items';
			}else{
				$gym = $result[ 'gym_id' ];
			}

			// get id events from scope

			if( $day_t ){
				$results = $wpdb->get_results( "
					SELECT `w`.ID, `w`.post_title, `m`.meta_key, `m`.meta_value
					FROM {$wpdb->posts} w INNER JOIN {$wpdb->postmeta} m ON w.ID = m.post_id
					WHERE w.post_status = 'publish' AND w.ID IN(
						SELECT post_id FROM {$wpdb->postmeta}
						WHERE
							meta_key = '_wtr_event_date' AND meta_value = STR_TO_DATE('{$day_t}', '%Y-%m-%d')
					)",
					'ARRAY_A'
				);
			}else{
				$results = $wpdb->get_results( "
					SELECT `w`.ID, `w`.post_title, `m`.meta_key, `m`.meta_value
					FROM {$wpdb->posts} w INNER JOIN {$wpdb->postmeta} m ON w.ID = m.post_id
					WHERE w.post_status = 'publish' AND w.ID IN(
						SELECT post_id FROM {$wpdb->postmeta}
						WHERE
							meta_key = '_wtr_event_date' AND meta_value >= STR_TO_DATE('{$scope[ 'days_f' ][ 0 ]}', '%Y-%m-%d')
							AND
							meta_value <=  STR_TO_DATE('{$scope[ 'days_f' ][ 6 ]}', '%Y-%m-%d')
					)",
					'ARRAY_A'
				);
			}

			$results_c	= count( $results );

			//prepare data
			for( $i = 0; $i < $results_c; $i++ ){
				$events_tmp[ $results[ $i ][ 'ID' ] ]['title'] = $results[ $i ][ 'post_title' ];
				if( '_wtr_gym_location' != $results[ $i ][ 'meta_key' ] ){
					$events_tmp[ $results[ $i ][ 'ID' ] ][ $results[ $i ][ 'meta_key' ] ] = $results[ $i ][ 'meta_value' ];
				}else{
					if( 'a:0:{}' != $results[ $i ][ 'meta_value' ] ){
						$events_tmp[ $results[ $i ][ 'ID' ] ][ '_wtr_gym_location' ][ $results[ $i ][ 'meta_value' ] ] = $results[ $i ][ 'meta_value' ];
					}
				}
			}

			foreach( $events_tmp as $id_event => $data ){

				//remove unnecessary events
				if( 'wtr_all_items' != $gym ){
					if( isset( $data[ '_wtr_gym_location' ][ $gym ] ) ){
						$events_data[ $id_event ] = $data;
						if( $day_t ){
							$events_data[ $id_event ]			= $data;
							$events_data[ $id_event ][ 'day' ]	= current_time( 'N' ) - 1;
						}else{
							$events_data[ $id_event ]			= $data;
							$events_data[ $id_event ][ 'day' ]	= $scope[ 'days' ][ $data[ '_wtr_event_date' ] ];
						}
					}
				}
				else{
					if( $day_t ){
						$events_data[ $id_event ]			= $data;
						$events_data[ $id_event ][ 'day' ]	= current_time( 'N' ) - 1;
					}else{
						$events_data[ $id_event ]			= $data;
						$events_data[ $id_event ][ 'day' ]	= $scope[ 'days' ][ $data[ '_wtr_event_date' ] ];
					}
				}
			}

			return $events_data;
		}//end get_list_events
	}//end WTR_Cs_db
}