<?php
/**
 * Atom: Paragraph Text
 */
defined( 'ABSPATH' ) || exit;

add_action( 'init', function() {
    register_block_pattern(
        'understrap/atom-paragraph-text',
        [
            'title'      => __( 'Atom: Paragraph Text', 'understrap-child' ),
            'categories' => [ 'understrap-atom' ],
            'content'    => '
<!-- wp:paragraph {"className":"paragraph-text"} -->
<p class="paragraph-text">' . esc_html__( 'Insert your paragraph text here.', 'understrap-child' ) . '</p>
<!-- /wp:paragraph -->',
        ]
    );
} );
