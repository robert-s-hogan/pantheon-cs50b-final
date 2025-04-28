<?php
// template-parts/hero.php
$hero_image = get_theme_mod( 'understrap_child_hero_image', get_stylesheet_directory_uri() . '/images/hero.jpg' );
?>
<section class="site-hero py-5 text-center text-white" style="background: url(<?php echo esc_url( $hero_image ); ?>) center/cover no-repeat;">
  <div class="container">
    <h1 class="display-4"><?php echo esc_html( get_theme_mod( 'understrap_child_hero_title', 'Welcome!' ) ); ?></h1>
    <p class="lead"><?php echo esc_html( get_theme_mod( 'understrap_child_hero_subtitle', 'Your tagline here.' ) ); ?></p>
  </div>
</section>
