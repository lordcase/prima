<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

get_header();
global $post_settings;
?>
	<main class="wtrMainContent wtrModernBlogPost">
		<div class="wtrContainer wtrContainerColor wtrPost wtrPage wtr404">
			<div class="wtrInner clearfix">
				<section class="wtrContentCol wtrContentNoSidebar clearfix">
					<div class="wtrPageContent clearfix">
						<div class="wtrColOneTwo wtr404container clearfix">
							<h2 class="wtr404Headline wtr404HeadlineColor">4O4</h2>
							<?php if( $post_settings['wtr_Translate404After404'] ) : ?>
								<h6 class="wtr404SiteName wtr404HeadlineColor"><?php echo $post_settings['wtr_Translate404After404']; ?></h6>
							<?php endif; ?>
							<?php if( $post_settings['wtr_Translate404TextBelow404'] ) : ?>
								<div class="wtr404Slug"><?php echo $post_settings['wtr_Translate404TextBelow404'];?> </div>
							<?php endif; ?>
							<?php if( $post_settings['wtr_Translate404ButtonLabel'] ) : ?>
								<a href="<?php echo esc_url( home_url() );?>" class="wtrButtonTrRad wtr404ButtonColors wtrButtonAnim"><?php echo $post_settings['wtr_Translate404ButtonLabel']; ?></a>
							<?php endif; ?>
						</div>
					</div>
				</section>
			</div>
		</div>
		<div class="wtrContainer wtrContainerColor wtrPost wtrPage ">
			<div class="wtrInner clearfix">
				<section class="wtrContentCol wtrContentNoSidebar clearfix">
					<div class="wtrPageContent clearfix">
						<div class="wtrColOneThird wtr404ElementCol">
							<?php if( $post_settings['wtr_Translate404Section_1_title'] ) : ?>
								<div class="wtrHeadlineElement big wtrHedlineColor"><?php echo $post_settings['wtr_Translate404Section_1_title']; ?></div>
							<?php endif; ?>
							<div class="wtrSearchResultsFraze">
								<?php echo wtr_search_form( 'screen-reader-text', 'searchform wtrSearchFormAlter', false, true ); ?>
							</div>
						</div>
						<div class="wtrColOneThird wtr404ElementCol">
							<?php if( $post_settings['wtr_Translate404Section_2_title'] ) : ?>
								<div class="wtrHeadlineElement big wtrHedlineColor"><?php echo $post_settings['wtr_Translate404Section_2_title']; ?></div>
							<?php endif; ?>
							<?php if( $post_settings['wtr_Translate404Section_2_desc'] ) : ?>
								<p><?php echo $post_settings['wtr_Translate404Section_2_desc']; ?></p>
							<?php endif; ?>
						</div>

						<div class="wtrColOneThird wtr404ElementCol wtrLastCol">
							<?php if( $post_settings['wtr_Translate404Section_3_title'] ) : ?>
								<div class="wtrHeadlineElement big wtrHedlineColor"><?php echo $post_settings['wtr_Translate404Section_3_title']; ?></div>
							<?php endif; ?>
							<?php if( $post_settings['wtr_Translate404Section_3_desc'] ) : ?>
								<p><?php echo $post_settings['wtr_Translate404Section_3_desc']; ?></p>
							<?php endif; ?>
						</div>
					</div>
				</section>
			</div>
		</div>
	</main>
<?php get_footer(); ?>