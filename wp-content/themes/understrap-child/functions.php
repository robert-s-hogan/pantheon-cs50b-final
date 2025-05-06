<?php
/**
 * UnderStrap Child Theme functions and definitions
 *
 * @package UnderstrapChild
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Load your block patterns.
require_once get_stylesheet_directory() . '/inc/block-patterns/init.php';

/**
 * Dequeue parent assets & enqueue combined parent + child CSS/JS
 */
add_action( 'wp_enqueue_scripts', 'understrap_child_enqueue_assets', 20 );
function understrap_child_enqueue_assets() {
    $theme_version = wp_get_theme()->get( 'Version' );

    // 1) Google Fonts
    wp_enqueue_style(
        'understrap-google-fonts',
        'https://fonts.googleapis.com/css2?family=Russo+One&family=Open+Sans:wght@400;600&display=swap',
        [],
        null
    );

    // 2) Parent UnderStrap CSS — note: css/theme.min.css, not build/css/style.min.css
    wp_enqueue_style(
        'understrap-parent-styles',
        get_template_directory_uri() . '/css/theme.min.css',
        [],
        $theme_version
    );

    // 3) Your child theme CSS
    $child_css_rel  = '/css/child-theme.css';
    $child_css_path = get_stylesheet_directory() . $child_css_rel;
    $child_version  = file_exists( $child_css_path )
                      ? filemtime( $child_css_path )
                      : $theme_version;

    wp_enqueue_style(
        'understrap-child-styles',
        get_stylesheet_directory_uri() . $child_css_rel,
        [ 'understrap-parent-styles', 'understrap-google-fonts' ],
        $child_version
    );

    // 4) (Optional) child Bootstrap bundle JS
    $bootstrap_js_rel  = '/js/vendor/bootstrap.bundle.min.js';
    $bootstrap_js_path = get_stylesheet_directory() . $bootstrap_js_rel;
    if ( file_exists( $bootstrap_js_path ) ) {
        wp_enqueue_script(
            'understrap-child-bootstrap-bundle',
            get_stylesheet_directory_uri() . $bootstrap_js_rel,
            [ 'jquery' ],
            filemtime( $bootstrap_js_path ),
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
