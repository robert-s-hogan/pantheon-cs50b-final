<?php
/**
 * Atom: Badge
 * Usage:
 *   get_template_part('template-parts/atoms/badge', null, [
 *     'text'  => 'Oct 15, 4–7 PM',
 *     'class' => 'bg-secondary text-white'
 *   ]);
 */
extract( wp_parse_args( $args, [
  'text'  => '',
  'class' => 'bg-secondary text-white'
] ) );
printf(
  '<span class="badge %s">%s</span>',
  esc_attr( $class ),
  esc_html( $text )
);
