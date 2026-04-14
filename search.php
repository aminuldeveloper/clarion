<?php
/**
 * The template for displaying search results pages
 *
 * @package Clarion
 * @since   1.0.0
 */

get_header();
?>

<div class="site-content-area container">
	<div class="content-sidebar-wrap">

		<main id="primary" class="site-main">

			<?php clarion_breadcrumbs(); ?>

			<?php if ( have_posts() ) : ?>

				<header class="page-header">
					<h1 class="page-title">
						<?php
						printf(
							/* translators: %s: search query. */
							esc_html__( 'Search Results for: %s', 'clarion' ),
							'<span>' . esc_html( get_search_query() ) . '</span>'
						);
						?>
					</h1>
				</header><!-- .page-header -->

				<div class="posts-grid">
					<?php while ( have_posts() ) : the_post(); ?>
						<?php get_template_part( 'template-parts/content/content', 'search' ); ?>
					<?php endwhile; ?>
				</div><!-- .posts-grid -->

				<?php the_posts_navigation(); ?>

			<?php else : ?>

				<?php get_template_part( 'template-parts/content/content', 'none' ); ?>

			<?php endif; ?>

		</main><!-- #primary -->

		<?php get_sidebar(); ?>

	</div><!-- .content-sidebar-wrap -->
</div><!-- .container -->

<?php get_footer(); ?>
