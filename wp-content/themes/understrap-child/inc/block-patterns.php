<?php
/**
 * UnderStrap‑Child: Register custom block pattern categories & patterns.
 */

defined( 'ABSPATH' ) || exit;

add_action( 'init', function() {
    // 1) Register a custom pattern category
    if ( function_exists( 'register_block_pattern_category' ) ) {
        register_block_pattern_category(
            'understrap-general',
            array( 'label' => __( 'UnderStrap Patterns', 'understrap-child' ) )
        );
    }

    // 2) Register a Hero Section pattern
    if ( function_exists( 'register_block_pattern' ) ) {
        register_block_pattern(
            'understrap/hero-section',
            array(
                'title'       => __( 'UnderStrap Hero Section', 'understrap-child' ),
                'description' => _x( 'Full‑width hero with BG color, heading, text & button', 'Block pattern description', 'understrap-child' ),
                'categories'  => array( 'understrap-general', 'featured' ),
                'content'     =>
                    "<!-- wp:group {\"align\":\"full\",\"backgroundColor\":\"primary\",\"className\":\"hero-section\"} -->\n" .
                    "<div class=\"wp-block-group alignfull has-primary-background-color has-background hero-section\">\n" .
                    "  <!-- wp:heading {\"textAlign\":\"center\",\"level\":1} -->\n" .
                    "  <h1 class=\"has-text-align-center\">Your Hero Title Here</h1>\n" .
                    "  <!-- /wp:heading -->\n\n" .
                    "  <!-- wp:paragraph {\"align\":\"center\"} -->\n" .
                    "  <p class=\"has-text-align-center\">A brief subtitle or description goes here.</p>\n" .
                    "  <!-- /wp:paragraph -->\n\n" .
                    "  <!-- wp:buttons {\"layout\":{\"type\":\"flex\",\"justifyContent\":\"center\"}} -->\n" .
                    "  <div class=\"wp-block-buttons\">\n" .
                    "    <!-- wp:button {\"backgroundColor\":\"secondary\"} -->\n" .
                    "    <div class=\"wp-block-button\"><a class=\"wp-block-button__link has-secondary-background-color has-background\">Call to Action</a></div>\n" .
                    "    <!-- /wp:button -->\n" .
                    "  </div>\n" .
                    "  <!-- /wp:buttons -->\n" .
                    "</div>\n" .
                    "<!-- /wp:group -->"
            )
        );
        // 3) Register a Call‑to‑Action pattern
        register_block_pattern(
            'understrap/cta',
            array(
                'title'       => __( 'Call to Action', 'understrap-child' ),
                'description' => __( 'Full‑width CTA with background, text, and button', 'understrap-child' ),
                'categories'  => array( 'understrap-general', 'buttons' ),
                'content'     =>
                    "<!-- wp:group {\"align\":\"full\",\"backgroundColor\":\"secondary\",\"className\":\"cta-section\"} -->\n" .
                    "<div class=\"wp-block-group alignfull has-secondary-background-color has-background cta-section\">\n" .
                    "  <!-- wp:heading {\"textAlign\":\"center\",\"level\":2} -->\n" .
                    "  <h2 class=\"has-text-align-center\">Ready to get started?</h2>\n" .
                    "  <!-- /wp:heading -->\n\n" .
                    "  <!-- wp:paragraph {\"align\":\"center\"} -->\n" .
                    "  <p class=\"has-text-align-center\">Join us today and see the difference.</p>\n" .
                    "  <!-- /wp:paragraph -->\n\n" .
                    "  <!-- wp:buttons {\"layout\":{\"type\":\"flex\",\"justifyContent\":\"center\"}} -->\n" .
                    "  <div class=\"wp-block-buttons\">\n" .
                    "    <!-- wp:button {\"backgroundColor\":\"primary\",\"className\":\"is-style-fill\"} -->\n" .
                    "    <div class=\"wp-block-button is-style-fill\"><a class=\"wp-block-button__link has-primary-background-color has-background\">Sign Up Now</a></div>\n" .
                    "    <!-- /wp:button -->\n" .
                    "  </div>\n" .
                    "  <!-- /wp:buttons -->\n" .
                    "</div>\n" .
                    "<!-- /wp:group -->",
            )
        );
    }
} );
