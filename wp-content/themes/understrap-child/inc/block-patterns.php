<?php
// inc/block-patterns.php

function understrap_child_register_block_patterns() {
  if ( function_exists( 'register_block_pattern' ) ) {
    register_block_pattern( 'understrap-child/hero-home', [
      'title'      => __( 'Home Hero', 'understrap-child' ),
      'categories' => [ 'hero' ],
      'content'    =>
        '<!-- wp:understrap-child/hero-section ' .
          wp_json_encode( [
            'background' => get_stylesheet_directory_uri() . '/images/hero-default.jpeg',
            'title'      => get_theme_mod( 'understrap_child_hero_title', 'Welcome to Whited PTO' ),
            'buttonText' => 'Get Involved',
          ] ) .
        ' /-->',
    ] );
    // …other patterns…
  }
}
add_action( 'init', 'understrap_child_register_block_patterns' );
