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

global $db, $module_name, $module_file, $lang_module, $nv_Request, $nv_Lang, $global_config;

$page_title = isset($nv_Lang) ? $nv_Lang->getModule('Danh sách bài viết') : 'Danh sách bài viết';  // Check if $nv_Lang is initialized
$base_url = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=posts';

// Lấy tổng số bài viết
try {
    $sql = 'SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_petshop_posts';
    $total_rows = $db->query($sql)->fetchColumn();
} catch (PDOException $e) {
    die("Lỗi kết nối cơ sở dữ liệu: " . $e->getMessage());
}

// Số bài viết hiển thị trên một trang
$per_page = 10;
$page = $nv_Request->get_int('page', 'get', 1);
$offset = ($page - 1) * $per_page;

// Tạo URL phân trang
$generate_page = nv_generate_page($base_url, $total_rows, $per_page, $page);

// Truy vấn danh sách bài viết có phân trang
try {
    $sql = 'SELECT id, title, description, image, content, views, likes, tags, status, updated_at, created_at FROM ' . NV_PREFIXLANG . '_petshop_posts ORDER BY id DESC LIMIT ' . $offset . ', ' . $per_page;
    $stmt = $db->prepare($sql);
    $stmt->execute();
} catch (PDOException $e) {
    die("Lỗi khi truy vấn cơ sở dữ liệu: " . $e->getMessage());
}

$posts = [];
while ($row = $stmt->fetch()) {
    $row['created_at'] = date('d/m/Y H:i', $row['created_at']);
    $row['status_text'] = ($row['status'] == 1) ? 'Hiển thị' : 'Ẩn';
    $row['url_add'] = $base_url . '&op=posts/add';
    $row['url_detail'] = $base_url . '&op=posts/detail&id=' . $row['id'];
    $row['url_edit'] = $base_url . '&op=posts/edit&id=' . $row['id'];
    $row['url_delete'] = $base_url . '&op=posts/delete&id=' . $row['id'];
    $posts[] = $row;
}

// Khởi tạo template
try {
    $xtpl = new XTemplate('posts.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
} catch (Exception $e) {
    die("Lỗi khi khởi tạo template: " . $e->getMessage());
}

$xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
$xtpl->assign('GLANG', \NukeViet\Core\Language::$lang_global);
$xtpl->assign('ADD_URL', $base_url . '/add');

if (!empty($posts)) {
    foreach ($posts as $post) {
        $xtpl->assign('POST', $post);
        $xtpl->parse('main.loop');
    }
    $xtpl->assign('GENERATE_PAGE', $generate_page);
    $xtpl->parse('main');
    $contents = $xtpl->text('main');
} else {
    $contents = "Không có bài viết nào";
}

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
