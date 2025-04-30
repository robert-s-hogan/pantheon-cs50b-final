<?php
// inc/atomic.php
namespace UnderstrapChild\Atomic;

/**
 * Render a PHP template from template-parts/
 *
 * @param string $path Path under template-parts/, e.g. 'atoms/heading'
 * @param array  $data Attributes to extract into the template.
 * @return string
 */
function render_template( $path, $data = [] ) {
  $template = get_stylesheet_directory() . "/template-parts/{$path}.php";
  if ( ! file_exists( $template ) ) {
    return '';
  }
  ob_start();
  extract( $data );
  include $template;
  return ob_get_clean();
}
