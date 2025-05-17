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
<nav class="navbar navbar-expand-lg bg-primary">
  <div class="container d-flex justify-content-between align-items-center">
    <?php the_custom_logo(); ?>
    <a class="navbar-brand text-white ms-2" href="<?php echo home_url(); ?>">
      <?php bloginfo( 'name' ); ?>
    </a>
    <button class="navbar-toggler border-0" type="button"
            data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false"
            aria-label="<?php esc_attr_e('Toggle navigation','understrap-child'); ?>">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <?php
        wp_nav_menu( [
          'theme_location' => 'primary',
          'menu_class'     => 'navbar-nav',
          'container'      => false,
          'depth'          => 2,
          'link_before'    => '<span class="nav-link-text">',
          'link_after'     => '</span>',
        ] );
      ?>
    </div>
  </div>
</nav>

<?php endif; ?>
