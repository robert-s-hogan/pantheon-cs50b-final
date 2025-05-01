<?php
/**
 * Understrap Child Theme functions and definitions
 *
 * @package UnderstrapChild
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * 1) Hide all of WordPress’s built-in block patterns.
 *    (so the Patterns panel only shows the ones you register)
 */
add_action( 'after_setup_theme', function(){
    remove_theme_support( 'core-block-patterns' );
  }, 11 );

// error_log('DEBUG: Successfully loaded inc/atomic.php'); // Remove or comment out this line - it's in the wrong place


/**
 * 3) Load your custom block patterns.
 *    Require files in logical dependency order.
 */
// error_log('DEBUG: Attempting to load inc/atomic.php...'); // Remove temporary log
require get_stylesheet_directory() . '/inc/atomic.php'; // <--- UNCOMMENT THIS!
// error_log('DEBUG: Finished attempting to load inc/atomic.php'); // Remove temporary log


// error_log('DEBUG: Attempting to load inc/block-types.php...'); // Remove temporary log
require get_stylesheet_directory() . '/inc/block-types.php'; // <--- UNCOMMENT THIS! Requires atomic.php
// error_log('DEBUG: Finished attempting to load inc/block-types.php'); // Remove temporary log


// error_log('DEBUG: Attempting to load inc/block-patterns.php...'); // Remove temporary log
require get_stylesheet_directory() . '/inc/block-patterns.php'; // <--- UNCOMMENT THIS! Requires block-types.php etc.
// error_log('DEBUG: Finished attempting to load inc/block-patterns.php'); // Remove temporary log


// Register block patterns - this hook is defined *within* inc/block-patterns.php
// REMOVE this redundant action hook call from functions.php
// add_action( 'init', 'understrap_child_register_block_patterns', 20 );


// error_log('DEBUG: Loading child theme functions.php END'); // Remove temporary log


/**
 * 4) Your existing enqueue / customizer code below…
 */
add_action( 'wp_enqueue_scripts', 'understrap_remove_scripts', 20 );
function understrap_remove_scripts() {
    wp_dequeue_style(  'understrap-styles' );
    wp_deregister_style( 'understrap-styles' );
    wp_dequeue_script( 'understrap-scripts' );
    wp_deregister_script( 'understrap-scripts' );
}

add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
    $the_theme   = wp_get_theme();
    $suffix      = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
    $style_path  = "/css/child-theme{$suffix}.css";
    $script_path = "/js/child-theme{$suffix}.js";

    wp_enqueue_style(
        'child-understrap-styles',
        get_stylesheet_directory_uri() . $style_path,
        [],
        $the_theme->get( 'Version' )
    );

    wp_enqueue_script( 'jquery' );
    wp_enqueue_script(
        'child-understrap-scripts',
        get_stylesheet_directory_uri() . $script_path,
        [],
        $the_theme->get( 'Version' ),
        true
    );

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}

add_action( 'after_setup_theme', 'add_child_theme_textdomain' );
function add_child_theme_textdomain() {
    load_child_theme_textdomain(
        'understrap-child',
        get_stylesheet_directory() . '/languages'
    );
}

add_filter( 'theme_mod_understrap_bootstrap_version', 'understrap_default_bootstrap_version', 20 );
function understrap_default_bootstrap_version() {
    return 'bootstrap5';
}

add_action( 'customize_controls_enqueue_scripts', 'understrap_child_customize_controls_js' );
function understrap_child_customize_controls_js() {
    wp_enqueue_script(
        'understrap_child_customizer',
        get_stylesheet_directory_uri() . '/js/customizer-controls.js',
        [ 'customize-preview' ],
        '20130508',
        true
    );
}

add_action( 'customize_register', 'understrap_child_customize_register' );
function understrap_child_customize_register( $wp_customize ) {
    $wp_customize->add_section( 'hero_section', [
        'title'    => __( 'Hero Settings', 'understrap-child' ),
        'priority' => 30,
    ] );

    $wp_customize->add_setting( 'understrap_child_hero_image' );
    $wp_customize->add_control( new WP_Customize_Image_Control(
        $wp_customize,
        'understrap_child_hero_image',
        [
            'label'   => __( 'Hero Background', 'understrap-child' ),
            'section' => 'hero_section',
        ]
    ) );

    $wp_customize->add_setting( 'understrap_child_hero_title', [ 'default' => 'Welcome!' ] );
    $wp_customize->add_control( 'understrap_child_hero_title', [
        'label'   => __( 'Hero Title', 'understrap-child' ),
        'section' => 'hero_section',
    ] );
}