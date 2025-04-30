<?php
/**
 * Atom: Button
 * Usage:
 *   get_template_part('template-parts/atoms/button', null, [
 *     'text'  => 'Get Involved',
 *     'url'   => '#get-involved',
 *     'variant' => 'primary',   // maps to btn-primary, btn-outline-secondary, etc.
 *     'size'    => 'lg',        // btn-sm, btn-lg or empty
 *     'class'   => '',
 *   ]);
 */
extract( wp_parse_args( $args, [
  'text'    => '',
  'url'     => '#',
  'variant' => 'primary',
  'size'    => '',
  'class'   => '',
] ) );
$classes = trim( "btn btn-{$variant} " . ( $size ? "btn-{$size}" : '' ) . " {$class}" );
printf(
  '<a href="%s" class="%s">%s</a>',
  esc_url( $url ),
  esc_attr( $classes ),
  esc_html( $text )
);
