<?php get_header(); ?>

<section class="loop">
  <?php
  if(have_posts()){
    while(have_posts()){ the_post(); ?>
      <article <?php post_class(); ?>>
        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        <div class="excerpt"><?php the_excerpt(); ?></div>
      </article>
    <?php }
  } else {
    echo '<p>'.esc_html__('Nothing found.','unmnmnc').'</p>';
  }
  ?>
</section>

<?php get_footer(); ?>