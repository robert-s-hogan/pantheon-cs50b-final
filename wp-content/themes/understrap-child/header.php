<?php
/** Header with collapse menu & bottom actions */
defined( 'ABSPATH' ) || exit;
?>
<header class="site-header">
  <div class="container">
    <!-- Left: Logo + Site Name -->
    <div class="site-branding">
      <img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/images/brand-logo.jpg' ); ?>"
           alt="<?php bloginfo( 'name' ); ?>">
      <span class="site-title"><?php bloginfo( 'name' ); ?></span>
    </div>

    <!-- Toggler (mobile) -->
    <button class="navbar-toggler" type="button"
            data-bs-toggle="collapse"
            data-bs-target="#primaryMenuCollapse"
            aria-controls="primaryMenuCollapse"
            aria-expanded="false"
            aria-label="<?php esc_attr_e( 'Toggle navigation', 'your-text-domain' ); ?>">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Collapsible menu + mobile actions -->
    <div class="collapse navbar-collapse" id="primaryMenuCollapse">
      <?php
        wp_nav_menu([
          'theme_location' => 'primary',
          'container'      => false,
          'menu_class'     => 'navbar-nav',
          'fallback_cb'    => false,
        ]);
      ?>

      <div class="actions-mobile">
        <a href="/donate" class="btn btn-primary btn-sm">Donate</a>
        <button class="btn btn-outline-light btn-sm">Translate</button>
      </div>
    </div>

    <!-- Desktop actions -->
    <div class="actions-desktop">
      <a href="/donate" class="btn btn-primary btn-sm">Donate</a>
      <button class="btn btn-outline-light btn-sm">Translate</button>
    </div>
  </div>
</header>
