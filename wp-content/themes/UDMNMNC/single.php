<?php get_header(); ?>

<?php
if(have_posts()){
  while(have_posts()){ the_post(); ?>
    <article <?php post_class(); ?>>
      <h1><?php the_title(); ?></h1>
      <div class="entry-meta"><?php echo get_the_date(); ?></div>

      <?php if(has_post_thumbnail()){ ?>
        <div class="post-thumbnail"><?php the_post_thumbnail('unmnmnc-thumb'); ?></div>
      <?php } ?>

      <div class="entry-content">
        <?php the_content(); ?>
      </div>

      <?php
      // if project CPT, show gallery meta
      if(get_post_type() === 'project'){
        $gallery = get_post_meta(get_the_ID(),'unmnmnc_project_gallery', true);
        if(!empty($gallery)){
          $ids = array_filter(explode(',',$gallery));
          echo '<div class="project-gallery">';
          foreach($ids as $id){
            $src = wp_get_attachment_image_url($id, 'large');
            if($src) echo '<img src="'.esc_url($src).'" alt="" loading="lazy">';
          }
          echo '</div>';
        }
      }
      ?>
    </article>
  <?php }
}
?>

<?php get_footer(); ?>