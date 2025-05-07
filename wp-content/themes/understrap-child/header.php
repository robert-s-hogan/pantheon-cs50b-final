<?php
/**
 * Child Theme Header (UnderStrap + custom block)
 *
 * @package UnderstrapChild
 */
defined( 'ABSPATH' ) || exit;

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

<body <?php body_class(); ?> <?php understrap_body_attributes(); ?>>
<?php do_action( 'wp_body_open' ); ?>

<div class="site" id="page"><!-- ← Opened here -->

  <!-- Skip link for screen readers -->
  <a class="skip-link <?php echo esc_attr( understrap_get_screen_reader_class( true ) ); ?>"
     href="#content">
    <?php esc_html_e( 'Skip to content', 'understrap-child' ); ?>
  </a>

  <!-- ******************* The Navbar Area / Custom Header ******************* -->
  <header id="wrapper-navbar" class="wp-block-group alignfull site-header py-3">
  <nav class="navbar navbar-expand-lg">

    <div class="container d-flex align-items-center justify-content-between">

      <!-- Logo + Site Title -->
      <div class="d-flex align-items-center gap-3 site-branding">
        <figure class="eagle-logo mb-0">
          <img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/images/brand-logo.jpg' ); ?>"
               alt="<?php bloginfo( 'name' ); ?>">
        </figure>
        <div class="site-title">
          <p class="mb-0 fw-bold"><?php bloginfo( 'name' ); ?></p>
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

      <!-- Primary Menu -->
      <div class="collapse navbar-collapse" id="siteNav">
        <?php
        wp_nav_menu( [
          'theme_location' => 'primary',
          'container'      => false,
          'menu_class'     => 'navbar-nav',
          'fallback_cb'    => false,
          'depth'          => 2,
          'walker'         => class_exists( 'Understrap\Bootstrap_5_Navwalker' )
                             ? new Understrap\Bootstrap_5_Navwalker()
                             : new Walker_Nav_Menu(),
        ] );
        ?>
      </div>

    </div><!-- .container -->
        </nav>
  </header><!-- #wrapper-navbar -->

<!-- NOTE: we do NOT close #page here — that lives in footer.php -->
