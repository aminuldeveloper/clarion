<?php
/**
 * The sidebar containing the main widget area
 *
 * @package Clarion
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}

$sidebar_position = get_theme_mod( 'clarion_sidebar_position', 'right' );

if ( 'none' === $sidebar_position ) {
	return;
}
?>

<aside id="secondary" class="widget-area" aria-label="<?php esc_attr_e( 'Sidebar', 'clarion' ); ?>">
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</aside><!-- #secondary -->
