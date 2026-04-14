<?php
/**
 * Custom template tags for Luminary
 *
 * @package Clarion
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Prints HTML with meta information for the current post-date/time.
 */
function clarion_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated screen-reader-text" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf(
		$time_string,
		esc_attr( get_the_date( DATE_W3C ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( DATE_W3C ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = sprintf(
		/* translators: %s: post date. */
		esc_html_x( 'Posted on %s', 'post date', 'clarion' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);

	echo '<span class="posted-on">' . $posted_on . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

/**
 * Prints HTML with meta information for the current author.
 */
function clarion_posted_by() {
	$byline = sprintf(
		/* translators: %s: post author. */
		esc_html_x( 'by %s', 'post author', 'clarion' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);

	echo '<span class="byline"> ' . $byline . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

/**
 * Prints estimated reading time for the current post.
 */
function clarion_reading_time() {
	if ( ! get_theme_mod( 'clarion_show_reading_time', true ) ) {
		return;
	}

	$content    = get_post_field( 'post_content', get_the_ID() );
	$word_count = str_word_count( wp_strip_all_tags( $content ) );
	$minutes    = (int) ceil( $word_count / 200 );

	if ( $minutes < 1 ) {
		$minutes = 1;
	}

	printf(
		'<span class="reading-time">%s</span>',
		sprintf(
			/* translators: %d: reading time in minutes. */
			esc_html( _n( '%d min read', '%d min read', $minutes, 'clarion' ) ),
			absint( $minutes )
		)
	);
}

/**
 * Prints the post thumbnail with lazy loading.
 *
 * @param string $size Image size.
 * @param array  $attr Additional attributes.
 */
function clarion_post_thumbnail( $size = 'clarion-card', $attr = array() ) {
	if ( ! has_post_thumbnail() ) {
		return;
	}

	$default_attr = array(
		'loading' => 'lazy',
		'class'   => 'post-thumbnail-img',
	);

	$attr = wp_parse_args( $attr, $default_attr );

	echo '<figure class="post-thumbnail">';
	if ( is_singular() ) {
		the_post_thumbnail( $size, $attr );
	} else {
		echo '<a href="' . esc_url( get_permalink() ) . '" aria-hidden="true" tabindex="-1">';
		the_post_thumbnail( $size, $attr );
		echo '</a>';
	}
	echo '</figure>';
}

/**
 * Prints a linked list of categories for the current post.
 */
function clarion_category_list() {
	$categories = get_the_category();
	if ( empty( $categories ) ) {
		return;
	}

	echo '<ul class="cat-list">';
	foreach ( $categories as $category ) {
		echo '<li class="cat-item"><a href="' . esc_url( get_category_link( $category->term_id ) ) . '">' . esc_html( $category->name ) . '</a></li>';
	}
	echo '</ul>';
}

/**
 * Prints a linked list of tags for the current post.
 */
function clarion_tag_list() {
	$tags = get_the_tags();
	if ( empty( $tags ) ) {
		return;
	}

	echo '<ul class="tag-list">';
	foreach ( $tags as $tag ) {
		echo '<li class="tag-item"><a href="' . esc_url( get_tag_link( $tag->term_id ) ) . '" rel="tag">' . esc_html( $tag->name ) . '</a></li>';
	}
	echo '</ul>';
}

/**
 * Prints the author bio box for single posts.
 */
function clarion_author_bio() {
	if ( ! get_theme_mod( 'clarion_show_author_bio', true ) ) {
		return;
	}

	if ( ! is_single() ) {
		return;
	}

	$author_id          = get_the_author_meta( 'ID' );
	$author_name        = get_the_author();
	$author_description = get_the_author_meta( 'description' );
	$author_url         = get_author_posts_url( $author_id );

	?>
	<div class="author-bio">
		<div class="author-bio__avatar">
			<?php echo get_avatar( $author_id, 80, '', esc_attr( $author_name ), array( 'class' => 'author-bio__img' ) ); ?>
		</div>
		<div class="author-bio__content">
			<h3 class="author-bio__name">
				<a href="<?php echo esc_url( $author_url ); ?>">
					<?php echo esc_html( $author_name ); ?>
				</a>
			</h3>
			<?php if ( $author_description ) : ?>
				<p class="author-bio__description"><?php echo wp_kses_post( $author_description ); ?></p>
			<?php endif; ?>
			<a class="author-bio__link" href="<?php echo esc_url( $author_url ); ?>">
				<?php
				printf(
					/* translators: %s: author name. */
					esc_html__( 'More posts by %s', 'clarion' ),
					esc_html( $author_name )
				);
				?>
			</a>
		</div>
	</div>
	<?php
}

/**
 * Prints a related posts section (same category, no plugin).
 */
function clarion_related_posts() {
	if ( ! get_theme_mod( 'clarion_show_related_posts', true ) ) {
		return;
	}

	if ( ! is_single() ) {
		return;
	}

	$categories = wp_get_post_categories( get_the_ID() );

	if ( empty( $categories ) ) {
		return;
	}

	$related = new WP_Query(
		array(
			'category__in'        => $categories,
			'post__not_in'        => array( get_the_ID() ),
			'posts_per_page'      => 3,
			'no_found_rows'       => true,
			'ignore_sticky_posts' => true,
		)
	);

	if ( ! $related->have_posts() ) {
		return;
	}

	?>
	<div class="related-posts">
		<h2 class="related-posts__title"><?php esc_html_e( 'You Might Also Like', 'clarion' ); ?></h2>
		<div class="related-posts__grid">
			<?php while ( $related->have_posts() ) : $related->the_post(); ?>
				<article class="related-post-card">
					<?php if ( has_post_thumbnail() ) : ?>
						<a href="<?php the_permalink(); ?>" class="related-post-card__thumb" tabindex="-1" aria-hidden="true">
							<?php the_post_thumbnail( 'clarion-card', array( 'loading' => 'lazy' ) ); ?>
						</a>
					<?php endif; ?>
					<div class="related-post-card__body">
						<h3 class="related-post-card__title">
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						</h3>
						<span class="related-post-card__date"><?php echo esc_html( get_the_date() ); ?></span>
					</div>
				</article>
			<?php endwhile; ?>
		</div>
	</div>
	<?php

	wp_reset_postdata();
}

/**
 * Prints breadcrumbs navigation (no plugin required).
 */
function clarion_breadcrumbs() {
	if ( is_front_page() ) {
		return;
	}

	$separator = '<span class="breadcrumb-sep" aria-hidden="true">/</span>';

	echo '<nav class="breadcrumbs" aria-label="' . esc_attr__( 'Breadcrumbs', 'clarion' ) . '">';
	echo '<ol class="breadcrumbs__list">';

	// Home.
	echo '<li class="breadcrumbs__item"><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 'clarion' ) . '</a></li>';

	if ( is_category() ) {
		echo '<li class="breadcrumbs__item">' . $separator . esc_html( single_cat_title( '', false ) ) . '</li>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	} elseif ( is_tag() ) {
		echo '<li class="breadcrumbs__item">' . $separator . esc_html__( 'Tag: ', 'clarion' ) . esc_html( single_tag_title( '', false ) ) . '</li>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	} elseif ( is_author() ) {
		echo '<li class="breadcrumbs__item">' . $separator . esc_html__( 'Author: ', 'clarion' ) . esc_html( get_the_author() ) . '</li>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	} elseif ( is_search() ) {
		echo '<li class="breadcrumbs__item">' . $separator . esc_html__( 'Search Results', 'clarion' ) . '</li>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	} elseif ( is_404() ) {
		echo '<li class="breadcrumbs__item">' . $separator . esc_html__( '404 Not Found', 'clarion' ) . '</li>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	} elseif ( is_single() ) {
		$categories = get_the_category();
		if ( $categories ) {
			$category = $categories[0];
			echo '<li class="breadcrumbs__item">' . $separator . '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '">' . esc_html( $category->name ) . '</a></li>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
		echo '<li class="breadcrumbs__item">' . $separator . '<span aria-current="page">' . esc_html( get_the_title() ) . '</span></li>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	} elseif ( is_page() ) {
		$ancestors = get_post_ancestors( get_the_ID() );
		if ( $ancestors ) {
			$ancestors = array_reverse( $ancestors );
			foreach ( $ancestors as $ancestor ) {
				echo '<li class="breadcrumbs__item">' . $separator . '<a href="' . esc_url( get_permalink( $ancestor ) ) . '">' . esc_html( get_the_title( $ancestor ) ) . '</a></li>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		}
		echo '<li class="breadcrumbs__item">' . $separator . '<span aria-current="page">' . esc_html( get_the_title() ) . '</span></li>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	} elseif ( is_date() ) {
		echo '<li class="breadcrumbs__item">' . $separator . esc_html( get_the_date( 'F Y' ) ) . '</li>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	echo '</ol>';
	echo '</nav>';
}
