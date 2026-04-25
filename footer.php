<?php
/**
 * The template for displaying the footer
 *
 * @package Clarion
 * @since   1.0.0
 */
?>

<footer id="colophon" class="site-footer">

	<?php if ( is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' ) ) : ?>
		<div class="footer-widgets">
			<div class="container">
				<div class="footer-widgets__grid">

					<?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
						<div class="footer-widget-area">
							<?php dynamic_sidebar( 'footer-1' ); ?>
						</div>
					<?php endif; ?>

					<?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
						<div class="footer-widget-area">
							<?php dynamic_sidebar( 'footer-2' ); ?>
						</div>
					<?php endif; ?>

					<?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
						<div class="footer-widget-area">
							<?php dynamic_sidebar( 'footer-3' ); ?>
						</div>
					<?php endif; ?>

				</div><!-- .footer-widgets__grid -->
			</div><!-- .container -->
		</div><!-- .footer-widgets -->
	<?php endif; ?>

	<div class="site-info">
		<div class="container">
			<div class="site-info__inner">

				<!-- Footer navigation -->
				<?php
				if ( has_nav_menu( 'footer' ) ) :
					wp_nav_menu(
						array(
							'theme_location'  => 'footer',
							'menu_id'         => 'footer-menu',
							'menu_class'      => 'footer-nav-menu',
							'container'       => 'nav',
							'container_id'    => 'footer-navigation',
							'container_class' => 'footer-navigation',
							'depth'           => 1,
							'fallback_cb'     => '__return_false',
						)
					);
				endif;
				?>

				<!-- Copyright -->
				<div class="copyright">
					<span class="copyright__text">
						&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
							<?php bloginfo( 'name' ); ?>
						</a>.
						<?php esc_html_e( 'All rights reserved.', 'clarion' ); ?>
					</span>

					<?php
					$credit_text = get_theme_mod( 'clarion_footer_credit', '' );
					if ( $credit_text ) :
						echo '<span class="copyright__credit">' . esc_html( $credit_text ) . '</span>';
					endif;
					?>

					<span class="copyright__theme-credit">
						<?php
						printf(
							wp_kses(
								/* translators: %s: author name with link. */
								__( 'Theme: Clarion by %s.', 'clarion' ),
								array( 'a' => array( 'href' => array() ) )
							),
							'<a href="' . esc_url( 'https://aminuldeveloper.com' ) . '">Aminul Islam</a>'
						);
						?>
					</span>
				</div><!-- .copyright -->

				<!-- Social links menu -->
				<?php
				if ( has_nav_menu( 'social' ) ) :
					wp_nav_menu(
						array(
							'theme_location'  => 'social',
							'menu_id'         => 'social-menu',
							'menu_class'      => 'social-nav-menu',
							'container'       => 'nav',
							'container_id'    => 'social-navigation',
							'container_class' => 'social-navigation',
							'link_before'     => '<span class="screen-reader-text">',
							'link_after'      => '</span>',
							'depth'           => 1,
							'fallback_cb'     => '__return_false',
						)
					);
				endif;
				?>

			</div><!-- .site-info__inner -->
		</div><!-- .container -->
	</div><!-- .site-info -->

</footer><!-- #colophon -->

</div><!-- #content -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
