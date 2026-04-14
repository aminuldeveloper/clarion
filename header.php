<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'clarion' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="site-header__inner container">

			<!-- Site Branding -->
			<div class="site-branding">
				<?php
				if ( clarion_has_custom_logo() ) :
					the_custom_logo();
				else :
					?>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-title-link" rel="home">
						<?php bloginfo( 'name' ); ?>
					</a>
					<?php
					$description = get_bloginfo( 'description', 'display' );
					if ( $description || is_customize_preview() ) :
						?>
						<p class="site-description"><?php echo esc_html( $description ); ?></p>
					<?php endif; ?>
				<?php endif; ?>
			</div><!-- .site-branding -->

			<!-- Primary Navigation -->
			<nav id="site-navigation" class="main-navigation" aria-label="<?php esc_attr_e( 'Primary Navigation', 'clarion' ); ?>">

				<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
					<span class="menu-toggle__bar"></span>
					<span class="menu-toggle__bar"></span>
					<span class="menu-toggle__bar"></span>
					<span class="screen-reader-text"><?php esc_html_e( 'Menu', 'clarion' ); ?></span>
				</button>

				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'primary',
						'menu_id'        => 'primary-menu',
						'menu_class'     => 'nav-menu primary-navigation',
						'container'      => false,
						'fallback_cb'    => '__return_false',
					)
				);
				?>
			</nav><!-- #site-navigation -->

		</div><!-- .site-header__inner -->
	</header><!-- #masthead -->

<div id="content" class="site-content">
