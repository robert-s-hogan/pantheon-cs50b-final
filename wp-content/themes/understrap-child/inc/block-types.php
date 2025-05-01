<?php
// inc/block-types.php
add_action( 'init', function() {
    register_block_type( __DIR__ . '/block-types/hero-section/block.json' );
  } );
  

function understrap_child_render_hero_section( $attrs ) {
  return \UnderstrapChild\Atomic\render_template( 'organisms/hero', $attrs );
}
