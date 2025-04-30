<?php
/**
 * Understrap Child Theme functions and definitions
 *
 * @package UnderstrapChild
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
require get_stylesheet_directory() . '/inc/block-patterns.php';


add_action( 'wp_enqueue_scripts', 'understrap_remove_scripts', 20 );
function understrap_remove_scripts() {
  wp_dequeue_style(  'understrap-styles' );
  wp_deregister_style( 'understrap-styles' );
  wp_dequeue_script( 'understrap-scripts' );
  wp_deregister_script( 'understrap-scripts' );
}

add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
  $the_theme     = wp_get_theme();
  $suffix        = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
  $style_path    = "/css/child-theme{$suffix}.css";
  $script_path   = "/js/child-theme{$suffix}.js";

  wp_enqueue_style( 'child-understrap-styles',
    get_stylesheet_directory_uri() . $style_path,
    [], // no dependencies
    $the_theme->get( 'Version' )
  );

  wp_enqueue_script( 'jquery' );
  wp_enqueue_script( 'child-understrap-scripts',
    get_stylesheet_directory_uri() . $script_path,
    [], // no deps beyond jquery
    $the_theme->get( 'Version' ),
    true
  );

  if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
    wp_enqueue_script( 'comment-reply' );
  }
}

add_action( 'after_setup_theme', 'add_child_theme_textdomain' );
function add_child_theme_textdomain() {
  load_child_theme_textdomain( 'understrap-child',
    get_stylesheet_directory() . '/languages' );
}

add_filter( 'theme_mod_understrap_bootstrap_version',
  'understrap_default_bootstrap_version', 20 );
function understrap_default_bootstrap_version() {
  return 'bootstrap5';
}

add_action( 'customize_controls_enqueue_scripts',
  'understrap_child_customize_controls_js' );
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
    $wp_customize, 'understrap_child_hero_image', [
      'label'   => __( 'Hero Background', 'understrap-child' ),
      'section' => 'hero_section',
  ] ) );

  $wp_customize->add_setting( 'understrap_child_hero_title',
    [ 'default' => 'Welcome!' ] );
  $wp_customize->add_control( 'understrap_child_hero_title', [
    'label'   => __( 'Hero Title', 'understrap-child' ),
    'section' => 'hero_section',
  ] );
}

/**
 * 1) Register “Heading” dynamic block so Gutenberg uses our atom.
 */
function understrap_child_register_heading_block() {
  // Bail if the WP block API isn’t available yet.
  if ( ! function_exists( 'register_block_type' ) ) {
    return;
  }

  register_block_type( 'understrap-child/heading', [
    // ← make it show up in the inserter:
    'title'          => __( 'Bootstrap Heading', 'understrap-child' ),
    'category'       => 'text',           // puts it alongside other text blocks
    'icon'           => 'editor-heading', // the H-icon you’re used to
    'attributes'     => [
      'level'     => [ 'type' => 'number', 'default' => 2 ],
      'text'      => [ 'type' => 'string', 'default' => '' ],
      'className' => [ 'type' => 'string', 'default' => '' ],
    ],
    'render_callback'=> function( $attrs ) {
      get_template_part(
        'template-parts/atoms/heading',
        null,
        [
          'level' => $attrs['level'],
          'text'  => $attrs['text'],
          'class' => $attrs['className'],
        ]
      );
    },
  ] );
  
}
add_action( 'init', 'understrap_child_register_heading_block' );
