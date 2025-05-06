<?php
/**
 * Atom: Button
 */
defined( 'ABSPATH' ) || exit;

add_action( 'init', function() {
    if ( ! function_exists( 'register_block_pattern' ) ) {
        return;
    }

    register_block_pattern(
        // slug matching your other atoms
        'understrap/atom-button',
        [
            'title'      => __( 'Atom: Button', 'understrap-child' ),
            'categories' => [ 'understrap-atom', 'buttons' ],
            'content'    => '
<div class="wp-block-buttons">
  <div class="wp-block-button">
    <a href="#" class="wp-block-button__link btn btn-primary">
      ' . esc_html__( 'Click Me', 'understrap-child' ) . '
    </a>
  </div>
</div>',
        ]
    );
} );
