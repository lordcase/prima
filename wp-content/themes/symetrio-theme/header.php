<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */
global $post_settings; ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<title><?php wp_title( '', true ); ?></title>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1"/>
	<meta name="format-detection" content="telephone=no">
	<?php wtr_favicon() ?>

	<?php wp_head(); ?>
</head>
<body <?php body_class( 'body' ); ?>>
<?php wtr_loader()?>
<div class="container">
	<div class="mp-pusher <?php echo $post_settings['wtr_HeaderPusherClass']; ?>" id="mp-pusher">
		<?php do_action('wtr_header'); ?>