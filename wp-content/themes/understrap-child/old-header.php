<?php
/**
 * Child Theme Header (UnderStrap + custom block)
 *
 * This file includes the <head> section, the opening <body> tag,
 * the wp_body_open hook, and the start of the main site structure,
 * including the header/navbar area.
 *
 * The closing </body> and </html> tags are in footer.php.
 *
 * @package UnderstrapChild
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Get the Bootstrap version setting from the parent theme or default to Bootstrap 5.
$bootstrap_version = get_theme_mod( 'understrap_bootstrap_version', 'bootstrap5' );

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="profile" href="http://gmpg.org/xfn/11">
  <?php
  // This is the crucial WordPress function that outputs enqueued styles,
  // scripts, and other things added to the head.
  wp_head();
  ?>
</head>

<body <?php body_class(); ?> <?php understrap_body_attributes(); ?>>
<?php
// This hook is used by some plugins and WordPress itself (e.g., admin bar).
do_action( 'wp_body_open' );
?>

<!-- Site container, opened here and closed in footer.php -->
<div class="site" id="page">

  <!-- Skip link for screen readers, goes directly to the main content area -->
  <a class="skip-link <?php echo esc_attr( understrap_get_screen_reader_class( true ) ); ?>"
     href="#content">
    <?php esc_html_e( 'Skip to content', 'understrap-child' ); ?>
  </a>

  <!-- ******************* The Navbar Area / Custom Header ******************* -->
  <!-- This uses Bootstrap and custom classes for styling -->
  <header id="wrapper-navbar" class="wp-block-group alignfull site-header py-3">

    <div class="container d-flex align-items-center justify-content-between">

      <!-- Site Branding: Logo + Site Title -->
      <div class="d-flex align-items-center gap-3 site-branding">
        <figure class="eagle-logo mb-0">
          <?php
          // Output the site logo image
          // Using get_stylesheet_directory_uri() ensures this points to the child theme's directory
          ?>
          <img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/images/brand-logo.jpg' ); ?>"
               alt="<?php bloginfo( 'name' ); ?>">
        </figure>
        <div class="site-title">
          <?php
          // Output the site title/name
          // Assuming your SASS gives .site-title strong typography
          ?>
          <p class="mb-0 fw-bold"><?php bloginfo( 'name' ); ?></p>
        </div>
      </div>

      <!-- Mobile Navbar Toggler Button (Bootstrap) -->
      <button class="navbar-toggler collapsed" type="button"
              data-bs-toggle="collapse"
              data-bs-target="#siteNav"
              aria-controls="siteNav"
              aria-expanded="false"
              aria-label="<?php esc_attr_e( 'Toggle navigation', 'understrap-child' ); ?>">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Primary Navigation Menu (Bootstrap collapse) -->
      <div class="collapse navbar-collapse" id="siteNav">
        <?php
        // Output the main navigation menu
        wp_nav_menu( [
          'theme_location' => 'primary', // This must match the 'primary' handle registered in functions.php
          'container'      => false, // No wrapper div for the menu
          'menu_class'     => 'navbar-nav', // Use Bootstrap's navbar-nav class
          'fallback_cb'    => false, // Don't show default WordPress menu if 'primary' location isn't assigned a menu
          'depth'          => 2, // How many levels of menu items to include
          // Use the custom Bootstrap 5 Navwalker class if it exists, otherwise fallback to default Walker_Nav_Menu
          'walker'         => class_exists( 'Understrap\Bootstrap_5_Navwalker' )
                             ? new Understrap\Bootstrap_5_Navwalker()
                             : new Walker_Nav_Menu(),
        ] );
        ?>
        <?php
        // You might add desktop action buttons here
        // e.g., get_template_part('template-parts/components/desktop-actions');
        ?>
      </div><!-- .navbar-collapse -->

      <?php
      // You might add desktop action buttons here, outside the collapse for visibility on larger screens
      // e.g., get_template_part('template-parts/components/desktop-actions');
      ?>

    </div><!-- .container -->

  </header><!-- #wrapper-navbar -->

<!-- NOTE: The main content area (#content or <main>) and the closing #page div
     are typically opened/included after the header in index.php, page.php, single.php etc.
     and closed in footer.php. -->