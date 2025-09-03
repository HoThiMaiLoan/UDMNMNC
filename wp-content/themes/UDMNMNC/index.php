<?php get_header(); ?>

<main>
    <?php if(have_posts()): while(have_posts()): the_post(); ?>
        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        <div><?php the_excerpt(); ?></div>
    <?php endwhile; else: ?>
        <p>Không có bài viết nào.</p>
    <?php endif; ?>
</main>

<?php get_footer(); ?>