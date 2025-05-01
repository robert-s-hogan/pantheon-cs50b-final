
<?php
// inc/block-types.php
add_action( 'init', function() {
    register_block_type( __DIR__ . '/block-types/hero-section/block.json' );
  } );
  

  function understrap_child_render_hero_section( $attrs ) {
    // Temporarily return simple HTML to see if the callback is hit
    // var_dump($attrs); // You can also dump attributes here to debug
    return \UnderstrapChild\Atomic\render_template( 'organisms/hero', $attrs ); 
}