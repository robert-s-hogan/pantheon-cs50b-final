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

    <!-- LEFT COLUMN: flex-col -->
    <div class="footer-left">
      <?php if ( function_exists('the_custom_logo') && has_custom_logo() ) : ?>
        <div class="site-logo"><?php the_custom_logo(); ?></div>
      <?php endif; ?>

      <address class="footer-address">
        Douglas Whited Elementary<br>
        4995 Sonoma Hwy, Santa Rosa, CA 95409 | (707) XXX-XXXX
      </address>

      <?php if ( has_nav_menu('social') ) : ?>
        <nav class="social-menu-container" aria-label="Social Links">
          <?php
           wp_nav_menu([
  'theme_location' => 'social',
  'container'      => false,
  'menu_class'     => 'social-menu',
  'fallback_cb'    => false,
  // wrap each link in an <i> plus a hidden label:
  'link_before'   => '<i class="fab fa-facebook-f" aria-hidden="true"></i><span class="sr-only">',
  'link_after'    => '</span>',
]);

          ?>
        </nav>
      <?php endif; ?>
    </div>

    <!-- RIGHT COLUMN: horizontal list -->
    <?php if ( has_nav_menu('footer') ) : ?>
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
    <?php endif; ?>

  </div>
</footer>



      </div>
    </div>
  </div>
</div>
<?php wp_footer(); ?>
</body>
</html>
