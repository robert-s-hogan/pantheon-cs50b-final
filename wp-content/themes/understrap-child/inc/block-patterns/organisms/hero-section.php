<?php
/**
 * Organism: Hero Section
 */
defined( 'ABSPATH' ) || exit;

add_action( 'init', function() {
    register_block_pattern(
        'understrap/organism-hero-section',
        [
            'title'      => esc_html__( 'Organism: Hero Section', 'understrap-child' ),
            'categories' => [ 'understrap-organism', 'hero' ],
            'content'    => '
<!-- wp:cover {"url":"' . esc_url( get_stylesheet_directory_uri() . '/assets/hero-bg.jpg' ) . '","dimRatio":60,"overlayColor":"black","align":"full","className":"hero-section"} -->
<div class="wp-block-cover alignfull hero-section">
  <span aria-hidden="true" class="wp-block-cover__background has-black-background-color has-background-dim"></span>
  <div class="wp-block-cover__inner-container">
    <div class="container-lg">

      <!-- pull in your “section‐title” atom -->
      <!-- wp:pattern {"slug":"understrap/atom-section-title"} /-->

      <!-- pull in your “subheading” atom -->
      <!-- wp:pattern {"slug":"understrap/atom-subheading"} /-->

      <!-- pull in your “paragraph‐text” atom -->
      <!-- wp:pattern {"slug":"understrap/atom-paragraph-text"} /-->

      <!-- pull in your “button” atom -->
      <!-- wp:pattern {"slug":"understrap/atom-button"} /-->

    </div>
  </div>
</div>
<!-- /wp:cover -->'
        ]
    );
} );
