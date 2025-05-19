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

/* 0. RE-enable support late – guarantees it’s on */
add_action( 'after_setup_theme', function () {
	add_theme_support( 'core-block-patterns' );
}, 99 );          // 99 > any parent theme call

/* 1. Register EVERY slug you use – add the missing ones */
add_action( 'init', function () {
	foreach ( [
		'banner'   => 'Banners',
		'callout'  => 'Callouts',
		'hero'     => 'Hero',
		'forms'    => 'Forms',
		'events'   => 'Events',
		'cards'    => 'Cards',
		'grid'     => 'Grids',
		'people'   => 'People',
		'calendar' => 'Calendars',
		'text'     => 'Text',
		'members'  => 'Members',
		'media'    => 'Media',         // ← NEW
		'cta'      => 'Call to action' // ← if any header says “cta”
	] as $slug => $label ) {
		register_block_pattern_category( $slug, [ 'label' => __( $label, 'understrap-child' ) ] );
	}
}, 1 );           // before core scan (init 9)


add_filter( 'should_load_remote_block_patterns', '__return_false' );


add_filter( 'block_editor_settings_all', function ( $settings ) {
    $settings['hasCustomBlockPatterns'] = false;  // hides “My patterns” tab
    return $settings;
} );


/**
 * Register our “Our Mission – Home” block pattern so
 * we know exactly what HTML Gutenberg will insert.
 */
add_action( 'init', function() {
    register_block_pattern(
        'whited/home-our-mission',
        [
            'title'       => __( 'Our Mission – Home', 'understrap-child' ),
            'description' => __( 'Full-width mission section with an inner constrained container', 'understrap-child' ),
            'categories'  => [ 'home-page' ],
            'inserter'    => true,
            'content'     => <<<'HTML'
<div class="wp-block-group alignfull mission-section">
  <div class="wp-block-group section-inner">
    <p class="has-text-align-center"><strong>At Whited Elementary PTO, our mission is simple:</strong></p>
    <p class="has-text-align-center mission-inner">
      We strive to enhance the educational experience of every student by fostering a supportive community of parents, teachers, and staff. Through volunteer efforts, fundraising events, and open communication, we work together to create a positive environment where every family can thrive.
    </p>
  </div>
</div>
HTML
        ]
    );
}, 11 );
