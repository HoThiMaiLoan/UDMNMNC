<?php 
/*
Plugin Name: UNMNMNC Contact Info
Description: Lưu & hiển thị thông tin liên hệ (shortcode [unmnmnc_contact_info])
Version: 1.0
Author: UNMNMNC
Text Domain: unmnmnc-contact-info
Domain Path: /languages
*/

if ( ! defined( 'ABSPATH' ) ) exit;

// Load textdomain
function unmnmnc_contact_info_load_textdomain() {
    load_plugin_textdomain('unmnmnc-contact-info', false, dirname(plugin_basename(__FILE__)) . '/languages');
}
add_action('plugins_loaded','unmnmnc_contact_info_load_textdomain');

// add settings page
add_action('admin_menu', function(){
    add_options_page(
        __('Thông tin Liên Hệ','unmnmnc-contact-info'),
        __('Thông tin Liên Hệ','unmnmnc-contact-info'),
        'manage_options',
        'unmnmnc-contact-info',
        'unmnmnc_contact_info_page'
    );
});

add_action('admin_init', function(){
    register_setting('unmnmnc_contact_info_group','unmnmnc_contact_email');
    register_setting('unmnmnc_contact_info_group','unmnmnc_contact_address');
    register_setting('unmnmnc_contact_info_group','unmnmnc_contact_phone');
    register_setting('unmnmnc_contact_info_group','unmnmnc_contact_map');

    add_settings_section(
        'unmnmnc_contact_info_section',
        __('Thông tin liên hệ','unmnmnc-contact-info'),
        null,
        'unmnmnc-contact-info'
    );

    add_settings_field('unmnmnc_contact_email', __('Email','unmnmnc-contact-info'), 'unmnmnc_contact_email_cb', 'unmnmnc-contact-info', 'unmnmnc_contact_info_section');
    add_settings_field('unmnmnc_contact_address', __('Địa chỉ','unmnmnc-contact-info'), 'unmnmnc_contact_address_cb', 'unmnmnc-contact-info', 'unmnmnc_contact_info_section');
    add_settings_field('unmnmnc_contact_phone', __('Số điện thoại','unmnmnc-contact-info'), 'unmnmnc_contact_phone_cb', 'unmnmnc-contact-info', 'unmnmnc_contact_info_section');
    add_settings_field('unmnmnc_contact_map', __('Google Map iframe src','unmnmnc-contact-info'), 'unmnmnc_contact_map_cb', 'unmnmnc-contact-info', 'unmnmnc_contact_info_section');
});

function unmnmnc_contact_info_page(){
    ?>
    <div class="wrap">
      <h1><?php _e('Thông tin Liên Hệ','unmnmnc-contact-info'); ?></h1>
      <form method="post" action="options.php">
        <?php settings_fields('unmnmnc_contact_info_group'); do_settings_sections('unmnmnc-contact-info'); submit_button(); ?>
      </form>
    </div>
    <?php
}
function unmnmnc_contact_email_cb(){
    echo '<input type="email" name="unmnmnc_contact_email" value="'.esc_attr(get_option('unmnmnc_contact_email')).'" class="regular-text">';
}
function unmnmnc_contact_address_cb(){
    echo '<input type="text" name="unmnmnc_contact_address" value="'.esc_attr(get_option('unmnmnc_contact_address')).'" class="regular-text">';
}
function unmnmnc_contact_phone_cb(){
    echo '<input type="text" name="unmnmnc_contact_phone" value="'.esc_attr(get_option('unmnmnc_contact_phone')).'" class="regular-text">';
}
function unmnmnc_contact_map_cb(){
    echo '<textarea name="unmnmnc_contact_map" rows="3" class="large-text">'.esc_textarea(get_option('unmnmnc_contact_map')).'</textarea>';
}

// shortcode to show
function unmnmnc_contact_info_shortcode(){
    ob_start();
    ?>
    <div class="unmnmnc-contact-info">
      <p><strong><?php _e('Email','unmnmnc-contact-info'); ?>:</strong> <?php echo esc_html(get_option('unmnmnc_contact_email','example@domain.com')); ?></p>
      <p><strong><?php _e('Địa chỉ','unmnmnc-contact-info'); ?>:</strong> <?php echo esc_html(get_option('unmnmnc_contact_address','')); ?></p>
      <p><strong><?php _e('Điện thoại','unmnmnc-contact-info'); ?>:</strong> <?php echo esc_html(get_option('unmnmnc_contact_phone','')); ?></p>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('unmnmnc_contact_info','unmnmnc_contact_info_shortcode');
