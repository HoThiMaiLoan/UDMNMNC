<?php
/*
Template Name: Blog
*/
get_header();
?>
<section class="blog-list">
  <h1><?php the_title(); ?></h1>
  <?php
  $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
  $q = new WP_Query(array('post_type'=>'post','paged'=>$paged));
  if($q->have_posts()){
    while($q->have_posts()){ $q->the_post();
      get_template_part('template-parts/content','excerpt');
    }
    // pagination
    echo '<div class="pagination">';
    echo paginate_links(array('total'=>$q->max_num_pages));
    echo '</div>';
    wp_reset_postdata();
  } else {
    echo '<p>'.esc_html__('No posts found.','unmnmnc').'</p>';
  }
  ?>
</section>
<?php get_footer(); ?>