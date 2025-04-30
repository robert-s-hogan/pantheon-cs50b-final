<?php
/**
 * Atom: Image
 * Usage:
 *   get_template_part('template-parts/atoms/image', null, [
 *     'src'   => $url,
 *     'alt'   => '…',
 *     'class' => 'img-fluid rounded'
 *   ]);
 */
extract( wp_parse_args( $args, [
  'src'   => '',
  'alt'   => '',
  'class' => '',
] ) );
printf(
  '<img src="%s" alt="%s" class="%s"/>',
  esc_url( $src ),
  esc_attr( $alt ),
  esc_attr( $class )
);
