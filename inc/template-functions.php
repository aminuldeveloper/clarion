<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Clarion
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function clarion_body_classes( $classes ) {

	// Sidebar position class.
	$sidebar_position = get_theme_mod( 'clarion_sidebar_position', 'right' );
	$classes[]        = 'sidebar-' . sanitize_html_class( $sidebar_position );

	// Posts per row class.
	$posts_per_row = get_theme_mod( 'clarion_posts_per_row', '2' );
	$classes[]     = 'posts-col-' . absint( $posts_per_row );

	// Add class when there is no sidebar.
	if ( 'none' === $sidebar_position || ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	// Add class for single post without sidebar.
	if ( is_single() || is_page() ) {
		if ( ! is_active_sidebar( 'sidebar-1' ) ) {
			$classes[] = 'no-sidebar';
		}
	}

	return $classes;
}
add_filter( 'body_class', 'clarion_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function clarion_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'clarion_pingback_header' );

/**
 * Filter the excerpt length.
 *
 * @param int $length Excerpt length.
 * @return int Modified excerpt length.
 */
function clarion_excerpt_length( $length ) {
	if ( is_admin() ) {
		return $length;
	}
	return 25;
}
add_filter( 'excerpt_length', 'clarion_excerpt_length' );

/**
 * Replace the excerpt "…" string with a custom one.
 *
 * @param string $more The existing excerpt more string.
 * @return string Modified excerpt more string.
 */
function clarion_excerpt_more( $more ) {
	if ( is_admin() ) {
		return $more;
	}
	return '&hellip;';
}
add_filter( 'excerpt_more', 'clarion_excerpt_more' );

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool True if there is more than 1 category.
 */
function clarion_categorized_blog() {
	$all_cats       = false;
	$category_count = get_transient( 'clarion_categories' );

	if ( false === $category_count ) {
		$category_count = wp_count_terms( 'category' );
		set_transient( 'clarion_categories', $category_count );
	}

	if ( $category_count > 1 ) {
		$all_cats = true;
	}

	return $all_cats;
}

/**
 * Flush out the transients used in clarion_categorized_blog.
 */
function clarion_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	delete_transient( 'clarion_categories' );
}
add_action( 'edit_category', 'clarion_category_transient_flusher' );
add_action( 'save_post', 'clarion_category_transient_flusher' );

/**
 * Determines whether the site has a custom logo.
 *
 * @return bool True if the site has a logo, false otherwise.
 */
function clarion_has_custom_logo() {
	return (bool) get_theme_mod( 'custom_logo' );
}

/**
 * Get the correct archive title with prefix removed for cleaner display.
 *
 * @return string Archive title without prefix.
 */
function clarion_get_archive_title() {
	if ( is_category() ) {
		return single_cat_title( '', false );
	} elseif ( is_tag() ) {
		return single_tag_title( '', false );
	} elseif ( is_author() ) {
		return get_the_author();
	} elseif ( is_date() ) {
		if ( is_day() ) {
			return get_the_date();
		} elseif ( is_month() ) {
			return get_the_date( 'F Y' );
		} else {
			return get_the_date( 'Y' );
		}
	} elseif ( is_post_type_archive() ) {
		return post_type_archive_title( '', false );
	} else {
		return esc_html__( 'Archives', 'clarion' );
	}
}

/**
 * Get the archive description label (e.g. "Category", "Tag").
 *
 * @return string Archive type label.
 */
function clarion_get_archive_label() {
	if ( is_category() ) {
		return esc_html__( 'Category', 'clarion' );
	} elseif ( is_tag() ) {
		return esc_html__( 'Tag', 'clarion' );
	} elseif ( is_author() ) {
		return esc_html__( 'Author', 'clarion' );
	} elseif ( is_date() ) {
		return esc_html__( 'Archive', 'clarion' );
	}
	return '';
}

/**
 * Wrap oEmbed output in a responsive container.
 *
 * @param  string $html The embed HTML.
 * @return string       Wrapped embed HTML.
 */
function clarion_responsive_embed_wrapper( $html ) {
	return '<div class="responsive-embed">' . $html . '</div>';
}
add_filter( 'embed_oembed_html', 'clarion_responsive_embed_wrapper', 10 );

/**
 * Custom comment callback for wp_list_comments().
 *
 * @param WP_Comment $comment Comment object.
 * @param array      $args    An array of arguments.
 * @param int        $depth   Depth of the current comment.
 */
function clarion_comment_callback( $comment, $args, $depth ) {
	$tag = ( 'div' === $args['style'] ) ? 'div' : 'li';
	?>

	<<?php echo esc_attr( $tag ); ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( $args['has_children'] ? 'parent' : '', $comment ); ?>>

		<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">

			<footer class="comment-meta">
				<div class="comment-author vcard">
					<?php
					if ( 0 !== $args['avatar_size'] ) {
						echo get_avatar( $comment, $args['avatar_size'], '', '', array( 'class' => 'comment-avatar' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					}
					?>
					<?php
					printf(
						'<b class="fn">%s</b>',
						get_comment_author_link( $comment ) // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					);
					?>
				</div><!-- .comment-author -->

				<div class="comment-metadata">
					<a href="<?php echo esc_url( get_comment_link( $comment, $args ) ); ?>">
						<time datetime="<?php comment_time( 'c' ); ?>">
							<?php
							printf(
								/* translators: 1: comment date, 2: comment time. */
								esc_html__( '%1$s at %2$s', 'clarion' ),
								esc_html( get_comment_date( '', $comment ) ),
								esc_html( get_comment_time() )
							);
							?>
						</time>
					</a>
					<?php edit_comment_link( esc_html__( 'Edit', 'clarion' ), '<span class="edit-link">', '</span>' ); ?>
				</div><!-- .comment-metadata -->

				<?php if ( '0' === $comment->comment_approved ) : ?>
					<p class="comment-awaiting-moderation">
						<?php esc_html_e( 'Your comment is awaiting moderation.', 'clarion' ); ?>
					</p>
				<?php endif; ?>

			</footer><!-- .comment-meta -->

			<div class="comment-content">
				<?php comment_text(); ?>
			</div><!-- .comment-content -->

			<?php
			comment_reply_link(
				array_merge(
					$args,
					array(
						'add_below' => 'div-comment',
						'depth'     => $depth,
						'max_depth' => $args['max_depth'],
						'before'    => '<div class="reply">',
						'after'     => '</div>',
					)
				)
			);
			?>

		</article><!-- .comment-body -->

	<?php
}
