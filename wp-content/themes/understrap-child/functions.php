<?php
/**
 * UnderStrap Child Theme functions and definitions
 *
 * @package UnderstrapChild
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * 1) Hide WordPress core block patterns
 */
add_action( 'after_setup_theme', function() {
    remove_theme_support( 'core-block-patterns' );
}, 11 );

/**
 * 2) Load all of your atomic helpers, custom block types & block patterns
 *
 * inc/block-patterns/init.php should itself require:
 *   – atomic.php
 *   – block-types.php
 *   – block-patterns.php
 * in the proper order.
 */
require_once get_stylesheet_directory() . '/inc/block-patterns/init.php';

/**
 * 3) Theme setup: textdomain, editor support, menus, Bootstrap override
 */
add_action( 'after_setup_theme', 'understrap_child_setup' );
function understrap_child_setup() {
    // 3a) Translations
    load_child_theme_textdomain( 'understrap-child', get_stylesheet_directory() . '/languages' );

    // 3b) Editor features
    add_theme_support( 'align-wide' );
    add_theme_support( 'wp-block-styles' );
    add_theme_support( 'responsive-embeds' );
    add_theme_support( 'editor-styles' );
    add_editor_style( 'css/child-theme.css' );

    // 3c) Primary menu
    register_nav_menus( [
        'primary' => __( 'Primary Menu', 'understrap-child' ),
    ] );

    // 3d) Force Bootstrap 5
    add_filter( 'theme_mod_understrap_bootstrap_version', 'understrap_child_default_bootstrap_version', 20 );
}
function understrap_child_default_bootstrap_version() {
    return 'bootstrap5';
}

/**
 * 4) Enqueue / dequeue front‑end assets
 */
add_action( 'wp_enqueue_scripts', 'understrap_child_enqueue_assets', 20 );
function understrap_child_enqueue_assets() {
    // 4a) Remove parent UnderStrap CSS & JS
    wp_dequeue_style(  'understrap-styles' );
    wp_deregister_style( 'understrap-styles' );
    wp_dequeue_script( 'understrap-scripts' );
    wp_deregister_script( 'understrap-scripts' );

    // 4b) Google Fonts (Russo One, Open Sans)
    wp_enqueue_style(
        'google-font-russo',
        'https://fonts.googleapis.com/css2?family=Russo+One&family=Open+Sans:wght@400;600&display=swap',
        [],
        null
    );

    // 4c) Your compiled Sass CSS
    $css_rel  = '/build/assets/css/app.css';
    $css_path = get_stylesheet_directory() . $css_rel;
    $version  = file_exists( $css_path ) ? filemtime( $css_path ) : wp_get_theme()->get( 'Version' );
    wp_enqueue_style(
        'understrap-child-css',
        get_stylesheet_directory_uri() . $css_rel,
        [ 'google-font-russo' ],
        $version
    );

    // 4d) Bootstrap JS bundle (if you still need it)
    $js_rel  = '/js/vendor/bootstrap.bundle.min.js';
    $js_path = get_stylesheet_directory() . $js_rel;
    if ( file_exists( $js_path ) ) {
        wp_enqueue_script(
            'understrap-child-bootstrap-bundle',
            get_stylesheet_directory_uri() . $js_rel,
            [],
            filemtime( $js_path ),
            true
        );
    }
}

/**
 * 5) Customizer controls JS
 */
add_action( 'customize_controls_enqueue_scripts', 'understrap_child_customize_controls_js' );
function understrap_child_customize_controls_js() {
    wp_enqueue_script(
        'understrap-child-customizer',
        get_stylesheet_directory_uri() . '/js/customizer-controls.js',
        [ 'customize-preview' ],
        '20130508',
        true
    );
}
