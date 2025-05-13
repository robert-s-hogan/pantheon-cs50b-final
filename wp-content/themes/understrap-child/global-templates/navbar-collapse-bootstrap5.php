<?php
/**
 * Header Navbar (bootstrap5)
 *
 * @package Understrap
 * @since 1.1.0
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$container = get_theme_mod( 'understrap_container_type' );
?>

<?php if ( has_nav_menu( 'primary' ) ) : ?>
  <nav id="main-nav" class="navbar navbar-expand-md navbar-dark bg-primary">
    <div class="<?php echo esc_attr( get_theme_mod('understrap_container_type') ); ?>">
      <?php get_template_part('global-templates/navbar-branding'); ?>
      <button class="navbar-toggler" …></button>
      <?php
        wp_nav_menu([
          'theme_location'  => 'primary',
          'container'       => false,
          'menu_class'      => 'navbar-nav ms-auto',
          'fallback_cb'     => false,
          'depth'           => 2,
          'walker'          => new Understrap_WP_Bootstrap_Navwalker(),
        ]);
      ?>
    </div>
  </nav>
<?php endif; ?>
