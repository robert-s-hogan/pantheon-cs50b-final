<?php
/**
 * template-parts/organisms/hero.php
 *
 * Expects attributes in the $args array.
 */

// Use wp_parse_args for defaults and sanitization
$args = wp_parse_args( $args ?? [], [ // Assuming $args is passed, maybe by render_template or get_template_part
    'background' => '',
    'title'      => '',
    'buttonText' => '',
] );

// Access attributes directly from the array
$background = $args['background'];
$title      = $args['title'];
$buttonText = $args['buttonText'];

// Alternatively, you could extract here if you prefer the variable syntax below
// extract($args); // Uncomment this if you want to use $background, $title etc below

?>
<div class="wp-block-cover alignfull has-background-dim"
     style="background-image:url(<?php echo esc_url( $background ); ?>)"> <!-- or $args['background'] -->
  <div class="wp-block-cover__inner-container text-white text-center">
    <?php
    echo \UnderstrapChild\Atomic\render_template( 'atoms/heading', [
      'level' => 1,
      'text'  => $title, // or $args['title']
      'class' => 'h1 text-white',
    ] );
    ?>
    <div class="wp-block-buttons" style="justify-content:center;">
      <div class="wp-block-button">
        <a class="wp-block-button__link btn btn-primary text-white">
          <?php echo esc_html( $buttonText ); ?> <!-- or $args['buttonText'] -->
        </a>
      </div>
    </div>
  </div>
</div>