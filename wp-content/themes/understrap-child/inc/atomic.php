<?php
// inc/atomic.php
namespace UnderstrapChild\Atomic;

function render_template( $slug, $args = [] ) {
    $template_path = get_stylesheet_directory() . '/template-parts/' . $slug . '.php';
    if ( ! file_exists( $template_path ) ) {
        // Handle error appropriately
        return '';
    }

    ob_start(); // Start output buffering
    // Include the template file... BUT HOW ARE $args PASSED?
    // require $template_path; // This alone won't make $args keys variables

    // Corrected approach: Extract args into variables before including
    if ( ! empty( $args ) && is_array( $args ) ) {
        extract( $args ); // <--- ADD THIS LINE
    }
    require $template_path; // Now $background, $title, etc. will be available if they were keys in $args

    return ob_get_clean(); // Return the buffered output
}