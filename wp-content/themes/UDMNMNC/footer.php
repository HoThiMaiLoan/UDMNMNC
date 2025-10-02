<footer class="site-footer">
    <div class="footer-container">
        <div class="footer-col">
            <h3><?php _e('🌸 Yêu Hoa', 'unmnmnc'); ?></h3>
            <p><?php echo esc_html(get_theme_mod('yeuhoa_footer_about')); ?></p>
        </div>
        <div class="footer-col">
            <h3><?php _e('Liên Hệ', 'unmnmnc'); ?></h3>
            <p>📍 <?php echo esc_html(get_theme_mod('yeuhoa_footer_address')); ?></p>
            <p>📞 <?php echo esc_html(get_theme_mod('yeuhoa_footer_phone')); ?></p>
            <p>📧 <?php echo esc_html(get_theme_mod('yeuhoa_footer_email')); ?></p>
        </div>
        <div class="footer-col">
            <h3><?php _e('Kết Nối', 'unmnmnc'); ?></h3>
            <p>
                <a href="<?php echo esc_url(get_theme_mod('yeuhoa_footer_facebook')); ?>" target="_blank">Facebook</a> | 
                <a href="<?php echo esc_url(get_theme_mod('yeuhoa_footer_instagram')); ?>" target="_blank">Instagram</a> | 
                <a href="<?php echo esc_url(get_theme_mod('yeuhoa_footer_youtube')); ?>" target="_blank">YouTube</a>
            </p>
        </div>
    </div>
    <div class="footer-bottom">
        <p>© <?php echo date('Y'); ?> <?php _e('Yêu Hoa. All rights reserved', 'unmnmnc'); ?></p>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
