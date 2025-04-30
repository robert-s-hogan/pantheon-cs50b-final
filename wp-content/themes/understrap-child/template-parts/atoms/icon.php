<?php
/**
 * Atom: Icon (Bootstrap Icons SVG wrapper)
 * Usage:
 *   get_template_part('template-parts/atoms/icon', null, [
 *     'name'  => 'facebook',
 *     'class' => 'me-2'
 *   ]);
 */
extract( wp_parse_args( $args, [
  'name'  => '',
  'class' => '',
] ) );
printf(
  '<i class="bi bi-%s %s" aria-hidden="true"></i>',
  esc_attr( $name ),
  esc_attr( $class )
);
