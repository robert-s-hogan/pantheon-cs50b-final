<?php
/**
 * Template Name: Mix & Match Events
 */
get_header();
?>

<div class="container my-5">
  <h1><?php the_title(); ?></h1>

  <section class="events-calendar mb-5">
    <?php echo do_shortcode('[tribe_events view="month"]'); ?>
  </section>

  <section class="events-list">
    <h2>Upcoming Events</h2>
    <?php echo do_shortcode('[tribe_events view="list" limit="5"]'); ?>
  </section>
</div>

<?php get_footer(); ?>
