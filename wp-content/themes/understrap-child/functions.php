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

	wp_enqueue_style(
  'font-awesome-cdn',
  'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css',
  [],
  '6.4.0'
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



/* ========================== HOME PAGE ========================== */
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

/**
 * Register the “Why Get Involved? – Home” block pattern (3-column version)
 */
add_action( 'init', function() {
    register_block_pattern(
        'whited/home-why-columns',
        [
            'title'       => __( 'Why Get Involved? – 3-Columns', 'understrap-child' ),
            'description' => __( 'Three columns with icons and details, plus a CTA', 'understrap-child' ),
            'categories'  => [ 'home-page' ],
            'inserter'    => true,
            'content'     => <<<'HTML'
<section class="wp-block-group alignfull why-section bg-light py-5">
  <div class="container section-inner">
    <h3 class="text-center mb-5">Why Get Involved?</h3>
    <div class="row text-center">
      <div class="col-lg-4 mb-4">
        <div class="px-3">
          <i class="fas fa-hands-helping fa-3x mb-3 text-primary"></i>
          <h4 class="mb-2">Support Our Students</h4>
          <p class="text-muted">Volunteer in the classroom or at events—every hour you spend makes a real difference in a child’s day. From reading buddies to STEM helpers, there’s something for everyone.</p>
        </div>
      </div>
      <div class="col-lg-4 mb-4">
        <div class="px-3">
          <i class="fas fa-users fa-3x mb-3 text-primary"></i>
          <h4 class="mb-2">Build Community</h4>
          <p class="text-muted">Join family-friendly gatherings like our Fall Festival and Spring Carnival. Bring your energy, meet other parents, and help us create memories for the whole school.</p>
        </div>
      </div>
      <div class="col-lg-4 mb-4">
        <div class="px-3">
          <i class="fas fa-school fa-3x mb-3 text-primary"></i>
          <h4 class="mb-2">Bridge Home &amp; School</h4>
          <p class="text-muted">Serve as a liaison between parents and teachers—help translate needs, ideas, and feedback so we can all work together toward a stronger learning environment.</p>
        </div>
      </div>
    </div>
    <div class="text-center mt-4">
      <a href="/get-involved" class="btn btn-primary btn-lg">Get Involved</a>
    </div>
  </div>
</section>
HTML
        ]
    );
}, 11 );


/**
 * Register “Upcoming Events” – Home block pattern
 */
add_action( 'init', function() {
    register_block_pattern(
        'whited/home-upcoming-events',
        [
            'title'       => __( 'Upcoming Events – Home (Stacked)', 'understrap-child' ),
            'description' => __( 'Stacked list of upcoming events, flyers & directions', 'understrap-child' ),
            'categories'  => [ 'home-page' ],
            'inserter'    => true,
            'content'     => <<<'HTML'
<section class="wp-block-group alignfull events-section bg-light py-5">
  <div class="container section-inner">
    <h2 class="text-uppercase fw-bold">Upcoming Events</h2>
	<p class="mb-4">Join us for our upcoming events! Click the buttons below to view flyers and get directions.</p>
<!-- Event 1 -->
<div class="card border-0 shadow-sm mb-4 p-4">
  <h3 class="h5">Whited Elementary Holiday Vendor & Craft Faire</h3>
  <p class="mb-1">
    <i class="far fa-calendar-alt me-2"></i>December 7, 2024 
    <i class="far fa-clock ms-3 me-2"></i>10 AM – 2 PM
  </p>
  <p class="mb-3">
    <i class="fas fa-map-marker-alt me-2"></i>Douglas Whited MPR
  </p>
  <p class="text-muted mb-4">
    Holiday crafts, homebaked goods, jewelry, candles, tamales, and more!
  </p>
  <div class="d-flex align-items-center">
    <a href="https://dev-rhogan-cs50b-final.pantheonsite.io/wp-content/uploads/2025/05/Screenshot-2025-05-18-at-7.51.15 PM.png" class="btn btn-outline-primary btn-sm" target="_blank">View Flyer</a>
    <a href="https://www.bing.com/maps?q=douglas+whited+locatoin+santa+rosa&cvid=d881f765609d4204be6077724425f316&gs_lcrp=EgRlZGdlKgYIABBFGDkyBggAEEUYOdIBCDc0MjRqMGoxqAIAsAIA&FORM=ANNTA1&PC=U531" class="btn btn-primary btn-sm ms-3" target="_blank">Get Directions</a>
  </div>
</div>

<!-- Event 2 -->
<div class="card border-0 shadow-sm mb-4 p-4">
  <h3 class="h5">PTO Meeting</h3>
  <p class="mb-1">
    <i class="far fa-calendar-alt me-2"></i>November 14, 2024 
    <i class="far fa-clock ms-3 me-2"></i>8:20 AM
  </p>
  <p class="mb-3">
    <i class="fas fa-map-marker-alt me-2"></i>Whited Elementary Library
  </p>
  <p class="text-muted mb-4">
    Monthly PTO gathering to discuss upcoming events, budgets, and volunteer opportunities.
  </p>
  <div class="d-flex align-items-center">
    <a href="https://dev-rhogan-cs50b-final.pantheonsite.io/wp-content/uploads/2025/05/Screenshot-2025-05-18-at-7.51.35%20PM.png" class="btn btn-outline-primary btn-sm" target="_blank">View Flyer</a>
    <a href="https://www.bing.com/maps?q=douglas+whited+locatoin+santa+rosa&cvid=d881f765609d4204be6077724425f316&gs_lcrp=EgRlZGdlKgYIABBFGDkyBggAEEUYOdIBCDc0MjRqMGoxqAIAsAIA&FORM=ANNTA1&PC=U531" class="btn btn-primary btn-sm ms-3" target="_blank">Get Directions</a>
  </div>
</div>

<!-- Event 3 -->
<div class="card border-0 shadow-sm mb-4 p-4">
  <h3 class="h5">It’s a Pizza Party!</h3>
  <p class="mb-1">
    <i class="far fa-calendar-alt me-2"></i>November 19, 2024 
    <i class="far fa-clock ms-3 me-2"></i>12 PM – 10 PM
  </p>
  <p class="mb-3">
    <i class="fas fa-map-marker-alt me-2"></i>Santa Rosa Pizzeria
  </p>
  <p class="text-muted mb-4">
    20% of your purchase will be donated to our PTO—just mention “Whited” at the counter!
  </p>
  <div class="d-flex align-items-center">
    <a href="https://dev-rhogan-cs50b-final.pantheonsite.io/wp-content/uploads/2025/05/Screenshot-2025-05-18-at-7.51.27%20PM.png" class="btn btn-outline-primary btn-sm" target="_blank">View Flyer</a>
    <a href="https://maps.google.com/?q=500+Mission+Blvd+Santa+Rosa+CA+95409" class="btn btn-primary btn-sm ms-3" target="_blank">Get Directions</a>
  </div>
</div>

  </div>
</section>
HTML
        ]
    );
}, 11 );

