<?php
// inc/atomic.php
namespace UnderstrapChild\Atomic;

/**
 * Load a PHP template from template-parts/.
 */
function render_template( $path, $data = [] ) {
  $file = get_stylesheet_directory() . "/template-parts/{$path}.php";
  if ( ! file_exists( $file ) ) {
    return ''; 
  }
  ob_start();
  extract( $data );
  include $file;
  return ob_get_clean();
}
