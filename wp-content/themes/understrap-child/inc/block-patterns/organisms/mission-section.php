<?php
/**
 * Organism: Mission Section
 */
defined( 'ABSPATH' ) || exit;

add_action( 'init', function() {
    register_block_pattern(
        'understrap/organism-mission-section',
        [
            'title'      => __( 'Organism: Mission Section', 'understrap-child' ),
            'categories' => [ 'understrap-organism', 'about' ],
            'content'    =>
                '<!-- wp:group {"align":"full","className":"mission-section bg-light py-5"} -->' .
                '<div class="wp-block-group alignfull mission-section bg-light py-5">' .
                    '<div class="container">' .
                        '<!-- wp:heading {"level":4,"className":"text-center fw-bold"} -->' .
                        '<h4 class="text-center fw-bold">' . esc_html__( 'At Whited Elementary PTO, our mission is simple:', 'understrap-child' ) . '</h4>' .
                        '<!-- /wp:heading -->' .

                        '<!-- wp:paragraph {"className":"text-center mx-auto"} -->' .
                        '<p class="text-center mx-auto">' . esc_html__( 'We strive to enhance the educational experience of every student by fostering a supportive community of parents, teachers, and staff. Through volunteer efforts, fundraising events, and open communication, we work together to create a positive environment where every family can thrive.', 'understrap-child' ) . '</p>' .
                        '<!-- /wp:paragraph -->' .
                    '</div>' .
                '</div>' .
                '<!-- /wp:group -->',
        ]
    );
} );
