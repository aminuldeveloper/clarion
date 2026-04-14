<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package Clarion
 * @since   1.0.0
 */

get_header();
?>

<div class="site-content-area container">
	<div class="content-sidebar-wrap">

		<main id="primary" class="site-main">

			<section class="error-404 not-found">
				<header class="page-header">
					<h1 class="page-title"><?php esc_html_e( '404', 'clarion' ); ?></h1>
					<p class="error-404__subtitle"><?php esc_html_e( 'Page Not Found', 'clarion' ); ?></p>
				</header><!-- .page-header -->

				<div class="page-content">
					<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try a search?', 'clarion' ); ?></p>

					<?php get_search_form(); ?>

					<?php
					$recent_posts = new WP_Query(
						array(
							'posts_per_page'      => 5,
							'no_found_rows'       => true,
							'ignore_sticky_posts' => true,
						)
					);
					if ( $recent_posts->have_posts() ) :
						?>
						<h2 class="error-404__section-title"><?php esc_html_e( 'Recent Posts', 'clarion' ); ?></h2>
						<ul class="error-404__recent-posts">
							<?php while ( $recent_posts->have_posts() ) : $recent_posts->the_post(); ?>
								<li>
									<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
								</li>
							<?php endwhile; ?>
						</ul>
						<?php wp_reset_postdata(); ?>
					<?php endif; ?>

				</div><!-- .page-content -->
			</section><!-- .error-404 -->

		</main><!-- #primary -->

		<?php get_sidebar(); ?>

	</div><!-- .content-sidebar-wrap -->
</div><!-- .container -->

<?php get_footer(); ?>
