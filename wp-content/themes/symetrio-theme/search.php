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
						<div class="wtrSearchResultsContainer">
							<div class="wtrSearchResultsHeadline">
								<div class="wtrHeadlineElement big wtrHedlineColor">
									<?php echo $found_items = $wp_query->found_posts . ' ' . $post_settings['wtr_TranslateSearchFormSearchResultFor']; ?>
								</div>
								<div class="wtrSearchResultsFraze"><?php echo get_search_query(); ?></div>
							</div>
						</div>
						<?php if (have_posts()) : ?>
							<ul class="wtrSearchResultsList">
								<?php while ( have_posts() ) : the_post(); ?>
									<?php $current_id	= ( empty( $paged ) ) ? ( $wp_query->current_post + 1 ) : ( $wp_query->current_post + 1 ) + get_query_var( 'posts_per_page' ) * $paged - 1 ; ?>
									<?php $post_type	= ( isset( $post_settings[ 'wtr_TranslateSearchFormSearchPostType_' . get_post_type() ] ) ) ? $post_settings[ 'wtr_TranslateSearchFormSearchPostType_' . get_post_type() ] : __( get_post_type(), WTR_THEME_NAME );?>
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
													<li class="wtrSearchResultItemType"> <?php  echo $post_settings[ 'wtr_TranslateSearchFormSearchPostType']; ?> <?php echo $post_type; ?></li>
													<li class="wtrSearchResultItemAuthor"><?php echo $post_settings['wtr_TranslateSearchFormSearchByAuthor']; ?> <a class="wtrDefBorderLink" href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php the_author_meta( 'display_name' ); ?></a></li>
													<?php if( ( 'post' == get_post_type() OR 'page' == get_post_type() ) AND ! post_password_required() AND ( comments_open() OR  0 != get_comments_number() ) ) : ?>
														<li class="wtrSearchResultItemComments"> <?php echo wtr_comments_number( "wtrDefBorderLink", get_the_id(), 'search' ); ?></li>
													<?php endif; ?>
												</ul>
											</div>
										</header>
									</li>
								<?php endwhile; ?>
							</ul>
						<?php else : ?>
							<div class="wtrNoItemStream wtrRadius3">
								<h6 class="wtrNoItemStreamHeadline">
									<?php echo $post_settings['wtr_TranslateSearchFormSectionNoresultsTitle']; ?>
								</h6>
							</div>
						<?php endif ?>


						<div class="wtrSearchResultsFootline clearfix">
							<div class="wtrColOneTwo">
								<div class="wtrHeadlineElement big wtrHedlineColor">
									<?php echo $post_settings['wtr_TranslateSearchFormNewSearch']; ?>
								</div>
								<div class="wtrSearchResultsFraze">
									<?php echo wtr_search_form( 'screen-reader-text', 'searchform wtrSearchFormAlter', false, true ); ?>
								</div>
							</div>
						</div>
					</div>
					<?php echo wtr_pagination(); ?>
				</section>
				<?php get_sidebar();?>
			</div>
		</div>
	</main>
<?php get_footer(); ?>