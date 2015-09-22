<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

// LOAD LIBS

// # wp
include_once '../get_wp.php';

if( ! is_user_logged_in() OR ! isset( $_GET[ 'wtr_sht_id_data' ] ) ) {
	return ;
}

$wtr_sht_id_data	= strip_tags( trim( $_GET[ 'wtr_sht_id_data' ] ) );
$wtr_sht			= get_transient( $wtr_sht_id_data );

delete_transient( $wtr_sht_id_data );


wtr_public_settings();
$sht			= stripslashes( urldecode( $wtr_sht ) );
$sht_ready		= apply_filters( 'the_content', $sht );

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>" type="text/css" media="screen" />
	<?php wp_head(); ?>
</head>

<body style="background:#fff;">
	<div class="postInside" style="margin-right:10px;">
			<?php echo $sht_ready ?>
	</div>
	<?php wp_footer(); ?>
</body>
</html>