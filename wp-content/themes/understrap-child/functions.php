<?php
/**
 * UnderStrap Child Theme functions and definitions
 *
 * @package UnderstrapChild
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

require_once get_stylesheet_directory() . '/inc/block-patterns/init.php';

/**
 * Dequeue parent assets & enqueue
 */
add_action( 'wp_enqueue_scripts', 'understrap_child_enqueue_assets', 20 );
function understrap_child_enqueue_assets() {
    // Remove parent UnderStrap CSS/JS
    wp_dequeue_style(  'understrap-styles' );
    wp_deregister_style( 'understrap-styles' );
    wp_dequeue_script( 'understrap-scripts' );
    wp_deregister_script( 'understrap-scripts' );

    // Enqueue your compiled Sass CSS
    // (adjusted to your build path)
    $css_rel = '/css/child-theme.css';

    $css_full = get_stylesheet_directory() . $css_rel;
    $version  = file_exists( $css_full ) 
                 ? filemtime( $css_full ) 
                 : wp_get_theme()->get('Version');

     // 1. Enqueue Google Font first
    wp_enqueue_style(
      'google-font-russo',
      'https://fonts.googleapis.com/css2?family=Russo+One&family=Open+Sans:wght@400;600&display=swap',
      [],
      null
    );

    // 2. Then enqueue your compiled child theme CSS
    wp_enqueue_style(
      'understrap-child-css',
      get_stylesheet_directory_uri() . $css_rel,
      [ 'google-font-russo' ], // Make Google Font a dependency (optional)
      $version
    );


    // ——————————————
    // Leave the JS/bootstrap bundle enqueue as‑is
    // ——————————————

    $js_rel  = '/js/vendor/bootstrap.bundle.min.js';
    $js_full = get_stylesheet_directory() . $js_rel;

    if ( file_exists( $js_full ) ) {
        wp_enqueue_script(
            'understrap-child-bootstrap-bundle',
            get_stylesheet_directory_uri() . $js_rel,
            [],
            filemtime( $js_full ),
            true
        );
    }
}



/**
 * Load the child theme's text domain for translations.
 */
add_action( 'after_setup_theme', 'understrap_child_load_textdomain' );
function understrap_child_load_textdomain() {
  load_child_theme_textdomain( 'understrap-child', get_stylesheet_directory() . '/languages' );
}

add_action( 'after_setup_theme', 'understrap_child_editor_support' );
function understrap_child_editor_support() {
    // 1) Let blocks go “wide” or “full”‐width
    add_theme_support( 'align-wide' );

    // 2) Use core block styles (so buttons, quotes, etc. look like front‑end)
    add_theme_support( 'wp-block-styles' );

    // 3) Enable responsive embeds (videos, iframes stretch correctly)
    add_theme_support( 'responsive-embeds' );

    // 4) Load your front‑end CSS in the editor too
    add_theme_support( 'editor-styles' );
    add_editor_style( 'css/child-theme.css' );
}


/**
 * Register Primary Menu location.
 */
add_action( 'after_setup_theme', function() {
    register_nav_menus( array(
        'primary' => __( 'Primary Menu', 'understrap-child' ),
    ) );
} );


/**
 * Override UnderStrap default to Bootstrap 5.
 *
 * Uses the theme_mod_{name} hook.
 *
 * @return string
 */
add_filter( 'theme_mod_understrap_bootstrap_version', 'understrap_child_default_bootstrap_version', 20 );
function understrap_child_default_bootstrap_version() {
  return 'bootstrap5';
}

/**
 * Enqueue customizer controls JS.
 */
add_action( 'customize_controls_enqueue_scripts', 'understrap_child_customize_controls_js' );
function understrap_child_customize_controls_js() {
  wp_enqueue_script(
    'understrap-child-customizer',
    get_stylesheet_directory_uri() . '/js/customizer-controls.js',
    ['customize-preview'],
    '20130508',
    true
  );
}

