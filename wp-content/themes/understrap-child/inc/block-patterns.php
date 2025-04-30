<?php
/**
 * Register custom block-pattern categories & patterns.
 *
 * @package understrap-child
 */

if ( ! function_exists( 'understrap_child_register_block_patterns' ) ) :

	function understrap_child_register_block_patterns() {

		/* -------------------------------------------------------------
		 * Categories
		 * ----------------------------------------------------------- */
		if ( function_exists( 'register_block_pattern_category' ) ) {
			$cats = [
				'hero'      => __( 'Hero Sections',      'understrap-child' ),
				'events'    => __( 'Events Sections',    'understrap-child' ),
				'about'     => __( 'About Sections',     'understrap-child' ),
				'volunteer' => __( 'Volunteer Sections', 'understrap-child' ),
				'contact'   => __( 'Contact Sections',   'understrap-child' ),
			];
			foreach ( $cats as $slug => $label ) {
				register_block_pattern_category( $slug, [ 'label' => $label ] );
			}
		}

		/* -------------------------------------------------------------
		 * Bail early if patterns API unavailable
		 * ----------------------------------------------------------- */
		if ( ! function_exists( 'register_block_pattern' ) ) {
			return;
		}

		/* -------------------------------------------------------------
		 * 1.  Full-width hero  (existing)
		 * ----------------------------------------------------------- */
        register_block_pattern(
            'understrap-child/hero-full',
            [
              'title'      => __( 'Full-width Hero', 'understrap-child' ),
              'categories' => [ 'hero' ],
              'content'    => sprintf(
                '<!-- wp:cover {"url":"%1$s","dimRatio":50,"isDark":false,"align":"full"} -->' .
                  '<div class="wp-block-cover alignfull has-background-dim" style="background-image:url(%1$s)">' .
                    '<div class="wp-block-cover__inner-container text-white">' .
                      '<!-- wp:heading {"textAlign":"center","className":"text-white"} -->' .
                      '<h1 class="has-text-align-center text-white">Welcome to Whited PTO</h1>' .
                      '<!-- /wp:heading -->' .
                      '<!-- wp:paragraph {"align":"center","className":"text-white"} -->' .
                      '<p class="has-text-align-center text-white">Supporting Our Students, Empowering Our Community</p>' .
                      '<!-- /wp:paragraph -->' .
                      '<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->' .
                        '<div class="wp-block-buttons">' .
                          '<!-- wp:button {"className":"btn btn-primary text-white"} -->' .
                            '<div class="wp-block-button"><a class="wp-block-button__link btn btn-primary text-white">Get Involved</a></div>' .
                          '<!-- /wp:button -->' .
                        '</div>' .
                      '<!-- /wp:buttons -->' .
                    '</div>' .
                  '</div>' .
                '<!-- /wp:cover -->',
                esc_url( get_stylesheet_directory_uri() . '/images/hero-default.jpg' )
              ),
            ]
          );
          

		/* -------------------------------------------------------------
		 * 2.  Featured events list  (existing)
		 * ----------------------------------------------------------- */
        register_block_pattern(
            'understrap-child/featured-events',
            [
                'title'      => __( 'Featured Events', 'understrap-child' ),
                'categories' => [ 'events' ],
                'content'    => '
                    <div class="container py-5">
                      <h2 class="text-center mb-4">Featured Events</h2>
                      <div class="row g-4">
                        <div class="col-md-6">
                          <div class="card h-100 border-secondary">
                            <div class="card-body">
                              <h5 class="card-title">Fall Harvest Festival</h5>
                              <p class="card-text"><strong>Oct 15, 4–7 PM •</strong> Games, pumpkin patch, treats. Volunteers needed!</p>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="card h-100 border-secondary">
                            <div class="card-body">
                              <h5 class="card-title">Winter Book Fair</h5>
                              <p class="card-text"><strong>Dec 5–9</strong> Support literacy—buy a book, donate a book!</p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                ',
            ]
        );
	/* -------------------------------------------------------------
		 * 3.  About – mission & board overview
		 * ----------------------------------------------------------- */
		register_block_pattern(
			'understrap-child/about-overview',
			[
				'title'      => __( 'About Overview', 'understrap-child' ),
				'categories' => [ 'about' ],
				'content'    => '
<div class="container py-5">
  <div class="row">
    <div class="col-lg-7">
      <h2>Mission &amp; Purpose</h2>
      <p>We foster partnerships among parents, teachers, and the community to enrich every student’s learning experience.</p>
    </div>
    <div class="col-lg-5">
      <h3>PTO Board</h3>
      <ul class="list-unstyled">
        <li><strong>President:</strong> Jane Smith</li>
        <li><strong>Vice President:</strong> Mark Johnson</li>
        <li><strong>Treasurer:</strong> Amy Brown</li>
      </ul>
    </div>
  </div>
</div>',
			]
		);

		/* -------------------------------------------------------------
		 * 4.  About – highlights grid
		 * ----------------------------------------------------------- */
		register_block_pattern(
			'understrap-child/about-highlights',
			[
				'title'      => __( 'Highlights Grid', 'understrap-child' ),
				'categories' => [ 'about' ],
				'content'    => '
<div class="container text-center py-5">
  <h2 class="mb-4">Highlights</h2>
  <div class="row g-3">
    <div class="col-md-4"><figure><img src="#" class="img-fluid rounded"><figcaption class="mt-2">Back-to-School Bash</figcaption></figure></div>
    <div class="col-md-4"><figure><img src="#" class="img-fluid rounded"><figcaption class="mt-2">Fun Run</figcaption></figure></div>
    <div class="col-md-4"><figure><img src="#" class="img-fluid rounded"><figcaption class="mt-2">Spring Carnival</figcaption></figure></div>
    <div class="col-md-4"><figure><img src="#" class="img-fluid rounded"><figcaption class="mt-2">Teacher Appreciation</figcaption></figure></div>
    <div class="col-md-4"><figure><img src="#" class="img-fluid rounded"><figcaption class="mt-2">Reading Rodeo</figcaption></figure></div>
    <div class="col-md-4"><figure><img src="#" class="img-fluid rounded"><figcaption class="mt-2">Spirit Week</figcaption></figure></div>
  </div>
</div>',
			]
		);

		/* -------------------------------------------------------------
		 * 5.  Volunteer – cards
		 * ----------------------------------------------------------- */
		register_block_pattern(
			'understrap-child/volunteer-cards',
			[
				'title'      => __( 'Volunteer Opportunity Cards', 'understrap-child' ),
				'categories' => [ 'volunteer' ],
				'content'    => '
<div class="container py-5">
  <h2 class="text-center mb-4">Ways to Be Involved</h2>
  <div class="row g-4">
    <div class="col-md-6">
      <div class="card h-100 border-secondary">
        <div class="card-body">
          <h3 class="card-title">Chair an Event</h3>
          <p class="card-text">Lead planning for a single PTO event—templates &amp; team provided.</p>
          <a href="#" class="btn btn-primary">Learn More</a>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card h-100 border-secondary">
        <div class="card-body">
          <h3 class="card-title">Classroom Support</h3>
          <p class="card-text">Help teachers with copies, supplies, or reading groups.</p>
          <a href="#" class="btn btn-primary">Sign Up</a>
        </div>
      </div>
    </div>
  </div>
</div>',
			]
		);

		/* -------------------------------------------------------------
		 * 6.  Volunteer – signup band
		 * ----------------------------------------------------------- */
		register_block_pattern(
			'understrap-child/volunteer-signup',
			[
				'title'      => __( 'Volunteer Signup Band', 'understrap-child' ),
				'categories' => [ 'volunteer' ],
				'content'    => '
<div class="container-fluid bg-light py-5">
  <h2 class="text-center mb-3">Sign Up to Volunteer</h2>
  <p class="text-center mb-4">Let us know how you’d like to help—every hour counts.</p>
  <div class="text-center">
    <a href="#" class="btn btn-primary btn-lg">Volunteer Form</a>
  </div>
</div>',
			]
		);

		/* -------------------------------------------------------------
		 * 7.  Events – upcoming list (compact)
		 * ----------------------------------------------------------- */
		register_block_pattern(
			'understrap-child/events-list',
			[
				'title'      => __( 'Upcoming Events List', 'understrap-child' ),
				'categories' => [ 'events' ],
				'content'    => '
<div class="container py-5">
  <h2>Upcoming Events</h2>
  <ul class="list-group list-group-flush">
    <li class="list-group-item"><strong>Family Movie Night</strong> • Sept 20, 6 PM – Gym</li>
    <li class="list-group-item"><strong>Pajama Day</strong> • Oct 4 – School-wide spirit day</li>
    <li class="list-group-item"><strong>Turkey Trot</strong> • Nov 22, 9 AM – Track Field</li>
  </ul>
</div>',
			]
		);

		/* -------------------------------------------------------------
		 * 8.  Events – year-at-a-glance calendar
		 * ----------------------------------------------------------- */
		register_block_pattern(
			'understrap-child/events-calendar',
			[
				'title'       => __( 'Year-at-a-Glance Calendar', 'understrap-child' ),
				'categories'  => [ 'events' ],
				'description' => __( '12-month overview table. Replace with calendar-plugin block if preferred.', 'understrap-child' ),
				'content'     => '
<div class="container py-5">
  <table class="table table-bordered">
    <thead class="table-light">
      <tr><th>Month</th><th>Key Dates</th></tr>
    </thead>
    <tbody>
      <tr><td>August</td><td>First Day of School (Aug 14)</td></tr>
      <tr><td>September</td><td>Movie Night (Sept 20)</td></tr>
      <tr><td>October</td><td>Fall Festival (Oct 26)</td></tr>
      <tr><td>November</td><td>Turkey Trot (Nov 22)</td></tr>
      <tr><td>December</td><td>Book Fair (Dec 5-9)</td></tr>
    </tbody>
  </table>
</div>',
			]
		);
		/* -------------------------------------------------------------
		 * 9.  Contact – details panel
		 * ----------------------------------------------------------- */
        register_block_pattern(
            'understrap-child/contact-details',
            [
                'title'      => __( 'Contact Details', 'understrap-child' ),
                'categories' => [ 'contact' ],
                'content'    => '
                    <div class="container py-5">
                      <div class="row">
                        <div class="col-md-6">
                          <h3>Get in touch</h3>
                          <p>Email: <a href="mailto:pto@example.org">pto@example.org</a></p>
                          <p>Phone: (707) XXX-XXXX</p>
                          <p>Address: 4955 Sonoma Hwy, Santa Rosa CA</p>
                        </div>
                        <div class="col-md-6">
                          <h3>Follow us</h3>
                          <a href="https://facebook.com/YourPage" class="me-3 text-decoration-none">
                            <i class="bi bi-facebook"></i> Facebook
                          </a>
                          <a href="https://instagram.com/YourHandle" class="text-decoration-none">
                            <i class="bi bi-instagram"></i> Instagram
                          </a>
                        </div>
                      </div>
                    </div>
                ',
            ]
        );

		/* -------------------------------------------------------------
		 * 10. Contact – FAQ accordion
		 * ----------------------------------------------------------- */
		register_block_pattern(
			'understrap-child/contact-faq',
			[
				'title'      => __( 'FAQ Accordion', 'understrap-child' ),
				'categories' => [ 'contact' ],
				'content'    => '
<div class="container py-5">
  <h2 class="text-center mb-4">Frequently Asked Questions</h2>
  <div class="accordion" id="faqAccordion">
    <div class="accordion-item">
      <h3 class="accordion-header" id="faqHeadingOne">
        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapseOne" aria-expanded="true" aria-controls="faqCollapseOne">
          How can I volunteer?
        </button>
      </h3>
      <div id="faqCollapseOne" class="accordion-collapse collapse show" aria-labelledby="faqHeadingOne" data-bs-parent="#faqAccordion">
        <div class="accordion-body">
          Fill out the volunteer form or email us—there are roles for every schedule.
        </div>
      </div>
    </div>
    <div class="accordion-item">
      <h3 class="accordion-header" id="faqHeadingTwo">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapseTwo" aria-expanded="false" aria-controls="faqCollapseTwo">
          Are donations tax-deductible?
        </button>
      </h3>
      <div id="faqCollapseTwo" class="accordion-collapse collapse" aria-labelledby="faqHeadingTwo" data-bs-parent="#faqAccordion">
        <div class="accordion-body">
          Yes, Whited PTO is a 501(c)(3) non-profit. Keep your receipt for records.
        </div>
      </div>
    </div>
  </div>
</div>',
			]
		);
	}
endif;
add_action( 'init', 'understrap_child_register_block_patterns' );
