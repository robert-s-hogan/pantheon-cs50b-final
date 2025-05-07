<?php
/**
 * Child Theme Header (UnderStrap + custom block)
 *
 * @package UnderstrapChild
 */
defined( 'ABSPATH' ) || exit;

// If you ever need to branch on BS version:
$bootstrap_version = get_theme_mod( 'understrap_bootstrap_version', 'bootstrap5' );
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="profile" href="http://gmpg.org/xfn/11">
  <?php wp_head(); // ← this injects Bootstrap CSS & your compiled style.css ?>
</head>

<body <?php body_class(); ?> <?php understrap_body_attributes(); ?>>
<?php do_action( 'wp_body_open' ); ?>

<div class="site" id="page">

  <!-- Skip link for screen readers -->
  <a class="skip-link <?php echo esc_attr( understrap_get_screen_reader_class( true ) ); ?>"
     href="#content">
    <?php esc_html_e( 'Skip to content', 'understrap-child' ); ?>
  </a>

  <!-- ******************* The Navbar Area ******************* -->
  <header id="wrapper-navbar" role="navigation" aria-label="<?php esc_attr_e( 'Primary', 'understrap-child' ); ?>">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary py-3">
      <div class="container d-flex align-items-center justify-content-between">

        <!-- Logo + Site Title -->
        <a class="navbar-brand d-flex align-items-center gap-2" href="<?php echo home_url(); ?>">
          <img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/images/brand-logo.jpg' ); ?>"
               alt="<?php bloginfo( 'name' ); ?>" width="48" height="48">
          <span class="fw-bold mb-0"><?php bloginfo( 'name' ); ?></span>
        </a>

        <!-- Mobile Toggle -->
        <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse"
                data-bs-target="#siteNav"
                aria-controls="siteNav"
                aria-expanded="false"
                aria-label="<?php esc_attr_e( 'Toggle navigation', 'understrap-child' ); ?>">
          <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Collapsed Menu + Actions -->
        <div class="collapse navbar-collapse" id="siteNav">
          <?php
            wp_nav_menu( [
              'theme_location' => 'primary',
              'container'      => false,
              'menu_class'     => 'navbar-nav me-auto mb-2 mb-lg-0',
              'fallback_cb'    => false,
              'depth'          => 2,
              'walker'         => class_exists( 'Understrap\Bootstrap_5_Navwalker' )
                                 ? new Understrap\Bootstrap_5_Navwalker()
                                 : new Walker_Nav_Menu(),
            ] );
          ?>

          <!-- Mobile‑only buttons -->
          <div class="d-lg-none mt-3 actions-mobile">
            <a href="/donate" class="btn btn-primary btn-sm me-2">Donate</a>
            <button class="btn btn-outline-light btn-sm">Translate</button>
          </div>

          <!-- Desktop‑only buttons -->
          <div class="d-none d-lg-flex gap-2 actions-desktop">
            <a href="/donate" class="btn btn-primary btn-sm">Donate</a>
            <button class="btn btn-outline-light btn-sm">Translate</button>
          </div>
        </div><!-- /.navbar-collapse -->

      </div><!-- /.container -->
    </nav>
  </header><!-- /#wrapper-navbar -->
