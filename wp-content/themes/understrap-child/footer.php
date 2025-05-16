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
          
          <?php 
            // If you no longer need it, you can remove this call entirely:
            // understrap_site_info(); 
            // Or move it somewhere else, e.g. above your menu:
          ?>

          <nav class="footer-navigation" aria-label="Footer Menu">
            <?php
              wp_nav_menu( [
                'theme_location' => 'footer',
                'container'      => false,
                'menu_class'     => 'footer-menu-list',
                'fallback_cb'    => false,
              ] );
            ?>
          </nav>

        </footer>
      </div>
    </div>
  </div>
</div>
<?php wp_footer(); ?>
</body>
</html>
