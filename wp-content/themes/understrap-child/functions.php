<?php
defined( 'ABSPATH' ) || exit;

/**
 * 1) Load all block patterns
 */
require_once get_stylesheet_directory() . '/inc/block-patterns/init.php';

/**
 * 2) Strip Gutenberg layout flags from core/cover
 */
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
 * 3) Enqueue Styles & Scripts
 */
add_action( 'wp_enqueue_scripts', 'understrap_child_enqueue_assets', 20 );
function understrap_child_enqueue_assets() {

    // **a) Remove the parent UnderStrap CSS entirely**
    wp_dequeue_style(  'understrap-styles' );
    wp_deregister_style( 'understrap-styles' );

    // **b) Google Fonts**
    wp_enqueue_style(
        'google-font-russo',
        'https://fonts.googleapis.com/css2?family=Russo+One&family=Open+Sans:wght@400;600&display=swap',
        [],
        null
    );

    // **c) Your compiled child CSS** (which should import/bootstrap and your .wrapper rule)
    $css_rel  = '/build/assets/css/app.css';
    $css_full = get_stylesheet_directory() . $css_rel;
    $version  = file_exists( $css_full ) 
                ? filemtime( $css_full ) 
                : wp_get_theme()->get( 'Version' );

    wp_enqueue_style(
        'understrap-child-css',
        get_stylesheet_directory_uri() . $css_rel,
        [ 'google-font-russo' ],  // fonts first, then your CSS
        $version
    );

    // **d) Leave the parent UnderStrap JS** registered so you still get Bootstrap’s bundle
    //    (i.e. we do NOT dequeue 'understrap-scripts' here).
}

/**
 * 4) Load text domain for translations
 */
add_action( 'after_setup_theme', 'understrap_child_load_textdomain' );
function understrap_child_load_textdomain() {
    load_child_theme_textdomain( 'understrap-child', get_stylesheet_directory() . '/languages' );
}

/**
 * 5) Editor support (wide alignments, block styles, etc.)
 */
add_action( 'after_setup_theme', 'understrap_child_editor_support' );
function understrap_child_editor_support() {
    add_theme_support( 'align-wide' );
    add_theme_support( 'wp-block-styles' );
    add_theme_support( 'responsive-embeds' );
    add_theme_support( 'editor-styles' );
    add_editor_style( 'css/child-theme.css' );
    add_theme_support( 'disable-layout-styles' );
}

/**
 * 6) Register Primary Menu location
 */
add_action( 'after_setup_theme', function() {
    register_nav_menus( [
        'primary' => __( 'Primary Menu', 'understrap-child' ),
    ] );
} );

/**
 * 7) Force Bootstrap 5
 */
add_filter( 'theme_mod_understrap_bootstrap_version', 'understrap_child_default_bootstrap_version', 20 );
function understrap_child_default_bootstrap_version() {
    return 'bootstrap5';
}

/**
 * 8) Customizer controls (live preview)
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


/**
 * Disable layout support on core/cover so
 * Gutenberg never injects is-layout-* classes.
 */
add_filter( 'block_type_metadata_settings', function( $settings, $metadata ) {
    if ( isset( $metadata['name'] ) && $metadata['name'] === 'core/cover' ) {
        // Turn off all layout support
        $settings['supports']['layout'] = false;
    }
    return $settings;
}, 10, 2 );
