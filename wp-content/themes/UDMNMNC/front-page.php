<?php
get_header();
?>
<section class="hero">
  <?php echo do_shortcode('[unmnmnc_slider posts="6"]'); ?>
</section>

<section class="latest-posts">
  <h2><?php esc_html_e('Latest Posts','unmnmnc'); ?></h2>
  <div class="grid">
    <?php
    $q = new WP_Query(array('post_type'=>'post','posts_per_page'=>3));
    if($q->have_posts()){
      while($q->have_posts()){ $q->the_post();
        ?>
        <article class="card">
          <a href="<?php the_permalink(); ?>">
            <?php if(has_post_thumbnail()) the_post_thumbnail('unmnmnc-thumb'); ?>
            <h3><?php the_title(); ?></h3>
            <p><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
          </a>
        </article>
        <?php
      }
      wp_reset_postdata();
    } else {
      echo '<p>'.esc_html__('No posts found.','unmnmnc').'</p>';
    }
    ?>
  </div>
</section>

<section class="latest-projects">
  <h2><?php esc_html_e('Featured Projects','unmnmnc'); ?></h2>
  <div class="grid">
    <?php
    $q = new WP_Query(array('post_type'=>'project','posts_per_page'=>3));
    if($q->have_posts()){
      while($q->have_posts()){ $q->the_post(); ?>
        <article class="card">
          <a href="<?php the_permalink(); ?>">
            <?php if(has_post_thumbnail()) the_post_thumbnail('unmnmnc-thumb'); ?>
            <h3><?php the_title(); ?></h3>
            <p><?php echo esc_html(get_post_meta(get_the_ID(),'unmnmnc_project_subtitle', true)); ?></p>
          </a>
        </article>
      <?php }
      wp_reset_postdata();
    } else {
      echo '<p>'.esc_html__('No projects yet.','unmnmnc').'</p>';
    }
    ?>
  </div>
</section>

<?php
get_footer();