<?php
/**
 * Molecule: Contact Info
 */
defined( 'ABSPATH' ) || exit;

add_action( 'init', function() {
    register_block_pattern(
        'understrap/molecule-contact-info',
        [
            'title'      => __( 'Molecule: Contact Info', 'understrap-child' ),
            'categories' => [ 'understrap-molecule', 'text' ],
            'content'    =>
                '<!-- wp:group {"className":"contact-info"} -->' .
                '<div class="wp-block-group contact-info">' .
                '  <!-- wp:paragraph -->' .
                '  <p>Email: info@whitedpto.org</p>' .
                '  <!-- /wp:paragraph -->' .
                '  <!-- wp:paragraph -->' .
                '  <p>Address: 4095 Sonoma Hwy, Santa Rosa, CA 95409</p>' .
                '  <!-- /wp:paragraph -->' .
                '</div>' .
                '<!-- /wp:group -->',
        ]
    );
} );
