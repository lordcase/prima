<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

global $post_settings; ?>

<section class="wtrContentCol wtrContentNoSidebar clearfix">
	<div class="wtrPageContent clearfix">
		<?php
		$type = get_post_mime_type(get_the_ID());
		switch ($type) {
			case 'image/jpeg':
			case 'image/png':
			case 'image/gif':
				the_content();
			break;

			case 'video/mpeg':
			case 'video/mp4':
			case 'video/quicktime':
				echo '<p>'. do_shortcode( '[video src="' . wp_get_attachment_url( get_the_ID() ) . '"]</p>' );
				echo '<p>' . get_the_content() . '</p>';
			break;

			default:
				the_content();
			break;
		}
		?>
	</div>
</section>