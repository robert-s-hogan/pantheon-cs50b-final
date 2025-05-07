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

    <!-- wp:heading {"level":1,"textAlign":"center","className":"section-title"} -->
    <h1 class="has-text-align-center section-title">Your Hero Title</h1>
    <!-- /wp:heading -->

    <!-- wp:paragraph {"align":"center","className":"subheading"} -->
    <p class="has-text-align-center subheading">Your subheading here.</p>
    <!-- /wp:paragraph -->


<!-- wp:button {\"backgroundColor\":\"secondary\"} -->\n" .
<div class=\"wp-block-button\"><a class=\"wp-block-button__link has-secondary-background-color has-background\">Call to Action</a></div>\n" .
<!-- /wp:button -->\n




  </div>
</div>
<!-- /wp:cover -->'

        ]
    );
} );
