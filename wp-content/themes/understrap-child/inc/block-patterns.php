<?php error_log('DEBUG: Loading inc/block-patterns.php'); ?>

<?php
/**
 * Register custom block-pattern categories & patterns.
 *
 * @package understrap-child
 */

function understrap_child_register_block_patterns() {
    // 1) Pattern Categories
    if ( function_exists( 'register_block_pattern_category' ) ) {
        $cats = [
            'hero'      => __( 'Hero Sections',      'understrap-child' ),
            'events'    => __( 'Events Sections',    'understrap-child' ),
            'about'     => __( 'About Sections',     'understrap-child' ),
            'volunteer' => __( 'Volunteer Sections', 'understrap-child' ),
            'contact'   => __( 'Contact Sections',   'understrap-child' ),
            'general'   => __( 'General Sections',   'understrap-child' ),
        ];
        foreach ( $cats as $slug => $label ) {
            register_block_pattern_category( $slug, [ 'label' => $label ] );
        }
    }

    // Bail if patterns API not available
    if ( ! function_exists( 'register_block_pattern' ) ) {
        return;
    }

    //
    // 2) Hero Variations
    //
    register_block_pattern( 'understrap-child/hero-home', [
        'title'       => __( 'Home Hero', 'understrap-child' ),
        'categories'  => [ 'hero' ],
        'description' => __( 'Your dynamic home hero with background, title & button', 'understrap-child' ),
        'content'     => sprintf(
            '<!-- wp:group {"align":"full","className":"pattern-hero-home"} -->
              <div class="wp-block-group alignfull pattern-hero-home">
                <!-- wp:understrap-child/hero-section %s /-->
              </div>
            <!-- /wp:group -->',
            wp_json_encode( [
                'background' => get_stylesheet_directory_uri() . '/images/hero-default.jpeg',
                'title'      => get_theme_mod( 'understrap_child_hero_title', 'Welcome to Whited PTO' ),
                'buttonText' => 'Get Involved',
            ] )
        ),
    ] );

    register_block_pattern(
        'understrap-child/hero-full',
        [
            'title'      => __( 'Full-width Hero', 'understrap-child' ),
            'categories' => [ 'hero', 'general' ],
            'content'    => sprintf(
                /* 
                 * Group = your atomic Section
                 * section--narrow = no padding at all
                 */
                '<!-- wp:group {"align":"full","className":"section section--narrow"} -->' .
                  '<div class="wp-block-group alignfull section section--narrow">' .
    
                    /* Cover = background + inner content */
                    '<!-- wp:cover {"url":"%1$s","dimRatio":50,"align":"full","style":{"spacing":{"padding":{"top":"0px","bottom":"0px"}}}} -->' .
                      '<div class="wp-block-cover alignfull has-background-dim" style="background-image:url(%1$s);padding:0;margin:0;">' .
                        '<div class="wp-block-cover__inner-container text-center">' .
    
                          '<!-- wp:heading {"level":1,"textColor":"white","className":"display-1"} -->' .
                            '<h1 class="display-1 has-white-color has-text-align-center">%2$s</h1>' .
                          '<!-- /wp:heading -->' .
    
                          '<!-- wp:paragraph {"align":"center","textColor":"white","fontSize":"large"} -->' .
                            '<p class="has-text-align-center has-white-color has-large-font-size">%3$s</p>' .
                          '<!-- /wp:paragraph -->' .
    
                          '<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->' .
                            '<div class="wp-block-buttons">' .
                              '<!-- wp:button {"className":"btn btn-warning btn-lg"} -->' .
                                '<div class="wp-block-button"><a class="wp-block-button__link btn btn-warning btn-lg">%4$s</a></div>' .
                              '<!-- /wp:button -->' .
                            '</div>' .
                          '<!-- /wp:buttons -->' .
    
                        '</div>' .
                      '</div>' .
                    '<!-- /wp:cover -->' .
    
                  '</div>' .
                '<!-- /wp:group -->',
                esc_url( get_stylesheet_directory_uri() . '/images/hero-default.jpeg' ),
                esc_html( get_theme_mod( 'understrap_child_hero_title', 'Welcome to Whited PTO' ) ),
                esc_html( 'Supporting Our Students, Empowering Our Community' ),
                esc_html( 'Get Involved' )
            ),
        ]
    );
    


    register_block_pattern( 'understrap-child/hero-involved', [
        'title'      => __( 'Get Involved Hero', 'understrap-child' ),
        'categories' => [ 'hero' ],
        'content'    =>
          '<!-- wp:cover {"dimRatio":50,"align":"full","className":"hero-involved"} -->'.
            '<div class="wp-block-cover alignfull has-background-dim hero-involved">'.
              '<div class="wp-block-cover__inner-container text-center">'.
                '<!-- wp:heading {"level":1,"className":"h1 text-white"} -->'.
                  '<h1 class="h1 text-white">Be a Part of Something Bigger – Get Involved with Whited PTO!</h1>'.
                '<!-- /wp:heading -->'.
                '<!-- wp:paragraph {"className":"text-white"} -->'.
                  '<p class="text-white">Your time, skills, and support make a difference for our students.</p>'.
                '<!-- /wp:paragraph -->'.
                '<!-- wp:button {"className":"btn btn-light btn-lg"} -->'.
                  '<div class="wp-block-button"><a class="wp-block-button__link btn btn-light btn-lg">Sign Up to Volunteer</a></div>'.
                '<!-- /wp:button -->'.
              '</div>'.
            '</div>'.
          '<!-- /wp:cover -->',
    ] );

    register_block_pattern( 'understrap-child/hero-events', [
        'title'      => __( 'Events Hero', 'understrap-child' ),
        'categories' => [ 'hero','events' ],
        'content'    =>
          '<!-- wp:cover {"dimRatio":50,"align":"full","className":"hero-events"} -->'.
            '<div class="wp-block-cover alignfull has-background-dim hero-events">'.
              '<div class="wp-block-cover__inner-container text-center">'.
                '<!-- wp:heading {"level":1,"className":"h1 text-white"} -->'.
                  '<h1 class="h1 text-white">Join the Fun – Stay Connected with Whited PTO Events</h1>'.
                '<!-- /wp:heading -->'.
                '<!-- wp:button {"className":"btn btn-primary"} -->'.
                  '<div class="wp-block-button"><a class="wp-block-button__link btn btn-primary">Subscribe via Google Calendar</a></div>'.
                '<!-- /wp:button -->'.
              '</div>'.
            '</div>'.
          '<!-- /wp:cover -->',
    ] );

    register_block_pattern( 'understrap-child/hero-contact', [
        'title'      => __( 'Contact Hero', 'understrap-child' ),
        'categories' => [ 'hero','contact' ],
        'content'    =>
          '<!-- wp:cover {"dimRatio":50,"align":"full","className":"hero-contact"} -->'.
            '<div class="wp-block-cover alignfull has-background-dim hero-contact">'.
              '<div class="wp-block-cover__inner-container text-center">'.
                '<!-- wp:heading {"level":1,"className":"h1"} -->'.
                  '<h1 class="h1">We’d Love to Hear From You!</h1>'.
                '<!-- /wp:heading -->'.
                '<!-- wp:paragraph -->'.
                  '<p>Have a question, idea, or concern? Reach out and we’re here to help!</p>'.
                '<!-- /wp:paragraph -->'.
              '</div>'.
            '</div>'.
          '<!-- /wp:cover -->',
    ] );


    //
    // 3) About Patterns
    //
    register_block_pattern( 'understrap-child/about-overview', [
        'title'      => __( 'About Overview', 'understrap-child' ),
        'categories' => [ 'about' ],
        'content'    =>
          '<div class="container py-5">'.
            '<div class="row">'.
              '<div class="col-lg-7">'.
                '<h2>Mission &amp; Purpose</h2>'.
                '<p>We foster partnerships among parents, teachers, and the community to enrich every student’s learning experience.</p>'.
              '</div>'.
              '<div class="col-lg-5">'.
                '<h3>PTO Board</h3>'.
                '<ul class="list-unstyled">'.
                  '<li><strong>President:</strong> Jane Smith</li>'.
                  '<li><strong>Vice President:</strong> Mark Johnson</li>'.
                  '<li><strong>Treasurer:</strong> Amy Brown</li>'.
                '</ul>'.
              '</div>'.
            '</div>'.
          '</div>',
    ] );

    register_block_pattern( 'understrap-child/about-highlights', [
        'title'      => __( 'Highlights Grid', 'understrap-child' ),
        'categories' => [ 'about' ],
        'content'    =>
          '<div class="container text-center py-5">'.
            '<h2 class="mb-4">Highlights</h2>'.
            '<div class="row g-3">'.
              '<div class="col-md-4"><figure><img src="#" class="img-fluid rounded"><figcaption class="mt-2">Back-to-School Bash</figcaption></figure></div>'.
              '<div class="col-md-4"><figure><img src="#" class="img-fluid rounded"><figcaption class="mt-2">Fun Run</figcaption></figure></div>'.
              '<div class="col-md-4"><figure><img src="#" class="img-fluid rounded"><figcaption class="mt-2">Spring Carnival</figcaption></figure></div>'.
            '</div>'.
          '</div>',
    ] );

    register_block_pattern( 'understrap-child/board-profiles', [
        'title'      => __( 'Meet the PTO Board', 'understrap-child' ),
        'categories' => [ 'about' ],
        'content'    =>
          '<div class="container py-5">'.
            '<h2 class="text-center mb-4">PTO Board</h2>'.
            '<div class="row g-4">'.
              '<div class="col-md-4 text-center">'.
                '<figure><img src="#" alt="Jane Smith" class="img-fluid rounded-circle mb-3"></figure>'.
                '<h3>Jane Smith</h3><p>President</p>'.
              '</div>'.
              '<div class="col-md-4 text-center">'.
                '<figure><img src="#" alt="Mark Johnson" class="img-fluid rounded-circle mb-3"></figure>'.
                '<h3>Mark Johnson</h3><p>Vice President</p>'.
              '</div>'.
              '<div class="col-md-4 text-center">'.
                '<figure><img src="#" alt="Amy Brown" class="img-fluid rounded-circle mb-3"></figure>'.
                '<h3>Amy Brown</h3><p>Treasurer</p>'.
              '</div>'.
            '</div>'.
          '</div>',
    ] );


    //
    // 4) Events Patterns
    //
    register_block_pattern( 'understrap-child/featured-events', [
        'title'      => __( 'Featured Events', 'understrap-child' ),
        'categories' => [ 'events' ],
        'content'    =>
          '<div class="container py-5">'.
            '<h2 class="text-center mb-4">Featured Events</h2>'.
            '<div class="row g-4">'.
              '<div class="col-md-6"><div class="card h-100 border-secondary"><div class="card-body"><h5 class="card-title">Fall Harvest Festival</h5><p class="card-text"><strong>Oct 15, 4–7 PM •</strong> Games, pumpkin patch, treats. Volunteers needed!</p></div></div></div>'.
              '<div class="col-md-6"><div class="card h-100 border-secondary"><div class="card-body"><h5 class="card-title">Winter Book Fair</h5><p class="card-text"><strong>Dec 5–9</strong> Support literacy—buy a book, donate a book!</p></div></div></div>'.
            '</div>'.
          '</div>',
    ] );

    register_block_pattern( 'understrap-child/events-query', [
        'title'       => __( 'Upcoming Events (Dynamic)', 'understrap-child' ),
        'categories'  => [ 'events' ],
        'description' => __( 'Automatically show upcoming events via Query Loop.', 'understrap-child' ),
        'content'     =>
          '<!-- wp:query {"queryId":1,"query":{"postType":"event","order":"asc","orderBy":"meta_value","metaKey":"event_date"}} -->'.
            '<!-- wp:post-template -->'.
              '<div class="container py-4 event-item">'.
                '<!-- wp:post-title {"level":5} /-->'.
                '<!-- wp:post-date {"format":"F j, Y"} /-->'.
                '<!-- wp:post-excerpt /-->'.
                '<!-- wp:button {"className":"btn btn-outline-primary"} --><div class="wp-block-button"><a class="wp-block-button__link btn btn-outline-primary">Learn More</a></div><!-- /wp:button -->'.
              '</div>'.
            '<!-- /wp:post-template -->'.
          '<!-- /wp:query -->',
    ] );

    register_block_pattern( 'understrap-child/events-calendar', [
        'title'       => __( 'Year-at-a-Glance Calendar', 'understrap-child' ),
        'categories'  => [ 'events' ],
        'description' => __( '12-month overview table.', 'understrap-child' ),
        'content'     =>
          '<div class="container py-5">'.
            '<table class="table table-bordered">'.
              '<thead class="table-light"><tr><th>Month</th><th>Key Dates</th></tr></thead>'.
              '<tbody>'.
                '<tr><td>August</td><td>First Day of School (Aug 14)</td></tr>'.
                '<tr><td>September</td><td>Movie Night (Sept 20)</td></tr>'.
                '<tr><td>October</td><td>Fall Festival (Oct 26)</td></tr>'.
                '<tr><td>November</td><td>Turkey Trot (Nov 22)</td></tr>'.
                '<tr><td>December</td><td>Book Fair (Dec 5–9)</td></tr>'.
              '</tbody>'.
            '</table>'.
          '</div>',
    ] );


    //
    // 5) Volunteer Patterns
    //
    register_block_pattern( 'understrap-child/volunteer-grid', [
        'title'      => __( 'How to Get Involved', 'understrap-child' ),
        'categories' => [ 'volunteer' ],
        'content'    =>
          '<div class="container py-5">'.
            '<h2 class="text-center mb-4">Ways to Get Involved</h2>'.
            '<div class="row g-4">'.
              '<div class="col-md-4 text-center p-4 border rounded">'.
                '<figure class="mb-3"><img src="#" class="img-fluid" alt=""></figure>'.
                '<h3>Volunteer at an Event</h3><p>Help set up, staff, and clean up PTO events.</p>'.
                '<!-- wp:button {"className":"btn btn-outline-primary"} --><div class="wp-block-button"><a class="wp-block-button__link btn btn-outline-primary">Learn More</a></div><!-- /wp:button -->'.
              '</div>'.
              '<div class="col-md-4 text-center p-4 border rounded">'.
                '<figure class="mb-3"><img src="#" class="img-fluid" alt=""></figure>'.
                '<h3>Join the PTO</h3><p>Become an official member of our Parent-Teacher Organization.</p>'.
                '<!-- wp:button {"className":"btn btn-outline-primary"} --><div class="wp-block-button"><a class="wp-block-button__link btn btn-outline-primary">Sign Up</a></div><!-- /wp:button -->'.
              '</div>'.
              '<div class="col-md-4 text-center p-4 border rounded">'.
                '<figure class="mb-3"><img src="#" class="img-fluid" alt=""></figure>'.
                '<h3>Donate to Support</h3><p>Contribute funds or supplies to help our school thrive.</p>'.
                '<!-- wp:button {"className":"btn btn-outline-primary"} --><div class="wp-block-button"><a class="wp-block-button__link btn btn-outline-primary">Donate</a></div><!-- /wp:button -->'.
              '</div>'.
            '</div>'.
          '</div>',
    ] );

    register_block_pattern( 'understrap-child/volunteer-signup', [
        'title'      => __( 'Volunteer Signup Band', 'understrap-child' ),
        'categories' => [ 'volunteer','general' ],
        'content'    =>
          '<div class="container-fluid bg-light py-5 text-center">'.
            '<h2 class="mb-3">Sign Up to Volunteer</h2>'.
            '<p class="mb-4">Let us know how you’d like to help—every hour counts.</p>'.
            '<!-- wp:button {"className":"btn btn-primary btn-lg"} --><div class="wp-block-button"><a class="wp-block-button__link btn btn-primary btn-lg">Volunteer Form</a></div><!-- /wp:button -->'.
          '</div>',
    ] );


    //
    // 6) Form Patterns
    //
    register_block_pattern( 'understrap-child/form-volunteer', [
        'title'      => __( 'Volunteer Signup Form', 'understrap-child' ),
        'categories' => [ 'volunteer','contact','general' ],
        'content'    =>
          '<!-- wp:html -->'.
            '<form class="pto-signup-form container py-5">'.
              '<div class="row g-3">'.
                '<div class="col-md-6"><label>Name</label><input type="text" name="name" class="form-control"></div>'.
                '<div class="col-md-6"><label>Email</label><input type="email" name="email" class="form-control"></div>'.
                '<div class="col-md-12"><label>How can you help?</label><textarea name="message" class="form-control"></textarea></div>'.
                '<div class="col-12 text-center"><button type="submit" class="btn btn-primary">Submit</button></div>'.
              '</div>'.
            '</form>'.
          '<!-- /wp:html -->',
    ] );

    register_block_pattern( 'understrap-child/form-contact', [
        'title'      => __( 'Contact Form', 'understrap-child' ),
        'categories' => [ 'contact','general' ],
        'content'    => '<!-- wp:shortcode -->[contact-form-7 id="123" title="Contact form"]<!-- /wp:shortcode -->',
    ] );


    //
    // 7) Contact Patterns
    //
    register_block_pattern( 'understrap-child/contact-details', [
        'title'      => __( 'Contact Details', 'understrap-child' ),
        'categories' => [ 'contact' ],
        'content'    =>
          '<div class="container py-5">'.
            '<div class="row">'.
              '<div class="col-md-6">'.
                '<h3>Get in touch</h3>'.
                '<p>Email: <a href="mailto:pto@example.org">pto@example.org</a></p>'.
                '<p>Phone: (707) XXX-XXXX</p>'.
                '<p>Address: 4955 Sonoma Hwy, Santa Rosa CA</p>'.
              '</div>'.
              '<div class="col-md-6">'.
                '<h3>Follow us</h3>'.
                '<a href="#" class="me-3"><i class="bi bi-facebook"></i> Facebook</a>'.
                '<a href="#"><i class="bi bi-instagram"></i> Instagram</a>'.
              '</div>'.
            '</div>'.
          '</div>',
    ] );

    register_block_pattern( 'understrap-child/contact-faq', [
        'title'      => __( 'FAQ Accordion', 'understrap-child' ),
        'categories' => [ 'contact' ],
        'content'    =>
          '<div class="container py-5">'.
            '<h2 class="text-center mb-4">Frequently Asked Questions</h2>'.
            '<div class="accordion" id="faqAccordion">'.
              '<div class="accordion-item">'.
                '<h3 class="accordion-header" id="faqHeadingOne">'.
                  '<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapseOne">How can I volunteer?</button>'.
                '</h3>'.
                '<div id="faqCollapseOne" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">'.
                  '<div class="accordion-body">Fill out the volunteer form or email us—there are roles for every schedule.</div>'.
                '</div>'.
              '</div>'.
              '<div class="accordion-item">'.
                '<h3 class="accordion-header" id="faqHeadingTwo">'.
                  '<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapseTwo">Are donations tax-deductible?</button>'.
                '</h3>'.
                '<div id="faqCollapseTwo" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">'.
                  '<div class="accordion-body">Yes, Whited PTO is a 501(c)(3) nonprofit. Keep your receipt for records.</div>'.
                '</div>'.
              '</div>'.
            '</div>'.
          '</div>',
    ] );


    //
    // 8) General CTA Band
    //
    register_block_pattern( 'understrap-child/cta-band', [
        'title'      => __( 'CTA Band', 'understrap-child' ),
        'categories' => [ 'general' ],
        'content'    =>
          '<div class="container-fluid bg-primary text-white py-5 text-center">'.
            '<h2 class="mb-3">Ready to Make a Difference?</h2>'.
            '<!-- wp:button {"className":"btn btn-light btn-lg"} --><div class="wp-block-button"><a class="wp-block-button__link btn btn-light btn-lg">Get Involved</a></div><!-- /wp:button -->'.
          '</div>',
    ] );
}


register_block_pattern( 'test/simple-paragraph', [
    'title'   => 'Simple Paragraph',
    'content' => '<!-- wp:paragraph --><p>Hello world</p><!-- /wp:paragraph -->',
  ] );

  
add_action( 'init', 'understrap_child_register_block_patterns' );

