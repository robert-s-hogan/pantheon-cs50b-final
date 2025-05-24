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
<section class="wp-block-group alignfull events-section py-5">
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
        'whited/about-hero',
        [
            'title'       => __( 'About Hero Section', 'understrap-child' ),
            'description' => __( 'Full-width cover with background image, title, and subtitle', 'understrap-child' ),
            'categories'  => [ 'about-page' ],
            'inserter'    => true,
            'content'     => <<<'HTML'
<figure class="wp-block-cover alignfull about-hero-section" style="background-image:url('#');min-height:50vh">
  <div class="wp-block-cover__inner-container section-inner">
    <h1 class="has-text-align-center">About Douglas Whited PTO</h1>
    <p class="has-text-align-center">Our mission is to enhance the educational experience of every student by fostering a supportive community of parents, teachers, and staff.</p>
  </div>
</figure>
HTML
        ]
    );
}, 11 );


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
            'description' => __( 'Board photo on one side and member bios on the other', 'understrap-child' ),
            'categories'  => [ 'about-page' ],
            'inserter'    => true,
            'content'     => <<<'HTML'
<section class="wp-block-group alignfull about-board-section py-5 bg-light">
  <div class="container section-inner">
    <div class="row align-items-center">
      <div class="col-md-6 mb-4 mb-md-0">
        <figure class="wp-block-image size-large">
          <img src="https://dev-rhogan-cs50b-final.pantheonsite.io/wp-content/uploads/2025/05/meet_the_board.png" alt="PTO Board Group Photo"/>
        </figure>
      </div>
      <div class="col-md-6">
        <h2>Meet the PTO Board</h2>
        <ul class="list-unstyled">
          <li class="mb-4">
            <h4>Jane Smith <small class="text-uppercase text-muted">President</small></h4>
            <p>Jane is a dedicated parent of two Whited Elementary students. She enjoys organizing family-friendly fundraisers and community events.</p>
          </li>
          <li class="mb-4">
            <h4>Mark Johnson <small class="text-uppercase text-muted">Vice President</small></h4>
            <p>Mark focuses on volunteer outreach coordination. He’s passionate about ensuring every parent has a chance to get involved.</p>
          </li>
          <li>
            <h4>All Other Contributors</h4>
            <p>Parents and staff who make PTO possible.</p>
          </li>
        </ul>
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
 <!-- Timeline side -->
      <div class="col-md-6 order-md-1">
        <ul class="history-timeline list-unstyled">
          <li><span class="year">2000</span> ─ PTO founded by six dedicated parents.</li>
          <li><span class="year">2005</span> ─ First Fall Festival raised $2,500…</li>
          <li><span class="year">2010</span> ─ Renovated outdoor reading garden…</li>
          <li><span class="year">2020</span> ─ Pivoted to virtual events…</li>
          <li><span class="year">2023</span> ─ Awarded tech grant for every classroom.</li>
        </ul>
      </div>
      <!-- Image side -->
      <div class="col-md-6 order-md-2 mb-4 mb-md-0">
        <figure class="wp-block-image size-large">
          <img src="https://dev-rhogan-cs50b-final.pantheonsite.io/wp-content/uploads/2025/05/hero-default-scaled.jpeg" alt="PTO founding photo"/>
          <figcaption class="mt-2 text-center text-muted small">
            Founded in 2000 with just a handful of parents.
          </figcaption>
        </figure>
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
            'description' => __( 'Grid of six key successes and events', 'understrap-child' ),
            'categories'  => [ 'about-page' ],
            'inserter'    => true,
            'content'     => <<<'HTML'
<section class="wp-block-group alignfull about-highlights-section py-5">
  <div class="container section-inner">
    <h2 class="has-text-align-center mb-4">Highlights</h2>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 g-4">
      <!-- 1 -->
      <div class="col">
        <div class="card border-0 shadow-sm">
          <figure class="wp-block-image"><img src="https://dev-rhogan-cs50b-final.pantheonsite.io/wp-content/uploads/2025/05/about_highlights_back_to_school_bash.png" alt="Back-to-School Bash"/></figure>
          <div class="card-body text-center">
            <h5 class="card-title mb-1">Back-to-School Bash</h5>
            <p class="small">Family carnival games, food trucks, and meet-the-teacher fun.</p>
          </div>
        </div>
      </div>
      <!-- 2 -->
      <div class="col">
        <div class="card border-0 shadow-sm">
          <figure class="wp-block-image"><img src="https://dev-rhogan-cs50b-final.pantheonsite.io/wp-content/uploads/2025/05/about_hightlightsfall_festival.png" alt="Fall Festival"/></figure>
          <div class="card-body text-center">
            <h5 class="card-title mb-1">Fall Festival</h5>
            <p class="small">Pumpkins, hayrides, and crafts to celebrate autumn.</p>
          </div>
        </div>
      </div>
      <!-- 3 -->
      <div class="col">
        <div class="card border-0 shadow-sm">
          <figure class="wp-block-image"><img src="https://dev-rhogan-cs50b-final.pantheonsite.io/wp-content/uploads/2025/05/about_highlights_spring_carnival.png" alt="Spring Carnival"/></figure>
          <div class="card-body text-center">
            <h5 class="card-title mb-1">Spring Carnival</h5>
            <p class="small">Games, rides, and food to welcome the warmer weather.</p>
          </div>
        </div>
      </div>
      <!-- 4 -->
      <div class="col">
        <div class="card border-0 shadow-sm">
          <figure class="wp-block-image"><img src="https://dev-rhogan-cs50b-final.pantheonsite.io/wp-content/uploads/2025/05/about_highlights_family_fun_night.png" alt="Family Fun Night"/></figure>
          <div class="card-body text-center">
            <h5 class="card-title mb-1">Family Fun Night</h5>
            <p class="small">Board games, snacks, and prizes for the whole family.</p>
          </div>
        </div>
      </div>
      <!-- 5 -->
      <div class="col">
        <div class="card border-0 shadow-sm">
          <figure class="wp-block-image"><img src="https://dev-rhogan-cs50b-final.pantheonsite.io/wp-content/uploads/2025/05/about_highlights_teacher_appreciation_day.png" alt="Teacher Appreciation Day"/></figure>
          <div class="card-body text-center">
            <h5 class="card-title mb-1">Teacher Appreciation Day</h5>
            <p class="small">Celebrating our educators with treats and thank-you notes.</p>
          </div>
        </div>
      </div>
      <!-- 6 -->
      <div class="col">
        <div class="card border-0 shadow-sm">
          <figure class="wp-block-image"><img src="https://dev-rhogan-cs50b-final.pantheonsite.io/wp-content/uploads/2025/05/about_highlights_reading_rodeo.png" alt="Reading Rodeo"/></figure>
          <div class="card-body text-center">
            <h5 class="card-title mb-1">Reading Rodeo</h5>
            <p class="small">Students earn “ticket” prizes for every book they finish.</p>
          </div>
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
        'whited/about-cta-join',
        [
            'title'       => __( 'How to Join PTO', 'understrap-child' ),
            'description' => __( 'Warm, inviting call-to-action to join PTO with flexible involvement', 'understrap-child' ),
            'categories'  => [ 'about-page', 'cta' ],
            'inserter'    => true,
            'content'     => <<<'HTML'
<section class="wp-block-group alignfull how-to-join-section py-5 bg-light">
  <div class="container section-inner text-center">
    <h2>How to Join</h2>
    <div class="row text-center mb-4">
      <div class="col-md-4">
        <i class="fas fa-calendar fa-2x mb-2 text-primary"></i>
        <h5>Set Your Pace</h5>
        <p>Volunteer once a year or every month—it's up to you.</p>
      </div>
      <div class="col-md-4">
        <i class="fas fa-hand-holding-heart fa-2x mb-2 text-primary"></i>
        <h5>Pick Your Role</h5>
        <p>Chair a big event or help with small tasks like baking treats.</p>
      </div>
      <div class="col-md-4">
        <i class="fas fa-clock fa-2x mb-2 text-primary"></i>
        <h5>Choose Your Time</h5>
        <p>Give an hour, an afternoon, or every week—whatever fits your schedule.</p>
      </div>
    </div>
    <a href="/get-involved" class="btn btn-primary btn-lg">Get Involved</a>
  </div>
</section>

HTML
        ]
    );
}, 11 );



/* ───────────────────────────────
 * EVENTS PAGE — block patterns
 * ───────────────────────────────
 */
add_action( 'init', function () {

	/* 1. Category */
register_block_pattern(
	'whited/events-hero',
	[
		'title'       => __( 'Events – Hero', 'understrap-child' ),
		'categories'  => [ 'events-page' ],
		'content'     => <<<'HTML'
<section class="wp-block-group alignfull events-hero-section bg-light text-center d-flex flex-column justify-content-center">
	<div class="container section-inner">
		<h1 class="hero-headline fw-bold mb-3">
			Join the Fun – Stay Connected<br/>
			<span class="d-block">with Whited PTO Events</span>
		</h1>

		<p class="lead mb-3">Mark Your Calendar and Get Involved!</p>

		<a class="btn btn-outline-primary btn-lg d-inline-flex align-items-center gap-2"
		   href="#" target="_blank" rel="noopener">
			<i class="far fa-calendar-plus fa-lg flex-shrink-0"></i>
			Subscribe with Google Calendar
		</a>
	</div>
</section>
HTML
	]
);


	/* 3. UPCOMING EVENTS pattern  (card list) */
	register_block_pattern(
		'whited/events-upcoming-cards',
		[
			'title'       => __( 'Events – Upcoming (Cards)', 'understrap-child' ),
			'description' => __( 'Stacked list of events with flyer & map links', 'understrap-child' ),
			'categories'  => [ 'events-page' ],
			'inserter'    => true,
			'content'     => <<<'HTML'
<section class="wp-block-group alignfull events-upcoming-section bg-white py-5">
  <div class="container section-inner">

    <h2 class="text-uppercase fw-bold mb-3">Upcoming Events</h2>
    <p class="mb-4">Stay connected with our latest events! Join us for school fundraisers, community gatherings, and fun activities for families.</p>

    <!-- Event Card 1 -->
    <div class="card event-card border-0 shadow-sm mb-4 p-md-4 p-3">
      <div class="row g-md-4 align-items-start flex-md-row flex-column">
        <div class="col-md-3 mb-3 mb-md-0">
          <figure class="event-thumb ratio ratio-1x1 bg-body-tertiary d-flex align-items-center justify-content-center rounded">
                    <!-- <figure class="wp-block-image size-large"> -->
          <img src="https://dev-rhogan-cs50b-final.pantheonsite.io/wp-content/uploads/2025/05/holiday_craft_faire_flyer.png" alt="PTO Board Group Photo"/>
        <!-- </figure> -->
          </figure>
        </div>
        <div class="col-md-9">
          <h3 class="h5 mb-1">Whited Elementary Holiday Vendor & Craft Faire</h3>
          <p class="small mb-1"><i class="far fa-calendar-alt me-1"></i>December 7, 2024 · <i class="far fa-clock me-1"></i>10 AM – 2 PM</p>
          <p class="small mb-2"><i class="fas fa-map-marker-alt me-1"></i>Douglas Whited MPR</p>
          <p class="text-muted mb-3">Holiday crafts, homebaked goods, jewelry, candles, tamales, and more!</p>
          <div class="d-flex">
            <a class="btn btn-outline-primary btn-sm" href="https://dev-rhogan-cs50b-final.pantheonsite.io/wp-content/uploads/2025/05/holiday_craft_faire_flyer.png" target="_blank">View Flyer</a>
            <a class="btn btn-primary btn-sm ms-2" href="https://maps.app.goo.gl/M1s96NAkRd7vwLS77" target="_blank">Get Directions</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Event Card 2 -->
    <div class="card event-card border-0 shadow-sm mb-4 p-md-4 p-3">
      <div class="row g-md-4 align-items-start flex-md-row flex-column">
        <div class="col-md-3 mb-3 mb-md-0">
          <figure class="event-thumb ratio ratio-1x1 bg-body-tertiary d-flex align-items-center justify-content-center rounded">
          <img src="https://dev-rhogan-cs50b-final.pantheonsite.io/wp-content/uploads/2025/05/pto_flyer.png" alt="PTO Board Group Photo"/>
          </figure>
        </div>
        <div class="col-md-9">
          <h3 class="h5 mb-1">PTO Meeting</h3>
          <p class="small mb-1"><i class="far fa-calendar-alt me-1"></i>November 14, 2024 · <i class="far fa-clock me-1"></i>8:20 AM</p>
          <p class="small mb-2"><i class="fas fa-map-marker-alt me-1"></i>Whited Elementary Library</p>
          <p class="text-muted mb-3">Monthly PTO gathering to discuss upcoming events, budgets, and volunteer opportunities.</p>
          <div class="d-flex">
            <a class="btn btn-outline-primary btn-sm" href="https://dev-rhogan-cs50b-final.pantheonsite.io/wp-content/uploads/2025/05/pto_flyer.png" target="_blank">View Flyer</a>
            <a class="btn btn-primary btn-sm ms-2" href="https://maps.app.goo.gl/M1s96NAkRd7vwLS77" target="_blank">Get Directions</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Event Card 3 -->
    <div class="card event-card border-0 shadow-sm mb-4 p-md-4 p-3">
      <div class="row g-md-4 align-items-start flex-md-row flex-column">
        <div class="col-md-3 mb-3 mb-md-0">
          <figure class="event-thumb ratio ratio-1x1 bg-body-tertiary d-flex align-items-center justify-content-center rounded">
          <img src="https://dev-rhogan-cs50b-final.pantheonsite.io/wp-content/uploads/2025/05/santa_rosa_pizzeria_flyer.png" alt="PTO Board Group Photo"/>
          </figure>
        </div>
        <div class="col-md-9">
          <h3 class="h5 mb-1">It’s a Pizza Party!</h3>
          <p class="small mb-1"><i class="far fa-calendar-alt me-1"></i>November 19, 2024 · <i class="far fa-clock me-1"></i>12 PM – 10 PM</p>
          <p class="small mb-2"><i class="fas fa-map-marker-alt me-1"></i>Santa Rosa Pizzeria</p>
          <p class="text-muted mb-3">20% of your purchase will be donated to our PTO—just mention “Whited” at the counter!</p>
          <div class="d-flex">
            <a class="btn btn-outline-primary btn-sm" href="https://dev-rhogan-cs50b-final.pantheonsite.io/wp-content/uploads/2025/05/santa_rosa_pizzeria_flyer.png" target="_blank">View Flyer</a>
            <a class="btn btn-primary btn-sm ms-2" href="https://maps.app.goo.gl/ALZJHYvJLe5EaUwq8" target="_blank">Get Directions</a>
          </div>
        </div>
      </div>
    </div>

  </div>
</section>
HTML
		]
	);

	/* 4. GOOGLE CALENDAR pattern */
	register_block_pattern(
		'whited/events-calendar',
		[
			'title'       => __( 'Events – Full Calendar', 'understrap-child' ),
			'description' => __( 'Embedded Google Calendar with heading', 'understrap-child' ),
			'categories'  => [ 'events-page' ],
			'inserter'    => true,
			'content'     => <<<'HTML'
<section class="wp-block-group alignfull events-calendar-section bg-light py-5">
	<div class="container section-inner">
 <h2 class="fw-bold mb-2">Full Event Calendar</h2>
       <p class="lead mb-4">Sync our PTO events directly to your own calendar with one click.</p>

		<!-- Embed -->
		<div class="ratio ratio-16x9 shadow-sm rounded overflow-hidden">
		<iframe src="https://calendar.google.com/calendar/embed?src=be9c1435fae1ea24f4971bddfe5cf4c45b08200ec7fb72c2ca894eb7f9a2f77e%40group.calendar.google.com&ctz=America%2FLos_Angeles" style="border: 0" width="800" height="600" frameborder="0" scrolling="no"></iframe>
		</div>
	</div>
</section>
HTML
		]
	);

}, 11 ); // end add_action






/**
 * ─────────────────────────────────────────────────
 * Get Involved Page — Block Patterns
 * ─────────────────────────────────────────────────
 */

/**
 * 1. Hero Section (full-width)
 */
add_action( 'init', function() {
    register_block_pattern(
        'whited/get-involved-hero',
        [
            'title'       => __( 'Get Involved – Hero', 'understrap-child' ),
            'description' => __( 'Full-width hero section with headline and CTA', 'understrap-child' ),
            'categories'  => [ 'get-involved-page' ],
            'inserter'    => true,
            'content'     => <<<'HTML'
<section class="section section--gray get-involved__hero alignfull">
  <div class="section__inner text-center">
    <h1 class="section__heading">
      Be a Part of Something Bigger –<br/>
      Get Involved with Whited PTO!
    </h1>
    <p class="section__subtitle">
      Your time, skills, and support make a difference for our students. Join us today!
    </p>
    <a href="#volunteer-form" class="btn btn-primary btn-lg">Sign Up to Volunteer</a>
  </div>
</section>
HTML
        ]
    );
}, 11 );

/**
 * 2. Ways to Get Involved (Card Grid → CSS Grid)
 */
add_action( 'init', function() {
    register_block_pattern(
        'whited/get-involved-ways',
        [
            'title'       => __( 'Get Involved – Ways to Participate', 'understrap-child' ),
            'description' => __( 'Grid of cards showing different ways to get involved', 'understrap-child' ),
            'categories'  => [ 'get-involved-page' ],
            'inserter'    => true,
            'content'     => <<<'HTML'
<section class="section section--white get-involved__card-list alignfull">
  <div class="section__inner">
    <h2 class="section__heading">Ways to Get Involved</h2>

    <div class="section__cards">
      <!-- card 1 -->
      <div class="card h-100 border-0 shadow-sm p-4 d-flex flex-column">
        <i class="fas fa-hands-helping fa-2x mb-3 text-primary"></i>
        <h5 class="card-title">Volunteer at an Event</h5>
        <p class="card-text text-muted">Help us run school events like Fall Harvest Festival or Family Fun Night.</p>
        <a href="#volunteer-form" class="btn btn-outline-primary mt-auto">Sign Up</a>
      </div>

      <!-- card 2 -->
      <div class="card h-100 border-0 shadow-sm p-4 d-flex flex-column">
        <i class="fas fa-users fa-2x mb-3 text-primary"></i>
        <h5 class="card-title">Join the PTO</h5>
        <p class="card-text text-muted">Support planning, fundraising, and school needs by becoming a member.</p>
        <a href="#volunteer-form" class="btn btn-outline-primary mt-auto">Learn More</a>
      </div>

      <!-- card 3 -->
      <div class="card h-100 border-0 shadow-sm p-4 d-flex flex-column">
        <i class="fas fa-hand-holding-dollar fa-2x mb-3 text-primary"></i>
        <h5 class="card-title">Donate to Support Our School</h5>
        <p class="card-text text-muted">Your gifts directly fund classroom supplies, field trips, and special programs.</p>
        <a href="#volunteer-form" class="btn btn-outline-primary mt-auto">Make a Donation</a>
      </div>

      <!-- card 4 -->
      <div class="card h-100 border-0 shadow-sm p-4 d-flex flex-column">
        <i class="fas fa-school fa-2x mb-3 text-primary"></i>
        <h5 class="card-title">Classroom &amp; Teacher Support</h5>
        <p class="card-text text-muted">Provide resources or time in the classroom to enhance learning experiences.</p>
        <a href="#volunteer-form" class="btn btn-outline-primary mt-auto">Offer Support</a>
      </div>

      <!-- card 5 -->
      <div class="card h-100 border-0 shadow-sm p-4 d-flex flex-column">
        <i class="fas fa-bullhorn fa-2x mb-3 text-primary"></i>
        <h5 class="card-title">Spread the Word</h5>
        <p class="card-text text-muted">Follow us on social media, share events, and help us reach more families.</p>
        <a href="#volunteer-form" class="btn btn-outline-primary mt-auto">Stay Updated</a>
      </div>

      <!-- card 6 -->
      <div class="card h-100 border-0 shadow-sm p-4 d-flex flex-column">
        <i class="fas fa-star fa-2x mb-3 text-primary"></i>
        <h5 class="card-title">Every Effort Counts!</h5>
        <p class="card-text text-muted">Whether big or small, your involvement helps build a stronger school community.</p>
        <a href="#volunteer-form" class="btn btn-outline-primary mt-auto">Email Us</a>
      </div>
    </div>
  </div>
</section>
HTML
        ]
    );
}, 11 );


/**
 * 3. Volunteer Sign-Up Form (two columns on desktop, full-width)
 */
add_action( 'init', function() {
    register_block_pattern(
        'whited/get-involved-form',
        [
            'title'       => __( 'Get Involved – Volunteer Form', 'understrap-child' ),
            'description' => __( 'Two-column sign-up form: personal info + preferences', 'understrap-child' ),
            'categories'  => [ 'get-involved-page' ],
            'inserter'    => true,
            'content'     => <<<'HTML'
<section id="volunteer-form" class="section section--gray get-involved__form alignfull">
  <div class="section__inner">
    <h2 class="section__heading text-center">Sign Up to Volunteer</h2>
    <form class="row g-4">
      <div class="col-12 col-md-6">
        <label for="first-name" class="form-label">First Name</label>
        <input type="text" id="first-name" class="form-control" placeholder="Enter first name">
        <label for="last-name" class="form-label mt-3">Last Name</label>
        <input type="text" id="last-name" class="form-control" placeholder="Enter last name">
        <label for="email-address" class="form-label mt-3">Email Address</label>
        <input type="email" id="email-address" class="form-control" placeholder="you@example.com">
        <fieldset class="mt-3">
          <legend class="col-form-label">Preferred Contact Method</legend>
          <div class="form-check"><input class="form-check-input" type="checkbox" id="contact-email"><label class="form-check-label" for="contact-email">Email</label></div>
          <div class="form-check"><input class="form-check-input" type="checkbox" id="contact-phone"><label class="form-check-label" for="contact-phone">Phone</label></div>
          <div class="form-check"><input class="form-check-input" type="checkbox" id="contact-text"><label class="form-check-label" for="contact-text">Text</label></div>
        </fieldset>
      </div>
      <div class="col-12 col-md-6">
        <label for="interest" class="form-label">Select Volunteer Options</label>
        <select id="interest" class="form-select mb-3">
          <option>Volunteer at an Event</option>
          <option>Join the PTO</option>
          <option>Donate to Support Our School</option>
          <option>Classroom &amp; Teacher Support</option>
          <option>Spread the Word</option>
          <option>Every Effort Counts</option>
        </select>
        <label for="frequency" class="form-label">Preferred Commitment Frequency</label>
        <select id="frequency" class="form-select mb-3">
          <option>Once</option>
          <option>Monthly</option>
          <option>Weekly</option>
        </select>
        <label for="questions" class="form-label">Any Questions/Concerns? <small class="text-muted">(Optional)</small></label>
        <textarea id="questions" class="form-control mb-3" rows="3"></textarea>
      </div>
      <div class="col-12 text-center">
        <button type="submit" class="btn btn-primary btn-lg">Sign Me Up!</button>
      </div>
    </form>
  </div>
</section>
HTML
        ]
    );
}, 11 );


/** 
 *   LAST 5 PAGES DONT EDIT ABOVE
 */

add_action( 'init', function() {
    // 1. Hero
    register_block_pattern(
        'whited/hero',
        [
            'title'       => __( 'Hero Section', 'understrap-child' ),
            'description' => __( 'Full-width hero with headline, subhead, and CTA', 'understrap-child' ),
            'categories'  => [ 'layout' ],
            'inserter'    => true,
            'content'     => <<<'HTML'
<section class="hero alignfull">
  <div class="section__inner">
    <h1>Welcome to Our Community</h1>
    <p class="fs-5">Supporting Students – Empowering Families</p>
    <a href="#get-involved" class="btn btn-primary btn-lg">Get Involved</a>
  </div>
</section>
HTML
        ]
    );

    // 2. Mission Section
    register_block_pattern(
        'whited/mission',
        [
            'title'       => __( 'Mission Section', 'understrap-child' ),
            'description' => __( 'Centered mission statement on gray background', 'understrap-child' ),
            'categories'  => [ 'layout' ],
            'inserter'    => true,
            'content'     => <<<'HTML'
<section class="mission-section section section--gray alignfull">
  <div class="section__inner container">
    <h2>At Whited Elementary PTO, our mission is simple:</h2>
    <p>
      We strive to enhance the educational experience…  
      Through volunteer efforts, fundraising events, and open communication,  
      we work together to create a positive environment where every family can thrive.
    </p>
  </div>
</section>
HTML
        ]
    );

    // 3. Feature Grid
    register_block_pattern(
        'whited/feature-grid',
        [
            'title'       => __( 'Feature Grid: Why Get Involved', 'understrap-child' ),
            'description' => __( 'Three-column grid with icons, titles, copy, and primary CTA', 'understrap-child' ),
            'categories'  => [ 'get-involved-page' ],
            'inserter'    => true,
            'content'     => <<<'HTML'
<section class="feature-grid section alignfull">
  <div class="container">
    <h2 class="text-center mb-5">Why Get Involved?</h2>
    <div class="row">
      <div class="col-4 text-center feature-grid__item">
        <i class="fas fa-handshake fa-3x mb-3"></i>
        <h3>Support Our Students</h3>
        <p>Volunteering in the classroom or at events …</p>
      </div>
      <div class="col-4 text-center feature-grid__item">
        <i class="fas fa-users fa-3x mb-3"></i>
        <h3>Build Community</h3>
        <p>Join family-friendly gatherings like our Fall Festival …</p>
      </div>
      <div class="col-4 text-center feature-grid__item">
        <i class="fas fa-school fa-3x mb-3"></i>
        <h3>Bridge Home &amp; School</h3>
        <p>Serve as a liaison between parents and teachers …</p>
      </div>
    </div>
    <div class="text-center mt-4">
      <a href="#get-involved" class="btn btn-primary btn-lg">Get Involved</a>
    </div>
  </div>
</section>
HTML
        ]
    );

    // 4. Subscribe & Calendar CTA
    register_block_pattern(
        'whited/subscribe-calendar',
        [
            'title'       => __( 'Subscribe & Calendar CTA', 'understrap-child' ),
            'description' => __( 'Buttons to download ICS and link to Google Calendar', 'understrap-child' ),
            'categories'  => [ 'events-page' ],
            'inserter'    => true,
            'content'     => <<<'HTML'
<section class="subscribe-calendar section alignfull">
  <div class="section__inner text-center">
    <a href="/path/to/whited-pto-events.ics" class="btn btn-secondary me-2" download>
      <i class="fas fa-calendar-alt"></i> Subscribe to Calendar
    </a>
    <a href="https://calendar.google.com/calendar/r?cid=YOUR_ICAL_URL" class="btn btn-outline-primary" target="_blank" rel="noopener">
      <i class="fab fa-google"></i> Google Calendar
    </a>
  </div>
</section>
HTML
        ]
    );

    // 5. Upcoming Events List
    register_block_pattern(
        'whited/events-list',
        [
            'title'       => __( 'Upcoming Events List', 'understrap-child' ),
            'description' => __( 'Repeatable event cards with image, meta, description, and actions', 'understrap-child' ),
            'categories'  => [ 'events-page' ],
            'inserter'    => true,
            'content'     => <<<'HTML'
<section class="events-list section alignfull">
  <div class="section__inner container">
    <h2 class="section-heading">Upcoming Events</h2>
    <p class="section-subheading">Join us for our upcoming events! Click the buttons below to view flyers and get directions.</p>

    <div class="event-card">
      <div class="event-card__media">
        <a href="https://dev-rhogan-cs50b-final.pantheonsite.io/wp-content/uploads/2025/05/holiday_craft_faire_flyer.png" target="_blank" rel="noopener noreferrer">
          <img src="https://dev-rhogan-cs50b-final.pantheonsite.io/wp-content/uploads/2025/05/holiday_craft_faire_flyer.png" alt="Holiday Vendor & Craft Faire Flyer" />
        </a>
      </div>
      <div class="event-card__content">
        <h3>Whited Elementary Holiday Vendor &amp; Craft Faire</h3>
        <div class="event-meta">
          <div><i class="fas fa-calendar"></i> December 7, 2024</div>
          <div><i class="fas fa-clock"></i> 10 AM – 2 PM</div>
          <div><i class="fas fa-map-marker-alt"></i> Douglas Whited MPR</div>
        </div>
        <p class="event-description">Holiday crafts, homebaked goods, jewelry, candles, tamales, and more!</p>
        <div class="event-actions">
          <a href="https://dev-rhogan-cs50b-final.pantheonsite.io/wp-content/uploads/2025/05/holiday_craft_faire_flyer.png" download class="btn btn-outline-primary">
            <i class="fas fa-download"></i> Download Flyer
          </a>
          <a href="#" class="btn btn-primary">Get Directions</a>
          <a href="/path/to/holiday_craft_faire.ics" class="btn btn-secondary ms-2" download>
            <i class="fas fa-calendar-plus"></i> Add to Calendar
          </a>
        </div>
      </div>
    </div>

    <!-- Repeat .event-card for each event -->
  </div>
</section>
HTML
        ]
    );

} );


// 6. Media Highlight – History / Spotlight
register_block_pattern(
    'whited/media-highlight',
    [
        'title'       => __( 'Media Highlight', 'understrap-child' ),
        'description' => __( 'Two-column highlight: years list + image', 'understrap-child' ),
        'categories'  => [ 'about-page' ],
        'inserter'    => true,
        'content'     => <<<'HTML'
<section class="media-highlight section alignfull media-highlight--v-center media-highlight--h-center">
  <div class="section__inner container">
    <h2 class="section-heading">History of the PTO</h2>
    <div class="media-highlight__wrap">
      <!-- Text Column -->
      <div class="media-highlight__text">
        <ul class="highlight-list">
          <li><span class="highlight-list__year">2000</span> PTO founded by six dedicated parents.</li>
          <li><span class="highlight-list__year">2005</span> First Fall Festival raised $2,500…</li>
          <li><span class="highlight-list__year">2010</span> Renovated outdoor reading garden…</li>
          <li><span class="highlight-list__year">2020</span> Pivoted to virtual events…</li>
          <li><span class="highlight-list__year">2023</span> Awarded tech grant for every classroom.</li>
        </ul>
      </div>
      <!-- Image Column -->
      <figure class="media-highlight__media">
        <img src="https://dev-rhogan-cs50b-final.pantheonsite.io/wp-content/uploads/2025/05/hero-default-1024x683.jpeg"
             alt="Douglas Whited Elementary school front" />
        <figcaption class="media-highlight__caption">Founded in 2000 with just a handful of parents.</figcaption>
      </figure>
    </div>
  </div>
</section>
HTML
    ]
);

// 7. Volunteer Sign-Up Form
register_block_pattern(
    'whited/volunteer-form',
    [
        'title'       => __( 'Volunteer Sign-Up Form', 'understrap-child' ),
        'description' => __( 'Two-column sign-up form: personal info + preferences', 'understrap-child' ),
        'categories'  => [ 'get-involved-page' ],
        'inserter'    => true,
        'content'     => <<<'HTML'
<section id="volunteer-form" class="volunteer-form section section--gray alignfull">
  <div class="section__inner container">
    <h2 class="section-heading text-center mb-5">Sign Up to Volunteer</h2>
    <form class="row g-4">
      <div class="col-12 col-md-6">
        <h3 class="form-subheading">Personal Information</h3>
        <label class="form-label"><i class="fas fa-user"></i> Volunteer Name</label>
        <input type="text" class="form-control" placeholder="First & Last Name">
        <label class="form-label mt-3"><i class="fas fa-envelope"></i> Email Address</label>
        <input type="email" class="form-control" placeholder="you@example.com">
        <label class="form-label mt-3"><i class="fas fa-phone"></i> Phone Number</label>
        <input type="tel" class="form-control" placeholder="707-555-1234">
        <fieldset class="mt-3">
          <legend class="col-form-label"><i class="fas fa-comments"></i> Preferred Contact Method</legend>
          <div class="form-check"><input class="form-check-input" type="checkbox"><label class="form-check-label">Email</label></div>
          <div class="form-check"><input class="form-check-input" type="checkbox"><label class="form-check-label">Phone</label></div>
          <div class="form-check"><input class="form-check-input" type="checkbox"><label class="form-check-label">Text</label></div>
        </fieldset>
      </div>
      <div class="col-12 col-md-6">
        <h3 class="form-subheading">Volunteer Preferences</h3>
        <label class="form-label"><i class="fas fa-hands-helping"></i> Interests</label>
        <select class="form-select mb-3">
          <option>Volunteer at an Event</option>
          <option>Join the PTO Board</option>
          <option>Donate to Support Our School</option>
        </select>
        <label class="form-label"><i class="fas fa-clock"></i> Preferred Times</label>
        <select class="form-select mb-3">
          <option>Morning</option>
          <option>Afternoon</option>
          <option>Evening</option>
        </select>
        <label class="form-label"><i class="fas fa-question-circle"></i> Questions/Requests <small>(Optional)</small></label>
        <textarea class="form-control" rows="4" placeholder="Enter any questions or concerns"></textarea>
      </div>
      <div class="col-12 text-center">
        <button type="submit" class="btn btn-primary btn-lg">
          <i class="fas fa-paper-plane"></i> Sign Me Up!
        </button>
      </div>
    </form>
  </div>
</section>
HTML
    ]
);

// 8. FAQ Section
register_block_pattern(
    'whited/faq-section',
    [
        'title'       => __( 'FAQ Section', 'understrap-child' ),
        'description' => __( 'Accordion with common questions & answers', 'understrap-child' ),
        'categories'  => [ 'layout' ],
        'inserter'    => true,
        'content'     => <<<'HTML'
<section class="faq-section section alignfull">
  <div class="section__inner container">
    <h2 class="section-heading text-center mb-4">Frequently Asked Questions</h2>
    <div class="accordion" id="faqAccordion">
      <!-- Q1 -->
      <div class="accordion-item">
        <h3 class="accordion-header" id="faqHeading1">
          <button class="accordion-button collapsed"
                  type="button"
                  data-bs-toggle="collapse"
                  data-bs-target="#faqCollapse1"
                  aria-expanded="false"
                  aria-controls="faqCollapse1">
            <i class="fas fa-question-circle text-primary me-2"></i>
            How can I donate to the PTO?
          </button>
        </h3>
        <div id="faqCollapse1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
          <div class="accordion-body">
            You can donate online via our <a href="#">Donations Page</a> or send a check to Douglas Whited Elementary.
          </div>
        </div>
      </div>
      <!-- Q2 -->
      <div class="accordion-item">
        <h3 class="accordion-header" id="faqHeading2">
          <button class="accordion-button collapsed"
                  type="button"
                  data-bs-toggle="collapse"
                  data-bs-target="#faqCollapse2"
                  aria-expanded="false"
                  aria-controls="faqCollapse2">
            <i class="fas fa-question-circle text-primary me-2"></i>
            When and where are meetings held?
          </button>
        </h3>
        <div id="faqCollapse2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
          <div class="accordion-body">
            Meetings occur the second Tuesday monthly at 6pm in the school library.
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
HTML
    ]
);

// 9. Spotlight Stats
register_block_pattern(
    'whited/stats',
    [
        'title'       => __( 'Spotlight Stats', 'understrap-child' ),
        'description' => __( 'Four key numbers in a row', 'understrap-child' ),
        'categories'  => [ 'layout' ],
        'inserter'    => true,
        'content'     => <<<'HTML'
<section class="stats-section section alignfull">
  <div class="section__inner container">
    <h2 class="section-heading text-center mb-4">By the Numbers</h2>
    <div class="row stats-grid">
      <div class="col-sm-6 col-md-3 stat">
        <div class="stat-value">336</div><div class="stat-label">Students Enrolled</div>
      </div>
      <div class="col-sm-6 col-md-3 stat">
        <div class="stat-value">10</div><div class="stat-label">Pages on Site</div>
      </div>
      <div class="col-sm-6 col-md-3 stat">
        <div class="stat-value">23</div><div class="stat-label">Events Hosted</div>
      </div>
      <div class="col-sm-6 col-md-3 stat">
        <div class="stat-value">1500</div><div class="stat-label">Volunteer Hours</div>
      </div>
    </div>
  </div>
</section>
HTML
    ]
);

// 10. How It Works Steps
register_block_pattern(
    'whited/steps',
    [
        'title'       => __( 'How It Works Steps', 'understrap-child' ),
        'description' => __( 'Three-step icon-driven process', 'understrap-child' ),
        'categories'  => [ 'get-involved-page' ],
        'inserter'    => true,
        'content'     => <<<'HTML'
<section class="steps-section section alignfull">
  <div class="section__inner container text-center">
    <h2 class="section-heading mb-4">How It Works</h2>
    <div class="row g-4">
      <div class="col-md-4 step">
        <i class="fas fa-user-plus fa-2x mb-2"></i><h3>Sign Up</h3><p>Create your volunteer profile in minutes.</p>
      </div>
      <div class="col-md-4 step">
        <i class="fas fa-calendar-check fa-2x mb-2"></i><h3>Choose an Event</h3><p>Browse upcoming activities and grab a spot.</p>
      </div>
      <div class="col-md-4 step">
        <i class="fas fa-hands-helping fa-2x mb-2"></i><h3>Show Up &amp; Help</h3><p>Join us on the big day and make a difference.</p>
      </div>
    </div>
  </div>
</section>
HTML
    ]
);

// 11. Quick Links
register_block_pattern(
    'whited/quick-links',
    [
        'title'       => __( 'Quick Links', 'understrap-child' ),
        'description' => __( 'Inline list of key site links', 'understrap-child' ),
        'categories'  => [ 'layout' ],
        'inserter'    => true,
        'content'     => <<<'HTML'
<section class="quick-links section alignfull">
  <div class="section__inner container text-center">
    <h2 class="section-heading mb-4">Quick Links</h2>
    <ul class="links-list list-inline">
      <li class="list-inline-item"><a href="#mission">Mission &amp; Purpose</a></li>
      <li class="list-inline-item"><a href="#get-involved">Get Involved</a></li>
      <li class="list-inline-item"><a href="#events">Upcoming Events</a></li>
      <li class="list-inline-item"><a href="#donate">Donate</a></li>
    </ul>
  </div>
</section>
HTML
    ]
);

// 12. News Archive List
register_block_pattern(
    'whited/archive-list',
    [
        'title'       => __( 'News Archive List', 'understrap-child' ),
        'description' => __( 'Filterable list of archived posts', 'understrap-child' ),
        'categories'  => [ 'news-page' ],
        'inserter'    => true,
        'content'     => <<<'HTML'
<section class="archive-section section alignfull">
  <div class="section__inner container">
    <h2 class="section-heading mb-4">News Archive</h2>
    <div class="d-flex mb-3">
      <select class="form-select w-auto me-3">
        <option>All Categories</option>
        <option>Announcements</option>
        <option>Fundraisers</option>
      </select>
      <select class="form-select w-auto">
        <option>All Dates</option>
        <option>2025</option>
        <option>2024</option>
      </select>
    </div>
    <ul class="archive-list">
      <li><a href="#">Fall Harvest Festival Recap <small>(Oct 15, 2024)</small></a></li>
      <li><a href="#">Spring Carnival Photos <small>(Apr 20, 2024)</small></a></li>
      <!-- more items -->
    </ul>
  </div>
</section>
HTML
    ]
);

// 13. FAQ Teaser
register_block_pattern(
    'whited/faq-teaser',
    [
        'title'       => __( 'FAQ Teaser', 'understrap-child' ),
        'description' => __( 'Call-out with link to full FAQ page', 'understrap-child' ),
        'categories'  => [ 'layout' ],
        'inserter'    => true,
        'content'     => <<<'HTML'
<section class="faq-teaser section alignfull text-center">
  <div class="section__inner container">
    <p>Can’t find what you’re looking for? <a href="/faq" class="text-primary fw-bold">Visit our FAQ <i class="fas fa-chevron-right"></i></a></p>
  </div>
</section>
HTML
    ]
);

// 14. Testimonials Carousel
register_block_pattern(
    'whited/testimonials',
    [
        'title'       => __( 'Testimonials Carousel', 'understrap-child' ),
        'description' => __( 'Rotating quotes from parents', 'understrap-child' ),
        'categories'  => [ 'layout' ],
        'inserter'    => true,
        'content'     => <<<'HTML'
<section class="testimonials-section section alignfull">
  <div class="section__inner container text-center">
    <h2 class="section-heading mb-4">What Parents Say</h2>
    <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner">
        <div class="carousel-item active">
          <blockquote>“Joining the PTO has been the best decision for my family. We’ve made lifelong friends!”</blockquote>
          <footer>— Jane Doe, Parent</footer>
        </div>
        <div class="carousel-item">
          <blockquote>“Our kids love the events. The PTO really brings the community together.”</blockquote>
          <footer>— Mark Smith, Parent</footer>
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev">
        <i class="fas fa-chevron-left fa-lg"></i>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next">
        <i class="fas fa-chevron-right fa-lg"></i>
      </button>
    </div>
  </div>
</section>
HTML
    ]
);

// 15. Map Embed
register_block_pattern(
    'whited/map-embed',
    [
        'title'       => __( 'Google Map Embed', 'understrap-child' ),
        'description' => __( 'Full-width embedded Google Map', 'understrap-child' ),
        'categories'  => [ 'contact-page' ],
        'inserter'    => true,
        'content'     => <<<'HTML'
<section class="map-section section alignfull">
  <div class="section__inner container">
    <h2 class="section-heading text-center mb-4">Our Location</h2>
    <div class="map-container">
      <iframe src="https://www.google.com/maps/embed?...YOUR_MAP_URL..." width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
    </div>
  </div>
</section>
HTML
    ]
);
