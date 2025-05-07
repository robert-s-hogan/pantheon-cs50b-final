<?php
/**
 * UnderStrap Child Theme functions.php
 *
 * Note: Many core WordPress setups (like post types, taxonomies, etc.)
 * should ideally live in a plugin. This functions.php focuses on theme-specific
 * setup and asset loading.
 *
 * @package UnderstrapChild
 */
defined( 'ABSPATH' ) || exit;

// 1) Block Patterns loader
// Requires /inc/block-patterns/init.php to exist.
// This file recursively loads all other pattern files in /inc/block-patterns/
if ( file_exists( get_stylesheet_directory() . '/inc/block-patterns/init.php' ) ) {
    require_once get_stylesheet_directory() . '/inc/block-patterns/init.php';
}


// 2) Strip core layout‑style flags globally from core/cover block
// This helps prevent conflicts if you are defining your own grid/flex styles for Cover blocks.
// Note: This filter is applied relatively late (priority 20) to ensure it runs after other potential filters.
add_filter( 'render_block', function( $block_content, $block ) {
    // Check if it's the core/cover block
    if ( isset( $block['blockName'] ) && $block['blockName'] === 'core/cover' ) {
        // Use regex to remove the 'is-layout-*' and 'wp-block-cover-is-layout-*' classes
        $block_content = preg_replace(
            '/(wp-block-cover__inner-container)(?:\s+is-layout-\w+|\s+wp-block-cover-is-layout-\w+)/',
            '$1', // Replace with just the base class 'wp-block-cover__inner-container'
            $block_content
        );
    }
    return $block_content;
}, 20, 2 ); // Increased priority to 20, added block content/block args


// 3) Disable layout support settings for core/cover block
// This prevents Gutenberg from adding layout controls (like 'justify content')
// in the editor sidebar for the Cover block, relying on your theme's styles.
add_filter( 'block_type_metadata_settings', function( $settings, $metadata ) {
    if ( isset( $metadata['name'] ) && $metadata['name'] === 'core/cover' ) {
        // Turn off all layout support by setting the 'layout' setting to false
        $settings['supports']['layout'] = false;
    }
    return $settings;
}, 10, 2 );


/**
 * 4) Enqueue Child CSS/JS
 */
add_action( 'wp_enqueue_scripts', 'understrap_child_enqueue_assets', 20 );
function understrap_child_enqueue_assets() {

    // a) Dequeue and deregister the parent UnderStrap CSS entirely
    // We assume your child theme's CSS bundle replaces the parent's main stylesheet.
    wp_dequeue_style(  'understrap-styles' );
    wp_deregister_style( 'understrap-styles' );

    // b) Google Fonts (optional)
    // Enqueue Google Fonts early so they are available before your CSS
    wp_enqueue_style(
        'google-font-russo',
        'https://fonts.googleapis.com/css2?family=Russo+One&family=Open+Sans:wght@400;600&display=swap',
        [], // No dependencies for the font itself
        null // Use null for version if it's a static external URL
    );

    // c) Your compiled child CSS (from your build process, e.g., build/assets/css/app.css)
    $css_rel  = '/build/assets/css/app.css'; // Path relative to theme root
    $css_full = get_stylesheet_directory() . $css_rel; // Full server path




// --- TEMPORARY DEBUG ---
// NOTE: These logs will go to wp-content/debug.log on Pantheon
error_log("Debugging CSS Path Check:");
error_log("Expected relative path: " . $css_rel);
error_log("Resolved absolute path: " . $css_full);
if (file_exists($css_full)) {
    error_log("Result: CSS file FOUND!");
} else {
    error_log("Result: CSS file NOT FOUND at: " . $css_full);
}
error_log("--- End Debug ---");
// --- END TEMPORARY DEBUG ---


    // Determine version based on file modified time for cache busting
    // Fallback to theme version if file doesn't exist (though it should!)
    $version  = file_exists( $css_full )
                ? filemtime( $css_full )
                : wp_get_theme()->get( 'Version' );

    wp_enqueue_style(
        'understrap-child-css', // Unique handle for your stylesheet
        get_stylesheet_directory_uri() . $css_rel, // Public URL
        [ 'google-font-russo' ],  // Dependency: load after Google Fonts
        $version // Version for cache busting
    );

    // d) You might want to keep the parent's Bootstrap JS bundle.
    //    If so, do NOT dequeue 'understrap-scripts' here.
    //    If you have custom JS, enqueue it here with `true` for in_footer.
}

/**
 * 5) Load the child theme's text domain for translations.
 */
add_action( 'after_setup_theme', 'understrap_child_load_textdomain' );
function understrap_child_load_textdomain() {
    load_child_theme_textdomain( 'understrap-child', get_stylesheet_directory() . '/languages' );
}

/**
 * 6) Editor support for block styles, wide alignments, etc.
 */
add_action( 'after_setup_theme', 'understrap_child_editor_support' );
function understrap_child_editor_support() {
    add_theme_support( 'align-wide' ); // Enables wide and full alignments for blocks
    add_theme_support( 'wp-block-styles' ); // Adds default WordPress block styles
    add_theme_support( 'responsive-embeds' ); // Makes embeds responsive
    add_theme_support( 'editor-styles' ); // Enables the editor stylesheet feature
    // Enqueue your editor styles. Make sure this CSS file also exists (compiled from SASS usually).
    add_editor_style( 'css/child-theme.css' );
    add_theme_support( 'disable-layout-styles' ); // Disable core layout styles if you're providing your own
}

/**
 * 7) Register Primary Menu location.
 */
add_action( 'after_setup_theme', function() {
    register_nav_menus( [
        'primary' => __( 'Primary Menu', 'understrap-child' ),
    ] );
} );

/**
 * 8) Default to Bootstrap 5 (override parent default).
 */
add_filter( 'theme_mod_understrap_bootstrap_version', 'understrap_child_default_bootstrap_version', 20 );
function understrap_child_default_bootstrap_version() {
    return 'bootstrap5';
}

/**
 * 9) Enqueue customizer scripts for live preview, if needed.
 */
// This is usually for adding custom controls, preview updates, etc.
// Only necessary if you have customizer-controls.js
if ( file_exists( get_stylesheet_directory() . '/js/customizer-controls.js' ) ) {
    add_action( 'customize_controls_enqueue_scripts', 'understrap_child_customize_controls_js' );
    function understrap_child_customize_controls_js() {
        wp_enqueue_script(
            'understrap-child-customizer',
            get_stylesheet_directory_uri() . '/js/customizer-controls.js',
            [ 'customize-preview' ], // Depends on the customizer preview script
            '1.0.0', // Script version
            true // Load in footer
        );
    }
}