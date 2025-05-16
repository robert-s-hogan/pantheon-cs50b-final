<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$container = get_theme_mod( 'understrap_container_type' );
?>

<?php get_template_part( 'sidebar-templates/sidebar', 'footerfull' ); ?>


<div class="wrapper" id="wrapper-footer">
  <div class="<?php echo esc_attr( $container ); ?>">
    <div class="row">
      <div class="col-md-12">
<footer class="site-footer" id="colophon">
  <div class="<?php echo esc_attr( $container ); ?> footer-flex-container">

    <!-- LEFT COLUMN -->
    <div class="footer-left">

      <?php if ( function_exists('the_custom_logo') && has_custom_logo() ) : ?>
        <div class="site-logo">
          <?php the_custom_logo(); ?>
        </div>
      <?php endif; ?>

      <div class="logo-address">
        <address class="footer-address">
          Douglas Whited Elementary<br>
          4995 Sonoma Hwy, Santa Rosa, CA 95409 | (707) XXX-XXXX
        </address>
      </div>

      <?php
      // Social menu: just add a menu in WP Admin → Menus → Manage Locations → Social Menu
      wp_nav_menu([
        'theme_location' => 'social',
        'container'      => false,
        'menu_class'     => 'social-menu',
        'fallback_cb'    => false,
      ]);
      ?>

    </div>

    <!-- RIGHT COLUMN (footer links) -->
    <nav class="footer-right" aria-label="Footer Menu">
      <?php
      wp_nav_menu([
        'theme_location' => 'footer',
        'container'      => false,
        'menu_class'     => 'footer-menu-list',
        'fallback_cb'    => false,
      ]);
      ?>
    </nav>

  </div>
</footer>


      </div>
    </div>
  </div>
</div>
<?php wp_footer(); ?>
</body>
</html>
