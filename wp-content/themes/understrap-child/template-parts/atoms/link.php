<?php
/**
 * Atom: Link
 * Usage:
 *   get_template_part('template-parts/atoms/link', null, [
 *     'url'   => '#',
 *     'text'  => 'Click me',
 *     'class' => 'text-decoration-none'
 *   ]);
 */
extract( wp_parse_args( $args, [
  'url'   => '#',
  'text'  => '',
  'class' => '',
  'attrs' => [],
] ) );
$attr_str = '';
foreach ( $attrs as $k => $v ) {
  $attr_str .= sprintf( ' %s="%s"', esc_attr($k), esc_attr($v) );
}
printf(
  '<a href="%s" class="%s"%s>%s</a>',
  esc_url( $url ),
  esc_attr( $class ),
  $attr_str,
  esc_html( $text )
);
