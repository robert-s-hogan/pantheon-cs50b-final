<?php
// inc/block-types.php

add_action( 'init', function() {
  register_block_type( 'understrap-child/hero-section', [
    'render_callback' => 'understrap_child_render_hero_section',
    'attributes'      => [
      'background' => [ 'type' => 'string' ],
      'title'      => [ 'type' => 'string' ],
      'buttonText' => [ 'type' => 'string' ],
    ],
    'category'        => 'hero',
  ] );
} );

function understrap_child_render_hero_section( $attrs ) {
  return \UnderstrapChild\Atomic\render_template( 'organisms/hero', $attrs );
}
