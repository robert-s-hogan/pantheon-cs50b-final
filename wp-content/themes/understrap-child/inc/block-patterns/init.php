<?php
/**
 * inc/block-patterns/init.php
 *
 * Registers only your custom block patterns.
 */
defined( 'ABSPATH' ) || exit;

// 1) Load all your atom patterns first:
require get_stylesheet_directory() . '/inc/block-patterns/organisms/site-header.php';
require get_stylesheet_directory() . '/inc/block-patterns/atoms/section-title.php';
require get_stylesheet_directory() . '/inc/block-patterns/atoms/paragraph-text.php';
require get_stylesheet_directory() . '/inc/block-patterns/atoms/subheading.php';
require get_stylesheet_directory() . '/inc/block-patterns/atoms/button.php';

// 2) Then register your hero (organism) which can reference them:
add_action( 'init', function() {
    if ( ! function_exists( 'register_block_pattern' ) ) {
        return;
    }

    register_block_pattern(
        'understrap/organism-hero-section',
        [
            'title'      => __( 'Organism: Hero Section', 'understrap-child' ),
            'categories' => [ 'understrap-organism', 'hero', 'featured' ],
            'content'    => '
<!-- wp:cover {"url":"' . esc_url( get_stylesheet_directory_uri() . '/assets/hero-bg.jpg' ) . '","dimRatio":60,"overlayColor":"black","align":"full","className":"hero-section text-white","minHeight":75,"minHeightUnit":"vh"} -->
<div class="wp-block-cover alignfull hero-section text-white">
  <span aria-hidden="true" class="wp-block-cover__background has-black-background-color has-background-dim"></span>
  <div class="wp-block-cover__inner-container">
    <div class="container-lg">

      <!-- pull in your Section Title atom as an H1 -->
      <!-- wp:pattern {"slug":"understrap/atom-section-title"} /-->

      <!-- pull in your Subheading atom -->
      <!-- wp:pattern {"slug":"understrap/atom-subheading"} /-->

      <!-- pull in your Paragraph Text atom -->
      <!-- wp:pattern {"slug":"understrap/atom-paragraph-text"} /-->

      <!-- pull in your Button atom -->
      <!-- wp:pattern {"slug":"understrap/atom-button"} /-->

    </div>
  </div>
</div>
<!-- /wp:cover -->',
        ]
    );
} );
