<?php get_header(); ?>
<section class="container">
  <?php if (have_posts()): while (have_posts()): the_post(); ?>
    <article class="post-section">
      <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
      <?php if (has_post_thumbnail()): the_post_thumbnail('large'); endif; ?>
      <div class="excerpt"><?php the_excerpt(); ?></div>
    </article>
  <?php endwhile; the_posts_pagination(); else: ?>
    <p>Không có bài viết.</p>
  <?php endif; ?>
</section>
<?php get_footer(); ?>