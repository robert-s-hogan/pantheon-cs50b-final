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

  <nav class="navbar__links">
    <?php
      // Loop through your menu items (or output with wp_nav_menu and a custom walker)
      foreach ( wp_get_nav_menu_items( 'primary' ) as $item ) : ?>
        <a href="<?php echo esc_url( $item->url ); ?>">
          <?php echo esc_html( $item->title ); ?>
        </a>
    <?php endforeach; ?>
  </nav>

  <div class="navbar__actions">
    <a href="/donate" class="btn btn-primary btn-sm">Donate</a>
    <button class="btn btn-outline-light btn-sm">Translate</button>
  </div>
</header>



<!-- NOTE: we do NOT close #page here — that lives in footer.php -->
