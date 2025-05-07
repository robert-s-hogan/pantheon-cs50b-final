<?php
/** Header with collapse menu & bottom actions */
defined( 'ABSPATH' ) || exit;
?>
<header class="navbar navbar-expand-lg px-4 py-3">
  <div class="container d-flex align-items-center justify-content-between">

    <!-- Left: Brand -->
    <div class="navbar__brand d-flex align-items-center gap-2">
      <img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/images/brand-logo.jpg' ); ?>"
           alt="<?php bloginfo( 'name' ); ?>" width="48" height="48">
      <span class="site-title"><?php bloginfo( 'name' ); ?></span>
    </div>

    <!-- Toggler (visible only <lg) -->
    <button class="navbar-toggler" type="button"
            data-bs-toggle="collapse"
            data-bs-target="#primaryMenuCollapse"
            aria-controls="primaryMenuCollapse"
            aria-expanded="false"
            aria-label="<?php esc_attr_e( 'Toggle navigation', 'understrap-child' ); ?>">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Collapse: links + actions -->
    <div class="collapse navbar-collapse flex-column" id="primaryMenuCollapse">
      <!-- Menu -->
      <nav class="navbar__links w-100 text-center">
        <?php
        wp_nav_menu( [
          'theme_location' => 'primary',
          'container'      => false,
          'menu_class'     => 'navbar-nav flex-column', // vertical list
          'fallback_cb'    => false,
        ] );
        ?>
      </nav>

      <!-- Mobile-only actions -->
      <div class="navbar__actions w-100 d-flex justify-content-center gap-2 mt-3">
        <a href="/donate" class="btn btn-primary btn-sm">Donate</a>
        <button class="btn btn-outline-light btn-sm">Translate</button>
      </div>
    </div>

    <!-- Desktop-only actions (pull to right) -->
    <div class="desktop-actions d-none d-lg-flex align-items-center gap-2">
      <a href="/donate" class="btn btn-primary btn-sm">Donate</a>
      <button class="btn btn-outline-light btn-sm">Translate</button>
    </div>
  </div>
</header>
