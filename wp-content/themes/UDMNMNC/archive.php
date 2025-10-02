<?php get_header(); ?>

<section class="container">
  <h1><?php the_archive_title(); ?></h1>
  <div class="blog-grid">
    <?php if(have_posts()): while(have_posts()): the_post(); ?>
      <article class="card">
        <?php if(has_post_thumbnail()) the_post_thumbnail('udmnmnc-thumb'); ?>
        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
        <div class="meta"><?php the_time(get_option('date_format')); ?></div>
      </article>
    <?php endwhile; endif; wp_pagenavi ? wp_pagenavi() : the_posts_pagination(); ?>
  </div>
</section>

<?php get_footer(); ?>