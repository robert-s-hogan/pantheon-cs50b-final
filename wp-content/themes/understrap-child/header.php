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

<div class="site" id="page">

  <!-- Skip link for screen readers -->
  <a class="skip-link <?php echo esc_attr( understrap_get_screen_reader_class( true ) ); ?>"
     href="#content">
    <?php esc_html_e( 'Skip to content', 'understrap-child' ); ?>
  </a>

  <!-- ******************* The Navbar Area / Custom Header ******************* -->
  <header class="navbar px-4 py-3">
  <div class="navbar__brand">
    <img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/images/brand-logo.jpg' ); ?>"
         alt="<?php bloginfo( 'name' ); ?>">
    <span class="site-title"><?php bloginfo( 'name' ); ?></span>
  </div>

  <!-- Bootstrap 5 navbar with wp_nav_menu pulling in your “Primary Menu” -->
  <nav class="navbar navbar-expand-lg flex-grow-1">
    <button class="navbar-toggler" type="button"
            data-bs-toggle="collapse"
            data-bs-target="#siteNav"
            aria-controls="siteNav"
            aria-expanded="false"
            aria-label="<?php esc_attr_e( 'Toggle navigation', 'understrap-child' ); ?>">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="siteNav">
      <?php
      wp_nav_menu([
        'theme_location' => 'primary',
        'container'      => false,
        'menu_class'     => 'navbar-nav d-flex gap-4',
        'fallback_cb'    => false,
        'depth'          => 2,
        'walker'         => class_exists( 'Understrap\Bootstrap_5_Navwalker' )
                           ? new Understrap\Bootstrap_5_Navwalker()
                           : null,
      ]);
      ?>
    </div>
  </nav>

  <div class="navbar__actions">
    <a href="/donate" class="btn btn-primary btn-sm">Donate</a>
    <button class="btn btn-outline-light btn-sm">Translate</button>
  </div>
</header>




<!-- NOTE: we do NOT close #page here — that lives in footer.php -->
