# UNMNMNC - WordPress Theme (Demo)

## Mô tả
Theme demo tự viết cho mục tiêu học tập / project. Bao gồm:
- Front page (slider)
- Page templates: Trang Chủ, Blog, Liên hệ
- Custom Post Type: Project
- Custom taxonomy: Project Categories
- Meta box: subtitle + gallery (media uploader)
- Shortcodes: [unmnmnc_slider], [unmnmnc_contact_form]

## Hướng dẫn cài đặt
1. Copy folder `UNMNMNC` vào `wp-content/themes/`.
2. Active theme trong Appearance -> Themes.
3. Tạo một vài Project (Projects -> Add New), thiết lập featured image và gallery.
4. Tạo page "Home" (không cần chọn template nếu muốn front-page.php), page "Blog" -> chọn template "Blog" (Page Attributes), page "Contact" -> chọn template "Contact".
5. Trong Settings -> Reading, nếu bạn muốn Home tĩnh, set "Your homepage displays" -> A static page -> Homepage: Home.
6. Kiểm tra Contact page, gửi thử (WP cần cấu hình gửi mail trên server để wp_mail hoạt động; nếu local, dùng plugin như WP Mail SMTP).

## Lưu ý bảo mật & tối ưu
- Không push vào repo các file chứa credentials.
- Bật `DISALLOW_FILE_EDIT` trong wp-config.php khi deploy.
- Dùng caching plugin & CDN khi lên production.