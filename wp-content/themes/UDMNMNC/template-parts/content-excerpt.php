<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  <a href="<?php the_permalink(); ?>">
    <?php if(has_post_thumbnail()) the_post_thumbnail('unmnmnc-thumb'); ?>
    <h3><?php the_title(); ?></h3>
    <div class="entry-summary"><?php the_excerpt(); ?></div>
  </a>
</article>