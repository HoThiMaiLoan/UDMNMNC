<?php get_header(); ?>
<section class="container post-section" style="text-align:center;">
  <h1>404 — Không tìm thấy</h1>
  <p>Trang bạn tìm không tồn tại.</p>
  <?php get_search_form(); ?>
  <p><a href="<?php echo esc_url(home_url('/')); ?>">Về trang chủ</a></p>
</section>
<?php get_footer(); ?>