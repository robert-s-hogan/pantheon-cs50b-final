<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <?php wp_head();              // ← this is what injects style.css, bootstrap.js, etc. ?>
</head>

<body <?php body_class(); ?>>
<?php do_action( 'wp_body_open' ); ?>

<header class="site-header navbar navbar-expand-lg navbar-dark">
  <div class="container">
    <!-- ↳ your nav markup goes here, DO NOT delete anything above this line -->
    <div class="site-branding">
      <img src="<?php echo get_stylesheet_directory_uri() . '/images/brand-logo.jpg'; ?>"
           alt="<?php bloginfo( 'name' ); ?>">
      <span class="site-title"><?php bloginfo( 'name' ); ?></span>
    </div>

    <button class="navbar-toggler" type="button"
            data-bs-toggle="collapse"
            data-bs-target="#primaryMenuCollapse"
            aria-controls="primaryMenuCollapse"
            aria-expanded="false"
            aria-label="<?php esc_attr_e( 'Toggle navigation', 'your-text-domain' ); ?>">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="primaryMenuCollapse">
      <?php
        wp_nav_menu( [
          'theme_location' => 'primary',
          'container'      => false,
          'menu_class'     => 'navbar-nav',
          'fallback_cb'    => false,
        ] );
      ?>
      <div class="actions-mobile">
        <a href="/donate" class="btn btn-primary btn-sm">Donate</a>
        <button class="btn btn-outline-light btn-sm">Translate</button>
      </div>
    </div>

    <div class="actions-desktop">
      <a href="/donate" class="btn btn-primary btn-sm">Donate</a>
      <button class="btn btn-outline-light btn-sm">Translate</button>
    </div>
    <!-- ↳ DO NOT delete anything below this line -->
  </div>
</header>
