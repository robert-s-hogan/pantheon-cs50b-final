<?php
/**
 * template-parts/organisms/hero.php
 *
 * Expects $background, $title, $buttonText.
 */

// Defaults:
$background = $background ?? '';
$title      = $title      ?? '';
$buttonText = $buttonText ?? '';
?>
<div class="wp-block-cover alignfull has-background-dim"
     style="background-image:url(<?php echo esc_url( $background ); ?>)">
  <div class="wp-block-cover__inner-container text-white text-center">
    <?php
    echo \UnderstrapChild\Atomic\render_template( 'atoms/heading', [
      'level' => 1,
      'text'  => $title,
      'class' => 'h1 text-white',
    ] );
    ?>
    <div class="wp-block-buttons" style="justify-content:center;">
      <div class="wp-block-button">
        <a class="wp-block-button__link btn btn-primary text-white">
          <?php echo esc_html( $buttonText ); ?>
        </a>
      </div>
    </div>
  </div>
</div>
