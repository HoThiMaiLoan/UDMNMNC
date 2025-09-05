<?php
/*
Template Name: Contact
*/
get_header();
?>
<section class="contact-page">
  <h1><?php the_title(); ?></h1>
  <div class="contact-wrapper">
    <?php echo do_shortcode('[unmnmnc_contact_form]'); ?>
  </div>
</section>
<?php get_footer(); ?>