<?php get_header(); ?>
<article class="container post-section">
  <?php if (have_posts()): while (have_posts()): the_post(); ?>
    <h1><?php the_title(); ?></h1>
    <div class="meta"><?php the_time(get_option('date_format')); ?></div>
    <?php if (has_post_thumbnail()) the_post_thumbnail('large'); ?>
    <div><?php the_content(); ?></div>
  <?php endwhile; endif; ?>
</article>
<?php get_footer(); ?>