<?php
/**
 * Organism: Site Header
 */
defined( 'ABSPATH' ) || exit;

add_action( 'init', function() {
    register_block_pattern(
        'understrap/organism-site-header',
        [
            'title'      => esc_html__( 'Organism: Site Header', 'understrap-child' ),
            'categories' => [ 'understrap-organism', 'header', 'navigation' ],
            'content'    => '
<!-- wp:group {"align":"full","className":"site-header py-3"} -->
<div class="wp-block-group alignfull site-header py-3">
  <div class="container d-flex align-items-center justify-content-between">

    <!-- Logo + Text -->
    <div class="d-flex align-items-center gap-3">
      <!-- Temporary icon image -->
      <!-- wp:image {"width":48,"height":48,"className":"eagle-logo"} -->
      <figure class="wp-block-image eagle-logo" style="width:48px;height:48px;"><img src="' . esc_url( get_stylesheet_directory_uri() . '/assets/eagle-placeholder.png' ) . '" alt="Eagle logo" /></figure>
      <!-- /wp:image -->

      <div class="site-title">
        <!-- wp:paragraph {"className":"mb-0 fw-bold text-white"} -->
        <p class="mb-0 fw-bold text-white" style="font-family:\'Russo One\', sans-serif;">Douglas Whited PTO</p>
        <!-- /wp:paragraph -->
      </div>
    </div>

    <!-- Nav Menu Placeholder -->
    <!-- wp:navigation {"layout":{"type":"flex","justifyContent":"right"}} /-->

  </div>
</div>
<!-- /wp:group -->',
        ]
    );
} );
