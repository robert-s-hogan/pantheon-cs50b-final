<?php
/**
 * Molecule: Why Get Involved
 */
defined( 'ABSPATH' ) || exit;

add_action( 'init', function() {
    register_block_pattern(
        'understrap/molecule-why-get-involved',
        [
            'title'      => __( 'Molecule: Why Get Involved', 'understrap-child' ),
            'categories' => [ 'understrap-molecule', 'callout', 'text' ],
            'content'    =>
                '<!-- wp:group {"className":"why-get-involved bg-white py-5"} -->' .
                '<div class="wp-block-group why-get-involved bg-white py-5">' .
                '  <!-- wp:heading {"level":3,"className":"text-center mb-4"} -->' .
                '  <h3 class="text-center mb-4">Why Get Involved?</h3>' .
                '  <!-- /wp:heading -->' .

                '  <!-- wp:columns {"className":"text-center"} -->' .
                '  <div class="wp-block-columns text-center">' .

                '    <!-- wp:column -->' .
                '    <div class="wp-block-column">' .
                '      <div class="feature-box p-3 border rounded h-100">' .
                '        <!-- wp:paragraph {"className":"icon-heart"} -->' .
                '        <p class="icon-heart" style="font-size:2rem;">❤️</p>' .
                '        <!-- /wp:paragraph -->' .
                '        <!-- wp:heading {"level":4,"className":"h6"} -->' .
                '        <h4 class="h6">Support Students</h4>' .
                '        <!-- /wp:heading -->' .
                '        <!-- wp:paragraph -->' .
                '        <p>Every hour volunteered and every dollar donated directly benefits our students.</p>' .
                '        <!-- /wp:paragraph -->' .
                '      </div>' .
                '    </div>' .
                '    <!-- /wp:column -->' .

                '    <!-- wp:column -->' .
                '    <div class="wp-block-column">' .
                '      <div class="feature-box p-3 border rounded h-100">' .
                '        <!-- wp:paragraph {"className":"icon-community"} -->' .
                '        <p class="icon-community" style="font-size:2rem;">🤝</p>' .
                '        <!-- /wp:paragraph -->' .
                '        <!-- wp:heading {"level":4,"className":"h6"} -->' .
                '        <h4 class="h6">Build Community</h4>' .
                '        <!-- /wp:heading -->' .
                '        <!-- wp:paragraph -->' .
                '        <p>We host fun family events to bring the community together.</p>' .
                '        <!-- /wp:paragraph -->' .
                '      </div>' .
                '    </div>' .
                '    <!-- /wp:column -->' .

                '    <!-- wp:column -->' .
                '    <div class="wp-block-column">' .
                '      <div class="feature-box p-3 border rounded h-100">' .
                '        <!-- wp:paragraph {"className":"icon-school"} -->' .
                '        <p class="icon-school" style="font-size:2rem;">🏫</p>' .
                '        <!-- /wp:paragraph -->' .
                '        <!-- wp:heading {"level":4,"className":"h6"} -->' .
                '        <h4 class="h6">Strengthen School Ties</h4>' .
                '        <!-- /wp:heading -->' .
                '        <!-- wp:paragraph -->' .
                '        <p>We’re building a stronger connection between home and school.</p>' .
                '        <!-- /wp:paragraph -->' .
                '      </div>' .
                '    </div>' .
                '    <!-- /wp:column -->' .

                '  </div>' .
                '  <!-- /wp:columns -->' .
                '</div>' .
                '<!-- /wp:group -->',
        ]
    );
} );
