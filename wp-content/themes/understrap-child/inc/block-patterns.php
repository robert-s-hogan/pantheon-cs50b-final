<?php
// inc/block-patterns.php

function understrap_child_register_block_patterns() {
    // 1) Define custom pattern categories
    if ( function_exists( 'register_block_pattern_category' ) ) {
        register_block_pattern_category(
            'hero',
            [ 'label' => __( 'Hero Sections', 'understrap-child' ) ]
        );
        register_block_pattern_category(
            'events',
            [ 'label' => __( 'Events Sections', 'understrap-child' ) ]
        );
    }

    // 2) Register patterns
    if ( function_exists( 'register_block_pattern' ) ) {
        // Full-width Hero with button
        register_block_pattern(
            'understrap-child/hero-full',
            [
                'title'      => __( 'Full-width Hero', 'understrap-child' ),
                'categories' => [ 'hero' ],
                'content'    => <<<'HTML'
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"4rem","bottom":"4rem"}}},"backgroundColor":"light"} -->
<div class="wp-block-group alignfull has-light-background-color has-background" style="padding-top:4rem;padding-bottom:4rem">
    <!-- wp:heading {"textAlign":"center","level":1} -->
    <h1 class="has-text-align-center">Welcome to Whited PTO</h1>
    <!-- /wp:heading -->
    <!-- wp:paragraph {"align":"center"} -->
    <p class="has-text-align-center">Supporting Our Students, Empowering Our Community</p>
    <!-- /wp:paragraph -->
    <!-- wp:button {"backgroundColor":"primary","align":"center"} -->
    <div class="wp-block-button aligncenter">
        <a class="wp-block-button__link has-primary-background-color has-background">Get Involved</a>
    </div>
    <!-- /wp:button -->
</div>
<!-- /wp:group -->
HTML
            ]
        );

        // Featured Events list
        register_block_pattern(
            'understrap-child/featured-events',
            [
                'title'      => __( 'Featured Events', 'understrap-child' ),
                'categories' => [ 'events' ],
                'content'    => <<<'HTML'
<!-- wp:group {"align":"wide","style":{"spacing":{"padding":{"top":"2rem","bottom":"2rem"}}}} -->
<div class="wp-block-group alignwide" style="padding-top:2rem;padding-bottom:2rem">
    <!-- wp:heading {"level":2} -->
    <h2>Featured Events</h2>
    <!-- /wp:heading -->
    <!-- wp:paragraph -->
    <p>Upcoming Events Highlight</p>
    <!-- /wp:paragraph -->

    <!-- wp:group {"style":{"border":{"width":"1px","color":"#ddd"},"spacing":{"padding":{"all":"1rem"}}}} -->
    <div class="wp-block-group has-border" style="border-color:#ddd;border-width:1px;padding:1rem">
        <!-- wp:heading {"level":3} -->
        <h3>Fall Harvest Festival</h3>
        <!-- /wp:heading -->
        <!-- wp:paragraph -->
        <p><strong>Date/Time:</strong> October 15, 4–7 PM</p>
        <!-- /wp:paragraph -->
        <!-- wp:paragraph -->
        <p><strong>Quick Description:</strong> Celebrate autumn with games, a pumpkin patch, and tasty treats. Volunteers needed!</p>
        <!-- /wp:paragraph -->
    </div>
    <!-- /wp:group -->

    <!-- wp:group {"style":{"border":{"width":"1px","color":"#ddd"},"spacing":{"padding":{"all":"1rem"}}}} -->
    <div class="wp-block-group has-border" style="border-color:#ddd;border-width:1px;padding:1rem">
        <!-- wp:heading {"level":3} -->
        <h3>Winter Book Fair</h3>
        <!-- /wp:heading -->
        <!-- wp:paragraph -->
        <p><strong>Date/Time:</strong> December 5–9 (during school hours)</p>
        <!-- /wp:paragraph -->
        <!-- wp:paragraph -->
        <p><strong>Quick Description:</strong> Support literacy! Purchase books for your child and donate to the classroom library.</p>
        <!-- /wp:paragraph -->
    </div>
    <!-- /wp:group -->
</div>
<!-- /wp:group -->
HTML
            ]
        );
    }
}
add_action( 'init', 'understrap_child_register_block_patterns' );
