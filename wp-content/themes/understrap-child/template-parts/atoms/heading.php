<?php
/**
 * Atom: Heading
 * Usage: 
 *   get_template_part('template-parts/atoms/heading', null, [
 *     'level' => 2,
 *     'text'  => 'Your Title Here',
 *     'class' => 'my-custom-class'
 *   ]);
 */
extract( wp_parse_args( $args, [
  'level' => 1,
  'text'  => '',
  'class' => '',
] ) );
printf(
  '<h%d class="%s">%s</h%d>',
  esc_attr( $level ),
  esc_attr( $class ),
  esc_html( $text ),
  esc_attr( $level )
);
