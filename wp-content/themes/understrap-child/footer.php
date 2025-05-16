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
  <div class="<?php echo esc_attr($container); ?> footer-flex-container">

    <!-- LEFT SIDE: logo + address, then social icons -->
    <div class="footer-left">
      <div class="logo-address">
        <a href="<?php echo home_url(); ?>">
          <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/whited-logo.svg"
               alt="Douglas Whited PTO logo" class="footer-logo">
        </a>
        <address class="footer-address">
          Douglas Whited Elementary&nbsp;&nbsp;|&nbsp;&nbsp;
          4995 Sonoma Hwy, Santa Rosa, CA 95409&nbsp;&nbsp;|&nbsp;&nbsp;
          (707) XXX-XXXX
        </address>
      </div>
      <div class="footer-social">
        <!-- you can hard-code your links, or if you have a social menu: -->
        <?php
        wp_nav_menu([
          'theme_location' => 'social',
          'container'      => false,
          'menu_class'     => 'social-menu',
          'fallback_cb'    => false,
        ]);
        ?>
      </div>
    </div>

    <!-- RIGHT SIDE: footer menu links -->
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
