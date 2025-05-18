<?php
/**
 * UnderStrap Child Theme – functions.php (condensed)
 */
defined( 'ABSPATH' ) || exit;

/**
 * ----------------------------------------------------------------------------
 *  Child-theme setup (runs once on after_setup_theme)
 * ----------------------------------------------------------------------------
 */
add_action( 'after_setup_theme', 'understrap_child_setup', 11 );
function understrap_child_setup() {

	// 1. Core block patterns & editor preview styles
	add_theme_support( 'core-block-patterns' );
	add_theme_support( 'editor-styles' );
	add_editor_style( 'build/assets/css/app.css' );

	// 2. Translation files
	load_child_theme_textdomain(
		'understrap-child',
		get_stylesheet_directory() . '/languages'
	);

	// 3. Theme supports
	add_theme_support( 'align-wide' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'disable-layout-styles' ); // experimental
	add_theme_support( 'custom-logo', [
		'height'      => 50,
		'width'       => 200,
		'flex-height' => true,
		'flex-width'  => true,
	] );

	// 4. Menus
	register_nav_menus( [
		'primary' => __( 'Primary Menu', 'understrap-child' ),
		'footer'  => __( 'Footer Menu',  'understrap-child' ),
		'social'  => __( 'Social Menu',  'understrap-child' ),
	] );
}

/**
 * ----------------------------------------------------------------------------
 *  Enqueue front-end & editor assets
 * ----------------------------------------------------------------------------
 */
add_action( 'wp_enqueue_scripts', 'understrap_child_enqueue_assets', 20 );
function understrap_child_enqueue_assets() {

	// Google Fonts
	wp_enqueue_style(
		'google-font-russo',
		'https://fonts.googleapis.com/css2?family=Russo+One&family=Open+Sans:wght@400;600&display=swap',
		[],
		null
	);


	// (A) If using CDN —---
	wp_enqueue_style(
		'font-awesome',
		'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css',
		[],
		'6.4.0'
	);


	// ─────────────────────────────────────────────────────────────────────────

	// Child theme bundle (cache-busted)
	$css_rel  = '/build/assets/css/app.css';
	$css_path = get_stylesheet_directory() . $css_rel;
	$version  = file_exists( $css_path )
		? filemtime( $css_path )
		: wp_get_theme()->get( 'Version' );

	wp_enqueue_style(
		'understrap-child-css',
		get_stylesheet_directory_uri() . $css_rel,
		[ 'google-font-russo' ],
		$version
	);
}

/**
 * ----------------------------------------------------------------------------
 *  Filters & helpers (unchanged)
 * ----------------------------------------------------------------------------
 */
add_filter( 'render_block', 'understrap_child_strip_cover_layout_flags', 20, 2 );
function understrap_child_strip_cover_layout_flags( $markup, $block ) {
	if ( ( $block['blockName'] ?? '' ) === 'core/cover' ) {
		$markup = preg_replace(
			'/(wp-block-cover__inner-container)(?:\s+is-layout-\w+|\s+wp-block-cover-is-layout-\w+)/',
			'$1',
			$markup
		);
	}
	return $markup;
}

add_filter( 'block_type_metadata_settings', 'understrap_child_disable_cover_layout_control', 10, 2 );
function understrap_child_disable_cover_layout_control( $settings, $metadata ) {
	if ( ( $metadata['name'] ?? '' ) === 'core/cover' ) {
		$settings['supports']['layout'] = false;
	}
	return $settings;
}

add_filter(
	'theme_mod_understrap_bootstrap_version',
	fn() => 'bootstrap5',
	20
);

/**
 *  Button block style (kept as-is)
 */
add_action( 'init', function () {
	if ( function_exists( 'register_block_style' ) ) {
		register_block_style( 'core/button', [
			'name'  => 'solid-gold',
			'label' => __( 'Solid Gold', 'understrap-child' ),
		] );
	}
} );

add_action( 'init', function() {
    register_block_pattern_category( 'callout', [ 'label' => __( 'Callouts', 'understrap-child' ) ] );
    register_block_pattern_category( 'query',   [ 'label' => __( 'Query',   'understrap-child' ) ] );
} );