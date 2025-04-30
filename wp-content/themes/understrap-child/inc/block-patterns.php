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
                    '<div class="wp-block-cover__inner-container">' .
                      '<!-- wp:heading {"textAlign":"center"} -->' .
                      '<h1 class="has-text-align-center">Welcome to Whited PTO</h1>' .
                      '<!-- /wp:heading -->' .
                      '<!-- wp:paragraph {"align":"center"} -->' .
                      '<p class="has-text-align-center">Supporting Our Students, Empowering Our Community</p>' .
                      '<!-- /wp:paragraph -->' .
                      '<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->' .
                        '<div class="wp-block-buttons">' .
                          '<!-- wp:button {"backgroundColor":"primary"} -->' .
                            '<div class="wp-block-button"><a class="wp-block-button__link has-primary-background-color has-background">Get Involved</a></div>' .
                          '<!-- /wp:button -->' .
                        '</div>' .
                      '<!-- /wp:buttons -->' .
                    '</div>' .
                  '</div>' .
                '<!-- /wp:cover -->',
                esc_url( get_stylesheet_directory_uri() . '/images/hero-default.jpeg' )
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
				'content'    => <<<'HTML'
<!-- wp:group {"align":"wide","style":{"spacing":{"padding":{"top":"2rem","bottom":"2rem"}}}} -->
<div class="wp-block-group alignwide" style="padding-top:2rem;padding-bottom:2rem"><!-- wp:heading {"level":2} -->
<h2>Featured Events</h2><!-- /wp:heading -->

<!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"style":{"border":{"width":"1px","color":"#ddd"},"spacing":{"padding":{"all":"1rem"}}}} -->
<div class="wp-block-group has-border" style="border-color:#ddd;border-width:1px;padding:1rem"><!-- wp:heading {"level":3} -->
<h3>Fall Harvest Festival</h3><!-- /wp:heading -->

<!-- wp:paragraph -->
<p><strong>Oct&nbsp;15, 4–7 PM •</strong> Games, pumpkin patch, treats. Volunteers needed!</p><!-- /wp:paragraph --></div><!-- /wp:group --></div><!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"style":{"border":{"width":"1px","color":"#ddd"},"spacing":{"padding":{"all":"1rem"}}}} -->
<div class="wp-block-group has-border" style="border-color:#ddd;border-width:1px;padding:1rem"><!-- wp:heading {"level":3} -->
<h3>Winter Book Fair</h3><!-- /wp:heading -->

<!-- wp:paragraph -->
<p><strong>Dec 5-9</strong> Support literacy—buy a book, donate a book!</p><!-- /wp:paragraph --></div><!-- /wp:group --></div><!-- /wp:column --></div><!-- /wp:columns --></div>
<!-- /wp:group -->
HTML
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
				'content'    => <<<'HTML'
<!-- wp:columns {"align":"wide","style":{"spacing":{"padding":{"top":"3rem","bottom":"3rem"}}}} -->
<div class="wp-block-columns alignwide" style="padding-top:3rem;padding-bottom:3rem"><!-- wp:column {"width":"60%"} -->
<div class="wp-block-column" style="flex-basis:60%"><!-- wp:heading {"level":2} -->
<h2>Mission &amp; Purpose</h2><!-- /wp:heading -->

<!-- wp:paragraph -->
<p>We foster partnerships among parents, teachers, and the community to enrich every student’s learning experience.</p><!-- /wp:paragraph --></div><!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"level":3} -->
<h3>PTO Board</h3><!-- /wp:heading -->

<!-- wp:list -->
<ul><li>President: Jane Smith</li><li>Vice President: Mark Johnson</li><li>Treasurer: Amy Brown</li></ul><!-- /wp:list --></div><!-- /wp:column --></div><!-- /wp:columns -->
HTML
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
				'content'    => <<<'HTML'
<!-- wp:heading {"align":"center","level":2} -->
<h2 class="has-text-align-center">Highlights</h2><!-- /wp:heading -->

<!-- wp:gallery {"columns":3,"linkTo":"none"} -->
<figure class="wp-block-gallery has-nested-images columns-3 is-cropped">
	<!-- wp:image {"sizeSlug":"large"} --><img alt="" /><figcaption>Back-to-School Bash</figcaption><!-- /wp:image -->
	<!-- wp:image {"sizeSlug":"large"} --><img alt="" /><figcaption>Fun Run</figcaption><!-- /wp:image -->
	<!-- wp:image {"sizeSlug":"large"} --><img alt="" /><figcaption>Spring Carnival</figcaption><!-- /wp:image -->
	<!-- wp:image {"sizeSlug":"large"} --><img alt="" /><figcaption>Teacher Appreciation</figcaption><!-- /wp:image -->
	<!-- wp:image {"sizeSlug":"large"} --><img alt="" /><figcaption>Reading Rodeo</figcaption><!-- /wp:image -->
	<!-- wp:image {"sizeSlug":"large"} --><img alt="" /><figcaption>Spirit Week</figcaption><!-- /wp:image -->
</figure><!-- /wp:gallery -->
HTML
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
				'content'    => <<<'HTML'
<!-- wp:heading {"level":2,"align":"center"} -->
<h2 class="has-text-align-center">Ways to Be Involved</h2><!-- /wp:heading -->

<!-- wp:group {"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"style":{"border":{"width":"1px","color":"#e5e5e5"},"spacing":{"padding":{"all":"1.25rem"}}}} -->
<div class="wp-block-group" style="border-color:#e5e5e5;border-width:1px;padding:1.25rem"><!-- wp:heading {"level":3} -->
<h3>Chair an Event</h3><!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Lead planning for a single PTO event—templates &amp; team provided.</p><!-- /wp:paragraph -->

<!-- wp:button {"backgroundColor":"primary"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-primary-background-color has-background">Learn More</a></div><!-- /wp:button --></div><!-- /wp:group --></div><!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"style":{"border":{"width":"1px","color":"#e5e5e5"},"spacing":{"padding":{"all":"1.25rem"}}}} -->
<div class="wp-block-group" style="border-color:#e5e5e5;border-width:1px;padding:1.25rem"><!-- wp:heading {"level":3} -->
<h3>Classroom Support</h3><!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Help teachers with copies, supplies, or reading groups.</p><!-- /wp:paragraph -->

<!-- wp:button {"backgroundColor":"primary"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-primary-background-color has-background">Sign Up</a></div><!-- /wp:button --></div><!-- /wp:group --></div><!-- /wp:column --></div><!-- /wp:columns --></div><!-- /wp:group -->
HTML
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
				'content'    => <<<'HTML'
<!-- wp:group {"align":"full","backgroundColor":"light","style":{"spacing":{"padding":{"top":"2.5rem","bottom":"2.5rem"}}}} -->
<div class="wp-block-group alignfull has-light-background-color has-background" style="padding-top:2.5rem;padding-bottom:2.5rem"><!-- wp:heading {"textAlign":"center","level":2} -->
<h2 class="has-text-align-center">Sign Up to Volunteer</h2><!-- /wp:heading -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">Let us know how you’d like to help—every hour counts.</p><!-- /wp:paragraph -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"primary"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-primary-background-color has-background">Volunteer Form</a></div><!-- /wp:button --></div><!-- /wp:buttons --></div><!-- /wp:group -->
HTML
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
				'content'    => <<<'HTML'
<!-- wp:heading {"level":2} -->
<h2>Upcoming Events</h2><!-- /wp:heading -->

<!-- wp:list {"className":"events-list"} -->
<ul class="events-list">
	<li><strong>Family Movie Night</strong> • Sept 20, 6 PM – Gym</li>
	<li><strong>Pajama Day</strong> • Oct 4 – School-wide spirit day</li>
	<li><strong>Turkey Trot</strong> • Nov 22, 9 AM – Track Field</li>
</ul><!-- /wp:list -->
HTML
			]
		);

		/* -------------------------------------------------------------
		 * 8.  Events – year-at-a-glance calendar
		 * ----------------------------------------------------------- */
		register_block_pattern(
			'understrap-child/events-calendar',
			[
				'title'      => __( 'Year-at-a-Glance Calendar', 'understrap-child' ),
				'categories' => [ 'events' ],
				'description'=> __( '12-month overview table. Replace with calendar-plugin block if preferred.', 'understrap-child' ),
				'content'    => <<<'HTML'
<!-- wp:table {"align":"wide"} -->
<figure class="wp-block-table alignwide"><table><thead><tr>
<th>Month</th><th>Key Dates</th></tr></thead><tbody>
<tr><td>August</td><td>First Day of School (Aug 14)</td></tr>
<tr><td>September</td><td>Movie Night (Sept 20)</td></tr>
<tr><td>October</td><td>Fall Festival (Oct 26)</td></tr>
<tr><td>November</td><td>Turkey Trot (Nov 22)</td></tr>
<tr><td>December</td><td>Book Fair (Dec 5-9)</td></tr>
</tbody></table></figure><!-- /wp:table -->
HTML
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
              'content'    => <<<'HTML'
          <!-- wp:columns {"align":"wide","style":{"spacing":{"padding":{"top":"2rem","bottom":"2rem"}}}} -->
          <div class="wp-block-columns alignwide" style="padding-top:2rem;padding-bottom:2rem">
            <!-- wp:column -->
            <div class="wp-block-column">
              <!-- wp:heading {"level":3} -->
              <h3>Get in touch</h3>
              <!-- /wp:heading -->
              <!-- wp:paragraph -->
              <p>Email: <a href="mailto:pto@example.org">pto@example.org</a></p>
              <!-- /wp:paragraph -->
              <!-- wp:paragraph -->
              <p>Phone: (707) XXX-XXXX</p>
              <!-- /wp:paragraph -->
              <!-- wp:paragraph -->
              <p>Address: 4955 Sonoma Hwy, Santa Rosa CA</p>
              <!-- /wp:paragraph -->
            </div>
            <!-- /wp:column -->
            <!-- wp:column -->
            <div class="wp-block-column">
              <!-- wp:heading {"level":3} -->
              <h3>Follow us</h3>
              <!-- /wp:heading -->
              <!-- wp:social-links {"layout":{"type":"flex","justifyContent":"left"},"style":{"spacing":{"blockGap":"0.5rem"}}} -->
              <!-- wp:social-link {"url":"https://facebook.com/YourPage","service":"facebook"} /-->
              <!-- wp:social-link {"url":"https://instagram.com/YourHandle","service":"instagram"} /-->
              <!-- /wp:social-links -->
            </div>
            <!-- /wp:column -->
          </div>
          <!-- /wp:columns -->
          HTML
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
				'content'    => <<<'HTML'
<!-- wp:heading {"level":2,"align":"center"} -->
<h2 class="has-text-align-center">Frequently Asked Questions</h2><!-- /wp:heading -->

<!-- wp:details -->
<details><summary>How can I volunteer?</summary><p>Fill out the volunteer form or email us—there are roles for every schedule.</p></details><!-- /wp:details -->

<!-- wp:details -->
<details><summary>Are donations tax-deductible?</summary><p>Yes, Whited PTO is a 501(c)(3) non-profit. Keep your receipt for records.</p></details><!-- /wp:details -->
HTML
			]
		);
	}
endif;
add_action( 'init', 'understrap_child_register_block_patterns' );
