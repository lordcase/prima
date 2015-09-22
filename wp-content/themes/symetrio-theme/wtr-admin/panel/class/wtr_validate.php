<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

if ( ! class_exists( 'WTR_Validate' ) ) {

	class WTR_Validate {

		static public  function check( $type, $value, $max = NULL, $min = NULL, $has_attr  = NULL ) {

			if( is_array( $type ) ) {
				return in_array( $value, $type );
			} else {
				switch ( $type ) {

					case 'int':
						$tmp = filter_var( $value , FILTER_VALIDATE_INT );
						return ( $tmp OR 0 === $tmp );
						break;

					case 'between':
						if( NULL == $max AND NULL == $min ){
							return 	true;
						}

						if( $has_attr ){

							$tmp2 = explode( $has_attr , $value );
							if( ! is_array( $tmp2 ) ){
								return false;
							}

							$value = $tmp2[ 0 ];
						}

						$tmp = filter_var( $value , FILTER_VALIDATE_INT );

						if( !( $tmp OR 0 === $tmp ) ){
							return false;
						}

						return ( $max >=  $value  AND $min <= $value );
						break;

					case 'unsigned_int':
						$tmp = filter_var( $value , FILTER_VALIDATE_INT );
						return ( ( $tmp OR 0 === $tmp ) AND  $tmp >= 0 );
						break;

					case 'decimal':
						$tmp = filter_var( $value , FILTER_VALIDATE_FLOAT );
						return ( $tmp OR 0 === $tmp OR 0.0 === $tmp );
						break;

					case 'color':
						return preg_match('/^#[A-Fa-f0-9]{6}$/i', $value );
						break;

					case 'email':
						return preg_match ( '/^([a-z0-9])(([-a-z0-9._])*([a-z0-9]))*\@([a-z0-9])' .'(([a-z0-9-])*([a-z0-9]))+' . '(\.([a-z0-9])([-a-z0-9_-])?([a-z0-9])+)+$/i', $value );
						break;

					case 'date_time':
						if (preg_match("/^(\d{4})-(\d{2})-(\d{2}) ([01][0-9]|2[0-3]):([0-5][0-9])$/", $date, $matches)) {
							if (checkdate($matches[2], $matches[3], $matches[1])) {
								return true;
							}
						}
						return false;
					break;

					case 'all':
						return true;
						break;

					default:
						return false;
						break;
				}
			}
		}
	};// ednd WTR_Validate
}