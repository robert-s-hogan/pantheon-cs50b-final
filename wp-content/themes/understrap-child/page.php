

<?php
/**
 * Child Theme Page Template
 * This will ensure every Page loads the header and footer.
 */
get_header();  

// wrapper (match parent theme’s markup)
?>
<div class="wrapper" id="page-wrapper">
    <?php
    // Standard Loop: pull in your content-page.php
    while ( have_posts() ) :
      the_post();
      get_template_part( 'loop-templates/content', 'page' );
    endwhile;
    ?>
</div><!-- #page-wrapper -->

<?php
get_footer(); 
