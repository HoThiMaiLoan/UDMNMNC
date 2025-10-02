<?php
/* Front Page Template */
get_header();

$slider_title    = get_theme_mod('slider_title', __('Tiêu đề slider', 'unmnmnc'));
$slider_desc     = get_theme_mod('slider_desc', __('Mô tả slider', 'unmnmnc'));
$slider_cta_text = get_theme_mod('slider_cta_text', __('Xem Thêm', 'unmnmnc'));
$slider_cta_link = get_theme_mod('slider_cta_link', '#');

?>

<section class="hero-slider">
  <div class="slider-wrapper">
    <?php for ($i = 1; $i <= 3; $i++):
      $img = get_theme_mod("slide_{$i}_image");
      if ($img): ?>
        <div class="slide">
          <img src="<?php echo esc_url($img); ?>" alt="slide-<?php echo $i; ?>">
        </div>
    <?php endif; endfor; ?>
  </div>

  <!-- Overlay chung (1 title + 1 desc + 1 nút) -->
  <div class="slider-overlay" aria-hidden="<?php echo empty($slider_title) && empty($slider_desc) ? 'true' : 'false'; ?>">
    <?php if ($slider_title): ?>
      <h2 class="slider-title"><?php echo esc_html($slider_title); ?></h2>
    <?php endif; ?>
    <?php if ($slider_desc): ?>
      <p class="slider-desc"><?php echo esc_html($slider_desc); ?></p>
    <?php endif; ?>
    <?php if ($slider_cta_text && $slider_cta_link): ?>
      <a class="btn-slide" href="<?php echo esc_url($slider_cta_link); ?>">
        <?php echo esc_html($slider_cta_text); ?>
      </a>
    <?php endif; ?>
</div>

<!-- nút điều hướng -->
<button class="nav-btn prev" aria-label="<?php echo esc_attr__('Previous slide', 'unmnmnc'); ?>">&#10094;</button>
<button class="nav-btn next" aria-label="<?php echo esc_attr__('Next slide', 'unmnmnc'); ?>">&#10095;</button>

<div class="dots" role="tablist"></div>

</section>

<!-- ========== NỘI DUNG TRANG CHỦ ========== -->
<div class="home-content">
  
  <!-- Sidebar -->
  <aside class="sidebar">
    <h2><?php _e('Danh mục', 'unmnmnc'); ?></h2>
    <ul>
      <?php wp_list_categories(array(
        'title_li' => ''
      )); ?>
    </ul>
  </aside>

  <!-- Main content -->
  <main class="main-content">

    <!-- Bài viết nổi bật -->
    <section class="featured-posts">
      <h2><?php _e('Bài viết nổi bật', 'unmnmnc'); ?></h2>
      <div class="featured-list">
        <?php
        $paged_featured = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $featured = new WP_Query(array(
          'posts_per_page' => 3,
          'paged'          => $paged_featured,
          'meta_key'       => 'featured',
          'meta_value'     => '1'
        ));
        if ($featured->have_posts()):
          while ($featured->have_posts()): $featured->the_post(); ?>
            <article class="featured-card">
              <div class="img-wrap">
                <?php if (has_post_thumbnail()): ?>
                  <a href="<?php the_permalink(); ?>">
                    <?php the_post_thumbnail('medium'); ?>
                    <div class="overlay"></div>
                  </a>
                <?php endif; ?>
              </div>
              <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
              <p><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
              <a href="<?php the_permalink(); ?>" class="btn"><?php _e('Xem Thêm', 'unmnmnc'); ?></a>
            </article>
          <?php endwhile; ?>
      </div>
      <!-- Phân trang nổi bật -->
      <div class="pagination">
        <?php
          echo paginate_links(array(
            'total' => $featured->max_num_pages
          ));
        ?>
      </div>
      <?php wp_reset_postdata(); else: ?>
        <p><?php _e('Chưa có bài viết nổi bật.', 'unmnmnc'); ?></p>
      <?php endif; ?>
    </section>

    <!-- Bài viết mới nhất -->
    <section class="latest-posts">
      <h2><?php _e('Bài viết mới nhất', 'unmnmnc'); ?></h2>
      <div class="latest-list">
        <?php
        $paged_latest = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $latest = new WP_Query(array(
          'posts_per_page' => 6,
          'paged'          => $paged_latest
        ));
        if ($latest->have_posts()):
          while ($latest->have_posts()): $latest->the_post(); ?>
            <article class="latest-card">
              <div class="img-wrap">
                <?php if (has_post_thumbnail()): ?>
                  <a href="<?php the_permalink(); ?>">
                    <?php the_post_thumbnail('medium'); ?>
                    <div class="overlay"></div>
                  </a>
                <?php endif; ?>
              </div>
              <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
              <a href="<?php the_permalink(); ?>" class="btn"><?php _e('Xem Thêm', 'unmnmnc'); ?></a>
            </article>
          <?php endwhile; ?>
      </div>
      <!-- Phân trang mới nhất -->
      <div class="pagination">
        <?php
          echo paginate_links(array(
            'total' => $latest->max_num_pages
          ));
        ?>
      </div>
      <?php wp_reset_postdata(); else: ?>
        <p><?php _e('Chưa có bài viết mới.', 'unmnmnc'); ?></p>
      <?php endif; ?>
    </section>

  </main>
</div>


<?php get_footer(); ?>
