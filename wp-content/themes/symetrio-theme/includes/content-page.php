<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

global $post_settings; ?>

<section class="wtrContentCol <?php echo $post_settings['wtr_ContentInClass']['content']; ?> clearfix">
	<div class="wtrPageContent clearfix">
		<?php the_content(); ?>
		<?php wtr_wp_link_pages(); ?>
	</div>
	<?php comments_template(); ?>
</section>