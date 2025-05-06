<?php
/**
 * Organism: Events List (The Events Calendar)
 */
defined( 'ABSPATH' ) || exit;

add_action( 'init', function() {
    if ( ! function_exists( 'register_block_pattern' ) ) {
        return;
    }

    register_block_pattern(
        'understrap/organism-events-list',
        [
            'title'       => __( 'Organism: Events List', 'understrap-child' ),
            'description' => __( 'List of upcoming events, styled via Sass', 'understrap-child' ),
            'categories'  => [ 'understrap-organism', 'cards' ],
            'keywords'    => [ 'events', 'calendar', 'upcoming' ],
            'content'     =>
            '<!-- wp:group {"align":"wide","className":"upcoming-events"} -->
            <div class="wp-block-group alignwide upcoming-events">
            <!-- wp:tribe/events-list {"view":"list","limit":3} /-->
            </div>
            <!-- /wp:group -->',
        ]
    );
}, 20 );
