<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

$wtr_date_format = array(
1 => array( 'sample' => '20.10.2013', 'date_d'=> 'd', 'date_m' => 'm', 'date_y' => 'Y' , 'all'=> 'd.m.Y', 'order' => '[d] [m] [y]', 'separator' => '.' ),
2 => array( 'sample' => '20/10/2013', 'date_d'=> 'd', 'date_m' => 'm', 'date_y' => 'Y' , 'all'=> 'd/m/Y', 'order' => '[d] [m] [y]', 'separator' => '/' ),
3 => array( 'sample' => '10.2013', 'date_d'=> '', 'date_m' => 'm', 'date_y' => 'Y' , 'all'=> 'm.Y', 'order' => '[m] [y]', 'separator' => '.' ),
4 => array( 'sample' => '10/2013', 'date_d'=> '', 'date_m' => 'm', 'date_y' => 'Y' , 'all'=> 'm/Y', 'order' => '[m] [y]', 'separator' => '/' ),
5 => array( 'sample' => '10.20.2013', 'date_d'=> 'd', 'date_m' => 'm', 'date_y' => 'Y' , 'all'=> 'm.d.Y', 'order' => '[m] [d] [y]', 'separator' => '.' ),
6 => array( 'sample' => '10/20/2013', 'date_d'=> 'd', 'date_m' => 'm', 'date_y' => 'Y' , 'all'=> 'm/d/Y', 'order' => '[m] [d] [y]', 'separator' => '/' ),
7 => array( 'sample' => '20 October 2013', 'date_d'=> 'd', 'date_m' => 'F', 'date_y' => 'Y' , 'all'=> 'd F Y', 'order' => '[d] [m] [y]', 'separator' => ' ' ),
8 => array( 'sample' => 'October 20 2013', 'date_d'=> 'd', 'date_m' => 'F', 'date_y' => 'Y' , 'all'=> 'F d Y', 'order' => '[m] [d] [y]', 'separator' => ' ' ),
9 => array( 'sample' => '20 OCT 2013', 'date_d'=> 'd', 'date_m' => 'M', 'date_y' => 'Y' , 'all'=> 'd M Y', 'order' => '[d] [m] [y]', 'separator' => ' ' ),
10 => array( 'sample' => 'OCT 20 2013', 'date_d'=> 'd', 'date_m' => 'M', 'date_y' => 'Y' , 'all'=> 'M d Y', 'order' => '[m] [d] [y]', 'separator' => ' ' ),
);

$wtr_date_format_field = array();
foreach( $wtr_date_format as $key => $value ){
	$wtr_date_format_field[ $key ] = $value['sample'];
}