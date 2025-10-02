<?php
/* Template Name: Trang Liên Hệ */
get_header();
?>

<div class="contact-page-container" style="max-width:1200px;margin:40px auto;padding:0 16px;">
  <h1 class="contact-page-title" style="text-align:center;margin-bottom:30px;"><?php the_title(); ?></h1>

  <div class="contact-columns" style="display:flex;gap:30px;flex-wrap:wrap;">
    <div class="contact-col contact-left" style="flex:1;min-width:300px;">
      <div class="box contact-info-box" style="padding:20px;border-radius:12px;background:#ffecec;">
        <h3><?php _e('Thông tin liên hệ', 'unmnmnc'); ?></h3>
        <?php echo do_shortcode('[unmnmnc_contact_info]'); ?>
      </div>
    </div>

    <div class="contact-col contact-right" style="flex:1;min-width:320px;">
      <div class="box contact-form-box" style="padding:20px;border-radius:12px;background:#fff7f7;">
        <h3><?php _e('Form liên hệ', 'unmnmnc'); ?></h3>
        <?php echo do_shortcode('[unmnmnc_contact_form]'); ?>
      </div>
    </div>
  </div>

  <div class="contact-map" style="margin-top:30px;">
    <div class="box" style="padding:12px;border-radius:12px;background:#fff7f7;">
      <h3 style="text-align:center"><?php _e('Bản đồ', 'unmnmnc'); ?></h3>
      <?php
        $map_src = get_option('udmnmnc_contact_map');
        if ( $map_src ) {
          // if user pasted full iframe code, print it; if they put src only, wrap it
          if ( strpos( $map_src, '<iframe' ) !== false ) {
            echo $map_src;
          } else {
            echo '<iframe src="'.esc_url($map_src).'" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"></iframe>';
          }
        } else {
          echo '<p style="text-align:center;color:#777">Chưa có link bản đồ. Vui lòng config trong Settings → Thông tin Liên Hệ.</p>';
        }
      ?>
    </div>
  </div>
</div>

<?php get_footer(); ?>
