<?php
/**
 * Template part for displaying posts in the blog loop
 *
 * @package Clarion
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-card' ); ?>>

	<?php clarion_post_thumbnail( 'clarion-card' ); ?>

	<div class="post-card__body">

		<div class="post-card__meta">
			<?php clarion_category_list(); ?>
			<?php clarion_reading_time(); ?>
		</div>

		<header class="post-card__header">
			<?php the_title( '<h2 class="post-card__title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
		</header>

		<div class="post-card__excerpt">
			<?php the_excerpt(); ?>
		</div>

		<footer class="post-card__footer">
			<div class="post-card__author-date">
				<?php clarion_posted_on(); ?>
				<?php clarion_posted_by(); ?>
			</div>
			<a class="post-card__read-more" href="<?php echo esc_url( get_permalink() ); ?>" aria-label="<?php echo esc_attr( sprintf( __( 'Read more: %s', 'clarion' ), get_the_title() ) ); ?>">
				<?php esc_html_e( 'Read More', 'clarion' ); ?>
				<span aria-hidden="true">&rarr;</span>
			</a>
		</footer>

	</div><!-- .post-card__body -->

</article><!-- #post-<?php the_ID(); ?> -->
