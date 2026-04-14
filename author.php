<?php
/**
 * The template for displaying author archive pages
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

				<?php $author = get_queried_object(); ?>

				<header class="page-header archive-header author-header">
					<div class="author-archive-profile">
						<?php echo get_avatar( $author->ID, 96, '', esc_attr( $author->display_name ), array( 'class' => 'author-archive-avatar' ) ); ?>
						<div class="author-archive-info">
							<span class="archive-label"><?php esc_html_e( 'Author', 'clarion' ); ?></span>
							<h1 class="page-title"><?php echo esc_html( $author->display_name ); ?></h1>
							<?php if ( $author->description ) : ?>
								<p class="author-archive-bio"><?php echo wp_kses_post( $author->description ); ?></p>
							<?php endif; ?>
						</div>
					</div>
				</header><!-- .page-header -->

				<div class="posts-grid">
					<?php while ( have_posts() ) : the_post(); ?>
						<?php get_template_part( 'template-parts/content/content', get_post_format() ); ?>
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
