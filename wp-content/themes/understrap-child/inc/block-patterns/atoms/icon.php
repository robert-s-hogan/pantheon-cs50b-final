<?php
/**
 * Atom: Icon
 */
defined( 'ABSPATH' ) || exit;

add_action( 'init', function() {
    register_block_pattern(
        'understrap/atom-icon',
        [
            'title'      => __( 'Atom: Icon', 'understrap-child' ),
            'categories' => [ 'understrap-atom' ],
            'content'    => '
<!-- wp:html -->
<span class="icon-heart" role="img" aria-label="heart">❤️</span>
<!-- /wp:html -->
',
        ]
    );
} );
