<?php 
/*
Plugin Name: UNMNMNC Contact Form
Description: Form liên hệ, lưu vào DB và gửi email. Shortcode: [unmnmnc_contact_form]
Version: 1.1
Author: UNMNMNC
Text Domain: unmnmnc-contact-form
Domain Path: /languages
*/

if ( ! defined( 'ABSPATH' ) ) exit;

// -------------------- Load translations --------------------
function unmnmnc_cf_load_textdomain() {
    load_plugin_textdomain( 'unmnmnc-contact-form', false, dirname( plugin_basename(__FILE__) ) . '/languages' );
}
add_action( 'plugins_loaded', 'unmnmnc_cf_load_textdomain' );

// -------------------- Create DB table on activation --------------------
register_activation_hook( __FILE__, 'unmnmnc_cf_create_table' );
function unmnmnc_cf_create_table() {
    global $wpdb;
    $table = $wpdb->prefix . 'unmnmnc_contacts';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS $table (
      id BIGINT(20) NOT NULL AUTO_INCREMENT,
      name VARCHAR(250) NOT NULL,
      email VARCHAR(120) NOT NULL,
      phone VARCHAR(60) NULL,
      message TEXT NOT NULL,
      created DATETIME NOT NULL,
      PRIMARY KEY  (id)
    ) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
}

// -------------------- Shortcode: show form & process submission --------------------
function unmnmnc_cf_shortcode( $atts ) {
    $output = '';

    if ( isset( $_POST['unmnmnc_cf_submit'] ) ) {
        if ( ! isset( $_POST['unmnmnc_cf_nonce'] ) || ! wp_verify_nonce( $_POST['unmnmnc_cf_nonce'], 'unmnmnc_cf_action' ) ) {
            $output .= '<div class="unmnmnc-cf-error">'.__('Nội dung không hợp lệ (nonce).', 'unmnmnc-contact-form').'</div>';
        } else {
            $name    = sanitize_text_field( $_POST['unmnmnc_cf_name'] ?? '' );
            $email   = sanitize_email( $_POST['unmnmnc_cf_email'] ?? '' );
            $phone   = sanitize_text_field( $_POST['unmnmnc_cf_phone'] ?? '' );
            $message = sanitize_textarea_field( $_POST['unmnmnc_cf_message'] ?? '' );

            if ( empty($name) || empty($email) || empty($message) ) {
                $output .= '<div class="unmnmnc-cf-error">'.__('Vui lòng điền đủ các trường bắt buộc.', 'unmnmnc-contact-form').'</div>';
            } else {
                global $wpdb;
                $table = $wpdb->prefix . 'unmnmnc_contacts';
                $now   = current_time('mysql');

                $inserted = $wpdb->insert(
                    $table,
                    array(
                        'name'    => $name,
                        'email'   => $email,
                        'phone'   => $phone,
                        'message' => $message,
                        'created' => $now
                    ),
                    array('%s','%s','%s','%s','%s')
                );

                // send email to admin
                $to      = get_option('admin_email');
                $subject = sprintf( __('[Liên hệ] %s', 'unmnmnc-contact-form'), $name );
                $body    = '<p>'.__('Bạn có liên hệ mới từ website:', 'unmnmnc-contact-form').'</p>';
                $body   .= '<p><strong>'.__('Tên:', 'unmnmnc-contact-form').'</strong> ' . esc_html($name) . '</p>';
                $body   .= '<p><strong>Email:</strong> ' . esc_html($email) . '</p>';
                if ( $phone ) $body .= '<p><strong>'.__('Điện thoại:', 'unmnmnc-contact-form').'</strong> ' . esc_html($phone) . '</p>';
                $body   .= '<p><strong>'.__('Nội dung:', 'unmnmnc-contact-form').'</strong><br>' . nl2br(esc_html($message)) . '</p>';
                $headers = array('Content-Type: text/html; charset=UTF-8', 'Reply-To: ' . $name . ' <' . $email . '>');

                $sent = wp_mail( $to, $subject, $body, $headers );

                if ( $inserted ) {
                    $output .= '<div class="unmnmnc-cf-success">'.__('Cảm ơn bạn! Chúng tôi đã nhận được tin nhắn.', 'unmnmnc-contact-form').'</div>';
                } else {
                    $output .= '<div class="unmnmnc-cf-error">'.__('Lưu thông tin thất bại. Vui lòng thử lại.', 'unmnmnc-contact-form').'</div>';
                }
            }
        }
    }

    // show form
    $output .= '<form class="unmnmnc-contact-form" method="post">';
    $output .= wp_nonce_field('unmnmnc_cf_action', 'unmnmnc_cf_nonce', true, false);
    $output .= '<p><label>'.__('Họ tên *', 'unmnmnc-contact-form').'</label><br><input type="text" name="unmnmnc_cf_name" required></p>';
    $output .= '<p><label>'.__('Email *', 'unmnmnc-contact-form').'</label><br><input type="email" name="unmnmnc_cf_email" required></p>';
    $output .= '<p><label>'.__('Số điện thoại', 'unmnmnc-contact-form').'</label><br><input type="text" name="unmnmnc_cf_phone"></p>';
    $output .= '<p><label>'.__('Nội dung *', 'unmnmnc-contact-form').'</label><br><textarea name="unmnmnc_cf_message" rows="6" required></textarea></p>';
    $output .= '<p><button type="submit" name="unmnmnc_cf_submit">'.__('Gửi', 'unmnmnc-contact-form').'</button></p>';
    $output .= '</form>';

    return $output;
}
add_shortcode( 'unmnmnc_contact_form', 'unmnmnc_cf_shortcode' );

// -------------------- Enqueue plugin css --------------------
function unmnmnc_cf_enqueue_assets() {
    wp_register_style( 'unmnmnc-cf-style', plugin_dir_url(__FILE__) . 'assets/css/style.css' );
    wp_enqueue_style( 'unmnmnc-cf-style' );
}
add_action( 'wp_enqueue_scripts', 'unmnmnc_cf_enqueue_assets' );

// -------------------- Admin menu --------------------
add_action( 'admin_menu', 'unmnmnc_cf_admin_menu' );
function unmnmnc_cf_admin_menu() {
    add_menu_page(
        __('Messages', 'unmnmnc-contact-form'),
        __('Liên Hệ (UNMNMNC)', 'unmnmnc-contact-form'),
        'manage_options',
        'unmnmnc-contacts',
        'unmnmnc_cf_admin_page',
        'dashicons-email',
        26
    );
}

function unmnmnc_cf_admin_page() {
    if ( ! current_user_can('manage_options') ) wp_die(__('Bạn không có quyền truy cập.', 'unmnmnc-contact-form'));

    global $wpdb;
    $table = $wpdb->prefix . 'unmnmnc_contacts';

    // delete
    if ( isset($_GET['delete']) && isset($_GET['_wpnonce']) ) {
        if ( wp_verify_nonce( $_GET['_wpnonce'], 'unmnmnc_delete_message' ) ) {
            $id = intval( $_GET['delete'] );
            $wpdb->delete( $table, array('id'=>$id), array('%d') );
            echo '<div class="updated"><p>'.__('Đã xoá.', 'unmnmnc-contact-form').'</p></div>';
        }
    }

    // pagination
    $paged = max(1, intval( $_GET['paged'] ?? 1 ));
    $per_page = 20;
    $offset = ($paged - 1) * $per_page;

    $total = $wpdb->get_var( "SELECT COUNT(*) FROM $table" );
    $messages = $wpdb->get_results( $wpdb->prepare(
        "SELECT * FROM $table ORDER BY created DESC LIMIT %d OFFSET %d",
        $per_page, $offset
    ) );

    echo '<div class="wrap"><h1>'.__('Liên hệ từ website', 'unmnmnc-contact-form').'</h1>';
    echo '<table class="widefat fixed striped"><thead><tr>';
    echo '<th>ID</th><th>'.__('Tên', 'unmnmnc-contact-form').'</th><th>Email</th><th>'.__('Điện thoại', 'unmnmnc-contact-form').'</th><th>'.__('Nội dung', 'unmnmnc-contact-form').'</th><th>'.__('Thời gian', 'unmnmnc-contact-form').'</th><th>'.__('Hành động', 'unmnmnc-contact-form').'</th>';
    echo '</tr></thead><tbody>';

    if ( $messages ) {
        foreach ( $messages as $m ) {
            $del_url = wp_nonce_url(
                add_query_arg( array('delete'=>$m->id, 'paged'=>$paged), menu_page_url('unmnmnc-contacts', false) ),
                'unmnmnc_delete_message'
            );
            echo '<tr>';
            echo '<td>' . esc_html($m->id) . '</td>';
            echo '<td>' . esc_html($m->name) . '</td>';
            echo '<td>' . esc_html($m->email) . '</td>';
            echo '<td>' . esc_html($m->phone) . '</td>';
            echo '<td>' . esc_html( wp_trim_words($m->message, 25) ) . '</td>';
            echo '<td>' . esc_html($m->created) . '</td>';
            echo '<td><a href="'.esc_url($del_url).'" onclick="return confirm(\''.__('Bạn có chắc xóa?', 'unmnmnc-contact-form').'\')">'.__('Xóa', 'unmnmnc-contact-form').'</a></td>';
            echo '</tr>';
        }
    } else {
        echo '<tr><td colspan="7">'.__('Chưa có liên hệ.', 'unmnmnc-contact-form').'</td></tr>';
    }
    echo '</tbody></table>';

    // pagination
    $pages = ceil( $total / $per_page );
    if ( $pages > 1 ) {
        echo '<div style="margin-top:15px">';
        for ( $i=1; $i <= $pages; $i++ ) {
            $link = add_query_arg( array('paged'=>$i), menu_page_url('unmnmnc-contacts', false) );
            echo '<a style="margin-right:6px" href="'.esc_url($link).'">'.esc_html($i).'</a>';
        }
        echo '</div>';
    }

    echo '</div>';
}
