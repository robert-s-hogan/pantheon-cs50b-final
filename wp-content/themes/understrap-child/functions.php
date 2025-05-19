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
    <a href="https://dev-rhogan-cs50b-final.pantheonsite.io/wp-content/uploads/2025/05/holiday_craft_faire_flyer.png" class="btn btn-outline-primary btn-sm" target="_blank">View Flyer</a>
    <a href="https://www.google.com/maps/place/Douglas+Whited+Elementary+School/@38.4653209,-122.6631306,16z/data=!4m15!1m8!3m7!1s0x808446304010473f:0x589d54b02ec95452!2s4995+Sonoma+Hwy,+Santa+Rosa,+CA+95409!3b1!8m2!3d38.4653209!4d-122.6631306!16s%2Fg%2F11cplgq9_g!3m5!1s0x80844630039342af:0x4bc912ea932eb1f0!8m2!3d38.4652488!4d-122.6624056!16s%2Fm%2F07682f9?entry=ttu&g_ep=EgoyMDI1MDUxMy4xIKXMDSoASAFQAw%3D%3D" class="btn btn-primary btn-sm ms-3" target="_blank">Get Directions</a>
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
    <a href="https://dev-rhogan-cs50b-final.pantheonsite.io/wp-content/uploads/2025/05/pto_flyer.png" class="btn btn-outline-primary btn-sm" target="_blank">View Flyer</a>
    <a href="https://www.google.com/maps/place/Douglas+Whited+Elementary+School/@38.4653209,-122.6631306,16z/data=!4m15!1m8!3m7!1s0x808446304010473f:0x589d54b02ec95452!2s4995+Sonoma+Hwy,+Santa+Rosa,+CA+95409!3b1!8m2!3d38.4653209!4d-122.6631306!16s%2Fg%2F11cplgq9_g!3m5!1s0x80844630039342af:0x4bc912ea932eb1f0!8m2!3d38.4652488!4d-122.6624056!16s%2Fm%2F07682f9?entry=ttu&g_ep=EgoyMDI1MDUxMy4xIKXMDSoASAFQAw%3D%3D" class="btn btn-primary btn-sm ms-3" target="_blank">Get Directions</a>
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
    <a href="https://dev-rhogan-cs50b-final.pantheonsite.io/wp-content/uploads/2025/05/santa_rosa_pizzeria_flyer.png" class="btn btn-outline-primary btn-sm" target="_blank">View Flyer</a>
    <a href="https://www.google.com/maps/place/Santa+Rosa+Pizzeria/@38.4598755,-122.6774198,17z/data=!3m1!4b1!4m6!3m5!1s0x808447ef2b9baf37:0xa9d9d0fe15ef9e2b!8m2!3d38.4598755!4d-122.6748449!16s%2Fg%2F11ks3fwydt?entry=ttu&g_ep=EgoyMDI1MDUxMy4xIKXMDSoASAFQAw%3D%3D" class="btn btn-primary btn-sm ms-3" target="_blank">Get Directions</a>
  </div>
</div>

  </div>
</section>
HTML
        ]
    );
}, 11 );



/* ============================= ABOUT PAGE ============================ */

add_action( 'init', function() {
    register_block_pattern(
        'whited/about-what-we-do',
        [
            'title'       => __( 'What We Do – About', 'understrap-child' ),
            'description' => __( 'Three columns outlining our core activities', 'understrap-child' ),
            'categories'  => [ 'about-page' ],
            'inserter'    => true,
            'content'     => <<<'HTML'
<section class="wp-block-group alignfull about-what-we-do-section py-5">
  <div class="container section-inner">
    <h2 class="text-center mb-4">What We Do</h2>
    <div class="row text-center">
      <div class="col-md-4 mb-4">
        <h4>Fundraising</h4>
        <p>We organize events such as fun runs, book fairs, and spirit nights to raise funds for classroom supplies, field trips, and educational resources.</p>
      </div>
      <div class="col-md-4 mb-4">
        <h4>Community Building</h4>
        <p>We host family activities and school-wide celebrations to bring parents, students, and teachers together outside the classroom.</p>
      </div>
      <div class="col-md-4 mb-4">
        <h4>Volunteer Coordination</h4>
        <p>We connect parents with a range of opportunities—from helping in classrooms to coordinating large-scale events.</p>
      </div>
    </div>
  </div>
</section>
HTML
        ]
    );
}, 11 );


add_action( 'init', function() {
    register_block_pattern(
        'whited/about-board',
        [
            'title'       => __( 'Meet the PTO Board', 'understrap-child' ),
            'description' => __( 'Cards listing board members with avatar, role, and bio', 'understrap-child' ),
            'categories'  => [ 'about-page' ],
            'inserter'    => true,
            'content'     => <<<'HTML'
<section class="wp-block-group alignfull about-board-section py-5">
  <div class="container section-inner">
    <h2 class="text-center mb-4">Meet the PTO Board</h2>
    <div class="row">
      <!-- Board Member 1 -->
      <div class="col-md-4 mb-4">
        <div class="card border-0 text-center">
          <div class="card-avatar mb-3">
            <!-- use a placeholder or WP avatar block -->
            <img src="#" alt="President Avatar" class="rounded-circle">
          </div>
          <h4 class="mb-1">Jane Smith</h4>
          <p class="text-uppercase text-muted small">President</p>
          <p class="text-muted">Jane is a dedicated parent of two Whited Elementary students. She enjoys organizing family-friendly fundraisers and community events.</p>
        </div>
      </div>
      <!-- Board Member 2 -->
      <div class="col-md-4 mb-4">
        <div class="card border-0 text-center">
          <div class="card-avatar mb-3">
            <img src="#" alt="Vice President Avatar" class="rounded-circle">
          </div>
          <h4 class="mb-1">Mark Johnson</h4>
          <p class="text-uppercase text-muted small">Vice President</p>
          <p class="text-muted">Mark focuses on volunteer outreach coordination. He’s passionate about ensuring every parent has a chance to get involved.</p>
        </div>
      </div>
      <!-- Fallback / “All Others” -->
      <div class="col-md-4 mb-4">
        <div class="card border-0 text-center">
          <div class="card-avatar mb-3">
            <img src="#" alt="Contributors Avatar" class="rounded-circle">
          </div>
          <h4 class="mb-1">All Other Contributors</h4>
          <p class="text-muted">Parents and staff who make PTO possible.</p>
        </div>
      </div>
    </div>
  </div>
</section>
HTML
        ]
    );
}, 11 );


add_action( 'init', function() {
    register_block_pattern(
        'whited/about-history',
        [
            'title'       => __( 'History of the PTO', 'understrap-child' ),
            'description' => __( 'Our origin story with image and caption', 'understrap-child' ),
            'categories'  => [ 'about-page' ],
            'inserter'    => true,
            'content'     => <<<'HTML'
<section class="wp-block-group alignfull about-history-section py-5 bg-light">
  <div class="container section-inner">
    <h2 class="text-center mb-4">History of the PTO</h2>
    <div class="row align-items-center">
      <div class="col-lg-6 mb-4 mb-lg-0">
        <!-- Gutenberg Image block goes here -->
        <figure class="wp-block-image size-large">
          <img src="#" alt="PTO founding photo"/>
          <figcaption class="mt-2 text-center text-muted small">Founded in 2000 with just a handful of parents.</figcaption>
        </figure>
      </div>
      <div class="col-lg-6">
        <p>“A brief background on where and why the PTO was formed, major milestones, and achievements over the years.”</p>
      </div>
    </div>
  </div>
</section>
HTML
        ]
    );
}, 11 );


add_action( 'init', function() {
    register_block_pattern(
        'whited/about-highlights',
        [
            'title'       => __( 'Highlights – About', 'understrap-child' ),
            'description' => __( 'Grid of our key successes and events', 'understrap-child' ),
            'categories'  => [ 'about-page' ],
            'inserter'    => true,
            'content'     => <<<'HTML'
<section class="wp-block-group alignfull about-highlights-section py-5">
  <div class="container section-inner">
    <h2 class="text-center mb-4">Highlights</h2>
    <div class="row g-4">
      <!-- Repeat these cols for each highlight -->
      <div class="col-sm-6 col-md-4">
        <div class="card border-0 shadow-sm">
          <!-- Gutenberg Image block -->
          <div class="card-img-top">
            <img src="#" alt="Back-to-School Bash">
          </div>
          <div class="card-body text-center">
            <h5 class="card-title mb-1">Back-to-School Bash</h5>
            <p class="text-muted small">Family carnival games, food trucks, and meet-the-teacher fun.</p>
          </div>
        </div>
      </div>
      <!-- …other highlight cards… -->
    </div>
  </div>
</section>
HTML
        ]
    );
}, 11 );
