<?php
/**
 * UnderStrap Child Theme Header
 *
 * Displays the <head> section and the opening navbar.
 *
 * @package UnderstrapChild
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// We default to bootstrap5, per your theme_mod override.
$bootstrap_version = get_theme_mod( 'understrap_bootstrap_version', 'bootstrap5' );
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="profile" href="http://gmpg.org/xfn/11">
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php do_action('wp_body_open'); ?>

<!-- ↓ Your new header ↓ -->
<div class="wp-block-group alignfull site-header py-3">
  <div class="container d-flex align-items-center justify-content-between">

    <!-- Logo + Text -->
    <div class="d-flex align-items-center gap-3 site-branding">
      <figure class="eagle-logo">
        <img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/brand-logo.jpg' ); ?>"
             alt="Douglas Whited PTO"/>
      </figure>
      <div class="site-title">
        <p class="mb-0 fw-bold">Douglas Whited PTO</p>
      </div>
    </div>

<!-- Mobile Toggle -->
<button class="navbar-toggler collapsed" type="button"
        data-bs-toggle="collapse"
        data-bs-target="#siteNav"
        aria-controls="siteNav"
        aria-expanded="false"
        aria-label="<?php esc_attr_e( 'Toggle navigation', 'understrap-child' ); ?>">
  <span class="navbar-toggler-icon"></span>
</button>

<!-- Collapsible Menu -->
<div class="collapse navbar-collapse" id="siteNav">
  <?php
  wp_nav_menu([
    'theme_location' => 'primary',
    'container'      => false,
    'menu_class'     => 'navbar-nav',
    'fallback_cb'    => false,
    'depth'          => 2,
    'walker'         => class_exists('Understrap\Bootstrap_5_Navwalker')
                        ? new Understrap\Bootstrap_5_Navwalker()
                        : new Walker_Nav_Menu(),
  ]);
  ?>
</div>

  </div>
</div>
<!-- ↑ End new header ↑ -->


<div class="site" id="page">
  <!-- Skip link for screen readers -->
  <a class="skip-link <?php echo esc_attr( understrap_get_screen_reader_class( true ) ); ?>"
     href="#content">
    <?php esc_html_e( 'Skip to content', 'understrap-child' ); ?>
  </a>
  </div>