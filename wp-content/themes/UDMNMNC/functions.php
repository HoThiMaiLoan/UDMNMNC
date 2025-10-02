<?php
remove_action('wp_head', 'wp_generator');
add_filter('wp_lazy_loading_enabled', '__return_true');

if ( ! defined('ABSPATH') ) exit;

// Constants
if ( ! defined('UNMNMNC_DIR') ) define('UNMNMNC_DIR', get_template_directory());
if ( ! defined('UNMNMNC_URI') ) define('UNMNMNC_URI', get_template_directory_uri());

// Khai báo textdomain cho theme
function unmnmnc_load_textdomain() {
    load_theme_textdomain('unmnmnc', get_template_directory() . '/languages');
}
add_action('after_setup_theme', 'unmnmnc_load_textdomain');

// Theme setup
function unmnmnc_setup() {
    load_theme_textdomain('unmnmnc', UNMNMNC_DIR . '/languages');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo');
    add_theme_support('html5', array('search-form','comment-form','gallery','caption'));
    register_nav_menus(array(
        'primary_vi' => __('Primary Menu Vietnamese', 'unmnmnc'),
        'primary_en' => __('Primary Menu English', 'unmnmnc'),
    ));
}
add_action('after_setup_theme','unmnmnc_setup');

// Enqueue styles & scripts
function unmnmnc_enqueue_assets() {
    // style.css required by WP (keeps theme visible)
    wp_enqueue_style('unmnmnc-style', get_stylesheet_uri(), array(), filemtime(UNMNMNC_DIR . '/style.css'));

    // main CSS
    $main_css = UNMNMNC_DIR . '/assets/css/main.css';
    if ( file_exists($main_css) ) {
        wp_enqueue_style('unmnmnc', UNMNMNC_URI . '/assets/css/main.css', array('unmnmnc-style'), filemtime($main_css));
    }

    // main JS
    $main_js = UNMNMNC_DIR . '/assets/js/main.js';
    if ( file_exists($main_js) ) {
        wp_enqueue_script('unmnmnc', UNMNMNC_URI . '/assets/js/main.js', array(), filemtime($main_js), true);
        wp_localize_script('unmnmnc', 'unmnmnc_vars', array('ajax_url' => admin_url('admin-ajax.php')));
    }
}
// ===========================================
// Enqueue CSS & JS
// ===========================================
function udmnmnc_enqueue_scripts() {
    // CSS
    wp_enqueue_style(
        'udmnmnc-main', 
        get_template_directory_uri() . '/assets/css/main.css',
        array(),
        '1.0'
    );

    // JS
    wp_enqueue_script(
        'udmnmnc-main', 
        get_template_directory_uri() . '/assets/js/main.js',
        array('jquery'),
        '1.0',
        true
    );
}
add_action('wp_enqueue_scripts', 'udmnmnc_enqueue_scripts');


// ===========================================
// Customizer Settings
// ===========================================
function udmnmnc_customize_register($wp_customize) {
    // Section
    $wp_customize->add_section('udmnmnc_slider_section', array(
        'title'    => __('Slider Trang Chủ', 'udmnmnc'),
        'priority' => 30,
    ));

    // Title
    $wp_customize->add_setting('slider_title', array(
        'default'           => __('Tiêu đề slider', 'udmnmnc'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('slider_title', array(
        'label'   => __('Tiêu đề Slider', 'udmnmnc'),
        'section' => 'udmnmnc_slider_section',
        'type'    => 'text',
    ));

    // Description
    $wp_customize->add_setting('slider_desc', array(
        'default'           => __('Mô tả slider', 'udmnmnc'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('slider_desc', array(
        'label'   => __('Mô tả Slider', 'udmnmnc'),
        'section' => 'udmnmnc_slider_section',
        'type'    => 'textarea',
    ));

    // Slide Images
    for ($i = 1; $i <= 3; $i++) {
        $wp_customize->add_setting("slide_{$i}_image", array(
            'sanitize_callback' => 'esc_url_raw',
        ));
        $wp_customize->add_control(
            new WP_Customize_Image_Control(
                $wp_customize,
                "slide_{$i}_image",
                array(
                    'label'   => __("Ảnh Slide {$i}", 'udmnmnc'),
                    'section' => 'udmnmnc_slider_section',
                    'settings'=> "slide_{$i}_image",
                )
            )
        );
    }
}
add_action('customize_register', 'udmnmnc_customize_register');

add_filter( 'jpeg_quality', function() {
    return 100;
});
// ===========================================
// Customizer: Blog Settings
// ===========================================

// Hỗ trợ ảnh đại diện
add_theme_support('post-thumbnails');
add_image_size('circle-thumb', 200, 200, true);

// Giới hạn excerpt (mô tả)
function custom_excerpt_length($length) {
  return 15;
}
add_filter('excerpt_length', 'custom_excerpt_length');

// Thêm Customizer cho lời chào Blog
// 1) Theme supports (safe: check before add)
if ( ! function_exists('udmnmnc_theme_setup') ) {
  function udmnmnc_theme_setup() {
    add_theme_support('post-thumbnails');
    add_image_size('udmnmnc-circle-thumb', 200, 200, true);
  }
  add_action('after_setup_theme', 'udmnmnc_theme_setup');
}

// 2) Excerpt length
if ( ! function_exists('udmnmnc_excerpt_length') ) {
  function udmnmnc_excerpt_length($length) {
    return 15;
  }
  add_filter('excerpt_length', 'udmnmnc_excerpt_length', 999);
}

// 3) Customizer: Lời chào Blog
if ( ! function_exists('udmnmnc_customizer_settings') ) {
  function udmnmnc_customizer_settings($wp_customize) {
    $wp_customize->add_section('udmnmnc_blog_section', array(
      'title' => __('Cài đặt Blog', 'udmnmnc'),
      'priority' => 30,
    ));

    $wp_customize->add_setting('udmnmnc_blog_intro_text', array(
      'default' => __('Chào mừng bạn đến với Blog!', 'udmnmnc'),
      'sanitize_callback' => 'sanitize_text_field',
      'transport' => 'refresh',
    ));

    $wp_customize->add_control('udmnmnc_blog_intro_text', array(
      'label' => __('Lời chào trang Blog', 'udmnmnc'),
      'section' => 'udmnmnc_blog_section',
      'settings' => 'udmnmnc_blog_intro_text',
      'type' => 'text',
    ));
  }
  add_action('customize_register', 'udmnmnc_customizer_settings');
}

// 4) Enqueue: slick + main.css + main.js
if ( ! function_exists('udmnmnc_enqueue_assets') ) {
  function udmnmnc_enqueue_assets() {
    // Slick CSS (load first so main.css can override)
    wp_enqueue_style('slick-css', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css', array(), '1.8.1');

    // Your main CSS (replace path if your main.css is elsewhere)
    wp_enqueue_style('udmnmnc-main', get_template_directory_uri() . '/assets/css/main.css', array('slick-css'), wp_get_theme()->get('Version'));

    // Slick JS
    wp_enqueue_script('slick-js', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', array('jquery'), '1.8.1', true);

    // Your main JS - ensure it depends on slick-js so init runs
    wp_enqueue_script('udmnmnc-main-js', get_template_directory_uri() . '/assets/js/main.js', array('jquery','slick-js'), wp_get_theme()->get('Version'), true);
  }
  add_action('wp_enqueue_scripts', 'udmnmnc_enqueue_assets');
}

// === Footer Customizer ===
function yeuhoa_footer_customizer($wp_customize) {
    $wp_customize->add_section('yeuhoa_footer_section', array(
        'title'    => 'Footer',
        'priority' => 160,
    ));

    // About
    $wp_customize->add_setting('yeuhoa_footer_about', array(
        'default' => 'Website chia sẻ tình yêu hoa và thiên nhiên.',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('yeuhoa_footer_about', array(
        'label' => 'Giới thiệu ngắn',
        'section' => 'yeuhoa_footer_section',
        'type' => 'textarea',
    ));

    // Address
    $wp_customize->add_setting('yeuhoa_footer_address', array(
        'default' => '123 Hoa Sen, Hà Nội',
    ));
    $wp_customize->add_control('yeuhoa_footer_address', array(
        'label' => 'Địa chỉ',
        'section' => 'yeuhoa_footer_section',
        'type' => 'text',
    ));

    // Phone
    $wp_customize->add_setting('yeuhoa_footer_phone', array(
        'default' => '0123 456 789',
    ));
    $wp_customize->add_control('yeuhoa_footer_phone', array(
        'label' => 'Số điện thoại',
        'section' => 'yeuhoa_footer_section',
        'type' => 'text',
    ));

    // Email
    $wp_customize->add_setting('yeuhoa_footer_email', array(
        'default' => 'info@yeuhoa.com',
    ));
    $wp_customize->add_control('yeuhoa_footer_email', array(
        'label' => 'Email',
        'section' => 'yeuhoa_footer_section',
        'type' => 'text',
    ));

    // Facebook
    $wp_customize->add_setting('yeuhoa_footer_facebook', array(
        'default' => '#',
    ));
    $wp_customize->add_control('yeuhoa_footer_facebook', array(
        'label' => 'Link Facebook',
        'section' => 'yeuhoa_footer_section',
        'type' => 'url',
    ));

    // Instagram
    $wp_customize->add_setting('yeuhoa_footer_instagram', array(
        'default' => '#',
    ));
    $wp_customize->add_control('yeuhoa_footer_instagram', array(
        'label' => 'Link Instagram',
        'section' => 'yeuhoa_footer_section',
        'type' => 'url',
    ));

    // YouTube
    $wp_customize->add_setting('yeuhoa_footer_youtube', array(
        'default' => '#',
    ));
    $wp_customize->add_control('yeuhoa_footer_youtube', array(
        'label' => 'Link YouTube',
        'section' => 'yeuhoa_footer_section',
        'type' => 'url',
    ));
}
add_action('customize_register', 'yeuhoa_footer_customizer');

