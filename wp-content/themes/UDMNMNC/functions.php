<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * UNMNMNC - Functions
 */

/* -------------------------
 * Enqueue scripts & styles
 * ------------------------- */
add_action('wp_enqueue_scripts', 'unmnmnc_enqueue_assets');
function unmnmnc_enqueue_assets(){
    wp_enqueue_style('unmnmnc-style', get_stylesheet_uri(), array(), '1.0');
    wp_enqueue_style('unmnmnc-main', get_template_directory_uri() . '/assets/css/main.css', array('unmnmnc-style'), '1.0');
    wp_enqueue_script('unmnmnc-main', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), '1.0', true);

    wp_localize_script('unmnmnc-main', 'unmnmnc_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php')
    ));
}

/* -------------------------
 * Theme supports & menus
 * ------------------------- */
add_action('after_setup_theme', 'unmnmnc_setup');
function unmnmnc_setup(){
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_image_size('unmnmnc-thumb', 800, 600, true);
    add_theme_support('custom-logo', array('height'=>80,'width'=>240,'flex-width'=>true));
    register_nav_menus(array('primary' => __('Primary Menu','unmnmnc')));
}

/* -------------------------
 * Register Custom Post Type: project
 * and taxonomy: project_category
 * ------------------------- */
add_action('init', 'unmnmnc_register_cpts');
function unmnmnc_register_cpts(){
    // Project CPT
    $labels = array(
        'name' => __('Projects','unmnmnc'),
        'singular_name' => __('Project','unmnmnc'),
        'add_new_item' => __('Add New Project','unmnmnc'),
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'show_in_rest' => true,
        'supports' => array('title','editor','thumbnail','excerpt'),
        'menu_position' => 5,
        'menu_icon' => 'dashicons-portfolio',
    );
    register_post_type('project', $args);

    // taxonomy
    register_taxonomy('project_category', 'project', array(
        'label' => __('Project Categories','unmnmnc'),
        'hierarchical' => true,
        'show_in_rest' => true,
    ));
}

/* -------------------------
 * Meta box for project: subtitle + gallery
 * ------------------------- */
add_action('add_meta_boxes', 'unmnmnc_add_meta_boxes');
function unmnmnc_add_meta_boxes(){
    add_meta_box('unmnmnc_project_meta', __('Project Details','unmnmnc'), 'unmnmnc_project_meta_callback', 'project', 'normal', 'high');
}

function unmnmnc_project_meta_callback($post){
    wp_nonce_field('unmnmnc_project_meta_nonce', 'unmnmnc_project_meta_nonce_field');

    $subtitle = get_post_meta($post->ID, 'unmnmnc_project_subtitle', true);
    $gallery = get_post_meta($post->ID, 'unmnmnc_project_gallery', true); // stored as comma separated attachment IDs
    ?>
    <p>
        <label for="unmnmnc_project_subtitle"><strong><?php esc_html_e('Subtitle','unmnmnc'); ?></strong></label><br/>
        <input type="text" id="unmnmnc_project_subtitle" name="unmnmnc_project_subtitle" value="<?php echo esc_attr($subtitle); ?>" style="width:100%;" />
    </p>

    <p>
        <label><strong><?php esc_html_e('Gallery Images','unmnmnc'); ?></strong></label><br/>
        <input type="hidden" id="unmnmnc_project_gallery" name="unmnmnc_project_gallery" value="<?php echo esc_attr($gallery); ?>" />
        <button type="button" class="button" id="unmnmnc_gallery_button"><?php esc_html_e('Select Images','unmnmnc'); ?></button>
        <div id="unmnmnc_gallery_preview" style="margin-top:10px;">
            <?php
            if(!empty($gallery)){
                $ids = array_filter( explode(',', $gallery) );
                foreach($ids as $id){
                    $src = wp_get_attachment_image_url($id,'thumbnail');
                    if($src) echo '<img src="'.esc_url($src).'" style="margin:5px;max-width:80px;">';
                }
            }
            ?>
        </div>
    </p>
    <?php
}

add_action('save_post', 'unmnmnc_save_project_meta');
function unmnmnc_save_project_meta($post_id){
    if( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return;
    if( !isset($_POST['unmnmnc_project_meta_nonce_field']) || !wp_verify_nonce($_POST['unmnmnc_project_meta_nonce_field'], 'unmnmnc_project_meta_nonce') ) return;
    if( !current_user_can('edit_post', $post_id) ) return;

    if( isset($_POST['unmnmnc_project_subtitle']) ){
        update_post_meta($post_id, 'unmnmnc_project_subtitle', sanitize_text_field($_POST['unmnmnc_project_subtitle']));
    } else {
        delete_post_meta($post_id, 'unmnmnc_project_subtitle');
    }

    if( isset($_POST['unmnmnc_project_gallery']) ){
        $ids = array_filter( array_map('intval', explode(',', $_POST['unmnmnc_project_gallery'])) );
        update_post_meta($post_id, 'unmnmnc_project_gallery', implode(',', $ids));
    } else {
        delete_post_meta($post_id, 'unmnmnc_project_gallery');
    }
}

/* -------------------------
 * Admin scripts for media uploader
 * ------------------------- */
add_action('admin_enqueue_scripts', 'unmnmnc_admin_enqueue');
function unmnmnc_admin_enqueue($hook){
    $screen = get_current_screen();
    if(!$screen) return;
    if( isset($screen->post_type) && $screen->post_type === 'project' ){
        wp_enqueue_media();
        wp_enqueue_script('unmnmnc-admin', get_template_directory_uri() . '/assets/js/admin.js', array('jquery'), '1.0', true);
    }
}

/* -------------------------
 * Shortcode: slider (shows projects)
 * usage: [unmnmnc_slider posts="6"]
 * ------------------------- */
add_shortcode('unmnmnc_slider', 'unmnmnc_slider_shortcode');
function unmnmnc_slider_shortcode($atts){
    $atts = shortcode_atts(array('posts' => 6), $atts, 'unmnmnc_slider');
    $q = new WP_Query(array(
        'post_type' => 'project',
        'posts_per_page' => intval($atts['posts']),
        'orderby' => 'date',
        'order' => 'DESC'
    ));
    if( !$q->have_posts() ) return '';
    $html = '<div class="unmnmnc-slider">';
    while( $q->have_posts() ): $q->the_post();
        $img = get_the_post_thumbnail_url(get_the_ID(), 'full');
        $subtitle = get_post_meta(get_the_ID(), 'unmnmnc_project_subtitle', true);
        $html .= '<div class="slide">';
        if($img) $html .= '<img src="'.esc_url($img).'" alt="'.esc_attr(get_the_title()).'" loading="lazy"/>';
        $html .= '<div class="slide-info"><h3>'.esc_html(get_the_title()).'</h3>';
        if($subtitle) $html .= '<p>'.esc_html($subtitle).'</p>';
        $html .= '</div></div>';
    endwhile; wp_reset_postdata();
    $html .= '</div>';
    return $html;
}

/* -------------------------
 * Shortcode: contact form
 * Processor uses admin-post.php with actions below
 * Shortcode: [unmnmnc_contact_form]
 * ------------------------- */
add_shortcode('unmnmnc_contact_form', 'unmnmnc_contact_form_shortcode');
function unmnmnc_contact_form_shortcode(){
    $out = '';
    if( isset($_GET['contact']) && $_GET['contact'] === 'success' ){
        $out .= '<div class="contact-success">'.esc_html__('Message sent. Thank you.','unmnmnc').'</div>';
    } elseif( isset($_GET['contact']) && $_GET['contact'] === 'error' ){
        $out .= '<div class="contact-error">'.esc_html__('Error sending message, please try again.','unmnmnc').'</div>';
    }
    $out .= '<form action="'.esc_url(admin_url('admin-post.php')).'" method="post" class="unmnmnc-contact-form">';
    $out .= '<input type="hidden" name="action" value="unmnmnc_contact">';
    $out .= wp_nonce_field('unmnmnc_contact_nonce','unmnmnc_contact_nonce', true, false);
    $out .= '<p><label>'.esc_html__('Name','unmnmnc').'<br/><input type="text" name="name" required></label></p>';
    $out .= '<p><label>'.esc_html__('Email','unmnmnc').'<br/><input type="email" name="email" required></label></p>';
    $out .= '<p><label>'.esc_html__('Message','unmnmnc').'<br/><textarea name="message" rows="6" required></textarea></label></p>';
    $out .= '<p><button type="submit">'.esc_html__('Send','unmnmnc').'</button></p>';
    $out .= '</form>';
    return $out;
}

/* Handler for contact form */
add_action('admin_post_nopriv_unmnmnc_contact', 'unmnmnc_handle_contact');
add_action('admin_post_unmnmnc_contact', 'unmnmnc_handle_contact');
function unmnmnc_handle_contact(){
    if( !isset($_POST['unmnmnc_contact_nonce']) || !wp_verify_nonce($_POST['unmnmnc_contact_nonce'], 'unmnmnc_contact_nonce') ){
        $redirect = wp_get_referer() ? add_query_arg('contact','error', wp_get_referer()) : add_query_arg('contact','error', home_url('/'));
        wp_safe_redirect($redirect);
        exit;
    }

    $name = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';
    $email = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
    $message = isset($_POST['message']) ? wp_kses_post($_POST['message']) : '';

    if( empty($name) || empty($email) || empty($message) ){
        $redirect = wp_get_referer() ? add_query_arg('contact','error', wp_get_referer()) : add_query_arg('contact','error', home_url('/'));
        wp_safe_redirect($redirect);
        exit;
    }

    $to = get_option('admin_email');
    $subject = sprintf( __('Contact form from %s','unmnmnc'), $name );
    $body = "Name: $name\nEmail: $email\n\nMessage:\n$message";
    $headers = array('Content-Type: text/plain; charset=UTF-8', 'From: '.get_bloginfo('name').' <'.$to.'>');

    $sent = wp_mail($to, $subject, $body, $headers);

    $redirect = wp_get_referer() ? add_query_arg('contact', $sent ? 'success' : 'error', wp_get_referer()) : add_query_arg('contact', $sent ? 'success' : 'error', home_url('/'));
    wp_safe_redirect($redirect);
    exit;
}

/* -------------------------
 * Other helpers (optional)
 * ------------------------- */
// You can add more helpers here (shortcodes, REST endpoints, etc.)