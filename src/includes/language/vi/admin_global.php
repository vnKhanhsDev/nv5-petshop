<?php

/**
 * NukeViet Content Management System
 * @version 5.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2025 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_MAINFILE')) {
    exit('Stop!!!');
}

$lang_translator['author'] = 'VINADES.,JSC <contact@vinades.vn>';
$lang_translator['createdate'] = '04/03/2010, 15:22';
$lang_translator['copyright'] = '@Copyright (C) 2009-2021 VINADES.,JSC. All rights reserved';
$lang_translator['info'] = '';
$lang_translator['langtype'] = 'lang_global';

$lang_global['mod_authors'] = 'Quản trị';
$lang_global['mod_groups'] = 'Nhóm người dùng';
$lang_global['mod_database'] = 'CSDL';
$lang_global['mod_settings'] = 'Cấu hình';
$lang_global['mod_cronjobs'] = 'Tiến trình tự động';
$lang_global['mod_modules'] = 'Quản lý Modules';
$lang_global['mod_themes'] = 'Quản lý giao diện';
$lang_global['mod_siteinfo'] = 'Thông tin';
$lang_global['mod_language'] = 'Ngôn ngữ, bản địa hóa';
$lang_global['mod_upload'] = 'Quản lý File';
$lang_global['mod_webtools'] = 'Công cụ web';
$lang_global['mod_seotools'] = 'Công cụ SEO';
$lang_global['mod_subsite'] = 'Quản lý site con';
$lang_global['mod_extensions'] = 'Mở rộng';
$lang_global['mod_zalo'] = 'Zalo';
$lang_global['mod_emailtemplates'] = 'Mẫu email';
$lang_global['go_clientsector'] = 'Trang chủ site';
$lang_global['go_clientmod'] = 'Xem ngoài site';
$lang_global['go_instrucion'] = 'Tài liệu hướng dẫn';
$lang_global['please_select'] = 'Hãy lựa chọn';
$lang_global['admin_password_empty'] = 'Mật khẩu quản trị của bạn chưa được khai báo';
$lang_global['adminpassincorrect'] = 'Mật khẩu quản trị &ldquo;<strong>%s</strong>&rdquo; không chính xác. Hãy thử lại lần nữa';
$lang_global['admin_password'] = 'Mật khẩu của bạn';
$lang_global['admin_no_allow_func'] = 'Bạn không có quyền truy cập chức năng này';
$lang_global['admin_suspend'] = 'Tài khoản bị đình chỉ';
$lang_global['block_modules'] = 'Block của modules';
$lang_global['hello_admin1'] = 'Đăng nhập trước: %1$s<br />Bằng IP: %2$s';
$lang_global['hello_admin2'] = 'Đăng nhập vào: %1$s<br />Bằng IP: %2$s';
$lang_global['ftp_error_account'] = 'Lỗi: hệ thống không kết nối được FTP server vui lòng kiểm tra lại các thông số FTP';
$lang_global['ftp_error_path'] = 'Lỗi: thông số Remote path không đúng';
$lang_global['login_error_account'] = 'Lỗi: Bí danh tài khoản quản trị chưa được khai báo hoặc khai báo không hợp lệ! (Không ít hơn %1$s ký tự, không nhiều hơn %2$s ký tự. Chỉ chứa các ký tự có trong bảng chữ cái latin, số và dấu gạch dưới)';
$lang_global['login_error_password'] = 'Lỗi: Password của Admin chưa được khai báo hoặc khai báo không hợp lệ! (Không ít hơn %1$s ký tự, không nhiều hơn %2$s ký tự. Chỉ chứa các ký tự có trong bảng chữ cái latin, số và dấu gạch dưới)';
$lang_global['login_error_security'] = 'Lỗi: Mã kiểm tra chưa được khai báo hoặc khai báo không hợp lệ! (Phải có %1$s ký tự. Chỉ chứa các ký tự có trong bảng chữ cái latin và số)';
$lang_global['error_zlib_support'] = 'Lỗi: Máy chủ của bạn không hỗ trợ thư viện zlib, bạn cần liên hệ với nhà cung cấp dịch vụ hosting bật thư viện zlib để có thể sử dụng tính năng này.';
$lang_global['error_zip_extension'] = 'Lỗi: Máy chủ của bạn không hỗ trợ extension ZIP, bạn cần liên hệ với nhà cung cấp dịch vụ hosting bật extension ZIP để có thể sử dụng tính năng này.';
$lang_global['length_characters'] = 'Số ký tự';
$lang_global['length_suggest_max'] = 'Nên nhập tối đa %s ký tự';
$lang_global['phone_note_title'] = 'Quy định khai báo số điện thoại';
$lang_global['phone_note_content'] = '<ul><li>Số điện thoại được chia ra hai phần, phần đầu là bắt buộc và dành cho việc hiển thị trên site, phần hai không bắt buộc và dành cho việc quay số khi click chuột vào nó.</li><li>Phần đầu được viết tự do nhưng không có dấu ngoặc vuông. Phần hai để trong dấu ngoặc vuông ngay sau phần đầu và chỉ được chứa các ký tự sau: chữ số, dấu sao, dấu thăng, dấu phẩy, dấu chấm, dấu chấm phẩy và dấu cộng ([0-9\*\#\.\,\;\+]).</li><li>Ví dụ, nếu bạn khai báo <strong>0438211725 (ext 601)</strong>, thì số <strong>0438211725 (ext 601)</strong> sẽ được hiển thị đơn thuần trên site. Còn nếu bạn khai báo <strong>0438211725 (ext 601)[+84438211725,601]</strong>, hệ thống sẽ cho hiển thị <strong>0438211725 (ext 601)</strong> trên site và url khi click chuột vào số điện thoại trên sẽ là <strong>tel:+84438211725,601</strong></li><li>Bạn có thể khai báo nhiều số điện thoại theo quy tắc trên. Chúng được phân cách bởi dấu |.</li></ul>';
$lang_global['phone_note_content2'] = '<ul><li>Số điện thoại được chia ra hai phần, phần đầu là bắt buộc và dành cho việc hiển thị trên site, phần hai không bắt buộc và dành cho việc quay số khi click chuột vào nó.</li><li>Phần đầu được viết tự do nhưng không có dấu ngoặc vuông. Phần hai để trong dấu ngoặc vuông ngay sau phần đầu và chỉ được chứa các ký tự sau: chữ số, dấu sao, dấu thăng, dấu phẩy, dấu chấm, dấu chấm phẩy và dấu cộng ([0-9\*\#\.\,\;\+]).</li><li>Ví dụ, nếu bạn khai báo <strong>0438211725 (ext 601)</strong>, thì số <strong>0438211725 (ext 601)</strong> sẽ được hiển thị đơn thuần trên site. Còn nếu bạn khai báo <strong>0438211725 (ext 601)[+84438211725,601]</strong>, hệ thống sẽ cho hiển thị <strong>0438211725 (ext 601)</strong> trên site và url khi click chuột vào số điện thoại trên sẽ là <strong>tel:+84438211725,601</strong></li></ul>';
$lang_global['multi_note'] = 'Có thể khai báo hơn 1 giá trị, được phân cách bởi dấu phẩy.';
$lang_global['multi_email_note'] = 'Có thể khai báo hơn 1 giá trị, được phân cách bởi dấu phẩy. Email đầu tiên được coi là email chính, được sử dụng để gửi, nhận thư.';
$lang_global['view_all'] = 'Xem tất cả';
$lang_global['email'] = 'Email';
$lang_global['phonenumber'] = 'Điện thoại';
$lang_global['admin_pre_logout'] = 'Không phải tôi, đăng xuất';
$lang_global['admin_hello_2step'] = 'Chào <strong class="admin-name">%s</strong>, mời bạn xác thực tài khoản';
$lang_global['admin_noopts_2step'] = 'Chưa có phương thức xác thực hai bước nào được cấp phép, tạm thời bạn không thể đăng nhập quản trị';
$lang_global['admin_mactive_2step'] = 'Bạn chưa thể xác thực vì chưa kích hoạt phương thức nào';
$lang_global['admin_mactive_2step_choose0'] = 'Mời bạn nhấp vào nút bên dưới để kích hoạt phương thức xác thực';
$lang_global['admin_mactive_2step_choose1'] = 'Mời bạn lựa chọn một trong các phương thức xác thực bên dưới';
$lang_global['admin_2step_opt_code'] = 'Mã xác nhận từ ứng dụng';
$lang_global['admin_2step_opt_facebook'] = 'Tài khoản Facebook';
$lang_global['admin_2step_opt_google'] = 'Tài khoản Google';
$lang_global['admin_2step_opt_zalo'] = 'Tài khoản Zalo';
$lang_global['admin_2step_opt_key'] = 'Khóa truy cập';
$lang_global['admin_setup_2fa_keycode'] = 'Ứng dụng 2FA hoặc khóa truy cập';
$lang_global['admin_2step_other'] = 'Phương thức xác thực khác';
$lang_global['admin_oauth_error_getdata'] = 'Lỗi: Hệ thống không nhận dạng được dữ liệu xác thực. Xác thực thất bại!';
$lang_global['admin_oauth_error_email'] = 'Lỗi: Email trả về không hợp lệ, bạn không thể xác thực';
$lang_global['admin_oauth_error_savenew'] = 'Lỗi: Không thể lưu thông tin xác thực';
$lang_global['admin_oauth_error'] = 'Lỗi: Xác minh không hợp lệ. Tài khoản này chưa được ủy quyền để xác minh';
$lang_global['acp'] = 'Quản lý site';
$lang_global['login_session_expire'] = 'Phiên đăng nhập hiện tại sẽ hết hạn sau';
$lang_global['account_settings'] = 'Thiết lập tài khoản';
$lang_global['your_admin_account'] = 'Tài khoản quản trị của bạn';
$lang_global['login_name'] = 'Tên đăng nhập';
$lang_global['login_name_type_username'] = 'Bí danh';
$lang_global['login_name_type_email'] = 'Email';
$lang_global['login_name_type_email_username'] = 'Bí danh hoặc Email';
$lang_global['interface_current_menu'] = 'Đang thao tác';
$lang_global['interface_other_menu'] = 'Các module khác';

$lang_global['merge_field_author_delete_time'] = 'Thời gian xóa';
$lang_global['merge_field_author_delete_reason'] = 'Lý do xóa';
$lang_global['merge_field_contact_link'] = 'Liên kết gửi liên hệ';
$lang_global['merge_field_is_suspend'] = 'Đình chỉ (1) hay kích hoạt lại (0)';
$lang_global['merge_field_time'] = 'Thời gian thực hiện';
$lang_global['merge_field_reason'] = 'Lý do thực hiện';
$lang_global['merge_field_sys_siteurl'] = 'Đường dẫn site trên url';
$lang_global['merge_field_sys_nv'] = 'Biến module';
$lang_global['merge_field_sys_op'] = 'Biến function các module';
$lang_global['merge_field_sys_langvar'] = 'Biến ngôn ngữ';
$lang_global['merge_field_sys_langdata'] = 'Khóa ngôn ngữ data';
$lang_global['merge_field_sys_langinterface'] = 'Khóa ngôn ngữ giao diện';
$lang_global['merge_field_sys_assetsdir'] = 'Thư mục thumb của hệ thống';
$lang_global['merge_field_sys_filesdir'] = 'Thư mục thumb của các module';
