<?php
/**
 * Register custom block types (server-side rendered).
 */

add_action( 'init', function() {

  // 1) Hero Section block
  register_block_type( 'understrap-child/hero-section', [
    'render_callback' => 'understrap_child_render_hero_section',
    'attributes'      => [
      'title'      => [ 'type' => 'string', 'default' => 'Welcome to Whited PTO' ],
      'background' => [ 'type' => 'string', 'default' => '' ],
      'buttonText' => [ 'type' => 'string', 'default' => 'Get Involved' ],
    ],
    'category'        => 'hero',
  ] );

});

/**
 * Render callback: grabs your atomic template and passes in attrs.
 *
 * @param array $attrs
 * @return string
 */
function understrap_child_render_hero_section( $attrs ) {
  // Assumes you have a helper to load template-parts under components/
  return \UnderstrapChild\Atomic\render_template( 'organisms/hero', $attrs );
}
