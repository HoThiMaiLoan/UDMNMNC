# UNMNMNC - WordPress Theme (Demo)

## Mô tả
Theme demo tự viết cho mục tiêu học tập / project. Bao gồm:
- Front page (slider)
- Page templates: Trang Chủ, Blog, Liên hệ
- Custom Post Type: Project
- Custom taxonomy: Project Categories
- Meta box: subtitle + gallery (media uploader)
- Shortcodes: [unmnmnc_slider], [unmnmnc_contact_form], [unmnmnc-contact-info]
- Plugin tự viết: [unmnmnc-contact-info], [unmnmnc_contact_form]

Không dùng theme/plugin crack.

 Ẩn version PHP & WordPress.

 Chặn truy cập file nhạy cảm.

 Dùng plugin cache (W3 Total Cache).

 Bật Gzip nén nội dung.

 Tối ưu ảnh (Smush).

 Sử dụng WebP (WebP Express).

 Lazy load ảnh/video

Hướng dẫn nhanh:
1. Cài đặt plugin: Advanced Custom Fields (ACF), Contact Form 7.
2. Tạo Field Group (ACF, location: Options Page hoặc Front Page) với:
   - hero_title (text)
   - hero_description (textarea)
   - hero_background (image)
   - featured (checkbox on post) để đánh dấu bài nổi bật
3. Tạo menu Appearance -> Menus, gán vị trí Primary.
4. Upload theme vào `wp-content/themes/UDMNMNC` và kích hoạt.
5. Thêm widget vào Primary Sidebar.
6. Chỉnh form CF7, sửa ID trong page-contact.php nếu cần.