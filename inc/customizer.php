<?php
/**
 * Luminary Theme Customizer
 *
 * @package Clarion
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add Customizer settings, sections, and controls.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function clarion_customize_register( $wp_customize ) {

	// ---------------------------------------------------------------
	// Panel: Theme Options
	// ---------------------------------------------------------------
	$wp_customize->add_panel(
		'clarion_options',
		array(
			'title'    => esc_html__( 'Theme Options', 'clarion' ),
			'priority' => 130,
		)
	);

	// ---------------------------------------------------------------
	// Section: Colors
	// ---------------------------------------------------------------
	$wp_customize->add_section(
		'clarion_colors',
		array(
			'title'    => esc_html__( 'Colors', 'clarion' ),
			'panel'    => 'clarion_options',
			'priority' => 10,
		)
	);

	// Accent Color.
	$wp_customize->add_setting(
		'clarion_accent_color',
		array(
			'default'           => '#B8860B',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'clarion_accent_color',
			array(
				'label'   => esc_html__( 'Accent Color', 'clarion' ),
				'section' => 'clarion_colors',
			)
		)
	);

	// Body Background Color.
	$wp_customize->add_setting(
		'clarion_body_bg_color',
		array(
			'default'           => '#FAFAF8',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'clarion_body_bg_color',
			array(
				'label'   => esc_html__( 'Body Background Color', 'clarion' ),
				'section' => 'clarion_colors',
			)
		)
	);

	// Text Color.
	$wp_customize->add_setting(
		'clarion_text_color',
		array(
			'default'           => '#2C2C2C',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'clarion_text_color',
			array(
				'label'   => esc_html__( 'Body Text Color', 'clarion' ),
				'section' => 'clarion_colors',
			)
		)
	);

	// Heading Color.
	$wp_customize->add_setting(
		'clarion_heading_color',
		array(
			'default'           => '#1A1A1A',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'clarion_heading_color',
			array(
				'label'   => esc_html__( 'Heading Color', 'clarion' ),
				'section' => 'clarion_colors',
			)
		)
	);

	// ---------------------------------------------------------------
	// Section: Layout
	// ---------------------------------------------------------------
	$wp_customize->add_section(
		'clarion_layout',
		array(
			'title'    => esc_html__( 'Layout', 'clarion' ),
			'panel'    => 'clarion_options',
			'priority' => 20,
		)
	);

	// Sidebar Position.
	$wp_customize->add_setting(
		'clarion_sidebar_position',
		array(
			'default'           => 'right',
			'sanitize_callback' => 'clarion_sanitize_select',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'clarion_sidebar_position',
		array(
			'label'   => esc_html__( 'Sidebar Position', 'clarion' ),
			'section' => 'clarion_layout',
			'type'    => 'select',
			'choices' => array(
				'right' => esc_html__( 'Right Sidebar', 'clarion' ),
				'left'  => esc_html__( 'Left Sidebar', 'clarion' ),
				'none'  => esc_html__( 'No Sidebar (Full Width)', 'clarion' ),
			),
		)
	);

	// Posts Per Row on Blog.
	$wp_customize->add_setting(
		'clarion_posts_per_row',
		array(
			'default'           => '2',
			'sanitize_callback' => 'clarion_sanitize_select',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'clarion_posts_per_row',
		array(
			'label'   => esc_html__( 'Posts Per Row (Blog)', 'clarion' ),
			'section' => 'clarion_layout',
			'type'    => 'select',
			'choices' => array(
				'1' => esc_html__( '1 Column', 'clarion' ),
				'2' => esc_html__( '2 Columns', 'clarion' ),
				'3' => esc_html__( '3 Columns', 'clarion' ),
			),
		)
	);

	// ---------------------------------------------------------------
	// Section: Blog Options
	// ---------------------------------------------------------------
	$wp_customize->add_section(
		'clarion_blog',
		array(
			'title'    => esc_html__( 'Blog Options', 'clarion' ),
			'panel'    => 'clarion_options',
			'priority' => 30,
		)
	);

	// Show Reading Time.
	$wp_customize->add_setting(
		'clarion_show_reading_time',
		array(
			'default'           => true,
			'sanitize_callback' => 'clarion_sanitize_checkbox',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'clarion_show_reading_time',
		array(
			'label'   => esc_html__( 'Show Reading Time', 'clarion' ),
			'section' => 'clarion_blog',
			'type'    => 'checkbox',
		)
	);

	// Show Author Bio on Single Posts.
	$wp_customize->add_setting(
		'clarion_show_author_bio',
		array(
			'default'           => true,
			'sanitize_callback' => 'clarion_sanitize_checkbox',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'clarion_show_author_bio',
		array(
			'label'   => esc_html__( 'Show Author Bio on Single Posts', 'clarion' ),
			'section' => 'clarion_blog',
			'type'    => 'checkbox',
		)
	);

	// Show Related Posts.
	$wp_customize->add_setting(
		'clarion_show_related_posts',
		array(
			'default'           => true,
			'sanitize_callback' => 'clarion_sanitize_checkbox',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'clarion_show_related_posts',
		array(
			'label'   => esc_html__( 'Show Related Posts on Single Posts', 'clarion' ),
			'section' => 'clarion_blog',
			'type'    => 'checkbox',
		)
	);

	// Show Post Navigation.
	$wp_customize->add_setting(
		'clarion_show_post_nav',
		array(
			'default'           => true,
			'sanitize_callback' => 'clarion_sanitize_checkbox',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'clarion_show_post_nav',
		array(
			'label'   => esc_html__( 'Show Previous/Next Post Navigation', 'clarion' ),
			'section' => 'clarion_blog',
			'type'    => 'checkbox',
		)
	);

	// ---------------------------------------------------------------
	// Section: Footer
	// ---------------------------------------------------------------
	$wp_customize->add_section(
		'clarion_footer',
		array(
			'title'    => esc_html__( 'Footer', 'clarion' ),
			'panel'    => 'clarion_options',
			'priority' => 40,
		)
	);

	// Footer Credit Text.
	$wp_customize->add_setting(
		'clarion_footer_credit',
		array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'clarion_footer_credit',
		array(
			'label'       => esc_html__( 'Footer Credit Text', 'clarion' ),
			'description' => esc_html__( 'Optional additional text displayed in the footer.', 'clarion' ),
			'section'     => 'clarion_footer',
			'type'        => 'text',
		)
	);
}
add_action( 'customize_register', 'clarion_customize_register' );

/**
 * Sanitize select fields.
 *
 * @param  string               $input   The value to sanitize.
 * @param  WP_Customize_Setting $setting The setting object.
 * @return string                         Sanitized value or the default.
 */
function clarion_sanitize_select( $input, $setting ) {
	$input   = sanitize_key( $input );
	$choices = $setting->manager->get_control( $setting->id )->choices;
	return array_key_exists( $input, $choices ) ? $input : $setting->default;
}

/**
 * Sanitize checkbox fields.
 *
 * @param  bool $checked Whether the checkbox is checked.
 * @return bool
 */
function clarion_sanitize_checkbox( $checked ) {
	return ( isset( $checked ) && true === $checked ) ? true : false;
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function clarion_customize_preview_js() {
	wp_enqueue_script(
		'clarion-customizer',
		get_template_directory_uri() . '/assets/js/customizer.js',
		array( 'customize-preview' ),
		CLARION_VERSION,
		true
	);
}
add_action( 'customize_preview_init', 'clarion_customize_preview_js' );
