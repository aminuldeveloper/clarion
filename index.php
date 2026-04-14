<?php
/**
 * The main template file
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

				<?php if ( is_home() && ! is_front_page() ) : ?>
					<header class="page-header">
						<h1 class="page-title"><?php single_post_title(); ?></h1>
					</header>
				<?php endif; ?>

				<div class="posts-grid">
					<?php while ( have_posts() ) : the_post(); ?>
						<?php get_template_part( 'template-parts/content/content', get_post_format() ); ?>
					<?php endwhile; ?>
				</div><!-- .posts-grid -->

				<?php the_posts_navigation(
					array(
						'prev_text'          => '<span class="nav-subtitle">' . esc_html__( 'Older posts', 'clarion' ) . '</span>',
						'next_text'          => '<span class="nav-subtitle">' . esc_html__( 'Newer posts', 'clarion' ) . '</span>',
						'screen_reader_text' => esc_html__( 'Posts navigation', 'clarion' ),
					)
				); ?>

			<?php else : ?>

				<?php get_template_part( 'template-parts/content/content', 'none' ); ?>

			<?php endif; ?>

		</main><!-- #primary -->

		<?php get_sidebar(); ?>

	</div><!-- .content-sidebar-wrap -->
</div><!-- .container -->

<?php get_footer(); ?>
