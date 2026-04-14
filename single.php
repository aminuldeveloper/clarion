<?php
/**
 * The template for displaying all single posts
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

				<?php get_template_part( 'template-parts/content/content', 'single' ); ?>

				<?php clarion_author_bio(); ?>

				<?php clarion_related_posts(); ?>

				<?php
				if ( get_theme_mod( 'clarion_show_post_nav', true ) ) :
					the_post_navigation(
						array(
							'prev_text' => '<span class="nav-direction">' . esc_html__( 'Previous Post', 'clarion' ) . '</span><span class="nav-title">%title</span>',
							'next_text' => '<span class="nav-direction">' . esc_html__( 'Next Post', 'clarion' ) . '</span><span class="nav-title">%title</span>',
						)
					);
				endif;
				?>

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
