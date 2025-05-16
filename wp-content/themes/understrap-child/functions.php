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



/**
 * ----------------------------------------------------------------------------
 * 2) Re‑enable WP Core Block Patterns
 * ----------------------------------------------------------------------------
 */
add_action( 'after_setup_theme', function() {
    // Turn on WP’s built‑in patterns
    add_theme_support( 'core-block-patterns' );

    // You’ll want editor styles so your patterns render correctly in Gutenberg
    add_theme_support( 'editor-styles' );
    // Make sure this path matches where your SASS build outputs
    add_editor_style( 'css/child-theme.css' );
}, 11 );


/**
 * ----------------------------------------------------------------------------
 * 3) Strip core layout‑style flags from core/cover block at render
 * ----------------------------------------------------------------------------
 */
add_filter( 'render_block', function( $block_content, $block ) {
    if ( isset( $block['blockName'] ) && $block['blockName'] === 'core/cover' ) {
        $block_content = preg_replace(
            '/(wp-block-cover__inner-container)(?:\s+is-layout-\w+|\s+wp-block-cover-is-layout-\w+)/',
            '$1',
            $block_content
        );
    }
    return $block_content;
}, 20, 2 );


/**
 * ----------------------------------------------------------------------------
 * 4) Disable Gutenberg’s layout controls for core/cover
 * ----------------------------------------------------------------------------
 */
add_filter( 'block_type_metadata_settings', function( $settings, $metadata ) {
    if ( isset( $metadata['name'] ) && $metadata['name'] === 'core/cover' ) {
        $settings['supports']['layout'] = false;
    }
    return $settings;
}, 10, 2 );


/**
 * ----------------------------------------------------------------------------
 * 5) Enqueue Child CSS/JS
 * ----------------------------------------------------------------------------
 */
add_action( 'wp_enqueue_scripts', 'understrap_child_enqueue_assets', 20 );
function understrap_child_enqueue_assets() {

    // b) Google Fonts (optional)
    wp_enqueue_style(
        'google-font-russo',
        'https://fonts.googleapis.com/css2?family=Russo+One&family=Open+Sans:wght@400;600&display=swap',
        [],
        null
    );

    // c) Your compiled child CSS
    $css_rel  = '/build/assets/css/app.css';
    $css_full = get_stylesheet_directory() . $css_rel;

    // Cache‑busting by filemtime
    $version  = file_exists( $css_full )
                ? filemtime( $css_full )
                : wp_get_theme()->get( 'Version' );

    wp_enqueue_style(
        'understrap-child-css',
        get_stylesheet_directory_uri() . $css_rel,
        [ 'google-font-russo' ],
        $version
    );

    // d) (Optional) Enqueue your JS here, or leave parent scripts intact
}


/**
 * ----------------------------------------------------------------------------
 * 6) Load translation files
 * ----------------------------------------------------------------------------
 */
add_action( 'after_setup_theme', 'understrap_child_load_textdomain' );
function understrap_child_load_textdomain() {
    load_child_theme_textdomain( 'understrap-child', get_stylesheet_directory() . '/languages' );
}

add_action( 'after_setup_theme', function() {
      // 1. Custom logo support
  add_theme_support( 'custom-logo', [
    'height'      => 50,
    'width'       => 200,
    'flex-height' => true,
    'flex-width'  => true,
  ] );
  register_nav_menus( [
    'primary' => __( 'Primary Menu', 'understrap-child' ),
    'footer'  => __( 'Footer Menu',  'understrap-child' ),
        'social'  => __( 'Social Menu',  'understrap-child' ),

  ] );
} );

/**
 * ----------------------------------------------------------------------------
 * 7) Editor support: alignments, block‑styles, responsive embeds, etc.
 * ----------------------------------------------------------------------------
 */
add_action( 'after_setup_theme', 'understrap_child_editor_support' );
function understrap_child_editor_support() {
    add_theme_support( 'align-wide' );
    add_theme_support( 'wp-block-styles' );
    add_theme_support( 'responsive-embeds' );
    // We already hooked editor-styles above (see #2)
    add_theme_support( 'disable-layout-styles' );
}



/**
 * ----------------------------------------------------------------------------
 * 9) Default to Bootstrap 5 (override parent default).
 * ----------------------------------------------------------------------------
 */
add_filter( 'theme_mod_understrap_bootstrap_version', 'understrap_child_default_bootstrap_version', 20 );
function understrap_child_default_bootstrap_version() {
    return 'bootstrap5';
}


/**
 * ----------------------------------------------------------------------------
 * 10) Customizer scripts for live preview (if present).
 * ----------------------------------------------------------------------------
 */
if ( file_exists( get_stylesheet_directory() . '/js/customizer-controls.js' ) ) {
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
}

