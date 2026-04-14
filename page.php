<?php
/**
 * The template for displaying all pages
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

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'template-parts/content/content', 'page' ); ?>

				<?php
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;
				?>

			<?php endwhile; ?>

		</main><!-- #primary -->

		<?php get_sidebar(); ?>

	</div><!-- .content-sidebar-wrap -->
</div><!-- .container -->

<?php get_footer(); ?>
