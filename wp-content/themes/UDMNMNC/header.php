<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<header class="site-header">
  <div class="wrap">
    <div class="site-branding">
      <?php
      if ( function_exists('the_custom_logo') && has_custom_logo() ) {
        the_custom_logo();
      } else {
        echo '<a class="site-title" href="'.esc_url(home_url('/')).'">'.esc_html(get_bloginfo('name')).'</a>';
      }
      ?>
    </div>
    <nav class="site-nav">
      <?php wp_nav_menu(array('theme_location'=>'primary','container'=>false)); ?>
    </nav>
  </div>
</header>
<main class="site-main wrap">