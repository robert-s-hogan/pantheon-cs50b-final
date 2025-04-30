<?php
/**
 * Atom: Heading
 */
extract( wp_parse_args( $args, [
  'level' => 2,
  'text'  => '',
  'class' => '',
] ) );

// Add a default Bootstrap “h{n}” class so it picks up Bootstrap typography:
$bootstrap_class = 'h' . intval( $level );
$classes         = trim( $bootstrap_class . ' ' . $class );

printf(
  '<h%d class="%s">%s</h%d>',
  $level,
  esc_attr( $classes ),
  esc_html( $text ),
  $level
);
