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

$page_title = 'Sửa thông tin bài viết';

$post_id = $_GET['id'] ?? 0;

if ($post_id > 0) {
    // Lấy thông tin bài viết từ database
    $stmt = $db->prepare('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_posts WHERE id = :id');
    $stmt->bindParam(':id', $post_id, PDO::PARAM_INT);
    $stmt->execute();
    $post = $stmt->fetch();

    if (!$post) {
        die('Bài viết không tồn tại.');
    }
} else {
    die('ID bài viết không hợp lệ.');
}

// Nếu người dùng submit form (POST request)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $status = intval($_POST['status']);

    if ($title == '' || $content == '') {
        die('Dữ liệu không hợp lệ.');
    }

    // Cập nhật bài viết vào database
    $stmt = $db->prepare('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_posts 
        SET title = :title, content = :content, status = :status 
        WHERE id = :id');

    $stmt->bindParam(':title', $title, PDO::PARAM_STR);
    $stmt->bindParam(':content', $content, PDO::PARAM_STR);
    $stmt->bindParam(':status', $status, PDO::PARAM_INT);
    $stmt->bindParam(':id', $post_id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA 
            . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&op=posts');
        exit();
    } else {
        echo 'Lỗi khi cập nhật bài viết.';
    }
}

// Load template
$xtpl = new XTemplate('edit.tpl', NV_ROOTDIR . '/themes/admin_default/modules/petshop/');
$xtpl->assign('POST', $post);
$xtpl->assign('SAVE_URL', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA 
    . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&op=posts/edit&id=' . $post_id);
$xtpl->parse('edit');
$contents = $xtpl->text('edit');


include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
