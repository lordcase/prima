<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

get_header();

global $post_settings;
$post		= get_post( $post );
$label		= 'pwbox-' . ( empty($post->ID) ? rand() : $post->ID );
?>

	<main class="wtrMainContent">
		<div class="wtrContainer wtrContainerColor wtrProtectedContent wtrPost wtrPage">
			<div class="wtrInner clearfix">
				<section class="wtrContentCol wtrContentNoSidebar clearfix">
					<div class="wtrPageContent clearfix">
						<div class="wtrColOneTwo wtrProtectedElements">
							<div class="wtrHeadlineElement big wtrHedlineColor">
								<?php echo $post_settings['wtr_TranslateHomePasswordText'] ?>;
							</div>
							<form action="<?php echo esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ); ?>" class="post-password-form" method="post">
								<div class="wtrPassProtectedContent clearfix">
									<div class="wtrColTwoThird">
										<label>
											<input name="post_password" id="<?php echo $label; ?>" type="password" size="20">
										</label>
									</div>
									<div class="wtrColOneThird wtrLastCol">
										<input type="submit" name="Submit" value="<?php echo esc_attr( $post_settings['wtr_TranslateHomePasswordlabelSubmit']); ?>">
									</div>
								</div>
							</form>
							<div class="wtrProtectedFormFoot">
								<p><?php echo $post_settings['wtr_TranslateHomePasswordText2']; ?></p>
							</div>
						</div>
					</div>
				</section>
			</div>
		</div>
	</main>
<?php get_footer(); ?>