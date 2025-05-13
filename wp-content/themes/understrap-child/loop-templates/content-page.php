<?php
/**
 * Partial template for page content (child theme override)
 *
 * @package UnderstrapChild
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

  <?php if ( has_post_thumbnail() ) : ?>
  <div class="page-header-image">
    <?php echo get_the_post_thumbnail( get_the_ID(), 'large' ); ?>
  </div>
  <?php endif; ?>

  <header class="page-header-title">
    <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
  </header>

  <div class="entry-content">
    <?php
      the_content();
      understrap_link_pages();
    ?>
  </div><!-- .entry-content -->

  <footer class="entry-footer">
    <?php understrap_edit_post_link(); ?>
  </footer><!-- .entry-footer -->

</article><!-- #post-<?php the_ID(); ?> -->
