<?php
// inc/block-types.php
add_action( 'init', function() {
    register_block_type( __DIR__ . '/block-types/hero-section/block.json' );
  } );
  

  function understrap_child_render_hero_section( $attrs ) {
    // Temporarily return simple HTML to see if the callback is hit
    // var_dump($attrs); // You can also dump attributes here to debug
    return '<div style="border: 2px dashed red; padding: 20px;">Custom Hero Section Block Rendered! Title: ' . esc_html($attrs['title']) . '</div>';
}