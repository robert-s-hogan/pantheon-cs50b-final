<?php
/**
 * Organism: Hero Section
 */
defined( 'ABSPATH' ) || exit;

add_action( 'init', function() {
    // Only register if the block‑pattern API is available.
    if ( ! function_exists( 'register_block_pattern' ) ) {
        return;
    }

    register_block_pattern(
        'understrap/organism-hero-section',
        [
            'title'      => esc_html__( 'Organism: Hero Section', 'understrap-child' ),
            'categories' => [ 'understrap-organism', 'hero' ],
            'content'    => <<<'CONTENT'
<!-- wp:cover {"url":"%s","dimRatio":60,"overlayColor":"black","align":"full","className":"hero-section"} -->
<div class="wp-block-cover alignfull hero-section">
  <span aria-hidden="true" class="wp-block-cover__background has-black-background-color has-background-dim"></span>
  <div class="wp-block-cover__inner-container">

    <!-- wp:heading {"level":1,"className":"section-title"} -->
    <h1 class="section-title">%s</h1>
    <!-- /wp:heading -->

    <!-- wp:paragraph {"className":"subheading"} -->
    <p class="subheading">%s</p>
    <!-- /wp:paragraph -->

    <!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
    <div class="wp-block-buttons">
      <!-- wp:button {"className":"btn-primary"} -->
      <div class="wp-block-button">
        <a class="wp-block-button__link btn btn-primary">%s</a>
      </div>
      <!-- /wp:button -->
    </div>
    <!-- /wp:buttons -->

  </div>
</div>
<!-- /wp:cover -->
CONTENT
            ,
            // Pass dynamic values into the nowdoc:
            'args'       => [
                sprintf( '%1$s/assets/hero-bg.jpg', esc_url( get_stylesheet_directory_uri() ) ),
                esc_html__( 'Your Hero Title',    'understrap-child' ),
                esc_html__( 'Your subheading here.','understrap-child' ),
                esc_html__( 'Call to Action',      'understrap-child' ),
            ],
        ]
    );
} );
