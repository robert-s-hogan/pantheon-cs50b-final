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


/**
 * 3) Load your custom block patterns and types.
 *    Require files in logical dependency order if necessary (atomic -> block-types -> block-patterns).
 *    Using get_stylesheet_directory() is correct for a child theme loading its own files.
 */

// Path to your inc directory within the child theme.
$inc_dir = get_stylesheet_directory() . '/inc';

// Include atomic design helper file first, as it might contain functions used by render callbacks or templates.
$atomic_path = $inc_dir . '/atomic.php';
if (file_exists($atomic_path)) { // Check if file exists before requiring
    require_once $atomic_path;
} else {
     // Optional: Log an error if the file is missing for debugging
     // error_log("ERROR: Missing required theme file: " . $atomic_path);
}

// Include custom block types registration. This registers the block using block.json.
$block_types_path = $inc_dir . '/block-types.php';
if (file_exists($block_types_path)) { // Check if file exists before requiring
    require_once $block_types_path;
} else {
     // error_log("ERROR: Missing required theme file: " . $block_types_path);
}


// Include custom block patterns registration. This defines the patterns using the registered block types.
$block_patterns_path = $inc_dir . '/block-patterns.php';
if (file_exists($block_patterns_path)) { // Check if file exists before requiring
    require_once $block_patterns_path;
} else {
     // error_log("ERROR: Missing required theme file: " . $block_patterns_path);
}


// Register block patterns - this hook is defined *within* inc/block-patterns.php
// REMOVE this redundant action hook call from functions.php - it's already handled in inc/block-patterns.php
// add_action( 'init', 'understrap_child_register_block_patterns', 20 );


/**
 * 4) Your existing enqueue / customizer code below…
 *    Keeping customizer settings that affect block patterns.
 *    Keeping standard enqueue code as it's needed for the theme to function.
 *    These parts are necessary for the block *pattern* to fetch data (like hero title from customizer)
 *    and for the theme to style the resulting HTML.
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

// Note: The customizer and enqueue code here is standard theme setup.
// It doesn't directly affect the block *rendering logic* itself (which is in renderCallback/templates),
// but the customizer settings do provide attribute values for the pattern.
// Keeping this code is reasonable for a functional theme.