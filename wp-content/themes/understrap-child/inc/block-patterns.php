<?php
// inc/block-patterns.php

function understrap_child_register_block_patterns() {
  // 1) Define a new “Hero” category (optional)
  if ( function_exists( 'register_block_pattern_category' ) ) {
    register_block_pattern_category(
      'hero',
      [ 'label' => __( 'Hero Sections', 'understrap-child' ) ]
    );
  }

  // 2) Register a simple hero pattern
  if ( function_exists( 'register_block_pattern' ) ) {
    register_block_pattern(
      'understrap-child/hero',
      [
        'title'       => __( 'Full-width Hero', 'understrap-child' ),
        'categories'  => [ 'hero' ],
        'content'     => 
          '<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"5rem","bottom":"5rem"}}},"backgroundImage":{"url":"' . esc_url( get_stylesheet_directory_uri() . '/images/hero.jpg' ) . '"},"className":"has-dark-overlay"} -->
          <div class="wp-block-group alignfull has-dark-overlay" style="padding-top:5rem;padding-bottom:5rem;background-image:url(' . esc_url( get_stylesheet_directory_uri() . '/images/hero.jpg' ) . ');">
            <!-- wp:heading {"textAlign":"center","level":1} -->
            <h1 class="has-text-align-center">' . __( 'Welcome to Our Site', 'understrap-child' ) . '</h1>
            <!-- /wp:heading -->
            <!-- wp:paragraph {"align":"center"} -->
            <p class="has-text-align-center">' . __( 'Your subtitle or call-to-action copy goes here.', 'understrap-child' ) . '</p>
            <!-- /wp:paragraph -->
          </div>
          <!-- /wp:group -->',
      ]
    );
  }
}
add_action( 'init', 'understrap_child_register_block_patterns' );
