<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

get_header();
global $post_settings, $wp_query;
?>
	<main class="wtrMainContent">
		<div class="wtrContainer wtrContainerColor wtrPost wtrPage">
			<div class="wtrInner clearfix">
				<section class="wtrContentCol <?php echo $post_settings['wtr_ContentInClass']['content']; ?> wtrSearchResults clearfix">
					<div class="wtrPageContent clearfix">
						<?php if ( have_posts() ) : ?>
							<ul class="wtrSearchResultsList">
								<?php while ( have_posts() ) : the_post(); ?>
									<?php $current_id	= ( empty( $paged ) ) ? ( $wp_query->current_post + 1 ) : ( $wp_query->current_post + 1 ) + get_query_var( 'posts_per_page' ) * $paged - 1 ; ?>
									<?php $url			= esc_url( get_permalink() )?>
									<li class="wtrSearchResultItem">
										<header>
											<span class="wtrSearchResultItemCounter wtrDefBgColor wtrAnimate wtrRadius2"><?php echo $current_id; ?></span>
											<h2 class="wtrSearchResultItemHeadline wtrDefHedlineLinkColor"><a class="" href="<?php echo $url; ?>"><?php echo get_the_title(); ?></a></h2>
											<div class="wtrSearchResultMeta">
												<ul class="wtrSearchResultMetaList">
													<li class="wtrSearchResultItemDate">
														<div class=""><?php echo get_the_time( $post_settings['wtr_BlogDateFormat']['all'] ); ?></div>
													</li>
												</ul>
											</div>
										</header>
									</li>
								<?php endwhile; ?>
							</ul>
						<?php endif ?>
					</div>
					<?php echo wtr_pagination(); ?>
				</section>
				<?php get_sidebar();?>
			</div>
		</div>
	</main>
<?php get_footer(); ?>