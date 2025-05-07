<?php
defined( 'ABSPATH' ) || exit;

// 1) Patterns loader
require_once get_stylesheet_directory() . '/inc/block-patterns/init.php';

// 2) Strip core layout‑style flags globally
remove_filter( 'render_block', 'wp_render_layout_support_flag',       10 );
remove_filter( 'render_block', 'gutenberg_render_layout_support_flag', 10 );
add_filter( 'render_block', function( $content, $block ) {
    if ( isset( $block['blockName'] ) && $block['blockName'] === 'core/cover' ) {
        $content = preg_replace(
            '/(wp-block-cover__inner-container)(?:\s+is-layout-\w+|\s+wp-block-cover-is-layout-\w+)/',
            '$1',
            $content
        );
    }
    return $content;
}, 100, 2 );

/**
 * Dequeue parent assets & enqueue combined parent + child CSS/JS
 */
add_action( 'wp_enqueue_scripts', 'understrap_child_enqueue_assets', 20 );
function understrap_child_enqueue_assets() {

    wp_dequeue_style(  'understrap-styles' );
    wp_deregister_style( 'understrap-styles' );
    wp_dequeue_script( 'understrap-scripts' );
    wp_deregister_script( 'understrap-scripts' );
    $parent_version = wp_get_theme()->get( 'Version' );

   // 3) Load your compiled child CSS
   $css_rel  = '/build/assets/css/app.css';
   $css_full = get_stylesheet_directory() . $css_rel;
   $version  = file_exists( $css_full ) 
                ? filemtime( $css_full ) 
                : wp_get_theme()->get('Version');

    wp_enqueue_style(
    'google-font-russo',
    'https://fonts.googleapis.com/css2?family=Russo+One&family=Open+Sans:wght@400;600&display=swap',
    [],
    null
    );

    wp_enqueue_style(
        'understrap-child-css',
        get_stylesheet_directory_uri() . $css_rel,
        [ 'google-font-russo' ], // Make Google Font a dependency (optional)
        $version
      );

    // 4) (Optional) Bootstrap JS bundle if you have it
    $js_rel  = '/js/vendor/bootstrap.bundle.min.js';
    $js_path = get_stylesheet_directory() . $js_rel;
    if ( file_exists( $js_path ) ) {
        wp_enqueue_script(
            'understrap-child-bootstrap-bundle',
            get_stylesheet_directory_uri() . $js_rel,
            [ 'jquery' ],
            filemtime( $js_path ),
            true
        );
    }
}



/**
 * Load the child theme's text domain.
 */
add_action( 'after_setup_theme', 'understrap_child_load_textdomain' );
function understrap_child_load_textdomain() {
    load_child_theme_textdomain( 'understrap-child', get_stylesheet_directory() . '/languages' );
}

/**
 * Editor support for block styles, wide alignments, etc.
 */
add_action( 'after_setup_theme', 'understrap_child_editor_support' );
function understrap_child_editor_support() {
    add_theme_support( 'align-wide' );
    add_theme_support( 'wp-block-styles' );
    add_theme_support( 'responsive-embeds' );
    add_theme_support( 'editor-styles' );
    add_editor_style( 'css/child-theme.css' );
    // Remove the core layout classes on inner containers (Cover, Group, etc.)
add_theme_support( 'disable-layout-styles' );


}

/**
 * Register Primary Menu location.
 */
add_action( 'after_setup_theme', function() {
    register_nav_menus( [
        'primary' => __( 'Primary Menu', 'understrap-child' ),
    ] );
} );

/**
 * Default to Bootstrap 5 (override parent default).
 */
add_filter( 'theme_mod_understrap_bootstrap_version', 'understrap_child_default_bootstrap_version', 20 );
function understrap_child_default_bootstrap_version() {
    return 'bootstrap5';
}

/**
 * Enqueue customizer scripts for live preview, if needed.
 */
add_action( 'customize_controls_enqueue_scripts', 'understrap_child_customize_controls_js' );
function understrap_child_customize_controls_js() {
    wp_enqueue_script(
        'understrap-child-customizer',
        get_stylesheet_directory_uri() . '/js/customizer-controls.js',
        [ 'customize-preview' ],
        '1.0.0',
        true
    );
}

/**
 * Strip `is-layout-*` and `wp-block-cover-is-layout-*` classes
 * from the inner container of every Cover block on the front end.
 */
add_filter( 'render_block', function( $block_content, $block ) {
    if ( isset( $block['blockName'] ) && $block['blockName'] === 'core/cover' ) {
        $block_content = preg_replace(
            // Match the base class plus any layout classes
            '/(wp-block-cover__inner-container)(?:\s+is-layout-\w+|\s+wp-block-cover-is-layout-\w+)/',
            '$1',
            $block_content
        );
    }
    return $block_content;
}, 20, 2 );