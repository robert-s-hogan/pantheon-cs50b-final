<?php
/**
 * Understrap Child – functions.php
 * Load order: setup  ► assets  ► extras
 */
defined( 'ABSPATH' ) || exit;

/* ─────────────────────────────────────────────────────────────
   1. Theme setup  (after parent theme; priority 10 is fine)
   ─────────────────────────────────────────────────────────── */
add_action( 'after_setup_theme', function () {

	/* Block-editor & patterns
	   -------------------------------------------------------- */
	add_theme_support( 'wp-block-styles' );        // Core block CSS
	add_theme_support( 'core-block-patterns' );    // Enables /patterns auto-scan
	add_theme_support( 'align-wide' );             // “Wide” & “Full” options
	add_theme_support( 'editor-styles' );          // Load custom CSS in editor
	add_editor_style( 'build/assets/css/app.css' );

	/* Misc supports you actually use
	   -------------------------------------------------------- */
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'custom-logo', [
		'height'      => 50,
		'width'       => 200,
		'flex-height' => true,
		'flex-width'  => true,
	] );

	/* ✂︎  Disable layout styles  — only keep if you really need it
	----------------------------------------------------------------
	 add_theme_support( 'disable-layout-styles' );
	*/

	/* Menus
	   -------------------------------------------------------- */
	register_nav_menus( [
		'primary' => __( 'Primary Menu', 'understrap-child' ),
		'footer'  => __( 'Footer Menu',  'understrap-child' ),
		'social'  => __( 'Social Menu',  'understrap-child' ),
	] );
}, 10 );

/* ─────────────────────────────────────────────────────────────
   2. Front-end & editor assets
   ─────────────────────────────────────────────────────────── */
add_action( 'wp_enqueue_scripts', function () {

	$theme_dir = get_stylesheet_directory();
	$theme_uri = get_stylesheet_directory_uri();

	/* Google / local fonts first (keeps CLS low) */
	wp_enqueue_style(
		'understrap-fonts',
		'https://fonts.googleapis.com/css2?family=Russo+One&family=Open+Sans:wght@400;600&display=swap',
		[],
		null
	);

	/* Compiled child-theme CSS (version = filemtime for cache-bust) */
	$css_rel = '/build/assets/css/app.css';
	$css_abs = $theme_dir . $css_rel;

	if ( file_exists( $css_abs ) ) {
		wp_enqueue_style(
			'understrap-child',
			$theme_uri . $css_rel,
			[ 'understrap-fonts' ],
			filemtime( $css_abs )
		);
	}

	/* ✂︎  JS bundle — uncomment when you actually build one
	----------------------------------------------------------
	$js_rel = '/build/assets/js/app.js';
	$js_abs = $theme_dir . $js_rel;

	if ( file_exists( $js_abs ) ) {
		wp_enqueue_script(
			'understrap-child',
			$theme_uri . $js_rel,
			[ 'jquery' ],                       // deps
			filemtime( $js_abs ),
			true                                // in footer
		);
	}
	*/
}, 20 );

/* ─────────────────────────────────────────────────────────────
   3. Extras: pattern-categories & custom block styles
   ─────────────────────────────────────────────────────────── */

add_action( 'init', 'rhogan_register_pattern_categories', 1 ); // 1 ≪ 9
function rhogan_register_pattern_categories() {

	$cats = [
		'banner'   => __( 'Banners',  'understrap-child' ),
		'callout'  => __( 'Callouts', 'understrap-child' ),
		'hero'     => __( 'Hero',    'understrap-child' ),
		'forms'    => __( 'Forms',   'understrap-child' ),
		'events'   => __( 'Events',  'understrap-child' ),
		'cards'    => __( 'Cards & Grids', 'understrap-child' ),
		'grid'     => __( 'Grids',   'understrap-child' ),
		'people'   => __( 'People',  'understrap-child' ),
		'calendar' => __( 'Calendars','understrap-child' ),
		'text'     => __( 'Text',    'understrap-child' ),
		'members'  => __( 'Members', 'understrap-child' ),
	];

	foreach ( $cats as $slug => $label ) {
		register_block_pattern_category( $slug, [ 'label' => $label ] );
	}
}


/* (B) Optional custom block style */
add_action( 'init', function () {
	register_block_style( 'core/button', [
		'name'  => 'solid-gold',
		'label' => __( 'Solid Gold', 'understrap-child' ),
	] );
} );

add_action( 'init', function () {
	remove_theme_support( 'core-block-patterns' );   // kicks out WP’s bundle
}, 20 ); // > 10 so it fires after Core’s loaders
