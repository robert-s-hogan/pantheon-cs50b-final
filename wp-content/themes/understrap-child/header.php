<?php
/** Header with collapse menu & bottom actions */
defined( 'ABSPATH' ) || exit;
?>
<header class="site-header">
  <div class="container d-flex align-items-center justify-content-between">

    <!-- Left: Brand -->
    <div class="navbar__brand d-flex align-items-center gap-2">
    <div class="site-branding">
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

    <!-- Middle: Bootstrap navbar, toggler + collapse -->
<nav class="navbar navbar-expand-lg px-0">
  <button class="navbar-toggler" type="button"
          data-bs-toggle="collapse"
          data-bs-target="#primaryMenuCollapse"
          aria-controls="primaryMenuCollapse"
          aria-expanded="false"
          aria-label="<?php esc_attr_e( 'Toggle navigation', 'understrap-child' ); ?>">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="primaryMenuCollapse">
    <?php
    wp_nav_menu( [
      'theme_location' => 'primary',
      'container'      => false,
      'menu_class'     => 'navbar-nav list-unstyled mx-auto',
      'fallback_cb'    => false,
    ] );
    ?>

    <!-- mobile-only actions -->
    <div class="navbar__actions d-flex d-lg-none justify-content-center gap-2 mt-3 w-100">
      <a href="/donate"   class="btn btn-primary btn-sm">Donate</a>
      <button            class="btn btn-outline-light btn-sm">Translate</button>
    </div>
  </div>
</nav>

    <!-- Desktop-only actions (pull to right) -->
     <div class="d-none d-lg-flex desktop-actions align-items-center gap-2">
      <a href="/donate" class="btn btn-primary btn-sm">Donate</a>
      <button class="btn btn-outline-light btn-sm">Translate</button>
    </div>
  </div>
</header>
