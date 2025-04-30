<?php
/**
 * Atom: Paragraph
 * Usage:
 *   get_template_part('template-parts/atoms/paragraph', null, [
 *     'text'  => 'Some descriptive copy…',
 *     'class' => 'lead'
 *   ]);
 */
extract( wp_parse_args( $args, [
  'text'  => '',
  'class' => '',
] ) );
printf(
  '<p class="%s">%s</p>',
  esc_attr( $class ),
  esc_html( $text )
);
