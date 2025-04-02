<?php

/**
 * NukeViet Content Management System
 * @version 5.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2025 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_IS_FILE_ADMIN')) {
    exit('Stop!!!');
}

$page_title = 'Thêm bài viết';



if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // xử lí hình ảnh
    $image_path = '';
    $upload = new NukeViet\Files\Upload(
            $admin_info['allow_files_type'], 
            $global_config['forbid_extensions'], 
            $global_config['forbid_mimes'], 
            NV_UPLOAD_MAX_FILESIZE, 
            NV_MAX_WIDTH, 
            NV_MAX_HEIGHT
        );

        // Thiết lập ngôn ngữ
        $upload->setLanguage($lang_global);

        // Xác định thư mục lưu ảnh
        $target_dir = NV_UPLOADS_REAL_DIR . '/' . $module_name . '/posts/';
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true); // Tạo thư mục nếu chưa có
        }

        // Tải file lên server
        $upload_info = $upload->save_file($_FILES['image'], $target_dir, false, $global_config['nv_auto_resize']);

        // Kiểm tra lỗi upload
        if (!empty($upload_info['error'])) {
            die('Lỗi upload file: ' . $upload_info['error']);
        } else {
            // Đường dẫn ảnh đã upload
            $image_path = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_name . '/posts/' . $upload_info['basename'];
        }
        

    $title = $_POST['title'] ?? '';
    $image = $image_path ?? '';
    $description = $_POST['description'] ?? ''; // Lấy dữ liệu mô tả ngắn
    $tags = $_POST['tags'] ?? ''; // Lấy dữ liệu tags
    $content = $_POST['content'] ?? '';
    $status = $_POST['status'] ?? 1;
    $created_at = time();
    $updated_at = time();

    if (!empty($title) && !empty($content)) {
        $stmt = $db->prepare('INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_posts 
            (title, description, image, tags, content, status, created_at, updated_at) 
            VALUES (:title, :description, :image, :tags, :content, :status, :created_at, :updated_at)');

        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':image', $image, PDO::PARAM_STR);
        $stmt->bindParam(':tags', $tags, PDO::PARAM_STR);
        $stmt->bindParam(':content', $content, PDO::PARAM_STR);
        $stmt->bindParam(':status', $status, PDO::PARAM_INT);
        $stmt->bindParam(':created_at', $created_at, PDO::PARAM_INT);
        $stmt->bindParam(':updated_at', $updated_at, PDO::PARAM_INT);

        if ($stmt->execute()) {
            header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA 
                . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&op=posts');
            exit();
        } else {
            echo 'Lỗi khi thêm bài viết.';
        }
    } else {
        echo 'Vui lòng nhập đầy đủ thông tin bắt buộc.';
    }
}

// Load giao diện add.tpl
$xtpl = new XTemplate('add.tpl', NV_ROOTDIR . '/themes/admin_default/modules/petshop/posts');

$xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
$xtpl->assign('SAVE_URL', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA 
. '&' . NV_NAME_VARIABLE . '=' . $module_name . '&op=posts/add');

$xtpl->parse('main');
$contents = $xtpl->text('main');

include (NV_ROOTDIR . "/includes/header.php");
echo nv_admin_theme($contents);
include (NV_ROOTDIR . "/includes/footer.php");