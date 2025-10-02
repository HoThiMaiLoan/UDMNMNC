<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<header class="site-header">
  <div class="container header-container">
    <!-- Logo -->
    <div class="logo">
      <a href="<?php echo esc_url(home_url('/')); ?>">
        <?php bloginfo('name'); ?>
      </a>
    </div>

    <!-- Menu desktop -->
    <nav class="main-menu desktop-menu">
      <?php
        if (function_exists('pll_current_language')) {
    $lang = pll_current_language();

    if ($lang == 'vi') {
        wp_nav_menu(array(
            'theme_location' => 'primary_vi',
            'container'      => false,
            'menu_class'     => 'main-menu',
        ));
    } else {
        wp_nav_menu(array(
            'theme_location' => 'primary_en',
            'container'      => false,
            'menu_class'     => 'main-menu',
        ));
    }
}
      ?>
    </nav>

    <!-- Nút mở menu mobile -->
    <button class="menu-toggle" aria-label="Open Menu">
      ☰
    </button>
  </div>

  <!-- Menu mobile -->
  <div class="mobile-menu-overlay"></div>
  <nav class="mobile-menu">
    <button class="menu-close" aria-label="Close Menu">×</button>
    <?php
      if (function_exists('pll_current_language')) {
    $lang = pll_current_language();

    if ($lang == 'vi') {
        wp_nav_menu(array(
            'theme_location' => 'primary_vi',
            'container'      => false,
            'menu_class'     => 'main-menu',
        ));
    } else {
        wp_nav_menu(array(
            'theme_location' => 'primary_en',
            'container'      => false,
            'menu_class'     => 'main-menu',
        ));
    }
}
    ?>
  </nav>
</header>