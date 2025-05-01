<?php error_log('DEBUG: Loading inc/block-patterns.php'); ?>

<?php
/**
 * Register custom block-pattern categories & patterns.
 *
 * @package understrap-child
 */

function understrap_child_register_block_patterns() {
    // 1) Pattern Categories
    if ( function_exists( 'register_block_pattern_category' ) ) {
        $cats = [
            'hero'      => __( 'Hero Sections',      'understrap-child' ),
            'events'    => __( 'Events Sections',    'understrap-child' ),
            'about'     => __( 'About Sections',     'understrap-child' ),
            'volunteer' => __( 'Volunteer Sections', 'understrap-child' ),
            'contact'   => __( 'Contact Sections',   'understrap-child' ),
            'general'   => __( 'General Sections',   'understrap-child' ),
        ];
        foreach ( $cats as $slug => $label ) {
            register_block_pattern_category( $slug, [ 'label' => $label ] );
        }
    }

    // Bail if patterns API not available
    if ( ! function_exists( 'register_block_pattern' ) ) {
        return;
    }

    //
    // 2) Hero Variations
    //
    register_block_pattern( 'understrap-child/hero-home', [
        'title'       => __( 'Home Hero', 'understrap-child' ),
        'categories'  => [ 'hero' ],
        'description' => __( 'Your dynamic home hero with background, title & button', 'understrap-child' ),
        'content'     => sprintf(
            '<!-- wp:group {"align":"full","className":"pattern-hero-home"} -->
              <div class="wp-block-group alignfull pattern-hero-home">
                <!-- wp:understrap-child/hero-section %s /-->
              </div>
            <!-- /wp:group -->',
            wp_json_encode( [
                'background' => get_stylesheet_directory_uri() . '/images/hero-default.jpeg',
                'title'      => get_theme_mod( 'understrap_child_hero_title', 'Welcome to Whited PTO' ),
                'buttonText' => 'Get Involved',
            ] )
        ),
    ] );

}


  
add_action( 'init', 'understrap_child_register_block_patterns' );

