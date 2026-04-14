<?php
/**
 * The template for displaying archive pages
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

				<header class="page-header archive-header">
					<?php
					$archive_label = clarion_get_archive_label();
					if ( $archive_label ) :
						echo '<span class="archive-label">' . esc_html( $archive_label ) . '</span>';
					endif;
					?>
					<h1 class="page-title archive-title"><?php echo esc_html( clarion_get_archive_title() ); ?></h1>
					<?php
					$archive_description = get_the_archive_description();
					if ( $archive_description ) :
						?>
						<div class="archive-description"><?php echo wp_kses_post( $archive_description ); ?></div>
					<?php endif; ?>
				</header><!-- .page-header -->

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
