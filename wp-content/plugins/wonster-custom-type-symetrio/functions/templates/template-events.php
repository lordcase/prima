<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

get_header();
global $post_settings;?>
<?php
$page			= get_query_var( 'paged' ) ? get_query_var( 'paged' ) : get_query_var( 'page' );
$page_url		= get_permalink();
$current_url	= add_query_arg( 'event-order', 'current',$page_url);
$outdated_url	= add_query_arg( 'event-order', 'outdated',$page_url);
$posts_per_page	= $post_settings['wtr_EventPostNumber'];
$date_format	= $post_settings['wtr_EventDateFormat'];
$meta_query		= array();

//ALL
if( 0 == $post_settings['wtr_EventPostReviewType'] ){
	$order			= 'DESC';
//Split
}else {

	if( ! isset( $_GET['event-order'] ) OR  'current' == $_GET['event-order'] ){
		$current_class	= 'class="active"';
		$outdated_class	= '';
		$compare		= '>=';
		$order			= 'ASC';
	} else {
		$current_class	= '';
		$outdated_class	= 'class="active"';
		$compare		= '<';
		$order			= 'DESC';
	}

	$meta_query = array(
		array(
			'key'		=> '_wtr_event_time_end',
			'value'		=> current_time( "timestamp" ),
			'compare'	=> $compare,
		)
	);
}
$args = array(
	'ignore_sticky_posts'	=> 1,
	'posts_per_page'		=> $posts_per_page,
	'post_type'				=> 'events',
	'paged'					=> $page,
	'order'					=> $order,
	'orderby'				=> 'meta_value',
	'meta_key'				=> '_wtr_event_time_start',
	'meta_query'			=> $meta_query
);
query_posts( $args );

?>
<?php get_header(); ?>

		<main class="wtrMainContent">

			<div class="wtrContainer wtrContainerColor wtrPost wtrPage ">
				<div class="wtrInner clearfix">
					<section class="wtrContentCol <?php echo $post_settings['wtr_ContentInClass']['content']; ?> wtrEventStream clearfix">

						<div class="wtrEventStreamContainer clearfix">
							<?php if( 1 == $post_settings['wtr_EventPostReviewType'] ) : ?>
								<div class="wtrEventStreamHeadline clearfix">
									<div class="wtrColOneTwo wtrHeadlineElement big"><?php echo $post_settings['wtr_TranslateEventSelectEvent']; ?></div>
									<div class="wtrColOneTwo wtrLastCol wtrEventSelector">
										<ul class="wtrEventCategoryList">
											<li class="wtrEventCategoryItem"><a <?php echo $current_class; ?> href="<?php echo esc_url( $current_url ); ?>"><?php echo $post_settings['wtr_TranslateEventCurrent']; ?></a></li>
											<li class="wtrEventCategoryItem"><a <?php echo $outdated_class; ?> href="<?php echo esc_url( $outdated_url ); ?>"><?php echo $post_settings['wtr_TranslateEventOutdated']; ?></a></li>
										</ul>
									</div>
								</div>
							<?php endif; ?>

							<?php if (have_posts()) : ?>
								<?php while (have_posts()) : the_post(); ?>
									<?php
									$id					= get_the_id();
									$url				= esc_url( get_permalink() );
									$title				= get_the_title();
									$thumbnail			= get_post_meta( $id, '_wtr_event_covera_img_stream', true );
									$thumbnail_alt		= esc_attr( get_post_meta( $thumbnail, '_wp_attachment_image_alt', true ) );
									$thumbnail			= wp_get_attachment_image_src( $thumbnail, 'size_4' );
									$thumbnail			= $thumbnail[0];
									$class				= ( $thumbnail ) ? '' : ' wtrAnimate wtrEventStreamItemNoPhoto ';
									$time_start			= get_post_meta( $id, '_wtr_event_time_start', true );
									$time_start_type	= get_post_meta( $id, '_wtr_event_time_start_type', true );
									$time_start_type	= ( 0 == $time_start_type ) ? '' : '<span>'. date( 'a', $time_start ) . '</span>';
									$time_start_h_type	= ( $time_start_type ) ? 'h' : 'H';
									$time_start_h_m		= date( $time_start_h_type . ':i', $time_start );
									$time_end			= get_post_meta( $id, '_wtr_event_time_end', true );
									$time_end_type		= get_post_meta( $id, '_wtr_event_time_end_type', true );
									$time_end_type		= ( 0 == $time_end_type ) ? '' : '<span>'. date( 'a', $time_end ) . '</span>';
									$time_end_h_type	= ( $time_end_type ) ? 'h' : 'H';
									$time_end_h_m		= date( $time_end_h_type . ':i', $time_end );
									$date				= date_i18n( $date_format['all'] , $time_start );
									$price				= get_post_meta( $id, '_wtr_event_price', true );
									?>
									<div class="wtrEventStreamItem <?php echo $class; ?>wtrRadius3">
										<div class="wtrEventStreamItemContainer">
											<div class="wtrEventStreamItemHeadlineContainer wtrRadius3">
												<h2 class="wtrEventStreamItemTitle wtrDefHedlineLinkColor"><a href="<?php echo $url ?>"><?php echo $title; ?></a></h2>
											</div>
											<div class="wtrEventStreamItemMetaContainer wtrRadius3">
												<ul class="wtrEventStreamItemMetaList clearfix">
													<li>
														<div class="wtrEventStreamItemMetaDate">
															<i class="fa fa-clock-o"></i>
															<span><?php echo $date ?></span>
														</div>
													</li>
													<li>
														<div class="wtrEventStreamItemMetaTime">
															<?php echo $time_start_h_m . ' ' . $time_start_type; ?> - <?php echo $time_end_h_m . ' ' . $time_end_type; ?>
														</div>
													</li>
													<?php if( $price ) : ?>
														<li>
															<div class="wtrEventStreamItemPrice wtrRadius2"><?php echo $price; ?></div>
														</li>
													<?php endif; ?>
												</ul>
											</div>
											<a href="<?php echo $url; ?>">
												<?php if( $thumbnail ) : ?>
													<span class="wtrPostOverlay wtrHoverdPostBoxAnimation wtrRadius3"></span>
													<img class="wtrEventStreamItemPic wtrRadius3" alt="<?php echo $thumbnail_alt; ?>" src="<?php echo $thumbnail; ?>">
												<?php endif;?>
												<span class="wtrEventStreamItemNoPhotoLink"></span>
											</a>
										</div>
									</div>
								<?php endwhile; ?>
							<?php else : ?>
								<div class="wtrNoItemStream wtrRadius3">
									<h6 class="wtrNoItemStreamHeadline">
										<?php echo $post_settings['wtr_TranslateEventNoItems']; ?>
									</h6>
								</div>
							<?php endif;?>
						</div>
						<?php echo wtr_pagination(); ?>
						<?php wp_reset_query();?>
					</section>
					<?php get_sidebar(); ?>
				</div>
			</div>
		</main>
<?php get_footer(); ?>