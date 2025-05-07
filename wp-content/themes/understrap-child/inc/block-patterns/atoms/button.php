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
        'understrap/atom-button',
        [
            'title'      => esc_html__( 'Atom: Button', 'understrap-child' ),
            'categories' => [ 'understrap-atom', 'buttons' ],
            'content'    => <<<'CONTENT'
<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons">
  <!-- wp:button {"className":"btn-primary"} -->
  <div class="wp-block-button">
    <a class="wp-block-button__link btn btn-primary">%s</a>
  </div>
  <!-- /wp:button -->
</div>
<!-- /wp:buttons -->
CONTENT
            ,
            'args'       => [
                esc_html__( 'Click Me', 'understrap-child' ),
            ],
        ]
    );
} );
