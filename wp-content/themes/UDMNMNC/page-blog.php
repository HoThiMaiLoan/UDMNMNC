<?php
/* Template Name: Blog */
get_header(); ?>

<div class="udmnmnc-blog-container">

  <!-- Lời chào -->
  <div class="udmnmnc-blog-intro">
    <h2><?php echo get_theme_mod('udmnmnc_blog_intro_text', _e('🌼 Hãy để hương hoa xoa dịu tâm hồn bạn.', 'unmnmnc')); ?></h2>
  </div>

  <!-- Slider ảnh tròn -->
  <div class="udmnmnc-blog-slider">
    <?php
    $q = new WP_Query(array('post_type' => 'post', 'posts_per_page' => -1));
    if ($q->have_posts()):
      while ($q->have_posts()): $q->the_post(); ?>
        <div class="udmnmnc-blog-item">
          <a href="<?php the_permalink(); ?>">
            <?php if (has_post_thumbnail()) {
              the_post_thumbnail('udmnmnc-circle-thumb', array('class' => 'udmnmnc-blog-thumb'));
            } ?>
          </a>
        </div>
      <?php endwhile;
      wp_reset_postdata();
    endif; ?>
  </div>

  <!-- Danh sách bài viết -->
  <div class="udmnmnc-blog-grid">
    <?php
    $paged = max(1, get_query_var('paged'));
    $main = new WP_Query(array(
      'post_type' => 'post',
      'posts_per_page' => 8,
      'paged' => $paged
    ));
    if ($main->have_posts()):
      while ($main->have_posts()): $main->the_post(); ?>
        <article class="udmnmnc-blog-card">
          <a href="<?php the_permalink(); ?>">
            <?php if (has_post_thumbnail()) {
              the_post_thumbnail('medium');
            } ?>
          </a>
          <h3 class="udmnmnc-blog-title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
          </h3>
          <div class="udmnmnc-blog-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 20); ?></div>
          <div class="udmnmnc-blog-meta">
            <span><?php the_author(); ?></span> | 
            <span><?php echo get_the_date(); ?></span>
          </div>
        </article>
      <?php endwhile; ?>

      <!-- Phân trang -->
      <div class="udmnmnc-pagination">
        <?php echo paginate_links(array(
          'total' => $main->max_num_pages,
          'current' => $paged
        )); ?>
      </div>

      <?php wp_reset_postdata();
    endif; ?>
  </div>

</div>

<?php get_footer(); ?>
